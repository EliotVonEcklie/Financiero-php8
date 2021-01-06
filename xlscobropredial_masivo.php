<?php //V 1000 12/12/16 ?> 
<?php
header("content-disposition: attachment;filename=cobropredial.xls");
header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
require"comun.inc";
?>
<html>
<body>
	<table>
		<tr>
			<td>Cedula Catastral</td>
			<td>Tercero</td>
			<td>Total Deuda</td>
		</tr>
	<?php
$disc=count($_POST[dcodcatas]);
$nuevo="";
$actual="";
for($v=0;$v<$disc;$v++)
{
if($nuevo=="")
{
//$actual=$_POST[vigencias][$v];
$nuevo=1;
}
	
if($_POST[dcodcatas][$v]!=$actual)
{

$linkbd=conectar_bd();

$direccion="";
$tercero="";
$ntercero="";
$sqlr="select *from tesopredios where cedulacatastral='".$_POST[dcodcatas][$v]."' and estado='S'";
//echo $sqlr;
$res=mysql_query($sqlr,$linkbd);
while($row=mysql_fetch_row($res))
 {
  $direccion=$row[7];
  $tercero=$row[5];
  $ntercero=$row[6];
 }
$actual=$_POST[dcodcatas][$v];
$cont=$v;
$igual=1;
$totdeuda=0;
	while($igual==1)
	 {	
	 if($_POST[dcodcatas][$v]==$_POST[dcodcatas][$cont])
	 {
	 $totage=0;	 
	$interes=$_POST[dinteres1][$cont]+$_POST[dipredial][$cont];
	$totage=$_POST[dpredial][$cont]+$interes+$_POST[dimpuesto2][$cont]+$_POST[dinteres2][$cont]+$_POST[dimpuesto1][$cont];	
	$cont+=1;
	$totdeuda+=$totage;
	 }
	 else
	 {
	 $igual=0;
	 }
	 }
	 
if($totdeuda>=1000000){	 
	echo'<tr>
		<td>'.$_POST[dcodcatas][$v].'</td>
		<td>'.$ntercero.'</td>
		<td>'.$totdeuda.'</td>
	</tr>';
}
 	?>
	</table>
</body>
</html>