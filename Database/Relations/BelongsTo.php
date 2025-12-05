<?php
namespace Framework\Database\Relations;

use Framework\Database\QueryBuilder;

class BelongsTo extends Relation {
    
    /**
     * Get the related model (returns single object)
     */
    public function get(): object|bool
    {
        return $this->first();
    }
    
    /**
     * Get the related model
     */
    public function first(): object|bool
    {
        $qb = new QueryBuilder($this->db);
        $relatedInstance = $this->getRelatedInstance();
        $foreignKeyValue = $this->parent->{$this->foreignKey};
        
        if (!$foreignKeyValue) {
            return false;
        }
        
        return $qb->table($relatedInstance->getTable())
                  ->where($this->localKey, '=', $foreignKeyValue)
                  ->first();
    }
    
    /**
     * Associate the model with the given model
     */
    public function associate($model): void
    {
        $this->parent->{$this->foreignKey} = $model->{$this->localKey};
    }
    
    /**
     * Dissociate the model from its parent
     */
    public function dissociate(): void
    {
        $this->parent->{$this->foreignKey} = null;
    }
}
