<?php

require_once 'AppController.php';

class HomeController extends AppController {

    public function index() {
        $title = "index";

        return $this->render("home", ["title" => $title]);
    }
}
