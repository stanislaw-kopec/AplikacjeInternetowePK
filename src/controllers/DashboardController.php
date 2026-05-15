<?php

require_once 'AppController.php';

require_once __DIR__.'/../repositories/UsersRepository.php';

class DashboardController extends AppController {

    public function index() {
        // Przekierowanie do nowego widoku dashboard
        return $this->render("dashboard");
    }

    public function ildIndex() {
        // TODO pobieranie danych z bazy
        // wstawianie zmiennych na widok
        $title = "index";
        $usersRepository = new UsersRepository();
        $users = $usersRepository->getUsers();

        return $this->render("index", ["title" => $title, "users" => $users]);
    }

    public function proDashboard() {
        return $this->render("pro-dashboard");
    }

    public function profileSettings() {
        return $this->render("profile-settings");
    }
}