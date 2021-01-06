<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	sesion();
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
		<title>:: Spid - Gestion Humana</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
		<script>
			function guardar()
			{
				if (document.form2.tercero.value!='' && document.form2.periodo.value!='')
  				{
					if (confirm("Esta Seguro de Guardar"))
					{
						document.form2.oculto.value=2;
						document.form2.submit();
					}
  				}
  				else{alert('Faltan datos para completar el registro');}
 			}
			function validar(formulario){document.form2.submit();}
			function buscater(e)
 			{
				if (document.form2.tercero.value!="")
				{
 					document.form2.bt.value='1';
 					document.form2.submit();
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
			function funcionmensaje(){document.location.href = "";}
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
			function despliegamodal2(_valor,_num)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else 
				{	
					document.getElementById('ventana2').src="tercerosgral-ventana02.php?objeto=tercero&nobjeto=ntercero&nfoco=incaeps&valsub=SI";
				}
			}
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
 			<tr><script>barra_imagenes("hum");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("hum");?></tr>
			<tr>
  				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='hum-incapacidades.php'" class="mgbt"/></a><a href="#"  onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a><a onClick="" href="hum-buscaincapacidades.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a><a href="#" onClick="mypop=window.open('hum-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="nueva ventana"></a><a href="#" onClick='excell()' class="mgbt"><img src="imagenes/excel.png"  title="excel"></a></td>
  			</tr>	
  		</table>
  		<div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
		<form name="form2" method="post" action="">
			<?php
				$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
				if(!$_POST[oculto])
				{
					$_POST[pagopara]='N';
	 				$consec=selconsecutivo('humincapacidades','id_inca');
	 				$_POST[idcomp]=$consec;		 
					$_POST[fecha]=date("Y-m-d"); 
					$sqlr="select indiceinca from admfiscales where vigencia='$vigusu'";
					$res=mysql_query($sqlr,$linkbd);
					while($r=mysql_fetch_row($res)){$_POST[indiceinca]=$r[0];}	 
					$_POST[vigenciat]=$vigusu;
				}
				if($_POST[bt]=='1')
			 	{
			  		$nresul=buscatercero($_POST[tercero]);
			  		if($nresul!='')
			   		{
			  			$_POST[ntercero]=$nresul;
						$sqlr="select terceros_nomina.cargo, humnivelsalarial.nombre, humnivelsalarial.valor, terceros_nomina.fondopensionestipo from terceros_nomina inner join humnivelsalarial on terceros_nomina.cargo=humnivelsalarial.id_nivel where terceros_nomina.cedulanit='$_POST[tercero]'";
			 			$resp2 = mysql_query($sqlr,$linkbd);
						$row2 =mysql_fetch_row($resp2);
						$_POST[salbas]=$row2[2];
			  		}
			 		else {$_POST[ntercero]="";}
			 	}	
		 		$pf[]=array();
		 		$pfcp=array();	
		 		if($_POST[vactodos]==1){$checkt=" checked";}
 				else {$checkt=" ";}
			?>
			<table  class="inicio" align="center" >
				<tr>
					<td class="titulos" colspan="7">:: Incapacidades y Licencias</td>
					<td class="cerrar" style="width:7%" onClick="location.href='hum-principal.php'">Cerrar</td>
				</tr>
				<tr> 
					<td class="saludo1" style="width:3.5cm;">No Incapacidad:</td>
					<td style="width:12%"><input name="idcomp" type="text" value="<?php echo $_POST[idcomp]?>" style="width:98%;" readonly/></td>
					<td class="saludo1"  style="width:4cm;">Fecha Registro:</td>
					<td style="width:12%"><input type="date" name="fecha"  value="<?php echo $_POST[fecha]?>" style="width:98%;" readonly/></td>
					<td class="saludo1" style="width:3.5cm;">Vigencia:</td>
					<td style="width:14%"><input type="text" name="vigenciat" id="vigenciat" value="<?php echo $_POST[vigenciat];?>" style="width:100%;" readonly/></td>
					<td rowspan="6" colspan="2" style="background:url(imagenes/incapacidad.png); background-repeat:no-repeat; background-position:center; background-size: 60% 100%;" ></td>
				</tr>  
     			<tr>
       				<td class="saludo1">Tercero:</td>
 					<td><input type="text" id="tercero" name="tercero" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo $_POST[tercero]?>" style="width:80%;"/>&nbsp;&nbsp;<img class="icobut" src="imagenes/find02.png"  title="Listado Terceros" onClick="despliegamodal2('visible');"/></td>
       			 	<td colspan="4"><input type="text" name="ntercero" id="ntercero" value="<?php echo $_POST[ntercero]?>" style="width: 100%;"readonly/></td> 
        			<input type="hidden" name="bt" id="bt" value="0"/>
         		</tr>       
      			<tr>
       				<td class="saludo1">Cod Incapacidad EPS:</td>
       				<td><input type="text" name="incaeps" id="incaeps" value="<?php echo $_POST[incaeps]?>" style="width:98%;"/></td>
       				<td class="saludo1">Cod Incapacidad Ant. EPS:</td>
       				<td><input name="incaepsant" type="text"  value="<?php echo $_POST[incaepsant]?>" style="width:98%;"/></td>
          			<td class="saludo1">Tipo Incapacidad:</td>
          			<td >
          				<select name="tipoinca" id="tipoinca" onChange=""  style="width:100%;" >
				  			<option value="">Seleccione ....</option>
                 			<?php
					 			$sqlr="Select * from dominios where tipo='S' and nombre_dominio LIKE 'LICENCIAS' ";
		 			 			$resp = mysql_query($sqlr,$linkbd);
					 			while ($row =mysql_fetch_row($resp)) 
					 			{
									if($row[1]==$_POST[tipoinca]){echo "<option value='$row[1]' SELECTED>$row[0]</option>";}
									else{echo "<option value='$row[1]'>$row[0]</option>";}
				     			}   
							?>             
          	   			</select>        
          			</td>     
          		</tr>   	 
         		<tr>
          			<td class="saludo1">Salario Basico:</td>
          			<td><input type="text" name="salbas" value="<?php echo $_POST[salbas]?>" style="width:98%;" readonly/></td>
           			<td class="saludo1">Mes:</td>
          			<td >
          				<select name="periodo" id="periodo" onChange="validar()"  style="width:98%;">
				  			<option value="-1">Seleccione ....</option>
							<?php
					 			$sqlr="Select * from meses where estado='S' ";
		 						$resp = mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($resp)) 
								{
									if($row[0]==$_POST[periodo])
			 						{
				 						echo "<option value='$row[0]' SELECTED>$row[1]</option>";
				 						$_POST[periodonom]=$row[1];
				 						$_POST[periodonom]=$row[2];
				 					}
									else {echo "<option value='$row[0]'>$row[1]</option>";}
			     				}   
							?>
		  				</select> 
         			</td>
        			<?php
						if(!$_POST[oculto])
						{
							$_POST[diast]=array();
						 	$_POST[devengado]=array();
						 	$_POST[empleados]=array();		 		
						}
						$sqlr="select *from admfiscales where vigencia='$vigusu'";
						$resp = mysql_query($sqlr,$linkbd);
						while ($row =mysql_fetch_row($resp)) 
						{
							$_POST[balim]=$row[7];
							$_POST[btrans]=$row[8];
							$_POST[bfsol]=$row[6];
							$_POST[alim]=$row[5];
							$_POST[transp]=$row[4];
							$_POST[salmin]=$row[3];
							$_POST[cajacomp]=$row[13];
							$_POST[icbf]=$row[10];
							$_POST[sena]=$row[11];
							$_POST[esap]=$row[14];
							$_POST[iti]=$row[12];	
						}		
        			?>
					<input type="hidden" name="diaini" value="1" \>
        			<td class="saludo1">Dias Incapacidad:</td>
        			<td><input name="diasperiodo" type="text" id="diasperiodo" value="<?php echo $_POST[diasperiodo]?>" onBlur="validar()" style="width:100%;" /></td>
				</tr>          
      			<tr > 
        			<input type="hidden" name="indiceinca" id="indiceinca" value="<?php echo $_POST[indiceinca]?>" />
         			<input type="hidden" name="oculto" value="1"/>
         			<input type="hidden" name="salmin"  value="<?php echo $_POST[salmin]?>"/>
          			<input type="hidden" name="pagopara" id="pafopara" value="N"/>
           			<td class="saludo1">Dias Descontados:</td>
        			<td><input type="text" name="diasdescontados" id="diasdescontados" value="<?php echo $_POST[diasdescontados]?>" onBlur="validar()" style="width:98%;"></td>
          			<td class="saludo1">Incapacidad (%):</td>
          			<td >
          				<select name="porcinca" id="porcinca" onChange="validar()" style="width:98%;">
				  			<option value="">Seleccione ....</option>
                 			<?php
					 			$sqlr="Select * from dominios where tipo='S' and nombre_dominio LIKE 'LICENCIAS_PORCENTAJE' ";
		 			 			$resp = mysql_query($sqlr,$linkbd);
					 			while ($row =mysql_fetch_row($resp)) 
					 			{
									if($row[0]==$_POST[porcinca]){echo "<option value='$row[0]' SELECTED>$row[0]%</option>";}
									else {echo "<option value='$row[0]'>$row[0]%</option>";}
				     			}   
							?>             
          	   			</select>        
          			</td>     
       				<?php 
	   					//**calculo incapacidad
			   			$diasalmin=($_POST[salmin]/30);
			   			$porcentaje=str_replace(".",",",$_POST[porcinca]);
			   			$diasi=($_POST[salbas]/30);
			   			$diainca=($porcentaje/100)*$diasi;
			   			if($diainca>$diasalmin)
	   					{
	   						$_POST[valinca]=round($diainca*($_POST[diasperiodo]-$_POST[diasdescontados]),0);
	   						$valdia=$diainca;
	   					}
	   					else
	   					{
	   						$_POST[valinca]=round($diasalmin*($_POST[diasperiodo]-$_POST[diasdescontados]),0);	  
	   						$valdia=$diasalmin;
	   					}
	   				?>
       				<td class="saludo1">Valor Incapacidad:</td>
       				<td><input type="text" name="valinca" value="<?php echo $_POST[valinca]?>" style="width:100%;" readonly></td>
       			</tr>             
    		</table>    
			<table class="iniciop">
				<tr><td class="titulos" colspan="6">:: Novedades Generadas</td></tr>
				<tr>
					<td class="titulos2">Item</td>
					<td class="titulos2">Vigencia</td>
					<td class="titulos2">Mes</td>
					<td class="titulos2">Dias</td>
					<td class="titulos2">Dias Descontados</td>
					<td class="titulos2">Valor</td>
				</tr>
				<?php
					//******calculo meses ****
					$mesini=$_POST[periodo];
					$vigenciaini=$vigusu;
					$diainicial=$_POST[diaini];
					$diasdesc=$_POST[diasdescontados];
					$totaldias=$_POST[diasperiodo];
					$saldodias=$totaldias;
					$nmeses=0;
					$periodo=30;
					$nmeses=ceil(($totaldias+$diainicial-1)/30);
					$co="zebra1";
					$co2="zebra2";
					for($m=1;$m<=$nmeses;$m++)
					{
						$diasim=0;
						if($saldodias>=30){$diasim=$periodo-$diainicial+1;}
						else {$diasim=$saldodias-$diainicial+1;}
						$valmes=($diasim-$diasdesc)*$valdia;
						$saldodias=$saldodias-$diasim;
						$diainicial=1;
						$difmes=abs(ceil(($mesini/12)-1));
						$mesdif=abs($mesini-(12*$difmes));
						echo "
							<tr class='$co'>
								<td>$m</td>
								<td><input type='hidden' name='viginc[]' value='".($vigenciaini+$difmes)."'>".($vigenciaini+$difmes)."</td>
								<td><input type='hidden' name='mesinc[]' value='".($mesdif)."'>$mesdif</td>
								<td><input type='hidden' name='diasinc[]' value='".($diasim)."'>$diasim</td>
								<td><input type='hidden' name='diasdescinc[]' value='".($diasdesc)."'>$diasdesc</td>
								<td><input type='hidden' name='valorinc[]' value='".round($valmes,2)."'>".round($valmes,2)."</td>
							</tr>";
						$aux=$co;
						$co=$co2;
						$co2=$aux;
						$mesini+=1;
						$diasdesc=0;
					}
				?>
			</table>
			<?php
 				if($_POST[bt]=='1')
			 	{
			  		$nresul=buscatercero($_POST[tercero]);
			  		if($nresul!=''){$_POST[ntercero]=$nresul;}
			 		else
			 		{
			  			$_POST[ntercero]="";
			  			echo"
			  			<script>
							alert('Tercero Incorrecto o no Existe');								
  		  					document.form2.tercero.value='';	
  		  					document.form2.tercero.focus();	
			  			</script>";
			  		}
			 	}
				if($_POST[oculto]==2)
 				{
					if($_POST[tipoinca]=="EG"){$_POST[pagopara]="S";}
  					$sqlr="insert into humincapacidades(incaeps_ant,incanueva,fecha,tercero,dia_ini,dias_inca,mes,vigencia,tipo_inca, indicador,ajustar_nov,pagar_parafiscales,diasdesc_inca,valordiainca,valorinca,estado) values ('$_POST[incaepsant]','$_POST[incaeps]','$_POST[fecha]','$_POST[tercero]','$_POST[diaini]','$_POST[diasperiodo]', '$_POST[periodo]','$vigusu','$_POST[tipoinca]','$_POST[porcinca]','N','$_POST[pagopara]','$_POST[diasdescontados]', '$diainca','$_POST[valinca]','S')";
	  				if (mysql_query($sqlr,$linkbd))
					{
						echo "<table class='inicio'><tr><td class='saludo1'><center>Incapacidad Almacenada Exitosamente<img src='imagenes\confirm.png'></center></td></tr></table>";	
		 				$idinca=mysql_insert_id();
		 				$detalle=count($_POST[mesinc]);
		 				for($y=0;$y<$detalle;$y++)
		 				{
		  					$sqlr="insert into humincapacidades_det (id_inca,mes,vigencia,dias,diasdesc,valor,estado) values ('$idinca','".$_POST[mesinc][$y]."','".$_POST[viginc][$y]."','".$_POST[diasinc][$y]."', '".$_POST[diasdescinc][$y]."','".$_POST[valorinc][$y]."','S')";
		  					mysql_query($sqlr,$linkbd);
		 				}
		 
					}
					else
					{
						echo "<table class='inicio'><tr><td class='saludo1'><center>Error al Almacenar Incapacidad ".mysql_error($linkbd).$sqlr."<img src='imagenes\alert.png'></center></td></tr></table>";
					}
 				}
			?>
		</form>
		<div id="bgventanamodal2">
			<div id="ventanamodal2">
				<IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"></IFRAME>
        	</div>
		</div>
	</body>
</html>