<?php

	include("connect.php");
	
	$name = $_POST['name'];
	$country = $_POST['country'];
	$session = $_POST['session'];
	
	$lastId = ((integer) mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `films` ORDER BY `id` DESC LIMIT 1"))['id']) + 1;
	
	mysqli_query($connect, "INSERT INTO `films` (`id`, `name`, `country`, `status`, `dataAdded`) VALUES ({$lastId}, '{$name}', '{$country}', 1, ".time().")");
	
	mysqli_query($connect, "INSERT INTO `sessions` (`idFilm`, `timeBeing`) VALUES ({$lastId}, '{$session}')");
	
?>