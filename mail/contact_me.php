<?php
require 'PHPMailerAutoload.php';
// Check for empty fields
if(empty($_POST['name'])  		||
   empty($_POST['email']) 		||
   empty($_POST['message'])	||
   !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
   {
	echo "No arguments Provided!";
	return false;
   }

$name = strip_tags(htmlspecialchars($_POST['name']));
$email_address = strip_tags(htmlspecialchars($_POST['email']));
$message = strip_tags(htmlspecialchars($_POST['message']));

// Create the email and send the message
$from = 'noreply@zelaf.eu';
$to = 'zelaf@zelaf.eu'; // Add your email address inbetween the '' replacing yourname@yourdomain.com - This is where the form will send a message to.
$reply_to = $email_address;
$email_subject = "Website Contact Form:  $name";
$email_body = "You have received a new message from your website contact form.\n\n"."Here are the details:\n\nName: $name\n\nEmail: $email_address\n\nPhone: $phone\n\nMessage:\n$message";
$email_html_body = "<html>You have recieved an email from your websites contact form. <br>Name: $name <br>Email: $email_address <br>Message: $message</html>";

$mailgun_domain = 'noreply.zelaf.eu'; // should look like samples.mailgun.org or like mg.ardao.me (not necessarily the domain but the subdomain you configured mailgun on)
$mailgun_smtp_password = '';

$mail = new PHPMailer;

$mail->isSMTP();
$mail->Host = 'smtp.mailgun.org';
$mail->SMTPAuth = true;
$mail->Username = 'contact@'.$mailgun_domain; //If using default account this should be postmaster, not contact
$mail->Password = $mailgun_smtp_password;
$mail->SMTPSecure = 'tls';
$mail->Port = 587;
$mail->setFrom($from, $name);
$mail->addAddress($to);
$mail->addReplyTo($reply_to);
$mail->Subject = $email_subject;
$mail->Body = $email_html_body;
$mail->AltBody = $email_body;

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}

return true;
?>
