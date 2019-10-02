<?php

namespace App;

use App\Models\Balance;


class BalanceSum
{
	public static function getSumCurrentMonth()
	{
		if (isset($_SESSION['user_id'])) {
			return Balance::showBalanceSummary($_SESSION['user_id']);
		}
	}
	
	
	public static function getSumPreviousMonth()
	{
		if (isset($_SESSION['user_id'])) {
			return Balance::showBalancePreviousMonthSummary($_SESSION['user_id']);
		}
	}
	
	
	public static function getSumPresentYear()
	{
		if (isset($_SESSION['user_id'])) {
			return Balance::showBalancePresentYearSummary($_SESSION['user_id']);
		}
	}
	
	
	public static function getSumUserPeriod()
	{
		if (isset($_SESSION['user_id'], $_SESSION['date1'], $_SESSION['date2'])) {
			return Balance::showBalanceUserPeriodSummary($_SESSION['user_id'], $_SESSION['date1'], $_SESSION['date2']);
		}
	}
	
}