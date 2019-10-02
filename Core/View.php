<?php

namespace Core;

use App\Models\Income;

/**
 * View
 *
 * PHP version 7.0
 */
class View
{

    /**
     * Render a view file
     *
     * @param string $view  The view file
     * @param array $args  Associative array of data to display in the view (optional)
     *
     * @return void
     */
    public static function render($view, $args = [])
    {
        extract($args, EXTR_SKIP);

        $file = dirname(__DIR__) . "/App/Views/$view";  // relative to Core directory

        if (is_readable($file)) {
            require $file;
        } else {
            throw new \Exception("$file not found");
        }
    }

    /**
     * Render a view template using Twig
     *
     * @param string $template  The template file
     * @param array $args  Associative array of data to display in the view (optional)
     *
     * @return void
     */
    public static function renderTemplate($template, $args = [])
    {
        echo static::getTemplate($template, $args);
    }
	
	public static function getTemplate($template, $args = [])
    {
        static $twig = null;

        if ($twig === null) {
            $loader = new \Twig_Loader_Filesystem(dirname(__DIR__) . '/App/Views');
            $twig = new \Twig_Environment($loader);
			$twig->addGlobal('current_user', \App\Auth::getUser());
			$twig->addGlobal('flash_messages', \App\Flash::getMessages());
			
			$twig->addGlobal('incomes_category', \App\ShowRadioButtons::getIncomeCategory());
			$twig->addGlobal('expenses_category', \App\ShowRadioButtons::getExpenseCategory());
			$twig->addGlobal('payment_methods_category', \App\ShowRadioButtons::getPaymentMethods
			());
			
			
			//////////////////////////////////BALANCE//////////////////////////////////////
			$twig->addGlobal('balance_incomes_current_month', \App\BalanceTable::getIncomesCurrentMonth());
			$twig->addGlobal('balance_expenses_current_month', \App\BalanceTable::getExpensesCurrentMonth());
			$twig->addGlobal('balance_sum_current_month', \App\BalanceSum::getSumCurrentMonth());
			$twig->addGlobal('summary_message_current', \App\BalanceSummaryMessage::getMessagesCurrent());
			$twig->addGlobal('piechart_current_month', \App\Piechart::getPieChartCurrentMonth());
			
			
			$twig->addGlobal('balance_incomes_previous_month', \App\BalanceTable::getIncomesPreviousMonth());
			$twig->addGlobal('balance_expenses_previous_month', \App\BalanceTable::getExpensesPreviousMonth());
			$twig->addGlobal('balance_sum_previous_month', \App\BalanceSum::getSumPreviousMonth());
			$twig->addGlobal('summary_message_previous', \App\BalanceSummaryMessage::getMessagesPrevious());
			$twig->addGlobal('piechart_previous_month', \App\Piechart::getPieChartPreviousMonth());
			
			
			$twig->addGlobal('balance_incomes_present_year', \App\BalanceTable::getIncomesPresentYear());
			$twig->addGlobal('balance_expenses_present_year', \App\BalanceTable::getExpensesPresentYear());
			$twig->addGlobal('balance_sum_present_year', \App\BalanceSum::getSumPresentYear());
			$twig->addGlobal('summary_message_present_year', \App\BalanceSummaryMessage::getMessagesPresentYear());
			$twig->addGlobal('piechart_present_year', \App\Piechart::getPieChartPresentYear());
			
			
			$twig->addGlobal('balance_date1', \App\BalanceUserDate::getDate1());
			$twig->addGlobal('balance_date2', \App\BalanceUserDate::getDate2());
			$twig->addGlobal('balance_incomes_user_period', \App\BalanceTable::getIncomesUserPeriod());
			$twig->addGlobal('balance_expenses_user_period', \App\BalanceTable::getExpensesUserPeriod());
			$twig->addGlobal('balance_sum_user_period', \App\BalanceSum::getSumUserPeriod());
			$twig->addGlobal('summary_message_user_period', \App\BalanceSummaryMessage::getMessagesUserPeriod());
			$twig->addGlobal('piechart_user_period', \App\Piechart::getPieChartUserPeriod());
			/////////////////////////////////END//////////////////////////////////////////////
        }

        return $twig->render($template, $args);
    }
}
