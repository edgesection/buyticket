<?php

	include("connect.php");
	
	$idFilm = $_GET['idFilm'];
	$session = $_GET['session'];
	$place = $_GET['place'];
	$pay = $_GET['pay'];
	
	mysqli_query($connect, "INSERT INTO `places` (`idSession`, `place`, `status`) VALUES ({$session}, {$place}, 1)");
	mysqli_query($connect, "INSERT INTO `orderplace` (`idFilm`,`idSession`,`idPlace`,`paid`) VALUES ({$idFilm}, {$session}, {$place}, '{$pay}')");
	
	$getInfoFilm = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `films` WHERE `id` = ".$idFilm.""));

?>

<!DOCTYPE html>
<html>

<head>

	<title>Оплата произведена успешно</title>
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="session.css">
	<script src="jquery.js"></script>

</head>

<body>
	
	<header>
		<a href="index.php"><span>Покупка билетов</span></a>
	</header>
	
	<main>
	
		<span id="selectFilms">Вы успешно купили место №<?php echo $place; ?> (сессия №<?php echo $session; ?>) на фильм '<?php echo $getInfoFilm['name']; ?>'.</span>
		
	</main>
	
	<script>
	
	window.onload = function(){
		
	};
	
	</script>

</body>

</html>