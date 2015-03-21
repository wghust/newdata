<!DOCTYPE html>
<html>
<head>
	151532.9255	-36.13414634	-35.88518293	3.613734104	3.191707317	14154.89814	82.69662038
	<meta charset="utf-8">
	<title>One Investment</title>
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
		$Identifier = $_GET['identifier'];
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

		function getDayLast($date1,$date2) {
			$date1_list = explode('/',$date1);
			$date2_list = explode('/',$date2);
			$d1 = mktime(0,0,0,$date1_list[1],$date1_list[0],$date1_list[2]);
			$d2 = mktime(0,0,0,$date2_list[1],$date2_list[0],$date2_list[2]);
			$day = ($d2-$d1)/3600/24;
			return round($day);
		}

		// print_r($obj);
		$projects = array();
		for($g=0;$g<$obj_len;$g++) {
			if($obj[$g]['Agency_Name'] == $Agency_Name&&$obj[$g]['Identifier']==$Identifier) {
				$nowday = getDayLast($obj[$g]['Start_Date'],$obj[$g]['Completion_Date']);
				$oneproject = array(
					'projectName'=>$obj[$g]['Project_Name'],
					'projectId'=>$obj[$g]['Project_ID'],
					'projectcost'=>$obj[$g]['Projected_Actual_Cost'],
					'timeday'=>$nowday
					);
				array_push($projects,$oneproject);
			}
		}
		$c_projectName = "";
		$c_projectTimeLast = "";
		$c_projectCost = "";
		for($s=0;$s<count($projects);$s++) {
			if($s==0) {
				$c_projectName .= "'".$projects[$s]['projectName']."'";
				$c_projectTimeLast .= $projects[$s]['timeday'];
				$c_projectCost .= $projects[$s]['projectcost'];
			} else {
				$c_projectName .= ",'".$projects[$s]['projectName']."'";
				$c_projectTimeLast .=",".$projects[$s]['timeday'];
				$c_projectCost .=",".$projects[$s]['projectcost'];
			}
		}

		// echo $c_projectCost;
	?>
	<div class="container">
		<div class="lcon">
			<div class="block_top">
				<span>Investment Titles</span>
			</div>
			<div class="block_con" style="max-height:300px;overflow-y:scroll">
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
		<div class="lcon">
			<div class="block_con">
				<div id="showdata" style="width:100%;height: 500px;"></div>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="./public/js/jquery-1.8.2.min.js"></script>
	<script type="text/javascript" src="./public/js/echarts-plain.js"></script>
	<script type="text/javascript">
	$(document).ready(function() {
		var myChart = echarts.init(document.getElementById('showdata')); 
		option = {
		    tooltip : {
		        trigger: 'axis'
		    },
		    calculable : true,
		    legend: {
		        data:['time consumed/day','Actual cost']
		    },
		    xAxis : [
		        {
		            type : 'category',
		            data : [<?php echo $c_projectName; ?>]
		        }
		    ],
		    yAxis : [
		    	{
		            type : 'value',
		            name : 'time consumed/day',
		            axisLabel : {
		                formatter: '{value} days'
		            }
		        },
		        {
		            type : 'value',
		            name : 'Actual cost',
		            axisLabel : {
		                formatter: '{value} $M'
		            }
		        },
		    ],
		    series : [
		    	{
		            name:'time consumed/day',
		            type:'bar',
		            data:[<?php echo $c_projectTimeLast ?>]
		        },

		        {
		            name:'Actual cost',
		            type:'line',
		            yAxisIndex: 1,
		            data:[<?php echo $c_projectCost;?>],
		        }
		    ]
		};
	    myChart.setOption(option);
	});
	</script>
</body>
</html>