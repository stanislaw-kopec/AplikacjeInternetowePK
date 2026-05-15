<?php

require_once 'AppController.php';
require_once __DIR__.'/../repositories/ProfileRepository.php';
require_once __DIR__.'/../models/Profile.php';

class ProfileController extends AppController {

    public function index()
    {
        // Pokaż profil zalogowanego użytkownika
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            return;
        }

        $repository = new ProfileRepository();
        $profile = $repository->getProfileByUserId($_SESSION['user_id']);

        if ($profile) {
            echo "Username: " . $profile->getUsername();
        } else {
            echo "Profile not found. <a href='/create-profile'>Create profile</a>";
        }
    }

    public function create()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            return;
        }

        if (!$this->isPost()) {
            echo "
                <form method='POST'>
                    <input name='username' placeholder='Username' required>
                    <button type='submit'>Create Profile</button>
                </form>
            ";
            return;
        }

        $username = $_POST['username'];
        $profile = new Profile($_SESSION['user_id'], $username);

        $repository = new ProfileRepository();
        $repository->createProfile($profile);

        header("Location: /profile");
    }
}