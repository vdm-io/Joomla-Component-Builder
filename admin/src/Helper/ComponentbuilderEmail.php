<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
namespace VDM\Component\Componentbuilder\Administrator\Helper;

use Joomla\CMS\Factory;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Mail\Mail;
use Joomla\Registry\Registry;
use Joomla\CMS\Mail\MailerInterface;
use Joomla\CMS\Mail\MailerFactoryInterface;

\defined('_JEXEC') or die;

/**
 * Componentbuilder component email helper
 *
 * Provides a complete and configurable mailer integration for Joomla components.
 * Allows for custom headers, DKIM signing, embedded images, and HTML styling.
 *
 * @since  3.0
 */
abstract class ComponentbuilderEmail
{
	/**
	 * The active recipient.
	 *
	 * @var    array<string, mixed>
	 * @since  3.0
	 */
	public static array $active = [];

	/**
	 * Mail instances container.
	 *
	 * @var    MailerInterface[]
	 * @since  1.7.3
	 */
	protected static array $instances = [];

	/**
	 * Global Configuration object.
	 *
	 * @var    Registry|null
	 * @since  5.1.1
	 */
	protected static ?Registry $gConfig = null;

	/**
	 * Component Configuration object.
	 *
	 * @var    Registry|null
	 * @since  3.0
	 */
	protected static ?Registry $config = null;

	/**
	 * Mailer object.
	 *
	 * @var    MailerInterface|null
	 * @since  3.0
	 */
	protected static ?MailerInterface $mailer = null;

	/**
	 * Custom email headers.
	 *
	 * @var    array<string, string>
	 * @since  3.0
	 */
	protected static array $header = [];

	/**
	 * Retrieve the component configuration.
	 *
	 * @return  Registry  Component configuration object
	 * @since   3.0
	 */
	protected static function getConfig(): Registry
	{
		return self::$config ??= ComponentHelper::getParams('com_componentbuilder');
	}

	/**
	 * Retrieve the global configuration.
	 *
	 * @return  Registry  Global configuration object
	 * @since   3.0
	 */
	protected static function getGlobalConfig(): Registry
	{
		return self::$gConfig ??= Factory::getApplication()->getConfig();
	}

	/**
	 * Get or create a Mailer instance.
	 *
	 * @return  MailerInterface  A cloned Mail object instance
	 * @since   3.0
	 */
	public static function getMailer(): MailerInterface
	{
		return self::$mailer ??= self::createMailer();
	}

	/**
	 * Validate an email address using a selected pattern or callable.
	 *
	 * @param   string               $address        Email address to validate.
	 * @param   string|callable|null $patternselect  Validation pattern or callable.
	 * * `auto` Pick best pattern automatically;
	 * * `pcre8` Use the squiloople.com pattern, requires PCRE > 8.0, PHP >= 5.3.2, 5.2.14;
	 * * `pcre` Use old PCRE implementation;
	 * * `php` Use PHP built-in FILTER_VALIDATE_EMAIL;
	 * * `html5` Use the pattern given by the HTML5 spec for 'email' type form input elements.
	 * * `noregex` Don't use a regex: super fast, really dumb.
	 * Alternatively you may pass in a callable to inject your own validator, for example:
	 * PHPMailer::validateAddress('user@example.com', function($address) {
	 *     return (strpos($address, '@') !== false);
	 * });
	 * You can also set the PHPMailer::$validator static to a callable, allowing built-in methods to use your validator.
	 *
	 * @return  bool  True if valid, false otherwise
	 * @since   3.0
	 */
	public static function validateAddress(string $address, $patternselect = null): bool
	{
		return self::getMailer()->validateAddress($address, $patternselect);
	}

	/**
	 * Set a custom email header.
	 *
	 * @param   string  $key    Header name.
	 * @param   string  $value  Header value.
	 *
	 * @return  void
	 * @since   3.0
	 */
	public static function setHeader(string $key, string $value): void
	{
		self::$header[$key] = $value;
	}

	/**
	 * Get or create a Mail instance with specific configuration.
	 *
	 * @param   string  $id          Instance ID.
	 * @param   bool    $exceptions  Enable exceptions.
	 *
	 * @return  MailerInterface  Configured Mail instance
	 * @since   5.1.1
	 */
	public static function getInstance(string $id = 'Joomla', bool $exceptions = true): MailerInterface
	{
		if (!isset(self::$instances[$id]))
		{
			$config = clone self::getGlobalConfig();
			$config->set('throw_exceptions', $exceptions);
			self::$instances[$id] = Factory::getContainer()->get(MailerFactoryInterface::class)->createMailer($config);
		}

		return self::$instances[$id];
	}

