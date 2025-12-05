<?php
namespace App\Controllers;

use Framework\Core\Controller;

class HomeController extends Controller {
    
    public function index()
    {
        $this->view('home.index', [
            'title' => 'Welcome to Framework Demo',
            'message' => 'This is a demonstration of the PHP MVC Framework'
        ]);
    }
    
    public function about()
    {
        $this->view('home.about', [
            'title' => 'About Framework'
        ]);
    }
}
