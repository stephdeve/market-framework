<?php
namespace App\Controllers;

use Framework\Core\Controller;
use Framework\Core\Request;
use Framework\Validation\Validator;
use Framework\Auth\Auth;
use App\Models\User;

class AuthController extends Controller {
    
    public function showLogin()
    {
        $this->view('auth.login', [
            'title' => 'Login'
        ]);
    }
    
    public function login()
    {
        $request = new Request();
        
        $validator = new Validator($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        if ($validator->fails()) {
            $_SESSION['errors'] = $validator->errors();
            $this->redirect('/login');
            return;
        }
        
        $auth = new Auth($this->db);
        
        if ($auth->attempt($request->input('email'), $request->input('password'))) {
            $this->redirect('/users');
        } else {
            $_SESSION['errors'] = ['auth' => ['Invalid credentials']];
            $this->redirect('/login');
        }
    }
    
    public function showRegister()
    {
        $this->view('auth.register', [
            'title' => 'Register'
        ]);
    }
    
    public function register()
    {
        $request = new Request();
        
        $validator = new Validator($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password'
        ]);
        
        if ($validator->fails()) {
            $_SESSION['errors'] = $validator->errors();
            $_SESSION['old'] = $request->except(['password', 'password_confirmation']);
            $this->redirect('/register');
            return;
        }
        
        $auth = new Auth($this->db);
        
        if ($auth->register($request->only(['name', 'email', 'password']))) {
            $_SESSION['success'] = 'Account created successfully! Please login.';
            $this->redirect('/login');
        } else {
            $_SESSION['errors'] = ['registration' => ['Registration failed']];
            $this->redirect('/register');
        }
    }
    
    public function logout()
    {
        $auth = new Auth($this->db);
        $auth->logout();
        $this->redirect('/');
    }
}
