<!--V 1.0 24/02/2015-->
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
		<title>:: Spid - Activos Fijos</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/calendario.js"></script>
        <script type="text/javascript" src="css/programas.js"></script>
<script>
function guardar()
{
	if (document.form2.numero.value!='' && document.form2.nombre.value!='')
  		{if (confirm("Esta Seguro de Guardar")){document.form2.oculto.value=2;document.form2.submit();}}
	 else
 		{alert('Faltan datos para completar el registro');document.form2.numero.focus();document.form2.numero.select();}
 }

function clasifica(formulario)
{
	//document.form2.action="presu-recursos.php";
	document.form2.submit();
}

function agregardetalle()
{
	if( document.form2.cc.value!="" ){document.form2.agregadet.value=1;document.form2.submit();}
	else {alert("Falta informacion para poder Agregar");}
}

function eliminar(variable)
{
	if (confirm("Esta Seguro de Eliminar"))
	{
		document.form2.elimina.value=variable;
		//eli=document.getElementById(elimina);
		vvend=document.getElementById('elimina');
		//eli.value=elimina;
		vvend.value=variable;
		document.form2.submit();
	}
}

function buscacta(objeto)
{
	if(objeto=='1'){if (document.form2.cuentadeb.value!=""){document.form2.bcd.value='1';document.form2.submit();}}
	if(objeto=='2'){if (document.form2.cuentacred.value!=""){document.form2.bccr.value='1';document.form2.submit();}}
	if(objeto=='3'){if (document.form2.cuentact.value!=""){document.form2.bca.value='1';document.form2.submit();}}
	if(objeto=='4'){if (document.form2.cuentaper.value!=""){document.form2.bcp.value='1';document.form2.submit();}}
}

function buscacc(e){if (document.form2.cc.value!=""){document.form2.bcc.value='1';document.form2.submit();}}

function deprec()
 {
	var campo = document.getElementById('agedep');
 	if (document.form2.deprecia.checked==true){campo.readOnly=true;}
 	else{campo.readOnly=false;document.form2.agedep.value=0;}
 }

function validar2()
{
	//alert("Balance Descuadrado");
	document.form2.oculto.value=2;
	document.form2.action="presu-concecontablesconpes.php";
	document.form2.submit();
}

function validar(){document.form2.submit();}

function agregardetalle()
{
	if( document.form2.cc.value!="" ){document.form2.agregadet.value=1;document.form2.submit();}
 	else {alert("Falta informacion para poder Agregar");}
}
</script>

