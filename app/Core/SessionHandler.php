<?php

namespace App\Core;

use SessionHandlerInterface;

class SessionHandler implements SessionHandlerInterface
{
    private ?Database $db = null;
    private int $lifetime;
    private bool $useDb = true;

    public function __construct()
    {
        try {
            $this->db = Database::getInstance();
            $this->lifetime = (int)ini_get('session.gc_maxlifetime') ?: 1440;
        } catch (\Exception $e) {
            // DB 연결 실패 시 파일 기반 세션 사용
            $this->useDb = false;
            error_log("SessionHandler: DB connection failed, falling back to file sessions: " . $e->getMessage());
        }
    }

    /**
     * 세션 시작
     */
    public function open($path, $name): bool
    {
        return true;
    }

    /**
     * 세션 종료
     */
    public function close(): bool
    {
        return true;
    }

    /**
     * 세션 읽기
     */
    public function read($id): string|false
    {
        if (!$this->useDb || !$this->db) {
            return '';
        }

        try {
            $sql = "SELECT payload FROM sessions WHERE id = ? AND last_activity > ?";
            $minActivity = time() - $this->lifetime;

            $result = $this->db->fetchOne($sql, [$id, $minActivity]);

            if ($result) {
                return $result['payload'] ?? '';
            }
        } catch (\Exception $e) {
            error_log("Session read error: " . $e->getMessage());
        }

        return '';
    }

    /**
     * 세션 쓰기
     */
    public function write($id, $data): bool
    {
        if (!$this->useDb || !$this->db) {
            return true; // 파일 기반 세션이 처리하도록
        }

        try {
            $userId = $_SESSION['user_id'] ?? null;
            $ipAddress = $_SERVER['REMOTE_ADDR'] ?? null;
            $userAgent = substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 255);
            $lastActivity = time();

            // UPSERT 쿼리 (MySQL)
            $sql = "INSERT INTO sessions (id, user_id, ip_address, user_agent, payload, last_activity)
                    VALUES (?, ?, ?, ?, ?, ?)
                    ON DUPLICATE KEY UPDATE
                        user_id = VALUES(user_id),
                        ip_address = VALUES(ip_address),
                        user_agent = VALUES(user_agent),
                        payload = VALUES(payload),
                        last_activity = VALUES(last_activity)";

            return $this->db->execute($sql, [
                $id,
                $userId,
                $ipAddress,
                $userAgent,
                $data,
                $lastActivity
            ]);
        } catch (\Exception $e) {
            error_log("Session write error: " . $e->getMessage());
            return true; // 에러를 숨기고 PHP 기본 처리로
        }
    }

    /**
     * 세션 삭제
     */
    public function destroy($id): bool
    {
        if (!$this->useDb || !$this->db) {
            return true;
        }

        try {
            $sql = "DELETE FROM sessions WHERE id = ?";
            return $this->db->execute($sql, [$id]);
        } catch (\Exception $e) {
            error_log("Session destroy error: " . $e->getMessage());
            return true;
        }
    }

    /**
     * 세션 가비지 컬렉션
     */
    public function gc($max_lifetime): int|false
    {
        $sql = "DELETE FROM sessions WHERE last_activity < ?";
        $expiry = time() - $max_lifetime;

        try {
            $this->db->execute($sql, [$expiry]);
            return 0; // 삭제된 행 수는 반환하지 않음 (선택사항)
        } catch (\Exception $e) {
            error_log("Session GC error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * 세션 타임스탬프 업데이트 (PHP 7.0+)
     */
    #[\ReturnTypeWillChange]
    public function updateTimestamp($id, $data): bool
    {
        if (!$this->useDb || !$this->db) {
            return true;
        }

        try {
            // UPDATE가 실패할 수 있으므로 UPSERT 방식 사용
            $userId = $_SESSION['user_id'] ?? null;
            $ipAddress = $_SERVER['REMOTE_ADDR'] ?? null;
            $userAgent = substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 255);
            $lastActivity = time();

            $sql = "INSERT INTO sessions (id, user_id, ip_address, user_agent, payload, last_activity)
                    VALUES (?, ?, ?, ?, ?, ?)
                    ON DUPLICATE KEY UPDATE
                        last_activity = VALUES(last_activity)";

            return $this->db->execute($sql, [
                $id,
                $userId,
                $ipAddress,
                $userAgent,
                $data,
                $lastActivity
            ]);
        } catch (\Exception $e) {
            error_log("Session updateTimestamp error: " . $e->getMessage());
            return true; // 에러를 숨김
        }
    }

    /**
     * 세션 유효성 검증 (PHP 7.0+)
     */
    #[\ReturnTypeWillChange]
    public function validateId($id): bool
    {
        if (!$this->useDb || !$this->db) {
            return true;
        }

        try {
            $sql = "SELECT id FROM sessions WHERE id = ? AND last_activity > ?";
            $minActivity = time() - $this->lifetime;
            $result = $this->db->fetchOne($sql, [$id, $minActivity]);
            return $result !== null;
        } catch (\Exception $e) {
            error_log("Session validateId error: " . $e->getMessage());
            return true; // 에러 시 기본 동작으로
        }
    }

    /**
     * 특정 사용자의 모든 세션 삭제
     */
    public function destroyUserSessions(int $userId): bool
    {
        $sql = "DELETE FROM sessions WHERE user_id = ?";
        return $this->db->execute($sql, [$userId]);
    }

    /**
     * 현재 사용자의 다른 세션 삭제 (현재 세션 제외)
     */
    public function destroyOtherSessions(int $userId, string $currentSessionId): bool
    {
        $sql = "DELETE FROM sessions WHERE user_id = ? AND id != ?";
        return $this->db->execute($sql, [$userId, $currentSessionId]);
    }

    /**
     * 활성 세션 수 조회
     */
    public function countActiveSessions(?int $userId = null): int
    {
        $minActivity = time() - $this->lifetime;

        if ($userId) {
            $sql = "SELECT COUNT(*) as count FROM sessions WHERE user_id = ? AND last_activity > ?";
            $result = $this->db->fetchOne($sql, [$userId, $minActivity]);
        } else {
            $sql = "SELECT COUNT(*) as count FROM sessions WHERE last_activity > ?";
            $result = $this->db->fetchOne($sql, [$minActivity]);
        }

        return (int)($result['count'] ?? 0);
    }

    /**
     * 활성 세션 목록 조회
     */
    public function getActiveSessions(?int $userId = null, int $limit = 100): array
    {
        $minActivity = time() - $this->lifetime;

        if ($userId) {
            $sql = "SELECT s.*, u.email, u.name
                    FROM sessions s
                    LEFT JOIN users u ON s.user_id = u.id
                    WHERE s.user_id = ? AND s.last_activity > ?
                    ORDER BY s.last_activity DESC
                    LIMIT ?";
            return $this->db->fetchAll($sql, [$userId, $minActivity, $limit]);
        } else {
            $sql = "SELECT s.*, u.email, u.name
                    FROM sessions s
                    LEFT JOIN users u ON s.user_id = u.id
                    WHERE s.last_activity > ?
                    ORDER BY s.last_activity DESC
                    LIMIT ?";
            return $this->db->fetchAll($sql, [$minActivity, $limit]);
        }
    }
}
