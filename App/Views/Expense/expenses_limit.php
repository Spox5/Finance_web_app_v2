<?php

include 'dbconnect.php';

header("Content-type: application/json");

	if (isset($_POST['category_id_ajax']) && isset($_POST['amount_ajax'])) {
		$amount = $_POST['amount_ajax'];
		$category_id = $_POST['category_id_ajax'];
		
		if (!empty($amount) && !empty($category_id)) {
			
			$sql = "SELECT * FROM expense_category WHERE id = $category_id";
			$sql_2 = "SELECT SUM(expenses.amount) AS sum FROM expenses WHERE category_id = $category_id";
			$result = mysqli_query($conn, $sql);
			$result_2 = mysqli_query($conn, $sql_2);
			$row = mysqli_fetch_assoc($result);
			$row_2 = mysqli_fetch_assoc($result_2);
			
			$limit = $row['amount_limit'];
			
			$message =
			 array
			 (
			 "limit" => $limit,
			 "suma" => $row_2['sum'],
			 "roznica" => $limit - $row_2['sum'],
			 "wynik" => $row_2['sum'] + $amount,
			 
			 );
			 
			 //echo $row['amount_limit'];
			 echo json_encode($message);
			
		}
	}
	

?>