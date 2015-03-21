<?php
$number = 1234.5678; 
$english_format_number = number_format($number, 2, '.', ''); 
echo  $english_format_number +2; // 1234.57 
?>