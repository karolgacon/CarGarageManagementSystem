<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/User.php';

class UserRepository extends Repository {

    public function getUser(string $email): ?User {
        $stmt = $this->database->connect()->prepare('
        SELECT * FROM users WHERE email = :email
    ');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return new User(
            $row['id'],
            $row['email'],
            $row['password'],
            $row['name'],
            $row['surname'],
            $row['role'],
            $row['photo']
        );
    }

    public function getAllUsers(): array {
        $stmt = $this->database->connect()->query("SELECT * FROM users");
        $users = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $users[] = new User(
                $row['id'],
                $row['email'],
                $row['password'],
                $row['name'],
                $row['surname'],
                $row['role'],
                $row['photo'] ?? null
            );
        }
        return $users;
    }

    public function getUserById(int $id): ?User {
        $stmt = $this->database->connect()->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return new User(
            $row['id'],
            $row['email'],
            $row['password'],
            $row['name'],
            $row['surname'],
            $row['role'],
            $row['photo'] ?? null
        );
    }

    public function addUser(array $data): void {
        // Sprawdź, czy użytkownik już istnieje
        $existingUser = $this->getUserByEmail($data['email']);
        if ($existingUser) {
            throw new RuntimeException('User with this email already exists.');
        }

        $stmt = $this->database->connect()->prepare('
        INSERT INTO users (email, password, name, surname, role, photo)
        VALUES (:email, :password, :name, :surname, :role, :photo)
    ');

        $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);

        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':surname', $data['surname']);
        $stmt->bindParam(':role', $data['role']);
        $stmt->bindParam(':photo', $data['photo']);
        $stmt->execute();
    }

    public function getUserByEmail(string $email): ?User {
        $stmt = $this->database->connect()->prepare('
        SELECT * FROM users WHERE email = :email
    ');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return new User(
            $row['id'],
            $row['email'],
            $row['password'],
            $row['name'],
            $row['surname'],
            $row['role'],
            $row['photo']
        );
    }


    public function updateUser(int $id, array $data): void {
        $query = "
        UPDATE users SET 
        email = :email, 
        name = :name, 
        surname = :surname, 
        role = :role, 
        photo = :photo
    ";

        // Dodaj `password` do zapytania, jeśli jest ustawione
        if (isset($data['password'])) {
            $query .= ", password = :password";
        }

        $query .= " WHERE id = :id";

        $stmt = $this->database->connect()->prepare($query);

        $stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);
        $stmt->bindParam(':name', $data['name'], PDO::PARAM_STR);
        $stmt->bindParam(':surname', $data['surname'], PDO::PARAM_STR);
        $stmt->bindParam(':role', $data['role'], PDO::PARAM_STR);
        $stmt->bindParam(':photo', $data['photo'], PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Powiąż `password`, jeśli jest ustawione
        if (isset($data['password'])) {
            $stmt->bindParam(':password', $data['password']);
        }

        $stmt->execute();
    }


    public function deleteUser(int $id): void {
        $stmt = $this->database->connect()->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

}
