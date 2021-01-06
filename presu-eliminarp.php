<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	require "conversor.php";
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
		<title>:: Spid - Presupuesto</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
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
//************* genera reporte ************
//***************************************
function guardar()
{
if (document.form2.documento.value!='')
  {
	if (confirm("Esta Seguro de Guardar"))
  	{
  	document.form2.oculto.value=2;
  	document.form2.submit();
  	}
  }
  else{
  alert('Faltan datos para completar el registro');
  }
 }
//************* genera reporte ************
//***************************************
function eliminar(idr)
{
	if (confirm("Esta Seguro de Eliminar el registro: "+idr))
  	{
  	document.form2.oculto.value=2;
  	document.form2.var1.value=idr;
	document.form2.var2.value=idr;
	document.form2.submit();
  	}
}
function validar(formulario)
{
document.form2.action="presu-eliminarp.php";
document.form2.submit();
}
function cleanForm()
{
document.form2.nombre1.value="";
document.form2.nombre2.value="";
document.form2.apellido1.value="";
document.form2.apellido2.value="";
document.form2.documento.value="";
document.form2.codver.value="";
document.form2.telefono.value="";
document.form2.direccion.value="";
document.form2.email.value="";
document.form2.web.value="";
document.form2.celular.value="";
document.form2.razonsocial.value="";
}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
		  	{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
			  	if(_valor=="hidden"){document.getElementById('ventanam').src="";}
			  	else
			  	{
					switch(_tip)
					{
						case "2":
							document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
						case "5":
							var idcdp=document.form2.var2.value;
							document.getElementById('ventanam').src="ventana-comentarios.php?infor="+mensa+"&tabl=pptoanulaciones&tipo=RP&idr="+idcdp;break;
					}
					
				}
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
          		<td colspan="3" class="cinta">
				<a href="#" class="mgbt"><img src="imagenes/add2.png" title="Nuevo"/></a>
				<a class="mgbt"><img src="imagenes/guardad.png"/></a>
				<a href="#" onClick="document.form2.submit();" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
				<a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
        	</tr>
        </table>	
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
 		<form name="form2" method="post" action="presu-eliminarp.php">
        	<input name="var2" id="var2" type="hidden" value=<?php echo $_POST[var2];?>>
 		<?php
			$oculto=$_POST['oculto'];
			$vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
			//echo "<br>oc:".$oculto;
			if($_POST[oculto]==2)
			{
				$nrp=buscarpcxpactiva($_POST[var1],$vigusu);
				if ($nrp<=0)
				{	
					$sqlr="select * from pptorp where pptorp.consvigencia='$_POST[var1]' AND VIGENCIA='".$vigusu."'";
					//echo "<br>n:$sqlr:";
					$resp = mysql_query($sqlr,$linkbd);
					$cont=0;
					while($row =mysql_fetch_row($resp))
					{		
						//ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $row[4],$fecha);
						//$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
						$fechaf=$row[4];
						//echo $fechaf;
						$bloq=bloqueos($_SESSION[cedulausu],$fechaf);
						if($bloq>=1)
						{		
							$sqlr="update pptocdp set estado='S' where consvigencia=$row[2] AND VIGENCIA='$row[0]'";
							//echo "up: ".$sqlr;
							if (!mysql_query($sqlr,$linkbd))
							{
	 							echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
								//	 $e =mysql_error($respquery);
								echo "Ocurrió el siguiente problema:<br>";
  	 							//echo htmlentities($e['message']);
  								echo "<pre>";
     							//echo htmlentities($e['sqltext']);
    							// printf("\n%".($e['offset']+1)."s", "^");
     							echo "</pre></center></td></tr></table>";
							}	
							else
							{		
								$sqlr="update pptorp set estado='N' where consvigencia=$_POST[var1] AND VIGENCIA='$row[0]'";
								mysql_query($sqlr,$linkbd);
								$sqlr="update pptocomprobante_cab set pptocomprobante_cab.estado='0' where pptocomprobante_cab.numerotipo=$_POST[var1] and pptocomprobante_cab.tipo_comp=7 and pptocomprobante_cab.vigencia=$vigusu";
								mysql_query($sqlr,$linkbd);
								$sqlr="update pptocomprobante_det set pptocomprobante_det.estado='0' where pptocomprobante_det.numerotipo=$_POST[var1] and pptocomprobante_det.tipo_comp=7 and pptocomprobante_det.vigencia=$vigusu";
								mysql_query($sqlr,$linkbd);
									
								$sqlr="select *from pptocdp_detalle where pptocdp_detalle.consvigencia='$row[2]' AND VIGENCIA='$row[0]'";
								$resp2 = mysql_query($sqlr,$linkbd);
								$cont=0;
								while($row2 =mysql_fetch_row($resp2))
								{
									$sqlr="update pptocuentaspptoinicial set saldos= saldos + $row2[5] where cuenta=$row2[3] and vigencia=$vigusu";
									mysql_query($sqlr,$linkbd);
									$sqlr="update pptocuentaspptoinicial set saldoscdprp= saldoscdprp + $row2[5] where cuenta=$row2[3] and vigencia=$vigusu";
									mysql_query($sqlr,$linkbd);
								}						
								if (!mysql_query($sqlr,$linkbd))
								{
	 								echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
									//	 $e =mysql_error($respquery);
									echo "Ocurrió el siguiente problema:<br>";
									//echo htmlentities($e['message']);
									echo "<pre>";
									//echo htmlentities($e['sqltext']);
									// printf("\n%".($e['offset']+1)."s", "^");
									echo "</pre></center></td></tr></table>";
								}
								else
	 							{	
		 							echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha eliminado el registro con Exito</center></td></tr></table>"; 		 		  		}
	 						}
  						echo"<script>despliegamodalm('visible','5','Escriba la justificacion de la anulacion');</script>";
						}
  						else
   						{echo "<div class='inicio'><img src='imagenes\alert.png'> No Tiene los Permisos para Modificar este Documento</div>"; }
 					}
				}
				else
 				echo "<div class='ejemplo'>NO SE PUEDE ANULAR EL REGISTRO PRESUPUESTAL, FUE USADO EN UNA CUENTA POR PAGAR O LIQUIDACION DE NOMINA</div>";
			}
//sacar el consecutivo 
//$sqlr="select *from pptosideforigen where".$crit1.$crit2." order by pptosideforigen.codigo";
//if ($_POST[vigencia]!="" and $_POST[numero]!="" and  $_POST[fecha]!="" and  $_POST[solicita]!="" and $_POST[objeto]!="" )
//	$sqlr="select *from pptocdp order by pptocdp.consvigencia";
//else	 
	
// echo "<div><div>sqlr:".$sqlr."</div></div>";
?>
<table   class="inicio" >
      <tr >
        <td class="titulos" colspan="9">:: Anular Registro Presupuestal </td>
        <td width="67" class="cerrar" ><a href="presu-principal.php">Cerrar</a></td>        
    </tr>   
     <tr  >    
    <td width="65" class="saludo1">Numero:</td>
    <td width="255"><input name="numero" type="text" id="numero" value="<?php echo $_POST[numero] ?>" size="5"></td>
    <td width="81" class="saludo1">Fecha Inicial: </td>
    <td width="147" ><input name="fechaini" type="text" id="fc_1198971545" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fechaini]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">
        <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>          </td>
  <td width="141" class="saludo1">Fecha Final: </td>
    <td width="173" ><input name="fechafin" type="text" id="fc_1198971546" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fechafin]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10"><a href="#" onClick="displayCalendarFor('fc_1198971546');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a><input type="hidden" value="1" name="oculto2"><input name="oculto" type="hidden" value="1"> <input name="var1" type="hidden" value=<?php echo $_POST[var1];?>>
