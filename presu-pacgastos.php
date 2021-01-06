<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: SPID - Presupuesto</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
<script>
function buscacta(e)
 {
if (document.form2.cuenta.value!="")
{
 document.form2.bc.value=2;
 document.form2.submit();
 }
 }
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
document.form2.action="pdfejecucioningresos.php";
document.form2.target="_BLANK";
document.form2.submit(); 
document.form2.action="";
document.form2.target="";
}
function excell()
{
document.form2.action="presu-ejecucioningresosexcel.php";
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
            <tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("presu");?></tr>
       	 	<tr>
  				<td colspan="3" class="cinta"><a href="#" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a> <a href="#"  class="mgbt"><img src="imagenes/guarda.png" title="Guardar"/></a> <a href="#" onClick="document.form2.submit()" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a> <a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a> <a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png" title="imprimir"></a> <a href="#" onClick="excell()" class="mgbt"><img src="imagenes/excel.png" title="excel"></a> <a href="presu-pac.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a></td>
			</tr>
        </table> 
 <form name="form2" method="post" action="presu-pacgastos.php">
<?php
$vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
?>
    <table  align="center" class="inicio" >
      <tr >
        <td class="titulos" colspan="2">.: GASTOS VIGENCIA</td>
        <td  class="cerrar"><a href="presu-principal.php">Cerrar</a></td>
      </tr>
      <tr  >      
         <td  class="saludo1">Vigencia:</td>
        <td ><input type="text" value="<?php echo $vigusu ?>" name="vigencias" readonly="">  <input type="button" name="generar" value="Generar" onClick="document.form2.submit()"> <input type="hidden" value="1" name="oculto"></td></tr>
      
    </table>
     <?php
	 $vigusu=vigencia_usuarios($_SESSION[cedulausu]);
$_POST[vigencia]=$vigusu;
			//**** busca cuenta
			if($_POST[bc]!='')
			 {
			  $nresul=buscacuentapres($_POST[cuenta],1);
			  if($nresul!='')
			   {
			  $_POST[ncuenta]=$nresul;			  			  
  			  ?>
			<script>
			  document.form2.fecha.focus();
			  document.form2.fecha.select();
			  </script>
			  <?php
			  }
			 else
			 {
			  $_POST[ncuenta]="";
			  ?>
	  		<script>alert("Cuenta Incorrecta");document.form2.cuenta.focus();</script>
			  <?php
			  }
			 }
			 ?>
	<div class="subpantallap" style="height:67%; width:99.6%;">
  <?php
  //**** para sacar la consulta del balance se necesitan estos datos ********
  //**** nivel, mes inicial, mes final, cuenta inicial, cuenta final, cc inicial, cc final  
$oculto=$_POST['oculto'];
if($_POST[oculto])
{
$meses=array();
$niveles=array();
$linkbd=conectar_bd();
$sqlr="select *from meses where tipo='M' order by id";
$res=mysql_query($sqlr,$linkbd);
		while($row=mysql_fetch_row($res))
		{
		 $meses[$row[0]][0]=$row[0];
		 $meses[$row[0]][1]=$row[1];		 		 
		}

$sqlr="select *from nivelesctasing where estado='S'";
$res=mysql_query($sqlr,$linkbd);
		while($row=mysql_fetch_row($res))
		{
		$niveles[]=$row[3];
	//	echo "<br>".$row[3];
 		}	
		
	$sumareca=0;
	$sumarp=0;	
	$sumaop=0;	
	$sumap=0;			
	$sumai=0;
	$sumapi=0;				
	$sumapad=0;	
$sumapred=0;	
$sumapcr=0;	
$sumapccr=0;						
ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
	$fechaf2=$fecha[3]."-".$fecha[2]."-".$fecha[1];	
$sqlr2="Select distinct cuenta, tipo, vigencia, vigenciaf from pptocuentas where TIPO='Auxiliar' and CLASIFICACION<>'ingresos' and  (vigencia='".$vigusu."' or vigenciaf='$vigusu') order by cuenta";	
//echo "$sqlr2";
	$pctas=array();
	$tpctas=array();
	$pctasvig1=array();
	$pctasvig2=array();	
	$ingctas[]=array();
	$rescta=mysql_query($sqlr2,$linkbd);
while ($row =mysql_fetch_row($rescta)) 
 {
  $pctas[]=$row[0];
  $tpctas[$row[0]]=$row[1];
  $pctasvig1[$row[0]]=$row[2];
  $pctasvig2[$row[0]]=$row[3];
// 	echo "<br>$row[0]:".$tpctas[$row[0]];
 }	
mysql_free_result($rescta);
//echo "tc:".count($pctas);
$iter="zebra1";
$iter2="zebra2";
$nm=count($meses);
 echo "<table class='inicio' ><tr><td colspan='".($nm+3)."' class='titulos'>PAC GASTOS $vigusu</td></tr>";
   echo "<tr><td class='titulos2'>Rubro </td><td class='titulos2'>Nombre</td>";
   for($x=1;$x<=$nm;$x++)
   {
   echo "<td class='titulos2'>".$meses[$x][1]."</td>";
   }
   echo "<td class='titulos2'>TOTAL</td></tr>";
for($x=0;$x<count($pctas);$x++) 
 {		
 	 //$nc=buscacuentap($_POST[cuenta]);
	 $pdef=0;
	 $vitot=0;
	 $todos=0;
//$sqlr="Select distinct cuenta from pptocuentaspptoinicial where (left(cuenta,1)='1' OR left(cuenta,2)='R1')  and vigencia='".$_POST[vigencias]."' order by cuenta"; 	 	 
	  $tama=strlen($pctas[$x]);
	  $ctaniv=substr($pctas[$x],0,$tama);
	 // echo "<br>".$ctaniv; 
	 //$nt=existecuentain($ctaniv);	
	 //$vitot=$vi+$vit+$viret+$vissf+$notas+$visinrec;
	 //$vporcentaje=round(($vitot/$pdef)*100,2);
	  $negrilla="style='font-weight:bold'";	  
	   $tcta="0"; 
	   echo "<tr class='$iter'>";
	   $ctaniv=$pctas[$x];
	   $nt=existecuentain($ctaniv);	   
		echo "<td $negrilla><input type='hidden' name='tcodcuenta[]' value='$tcta'><input type='hidden' name='codcuenta[]' value='$ctaniv'>".$ctaniv."</td>
		<td $negrilla><input type='hidden' name='nomcuenta[]' value='$nt'>".strtoupper($nt)."</td>";
	   for($m=1;$m<=$nm;$m++)
   		{
	   $vitot=0;
	   //**** PRUEBA TODOS LOS INGRESOS
	    //*** todos los ingresos ***
	 $sqlr3="SELECT DISTINCT
          pptocomprobante_det.cuenta,
          sum(pptocomprobante_det.valdebito),
          sum(pptocomprobante_det.valcredito)
     FROM pptocomprobante_det, pptocomprobante_cab, pptotipo_comprobante
    WHERE     pptocomprobante_cab.tipo_comp = pptocomprobante_det.tipo_comp
          AND pptocomprobante_det.numerotipo = pptocomprobante_cab.numerotipo
          AND pptocomprobante_cab.estado = 1
          AND pptocomprobante_det.valdebito > 0              
AND(pptocomprobante_cab.VIGENCIA=".$pctasvig1[$pctas[$x]]." or pptocomprobante_cab.VIGENCIA=".$pctasvig2[$pctas[$x]].")
	  AND(pptocomprobante_det.VIGENCIA=".$pctasvig1[$pctas[$x]]." or pptocomprobante_det.VIGENCIA=".$pctasvig2[$pctas[$x]].")
		    AND MONTH(pptocomprobante_cab.fecha) = '".$m."' 
          AND pptocomprobante_cab.tipo_comp = pptotipo_comprobante.codigo 
		  AND (pptotipo_comprobante.tipo = 'G' or pptotipo_comprobante.tipo = 'D')	AND pptocomprobante_det.cuenta = '".$pctas[$x]."' 
		  GROUP BY pptocomprobante_det.cuenta
   ORDER BY pptocomprobante_det.cuenta";
	   $res=mysql_query($sqlr3,$linkbd);
	   $row =mysql_fetch_row($res);
	   //echo $sqlr3."<br>";
	   $vitot=$row[1];	
	   $tcta+=$vitot;
	   $ingctas["$pctas[$x]"][$m]=$vitot+0;
		echo "<td>".number_format($ingctas["$pctas[$x]"][$m],2,",",".")."</td>";  
		}		
		echo "<td>".number_format($tcta)."</td></tr>";
}		
	   //**
/* for($x=0;$x<count($pctas);$x++) 
 {	 
 $ctaniv=$pctas[$x];
 // echo "<br>".$ctaniv; 
 $nt=existecuentain($ctaniv);	
  echo "<tr class='$iter'>";
  echo "<td $negrilla><input type='hidden' name='tcodcuenta[]' value='$tcta'><input type='hidden' name='codcuenta[]' value='$ctaniv'>".$ctaniv."</td>
		<td $negrilla><input type='hidden' name='nomcuenta[]' value='$nt'>".strtoupper($nt)."</td>";
    for($m=1;$m<=$nm;$m++)
   		{	  	
  		echo "<td>".$ingctas["$pctas[$x]"][$m]."</td>";  			
  		}
		echo "</tr>";
 	$aux=$iter;
	$iter=$iter2;
	$iter2=$aux;
 }*/
 echo "<tr><td ></td><td  align='right'>Totales:</td><td class='saludo3' align='right'>".number_format($sumapi,2)."</td><td class='saludo3' align='right'>".number_format($sumapad,2)."</td><td class='saludo3' align='right'>".number_format($sumapred,2)."</td><td class='saludo3' align='right'>".number_format($sumai,2)."</td><td class='saludo3' align='right'>".number_format($sumareca,2)."</td><td class='saludo3' align='right'>".number_format($vportot,2)."%</td></tr>";
 //} 
}
?> 
</div></form>
</body>
</html>