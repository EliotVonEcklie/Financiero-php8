<?php //V 1001 20/12/16 Modificado implementacion de Reversion?> 
<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	require"validaciones.inc";
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
		<title>:: SPID - Presupuesto</title>
         <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
		<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
        <script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
		<script src="JQuery/jquery-2.1.4.min.js"></script>
		<style>
			.message{
				font-family: 'Open Sans', sans-serif;
				font-size: 12px;
				font-weight: bold;
				font-color: black;
				background-color:white;
			}
		</style>
<script>
function finaliza()
 {
  if (document.form2.valorac2.value==document.form2.cuentacreditos2.value && document.form2.valorac2.value==document.form2.cuentacontras2.value)
  {
   if (confirm("Confirme Guardando el Documento, al completar el Proceso"))
   {
	  document.form2.fin.checked=true; 
   } 
   else
   document.form2.fin.checked=false; 
  }
  else 
  {
   alert("El Total del Acto Administrativo no es igual al de Creditos y/o Contracreditos");
    document.form2.fin.checked=false; 
  }
 }
 
 function protocoloimport()
	{
		document.form2.action="presu-traslados-import.php";
		document.form2.target="_BLANK";
		document.form2.submit(); 
		document.form2.action="";
		document.form2.target="";
	}
 function redireccionar1(){
			
			valorSeleccionado=document.form2.tipomovimiento.value;
			switch(valorSeleccionado){
				case '201': 
				document.location='presu-traslados.php?tipo=201';
				break;
				
				case '401': 
				document.location='presu-trasladosreversar.php?tipo=401';
				break;
				
			}
		}
 
 function despliegamodalm(_valor,_tip,mensa,pregunta)
	{
		document.getElementById("bgventanamodalm").style.visibility=_valor;
		if(_valor=="hidden") {document.getElementById('ventanam').src="";}
		else
		{
			switch(_tip)
			{
				case "1":
					document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
				case "2":
					document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
				case "3":
					document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
				case "4":
					document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;	
			}
		}
	}
	function respuestaconsulta(pregunta)
	{
		switch(pregunta)
		{
			case "1":	
				document.form2.oculto.value=2;
				document.form2.submit();
			break;
		}
	}

	function funcionmensaje()
	{
	}
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
var fechabloqueo=document.form2.fechabloq.value;
var fechadocumento=document.form2.fecha.value;
var nuevaFecha=fechadocumento.split("/");
var fechaCompara=nuevaFecha[2]+"-"+nuevaFecha[1]+"-"+nuevaFecha[0];
var restric=document.form2.restric.value;
//if(restric!=1){
	if((Date.parse(fechabloqueo)) > (Date.parse(fechaCompara))){
	despliegamodalm('visible','2','Fecha de documento menor que fecha de bloqueo');
}else{
	var vigencia="<?php echo vigencia_usuarios($_SESSION[cedulausu]) ?>";
	if(vigencia==nuevaFecha[2]){
	if (document.form2.vigencia.value!='' && document.form2.fecha.value!='' && document.form2.acuerdo.value!='-1' && document.form2.acuerdo.value!='')
  {
	// if (confirm("Esta Seguro de Guardar"))
  	// {
  	// document.form2.oculto.value=2;
  	// document.form2.submit();
  	// }
	despliegamodalm('visible','4','Esta Seguro de Guardar','1');
  }
  else{
  // alert('Faltan datos para completar el registro');
  	// document.form2.fecha.focus();
  	// document.form2.fecha.select();
	despliegamodalm('visible','2','Faltan datos para completar el registro');
  }	
	}else{
		despliegamodalm('visible','2','La fecha del documento debe coincidir con su vigencia');
	}
	
	
}


}
function validar(formulario)
{
document.form2.action="presu-traslados.php";
document.form2.submit();
}
function validar2(formulario)
{
document.form2.chacuerdo.value=2;
document.form2.action="presu-traslados.php";
document.form2.submit();
}
function validarimport(formulario)
{
	document.form2.import.value=1;
	document.form2.action="presu-traslados.php";
	document.form2.submit();
}
function buscacta(e)
 {
if (document.form2.cuenta.value!="")
{
 document.form2.bc.value=2;
 document.form2.submit();
 }
 }
function buscacta2(e)
 {
if (document.form2.cuenta2.value!="")
{
 document.form2.bc2.value=2;
 document.form2.submit();
 }
 }
