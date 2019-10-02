<?php

namespace App;

use App\Models\Balance;


class BalanceUserDate
{
	public static function getDate1()
	{
		if (isset($_SESSION['date1'])) {
			
			$oldDateFormat = $_SESSION['date1'];
			$newDateFormat = date("d-m-Y", strtotime($oldDateFormat));
			return $newDateFormat;
			
		}
	}
	
	
	public static function getDate2()
	{
		if (isset($_SESSION['date2'])) {
			
			$oldDateFormat = $_SESSION['date2'];
			$newDateFormat = date("d-m-Y", strtotime($oldDateFormat));
			return $newDateFormat;
			
		}
	}
}