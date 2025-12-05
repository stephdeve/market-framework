<?php
namespace Framework\Database\Traits;

use Framework\Database\Relations\HasMany;
use Framework\Database\Relations\BelongsTo;
use Framework\Database\Relations\HasOne;
use Framework\Database\Relations\BelongsToMany;

trait HasRelationships {
    
    /**
     * Define a one-to-many relationship
     */
    protected function hasMany(string $related, string $foreignKey = null, string $localKey = 'id'): HasMany
    {
        if ($foreignKey === null) {
            $foreignKey = strtolower(class_basename(get_class($this))) . '_id';
        }
        
        return new HasMany($this->db, $this, $related, $foreignKey, $localKey);
    }
    
    /**
     * Define an inverse one-to-many relationship
     */
    protected function belongsTo(string $related, string $foreignKey = null, string $ownerKey = 'id'): BelongsTo
    {
        if ($foreignKey === null) {
            $foreignKey = strtolower(class_basename($related)) . '_id';
        }
        
        return new BelongsTo($this->db, $this, $related, $foreignKey, $ownerKey);
    }
    
    /**
     * Define a one-to-one relationship
     */
    protected function hasOne(string $related, string $foreignKey = null, string $localKey = 'id'): HasOne
    {
        if ($foreignKey === null) {
            $foreignKey = strtolower(class_basename(get_class($this))) . '_id';
        }
        
        return new HasOne($this->db, $this, $related, $foreignKey, $localKey);
    }
    
    /**
     * Define a many-to-many relationship
     */
    protected function belongsToMany(
        string $related,
        string $pivotTable = null,
        string $foreignPivotKey = null,
        string $relatedPivotKey = null,
        string $localKey = 'id'
    ): BelongsToMany {
        if ($pivotTable === null) {
            $tables = [
                strtolower(class_basename(get_class($this))),
                strtolower(class_basename($related))
            ];
            sort($tables);
            $pivotTable = implode('_', $tables);
        }
        
        if ($foreignPivotKey === null) {
            $foreignPivotKey = strtolower(class_basename(get_class($this))) . '_id';
        }
        
        if ($relatedPivotKey === null) {
            $relatedPivotKey = strtolower(class_basename($related)) . '_id';
        }
        
        return new BelongsToMany(
            $this->db,
            $this,
            $related,
            $pivotTable,
            $foreignPivotKey,
            $relatedPivotKey,
            $localKey
        );
    }
    
    /**
     * Get the table name for the model
     */
    public function getTable(): string
    {
        return $this->table ?? strtolower(class_basename(get_class($this))) . 's';
    }
}

/**
 * Helper function to get class basename
 */
if (!function_exists('class_basename')) {
    function class_basename(string $class): string
    {
        $class = is_object($class) ? get_class($class) : $class;
        return basename(str_replace('\\', '/', $class));
    }
}
