<?php //V 1000 12/12/16 ?> 
<?php
	require "comun.inc";
	require "funciones.inc";
	require "conversor.php";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	header("Content-Type: text/html;charset=iso-8859-1");
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
        <link href="css/tabs.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
		<script>
			function buscacta(e){if (document.form2.cuenta.value!=""){document.form2.bc.value='1';document.form2.submit();}}
			function validar(){document.form2.submit();}
			function buscater(e){if (document.form2.tercero.value!=""){document.form2.bt.value='1';document.form2.submit();}}
			function agregardetalle()
			{
				if(document.form2.numero.value!="" &&  document.form2.valor.value>0 &&  document.form2.banco.value!=""  )
				{ 
					document.form2.agregadet.value=1;
					//document.form2.chacuerdo.value=2;
					document.form2.submit();
				}
				else {alert("Falta informacion para poder Agregar");}
			}
			function eliminar(variable)
			{
				if (confirm("Esta Seguro de Eliminar"))
				{
					document.form2.elimina.value=variable;
					//eli=document.getElementById(elimina);
					vvend=document.getElementById('elimina');
					//eli.value=elimina;
					vvend.value=variable;
					document.form2.submit();
				}
			}
			function guardar()
			{
				if (document.form2.fecha.value!='')
					{if (confirm("Esta Seguro de Guardar")){document.form2.oculto.value=2;document.form2.submit();}}
				else{alert('Faltan datos para completar el registro');document.form2.fecha.focus();document.form2.fecha.select();}
			}
			function despliegamodal2(_valor)
						{
							document.getElementById("bgventanamodal2").style.visibility=_valor;
							if(_valor=="hidden"){document.getElementById('ventana2').src="";}
							else {document.getElementById('ventana2').src="catastral-ventana01.php";}
						}
			function pdf()
			{
				document.form2.action="pdfestadocuenta.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function buscar()
			{
				//alert("dsdd");
				document.form2.buscav.value='1';
				document.form2.submit();
			}
			function buscavigencias()
			{
				//document.form2.buscarvig.value='1';
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
  				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='teso-estadocuenta.php'" class="mgbt"/><img src="imagenes/guardad.png" title="Guardar" class="mgbt1"/><img src="imagenes/busca.png" title="Buscar" onClick="location.href='teso-buscapredial.php'" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/print.png" title="Buscar" onClick="pdf()" class="mgbt"/><img src="imagenes/iratras.png" title="Atr&aacute;s" onClick="location.href='teso-informespredios.php'" class="mgbt"></td>
			</tr>		  
		</table>
		<?php
			$vigencia=date(Y);
			$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
			$_POST[vigencia]=$vigusu; 	
			$dif= diferenciamesesfechas_f2($_POST[fecha],$_POST[fechaav]);
			if(0>diferenciamesesfechas_f2($_POST[fecha],$_POST[fechaav]))
			{
				?><script>alert("LA FECHA DE PROYECCION DE LIQUIDACION NO PUEDE SER MENOR A LA FECHA ACTUAL")</script><?php
				$_POST[fechaav]=$_POST[fecha];
			}	
	  		//*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
			if(!$_POST[oculto])
			{
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
				$fec=date("d/m/Y");
				$_POST[fecha]=$fec; 		 		  			 		
				$check1="checked";
				$sqlr="select *from tesotasainteres where vigencia=".$vigusu;
				$res=mysql_query($sqlr,$linkbd);
				$r=mysql_fetch_row($res);
				$tasam=array();
				$tasam[0]=$r[14];
				$tasam[1]=$r[15];
				$tasam[2]=$r[16];
				$tasam[3]=$r[17];
				$tasamoratoria[0]=0;
				ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechaav],$fecha);
				if($fecha[2]<=3){$tasamoratoria[0]=$tasam[0];}
				else
				{
					if($fecha[2]<=6){$tasamoratoria[0]=$tasam[1];}
					else
					{
						if($fecha[2]<=9){$tasamoratoria[0]=$tasam[2];}
						else{$tasamoratoria[0]=$tasam[3];}						
					}
				}
				$_POST[tasamora]=$tasamoratoria[0];   
				$_POST[tasa]=0;
				$_POST[predial]=0;
				$_POST[descuento]=0;
				$condes=0;
				//***** BUSCAR FECHAS DE INCENTIVOS
				ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechaav],$fecha);
				$fechaactual=$fecha[3]."-".$fecha[2]."-".$fecha[1];	
				$sqlr="select *from tesodescuentoincentivo where vigencia=".$vigusu." and ingreso='01' and estado='S'";
				$res=mysql_query($sqlr,$linkbd);
				while($r=mysql_fetch_row($res))
				{	
					if($r[7]<=$fechaactual && $fechaactual <= $r[8]){$_POST[descuento]=$r[2];$condes=1; }
					elseif($fechaactual>$r[9] && $fechaactual <= $r[10]){$_POST[descuento]=$r[3];$condes=1;}
					elseif($fechaactual>$r[11] && $fechaactual <= $r[12]){$_POST[descuento]=$r[4];$condes=1;} 
					elseif($fechaactual>$r[19] && $fechaactual <= $r[20]){$_POST[descuento]=$r[16];$condes=1;} 
					elseif($fechaactual>$r[21] && $fechaactual <= $r[22] && $r[17]>0){$_POST[descuento]=$r[17];$condes=1;} 
					elseif($fechaactual>$r[23] && $fechaactual <= $r[24] && $r[18]>0){$_POST[descuento]=$r[18];$condes=1;} 
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
				$sqlr="select *from cuentacaja where estado='S' and vigencia=".$vigusu;
				$res=mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($res)){$_POST[cuentacaja]=$row[1];}
				$sqlr="select max(numerotipo) from comprobante_cab where tipo_comp='8' ";
				$res=mysql_query($sqlr,$linkbd);
				$consec=0;
				while($r=mysql_fetch_row($res)){$consec=$r[0];}
				$consec+=1;
				$_POST[idcomp]=$consec;	
				$fec=date("d/m/Y");
				$_POST[fecha]=$fec; 		 		  			 
				$_POST[valor]=0;	
				$sqlr="select valor_inicial,valor_final, tipo from dominios where nombre_dominio='DESC_INTERESES' ";
				$res=mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($res)) 
				{
					$_POST[vigmaxdescint]=$row[0];
					$_POST[porcdescint]=$row[1];
					$_POST[aplicadescint]=$row[2];
				}
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
				$sqlr="select *from tesotasainteres where vigencia=".$vigusu;
				$res=mysql_query($sqlr,$linkbd);
				$r=mysql_fetch_row($res);
				$tasam=array();
				$tasam[0]=$r[14];									
				$tasam[1]=$r[15];
				$tasam[2]=$r[16];
				$tasam[3]=$r[17];
				$tasamoratoria[0]=0;
				ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechaav],$fecha);
				if($fecha[2]<=3){$tasamoratoria[0]=$tasam[0];}
				else
				{
					if($fecha[2]<=6){$tasamoratoria[0]=$tasam[1];}
					else
					{
						if($fecha[2]<=9){$tasamoratoria[0]=$tasam[2]; }
						else{$tasamoratoria[0]=$tasam[3];}						
					}
				}
				$_POST[tasamora]=$tasamoratoria[0]; 
				ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechaav],$fecha);
				$fechaactual=$fecha[3]."-".$fecha[2]."-".$fecha[1];	
				$sqlr="select *from tesodescuentoincentivo where vigencia=".$vigusu." and ingreso='01' and estado='S'";
				$res=mysql_query($sqlr,$linkbd);
				$condes=0;
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
				case 1:$check1='checked';break;
				case 2:$check2='checked';break;
				case 3:$check3='checked';
			}
		?>
 		<form name="form2" method="post" action="">
			<?php
				$estadofase="SIN PROCESO";
				$color="#BBDEFB";
				$sqlr="Select max(idpredial) from tesoliquidapredial";
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
				$_POST[numpredial]=$row[0]+1;
				if($_POST[buscav]=='1')
				{
					$_POST[dcuentas]=array();
					$_POST[dncuentas]=array();
					$_POST[dtcuentas]=array();		 
					$_POST[dvalores]=array();
					$sql="SELECT  1 FROM tesocobroreporte WHERE codcatastral='$_POST[codcat]' ";
					$res=mysql_query($sql,$linkbd);
					$total=mysql_num_rows($res);
					if($total>0){
						$estadofase="EN FASE PERSUASIVA";
						$color="#EF9A9A";
					}
					
					$sql="SELECT  1 FROM tesoreportecitacion WHERE codcatastral='$_POST[codcat]' ";
					$res=mysql_query($sql,$linkbd);
					$total=mysql_num_rows($res);
					if($total>0){
						$estadofase="EN FASE COACTIVA";
						$color="#EF9A9A";
					}
					
					$sql="SELECT  1 FROM tesoreportemandamiento WHERE codcatastral='$_POST[codcat]' ";
					$res=mysql_query($sql,$linkbd);
					$total=mysql_num_rows($res);
					if($total>0){
						$estadofase="EN FASE DE MANDAMIENTO";
						$color="#EF9A9A";
					}
					
					
					if ($_POST[ord]=='' && $_POST[tot]=='')
					{
						$sqlr="SELECT ord,tot FROM tesoprediosavaluos WHERE codigocatastral='$_POST[codcat]'";
						$rowot=mysql_fetch_row(mysql_query($sqlr,$linkbd));
						$_POST[ord]=$rowot[0];
						$_POST[tot]=$rowot[1];
						echo "<script>document.form2.ord.value=$rowot[0];document.form2.tot.value=$rowot[1];</script>";
					}

					$sqlr="select *from tesopredios where cedulacatastral='".$_POST[codcat]."' AND ORD='$_POST[ord]' AND TOT='$_POST[tot]'";
					$res=mysql_query($sqlr,$linkbd);
					while($row=mysql_fetch_row($res))
					{
						//$_POST[vigencia]=$row[0];
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
						if($_POST[tipop]=='urbano'){$_POST[estrato]=$row[15];$tipopp=$row[15];}
						else{$_POST[rangos]=$row[15];$tipopp=$row[15];}
						// $_POST[dcuentas][]=$_POST[estrato];		
						$_POST[dtcuentas][]=$row[1];		 
						$_POST[dvalores][]=$row[5];
						$_POST[buscav]="";
						$sqlr2="select IF(tasa='-1',0,tasa) from tesoprediosavaluos where vigencia='$vigusu' AND codigocatastral='$row[0]' ";
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
	   				<label for="tab-1">Estado de Cuenta</label>
	   				<div class="content">
 						<table class="inicio" align="center" >
                            <tr>
                                <td class="titulos" colspan="9" style='width:93%'>Estado de Cuenta</td>
                                <td class="cerrar" style='width:7%'><a href="teso-principal.php">Cerrar</a></td>
                            </tr>
                            <tr>
                                <td class="saludo1" style="width: 10%" >No Liquidacion:</td>
                                <td style="width: 10%"><input name="numpredial" type="text" value="<?php echo $_POST[numpredial]?>" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  readonly></td>
								
								<td class="saludo1" style="width: 10%">Vigencia:</td>
                                <td style="width: 10%"><input name="vigencia" type="text" value="<?php echo $_POST[vigencia]?>" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" style="width: 100%" readonly></td>
								
                                <td class="saludo1" style="width: 10%">Fecha:</td>
                                <td style="width: 18%"><input name="fecha" type="text" value="<?php echo $_POST[fecha]?>"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" style="width: 89%" readonly> </td>
                                <td></td>
                                <td rowspan="3"><img src="imagenes/dinero.png" style="width:250px; height: 82px" /> </td>
                                
                            </tr>
	  						<tr>
								<td class="saludo1">Proy Liquidacion:</td>
                                <td><input name="fechaav" type="text" value="<?php echo $_POST[fechaav]?>" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" style="width:80%"  readonly>   <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/calendario04.png" style="width:20px" align="absmiddle" border="0"></a>  </td> 
								
								<td class="saludo1" style="width: 10%">Tasa Interes Mora:</td><td><input name="tasamora" type="text" value="<?php echo $_POST[tasamora]?>"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" style="width: 87%" readonly>%</td>
                       
								
                                <td  class="saludo1">Codigo Catastral:</td> 
          						<td>
		  							<input id="codcat" type="text" name="codcat" size="20" onKeyUp="return tabular(event,this)" onBlur="buscar(event)" value="<?php echo $_POST[codcat]?>" >
									<input id="ord" type="text" name="ord"   value="<?php echo $_POST[ord]?>" style="width: 15%" readonly>
		  							<input id="tot" type="text" name="tot"   value="<?php echo $_POST[tot]?>" style="width: 15%" readonly><input type="hidden" value="0" name="bt">&nbsp;<a title="Listado de Predios" onClick="despliegamodal2('visible');" style="cursor:pointer;"><img src="imagenes/find02.png" style="width:20px;"/></a>
                             	</td>
		  						<input type="hidden" name="chacuerdo" value="1">
                                <input type="hidden" value="1" name="oculto">
                                <td>
								<input type="hidden" value="<?php echo  $_POST[basepredial] ?>" name="basepredial">
								<input type="hidden" value="<?php echo  $_POST[basepredialamb] ?>" name="basepredialamb">
								<input type="hidden" value="<?php echo  $_POST[aplicapredial] ?>" name="aplicapredial"> 
								<input type="hidden" name="cobroalumbrado" value="<?php echo  $_POST[cobroalumbrado] ?>"/>
                                <input type="hidden" name="vcobroalumbrado" value="<?php echo  $_POST[vcobroalumbrado] ?>"/>
                                <input type="hidden" name="tcobroalumbrado" value="<?php echo  $_POST[tcobroalumbrado] ?>"/>
                                <input type="hidden" name="descuentoConDeuda" value="<?php echo  $_POST[descuentoConDeuda] ?>"/>
								<input type="hidden" value="<?php echo $_POST[buscav]?>" name="buscav">
								<input type="button" name="buscarb" id="buscarb" value="   Buscar   " onClick="buscar()" ></td>
        					</tr>
        					<tr>
                            	<td class="saludo1">Avaluo Vigente:</td>
                                <td><input name="avaluo2" value="<?php echo $_POST[avaluo2]?>" type="text" size="20" readonly><input type="hidden" name="vavaluo"  value="<?php echo $_POST[vavaluo]?>" > </td>
								
								<td class="saludo1" style="width: 10%">Descuento:</td>
								<td><input name="descuento" type="text" value="<?php echo $_POST[descuento]?>"   onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" style="width: 87%" readonly>%</td >
								
                                <td class="saludo1">Tasa Predial	:</td>
                                <td colspan="2"><input name="tasa" value="<?php echo $_POST[tasa]?>" type="text" size="4" readonly>xmil <span style="margin-left: 4% !important; background-color: <?php echo $color; ?> !important; border-radius: 5px !important;color:#455A64; padding: 4px;box-shadow: 1px 4px 12px 0px rgba(0,0,0,0.75);font-weight: bold"><?php echo $estadofase; ?></span> </td>
                                <td ></td>
                            
                     		</tr>
	  					</table>
					</div> 
				</div>
     			<div class="tab">
       				<input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?>>
       				<label for="tab-2">Informacion Predio</label>
       				<div class="content"> 
		  				<table class="inicio">
	  					<tr><td class="titulos" colspan="8">Informaci&oacute;n Predio</td></tr>
	  					<tr>
	  						<td width="119" class="saludo1">C&oacute;digo Catastral:</td>
	  						<td width="202" ><input type="hidden" value="<?php echo $_POST[nbanco]?>" name="nbanco"> <input name="catastral" type="text" id="catastral" onBlur="buscater(event)"  onKeyUp="return tabular(event,this)" value="<?php echo $_POST[catastral]?>" size="20" readonly></td>
		 					<td width="82" class="saludo1">Avaluo:</td>
	 						<td colspan="5"><input name="avaluo" type="text" id="avaluo" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[avaluo]?>" size="20" readonly></td>
      					</tr>
      					<tr> 
                        	<td width="82" class="saludo1">Documento:</td>
	  						<td><input name="tercero" type="text" id="tercero" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[tercero]?>" size="20" readonly></td>
	  						<td width="119" class="saludo1">Propietario:</td>
	  						<td width="202" colspan="5" ><input type="hidden" value="<?php echo $_POST[nbanco]?>" name="nbanco"> <input name="ntercero" type="text" id="propietario" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[ntercero]?>" size="76" readonly></td>
						</tr>
      					<tr>
	  						<td width="119" class="saludo1">Direcci&oacute;n:</td>
	 						<td width="202" ><input type="hidden" value="<?php echo $_POST[nbanco]?>" name="nbanco"> <input name="direccion" type="text" id="direccion" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[direccion]?>" size="40" readonly></td>			   
		 					<td width="82" class="saludo1">Ha:</td>
	  						<td width="124"><input name="ha" type="text" id="ha" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[ha]?>" size="6" readonly></td>
	  						<td width="72" class="saludo1">Mt2:</td>
	  						<td width="144"><input name="mt2" type="text" id="mt2" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[mt2]?>" size="6" readonly></td>
	  						<td width="76" class="saludo1">Area Cons:</td>
	  						<td width="206">
	  							<input name="areac" type="text" id="areac" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[areac]?>" size="6" readonly>
	  							<input type="hidden" name="vigmaxdescint" value="<?php echo  $_POST[vigmaxdescint] ?>"/>
      							<input type="hidden" name="porcdescint" value="<?php echo  $_POST[porcdescint] ?>"/>
      							<input type="hidden" name="aplicadescint" value="<?php echo  $_POST[aplicadescint] ?>"/>
	  						</td>
      					</tr>
	  					<tr>
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
                                    echo " 
                                        <td class='saludo1'>Estratos:</td>
                                        <td>
                                            <select name='estrato'  disabled>
                                                <option value=''>Seleccione ...</option>";
                                    $sqlr="select *from estratos where estado='S'";
                                    $res=mysql_query($sqlr,$linkbd);
                                    while ($row =mysql_fetch_row($res)) 
                                    {
                                        if($row[0]==$_POST[estrato])
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
                                    $sqlr="select *from rangoavaluos where estado='S'";
                                    $res=mysql_query($sqlr,$linkbd);
                                    while ($row =mysql_fetch_row($res)) 
                                    {
                                        if($row[0]==$_POST[rangos])
                                        {
                                            echo "<option value='$row[0]' SELECTED>Entre $row[1] - $row[2] SMMLV</option>";
                                            $_POST[nrango]=$row[1]." - ".$row[2]." SMMLV";
                                        }
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
		<div class="subpantallac">
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
					<?php 
					if($_POST[tcobroalumbrado]=='S' && $_POST[tipop]=='rural')
					{
						echo "<td class='titulos2'>Alumbrado Publico</td>";
					}
					?>
                    <td  class="titulos2">Descuentos</td>
                    <td  class="titulos2">Valor Total</td>
                    <td  class="titulos2">Dias Mora</td>
                        <input type='hidden' name='buscarvig' id='buscarvig'>
                </tr>
                <?php		
                    ini_set('max_execution_time', 7200);	
                    ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechaav],$fecha);
                    $fechaactual=$fecha[3]."-".$fecha[2]."-".$fecha[1];					
                    $tasaintdiaria=($_POST[tasamora]/100);
					$cuentavigencias=0;
					$valorAlumbrado=0;
					$alumbrado = 0;
                    $co="zebra1";
                    $co2="zebra2";
                    $sqlrxx="
                    SELECT DISTINCT TB1.vigencia,TB1.codigocatastral,TB1.avaluo,TB1.pago,TB1.estado,TB1.tipopredio,TB1.estratos,TB1.areacon
                    FROM tesoprediosavaluos TB1
                    WHERE TB1.codigocatastral = '$_POST[codcat]'
                    AND TB1.estado = 'S'
                    AND TB1.pago = 'N'
                    ORDER BY TB1.vigencia ASC";	
                    $resxx=mysql_query($sqlrxx,$linkbd);
                    $cuentavigencias= mysql_num_rows($resxx);
                    $sqlr="
                    SELECT DISTINCT TB1.vigencia,TB1.codigocatastral,TB1.avaluo,TB1.pago,TB1.estado,TB1.tipopredio,TB1.estratos,TB1.areacon
                    FROM tesoprediosavaluos TB1
                    WHERE TB1.codigocatastral = '$_POST[codcat]'
                    AND TB1.estado = 'S'
                    AND TB1.pago = 'N'
                    ORDER BY TB1.vigencia ASC ";	
                    $res=mysql_query($sqlr,$linkbd);
                    $cv=0;		
                    $sq="select interespredial from tesoparametros ";
                    $result=mysql_query($sq,$linkbd);
                    $rw=mysql_fetch_row($result);
                    $interespredial=$rw[0];
					$sq="SELECT idacuerdo FROM tesoacuerdopredial WHERE codcatastral='$_POST[codcat]'";
					$rs=mysql_query($sq,$linkbd);
					$idacuerdopre=mysql_fetch_row($rs);
					if($idacuerdopre[0]!='')
					{
						//$cuentavigencias=1;
					}
                    while($r=mysql_fetch_row($res))
                    {
						$totalintereses=0;
						$sql="SELECT * FROM tesoacuerdopredial_det WHERE idacuerdo='$idacuerdopre[0]' and vigencia='$r[0]'";
						$rst=mysql_query($sql,$linkbd);
						if(!mysql_fetch_row($rst))
						{
                        $otros=0;
                       $sqlr2="select IF(tasa='-1',0,tasa) from tesoprediosavaluos where vigencia='$r[0]' and codigocatastral='$r[1]' " ;
							//echo $sqlr2;
			 			$res2=mysql_query($sqlr2,$linkbd);
	 					$row2=mysql_fetch_row($res2);
                        $base=$r[2];
       					$valorperiodo=$base*($row2[0]/1000)-$base*($row2[0]/1000)*($_POST[deduccion]/100);
						$tasav=$row2[0];
						$predial=round($base*($row2[0]/1000)-$base*($row2[0]/1000)*($_POST[deduccion]/100),2);
                        $valoringresos=0;
                        $sidescuentos=0;
                        //**validacion normatividad predial *****
                        if($_POST[aplicapredial]=='S')
                        {
                            $estant="N";
                            $sqlrp="select * from tesoprediosavaluos where tesoprediosavaluos.codigocatastral='$_POST[codcat]' and vigencia=".($r[0]-1)."";	
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
                            if ($baseant<=0){}
                            else
                            {
                                if(($predialant>($npredialant*2)) && ($npredialant>0)){$predialant=$npredialant;}
                                if($predial>($predialant*2) && $r[7]==$areaanterior){$predial=$predialant*2;}			 
                            }
                            $npredialant=$predial;
                        }
                        //****buscar en el concepto del ingreso *******
                        $intereses=array();
                        $valoringreso=array();
						$sidescuentos=0;
						$tdescuentos=0;
                        $in=0;
                        if($cuentavigencias>1)
			 				{
								$diasd=0;
								if(($_POST[descuento]>0 or $condes==1) && $vigusu==$r[0])
				 				{
									$pdescuento=$_POST[descuento]/100; 
									
									if($_POST[descuentoConDeuda]=='S')
									{
										$tdescuentos=round(($predial)*$pdescuento,0);
									}						
									//$tdescuentos+=round(($predial)*$pdescuento,0);
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
									//$tdescuentos+=round(($predial)*$pdescuento,0);
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
							$baseParaBomberilAmbiental = 0;
							$baseParaBomberilAmbiental = $predial-$tdescuentos;
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
					  						$valoringreso[0]=round($baseParaBomberilAmbiental*($r3[5]/100),0);
					  						$valoringresos+=round($baseParaBomberilAmbiental*($r3[5]/100),0);
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
					  						$valoringreso[1]=round($baseParaBomberilAmbiental*($r3[5]/100),0);
					  						$valoringresos+=round($baseParaBomberilAmbiental*($r3[5]/100),0);
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
									$numdias = cal_days_in_month(CAL_GREGORIAN, $i, $vigcal);
									$totdiastri += $numdias;
									if($i==$fechainiciocobro && $vigcal==$fechafd[3])
										$numdias=$diascobro1;
									if($vigcal<'2017')
									{
										if($i % 3 == 0){
											$ipredial+=round(($predial*$totdiastri*($rowinteres[$i-$x1]/100))/365,0);
											//echo "$predial  ---> $totdiastri <br>";
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
                        $descipred=0;
                        $tdescuentos1=0;
                        if($r[0]<=$_POST[vigmaxdescint] && $_POST[aplicadescint]=='S')
                        {$descipred=$ipredial*($_POST[porcdescint]/100)+$intereses[0]*($_POST[porcdescint]/100);}
					    //echo "$ipredial*($_POST[porcdescint]/100)+$intereses[0]*($_POST[porcdescint]/100)+$intereses[1]*($_POST[porcdescint]/100) <br>";
                        $totalpredial=round(($predial+$otros+$totalintereses+$ipredial-$descipred),0);
						//echo "round($predial+$otros+$totalintereses-$descipred+$ipredial,0);";
                        $totalpagar=round($totalpredial- $tdescuentos,0);
						//echo "round($totalpredial- $tdescuentos,0)";
                        $ch=esta_en_array($_POST[dselvigencias], $r[0]);
                        if($ch==1){$chk="checked";}
                        //*************	
                        $tdescuentos1=$tdescuentos+$descipred;
                        if($r[3]=="N")
                        {
                            echo "
                            <input type='hidden' name='dvigencias[]' value='$r[0]'/>
                            <input type='hidden' name='dcodcatas[]' value='$r[1]'/>
                            <input type='hidden' name='dvaloravaluo[]' value='$base'/>
                            <input type='hidden' name='dtasavig[]' value='$tasav'/>
                            <input type='hidden' name='dpredial[]' value='$predial'/>
                            <input type='hidden' name='dipredial[]' value='$ipredial'/>
                            <input type='hidden' name='dimpuesto1[]' value='".($valoringreso[0]+0)."'/>
                            <input type='hidden' name='dinteres1[]' value='".($intereses[0]+0)."'/>
                            <input type='hidden' name='dimpuesto2[]' value='".($valoringreso[1]+0)."'/>
                            <input type='hidden' name='dinteres2[]' value='".($intereses[1]+0)."'/>";
							if($alumbrado>0)
							{
								echo "<input type='hidden' name='dvalorAlumbrado[]' value='$valorAlumbrado'/>";
							}
							echo "
                            <input type='hidden' name='ddescuentos[]' value='$tdescuentos1'/>
                            <input type='hidden' name='davaluos[]' value='".number_format($totalpagar,2)."'/>
                            <input type='hidden' name='dhavaluos[]' value='$totalpagar'/>
                            <input type='hidden' name='dias[]' value='$diasd'/>
                            <input type='hidden' name='dselvigencias[]' value='$r[0]' onClick='buscavigencias(this)' >
                            <tr class='$co'>
                                <td>$r[0]</td>
                                <td>$r[1]</td>
                                <td style='text-align:right;'>$ ".number_format($predial,2)."</td>
                                <td style='text-align:right;'>$ ".number_format($ipredial,2)."</td>
                                <td style='text-align:right;'>$ ".number_format($valoringreso[0]+0,2)."</td>
                                <td style='text-align:right;'>$ ".number_format($intereses[0]+0,2)."</td>
                                <td style='text-align:right;'>$ ".number_format($valoringreso[1]+0,2)."</td>
                                <td style='text-align:right;'>$ ".number_format($intereses[1]+0,2)."</td>";
								if($alumbrado>0)
								{
									echo "<td style='text-align:right;'>$ ".number_format($valorAlumbrado,2)."</td>";
								}
								echo "
                                <td style='text-align:right;'>$ ".number_format($tdescuentos1,2)."</td>
                                <td style='text-align:right;'>$ ".number_format($totalpagar,2)."</td>
                                <td style='text-align:right;'> ".number_format($diasd,0)."</td>
                            </tr>";
                            $aux=$co;
                            $co=$co2;
                            $co2=$aux;
                            $_POST[totalc]=$_POST[totalc]+$_POST[davaluos][$x];
                            $_POST[totalcf]=number_format($_POST[totalc],2,".",",");
                        }
                    }
					}
                    $resultado = convertir($_POST[totliquida]);
                    $_POST[letras]=$resultado." PESOS M/CTE";	
                    ini_set('max_execution_time', 180);
                ?> 
            </table>
		</div>
      	<table class="inicio">
      		<tr>
            	<td class="saludo1">Total Liquidacion:</td>
                <td><input type="text" name="totliquida2" value="<?php echo number_format($_POST[totliquida2],2)?>" size="12"  readonly><input type="hidden" name="totliquida" value="<?php echo $_POST[totliquida]?>" size="12" readonly></td><td class="saludo1">Total Predial:</td><td><input type="hidden" name="intpredial" value="<?php echo $_POST[intpredial]?>"><input type="text" name="totpredial" value="<?php echo $_POST[totpredial]?>" size="9" readonly></td><td class="saludo1">Total Sobret Bomberil:</td><td><input type="hidden" name="intbomb" value="<?php echo $_POST[intbomb]?>"><input type="text" name="totbomb" value="<?php echo $_POST[totbomb]?>" size="9" readonly></td><td class="saludo1">Total Sobret Ambiental:</td><td><input type="hidden" name="intamb" value="<?php echo $_POST[intamb]?>"><input type="text" name="totamb" value="<?php echo $_POST[totamb]?>" size="9" readonly></td><td class="saludo1">Total Intereses:</td><td><input type="text" name="totint" value="<?php echo $_POST[totint]?>" size="9" readonly></td><td class="saludo1">Total Descuentos:</td><td><input type="text" name="totdesc"  value="<?php echo $_POST[totdesc]?>" size="9" readonly></td></tr>
      <tr><td class="saludo1" >Son:</td><td colspan="8"><input type="text" name="letras"  value="<?php echo $_POST[letras]?>" size="155"></td></tr>
      </table>
		<script>buscavigencias()</script>
		<div id="bgventanamodal2">
                <div id="ventanamodal2">
                    <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                    </IFRAME>
                </div>
       	 	</div>
</form>
 </td></tr>
</table>
</body>
</html>