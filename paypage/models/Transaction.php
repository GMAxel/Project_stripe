<?php
require_once('vendor/init.php');
require_once('config/db.php');

class Transaction {
    private $db;
    private $pdo;

    public function __construct() {
        $this->db = new Database;
        $this->pdo = $this->db->pdo;

        
    }

    public function addTransaction($data) {
        // Prepare query
        $this->db->query('INSERT INTO transactions (stripe_charge_id, stripe_cus_id, product, amount, currency, status, created_at)
        VALUES(:stripe_charge_id, :stripe_cus_id, :product, :amount, :currency, :status, :created_at)');

        // bind values
        $this->db->bind(':stripe_charge_id', $data['id']);
        $this->db->bind(':stripe_cus_id', $data['customer_id']); 
        $this->db->bind(':product', $data['product']);
        $this->db->bind(':amount', $data['amount']);
        $this->db->bind(':currency', $data['currency']);
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':created_at', date("Y-m-d H:i:s"));

        // execute
        if($this->db->execute()) {
            return true;
        } else {
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