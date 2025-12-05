<?php
namespace Framework\Core;

use PDO;
use Framework\Database\Traits\HasRelationships;

#[AllowDynamicProperties]
abstract class Model {
    use HasRelationships;
    
    protected $db;
    protected $table;

    public function __construct(Database $db)
    {
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }
        $this->db = $db;
    }
    
    public function all(string $column)
    {
        return $this->query("SELECT * FROM {$this->table} ORDER BY {$column} DESC");
    }

    public function findById(int $id, string $column): object|bool
    {
        return $this->query("SELECT * FROM {$this->table} WHERE {$column} = ?", [$id], true);
    }

    public function create(array $data, ?array $relations = null)
    {
        $firstParenthesis = "";
        $secondeParenthesis = "";
        $i = 1;
        foreach($data as $key => $value){
            $comma = $i === count($data) ? "": ", ";
            $firstParenthesis .= "{$key}{$comma}";
            $secondeParenthesis .= ":{$key}{$comma}";
            $i++;
        }

        return $this->query("INSERT INTO {$this->table} ($firstParenthesis) VALUES($secondeParenthesis)", $data);
    }

    public function update(int $id, array $data, ?array $relations = null)
    {
        $sqlRequestPart = "";
        $i = 1;

        foreach($data as $key=>$value){
            $comma = ($i === count($data) ? "": ", ");
            $sqlRequestPart .= "{$key} = :{$key}{$comma}";
            $i++;
        }

        $data["id"] = $id;
        if($i > 1){
            return $this->query("UPDATE {$this->table} SET {$sqlRequestPart} WHERE id = :id", $data);
        }
    }
    
    public function destroy(int $id): bool
    {
        return $this->query("DELETE FROM {$this->table} WHERE id = ?", [$id]);
    }

    public function query(string $sql, array $param=null, bool $single=null)
    {
        $method = is_null($param) ? 'query': 'prepare';
        if(
        strpos($sql, 'DELETE') === 0
        || strpos($sql, 'UPDATE') === 0
        || strpos($sql, 'INSERT') === 0)
        {
            $stmt = $this->db->getPDO()->$method($sql);
            return $stmt->execute($param);
        }

        $fetch = is_null($single) ? 'fetchALL': 'fetch';
        $stmt = $this->db->getPDO()->$method($sql);
        $stmt->setFetchMode(PDO::FETCH_OBJ);

        if($method === 'query'){
            return $stmt->$fetch();
        }else{
            $stmt->execute($param);
            return $stmt->$fetch();
        }
    }
}
