
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
					<a class="mgbt1"><img src="imagenes/add2.png"/></a> 
					<a class="mgbt1"><img src="imagenes/guardad.png"/></a> 
					<a class="mgbt1"><img src="imagenes/buscad.png"/></a> 
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
				</td>
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
				
			?>
    			<table class="inicio" align="center" >
      				<tr>
        				<td class="titulos" colspan="3" style='width:93%'>.: Proceso Tarifas Avaluo Vigencia Predios</td>
                        <td width="72" class="cerrar" style='width:7%'><a href="teso-principal.php">Cerrar</a></td>
      				</tr>
	  				<tr> 
                    	<td width="8%" class="saludo1">C&oacute;digo Catastral:</td>
          				<td width="20%" ><input id="codcat" type="text" name="codcat"  onKeyUp="return tabular(event,this)" onBlur="buscar(event)" value="<?php echo $_POST[codcat]?>" onClick="document.getElementById('tercero').focus();document.getElementById('tercero').select();"><input type="hidden" value="0" name="bt"> <input type="hidden" name="chacuerdo" value="1"><input type="hidden" value="1" name="oculto"> <input type="hidden" value="<?php echo $_POST[buscav]?>" name="buscav">&nbsp;<a title="Listado de Predios" onClick="despliegamodal2('visible');" style="cursor:pointer;"><img src="imagenes/find02.png" style="width:20px;"/></a>&nbsp;<input type="button" name="buscarb" id="buscarb" value="   Correr Proceso   " onClick="buscar()" ></td>
						<td width="15%"><div id="progress" style="width:400px;border:1px solid #ccc;height: 22px;display: inline-block"></div><div id="information" style="display: inline-block; margin-left: 10px;"></div></td>
						
        			</tr>
	  			</table>
				<input  type="hidden" name="ord"   value="<?php echo $_POST[ord]?>" ><input type="hidden" name="tot"  value="<?php echo $_POST[tot]?>" >
	  			<div class="subpantallap" style="height:68.5%; width:99.6%; overflow-x:hidden;">
            <?php
			function calcularTarifa($avaluo,$clasifica,$estratos,$vigencia){
					global $linkbd;
					$tarifa=-1;//echo  "hola".$estratos;
					if(empty($estratos) || $estratos=='A'){
						
						$sql="SELECT valor FROM tesounidadpred where vigencia=$vigencia";
						$res=mysql_query($sql,$linkbd);
						$row = mysql_fetch_row($res);
						$valor=$row[0];
						$sqlclasi="SELECT codigo,consecutivo,val1,val2 FROM teso_clasificapredios where codigo=$clasifica AND vigencia=$vigencia";
						//echo $sqlclasi."<br>";
						//echo $vigencia."<br>";
						$resclasi=mysql_query($sqlclasi,$linkbd);
						while($rowclasi = mysql_fetch_row($resclasi)){
							$valn1=$valor * $rowclasi[2];
							$valn2=$valor * $rowclasi[3];
							if($avaluo>=$valn1 && $valn2>$avaluo ){
								$sqltar="SELECT tasa FROM tesotarifaspredial WHERE tipo=$rowclasi[0] AND estratos=$rowclasi[1] AND estado='S' AND vigencia='$vigencia'";
								$restarifa=mysql_query($sqltar,$linkbd);
								$rowtar = mysql_fetch_row($restarifa);
								$tarifa=$rowtar[0]."-".$rowclasi[1];
								break;
							}
						}
					
					}else{
						$sql="SELECT tasa FROM tesotarifaspredial WHERE tipo=$clasifica AND estratos=$estratos AND estado='S' AND vigencia='$vigencia' ";//echo $sql;
						$res=mysql_query($sql,$linkbd);
						$row = mysql_fetch_row($res);
						$tarifa=$row[0]."-".$estratos;
						
					}
					return $tarifa;
				}
			function obtenerNombre1($codigo,$idrango,$tipo,$vigencia){
					global $linkbd;
					if(empty($idrango)){
						$sql="SELECT nombre,nom_rango FROM teso_clasificapredios WHERE codigo=$codigo AND vigencia=$vigencia LIMIT 0,1";
					}else{
						$sql="SELECT nombre,nom_rango FROM teso_clasificapredios WHERE codigo=$codigo AND id_rango=$idrango AND vigencia=$vigencia LIMIT 0,1";
					}
					$res=mysql_query($sql,$linkbd);
					$row = mysql_fetch_row($res);
					if($tipo==0){
						return $row[0];
					}else{
						return $row[1];
					}
					
				}
				
				
				
				echo "
					<table class='inicio'>
						<tr><td colspan='12' class='titulos'>.: Resultados Busqueda:</td></tr>
						<tr><td colspan='12'>Informaci&oacute;n de Predios Encontrados: $ntr</td></tr>
						<tr>
							<td class='titulos2'>Item</td>
							<td class='titulos2'>Vigencia</td>
							<td class='titulos2'>Codigo Catastral</td>
							<td class='titulos2'>Avaluo</td>
							<td class='titulos2'>Propietario</td>
							<td class='titulos2'>Direcci&oacute;n</td>
							<td class='titulos2'>Ha</td>
							<td class='titulos2'>Mt&sup2;</td>
							<td class='titulos2'>Area Cons</td>
							<td class='titulos2'>Tipo</td>
							<td class='titulos2'>Estratos o Rangos Avaluo</td>
							<td class='titulos2'>Tarifa</td>
						</tr>";	
						
				if($_POST[buscav]=='1' && $_POST[oculto])
 				{
					
			
					if(!empty($_POST[codcat])){
						$sqlr="select tpa.vigencia,tpa.codigocatastral,tpa.avaluo,campo1,campo2,tpa.ha,tpa.met2,tpa.areacon,campo3,campo4 from (SELECT nombrepropietario AS campo1,direccion AS campo2,clasifica AS campo3,estratos AS campo4,cedulacatastral AS campo5 FROM tesopredios WHERE cedulacatastral='$_POST[codcat]' AND clasifica<>''  LIMIT 0,1) AS tp,tesoprediosavaluos as tpa where  campo5=tpa.codigocatastral and tpa.estado='I'";
					}else{
						$sqlr="SELECT tpa.vigencia,tpa.codigocatastral,tpa.avaluo,s.nombrepropietario,s.direccion,tpa.ha,tpa.met2,tpa.areacon,s.clasifica,s.estratos FROM tesoprediosavaluos tpa INNER JOIN (SELECT nombrepropietario,direccion,clasifica,cedulacatastral,estratos FROM tesopredios GROUP BY cedulacatastral) s ON s.cedulacatastral=tpa.codigocatastral WHERE tpa.tasa='-1'";
					}
	 				$res=mysql_query($sqlr,$linkbd);
					$total = mysql_num_rows($res);
					$con=1;//echo $sqlr."<br>";
	 				while($row=mysql_fetch_row($res))
	  				{
					$iter='saludo1a';
					$iter2='saludo2';
					$stilocolor="";
					$arreglo=explode("-",calcularTarifa($row[2],$row[8],$row[9],$row[0]));
					$tarifapre=$arreglo[0];
					$estratopre=$arreglo[1];
					if(!empty($tarifapre)){
						$actualiza="UPDATE tesoprediosavaluos SET tasa='".$tarifapre."',estratos='".$estratopre."',tipopredio='".$row[8]."' WHERE codigocatastral='$row[1]' AND vigencia=$row[0]" ;
						mysql_query($actualiza,$linkbd);
					}else{
						$stilocolor="style='background-color: #FFAB91 !important' ";
						
					}
					
					$percent = intval($con/$total * 100)."%";
					 echo '<script language="javascript">
    document.getElementById("progress").innerHTML="<div style=\"width:'.$percent.';background-color:#0D47A1;height: 22px\">&nbsp;</div>";
    document.getElementById("information").innerHTML="'.$percent.' ";
    </script>';
						echo str_repeat(' ',1024*64);
						flush();
						sleep(0.4);
					 	echo "
						<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\" $stilocolor>
							<td>$con</td>
							<td>$row[0]</td>
							<td>$row[1]</td>
							<td>$row[2]</td>
							<td>$row[3]</td>
							<td>$row[4]</td>
							<td>$row[5]</td>
							<td>$row[6]</td>
							<td>$row[7]</td>
							<td>".obtenerNombre1($row[8],"",0,$row[0])."</td>
							<td>".obtenerNombre1($row[8],$estratopre,1,$row[0])."</td>
							<td>".$tarifapre." x Mil</td>
						</tr>
						<input type='hidden' name='codcath[]' value='$row[0]'>
						<input type='hidden' name='avaluoh[]' value='$row[11]'>
						<input type='hidden' name='documeh[]' value='$row[5]'>
						<input type='hidden' name='propieh[]' value='$row[6]'>
						<input type='hidden' name='direcch[]' value='$row[7]'>
						<input type='hidden' name='hah[]' value='$row[8]'>
						<input type='hidden' name='mt2h[]' value='$row[9]'>
						<input type='hidden' name='areconh[]' value='$row[10]'>
						<input type='hidden' name='tipoh[]' value='$row[14]'>
						<input type='hidden' name='estrath[]' value='$estrato'>
						";
						$con+=1;
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
						
			
	  				}
					echo '<script language="javascript">document.getElementById("information").innerHTML="Proceso completado"</script>';
				
  				}
			?>
			</div>
	  
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