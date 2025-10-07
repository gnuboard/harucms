<?php

namespace App\Models;

use App\Core\Database;

class Content
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * 슬러그로 컨텐츠 조회
     */
    public function findBySlug(string $slug): ?array
    {
        $sql = "SELECT c.*, u.email, u.name as author_name
                FROM contents c
                LEFT JOIN users u ON c.created_by = u.id
                WHERE c.slug = ? AND c.status = 'published'";

        return $this->db->fetchOne($sql, [$slug]);
    }

    /**
     * ID로 컨텐츠 조회
     */
    public function findById(int $id): ?array
    {
        $sql = "SELECT c.*, u.email, u.name as author_name
                FROM contents c
                LEFT JOIN users u ON c.created_by = u.id
                WHERE c.id = ?";

        return $this->db->fetchOne($sql, [$id]);
    }

    /**
     * 전체 컨텐츠 목록
     */
    public function getAll(string $status = 'all', int $limit = 100, int $offset = 0): array
    {
        $where = $status === 'all' ? '' : "WHERE c.status = ?";
        $params = $status === 'all' ? [] : [$status];

        $sql = "SELECT c.*, u.email, u.name as author_name
                FROM contents c
                LEFT JOIN users u ON c.created_by = u.id
                {$where}
                ORDER BY c.updated_at DESC
                LIMIT ? OFFSET ?";

        $params[] = $limit;
        $params[] = $offset;

        return $this->db->fetchAll($sql, $params);
    }

    /**
     * 컨텐츠 수 조회
     */
    public function count(string $status = 'all'): int
    {
        $where = $status === 'all' ? '' : "WHERE status = ?";
        $params = $status === 'all' ? [] : [$status];

        $sql = "SELECT COUNT(*) as count FROM contents {$where}";
        $result = $this->db->fetchOne($sql, $params);
        return (int)($result['count'] ?? 0);
    }

    /**
     * 컨텐츠 생성
     */
    public function create(array $data): int
    {
        $sql = "INSERT INTO contents (slug, title, content, status, created_by)
                VALUES (?, ?, ?, ?, ?)";

        $params = [
            $data['slug'],
            $data['title'],
            $data['content'] ?? '',
            $data['status'] ?? 'draft',
            $data['created_by'] ?? null
        ];

        $this->db->execute($sql, $params);
        return (int)$this->db->lastInsertId();
    }

    /**
     * 컨텐츠 수정
     */
    public function update(int $id, array $data): bool
    {
        $fields = [];
        $params = [];

        $allowedFields = ['slug', 'title', 'content', 'status'];

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
        $sql = "UPDATE contents SET " . implode(', ', $fields) . " WHERE id = ?";

        return $this->db->execute($sql, $params);
    }

    /**
     * 컨텐츠 삭제
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM contents WHERE id = ?";
        return $this->db->execute($sql, [$id]);
    }

    /**
     * 슬러그 중복 체크
     */
    public function slugExists(string $slug, ?int $excludeId = null): bool
    {
        if ($excludeId) {
            $sql = "SELECT COUNT(*) as count FROM contents WHERE slug = ? AND id != ?";
            $result = $this->db->fetchOne($sql, [$slug, $excludeId]);
        } else {
            $sql = "SELECT COUNT(*) as count FROM contents WHERE slug = ?";
            $result = $this->db->fetchOne($sql, [$slug]);
        }

        return (int)($result['count'] ?? 0) > 0;
    }
}
