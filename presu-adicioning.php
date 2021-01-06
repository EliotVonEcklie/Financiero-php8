<?php //V 1001 20/12/16 Modificado implementacion de Reversion?> 
<?php //V 1000 12/12/16 ?> 
<!--V 1.0 24/02/2015-->
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
        <script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>		
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
//************* ver reporte ************
//***************************************
function verep(idfac)
{
  document.form1.oculto.value=idfac;
  document.form1.submit();
  }
  
	function protocoloimport()
	{
		document.form2.action="presu-adicioning-import.php";
		document.form2.target="_BLANK";
		document.form2.submit(); 
		document.form2.action="";
		document.form2.target="";
	}
//************* genera reporte ************
//***************************************
function genrep(idfac)
{
  document.form2.oculto.value=idfac;
  document.form2.submit();
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
				var _cons=document.getElementById('acuerdo').value;
				document.location.href = "presu-adicioningver.php?idegre="+_cons+"&scrtop=0&numpag=1&limreg=10&filtro1=&filtro2=";
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
if(restric!=1){
	if((Date.parse(fechabloqueo)) > (Date.parse(fechaCompara))){
	despliegamodalm('visible','2','Fecha de documento menor que fecha de bloqueo');
}else{
	var vigencia="<?php echo vigencia_usuarios($_SESSION[cedulausu]) ?>";
	if(vigencia==nuevaFecha[2]){
	if (document.form2.vigencia.value!='' && document.form2.fecha.value!='' && document.form2.acuerdo.value!='-1' && document.form2.acuerdo.value!='')
  {

	despliegamodalm('visible','4','Esta Seguro de Guardar','1');
  }
  else{

	despliegamodalm('visible','2','Faltan datos para completar el registro');
  }
  
	}else{
		despliegamodalm('visible','2','La fecha del documento debe coincidir con su vigencia');
	}

	
}
}else{
	despliegamodalm('visible','2','Algunos rubros sobrepasan el saldo permitido');
}


}

function validar(formulario)
{
document.form2.action="presu-adicioning.php";
document.form2.submit();
}

function validarimport(formulario)
{
	document.form2.import.value=1;
	document.form2.action="presu-adicioning.php";
	document.form2.submit();
}

function validar2(formulario)
{
var compro=document.form2.tipomov.value;
var regalias=document.form2.regalias.checked;
if(compro=='1'){
document.form2.chacuerdo.value=2;
document.form2.action="presu-adicioning.php";
document.form2.submit();
}else if(compro=='2'){
if(regalias){
alert("No puede aplicar reduccion a rubros de regalias");
document.form2.tipomov.value="-1";
}
else{
document.form2.chacuerdo.value=2;
document.form2.action="presu-adicioning.php";
document.form2.submit();
}

}

}

