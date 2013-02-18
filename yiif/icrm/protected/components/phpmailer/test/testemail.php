<?php
/**
* Simple example script using PHPMailer with exceptions enabled
* @package phpmailer
* @version $Id$
*/

require '../class.phpmailer.php';

try {
	$mail = new PHPMailer(true); //New instance, with exceptions enabled

	$body             = file_get_contents('contents.html');
	$body             = preg_replace('/\\\\/','', $body); //Strip backslashes

	$mail->IsSMTP();                           // tell the class to use SMTP
	$mail->SMTPAuth   = true;                  // enable SMTP authentication
	$mail->Port       = 465;                    // set the SMTP server port
	$mail->Host       = "smtp.googlemail.com"; // SMTP server
	$mail->Username   = "adgoh79@gmail.com";     // SMTP server username
	$mail->Password   = "13081979";            // SMTP server password

	$mail->IsSendmail();  // tell the class to use Sendmail

	$mail->AddReplyTo("adgoh79@gmail.com","First Last");

	$mail->From       = "adgoh79@gmail.com";
	$mail->FromName   = "Adrian Goh";

	$to = "adgoh79@yahoo.com";

	$mail->AddAddress($to);

	$mail->Subject  = "First PHPMailer Message";

	$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
	$mail->WordWrap   = 80; // set word wrap

	$mail->MsgHTML($body);
echo 2;
	$mail->IsHTML(true); // send as HTML
echo 1;
	$mail->Send();
	echo 3;
	echo 'Message has been sent.';
} catch (phpmailerException $e) {
	echo $e->errorMessage();

}
?>