<?php

namespace App\Models;

use App\Core\Database;

class Comment
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * 게시글의 댓글 목록
     */
    public function getByPostId(int $postId): array
    {
        $sql = "SELECT c.*, u.username, u.name as author_name
                FROM comments c
                LEFT JOIN users u ON c.user_id = u.id
                WHERE c.post_id = ? AND c.status = 'active'
                ORDER BY c.created_at ASC";

        return $this->db->fetchAll($sql, [$postId]);
    }

    /**
     * 댓글 수 조회
     */
    public function countByPostId(int $postId): int
    {
        $sql = "SELECT COUNT(*) as count FROM comments WHERE post_id = ? AND status = 'active'";
        $result = $this->db->fetchOne($sql, [$postId]);
        return (int)($result['count'] ?? 0);
    }

    /**
     * ID로 댓글 조회
     */
    public function findById(int $id): ?array
    {
        $sql = "SELECT c.*, u.username
                FROM comments c
                LEFT JOIN users u ON c.user_id = u.id
                WHERE c.id = ?";

        return $this->db->fetchOne($sql, [$id]);
    }

    /**
     * 댓글 작성
     */
    public function create(array $data): int
    {
        $sql = "INSERT INTO comments (post_id, user_id, content, status)
                VALUES (?, ?, ?, 'active')";

        $params = [
            $data['post_id'],
            $data['user_id'] ?? null,
            $data['content']
        ];

        $this->db->execute($sql, $params);
        return (int)$this->db->lastInsertId();
    }

    /**
     * 댓글 수정
     */
    public function update(int $id, string $content): bool
    {
        $sql = "UPDATE comments SET content = ? WHERE id = ?";
        return $this->db->execute($sql, [$content, $id]);
    }

    /**
     * 댓글 삭제
     */
    public function delete(int $id): bool
    {
        $sql = "UPDATE comments SET status = 'deleted' WHERE id = ?";
        return $this->db->execute($sql, [$id]);
    }

    /**
     * 사용자의 댓글 수
     */
    public function countByUser(int $userId): int
    {
        $sql = "SELECT COUNT(*) as count FROM comments WHERE user_id = ? AND status = 'active'";
        $result = $this->db->fetchOne($sql, [$userId]);
        return (int)($result['count'] ?? 0);
    }

    /**
     * 최근 댓글 목록
     */
    public function getRecent(int $limit = 10): array
    {
        $sql = "SELECT c.*, u.username, u.name as author_name, p.title as post_title
                FROM comments c
                LEFT JOIN users u ON c.user_id = u.id
                LEFT JOIN posts p ON c.post_id = p.id
                WHERE c.status = 'active'
                ORDER BY c.created_at DESC
                LIMIT ?";

        return $this->db->fetchAll($sql, [$limit]);
    }
}
