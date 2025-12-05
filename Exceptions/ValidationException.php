<?php
namespace Framework\Exceptions;

class ValidationException extends \Exception {
    private $errors;
    
    public function __construct(array $errors, string $message = "Validation failed")
    {
        parent::__construct($message);
        $this->errors = $errors;
    }
    
    public function getErrors(): array
    {
        return $this->errors;
    }
    
    public function getFirstError(): ?string
    {
        foreach ($this->errors as $field => $messages) {
            return is_array($messages) ? $messages[0] : $messages;
        }
        return null;
    }
}
