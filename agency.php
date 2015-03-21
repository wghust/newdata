<!DOCTYPE html>
<html>
<head>
	<meta charset="uft-8">
	<title>Agency</title>
	<link rel="stylesheet" type="text/css" href="./public/css/style.css">
</head>
<body>
	<?php
		$filename = "./public/data/data.json";
		$json_string = file_get_contents($filename);
		$obj = json_decode($json_string,true);
		print_r($obj);
	?>
	<div class="lcon">
		<div class="block_top">
			<span></span>
		</div>
		<div class="block_con">

		</div>
	</div>
	<script type="text/javascript" src="./public/js/jquery-1.8.2.min.js"></script>
	<script type="text/javascript" src="./public/js/echarts-plain.js"></script>
</body>
</html>