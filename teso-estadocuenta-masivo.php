<?php //V 1000 12/12/16 ?> 
<?php
	require "comun.inc";
	require "funciones.inc";
	require "conversor.php";
	sesion();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	header("Content-Type: text/html;charset=iso-8859-1");
	date_default_timezone_set("America/Bogota");
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
    	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: SPID - Tesoreria</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
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
				document.form2.action="pdfestadocuentamasivo.php";
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
			function buscar()
 			{
 				document.form2.buscav.value='1'; 	
	 			document.form2.submit();
			}
			function despliegamodal2(_valor)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else {document.getElementById('ventana2').src="catastral-ventana01.php";}
			}
			function despliegamodal21(_valor)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else {document.getElementById('ventana2').src="catastral-ventana02.php";}
			}
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
                    <img src="imagenes/add.png" onClick="location.href='teso-estadocuenta-masivo.php'" title="Nuevo" class="mgbt"/>
					<img src="imagenes/guardad.png" class="mgbt1"/>
					<img src="imagenes/buscad.png" class="mgbt1"/>
					<img src="imagenes/nv.png" title="Nueva Ventana" onClick="<?php echo paginasnuevas("teso");?>" class="mgbt"/>
					<img src="imagenes/print.png" title="Imprimir" onClick="pdf()" class="mgbt"/>
					<img src="imagenes/iratras.png" title="Atr&aacute;s" onClick="location.href='teso-informespredios.php'" class="mgbt"/>
					
                </td>
			</tr>		  
		</table>
		<div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
        <form name="form2" method="post" action="teso-estadocuenta-masivo.php">
			<?php
                $vigusu=vigencia_usuarios($_SESSION[cedulausu]);
                $vigencia=$vigusu;
                if(0>diferenciamesesfechas_f2($_POST[fecha],$_POST[fechaav]))
                {
                    echo"<script>despliegamodalm('visible','2','LA FECHA DE PROYECCION DE LIQUIDACION NO PUEDE SER MENOR A LA FECHA ACTUAL');</script>";
                    $_POST[fechaav]=$_POST[fecha];
                }
                      //*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
                if(!$_POST[oculto])
                {
                    $fec=date("d/m/Y");
                    $_POST[fecha]=$fec; 		
                    $_POST[fechaav]=$_POST[fecha]; 		  			 
                    $_POST[vigencia]=$vigusu; 		
                    $check1="checked";
                    $sqlr="select *from tesotasainteres where vigencia='$vigusu'";
                    $res=mysql_query($sqlr,$linkbd);
                    $r=mysql_fetch_row($res);
                    $tasam=array();
                    $tasam[0]=$r[6];									
                    $tasam[1]=$r[7];
                    $tasam[2]=$r[8];
                    $tasam[3]=$r[9];
                    $tasamoratoria[0]=0;
                    ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
                    if($fecha[2]<=3){$tasamoratoria[0]=$tasam[0];}
                    elseif($fecha[2]<=6){$tasamoratoria[0]=$tasam[1];}
                    elseif($fecha[2]<=9){$tasamoratoria[0]=$tasam[2];}
                    else{$tasamoratoria[0]=$tasam[3];}
                    $_POST[tasamora]=$tasamoratoria[0];   
                    if($_POST[tasamora]==0)
                    {
                        echo"<script>despliegamodalm('visible','2',LA TASA DE INTERES DE MORA ES CERO (0) POR FAVOR ACTUALIZAR EL VALOR');</script>";
                    }
                    $_POST[tasa]=0;
                    $_POST[predial]=0;
                    $_POST[descuento]=0;
                    //***** BUSCAR FECHAS DE INCENTIVOS
                    ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
                    $fechaactual=$fecha[3]."-".$fecha[2]."-".$fecha[1];	
                    $sqlr="select *from tesodescuentoincentivo where vigencia=".$vigusu." and ingreso='01' and estado='S'";
                    $res=mysql_query($sqlr,$linkbd);
                    while($r=mysql_fetch_row($res))
                    {	
                        if($r[7]<=$fechaactual && $fechaactual <= $r[8])
                        {
                            $fdescuento=$r[2];	 
                            $_POST[descuento]=$r[2];	   
                        }
                        elseif($fechaactual>$r[9] && $fechaactual <= $r[10])
                        {
                             $fdescuento=$r[2];	 
                             $_POST[descuento]=$r[3];	   
                        }
                        elseif($fechaactual>$r[11] && $fechaactual <= $r[12])
                        {
                            $fdescuento=$r[2];	 
                            $_POST[descuento]=$r[4];	   
                        }  
                        else {$ulfedes=explode("-",$r[12]);}
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
                    $tasam[0]=$r[6];									
                    $tasam[1]=$r[7];
                    $tasam[2]=$r[8];
                    $tasam[3]=$r[9];
                    $tasamoratoria[0]=0;
                    $sqlr="select *from tesotasainteres where vigencia=".$vigusu;
                    $res=mysql_query($sqlr,$linkbd);
                    $r=mysql_fetch_row($res);
                    $tasam=array();
                    $tasam[0]=$r[6];									
                    $tasam[1]=$r[7];
                    $tasam[2]=$r[8];
                    $tasam[3]=$r[9];
                    $tasamoratoria[0]=0;
                    ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechaav],$fecha);
                    if($fecha[2]<=3){$tasamoratoria[0]=$tasam[0];}
                    elseif($fecha[2]<=6){$tasamoratoria[0]=$tasam[1];}
                    elseif($fecha[2]<=9){$tasamoratoria[0]=$tasam[2];}
                    else{$tasamoratoria[0]=$tasam[3];}						
                    $_POST[tasamora]=$tasamoratoria[0]; 
                    ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechaav],$fecha);
                    $fechaactual=$fecha[3]."-".$fecha[2]."-".$fecha[1];	
                    $sqlr="select *from tesodescuentoincentivo where vigencia='$vigusu' and ingreso='01' and estado='S'";
                    $res=mysql_query($sqlr,$linkbd);
                    while($r=mysql_fetch_row($res))
                    {	
                        if($r[7]<=$fechaactual && $fechaactual <= $r[8])
                        {
                            $fdescuento=$r[2];	 
                            $_POST[descuento]=$r[2];	   
                        }
                        elseif($fechaactual>$r[9] && $fechaactual <= $r[10])
                        {
                            $fdescuento=$r[2];	 
                            $_POST[descuento]=$r[3];	   
                        }
                        elseif($fechaactual>$r[11] && $fechaactual <= $r[12])
                        {
                            $fdescuento=$r[2];	 
                            $_POST[descuento]=$r[4];	   
                        }  
                        else {$ulfedes=explode("-",$r[12]);}
                    }
                }
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
				echo"
				<input type='hidden' name='dvigencias[]' value='$_POST[dvigencias]'/>
				<input type='hidden' name='dcodcatas[]' value='$_POST[dcodcatas]' />
				<input type='hidden' name='dvaloravaluo[]' value='$_POST[dvaloravaluo]'/>
				<input type='hidden' name='dtasavig[]' value='$_POST[dtasavig]'/>
				<input type='hidden' name='dpredial[]' value='$_POST[dpredial]' />
				<input type='hidden' name='dipredial[]' value='$_POST[dipredial]' />
				<input type='hidden' name='dimpuesto1[]' value='$_POST[dimpuesto1]' />
				<input type='hidden' name='dinteres1[]' value='$_POST[dinteres1]' />
				<input type='hidden' name='dimpuesto2[]' value='$_POST[dimpuesto2]' />
				<input type='hidden' name='dinteres2[]' value='$_POST[dinteres2]' />
				<input type='hidden' name='ddescuentos[]' value='$_POST[ddescuentos]' >
				<input type='hidden' name='davaluos[]' value='$_POST[davaluos]'>
				<input type='hidden' name='dhavaluos[]' value='$_POST[dhavaluos]'/>
				<input type='hidden' name='dias[]' value='$_POST[dias]'>
				<input type='hidden' name='dselvigencias2[]' value='$_POST[dselvigencias2]' >
				<input type='hidden' name='varcheck[]' value='$_POST[varcheck]' >";
				$sqlr2="select *from tesotarifaspredial where vigencia='".$vigusu."' and tipo='$_POST[tipop]' and estratos=$tipopp";
				$res2=mysql_query($sqlr2,$linkbd);
			 	while($row2=mysql_fetch_row($res2))
				{
					$_POST[tasa]=$row2[5];
					$_POST[predial]=($row2[5]/1000)*$_POST[vavaluo];
					$_POST[predial]=number_format($_POST[predial],2);
				}
			?>
		    <table class="inicio" align="center" >
		    	<tr >
		        	<td class="titulos" colspan="9">Liquidar Predial</td>
                    <td class="cerrar" style="width:7%" onClick="location.href='teso-principal.php'">Cerrar</td>
		     	</tr>
		     	<tr>
		     		<td class="saludo1">Busqueda No:</td>
                    <td><input name="numpredial" type="text" value="<?php echo $_POST[idconsul]?>"  size="8" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly></td>
		     		<td class="saludo1">Fecha:</td>
                    <td><input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10" size="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly></td>
		     		<td class="saludo1">Vigencia:</td>
                    <td><input name="vigencia" type="text" value="<?php echo $_POST[vigencia]?>" maxlength="2" size="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly></td>
		     		<td class="saludo1">Tasa Interes Mora:</td>
                    <td><input name="tasamora" type="text" value="<?php echo $_POST[tasamora]?>" size="5" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly>%</td>
		    		<td class="saludo1">Descuento:</td>
                    <td><input name="descuento" type="text" value="<?php echo $_POST[descuento]?>"  size="5" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly>%</td >
		    	</tr>
			  	<tr>
			  		<td class="saludo1">Proy Liquidacion:</td>
                    <td><input name="fechaav" type="text" value="<?php echo $_POST[fechaav]?>" maxlength="10" size="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" readonly>   <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a></td> 
			  		<td width="128" class="saludo1">Codigo Catastral Inicial:</td>
		          	<td  ><input id="codcat" type="text" name="codcat" size="20" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[codcat]?>" >
					<input id="ord" type="hidden" name="ord" size="3"  value="<?php echo $_POST[ord]?>" readonly>
					<input id="tot" type="hidden" name="tot" size="3" value="<?php echo $_POST[tot]?>" readonly>
					<a title="Listado de Predios" onClick="despliegamodal2('visible');" style="cursor:pointer;"><img src="imagenes/find02.png" style="width:20px;"></a>
					<input type="hidden" name="chacuerdo" value="1">
					<input type="hidden" value="1" name="oculto"></td>
				  	<td width="128" class="saludo1">Codigo Catastral Final:</td>
		          	<td><input id="codcat2" type="text" name="codcat2" size="20" onKeyUp="return tabular(event,this)"  value="<?php echo $_POST[codcat2]?>" >
					<input id="ord" type="hidden" name="ord" size="3"  value="<?php echo $_POST[ord]?>" readonly>
					<input id="tot" type="hidden" name="tot" size="3" value="<?php echo $_POST[tot]?>" readonly>
					<a title="Listado de Predios" onClick="despliegamodal21('visible');" style="cursor:pointer;"><img src="imagenes/find02.png" style="width:20px;"></a></td>
		         	 <td class="saludo1">Deuda superior a:</td>
                     <td><input name="deudasuperior" id="deudasuperior" type="text" value="<?php echo "$_POST[deudasuperior]"; ?>" size="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"></td>
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
					<td class="saludo1">Deduccion Ajuste:</td>
                    <td><input name="deduccion" value="<?php echo $_POST[deduccion]?>" type="text" size="10" onBlur="document.form2.submit()" ></td>
		        </tr>
			</table>
			<div class="subpantallac6">
				<table class="inicio">
					<tr><td colspan="12" class="titulos">Periodos a Liquidar  </td></tr>                  
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
						<td width="3%" class="titulos2">Sel</td>
          			</tr>
					<input type='hidden' name='buscarvig' id='buscarvig'>
					<?php
						if ($_POST[buscav]=='1') 
						{
							$crit01='';
							if ($_POST[tipop]!='') {$crit01="AND tipopredio='$_POST[tipop]'";}
			  				$sqlr="select distinct cedulacatastral, estratos,tipopredio from tesopredios where tesopredios.cedulacatastral between '$_POST[codcat]' and '$_POST[codcat2]' and tesopredios.estado='S' AND DOCUMENTO<>'$nit' AND nombrepropietario NOT LIKE '%NACION E%' $crit01 ORDER BY tesopredios.cedulacatastral";
			  				$resp=mysql_query($sqlr,$linkbd);
							$sq="select interespredial from tesoparametros ";
							$result=mysql_query($sq,$linkbd);
							$rw=mysql_fetch_row($result);
							$interespredial=$rw[0];
			  				while($rp=mysql_fetch_row($resp))
			  				{		
								ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechaav],$fecha);
								$fechaactual=$fecha[3]."-".$fecha[2]."-".$fecha[1];					
								//$tasaintdiaria=(pow((1+$_POST[tasamora]/100),(1/365))-1); Compuesta
								$tasaintdiaria=($_POST[tasamora]/100);
								$cuentavigencias=0;
								$tdescuentos=0;
								$sqlr1="Select *from tesoprediosavaluos where tesoprediosavaluos.codigocatastral=$rp[0] and   tesoprediosavaluos.estado='S' and tesoprediosavaluos.pago='N' order by tesoprediosavaluos.vigencia ASC ";		
								//echo $sqlr1."</br>";
								$res1=mysql_query($sqlr1,$linkbd);
								$cuentavigencias = mysql_num_rows($res1);
								$cv=0;			
								if($cuentavigencias>0)
								{ 
									while($r=mysql_fetch_row($res1))
									{
										//echo $r[0]."</br>";
										$sqlr2="select *from tesotarifaspredial where vigencia='".$r[0]."' and tipo='$rp[2]' and estratos='$rp[1]'";
										$res2=mysql_query($sqlr2,$linkbd);
										$row2=mysql_fetch_row($res2);
										$base=$r[2];
										$valorperiodo=$base*($row2[5]/1000);
										$tasav=$row2[5];
										$predial=$base*($row2[5]/1000);
										$valoringresos=0;
										$sidescuentos=0;
										//****buscar en el concepto del ingreso *******
										$intereses=array();
										$valoringreso=array();
										$in=0;
										if($cuentavigencias>1)
										{
											if($vigusu==$r[0] && $_POST[descuento]>0)
											{
												$diasd=0;
												$totalintereses=0; 
												$sidescuentos=0;
											}
											elseif ($interespredial=='inicioanio')//Si se cuentan los dias desde el principio del año 
											{
												//$fechaini=mktime(0,0,0,$ulfedes[1],$ulfedes[2],$r[0]);
												//echo "aqui";
												$fechaini=mktime(0,0,0,1,1,$r[0]);
												$fechafin=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
												$difecha=$fechafin-$fechaini;
												$diasd=$difecha/(24*60*60);
												$diasd=floor($diasd);
												$totalintereses=0; 
											}
											else //Si se cuentan los dias desde el principio del año 
											{
												//echo "hola";
												$fechaini=mktime(0,0,0,$ulfedes[1],$ulfedes[2],$r[0]);
												$fechafin=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
												$difecha=$fechafin-$fechaini;
												$diasd=$difecha/(24*60*60);
												$diasd=floor($diasd);
												$totalintereses=0; 
											}
										}
										else
										{ //********* si solo debe la actual vigencia
											$diasd=0;
											$totalintereses=0; 
											$tdescuentos=0;
											$sidescuentos=1;
											if($vigusu==$r[0] && $_POST[descuento]>0)
											{
												$pdescuento=$_POST[descuento]/100; 					
												$tdescuentos+=round(($valorperiodo)*$pdescuento,0);
											}
											elseif ($interespredial=='inicioanio')//Si se cuentan los dias desde el principio del año 
											{
												//$fechaini=mktime(0,0,0,$ulfedes[1],$ulfedes[2],$r[0]);
												//echo "aqui";
												$fechaini=mktime(0,0,0,1,1,$r[0]);
												$fechafin=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
												$difecha=$fechafin-$fechaini;
												$diasd=$difecha/(24*60*60);
												$diasd=floor($diasd);
												$totalintereses=0; 
											}
											else //Si se cuentan los dias desde el principio del año 
											{
												//echo "hola";
												$fechaini=mktime(0,0,0,$ulfedes[1],$ulfedes[2],$r[0]);
												$fechafin=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
												$difecha=$fechafin-$fechaini;
												$diasd=$difecha/(24*60*60);
												$diasd=floor($diasd);
												$totalintereses=0; 
											}
										}
									$sqlr2="select *from tesoingresos_det where codigo='01' and modulo='4' and  estado='S' and vigencia=$vigusu order by concepto";
									$res3=mysql_query($sqlr2,$linkbd);
									$stot=0;
									while($r3=mysql_fetch_row($res3))
									{
										if($r3[5]>0 && $r3[5]<100)
										{
						
											if($r3[2]=='03')
											{
												$valoringreso[0]=round($valorperiodo*($r3[5]/100),0);
												$valoringresos+=round($valorperiodo*($r3[5]/100),0);
												 //$intereses[0]=ceil($valoringreso[0]*(pow(1+$tasaintdiaria,$diasd)-1));  Compuesta
												$intereses[0]=round(($valoringreso[0]*$diasd*$tasaintdiaria)/365,0);
												$totalintereses+=$intereses[0];						
											}

											if($r3[2]=='02')
											{
												$valoringreso[1]=round($valorperiodo*($r3[5]/100),0);
												$valoringresos+=round($valorperiodo*($r3[5]/100),0);
												//$intereses[1]=ceil($valoringreso[1]*(pow(1+$tasaintdiaria,$diasd)-1)); Compuesta
												$intereses[1]=round(($valoringreso[1]*$diasd*$tasaintdiaria)/365,0);
												$totalintereses+=$intereses[1];						 
											}
											if($sidescuentos==1 && '03'==$r3[2])
											{
												$tdescuentos+=round($valoringreso[0]*$pdescuento,0);
											}
										}
									}
									$valorperiodo+=$valoringresos;		
									//$ipredial=ceil($predial*(pow(1+$tasaintdiaria,$diasd)-1));
									$ipredial=round(($predial*$tasaintdiaria*$diasd)/365,0);
									$totalpredial=round($valorperiodo+$totalintereses+$ipredial,0);
									$totalpagar=round($totalpredial- round($tdescuentos,0),0);
									$ch=esta_en_array($_POST[dselvigencias], $r[0]);
									if($ch==1)
									 //{
									 $chk="checked";
									 
										# code...
									 
									// }
									//*************	

									$_POST[dvigencias][]=$r[0];
									$_POST[dcodcatas][]=$r[1];
									
									$_POST[dvaloravaluo][]=$base;
									//echo $_POST[dvaloravaluo][1];
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
						$_POST[contador]=count($_POST[dcodcatas]);
						$xx=1;
						$varconta= count($_POST[dvigencias]);
						// echo "varc-".$varconta;
						$xy=0;
						$iter=saludo1a;
						$iter2=saludo2;
						//echo $varconta."</br>";
						while ($xx < $varconta)
						{
							$sumatotal=0;
							for ($xy=0; $xy < $varconta; $xy++) { 
								if($_POST[dcodcatas][$xy]==$_POST[dcodcatas][$xx])
								{
									$sumatotal=$sumatotal+$_POST[davaluos][$xy];
								}
							}
							$sumafinal=$sumatotal*1000;
							if ($sumafinal>=$_POST['deudasuperior'])
							{
								echo "
									 <tr class='$iter'>
										<td >".$_POST[dvigencias][$xx]."</td>
										<td >".$_POST[dcodcatas][$xx]."</td>
										<td >".$_POST[dpredial][$xx]."</td>
										<td >".$_POST[dipredial][$xx]."</td>
										<td >".$_POST[dimpuesto1][$xx]."</td>
										<td >".$_POST[dinteres1][$xx]."</td>
										<td >".$_POST[dimpuesto2][$xx]."</td>
										<td >".$_POST[dinteres2][$xx]."</td>
										<td >".$_POST[ddescuentos][$xx]."</td>
										<td >".$_POST[davaluos][$xx]."</td>
										<td >".$_POST[dias][$xx]."</td>
										<td ><input type='checkbox' name='dselvigencias[]' value='".$_POST[dselvigencias2][$xx]."' onClick='buscavigencias(this)' ".$_POST[varcheck][$xx]."></td>
										<td><input type='hidden' name='dselvigencias3[]' value='".$r[0][$xx]."'></td>
										</tr>";
									$aux=$iter;
									$iter=$iter2;
									$iter2=$aux;
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
			  	for ($v=0; $v <$disc ; $v++)
			  	{ 
			  			

			  			$sumatotal=0;
			  			$cont=$v;
			  			$igual=1;
			  			$totalint=$_POST[dipredial][$v]+$_POST[dinteres1][$v]+$_POST[dinteres2][$v];

			  			
			  			for ($xy=0; $xy < $disc; $xy++)
			  			{
			  				if($_POST[dcodcatas][$xy]==$_POST[dcodcatas][$v]){
			 					
			 					$sumatotal=$sumatotal+$_POST[davaluos][$xy];
			 					}	
			  			}

			  			$sumafinal=$sumatotal*1000;
			  			if ($sumafinal>=$_POST['deudasuperior'])
			  			{
			  			while($igual==1)
			  			{
			  				if($_POST[dcodcatas][$v]==$_POST[dcodcatas][$cont])
			  				{
			  					$sqlr="INSERT INTO tesocobroreporte (idconsulta,vigencia,codcatastral,predial,intereses1,sobretasabombe,intereses2,sobretasamb,intereses3,descuentos,totalinteres,valortotal,diasmora,tasavig, avaluo) VALUES ('$id','".$_POST[dvigencias][$v]."','".$_POST[dcodcatas][$v]."','".$_POST[dpredial][$v]."','".$_POST[dipredial][$v]."','".$_POST[dimpuesto1][$v]."','".$_POST[dinteres1][$v]."','".$_POST[dimpuesto2][$v]."','".$_POST[dinteres2][$v]."','".$_POST[ddescuentos][$v]."','$totalint','".$_POST[davaluos][$v]."','".$_POST[dias][$v]."','".$_POST[dtasavig][$v]."','".$_POST[dvaloravaluo][$v]."')";
			  						mysql_query($sqlr,$linkbd);
									$valconta++;
									
			  					

			  				}
			  				$igual=0;
			  			}
			  			}
			  			$totalint=0;
			  			
			  	}
				if ($valconta==0){echo "<script>despliegamodalm('visible','2','No se pudo ejecutar la petición');</script>";}
				else {echo "<script>despliegamodalm('visible','1','Se ha almacenado con Exito');</script>";}
			}
		    ?>
		<input type='hidden' name='contador' value="<?php echo $_POST[contador] ?>"/>
		
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