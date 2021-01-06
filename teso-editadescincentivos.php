<?php //V 1000 12/12/16 ?> 
<?php
require"comun.inc";
require"funciones.inc";
session_start();
cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
//**niveles menu: Administracion (0) - Consultas (1) - Herramientas (2) - Reportes (3)
 	$linkbd=conectar_bd();
	$scroll=$_GET['scrtop'];
	$totreg=$_GET['totreg'];
	$idcta=$_GET['idcta'];
	$altura=$_GET['altura'];
	$filtro="'".$_GET['filtro']."'";
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<title>:: SPID- Tesoreria</title>
<script>
	function buscacta(e){
		if (document.form2.cuenta.value!=""){
			document.form2.bc.value='1';
			document.getElementById('oculto').value='7';
			document.form2.submit();
		}
	}

	function validar(){
		document.getElementById('oculto').value='7';
		document.form2.submit();
	}

	function guardar(){
		if (document.form2.nombre.value!=''&& document.form2.ingreso.value!='' && document.form2.cuenta.value!='' && document.form2.codigo.value!=''){
			despliegamodalm('visible','4','Esta Seguro de Guardar los Cambios','1');
		}
		else{
			despliegamodalm('visible','2','Faltan datos para Modificar los Datos');
			document.form2.nombre.focus();document.form2.nombre.select();
		}
	}

	function despliegamodalm(_valor,_tip,mensa,pregunta){
		document.getElementById("bgventanamodalm").style.visibility=_valor;
		if(_valor=="hidden"){document.getElementById('ventanam').src="";}
		else{
			switch(_tip){
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

	function funcionmensaje(){}

	function respuestaconsulta(pregunta){
		switch(pregunta){
			case "1":	document.getElementById('oculto').value='2';document.form2.submit();break;
		}
	}

</script>
<script src="css/programas.js"></script>
<script src="css/calendario.js"></script>
<link href="css/css2.css" rel="stylesheet" type="text/css" />
<link href="css/css3.css" rel="stylesheet" type="text/css" />
		<script>
			function adelante(scrtop, numpag, limreg, filtro, next){
				var maximo=document.getElementById('maximo').value;
				var actual=document.getElementById('id').value;
				if(parseFloat(maximo)>parseFloat(actual)){
					document.getElementById('oculto').value='1';
					document.getElementById('id').value=next;
					var idcta=document.getElementById('id').value;
					document.form2.action="teso-editadescincentivos.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
					document.form2.submit();
				}
			}
		
			function atrasc(scrtop, numpag, limreg, filtro, prev){
				var minimo=document.getElementById('minimo').value;
				var actual=document.getElementById('id').value;
				if(parseFloat(minimo)<parseFloat(actual)){
					document.getElementById('oculto').value='1';
					document.getElementById('id').value=prev;
					var idcta=document.getElementById('id').value;
					document.form2.action="teso-editadescincentivos.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
					document.form2.submit();
				}
			}
		
			function iratras(scrtop, numpag, limreg, filtro){
				var idcta=document.getElementById('id').value;
				location.href="teso-buscadescincentivos.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
			}
		</script>
<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
        <?php
		$numpag=$_GET[numpag];
		$limreg=$_GET[limreg];
		$scrtop=26*$totreg;
		?>
	<table>
		<tr>
			<script>barra_imagenes("teso");</script>
			<?php cuadro_titulos();?>
		</tr>	 
		<tr><?php menu_desplegable("teso");?></tr>
		<tr>
		  	<td colspan="3" class="cinta">
			  	<a href="teso-descincentivos.php" class="mgbt"><img src="imagenes/add.png" alt="Nuevo"  border="0" title="Nuevo"/></a>
			  	<a href="#"  onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png"  alt="Guardar" title="Guardar"/></a>
			  	<a href="teso-buscadescincentivos.php" class="mgbt"> <img src="imagenes/busca.png"  alt="Buscar" title="Buscar"/></a>
			  	<a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana" title="Nueva ventana"></a>
			  	<a href="#" onClick="iratras(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>)" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
		  	</td>
		</tr>		  
	</table>
		<tr>	
			<td colspan="3" class="tablaprin" align="center"> 
			<?php
				$linkbd=conectar_bd();
				if ($_GET[is]!=""){echo "<script>document.getElementById('codrec').value=$_GET[is];</script>";}
				$sqlr="select MIN(tesodescuentoincentivo.id), MAX(tesodescuentoincentivo.id) from tesodescuentoincentivo,tesoingresos where tesodescuentoincentivo.ingreso=tesoingresos.codigo and tesoingresos.tipo='C' ORDER BY tesodescuentoincentivo.id";
				$res=mysql_query($sqlr,$linkbd);
				$r=mysql_fetch_row($res);
				$_POST[minimo]=$r[0];
				$_POST[maximo]=$r[1];
				if($_POST[oculto]==""){
					if ($_POST[codrec]!="" || $_GET[is]!=""){
						if($_POST[codrec]!=""){
							$sqlr="select *from tesodescuentoincentivo,tesoingresos where tesodescuentoincentivo.ingreso=tesoingresos.codigo and tesoingresos.tipo='C' and tesodescuentoincentivo.id='$_POST[codrec]'";
						}
						else{
							$sqlr="select *from tesodescuentoincentivo,tesoingresos where tesodescuentoincentivo.ingreso=tesoingresos.codigo and tesoingresos.tipo='C' and tesodescuentoincentivo.id ='$_GET[is]'";
						}
					}
					else{
						$sqlr="select *from tesodescuentoincentivo,tesoingresos where tesodescuentoincentivo.ingreso=tesoingresos.codigo and tesoingresos.tipo='C' ORDER BY tesodescuentoincentivo.id DESC";
					}
					$res=mysql_query($sqlr,$linkbd);
					$row=mysql_fetch_row($res);
				   	$_POST[id]=$row[0];
				}
			
	 			if(($_POST[oculto]!="2")&&($_POST[oculto]!="7")){	
					$sqlr="select *from tesodescuentoincentivo,tesoingresos where tesodescuentoincentivo.ingreso=tesoingresos.codigo and tesoingresos.tipo='C' and tesodescuentoincentivo.id=$_POST[id]";
					$res=mysql_query($sqlr,$linkbd);
		
					$cont=0;
				while ($row =mysql_fetch_row($res)) 
			 	{	$_POST[codigo]=$row[14];
					$_POST[nombre]=$row[15];
					$_POST[ingreso]=$row[16];
					$_POST[fecha1]=$row[8];
					$_POST[fecha2]=$row[10];
					$_POST[fecha3]=$row[12];
				 	ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha1],$fecha);
					$_POST[fecha1]=$fecha[3]."/".$fecha[2]."/".$fecha[1]; 
					ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha2],$fecha);
					$_POST[fecha2]=$fecha[3]."/".$fecha[2]."/".$fecha[1]; 
				 	ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha3],$fecha);
					$_POST[fecha3]=$fecha[3]."/".$fecha[2]."/".$fecha[1]; 
				
					$_POST[porcentaje1]=$row[2];
					$_POST[porcentaje2]=$row[3];
					$_POST[porcentaje3]=$row[4];		 		  			 
					$_POST[cuenta]=$row[13];
					$_POST[ncuenta]=buscacuenta($_POST[cuenta]);
					$_POST[vigencia]=$row[6];
			?>
			<script>
				document.form2.cuenta.focus();
				document.form2.cuenta.select();
			</script>
			<?php 	
					$cont=$cont+1;
	
				}
			}

				//NEXT
				$sqln="select *from tesodescuentoincentivo,tesoingresos where tesodescuentoincentivo.ingreso=tesoingresos.codigo and tesoingresos.tipo='C' and tesodescuentoincentivo.id > '$_POST[id]' ORDER BY tesodescuentoincentivo.id ASC LIMIT 1";
				$resn=mysql_query($sqln,$linkbd);
				$row=mysql_fetch_row($resn);
				$next="'".$row[0]."'";
				//PREV
				$sqlp="select *from tesodescuentoincentivo,tesoingresos where tesodescuentoincentivo.ingreso=tesoingresos.codigo and tesoingresos.tipo='C' and tesodescuentoincentivo.id < '$_POST[id]' ORDER BY tesodescuentoincentivo.id DESC LIMIT 1";
				$resp=mysql_query($sqlp,$linkbd);
				$row=mysql_fetch_row($resp);
				$prev="'".$row[0]."'";

			?>

		<div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
 		<form name="form2" method="post" action="">
 			<?php //**** busca cuenta
  				if($_POST[bc]!='')
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
			 
			 ?>
 
		    <table class="inicio" align="center" >
		      	<tr >
		        	<td class="titulos" colspan="6">Descuento Incentivo</td>
		        	<td width="84" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
		      	</tr>
		      	<tr  >
			  		<td  class="saludo1">Codigo: </td>
		        	<td style="width:8%;">
			        	<a href="#" onClick="atrasc(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $prev; ?>)">
			        		<img src="imagenes/back.png" alt="anterior" align="absmiddle">
			        	</a> 
		        		<input name="codigo" id="codigo" type="text" value="<?php echo $_POST[codigo]?>" maxlength="2" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" style="width:45%;">
						<a href="#" onClick="adelante(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $next; ?>)">
							<img src="imagenes/next.png" alt="siguiente" align="absmiddle">
						</a> 
						<input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo" id="maximo">
						<input type="hidden" value="<?php echo $_POST[minimo]?>" name="minimo" id="minimo">
						<input type="hidden" value="<?php echo $_POST[codrec]?>" name="codrec" id="codrec">
		       		</td>
		        	<td  class="saludo1">Nombre:        </td>
		        	<td style="width:30%;">
		        		<input name="nombre" type="text" value="<?php echo $_POST[nombre]?>"  onKeyUp="return tabular(event,this)" style="width:95%;">        
		        	</td>
					<td  class="saludo1" >Ingreso:   </td>
					<td style="width:40%;">        
						<select name="ingreso"   onKeyUp="return tabular(event,this)" style="width:100%;">
							<option value="">Seleccione....</option>
								<?php
									$linkbd=conectar_bd();
									$sqlr="select *from tesoingresos where estado='S'";
									$res=mysql_query($sqlr,$linkbd);
									while ($row =mysql_fetch_row($res)) 
									{
										echo "<option value=$row[0] ";
										$i=$row[0];
										if($i==$_POST[ingreso])
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
	  
	   		<table width="100%" class="inicio">
	   			<tr>
	     			<td colspan="6" class="titulos">Cuenta Contable </td>
	   			</tr>                  
				<tr>
					<td  class="saludo1" style="width:8%;">Cuenta Contable: </td>
          			<td colspan="2"  valign="middle"  style="width:14%;">
          				<input type="text" id="cuenta" name="cuenta"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="buscacta(event)" value="<?php echo $_POST[cuenta]?>" onClick="document.getElementById('cuenta').focus();document.getElementById('cuenta').select();" >
          				<input type="hidden" value="0" name="bc">
          				<a href="#" onClick="mypop=window.open('cuentas-ventana.php','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();">
          					<img src="imagenes/buscarep.png" align="absmiddle" border="0">
          				</a>  
          			</td>
          			<td  style="width:20%;">
          				<input name="ncuenta" type="text" value="<?php echo $_POST[ncuenta]?>" style="width:100%;" readonly>
          			</td>
		  			<td class="saludo1" style="width:5%;">Vigencia:</td>
		  			<td >
		  				<input name="vigencia" type="text" value="<?php echo $_POST[vigencia]?>" style="width:8%;" readonly>
		  			</td>
		  		</tr>
		  	</table>
		 	<table class="inicio">
		 		<tr>
		 			<td class="titulos" colspan="4">Fechas y Valores</td>
		 		</tr>
				<tr>
					<td style="width:8%;" class="saludo1">Fecha Limite 1:</td>
					<td style="width:14%;">
						<input name="fecha1" type="text" id="fc_1198971545" title="DD/MM/YYYY"  value="<?php echo $_POST[fecha1]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">
		  				<a href="#" onClick="displayCalendarFor('fc_1198971545');">
		  					<img src="imagenes/buscarep.png" align="absmiddle" border="0">
		  				</a> 
		  			</td>
					<td style="width:6%;" class="saludo1">Porcentaje:</td>
					<td >
						<input id="porcentaje1" name="porcentaje1" type="text" style="width:5%;" value="<?php echo $_POST[porcentaje1]?>" onKeyUp="return tabular(event,this)"  onKeyPress="javascript:return solonumeros(event)" > % 
					</td>
				</tr>
				<tr>
					<td style="width:8%;"class="saludo1">Fecha Limite 2:</td>
					<td style="width:14%;">
						<input name="fecha2" type="text" id="fc_1198971546" title="DD/MM/YYYY"  value="<?php echo $_POST[fecha2]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">         
						<a href="#" onClick="displayCalendarFor('fc_1198971546');">
							<img src="imagenes/buscarep.png" align="absmiddle" border="0">
						</a> 
					</td>
					<td style="width:6%;" class="saludo1">Porcentaje:</td>
					<td	>
						<input id="porcentaje2" name="porcentaje2" type="text" style="width:5%;" value="<?php echo $_POST[porcentaje2]?>" onKeyUp="return tabular(event,this)"  onKeyPress="javascript:return solonumeros(event)" > % 
					</td>
				</tr>
				<tr>
				  	<td style="width:8%;" class="saludo1">Fecha Limite 3:</td>
				  	<td style="width:14%;">
				  		<input name="fecha3" type="text" id="fc_1198971547" title="DD/MM/YYYY"  value="<?php echo $_POST[fecha3]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">         
				  		<a href="#" onClick="displayCalendarFor('fc_1198971547');">
				  			<img src="imagenes/buscarep.png" align="absmiddle" border="0">
				  		</a> 
				  	</td>
				  	<td style="width:6%;" class="saludo1">Porcentaje:</td>
				  	<td >
				  		<input id="porcentaje3" name="porcentaje3" type="text" style="width:5%;" value="<?php echo $_POST[porcentaje3]?>" onKeyUp="return tabular(event,this)"  onKeyPress="javascript:return solonumeros(event)"> 
				  		<input name="id" id="id" type="hidden" value="<?php echo $_POST[id]?>">
				  		<input name="oculto" id="oculto" type="hidden" value="1"> %
				  	</td>
				</tr>
    		</table>
	
    </form>
  <?php
$oculto=$_POST['oculto'];
if($_POST[oculto]=='2')
{
$linkbd=conectar_bd();

if ($_POST[nombre]!="" and $_POST[codigo]!="" and $_POST[ingreso] )
 {
 $a=date(Y);
 $fecini=$a."-01-01";
 ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha1],$fecha);
	$fechaf1=$fecha[3]."-".$fecha[2]."-".$fecha[1]; 

ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
	$fechaf2=$fecha[3]."-".$fecha[2]."-".$fecha[1]; 
ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha3],$fecha);
	$fechaf3=$fecha[3]."-".$fecha[2]."-".$fecha[1]; 

  
 $nr="1";
 
$sqlr="update tesodescuentoincentivo set ingreso='$_POST[ingreso]',valordesc1='$_POST[porcentaje1]',valordesc2='$_POST[porcentaje2]',valordesc3='$_POST[porcentaje3]',estado='S',fechaini1='$fecini',fechaini2='$fechaf1',fechaini3='$fechaf2',fechafin1='$fechaf1',fechafin2='$fechaf2',fechafin3='$fechaf3',cuenta='$_POST[cuenta]',codigo='$_POST[codigo]',nombre='$_POST[nombre]' where tesodescuentoincentivo.id='$_POST[id]'";
 


  if (!mysql_query($sqlr,$linkbd))
	{
	 echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petici�n: <br><font color=red><b>$sqlr</b></font></p>";
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
  echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado con Exito</center></td></tr></table>";
  }
 }
else
 {
  echo "<table class='inicio'><tr><td class='saludo1'><center>Falta informacion para Crear el Centro Costo</center></td></tr></table>";
 }
}
?> </td></tr>
     
</table>
</body>
</html>