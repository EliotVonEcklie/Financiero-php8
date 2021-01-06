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
        <script type="text/javascript" src="css/calendario.js"></script>
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
if (document.form2.cuenta.value!='' && document.form2.fecha.value!='' && document.form2.valor.value!='')
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
function validar(formulario)
{
document.form2.action="presu-recursos.php";
document.form2.submit();
}
function buscacta(e)
 {
if (document.form2.cuenta.value!="")
{
 document.form2.bc.value='2';
 document.form2.submit();
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
          		<td colspan="3" class="cinta"><a href="presu-presuinicialing.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a><a href="#"  onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar"/></a><a href="presu-buscarsaldos.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a><a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" Title="Nueva Ventana"></a></td>
        	</tr>
        </table>
<?php
$vigencia=date(Y);
$linkbd=conectar_bd();
$sqlr="select * from pptosaldoinicialproceso where vigencia='$vigencia' and estado='S'";
$resp = mysql_query($sqlr,$linkbd);
//echo $sqlr;
$aceptar="N";
while ($row =mysql_fetch_row($resp)) 
 {
  $aceptar=$row[3];
 }
if ($aceptar=='S') //***************VERIFICACION DE CIERRE DE SALDOS **************
 {
 ?>	
<?php
if(!$_POST[oculto])
{
 		 $fec=date("d/m/Y");
		 $_POST[fecha]=$fec; 	
 	 	 $_POST[valor]=0; 			 
}
?>
 <form name="form2" method="post" action="">
 <?php
			//**** busca cuenta
			if($_POST[bc]=='2')
			 {
			  $nresul=buscacuentapres($_POST[cuenta],2);			
			  if($nresul!='')
			   {
			  $_POST[ncuenta]=$nresul;
			   }
			  else
			  {
			   $_POST[ncuenta]="";	
			   }
			 }
		?>
    <table class="inicio" align="center" width="80%" >
      <tr >
        <td class="titulos" colspan="6">.: Agregar Presupuesto Inicial - Gastos </td>
        <td width="61" class="cerrar" ><a href="presu-principal.php"> Cerrar</a></td>
      </tr>
      <tr  >
	  <td width="96" class="saludo1">Fecha:        </td>
        <td width="194"><input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">         <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>        </td>
		 <td width="119" class="saludo1">Cuenta:</td>
          <td width="197" valign="middle" ><input type="text" id="cuenta" name="cuenta" size="20" onKeyPress="javascript:return solonumeros(event)" 
		  onKeyUp="return tabular(event,this)" onBlur="buscacta(event)" value="<?php echo $_POST[cuenta]?>" onClick="document.getElementById('cuenta').focus();document.getElementById('cuenta').select();"><input type="hidden" value="0" name="bc"><a href="#" onClick="mypop=window.open('cuentasppto-ventana.php?ti=2','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a></td><td colspan="2"><input name="ncuenta" type="text" value="<?php echo $_POST[ncuenta]?>" size="70" readonly></td></tr>
		  <tr>
		  <td class="saludo1">Valor:</td>
		  <td><input type="text" id="valor" name="valor" size="20" onKeyPress="javascript:return solonumeros(event)" 
		  onKeyUp="return tabular(event,this)"  value="<?php echo $_POST[valor]?>" onClick="document.getElementById('valor').focus();document.getElementById('valor').select();"></td><td><input type="button" name="guardard" id="guardard" value="   Guardar   " onClick="guardar()"><input type="hidden" value="1" name="oculto"></td>
       </tr>  
    </table>
	<?php
	if(!$_POST[oculto])
	{ 
		 ?>
		 <script>
    	document.form2.fecha.focus();
		</script>
	<?php
	}
	?>
	 <?php
			//**** busca cuenta
			if($_POST[bc]=='2')
			 {
			  $nresul=buscacuentapres($_POST[cuenta],2);
			  if($nresul!='')
			   {
			  $_POST[ncuenta]=$nresul;
  			  ?>
			  <script>
			  document.getElementById('valor').focus();
			  document.getElementById('valor').select();</script>
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
    </form>
  <?php
$oculto=$_POST['oculto'];
if($_POST[oculto]=='2')
{
$linkbd=conectar_bd();
if ($_POST[cuenta]!="")
 {
 $nr="1";
 	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
 $sqlr="INSERT INTO pptocuentaspptoinicial (cuenta,fecha,valor,estado,pptodef,saldos)VALUES ('$_POST[cuenta]','".$fechaf."',$_POST[valor], 'S',$_POST[valor],$_POST[valor])";
 //echo "sqlr:".$sqlr;
  if (!mysql_query($sqlr,$linkbd))
	{
	 echo "<script>alert('CUENTA YA TIENE SALDO INICIAL');document.form2.fecha.focus();</script>";
	}
  else
  {
  echo "<table><tr><td class='saludo1'><center><h2>Se ha almacenado con Exito</h2></center></td></tr></table>";
  echo "<script>document.form2.cuenta.value='';</script>";
      echo "<script>document.form2.ncuenta.value='';</script>";
      echo "<script>document.form2.valor.value=0;</script>";
	  echo "<script>document.form2.fecha.focus();</script>";
  }
 }
else
 {
  echo "<table><tr><td class='saludo1'><center><H2>Falta informacion para Crear el Presupuesto Inicial de la Cuenta</H2></center></td></tr></table>";
  echo "<script>document.form2.fecha.focus();</script>";  
 }
}
}//******************************* fin de LA CONDICION DE VERIFICACION DE CIERRE DE SALDOS
else
 {
  echo "<table><tr><td class='saludo1'><center><H2>LOS SALDOS INICIALES ESTAN BLOQUEADOS, PARA DESBLOQUEAR CONSULTE AL ADMINISTRADOR</H2></center></td></tr></table>";
 }
?> 
</td></tr>     
</table>
</body>
</html>