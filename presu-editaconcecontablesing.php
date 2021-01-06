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
if (document.form2.numero.value!='' && document.form2.nombre.value!='')
  {
	if (confirm("Esta Seguro de Guardar"))
  	{
  	document.form2.oculto.value=2;
  	document.form2.submit();
  	}
  }
 else{
  alert('Faltan datos para completar el registro');
  	document.form2.numero.focus();
  	document.form2.numero.select();
  }
 }
function clasifica(formulario)
{
//document.form2.action="presu-recursos.php";
document.form2.submit();
}
function agregardetalle()
{
if(document.form2.cuenta.value!=""  && document.form2.cc.value!="" )
 {
document.form2.agregadet.value=1;
document.form2.oculto.value=9;
document.form2.submit();
 }
 else {
 alert("Falta informacion para poder Agregar");
 }
}
function eliminar(variable)
{
if (confirm("Esta Seguro de Eliminar"))
  {
document.form2.oculto.value=9;
document.form2.elimina.value=variable;
//eli=document.getElementById(elimina);
vvend=document.getElementById('elimina');
//eli.value=elimina;
vvend.value=variable;
document.form2.submit();
}
}
function buscacta(e)
 {
if (document.form2.cuenta.value!="")
{
 document.form2.bc.value='1';
 document.form2.oculto.value=9;
 document.form2.submit();
 }
 }
function buscacc(e)
 {
if (document.form2.cc.value!="")
{
 document.form2.bcc.value='1';
 document.form2.submit();
 }
 }
