<?php

namespace App\Controllers;

use App\Models\User;

class AuthController extends BaseController
{
    private $userModel;

    public function __construct($twig)
    {
        parent::__construct($twig);
        $this->userModel = new User();
    }

    public function showLogin()
    {
        if ($this->isAuthenticated()) {
            $this->redirect('/dashboard');
        }
        
        return $this->render('pages/login.html.twig');
    }

    public function login()
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        
        $errors = [];
        
        if (empty($email)) {
            $errors['email'] = 'Email is required';
        }
        
        if (empty($password)) {
            $errors['password'] = 'Password is required';
        }
        
        if (empty($errors)) {
            $user = $this->userModel->authenticate($email, $password);
            
            if ($user) {
                $_SESSION['user'] = $user;
                $this->setFlash('success', 'Login successful!');
                $this->redirect('/dashboard');
            } else {
                $errors['general'] = 'Invalid credentials. Try demo@ticaro.com / demo123';
            }
        }
        
        return $this->render('pages/login.html.twig', [
            'errors' => $errors,
            'email' => $email
        ]);
    }

    public function showSignup()
    {
        if ($this->isAuthenticated()) {
            $this->redirect('/dashboard');
        }
        
        return $this->render('pages/signup.html.twig');
    }

    public function signup()
    {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        
        $errors = [];
        
        if (empty($name)) {
            $errors['name'] = 'Name is required';
        }
        
        if (empty($email)) {
            $errors['email'] = 'Email is required';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email format';
        }
        
        if (empty($password)) {
            $errors['password'] = 'Password is required';
        } elseif (strlen($password) < 6) {
            $errors['password'] = 'Password must be at least 6 characters';
        }
        
        if ($password !== $confirmPassword) {
            $errors['confirm_password'] = 'Passwords do not match';
        }
        
        if (empty($errors)) {
            $user = $this->userModel->register($name, $email, $password);
            
            if ($user) {
                $_SESSION['user'] = $user;
                $this->setFlash('success', 'Account created successfully!');
                $this->redirect('/dashboard');
            } else {
                $errors['general'] = 'Email already registered';
            }
        }
        
        return $this->render('pages/signup.html.twig', [
            'errors' => $errors,
            'name' => $name,
            'email' => $email
        ]);
    }

    public function logout()
    {
        session_destroy();
        $this->redirect('/');
    }
}