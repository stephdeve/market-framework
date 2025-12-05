<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Framework\Config\Config;

class ConfigTest extends TestCase {
    
    protected function setUp(): void
    {
        // Clear config before each test
        Config::set('test', null);
    }
    
    public function testSetAndGet()
    {
        Config::set('app.name', 'Test App');
        $this->assertEquals('Test App', Config::get('app.name'));
    }
    
    public function testGetWithDefault()
    {
        $this->assertEquals('default', Config::get('non.existent', 'default'));
    }
    
    public function testNestedConfig()
    {
        Config::set('database.mysql.host', 'localhost');
        Config::set('database.mysql.port', 3306);
        
        $this->assertEquals('localhost', Config::get('database.mysql.host'));
        $this->assertEquals(3306, Config::get('database.mysql.port'));
    }
    
    public function testHas()
    {
        Config::set('app.debug', true);
        $this->assertTrue(Config::has('app.debug'));
        $this->assertFalse(Config::has('app.nonexistent'));
    }
    
    public function testAll()
    {
        Config::set('test.key1', 'value1');
        Config::set('test.key2', 'value2');
        
        $all = Config::all();
        $this->assertIsArray($all);
    }
}
