<?php
namespace Framework\Exceptions;

class AuthenticationException extends \Exception {
    
    public function __construct(string $message = "Authentication required")
    {
        parent::__construct($message, 401);
    }
}
