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
		<script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
        <script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
		<script src="css/funciones.js"></script>
		<script>
			//************* FUNCIONES ************
			function despliegamodal2(_valor,_pag)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else if(_pag=="1"){document.getElementById('ventana2').src="hum-nnomina.php";}
			}
		
			function despliegamodalm(_valor,_tip,mensa,pregunta, variable)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden")
				{
					document.getElementById('ventanam').src="";
					switch(document.getElementById('valfocus').value)
					{
						case "1":	document.getElementById('docum').focus();
									document.getElementById('docum').select();
									break;
					}
					document.getElementById('valfocus').value='0';
				}
				else
				{
					switch(_tip)
					{
						case "1":	document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
						case "2":	document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
						case "3":	document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
						case "4":	document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;	
						case "5":	document.getElementById('ventanam').src= "ventana-elimina1.php?titulos="+mensa+"&idresp="+pregunta+"&variable="+variable;break;	
					}
				}
			}
			function respuestaconsulta(pregunta, variable)
			{
				switch(pregunta)
				{
					case "1":	
						document.getElementById('oculto').value="2";
						document.form2.submit();
						break;
					case "2":
						document.form2.elimina.value=variable;
						vvend=document.getElementById('elimina');
						vvend.value=variable;
						document.form2.sw.value=document.getElementById('tipomov').value ;
						document.form2.submit();
						break;
				}
			}
			function funcionmensaje(){}
			function validar(){document.form2.oculto.value=2;document.form2.submit();}
			
			
			
			function pdf(idnomp,mesp,vigenp,tercerop,totalpagop,diaslabp,salbasicp,auxalimp,auxtranp,devenp,horaxp,saludp,pensionp,fondosp,retep)
			{
				document.getElementById('pdfidnom').value=idnomp;
				document.getElementById('pdfmes').value=mesp;
				document.getElementById('pdfvigen').value=vigenp;
				document.getElementById('pdftercero').value=tercerop;
				document.getElementById('pdftotalpago').value=totalpagop;
				document.getElementById('pdfdiaslab').value=diaslabp;
				document.getElementById('pdfsalbasico').value=salbasicp;
				document.getElementById('pdfauxali').value=auxalimp;
				document.getElementById('pdfauxtran').value=auxtranp;
				document.getElementById('pdfdeveng').value=devenp;
				document.getElementById('pdfhorax').value=horaxp;
				document.getElementById('pdfsalud').value=saludp;
				document.getElementById('pdfpension').value=pensionp;
				document.getElementById('pdffondos').value=fondosp;
				document.getElementById('pdfrete').value=retep;
				document.form2.action="pdfdescnomina.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function pdf2(){
				document.form2.action="pdfdescnominageneral.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function excel(){
				document.form2.action="hum-reportedescuentosnomxls.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function buscater(e)
			{
				if (document.form2.tercero.value!=""){document.form2.bt.value='1';document.form2.submit();}
				else{document.form2.ntercero.value=""}
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
  				<td colspan="3" class="cinta"><img src="imagenes/add2.png" class="mgbt1"/><img src="imagenes/guardad.png" class="mgbt1"/><img src="imagenes/buscad.png" class="mgbt1"/><img src="imagenes/nv.png" title="Nueva Ventana" onClick="mypop=window.open('hum-principal.php','','');mypop.focus();" class="mgbt"><?php if($_POST[nnomina]!='' || $_POST[vigencias]!=''){ echo "<img src='imagenes/print.png' onClick=\"pdf2();\" title='Imprimir' class='mgbt'/>"; } else {echo "<img src='imagenes/print_off.png' class='mgbt1'/>";} ?><img <?php if($_POST[nnomina]!='' || $_POST[vigencias]!=''){ echo "onClick=\"excel();\""; } ?> src="imagenes/csv.png"  title="csv" class='mgbt'/></td>
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
	  		$vact=$vigusu;
			if(!$_POST[oculto])
			{

			}
  			//***** busca tercero
			if($_POST[bt]=='1')
			{
				$nresul=buscatercero($_POST[tercero]);
			  	if($nresul!=''){$_POST[ntercero]=$nresul;}
			 	else{$_POST[ntercero]="";}
			}
	   ?>
        <input name="pdfidnom" id="pdfidnom" type="hidden" value="<?php echo $_POST[pdfidnom];?>">
        <input name="pdfmes" id="pdfmes" type="hidden" value="<?php echo $_POST[pdfmes];?>">
        <input name="pdfvigen" id="pdfvigen" type="hidden" value="<?php echo $_POST[pdfvigen];?>">
        <input name="pdftercero" id="pdftercero" type="hidden" value="<?php echo $_POST[pdftercero];?>">
        <input name="pdftotalpago" id="pdftotalpago" type="hidden" value="<?php echo $_POST[pdftotalpago];?>">
        <input name="pdfdiaslab" id="pdfdiaslab" type="hidden" value="<?php echo $_POST[pdfdiaslab];?>">
        <input name="pdfsalbasico" id="pdfsalbasico" type="hidden" value="<?php echo $_POST[pdfsalbasico];?>">
        <input name="pdfauxali" id="pdfauxali" type="hidden" value="<?php echo $_POST[pdfauxali];?>">
        <input name="pdfauxtran" id="pdfauxtran" type="hidden" value="<?php echo $_POST[pdfauxtran];?>">
        <input name="pdfdeveng" id="pdfdeveng" type="hidden" value="<?php echo $_POST[pdfdeveng];?>">
        <input name="pdfhorax" id="pdfhorax" type="hidden" value="<?php echo $_POST[pdfhorax];?>">
        <input name="pdfsalud" id="pdfsalud" type="hidden" value="<?php echo $_POST[pdfsalud];?>">
        <input name="pdfpension" id="pdfpension" type="hidden" value="<?php echo $_POST[pdfpension];?>">
        <input name="pdffondos" id="pdffondos" type="hidden" value="<?php echo $_POST[pdffondos];?>">
        <input name="pdfrete" id="pdfrete" type="hidden" value="<?php echo $_POST[pdfrete];?>">
		<table class="inicio">
			<tr>
            	<td colspan="10" class="titulos" style='width:93%'>Detalle Descuentos de Nomina</td>
                <td class="cerrar" style='width:7%'><a href="hum-principal.php">Cerrar</a></td>
			</tr>                  
			<tr>
            	<td class="saludo1" style='width:7%'> N&deg; N&oacute;mina:</td>
          		<td width="5%">
                	<input id="nnomina" type="text" name="nnomina"  onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo $_POST[nnomina]?>" style='width:60%'>
                    &nbsp;<a href="#" onClick="despliegamodal2('visible','1');"><img src="imagenes/buscarep.png" style='width:16px'></a>
               	</td>
	  			<td class="saludo1" style='width:5%'>Vigencia:</td>
	 			<td style='width:5%'>      
                	<input type="text" name="vigencias" id="vigencias" style="width:80%" value="<?php echo $_POST[vigencias] ?>" readonly>
				</td>
				<td class="saludo1" style='width:3%'>Mes:</td>
          		<td style='width:5%'>
                	<input type="text" name="periodo" id="periodo" style="width:100%" value="<?php echo $_POST[periodo] ?>" readonly>
                  	<input name="mes" id="mes" type="hidden" value="<?php echo $_POST[mes]; ?>"> 
                  	<input name="oculto" id="oculto" type="hidden" value="1"> 
          		</td>
            	<td class="saludo1" style='width:5%'>Tercero:</td>
          		<td style="width:10%"><input id="tercero" type="text" name="tercero"  onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo $_POST[tercero]?>" onClick="document.getElementById('tercero').focus();document.getElementById('tercero').select();" style='width:80%'><input type="hidden" value="0" name="bt">&nbsp;<a href="#" onClick="mypop=window.open('tercerosnom-ventana.php','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=900,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" style='width:16px'></a></td>
          		<td style='width:30%'><input name="ntercero" type="text" value="<?php echo $_POST[ntercero]?>"  readonly style='width:95%'>
                </td>	       
          		<td style='width:5%'>
                    <input type="button" name="buscar" value="Buscar " onClick="validar()">
          		</td>
			</tr>
		</table>  
		<div class="subpantalla" style="height:68.5%; width:99.6%; overflow-x:hidden;">
	 	<?php
			//**** busca cuenta
			if($_POST[bc]!='')
			{
				$nresul=buscacuenta($_POST[cuenta]);
			  	if($nresul!='')
			   	{
			  		$_POST[ncuenta]=$nresul;
  			 		?><script>
						document.getElementById('cuentap').focus();
					  	document.getElementById('cuentap').select();
					  	document.getElementById('bc').value='';
			  		</script><?php
			  	}
			 	else
			 	{
			  		$_POST[ncuenta]="";
			  		?><script>alert("Cuenta Incorrecta");document.form2.cuenta.focus();</script><?php
			  	}
			}
			//***** busca tercero
			if($_POST[bt]=='1')	{
				$nresul=buscatercero($_POST[tercero]);
			  	if($nresul!='')	{
			  		$_POST[ntercero]=$nresul;
  					?><script>
			  			document.getElementById('retencion').focus();document.getElementById('retencion').select();
                	</script><?php
			  	}
			 	else{
			  		$_POST[ntercero]="";
			  		?><script>
						alert("Tercero Incorrecto o no Existe");				  
		  				document.form2.tercero.focus();	
			  		</script><?php
			  	}
			}
			if($_POST[oculto]==2 && ($_POST[tercero]!='' || $_POST[nnomina]!='' || $_POST[vigencias]!='')){
				if($_POST[tercero]!=''){
				echo "<table class='inicio'>
				<tr><td colspan='10' class='titulos'>Nominas Liquidadas</td></tr>
				<tr>
					<td>
						<img id='img".$np."' src='imagenes/plus.gif'>
					</td>
					<td class='titulos2'>No N&oacute;mina</td>
					<td class='titulos2'>Mes</td>
					<td class='titulos2'>Vigencia</td>
					<td class='titulos2'>D&iacute;as Lab</td>
					<td class='titulos2'>Devengado</td>
					<td class='titulos2'>Total Deducciones</td>
					<td class='titulos2'>Total Pago</td>
					<td class='titulos2' style='text-align:center;'>Ver</td>
				</tr>";
				$criterio="";
				$criterio2="";	
				$criterio3="";
				if($_POST[vigencias]!=""){$criterio=" AND hm.vigencia='$_POST[vigencias]' ";}
				if($_POST[mes]!=""){$criterio2=" AND hm.mes='$_POST[mes]' ";}
				if($_POST[nnomina]!=""){$criterio3="AND hm.id_nom='$_POST[nnomina]' ";}

				$sqlr="SELECT hm.id_nom,hm.mes,hm.vigencia,ht.netopagar,ht.diaslab,ht.devendias,ht.auxalim,ht.auxtran,ht.totaldeduc, ht.netopagar, ht.salbas,ht.valhorex,ht.salud,ht.pension,ht.fondosolid,ht.retefte,ht.cedulanit FROM humnomina hm,humnomina_det ht WHERE hm.id_nom=ht.id_nom AND ht.cedulanit='".$_POST[tercero]."' ".$criterio.$criterio2.$criterio3." AND hm.estado <> 'N' ORDER BY hm.id_nom DESC";
				//echo $sqlr;
				$resp = mysql_query($sqlr,$linkbd);
				$co="saludo1a";
				$co2="saludo2";
				$np=1;
				while ($row =mysql_fetch_row($resp)){
					$lastday = mktime (0,0,0,$row[1],1,$row[2]);
					$vmes=ucwords(strftime('%B',$lastday));		
					$ord="'".$row[0]."'";
					$tot="'".$row[16]."'";
					echo "<tr class='$co' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
	onMouseOut=\"this.style.backgroundColor=anterior\" style='text-transform:uppercase'>
						<td class='titulos2'>
							<a onClick=\"verDetalleDescNom($np, $ord, $tot)\" style='cursor:pointer;'>
								<img id='img".$np."' src='imagenes/plus.gif'>
							</a>
						</td>
						<td>$row[0]</td>
						<td>$vmes</td>
						<td>$row[2]</td>
						<td>$row[4]</td>
						<td style='text-align:right;'>".number_format($row[5],2,",",".")."</td>
						<td style='text-align:right;'>".number_format($row[6],2,",",".")."</td>
						<td style='text-align:right;'>".number_format($row[3],2,",",".")."</td>
						<td style='text-align:center;'>
							<a href='#' onClick=\"pdf('$row[0]','$vmes','$row[2]','$row[16]','$row[3]','$row[4]','$row[10]', '$row[6]','$row[7]','$row[5]','$row[11]','$row[12]','$row[13]','$row[14]','$row[15]')\"><img src='imagenes/buscarep.png'></a>
						</td>
					</tr>
					<tr>
						<td align='center'></td>
						<td colspan='7' align='right'>
							<div id='detalle".$np."' style='display:none'></div>
						</td>
					</tr>";
					$aux=$co;
					$co=$co2;
					$co2=$aux;
					$np++;
				}
			}
			else{
				echo "<table class='inicio'>
					<tr><td colspan='10' class='titulos'>Nominas Liquidadas</td></tr>
					<tr>
						<td class='titulos2'>
							<img id='img".$np."' src='imagenes/plus.gif'>
						</td>
						<td class='titulos2'>No N&oacute;mina</td>
						<td class='titulos2'>Mes</td>
						<td class='titulos2'>Vigencia</td>
						<td class='titulos2'>Empleado</td>
						<td class='titulos2'>D&iacute;as Lab</td>
						<td class='titulos2'>Devengado</td>
						<td class='titulos2'>Total Deducciones</td>
						<td class='titulos2' style='text-align:right;'>Total Pago</td>
						<td class='titulos2' style='text-align:center;'>Ver</td>
					</tr>";
					$criterio="";
					$criterio2="";	
					$criterio3="";	
					if($_POST[vigencias]!=""){$criterio=" AND hm.vigencia='$_POST[vigencias]' ";}
					if($_POST[mes]!=""){$criterio2=" AND hm.mes='$_POST[mes]' ";}
					if($_POST[nnomina]!=""){$criterio3="AND hm.id_nom='$_POST[nnomina]' ";}
					$sqlr="SELECT hm.id_nom,hm.mes,hm.vigencia,ht.netopagar,ht.diaslab,ht.devendias,ht.auxalim,ht.auxtran,ht.totaldeduc, ht.netopagar, ht.salbas,ht.valhorex,ht.salud,ht.pension,ht.fondosolid,ht.retefte,ht.cedulanit FROM humnomina hm,humnomina_det ht WHERE hm.id_nom=ht.id_nom ".$criterio.$criterio2.$criterio3." AND hm.estado <> 'N' ORDER BY hm.id_nom DESC";
					//echo $sqlr;
					$resp = mysql_query($sqlr,$linkbd);
					$co="saludo1a";
					$co2="saludo2";
					$np=1;
					while ($row =mysql_fetch_row($resp)){
						$lastday = mktime (0,0,0,$row[1],1,$row[2]);
						$vmes=ucwords(strftime('%B',$lastday));	
						$nresult=buscatercero($row[16]);	
						$ord="'".$row[0]."'";
						$tot="'".$row[16]."'";
						echo "<tr class='$co' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
	onMouseOut=\"this.style.backgroundColor=anterior\" style='text-transform:uppercase'>
							<td class='titulos2'>
								<a onClick=\"verDetalleDescNom($np, $ord, $tot)\" style='cursor:pointer;'>
									<img id='img".$np."' src='imagenes/plus.gif'>
								</a>
							</td>
							<td>$row[0]</td>
							<td>$vmes</td>
							<td>$row[2]</td>
							<td>$nresult</rd>
							<td>$row[4]</td>
							<td style='text-align:right;'>".number_format($row[5],2,",",".")."</td>
							<td style='text-align:right;'>".number_format($row[8],2,",",".")."</td>
							<td style='text-align:right;'>".number_format($row[3],2,",",".")."</td>
							<td style='text-align:center;'>
								<a href='#' onClick=\"pdf('$row[0]','$vmes','$row[2]','$row[16]','$row[3]','$row[4]','$row[10]', '$row[6]','$row[7]','$row[5]','$row[11]','$row[12]','$row[13]','$row[14]','$row[15]')\"><img src='imagenes/buscarep.png'></a>
							</td>
						</tr>
						<tr>
							<td align='center'></td>
							<td colspan='7' align='right'>
								<div id='detalle".$np."' style='display:none'></div>
							</td>
						</tr>";
						$aux=$co;
						$co=$co2;
						$co2=$aux;
						$np++;
					}
				}
				echo "</table>";	
			}
			echo $matnomina[0][4];
			

		?>
        </div>

	<div id="bgventanamodal2">
    	<div id="ventanamodal2">
        	<IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
            </IFRAME>
		</div>
	</div>

		</form>
        
	</body>
</html>