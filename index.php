<?php
$__time = microtime(true);
require_once("apu/apu.php");
Apu::listen();
//echo "<pre>";
//debug_r($_SERVER['REQUEST_URI'], false);
//echo "\n\n";
//debug_r($_REQUEST);
//echo "</pre>";
echo sprintf("%01.20f", microtime(true) - $__time);
?>