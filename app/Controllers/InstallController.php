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
            echo '<h1>이미 설치가 완료되었습니다</h1>';
            echo '<p>data/config/database.php 파일을 삭제하면 재설치할 수 있습니다.</p>';
            echo '<a href="/">홈으로 이동</a>';
            exit;
        }

        // URL 파라미터로 전달된 에러 메시지
        $error = $_GET['error'] ?? null;
        $success = $_GET['success'] ?? null;

        // 이전 입력값 가져오기 (세션에서)
        $oldInput = $_SESSION['_old_input'] ?? [];
        unset($_SESSION['_old_input']);

        Helper::view('install/index', compact('error', 'success', 'oldInput'));
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
            $this->redirectWithError('라이센스에 동의해야 설치를 진행할 수 있습니다.');
        }

        // 입력값 받기
        $dbHost = $_POST['db_host'] ?? 'localhost';
        $dbName = $_POST['db_name'] ?? 'haru';
        $dbUser = $_POST['db_user'] ?? 'root';
        $dbPass = $_POST['db_password'] ?? '';
        $adminEmail = $_POST['admin_email'] ?? '';
        $adminPassword = $_POST['admin_password'] ?? '';
        $adminName = $_POST['admin_name'] ?? '관리자';
        $overwrite = !empty($_POST['overwrite_data']);

        // 입력값 검증
        if (empty($dbHost) || empty($dbName) || empty($dbUser)) {
            $this->redirectWithError('데이터베이스 정보를 모두 입력해주세요.');
        }

        if (empty($adminEmail) || empty($adminPassword)) {
            $this->redirectWithError('관리자 이메일과 비밀번호를 입력해주세요.');
        }

        if (!filter_var($adminEmail, FILTER_VALIDATE_EMAIL)) {
            $this->redirectWithError('올바른 이메일 형식을 입력해주세요.');
        }

        if (strlen($adminPassword) < 6) {
            $this->redirectWithError('비밀번호는 최소 6자 이상이어야 합니다.');
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

            // users 테이블이 존재하는지 확인
            $tablesResult = $pdo->query("SHOW TABLES LIKE 'users'");
            $usersTableExists = $tablesResult->rowCount() > 0;

            // 덮어쓰기 옵션에 따라 처리
            if ($overwrite) {
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
                $usersTableExists = false;
            } elseif ($usersTableExists) {
                // 덮어쓰기 안함 + 테이블 존재: 관리자 이메일 중복 확인
                $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM users WHERE email = ? AND is_admin = 1");
                $stmt->execute([$adminEmail]);
                $result = $stmt->fetch();

                if ($result && $result['count'] > 0) {
                    $this->redirectWithError('이미 동일한 이메일의 관리자 계정이 존재합니다. 덮어쓰기를 선택하거나 다른 이메일을 사용해주세요.');
                }
            }

            // 스키마 실행 (테이블이 없거나 덮어쓰기인 경우)
            if (!$usersTableExists || $overwrite) {
                // 주석 제거
                $schemaClean = preg_replace('/^--.*$/m', '', $schema);
                $statements = explode(';', $schemaClean);
                $executedCount = 0;
                $errors = [];
                $debugInfo = [];

                foreach ($statements as $index => $statement) {
                    $statement = trim($statement);

                    // 빈 문자열 스킵
                    if (empty($statement)) {
                        continue;
                    }

                    $debugInfo[] = "Statement $index: " . substr($statement, 0, 50) . '...';

                    try {
                        $pdo->exec($statement);
                        $executedCount++;
                    } catch (\PDOException $e) {
                        // INSERT 실패는 경고만 (중복 키 등)
                        if (stripos($statement, 'INSERT') !== false) {
                            $errors[] = "Warning [Line $index]: " . $e->getMessage();
                        } else {
                            // CREATE/ALTER 등 실패는 치명적 에러
                            throw new \Exception('스키마 실행 오류 (Statement ' . $index . '): ' . $e->getMessage() .
                                '<br><br>실패한 SQL:<br><code style="background:#f5f5f5;padding:10px;display:block;overflow:auto;white-space:pre-wrap;">' .
                                htmlspecialchars(substr($statement, 0, 500)) . '</code>');
                        }
                    }
                }

                // 스키마 실행 확인
                if ($executedCount < 5) {
                    throw new \Exception('스키마 실행이 불완전합니다. 실행된 SQL: ' . $executedCount . '개<br>' .
                        '에러: ' . implode('<br>', $errors) . '<br><br>' .
                        '디버그 정보:<br>' . implode('<br>', array_slice($debugInfo, 0, 10)));
                }
            }

            // users 테이블이 존재하는지 다시 확인
            $tablesCheck = $pdo->query("SHOW TABLES LIKE 'users'");
            if ($tablesCheck->rowCount() === 0) {
                throw new \Exception('users 테이블 생성에 실패했습니다. 스키마 파일을 확인해주세요.');
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

            $this->redirectWithSuccess('설치가 완료되었습니다! 관리자 계정으로 로그인하세요.', '/admin/login');

        } catch (\PDOException $e) {
            $this->redirectWithError('DB 연결 오류: ' . $e->getMessage() . '<br><br>상세 정보:<br>' .
                '호스트: ' . $dbHost . '<br>' .
                '데이터베이스: ' . $dbName . '<br>' .
                '사용자: ' . $dbUser);
        } catch (\Exception $e) {
            $this->redirectWithError('설치 오류: ' . $e->getMessage());
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

    /**
     * 에러 메시지와 함께 리다이렉트
     */
    private function redirectWithError(string $message): void
    {
        // 입력값 세션에 저장
        $_SESSION['_old_input'] = $_POST;

        header('Location: /install?error=' . urlencode($message));
        exit;
    }

    /**
     * 성공 메시지와 함께 리다이렉트
     */
    private function redirectWithSuccess(string $message, string $url = '/install'): void
    {
        header('Location: ' . $url . '?success=' . urlencode($message));
        exit;
    }
}
