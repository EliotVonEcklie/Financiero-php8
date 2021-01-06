<?php
	ini_set('max_execution_time',3600);
	header("Cache-control: no-cache, no-store, must-revalidate");
	header("Content-Type: text/html;charset=utf8");
	require "comun.inc";
	require "funciones.inc";
	session_start();
	$linkbd=conectar_v7();
	cargarcodigopag(@$_GET['codpag'],$_SESSION["nivel"]);
	date_default_timezone_set("America/Bogota");
	//error_reporting(E_ALL);
	//ini_set('display_errors', '1');
	if (!isset($_POST['clasificacion']))
	{
		$_POST['clasificacion']='N';
		$_POST['tipo']='N';
		$_POST['grupo']='N';
	}
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="utf8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Spid - Activos Fijos</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css4.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script type="text/javascript" src="css/calendario.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<style>
			input[type='text']{height:30px;}
			input[type='search']{height:30px;}
			select{height:30px;}
		</style>
		<script>
			function mostrar()
			{
				if (document.getElementById("cuerpo1").style.visibility == 'visible'){document.getElementById("cuerpo1").style.visibility= 'hidden';}
				else{document.getElementById("cuerpo1").style.visibility= 'visible';}  
			}
			function guardar()
			{
				if(document.form2.periodo.value!='')
					{if (confirm("Esta Seguro de Guardar")){document.form2.oculto.value=2;document.form2.listar.value=2;document.form2.submit();}}
				else{alert('Seleccione un MES para realizar la Depreciaci�n');}
			}
			function clasifica(formulario)
			{
				//document.form2.action="presu-recursos.php";
				document.form2.submit();
			}
			function agregardetalle()
			{
				if(document.form2.cuenta.value!=""  && document.form2.cc.value!="" ){document.form2.agregadet.value=1;document.form2.submit();}
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
			function buscacta(e)
			{
				if (document.form2.cuenta.value!="")
				{
					document.form2.bc.value='1';
					document.form2.submit();
				}
			}
			function buscacc(e)
			{
				if (document.form2.cc.value!="")
				{
					document.form2.bcc.value='1';
					document.form2.submit();
				}
			}
			function validar2()
			{
				document.form2.oculto.value=2;
				document.form2.action="presu-concecontablesconpes.php";
				document.form2.submit();
			}
			function validar(){document.form2.submit();}
			function creaplaca()
			{
				clasi=document.getElementById("clasificacion").value;
				grup=document.getElementById("grupo").value;
				cons=document.getElementById("consecutivo").value;
				document.getElementById("placa").value=clasi+'-'+grup+'-'+cons;
			}
			function agregardetalle()
			{
				if(document.form2.cuentadeb.value!=""  && document.form2.cc.value!=""){document.form2.agregadet.value=1;document.form2.submit();}
				else {alert("Falta informacion para poder Agregar");}
			}
			function buscaract()
			{
				document.form2.listar.value=2;
				document.form2.submit();
			}
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("acti");</script><?php cuadro_titulos();?></tr>
			<tr><?php menu_desplegable("acti");?></tr>
			<tr>
				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='acti-reporteactivos.php'" class="mgbt"/><img src="imagenes/guarda.png" title="Guardar" onClick="guardar()" class="mgbt"/><img src="imagenes/busca.png" title="Buscar" onClick="location.href='acti-reporteactivos.php'" class="mgbt"/><img src="imagenes/agenda1.png" title="Agenda" onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" onClick="mypop=window.open('acti-principal.php','','');mypop.focus();" class="mgbt"/><a href="<?php echo "acti-reporteactivoscsv.php?clasificacion=".$_POST['clasificacion']."&tipo=".$_POST['tipo']."&grupo=".$_POST['grupo']."&fecha1=".$_POST['fecha1']."&fecha2=".$_POST['fecha2']."&placa1=".$_POST['placaini']."&placa2=".$_POST['placafin']; ?>" target="_blank" class="mgbt"><img src="imagenes/csv.png"  title="csv"></a></td>
			</tr>
		</table>
		<form name="form2" method="post" action=""> 
			<div class="loading" id="divcarga"><span>Cargando...</span></div>
			<?php
				$vigencia=date('Y');
				$vs=" ";
				if(!@$_POST['oculto'])
				{
					$fec=date("d/m/Y");
					$_POST['fecha']=$fec;
					$_POST['vigencia']=$vigencia;
					$_POST['vigdep']=$vigencia;
					$_POST['valor']=0;
					$vs=" style=visibility:visible";
					echo"<script>document.getElementById('divcarga').style.display='none';</script>";
				}
				if(@$_POST['bc']=='1')//**** busca cuenta
				{
					$nresul=buscacuenta($_POST['cuenta']);
					if($nresul!=''){$_POST['ncuenta']=$nresul;}
					else {$_POST[ncuenta]="";}
				}
				if(@$_POST['bcc']=='1')//**** busca centro costo
				{
					$nresul=buscacentro($_POST['cc']);
					if($nresul!=''){$_POST['ncc']=$nresul;}
					else {$_POST['ncc']="";}
				}
			?>
			<table class="inicio" align="center"  >
				<tr>
					<td class="titulos" colspan="10">.: Reporte de Activos</td>
					<td style="width:7%"><label class="boton02" onClick="location.href='acti-principal.php'">Cerrar</label></td>
				</tr>
				<tr>
					<td class="saludo1" style="width:2cm;">Fecha Inicial:</td>
					<td style="width:15%;"><input type="text" name="fecha1" value="<?php echo @$_POST['fecha1']?>" maxlength="10"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" style="width:75%;" title="DD/MM/YYYY"/>&nbsp;<a href="#" onClick="displayCalendarFor('fc_1198971545');" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px;"/></a></td>
					<td class="saludo1" style="width:2cm;">Fecha Final:</td>
					<td style="width:15%;"><input name="fecha2" type="text" value="<?php echo @$_POST['fecha2']?>" maxlength="10"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971546" onKeyDown="mascara(this,'/',patron,true)" style="width:75%;" title="DD/MM/YYYY"/>&nbsp;<a href="#" onClick="displayCalendarFor('fc_1198971546');" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px;"/></a></td>
				
					<td class="saludo1" style="width:2cm;">Placa Inicial:</td>
					<td ><input type="search" name="placaini" id="placaini" value="<?php echo @$_POST['placaini'];?>" style="width:100%;"/></td>
					<td class="saludo1" style="width:2cm;">Placa Final:</td>
					<td><input type="search" name="placafin" id="placafin" value="<?php echo @$_POST['placafin'];?>" style="width:100%;"/></td>
					
				</tr>
				<tr>
					<td class="saludo1" >.: Clase:</td>
					<td >
						<select id="clasificacion" name="clasificacion" onChange="document.form2.submit()" style="width:100%">
							<option value="">...</option>
							<?php
								$sqlr="SELECT * from actipo where niveluno='0' and estado='S'";
								$resp = mysqli_query($linkbd,$sqlr);
								while ($row =mysqli_fetch_row($resp)) 
								{
									if($row[0]==$_POST['clasificacion'])
									{
										echo "<option value='$row[0]' SELECTED>".$row[0].' - '.strtoupper($row[1])."</option>";
									}
									else {echo "<option value='$row[0]'>".$row[0].' - '.strtoupper($row[1])."</option>";}
								}
							?>
						</select>
						<input type="hidden" name="clasificacion2" id="clasificacion2" value="<?php echo @$_POST['clasificacion']?>" onKeyUp="return tabular(event,this)"/>
					</td>
					<td class="saludo1" >.: Grupo:</td>
					<td >
						<select id="grupo" name="grupo" onChange="document.form2.submit()" style="width:100%">
							<option value="">...</option>
							<?php
							$sqlr="SELECT * from actipo where niveluno='".$_POST['clasificacion']."' and estado='S'";
							$resp = mysqli_query($linkbd,$sqlr);
							while ($row=mysqli_fetch_row($resp)) 
							{
								if($row[0]==$_POST['grupo'])
								{
									echo "<option value='$row[0]' SELECTED>".$row[0].' - '.strtoupper($row[1])."</option>";
								}
								else{echo "<option value='$row[0]'>".$row[0].' - '.strtoupper($row[1])."</option>";}
							}
							?>
						</select>
						<input type="hidden" name="grupo2" id="grupo2" value="<?php echo @$_POST['grupo']?>" onKeyUp="return tabular(event,this)"/>
					</td>
					<td class="saludo1">.: Tipo:</td>
					<td >
						<select id="tipo" name="tipo" onChange="document.form2.submit()" style="width:100%">
							<option value="">...</option>
							<?php
								$sqlr="SELECT * from actipo where niveluno='".$_POST['grupo']."' and niveldos = '".$_POST['clasificacion']."' and estado='S'";
								$resp = mysqli_query($linkbd,$sqlr);
								while ($row =mysqli_fetch_row($resp)) 
								{
									if($row[0]==$_POST['tipo'])
									{
										echo "<option value='$row[0]' SELECTED>".$row[0].' - '.strtoupper($row[1])."</option>";
										$_POST['nombre'] = $row[1];
									}
									else {echo "<option value='$row[0]'>".$row[0].' - '.strtoupper($row[1])."</option>";}
								}
							?>
						</select>
						<input type="hidden" name="tipo2" id="tipo2" value="<?php echo @$_POST['tipo']?>" onKeyUp="return tabular(event,this)"/>
						<input type="hidden" name="nombre" id="nombre" value="<?php echo @$_POST['nombre']?>" onKeyUp="return tabular(event,this)"/>
					</td>
					<input name="oculto" type="hidden" value="1"><input name="listar" type="hidden" value="1"></td>
					<td style="padding-bottom:1px"><em class="botonflecha" onClick="buscaract()">Buscar</em></td>
				</tr>
			</table>
		<div class="subpantalla" style="height:60%; width:99.6%;">
			<table class="inicio">
				<tr><td class="titulos" colspan="18">Listado de Activos</td></tr>
				<tr class="titulos2">
					<td>No</td>
					<td>Placa</td>
					<td>Fecha Activacion</td>
					<td>Fecha Compra</td>
					<td>Nombre</td>
					<td>Clasificacion</td>
					<td>Grupo</td>
					<td>Tipo</td>
					<td>Ref.</td>
					<td>Mod.</td>
					<td>Serial</td>
					<td>Origen</td>
					<td>Valor</td>
					<td>Valor Depreciado</td>
					<td>Valor de Correccion</td>
					<td>Valor por Depreciar</td>
					<td>Fecha Ultima Depre</td>
				</tr>
				<?php
					if(@$_POST['listar']=='2')
					{
						if($_POST['clasificacion']!=''){$criterio=" and clasificacion='".$_POST['clasificacion']."'";}
						else{$criterio='';}
						if($_POST['tipo']!='') {$criterio2=" and tipo='".$_POST['tipo']."'";}
						else{$criterio2='';}
						if($_POST['grupo']!='') {$criterio3=" and grupo='".$_POST['grupo']."'";}
						else{$criterio3='';}
						if($_POST['fecha1']!='')
						{
							$fech1=split("/",$_POST['fecha1']);
							$f1=$fech1[2]."-".$fech1[1]."-".$fech1[0];
							if(@$_POST['fecha2']!='')
							{
								$fech2=split("/",$_POST['fecha2']);
								$f2=$fech2[2]."-".$fech2[1]."-".$fech2[0];
								$criterio4=" AND fechacom between '$f1' AND '$f2'";
							}
							else{$criterio4=" AND fechacom >= '$f1'";}
						}
						else if(@$_POST['fecha2']!='') 
						{
							$fech2=split("/",$_POST['fecha2']);
							$f2=$fech2[2]."-".$fech2[1]."-".$fech2[0];
							$criterio4=" AND fechacom <= '$f2'";
						}
						else{$criterio4="";}
						if($_POST['placaini']!='')
						{
							if($_POST['placafin']!='')
							{
								$criterio5=" AND placa between '".$_POST['placaini']."' AND '".$_POST['placafin']."'";
							}
							else{$criterio5="AND placa = '".$_POST['placaini']."'";}
							
						}
						else{$criterio5='';}
						$fechadep=@$_POST['vigdep'].'-'.@$_POST['periodo'].'-01';
						$sqlr="SELECT * FROM acticrearact_det WHERE estado='S'  $criterio $criterio3 $criterio2 $criterio4 $criterio5	ORDER BY placa";
						$row = view($sqlr);
						$resp = mysqli_query($linkbd,$sqlr);
						$tama=count($row);
						$con=1;
						$co="zebra1";
						$co2='zebra2';
						$cuentas[]=array();
						$sumavalor=0;
						$sumavalordep=0;
						$sumaxvalordep=0;
						$sumavalordepmen=0;
						$vector_origen = consultar_origen();
						$sumsubtotal1=0;
						$sumsubtotal2=0;
						$sumsubtotal3=0;
						$sumsubtotal4=0;
						$sumsubtotal5=0;
						while($con<=$tama)
						{
							@$cuentas[$row[$con-1]['clasificacion']][0]=$row[$con-1]['clasificacion'];
							@$cuentas[$row[$con-1]['clasificacion']][1]+=$row[$con-1]['valdepmen'];	
							@$cuentas[$row[$con-1]['clasificacion']][2]=$row[$con-1]['cc'];

							$sqlr = "Select nombre from actipo where tipo='1' and codigo='".$row[$con-1]['clasificacion']."' and estado='S'";
							$resp = mysqli_query($linkbd,$sqlr);
							$cla = mysqli_fetch_row($resp);

							$sqlr = "Select nombre from actipo where tipo='2' and niveluno='".$row[$con-1]['clasificacion']."' and codigo='".$row[$con-1]['grupo']."' and estado='S'";
							$resp = mysqli_query($linkbd,$sqlr);
							$gru = mysqli_fetch_row($resp);

							$sqlr = "Select nombre from actipo where tipo='3' and niveluno='".$row[$con-1]['grupo']."' and niveldos='".$row[$con-1]['clasificacion']."' and codigo='".$row[$con-1]['tipo']."' and estado='S'";
							$resp = mysqli_query($linkbd,$sqlr);
							$tip = mysqli_fetch_row($resp);

							$agesdep=$row[$con-1]['nummesesdep'];
							$fechacorte='2013-09-30';		
							$fechareg=$row[$con-1]['fechact'];			
							$meses=diferenciamesesfechas($fechareg,$fechacorte);
							$valordep=0;
							$sqlrDep = "SELECT SUM(valcredito) FROM comprobante_det WHERE (tipo_comp='22' OR tipo_comp='78') AND numacti='".$row[$con-1]['placa']."'";
							$rowDep = view($sqlrDep);

							//var_dump($rowDep);
							$valordep = $rowDep[0]["SUM(valcredito)"];
							@$valorcorrec=$row[$con-1]['valorcorrec'];
							$valoract=$row[$con-1]['valor'];
							$valdepmen=$row[$con-1]['valdepmen'];
							if($meses<$agesdep)
							{
								$mesesdep=$row[$con-1]['mesesdepacum'];
								$fechadep=sumamesesfecha($row[$con-1]['fechact'],$mesesdep);	
								//$valordep=$row[$con-1]['valdepact'];
							}
							else
							{
								$mesesdep=$row[$con-1]['mesesdepacum']	;  
								$fechadep=sumamesesfecha($row[$con-1]['fechact'],$mesesdep);
								//$valordep=$row[$con-1]['valdepact'];
							}
							$valxdep=round($valoract-$valordep,2);
							if($con==1)
							{
								$sumsubtotal1=1;
								$sumsubtotal2=$valoract;
								$sumsubtotal3=$valordep;
								$sumsubtotal4=$valorcorrec;
								$sumsubtotal5=$valxdep;
								$codtipo=$tip[0];
							}
							else if($codtipo==$tip[0])
							{
								$sumsubtotal1++;
								$sumsubtotal2+=$valoract;
								$sumsubtotal3+=$valordep;
								$sumsubtotal4+=$valorcorrec;
								$sumsubtotal5+=$valxdep;
							}
							else
							{
								echo "
								<tr class='titulos1' style='text-align:right;'>
									<td colspan='12'>Totales: $sumsubtotal1</td>
									<td>".number_format($sumsubtotal2,2,',','.')."</td>
									<td>".number_format($sumsubtotal3,2,',','.')."</td>
									<td>".number_format($sumsubtotal4,2,',','.')."</td>
									<td>".number_format($sumsubtotal5,2,',','.')."</td>
									<td></td>
								</tr>";
								$sumsubtotal1=1;
								$sumsubtotal2=$valoract;
								$sumsubtotal3=$valordep;
								$sumsubtotal4=$valorcorrec;
								$sumsubtotal5=$valxdep;
								$codtipo=$tip[0];
							}
							echo "<tr class='$co'>
							<td>$con</td>
							<td>".$row[$con-1]['placa']."</td>
							<td>".$row[$con-1]['fechacom']."</td>
							<td>".$row[$con-1]['fechacom']."</td>
							<td>".$row[$con-1]['nombre']."</td>
							<td>".$cla[0]."</td>
							<td>".@$gru[0]."</td>
							<td>".$tip[0]."</td>
							<td>".$row[$con-1]['referencia']."</td>
							<td>".$row[$con-1]['modelo']."</td>
							<td>".$row[$con-1]['serial']."</td>
							<td>".@$vector_origen['0'.$row[$con-1]['origen']]."</td>
							<td style='text-align:right;'>".number_format($valoract,2,',','.')."</td>
							<td style='text-align:right;'>".number_format($valordep,2,',','.')."</td>
							<td style='text-align:right;'>".number_format($valorcorrec,2,',','.')."</td>
							<td style='text-align:right;'>".number_format($valxdep,2,',','.')."</td>
							<td>$fechadep</td></tr>";	
							$con+=1;
							$aux=$co;
							$co=$co2;
							$co2=$aux;
							$sumavalor+=$valoract;
							$sumavalordep+=$valordep;
							@$sumavalorcorrec+=$valorcorrec;
							$sumaxvalordep+=$valxdep;
							@$sumavalordepmen+=$valdepmen;
						}
						echo "
						<tr class='titulos1' style='text-align:right;'>
							<td colspan='12'>Totales: $sumsubtotal1</td>
							<td>".number_format($sumsubtotal2,2,',','.')."</td>
							<td>".number_format($sumsubtotal3,2,',','.')."</td>
							<td>".number_format($sumsubtotal4,2,',','.')."</td>
							<td>".number_format($sumsubtotal5,2,',','.')."</td>
							<td></td>
						</tr>
						<tr class='$co' style='text-align:right;'>
							<td colspan='12'>TOTALES:  ".($con-1)."</td>
							<td>".number_format($sumavalor,2,',','.')."</td>
							<td>".number_format($sumavalordep,2,',','.')."</td>
							<td>".number_format($sumavalorcorrec,2,',','.')."</td>
							<td>".number_format($sumaxvalordep,2,',','.')."</td>
							<td>".number_format($sumavalordepmen,2,',','.')."</td>
						</tr>
						<script>document.getElementById('divcarga').style.display='none';</script>";
					}
				?>
			</table>
		</form>
	</body>
</html>