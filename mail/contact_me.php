<?php
require 'PHPMailerAutoload.php';
// Check for empty fields
if(empty($_POST['name'])  		||
   empty($_POST['email']) 		||
   empty($_POST['phone']) 		||
   empty($_POST['message'])	||
   !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
   {
	echo "No arguments Provided!";
	return false;
   }

$name = strip_tags(htmlspecialchars($_POST['name']));
$email_address = strip_tags(htmlspecialchars($_POST['email']));
$phone = strip_tags(htmlspecialchars($_POST['phone']));
$message = strip_tags(htmlspecialchars($_POST['message']));

// Create the email and send the message
$from = 'noreply@zelaf.eu'
$to = 'contact@zelaf.eu'; // Add your email address inbetween the '' replacing yourname@yourdomain.com - This is where the form will send a message to.
$reply_to = $email_address;
$email_subject = "Website Contact Form:  $name";
$email_body = "You have received a new message from your website contact form.\n\n"."Here are the details:\n\nName: $name\n\nEmail: $email_address\n\nPhone: $phone\n\nMessage:\n$message";

$mailgun_domain = 'noreply.zelaf.eu'; // should look like samples.mailgun.org or like mg.ardao.me (not necessarily the domain but the subdomain you configured mailgun on)
$mailgun_smtp_password = '';

$mail = new PHPMailer;

$mail->isSMTP();
$mail->Host = 'smtp.mailgun.org';
$mail->SMTPAuth = true;
$mail->Username = 'postmaster@'.$mailgun_domain;
$mail->Password = $mailgun_smtp_password;
$mail->SMTPSecure = 'tls';
$mail->Port = 587;     
$mail->setFrom($from, $name);
$mail->addAddress($to);
$mail->addReplyTo($reply_to);
$mail->Subject = $email_subject;
$mail->Body = $email_body;
$mail->AltBody = $email_body;

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}

return true;
?>
