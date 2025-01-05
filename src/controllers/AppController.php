<?php

class AppController {
    private $request;

    public function __construct()
    {
        $this->request = $_SERVER['REQUEST_METHOD'];
    }

    protected function isGet(): bool
    {
        return $this->request === 'GET';
    }

    protected function isPost(): bool
    {
        return $this->request === 'POST';
    }

    protected function render(string $template , array $variables = [])
    {
        $templatePath = 'data/views/'. $template.'.php';
        $output = 'File not found';
        $variables['loggedInUser'] = $this->getLoggedInUser();
                
        if(file_exists($templatePath)){
            extract($variables);
            
            ob_start();
            include $templatePath;
            $output = ob_get_clean();
        }

        print $output;
    }

    public function getLoggedInUser(): ?User {
        if (!isset($_SESSION['user_id'])) {
            return null;
        }

        $userRepository = new UserRepository();
        return $userRepository->getUserById((int)$_SESSION['user_id']);
    }

}