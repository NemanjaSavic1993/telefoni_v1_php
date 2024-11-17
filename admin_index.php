<?php

    require 'load.php';

    if(!isset($_SESSION["loggedUser"]) && ($_SESSION["loggedUser"]->role != "Administrator")){
        header("Location: index.php");
    }

    if(!isset($_GET["menu"])){
        $menu = "korisnici";
    }else{
        $menu = $_GET["menu"];
    }

    if($menu == 'korisnici'){
        $allUsers = $user->getAllWithoutLogin($_SESSION["loggedUser"]->uid);

        $number = ceil(count($allUsers) / 5);

        $result = pagination($number);

        $users = $user->paginateWithoutLogin($_SESSION["loggedUser"]->uid, 5, $result['offset']);

        require_once 'views/admin.korisnici.html';

    }elseif($menu == 'proizvodjaci'){
        
        if(isset($_POST['btnSaveProducer'])){
            $producer->save();
        }

        if(isset($_POST['btnEditProducer'])){
            $producer->update();
        }
        
        $allProd = $producer->getAll();

        $number = ceil(count($allProd) / 5);

        $result = pagination($number);

        $manufacturers = $producer->paginate(5, $result['offset']);


        require_once 'views/admin.proizvodjaci.html';
    }elseif($menu == 'modeli'){
        
        if(isset($_POST['btnSaveModel'])){
            $db->beginTransaction();
            try{
                $model->save();
                $image->save($model->id);
                $db->commit();
            }
            catch(Exception $e){
                $db->rollBack();
                echo "Došlo je do greške: " . $e->getMessage();
            }
        }

        if(isset($_POST['btnEditModel'])){
            $db->beginTransaction();
            try{
                $model->update();
                $image->deleteImages($_POST['mid']);
                $image->save($_POST['mid']);
                $db->commit();
            }
            catch(Exception $e){
                $db->rollBack();
                echo "Došlo je do greške: " . $e->getMessage();
            }
        }

        $producers = $producer->getAll();

        $allModels = $model->getAll();

        $number = ceil(count($allModels) / 5);

        $result = pagination($number);

        $models = $model->paginate(5, $result['offset']);


        require_once 'views/admin.modeli.html';
    }

    
