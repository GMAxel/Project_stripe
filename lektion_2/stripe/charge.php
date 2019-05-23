<?php
require_once('stripe-php-master/init.php');
\Stripe\Stripe::setApiKey('sk_test_mblcMK40UNMGgKaV6L91oWT8008qrOEmP5'); //YOUR_STRIPE_SECRET_KEY
// Get the token from the JS script
$token = $_POST['stripeToken'];
// This is a $20.00 charge in US Dollar.
//Charging a Customer
// Create a Customer
$name_first = "Batosai";
$name_last = "Ednalan";
$address = "New Cabalan Olongapo City";
$state = "Zambales";
$zip = "22005";
$country = "Philippines";
$phone = "09306408219";
$user_info = array("First Name" => $name_first, "Last Name" => $name_last, "Address" => $address, "State" => $state, "Zip Code" => $zip, "Country" => $country, "Phone" => $phone);
$customer = \Stripe\Customer::create(array(
    "email" => "rednalan23@gmail.com",
    "source" => $token,
 'metadata' => $user_info,
));
// Save the customer id in your own database!
// Charge the Customer instead of the card
$charge = \Stripe\Charge::create(array(
    "amount" => 2000,
 "description" => "Purchase off Caite watch",
    "currency" => "usd",
    "customer" => $customer->id,
 'metadata' => $user_info
));
print_r($charge);
// You can charge the customer later by using the customer id.
 
//Making a Subscription Charge
// Get the token from the JS script
//$token = $_POST['stripeToken'];
// Create a Customer
//$customer = \Stripe\Customer::create(array(
//    "email" => "paying.user@example.com",
//    "source" => $token,
//));
// or you can fetch customer id from the database too.
// Creates a subscription plan. This can also be done through the Stripe dashboard.
// You only need to create the plan once.
//$subscription = \Stripe\Plan::create(array(
//    "amount" => 2000,
//    "interval" => "month",
//    "name" => "Gold large",
//    "currency" => "cad",
//    "id" => "gold"
//));
// Subscribe the customer to the plan
//$subscription = \Stripe\Subscription::create(array(
//    "customer" => $customer->id,
//    "plan" => "gold"
//));
//print_r($subscription);
?>