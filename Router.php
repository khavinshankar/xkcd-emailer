<?php

namespace app;

class Router
{
    public array $get_routes = [];
    public array $post_routes = [];

    public function get($url, $fn)
    {
        $this->get_routes[$url] = $fn;
    }

    public function post($url, $fn)
    {
        $this->post_routes[$url] = $fn;
    }

    public function resolve()
    {
        $current_url = $_SERVER["PATH_INFO"] ?? "/";
        $current_method = $_SERVER["REQUEST_METHOD"];

        if ($current_method === "GET") {
            $fn = $this->get_routes[$current_url] ?? null;
        } else {
            $fn = $this->post_routes[$current_url] ?? null;
        }

        if ($fn) {
            call_user_func($fn, $this);
        } else {
            echo "404: Page Not Found!";
        }
    }

    public function render($view, $data = [])
    {
        ob_start();
        include_once __DIR__ . "/views/$view.php";
        $content = ob_get_clean();
        include_once __DIR__ . "/views/_layout.php";
    }
}