</td>  
  </tr>                      
</table>
<div class="subpantallap" style="height:75%; width:99.6%; overflow-x:hidden;">
<?php
if($_POST[oculto])
{
$linkbd=conectar_bd();
$crit1=" ";
$crit2=" ";
$crit3=" ";
$crit4=" ";
$crit5=" ";
if ($_POST[numero]!="")
$crit2=" and pptorp.consvigencia like '%$_POST[numero]%' ";
if ($_POST[fechaini]!="" and $_POST[fechafin]!="" )
{	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechaini],$fecha);
	$fechai=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechafin],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
$crit3=" and pptorp.fecha between '$fechai' and '$fechaf'  ";
}
//$sqlr="select *from pptorp where pptorp.estado='S' and vigencia='".$_SESSION[vigencia]."' order by pptorp.consvigencia";
$sqlr="select *from pptorp where pptorp.estado='S' and vigencia=$vigusu ".$crit1.$crit2.$crit3." order by pptorp.consvigencia desc";
$resp = mysql_query($sqlr,$linkbd);
$ntr = mysql_num_rows($resp);
$con=1;
echo "<table class='inicio' align='center' width='80%'><tr><td colspan='8' class='titulos'>Registro Presupuestal Encontrados: $ntr</td></tr><tr><td width='5%' class='titulos2'>Vigencia</td><td class='titulos2'>No Reg Presupuestal</td><td class='titulos2'>Número CDP</td><td class='titulos2'>Objeto</td><td class='titulos2'>Valor</td><td class='titulos2' width='10%'>Fecha</td><td class='titulos2'>Estado</td><td class='titulos2' width='5%'>Anular</td></tr>";	
$iter='saludo1a';
$iter2='saludo2';
 while ($row =mysql_fetch_row($resp)) 
 {
	  $sqlr2="select pptocdp.objeto from pptocdp where pptocdp.consvigencia=$row[2] and vigencia=$vigusu";
	 $resp2 = mysql_query($sqlr2,$linkbd);
	 $r2 =mysql_fetch_row($resp2);
	 echo "<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\"><td >$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$r2[0]</td><td>".number_format($row[6],2)."</td><td>$row[4]</td><td>$row[3]</td><td><a href='#' onClick=eliminar(id=$row[1])><center><img src='imagenes/anular.png'></center></a></td></tr>";
	 $con+=1;
	 $aux=$iter;
	 $iter=$iter2;
	 $iter2=$aux;
 }
}
 ?>  
</div>
 </form> 
</body>
</html>