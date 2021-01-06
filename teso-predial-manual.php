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
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <link href="css/tabs.css" rel="stylesheet" type="text/css" />
   		<script type="text/javascript" src="css/programas.js"></script>
        <script type="text/javascript" src="css/calendario.js"></script>
		<script>
			function buscacta(e)
 			{
				if (document.form2.cuenta.value!="")
				{
					document.form2.bc.value='1';
				 	document.form2.submit();
 				}
			 }
			function validar(){document.form2.submit();}
			function buscater(e)
 			{
				if (document.form2.tercero.value!="")
				{
 					document.form2.bt.value='1'; 
 					document.form2.submit();
 				}
 			}
			function guardar()
			{
				vvigencias=document.getElementsByName('dselvigencias[]');
				var banche=0;
				for(x=0;x<vvigencias.length;x++){if(vvigencias.item(x).checked){banche=1;}}
				if (banche!=0)
				{
					if (document.form2.fecha.value!=''  && document.form2.fechaav.value!='' && document.form2.vigencia.value!='' )
					{
						if(document.form2.tasa.value>0)
						{
							despliegamodalm('visible','4','Esta Seguro de Guardar','1');
						}
						else
						{
							despliegamodalm('visible','2','Falta la tasa por mil');
						}
					}
  					else 
					{
						despliegamodalm('visible','2','Faltan datos para completar el registro');
					}
				}
				else{despliegamodalm('visible','2','Faltan elegir un periodo a liquidar');}
			}
			function pdf()
			{
				document.form2.action="pdfpredial.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function buscar()
 			{
				document.form2.var1.value=0;
				document.form2.var2.value=0;
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
			function funcionmensaje(){document.location.href = "teso-predialver.php?idpredial="+document.form2.numpredial.value;}
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
			function hisliquidacion(nliqi)
			{
				paginas="../spid.php?pagina=teso-predialver.php?idpredial="+nliqi;
				mypop=window.open(paginas,'','');
				mypop.focus();
			}
			function hisautorizacion(nliqi)
			{
				paginas="../spid.php?pagina=teso-autorizapredialmirar.php?idauto="+nliqi;
				mypop=window.open(paginas,'','');
				mypop.focus();
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
  				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" class="mgbt" onClick="location.href='teso-predial-manual.php'"/><img src="imagenes/guarda.png" title="Guardar" class="mgbt" onClick="guardar();"/><img src="imagenes/busca.png" title="Buscar" onClick="location.href='teso-buscapredial.php'" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" class="mgbt" onClick="<?php echo paginasnuevas("teso");?>"><img src="imagenes/print.png" title="Imprimir"  style="width:29px;height:25px;" class="mgbt" <?php if($_POST[oculto]==2) { ?> onClick="pdf()" <?php } ?>/></td>
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
				$vigencia=$vigusu;
				
				if(0>diferenciamesesfechas_f2($_POST[fecha],$_POST[fechaav]))
				{
					echo"<script>despliegamodalm('visible','2','La fecha de proyecci�n de liquidaci�n no puede ser menor a la fecha actual');</script>";
 					$_POST[fechaav]=$_POST[fecha];
				}
	 			//*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
				if(!$_POST[oculto])
				{
					$_POST[var1]=0;
					$_POST[var2]=0;
					$sqlr="select valor_inicial,valor_final, tipo from dominios where nombre_dominio='BASE_PREDIAL' ";
					$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res)){$_POST[basepredial]=$row[0];}
					$sqlr="select valor_inicial,valor_final, tipo from dominios where nombre_dominio='BASE_PREDIALAMB' ";
					$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res)){$_POST[basepredialamb]=$row[0];}	
	 				$sqlr="select valor_inicial,valor_final, tipo from dominios where nombre_dominio='NORMA_PREDIAL' ";
					$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res)){$_POST[aplicapredial]=$row[0];}
					$sqlr="select valor_inicial,valor_final, tipo from dominios where nombre_dominio='DESCUENTO_CON_DEUDA' ";
					$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res)){$_POST[descuentoConDeuda]=$row[0];}
					$sqlr="select valor_inicial,valor_final, tipo from dominios where nombre_dominio='DESC_INTERESES' ";
					$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res)) 
					{
	 					$_POST[vigmaxdescint]=$row[0];
 	 					$_POST[porcdescint]=$row[1];
	 					$_POST[aplicadescint]=$row[2];
					}
					$sqlr="SELECT valor_inicial,valor_final,tipo FROM dominios WHERE nombre_dominio='COBRO_ALUMBRADO' AND  tipo='S'";
					$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res)) 
					{
						$_POST[cobroalumbrado]=$row[0];
						$_POST[vcobroalumbrado]=$row[1];
						$_POST[tcobroalumbrado]=$row[2];
					}
	 		 		$fec=date("d/m/Y");
		 			$_POST[fecha]=$fec; 		
					$_POST[fechaav]=$_POST[fecha]; 		  			 
 					$_POST[vigencia]=$vigusu; 		
					$check1="checked";
					$sqlr="select *from tesotasainteres where vigencia='$vigusu'";
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
					else
				  	{
						if($fecha[2]<=6){$tasamoratoria[0]=$tasam[1];}
						else
					 	{
					  		if($fecha[2]<=9){$tasamoratoria[0]=$tasam[2];}
							else {$tasamoratoria[0]=$tasam[3];}						
						}
				   	}
					$_POST[tasamora]=$tasamoratoria[0];   
					if($_POST[tasamora]==0)
				 	{echo"<script>despliegamodalm('visible','2','LA TASA DE INTERES DE MORA ES CERO (0) POR FAVOR ACTUALIZAR EL VALOR');</script>";}
					$_POST[tasa]=0;
					$_POST[predial]=0;
					$_POST[descuento]=0;
			 		$condes=0;
					//***** BUSCAR FECHAS DE INCENTIVOS
					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
					$fechaactual=$fecha[3]."-".$fecha[2]."-".$fecha[1];	
					$sqlr="select *from tesodescuentoincentivo where vigencia='$vigusu' and ingreso='01' and estado='S'";
					$res=mysql_query($sqlr,$linkbd);
					while($r=mysql_fetch_row($res))
					{	
			  			if($r[7]<=$fechaactual && $fechaactual <= $r[8])
			   			{
				 			$_POST[descuento]=$r[2];	
 				 			$condes=1;   
			   			}
			  			elseif($fechaactual>$r[9] && $fechaactual <= $r[10])
			   			{
				 			$_POST[descuento]=$r[3];	   
				 			$condes=1;
			   			}
			  			elseif($fechaactual>$r[11] && $fechaactual <= $r[12])
			   			{
				 			$_POST[descuento]=$r[4];	   
				 			$condes=1;				 
			   			}  
						elseif($fechaactual>$r[19] && $fechaactual <= $r[20])
			   			{
				 			$_POST[descuento]=$r[16];	   
				 			$condes=1;				 
			   			} 
						elseif($fechaactual>$r[21] && $fechaactual <= $r[22])
			   			{
				 			$_POST[descuento]=$r[17];	   
				 			$condes=1;				 
			   			} 
						elseif($fechaactual>$r[23] && $fechaactual <= $r[24] )
			   			{
				 			$_POST[descuento]=$r[18];	   
				 			$condes=1;				 
			   			} 
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
					$sqlr="select *from tesotasainteres where vigencia=".$vigusu;
					$res=mysql_query($sqlr,$linkbd);
					$r=mysql_fetch_row($res);
					$tasam=array();
					$tasam[0]=$r[14];									
					$tasam[1]=$r[15];
					$tasam[2]=$r[16];
					$tasam[3]=$r[17];
					$tasamoratoria[0]=0;
					$sqlr="select * from tesotasainteres where vigencia='$vigusu'";
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
					else
				  	{
				  		if($fecha[2]<=6){$tasamoratoria[0]=$tasam[1];}
						else
					 	{
					  		if($fecha[2]<=9){$tasamoratoria[0]=$tasam[2];}
							else {$tasamoratoria[0]=$tasam[3];}						
						}
				   	}
					$_POST[tasamora]=$tasamoratoria[0]; 
					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechaav],$fecha);
					$fechaactual=$fecha[3]."-".$fecha[2]."-".$fecha[1];	
					$condes=0;
					$sqlr="select *from tesodescuentoincentivo where vigencia='$vigusu' and ingreso='01' and estado='S'";
					$res=mysql_query($sqlr,$linkbd);
					while($r=mysql_fetch_row($res))
					{	
			 			if($r[7]<=$fechaactual && $fechaactual <= $r[8] )
			   			{
							$_POST[descuento]=$r[2];	   
				 			$condes=1;
			   			}
			  			elseif($fechaactual>$r[9] && $fechaactual <= $r[10] )
			   			{
							$_POST[descuento]=$r[3];	   
							$condes=1;				 
			  			}
			  			elseif($fechaactual>$r[11] && $fechaactual <= $r[12] )
			   			{
				 			$_POST[descuento]=$r[4];	 
				 			$condes=1;				 
			   			} 
						elseif($fechaactual>$r[19] && $fechaactual <= $r[20]  )
			   			{
				 			$_POST[descuento]=$r[16];	  
				 			$condes=1;				 
			   			} 
						elseif($fechaactual>$r[21] && $fechaactual <= $r[22] )
			   			{
				 			$_POST[descuento]=$r[17];	   
				 			$condes=1;				 
			   			} 
						elseif($fechaactual>$r[23] && $fechaactual <= $r[24] )
			   			{
				 			$_POST[descuento]=$r[18];	   
				 			$condes=1;				 
			   			} 
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
					case 1: $check1='checked';break;
					case 2:	$check2='checked';break;
					case 3:	$check3='checked';
				}
				$sqlr="Select max(idpredial) from tesoliquidapredial";
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
  				$_POST[numpredial]=$row[0]+1;
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
	 				$sqlr="select *from tesopredios where cedulacatastral='$_POST[codcat]' and ord='$_POST[ord]'  and tot='$_POST[tot]'";					
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
						$_POST[rangos]=$row[16];
						$tipopp=$row[14];
						
						// $_POST[dcuentas][]=$_POST[estrato];		
		 				$_POST[dtcuentas][]=$row[1];		 
		 				$_POST[dvalores][]=$row[5];
		 				$_POST[buscav]="";
		 				$sqlr2="select tasa from tesoprediosavaluos where vigencia='$vigusu' AND codigocatastral='$row[0]' ";
		 				$res2=mysql_query($sqlr2,$linkbd);
	 					while($row2=mysql_fetch_row($res2))
			  			{
			   				$_POST[tasa]=$row2[0];
			   				$_POST[predial]=($row2[0]/1000)*$_POST[vavaluo];
			   				$_POST[predial]=number_format($_POST[predial],2);
			  			}
	  				}
 				}
			?>
 			<div class="tabspre">
   				<div class="tab">
       				<input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
	   				<label for="tab-1">Liquidaci&oacute;n Predial Manual</label>
	   				<div class="content">
           				<table class="inicio" align="center" >
      						<tr >
        						<td class="titulos" colspan="10">Liquidar Predial Manual</td>
                                <td class="cerrar" style="width:7%;"><a onClick="location.href='teso-principal.php'">&nbsp;Cerrar</a></td>
      						</tr>
     						<tr>
                            	<td class="saludo1" style="width:9%;">No Liquidaci&oacute;n:</td>
                                <td style="width:9%;">
									<input type="text" name="numpredial" value="<?php echo $_POST[numpredial]?>"  readonly /></td>
                                <td class="saludo1" style="width:9%;">Fecha:</td>
                                <td style="width:8%;">
									<input type="text" name="fecha" value="<?php echo $_POST[fecha]?>" style="width:100%;" readonly /></td>
                                <td class="saludo1" style="width:8%;">Vigencia:</td>
                                <td style="width:7%;"><input type="text" name="vigencia" value="<?php echo $_POST[vigencia]?>" style="width:100%;" readonly /></td>
                                <td class="saludo1" style="width:10%;">Tasa Interes Mora:</td>
                                <td style="width:7%;"><input type="text" name="tasamora" value="<?php echo $_POST[tasamora]?>" style="width:75%;" readonly />%</td>
    							<td class="saludo1" style="width:7%;">Descuento:</td>
    							<td style="width:8%;"><input name="descuento" type="text" style="width:80%;" value="<?php echo $_POST[descuento]?>" readonly />%</td >
								<td style="width:12%;"></td>
                          	</tr>
	  						<tr>
                            	<td class="saludo1">Proy Liquidaci&oacute;n:</td>
                                <td style="width:8%;"><input name="fechaav" type="text" value="<?php echo $_POST[fechaav]?>"  id="fc_1198971545" title="DD/MM/YYYY" style="width:80%;" readonly />&nbsp;<a style="cursor:pointer;" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/calendario04.png" style="width:20px;"/></a></td> 	
                                <td  class="saludo1">C&oacute;digo Catastral:</td>
          						<td colspan="3">
									<input id="codcat" type="text" name="codcat"  onKeyUp="return tabular(event,this)" onBlur="buscar(event)" value="<?php echo $_POST[codcat]?>"/>
									<input id="ord" type="text" name="ord"   value="<?php echo $_POST[ord]?>" style="width:18%;" readonly>
									<input id="tot" type="text" name="tot"  value="<?php echo $_POST[tot]?>" style="width:18%;" readonly>&nbsp;<a title="Listado de Predios" onClick="despliegamodal2('visible');" style="cursor:pointer;"><img src="imagenes/find02.png" style="width:20px;"/></a></td>
                                <input type="hidden" name="chacuerdo" value="1"/>
                                <input type="hidden" name="bt" value="0"/>
                                <input type="hidden" name="oculto" id="oculto" value="1"/>
                                <input type="hidden" name="basepredial" value="<?php echo  $_POST[basepredial] ?>"/>
                                <input type="hidden" name="basepredialamb" value="<?php echo  $_POST[basepredialamb] ?>"/>
                                <input type="hidden" name="aplicapredial" value="<?php echo  $_POST[aplicapredial] ?>"/>
                                <input type="hidden" name="vigmaxdescint" value="<?php echo  $_POST[vigmaxdescint] ?>"/>
                                <input type="hidden" name="porcdescint" value="<?php echo  $_POST[porcdescint] ?>"/>
                                <input type="hidden" name="aplicadescint" value="<?php echo  $_POST[aplicadescint] ?>"/>
                                <input type="hidden" name="cobroalumbrado" value="<?php echo  $_POST[cobroalumbrado] ?>"/>
                                <input type="hidden" name="vcobroalumbrado" value="<?php echo  $_POST[vcobroalumbrado] ?>"/>
                                <input type="hidden" name="tcobroalumbrado" value="<?php echo  $_POST[tcobroalumbrado] ?>"/>
                                <input type="hidden" name="descuentoConDeuda" value="<?php echo  $_POST[descuentoConDeuda] ?>"/>
                                <input type="hidden" name="buscav" value="<?php echo $_POST[buscav]?>"/>
                                <td><input type="button" name="buscarb" id="buscarb" value=" Calcular " onClick="buscar()" ></td>
        					</tr>
        					<tr>
                            	<td class="saludo1">Avaluo Vigente:</td>
                                <td>
                                	<input type="text" name="avaluo2" value="<?php echo $_POST[avaluo2]?>"  readonly/>
                                	<input type="hidden" name="vavaluo"  value="<?php echo $_POST[vavaluo]?>"/> 
                               </td>
                                <td class="saludo1">Tasa Predial:</td>
                                <td colspan="3"><input type="text" name="tasa" value="<?php echo $_POST[tasa]?>" style="width:35%;" readonly>xmil</td>
                                <input type="hidden" name="predial" value="<?php echo $_POST[predial]?>"  readonly>
                   			</tr>
	  					</table>
					</div> 
				</div>
     			<div class="tab">
       				<input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?>>
      				<label for="tab-2">Informaci&oacute;n Predio</label>
       				<div class="content"> 
		  				<table class="inicio">
	  						<tr><td class="titulos" colspan="8">Informac&oacute;n Predio</td></tr>
	 					 	<tr>
	  							<td width="119" class="saludo1">C&oacute;digo Catastral:</td>
	  							<td width="202" >
                                	<input type="hidden" name="nbanco" value="<?php echo $_POST[nbanco]?>"/> 
                                    <input type="text" name="catastral" id="catastral" value="<?php echo $_POST[catastral]?>" size="20" readonly/>
                             	</td>
		 						<td width="82" class="saludo1">Avaluo:</td>
	  							<td ><input type="text" name="avaluo" id="avaluo" value="<?php echo $_POST[avaluo]?>" size="20" readonly/></td>
								<td width="119" class="saludo1">Tipo:</td>
                                <td width="202">
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
											<select name='estrato' disabled>
       											<option value=''>Seleccione ...</option>";
										$sqlr="select *from estratos where estado='S'";
										$res=mysql_query($sqlr,$linkbd);
										while ($row =mysql_fetch_row($res)) 
				    					{
					 						if("$row[0]"==$_POST[estrato])
			 								{
						 						echo "<option value='$row[0]' SELECTED>$row[1]</option>";
						 						$_POST[nestrato]=$row[1];
						 					}
										}
										echo"
											</select>  
											<input type='hidden' name='nestrato' value='$_POST[nestrato]'/>
            							</td>";  
								 	}
		 							else
		  							{
										echo"  
										<td class='saludo1'>Rango Avaluo:</td>
            							<td>
            								<select name='rangos'>";
										$sqlr="select *from rangoavaluos where estado='S'";
										$res=mysql_query($sqlr,$linkbd);
										while ($row =mysql_fetch_row($res)) 
				    					{
					 						if("$row[0]"==$_POST[rangos])
			 								{
											 	echo "<option value='$row[0]' SELECTED >Entre $row[1] - $row[2] SMMLV</option>";
						 						$_POST[nrango]="$row[1] - $row[2] SMMLV";
					    					}
										}	 	
										echo"            
											</select>
            								<input type='hidden' name='nrango' value='$_POST[nrango]'/>            
											<input type='hidden' value='0' name='agregadet'>
										</td>";
		 							}
		  						?>
      						</tr>
      						<tr>
                            	<td width="82" class="saludo1">Documento:</td>
	  							<td><input type="text" name="tercero" id="tercero" value="<?php echo $_POST[tercero]?>" size="20" readonly /></td>
	  							<td width="119" class="saludo1">Propietario:</td>
	  							<td width="202" colspan="4" >
                                	<input type="hidden" name="nbanco" value="<?php echo $_POST[nbanco]?>"/> 
                                    <input type="text" name="ntercero" id="propietario" value="<?php echo $_POST[ntercero]?>" style="width:66.5%;" readonly />
                              	</td>
							</tr>
      						<tr>
	  							<td  class="saludo1">Direccion:</td>
	  							<td ><input type="text" name="direccion" id="direccion" value="<?php echo $_POST[direccion]?>"  readonly /></td>		   
		 						<td  class="saludo1">Ha:</td>
	  							<td ><input type="text" name="ha" id="ha" value="<?php echo $_POST[ha]?>"  readonly /></td>
	  							<td class="saludo1">Mt2:</td>
	  							<td ><input type="text" name="mt2" id="mt2" value="<?php echo $_POST[mt2]?>" style="width:50%;" readonly /></td>
	  							<td  class="saludo1">Area Cons:</td>
	  							<td ><input name="areac" type="text" id="areac" value="<?php echo $_POST[areac]?>" style="width:50%;" readonly /></td>
      						</tr>
	  						
      					</table>
					</div> 
				</div>    
			</div>
	  		<div class="subpantallac4">
      			<table class="inicio">
	   	   			<tr><td colspan="15" class="titulos">Periodos a Liquidar</td></tr>                  
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
						<?php 
						if($_POST[tcobroalumbrado]=='S' && $_POST[tipop]=='rural')
						{
							echo "<td class='titulos2'>Alumbrado Publico</td>";
						}
						?>
          				<td class="titulos2">Descuentos</td>
          				<td class="titulos2">Valor Total</td>
          		  		<td class="titulos2">Dias Mora</td>
		  				<td class="titulos2" width="3%">Sel</td>
                   	</tr>
                    <input type='hidden' name='buscarvig' id='buscarvig'>
            		<?php		 	
						ini_set('max_execution_time', 7200);
						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechaav],$fecha);
						$fechaactual=$fecha[3]."-".$fecha[2]."-".$fecha[1];					
			  			//$tasaintdiaria=(pow((1+$_POST[tasamora]/100),(1/365))-1); Compuesta
			  			$tasaintdiaria=($_POST[tasamora]/100);
			  			$valoringreso[0]=0;
			  			$valoringreso[1]=0;
						$intereses[1]=0;
						$intereses[0]=0;
						$valoringresos=0;
						$valorAlumbrado=0;
						$alumbrado = 0;
						$cuentavigencias=0;
						$tdescuentos=0;
						$baseant=0;
						$npredialant=0;
						$banderapre=0;
			  			$co="zebra1";
			  			$co2="zebra2";
						$sqlrxx="
						SELECT DISTINCT TB1.vigencia,TB1.codigocatastral,TB1.avaluo,TB1.pago,TB1.estado,TB1.tipopredio,TB1.estratos,TB1.areacon
						FROM tesoprediosavaluos TB1
						WHERE TB1.codigocatastral = '$_POST[codcat]'
						AND TB1.estado = 'S'
						AND TB1.pago = 'N'
						ORDER BY TB1.vigencia ASC 
