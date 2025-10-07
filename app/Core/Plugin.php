<?php

namespace App\Core;

class Plugin
{
    private static array $hooks = [];
    private static array $loadedPlugins = [];

    /**
     * 플러그인 로드
     */
    public static function load(): void
    {
        $db = Database::getInstance();
        $plugins = $db->fetchAll("SELECT * FROM plugins WHERE enabled = 1 ORDER BY name");

        foreach ($plugins as $plugin) {
            $pluginPath = BASE_PATH . '/plugins/' . $plugin['name'] . '/plugin.php';

            if (file_exists($pluginPath)) {
                require_once $pluginPath;
                self::$loadedPlugins[$plugin['name']] = $plugin;
            }
        }
    }

    /**
     * 훅 등록
     */
    public static function addHook(string $hookName, callable $callback, int $priority = 10): void
    {
        if (!isset(self::$hooks[$hookName])) {
            self::$hooks[$hookName] = [];
        }

        self::$hooks[$hookName][] = [
            'callback' => $callback,
            'priority' => $priority
        ];

        // 우선순위로 정렬
        usort(self::$hooks[$hookName], function($a, $b) {
            return $a['priority'] <=> $b['priority'];
        });
    }

    /**
     * 훅 실행 (값 반환)
     */
    public static function applyFilter(string $hookName, $value, ...$args)
    {
        if (!isset(self::$hooks[$hookName])) {
            return $value;
        }

        foreach (self::$hooks[$hookName] as $hook) {
            $value = call_user_func_array($hook['callback'], array_merge([$value], $args));
        }

        return $value;
    }

    /**
     * 훅 실행 (액션)
     */
    public static function doAction(string $hookName, ...$args): void
    {
        if (!isset(self::$hooks[$hookName])) {
            return;
        }

        foreach (self::$hooks[$hookName] as $hook) {
            call_user_func_array($hook['callback'], $args);
        }
    }

    /**
     * 플러그인 설정 가져오기
     */
    public static function getConfig(string $pluginName, ?string $key = null)
    {
        if (!isset(self::$loadedPlugins[$pluginName])) {
            return null;
        }

        $config = json_decode(self::$loadedPlugins[$pluginName]['config'] ?? '{}', true);

        if ($key === null) {
            return $config;
        }

        return $config[$key] ?? null;
    }

    /**
     * 플러그인 설정 저장
     */
    public static function setConfig(string $pluginName, array $config): bool
    {
        $db = Database::getInstance();
        $configJson = json_encode($config, JSON_UNESCAPED_UNICODE);

        return $db->execute(
            "UPDATE plugins SET config = ? WHERE name = ?",
            [$configJson, $pluginName]
        );
    }

    /**
     * 로드된 플러그인 목록
     */
    public static function getLoadedPlugins(): array
    {
        return self::$loadedPlugins;
    }

    /**
     * 플러그인 활성화
     */
    public static function enable(string $pluginName): bool
    {
        $db = Database::getInstance();
        return $db->execute("UPDATE plugins SET enabled = 1 WHERE name = ?", [$pluginName]);
    }

    /**
     * 플러그인 비활성화
     */
    public static function disable(string $pluginName): bool
    {
        $db = Database::getInstance();
        return $db->execute("UPDATE plugins SET enabled = 0 WHERE name = ?", [$pluginName]);
    }
}
