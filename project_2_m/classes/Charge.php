<?php
session_start();
require_once('vendor/init.php');
require_once('classes/Customer.php');
require_once('classes/Transaction.php');
require_once('classes/Product.php');

class Charge {
    private $db;
    private $pdo;
    public $response;
    public $customer_to_charge;

    public function __construct($customer) 
    {
        $this->db = new Database;
        $this->pdo = $this->db->pdo;
        $this->$customer_to_charge = $customer;
        \Stripe\Stripe::setApiKey('sk_test_mblcMK40UNMGgKaV6L91oWT8008qrOEmP5');
    }
}