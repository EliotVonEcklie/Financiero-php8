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
          		<td colspan="3" class="cinta"><a href="presu-presuinicial.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a><a class="mgbt"><img src="imagenes/guardad.png"/></a><a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a><a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="Nueva Ventana"></a></td>
			</tr>
		</table>
 <form name="form2" method="post" action="presu-buscarpresuinicial.php">
<table  class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="4">:: Buscar Presupuesto Inicial </td>
        <td class="cerrar" ><a href="presu-principal.php"> Cerrar</a></td>
      </tr>
      <tr >
      <td class="saludo1">Cuenta:</td>
        <td><input name="cuenta" type="text" value="" size="40">
        </td>
        <td class="saludo1">Codigo:
        </td>
        <td><input name="documento" type="text" id="documento" value="" size="2" maxlength="2">
          <input name="oculto" type="hidden" value="1"></td>
          
       </tr>                       
    </table>    
    <div class="subpantalla" style="height:68.5%; width:99.6%; overflow-x:hidden;">
      <?php
$oculto=$_POST['oculto'];
if($_POST[oculto])
{
$linkbd=conectar_bd();
$crit1=" ";
$crit2=" ";
if ($_POST[nombre]!="")
$crit1=" where pptosideforigen.nombre like '%".$_POST[nombre]."%' ";
if ($_POST[documento]!="")
$crit2=" where pptosideforigen.codigo like '%$_POST[documento]%' ";
//sacar el consecutivo 
//$sqlr="select *from pptosideforigen where".$crit1.$crit2." order by pptosideforigen.codigo";
//if ($_POST[nombre]!="" and $_POST[documento]!="")
	$sqlr="select pptocuentaspptoinicial.cuenta, pptocuentas.nombre, pptocuentaspptoinicial.fecha, pptocuentaspptoinicial.vigencia, pptocuentaspptoinicial.valor, pptocuentaspptoinicial.pptodef, pptocuentaspptoinicial.saldos, pptoacuerdos.consecutivo, pptoacuerdos.numero_acuerdo   from pptocuentaspptoinicial, pptocuentas, pptoacuerdos where pptocuentaspptoinicial.cuenta=pptocuentas.cuenta and pptocuentaspptoinicial.id_acuerdo=pptoacuerdos.id_acuerdo order by pptocuentaspptoinicial.cuenta";
//else	 
	//$sqlr="select pptocuentaspptoinicial.cuenta, pptocuentas.nombre, pptocuentaspptoinicial.fecha, pptocuentaspptoinicial.vigencia, pptocuentaspptoinicial.valor, pptocuentaspptoinicial.pptodef, pptocuentaspptoinicial.saldos, pptoacuerdos.consecutivo, pptoacuerdos.numero_acuerdo  from pptocuentaspptoinicial, pptocuentas, pptoacuerdos where pptocuentaspptoinicial.cuenta=pptocuentas.cuentas and pptocuentaspptoinicial.id_acuerdo=pptoacuerdos.id_acuerdo ".$crit1.$crit2." order by pptocuentaspptoinicial.cuenta";

// echo "<div><div>sqlr:".$sqlr."</div></div>";
$resp = mysql_query($sqlr,$linkbd);
$ntr = mysql_num_rows($resp);
$con=1;
echo "<table class='inicio' align='center' width='80%'><tr><td colspan='10' class='titulos'>.: Resultados Busqueda:</td></tr><tr><td colspan='5'>Presupuesto Inicial Encontrados: $ntr</td></tr><tr><td width='5%' class='titulos2'>Cuenta</td><td class='titulos2'>Nombre de Cuenta</td><td class='titulos2'>Fecha</td> <td class='titulos2'>Vigencia</td> <td class='titulos2'>Valor</td> <td class='titulos2'>Presupuesto Definitivo</td><td class='titulos2'>Saldo</td><td class='titulos2'>Consecutivo</td><td class='titulos2'>Acuerdo</td></tr>";	
//echo "nr:".$nr;
$iter='saludo1';
$iter2='saludo2';
 while ($row =mysql_fetch_row($resp)) 
 {
	 echo "<tr ><td class='$iter'>".strtoupper($row[0])."</td><td class='$iter'>".strtoupper($row[1])."</td><td class='$iter'>".strtoupper($row[2])."</td><td class='$iter'>".strtoupper($row[3])."</td><td class='$iter'>".strtoupper($row[4])."</td><td class='$iter'>".strtoupper($row[5])."</td><td class='$iter'>".strtoupper($row[6])."</td><td class='$iter'>".strtoupper($row[7])."</td><td class='$iter'>".strtoupper($row[8])."</td></tr>";
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