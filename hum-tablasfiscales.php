<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
  	require "funciones.inc";
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
		<title>:: Spid - Gestion Humana</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<script>
			function guardar()
			{
				if (document.getElementById('nicbf').value!='' && document.getElementById('nsena').value!='' && document.getElementById('niti').value!='' && document.getElementById('ncajas').value!='' && document.getElementById('nesap').value!='')
				{despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
  				else{despliegamodalm('visible','2','Faltan datos para completar el registro');}
			}
			function despliegamodal2(_valor,_nven)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else 
				{
					switch (_nven) 
					{ 
						case "1":	
							document.getElementById('ventana2').src="tercerosgral-ventana01.php?objeto=icbf&nobjeto=nicbf&nfoco=sena";break;
						case "2":	
							document.getElementById('ventana2').src="tercerosgral-ventana01.php?objeto=sena&nobjeto=nsena&nfoco=iti";break;
						case "3":	
							document.getElementById('ventana2').src="tercerosgral-ventana01.php?objeto=iti&nobjeto=niti&nfoco=cajas";break;
						case "4":	
							document.getElementById('ventana2').src="tercerosgral-ventana01.php?objeto=cajas&nobjeto=ncajas&nfoco=esap";break;
						case "5":	
							document.getElementById('ventana2').src="tercerosgral-ventana01.php?objeto=esap&nobjeto=nesap&nfoco=indiceinca";break;
					case "6":	
							document.getElementById('ventana2').src="tercerosgral-ventana01.php?objeto=arp&nobjeto=narp&nfoco=arp";break;	
					}
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
						case "0":	break;
						case "1": 	document.getElementById('valfocus').value='0';
									document.getElementById('nicbf').value='';
									document.getElementById('icbf').focus();
									document.getElementById('icbf').select();break;
						case "2": 	document.getElementById('valfocus').value='0';
									document.getElementById('nsena').value='';
									document.getElementById('sena').focus();
									document.getElementById('sena').select();break;
						case "3": 	document.getElementById('valfocus').value='0';
									document.getElementById('niti').value='';
									document.getElementById('iti').focus();
									document.getElementById('iti').select();break;
						case "4": 	document.getElementById('valfocus').value='0';
									document.getElementById('ncajas').value='';
									document.getElementById('cajas').focus();
									document.getElementById('cajas').select();break;
						case "5": 	document.getElementById('valfocus').value='0';
									document.getElementById('nivsal').value='';
									document.getElementById('nesap').value='';
									document.getElementById('esap').focus();
									document.getElementById('esap').select();break;
						case "6": 	document.getElementById('valfocus').value='0';									
									document.getElementById('arp').focus();
									document.getElementById('arp').select();break;			
					}
				}
				else
				{
					switch(_tip)
					{
						case "1":	document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
						case "2":	document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
						case "3":	document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
						case "4":	document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;	
					}
				}
			}
			function funcionmensaje(){document.location.href = "";}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.getElementById('oculto').value="2";
								document.form2.submit();break;
				}
			}
			function busquedas(_nbus)
			{
				switch(_nbus)
				{
					case "1":	if (document.getElementById('icbf').value!="")
								{document.getElementById('banbus').value="1";document.form2.submit();}
								break;
					case "2":	if (document.getElementById('sena').value!="")
								{document.getElementById('banbus').value="2";document.form2.submit();}
								break;
					case "3":	if (document.getElementById('iti').value!="")
								{document.getElementById('banbus').value="3";document.form2.submit();}
								break;
					case "4":	if (document.getElementById('cajas').value!="")
								{document.getElementById('banbus').value="4";document.form2.submit();}
								break;
					case "5":	if (document.getElementById('esap').value!="")
								{document.getElementById('banbus').value="5";document.form2.submit();}
								break;
					case "6":	if (document.getElementById('arp').value!="")
								{document.getElementById('banbus').value="6";document.form2.submit();}
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
    		<tr><script>barra_imagenes("hum");</script><?php cuadro_titulos();?></tr>	 
    		<tr><?php menu_desplegable("hum");?></tr>
			<tr>
  				<td colspan="3" class="cinta"><a href="hum-tablasfiscales.php" onClick="hum-tablasfiscales.php" class="mgbt"><img src="imagenes/add.png"  title="Nuevo" /></a><a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar"/></a><a href="hum-buscatablasfiscales.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a><a href="#" onClick="mypop=window.open('hum-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="nueva ventana"></a></td></tr>		
		</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
        <form name="form2" method="post">
        	<input type="hidden" name="valfocus" id="valfocus" value="0"/>
			<?php
                $vigusu=vigencia_usuarios($_SESSION[cedulausu]);
                if($_POST[oculto]=="")
                {
                     
                    $_POST[vigencia]=$vigusu;   
                    $_POST[uvt]=0;
                    $_POST[salario]=0;
                    $_POST[transporte]=0;
                    $_POST[alimentacion]=0;
                    $_POST[bfsol]=0;
                    $_POST[balimentacion]=0;
                    $_POST[btransporte]=0;
					$_POST[indiceinca]=0;
                }
            ?>
    		<table class="inicio" >
      			<tr>
        			<td class="titulos" colspan="4">:: Tablas Fiscales</td>
                    <td class="cerrar" style="width:7%;" ><a href="hum-principal.php">&nbsp;Cerrar</a></td>
      			</tr>
      			<tr>
        			<td class="saludo1" style="width:18%">:: 	Vigencia:</td>
        			<td style="width:30%"><input type="text" name="vigencia" value="<?php echo $_POST[vigencia]?>" maxlength="4" onKeyPress="javascript:return solonumeros(event)" style="width:30%"></td>
				</tr>
      			<tr>
        			<td class="saludo1">:: UVT:</td>
        			<td><input name="uvt" type="text" value="<?php echo $_POST[uvt]?>"  onKeyPress="javascript:return solonumeros(event)" style="width:30%"></td>
        			<td class="saludo1" style="width:16%">:: Salario Minimo:</td>
        			<td><input name="salario" type="text" value="<?php echo $_POST[salario]?>" onKeyPress="javascript:return solonumeros(event)" style="width:30%"></td>
        		</tr>
        		<tr>
         			<td class="saludo1">:: Subsidio Transporte:</td>
        			<td><input name="transporte" type="text" value="<?php echo $_POST[transporte]?>" onKeyPress="javascript:return solonumeros(event)" style="width:30%"></td>
         			<td class="saludo1">:: Subsidio Alimentacion:</td>
        			<td><input name="alimentacion" type="text" value="<?php echo $_POST[alimentacion]?>" onKeyPress="javascript:return solonumeros(event)" style="width:30%"></td>
       			</tr>    
          		<tr>
         			<td class="saludo1">:: Base F Solidaridad:</td>
        			<td><input name="bfsol" type="text" value="<?php echo $_POST[bfsol]?>"  onKeyPress="javascript:return solonumeros(event)" style="width:30%"></td>
         			<td class="saludo1">:: Base Aux Alimentacion:</td>
        			<td><input name="balimentacion" type="text" value="<?php echo $_POST[balimentacion]?>"  onKeyPress="javascript:return solonumeros(event)" style="width:30%"></td>
       			</tr>               
          		<tr>
         			<td class="saludo1">:: Base Aux Transporte:</td>
        			<td><input name="btransporte" type="text" value="<?php echo $_POST[btransporte]?>" onKeyPress="javascript:return solonumeros(event)" style="width:30%"></td>
        			<td class="saludo1">.: ICBF:</td>
        			<td><input id="icbf" name="icbf" type="text" value="<?php echo $_POST[icbf]?>" onKeyUp="return tabular(event,this)" style="width:25%" onBlur="busquedas('1')"/>&nbsp;<a href="#" onClick="despliegamodal2('visible','1');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>&nbsp;<input id="nicbf" name="nicbf" type="text" value="<?php echo $_POST[nicbf]?>" onKeyUp="return tabular(event,this)" style="width:65%" readonly> </td>
             	</tr>
				<tr>
                	<td class="saludo1">.: SENA:</td>
        			<td><input id="sena" name="sena" type="text" value="<?php echo $_POST[sena]?>"  onKeyUp="return tabular(event,this)" style="width:25%" onBlur="busquedas('2')">&nbsp;<a href="#" onClick="despliegamodal2('visible','2');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>&nbsp;<input id="nsena" name="nsena" type="text" value="<?php echo $_POST[nsena]?>"  onKeyUp="return tabular(event,this)" style="width:65%" readonly> </td>
        			<td class="saludo1">.: Institutos Tecnicos:</td>
        			<td><input id="iti" name="iti" type="text" value="<?php echo $_POST[iti]?>" onKeyUp="return tabular(event,this)" style="width:25%" onBlur="busquedas('3')">&nbsp;<a href="#" onClick="despliegamodal2('visible','3');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>&nbsp;<input id="niti" name="niti" type="text" value="<?php echo $_POST[niti]?>" onKeyUp="return tabular(event,this)" style="width:65%" readonly> </td>
            	</tr>
        		<tr>
            		<td class="saludo1">.: Caja de Compensacion:</td>
        			<td><input id="cajas" name="cajas" type="text" value="<?php echo $_POST[cajas]?>" onKeyUp="return tabular(event,this)" style="width:25%" onBlur="busquedas('4')"/>&nbsp;<a href="#" onClick="despliegamodal2('visible','4');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>&nbsp;<input id="ncajas" name="ncajas" type="text" value="<?php echo $_POST[ncajas]?>" onKeyUp="return tabular(event,this)" style="width:65%" readonly></td>
        			<td class="saludo1">.: ESAP:</td>
        			<td><input id="esap" name="esap" type="text" value="<?php echo $_POST[esap]?>" onKeyUp="return tabular(event,this)" style="width:25%" onBlur="busquedas('5')">&nbsp;<a href="#" onClick="despliegamodal2('visible','5');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>&nbsp;<input id="nesap" name="nesap" type="text" value="<?php echo $_POST[nesap]?>" onKeyUp="return tabular(event,this)" style="width:65%" readonly></td>
           		</tr>        
				<tr>
				<td class="saludo1">.: ARL:</td>
        			<td><input id="arp" name="arp" type="text" value="<?php echo $_POST[arp]?>" onKeyUp="return tabular(event,this)" style="width:25%" onBlur="busquedas('6')">&nbsp;<a href="#" onClick="despliegamodal2('visible','6');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>&nbsp;<input id="narp" name="narp" type="text" value="<?php echo $_POST[narp]?>" onKeyUp="return tabular(event,this)" style="width:65%" readonly></td>
                	
             	</tr>        
    		</table>
            <input type="hidden" name="banbus" id="banbus" value=""/>
    		<input type="hidden" name="oculto" id="oculto" value="1">
  			<?php
				if($_POST[banbus]!='')
				{
					switch ($_POST[banbus]) 
					{ 
						case '1':	
							$nresul=buscatercero($_POST[icbf]);
							if($nresul!='')
							{echo"<script>document.getElementById('nicbf').value='$nresul';document.getElementById('sena').focus();</script>";}
							else
							{echo"<script>document.getElementById('valfocus').value='1';despliegamodalm('visible','2','Documento Incorrecto');</script>";}break;
						case '2':	
							$nresul=buscatercero($_POST[sena]);
							if($nresul!='')
							{echo"<script>document.getElementById('nsena').value='$nresul';document.getElementById('iti').focus();</script>";}
							else
							{echo"<script>document.getElementById('valfocus').value='2';despliegamodalm('visible','2','Documento Incorrecto');</script>";}break;
						case '3':	
							$nresul=buscatercero($_POST[iti]);
							if($nresul!='')
							{echo"<script>document.getElementById('niti').value='$nresul';document.getElementById('cajas').focus();</script>";}
							else
							{echo"<script>document.getElementById('valfocus').value='3';despliegamodalm('visible','2','Documento Incorrecto');</script>";}break;
						case '4':	
							$nresul=buscatercero($_POST[cajas]);
							if($nresul!='')
							{echo"<script>document.getElementById('ncajas').value='$nresul';document.getElementById('esap').focus();</script>";}
							else
							{echo"<script>document.getElementById('valfocus').value='4';despliegamodalm('visible','2','Documento Incorrecto');</script>";}break;
						case '5':	
							$nresul=buscatercero($_POST[esap]);
							if($nresul!='')
							{echo"<script>document.getElementById('nesap').value='$nresul';document.getElementById('indiceinca').focus();</script>";}
							else
							{echo"<script>document.getElementById('valfocus').value='5';despliegamodalm('visible','2','Documento Incorrecto');</script>";}break;
						case '6':	
							$nresul=buscatercero($_POST[arp]);
							if($nresul!='')
							{echo"<script>document.getElementById('narp').value='$nresul';document.getElementById('narp').focus();</script>";}
							else
							{echo"<script>document.getElementById('valfocus').value='6';despliegamodalm('visible','2','Documento Incorrecto');</script>";}break;
					}
				}
				if($_POST[oculto]=="2")
				{
					if($_POST[indiceinca]==""){$_POST[indiceinca]=0;}
					$sqlr="select count(vigencia) from admfiscales where vigencia='$_POST[vigencia]' ";
					$resp = mysql_query($sqlr,$linkbd);
					$row =mysql_fetch_row($resp);
					if ($row[0]==0 && $row[0]!="")
					{
						$sqlr="insert into admfiscales (vigencia,uvt,salario,transporte,alimentacion,bfsol,balimentacion,btransporte,estado,icbf, sena,iti,cajas,esap,indiceinca) values ('$_POST[vigencia]',$_POST[uvt],$_POST[salario],$_POST[transporte],$_POST[alimentacion],$_POST[bfsol], $_POST[balimentacion],$_POST[btransporte],'S','$_POST[icbf]','$_POST[sena]','$_POST[iti]','$_POST[cajas]','$_POST[esap]','$_POST[arp]') ";
						if (!mysql_query($sqlr,$linkbd))
						{echo "<script>despliegamodalm('visible','2','Manejador de Errores de la Clase BD admfiscales');</script>";}
						else {echo"<script>despliegamodalm('visible','3','Se ha Agregado La informacion a la Vigencia $_POST[vigencia]');</script>";}
					}
					else {echo "<script>despliegamodalm('visible','2','Ya Existe datos para esta Vigencia');</script>";}
				}
			?>
		</form>
        <div id="bgventanamodal2">
      		<div id="ventanamodal2">
        		<IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
           		</IFRAME>
         	</div>
    	</div>
	</body>
</html>