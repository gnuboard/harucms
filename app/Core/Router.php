<?php

namespace App\Core;

class Router
{
    private array $routes = [];
    private string $basePath = '';

    public function __construct(string $basePath = '')
    {
        $this->basePath = rtrim($basePath, '/');
    }

    public function get(string $path, $callback): void
    {
        $this->addRoute('GET', $path, $callback);
    }

    public function post(string $path, $callback): void
    {
        $this->addRoute('POST', $path, $callback);
    }

    private function addRoute(string $method, string $path, $callback): void
    {
        $pattern = $this->convertToPattern($path);
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'pattern' => $pattern,
            'callback' => $callback
        ];
    }

    private function convertToPattern(string $path): string
    {
        // URL 파라미터 변환 (:id -> 정규식)
        $pattern = preg_replace('/\/:([^\/]+)/', '/(?P<$1>[^/]+)', $path);
        return '#^' . $pattern . '$#';
    }

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // basePath 제거
        if ($this->basePath && strpos($uri, $this->basePath) === 0) {
            $uri = substr($uri, strlen($this->basePath));
        }

        $uri = $uri ?: '/';

        foreach ($this->routes as $route) {
            if ($route['method'] === $method && preg_match($route['pattern'], $uri, $matches)) {
                // 파라미터 추출
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                $callback = $route['callback'];

                try {
                    if (is_array($callback)) {
                        // [ControllerClass, 'method'] 형식
                        $controller = new $callback[0]();
                        $method = $callback[1];
                        echo $controller->$method($params);
                    } else {
                        // 익명 함수
                        echo $callback($params);
                    }
                } catch (\Exception $e) {
                    // Stack Trace 없이 에러 메시지만 표시
                    echo $e->getMessage();
                }
                return;
            }
        }

        // 404 처리
        http_response_code(404);
        echo '404 Not Found';
    }
}
