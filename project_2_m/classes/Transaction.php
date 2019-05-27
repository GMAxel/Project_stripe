<?php
require_once('classes/Database.php');

class Transaction {
    private $db;
    private $pdo;
    public $response = null;
    public $table = 'transactions';

    public function __construct() 
    {
        $this->db = new Database;
        $this->pdo = $this->db->pdo;
    }

    public function addTransaction($data) {
        // Sql query
        $sql = "INSERT INTO $this->table (stripe_charge_id, stripe_cus_id, product_id, amount, currency, status, created_at)
        VALUES(:stripe_charge_id, :stripe_cus_id, :product, :amount, :currency, :status, :created_at)";

        // Prepare
        $stmt = $this->pdo->prepare($sql);

        // bind values
        $stmt->bindValue(':stripe_charge_id', $data['id']);
        $stmt->bindValue(':stripe_cus_id', $data['customer_id']); 
        $stmt->bindValue(':product', $data['product']);
        $stmt->bindValue(':amount', $data['amount']);
        $stmt->bindValue(':currency', $data['currency']);
        $stmt->bindValue(':status', $data['status']);
        $stmt->bindValue(':created_at', date("Y-m-d H:i:s"));

        // execute
        if($stmt->execute()) {
            $this->response = 'Transaction Complete';
            return true;
        } else {
            $this->response = 'Error! Transaction could not go through, try again';
            return false;
        }
    }
    public function getTransactions() {
        $cus_stripe_id = $_SESSION['stripe_id'];
        $sql = "SELECT t.stripe_charge_id, p.name, t.amount, 
        t.currency, t.created_at, t.status 
        FROM transactions AS t
        JOIN products as p on t.product_id = p.id
        WHERE t.stripe_cus_id = :id;";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue('id', "cus_F8Kxp5hSsyhEDT");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }
}