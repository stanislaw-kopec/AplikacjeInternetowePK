<?php

require_once __DIR__.'/../repositories/UsersRepository.php';

class ApiController {
    protected function jsonResponse($data, int $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    protected function jsonError(string $message, int $statusCode = 400)
    {
        $this->jsonResponse(['error' => $message], $statusCode);
    }

    protected function isLoggedIn(): bool
    {
        return isset($_SESSION['user_id']);
    }

    protected function getCurrentUser()
    {
        if (!$this->isLoggedIn()) {
            return null;
        }

        $usersRepository = new UsersRepository();
        return $usersRepository->getUserById($_SESSION['user_id']);
    }

    protected function requireAuth()
    {
        if (!$this->isLoggedIn()) {
            $this->jsonError('Unauthorized', 401);
        }
    }

    protected function isGet(): bool
    {
        return $_SERVER["REQUEST_METHOD"] === 'GET';
    }

    protected function isPost(): bool
    {
        return $_SERVER["REQUEST_METHOD"] === 'POST';
    }
}