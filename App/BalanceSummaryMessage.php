<?php

namespace App;

//messages display from storage in session
class BalanceSummaryMessage
{
	////types of messages
	const GOOD = 'good';
	const NORMAL = 'normal';
	const BAD = 'bad';
	////
	
	public static function addMessageCurrent($message, $messageType = 'normal')
	{
		$_SESSION['summary_message_current'] = [];
		
		$_SESSION['summary_message_current'] [] = [
			'body' => $message,
			'type' => $messageType
		];
	}
	
	public static function getMessagesCurrent()
	{
		if (isset($_SESSION['summary_message_current'])) {
			$messages = $_SESSION['summary_message_current'];
			return $messages;
		}
	}
	
	
	
	public static function addMessagePrevious($message, $messageType = 'normal')
	{
		$_SESSION['summary_message_previous'] = [];
		
		$_SESSION['summary_message_previous'] [] = [
			'body' => $message,
			'type' => $messageType
		];
	}
	
	public static function getMessagesPrevious()
	{
		if (isset($_SESSION['summary_message_previous'])) {
			$messages = $_SESSION['summary_message_previous'];
			return $messages;
		}
	}
	
	
	
	public static function addMessagePresentYear($message, $messageType = 'normal')
	{
		$_SESSION['summary_message_present_year'] = [];
		
		$_SESSION['summary_message_present_year'] [] = [
			'body' => $message,
			'type' => $messageType
		];
	}
	
	public static function getMessagesPresentYear()
	{
		if (isset($_SESSION['summary_message_present_year'])) {
			$messages = $_SESSION['summary_message_present_year'];
			return $messages;
		}
	}
	
	
	
	public static function addMessageUserPeriod($message, $messageType = 'normal')
	{
		$_SESSION['summary_message_user_period'] = [];
		
		$_SESSION['summary_message_user_period'] [] = [
			'body' => $message,
			'type' => $messageType
		];
	}
	
	public static function getMessagesUserPeriod()
	{
		if (isset($_SESSION['summary_message_user_period'])) {
			$messages = $_SESSION['summary_message_user_period'];
			return $messages;
		}
	}
	
}