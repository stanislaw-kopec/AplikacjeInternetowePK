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
            header("Location: /login");
            exit;
        }
    }

    protected function render(string $template = null, array $variables = [])
    {
        $templatePath = 'public/views/'. $template.'.html';
        $templatePath404 = 'public/views/404.html';
        $output = "";
                 
        if(file_exists($templatePath)){
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
