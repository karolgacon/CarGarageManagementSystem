<?php

require_once __DIR__.'/../models/Task.php';

class TaskRepository {
    private $tasks = [];

    public function __construct() {
        // Example tasks
        $this->tasks[] = new Task(1, 'Change oil', 'Change the oil of the car', 'pending', 2);
        $this->tasks[] = new Task(2, 'Replace brake pads', 'Replace the brake pads of the car', 'completed', 2);
    }

    public function getTasksByUserId($userId) {
        $userTasks = [];
        foreach ($this->tasks as $task) {
            if ($task->getUserId() === $userId) {
                $userTasks[] = $task;
            }
        }
        return $userTasks;
    }

    public function addTask($title, $description, $status, $userId) {
        $id = count($this->tasks) + 1;
        $this->tasks[] = new Task($id, $title, $description, $status, $userId);
    }

    public function updateTask($id, $title, $description, $status) {
        foreach ($this->tasks as $task) {
            if ($task->getId() === $id) {
                $task->title = $title;
                $task->description = $description;
                $task->status = $status;
                return true;
            }
        }
        return false;
    }
}