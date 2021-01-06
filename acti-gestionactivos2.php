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
	if (document.form2.consecutivo.value!='' && document.form2.placa.value!='')
  		{if (confirm("Esta Seguro de Guardar")){document.form2.oculto.value=2;document.form2.submit();}}
 	else{alert('Faltan datos para completar el registro');document.form2.fecha.focus();document.form2.fecha.select();}
}

function clasifica(formulario)
{
	//document.form2.action="presu-recursos.php";
	document.form2.submit();
}

function agregardetalle()
{
	if(document.form2.cuenta.value!=""  && document.form2.cc.value!="" )
	{document.form2.agregadet.value=1;document.form2.submit();}
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

function buscacta(e){if (document.form2.cuenta.value!=""){document.form2.bc.value='1';document.form2.submit();}}

function buscacc(e){if (document.form2.cc.value!=""){document.form2.bcc.value='1';document.form2.submit();}}

function validar2()
{
	//alert("Balance Descuadrado");
	document.form2.oculto.value=2;
	document.form2.action="presu-concecontablesconpes.php";
	document.form2.submit();
}

function validar(){document.form2.submit();}

function creaplaca()
{
	clasi=document.getElementById("clasificacion").value;	
	grup=document.getElementById("grupo").value;	
	cons=document.getElementById("consecutivo").value;	;
	document.getElementById("placa").value=clasi+''+grup+''+cons;
	//document.form2.submit();
}

function agregardetalle()
{
	if(document.form2.cuentadeb.value!=""  && document.form2.cc.value!="" )
	{document.form2.agregadet.value=1;document.form2.submit();}
	else { alert("Falta informacion para poder Agregar");}
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
			<a href="acti-gestionactivos.php" class="mgbt"><img src="imagenes/add.png"  title="Nuevo"/></a>
			<a href="#"  onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png"  title="Guardar" /></a>
			<a href="acti-buscagestionactivos.php" class="mgbt"><img src="imagenes/busca.png"  title="Buscar"/></a>
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" onClick="mypop=window.open('acti-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
		</td>
	</tr>
</table>
<?php
$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
$vigencia=$vigusu;
$linkbd=conectar_bd();
 ?>	
<?php
if(!$_POST[oculto])
{
 		 $fec=date("d/m/Y");
		 $_POST[fecha]=$fec; 	
 	 	 $_POST[vigencia]=$vigencia;		 	  			 
		 $_POST[valor]=0;		 		 
		  }
 		 $sqlr="select MAX(codigo) from acticrearact  order by codigo Desc";
		// echo $sqlr;
		  $res=mysql_query($sqlr);
		  $row=mysql_fetch_row($res);
		  $_POST[consecutivo]=$row[0]+1;
		  $_POST[consecutivo]='000'.$_POST[consecutivo];
 		  $ta=strlen($_POST[consecutivo]);
  		  $_POST[consecutivo]=substr($_POST[consecutivo],$ta-6,$ta);		  
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
        <td class="titulos" colspan="8">.: Gestion de Activos - Activar</td>
        <td  class="cerrar"><a href="acti-principal.php">Cerrar</a></td>
      </tr>
      <tr  ><td class="saludo1">Fecha:        </td>
        <td><input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">         <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>        <input type="hidden" name="chacuerdo" value="1">		  </td>
        <td  class="saludo1">Fecha Activacion:</td>
        <td ><input name="fechact" type="text" id="fc_1198971546" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fechact]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">         <a href="#" onClick="displayCalendarFor('fc_1198971546');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a> </td>
		<td  class="saludo1">Consecutivo:</td>
          <td valign="middle" >
          <input type="text" id="consecutivo" name="consecutivo" size="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[consecutivo]?>" readonly></td>
		 <td class="saludo1">Placa:</td>
          <td valign="middle" ><input name="placa" type="text" id="placa" 
		  onKeyUp="return tabular(event,this)" value="<?php echo $_POST[placa]?>" size="20" title="XX-XX-XXXXX"  readonly="readonly" ></td>         	    </tr>          
    </table>    
	<table class="inicio">
	<tr><td colspan="6" class="titulos2">Crear Detalle Activo Fijo</td></tr>
    <tr><td class="saludo1">Clasificacion</td>
    <td><select id="clasificacion" name="clasificacion" onChange="document.form2.submit()">
    <option value="">...</option>
		 <?php
		   $link=conectar_bd();
  		   $sqlr="Select * from acticlasificacion where estado='S'";
			// echo $sqlr;
		 			$resp = mysql_query($sqlr,$link);
				    while ($row =mysql_fetch_row($resp)) 
				    {
					echo "<option value=$row[0] ";
					$i=$row[0];
					 if($i==$_POST[clasificacion])
			 			{
						 echo "SELECTED";
						 $_POST[agedep]=$row[3];
						 }
					  echo ">".$row[0].' - '.$row[1]."</option>";	  
					}
  
		  ?>
    </select>
    </td>    
    <td class="saludo1">Origen</td>
    <td>
    <select id="origen" name="origen" onChange="validar()">
    <option value="">...</option>
		 <?php
		   $link=conectar_bd();
  		   $sqlr="Select * from almdestinocompra where estado='S'";
			// echo $sqlr;
		 			$resp = mysql_query($sqlr,$link);
				    while ($row =mysql_fetch_row($resp)) 
				    {
					echo "<option value='A-".$row[0]."'";
					$i="A-".$row[0];
					 if($i==$_POST[origen])
			 			{
						 echo "SELECTED";
						 }
					  echo ">A-".$row[0].' - '.$row[1]."</option>";	  
					}
			$sqlr="Select * from actiorigenes where estado='S'";
			// echo $sqlr;
		 			$resp = mysql_query($sqlr,$link);
				    while ($row =mysql_fetch_row($resp)) 
				    {
					echo "<option value='F-".$row[0]."'";
					$i="F-".$row[0];
					 if($i==$_POST[origen])
			 			{
						 echo "SELECTED";
						 }
					  echo ">F-".$row[0].' - '.$row[1]."</option>";	  
					}		
  
		  ?>
    </select>
    </td>
	</tr>
    <tr><td class="saludo1">Area</td>
    <td><select id="area" name="area" onChange="validar()">
    <option value="">...</option>
		 <?php
		   $link=conectar_bd();
  		   $sqlr="Select * from admareas,actiareasact where actiareasact.id_cc=admareas.id_cc and admareas.estado='S'";
			// echo $sqlr;
		 			$resp = mysql_query($sqlr,$link);
				    while ($row =mysql_fetch_row($resp)) 
				    {
					echo "<option value=$row[0] ";
					$i=$row[0];
					 if($i==$_POST[area])
			 			{
						 echo "SELECTED";
						 }
					  echo ">".$row[0].' - '.$row[1]."</option>";	  
					}
  
		  ?>
    </select>
    </td>   
    
     <td class="saludo1">Ubicacion</td>
    <td>
    <select name="ubicacion" onChange="validar()">
    <option value="">...</option>
		 <?php
		   $link=conectar_bd();
  		   $sqlr="Select * from actiubicacion where estado='S'";
			// echo $sqlr;
		 			$resp = mysql_query($sqlr,$link);
				    while ($row =mysql_fetch_row($resp)) 
				    {
					echo "<option value=$row[0] ";
					$i=$row[0];
					 if($i==$_POST[ubicacion])
			 			{
						 echo "SELECTED";
						 }
					  echo ">".$row[0].' - '.$row[1]."</option>";	  
					}
  
		  ?>
    </select>
    </td> 
   </tr>
    <tr>
     <td class="saludo1">Grupo</td>
    <td>
    <select id="grupo" name="grupo" onChange="document.form2.submit()">
    <option value="">...</option>
		 <?php
		   $link=conectar_bd();
  		   $sqlr="Select * from actigrupos where estado='S'";
			// echo $sqlr;
		 			$resp = mysql_query($sqlr,$link);
				    while ($row =mysql_fetch_row($resp)) 
				    {
					echo "<option value=$row[0] ";
					$i=$row[0];
					 if($i==$_POST[grupo])
			 			{
						 echo "SELECTED";
						 }
					  echo ">".$row[0].' - '.$row[1]."</option>";	  
					}
		  ?>
    </select>
    </td>
   <td class="saludo1">CC:</td><td >
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
	 </td>
	</tr>
	</table>
    <script>
	creaplaca()
	</script>
    <table class="inicio">
	<tr><td colspan="8" class="titulos2">Informacion Activo Fijo</td></tr>
    <tr><td class="saludo1">Nombre:</td><td><input type="text" name="nombre" onKeyUp="return tabular(event,this)" size="100"></td><td class="saludo1">Ref:</td><td><input type="text" name="referencia" onKeyUp="return tabular(event,this)"></td><td class="saludo1">Modelo:</td><td><input type="text" name="modelo" onKeyUp="return tabular(event,this)"></td></tr><tr><td class="saludo1">Serial:</td><td><input type="text" name="serial" onKeyUp="return tabular(event,this)"></td><td class="saludo1">Unidad Medida:</td><td><select name="unimed">
		   <option value="" >Seleccione...</option>
           <option value="1" <?php if($_POST[unimed]=='1') echo "SELECTED"; ?>>Unidad</option>
    	   <option value="2" <?php if($_POST[unimed]=='2') echo "SELECTED"; ?>>Juego</option>
		  </select></td><td class="saludo1">Valor:</td><td><input type="text" name="valor"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="puntitos(this,this.value.charAt(this.value.length-1))" value='<?php echo $_POST[valor]?>'> <input type="hidden" value="1" name="oculto"></td></tr>
          <tr><td class="saludo1">Fecha Compra: </td>
        <td ><input name="fechac" type="text" value="<?php echo $_POST[fechac]?>" maxlength="10" size="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971547" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY">   <a href="#" onClick="displayCalendarFor('fc_1198971547');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a></td><td  class="saludo1">A&ntilde;os Depreciacion:</td>
          <td valign="middle" >
          <input type="text" id="agedep" name="agedep" size="5"  value="<?php echo $_POST[agedep]?>" readonly></td>
          <td class="saludo1">Estado:</td><td><select name="estadoact">
		   <option value="" >Seleccione...</option>
           <option value="bueno" <?php if($_POST[estadoact]=='bueno') echo "SELECTED"; ?>>Bueno</option>
    	   <option value="regular" <?php if($_POST[estadoact]=='regular') echo "SELECTED"; ?>>Regular</option>
           <option value="malo" <?php if($_POST[estadoact]=='malo') echo "SELECTED"; ?>>Malo</option>
		  </select></td>
          <tr>
          <tr><td class="saludo1">Foto:</td><td><input type="file" name="archivofoto" id="archivofoto" ></td></tr>
    </table>    
</form>
	<?php 
	//********** GUARDAR EL COMPROBANTE ***********
	if($_POST[oculto]=='2')	
		{
		?>
		<script>
		creaplaca()
		</script>
    <?php
		//rutina de guardado cabecera
		$linkbd=conectar_bd();
		$sqlr="select *from configbasica where estado='S'";
//echo $sqlr;
		$res=mysql_query($sqlr,$linkbd);
		while($row=mysql_fetch_row($res))
		 {
		  $nit=$row[0];
		  $rs=$row[1];
		 }
		
		$_POST[valor]=str_replace(".","",$_POST[valor]);
		ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
		$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
		ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechact],$fecha);
		$fechafact=$fecha[3]."-".$fecha[2]."-".$fecha[1];
		$nmesesdep=$_POST[agedep]*12;
		$vmendep=$_POST[valor]/$nmesesdep;
		$sqlr="insert into acticrearact (`codigo`, `placa`, nombre, `referencia`, `modelo`, `serial`, unidadmed, `fechareg`, `fechact`, `clasificacion`, `origen`, `area`, `ubicacion`, `grupo`, `cc`, `valor`, nummesesdep, mesesdepacum, saldomesesdep,`valdepact`, `saldodepact`, `valdepmen`, estadoactivo,foto,`estado`,fechaultdep) values ('$_POST[consecutivo]','$_POST[placa]', '$_POST[nombre]', '$_POST[referencia]','$_POST[modelo]','$_POST[serial]', '$_POST[unimed]','$fechaf', '$fechafact','$_POST[clasificacion]','$_POST[origen]','$_POST[area]','$_POST[ubicacion]','$_POST[grupo]','$_POST[cc]',$_POST[valor],$nmesesdep,0,$nmesesdep,0,$_POST[valor],$vmendep,'$_POST[estadoact]','$_POST[foto]','S','')";
		//echo $sqlr;
		if(!mysql_query($sqlr,$linkbd))
		 {
		  echo "<table class='inicio'><tr><td class='saludo1'><center>No Se ha Almacenado el Nuevo Activo, <img src='imagenes\alert.png'> Error:".mysql_error()."</center></td></tr></table>";
		 }
		 else
		 {
		  echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha Almacenado con Exito el Nuevo Activo <img src='imagenes\confirm.png'></center></td></tr></table>";						          $consec=0;

		  $sqlr="Select max(numerotipo) from comprobante_cab where tipo_comp=23  ";
		  $res=mysql_query($sqlr,$linkbd);
		  while($r=mysql_fetch_row($res))
		 {
		  $consec=$r[0];	  
		 }
		 $consec+=1;
		  $sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($consec ,23,'$fechaf','CREACION ACTIVO FIJO $_POST[placa]',0,$_POST[valor],$_POST[valor],0,'1')";
		 mysql_query($sqlr,$linkbd);
		 if(!mysql_query($sqlr,$linkbd))
		  {
			echo "<table class='inicio'><tr><td class='saludo1'><center>No se ha creado el comprobante contable, <img src='imagenes\alert.png'> Error:".mysql_error()."</center></td></tr></table>";
		  }
		  else
		  {
			//**** detalle del comp contable
			$torigen=substr($_POST[origen],0,1);
			$origen=substr($_POST[origen],2);
			if($torigen=='A')
			 {
			   $sqlr="Select * from almdestinocompra_det where codigo='$origen' AND CC='$_POST[cc]'";
		 	   $resp = mysql_query($sqlr,$link);
			   while ($row =mysql_fetch_row($resp)) 
			    {
				$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('23 $consec','".$row[3]."','".$nit."','".$_POST[cc]."','Cta Destino compra ".$origen."','',0,".$_POST[valor].",'1','".$vigusu."')";
		//	echo "$sqlr <br>";
				mysql_query($sqlr,$linkbd);  
				}
			 }
			if($torigen=='F')
			 {
			$sqlr="Select * from actiorigenes_det where  codigo='$origen' AND CC='$_POST[cc]'";
			// echo $sqlr;
		 			$resp = mysql_query($sqlr,$link);
				    while ($row =mysql_fetch_row($resp)) 
				    {
					$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('23 $consec','".$row[3]."','".$nit."','".$_POST[cc]."','Cta Origen ".$origen."','',0,".$_POST[valor].",'1','".$vigusu."')";
		//	echo "$sqlr <br>";
					mysql_query($sqlr,$linkbd);  				
					}							
			 }		
			 //****cuenta credito detalle
			   		   $sqlr="Select * from acticlasificacion_DET where codigo='$_POST[clasificacion]' AND CC='$_POST[cc]'";
			// echo $sqlr;
		 			$resp = mysql_query($sqlr,$link);
				    while ($row =mysql_fetch_row($resp)) 
				    {
					$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('23 $consec','".$row[4]."','".$nit."','".$_POST[cc]."','Cta Clasificacion Activo ".$_POST[clasificacion]."','',".$_POST[valor].",0,'1','".$vigusu."')";
		//	echo "$sqlr <br>";
					mysql_query($sqlr,$linkbd);  				
					}

			 //*********	 
		  }
		 }
	   }
	?>	
</td></tr>     
</table>
</body>
</html>