
<?php

	include("connect.php");

?>

<!DOCTYPE html>
<html>

<head>

	<title>Админ панель</title>
	<link rel="stylesheet" href="style.css">
	<script src="jquery.js"></script>

	<style>
	
		main input{
			position: relative;
			display: block;
			width: calc(100% - 20px);
			padding: 5px 10px;
			margin: 10px 0px;
		}
		main div.submit{
			position: relative;
			margin: 10px 0px;
			padding: 10px 0px;
			background: black;
			color: white;
			font-weight: bold;
			text-align: center;
			cursor: pointer;
			user-select: none;
		}
		
		main div.paidPlace{
			width: 100%;
			position: relative;
		}
		main div.paidPlace span#name{
			font-weight: bold;
			margin: 10px 0px;
		}
		main div.paidPlace div.places{
			position: relative;
			width: 100%;
		}
		
		main div.paidPlace div.places div.orderPlace{
			
			position: relative;
			padding: 5px 10px;
			width: calc(100% - 20px);
			margin: 10px 0px;
			background: #e6e6e6;
			border-radius: 5px;
			
		}
		main div.paidPlace div.places div.orderPlace span{
			display: block;
		}
		
		main div.films{
			position: relative;
			margin: 10px 0px;
		}
		main div.films div.film{
			position: relative;
			padding: 5px 10px;
			width: calc(100% - 20px);
			border-radius: 5px;
			margin: 10px 0px;
			background: #e6e6e6;
		}
		main div.films div.film span{
			display: block;
		}
		main div.films div.film div.stopShow{
			position: relative;
			background: black;
			color: white;
			text-align: center;
			font-weight: bold;
			padding: 10px 0px;
			margin: 5px 0px;
			cursor: pointer;
		}
		
		main select#addSessionFilm{
			display: block;
			width: calc(100% - 0px);
			padding: 5px 10px;
			margin: 10px 0px 0px 0px;
		}
		main input#dateSession{
			position: relative;
			width: calc(100% - 20px);
			display: block;
			padding: 5px 10px;
		}
		main div.submitCreateNewSession{
			position: relative;
			display: block;
			background: black;
			padding: 10px 0px;
			text-align: center;
			color: white;
			margin: 0px 0px 10px 0px;
			cursor: pointer;
			user-select: none;
		}
		
	</style>

</head>

<body>
	
	<header>
		<a href="index.php"><span>Покупка билетов</span></a>
	</header>
	
	<main>
	
		<span id="selectFilms">Добавление фильма:</span>
		
		<input type="text" placeholder="Название фильма" id="name">
		<input type="text" placeholder="Страна съёмки" id="country">
		<input type="text" placeholder="Название дату первого проката" id="session">
		
		<div class="submit">Запустить в прокат</div>
		
		<span id="selectFilms">Фильмы:</span>
		
		<div class="films">
		
			<?php
				
				$listOrders = mysqli_query($connect, "SELECT * FROM `films`");
				
				while($film = mysqli_fetch_assoc($listOrders)){
					
					if($film['status'] == 0){
						echo '
					
							<div class="film film'.$film['id'].'">
								<span>Название: <b>'.$film['name'].'</b></span>
								<span>Страна съёмки: <b>'.$film['country'].'</b></span>
								
								<div class="stopShow" id="'.$film['id'].'">Остановить прокат</div>
								
							</div>
						
						';
					}else{
						
						echo '
					
							<div class="film film'.$film['id'].'">
								<span>Название: <b>'.$film['name'].'</b></span>
								<span>Страна съёмки: <b>'.$film['country'].'</b></span>
								
								<div class="stopShow" id="'.$film['id'].'">Запустить в прокат</div>
								
							</div>
						
						';
						
					}
					
				}
				
			?>
			
		</div>
		
		<span id="selectFilms">Добавить прокат к фильму:</span>
		
		<select id="addSessionFilm">
		
			<?php
			
				$listOrders = mysqli_query($connect, "SELECT * FROM `films`");
				
				while($film = mysqli_fetch_assoc($listOrders)){
					
					echo '
					
						<option value="'.$film['id'].'">'.$film['name'].'</option>
					
					';
					
				}
			
			?>
		
		</select>
		
		<input type="text" placeholder="Введите дату проката" id="dateSession">
		
		<div class="submitCreateNewSession">Добавить новый прокат</div>
		
		<div class="paidPlace">
		
			<span id="name">Оплаченные места:</span>
			
			<div class="places">
			
				<?php
				
					$listOrders = mysqli_query($connect, "SELECT * FROM `orderplace`");
					
					while($order = mysqli_fetch_assoc($listOrders)){
						
						$dataFilm = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `films` WHERE `id` = ".$order['idFilm'].""));
						
						echo '
						
							<div class="orderPlace">
								<span>Название фильма: <b>'.$dataFilm['name'].'</b></span>
								<span>ID сессии: <b>'.$order['idSession'].'</b></span>
								<span>Место: <b>'.$order['idPlace'].'</b></span>
								<span>Вариант оплаты: <b>'.$order['paid'].'</b></span>
							</div>
						
						';
						
					}
				
				?>
			
			</div>
			
		</div>
		
	</main>
	
	<script>
	
		window.onload = function(){
			
			$("main div.submit").click(function(){
				
				let name = $("main input#name").val();
				let country = $("main input#country").val();
				let session = $("main input#session").val();
				
				$.ajax({
					
					url: "addFilm.php",
					method: "POST",
					data: {
						
						name:name,
						country:country,
						session:session
						
					},
					success: function(data){
						
						location.href = "ap.php";
						
					}
					
				});
				
			});
			
			$("main div.films div.film div.stopShow").click(function(){
				
				let idFilm = $(this).attr("id");
				
				$.ajax({
					url: "changeStatusFilm.php",
					method: "POST",
					data: {
						idFilm:idFilm
					},
					success: function(data){
						
						location.href = "ap.php";
						
					}
				});
				
			});
			
			$("main div.submitCreateNewSession").click(function(){
				
				let idFilm = $("main select#addSessionFilm").val();
				let dateNewSession = $("main input#dateSession").val();
				
				console.log(idFilm+" "+dateNewSession);
				
				$.ajax({
					url: "createNewSession.php",
					method: "POST",
					data: {
						
						idFilm: idFilm,
						dateNewSession: dateNewSession
						
					},
					success: function(data){
						
						location.href = "ap.php";
						
					}
				});
				
			});
			
		};
	
	</script>

</body>

</html>