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
<script>
		function crearexcel(){
			document.form2.action="teso-buscapagoterceros-vigante-excel.php";
			document.form2.target="_BLANK";
			document.form2.submit();
			document.form2.action="";
			document.form2.target="";
		}
			function verUltimaPos(idcta, filas, filtro)
			{
				var scrtop=$('#divdet').scrollTop();
				var altura=$('#divdet').height();
				var numpag=$('#nummul').val();
				var limreg=$('#numres').val();
				if((numpag<=0)||(numpag=="")){numpag=0;}
				if((limreg==0)||(limreg=="")){limreg=10;}
				numpag++;
				location.href="cont-editarplancuenta.php?idtipocom="+idcta+"&scrtop="+scrtop+"&totreg="+filas+"&altura="+altura+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
			}
		</script>
		
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
function buscacta(e)
 {
if (document.form2.cuenta.value!="")
{
 document.form2.bc.value='1';
 document.form2.submit();
 }
 }
function validar()
{
document.form2.submit();
}
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
	//			document.form2.chacuerdo.value=2;
				document.form2.submit();
 }
 else {
 alert("Falta informacion para poder Agregar");
 }
}
//************* genera reporte ************
//***************************************
function eliminar(idr)
{
	if (confirm("Esta Seguro de Eliminar el Recibo de Caja"))
  	{
  	document.form2.oculto.value=2;
  	document.form2.var1.value=idr;
	document.form2.submit();
  	}
}
//************* genera reporte ************
//***************************************
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
  else{
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
				location.href="teso-editapagotercerosvigant.php?idpago="+idcta;
			}
			
</script>
<?php titlepag();
$gidcta=$_GET['idpago'];
?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
	<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
	<tr><?php menu_desplegable("teso");?></tr>
<tr>
  <td colspan="3" class="cinta">
  <a href="teso-pagoterceros-vigant.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
  <a class="mgbt"><img src="imagenes/guardad.png"/></a>
  <a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a>
  <a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
  <a href="#" onclick="crearexcel()" class="mgbt"><img src="imagenes/excel.png" title="Excell"></a>
  </td></tr>	
</table>
 <form name="form2" method="post" action="teso-buscapagoterceros-vigant.php">
<table  class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="6">:. Buscar Pago Terceros Vigencias Anteriores</td>
        <td width="70" class="cerrar" ><a href="teso-principal.php"> Cerrar</a></td>
      </tr>
      <tr >
        <td  class="saludo1">No Pago:</td>
        <td  ><input name="numero" type="text" value="" Onchange="validar();" >
        </td>
         <td  class="saludo1">Concepto Pago: </td>
    <td  ><input name="nombre" type="text" value="" size="80" Onchange="validar();"></td>  	   
          <input name="oculto" type="hidden" value="1"><input name="var1" type="hidden" value=<?php echo $_POST[var1];?> >
        </tr>                       
    </table>    
     <div class="subpantallap" style="height:68.5%; width:99.6%; overflow-x:hidden;">
     <?php
	$oculto=$_POST['oculto'];
	if($_POST[oculto]==2)
	{
	 $linkbd=conectar_bd();	
	 $sqlr="select * from tesopagotercerosvigant where id_pago	=$_POST[var1]";
	 $resp = mysql_query($sqlr,$linkbd);
	 $row=mysql_fetch_row($resp);
	 //********Comprobante contable en 000000000000
	  $sqlr="update comprobante_cab set estado='0' where tipo_comp='15' and numerotipo='$_POST[var1]'";
	  mysql_query($sqlr,$linkbd);
	  /*$sqlr="update comprobante_det set valdebito=0,valcredito=0 where id_comp='15 $row[0]'";
	  mysql_query($sqlr,$linkbd);*/
	
	 //******** RECIBO DE CAJA ANULAR 'N'	 
	  $sqlr="update tesopagotercerosvigant set estado='N' where id_pago=$row[0]";
	  mysql_query($sqlr,$linkbd);	  
	}
   ?>
    
    
      <?php
