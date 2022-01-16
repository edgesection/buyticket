<?php

	include("connect.php");
	
	$film = $_POST['idFilm'];
	$session = $_POST['session'];
	
	echo '<option value="none">Выберите место</option>';

	$busyPlace = array();
				
	$sessions = mysqli_query($connect, "SELECT * FROM `places` WHERE `idSession` = ".$session."");
					
	while($session = mysqli_fetch_assoc($sessions)){
					
		if($session['status'] == 1){
						
			array_push($busyPlace, $session['place']);
						
		}
					
	}
					
	for($i = 1; $i <= 60; $i++){
					
		if(array_search($i, $busyPlace) !== false){
			continue;
		}
					
		echo '
					
			<option value="'.$i.'">'.$i.' место</option>
					
		';
					
	}

?>