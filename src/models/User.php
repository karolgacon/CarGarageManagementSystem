<?php

class User
{
    private $email;
    private $password;
    private $name;
    private $surname;
    private $role;

    public function __construct(string $email, string $password, string $surname, string $name, string $role)
    {
        $this->email = $email;
        $this->password = $password;
        $this->surname = $surname;
        $this->name = $name;
        $this->role = $role;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function setSurname(string $surname)
    {
        $this->surname = $surname;
    }


}