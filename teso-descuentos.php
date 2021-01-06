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
<script>

//Pop-it menu- By Dynamic Drive
//For full source code and more DHTML scripts, visit http://www.dynamicdrive.com
//This credit MUST stay intact for use
var linksets=new Array()
var linkset2=new Array()
linksets= '<?php echo $_SESSION[linkset][0]; ?>';
linkset2[0]=linksets;
//alert("mensaje"+linkset2[0]);
linksets= '<?php echo $_SESSION[linkset][1]; ?>';
linkset2[1]=linksets
linksets= '<?php echo $_SESSION[linkset][2]; ?>'
linkset2[2]=linksets
linksets= '<?php echo $_SESSION[linkset][3]; ?>'
linkset2[3]=linksets
linksets= '<?php echo $_SESSION[linkset][4]; ?>'
linkset2[4]=linksets
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
  <td colspan="3" class="cinta"><a href="teso-ingresos.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a><a href="#"  onClick="document.form2.submit();" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a><a href="teso-buscaingresos.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a><a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
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
 	 	 $_POST[tipo]='S';
		 $_POST[valoradicion]=0;
		 $_POST[valorreduccion]=0;
		 $_POST[valortraslados]=0;		 		  			 
		 $_POST[valor]=0;		 
}
?>

 <form name="form2" method="post" action="">
 <?php //**** busca cuenta
  			if($_POST[bc]!='')
			 {
			  $nresul=buscacuentapres($_POST[cuenta],1);			
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
        <td class="titulos" colspan="6">Retenciones Pagos</td><td width="112" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
      </tr>
      <tr  >
	  <td width="90" class="saludo1">Codigo:        </td>
        <td width="180"><input name="codigo" type="text" value="<?php echo $_POST[codigo]?>" maxlength="2" size="2" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)">        </td>
        <td width="147" class="saludo1">Nombre Impuesto:        </td>
        <td width="644"><input name="nombre" type="text" value="<?php echo $_POST[nombre]?>" size="80" onKeyUp="return tabular(event,this)">        </td>
        <td width="73" class="saludo1">Tipo:        </td>
        <td><select name="tipo" id="tipo" onChange="validar()" >
			<option value="S" <?php if($_POST[tipo]=='S') echo "SELECTED"?>>Simple</option>
  			<option value="C" <?php if($_POST[tipo]=='C') echo "SELECTED"?>>Compuesto</option>
			</select>
			<input name="oculto" type="hidden" value="1">		  </td>
       </tr> 
	   </table>
	   <?php
	   if($_POST[tipo]=='S') //***** SIMPLE
	   {
	   ?>
	   <table class="inicio">
	   <tr><td colspan="4" class="titulos">Detalle Retencion Pago</td></tr>                  
	  <tr>
	  <td class="saludo1">Concepto Contable:</td><td><select name="concecont" id="concecont" >
				  <option value="-1">Seleccione ....</option>
					<?php
					 $sqlr="Select * from conceptoscontables  where modulo='4'  order by codigo";
		 		$resp = mysql_query($sqlr,$link);
				while ($row =mysql_fetch_row($resp)) 
				{
				$i=$row[0];
				echo "<option value=$row[0] ";
				if($i==$_POST[concecont])
			 	{
				 echo "SELECTED";
				 $_POST[concecontnom]=$row[1];
				 }
				echo " >".$row[0]." - ".$row[3]." - ".$row[1]."</option>";	  
			     }			
				?>
				  </select></td></tr>
         <tr>
	  <td class="saludo1">Cuenta presupuestal: </td> <td colspan="3" valign="middle" ><input type="text" id="cuenta" name="cuenta" size="20" onKeyPress="javascript:return solonumeros(event)" 
		  onKeyUp="return tabular(event,this)" onBlur="buscacta(event)" value="<?php echo $_POST[cuenta]?>" onClick="document.getElementById('cuenta').focus();document.getElementById('cuenta').select();"><input type="hidden" value="" name="bc" id="bc"><a href="#" onClick="mypop=window.open('cuentasppto-ventana.php?ti=<?php echo $_POST[tipocta] ?>','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>            <input name="ncuenta" type="text" value="<?php echo $_POST[ncuenta]?>" size="80" readonly></td>
	    </tr> 
    </table>
		<?php
		}
		if($_POST[tipo]=='C') //**** COMPUESTO
	   {
	   ?>
	    <table class="inicio">
	   <tr><td colspan="4" class="titulos">Agregar Detalle Retencion Pago</td></tr>                  
	  <tr>
	  <td class="saludo1">Concepto Contable:</td><td><select name="concecont" id="concecont" >
				  <option value="-1">Seleccione ....</option>
					<?php
					 $sqlr="Select * from conceptoscontables  where modulo='4'  order by codigo";
		 		$resp = mysql_query($sqlr,$link);
				while ($row =mysql_fetch_row($resp)) 
				{
				$i=$row[0];
				echo "<option value=$row[0] ";
				if($i==$_POST[concecont])
			 	{
				 echo "SELECTED";
				 $_POST[concecontnom]=$row[1];
				 }
				echo " >".$row[0]." - ".$row[3]." - ".$row[1]."</option>";	  
			     }			
				?>
				  </select></td>
	  <td class="saludo1">Cuenta presupuestal: </td>
          <td colspan="3" valign="middle" ><input type="text" id="cuenta" name="cuenta" size="20" onKeyPress="javascript:return solonumeros(event)" 
		  onKeyUp="return tabular(event,this)" onBlur="buscacta(event)" value="<?php echo $_POST[cuenta]?>" onClick="document.getElementById('cuenta').focus();document.getElementById('cuenta').select();"><input type="hidden" value="" name="bc" id="bc"><a href="#" onClick="mypop=window.open('cuentasppto-ventana.php?ti=1','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>            <input name="ncuenta" type="text" value="<?php echo $_POST[ncuenta]?>" size="80" readonly></td></tr>
		  <tr>		  <td class="saludo1">Porcentaje:</td><td><input id="valor" name="valor" type="text" value="<?php echo $_POST[valor]?>" onKeyUp="return tabular(event,this)" size="5" onKeyPress="javascript:return solonumeros(event)" > % <input type="button" name="agregar" id="agregar" value="   Agregar   " onClick="agregardetalle()" ><input type="hidden" value="0" name="agregadet"></td>
	    </tr> 
    </table>
	 <?php
			//**** busca cuenta
			if($_POST[bc]!='')
			 {
			  $nresul=buscacuentapres($_POST[cuenta],1);
			  if($nresul!='')
			   {
			  $_POST[ncuenta]=$nresul;
  			  ?>
			  <script>
			  document.getElementById('valor').focus();
			  document.getElementById('valor').select();
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
	<table class="inicio">
	<tr><td class="titulos" colspan="6">Detalle Retencion Pago</td></tr>
	<tr><td class="titulos2">Cuenta</td><td class="titulos2">Nombre Cuenta</td><td class="titulos2">Concepto</td><td class="titulos2"><img src="imagenes/del.png" ><input type='hidden' name='elimina' id='elimina'></td></tr>
	<?php
			 
	if ($_POST[elimina]!='')
		 { 
		 $posi=$_POST[elimina];
		 unset($_POST[tcuentas][$posi]);
		 unset($_POST[dcuentas][$posi]);
 		 unset($_POST[dncuentas][$posi]);
		 unset($_POST[dccs][$posi]);
		 unset($_POST[dcreditos][$posi]);		 		 		 		 		 
		 unset($_POST[ddebitos][$posi]);		 
		 $_POST[tcuentas]= array_values($_POST[tcuentas]); 
		 $_POST[dcuentas]= array_values($_POST[dcuentas]); 
		 $_POST[dncuentas]= array_values($_POST[dncuentas]); 		 		 
		 $_POST[dccs]= array_values($_POST[dccs]); 
		 $_POST[dcreditos]= array_values($_POST[dcreditos]); 
		 $_POST[ddebitos]= array_values($_POST[ddebitos]); 		 		 		 		 
		 }
	
	if ($_POST[agregadet]=='1')
		 {
		  $cuentacred=0;
		  $cuentadeb=0;
		  $diferencia=0;
		 $_POST[tcuentas][]='N';
		 $_POST[dcuentas][]=$_POST[cuenta];
		 $_POST[dncuentas][]=$_POST[ncuenta];
		 $_POST[dccs][]=$_POST[cc];		 
		 if ($_POST[debcred]==1)
		  {
		  $_POST[dcreditos][]='N';
		  $_POST[ddebitos][]="S";
	 	  }
		 else
		  {
		  $_POST[dcreditos][]='S';
		  $_POST[ddebitos][]="N";
		  }
		 $_POST[agregadet]=0;
		  ?>
		 <script>
		  		//document.form2.cuenta.focus();	
				document.form2.cc.select();
				document.form2.cc.value="";
		 </script>
		 <?php
		 }
		 for ($x=0;$x< count($_POST[dcuentas]);$x++)
		 {echo "<tr><td class='saludo2'><input name='tcuentas[]' value='".$_POST[tcuentas][$x]."' type='hidden' ><input name='dcuentas[]' value='".$_POST[dcuentas][$x]."' type='text' size='8' readonly></td><td class='saludo2'><input name='dncuentas[]' value='".$_POST[dncuentas][$x]."' type='text' size='70' readonly></td><td class='saludo2'><input name='ddebitos[]' value='".$_POST[ddebitos][$x]."' type='text' size='3' onDblClick='llamarventanadeb(this,$x)' readonly></td><td class='saludo2'><input name='dcreditos[]' value='".$_POST[dcreditos][$x]."' type='text' size='3' onDblClick='llamarventanacred(this,$x)' readonly></td><td class='saludo2'><a href='#' onclick='eliminar($x)'><img src='imagenes/del.png'></a></td></tr>";
		 }	 
		 ?>
	<tr></tr>
	</table>	
	   <?php
	   }
		?>
    </form>
  <?php
$oculto=$_POST['oculto'];
if($_POST[oculto]=='2')
{
$linkbd=conectar_bd();
if ($_POST[nombre]!="")
 {
 $nr="1";
 $sqlr="INSERT INTO centrocosto (id_cc,nombre,estado)VALUES ('$_POST[codigo]','".utf8_decode($_POST[nombre])."', '$_POST[estado]')";
 //echo "sqlr:".$sqlr;
  if (!mysql_query($sqlr,$linkbd))
	{
	 echo "<table><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
//	 $e =mysql_error($respquery);
	 echo "Ocurrió el siguiente problema:<br>";
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
  echo "<table><tr><td class='saludo1'><center><H2>Falta informacion para Crear el Centro Costo</H2></center></td></tr></table>";
 }
}
?> </td></tr>
     
</table>
</body>
</html>