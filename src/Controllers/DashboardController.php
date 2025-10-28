<?php

namespace App\Controllers;

use App\Models\Ticket;

class DashboardController extends BaseController
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
        
        $stats = $this->ticketModel->getStats();
        
        return $this->render('pages/dashboard.html.twig', [
            'stats' => $stats
        ]);
    }
}