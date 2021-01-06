<?php 
$id=$_GET[id];
$enlace = $_GET[dire]."/".$id; 
header ("Content-Disposition: attachment; filename=".$id); 
header ("Content-Type: application/octet-stream"); 
header ("Content-Length: ".filesize($enlace)); 
readfile($enlace); 
?>