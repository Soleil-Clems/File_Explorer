<?php
// namespace DB;

// use PDO;
// use PDOException;

abstract class Db
{
    protected $db;
    private $host = 'localhost';
    private $dbName = 'h5ai';
    private $user = 'root';
    private $password = 'root';

    public function __construct()
    {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->dbName};charset=utf8";
            $this->db = new PDO($dsn, $this->user, $this->password); 
            $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new \Exception("Erreur de connexion à la base de données: " . $e->getMessage());
        }
    }
}
?>
