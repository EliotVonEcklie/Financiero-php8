<?php //V 1000 12/12/16 ?> 
<?php 
require"comun.inc";
require"funciones.inc";
session_start();
cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
//**niveles menu: Administracion (0) - Consultas (1) - Herramientas (2) - Reportes (3)
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<title>:: Spid - Contabilidad</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
<script>
//************* ver reporte ************
//***************************************
function verep(idfac)
{
  document.form1.oculto.value=idfac;
  document.form1.submit();
  }
//************* genera reporte ************
//***************************************
function genrep(idfac)
{
  document.form2.oculto.value=idfac;
  document.form2.submit();
  }

function pdf()
{
document.form2.action="pdfbalance.php";
document.form2.target="_BLANK";
document.form2.submit(); 
document.form2.action="";
document.form2.target="";
}
</script>

<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
    <tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
    <tr><?php menu_desplegable("cont");?></tr>
		<tr>
			<td colspan="3" class="cinta">
				<a href="cont-tipodoc.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a>
				<a href="#" onClick="document.form2.submit();" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a>
				<a href="#" onClick="document.form2.submit()" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
				<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
				<a href="#" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="nueva ventana"></a>
				<a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png" title="imprimir"></a>
				<a href="cont-balancepruebaexcel.php" target="_blank" class="mgbt"><img src="imagenes/excel.png" title="excel"></a>
				<a href="<?php echo "archivos/".$_SESSION[usuario]."balanceprueba-nivel$_POST[nivel].csv"; ?>" target="_blank" class="mgbt"><img src="imagenes/csv.png" title="csv"></a>
		</td>
	</tr>
</table>
 <form name="form2" method="post" action="cont-balanceprueba.php">
    <table  align="center" class="inicio" >
      <tr >
        <td class="titulos" colspan="6" >.: Balance de Prueba</td>
        <td  class="cerrar"><a href="cont-principal.php">Cerrar</a></td>
      </tr>
      <tr  >
        <td class="saludo1">Nivel:</td>
        <td ><select name="nivel" id="nivel">
				   <?php
				   $niveles=array();
		   $link=conectar_bd();
  		   $sqlr="Select * from nivelesctas  where estado='S' order by id_nivel";
			// echo $sqlr;
		 		$resp = mysql_query($sqlr,$link);
				while ($row =mysql_fetch_row($resp)) 
				{
				$i=$row[0];
				$niveles[]=$row[4];
				echo "<option value=$row[0] ";
				if($i==$_POST[nivel])
			 	{
				 echo "SELECTED";
				 }
				echo " >".$row[0]."</option>";	  
			     }			
		  ?>
        </select>   <input name="oculto" type="hidden" value="1">     </td>
        <td class="saludo1" >Mes Inicial:</td>
        <td><input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">         <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>        </td>
        <td class="saludo1">Mes Final: </td>
        <td><input name="fecha2" type="text" id="fc_1198971546" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha2]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">         <a href="#" onClick="displayCalendarFor('fc_1198971546');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>        </td></tr>
       <tr> <td class="saludo1" >Cuenta Inicial: </td>
        <td ><input name="cuenta1" type="text" id="cuenta1" size="8" value="<?php echo $_POST[cuenta1]; ?>"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this) " > <a href="#" onClick="mypop=window.open('cuentas-ventana.php','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=900,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a></td>
        <td class="saludo1" >Cuenta Final: </td>
		<td ><input name="cuenta2" type="text" id="cuenta2" size="8" value="<?php echo $_POST[cuenta2]; ?>"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this) "> <a href="#" onClick="mypop=window.open('cuentas-ventana.php','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=900,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a></td>
        <td ><input type="button" name="generar" value="Generar" onClick="document.form2.submit()"></td>
       </tr>  
	   <tr><td></td></tr>                  
    </table>
    
	<div class="subpantallap">
  <?php
 
  //**** para sacar la consulta del balance se necesitan estos datos ********
  //**** nivel, mes inicial, mes final, cuenta inicial, cuenta final, cc inicial, cc final  
