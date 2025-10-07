<?php

namespace App\Models;

use App\Core\Database;

class Post
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * 게시글 목록 조회
     */
    public function getList(int $boardId, int $limit = 20, int $offset = 0): array
    {
        $sql = "SELECT p.*, u.username, u.name as author_name
                FROM posts p
                LEFT JOIN users u ON p.user_id = u.id
                WHERE p.board_id = ? AND p.status = 'active'
                ORDER BY p.is_notice DESC, p.created_at DESC
                LIMIT ? OFFSET ?";

        return $this->db->fetchAll($sql, [$boardId, $limit, $offset]);
    }

    /**
     * 게시글 수 조회
     */
    public function count(int $boardId): int
    {
        $sql = "SELECT COUNT(*) as count FROM posts WHERE board_id = ? AND status = 'active'";
        $result = $this->db->fetchOne($sql, [$boardId]);
        return (int)($result['count'] ?? 0);
    }

    /**
     * 게시글 상세 조회
     */
    public function findById(int $id): ?array
    {
        $sql = "SELECT p.*, u.username, u.name as author_name, b.name as board_name, b.title as board_title
                FROM posts p
                LEFT JOIN users u ON p.user_id = u.id
                LEFT JOIN boards b ON p.board_id = b.id
                WHERE p.id = ? AND p.status = 'active'";

        return $this->db->fetchOne($sql, [$id]);
    }

    /**
     * 게시글 생성
     */
    public function create(array $data): int
    {
        $sql = "INSERT INTO posts (board_id, user_id, title, content, is_notice, status)
                VALUES (?, ?, ?, ?, ?, 'active')";

        $params = [
            $data['board_id'],
            $data['user_id'] ?? null,
            $data['title'],
            $data['content'] ?? '',
            $data['is_notice'] ?? 0
        ];

        $this->db->execute($sql, $params);
        return (int)$this->db->lastInsertId();
    }

    /**
     * 게시글 수정
     */
    public function update(int $id, array $data): bool
    {
        $fields = [];
        $params = [];

        if (isset($data['title'])) {
            $fields[] = "title = ?";
            $params[] = $data['title'];
        }

        if (isset($data['content'])) {
            $fields[] = "content = ?";
            $params[] = $data['content'];
        }

        if (isset($data['is_notice'])) {
            $fields[] = "is_notice = ?";
            $params[] = $data['is_notice'];
        }

        if (empty($fields)) {
            return false;
        }

        $params[] = $id;
        $sql = "UPDATE posts SET " . implode(', ', $fields) . " WHERE id = ?";

        return $this->db->execute($sql, $params);
    }

    /**
     * 게시글 삭제
     */
    public function delete(int $id): bool
    {
        $sql = "UPDATE posts SET status = 'deleted' WHERE id = ?";
        return $this->db->execute($sql, [$id]);
    }

    /**
     * 조회수 증가
     */
    public function incrementViewCount(int $id): bool
    {
        $sql = "UPDATE posts SET view_count = view_count + 1 WHERE id = ?";
        return $this->db->execute($sql, [$id]);
    }

    /**
     * 검색
     */
    public function search(int $boardId, string $keyword, string $searchType = 'all', int $limit = 20, int $offset = 0): array
    {
        $where = "p.board_id = ? AND p.status = 'active'";
        $params = [$boardId];

        switch ($searchType) {
            case 'title':
                $where .= " AND p.title LIKE ?";
                $params[] = "%{$keyword}%";
                break;
            case 'content':
                $where .= " AND p.content LIKE ?";
                $params[] = "%{$keyword}%";
                break;
            case 'author':
                $where .= " AND u.username LIKE ?";
                $params[] = "%{$keyword}%";
                break;
            default: // all
                $where .= " AND (p.title LIKE ? OR p.content LIKE ? OR u.username LIKE ?)";
                $params[] = "%{$keyword}%";
                $params[] = "%{$keyword}%";
                $params[] = "%{$keyword}%";
                break;
        }

        $params[] = $limit;
        $params[] = $offset;

        $sql = "SELECT p.*, u.username, u.name as author_name
                FROM posts p
                LEFT JOIN users u ON p.user_id = u.id
                WHERE {$where}
                ORDER BY p.is_notice DESC, p.created_at DESC
                LIMIT ? OFFSET ?";

        return $this->db->fetchAll($sql, $params);
    }

    /**
     * 이전/다음 글
     */
    public function getAdjacentPosts(int $boardId, int $currentId): array
    {
        // 이전 글
        $prevSql = "SELECT id, title FROM posts
                    WHERE board_id = ? AND id < ? AND status = 'active'
                    ORDER BY id DESC LIMIT 1";
        $prev = $this->db->fetchOne($prevSql, [$boardId, $currentId]);

        // 다음 글
        $nextSql = "SELECT id, title FROM posts
                    WHERE board_id = ? AND id > ? AND status = 'active'
                    ORDER BY id ASC LIMIT 1";
        $next = $this->db->fetchOne($nextSql, [$boardId, $currentId]);

        return [
            'prev' => $prev,
            'next' => $next
        ];
    }

    /**
     * 사용자의 게시글 수
     */
    public function countByUser(int $userId): int
    {
        $sql = "SELECT COUNT(*) as count FROM posts WHERE user_id = ? AND status = 'active'";
        $result = $this->db->fetchOne($sql, [$userId]);
        return (int)($result['count'] ?? 0);
    }
}
