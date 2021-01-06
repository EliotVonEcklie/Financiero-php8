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
		<script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
        <script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
		<script>
			function verUltimaPos(idcta, tiporeca, filas, filtro){
				var scrtop=$('#divdet').scrollTop();
				var altura=$('#divdet').height();
				var numpag=$('#nummul').val();
				var limreg=$('#numres').val();
				if((numpag<=0)||(numpag==""))
					numpag=0;
				if((limreg==0)||(limreg==""))
					limreg=10;
				numpag++;
				location.href="teso-anularrecibover.php?idrecibo="+idcta+"&tiporeca="+tiporeca+"&scrtop="+scrtop+"&totreg="+filas+"&altura="+altura+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
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
	if (confirm("Esta Seguro de Eliminar el Recibo de Caja No "+idr))
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
</script>
		<?php titlepag();?>
        <?php
		$scrtop=$_GET['scrtop'];
		if($scrtop=="") $scrtop=0;
		echo"<script>
			window.onload=function(){
				$('#divdet').scrollTop(".$scrtop.")
			}
		</script>";
		$gidcta=$_GET['idcta'];
		if(isset($_GET['filtro']))
			$_POST[nombre]=$_GET['filtro'];
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
				<a href="teso-recibocaja.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
				<a class="mgbt"><img src="imagenes/guardad.png" /></a>
				<a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
				<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
				<a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
          	</tr>	
        </table>
 <form name="form2" method="post" action="teso-anularecibocaja.php">
<table  class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="6">:. Anular Recibos de Caja</td>
        <td width="70" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
      </tr>
      <tr >
        <td width="168" class="saludo1">Numero Liquidacion:</td>
        <td width="154" ><input name="numero" type="text" value="" >
        </td>
         <td width="144" class="saludo1">Concepto Liquidacion: </td>
    <td width="498" ><input name="nombre" type="text" value="" size="80" ></td>
  
	   
          <input name="oculto" type="hidden" value="1"><input name="var1" type="hidden" value=<?php echo $_POST[var1];?>>
        </tr>                       
    </table>     
    <div class="subpantallap" style="height:68.5%; width:99.6%;" id="divdet">
   <?php
	$oculto=$_POST['oculto'];
	if($_POST[oculto]==2)
	{
	 $linkbd=conectar_bd();	
	 $sqlr="select * from tesoreciboscaja where id_recibos=$_POST[var1]";
	 $resp = mysql_query($sqlr,$linkbd);
	 $row=mysql_fetch_row($resp);
	 //********Comprobante contable en 000000000000
	 
	  $sqlr="update comprobante_cab set total_debito=0,total_credito=0,estado='0' where tipo_comp='5' and numerotipo=$row[0]";
	  mysql_query($sqlr,$linkbd);
	  //echo $sqlr;
	  $sqlr="update comprobante_det set valdebito=0,valcredito=0 where id_comp='5 $row[0]'";
	  mysql_query($sqlr,$linkbd);
	  
  	  $sqlr="update pptocomprobante_cab set estado='0' where  tipo_comp='16' and numerotipo=$_POST[var1]";
	  mysql_query($sqlr,$linkbd);
	  
	 //********PREDIAL O RECAUDO SE ACTIVA COLOCAR 'S'
	  if($row[10]=='1')
	   {
		 $sql="SELECT FIND_IN_SET($_POST[var1],recibo),idacuerdo FROM tesoacuerdopredial ";
		 $result=mysql_query($sql,$linkbd);
		 $val=0;
		 $compro=0;
		 while($fila = mysql_fetch_row($result)){
		 if($fila[0]!=0){
			$val=$fila[0];
			$compro=$fila[1];
			break;
		  }
		 }
	   if($val>0){
		   $valrem=",$_POST[var1]";
	   //$sql="UPDATE tesoacuerdopredial SET cuota_pagada=cuota_pagada-1, abono=abono-(valor_pago/cuotas),recibo=REPLACE(recibo,'$valrem','') WHERE idacuerdo='$compro' ";
	     $sql="UPDATE tesoacuerdopredial SET cuota_pagada=cuota_pagada-1, abono=abono-(valor_pago/cuotas) WHERE idacuerdo='$compro' ";
	     mysql_query($sql,$linkbd);
	   }else{
		     $sqlr="update tesoliquidapredial set estado='S' where idpredial=$row[4]";
			  mysql_query($sqlr,$linkbd);
		  //**** AVALUOS ****
		    $sqlr="select * from tesoliquidapredial  where idpredial=$row[4]";
		    $res=mysql_query($sqlr,$linkbd);
		    $rf=mysql_fetch_row($res);
			$codcat=$rf[1];
		    $sqlr="select * from tesoliquidapredial_det  where idpredial=$row[4]";
		    $res=mysql_query($sqlr,$linkbd);
		   while($rf=mysql_fetch_row($res))
			{
			  $sqlr="update tesoprediosavaluos set pago='S' where codigocatastral='$codcat' and vigencia='$rf[1]'";
			  mysql_query($sqlr,$linkbd);		 
			}
	   }
	   
	 
	
	   }
	  if($row[10]=='2')
	   { 
	  $sqlr="update tesoindustria set estado='S' where id_industria=$row[4]";
	  mysql_query($sqlr,$linkbd);		 
	   }
	  if($row[10]=='3')
	   {
 	  $sqlr="update tesorecaudos set estado='S' where id_recaudo=$row[4]";
	  mysql_query($sqlr,$linkbd);
	   } 
	 //******** RECIBO DE CAJA ANULAR 'N'	 
	  $sqlr="update tesoreciboscaja set estado='N' where id_recibos=$row[0]";
	  mysql_query($sqlr,$linkbd);
	 //******** Disminuir En 1 cuota predial
	 
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
$crit1=" and tesoreciboscaja.id_recibos like '%".$_POST[numero]."%' ";
if ($_POST[nombre]!="")
{//$crit2=" and tesorecaudos.concepto like '%".$_POST[nombre]."%'  ";}
}
$sqlr="select *from tesoreciboscaja where tesoreciboscaja.estado<>'' ".$crit1.$crit2." order by tesoreciboscaja.id_recibos DESC";
	// echo "<div><div>sqlr:".$sqlr."</div></div>";
	$resp = mysql_query($sqlr,$linkbd);
$ntr = mysql_num_rows($resp);
$con=1;

echo "<table class='inicio' align='center'  >
	<tr>
		<td colspan='10' class='titulos'>.: Resultados Busqueda:</td>
	</tr>
	<tr>
		<td colspan='2'>Recibos de Caja Encontrados: $ntr</td>
	</tr>
	<tr>
		<td style='width:5%;' class='titulos2'>No Recibo</td>
		<td style='width:20%;' class='titulos2'>Concepto</td>
		<td style='width:7%;' class='titulos2'>Fecha</td>
		<td style='width:25%;' class='titulos2'>Contribuyente</td>
		<td style='width:10%;' class='titulos2'>Valor</td>
		<td style='width:5%;' class='titulos2'>No Liquid.</td>
		<td style='width:5%;' class='titulos2'>Tipo</td>
		<td style='width:5%;' class='titulos2'>ESTADO</td>
		<td style='width:5%;' class='titulos2'><center>Anular</td>
		<td style='width:5%;' class='titulos2'><center>Ver</td>
	</tr>";	
//echo "nr:".$nr;
$iter='saludo1a';
$iter2='saludo2';
$tipos=array('Predial','Industria y Comercio','Otros Recaudos');
 while ($row =mysql_fetch_row($resp)) 
 {

	if($row[10]==1){$sqlrt="select tercero from tesoliquidapredial where tesoliquidapredial.idpredial=$row[4]";}
	if($row[10]==2){$sqlrt="select tercero from tesoindustria where $row[4]=tesoindustria.id_industria";}
	if($row[10]==3){$sqlrt="select tercero from tesorecaudos where tesorecaudos.id_recaudo=$row[4]";}
	$rest=mysql_query($sqlrt,$linkbd);
	$rowt=mysql_fetch_row($rest);	 	
	 $ntercero=buscatercero($rowt[0]);
	 if ($row[9]=="S"){$imgsem="src='imagenes/sema_verdeON.jpg' title='Activo'";}
	 else{$imgsem="src='imagenes/sema_rojoON.jpg' title='Inactivo'";}
	if($gidcta!=""){
		if($gidcta==$row[0]){
			$estilo='background-color:yellow';
		}
		else{
			$estilo="";
		}
	}
	else{
		$estilo="";
	}	
	$idcta="'$row[0]'";
	$tiporeca="'$row[10]'";
	$numfil="'$filas'";
	$filtro="'$_POST[nombre]'";

	 echo "<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
			onMouseOut=\"this.style.backgroundColor=anterior\" onDblClick=\"verUltimaPos($idcta, $tiporeca, $numfil, $filtro)\" style='text-transform:uppercase; $estilo'>
			<td>$row[0]</td>
			<td>$row[11]</td>
			<td>$row[2]</td>
			<td>$ntercero</td>
			<td>".number_format($row[8],2)."</td>
			<td>$row[4]</td>
			<td>".$tipos[$row[10]-1]."</td>
			<td style='text-align:center;'><img $imgsem style='width:18px' ></td>";
	 if ($row[9]=='S')
	 echo "<td style='text-align:center;'><a href='#' onClick=eliminar($row[0])><img src='imagenes/anular.png'></a></td>";
	 if ($row[9]=='N')
	 echo "<td></td>";
	echo"<td style='text-align:center;'>
		<a onClick=\"verUltimaPos($idcta, $tiporeca, $numfil, $filtro)\" style='cursor:pointer;'>
			<img src='imagenes/lupa02.png' style='width:18px' title='Ver'>
		</a>
	</td>
	</tr>";
	 $con+=1;
	 $aux=$iter;
	 $iter=$iter2;
	 $iter2=$aux;	
 }
 echo"</table>";
//}
?></div>
</form>
</body>
</html>