function agregardetalle()
{
	vc=document.form2.valorac2.value;
	if(document.form2.cuenta.value!="" && document.form2.tipocta.value!="" &&  document.form2.valor.value>0 )
	{ 
		tipoc=document.form2.tipocta.value;
		switch (tipoc)
		{
			case '1':
				suma=parseFloat(document.form2.valor.value)+parseFloat(document.form2.cuentacreditos2.value);
				saldo=parseFloat(document.form2.valor2.value);
				valor=parseFloat(document.form2.valor.value);
				if(suma<=vc)
				{
					tipocta=parseFloat(document.form2.tipocta.value);
					if(tipocta==2){
						if(valor<=saldo){
							document.form2.agregadet.value=1;
			//				document.form2.chacuerdo.value=2;
							document.form2.submit();
						}
						else{
							alert("El Valor supera el Saldo de la Cuenta: "+valor);
						}
					}else{
						document.form2.agregadet.value=1;
		//				document.form2.chacuerdo.value=2;
						document.form2.submit();
					}	
				}
				else
	 			{
					alert("El Valor supera el Acto Administrativo: "+suma);
				}
			break;
			case '2':
				suma=parseFloat(document.form2.valor.value)+parseFloat(document.form2.cuentacontras2.value);
				saldo=parseFloat(document.form2.valor2.value);
				valor=parseFloat(document.form2.valor.value);
				if(suma<=vc)
				{
					tipocta=parseFloat(document.form2.tipocta.value);
					if(tipocta==2){
						if(valor<=saldo){
							document.form2.agregadet.value=1;
			//				document.form2.chacuerdo.value=2;
							document.form2.submit();
						}
						else{
							alert("El Valor supera el Saldo de la Cuenta: "+valor);
						}
					}else{
						document.form2.agregadet.value=1;
		//				document.form2.chacuerdo.value=2;
						document.form2.submit();
					}	
				}
				else
	 			{
					alert("El Valor supera el Acto Administrativo: "+suma);
				}
			break;
		}
	}
	else 
	{
		alert("Falta informacion para poder Agregar ");
	}
}
function eliminar(variable)
{
if (confirm("Esta Seguro de Eliminar"))
  {
//  document.form2.chacuerdo.value=2;
document.form2.elimina.value=variable;
//eli=document.getElementById(elimina);
vvend=document.getElementById('elimina');
//eli.value=elimina;
vvend.value=variable;
document.form2.submit();
}
}
function capturaTecla(e){ 
var tcl = (document.all)?e.keyCode:e.which;
if (tcl==115){
alert(tcl);
return tabular(e,elemento);
}
}
</script>
		<?php titlepag();?>
    </head>
    <body >
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("presu");?></tr>
       	 	<tr>
          		<td colspan="3" class="cinta">
					<img src="imagenes/add.png" title="Nuevo" onClick="location.href='presu-traslados.php'" class="mgbt"/><img src="imagenes/guarda.png" title="Guardar" href="#" onClick="guardar()" class="mgbt"/><img src="imagenes/busca.png" title="Buscar" onClick="location.href='presu-buscartraslados.php'" class="mgbt"/><img src="imagenes/agenda1.png" title="Agenda" onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"/>
				</td>
        	</tr>
        </table>
<?php
//$vigencia=date(Y);

$vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
$vigencia=$vigusu;
$linkbd=conectar_bd();
 ?>	
<?php
if($_POST[oculto]=='')
{
		 $_POST[tipomovimiento]=$_GET[tipo];
 		 $fec=date("d/m/Y");
		 $_POST[vigencia]=vigencia_usuarios($_SESSION[cedulausu]); 
		 $_POST[fecha]=$fec; 	
		 $_POST[valor]=0; 			 
		 $_POST[cuentacred]=0;
		 $_POST[cuentacontras]=0;
 		 $_POST[cuentacreditos2]=0;
		 $_POST[cuentacontras2]=0;
		 $_POST[dcuentas]=array();
 		 $_POST[dncuentas]=array();
		 $_POST[dcontras]=array();		 		 		 		 		 
		 $_POST[dcreditos]=array();	
}

