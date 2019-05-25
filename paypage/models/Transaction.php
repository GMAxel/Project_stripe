<?php
    class Transaction {
        private $db;

        public function __construct() {
            $this->db = new Database;
            
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
            $this->db->query('SELECT * FROM transactions ORDER BY id DESC');
            $results = $this->db->resultset();
            
            return $results;
        }
    }