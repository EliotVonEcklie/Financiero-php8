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
		<title>:: SPID - Tesoreria</title>
		<link href="css/css2.css" rel="stylesheet" type="text/css" />
		<link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
        <script type="text/javascript" src="css/calendario.js"></script>
        <script type="text/javascript" src="JQuery/jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="JQuery/autoNumeric-master/autoNumeric-min.js"></script>
		<script>
			function validar(){document.form2.submit();}
			function buscater(e)
 			{
				if (document.form2.tercero.value!="")
				{
 					document.form2.bt.value='1';
 					document.form2.submit();
				}
 			}
			function agregardetalle()
			{
				if(document.form2.numero.value!="" &&  document.form2.valor.value>0 &&  document.form2.banco.value!=""  )
				{ 
					document.form2.agregadet.value=1;
					document.form2.submit();
 				}
 				else {alert("Falta informacion para poder Agregar");}
			}
			function eliminar(idr)
			{
				if (confirm("Esta Seguro de Eliminar el Recaudo Transferencia "+idr))
  				{
  					document.form2.oculto.value=2;
  					document.form2.var1.value=idr;
					document.form2.submit();
  				}
			}
			function guardar()
			{
				if (document.form2.fecha.value!='')
  				{
					if (confirm("Esta Seguro de Guardar"))
  					{
  						document.form2.oculto.value=2;
  						document.form2.submit();
  					}
  				}
  				else
				{
 					alert('Faltan datos para completar el registro');
  					document.form2.fecha.focus();
  					document.form2.fecha.select();
  				}
			}
			function pdf()
			{
				document.form2.action="teso-pdfconsignaciones.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}

			function verUltimaPos(idcta){
				location.href="teso-editarecaudotransferenciaprivado.php?idrecaudo="+idcta;
			}


			</script>
			<?php titlepag();?>
		</head>
		<body>
			<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
			<span id="todastablas2"></span>
			<table>
				<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
				<tr><?php menu_desplegable("teso");?></tr>
				<tr>
  					<td colspan="3" class="cinta"><a href="teso-recaudotransferenciaprivado.php" class="mgbt"><img src="imagenes/add.png" alt="Nuevo" title="Nuevo"/></a><a class="mgbt"><img src="imagenes/guardad.png" alt="Guardar"  /> </a><a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" alt="Buscar" title="Buscar" /></a><a class="mgbt" href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" alt="nueva ventana" title="Nueva ventana"></a>
					</td>
             	</tr>	
			</table>
<tr><td colspan="3" class="tablaprin"> 
 <form name="form2" method="post" action="teso-buscarecaudotransferenciaprivado.php">
<table  class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="6">:. Buscar Liquidacion Recaudos Transferencia</td>
        <td width="70" class="cerrar" ><a href="teso-principal.php"> Cerrar</a></td>
      </tr>
      <tr >
        <td width="168" class="saludo1">Numero Recaudo:</td>
        <td width="154" ><input name="numero" type="text" value="" >
        </td>
         <td width="144" class="saludo1">Concepto Recaudo: </td>
    <td width="498" ><input name="nombre" type="text" value="" size="80" ></td>
  
	   
          <input name="oculto" type="hidden" value="1"><input name="var1" type="hidden" value=<?php echo $_POST[var1];?>>
        </tr>                       
    </table>    </form> <div class="subpantallap">
     <?php
	$oculto=$_POST['oculto'];
	if($_POST[oculto]==2)
	{
	 $linkbd=conectar_bd();	
	 $sqlr="select * from tesorecaudotransferenciaprivado where id_recaudo=$_POST[var1]  ";
	 $resp = mysql_query($sqlr,$linkbd);
	 $row=mysql_fetch_row($resp);
	 //********Comprobante contable en 000000000000
	  $sqlr="update comprobante_cab set total_debito=0,total_credito=0,estado='0' where numerotipo=$row[0] AND tipo_comp=37";
	 // echo $sqlr;
	  mysql_query($sqlr,$linkbd);
	  $sqlr="update comprobante_det set valdebito=0,valcredito=0 where id_comp='37 $row[0]'";
	  mysql_query($sqlr,$linkbd);
	  
	 /* $sqlr="update pptocomprobante_cab set estado='0' where numerotipo=$row[0] AND tipo_comp=19";
	  mysql_query($sqlr,$linkbd);
	*/
	 //******** RECIBO DE CAJA ANULAR 'N'	 
	  $sqlr="update tesorecaudotransferenciaprivado set estado='N' where id_recaudo=$row[0]";
	  mysql_query($sqlr,$linkbd);
	  
	}
   ?>
    
    
      <?php
$oculto=$_POST['oculto'];
//if($_POST[oculto])
{
$linkbd=conectar_bd();
$crit1=" ";
$crit2=" ";
if ($_POST[numero]!="")
$crit1=" and tesorecaudotransferenciaprivado.id_recaudo  like '%".$_POST[numero]."%' ";
if ($_POST[nombre]!="")
$crit2=" and tesorecaudotransferenciaprivado.concepto like '%".$_POST[nombre]."%'  ";
//sacar el consecutivo 
//$sqlr="select *from pptosideforigen where".$crit1.$crit2." order by pptosideforigen.codigo";
	$sqlr="select *from tesorecaudotransferenciaprivado where tesorecaudotransferenciaprivado.id_RECAUDO>-1 ".$crit1.$crit2." order by tesorecaudotransferenciaprivado.id_RECAUDO desc";

// echo "<div><div>sqlr:".$sqlr."</div></div>";
$resp = mysql_query($sqlr,$linkbd);
$ntr = mysql_num_rows($resp);
$con=1;

echo "<table class='inicio' align='center' >
		<tr>
			<td colspan='8' class='titulos'>.: Resultados Busqueda:</td>
		</tr>
		<tr>
			<td colspan='2'>Recaudos Encontrados: $ntr</td>
		</tr>
		<tr>	
			<td width='150' class='titulos2' style='width:7%;text-align:center'>Codigo</td>
			<td class='titulos2'>Nombre</td>
			<td class='titulos2' style='width:8%;text-align:center'>Fecha</td>
			<td class='titulos2' style='width:20%;text-align:center'>Contribuyente</td>
			<td class='titulos2' style='width:9%;text-align:center'>Valor</td>
			<td class='titulos2'>Estado</td>
			<td class='titulos2' width='5%'>
				<center>Anular
			</td>
			<td class='titulos2' width='5%'>
				<center>Ver
			</td>
		</tr>";	
//echo "nr:".$nr;
$iter='zebra1';
$iter2='zebra2';
$id=$_GET[id];
 while ($row =mysql_fetch_row($resp)) 
 {
 	$estilo='';
 	if($id==$row[0]){
 		$estilo='background-color:#FF9';
 	}
	 $nter=buscatercero($row[7]);
	 if($row[10]=='S')
		 $estado='ACTIVO'; 	 				  
		 if($row[10]=='N')
		 $estado='ANULADO'; 	
	 echo "<tr class='$iter' onDblClick=\"verUltimaPos($row[0])\" style='$estilo'>
	 		<td >$row[0]</td>
	 		<td >$row[6]</td>
	 		<td >$row[2]</td>
	 		<td >$nter</td>
	 		<td >".number_format($row[9],2)."</td>";
	 		if ($row[10]=='S'){echo "<td ><center><img src='imagenes/sema_verdeON.jpg' style='width:18px;'></center></td>";}
			if ($row[10]=='N'){echo "<td ><center><img src='imagenes/sema_rojoON.jpg' style='width:18px;'></center></td>";}
	 	 if($row[10]=='S')
		 {
		 echo "<td ><a href='#'  onClick=eliminar($row[0])><center><img src='imagenes/anular.png'></center></a></td>";		 
	 	 }
		 if($row[10]=='N')
		 echo "<td ></td>";	 
	 echo "<td><a href='teso-editarecaudotransferenciaprivado.php?idrecaudo=$row[0]'><center><img src='imagenes/buscarep.png'></center></a></td></tr>";
	 $con+=1;
	 $aux=$iter;
	 $iter=$iter2;
	 $iter2=$aux;
 }
 echo"</table>";
}
?></div>

</td></tr>     
</table>
</body>
</html>