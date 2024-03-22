<?php

require_once('vendor/autoload.php');
\Stripe\Stripe::setApiKey('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');

var_dump($_POST);die();
// Sanitize input
$amount = filter_var($_POST['amount'], FILTER_SANITIZE_NUMBER_INT);
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

// Convert amount to cents for Stripe
$amountInCents = $amount * 100;

try {
    $charge = \Stripe\Charge::create([
        'amount' => $amountInCents,
        'currency' => 'usd',
        'source' => $_POST['stripeToken'],
        'receipt_email' => $email,
    ]);

    // Success: Redirect or inform the user
    echo 'Payment successful!';

} catch (\Stripe\Exception\ApiErrorException $e) {
    // Error: Handle accordingly
    echo 'Payment error: ' . $e->getMessage();
}
?>