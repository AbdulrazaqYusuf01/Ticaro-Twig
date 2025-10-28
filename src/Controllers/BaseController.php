<?php

namespace App\Controllers;

class BaseController
{
    protected $twig;

    public function __construct($twig)
    {
        $this->twig = $twig;
        
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    protected function render($template, $data = [])
    {
       
        $data['user'] = $_SESSION['user'] ?? null;
        $data['flash'] = $_SESSION['flash'] ?? [];
        
       
        unset($_SESSION['flash']);
        
        return $this->twig->render($template, $data);
    }

    protected function redirect($path)
    {
        header("Location: $path");
        exit;
    }

    protected function setFlash($type, $message)
    {
        $_SESSION['flash'][] = [
            'type' => $type,
            'message' => $message
        ];
    }

    protected function isAuthenticated()
    {
        return isset($_SESSION['user']);
    }

    protected function requireAuth()
    {
        if (!$this->isAuthenticated()) {
            $this->redirect('/login');
        }
    }
}