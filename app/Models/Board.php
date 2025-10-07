<?php

namespace App\Models;

use App\Core\Database;

class Board
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * 이름으로 게시판 조회
     */
    public function findByName(string $name): ?array
    {
        $sql = "SELECT * FROM boards WHERE name = ? AND status = 1";
        return $this->db->fetchOne($sql, [$name]);
    }

    /**
     * ID로 게시판 조회
     */
    public function findById(int $id): ?array
    {
        $sql = "SELECT * FROM boards WHERE id = ? AND status = 1";
        return $this->db->fetchOne($sql, [$id]);
    }

    /**
     * 전체 게시판 목록
     */
    public function getAll(): array
    {
        $sql = "SELECT * FROM boards WHERE status = 1 ORDER BY order_num ASC, id ASC";
        return $this->db->fetchAll($sql);
    }

    /**
     * 게시판 생성
     */
    public function create(array $data): bool
    {
        $sql = "INSERT INTO boards (name, title, description, use_comments, use_files, write_level, read_level, list_level, order_num, status)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $params = [
            $data['name'],
            $data['title'],
            $data['description'] ?? null,
            $data['use_comments'] ?? 1,
            $data['use_files'] ?? 1,
            $data['write_level'] ?? 0,
            $data['read_level'] ?? 0,
            $data['list_level'] ?? 0,
            $data['order_num'] ?? 0,
            $data['status'] ?? 1
        ];

        return $this->db->execute($sql, $params);
    }

    /**
     * 게시판 수정
     */
    public function update(int $id, array $data): bool
    {
        $fields = [];
        $params = [];

        $allowedFields = ['title', 'description', 'use_comments', 'use_files',
                         'write_level', 'read_level', 'list_level', 'order_num', 'status'];

        foreach ($allowedFields as $field) {
            if (isset($data[$field])) {
                $fields[] = "$field = ?";
                $params[] = $data[$field];
            }
        }

        if (empty($fields)) {
            return false;
        }

        $params[] = $id;
        $sql = "UPDATE boards SET " . implode(', ', $fields) . " WHERE id = ?";

        return $this->db->execute($sql, $params);
    }

    /**
     * 게시판 삭제
     */
    public function delete(int $id): bool
    {
        $sql = "UPDATE boards SET status = 0 WHERE id = ?";
        return $this->db->execute($sql, [$id]);
    }

    /**
     * 게시판의 게시글 수
     */
    public function getPostCount(int $boardId): int
    {
        $sql = "SELECT COUNT(*) as count FROM posts WHERE board_id = ? AND status = 'active'";
        $result = $this->db->fetchOne($sql, [$boardId]);
        return (int)($result['count'] ?? 0);
    }
}
