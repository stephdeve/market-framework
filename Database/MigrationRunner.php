<?php
namespace Framework\Database;

use Framework\Core\Database;

class MigrationRunner {
    private $db;
    private $migrationsPath;
    
    public function __construct(Database $db, string $migrationsPath)
    {
        $this->db = $db;
        $this->migrationsPath = $migrationsPath;
        $this->createMigrationsTable();
    }
    
    /**
     * Create migrations tracking table
     */
    private function createMigrationsTable(): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255) NOT NULL,
            batch INT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $this->db->getPDO()->exec($sql);
    }
    
    /**
     * Run all pending migrations
     */
    public function migrate(): void
    {
        $migrations = $this->getPendingMigrations();
        
        if (empty($migrations)) {
            echo "No migrations to run.\n";
            return;
        }
        
        $batch = $this->getNextBatchNumber();
        
        foreach ($migrations as $migrationFile) {
            $this->runMigration($migrationFile, $batch);
        }
        
        echo count($migrations) . " migration(s) completed.\n";
    }
    
    /**
     * Rollback the last batch of migrations
     */
    public function rollback(): void
    {
        $lastBatch = $this->getLastBatchNumber();
        
        if (!$lastBatch) {
            echo "Nothing to rollback.\n";
            return;
        }
        
        $migrations = $this->getMigrationsByBatch($lastBatch);
        
        foreach (array_reverse($migrations) as $migration) {
            $this->rollbackMigration($migration);
        }
        
        echo count($migrations) . " migration(s) rolled back.\n";
    }
    
    /**
     * Get all migration files
     */
    private function getAllMigrationFiles(): array
    {
        if (!is_dir($this->migrationsPath)) {
            return [];
        }
        
        $files = scandir($this->migrationsPath);
        $migrations = [];
        
        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                $migrations[] = $file;
            }
        }
        
        sort($migrations);
        return $migrations;
    }
    
    /**
     * Get pending migrations
     */
    private function getPendingMigrations(): array
    {
        $allMigrations = $this->getAllMigrationFiles();
        $ranMigrations = $this->getRanMigrations();
        
        return array_diff($allMigrations, $ranMigrations);
    }
    
    /**
     * Get migrations that have been run
     */
    private function getRanMigrations(): array
    {
        $stmt = $this->db->getPDO()->query("SELECT migration FROM migrations");
        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }
    
    /**
     * Get next batch number
     */
    private function getNextBatchNumber(): int
    {
        $stmt = $this->db->getPDO()->query("SELECT MAX(batch) as batch FROM migrations");
        $result = $stmt->fetch(\PDO::FETCH_OBJ);
        return ($result->batch ?? 0) + 1;
    }
    
    /**
     * Get last batch number
     */
    private function getLastBatchNumber(): ?int
    {
        $stmt = $this->db->getPDO()->query("SELECT MAX(batch) as batch FROM migrations");
        $result = $stmt->fetch(\PDO::FETCH_OBJ);
        return $result->batch ?? null;
    }
    
    /**
     * Get migrations by batch
     */
    private function getMigrationsByBatch(int $batch): array
    {
        $stmt = $this->db->getPDO()->prepare("SELECT migration FROM migrations WHERE batch = ?");
        $stmt->execute([$batch]);
        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }
    
    /**
     * Run a single migration
     */
    private function runMigration(string $migrationFile, int $batch): void
    {
        require_once $this->migrationsPath . DIRECTORY_SEPARATOR . $migrationFile;
        
        $className = $this->getMigrationClassName($migrationFile);
        $migration = new $className($this->db);
        
        echo "Migrating: $migrationFile\n";
        $migration->up();
        
        // Record migration
        $stmt = $this->db->getPDO()->prepare("INSERT INTO migrations (migration, batch) VALUES (?, ?)");
        $stmt->execute([$migrationFile, $batch]);
        
        echo "Migrated: $migrationFile\n";
    }
    
    /**
     * Rollback a single migration
     */
    private function rollbackMigration(string $migrationFile): void
    {
        require_once $this->migrationsPath . DIRECTORY_SEPARATOR . $migrationFile;
        
        $className = $this->getMigrationClassName($migrationFile);
        $migration = new $className($this->db);
        
        echo "Rolling back: $migrationFile\n";
        $migration->down();
        
        // Remove from migrations table
        $stmt = $this->db->getPDO()->prepare("DELETE FROM migrations WHERE migration = ?");
        $stmt->execute([$migrationFile]);
        
        echo "Rolled back: $migrationFile\n";
    }
    
    /**
     * Get migration class name from file name
     */
    private function getMigrationClassName(string $filename): string
    {
        // Remove .php extension and numbers/underscores from beginning
        $name = pathinfo($filename, PATHINFO_FILENAME);
        $name = preg_replace('/^\d+_/', '', $name);
        
        // Convert to PascalCase
        $parts = explode('_', $name);
        $className = implode('', array_map('ucfirst', $parts));
        
        return $className;
    }
}
