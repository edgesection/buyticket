
<?php

	include("connect.php");
	
	$film = $_GET['idFilm'];
	
	$getInfoFilm = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `films` WHERE `id` = ".$film.""));

?>

<!DOCTYPE html>
<html>

<head>

	<title>Покупка билетов</title>
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="session.css">
	<script src="jquery.js"></script>

</head>

<body>
	
	<header>
		<a href="index.php"><span>Покупка билетов</span></a>
	</header>
	
	<main>
		<span id="selectFilms">Выбранный фильм: <?php echo $getInfoFilm['name']; ?></span>
		
		<select id="selectSessions">
			<option value="none">Выберите сеанс</option>
			<?php
				
				$sessions = mysqli_query($connect, "SELECT * FROM `sessions` WHERE `idFilm` = ".$film."");
				
				while($session = mysqli_fetch_assoc($sessions)){
					
					echo '
					
						<option value="'.$session['id'].'">'.$session['id'].' сеанс '.$session['timeBeing'].'</option>
					
					';
					
				}
				
			?>
		</select>
		
		<select id="selectPlace">
			<option value="none">Выберите место</option>
			<?php
				
				$busyPlace = array();
				
				$sessions = mysqli_query($connect, "SELECT * FROM `places` WHERE `idSession` = 1");
					
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
		</select>
		
		<select id="selectPay">
			<option value="none">Выберите способ оплаты</option>
			<option value="paypal">PayPal</option>
			<option value="qiwi">QIWI</option>
			<option value="ymoney">ЮMoney</option>
			<option value="webmoney">WebMoney</option>
			<option value="sber">Сбербанк</option>
		</select>
		
		<div class="buyPlace">Купить место</div>
		
	</main>
	
	<script>
	
	window.onload = function(){
		
		$("main select#selectSessions").click(function(){
			
			let session = $("main select#selectSessions").val();
			
			if(session == "none"){
				
				return false;
				
			}else{
				
				let idFilm = location.search.replace("?idFilm=", "");
				
				$.ajax({
					url: "loadPlaces.php",
					method: "POST",
					data: {
						idFilm: idFilm,
						session: session
					},
					success: function(data){
						
						$("main select#selectPlace").html(data);
						
					}
				});
				
			}
			
		});
		
		$("main div.buyPlace").click(function(){
			
			let idFilm = location.search.replace("?idFilm=", "");
			let session = $("main select#selectSessions").val();
			let place = $("main select#selectPlace").val();
			let pay = $("main select#selectPay").val();
			
			console.log(idFilm+"\n"+session+"\n"+place+"\n"+pay);
			
			if(idFilm == "none" || session == "none" || place == "none" || pay == "none"){
				
				return false;
				
			}else{
				
				location.href = "buyPlace.php?idFilm="+idFilm+"&session="+session+"&place="+place+"&pay="+pay;
				
			}
			
		});
		
	};
	
	</script>

</body>

</html>