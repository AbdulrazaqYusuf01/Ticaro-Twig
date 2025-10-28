<?php

namespace App\Models;

use App\Database\Database;

class User
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function authenticate($email, $password)
    {
        // Demo authentication
        $config = require __DIR__ . '/../../config/config.php';
        
        if ($email === $config['demo_credentials']['email'] && 
            $password === $config['demo_credentials']['password']) {
            return [
                'id' => 1,
                'email' => $email,
                'name' => 'Demo User'
            ];
        }
        
        // Check registered users
        $users = $this->db->read('users.json');
        
        foreach ($users as $user) {
            if ($user['email'] === $email && password_verify($password, $user['password'])) {
                unset($user['password']);
                return $user;
            }
        }
        
        return false;
    }

    public function register($name, $email, $password)
    {
        $users = $this->db->read('users.json');
        
        // Check if user already exists
        foreach ($users as $user) {
            if ($user['email'] === $email) {
                return false;
            }
        }
        
        $newUser = [
            'id' => count($users) + 1,
            'name' => $name,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'createdAt' => date('c')
        ];
        
        $users[] = $newUser;
        $this->db->write('users.json', $users);
        
        unset($newUser['password']);
        return $newUser;
    }
}