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
<title>:: SPID - Tesoreria</title>

<script>
//************* ver reporte ************
//***************************************
function verep(idfac)
{
  document.form1.oculto.value=idfac;
  document.form1.submit();
  }
</script>
<script>
//************* genera reporte ************
//***************************************
function genrep(idfac)
{
  document.form2.oculto.value=idfac;
  document.form2.submit();
  }
</script>
<script>
function buscacta(e)
 {
if (document.form2.cuenta.value!="")
{
 document.form2.bc.value='1';
 document.form2.submit();
 }
 }
</script>
<script>
function buscactap(e)
 {
if (document.form2.cuentap.value!="")
{
 document.form2.bcp.value='1';
 document.form2.submit();
 }
 }
</script>
<script language="JavaScript1.2">
function validar()
{
document.form2.submit();
}
</script>
<script>
function guardar()
{
//   alert("Balance Descuadrado");
//valor=document.form2.codigo.value;
if (document.form2.codigo.value!='' && document.form2.nombre.value!='')
 {
	if (confirm("Esta Seguro de Guardar"))
  {
document.form2.oculto.value=2;
document.form2.action="teso-sanciones.php";
document.form2.submit();
  }
 }
 else 
  {
   alert("Comprobante descuadrado o faltan informacion");
  }
}

			


		function despliegamodal2(_valor,_nomve)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){
					document.getElementById('ventana2').src="";
				}
				else {
					document.getElementById('ventana2').src="cuentas-ventana01.php";
					switch(_nomve)
					{
						case "1":	document.getElementById('ventana2').src="cuentas-ventana01.php";break;
						case "2":	document.getElementById('ventana2').src="scuentasppto-ventana01.php?ti=1";break;
					}
				}
			}
</script>
<script src="css/programas.js"></script>
<link href="css/css2.css" rel="stylesheet" type="text/css" />
<link href="css/css3.css" rel="stylesheet" type="text/css" />
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
	<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
	<tr><?php menu_desplegable("teso");?></tr>
<tr>
  <td colspan="3" class="cinta">
	  <a href="teso-sanciones.php" class="mgbt"><img src="imagenes/add.png" alt="Nuevo"  border="0"  title="Nuevo"/></a> 
	  <a href="#"  onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png"  alt="Guardar" title="Guardar"/></a>
	  <a href="teso-buscasanciones.php" class="mgbt" > <img src="imagenes/busca.png"  alt="Buscar"  title="Buscar"/></a> 
	  <a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt" ><img src="imagenes/nv.png" alt="nueva ventana" title="Nueva ventana"></a> </td>
</tr>		  
</table>
<tr><td colspan="3" class="tablaprin" align="center"> 
<?php
$vigencia=date(Y);
 ?>	
