<?php
namespace App\Models;

use Framework\Core\Model;

#[AllowDynamicProperties]
class User extends Model {
    protected $table = 'users';
    
    /**
     * Find a user by email
     */
    public function findByEmail(string $email)
    {
        return $this->query("SELECT * FROM {$this->table} WHERE email = ?", [$email], true);
    }
    
    /**
     * Check if email exists
     */
    public function emailExists(string $email): bool
    {
        $user = $this->findByEmail($email);
        return $user !== false && $user !== null;
    }
    
    /**
     * Get all posts for this user
     */
    public function posts()
    {
        return $this->hasMany('App\\Models\\Post', 'user_id', 'id');
    }
}
