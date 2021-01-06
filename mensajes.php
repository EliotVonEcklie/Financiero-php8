<?php //V 1000 12/12/16 ?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/css3.css" rel="stylesheet" type="text/css" />
<style>
.inicio{
font-family:Verdana, Arial, Helvetica, sans-serif;
font-size:13px;
background-color:#eee;
width:99.8%;
font-weight:bold;
color:#222; 	
border: #FFFFFF 1px solid;
margin-left:3px;
margin-right:1px;
margin-bottom:1px;
margin-top:1px;
padding-left:1px;
padding-right:1px;
/*filter:alpha(opacity=80);*/
    -moz-border-radius: 3px;  
    -webkit-border-radius: 3px;
	box-shadow: 0 0 5px #222;
    -webkit-box-shadow: 0 0 5px #222;
    -moz-box-shadow: 0 0 5px #222;}
.saludo1{
font-family:Verdana, Arial, Helvetica, sans-serif;
font-size:12px;
background-color:#ffffff;
font-weight:normal;
border:#CCCCCC 1px solid;
padding-left:3px;
padding-right:3px;
margin-bottom:1px;
margin-top:1px;
height:10px;
    -moz-border-radius: 2px;  
    -webkit-border-radius: 2px;
}
</style>
</head>
<body>
<table class='inicio' style="top:3%;height: 11%;left: 10%;width: 60%;position:absolute; "><tr><td class='saludo1'><center><img src='imagenes\alert.png'>No se puede eliminar el Evento ya que se esta usando en el Calendario<img src='imagenes\alert.png'></center></td></tr></table>
<input type="button"  value="Aceptar" onclick="parent.winbuscar.despliegamodal('hidden')" style="top:17%;height: 6%;left: 34%;width: 10%;position:absolute; " />
</body>
</html>