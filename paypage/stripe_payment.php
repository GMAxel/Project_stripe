<?php 
require_once('vendor/init.php');
require_once('config/db.php');
require_once('lib/pdo_db.php');
require_once('models/Customer.php');
require_once('models/Transaction.php');
// Set your secret key: remember to change this to your live secret key in production
// See your keys here: https://dashboard.stripe.com/account/apikeys
\Stripe\Stripe::setApiKey('sk_test_mblcMK40UNMGgKaV6L91oWT8008qrOEmP5');

// Token is created using Checkout or Elements!
// Get the payment token ID submitted by the form:
$id = $_GET['id'];
var_dump($id);
die;
$token = $_POST['stripeToken'];
$charge = \Stripe\Charge::create([
    'amount' => 999,
    'currency' => 'sek',
    'description' => 'Example charge',
    'source' => $token,
]);
?>