?>
 <?php
			//**** busca cuenta
			if($_POST[bc]!='')
			 {
			  $nresul=buscacuentapres($_POST[cuenta],2);			
			  if($nresul!='')
			   {
					$_POST[ncuenta]=$nresul;
					$sqlr="select *from pptocuentas where cuenta='$_POST[cuenta]' and (vigencia=".$vigusu." or   vigenciaf=$vigusu)";
			  		$res=mysql_query($sqlr,$linkbd);
			  		$row=mysql_fetch_row($res);
					$vigenciai=$row[25];
					$_POST[ncuenta]=$nresul;
					$vsal=generaSaldo($_POST[cuenta],$vigenciai,$vigusu); 			  
					$_POST[valor]=0;		  
					$_POST[valor2]=$vsal;	
			   }
			  else
			  {
			   $_POST[ncuenta]="";	
			   }
			 }
			 //*** contra credito
			 
		if ($_POST[chacuerdo]=='2')
					 {
				    $_POST[dcuentas]=array();
				    $_POST[dncuetas]=array();
				    $_POST[dingresos]=array();
				    $_POST[dgastos]=array();
					$_POST[diferencia]=0;
					$_POST[cuentacontras]=0;
					$_POST[cuentacred]=0;			
					/*$_POST[dcuentas]=array();
 					$_POST[dncuentas]=array();
					$_POST[dcontras]=array();		 		 		 		 		 
					$_POST[dcreditos]=array();	*/
					 }	 
		?>
<div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
 <form name="form2" method="post" action="" enctype="multipart/form-data">
 <?php
	$sesion=$_SESSION[cedulausu];
	$sqlr="Select dominios.valor_final from usuarios,dominios where usuarios.cc_usu=$sesion and dominios.NOMBRE_DOMINIO='PERMISO_MODIFICA_DOC' and dominios.valor_inicial=usuarios.cc_usu ";
	$resp = mysql_query($sqlr,$linkbd);
	$fechaBloqueo=mysql_fetch_row($resp);
	echo "<input type='hidden' name='fechabloq' id='fechabloq' value='$fechaBloqueo[0]' />";
