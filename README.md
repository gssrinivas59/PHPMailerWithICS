# PHPMailerWithICS

You Can Install PHPMailer from 
https://github.com/PHPMailer/PHPMailer

How To Use
```php
<?php

require_once(__DIR__ . '/EasyGenrateICS.php');

$invite = new EasyGenrateICS("Test Event");
$invite->addOrganizer("Sudhir Srinivas", "sudhir@test.com");
$invite->showRsvpBtns(); // if you want to show RSVP buttons, use this line
$inlive->addLocation("Hyderabad");
$invite->addEvent('2023-03-10 09:00:00','2023-03-10 10:52:54',"Test Summary","Test Description","https://example.com/115498");
$ical_content = $invite->render(false);


require_once(__DIR__ . '/Mailer.php');

$mailer = new Mailer();
$mailer->set_ical_content($ical_content, "Test Event");

$to = "sudhir@example.com";
$to_name = "Sudhir Srinivas";
$cc = array();

$debug_mode = 0;
/*
SMTP::DEBUG_OFF (0): Normal production setting; no debug output.
SMTP::DEBUG_CLIENT (1): show client -> server messages only. Don't use this - it's very unlikely to tell you anything useful.
SMTP::DEBUG_SERVER (2): show client -> server and server -> client messages - this is usually the setting you want
SMTP::DEBUG_CONNECTION (3): As 2, but also show details about the initial connection; only use this if you're having trouble connecting (e.g. connection timing out)
SMTP::DEBUG_LOWLEVEL (4): As 3, but also shows detailed low-level traffic. Only really useful for analyzing protocol-level bugs, very verbose, probably not what you need.
*/

$subject = "Test Event Mail";
$message = "Use Html Code here";

$mailer->sendMail($to, $subject, $message, $to_name, $cc, $debug_mode);

?>
