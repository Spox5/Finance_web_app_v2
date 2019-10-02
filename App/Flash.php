<?php

namespace App;

//messages display from storage in session
class Flash
{
	////types of messages
	const SUCCESS = 'success';
	const INFO = 'info';
	const WARNING = 'warning';
	////
	
	public static function addMessage($message, $messageType = 'success')
	{
		//create array where we store the messages
		if (! isset($_SESSION['flash_notification'])) {
			
			$_SESSION['flash_notification'] = [];
		}
		
		//add message to array
		$_SESSION['flash_notifications'][] = [
			'body' => $message,
			'type' => $messageType
		];
	}
	
	public static function getMessages()
	{
		if (isset($_SESSION['flash_notifications'])) {
			$messages = $_SESSION['flash_notifications'];
			unset($_SESSION['flash_notifications']);
			
			return $messages;
		}
	}
}