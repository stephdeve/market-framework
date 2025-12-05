<?php
namespace Framework\Database;

use Framework\Core\Database;

abstract class Migration {
    protected $db;
    
    public function __construct(Database $db)
    {
        $this->db = $db;
    }
    
    /**
     * Run the migration
     */
    abstract public function up(): void;
    
    /**
     * Reverse the migration
     */
    abstract public function down(): void;
    
    /**
     * Create a new table
     */
    protected function createTable(string $tableName, callable $callback): void
    {
        $schema = new Schema($this->db, $tableName);
        $callback($schema);
        $schema->create();
    }
    
    /**
     * Drop a table
     */
    protected function dropTable(string $tableName): void
    {
        $sql = "DROP TABLE IF EXISTS $tableName";
        $this->db->getPDO()->exec($sql);
    }
    
    /**
     * Check if table exists
     */
    protected function tableExists(string $tableName): bool
    {
        $sql = "SHOW TABLES LIKE ?";
        $stmt = $this->db->getPDO()->prepare($sql);
        $stmt->execute([$tableName]);
        return $stmt->rowCount() > 0;
    }
}

/**
 * Schema builder for migrations
 */
class Schema {
    private $db;
    private $tableName;
    private $columns = [];
    
    public function __construct(Database $db, string $tableName)
    {
        $this->db = $db;
        $this->tableName = $tableName;
    }
    
    public function id(string $name = 'id'): self
    {
        $this->columns[] = "$name INT AUTO_INCREMENT PRIMARY KEY";
        return $this;
    }
    
    public function string(string $name, int $length = 255): self
    {
        $this->columns[] = "$name VARCHAR($length)";
        return $this;
    }
    
    public function text(string $name): self
    {
        $this->columns[] = "$name TEXT";
        return $this;
    }
    
    public function integer(string $name): self
    {
        $this->columns[] = "$name INT";
        return $this;
    }
    
    public function bigInteger(string $name): self
    {
        $this->columns[] = "$name BIGINT";
        return $this;
    }
    
    public function decimal(string $name, int $precision = 10, int $scale = 2): self
    {
        $this->columns[] = "$name DECIMAL($precision, $scale)";
        return $this;
    }
    
    public function boolean(string $name): self
    {
        $this->columns[] = "$name TINYINT(1)";
        return $this;
    }
    
    public function date(string $name): self
    {
        $this->columns[] = "$name DATE";
        return $this;
    }
    
    public function datetime(string $name): self
    {
        $this->columns[] = "$name DATETIME";
        return $this;
    }
    
    public function timestamp(string $name): self
    {
        $this->columns[] = "$name TIMESTAMP";
        return $this;
    }
    
    public function timestamps(): self
    {
        $this->columns[] = "created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
        $this->columns[] = "updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP";
        return $this;
    }
    
    public function nullable(): self
    {
        $lastIndex = count($this->columns) - 1;
        $this->columns[$lastIndex] .= " NULL";
        return $this;
    }
    
    public function unique(): self
    {
        $lastIndex = count($this->columns) - 1;
        $this->columns[$lastIndex] .= " UNIQUE";
        return $this;
    }
    
    public function default($value): self
    {
        $lastIndex = count($this->columns) - 1;
        $defaultValue = is_string($value) ? "'$value'" : $value;
        $this->columns[$lastIndex] .= " DEFAULT $defaultValue";
        return $this;
    }
    
    public function create(): void
    {
        $columnsSql = implode(', ', $this->columns);
        $sql = "CREATE TABLE {$this->tableName} ($columnsSql)";
        $this->db->getPDO()->exec($sql);
    }
}
