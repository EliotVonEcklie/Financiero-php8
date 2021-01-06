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
        <script src="css/programas.js"></script>
		<script>
			function despliegamodal2(_valor)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else {document.getElementById('ventana2').src="catastral-ventana01.php";}
			}
			function validar()
			{
				var x = document.getElementById("tipop").value;
				document.form2.codigo.value=x;
				document.form2.submit();
			}
			function guardar()
			{
				if (document.form2.tipop.value!='')
  				{
					if (confirm("Esta Seguro de Guardar")){document.form2.oculto.value=2;document.form2.submit();}
  				}
  				else
				{
  					alert('Faltan datos para completar el registro');
					document.form2.tercero.focus();
					document.form2.tercero.select();
  				}
			}
			function buscater(e){if (document.form2.tercero.value!=""){document.form2.bt.value='1';document.form2.submit();}}
			function buscar(){document.form2.buscav.value='1';document.form2.submit();}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventanam').src="";}
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
			function funcionmensaje(){document.location.href = "teso-estratificacion.php";}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":
						document.form2.oculto.value="2";
						document.form2.submit();
						break;
				}
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
  				<td colspan="3" class="cinta">
				<a href="teso-estratificacion.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a> 
				<a href="#"  onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a> 
				<a href="teso-estratificacionbuscar.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a> 
				<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
				<a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a> 
				<a href="teso-gestionpredial.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a></td>
			</tr>		  
		</table>
		<div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div> 
        <form  name="form2" method="post" action="">
			<?php
			$sqlr="SELECT valor_inicial,valor_final,tipo FROM dominios WHERE nombre_dominio='COBRO_ALUMBRADO' AND  tipo='S'";
			$res=mysql_query($sqlr,$linkbd);
			while ($row =mysql_fetch_row($res)) 
			{
				$_POST[cobroalumbrado]=$row[0];
				$_POST[vcobroalumbrado]=$row[1];
				$_POST[tcobroalumbrado]=$row[2];
			}
			function obtenerTipoPredio($catastral){
				$tipo="";
				$digitos=substr($catastral,0,2);
				if($digitos=="01"){
					$tipo="urbano";
				}else{
					$tipo="rural";
				}
				return $tipo;
			}
			
                $vigencia=date(Y);
                if(!$_POST[oculto])
                {
                    $fec=date("d/m/Y");
                    $_POST[fecha]=$fec; 	
                    $_POST[valoradicion]=0;
                    $_POST[valorreduccion]=0;
                    $_POST[valortraslados]=0;		 		  			 
                    $_POST[valor]=0;		 
                }
                if ($_POST[chacuerdo]=='2')
                {
                    $_POST[dcuentas]=array();
                    $_POST[dncuetas]=array();
                    $_POST[dingresos]=array();
                    $_POST[dgastos]=array();
                    $_POST[diferencia]=0;
                    $_POST[cuentagas]=0;
                    $_POST[cuentaing]=0;																			
                }	
				if($_POST[bt]=='1')
			 	{
					$nresul=buscatercero($_POST[tercero]);
				  	if($nresul!=''){$_POST[ntercero]=$nresul;}
			 		else{$_POST[ntercero]="";}
			 	}
				if($_POST[buscav]=='1')
 				{
					$_POST[dcuentas]=array();
				 	$_POST[dncuentas]=array();
				 	$_POST[dtcuentas]=array();		 
				 	$_POST[dvalores]=array();
	 				$sqlr="select *from tesopredios where cedulacatastral=".$_POST[codcat]." ";
					//echo $sqlr;
	 				$res=mysql_query($sqlr,$linkbd);
	 				while($row=mysql_fetch_row($res))
	  				{
						$_POST[catastral]=$row[0];
					  	$_POST[propietario]=$row[6];
					  	$_POST[documento]=$row[5];
					  	$_POST[direccion]=$row[7];
					  	$_POST[ha]=$row[8];
					  	$_POST[mt2]=$row[9];
					  	$_POST[areac]=$row[10];
					  	$_POST[avaluo]=number_format($row[11],2);
						$_POST[codigo]=$row[15];
					  	$_POST[tipop]=$row[15];
						$_POST[nestrato]=$row[16];
					  	//if($_POST[tipop]=='urbano'){$_POST[estrato]=$row[16];}
						$_POST[rangos]=$row[16];
						$_POST[dtcuentas][]=$row[1];		 
						$_POST[dvalores][]=$row[5];
						$_POST[buscav]="";
						$_POST[vigencia]=$row[12];
	  				}
  				}
			?>
    			<table class="inicio" align="center" >
      				<tr>
        				<td class="titulos" colspan="3" style='width:93%'>.: Estratificar Predios</td>
                        <td width="72" class="cerrar" style='width:7%'><a href="teso-principal.php">Cerrar</a></td>
      				</tr>
	  				<tr> 
                    	<td width="8%" class="saludo1">C&oacute;digo Catastral:</td>
          				<td width="50%" ><input id="codcat" type="text" name="codcat"  onKeyUp="return tabular(event,this)" onBlur="buscar(event)" value="<?php echo $_POST[codcat]?>" onClick="document.getElementById('tercero').focus();document.getElementById('tercero').select();"><input type="hidden" value="0" name="bt"> <input type="hidden" name="chacuerdo" value="1"><input type="hidden" value="1" name="oculto"> <input type="hidden" value="<?php echo $_POST[buscav]?>" name="buscav">&nbsp;<a title="Listado de Predios" onClick="despliegamodal2('visible');" style="cursor:pointer;"><img src="imagenes/find02.png" style="width:20px;"/></a>&nbsp;</td>
					
						
						
        			</tr>
	  			</table>
				<input  type="hidden" name="ord"   value="<?php echo $_POST[ord]?>" ><input type="hidden" name="tot"  value="<?php echo $_POST[tot]?>" >
	  			<table class="inicio">
	  				<tr><td class="titulos" colspan=11">Informaci&oacute;n Predio</td></tr>
	  				<tr>
	  					<td  class="saludo1" style="width: 10%">C&oacute;digo Catastral:</td>
	  					<td style="width:10%;"><input type="hidden" value="<?php echo $_POST[nbanco]?>" name="nbanco"> <input name="catastral" type="text" id="catastral" onBlur="buscater(event)" onClick="document.getElementById('tercero').focus();document.getElementById('tercero').select();" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[catastral]?>"  readonly></td>
		 				<td  class="saludo1" style="width:10%;">Avaluo:</td>
	  					<td style="width:10%;"><input name="avaluo" type="text" id="avaluo" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[avaluo]?>" style="width:100%;" readonly></td>
						<td class="saludo1">Tipo:</td>
			  <td ><select name="tipop" onChange="validar();" id="tipop" value="<?php echo $_POST[tipop]; ?>">
			   <option value="">Seleccione ...</option>
				<?php
						$linkbd=conectar_bd();
						$sql="SELECT codigo,nombre FROM teso_clasificapredios WHERE vigencia='$_POST[vigencia]' GROUP BY codigo,nombre";
		
						$result=mysql_query($sql,$linkbd);
						$check="";
						if(isset($_POST[codigo])){
							if(!empty($_POST[codigo])){
							$check="SELECTED";
							}
						}
						while($row = mysql_fetch_array($result)){
							if(!empty($check)){
								if($row[0]==$_POST[codigo]){
									echo "<option value='$row[0]' $check >$row[1]</option>";
								}else{
									echo "<option value='$row[0]'>$row[1]</option>";
								}
							}else{
								echo "<option value='$row[0]'>$row[1]</option>";
							}
						}
					
					?>
				</select>
				<input type="hidden" name='codigo' id="codigo" value="<?php echo $_POST[codigo]; ?>" />
				</td>
				
			<?php
				if($_POST[tipop]!=''){
					$sql="SELECT COUNT(IF(avaluo_fijo = 'A',1,NULL)) CONT1,COUNT(IF(avaluo_fijo = 'F',1,NULL)) CONT2, avaluo_fijo FROM teso_clasificapredios WHERE codigo=$_POST[tipop] AND avaluo_fijo<>'' ";
					//echo $sql;
					$result=mysql_query($sql,$linkbd);
					$num=mysql_num_rows($result);
					if($num>0){
						$row = mysql_fetch_row($result);
						if($row[0]==0 && $row[1]>0){
							echo "<td class='saludo1' width='10%'>Rango Avaluo:</td>";
							echo "<td width='20%'>";
							echo "<select name='rangos' style='width: 100%'>";
							echo "<option value='' > Seleccione...</option>";
							$sqlr="SELECT consecutivo,nom_rango FROM teso_clasificapredios WHERE codigo=$_POST[tipop] AND estado='S' AND vigencia='$_POST[vigencia]'";
							$res=mysql_query($sqlr,$linkbd);
							while ($row = mysql_fetch_row($res)){
								if($row[0]==$_POST[rangos])
								{
									echo "<option value='$row[0]' $check>$row[1]</option>";
								}
								else
								{
									echo "<option value='$row[0]' >$row[1]</option>";
								}
							}
							echo "</select>";
							echo "</td>";
						}else if($row[0]>0 && $row[1]==0){
							echo "<td width='10%' ></td><td width='20%'></td>";
						}else if($row[0]>0 && $row[1]>0){
							echo "<td class='saludo1' width='10%'>Rango Avaluo:</td>";
							echo "<td width='20%'>";
							echo "<select name='rangos' style='width: 100%'>";
							echo "<option value='' > Seleccione...</option>";
							if($row[2]==$_POST[rangos])
							{
								echo "<option value='A' $check>POR AVALUO</option>";
							}
							else
							{
								echo "<option value='A' >POR AVALUO</option>";
							}
							$sqlr="SELECT consecutivo,nom_rango FROM teso_clasificapredios WHERE codigo=$_POST[tipop] AND estado='S' AND avaluo_fijo='F' AND vigencia='$_POST[vigencia]'";
							$res=mysql_query($sqlr,$linkbd);
							while ($row = mysql_fetch_row($res)){
								if($row[0]==$_POST[rangos])
								{
									echo "<option value='$row[0]' $check>$row[1]</option>";
								}
								else
								{
									echo "<option value='$row[0]' >$row[1]</option>";
								}
							}
							echo "</select>";
							echo "</td>";
						}
						
					}
					if($_POST[tipop]=='1' && $_POST[cobroalumbrado]=='S')
					{
						echo "<td class='saludo1' width='5%'>Cobra Alumbrado: </td>";
						echo "<td>";
						echo "<select width='10%' name='alumbrado' id='alumbrado'> ";
							if($_POST[cobroAlumbrado] == 'S')
								echo "<option value='S' SELECTED>Aplicar Cobro (S)</option>";
							if($_POST[cobroAlumbrado] == 'N')
								echo "<option value='N' SELECTED>No Aplicar (N)</option>";
						echo "</select> ";
						echo "</td>";
						echo "<td width='20%'></td>";
					}
				}else{
					echo "<td width='10%' ></td><td width='20%'></td>";
				}
			?>
      				</tr>
      				<tr>	    
		 				<td  class="saludo1">Documento:</td>         
	  					<td><input name="documento" type="text" id="documento" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[documento]?>"  readonly></td>
      					<td class="saludo1">Propietario:</td>
	  					<td  colspan="5"><input type="hidden" value="<?php echo $_POST[nbanco]?>" name="nbanco"> <input name="propietario" type="text" id="propietario" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[propietario]?>" style="width:100%;" readonly></td>
      				</tr>
      				<tr>
	  					<td  class="saludo1">Direcci&oacute;n:</td>
	  					<td ><input type="hidden" value="<?php echo $_POST[nbanco]?>" name="nbanco"> <input name="direccion" type="text" id="direccion" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[direccion]?>"  readonly></td>
			   
						<td  class="saludo1">Ha:</td>
	  					<td ><input name="ha" type="text" id="ha" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[ha]?>" style="width:100%;" readonly></td>
                     	<td  class="saludo1">Mt2:</td>
                     	<td ><input name="mt2" type="text" id="mt2" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[mt2]?>" style="width:100%;" readonly></td>
                  		<td  class="saludo1">Area Cons:</td>
                  		<td ><input name="areac" type="text" id="areac" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[areac]?>" style="width:56.5%;" readonly>
						<input name="vigencia" type="hidden" id="vigencia" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[vigencia]?>" style="width:100%;" readonly>
						</td>
						<td style="width:17%;"> </td>
      				</tr>
	  				
      </table>
	   
	  <?php
	 
