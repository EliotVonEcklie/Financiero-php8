<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
  	require"funciones.inc";
  	session_start();	
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	header("Content-Type: text/html;charset=iso-8859-1");
	date_default_timezone_set("America/Bogota");
	$scroll=$_GET['scrtop'];
	$totreg=$_GET['totreg'];
	$idcta=$_GET['idcta'];
	$altura=$_GET['altura'];
	$filtro="'".$_GET['filtro']."'";
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
			function adelante(scrtop, numpag, limreg, filtro, totreg, next)
			{
				if(parseFloat(document.form2.id.value)<parseFloat(document.form2.maximo.value))
				{
					document.getElementById('oculto').value='';
					document.getElementById('id').value=next;
					var idcta=document.getElementById('id').value;
					totreg++;
					document.form2.action="hum-editatablasfiscales.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&totreg="+totreg+"&filtro="+filtro;
					document.form2.submit();
				}
			}
			function atrasc(scrtop, numpag, limreg, filtro, totreg, prev)
			{
				if(document.form2.id.value>1)
				{
					document.getElementById('oculto').value='';
					document.getElementById('id').value=prev;
					var idcta=document.getElementById('id').value;
					totreg--;
					document.form2.action="hum-editatablasfiscales.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&totreg="+totreg+"&filtro="+filtro;
					document.form2.submit();
 				}
			}
			function iratras(scrtop, numpag, limreg, filtro)
			{
				var idcta=document.getElementById('id').value;
				location.href="hum-buscatablasfiscales.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
			}
			function cambiocheck(id)
			{
				switch(id)
				{
					case "1":	if(document.getElementById('idswauxali').value=='S'){document.getElementById('idswauxali').value='N';}
								else{document.getElementById('idswauxali').value='S';}
								break;
					case "2":	if(document.getElementById('idswauxtra').value=='S'){document.getElementById('idswauxtra').value='N';}
								else{document.getElementById('idswauxtra').value='S';}
								break;
				}
				document.form2.submit();
			}
		</script>
		 <style>
			/*boton1*/
			.swauxali
			{position: relative; width: 71px;-webkit-user-select:none;-moz-user-select:none;-ms-user-select: none;}
			.swauxali-checkbox {display: none;}
			.swauxali-label 
			{display: block;overflow: hidden;cursor: pointer;border: 2px solid #DDE6E2;border-radius: 20px;}
			.swauxali-inner 
			{display: block;width: 200%;margin-left: -100%;transition: margin 0.3s ease-in 0s;}
			.swauxali-inner:before, .swauxali-inner:after 
			{display: block;float: left;width: 50%;height: 23px;padding: 0;line-height: 23px;font-size: 14px;color: white;font-family: Trebuchet, Arial, sans-serif;font-weight: bold;box-sizing: border-box;}
			.swauxali-inner:before 
			{content: "SI";padding-left: 10px;background-color: #51C3E0;color: #FFFFFF;}
			.swauxali-inner:after 
			{content: "NO";padding-right: 10px;background-color: #EEEEEE; color: #999999;text-align: right;}
			.swauxali-switch 
			{display: block;width: 17px;margin: 3px;background: #FFFFFF;position: absolute;top: 0;bottom: 0;right: 44px;border: 2px solid #DDE6E2;border-radius: 20px;transition: all 0.3s ease-in 0s;}
			.swauxali-checkbox:checked + .swauxali-label .swauxali-inner {margin-left: 0;}
			.swauxali-checkbox:checked + .swauxali-label .swauxali-switch {right: 0px;}
			/*boton2*/
			.swauxtra
			{position: relative; width: 71px;-webkit-user-select:none;-moz-user-select:none;-ms-user-select: none;}
			.swauxtra-checkbox {display: none;}
			.swauxtra-label 
			{display: block;overflow: hidden;cursor: pointer;border: 2px solid #DDE6E2;border-radius: 20px;}
			.swauxtra-inner 
			{display: block;width: 200%;margin-left: -100%;transition: margin 0.3s ease-in 0s;}
			.swauxtra-inner:before, .swauxtra-inner:after 
			{display: block;float: left;width: 50%;height: 23px;padding: 0;line-height: 23px;font-size: 14px;color: white;font-family: Trebuchet, Arial, sans-serif;font-weight: bold;box-sizing: border-box;}
			.swauxtra-inner:before 
			{content: "SI";padding-left: 10px;background-color: #51C3E0;color: #FFFFFF;}
			.swauxtra-inner:after 
			{content: "NO";padding-right: 10px;background-color: #EEEEEE; color: #999999;text-align: right;}
			.swauxtra-switch 
			{display: block;width: 17px;margin: 3px;background: #FFFFFF;position: absolute;top: 0;bottom: 0;right: 44px;border: 2px solid #DDE6E2;border-radius: 20px;transition: all 0.3s ease-in 0s;}
			.swauxtra-checkbox:checked + .swauxtra-label .swauxtra-inner {margin-left: 0;}
			.swauxtra-checkbox:checked + .swauxtra-label .swauxtra-switch {right: 0px;}
		</style>
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
    		<tr><script>barra_imagenes("hum");</script><?php cuadro_titulos();?></tr>	 
    		<tr><?php menu_desplegable("hum");?></tr>
			<tr>
  				<td colspan="3" class="cinta"><a href="hum-tablasfiscales.php" onClick="adm-tablasfiscales.php" class="mgbt"><img src="imagenes/add.png"  title="Nuevo" /></a><a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar"/></a><a href="hum-buscatablasfiscales.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a></a><a href="#" onClick="mypop=window.open('hum-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="nueva ventana"></a><a onClick="iratras(<?php echo "$scrtop, $numpag,$limreg,$filtro"; ?>)" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a></td>
       		</tr>		
		</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
        <form name="form2" method="post" >
        	<input type="hidden" name="valfocus" id="valfocus" value="0"/>
			<?php
			if ($_GET[idvig]!=""){echo "<script>document.getElementById('codrec').value=$_GET[idvig];</script>";}
			if($_POST[oculto]=="")
			{
				if ($_POST[codrec]!="" || $_GET[idvig]!="")
				{
					if($_POST[codrec]!=""){$sqlr="SELECT * FROM admfiscales WHERE id=$_POST[codrec] ";}
					else{$sqlr="SELECT * FROM admfiscales WHERE id=$_GET[idvig] ";}
				}
				else{$sqlr="SELECT * FROM  admfiscales ORDER BY id DESC";}
				$cont=0;
				$resp = mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($resp))
				{
					$_POST[id]=$row[0];
					$_POST[vigencia]=$row[1];
					$_POST[uvt]=$row[2];
					$_POST[salario]=$row[3];
					$_POST[transporte]=$row[4];
					$_POST[alimentacion]=$row[5];	
					$_POST[bfsol]=$row[6];
					$_POST[btransporte]=$row[8];
					$_POST[balimentacion]=$row[7];	
					$_POST[estado]=$row[9];	
					$_POST[icbf]=$row[10];	
					$_POST[nicbf]=buscatercero($row[10]);
					$_POST[sena]=$row[11];	
					$_POST[nsena]=buscatercero($row[11]);		
					$_POST[iti]=$row[12];	
					$_POST[niti]=buscatercero($row[12]);		
					$_POST[cajas]=$row[13];	
					$_POST[ncajas]=buscatercero($row[13]);		
					$_POST[esap]=$row[14];			
					$_POST[nesap]=buscatercero($row[14]);		
					$_POST[arp]=$row[15]; 
					$_POST[swauxali]=$row[16];
					$_POST[swauxtra]=$row[17];           		
				}	
				$sqlr="SELECT MAX(CONVERT(id, SIGNED INTEGER)) FROM admfiscales";
				$res=mysql_query($sqlr,$linkbd);
				$r=mysql_fetch_row($res);
				$_POST[maximo]=$r[0];
			}
			//NEXT
			$sqln="select *from admfiscales where id > '$_POST[id]' ORDER BY id ASC LIMIT 1";
			$resn=mysql_query($sqln,$linkbd);
			$row=mysql_fetch_row($resn);
			$next=$row[0];
			//PREV
			$sqlp="select *from admfiscales where id < '$_POST[id]' ORDER BY id DESC LIMIT 1";
			$resp=mysql_query($sqlp,$linkbd);
			$row=mysql_fetch_row($resp);
			$prev=$row[0];
			?>
    		<table class="inicio" style="width:99.6%">
      			<tr>
						<td class="titulos" colspan="4">:: Tablas Fiscales</td>
						<td class="cerrar" style="width:7%" onClick="location.href='hum-principal.php'">Cerrar</td>
      			</tr>
     			<tr>
        			<td class="saludo1" style="width:18%">:: 	Vigencia:</td>
        			<td style="width:30%">
	        	    	<a onClick="atrasc(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $totreg; ?>, <?php echo $prev; ?>)" style='cursor:pointer;'><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a> 
						<input type="text" name="vigencia" value="<?php echo $_POST[vigencia]?>" maxlength="4" onKeyPress="javascript:return solonumeros(event)" style="width:30%">
	    	            <a onClick="adelante(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $totreg; ?>, <?php echo $next; ?>)" style='cursor:pointer;'><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> 
						<input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo">
						<input type="hidden" name="codrec" id="codrec" value="<?php echo $_POST[codrec]?>" >
						<input type="hidden" value="<?php echo $_POST[id]?>" name="id" id="id">
					</td>
				</tr>
      			<tr>
        			<td class="saludo1">:: UVT:</td>
        			<td><input name="uvt" type="text" value="<?php echo $_POST[uvt]?>"  onKeyPress="javascript:return solonumeros(event)" style="width:30%"></td>
        			<td class="saludo1" style="width:16%">:: Salario Minimo:</td>
        			<td><input name="salario" type="text" value="<?php echo $_POST[salario]?>" onKeyPress="javascript:return solonumeros(event)" style="width:30%"></td>
        		</tr>
        		<tr>
                	<td class="saludo1">:: Subsidio Alimentación:</td>
        			<td><input name="alimentacion" type="text" value="<?php echo $_POST[alimentacion]?>" onKeyPress="javascript:return solonumeros(event)" style="width:30%"></td>
         			<td class="saludo1">:: Subsidio Transporte:</td>
        			<td><input name="transporte" type="text" value="<?php echo $_POST[transporte]?>" onKeyPress="javascript:return solonumeros(event)" style="width:30%"></td>
         			
       			</tr>    
          		<tr>
         			<td class="saludo1">:: Base Aux Alimentaciópn:</td>
        			<td><input name="balimentacion" type="text" value="<?php echo $_POST[balimentacion]?>"  onKeyPress="javascript:return solonumeros(event)" style="width:30%"></td>
                    <td class="saludo1">:: Base Aux Transporte:</td>
        			<td><input name="btransporte" type="text" value="<?php echo $_POST[btransporte]?>" onKeyPress="javascript:return solonumeros(event)" style="width:30%"></td>
       			</tr>   
                <tr>
					<td class="saludo1" style="width:3cm;">Vincular Aux Alimentación con Nomina:</td>
					<td >
						<div class="swauxali">
							<input type="checkbox" name="swauxali" class="swauxali-checkbox" id="idswauxali" value="<?php echo $_POST[swauxali];?>" <?php if($_POST[swauxali]=='S'){echo "checked";}?> onChange="cambiocheck('1');"/>
							<label class="swauxali-label" for="idswauxali">
								<span class="swauxali-inner"></span>
								<span class="swauxali-switch"></span>
							</label>
						</div>
					</td>
                    <td class="saludo1" style="width:3cm;">Vincular Aux Transporte con Nomina:</td>
					<td >
						<div class="swauxtra">
							<input type="checkbox" name="swauxtra" class="swauxtra-checkbox" id="idswauxtra" value="<?php echo $_POST[swauxtra];?>" <?php if($_POST[swauxtra]=='S'){echo "checked";}?> onChange="cambiocheck('2');"/>
							<label class="swauxtra-label" for="idswauxtra">
								<span class="swauxtra-inner"></span>
								<span class="swauxtra-switch"></span>
							</label>
						</div>
					</td>
				</tr>            
          		<tr>
                    <td class="saludo1">:: Base F Solidaridad:</td>
        			<td><input name="bfsol" type="text" value="<?php echo $_POST[bfsol]?>"  onKeyPress="javascript:return solonumeros(event)" style="width:30%"></td>
             	</tr>
			</table>
            <table class="inicio" style="width:99.6%">
                <tr><td class="titulos" colspan="5">:: Empresas Prestadoras de Servicios</td></tr>
				<tr>
                	<td class="saludo1">.: Caja de Compensacion:</td>
        			<td><input id="cajas" name="cajas" type="text" value="<?php echo $_POST[cajas]?>" onKeyUp="return tabular(event,this)" style="width:25%" onBlur="busquedas('4')"/>&nbsp;<a href="#" onClick="despliegamodal2('visible','4');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>&nbsp;<input id="ncajas" name="ncajas" type="text" value="<?php echo $_POST[ncajas]?>" onKeyUp="return tabular(event,this)" style="width:65%" readonly></td>
                	
        			
                    <td class="saludo1">.: ICBF:</td>
        			<td><input id="icbf" name="icbf" type="text" value="<?php echo $_POST[icbf]?>" onKeyUp="return tabular(event,this)" style="width:25%" onBlur="busquedas('1')"/>&nbsp;<a href="#" onClick="despliegamodal2('visible','1');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>&nbsp;<input id="nicbf" name="nicbf" type="text" value="<?php echo $_POST[nicbf]?>" onKeyUp="return tabular(event,this)" style="width:65%" readonly> </td>
            	</tr>
        		<tr>
            		<td class="saludo1">.: SENA:</td>
        			<td><input id="sena" name="sena" type="text" value="<?php echo $_POST[sena]?>"  onKeyUp="return tabular(event,this)" style="width:25%" onBlur="busquedas('2')">&nbsp;<a href="#" onClick="despliegamodal2('visible','2');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>&nbsp;<input id="nsena" name="nsena" type="text" value="<?php echo $_POST[nsena]?>"  onKeyUp="return tabular(event,this)" style="width:65%" readonly> </td>
        			<td class="saludo1">.: ESAP:</td>
        			<td><input id="esap" name="esap" type="text" value="<?php echo $_POST[esap]?>" onKeyUp="return tabular(event,this)" style="width:25%" onBlur="busquedas('5')">&nbsp;<a href="#" onClick="despliegamodal2('visible','5');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>&nbsp;<input id="nesap" name="nesap" type="text" value="<?php echo $_POST[nesap]?>" onKeyUp="return tabular(event,this)" style="width:65%" readonly></td>
           		</tr>        
				<tr>
                <td class="saludo1">.: Institutos Tecnicos:</td>
        			<td><input id="iti" name="iti" type="text" value="<?php echo $_POST[iti]?>" onKeyUp="return tabular(event,this)" style="width:25%" onBlur="busquedas('3')">&nbsp;<a href="#" onClick="despliegamodal2('visible','3');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>&nbsp;<input id="niti" name="niti" type="text" value="<?php echo $_POST[niti]?>" onKeyUp="return tabular(event,this)" style="width:65%" readonly> </td>
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
							{echo"<script>document.getElementById('nicbf').value='$nresul';</script>";}
							else
							{echo"<script>document.getElementById('valfocus').value='1';despliegamodalm('visible','2','Documento Incorrecto');</script>";}break;
						case '2':	
							$nresul=buscatercero($_POST[sena]);
							if($nresul!='')
							{echo"<script>document.getElementById('nsena').value='$nresul';</script>";}
							else
							{echo"<script>document.getElementById('valfocus').value='2';despliegamodalm('visible','2','Documento Incorrecto');</script>";}break;
						case '3':	
							$nresul=buscatercero($_POST[iti]);
							if($nresul!='')
							{echo"<script>document.getElementById('niti').value='$nresul';</script>";}
							else
							{echo"<script>document.getElementById('valfocus').value='3';despliegamodalm('visible','2','Documento Incorrecto');</script>";}break;
						case '4':	
							$nresul=buscatercero($_POST[cajas]);
							if($nresul!='')
							{echo"<script>document.getElementById('ncajas').value='$nresul';</script>";}
							else
							{echo"<script>document.getElementById('valfocus').value='4';despliegamodalm('visible','2','Documento Incorrecto');</script>";}break;
						case '5':	
							$nresul=buscatercero($_POST[esap]);
							if($nresul!='')
							{echo"<script>document.getElementById('nesap').value='$nresul';</script>";}
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
					if($_POST[swauxali]=="" || $_POST[swauxali]=="N"){$valswauxali='N';}
					else{$valswauxali='S';}
					if($_POST[swauxtra]=="" || $_POST[swauxtra]=="N"){$valswauxtra='N';}
					else{$valswauxtra='S';}
 					$sqlr="UPDATE admfiscales SET uvt='$_POST[uvt]', salario='$_POST[salario]', transporte='$_POST[transporte]', alimentacion='$_POST[alimentacion]', bfsol='$_POST[bfsol]', balimentacion='$_POST[balimentacion]', btransporte='$_POST[btransporte]', icbf='$_POST[icbf]', sena='$_POST[sena]', iti='$_POST[iti]', cajas='$_POST[cajas]', esap='$_POST[esap]', indiceinca='$_POST[arp]', anauxalim='$valswauxali', anauxtrans='$valswauxtra'  WHERE vigencia='$_POST[vigencia]' ";
  					if (!mysql_query($sqlr,$linkbd))
					{echo "<script>despliegamodalm('visible','2','Manejador de Errores de la Clase BD admfiscales');</script>";}
  					else {echo"<script>despliegamodalm('visible','3','Se ha Actualizado La informacion a la Vigencia $_POST[vigencia]');</script>";}
					$_POST[oculto]="1";
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