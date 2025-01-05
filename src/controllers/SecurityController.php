<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../repository/UserRepository.php';

class SecurityController extends AppController {

    public function login()
    {
        // Inicjalizacja sesji (jeśli jeszcze nie została uruchomiona)
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userRepository = new UserRepository();

        // Renderowanie widoku logowania, jeśli metoda nie jest POST
        if (!$this->isPost()) {
            return $this->render('login');
        }

        $email = $_POST["email"] ?? "";
        $password = $_POST["password"] ?? "";

        // Pobieranie użytkownika z repozytorium
        $user = $userRepository->getUser($email);

        if (!$user) {
            return $this->render('login', ['messages' => ['User does not exist']]);
        }

        // Weryfikacja hasła (proste porównanie)
        if (!password_verify($password, $user->getPassword())) {
            return $this->render('login', ['messages' => ['Wrong password']]);
        }

        // Ustawienie zmiennych sesji po poprawnym logowaniu
        $_SESSION["email"] = $user->getEmail();
        $_SESSION['user_role'] = $user->getRole();
        $_SESSION['user_id'] = $user->getId();


        // Przekierowanie do głównego widoku
        header('Location: /mainview');
        exit();
    }

    public function getLoggedInUser(): ?User {
        if (!isset($_SESSION['user_id'])) {
            return null;
        }

        $userRepository = new UserRepository();
        return $userRepository->getUserById((int)$_SESSION['user_id']);
    }

    public function logout() {
        session_unset();
        session_destroy();

        header("Location: /login");
        exit();
    }


}
