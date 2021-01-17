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
        <title>:: Spid - Contabilidad</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		
		<script>
			function guardar()
			{
				despliegamodalm('visible','4','Esta Seguro de Guardar','1');
			}
			function buscacuentas(e,_cuenta)
			{
				switch(_cuenta)
				{
					case "1":	if (document.form2.cuentamiles.value!=""){document.form2.bcc.value='1';;}break;
					case "2":	if (document.form2.cuentautilidad.value!=""){document.form2.bcc.value='2';}break;
					case "3":	if (document.form2.cuentacierredef.value!=""){document.form2.bcc.value='3';}break;
					case "4":	if (document.form2.cuentacierre.value!=""){document.form2.bcc.value='4';}break;
					case "5":	if (document.form2.cuentaemipre.value!=""){document.form2.bcc.value='5';}break;
					case "6":	if (document.form2.cuentarecpre.value!=""){document.form2.bcc.value='6';}break;
					case "7":	if (document.form2.cuentaemibom.value!=""){document.form2.bcc.value='7';}break;
					case "8":	if (document.form2.cuentarecbom.value!=""){document.form2.bcc.value='8';}break;
				}
				document.form2.submit();
			}
			function buscactacd(e){if (document.form2.cuentac.value!=""){document.form2.bccd.value='1';document.form2.submit();}}
			function despliegamodal2(_valor,_nomve)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else 
				{
					var opsession=document.getElementById('sessionopen').value;
					switch(_nomve)
					{
						case "1":	var direcventana="cuentasgral-ventana01.php?vigencia="+opsession+"&objeto=cuentamiles&nobjeto=ncuentamiles";break;
						case "2":	var direcventana="cuentasgral-ventana01.php?vigencia="+opsession+"&objeto=cuentautilidad&nobjeto=ncuentautilidad";break;
						case "3":	var direcventana="cuentasgral-ventana01.php?vigencia="+opsession+"&objeto=cuentacierredef&nobjeto=ncuentacierredef";break;
						case "4":	var direcventana="cuentasgral-ventana01.php?vigencia="+opsession+"&objeto=cuentacierre&nobjeto=ncuentacierre";break;
						case "5":	var direcventana="cuentasgral-ventana01.php?vigencia="+opsession+"&objeto=cuentaemipre&nobjeto=ncuentaemipre";break;
						case "6":	var direcventana="cuentasgral-ventana01.php?vigencia="+opsession+"&objeto=cuentarecpre&nobjeto=ncuentarecpre";break;
						case "7":	var direcventana="cuentasgral-ventana01.php?vigencia="+opsession+"&objeto=cuentaemibom&nobjeto=ncuentaemibom";break;
						case "8":	var direcventana="cuentasgral-ventana01.php?vigencia="+opsession+"&objeto=cuentarecbom&nobjeto=ncuentarecbom";break;
					}
					document.getElementById('ventana2').src=direcventana;
				}
			}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden")
				{
					document.getElementById('ventanam').src="";
					switch(document.getElementById('valfocus').value)
					{
						case "1":	document.form2.cuentamiles.focus();
									document.form2.cuentamiles.select();
									break;
						case "2":	document.form2.cuentautilidad.focus();
									document.form2.cuentautilidad.select();
									break;
						case "3":	document.form2.cuentacierredef.focus();
									document.form2.cuentacierredef.select();
									break;
						case "4":	document.form2.cuentacierre.focus();
									document.form2.cuentacierre.select();
									break;
						case "5":	document.form2.cuentaemipre.focus();
									document.form2.cuentaemipre.select();
									break;
						case "6":	document.form2.cuentarecpre.focus();
									document.form2.cuentarecpre.select();
									break;
						case "7":	document.form2.cuentaemibom.focus();
									document.form2.cuentaemibom.select();
									break;
						case "8":	document.form2.cuentarecbom.focus();
									document.form2.cuentarecbom.select();
									break;
					}
					document.getElementById('valfocus').value='0';
				}
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
							document.getElementById('ventanam').src="ventana-consulta2.php?titulos="+mensa+"&idresp="+pregunta;break;	
						case "5":
							document.getElementById('ventanam').src="ventana-mensaje5.php?titulos="+mensa;break;
					}
				}
			}
			function funcionmensaje(){}
			function respuestaconsulta(estado,pregunta)
			{
				if(estado=="S")
				{
					switch(pregunta)
					{
						case "1":	document.form2.oculto.value="2";
				 					document.form2.submit();break;
					}
				}
				else
				{
					switch(pregunta)
					{
						case "1":	break;
					}
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
					<a class="mgbt"><img src="imagenes/add2.png"/></a>
					<a href="#" class="mgbt" onClick="guardar()"><img src="imagenes/guarda.png"  title="Guardar"/></a>
					<a class="mgbt"><img src="imagenes/buscad.png"/></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" class="mgbt" onClick="<?php echo paginasnuevas("cont");?>"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
				</td>
  			</tr>
   		</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
		<?php
   			if($_POST[oculto]=="")
   			{ 
				$_POST[sessionopen]=$_SESSION[vigencia];
				$sqlr="select valor_inicial from dominios where nombre_dominio='CUENTA_MILES'";
				$res=mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($res)) 
				{
	 				$_POST[cuentamiles]=$row[0];
	 				$_POST[ncuentamiles]=buscacuenta($_POST[cuentamiles]);
				}
				//***excedente
				$sqlr="select valor_inicial from dominios where nombre_dominio='CUENTA_EXCEDENTE'";
				$res=mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($res)) 
				{
				 	$_POST[cuentautilidad]=$row[0];
				 	$_POST[ncuentautilidad]=buscacuenta($_POST[cuentautilidad]);
				}
				//**** deficit
				$sqlr="select valor_inicial from dominios where nombre_dominio='CUENTA_DEFICIT'";
				$res=mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($res)) 
				{
				 	$_POST[cuentacierredef]=$row[0];
					$_POST[ncuentacierredef]=buscacuenta($_POST[cuentacierredef]);
				}
				//**** resultado
				$sqlr="select valor_inicial from dominios where nombre_dominio='CUENTA_CIERRE_EJERCICIO'";
				$res=mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($res)) 
				{
	 				$_POST[cuentacierre]=$row[0];
	 				$_POST[ncuentacierre]=buscacuenta($_POST[cuentacierre]);
				}
				//**** resultado
				$sqlr="select valor_inicial from dominios where nombre_dominio='CUENTA_EMISORA_PREDIAL'";
				$res=mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($res)) 
				{
	 				$_POST[cuentaemipre]=$row[0];
	 				$_POST[ncuentaemipre]=buscacuenta($_POST[cuentaemipre]);
				}//**** resultado
				$sqlr="select valor_inicial from dominios where nombre_dominio='CUENTA_RECEPTORA_PREDIAL'";
				$res=mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($res)) 
				{
	 				$_POST[cuentarecpre]=$row[0];
	 				$_POST[ncuentarecpre]=buscacuenta($_POST[cuentarecpre]);
				}//**** resultado
				$sqlr="select valor_inicial from dominios where nombre_dominio='CUENTA_EMISORA_BOMBERIL'";
				$res=mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($res)) 
				{
	 				$_POST[cuentaemibom]=$row[0];
	 				$_POST[ncuentaemibom]=buscacuenta($_POST[cuentaemibom]);
				}//**** resultado
				$sqlr="select valor_inicial from dominios where nombre_dominio='CUENTA_RECEPTORA_BOMBERIL'";
				$res=mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($res)) 
				{
	 				$_POST[cuentarecbom]=$row[0];
					$_POST[ncuentarecbom]=buscacuenta($_POST[cuentarecbom]);
				}//**** resultado
				$_POST[oculto]="0";
			}
		?>
    	<form name="form2" method="post" action="cont-parametroscierre.php">
        	<input type="hidden" name="valfocus" id="valfocus" value="0"/>
            <input type="hidden" name="sessionopen" id="sessionopen" value="<?php echo $_POST[sessionopen];?>"/>
    		<table class="inicio" >
      			<tr>
        			<td class="titulos" colspan="4">:: Par&aacute;metros de Cierre Ajuste Miles</td>
                    <td class="cerrar" style="width:7%"><a href="cont-principal.php">&nbsp;Cerrar</a></td>
     			</tr>
       			<tr>
                	<td class="saludo1" style="width:10%;">:: Ajuste a Miles:</td><!--1-->
        			<td style="width:60%;">
                    	<input type="text" name="cuentamiles" id="cuentamiles" value="<?php echo $_POST[cuentamiles]?>" style="width:10%;" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="buscacuentas(event,'1');" onClick="document.getElementById('cuentamiles').select();"> <a href="#" onClick="despliegamodal2('visible','1')">&nbsp;<img src="imagenes/find02.png" style="width:20px;" align="absmiddle" border="0"></a> <input type="text" id="ncuentamiles" name="ncuentamiles" value="<?php echo $_POST[ncuentamiles]?>" style="width:42%;" readonly></td>
        		</tr>       
     		</table>
      		<table class="inicio">  
     			<tr><td class="titulos" colspan="4">:: Par&aacute;metros de Cierre de Cuentas de Resultado</td></tr>
           		<tr>
        			<td class="saludo1" style="width:13%;">:: Cuenta Excedente Ejercicio:</td><!--2-->
        			<td><input id="cuentautilidad" name="cuentautilidad" type="text" value="<?php echo $_POST[cuentautilidad]?>" size="15" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="buscacuentas(event,'2');"  onClick="document.getElementById('cuentautilidad').select();"> <a href="#" onClick="despliegamodal2('visible','2');">&nbsp;<img src="imagenes/find02.png" style="width:20px;"align="absmiddle" border="0"></a> <input id="ncuentautilidad"  name="ncuentautilidad" type="text" value="<?php echo $_POST[ncuentautilidad]?>" size="80" readonly></td>
        		</tr>           
           		<tr>
        			<td class="saludo1">:: Cuenta Deficit Ejercicio:</td><!--3-->
        			<td><input id="cuentacierredef" name="cuentacierredef" type="text" value="<?php echo $_POST[cuentacierredef]?>" size="15" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="buscacuentas(event,'3');"  onClick="document.getElementById('cuentacierredef').select();"> <a href="#" onClick="despliegamodal2('visible','3');">&nbsp;<img src="imagenes/find02.png" style="width:20px;" align="absmiddle" border="0"></a> <input id="ncuentacierredef"  name="ncuentacierredef" type="text" value="<?php echo $_POST[ncuentacierredef]?>" size="80" readonly></td>
        		</tr>   
            	<tr>
        			<td class="saludo1">:: Cuenta Cierre Ejercicio:</td><!--4-->
        			<td><input id="cuentacierre" name="cuentacierre" type="text" value="<?php echo $_POST[cuentacierre]?>" size="15" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="buscacuentas(event,'4');"  onClick="document.getElementById('cuentacierre').select();"> <a href="#" onClick="despliegamodal2('visible','4');">&nbsp;<img src="imagenes/find02.png" style="width:20px;" align="absmiddle" border="0"></a> <input id="ncuentacierre"  name="ncuentacierre" type="text" value="<?php echo $_POST[ncuentacierre]?>" size="80" readonly> <input type="hidden" value="<?php echo $_POST[oculto]?>" name="oculto"></td>
        		</tr>   
    		</table>
      		<table class="inicio">  
     			<tr><td class="titulos" colspan="4">:: Par&aacute;metros de Cierre de Predial</td></tr>
           		<tr>
        			<td  class="saludo1" style="width:13%;">:: Cuenta Emisora Predial:</td><!--5-->
        			<td><input id="cuentaemipre" name="cuentaemipre" type="text" value="<?php echo $_POST[cuentaemipre]?>" size="15" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="buscacuentas(event,'5');"  onClick="document.getElementById('cuentaemipre').select();"><a href="#" onClick="despliegamodal2('visible','5');">&nbsp;<img src="imagenes/find02.png" style="width:20px;" align="absmiddle" border="0"></a> <input id="ncuentaemipre"  name="ncuentaemipre" type="text" value="<?php echo $_POST[ncuentaemipre]?>" size="80" readonly></td>
        		</tr>           
           		<tr>
        			<td  class="saludo1">:: Cuenta Receptora Predial:</td><!--6-->
        			<td><input id="cuentarecpre" name="cuentarecpre" type="text" value="<?php echo $_POST[cuentarecpre]?>" size="15" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="buscacuentas(event,'6');"  onClick="document.getElementById('cuentarecpre').select();"><a href="#" onClick="despliegamodal2('visible','6');">&nbsp;<img src="imagenes/find02.png" style="width:20px;" align="absmiddle" border="0"></a> <input id="ncuentarecpre"  name="ncuentarecpre" type="text" value="<?php echo $_POST[ncuentarecpre]?>" size="80" readonly></td>
        		</tr>   
            	<tr>
        			<td  class="saludo1">:: Cuenta Emisora Bomberil:</td><!--7-->
        			<td><input id="cuentaemibom" name="cuentaemibom" type="text" value="<?php echo $_POST[cuentaemibom]?>" size="15" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="buscacuentas(event,'7');"  onClick="document.getElementById('cuentaemibom').select();"><a href="#" onClick="despliegamodal2('visible','7');">&nbsp;<img src="imagenes/find02.png" style="width:20px;" align="absmiddle" border="0"></a> <input id="ncuentaemibom"  name="ncuentaemibom" type="text" value="<?php echo $_POST[ncuentaemibom]?>" size="80" readonly></td>
        		</tr>   
            	<tr>
       				<td  class="saludo1">:: Cuenta Receptora Bomberil:</td><!--8-->
        			<td><input id="cuentarecbom" name="cuentarecbom" type="text" value="<?php echo $_POST[cuentarecbom]?>" size="15" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="buscacuentas(event,'8');"  onClick="document.getElementById('cuentarecbom').select();"><a href="#" onClick="despliegamodal2('visible','8');">&nbsp;<img src="imagenes/find02.png" style="width:20px;" align="absmiddle" border="0"></a> <input id="ncuentarecbom"  name="ncuentarecbom" type="text" value="<?php echo $_POST[ncuentarecbom]?>" size="80" readonly></td>
        		</tr>   
    		</table>    
            <input type="hidden" name="bcc" id="bcc" value="">
  			<?php
				switch($_POST[bcc])
   				{ 
					case "":	break;
					case "1":	$nresul=buscacuenta($_POST[cuentamiles]);
								if($nresul!='')
								{	
									echo "
									<script>
										document.getElementById('bcc').value='';
										document.getElementById('ncuentamiles').value='$nresul'; 
									</script>";
								}
								else
								{
									echo "
									<script>
										document.getElementById('ncuentamiles').value='';
										document.getElementById('valfocus').value='1';
										despliegamodalm('visible','2','Cuenta Incorrecta');
									</script>";
								}break;
					case "2":	$nresul=buscacuenta($_POST[cuentautilidad]);
								if($nresul!='')
								{
									echo "
									<script>
										document.getElementById('bcc').value='';
										document.getElementById('ncuentautilidad').value='$nresul'; 
									</script>";
								}
								else
								{
									echo "
									<script>
										document.getElementById('ncuentautilidad').value='';
										document.getElementById('valfocus').value='2';
										despliegamodalm('visible','2','Cuenta Incorrecta');
									</script>";
								}break;
					case "3":	$nresul=buscacuenta($_POST[cuentacierredef]);
								if($nresul!='')
								{
									echo "
									<script>
										document.getElementById('bcc').value='';
										document.getElementById('ncuentacierredef').value='$nresul'; 
									</script>";
								}
								else
								{
									echo "
									<script>
										document.getElementById('ncuentacierredef').value='';
										document.getElementById('valfocus').value='3';
										despliegamodalm('visible','2','Cuenta Incorrecta');
									</script>";
								}break;
					case "4":	$nresul=buscacuenta($_POST[cuentacierre]);
								if($nresul!='')
								{
									echo "
									<script>
										document.getElementById('bcc').value='';
										document.getElementById('ncuentacierre').value='$nresul'; 
									</script>";
								}
								else
								{
									echo "
									<script>
										document.getElementById('ncuentacierre').value='';
										document.getElementById('valfocus').value='4';
										despliegamodalm('visible','2','Cuenta Incorrecta');
									</script>";
								}break;
					case "5":	$nresul=buscacuenta($_POST[cuentaemipre]);
								if($nresul!='')
								{
									echo "
									<script>
										document.getElementById('bcc').value='';
										document.getElementById('ncuentaemipre').value='$nresul'; 
									</script>";
								}
								else
								{
									echo "
									<script>
										document.getElementById('ncuentaemipre').value='';
										document.getElementById('valfocus').value='5';
										despliegamodalm('visible','2','Cuenta Incorrecta');
									</script>";
								}break;
					case "6":	$nresul=buscacuenta($_POST[cuentarecpre]);
								if($nresul!='')
								{
									echo "
									<script>
										document.getElementById('bcc').value='';
										document.getElementById('ncuentarecpre').value='$nresul'; 
									</script>";
								}
								else
								{
									echo "
									<script>
										document.getElementById('ncuentarecpre').value='';
										document.getElementById('valfocus').value='6';
										despliegamodalm('visible','2','Cuenta Incorrecta');
									</script>";
								}break;
					case "7":	$nresul=buscacuenta($_POST[cuentaemibom]);
								if($nresul!='')
								{
									echo "
									<script>
										document.getElementById('bcc').value='';
										document.getElementById('ncuentaemibom').value='$nresul'; 
									</script>";
								}
								else
								{
									echo "
									<script>
										document.getElementById('ncuentaemibom').value='';
										document.getElementById('valfocus').value='7';
										despliegamodalm('visible','2','Cuenta Incorrecta');
									</script>";
								}break;
					case "8":	$nresul=buscacuenta($_POST[cuentarecbom]);
								if($nresul!='')
								{
									echo "
									<script>
										document.getElementById('bcc').value='';
										document.getElementById('ncuentarecbom').value='$nresul'; 
									</script>";
								}
								else
								{
									echo "
									<script>
										document.getElementById('ncuentarecbom').value='';
										document.getElementById('valfocus').value='8';
										despliegamodalm('visible','2','Cuenta Incorrecta');
									</script>";
								}break;
				}
				if($_POST[oculto]=="2")
				{	
					$mencarga="";
					$menerrores="";
					//CUENTA MILES
					$sqlr="delete from dominios  where nombre_dominio='CUENTA_MILES' ";
					if(mysql_query($sqlr,$linkbd))
					{
						$sqlr="insert into dominios (valor_inicial,valor_final,descripcion_valor,nombre_dominio,tipo,descripcion_dominio) values ('$_POST[cuentamiles]','','$_POST[ncuentamiles]','CUENTA_MILES','','Cuenta ajuste a los miles') ";
						if (!mysql_query($sqlr,$linkbd)){$menerrores="-Cuenta Ajuste a Miles Error: ".mysql_error($linkbd)."--";}
						else{$mencarga="-Cuenta Ajuste a Miles.--";}
					}
					else{$menerrores="-Cuenta Ajuste a Miles Error: ".mysql_error($linkbd)."--";}
					//****excedente
					$sqlr="delete from dominios  where nombre_dominio='CUENTA_EXCEDENTE' ";
					if(mysql_query($sqlr,$linkbd))
					{
						$sqlr="insert into dominios (valor_inicial,valor_final,descripcion_valor,nombre_dominio,tipo,descripcion_dominio) values ('$_POST[cuentautilidad]','','$_POST[ncuentautilidad]','CUENTA_EXCEDENTE','','Cuenta EXCEDENTE DEL EJERCICIO') ";
						if (!mysql_query($sqlr,$linkbd)){$menerrores=$menerrores."-Cuenta Excedente Ejercicio Error: ".mysql_error($linkbd)."--";}
						else{$mencarga=$mencarga."-Cuenta Excedente Ejercicio.--";}
					}
					else{$menerrores=$menerrores."-Cuenta Excedente Ejercicio Error: ".mysql_error($linkbd)."--";}
					//****DEFICIT
					$sqlr="delete from dominios  where nombre_dominio='CUENTA_DEFICIT' ";
					if(mysql_query($sqlr,$linkbd))
					{
						$sqlr="insert into dominios (valor_inicial,valor_final,descripcion_valor,nombre_dominio,tipo,descripcion_dominio) values ('$_POST[cuentacierredef]','','$_POST[ncuentacierredef]','CUENTA_DEFICIT','','Cuenta DEFICIT DEL EJERCICIO') ";
						if (!mysql_query($sqlr,$linkbd)){$menerrores=$menerrores."-Cuenta Deficit Ejercicio Error: ".mysql_error($linkbd)."--";}
						else {$mencarga=$mencarga."-Cuenta Deficit Ejercicio.--";}
					}
					else {$menerrores=$menerrores."-Cuenta Deficit Ejercicio Error: ".mysql_error($linkbd)."--";}
					//****CIERRE DEL EJERCICIO
					$sqlr="delete from dominios  where nombre_dominio='CUENTA_CIERRE_EJERCICIO' ";
					if(mysql_query($sqlr,$linkbd))
					{
						$sqlr="insert into dominios (valor_inicial,valor_final,descripcion_valor,nombre_dominio,tipo,descripcion_dominio) values ('$_POST[cuentacierre]','','$_POST[ncuentacierre]','CUENTA_CIERRE_EJERCICIO','','Cuenta CIERRE DEL EJERCICIO') ";
						if (!mysql_query($sqlr,$linkbd)){$menerrores=$menerrores."-Cuenta Cierre Ejercicio Error: ".mysql_error($linkbd)."--";}
						else {$mencarga=$mencarga."-Cuenta Cierre Ejercicio.--";}
					}
					else {$menerrores=$menerrores."-Cuenta Cierre Ejercicio Error: ".mysql_error($linkbd)."--";} 
					//****EMISORA PREDIAL
					$sqlr="delete from dominios  where nombre_dominio='CUENTA_EMISORA_PREDIAL' ";
					if(mysql_query($sqlr,$linkbd))
					{
						$sqlr="insert into dominios (valor_inicial,valor_final,descripcion_valor,nombre_dominio,tipo,descripcion_dominio) values ('$_POST[cuentaemipre]','','$_POST[ncuentaemipre]','CUENTA_EMISORA_PREDIAL','','Cuenta EMISORA PREDIAL') ";
						if (!mysql_query($sqlr,$linkbd)){$menerrores=$menerrores."-Cuenta Emisora Predial Error: ".mysql_error($linkbd)."--";}
						else
						{$mencarga=$mencarga."-Cuenta Emisora Predial.--";}
					}
					else {$menerrores=$menerrores."-Cuenta Emisora Predial Error: ".mysql_error($linkbd)."--";}
					//****RECEPTORA PREDIAL
					$sqlr="delete from dominios  where nombre_dominio='CUENTA_RECEPTORA_PREDIAL' ";
					if(mysql_query($sqlr,$linkbd))
					{
						$sqlr="insert into dominios (valor_inicial,valor_final,descripcion_valor,nombre_dominio,tipo,descripcion_dominio) values ('$_POST[cuentarecpre]','','$_POST[ncuentarecpre]','CUENTA_RECEPTORA_PREDIAL','','Cuenta RECEPTORA PREDIAL') ";
						if (!mysql_query($sqlr,$linkbd)){$menerrores=$menerrores."-Cuenta Receptora Predial Error: ".mysql_error($linkbd)."--";}
						else {$mencarga=$mencarga."-Cuenta Receptora Predial.--";}
					}
					else {$menerrores=$menerrores."-Cuenta Receptora Predial Error: ".mysql_error($linkbd)."--";}
					//**** EMISORA BOMBERIL
					$sqlr="delete from dominios  where nombre_dominio='CUENTA_EMISORA_BOMBERIL' ";
					if(mysql_query($sqlr,$linkbd))
					{
						$sqlr="insert into dominios (valor_inicial,valor_final,descripcion_valor,nombre_dominio,tipo,descripcion_dominio) values ('$_POST[cuentaemibom]','','$_POST[ncuentaemibom]','CUENTA_EMISORA_BOMBERIL','','Cuenta CUENTA_EMISORA_BOMBERIL') ";
						if (!mysql_query($sqlr,$linkbd)){$menerrores=$menerrores."-Cuenta Emisora Bomberil Error: ".mysql_error($linkbd).", ";}
						else {$mencarga=$mencarga."-Cuenta Emisora Bomberil.--";}
					}
					else {$menerrores=$menerrores."-Cuenta Emisora Bomberil Error: ".mysql_error($linkbd)."--";}
					//****CUENTA_RECEPTORA_BOMBERIL
					$sqlr="delete from dominios  where nombre_dominio='CUENTA_RECEPTORA_BOMBERIL' ";
					if(mysql_query($sqlr,$linkbd))
					{
						$sqlr="insert into dominios (valor_inicial,valor_final,descripcion_valor,nombre_dominio,tipo,descripcion_dominio) values ('$_POST[cuentarecbom]','','$_POST[ncuentarecbom]','CUENTA_RECEPTORA_BOMBERIL','','Cuenta CUENTA_RECEPTORA_BOMBERIL') ";
						if (!mysql_query($sqlr,$linkbd)){$menerrores=$menerrores."-Cuenta Receptora Bomberil Error: ".mysql_error($linkbd)."--";}
						else
						{$mencarga=$mencarga."-Cuenta Receptora Bomberil.--";}
					}
					else {$menerrores=$menerrores."-Cuenta Receptora Bomberil Error: ".mysql_error($linkbd)."--";}
					$echomensaje="Se almacenaron con exito las cuantas:--".$mencarga." No se almacenaron las Cuentas:--".$menerrores;
					
					echo "<script>despliegamodalm('visible','5','$echomensaje');</script>";
				}
			?>
            <div id="bgventanamodal2">
                <div id="ventanamodal2">
                    <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                    </IFRAME>
                </div>
       	 	</div> 
		</form>
	</body>
</html>