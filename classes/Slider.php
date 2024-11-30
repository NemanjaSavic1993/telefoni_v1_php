<?php 

class Slider extends QueryBuilder{

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

    public function getAll(){
        $sql = "SELECT * FROM sliders";
        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function getActiveSliders(){
        $sql = "SELECT * FROM sliders where active <> 0";
        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function paginate($limit, $offset){
        $sql = "SELECT * FROM sliders order by id limit {$limit} offset {$offset} ";
        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function save(){
        // cuvanje slika za slajder
    }
}