	/**
	 * Create a configured Mail instance.
	 *
	 * @return  MailerInterface  The created Mail object with sender, reply-to and transport settings.
	 * @since   3.0
	 */
	protected static function createMailer(): MailerInterface
	{
		$conf   = self::getConfig();
		$mailer = $conf->get('mailer', 'global');
		$mail   = self::getInstance();

		if ($mailer === 'global')
		{
			$global = self::getGlobalConfig();
			$mailer = $global->get('mailer');
			$params = [
				'smtpauth'     => $global->get('smtpauth') ? 1 : null,
				'smtpuser'     => $global->get('smtpuser'),
				'smtppass'     => $global->get('smtppass'),
				'smtphost'     => $global->get('smtphost'),
				'smtpsecure'   => $global->get('smtpsecure'),
				'smtpport'     => $global->get('smtpport'),
				'sendmail'     => $global->get('sendmail'),
				'from'         => $global->get('mailfrom'),
				'name'         => $global->get('fromname'),
				'replyto'      => $global->get('replyto'),
				'replytoname'  => $global->get('replytoname'),
			];
		}
		else
		{
			$params = [
				'smtpauth'     => $conf->get('smtpauth') ? 1 : null,
				'smtpuser'     => $conf->get('smtpuser'),
				'smtppass'     => $conf->get('smtppass'),
				'smtphost'     => $conf->get('smtphost'),
				'smtpsecure'   => $conf->get('smtpsecure'),
				'smtpport'     => $conf->get('smtpport'),
				'sendmail'     => $conf->get('sendmail'),
				'from'         => $conf->get('emailfrom'),
				'name'         => $conf->get('fromname'),
				'replyto'      => $conf->get('replyto'),
				'replytoname'  => $conf->get('replytoname'),
			];
		}

		$mail->setSender([$params['from'], $params['name']]);

		if (!empty($params['replyto']) && !empty($params['replytoname']))
        {
			$mail->ClearReplyTos();
			$mail->addReplyTo($params['replyto'], $params['replytoname']);
		}

		switch ($mailer)
		{
			case 'smtp':
				$mail->useSMTP(
                    $params['smtpauth'],
                    $params['smtphost'],
                    $params['smtpuser'],
                    $params['smtppass'],
                    $params['smtpsecure'],
                    $params['smtpport']
                );
				break;
			case 'sendmail':
				$mail->useSendmail($params['sendmail']);
				$mail->IsSendmail();
				break;
			default:
				$mail->IsMail();
		}

		return $mail;
	}

	/**
	 * Compose and send an email with full options including attachments, HTML, DKIM, and reply-to support.
	 *
	 * @param   string|array       $recipient    Email or list of recipients.
	 * @param   string             $subject      Subject line.
	 * @param   string             $body         HTML body.
	 * @param   string|null        $textonly     Optional plain text fallback.
	 * @param   int                $mode         1 = HTML, 0 = plain text.
	 * @param   string|null        $bounce_email Optional bounce email address.
	 * @param   string|null        $idsession    Optional message tracking tag.
	 * @param   string|array|null  $mailreply    Optional reply-to address(es).
	 * @param   string|array|null  $replyname    Optional reply-to name(s).
	 * @param   string|null        $mailfrom     Optional sender email override.
	 * @param   string|null        $fromname     Optional sender name override.
	 * @param   array|null         $cc           CC recipients.
	 * @param   array|null         $bcc          BCC recipients.
	 * @param   array|string|null  $attachment   Attachments.
	 * @param   bool               $embeded      Embed image flag.
	 * @param   array|null         $embeds       Embedded image definitions.
	 *
	 * @return  bool  True on success, false on failure.
	 * @since   3.0
	 */
	public static function send(
		$recipient,
		string $subject,
		string $body,
		?string $textonly,
		int $mode = 0,
		?string $bounce_email = null,
		?string $idsession = null,
		$mailreply = null,
		$replyname = null,
		?string $mailfrom = null,
		?string $fromname = null,
		?array $cc = null,
		?array $bcc = null,
		$attachment = null,
		bool $embeded = false,
		?array $embeds = null
	): bool {
		$mail = self::getMailer();
		$conf = self::getConfig();

		if ($mailfrom && $fromname)
		{
			$mail->setSender([$mailfrom, $fromname]);
		}

		if ($bounce_email)
		{
			$mail->Sender = $bounce_email;
		}

		if ($idsession)
		{
			$mail->addCustomHeader('X-VDMmethodID:' . $idsession);
		}

		foreach (self::$header as $key => $val)
		{
			$mail->addCustomHeader($key . ':' . $val);
		}

		$mail->setSubject($subject);
		$mail->setBody($body);

		if ($mode)
		{
			$mail->isHTML(true);
			$mail->AltBody = $textonly;
		}

		if ($embeded && !empty($embeds))
		{
			foreach ($embeds as $embed)
			{
				$mail->addEmbeddedImage($embed->Path, $embed->FileName);
			}
		}

		$mail->addRecipient($recipient);
		if (!empty($cc)) $mail->addCC($cc);
		if (!empty($bcc)) $mail->addBCC($bcc);
		if (!empty($attachment)) $mail->addAttachment($attachment);

		if (!empty($mailreply))
		{
			$mail->ClearReplyTos();
			if (is_array($mailreply))
			{
				foreach ($mailreply as $i => $reply)
				{
					$mail->addReplyTo($reply, $replyname[$i] ?? '');
				}
			}
			else
			{
				$mail->addReplyTo($mailreply, (string) $replyname);
			}
		}

		$sent = false;
		$tmp = null;

		try {
			if (
				$conf->get('enable_dkim') &&
				($domain = $conf->get('dkim_domain')) &&
				($selector = $conf->get('dkim_selector')) &&
				($privateKey = $conf->get('dkim_private'))
			) {
				$mail->DKIM_domain     = $domain;
				$mail->DKIM_selector   = $selector;
				$mail->DKIM_identity   = $conf->get('dkim_identity') ?: $domain;
				$mail->DKIM_passphrase = $conf->get('dkim_passphrase');

				$tmp = tempnam(sys_get_temp_dir(), 'VDM');
				if ($tmp === false || file_put_contents($tmp, $privateKey) === false)
				{
					throw new \RuntimeException('Failed to create temporary DKIM private key file.');
				}

				$mail->DKIM_private = $tmp;
			}

			$sent = $mail->Send();
		} finally {
			if ($tmp && file_exists($tmp))
			{
				@unlink($tmp);
			}
		}

		$sent = $mail->Send();

		if ($tmp)
		{
			@unlink($tmp);
		}

		if (method_exists('ComponentbuilderHelper', 'storeMessage'))
		{
			$data = self::$active[$recipient] ?? $recipient;
			ComponentbuilderHelper::storeMessage($sent, $data, $subject, $body, $textonly, $mode, 'email');
			unset(self::$active[$recipient]);
		}

		return $sent;
	}

