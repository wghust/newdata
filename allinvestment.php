<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>All Investments</title>
	<link rel="stylesheet" type="text/css" href="./public/css/style.css">
</head>
<body>
	<?php
		$filename = "./public/data/data.json";
		$json_string = file_get_contents($filename);
		$obj = json_decode($json_string,true);
		$obj_len = count($obj);
		$investments = array();
		$Agency_Name = $_GET['agencyname'];
		$Agency_Name = str_replace("_"," ",$Agency_Name);
		for($i=0;$i<$obj_len;$i++) {
			if($obj[$i]['Agency_Name'] == $Agency_Name) {
				$isHas = false;
				for($j=0;$j<count($investments);$j++) {
					if($obj[$i]['Identifier']==$investments[$j]['Identifier']) {
						$isHas = true;
						break;
					}
				}
				if(!$isHas) {
					$thisInvest = array(
						'Agency_Name'=>$obj[$i]['Agency_Name'],
						'Agency_Code'=>$obj[$i]['Agency_Code'],
						'Identifier'=>$obj[$i]['Identifier'],
						'Investment_Title'=>$obj[$i]['Investment_Title']
						);
					array_push($investments,$thisInvest);
				}

			}
		}
	?>
	<div class="container">
		<div class="lcon">
			<div class="block_top">
				<span>Investment Titles</span>
			</div>
			<div class="block_con">
				<div class="btn_group">
					<?php
					for($s=0;$s<count($investments);$s++) {
						$nowName = str_replace(" ","_",$investments[$s]['Agency_Name']);
					?>
					<a href="./investment.php?agencyname=<?php echo $nowName; ?>&identifier=<?php echo $investments[$s]['Identifier']; ?>" class="abtn investbtn"><?php echo $investments[$s]['Investment_Title']?></a>
					<?php
					}
					?>
					<div class="clear"></div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>