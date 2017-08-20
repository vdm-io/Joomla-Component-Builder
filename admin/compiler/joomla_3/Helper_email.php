<?php
/*--------------------------------------------------------------------------------------------------------|  www.vdm.io  |------/
    __      __       _     _____                 _                                  _     __  __      _   _               _
    \ \    / /      | |   |  __ \               | |                                | |   |  \/  |    | | | |             | |
     \ \  / /_ _ ___| |_  | |  | | _____   _____| | ___  _ __  _ __ ___   ___ _ __ | |_  | \  / | ___| |_| |__   ___   __| |
      \ \/ / _` / __| __| | |  | |/ _ \ \ / / _ \ |/ _ \| '_ \| '_ ` _ \ / _ \ '_ \| __| | |\/| |/ _ \ __| '_ \ / _ \ / _` |
       \  / (_| \__ \ |_  | |__| |  __/\ V /  __/ | (_) | |_) | | | | | |  __/ | | | |_  | |  | |  __/ |_| | | | (_) | (_| |
        \/ \__,_|___/\__| |_____/ \___| \_/ \___|_|\___/| .__/|_| |_| |_|\___|_| |_|\__| |_|  |_|\___|\__|_| |_|\___/ \__,_|
                                                        | |                                                                 
                                                        |_| 				
/-------------------------------------------------------------------------------------------------------------------------------/

	@package		Component Builder
	@subpackage		componentbuilder.php
	@author			Llewellyn van der Merwe <https://www.vdm.io/joomla-component-builder>
	@my wife		Roline van der Merwe <http://www.vdm.io/>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
?>
###BOM###

/**
 * ###Component### component email helper
 */
abstract class ###Component###Email
{
	/**
	 * Configuraiton object
	 *
	 * @var    JConfig
	 */
	public static $config = null;

	/**
	 * Mailer object
	 *
	 * @var    JMail
	 */
	public static $mailer = null;

	/**
	 * Get a configuration object
	 *
	 */
	public static function getConfig()
	{
		if (!self::$config)
		{
			self::$config = JComponentHelper::getParams('com_###component###');
		}

		return self::$config;
	}
	
	/**
	 * Get a mailer object.
	 *
	 * Returns the global {@link JMail} object, only creating it if it doesn't already exist.
	 *
	 * @return  JMail object
	 *
	 * @see     JMail
	 */
	public static function getMailer()
	{
		if (!self::$mailer)
		{
			self::$mailer = self::createMailer();
		}

		$copy = clone self::$mailer;

		return $copy;
	}

	/**
	 * Create a mailer object
	 *
	 * @return  JMail object
	 *
	 * @see     JMail
	 */
	protected static function createMailer() 
	{
		// set component params
		$conf = self::getConfig();
		
		// now load the mailer
		$mailer = $conf->get('mailer', 'global');
		
		// Create a JMail object
		$mail = JMail::getInstance();

		// check if set to global
		if ('global' == $mailer)
		{
			// get the global details
			$globalConf	= JFactory::getConfig();
			
			$mailer		= $globalConf->get('mailer');
			$smtpauth	= ($globalConf->get('smtpauth') == 0) ? null : 1;
			$smtpuser	= $globalConf->get('smtpuser');
			$smtppass	= $globalConf->get('smtppass');
			$smtphost	= $globalConf->get('smtphost');
			$smtpsecure	= $globalConf->get('smtpsecure');
			$smtpport	= $globalConf->get('smtpport');
			$sendmail	= $globalConf->get('sendmail');
			$mailfrom	= $globalConf->get('mailfrom');
			$fromname	= $globalConf->get('fromname');
		}
		else
		{
			$smtpauth 	= ($conf->get('smtpauth') == 0) ? null : 1;
			$smtpuser 	= $conf->get('smtpuser');
			$smtppass 	= $conf->get('smtppass');
			$smtphost 	= $conf->get('smtphost');
			$smtpsecure	= $conf->get('smtpsecure');
			$smtpport 	= $conf->get('smtpport');
			$sendmail	= $conf->get('sendmail');
			$mailfrom	= $conf->get('mailfrom');
			$fromname	= $conf->get('fromname');
			$mailreply	= $conf->get('mailreply');
			$replyname	= $conf->get('replyname');
			
			// set the global reply-to
			if ($mailreply && $fromname)
			{
				$mail->ClearReplyTos();
				$mail->addReplyTo( array( $mailreply, $replyname ) );
			}
		}

		// Set global sender
		$mail->setSender(array($mailfrom, $fromname));

		// Default mailer is to use PHP's mail function
		switch ($mailer)
		{
			case 'smtp':
				// set the SMTP option
				$mail->useSMTP($smtpauth, $smtphost, $smtpuser, $smtppass, $smtpsecure, $smtpport);
				break;

			case 'sendmail':
				// set the sendmail option
				$mail->useSendmail($sendmail);
				$mail->IsSendmail();
				break;

			default:
				$mail->IsMail();
				break;
		}

		return $mail;
	}

