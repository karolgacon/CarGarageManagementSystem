<?php

require_once 'AppController.php';


class DefaultController extends AppController {

    public function index()
    {
        if (!isset($_SESSION['id'])) {
            $this->render('main');
            return;
        }
        $this->render('mainview');
    }

    public function user() {
        if (!isset($_SESSION['id'])) {
            $this->render('main');
            return;
        }
        $this->render('user');
    }

    public function mainview() {
        if (!isset($_SESSION['id'])) {
            $this->render('main');
            return;
        }
        $this->render('mainview');
    }

     public function login() {
        if (!isset($_SESSION['id'])) {
            $this->render('login');
            return;
        }
        $this->render('login');
    }

         public function register() {
        if (!isset($_SESSION['id'])) {
            $this->render('register');
            return;
        }
        $this->render('register');
    }

}