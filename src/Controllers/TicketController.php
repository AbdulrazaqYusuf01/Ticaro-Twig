<?php

namespace App\Controllers;

use App\Models\Ticket;

class TicketController extends BaseController
{
    private $ticketModel;

    public function __construct($twig)
    {
        parent::__construct($twig);
        $this->ticketModel = new Ticket();
    }

    public function index()
    {
        $this->requireAuth();
        
        $tickets = $this->ticketModel->getAll();
        
        return $this->render('pages/tickets.html.twig', [
            'tickets' => $tickets,
            'editingTicket' => null
        ]);
    }

    public function create()
    {
        $this->requireAuth();
        
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $status = $_POST['status'] ?? 'open';
        $priority = $_POST['priority'] ?? 'medium';
        
        $errors = [];
        
        if (empty($title)) {
            $errors['title'] = 'Title is required';
        }
        
        if (!in_array($status, ['open', 'in_progress', 'closed'])) {
            $errors['status'] = 'Invalid status';
        }
        
        if (strlen($description) > 500) {
            $errors['description'] = 'Description must be less than 500 characters';
        }
        
        if (empty($errors)) {
            $this->ticketModel->create([
                'title' => $title,
                'description' => $description,
                'status' => $status,
                'priority' => $priority
            ]);
            
            $this->setFlash('success', 'Ticket created successfully!');
            $this->redirect('/tickets');
        }
        
        $tickets = $this->ticketModel->getAll();
        
        return $this->render('pages/tickets.html.twig', [
            'tickets' => $tickets,
            'errors' => $errors,
            'formData' => $_POST
        ]);
    }

    public function edit($id)
    {
        $this->requireAuth();
        
        $ticket = $this->ticketModel->getById($id);
        
        if (!$ticket) {
            $this->setFlash('error', 'Ticket not found');
            $this->redirect('/tickets');
        }
        
        $tickets = $this->ticketModel->getAll();
        
        return $this->render('pages/tickets.html.twig', [
            'tickets' => $tickets,
            'editingTicket' => $ticket
        ]);
    }

    public function update($id)
    {
        $this->requireAuth();
        
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $status = $_POST['status'] ?? 'open';
        $priority = $_POST['priority'] ?? 'medium';
        
        $errors = [];
        
        if (empty($title)) {
            $errors['title'] = 'Title is required';
        }
        
        if (!in_array($status, ['open', 'in_progress', 'closed'])) {
            $errors['status'] = 'Invalid status';
        }
        
        if (strlen($description) > 500) {
            $errors['description'] = 'Description must be less than 500 characters';
        }
        
        if (empty($errors)) {
            $this->ticketModel->update($id, [
                'title' => $title,
                'description' => $description,
                'status' => $status,
                'priority' => $priority
            ]);
            
            $this->setFlash('success', 'Ticket updated successfully!');
            $this->redirect('/tickets');
        }
        
        $tickets = $this->ticketModel->getAll();
        $editingTicket = $this->ticketModel->getById($id);
        
        return $this->render('pages/tickets.html.twig', [
            'tickets' => $tickets,
            'editingTicket' => $editingTicket,
            'errors' => $errors
        ]);
    }

    public function delete($id)
    {
        $this->requireAuth();
        
        $this->ticketModel->delete($id);
        $this->setFlash('success', 'Ticket deleted successfully!');
        $this->redirect('/tickets');
    }
}