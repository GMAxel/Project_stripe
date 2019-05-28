<?php
session_start();
require_once('classes/Transaction.php');
require_once('classes/Product.php');
require_once('classes/Charge.php');

// Customer Email
$email = $_SESSION['email'];
$token = filter_input(INPUT_POST, 'stripeToken', FILTER_SANITIZE_STRING);
// Instantiate Product
$product_obj = new Product();
$product_id = $_GET['id'];
$product = $product_obj->getProduct($product_id);
// Instantiate Transaction
$transaction = new Transaction();
// Instantiate Charge
$charge = new Charge();
// Customer Stripe_id
$customer = $_SESSION['stripe_id'] ?? null;


switch($customer) {
    case null:
        // skapa kund.
        $customer_obj = $charge->create_customer($email, $token);
        // Fakturera kund.
        $charge_obj = $charge->charge_customer($product, $customer);
        // Lägg in kunddata i databasen.
        $customer->update_customer($product->nrOfBooks, $customer);
        // Transaction Data
        $transactionData = [
            'order_id' =>  $charge_obj->id,
            'customer_id' => $charge_obj->customer,
            'product' => $product->id,
            'amount' => $charge_obj->amount,
            'currency' => $charge_obj->currency,
            'status' => $charge_obj->status
        ];
        // Add transaction to DB
        $trans = $transaction->addTransaction($transactionData);
        if(!$trans) {
            echo $transaction->response;
        } else {
            header('Location: success.php?tid='.$charge->id.'& product='.$charge->description);
        }
    default: 
        // fakturera kund.
        // Behöver veta vilken produkt,
        // och vilken kund.
        // Lägg in data i databasen.
}