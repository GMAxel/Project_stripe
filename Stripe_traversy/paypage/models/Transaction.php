<?php
    class Transaction {
        private $db;

        public function __construct() {
            $this->db = new Database;
            
        }

        public function addTransaction($data) {
            // Prepare query
            $this->db->query('INSERT INTO transactions (stripe_id, customer_id, product, amount, currency, status)
            VALUES(:stripe_id, :customer_id, :product, :amount, :currency, :status)');

            // bind values
            $this->db->bind(':stripe_id', $data['id']);
            $this->db->bind(':customer_id', $data['customer_id']); 
            $this->db->bind(':product', $data['product']);
            $this->db->bind(':amount', $data['amount']);
            $this->db->bind(':currency', $data['currency']);
            $this->db->bind(':status', $data['status']);



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