?>
 <table class="inicio">
				<tr>
					<td class="titulos" colspan="8">.: Tipo de Movimiento Disponibilidad Presupuestal </td>
				</tr>
				<tr>
					<td>
						<select name="tipomovimiento" id="tipomovimiento"  onChange="redireccionar1()" >
							<?php 
								$sqlr="select * from tipo_movdocumentos where estado='S' and modulo=4";
								$resp = mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($resp)) 
								{
									if($_POST[tipomovimiento]==$row[0].$row[1]){
										echo "<option value='$row[0]$row[1]' SELECTED >$row[0]$row[1]-$row[2]</option>";
									}else{
										echo "<option value='$row[0]$row[1]'>$row[0]$row[1]-$row[2]</option>";
									}
								}
							?>
						</select>
					</td>
				</tr>
			</table>
    <table class="inicio" align="center" width="80%" >
      	<tr >
        	<td class="titulos" style="width:95%;" colspan="2">.: Traslados Presupuestal</td>
        	<td class="cerrar" style="width:5%;"><a href="presu-principal.php">Cerrar</a></td>
      	</tr>
      	<tr>
      		<td style="width:75%;">
      			<table>
      				<tr  >
				  		<td style="width:10%;" class="saludo1">Fecha:</td>
			        	<td style="width:15%;">
			        		<input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">   
			        		<a href="#" onClick="displayCalendarFor('fc_1198971545');">
			        			<img src="imagenes/buscarep.png" align="absmiddle" border="0">
			        		</a>        
			        	</td>
					 	<td style="width:10%;" class="saludo1">Acto Administrativo:</td>
			          	<td style="width:20%;" valign="middle" >
					  		<select name="acuerdo" style="width:100%;" onChange="validar2()" onKeyUp="return tabular(event,this)">
								<option value="-1">...</option>
					 				<?php
					   					$link=conectar_bd();
			  		   					$sqlr="Select * from pptoacuerdos where estado='S' and vigencia='".$_POST[vigencia]."' and tipo<>'I'";
								        $tv=7;
							 			$resp = mysql_query($sqlr,$link);
									    while ($row =mysql_fetch_row($resp)) 
									    {
											echo "<option value=$row[0] ";
											$i=$row[0];
										 	if($i==$_POST[acuerdo])
								 			{
											 	$_POST[nomacuerdo]=$row[2];
											 	echo "SELECTED";
											 	$_POST[vigencia]=$row[4];
											 	$_POST[valorac]=$row[$tv];
											 	$_POST[valorac2]=$row[$tv];
											 	$_POST[valorac]=number_format($_POST[valorac],2,'.',',');		 
											 	//******subrutina para cargar el detalle del acuerdo de adiciones
											 	if($_POST[chacuerdo]=='2' )
											  	{
											 		$sqlr2="select *from pptotraslados where id_acuerdo='$i' and vigencia='$vigusu' order by id_traslados";
											 		$resp2=mysql_query($sqlr2,$link);
										     		while ($row2 =mysql_fetch_row($resp2)) 
											   		{
											    		$_POST[dcuentas][]=$row2[4];
												 		if($row2[7]=='C')							
											    		{	
															$_POST[dcreditos][]=$row2[5];
															$_POST[dcontras][]=0;
														}
														else
														{
												 			$_POST[dcontras][]=$row2[5];
												 			$_POST[dcreditos][]=0;	
														}
												 		if(substr($row2[4],0,1)=='1')							
											     		{
											     			//$_POST[dcreditos][]=$row2[5];
															//$_POST[dcontras][]=0;
												 			$nresul=buscacuentapres($row2[4],1);
												 			$_POST[dncuentas][]=$nresul;		
												 		}
														else
														{
												 			$nresul=buscacuentapres($row2[4],2);
												 			$_POST[dncuentas][]=$nresul;									
											    			//$_POST[dcontras][]=$row2[5];
															//$_POST[dcreditos][]=0;
														}
											   		}						
											  	}///**** fin si cambio 
											}
										  	echo ">".$row[1]."-".$row[2]."</option>";	  
										}
							  		?>
							</select>
							<input type="hidden" name="chacuerdo" value="1">	
							<input type="hidden" name="nomacuerdo" value="<?php echo $_POST[nomacuerdo] ?>">	  
						</td>
					  	<td style="width:10%;" class="saludo1">Vigencia:</td>
					  	<td style="width:10%;">
					  		<input type="text" id="vigencia" name="vigencia" style="width:100%; font-weight: 500;" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  value="<?php echo $_POST[vigencia]?>" onClick="document.getElementById('tipocta').focus();document.getElementById('tipocta').select();" readonly>
					  	</td>
			       	</tr>
			       	<tr>
				   		<td style="width:10%;" class="saludo1">
				   			<input type="hidden" value="1" name="oculto">Valor Acuerdo:
				   		</td>
				   		<td style="width:10%;">
				   			<input name="valorac" type="text" value="<?php echo $_POST[valorac]?>" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)">
				   			<input type="hidden"  id="valorac2" name="valorac2" value="<?php echo $_POST[valorac2]?>">
				   		</td>
				   		<td style="width:10%;" class="saludo1">Finalizar</td>
				   		<td>
				   			<input type="checkbox" name="fin" value="1" id="fin" onClick="finaliza()">
				   		</td>
				    </tr>
      			</table>
      		</td>
      		<td colspan="3" style="width:25%; background:url(imagenes/siglas.png); background-repeat:no-repeat; background-position:right; background-size: 100% 100%;" ></td>
      	</tr>
	</table>
	<table  align="center" class="inicio" >
				<tr >
					<td class="titulos" colspan="7">.: Importar Cuentas Adicion/Reduccion</td>
				</tr>   
				<tr> 
					<td width="15%"  class="saludo1">Seleccione Archivo: </td>
					<td width="15%" >
						<input type="file" name="archivotexto" id="archivotexto">
					</td>
					<td colspan="7" >
						<input type="button" name="generar" value="Cargar Archivo" onClick="validarimport()">
						<input type="hidden" name="import" id="import" value="<?php echo $_POST[import] ?>" >
						<input type="button" name="protocolo" value="Descargar Formato de Importacion" onClick="protocoloimport()">
					</td>
				</tr>                  
			</table>
	<table class="inicio">
	   	<tr>
	   		<td colspan="8" class="titulos">Cuentas</td>
	   	</tr>
	   	<tr>
	   		<td style="width:5%;" class="saludo1">Tipo:</td>
	     	<td style="width:10%;">
		   	   	<select name="tipocta" id="tipocta" onKeyUp="return tabular(event,this)" onChange="validar()">
	          		<option value="1" <?php if($_POST[tipocta]=='1') echo "SELECTED"; ?>>Credito</option>
	          		<option value="2" <?php if($_POST[tipocta]=='2') echo "SELECTED"; ?>>ContraCredito</option>
	        	</select>	   
	        </td>
	        <td style="width:5%;" class="saludo1"> Cuenta:</td>
          	<td style="width:10%;" valign="middle" >
	          	<input type="text" id="cuenta" name="cuenta" style="width:80%;" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="buscacta(event)" value="<?php echo $_POST[cuenta]?>" onClick="document.getElementById('cuenta').focus();document.getElementById('cuenta').select();">
	          	<input type="hidden" value="" name="bc" id="bc">
	          	<a href="#" onClick="mypop=window.open('cuentasppto-ventana.php?ti=2','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px, height=500px'); mypop.focus();">
	          		<img src="imagenes/buscarep.png" align="absmiddle" border="0">
	          	</a>
	        </td>
	        <td >
	        	<input name="ncuenta" type="text" style="width:50%;" value="<?php echo $_POST[ncuenta]?>" readonly>
	        </td>
	    </tr>
		<tr>
			<td style="width:5%;" class="saludo1">Valor:</td>
			<td style="width:10%;">
				<input name="valor" type="text" value="<?php echo $_POST[valor]?>" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"> 
			</td>
			<td style="width:5%;" class="saludo1">Saldo:</td>
			<td style="width:10%;">
				<input name="valor2" type="text" value="<?php echo $_POST[valor2]?>" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly>
			</td> 
			<td >
				<input type="hidden" value="0" name="agregadet">
  				<input type="button" name="agregar" id="agregar" value="   Agregar   " onClick="agregardetalle()" >
  			</td>
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
			if($_POST[bc]!='')
			 {
			  $nresul=buscacuentapres($_POST[cuenta],2);
			  if($nresul!='')
			   {
			  $_POST[ncuenta]=$nresul;
	
  			  $vsal=generaSaldo($_POST[cuenta],$vigenciai,$vigusu); 	  			  	  			  
			  $_POST[valor]=$vsal;		  
			  $_POST[valor2]=$vsal;	
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
			  <script>alert("Cuenta Incorrecta");document.form2.cuenta.value="";document.form2.cuenta.focus();</script>
			  <?php
			  }
			 }
