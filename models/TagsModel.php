<?php

class TagsModel extends Db
{
    public function __construct()
    {
        parent::__construct();
    }


    public function getTagsModel()
    {
        $query = "SELECT * FROM alltags";
        $stmt = $this->db->query($query);
        $stmt->execute();

        $tags = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $tags;
    }

    public function setTagModel($tag, $folders)
    {
        $values='';
        foreach ($folders as $key => $folder) {
            $values .="('$tag', '$folder[0]', '$folder[1]'),";
        }

        $values = rtrim($values, ',');
        $query = "INSERT INTO mytag (tag, path, ext) VALUES $values";
        $stmt = $this->db->prepare($query);
        $exec = $stmt->execute();

        if ($exec) {
            return "it work";
        }
        
        return $query;
    }

    public function getTagModel($tag)
    {
        $tag = "%$tag%";
        $query = "SELECT * FROM mytag WHERE mytag.tag LIKE '$tag'";
        $stmt = $this->db->query($query);
        

        $tags = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $tags;
    }
}
