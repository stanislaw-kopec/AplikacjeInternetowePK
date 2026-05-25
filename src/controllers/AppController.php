<?php

require_once __DIR__.'/../repositories/UsersRepository.php';

class AppController {
    protected function isGet(): bool
    {
        return $_SERVER["REQUEST_METHOD"] === 'GET';
    }

    protected function isPost(): bool
    {
        return $_SERVER["REQUEST_METHOD"] === 'POST';
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
            $redirect = $_SERVER['REQUEST_URI'] ?? '/dashboard';
            header("Location: /login?redirect=" . urlencode($redirect));
            exit;
        }
    }

    protected function requireRole(string ...$roles)
    {
        $this->requireAuth();

        $user = $this->getCurrentUser();

        if (!$user) {
            session_destroy();
            header("Location: /login");
            exit;
        }

        if (!in_array($user->getRole(), $roles, true)) {
            http_response_code(403);
            include 'public/views/403.html';
            exit;
        }
    }

    protected function render(string $template = null, array $variables = [])
    {
        $templatePath = 'public/views/'. $template.'.html';
        $templatePath404 = 'public/views/404.html';
        $output = "";
                 
        if(file_exists($templatePath)){
            $currentUser = $this->getCurrentUser();
            $variables['isLoggedIn'] = $currentUser !== null;
            $variables['currentUserRole'] = $currentUser ? $currentUser->getRole() : null;
            $variables['currentUserEmail'] = $currentUser ? $currentUser->getEmail() : null;

            extract($variables);
            // ["tab_name" => $title]

            // $tab_name = $title

            ob_start();
            include $templatePath;
            $output = ob_get_clean();
        } else {
            ob_start();
            include $templatePath404;
            $output = ob_get_clean();
        }
        echo $output;
    }

}
