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
		<title>:: Spid - Almacen</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/tabs.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css"/>
		<script type="text/javascript" src="css/programas.js"></script>
		<script src="JQuery/jquery-2.1.4.min.js"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
		<script src="JQuery/autoNumeric-master/autoNumeric-min.js"></script>
		<script>
			function despliegamodal2(_valor,_pag,cod01,cod02)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else if(_pag=="1"){document.getElementById('ventana2').src="inve-greservas-articulos01.php";}
				else if(_pag=="2")
				{
					var nompag="tercerosalm-ventana01.php?objeto="+cod01+"&nobjeto="+cod02;
					document.getElementById('ventana2').src=nompag;
				}
			}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden")
				{
					document.getElementById('ventanam').src="";
					switch(document.getElementById('valfocus').value)
					{
						case "1":	document.getElementById('articulo').focus();
									document.getElementById('articulo').select();
									break;
						case "2":	document.getElementById('cuenta').focus();
									document.getElementById('cuenta').select();
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
					}
				}
			}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.getElementById('oculto').value="2";
								document.form2.submit();break;
					case "2":	document.getElementById('tipoelimina').value="1";
								document.form2.submit();break;
					case "3":	document.getElementById('tipoelimina').value="2";
								document.form2.submit();break;
				}
			}
			function funcionmensaje()
			{
				var codig=document.form2.codigo.value;
				document.location.href = "inve-donacionsalidaedita.php?codi="+codig;
			}
			function buscater(tipo)
 			{
				switch(tipo)
				{
					case '01':
						if (document.form2.tercero.value!=""){document.form2.bt.value='1';document.form2.submit();}
						break;
					case '02':
						if (document.form2.tercerop.value!=""){document.form2.bt.value='2';document.form2.submit();}
						break;
				}
 			}
			function guardar()
			{
				if(document.form2.estadogn.value=="A")
				{
					valg01=document.form2.codigo.value;
					valg02=document.form2.fecha.value;
					valg03=document.form2.ntercero.value;
					valg04=document.form2.valort.value;
					valg05=document.form2.ciudad.value;
					valg06=document.form2.lugarfi.value;
					valg07=document.form2.motivo.value;
					if (valg01!='' && valg02!='' && valg03!='' && valg04!='' && valg05!='' && valg06!='' && valg07!='')
					{despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
					else{despliegamodalm('visible','2','Faltan datos para completar el registro');}
				}
				else {despliegamodalm('visible','2','Este Acto Administrativo ya tiene un proceso o fue anulada; así que no se puede editar');}
			}
			function agregardetalle(tipo)
			{
				switch(tipo)
				{
					case '01':	
						val01=document.getElementById('tercerop').value;
						val02=document.getElementById('ntercerop').value;
						val03=document.getElementById('cargop').value;
						if(val01!="" && val02!="" && val03!=""){document.form2.agregadet.value='01';document.form2.submit();}
						else {despliegamodalm('visible','2','Falta información para poder Agregar Participante');}
						break;
						case '02':	
						val01=document.getElementById('narticulo').value;
						val02=document.getElementById('unimedida').value;
						val03=document.getElementById('nbodega').value;
						val04=document.getElementById('cantidadmax').value;
						val05=document.getElementById('cantidad').value;
						val06=document.getElementById('nbodega').value;
						val07=document.getElementById('cc').value;
						val08=document.getElementById('estado').value;
						if(val01!="" && val02!="" && val03!="" && val04!="" && val05!="" && val06!="" && val07!="" && val08!="")
						{document.form2.agregadet.value='02';document.form2.submit();}
						else {despliegamodalm('visible','2','Falta información para poder Agregar Articulo');}
						break;
				}
			}
			function eliminar(posi,tipo)
			{
				document.form2.elimina.value=posi;
				despliegamodalm('visible','4','Esta Seguro de Eliminar',tipo);
			}
			function validar(_opc){document.form2.submit();}
			function validasaldo()
			{
				var cant1=document.form2.cantidad.value;
				var cant2=document.form2.cantidadmax.value;
				if(cant1!='' && cant2!='')
				{
					if(parseFloat(cant1) > parseFloat(cant2))
					{
						despliegamodalm('visible','2','La cantidad donada es mayor a la cantidad en bodega');
						document.form2.cantidad.value='';
					}
				}
			
			}
			function pdf()
			{
				document.form2.action="inve-donacionsalidapdf.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			jQuery(function($){ $('#nreservav').autoNumeric('init',{mDec:'0'});});
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
    		<tr><script>barra_imagenes("inve");</script><?php cuadro_titulos();?></tr>	 
    		<tr><?php menu_desplegable("inve");?></tr>
    		<tr>
  				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='inve-donacionsalida.php'" class="mgbt"/><img src="imagenes/guarda.png" title="Guardar" onClick="guardar();" class="mgbt"/><img src="imagenes/busca.png" title="Buscar" onClick="location.href='inve-donacionsalidabuscar.php'" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" onClick="<?php echo paginasnuevas("inve");?>" class="mgbt"><img src="imagenes/print.png" title="Imprimir" onClick="pdf()" class="mgbt"/></td>
			</tr>
         </table>
         <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>		  
 		<form name="form2" method="post" action="inve-donacionsalidaedita.php">
        	<input type="hidden" name="valfocus" id="valfocus" value="0"/>
        	<?php
				if ($_POST[oculto]=="" && $_GET[codi]!="")
				{ 
					$sqlr="SELECT * FROM almactodonacionessal WHERE id='$_GET[codi]'";
					$resp = mysql_query($sqlr,$linkbd);
					$row =mysql_fetch_row($resp);
					$_POST[codigo]=$_GET[codi];
					$_POST[fecha]=date('d/m/Y',strtotime($row[1]));
					$_POST[donante]=$row[2];
					$_POST[ndonante]=$row[3];
					$_POST[tercero] =$row[4];
					$_POST[ntercero] =trim(iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$row[5]));
					$_POST[valort]=$row[6];
					$_POST[ciudad]=iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$row[7]);
					$_POST[lugarfi]=iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$row[8]);
					$_POST[motivo]=iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$row[9]);
					$_POST[otdetalles]=iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$row[10]);
					$_POST[estadogn]=$row[11];
					$sqlr="SELECT id,documento,nombre,cargo FROM almactodonacionessalpartici WHERE idacto='$_GET[codi]' AND estado='S'";
					$resp = mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($resp))
					{
						$_POST[agcodigo][]=$row[0];
						$_POST[agtercerop][]=$row[1];
						$_POST[agntercerop][]=$row[2];
						$_POST[agcargop][]=$row[3]; 
					}
					$sqlr="SELECT * FROM almactodonacionessalarticu WHERE idacto='$_GET[codi]' AND estado='S'";
					$resp = mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($resp))
					{
						$_POST[agcodigoart][]=$row[0];
						$_POST[agarticulo][]=$row[2];
						$_POST[agnarticulo][]=$row[3];
						$_POST[agunimedida][]=$row[4];
						$_POST[agcantidadmax][]=$row[5];
						$_POST[agcantidad][]=$row[6]; 
						$_POST[agbodega][]=$row[7];
						$_POST[agnbodega][]=$row[8];
						$_POST[agcc][]=$row[9];
						$_POST[agestado][]=$row[10];
					}
					$_POST[partielimina]="";
					$_POST[articelimina]="";
					$_POST[tabgroup1]=1;
				}
				if($_POST[bt]=='1')
			 	{
			  		$nresul=buscatercero($_POST[tercero]);
			 		if($nresul!=''){$_POST[ntercero]=$nresul;}
					else{ $_POST[ntercero]="";}
			 	}
				if($_POST[bt]=='2')
			 	{
			  		$nresul=buscatercero($_POST[tercerop]);
			 		if($nresul!=''){$_POST[ntercerop]=$nresul;}
					else{ $_POST[ntercerop]="";}
			 	}
				switch($_POST[tabgroup1])
				{
					case 1:	$check1='checked';break;
					case 2:	$check2='checked';break;
				}
			?>
			<table class="inicio" align="center" >
				<tr >
					<td class="titulos" colspan="7">.: Acto Administrativo de Acuerdo de Donaci&oacute;n </td>
					<td class="cerrar" style="width:7%" onClick="location.href='inve-principal.php'">Cerrar</td>
				</tr>
				<tr>
					<td class="saludo1" style="width:8%;" >.: Consecutivo:</td>
					<td style="width:10%;"><input type="text" id="codigo" name="codigo" style="width:100%; text-align:center" value="<?php echo $_POST[codigo] ?>" readonly/></td>
					<td class="saludo1" style="width:9%;">.: Fecha Registro:</td>
					<td style="width:13%"><input type="text" name="fecha" id="fc_1198971545" title="DD/MM/YYYY" value="<?php echo $_POST[fecha];?>" onKeyUp="return tabular(event,this)" onKeyDown="mascara(this,'/',patron,true)" maxlength="10" style="width: 80%">&nbsp;<img src="imagenes/calendario04.png" title="Calendario" onClick="displayCalendarFor('fc_1198971545');" class="icobut"/></td>
                    <td class="saludo1" style="width:10%;">.: Donatario:</td>
                    <td style="width:12%;"><input type="text" id="tercero" name="tercero"  style="width:80%; text-align:center" value="<?php echo $_POST[tercero] ?>" onKeyUp="return tabular(event,this)" onBlur="buscater('01')"/>&nbsp;<img src="imagenes/find02.png" onClick="despliegamodal2('visible','2','tercero','ntercero'); " class="icobut" title="Lista de Terceros"/></td>
					<td><input type="text" id="ntercero" name="ntercero" style="width:100%; text-align:center" value="<?php echo $_POST[ntercero] ?>" readonly></td>
				</tr>
				<tr>
                	<td class="saludo1" >.: Valor Total:</td>
					<td ><input type="text" id="valort" name="valort"  style="width:100%;" value="<?php echo $_POST[valort] ?>" /></td>
					<td class="saludo1" >.: Ciudad:</td>
					<td ><input type="text" id="ciudad" name="ciudad"  style="width:100%;" value="<?php echo $_POST[ciudad] ?>" /></td>
					<td class="saludo1" >.: Lugar f&iacute;sico:</td>
					<td colspan="2"><input type="text" id="lugarfi" name="lugarfi" style="width:100%;" value="<?php echo $_POST[lugarfi] ?>" /></td>
				</tr>
                <tr>
					<td class="saludo1" >.: Motivo:</td>
					<td colspan="6"><input type="text" id="motivo" name="motivo" style="width:100%;" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[motivo]?>"/></td>
				</tr>
				<tr>
					<td class="saludo1" >.: Otros Detalles:</td>
					<td colspan="6"><input type="text" id="otdetalles" name="otdetalles" style="width:100%;" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[otdetalles]?>"/></td>
				</tr>
			</table>
			<input type="hidden" id="donante" name="donante" value="<?php echo $_POST[donante];?>" />
			<input type="hidden" id="ndonante" name="ndonante" value="<?php echo $_POST[ndonante];?>"/>
			<div class="tabscontra" style="height:54%; width:99.6%"> 
				<div class="tab">
					<input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?>/>
					<label for="tab-1">Participantes</label>
					<div class="content" style="overflow:hidden">
						<table class='inicio' align='center' width='99%' >
							<tr>
								<td class="saludo1" style="width:10%;"  >.: Terceros:</td>
								<td style="width:12%;"><input type="text" id="tercerop" name="tercerop"  style="width:80%; text-align:center;" value="<?php echo $_POST[tercerop] ?>" onKeyUp="return tabular(event,this)" onBlur="buscater('02')"/>&nbsp;<img src="imagenes/find02.png" onClick="despliegamodal2('visible','2','tercerop','ntercerop'); " class="icobut" title="Lista de Terceros"/></td>
								<td style="width:40%;"><input type="text" id="ntercerop" name="ntercerop" style="width:100%; text-align:center;" value="<?php echo $_POST[ntercerop] ?>" readonly/></td>
								<td><em class="botonflecha" onClick="agregardetalle('01')">Agregar</em></td>
							</tr>
                            <tr>
                            	<td class="saludo1">.: Cargo</td>
                                <td colspan="2"><input type="text" id="cargop" name="cargop" style="width:100%;" value="<?php echo $_POST[cargop] ?>"/></td>
                            </tr>
						</table>
						<div class="subpantalla" style="height:79%; width:99.5%;overflow-x:hidden;">
							<table class='inicio' align='center' width='99%' >
								<tr><td class="titulos" colspan="5">Participantes Inscritos</td></tr>
								<tr>
									<td class="titulos2" style="width:5%;">N°</td>
									<td class="titulos2" style="width:10%;">Documento</td>
									<td class="titulos2" style="width:35%;">Nombre</td>
									<td class="titulos2" >Cargo</td>
									<td class="titulos2" style="width:5%;">Eliminar</td>
								</tr>
								<?php
									if ($_POST[tipoelimina]=='1')
									{ 
										$posi=$_POST[elimina];
										if($_POST[partielimina]==""){$_POST[partielimina]=$_POST[agcodigo][$posi];}
										else{$_POST[partielimina]="<->".$_POST[agcodigo][$posi];}
										unset($_POST[agcodigo][$posi]);
										unset($_POST[agtercerop][$posi]);
										unset($_POST[agntercerop][$posi]);
										unset($_POST[agcargop][$posi]);
										$_POST[agcodigo]=array_values($_POST[agcodigo]);
										$_POST[agtercerop]= array_values($_POST[agtercerop]); 
										$_POST[agntercerop]= array_values($_POST[agntercerop]); 
										$_POST[agcargop]= array_values($_POST[agcargop]); 
										$_POST[elimina]='';
										$_POST[tipoelimina]='';
									}
									if ($_POST[agregadet]=='01')
									{
										$_POST[agcodigo][]="N";
										$_POST[agtercerop][]=$_POST[tercerop];
										$_POST[agntercerop][]=$_POST[ntercerop];
										$_POST[agcargop][]=$_POST[cargop]; 
										$_POST[agregadet]=0;
										echo "
										<script>
											document.getElementById('tercerop').value='';
											document.getElementById('ntercerop').value='';
											document.getElementById('cargop').value='';
										</script>";
									}
									$iter='saludo1a';
									$iter2='saludo2';
									$conparti=count($_POST[agtercerop]);
									for ($x=0;$x<$conparti;$x++)
									{		 
										echo "
										<input type='hidden' name='agcodigo[]' value='".$_POST[agcodigo][$x]."'/>
										<input type='hidden' name='agtercerop[]' value='".$_POST[agtercerop][$x]."'/>
										<input type='hidden' name='agntercerop[]' value='".$_POST[agntercerop][$x]."'/>
										<input type='hidden' name='agcargop[]' value='".$_POST[agcargop][$x]."'/>
										<tr class='$iter'>
											<td>".($x+1)."</td>
											<td>".$_POST[agtercerop][$x]."</td>
											<td>".$_POST[agntercerop][$x]."</td>
											<td>".$_POST[agcargop][$x]."</td>
											<td style='text-align:center;' onclick=\"eliminar($x,'2')\"><img src='imagenes/del.png' class='icoop'></td>
										</tr>";
										$aux=$iter;
										$iter=$iter2;
										$iter2=$aux;
									}
								?>
							</table>
						</div>
					</div>	
				</div>
				<div class="tab">
					<input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?>/>
					<label for="tab-2">Articulos</label>
					<div class="content" style="overflow:hidden">
						<table class='inicio' align='center' width='99%'>
							<tr>
                            
								<td class="saludo1" style="width:8%;">.:Articulo:</td>
								<td ><input type="text" name="articulo" id="articulo" value="<?php echo $_POST[articulo]?>" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="guiabuscar('1');" style="width:80%"/>&nbsp;<img src="imagenes/find02.png" onClick="despliegamodal2('visible','1');" class="icobut" title="Lista de Articulos"/></td>
								<td colspan="5"><input type="text" id="narticulo" name="narticulo"  style="width:100%; text-align:center" value="<?php echo $_POST[narticulo] ?>" readonly></td>
								<td><em class="botonflecha" onClick="agregardetalle('02')">Agregar</em></td>
							</tr>
							<tr>
								<td class="saludo1" style="width:10%;">.: Unidad de Medida:</td>
								<td style="width:12%;"><input type="text" id="unimedida" name="unimedida" style="width:100%;" value="<?php echo $_POST[unimedida];?>" readonly/></td>
                                <td class="saludo1" style="width:12%;">.: Cantidad en Bodega:</td>
								<td style="width:10%;"><input type="text" id="cantidadmax" name="cantidadmax" style="width:100%;" value="<?php echo $_POST[cantidadmax];?>"readonly/></td>
								<td class="saludo1" style="width:12%;">.: Cantidad a Donar:</td>
								<td style="width:10%;"><input type="text" id="cantidad" name="cantidad" style="width:100%;" value="<?php echo $_POST[cantidad];?>" onKeyPress="javascript:return solonumeros(event)" onBlur="validasaldo()"/></td>
							</tr>
							<tr>
								<td class="saludo1">.: Bodega:</td>
								<td><input type="text" id="nbodega" name="nbodega" style="width:100%;" value="<?php echo $_POST[nbodega];?>"readonly/></td>
								<td class="saludo1">.: Centro de Costo:</td>
								<td><input type="text" id="cc" name="cc" style="width:100%;" value="<?php echo $_POST[cc];?>"readonly/></td>
								<td class="saludo1" style="width:7%;">.: Estado:</td>
								<td style="width:10%;">
									<select name="estado" id="estado" style="width:100%;">
										<option value="">Seleccione ....</option>
										<option value="N" <?php if($_POST[estado]=='N'){echo "SELECTED";}?>>NUEVO</option>
										<option value="U" <?php if($_POST[estado]=='U'){echo "SELECTED";}?>>USADO</option>
									</select>
								</td>
							</tr>
						</table>
                        <input type="hidden" id="bodega" name="bodega" value="<?php echo $_POST[bodega];?>"/>
						<div class="subpantalla" style="height:70.5%; width:99.5%;overflow-x:hidden;">
							<table class='inicio' align='center' width='99%' >
								<tr><td class="titulos" colspan="10">Articulos Contenidos en el Acta</td></tr>
								<tr>
									<td class="titulos2" style="width:5%;">N°</td>
									<td class="titulos2" style="width:10%;">Cod. Articulo</td>
                                    <td class="titulos2" >Nombre Articulo</td>
									<td class="titulos2" style="width:15%;">Unidad de Medida</td>
									<td class="titulos2" style="width:9%;">Catidad Donar</td>
                                    <td class="titulos2" style="width:9%;">Cantidad Bodega</td>
                                    <td class="titulos2" style="width:12%;">Bodega</td>
                                    <td class="titulos2" style="width:8%;">CC</td>
                                    <td class="titulos2" style="width:8%;">Estado</td>
									<td class="titulos2" style="width:5%;">Eliminar</td>
								</tr>
                                <?php
									if ($_POST[tipoelimina]=='2')
									{
										$posi=$_POST[elimina];
										if($_POST[articelimina]==""){$_POST[articelimina]=$_POST[agcodigoart][$posi];}
										else{$_POST[articelimina]="<->".$_POST[agcodigoart][$posi];}
										unset($_POST[agcodigoart][$posi]);
										unset($_POST[agarticulo][$posi]);
										unset($_POST[agnarticulo][$posi]);
										unset($_POST[agunimedida][$posi]);
										unset($_POST[agcantidadmax][$posi]);
										unset($_POST[agcantidad][$posi]);
										unset($_POST[agbodega][$posi]);
										unset($_POST[agnbodega][$posi]);
										unset($_POST[agcc][$posi]);
										unset($_POST[agestado][$posi]);
										$_POST[agcodigoart]= array_values($_POST[agcodigoart]);
										$_POST[agarticulo]= array_values($_POST[agarticulo]);
										$_POST[agnarticulo]= array_values($_POST[agnarticulo]);
										$_POST[agunimedida]= array_values($_POST[agunimedida]);
										$_POST[agcantidadmax]= array_values($_POST[agcantidadmax]);
										$_POST[agcantidad]= array_values($_POST[agcantidad]);
										$_POST[agbodega]= array_values($_POST[agbodega]);
										$_POST[agnbodega]= array_values($_POST[agnbodega]);
										$_POST[agcc]= array_values($_POST[agcc]);
										$_POST[agestado]= array_values($_POST[agestado]);
										$_POST[elimina]='';
										$_POST[tipoelimina]='';
									}
									if ($_POST[agregadet]=='02')
									{
										$_POST[agcodigoart][]="N";
										$_POST[agarticulo][]=$_POST[articulo];
										$_POST[agnarticulo][]=$_POST[narticulo];
										$_POST[agunimedida][]=$_POST[unimedida];
										$_POST[agcantidadmax][]=$_POST[cantidadmax]; 
										$_POST[agcantidad][]=$_POST[cantidad]; 
										$_POST[agbodega][]=$_POST[bodega];
										$_POST[agnbodega][]=$_POST[nbodega];
										$_POST[agcc][]=$_POST[cc];
										$_POST[agestado][]=$_POST[estado];
										$_POST[agregadet]=0;
										echo "
										<script>
											document.getElementById('articulo').value='';
											document.getElementById('narticulo').value='';
											document.getElementById('unimedida').value='';
											document.getElementById('cantidadmax').value='';
											document.getElementById('cantidad').value='';
											document.getElementById('bodega').value='';
											document.getElementById('nbodega').value='';
											document.getElementById('cc').value='';
											document.getElementById('estado').value='';
										</script>";
									}
									$iter='saludo1a';
									$iter2='saludo2';
									$conparti2=count($_POST[agarticulo]);
									for ($x=0;$x<$conparti2;$x++)
									{		 
										echo "
										<input type='hidden' name='agcodigoart[]' value='".$_POST[agcodigoart][$x]."'/>
										<input type='hidden' name='agarticulo[]' value='".$_POST[agarticulo][$x]."'/>
										<input type='hidden' name='agnarticulo[]' value='".$_POST[agnarticulo][$x]."'/>
										<input type='hidden' name='agunimedida[]' value='".$_POST[agunimedida][$x]."'/>
										<input type='hidden' name='agcantidadmax[]' value='".$_POST[agcantidadmax][$x]."'/>
										<input type='hidden' name='agcantidad[]' value='".$_POST[agcantidad][$x]."'/>
										<input type='hidden' name='agbodega[]' value='".$_POST[agbodega][$x]."'/>
										<input type='hidden' name='agnbodega[]' value='".$_POST[agnbodega][$x]."'/>
										<input type='hidden' name='agcc[]' value='".$_POST[agcc][$x]."'/>
										<input type='hidden' name='agestado[]' value='".$_POST[agestado][$x]."'/>";
										if($_POST[agestado][$x]=='U'){$mdestado="Usado";}
										else{$mdestado="Nuevo";}
										echo "
										<tr class='$iter'>
											<td>".($x+1)."</td>
											<td>".$_POST[agarticulo][$x]."</td>
											<td>".$_POST[agnarticulo][$x]."</td>
											<td>".$_POST[agunimedida][$x]."</td>
											<td>".$_POST[agcantidadmax][$x]."</td>
											<td>".$_POST[agcantidad][$x]."</td>
											<td>".$_POST[agnbodega][$x]."</td>
											<td>".$_POST[agcc][$x]."</td>
											<td>$mdestado</td>
											<td style='text-align:center;' onclick=\"eliminar($x,'3')\"><img src='imagenes/del.png' class='icoop'></td>
										</tr>";
										$aux=$iter;
										$iter=$iter2;
										$iter2=$aux;
									}
								?>
                            </table>
						</div>
                        
					</div>
				</div>
			</div>
			<input type="hidden" name="oculto" id="oculto" value="1"/> 
			<input type="hidden" name="agregadet" id="agregadet" value="0"/>
			<input type='hidden' name='elimina' id='elimina' value=""/>
			<input type='hidden' name='tipoelimina' id='tipoelimina' value=""/>
			<input type='hidden' name='partielimina' id='partielimina' value="<?php echo $_POST[partielimina];?>"/>
			<input type='hidden' name='articelimina' id='articelimina' value="<?php echo $_POST[articelimina];?>"/>
			<input type='hidden' name='estadogn' id='estadogn' value="<?php echo $_POST[estadogn];?>"/>
			<input type='hidden' name='bt' id='bt' value=""/>
			  <?php
				if($_POST[oculto]=="2")
				{
					preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/", $_POST[fecha],$fecha);
					$fechaf="$fecha[3]-$fecha[2]-$fecha[1]";
					$sqlr ="UPDATE almactodonacionessal SET fecha='$fechaf',docdonante='$_POST[donante]',nomdonante='$_POST[ndonante]', docdonatario='$_POST[tercero]',nomdonatario='$_POST[ntercero]',valortotal='$_POST[valort]',ciudad='$_POST[ciudad]', lugarfisico='$_POST[lugarfi]',motivo='$_POST[motivo]',otrosdetalles='$_POST[otdetalles]' WHERE id='$_POST[codigo]'";
					if (!mysql_query($sqlr,$linkbd)){echo"<script>despliegamodalm('visible','2','Error al almacenar');</script>";}	
					else 
					{
						$cont=0;
						$contx=count($_POST[agtercerop]);
						for ($x=0;$x<$contx;$x++)
						{
							if($_POST[agcodigo][$x]=="N")
							{
								$consp=selconsecutivo('almactodonacionesentpartici','id');
								$sqlr="INSERT INTO almactodonacionessalpartici (id,idacto,documento,nombre,cargo,estado) VALUES ('$consp','$_POST[codigo]','".$_POST[agtercerop][$x]."','".$_POST[agntercerop][$x]."','".$_POST[agcargop][$x]."','S')";
								if (!mysql_query($sqlr,$linkbd)){$cont=$cont+1;}
							}
						}
						if($_POST[partielimina]!="")
						{
							$nuparti = explode('<->', $_POST[partielimina]);							
							for ($x=0;$x<count($nuparti);$x++)
							{
								$sqlr ="UPDATE almactodonacionessalpartici SET estado='N' WHERE id='$nuparti[$x]'";
								if (!mysql_query($sqlr,$linkbd)){$cont2=$cont2+1;}
							}
						}
						$cont2=0;
						$contx=count($_POST[agarticulo]);
						for ($x=0;$x<$contx;$x++)
						{
							if($_POST[agcodigoart][$x]=="N")
							{
								$consa=selconsecutivo('almactodonacionesentarticu','id');
								$sqlr="INSERT INTO almactodonacionessalarticu (id,idacto,codarticulo,nomarticulo,unumedida,cantidadbodega, cantidadsalida,idbodega,nombodega,cc,estadou,estado) VALUES ('$consa','$_POST[codigo]','".$_POST[agarticulo][$x]."','".$_POST[agnarticulo][$x]."','".$_POST[agunimedida][$x]."','".$_POST[agcantidadmax][$x]."','".$_POST[agcantidad][$x]."','".$_POST[agbodega][$x]."','".$_POST[agnbodega][$x]."','".$_POST[agcc][$x]."','".$_POST[agestado][$x]."','S')";
								if (!mysql_query($sqlr,$linkbd)){$cont2=$cont2+1;}
							}
						}
						if($_POST[articelimina]!="")
						{
							$nuarti = explode('<->', $_POST[articelimina]);							
							for ($x=0;$x<count($nuarti);$x++)
							{
								$sqlr ="UPDATE almactodonacionessalarticu SET estado='N' WHERE id='$nuarti[$x]'";
								if (!mysql_query($sqlr,$linkbd)){$cont2=$cont2+1;}
							}
						}
						if ($cont!=0){echo"<script>despliegamodalm('visible','2','Error al almacenar Participantes');</script>";}
						elseif ($cont2!=0){echo"<script>despliegamodalm('visible','2','Error al almacenar Articulos');</script>";}
						else {echo"<script>despliegamodalm('visible','1','La Salida de Donacion N° $_POST[codigo] solicitada con Exito');</script>";}
					}
				}
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