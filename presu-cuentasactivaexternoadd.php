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
		<title>:: Spid - Presupuesto</title>
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
function buscacta(e)
 {
if (document.form2.cuenta.value!="")
{
 document.form2.bc.value='1';
 document.form2.submit();
 }
 }

 			function despliegamodal2(_valor)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else {document.getElementById('ventana2').src="contra-productos-ventana.php";}
			}
 			function despliegamodalm(_valor,_tip,mensa,pregunta,variable)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventanam').src="";}
				else
				{
					switch(_tip)
					{
						case "1":	document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
						case "2":	document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
						case "3":	document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
						case "4":	document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;	
				case "5":
					document.getElementById('ventanam').src="ventana-elimina1.php?titulos="+mensa+"&idresp="+pregunta+"&variable="+variable;break;	
					}
				}
			}
			function respuestaconsulta(pregunta, variable)
			{
				switch(pregunta)
				{
					case "1":	document.getElementById('oculto').value="2";
								document.form2.submit();break;
					case "2":
						document.form2.elimina.value=variable;
						//eli=document.getElementById(elimina);
						vvend=document.getElementById('elimina');
						//eli.value=elimina;
						vvend.value=variable;
						document.form2.submit();
						break;
				}
			}
			function funcionmensaje(){}
			function guardar()
			{
				var validacion01=document.getElementById('clasificacion').value;
				if (validacion01.trim()!='-1')
				{despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
 				else{despliegamodalm('visible','2','Faltan datos para completar el registro');}
			}

 function mosven()
 {

document.form2.verifica.value=2;


document.form2.action="presu-cuentasactivaexternoadd.php";
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
          		<td colspan="3" class="cinta"><a href="presu-cuentasactivaexternoadd.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a><a href="#"  onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png" title="Guardar"/></a><a href="presu-cuentasactivaexterno.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a><a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
        	</tr>
		</table>	  
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>	  
 <form name="form2" method="post" action="presu-cuentasactivaexternoadd.php">
<?php 
$vigencia=date(Y);
$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
?>
	<table class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="14">.: Agregar Cuentas Ingresos </td>
        <td class="cerrar" ><a href="presu-principal.php"> Cerrar</a></td>
      </tr>
      <tr  >
	  <td class="saludo1">.: Cuenta:
        </td>
        <td><input name="cuenta" type="text" value="<?php echo $_POST[cuenta]?>" size="25"  onKeyUp="return tabular(event,this)" onBlur="buscacta(event)"><input type="hidden" value="0" name="bc" >
        </td>
        <td class="saludo1">.: Descripción:
        </td>
        <td colspan="1">  <input name="descripcion" type="text" value="<?php echo $_POST[descripcion]?>" size="70" onKeyUp="return tabular(event,this)">
        </td>
		      
	   <td class="saludo1">.: Tipo:
        </td>
        <td><select name="tipo" id="tipo" onChange="document.form2.submit()">
          <option value="Mayor"<?php if($_POST[tipo]=='Mayor') echo "SELECTED"?>>Mayor</option>
          <option value="Auxiliar" <?php if($_POST[tipo]=='Auxiliar') echo "SELECTED"?>>Auxiliar</option>
        </select>   <input name="oculto" id="oculto" type="hidden" value="1"><input name="verifica" type="hidden" value="1">     </td>
	           <td class="saludo1">Clasificacion:
        </td>
        <td colspan="2">
			<select name="clasificacion" id="clasificacion" >
				<option value="-1">Seleccione ....</option>
				<?php
				$sqlr="Select * from dominios where nombre_dominio like 'CLASIFICACION_RUBROS' and TIPO='I' order by descripcion_dominio ASC";
				$resp = mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($resp)) 
				{
					$i=$row[2];
					echo "<option value='$row[2]' ";
					if(0==strcmp($i,$_POST[clasificacion]))
					{
						echo "SELECTED";
					}
					echo " >".strtoupper($row[2])."</option>";	  
				}			
				?>        
			</select>    
		</td>
					<td class="saludo1">Regal&iacute;as:</td>
					<td>
						<select name="regalias" id="regalias" onChange="document.form2.submit()" >
							<option value="N" <?php if($_POST[regalias]=='N') echo "SELECTED"?>>N</option>
							<option value="S" <?php if($_POST[regalias]=='S') echo "SELECTED"?>>S</option>
						</select>    
					</td>
					<?php
					if($_POST[regalias]=='S'){
						echo'<td class="saludo1">Vigencia:</td>
						<td>
							<select name="vigenciarg" id="vigenciarg">';
								$sqlv="select * from dominios where nombre_dominio='VIGENCIA_RG' ORDER BY valor_inicial DESC";
								$resv = mysql_query($sqlv,$linkbd);
								while($wvig=mysql_fetch_array($resv)){
									echo'<option value="'.$wvig[0].' - '.$wvig[1].'">'.$wvig[0].' - '.$wvig[1].'</option>';
								}
							echo'</select>
						</td>';
					}
					?>
	
	</tr>                  
    </table>
	<?php 	
		if ($_POST[tipo]=='Auxiliar')
					 { $link=conectar_bd();
				?>
				<div class="subpantallac2" >
				<table class="inicio" width="99%">				
			    <tr >
			      <td height="35" colspan="8" class="titulos2" >C.G.R.</td>
			    </tr>
				<tr >
				  <td class="saludo1" >Cod 	:</td>
				  <td  ><select name="cgrclas" id="cgrclas" onChange="document.form2.submit();">
				  <option value="-1">Seleccione ....</option>
					<?php
					 $sqlr="Select * from pptosidefclas  where nivel='D'  AND LEFT(codigo,1)='1'order by codigo";
//			 echo $sqlr;
		 		$resp = mysql_query($sqlr,$link);
				while ($row =mysql_fetch_row($resp)) 
				{
				$i=$row[0];
				echo "<option value=$row[0] ";
				if($i==$_POST[cgrclas])
			 	{
				 echo "SELECTED";
				 $_POST[cgrclasnom]=$row[1];
				 }
				echo " >".$row[0]." - ".substr($row[1],0,50)."</option>";	  
			     }			
				?>
				  </select>
			      </td>
				  <td class="saludo1" >Codigo nombre:</td>
				  <td  ><input name="cgrclasnom" type="text" size="80" value="<?php echo $_POST[cgrclasnom]?>"></td></tr>
				  <tr>
				  <td class="saludo1" >Recurso	:</td>
				  <td  ><select name="cgrrecu" id="cgrrecu" onChange="document.form2.submit();">
				  <option value="-1">Seleccione ....</option>
					<?php
					 $sqlr="Select * from pptosidefrecursos  where estado='S' order by codigo";
//			 echo $sqlr;
		 		$resp = mysql_query($sqlr,$link);
				while ($row =mysql_fetch_row($resp)) 
				{
				$i=$row[0];
				echo "<option value=$row[0] ";
				if($i==$_POST[cgrrecu])
			 	{
				 echo "SELECTED";
				 $_POST[cgrrecunom]=$row[1];
				 }
				echo " >".$row[0]." - ".substr($row[1],0,50)."</option>";	  
			     }			
				?>
				  </select>
			      </td>
				  <td class="saludo1" >Recurso nombre:</td>
				  <td  ><input name="cgrrecunom" type="text" size="80" value="<?php echo $_POST[cgrrecunom]?>"></td>
			    </tr>
				<tr>
				  <td class="saludo1" >Origen:</td>
				  <td  ><select name="cgrorigen" id="cgrorigen" onChange="document.form2.submit();">
				  <option value="-1">Seleccione ....</option>
					<?php
					 $sqlr="Select * from pptosideforigen order by codigo";
//			 echo $sqlr;
		 		$resp = mysql_query($sqlr,$link);
				while ($row =mysql_fetch_row($resp)) 
				{
				$i=$row[0];
				echo "<option value=$row[0] ";
				if($i==$_POST[cgrorigen])
			 	{
				 echo "SELECTED";
				 $_POST[cgrorigennom]=$row[1];
				 }
				echo " >".$row[0]." - ".substr($row[1],0,50)."</option>";	  
			     }			
				?>
				  </select>
			      </td>
				  <td class="saludo1" >Origen nombre:</td>
				  <td  ><input name="cgrorigennom" type="text" size="80" value="<?php echo $_POST[cgrorigennom]?>"></td>
			    </tr>										
				<tr >
				  <td class="saludo1" >Destinacion:</td>
				  <td  ><select name="cgrdest" id="cgrdest" onChange="document.form2.submit();">
				  <option value="-1">Seleccione ....</option>
					<?php
					 $sqlr="Select * from pptosidefdestinacion  order by codigo";
//			 echo $sqlr;
		 		$resp = mysql_query($sqlr,$link);
				while ($row =mysql_fetch_row($resp)) 
				{
				$i=$row[0];
				echo "<option value=$row[0] ";
				if($i==$_POST[cgrdest])
			 	{
				 echo "SELECTED";
				 $_POST[cgrdestnom]=$row[1];
				 }
				echo " >".$row[0]." - ".substr($row[1],0,50)."</option>";	  
			     }			
				?>
				  </select>
			      </td>
				  <td class="saludo1" >Destinacion nombre:</td>
				  <td  ><input name="cgrdestnom" type="text" size="80" value="<?php echo $_POST[cgrdestnom]?>"></td></tr>
					<tr>
				  <td class="saludo1" >Tercero:</td>
				  <td  ><select name="cgrtercero" id="cgrtercero" onChange="document.form2.submit();">
				  <option value="-1">Seleccione ....</option>
					<?php
					 $sqlr="Select * from pptosidefterceros order by codigo";
//			 echo $sqlr;
		 		$resp = mysql_query($sqlr,$link);
				while ($row =mysql_fetch_row($resp)) 
				{
				$i=$row[0];
				echo "<option value=$row[0] ";
				if($i==$_POST[cgrtercero])
			 	{
				 echo "SELECTED";
				 $_POST[cgrterceronom]=$row[1];
				 }
				echo " >".$row[0]." - ".substr($row[1],0,50)."</option>";	  
			     }			
				?>
				  </select>
			      </td>
				  <td class="saludo1" >Tercero nombre:</td>
				  <td  ><input name="cgrterceronom" type="text" size="80" value="<?php echo $_POST[cgrterceronom]?>"></td>
			    </tr>
  				<tr>
				  <td class="saludo1" >Situacion Fondos:</td>
				  <td  ><select name="cgrsituacion" id="cgrsituacion" onChange="document.form2.submit();">
				  <option value="-1">Seleccione ....</option>
					<?php
					 $sqlr="Select * from pptosideffondos order by codigo";
//			 echo $sqlr;
		 		$resp = mysql_query($sqlr,$link);
				while ($row =mysql_fetch_row($resp)) 
				{
				$i=$row[0];
				echo "<option value=$row[0] ";
				if($i==$_POST[cgrsituacion])
			 	{
				 echo "SELECTED";
				 $_POST[cgrsituacionnom]=$row[1];
				 }
				echo " >".$row[0]." - ".substr($row[1],0,50)."</option>";	  
			     }			
				?>
				  </select>
			      </td>
				  <td class="saludo1" >Situacion Fondos nombre:</td>
				  <td  ><input name="cgrsituacionnom" type="text" size="80" value="<?php echo $_POST[cgrsituacionnom]?>"></td>
			    </tr>								  			
			</table>			
				<table class="inicio" width="99%">				
			    <tr >
			      <td height="25" colspan="4" class="titulos2" >F.U.T.</td>
			    </tr>
				<tr >
				  <td class="saludo1" >Cod 	:</td>
				  <td  ><select name="futcoding" id="futcoding" onChange="document.form2.submit();">
				  <option value="-1">Seleccione ....</option>
					<?php
					 $sqlr="Select * from pptofutcoding  order by codigo";
//			 echo $sqlr;
		 		$resp = mysql_query($sqlr,$link);
				while ($row =mysql_fetch_row($resp)) 
				{
				$i=$row[0];
				echo "<option value=$row[0] ";
				if($i==$_POST[futcoding])
			 	{
				 echo "SELECTED";
				 $_POST[futcodingnom]=$row[1];
				 }
				echo " >".$row[0]." - ".substr($row[1],0,50)."</option>";	  
			     }			
				?>
				  </select>
			      </td>
				  <td class="saludo1" >Cod nombre:</td>
				  <td  ><input name="futcodingnom" type="text" size="80" value="<?php echo $_POST[futcodingnom]?>"></td>
			    </tr>				
				<tr >
				  <td class="saludo1" >Situacion de Fondos:</td>
				  <td  ><select name="situacion" id="situacion" onChange="document.form2.submit();">
				  <option value="-1">Seleccione ....</option>
				  <option value="C" <?php if($_POST[situacion]=='C') echo "SELECTED"?>>Con Situacion</option>
  				  <option value="S" <?php if($_POST[situacion]=='S') echo "SELECTED"?>>Sin Situacion</option>
				  </select>
			      </td>
			    </tr>													
  			</table>
			</div>
			<?php 	
}
	

//}	 ?>
	
	
	
	
    </form>
  <?php
$oculto=$_POST['oculto'];

if($_POST[oculto]==2)
{
	$fec=date("d/m/Y");
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $fec,$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];	
	
 ?>

<script>
	document.form2.oculto.value=1;
	document.form2.descripcion.value="";
	document.form2.cuenta.value="";
</script>
<?php

$linkbd=conectar_bd();
if ($_POST[cuenta]!="" and $_POST[descripcion]!="")
{
	if($_POST[regalias]=='S'){
		$arrvig=explode('-',$_POST[vigenciarg]);
		$vigi=trim($arrvig[0]);
		$vigf=trim($arrvig[1]);
	}
	else{
		$vigi=$vigusu;
		$vigf=$vigusu;
	}
	if(strlen($_POST[cuenta])>1){
		for($i=0;$i<strlen($_POST[cuenta]);$i++){
			$nuevacuenta=substr($_POST[cuenta],0,strlen($_POST[cuenta])-$i);
			$sql="SELECT posicion  FROM  pptocuentas_pos  WHERE cuentapos LIKE  '".$nuevacuenta."%' AND vigencia=$vigusu  AND entidad='interna' ORDER BY cuentapos DESC  LIMIT 0 , 1";
			$result=mysql_query($sql,$linkbd);
			$filas=mysql_num_rows($result);
			if($filas==1){
				$row=mysql_fetch_row($result);
				$inserta="INSERT INTO pptocuentas_pos(posicion,cuentapos,tipo,vigencia,entidad) VALUES ($row[0],'$_POST[cuenta]','ingresos',$vigusu,'externa')";
				mysql_query($inserta,$linkbd);
				break;
			}
			
		}
		
	}else{
		$sql="SELECT posicion  FROM  pptocuentas_pos  WHERE cuentapos LIKE  '".$_POST[cuenta]."%' AND vigencia=$vigusu AND entidad='interna' ORDER BY cuentapos DESC  LIMIT 0 , 1";
		$result=mysql_query($sql,$linkbd);
		$row=mysql_fetch_row($result);
		$inserta="INSERT INTO pptocuentas_pos(posicion,cuentapos,tipo,vigencia,entidad) VALUES ($row[0],'$_POST[cuenta]','ingresos',$vigusu,'externa')";
		mysql_query($inserta,$linkbd);
	}
$sqlr="INSERT INTO pptocuentasentidades (cuenta,nombre,tipo,estado,sidefclas,sidefrecur,sideftercero,sidefdest,futcoding,codconficontable,futsituacion,vigencia,nomina,vigenciaf, pptoinicial,clasificacion, regalias, vigenciarg) VALUES ('".strtoupper($_POST[cuenta])."','".utf8_decode($_POST[descripcion])."','$_POST[tipo]','S','$_POST[cgrclas]','$_POST[cgrrecu]','$_POST[cgrtercero]','$_POST[cgrdest]','$_POST[futcoding]','$_POST[concecont]','$_POST[situacion]','".$vigi."','N','".$vigf."', 0,'$_POST[clasificacion]','$_POST[regalias]','$_POST[vigenciarg]')";

  if (!mysql_query($sqlr,$linkbd))
	{
	 echo "<table><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
	 echo "Ocurrió el siguiente problema:<br>";
  	 echo "<pre>";
     echo "</pre></center></td></tr></table>";
	}
  else
  {
	  if($_POST[tipo]=='Auxiliar')
	   {
		// $sqlr="INSERT INTO pptocuentasentidadespptoinicial (cuenta,fecha,vigencia,valor,estado, pptodef, saldos, saldoscdprp, id_acuerdo, cxp, ingresos,pagos) values ('".strtoupper($_POST[cuenta])."','$fechaf','$vigusu',0,'S',0,0,0,0,0,0,0)";
		 //mysql_query($sqlr,$linkbd);
		 		 
		 $sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) values('".$_POST[cuenta]."','','PPTO INICIAL(CUENTA CREADA MANUALMENTE)',0,0,1,'$vigusu',1,'$vigusu')";
	 	 mysql_query($sqlr,$linkbd); 
		// echo $sqlr;
		}
  echo "<script>despliegamodalm('visible','1','Se ha Almacenado la Cuenta con Exito');</script>";
  }
 }
