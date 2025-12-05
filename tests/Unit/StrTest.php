<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Framework\Helpers\Str;

class StrTest extends TestCase {
    
    public function testSlugify()
    {
        $this->assertEquals('hello-world', Str::slugify('Hello World'));
        $this->assertEquals('hello-world', Str::slugify('Hello  World!'));
    }
    
    public function testCamelCase()
    {
        $this->assertEquals('helloWorld', Str::camelCase('hello_world'));
        $this->assertEquals('helloWorld', Str::camelCase('hello-world'));
    }
    
    public function testSnakeCase()
    {
        $this->assertEquals('hello_world', Str::snakeCase('HelloWorld'));
        $this->assertEquals('hello_world', Str::snakeCase('helloWorld'));
    }
    
    public function testKebabCase()
    {
        $this->assertEquals('hello-world', Str::kebabCase('HelloWorld'));
        $this->assertEquals('hello-world', Str::kebabCase('hello_world'));
    }
    
    public function testPascalCase()
    {
        $this->assertEquals('HelloWorld', Str::pascalCase('hello_world'));
        $this->assertEquals('HelloWorld', Str::pascalCase('hello-world'));
    }
    
    public function testTruncate()
    {
        $this->assertEquals('Hello...', Str::truncate('Hello World', 5));
        $this->assertEquals('Hello', Str::truncate('Hello', 10));
    }
    
    public function testStartsWith()
    {
        $this->assertTrue(Str::startsWith('Hello World', 'Hello'));
        $this->assertFalse(Str::startsWith('Hello World', 'World'));
    }
    
    public function testEndsWith()
    {
        $this->assertTrue(Str::endsWith('Hello World', 'World'));
        $this->assertFalse(Str::endsWith('Hello World', 'Hello'));
    }
    
    public function testContains()
    {
        $this->assertTrue(Str::contains('Hello World', 'World'));
        $this->assertFalse(Str::contains('Hello World', 'Foo'));
    }
    
    public function testRandom()
    {
        $random = Str::random(10);
        $this->assertEquals(10, strlen($random));
        
        $random2 = Str::random(10);
        $this->assertNotEquals($random, $random2);
    }
}
