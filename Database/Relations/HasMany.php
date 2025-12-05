<?php
namespace Framework\Database\Relations;

use Framework\Database\QueryBuilder;

class HasMany extends Relation {
    
    /**
     * Get all related models
     */
    public function get(): array
    {
        $qb = new QueryBuilder($this->db);
        $relatedInstance = $this->getRelatedInstance();
        
        return $qb->table($relatedInstance->getTable())
                  ->where($this->foreignKey, '=', $this->getParentKey())
                  ->get();
    }
    
    /**
     * Get the first related model
     */
    public function first(): object|bool
    {
        $qb = new QueryBuilder($this->db);
        $relatedInstance = $this->getRelatedInstance();
        
        return $qb->table($relatedInstance->getTable())
                  ->where($this->foreignKey, '=', $this->getParentKey())
                  ->first();
    }
    
    /**
     * Create a new related model
     */
    public function create(array $data): bool
    {
        $data[$this->foreignKey] = $this->getParentKey();
        $relatedInstance = $this->getRelatedInstance();
        
        return $relatedInstance->create($data);
    }
}