$oculto=$_POST['oculto'];
//if($_POST[oculto])
//{
$linkbd=conectar_bd();
$crit1=" ";
$crit2=" ";
if ($_POST[numero]!="")
$crit1=" and tesopagotercerosvigant.id_pago like '%".$_POST[numero]."%' ";
if ($_POST[nombre]!="")
$crit2=" and tesopagotercerosvigant.concepto like '%".$_POST[nombre]."%'  ";


//sacar el consecutivo 
//$sqlr="select *from pptosideforigen where".$crit1.$crit2." order by pptosideforigen.codigo";
	$sqlr="select *from tesopagotercerosvigant where tesopagotercerosvigant.id_pago>-1 ".$crit1.$crit2." order by tesopagotercerosvigant.id_pago desc";

// echo "<div><div>sqlr:".$sqlr."</div></div>";
$resp = mysql_query($sqlr,$linkbd);
$ntr = mysql_num_rows($resp);
$con=1;

echo "<table class='inicio' align='center' ><tr><td colspan='8' class='titulos'>.: Resultados Busqueda:</td></tr><tr><td colspan='2'>Recaudos Encontrados: $ntr</td></tr><tr><td class='titulos2'>Codigo</td><td class='titulos2'>Concepto</td><td class='titulos2'>Fecha</td><td class='titulos2'>Beneficiario</td><td class='titulos2'>Valor</td><td class='titulos2'>Estado</td><td class='titulos2' width='5%'><center>Anular</td><td class='titulos2' width='5%'><center>Ver</td></tr>";	
//echo "nr:".$nr;
$iter='zebra1';
$iter2='zebra2';
 while ($row =mysql_fetch_row($resp)) 
 {
	 $nter=buscatercero($row[1]);
	 if($row[9]=='S')
		 $imgsem="src='imagenes/sema_verdeON.jpg' title='Activo'"; 	 				  
		 if($row[9]=='N')
		 $imgsem="src='imagenes/sema_rojoON.jpg' title='Inactivo'"; 
	 if($gidcta!=""){
							if($gidcta==$row[0]){
								$estilo='background-color:#FF9';
							}
							else{
								$estilo="";
							}
						}
						else{
							$estilo="";
						}
		$idcta="'".$row[0]."'";
	 echo "
	 <tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
			onMouseOut=\"this.style.backgroundColor=anterior\" onDblClick=\"verUltimaPos($idcta)\" style='text-transform:uppercase; $estilo'>
		<td>$row[0]</td>
		<td>$row[7]</td>
		<td>$row[10]</td>
		<td>$nter</td>
		<td>".number_format($row[5],2)."</td>
		<td style='text-align:center;'><img $imgsem style='width:18px'></td>";
	 	 if($row[9]=='S')
		 echo "<td ><a href='#'  onClick=eliminar($row[0])><center><img src='imagenes/anular.png'></center></a></td>";		 
	 	 if($row[9]=='N')
		 echo "<td></td>";	 
	 echo "<td ><a href='teso-editapagotercerosvigant.php?idpago=$row[0]'><center><img src='imagenes/lupa02.png' style='width:18px'></center></a></td></tr>";
	 $con+=1;
	 $aux=$iter;
	 $iter=$iter2;
	 $iter2=$aux;
	 ?>
	 <input type="hidden" name="code[]" id="code[]" value="<?php echo $row[0];?>"/>
	  <input type="hidden" name="cont[]" id="cont[]" value="<?php echo $row[7];?>"/>
	    <input type="hidden" name="fecha[]" id="fecha[]" value="<?php echo $row[10];?>"/>
		<input type="hidden" name="ben[]" id="ben[]" value="<?php echo $nter;?>"/>
		<input type="hidden" name="num[]" id="num[]" value="<?php echo number_format($row[5],2);?>"/>
	 
	 <?php
 }
 echo"</table>";

?>

</div>
</form>
</body>
</html>