<?php

namespace App\Models;

use App\Core\Database;

class User
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * 이메일로 로그인
     */
    public function login(string $email, string $password): ?array
    {
        $sql = "SELECT * FROM users WHERE email = ? AND status = 1";
        $user = $this->db->fetchOne($sql, [$email]);

        if ($user && password_verify($password, $user['password'])) {
            // 마지막 로그인 시간 업데이트
            $this->updateLastLogin($user['id']);

            // 비밀번호 정보는 제거
            unset($user['password']);

            return $user;
        }

        return null;
    }

    /**
     * ID로 사용자 조회
     */
    public function findById(int $id): ?array
    {
        $sql = "SELECT * FROM users WHERE id = ? AND status = 1";
        $user = $this->db->fetchOne($sql, [$id]);

        if ($user) {
            unset($user['password']);
        }

        return $user;
    }

    /**
     * 이메일로 조회
     */
    public function findByEmail(string $email): ?array
    {
        $sql = "SELECT * FROM users WHERE email = ?";
        return $this->db->fetchOne($sql, [$email]);
    }

    /**
     * 전체 사용자 목록
     */
    public function getAll(int $limit = 100, int $offset = 0): array
    {
        $sql = "SELECT id, email, nickname, is_admin, status, created_at, last_login
                FROM users
                ORDER BY created_at DESC
                LIMIT ? OFFSET ?";
        return $this->db->fetchAll($sql, [$limit, $offset]);
    }

    /**
     * 사용자 수 조회
     */
    public function count(): int
    {
        $sql = "SELECT COUNT(*) as count FROM users";
        $result = $this->db->fetchOne($sql);
        return (int)($result['count'] ?? 0);
    }

    /**
     * 사용자 생성
     */
    public function create(array $data): bool
    {
        // 이메일 중복 체크
        if ($this->findByEmail($data['email'])) {
            return false;
        }

        // 닉네임이 없으면 자동 생성
        if (empty($data['nickname'])) {
            $data['nickname'] = $this->generateUniqueNickname();
        } else {
            // 닉네임 중복 체크
            if ($this->findByNickname($data['nickname'])) {
                return false;
            }
        }

        $sql = "INSERT INTO users (email, password, nickname, is_admin, status)
                VALUES (?, ?, ?, ?, ?)";

        $params = [
            $data['email'],
            password_hash($data['password'], PASSWORD_BCRYPT),
            $data['nickname'],
            $data['is_admin'] ?? 0,
            $data['status'] ?? 1
        ];

        return $this->db->execute($sql, $params);
    }

    /**
     * 닉네임으로 조회
     */
    public function findByNickname(string $nickname): ?array
    {
        $sql = "SELECT * FROM users WHERE nickname = ?";
        return $this->db->fetchOne($sql, [$nickname]);
    }

    /**
     * 유일한 닉네임 자동 생성 (형용사+형용사+명사)
     */
    private function generateUniqueNickname(): string
    {
        $adjectives = [
            '밝은', '행복한', '즐거운', '귀여운', '멋진', '아름다운', '사랑스러운', '용감한',
            '친절한', '상냥한', '따뜻한', '차분한', '활발한', '조용한', '똑똑한', '재미있는',
            '신나는', '평화로운', '강한', '부드러운', '빠른', '느긋한', '튼튼한', '가벼운',
            '싱그러운', '화사한', '청순한', '당당한', '씩씩한', '영리한', '깜찍한', '반짝이는'
        ];

        $nouns = [
            '호랑이', '토끼', '사자', '고양이', '강아지', '팬더', '다람쥐',
            '펭귄', '돌고래', '나비', '새', '독수리', '부엉이', '까치', '참새',
            '꽃', '나무', '구름', '별', '무지개', '이슬', '햇살', '달빛',
            '달', '태양', '바람', '물결', '파도', '노을', '안개', '눈송이',
            '산', '강', '바다', '하늘', '숲', '들판', '호수', '계곡',
            '사슴', '여우', '거북이', '기린', '코끼리', '치타', '표범'
        ];

        $maxAttempts = 100;
        for ($i = 0; $i < $maxAttempts; $i++) {
            $adj1 = $adjectives[array_rand($adjectives)];
            $adj2 = $adjectives[array_rand($adjectives)];
            $noun = $nouns[array_rand($nouns)];

            $nickname = $adj1 . $adj2 . $noun;

            // 중복 체크
            if (!$this->findByNickname($nickname)) {
                return $nickname;
            }

            // 중복이면 숫자 추가
            $nickname = $adj1 . $adj2 . $noun . rand(1, 9999);
            if (!$this->findByNickname($nickname)) {
                return $nickname;
            }
        }

        // 최악의 경우 타임스탬프 사용
        return '사용자' . time();
    }

    /**
     * 사용자 정보 수정
     */
    public function update(int $id, array $data): bool
    {
        $fields = [];
        $params = [];

        if (isset($data['email'])) {
            $fields[] = "email = ?";
            $params[] = $data['email'];
        }

        if (isset($data['nickname'])) {
            $fields[] = "nickname = ?";
            $params[] = $data['nickname'];
        }

        if (isset($data['password'])) {
            $fields[] = "password = ?";
            $params[] = password_hash($data['password'], PASSWORD_BCRYPT);
        }

        if (isset($data['is_admin'])) {
            $fields[] = "is_admin = ?";
            $params[] = $data['is_admin'];
        }

        if (isset($data['status'])) {
            $fields[] = "status = ?";
            $params[] = $data['status'];
        }

        if (empty($fields)) {
            return false;
        }

        $params[] = $id;
        $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = ?";

        return $this->db->execute($sql, $params);
    }

    /**
     * 사용자 삭제 (soft delete)
     */
    public function delete(int $id): bool
    {
        $sql = "UPDATE users SET status = 0 WHERE id = ?";
        return $this->db->execute($sql, [$id]);
    }

    /**
     * 사용자 완전 삭제
     */
    public function forceDelete(int $id): bool
    {
        $sql = "DELETE FROM users WHERE id = ?";
        return $this->db->execute($sql, [$id]);
    }

    /**
     * 마지막 로그인 시간 업데이트
     */
    public function updateLastLogin(int $id): bool
    {
        $sql = "UPDATE users SET last_login = NOW() WHERE id = ?";
        return $this->db->execute($sql, [$id]);
    }

    /**
     * 비밀번호 변경
     */
    public function changePassword(int $id, string $newPassword): bool
    {
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        return $this->db->execute($sql, [password_hash($newPassword, PASSWORD_BCRYPT), $id]);
    }

    /**
     * 사용자 검색
     */
    public function search(string $keyword, int $limit = 20, int $offset = 0): array
    {
        $sql = "SELECT id, email, nickname, is_admin, status, created_at
                FROM users
                WHERE email LIKE ? OR nickname LIKE ?
                ORDER BY created_at DESC
                LIMIT ? OFFSET ?";

        $searchTerm = "%{$keyword}%";
        return $this->db->fetchAll($sql, [$searchTerm, $searchTerm, $limit, $offset]);
    }
}
