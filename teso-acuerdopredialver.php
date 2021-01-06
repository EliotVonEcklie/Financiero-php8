<?php //V 1000 12/12/16 ?> 
<?php
	require "comun.inc";
	require "funciones.inc";
	require "conversor.php";
	setlocale(LC_ALL,"es_ES");
	//session_start();
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
		<title>:: SPID - Tesoreria</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <link href="css/tabs.css" rel="stylesheet" type="text/css" />
   		<script type="text/javascript" src="css/programas.js"></script>
        <script type="text/javascript" src="css/calendario.js"></script>
		<script>
			function validar(){document.form2.submit();}
			function guardar()
			{
				vvigencias=document.getElementsByName('dselvigencias[]');
				var banche=0;
				for(x=0;x<vvigencias.length;x++){if(vvigencias.item(x).checked){banche=1;}}
				if (banche!=0)
				{
	
					if (document.form2.fecha.value!='' && document.form2.fechaav.value!='' && document.form2.vigencia.value!='' && document.form2.cuotas.value!='')
					{despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
					else {despliegamodalm('visible','2','Faltan datos para completar el registro');}
				}
				else{despliegamodalm('visible','2','Faltan elegir un periodo a liquidar');}
			}
			function pdf()
			{
				document.form2.action="pdfacuerdo.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function buscar()
 			{
 				document.form2.buscav.value='1';
 				document.form2.submit();
 			}
			function buscavigencias(objeto,posicion)
 			{
				vvigencias=document.getElementsByName('dselvigencias[]');
				vtotalpred=document.getElementsByName("dpredial[]"); 	
				vtotaliqui=document.getElementsByName("dhavaluos[]"); 	
				vtotalbomb=document.getElementsByName("dimpuesto1[]"); 	
				vtotalmedio=document.getElementsByName("dimpuesto2[]"); 	
				vtotalintp=document.getElementsByName("ditpredial[]"); 	
				vtotalintb=document.getElementsByName("dinteres1[]"); 	
				vtotalintma=document.getElementsByName("dinteres2[]"); 	
				vtotaldes=document.getElementsByName("ddescuentos[]"); 	
				sumar=0;
				sumarp=0;
				sumarb=0;
				sumarma=0;
				sumarint=0;
				sumarintp=0;
				sumarintb=0;
				sumarintma=0;
				sumardes=0;
				totalceldas=vvigencias.length;
				if(objeto.checked){for(x=0;x<posicion;x++){vvigencias.item(x).checked=true;}}
				else {for(x=posicion;x<totalceldas;x++){vvigencias.item(x).checked=false;}}
				for(x=0;x<vvigencias.length;x++)
 				{
	 				if(vvigencias.item(x).checked)
	 				{
	 					sumar=sumar+parseFloat(vtotaliqui.item(x).value);
				 		sumarp=sumarp+parseFloat(vtotalpred.item(x).value);
				 		sumarb=sumarb+parseFloat(vtotalbomb.item(x).value);
				 		sumarma=sumarma+parseFloat(vtotalmedio.item(x).value);
				 		sumarint=sumarint+parseFloat(vtotalintp.item(x).value)+parseFloat(vtotalintb.item(x).value)+parseFloat(vtotalintma.item(x).value);
						sumarintp=sumarintp+parseFloat(vtotalintp.item(x).value);
				 		sumarintb=sumarintb+parseFloat(vtotalintb.item(x).value);
				 		sumarintma=sumarintma+parseFloat(vtotalintma.item(x).value);	 	 
				 		sumardes=sumardes+parseFloat(vtotaldes.item(x).value);
	 				}
 				}
				document.form2.totliquida.value=sumar;
				document.form2.totliquida2.value=sumar;
				document.form2.totpredial.value=sumarp;
				document.form2.totbomb.value=sumarb;
				document.form2.totamb.value=sumarma;
				document.form2.totint.value=sumarint;
				document.form2.intpredial.value=sumarintp;
				document.form2.intbomb.value=sumarintb;
				document.form2.intamb.value=sumarintma;
				document.form2.totdesc.value=sumardes;
				document.form2.submit();
 			}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden") {document.getElementById('ventanam').src="";}
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
			function funcionmensaje(){document.location.href = "teso-acuerdopredial.php";}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.form2.oculto.value=2;
								document.form2.submit();
								break;
				}
			}
			function despliegamodal2(_valor)
			{
				
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else {document.getElementById('ventana2').src="catastral-ventana01.php";}
				
			}
		
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("teso");?></tr>
			<tr>
  				<td colspan="3" class="cinta"><a class="mgbt" onClick="location.href='teso-acuerdopredial.php'"><img src="imagenes/add.png" title="Nuevo"/></a><a class="mgbt" ><img src="imagenes/guardad.png" title="Guardar" /></a><a class="mgbt" onClick="location.href='teso-buscaacuerdopredial.php'" ><img src="imagenes/busca.png" title="Buscar" /></a><a onClick="<?php echo paginasnuevas("teso");?>" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a><a onClick="pdf()" class="mgbt"><img src="imagenes/print.png"  title="Imprimir" style="width:29px;height:25px;"/></a><a href="teso-buscaacuerdopredial.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a></td>
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
				verificavigencia();
				$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
				$vigencia=$vigusu;
				if(0<diferenciamesesfechas_f2($_POST[fechaav],$_POST[fecha]))
				{
 					echo"<script>despliegamodalm('visible','2','La fecha de pago de liquidación no puede ser mayor a la fecha actual');</script>";
					$_POST[fechaav]=$_POST[fecha];
				}
	  			//*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
				if(!$_POST[oculto])
				{
					$sqlr="SELECT valor_inicial,valor_final, tipo FROM dominios WHERE nombre_dominio='BASE_PREDIAL' ";
					$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res)){$_POST[basepredial]=$row[0];}
					$sqlr="SELECT valor_inicial,valor_final, tipo FROM dominios WHERE nombre_dominio='BASE_PREDIALAMB' ";
					$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res)){$_POST[basepredialamb]=$row[0];}
	 				$sqlr="SELECT valor_inicial,valor_final, tipo FROM dominios WHERE nombre_dominio='NORMA_PREDIAL' ";
					$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res)){$_POST[aplicapredial]=$row[0];}
					$sqlr="SELECT valor_inicial,valor_final, tipo FROM dominios WHERE nombre_dominio='DESC_INTERESES' ";
					$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res)) 
					{
	 					$_POST[vigmaxdescint]=$row[0];
 	 					$_POST[porcdescint]=$row[1];
	 					$_POST[aplicadescint]=$row[2];
					}
	 		 		$fec=date("d/m/Y");
		 			$_POST[fecha]=$fec; 		
		 			$_POST[fechaav]=$_POST[fecha]; 		  			 
 					$_POST[vigencia]=$vigusu; 		
					$check1="checked";
					$sqlr="SELECT * FROM tesotasainteres WHERE vigencia='$vigusu'";
					$res=mysql_query($sqlr,$linkbd);
					$r=mysql_fetch_row($res);
					$tasam=array();
					$tasam[0]=$r[14];									
					$tasam[1]=$r[15];
					$tasam[2]=$r[16];
					$tasam[3]=$r[17];
					$tasamoratoria[0]=0;
					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
					//$fechaactual=$fecha[3]."-".$fecha[2]."-".$fecha[1];
					//$fecha[2]=round($fecha[2],0);
					//echo "<br>ve:".round($fecha[2],0);
					if($fecha[2]<=3){$tasamoratoria[0]=$tasam[0];}
					elseif($fecha[2]<=6){$tasamoratoria[0]=$tasam[1];}
					elseif($fecha[2]<=9){$tasamoratoria[0]=$tasam[2];}
					else{$tasamoratoria[0]=$tasam[3];}						
					$_POST[tasamora]=$tasamoratoria[0];   
					if($_POST[tasamora]==0)
					{echo "<script>despliegamodalm('visible','2','LA TASA DE INTERES DE MORA ES CERO (0) POR FAVOR ACTUALIZAR EL VALOR');</script>";}
					$_POST[tasa]=0;
					$_POST[predial]=0;
					$_POST[descuento]=0;
			 		$condes=0;
					//***** BUSCAR FECHAS DE INCENTIVOS
					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
					$fechaactual=$fecha[3]."-".$fecha[2]."-".$fecha[1];	
					$sqlr="SELECT * FROM tesodescuentoincentivo WHERE vigencia='$vigusu' AND ingreso='01' AND estado='S'";
					$res=mysql_query($sqlr,$linkbd);
					while($r=mysql_fetch_row($res))
					{	
			  			if($r[7]<=$fechaactual && $fechaactual <= $r[8]){$_POST[descuento]=$r[2];$condes=1;}
						elseif($fechaactual>$r[9] && $fechaactual <= $r[10]){$_POST[descuento]=$r[3];$condes=1;}
						elseif($fechaactual>$r[11] && $fechaactual <= $r[12]){$_POST[descuento]=$r[4];$condes=1;} 
						elseif($fechaactual>$r[19] && $fechaactual <= $r[20]){$_POST[descuento]=$r[16];$condes=1;} 
						elseif($fechaactual>$r[21] && $fechaactual <= $r[22]){$_POST[descuento]=$r[17];$condes=1;} 
						elseif($fechaactual>$r[23] && $fechaactual <= $r[24]){$_POST[descuento]=$r[18];$condes=1;} 
						else 
						{
							if($r[24]!="0000-00-00"){$ulfedes=explode("-",$r[24]);}
							elseif($r[22]!="0000-00-00"){$ulfedes=explode("-",$r[22]);}
							elseif($r[20]!="0000-00-00"){$ulfedes=explode("-",$r[20]);}
							elseif($r[12]!="0000-00-00"){$ulfedes=explode("-",$r[12]);}
							elseif($r[10]!="0000-00-00"){$ulfedes=explode("-",$r[10]);}
							else {$ulfedes=explode("-",$r[8]);} 
						}
					}
					//*************cuenta caja
					$sqlr="select valor_inicial from dominios where nombre_dominio='CUENTA_CAJA'";
					$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res)){$_POST[cuentacaja]=$row[0];}
					$sqlr="select max(numerotipo) from comprobante_cab where tipo_comp='8' ";
					$res=mysql_query($sqlr,$linkbd);
					$consec=0;
					while($r=mysql_fetch_row($res)){$consec=$r[0];}
	 				$consec+=1;
	 				$_POST[idcomp]=$consec;	
 		 			$fec=date("d/m/Y");
					$_POST[fecha]=$fec; 	
		 			$_POST[fechaav]=$fec; 		 		  			 
					$_POST[valor]=0;		 
				}
				else
				{
					$sqlr="select *from tesotasainteres where vigencia='$vigusu'";
					$res=mysql_query($sqlr,$linkbd);
					$r=mysql_fetch_row($res);
					$tasam=array();
					$tasam[0]=$r[14];									
					$tasam[1]=$r[15];
					$tasam[2]=$r[16];
					$tasam[3]=$r[17];
					$tasamoratoria[0]=0;
					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechaav],$fecha);
					//$fechaactual=$fecha[3]."-".$fecha[2]."-".$fecha[1];
					//echo $fecha[2];
					if($fecha[2]<=3){$tasamoratoria[0]=$tasam[0];}
					elseif($fecha[2]<=6){$tasamoratoria[0]=$tasam[1];}
					elseif($fecha[2]<=9){$tasamoratoria[0]=$tasam[2];}
					else{$tasamoratoria[0]=$tasam[3];}						
					$_POST[tasamora]=$tasamoratoria[0]; 
					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechaav],$fecha);
					$fechaactual=$fecha[3]."-".$fecha[2]."-".$fecha[1];	
					$condes=0;
					$sqlr="SELECT * FROM tesodescuentoincentivo WHERE vigencia='$vigusu' and ingreso='01' and estado='S'";
					$res=mysql_query($sqlr,$linkbd);
					while($r=mysql_fetch_row($res))
					{	
			 			if($r[7]<=$fechaactual && $fechaactual <= $r[8]){$_POST[descuento]=$r[2];$condes=1;}
						elseif($fechaactual>$r[9] && $fechaactual <= $r[10]){$_POST[descuento]=$r[3];$condes=1;}
						elseif($fechaactual>$r[11] && $fechaactual <= $r[12]){$_POST[descuento]=$r[4];$condes=1;} 
						elseif($fechaactual>$r[19] && $fechaactual <= $r[20]){$_POST[descuento]=$r[16];$condes=1;} 
						elseif($fechaactual>$r[21] && $fechaactual <= $r[22]){$_POST[descuento]=$r[17];$condes=1;} 
						elseif($fechaactual>$r[23] && $fechaactual <= $r[24]){$_POST[descuento]=$r[18];$condes=1;} 
						else 
						{
							if($r[24]!="0000-00-00"){$ulfedes=explode("-",$r[24]);}
							elseif($r[22]!="0000-00-00"){$ulfedes=explode("-",$r[22]);}
							elseif($r[20]!="0000-00-00"){$ulfedes=explode("-",$r[20]);}
							elseif($r[12]!="0000-00-00"){$ulfedes=explode("-",$r[12]);}
							elseif($r[10]!="0000-00-00"){$ulfedes=explode("-",$r[10]);}
							else {$ulfedes=explode("-",$r[8]);} 
						}
					}
				}
				switch($_POST[tabgroup1])
				{
					case 1:	$check1='checked';break;
					case 2:	$check2='checked';break;
					case 3:	$check3='checked';
				}
				$_POST[numacuerdo]=$_GET[idacuerdo];
				$sql="SELECT * FROM tesoacuerdopredial WHERE idacuerdo=$_POST[numacuerdo]";
				$res=mysql_query($sql,$linkbd);
				$fila=mysql_fetch_row($res);
				$_POST[codcat]=$fila[1];
				$_POST[fecha]=$fila[5];
				$_POST[fechaav]=$fila[6];
				$_POST[cuotas]=$fila[4];
				$_POST[totliquida]=$fila[7];
				if($_POST[codcat]!='')
 				{
					if ($_POST[ord]=='' && $_POST[tot]=='')
					{
						$sqlr="SELECT ord,tot FROM tesoprediosavaluos WHERE codigocatastral='$_POST[codcat]'";
						$rowot=mysql_fetch_row(mysql_query($sqlr,$linkbd));
						$_POST[ord]=$rowot[0];
						$_POST[tot]=$rowot[1];
						echo "<script>document.form2.ord.value=$rowot[0];document.form2.tot.value=$rowot[1];</script>";
					}
	 				$_POST[dcuentas]=array();
	 				$_POST[dncuentas]=array();
	 				$_POST[dtcuentas]=array();		 
	 				$_POST[dvalores]=array();
	 				$sqlr="SELECT * FROM tesopredios WHERE cedulacatastral='$_POST[codcat]' AND ord='$_POST[ord]' AND tot='$_POST[tot]'";
	 				$res=mysql_query($sqlr,$linkbd);
	 				while($row=mysql_fetch_row($res))
	  				{
		  				$_POST[catastral]=$row[0];
		  				$_POST[ntercero]=$row[6];
		  				$_POST[tercero]=$row[5];
		  				$_POST[direccion]=$row[7];
		  				$_POST[ha]=$row[8];
		  				$_POST[mt2]=$row[9];
		  				$_POST[areac]=$row[10];
		  				$_POST[avaluo]=number_format($row[11],2);
		  				$_POST[avaluo2]=number_format($row[11],2);
		 				$_POST[vavaluo]=$row[11];
		  				$_POST[tipop]=$row[14];
		  				if($_POST[tipop]=='urbano')
						{
							$_POST[estrato]=$row[15];
							$tipopp=$row[15];
						}
						else
						{
							$_POST[rangos]=$row[15];
							$tipopp=$row[15];
						}
						// $_POST[dcuentas][]=$_POST[estrato];		
						$_POST[dtcuentas][]=$row[1];		 
						$_POST[dvalores][]=$row[5];
						$_POST[buscav]="";
						$sqlr2="SELECT * FROM tesotarifaspredial WHERE vigencia='$vigusu' AND tipo='$_POST[tipop]' AND estratos=$tipopp";
						$res2=mysql_query($sqlr2,$linkbd);
						while($row2=mysql_fetch_row($res2))
						{
							$_POST[tasa]=$row2[5];
							$_POST[predial]=($row2[5]/1000)*$_POST[vavaluo];
							$_POST[predial]=number_format($_POST[predial],2);
						}
					}
				}
			?>
 			<div class="tabspre" style="width:99.6%;">
   				<div class="tab">
       				<input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
	   				<label for="tab-1">Acuerdo Predial</label>
	   				<div class="content" style="overflow-x:hidden;">
           				<table class="inicio" align="center" >
      						<tr>
        						<td class="titulos" colspan="10">Acuerdo Predial</td>
                                <td class="cerrar" style="width:7%;"><a onClick="location.href='teso-principal.php'">&nbsp;Cerrar</a></td>
      						</tr>
     						<tr>
                            	<td class="saludo1" style="width:12%;">No Acuerdo:</td>
                                <td style="width:8%;">
									<input type="text" name="numacuerdo" value="<?php echo $_POST[numacuerdo]?>" readonly/></td>
                                <td class="saludo1" style="width:12%;" >Fecha de Acuerdo:</td>
                                <td style="width:10%;">
									<input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" id="fc_1198971547" title="DD/MM/YYYY" style="width:80%;" readonly>&nbsp;<a style="cursor:pointer;"><img src="imagenes/calendario04.png" style="width:20px;"/></a>
								</td>
                                <td class="saludo1" style="width:6%;">Vigencia:</td>
                                <td style="width:8%;">
									<input name="vigencia" type="text" value="<?php echo $_POST[vigencia]?>" style="width:70%;" readonly></td>
                               
                     		</tr>
	  						<tr>
      							<td class="saludo1" style="width:12%;">Fecha M&aacute;xima de Pago:</td>
                                <td style="width:8%;">
									<input name="fechaav" type="text" value="<?php echo $_POST[fechaav]?>"  id="fc_1198971545" title="DD/MM/YYYY" style="width:80%;" readonly>&nbsp;<a  style="cursor:pointer;"><img src="imagenes/calendario04.png" style="width:20px;"></a></td> 
                                <td style="width:12%;" class="saludo1">Codigo Catastral:</td>
          							<td colspan="2" >
									<input id="codcat" type="text" name="codcat"  onKeyUp="return tabular(event,this)" onBlur="buscar(event)" value="<?php echo $_POST[codcat]?>" style="width:50%;" readonly>
									<input id="ord" type="text" name="ord" value="<?php echo $_POST[ord]?>" style="width:19%;" readonly>
									<input id="tot" type="text" name="tot" value="<?php echo $_POST[tot]?>" style="width:19%;" readonly>&nbsp;<a title="Listado de Predios"  style="cursor:pointer;"><img src="imagenes/find02.png" style="width:20px;"></a></td>
                                <input type="hidden" name="chacuerdo" value="1">
                                <input type="hidden" name="bt" id="bt" value="0"/> 
                                <input type="hidden" name="oculto" id="oculto" value="1"/>
                                <input type="hidden" name="basepredial" value="<?php echo  $_POST[basepredial] ?>"/>
                                <input type="hidden" name="basepredialamb" value="<?php echo  $_POST[basepredialamb] ?>"/>
                                <input type="hidden" name="aplicapredial" value="<?php echo  $_POST[aplicapredial] ?>"/>
                                <input type="hidden" name="vigmaxdescint" value="<?php echo  $_POST[vigmaxdescint] ?>"/>
                                <input type="hidden" name="porcdescint" value="<?php echo  $_POST[porcdescint] ?>"/>
                                <input type="hidden" name="aplicadescint" value="<?php echo  $_POST[aplicadescint] ?>"/>
                                <input type="hidden" name="buscav" value="<?php echo $_POST[buscav]?>"/>
                                <td></td>
        					</tr>
        					<tr>
                            	<td class="saludo1">Avaluo Vigente:</td>
                                <td><input name="avaluo2" value="<?php echo $_POST[avaluo2]?>" type="text" readonly><input type="hidden" name="vavaluo"  value="<?php echo $_POST[vavaluo]?>" ></td>
                                <td class="saludo1">Tasa Predial	:</td>
                                <td><input name="tasa" value="<?php echo $_POST[tasa]?>" type="text" style="width:40%;" readonly>xmil</td>
                                
                                <input name="predial" value="<?php echo $_POST[predial]?>" type="hidden"  readonly>
                                <td class="saludo1" style="width:10%;">Deduccion Ajuste:</td>
								<td style="width:8%;">
									<input name="deduccion" value="<?php echo $_POST[deduccion]?>" type="text"  style="width:70%;" readonly></td>
                      		</tr>
                            <tr>
                            	<td class="saludo1">No. Cuotas: </td>
                                <td><input type="number" name="cuotas" id="cuotas" value="<?php echo $_POST[cuotas] ?>" readonly></td>
								 <td class="saludo1" style="width:12%;">Tasa Interes Mora:</td>
                                <td style="width:8%;">
									<input name="tasamora" type="text" value="<?php echo $_POST[tasamora]?>" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" style="width:50%;" readonly>%</td>
    							<td class="saludo1" style="width:10%;">Descuento:</td>
    							<td style="width:7%;">
									<input name="descuento" type="text" value="<?php echo $_POST[descuento]?>"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" style="width:70%;" readonly>%</td >
                            </tr>
	  					</table>
					</div> 
				</div>
     			<div class="tab">
       				<input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?>>
       				<label for="tab-2">Informacion Predio</label>
       				<div class="content" style="overflow-x:hidden;"> 
                    	<input type="hidden" name="nbanco" id="nbanco" value="<?php echo $_POST[nbanco]?>">
		  				<table class="inicio">
	  						<tr><td class="titulos" colspan="8">Informaci&oacute;n Predio</td></tr>
	  						<tr>
	  							<td width="119" class="saludo1">Codigo Catastral:</td>
	  							<td width="202" ><input name="catastral" type="text" id="catastral" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[catastral]?>"  readonly></td>
                                <td width="82" class="saludo1">Avaluo:</td>
	  							<td colspan="5"><input name="avaluo" type="text" id="avaluo" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[avaluo]?>" size="20" readonly></td>
                      		</tr>
      						<tr> 
                            	<td width="82" class="saludo1">Documento:</td>
	  							<td ><input name="tercero" type="text" id="tercero" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[tercero]?>"  readonly></td>
	  							<td width="119" class="saludo1">Propietario:</td>
	  							<td  colspan="2" >
		
								<input name="ntercero" type="text" id="propietario" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[ntercero]?>" style="width:90%;" readonly></td>
                          	</tr>
                         	<tr>
								<td  class="saludo1" style="width:8%;">Direccion:</td>
	  							<td colspan="3" >
									 
									<input name="direccion" type="text" id="direccion" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[direccion]?>" style="width:60%;" readonly></td>
			   
							</tr>
      						<tr>
	  							
                                <td  class="saludo1">Ha:</td>
	  							<td >
									<input name="ha" type="text" id="ha" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[ha]?>"  readonly></td>
	  							<td class="saludo1">Mt2:</td>
	  							<td >
									<input name="mt2" type="text" id="mt2" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[mt2]?>" readonly></td>
	  							<td  class="saludo1">Area Cons:</td>
	  							<td ><input name="areac" type="text" id="areac" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[areac]?>"  readonly></td>
      						</tr>
	  						<tr>
	     						<td  class="saludo1">Tipo:</td>
                                <td >
                                	<select name="tipop" onChange="validar();" disabled>
       									<option value="">Seleccione ...</option>
				  						<option value="urbano" <?php if($_POST[tipop]=='urbano') echo "SELECTED"?>>Urbano</option>
  				  						<option value="rural" <?php if($_POST[tipop]=='rural') echo "SELECTED"?>>Rural</option>
				  					</select>
                 				</td>
         						<?php
		 							if($_POST[tipop]=='urbano')
		 							{
		 					 			echo"
        								<td class='saludo1'>Estratos:</td>
										<td>
											<select name='estrato'  disabled>
       											<option value=''>Seleccione ...</option>";
										$sqlr="SELECT * FROM estratos WHERE estado='S'";
										$res=mysql_query($sqlr,$linkbd);
										while ($row =mysql_fetch_row($res)) 
				    					{
					 						if("$row[0]"==$_POST[estrato])
			 								{
						 						echo "<option value='$row[0]' SELECTED>$row[1]</option>";
						 						$_POST[nestrato]=$row[1];
						 					}
											else {echo "<option value='$row[0]'>$row[1]</option>";}
										}	 	
										echo"           
											</select>  
											<input type='hidden' value='$_POST[nestrato]' name='nestrato'/>
            							</td>"; 
									}
		 							else
		  							{
										echo"  
										<td class='saludo1'>Rango Avaluo:</td>
            							<td>
            								<select name='rangos'>
       											<option value=''>Seleccione ...</option>";
										$sqlr="SELECT * FROM rangoavaluos WHERE estado='S'";
										$res=mysql_query($sqlr,$linkbd);
										while ($row =mysql_fetch_row($res)) 
				    					{
					 						if("$row[0]"==$_POST[rangos])
			 								{
						 						echo "<option value='$row[0]' SELECTED>Entre $row[1] - $row[2] SMMLV</option>";
												$_POST[nrango]=$row[1]." - ".$row[2]." SMMLV";
					    					}
											else{echo "<option value='$row[0]'>Entre $row[1] - $row[2] SMMLV</option>";}
										}	 					
										echo"
											</select>
            								<input type='hidden' value='$_POST[nrango]' name='nrango'/>            
											<input type='hidden' value='0' name='agregadet'/>
										</td>";
		  							}
		  						?> 
        					</tr> 
      					</table>
					</div> 
				</div>    
			</div>
	  		<div class="subpantallac" style="width:99.4%;">
      			<table class="inicio">
	   	   			<tr><td colspan="14" class="titulos">Periodos a Liquidar  </td></tr>                  
					<tr>
		  				<td class="titulos2">Vigencia</td>
		  				<td class="titulos2">Codigo Catastral</td>
                     	<td class="titulos2">Predial</td>
                      	<td class="titulos2">Intereses Predial</td>   
                      	<td class="titulos2">Desc. Intereses</td> 
                      	<td class="titulos2">Tot. Int Predial</td>                              
                      	<td class="titulos2">Sobretasa Bombe</td>
                      	<td class="titulos2">Intereses</td>
                      	<td class="titulos2">Sobretasa Amb</td>
                      	<td class="titulos2">Intereses</td>
                      	<td class="titulos2">Descuentos</td>
                      	<td class="titulos2">Valor Total</td>
          		  		<td class="titulos2">Dias Mora</td>
		  				<td width="3%" class="titulos2">Sel</td>
              		</tr>
		    		<input type='hidden' name='buscarvig' id='buscarvig'/>
            		<?php			
						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechaav],$fecha);
						$fechaactual=$fecha[3]."-".$fecha[2]."-".$fecha[1];					

						$sqlr="SELECT * FROM tesoacuerdopredial_det WHERE idacuerdo=$_POST[numacuerdo]";							
						$res=mysql_query($sqlr,$linkbd);

						while($r=mysql_fetch_row($res))
						{	
							$base=$_POST[vavaluo];
							$tasav=$r[12];
							$predial=$r[2];
							$ipredial=$r[3];
							$descipred=$r[4];
							$bomberos=$r[5];
							$ibomberos=$r[6];
							$ambiente=$r[7];
							$iambiente=$r[8];
							$tdescuentos=$r[9];
							$totalpagar=$r[10];
							$diasd=$r[11];
			 				echo "
							<input type='hidden' name='dvigencias[]' value='$r[13]'/>
							<input type='hidden' name='dcodcatas[]' value='$_POST[codcat]'/>
							<input type='hidden' name='dvaloravaluo[]' value='$base'/>
							<input type='hidden' name='dtasavig[]' value='$tasav'/>
							<input type='hidden' name='dpredial[]' value='$predial'/>
							<input type='hidden' name='dipredial[]' value='$ipredial'/>
							<input type='hidden' name='ddescipredial[]' value='$descipred'/>
							<input type='hidden' name='ditpredial[]' value='".($ipredial-$descipred)."'/>
							<input type='hidden' name='dimpuesto1[]' value='".($bomberos)."'/>
							<input type='hidden' name='dinteres1[]' value='".($ibomberos)."'/>
							<input type='hidden' name='dimpuesto2[]' value='".($ambiente)."'/>
							<input type='hidden' name='dinteres2[]' value='".($iambiente)."'/>
							<input type='hidden' name='ddescuentos[]' value='$tdescuentos'/>
							<input type='hidden' name='davaluos[]' value='".number_format($totalpagar,2)."'/>
							<input type='hidden' name='dhavaluos[]' value='$totalpagar'/>
							<input type='hidden' name='dias[]' value='$diasd'/>
			 				<tr class='$co' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
			onMouseOut=\"this.style.backgroundColor=anterior\">
			 					<td>$r[13]</td>
								<td>$_POST[codcat]</td>
								<td style='text-align:right;'>$ ".number_format($predial,2)."</td>
								<td style='text-align:right;'>$ ".number_format($ipredial,2)."</td>
								<td style='text-align:right;'>$ ".number_format($descipred,2)."</td>
								<td style='text-align:right;'>$ ".number_format(($ipredial-$descipred),2)."</td>
								<td style='text-align:right;'>$ ".number_format(($bomberos),2)."</td>
								<td style='text-align:right;'>$ ".number_format(($ibomberos),2)."</td>
								<td style='text-align:right;'>$ ".number_format(($ambiente),2)."</td>
								<td style='text-align:right;'>$ ".number_format(($iambiente),2)."</td>
								<td style='text-align:right;'>$ ".number_format($tdescuentos,2)."</td>
								<td style='text-align:right;'>$ ".number_format($totalpagar,2)."</td>
								<td style='text-align:right;'>".number_format($diasd,0)."</td>
								<td><input type='checkbox' name='dselvigencias[]' value='$r[13]' onClick='buscavigencias(this,$xpm)' $chk></td>
							</tr>";
		 					$_POST[totalc]=$_POST[totalc]+$_POST[davaluos][$x];
		 					$_POST[totalcf]=number_format($_POST[totalc],2,".",",");
							$aux=$co;
		 					$co=$co2;
		 					$co2=$aux;
							$xpm=$xpm+1;
		 					//$ageliqui=$ageliqui." ".$_POST[dselvigencias][$x];
		 				}
 						$resultado = convertir($_POST[totliquida]);
						$_POST[letras]=$resultado." PESOS M/CTE";	
					?> 
      			</table>
      		</div>
      		<table class="inicio">
     	 		<tr>
            		<td class="saludo1">Total Liquidacion:</td>
                    <td><input type="text" name="totliquida2" value="<?php echo number_format($_POST[totliquida2],2)?>" size="12"  readonly><input type="hidden" name="totliquida" value="<?php echo $_POST[totliquida]?>" size="12" readonly></td>
                    <td class="saludo1">Total Predial:</td>
                    <td><input type="hidden" name="intpredial" value="<?php echo $_POST[intpredial]?>"><input type="text" name="totpredial" value="<?php echo $_POST[totpredial]?>" size="9" readonly></td>
                    <td class="saludo1">Total Sobret Bomberil:</td>
                    <td><input type="hidden" name="intbomb" value="<?php echo $_POST[intbomb]?>"><input type="text" name="totbomb" value="<?php echo $_POST[totbomb]?>" size="9" readonly></td>
                    <td class="saludo1">Total Sobret Ambiental:</td>
                    <td><input type="hidden" name="intamb" value="<?php echo $_POST[intamb]?>"><input type="text" name="totamb" value="<?php echo $_POST[totamb]?>" size="9" readonly></td>
                    <td class="saludo1">Total Intereses:</td>
                    <td><input type="text" name="totint" value="<?php echo $_POST[totint]?>" size="9" readonly></td>
                    <td class="saludo1">Total Descuentos:</td>
                    <td><input type="text" name="totdesc"  value="<?php echo $_POST[totdesc]?>" size="9" readonly></td>
             	</tr>
      			<tr>
                	<td class="saludo1" >Son:</td>
                    <td colspan="8"><input type="text" name="letras"  value="<?php echo $_POST[letras]?>" size="155"></td>
             	</tr>
     		</table>
			
            <div id="bgventanamodal2">
                <div id="ventanamodal2">
                    <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                    </IFRAME>
                </div>
       	 	</div>
		</form>
	</body>
</html>