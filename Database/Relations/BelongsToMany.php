<?php
namespace Framework\Database\Relations;

use Framework\Database\QueryBuilder;

class BelongsToMany extends Relation {
    protected $pivotTable;
    protected $foreignPivotKey;
    protected $relatedPivotKey;
    
    public function __construct(
        $db, 
        $parent, 
        string $related, 
        string $pivotTable,
        string $foreignPivotKey,
        string $relatedPivotKey,
        string $localKey = 'id'
    ) {
        $this->pivotTable = $pivotTable;
        $this->foreignPivotKey = $foreignPivotKey;
        $this->relatedPivotKey = $relatedPivotKey;
        
        parent::__construct($db, $parent, $related, $foreignPivotKey, $localKey);
    }
    
    /**
     * Get all related models through pivot table
     */
    public function get(): array
    {
        $relatedInstance = $this->getRelatedInstance();
        $relatedTable = $relatedInstance->getTable();
        
        $sql = "SELECT {$relatedTable}.* FROM {$relatedTable}
                INNER JOIN {$this->pivotTable} 
                ON {$relatedTable}.{$this->localKey} = {$this->pivotTable}.{$this->relatedPivotKey}
                WHERE {$this->pivotTable}.{$this->foreignPivotKey} = ?";
        
        $stmt = $this->db->getPDO()->prepare($sql);
        $stmt->execute([$this->getParentKey()]);
        
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }
    
    /**
     * Get the first related model
     */
    public function first(): object|bool
    {
        $results = $this->get();
        return $results[0] ?? false;
    }
    
    /**
     * Attach a model to the relationship
     */
    public function attach($id): bool
    {
        $qb = new QueryBuilder($this->db);
        
        return $qb->table($this->pivotTable)->insert([
            $this->foreignPivotKey => $this->getParentKey(),
            $this->relatedPivotKey => $id
        ]);
    }
    
    /**
     * Detach a model from the relationship
     */
    public function detach($id = null): bool
    {
        $qb = new QueryBuilder($this->db);
        
        $query = $qb->table($this->pivotTable)
                    ->where($this->foreignPivotKey, '=', $this->getParentKey());
        
        if ($id !== null) {
            $query->where($this->relatedPivotKey, '=', $id);
        }
        
        return $query->delete();
    }
    
    /**
     * Sync the relationship with the given IDs
     */
    public function sync(array $ids): void
    {
        $this->detach();
        
        foreach ($ids as $id) {
            $this->attach($id);
        }
    }
}
