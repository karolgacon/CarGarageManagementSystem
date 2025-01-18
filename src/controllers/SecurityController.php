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
        if (!(password_verify($password, $user->getPassword()))) {
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

    public function register() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userRepository = new UserRepository();

        // Renderowanie widoku rejestracji, jeśli metoda nie jest POST
        if (!$this->isPost()) {
            return $this->render('register');
        }

        $email = $_POST["email"] ?? "";
        $password = $_POST["password"] ?? "";
        $name = $_POST["name"] ?? "";
        $surname = $_POST["surname"] ?? "";

        // Walidacja danych wejściowych
        $messages = [];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $messages[] = "Invalid email format";
        }

        if (strlen($password) < 6) {
            $messages[] = "Password must be at least 6 characters long";
        }

        if (empty($name)) {
            $messages[] = "Name is required";
        }

        if (empty($surname)) {
            $messages[] = "Surname is required";
        }

        if (!empty($messages)) {
            return $this->render('register', ['messages' => $messages]);
        }

        // Sprawdzenie, czy użytkownik już istnieje
        if ($userRepository->getUser($email)) {
            return $this->render('register', ['messages' => ['User with this email already exists']]);
        }

        // Hashowanie hasła
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);


        // Tworzenie nowego użytkownika z domyślną rolą "user"
        $newUser = [
            'email' => $email,
            'password' => $hashedPassword,
            'name' => $name,
            'surname' => $surname,
            'role' => 'user', // Domyślna rola
            'photo' => null // Opcjonalne zdjęcie
        ];

        $userRepository->addUser($newUser);

        // Przekierowanie na stronę logowania
//        header('Location: /login');
        return $this->render('register', [
            'messages' => ['Registration successful! You will be redirected to the login page in 5 seconds.'],
            'redirect' => true // Dodatkowy parametr do obsługi przekierowania
        ]);
    }



}
