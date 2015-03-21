<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Agency</title>
	<link rel="stylesheet" type="text/css" href="./public/css/style.css">
</head>
<body>
	<?php
		$filename = "./public/data/data.json";
		$json_string = file_get_contents($filename);
		$obj = json_decode($json_string,true);
		$obj_len = count($obj);
		$agency = Array();
		for($i=0;$i<$obj_len;$i++) {
			$isHere = false;
			$isHereId = 0;
			for($j=0;$j<count($agency);$j++) {
				if($obj[$i]['Agency_Code']==$agency[$j]['Agency_Code']) {
					$isHere = true;
					$isHereId = $j;
					break;
				}
			}
			if(!$isHere) {
				$thisarray = array(
						'Agency_Code'=>$obj[$i]['Agency_Code'],
						'Agency_Name'=>$obj[$i]['Agency_Name'],
						'Plan_Cost'=>number_format($obj[$i]['Planned_Cost_m'],2),
						'Actual_Cost'=>number_format($obj[$i]['Projected_Actual_Cost'],2)
						);
				array_push($agency,$thisarray);
			} else {
				$agency[$isHereId]['Plan_Cost'] += number_format($obj[$isHereId]['Planned_Cost_m'],2);
				$agency[$isHereId]['Actual_Cost'] += number_format($obj[$isHereId]['Projected_Actual_Cost'],2);
			}
		}

		$charttitle = 'Actual Cost';
		$type = $_GET['type'];
		if($type == 1) {
			// echo count($agency);
			$charttitle = "Actual Cost";
			$agency_name = "";
			$data_show = "";
			for($k=0;$k<count($agency);$k++) {
				if($k==0) {
					$agency_name = $agency_name."'".$agency[$k]['Agency_Name']."'";
					$data_show = $data_show."{value:".$agency[$k]['Actual_Cost'].",name:'".$agency[$k]['Agency_Name']."'}";
				} else {
					$agency_name = $agency_name.",'".$agency[$k]['Agency_Name']."'";
					$data_show = $data_show.",{value:".$agency[$k]['Actual_Cost'].",name:'".$agency[$k]['Agency_Name']."'}";
				}
			}
		} else {
			if($type == 2) {
				$charttitle = 'PLAN COST';
				$agency_name = "";
				$data_show = "";
				for($k=0;$k<count($agency);$k++) {
					if($k==0) {
						$agency_name = $agency_name."'".$agency[$k]['Agency_Name']."'";
						$data_show = $data_show."{value:".$agency[$k]['Plan_Cost'].",name:'".$agency[$k]['Agency_Name']."'}";
					} else {
						$agency_name = $agency_name.",'".$agency[$k]['Agency_Name']."'";
						$data_show = $data_show.",{value:".$agency[$k]['Plan_Cost'].",name:'".$agency[$k]['Agency_Name']."'}";
					}
				}
			}
		}
		// print_r($agency);
		// print_r($obj);
	?>
	<div class="container">
		<div class="lcon">
			<div class="block_top">
				<span>Description</span>
			</div>
			<div class="block_con">
				<div class="showDes">
					&nbsp;&nbsp;&nbsp;&nbsp;This website displays the expenditures US government controls to each agency and compares the shares among those agencies. Besides, it details the investments each agency implements and shows each investment’s expenditures and time consumed. Users can choose the plan cost and actual cost to select which pie chart they want to see. When users focus on one agency, they can click the corresponding part on the pie chart to get more details. After clicking that, they can see a new page where they can select investment titles from the drop-down box. These webpages mainly focuses on helping government to know which agency they need pay more attention to and how much they need to pay for each agency. That also can give better understanding to citizens that what their government think highly of.
				</div>
			</div>
		</div>
		<div class="lcon">
			<div class="block_top">
				<span>The expenditure for each agencies</span>
			</div>
			<div class="block_con">
				<div class="btn_group">
					<a href="./agency.php?type=2" class="abtn">PLAN COST</a><a href="./agency.php?type=1" class="abtn">ACTUAL COST</a>
					<div class="clear"></div>
				</div>
			</div>
		</div>
		<div class="lcon">
			<div class="block_con">
				<div id="showdata" style="width:100%;height: 1000px;"></div>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="./public/js/jquery-1.8.2.min.js"></script>
	<script type="text/javascript" src="./public/js/echarts-plain.js"></script>
	<script type="text/javascript">
	$(document).ready(function() {
		var myChart = echarts.init(document.getElementById('showdata')); 
        
        option = {
		    title : {
		        text: 'Agency <?php echo $charttitle;?>',
		        x:'left'
		    },
		    tooltip : {
		        trigger: 'item',
		        formatter: "{a} <br/>Agency Name:{b} , {c} ({d}%)"
		    },
		    legend: {
		        orient : 'horizontal',
		        x : 'right',
		        y: 50,
		        data:[<?php echo $agency_name;?>],
		    },
		    calculable : true,
		    series : [
		        {
		            name:'Agency',
		            type:'pie',
		            radius : '55%',
		            center: ['50%', '50%'],
		            data:[
		               	<?php echo $data_show;?>
		            ]
		        }
		    ]
		};
        myChart.setOption(option);
        myChart.on(echarts.config.EVENT.CLICK,function(param){
        	var name = param.name;
        	// name = name.replace(/\s+/g,"_");
        	// window.open('/get/oneAgency/'+name+'/investment/all');
        });
	});
	</script>
</body>
</html>