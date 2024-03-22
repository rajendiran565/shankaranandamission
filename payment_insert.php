<?php 
include_once('./includes/csrf_token.php');
include_once('./includes/crud.php');
include_once('./includes/custom-functions.php');

require_once 'stripe_header.php';

$db = new Database();
$db->connect();
$db->sql("SET NAMES utf8");
$function = new custom_functions();

$payment = !empty($jsonObj->payment_intent)?$jsonObj->payment_intent:''; 
$customer_id = !empty($jsonObj->customer_id)?$jsonObj->customer_id:''; 
    
// Retrieve customer information from stripe
try {
    $customerData = \Stripe\Customer::retrieve($customer_id);  
}catch(Exception $e) { 
    $error = $e->getMessage(); 
}

if(empty($error)) {
    // If transaction was successful
    if(!empty($payment) && $payment->status == 'succeeded'){
        // Retrieve transaction details
        $transaction_id = $payment->id; 
        $amount = ($payment->amount/100); 
        $currency = $payment->currency; 
        $item_description = $payment->description; 
        $payment_status = $payment->status; 
            
        $fulname = $email = ''; 
        if(!empty($customerData)){
            if(!empty($customerData->name)) {
                $fullname = $customerData->name;
            }
            if(!empty($customerData->email)) {
                $email = $customerData->email;
            }
        }

        $sql = "select * from stripe_payment where transaction_id='".$transaction_id."'";
        $db->sql($sql);
        $res = $db->getResult();
        $num_rows = $db->numRows($res);
        if($num_rows <= 0){ 
            $data = array(
                'fullname' => $fullname,
                'email' => $email,
                'item_description' => $item_description,
                'currency' => $currency,
                'amount' => $amount,
                'transaction_id' => $transaction_id,
                'payment_status' => $payment_status
            );
            $db->insert('stripe_payment',$data);
            $id = $db->getResult()[0];
        }

        $output = [ 
            'transaction_id' => $transaction_id
        ];
        echo json_encode($output); 
    }else{ 
        http_response_code(500); 
        echo json_encode(['error' => 'Transaction has been failed!']); 
    } 
}else{ 
    http_response_code(500);
    echo json_encode(['error' => $error]); 
} 
?>