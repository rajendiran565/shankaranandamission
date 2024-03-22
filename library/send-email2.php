<?php 
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	use PHPMailer\PHPMailer\SMTP;
    require   __DIR__.'/PHPMailer/src/PHPMailer.php';
    require   __DIR__.'/PHPMailer/src/SMTP.php';
    require   __DIR__.'/PHPMailer/src/Exception.php';

function send_email($to,$subject,$message){

	
	$app_name = 'SMF';
	$from_mail = 'info@spiderekart.com'; 
	$reply_to = 'info@spiderekart.com'; 
	
	$mail = new PHPMailer();
	$mail->isSMTP();
//	$mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->Host = 'spiderekart.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'info@spiderekart.com'; 
    $mail->Password = '+c()6.DRTwL6';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = '465';

    $mail->setFrom($from_mail, $app_name);
    $mail->addReplyTo($reply_to, $app_name);
    $mail->addAddress($to, 'Tim'); 
 //   $mail->addCC('cc1@example.com', 'Elena');
  //  $mail->addBCC('bcc1@example.com', 'Alex');
    $mail->Subject =$subject;
    $mail->isHTML(true);
    $mail->Body =$message;
    if($mail->send()){
        return true;
    }else{
        return false;
       
    }
	
}
?>