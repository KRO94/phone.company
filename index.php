<?php
	if (!file_exists($_SERVER['DOCUMENT_ROOT']."/config.php")) { 
		require_once($_SERVER['DOCUMENT_ROOT']."/createDB.php");
	}
	require_once($_SERVER['DOCUMENT_ROOT']."/config.php");
	$db = new mysqli(DB_SERVER, DB_LOGIN, DB_PASSWORD, DB_NAME);
	// if (mysql_select_db(DB_NAME)) /*echo "GOOD;)"*/;

	$all_data_query = "SELECT * FROM users
					   INNER JOIN calls on calls.u_id=users.u_id
					   INNER JOIN tariffs on calls.t_id=tariffs.t_id 
					   ORDER BY c_id";

	$result = $db->query($all_data_query);

	// while ($row = mysql_fetch_assoc($result)) {
	// 	echo $row['card_number'];
	// 	echo ", ";
	// 	echo $row['city'];
	// 	echo ", ";
	// 	echo $row['minut_price'];
	// 	echo ", ";
	// 	echo $row['u_name'];
	// 	echo ", ";
	// 	echo $row['t_name'];
	// 	echo "</br>";
	// }
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>phone_company_db</title>
</head>
<body>
	<style>
		*{
			padding: 0;
			margin: 0;
			box-sizing: border-box;
		}
		html, body {
			width: 100%;
			min-height: 100%;
		}
		body{
			font-family: Arial;
			background: url(1.jpg) no-repeat;
			background-size: cover;
			font-size: 15px;
		}
		.wrapper{
			width: 100%;
			max-width: 900px;
			margin: 0 auto;
		}
		header{
			width: 100%;
			background: rgba(0, 0, 0, 0.8);
			padding: 20px 0;
			font-size: 3em;
			text-indent: 30px;
			color: #ffffff;
			font-style: italic;
			font-weight: bold;
			margin-bottom: 20px;
		}
		#content{
			width: 100%;
		}
		#ex-9{
			cursor: pointer;
		}
		#ex-39{
			cursor: pointer;
		}
		.close{
			display: none;
		}
		.open{
			display: block;
		}
		.left_bar{
			width: 25%;
			background: rgba(0, 0, 0, 0.7);
			color: #ffffff;
			position: relative;
			float:left;
			margin-right: 5%;
			padding: 10px;
		}
		.left_bar li{
		padding:5px 0;
		margin-left: 20px;
		}
		h1{
			text-align: center;
			font-style: italic
		}
		table{
			background: rgba(0, 0, 0, 0.4);
			margin: 0px auto;
			font-size: 1.2em;
			width: 70%;
			position: relative;
			float:left;
		}
		td{
			 background: rgba(0, 0, 0, 0.5);
			 color: #ffffff;
			 text-align: center;
			 padding: 5px;
		}
		.main{
			color: #aaaaaa;
			font-weight: bold;
		}
	</style>
	<header>
		<div class="wrapper">
			Phone Company
		</div>
	</header>
	<div id="content">
	<div class="wrapper">
		<span class="button">
			<button id="ex-9" onclick = "addClass()">Task 9</button>
			<button id="ex-39" onclick = "addClass1()">Task 39</button>
				<table id = "task9" class = "close">
					  <tr class="main">
						<td>Університет</td>
						<td>Рейтинг</td>		
					  </tr>
							<tr>
								<td><?php echo $row['univ_name']; ?></td>
								<td><?php echo $row['rating']." ".$row['surname']; ?></td>		
							 </tr>
				</table>
				<table id = "task39" class = "close">
					  <tr class="main">
						<td>Університет1</td>
						<td>Рейтинг1</td>		
					  </tr>
							<tr>
								<td><?php echo $row['univ_name']; ?></td>
								<td><?php echo $row['rating']." ".$row['surname']; ?></td>		
							 </tr>
				</table>
		</span>
		<div class="left_bar">
			<h1>Tariffs</h1>
			<ul>
				<li><h2>Night</h2>
					<ul>
						<li>Minute of call - 15 cent</li>
						<li>Connection fee - 20 cent</li>
					</ul>
				</li>
				<li><h2>Students</h2>
					<ul>
						<li>Minute of call - 5 cent</li>
						<li>Connection fee - 10 cent</li>
					</ul>
				</li>
				<li><h2>Bisness</h2>
					<ul>
						<li>Minute of call - 10 cent</li>
						<li>Connection fee - 25 cent</li>
					</ul>
				</li>
				<li><h2>Granny</h2>
					<ul>
						<li>Minute of call - 14 cent</li>
						<li>Connection fee - 2 cent</li>
					</ul>
				</li>
				<li><h2>Light</h2>
					<ul>
						<li>Minute of call - 19 cent</li>
						<li>Connection fee - 15 cent</li>
					</ul>
				</li>
			</ul>
		</div>
			<table>
				  <tr class="main">
					<td>ID</td>
					<td>Name</td>		
					<td>City</td>
					<td>Duration</td>		
					<td>Price</td>
					<td>Tariff</td>
				  </tr>
				<?php 			
					while ($row = $result->fetch_assoc()) { ?>
						<tr>
							<td><?php echo $row['c_id']; ?></td>
							<td><?php echo $row['u_name']." ".$row['surname']; ?></td>		
							<td><?php echo $row['city']; ?></td>
							<td><?php echo round($row['duration']/60000)." min"; ?></td>
							<td><?php echo "$ ".(($row['minut_price']*round($row['duration']/60000) + $row['connect_price'])/100); ?></td>		
							<td><?php echo $row['t_name']; ?></td>
						 </tr>
				<?php	}
				?>
			</table>
	</div>
</div>
<script>
var count = 0;
var count1 = 0;
var task1 = document.getElementById("task9");
var task2 = document.getElementById("task39");
	function addClass(){
		task1.className = "open";
		task2.className = "close";
		count1 = 0;
		count++;
		if(count>1){
		task1.className = "close";
		count = 0;
		}
	}
		function addClass1(){
		task2.className = "open";
		task1.className = "close";
		count1++;
		count = 0;
		if(count1>1){
		task2.className = "close";
		count1 = 0;
		}
	}
</script>
</body>
</html>