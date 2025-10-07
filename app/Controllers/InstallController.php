<?php

namespace App\Controllers;

use App\Core\Helper;

class InstallController
{
    /**
     * 설치 페이지 표시
     */
    public function index(): void
    {
        // 이미 설치되어 있는지 확인
        if ($this->isInstalled()) {
            Helper::flash('error', '이미 설치가 완료되었습니다.');
            Helper::redirect('/');
        }

        Helper::view('install/index');
    }

    /**
     * 설치 처리
     */
    public function install(): void
    {
        if ($this->isInstalled()) {
            Helper::flash('error', '이미 설치가 완료되었습니다.');
            Helper::redirect('/');
        }

        // 라이센스 동의 확인
        if (empty($_POST['agree_license'])) {
            Helper::flash('error', '라이센스에 동의해야 설치를 진행할 수 있습니다.');
            Helper::redirect('/install');
        }

        // 입력값 받기
        $dbHost = $_POST['db_host'] ?? 'localhost';
        $dbName = $_POST['db_name'] ?? 'cafe24';
        $dbUser = $_POST['db_user'] ?? 'root';
        $dbPass = $_POST['db_password'] ?? '';
        $adminEmail = $_POST['admin_email'] ?? '';
        $adminPassword = $_POST['admin_password'] ?? '';
        $adminName = $_POST['admin_name'] ?? '관리자';
        $overwrite = !empty($_POST['overwrite_data']);

        // 입력값 검증
        if (empty($dbHost) || empty($dbName) || empty($dbUser)) {
            Helper::flash('error', '데이터베이스 정보를 모두 입력해주세요.');
            Helper::redirect('/install');
        }

        if (empty($adminEmail) || empty($adminPassword)) {
            Helper::flash('error', '관리자 이메일과 비밀번호를 입력해주세요.');
            Helper::redirect('/install');
        }

        if (!filter_var($adminEmail, FILTER_VALIDATE_EMAIL)) {
            Helper::flash('error', '올바른 이메일 형식을 입력해주세요.');
            Helper::redirect('/install');
        }

        if (strlen($adminPassword) < 6) {
            Helper::flash('error', '비밀번호는 최소 6자 이상이어야 합니다.');
            Helper::redirect('/install');
        }

        try {
            // 데이터베이스 연결 테스트
            $pdo = new \PDO(
                "mysql:host={$dbHost};charset=utf8mb4",
                $dbUser,
                $dbPass,
                [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
                ]
            );

            // 데이터베이스 생성 (존재하지 않는 경우)
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$dbName}` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            $pdo->exec("USE `{$dbName}`");

            // 스키마 파일 읽기
            $schemaPath = BASE_PATH . '/app/Install/schema.sql';
            if (!file_exists($schemaPath)) {
                throw new \Exception('스키마 파일을 찾을 수 없습니다.');
            }

            $schema = file_get_contents($schemaPath);

            // 덮어쓰기 옵션에 따라 처리
            if (!$overwrite) {
                // 관리자 이메일 중복 확인
                $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM users WHERE email = ? AND is_admin = 1");
                $stmt->execute([$adminEmail]);
                $result = $stmt->fetch();

                if ($result && $result['count'] > 0) {
                    Helper::flash('error', '이미 동일한 이메일의 관리자 계정이 존재합니다. 덮어쓰기를 선택하거나 다른 이메일을 사용해주세요.');
                    Helper::redirect('/install');
                }
            } else {
                // 덮어쓰기: 기존 테이블 삭제
                $pdo->exec("DROP TABLE IF EXISTS sessions");
                $pdo->exec("DROP TABLE IF EXISTS plugins");
                $pdo->exec("DROP TABLE IF EXISTS attachments");
                $pdo->exec("DROP TABLE IF EXISTS comments");
                $pdo->exec("DROP TABLE IF EXISTS posts");
                $pdo->exec("DROP TABLE IF EXISTS boards");
                $pdo->exec("DROP TABLE IF EXISTS contents");
                $pdo->exec("DROP TABLE IF EXISTS configs");
                $pdo->exec("DROP TABLE IF EXISTS users");
            }

            // 스키마 실행
            $statements = array_filter(
                array_map('trim', explode(';', $schema)),
                fn($stmt) => !empty($stmt) && !preg_match('/^--/', $stmt)
            );

            foreach ($statements as $statement) {
                if (trim($statement)) {
                    $pdo->exec($statement);
                }
            }

            // 기본 관리자 계정 삭제 후 새 관리자 생성
            $pdo->exec("DELETE FROM users WHERE email = 'admin@example.com'");

            $hashedPassword = password_hash($adminPassword, PASSWORD_BCRYPT);
            $stmt = $pdo->prepare("INSERT INTO users (email, password, name, is_admin, status) VALUES (?, ?, ?, 1, 1)");
            $stmt->execute([$adminEmail, $hashedPassword, $adminName]);

            // database.php 파일 생성
            $configContent = "<?php\n\nreturn [\n";
            $configContent .= "    'host' => '{$dbHost}',\n";
            $configContent .= "    'database' => '{$dbName}',\n";
            $configContent .= "    'username' => '{$dbUser}',\n";
            $configContent .= "    'password' => '{$dbPass}',\n";
            $configContent .= "    'charset' => 'utf8mb4',\n";
            $configContent .= "    'collation' => 'utf8mb4_unicode_ci',\n";
            $configContent .= "];\n";

            $configPath = BASE_PATH . '/data/config/database.php';
            if (!is_dir(dirname($configPath))) {
                mkdir(dirname($configPath), 0755, true);
            }

            if (file_put_contents($configPath, $configContent) === false) {
                throw new \Exception('설정 파일 생성에 실패했습니다. data/config 폴더에 쓰기 권한이 있는지 확인해주세요.');
            }

            Helper::flash('success', '설치가 완료되었습니다! 관리자 계정으로 로그인하세요.');
            Helper::redirect('/admin/login');

        } catch (\PDOException $e) {
            Helper::flash('error', 'DB 연결 오류: ' . $e->getMessage());
            Helper::redirect('/install');
        } catch (\Exception $e) {
            Helper::flash('error', '설치 오류: ' . $e->getMessage());
            Helper::redirect('/install');
        }
    }

    /**
     * 설치 여부 확인
     */
    private function isInstalled(): bool
    {
        $configPath = BASE_PATH . '/data/config/database.php';
        return file_exists($configPath);
    }
}