//******contracredito
			//**** busca cuenta
			if($_POST[bc2]!='')
			 {
			  $nresul=buscacuentapres($_POST[cuenta2],2);
			  if($nresul!='')
			   {
			  $_POST[ncuenta2]=$nresul;
			
			  $vsal=generaSaldo($_POST[cuenta2],$vigenciai,$vigusu); 	  			  	  			  
			  $_POST[valor]=$vsal;		  
			  $_POST[valor2]=$vsal;	
  			  ?>
			  <script>
			  document.getElementById('valor').focus();
			  document.getElementById('valor').select();
			  </script>
			  <?php
			  }
			 else
			 {
			  $_POST[ncuenta2]="";
			  ?>
			  <script>alert("Cuenta Incorrecta");document.form2.cuenta2.focus();</script>
			  <?php
			  }
			 }
		?><div class="subpantallac" style="height:40%; width:99.6%; overflow-x:hidden;">
		<table class="inicio" width="99%">
        <tr>
          <td class="titulos" colspan="6">Detalle Comprobantes          </td>
        </tr>
		<tr>
		<td class="titulos2">Cuenta Credito</td><td class="titulos2">Nombre Cuenta Credito</td>
		<td class="titulos2">Credito</td>
		<td class="titulos2">Contracredito</td>
		<td class="titulos2"><img src="imagenes/del.png"><input type='hidden' name='elimina' id='elimina'></td>
		</tr>
		<input type="hidden" name="restric" id="restric"  />
		<?php 
		function generaMensaje($arreglo,$contra){
				$cont=0;
				global $linkbd,$vigusu;
				for($i=0;$i<count($arreglo); $i++){
					$saldo=generaSaldo($arreglo[$i],$vigusu,$vigusu);
					if($contra[$i]>$saldo){
						$cont++;
						
					}
				}
				return "Existen $cont rubros con saldo insuficiente para dicha operacion";
			}
			
		if($_POST[import]=='1'){
			
			if(is_uploaded_file($_FILES['archivotexto']['tmp_name']))
			{
				$archivo = $_FILES['archivotexto']['name'];
				$archivoF = "$archivo";
				if(move_uploaded_file($_FILES['archivotexto']['tmp_name'],$archivoF))
				{
					$subio=1;
				}else{
					echo "El archivo NO se subio correctamente ";
				}
			}
			else{
				
			}
			
				$_POST[dcuentas]= array_values($_POST[dcuentas]); 
				$_POST[dncuentas]= array_values($_POST[dncuentas]); 
				$_POST[dcontras]= array_values($_POST[dcontras]); 
				$_POST[dcreditos]= array_values($_POST[dcreditos]); 
				require_once 'PHPExcel/Classes/PHPExcel/IOFactory.php';
				$objPHPExcel = PHPExcel_IOFactory::load("$archivo");
				foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
				$worksheetTitle     = $worksheet->getTitle();
				$highestRow         = $worksheet->getHighestRow(); // e.g. 10
				$highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
				$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
				$nrColumns = ord($highestColumn) - 64;
				
				
				for ($row = 3; $row <= $highestRow; ++ $row) {
					echo "<tr class='$co'>";
					$cell = $worksheet->getCellByColumnAndRow(0, $row);
					$val1 = trim($cell->getValue());
					//$val1 = str_replace(".", "",$val1);
					$cell = $worksheet->getCellByColumnAndRow(1, $row);
					$val2 = utf8_decode($cell->getValue());
					$cell = $worksheet->getCellByColumnAndRow(2, $row);
					$val3 = $cell->getValue();
					$cell = $worksheet->getCellByColumnAndRow(3, $row);
					$val4 = $cell->getValue();
					$_POST[dcuentas][]=$val1;
					$_POST[dncuentas][]=$val2;
					if($val3=='' || $val3=='0')
					{
						$_POST[dcreditos][]=0;
					}else{
						$_POST[dcreditos][]=$val3;
					}
					if($val4=='' || $val4=='0')
					{
						$_POST[dcontras][]=0;
					}else{
						$_POST[dcontras][]=$val4;
					}
				}
			}
			
			echo "<script>
			
					document.form2.import.value=2;
				</script>";
		}
					
		if ($_POST[elimina]!='')
		{ 
			$posi=$_POST[elimina];
			$cuentagas=0;
			$cuentaing=0;
			$diferencia=0;
			unset($_POST[dcuentas][$posi]);
			unset($_POST[dncuentas][$posi]);
			unset($_POST[dcontras][$posi]);		 		 		 		 		 
			unset($_POST[dcreditos][$posi]);		 		 
			$_POST[dcuentas]= array_values($_POST[dcuentas]); 
			$_POST[dncuentas]= array_values($_POST[dncuentas]); 
			$_POST[dcontras]= array_values($_POST[dcontras]); 		 		 		 		 
			$_POST[dcreditos]= array_values($_POST[dcreditos]); 		 		 		 		 		 
		}	 
		if ($_POST[agregadet]=='1')
		{
			$cuentagas=0;
			$cuentaing=0;
			$diferencia=0;
			$_POST[dcuentas][]=$_POST[cuenta];
			$_POST[dncuentas][]=$_POST[ncuenta];
		 
			if($_POST[tipocta]=='1')
			{
				$_POST[dcontras][]=0;
				$_POST[dcreditos][]=$_POST[valor];
			}
			if($_POST[tipocta]=='2')
			{
				$_POST[dcreditos][]=0;
				$_POST[dcontras][]=$_POST[valor];
			}

			$_POST[agregadet]=0;
			echo"
			<script>
		  		//document.form2.cuenta.focus();
				document.form2.valor.value='0';	
				document.form2.cuenta.value='';
				document.form2.ncuenta.value='';
				document.form2.tipocta.select();
		  		document.form2.tipocta.focus();	
			</script>";
		}
		$estilo="";
		$cont=0;
		$_POST[restric]="0";
		 for ($x=0;$x< count($_POST[dcuentas]);$x++)
		 {		
			$saldo=generaSaldo($_POST[dcuentas][$x],$vigusu,$vigusu);
			if($_POST[dcontras][$x]>$saldo){
				$estilo= "background-color:yellow !important"; 
				$_POST[restric]="1";
				$cont++;
				
			}
		 echo "<tr><td class='saludo2' style='width:20%;'>
			<input name='dcuentas[]' value='".$_POST[dcuentas][$x]."' type='text' style='width:100%;$estilo' readonly></td>
			<td class='saludo2' style='width:40%;'>
				<input name='dncuentas[]' value='".$_POST[dncuentas][$x]."' type='text' style='width:100%;$estilo' readonly></td>
			<td class='saludo2' style='width:20%;'>
				<input name='dcreditos[]' value='".$_POST[dcreditos][$x]."' type='text' style='width:100%;$estilo'></td>
			<td class='saludo2' style='width:20%;'>
				<input name='dcontras[]' value='".$_POST[dcontras][$x]."' type='text' style='width:100%;$estilo' onDblClick='llamarventana(this,$x)' readonly></td><td class='saludo2'><a href='#' onclick='eliminar($x)'><img src='imagenes/del.png'></a></td></tr>";
		 $cred=$_POST[dcreditos][$x];
 		 $contra=$_POST[dcontras][$x];		 
		 $contra=$contra;
		 $cred=$cred;		 
		 $cuentacred=$cuentacred+$cred;
		 $cuentacontras=$cuentacontras+$contra;
		 $_POST[cuentacreditos2]=$cuentacred;
		 $_POST[cuentacontras2]=$cuentacontras;		 	
		 $diferencia=$cuentacred-$cuentacontras;
		 $total=number_format($total,2,",","");
		 $_POST[diferencia]=number_format($diferencia,2,".",",");
 		 $_POST[cuentacred]=number_format($cuentacred,2,".",",");
		 $_POST[cuentacontras]=number_format($cuentacontras,2,".",",");	 
		 }
		  if($_POST[import]==1){
			 echo "<script>despliegamodalm('visible','2','Cuentas desplegadas','1'); </script>";
			 echo  "<div class='message'>".generaMensaje($_POST[dcuentas],$_POST[dcontras])."</div>";
			 if($cont>0){
				  echo "<script>document.form2.restric.value=1; </script>";
			 }else{
				  echo "<script>document.form2.restric.value=0; </script>";
			 }
			
		 }
		 echo "<tr><td >Diferencia:</td>
		 <td colspan='1' class='saludo1' style='width:40%;'>
			<input id='diferencia' name='diferencia' value='$_POST[diferencia]' style='width:100%;' readonly></td>
		<td class='saludo1' style='width:20%;'>
			<input name='cuentacred' id='cuentacred' value='$_POST[cuentacred]' style='width:100%;' readonly>
			<input name='cuentacreditos2' id='cuentacreditos2' value='$_POST[cuentacreditos2]'  type='hidden'></td>	
		<td class='saludo1' style='width:20%;'>
			<input name='cuentacontras' id='cuentacontras' value='$_POST[cuentacontras]' style='width:100%;' readonly>
			<input name='cuentacontras2' id='cuentacontras2' value='$_POST[cuentacontras2]' type='hidden'></td></tr>";
		?>
		</table></div>
    </form>
 <?php
  //***************PARTE PARA INSERTAR Y ACTUALIZAR LA INFORMACION
	$oculto=$_POST['oculto'];
	if($_POST[oculto]=='2')
	{	
		$linkbd=conectar_bd();
		if ($_POST[acuerdo]!="")
		{
			$nr="1";	
			ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
			$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	
		
			if($_POST[fin]=='1' && $_POST[valorac2]==$_POST[cuentacreditos2] && $_POST[valorac2]==$_POST[cuentacontras2]) //**** si esta completa y finalizado
			{
				$sqlr="update pptoacuerdos set estado='F' where id_acuerdo='".$_POST[acuerdo]."'";
				mysql_query($sqlr,$linkbd);	  
				echo "<table  class='inicio'>
						<tr>
							<td class='saludo1'><center>Se ha Actualizado el Presupuesto a la cuenta ".$_POST[dcuentas][$x]." con Exito</center></td>
						</tr>
					</table>";
				echo "<script>document.form2.acuerdo.value='';</script>";
				echo "<script>document.form2.fecha.focus();</script>";
				 //finalizacion y actualizacion de las cuentas pptales			  
		
				for($x=0;$x<count($_POST[dcuentas]);$x++)	
				{
					if ($_POST[dcreditos][$x]<=0)
					{
						$valores=$_POST[dcontras][$x];
						  
					}
					else
					{
						$valores=$_POST[dcreditos][$x];
  
					}
			
	  			}			 		  
			} 
			if($_POST[fin]!='1' )  //***** si no esta finalizado guardado provisionalmente 	
		    {
			 	$sqlr="update pptoacuerdos set estado='S' where id_acuerdo='".$_POST[acuerdo]."'";
				mysql_query($sqlr,$linkbd);	  
			  	echo "<table  class='inicio'><tr><td class='saludo1'><center>Se ha Actualizado el Presupuesto a la cuenta ".$_POST[dcuentas][$x]." con Exito</center></td></tr></table>";
	    	  	echo "<script>document.form2.acuerdo.value='';</script>";
		  	  	echo "<script>document.form2.fecha.focus();</script>";
			} 
			
			///***********insercion de las cuentas al traslado
			$sqlr="delete from pptotraslados where id_acuerdo='".$_POST[acuerdo]."' and vigencia='$_POST[vigencia]'";	 
			mysql_query($sqlr,$linkbd); 
			for($x=0;$x<count($_POST[dcuentas]);$x++)	
			{
				// echo"<br>rubro: ".$_POST[dcontras][$x]."cred: ".$_POST[dcreditos][$x]." Contra: ".$_POST[dcontras][$x];
				if ($_POST[dcontras][$x]>0)
				{
					$valores=$_POST[dcontras][$x];
					$tipocc='R';
					//$sqlr2="update pptocuentaspptoinicial set pptodef=pptodef-$valores,saldos=saldos-$valores,saldoscdprp=saldoscdprp-$valores where cuenta=".$_POST[dcuentas][$x]." and vigencia=".$_POST[vigencia];
					$sqlr="INSERT INTO pptotraslados (id_acuerdo,fecha,vigencia,cuenta,valor,estado,tipo)VALUES ($_POST[acuerdo],'".$fechaf."','$_POST[vigencia]','".$_POST[dcuentas][$x]."',".$_POST[dcontras][$x].",'S','$tipocc')";
				}
				else
				{
					$valores=$_POST[dcreditos][$x];
					$tipocc='C';
					//$sqlr2="update pptocuentaspptoinicial set pptodef=pptodef+$valores,saldos=saldos+$valores,saldoscdprp=saldoscdprp+$valores where cuenta=".$_POST[dcuentas][$x]." and vigencia=".$_POST[vigencia];
					$sqlr="INSERT INTO pptotraslados (id_acuerdo,fecha,vigencia,cuenta,valor,estado,tipo)VALUES ($_POST[acuerdo],'".$fechaf."','$_POST[vigencia]','".$_POST[dcuentas][$x]."',".$_POST[dcreditos][$x].",'S','$tipocc')";
				}
				//*** eliminar anteriores registros para crear el nuevo ppto inicial de la vigencia		
				// $sqlr="INSERT INTO pptotraslados (id_acuerdo,fecha,vigencia,cuenta,valor,estado,tipo)VALUES ($_POST[acuerdo],'".$fechaf."','$_POST[vigencia]','".$_POST[dcuentas][$x]."', $valores,'S','$tipocc')";
				//echo "<br>sqlr:".$sqlr;
				if (!mysql_query($sqlr,$linkbd))
				{
					echo "<script>alert('ERROR EN LA CREACION DEL TRASLADO PRESUPUESTAL');document.form2.fecha.focus();</script>";
				}
				else
				{
					echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado el presupuesto inicial de la cuenta ".$_POST[dcuentas][$x]." con Exito  Valor:".$valores."</center></td></tr></table>";
					echo "<script>document.form2.acuerdo.value='';</script>";
					echo "<script>document.form2.fecha.focus();</script>"; 
				}
			}   //****for
		}//***if de acuerdo   
		else
		{
			echo "<table  class='inicio'><tr><td class='saludo1'><center>Falta informacion para Crear el Proceso</center></td></tr></table>";
			echo "<script>document.form2.fecha.focus();</script>";  
		} 
	}//*** if de control de guardado
