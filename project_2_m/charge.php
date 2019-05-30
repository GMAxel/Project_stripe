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

// Instantiate Products and store product details.
$product_obj = new Product();
$id = $_GET['id'];
$product = $product_obj->getProduct($id);

// The customer who we are going to charge.
$customer_to_charge = $user;

if(!$customer_to_charge) {
    // Get customers Email
    $email = $_SESSION['email'];
    // Create customer in stripe
    $customer = \Stripe\Customer::create(array(
        "email" => $email,
        "source" => $token,
    ));
    // Set customer to charge. 
    $_SESSION['stripe_id'] = $customer->id;  
    $customer_to_charge = $customer->id;
}
$charge = \Stripe\Charge::create(array(
    "amount" => $product->price,
    "currency" => 'sek',
    "description" => $product->description,
    "customer" => $customer_to_charge
));

if($charge->status !== 'succeeded') {
    header("Location: failure.php?id=$id");
    die;
}

// Instantiate Customer
$customer = new Customer();
// Store bought licenses in DB - If we just created stripe account,
// Then store stripe_id. If not, send in null.
if(is_null($user)) {
    $customer->update_customer($product->nrOfBooks, $customer_to_charge);
} else {
    $customer->update_customer($product->nrOfBooks);
}

// Refund if no goodio https://stripe.com/docs/refunds
// // Set your secret key: remember to change this to your live secret key in production
// // See your keys here: https://dashboard.stripe.com/account/apikeys
// \Stripe\Stripe::setApiKey('sk_test_mblcMK40UNMGgKaV6L91oWT8008qrOEmP5');

// $refund = \Stripe\Refund::create([
//     'charge' => 'ch_a6NGSRWJeqi0nPztKe0n',
// ]);

// Transaction Data
$transactionData = [
    'order_id' => $charge->id,
    'customer_id' => $charge->customer,
    'product' => $product->id,
    'amount' => $charge->amount,
    'currency' => $charge->currency,
    'status' => $charge->status
];

// Instantiate Transaction
$transaction = new Transaction();

// Store transaction in DB
$trans = $transaction->addTransaction($transactionData);
if(!$trans) {
    echo $transaction->response;
} else {
// Redirect to success
header('Location: success.php?tid='.$charge->id.'&product='.$charge->description);
}