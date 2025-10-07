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
        $sql = "SELECT id, email, name, is_admin, status, created_at, last_login
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

        $sql = "INSERT INTO users (email, password, name, is_admin, status)
                VALUES (?, ?, ?, ?, ?)";

        $params = [
            $data['email'],
            password_hash($data['password'], PASSWORD_BCRYPT),
            $data['name'] ?? null,
            $data['is_admin'] ?? 0,
            $data['status'] ?? 1
        ];

        return $this->db->execute($sql, $params);
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

        if (isset($data['name'])) {
            $fields[] = "name = ?";
            $params[] = $data['name'];
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
        $sql = "SELECT id, email, name, is_admin, status, created_at
                FROM users
                WHERE email LIKE ? OR name LIKE ?
                ORDER BY created_at DESC
                LIMIT ? OFFSET ?";

        $searchTerm = "%{$keyword}%";
        return $this->db->fetchAll($sql, [$searchTerm, $searchTerm, $limit, $offset]);
    }
}