<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
	<tr><script>barra_imagenes("acti");</script><?php cuadro_titulos();?></tr>
	<tr><?php menu_desplegable("acti");?></tr>
	<tr>
		<td colspan="3" class="cinta">
			<a href="acti-clasificacion.php" class="mgbt"><img src="imagenes/add.png"  title="Nuevo"/></a>
			<a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a>
			<a href="acti-buscaclasificacion.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a>
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" onClick="mypop=window.open('acti-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
		</td>
	</tr>
</table>
<?php
$vigencia=date(Y);
$linkbd=conectar_bd();
 ?>	
<?php
//echo "oc:".$_POST[oculto];
if($_POST[oculto]=='')
{
 		 $fec=date("d/m/Y");
		 $_POST[fecha]=$fec; 	
 	 	 $_POST[vigencia]=$vigencia;
		 $_POST[agedep]=0;
		 $_POST[valorreduccion]=0;
		 $_POST[valortraslados]=0;		 		  			 
		 $_POST[valor]=0;		 
		  $sqlr="select MAX(codigo) from acticlasificacion  order by codigo Desc";
		// echo $sqlr;
		  $res=mysql_query($sqlr);
		  $row=mysql_fetch_row($res);
		  $_POST[numero]=$row[0]+1;
		  if(strlen($_POST[numero])==1)
		   {
			   $_POST[numero]='0'.$_POST[numero];
			}
}
?>
 <form name="form2" method="post" action=""> 
<?php //**** busca cuenta
  			if($_POST[bcd]=='1')
			 {
			  $nresul=buscacuenta($_POST[cuentadeb]);
			  if($nresul!='')
			   {
			  $_POST[ncuentadeb]=$nresul;
  	
			  }
			 else
			 {
			  $_POST[ncuenta]="";
			  }
			 }
			 if($_POST[bccr]=='1')
			 {
			  $nresul=buscacuenta($_POST[cuentacred]);
			  if($nresul!='')
			   {
			  $_POST[ncuentacred]=$nresul;
  	
			  }
			 else
			 {
			  $_POST[ncuenta]="";
			  }
			 }
			 if($_POST[bca]=='1')
			 {
			  $nresul=buscacuenta($_POST[cuentact]);
			  if($nresul!='')
			   {
			  $_POST[ncuentact]=$nresul;
  	
			  }
			 else
			 {
			  $_POST[ncuenta]="";
			  }
			 }
			 if($_POST[bcp]=='1')
			 {
			  $nresul=buscacuenta($_POST[cuentaper]);
			  if($nresul!='')
			   {
			  $_POST[ncuentaper]=$nresul;
  	
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
      	<tr>
        	<td class="titulos" colspan="9" style='width:90%'>.: Clasificacion</td>
        	<td  class="cerrar" style='width:10%'><a href="acti-principal.php">&nbsp;&nbsp;Cerrar</a></td>
      	</tr>
      	<tr>
			<td class="saludo1" style='width:10%'>Codigo:</td>
          	<td  style='width:10%'><input type="text" id="numero" name="numero" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[numero]?>" onClick="document.getElementById('numero').focus();document.getElementById('numero').select();" style='width:80%'></td>
		 	<td class="saludo1" style='width:10%'>Nombre:</td>
          	<td style='width:36%'><input type="text" id="nombre" name="nombre" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[nombre]?>" onClick="document.getElementById('acuerdo').focus();document.getElementById('acuerdo').select();" style='width:95%'></td>
          	<td class="saludo1" style='width:10%'>No Deprecia:</td>
            <td style='width:4%'><input id="deprecia" name="deprecia" type="checkbox" value="S" <?php echo $chk; ?> onClick="deprec()"></td>
			<td class="saludo1" style='width:10%'>A&ntilde;os Depreciacion:</td>
	  		<td colspan="2" style='width:5%'><input type="text" id="agedep" name="agedep" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[agedep]?>" onClick="document.getElementById('agedep').focus();document.getElementById('agedep').select();" style='width:80%'></td>          
		</tr>
    </table>
	<table class="inicio">
		<tr><td colspan="6" class="titulos2">Crear Detalle Clasificacion</td></tr>	
		<tr>
        	<td class="saludo1" style='width:10%'>Cuenta Depreciacion Deb:</td>
			<td style='width:10%'><input type="text" id="cuentadeb" name="cuentadeb" onKeyPress="javascript:return solonumeros(event)" 
              onKeyUp="return tabular(event,this)" onBlur="buscacta('1')" value="<?php echo $_POST[cuentadeb]?>" onClick="document.getElementById('cuentadeb').focus();document.getElementById('cuentadeb').select();" style='width:80%'><input type="hidden" value="0" name="bcd"><a href="#" onClick="mypop=window.open('cuentasgral-ventana.php?objeto=cuentadeb&nobjeto=ncuentadeb','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();">&nbsp;<img src="imagenes/buscarep.png" style='width:16px'></a>  </td>
      		<td style='width:30%'><input id="ncuentadeb" name="ncuentadeb" type="text" value="<?php echo $_POST[ncuentadeb]?>" style='width:100%' readonly></td>
         	<td class="saludo1" style='width:10%'>Cuenta Depreciacion Cred:</td>
          	<td style='width:10%'><input type="text" id="cuentacred" name="cuentacred"  onKeyPress="javascript:return solonumeros(event)" 
		  onKeyUp="return tabular(event,this)" onBlur="buscacta('2')" value="<?php echo $_POST[cuentacred]?>" onClick="document.getElementById('cuentacred').focus();document.getElementById('cuentacred').select();" style='width:80%'><input type="hidden" value="0" name="bccr"><a href="#" onClick="mypop=window.open('cuentasgral-ventana.php?objeto=cuentacred&nobjeto=ncuentacred','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();">&nbsp;<img src="imagenes/buscarep.png" style='width:16px'></a>  </td>
          <td style='width:30%'><input id="ncuentacred" name="ncuentacred" type="text" value="<?php echo $_POST[ncuentacred]?>" style='width:100%' readonly></td> 
		</tr>
		<tr>        
        	<td class="saludo1">Cuenta Activos:</td>
           	<td><input type="text" id="cuentact" name="cuentact"  onKeyPress="javascript:return solonumeros(event)" 
              onKeyUp="return tabular(event,this)" onBlur="buscacta('3')" value="<?php echo $_POST[cuentact]?>" onClick="document.getElementById('cuentact').focus();document.getElementById('cuentact').select();" style='width:80%'><input type="hidden" value="0" name="bca"><a href="#" onClick="mypop=window.open('cuentasgral-ventana.php?objeto=cuentact&nobjeto=ncuentact','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();">&nbsp;<img src="imagenes/buscarep.png" style='width:16px'></a></td>
              <td><input name="ncuentact" type="text" id="ncuentact" value="<?php echo $_POST[ncuentact]?>" style='width:100%' readonly></td>
	<td class="saludo1">Cuenta Perdida:</td>
              <td><input type="text" id="cuentaper" name="cuentaper"  onKeyPress="javascript:return solonumeros(event)" 
              onKeyUp="return tabular(event,this)" onBlur="buscacta('4')" value="<?php echo $_POST[cuentaper]?>" onClick="document.getElementById('cuentaper').focus();document.getElementById('cuentaper').select();" style='width:80%'><input type="hidden" value="0" name="bcp"><a href="#" onClick="mypop=window.open('cuentasgral-ventana.php?objeto=cuentaper&nobjeto=ncuentaper','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();">&nbsp;<img src="imagenes/buscarep.png" style='width:16px'></a></td>
              <td ><input id="ncuentaper" name="ncuentaper" type="text" value="<?php echo $_POST[ncuentaper]?>" style='width:100%' readonly></td>
		</tr>
		<tr>
	 
    <td class="saludo1">CC:</td><td colspan="2">
	<select name="cc"   onKeyUp="return tabular(event,this)">
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
	 </td><td><input type="button" name="agrega" value="  Agregar  " onClick="agregardetalle()" ><input type="hidden" value="0" name="agregadet"> <input type="hidden"  name="oculto" value="0">	</td>
        </tr>
		  <?php
		if (!$_POST[oculto])
		 {
		 ?>
		<script>
    	//document.form2.cc.focus();
		</script>	
		<?php
		}
		
		if($_POST[bcd]=='1')
			 {
			  $nresul=buscacuenta($_POST[cuentadeb]);
			  if($nresul!='')
			   {
			  $_POST[ncuentadeb]=$nresul;
  			  ?>
			  <script>
			  document.getElementById('cuentacred').focus();</script>
			  <?php
			  }
			 else
			 {
			  $_POST[ncuentadeb]="";
			  ?>
			  <script>alert("Cuenta Incorrecta Debito");document.form2.cuentadeb.focus();</script>
			  <?php
			  }
			 }
			 	if($_POST[bccr]=='1')
			 {
			  $nresul=buscacuenta($_POST[cuentacred]);
			  if($nresul!='')
			   {
			  $_POST[ncuentacred]=$nresul;
  			  ?>
			  <script>
			  document.getElementById('cuentact').focus();</script>
			  <?php
			  }
			 else
			 {
			  $_POST[ncuentacred]="";
			  ?>
			  <script>alert("Cuenta Incorrecta Credito");document.form2.cuentacred.focus();</script>
			  <?php
			  }
			 }
			 	if($_POST[bca]=='1')
			 {
			  $nresul=buscacuenta($_POST[cuentact]);
			  if($nresul!='')
			   {
			  $_POST[ncuentact]=$nresul;
  			  ?>
			  <script>
			  document.getElementById('cuentaper').focus();</script>
			  <?php
			  }
			 else
			 {
			  $_POST[ncuentact]="";
			  ?>
			  <script>alert("Cuenta Incorrecta Activo");document.form2.cuentact.focus();</script>
			  <?php
			  }
			 }
			 	if($_POST[bcp]=='1')
			 {
			  $nresul=buscacuenta($_POST[cuentaper]);
			  if($nresul!='')
			   {
			  $_POST[ncuentaper]=$nresul;
  			  ?>
			  <script>
			  document.getElementById('cc').focus();</script>
			  <?php
			  }
			 else
			 {
			  $_POST[ncuentaper]="";
			  ?>
			  <script>alert("Cuenta Incorrecta Perdida");document.form2.cuentaper.focus();</script>
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
		 		  
	</table>
	<div class="subpantallac" style="height:49.5%; width:99.6%;">
	<table class="inicio">
	<tr><td class="titulos" colspan="10">Detalle Clasificacion</td></tr>
	<tr><td class="titulos2">CC</td><td class="titulos2">Cuenta Depre Deb</td><td class="titulos2">Nombre Cuenta</td><td class="titulos2">Cuenta Depre Cred</td><td class="titulos2">Nombre Cuenta</td><td class="titulos2">Cuenta Activa</td><td class="titulos2">Nombre Cuenta</td><td class="titulos2">Cuenta Perdida</td><td class="titulos2">Nombre Cuenta</td><td class="titulos2"><img src="imagenes/del.png" ><input type='hidden' name='elimina' id='elimina'></td></tr>
	<?php	
	//echo "<br>posic:".$_POST[elimina];		 
	if ($_POST[elimina]!='')
		 { 		 
		 $posi=$_POST[elimina];
		// echo "<br>posic:".$_POST[elimina];
		 unset($_POST[dcuentasdeb][$posi]);
 		 unset($_POST[dncuentasdeb][$posi]);
		 unset($_POST[dcuentascred][$posi]);
 		 unset($_POST[dncuentascred][$posi]);
		  unset($_POST[dcuentasper][$posi]);
 		 unset($_POST[dncuentasper][$posi]);
		  unset($_POST[dcuentasact][$posi]);
 		 unset($_POST[dncuentasact][$posi]);		 
		 unset($_POST[dccs][$posi]);		 	 
		 $_POST[dcuentasdeb]= array_values($_POST[dcuentasdeb]); 
		 $_POST[dncuentasdeb]= array_values($_POST[dncuentasdeb]); 	
		 $_POST[dcuentascred]= array_values($_POST[dcuentascred]); 
		 $_POST[dncuentascred]= array_values($_POST[dncuentascred]); 	
		 $_POST[dcuentasper]= array_values($_POST[dcuentasper]); 
		 $_POST[dncuentasper]= array_values($_POST[dncuentasper]); 	
		 $_POST[dcuentasact]= array_values($_POST[dcuentasact]); 
		 $_POST[dncuentasact]= array_values($_POST[dncuentasact]); 	
			 	 		 
		 $_POST[dccs]= array_values($_POST[dccs]); 
		 }
	
	if ($_POST[agregadet]=='1')
		 {
		  $cuentacred=0;
		  $cuentadeb=0;
		  $diferencia=0;
		 $_POST[dcuentasdeb][]=$_POST[cuentadeb];
		 $_POST[dncuentasdeb][]=$_POST[ncuentadeb];
		 $_POST[dcuentascred][]=$_POST[cuentacred];
		 $_POST[dncuentascred][]=$_POST[ncuentacred];		 
		 $_POST[dcuentasact][]=$_POST[cuentact];
		 $_POST[dncuentasact][]=$_POST[ncuentact];		 
		 $_POST[dcuentasper][]=$_POST[cuentaper];
		 $_POST[dncuentasper][]=$_POST[ncuentaper];	 
		 $_POST[dccs][]=$_POST[cc];		 		 
		 $_POST[agregadet]=0;
		 
		  ?>
		 <script>
		  		//document.form2.cuenta.focus();	
				document.form2.cc.select();
				document.form2.cc.value="";
		 </script>
		 <?php
		 }
		 $iter='zebra1';
		 $iter2='zebra2';
		 for ($x=0;$x< count($_POST[dcuentasdeb]);$x++)
		 {echo "<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\" >
		 <td><input name='dccs[]' value='".$_POST[dccs][$x]."' type='text' size='1' class='inpnovisibles' readonly></td>
		 <td><input name='dcuentasdeb[]' value='".$_POST[dcuentasdeb][$x]."' type='text' size='6' class='inpnovisibles' readonly></td>
		 <td><input name='dncuentasdeb[]' value='".$_POST[dncuentasdeb][$x]."' type='text' size='50' class='inpnovisibles' readonly></td>
		 <td><input name='dcuentascred[]' value='".$_POST[dcuentascred][$x]."' type='text' size='6' class='inpnovisibles' readonly></td>
		 <td><input name='dncuentascred[]' value='".$_POST[dncuentascred][$x]."' type='text' size='50' class='inpnovisibles' readonly></td>
		 <td><input name='dcuentasact[]' value='".$_POST[dcuentasact][$x]."' type='text' size='6' class='inpnovisibles' readonly></td>
		 <td><input name='dncuentasact[]' value='".$_POST[dncuentasact][$x]."' type='text' size='50' class='inpnovisibles' readonly></td>
		 <td><input name='dcuentasper[]' value='".$_POST[dcuentasper][$x]."' type='text' size='6' class='inpnovisibles' readonly></td>
		 <td><input name='dncuentasper[]' value='".$_POST[dncuentasper][$x]."' type='text' size='50' class='inpnovisibles' readonly></td>
		 <td style='text-align:center;'><a href='#' onclick='eliminar($x)'><img src='imagenes/del.png'></a></td></tr>";
		 $aux=$iter;
		 $iter=$iter2;
		 $iter2=$aux;
		 }	 
		 ?>
	</table>
	</div>
</form>
	<?php 
	//********** GUARDAR EL COMPROBANTE ***********
	if($_POST[oculto]=='2')	
		{
		//rutina de guardado cabecera
		$linkbd=conectar_bd();
		ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
		$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
		$sqlr="insert into acticlasificacion (codigo,nombre,deprecia,agedep,estado) values ('$_POST[numero]','$_POST[nombre]', '$_POST[deprecia]',  '$_POST[agedep]','S')";
		if(!mysql_query($sqlr,$linkbd))
		 {
		  echo "<table class='inicio'><tr><td class='saludo1'><center>No Se ha Almacenado la Clasificacion, Error:".mysql_error()."</center></td></tr></table>";
		 }
		 else
		 {
		  echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha Almacenado con Exito La Clasificacion</center></td></tr></table>";
		  for($x=0;$x<count($_POST[dccs]);$x++) 
		 {
		 $sqlr="insert into acticlasificacion_det(codigo,depredeb,deprecred,activa, perdida,cc,estado) values ('$_POST[numero]', '".$_POST[dcuentasdeb][$x]."','".$_POST[dcuentascred][$x]."', '".$_POST[dcuentasact][$x]."', '".$_POST[dcuentasper][$x]."','".$_POST[dccs][$x]."','S')";
		  $res=mysql_query($sqlr,$linkbd);
		 }
		 }
	   }
	?>	
</td></tr>     
</table>
</body>
</html>