<?php
if(!$_POST[oculto])
{
 		 $fec=date("d/m/Y");
		 $_POST[fecha]=$fec; 	
		 $_POST[valoradicion]=0;
		 $_POST[valorreduccion]=0;
		 $_POST[valortraslados]=0;		 		  			 
		 $_POST[valor]=0;		 
}
?>

 <form name="form2" method="post" action="">
 		<?php //**** busca cuentas
  			if($_POST[bcp]!='')
			 {
			  $nresul=buscacuentapres($_POST[cuentap],1);			
			  if($nresul!='')
			   {
			  $_POST[ncuentap]=$nresul;
			   }
			  else
			  {
			   $_POST[ncuentap]="";	
			   }
			 }
			 if($_POST[bc]!='')
			 {
			  $nresul=buscacuenta($_POST[cuenta],1);			
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
    <table class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="9">Crear Sancion </td>
        <td style="width:10%;" class="cerrar" ><a href="teso-principal.php"> Cerrar</a></td>
      </tr>
      <tr  >
	  <td style="width:5%;" class="saludo1">Codigo:  </td>
        <td style="width:10%;">
			<input name="codigo" id='codigo' type="text" value="<?php echo $_POST[codigo]?>" maxlength="2" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" >        </td>
        <td style="width:5%;" class="saludo1">Nombre:        </td>
        <td style="width:30%;">
			<input name="nombre" type="text" value="<?php echo $_POST[nombre]?>"  onKeyUp="return tabular(event,this)" style="width:100%;">        </td>
		<td style="width:6%;" class="saludo1">Porcentaje:</td>
		<td >
			<input id="valor" name="valor" type="text" value="<?php echo $_POST[valor]?>" onKeyUp="return tabular(event,this)"  onKeyPress="javascript:return solonumeros(event)" style="width:25%;"> % <input type="hidden" name="oculto" value="1"></td>
       </tr> 
      </table>
	  
	   <table class="inicio">
	   <tr>
	     <td colspan="5" class="titulos">Detalle Sancion </td>
	   </tr>                  
		  <tr>
			  <td style="width:10%;" class="saludo1">Cuenta Contable: </td>
			  <td colspan="2" style="width:60%;" valign="middle" >
				
				<input type="text" id="cuenta" name="cuenta" style="width:10%"  onKeyPress="javascript:return solonumeros(event)" 
			  onKeyUp="return tabular(event,this)" onBlur="buscacta(event)" value="<?php echo $_POST[cuenta]?>" onClick="document.getElementById('cuenta').focus();document.getElementById('cuenta').select();">
				
				<input type="hidden"  value="" name="bc"><a onClick="despliegamodal2('visible','1');"  style='cursor:pointer;' title='Listado Cuentas Contables'><img src='imagenes/find02.png' style='width:20px;'/>
                </a>
				
			  <input name="ncuenta" type="text" style="width:50%;" value="<?php echo $_POST[ncuenta]?>"  readonly >
			  </td>
			  
	     </tr>
		 <tr>
		  <td style="width:10%;" class="saludo1">Cuenta presupuestal: </td>
		  
          <td colspan="2" style="width:60%;" valign="middle" >
			<input type="text" id="cuentap" style="width:10%" name="cuentap"  onKeyPress="javascript:return solonumeros(event)" 
		  onKeyUp="return tabular(event,this)" onBlur="buscactap(event)" value="<?php echo $_POST[cuentap]?>" onClick="document.getElementById('cuentap').focus();document.getElementById('cuentap').select();">
		  <input type="hidden" value="" name="bcp" id="bcp"><a onClick="despliegamodal2('visible','2');"  style='cursor:pointer;' title='Listado Cuentas Contables'><img src="imagenes/find02.png" style="width:20px"></a>
	     
			<input name="ncuentap" type="text" style="width:50%;" value="<?php echo $_POST[ncuentap]?>" readonly></td>
         </tr> 
    </table>
			 <?php
			//**** busca cuenta
			if($_POST[bc]!='')
			 {
			  $nresul=buscacuenta($_POST[cuenta]);
			  if($nresul!='')
			   {
			  $_POST[ncuenta]=$nresul;
  			  ?>
			  <script>
			  document.getElementById('cuentap').focus();
			  document.getElementById('cuentap').select();
			  document.getElementById('bc').value='';
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

	 <?php
			//**** busca cuenta
			if($_POST[bcp]!='')
			 {
			  $nresul=buscacuentapres($_POST[cuentap],1);
			  if($nresul!='')
			   {
			  $_POST[ncuentap]=$nresul;
  			  ?>
			  <script>
			  document.getElementById('codigo').focus();
			  document.getElementById('codigo').select();
			  document.getElementById('bcp').value='';
			  </script>
			  <?php
			  }
			 else
			 {
			  $_POST[ncuentap]="";
			  ?>
			  <script>alert("Cuenta Incorrecta");
			  document.form2.cuentap.focus();
			  document.form2.cuentap.select();
			  </script>
			  <?php
			  }
			 }
		?>
		<div id="bgventanamodal2">
                <div id="ventanamodal2">
                    <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                    </IFRAME>
                </div>
       	 	</div>
    </form>
  <?php
$oculto=$_POST['oculto'];
if($_POST[oculto]=='2')
{
$linkbd=conectar_bd();
if ($_POST[nombre]!="" and $_POST[codigo]!="" )
 {  
 $nr="1";
 $sqlr="INSERT INTO tesosanciones (id_sancion,nombre,cuentacontable,cuentapptal,porcentaje,estado)VALUES ('$_POST[codigo]','".utf8_decode($_POST[nombre])."','$_POST[cuenta]','$_POST[cuentap]','$_POST[valor]','S')";
  if (!mysql_query($sqlr,$linkbd))
	{
	 echo "<table><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petici�n: <br><font color=red><b>$sqlr</b></font></p>";
//	 $e =mysql_error($respquery);
	 echo "Ocurri� el siguiente problema:<br>";
  	 //echo htmlentities($e['message']);
  	 echo "<pre>";
     ///echo htmlentities($e['sqltext']);
    // printf("\n%".($e['offset']+1)."s", "^");
     echo "</pre></center></td></tr></table>";
	}
  else
  {
  echo "<table><tr><td class='saludo1'><center><h2>Se ha almacenado con Exito</h2></center></td></tr></table>";
  }
 }
else
 {
  echo "<table><tr><td class='saludo1'><center><H2>Falta informacion para Crear la Sancion</H2></center></td></tr></table>";
 }
}
?> </td></tr>
     
</table>
</body>
</html>