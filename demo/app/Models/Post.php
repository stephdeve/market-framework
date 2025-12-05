<?php
namespace App\Models;

use Framework\Core\Model;

#[AllowDynamicProperties]
class Post extends Model {
    protected $table = 'posts';
    
    /**
     * Get the user that owns the post
     */
    public function user()
    {
        return $this->belongsTo('App\\Models\\User', 'user_id', 'id');
    }
}