?>
<script>
 jQuery(function($){
  var user ="<?php echo $_SESSION[cedulausu]; ?>";
  var bloque='';
  $.post('peticionesjquery/seleccionavigencia.php',{usuario: user},selectresponse);
  

 $('#cambioVigencia').change(function(event) {
   var valor= $('#cambioVigencia').val();
   var user ="<?php echo $_SESSION[cedulausu]; ?>";
   var confirma=confirm('¿Realmente desea cambiar la vigencia?');
   if(confirma){
    var anobloqueo=bloqueo.split("-");
    var ano=anobloqueo[0];
    if(valor < ano){
      if(confirm("Tenga en cuenta va a entrar a un periodo bloqueado. Desea continuar")){
        $.post('peticionesjquery/cambiovigencia.php',{valor: valor,usuario: user},updateresponse);
      }else{
        location.reload();
      }

    }else{
      $.post('peticionesjquery/cambiovigencia.php',{valor: valor,usuario: user},updateresponse);
    }
    
   }else{
    location.reload();
   }
   
 });

 function updateresponse(data){
  json=eval(data);
  if(json[0].respuesta=='2'){
    alert("Vigencia modificada con exito");
  }else if(json[0].respuesta=='3'){
    alert("Error al modificar la vigencia");
  }
  location.reload();
 }
 function selectresponse(data){ 
  json=eval(data);
  $('#cambioVigencia').val(json[0].vigencia);
  bloqueo=json[0].bloqueo;
 }

 }); 
</script>
</body>
</html>