function validar2()
{
//   alert("Balance Descuadrado");
document.form2.oculto.value=2;
document.form2.action="presu-editaconcecontablesing.php";
document.form2.submit();
}
function validar()
{
document.form2.oculto.value=9;
document.form2.submit();
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
          		<td colspan="3" class="cinta"><a href="presu-concecontablesing.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a><a href="#"  onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar"/></a><a href="presu-buscaconcecontablesing.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a><a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
        	</tr>
        </table>
<?php
if($_POST[oculto]==0)
{	
	$linkbd=conectar_bd();
	$sqlr="select *from conceptoscontables, conceptoscontables_det,cuentas  where conceptoscontables.codigo=conceptoscontables_det.codigo and conceptoscontables.codigo=$_GET[is] and conceptoscontables.tipo='I' and conceptoscontables_det.tipo='I' and conceptoscontables_det.cuenta=cuentas.cuenta and conceptoscontables.modulo='3' ";
	$res=mysql_query($sqlr,$linkbd); 
	$cont=0;
	while ($row=mysql_fetch_row($res)) 
 		{
		$_POST[nombre]=$row[1];
		$_POST[numero]=$row[0];
		$_POST[dcuentas][$cont]=$row[8];
		$_POST[dccs][$cont]=$row[9];
		$_POST[dncuentas][$cont]=$row[15];
		$_POST[ddebitos][$cont]=$row[10];
		$_POST[dcreditos][$cont]=$row[11];
		$cont=$cont+1;
		}
}
?>
 <form name="form2" method="post" action=""> 
<?php //**** busca cuenta
  			if($_POST[bc]=='1')
			 {
			  $nresul=buscacuenta($_POST[cuenta]);
			  if($nresul!='')
			   {
			  $_POST[ncuenta]=$nresul;
  	
			  }
			 else
			 {
			  $_POST[ncuenta]="";
			  }
			 }
			  //**** busca centro costo
  			if($_POST[bcc]=='1')
			 {
			  $nresul=buscacentro($_POST[cc]);
			  if($nresul!='')
			   {
			  $_POST[ncc]=$nresul;
  	
			  }
			 else
			 {
			  $_POST[ncc]="";
			  }
			 }
			 ?>
    <table class="inicio" align="center"  >
      <tr >
        <td class="titulos" colspan="8">.: Editar Concepto Contable Ingresos </td>
        <td width="61" class="cerrar" ><a href="presu-principal.php"> Cerrar</a></td>
      </tr>
      <tr  >
		<td width="119" class="saludo1">Codigo:</td>
          <td width="197" valign="middle" ><input type="text" id="numero" name="numero" size="10" onKeyPress="javascript:return solonumeros(event)" 
		  onKeyUp="return tabular(event,this)" value="<?php echo $_POST[numero]?>" onClick="document.getElementById('numero').focus();document.getElementById('numero').select();"></td>
		 <td width="119" class="saludo1">Nombre:</td>
          <td width="197" valign="middle" ><input type="text" id="nombre" name="nombre" size="80" 
		  onKeyUp="return tabular(event,this)" value="<?php echo $_POST[nombre]?>" onClick="document.getElementById('acuerdo').focus();document.getElementById('acuerdo').select();"></td><td class="saludo1">Tipo:</td><td><input name="tipo" value="Ingreso" size="10" type="text"><input name="tipoc" value="I" size="10" type="hidden"></td><td colspan="3"><center><a href="presu-concecontables.php">Volver Menu</a></center></td>
	    </tr>
    </table>
	<table class="inicio">
	<tr><td colspan="4" class="titulos2">Crear Detalle Concepto</td></tr>
	<tr><td class="saludo1">CC:</td><td colspan="2">
	<select name="cc"  onChange="validar()" onKeyUp="return tabular(event,this)">
	<?php
	$linkbd=conectar_bd();
	$sqlr="select *from centrocosto where estado='S'";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
				    {
					echo "<option value=$row[0] ";
					$i=$row[0];
		
					 if($i==$_POST[cc])
			 			{
						 echo "SELECTED";
						 }
					  echo ">".$row[0]." - ".$row[1]."</option>";	 	 
					}	 	
	?>
   </select>
	 </td>
        </tr>
	<tr>
	<td class="saludo1">Cuenta: </td>
          <td  valign="middle" ><input type="text" id="cuenta" name="cuenta" size="8" onKeyPress="javascript:return solonumeros(event)" 
		  onKeyUp="return tabular(event,this)" onBlur="buscacta(event)" value="<?php echo $_POST[cuenta]?>" onClick="document.getElementById('cuenta').focus();document.getElementById('cuenta').select();"><input type="hidden" value="0" name="bc"><a href="#" onClick="mypop=window.open('cuentas-ventana.php','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>  </td><td ><input name="ncuenta" type="text" value="<?php echo $_POST[ncuenta]?>" size="70" readonly></td>
	</tr>
	<tr>
	<td class="saludo1">Tipo:</td><td><select name="debcred">
          <option value="2" <?php if($_POST[debcred]=='2') echo "SELECTED"; ?>>Credito</option>
		  </select></td><td><input type="button" name="agrega" value="  Agregar  " onClick="agregardetalle()" ><input type="hidden" value="0" name="agregadet">
		  <?php
		if (!$_POST[oculto])
		 {
		 ?>
		<script>
    	//document.form2.cc.focus();
		</script>	
		<?php
		}
		
		if($_POST[bc]=='1')
			 {
			  $nresul=buscacuenta($_POST[cuenta]);
			  if($nresul!='')
			   {
			  $_POST[ncuenta]=$nresul;
  			  ?>
			  <script>
			  document.getElementById('debcred').focus();</script>
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
	 //*** centro  costo
			 if($_POST[bcc]=='1')
			 {
			  $nresul=buscacentro($_POST[cc]);
			  if($nresul!='')
			   {
			  $_POST[ncc]=$nresul;
  			  ?>
			  <script>
			  document.getElementById('cuenta').focus();document.getElementById('cuenta').select();</script>
			  <?php
			  }
			 else
			 {
			  $_POST[ncc]="";
			  ?>
			  <script>alert("Centro de Costos Incorrecto");document.form2.cc.focus();</script>
			  <?php
			  }
			 }
		
		?>
		  <input type="hidden" value="0" name="oculto">	
		  </td>
	</tr>
	</table>
	<table class="inicio">
	<tr><td class="titulos" colspan="6">Detalle Concepto</td></tr>
	<tr><td class="titulos2">CC</td><td class="titulos2">Cuenta</td><td class="titulos2">Nombre Cuenta</td><td class="titulos2">Debito</td><td class="titulos2">Credito</td><td class="titulos2"><img src="imagenes/del.png" ><input type='hidden' name='elimina' id='elimina'></td></tr>
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
		 {echo "<tr><td class='saludo2'  ><input name='dccs[]' value='".$_POST[dccs][$x]."' type='text' size='2'></td><td class='saludo2'><input name='tcuentas[]' value='".$_POST[tcuentas][$x]."' type='hidden' ><input name='dcuentas[]' value='".$_POST[dcuentas][$x]."' type='text' size='8' readonly></td><td class='saludo2'><input name='dncuentas[]' value='".$_POST[dncuentas][$x]."' type='text' size='70' readonly></td><td class='saludo2'><input name='ddebitos[]' value='".$_POST[ddebitos][$x]."' type='text' size='3' onDblClick='llamarventanadeb(this,$x)' readonly></td><td class='saludo2'><input name='dcreditos[]' value='".$_POST[dcreditos][$x]."' type='text' size='3' onDblClick='llamarventanacred(this,$x)' readonly></td><td class='saludo2'><a href='#' onclick='eliminar($x)'><img src='imagenes/del.png'></a></td></tr>";
		 }	 
		 ?>
	<tr></tr>
	</table>
</form>
	<?php 
	//********** GUARDAR EL COMPROBANTE ***********
	if($_POST[oculto]=='2')	
		{
		//rutina de guardado cabecera
		$linkbd=conectar_bd();
		
		$sqlr="delete from conceptoscontables_det where codigo='".$_POST[numero]."' and tipo='$_POST[tipoc]' and modulo ='3'";	 
		mysql_query($sqlr,$linkbd);
		$sqlr="delete from conceptoscontables where codigo='".$_POST[numero]."' and tipo='$_POST[tipoc]' and modulo ='3'";	 
		mysql_query($sqlr,$linkbd);
		
		
		
		ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
		$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
		$sqlr="insert into conceptoscontables (codigo,nombre,modulo,tipo) values ('$_POST[numero]','$_POST[nombre]',3,'$_POST[tipoc]')";
		if(!mysql_query($sqlr,$linkbd))
		 {
		   echo "<table class='inicio'><tr><td class='saludo1'><center>No Se ha Almacenado con Exito El Concepto Contable, Error: $sqlr </center></td></tr></table>";
		 }
		 else
		 {
		 echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha Almacenado con Exito El Concepto Contable</center></td></tr></table>";
		 }
		 //**** crear el detalle del concepto
		for($x=0;$x<count($_POST[dcuentas]);$x++) 
		 {
		  $sqlr="insert into conceptoscontables_det (codigo,tipo,tipocuenta,cuenta,cc,debito,credito,estado,modulo) values ('$_POST[numero]','$_POST[tipoc]','".$_POST[tcuentas][$x]."','".$_POST[dcuentas][$x]."','".$_POST[dccs][$x]."','".$_POST[ddebitos][$x]."','".$_POST[dcreditos][$x]."','S','3')";
		  $res=mysql_query($sqlr,$linkbd);
		  $cc=$_POST[dccs][$x];
		 }
		 $sqlr="insert into conceptoscontables_det (codigo,tipo,tipocuenta,cuenta,cc,debito,credito,estado,modulo) values ('$_POST[numero]','$_POST[tipoc]','B','','".$cc."','S','N','S','3')";
		 $res=mysql_query($sqlr,$linkbd);
	   }
	?>	

</body>
</html>