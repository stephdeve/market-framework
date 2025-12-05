<?php
namespace Framework\Database\Relations;

use Framework\Core\Database;

abstract class Relation {
    protected $db;
    protected $parent;
    protected $related;
    protected $foreignKey;
    protected $localKey;
    
    public function __construct(Database $db, $parent, string $related, string $foreignKey, string $localKey)
    {
        $this->db = $db;
        $this->parent = $parent;
        $this->related = $related;
        $this->foreignKey = $foreignKey;
        $this->localKey = $localKey;
    }
    
    /**
     * Get the results of the relationship
     */
    abstract public function get();
    
    /**
     * Get the first result
     */
    abstract public function first();
    
    /**
     * Add a where constraint to the relation
     */
    public function where(string $column, string $operator, $value): self
    {
        // We'll implement this with QueryBuilder integration later
        return $this;
    }
    
    /**
     * Get related model instance
     */
    protected function getRelatedInstance()
    {
        return new $this->related($this->db);
    }
    
    /**
     * Get the parent key value
     */
    protected function getParentKey()
    {
        return $this->parent->{$this->localKey};
    }
}
