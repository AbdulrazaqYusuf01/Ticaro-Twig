<?php

namespace App\Models;

use App\Database\Database;

class Ticket
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll()
    {
        return $this->db->read('tickets.json');
    }

    public function getById($id)
    {
        $tickets = $this->getAll();
        
        foreach ($tickets as $ticket) {
            if ($ticket['id'] == $id) {
                return $ticket;
            }
        }
        
        return null;
    }

    public function create($data)
    {
        $tickets = $this->getAll();
        
        $newTicket = [
            'id' => $this->getNextId(),
            'title' => $data['title'],
            'description' => $data['description'] ?? '',
            'status' => $data['status'] ?? 'open',
            'priority' => $data['priority'] ?? 'medium',
            'createdAt' => date('c')
        ];
        
        $tickets[] = $newTicket;
        $this->db->write('tickets.json', $tickets);
        
        return $newTicket;
    }

    public function update($id, $data)
    {
        $tickets = $this->getAll();
        
        foreach ($tickets as $key => $ticket) {
            if ($ticket['id'] == $id) {
                $tickets[$key]['title'] = $data['title'] ?? $ticket['title'];
                $tickets[$key]['description'] = $data['description'] ?? $ticket['description'];
                $tickets[$key]['status'] = $data['status'] ?? $ticket['status'];
                $tickets[$key]['priority'] = $data['priority'] ?? $ticket['priority'];
                
                $this->db->write('tickets.json', $tickets);
                return $tickets[$key];
            }
        }
        
        return null;
    }

    public function delete($id)
    {
        $tickets = $this->getAll();
        $filtered = array_filter($tickets, function($ticket) use ($id) {
            return $ticket['id'] != $id;
        });
        
        $this->db->write('tickets.json', array_values($filtered));
        return true;
    }

    public function getStats()
    {
        $tickets = $this->getAll();
        
        return [
            'total' => count($tickets),
            'open' => count(array_filter($tickets, fn($t) => $t['status'] === 'open')),
            'in_progress' => count(array_filter($tickets, fn($t) => $t['status'] === 'in_progress')),
            'closed' => count(array_filter($tickets, fn($t) => $t['status'] === 'closed'))
        ];
    }

    private function getNextId()
    {
        $tickets = $this->getAll();
        
        if (empty($tickets)) {
            return 1;
        }
        
        $maxId = max(array_column($tickets, 'id'));
        return $maxId + 1;
    }
}