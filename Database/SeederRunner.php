<?php
namespace Framework\Database;

use Framework\Core\Database;

class SeederRunner {
    protected $db;
    protected $seedersPath;
    
    public function __construct(Database $db, string $seedersPath)
    {
        $this->db = $db;
        $this->seedersPath = $seedersPath;
    }
    
    /**
     * Run a specific seeder
     */
    public function seed(string $seederClass): void
    {
        echo "Seeding: {$seederClass}\n";
        
        $seeder = new $seederClass($this->db);
        $seeder->run();
        
        echo "Seeded: {$seederClass}\n";
    }
    
    /**
     * Run all seeders in the seeders directory
     */
    public function seedAll(): void
    {
        $files = glob($this->seedersPath . '/*.php');
        
        foreach ($files as $file) {
            require_once $file;
            
            $className = pathinfo($file, PATHINFO_FILENAME);
            
            if (class_exists($className)) {
                $this->seed($className);
            }
        }
    }
}
