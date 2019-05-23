<?php
    class Customer {
        private $db;

        public function __construct() {
            $this->db = new Database;
        }

        public function addCustomer($data) {
            // Prepare query
            $this->db->query('INSERT INTO customers (stripe_id, first_name, last_name, email)
            VALUES(:stripe_id, :first_name, :last_name, :email)');

            // bind values
            $this->db->bind(':stripe_id', $data['id']);
            $this->db->bind(':first_name', $data['first_name']);
            $this->db->bind(':last_name', $data['last_name']);
            $this->db->bind(':email', $data['email']);

            // execute
            if($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }

        public function getCustomers() {
            $this->db->query('SELECT * FROM customers ORDER BY first_name ASC');
            $results = $this->db->resultset();
            
            return $results;
        }
    }