else

echo "<table class='inicio'><tr><td class='saludo1'><center>Falta informacion para Crear la Cuenta</center></td></tr></table>";

	
}
 
			if($_POST[bc]=='1')
			 {
				 $r1='';
			 	$dig=substr($_POST[cuenta],0,1);
					if($dig=='R' || $dig=='r')
					 {
					$cant=strlen($_POST[cuenta])-1;	
					$r1=substr($_POST[cuenta],1,1);
					$ini=1;							  
					 }
					 else
					 {
					$cant=strlen($_POST[cuenta]);
					$r1=1;
					$ini=0;					
					 }	
					 				
					$nresul=existecuentain($_POST[cuenta]);
			  				if($nresul!='')
			   					{		  
  			  					?>
			  					<script> res="<?php echo $nresul ?>";
			   					alert("Esta cuenta ya existe su descripcion es "+res);
			   					document.form2.cuenta.focus();
			  					document.getElementById('cuenta').focus();document.getElementById('cuenta').select();</script>
			  					<?php
			  					}
			 				/*
							else
			 					{
								if($cant>1)
			 						{
			  							$linkbd=conectar_bd();
										$sqlr="select *from nivelesctasing where posiciones=$cant";
			  							$res=mysql_query($sqlr,$linkbd);
			  							$con=mysql_fetch_row($res);									
										$ncuen=substr($_POST[cuenta],'0',$cant-$con[1]-$ini);
										$resultado=existecuentain($ncuen);
										if($resultado!='')
											{ 
												
												$ncuen=substr($_POST[cuenta],'0',$cant-$con[1]-$ini);
												$stipo=mayaux($ncuen);																								
												if ($stipo=='Mayor')
												{
												?>
												<script>
												document.form2.descripcion.focus(); </script>
												<?php }
												else
												{
													?>	<script> alert("La anterior cuenta es auxiliar... No se puede crear otra ");
													document.form2.cuenta.focus();
													</script><?php
			  									}
							
											}
					
										else
											{?>	<script> alert("Error cantidad de digitos");
												document.form2.cuenta.focus();
												</script><?php
											}
								} 
							}
							*/
			 		//		else
					//		{	?>
			  				<script>
			  		//		  alert("No existe cuenta mayor para crear esta cuenta");</script>
			   				<?php	//}
						//}
			//			else
				//		{	
					?>
			  				<script>
			  //				  document.form2.tipo.value='Mayor';
			   //				  document.form2.descripcion.focus();</script>	
							<?php									
			 }
?>			 
</td></tr>
<tr><td></td></tr>      
</table>
</body>
</html>