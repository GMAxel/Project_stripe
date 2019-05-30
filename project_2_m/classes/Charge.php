<?php
session_start();
require_once('vendor/init.php');
require_once('classes/Customer.php');
require_once('classes/Transaction.php');
require_once('classes/Product.php');

class Charge {
    private $pdo;
    public $response;
    public $customer;

    public function __construct() 
    {
        $db = new Database;
        $this->pdo = $db->pdo;
        \Stripe\Stripe::setApiKey('sk_test_mblcMK40UNMGgKaV6L91oWT8008qrOEmP5');
    }

    public function create_customer($email, $token) 
    {
        $customer = \Stripe\Customer::create(array(
            "email" => $email,
            "source" => $token,
        ));
        return $customer;
    }
    
    public function charge_customer($product, $customer) 
    {
        $charge = \Stripe\Charge::create(array(
            "amount" => $product->price,
            "currency" => 'sek',
            "description" => $product->description,
            "customer" => $customer
        ));
        return $charge;
    }

    public function refund_customer($charge_id) 
    {
        $refund = \Stripe\Refund::create([
            'charge' => $charge_id,
        ]);
    }

}