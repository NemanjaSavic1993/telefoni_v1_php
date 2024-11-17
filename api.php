<?php
    require 'load.php';

    $json = file_get_contents('php://input');

    $data = json_decode($json);

    if($data->action == 'del'){
        if($data->table != 'models'){
            echo $query->delete($data->id, $data->table);
        }else{
            $db->beginTransaction();
            try{
                $query->delete($data->id, $data->table);
                $image->deleteImages($data->id);
                $db->commit();

                echo 'success';
            }
            catch(Exception $e){
                $db->rollBack();
                echo "Došlo je do greške: " . $e->getMessage();
            }
           
        }
        
    }

    if($data->action == 'edit' && $data->table == 'users'){
        echo $user->updateRole($data->id, $data->role);
    }

    if($data->action == 'edit' && $data->table == 'manufacturers'){
        echo json_encode($producer->getById($data->id));
    }

    if($data->action == 'edit' && $data->table == 'models'){
        echo json_encode($model->getById($data->id));
    }

?>