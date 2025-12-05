<?php
namespace Framework\Database;

use Framework\Core\Database;

abstract class Seeder {
    protected $db;
    
    public function __construct(Database $db)
    {
        $this->db = $db;
    }
    
    /**
     * Run the database seeder
     */
    abstract public function run(): void;
    
    /**
     * Call another seeder
     */
    protected function call(string $seederClass): void
    {
        $seeder = new $seederClass($this->db);
        $seeder->run();
    }
    
    /**
     * Get database instance
     */
    protected function getDB(): Database
    {
        return $this->db;
    }
}
