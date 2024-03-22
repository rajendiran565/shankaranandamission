<?php  
include_once('./includes/csrf_token.php');
define("STRIPE_SECRET_API_KEY", "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");
define("STRIPE_PUBLISHABLE_KEY", "pk_live_51OaJKXH7WXIVvYYAw6ggCIbO23mlR9DlcrVc6ci1qqiwUdZYuPoGjM7vkENG3NFF2ynLIG2DjqMJjNJQFbT0IHNd00k3DyiknO");

//Sample Product Details
define('CURRENCY', 'USD');
define('AMOUNT', $_SESSION['donate_amount']);
define('DESCRIPTION', $_SESSION['donate_desc']);

// Include the Stripe PHP SDK library 
require_once 'vendor/autoload.php'; 

// Set API key 
\Stripe\Stripe::setApiKey('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'); 

// Set content type to JSON 
header('Content-Type: application/json'); 

// Retrieve JSON from POST body 
$jsonStr = file_get_contents('php://input'); 
$jsonObj = json_decode($jsonStr); 
?>