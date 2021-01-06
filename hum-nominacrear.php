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
			function funcionmensaje()
			{
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
			function guardar()
			{
				if (document.form2.idpreli.value!='-1')
				{
					if (document.form2.ttippen.value!='N'){despliegamodalm('visible','4','Esta Seguro de Guardar','1')}
					else {despliegamodalm('visible','2','Error con los tipos de pension');}
				}
  				else{despliegamodalm('visible','2','Faltan datos para completar el registro');}
			}
		</script>
		<?php 
			titlepag();
			function buscavalorotrospagos($prenom,$tipo,$codfunc)
			{
				$linkbd=conectar_bd();
				$sqlr="SELECT valpago FROM hum_otrospagos WHERE codpre='$prenom' AND codpag='$tipo' AND codigofun='$codfunc'";
				$res=mysql_query($sqlr,$linkbd);
				$r=mysql_fetch_row($res);
				return $r[0];
			}
			function totalvalorotrospagossinaux($prenom,$codfunc)
			{
				$linkbd=conectar_bd();	
				$sqlr="SELECT SUM(valpago) FROM hum_otrospagos WHERE codpre='$prenom' AND (codpag<>'01' AND codpag<>'07' AND codpag<>'08') AND codigofun='$codfunc'";
				$res=mysql_query($sqlr,$linkbd);
				$r=mysql_fetch_row($res);
				return $r[0];
			}
			function calcularibc($prenom,$codfunc,$tipo)
			{
				switch ($tipo)
				{
					case '01':	$condi="peps='S'";break;
					case '02':	$condi="ppen='S'";break;
					case '03':	$condi="parl='S'";break;
					case '04':	$condi="ppar='S'";break;
				}
				$linkbd=conectar_bd();
				$sqlr="SELECT SUM(valpago) FROM hum_otrospagos WHERE codpre='$prenom' AND codigofun='$codfunc' AND $condi";
				$res=mysql_query($sqlr,$linkbd);
				$r=mysql_fetch_row($res);
				//return $r[0];
				return 0;
			}
			function aplicaredondeo($valor,$resino,$renivel,$retipo)
			{
				$ndecimal= -1*substr_count($retipo, '0');
				if($resino==1)
				{
					if($renivel==0){$revalor=ceil($valor/$retipo)*$retipo;}
					else{$revalor=round($valor, $ndecimal);}
				}
				else{$revalor=$valor;}
				return $revalor;
			}
			function traercuentapresu($tipo,$cc,$vigencia,$sector)
			{
				$linkbd=conectar_bd();
				if($sector!='')
				{
					if($sector=='PR'){$tpf='privado';}
					else {$tpf='publico';}
					$adic="AND sector='$tpf'";
				}
				else{$adic="";}
				$sqlr="SELECT cuentapres FROM humparafiscales_det WHERE codigo='$tipo' AND cc='$cc' AND estado='S' AND vigencia='$vigencia' $adic";
				$res= mysql_query($sqlr,$linkbd);
				$r=mysql_fetch_row($res);
				return $r[0];
			}
			function traercuentapresu2($tipo,$cc,$vigencia)
			{
				$linkbd=conectar_bd();
				$sqlr="SELECT cuentapres FROM humvariables_det WHERE codigo='$tipo' AND cc='$cc' AND estado='S' AND vigencia='$vigencia'";
				$res= mysql_query($sqlr,$linkbd);
				$r=mysql_fetch_row($res);
				return $r[0];
			}
			function porcentajearl($codfun)
			{
				$linkbd=conectar_bd();
				$sqlrfun="
				SELECT  GROUP_CONCAT(descripcion ORDER BY CONVERT(codrad, SIGNED INTEGER) SEPARATOR '<->')
				FROM hum_funcionarios 
				WHERE (item = 'NIVELARL') AND estado='S'  AND codfun='$codfun'
				GROUP BY codfun
				ORDER BY CONVERT(codfun, SIGNED INTEGER)";
				$respfun = mysql_query($sqlrfun,$linkbd);
				$rowfun =mysql_fetch_row($respfun);
				$sqlr="SELECT tarifa FROM hum_nivelesarl WHERE id='$rowfun[0]'";
				$res = mysql_query($sqlr,$linkbd);
				$r =mysql_fetch_row($res);
				return $r[0];
			}
			function buscavariablepagov($codigo,$cc,$vigencia)
			{
				$linkbd=conectar_bd();
				$sqlr="SELECT cuentapres FROM humvariables_det WHERE codigo='$codigo' AND cc='$cc' AND vigencia=$vigencia AND estado='S'";
				$res=mysql_query($sqlr,$linkbd);
				$r=mysql_fetch_row($res);
				return $r[0];
			}
			function presservsocial($codfun, $tipo)
			{
				$linkbd=conectar_bd();
				switch ($tipo)
				{
					case '1': 	$nf='NUMEPS';break;
					case '2':	$nf='NUMAFP';break;
					case '3':	$nf='NUMARL';break;
					case '4':	$nf='NUMFDC';break;
				}
				$sqlr="
				SELECT  GROUP_CONCAT(descripcion ORDER BY CONVERT(codrad, SIGNED INTEGER) SEPARATOR '<->')
				FROM hum_funcionarios 
				WHERE (item = '$nf') AND estado='S'  AND codfun='$codfun'
				GROUP BY codfun
				ORDER BY CONVERT(codfun, SIGNED INTEGER)";
				$res = mysql_query($sqlr,$linkbd);
				$r =mysql_fetch_row($res);
				return $r[0];
			}
		?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
            <tr><script>barra_imagenes("hum");</script><?php cuadro_titulos();?></tr>
            <tr><?php menu_desplegable("hum");?></tr>
            <tr>
                <td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='hum-nominacrear.php'" class="mgbt"/><img src="imagenes/guarda.png" title="Guardar" onClick="guardar()" class="mgbt"/><img class="mgbt" src="imagenes/busca.png" title="Buscar" onClick="location.href='hum-liquidarnominabuscar.php'"/><img class="mgbt" src="imagenes/nv.png" title="Nueva Ventana" onClick="mypop=window.open('hum-principal.php','','');mypop.focus();"/><img src='imagenes/iratras.png' title='Men&uacute; Nomina' class='mgbt' onClick="location.href='hum-menunomina.php'"/></td>
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
					$_POST[valtipos]="0";
					$_POST[tipo02]="";
					//**** carga parametros de nomina
					$sqlr="SELECT * FROM humparametrosliquida";	
		 			$resp = mysql_query($sqlr,$linkbd);
					$row =mysql_fetch_row($resp);
					$_POST[aprueba]=$row[1];
					$_POST[naprueba]=buscatercero($row[1]);
					$_POST[tsueldo]=$row[2];
					$_POST[tprimnav]=$row[3];
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
					$_POST[bfsol]=$row[6];
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
					$_POST[tipoincapasidad]=$row[14];
				}
				$listatipomov=array();
				$listatipopago=array();
				$listatcodigofuncionario=array();
				$listacentrocosto=array();
				$listatipopension=array();
				$listaempleados=array();
				$listadocumentos=array();
				$listasalariobasico=array();
				$listadiasliquidados=array();
				$listadevengados=array();
				$listaauxalimentacion=array();
				$listaauxtrasporte=array();
				$listaotrospagos=array();
				$listatotaldevengados=array();
				$listaibc=array();
				$listaibceps=array();
				$listaibcfdp=array();
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
				$listaretenciones=array();
				$listaotrasdeducciones=array();
				$listatotaldeducciones=array();
				$listanetoapagar=array();
				$listaccf=array();
				$listasena=array();
				$listaicbf=array();
				$listainstecnicos=array();
				$listaesap=array();
				$listadoceps=array();
				$listadocarl=array();
				$listadocafp=array();
				$listadocfdc=array();
				$listaretiro=array();
				$pfcp=array();
				$pf[]=array();
				switch($_POST[tabgroup1])
				{
					case 1:	$check1='checked';break;
					case 2:	$check2='checked';break;
					case 3:	$check3='checked';break;
					case 4:	$check4='checked';break;
					case 5:	$check5='checked';break;
					case 6:	$check6='checked';break;
					case 7:	$check6='checked';break;
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
                    <td style="width:10%"><input type="text" name="vigencia" id="vigencia" value="<?php echo $_POST[vigencia]?>" style="width:98%" readonly></td>
                    <td class="saludo1" style="width:3cm;">No Preliquidaci&oacute;n:</td> 
	    			<td>
                    	<select name="idpreli" id="idpreli" onChange="document.form2.submit();">
							<option value="-1">Sel ...</option>
                            <?php
                          		$sqlr="SELECT codigo,mes,vigencia FROM hum_prenomina T1 WHERE estado='S' AND num_liq='0'";
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
			<input type="hidden" id="tprimnav" name="tprimnav" value="<?php echo $_POST[tprimnav];?>"/>
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
            <input type="hidden" id="mesnomina" name="mesnomina" value="<?php echo $_POST[mesnomina];?>"/>
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
			<input type="hidden" id="tipoincapasidad" name="tipoincapasidad" value="<?php echo $_POST[tipoincapasidad];?>"/>
			<!-- Variables tipos procesos adicionales --> 
			<?php
				if($_POST[idpreli]!="-1")
				{
					//calcula el listado de pago nomina
					$_POST[saldocuentas]="0";
					$sqlr="SELECT * FROM hum_prenomina_det WHERE codigo='$_POST[idpreli]' ORDER BY id_det"; 
					$resp = mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($resp))
					{
						if($_POST[mesnomina]==''){$_POST[mesnomina]=$row[2];}
						$totaldevengado=0;
						$veribc01=0;
						$veribc02=0;
						$listatipomov[]="nomina";
						$listatipopago[]="01";
						$listatcodigofuncionario[]=$row[4];
						$listacentrocosto[]=$row[13];
						$listatipopension[]=$row[19];
						$listaempleados[]=iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$row[8]);
						$listadocumentos[]=$row[7];
						$listasalariobasico[]=$row[6];
						$listadiasliquidados[]=$row[15];
						$listadoceps[]=$row[9];
						$listadocarl[]=$row[10];
						$listadocafp[]=$row[11];
						$listadocfdc[]=$row[12];
						$listaretiro[]=$row[29];
						if($row[29]=='N'){$devengadocal=$row[18];}
						else {$devengadocal=($row[18]/30)*$row[15];}
						if($row[24]=='S')
						{
							$totaldevengado=$listadevengados[]=$devengadocal;
							$pfcp[traercuentapresu2($_POST[tsueldo],$row[13],$row[3])]+=$totaldevengado;
							if($row[25]=='S' && $row[26]=='S')
							{
								$listaibceps[]=$veribc01=aplicaredondeo($devengadocal+calcularibc($_POST[idpreli],$row[4],'01'),$_POST[redondeoibc],$_POST[nivelredondeo],$_POST[tiporedondeoibc2]);
								$listaibcfdp[]=$veribc02=aplicaredondeo($devengadocal+calcularibc($_POST[idpreli],$row[4],'02'),$_POST[redondeoibc],$_POST[nivelredondeo],$_POST[tiporedondeoibc2]);
							}
							elseif($row[25]=='S')
							{
								$listaibceps[]=$veribc01=aplicaredondeo($devengadocal+calcularibc($_POST[idpreli],$row[4],'01'),$_POST[redondeoibc],$_POST[nivelredondeo],$_POST[tiporedondeoibc2]);
								$listaibcfdp[]=$veribc02=aplicaredondeo(0+calcularibc($_POST[idpreli],$row[4],'02'),$_POST[redondeoibc],$_POST[nivelredondeo],$_POST[tiporedondeoibc2]);
								
							}
							elseif($row[26]=='S')
							{
								$listaibceps[]=$veribc01=aplicaredondeo(0+calcularibc($_POST[idpreli],$row[4],'01'),$_POST[redondeoibc],$_POST[nivelredondeo],$_POST[tiporedondeoibc2]);
								$listaibcfdp[]=$veribc02=aplicaredondeo($devengadocal+calcularibc($_POST[idpreli],$row[4],'02'),$_POST[redondeoibc],$_POST[nivelredondeo],$_POST[tiporedondeoibc2]);
							}
							else
							{
								$listaibceps[]=$veribc01=aplicaredondeo(0+calcularibc($_POST[idpreli],$row[4],'01'),$_POST[redondeoibc],$_POST[nivelredondeo],$_POST[tiporedondeoibc2]);
								$listaibcfdp[]=$veribc02=aplicaredondeo(0+calcularibc($_POST[idpreli],$row[4],'02'),$_POST[redondeoibc],$_POST[nivelredondeo],$_POST[tiporedondeoibc2]);
							}
						}
						else 
						{
							$totaldevengado=$listadevengados[]=0;
							if($row[25]=='S' && $row[26]=='S')
							{
								$listaibceps[]=$veribc01=aplicaredondeo((($row[6]/30)*$row[15])+calcularibc($_POST[idpreli],$row[4],'01'),$_POST[redondeoibc],$_POST[nivelredondeo],$_POST[tiporedondeoibc2]);
								$listaibcfdp[]=$veribc02=aplicaredondeo((($row[6]/30)*$row[15])+calcularibc($_POST[idpreli],$row[4],'02'),$_POST[redondeoibc],$_POST[nivelredondeo],$_POST[tiporedondeoibc2]);
								
							}
							elseif($row[25]=='S')
							{
								$listaibceps[]=$veribc01=aplicaredondeo((($row[6]/30)*$row[15])+calcularibc($_POST[idpreli],$row[4],'01'),$_POST[redondeoibc],$_POST[nivelredondeo],$_POST[tiporedondeoibc2]);
								$listaibcfdp[]=$veribc02=0;
							}
							elseif($row[26]=='S')
							{
								$listaibceps[]=$veribc01=0;
								$listaibcfdp[]=$veribc02=aplicaredondeo((($row[6]/30)*$row[15])+calcularibc($_POST[idpreli],$row[4],'02'),$_POST[redondeoibc],$_POST[nivelredondeo],$_POST[tiporedondeoibc2]);
							}
							else
							{
								$listaibceps[]=$veribc01=0;
								$listaibcfdp[]=$veribc02=0;
							}
						}
						if ($veribc01>$veribc02){$listaibc[]=$veribc01;}
						else{$listaibc[]=$veribc01;}
						//$totaldevengado+=$listaauxalimentacion[]=$auxalim=buscavalorotrospagos($_POST[idpreli],$_POST[tsubalim],$row[4]);
						//$totaldevengado+=$listaauxtrasporte[]=$auxtra=buscavalorotrospagos($_POST[idpreli],$_POST[tauxtrans],$row[4]);
						//$totaldevengado+=$listaotrospagos[]=$otrospag=totalvalorotrospagossinaux($_POST[idpreli],$row[4]);
						$totaldevengado+=$listaotrospagos[]=$otrospag=0;
						$listatotaldevengados[]=$totaldevengado;
						//if($auxalim>0){$pfcp[traercuentapresu2($_POST[tsubalim],$row[13],$row[3])]+=$auxalim;}
						//if($auxtra>0){$pfcp[traercuentapresu2($_POST[tauxtrans],$row[13],$row[3])]+=$auxtra;}
						if($otrospag>0)
						{
							$sqlrotos="SELECT valpago,codpag FROM hum_otrospagos WHERE codpre='$_POST[idpreli]' AND (codpag<>'01' AND codpag<>'07' AND codpag<>'08') AND codigofun='$row[4]'";
							$resotos=mysql_query($sqlrotos,$linkbd);
							while ($rotos=mysql_fetch_row($resotos))
							{
								if($rotos[0]>0){$pfcp[traercuentapresu2($rotos[1],$row[13],$row[3])]+=$rotos[0];}
							}
						}
						if ($row[28]=='S')
						{$listabaseparafiscales[]=$ibcpara=aplicaredondeo($devengadocal+calcularibc($_POST[idpreli],$row[4],'04'),$_POST[redondeoibcpara],$_POST[nivelredondeo],$_POST[tiporedondeoibc2]);}
						else {$listabaseparafiscales[]=$ibcpara=0;}
						if ($row[27]=='S')
						{$listabasearp[]=$ibcarp=aplicaredondeo($devengadocal+calcularibc($_POST[idpreli],$row[4],'03'),$_POST[redondeoibcarp],$_POST[nivelredondeo],$_POST[tiporedondeoibc2]);}
						else {$listabasearp[]=$ibcarp=0;}
						//calcular SALUD
						$porcentaje1=buscaporcentajeparafiscal($_POST[tsaludemr],'A');
						$porcentaje2=buscaporcentajeparafiscal($_POST[tsaludemp],'D');
						if($row[7]=='17316460')
						{
							$porcentajet=$porcentaje1;
							$listasaludtotal[]=$valsaludtot=ceil(($veribc01*$porcentajet)/10000)*100;
							$listasaludempleado[]=$rsalud=0;
							$listasaludempresa[]=$rsaludemp=$valsaludtot;
						}
						else
						{
							$porcentajet=$porcentaje1+$porcentaje2;
							$listasaludtotal[]=$valsaludtot=ceil(($veribc01*$porcentajet)/10000)*100;
							$listasaludempleado[]=$rsalud=round(($veribc01*$porcentaje2)/100);
							$listasaludempresa[]=$rsaludemp=$valsaludtot-$rsalud;
						}
						$pfcp[traercuentapresu($_POST[tsaludemr],$row[13],$row[3])]+=$rsaludemp;
						//calular PENSION
						$porcentaje1=buscaporcentajeparafiscal($_POST[tpensionemr],'A');
						$porcentaje2=buscaporcentajeparafiscal($_POST[tpensionemp],'D');
						
							$porcentajet=$porcentaje1+$porcentaje2;
							$listapensiontotal[]=$valpensiontot=ceil (($veribc02*$porcentajet)/10000)*100;
							$listapensionempleado[]=$rpension=round(($veribc02*$porcentaje2)/100);
							$listapensionempresa[]=$rpensionemp=$valpensiontot-$rpension;
						
						$pfcp[traercuentapresu($_POST[tpensionemr],$row[13],$row[3],$row[19])]+=$rpensionemp;
						//calcular FONDO SOLIDARIDAD
						$sqlrfs="SELECT * FROM humfondosoli WHERE estado='S' AND $totaldevengado between (rangoinicial*$_POST[salmin]) AND (rangofinal*$_POST[salmin])"; 
						$respfs = mysql_query($sqlrfs,$linkbd);
						$rowfs =mysql_fetch_row($respfs);
						$fondosol=0;
						if($_POST[tipofondosol]==0)
						{$fondosol=round((($rowfs[3]/2)/100)*(round($veribc02,-3,PHP_ROUND_HALF_DOWN)),-2)*2;}
						else {$fondosol=ceil(((($rowfs[3]/2)/100)*round($veribc02,-3,PHP_ROUND_HALF_DOWN))/100)*200;}
						$listafondosolidaridad[]=$fondosol;
						//calcular ARL
						$porcentaje=porcentajearl($row[4]);
						$valdeci= (int) substr(number_format(($ibcarp*$porcentaje)/100,0),-2);
						if($valdeci > 5){$listaarp[]=$valorarl=ceil(($ibcarp*$porcentaje)/10000)*100;}
						else {$listaarp[]=$valorarl=round (($ibcarp*$porcentaje)/100,-2,PHP_ROUND_HALF_DOWN);}
						$pfcp[traercuentapresu($_POST[tarp],$row[13],$row[3])]+=$valorarl;
						$pf[$_POST[tarp]][$row[13]]+=$valorarl;
						//calcular Retenciones
						$sqlrete="SELECT SUM(valorretencion) FROM hum_retencionesfun WHERE estado='S' AND estadopago='N' AND mes='$row[2]' AND docfuncionario='$row[7]' AND vigencia='$row[3]'"; 
						$resrete = mysql_query($sqlrete,$linkbd);
						$rowrete =mysql_fetch_row($resrete);
						$listaretenciones[]=$valorretencion=$rowrete[0];
						// calcular Descuentos
						$sqlrds="SELECT SUM(T1.valorcuota) FROM humretenempleados T1 WHERE T1.empleado='$row[7]' AND T1.habilitado='H' AND T1.estado='S' AND T1.tipopago='01' AND ncuotas > (SELECT COUNT(T2.id) FROM humnominaretenemp T2 WHERE T2.cedulanit='$row[7]' AND T2.id = T1.id AND estado='P')";
						$respds = mysql_query($sqlrds,$linkbd);
						$rowds =mysql_fetch_row($respds);
						$listaotrasdeducciones[]=$otrasrete=round($rowds[0]);
						//calcular total descuentos
						$listatotaldeducciones[]=$totalretenciones=$rsalud+$rpension+$otrasrete+$fondosol+$valorretencion;
						//calcular Neto a Pagar
						$listanetoapagar[]=$totalneto=$totaldevengado-$totalretenciones;
						//calcular CCF
						$porcentaje=buscaporcentajeparafiscal($_POST[tcajacomp],'A');
						$listaccf[]=$valccf=ceil(($ibcpara*$porcentaje)/10000)*100;
						$pfcp[traercuentapresu($_POST[tcajacomp],$row[13],$row[3])]+=$valccf;
						$pf[$_POST[tcajacomp]][$row[13]]+=$valccf;
						//calcular SENA
						$porcentaje=buscaporcentajeparafiscal($_POST[tsena],'A');
						$listasena[]=$valsena=ceil(($ibcpara*$porcentaje)/10000)*100;
						$pfcp[traercuentapresu($_POST[tsena],$row[13],$row[3])]+=$valsena;
						$pf[$_POST[tsena]][$row[13]]+=$valsena;
						//calcular ICBF
						$porcentaje=buscaporcentajeparafiscal($_POST[ticbf],'A');
						$listaicbf[]=$valicbf=ceil(($ibcpara*$porcentaje)/10000)*100;
						$pfcp[traercuentapresu($_POST[ticbf],$row[13],$row[3])]+=$valicbf;
						$pf[$_POST[ticbf]][$row[13]]+=$valicbf;
						//calcular INSTITUTOS TECNICOS
						$porcentaje=buscaporcentajeparafiscal($_POST[titi],'A');
						$listainstecnicos[]=$valinstec=ceil(($ibcpara*$porcentaje)/10000)*100;
						$pfcp[traercuentapresu($_POST[titi],$row[13],$row[3])]+=$valinstec;
						$pf[$_POST[titi]][$row[13]]+=$valinstec;
						//calcular ESAP
						$porcentaje=buscaporcentajeparafiscal($_POST[tesap],'A');
						$listaesap[]=$valesap=ceil(($ibcpara*$porcentaje)/10000)*100;
						$pfcp[traercuentapresu($_POST[tesap],$row[13],$row[3])]+=$valesap;
						$pf[$_POST[tesap]][$row[13]]+=$valesap;
						//calcular otros tipos de pago 
						if($row[16]>0)//calcular Incapacidades
						{
							$sqlric="SELECT T1.pagar_ibc,T1.pagar_arl,T1.pagar_para,SUM(T1.valor_total),SUM(T1.dias_inca),T1.tipo_inca FROM hum_incapacidades_det T1, hum_incapacidades T2 WHERE T1.num_inca=T2.num_inca AND T2.estado<>'N' AND T1.doc_funcionario='$row[7]' AND T1.mes='$row[2]' AND T1.vigencia='$row[3]' AND T1.estado='S' AND T1.tipo_inca <> 'LNR'";
							$respic = mysql_query($sqlric,$linkbd);
							while ($rowic =mysql_fetch_row($respic)) 
							{	
								if($rowic[4]!=NULL)
								{
									$veribc01=0;
									$veribc02=0;
									$listatipomov[]="Incapacidad";
									$listatipopago[]="01";
									$listatcodigofuncionario[]=$row[4];
									$listadoceps[]=$row[9];
									$listadocarl[]=$row[10];
									$listadocafp[]=$row[11];
									$listadocfdc[]=$row[12];
									$listacentrocosto[]=$row[13];
									$listatipopension[]=$row[19];
									$listaempleados[]=iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$row[8]);
									$listadocumentos[]=$row[7];
									$listasalariobasico[]=$row[6];
									$listadiasliquidados[]=$rowic[4];
									$totaldevengado=$listadevengados[]=$rowic[3];
									$pfcp[traercuentapresu2($_POST[tsueldo],$row[13],$row[3])]+=$totaldevengado;

									if($row[25]=='S' && $row[26]=='S' && $rowic[0]=='S')
									{
										if($_POST[tipoincapasidad]=='1')
										{
											$listaibceps[]=$veribc01=aplicaredondeo($totaldevengado,$_POST[redondeoibc],$_POST[nivelredondeo],$_POST[tiporedondeoibc2]);
											$listaibcfdp[]=$veribc02=aplicaredondeo($totaldevengado,$_POST[redondeoibc],$_POST[nivelredondeo],$_POST[tiporedondeoibc2]);
										}
										else
										{
											$listaibceps[]=$veribc01=aplicaredondeo(($row[6]/30)*$rowic[4],$_POST[redondeoibc],$_POST[nivelredondeo],$_POST[tiporedondeoibc2]);
											$listaibcfdp[]=$veribc02=aplicaredondeo(($row[6]/30)*$rowic[4],$_POST[redondeoibc],$_POST[nivelredondeo],$_POST[tiporedondeoibc2]);
										}

									}
									elseif($row[25]=='S' && $rowic[0]=='S')
									{
										if($_POST[tipoincapasidad]=='1')
										{$listaibceps[]=$veribc01=aplicaredondeo($totaldevengado,$_POST[redondeoibc],$_POST[nivelredondeo],$_POST[tiporedondeoibc2]);}
										else
										{$listaibceps[]=$veribc01=aplicaredondeo(($row[6]/30)*$rowic[4],$_POST[redondeoibc],$_POST[nivelredondeo],$_POST[tiporedondeoibc2]);}
										$listaibcfdp[]=$veribc02=0;
									}
									elseif($row[26]=='S' && $rowic[0]=='S')
									{
										$listaibceps[]=$veribc01=0;
										if($_POST[tipoincapasidad]=='1')
										{$listaibcfdp[]=$veribc02=aplicaredondeo($totaldevengado,$_POST[redondeoibc],$_POST[nivelredondeo],$_POST[tiporedondeoibc2]);}
										else
										{$listaibcfdp[]=$veribc02=aplicaredondeo(($row[6]/30)*$rowic[4],$_POST[redondeoibc],$_POST[nivelredondeo],$_POST[tiporedondeoibc2]);}
									}
									else
									{
										$listaibceps[]=$veribc01=0;
										$listaibcfdp[]=$veribc02=0;
									}
									if ($veribc01>$veribc02){$listaibc[]=$veribc01;}
									else{$listaibc[]=$veribc01;}
									$totaldevengado+=$listaauxalimentacion[]=0;
									$totaldevengado+=$listaauxtrasporte[]=0;
									$totaldevengado+=$listaotrospagos[]=0;
									$listatotaldevengados[]=$totaldevengado;
									if($rowic[2]=='S')
									{
										if($_POST[tipoincapasidad]=='1')
										{$listabaseparafiscales[]=$ibcpara=aplicaredondeo($totaldevengado,$_POST[redondeoibcpara],$_POST[nivelredondeo],$_POST[tiporedondeoibc2]);}
										else
										{$listabaseparafiscales[]=$ibcpara=aplicaredondeo(($row[6]/30)*$rowic[4],$_POST[redondeoibcpara],$_POST[nivelredondeo],$_POST[tiporedondeoibc2]);}
									}
									else {$listabaseparafiscales[]=$ibcpara=0;}
									if($rowic[1]=='S')
									{
										if($_POST[tipoincapasidad]=='1')
										{$listabasearp[]=$ibcarp=aplicaredondeo($totaldevengado,$_POST[redondeoibcarp],$_POST[nivelredondeo],$_POST[tiporedondeoibc2]);}
										else
										{$listabasearp[]=$ibcarp=aplicaredondeo(($row[6]/30)*$rowic[4],$_POST[redondeoibcarp],$_POST[nivelredondeo],$_POST[tiporedondeoibc2]);}
									}
									else {$listabasearp[]=$ibcarp=0;}
									//calcular SALUD
									$porcentaje1=buscaporcentajeparafiscal($_POST[tsaludemr],'A');
									$porcentaje2=buscaporcentajeparafiscal($_POST[tsaludemp],'D');
									//if($row[7]=='30218905'){echo "$rowic[5] <-> $row[6] <-> $row[15]";}

									if($rowic[5]=='LNR')
									{
										$porcentajet=$porcentaje1;
										$listasaludtotal[]=$valsaludtot=ceil(((($row[6]/30)*$rowic[4])*$porcentajet)/10000)*100;
										$listasaludempleado[]=$rsalud=0;
										$listasaludempresa[]=$rsaludemp=$valsaludtot;
									}
									else
									{
										$porcentajet=$porcentaje1+$porcentaje2;
										$listasaludtotal[]=$valsaludtot=ceil(($veribc01*$porcentajet)/10000)*100;
										$listasaludempleado[]=$rsalud=round(($veribc01*$porcentaje2)/100);
										$listasaludempresa[]=$rsaludemp=$valsaludtot-$rsalud;

									}
									$pfcp[traercuentapresu($_POST[tsaludemr],$row[13],$row[3])]+=$rsaludemp;
									//calular PENSION
									$porcentaje1=buscaporcentajeparafiscal($_POST[tpensionemr],'A');
									$porcentaje2=buscaporcentajeparafiscal($_POST[tpensionemp],'D');
									//if(($row[7]=='30218905')|| ($row[7]=='35261542'))
									if($rowic[5]=='LNR')
									{
										$porcentajet=$porcentaje1;
										$listapensiontotal[]=$valpensiontot=ceil(((($row[6]/30)*$rowic[4])*$porcentajet)/10000)*100;
										$listapensionempleado[]=0;
										$listapensionempresa[]=$rpensionemp=$valpensiontot;
									}
									else
									{
									$porcentajet=$porcentaje1+$porcentaje2;
									$listapensiontotal[]=$valpensiontot=ceil (($veribc02*$porcentajet)/10000)*100;
									$listapensionempleado[]=$rpension=round(($veribc02*$porcentaje2)/100);
									$listapensionempresa[]=$rpensionemp=$valpensiontot-$rpension;
									}
									$pfcp[traercuentapresu($_POST[tpensionemr],$row[13],$row[3],$row[19])]+=$rpensionemp;
									//calcular FONDO SOLIDARIDAD
									$sqlrfs="SELECT * FROM humfondosoli WHERE estado='S' AND $totaldevengado between (rangoinicial*$_POST[salmin]) AND (rangofinal*$_POST[salmin])"; 
									$respfs = mysql_query($sqlrfs,$linkbd);
									$rowfs =mysql_fetch_row($respfs);
									$fondosol=0;
									if($_POST[tipofondosol]==0)
									{$fondosol=round((($rowfs[3]/2)/100)*(round($veribc02,-3,PHP_ROUND_HALF_DOWN)),-2)*2;}
									else {$fondosol=ceil(((($rowfs[3]/2)/100)*round($veribc02,-3,PHP_ROUND_HALF_DOWN))/100)*200;}
									$listafondosolidaridad[]=$fondosol;
									//calcular ARL
									$porcentaje=porcentajearl($row[4]);
									$valdeci= (int) substr(number_format(($ibcarp*$porcentaje)/100,0),-2);
									if($valdeci > 5){$listaarp[]=$valorarl=ceil(($ibcarp*$porcentaje)/10000)*100;}
									else {$listaarp[]=$valorarl=round (($ibcarp*$porcentaje)/100,-2,PHP_ROUND_HALF_DOWN);}
									$pfcp[traercuentapresu($_POST[tarp],$row[13],$row[3])]+=$valorarl;
									$pf[$_POST[tarp]][$row[13]]+=$valorarl;
									//calcular Retenciones
									$listaretenciones[]=$valorretencion=0;
									// calcular Descuentos
									$listaotrasdeducciones[]=$otrasrete=0;
									//calcular total descuentos
									$listatotaldeducciones[]=$totalretenciones=$rsalud+$rpension+$otrasrete+$fondosol+$valorretencion;
									//calcular Neto a Pagar
									$listanetoapagar[]=$totalneto=$totaldevengado-$totalretenciones;
									//calcular CCF
									$porcentaje=buscaporcentajeparafiscal($_POST[tcajacomp],'A');
									$listaccf[]=$valccf=ceil(($ibcpara*$porcentaje)/10000)*100;
									$pfcp[traercuentapresu($_POST[tcajacomp],$row[13],$row[3])]+=$valccf;
									$pf[$_POST[tcajacomp]][$row[13]]+=$valccf;
									//calcular SENA
									$porcentaje=buscaporcentajeparafiscal($_POST[tsena],'A');
									$listasena[]=$valsena=ceil(($ibcpara*$porcentaje)/10000)*100;
									$pfcp[traercuentapresu($_POST[tsena],$row[13],$row[3])]+=$valsena;
									$pf[$_POST[tsena]][$row[13]]+=$valsena;
									//calcular ICBF
									$porcentaje=buscaporcentajeparafiscal($_POST[ticbf],'A');
									$listaicbf[]=$valicbf=ceil(($ibcpara*$porcentaje)/10000)*100;
									$pfcp[traercuentapresu($_POST[ticbf],$row[13],$row[3])]+=$valicbf;
									$pf[$_POST[ticbf]][$row[13]]+=$valicbf;
									//calcular INSTITUTOS TECNICOS
									if($rowic[5]=='LM')
									{
										$listainstecnicos[]=$valinstec=0;
										$pfcp[traercuentapresu($_POST[titi],$row[13],$row[3])]+=$valinstec;
										$pf[$_POST[titi]][$row[13]]+=$valinstec;
									}
									else
									{
										$porcentaje=buscaporcentajeparafiscal($_POST[titi],'A');
										$listainstecnicos[]=$valinstec=ceil(($ibcpara*$porcentaje)/10000)*100;
										$pfcp[traercuentapresu($_POST[titi],$row[13],$row[3])]+=$valinstec;
										$pf[$_POST[titi]][$row[13]]+=$valinstec;
									}
									//calcular ESAP
									if($rowic[5]=='LM')
									{
										$listaesap[]=$valesap=0;
										$pfcp[traercuentapresu($_POST[tesap],$row[13],$row[3])]+=$valesap;
										$pf[$_POST[tesap]][$row[13]]+=$valesap;
									}
									else
									{
										$porcentaje=buscaporcentajeparafiscal($_POST[tesap],'A');
										$listaesap[]=$valesap=ceil(($ibcpara*$porcentaje)/10000)*100;
										$pfcp[traercuentapresu($_POST[tesap],$row[13],$row[3])]+=$valesap;
										$pf[$_POST[tesap]][$row[13]]+=$valesap;
									}
								}
							}
							
							$sqlric="SELECT T1.pagar_ibc,T1.pagar_arl,T1.pagar_para,SUM(T1.valor_total),SUM(T1.dias_inca),T1.tipo_inca FROM hum_incapacidades_det T1, hum_incapacidades T2 WHERE T1.num_inca=T2.num_inca AND T2.estado<>'N' AND T1.doc_funcionario='$row[7]' AND T1.mes='$row[2]' AND T1.vigencia='$row[3]' AND T1.estado='S' AND T1.tipo_inca = 'LNR'";
							$respic = mysql_query($sqlric,$linkbd);
							while ($rowic =mysql_fetch_row($respic)) 
							{
								if($rowic[4]!=NULL)
								{
									$veribc01=0;
									$veribc02=0;
									$listatipomov[]="Incapacidad";
									$listatipopago[]="01";
									$listatcodigofuncionario[]=$row[4];
									$listadoceps[]=$row[9];
									$listadocarl[]=$row[10];
									$listadocafp[]=$row[11];
									$listadocfdc[]=$row[12];
									$listacentrocosto[]=$row[13];
									$listatipopension[]=$row[19];
									$listaempleados[]=iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$row[8]);
									$listadocumentos[]=$row[7];
									$listasalariobasico[]=$row[6];
									$listadiasliquidados[]=$rowic[4];
									$totaldevengado=$listadevengados[]=$rowic[3];
									$pfcp[traercuentapresu2($_POST[tsueldo],$row[13],$row[3])]+=$totaldevengado;

									if($row[25]=='S' && $row[26]=='S' && $rowic[0]=='S')
									{
										if($_POST[tipoincapasidad]=='1')
										{
											$listaibceps[]=$veribc01=aplicaredondeo($totaldevengado,$_POST[redondeoibc],$_POST[nivelredondeo],$_POST[tiporedondeoibc2]);
											$listaibcfdp[]=$veribc02=aplicaredondeo($totaldevengado,$_POST[redondeoibc],$_POST[nivelredondeo],$_POST[tiporedondeoibc2]);
										}
										else
										{
											$listaibceps[]=$veribc01=aplicaredondeo(($row[6]/30)*$rowic[4],$_POST[redondeoibc],$_POST[nivelredondeo],$_POST[tiporedondeoibc2]);
											$listaibcfdp[]=$veribc02=aplicaredondeo(($row[6]/30)*$rowic[4],$_POST[redondeoibc],$_POST[nivelredondeo],$_POST[tiporedondeoibc2]);
										}

									}
									elseif($row[25]=='S' && $rowic[0]=='S')
									{
										if($_POST[tipoincapasidad]=='1')
										{$listaibceps[]=$veribc01=aplicaredondeo($totaldevengado,$_POST[redondeoibc],$_POST[nivelredondeo],$_POST[tiporedondeoibc2]);}
										else
										{$listaibceps[]=$veribc01=aplicaredondeo(($row[6]/30)*$rowic[4],$_POST[redondeoibc],$_POST[nivelredondeo],$_POST[tiporedondeoibc2]);}
										$listaibcfdp[]=$veribc02=0;
									}
									elseif($row[26]=='S' && $rowic[0]=='S')
									{
										$listaibceps[]=$veribc01=0;
										if($_POST[tipoincapasidad]=='1')
										{$listaibcfdp[]=$veribc02=aplicaredondeo($totaldevengado,$_POST[redondeoibc],$_POST[nivelredondeo],$_POST[tiporedondeoibc2]);}
										else
										{$listaibcfdp[]=$veribc02=aplicaredondeo(($row[6]/30)*$rowic[4],$_POST[redondeoibc],$_POST[nivelredondeo],$_POST[tiporedondeoibc2]);}
									}
									else
									{
										$listaibceps[]=$veribc01=0;
										$listaibcfdp[]=$veribc02=0;
									}
									if ($veribc01>$veribc02){$listaibc[]=$veribc01;}
									else{$listaibc[]=$veribc01;}
									$totaldevengado+=$listaauxalimentacion[]=0;
									$totaldevengado+=$listaauxtrasporte[]=0;
									$totaldevengado+=$listaotrospagos[]=0;
									$listatotaldevengados[]=$totaldevengado;
									if($rowic[2]=='S')
									{
										if($_POST[tipoincapasidad]=='1')
										{$listabaseparafiscales[]=$ibcpara=aplicaredondeo($totaldevengado,$_POST[redondeoibcpara],$_POST[nivelredondeo],$_POST[tiporedondeoibc2]);}
										else
										{$listabaseparafiscales[]=$ibcpara=aplicaredondeo(($row[6]/30)*$rowic[4],$_POST[redondeoibcpara],$_POST[nivelredondeo],$_POST[tiporedondeoibc2]);}
									}
									else {$listabaseparafiscales[]=$ibcpara=0;}
									if($rowic[1]=='S')
									{
										if($_POST[tipoincapasidad]=='1')
										{$listabasearp[]=$ibcarp=aplicaredondeo($totaldevengado,$_POST[redondeoibcarp],$_POST[nivelredondeo],$_POST[tiporedondeoibc2]);}
										else
										{$listabasearp[]=$ibcarp=aplicaredondeo(($row[6]/30)*$rowic[4],$_POST[redondeoibcarp],$_POST[nivelredondeo],$_POST[tiporedondeoibc2]);}
									}
									else {$listabasearp[]=$ibcarp=0;}
									//calcular SALUD
									$porcentaje1=buscaporcentajeparafiscal($_POST[tsaludemr],'A');
									$porcentaje2=buscaporcentajeparafiscal($_POST[tsaludemp],'D');
									//if($row[7]=='30218905'){echo "$rowic[5] <-> $row[6] <-> $row[15]";}

									if($rowic[5]=='LNR')
									{
										$porcentajet=$porcentaje1;
										$listasaludtotal[]=$valsaludtot=ceil(((($row[6]/30)*$rowic[4])*$porcentajet)/10000)*100;
										$listasaludempleado[]=$rsalud=0;
										$listasaludempresa[]=$rsaludemp=$valsaludtot;
									}
									else
									{
										$porcentajet=$porcentaje1+$porcentaje2;
										$listasaludtotal[]=$valsaludtot=ceil(($veribc01*$porcentajet)/10000)*100;
										$listasaludempleado[]=$rsalud=round(($veribc01*$porcentaje2)/100);
										$listasaludempresa[]=$rsaludemp=$valsaludtot-$rsalud;
									}
									$pfcp[traercuentapresu($_POST[tsaludemr],$row[13],$row[3])]+=$rsaludemp;
									//calular PENSION
									$porcentaje1=buscaporcentajeparafiscal($_POST[tpensionemr],'A');
									$porcentaje2=buscaporcentajeparafiscal($_POST[tpensionemp],'D');
									//if(($row[7]=='30218905')|| ($row[7]=='35261542'))
									if($rowic[5]=='LNR')
									{
										$porcentajet=$porcentaje1;
										$listapensiontotal[]=$valpensiontot=ceil(((($row[6]/30)*$rowic[4])*$porcentajet)/10000)*100;
										$listapensionempleado[]=0;
										$listapensionempresa[]=$rpensionemp=$valpensiontot;
									}
									else
									{
									$porcentajet=$porcentaje1+$porcentaje2;
									$listapensiontotal[]=$valpensiontot=ceil (($veribc02*$porcentajet)/10000)*100;
									$listapensionempleado[]=$rpension=round(($veribc02*$porcentaje2)/100);
									$listapensionempresa[]=$rpensionemp=$valpensiontot-$rpension;
									}
									$pfcp[traercuentapresu($_POST[tpensionemr],$row[13],$row[3],$row[19])]+=$rpensionemp;
									//calcular FONDO SOLIDARIDAD
									$sqlrfs="SELECT * FROM humfondosoli WHERE estado='S' AND $totaldevengado between (rangoinicial*$_POST[salmin]) AND (rangofinal*$_POST[salmin])"; 
									$respfs = mysql_query($sqlrfs,$linkbd);
									$rowfs =mysql_fetch_row($respfs);
									$fondosol=0;
									if($_POST[tipofondosol]==0)
									{$fondosol=round((($rowfs[3]/2)/100)*(round($veribc02,-3,PHP_ROUND_HALF_DOWN)),-2)*2;}
									else {$fondosol=ceil(((($rowfs[3]/2)/100)*round($veribc02,-3,PHP_ROUND_HALF_DOWN))/100)*200;}
									$listafondosolidaridad[]=$fondosol;
									//calcular ARL
									$porcentaje=porcentajearl($row[4]);
									$valdeci= (int) substr(number_format(($ibcarp*$porcentaje)/100,0),-2);
									if($valdeci > 5){$listaarp[]=$valorarl=ceil(($ibcarp*$porcentaje)/10000)*100;}
									else {$listaarp[]=$valorarl=round (($ibcarp*$porcentaje)/100,-2,PHP_ROUND_HALF_DOWN);}
									$pfcp[traercuentapresu($_POST[tarp],$row[13],$row[3])]+=$valorarl;
									$pf[$_POST[tarp]][$row[13]]+=$valorarl;
									//calcular Retenciones
									$listaretenciones[]=$valorretencion=0;
									// calcular Descuentos
									$listaotrasdeducciones[]=$otrasrete=0;
									//calcular total descuentos
									$listatotaldeducciones[]=$totalretenciones=$rsalud+$rpension+$otrasrete+$fondosol+$valorretencion;
									//calcular Neto a Pagar
									$listanetoapagar[]=$totalneto=$totaldevengado-$totalretenciones;
									//calcular CCF
									$porcentaje=buscaporcentajeparafiscal($_POST[tcajacomp],'A');
									$listaccf[]=$valccf=ceil(($ibcpara*$porcentaje)/10000)*100;
									$pfcp[traercuentapresu($_POST[tcajacomp],$row[13],$row[3])]+=$valccf;
									$pf[$_POST[tcajacomp]][$row[13]]+=$valccf;
									//calcular SENA
									$porcentaje=buscaporcentajeparafiscal($_POST[tsena],'A');
									$listasena[]=$valsena=ceil(($ibcpara*$porcentaje)/10000)*100;
									$pfcp[traercuentapresu($_POST[tsena],$row[13],$row[3])]+=$valsena;
									$pf[$_POST[tsena]][$row[13]]+=$valsena;
									//calcular ICBF
									$porcentaje=buscaporcentajeparafiscal($_POST[ticbf],'A');
									$listaicbf[]=$valicbf=ceil(($ibcpara*$porcentaje)/10000)*100;
									$pfcp[traercuentapresu($_POST[ticbf],$row[13],$row[3])]+=$valicbf;
									$pf[$_POST[ticbf]][$row[13]]+=$valicbf;
									//calcular INSTITUTOS TECNICOS
									if($rowic[5]=='LM')
									{
										$listainstecnicos[]=$valinstec=0;
										$pfcp[traercuentapresu($_POST[titi],$row[13],$row[3])]+=$valinstec;
										$pf[$_POST[titi]][$row[13]]+=$valinstec;
									}
									else
									{
										$porcentaje=buscaporcentajeparafiscal($_POST[titi],'A');
										$listainstecnicos[]=$valinstec=ceil(($ibcpara*$porcentaje)/10000)*100;
										$pfcp[traercuentapresu($_POST[titi],$row[13],$row[3])]+=$valinstec;
										$pf[$_POST[titi]][$row[13]]+=$valinstec;
									}
									//calcular ESAP
									if($rowic[5]=='LM')
									{
										$listaesap[]=$valesap=0;
										$pfcp[traercuentapresu($_POST[tesap],$row[13],$row[3])]+=$valesap;
										$pf[$_POST[tesap]][$row[13]]+=$valesap;
									}
									else
									{
										$porcentaje=buscaporcentajeparafiscal($_POST[tesap],'A');
										$listaesap[]=$valesap=ceil(($ibcpara*$porcentaje)/10000)*100;
										$pfcp[traercuentapresu($_POST[tesap],$row[13],$row[3])]+=$valesap;
										$pf[$_POST[tesap]][$row[13]]+=$valesap;
									}
								}
							}
							
							
							
							
						} //fin incapacidad
						if($row[17]>0)//calcular Vacaciones
						{
							$sqlrva="SELECT T1.valor_total,T1.dias_vaca,T2.valor_total,T2.estado,T1.pagar_ibc,T1.pagar_arl,T1.pagar_para FROM hum_vacaciones_det T1, hum_vacaciones T2 WHERE T1.num_vaca=T2.num_vaca AND T2.estado<>'N' AND T1.doc_funcionario='$row[7]' AND T1.mes='$row[2]' AND T1.vigencia='$row[3]' AND T1.estado='S' ";
							$respva = mysql_query($sqlrva,$linkbd);
							while ($rowva =mysql_fetch_row($respva)) 
							{
								$veribc01=0;
								$veribc02=0;
								$listatipomov[]="Vacaciones";
								$listatipopago[]="01";
								$listatcodigofuncionario[]=$row[4];
								$listadoceps[]=$row[9];
								$listadocarl[]=$row[10];
								$listadocafp[]=$row[11];
								$listadocfdc[]=$row[12];
								$listacentrocosto[]=$row[13];
								$listatipopension[]=$row[19];
								$listaempleados[]=iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$row[8]);
								$listadocumentos[]=$row[7];
								$listasalariobasico[]=$row[6];
								$listadiasliquidados[]=$rowva[1];
								/*if($rowva[3]=='S')
								{
									$totaldevengado=$listadevengados[]=$rowva[2];
									$pfcp[traercuentapresu2($_POST[tsueldo],$row[13],$row[3])]+=$totaldevengado;
								}
								else*/
								{$totaldevengado=$listadevengados[]=0;}
								if($row[25]=='S' && $row[26]=='S' && $rowva[4]=='S')
								{
									$listaibceps[]=$veribc01=aplicaredondeo($rowva[0],$_POST[redondeoibc],$_POST[nivelredondeo],$_POST[tiporedondeoibc2]);
									$listaibcfdp[]=$veribc02=aplicaredondeo($rowva[0],$_POST[redondeoibc],$_POST[nivelredondeo],$_POST[tiporedondeoibc2]);
									
								}
								elseif($row[25]=='S' && $rowva[4]=='S')
								{
									$listaibceps[]=$veribc01=aplicaredondeo($rowva[0],$_POST[redondeoibc],$_POST[nivelredondeo],$_POST[tiporedondeoibc2]);
									$listaibcfdp[]=$veribc02=0;
								}
								elseif($row[26]=='S' && $rowva[4]=='S')
								{
									$listaibceps[]=$veribc01=0;
									$listaibcfdp[]=$veribc02=aplicaredondeo($rowva[0],$_POST[redondeoibc],$_POST[nivelredondeo],$_POST[tiporedondeoibc2]);
								}
								else
								{
									$listaibceps[]=$veribc01=0;
									$listaibcfdp[]=$veribc02=0;
								}
								if ($veribc01>$veribc02){$listaibc[]=$veribc01;}
								else{$listaibc[]=$veribc01;}
								$totaldevengado+=$listaauxalimentacion[]=0;
								$totaldevengado+=$listaauxtrasporte[]=0;
								$totaldevengado+=$listaotrospagos[]=0;
								$listatotaldevengados[]=$totaldevengado;
								if($rowva[6]=='S'){$listabaseparafiscales[]=$ibcpara=aplicaredondeo($rowva[0],$_POST[redondeoibcpara],$_POST[nivelredondeo],$_POST[tiporedondeoibc2]);}
								else {$listabaseparafiscales[]=$ibcpara=0;}
								if($rowva[5]=='S'){$listabasearp[]=$ibcarp=aplicaredondeo($rowva[0],$_POST[redondeoibcarp],$_POST[nivelredondeo],$_POST[tiporedondeoibc2]);}
								else {$listabasearp[]=$ibcarp=0;}
								//calcular SALUD
								$porcentaje1=buscaporcentajeparafiscal($_POST[tsaludemr],'A');
								$porcentaje2=buscaporcentajeparafiscal($_POST[tsaludemp],'D');
								$porcentajet=$porcentaje1+$porcentaje2;
								$listasaludtotal[]=$valsaludtot=ceil(($veribc01*$porcentajet)/10000)*100;
								$listasaludempleado[]=$rsalud=round(($veribc01*$porcentaje2)/100);
								$listasaludempresa[]=$rsaludemp=$valsaludtot-$rsalud;
								$pfcp[traercuentapresu($_POST[tsaludemr],$row[13],$row[3])]+=$rsaludemp;
								//calular PENSION
								$porcentaje1=buscaporcentajeparafiscal($_POST[tpensionemr],'A');
								$porcentaje2=buscaporcentajeparafiscal($_POST[tpensionemp],'D');
								$porcentajet=$porcentaje1+$porcentaje2;
								$listapensiontotal[]=$valpensiontot=ceil (($veribc02*$porcentajet)/10000)*100;
								$listapensionempleado[]=$rpension=round(($veribc02*$porcentaje2)/100);
								$listapensionempresa[]=$rpensionemp=$valpensiontot-$rpension;
								$pfcp[traercuentapresu($_POST[tpensionemr],$row[13],$row[3],$row[19])]+=$rpensionemp;
								//calcular FONDO SOLIDARIDAD
								$sqlrfs="SELECT * FROM humfondosoli WHERE estado='S' AND $totaldevengado between (rangoinicial*$_POST[salmin]) AND (rangofinal*$_POST[salmin])"; 
								$respfs = mysql_query($sqlrfs,$linkbd);
								$rowfs =mysql_fetch_row($respfs);
								$fondosol=0;
								if($_POST[tipofondosol]==0)
								{$fondosol=round((($rowfs[3]/2)/100)*(round($veribc02,-3,PHP_ROUND_HALF_DOWN)),-2)*2;}
								else {$fondosol=ceil(((($rowfs[3]/2)/100)*round($veribc02,-3,PHP_ROUND_HALF_DOWN))/100)*200;}
								$listafondosolidaridad[]=$fondosol;
								//calcular ARL
								$porcentaje=porcentajearl($row[4]);
								$valdeci= (int) substr(number_format(($ibcarp*$porcentaje)/100,0),-2);
								if($valdeci > 5){$listaarp[]=$valorarl=ceil(($ibcarp*$porcentaje)/10000)*100;}
								else {$listaarp[]=$valorarl=round (($ibcarp*$porcentaje)/100,-2,PHP_ROUND_HALF_DOWN);}
								$pfcp[traercuentapresu($_POST[tarp],$row[13],$row[3])]+=$valorarl;
								$pf[$_POST[tarp]][$row[13]]+=$valorarl;
								//calcular Retenciones
								$listaretenciones[]=$valorretencion=0;
								// calcular Descuentos
								$listaotrasdeducciones[]=$otrasrete=0;
								//calcular total descuentos
								$listatotaldeducciones[]=$totalretenciones=$rsalud+$rpension+$otrasrete+$fondosol+$valorretencion;
								//calcular Neto a Pagar
								$listanetoapagar[]=$totalneto=$totaldevengado-$totalretenciones;
								//calcular CCF
								$porcentaje=buscaporcentajeparafiscal($_POST[tcajacomp],'A');
								$listaccf[]=$valccf=ceil(($ibcpara*$porcentaje)/10000)*100;
								$pfcp[traercuentapresu($_POST[tcajacomp],$row[13],$row[3])]+=$valccf;
								$pf[$_POST[tcajacomp]][$row[13]]+=$valccf;
								//calcular SENA
								$porcentaje=buscaporcentajeparafiscal($_POST[tsena],'A');
								$listasena[]=$valsena=ceil(($ibcpara*$porcentaje)/10000)*100;
								$pfcp[traercuentapresu($_POST[tsena],$row[13],$row[3])]+=$valsena;
								$pf[$_POST[tsena]][$row[13]]+=$valsena;
								//calcular ICBF
								$porcentaje=buscaporcentajeparafiscal($_POST[ticbf],'A');
								$listaicbf[]=$valicbf=ceil(($ibcpara*$porcentaje)/10000)*100;
								$pfcp[traercuentapresu($_POST[ticbf],$row[13],$row[3])]+=$valicbf;
								$pf[$_POST[ticbf]][$row[13]]+=$valicbf;
								//calcular INSTITUTOS TECNICOS
								$porcentaje=buscaporcentajeparafiscal($_POST[titi],'A');
								$listainstecnicos[]=$valinstec=ceil(($ibcpara*$porcentaje)/10000)*100;
								$pfcp[traercuentapresu($_POST[titi],$row[13],$row[3])]+=$valinstec;
								$pf[$_POST[titi]][$row[13]]+=$valinstec;
								//calcular ESAP
								$porcentaje=buscaporcentajeparafiscal($_POST[tesap],'A');
								$listaesap[]=$valesap=ceil(($ibcpara*$porcentaje)/10000)*100;
								$pfcp[traercuentapresu($_POST[tesap],$row[13],$row[3])]+=$valesap;
								$pf[$_POST[tesap]][$row[13]]+=$valesap;
							}
						}
					}
					//calcula el listado de otros pagos
					$sqlr="SELECT T1.* FROM hum_otrospagos T1 WHERE T1.codpre='$_POST[idpreli]'  ORDER BY T1.id_det";
					//$sqlr="SELECT T1.* FROM hum_otrospagos T1 WHERE T1.codpre='$_POST[idpreli]' AND NOT EXISTS(SELECT 1 FROM hum_prenomina_det T2 WHERE T2.codigo='$_POST[idpreli]' AND T2.codigofun=T1.codigofun) ORDER BY T1.id_det"; 
					$resp = mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($resp))
					{
						if($row[10]>0)
						{
							$veribc01=0;
							$veribc02=0;
							$listatipomov[]="Otros Pagos";
							$listatipopago[]=$row[2];
							$listatcodigofuncionario[]=$row[5];
							$listacentrocosto[]=$row[9];
							$listadoceps[]=presservsocial($row[5],'1');
							$listadocarl[]=presservsocial($row[5],'3');
							$listadocafp[]=$numafp=presservsocial($row[5],'2');
							$listadocfdc[]=presservsocial($row[5],'4');
							$sqlrtp="SELECT tipoemprse FROM hum_terceros_emprse WHERE numdocumento='$numafp' AND estado='S'";
							$resptp = mysql_query($sqlrtp,$linkbd);
							$rowtp =mysql_fetch_row($resptp);
							$listatipopension[]=$rowtp[0];
							$listaempleados[]=iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$row[8]);
							$listadocumentos[]=$row[7];
							$listasalariobasico[]=$row[6];
							$listadiasliquidados[]=$row[11];
							//if($row[2]=='16' || $row[2]=='17'){$valdevotr=($row[10]/30)*$row[11];}
							//else {$valdevotr=$row[10];}
							$valdevotr=$row[10];
							if($valdevotr==0){$valpagoibc=$row[6];}
							else {$valpagoibc=$valdevotr;}
							if($row[15]=='S')
							{
								$totaldevengado=$listadevengados[]=$valdevotr;
								if($totaldevengado>0){$pfcp[traercuentapresu2($row[2],$row[9],$row[4])]+=$totaldevengado;}
							}
							else{$totaldevengado=$listadevengados[]=0;}
							if($row[16]=='S' && $row[17]=='S')
							{
								$listaibceps[]=$veribc01=aplicaredondeo($valpagoibc,$_POST[redondeoibc],$_POST[nivelredondeo],$_POST[tiporedondeoibc2]);
								$listaibcfdp[]=$veribc02=aplicaredondeo($valpagoibc,$_POST[redondeoibc],$_POST[nivelredondeo],$_POST[tiporedondeoibc2]);

							}
							elseif($row[16]=='S')
							{
								$listaibceps[]=$veribc01=aplicaredondeo($valpagoibc,$_POST[redondeoibc],$_POST[nivelredondeo],$_POST[tiporedondeoibc2]);
								$listaibcfdp[]=$veribc02=0;
							}
							elseif($row[17]=='S')
							{
								$listaibceps[]=$veribc01=0;
								$listaibcfdp[]=$veribc02=aplicaredondeo($valpagoibc,$_POST[redondeoibc],$_POST[nivelredondeo],$_POST[tiporedondeoibc2]);
							}
							else
							{
								$listaibceps[]=$veribc01=0;
								$listaibcfdp[]=$veribc02=0;
							}
							if ($veribc01>$veribc02){$listaibc[]=$veribc01;}
							else{$listaibc[]=$veribc01;}
							$totaldevengado+=$listaauxalimentacion[]=0;
							$totaldevengado+=$listaauxtrasporte[]=0;
							$totaldevengado+=$listaotrospagos[]=0;
							$listatotaldevengados[]=$totaldevengado;
							if($row[19]=='S'){$listabaseparafiscales[]=$ibcpara=aplicaredondeo($valpagoibc,$_POST[redondeoibcpara],$_POST[nivelredondeo],$_POST[tiporedondeoibc2]);}
							else {$listabaseparafiscales[]=$ibcpara=0;}
							if($row[18]=='S'){$listabasearp[]=$ibcarp=aplicaredondeo($valpagoibc,$_POST[redondeoibcarp],$_POST[nivelredondeo],$_POST[tiporedondeoibc2]);}
							else {$listabasearp[]=$ibcarp=0;}
							//calcular SALUD
							$porcentaje1=buscaporcentajeparafiscal($_POST[tsaludemr],'A');
							$porcentaje2=buscaporcentajeparafiscal($_POST[tsaludemp],'D');
							$porcentajet=$porcentaje1+$porcentaje2;
							$listasaludtotal[]=$valsaludtot=ceil(($veribc01*$porcentajet)/10000)*100;
							$listasaludempleado[]=$rsalud=round(($veribc01*$porcentaje2)/100);
							$listasaludempresa[]=$rsaludemp=$valsaludtot-$rsalud;
							$pfcp[traercuentapresu($_POST[tsaludemr],$row[9],$row[4])]+=$rsaludemp;
							//calular PENSION
							$porcentaje1=buscaporcentajeparafiscal($_POST[tpensionemr],'A');
							$porcentaje2=buscaporcentajeparafiscal($_POST[tpensionemp],'D');
							$porcentajet=$porcentaje1+$porcentaje2;
							$listapensiontotal[]=$valpensiontot=ceil (($veribc02*$porcentajet)/10000)*100;
							$listapensionempleado[]=$rpension=round(($veribc02*$porcentaje2)/100);
							$listapensionempresa[]=$rpensionemp=$valpensiontot-$rpension;
							$pfcp[traercuentapresu($_POST[tpensionemr],$row[9],$row[4],$rowtp[0])]+=$rpensionemp;
							//calcular FONDO SOLIDARIDAD
							$sqlrfs="SELECT * FROM humfondosoli WHERE estado='S' AND $totaldevengado between (rangoinicial*$_POST[salmin]) AND (rangofinal*$_POST[salmin])"; 
							$respfs = mysql_query($sqlrfs,$linkbd);
							$rowfs =mysql_fetch_row($respfs);
							$fondosol=0;
							if($_POST[tipofondosol]==0)
							{$fondosol=round((($rowfs[3]/2)/100)*(round($veribc02,-3,PHP_ROUND_HALF_DOWN)),-2)*2;}
							else {$fondosol=ceil(((($rowfs[3]/2)/100)*round($veribc02,-3,PHP_ROUND_HALF_DOWN))/100)*200;}
							$listafondosolidaridad[]=$fondosol;
							//calcular ARL
							$porcentaje=porcentajearl($row[5]);
							$valdeci= (int) substr(number_format(($ibcarp*$porcentaje)/100,0),-2);
							if($valdeci > 5){$listaarp[]=$valorarl=ceil(($ibcarp*$porcentaje)/10000)*100;}
							else {$listaarp[]=$valorarl=round (($ibcarp*$porcentaje)/100,-2,PHP_ROUND_HALF_DOWN);}
							$pfcp[traercuentapresu($_POST[tarp],$row[9],$row[4])]+=$valorarl;
							$pf[$_POST[tarp]][$row[9]]+=$valorarl;
							//calcular Retenciones
							$listaretenciones[]=$valorretencion=0;
							// calcular Descuentos
							$sqlrds="SELECT SUM(T1.valorcuota) FROM humretenempleados T1 WHERE T1.empleado='$row[7]' AND T1.habilitado='H' AND T1.estado='S' AND T1.tipopago='$row[2]' AND ncuotas > (SELECT COUNT(T2.id) FROM humnominaretenemp T2 WHERE T2.cedulanit='$row[7]' AND T2.id = T1.id AND estado='P')";
							$respds = mysql_query($sqlrds,$linkbd);
							$rowds =mysql_fetch_row($respds);
							$listaotrasdeducciones[]=$otrasrete=round($rowds[0]);
							//calcular total descuentos
							$listatotaldeducciones[]=$totalretenciones=$rsalud+$rpension+$otrasrete+$fondosol+$valorretencion;
							//calcular Neto a Pagar
							$listanetoapagar[]=$totalneto=$totaldevengado-$totalretenciones;
							//calcular CCF
							$porcentaje=buscaporcentajeparafiscal($_POST[tcajacomp],'A');
							$listaccf[]=$valccf=ceil(($ibcpara*$porcentaje)/10000)*100;
							$pfcp[traercuentapresu($_POST[tcajacomp],$row[9],$row[4])]+=$valccf;
							$pf[$_POST[tcajacomp]][$row[9]]+=$valccf;
							//calcular SENA
							$porcentaje=buscaporcentajeparafiscal($_POST[tsena],'A');
							$listasena[]=$valsena=ceil(($ibcpara*$porcentaje)/10000)*100;
							$pfcp[traercuentapresu($_POST[tsena],$row[9],$row[4])]+=$valsena;
							$pf[$_POST[tsena]][$row[9]]+=$valsena;
							//calcular ICBF
							$porcentaje=buscaporcentajeparafiscal($_POST[ticbf],'A');
							$listaicbf[]=$valicbf=ceil(($ibcpara*$porcentaje)/10000)*100;
							$pfcp[traercuentapresu($_POST[ticbf],$row[9],$row[4])]+=$valicbf;
							$pf[$_POST[ticbf]][$row[9]]+=$valicbf;
							//calcular INSTITUTOS TECNICOS
							$porcentaje=buscaporcentajeparafiscal($_POST[titi],'A');
							$listainstecnicos[]=$valinstec=ceil(($ibcpara*$porcentaje)/10000)*100;
							$pfcp[traercuentapresu($_POST[titi],$row[9],$row[4])]+=$valinstec;
							$pf[$_POST[titi]][$row[9]]+=$valinstec;
							//calcular ESAP
							$porcentaje=buscaporcentajeparafiscal($_POST[tesap],'A');
							$listaesap[]=$valesap=ceil(($ibcpara*$porcentaje)/10000)*100;
							$pfcp[traercuentapresu($_POST[tesap],$row[9],$row[4])]+=$valesap;
							$pf[$_POST[tesap]][$row[9]]+=$valesap;
							if($row[2]=='16')
							{
								if($row[11]!=30)
								{
									//calcular Vacaciones
									{
										$sqlrva="SELECT T1.valor_total,T1.dias_vaca,T2.valor_total,T2.estado,T1.pagar_ibc,T1.pagar_arl,T1.pagar_para FROM hum_vacaciones_det T1, hum_vacaciones T2 WHERE T1.num_vaca=T2.num_vaca AND T2.estado<>'N' AND T1.doc_funcionario='$row[7]' AND T1.mes='$row[3]' AND T1.vigencia='$row[4]' AND T1.estado='S' ";
										$respva = mysql_query($sqlrva,$linkbd);
										while ($rowva =mysql_fetch_row($respva)) 
										{
											if ( !empty($rowva[0]) && !is_null($rowva[0]))
											{
												$veribc01=0;
												$veribc02=0;
												$listatipomov[]="vacaciones Otros Pagos";
												$listatipopago[]=$row[2];
												$listatcodigofuncionario[]=$row[5];
												$listacentrocosto[]=$row[9];
												$listadoceps[]=presservsocial($row[5],'1');
												$listadocarl[]=presservsocial($row[5],'3');
												$listadocafp[]=$numafp=presservsocial($row[5],'2');
												$listadocfdc[]=presservsocial($row[5],'4');
												$sqlrtp="SELECT tipoemprse FROM hum_terceros_emprse WHERE numdocumento='$numafp' AND estado='S'";
												$resptp = mysql_query($sqlrtp,$linkbd);
												$rowtp =mysql_fetch_row($resptp);
												$listatipopension[]=$rowtp[0];
												$listaempleados[]=iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$row[8]);
												$listadocumentos[]=$row[7];
												$listasalariobasico[]=$row[6];
												$listadiasliquidados[]=$rowva[1];
												$valdevotr=$rowva[0];
												if('w'=='Ss')
												{
													$totaldevengado=$listadevengados[]=$valdevotr;
													if($totaldevengado>0){$pfcp[traercuentapresu2($row[2],$row[9],$row[4])]+=$totaldevengado;}
												}
												else{$totaldevengado=$listadevengados[]=0;}
												if($rowva[4]=='S')
												{
													$listaibceps[]=$veribc01=aplicaredondeo($valdevotr,$_POST[redondeoibc],$_POST[nivelredondeo],$_POST[tiporedondeoibc2]);
													$listaibcfdp[]=$veribc02=aplicaredondeo($valdevotr,$_POST[redondeoibc],$_POST[nivelredondeo],$_POST[tiporedondeoibc2]);
												}
												else
												{
													$listaibceps[]=$veribc01=0;
													$listaibcfdp[]=$veribc02=0;
												}
												if ($veribc01>$veribc02){$listaibc[]=$veribc01;}
												else{$listaibc[]=$veribc01;}
												$totaldevengado+=$listaauxalimentacion[]=0;
												$totaldevengado+=$listaauxtrasporte[]=0;
												$totaldevengado+=$listaotrospagos[]=0;
												$listatotaldevengados[]=$totaldevengado;
												if($rowva[6]=='S'){$listabaseparafiscales[]=$ibcpara=aplicaredondeo($valdevotr,$_POST[redondeoibcpara],$_POST[nivelredondeo],$_POST[tiporedondeoibc2]);}
												else {$listabaseparafiscales[]=$ibcpara=0;}
												if($rowva[5]=='S'){$listabasearp[]=$ibcarp=aplicaredondeo($valdevotr,$_POST[redondeoibcarp],$_POST[nivelredondeo],$_POST[tiporedondeoibc2]);}
												else {$listabasearp[]=$ibcarp=0;}
												//calcular SALUD
												$porcentaje1=buscaporcentajeparafiscal($_POST[tsaludemr],'A');
												$porcentaje2=buscaporcentajeparafiscal($_POST[tsaludemp],'D');
												$porcentajet=$porcentaje1+$porcentaje2;
												$listasaludtotal[]=$valsaludtot=ceil(($veribc01*$porcentajet)/10000)*100;
												$listasaludempleado[]=$rsalud=round(($veribc01*$porcentaje2)/100);
												$listasaludempresa[]=$rsaludemp=$valsaludtot-$rsalud;
												$pfcp[traercuentapresu($_POST[tsaludemr],$row[9],$row[4])]+=$rsaludemp;
												//calular PENSION
												$porcentaje1=buscaporcentajeparafiscal($_POST[tpensionemr],'A');
												$porcentaje2=buscaporcentajeparafiscal($_POST[tpensionemp],'D');
												$porcentajet=$porcentaje1+$porcentaje2;
												$listapensiontotal[]=$valpensiontot=ceil (($veribc02*$porcentajet)/10000)*100;
												$listapensionempleado[]=$rpension=round(($veribc02*$porcentaje2)/100);
												$listapensionempresa[]=$rpensionemp=$valpensiontot-$rpension;
												$pfcp[traercuentapresu($_POST[tpensionemr],$row[9],$row[4],$rowtp[0])]+=$rpensionemp;
												//calcular FONDO SOLIDARIDAD
												$sqlrfs="SELECT * FROM humfondosoli WHERE estado='S' AND $totaldevengado between (rangoinicial*$_POST[salmin]) AND (rangofinal*$_POST[salmin])"; 
												$respfs = mysql_query($sqlrfs,$linkbd);
												$rowfs =mysql_fetch_row($respfs);
												$fondosol=0;
												if($_POST[tipofondosol]==0)
												{$fondosol=round((($rowfs[3]/2)/100)*(round($veribc02,-3,PHP_ROUND_HALF_DOWN)),-2)*2;}
												else {$fondosol=ceil(((($rowfs[3]/2)/100)*round($veribc02,-3,PHP_ROUND_HALF_DOWN))/100)*200;}
												$listafondosolidaridad[]=$fondosol;
												//calcular ARL
												$porcentaje=porcentajearl($row[5]);
												$valdeci= (int) substr(number_format(($ibcarp*$porcentaje)/100,0),-2);
												if($valdeci > 5){$listaarp[]=$valorarl=ceil(($ibcarp*$porcentaje)/10000)*100;}
												else {$listaarp[]=$valorarl=round (($ibcarp*$porcentaje)/100,-2,PHP_ROUND_HALF_DOWN);}
												$pfcp[traercuentapresu($_POST[tarp],$row[9],$row[4])]+=$valorarl;
												$pf[$_POST[tarp]][$row[9]]+=$valorarl;
												//calcular Retenciones
												$listaretenciones[]=$valorretencion=0;
												// calcular Descuentos
												$listaotrasdeducciones[]=$otrasrete=0;
												//calcular total descuentos
												$listatotaldeducciones[]=$totalretenciones=$rsalud+$rpension+$otrasrete+$fondosol+$valorretencion;
												//calcular Neto a Pagar
												$listanetoapagar[]=$totalneto=$totaldevengado-$totalretenciones;
												//calcular CCF
												$porcentaje=buscaporcentajeparafiscal($_POST[tcajacomp],'A');
												$listaccf[]=$valccf=ceil(($ibcpara*$porcentaje)/10000)*100;
												$pfcp[traercuentapresu($_POST[tcajacomp],$row[9],$row[4])]+=$valccf;
												$pf[$_POST[tcajacomp]][$row[9]]+=$valccf;
												//calcular SENA
												$porcentaje=buscaporcentajeparafiscal($_POST[tsena],'A');
												$listasena[]=$valsena=ceil(($ibcpara*$porcentaje)/10000)*100;
												$pfcp[traercuentapresu($_POST[tsena],$row[9],$row[4])]+=$valsena;
												$pf[$_POST[tsena]][$row[9]]+=$valsena;
												//calcular ICBF
												$porcentaje=buscaporcentajeparafiscal($_POST[ticbf],'A');
												$listaicbf[]=$valicbf=ceil(($ibcpara*$porcentaje)/10000)*100;
												$pfcp[traercuentapresu($_POST[ticbf],$row[9],$row[4])]+=$valicbf;
												$pf[$_POST[ticbf]][$row[9]]+=$valicbf;
												//calcular INSTITUTOS TECNICOS
												$porcentaje=buscaporcentajeparafiscal($_POST[titi],'A');
												$listainstecnicos[]=$valinstec=ceil(($ibcpara*$porcentaje)/10000)*100;
												$pfcp[traercuentapresu($_POST[titi],$row[9],$row[4])]+=$valinstec;
												$pf[$_POST[titi]][$row[9]]+=$valinstec;
												//calcular ESAP
												$porcentaje=buscaporcentajeparafiscal($_POST[tesap],'A');
												$listaesap[]=$valesap=ceil(($ibcpara*$porcentaje)/10000)*100;
												$pfcp[traercuentapresu($_POST[tesap],$row[9],$row[4])]+=$valesap;
												$pf[$_POST[tesap]][$row[9]]+=$valesap;
											}
										}
									}
									//calcular Incapacidades
									{
										$sqlric="SELECT T1.pagar_ibc,T1.pagar_arl,T1.pagar_para,SUM(T1.valor_total),SUM(T1.dias_inca) FROM hum_incapacidades_det T1, hum_incapacidades T2 WHERE T1.num_inca=T2.num_inca AND T2.estado<>'N' AND T1.doc_funcionario='$row[7]' AND T1.mes='$row[3]' AND T1.vigencia='$row[4]' AND T1.estado='S'";
										$respic = mysql_query($sqlric,$linkbd);
										while ($rowic =mysql_fetch_row($respic)) 
										{
											if ( !empty($rowic[0]) && !is_null($rowic[0]))
											{
												$veribc01=0;
												$veribc02=0;
												$listatipomov[]="Incapacidades Otros Pagos";
												$listatipopago[]=$row[2];
												$listatcodigofuncionario[]=$row[5];
												$listacentrocosto[]=$row[9];
												$listadoceps[]=presservsocial($row[5],'1');
												$listadocarl[]=presservsocial($row[5],'3');
												$listadocafp[]=$numafp=presservsocial($row[5],'2');
												$listadocfdc[]=presservsocial($row[5],'4');
												$sqlrtp="SELECT tipoemprse FROM hum_terceros_emprse WHERE numdocumento='$numafp' AND estado='S'";
												$resptp = mysql_query($sqlrtp,$linkbd);
												$rowtp =mysql_fetch_row($resptp);
												$listatipopension[]=$rowtp[0];
												$listaempleados[]=iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$row[8]);
												$listadocumentos[]=$row[7];
												$listasalariobasico[]=$row[6];
												$listadiasliquidados[]=$rowic[4];
												$valdevotr=$rowic[3];
												$totaldevengado=$listadevengados[]=$valdevotr;
												if($totaldevengado>0){$pfcp[traercuentapresu2($row[2],$row[9],$row[4])]+=$totaldevengado;}
												else{$totaldevengado=$listadevengados[]=0;}
												if($rowic[0]=='S')
												{
													$listaibceps[]=$veribc01=aplicaredondeo($valdevotr,$_POST[redondeoibc],$_POST[nivelredondeo],$_POST[tiporedondeoibc2]);
													$listaibcfdp[]=$veribc02=aplicaredondeo($valdevotr,$_POST[redondeoibc],$_POST[nivelredondeo],$_POST[tiporedondeoibc2]);
												}
												else
												{
													$listaibceps[]=$veribc01=0;
													$listaibcfdp[]=$veribc02=0;
												}
												if ($veribc01>$veribc02){$listaibc[]=$veribc01;}
												else{$listaibc[]=$veribc01;}
												$totaldevengado+=$listaauxalimentacion[]=0;
												$totaldevengado+=$listaauxtrasporte[]=0;
												$totaldevengado+=$listaotrospagos[]=0;
												$listatotaldevengados[]=$totaldevengado;
												if($rowic[1]=='S'){$listabaseparafiscales[]=$ibcpara=aplicaredondeo($valdevotr,$_POST[redondeoibcpara],$_POST[nivelredondeo],$_POST[tiporedondeoibc2]);}
												else {$listabaseparafiscales[]=$ibcpara=0;}
												if($rowic[2]=='S'){$listabasearp[]=$ibcarp=aplicaredondeo($valdevotr,$_POST[redondeoibcarp],$_POST[nivelredondeo],$_POST[tiporedondeoibc2]);}
												else {$listabasearp[]=$ibcarp=0;}
												//calcular SALUD
												$porcentaje1=buscaporcentajeparafiscal($_POST[tsaludemr],'A');
												$porcentaje2=buscaporcentajeparafiscal($_POST[tsaludemp],'D');
												$porcentajet=$porcentaje1+$porcentaje2;
												$listasaludtotal[]=$valsaludtot=ceil(($veribc01*$porcentajet)/10000)*100;
												$listasaludempleado[]=$rsalud=round(($veribc01*$porcentaje2)/100);
												$listasaludempresa[]=$rsaludemp=$valsaludtot-$rsalud;
												$pfcp[traercuentapresu($_POST[tsaludemr],$row[9],$row[4])]+=$rsaludemp;
												//calular PENSION
												$porcentaje1=buscaporcentajeparafiscal($_POST[tpensionemr],'A');
												$porcentaje2=buscaporcentajeparafiscal($_POST[tpensionemp],'D');
												$porcentajet=$porcentaje1+$porcentaje2;
												$listapensiontotal[]=$valpensiontot=ceil (($veribc02*$porcentajet)/10000)*100;
												$listapensionempleado[]=$rpension=round(($veribc02*$porcentaje2)/100);
												$listapensionempresa[]=$rpensionemp=$valpensiontot-$rpension;
												$pfcp[traercuentapresu($_POST[tpensionemr],$row[9],$row[4],$rowtp[0])]+=$rpensionemp;
												//calcular FONDO SOLIDARIDAD
												$sqlrfs="SELECT * FROM humfondosoli WHERE estado='S' AND $totaldevengado between (rangoinicial*$_POST[salmin]) AND (rangofinal*$_POST[salmin])"; 
												$respfs = mysql_query($sqlrfs,$linkbd);
												$rowfs =mysql_fetch_row($respfs);
												$fondosol=0;
												if($_POST[tipofondosol]==0)
												{$fondosol=round((($rowfs[3]/2)/100)*(round($veribc02,-3,PHP_ROUND_HALF_DOWN)),-2)*2;}
												else {$fondosol=ceil(((($rowfs[3]/2)/100)*round($veribc02,-3,PHP_ROUND_HALF_DOWN))/100)*200;}
												$listafondosolidaridad[]=$fondosol;
												//calcular ARL
												$porcentaje=porcentajearl($row[5]);
												$valdeci= (int) substr(number_format(($ibcarp*$porcentaje)/100,0),-2);
												if($valdeci > 5){$listaarp[]=$valorarl=ceil(($ibcarp*$porcentaje)/10000)*100;}
												else {$listaarp[]=$valorarl=round (($ibcarp*$porcentaje)/100,-2,PHP_ROUND_HALF_DOWN);}
												$pfcp[traercuentapresu($_POST[tarp],$row[9],$row[4])]+=$valorarl;
												$pf[$_POST[tarp]][$row[9]]+=$valorarl;
												//calcular Retenciones
												$listaretenciones[]=$valorretencion=0;
												// calcular Descuentos
												$listaotrasdeducciones[]=$otrasrete=0;
												//calcular total descuentos
												$listatotaldeducciones[]=$totalretenciones=$rsalud+$rpension+$otrasrete+$fondosol+$valorretencion;
												//calcular Neto a Pagar
												$listanetoapagar[]=$totalneto=$totaldevengado-$totalretenciones;
												//calcular CCF
												$porcentaje=buscaporcentajeparafiscal($_POST[tcajacomp],'A');
												$listaccf[]=$valccf=ceil(($ibcpara*$porcentaje)/10000)*100;
												$pfcp[traercuentapresu($_POST[tcajacomp],$row[9],$row[4])]+=$valccf;
												$pf[$_POST[tcajacomp]][$row[9]]+=$valccf;
												//calcular SENA
												$porcentaje=buscaporcentajeparafiscal($_POST[tsena],'A');
												$listasena[]=$valsena=ceil(($ibcpara*$porcentaje)/10000)*100;
												$pfcp[traercuentapresu($_POST[tsena],$row[9],$row[4])]+=$valsena;
												$pf[$_POST[tsena]][$row[9]]+=$valsena;
												//calcular ICBF
												$porcentaje=buscaporcentajeparafiscal($_POST[ticbf],'A');
												$listaicbf[]=$valicbf=ceil(($ibcpara*$porcentaje)/10000)*100;
												$pfcp[traercuentapresu($_POST[ticbf],$row[9],$row[4])]+=$valicbf;
												$pf[$_POST[ticbf]][$row[9]]+=$valicbf;
												//calcular INSTITUTOS TECNICOS
												$porcentaje=buscaporcentajeparafiscal($_POST[titi],'A');
												$listainstecnicos[]=$valinstec=ceil(($ibcpara*$porcentaje)/10000)*100;
												$pfcp[traercuentapresu($_POST[titi],$row[9],$row[4])]+=$valinstec;
												$pf[$_POST[titi]][$row[9]]+=$valinstec;
												//calcular ESAP
												$porcentaje=buscaporcentajeparafiscal($_POST[tesap],'A');
												$listaesap[]=$valesap=ceil(($ibcpara*$porcentaje)/10000)*100;
												$pfcp[traercuentapresu($_POST[tesap],$row[9],$row[4])]+=$valesap;
												$pf[$_POST[tesap]][$row[9]]+=$valesap;
											}
										}
									}
								}
							}
						}
					}
					$listemp1=array_filter($listatipopension, 'array_null');
					$listemp2=array_filter($listapensiontotal, 'array_zero');
					if(count($listemp1)==count($listemp2) && count($listemp1)!=0){$vartemp="S";}
					else{$vartemp="N";}
					$vartemp="S";
					$_POST[ttippen]=$vartemp;
				}
				else{$_POST[saldocuentas]="0";}
			?>
			<div class="tabscontra" style="height:64%; width:99.6%"> 
 				<div class="tab"><!--Pestaña liquidación de Empleados-->
       				<input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
	   				<label for="tab-1">Liquidaci&oacute;n Individual</label>
	   				<div class="content" >
						<table class='inicio' align='center' width='99%' id="tabla1">
                            <tr>
                                <th class='titulos2'>Id</th>
                                <th class='titulos2'>TIPO</th>
                                <th class='titulos2'>SECTOR</th>
                                <th class='titulos2'>EMPLEADO</th>
                                <th class='titulos2'>Doc Id</th>
                                <th class='titulos2'>SAL BAS</th>
                                <th class='titulos2'>DIAS LIQ</th>
                                <th class='titulos2'>DEVENGADO</th>
                                <th class='titulos2'>AUX ALIM</th>
                                <th class='titulos2'>AUX TRAN</th>
                                <th class='titulos2'>OTROS</th>
                                <th class='titulos2'>TOT DEV</th>
                                <th class='titulos2'>IBC</th>
                                <th class='titulos2'>BASE PARAFISCALES</th>									
                                <th class='titulos2'>BASE ARP</th>
                                <th class='titulos2'>ARP</th>
                                <th class='titulos2'>SALUD EMPLEADO</th>
                                <th class='titulos2'>SALUD EMPRESA</th>
                                <th class='titulos2'>SALUD TOTAL</th>
                                <th class='titulos2'>PENSION EMPLEADO</th>
                                <th class='titulos2'>PENSION EMPRESA</th>
                                <th class='titulos2'>PENSION TOTAL</th>
                                <th class='titulos2'>FONDO SOLIDARIDAD</th>
                                <th class='titulos2'>RETE FTE</th>
                                <th class='titulos2'>OTRAS DEDUC</th>
                                <th class='titulos2'>TOT DEDUC</th>
                                <th class='titulos2'>NETO PAG</th>
                                <th class='titulos2'>CCF</th>
                                <th class='titulos2'>SENA</th>
                                <th class='titulos2'>ICBF</th>
                                <th class='titulos2'>INS. TEC.</th>
                                <th class='titulos2'>ESAP</th>
                            </tr>
							<?php
								if($_POST[idpreli]!="-1")
								{
									$iter="zebra1";
									$iter2="zebra2";
									for ($x=0;$x<count($listaempleados);$x++)
									{
										if($listatipomov[$x]=='Vacaciones'){$valornetor=0;}
										else {$valornetor=$listanetoapagar[$x];}
										if($listatipopago[$x]=='01'){$tipodepago="$listatipomov[$x] - $listatipopago[$x]";}
										else {$tipodepago=buscavariblespagonomina($listatipopago[$x]);}
										echo"
										<tr class='$iter'>
										<td style='text-align:right;'>".($x+1)."&nbsp;</td>
										<td>$tipodepago</td>
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
										<td style='text-align:right;'>$".number_format($listafondosolidaridad[$x],0,',','.')."</td>
										<td style='text-align:right;' title='Retefunte'>$".number_format($listaretenciones[$x],0,',','.')."</td>
										<td style='text-align:right;' title='Otras Deducciones'>$".number_format($listaotrasdeducciones[$x],0,',','.')."</td>
										<td style='text-align:right;' title='Total Deducciones'>$".number_format($listatotaldeducciones[$x],0,',','.')."</td>
										<td style='text-align:right;' title='Neto a Pagar'>$".number_format($valornetor,0,',','.')."</td>
										<td style='text-align:right;' title='CCF'>$".number_format($listaccf[$x],0,',','.')."</td>
										<td style='text-align:right;' title='SENA'>$".number_format($listasena[$x],0,',','.')."</td>
										<td style='text-align:right;' title='ICBF'>$".number_format($listaicbf[$x],0,',','.')."</td>
										<td style='text-align:right;' title='Institutos Tecnicos'>$".number_format($listainstecnicos[$x],0,',','.')."</td>
										<td style='text-align:right;' title='ESAP'>$".number_format($listaesap[$x],0,',','.')."</td>
										</tr>";
										$aux=$iter;
										$iter=$iter2;
										$iter2=$aux;
									}
									//Calcula totales generales
									echo"
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
										<td style='text-align:right;'>$".number_format(array_sum($listaretenciones),0,',','.')."</td>
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
								}
							?>
                 		</table>
                 	</div>
				</div><!--Pestaña liquidación de Empleados-->
                <div class="tab"><!--Pestaña liquidación de Empleados totales-->
       				<input type="radio" id="tab-8" name="tabgroup1" value="8" <?php echo $check8;?> >
	   				<label for="tab-8">Liquidaci&oacute;n Global</label>
	   				<div class="content" >
						<table class='inicio' align='center' width='99%' id="tabla1">
                            <tr>
                                <th class='titulos2'>Id</th>
                                <th class='titulos2'>TIPO</th>
                                <th class='titulos2'>SECTOR</th>
                                <th class='titulos2'>EMPLEADO</th>
                                <th class='titulos2'>Doc Id</th>
                                <th class='titulos2'>SAL BAS</th>
                                <th class='titulos2'>DIAS LIQ</th>
                                <th class='titulos2'>DEVENGADO</th>
                                <th class='titulos2'>AUX ALIM</th>
                                <th class='titulos2'>AUX TRAN</th>
                                <th class='titulos2'>OTROS</th>
                                <th class='titulos2'>TOT DEV</th>
                                <th class='titulos2'>IBC</th>
                                <th class='titulos2'>BASE PARAFISCALES</th>									
                                <th class='titulos2'>BASE ARP</th>
                                <th class='titulos2'>ARP</th>
                                <th class='titulos2'>SALUD EMPLEADO</th>
                                <th class='titulos2'>SALUD EMPRESA</th>
                                <th class='titulos2'>SALUD TOTAL</th>
                                <th class='titulos2'>PENSION EMPLEADO</th>
                                <th class='titulos2'>PENSION EMPRESA</th>
                                <th class='titulos2'>PENSION TOTAL</th>
                                <th class='titulos2'>FONDO SOLIDARIDAD</th>
                                <th class='titulos2'>RETE FTE</th>
                                <th class='titulos2'>OTRAS DEDUC</th>
                                <th class='titulos2'>TOT DEDUC</th>
                                <th class='titulos2'>NETO PAG</th>
                                <th class='titulos2'>CCF</th>
                                <th class='titulos2'>SENA</th>
                                <th class='titulos2'>ICBF</th>
                                <th class='titulos2'>INS. TEC.</th>
                                <th class='titulos2'>ESAP</th>
                            </tr>
							<?php
								if($_POST[idpreli]!="-1")
								{
									$iter="zebra1";
									$iter2="zebra2";
									$vecmarca=array();
									
									$x=0;
									$y=1;
									foreach ($listatcodigofuncionario as &$codfunci)
									{	
										$totaldias=$totaldeven=$totalauxalim=$totalauxtrans=$totalotrospag=$totalrdevenga=$totalsumibc=0;
										$totalibcpara=$totalibcarl=$totalsumarl=$totalsaludempl=$totalsaludempr=$totalsalud=$totalpensionempl=0;
										$totalpensionempr=$totalpension=$totalfondosol=$totalretefuente=$totalotrasdedu=$totaldeducciones=0; 
										$totalnetoapagar=$totalccf=$totalsena=$totalicbf=$totalinstecnicos=$totalesap=0;
										if (!in_array($listatcodigofuncionario[$x], $vecmarca))
										{
											$vecmarca[]=$listatcodigofuncionario[$x];
											for ($xy=0;$xy<count($listatcodigofuncionario);$xy++)
											{	
												if($listatcodigofuncionario[$x]==$listatcodigofuncionario[$xy]) 
												{
													$totaldias+=$listadiasliquidados[$xy];
													$totaldeven+=$listadevengados[$xy];
													$totalauxalim+=$listaauxalimentacion[$xy];
													$totalauxtrans+=$listaauxtrasporte[$xy];
													$totalotrospag+=$listaotrospagos[$xy];
													$totalrdevenga+=$listatotaldevengados[$xy];
													$totalsumibc+=$listaibc[$xy];
													$totalibcpara+=$listabaseparafiscales[$xy];
													$totalibcarl+=$listabasearp[$xy];
													$totalsumarl+=$listaarp[$xy];
													$totalsaludempl+=$listasaludempleado[$xy];
													$totalsaludempr+=$listasaludempresa[$xy];
													$totalsalud+=$listasaludtotal[$xy];
													$totalpensionempl+=$listapensionempleado[$xy];
													$totalpensionempr+=$listapensionempresa[$xy];
													$totalpension+=$listapensiontotal[$xy];
													$totalfondosol+=$listafondosolidaridad[$xy];
													$totalretefuente+=$listaretenciones[$xy];
													$totalotrasdedu+=$listaotrasdeducciones[$xy];
													$totaldeducciones+=$listatotaldeducciones[$xy];
													$totalnetoapagar+=$listanetoapagar[$xy];
													$totalccf+=$listaccf[$xy];
													$totalsena+=$listasena[$xy];
													$totalicbf+=$listaicbf[$xy];
													$totalinstecnicos+=$listainstecnicos[$xy];
													$totalesap+=$listaesap[$xy];
												}
											}
										echo"
										<tr class='$iter'>
										<td style='text-align:right;'>$y&nbsp;</td>
										<td>$listatipopago[$x]</td>
										<td>$listatipopension[$x]</td>
										<td>$listaempleados[$x]</td>			
										<td style='text-align:right;'>$listadocumentos[$x]&nbsp;</td>
										<td style='text-align:right;' title='Salario Basico'>$".number_format($listasalariobasico[$x],0,',','.')."</td>
										<td style='text-align:right;'>$totaldias&nbsp;</td>
										<td style='text-align:right;' title='Salario Devengado'>$".number_format($totaldeven,0,',','.')."</td>
										<td style='text-align:right;' title='Auxilio Alimentacion'>$".number_format($totalauxalim,0,',','.')."</td>
										<td style='text-align:right;' title='Auxilio Transporte'>$".number_format($totalauxtrans,0,',','.')."</td>
										<td style='text-align:right;' title='Otros Pagos'>$".number_format($totalotrospag,0,',','.')."</td>
										<td style='text-align:right;' title='Total Devengado'>$".number_format($totalrdevenga,0,',','.')."</td>
										<td style='text-align:right;' title='IBC'>$".number_format($totalsumibc,0,',','.')."</td>
										<td style='text-align:right;' title='Base Parafiscales'>$".number_format($totalibcpara,0,',','.')."</td>
										<td style='text-align:right;' title='Base ARP'>$".number_format($totalibcarl,0,',','.')."</td>
										<td style='text-align:right;' title='Valor ARP'>$".number_format($totalsumarl,0,',','.')."</td>
										<td style='text-align:right;' title='Salud Empleado'>$".number_format($totalsaludempl,0,',','.')."</td>
										<td style='text-align:right;' title='Salud Empresa'>$".number_format($totalsaludempr,0,',','.')."</td>
										<td style='text-align:right;' title='Salud Total'>$".number_format($totalsalud,0,',','.')."</td>
										<td style='text-align:right;' title='Pension Empleado'>$".number_format($totalpensionempl,0,',','.')."</td>
										<td style='text-align:right;' title='Pension Empresa'>$".number_format($totalpensionempr,0,',','.')."</td>
										<td style='text-align:right;' title='Pension Total'>$".number_format($totalpension,0,',','.')."</td>
										<td style='text-align:right;' title='Fondo Solidaridad'>$".number_format($totalfondosol,0,',','.')."</td>
										<td style='text-align:right;' title='Retefunte'>$".number_format($totalretefuente,0,',','.')."</td>
										<td style='text-align:right;' title='Otras Deducciones'>$".number_format($totalotrasdedu,0,',','.')."</td>
										<td style='text-align:right;' title='Total Deducciones'>$".number_format($totaldeducciones,0,',','.')."</td>
										<td style='text-align:right;' title='Neto a Pagar'>$".number_format($totalnetoapagar,0,',','.')."</td>
										<td style='text-align:right;' title='CCF'>$".number_format($totalccf,0,',','.')."</td>
										<td style='text-align:right;' title='SENA'>$".number_format($totalsena,0,',','.')."</td>
										<td style='text-align:right;' title='ICBF'>$".number_format($totalicbf,0,',','.')."</td>
										<td style='text-align:right;' title='Institutos Tecnicos'>$".number_format($totalinstecnicos,0,',','.')."</td>
										<td style='text-align:right;' title='ESAP'>$".number_format($totalesap,0,',','.')."</td>
										</tr>";
										$y++;
										$aux=$iter;
										$iter=$iter2;
										$iter2=$aux;
										}
										$x++;
									}
									//Calcula totales generales
									echo"
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
										<td style='text-align:right;'>$".number_format(array_sum($listaretenciones),0,',','.')."</td>
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
								}
							?>
                 		</table>
                 	</div>
				</div><!--Pestaña liquidación de Empleados totales-->
    			<div class="tab"><!--Pestaña Aporte Parafiscales-->
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
										if($listatotalparafiscales[$row2[0]]>0)
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
									}
									echo "
									<tr class='$iter'>
										<td></td>
										<td>TOTAL SALUD </td>
										<td style='text-align:right;'>12.5 %</td>
										<td style='text-align:right;'>$ ".number_format(array_sum($listasaludtotal),2)."</td>
										<td></td>
									</tr>";
									$aux=$iter;
									$iter=$iter2;
									$iter2=$aux;
									echo"
									<tr class='$iter'>
										<td></td>
										<td>TOTAL PENSION: </td>
										<td style='text-align:right;'>16 %</td>
										<td style='text-align:right;'>".number_format(array_sum($listapensiontotal),2)."</td>
										<td></td>
									</tr>";
								}
							?>
						</table>
					</div>
				</div><!--Pestaña Aporte Parafiscales-->
    			<div class="tab"><!--Pestaña Presupuesto-->
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
								$iter="zebra1";
								$iter2="zebra2";
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
											$color=" style='text-align:center;background-color :#092; color:#fff' ";
										}
  										else
  										{
											$_POST[saldocuentas]="1";
  											$saldo="SIN SALDO";
  											$color=" style='text-align:center;background-color :#901; color:#fff' ";
  										}
 										echo "
										<input type='hidden' name='rubrosp[]' value='$k'/>
										<input type='hidden' name='nrubrosp[]' value='".strtoupper(iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$ncta))."'/>
										<input type='hidden' name='vrubrosp[]' value='$valrubros'/>
										<input type='hidden' name='vsaldo[]' value='$saldo'/>
										<tr class='$iter'>
											<td>$k</td>
											<td>".strtoupper(iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$ncta))."</td>
											<td style='text-align:right;'>".number_format($valrubros,0)."</td>
											<td $color>".$saldo."</td>
										</tr>";
  										$totalrubro+=$valrubros;
										$aux=$iter;
										$iter=$iter2;
										$iter2=$aux;
  									}
 								}
								echo"
								<tr class='$iter'>
									<td></td>
									<td style='text-align:right;'>Total:</td>
									<td style='text-align:right;'>".number_format($totalrubro,2)."</td>
								</tr>";
							?> 
						</table>
					</div>
				</div><!--Pestaña Presupuesto-->
				<div class="tab"><!--Pestaña Vacaciones-->
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
 				</div><!--Pestaña Vacaciones-->
 				<div class="tab"><!--Pestaña Incapacidades-->
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
 				</div><!--Pestaña Incapacidades-->
				<div class="tab"><!--Pestaña Descuentos-->
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
										$sqlr2="SELECT T1.* FROM humretenempleados T1 WHERE T1.empleado='$row[3]' AND T1.habilitado='H' AND T1.estado='S' AND ncuotas > (SELECT COUNT(T2.id) FROM humnominaretenemp T2 WHERE T2.cedulanit='$row[3]' AND T2.id = T1.id AND estado='P') ORDER BY T1.fecha,T1.descripcion";
	   									$resp2=mysql_query($sqlr2,$linkbd);
	   									while($row2=mysql_fetch_row($resp2))
										{
											$sqlrdes="SELECT COUNT(*) FROM humnominaretenemp WHERE cedulanit='$row[3]' AND id='$row2[0]' AND estado = 'P'";
											$respdes=mysql_query($sqlrdes,$linkbd);
											$rowdes=mysql_fetch_row($respdes);
											$numcot=$rowdes[0]+1;
											echo "<tr class='$iter'>
												<td>$con</td>
												<td>$row2[3]</td>
												<td>$row[3]</td>												
												<td>$row[4]</td>
												<td>$row2[1]</td>
												<td>$row2[8]</td>
												<td style='text-align:center;'>$numcot / $row2[6]</td>
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
				</div><!--Pestaña Descuentos-->
                <div class="tab"><!--Pestaña Retenciones-->
					<input type="radio" id="tab-7" name="tabgroup1" value="7" <?php echo $check7;?> >
					<label for="tab-7">Retenciones</label>
					<div class="content" >
						<table class="inicio">
							<tr>
								<td class="titulos">No</td>
								<td class="titulos">Fecha Registro</td>
								<td class="titulos">Documento</td>
								<td class="titulos">Nombre</td>
								<td class="titulos">Valor</td>
							</tr>
							<?php
								if($_POST[idpreli]!="-1")
								{
									$iter="zebra1";
									$iter2="zebra2";
									$con=1;
									$sqlrxre="SELECT * FROM hum_retencionesfun WHERE estadopago='N' AND estado='S' AND mes='$_POST[mesnomina]'";
									$respli=mysql_query($sqlrxre,$linkbd);
									while ($rowr=mysql_fetch_row($respli)) 
									{
										echo "<tr class='$iter'>
											<td>$con</td>
											<td>$rowr[1]</td>
											<td>$rowr[3]</td>												
											<td>$rowr[4]</td>
											<td>$rowr[6]</td>
											</tr>";
										$aux=$iter;
										$iter=$iter2;
										$iter2=$aux;
										$con++;
										
									}
								}
							?>
						</table>
					</div>
				</div><!--Pestaña Retenciones-->
			</div> 
          	<?php
				//Listados para exportar informacion
				echo"
				<input type='hidden' name='lista_codigofuncionario' value='".serialize($listatcodigofuncionario)."'/>
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
				<input type='hidden' name='lista_retenciones' value='".serialize($listaretenciones)."'/>
				<input type='hidden' name='lista_otrasdeducciones' value='".serialize($listaotrasdeducciones)."'/>
				<input type='hidden' name='lista_totaldeducciones' value='".serialize($listatotaldeducciones)."'/>
				<input type='hidden' name='lista_netoapagar' value='".serialize($listanetoapagar)."'/>
				<input type='hidden' name='lista_ccf' value='".serialize($listaccf)."'/>
				<input type='hidden' name='lista_sena' value='".serialize($listasena)."'/>
				<input type='hidden' name='lista_icbf' value='".serialize($listaicbf)."'/>
				<input type='hidden' name='lista_instecnicos' value='".serialize($listainstecnicos)."'/>
				<input type='hidden' name='lista_esap' value='".serialize($listaesap)."'/>
				<input type='hidden' name='lista_diasincapacidad' value='".serialize($listadiasincapacidad)."'/>
				<input type='hidden' name='lista_diaslaborados' value='".serialize($listadiasliquidados)."'/>";
			?>
			<input type="hidden" name="ttippen"id="ttippen" value="<?php echo $_POST[ttippen];?>"/>
            <input type="hidden" name="saldocuentas"id="saldocuentas" value="<?php echo $_POST[saldocuentas];?>"/>
            <input type="hidden" name="oculto" id="oculto" value="0"/>
            <?php 
				if($_POST[oculto]==2 && $_POST[saldocuentas]=="0")
				{
					$_POST[idcomp]=selconsecutivo('humnomina','id_nom');
					preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/", $_POST[fecha],$fecha);
					$fechaf="$fecha[3]-$fecha[2]-$fecha[1]";
					$sqlrcn="SELECT mes,vigencia FROM hum_prenomina WHERE codigo='$_POST[idpreli]' "; 
					$respcn = mysql_query($sqlrcn,$linkbd);
					$rowcn =mysql_fetch_row($respcn);
					$sqlr="INSERT INTO humnomina (id_nom,fecha, periodo,mes,diasp,mesnum,cc,vigencia,estado) VALUES ('$_POST[idcomp]','$fechaf', '1','$rowcn[0]','0','1','00','$rowcn[1]','S')";
					if (!mysql_query($sqlr,$linkbd))
					{echo "<script>despliegamodalm('visible','2','Error, no se pudo almacenar la Nomina:');</script>";}
					else
					{
						$id=$_POST[idcomp];
						$idconec=selconsecutivo('hum_nom_cdp_rp','id');
						$sqlrco="INSERT INTO hum_nom_cdp_rp (id,nomina,cdp,rp,codaprobado,vigencia,estado) VALUES ('$idconec','$id','0','0','0','$rowcn[1]', 'S')";
						mysql_query($sqlrco,$linkbd);
						$sqlrpre="UPDATE hum_prenomina SET num_liq='$_POST[idcomp]' WHERE codigo='$_POST[idpreli]'";
						mysql_query($sqlrpre,$linkbd);
						$lastday = mktime (0,0,0,$rowcn[0],1,$rowcn[1]);
						echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado la Liquidacion de la Nomina $id - Centro Costo:$_POST[cc] - Mes: ".strtoupper(strftime('%B',$lastday))." <img src='imagenes\confirm.png'></center></td></tr></table>";
						$cex=0;
						$cerr=0;
						$eps="";
						$arp="";			
						$afp="";	
						$tipoafp="";
						$x=0;
						for ($x=0;$x<count($listasalariobasico);$x++)
						{
							$perpagoi="$rowcn[1]-$rowcn[0]-01";
							$fechar = new DateTime($perpagoi);
							$fechar->modify('last day of this month');
							$fechat=$fechar->format('Y-m-d');
							$perpagof=$fechat;
							switch($listatipopago[$x])//hum_salarios_nom
							{
								case '01':
								{
									if($listaauxalimentacion[$x]>0)
									{
										$idlist=selconsecutivo('hum_salarios_nom','id_list');
										$cupres=buscavariablepagov('07',$listacentrocosto[$x],$_POST[vigencia]);
										$sqlry2="INSERT INTO hum_salarios_nom (id_list,id_nom,tercero,cc,cuentap,valorneto,valordevengado,fecha, periodopagoi,periodopagof,tipo_item,estado,tipo_mov) VALUES ('$idlist','$id','$listadocumentos[$x]','$listacentrocosto[$x]','$cupres', '$listaauxalimentacion[$x]','$listaauxalimentacion[$x]','','$perpagoi','$perpagof','07','S','201')";
										$respy2=mysql_query($sqlry2,$linkbd);
										$rowy2=mysql_fetch_row($respy2);
									}
								}
								case '16':
								{
									$idlist=selconsecutivo('hum_salarios_nom','id_list');
									$cupres=buscavariablepagov($listatipopago[$x],$listacentrocosto[$x],$_POST[vigencia]);
									$sqlry1="INSERT INTO hum_salarios_nom (id_list,id_nom,tercero,cc,cuentap,valorneto,valordevengado,fecha, periodopagoi,periodopagof,tipo_item,estado,tipo_mov) VALUES ('$idlist','$id','$listadocumentos[$x]','$listacentrocosto[$x]','$cupres', '$listanetoapagar[$x]','$listadevengados[$x]','','$perpagoi','$perpagof','$listatipopago[$x]','S','201')";
									$respy1=mysql_query($sqlry1,$linkbd);
									$rowy1=mysql_fetch_row($respy1);
								}break;
								default:
								{
									$idlist=selconsecutivo('hum_salarios_nom','id_list');
									$cupres=buscavariablepagov($listatipopago[$x],$listacentrocosto[$x],$_POST[vigencia]);
									$sqlry1="INSERT INTO hum_salarios_nom (id_list,id_nom,tercero,cc,cuentap,valorneto,valordevengado,fecha, periodopagoi,periodopagof,tipo_item,estado,tipo_mov) VALUES ('$idlist','$id','$listadocumentos[$x]','$listacentrocosto[$x]','$cupres', '$listanetoapagar[$x]','$listadevengados[$x]','','$perpagoi','$perpagof','$listatipopago[$x]','S','201')";
									$respy1=mysql_query($sqlry1,$linkbd);
									$rowy1=mysql_fetch_row($respy1);
								}	
							}
							$consid=selconsecutivo('humnomina_det','id');
							$sqlr="INSERT INTO humnomina_det (id_nom,cedulanit,salbas,diaslab,devendias,ibc,auxalim,auxtran,valhorex, totaldev,salud,saludemp,pension,pensionemp,fondosolid,retefte,otrasdeduc,totaldeduc,netopagar,estado,vac,diasarl,cajacf,sena,icbf,instecnicos,esap, tipofondopension,basepara,basearp,arp,totalsalud,totalpension,prima_navi,cc,id,tipopago,detalle,idfuncionario) VALUES ('$id', '$listadocumentos[$x]','$listasalariobasico[$x]','$listadiasliquidados[$x]','$listadevengados[$x]','$listaibc[$x]','$listaauxalimentacion[$x]', '$listaauxtrasporte[$x]','0','$listatotaldevengados[$x]','$listasaludempleado[$x]','$listasaludempresa[$x]','$listapensionempleado[$x]', '$listapensionempresa[$x]','$listafondosolidaridad[$x]','$listaretenciones[$x]','$listaotrasdeducciones[$x]','$listatotaldeducciones[$x]', '$listanetoapagar[$x]','S','1','$listadiasincapacidad[$x]','$listaccf[$x]','$listasena[$x]','$listaicbf[$x]','$listainstecnicos[$x]', '$listaesap[$x]','$listatipopension[$x]','$listabaseparafiscales[$x]','$listabasearp[$x]','$listaarp[$x]','$listasaludtotal[$x]', '$listapensiontotal[$x]','$listaprimasnavidad[$x]','$listacentrocosto[$x]','$consid','$listatipopago[$x]','$listatipomov[$x]', '$listatcodigofuncionario[$x]')";
							if (!mysql_query($sqlr,$linkbd)){$cerr+=1;}
							else{$cex+=1;}
							if($listasaludempleado[$x]>0)//********SALUD EMPLEADO *****
							{
								$idsalud=selconsecutivo('humnomina_saludpension','id');
								$sqlrins="INSERT INTO humnomina_saludpension (id_nom,tipo,empleado,tercero,cc,valor,estado,sector,id) VALUES ($id,'SE','$listadocumentos[$x]','$listadoceps[$x]','$listacentrocosto[$x]','$listasaludempleado[$x]','S','','$idsalud')";
								mysql_query($sqlrins,$linkbd);
							}
							if($listapensionempleado[$x]>0)//********PENSION EMPLEADO *****
							{
								$idsalud=selconsecutivo('humnomina_saludpension','id');					
								$sqlrins="INSERT INTO  humnomina_saludpension (id_nom,tipo,empleado,tercero,cc,valor,estado,sector,id) VALUES ($id,'PE', '$listadocumentos[$x]','$listadocafp[$x]','$listacentrocosto[$x]','$listapensionempleado[$x]','S','$listatipopension[$x]', '$idsalud')";
								mysql_query($sqlrins,$linkbd);	
							}
							if($listafondosolidaridad[$x]>0)//********FONDO SOLIDARIDAD EMPLEADO *****
							{
								$idsalud=selconsecutivo('humnomina_saludpension','id');
								$sqlrins="INSERT INTO  humnomina_saludpension (id_nom, tipo, empleado, tercero, cc, valor, estado,sector,id) VALUES ($id,'FS','$listadocumentos[$x]','$listadocafp[$x]','$listacentrocosto[$x]','$listafondosolidaridad[$x]','S','$listatipopension[$x]','$idsalud')";
								mysql_query($sqlrins,$linkbd);
							}
							if($listaretenciones[$x]>0)//********RETENCIONES *****
							{
								$sqlrxre="SELECT * FROM hum_retencionesfun WHERE docfuncionario='$listadocumentos[$x]' AND estadopago='N' AND estado='S' AND mes='$_POST[mesnomina]'";
								$respli=mysql_query($sqlrxre,$linkbd);
								while ($rowh=mysql_fetch_row($respli)) 
								{
									$iddescu=selconsecutivo('humnominaretenemp','id_des');
									$numcot=1;
									$sqlret="INSERT INTO humnominaretenemp (id_nom,id,cedulanit,fecha,descripcion,valor,ncta,estado,id_des, tipo_des) VALUES ('$id','$rowh[0]','$rowh[3]','$fechaf','RETENCIÓN $rowh[4]','$rowh[6]','$numcot','S','$iddescu','RE')";
									mysql_query($sqlret,$linkbd);
								}
							}
							if($listaotrasdeducciones[$x]>0)//********OTROS DESCUENTOS EMPLEADO *****
							{
								$sqlrxde="SELECT T1.* FROM humretenempleados T1 WHERE T1.empleado='$listadocumentos[$x]' AND T1.habilitado='H' AND T1.estado='S' AND ncuotas > (SELECT COUNT(T2.id) FROM humnominaretenemp T2 WHERE T2.cedulanit='$listaempleados[$x]' AND T2.id = T1.id )";		
								$respli=mysql_query($sqlrxde,$linkbd);
								while ($rowh=mysql_fetch_row($respli)) 
								{
									$iddescu=selconsecutivo('humnominaretenemp','id_des');
									$sqlrdes="SELECT COUNT(*) FROM humnominaretenemp WHERE cedulanit='$listadocumentos[$x]' AND id='$rowh[0]'";
									$respdes=mysql_query($sqlrdes,$linkbd);
									$rowdes=mysql_fetch_row($respdes);
									$numcot=$rowdes[0]+1;
									$sqlret="INSERT INTO humnominaretenemp (id_nom,id,cedulanit,fecha,descripcion,valor,ncta,estado,id_des, tipo_des) VALUES ($id,$rowh[0],'$rowh[4]','$fechaf','$rowh[1]','$rowh[8]','$numcot','S','$iddescu','DS')";
									mysql_query($sqlret,$linkbd);
								}
							}
							if($listasaludempresa[$x]>0)//******** SALUD EMPLEADOR *******
							{
								$idsalud=selconsecutivo('humnomina_saludpension','id');
								$sqlrins="INSERT INTO humnomina_saludpension (id_nom,tipo,empleado,tercero,cc,valor,estado,id) VALUES ($id,'SR', '$listadocumentos[$x]','$listadoceps[$x]','$listacentrocosto[$x]','$listasaludempresa[$x]','S','$idsalud')";
								mysql_query($sqlrins,$linkbd);
							}
							if($listapensionempresa[$x]>0)//******** PENSIONES EMPLEADOR *******
							{
								$idsalud=selconsecutivo('humnomina_saludpension','id');
								$sqlrins="INSERT INTO humnomina_saludpension (id_nom,tipo,empleado,tercero,cc,valor,estado,sector,id) VALUES ($id,'PR', '$listadocumentos[$x]','$listadocafp[$x]','$listacentrocosto[$x]','$listapensionempresa[$x]','S','$listatipopension[$x]','$idsalud')";
								mysql_query($sqlrins,$linkbd);							
							}
						}
						//***********PARAFISCALES ******
						$sqlr="SELECT * FROM centrocosto WHERE estado='S'";
						$rescc=mysql_query($sqlr,$linkbd);
						while ($rowcc =mysql_fetch_row($rescc)) 
						{
							if($pf[$_POST[tcajacomp]][$rowcc[0]]>0)//CAJAS DE COMPENSACION
							{
								$sqlr="SELECT DISTINCT * FROM humparafiscales_det INNER JOIN humparafiscales ON humparafiscales_det.codigo = humparafiscales.codigo WHERE humparafiscales_det.codigo='$_POST[tcajacomp]' AND humparafiscales_det.CC='$rowcc[0]' AND humparafiscales_det.vigencia = '$_POST[vigencia]'";
								$resph=mysql_query($sqlr,$linkbd);		
								while ($rowh =mysql_fetch_row($resph)) 
								{
									$sqlr="INSERT INTO humnomina_parafiscales (id_nom,id_parafiscal,porcentaje,valor,cc,estado) VALUES ($id,'$_POST[tcajacomp]',$rowh[14],".$pf[$_POST[tcajacomp]][$rowcc[0]].",'$rowcc[0]','S')";			
									mysql_query($sqlr,$linkbd);											
								}
							}
							if($pf[$_POST[ticbf]][$rowcc[0]]>0)//ICBF
							{			
								$sqlr="SELECT DISTINCT * FROM humparafiscales_det INNER JOIN humparafiscales ON humparafiscales_det.codigo=humparafiscales.codigo WHERE humparafiscales_det.codigo='$_POST[ticbf]' AND humparafiscales_det.CC='$rowcc[0]' AND humparafiscales_det.vigencia='$_POST[vigencia]'";
								$resph=mysql_query($sqlr,$linkbd);		
								while ($rowh =mysql_fetch_row($resph)) 
								{							 
									$sqlr="INSERT INTO humnomina_parafiscales (id_nom, id_parafiscal, porcentaje, valor, cc,estado) VALUES ($id,'$_POST[ticbf]',$rowh[14],".$pf[$_POST[ticbf]][$rowcc[0]].",'$rowcc[0]','S')";			
									mysql_query($sqlr,$linkbd);															   
								}		  
							}
							if($pf[$_POST[tsena]][$rowcc[0]]>0)//SENA
							{			
								$sqlr="SELECT DISTINCT * FROM humparafiscales_det INNER JOIN humparafiscales ON humparafiscales_det.codigo=humparafiscales.codigo WHERE humparafiscales_det.codigo='$_POST[tsena]' AND humparafiscales_det.CC='$rowcc[0]' AND humparafiscales_det.vigencia='$_POST[vigencia]'";
								$resph=mysql_query($sqlr,$linkbd);		
								while ($rowh =mysql_fetch_row($resph)) 
								{
									$sqlr="INSERT INTO humnomina_parafiscales (id_nom, id_parafiscal, porcentaje, valor, cc, estado) VALUES ($id,'$_POST[tsena]',$rowh[14],'".$pf[$_POST[tsena]][$rowcc[0]]."','$rowcc[0]', 'S')";			
									mysql_query($sqlr,$linkbd);																
								}
							}
							$ctacont='';
							$ctapres='';		
							if($pf[$_POST[titi]][$rowcc[0]]>0)//ITI
							{			
								$sqlr="SELECT DISTINCT * FROM humparafiscales_det INNER JOIN humparafiscales ON humparafiscales_det.codigo=humparafiscales.codigo WHERE humparafiscales_det.codigo='$_POST[titi]' AND humparafiscales_det.CC='$rowcc[0]' AND humparafiscales_det.vigencia='$_POST[vigencia]'";
								$resph=mysql_query($sqlr,$linkbd);		
								while ($rowh =mysql_fetch_row($resph)) 
								{
									$sqlr="INSERT INTO humnomina_parafiscales (id_nom, id_parafiscal, porcentaje, valor, cc, estado) VALUES ('$id','$_POST[titi]','$rowh[14]','".$pf[$_POST[titi]][$rowcc[0]]."','$rowcc[0]', 'S')";			
									mysql_query($sqlr,$linkbd);										
								}
							}
							if($pf[$_POST[tesap]][$rowcc[0]]>0)//ESAP
							{			
								$sqlr="SELECT DISTINCT * FROM humparafiscales_det INNER JOIN humparafiscales ON humparafiscales_det.codigo=humparafiscales.codigo WHERE humparafiscales_det.codigo='$_POST[tesap]' AND humparafiscales_det.CC='$rowcc[0]' AND humparafiscales_det.vigencia='$_POST[vigencia]'";
								$resph=mysql_query($sqlr,$linkbd);		
								while ($rowh =mysql_fetch_row($resph)) 
								{
									$sqlr="INSERT INTO humnomina_parafiscales (id_nom,id_parafiscal,porcentaje,valor,cc,estado) VALUES ($id,'$_POST[tesap]',$rowh[14],'".$pf[$_POST[tesap]][$rowcc[0]]."','$rowcc[0]','S')";			
									mysql_query($sqlr,$linkbd);								
								}
							}
							$ctacont='';
							$ctapres='';
							if($pf[$_POST[tarp]][$rowcc[0]]>0)//ARL
							{			
								$sqlr="SELECT DISTINCT * FROM humparafiscales_det INNER JOIN humparafiscales ON humparafiscales_det.codigo=humparafiscales.codigo WHERE humparafiscales_det.codigo='$_POST[tarp]' AND humparafiscales_det.CC='$rowcc[0]' AND humparafiscales_det.vigencia='$_POST[vigencia]'";
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
										$sqlr="INSERT INTO humnomina_parafiscales (id_nom,id_parafiscal,porcentaje,valor,cc,estado) VALUES ($id,'$_POST[tarp]',$rowh[14],$debito,'$rowcc[0]','S')";			
										mysql_query($sqlr,$linkbd);													
									}
								}
							}
						}		
						//CARGAR PRESUPUESTO
						for($rb=0;$rb<count($_POST[rubrosp]);$rb++)
						{
							$valrubros=$_POST[vrubrosp][$rb];
							$sqlrp="INSERT INTO humnom_presupuestal (id_nom,cuenta,valor,estado) VALUES ($id,'".$_POST[rubrosp][$rb]."',$valrubros,'S')";
							mysql_query($sqlrp,$linkbd);	
						}	
						echo "<script>funcionmensaje();</script>";
					}
				}//fin guardar
				elseif( $_POST[saldocuentas]=="1")
				{echo "<script>despliegamodalm('visible','2','Error, Una de las cuentas no tiene saldo disponible:');</script>";}
				
			?>
		</form>
	</body>
</html>