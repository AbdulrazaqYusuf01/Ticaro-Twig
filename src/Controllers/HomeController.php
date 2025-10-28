<?php

namespace App\Controllers;

class HomeController extends BaseController
{
    public function index()
    {
        return $this->render('pages/landing.html.twig');
    }
}