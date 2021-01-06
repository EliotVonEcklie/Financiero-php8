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
		<title>:: SPID - Gestion Humana</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
		<style>
		 	/*boton1a*/
			.swslse
			{position: relative; width: 71px;-webkit-user-select:none;-moz-user-select:none;-ms-user-select: none;}
			.swslse-checkbox {display: none;}
			.swslse-label 
			{display: block;overflow: hidden;cursor: pointer;border: 2px solid #DDE6E2;border-radius: 20px;}
			.swslse-inner 
			{display: block;width: 200%;margin-left: -100%;transition: margin 0.3s ease-in 0s;}
			.swslse-inner:before, .swslse-inner:after 
			{display: block;float: left;width: 50%;height: 23px;padding: 0;line-height: 23px;font-size: 14px;color: white;font-family: Trebuchet, Arial, sans-serif;font-weight: bold;box-sizing: border-box;}
			.swslse-inner:before 
			{content: "SI";padding-left: 10px;background-color: #51C3E0;color: #FFFFFF;}
			.swslse-inner:after 
			{content: "NO";padding-right: 10px;background-color: #EEEEEE; color: #999999;text-align: right;}
			.swslse-switch 
			{display: block;width: 17px;margin: 3px;background: #FFFFFF;position: absolute;top: 0;bottom: 0;right: 44px;border: 2px solid #DDE6E2;border-radius: 20px;transition: all 0.3s ease-in 0s;}
			.swslse-checkbox:checked + .swslse-label .swslse-inner {margin-left: 0;}
			.swslse-checkbox:checked + .swslse-label .swslse-switch {right: 0px;}
			/*boton1b*/
			.swslsr
			{position: relative; width: 71px;-webkit-user-select:none;-moz-user-select:none;-ms-user-select: none;}
			.swslsr-checkbox {display: none;}
			.swslsr-label 
			{display: block;overflow: hidden;cursor: pointer;border: 2px solid #DDE6E2;border-radius: 20px;}
			.swslsr-inner 
			{display: block;width: 200%;margin-left: -100%;transition: margin 0.3s ease-in 0s;}
			.swslsr-inner:before, .swslsr-inner:after 
			{display: block;float: left;width: 50%;height: 23px;padding: 0;line-height: 23px;font-size: 14px;color: white;font-family: Trebuchet, Arial, sans-serif;font-weight: bold;box-sizing: border-box;}
			.swslsr-inner:before 
			{content: "SI";padding-left: 10px;background-color: #51C3E0;color: #FFFFFF;}
			.swslsr-inner:after 
			{content: "NO";padding-right: 10px;background-color: #EEEEEE; color: #999999;text-align: right;}
			.swslsr-switch 
			{display: block;width: 17px;margin: 3px;background: #FFFFFF;position: absolute;top: 0;bottom: 0;right: 44px;border: 2px solid #DDE6E2;border-radius: 20px;transition: all 0.3s ease-in 0s;}
			.swslsr-checkbox:checked + .swslsr-label .swslsr-inner {margin-left: 0;}
			.swslsr-checkbox:checked + .swslsr-label .swslsr-switch {right: 0px;}
			/*boton1c*/
			.swslpe
			{position: relative; width: 71px;-webkit-user-select:none;-moz-user-select:none;-ms-user-select: none;}
			.swslpe-checkbox {display: none;}
			.swslpe-label 
			{display: block;overflow: hidden;cursor: pointer;border: 2px solid #DDE6E2;border-radius: 20px;}
			.swslpe-inner 
			{display: block;width: 200%;margin-left: -100%;transition: margin 0.3s ease-in 0s;}
			.swslpe-inner:before, .swslpe-inner:after 
			{display: block;float: left;width: 50%;height: 23px;padding: 0;line-height: 23px;font-size: 14px;color: white;font-family: Trebuchet, Arial, sans-serif;font-weight: bold;box-sizing: border-box;}
			.swslpe-inner:before 
			{content: "SI";padding-left: 10px;background-color: #51C3E0;color: #FFFFFF;}
			.swslpe-inner:after 
			{content: "NO";padding-right: 10px;background-color: #EEEEEE; color: #999999;text-align: right;}
			.swslpe-switch 
			{display: block;width: 17px;margin: 3px;background: #FFFFFF;position: absolute;top: 0;bottom: 0;right: 44px;border: 2px solid #DDE6E2;border-radius: 20px;transition: all 0.3s ease-in 0s;}
			.swslpe-checkbox:checked + .swslpe-label .swslpe-inner {margin-left: 0;}
			.swslpe-checkbox:checked + .swslpe-label .swslpe-switch {right: 0px;}
			/*boton1d*/
			.swslpr
			{position: relative; width: 71px;-webkit-user-select:none;-moz-user-select:none;-ms-user-select: none;}
			.swslpr-checkbox {display: none;}
			.swslpr-label 
			{display: block;overflow: hidden;cursor: pointer;border: 2px solid #DDE6E2;border-radius: 20px;}
			.swslpr-inner 
			{display: block;width: 200%;margin-left: -100%;transition: margin 0.3s ease-in 0s;}
			.swslpr-inner:before, .swslpr-inner:after 
			{display: block;float: left;width: 50%;height: 23px;padding: 0;line-height: 23px;font-size: 14px;color: white;font-family: Trebuchet, Arial, sans-serif;font-weight: bold;box-sizing: border-box;}
			.swslpr-inner:before 
			{content: "SI";padding-left: 10px;background-color: #51C3E0;color: #FFFFFF;}
			.swslpr-inner:after 
			{content: "NO";padding-right: 10px;background-color: #EEEEEE; color: #999999;text-align: right;}
			.swslpr-switch 
			{display: block;width: 17px;margin: 3px;background: #FFFFFF;position: absolute;top: 0;bottom: 0;right: 44px;border: 2px solid #DDE6E2;border-radius: 20px;transition: all 0.3s ease-in 0s;}
			.swslpr-checkbox:checked + .swslpr-label .swslpr-inner {margin-left: 0;}
			.swslpr-checkbox:checked + .swslpr-label .swslpr-switch {right: 0px;}
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
			/*boton3a*/
			.swccf
			{position: relative; width: 71px;-webkit-user-select:none;-moz-user-select:none;-ms-user-select: none;}
			.swccf-checkbox {display: none;}
			.swccf-label 
			{display: block;overflow: hidden;cursor: pointer;border: 2px solid #DDE6E2;border-radius: 20px;}
			.swccf-inner 
			{display: block;width: 200%;margin-left: -100%;transition: margin 0.3s ease-in 0s;}
			.swccf-inner:before, .swccf-inner:after 
			{display: block;float: left;width: 50%;height: 23px;padding: 0;line-height: 23px;font-size: 14px;color: white;font-family: Trebuchet, Arial, sans-serif;font-weight: bold;box-sizing: border-box;}
			.swccf-inner:before 
			{content: "SI";padding-left: 10px;background-color: #51C3E0;color: #FFFFFF;}
			.swccf-inner:after 
			{content: "NO";padding-right: 10px;background-color: #EEEEEE; color: #999999;text-align: right;}
			.swccf-switch 
			{display: block;width: 17px;margin: 3px;background: #FFFFFF;position: absolute;top: 0;bottom: 0;right: 44px;border: 2px solid #DDE6E2;border-radius: 20px;transition: all 0.3s ease-in 0s;}
			.swccf-checkbox:checked + .swccf-label .swccf-inner {margin-left: 0;}
			.swccf-checkbox:checked + .swccf-label .swccf-switch {right: 0px;}
			/*boton3b*/
			.swicbf
			{position: relative; width: 71px;-webkit-user-select:none;-moz-user-select:none;-ms-user-select: none;}
			.swicbf-checkbox {display: none;}
			.swicbf-label 
			{display: block;overflow: hidden;cursor: pointer;border: 2px solid #DDE6E2;border-radius: 20px;}
			.swicbf-inner 
			{display: block;width: 200%;margin-left: -100%;transition: margin 0.3s ease-in 0s;}
			.swicbf-inner:before, .swicbf-inner:after 
			{display: block;float: left;width: 50%;height: 23px;padding: 0;line-height: 23px;font-size: 14px;color: white;font-family: Trebuchet, Arial, sans-serif;font-weight: bold;box-sizing: border-box;}
			.swicbf-inner:before 
			{content: "SI";padding-left: 10px;background-color: #51C3E0;color: #FFFFFF;}
			.swicbf-inner:after 
			{content: "NO";padding-right: 10px;background-color: #EEEEEE; color: #999999;text-align: right;}
			.swicbf-switch 
			{display: block;width: 17px;margin: 3px;background: #FFFFFF;position: absolute;top: 0;bottom: 0;right: 44px;border: 2px solid #DDE6E2;border-radius: 20px;transition: all 0.3s ease-in 0s;}
			.swicbf-checkbox:checked + .swicbf-label .swicbf-inner {margin-left: 0;}
			.swicbf-checkbox:checked + .swicbf-label .swicbf-switch {right: 0px;}
			/*boton3c*/
			.swsena
			{position: relative; width: 71px;-webkit-user-select:none;-moz-user-select:none;-ms-user-select: none;}
			.swsena-checkbox {display: none;}
			.swsena-label 
			{display: block;overflow: hidden;cursor: pointer;border: 2px solid #DDE6E2;border-radius: 20px;}
			.swsena-inner 
			{display: block;width: 200%;margin-left: -100%;transition: margin 0.3s ease-in 0s;}
			.swsena-inner:before, .swsena-inner:after 
			{display: block;float: left;width: 50%;height: 23px;padding: 0;line-height: 23px;font-size: 14px;color: white;font-family: Trebuchet, Arial, sans-serif;font-weight: bold;box-sizing: border-box;}
			.swsena-inner:before 
			{content: "SI";padding-left: 10px;background-color: #51C3E0;color: #FFFFFF;}
			.swsena-inner:after 
			{content: "NO";padding-right: 10px;background-color: #EEEEEE; color: #999999;text-align: right;}
			.swsena-switch 
			{display: block;width: 17px;margin: 3px;background: #FFFFFF;position: absolute;top: 0;bottom: 0;right: 44px;border: 2px solid #DDE6E2;border-radius: 20px;transition: all 0.3s ease-in 0s;}
			.swsena-checkbox:checked + .swsena-label .swsena-inner {margin-left: 0;}
			.swsena-checkbox:checked + .swsena-label .swsena-switch {right: 0px;}
			/*boton3d*/
			.swintec
			{position: relative; width: 71px;-webkit-user-select:none;-moz-user-select:none;-ms-user-select: none;}
			.swintec-checkbox {display: none;}
			.swintec-label 
			{display: block;overflow: hidden;cursor: pointer;border: 2px solid #DDE6E2;border-radius: 20px;}
			.swintec-inner 
			{display: block;width: 200%;margin-left: -100%;transition: margin 0.3s ease-in 0s;}
			.swintec-inner:before, .swintec-inner:after 
			{display: block;float: left;width: 50%;height: 23px;padding: 0;line-height: 23px;font-size: 14px;color: white;font-family: Trebuchet, Arial, sans-serif;font-weight: bold;box-sizing: border-box;}
			.swintec-inner:before 
			{content: "SI";padding-left: 10px;background-color: #51C3E0;color: #FFFFFF;}
			.swintec-inner:after 
			{content: "NO";padding-right: 10px;background-color: #EEEEEE; color: #999999;text-align: right;}
			.swintec-switch 
			{display: block;width: 17px;margin: 3px;background: #FFFFFF;position: absolute;top: 0;bottom: 0;right: 44px;border: 2px solid #DDE6E2;border-radius: 20px;transition: all 0.3s ease-in 0s;}
			.swintec-checkbox:checked + .swintec-label .swintec-inner {margin-left: 0;}
			.swintec-checkbox:checked + .swintec-label .swintec-switch {right: 0px;}
			/*boton3e*/
			.swesap
			{position: relative; width: 71px;-webkit-user-select:none;-moz-user-select:none;-ms-user-select: none;}
			.swesap-checkbox {display: none;}
			.swesap-label 
			{display: block;overflow: hidden;cursor: pointer;border: 2px solid #DDE6E2;border-radius: 20px;}
			.swesap-inner 
			{display: block;width: 200%;margin-left: -100%;transition: margin 0.3s ease-in 0s;}
			.swesap-inner:before, .swesap-inner:after 
			{display: block;float: left;width: 50%;height: 23px;padding: 0;line-height: 23px;font-size: 14px;color: white;font-family: Trebuchet, Arial, sans-serif;font-weight: bold;box-sizing: border-box;}
			.swesap-inner:before 
			{content: "SI";padding-left: 10px;background-color: #51C3E0;color: #FFFFFF;}
			.swesap-inner:after 
			{content: "NO";padding-right: 10px;background-color: #EEEEEE; color: #999999;text-align: right;}
			.swesap-switch 
			{display: block;width: 17px;margin: 3px;background: #FFFFFF;position: absolute;top: 0;bottom: 0;right: 44px;border: 2px solid #DDE6E2;border-radius: 20px;transition: all 0.3s ease-in 0s;}
			.swesap-checkbox:checked + .swesap-label .swesap-inner {margin-left: 0;}
			.swesap-checkbox:checked + .swesap-label .swesap-switch {right: 0px;}
		</style>
		<script>
			function guardar()
			{
				
				if (document.getElementById('codigo').value !='')
 				{despliegamodalm('visible','4','Esta Seguro de Guardar','1')}
 				else{despliegamodalm('visible','2','Faltan datos para completar el registro');}
 			}
			function buscater(e)
 			{
				if (document.form2.tercero.value!="")
				{
 					document.form2.bt.value='1';
 					document.form2.submit();
				}
			}
			function despliegamodal2(_valor,_num)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else 
				{
					switch(_num)
					{
						case '1':	document.getElementById('ventana2').src="cargafuncionarios-ventana03.php?objeto=tercero&vcodfun=codfun";break;
						case '2':	if(document.form2.variablepago.value!="-1")
									{
										if (document.form2.periodo.value!="-1")
										{document.getElementById('ventana2').src="cargafuncionarios-ventana01.php?objeto=lfuncionarios";break;}
										else
										{
											document.getElementById("bgventanamodal2").style.visibility="hidden";
											document.getElementById('ventana2').src="";
											despliegamodalm('visible','2','Faltan seleccionar el Mes');
											break;
										}
									}
									else
									{
										document.getElementById("bgventanamodal2").style.visibility="hidden";
										document.getElementById('ventana2').src="";
										despliegamodalm('visible','2','Faltan seleccionar un tipo de Pago');
										break;
									}
					}
				}
			}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden")
				{
					document.getElementById('ventanam').src="";
					if (document.getElementById('valfocus').value =="1")
					{
						document.getElementById('valfocus').value='0';
						document.getElementById('ntercero').value='';
						document.getElementById('tercero').focus();
						document.getElementById('tercero').select();
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
			function funcionmensaje(){}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.getElementById('oculto').value="2";
								document.form2.submit();break;
					case "2":	document.form2.oculto.value="3";
								document.form2.submit();break;
				}
			}
			function cambiocheck(id)
			{
				switch(id)
				{
					case '1':
						if(document.getElementById('idswslse').value=='S'){document.getElementById('idswslse').value='N';}
						else{document.getElementById('idswslse').value='S';}
						break;
					case '2':
						if(document.getElementById('idswslsr').value=='S'){document.getElementById('idswslsr').value='N';}
						else{document.getElementById('idswslsr').value='S';}
						break;
					case '3':
						if(document.getElementById('idswslpe').value=='S'){document.getElementById('idswslpe').value='N';}
						else{document.getElementById('idswslpe').value='S';}
						break;
					case '4':
						if(document.getElementById('idswslpr').value=='S'){document.getElementById('idswslpr').value='N';}
						else{document.getElementById('idswslpr').value='S';}
						break;
					case '5':
						if(document.getElementById('idswarl').value=='S'){document.getElementById('idswarl').value='N';}
						else{document.getElementById('idswarl').value='S';}
						break;
					case '6':
						if(document.getElementById('idswccf').value=='S'){document.getElementById('idswccf').value='N';}
						else{document.getElementById('idswccf').value='S';}
						break;
					case '7':
						if(document.getElementById('idswicbf').value=='S'){document.getElementById('idswicbf').value='N';}
						else{document.getElementById('idswicbf').value='S';}
						break;
					case '8':
						if(document.getElementById('idswsena').value=='S'){document.getElementById('idswsena').value='N';}
						else{document.getElementById('idswsena').value='S';}
						break;
					case '9':
						if(document.getElementById('idswintec').value=='S'){document.getElementById('idswintec').value='N';}
						else{document.getElementById('idswintec').value='S';}
						break;
					case '10':
						if(document.getElementById('idswesap').value=='S'){document.getElementById('idswesap').value='N';}
						else{document.getElementById('idswesap').value='S';}
						break;
				}
				document.form2.submit();
			}
			function cambiotippago()
			{
				document.form2.cambios.value="2";
				document.form2.submit();
			}
			function fagregar()
			{
				if(document.form2.variablepago.value!="-1")
				{
					if (document.form2.periodo.value!="-1")
					{
						if (document.form2.ntercero.value!="")
						{
							document.form2.oculto.value="4";
							document.form2.submit();
						}
						else {despliegamodalm('visible','2','Faltan seleccionar un funcionario');}
					}
					else {despliegamodalm('visible','2','Faltan seleccionar el Mes');}
				}
				else {despliegamodalm('visible','2','Faltan seleccionar un tipo de Pago');}
			}
			function eliminar(variable)
			{
				document.getElementById('elimina').value=variable;
				despliegamodalm('visible','4','Esta Seguro de Eliminar','2');
			}
			function fmodificar(pos)
			{
				document.form2.codfun.value=document.getElementsByName('vidfun[]').item(pos).value;
				document.form2.tercero.value=document.getElementsByName('vdocum[]').item(pos).value;
				document.form2.ntercero.value=document.getElementsByName('vnombre[]').item(pos).value;
				document.form2.salbasico.value=document.getElementsByName('vvbasico[]').item(pos).value;
				document.form2.diasn.value=document.getElementsByName('vdias[]').item(pos).value;
				document.form2.valdias.value=document.getElementsByName('vvdias[]').item(pos).value;
				document.form2.descripcion.value=document.getElementsByName('vdescrip[]').item(pos).value;
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
  				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='hum-novedadespagoscrear.php'" class="mgbt"/><img src="imagenes/guarda.png" title="Guardar" onClick="guardar();" class="mgbt"/><img src="imagenes/busca.png" title="Buscar" onClick="location.href='hum-novedadespagosbuscar.php'" class="mgbt"/><img src="imagenes/nv.png" title="nueva ventana" onClick="mypop=window.open('hum-principal.php','','');mypop.focus();" class="mgbt"/><img src='imagenes/iratras.png' title='Men&uacute; Nomina' class='mgbt' onClick="location.href='hum-menunomina.php'"/></td>
			</tr>		  
		</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
        <form name="form2" method="post" action="">
        	<input type="hidden" name="valfocus" id="valfocus" value="0"/>
			
			<?php
				if($_POST[oculto]=="")
				{
					$fec=date("d/m/Y");
					$_POST[fecha]=$fec; 	
					$_POST[vigencia]=date("Y");
					$_POST[lfuncionarios]="";
					$sqlr="SELECT * FROM hum_novedadespagos WHERE codigo='$_GET[codig]'";
					$resp = mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($resp))
					{
						$_POST[vcodid][]=$row[0];
						$_POST[vcftp][]="$row[5]:$row[7]";
						$_POST[vidfun][]=$row[7];
						$_POST[vfecha][]=date('d-m-Y',strtotime($row[2]));
						$_POST[vvigencia][]=$row[4];
						$_POST[vmes][]=$row[3];
						$_POST[vdescrip][]=$row[6];
						$_POST[vdocum][]=$row[8];
						$_POST[vnombre][]=$row[9];
						$_POST[vtipopago][]=$row[5];
						$_POST[vvbasico][]=$row[10];
						$_POST[vdias][]=$row[11];
						$_POST[vvdias][]=$row[12];
						$_POST[vpse][]=$row[13];
						$_POST[vpsr][]=$row[14];
						$_POST[vppe][]=$row[15];
						$_POST[vppr][]=$row[16];
						$_POST[vparl][]=$row[17];
						$_POST[vpccf][]=$row[18];
						$_POST[vpicbf][]=$row[19];
						$_POST[vpsena][]=$row[20];
						$_POST[vpitec][]=$row[21];
						$_POST[vpesap][]=$row[22];
						$_POST[vestado][]=$row[24];
						$_POST[codigo]=$row[1];
						$_POST[periodo]=$row[3];
					}
				}
				if($_POST[lfuncionarios]!='')
				{
					$listacod=str_replace(":","",$_POST[lfuncionarios]);
					$codfun = explode('<->', $listacod);
					for ($x=0;$x<count($codfun);$x++)
					{
						$idfunenter="$_POST[variablepago]:$codfun[$x]";
						$valarray=in_array($idfunenter,$_POST[vcftp]);
						if($valarray == false)
						{
							$indice = array_search($idfunenter,$_POST[vcftp],false);
							$sqlr="SELECT codfun, GROUP_CONCAT(descripcion ORDER BY CONVERT(valor, SIGNED INTEGER) SEPARATOR '<->')
							FROM hum_funcionarios
							WHERE (item = 'VALESCALA' OR item = 'DOCTERCERO' OR item = 'NOMTERCERO' OR item = '') AND codfun='$codfun[$x]' AND estado='S'
							GROUP BY codfun";
							$resp2 = mysql_query($sqlr,$linkbd);
							$row2 =mysql_fetch_row($resp2);
							$datos = explode('<->', $row2[1]);
							switch($_POST[variablepago])
							{
								case '01':	$valbasico=$datos[0];
											$valdias='30';
											$valdiasval=$datos[0];
											break;
								case '07':	$sqlr6="SELECT alimentacion,balimentacion FROM admfiscales WHERE vigencia='$_POST[vigencia]'";
											$resp6 = mysql_query($sqlr6,$linkbd);
											$row6 =mysql_fetch_row($resp6);
											if($datos[0]<=$row6[1])
											{
												$valbasico=$row6[0];
												$valdias='30';
												$valdiasval=$row6[0];
											}
											else {$valbasico=$valdias=$valdiasval=0;}
											break;
								default:	$valbasico=$valdias=$valdiasval=0;
							}
							$_POST[vcodid][]='';
							$_POST[vcftp][]="$_POST[variablepago]:$codfun[$x]";
							$_POST[vidfun][]=$codfun[$x];
							$_POST[vfecha][]=$_POST[fecha];
							$_POST[vvigencia][]=$_POST[vigencia];
							$_POST[vmes][]=$_POST[periodo];
							$_POST[vdescrip][]=$_POST[descripcion];
							$_POST[vdocum][]=$datos[1];
							$_POST[vnombre][]=$datos[2];
							$_POST[vtipopago][]=$_POST[variablepago];
							$_POST[vvbasico][]=$valbasico;
							$_POST[vdias][]=$valdias;
							$_POST[vvdias][]=$valdiasval;
							if($_POST[swslse]==''){$_POST[vpse][]='N';}
							else {$_POST[vpse][]=$_POST[swslse];}
							if($_POST[swslsr]==''){$_POST[vpsr][]='N';}
							else {$_POST[vpsr][]=$_POST[swslsr];}
							if($_POST[swslpe]==''){$_POST[vppe][]='N';}
							else{$_POST[vppe][]=$_POST[swslpe];}
							if($_POST[swslpr]==''){$_POST[vppr][]='N';}
							else {$_POST[vppr][]=$_POST[swslpr];}
							if($_POST[swarl]==''){$_POST[vparl][]='N';}
							else{$_POST[vparl][]=$_POST[swarl];}
							if($_POST[swccf]==''){$_POST[vpccf][]='N';}
							else{$_POST[vpccf][]=$_POST[swccf];}
							if($_POST[swicbf]==''){$_POST[vpicbf][]='N';}
							else{$_POST[vpicbf][]=$_POST[swicbf];}
							if($_POST[swsena]==''){$_POST[vpsena][]='N';}
							else{$_POST[vpsena][]=$_POST[swsena];}
							if($_POST[swintec]==''){$_POST[vpitec][]='N';}
							else{$_POST[vpitec][]=$_POST[swintec];}
							if($_POST[swesap]==''){$_POST[vpesap][]='N';}
							else{$_POST[vpesap][]=$_POST[swesap];}
							$_POST[vestado][]='S';
						}
					}
					$_POST[lfuncionarios]='';
				}
			 	if($_POST[bt]=='1')//***** busca tercero
			 	{
			  		$nresul=buscatercero($_POST[tercero]);
			  		if($nresul!=''){$_POST[ntercero]=$nresul;}
			 		else { $_POST[ntercero]="";}
				}
				if($_POST[cambios]==2)
				{
					$sqlr="SELECT pparafiscal,psalud,ppension,parl FROM humvariables WHERE codigo='$_POST[variablepago]'";
					$resp = mysql_query($sqlr,$linkbd);
					$row =mysql_fetch_row($resp);
					$_POST[swslse]=$row[1];
					$_POST[swslsr]=$row[1];
					$_POST[swslpe]=$row[2];
					$_POST[swslpr]=$row[2];
					$_POST[swarl]=$row[3];
					$_POST[swccf]=$row[0];
					$_POST[swicbf]=$row[0];
					$_POST[swsena]=$row[0];
					$_POST[swintec]=$row[0];
					$_POST[swesap]=$row[0];
				}
				if($_POST[ntercero]!="" && $_POST[variablepago]!='-1')
				{
					switch($_POST[variablepago])
					{
						case '01':	$sqlr="SELECT codfun, GROUP_CONCAT(descripcion ORDER BY CONVERT(valor, SIGNED INTEGER) SEPARATOR '<->')
									FROM hum_funcionarios
									WHERE (item = 'VALESCALA') AND codfun='$_POST[codfun]' AND estado='S'
									GROUP BY codfun";
									$resp2 = mysql_query($sqlr,$linkbd);
									$row2 =mysql_fetch_row($resp2);
									$_POST[salbasico]=$row2[1];
									$vlectura="readonly";
									break;
						case '07':	$sqlr="SELECT codfun, GROUP_CONCAT(descripcion ORDER BY CONVERT(valor, SIGNED INTEGER) SEPARATOR '<->')
									FROM hum_funcionarios
									WHERE (item = 'VALESCALA') AND codfun='$_POST[codfun]' AND estado='S'
									GROUP BY codfun";
									$resp2 = mysql_query($sqlr,$linkbd);
									$row2 =mysql_fetch_row($resp2);
									$salbasico=$row2[1];
									$sqlr="SELECT alimentacion,balimentacion FROM admfiscales WHERE vigencia='$_POST[vigencia]'";
									$resp = mysql_query($sqlr,$linkbd);
									$row =mysql_fetch_row($resp);
									if($salbasico<=$row[1]){$_POST[salbasico]=$row[0];}
									else{$_POST[salbasico]=0;}
									$vlectura="readonly";
									break;
						case '08':	$sqlr="SELECT codfun, GROUP_CONCAT(descripcion ORDER BY CONVERT(valor, SIGNED INTEGER) SEPARATOR '<->')
									FROM hum_funcionarios
									WHERE (item = 'VALESCALA') AND codfun='$_POST[codfun]' AND estado='S'
									GROUP BY codfun";
									$resp2 = mysql_query($sqlr,$linkbd);
									$row2 =mysql_fetch_row($resp2);
									$salbasico=$row2[1];
									$sqlr="SELECT transporte,btransporte FROM admfiscales WHERE vigencia='$_POST[vigencia]'";
									$resp = mysql_query($sqlr,$linkbd);
									$row =mysql_fetch_row($resp);
									if($salbasico<=$row[1]){$_POST[salbasico]=$row[0];}
									else{$_POST[salbasico]=0;}
									$vlectura="readonly";
									break;
						default:	$_POST[salbasico]=0;
					}
				}
				else {$_POST[salbasico]=0;}
				if($_POST[diasn]!='' && $_POST[diasn]!=0 && $_POST[salbasico]!=0)
				{
					$_POST[valdias]=round (($_POST[salbasico]/30)*$_POST[diasn],0,PHP_ROUND_HALF_DOWN);
				}
				else if($_POST[variablepago]=='01' || $_POST[variablepago]=='07' || $_POST[variablepago]=='08'){$_POST[valdias]=0;}
			 ?>
			<input type="hidden" name="lfuncionarios" id="lfuncionarios" value="<?php echo $_POST[lfuncionarios];?>"/>
    		<table class="inicio" align="center" >
      			<tr>
        			<td class="titulos" colspan="11">.: Agregar Novedad de Pagos Funcionario</td>
                    <td class="cerrar" style="width:7%" onClick="location.href='hum-principal.php'">Cerrar</td>
      			</tr>
      			<tr>
	  				<td class="saludo1" style="width:2.2cm;">C&oacute;digo:</td>
        			<td style="width:5%;"><input type="text" name="codigo" id="codigo" value="<?php echo $_POST[codigo]?>" style="width:90%;"  readonly></td>
        			<td class="saludo1" style="width:2.2cm;">Fecha:</td>
                    <td style="width:14%;"><input type="text" name="fecha" id="fc_1198971545" title="DD/MM/YYYY" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this)" onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" style="width:75%;">&nbsp;<img src="imagenes/calendario04.png"  onClick="displayCalendarFor('fc_1198971545');" title="Calendario" class="icoop"></td>
					<td class="saludo1" style="width:2.2m;">Vigencia:</td> 
                    <td style="width:10%;"><input name="vigencia" type="text" value="<?php echo $_POST[vigencia]?>" style="width:80%;" readonly></td>
                    <td class="saludo1" style="width:2.2cm;">Mes:</td>
          			<td>
                    	<select name="periodo" id="periodo" >
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
					<td class="saludo1" >Tipo de Pago:</td>
					<td >
						<select name="variablepago" id="variablepago" style="width:100%;" onChange="cambiotippago();">
							<option value="-1">Seleccione ....</option>
							<?php
								$sqlr="SELECT codigo,nombre FROM humvariables WHERE estado='S'";
								$resp = mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($resp)) 
								{
									if(in_array($row[0], $vtiponum)){$vartip="S";}
									else{$vartip="N";}
									if($row[0]==$_POST[variablepago])
									{
										if($vartip=="N"){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
									}
									else 
									{
										if($vartip=="N"){echo "<option value='$row[0]' >$row[0] - $row[1]</option>";}
									}
								}
							?>
						</select>
					</td>
				</tr>
				<tr>
        			<td class="saludo1">Descripci&oacute;n:</td>
        			<td colspan="8"><input type="text" name="descripcion" id="descripcion" value="<?php echo $_POST[descripcion];?>" onKeyUp="return tabular(event,this)" style="width:100%;"></td>
					<td style="padding-bottom:5px"><em class="botonflecha" onClick="despliegamodal2('visible','2');">Lista Funcionarios</em></td>
       			</tr> 
      		</table>
	    	<table class="inicio">
	   			<tr><td colspan="10" class="titulos">Detalle Novedad de Pagos Funcionario</td></tr>                  
	  		  	<tr>
                	<td class="saludo1" style="width:2.5cm;">Empleado:</td>
          			<td style="width:15%"><input type="text" id="tercero" name="tercero" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo $_POST[tercero]?>" style="width:80%;"/>&nbsp;&nbsp<img class="icobut" src="imagenes/find02.png"  title="Listado Terceros" onClick="despliegamodal2('visible','1');"></td>
          			<td colspan="7"><input type="text" name="ntercero" id="ntercero"  value="<?php echo $_POST[ntercero]?>" style="width:100%;" readonly></td>
                    <td style="width:7%;"></td>
              	</tr>
          		<tr>	       
					<input type="hidden" name="codfun" id="codfun" value="<?php echo $_POST[codfun]?>"/>
		  			<td class="saludo1" style="width:9%;">Valor B&aacute;sico:</td>
                    <td><input type="text" name="salbasico" id="salbasico" value="<?php echo $_POST[salbasico]; ?>" style='text-align:right;' readonly/></td>
				
             		<td class="saludo1" style="width:9%;">D&iacute;as:</td>
                    <td ><input type="text" name="diasn" id="diasn" value="<?php echo $_POST[diasn]?>" onChange="document.form2.submit();"/></td>
          			<td class="saludo1" style="width:9%;">Valor D&iacute;as:</td>
                    <td><input type="text" name="valdias" id="valdias" value="<?php echo $_POST[valdias]?>" <?php echo $vlectura;?>/></td>
					<td style=" padding-bottom:5px"><em class="botonflecha" onClick="fagregar();">Agregar</em></td>
	  			</tr>
    		</table>
			<table class="inicio">
	   			<tr><td colspan="11" class="titulos">Detalle Seguridad Social y Parafiscales</td></tr>
				<tr>
					<td class="saludo1" style="width:3.5cm">Pagar Salud Empleado:</td>
					<td style="width:7%">
                    	<div class="swslse">
                            <input type="checkbox" name="swslse" class="swslse-checkbox" id="idswslse" value="<?php echo $_POST[swslse];?>" <?php if($_POST[swslse]=='S'){echo "checked";}?> onChange="cambiocheck('1');"/>
                            <label class="swslse-label" for="idswslse">
                                <span class="swslse-inner"></span>
                                <span class="swslse-switch"></span>
                            </label>
                        </div>
           			</td>
					<td class="saludo1" style="width:3.5cm">Pagar Salud Empresa:</td>
        			<td style="width:7%">
                    	<div class="swslsr">
                            <input type="checkbox" name="swslsr" class="swslsr-checkbox" id="idswslsr" value="<?php echo $_POST[swslsr];?>" <?php if($_POST[swslsr]=='S'){echo "checked";}?> onChange="cambiocheck('2');"/>
                            <label class="swslsr-label" for="idswslsr">
                                <span class="swslsr-inner"></span>
                                <span class="swslsr-switch"></span>
                            </label>
                        </div>
           			</td>
					<td class="saludo1" style="width:4cm">Pagar Pension Empleado:</td>
        			<td style="width:7%">
                    	<div class="swslpe">
                            <input type="checkbox" name="swslpe" class="swslpe-checkbox" id="idswslpe" value="<?php echo $_POST[swslpe];?>" <?php if($_POST[swslpe]=='S'){echo "checked";}?> onChange="cambiocheck('3');"/>
                            <label class="swslpe-label" for="idswslpe">
                                <span class="swslpe-inner"></span>
                                <span class="swslpe-switch"></span>
                            </label>
                        </div>
           			</td>
					<td class="saludo1" style="width:4cm">Pagar Pension Empresa:</td>
        			<td style="width:7%">
                    	<div class="swslpr">
                            <input type="checkbox" name="swslpr" class="swslpr-checkbox" id="idswslpr" value="<?php echo $_POST[swslpr];?>" <?php if($_POST[swslpr]=='S'){echo "checked";}?> onChange="cambiocheck('4');"/>
                            <label class="swslpr-label" for="idswslpr">
                                <span class="swslpr-inner"></span>
                                <span class="swslpr-switch"></span>
                            </label>
                        </div>
           			</td>
                	<td class="saludo1" style="width:3.5cm">Pagar ARL:</td>
        			<td style="width:7%">
                    	<div class="swarl">
                            <input type="checkbox" name="swarl" class="swarl-checkbox" id="idswarl" value="<?php echo $_POST[swarl];?>" <?php if($_POST[swarl]=='S'){echo "checked";}?> onChange="cambiocheck('5');"/>
                            <label class="swarl-label" for="idswarl">
                                <span class="swarl-inner"></span>
                                <span class="swarl-switch"></span>
                            </label>
                        </div>
           			</td>
					<td></td>
				</tr>
				<tr>
                    <td class="saludo1" title="Caja de Compensacion Familiar">Pagar CCF:</td>
        			<td style="width:7%">
                    	<div class="swccf">
                            <input type="checkbox" name="swccf" class="swccf-checkbox" id="idswccf" value="<?php echo $_POST[swccf];?>" <?php if($_POST[swccf]=='S'){echo "checked";}?> onChange="cambiocheck('6');"/>
                            <label class="swccf-label" for="idswccf">
                                <span class="swccf-inner"></span>
                                <span class="swccf-switch"></span>
                            </label>
                        </div>
           			</td>
					<td class="saludo1" title="Instituto Colombiano de Bienestar Familiar">Pagar ICBF:</td>
        			<td style="width:7%">
                    	<div class="swicbf">
                            <input type="checkbox" name="swicbf" class="swicbf-checkbox" id="idswicbf" value="<?php echo $_POST[swicbf];?>" <?php if($_POST[swicbf]=='S'){echo "checked";}?> onChange="cambiocheck('7');"/>
                            <label class="swicbf-label" for="idswicbf">
                                <span class="swicbf-inner"></span>
                                <span class="swicbf-switch"></span>
                            </label>
                        </div>
           			</td>
					<td class="saludo1" title="Servicio Nacional de Aprendizaje">Pagar SENA:</td>
        			<td style="width:7%">
                    	<div class="swsena">
                            <input type="checkbox" name="swsena" class="swsena-checkbox" id="idswsena" value="<?php echo $_POST[swsena];?>" <?php if($_POST[swsena]=='S'){echo "checked";}?> onChange="cambiocheck('8');"/>
                            <label class="swsena-label" for="idswsena">
                                <span class="swsena-inner"></span>
                                <span class="swsena-switch"></span>
                            </label>
                        </div>
           			</td>
					<td class="saludo1" title="Institutos Tecnicos">Pagar Ins. Tecnicos:</td>
        			<td style="width:7%">
                    	<div class="swintec">
                            <input type="checkbox" name="swintec" class="swintec-checkbox" id="idswintec" value="<?php echo $_POST[swintec];?>" <?php if($_POST[swintec]=='S'){echo "checked";}?> onChange="cambiocheck('9');"/>
                            <label class="swintec-label" for="idswintec">
                                <span class="swintec-inner"></span>
                                <span class="swintec-switch"></span>
                            </label>
                        </div>
           			</td>
					<td class="saludo1" title="Escuela Superior de Administracion Publica">Pagar ESAP:</td>
        			<td style="width:7%">
                    	<div class="swesap">
                            <input type="checkbox" name="swesap" class="swesap-checkbox" id="idswesap" value="<?php echo $_POST[swesap];?>" <?php if($_POST[swesap]=='S'){echo "checked";}?> onChange="cambiocheck('10');"/>
                            <label class="swesap-label" for="idswesap">
                                <span class="swesap-inner"></span>
                                <span class="swesap-switch"></span>
                            </label>
                        </div>
           			</td>
                </tr>
			</table>
			<div class="subpantalla" style="height:35%; width:99.6%; overflow-x:hidden;">
				<table class="inicio" width="99%">
					<tr><td class="titulos" colspan="18">funcionarios Agregados</td></tr>
					<tr>
                    	<td class="titulos2" style="width:4%">No</td>
                        <td class="titulos2" style="width:4%">Tipo</td>
                        <td class="titulos2" style="width:8%">Documento</td>
                        <td class="titulos2">Nombre</td>
                        <td class="titulos2">B&aacute;sico</td>
                        <td class="titulos2">D&iacute;as</td>
                        <td class="titulos2">Valor D&iacute;as</td>
                        <td class="titulos2" style="width:3%">SE</td>
						<td class="titulos2" style="width:3%">SR</td>
						<td class="titulos2" style="width:3%">PE</td>
						<td class="titulos2" style="width:3%">PR</td>
						<td class="titulos2" style="width:3%">ARL</td>
						<td class="titulos2" style="width:3%">CCF</td>
						<td class="titulos2" style="width:3%">ICBF</td>
						<td class="titulos2" style="width:3%">SENA</td>
						<td class="titulos2" style="width:3%">INTEC</td>
						<td class="titulos2" style="width:3%">ESAP</td>
                        <td class="titulos2" style="width:3%">Eliminar</td>
                	</tr>
					<?php
						if ($_POST[oculto]=='3')
						{
							$posi=$_POST[elimina];
							unset($_POST[vcodid][$posi]);
							unset($_POST[vcftp][$posi]);
							unset($_POST[vidfun][$posi]);
							unset($_POST[vfecha][$posi]);
							unset($_POST[vvigencia][$posi]);
							unset($_POST[vmes][$posi]);
							unset($_POST[vdescrip][$posi]);
							unset($_POST[vdocum][$posi]);
							unset($_POST[vnombre][$posi]);
							unset($_POST[vtipopago][$posi]);
							unset($_POST[vvbasico][$posi]);
							unset($_POST[vdias][$posi]);
							unset($_POST[vvdias][$posi]);
							unset($_POST[vpse][$posi]);
							unset($_POST[vpsr][$posi]);
							unset($_POST[vppe][$posi]);
							unset($_POST[vppr][$posi]);
							unset($_POST[vparl][$posi]);
							unset($_POST[vpccf][$posi]);
							unset($_POST[vpicbf][$posi]);
							unset($_POST[vpsena][$posi]);
							unset($_POST[vpitec][$posi]);
							unset($_POST[vpesap][$posi]);
							unset($_POST[vestado][$posi]);
							$_POST[vcodid]= array_values($_POST[vcodid]);
							$_POST[vcftp]= array_values($_POST[vcftp]);
							$_POST[vidfun]= array_values($_POST[vidfun]);
							$_POST[vfecha]= array_values($_POST[vfecha]);
							$_POST[vvigencia]= array_values($_POST[vvigencia]);
							$_POST[vmes]= array_values($_POST[vmes]);
							$_POST[vdescrip]= array_values($_POST[vdescrip]);
							$_POST[vdocum]= array_values($_POST[vdocum]);
							$_POST[vnombre]= array_values($_POST[vnombre]);
							$_POST[vtipopago]= array_values($_POST[vtipopago]);
							$_POST[vvbasico]= array_values($_POST[vvbasico]);
							$_POST[vdias]= array_values($_POST[vdias]);
							$_POST[vvdias]= array_values($_POST[vvdias]);
							$_POST[vpse]= array_values($_POST[vpse]);
							$_POST[vpsr]= array_values($_POST[vpsr]);
							$_POST[vppe]= array_values($_POST[vppe]);
							$_POST[vppr]= array_values($_POST[vppr]);
							$_POST[vparl]= array_values($_POST[vparl]);
							$_POST[vpccf]= array_values($_POST[vpccf]);
							$_POST[vpicbf]= array_values($_POST[vpicbf]);
							$_POST[vpsena]= array_values($_POST[vpsena]);
							$_POST[vpitec]= array_values($_POST[vpitec]);
							$_POST[vpesap]= array_values($_POST[vpesap]);
							$_POST[vestado]= array_values($_POST[vestado]);
							$_POST[elimina]='';
						}
						if ($_POST[oculto]=='4')
						{
							$idfunenter="$_POST[variablepago]:$_POST[codfun]";
							$valarray=in_array($idfunenter,$_POST[vcftp]);
							if($valarray == false)
							{
								$_POST[vcodid][]='';
								$_POST[vcftp][]="$_POST[variablepago]:$_POST[codfun]";
								$_POST[vidfun][]=$_POST[codfun];
								$_POST[vfecha][]=$_POST[fecha];
								$_POST[vvigencia][]=$_POST[vigencia];
								$_POST[vmes][]=$_POST[periodo];
								$_POST[vdescrip][]=$_POST[descripcion];
								$_POST[vdocum][]=$_POST[tercero];
								$_POST[vnombre][]=$_POST[ntercero];
								$_POST[vtipopago][]=$_POST[variablepago];
								$_POST[vvbasico][]=$_POST[salbasico];
								$_POST[vdias][]=$_POST[diasn];
								$_POST[vvdias][]=$_POST[valdias];
								if($_POST[swslse]==''){$_POST[vpse][]='N';}
								else {$_POST[vpse][]=$_POST[swslse];}
								if($_POST[swslsr]==''){$_POST[vpsr][]='N';}
								else {$_POST[vpsr][]=$_POST[swslsr];}
								if($_POST[swslpe]==''){$_POST[vppe][]='N';}
								else{$_POST[vppe][]=$_POST[swslpe];}
								if($_POST[swslpr]==''){$_POST[vppr][]='N';}
								else {$_POST[vppr][]=$_POST[swslpr];}
								if($_POST[swarl]==''){$_POST[vparl][]='N';}
								else{$_POST[vparl][]=$_POST[swarl];}
								if($_POST[swccf]==''){$_POST[vpccf][]='N';}
								else{$_POST[vpccf][]=$_POST[swccf];}
								if($_POST[swicbf]==''){$_POST[vpicbf][]='N';}
								else{$_POST[vpicbf][]=$_POST[swicbf];}
								if($_POST[swsena]==''){$_POST[vpsena][]='N';}
								else{$_POST[vpsena][]=$_POST[swsena];}
								if($_POST[swintec]==''){$_POST[vpitec][]='N';}
								else{$_POST[vpitec][]=$_POST[swintec];}
								if($_POST[swesap]==''){$_POST[vpesap][]='N';}
								else{$_POST[vpesap][]=$_POST[swesap];}
								$_POST[vestado][]='S';
							}
							else
							{
								$indice = array_search($idfunenter,$_POST[vcftp],false);
								$_POST[vcftp][$indice]="$_POST[variablepago]:$_POST[codfun]";
								$_POST[vidfun][$indice]=$_POST[codfun];
								$_POST[vfecha][$indice]=$_POST[fecha];
								$_POST[vvigencia][$indice]=$_POST[vigencia];
								$_POST[vmes][$indice]=$_POST[periodo];
								$_POST[vdescrip][$indice]=$_POST[descripcion];
								$_POST[vdocum][$indice]=$_POST[tercero];
								$_POST[vnombre][$indice]=$_POST[ntercero];
								$_POST[vtipopago][$indice]=$_POST[variablepago];
								$_POST[vvbasico][$indice]=$_POST[salbasico];
								$_POST[vdias][$indice]=$_POST[diasn];
								$_POST[vvdias][$indice]=$_POST[valdias];
								if($_POST[swslse]==''){$_POST[vpse][$indice]='N';}
								else {$_POST[vpse][$indice]=$_POST[swslse];}
								if($_POST[swslsr]==''){$_POST[vpsr][$indice]='N';}
								else {$_POST[vpsr][$indice]=$_POST[swslsr];}
								if($_POST[swslpe]==''){$_POST[vppe][$indice]='N';}
								else{$_POST[vppe][$indice]=$_POST[swslpe];}
								if($_POST[swslpr]==''){$_POST[vppr][$indice]='N';}
								else {$_POST[vppr][$indice]=$_POST[swslpr];}
								if($_POST[swarl]==''){$_POST[vparl][$indice]='N';}
								else{$_POST[vparl][$indice]=$_POST[swarl];}
								if($_POST[swccf]==''){$_POST[vpccf][$indice]='N';}
								else{$_POST[vpccf][$indice]=$_POST[swccf];}
								if($_POST[swicbf]==''){$_POST[vpicbf][$indice]='N';}
								else{$_POST[vpicbf][$indice]=$_POST[swicbf];}
								if($_POST[swsena]==''){$_POST[vpsena][$indice]='N';}
								else{$_POST[vpsena][$indice]=$_POST[swsena];}
								if($_POST[swintec]==''){$_POST[vpitec][$indice]='N';}
								else{$_POST[vpitec][$indice]=$_POST[swintec];}
								if($_POST[swesap]==''){$_POST[vpesap][$indice]='N';}
								else{$_POST[vpesap][$indice]=$_POST[swesap];}
								$_POST[vestado][$indice]='S';
							}
							$_POST[oculto]=1;
						}
						$co="saludo1a";
		  				$co2="saludo2";
						for ($x=0;$x<count($_POST[vidfun]);$x++)
						{
							echo"
							<input type='hidden' name='vcftp[]' value='".$_POST[vcftp][$x]."'/>
							<input type='hidden' name='vcodid[]' value='".$_POST[vcodid][$x]."'/>
							<input type='hidden' name='vidfun[]' value='".$_POST[vidfun][$x]."'/>
							<input type='hidden' name='vfecha[]' value='".$_POST[vfecha][$x]."'/>
							<input type='hidden' name='vvigencia[]' value='".$_POST[vvigencia][$x]."'/>
							<input type='hidden' name='vmes[]' value='".$_POST[vmes][$x]."'/>
							<input type='hidden' name='vdescrip[]' value='".$_POST[vdescrip][$x]."'/>
							<input type='hidden' name='vdocum[]' value='".$_POST[vdocum][$x]."'/>
							<input type='hidden' name='vnombre[]' value='".$_POST[vnombre][$x]."'/>
							<input type='hidden' name='vtipopago[]' value='".$_POST[vtipopago][$x]."'/>
							<input type='hidden' name='vvbasico[]' value='".$_POST[vvbasico][$x]."'/>
							<input type='hidden' name='vdias[]' value='".$_POST[vdias][$x]."'/>
							<input type='hidden' name='vvdias[]' value='".$_POST[vvdias][$x]."'/>
							<input type='hidden' name='vpse[]' value='".$_POST[vpse][$x]."'/>
							<input type='hidden' name='vpsr[]' value='".$_POST[vpsr][$x]."'/>
							<input type='hidden' name='vppe[]' value='".$_POST[vppe][$x]."'/>
							<input type='hidden' name='vppr[]' value='".$_POST[vppr][$x]."'/>
							<input type='hidden' name='vparl[]' value='".$_POST[vparl][$x]."'/>
							<input type='hidden' name='vpccf[]' value='".$_POST[vpccf][$x]."'/>
							<input type='hidden' name='vpicbf[]' value='".$_POST[vpicbf][$x]."'/>
							<input type='hidden' name='vpsena[]' value='".$_POST[vpsena][$x]."'/>
							<input type='hidden' name='vpitec[]' value='".$_POST[vpitec][$x]."'/>
							<input type='hidden' name='vpesap[]' value='".$_POST[vpesap][$x]."'/>
							<input type='hidden' name='vestado[]' value='".$_POST[vestado][$x]."'/>";
							if($_POST[vtipopago][$x]==$_POST[variablepago])
							{
								echo"
								<tr class='$co' ondblclick='fmodificar($x);'>
									<td style='text-align:right;'>".($x+1)."&nbsp;</td>
									<td style='text-align:right;'>".$_POST[vtipopago][$x]."&nbsp;</td>
									<td style='text-align:right;'>".$_POST[vdocum][$x]."&nbsp;</td>
									<td >".$_POST[vnombre][$x]."</td>
									<td style='text-align:right;'>$ ".number_format($_POST[vvbasico][$x],0)."&nbsp;</td>
									<td style='text-align:right;'>".$_POST[vdias][$x]."&nbsp;</td>
									<td style='text-align:right;'>$ ".number_format($_POST[vvdias][$x],0)."&nbsp;</td>
									<td >".$_POST[vpse][$x]."</td>
									<td >".$_POST[vpsr][$x]."</td>
									<td >".$_POST[vppe][$x]."</td>
									<td >".$_POST[vppr][$x]."</td>
									<td >".$_POST[vparl][$x]."</td>
									<td >".$_POST[vpccf][$x]."</td>
									<td >".$_POST[vpicbf][$x]."</td>
									<td >".$_POST[vpsena][$x]."</td>
									<td >".$_POST[vpitec][$x]."</td>
									<td >".$_POST[vpesap][$x]."</td>
									<td style='text-align:center;'><img src='imagenes/del.png' onclick='eliminar($x)' class='icoop'></td>
								</tr>";
								$aux=$co;
								$co=$co2;
								$co2=$aux;
							}
						}
					?>
					<input type='hidden' name='elimina' id='elimina'/>
				<table>
			</div>
   	 		<input type="hidden" name="oculto" id="oculto" value="1"/>
			<input type="hidden" name="cambios" id="cambios" value="1"/>
    		<input type="hidden" name="bt" id="bt" value="0" >
			<?php
				if($_POST[bt]=='1')//***** busca tercero
				{
					$nresul=buscatercero($_POST[tercero]);
			  		if($nresul!='')
			   		{echo"<script>document.getElementById('ntercero').value='$nresul';document.getElementById('retencion').focus();</script>";}
				 	else
					{echo"<script>document.getElementById('valfocus').value='1';despliegamodalm('visible','2','Documento Incorrecto');</script>";}
			 	}
				if($_POST[oculto]=='2')
				{
					for ($x=0;$x<count($_POST[vidfun]);$x++)
					{
						preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/", $_POST[vfecha][$x],$fecha);
						$fechaf="$fecha[3]-$fecha[2]-$fecha[1]";
						if($_POST[vcodid][$x]=='')
						{
							$conid=selconsecutivo('hum_novedadespagos','id');
							$sqlr="INSERT INTO hum_novedadespagos (id,codigo,fecha,mes,vigencia,tipo,descripcion,idfun,documento,nombrefun,valorb,dias,valord,pse,psr,ppe,ppr, parl,pccf,picbf,psena,pitec,pesap,codpre,estado) VALUES ('$conid','$_POST[codigo]','$fechaf','".$_POST[vmes][$x]."','".$_POST[vvigencia][$x]."','".$_POST[vtipopago][$x]."','".$_POST[vdescrip][$x]."','".$_POST[vidfun][$x]."','".$_POST[vdocum][$x]."','".$_POST[vnombre][$x]."','".$_POST[vvbasico][$x]."','".$_POST[vdias][$x]."','".$_POST[vvdias][$x]."','".$_POST[vpse][$x]."','".$_POST[vpsr][$x]."','".$_POST[vppe][$x]."','".$_POST[vppr][$x]."','".$_POST[vparl][$x]."','".$_POST[vpccf][$x]."','".$_POST[vpicbf][$x]."','".$_POST[vpsena][$x]."','".$_POST[vpitec][$x]."','".$_POST[vpesap][$x]."','0','S')";
						}
						else
						{
							$sqlr="UPDATE hum_novedadespagos SET fecha='$fechaf',descripcion='".$_POST[vdescrip][$x]."',valorb='".$_POST[vvbasico][$x]."',dias='".$_POST[vdias][$x]."',valord='".$_POST[vvdias][$x]."',pse='".$_POST[vpse][$x]."',psr='".$_POST[vpsr][$x]."',ppe='".$_POST[vppe][$x]."',ppr='".$_POST[vppr][$x]."',parl='".$_POST[vparl][$x]."',pccf='".$_POST[vpccf][$x]."',picbf='".$_POST[vpicbf][$x]."',psena='".$_POST[vpsena][$x]."',pitec='".$_POST[vpitec][$x]."',pesap='".$_POST[vpesap][$x]."' WHERE id='".$_POST[vcodid][$x]."'";
						}
						mysql_query($sqlr,$linkbd);
					}
  					echo "<script>despliegamodalm('visible','1','Se ha almacenado con Exito');</script>";
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