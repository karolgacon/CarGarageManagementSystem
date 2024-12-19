<?php

require_once 'AppController.php';
require_once __DIR__.'/../repository/TaskRepository.php';

class TaskController extends AppController {
    private $taskRepository;

    public function __construct() {
        parent::__construct();
        $this->taskRepository = new TaskRepository();
    }

    public function listTasks()
    {
        if (!isset($_SESSION['id'])) {
            return $this->render('login');
        }

        // Fetch tasks from the repository and pass them to the view
        $taskRepository = new TaskRepository();
        $tasks = $taskRepository->getTasksByUserId($_SESSION['id']);

        $this->render('task_list', ['tasks' => $tasks]);
    }

    public function addTask() {
        if (!isset($_SESSION['id'])) {
            $this->render('main');
            return;
        }
        if (!$this->isPost()) {
            $this->render('task_add');
            return;
        }
        $title = $_POST['title'];
        $description = $_POST['description'];
        $status = $_POST['status'];
        $this->taskRepository->addTask($title, $description, $status, $_SESSION['id']);
        $this->render('task_list', ['tasks' => $this->taskRepository->getTasksByUserId($_SESSION['id'])]);
    }

    public function editTask() {
        if (!isset($_SESSION['id'])) {
            $this->render('main');
            return;
        }
        if (!$this->isPost()) {
            $this->render('task_edit');
            return;
        }
        $id = $_POST['id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $status = $_POST['status'];
        $this->taskRepository->updateTask($id, $title, $description, $status);
        $this->render('task_list', ['tasks' => $this->taskRepository->getTasksByUserId($_SESSION['id'])]);
    }
}

