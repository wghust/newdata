<?php
// $number = 1234.5678; 
// $english_format_number = number_format($number, 2, '.', ''); 
// echo  $english_format_number +2; // 1234.57 

$date1 = '13/12/2010';
$date2 = '30/09/2016';
$date1_list = explode('/',$date1);
$date2_list = explode('/',$date2);
$d1 = mktime(0,0,0,$date1_list[1],$date1_list[0],$date1_list[2]);
$d2 = mktime(0,0,0,$date2_list[1],$date2_list[0],$date2_list[2]);
$day = ($d2-$d1)/3600/24;
echo "<br>".$day;
?>