<?php

class User extends QueryBuilder{

    public $resultRegister = NULL;
    public $loggedUser = NULL;

    public function register(){
        $name = $_POST['register_name'];
        $email = $_POST['register_email'];
        $password = $_POST['register_password'];

        $sql = "INSERT INTO users VALUES(NULL,?,?,?,NULL,?)";
        $query = $this->db->prepare($sql);
        $query->execute([$name,$email,md5($password),2]);

        if($query){
            $this->resultRegister = true;
        }
    }

    public function login(){
        $email = $_POST['login_email'];
        $password = $_POST['login_password'];

        $sql = "SELECT u.id as uid, u.name as username, email, r.id as rid, r.name as role FROM users u INNER JOIN roles r ON u.id_role = r.id WHERE email = ? AND password = ?";
        $query = $this->db->prepare($sql);
        $query->execute([$email,md5($password)]);

        $loggedUser = $query->fetch(PDO::FETCH_OBJ);

        if($loggedUser != NULL){
            $_SESSION['loggedUser'] = $loggedUser;
            $this->loggedUser = $loggedUser;
        }

    }

    public function getAllWithoutLogin($id){
        $sql = "SELECT u.id as uid, u.name as username, email, r.name as role FROM users u INNER JOIN roles r ON u.id_role = r.id WHERE u.id <> ?";
        $query = $this->db->prepare($sql);
        $query->execute([$id]);

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function paginateWithoutLogin($id, $limit, $offset){
        $sql = "SELECT u.id as uid, u.name as username, email, r.name as role FROM users u INNER JOIN roles r ON u.id_role = r.id WHERE u.id <> ? order by uid limit {$limit} offset {$offset} ";
        $query = $this->db->prepare($sql);
        $query->execute([$id]);

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function updateRole($id, $role){
        if($role == 'Administrator'){
            $sql = "UPDATE users SET id_role = 2 WHERE id = ?";
        }else{
            $sql = "UPDATE users SET id_role = 1 WHERE id = ?";
        }
        
        $query = $this->db->prepare($sql);
        $query->execute([$id]);

        if($query){
            return 'success';
        }else{
            return 'error';
        }
    }
}