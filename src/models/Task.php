<?php

class Task {
    private $id;
    private $title;
    private $description;
    private $status;
    private $userId;

    public function __construct($id, $title, $description, $status, $userId) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->status = $status;
        $this->userId = $userId;
    }

    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getUserId() {
        return $this->userId;
    }
}