function buscacta(e)
{
	if (document.form2.cuenta.value!="")
	{
		document.form2.bc.value=document.form2.tipocta.value;
		document.form2.submit();
	}
}
function agregardetalle()
{
	vc=document.form2.valorac2.value;
	if(document.form2.cuenta.value!="" && document.form2.tipomov.value!="" && document.form2.tipocta.value!="" && parseFloat(document.form2.valor.value)>0 )
	{ 
		tipoc=document.form2.tipocta.value;
		switch (tipoc)
		{
			case '1':
				suma=parseFloat(document.form2.valor.value)+parseFloat(document.form2.cuentaing2.value);
				saldo=parseFloat(document.form2.valor2.value);
				valor=parseFloat(document.form2.valor.value);
				if(suma<=vc)
				{
					document.form2.agregadet.value=1;
	//				document.form2.chacuerdo.value=2;
					document.form2.submit();
				}
				else
	 			{
					alert("El Valor supera el Acto Administrativo: "+suma);
				}
			break;
			case '2':
				suma=parseFloat(document.form2.valor.value)+parseFloat(document.form2.cuentagas2.value);
				if(suma<=vc)
				{
					document.form2.agregadet.value=1;
	//				document.form2.chacuerdo.value=2;
					document.form2.submit();
				}
				else
	 			{
					despliegamodalm('visible','2',"El Valor supera el saldo del rubro: "+suma);
				}
			break;
		}
	}
	else {
		despliegamodalm('visible','2',"Falta informacion para poder Agregar");
	}
}
function eliminar(variable)
{
if (confirm("Esta Seguro de Eliminar"))
  {
  //document.form2.chacuerdo.value=2;
document.form2.elimina.value=variable;
//eli=document.getElementById(elimina);
vvend=document.getElementById('elimina');
//eli.value=elimina;
vvend.value=variable;
document.form2.submit();
}
}
function finaliza()
{
	if(document.form2.fin.checked)
 	{
 		if (parseFloat(document.form2.valorac2.value)==parseFloat(document.form2.cuentagas2.value) && parseFloat(document.form2.valorac2.value)==parseFloat(document.form2.cuentaing2.value))
 	  	{
 	  		if (confirm("Confirme Guardando el Documento, al completar el Proceso"))
 	  		{
 		  		document.form2.fin.checked=true; 
 		  		document.form2.fin.value=1;
 	  		} 
 	  		else
 	  		{
 	  			document.form2.fin.checked=false; 
 	  		}
 	  	}
 	  	else 
 	  	{
			despliegamodalm('visible','2',"El Total del Acto Administrativo no es igual al de Ingresos y/o Gastos");
			
 	    	document.form2.fin.checked=false; 
 	  	}
 	}else{
 		document.form2.fin.checked=false; 
 		document.form2.fin.value=0;
 	}
}
function capturaTecla(e){ 
var tcl = (document.all)?e.keyCode:e.which;
if (tcl==115){
alert(tcl);
return tabular(e,elemento);
}
}
function validaregalias(){
	var compro=document.form2.tipomov.value;
	if(compro=='2'){
		if(document.form2.regalias.checked){
			alert("No puede aplicar reduccion a rubros de regalias");
			document.form2.regalias.checked=false;
		}
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
				<a href="presu-adicioning.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
				<a href="#"  onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar"/></a>
				<a href="presu-buscaradicioning.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a>
				<a href="#" class="mgbt" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
        	</tr>
        </table>
		<?php
			$vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
			$_POST[vigencia]=vigencia_usuarios($_SESSION[cedulausu]); 
			$vigencia=$vigusu; 
			if(!$_POST[oculto])
			{
					 $fec=date("d/m/Y");
					 $_POST[fecha]=$fec; 	
					 $_POST[valor]=0; 			 
					 $_POST[cuentaing]=0;
					 $_POST[cuentagas]=0;
					 $_POST[cuentaing2]=0;
					 $_POST[cuentagas2]=0;
			}
			//**** busca cuenta
			if($_POST[bc]!='')
			{
			  	$nresul=buscacuentapres($_POST[cuenta],$_POST[tipocta]);			
			  	if($nresul!=''){
					$sqlr="select *from pptocuentas where cuenta='$_POST[cuenta]' and (vigencia=".$vigusu." or   vigenciaf=$vigusu)";
			  		$res=mysql_query($sqlr,$linkbd);
			  		$row=mysql_fetch_row($res);
					$vigenciai=$row[25];
					$_POST[ncuenta]=$nresul;
					$vsal=generaSaldo($_POST[cuenta],$vigenciai,$vigusu);	  			  
					$_POST[valor]=0;		  
					$_POST[valor2]=$vsal;
				}
					
			 	else{$_POST[ncuenta]="";}
			}
			//echo "<TR><TD>CHAC :".$_POST[chacuerdo]."</TD></TR>";
			if ($_POST[chacuerdo]=='2')
			{
					unset($_POST[dcuentas]);
					unset($_POST[dncuentas]);
					unset($_POST[dgastos]);		 		 		 		 		 						   			 		 		 		 		 		 
					unset($_POST[dingresos]);
				$_POST[dcuentas]=array();
				$_POST[dncuentas]=array();
				$_POST[dingresos]=array();
				$_POST[dgastos]=array();
				$_POST[diferencia]=0;
				$_POST[cuentagas]=0;
				$_POST[cuentaing]=0;																			
			}	 
		?>
		<div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
 		<form name="form2" method="post" action="presu-adicioning.php" enctype="multipart/form-data">
	 		<?php
	 			$sesion=$_SESSION[cedulausu];
	 			$sqlr="Select dominios.valor_final from usuarios,dominios where usuarios.cc_usu=$sesion and dominios.NOMBRE_DOMINIO='PERMISO_MODIFICA_DOC' and dominios.valor_inicial=usuarios.cc_usu ";
					$resp = mysql_query($sqlr,$linkbd);
					$fechaBloqueo=mysql_fetch_row($resp);
					echo "<input type='hidden' name='fechabloq' id='fechabloq' value='$fechaBloqueo[0]' />";
	 		?>
   			<table class="inicio" align="center" width="80%" >
      			<tr>
                    <td class="titulos" style="width:95%;" colspan="2">.: Adicion/Reduccion Presupuestal</td>
                    <td class="cerrar" style="width:5%;"><a href="presu-principal.php">&nbsp;Cerrar</a></td>
      			</tr>
      			<tr>
      				<td style="width:75%;">
      					<table>
      						<tr>
				  				<td style="width:10%;" class="saludo1">Adicion/Reduccion</td>
					 			<td style="width:10%;">
			                     	<select name="tipomov" id="tipomov" onKeyUp="return tabular(event,this)" onChange="validar2()" style="width:100%;">
										<option value="-1" >Seleccione</option>
			          					<option value="1" <?php if($_POST[tipomov]=='1') echo "SELECTED"; ?>>Adicion</option>
			         					<option value="2" <?php if($_POST[tipomov]=='2') echo "SELECTED"; ?>>Reduccion</option>
			        				</select>
								</td>
				  				<td style="width:5%;" class="saludo1">Fecha:</td>
			        			<td style="width:15%;">
			        				<input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY"  value="<?php echo $_POST[fecha]; ?>" style="width:75%;" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">
			        				<a href="#" onClick="displayCalendarFor('fc_1198971545');">&nbsp;
			        					<img src="imagenes/calendario04.png" style="width:20px" align="absmiddle" border="0">
			        				</a>
			        			</td>
					 			<td style="width:15%;" class="saludo1">Acto Administrativo:</td>
			          			<td  valign="middle" style="width:20%;">
									<input type="hidden" name="consulta" id="consulta" value="<?php echo $_POST[consulta]?>">
									<select name="acuerdo" style="width:100%;" onChange="validar2()" onKeyUp="return tabular(event,this)">
										<option value="-1">Seleccione</option>
					 					<?php
										
											$_POST[cuentaing2]=0;
											$_POST[cuentagas2]=0;
			  		   						$sqlr="Select * from pptoacuerdos where estado='S' and vigencia='".$vigusu."' and tipo<>'I'";
						       				$tv=4+$_POST[tipomov];
					 						$resp = mysql_query($sqlr,$linkbd);
							    			while ($row =mysql_fetch_row($resp)) 
							    			{
												echo "<option value=$row[0] ";
												$i=$row[0];
								 				if($i==$_POST[acuerdo])
						 						{
									 				echo "SELECTED";
												   	$_POST[vigencia]=$row[4];
												   	$_POST[valorac]=$row[$tv];
												   	$_POST[valorac2]=$row[$tv];
												   	$_POST[valorac]=number_format($_POST[valorac],2,'.',',');		 
									 				//******subrutina para cargar el detalle del acuerdo de adiciones
									 				if($_POST[chacuerdo]=='2' )
									  				{
														if(!empty($_POST[tipomov])){
															if($_POST[tipomov]=='1'){
																 $_POST[chacuerdo]="";
									 					$sqlr2="select *from pptoadiciones where id_acuerdo='$i' order by tipo desc";
														
									 					$resp2=mysql_query($sqlr2,$linkbd);
														$contador=0;
								     					while ($row2 =mysql_fetch_row($resp2)) 
									   					{
									   						$_POST[dcuentas][]=$row2[4];	
															$nresul=existecuentain($row2[4]);
															$_POST[dncuentas][]=$nresul;		
															$sqlrad="select clasificacion from pptocuentas where estado='S' and cuenta='".$row2[4]."' and (vigencia='".$vigusu."' or vigenciaf='$vigusu')";				
															//echo "Sql:".$sqlr;
															$respc = mysql_query($sqlrad,$linkbd);
															while ($rowc =mysql_fetch_row($respc)) 
															{
															 $tipo=$rowc[0];
															}
										 					if($tipo=='ingresos')							
									    					{
																$_POST[dingresos][]=$row2[5];
																$_POST[dgastos][]=0;
										 						//$nresul=existecuentain($row2[4]);
										 						
															}
															if($tipo=='funcionamiento' || $tipo=='inversion' || $tipo=='deuda')	
															{
										 						//$nresul=existecuentain($row2[4]);
			//							 						$_POST[dncuentas][]=$nresul;									
									    						$_POST[dgastos][]=$row2[5];
																$_POST[dingresos][]=0;
															}
															$contador+=1;
									   					}
														$_POST[consulta]=$contador;
															}else{
															//******subrutina para cargar el detalle del acuerdo de adiciones
														$_POST[idacuerdo]=$i;
									 					$sqlr2="select *from pptoreducciones where id_acuerdo='$i'  order by tipo desc";
														$resp2=mysql_query($sqlr2,$linkbd);;
								     					while ($row2 =mysql_fetch_row($resp2)) 
									   					{
															$_POST[dcuentas][]=$row2[4];	
															$nresul=existecuentain($row2[4]);
															$_POST[dncuentas][]=$nresul;		
															$sqlrad="select clasificacion from pptocuentas where estado='S' and cuenta='".$row2[4]."' and (vigencia='".$vigusu."' or vigenciaf='$vigusu')";				
															$tipo="";
															$respc = mysql_query($sqlrad,$linkbd);
															while ($rowc =mysql_fetch_row($respc)) 
															{
															 $tipo=$rowc[0];
															}
										 					if($tipo=='ingresos')							
									    					{
																$_POST[dingresos][]=$row2[5];
																$_POST[dgastos][]=0;
										 						//$nresul=existecuentain($row2[4]);
										 						//$_POST[dncuentas][]=$nresul;		
															}
															if($tipo=='funcionamiento' || $tipo=='inversion' || $tipo=='deuda')	
															{
										 						//$nresul=existecuentain($row2[4]);
										 						//$_POST[dncuentas][]=$nresul;									
									    						$_POST[dgastos][]=$row2[5];
																$_POST[dingresos][]=0;
															}
									   					}	
															}
														}
													  
									 					
									 					
									  				}///**** fin si cambio 
												}
								  				echo ">".$row[1]."-".$row[2]."</option>";	  
											}
											
											
					  					?>
									</select><?php //echo $sqlrad;?>
			                        <input type="hidden" name="chacuerdo" value="1">		  
			                  	</td>
					  			<td style="width:7%;" class="saludo1">Vigencia:</td>
					  			<td style="width:10%;">
					  				<input type="text" id="vigencia" name="vigencia" style="width:100%; " onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  value="<?php echo $_POST[vigencia]?>" onClick="document.getElementById('tipocta').focus(); document.getElementById('tipocta').select();"  readonly>
					  			</td>
			       			</tr>
			                <tr>
				   				<td style="width:10%;" class="saludo1">
				   					<input type="hidden" value="1" name="oculto">Valor Acuerdo:</td>
			                    <td style="width:10%;">
			                    	<input name="valorac" type="text" value="<?php echo $_POST[valorac]?>" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)">
			                    	<input type="hidden"  id="valorac2" name="valorac2" value="<?php echo $_POST[valorac2]?>">
			                    </td>
			                    <td style="width:5%;" class="saludo1">Regalias</td>
			          			<td>
			          				<input type="checkbox" name="regalias" id="regalias" onClick="validaregalias()" <?php if(!empty($_POST[regalias])){echo "CHECKED"; } ?> >
			          			</td>
			          			<td style="width:5%;" class="saludo1">Finalizar</td>
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
						<input type="button" name="generar" value="Cargar Archivo" onClick="validarimport()" />
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
                	<td style="width:5%;" class="saludo1">Tipo</td>
	   				<td style="width:10%;">
                    	<select name="tipocta" id="tipocta" onKeyUp="return tabular(event,this)" onChange="validar()" style="width:80%;">
							<option value="-1" >Seleccione</option>
          					<option value="1" <?php if($_POST[tipocta]=='1') echo "SELECTED"; ?>>Ingreso</option>
          					<option value="2" <?php if($_POST[tipocta]=='2') echo "SELECTED"; ?>>Gastos</option>
       					</select>
                   	</td>
					<td style="width:5%;" class="saludo1">Cuenta:</td>
          			<td  valign="middle" style="width:10%;">
          				<input type="text" id="cuenta" name="cuenta" style="width:75%;" onKeyUp="return tabular(event,this)" onBlur="buscacta(event)" value="<?php echo $_POST[cuenta]?>" onClick="document.getElementById('cuenta').focus();document.getElementById('cuenta').select();"> 
          				<input type="hidden" value="" name="bc" id="bc">
          				<a href="#" onClick="mypop=window.open('cuentasppto-ventana.php?ti=<?php echo $_POST[tipocta] ?>','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();">
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
					<?php
					if($_POST[tipomov]==2){
					?>
					<td style="width:5%;" class="saludo1">Saldo:</td>
                    <td style="width:10%;">
                    	<input name="valor2" type="text" value="<?php echo $_POST[valor2]?>" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly>
                    </td>
					<?php
					}
					if($_POST[tipomov]==1){
					?>
					<input name="valor2" type="hidden" value="<?php echo $_POST[valor2]?>" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)">
                    <?php
					}
					?>
          			<td>
          				<input type="button" name="agregar" id="agregar" value="   Agregar   " onClick="agregardetalle()" >
          				<input type="hidden" value="0" name="agregadet">
          			</td>
              	</tr>  
    		</table>
			<?php
			
			function generaMensaje($arreglo,$ingresos,$gastos,$tipo){
				$cont=0;
				global $linkbd,$vigusu;
				for($i=0;$i<count($arreglo); $i++){
					 $saldo=generaSaldo($arreglo[$i],$vigusu,$vigusu);
				    if($tipo==2){
						 if($ingresos[$i]==0){   //GASTOS
					 if($gastos[$i]>$saldo){
						$cont++;
					 }
				 }else{  //INGRESOS
					 if($ingresos[$i]>$saldo){
						$cont++;
					 }
				 }
				 }
				}
				return "Existen $cont rubros con saldo insuficiente para dicha operacion";
			}
			
				if(!$_POST[oculto]){ ?><script>document.form2.fecha.focus();</script><?php }
				//**** busca cuenta
				$iter='zebra1';
                $iter2='zebra2';
				if($_POST[bc]!='')
			 	{
			  		$nresul=buscacuentapres($_POST[cuenta],$_POST[tipocta]);
			  		if($nresul!='')
			   		{
			  			$_POST[ncuenta]=$nresul;
  			  			?><script>
			  				document
			  				document.getElementById('valor').focus();
			  				document.getElementById('valor').select();
			  			</script><?php
			  		}
			 		else
			 		{
			  			$_POST[ncuenta]="";
			  			?><script>despliegamodalm('visible','2','Cuenta Incorrecta'); document.form2.cuenta.focus();</script><?php
			  		}
			 	}
			?>
			<input type="hidden" name="mensaje" id="mensaje" value="<?php echo $_POST[mensaje]; ?>" />
			<input type="hidden" name="restric" id="restric"  />
        	<div class="subpantallac" style="height:40%; width:99.6%; overflow-x:hidden;">
			<?php echo $_POST[mensaje]; ?>
				<table class="inicio" width="99%">
        			<tr><td class="titulos" colspan="5">Detalle Comprobantes</td></tr>
					<tr>
						<td class="titulos2">Cuenta</td><td class="titulos2">Nombre Cuenta</td>
        				<td class="titulos2">Ingresos</td><td class="titulos2">Gastos</td>
                        <td class="titulos2"><img src="imagenes/del.png"></td>
					</tr>
					<?php 
					//echo $_POST[import];
					if($_POST[import]==1){
						if(is_uploaded_file($_FILES['archivotexto']['tmp_name']))
						{
							$archivo = $_FILES['archivotexto']['name'];
							$archivoF = "$archivo";echo $archivo;
							if(move_uploaded_file($_FILES['archivotexto']['tmp_name'],$archivoF))
							{
								//echo "El archivo se subio correctamente ";
								$subio=1;
							}
						}
							$_POST[dcuentas]= array_values($_POST[dcuentas]); 
						   	$_POST[dncuentas]= array_values($_POST[dncuentas]); 
						   	$_POST[dgastos]= array_values($_POST[dgastos]); 
						   	$_POST[dingresos]= array_values($_POST[dingresos]); 
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
								if ($val1!='')
								{ 
									$sqlr="select cuenta from pptocuentas where cuenta='$val1'";
									$result=mysql_query($sqlr,$linkbd);
									$row1=mysql_fetch_row($result);
									if ($row1[0]=='')
									{
										echo "<script>despliegamodalm('visible','2',' Hay cuentas que no existen');</script>";
									}
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
											$_POST[dingresos][]=0;
										}else{
											$_POST[dingresos][]=$val3;
										}
										if($val4=='' || $val4=='0')
										{
											$_POST[dgastos][]=0;
										}else{
											$_POST[dgastos][]=$val4;
										}
								}
								
							}
						}
						
						?>
						<script>
							document.form2.import.value=2;
						</script>
						<?php
					}
					
						if ($_POST[elimina]!='')
		 				{ 
		 				
		 					$posi=$_POST[elimina];
		  					$cuentagas=0;
		  					$cuentaing=0;
		   					$diferencia=0;
		 					unset($_POST[dcuentas][$posi]);
						   	unset($_POST[dncuentas][$posi]);
						   	unset($_POST[dgastos][$posi]);		 		 		 		 		 						   			 		 		 		 		 		 
						   	unset($_POST[dingresos][$posi]);		 
						  	$_POST[dcuentas]= array_values($_POST[dcuentas]); 
						   	$_POST[dncuentas]= array_values($_POST[dncuentas]); 
						   	$_POST[dgastos]= array_values($_POST[dgastos]); 
						   	$_POST[dingresos]= array_values($_POST[dingresos]); 		
							$_POST[elimina]=""; 		 		 		 
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
								$_POST[dgastos][]=0;
							 	$_POST[dingresos][]=$_POST[valor];
							}
							if($_POST[tipocta]=='2')
		 					{
							 	$_POST[dingresos][]=0;
							 	$_POST[dgastos][]=$_POST[valor];
		 					}
		 					$_POST[agregadet]=0;
		  					?><script>
                         			
                                document.form2.cuenta.value="";
                                document.form2.ncuenta.value="";
                                document.form2.tipocta.select();
                                document.form2.tipocta.focus();	
								document.form2.agregadet.value=0;
                         	</script><?php
		  				}
		 $_POST[restric]="0";
		 $cont=0;
		 for ($x=0;$x< count($_POST[dcuentas]);$x++)
		 {
			 $saldo=generaSaldo($_POST[dcuentas][$x],$vigusu,$vigusu);
			 $stilo="";
			 $sqlr="select cuenta from pptocuentas where cuenta='".$_POST[dcuentas][$x]."'";
			 $result=mysql_query($sqlr,$linkbd);
			 $row1=mysql_fetch_row($result);
			 if($_POST[tipomov]==2){
				 	 if($_POST[dingresos][$x]==0){   //GASTOS
				 if($_POST[dgastos][$x]>$saldo){
					 $stilo="background-color:yellow !important ";
					 $_POST[mensaje]="Error";
					 $_POST[restric]="1";
					 $cont++;
				 }
			 }else{  //INGRESOS
				 if($_POST[dingresos][$x]>$saldo){
					 $stilo="background-color:yellow !important ";
					 $_POST[mensaje]="Error";
					 $_POST[restric]="1";
					 $cont++;
				 }
			 }
			 }
		
		 if($row1[0]=='')
		 {
			$stilo="background-color:yellow !important";
		 }
		 echo "<tr class='$iter' style='$stilo'>
				<td>".$_POST[dcuentas][$x]."<input name='dcuentas[]' value='".$_POST[dcuentas][$x]."' type='hidden'></td>
				<td>".$_POST[dncuentas][$x]."<input name='dncuentas[]' value='".$_POST[dncuentas][$x]."' type='hidden'></td>
				<td>".$_POST[dingresos][$x]."<input name='dingresos[]' value='".$_POST[dingresos][$x]."' type='hidden'></td>
				<td>".$_POST[dgastos][$x]."<input name='dgastos[]' value='".$_POST[dgastos][$x]."' type='hidden'></td>
		 		<td >
		 			<a href='#' onclick='eliminar($x)'><img src='imagenes/del.png'></a>
		 		</td>
		 	</tr>";
			$aux=$iter;
            $iter=$iter2;
            $iter2=$aux;
		 $gas=$_POST[dgastos][$x];
		 $ing=$_POST[dingresos][$x];
		 $gas=$gas;
		 $ing=$ing;		 
		 $cuentagas=$cuentagas+$gas;
		 $cuentaing=$cuentaing+$ing;
		 $_POST[cuentagas2]=$cuentagas;
		 $_POST[cuentaing2]=$cuentaing;		 	
		 $diferencia=$cuentaing-$cuentagas;
		 $total=number_format($total,2,",","");
		 $_POST[diferencia]=number_format($diferencia,2,".",",");
 		 $_POST[cuentagas]=number_format($cuentagas,2,".",",");
		 $_POST[cuentaing]=number_format($cuentaing,2,".",",");	
			
		 }
		 if($_POST[import]==1){
			 echo "<script>despliegamodalm('visible','2','Cuentas desplegadas','1'); </script>";
			 echo  "<div class='message'>".generaMensaje($_POST[dcuentas],$_POST[dingresos],$_POST[dgastos],$_POST[tipomov])."</div>";
			 if($cont>0){
				  echo "<script>document.form2.restric.value=1; </script>";
			 }else{
				  echo "<script>document.form2.restric.value=0; </script>";
			 }
			
		 }
		
		 echo "<tr><td >Diferencia:</td>
		 <td colspan='1'>
			<input id='diferencia' name='diferencia' value='$_POST[diferencia]' style='width:100%' readonly></td>
		<td class='saludo1' style='width:15%'>
			<input name='cuentaing' id='cuentaing' value='$_POST[cuentaing]' style='width:100%'  readonly>
			<input name='cuentaing2' id='cuentaing2' value='$_POST[cuentaing2]' type='hidden'></td>
		<td class='saludo1' style='width:15%'>
			<input id='cuentagas' name='cuentagas' value='$_POST[cuentagas]' style='width:100%' readonly><input id='cuentagas2' name='cuentagas2' value='$_POST[cuentagas2]' type='hidden'></td></tr>";
		?>
		<input type='hidden' name='elimina' id='elimina'></table></div>
    </form>
  <?php
  //***************PARTE PARA INSERTAR Y ACTUALIZAR LA INFORMACION
									 					
	$oculto=$_POST['oculto'];
	if($_POST[oculto]=='2')
	{
		
		if ($_POST[acuerdo]!="")
	 	{
 			$nr="1";	
 			ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
			$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
			///***********insercion de las cuentas al ppto inicial
			switch($_POST[tipomov])
			{
				case 1: //Adiciones 
					$regalias="";
		 			if($_POST[fin]=='1') //**** si esta completa y finalizado
		    		{
			 			$sqlr="update pptoacuerdos set estado='F' where id_acuerdo='".$_POST[acuerdo]."'";
	 		
		  	  			mysql_query($sqlr,$linkbd);	  

					}
					$sqlr="delete from pptoadiciones where  vigencia='$_POST[vigencia]' and id_acuerdo='$_POST[acuerdo]'";	
					mysql_query($sqlr,$linkbd); 		
					
				
					for($x=0;$x<count($_POST[dcuentas]);$x++)	
					{
						
						//	echo "<br>".$sqlr; 
						if ($_POST[dingresos][$x]<=0)
						{
							$valores=$_POST[dgastos][$x];
							$tc='G';
						}
						else
						{
							$valores=$_POST[dingresos][$x];
							$tc='I';
						}
						
						//*** eliminar anteriores registros para crear el nuevo ppto inicial de la vigencia	
						if($_POST[regalias]!='') //**** si esta completa y finalizado
			    		{
				 			$regalias="S"; 

						}

						$sqlr="INSERT INTO pptoadiciones (cuenta,fecha,vigencia,valor,estado,tipo,id_acuerdo,tipomovimiento)VALUES (TRIM(' ' FROM '".$_POST[dcuentas][$x]."'),'".$fechaf."','$_POST[vigencia]', $valores,'S','$tc',$_POST[acuerdo],'$regalias')";
						
	
						if (!mysql_query($sqlr,$linkbd))
						{
							echo "<script>alert('ERROR EN LA CREACION DE LA ADICION PRESUPUESTAL');document.form2.fecha.focus();</script>";
						}
						else
						{  	   
		  
							echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado el Reduccion de la cuenta ".$_POST[dcuentas][$x]." con Exito <img src='imagenes\confirm.png'></center></td></tr></table><script>funcionmensaje();</script>";
		
						}
					}   //****for
				break;	
				case 2:		
					if($_POST[fin]=='1') //**** si esta completa y finalizado
					{
						$sqlr="update pptoacuerdos set estado='F' where id_acuerdo='".$_POST[acuerdo]."'";
						//echo "sqlr:".$sqlr;
						mysql_query($sqlr,$linkbd);	  
					}
					$sqlr="delete from pptoreducciones where  vigencia='$_POST[vigencia]' and id_acuerdo=$_POST[acuerdo]";	
					mysql_query($sqlr,$linkbd);  
		
					for($x=0;$x<count($_POST[dcuentas]);$x++)	
					{	
						$sqlr="delete from pptoreducciones where cuenta='".$_POST[dcuentas][$x]."' and vigencia='$_POST[vigencia]' and id_acuerdo=$_POST[acuerdo]";	
						mysql_query($sqlr,$linkbd);   
						if ($_POST[dingresos][$x]<=0)
						{
							$valores=$_POST[dgastos][$x];
							$tc='G';
						}
						else
						{
							$valores=$_POST[dingresos][$x];
							$tc='I';
						}
							//*** eliminar anteriores registros para crear el nuevo ppto inicial de la vigencia			 
						$sqlr="INSERT INTO pptoreducciones (cuenta,fecha,vigencia,valor,estado,tipo,id_acuerdo)VALUES (TRIM(' ' FROM '".$_POST[dcuentas][$x]."'),'".$fechaf."','$_POST[vigencia]', $valores,'S','$tc',$_POST[acuerdo])";
						//echo "sqlr:".$sqlr;
						if (!mysql_query($sqlr,$linkbd))
						{
							echo "<script>alert('ERROR EN LA CREACION DE LA REDUCCION PRESUPUESTAL');document.form2.fecha.focus();</script>";
						}
						else
						{	 
							if($_POST[fin]=='1' ) //**** si esta completa y finalizado
							{
								
								$sqlr="update pptocuentaspptoinicial set pptodef=pptodef-$valores, SALDOS=SALDOS-$valores, SALDOSCDPRP=SALDOSCDPRP-$valores where cuenta='".$_POST[dcuentas][$x]."' and (pptocuentas.vigencia=".$vigusu." or pptocuentas.vigenciaf=".$vigusu.")";
								//echo "sqlr:".$sqlr;
								mysql_query($sqlr,$linkbd);	  

								
							} 
							echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado el Reduccion de la cuenta ".$_POST[dcuentas][$x]." con Exito <img src='imagenes\confirm.png'></center></td></tr></table><script>funcionmensaje();</script>";
			
			
						}
					}   //****for
				break;	   
			} //****switch
		}//***if de acuerdo
		else
		{
			echo "<table><tr><td class='saludo1'><center>Falta informacion para Crear el Proceso</center></td></tr></table>";
			echo "<script>document.form2.fecha.focus();</script>";  
		} 
	}//*** if de control de guardado
?> 
<div id="bgventanamodal2">
                <div id="ventanamodal2">
                    <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                    </IFRAME>
                </div>
       	 	</div>	
</body>
</html>