<?php
header("content-disposition: attachment;filename=validarchip.xls");
header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
require('comun.inc');
require('funciones.inc');
//session_start();
date_default_timezone_set("America/Bogota");

//TRIMESTRE Y VIGENCIA CHIP
$arrper=array('','Ene-Mar','Abr-Jun','Jul-Sep','Oct-Dic');
if($_POST[nperiodo]<4){
	$trimchip=$_POST[nperiodo]-1;
	$vigchip=$_POST[vigencias];
}
else{
	$trimchip=4;
	$vigchip=$_POST[vigencias]-1;
}
//FIN CHIP
echo'<table>
	<tr>
		<td colspan="4" align="center"><strong>VALIDAR SALDOS CHIP</strong></td>
	</tr>
	<tr>
		<td align="center">Trimestre</td>
		<td align="center">'.$arrper[$_POST[nperiodo]].'</td>
		<td align="center">Vigencia</td>
		<td align="center">'.$_POST[vigencias].'</td>
	</tr>
	<tr>
		<td>Cuenta</td>
		<td>Nombre</td>
		<td>Saldo Inicial Balance '.$arrper[$_POST[nperiodo]].' '.$_POST[vigencias].'</td>
		<td>Saldo Final CHIP '.$arrper[$trimchip].' '.$vigchip.'</td>
	</tr>';
	$con=0;
	while ($con<count($_POST[dcuentas]))
	{	
		$miles=$_POST[dsaldoant][$con];
		if((strlen($_POST[dcuentas][$con])==6)&&(number_format($miles)!=number_format($_POST[dsaldochip][$con]))){
			$estilo='background-color:#FF9';
		}
		else{
			$estilo='background-color:#FFF';
		}	
		echo'<tr style="'.$estilo.'">
			<td>'.$_POST[dcuentas][$con].'</td>
			<td>'.$_POST[dncuentas][$con].'</td>
			<td>'.number_format($miles,0,',','.').'</td>
			<td>'.number_format($_POST[dsaldochip][$con],0,',','.').'</td>
		</tr>';
	$con=$con+1;
	}
echo'</table>';
?> 


