<?php

namespace App\Database;

class Database
{
    private static $instance = null;
    private $storagePath;

    private function __construct()
    {
        $this->storagePath = __DIR__ . '/../../storage/';
        
        // Create storage directory if it doesn't exist
        if (!is_dir($this->storagePath)) {
            mkdir($this->storagePath, 0777, true);
        }
        
        // Initialize empty files if they don't exist
        $this->initializeStorage();
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function initializeStorage()
    {
        $files = ['tickets.json', 'users.json', 'sessions.json'];
        
        foreach ($files as $file) {
            $filepath = $this->storagePath . $file;
            if (!file_exists($filepath)) {
                file_put_contents($filepath, json_encode([]));
            }
        }
        
        // Initialize default tickets
        $ticketsFile = $this->storagePath . 'tickets.json';
        $tickets = json_decode(file_get_contents($ticketsFile), true);
        
        if (empty($tickets)) {
            $defaultTickets = [
                [
                    'id' => 1,
                    'title' => 'Login page not loading',
                    'description' => 'Users are reporting that the login page is not loading properly on mobile devices.',
                    'status' => 'open',
                    'priority' => 'high',
                    'createdAt' => '2025-10-20T10:30:00.000Z'
                ],
                [
                    'id' => 2,
                    'title' => 'Dashboard shows incorrect statistics',
                    'description' => "The ticket count on the dashboard doesn't match the actual number of tickets.",
                    'status' => 'in_progress',
                    'priority' => 'medium',
                    'createdAt' => '2025-10-22T14:15:00.000Z'
                ],
                [
                    'id' => 3,
                    'title' => 'Email notifications not working',
                    'description' => 'Users are not receiving email notifications when tickets are updated.',
                    'status' => 'closed',
                    'priority' => 'high',
                    'createdAt' => '2025-10-18T09:00:00.000Z'
                ],
                [
                    'id' => 4,
                    'title' => 'Add dark mode feature',
                    'description' => 'Request to add a dark mode toggle for better user experience during night time.',
                    'status' => 'open',
                    'priority' => 'low',
                    'createdAt' => '2025-10-25T16:45:00.000Z'
                ]
            ];
            
            file_put_contents($ticketsFile, json_encode($defaultTickets, JSON_PRETTY_PRINT));
        }
    }

    public function read($filename)
    {
        $filepath = $this->storagePath . $filename;
        if (!file_exists($filepath)) {
            return [];
        }
        
        $content = file_get_contents($filepath);
        return json_decode($content, true) ?? [];
    }

    public function write($filename, $data)
    {
        $filepath = $this->storagePath . $filename;
        return file_put_contents($filepath, json_encode($data, JSON_PRETTY_PRINT));
    }
}