<?php

require_once 'AppController.php';

require_once __DIR__.'/../repositories/UsersRepository.php';
require_once __DIR__.'/../models/User.php';

class SecurityController extends AppController {

    public function login()
    {
        if (!$this->isPost()) {
            return $this->render("login");
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

        $usersRepository = new UsersRepository();

        $user = $usersRepository->getUserByEmail($email);

        if (!$user) {
            echo "User not found";
            return;
        }

        if (!password_verify($password, $user->getPassword())) {
            echo "Wrong password";
            return;
        }

        $_SESSION['user_id'] = $user->getId();

        header("Location: /dashboard");
    }

    public function register()
    {
        if (!$this->isPost()) {
            return $this->render("register");
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

        $hashedPassword = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        $usersRepository = new UsersRepository();

        $existingUser = $usersRepository->getUserByEmail($email);

        if ($existingUser) {
            echo "User already exists";
            return;
        }

        $user = new User(
            $email,
            $hashedPassword
        );

        $usersRepository->createUser($user);

        header("Location: /login");
    }
}