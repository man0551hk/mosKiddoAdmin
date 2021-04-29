<?php
session_start();
$num = rand(1000,9999);
$id = rand(0,25);

$arr = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
$test = $arr[$id] . $num;

$_SESSION["verifyCode"] = $test;
$height = 25;
$width = 65;

$image_p = imagecreate($width, $height);
$black = imagecolorallocate($image_p, 0, 0, 0);
$white = imagecolorallocate($image_p, 255, 255, 255);
$font_size = 14;

imagestring($image_p, $font_size, 5, 5, $test, $white);
imagejpeg($image_p, null, 80);
?>