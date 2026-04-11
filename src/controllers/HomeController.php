<?php

require_once 'AppController.php';

class HomeController extends AppController {

    public function index() {
        // TODO pobieranie danych z bazy
        // wstawianie zmiennych na widok
        $title = "index";

        return $this->render("home", ["title" => $title]);
    }
}