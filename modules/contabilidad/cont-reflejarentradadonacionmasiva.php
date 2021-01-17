<?php
	require "comun.inc";
	require "funciones.inc";
	require "conversor.php";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE  6
	date_default_timezone_set("America/Bogota");
	$_POST[oculto2]=$_GET[oculto2];
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
        <title>:: Spid - Contabilidad</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
        <script type="text/javascript" src="css/programas.js"></script>
        <script type="text/javascript" src="css/calendario.js"></script>
        <script>

			function buscar()
			{
				var fechaini = document.getElementById("fechaini").value;
				var fechafin = document.getElementById("fechafin").value;
				
				if(fechaini!='' && fechafin!=''){
					document.form2.oculto.value='3';
					document.form2.submit(); 
				}else{
					despliegamodalm('visible','2','Debe existir una fecha inicial y una fecha final');
				}
				
			}
			
			function reflejar(){
				var numrecaudos = document.getElementsByName("recaudocc[]");
				if(numrecaudos.length >0){
					document.form2.oculto.value='2';
					document.form2.submit(); 
				}else{
					despliegamodalm('visible','2','No existen recibos para reflejar');
				}
			}
			
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
			
			function funcionmensaje()
			{
				
			}
			
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.form2.oculto.value=2;
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
            <tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("cont");?></tr>
        	<tr>
  				<td colspan="3" class="cinta">
				<a href="cont-reflejarentradadonacionmasiva.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
				<a class="mgbt"><img src="imagenes/guarda.png"/></a>
				<a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
				<a href="#" class="mgbt" onClick="mypop=window.open('cont-principal.php','',''); mypop.focus();"><img src="imagenes/nv.png" title="Nueva Ventana"></a> 
				<a href="#" onclick="crearexcel()" class="mgbt"><img src="imagenes/excel.png" title="Excell"></a><a href="cont-reflejardocs.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a></td>
         	</tr>	
		</table>
		
		 <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
		
 		<form name="form2" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">  

			<?php
				$iter='saludo1b';
				$iter2='saludo2b';
			?>
			<table width="100%" align="center"  class="inicio" >
                <tr>
                    <td class="titulos" colspan="9">:: Buscar .: Entradas por Donacion Almacen </td>
                    <td class="cerrar" style='width:7%' onClick="location.href='cont-principal.php'">Cerrar</td>
                    <input type="hidden" name="oculto" id="oculto" value="<?php echo $_POST[oculto]; ?>">
                    <input type="hidden" name="iddeshff" id="iddeshff" value="<?php echo $_POST[iddeshff];?>">	 
                </tr>                       
                <tr>
                    <td  class="saludo1" >Fecha Inicial: </td>
                    <td><input type="search" name="fechaini" id="fechaini" title="YYYY/MM/DD"  value="<?php echo $_POST[fechaini]; ?>" onKeyUp="return tabular(event,this)" onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">&nbsp;<img src="imagenes/calendario04.png" style="width:20px" onClick="displayCalendarFor('fechaini');" class="icobut" title="Calendario"></td>
                    <td  class="saludo1" >Fecha Final: </td>
                    <td ><input type="search" name="fechafin" id="fechafin" title="YYYY/MM/DD"  value="<?php echo $_POST[fechafin]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">&nbsp;<img src="imagenes/calendario04.png" style="width:20px" onClick="displayCalendarFor('fechafin');"  class="icobut" title="Calendario"></td>  
                    <td><input type="button" name="bboton" onClick="buscar()" value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;" /><input type="button" name="bboton" onClick="reflejar()" value="&nbsp;&nbsp;Reflejar&nbsp;&nbsp;" /></td>
                </tr>
			</table>
			
			<?php
				
				if($_POST[oculto]==3){
					//Variables ocultas para información de tablas
					unset($_POST[recaudocc]);
					unset($_POST[conceptocc]);
					unset($_POST[valtotaltescc]);
					unset($_POST[valtotalcontcc]);
					unset($_POST[diferenciacc]);
					unset($_POST[fechacc]);
					unset($_POST[cc]);
					unset($_POST[conceptoscc]);
					unset($_POST[documecc]);
					unset($_POST[terceros]);
					unset($_POST[cuentadon]);
					
					$_POST[recaudocc]= array_values($_POST[recaudocc]); 
					$_POST[conceptocc]= array_values($_POST[conceptocc]); 
					$_POST[valtotaltescc]= array_values($_POST[valtotaltescc]); 
					$_POST[valtotalcontcc]= array_values($_POST[valtotalcontcc]); 		 		 
					$_POST[diferenciacc]= array_values($_POST[diferenciacc]); 
					$_POST[fechacc]= array_values($_POST[fechacc]); 
					$_POST[cc]= array_values($_POST[cc]); 
					$_POST[conceptoscc]= array_values($_POST[conceptoscc]); 
					$_POST[documecc]= array_values($_POST[documecc]); 
					$_POST[terceros]= array_values($_POST[terceros]);
					$_POST[cuentadon]= array_values($_POST[cuentadon]);
					
					$queryDate="";
					if(isset($_POST['fechafin']) and isset($_POST['fechaini'])){

						if(!empty($_POST['fechaini']) and !empty($_POST['fechafin'])){
							$fechaInicial=date('Y-m-d',strtotime($_POST['fechaini']));
							$fechaFinal=date('Y-m-d',strtotime($_POST['fechafin']));
							$queryDate="AND fecha>='".$fechaInicial."' and fecha<='".$fechaFinal."'";
						}
					}
					$sqlr="select consec,valortotal,estado,nombre,fecha,codmov,cc from almginventario where estado!='N' AND tiporeg='07' AND tipomov='1' $queryDate order by consec";
					$resp=mysql_query($sqlr,$linkbd);
					while($row = mysql_fetch_row($resp)) 
					{
						$estilo="";
						$stado="";
						$cc = (($row[6] == '') ? '01' : $row[6]);
						$fecha = $row[4];
						$nfecha = cambiar_fecha($fecha);
						
						$sql="SELECT codigo,tipocuenta,cuenta,cc FROM conceptoscontables_det WHERE conceptoscontables_det.tipo='ED' AND conceptoscontables_det.modulo=5 and conceptoscontables_det.cuenta!='' AND  conceptoscontables_det.estado = 'S' AND conceptoscontables_det.fechainicial=(SELECT MAX(T3.fechainicial) FROM conceptoscontables_det T3 WHERE  T3.codigo=conceptoscontables_det.codigo AND T3.cc = '".$cc."' AND T3.modulo='5' AND T3.credito='S' AND T3.estado='S' AND T3.fechainicial<='$nfecha') LIMIT 1";
						$resconcep = mysql_query($sql,$linkbd);
						$rowconcepto = mysql_fetch_row($res);
								
						$sql = "select doctercero from almactodonacionesent where id=".$row[5];
						$resacto = mysql_query($sql,$linkbd);
						$rowacto = mysql_fetch_row($rowacto);
						
						$sql = "select codigo,sum(valortotal),concepto,cc from almginventario_det where codigo='$row[0]' AND tiporeg='07' AND tipomov='1' group by codigo ";
						$resinvd = mysql_query($sql,$linkbd);
						$rowinvdet = mysql_fetch_row($resinvd);
						
						$sql = "select numerotipo,total_debito,total_credito from comprobante_cab where numerotipo='$row[0]' AND tipo_comp='51' AND estado='1' ";
						$rescont=mysql_query($sql,$linkbd);
						$rowcont=mysql_fetch_row($rescont);
						
						$sql="select numerotipo,sum(valdebito),sum(valcredito) from comprobante_det where numerotipo='$row[0]' AND tipo_comp='51' AND estado='1' ";
						$rs=mysql_query($sql,$linkbd);
						$rw=mysql_fetch_row($rs);
						
						if($rw[0]!=null && $rowcont[0]!=null){
							
							$totaldebitocab = $rowcont[1];
							$totalcreditocab = $rowcont[2];
							$totaldebitodet = $rw[1];
							$totalcreditodet = $rw[2];
							
							$dif=$rowinvdet[1]-$rw[1];
							$difround = round($dif);
							
							if($totaldebitocab!=$totaldebitodet || $totalcreditocab!=$totalcreditodet || $difround!=0){
								$_POST[recaudocc][] = $row[0];
								$_POST[conceptocc][] = $row[3];
								$_POST[valtotaltescc][] = $rowinvdet[1];
								$_POST[valtotalcontcc][] = $rw[1];
								$_POST[diferenciacc][] = $difround;
								$_POST[fechacc][] = $row[4];
								$_POST[cc][] = $cc;
								$_POST[conceptoscc][] = $rowinvdet[2];
								$_POST[documecc][] = $row[5];
								$_POST[terceros][] = $rowacto[0];
								$_POST[cuentadon][] = $rowconcepto[2];
							}

						}else{
							$_POST[recaudocc][] = $row[0];
							$_POST[conceptocc][] = $row[3];
							$_POST[valtotaltescc][] = $rowinvdet[1];
							$_POST[valtotalcontcc][] = 0;
							$_POST[diferenciacc][] = $row[1];
							$_POST[fechacc][] = $row[4];
							$_POST[cc][] = $cc;
							$_POST[conceptoscc][] = $rowinvdet[2];
							$_POST[documecc][] = $row[5];
							$_POST[terceros][] = $rowacto[0];
							$_POST[cuentadon][] = $rowconcepto[2];
						}
						
					} 				
				}			
          ?>
				
	<?php
	echo "<div class='subpantallac5' style='height:55%; width:99.6%; margin-top:0px; overflow-x:hidden' id='divdet'>
		<table class='inicio' align='center' id='valores' >
		<tbody>";
		echo "<tr class='titulos'><td colspan='7'>.:Resultados: ".count($_POST[recaudocc])."</td></tr>";
		echo "<tr class='titulos ' style='text-align:center;'>
					<td ></td>
					<td colspan='2'></td>
					<td >Almacen</td>
					<td colspan='2'>Contabilidad</td>
					<td ></td>
				</tr>
				<tr class='titulos' style='text-align:center;'>
					<td id='col1'>Id Comprobante</td>
					<td id='col2'>Descripcion</td>
					<td id='col3'>Fecha</td>
					<td id='col4'>Valor Total</td>
					<td id='col5'>Cuenta Donacion</td>
					<td id='col6'>Valor Total</td>
					<td id='col7'>Diferencia</td>
				</tr>";
				
		for($k=0; $k<count($_POST[recaudocc]);$k++){
			
			echo "<input type='hidden' name='recaudocc[]' value='".$_POST[recaudocc][$k]."'/>";
			echo "<input type='hidden' name='conceptocc[]' value='".$_POST[conceptocc][$k]."'/>";
			echo "<input type='hidden' name='valtotaltescc[]' value='".$_POST[valtotaltescc][$k]."'/>";
			echo "<input type='hidden' name='valtotalcontcc[]' value='".$_POST[valtotalcontcc][$k]."'/>";
			echo "<input type='hidden' name='diferenciacc[]' value='".$_POST[diferenciacc][$k]."'/>";
			echo "<input type='hidden' name='fechacc[]' value='".$_POST[fechacc][$k]."'/>";
			echo "<input type='hidden' name='cc[]' value='".$_POST[cc][$k]."'/>";
			echo "<input type='hidden' name='conceptoscc[]' value='".$_POST[conceptoscc][$k]."'/>";
			echo "<input type='hidden' name='estilocc[]' value='".$_POST[estilocc][$k]."'/>";
			echo "<input type='hidden' name='terceros[]' value='".$_POST[terceros][$k]."'/>";
			echo "<input type='hidden' name='cuentadon[]' value='".$_POST[cuentadon][$k]."'/>";
			
			echo"<tr class='$iter' style='text-transform:uppercase;background-color:yellow; ' >
				<td style='width:7%;' id='1'>".$_POST[recaudocc][$k]."</td>
				<td style='width:32%;' id='2'>".$_POST[conceptocc][$k]."</td>
				<td style='width:32%;' id='3'>".$_POST[fechacc][$k]."</td>
				<td style='text-align:right;width:3%;' id='4'>$".number_format($_POST[valtotaltescc][$k],2,',','.')."</td>
				<td style='width:32%;' id='5'>".(($_POST[cuentadon][$k]=='')?'Sin parametrizar':$_POST[cuentadon][$k])."</td>
				<td  style='text-align:right;width:4.5%;' id='6'>$".number_format($_POST[valtotalcontcc][$k],2,',','.')."</td>
				<td  style='text-align:right;width:4.5%;' id='7'>$".number_format($_POST[diferenciacc][$k],2,',','.')."</td></tr>";
			$aux=$iter;
			$iter=$iter2;
			$iter2=$aux;
			$resultadoSuma=0.0;
			 
		}

		echo "</table></tbody></div>";				
		
	?>

	<?php
		if($_POST['oculto']==2){
			$entradas = "";
			$entradasfallidas = "";
			
			try{
				
				$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
				
				for($n=0; $n<count($_POST[recaudocc]); $n++){
					
					$bloq=bloqueos($_SESSION[cedulausu],$_POST[fechacc][$n]);
					
					if($bloq >= 1){
						$resultado1=0;$resultado2=0;$resultado3=0;$resultado4=0;$resultado5=0;
						$fecha = $_POST[fechacc][$n];
						$nfecha = cambiar_fecha($fecha);
						//Eliminar cabecera
						$sql = "delete from comprobante_cab where numerotipo='".$_POST[recaudocc][$n]."' AND tipo_comp='51' ";
						$res = mysql_query($sql,$linkbd) or die($resultado1=1);
						
						if($res){
							$sql = "delete from comprobante_det where numerotipo='".$_POST[recaudocc][$n]."' AND tipo_comp='51' ";
							$res = mysql_query($sql,$linkbd) or die($resultado2=1);
							if(mysql_query($sql,$linkbd)){
								//Aqui logica para almacenar salida directa
								$valtotf=0;
								$totalcab=0;
								
								$_POST[codinard]= array(); 		 
								$_POST[cantidadd]= array();
								$_POST[codunsd]= array();
								$_POST[undadd]= array();
								$_POST[ccd]= array();
								$_POST[agcuen]= array();
								$_POST[codbodd]= array();
								$_POST[valtotald]= array();
								$_POST[cuentacon]= array();
								
								$sql = "select codigo,unspsc,codart,cantidad_entrada,valortotal,bodega,cc,concepto,unidad from almginventario_det where codigo='".$_POST[recaudocc][$n]."' AND tiporeg='07' AND tipomov='1'";
								$res = mysql_query($sql,$linkbd);

								while($row = mysql_fetch_row($res)){

									$_POST[codinard][] = $row[2];
									$_POST[cantidadd][] = $row[3];
									$_POST[codunsd][] = $row[1];
									$_POST[undadd][] = $row[8];
									$_POST[agcuen][] = $row[7]; 
									$_POST[codbodd][] = $row[5];
									$_POST[valtotald][] = $row[4];
									$cc = (($row[6]=='')?'01':$row[6]);
									$_POST[ccd][] = $cc;
									
									$codgrupo= substr($row[2], 0, 4);

									$sqlrcumdon="SELECT T2.cuenta FROM almgrupoinv T1, conceptoscontables_det T2 WHERE  T1.codigo='$codgrupo' AND T1.concepent=T2.codigo AND T2.cc = '$cc' AND T2.modulo='5' AND T2.debito='S' AND T2.estado='S' AND T2.fechainicial=(SELECT MAX(T3.fechainicial) FROM conceptoscontables_det T3 WHERE  T3.codigo=T2.codigo AND T3.cc = '$cc' AND T3.modulo='5' AND T3.debito='S' AND T3.estado='S' AND T3.fechainicial<='$nfecha')";
									$rescumdon = mysql_query($sqlrcumdon,$linkbd);
									$cuentadeb = mysql_fetch_row($rescumdon);
									$_POST[cuentacon][]=$cuentadeb[0];
								}
								
								for ($x=0;$x<count($_POST[codinard]);$x++)
								{		 
									echo "<input type='hidden' name='codinard[]' value='".$_POST[codinard][$x]."'>";
									echo "<input type='hidden' name='cantidadd[]' value='".$_POST[cantidadd][$x]."'>";
									echo "<input type='hidden' name='codunsd[]' value='".$_POST[codunsd][$x]."'>";
									echo "<input type='hidden' name='undadd[]' value='".$_POST[undadd][$x]."'>";
									echo "<input type='hidden' name='ccd[]' value='".$_POST[ccd][$x]."'>";
									echo "<input type='hidden' name='agcuen[]' value='".$_POST[agcuen][$x]."'>";
									echo "<input type='hidden' name='codbodd[]' value='".$_POST[codbodd][$x]."'>";
									echo "<input type='hidden' name='valtotald[]' value='".$_POST[valtotald][$x]."'>";
									echo "<input type='hidden' name='cuentacon[]' value='".$_POST[cuentacon][$x]."'>";
								}
								
								$total = 0;
								
								for($x=0;$x<count($_POST[codinard]);$x++)
								{
									//DEBITO
									if($_POST[cuentacon][$x]!=""){
										$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado, vigencia,tipo_comp,numerotipo) VALUES ('51 ".$_POST[recaudocc][$n]."','".$_POST[cuentacon][$x]."','".$_POST[terceros][$n]."','".$_POST[ccd][$x]."','".$_POST[conceptocc][$n]."','','".$_POST[valtotald][$x]."','0','1','$vigusu','51','".$_POST[recaudocc][$n]."')";
										mysql_query($sqlr,$linkbd) or die($resultado3=1);
									}else{
										$resultado3=1;
									}
									
									//CREDITO
									if($_POST[cuentadon][$n]!=""){
										$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado, vigencia,tipo_comp,numerotipo) VALUES ('51 ".$_POST[recaudocc][$n]."','".$_POST[cuentadon][$n]."','".$_POST[terceros][$n]."','".$_POST[ccd][$x]."','".$_POST[conceptocc][$n]."','','0','".$_POST[valtotald][$x]."','1','$vigusu','51','".$_POST[recaudocc][$n]."')";
										mysql_query($sqlr,$linkbd) or die($resultado4=1);
									}else{
										$resultado4=1;
									}
									
									//Validaciones
									$total += (double)($_POST[valtotald][$x]);
									if($resultado3==1 || $resultado4==1){
										$entradasfallidas+=($_POST[codinard][$n])." ";
									}
								}

								$sqlr="INSERT INTO comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia, estado) VALUES (".$_POST[recaudocc][$n].",51,'$nfecha','".$_POST[conceptocc][$n]."',0,$total,$total,0,'1')";
								mysql_query($sqlr,$linkbd) or die($resultado5=1);
									
								if($resultado1==1 || $resultado2==1 || $resultado5==1){
									$entradasfallidas+=($_POST[codinard][$n])." ";
								}else{
									$entradas+=($_POST[codinard][$n])." ";
								}
							}
							
							
						}
					}

				}
			}catch(Exception $e){
				echo "<table class='inicio'><tr><td class='saludo1'><center>Ha ocurrido un Error: $e <img src='imagenes/del.png'><script></script></center></td></tr></table>";  
			}
			
			
			echo "<table class='inicio'><tr><td class='saludo1'><center>Se han reflejado las Entradas por Ajuste $entradas con Exito <img src='imagenes/confirm.png'><script></script></center></td></tr></table>"; 
			echo "<table class='inicio'><tr><td class='saludo1'><center>No se pudieron reflejar los Entradas por Ajuste $entradasfallidas <img src='imagenes/del.png'><script></script></center></td></tr></table>"; 
								
		}
			
	?>
			
		
        </form> 

</body>
</html>