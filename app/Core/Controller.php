<?php

namespace App\Core;

class Controller
{
    protected function view($view, $data = [])
    {
        extract($data);
        $viewFile = __DIR__ . "/../../resources/views/" . str_replace('.', '/', $view) . ".php";
        
        if (!file_exists($viewFile)) {
            die("View $view not found");
        }

        if (strpos($view, 'auth.') === 0) {
            $layoutFile = __DIR__ . "/../../resources/views/layouts/auth.php";
        } else {
            $layoutFile = __DIR__ . "/../../resources/views/layouts/app.php";
        }

        if (file_exists($layoutFile)) {
            require_once $layoutFile;
        } else {
            require_once $viewFile;
        }
    }

    protected function redirect($url)
    {
        header("Location: " . BASE_URL . "/" . ltrim($url, '/'));
        exit;
    }

    protected function json($data)
    {
        // Clear any previous output to ensure only JSON is sent
        if (ob_get_length()) ob_clean();
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