if($_POST[oculto]=='2')
{
	$linkbd=conectar_bd();
 	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	$sql="SELECT COUNT(IF(avaluo_fijo = 'A',1,NULL)) CONT1,COUNT(IF(avaluo_fijo = 'F',1,NULL)) CONT2 FROM teso_clasificapredios WHERE codigo=$_POST[tipop] AND avaluo_fijo<>''";
	$result=mysql_query($sql,$linkbd);
	$row = mysql_fetch_array($result);
	//************** modificacion del presupuesto **************
	$estrato="";
	
	if(($row[0]==0 && $row[1]!=0) || ($row[0]!=0 && $row[1]!=0) ){
		/*if($_POST[rangos]!='A'){
			$estrato=$_POST[rangos];
		}
		else
		{
			$estrato=1;
		}*/
		$estrato=$_POST[rangos];
	}
	if($_POST[alumbrado])
	{
		$scrit1 = ", alumbrado='$_POST[alumbrado]'";
	}
		$sqlr="update tesopredios set tipopredio='".obtenerTipoPredio($_POST[catastral])."',clasifica='".$_POST[tipop]."', estratos='".$estrato."', documento='$_POST[documento]' $scrit1 where cedulacatastral=".$_POST[catastral];	
	if (!mysql_query($sqlr,$linkbd))
	{
	 echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue><img src='imagenes\alert.png'> Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petici�n: <br><font color=red><b>$sqlr</b></font></p>";
//	 $e =mysql_error($respquery);
	 echo "Ocurri� el siguiente problema:<br>";
  	 //echo htmlentities($e['message']);
  	 echo "<pre>";
     ///echo htmlentities($e['sqltext']);
    // printf("\n%".($e['offset']+1)."s", "^");
     echo "</pre></center></td></tr></table>";
	}else{
		$vigencia=date(Y);
		$sqlr="update tesoprediosavaluos set tipopredio='".$_POST[tipop]."',estratos='".$estrato."' WHERE codigocatastral=$_POST[catastral] ";
		mysql_query($sqlr,$linkbd);
		 echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha Actualizado el Estrato del Predio con Exito <img src='imagenes\confirm.png'></center></td></tr></table>";
		  ?>
		  <script>
		  document.form2.tercero.value="";
		  document.form2.ntercero.value="";
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
</table>
</body>
</html>