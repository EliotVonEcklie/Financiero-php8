<?php //V 1000 12/12/16 ?> 
<?php require"funciones.inc";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<script language="JavaScript" type="text/javascript">
function crearcalendario()
 {
var mes = new Array();
mes[0] = "Enero"; mes[1] = "Febrero";
mes[2] = "Marzo"; mes[3] = "Abril";
mes[4] = "Mayo"; mes[5] = "Junio";
mes[6] = "Julio"; mes[7] = "Agosto";
mes[8] = "Setiembre"; mes[9] = "Octubre";
mes[10] = "Noviembre"; mes[11] = "Diciembre";
var fechaActual = new Date();
var mesActual = fechaActual.getMonth();
fechaActual.setDate(1);
document.write("<table border=1 cellpadding=3 cellspacing=0>");
document.write("<tr>");
document.write("<td colspan=7 align='center'>" + mes[mesActual] + "</td>");
document.write("<tr>");
document.write("<td align='center'>D</td>");
document.write("<td align='center'>L</td>");
document.write("<td align='center'>M</td>");
document.write("<td align='center'>M</td>");
document.write("<td align='center'>J</td>");
document.write("<td align='center'>V</td>");
document.write("<td align='center'>S</td>");
document.write("</tr>");

if (fechaActual.getDay() != 0) {
document.write("<tr>");
for (i = 0; i < fechaActual.getDay(); i++) {
document.write("<td> </td>");
}
}
while (fechaActual.getMonth() == mesActual) {
if (fechaActual.getDay == 0) {
document.write("<tr>");
}
document.write("<td align='center'>" + fechaActual.getDate() + "</td>");
if (fechaActual.getDay() == 6) {
document.write("</tr>");
}
fechaActual.setDate(fechaActual.getDate() + 1);
}

for (i = fechaActual.getDay(); i <= 6; i++) {
document.write("<td> </td>");
}
document.write("</table>");
 }
</script> 
<?php titlepag();?>
</head>
<body>
</body> 
</html>