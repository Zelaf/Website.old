<?php
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

$mailgun_domain = ''; // should look like samples.mailgun.org or like mg.ardao.me (not necessarily the domain but the subdomain you configured mailgun on)
$mailgun_apikey = ''; // should look like api:key-3ax6xnjp29jd6fds4gc373sgvjxteol0

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,"https://api.mailgun.net/v3/$mailgun_domain/messages");
curl_setopt($ch, CURLOPT_USERPWD, "");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('from' => $from, 'to' => $to, 'h:Reply-To' => $reply_to, 'subject' => $email_subject, 'text' => $email_body)));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_output = curl_exec ($ch);

curl_close ($ch);

return true;
?>
