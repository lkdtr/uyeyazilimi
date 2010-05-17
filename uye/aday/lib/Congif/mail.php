<?php

/*

	This is Congif's mail class
	Mail class has two parts
	 - sending
	 - recieving

	Depends :
		mail <dir> // phpmailer files

*/

class mail {

	// send init function // prepares to send method object
	function send_init($params){
		global $C;
		/*
			example :

				$mailer = mail::send_init(array(
					'host'     => 'gmail',  // or like this  ssl://smtp.gmail.com:465
					'username' => 'gmail_username',
					'password' => 'gmail_password',
					'from'     => 'Default From Address',
					'fromname' => 'Default From Name'
				));

		*/

		// setting default params if not set
		if( $C[mailer_config][sending] ){
			foreach ($C[mailer_config][sending] as $key => $val){
				if( empty($params[$key]) )  $params[$key] = $val;
			}
		}

		// PHP Mailer

			$libDir = $GLOBALS[C][PATH] .'mail/';
			// php mailer library
				require_once($libDir .'class.phpmailer.php');

			// new mailer object
				$mailer = new PHPMailer();
			// mailer params
				$mailer->PluginDir = $libDir;
				$mailer->Mailer    = 'smtp';
				$mailer->SMTPAuth  = true;
			// server vars (simply setting gmail if host string is "gmail")
				$mailer->Host      = ($params[host] == 'gmail' ? 'ssl://smtp.gmail.com:465' : $params[host]);
				$mailer->Username  = $params[username];
				$mailer->Password  = $params[password];
				// set port if set
				if($params[port]) $mailer->Port = $params[port];
			// message defaults
				$mailer->From      = $params[from];
				$mailer->FromName  = $params[fromName];
				$mailer->CharSet   = 'utf-8';
			// setting language for errors
				//$mailer->setLang('tr', $libDir);

		// returning mailer object
		return $mailer;
	}


	// send function
	function send($params){
		/*
			example :

				mail::send(array(
					'to'          => 'mail@domain.com',
					'toName'      => 'Mehmet Fatih YILDIZ',
					'replyTo'     => 'reply@other_domain.com',
					'replyToName' => 'reply To Name',
					'subject'     => 'Message Subject',
					'message'     => '<h1>Message Body</h1>',
					'html'        => true
				))

		*/


		// setting connection and mailer object
		$mailer = mail::send_init($params);

		// setting contact information
		$mailer->AddAddress($params[to], $params[toName]);
		if( $params[replyTo] )  $mailer->AddReplyTo($params[replyTo], $params[replyToName]);

		// setting message params
		$mailer->Subject = $params[subject];
		$mailer->Body    = $params[message];
		if( $params[html] )  $mailer->IsHTML(true);

		// sending mail
		return $mailer->Send();

	}

}

?>