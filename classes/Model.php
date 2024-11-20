<?php

class Model extends QueryBuilder{
    public $saveMessage = NULL;
    public $id = NULL;
    public $editMessage = NULL;

    public function getAll(){
        $sql = "SELECT * FROM models";
        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function paginate($limit, $offset){
        $sql = "SELECT m.*, p.name as product,(select pathSmall from images where id_model = m.id order by id limit 1) as mainImg FROM models m inner join manufacturers p on m.id_producer = p.id  order by m.id limit {$limit} offset {$offset}";
        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function save(){
        $name = $_POST['model_name'];
        $description = $_POST['model_description'];
        $price = (float)$_POST['model_price'];
        $quantity = (int)$_POST['model_quantity'];
        $producer_id = (int)$_POST['model_producer'];


        $sql = "INSERT INTO models VALUES (NULL,?,?,?,?,?)";
        $query = $this->db->prepare($sql);
        $query->execute([$name, $description, $price, $quantity, $producer_id]);

        if($query){
            $this->saveMessage = true;
            $this->id = $this->db->lastInsertId();
        }else{
            $this->saveMessage = false;
        }
    }

    public function getById($id){
        $sql = "SELECT * FROM models WHERE id = ?";
        $query = $this->db->prepare($sql);
        $query->execute([$id]);

        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function update(){
        $name = $_POST['edit_model_name'];
        $description = $_POST['edit_model_description'];
        $price = (float)$_POST['edit_model_price'];
        $quantity = (int)$_POST['edit_model_quantity'];
        $producer_id = (int)$_POST['edit_model_producer'];
        $id = $_POST['mid'];


        $sql = "UPDATE models SET name = ?, description = ?, price = ?, quantity = ?, id_producer = ? WHERE id = ?";
        $query = $this->db->prepare($sql);
        $query->execute([$name, $description, $price, $quantity, $producer_id, $id]);

        if($query){
            $this->editMessage = true;
        }else{
            $this->editMessage = false;
        }
    }

    public function filter(){
        $arr = array();

        $producer_name = $_POST['producer_name'];
        $model_name = $_POST['model_name'];
        $price_from = $_POST['price_from'];
        $price_to = $_POST['price_to'];

        $sql = "SELECT m.*, p.name as product,(select pathSmall from images where id_model = m.id order by id limit 1) as mainImg FROM models m inner join manufacturers p on m.id_producer = p.id where 1 = 1";

        if(!empty($producer_name)){
            $sql = $sql.' and p.name like "%"?"%"';
            array_push($arr,$producer_name);
        }
        if(!empty($model_name)){
            $sql = $sql.' and m.name like "%"?"%"';
            array_push($arr,$model_name);
        }
        if(!empty($price_from)){
            $sql = $sql.' and price > ?';
            array_push($arr,$price_from);
        }
        if(!empty($price_to)){
            $sql = $sql.' and price < ?';
            array_push($arr, $price_to);
        }

        $query = $this->db->prepare($sql);
        $query->execute($arr);

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function search(){

        $text = $_POST['search_text'];

        $sql = "SELECT m.*, p.name as product,(select pathSmall from images where id_model = m.id order by id limit 1) as mainImg FROM models m inner join manufacturers p on m.id_producer = p.id";

        if(!empty($text)){
            $sql = $sql." where m.name like ? or p.name like ?";
        }

        $query = $this->db->prepare($sql);
        $query->execute(['%' . $text . '%', '%' . $text . '%']);

        return $query->fetchAll(PDO::FETCH_OBJ);
    }
}