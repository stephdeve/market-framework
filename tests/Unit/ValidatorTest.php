<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Framework\Validation\Validator;

class ValidatorTest extends TestCase {
    
    public function testRequiredRulePasses()
    {
        $validator = new Validator(['name' => 'John'], ['name' => 'required']);
        $this->assertFalse($validator->fails());
    }
    
    public function testRequiredRuleFails()
    {
        $validator = new Validator(['name' => ''], ['name' => 'required']);
        $this->assertTrue($validator->fails());
    }
    
    public function testEmailRulePasses()
    {
        $validator = new Validator(['email' => 'test@example.com'], ['email' => 'email']);
        $this->assertFalse($validator->fails());
    }
    
    public function testEmailRuleFails()
    {
        $validator = new Validator(['email' => 'invalid-email'], ['email' => 'email']);
        $this->assertTrue($validator->fails());
    }
    
    public function testMinRulePasses()
    {
        $validator = new Validator(['password' => 'longpassword'], ['password' => 'min:6']);
        $this->assertFalse($validator->fails());
    }
    
    public function testMinRuleFails()
    {
        $validator = new Validator(['password' => 'short'], ['password' => 'min:10']);
        $this->assertTrue($validator->fails());
    }
    
    public function testMaxRulePasses()
    {
        $validator = new Validator(['username' => 'john'], ['username' => 'max:10']);
        $this->assertFalse($validator->fails());
    }
    
    public function testMaxRuleFails()
    {
        $validator = new Validator(['username' => 'verylongusername'], ['username' => 'max:5']);
        $this->assertTrue($validator->fails());
    }
    
    public function testNumericRulePasses()
    {
        $validator = new Validator(['age' => '25'], ['age' => 'numeric']);
        $this->assertFalse($validator->fails());
    }
    
    public function testNumericRuleFails()
    {
        $validator = new Validator(['age' => 'twenty'], ['age' => 'numeric']);
        $this->assertTrue($validator->fails());
    }
    
    public function testSameRulePasses()
    {
        $data = ['password' => 'secret', 'password_confirmation' => 'secret'];
        $validator = new Validator($data, ['password_confirmation' => 'same:password']);
        $this->assertFalse($validator->fails());
    }
    
    public function testSameRuleFails()
    {
        $data = ['password' => 'secret', 'password_confirmation' => 'different'];
        $validator = new Validator($data, ['password_confirmation' => 'same:password']);
        $this->assertTrue($validator->fails());
    }
    
    public function testMultipleRules()
    {
        $data = ['email' => 'test@example.com', 'name' => 'John Doe'];
        $rules = ['email' => 'required|email', 'name' => 'required|min:3'];
        $validator = new Validator($data, $rules);
        $this->assertFalse($validator->fails());
    }
    
    public function testErrorMessages()
    {
        $validator = new Validator(['name' => ''], ['name' => 'required']);
        $this->assertTrue($validator->fails());
        
        $errors = $validator->errors();
        $this->assertArrayHasKey('name', $errors);
        $this->assertNotEmpty($errors['name']);
    }
}
