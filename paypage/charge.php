<?php
require_once('vendor/init.php');
require_once('config/db.php');
require_once('lib/pdo_db.php');
require_once('models/Customer.php');
require_once('models/Transaction.php');



\Stripe\Stripe::setApiKey('sk_test_mblcMK40UNMGgKaV6L91oWT8008qrOEmP5');


// Sanitize POST Array
$POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);

// function filter_post_input($input_name) {
//     return filter_input(INPUT_POST, $input_name, FILTER_SANITIZE_STRING)
// }

$first_name = $POST['first_name'];
$last_name = $POST['last_name'];
$email = $POST['email'];
$token = $POST['stripeToken'];


// Create customer in stripe
$customer = \Stripe\Customer::create(array(
    "email" => $email,
    "source" => $token
));

// Charge Customer
$charge = \Stripe\Charge::create(array(
    "amount" => 5000,
    "currency" => 'sek',
    "description" => "CSV Book Information",
    "customer" => $customer->id
));


// Customer Data
$customerData = [
    'id' => $charge->id,
    'first_name' => $first_name,
    'last_name' => $last_name,
    'email' => $email
];

// Instantiate Customer
$customer = new Customer();

// Add customer To DB
$customer->addCustomer($customerData);

// Transaction Data
$transactionData = [
    'id' => $charge->id,
    'customer_id' => $charge->customer,
    'product' => $charge->description,
    'amount' => $charge->amount,
    'currency' => $charge->currency,
    'status' => $charge->status
];

// Instantiate Transaction
$transaction = new Transaction();

// Add transaction To DB
$transaction->addTransaction($transactionData);

// Redirect to success
header('Location: success.php?tid='.$charge->id.'& product='.$charge->description);