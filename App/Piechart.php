<?php

namespace App;

use App\Models\Balance;

//messages display from storage in session
class Piechart
{
	
	public static function getPieChartCurrentMonth()
	{
		if (isset($_SESSION['user_id'])) {
			return Balance::showPieChartCurrentMonth($_SESSION['user_id']);
		}
	}
	
	
	public static function getPieChartPreviousMonth()
	{
		if (isset($_SESSION['user_id'])) {
			return Balance::showPieChartPreviousMonth($_SESSION['user_id']);
		}
	}
	
	
	public static function getPieChartPresentYear()
	{
		if (isset($_SESSION['user_id'])) {
			return Balance::showPieChartPresentYear($_SESSION['user_id']);
		}
	}
	
	
	public static function getPieChartUserPeriod()
	{
		if (isset($_SESSION['user_id'], $_SESSION['date1'], $_SESSION['date2'])) {
			return Balance::showPieChartUserPeriod($_SESSION['user_id'], $_SESSION['date1'], $_SESSION['date2']);
		}
	}
	
}