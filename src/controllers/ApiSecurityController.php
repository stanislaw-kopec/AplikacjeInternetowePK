<?php

require_once 'ApiController.php';
require_once __DIR__.'/../repositories/UsersRepository.php';
require_once __DIR__.'/../models/User.php';

class ApiSecurityController extends ApiController {

    public function login()
    {
        if (!$this->isPost()) {
            $this->jsonError('Method not allowed', 405);
        }

        $input = json_decode(file_get_contents('php://input'), true);
        
        if (!isset($input['email']) || !isset($input['password'])) {
            $this->jsonError('Email and password are required', 400);
        }

        $email = $input['email'];
        $password = $input['password'];

        $usersRepository = new UsersRepository();
        $user = $usersRepository->getUserByEmail($email);

        if (!$user) {
            $this->jsonError('User not found', 401);
        }

        if (!password_verify($password, $user->getPassword())) {
            $this->jsonError('Wrong password', 401);
        }

        $_SESSION['user_id'] = $user->getId();

        $this->jsonResponse([
            'success' => true,
            'message' => 'Logged in successfully',
            'user_id' => $user->getId(),
            'email' => $user->getEmail()
        ]);
    }

    public function logout()
    {
        session_destroy();
        $this->jsonResponse([
            'success' => true,
            'message' => 'Logged out successfully'
        ]);
    }
}