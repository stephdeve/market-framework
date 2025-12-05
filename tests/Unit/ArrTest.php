<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Framework\Helpers\Arr;

class ArrTest extends TestCase {
    
    public function testGet()
    {
        $array = ['user' => ['name' => 'John', 'age' => 25]];
        $this->assertEquals('John', Arr::get($array, 'user.name'));
        $this->assertEquals(25, Arr::get($array, 'user.age'));
        $this->assertNull(Arr::get($array, 'user.email'));
    }
    
    public function testGetWithDefault()
    {
        $array = ['user' => ['name' => 'John']];
        $this->assertEquals('default', Arr::get($array, 'user.email', 'default'));
    }
    
    public function testSet()
    {
        $array = [];
        Arr::set($array, 'user.name', 'John');
        $this->assertEquals('John', $array['user']['name']);
    }
    
    public function testHas()
    {
        $array = ['user' => ['name' => 'John']];
        $this->assertTrue(Arr::has($array, 'user.name'));
        $this->assertFalse(Arr::has($array, 'user.email'));
    }
    
    public function testForget()
    {
        $array = ['user' => ['name' => 'John', 'age' => 25]];
        Arr::forget($array, 'user.age');
        $this->assertFalse(isset($array['user']['age']));
        $this->assertTrue(isset($array['user']['name']));
    }
    
    public function testOnly()
    {
        $array = ['name' => 'John', 'age' => 25, 'email' => 'john@example.com'];
        $result = Arr::only($array, ['name', 'email']);
        $this->assertArrayHasKey('name', $result);
        $this->assertArrayHasKey('email', $result);
        $this->assertArrayNotHasKey('age', $result);
    }
    
    public function testExcept()
    {
        $array = ['name' => 'John', 'age' => 25, 'email' => 'john@example.com'];
        $result = Arr::except($array, ['age']);
        $this->assertArrayHasKey('name', $result);
        $this->assertArrayHasKey('email', $result);
        $this->assertArrayNotHasKey('age', $result);
    }
    
    public function testPluck()
    {
        $array = [
            ['id' => 1, 'name' => 'John'],
            ['id' => 2, 'name' => 'Jane'],
            ['id' => 3, 'name' => 'Bob']
        ];
        $result = Arr::pluck($array, 'name');
        $this->assertEquals(['John', 'Jane', 'Bob'], $result);
    }
    
    public function testFlatten()
    {
        $array = [1, [2, 3], [4, [5, 6]]];
        $result = Arr::flatten($array);
        $this->assertEquals([1, 2, 3, 4, 5, 6], $result);
    }
    
    public function testWhere()
    {
        $array = [
            ['id' => 1, 'status' => 'active'],
            ['id' => 2, 'status' => 'inactive'],
            ['id' => 3, 'status' => 'active']
        ];
        $result = Arr::where($array, 'status', 'active');
        $this->assertCount(2, $result);
    }
}
