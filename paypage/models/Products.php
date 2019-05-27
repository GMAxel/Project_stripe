<?php
require_once('vendor/init.php');
require_once('config/db.php');
require_once('lib/pdo_db.php');

class Product {
    private $db;
    private $pdo;
    protected $table = 'products';
    protected $fields = null;
    public $id = null;
    public $response;


    public function __construct() {
        $this->db = new Database;
        $this->pdo = $this->db->pdo;
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

    // $products = array( 
    //     "product1" => array(
    //         "title" => "My amazing product 1",
    //         "price" => 6700,
    //         "features" => array("feature 1", "feature 2", "feature 3"),
    //         "description" => "Recieve information about 1 book!"
    //     ),
    //     "product2" => array(
    //         "title" => "My amazing product 2",
    //         "price" => 2500,
    //         "features" => array("feature 1", "feature 2", "feature 3"),
    //         "description" => "Recieve information about 3 books!"
    //     ),
    //     "product3" => array(
    //         "title" => "My amazing product 3",
    //         "price" => 2300,
    //         "features" => array("feature 1", "feature 2", "feature 3"),
    //         "description" => "Recieve information about 5 books!"
    //     )
    // );
?>