$oculto=$_POST['oculto'];
if($_POST[oculto])
{
$linkbd=conectar_bd();
ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf1=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
	$fechaf2=$fecha[3]."-".$fecha[2]."-".$fecha[1];

	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	$fechafa2=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
	$f1=$fechafa2;	
	$f2=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
	
	$fechafa=$_SESSION[vigencia]."-01-01";
	$fechafa2=date('Y-m-d',$fechafa2-((24*60*60)));

//Borrar el balance de prueba anterior
$sqlr2="select distinct digitos, posiciones from nivelesctas where estado='S' ORDER BY id_nivel DESC ";
$resn=mysql_query($sqlr2,$linkbd);
$rown=mysql_fetch_row($resn);
$nivmax=$rown[0];
$dignivmax=$rown[1];

$sqlr="Delete from balancepre";
mysql_query($sqlr,$linkbd);

$sqlr="Delete from balanceprueba";
mysql_query($sqlr,$linkbd);
//continuar**** creacion balance de prueba
//$namearch="archivos/".$_SESSION[usuario]."balanceprueba.csv";
//$Descriptor1 = fopen($namearch,"w+"); 
//fputs($Descriptor1,"CODIGO;CUENTA;SALDO ANTERIOR;DEBITO;CREDITO;SALDO FINAL\r\n");

  echo "<table class='inicio' ><tr><td colspan='6' class='titulos'>Balance de Prueba</td></tr>";
  echo "<tr><td class='titulos2'>Codigo</td><td class='titulos2'>Cuenta</td><td class='titulos2'>Saldo Anterior</td><td class='titulos2'>Debito</td><td class='titulos2'>Credito</td><td class='titulos2'>Saldo Final</td></tr>";
    $tam=$niveles[$_POST[nivel]-1];
$crit1=" and left(cuenta,$tam)>='$_POST[cuenta1]' and left(cuenta,$tam)<='$_POST[cuenta2]' ";
$sqlr2="select distinct left(cuenta,$tam),tipo from cuentas where estado ='S' and tipo='Auxiliar' ".$crit1." group by left(cuenta,$tam) order by cuenta ";
$rescta=mysql_query($sqlr2,$linkbd);
$i=0;
//echo $sqlr2;
while ($row =mysql_fetch_row($rescta)) 
 {
$si=0;
$saldoperant=0;
    $tam=$niveles[$_POST[nivel]-1];
  $sqlr="select distinct left(comprobante_det.cuenta,$tam),(sum(comprobante_det.valdebito)-sum(comprobante_det.valcredito)) as saldof from comprobante_cab,comprobante_det where left(comprobante_det.cuenta,$tam)=left($row[0],$tam) and  comprobante_det.id_comp=CONCAT(comprobante_cab.tipo_comp,' ',comprobante_cab.numerotipo) and  comprobante_det.vigencia='".$_SESSION[vigencia]."' and comprobante_cab.estado='1' and comprobante_cab.tipo_comp='7' group by left(comprobante_det.cuenta,$tam) order by comprobante_cab.tipo_comp, comprobante_cab.numerotipo,comprobante_det.id_det ";
   $res2=mysql_query($sqlr,$linkbd);
	$row2 =mysql_fetch_row($res2);
	 $si=$row2[1];
	 	mysqli_free_result($res2);
	 //****periodo anterior
	  $sqlr="select distinct left(comprobante_det.cuenta,$tam),(sum(comprobante_det.valdebito)-sum(comprobante_det.valcredito)) as saldof from comprobante_cab,comprobante_det where left(comprobante_det.cuenta,$tam)=left($row[0],$tam) and  comprobante_cab.fecha between '$fechafa' and '$fechafa2' and comprobante_det.id_comp=CONCAT(comprobante_cab.tipo_comp,' ',comprobante_cab.numerotipo) and  comprobante_det.vigencia='".$_SESSION[vigencia]."' and comprobante_cab.estado='1' and comprobante_cab.tipo_comp<>'7' group by left(comprobante_det.cuenta,$tam) ";
$res4=mysql_query($sqlr,$linkbd);
//	 echo "<br>".$sqlr;
while ($row4 =mysql_fetch_row($res4)) 
   {
	$saldoperant=$row4[1];	
	}
	mysqli_free_result($res4);
	 $si+=$saldoperant;
  //*************
  $nomc=buscacuenta($row[0]);
if($_POST[cuenta1]!='' && $_POST[cuenta2]!='')
$crit1=" and $row[0]>='$_POST[cuenta1]' and $row[0]<='$_POST[cuenta2]' ";
 $cuent=$row[0]; 	
  $sqlr="select distinct left(comprobante_det.cuenta,".$niveles[$_POST[nivel]-1]."),sum(comprobante_det.valdebito),sum(comprobante_det.valcredito) from comprobante_cab inner join comprobante_det on comprobante_det.id_comp=CONCAT(comprobante_cab.tipo_comp,' ',comprobante_cab.numerotipo)  where  left(comprobante_det.cuenta,".$niveles[$_POST[nivel]-1].")=left($cuent,".$niveles[$_POST[nivel]-1].") and  comprobante_cab.fecha between '$fechaf1' and '$fechaf2' and  comprobante_det.vigencia='".$_SESSION[vigencia]."' and comprobante_cab.estado='1' and comprobante_cab.tipo_comp<>'7' group by left(comprobante_det.cuenta,".$niveles[$_POST[nivel]-1].") ";
  $res=mysql_query($sqlr,$linkbd);
	// echo "<br>".$sqlr;
  $debs=0;
	$creds=0;
	$saldos=0;
  if($res)
   {
	$debs=0;
	$creds=0;
	$saldos=0;
  while($row2=mysql_fetch_row($res))
  {
  
  $debs=$row2[1];
	$creds=$row2[2];
  $saldos=$si+$debs-$creds;
  }
  //*********************
  //*************
  $nomc=buscacuenta($row[0]);
//  echo "<tr class='saludo1'><td>$row[0]</td><td>$row[3]</td><td>$row[1]</td><td>$row[2]</td></tr>";
if(($si<0 || $si>0) || ($debs<0 || $debs>0) || ($creds<0 || $creds>0))
 {
$i+=1;
 $sqlr2="insert into balancepre (id,cuenta,nombre,saldo_anterior,debito,credito,saldo_final,tipo) values($i,$row[0],'$nomc',$si,$debs,$creds,$saldos,'$row[5]') ";
	mysql_query($sqlr2,$linkbd);
	//echo "<br>	Sql: ".$sqlr2;
 $si=0;
	$debs=0;
	$creds=0;
	$saldos=0;
 }
 $si=0;
	$debs=0;
	$creds=0;
	$saldos=0;
	mysqli_free_result($res);
   }
 }  
//   fputs($Descriptor1,$row[0].";".$row[3].";".$row[1].";".$row[2]."\r\n");
//  echo "<br>".$sqlr2;
 
 //******* lectura archivo *****
 $i=0;
 for ($x=0;$x<$_POST[nivel];$x++)
 { 
 $sqlr="select distinct left(cuenta,$niveles[$x]),sum(debito),sum(credito), nombre,sum(saldo_final),tipo,sum(saldo_anterior) from balancepre group by left(cuenta,$niveles[$x])";
 //echo "<br>$sqlr";
 $res=mysql_query($sqlr,$linkbd);
  while($row=mysql_fetch_row($res))
  {
  $i+=1;
  $saldofinal=$row[6]+$row[1]-$row[2];
  $nomc=existecuenta($row[0]);
	$sqlr2="insert into balanceprueba (id,cuenta,nombre,saldo_anterior,debito,credito,saldo_final,tipo)    	values($i,$row[0],'$nomc',".round($row[6],2).",".round($row[1],2).",".round($row[2],2).",".round($saldofinal,2).",'$row[5]') ";
	mysql_query($sqlr2,$linkbd);
  }
 } 
 //*******************
 $sqlr="select *from balanceprueba order by cuenta";
 $res=mysql_query($sqlr,$linkbd);
 $_POST[tsaldoant]=0;
	 $_POST[tdebito]=0;
	 $_POST[tcredito]=0;
	 $_POST[tsaldofinal]=0;
	 
	 $namearch="archivos/".$_SESSION[usuario]."balanceprueba-nivel$_POST[nivel].csv";
$Descriptor1 = fopen($namearch,"w+"); 
fputs($Descriptor1,"CODIGO;CUENTA;SALDO ANTERIOR;DEBITO;CREDITO;SALDO FINAL\r\n");
	 $co='saludo1';
	 $co2='saludo2';
  while($row=mysql_fetch_row($res))
  {
	   $negrilla="style='font-weight:bold'";
	  if (strlen($row[1])==($dignivmax))
		{
		// $negrilla=" "; 
		 //$_POST[tsaldoant]+=$row[3];
		 //$_POST[tdebito]+=$row[4];
		 //$_POST[tcredito]+=$row[5];
		 }
	 if($niveles[$_POST[nivel]-1]==strlen($row[1]))
		  {
			  $negrilla=" ";  
			$_POST[tsaldoant]+=$row[3];
			 $_POST[tdebito]+=$row[4];
	 		$_POST[tcredito]+=$row[5];			  
	 		$_POST[tsaldofinal]+=$row[6];			  	
		  }
	echo "<tr class='$co'><td $negrilla>$row[1]</td><td $negrilla>$row[2]</td><td $negrilla align='right'>".number_format($row[3],2,".",",")."</td><td $negrilla align='right'>".number_format($row[4],2,".",",")."</td><td $negrilla align='right'>".number_format($row[5],2,".",",")."</td><td $negrilla align='right'>".number_format($row[6],2,".",",")."</td></tr>";
	 echo "<input type='hidden' name='dcuentas[]' value= '$row[1]'> <input type='hidden' name='dncuentas[]' value= '$row[2]'><input type='hidden' name='dsaldoant[]' value= '$row[3]'> <input type='hidden' name='ddebitos[]' value= '$row[4]'> <input type='hidden' name='dcreditos[]' value= '$row[5]'><input type='hidden' name='dsaldo[]' value= '$row[6]'></tr>" ;
	 
	  fputs($Descriptor1,$row[1].";".$row[2].";".number_format($row[3],2,",","").";".number_format($row[4],2,",","").";".number_format($row[5],2,",","").";".number_format($row[6],2,",","")."\r\n");
	  $aux=$co;
         $co=$co2;
         $co2=$aux;
		 $i=1+$i;
  }
  	mysqli_free_result($rescta);
//  $_POST[tsaldofinal]= $_POST[tsaldoant]+$_POST[tdebito]-$_POST[tcredito];
  echo "<tr class='$co'><td colspan='2'></td><td class='$co' align='right'>".number_format($_POST[tsaldoant],2,".",",")."<input type='hidden' name='tsaldoant' value= '$_POST[tsaldoant]'></td><td class='$co' align='right'>".number_format($_POST[tdebito],2,".",",")."<input type='hidden' name='tdebito' value= '$_POST[tdebito]'></td><td class='$co' align='right'>".number_format($_POST[tcredito],2,".",",")."<input type='hidden' name='tcredito' value= '$_POST[tcredito]'></td><td class='$co' align='right'>".number_format($_POST[tsaldofinal],2,".",",")."<input type='hidden' name='tsaldofinal' value= '$_POST[tsaldofinal]'></td></tr>";  
}
?> 
</div></form></td></tr>
</table>
</body>
</html>