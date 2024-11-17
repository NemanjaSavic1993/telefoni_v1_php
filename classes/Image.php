<?php
class Image extends QueryBuilder
{

    private function resize($name, $filename, $new_w, $new_h)
    {
        $system = explode('.', $name);
        if (preg_match('/jpg|jpeg/i', $system[1])) {
            $src_img = imagecreatefromjpeg($name);
        }
        if (preg_match('/png/i', $system[1])) {
            $src_img = imagecreatefrompng($name);
        }

        $old_x = imageSX($src_img);
        $old_y = imageSY($src_img);
        if ($old_x > $old_y) {
            $thumb_w = $new_w;
            $thumb_h = $old_y * ($new_h / $old_x);
        }
        if ($old_x < $old_y) {
            $thumb_w = $old_x * ($new_w / $old_y);
            $thumb_h = $new_h;
        }
        if ($old_x == $old_y) {
            $thumb_w = $new_w;
            $thumb_h = $new_h;
        }

        $dst_img = imagecreatetruecolor($thumb_w, $thumb_h);
        imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $thumb_w, $thumb_h, $old_x, $old_y);


        if (preg_match("/png/i", $system[1])) {
            imagepng($dst_img, $filename);
        } else {
            imagejpeg($dst_img, $filename);
        }
        imagedestroy($dst_img);
        imagedestroy($src_img);
    }

    public function save($id)
    {
        if(isset($_FILES['model_images'])){
            $totalFiles = count($_FILES['model_images']['name']);
            $tmpName = $_FILES['model_images']['tmp_name'];
        }elseif(isset($_FILES['edit_model_images'])){
            $totalFiles = count($_FILES['edit_model_images']['name']);
            $tmpName = $_FILES['edit_model_images']['tmp_name'];
        }

        for ($i = 0; $i < $totalFiles; $i++) {
            if(isset($_FILES['model_images'])){
                $largePath = 'images/phones/large/' . time() . '_' . $_FILES['model_images']['name'][$i];
                $smallPath = 'images/phones/small/' . time() . '_' . $_FILES['model_images']['name'][$i];
            }elseif(isset($_FILES['edit_model_images'])){
                $largePath = 'images/phones/large/' . time() . '_' . $_FILES['edit_model_images']['name'][$i];
                $smallPath = 'images/phones/small/' . time() . '_' . $_FILES['edit_model_images']['name'][$i];
            }
            $model_id = $id;

            if (move_uploaded_file($tmpName[$i], $largePath)) {
                $this->resize($largePath, $smallPath, 250, 250);

                $sql = "INSERT INTO images VALUES (NULL,?,?,?)";
                $query = $this->db->prepare($sql);
                $query->execute([$largePath, $smallPath, $model_id]);
            }
        }
    }

    public function deleteImages($id)
    {
        
        $sql = "SELECT * FROM images WHERE id_model = ?";
        $query = $this->db->prepare($sql);
        $query->execute([$id]);

        $images =$query->fetchAll(PDO::FETCH_OBJ);

        for($i=0;$i<count($images);$i++){
            unlink($images[$i]->pathLarge);
            unlink($images[$i]->pathSmall);
        }

        $sql = "DELETE FROM images WHERE id_model = ?";
        $query = $this->db->prepare($sql);
        $query->execute([$id]);
    }
}
