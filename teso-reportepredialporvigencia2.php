<?php //V 1001 22/12/16 ?>
<?php
	require "comun.inc";
	require "funciones.inc";
	require "conversor.php";
	sesion();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html" />
		<meta http-equiv="X-UA-Compatible" content="IE=9" />
			<title>:: SPID - Tesoreria</title>
            <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        	<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
            <link href="css/tabs.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
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
				function agregardetalle()
				{
					if(document.form2.numero.value!="" &&  document.form2.valor.value>0 &&  document.form2.banco.value!="")
					{ 
						document.form2.agregadet.value=1;
						document.form2.submit();
					}
 					else {alert("Falta informacion para poder Agregar");}
				}
				function eliminar(variable)
				{
					if (confirm("Esta Seguro de Eliminar"))
  					{
						document.form2.elimina.value=variable;
						vvend=document.getElementById('elimina');
						vvend.value=variable;
						document.form2.submit();
					}
				}
				function guardar()
				{
					if (document.form2.fecha.value!='')
  					{
						if (confirm("Esta Seguro de Guardar"))
  						{
  							document.form2.oculto.value=2;
  							document.form2.submit();
  						}
  					}
  					else
					{
  						alert('Faltan datos para completar el registro');
  						document.form2.fecha.focus();
  						document.form2.fecha.select();
  					}
				}
				function pdf()
				{
					document.form2.action="pdfcobropredial.php";
					document.form2.target="_BLANK";
					document.form2.submit(); 
					document.form2.action="";
					document.form2.target="";
				}
				function buscar()
 				{
					document.form2.target="_BLANK";
					var buscavId = document.form2.buscav.value;
					document.form2.buscav.value='1';
 					document.form2.submit();
 					document.form2.buscav.value = buscavId;
 				}
 				function buscar1()
 				{
 					document.form2.oculto.value='3';
 					document.form2.submit();
 				}
				function buscavigencias(objeto)
 				{
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
				function buscater(e)
 				{
					if (document.form2.tercero.value!="")
					{	
 						document.form2.bt.value='1';
 						document.form2.submit();
 					}
 				}
				function callprogress(vValor)
				{
					document.getElementById("getprogress").innerHTML = vValor;
					document.getElementById("getProgressBarFill").innerHTML = '<div class="ProgressBarFill" style="width: '+vValor+'%;"></div>';				
					document.getElementById("titulog1").style.display='block';
					document.getElementById("progreso").style.display='block';
					document.getElementById("getProgressBarFill").style.display='block';
					
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
  					<td colspan="3" class="cinta"><a href="#" class="mgbt"><img src="imagenes/add2.png" alt="Nuevo"  border="0"  title="Nuevo"/></a><a href="#" class="mgbt"><img src="imagenes/guardad.png"  alt="Guardar" title="Guardar" /></a><a href="#"  class="mgbt"><img src="imagenes/buscad.png"  alt="Buscar" title="Buscar"/></a><a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana"  title="Nueva ventana"></a><a href="#"  class="mgbt" onClick="pdff();"><img src="imagenes/printd.png"  title="Imprimir" /></a><a href="<?php echo "archivos/".$_SESSION[usuario]."reportepredial.csv"; ?>" target="_blank" class="mgbt"><img src="imagenes/csv.png"  alt="csv" title="csv"></a><a href="teso-informespredios.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a></td></td>
				</tr>		  
			</table>
            <form name="form2" method="post" action="">
            <?php
			//***************************************************************************************1
			$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
				$vigencia=$vigusu;

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
					$tasam[0]=$r[6];									
					$tasam[1]=$r[7];
					$tasam[2]=$r[8];
					$tasam[3]=$r[9];
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
				//else
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
					$sqlr="select * from tesotasainteres where vigencia='$vigusu'";
					$res=mysql_query($sqlr,$linkbd);
					$r=mysql_fetch_row($res);
					$tasam=array();
					$tasam[0]=$r[6];									
					$tasam[1]=$r[7];
					$tasam[2]=$r[8];
					$tasam[3]=$r[9];
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
								//***************************************************************************************2
			?>
            <input type="hidden" name="basepredial" value="<?php echo  $_POST[basepredial] ?>"/>
                                <input type="hidden" name="basepredialamb" value="<?php echo  $_POST[basepredialamb] ?>"/>
                                <input type="hidden" name="aplicapredial" value="<?php echo  $_POST[aplicapredial] ?>"/>
                                <input type="hidden" name="vigmaxdescint" value="<?php echo  $_POST[vigmaxdescint] ?>"/>
                                <input type="hidden" name="porcdescint" value="<?php echo  $_POST[porcdescint] ?>"/>
                                <input type="hidden" name="aplicadescint" value="<?php echo  $_POST[aplicadescint] ?>"/>
      			<table class="inicio" align="center" >
      				<tr>
        				<td class="titulos" colspan="11">Reporte de Estado Predial</td>
                        <td class="cerrar" style="width:7%" onClick="location.href='teso-principal.php'">Cerrar</td>
      				</tr>
     				<tr>
						<td style="width:10%;" class="saludo1">Fecha:</td>
						<td  style="width:5%;"><input name="fechaav" type="text" value="<?php echo $_POST[fechaav]?>"  id="fc_1198971545" title="DD/MM/YYYY" style="width:80%;" readonly />&nbsp;<img src="imagenes/calendario04.png" class="icobut" onClick="displayCalendarFor('fc_1198971545');" title="Calendario"/></td>
						<td class="saludo1"  style="width:8%;">Vigencia:</td>
						<td  style="width:7%;"><input name="vigencia" type="text" value="<?php echo $_POST[vigencia]?>" maxlength="2"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  style="width:100%;" readonly></td>
						<td class="saludo1"  style="width:10%;">Tasa Interes Mora:</td>
						<td  style="width:10%;"><input name="tasamora" type="text" value="<?php echo $_POST[tasamora]?>"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  style="width:80%;" readonly>%</td>
						<td class="saludo1"  style="width:10%;">Descuento:</td>
						<td  style="width:7%;"><input name="descuento" type="text" value="<?php echo $_POST[descuento]?>"   onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  style="width:70%;" readonly>%</td >
						<td class="saludo1" style="width:7%;">Tasa Predial	:</td>
						<td><input name="tasa" value="<?php echo $_POST[tasa]?>" type="text"  style="width:50%;" readonly>x mil</td>
					</tr>
	  				<tr> 
                    	<td class="saludo1">Documento: </td>
        				<td><input name="tercero" type="text" value="<?php echo $_POST[tercero]?>"  onKeyUp="return tabular(event,this)" style="width:80%;" onBlur="buscater(event)"><a href="#" onClick="mypop=window.open('terceros-ventana.php?ti=1','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a></td>
			  			<td class="saludo1">Contribuyente:</td>
	  					<td  colspan="3"><input type="text" id="ntercero" name="ntercero" value="<?php echo $_POST[ntercero]?>"  onKeyUp="return tabular(event,this) " style="width:100%" readonly><input type="hidden" value="0" id="bt" name="bt"></td>
						<td><input type="hidden" value="<?php echo $_POST[buscav]?>" name="buscav"></td>	 
       				</tr>
        			<tr>
		  				<td width="128" class="saludo1">C&oacute;digo Catastral:</td>
          				<td><input id="codcat" type="text" name="codcat"  onKeyUp="return tabular(event,this)" onBlur="buscar(event)" value="<?php echo $rowq[1]?>" style="width:80%;"> <a href="#" onClick="mypop=window.open('catastral-ventana4.php','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=900,height=500px');mypop.focus();" ><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a></td>
            			<input type="hidden" name="chacuerdo" value="1"><input type="hidden" value="1" name="oculto">
						<input type="hidden" name="basepredial" value="<?php echo  $_POST[basepredial] ?>"/>
						<input type="hidden" name="basepredialamb" value="<?php echo  $_POST[basepredialamb] ?>"/>
                        <input type="hidden" name="aplicapredial" value="<?php echo  $_POST[aplicapredial] ?>"/>
                        <input type="hidden" name="vigmaxdescint" value="<?php echo  $_POST[vigmaxdescint] ?>"/>
                        <input type="hidden" name="porcdescint" value="<?php echo  $_POST[porcdescint] ?>"/>
                        <input type="hidden" name="aplicadescint" value="<?php echo  $_POST[aplicadescint] ?>"/>
						<td class="saludo1" style="width:9%;">Avaluo Vigente:</td>
						<td><input name="avaluo2" value="<?php echo $_POST[avaluo2]?>" type="text" readonly></td>
						<input type="hidden" name="vavaluo"  value="<?php echo $_POST[vavaluo]?>" >
						<td class="saludo1">Estado Vigencias:</td>
						<td>
							<select name="tipov" onChange="document.form2.submit()">
                              <option value="" <?php if($_POST[tipov]=='') echo "SELECTED"?>>Todos</option>
                              <option value="S" <?php if($_POST[tipov]=='S') echo "SELECTED"?>>Pagos</option>
                              <option value="N" <?php if($_POST[tipov]=='N') echo "SELECTED"?>>Deuda</option>
                              <option value="P" <?php if($_POST[tipov]=='P') echo "SELECTED"?>>Prescritos</option>
				  			</select>
						</td>
						<td>
                        	<input type="button" name="buscarb" id="buscarb" value="   Buscar   " onClick="buscar1()" ><input name="predial" value="<?php echo $_POST[predial]?>" type="hidden"  readonly/>
                            <div id='titulog1' style='display:none; float:left'></div>
                            <div id='progreso' class='ProgressBar' style='display:none; float:left'>
                                <div class='ProgressBarText'><span id='getprogress'></span>&nbsp;% </div>
                                <div id='getProgressBarFill'></div>
                            </div>
                        </td>
                 	</tr>
          			<?php
		  			if($_POST[tipov]=='N')
					{
			  			echo "
							<td class='saludo1'>Deuda superior a:</td>
							<td><input type='text' name='dsuperior' id='dsuperior' value='$_POST[dsuperior]'></td>";
		  			}
	   				if($_POST[bt]=='1')
			 		{
			  			$nresul=buscatercero($_POST[tercero]);
			  			if($nresul!=''){$_POST[ntercero]=$nresul;}
			 			else
			 			{
			  				$_POST[ntercero]="";
			  				echo"
			  					<script>
									alert('Tercero Incorrecto o no Existe')				   		  	
		  							document.form2.tercero.focus();	
			 				 	</script>";
			  			}
			 		}
	  			?>
	  		</table>         
	  		<div class="subpantallac" style='height: 55%;'>
      			<table class="inicio">
	   	   			<tr><td colspan="15" class="titulos">Periodos a Liquidar</td></tr>                  
					<tr>
		  				<td  class="titulos2">Vigencia</td>
                        <td  class="titulos2">Tercero</td>
                        <td  class="titulos2">C&oacute;digo Catastral</td>
                        <td  class="titulos2">Avaluo</td>          
                        <td class="titulos2">Predial</td>
                        <td class="titulos2">Intereses Predial</td>   
   		  				<td class="titulos2">Desc. Intereses</td> 
 		  				<td class="titulos2">Tot. Int Predial</td>          
                        <td  class="titulos2">Sobretasa Bombe</td>
                        <td  class="titulos2">Intereses</td>
                        <td class="titulos2">Sobretasa Amb</td>
                        <td  class="titulos2">Intereses</td>
                        <td  class="titulos2">Descuentos</td>
                        <td  class="titulos2">Valor Total</td>
          		  		<td  class="titulos2">D&iacute;as Mora</td>
             		</tr>
		    		<input type='hidden' name='buscarvig' id='buscarvig'>
            		<?php
						if($_POST[oculto]==3)
						{
							if($_POST[tipov]=='N')
							{
								$sqlrtem="TRUNCATE tempredial";
								mysql_query($sqlrtem,$linkbd);
								
								$sqlrq="SELECT * FROM tesoprediosavaluos WHERE pago='N' GROUP BY codigocatastral ORDER BY codigocatastral ASC;";
								$resq=mysql_query($sqlrq,$linkbd);
								$totalcli=mysql_affected_rows ($linkbd);
								while ($rowq=mysql_fetch_row($resq)) 
								{
									$c+=1;
									$porcentaje = $c * 100 / $totalcli; 
									echo"<script>progres='".round($porcentaje)."';callprogress(progres);</script>"; 
									flush();
									ob_flush();
									usleep(5);
									//************************************************************************************
									ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechaav],$fecha);
									$fechaactual=$fecha[3]."-".$fecha[2]."-".$fecha[1];					
									$tasaintdiaria=($_POST[tasamora]/100);
									$valoringreso[0]=0;
									$valoringreso[1]=0;
									$intereses[1]=0;
									$intereses[0]=0;
									$valoringresos=0;
									$cuentavigencias=0;
									$tdescuentos=0;
									$baseant=0;
									$npredialant=0;
									$banderapre=0;
									$co="zebra1";
									$co2="zebra2";
									$sqlrnop="select * from tesonopago where cedulacatastral='$rowq[1]'";
									$resnop=mysql_query($sqlrnop,$linkbd);
									if (mysql_num_rows($resnop)>0){$tesopago='N';} 
									else {$tesopago='S';}
									$sqlrxx="
									SELECT DISTINCT TB1.vigencia,TB1.codigocatastral,TB1.avaluo,TB1.pago,TB1.estado,TB1.tipopredio,TB1.estratos, TB1.areacon
									FROM tesoprediosavaluos TB1
									WHERE TB1.codigocatastral = '$rowq[1]'
									AND TB1.estado = 'S'
									AND TB1.pago = 'N'
									ORDER BY TB1.vigencia ASC ";
									$resxx=mysql_query($sqlrxx,$linkbd);
									$cuentavigencias= mysql_num_rows($resxx);
									$sqlr="
									SELECT DISTINCT TB1.vigencia,TB1.codigocatastral,TB1.avaluo,TB1.pago,TB1.estado,TB1.tipopredio,TB1.estratos, TB1.areacon
									FROM tesoprediosavaluos TB1
									WHERE TB1.codigocatastral = '$rowq[1]'
									AND TB1.estado = 'S'
									AND (TB1.pago = 'N' OR TB1.pago = 'P')
									ORDER BY TB1.vigencia ASC ";						
									$res=mysql_query($sqlr,$linkbd);
									$cv=0;
									$sq="select interespredial from tesoparametros ";
									$result=mysql_query($sq,$linkbd);
									$rw=mysql_fetch_row($result);
									$interespredial=$rw[0];
									while($r=mysql_fetch_row($res))
									{	
										$banderapre++;
										$otros=0; 
										$sqlr2="select *from tesotarifaspredial where vigencia='$r[0]' and tipo='$r[5]' and estratos='$r[6]'";
										$res2=mysql_query($sqlr2,$linkbd);
										$row2=mysql_fetch_row($res2);
										$base=$r[2];
										$valorperiodo=$base*($row2[5]/1000)-$base*($row2[5]/1000)*($_POST[deduccion]/100);
										$tasav=$row2[5];
										$predial=round($base*($row2[5]/1000)-$base*($row2[5]/1000)*($_POST[deduccion]/100),2);
										//**validacion normatividad predial *****
										if($_POST[aplicapredial]=='S')
										{
											$sqlrp="select distinct * from tesoprediosavaluos where tesoprediosavaluos.codigocatastral = '$_POST[catastral]' and vigencia=".($r[0]-1)." ";		
											$respr=mysql_query($sqlrp,$linkbd);
											$rowpr=mysql_fetch_row($respr);
											$baseant=0;		
											$estant=$rowpr[3];
											$baseant=$rowpr[2]+0;
											$predialant=$baseant*($row2[5]/1000);
											$areaanterior=$rowpr[9];
											if($estant=='S')
											{	
												$sqlrav="select distinct tesoliquidapredial_det.predial,tesoliquidapredial_det.avaluo from tesoliquidapredial_det,tesoliquidapredial where tesoliquidapredial_det.idpredial=tesoliquidapredial.idpredial and tesoliquidapredial.codigocatastral='$_POST[catastral]' and tesoliquidapredial.estado='P' AND tesoliquidapredial_det.vigliquidada='".($r[0]-1)."'";
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
												$predialant=$baseant*($row2[5]/1000);
											}
											if ($baseant<=0)
											{
												//echo "<br>bas ".$baseant;
											}
											else
											{
												if(($predialant>($npredialant*2)) && ($npredialant>0)){$predialant=$npredialant;}
												if($predial>($predialant*2) && $r[7]==$areaanterior){$predial=$predialant*2;}	 
											}
											$npredialant=$predial;
										}
										//*******
										$valoringresos=0;
										$sidescuentos=0;
										//****buscar en el concepto del ingreso *******
										$intereses=array();
										$valoringreso=array();
										$in=0;
										if($cuentavigencias>1)
										{
											if($vigusu==$r[0] && ($_POST[descuento]>0 or $condes==1) )
											{
												$diasd=0;
												$totalintereses=0; 
												$sidescuentos=0;
											}
											elseif ($interespredial=='inicioanio')//Si se cuentan los dias desde el principio del año 
											{
												$fechaini=mktime(0,0,0,1,1,$r[0]);
												$fechafin=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
												$difecha=$fechafin-$fechaini;
												$diasd=$difecha/(24*60*60);
												$diasd=floor($diasd);
												$totalintereses=0; 
											}
											else //Si se cuentan los dias desde el principio del año 
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
												$fechaini=mktime(0,0,0,$fechafd[2],$fechafd[1],$fechafd[3]);
												$fechafin=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
												$difecha=$fechafin-$fechaini;
												$diasd=$difecha/(24*60*60);
												$diasd=floor($diasd);
												if($diasd<0){$diasd=0;}
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
											elseif ($interespredial=='inicioanio')//Si se cuentan los dias desde el principio del año 
											{
												$fechaini=mktime(0,0,0,1,1,$r[0]);
												$fechafin=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
												$difecha=$fechafin-$fechaini;
												$diasd=$difecha/(24*60*60);
												$diasd=floor($diasd);
												$totalintereses=0; 
											}
											else //Si se cuentan los dias desde el principio del año 
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
												$fechaini=mktime(0,0,0,$fechafd[2],$fechafd[1],$fechafd[3]);
												$fechafin=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
												$difecha=$fechafin-$fechaini;
												$diasd=$difecha/(24*60*60);
												$diasd=floor($diasd);
												if($diasd<0){$diasd=0;}
												$totalintereses=0; 
											}
										}
							$sqlr2="select *from tesoingresos_det where codigo='01' and modulo='4' and  estado='S' and vigencia=$vigusu order by concepto";
							$res3=mysql_query($sqlr2,$linkbd);
							while($r3=mysql_fetch_row($res3))
							{
								if($r3[5]>0 && $r3[5]<100)
					 			{
					  				if($r3[2]=='03')
					    			{
										//echo $tasaintdiaria."-";
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
					 					$intereses[0]=round(($valoringreso[0]*$diasd*$tasaintdiaria)/365,0);
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
					  					$intereses[1]=round(($valoringreso[1]*$diasd*$tasaintdiaria)/365,0);
					  					$totalintereses+=$intereses[1];						 
					   				}	
					 			}
							}
							$otros+=$valoringresos;		
							$ipredial=round(($predial*$tasaintdiaria*$diasd)/365,0);
							$chk='';
							$ch=esta_en_array($_POST[dselvigencias], $r[0]);
							if($ch==1){$chk=" checked";}
							$descipred=0;
							if($r[0]<=$_POST[vigmaxdescint] && $_POST[aplicadescint]=='S')
							{
								$descipred=$ipredial*($_POST[porcdescint]/100)+$intereses[0]*($_POST[porcdescint]/100)+$intereses[1]*($_POST[porcdescint]/100);
							}
							$totalpredial=round($predial+$otros+$totalintereses-$descipred+$ipredial,0);
							$totalpagar=round($totalpredial- round($tdescuentos,0),0);
							$sqlrat="SELECT TB1.idpredial FROM tesoliquidapredial_det TB1, tesoliquidapredial TB2 WHERE TB1.idpredial=TB2.idpredial AND TB2.codigocatastral='$r[1]' AND TB1.vigliquidada='$r[0]' AND TB2.estado='S'";
							$resat=mysql_fetch_row(mysql_query($sqlrat,$linkbd));
							if($resat[0]!="")
							{
								$varcol='resaltar01';
								$clihis="onDblClick='hisliquidacion(\"$resat[0]\");'"; 
								$titvig="title='Periodo con Liquidación vigente N° $resat[0]'";
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
									$titvig="title='Periodo con Autorización de Liquidación vigente N° $resat2[0]'";
									$_POST[var2]=$resat2[0];
								}
								else{$varcol=$co;$clihis=""; $titvig="";}
							}
							if($r[3]=="N")
							{
								if ($tesopago=='N')
								{
									$predial=0;
									$ipredial=0;
									$descipred=0;
									$valoringreso[0]=0;
									$intereses[0]=0;
									$tdescuentos=0;
									$totalpagar=$valoringreso[1]+$intereses[1];
								}
								$var1=$ipredial-$descipred;
								$sqlrtem="INSERT INTO tempredial (vigencia,tercero,ccatastral,avaluo,predial,ipredial,dintereses,totintpredial, stbomberil,ibomberil,stambiental,iambiental,descuentos,valortotal,diasmora) VALUES ('$r[0]','NOMBRE','$r[1]','$r[2]','$predial','$ipredial', '$descipred','$var1','$valoringreso[0]','$intereses[0]','$valoringreso[1]','$intereses[1]','$tdescuentos','$totalpagar','$diasd')";
								mysql_query($sqlrtem,$linkbd);
								//echo "$sqlrtem</br>";
								/*
							
							*/
							}
		 				}
									//************************************************************************************
									
								}
							}
							//$sqlrtem1="SELECT T1.* FROM tempredial T1 WHERE '(SELECT SUM(T2.valortotal) FROM tempredial T2 where T2.ccatastral=T1.ccatastral)' >='$_POST[dsuperior]'"; 
								$sqlrtem1="SELECT * FROM tempredial ";
								$restem1=mysql_query($sqlrtem2,$linkbd);
								while($rowtem1=mysql_fetch_row($restem2))
								{
								$sqlrtem2="SELECT SUM(valortotal) FROM tempredial where ccatastral='$rowtem1[2]'";
								$restem2=mysql_query($sqlrtem2,$linkbd);
								$rowtem2=mysql_fetch_row($restem2);
								if ($rowtem2>=$_POST[dsuperior])
								{
								echo "
								<tr class='$varcol' $clihis $titvig>
									<td>$rowtem1[0]</td>
									<td>$rowtem1[1]</td>
									<td>$rowtem1[2]</td>
									<td style='text-align:right;'>$ ".number_format($rowtem1[3],2)."</td>
									<td style='text-align:right;'>$ ".number_format($rowtem1[4],2)."</td>
									<td style='text-align:right;'>$ ".number_format($rowtem1[5],2)."</td>
									<td style='text-align:right;'>$ ".number_format($rowtem1[6],2)."</td>
									<td style='text-align:right;'>$ ".number_format($rowtem1[7],2)."</td>
									<td style='text-align:right;'>$ ".number_format($rowtem1[8],2)."</td>
									<td style='text-align:right;'>$ ".number_format($rowtem1[9],2)."</td>
									<td style='text-align:right;'>$ ".number_format($rowtem1[10],2)."</td>
									<td style='text-align:right;'>$ ".number_format($rowtem1[11],2)."</td>
									<td style='text-align:right;'>$ ".number_format($rowtem1[12],2)."</td>
									<td style='text-align:right;'>$ ".number_format($rowtem1[13],2)."</td>
									<td style='text-align:right;'>".number_format($rowtem1[14],0)."</td>
								</tr>";
							
							}
							$aux=$co;
							$co=$co2;
							$co2=$aux;
								}
							//*******
						}
						
					?>
                   
        
      </table>
      </div>
      <table class="inicio">
      <tr><td class="saludo1">Total Liquidaci&oacute;n:</td>
	  <td><input type="text" name="totliquida2" value="<?php echo number_format($_POST[totliquida2],2)?>" size="12"  readonly>
	  <input type="hidden" name="totliquida" value="<?php echo $_POST[totliquida]?>" size="12" readonly></td>
	  <td class="saludo1">Total Predial:</td>
	  <td>
		<input type="hidden" name="intpredial" value="<?php echo $_POST[intpredial]?>">
		<input type="text" name="totpredial" value="<?php echo $_POST[totpredial]?>" size="9" readonly></td>
	<td class="saludo1">Total Sobret Bomberil:</td>
	<td>
		<input type="hidden" name="intbomb" value="<?php echo $_POST[intbomb]?>">
		<input type="text" name="totbomb" value="<?php echo $_POST[totbomb]?>" size="9" readonly></td>
	<td class="saludo1">Total Sobret Ambiental:</td>
	<td>
		<input type="hidden" name="intamb" value="<?php echo $_POST[intamb]?>">
		<input type="text" name="totamb" value="<?php echo $_POST[totamb]?>" size="9" readonly></td>
	<td class="saludo1">Total Intereses:</td>
	<td>
		<input type="text" name="totint" value="<?php echo $_POST[totint]?>" size="9" readonly></td>
		<td class="saludo1">Total Descuentos:</td>
		<td>
		<input type="text" name="totdesc"  value="<?php echo $_POST[totdesc]?>" size="9" readonly></td></tr>
      <tr><td class="saludo1" >Son:</td><td colspan="8"><input type="text" name="letras"  value="<?php echo $_POST[letras]?>" size="155"></td></tr>
      </table>
</form>
 </td></tr>
</table>
</body>
</html>