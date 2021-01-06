<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	require "conversor.php";
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
         <style>
		 	/*boton1*/
			.swibc
			{position: relative; width: 71px;-webkit-user-select:none;-moz-user-select:none;-ms-user-select: none;}
			.swibc-checkbox {display: none;}
			.swibc-label 
			{display: block;overflow: hidden;cursor: pointer;border: 2px solid #DDE6E2;border-radius: 20px;}
			.swibc-inner 
			{display: block;width: 200%;margin-left: -100%;transition: margin 0.3s ease-in 0s;}
			.swibc-inner:before, .swibc-inner:after 
			{display: block;float: left;width: 50%;height: 23px;padding: 0;line-height: 23px;font-size: 14px;color: white;font-family: Trebuchet, Arial, sans-serif;font-weight: bold;box-sizing: border-box;}
			.swibc-inner:before 
			{content: "SI";padding-left: 10px;background-color: #51C3E0;color: #FFFFFF;}
			.swibc-inner:after 
			{content: "NO";padding-right: 10px;background-color: #EEEEEE; color: #999999;text-align: right;}
			.swibc-switch 
			{display: block;width: 17px;margin: 3px;background: #FFFFFF;position: absolute;top: 0;bottom: 0;right: 44px;border: 2px solid #DDE6E2;border-radius: 20px;transition: all 0.3s ease-in 0s;}
			.swibc-checkbox:checked + .swibc-label .swibc-inner {margin-left: 0;}
			.swibc-checkbox:checked + .swibc-label .swibc-switch {right: 0px;}
			/*boton2*/
			.swarl
			{position: relative; width: 71px;-webkit-user-select:none;-moz-user-select:none;-ms-user-select: none;}
			.swarl-checkbox {display: none;}
			.swarl-label 
			{display: block;overflow: hidden;cursor: pointer;border: 2px solid #DDE6E2;border-radius: 20px;}
			.swarl-inner 
			{display: block;width: 200%;margin-left: -100%;transition: margin 0.3s ease-in 0s;}
			.swarl-inner:before, .swarl-inner:after 
			{display: block;float: left;width: 50%;height: 23px;padding: 0;line-height: 23px;font-size: 14px;color: white;font-family: Trebuchet, Arial, sans-serif;font-weight: bold;box-sizing: border-box;}
			.swarl-inner:before 
			{content: "SI";padding-left: 10px;background-color: #51C3E0;color: #FFFFFF;}
			.swarl-inner:after 
			{content: "NO";padding-right: 10px;background-color: #EEEEEE; color: #999999;text-align: right;}
			.swarl-switch 
			{display: block;width: 17px;margin: 3px;background: #FFFFFF;position: absolute;top: 0;bottom: 0;right: 44px;border: 2px solid #DDE6E2;border-radius: 20px;transition: all 0.3s ease-in 0s;}
			.swarl-checkbox:checked + .swarl-label .swarl-inner {margin-left: 0;}
			.swarl-checkbox:checked + .swarl-label .swarl-switch {right: 0px;}
			/*boton3*/
			.swparafiscal
			{position: relative; width: 71px;-webkit-user-select:none;-moz-user-select:none;-ms-user-select: none;}
			.swparafiscal-checkbox {display: none;}
			.swparafiscal-label 
			{display: block;overflow: hidden;cursor: pointer;border: 2px solid #DDE6E2;border-radius: 20px;}
			.swparafiscal-inner 
			{display: block;width: 200%;margin-left: -100%;transition: margin 0.3s ease-in 0s;}
			.swparafiscal-inner:before, .swparafiscal-inner:after 
			{display: block;float: left;width: 50%;height: 23px;padding: 0;line-height: 23px;font-size: 14px;color: white;font-family: Trebuchet, Arial, sans-serif;font-weight: bold;box-sizing: border-box;}
			.swparafiscal-inner:before 
			{content: "SI";padding-left: 10px;background-color: #51C3E0;color: #FFFFFF;}
			.swparafiscal-inner:after 
			{content: "NO";padding-right: 10px;background-color: #EEEEEE; color: #999999;text-align: right;}
			.swparafiscal-switch 
			{display: block;width: 17px;margin: 3px;background: #FFFFFF;position: absolute;top: 0;bottom: 0;right: 44px;border: 2px solid #DDE6E2;border-radius: 20px;transition: all 0.3s ease-in 0s;}
			.swparafiscal-checkbox:checked + .swparafiscal-label .swparafiscal-inner {margin-left: 0;}
			.swparafiscal-checkbox:checked + .swparafiscal-label .swparafiscal-switch {right: 0px;}
		</style>
		<script>
			function guardar()
			{
				if(document.form2.totalinca.value>0)
				{
					if (document.form2.tercero.value!='' && document.form2.periodo.value!='')
					{
						despliegamodalm('visible','4','Esta Seguro de Guardar','1');
					}
					else{despliegamodalm('visible','2','Faltan datos para completar las vacaciones');}
				}
				else{despliegamodalm('visible','2','Falta asignar detalles a las vacaciones');}
				
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
			function funcionmensaje(){/*document.location.href = "";*/}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":
						document.form2.oculto.value="2";
						document.form2.submit();
						break;
					case "2": 
						document.form2.oculto.value="3";
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
					document.getElementById('ventana2').src="cargafuncionarios-ventana02.php?objeto=tercero";
				}
			}
			function fagregar()
			{
				if(document.form2.vigenciat.value!="")
				{
					if(document.form2.periodo.value!="-1")
					{
						if(document.form2.diasperiodo.value!="")
						{
							if(document.form2.salbas.value!="")
							{
								document.form2.oculto.value="4";
								document.form2.submit();
							}
							else{despliegamodalm('visible','2','Falta un funcionario con cargo asignado');}
						}
						else{despliegamodalm('visible','2','Falta asignar d�as de Vacaciones');}
					}
					else{despliegamodalm('visible','2','Falta asignar el mes');}
				}
				else{despliegamodalm('visible','2','Falta activar la vigencia actual');}
			}
			function eliminar(variable)
			{
				document.getElementById('elimina').value=variable;
				despliegamodalm('visible','4','Esta Seguro de Eliminar','2');
			}
			function cambiocheck(id)
			{	
				switch(id)
				{
					case '1':
						if(document.getElementById('idswibc').value=='S'){document.getElementById('idswibc').value='N';}
						else{document.getElementById('idswibc').value='S';}
						break;
					case '2':
						if(document.getElementById('idswarl').value=='S'){document.getElementById('idswarl').value='N';}
						else{document.getElementById('idswarl').value='S';}
						break;
					case '3':
						if(document.getElementById('idswparafiscal').value=='S'){document.getElementById('idswparafiscal').value='N';}
						else{document.getElementById('idswparafiscal').value='S';}
				}
				document.form2.submit();
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
  				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='hum-vacacionesagregar.php'" class="mgbt"/><img src="imagenes/guarda.png" title="Guardar" onClick="guardar()" class="mgbt"/><img src="imagenes/busca.png" title="Buscar" onClick="location.href='hum-vacacionesagregarbuscar.php'" class="mgbt"/><img src="imagenes/nv.png" title="nueva ventana"  class="mgbt" onClick="mypop=window.open('hum-principal.php','','');mypop.focus();"/><img src='imagenes/iratras.png' title='Men&uacute; Nomina' class='mgbt' onClick="location.href='hum-menunomina.php'"/></td>
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
					$consec=selconsecutivo('hum_vacaciones','num_vaca');
	 				$_POST[idcomp]=$consec;		
					$_POST[fecha]=date("Y-m-d"); 
					$_POST[vigenciat]=$vigusu;
					$sqlr="select salario from admfiscales where vigencia='$vigusu'";
					$resp = mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($resp)){$_POST[salmin]=$row[0];}
					$_POST[swibc]='S';
				}
				if($_POST[bt]=='1')
			 	{
			  		$nresul=buscatercero($_POST[tercero]);
			  		if($nresul!='')
			   		{
			  			$_POST[ntercero]=$nresul;
						$sqlr="
						SELECT codfun, GROUP_CONCAT(descripcion ORDER BY CONVERT(valor, SIGNED INTEGER) SEPARATOR '<->')
						FROM hum_funcionarios
						WHERE (item = 'VALESCALA') AND codfun=(SELECT codfun FROM hum_funcionarios WHERE descripcion='$_POST[tercero]' AND estado='S') AND estado='S'
						GROUP BY codfun";
			 			$resp2 = mysql_query($sqlr,$linkbd);
						$row2 =mysql_fetch_row($resp2);
						$_POST[salbas]=$row2[1];
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
					<td class="titulos" colspan="7">:: Asignar Vacaciones</td>
					<td class="cerrar" style="width:7%" onClick="location.href='hum-principal.php'">Cerrar</td>
				</tr>
				<tr> 
					<td class="saludo1" style="width:3.5cm;">No Vacaciones:</td>
					<td style="width:12%"><input name="idcomp" type="text" value="<?php echo $_POST[idcomp]?>" style="width:98%;" readonly/></td>
					<td class="saludo1"  style="width:4cm;">Fecha Registro:</td>
					<td style="width:12%"><input type="date" name="fecha"  value="<?php echo $_POST[fecha]?>" style="width:98%;" readonly/></td>
					<td class="saludo1" style="width:3.5cm;">Vigencia:</td>
					<td style="width:14%"><input type="text" name="vigenciat" id="vigenciat" value="<?php echo $_POST[vigenciat];?>" style="width:100%;" readonly/></td>
					<td rowspan="6" colspan="2" style="background:url(imagenes/vacaciones2.png); background-repeat:no-repeat; background-position:center; background-size: 60% 100%;" ></td>
				</tr>  
     			<tr>
       				<td class="saludo1">Funcionario:</td>
 					<td><input type="text" id="tercero" name="tercero" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo $_POST[tercero]?>" style="width:80%;"/>&nbsp;&nbsp;<img class="icobut" src="imagenes/find02.png"  title="Listado Terceros" onClick="despliegamodal2('visible');"/></td>
       			 	<td colspan="4"><input type="text" name="ntercero" id="ntercero" value="<?php echo $_POST[ntercero]?>" style="width: 100%;"readonly/></td> 
        			<input type="hidden" name="bt" id="bt" value="0"/>
         		</tr>       
      			<tr>
       				<td class="saludo1">No. Resoluci&oacute;n:</td>
       				<td><input type="text" name="incaeps" id="incaeps" value="<?php echo $_POST[incaeps]?>" style="width:98%;"/></td>
                   	<td class="saludo1">Fecha Inicial:</td>
                   	<td><input type="text" name="fechai" value="<?php echo $_POST[fechai]?>" maxlength="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" style="width:80%;">&nbsp;<img src="imagenes/calendario04.png" onClick="displayCalendarFor('fc_1198971545');" title="Calendario" class="icobut"/></td>
                   	<td class="saludo1">Fecha Final:</td>
					<td><input type="text" name="fechaf" value="<?php echo $_POST[fechaf]?>" maxlength="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971546" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" style="width:80%;">&nbsp;<img src="imagenes/calendario04.png" onClick="displayCalendarFor('fc_1198971546');" title="Calendario" class="icobut"/></td> 
          		</tr>   	 
         		<tr>
                	<td class="saludo1">Salario Basico:</td>
          			<td><input type="text" name="salbas" value="<?php echo $_POST[salbas]?>" style="width:100%;" /></td>
           			<td class="saludo1">Mes:</td>
          			<td >
          				<select name="periodo" id="periodo" style="width:98%;">
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
        			<td class="saludo1">Dias Vacaciones:</td>
        			<td><input type="text" name="diasperiodo" id="diasperiodo" value="<?php echo $_POST[diasperiodo]?>" style="width:98%;" /></td>
          			
       			</tr>   
                <tr>
                	<td class="saludo1" >Pagar EPS y AFP:</td>
        			<td style="width:7%">
                    	<div class="swibc">
                            <input type="checkbox" name="swibc" class="swibc-checkbox" id="idswibc" value="<?php echo $_POST[swibc];?>" <?php if($_POST[swibc]=='S'){echo "checked";}?> onChange="cambiocheck('1');"/>
                            <label class="swibc-label" for="idswibc">
                                <span class="swibc-inner"></span>
                                <span class="swibc-switch"></span>
                            </label>
                        </div>
           			</td>
                	<td class="saludo1" >Pagar ARL:</td>
        			<td style="width:7%">
                    	<div class="swarl">
                            <input type="checkbox" name="swarl" class="swarl-checkbox" id="idswarl" value="<?php echo $_POST[swarl];?>" <?php if($_POST[swarl]=='S'){echo "checked";}?> onChange="cambiocheck('2');"/>
                            <label class="swarl-label" for="idswarl">
                                <span class="swarl-inner"></span>
                                <span class="swarl-switch"></span>
                            </label>
                        </div>
           			</td>
                    <td class="saludo1" >Pagar Parafiscales:</td>
        			<td style="width:7%">
                    	<div class="swparafiscal">
                            <input type="checkbox" name="swparafiscal" class="swparafiscal-checkbox" id="idswparafiscal" value="<?php echo $_POST[swparafiscal];?>" <?php if($_POST[swparafiscal]=='S'){echo "checked";}?> onChange="cambiocheck('3');"/>
                            <label class="swparafiscal-label" for="idswparafiscal">
                                <span class="swparafiscal-inner"></span>
                                <span class="swparafiscal-switch"></span>
                            </label>
                        </div>
           			</td>
                </tr>
                <tr>
                    <td><label class="boton01" onClick="fagregar();">&nbsp;&nbsp;Agregar&nbsp;&nbsp;</label>
</td>
                </tr>          
    		</table> 
            <input type="hidden" name="oculto" id="oculto" value="1"/>
         	<input type="hidden" name="salmin" id="salmin"  value="<?php echo $_POST[salmin]?>"/>
			<div class="subpantalla" style="height:46.5%; width:50.6%;overflow-x:hidden" > 
      			<table class="inicio" width="99%">
          			<tr><td class="titulos" colspan="9">Detalles Vacaciones</td></tr>
                	<tr>
                    	<td class="titulos2" style="width:6%">Item</td>
                        <td class="titulos2">Vigencia</td>
                        <td class="titulos2">Mes</td>
                        <td class="titulos2">Dias</td>
                        <td class="titulos2">Valor Dia</td>
                        <td class="titulos2">Valor Total</td>
                        <td class="titulos2" style="width:8%">Eliminar</td>
                	</tr>
                    <?php
						if ($_POST[oculto]=='3')
						{ 
							$posi=$_POST[elimina];
							unset($_POST[viginca][$posi]);
							unset($_POST[mesinca][$posi]);
							unset($_POST[diasinca][$posi]);		 		 		 		 		 
							unset($_POST[valordiainca][$posi]);		 		 
							unset($_POST[valorinca][$posi]);		 
							$_POST[viginca]= array_values($_POST[viginca]); 
							$_POST[mesinca]= array_values($_POST[mesinca]); 
							$_POST[diasinca]= array_values($_POST[diasinca]); 
							$_POST[valordiainca]= array_values($_POST[valordiainca]); 		 		 		 		 
							$_POST[valorinca]= array_values($_POST[valorinca]); 	
							$_POST[elimina]='';	 		 		 		 
						}	 
						if ($_POST[oculto]=='4')
						{
									$totaldias=$_POST[diasperiodo];
									$saldia=$_POST[salbas]/30;
									$saldo1=$saldia*$totaldias;
									$_POST[viginca][]=$_POST[vigenciat];
									$_POST[mesinca][]=$_POST[periodo];
									$_POST[diasinca][]=$totaldias;
									$_POST[valordiainca][]=$saldia;
									$_POST[valorinca][]=$saldo1;
						}
					?>
                    <input type='hidden' name='elimina' id='elimina'/>
                    <?php
						$co="saludo1a";
		  				$co2="saludo2";
						$sumtotal=0;
						$_POST[totalinca]=count($_POST[valorinca]);
						$_POST[mestemp]="";
						$_POST[mesletras]="";
						$_POST[totaldiasinca]=0;
						for ($x=0;$x<$_POST[totalinca];$x++)
						{
							echo "
                        	<input type='hidden' name='mesinca[]' value='".$_POST[mesinca][$x]."'/>
							<input type='hidden' name='diasinca[]' value='".$_POST[diasinca][$x]."'/>
							<input type='hidden' name='valordiainca[]' value='".$_POST[valordiainca][$x]."'/>
							<input type='hidden' name='valorinca[]' value='".$_POST[valorinca][$x]."'/>
							<tr class='$co'>
								<td style='text-align:right;'>".($x+1)."&nbsp;</td>
								<td style='text-align:right;'><input type='text' name='viginca[]' value='".$_POST[viginca][$x]."' style='text-align:right; width:100%' class='inpnovisibles'/></td>
								<td style='text-align:right;'>".$_POST[mesinca][$x]."&nbsp;</td>
								<td style='text-align:right;'>".$_POST[diasinca][$x]."&nbsp;</td>
								<td style='text-align:right;'>$ ".number_format($_POST[valordiainca][$x],0)."&nbsp;</td>
								<td style='text-align:right;'>$ ".number_format($_POST[valorinca][$x],0)."&nbsp;</td>
								<td style='text-align:center;'><img src='imagenes/del.png' onclick='eliminar($x)' class='icoop'></td>
							</tr>";
							$_POST[totaldiasinca]+=$_POST[diasinca][$x];
							$sumtotal+=$_POST[valorinca][$x];
							$aux=$co;
							$co=$co2;
							$co2=$aux;
							if($_POST[mestemp]=="")
							{
								$_POST[mesletras]=mesletras($_POST[mesinca][$x]);
								$_POST[mestemp]=$_POST[mesinca][$x];
							}
							elseif($_POST[mestemp]!=$_POST[mesinca][$x])
							{
								$_POST[mesletras]=$_POST[mesletras]." - ".mesletras($_POST[mesinca][$x]);
								$_POST[mestemp]=$_POST[mesinca][$x];
							}
						}
						$totalred=round($sumtotal, 0, PHP_ROUND_HALF_UP);
						$_POST[valinca]=$totalred;
						$resultado = convertir($totalred);
						
						echo "
                    		<tr class='$iter' style='text-align:right;'>
                        		<td colspan='5'>Total:</td>
                        		<td>$ ".number_format($sumtotal,0)."</td>
                   			 </tr>
							<tr class='titulos2'>
								<td>Son:</td>
								<td colspan='6'>$resultado PESOS</td>
							</tr>";
					?>
                    <input type="hidden" name="valinca" value="<?php echo $_POST[valinca]?>"/>
                    <input type="hidden" name="totalinca" id="totalinca" value="<?php echo $_POST[totalinca]?>"/>
                    <input type="hidden" name="mesletras" value="<?php echo $_POST[mesletras]?>"/>
                    <input type="hidden" name="mestemp" value="<?php echo $_POST[mestemp]?>"/>
                    <input type="hidden" name="totaldiasinca" value="<?php echo $_POST[totaldiasinca]?>"/>
              	</table>
            </div>  
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
					$consec=selconsecutivo('hum_vacaciones','num_vaca');
					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechai],$fecha);
                    $fechai="$fecha[3]-$fecha[2]-$fecha[1]";
					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechaf],$fecha);
                    $fechaf="$fecha[3]-$fecha[2]-$fecha[1]";
					if($_POST[swibc]=='S'){$pagoibc='S';}
					else {$pagoibc='N';}
					if($_POST[swarl]=='S'){$pagoarl='S';}
					else {$pagoarl='N';}
					if($_POST[swparafiscal]=='S'){$pagopara='S';}
					else {$pagopara='N';}
  					$sqlr="INSERT INTO hum_vacaciones (num_vaca,fecha,vigencia,doc_funcionario,nom_funcionario,num_resolucion,salario,fecha_ini, fecha_fin,valor_total,paga_ibc,paga_arl,paga_para,meses,dias_total,estado) VALUES ('$consec','$_POST[fecha]','$_POST[vigenciat]', '$_POST[tercero]','$_POST[ntercero]','$_POST[incaeps]','$_POST[salbas]','$fechai','$fechaf','$_POST[valinca]','$pagoibc','$pagoarl','$pagopara', '$_POST[mesletras]','$_POST[totaldiasinca]','S')";
	  				if (mysql_query($sqlr,$linkbd))
					{
						echo "<script>despliegamodalm('visible','1','Incapacidad Almacenada Exitosamente');</script>";
		 				for($y=0;$y<$_POST[totalinca];$y++)
		 				{
							$consdet=selconsecutivo('hum_vacaciones_det','id_det');
		  					$sqlr="INSERT INTO hum_vacaciones_det (id_det,doc_funcionario,num_vaca,vigencia,mes,dias_vaca,valor_dia,valor_total, pagar_ibc,pagar_arl,pagar_para,estado) VALUES ('$consdet','$_POST[tercero]','$consec','".$_POST[viginca][$y]."','".$_POST[mesinca][$y]."','".$_POST[diasinca][$y]."','".$_POST[valordiainca][$y]."','".$_POST[valorinca][$y]."','$pagoibc','$pagoarl','$pagopara','S')";
		  					mysql_query($sqlr,$linkbd);
		 				}
					}
					else {echo"<script>despliegamodalm('visible','2','Error al Almacenar Incapacidad');</script>";}
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