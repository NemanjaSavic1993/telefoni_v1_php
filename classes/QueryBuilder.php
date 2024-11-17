<?php
class QueryBuilder{
    
    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function selectAll($table){
        $sql = "SELECT * FROM {$table}";
        $query = $this->db->prepare($sql);
        $query->execute();
        
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function delete($id, $table){
        $sql = "DELETE FROM {$table} WHERE id = ?";
        $query = $this->db->prepare($sql);
        $query->execute([$id]);
        
        if($query){
            return "success";
        }else{
            return "error";
        }
    }

}