<?php
namespace App\Controllers;

use Framework\Core\Controller;
use Framework\Core\Request;
use Framework\Validation\Validator;
use Framework\Auth\Auth;
use App\Models\User;

class UserController extends Controller {
    
    public function index()
    {
        $userModel = new User($this->db);
        $users = $userModel->all('id');
        
        $this->view('users.index', [
            'title' => 'Users List',
            'users' => $users
        ]);
    }
    
    public function show($id)
    {
        $userModel = new User($this->db);
        $user = $userModel->findById($id, 'id');
        
        if (!$user) {
            $_SESSION['error'] = 'User not found';
            $this->redirect('/users');
            return;
        }
        
        $this->view('users.show', [
            'title' => 'User Details',
            'user' => $user
        ]);
    }
    
    public function create()
    {
        $this->view('users.create', [
            'title' => 'Create User'
        ]);
    }
    
    public function store()
    {
        $request = new Request();
        
        $validator = new Validator($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email'
        ]);
        
        if ($validator->fails()) {
            $_SESSION['errors'] = $validator->errors();
            $_SESSION['old'] = $request->all();
            $this->redirect('/users/create');
            return;
        }
        
        $userModel = new User($this->db);
        
        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Auth::hash($request->input('password', 'password123'))
        ];
        
        if ($userModel->create($data)) {
            $_SESSION['success'] = 'User created successfully';
            $this->redirect('/users');
        } else {
            $_SESSION['error'] = 'Failed to create user';
            $this->redirect('/users/create');
        }
    }
}
