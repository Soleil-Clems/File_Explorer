<?php

class ColorsModel extends Db
{
    public function __construct()
    {
        parent::__construct();
    }


    public function getColorsModel()
    {
        $query = "SELECT * FROM colors";
        $stmt = $this->db->query($query);
        

        $colors = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $colors;
    }

    public function getIconModel(){
        $query = "SELECT path, color FROM icons";
        $stmt = $this->db->query($query);
        

        $icon = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $icons=[];
        foreach ($icon as $key => $value) {
            $icons[$value['path']]=$value['color'];
        }
        return $icons;
    }
    
    public function setColorsModel($color, $folders)
    {
        $values='';
        foreach ($folders as $key => $folder) {
            $values .="('$folder[0]', '$color'),";
        }

        $values = rtrim($values, ',');
        $query = "INSERT INTO icons (path, color) VALUES $values";
        $stmt = $this->db->prepare($query);
        $exec = $stmt->execute();

        if ($exec) {
            return "it work";
        }
        
        return $query;
    }

}
