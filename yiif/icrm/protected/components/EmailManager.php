<?php

	include_once "phpmailer\class.phpmailer.php";
	//yiic run from <installation directory>\icrm\protected\
	//so require_once in this way
	
	require_once dirname(__FILE__)."/../config/EmailReminderConfig.php";
	//include_once "logger.php";
	class EmailManager {
		//change email setup here
		private $host = GMAIL_SMTP_URL; // specify main and backup server
		private $port = GMAIL_SMTP_PORT; // set the port to use
		private $username= GMAIL_USER_EMAIL;  // your SMTP username or your gmail username
		private $password= GMAIL_USER_PASSWORD; // your SMTP password or your gmail password
		private $from = GMAIL_USER_EMAIL; // Reply to this email
		private $fromName=GMAIL_FROM; // Name to indicate where the email came from when the recepient received
		private $replyTo=GMAIL_NO_REPLY; //email address to reply to
		// Name to indicate where the email came from when the recepient received
		
		function sendMail($subject,$toAddr,$msgHTML,$msgTxt) {
			//$logger=new Logger();
			try
			{
				//$logger->lwrite('Attempting to send email now');
				//echo 'Sending email now';
				$mail = new PHPMailer();
				$mail->IsSMTP(); // set mailer to use SMTP
				$mail->Host = $this->host; 
				$mail->Port = $this->port; 
				$mail->SMTPAuth = true; // turn on SMTP authentication
				$mail->Username = $this->username;
				$mail->Password = $this->password; 
				$from = $this->from; // Reply to this email
				$to=$toAddr; // Recipients email ID
				$name=$toAddr; // Recipient's name
				$mail->From = $from;
				$mail->FromName = $this->fromName; // Name to indicate where the email came from when the recepient received
				$mail->AddAddress($to,$name);
				$mail->AddReplyTo($from,$this->replyTo);
				$mail->WordWrap = 50; // set word wrap
				$mail->IsHTML(true); // send as HTML
				$mail->Subject = $subject;
				$mail->Body = $msgHTML; //HTML Body
				//echo "\n".'msg body'.$msgHTML."\n";
				$mail->AltBody = $msgTxt; //Text Body
				
				if(!$mail->Send())
				{
					//$logger->lwrite("Mailer Error: " . $mail->ErrorInfo." while sending email of subject ".$subject." to ".$toAddr);
					echo "Mailer Error: " . $mail->ErrorInfo." while sending email of subject ".$subject." to ".$toAddr;
				}
				else
				{
					//$logger->lwrite('Email sent to '.$toAddr.'. Subject is \''.$subject.'\'');
					echo "\n".'Email sent to '.$toAddr.'. Subject is \''.$subject.'\'';
				}
			}
			catch(Exception $e)
			{
				//$logger->lwrite($e->getMessage());
				echo $e->getMessage();
			}	
			
		}
		
	}
?>