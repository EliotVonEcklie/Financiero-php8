<?php
	header("Cache-control: no-cache, no-store, must-revalidate");
	header("Content-Type: text/html;charset=utf8");
	require 'comun.inc';
	require 'funciones.inc';
	require 'conversor.php';
	sesion();
	$linkbd=conectar_v7();
	cargarcodigopag($_GET['codpag'],$_SESSION["nivel"]);
	date_default_timezone_set("America/Bogota");
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	$status = "";
	$sq="SELECT valor_inicial FROM dominios WHERE nombre_dominio = 'TIPO_CUENTA_BANCARIA_CARGA'";
	$result=mysqli_query($linkbd,$sq);
	$rw=mysqli_fetch_row($result);
	$_POST['TipoBanco']=$rw[0];
	if(isset($_POST["enviar"])) // obtenemos los datos del archivo
	{
		$tamano = $_FILES["archivo"]['size'];
		$tipo = $_FILES["archivo"]['type'];
		$archivo = $_FILES["archivo"]['name'];
		if ($archivo != "") // guardamos el archivo a la carpeta files
		{
			unset($_POST['codliq']);
			unset($_POST['valrec']);
			unset($_POST['nitpag']);
			unset($_POST['ref2']);
			unset($_POST['egresos']);
			$destino = "files/".$archivo;
			if (copy($_FILES['archivo']['tmp_name'],$destino)) 
			{	
				$file = fopen($destino, "r") or exit("Unable to open file!");//leer archivo linea por linea
				$i=0;
				while(!feof($file))
				{
					$linea=fgets($file);
					switch(substr($linea,0,2))
					{
						case '01':
						{
							switch($_POST['TipoBanco'])
							{
								case 1:
								{
									$anolec=substr($linea,12,4);
									$meslec=substr($linea,16,2);
									$dialec=substr($linea,18,2);
									$fecha1="$dialec/$meslec/$anolec";
									$anolec=substr($linea,40,4);
									$meslec=substr($linea,44,2);
									$dialec=substr($linea,46,2);
									$fecha2="$dialec/$meslec/$anolec";
									$_POST['fecharc']=$fecha1;
									$_POST['fecarc']="$fecha1 - $fecha2";
									$_POST['banco']=substr($linea,29,11);
									$sqlr="select TB1.razonsocial,TB3.nombre,TB2.cuenta,TB2.ncuentaban,TB2.tipo from terceros TB1,tesobancosctas TB2,cuentasnicsp TB3 where TB2.tercero=TB1.cedulanit and TB2.estado='S' AND TB3.cuenta=TB2.cuenta AND TB2.ncuentaban='".$_POST['banco']."'";
									$resp = mysqli_query($linkbd,$sqlr);
									$row=mysqli_fetch_row($resp);
									$_POST['nbanco']=$row[0];
									$_POST['cobanco']=$row[2];
									$_POST['tpcta']=$row[4];
								}break;
								case 2:
								{
									$anolec=substr($linea,15,4);
									$meslec=substr($linea,19,2);
									$dialec=substr($linea,21,2);
									$fecha1=$fecha2="$dialec/$meslec/$anolec";
									$_POST['fecharc']=$fecha1;
									$_POST['fecarc']="$fecha1 - $fecha2";
									$_POST['banco']=substr($linea,30,10)."-".substr($linea,40,1);
									$sqlr="select TB1.razonsocial,TB3.nombre,TB2.cuenta,TB2.ncuentaban,TB2.tipo from terceros TB1,tesobancosctas TB2,cuentasnicsp TB3 where TB2.tercero=TB1.cedulanit and TB2.estado='S' AND TB3.cuenta=TB2.cuenta AND TB2.ncuentaban='".$_POST['banco']."'";
									$resp = mysqli_query($linkbd,$sqlr);
									$row=mysqli_fetch_row($resp);
									$_POST['nbanco']=$row[0];
									$_POST['cobanco']=$row[2];
									$_POST['tpcta']=$row[4];
									$_POST['convenio']=substr($linea,2,13);
								}break;
							}
						}break;
						case '02':
						{
							switch($_POST['TipoBanco'])
							{
								case 1:
								{}break;
								case 2:
								{
									$_POST['tpreg'][]=substr($linea,42,-1);
									$_POST['ref2'][]=$codli=(integer)substr($linea,12,6);
									$_POST['valrec'][]=(integer)substr($linea,27,13);
									$sqlr="SELECT tercero,codigocatastral FROM tesoliquidapredial WHERE idpredial='$codli'";
									$res=mysqli_query($linkbd,$sqlr);
									$row=mysqli_fetch_row($res);
									$_POST['codliq'][]=$row[1];
									$_POST['nitpag'][]=$row[0];
									$sqlr="select nombrepropietario from tesopredios where cedulacatastral='$row[1]'";
									$res=mysqli_query($linkbd,$sqlr);
									$row=mysqli_fetch_row($res);
									$_POST['nompag'][]=$row[0];
									$sqlr="SELECT SUM(totaliquidavig) FROM tesoliquidapredial_det WHERE idpredial='$codli'";
									$res=mysqli_query($linkbd,$sqlr);
									$row=mysqli_fetch_row($res);
									$_POST['valliq'][]=$row[0];
									$sqlr="SELECT id_recibos FROM tesoreciboscaja WHERE id_recaudo='$codli' AND tipo='1'";
									$res=mysqli_query($linkbd,$sqlr);
									$row=mysqli_fetch_row($res);
									$_POST['egresos'][]=$row[0];
								}break;
							}
						}break;
						case '05':
						{
							switch($_POST['TipoBanco'])
							{
								case 1:
								{
									$_POST['convenio']=substr($linea,2,13);
									$sqlr="SELECT nombre FROM codigosbarras WHERE codigo='".$_POST['convenio']."' AND estado='S'";
									$res=mysqli_query($linkbd,$sqlr);
									$row=mysqli_fetch_row($res);
									$_POST['concepto']="Recaudo de $row[0] en banco";
								}break;
								case 2:
								{}break;
							}
						}break;
						case '06':
						{
							switch($_POST['TipoBanco'])
							{
								case 1:
								{
									$_POST['tpreg'][]=substr($linea,90,-1);
									$_POST['ref2'][]=$codli=(integer)substr($linea,34,7);
									$_POST['valrec'][]=(integer)substr($linea,50,12);
									$sqlr="SELECT tercero,codigocatastral FROM tesoliquidapredial WHERE idpredial='$codli'";
									$res=mysqli_query($linkbd,$sqlr);
									$row=mysqli_fetch_row($res);
									$_POST['codliq'][]=$row[1];
									$_POST['nitpag'][]=$row[0];
									$sqlr="select nombrepropietario from tesopredios where cedulacatastral='$row[1]'";
									$res=mysqli_query($linkbd,$sqlr);
									$row=mysqli_fetch_row($res);
									$_POST['nompag'][]=$row[0];
									$sqlr="SELECT SUM(totaliquidavig) FROM tesoliquidapredial_det WHERE idpredial='$codli'";
									$res=mysqli_query($linkbd,$sqlr);
									$row=mysqli_fetch_row($res);
									$_POST['valliq'][]=$row[0];
									$sqlr="SELECT id_recibos FROM tesoreciboscaja WHERE id_recaudo='$codli' AND tipo='1'";
									$res=mysqli_query($linkbd,$sqlr);
									$row=mysqli_fetch_row($res);
									$_POST['egresos'][]=$row[0];
								}break;
								case 2:
								{}break;
							}
						}break;
						case '09':
						{
							switch($_POST['TipoBanco'])
							{
								case 1:
								{
									$_POST['numreg']=(integer)substr($linea,2,9);
									$_POST['valtot']=(integer)substr($linea,11,16);
								}break;
								case 2:
								{
									$_POST['numreg']=(integer)substr($linea,2,9);
									$_POST['valtot']=(integer)substr($linea,11,18);
								}break;
							}
						}break;
					}
					
				}
				fclose($file);
			} 
			else {$status = "Error al subir el archivo";}
		}
		else {$status = "Error al subir archivo";}
	}
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="utf8" />
		<meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: SPID- Tesoreria</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script type="text/javascript" src="css/calendario.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script>
			function despliegamodal2(_valor,_num)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else 
				{
					switch(_num)
					{
						case '1':	document.getElementById('ventana2').src="cuentasbancarias-ventana03.php?tipoc=D";break;
					}
				}
			}
			function validar()
			{
				//document.form2.nbanco.value='BANCOLOMBIA';
				//document.form2.banco.value='';
				//document.form2.tpcta.value='';
				document.form2.convenio.value='';
				document.form2.numreg.value='';
				document.form2.fecarc.value='';
				document.form2.valtot.value='';
				document.form2.oculto.value=5;
				document.form2.submit();
			}
			function guardar()
			{
				if (document.form2.fecha.value!='' && document.form2.banco.value!='')
  				{despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
 				else
				{
  					despliegamodalm('visible','2','Faltan datos para completar el registro');
  					document.form2.fecha.focus();
  					document.form2.fecha.select();
 	 			}
			}
			function pdf()
			{
				document.form2.action="teso-pdfrecaja.php";
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
			function funcionmensaje()
			{
				document.location.href = "teso-planos.php";
			}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.form2.oculto.value=2;
								document.form2.submit();
								break;
				}
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
				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='teso-planos.php'" class="mgbt"/><img src="imagenes/guarda.png" title="Guardar" onClick="guardar()" class="mgbt"/><img src="imagenes/buscad.png" title="Buscar" class="mgbt" onClick="#'"/><img src="imagenes/nv.png" title="Nueva Ventana"class="mgbt" onClick="<?php echo paginasnuevas("teso");?>"/></td>
			</tr>
		</table>
		<div id="bgventanamodalm" class="bgventanamodalm">
			<div id="ventanamodalm" class="ventanamodalm">
				<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
				</IFRAME>
			</div>
		</div>
		<?php
			if(@$_POST['oculto']=='')
			{
				$vigusu=vigencia_usuarios($_SESSION['cedulausu']);
				$vigencia=$vigusu;
				$_POST['idcomp']=$consec=selconsecutivo('tesoplanos','numero');
				if(@$_POST['fecha']==''){$_POST['fecha']=date('d/m/Y');}
				$_POST['vigencia']=$vigencia;
				$_POST['nbanco']='BANCOLOMBIA';
				@$_POST['modlec']=='1';
			}
		?>
		<form name="form2" method="post" action="" enctype="multipart/form-data"> 
			<table class="inicio" style="width:99.7%;">
				<tr >
					<td class="titulos" colspan="7">Base Recaudo Bancos</td>
					<td class="cerrar" style="width:7%" onClick="location.href='teso-principal.php'">Cerrar</td>
				</tr>
				<tr>
					<td class="saludo1" style="width:2cm;">No Recaudo:</td>
					<td style="width:20%;">
						<input type="text" name="idcomp" id="idcomp" value="<?php echo @$_POST['idcomp']?>" onKeyUp="return tabular(event,this)" style="width:100%;" readonly/>
					</td>
					<td class="saludo1" style="width:2.5cm;">Fecha: </td>
					<td style="width:18%;"><input type="text" name="fecha" value="<?php echo @$_POST['fecha']?>" maxlength="10"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" style="width:80%;"/>&nbsp;<a onClick="displayCalendarFor('fc_1198971545');" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px; cursor:pointer"/></a></td>
					<td class="saludo1" style="width:2.5cm;">Vigencia:</td>
					<td style="width:12%;"><input type="text" id="vigencia" name="vigencia" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" value="<?php echo @$_POST['vigencia']?>" onClick="document.getElementById('tipocta').focus(); document.getElementById('tipocta').select();" style="width:100%;" readonly/></td>
					<td rowspan="6" colspan="2" style="background:url(imagenes/siglas.png); background-repeat:no-repeat; background-position:right; background-size: 100% 100%;"></td>
				</tr>
				<tr>
					<td class="saludo1" style="width:2.5cm;">Modo de Lectura:</td>
					<td>
						<select id="modlec" name="modlec" onKeyUp="return tabular(event,this)" onChange="validar()" style="width:80%;">
							<option value="1" <?php if(@$_POST['modlec']=='1') echo "SELECTED"; ?>>Archivo Plano</option>
							<option value="2" <?php if(@$_POST['modlec']=='2') echo "SELECTED"; ?>><?php echo 'Código de Barras' ?></option>
						</select>
					</td>
					<?php
					if(@$_POST['modlec']!='2')
					{
						echo'<td class="saludo1">Recaudado en:</td>
						<td>
							<input type="text" id="nbanco" name="nbanco" value="'.@$_POST['nbanco'].'" style="width:100%;" readonly/>
						</td>
						<td class="saludo1">Cuenta:</td>
						<td>
							<input type="text" id="banco" name="banco" value="'.@$_POST['banco'].'" style="width:100%;" readonly/>
							<input type="hidden" id="cobanco" name="cobanco" value="'.@$_POST['cobanco'].'"/>
						</td>';
					}
					else
					{
						echo'<td class="saludo1">Recaudado en:</td>
						<td>
							<input type="text" id="nbanco" name="nbanco" value="'.@$_POST['nbanco'].'" style="width:80%;" readonly/>
							&nbsp;<a onClick="despliegamodal2(\'visible\',\'1\');"  style="cursor:pointer;" title="Listado Cuentas Bancarias"><img src="imagenes/find02.png" style="width:20px;"/></a>
						</td>
						<td class="saludo1">Cuenta:</td>
						<td>
							<input type="text" id="banco" name="banco" value="'.@$_POST['banco'].'" style="width:100%;" readonly/>
							<input type="hidden" id="cobanco" name="cobanco" value="'.@$_POST['cobanco'].'"/>
						</td>';
					}
					?>
				</tr>
				<tr>
					<td class='saludo1'>Tipo:</td>
					<td>
						<input type='text' id='tpcta' name='tpcta' value='<?php echo @$_POST['tpcta']; ?>' style='width:100%;' readonly/>
					</td>
					<td class='saludo1'>Convenio:</td>
					<td>
						<input type='text' id='convenio' name='convenio' value='<?php echo @$_POST['convenio']; ?>' style='width:100%;' readonly/>
					</td>
					<td class='saludo1'>No. Registros:</td>
					<td>
						<input type='text' id='numreg' name='numreg' value='<?php echo @$_POST['numreg']; ?>' style='width:100%; text-align:center;' readonly/>
					</td>
				</tr>
				<tr>
					<td class="saludo1">Fecha Archivo:</td>
					<td>
						<input type="text" name="fecarc" value="<?php echo @$_POST['fecarc'] ?>" style="width:100%;" readonly/>
					</td>
					<td class="saludo1">Valor Total:</td>
					<td>
						<input type="text" name="valtot" value="<?php echo @$_POST['valtot'];?>" style="width:100%; text-align:right;" readonly/>
					</td>
				</tr>
				<tr>
					<td class="saludo1">Concepto:</td>
					<td colspan="5">
						<input type="text" name="concepto" value="<?php echo @$_POST['concepto'];?>" onKeyUp="return tabular(event,this)" style="width:100%;"/>
					</td>
				</tr>
				<?php
				if(@$_POST['modlec']!='2')
				{
					echo'<tr>
						<td class="saludo1">Archivo:</td>
						<td colspan="5">
							<input name="archivo" type="file" size="35" />
							<input name="enviar" type="submit" value="Subir Archivo" />
							'.$status.'
						</td>
					</tr>';
				}
				else
				{
					echo'<tr>
						<td class="saludo1">C&oacute;digo Barras:</td>
						<td colspan="5">
							<input name="codbar" type="text" size="35" />
							<input name="adicionar" type="submit" value="Adicionar Pago" />
							'.$status.'
						</td>
					</tr>';
				}
				?>
			</table>
			<input type="hidden" name="oculto" id="oculto" value="1"/>
			<input type="hidden" name="trec" value="<?php echo @$_POST['trec']?>"/>
			<input type="hidden" name="agregadet" value="0"/>
			<input type="hidden" name="fecharc" value="<?php echo @$_POST['fecharc'];?>"/>
			<div class="subpantallac7"  style="height:54%; width:99.6%; overflow-x:hidden;" id="divdet">
				<table class="inicio">
					<tr><td colspan="10" class="titulos">Detalle Recaudos</td></tr>
					<tr>
						<td class="titulos2" style="width:5%;">No.</td>
						<td class="titulos2">Fecha</td>
						<td class="titulos2">Nit</td>
						<td class="titulos2">Nombre Pagador</td>
						<td class="titulos2">Cod. Catastral</td>
						<td class="titulos2" style="width:8%">No Liquidaci&oacute;n</td>
						<td class="titulos2" style="width:8%">Valor Liquidaci&oacute;n</td>
						<td class="titulos2" style="width:8%">No Egreso</td>
						<td class="titulos2" style="width:10%;">Valor Recaudado</td>
						<td class="titulos2" style="width:5%;">Estado</td>

					</tr>
					<?php
						$_POST['totalc']=0;
						$co="saludo1a";
						$co2="saludo2";
						for ($x=0;$x<count(@$_POST['codliq']);$x++)
						{	
							$semaf=0;
							if($_POST['egresos'][$x]!=''){$egresn=$_POST['egresos'][$x];$semaf++;}
							else {$egresn="--";}
							if($_POST['valliq'][$x]<>$_POST['valrec'][$x]){$semaf++;}
							if($semaf==0){$imgsem="src='imagenes/sema_verdeON.jpg' title='OK'";}
							else{$imgsem="src='imagenes/sema_rojoON.jpg' title='Error'";}
							
		 					echo "
							<input type='hidden' name='tpreg[]' value='".@$_POST['tpreg'][$x]."'>
							<input type='hidden' name='nitpag[]' value='".@$_POST['nitpag'][$x]."'>
							<input type='hidden' name='nompag[]' value='".@$_POST['nompag'][$x]."'>
							<input type='hidden' name='codliq[]' value='".@$_POST['codliq'][$x]."'>
							<input type='hidden' name='valliq[]' value='".@$_POST['valliq'][$x]."'>
							<input type='hidden' name='ref2[]' value='".@$_POST['ref2'][$x]."'>
							<input type='hidden' name='valrec[]' value='".@$_POST['valrec'][$x]."'>
							<input type='hidden' name='egresos[]' value='".@$_POST['egresos'][$x]."'>
							<tr class='$co'>
								<td>".($x+1)."</td>
								<td>".$_POST['fecharc']."</td>
								<td>".$_POST['nitpag'][$x]."</td>
								<td>".$_POST['nompag'][$x]."</td>
								<td style='text-align:center;'>".$_POST['codliq'][$x]."</td>
								<td style='text-align:center;'>".$_POST['ref2'][$x]."</td>
								<td style='text-align:right;'>$ ".number_format($_POST['valliq'][$x],2,',','.')."</td>
								<td style='text-align:center;'>$egresn</td>
								<td style='text-align:right;'>$ ".number_format($_POST['valrec'][$x],2,',','.')."</td>
								<td style='text-align:center;'><img $imgsem style='width:20px'/></td>
							</tr>";
							$_POST['totalc']=$_POST['totalc']+$_POST['valrec'][$x];
							$_POST['totalcf']=number_format($_POST['totalc'],2);
							$totalg=number_format($_POST['totalc'],2,'.','');
							$aux=$co;
							$co=$co2;
							$co2=$aux;
						}
						if ($_POST['totalc']!='' && $_POST['totalc']!=0){$_POST['letras'] = convertirdecimal($totalg,'.');}
						else{$_POST['letras']=''; $_POST['totalcf']=0;}
						echo "
						<input type='hidden' name='totalcf' value='".@$_POST['totalcf']."'>
						<input type='hidden' name='totalc' value='".@$_POST['totalc']."'>
						<input type='hidden' name='letras' value='".@$_POST['letras']."'>
						<tr class='$co' style='text-align:right;'>
							<td colspan='8'>Total</td>
							<td>$ ".$_POST['totalcf']."</td>
						</tr>
						<tr class='titulos2'>
							<td>Son:</td>
							<td colspan='9'>".$_POST['letras']."</td>
						</tr>";
					?>
				</table>
				<input type="hidden" name="TipoBanco" id="TipoBanco" value="<? echo @$_POST['TipoBanco'];?>"/>
			</div>
			<?php
				if(@$_POST['oculto']=='2')
				{
					if(@$_POST['valtot']==@$_POST['totalc'])
					{
						preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/", $_POST['fecha'],$fecha);
						$fechaf="$fecha[3]-$fecha[2]-$fecha[1]";
						//GUARDAR RECAUDO MAESTRO
						$consec=selconsecutivo('tesoplanos','numero');
						$sqlp="INSERT INTO tesoplanos (numero,fecha,vigencia,convenio,cuenta,banco,concepto,registros,fecarc,total, modlec,estado) values('".$_POST['idcomp']."','$fechaf','".$_POST['vigencia']."','".$_POST['convenio']."', '".$_POST['banco']."','".$_POST['nbanco']."','".$_POST['concepto']."','".$_POST['numreg']."', '".$_POST['fecarc']."','".$_POST['valtot']."','".$_POST['modlec']."','N')";
						mysqli_query($linkbd,$sqlp);
						//******* GUARDAR DETALLE DEL RECIBO DE CAJA ******	
						for($x=0;$x<count($_POST['codliq']);$x++)
						{
							if((@$_POST['egresos'][$x]=='') && (@$_POST['valliq'][$x]==@$_POST['valrec'][$x]))
							{
								$maxid=selconsecutivo('tesoplanos_det','id');
								$valdet=(float) $_POST['valrec'][$x];
								$sqlr="INSERT INTO tesoplanos_det (id,plano,registro,fecha,hora,tercero,liquidacion,ref2,valor) values('$maxid','".$_POST['idcomp']."','".$_POST['tpreg'][$x]."','$fechaf','','".$_POST['nitpag'][$x]."','".$_POST['codliq'][$x]."','".$_POST['ref2'][$x]."','$valdet')";
								mysqli_query($linkbd,$sqlr);
								$sqlr="UPDATE tesoliquidapredial SET estado='P' WHERE idpredial='".$_POST['ref2'][$x]."'";
								mysqli_query($linkbd,$sqlr);
								$user=$_SESSION['nickusu'];
								$conreca=selconsecutivo("tesoreciboscaja","id_recibos");
								$sqlr="insert into tesoreciboscaja (id_recibos,id_comp,fecha,vigencia,id_recaudo,recaudado,cuentacaja, cuentabanco,valor,estado,tipo,descripcion,usuario) values('$conreca','0','$fechaf', '".$_POST['vigencia']."','".$_POST['ref2'][$x]."','banco','','".$_POST['cobanco']."', '".$_POST['valrec'][$x]."','S','1','".$_POST['concepto']."','$user')";
								mysqli_query($linkbd,$sqlr);
								$sqlr="SELECT * FROM tesoliquidapredial_det WHERE idpredial='".$_POST['ref2'][$x]."'";
								$resq=mysqli_query($linkbd,$sqlr);
								while($rq=mysqli_fetch_row($resq))
								{
									$sqlr2="UPDATE tesoprediosavaluos SET pago='S' WHERE codigocatastral=(select codigocatastral FROM tesoliquidapredial WHERE idpredial='".$_POST['ref2'][$x]."') AND vigencia='$rq[1]'";
									mysqli_query($linkbd,$sqlr2);
									$sqlr3="INSERT into tesoreciboscaja_det (id_recibos,ingreso,valor,estado) values ('$conreca','01','$rq[11]' ,'S')";
									mysqli_query($linkbd,$sqlr3);
								}
							}
						}
						echo "<script>despliegamodalm('visible','1','Se ha almacenado con Exito');</script>";
						//***** FIN DETALLE RECIBO DE CAJA ***************
					}
					else {echo"<script>despliegamodalm('visible','2','Los Totales NO Coinciden');</script>";}
				}//**fin del oculto 
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