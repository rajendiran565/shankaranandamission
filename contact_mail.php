<?php error_reporting(E_ALL ^ E_NOTICE); ?>
<?php

include "libmail.php";

$your-name=$_POST['name'];
$email=$_POST['email'];
$message=$_POST['message'];
$subject=$_POST['subject'];





$message= "<table><tr><td width='157' align='right' font-weight='bold' >CONTACT DETAILS</td></tr>
<tr><td width='157' align='right'>Customer Name&nbsp;:&nbsp;</td><td>$name</td></tr>
<tr><td width='157' align='right'>Customer Mail Id&nbsp;:&nbsp;</td><td>$email</td></tr>
<tr><td align='right'>Message&nbsp;:&nbsp;</td><td>$message</td></tr>
<tr><td align='right'>Subject&nbsp;:&nbsp;</td><td>$subject</td></tr>

</table><br>";


$m=new Mail; 

$m->From("donotreply@gnconstructions.in");
	
$m->To("gajalakshmi.r@spiderindia.net");

$m->Body($message);
	
$m->Priority(10) ;	

$m->Send();



 echo '<script>window.alert("Successfully Send");</script>';

 echo '<script>window.location="contact_mail.php"</script>';


?>