";						//echo $sqlrxx;
						$resxx=mysql_query($sqlrxx,$linkbd);
						$cuentavigencias= mysql_num_rows($resxx);
						$sqlr="
						SELECT DISTINCT TB1.vigencia,TB1.codigocatastral,TB1.avaluo,TB1.pago,TB1.estado,TB1.tipopredio,TB1.estratos,TB1.areacon
						FROM tesoprediosavaluos TB1
						WHERE TB1.codigocatastral = '$_POST[codcat]'
						AND TB1.estado = 'S'
						AND TB1.pago = 'N' ORDER BY TB1.vigencia ASC
";						
						$res=mysql_query($sqlr,$linkbd);
						$cv=0;
						$xpm=0;
				 		$sq="select interespredial from tesoparametros ";
						$result=mysql_query($sq,$linkbd);
						$rw=mysql_fetch_row($result);
						$interespredial=$rw[0];
						$sq="SELECT idacuerdo FROM tesoacuerdopredial WHERE codcatastral='$_POST[codcat]' and estado='S'";
						$rs=mysql_query($sq,$linkbd);
						$idacuerdopre=mysql_fetch_row($rs);
						if($idacuerdopre[0]!='')
						{
							//$cuentavigencias=1;
                        }
                        if($_POST[oculto]!='2')	
                        {
                            while($r=mysql_fetch_row($res))
                            {
                                $totalintereses=0;
                                $sql="SELECT * FROM tesoacuerdopredial_det WHERE idacuerdo='$idacuerdopre[0]' and vigencia='$r[0]' and estado='S'";
                                $rst=mysql_query($sql,$linkbd);
                                if(!mysql_fetch_row($rst))
                                {
                                $banderapre++;
                                $otros=0; 
                                $sqlr2="select IF(tasa='-1',0,tasa) from tesoprediosavaluos where vigencia='$r[0]' and codigocatastral='$r[1]' " ;
                            
                                $res2=mysql_query($sqlr2,$linkbd);
                                $row2=mysql_fetch_row($res2);
                                $base=$r[2];

                                //$valorperiodo=$base*($row2[0]/1000)-$base*($row2[0]/1000)*($_POST[deduccion]/100);
                                $valorperiodo=$base*($row2[0]/1000);
                                $tasav=$row2[0];
                                //$predial=round($base*($row2[0]/1000)-$base*($row2[0]/1000)*($_POST[deduccion]/100),2);
                                $predial=round($base*($row2[0]/1000),2);
                                //**validacion normatividad predial *****
                                if($_POST[aplicapredial]=='S')
                                {
                                    $sqlrp="select distinct * from tesoprediosavaluos where tesoprediosavaluos.codigocatastral='$_POST[codcat]' and vigencia=".($r[0]-1)." ";	
                                    $respr=mysql_query($sqlrp,$linkbd);
                                    $rowpr=mysql_fetch_row($respr);
                                    $baseant=0;		
                                    $estant=$rowpr[3];
                                    $baseant=$rowpr[2]+0;
                                    $predialant=$baseant*($rowpr[10]/1000);
                                    $areaanterior=$rowpr[9];
                                    if($estant=='S')
                                    {	
                                        $sqlrav="select distinct tesoliquidapredial_det.predial,tesoliquidapredial_det.avaluo from tesoliquidapredial_det,tesoliquidapredial where tesoliquidapredial_det.idpredial=tesoliquidapredial.idpredial and tesoliquidapredial.codigocatastral='$_POST[codcat]' and tesoliquidapredial.estado='P' AND tesoliquidapredial_det.vigliquidada='".($r[0]-1)."'";
                                        $resav=mysql_query($sqlrav,$linkbd);
                                        while($rowav=mysql_fetch_row($resav))
                                        {
                                            if($predialant<($rowav[0]*2))
                                            {
                                                $baseant=$rowav[1]+0;
                                                $predialant=$rowav[0]+0;
                                            }
                                        }		
                                    }		
                                    else
                                    {
                                        $baseant=$rowpr[2]+0;
                                        $predialant=$baseant*($rowpr[10]/1000);
                                    }
                                    if ($baseant<=0)
                                    {
                                        //echo "<br>bas ".$baseant;
                                    }
                                    else
                                    {
                                        if(($predialant>($npredialant*2)) && ($npredialant>0))
                                        {
                                            //echo "<br> PA:".$npredialant;
                                            $predialant=$npredialant;
                                        }
                                        //echo "if($predial>($predialant*2) && $r[7]==$areaanterior) <br>";	
                                        if($predial>($predialant*2) && $r[7]==$areaanterior)
                                        {
                                            //echo "<br>PPP ".$predialant." ".$predial;
                                            $predial=$predialant*2;		
                                    
                                        }	 
                                    }
                                    $npredialant=$predial;
                                }
                                
                                //echo "NP:".$npredialant;
                                //*******
                                $valoringresos=0;
                                //echo "vp:".$valorperiodo.' - Pr:'.$predial;
                                $sidescuentos=0;
                                //****buscar en el concepto del ingreso *******
                                $intereses=array();
                                $valoringreso=array();
                                //Inicializando intereses a cero
                                $intereses[0] = 0;
                                $intereses[1] = 0;
                                
                                $in=0;
                                if($cuentavigencias>1)
                                {
                                    if($vigusu==$r[0] && ($_POST[descuento]>0 or $condes==1) )
                                    {
                                        $pdescuento=$_POST[descuento]/100;
                                        $diasd=0;
                                        if($_POST[descuentoConDeuda]=='S')
                                        {
                                            $tdescuentos+=round(($predial)*$pdescuento,0);
                                        }			
                                    }
                                    elseif ($interespredial=='inicioanio')//Si se cuentan los dias desde el principio del a�o 
                                    {
                                        $fechaini=mktime(0,0,0,1,1,$r[0]);
                                        $fechafin=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
                                        $difecha=$fechafin-$fechaini;
                                        $vigenciacobro=$fecha[3];
                                        $diasd=$difecha/(24*60*60);
                                        $diasd=floor($diasd);
                                        $totalintereses=0; 
                                    }
                                    else //Si se cuentan los dias desde el principio del a�o 
                                    {
                                        $sqlrfd="SELECT * FROM tesodescuentoincentivo WHERE vigencia='$r[0]' AND estado='S'";
                                        $resfd=mysql_query($sqlrfd,$linkbd);
                                        $rowfd=mysql_fetch_row($resfd);
                                        if($rowfd[24]!="0000-00-00"){$ulfedes01=$rowfd[24];}
                                        elseif($rowfd[22]!="0000-00-00"){$ulfedes01=$rowfd[22];}
                                        elseif($rowfd[20]!="0000-00-00"){$ulfedes01=$rowfd[20];}
                                        elseif($rowfd[12]!="0000-00-00"){$ulfedes01=$rowfd[12];}
                                        elseif($rowfd[10]!="0000-00-00"){$ulfedes01=$rowfd[10];}
                                        else {$ulfedes01=$rowfd[8];}
                                        ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", date('d/m/Y',strtotime($ulfedes01)),$fechafd);
                                        $fechainiciocobro=$fecha[2];
                                        $vigenciacobro=$fecha[3];
                                        $diascobro=$fecha[1];
                                        $fechaini=mktime(0,0,0,$fechafd[2],$fechafd[1],$fechafd[3]);
                                        $fechafin=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
                                        $difecha=$fechafin-$fechaini;
                                        if($difecha<'0')
                                        {
                                            $ulfedes01=$rowfd[7];
                                            ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", date('d/m/Y',strtotime($ulfedes01)),$fechafd);
                                            $fechainiciocobro=$fecha[2];
                                            $vigenciacobro=$fecha[3];
                                            $diascobro=$fecha[1];
                                            $fechaini=mktime(0,0,0,$fechafd[2],$fechafd[1],$fechafd[3]);
                                            $fechafin=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
                                            $difecha=$fechafin-$fechaini;
                                        }
                                        $diasd=$difecha/(24*60*60);
                                        $diasd=floor($diasd);
                                        $totalintereses=0;  
                                    }
                                }
                                else //********* si solo debe la actual vigencia
                                { 
                                    $diasd=0;
                                    $totalintereses=0; 
                                    $tdescuentos=0;
                                    $sidescuentos=1;
                                    if($vigusu==$r[0] && ($_POST[descuento]>0 or $condes==1))
                                    {
                                        $pdescuento=$_POST[descuento]/100; 					
                                        $tdescuentos+=round(($predial)*$pdescuento,0);
                                    }
                                    elseif ($interespredial=='inicioanio')//Si se cuentan los dias desde el principio del a�o 
                                    {
                                        $fechaini=mktime(0,0,0,1,1,$r[0]);
                                        $fechafin=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
                                        $difecha=$fechafin-$fechaini;
                                        $vigenciacobro=$fecha[3];
                                        $diasd=$difecha/(24*60*60);
                                        $diasd=floor($diasd);
                                        $totalintereses=0; 
                                    }
                                    else //Si se cuentan los dias desde el principio del a�o 
                                    {
                                        $sqlrfd="SELECT * FROM tesodescuentoincentivo WHERE vigencia='$r[0]' AND estado='S'";
                                        $resfd=mysql_query($sqlrfd,$linkbd);
                                        $rowfd=mysql_fetch_row($resfd);
                                        if($rowfd[24]!="0000-00-00"){$ulfedes01=$rowfd[24];}
                                        elseif($rowfd[22]!="0000-00-00"){$ulfedes01=$rowfd[22];}
                                        elseif($rowfd[20]!="0000-00-00"){$ulfedes01=$rowfd[20];}
                                        elseif($rowfd[12]!="0000-00-00"){$ulfedes01=$rowfd[12];}
                                        elseif($rowfd[10]!="0000-00-00"){$ulfedes01=$rowfd[10];}
                                        else {$ulfedes01=$rowfd[8];}
                                        ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", date('d/m/Y',strtotime($ulfedes01)),$fechafd);
                                        $fechainiciocobro=$fecha[2];
                                        $vigenciacobro=$fecha[3];
                                        $diascobro=$fecha[1];
                                        $fechaini=mktime(0,0,0,$fechafd[2],$fechafd[1],$fechafd[3]);
                                        $fechafin=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
                                        $difecha=$fechafin-$fechaini;
                                        if($difecha<'0')
                                        {
                                            $ulfedes01=$rowfd[7];
                                            ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", date('d/m/Y',strtotime($ulfedes01)),$fechafd);
                                            $fechainiciocobro=$fecha[2];
                                            $vigenciacobro=$fecha[3];
                                            $diascobro=$fecha[1];
                                            $fechaini=mktime(0,0,0,$fechafd[2],$fechafd[1],$fechafd[3]);
                                            $fechafin=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
                                            $difecha=$fechafin-$fechaini;
                                        }
                                        $diasd=$difecha/(24*60*60);
                                        $diasd=floor($diasd);
                                        $totalintereses=0; 
                                        
                                    }
                                }
                                $y1=12;
                                $diascobro1=0;
                                if($vigenciacobro==$r[0])
                                {
                                    $y1=$fechainiciocobro;
                                    $diascobro1=$diascobro;
                                }
                                $sqlr2="select *from tesoingresos_det where codigo='01' and modulo='4' and  estado='S' and vigencia=$vigusu";
                                //echo $sqlr2;
                                $res3=mysql_query($sqlr2,$linkbd);
                                while($r3=mysql_fetch_row($res3))
                                {
                                    if($r3[5]>0 && $r3[5]<100)
                                    {
                                        if($r3[2]=='03')
                                        {
        
                                            if( $_POST[basepredial]==1)	
                                            {
                    
                                                //$valoringreso[0]=round($base*($r3[5]/1000),0)-($base*($r3[5]/1000)*($_POST[deduccion]/100));
                                                $valoringreso[0]=round($base*($r3[5]/1000),0);
                                                //$valoringresos+=round($base*($r3[5]/1000),0)-($base*($r3[5]/1000)*($_POST[deduccion]/100));
                                                $valoringresos+=round($base*($r3[5]/1000),0);	
                                            }
                                            if( $_POST[basepredial]==2)
                                            {	
                                                $valoringreso[0]=round($predial*($r3[5]/100),0);
                                                $valoringresos+=round($predial*($r3[5]/100),0);
                                            }
                                            
                                            
                                            $totdiastri = 0;
                                            //Antes del 2017 se cobran intereses trimestrales
                                            $vig=$vigenciacobro-$r[0];
                                            $vigcal=$r[0];
                                                for($j=0;$j<=$vig;$j++)
                                                {
                                                    //Se consultan los interes de la vigencia por mes
                                                    $sqlintereses = "SELECT inmopri,inmoseg,inmoter,inmocua,inmoquin,inmosex,inmosep,inmooct,inmonov,inmodec,inmoonc,inmodoc from tesotasainteres WHERE vigencia = '".$vigcal."'";
                                                    $resinteres = mysql_query($sqlintereses, $linkbd);
                                                    $rowinteres = mysql_fetch_row($resinteres);
                                                    $x1=3;
                                                    for($i = 1; $i <= $y1 ; $i++)
                                                    {
                                                        if($interespredial!='inicioanio')
                                                        {
                                                            $sqlrfd="SELECT * FROM tesodescuentoincentivo WHERE vigencia='$r[0]' AND estado='S'";
                                                            $resfd=mysql_query($sqlrfd,$linkbd);
                                                            $rowfd=mysql_fetch_row($resfd);
                                                            if($rowfd[24]!="0000-00-00"){$ulfedes01=$rowfd[24];}
                                                            elseif($rowfd[22]!="0000-00-00"){$ulfedes01=$rowfd[22];}
                                                            elseif($rowfd[20]!="0000-00-00"){$ulfedes01=$rowfd[20];}
                                                            elseif($rowfd[12]!="0000-00-00"){$ulfedes01=$rowfd[12];}
                                                            elseif($rowfd[10]!="0000-00-00"){$ulfedes01=$rowfd[10];}
                                                            else {$ulfedes01=$rowfd[8];}
                                                            ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", date('d/m/Y',strtotime($ulfedes01)),$fechafd);
                                                            $fechainiciocobro=$fecha[2];
                                                            $vigenciacobro=$fecha[3];
                                                            $diascobro=$fecha[1];
                                                            $fechaini=mktime(0,0,0,$fechafd[2],$fechafd[1],$fechafd[3]);
                                                            $fechafin=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
                                                            $difecha=$fechafin-$fechaini;
                                                            if($difecha<'0')
                                                            {
                                                                $rowinteres[$i-1]=0;
                                                            }
                                                        }
                                                        if($interespredial!='inicioanio')
                                                        {
                                                            $sqlrfd="SELECT * FROM tesodescuentoincentivo WHERE vigencia='$r[0]' AND estado='S'";
                                                            $resfd=mysql_query($sqlrfd,$linkbd);
                                                            $rowfd=mysql_fetch_assoc($resfd);
                                                            if($rowfd['fechafin4']!="0000-00-00"){$ulfedes01=$rowfd['fechafin4'];}
                                                            elseif($rowfd['fechafin5']!="0000-00-00"){$ulfedes01=$rowfd['fechafin5'];}
                                                            elseif($rowfd['fechafin6']!="0000-00-00"){$ulfedes01=$rowfd['fechafin6'];}
                                                            elseif($rowfd['fechafin3']!="0000-00-00"){$ulfedes01=$rowfd['fechafin3'];}
                                                            elseif($rowfd['fechafin2']!="0000-00-00"){$ulfedes01=$rowfd['fechafin2'];}
                                                            else {$ulfedes01=$rowfd['fechafin1'];}
                                                            $mesesIntereses = explode('-',$ulfedes01);
                                                            if($i <= $mesesIntereses[1])
                                                                continue;
                                                        }
                                                        $numdias = cal_days_in_month(CAL_GREGORIAN, $i, $vigcal);
                                                        $totdiastri += $numdias;
                                                        //echo $fecha[3]."<br>";
                                                        if($i==$fechainiciocobro && $vigcal==$fechafd[3] )
                                                            $numdias=$diascobro1;
                                                        if($vigcal>'2006' && $vigcal<'2017')
                                                        {
                                                            if($i % 3 == 0){
                                                                $intereses[0]+=round(($valoringreso[0]*$totdiastri*($rowinteres[$i-$x1]/100))/365,0);
                                                                $totdiastri = 0;
                                                                $x1+=2;
                                                            }
                                                            
                                                        }
                                                        elseif($vigcal=='2017')
                                                        {
                                                            if($i <= 7)
                                                            {
                                                                if($i % 3 == 0){
                                                                    $intereses[0]+=round(($valoringreso[0]*$totdiastri*($rowinteres[$i-$x1]/100))/365,0);
                                                                    $totdiastri = 0;
                                                                    $x1+=2;
                                                                }
                                                            }
                                                            else{
                                                                $totdiastri = $numdias;
                                                                $intereses[0]+=round(($valoringreso[0]*$totdiastri*($rowinteres[$i-1]/100))/365,0);
                                                            }
                                                        }
                                                        else{
                                                                $totdiastri = $numdias;
                                                                $intereses[0]+=round(($valoringreso[0]*$totdiastri*($rowinteres[$i-1]/100))/365,0);
                                                        }
                                                        
                                                    }
                                                    $vigcal+=1;
                                                }
                                            $totalintereses+=$intereses[0];						
                                        }
                                        if($r3[2]=='02')
                                        {
                                            if( $_POST[basepredialamb]==1)	
                                            {
                                                $valoringreso[1]=round($base*($r3[5]/1000),0)-($base*($r3[5]/1000)*($_POST[deduccion]/100));
                                                $valoringresos+=round($base*($r3[5]/1000),0)-($base*($r3[5]/1000)*($_POST[deduccion]/100));	
                                            }	
                                            if( $_POST[basepredialamb]==2)
                                            {	
                                                $valoringreso[1]=round($predial*($r3[5]/100),0);
                                                $valoringresos+=round($predial*($r3[5]/100),0);
                                            }
                                            $totdiastri = 0;
                                            //Antes del 2017 se cobran intereses trimestrales
                                            $vig=$vigenciacobro-$r[0];
                                            $vigcal=$r[0];
                                                for($j=0;$j<=$vig;$j++)
                                                {
                                                    $sqlintereses = "SELECT inmopri,inmoseg,inmoter,inmocua,inmoquin,inmosex,inmosep,inmooct,inmonov,inmodec,inmoonc,inmodoc from tesotasainteres WHERE vigencia = '".$vigcal."'";
                                                    $resinteres = mysql_query($sqlintereses, $linkbd);
                                                    $rowinteres = mysql_fetch_row($resinteres);
                                                    $x1=3;
                                                    for($i = 1; $i <= $y1 ; $i++)
                                                    {
                                                        if($interespredial!='inicioanio')
                                                        {
                                                            $sqlrfd="SELECT * FROM tesodescuentoincentivo WHERE vigencia='$r[0]' AND estado='S'";
                                                            $resfd=mysql_query($sqlrfd,$linkbd);
                                                            $rowfd=mysql_fetch_row($resfd);
                                                            if($rowfd[24]!="0000-00-00"){$ulfedes01=$rowfd[24];}
                                                            elseif($rowfd[22]!="0000-00-00"){$ulfedes01=$rowfd[22];}
                                                            elseif($rowfd[20]!="0000-00-00"){$ulfedes01=$rowfd[20];}
                                                            elseif($rowfd[12]!="0000-00-00"){$ulfedes01=$rowfd[12];}
                                                            elseif($rowfd[10]!="0000-00-00"){$ulfedes01=$rowfd[10];}
                                                            else {$ulfedes01=$rowfd[8];}
                                                            ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", date('d/m/Y',strtotime($ulfedes01)),$fechafd);
                                                            $fechainiciocobro=$fecha[2];
                                                            $vigenciacobro=$fecha[3];
                                                            $diascobro=$fecha[1];
                                                            $fechaini=mktime(0,0,0,$fechafd[2],$fechafd[1],$fechafd[3]);
                                                            $fechafin=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
                                                            $difecha=$fechafin-$fechaini;
                                                            if($difecha<'0')
                                                            {
                                                                $rowinteres[$i-1]=0;
                                                            }
                                                        }
                                                        $numdias = cal_days_in_month(CAL_GREGORIAN, $i, $vigcal);
                                                        $totdiastri += $numdias;
                                                        if($i==$fechainiciocobro && $vigcal==$fechafd[3])
                                                            $numdias=$diascobro1;
                                                        if($vigcal<'2017')
                                                        {
                                                            if($i % 3 == 0){
                                                                $intereses[1]+=round(($valoringreso[1]*$totdiastri*($rowinteres[$i-$x1]/100))/365,0);
                                                                $totdiastri = 0;
                                                                $x1+=2;
                                                            }
                                                        }
                                                        elseif($vigcal=='2017')
                                                        {
                                                            if($i <= 7)
                                                            {
                                                                if($i % 3 == 0){
                                                                    $intereses[1]+=round(($valoringreso[1]*$totdiastri*($rowinteres[$i-$x1]/100))/365,0);
                                                                    $totdiastri = 0;
                                                                    $x1+=2;
                                                                }
                                                            }
                                                            else{
                                                                $totdiastri = $numdias;
                                                                $intereses[1]+=round(($valoringreso[1]*$totdiastri*($rowinteres[$i-1]/100))/365,0);
                                                            }
                                                        }
                                                        else{
                                                                $totdiastri = $numdias;
                                                                $intereses[1]+=round(($valoringreso[1]*$totdiastri*($rowinteres[$i-1]/100))/365,0);
                                                        }
                                                    }
                                                    $vigcal+=1;
                                                }
                                            $totalintereses+=$intereses[1];
                                        }	
                                        
                                    }
                                    
                                }
                                
                                if($_POST[tcobroalumbrado]=='S' && $_POST[tipop]=='rural')
                                {
                                    $alumbrado = 1;
                                    if($r[0]>'2016')
                                    {
                                        $valorAlumbrado=round($base*($_POST[vcobroalumbrado]/1000),0);
                                        $valoringresos+=round($base*($_POST[vcobroalumbrado]/1000),0);
                                    }
                                }
                                $otros+=$valoringresos;	
                                $ipredial = 0;
                                $totdiastri = 0;
                            //Antes del 2017 se cobran intereses trimestrales
                            $vig=$vigenciacobro-$r[0];
                            $vigcal=$r[0];
                                for($j=0;$j<=$vig;$j++)
                                {
                                    $sqlintereses = "SELECT inmopri,inmoseg,inmoter,inmocua,inmoquin,inmosex,inmosep,inmooct,inmonov,inmodec,inmoonc,inmodoc from tesotasainteres WHERE vigencia = '".$vigcal."'";
                                    $resinteres = mysql_query($sqlintereses, $linkbd);
                                    $rowinteres = mysql_fetch_row($resinteres);
                                    $x1=3;
                                    for($i = 1; $i <= $y1 ; $i++)
                                    {
                                        if($interespredial!='inicioanio')
                                        {
                                            $sqlrfd="SELECT * FROM tesodescuentoincentivo WHERE vigencia='$r[0]' AND estado='S'";
                                            $resfd=mysql_query($sqlrfd,$linkbd);
                                            $rowfd=mysql_fetch_row($resfd);
                                            if($rowfd[24]!="0000-00-00"){$ulfedes01=$rowfd[24];}
                                            elseif($rowfd[22]!="0000-00-00"){$ulfedes01=$rowfd[22];}
                                            elseif($rowfd[20]!="0000-00-00"){$ulfedes01=$rowfd[20];}
                                            elseif($rowfd[12]!="0000-00-00"){$ulfedes01=$rowfd[12];}
                                            elseif($rowfd[10]!="0000-00-00"){$ulfedes01=$rowfd[10];}
                                            else {$ulfedes01=$rowfd[8];}
                                            ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", date('d/m/Y',strtotime($ulfedes01)),$fechafd);
                                            $fechainiciocobro=$fecha[2];
                                            $vigenciacobro=$fecha[3];
                                            $diascobro=$fecha[1];
                                            $fechaini=mktime(0,0,0,$fechafd[2],$fechafd[1],$fechafd[3]);
                                            $fechafin=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
                                            $difecha=$fechafin-$fechaini;
                                            if($difecha<'0')
                                            {
                                                $rowinteres[$i-1]=0;
                                            }
                                        }
                                        //echo $i." Hola ".$vigcal."<br>";
                                        $numdias = cal_days_in_month(CAL_GREGORIAN, $i, $vigcal);
                                        $totdiastri += $numdias;
                                        if($i==$fechainiciocobro && $vigcal==$fechafd[3])
                                            $numdias=$diascobro1;
                                        if($vigcal<'2017')
                                        {
                                            if($i % 3 == 0){
                                                $ipredial+=round(($predial*$totdiastri*($rowinteres[$i-$x1]/100))/365,0);
                                                $totdiastri = 0;
                                                $x1+=2;
                                            }
                                        }
                                        elseif($vigcal=='2017')
                                        {
                                            if($i <= 7)
                                            {
                                                if($i % 3 == 0){
                                                    $iipredial+=round(($predial*$totdiastri*($rowinteres[$i-$x1]/100))/365,0);
                                                    $totdiastri = 0;
                                                    $x1+=2;
                                                }
                                            }
                                            else{
                                                $totdiastri = $numdias;
                                                $ipredial+=round(($predial*$totdiastri*($rowinteres[$i-1]/100))/365,0);
                                                
                                            }
                                        }
                                        else{
                                                $totdiastri = $numdias;
                                                $ipredial+=round(($predial*$totdiastri*($rowinteres[$i-1]/100))/365,0);
                                        }
                                        
                                    }
                                    $vigcal+=1;
                                }
                                
                                $chk='';
                                $ch=esta_en_array($_POST[dselvigencias], $r[0]);
                                if($ch==1){$chk=" checked";}
                                $descipred=0;
                                $descintpredial=0;
                                $descintbomberil=0;
                                if($r[0]<=$_POST[vigmaxdescint] && $_POST[aplicadescint]=='S')
                                {
                                    $descipred=$ipredial*($_POST[porcdescint]/100)+$intereses[0]*($_POST[porcdescint]/100);
                                    $descintpredial = $ipredial*($_POST[porcdescint]/100);
                                    $descintbomberil = $intereses[0]*($_POST[porcdescint]/100);
                                }
                                $totalpredial=round($predial+$otros+$totalintereses-$descipred+$ipredial,0);
                                //echo "$predial+$otros+$totalintereses-$descipred+$ipredial <br>";
                                $totalpagar=round($totalpredial- round($tdescuentos,0),0);
                            
                                $sqlrat="SELECT TB1.idpredial FROM tesoliquidapredial_det TB1, tesoliquidapredial TB2 WHERE TB1.idpredial=TB2.idpredial AND TB2.codigocatastral='$r[1]' AND TB1.vigliquidada='$r[0]' AND TB2.estado='S'";
                                $resat=mysql_fetch_row(mysql_query($sqlrat,$linkbd));
                                if($resat[0]!="")
                                {
                                    $varcol='resaltar01';
                                    $clihis="onDblClick='hisliquidacion(\"$resat[0]\");'"; 
                                    $titvig="title='Periodo con Liquidaci�n vigente N� $resat[0]'";
                                    $_POST[var1]=$resat[0];
                                }
                                else 
                                {
                                    $sqlrat2="SELECT TB1.id_auto FROM tesoautorizapredial_det TB1, tesoautorizapredial TB2 WHERE TB1.id_auto=TB2.id_auto AND TB2.codcatastral='$r[1]' AND TB1.vigencia='$r[0]' AND TB2.estado='S'";
                                    $resat2=mysql_fetch_row(mysql_query($sqlrat2,$linkbd));
                                    if($resat2[0]!="")
                                    {
                                        $varcol='resaltar01';
                                        $clihis="onDblClick='hisautorizacion(\"$resat2[0]\");'"; 
                                        $titvig="title='Periodo con Autorizaci�n de Liquidaci�n vigente N� $resat2[0]'";
                                        $_POST[var2]=$resat2[0];
                                    }
                                    else{$varcol=$co;$clihis=""; $titvig="";}
                                }
                                if($r[3]=="N")
                                {
                                echo "
                                <input type='hidden' name='dvigencias[]' value='$r[0]' />
                                <input type='hidden' name='dcodcatas[]' value='$r[1]'/>
                                <input type='hidden' name='dvaloravaluo[]' value='$base'/>
                                <input type='hidden' name='dtasavig[]' value='$tasav'/>
                                <input type='hidden' name='ddescintpredial[]' value='$descintpredial'/>
                                <input type='hidden' name='ddescintbomberil[]' value='$descintbomberil'/>
                                <input type='hidden' name='dhavaluos[]' value='$totalpagar'/>
                                <input type='hidden' name='dias[]' value='$diasd'/>
                                <tr class='$varcol' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
                        onMouseOut=\"this.style.backgroundColor=anterior\" $clihis $titvig>
                                    <td>$r[0]</td>
                                    <td>$r[1]</td>
                                    <td style='text-align:right;'><input type='text' name='dpredial[]' value='$predial'/></td>
                                    <td style='text-align:right;'><input type='text' name='dipredial[]' value='$ipredial'/></td>
                                    <td style='text-align:right;'><input type='text' name='ddescipredial[]' value='$descipred'/></td>
                                    <td style='text-align:right;'><input type='text' name='ditpredial[]' value='".($ipredial-$descipred)."'/></td>
                                    <td style='text-align:right;'><input type='text' name='dimpuesto1[]' value='".($valoringreso[0]+0)."'/></td>
                                    <td style='text-align:right;'><input type='text' name='dinteres1[]' value='".($intereses[0]+0)."'/></td>
                                    <td style='text-align:right;'><input type='text' name='dimpuesto2[]' value='".($valoringreso[1]+0)."'/></td>
                                    <td style='text-align:right;'><input type='text' name='dinteres2[]' value='".($intereses[1]+0)."'/></td>";
                                    if($alumbrado>0)
                                    {
                                        echo "<td style='text-align:right;'><input type='text' name='dvalorAlumbrado[]' value='$valorAlumbrado'/></td>";
                                    }
                                    echo "
                                    <td style='text-align:right;'><input type='text' name='ddescuentos[]' value='$tdescuentos'/></td>
                                    <td style='text-align:right;'><input type='text' name='davaluos[]' value='".($totalpagar)."'/></td>
                                    <td style='text-align:right;'>".number_format($diasd,0)."</td>
                                    <td><input type='checkbox' name='dselvigencias[]' value='$r[0]' $chk></td>
                                </tr>";
                                
                                $_POST[totalc]=$_POST[totalc]+$_POST[davaluos][$x];
                                $_POST[totalcf]=number_format($_POST[totalc],2,".",",");
                                $aux=$co;
                                $co=$co2;
                                $co2=$aux;
                                $xpm=$xpm+1;
                                }
                                
                            
                            }
                            }
                        }
 						$resultado = convertir($_POST[totliquida]);
						$_POST[letras]=$resultado." PESOS M/CTE";	
					?> 
      			</table>
      		</div>
      		<table class="inicio">
                <tr>
                    <td class="saludo1">Total Liquidacion:</td>
                    <td><input type="text" name="totliquida" value="<?php echo $_POST[totliquida]?>" size="12" ></td>
                    <td class="saludo1">Total Predial:</td>
                    <td><input type="hidden" name="intpredial" value="<?php echo $_POST[intpredial]?>"><input type="text" name="totpredial" value="<?php echo $_POST[totpredial]?>" size="9" ></td>
                    <td class="saludo1">Total Sobret Bomberil:</td>
                    <td><input type="hidden" name="intbomb" value="<?php echo $_POST[intbomb]?>"><input type="text" name="totbomb" value="<?php echo $_POST[totbomb]?>" size="9" ></td><td class="saludo1">Total Sobret Ambiental:</td>
                    <td><input type="hidden" name="intamb" value="<?php echo $_POST[intamb]?>"><input type="text" name="totamb" value="<?php echo $_POST[totamb]?>" size="9" ></td><td class="saludo1">Total Intereses:</td>
                    <td><input type="text" name="totint" value="<?php echo $_POST[totint]?>" size="9" ></td>
                    <td class="saludo1">Total Descuentos:</td>
                    <td><input type="text" name="totdesc"  value="<?php echo $_POST[totdesc]?>" size="9" ></td>
                </tr>
                <tr>
                    <td class="saludo1" >Son:</td>
                    <td colspan="8"><input type="text" name="letras"  value="<?php echo $_POST[letras]?>" size="155"></td>
                </tr>
      		</table>
            <input type="hidden" name="var1" id="var1"  value="<?php echo $_POST[var1];?>" />
            <input type="hidden" name="var2" id="var2"  value="<?php echo $_POST[var2];?>" />
			<?php
                if ($_POST[oculto]=='2')
                {
					$user=$_SESSION[cedulausu];
					if($_POST[var1]!=0)
					{
						$sqlr="UPDATE tesoliquidapredial SET estado='N' WHERE idpredial=$_POST[var1]";
						mysql_query($sqlr,$linkbd);
						$sqlr="UPDATE tesoliquidapredial_det SET estado='N' WHERE idpredial=$_POST[var1]";
						mysql_query($sqlr,$linkbd);
					}
					if($_POST[var2]!=0)
					{
						$sqlr="UPDATE tesoautorizapredial SET estado='N' WHERE id_auto=$_POST[var2]";
						mysql_query($sqlr,$linkbd);
						$sqlr="UPDATE tesoautorizapredial_det SET estado='N' WHERE id_auto=$_POST[var2]";
						mysql_query($sqlr,$linkbd);
					}
                    ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
                    $fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];

                    

					$_POST[numpredial]=selconsecutivo('tesoliquidapredial','idpredial');
                    $sqlr="insert into tesoliquidapredial 
                    (
                        idpredial,
                        codigocatastral,
                        fecha,vigencia,
                        tercero,
                        tasamora,
                        descuento,
                        tasapredial,
                        totaliquida,
                        totalpredial,
                        totalbomb,
                        totalmedio,
                        totalinteres, 
                        intpredial, 
                        intbomb,
                        intmedio,
                        totaldescuentos,
                        concepto,
                        estado,
                        ord,
                        tot) values 
                        (
                            '$_POST[numpredial]',
                            '$_POST[catastral]',
                            '$fechaf',
                            '$vigusu', 
                            '$_POST[tercero]',
                            '$_POST[tasamora]',
                            '$_POST[descuento]',
                            '$_POST[tasa]',
                            '$_POST[totliquida]',
                            '$_POST[totpredial]', 
                            '$_POST[totbomb]',
                            '$_POST[totamb]' ,
                            '$_POST[totint]',
                            '$_POST[intpredial]',
                            '$_POST[intbomb]',
                            '$_POST[intamb]',
                            '$_POST[totdesc]',
                            '".utf8_decode("A�os Liquidados:".$ageliqui)."',
                            'S',
                            '$_POST[ord]',
                            '$_POST[tot]')";
					//echo $sqlr;
                    if(!mysql_query($sqlr,$linkbd))
                    {echo "<script>despliegamodalm('visible','2','No Se ha podido Liquidar el Predial');</script>";}
                    else
                    {
                        $sqlrmanual = "INSERT INTO tesoliquidapredialmanual (idpredial,user) VALUES ('$_POST[numpredial]','$user')"; 
                        mysql_query($sqlrmanual,$linkbd);
                        $idp=$_POST[numpredial]; 
                        echo "<input name='idpredial' value='$idp' type='hidden' >";
                        for ($y=0;$y<count($_POST[dselvigencias]);$y++)
                        {
                            for($x=0;$x<count($_POST[dvigencias]);$x++)
                            {
                                if($_POST[dvigencias][$x]==$_POST[dselvigencias][$y])
                                {
                                    $sqlr="insert into tesoliquidapredial_det (idpredial,vigliquidada,avaluo,tasav,predial,intpredial,bomberil, intbomb,medioambiente,intmedioambiente,descuentos,totaliquidavig,estado) values ('$idp','".$_POST[dvigencias][$x]."','".$_POST[dvaloravaluo][$x]."','".$_POST[dtasavig][$x]."','".$_POST[dpredial][$x]."','".$_POST[ditpredial][$x]."','".$_POST[dimpuesto1][$x]."','".$_POST[dinteres1][$x]."','".$_POST[dimpuesto2][$x]."','".$_POST[dinteres2][$x]."','".$_POST[ddescuentos][$x]."','".$_POST[davaluos][$x]."','S')";
									mysql_query($sqlr,$linkbd);
									$ageliqui=$ageliqui." ".$_POST[dselvigencias][$y];
									
									$sql = "INSERT INTO tesoliquidapredial_desc (id_predial, cod_catastral, vigencia, descuentointpredial, descuentointbomberil, descuentointambiental, val_alumbrado, estado, user) VALUES ($idp,'$_POST[catastral]','".$_POST[dvigencias][$x]."','".$_POST[ddescintpredial][$x]."','".$_POST[ddescintbomberil][$x]."',0,'".$_POST[dvalorAlumbrado][$x]."','S',$user)";
									mysql_query($sql,$linkbd);
                                }
                            }		 
                        }
						echo"
						<script>
							document.form2.numpredial.value='$_POST[numpredial]';
							despliegamodalm('visible','1','Se ha Liquidado el Predial de los a�os: $ageliqui');
						</script>";  
                    }  
                }
				ini_set('max_execution_time', 180);
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