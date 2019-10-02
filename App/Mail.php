<?php

namespace App;

use App\Config;
use Mailgun\Mailgun;

class Mail
{
	public static function send($to, $subject, $text, $html)
	{
		//$mg = Mailgun::create('your_api_key'); // For US servers
		$mg = Mailgun::create('your_api_key', 'your_address'); // For EU servers

		// Now, compose and send your message.
		//$mg->messages()->send($domain, $params);
		$domain = Config::MAILGUN_DOMAIN;
		$mg->messages()->send($domain, [
		  'from'    => 'your_domain',
		  'to'      => $to,
		  'subject' => $subject,
		  'text'    => $text
		]);
	}
}