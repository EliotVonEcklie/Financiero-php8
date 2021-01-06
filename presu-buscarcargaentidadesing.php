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
		<title>:: SieS - Presupuesto</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
		<link href="css/css3.css" rel="stylesheet" type="text/css" />
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

function validar(formulario)
{
document.form2.action="presu-buscaorigen.php";
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
				<a href="presu-cargaentidadesingresos.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
				<a class="mgbt"><img src="imagenes/guardad.png"/></a>
				<a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a>
				<a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
			</tr>
		</table>	
 <form name="form2" method="post" action="presu-buscarcargaentidades.php">
<table  class="inicio" align="center" >
      <tr >
		<td class="titulos" colspan="9" style='width:93%'>:: Buscar Cargue Entidades - Ejecucion de Ingresos</td>
        <td class="cerrar" style='width:7%' onClick="location.href='presu-principal.php'">Cerrar</td>
      </tr>
      <tr >
      <td class="saludo1" style="width:6%;">Trimestre:</td>
        <td>
			<select name="trimestre" id="trimestre">
				<option value="">Seleccione...</option>
					<option value="1" <?php if($_POST[trimestre]=="1"){echo "SELECTED"; } ?> >Enero-Marzo</option>
					<option value="2" <?php if($_POST[trimestre]=="2"){echo "SELECTED"; } ?>>Abril-Junio</option>
					<option value="3" <?php if($_POST[trimestre]=="3"){echo "SELECTED"; } ?> >Julio-Septiembre</option>
					<option value="4" <?php if($_POST[trimestre]=="4"){echo "SELECTED"; } ?>>Octubre-Diciembre</option>
			</select>
		</td>
       <td class="saludo1" style="width:10%;">Unidad Ejecutora:</td>
	  		<td>
				<select name="cc" onKeyUp="return tabular(event,this)">
					<option value="">Seleccione...</option>
						<?php
							$sqlr="SELECT * FROM pptouniejecu WHERE estado='S' AND entidad='N'";
							$res=mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($res)) 
				   			{
								if($row[0]==$_POST[cc]){echo "<option value=$row[0] SELECTED>$row[0] - $row[1]</option>";}
								else {echo "<option value=$row[0]>$row[0] - $row[1]</option>";}
							}	 	
						?>
				</select>
			</td>
		<td class="saludo1">Vigencia:</td>
        <td>
			<input name="vigencia" type="text" value="" size="10">
        </td>
         <td>
			<input type="button" name="bboton" onClick="document.form2.submit();" value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;" />
		</td>
       </tr>                       
    </table>    
    <div class="subpantalla" style="height:68.5%; width:99.6%; overflow-x:hidden;">
      <?php
$oculto=$_POST['oculto'];
//if($_POST[oculto])
{
$linkbd=conectar_bd();
$crit1=" ";
$crit2=" ";
$crit3=" ";

if ($_POST[trimestre]!="")
$crit1=" and entidadesing.trimestre like '%".$_POST[trimestre]."%' ";
if ($_POST[cc]!="")
$crit2=" and entidadesing.unidad like '%$_POST[cc]%' ";
if ($_POST[vigencia]!="")
$crit3=" and entidadesing.vigencia like '%".$_POST[vigencia]."%' ";

//$sqlr="select *from pptosideforigen where".$crit1.$crit2." order by pptosideforigen.codigo";
//if ($_POST[consecutivo]!="" or $_POST[acto]!="" or $_POST[vigencia]!="")
	$sqlr="select *from entidadesing where entidadesing.cuenta!=''".$crit1.$crit2.$crit3." GROUP BY fecha";
//else
///	$sqlr="select *from pptoacuerdos where pptoacuerdos.tipo='I'";
		 
//$sqlr="select pptocuentaspptoinicial.cuenta, pptocuentas.nombre, pptocuentaspptoinicial.fecha, pptocuentaspptoinicial.vigencia, pptocuentaspptoinicial.valor, pptocuentaspptoinicial.pptodef, pptocuentaspptoinicial.saldos, pptoacuerdos.consecutivo, pptoacuerdos.numero_acuerdo  from pptocuentaspptoinicial, pptocuentas, pptoacuerdos where pptocuentaspptoinicial.cuenta=pptocuentas.cuentas and pptocuentaspptoinicial.id_acuerdo=pptoacuerdos.id_acuerdo ".$crit1.$crit2." order by pptocuentaspptoinicial.cuenta";

// echo "<div><div>sqlr:".$sqlr."</div></div>";
$resp = mysql_query($sqlr,$linkbd);
$ntr = mysql_num_rows($resp);
$con=1;
echo "<table class='inicio' align='center' width='80%'>
		<tr>
			<td colspan='10' class='titulos'>.: Resultados Busqueda:</td>
		</tr>
		<tr>
			<td width='5%' class='titulos2'>Unidad</td>
			<td class='titulos2'>Vigencia</td>
			<td class='titulos2'>Trimestre</td> 
			<td class='titulos2'>Fecha</td> 
			<td class='titulos2'>Tipo</td>
			<td class='titulos2'>Ver</td>
		</tr>";	
//echo "nr:".$nr;
$iter='saludo1';
$iter2='saludo2';
 while ($row =mysql_fetch_row($resp)) 
 {
	 if($row[12]=='1')
		 $tri="Enero-Marzo";
	 elseif($row[12]=='2')
		$tri="Abril-Junio";
	 elseif($row[12]=='3')
		$tri="Julio-Septiembre";
	 else
		 $tri="Octubre-Diciembre";
	 
	 $sqlr="select nombre from pptouniejecu where id_cc='$row[10]'";
	 $result=mysql_query($sqlr,$linkbd);
	 $row1=mysql_fetch_row($result);
	 echo "
	 <tr >
		<td class='$iter'>".strtoupper($row1[0])."</td>
		<td class='$iter'>".strtoupper($row[11])."</td>
		<td class='$iter'>".strtoupper($tri)."</td>
		<td class='$iter'>".strtoupper($row[13])."</td>
		<td class='$iter'>Consolidacion Entidades</td>
		<td class='$iter'><a href='presu-cargaentidadesingver.php?trime=$row[12]&uni=$row[10]&fec=$row[13]&vig=$row[11]'><center><img src='imagenes/buscarep.png'></center></a></td>
	</tr>";
	 $con+=1;
	 $aux=$iter;
	 $iter=$iter2;
	 $iter2=$aux;
 }
 echo"</table>";
}
?></div>
</form>
</body>
</html>