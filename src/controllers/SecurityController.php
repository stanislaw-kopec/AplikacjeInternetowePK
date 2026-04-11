<?php

require_once 'AppController.php';

class SecurityController extends AppController {

    public function login() {
        // TODO sprawdzeie czy user istnieje

        return $this->render("login");
    }

    public function login2() {

        return $this->render("login");
    }
}