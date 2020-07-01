<?php

require (APPROOT .'/libraries/PHPMailer-master/src/PHPMailer.php');
require (APPROOT .'/libraries/PHPMailer-master/src/SMTP.php');
require (APPROOT .'/libraries/PHPMailer-master/src/Exception.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailController {
	
    public static function sendMail($html, $subject, $att, $filename, $address, $addAddress, $altBody)
	{
        $ausdruckdatum = date("Y_m_d");
        
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions

        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';
        
		try {
			//Server settings
            //$mail->SMTPDebug = 3;                                 // Enable verbose debug output
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';
			$mail->isSMTP();                                   
            $mail->Host = ''; 
            $mail->SMTPAuth = true;                               
            $mail->Username = '';              
            $mail->Password = '';                        
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to
 
			//Recipients
			$mail->setFrom('', '');
            $companyaddresses = explode(',', $address);
            foreach ($companyaddresses as $address) {
            $mail->AddAddress($address);
            }

            if(!empty($_POST['addmail'])){

                $customaddresses = explode(',', $addAddress);
                foreach ($customaddresses as $address) {
                $mail->AddAddress($address);
                }
            } 
         
            $mail->addCC('');

            $mail->addAttachment($att, $filename);
			//Content
			$mail->isHTML(true);                                  // Set email format to HTML
			$mail->Subject = $subject;
			$mail->Body    = $html;
            $mail->AltBody = $altBody;

			$mail->send();
			return true;
			
			}  catch (Exception $e) {
            echo "<div class='alert alert-danger'>Kundenmail wurde nicht versendet.", $mail->ErrorInfo;
            echo "</div>";
		}
		
	}
}

?>