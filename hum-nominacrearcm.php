<?php //V 1000 12/12/16 ?> 
<!--V 1.0 24/02/2015-->
<?php
	require"comun.inc";
	require"funciones.inc";
	require"validaciones.inc";
	sesion();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
    	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Spid - Gestion Humana</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css"/>
        <link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css"/>
        <link href="css/tabs.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css"/>
        <script type="text/javascript" src="css/calendario.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
        <script type='text/javascript' src='JQuery/jquery-2.1.4.min.js'></script>
		<script>
			function excell()
			{
				document.form2.action="hum-liquidarnominaexcel.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function pdf()
			{
				document.form2.action="pdfpeticionrp.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventanam').src="";}
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
			function funcionmensaje(){
				//document.location.href = "hum-liquidarnominamirar.php?idnomi="+document.form2.idcomp.value;
			}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	
						document.form2.oculto.value=2;
						document.form2.submit();
					break;
				}
			}
			function detallesnomina(id, radicado)
			{
				if($('#detalle'+id).css('display')=='none')
				{
					$('#detalle'+id).css('display','block');
					$('#img'+id).attr('src','imagenes/minus.gif');
				}
				else
				{
					$('#detalle'+id).css('display','none');
					$('#img'+id).attr('src','imagenes/plus.gif');
				}
				var toLoad= 'hum-detallesliquidarnom.php';
				$.post(toLoad,{radicado:radicado},function (data){
					$('#detalle'+id).html(data.detalle);
					return false;
				},'json');
			}
			function guardar()
			{
				if (document.form2.idpreli.value!='-1')
  				{despliegamodalm('visible','4','Esta Seguro de Guardar','1')}
  				else{despliegamodalm('visible','2','Faltan datos para completar el registro');}
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
                <td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='hum-nominacrear.php'" class="mgbt"/><img src="imagenes/guarda.png" title="Guardar" onClick="guardar()" class="mgbt"/><img class="mgbt" src="imagenes/busca.png" title="Buscar" onClick="location.href='hum-liquidarnominabuscar.php'"/><img class="mgbt" src="imagenes/nv.png" title="Nueva Ventana" onClick="mypop=window.open('hum-principal.php','','');mypop.focus();"/><img src="imagenes/print.png" title="Imprimir" onClick="pdf()" class="mgbt"/><img src="imagenes/excel.png" title="Excel" onClick='excell()' class="mgbt"/><img src='imagenes/iratras.png' title='Men&uacute; Nomina' class='mgbt' onClick="location.href='hum-menunomina.php'"/></td>
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
				if($_POST[oculto]=="")
				{
					$_POST[vigencia]=vigencia_usuarios($_SESSION[cedulausu]);
					$_POST[idcomp]=selconsecutivo('humnomina','id_nom');
					$_POST[fecha]=date('d/m/Y');
					$_POST[tabgroup1]=1;
					//**** carga parametros de nomina
					$sqlr="SELECT * FROM humparametrosliquida";	
		 			$resp = mysql_query($sqlr,$linkbd);
					$row =mysql_fetch_row($resp);
					$_POST[aprueba]=$row[1];
					$_POST[naprueba]=buscatercero($row[1]);
					$_POST[tsueldo]=$row[2];
					$_POST[tsubalim]=$row[8];
					$_POST[tauxtrans]=$row[9];
					$_POST[trecnoct]=$row[11];
					$_POST[thorextdiu]=$row[12];
					$_POST[thorextnoct]=$row[13];
					$_POST[thororddom]=$row[14];
					$_POST[thorextdiudom]=$row[15];
					$_POST[thorextnoctdom]=$row[16];
					$_POST[tcajacomp]=$row[17];
					$_POST[ticbf]=$row[18];
					$_POST[tsena]=$row[19];
					$_POST[titi]=$row[20];
					$_POST[tesap]=$row[21];
					$_POST[tarp]=$row[22];
					$_POST[tsaludemr]=$row[23];
					$_POST[tsaludemp]=$row[24];
					$_POST[tpensionemr]=$row[25];
					$_POST[tpensionemp]=$row[26];
					//carga parametros admfiscales
					$sqlr="SELECT * FROM admfiscales WHERE vigencia='$_POST[vigencia]'";
					$resp = mysql_query($sqlr,$linkbd);
					$row =mysql_fetch_row($resp);
					$_POST[salmin]=$row[3];
					$_POST[transp]=$row[4];
					$_POST[alim]=$row[5];
					$_POST[bfsol]=$row[6];
					$_POST[balim]=$row[7];
					$_POST[btrans]=$row[8];
					$_POST[icbf]=$row[10];
					$_POST[sena]=$row[11];
					$_POST[iti]=$row[12];
					$_POST[cajacomp]=$row[13];
					$_POST[esap]=$row[14];
					$_POST[indiceinca]=$row[15];
					//carga parametros nomina redondeos
					$sqlr="SELECT * FROM hum_parametros_nom ";
					$resp = mysql_query($sqlr,$linkbd);
					$row =mysql_fetch_row($resp);
					$_POST[salrioaux]=$row[0];
					$_POST[redondeoibc]=$row[1];
					$_POST[redonpension]=$row[2];
					$_POST[redondeoibcarp]=$row[3];
					$_POST[redondeoibcpara]=$row[4];
					$_POST[tiporedondeoibc1]=$row[5];
					$_POST[tiporedondeoibc2]=$row[6];
					$_POST[tiporedondeoibcp1]=$row[7];
					$_POST[tiporedondeoibcp2]=$row[8];
					$_POST[tiporedondeoibca1]=$row[9];
					$_POST[tiporedondeoibca2]=$row[10];
					$_POST[tipoliquidacion]=$row[11];
					$_POST[nivelredondeo]=$row[12];
					$_POST[tipofondosol]=$row[13];
				}
				$pf[]=array();
		 		$pfcp=array();
				$listatipopension=array();
				$listaempleados=array();
				$listadocumentos=array();
				$listasalariobasico=array();	
				$listadevengados=array();
				$listaauxalimentacion=array();
				$listaauxtrasporte=array();
				$listaotrospagos=array();
				$listatotaldevengados=array();
				$listaibc=array();
				$listabaseparafiscales=array();
				$listabasearp=array();
				$listaarp=array();
				$listasaludempleado=array();
				$listasaludempresa=array();
				$listasaludtotal=array();
				$listapensionempleado=array();
				$listapensionempresa=array();
				$listapensiontotal=array();
				$listafondosolidaridad=array();
				$listaotrasdeducciones=array();
				$listatotaldeducciones=array();
				$listanetoapagar=array();
				$listaccf=array();
				$listasena=array();
				$listaicbf=array();
				$listainstecnicos=array();
				$listaesap=array();
				$listatotalparafiscales=array();
				$listadiasincapacidad=array();
				$listatipofondopension=array();
				$listadiasliquidados=array();
				$listaidprenomina=array();
				switch($_POST[tabgroup1])
				{
					case 1:	$check1='checked';break;
					case 2:	$check2='checked';break;
					case 3:	$check3='checked';break;
					case 4:	$check4='checked';break;
					case 5:	$check5='checked';break;
					case 6:	$check6='checked';break;
				}		 
			?>
			<table  class="inicio" align="center" >
                <tr>
                    <td class="titulos" colspan="8">:: Liquidar Nomina</td>
                    <td class="cerrar" style="width:7%" onClick="location.href='hum-principal.php'">Cerrar</td>
      			</tr>
      			<tr>
                	<td class="saludo1" style="width:3cm;">No Liquidaci&oacute;n:</td>
                    <td style="width:10%"><input type="text" name="idcomp" id="idcomp" value="<?php echo $_POST[idcomp]?>" style="width:98%" readonly/></td>
                   	<td class="saludo1" style="width:3cm;">Fecha:</td>
                    <td style="width:15%"><input type="text" name="fecha" value="<?php echo $_POST[fecha]?>" maxlength="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" style="width:80%;">&nbsp;<img src="imagenes/calendario04.png" onClick="displayCalendarFor('fc_1198971545');" title="Calendario" class="icobut"/></td>
                    <td class="saludo1" style="width:3cm;">Vigencia:</td> 
                    <td style="width:10%"><input type="text" name="vigencia" id="vigencia"  value="<?php echo $_POST[vigencia]?>" style="width:98%" readonly></td>
                    <td class="saludo1" style="width:3cm;">No Preliquidaci&oacute;n:</td> 
	    			<td>
                    	<select name="idpreli" id="idpreli" onChange="document.form2.submit();">
							<option value="-1">Sel ...</option>
                            <?php
                          		$sqlr="SELECT codigo, mes, vigencia FROM  hum_prenomina WHERE estado='S'";
                                $resp = mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($resp)) 
								{
									if($row[0]==$_POST[idpreli]) 
									{
										echo "<option value='$row[0]' SELECTED>$row[0] - ".mesletras($row[1])." $row[2]</option>";
									}
									else {echo "<option value='$row[0]'>$row[0] - ".mesletras($row[1])." $row[2]</option>";}
								}   
							?>
                        </select>
                   	</td>
       			</tr>                       
    		</table> 
            <!-- Variables parametros de nomina --> 
            <input type="hidden" id="aprueba" name="aprueba" value="<?php echo $_POST[aprueba];?>"/>
            <input type="hidden" id="naprueba" name="naprueba" value="<?php echo $_POST[naprueba];?>"/>
         	<input type="hidden" id="tsueldo" name="tsueldo" value="<?php echo $_POST[tsueldo];?>"/>
            <input type="hidden" id="tsubalim" name="tsubalim" value="<?php echo $_POST[tsubalim];?>"/>
            <input type="hidden" id="tauxtrans" name="tauxtrans" value="<?php echo $_POST[tauxtrans];?>"/>
            <input type="hidden" id="trecnoct" name="trecnoct" value="<?php echo $_POST[trecnoct];?>"/>
            <input type="hidden" id="thorextdiu" name="thorextdiu" value="<?php echo $_POST[thorextdiu];?>"/>
            <input type="hidden" id="thorextnoct" name="thorextnoct" value="<?php echo $_POST[thorextnoct];?>"/>
            <input type="hidden" id="thororddom" name="thororddom" value="<?php echo $_POST[thororddom];?>"/>
            <input type="hidden" id="thorextdiudom" name="thorextdiudom" value="<?php echo $_POST[thorextdiudom];?>"/>
            <input type="hidden" id="thorextnoctdom" name="thorextnoctdom" value="<?php echo $_POST[thorextnoctdom];?>"/>
            <input type="hidden" id="tcajacomp" name="tcajacomp" value="<?php echo $_POST[tcajacomp];?>"/>
            <input type="hidden" id="ticbf" name="ticbf" value="<?php echo $_POST[ticbf];?>"/>
            <input type="hidden" id="tsena" name="tsena" value="<?php echo $_POST[tsena];?>"/>
            <input type="hidden" id="titi" name="titi" value="<?php echo $_POST[titi];?>"/>
            <input type="hidden" id="tesap" name="tesap" value="<?php echo $_POST[tesap];?>"/>
            <input type="hidden" id="tarp" name="tarp" value="<?php echo $_POST[tarp];?>"/>
            <input type="hidden" id="tsaludemr" name="tsaludemr" value="<?php echo $_POST[tsaludemr];?>"/>
            <input type="hidden" id="tsaludemp" name="tsaludemp" value="<?php echo $_POST[tsaludemp];?>"/>
            <input type="hidden" id="tpensionemr" name="tpensionemr" value="<?php echo $_POST[tpensionemr];?>"/>
            <input type="hidden" id="tpensionemp" name="tpensionemp" value="<?php echo $_POST[tpensionemp];?>"/>
            <!-- Variables parametros admfiscales --> 
            <input type="hidden" id="cajacomp" name="cajacomp" value="<?php echo $_POST[cajacomp];?>"/>
            <input type="hidden" id="icbf" name="icbf" value="<?php echo $_POST[icbf];?>"/>
            <input type="hidden" id="sena" name="sena" value="<?php echo $_POST[sena];?>"/>
            <input type="hidden" id="esap" name="esap" value="<?php echo $_POST[esap];?>"/>
            <input type="hidden" id="iti" name="iti" value="<?php echo $_POST[iti];?>"/>
            <input type="hidden" id="indiceinca" name="indiceinca" value="<?php echo $_POST[indiceinca];?>"/>
            <input type="hidden" id="btrans" name="btrans" value="<?php echo $_POST[btrans];?>"/>
            <input type="hidden" id="balim" name="balim"  value="<?php echo $_POST[balim];?>"/>
            <input type="hidden" id="bfsol" name="bfsol" value="<?php echo $_POST[bfsol];?>"/>
            <input type="hidden" id="transp" name="transp"  value="<?php echo $_POST[transp];?>"/>
            <input type="hidden" id="alim" name="alim" value="<?php echo $_POST[alim];?>"/>
            <input type="hidden" id="salmin" name="salmin" value="<?php echo $_POST[salmin];?>"/> 
            <!-- Variables parametros nomina redondeos --> 
            <input type="hidden" id="salrioaux" name="salrioaux" value="<?php echo $_POST[salrioaux];?>"/>
            <input type="hidden" id="redondeoibc" name="redondeoibc" value="<?php echo $_POST[redondeoibc];?>"/>
            <input type="hidden" id="redonpension" name="redonpension" value="<?php echo $_POST[redonpension];?>"/>
            <input type="hidden" id="redondeoibcarp" name="redondeoibcarp" value="<?php echo $_POST[redondeoibcarp];?>"/>
            <input type="hidden" id="redondeoibcpara" name="redondeoibcpara" value="<?php echo $_POST[redondeoibcpara];?>"/>
            <input type="hidden" id="tiporedondeoibc1" name="tiporedondeoibc1" value="<?php echo $_POST[tiporedondeoibc1];?>"/>
            <input type="hidden" id="tiporedondeoibc2" name="tiporedondeoibc2" value="<?php echo $_POST[tiporedondeoibc2];?>"/>
            <input type="hidden" id="tiporedondeoibcp1" name="tiporedondeoibcp1" value="<?php echo $_POST[tiporedondeoibcp1];?>"/>
            <input type="hidden" id="tiporedondeoibcp2" name="tiporedondeoibcp2" value="<?php echo $_POST[tiporedondeoibcp2];?>"/>
            <input type="hidden" id="tiporedondeoibca1" name="tiporedondeoibca1" value="<?php echo $_POST[tiporedondeoibca1];?>"/>
            <input type="hidden" id="tiporedondeoibca2" name="tiporedondeoibca2" value="<?php echo $_POST[tiporedondeoibca2];?>"/>
            <input type="hidden" id="tipoliquidacion" name="tipoliquidacion" value="<?php echo $_POST[tipoliquidacion];?>"/>
            <input type="hidden" id="nivelredondeo" name="nivelredondeo" value="<?php echo $_POST[nivelredondeo];?>"/>
            <input type="hidden" id="tipofondosol" name="tipofondosol" value="<?php echo $_POST[tipofondosol];?>"/>
            <?php
				if($_POST[idpreli]!="-1")
				{
					$sqlr="SELECT * FROM hum_prenomina_det WHERE codigo='$_POST[idpreli]' ORDER BY id_det"; 
					$resp = mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($resp)) 
	 				{
						if($row[16]>0)
						{
							$sqlrin="SELECT SUM(dias_inca),SUM(valor_total),pagar_ibc,pagar_arl,pagar_para FROM hum_incapacidades_det WHERE mes='$row[2]' AND vigencia='$row[3]' AND doc_funcionario='$row[7]'";
							$respin = mysql_query($sqlrin,$linkbd);
							$rowin = mysql_fetch_row($respin);
							$saldevb = round($rowin[1],0);
							
							if($rowin[2]=='S'){$diasibcinca=$rowin[0];$saldevb1=round((($row[6]/30)*($rowin[0])),0);}
							else{$diasibcinca=$saldevb1=0;}
							if($rowin[3]=='S'){$diasibcarlinca=$rowin[0];$saldevb2=round((($row[6]/30)*($rowin[0])),0);}
							else{$diasibcarlinca=$saldevb2=0;}
							if($rowin[4]=='S'){$diasibcparainca=$rowin[0];$saldevb3=round((($row[6]/30)*($rowin[0])),0);}
							else{$diasibcparainca=$saldevb3=0;}
						}
						else{$saldevb=$diasibcinca=$diasibcparainca=$saldevb1=$saldevb2=$saldevb3=0;}
						if($row[17]>0)
						{ 
							$sqlrva="SELECT SUM(dias_vaca),SUM(valor_total),pagar_ibc,pagar_arl,pagar_para FROM hum_vacaciones_det WHERE mes='$row[2]' AND vigencia='$row[3]' AND doc_funcionario='$row[7]'";
							$respva = mysql_query($sqlrva,$linkbd);
							$rowva =mysql_fetch_row($respva);
							$saldevc = round($rowva[1],0);
							if($rowva[2]=='S'){$diasibcvaca=$rowva[0];$saldevc1=$saldevc;}
							else{$diasibcvaca=$saldevc1=0;}
							if($rowva[3]=='S'){$diasibcarlvaca=$rowva[0];$saldevc2=$saldevc;}
							else{$diasibcarlvaca=$saldevc2=0;}
							if($rowva[4]=='S'){$diasibcparavaca=$rowva[0];$saldevc3=$saldevc;}
							else{$diasibcparavaca=$saldevc3=0;}
						}
						else{$saldevc=$diasibcvaca=$diasibcparavaca=$diasibcarlvaca=$saldevc1=$saldevc2=$saldevc3=0;}
						$saldev=(($row[6]/30)*($row[15]))+$saldevb;
						$saldevibc=($row[6]/30)*($row[15]+$diasibcinca+$diasibcvaca);
						$saldevibcpara=($row[6]/30)*($row[15]+$diasibcparainca+$diasibcparavaca);
						$saldevibcarl=($row[6]/30)*($row[15]+$diasibcarlinca+$diasibcarlvaca);
						
						if($row[6]<=$_POST[balim]){$auxalim=round(($_POST[alim]/30)*$row[15],0);}
						else{$auxalim=0;}
						if($row[6]<=$_POST[btrans]){$auxtra=round(($_POST[transp]/30)*$row[15],0);} 
						else{$auxtra=0;}
						$valotrospagos=0;
						$totaldevengado=round ($saldev+$auxalim+$auxtra+$valotrospagos,0,PHP_ROUND_HALF_DOWN);
						//calculos IBC salario nomina
						if($_POST[salrioaux]==1)
						{
							if($_POST[tipoliquidacion]==0)
							{
								if($_POST[nivelredondeo]==0)
								{
									if($_POST[redondeoibc]==1){$ibcnomina=ceil(($saldevibc+$auxalim)/$_POST[tiporedondeoibc2])*$_POST[tiporedondeoibc2];}
									else {$ibcnomina=$saldevibc+$auxalim;}
									if($_POST[redondeoibcarp]==1){$ibcarp=ceil(($saldevibcarl+$auxalim)/$_POST[tiporedondeoibc2])*$_POST[tiporedondeoibc2];}
									else {$ibcarp=$saldevibcarl+$auxalim;}
									if($_POST[redondeoibcpara]==1){$ibcpara=ceil(($saldevibcpara+$auxalim)/$_POST[tiporedondeoibc2])*$_POST[tiporedondeoibc2];}
									else {$ibcpara=$saldevibcpara+$auxalim;}
								}
								else
								{
									if($_POST[redondeoibc]==1){$ibcnomina=round($saldevibc+$auxalim, -3);}
									else {$ibcnomina=$saldevibc+$auxalim;}
									if($_POST[redondeoibcarp]==1){$ibcarp=round($saldevibcarl+$auxalim, -3);}
									else {$ibcarp=$saldevibcarl+$auxalim;}
									if($_POST[redondeoibcpara]==1){$ibcpara=round($saldevibcpara+$auxalim, -3);}
									else {$ibcpara=$saldevibcpara+$auxalim;}
								}
							}
							else
							{
								if($_POST[nivelredondeo]==0)
								{
									//salarios
									if($_POST[redondeoibc]==1){$ibcnomina1=ceil(($saldev+$auxalim)/$_POST[tiporedondeoibc2])*$_POST[tiporedondeoibc2];}
									else {$ibcnomina1=$saldev+$auxalim;}
									if($_POST[redondeoibcarp]==1){$ibcarp1=ceil(($saldev+$auxalim)/$_POST[tiporedondeoibc2])*$_POST[tiporedondeoibc2];}
									else {$ibcarp1=$saldev+$auxalim;}
									if($_POST[redondeoibcpara]==1){$ibcpara1=ceil(($saldev+$auxalim)/$_POST[tiporedondeoibc2])*$_POST[tiporedondeoibc2];}
									else {$ibcpara1=$saldev+$auxalim;}
									//vacaciones
									if($_POST[redondeoibc]==1){$ibcnomina2=ceil($saldevc1/$_POST[tiporedondeoibc2])*$_POST[tiporedondeoibc2];}
									else {$ibcnomina2=$saldevc1;}
									if($_POST[redondeoibcarp]==1){$ibcarp2=ceil($saldevc2/$_POST[tiporedondeoibc2])*$_POST[tiporedondeoibc2];}
									else {$ibcarp2=$saldevc2;}
									if($_POST[redondeoibcpara]==1){$ibcpara2=ceil($saldevc3/$_POST[tiporedondeoibc2])*$_POST[tiporedondeoibc2];}
									else {$ibcpara2=$saldevc3;}
									//incapacidad
									if($_POST[redondeoibc]==1){$ibcnomina3=ceil($saldevb1/$_POST[tiporedondeoibc2])*$_POST[tiporedondeoibc2];}
									else {$ibcnomina3=$saldevb1;}
									if($_POST[redondeoibcarp]==1){$ibcarp3=ceil($saldevb2/$_POST[tiporedondeoibc2])*$_POST[tiporedondeoibc2];}
									else {$ibcarp3=$saldevb2;}
									if($_POST[redondeoibcpara]==1){$ibcpara3=ceil($saldevb3/$_POST[tiporedondeoibc2])*$_POST[tiporedondeoibc2];}
									else {$ibcpara3=$saldevb3;}
								}
								else
								{
									//salarios
									if($_POST[redondeoibc]==1){$ibcnomina1=round($saldev+$auxalim, -3);}
									else {$ibcnomina1=$saldev+$auxalim;}
									if($_POST[redondeoibcarp]==1){$ibcarp1=round($saldev+$auxalim, -3);}
									else {$ibcarp1=$saldev+$auxalim;}
									if($_POST[redondeoibcpara]==1){$ibcpara1=round($saldev+$auxalim, -3);}
									else {$ibcpara1=$saldev+$auxalim;}
									//vacaciones
									if($_POST[redondeoibc]==1){$ibcnomina2=round($saldevc1, -3);}
									else {$ibcnomina2=$saldevc1;}
									if($_POST[redondeoibcarp]==1){$ibcarp2=round($saldevc2, -3);}
									else {$ibcarp2=$saldevc2;}
									if($_POST[redondeoibcpara]==1){$ibcpara2=round($saldevc3, -3);}
									else {$ibcpara2=$saldevc3;}
									//incapacidad
									if($_POST[redondeoibc]==1){$ibcnomina3=round($saldevb1, -3);}
									else {$ibcnomina3=$saldevb1;}
									if($_POST[redondeoibcarp]==1){$ibcarp3=round($saldevb2, -3);}
									else {$ibcarp3=$saldevb2;}
									if($_POST[redondeoibcpara]==1){$ibcpara3=round($saldevb3, -3);}
									else {$ibcpara3=$saldevb3;}
								}
								//todos
								$ibcnomina=$ibcnomina1+$ibcnomina2;
								$ibcarp=$ibcarp1+$ibcarp2;
								$ibcpara=$ibcpara1+$ibcpara2;	
							}
							switch ($row[7]) 
							{
								case "40440297":	$ibcnomina=$ibcnomina+1000;
													$ibcarp=$ibcarp+1000;
													$ibcpara=$ibcpara+1000;break;
								case "40440799":	$ibcnomina=$ibcnomina-1000;
													$ibcarp=$ibcarp-1000;
													$ibcpara=$ibcpara-1000;break;
							}
						}
						else
						{
							if($_POST[tipoliquidacion]==0)
							{
								if($_POST[nivelredondeo]==0)
								{
									if($_POST[redondeoibc]==1){$ibcnomina=ceil($saldevibc/$_POST[tiporedondeoibc2])*$_POST[tiporedondeoibc2];}
									else {$ibcnomina=$saldevibc;}
									if($_POST[redondeoibcarp]==1){$ibcarp=ceil($saldevibcarl/$_POST[tiporedondeoibc2])*$_POST[tiporedondeoibc2];}
									else {$ibcarp=$saldev;}
									if($_POST[redondeoibcpara]==1){$ibcpara=ceil($saldevibcpara/$_POST[tiporedondeoibc2])*$_POST[tiporedondeoibc2];}
									else {$ibcpara=$saldevibcpara;}
								}
								else
								{
									if($_POST[redondeoibc]==1){$ibcnomina=round($saldevibc, -3);}
									else {$ibcnomina=$saldevibc;}
									if($_POST[redondeoibcarp]==1){$ibcarp=round($saldevibcarl, -3);}
									else {$ibcarp=$saldev;}
									if($_POST[redondeoibcpara]==1){$ibcpara=round($saldevibcpara, -3);}
									else {$ibcpara=$saldevibcpara;}
								}
							}
							else
							{
								if($_POST[nivelredondeo]==0)
								{
									//salarios
									if($_POST[redondeoibc]==1){$ibcnomina1=ceil($saldev/$_POST[tiporedondeoibc2])*$_POST[tiporedondeoibc2];}
									else {$ibcnomina1=$saldev;}
									if($_POST[redondeoibcarp]==1){$ibcarp1=ceil($saldev/$_POST[tiporedondeoibc2])*$_POST[tiporedondeoibc2];}
									else {$ibcarp1=$saldev;}
									if($_POST[redondeoibcpara]==1){$ibcpara1=ceil($saldev/$_POST[tiporedondeoibc2])*$_POST[tiporedondeoibc2];}
									else {$ibcpara1=$saldev;}
									//vacaciones
									if($_POST[redondeoibc]==1){$ibcnomina2=ceil($saldevc1/$_POST[tiporedondeoibc2])*$_POST[tiporedondeoibc2];}
									else {$ibcnomina2=$saldevc1;}
									if($_POST[redondeoibcarp]==1){$ibcarp2=ceil($saldevc2/$_POST[tiporedondeoibc2])*$_POST[tiporedondeoibc2];}
									else {$ibcarp2=$saldevc2;}
									if($_POST[redondeoibcpara]==1){$ibcpara2=ceil($saldevc3/$_POST[tiporedondeoibc2])*$_POST[tiporedondeoibc2];}
									else {$ibcpara2=$saldevc3;}
									//incapacidad
									if($_POST[redondeoibc]==1){$ibcnomina3=ceil($saldevb1/$_POST[tiporedondeoibc2])*$_POST[tiporedondeoibc2];}
									else {$ibcnomina3=$saldevb1;}
									if($_POST[redondeoibcarp]==1){$ibcarp3=ceil($saldevb2/$_POST[tiporedondeoibc2])*$_POST[tiporedondeoibc2];}
									else {$ibcarp3=$saldevb2;}
									if($_POST[redondeoibcpara]==1){$ibcpara3=ceil($saldevb3/$_POST[tiporedondeoibc2])*$_POST[tiporedondeoibc2];}
									else {$ibcpara3=$saldevb3;}
								}
								else
								{
									//salarios
									if($_POST[redondeoibc]==1){$ibcnomina1=round($saldev, -3);}
									else {$ibcnomina1=$saldev;}
									if($_POST[redondeoibcarp]==1){$ibcarp1=round($saldev, -3);}
									else {$ibcarp1=$saldev;}
									if($_POST[redondeoibcpara]==1){$ibcpara1=round($saldev, -3);}
									else {$ibcpara1=$saldev;}
									//vacaciones
									if($_POST[redondeoibc]==1){$ibcnomina2=round($saldevc1, -3);}
									else {$ibcnomina2=$saldevc1;}
									if($_POST[redondeoibcarp]==1){$ibcarp2=round($saldevc2, -3);}
									else {$ibcarp2=$saldevc2;}
									if($_POST[redondeoibcpara]==1){$ibcpara2=round($saldevc3, -3);}
									else {$ibcpara2=$saldevc3;}
									//incapacidad
									if($_POST[redondeoibc]==1){$ibcnomina3=round($saldevb1, -3);}
									else {$ibcnomina3=$saldevb1;}
									if($_POST[redondeoibcarp]==1){$ibcarp3=round($saldevb2, -3);}
									else {$ibcarp3=$saldevb2;}
									if($_POST[redondeoibcpara]==1){$ibcpara3=round($saldevb3, -3);}
									else {$ibcpara3=$saldevb3;}
								}
								//todos
								$ibcnomina=$ibcnomina1+$ibcnomina2;
								$ibcarp=$ibcarp1+$ibcarp2;
								$ibcpara=$ibcpara1+$ibcpara2;
							}
						}
						//**ARP
						$porcentaje=buscaporcentajeparafiscal($_POST[tarp],'A');
						if($_POST[tipoliquidacion]==0)
						{
							$valdeci= (int) substr(number_format(($ibcarp*$porcentaje)/100,0),-2);
							if($valdeci > 5){$valarp=ceil(($ibcarp*$porcentaje)/10000)*100;}
							else {$valarp=round (($ibcarp*$porcentaje)/100,-2,PHP_ROUND_HALF_DOWN);}
							if($row[7]=="17328104"){$valarp=$valarp/2;}
						}
						else
						{
							//Salario
							$valdeci1= (int) substr(number_format(($ibcarp1*$porcentaje)/100,0),-2);
							if($valdeci1 > 5){$valarp1=ceil(($ibcarp1*$porcentaje)/10000)*100;}
							else {$valarp1=round (($ibcarp1*$porcentaje)/100,-2,PHP_ROUND_HALF_DOWN);}
							//Vacaciones
							$valdeci2= (int) substr(number_format(($ibcarp2*$porcentaje)/100,0),-2);
							if($valdeci2 > 5){$valarp2=ceil(($ibcarp2*$porcentaje)/10000)*100;}
							else {$valarp2=round (($ibcarp2*$porcentaje)/100,-2,PHP_ROUND_HALF_DOWN);}
							//Vacaciones
							$valdeci3= (int) substr(number_format(($ibcarp3*$porcentaje)/100,0),-2);
							if($valdeci3 > 5){$valarp3=ceil(($ibcarp3*$porcentaje)/10000)*100;}
							else {$valarp3=round (($ibcarp3*$porcentaje)/100,-2,PHP_ROUND_HALF_DOWN);}
							//total
							$valdeci=$valdeci1+$valdeci2+$valdeci3;
							$valarp=$valarp1+$valarp2+$valarp3;
						}
						$pf[$_POST[tarp]][$row[13]]+=$valarp;
						$sqlr="select * from humparafiscales_det where codigo='$_POST[tarp]' and cc='$row[13]' and estado='S' and vigencia='$_POST[vigencia]'";
						$resrp = mysql_query($sqlr,$linkbd);
						$rowrp =mysql_fetch_row($resrp);
						$pfcp[$rowrp[6]]+=$valarp;
						//**Salud
						$porcentaje1=buscaporcentajeparafiscal($_POST[tsaludemr],'A');
						$porcentaje2=buscaporcentajeparafiscal($_POST[tsaludemp],'D');
						$porcentajet=$porcentaje1+$porcentaje2;
						if($_POST[tipoliquidacion]==0)
						{
							$valsaludtotsin=($ibcnomina*$porcentajet)/100;
							$valsaludtot=ceil(($ibcnomina*$porcentajet)/10000)*100;
							$rsalud=round(($ibcnomina*$porcentaje2)/100);
							$rsaludemp=$valsaludtot-$rsalud;
						}
						else
						{
							//sueldo
							$valsaludtotsin1=($ibcnomina1*$porcentajet)/100;
							$valsaludtot1=ceil(($ibcnomina1*$porcentajet)/10000)*100;
							$rsalud1=round(($ibcnomina1*$porcentaje2)/100);
							$rsaludemp1=$valsaludtot1-$rsalud1;
							//vacaciones
							$valsaludtotsin2=($ibcnomina2*$porcentajet)/100;
							$valsaludtot2=ceil(($ibcnomina2*$porcentajet)/10000)*100;
							$rsalud2=round(($ibcnomina2*$porcentaje2)/100);
							$rsaludemp2=$valsaludtot2-$rsalud2;
							//incapacidad
							$valsaludtotsin3=($ibcnomina3*$porcentajet)/100;
							$valsaludtot3=ceil(($ibcnomina3*$porcentajet)/10000)*100;
							$rsalud3=round(($ibcnomina3*$porcentaje2)/100);
							$rsaludemp3=$valsaludtot3-$rsalud2;
							//total
							$valsaludtotsin=$valsaludtotsin1 + $valsaludtotsin2 + $valsaludtotsin3;
							$valsaludtot=$valsaludtot1+$valsaludtot2+$valsaludtot3;
							$rsalud=$rsalud1+$rsalud2+$rsalud3;
							$rsaludemp=$rsaludemp1+$rsaludemp2+$rsaludemp3;
						}
						$pf[$_POST[tsaludemr]][$row[13]]+=$rsaludemp;
						$sqlr="select * from humparafiscales_det where codigo='$_POST[tsaludemr]' and cc='$row[13]' and estado='S' and vigencia='$_POST[vigencia]'";
						$resrp = mysql_query($sqlr,$linkbd);
						$rowrp =mysql_fetch_row($resrp);
						$pfcp[$rowrp[6]]+=$rsaludemp;
						//**Pension
						if($row[11]!='')
						{
							$porcentaje1=buscaporcentajeparafiscal($_POST[tpensionemr],'A');
							$porcentaje2=buscaporcentajeparafiscal($_POST[tpensionemp],'D');
							$porcentajet=$porcentaje1+$porcentaje2;
							if($_POST[tipoliquidacion]==0)
							{
								
								
								$valpensiontot=ceil (($ibcnomina*$porcentajet)/10000)*100;
								$rpension=round(($ibcnomina*$porcentaje2)/100);
								if($row[7]=="6848975"){$valpensiontot=$valpensiontot+100;}
								$rpensionemp=$valpensiontot-$rpension;
							}
							else
							{
								//sueldo
								$valpensiontot1=ceil (($ibcnomina1*$porcentajet)/10000)*100;
								$rpension1=round(($ibcnomina1*$porcentaje2)/100);
								$rpensionemp1=$valpensiontot1-$rpension1;
								//vacaciones
								$valpensiontot2=ceil (($ibcnomina2*$porcentajet)/10000)*100;
								$rpension2=round(($ibcnomina2*$porcentaje2)/100);
								$rpensionemp2=$valpensiontot2-$rpension2;
								//incapasidad
								$valpensiontot3=ceil (($ibcnomina3*$porcentajet)/10000)*100;
								$rpension3=round(($ibcnomina3*$porcentaje2)/100);
								$rpensionemp3=$valpensiontot3-$rpension3;
								//total
								$valpensiontot=$valpensiontot1+$valpensiontot2+$valpensiontot3;
								$rpension=$rpension1+$rpension2+$rpension3;
								$rpensionemp=$rpensionemp1+$rpensionemp2+$rpensionemp3;
							}
							$sqlrfs="SELECT * FROM humfondosoli where estado='S' and $row[6] between (rangoinicial*$_POST[salmin]) and (rangofinal*$_POST[salmin])";
							$respfs = mysql_query($sqlrfs,$linkbd);
							$rowfs =mysql_fetch_row($respfs);	
							if($_POST[tipofondosol]==0)
							{$fondosol=round((($rowfs[3]/2)/100)*(round($ibcnomina,-3,PHP_ROUND_HALF_DOWN)),-2)*2;}
							else {$fondosol=ceil(((($rowfs[3]/2)/100)*round($ibcnomina,-3,PHP_ROUND_HALF_DOWN))/100)*200;}
							$pf[$_POST[tpensionemr]][$row[13]]+=$rpensionemp;
							if($row[18]=='PR'){$tpf='privado';}
							if($row[18]=='PB'){$tpf='publico';}
							$sqlr="select * from humparafiscales_det where codigo='$_POST[tpensionemr]' and cc='$row[13]' and estado='S' and sector='$tpf' and vigencia='$_POST[vigencia]'";
							$resrp = mysql_query($sqlr,$linkbd);
							$rowrp =mysql_fetch_row($resrp);
							$pfcp[$rowrp[6]]+=$rpensionemp;
						}
						else{$valpensiontot=$rpension=$rpensionemp=0;}
						//**CCF
						$porcentaje=buscaporcentajeparafiscal($_POST[tcajacomp],'A');
						if($_POST[tipoliquidacion]==0){$valccf=ceil(($ibcpara*$porcentaje)/10000)*100;if($row[7]=="17316460"  || $row[7]=="30218905"){$valccf+=100;}}
						else
						{
							$valccf1=ceil(($ibcpara1*$porcentaje)/10000)*100;//sueldo
							$valccf2=ceil(($ibcpara2*$porcentaje)/10000)*100;//vacaciones
							$valccf3=ceil(($ibcpara3*$porcentaje)/10000)*100;//incapasidad
							$valccf=$valccf1+$valccf2+$valccf3;//total
						}
						$pf[$_POST[tcajacomp]][$row[13]]+=$valccf;
						$sqlr="select * from humparafiscales_det where codigo='$_POST[tcajacomp]' and cc='$row[13]' and estado='S' and vigencia='$_POST[vigencia]'";
						$resrp = mysql_query($sqlr,$linkbd);
						$rowrp =mysql_fetch_row($resrp);
						$pfcp[$rowrp[6]]+=$valccf;
						//**SENA
						$porcentaje=buscaporcentajeparafiscal($_POST[tsena],'A');
						if($_POST[tipoliquidacion]==0){$valsena=ceil(($ibcpara*$porcentaje)/10000)*100;if($row[7]=="6848975" || $row[7]=="17316460"){$valsena+=100;}}
						else
						{
							$valsena1=ceil(($ibcpara1*$porcentaje)/10000)*100;//sueldo
							$valsena2=ceil(($ibcpara2*$porcentaje)/10000)*100;//vacaciones
							$valsena3=ceil(($ibcpara3*$porcentaje)/10000)*100;//incapasidad
							$valsena=$valsena1+$valsena2+$valsena3;//total
						}
						$pf[$_POST[tsena]][$row[13]]+=$valsena;
						$sqlr="select * from humparafiscales_det where codigo='$_POST[tsena]' and cc='$row[13]' and estado='S' and vigencia='$_POST[vigencia]'";
						$resrp = mysql_query($sqlr,$linkbd);
						$rowrp =mysql_fetch_row($resrp);
						$pfcp[$rowrp[6]]+=$valsena;
						//**ICBF
						$porcentaje=buscaporcentajeparafiscal($_POST[ticbf],'A');
						if($_POST[tipoliquidacion]==0){$valicbf=ceil(($ibcpara*$porcentaje)/10000)*100;if($row[7]=="6848975" || $row[7]=="17316460"  || $row[7]=="30218905"){$valicbf+=100;}}
						else
						{
							$valicbf1=ceil(($ibcpara1*$porcentaje)/10000)*100;//sueldo
							$valicbf2=ceil(($ibcpara2*$porcentaje)/10000)*100;//vacaciones
							$valicbf3=ceil(($ibcpara3*$porcentaje)/10000)*100;//incapasidad
							$valicbf=$valicbf1+$valicbf2+$valicbf3;//total
						}
						$pf[$_POST[ticbf]][$row[13]]+=$valicbf;
						$sqlr="select * from humparafiscales_det where codigo='$_POST[ticbf]' and cc='$row[13]' and estado='S' and vigencia='$_POST[vigencia]'";
						$resrp = mysql_query($sqlr,$linkbd);
						$rowrp =mysql_fetch_row($resrp);
						$pfcp[$rowrp[6]]+=$valicbf;
						//**INSTITUTOS TECNICOS
						$porcentaje=buscaporcentajeparafiscal($_POST[titi],'A');
						if($_POST[tipoliquidacion]==0){$valinstec=ceil(($ibcpara*$porcentaje)/10000)*100;if($row[7]=="6848975" || $row[7]=="17316460"  || $row[7]=="30218905"){$valinstec+=100;}}
						else
						{
							$valinstec1=ceil(($ibcpara1*$porcentaje)/10000)*100;//sueldo
							$valinstec2=ceil(($ibcpara2*$porcentaje)/10000)*100;//vacasiones
							$valinstec3=ceil(($ibcpara3*$porcentaje)/10000)*100;//incapasidad
							$valinstec=$valinstec1+$valinstec2+$valinstec3;
						}
						$pf[$_POST[titi]][$row[13]]+=$valinstec;
						$sqlr="select * from humparafiscales_det where codigo='$_POST[titi]' and cc='$row[13]' and estado='S' and vigencia='$_POST[vigencia]'";
						$resrp = mysql_query($sqlr,$linkbd);
						$rowrp =mysql_fetch_row($resrp);
						$pfcp[$rowrp[6]]+=$valinstec;
						//**ESAP
						$porcentaje=buscaporcentajeparafiscal($_POST[tesap],'A');
						if($_POST[tipoliquidacion]==0){$valesap=ceil(($ibcpara*$porcentaje)/10000)*100;if($row[7]=="6848975" || $row[7]=="17316460"){$valesap+=100;}}
						else
						{
							$valesap1=ceil(($ibcpara1*$porcentaje)/10000)*100;//sueldo
							$valesap2=ceil(($ibcpara2*$porcentaje)/10000)*100;//vacaciones
							$valesap3=ceil(($ibcpara3*$porcentaje)/10000)*100;//incapasidad
							$valesap=$valesap1+$valesap2+$valesap3;
						}
						$pf[$_POST[tesap]][$row[13]]+=$valesap;
						$sqlr="select * from humparafiscales_det where codigo='$_POST[tesap]' and cc='$row[13]' and estado='S' and vigencia='$_POST[vigencia]'";
						$resrp = mysql_query($sqlr,$linkbd);
						$rowrp =mysql_fetch_row($resrp);
						$pfcp[$rowrp[6]]+=$valesap;
						//Descuentos
						$sqlrds="SELECT sum(valorcuota) FROM humretenempleados WHERE estado='S' AND habilitado='H' AND empleado='$row[7]' AND sncuotas>0";
						$respds = mysql_query($sqlrds,$linkbd);
						$rowds =mysql_fetch_row($respds);
						$otrasrete=round($rowds[0]);
						//**Total descuentos
						$totalretenciones=$rsalud+$rpension+$otrasrete+$fondosol;
						//**Neto a Pagar
						$totalneto= $totaldevengado-$totalretenciones;
						
						$listatipopension[]=$row[18];
						$listaempleados[]=strtoupper($row[8]);
						$listadocumentos[]=$row[7];
						$listasalariobasico[]=$row[6];
						$listadiasliquidados[]=$row[15];
						$listadevengados[]=$saldev;
						$listaauxalimentacion[]=$auxalim;
						$listaauxtrasporte[]=$auxtra;
						$listaotrospagos[]=$valotrospagos;
						$listatotaldevengados[]=$totaldevengado;
						$listaibc[]=$ibcnomina;
						$listabaseparafiscales[]=$ibcpara;
						$listabasearp[]=$ibcarp;
						$listaarp[]=$valarp;
						$listasaludempleado[]=$rsalud;
						$listasaludempresa[]=$rsaludemp;
						$listasaludtotal[]=$valsaludtot;
						$listapensionempleado[]=$rpension;
						$listapensionempresa[]=$rpensionemp;
						$listapensiontotal[]=$valpensiontot;
						$listafondosolidaridad[]=$fondosol;
						$listaotrasdeducciones[]=$otrasrete;
						$listatotaldeducciones[]=$totalretenciones;
						$listanetoapagar[]=$totalneto;
						$listaccf[]=$valccf;
						$listasena[]=$valsena;
						$listaicbf[]=$valicbf;
						$listainstecnicos[]=$valinstec;
						$listaesap[]=$valesap;
						$listatipofondopension[]=$row[18];
						$listaidprenomina[]=$row[0];
						$listadiasincapacidad[]=$row[17];
						
						//calculo parte presupuestal
						//**devengado
						$sqlr="select * from  humvariables_det where codigo='$_POST[tsueldo]' and cc='$row[13]' and estado='S' and vigencia='$_POST[vigencia]'";
						$resrp = mysql_query($sqlr,$linkbd);
						$rowrp =mysql_fetch_row($resrp);
						$pfcp[$rowrp[7]]+= $saldev; 
						//**alimentacion
						$sqlr="select * from  humvariables_det where codigo='$_POST[tsubalim]' and cc='$row[13]' and estado='S' and vigencia='$_POST[vigencia]'";
						$resrp = mysql_query($sqlr,$linkbd);
						$rowrp =mysql_fetch_row($resrp);
						$pfcp[$rowrp[7]]+= $auxalim;
						//**transporte
						$sqlr="select * from  humvariables_det where codigo='$_POST[tauxtrans]' and cc='$row[13]' and estado='S' and vigencia='$_POST[vigencia]'";
						$resrp = mysql_query($sqlr,$linkbd);
						$rowrp =mysql_fetch_row($resrp);								
						$pfcp[$rowrp[7]]+= $auxtra;	
					}
				}
			?>   
			<div class="tabscontra" style="height:64%; width:99.6%"> 
 				<div class="tab">
       				<input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
	   				<label for="tab-1">Liquidacion Empleados</label>
	   				<div class="content" >
						<table class='inicio' align='center' width='99%'>
                            <tr><td colspan='34' class='titulos'>.: Resultados Busqueda: $ntr Empleados</td></tr>
                            <tr>
                            	<td class='titulos2'><img src='imagenes/plus.gif'></td>
                                <td class='titulos2'>Id</td>
                                <td class='titulos2'>SECTOR</td>
                                <td class='titulos2'>EMPLEADO</td>
                                <td class='titulos2'>Doc Id</td>
                                <td class='titulos2'>SAL BAS</td>
                                <td class='titulos2'>DIAS LIQ</td>
                                <td class='titulos2'>DEVENGADO</td>
                                <td class='titulos2'>AUX ALIM</td>
                                <td class='titulos2'>AUX TRAN</td>
                                <td class='titulos2'>OTROS</td>
                                <td class='titulos2'>TOT DEV</td>
                                <td class='titulos2'>IBC</td>
                                <td class='titulos2'>BASE PARAFISCALES</td>									
                                <td class='titulos2'>BASE ARP</td>
                                <td class='titulos2'>ARP</td>
                                <td class='titulos2'>SALUD EMPLEADO</td>
                                <td class='titulos2'>SALUD EMPRESA</td>
                                <td class='titulos2'>SALUD TOTAL</td>
                                <td class='titulos2'>PENSION EMPLEADO</td>
                                <td class='titulos2'>PENSION EMPRESA</td>
                                <td class='titulos2'>PENSION TOTAL</td>
                                <td class='titulos2'>FONDO SOLIDARIDAD</td>
                                <td class='titulos2'>RETE FTE</td>
                                <td class='titulos2'>OTRAS DEDUC</td>
                                <td class='titulos2'>TOT DEDUC</td>
                                <td class='titulos2'>NETO PAG</td>
                                <td class='titulos2'>CCF</td>
                                <td class='titulos2'>SENA</td>
                                <td class='titulos2'>ICBF</td>
                                <td class='titulos2'>INS. TEC.</td>
                                <td class='titulos2'>ESAP</td>
                            </tr>
                            <?php
								$iter="zebra1";
								$iter2="zebra2";
								for ($x=0;$x<count($listaempleados);$x++)
								{
									echo"
									<tr  class='$iter'>
										<td class='titulos2'><img id='img$x' src='imagenes/plus.gif' onClick=\"detallesnomina('$x', '$listaidprenomina[$x]')\" style='cursor:pointer;'></td>
										<td style='text-align:right;'>".($x+1)."&nbsp;</td>
										<td>$listatipopension[$x]</td>
										<td>$listaempleados[$x]</td>													
										<td style='text-align:right;'>$listadocumentos[$x]&nbsp;</td>
										<td style='text-align:right;' title='Salario Basico'>$".number_format($listasalariobasico[$x],0,',','.')."</td>
										<td style='text-align:right;'>$listadiasliquidados[$x]&nbsp;</td>
										<td style='text-align:right;' title='Salario Devengado'>$".number_format($listadevengados[$x],0,',','.')."</td>
										<td style='text-align:right;' title='Auxilio Alimentacion'>$".number_format($listaauxalimentacion[$x],0,',','.')."</td>
										<td style='text-align:right;' title='Auxilio Transporte'>$".number_format($listaauxtrasporte[$x],0,',','.')."</td>
										<td style='text-align:right;' title='Otros Pagos'>$".number_format($listaotrospagos[$x],0,',','.')."</td>
										<td style='text-align:right;' title='Total Devengado'>$".number_format($listatotaldevengados[$x],0,',','.')."</td>
										<td style='text-align:right;' title='IBC'>$".number_format($listaibc[$x],0,',','.')."</td>
										<td style='text-align:right;' title='Base Parafiscales'>$".number_format($listabaseparafiscales[$x],0,',','.')."</td>
										<td style='text-align:right;' title='Base ARP'>$".number_format($listabasearp[$x],0,',','.')."</td>
										<td style='text-align:right;' title='Valor ARP'>$".number_format($listaarp[$x],0,',','.')."</td>
										<td style='text-align:right;' title='Salud Empleado'>$".number_format($listasaludempleado[$x],0,',','.')."</td>
										<td style='text-align:right;' title='Salud Empresa'>$".number_format($listasaludempresa[$x],0,',','.')."</td>
										<td style='text-align:right;' title='Salud Total'>$".number_format($listasaludtotal[$x],0,',','.')."</td>
										<td style='text-align:right;' title='Pension Empleado'>$".number_format($listapensionempleado[$x],0,',','.')."</td>
										<td style='text-align:right;' title='Pension Empresa'>$".number_format($listapensionempresa[$x],0,',','.')."</td>
										<td style='text-align:right;' title='Pension Total'>$".number_format($listapensiontotal[$x],0,',','.')."</td>
										<td style='text-align:right;' title='fondo Solidaridad'>$".number_format($listafondosolidaridad[$x],0,',','.')."</td>
										<td style='text-align:right;' title='Retefunte'>$0</td>
										<td style='text-align:right;' title='Otras Deducciones'>$".number_format($listaotrasdeducciones[$x],0,',','.')."</td>
										<td style='text-align:right;' title='Total Deducciones'>$".number_format($listatotaldeducciones[$x],0,',','.')."</td>
										<td style='text-align:right;' title='Neto a Pagar'>$".number_format($listanetoapagar[$x],0,',','.')."</td>
										<td style='text-align:right;' title='CCF'>$".number_format($listaccf[$x],0,',','.')."</td>
										<td style='text-align:right;' title='SENA'>$".number_format($listasena[$x],0,',','.')."</td>
										<td style='text-align:right;' title='ICBF'>$".number_format($listaicbf[$x],0,',','.')."</td>
										<td style='text-align:right;' title='Institutos Tecnicos'>$".number_format($listainstecnicos[$x],0,',','.')."</td>
										<td style='text-align:right;' title='ESAP'>$".number_format($listaesap[$x],0,',','.')."</td>
									</tr>
									<tr>
										<td align='center'></td>
										<td colspan='33'>
											<div id='detalle$x' style='display:none'></div>
										</td>
									</tr>";
									$aux=$iter;
									$iter=$iter2;
									$iter2=$aux;
								}
								echo"
							<input type='hidden' name='lista_empleados' value='".serialize($listaempleados)."'/>
							<input type='hidden' name='lista_documento' value='".serialize($listadocumentos)."'/>
							<input type='hidden' name='lista_salariobasico' value='".serialize($listasalariobasico)."'/>
							<input type='hidden' name='lista_devengados' value='".serialize($listadevengados)."'/>
							<input type='hidden' name='lista_auxalimentacion' value='".serialize($listaauxalimentacion)."'/>
							<input type='hidden' name='lista_auxtrasporte' value='".serialize($listaauxtrasporte)."'/>
							<input type='hidden' name='lista_otrospagos' value='".serialize($listaotrospagos)."'/>
							<input type='hidden' name='lista_totaldevengados' value='".serialize($listatotaldevengados)."'/>
							<input type='hidden' name='lista_ibc' value='".serialize($listaibc)."'/>
							<input type='hidden' name='lista_baseparafiscales' value='".serialize($listabaseparafiscales)."'/>
							<input type='hidden' name='lista_basearp' value='".serialize($listabasearp)."'/>
							<input type='hidden' name='lista_arp' value='".serialize($listaarp)."'/>
							<input type='hidden' name='lista_saludempleado' value='".serialize($listasaludempleado)."'/>
							<input type='hidden' name='lista_saludempresa' value='".serialize($listasaludempresa)."'/>
							<input type='hidden' name='lista_saludtotal' value='".serialize($listasaludtotal)."'/>
							<input type='hidden' name='lista_pensionempleado' value='".serialize($listapensionempleado)."'/>
							<input type='hidden' name='lista_pensionempresa' value='".serialize($listapensionempresa)."'/>
							<input type='hidden' name='lista_pensiontotal' value='".serialize($listapensiontotal)."'/>
							<input type='hidden' name='lista_fondosolidaridad' value='".serialize($listafondosolidaridad)."'/>
							<input type='hidden' name='lista_otrasdeducciones' value='".serialize($listaotrasdeducciones)."'/>
							<input type='hidden' name='lista_totaldeducciones' value='".serialize($listatotaldeducciones)."'/>
							<input type='hidden' name='lista_netoapagar' value='".serialize($listanetoapagar)."'/>
							<input type='hidden' name='lista_ccf' value='".serialize($listaccf)."'/>
							<input type='hidden' name='lista_sena' value='".serialize($listasena)."'/>
							<input type='hidden' name='lista_icbf' value='".serialize($listaicbf)."'/>
							<input type='hidden' name='lista_instecnicos' value='".serialize($listainstecnicos)."'/>
							<input type='hidden' name='lista_esap' value='".serialize($listaesap)."'/>
							<input type='hidden' name='lista_diasincapacidad' value='".serialize($listadiasincapacidad)."'/>
							<input type='hidden' name='lista_diaslaborados' value='".serialize($listadiaslaborados)."'/>
							<tr class='titulos2'>
								<td colspan='7'></td>
								<td style='text-align:right;'>$".number_format(array_sum($listadevengados),0,',','.')."</td>
								<td style='text-align:right;'>$".number_format(array_sum($listaauxalimentacion),0,',','.')."</td>
								<td style='text-align:right;'>$".number_format(array_sum($listaauxtrasporte),0,',','.')."</td>
								<td style='text-align:right;'>$".number_format(array_sum($listaotrospagos),0,',','.')."</td>
								<td style='text-align:right;'>$".number_format(array_sum($listatotaldevengados),0,',','.')."</td>
								<td style='text-align:right;'>$".number_format(array_sum($listaibc),0,',','.')."</td>
								<td style='text-align:right;'>$".number_format(array_sum($listabaseparafiscales),0,',','.')."</td>
								<td style='text-align:right;'>$".number_format(array_sum($listabasearp),0,',','.')."</td>
								<td style='text-align:right;'>$".number_format(array_sum($listaarp),0,',','.')."</td>
								<td style='text-align:right;'>$".number_format(array_sum($listasaludempleado),0,',','.')."</td>
								<td style='text-align:right;'>$".number_format(array_sum($listasaludempresa),0,',','.')."</td>
								<td style='text-align:right;'>$".number_format(array_sum($listasaludtotal),0,',','.')."</td>
								<td style='text-align:right;'>$".number_format(array_sum($listapensionempleado),0)."</td>
								<td style='text-align:right;'>$".number_format(array_sum($listapensionempresa),0,',','.')."</td>
								<td style='text-align:right;'>$".number_format(array_sum($listapensiontotal),0,',','.')."</td>
								<td style='text-align:right;'>$".number_format(array_sum($listafondosolidaridad),0,',','.')."</td>
								<td style='text-align:right;'>$0</td>
								<td style='text-align:right;'>$".number_format(array_sum($listaotrasdeducciones),0,',','.')."</td>
								<td style='text-align:right;'>$".number_format(array_sum($listatotaldeducciones),0,',','.')."</td>
								<td style='text-align:right;'>$".number_format(array_sum($listanetoapagar),0,',','.')."</td>
								<td style='text-align:right;'>$".number_format(array_sum($listaccf),0,',','.')."</td>
								<td style='text-align:right;'>$".number_format(array_sum($listasena),0,',','.')."</td>
								<td style='text-align:right;'>$".number_format(array_sum($listaicbf),0,',','.')."</td>
								<td style='text-align:right;'>$".number_format(array_sum($listainstecnicos),0,',','.')."</td>
								<td style='text-align:right;'>$".number_format(array_sum($listaesap),0,',','.')."</td>
							</tr>";	
							$listatotalparafiscales[$_POST[tcajacomp]]=array_sum($listaccf);
							$listatotalparafiscales[$_POST[ticbf]]=array_sum($listaicbf);
							$listatotalparafiscales[$_POST[tsena]]=array_sum($listasena);
							$listatotalparafiscales[$_POST[titi]]=array_sum($listainstecnicos);
							$listatotalparafiscales[$_POST[tesap]]=array_sum($listaesap);
							$listatotalparafiscales[$_POST[tarp]]=array_sum($listaarp);
							$listatotalparafiscales[$_POST[tsaludemr]]=array_sum($listasaludempresa);
							$listatotalparafiscales[$_POST[tsaludemp]]=array_sum($listasaludempleado);
							$listatotalparafiscales[$_POST[tpensionemr]]=array_sum($listapensionempresa);
							$listatotalparafiscales[$_POST[tpensionemp]]=array_sum($listapensionempleado);
							?>
                 		</table>
                 	</div>
				</div>
    			<div class="tab">
       				<input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?> >
	   				<label for="tab-2">Aportes Parafiscales</label>
	   				<div class="content" style="overflow:hidden">
						<table class="inicio">
							<tr>
								<td class="titulos" style="width:8%">Codigo</td>
                                <td class="titulos" style="width:20%">Aportes Parafiscales</td>
                                <td class="titulos" style="width:8%">Porcentaje</td>
                                <td class="titulos" style="width:10%">Valor</td>
                                <td class="titulos" >descripci&oacute;n</td>
							</tr>
                            <?php
								if($_POST[idpreli]!="-1")
								{
									$iter="zebra1";
									$iter2="zebra2";
									$sqlr="select * from humparafiscales where  estado='S'";
									$resp2 = mysql_query($sqlr,$linkbd);
									while($row2 =mysql_fetch_row($resp2))
									{
										echo "
										<tr class='$iter'>
											<input type='hidden' name='codpara[]' value='$row2[0]'/>
											<input type='hidden' name='codnpara[]' value='$row2[1]'/>
											<input type='hidden' name='porpara[]' value='$row2[3]'/>
											<input type='hidden' name='valpara[]' value='".$listatotalparafiscales[$row2[0]]."'/>
											<input type='hidden' name='tipopara[]' value='$row2[2]'/>
											<td>$row2[0]</td>
											<td>$row2[1]</td>
											<td style='text-align:right;'>$row2[3] %</td>
											<td style='text-align:right;'>$ ".number_format($listatotalparafiscales[$row2[0]],0)."&nbsp;</td>";
										if ($row2[2]=="A"){echo"<td>&nbsp;APORTES EMPRESA</td>";}
										else{echo"<td>&nbsp;APORTE EMPLEADOS</td>";}
										echo"	</tr>";
										$aux=$iter;
										$iter=$iter2;
										$iter2=$aux;
									}
									echo "
									<tr>
										<td></td>
										<td colspan='2' style='text-align:right;'>TOTAL SALUD: </td>
										<td class='saludo3' style='text-align:right;'>$ ".number_format(array_sum($listasaludtotal),2)."</td>
										<td></td>
									</tr>
									<tr '>
										<td></td>
										<td colspan='2' style='text-align:right;'>TOTAL PENSION: </td>
										<td class='saludo3' style='text-align:right;'>".number_format(array_sum($listapensiontotal),2)."</td>
									</tr>";
								}
							?>
						</table>
					</div>
				</div>
    			<div class="tab">
       				<input type="radio" id="tab-3" name="tabgroup1" value="3" <?php echo $check3;?> >
	   				<label for="tab-3">Presupuesto</label>
	   				<div class="content" style="overflow-x:hidden">
						<table class="inicio">
							<tr>
								<td class="titulos">Cuenta Presupuestal</td>
                                <td class="titulos">Nombre Cuenta Presupuestal</td>
                                <td class="titulos">Valor</td>
                                 <td class="titulos" style='width:5%'>Saldo</td>
                          	</tr>
							<?php
								$totalrubro=0;
								
								foreach($pfcp as $k => $valrubros)
 								{
  									$ncta=existecuentain($k);
									
  									if($valrubros>0)
  									{  		
  									$saldo="";							
  									$vsal=generaSaldo($k,$_POST[vigencia],$_POST[vigencia]);
  									if($vsal>=$valrubros)
									{
									$saldo="OK";
									$color=" style=' background-color :#092; color:#fff' ";
									}
  									else
  									{
  									$saldo="SIN SALDO";
  									$color=" style=' background-color :#901; color:#fff' ";
  									}
 										echo "
										<input type='hidden' name='rubrosp[]' value='$k'/>
										<input type='hidden' name='nrubrosp[]' value='".strtoupper($ncta)."'/>
										<input type='hidden' name='vrubrosp[]' value='$valrubros'/>
										<input type='hidden' name='vsaldo[]' value='$saldo'/>
										<tr class='saludo3'>
											<td>$k</td>
											<td>".strtoupper($ncta)."</td>
											<td align='right'>".number_format($valrubros,0)."</td>
											<td align='center' $color>".$saldo."</td>
										</tr>";
  										$totalrubro+=$valrubros;
  									}
 								}
							?>
							<tr class='saludo3'>
                            	<td></td>
                                <td>Total:</td>
                                <td align='right'><?php echo number_format($totalrubro,2) ?></td>
                         	</tr> 
						</table>
					</div>
				</div>
				<div class="tab">
       				<input type="radio" id="tab-4" name="tabgroup1" value="4" <?php echo $check4;?> >
	   				<label for="tab-4">Vacaciones</label>
	   				<div class="content" >
       					<table class="inicio">
       						<tr>
                            	<td class="titulos">No</td>
                                <td class="titulos">Documento</td>
                                <td class="titulos">Nombre</td>
                                <td class="titulos">Salario Basico</td>
                                <td class="titulos">Salario dia</td>
                                <td class="titulos">Valor</td>
                                <td class="titulos">Fecha Inicio</td>
                                <td class="titulos">Fecha Final</td>
                                <td class="titulos" style="width:5%;">Dias Vacaciones</td>
                                <td class="titulos" style="width:5%;">Paga SyP</td>
                                <td class="titulos" style="width:5%;">Paga ARL</td>
                                <td class="titulos" style="width:5%;">Paga Parafiscales</td>
                          	</tr>
                            <?php
								
								if($_POST[idpreli]!="-1")
								{
									$iter="zebra1";
									$iter2="zebra2";
									$sqlr="SELECT mes,vigencia,salarifun,documefun,nombrefun FROM hum_prenomina_det WHERE codigo='$_POST[idpreli]' AND diasv > 0 ORDER BY id_det"; 
									$resp = mysql_query($sqlr,$linkbd);
									while ($row =mysql_fetch_row($resp)) 
									{
										$sqlr2="SELECT * FROM hum_vacaciones_det WHERE mes='$row[0]' AND vigencia='$row[1]' AND doc_funcionario= '$row[3]' AND estado='S'";
										$resp2 = mysql_query($sqlr2,$linkbd);
										while($row2 =mysql_fetch_row($resp2))
										{
											$sqlr3="SELECT fecha_ini,fecha_fin	 FROM hum_vacaciones WHERE num_vaca='$row2[0]'";
											$resp3 = mysql_query($sqlr3,$linkbd);
											$row3 =mysql_fetch_row($resp3);
											if($row2[8]=="S"){$imasem1="<img src='imagenes/sema_verdeON.jpg' title='Si Paga' style='width:20px'/>";}
											else{$imasem1="<img src='imagenes/sema_rojoON.jpg' title='No Paga' style='width:20px'/>";}
											if($row2[9]=="S"){$imasem2="<img src='imagenes/sema_verdeON.jpg' title='Si Paga' style='width:20px'/>";}
											else{$imasem2="<img src='imagenes/sema_rojoON.jpg' title='No Paga' style='width:20px'/>";}
											if($row2[10]=="S"){$imasem3="<img src='imagenes/sema_verdeON.jpg' title='Si Paga' style='width:20px'/>";}
											else{$imasem3="<img src='imagenes/sema_rojoON.jpg' title='No Paga' style='width:20px'/>";}
											echo"
											<tr class='$iter'>
												<td>$row2[0]</td>
												<td>$row[3]</td>
												<td>$row[4]</td>
												<td style='text-align:right;'>$".number_format($row[2],0,',','.')."</td>
												<td style='text-align:right;'>$".number_format($row2[6],0,',','.')."</td>
												<td style='text-align:right;'>$".number_format($row2[7],0,',','.')."</td>
												<td style='text-align:center;'>".date('d-m-Y',strtotime($row3[0]))."</td>
												<td style='text-align:center;'>".date('d-m-Y',strtotime($row3[1]))."</td>
												<td style='text-align:right;'>$row2[5]</td>
												<td style='text-align:center;'>$imasem1</td>
												<td style='text-align:center;'>$imasem2</td>
												<td style='text-align:center;'>$imasem3</td>
											</tr>";	
											$aux=$iter;
											$iter=$iter2;
											$iter2=$aux;
										}
										
									}
								}
								
								
							?>
               			</table>
       				</div>  
 				</div>                        
 				<div class="tab">
       				<input type="radio" id="tab-5" name="tabgroup1" value="5" <?php echo $check5;?> >
	   				<label for="tab-5">Incapacidades</label>
	   				<div class="content" >
       					<table class="inicio">
       						<tr>
                            	<td class="titulos">No</td>
                                <td class="titulos">Tipo</td>   
                                <td class="titulos">Documento</td>
                                <td class="titulos">Nombre</td>
                                <td class="titulos">Dias</td>
                                <td class="titulos">%</td>
                                <td class="titulos">Salario Basico</td>
                                <td class="titulos">Valor Dia</td>
                                <td class="titulos">Valor total</td>                             
								<td class="titulos" style="width:5%;">Paga SyP</td>
                                <td class="titulos" style="width:5%;">Paga ARL</td>
                                <td class="titulos" style="width:5%;">Paga Parafiscales</td>  
                          	</tr>
                             <?php
								if($_POST[idpreli]!="-1")
								{
									$iter="zebra1";
									$iter2="zebra2";
									$sqlr="SELECT mes,vigencia,salarifun,documefun,nombrefun FROM hum_prenomina_det WHERE codigo='$_POST[idpreli]' AND diasi > 0 ORDER BY id_det"; 
									$resp = mysql_query($sqlr,$linkbd);
									while ($row =mysql_fetch_row($resp)) 
									{
										$sqlr2="SELECT * FROM hum_incapacidades_det WHERE mes='$row[0]' AND vigencia='$row[1]' AND doc_funcionario= '$row[3]' AND estado='S'";
										$resp2 = mysql_query($sqlr2,$linkbd);
										while($row2 =mysql_fetch_row($resp2))
										{
											if($row2[10]=="S"){$imasem4="<img src='imagenes/sema_verdeON.jpg' title='Si Paga' style='width:20px'/>";}
											else{$imasem4="<img src='imagenes/sema_rojoON.jpg' title='No Paga' style='width:20px'/>";}
											if($row2[11]=="S"){$imasem5="<img src='imagenes/sema_verdeON.jpg' title='Si Paga' style='width:20px'/>";}
											else{$imasem5="<img src='imagenes/sema_rojoON.jpg' title='No Paga' style='width:20px'/>";}
											if($row2[12]=="S"){$imasem6="<img src='imagenes/sema_verdeON.jpg' title='Si Paga' style='width:20px'/>";}
											else{$imasem6="<img src='imagenes/sema_rojoON.jpg' title='No Paga' style='width:20px'/>";}
											echo"
											<tr class='$iter'>
												<td>$row2[2]</td>
												<td>$row2[3]</td>
												<td>$row[3]</td>
												<td>$row[4]</td>
												<td style='text-align:right;'>$row2[6]</td>
												<td style='text-align:right;'>$row2[7]%</td>
												<td style='text-align:right;'>$".number_format($row[2],0,',','.')."</td>
												<td style='text-align:right;'>$".number_format($row2[8],0,',','.')."</td>
												<td style='text-align:right;'>$".number_format($row2[9],0,',','.')."</td>
												<td style='text-align:center;'>$imasem4</td>
												<td style='text-align:center;'>$imasem5</td>
												<td style='text-align:center;'>$imasem6</td>
											</tr>";	
											$aux=$iter;
											$iter=$iter2;
											$iter2=$aux;
										}
									}
								}
							?>
                		</table>
       				</div>
 				</div>    
    			<div class="tab">
       				<input type="radio" id="tab-6" name="tabgroup1" value="6" <?php echo $check6;?> >
	   				<label for="tab-6">Descuentos</label>
	   				<div class="content" >
       					<table class="inicio">
       						<tr>
                            	<td class="titulos">No</td>
                                <td class="titulos">Fecha Registro</td>
                                <td class="titulos">Documento</td>
                                <td class="titulos">Nombre</td>
                                <td class="titulos">Descripcion</td>                                
                                <td class="titulos">Valor</td>
                                <td class="titulos">No Cuota</td>
                          	</tr>
                            <?php
								if($_POST[idpreli]!="-1")
								{
									$iter="zebra1";
									$iter2="zebra2";
									$con=1;
									$sqlr="SELECT mes,vigencia,salarifun,documefun,nombrefun FROM hum_prenomina_det WHERE codigo='$_POST[idpreli]' ORDER BY id_det"; 
									$resp = mysql_query($sqlr,$linkbd);
									while ($row =mysql_fetch_row($resp)) 
									{
										$sqlr2="SELECT * FROM humretenempleados WHERE empleado='$row[3]' AND estado='S' AND habilitado='H' AND sncuotas>0 ORDER BY fecha,descripcion";
	   									$resp2=mysql_query($sqlr2,$linkbd);
	   									while($row2=mysql_fetch_row($resp2))
										{
											 echo "<tr class='$iter'>
												<td>$con</td>
												<td>$row2[3]</td>
												<td>$row[3]</td>												
												<td>$row[4]</td>
												<td>$row2[1]</td>
												<td>$row2[8]</td>
												<td>".($row2[6]-$row2[7]+1)."</td>
												</tr>";
			 								$aux=$iter;
											$iter=$iter2;
											$iter2=$aux;
											$con++;
										}
									}
								}
							?>
                   		</table>
       				</div>
 				</div>      
			</div> 
            <input type="hidden" name="oculto" id="oculto" value="0"/>
            <?php 
				if($_POST[oculto]==2)
				{
					$_POST[idcomp]=selconsecutivo('humnomina','id_nom');
					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
					$fechaf="$fecha[3]-$fecha[2]-$fecha[1]";
					$sqlrcn="SELECT mes,vigencia FROM hum_prenomina WHERE codigo='$_POST[idpreli]' "; 
					$respcn = mysql_query($sqlrcn,$linkbd);
					$rowcn =mysql_fetch_row($respcn);
					$sqlr="insert into humnomina (id_nom,fecha, periodo,mes,diasp,mesnum,cc,vigencia,estado) values ('$_POST[idcomp]','$fechaf', '1','$rowcn[0]','0','1','00','$rowcn[1]','S')";
					if (!mysql_query($sqlr,$linkbd))
					{echo "<script>despliegamodalm('visible','2','Error, no se pudo almacenar la Nomina:');</script>";}
					else
					{
						$id=$_POST[idcomp];
						$idconec=selconsecutivo('hum_nom_cdp_rp','id');
						$sqlrco="insert into hum_nom_cdp_rp (id,nomina,cdp,rp,vigencia,estado) values ('$idconec','$id','0','0','$rowcn[1]', 'S')";
						mysql_query($sqlrco,$linkbd);
						$lastday = mktime (0,0,0,$rowcn[0],1,$rowcn[1]);
						echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado la Liquidacion de la Nomina $id - Centro Costo:$_POST[cc] - Mes: ".strtoupper(strftime('%B',$lastday))." <img src='imagenes\confirm.png'></center></td></tr></table>";
						$cex=0;
						$cerr=0;
						$sqlr="insert into humcomprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito, diferencia,estado) values ('$id','4','$fechaf','CAUSACION NOMINA MES ".strtoupper(strftime('%B',$lastday))."',0,0,0,0,'1')";
						mysql_query($sqlr,$linkbd);
						$eps="";
						$arp="";			
						$afp="";	
						$tipoafp="";
						$x=0;
						$sqlrpn="SELECT * FROM hum_prenomina_det WHERE codigo='$_POST[idpreli]' ORDER BY id_det"; 
						$resrpn = mysql_query($sqlrpn,$linkbd);
						while ($rowrpn =mysql_fetch_row($resrpn)) 
						{
							$eps=$rowrpn[9];
							$arp=$rowrpn[10];				 
							$afp=$rowrpn[11];
							if('PR'==$rowrpn[18]){$tipoafp="privado";}			 				 
							if('PB'==$rowrpn[18]){$tipoafp='publico';}	
							$sqlr="insert into humnomina_det (id_nom,cedulanit,salbas,diaslab,devendias,ibc,auxalim,auxtran,valhorex, totaldev,salud,saludemp,pension,pensionemp,fondosolid,retefte,otrasdeduc,totaldeduc,netopagar,estado,vac,diasarl,cajacf,sena,icbf,instecnicos,esap, tipofondopension,basepara,basearp,arp,totalsalud,totalpension) values ('$id','$rowrpn[7]','$listasalariobasico[$x]','$rowrpn[15]', '$listadevengados[$x]','$listaibc[$x]','$listaauxalimentacion[$x]','$listaauxtrasporte[$x]','0','$listatotaldevengados[$x]', '$listasaludempleado[$x]','$listasaludempresa[$x]','$listapensionempleado[$x]','$listapensionempresa[$x]','$listafondosolidaridad[$x]',0, '$listaotrasdeducciones[$x]','$listatotaldeducciones[$x]','$listanetoapagar[$x]','S','1','$listadiasincapacidad[$x]','$listaccf[$x]', '$listasena[$x]','$listaicbf[$x]','$listainstecnicos[$x]','$listaesap[$x]','$listatipofondopension[$x]','$listabaseparafiscales[$x]', '$listabasearp[$x]','$listaarp[$x]','$listasaludtotal[$x]','$listapensiontotal[$x]')";
							if (!mysql_query($sqlr,$linkbd)){$cerr+=1;}
							else
							{
								$cex+=1;	
								$ctacont='';
								$ctapres='';
								//*****SALARIO *******
								$sqlr="SELECT DISTINCT * FROM humvariables T1,humvariables_det T2 WHERE T1.codigo=T2.codigo AND T2.modulo=2 AND T1.codigo='$_POST[tsueldo]' AND T2.CC='$rowrpn[13]' AND T2.vigencia='$rowrpn[3]'";
								$resph=mysql_query($sqlr,$linkbd);
								while ($rowh =mysql_fetch_row($resph)) 
								{
									$ctacont=$rowh[11];	 
									$concepto=$rowh[7];	 
									$cuentas=concepto_cuentas($concepto,'H',2,$rowrpn[13]); 
									$tam=count($cuentas);
									for($cta=0;$cta<$tam;$cta++)
									{
										if($cuentas[$cta][1]=='N' && $cuentas[$cta][2]=='S'){$ctacont=$cuentas[$cta][0];}
										if($cuentas[$cta][1]=='N' && $cuentas[$cta][3]=='S'){$ctaconcepto=$cuentas[$cta][0];}
									}				
								}
							}
							$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('4 $id','$ctacont','$rowrpn[7]','$rowrpn[13]','Causacion Salario Mes ".strtoupper(strftime('%B',$lastday))."','','$listadevengados[$x]',0,'1','$rowrpn[3]')";
							mysql_query($sqlr,$linkbd);
							$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('4 $id','$ctaconcepto','$rowrpn[7]','$rowrpn[13]','Causacion Salario Mes ".strtoupper(strftime('%B',$lastday))."','',0,'$listadevengados[$x]','1','$rowrpn[3]')";
							mysql_query($sqlr,$linkbd);
							//************ FIN SALARIO ********
							//****** ALIMENTACION ****
							$ctacont='';
							$ctapres='';
							if($listaauxalimentacion[$x]>0)
							{
								$sqlr="SELECT DISTINCT * FROM humvariables T1,humvariables_det T2 WHERE T1.codigo=T2.codigo AND T2.modulo=2 AND T1.codigo='$_POST[tsubalim]' AND T2.CC='$rowrpn[13]' AND T2.vigencia='$rowrpn[3]'";
								$resph=mysql_query($sqlr,$linkbd);
								while ($rowh =mysql_fetch_row($resph)) 
								{
									$ctacont=$rowh[11];	 
									$concepto=$rowh[7];	 
									$cuentas=concepto_cuentas($concepto,'H',2,$rowrpn[13]); 
									$tam=count($cuentas);
									for($cta=0;$cta<$tam;$cta++)
									{
										if($cuentas[$cta][1]=='N' && $cuentas[$cta][2]=='S'){$ctacont=$cuentas[$cta][0];}
										if($cuentas[$cta][1]=='N' && $cuentas[$cta][3]=='S'){$ctaconcepto=$cuentas[$cta][0];}
									}				
									$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito, estado,vigencia) values ('4 $id','$ctacont','$rowrpn[7]','$rowrpn[13]','Causacion Aux Alimentacion Mes ".strtoupper(strftime('%B',$lastday))."','','$listaauxalimentacion[$x]',0,'1','$rowrpn[3]')";
									mysql_query($sqlr,$linkbd);
									$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito, estado,vigencia) values ('4 $id','$ctaconcepto','$rowrpn[7]','$rowrpn[13]','Causacion Aux Alimentacion Mes ".strtoupper(strftime('%B',$lastday))."','',0,'$listaauxalimentacion[$x]','1','$rowrpn[3]')";
									mysql_query($sqlr,$linkbd);   			
								}
							}		
							//*****FIN ALIMENTACION **********
							//******TRANSPORTE *****
							$ctacont='';
							$ctapres='';
							if($listaauxtrasporte[$x]>0)
							{
								$sqlr="SELECT DISTINCT * FROM humvariables T1,humvariables_det T2 WHERE T1.codigo=T2.codigo AND T2.modulo=2 AND T1.codigo='$_POST[tauxtrans]' AND T2.CC='$rowrpn[13]' AND T2.vigencia='$rowrpn[3]'";
								$resph=mysql_query($sqlr,$linkbd);
								while ($rowh =mysql_fetch_row($resph)) 
								{
									$ctacont=$rowh[11];	 
									$concepto=$rowh[7];	 												
									$cuentas=concepto_cuentas($concepto,'H',2,$rowrpn[13]); 
									$tam=count($cuentas);
									for($cta=0;$cta<$tam;$cta++)
									{
										if($cuentas[$cta][1]=='N' && $cuentas[$cta][2]=='S'){$ctacont=$cuentas[$cta][0];}
										if($cuentas[$cta][1]=='N' && $cuentas[$cta][3]=='S'){$ctaconcepto=$cuentas[$cta][0];}
									}				
									$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) values ('4 $id','$ctacont','$rowrpn[7]','$rowrpn[13]','Causacion Aux Transporte Mes ".strtoupper(strftime('%B',$lastday))."','','$listaauxtrasporte[$x]',0,'1','$rowrpn[3]')";
									mysql_query($sqlr,$linkbd);	
									$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito, valcredito,estado,vigencia) values ('4 $id','$ctaconcepto','$rowrpn[7]','$rowrpn[13]','Causacion Aux Transporte Mes ".strtoupper(strftime('%B',$lastday))."','',0,'$listaauxtrasporte[$x]','1','$rowrpn[3]')";
									mysql_query($sqlr,$linkbd);
								}
							}
							//****** FIN TRANSPORTE ****
							$sector=buscasector($rowrpn[7]);
							//********SALUD EMPLEADO *****
							$ctacont='';
							$ctapres='';
							$sqlrins="insert into  humnomina_saludpension (id_nom, tipo, empleado, tercero, cc, valor, estado,sector) values($id,'SE','$rowrpn[7]','$eps','$rowrpn[13]','$listasaludempleado[$x]','S','')";
							mysql_query($sqlrins,$linkbd);
							$sqlr="select distinct * from humparafiscales_det where  humparafiscales_det.codigo='$_POST[tsaludemp]' and humparafiscales_det.CC='$rowrpn[13]' and humparafiscales_det.vigencia='$rowrpn[3]'";
							$resph=mysql_query($sqlr,$linkbd);
							while ($rowh =mysql_fetch_row($resph)) 
							{
								$concepto=$rowh[8];	 	
								$cuentas=concepto_cuentas($concepto,'H',2,$rowrpn[13]); 
								$tam=count($cuentas);
								for($cta=0;$cta<$tam;$cta++)
								{
									$ctacont=$cuentas[$cta][0];
									if($cuentas[$cta][1]=='N' && $cuentas[$cta][2]=='S')
									{							
										$debito=$listasaludempleado[$x];
										$credito=0;
										$tercero=$rowrpn[7];
										$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) values ('4 $id','$ctacont','$tercero','$rowrpn[13]','APORTE SALUD EMPLEADO Mes ".strtoupper(strftime('%B',$lastday))."','','$debito','$credito','1','$rowrpn[3]')";
										mysql_query($sqlr,$linkbd);
										$ctasalud=$ctacont;
									}
									if($cuentas[$cta][1]=='N' && $cuentas[$cta][3]=='S')
									{			
										$credito=$listasaludempleado[$x];
										$debito=0;
										$tercero=$eps;
										$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) values ('4 $id','$ctacont','$tercero','$rowrpn[13]','APORTE SALUD EMPLEADO Mes ".strtoupper(strftime('%B',$lastday))."','','$debito','$credito','1','$rowrpn[3]')";
										mysql_query($sqlr,$linkbd);
										$ctasalud=$ctacont;				  
									}
								}
							}				
							//******** FIN SALUD EMPLEADO ****
							//********PENSION EMPLEADO *****
							$ctacont='';
							$ctapres='';
							$sqlrins="insert into  humnomina_saludpension (id_nom, tipo, empleado, tercero, cc, valor, estado,sector) values($id,'PE', '$rowrpn[7]','$afp','$rowrpn[13]','$listapensionempleado[$x]','S','$sector')";
							mysql_query($sqlrins,$linkbd);		
							$sqlr="select distinct *from humparafiscales_det where  humparafiscales_det.codigo='$_POST[tpensionemp]' and humparafiscales_det.CC='$rowrpn[13]' and humparafiscales_det.vigencia='$rowrpn[3]'";
							$resph=mysql_query($sqlr,$linkbd);
							while ($rowh =mysql_fetch_row($resph)) 
							{
								$concepto=$rowh[8];	 		
								$cuentas=concepto_cuentas($concepto,'H',2,$rowrpn[13]); 
								$tam=count($cuentas);
								for($cta=0;$cta<$tam;$cta++)
								{
									$ctacont=$cuentas[$cta][0];
									if($cuentas[$cta][1]=='N' && $cuentas[$cta][2]=='S')
									{							
										$debito=$listapensionempleado[$x];
										$credito=0;
										$tercero=$rowrpn[7];
										$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) values ('4 $id','$ctacont','$tercero','$rowrpn[13]','APORTE PENSION EMPLEADO Mes ".strtoupper(strftime('%B',$lastday))."','','$debito','$credito','1','$rowrpn[3]')";
										mysql_query($sqlr,$linkbd);
										$ctasalud=$ctacont;
									}
									if($cuentas[$cta][1]=='N' && $cuentas[$cta][3]=='S')
									{			
										$credito=$listapensionempleado[$x];
										$debito=0;
										$tercero=$afp;
										$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) values ('4 $id','$ctacont','$tercero','$rowrpn[13]','APORTE PENSION EMPLEADO Mes ".strtoupper(strftime('%B',$lastday))."','','$debito','$credito','1','$rowrpn[3]')";
										mysql_query($sqlr,$linkbd);
										$ctasalud=$ctacont;				  
									}
								}				
							}
							//******** FIN PENSION EMPLEADO ****	
							//********FONDO SOLIDARIDAD EMPLEADO *****
							$ctacont='';
							$ctapres='';
							if($listafondosolidaridad[$x]>0)
							{
								$sqlrins="insert into  humnomina_saludpension (id_nom, tipo, empleado, tercero, cc, valor, estado,sector) values($id,'FS','$rowrpn[7]','$afp','$rowrpn[13]','$listafondosolidaridad[$x]','S','$sector')";
								mysql_query($sqlrins,$linkbd);
								$sqlr="select distinct *from humparafiscales_det where  humparafiscales_det.codigo='$_POST[tpensionemp]' and humparafiscales_det.CC='$rowrpn[13]' and humparafiscales_det.vigencia='$rowrpn[3]' and  humparafiscales_det.sector='$tipoafp'";
								$resph=mysql_query($sqlr,$linkbd);
								while ($rowh =mysql_fetch_row($resph)) 
								{
									$concepto=$rowh[8];	 		
									$cuentas=concepto_cuentas($concepto,'H',2,$rowrpn[13]); 
									$tam=count($cuentas);
									for($cta=0;$cta<$tam;$cta++)
									{
										$ctacont=$cuentas[$cta][0];
										if($cuentas[$cta][1]=='N' && $cuentas[$cta][2]=='S')
										{									
											$debito=$listafondosolidaridad[$x];
											$credito=0;
											$tercero=$rowrpn[7];
											$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) values ('4 $id','$ctacont','$tercero','$rowrpn[13]','APORTE FONDO SOLIDARIDAD EMPLEADO Mes ".strtoupper(strftime('%B',$lastday))."','','$debito','$credito','1','$rowrpn[3]')";
											mysql_query($sqlr,$linkbd);
											$ctasalud=$ctacont;
										}
										if($cuentas[$cta][1]=='N' && $cuentas[$cta][3]=='S')
										{			
											$credito=$listafondosolidaridad[$x];
											$debito=0;
											$tercero=$afp;
											$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) values ('4 $id','$ctacont','$tercero','$rowrpn[13]','APORTE FONDO SOLIDARIDAD EMPLEADO Mes ".strtoupper(strftime('%B',$lastday))."','','$debito','$credito','1','$rowrpn[3]')";
											mysql_query($sqlr,$linkbd);
											$ctasalud=$ctacont;				  
										}
									}
								}
							}
							//******** FIN FONDO SOLIDARIDAD EMPLEADO ****	
							//********OTROS DESCUENTOS EMPLEADO *****
							$ctacont='';
							$ctapres='';
							if($listaotrasdeducciones[$x]>0)
							{
								$sqlr="select *from humretenempleados where humretenempleados.empleado='$rowrpn[7]' and humretenempleados.sncuotas>0 and habilitado='H' and estado='S'";		
								$respli=mysql_query($sqlr,$linkbd);
								while ($rowh=mysql_fetch_row($respli)) 
								{
									$valorlibranza=$rowh[8];
									$sqlr="select distinct *from humvariablesretenciones,humvariablesretenciones_det where humvariablesretenciones.codigo='".$rowh[2]."' and humvariablesretenciones.codigo=humvariablesretenciones_det.codigo";
									$respr=mysql_query($sqlr,$linkbd);
									while ($rowr=mysql_fetch_row($respr)) 
									{						
										$ctacont=$rowr[8];	 
										if('S'==$rowr[9])
										{
											$debito=$valorlibranza;
											$credito=0;
											$sqlret="INSERT INTO  humnominaretenemp (id_nom, id, cedulanit, fecha, descripcion, valor, ncta, estado) values($id,$rowh[0],'$rowh[4]','$fechaf','$rowh[1]',$debito,".($rowh[6]-$rowh[7]+1).",'S')";
											mysql_query($sqlret,$linkbd);
										}
										if('S'==$rowr[10])
										{
											$credito=$valorlibranza;
											$debito=0;
										}				 				 
										$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) values ('4 $id','$ctacont','$rowr[2]','$rowrpn[13]','DESCUENTO $rowr[1] Mes ".strtoupper(strftime('%B',$lastday))."','','$debito','$credito','1','$rowrpn[3]')";
										mysql_query($sqlr,$linkbd);
									}
								}
							}				
							//******** FIN otros descuentos EMPLEADO ****
							//******** SALUD EMPLEADOR *******
							$ctacont='';
							$ctapres='';	
							$sqlrins="insert into  humnomina_saludpension (id_nom, tipo, empleado, tercero, cc, valor, estado) values($id,'SR', '$rowrpn[7]','$eps','$rowrpn[13]','$listasaludempresa[$x]','S')";
							mysql_query($sqlrins,$linkbd);
							$sqlr="select distinct *from humparafiscales_det where  humparafiscales_det.codigo='$_POST[tsaludemr]' and humparafiscales_det.CC='$rowrpn[13]' and humparafiscales_det.vigencia='$rowrpn[3]' ";
							$resph=mysql_query($sqlr,$linkbd);
							while ($rowh =mysql_fetch_row($resph)) 
							{
								$concepto=$rowh[8];	 	
								$cuentas=concepto_cuentas($concepto,'H',2,$rowrpn[13]); 
								$tam=count($cuentas);
								for($cta=0;$cta<$tam;$cta++)
								{
									$ctacont=$cuentas[$cta][0];
									if($cuentas[$cta][1]=='N' && $cuentas[$cta][2]=='S')
									{									
										$debito=$listasaludempresa[$x];
										$credito=0;
										$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito, estado,vigencia) values ('4 $id','$ctacont','$eps','$rowrpn[13]','APORTE SALUD EMPLEADOR Mes ".strtoupper(strftime('%B',$lastday))."','','$debito', '$credito','1','$rowrpn[3]')";
										mysql_query($sqlr,$linkbd);
									}							 				 
									if($cuentas[$cta][1]=='N' && $cuentas[$cta][3]=='S')
									{
										$credito=$listasaludempresa[$x];
										$debito=0;
										$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito, estado,vigencia) values ('4 $id','$ctacont','$eps','$rowrpn[13]','APORTE SALUD EMPLEADOR Mes ".strtoupper(strftime('%B',$lastday))."','','$debito', '$credito','1','$rowrpn[3]')";
										mysql_query($sqlr,$linkbd);									
									}	 		  
								}
							}
							//**************FIN SALUD EMPLEADOR		
							//******** PENSIONES EMPLEADOR *******
							$ctacont='';
							$ctapres='';		
							$sqlrins="insert into  humnomina_saludpension (id_nom,tipo,empleado,tercero,cc,valor,estado,sector) values($id,'PR', '$rowrpn[7]','$afp','$rowrpn[13]','$listapensionempresa[$x]','S','$sector')";
							mysql_query($sqlrins,$linkbd);
							$sqlr="select distinct *from humparafiscales_det where  humparafiscales_det.codigo='$_POST[tpensionemr]' and humparafiscales_det.CC='$rowrpn[13]' and humparafiscales_det.vigencia='$rowrpn[3]'  and sector='$tipoafp'  and  humparafiscales_det.sector='$tipoafp'";
							$resph=mysql_query($sqlr,$linkbd);
							while ($rowh =mysql_fetch_row($resph)) 
							{
								$concepto=$rowh[8];	
								$cuentas=concepto_cuentas($concepto,'H',2,$rowrpn[13]); 
								$tam=count($cuentas);
								for($cta=0;$cta<$tam;$cta++)
								{
									$ctacont=$cuentas[$cta][0];
									if($cuentas[$cta][1]=='N' && $cuentas[$cta][2]=='S')
									{				
										$debito=$listapensionempresa[$x];
										$credito=0;				  	 
										$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) values ('4 $id','$ctacont','$afp','$rowrpn[13]','APORTE PENSIONES EMPLEADOR Mes ".strtoupper(strftime('%B',$lastday))."','','$debito','$credito','1','$rowrpn[3]')";
										mysql_query($sqlr,$linkbd);
									}				
									if($cuentas[$cta][1]=='N' && $cuentas[$cta][3]=='S')
									{			 				 
										$credito=$listapensionempresa[$x];
										$debito=0;
										$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito, estado,vigencia) values ('4 $id','$ctacont','$afp','$rowrpn[13]','APORTE PENSIONES EMPLEADOR Mes ".strtoupper(strftime('%B',$lastday))."','', '$debito','$credito','1','$rowrpn[3]')";
										mysql_query($sqlr,$linkbd);	
									}
								}
							}
							//**************FIN PENSION EMPLEADOR	
							//******ARP ******			 
							$ctacont='';
							$ctapres='';		
							$sqlr="select distinct *from humparafiscales_det inner join humparafiscales on humparafiscales_det.codigo=humparafiscales.codigo  where  humparafiscales_det.codigo='$_POST[tarp]' and humparafiscales_det.CC='$rowrpn[13]' and humparafiscales_det.vigencia='$rowrpn[3]'";
							$resph=mysql_query($sqlr,$linkbd);		
							while ($rowh =mysql_fetch_row($resph)) 
							{								 				  
								$concepto=$rowh[8];	
								$cuentas=concepto_cuentas($concepto,'H',2,$rowrpn[13]); 
								$tam=count($cuentas);
								for($cta=0;$cta<$tam;$cta++)
								{
									$ctacont=$cuentas[$cta][0];
									if($cuentas[$cta][1]=='N' && $cuentas[$cta][2]=='S')
									{			
										$debito=$listaarp[$x];
										$credito=0;				  	  							 				 
										$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito, estado,vigencia) values ('4 $id','$ctacont.','$arp','$rowrpn[13]','APORTE ARP EMPLEADOR Mes ".strtoupper(strftime('%B',$lastday))."','','$debito','$credito','1','$rowrpn[3]')";
										mysql_query($sqlr,$linkbd);
									}	
									if($cuentas[$cta][1]=='N' && $cuentas[$cta][3]=='S')
									{
										$credito=$listaarp[$x];
										$debito=0;
										$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito, estado,vigencia) values ('4 $id','$ctacont','$arp','$rowrpn[13]','APORTE ARP EMPLEADOR Mes ".strtoupper(strftime('%B',$lastday))."','','$debito', '$credito','1','$rowrpn[3]')";
										mysql_query($sqlr,$linkbd);		
									}
								}
							}
							//***** FIN ARP *****
							$x++;					
						}//
						//***********PARAFISCALES ******
						//CAJAS DE COMPENSACION
						$sqlr="select * from centrocosto where estado='S'";
						$rescc=mysql_query($sqlr,$linkbd);
						while ($rowcc =mysql_fetch_row($rescc)) 
						{
							if($pf[$_POST[tcajacomp]][$rowcc[0]]>0)
		   					{
								$sqlr="select distinct *from humparafiscales_det  inner join humparafiscales on humparafiscales_det.codigo=humparafiscales.codigo where  humparafiscales_det.codigo='$_POST[tcajacomp]' and humparafiscales_det.CC='$rowcc[0]' and humparafiscales_det.vigencia='$_POST[vigencia]'";
								$resph=mysql_query($sqlr,$linkbd);		
								while ($rowh =mysql_fetch_row($resph)) 
								{
									$concepto=$rowh[8];	
									$cuentas=concepto_cuentas($concepto,'H',2,$rowcc[0]); 
									$tam=count($cuentas);
									for($cta=0;$cta<$tam;$cta++)
									{
										$ctacont=$cuentas[$cta][0];
										if($cuentas[$cta][1]=='N' && $cuentas[$cta][2]=='S')
										{			
											$debito=$pf[$_POST[tcajacomp]][$rowcc[0]];
											$credito=0;				  	 							 				 
											$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('4 $id','$ctacont','$_POST[cajacomp]','$rowcc[0]','APORTE CAJA COMPENSACION Mes ".strtoupper(strftime('%B',$lastday))."','','$debito','$credito','1','$_POST[vigencia]')";
											mysql_query($sqlr,$linkbd);
										}
										if($cuentas[$cta][1]=='N' && $cuentas[$cta][3]=='S')
										{
											$credito=$pf[$_POST[tcajacomp]][$rowcc[0]];
											$debito=0;				  	 							 				 
											$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('4 $id','$ctacont','$_POST[cajacomp]','$rowcc[0]','APORTE CAJA COMPENSACION Mes ".strtoupper(strftime('%B',$lastday))."','','$debito','$credito','1','$_POST[vigencia]')";
											mysql_query($sqlr,$linkbd);	
										}						
									}
									//***nomina parafiscales
									$sqlr="insert into humnomina_parafiscales (id_nom,id_parafiscal,porcentaje,valor,cc,estado) values ($id,'$_POST[tcajacomp]',$rowh[14],".$pf[$_POST[tcajacomp]][$rowcc[0]].",'$rowcc[0]','S')";			
									mysql_query($sqlr,$linkbd);											
				   				}
							}
						}
						//*************FIN CAJAS DE COMP
			 			//ICBF
		 				$sqlr="select *from centrocosto where estado='S'";
	 					$rescc=mysql_query($sqlr,$linkbd);
	 					while ($rowcc =mysql_fetch_row($rescc)) 
	 					{
							$ctacont='';
							$ctapres='';		
		  					if($pf[$_POST[ticbf]][$rowcc[0]]>0)
		   					{			
								$sqlr="select distinct *from humparafiscales_det  inner join humparafiscales on humparafiscales_det.codigo=humparafiscales.codigo where  humparafiscales_det.codigo='$_POST[ticbf]' and humparafiscales_det.CC='$rowcc[0]' and humparafiscales_det.vigencia='$_POST[vigencia]'";
								$resph=mysql_query($sqlr,$linkbd);		
								while ($rowh =mysql_fetch_row($resph)) 
								{							 
				   					$concepto=$rowh[8];	
   				   					$cuentas=concepto_cuentas($concepto,'H',2,$rowcc[0]); 
									$tam=count($cuentas);
									for($cta=0;$cta<$tam;$cta++)
									{
					 					$ctacont=$cuentas[$cta][0];
				 	 					if($cuentas[$cta][1]=='N' && $cuentas[$cta][2]=='S')
					  					{			
											$debito=$pf[$_POST[ticbf]][$rowcc[0]];
											$credito=0;				  	 						 				 
											$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('4 $id','$ctacont','$_POST[icbf]','$rowcc[0]','APORTE ICBF Mes ".strtoupper(strftime('%B',$lastday))."','','$debito','$credito','1','$_POST[vigencia]')";
											mysql_query($sqlr,$linkbd);
										}
					 					if($cuentas[$cta][1]=='N' && $cuentas[$cta][3]=='S')
					  					{
											$debito=$pf[$_POST[ticbf]][$rowcc[0]];
											$credito=0;				  	 						 				 
											$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('4 $id','$ctacont','$_POST[icbf]','$rowcc[0]','APORTE ICBF Mes ".strtoupper(strftime('%B',$lastday))."','',0,'$debito','1','$_POST[vigencia]')";
											mysql_query($sqlr,$linkbd);	
					 					}
									}
									//***nomina parafiscales
									$sqlr="insert into humnomina_parafiscales (id_nom, id_parafiscal, porcentaje, valor, cc,estado) values ($id,'$_POST[ticbf]',$rowh[14],".$pf[$_POST[ticbf]][$rowcc[0]].",'$rowcc[0]','S')";			
									mysql_query($sqlr,$linkbd);															   
								}		  
		  	 				}
	 					}
						//*************FIN ICBF
 						//SENA
						$sqlr="select *from centrocosto where estado='S'";
	 					$rescc=mysql_query($sqlr,$linkbd);
						//echo "<br>$sqlr";
	 					while ($rowcc =mysql_fetch_row($rescc)) 
	 					{
							$ctacont='';
							$ctapres='';		
		  					if($pf[$_POST[tsena]][$rowcc[0]]>0)
		   					{			
								$sqlr="select distinct *from humparafiscales_det inner join humparafiscales on humparafiscales_det.codigo=humparafiscales.codigo where  humparafiscales_det.codigo='$_POST[tsena]' and humparafiscales_det.CC='$rowcc[0]' and humparafiscales_det.vigencia='$_POST[vigencia]'";
								$resph=mysql_query($sqlr,$linkbd);		
								while ($rowh =mysql_fetch_row($resph)) 
								{
				   					$concepto=$rowh[8];	
				  					$cuentas=concepto_cuentas($concepto,'H',2,$rowcc[0]); 
									$tam=count($cuentas);
									for($cta=0;$cta<$tam;$cta++)
									{
					 					$ctacont=$cuentas[$cta][0];
				 	 					if($cuentas[$cta][1]=='N' && $cuentas[$cta][2]=='S')
					  					{		
											$debito=$pf[$_POST[tsena]][$rowcc[0]];
											$credito=0;
											$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('4 $id','$ctacont','$_POST[sena]','$rowcc[0]','APORTE SENA Mes ".strtoupper(strftime('%B',$lastday))."','', '$debito',0,'1','$_POST[vigencia]')";
											mysql_query($sqlr,$linkbd);
					  					}
  					 					if($cuentas[$cta][1]=='N' && $cuentas[$cta][3]=='S')
					  					{
											$debito=$pf[$_POST[tsena]][$rowcc[0]];
											$credito=0;
											$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('4 $id','$ctacont','$_POST[sena]','$rowcc[0]', 'APORTE SENA Mes ".strtoupper(strftime('%B',$lastday))."','',0,'$debito','1','$_POST[vigencia]')";
											mysql_query($sqlr,$linkbd);		
					  					}
				   					}
									//***nomina parafiscales
									$sqlr="insert into humnomina_parafiscales (id_nom, id_parafiscal, porcentaje, valor, cc, estado) values ($id,'$_POST[tsena]',$rowh[14],$debito,'$rowcc[0]', 'S')";			
									mysql_query($sqlr,$linkbd);																
								}
		   					}
	 					}
						//*************FIN SENA	
						//ITI
						$sqlr="select *from centrocosto where estado='S'";
	 					$rescc=mysql_query($sqlr,$linkbd);
	 					while ($rowcc =mysql_fetch_row($rescc)) 
	 					{
							$ctacont='';
							$ctapres='';		
		  					if($pf[$_POST[titi]][$rowcc[0]]>0)
		   					{			
								$sqlr="select distinct *from humparafiscales_det inner join humparafiscales on humparafiscales_det.codigo=humparafiscales.codigo where  humparafiscales_det.codigo='$_POST[titi]' and humparafiscales_det.CC='$rowcc[0]' and humparafiscales_det.vigencia='$_POST[vigencia]'";
								$resph=mysql_query($sqlr,$linkbd);		
								while ($rowh =mysql_fetch_row($resph)) 
								{
				   					$concepto=$rowh[8];	
   				    				$cuentas=concepto_cuentas($concepto,'H',2,$rowcc[0]); 
									$tam=count($cuentas);
									for($cta=0;$cta<$tam;$cta++)
									{
					 					$ctacont=$cuentas[$cta][0];
				 	 					if($cuentas[$cta][1]=='N' && $cuentas[$cta][2]=='S')
					  					{	
											$debito=$pf[$_POST[titi]][$rowcc[0]];
											$credito=0;
											$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('4 $id','$ctacont','$_POST[iti]','$rowcc[0]','APORTE INST TECNICOS Mes ".strtoupper(strftime('%B',$lastday))."','','$debito',0,'1','$_POST[vigencia]')";
											mysql_query($sqlr,$linkbd);
					  					}
										if($cuentas[$cta][1]=='N' && $cuentas[$cta][3]=='S')
					  					{
											$debito=$pf[$_POST[titi]][$rowcc[0]];
											$credito=0;						  
											$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('4 $id','$ctacont','$_POST[iti]','$rowcc[0]','APORTE INST TECNICOS Mes ".strtoupper(strftime('%B',$lastday))."','',0,'$debito','1','$_POST[vigencia]')";
											mysql_query($sqlr,$linkbd);											
					   					}
									}
		   							//***nomina parafiscales
									$sqlr="insert into humnomina_parafiscales (id_nom, id_parafiscal, porcentaje, valor, cc, estado) values ('$id','$_POST[titi]','$rowh[14]','$debito','$rowcc[0]', 'S')";			
									mysql_query($sqlr,$linkbd);										
								}
		   					}
	 					}
						//*************FIN ITI		
						//ESAP********
	 					$sqlr="select *from centrocosto where estado='S'";
	 					$rescc=mysql_query($sqlr,$linkbd);
					 	while ($rowcc =mysql_fetch_row($rescc)) 
	 					{
							$ctacont='';
							$ctapres='';
		 					if($pf[$_POST[tesap]][$rowcc[0]]>0)
		   					{			
								$sqlr="select distinct *from humparafiscales_det inner join humparafiscales on humparafiscales_det.codigo=humparafiscales.codigo where  humparafiscales_det.codigo='$_POST[tesap]' and humparafiscales_det.CC='$rowcc[0]' and humparafiscales_det.vigencia='$_POST[vigencia]'";
								$resph=mysql_query($sqlr,$linkbd);		
								while ($rowh =mysql_fetch_row($resph)) 
								{
				   					$concepto=$rowh[8];	
				   					$cuentas=concepto_cuentas($concepto,'H',2,$rowcc[0]); 
									$tam=count($cuentas);
									for($cta=0;$cta<$tam;$cta++)
									{
					 					$ctacont=$cuentas[$cta][0];
				 	 					if($cuentas[$cta][1]=='N' && $cuentas[$cta][2]=='S')
					  					{	
											$debito=$pf[$_POST[tesap]][$rowcc[0]];
											$credito=0;
											$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('4 $id','$ctacont','$_POST[esap]','$rowcc[0]','APORTE ESAP Mes ".strtoupper(strftime('%B',$lastday))."','','$debito',0,'1','$_POST[vigencia]')";
											mysql_query($sqlr,$linkbd);
					  					}
  					 					if($cuentas[$cta][1]=='N' && $cuentas[$cta][3]=='S')
					  					{
											$debito=$pf[$_POST[tesap]][$rowcc[0]];
											$credito=0;
											$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('4 $id','$ctacont','$_POST[esap]','$rowcc[0]','APORTE ESAP Mes ".strtoupper(strftime('%B',$lastday))."','',0,'$debito','1','$_POST[vigencia]')";
											mysql_query($sqlr,$linkbd);	
											//***nomina parafiscales
					  					}						
				   					}
				   					$sqlr="insert into humnomina_parafiscales (id_nom,id_parafiscal,porcentaje,valor,cc,estado) values ($id,'$_POST[tesap]',$rowh[14],$debito,'$rowcc[0]','S')";			
									mysql_query($sqlr,$linkbd);								
								}
		   					}
	 					}
						//*************FIN ESAP	
						//ARP********
						$sqlr="select *from centrocosto where estado='S'";
	 					$rescc=mysql_query($sqlr,$linkbd);
	 					while ($rowcc =mysql_fetch_row($rescc)) 
						{
							$ctacont='';
							$ctapres='';
		  					if($pf[$_POST[tarp]][$rowcc[0]]>0)
		   					{			
								$sqlr="select distinct *from humparafiscales_det inner join humparafiscales on humparafiscales_det.codigo=humparafiscales.codigo where  humparafiscales_det.codigo='$_POST[tarp]' and humparafiscales_det.CC='$rowcc[0]' and humparafiscales_det.vigencia='$_POST[vigencia]'";
								$resph=mysql_query($sqlr,$linkbd);		
								while ($rowh =mysql_fetch_row($resph)) 
								{
									if($rowcc[0]==$rowh[2])
				 					{				 
				   						$ctacont=$rowh[3];	 
				   						$ctapres=$rowh[6];					    
										$debito=$pf[$_POST[tarp]][$rowcc[0]];
										$credito=0;
										//***nomina parafiscales
										$sqlr="insert into humnomina_parafiscales (id_nom, id_parafiscal, porcentaje, valor, cc,estado) values ($id,'$_POST[tarp]',$rowh[14],$debito,'$rowcc[0]','S')";			
										mysql_query($sqlr,$linkbd);													
				   					}
								}
		  					}
						}
						//*************FIN arp	
						echo"<script>despliegamodalm('visible','3','Registros Exitosos:$cex   -   Registros Erroneos: $cerr');</script>";
						//***** crea la solicitud de cdp *************
						foreach($pfcp as $k => $valrubros)
		 				{
  							$ncta=existecuentain($k);
							$sqlrp="insert into humnom_presupuestal (id_nom,cuenta,valor,estado) values ($id,$k,$valrubros,'S')";
  							//mysql_query($sqlrp,$linkbd);	
						 }	
						for($rb=0;$rb<count($_POST[rubrosp]);$rb++)
		 				{
							$valrubros=$_POST[vrubrosp][$rb];
							$sqlrp="insert into humnom_presupuestal (id_nom,cuenta,valor,estado) values ($id,'".$_POST[rubrosp][$rb]."',$valrubros,'S')";
  							mysql_query($sqlrp,$linkbd);	
		 				}	
						echo "<script>funcionmensaje();</script>";	 	
					}
				}//fin guardar
			?>
		</form>
	</body>
</html>