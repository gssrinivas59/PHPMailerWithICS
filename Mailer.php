<?php
/* ------------------------------------------------------------------------ */
/* Mailer
/* ------------------------------------------------------------------------ */
/* G Sudhir Srinivas
/* Instagram: @sudhir_srinivas_official
/* Twitter: @sudhir_srinivas
/* https://github.com/gssrinivas59
/* ------------------------------------------------------------------------ */  

use PHPMailer\PHPMailer\PHPMailer;

class Mailer
{
    public $mailer;

	function  __construct ()
	{        
		$this->mailer = new PHPMailer;
		$this->mailer->isSMTP();
		$this->mailer->isHTML(true);
		$this->mailer->Host = "";
		$this->mailer->SMTPAuth = true;
		$this->mailer->SMTPSecure = "ssl";    
		$this->mailer->Port = "";
		$this->mailer->Username = "";
		$this->mailer->Password = "";
		$this->mailer->FromName = "";
		$this->mailer->From = "";
		$this->mailer->SMTPOptions = ['ssl' => ['verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true]];

		/*
		SMTP::DEBUG_OFF (0): Normal production setting; no debug output.
		SMTP::DEBUG_CLIENT (1): show client -> server messages only. Don't use this - it's very unlikely to tell you anything useful.
		SMTP::DEBUG_SERVER (2): show client -> server and server -> client messages - this is usually the setting you want
		SMTP::DEBUG_CONNECTION (3): As 2, but also show details about the initial connection; only use this if you're having trouble connecting (e.g. connection timing out)
		SMTP::DEBUG_LOWLEVEL (4): As 3, but also shows detailed low-level traffic. Only really useful for analyzing protocol-level bugs, very verbose, probably not what you need.
		*/
	}

	public function set_ical_content($ical_content, $name)
	{
		$this->mailer->addStringAttachment($ical_content,''.$name.'.ics','base64','text/calendar');
	}

	public function sendMail($to, $subject, $message, $to_name, $cc = array(), $debug = false)
	{
		if($debug != false) {
		    $this->mailer->SMTPDebug  = $debug;
		}

		if(!isset($to_name) || $to_name==null)
		{
		    $to_name = "";
		}

		$this->mailer->setFrom($this->mailer->From, $this->mailer->FromName);
		$this->mailer->clearAddresses();
		$this->mailer->addAddress($to, $to_name);

		if(count($cc) > 0) {
		    foreach ($cc as $key => $cc_email) {
			$this->mailer->addCC($cc_email);
		    }
		}

		//$mail->addAttachment('/var/tmp/file.tar.gz');
		//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');

		$this->mailer->Subject = $subject;
		$this->mailer->Body    = $message;

		//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';


		if ($this->mailer->send()) {
		    return true;
		} else {
		    return false;
		}
	}
}
