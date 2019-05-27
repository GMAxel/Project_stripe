<?php
require_once('vendor/init.php');
require_once('classes/Database.php');

class Product {
    private $pdo;
    protected $table = 'products';
    public $response;

    public function __construct() 
    {
        $db = new Database();
        $this->pdo = $db->pdo;
    }

    public function getProducts() {
        $sql = "SELECT * FROM $this->table";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ); 
    }

    public function getProduct($id) {
        $sql = "SELECT * FROM $this->table WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue('id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ); 
    }

}
?>