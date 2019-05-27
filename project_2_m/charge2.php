<?php
session_start();
require_once('vendor/init.php');
require_once('classes/Customer.php');
require_once('classes/Transaction.php');
require_once('classes/Product.php');


\Stripe\Stripe::setApiKey('sk_test_mblcMK40UNMGgKaV6L91oWT8008qrOEmP5');

/**
 * If customer already exists in stripe, 
 * don't create a new customer. Charge that customer again.
 */
$user = $_SESSION['stripe_id'];
$token = filter_input(INPUT_POST, 'stripeToken', FILTER_SANITIZE_STRING);

// Instantiate Products
$product_obj = new Product();
$id = $_GET['id'];
$product = $product_obj->getProduct($id);

$customer_to_charge = $user;

if(!$customer_to_charge) {
    $email = $_SESSION['email'];

    // Create customer in stripe
    $customer = \Stripe\Customer::create(array(
        "email" => $email,
        "source" => $token,
    ));

    $customer_to_charge = $customer->id;
}
// Instantiate Customer
$customer = new Customer();

// Store bought licenses in DB
$customer->update_customer($product->nrOfBooks, $customer_to_charge);

$charge = \Stripe\Charge::create(array(
    "amount" => $product->price,
    "currency" => 'sek',
    "description" => $product->description,
    "customer" => $customer_to_charge
));

// Transaction Data
$transactionData = [
    'id' => $charge->id,
    'customer_id' => $charge->customer,
    'product' => $product->id,
    'amount' => $charge->amount,
    'currency' => $charge->currency,
    'status' => $charge->status
];

// Instantiate Transaction
$transaction = new Transaction();

// Store transaction in DB
$transaction->addTransaction($transactionData);

// Redirect to success
header('Location: success.php?tid='.$charge->id.'& product='.$charge->description);
