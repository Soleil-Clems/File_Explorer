<?php
// namespace Filter;
// use DB;
// use PDO;
include "./config/Db.php";
class FilterModel extends Db
{
    public function __construct()
    {
        parent::__construct();
    }


    public function getFilterModel()
    {
        $query = "SELECT * FROM filter";
        $stmt = $this->db->query($query);
        $stmt->execute();

        $filters = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $filters;
    }

    public function actualFiltreModel()
    {
        $query = "SELECT * FROM actual_filter";
        $stmt = $this->db->query($query);
        $stmt->execute();

        $actual = $stmt->fetch(PDO::FETCH_ASSOC);
        return $actual['name'];
    }

    public function setFilterModel($filtre)
    {
        $query = "UPDATE actual_filter SET name = $filtre";
        $stmt = $this->db->query($query);
        $exec = $stmt->execute();

        if ($exec) {
            return [true,"it's work"];
        } else {
            return [false,"Not work"];
        }
    }
}
