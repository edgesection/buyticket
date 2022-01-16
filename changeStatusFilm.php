<?php

	include("connect.php");
	
	$idFilm = $_POST['idFilm'];
	
	$lastId = (integer) mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `films` WHERE `id` = {$idFilm}"))['status'];
	
	if($lastId == 1){
		
		mysqli_query($connect, "UPDATE `films` SET `status` = 0 WHERE `id` = {$idFilm}");
		
	}else{
		
		mysqli_query($connect, "UPDATE `films` SET `status` = 1 WHERE `id` = {$idFilm}");
		
	}
	
?>