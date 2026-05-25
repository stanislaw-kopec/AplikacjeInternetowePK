<?php

require_once 'AppController.php';

require_once __DIR__.'/../repositories/UsersRepository.php';
require_once __DIR__.'/../repositories/SpecialistRepository.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../models/Specialist.php';

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
        $_SESSION['user_role'] = $user->getRole();

        $redirect = $this->getSafeRedirect($_GET['redirect'] ?? null);
        header("Location: " . $redirect);
    }

    public function register()
    {
        if (!$this->isPost()) {
            return $this->render("register");
        }

        $email = $_POST['email'];
        $password = $_POST['password'];
        $role = $_POST['role'] ?? 'User';

        if (!in_array($role, ['User', 'Specialist'], true)) {
            echo "Invalid role";
            return;
        }

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
            $hashedPassword,
            0,
            $role
        );

        $userId = $usersRepository->createUser($user);

        if ($role === 'Specialist') {
            $name = explode('@', $email)[0];
            $specialist = new Specialist(
                $name,
                'Specialist',
                '',
                0,
                null,
                null,
                $userId,
                'Update your profile description so clients know what you do best.',
                'Tell clients about your experience, services and working style.',
                '',
                0,
                '< 1 hour'
            );

            (new SpecialistRepository())->createSpecialist($specialist);
        }

        header("Location: /login");
    }

    public function logout()
    {
        session_destroy();
        header("Location: /home");
    }

    private function getSafeRedirect(?string $redirect): string
    {
        if (!$redirect || !str_starts_with($redirect, '/') || str_starts_with($redirect, '//')) {
            return '/dashboard';
        }

        return $redirect;
    }
}
