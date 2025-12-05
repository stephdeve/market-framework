<?php
namespace Framework\Auth;

use Framework\Core\Database;
use Framework\Core\Model;

class Auth {
    private $db;
    private $userModel;
    
    public function __construct(Database $db, string $userModel = 'App\\Models\\User')
    {
        $this->db = $db;
        $this->userModel = $userModel;
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    /**
     * Attempt to log in a user
     */
    public function attempt(string $email, string $password): bool
    {
        $model = new $this->userModel($this->db);
        
        // Find user by email
        $user = $model->query(
            "SELECT * FROM users WHERE email = ?", 
            [$email], 
            true
        );
        
        if (!$user) {
            return false;
        }
        
        // Verify password
        if (!password_verify($password, $user->password)) {
            return false;
        }
        
        // Set session
        $this->login($user);
        
        return true;
    }
    
    /**
     * Log in a user (set session)
     */
    public function login($user): void
    {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->name ?? null;
    }
    
    /**
     * Log out the current user
     */
    public function logout(): void
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        
        // Optionally destroy the entire session
        // session_destroy();
    }
    
    /**
     * Check if a user is authenticated
     */
    public function check(): bool
    {
        return isset($_SESSION['user_id']);
    }
    
    /**
     * Check if user is a guest (not authenticated)
     */
    public function guest(): bool
    {
        return !$this->check();
    }
    
    /**
     * Get the currently authenticated user
     */
    public function user()
    {
        if (!$this->check()) {
            return null;
        }
        
        $model = new $this->userModel($this->db);
        return $model->findById($_SESSION['user_id'], 'id');
    }
    
    /**
     * Get the current user's ID
     */
    public function id(): ?int
    {
        return $_SESSION['user_id'] ?? null;
    }
    
    /**
     * Hash a password
     */
    public static function hash(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
    
    /**
     * Verify a password against a hash
     */
    public static function verify(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }
    
    /**
     * Register a new user
     */
    public function register(array $data): bool
    {
        // Hash the password
        if (isset($data['password'])) {
            $data['password'] = self::hash($data['password']);
        }
        
        $model = new $this->userModel($this->db);
        
        try {
            return $model->create($data);
        } catch (\Exception $e) {
            return false;
        }
    }
}