	/**
	 * Build a complete minimal HTML email body with basic headers.
	 * Use <br /> instead of <p> for layout consistency in emails.
	 *
	 * @param   string  $html     Body HTML content.
	 * @param   string  $subject  Email subject/title used in the <title> tag.
	 *
	 * @return  string  Full HTML email body.
	 * @since   3.0
	 */
	public static function setBasicBody(string $html, string $subject): string
	{
		return implode("\n", [
			'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">',
			'<html xmlns="http://www.w3.org/1999/xhtml">',
			'<head>',
			'<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />',
			'<meta name="viewport" content="width=device-width, initial-scale=1.0"/>',
			'<title>' . htmlspecialchars($subject) . '</title>',
			'<style type="text/css">',
			'#outlook a {padding:0;} .ExternalClass {width:100%;} .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height:100%;}',
			// 'p {margin: 0; padding: 0; font-size: 0px; line-height: 0px;}',
			'table, table td {border-collapse: collapse;}',
			'img {display:block; outline:none; text-decoration:none; -ms-interpolation-mode:bicubic;}',
			'a img {border:none;} a {text-decoration:none; color:#000001;} a.phone {pointer-events:auto; cursor:default; color:#000001 !important;}',
			'span {font-size:13px; line-height:17px; font-family:monospace; color:#000001;}',
			'</style>',
			'<!--[if gte mso 9]><style>/* Target Outlook 2007 and 2010 */</style><![endif]-->',
			'</head>',
			'<body style="width:100%; margin:0; padding:0; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%;">',
			$html,
			'</body>',
			'</html>'
		]);
	}

	/**
	 * Build a styled HTML email with outer table formatting for wide layout support.
	 * Suitable for rich content emails that need outer table structure.
	 *
	 * @param   string  $html     Inner body HTML content.
	 * @param   string  $subject  Email subject/title used in the <title> tag.
	 *
	 * @return  string  Complete HTML email content.
	 * @since   3.0
	 */
	public static function setTableBody(string $html, string $subject): string
	{
		return implode("\n", [
			'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">',
			'<html xmlns="http://www.w3.org/1999/xhtml">',
			'<head>',
			'<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />',
			'<meta name="viewport" content="width=device-width, initial-scale=1.0"/>',
			'<title>' . htmlspecialchars($subject) . '</title>',
			'<style type="text/css">',
			'#outlook a {padding:0;} .ExternalClass {width:100%;} .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height:100%;}',
			// 'p {margin: 0; padding: 0; font-size: 0px; line-height: 0px;}',
			'table, table td {border-collapse: collapse;}',
			'img {display:block; outline:none; text-decoration:none; -ms-interpolation-mode:bicubic;}',
			'a img {border:none;} a {text-decoration:none; color:#000001;} a.phone {pointer-events:auto; cursor:default; color:#000001 !important;}',
			'span {font-size:13px; line-height:17px; font-family:monospace; color:#000001;}',
			'</style>',
			'<!--[if gte mso 9]><style>/* Target Outlook 2007 and 2010 */</style><![endif]-->',
			'</head>',
			'<body style="width:100%; margin:0; padding:0; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%;">',
			'<table cellpadding="0" cellspacing="0" border="0" width="100%" style="line-height:100% !important;">',
			'<tr><td valign="top">',
			'<table cellpadding="0" cellspacing="0" border="0" align="center" width="800">',
			'<tr><td valign="top">',
			'<table cellpadding="0" cellspacing="0" border="0" align="center" width="780">',
			'<tr><td valign="top" style="vertical-align:top;">',
			$html,
			'</td></tr></table>',
			'</td></tr></table>',
			'</td></tr></table>',
			'</body>',
			'</html>'
		]);
	}
}