	/**
	 * Send an email
	 *
	 * @return  bool on success
	 *
	 */
	public static function send($recipient, $subject, $body, $textonly, $mode = 0, $bounce_email = null, $idsession = null, $mailreply = null, $replyname = null , $mailfrom = null, $fromname = null, $cc = null, $bcc = null, $attachment = null, $embeded = null , $embeds = null)
	{
		
	 	// Get a JMail instance
		$mail = self::getMailer();
		
		// set component params
		$conf = self::getConfig();
		
		// do some house cleaning
		$mail->ClearReplyTos();
		
		// set if we have override
		if ($mailfrom && $fromname)
		{
			$mail->setSender(array($mailfrom, $fromname));
		}
		
		// load the bounce email as sender if set
		if (!is_null($bounce_email))
		{
		
			$mail->Sender = $bounce_email;
		}
		
		// Add tag to email to identify it 
		if (!is_null($idsession))
		{
			$mail->addCustomHeader('X-VDMmethodID:'.$idsession);
		}
		
		// set the subject & Body
		$mail->setSubject($subject);
		$mail->setBody($body);
		
		// Are we sending the email as HTML?
		if ($mode)
		{
			$mail->IsHTML(true);
			$mail->AltBody = $textonly;
		}

		//embed images
		if ($embeded)
		{
			if(###Component###Helper::checkArray($embeds))
			{
				foreach($embeds as $embed)
				{
					$mail->AddEmbeddedImage($embed->Path,$embed->FileName);
				}
			}
		}

		$mail->addRecipient($recipient);
		$mail->addCC($cc);
		$mail->addBCC($bcc);
		$mail->addAttachment($attachment);

		// Take care of reply email addresses
		if (is_array($mailreply))
		{
			$mail->ClearReplyTos();
			$numReplyTo = count($mailreply);
			for ($i=0; $i < $numReplyTo; $i++)
			{
				$mail->addReplyTo($mailreply[$i], $replyname[$i]);
			}
		}
		elseif (!empty($mailreply))
		{
			$mail->ClearReplyTos();
			$mail->addReplyTo($mailreply, $replyname);
		}
		
		// check if we can add the DKIM to email
		if ($conf->get('enable_dkim'))
		{
			if (!empty($conf->get('dkim_domain')) && !empty($conf->get('dkim_selector')) && !empty($conf->get('dkim_private')) && !empty($conf->get('dkim_public')))
			{
				$mail->DKIM_domain	= $conf->get('dkim_domain');
				$mail->DKIM_selector	= $conf->get('dkim_selector');
				$mail->DKIM_identity	= $conf->get('dkim_identity');
				$mail->DKIM_passphrase	= $conf->get('dkim_passphrase');
				
				$tmp			= tempnam(sys_get_temp_dir(), 'VDM');
				$h			= fopen($tmp, 'w');
				fwrite($h, $conf->get('dkim_private'));
				fclose($h);
				$mail->DKIM_private	= $tmp;
			}
		}
		
		$sendmail = $mail->Send();
		
		if ($conf->get('enable_dkim') && !empty($conf->get('dkim_domain')) && !empty($conf->get('dkim_selector')) && !empty($conf->get('dkim_private')) && !empty($conf->get('dkim_public')))
		{
			@unlink($tmp);
		}
		
		if (method_exists('###Component###Helper','storeMessage'))
		{
			// store the massage if the method is set
			###Component###Helper::storeMessage($sendmail, $recipient, $subject, $body, $textonly, $mode, 'email');
		}
		
		return $sendmail;
	}

	/**
	 * Set the HTML email body
	 *
	 * @return  string on success
	 *
	 */
	public static function setHtmlEmailBody($html, $subject)
	{
		$body = array();
		$body[] = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">";
		$body[] = "<html xmlns=\"http://www.w3.org/1999/xhtml\">";
		$body[] = "<head>";
		$body[] = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />";
		$body[] = "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\"/>";
		$body[] = "<title>".$subject."</title>";
		$body[] = "<style type=\"text/css\">";
		$body[] = "#outlook a {padding:0;}";
		$body[] = ".ExternalClass {width:100%;}";
		$body[] = ".ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;} ";
		$body[] = "p {margin: 0; padding: 0; font-size: 0px; line-height: 0px;} ";
		$body[] = "table td {border-collapse: collapse;}";
		$body[] = "table {border-collapse: collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; }";
		$body[] = "img {display: block; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic;}";
		$body[] = "a img {border: none;}";
		$body[] = "a {text-decoration: none; color: #000001;}";
		$body[] = "a.phone {text-decoration: none; color: #000001 !important; pointer-events: auto; cursor: default;}";
		$body[] = "span {font-size: 13px; line-height: 17px; font-family: monospace; color: #000001;}";
		$body[] = "</style>";
		$body[] = "<!--[if gte mso 9]>";
		$body[] = "<style>";
		$body[] = "/* Target Outlook 2007 and 2010 */";
		$body[] = "</style>";
		$body[] = "<![endif]-->";
		$body[] = "</head>";
		$body[] = "<body style=\"width:100%; margin:0; padding:0; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%;\">";
		$body[] = "\n<!-- body wrapper -->";
		$body[] = "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"margin:0; padding:0; width:100%; line-height: 100% !important;\">";
		$body[] = "<tr>";
		$body[] = "<td valign=\"top\">";
		$body[] = "<!-- edge wrapper -->";
		$body[] = "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" align=\"center\" width=\"800\" >";
		$body[] = "<tr>";
		$body[] = "<td valign=\"top\">";
		$body[] = "<!-- content wrapper -->";
		$body[] = "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" align=\"center\" width=\"780\">";
		$body[] = "<tr>";
		$body[] = "<td valign=\"top\" style=\"vertical-align: top;\">";
		$body[] = $html;
		$body[] = "</td>";
		$body[] = "</tr>";
		$body[] = "</table>";
		$body[] = "<!-- / content wrapper -->";
		$body[] = "</td>";
		$body[] = "</tr>";
		$body[] = "</table>";
		$body[] = "<!-- / edge wrapper -->";
		$body[] = "</td>";
		$body[] = "</tr>";
		$body[] = "</table>";
		$body[] = "<!-- / page wrapper -->";
		$body[] = "</body>";
		$body[] = "</html>";

		return implode("\n", $body);
	}
}
