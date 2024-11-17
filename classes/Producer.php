<?php

class Producer extends QueryBuilder{
    public $saveMessage = NULL;
    public $editMessage = NULL;

    public function getAll(){
        $sql = "SELECT * FROM manufacturers";
        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function paginate($limit, $offset){
        $sql = "SELECT * FROM manufacturers order by id limit {$limit} offset {$offset} ";
        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function save(){
        $name = $_POST['producer_name'];
        $sql = "INSERT INTO manufacturers VALUES (NULL,?)";
        $query = $this->db->prepare($sql);
        $query->execute([$name]);


        if($query){
            $this->saveMessage = true;
        }else{
            $this->saveMessage = false;
        }
    }

    public function update(){
        $name = $_POST['producer_name_edit'];
        $id = $_POST['pid'];
        $sql = "UPDATE manufacturers SET name = ? WHERE id = ?";
        $query = $this->db->prepare($sql);
        $query->execute([$name,$id]);


        if($query){
            $this->editMessage = true;
        }else{
            $this->editMessage = false;
        }
    }
    
    public function getById($id){
        $sql = "SELECT * FROM manufacturers WHERE id = ?";
        $query = $this->db->prepare($sql);
        $query->execute([$id]);

        return $query->fetch(PDO::FETCH_OBJ);
    }
}