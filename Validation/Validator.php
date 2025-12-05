<?php
namespace Framework\Validation;

class Validator {
    private $data;
    private $rules;
    private $errors = [];
    private $customMessages = [];
    
    public function __construct(array $data, array $rules, array $customMessages = [])
    {
        $this->data = $data;
        $this->rules = $rules;
        $this->customMessages = $customMessages;
    }
    
    /**
     * Validate the data
     */
    public function validate(): bool
    {
        foreach ($this->rules as $field => $ruleSet) {
            $rules = is_string($ruleSet) ? explode('|', $ruleSet) : $ruleSet;
            
            foreach ($rules as $rule) {
                $this->applyRule($field, $rule);
            }
        }
        
        return empty($this->errors);
    }
    
    /**
     * Check if validation failed
     */
    public function fails(): bool
    {
        return !$this->validate();
    }
    
    /**
     * Get validation errors
     */
    public function errors(): array
    {
        return $this->errors;
    }
    
    /**
     * Apply a single validation rule
     */
    private function applyRule(string $field, string $rule): void
    {
        // Parse rule and parameters
        $parts = explode(':', $rule);
        $ruleName = $parts[0];
        $parameters = isset($parts[1]) ? explode(',', $parts[1]) : [];
        
        // Get field value
        $value = $this->data[$field] ?? null;
        
        // Apply the rule
        $method = 'validate' . ucfirst($ruleName);
        
        if (method_exists($this, $method)) {
            $isValid = $this->$method($field, $value, $parameters);
            
            if (!$isValid) {
                $this->addError($field, $ruleName, $parameters);
            }
        }
    }
    
    /**
     * Add an error message
     */
    private function addError(string $field, string $rule, array $parameters = []): void
    {
        $message = $this->getMessage($field, $rule, $parameters);
        
        if (!isset($this->errors[$field])) {
            $this->errors[$field] = [];
        }
        
        $this->errors[$field][] = $message;
    }
    
    /**
     * Get error message for a rule
     */
    private function getMessage(string $field, string $rule, array $parameters = []): string
    {
        $key = "$field.$rule";
        
        if (isset($this->customMessages[$key])) {
            return $this->customMessages[$key];
        }
        
        $messages = [
            'required' => "The $field field is required.",
            'email' => "The $field must be a valid email address.",
            'min' => "The $field must be at least {$parameters[0]} characters.",
            'max' => "The $field must not exceed {$parameters[0]} characters.",
            'numeric' => "The $field must be a number.",
            'integer' => "The $field must be an integer.",
            'alpha' => "The $field must contain only letters.",
            'alphanumeric' => "The $field must contain only letters and numbers.",
            'url' => "The $field must be a valid URL.",
            'confirmed' => "The $field confirmation does not match.",
            'same' => "The $field must match {$parameters[0]}.",
            'different' => "The $field must be different from {$parameters[0]}.",
            'in' => "The selected $field is invalid.",
            'notIn' => "The selected $field is invalid.",
            'unique' => "The $field has already been taken.",
            'exists' => "The selected $field is invalid.",
        ];
        
        return $messages[$rule] ?? "The $field is invalid.";
    }
    
    // Validation Rules
    
    protected function validateRequired(string $field, $value, array $parameters): bool
    {
        return !is_null($value) && $value !== '';
    }
    
    protected function validateEmail(string $field, $value, array $parameters): bool
    {
        if (is_null($value)) return true; // Only validate if present
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }
    
    protected function validateMin(string $field, $value, array $parameters): bool
    {
        if (is_null($value)) return true;
        $min = (int) $parameters[0];
        
        if (is_numeric($value)) {
            return $value >= $min;
        }
        
        return strlen($value) >= $min;
    }
    
    protected function validateMax(string $field, $value, array $parameters): bool
    {
        if (is_null($value)) return true;
        $max = (int) $parameters[0];
        
        if (is_numeric($value)) {
            return $value <= $max;
        }
        
        return strlen($value) <= $max;
    }
    
    protected function validateNumeric(string $field, $value, array $parameters): bool
    {
        if (is_null($value)) return true;
        return is_numeric($value);
    }
    
    protected function validateInteger(string $field, $value, array $parameters): bool
    {
        if (is_null($value)) return true;
        return filter_var($value, FILTER_VALIDATE_INT) !== false;
    }
    
    protected function validateAlpha(string $field, $value, array $parameters): bool
    {
        if (is_null($value)) return true;
        return ctype_alpha($value);
    }
    
    protected function validateAlphanumeric(string $field, $value, array $parameters): bool
    {
        if (is_null($value)) return true;
        return ctype_alnum($value);
    }
    
    protected function validateUrl(string $field, $value, array $parameters): bool
    {
        if (is_null($value)) return true;
        return filter_var($value, FILTER_VALIDATE_URL) !== false;
    }
    
    protected function validateConfirmed(string $field, $value, array $parameters): bool
    {
        $confirmField = $field . '_confirmation';
        return isset($this->data[$confirmField]) && $value === $this->data[$confirmField];
    }
    
    protected function validateSame(string $field, $value, array $parameters): bool
    {
        $otherField = $parameters[0];
        return isset($this->data[$otherField]) && $value === $this->data[$otherField];
    }
    
    protected function validateDifferent(string $field, $value, array $parameters): bool
    {
        $otherField = $parameters[0];
        return !isset($this->data[$otherField]) || $value !== $this->data[$otherField];
    }
    
    protected function validateIn(string $field, $value, array $parameters): bool
    {
        if (is_null($value)) return true;
        return in_array($value, $parameters);
    }
    
    protected function validateNotIn(string $field, $value, array $parameters): bool
    {
        if (is_null($value)) return true;
        return !in_array($value, $parameters);
    }
}
