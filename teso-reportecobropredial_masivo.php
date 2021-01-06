<?php
	require "comun.inc";
	require "funciones.inc";
	require "conversor.php";
	sesion();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
	ini_set('max_execution_time', 100000);
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
    	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: SPID - Tesoreria</title>
		<script>
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
			function funcionmensaje(){document.location.href = "teso-buscareportecobropredial.php";}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":
						document.form2.oculto.value="2";
						document.form2.submit();
						break;
				}
			}
			function pdf()
			{
			document.form2.action="pdfcobropredial_masivo.php";
			document.form2.target="_BLANK";
			document.form2.submit(); 
			document.form2.action="";
			document.form2.target="";
			}

			function excel()
			{
			document.form2.action="xlscobropredial_masivo.php";
			document.form2.target="_BLANK";
			document.form2.submit(); 
			document.form2.action="";
			document.form2.target="";
			}

			</script>
			<script>
			function buscar()
			 {
			 document.form2.buscav.value='1'; 	
			 document.form2.submit();
			 }
			</script>

			<script>
			function buscavigencias(objeto)
			 {
				document.form2.buscav.value='1'; 
			 document.form2.buscarvig.value='1';
			vvigencias=document.getElementsByName('dselvigencias[]');
			vtotalpred=document.getElementsByName("dpredial[]"); 	
			vtotaliqui=document.getElementsByName("dhavaluos[]"); 	
			vtotalbomb=document.getElementsByName("dimpuesto1[]"); 	
			vtotalmedio=document.getElementsByName("dimpuesto2[]"); 	
			vtotalintp=document.getElementsByName("dipredial[]"); 	
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
			 }

				function refrescar()
				{
					document.form2.excel.value="";
					document.form2.action="";
					document.form2.target="";
					//document.form2.submit();
				}
				function guardar()
				{
					if (document.form2.codcat.value!='')
					{
						despliegamodalm('visible','4','Esta Seguro de Guardar','1');
					}
					else
					{
						despliegamodalm4('visible','2','Falta informaci\xf3n para poder guardar')
						document.form2.nombre.focus();
						document.form2.nombre.select();
					}
				}
</script>

<script src="css/programas.js"></script>
<script src="css/calendario.js"></script>
<link href="css/css2.css" rel="stylesheet" type="text/css" />
<link href="css/css3.css" rel="stylesheet" type="text/css" />
<link href="css/tabs.css" rel="stylesheet" type="text/css" />

