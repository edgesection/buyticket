<?php

	include("connect.php");
	
	$idFilm = $_POST['idFilm'];
	$dateNewSession = $_POST['dateNewSession'];
	
	mysqli_query($connect, "INSERT INTO `sessions` (`idFilm`, `timeBeing`) VALUES ({$idFilm}, '{$dateNewSession}')");
	
?>