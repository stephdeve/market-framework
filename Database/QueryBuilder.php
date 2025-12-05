<?php
namespace Framework\Database;

use Framework\Core\Database;
use PDO;

class QueryBuilder {
    private $db;
    private $table;
    private $select = '*';
    private $where = [];
    private $bindings = [];
    private $orderBy = [];
    private $limit;
    private $offset;
    private $joins = [];
    
    public function __construct(Database $db)
    {
        $this->db = $db;
    }
    
    /**
     * Set the table
     */
    public function table(string $table): self
    {
        $this->table = $table;
        return $this;
    }
    
    /**
     * Set the table (alias for table)
     */
    public function from(string $table): self
    {
        return $this->table($table);
    }
    
    /**
     * Set the columns to select
     */
    public function select($columns = '*'): self
    {
        $this->select = is_array($columns) ? implode(', ', $columns) : $columns;
        return $this;
    }
    
    /**
     * Add a WHERE clause
     */
    public function where(string $column, string $operator, $value): self
    {
        $this->where[] = "$column $operator ?";
        $this->bindings[] = $value;
        return $this;
    }
    
    /**
     * Add an OR WHERE clause
     */
    public function orWhere(string $column, string $operator, $value): self
    {
        $connector = empty($this->where) ? '' : ' OR ';
        $this->where[] = $connector . "$column $operator ?";
        $this->bindings[] = $value;
        return $this;
    }
    
    /**
     * Add WHERE IN clause
     */
    public function whereIn(string $column, array $values): self
    {
        $placeholders = implode(',', array_fill(0, count($values), '?'));
        $this->where[] = "$column IN ($placeholders)";
        $this->bindings = array_merge($this->bindings, $values);
        return $this;
    }
    
    /**
     * Add WHERE NULL clause
     */
    public function whereNull(string $column): self
    {
        $this->where[] = "$column IS NULL";
        return $this;
    }
    
    /**
     * Add WHERE NOT NULL clause
     */
    public function whereNotNull(string $column): self
    {
        $this->where[] = "$column IS NOT NULL";
        return $this;
    }
    
    /**
     * Add a JOIN clause
     */
    public function join(string $table, string $first, string $operator, string $second, string $type = 'INNER'): self
    {
        $this->joins[] = "$type JOIN $table ON $first $operator $second";
        return $this;
    }
    
    /**
     * Add a LEFT JOIN clause
     */
    public function leftJoin(string $table, string $first, string $operator, string $second): self
    {
        return $this->join($table, $first, $operator, $second, 'LEFT');
    }
    
    /**
     * Add a RIGHT JOIN clause
     */
    public function rightJoin(string $table, string $first, string $operator, string $second): self
    {
        return $this->join($table, $first, $operator, $second, 'RIGHT');
    }
    
    /**
     * Add ORDER BY clause
     */
    public function orderBy(string $column, string $direction = 'ASC'): self
    {
        $this->orderBy[] = "$column $direction";
        return $this;
    }
    
    /**
     * Set LIMIT
     */
    public function limit(int $limit): self
    {
        $this->limit = $limit;
        return $this;
    }
    
    /**
     * Set OFFSET
     */
    public function offset(int $offset): self
    {
        $this->offset = $offset;
        return $this;
    }
    
    /**
     * Build the SELECT query
     */
    private function buildSelectQuery(): string
    {
        $sql = "SELECT {$this->select} FROM {$this->table}";
        
        if (!empty($this->joins)) {
            $sql .= ' ' . implode(' ', $this->joins);
        }
        
        if (!empty($this->where)) {
            $sql .= ' WHERE ' . implode(' AND ', $this->where);
        }
        
        if (!empty($this->orderBy)) {
            $sql .= ' ORDER BY ' . implode(', ', $this->orderBy);
        }
        
        if ($this->limit) {
            $sql .= " LIMIT {$this->limit}";
        }
        
        if ($this->offset) {
            $sql .= " OFFSET {$this->offset}";
        }
        
        return $sql;
    }
    
    /**
     * Get all results
     */
    public function get(): array
    {
        $sql = $this->buildSelectQuery();
        $stmt = $this->db->getPDO()->prepare($sql);
        $stmt->execute($this->bindings);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    
    /**
     * Get first result
     */
    public function first()
    {
        $this->limit(1);
        $sql = $this->buildSelectQuery();
        $stmt = $this->db->getPDO()->prepare($sql);
        $stmt->execute($this->bindings);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
    
    /**
     * Get count
     */
    public function count(): int
    {
        $this->select = 'COUNT(*) as count';
        $result = $this->first();
        return $result ? (int) $result->count : 0;
    }
    
    /**
     * Insert data
     */
    public function insert(array $data): bool
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        
        $sql = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
        $stmt = $this->db->getPDO()->prepare($sql);
        
        return $stmt->execute(array_values($data));
    }
    
    /**
     * Update data
     */
    public function update(array $data): bool
    {
        $sets = [];
        $values = [];
        
        foreach ($data as $column => $value) {
            $sets[] = "$column = ?";
            $values[] = $value;
        }
        
        $sql = "UPDATE {$this->table} SET " . implode(', ', $sets);
        
        if (!empty($this->where)) {
            $sql .= ' WHERE ' . implode(' AND ', $this->where);
            $values = array_merge($values, $this->bindings);
        }
        
        $stmt = $this->db->getPDO()->prepare($sql);
        return $stmt->execute($values);
    }
    
    /**
     * Delete data
     */
    public function delete(): bool
    {
        $sql = "DELETE FROM {$this->table}";
        
        if (!empty($this->where)) {
            $sql .= ' WHERE ' . implode(' AND ', $this->where);
        }
        
        $stmt = $this->db->getPDO()->prepare($sql);
        return $stmt->execute($this->bindings);
    }
    
    /**
     * Execute raw SQL
     */
    public function raw(string $sql, array $bindings = []): array
    {
        $stmt = $this->db->getPDO()->prepare($sql);
        $stmt->execute($bindings);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
