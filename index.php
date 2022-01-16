
<?php

	include("connect.php");

?>

<!DOCTYPE html>
<html>

<head>

	<title>Покупка билетов</title>
	<link rel="stylesheet" href="style.css">
	<script src="jquery.js"></script>

</head>

<body>
	
	<header>
		<a href="index.php"><span>Покупка билетов</span></a>
	</header>
	
	<main>
		<span id="selectFilms">Выбор фильма:</span>
		
		<div class="films">
		
		<?php
		
			$films = mysqli_query($connect, "SELECT * FROM `films` WHERE `status` = 0");
			
			while($film = mysqli_fetch_assoc($films)){
				
				echo '
				
					<a href="session.php?idFilm='.$film['id'].'"><div class="film film'.$film['id'].'">
						<span id="name">Название: <b>'.$film['name'].'</b></span>
						<span id="countryRec">Страна съёмки: <b>'.$film['country'].'</b></span>
					</div></a>
				
				';
				
			}
		
		?>
		
		</div>
		
	</main>

</body>

</html>