<script>

	var valordeuda=document.getElementById('valordeuda').value;

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
				<td colspan="3" class="cinta">
					<a href="teso-reportecobropredial_masivo.php" class="mgbt" ><img src="imagenes/add.png" alt="Nuevo"  border="0" /></a> 
					<a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png"  alt="Guardar" /></a> 
					<a href="teso-buscareportecobropredial.php" class="mgbt"> <img src="imagenes/busca.png"  alt="Buscar" /></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana"></a> 
					<a href="teso-gestionpredial.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
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
		$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
		$vigencia=$vigusu;
		 ?>	
		<?php
		if(0>diferenciamesesfechas_f2($_POST[fecha],$_POST[fechaav]))
			{
			 ?>
			 <script>
			 	alert("LA FECHA DE PROYECCION DE LIQUIDACION NO PUEDE SER MENOR A LA FECHA ACTUAL")
			 </script>
			 <?php
			 $_POST[fechaav]=$_POST[fecha];
			}
				  //*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
				if(!$_POST[oculto])
				{
					$linkbd=conectar_bd();
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
					$sqlr="select valor_inicial,valor_final, tipo from dominios where nombre_dominio='DESC_INTERESES' ";
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
					$sqlr="select *from tesotasainteres where vigencia='$vigusu'";
					$res=mysql_query($sqlr,$linkbd);
					$r=mysql_fetch_row($res);
					$tasam=array();
					$errorcar=array();
					$errorvig=array();
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
					
				}

				switch($_POST[tabgroup1])
				{
					case 1:
					$check1='checked';
					break;
					case 2:
					$check2='checked';
					break;
					case 3:
					$check3='checked';
				}
			?>
		 <form name="form2" method="post" action="teso-reportecobropredial_masivo.php">
		 <?php
		  	$linkbd=conectar_bd();
			$sqlr="Select max(idconsulta) from tesocobroreporte";
			$res=mysql_query($sqlr,$linkbd);
			$row=mysql_fetch_row($res);
		  	$_POST[idconsul]=$row[0]+1;

			$sqlr="select *from configbasica where estado='S'";
			$res=mysql_query($sqlr,$linkbd);
			while($row=mysql_fetch_row($res))
		 	{
		  		$nit=$row[0];
		  		$rs=$row[1];
		  		$nalca=$row[6];
		 	}
		?>
		    <table class="inicio" align="center" >
		    	<tr >
		        	<td class="titulos" colspan="9">Liquidar Predial Masivo</td><td width="72" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
		     	</tr>
		     	<tr>
		     		<td class="saludo1">Busqueda No:</td><td><input name="numpredial" type="text" value="<?php echo $_POST[idconsul]?>"  size="8" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly></td>

		     		<td class="saludo1">Fecha:</td><td><input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" style="width: 65%" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly></td>

		     		<td class="saludo1">Vigencia:</td><td><input name="vigencia" type="text" value="<?php echo $_POST[vigencia]?>" maxlength="2" size="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly></td>

		     		<td class="saludo1">Tasa Interes Mora:</td><td><input name="tasamora" type="text" value="<?php echo $_POST[tasamora]?>" size="5" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly>%</td>
		    	</tr>
			  	<tr>
			  		<td class="saludo1">Proy Liquidaci&oacuten:</td><td><input name="fechaav" type="text" value="<?php echo $_POST[fechaav]?>" maxlength="10" size="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" readonly>   <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/calendario04.png" style="width:20px" align="absmiddle" border="0"></a></td> 

			  		<td width="128" class="saludo1">Codigo Catastral Inicial:</td>
		          	<td  ><input id="codcat" type="text" name="codcat" size="20" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[codcat]?>" ><input type="hidden" value="0" name="bt">  <a href="#" onClick="	mypop=window.open('catastral-ventana2.php','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=900,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a><input type="hidden" name="chacuerdo" value="1"><input type="hidden" value="1" name="oculto"></td>


				  	<td width="128" class="saludo1">Codigo Catastral Final:</td>
		          	<td><input id="codcat2" type="text" name="codcat2" size="20" onKeyUp="return tabular(event,this)"  value="<?php echo $_POST[codcat2]?>" ><a href="#" onClick="mypop=window.open('catastral-ventana3.php','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=900,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a></td>
					<input type="hidden" name="chacuerdo" value="1"/>
                    <input type="hidden" name="bt" value="0"/>
                    <input type="hidden" name="basepredial" value="<?php echo  $_POST[basepredial] ?>"/>
					<input type="hidden" name="basepredialamb" value="<?php echo  $_POST[basepredialamb] ?>"/>
					<input type="hidden" name="aplicapredial" value="<?php echo  $_POST[aplicapredial] ?>"/>
					<input type="hidden" name="vigmaxdescint" value="<?php echo  $_POST[vigmaxdescint] ?>"/>
					<input type="hidden" name="porcdescint" value="<?php echo  $_POST[porcdescint] ?>"/>
					<input type="hidden" name="aplicadescint" value="<?php echo  $_POST[aplicadescint] ?>"/>
		         	 <td class="saludo1">Deuda superior a:</td><td><input name="deudasuperior" id="deudasuperior" type="text" value="<?php echo "$_POST[deudasuperior]"; ?>" size="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"></td>
						
				 	 <td>
				  		<input type="hidden" value="<?php echo $_POST[buscav]?>" name="buscav" id="buscav">
						<input type="button" name="buscarb" id="buscarb" value="   Buscar   " onclick="buscar()" >
					</td>
		        </tr>
		        <tr>
		        	<td class="saludo1" style='width:10%'>Tipo:</td>
                	<td>
                    	<select name="tipop">
       						<option value="">Seleccione ...</option>
				  			<option value="urbano" <?php if($_POST[tipop]=='urbano') echo "SELECTED"?>>Urbano</option>
  				  			<option value="rural" <?php if($_POST[tipop]=='rural') echo "SELECTED"?>>Rural</option>
				 		</select>
                    </td>
					<td class="saludo1" style='width:10%'>Cantidad vigencias Deuda:</td>
                	<td>
                    	<select name="anosdeuda" style="width: 65%">
       						<option value="">Seleccione ...</option>
				  			<option value="1" <?php if($_POST[anosdeuda]=='1') echo "SELECTED"?> >1</option>
  				  			<option value="2" <?php if($_POST[anosdeuda]=='2') echo "SELECTED"?> >2</option>
							<option value="3" <?php if($_POST[anosdeuda]=='3') echo "SELECTED"?> >3</option>
							<option value="4" <?php if($_POST[anosdeuda]=='4') echo "SELECTED"?> >4</option>
							<option value="5" <?php if($_POST[anosdeuda]=='5') echo "SELECTED"?> >5</option>
							<option value="6" <?php if($_POST[anosdeuda]=='6') echo "SELECTED"?> >6</option>
							<option value="7" <?php if($_POST[anosdeuda]=='7') echo "SELECTED"?> >7</option>
							<option value="8" <?php if($_POST[anosdeuda]=='8') echo "SELECTED"?> >8</option>
							<option value="9" <?php if($_POST[anosdeuda]=='9') echo "SELECTED"?> >9</option>
							<option value="11" <?php if($_POST[anosdeuda]=='11') echo "SELECTED"?> >11</option>
							<option value="12" <?php if($_POST[anosdeuda]=='12') echo "SELECTED"?> >12</option>
							<option value="13" <?php if($_POST[anosdeuda]=='13') echo "SELECTED"?> >13</option>
							<option value="14" <?php if($_POST[anosdeuda]=='14') echo "SELECTED"?> >14</option>
							<option value="15" <?php if($_POST[anosdeuda]=='15') echo "SELECTED"?> >15</option>
							<option value="16" <?php if($_POST[anosdeuda]=='16') echo "SELECTED"?> >16</option>
				 		</select>
                    </td>
					<td class="saludo1" style='width:10%'>Vigencia Limite</td>
                	<td>
                    	<select name="tipov">
							<option value="2020">2020</option>
							<option value="2019" <?php if($_POST[tipov]=='2019') echo "SELECTED"?>>2019</option>
							<option value="2018" <?php if($_POST[tipov]=='2018') echo "SELECTED"?>>2018</option>
				  			<option value="2017" <?php if($_POST[tipov]=='2017') echo "SELECTED"?>>2017</option>
  				  			<option value="2016" <?php if($_POST[tipov]=='2016') echo "SELECTED"?>>2016</option>
  				  			<option value="2015" <?php if($_POST[tipov]=='2015') echo "SELECTED"?>>2015</option>
  				  			<option value="2014" <?php if($_POST[tipov]=='2014') echo "SELECTED"?>>2014</option>
  				  			<option value="2013" <?php if($_POST[tipov]=='2013') echo "SELECTED"?>>2013</option>
				 		</select>
                    </td>
		        </tr>
			</table>

			<div class="subpantallac6">
				<table class="inicio">
						   	   				<tr>
						   	     				<td colspan="12" class="titulos">Periodos a Liquidar  </td>
						   	   				</tr>                  
											<tr>
												<td  class="titulos2">Vigencia</td>
												<td  class="titulos2">Codigo Catastral</td>
											   	<td class="titulos2">Predial</td>
											   	<td  class="titulos2">Intereses</td>          
												<td  class="titulos2">Sobretasa Bombe</td>
											    <td  class="titulos2">Intereses</td>
												<td class="titulos2">Sobretasa Amb</td>
											    <td  class="titulos2">Intereses</td>
											    <td  class="titulos2">Descuentos</td>
											    <td  class="titulos2">Valor Total</td>
											    <td  class="titulos2">Dias Mora</td>
												</tr>

				<?php
				
					if ($_POST[buscav]=='1') 
					{
						$iter='saludo1a';
						$iter2='saludo2';
						$crit01='';
						if ($_POST[tipop]!='') {$crit01="AND tesopredios.tipopredio='$_POST[tipop]'";}
						$cantidad=$_POST[anosdeuda];
						
						if(!empty($cantidad)){
							$sqlr="select tesopredios.cedulacatastral, tesopredios.clasifica,tesopredios.tipopredio,tesopredios.nombrepropietario,tesopredios.vigencia from tesopredios where tesopredios.cedulacatastral between '$_POST[codcat]' and '$_POST[codcat2]' and tesopredios.estado='S' AND tesopredios.DOCUMENTO<>'$nit' AND tesopredios.nombrepropietario NOT LIKE '%NACION%' AND tesopredios.nombrepropietario NOT LIKE '%MUNICIPIO%' $crit01 GROUP BY tesopredios.cedulacatastral  ORDER BY tesopredios.cedulacatastral  ";
						}else{
							$sqlr="select tesopredios.cedulacatastral, tesopredios.clasifica,tesopredios.tipopredio,tesopredios.nombrepropietario,tesopredios.vigencia from tesopredios where tesopredios.cedulacatastral between '$_POST[codcat]' and '$_POST[codcat2]' and tesopredios.estado='S' AND tesopredios.DOCUMENTO<>'$nit' AND tesopredios.nombrepropietario NOT LIKE '%NACION%' AND tesopredios.nombrepropietario NOT LIKE '%MUNICIPIO%' $crit01 GROUP BY tesopredios.cedulacatastral  ORDER BY tesopredios.cedulacatastral  ";
						}
			  			
			  			//echo $sqlr;
			  			$resp=mysql_query($sqlr,$linkbd);
						$cv=0;
						$xpm=0;
						$sq="select interespredial from tesoparametros ";
						$result=mysql_query($sq,$linkbd);
						$rw=mysql_fetch_row($result);
						$interespredial=$rw[0];
						$sq="SELECT idacuerdo FROM tesoacuerdopredial WHERE codcatastral='$_POST[codcat]'";
						$rs=mysql_query($sq,$linkbd);
						$idacuerdopre=mysql_fetch_row($rs);
			  			while($rp=mysql_fetch_row($resp))
			  			{		
							$sql="SELECT * FROM tesoacuerdopredial_det WHERE idacuerdo='$idacuerdopre[0]' and vigencia='$r[0]'";
							$rst=mysql_query($sql,$linkbd);
							if(!mysql_fetch_row($rst))
							{
								//echo "$rp[0] <br>";
								ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechaav],$fecha);
								$fechaactual=$fecha[3]."-".$fecha[2]."-".$fecha[1];					
								//$tasaintdiaria=(pow((1+$_POST[tasamora]/100),(1/365))-1); Compuesta
								$tasaintdiaria=($_POST[tasamora]/100);
								$cuentavigencias=0;
								$tdescuentos=0;
								$totalpagar=0;
								$npredialant=0;
								$otros=0;
								$valoringresos=0;
								//echo $rp[0]."</br>";
								$sqlr2="select *from tesotarifaspredial where vigencia='$r[0]' and tipo='$r[5]' and estratos='$r[6]'";
								//echo $sqlr2;
								$res2=mysql_query($sqlr2,$linkbd);
								$row2=mysql_fetch_row($res2);
								$base=$r[2];
								$tasaxmil=$r[8];
								//$_POST[vavaluo]=$row[2];
								$valorperiodo=$base*($tasaxmil/1000)-$base*($tasaxmil/1000)*($_POST[deduccion]/100);
								//echo "$valorperiodo=$base*($row2[5]/1000)-$base*($row2[5]/1000)*($_POST[deduccion]/100) </br>";
								$tasav=$row2[5];
								$predial=round($base*($tasaxmil/1000)-$base*($tasaxmil/1000)*($_POST[deduccion]/100),2);
								$sqlr1="
								SELECT DISTINCT TB1.vigencia,TB1.codigocatastral,TB1.avaluo,TB1.pago,TB1.estado,TB1.tipopredio,TB1.estratos,TB1.areacon
								FROM tesoprediosavaluos TB1
								WHERE TB1.codigocatastral = '$rp[0]'
								AND TB1.estado = 'S'
								AND (TB1.pago = 'N')
								ORDER BY TB1.vigencia ASC ";
								
								//echo $sqlr1;
								$res1=mysql_query($sqlr1,$linkbd);
								$cuentavigencias = mysql_num_rows($res1);
								$cv=0;	
								$inicioCobro1 = 0;
								$inicioCobro2 = 0;
								$inicioCobro3 = 0;
								$valoringresos=0;
								$sidescuentos=0;
								//****buscar en el concepto del ingreso *******
								$intereses=array();
								$valoringreso=array();
								$in=0;							
								//echo $cuentavigencias;
								if($cuentavigencias>0)
								{ 
								while($r=mysql_fetch_row($res1))
								{	
									$sqlr2="select IF(tasa='-1',0,tasa) from tesoprediosavaluos where vigencia='$r[0]' and codigocatastral='$r[1]' " ;
									$res2=mysql_query($sqlr2,$linkbd);
									$row2=mysql_fetch_row($res2);
									$base=$r[2];
									$valorperiodo=$base*($row2[0]/1000)-$base*($row2[0]/1000)*($_POST[deduccion]/100);
									$tasav=$row2[0];
									$predial=round($base*($row2[0]/1000)-$base*($row2[0]/1000)*($_POST[deduccion]/100),2);
									if($_POST[aplicapredial]=='S')
									{
										$sqlrp="select distinct * from tesoprediosavaluos where tesoprediosavaluos.codigocatastral='$r[1]' and vigencia=".($r[0]-1)." ";		
										//echo $sqlrp;
										$respr=mysql_query($sqlrp,$linkbd);
										$rowpr=mysql_fetch_row($respr);
										$baseant=0;		
										$estant=$rowpr[3];
										$baseant=$rowpr[2]+0;
										$predialant=$baseant*($rowpr[10]/1000);
										$areaanterior=$rowpr[9];
										if($estant=='S')
										{									
											$sqlrav="select distinct tesoliquidapredial_det.predial,tesoliquidapredial_det.avaluo from tesoliquidapredial_det,tesoliquidapredial where tesoliquidapredial_det.idpredial=tesoliquidapredial.idpredial and tesoliquidapredial.codigocatastral='$r[1]' and tesoliquidapredial.estado='P' AND tesoliquidapredial_det.vigliquidada='".($r[0]-1)."'";
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
										}
										else
										{
											
											if(($predialant>($npredialant*2)) && ($npredialant>0))
											{
												$predialant=$npredialant;
											}
											if($predial>($predialant*2) && $r[7]==$areaanterior)
											{	
												$predial=$predialant*2;													
											}	 
										}
										$npredialant=$predial;
										
									}
											$valoringresos=0;
											$sidescuentos=0;
											//****buscar en el concepto del ingreso *******
											$intereses=array();
											$valoringreso=array();
											$in=0;

											if($cuentavigencias>1)
			 				{
								$diasd=0;
								$totalintereses=0; 
								 $tdescuentos=0;
								$sidescuentos=1;
								if($vigusu==$r[0] && ($_POST[descuento]>0 or $condes==1) )
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

							$res3=mysql_query($sqlr2,$linkbd);
							while($r3=mysql_fetch_row($res3))
							{

								if($r3[5]>0 && $r3[5]<100)
					 			{
					  				if($r3[2]=='03')
					    			{
	
										if( $_POST[basepredial]==1)	
										{
				
											$valoringreso[0]=round($base*($r3[5]/1000),0)-($base*($r3[5]/1000)*($_POST[deduccion]/100));
											$valoringresos+=round($base*($r3[5]/1000),0)-($base*($r3[5]/1000)*($_POST[deduccion]/100));	
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
														if($i <= $mesesIntereses[1] && $inicioCobro1==0)
														{
															continue;
														}
														
													}
													$numdias = cal_days_in_month(CAL_GREGORIAN, $i, $vigcal);
													$totdiastri += $numdias;
													if($i==$fechainiciocobro && $vigcal==$fechafd[3])
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
													$inicioCobro1 = 1;
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
														if($i <= $mesesIntereses[1] && $inicioCobro2==0)
														{
															continue;
															
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
													$inicioCobro2 = 1;
												}
												$vigcal+=1;
											}
					  					$totalintereses+=$intereses[1];
					   				}	
					  				
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
											//$rowinteres[$i-1]=0;
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
										if($i <= $mesesIntereses[1] && $inicioCobro3==0)
										{
											continue;
										}
										
										
									}
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
									$inicioCobro3 = 1;
								}
								$vigcal+=1;
							}
							$descipred=0;
											if($r[0]<=$_POST[vigmaxdescint] && $_POST[aplicadescint]=='S')
											{
												//$descipred=$ipredial*($_POST[porcdescint]/100)+$intereses[0]*($_POST[porcdescint]/100)+$intereses[1]*($_POST[porcdescint]/100);
											}
											$totalpredial=round($predial+$otros+$totalintereses-$descipred+$ipredial,0);
											$totalpagar=round($totalpredial,0);
											//echo "total predial: $r[0] $r[1] - $totalpredial=round($predial+$otros+$totalintereses-$descipred+$ipredial,0);"."::::";
											$otros=0;
											$ch=esta_en_array($_POST[dselvigencias], $r[0]);
											if($ch==1)
											 //{
											 $chk="checked";
											 
												# code...
											 
											// }
											//*************	
											$_POST[nompropietario][]=$rp[3];
											$_POST[dvigencias][]=$r[0];
											$_POST[dcodcatas][]=$r[1];
											$_POST[dvaloravaluo][]=$base;
											$_POST[dtasavig][]=$tasav;
											$_POST[dpredial][]=$predial;
											$_POST[dipredial][]=$ipredial;
											$_POST[dimpuesto1][]=$valoringreso[0];
											$_POST[dinteres1][]=$intereses[0];
											$_POST[dimpuesto2][]=$valoringreso[1];
											$_POST[dinteres2][]=$intereses[1];
											$_POST[ddescuentos][]=$tdescuentos;
											$_POST[davaluos][]=number_format($totalpagar,2);
											$_POST[dhavaluos][]=$totalpagar;
											$_POST[dias][]=$diasd;
											$_POST[dselvigencias][]=$r[0];
											$_POST[varcheck][]=$chk;

											//$_POST[totalc]=$_POST[totalc]+$_POST[dhavaluos][$x];
											//$_POST[totalcf]=number_format($_POST[totalc],2,".",",");
											//$ageliqui=$ageliqui." ".$_POST[dselvigencias][$x];
									}
									//$resultado = convertir($_POST[totliquida]);
									//$_POST[letras]=$resultado." PESOS M/CTE";	
									//			$_POST[valmax]=$cn;	
								}//***fin condicion de total vigencias
							}//****fin del while principal		
						}			
						$xx=0;
						$varconta= count($_POST[dvigencias]);
						// echo "varc-".$varconta;
						$xy=0;
						$zz=0;
						//echo $varconta."<br>";
						while ($xx < $varconta)
						{
							$sumatotal=0;
							$conta=0;
							for ($xy=0; $xy < $varconta; $xy++) { 
								if($_POST[dcodcatas][$xy]==$_POST[dcodcatas][$xx])
								{
									$sumatotal=$sumatotal+$_POST[dhavaluos][$xy];
									$conta+=1;
								}
							}
							$sumafinal=$sumatotal;
							if ($sumafinal>=$_POST['deudasuperior']  && $_POST[dvigencias][$xx]>$_POST[tipov].value-$cantidad && $_POST[dvigencias][$xx]<$_POST[tipov].value)
							{
								$aux=$iter;
								$iter=$iter2;
								$iter2=$aux;
								$zz+=1;
								echo "
									 <tr class='$iter'>
										<td >".$_POST[dvigencias][$xx]."</td>
										<td >".$_POST[dcodcatas][$xx]."</td>
										<td >$ ".number_format($_POST[dpredial][$xx],2)."</td>
										<td >$ ".number_format($_POST[dipredial][$xx],2)."</td>
										<td >$ ".number_format($_POST[dimpuesto1][$xx],2)."</td>
										<td >$ ".number_format($_POST[dinteres1][$xx],2)."</td>
										<td >$ ".number_format($_POST[dimpuesto2][$xx],2)."</td>
										<td >$ ".number_format($_POST[dinteres2][$xx],2)."</td>
										<td >$ ".number_format($_POST[ddescuentos][$xx],2)."</td>
										<td >$ ".$_POST[davaluos][$xx]."</td>
										<td >".$_POST[dias][$xx]."</td>
									</tr>";
										
										
										echo"
										 <input type='hidden' name='dvigencias1[]' value='".$_POST[dvigencias][$xx]."'/>
										 <input type='hidden' name='dcodcatas1[]' value='".$_POST[dcodcatas][$xx]."' />
										 <input type='hidden' name='dpredial1[]' value='".$_POST[dpredial][$xx]."' />
										 <input type='hidden' name='dipredial1[]' value='".$_POST[dipredial][$xx]."' />
										 <input type='hidden' name='dimpuesto11[]' value='".$_POST[dimpuesto1][$xx]."' />
										 <input type='hidden' name='dinteres11[]' value='".$_POST[dinteres1][$xx]."' />
										 <input type='hidden' name='dimpuesto21[]' value='".$_POST[dimpuesto2][$xx]."' />
										 <input type='hidden' name='dinteres21[]' value='".$_POST[dinteres2][$xx]."' />
										 <input type='hidden' name='ddescuentos1[]'value='".$_POST[ddescuentos][$xx]."' >
										 <input type='hidden' name='davaluos1[]' value='".$_POST[davaluos][$xx]."'>
										 <input type='hidden' name='dias1[]' value='".$_POST[dias][$xx]."'>
										 <input type='hidden' name='dtasavig1[]' value='".$_POST[dtasavig][$xx]."'>
										 <input type='hidden' name='dvaloravaluo1[]' value='".$_POST[dvaloravaluo][$xx]."'>
										 ";
							}
							$xx++;
						}
						
						?>
							</table>
						<?php
					}
			
			?>
			</div>
			<?php
			if ($_POST[oculto]=='2')
			{
				$linkbd=conectar_bd();
				$valconta=0;
				$query= mysql_query("SELECT MAX(idconsulta) AS id FROM tesocobroreporte");
 				if ($row = mysql_fetch_row($query)) 
				{
   					$id = trim($row[0]);
   					
 				}
				ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
				$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
				$xy=0;
			  	$disc=count($_POST[dcodcatas]);
			  	$nuevo="";
				$actual="";
				$id=$id+1;
				$ric=0;
				$nr=selconsecutivo('tesocobroreporte','numresolucion ');
				$conta=$nr;
				$error=0;
			  	for ($v=0; $v <$zz ; $v++)
			  	{ 
				$query= mysql_query("SELECT vigencia, codcatastral FROM tesocobroreporte where vigencia=".$_POST[dvigencias1][$v]." AND codcatastral=".$_POST[dcodcatas1][$v]);
				$row = mysql_fetch_row($query);
 				if ($row != ""){
					$errorcar[count($errorcar)]=$_POST[dcodcatas1][$v];
					$errorvig[count($errorvig)]=$_POST[dvigencias1][$v];
					$valconta++;
					$nr=$nr+1;
					$error=$error+1;}
				else{
					if($_POST[dcodcatas1][$v]==$_POST[dcodcatas1][$v+1])
					{
						$conta=$conta;
						$res=quitarcomas($_POST[davaluos1][$v]);
						$sqlr="INSERT INTO tesocobroreporte (idconsulta,vigencia,codcatastral,predial,intereses1,sobretasabombe,intereses2,sobretasamb,intereses3,descuentos,totalinteres,valortotal,diasmora,tasavig, avaluo,numresolucion,fecha) VALUES ('$id','".$_POST[dvigencias1][$v]."','".$_POST[dcodcatas1][$v]."','".$_POST[dpredial1][$v]."','".$_POST[dipredial1][$v]."','".$_POST[dimpuesto11][$v]."','".$_POST[dinteres11][$v]."','".$_POST[dimpuesto21][$v]."','".$_POST[dinteres21][$v]."','".$_POST[ddescuentos1][$v]."','$totalint','$res','".$_POST[dias1][$v]."','".$_POST[dtasavig1][$v]."','".$_POST[dvaloravaluo1][$v]."','$conta','$fechaf')";
						mysql_query($sqlr,$linkbd);
						$valconta++;
						$nr=$nr+1;
					}
					else
					{
						$conta=$conta;
						$res=quitarcomas($_POST[davaluos1][$v]);
						$sqlr="INSERT INTO tesocobroreporte (idconsulta,vigencia,codcatastral,predial,intereses1,sobretasabombe,intereses2,sobretasamb,intereses3,descuentos,totalinteres,valortotal,diasmora,tasavig, avaluo,numresolucion,fecha) VALUES ('$id','".$_POST[dvigencias1][$v]."','".$_POST[dcodcatas1][$v]."','".$_POST[dpredial1][$v]."','".$_POST[dipredial1][$v]."','".$_POST[dimpuesto11][$v]."','".$_POST[dinteres11][$v]."','".$_POST[dimpuesto21][$v]."','".$_POST[dinteres21][$v]."','".$_POST[ddescuentos1][$v]."','$totalint','$res','".$_POST[dias1][$v]."','".$_POST[dtasavig1][$v]."','".$_POST[dvaloravaluo1][$v]."','$conta','$fechaf')";
						mysql_query($sqlr,$linkbd);
						$valconta++;
						$nr=$nr+1;
						$conta=$conta+1;
					}
				}
				}
				if ($error==0){
					if ($valconta==0){echo "<script>despliegamodalm('visible','2','No se pudo ejecutar la petici�n');</script>";}
					else {echo "<script>despliegamodalm('visible','1','Se ha almacenado con Exito');</script>";}
				}else {echo "<script>despliegamodalm('visible','2','Por favor verifique la busqueda, No se pueden almacenar algunos registros repetidos');</script>";}
			}
		    ?>
			<div id="bgventanamodal2">
                <div id="ventanamodal2">
                    <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                    </IFRAME>
                </div>
       	 	</div>
		</form>

 	</td>
 </tr>
</table>
</body>
</html>