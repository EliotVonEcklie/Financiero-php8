<!--V 1.0 24/02/2015-->
<?php
	require"comun.inc";
	require"funciones.inc";
	ini_set('max_execution_time', 7200);
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
		<title>:: Spid - Activos Fijos</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
		<link href="css/css3.css" rel="stylesheet" type="text/css" />
		<link href="css/css4.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
		<script type='text/javascript' src='JQuery/jquery-2.1.4.min.js'></script>
		<script>
			$(window).load(function () { $('#cargando').hide();});
			function guardar()
			{
				despliegamodalm('visible','4','Esta Seguro de Guardar','1');
			}
			function despliegamodal2(_valor,v)
			{
					document.getElementById("bgventanamodal2").style.visibility=_valor;
					if(_valor=="hidden"){
						document.getElementById('ventana2').src="";
						document.form2.submit();
					}
					else {
						if(v==1){
							document.getElementById('ventana2').src="cuentas-ventana1.php?fecha=01/01/2018";
						}
						else if(v==2)
						{
							document.getElementById('ventana2').src="tercerosgral-ventana01.php?objeto=tercero&nobjeto=ntercero&nfoco=solicita";
						}
						else if(v==3)
						{
							document.getElementById('ventana2').src="cuentas-ventana3.php?fecha="+document.form2.fecha1.value;
						}
						else if(v==4)
						{
							document.getElementById('ventana2').src="cuentas-ventana4.php?fecha="+document.form2.fecha1.value;
						}
					}
			}
			function despliegamodalm(_valor,_tip,mensa,pregunta,variable)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden")
				{
					document.getElementById('ventanam').src="";
					if(document.getElementById('valfocus').value=="2")
					{
						document.getElementById('valfocus').value='1';
						document.getElementById('codigo').focus();
						document.getElementById('codigo').select();
					}
				}
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
						case "5":
							document.getElementById('ventanam').src="ventana-elimina1.php?titulos="+mensa+"&idresp="+pregunta+"&variable="+variable;break;	
					}
				}
			}
				
			function funcionmensaje(){
				document.location.href = "acti-depreciarinicial.php";
			}
				
			function respuestaconsulta(pregunta, variable)
			{
				switch(pregunta)
				{
					case "1":
						document.form2.oculto.value=2;
						document.form2.listar.value=2;
						document.form2.submit();						
						break;
				}
			}
			
			function validar(){document.form2.submit();}

			function buscaract()
			{
				var validacion01=document.getElementById('fc_1198971546').value;
				if(validacion01.trim()!='')
				{
					document.form2.listar.value=2;
					document.form2.oculto.value=1;
					document.form2.submit();
				}
				else
				{
					despliegamodalm('visible','2','Seleccione hasta que fecha va a depreciar.');
				}
			}

			function iratras(){
				location.href="acti-gestiondelosactivos.php";
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
			<td colspan="3" class="cinta">
				<a href="acti-depreciarinicial.php" class="mgbt"><img src="imagenes/add.png"  title="Nuevo"/></a>
				<a href="#"  onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png"  title="Guardar" /></a>
				<a href="acti-buscagestionactivos.php" class="mgbt"><img src="imagenes/busca.png"  title="Buscar"/></a>
				<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
				<a href="#" onClick="mypop=window.open('acti-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="nueva ventana"></a>
				<a onclick="iratras()" class="mgbt"><img src="imagenes/iratras.png" title="Atrás"></a>
			</td>
		</tr>
	</table>
	<?php
	$vigencia=date(Y);
	$vs=" ";
	if(!$_POST[oculto])
	{
		$fec=date("d/m/Y");
		$_POST[fecha]=$fec; 	
		//$_POST[fecha2]='2017-12-31';
 	 	$_POST[vigencia]=$vigencia;
		$_POST[vigdep]=$vigencia;	
		$sqlr="SELECT MAX(codigo) FROM acti_deprecia_inicial";
		//echo $sqlr;
		$res=mysql_query($sqlr,$linkbd);
		$row=mysql_fetch_row($res);
		$_POST[codigo]=$row[0]+1;
		$_POST[valor]=0;	
		$vs=" style=visibility:visible";	 		 
	} 				  
	?>
    <div id="bgventanamodalm" class="bgventanamodalm">
        <div id="ventanamodalm" class="ventanamodalm">
            <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"></IFRAME>
		</div>
	</div>
	<form name="form2" method="post" action=""> 
		
		<table class="inicio" align="center"  >
			<tr>
				<td class="titulos" colspan="11">.: Gestion de Activos - Depreciaci&oacute;n Inicial</td>
				<td  class="cerrar" ><a href="acti-principal.php">Cerrar</a></td>
			</tr>
			<tr>
				<td class="saludo1">Documento:</td>
				<td valign="middle" >
					<input name="codigo" type="text" id="codigo" size="10" value="<?php echo $_POST[codigo]; ?>" onKeyUp="return tabular(event,this)" readonly />         
				</td>
				<td class="salud1" style='width:8%'>Cuenta Debito:</td>
				<td style='width:8%'>
					<input name="cuentact" id="cuentact" type="text"  value="<?php echo $_POST[cuentact]?>" onKeyUp="return tabular(event,this) " style="width:60%;" onBlur="validar2()">
					<input name="cuentact_" type="hidden" value="<?php echo $_POST[cuentact_]?>">&nbsp;<img src="imagenes/find02.png" style="width:20px;" onClick="despliegamodal2('visible',1);" title="Buscar cuenta" class="icobut" />
					
				</td>
				<td><input type="text" name="ncuentact" style="width:100%;" value="<?php echo $_POST[ncuentact]?>" readonly></td>
				<td  class="saludo1">Fecha:</td>
					<td>
						<input type="hidden" value="<?php echo $ $vigusu ?>" name="vigencias"><input id="fc_1198971545" title="DD/MM/YYYY" name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10" size="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onKeyDown="mascara(this,'/',patron,true)"><a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/calendario04.png" style="width:20px" align="absmiddle" border="0"></a>
					</td>
				<td class="saludo1">Depreciar hasta: </td>
				<td>
					<input type="hidden" value="<?php echo $ $vigusu ?>" name="vigencias"><input id="fc_1198971546" title="DD/MM/YYYY" name="fecha2" type="text" value="<?php echo $_POST[fecha2]?>" maxlength="10" size="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onKeyDown="mascara(this,'/',patron,true)"><a href="#" onClick="displayCalendarFor('fc_1198971546');"><img src="imagenes/calendario04.png" style="width:20px" align="absmiddle" border="0"></a>
				</td>  
				
				<td>
					<input name="vigdep" type="hidden" id="vigdep" value="<?php echo $_POST[vigdep]?>" size="4" maxlength="4" readonly>
					<input name="oculto" type="hidden" value="1">
					<input name="listar" type="hidden" value="1">
				</td>
				<td>
					<input type="button" name="buscar" value="Buscar" onClick="buscaract()">
				</td>
			</tr>          
		</table>    
		<div class="subpantalla" style="height:66.5%; width:99.6%; overflow-x:hidden;">
		<table class="inicio">
			<thead>
				<tr><td class="titulos" colspan="12">Listado de Activos - Depreciaci&oacute;n Inicial</td></tr>
				<tr>
					<td class="titulos2"><center>No</center></td>
					<td class="titulos2"><center>Placa</center></td>
					<td class="titulos2"><center>Fecha Activacion</center></td>
					<td class="titulos2"><center>Nombre</center></td>
					<td class="titulos2"><center>Valor</center></td>
					<td class="titulos2"><center>Meses de depreciacion total</center></td>
					<td class="titulos2"><center>Valor de depreciacion mes</center></td>
					<td class="titulos2"><center>Meses de depreciacion a la fecha indicada</center></td>
					<td class="titulos2"><center>Valor depreciacion a la fecha indicada</center></td>
					<td class="titulos2"><center>Saldo</center></td>
				</tr> 
			</thead>
			<?php
			if($_POST[listar]=='2')
			{
				echo"<div class='loading' id='divcarga'><span>Cargando...</span></div>";
				$sqlr="SELECT * FROM acticrearact_det WHERE acticrearact_det.estado='S' ORDER BY acticrearact_det.placa";
				$resp = mysql_query($sqlr,$linkbd);
				$con=1;
				$co="zebra1";
				$co2='zebra2';
				//$cuentas[]=array();
				$x=0;
				$result=0;
				while ($row =mysql_fetch_assoc($resp)) 
				{
					$nivel1='';
					$nivel2='';
					$codplaca='';
					/*$cuentas[$row[9]][0]=$row[9];
					$cuentas[$row[9]][1]+=$row[21];	
					$cuentas[$row[9]][2]=$row[14];*/
					preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/",$_POST[fecha2],$fecha);
					$fechaf="$fecha[3]-$fecha[2]-$fecha[1]";
					$mesesdic=diferenciamesesfechas($row["fechacom"],$fechaf);
					$valoract=$row["valor"];
					$codplaca=substr($row["placa"],0,1);
					$nivel1=substr($row["placa"],1,2);
					$nivel2=substr($row["placa"],3,3);
					if($row["bloque"]=='1')
					{
						$sqlr1="SELECT * FROM actipo WHERE codigo='$nivel2' AND niveluno='$nivel1' AND niveldos='$codplaca'";
						$res1=mysql_query($sqlr1,$linkbd);
						$row1=mysql_fetch_assoc($res1);
						$mesesdeptot=$row1["deprecia"];
					}
					else
					{
						$mesesdeptot=$row["nummesesdep"];
					}
					$valordepm=round($valoract/$mesesdeptot,2);
					$valordic=round($valordepm*$mesesdic,2);
					$saldo=$valoract-$valordic;
					if($saldo<'0')
					{
						$saldo=0;
					}
					//arreglo
					$sqlrConsultar = "SELECT numerotipo FROM comprobante_det WHERE numacti='".$row['placa']."' AND tipo_comp='22'";
					$resConsultar = mysql_query($sqlrConsultar,$linkbd);
					$rowConsultar=mysql_fetch_assoc($resConsultar);
					if($rowConsultar['numerotipo']!='')
					{
						$result+=1;
					}
					else
					{
						$_POST[dplaca][$x]=$row["placa"];
						$_POST[dfecact][$x]=$row["fechacom"];
						$_POST[dnombre][$x]=$row["nombre"];		 
						$_POST[dvalact][$x]=$valoract;       		//valor activo
						$_POST[dmesesdept][$x]=$mesesdeptot;		//Meses de depreciacion total 
						$_POST[dvalordepm][$x]=$valordepm;         	//Valor de depreciacion mes
						$_POST[dmesesdic][$x]=$mesesdic;	 		//Meses de depreciacion a diciembre 2017
						$_POST[dvalordic][$x]=$valordic;		 	//Valor depreciacion a 31 de diciembre 2017 
						$_POST[dsaldo][$x]=$saldo;		 			//Saldo	 		 
						//fin arreglo
						echo "<tbody> <tr class='$co' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\" >
							<td style='width:3%'>$con</td>
							<td style='width:4%'>
								<input name='dplaca[]' value='".$_POST[dplaca][$x]."' type='text' style='width:100%' class='inpnovisibles' readonly>
							</td>
							<td style='width:5%'>
								<input name='dfecact[]' value='".cambiar_fecha($_POST[dfecact][$x])."' type='text' style='width:100%' class='inpnovisibles' readonly>
							</td>
							<td style='width:18%'>
								<input name='dnombre[]' value='".$_POST[dnombre][$x]."' type='text' style='width:100%' class='inpnovisibles' readonly>
							</td>
							<td style='width:6%'>
								<input name='dvalact[]' value='".number_format($_POST[dvalact][$x],2,',','.')."' type='text' style='width:100%; text-align:right;' class='inpnovisibles' readonly>
							</td>
							<td style='width:4%'>
								<input name='dmesesdept[]' value='".$_POST[dmesesdept][$x]."' type='text' style='width:100%; text-align:right;' class='inpnovisibles' readonly>
							</td>
							<td style='width:4%'>
								<input name='dvalordepm[]' value='".number_format($_POST[dvalordepm][$x],2,',','.')."' type='text' style='width:100%; text-align:right;' class='inpnovisibles' readonly>
							</td>
							<td style='width:4%'>
								<input name='dmesesdic[]' value='".$_POST[dmesesdic][$x]."' type='text' style='width:100%; text-align:right;' class='inpnovisibles' readonly>
							</td>
							<td style='width:3%'>
								<input name='dvalordic[]' value='".number_format($_POST[dvalordic][$x],2,',','.')."' type='text' style='width:100%; text-align:center;' class='inpnovisibles' readonly>
							</td>
							<td style='width:6%'>
								<input name='dsaldo[]' value='".number_format($_POST[dsaldo][$x],2,',','.')."' type='text' style='width:100%; text-align:center;' class='inpnovisibles' readonly>
								<input name='dcc[]' type='hidden' value='".$row['cc']."'>
								<input name='dnumacti[]' type='hidden' value='".$row['codigo']."'>
							</td>
						</tr></tbody>";	
						$con+=1;
						$aux=$co;
						$co=$co2;
						$co2=$aux;		 
						$x++;
					}
				}
				echo "<script>document.getElementById('divcarga').style.display='none';</script>";
				if($result>0)
				{
					echo "<script>despliegamodalm('visible','2','Hay activos que ya estan depreciados, no se incluiran en esta depreciacion inicial.');</script>";
				}
						 	
			}
			?>
			</table>
			<?php
			//echo $_POST[oculto];
			$cuentanp=array();
			if($_POST[oculto]==2)
			{
				$srl="SELECT nit FROM configbasica";
				$rs=mysql_query($srl,$linkbd);
				$ro=mysql_fetch_row($rs);
				$tercero=substr($ro[0],0,9);
				/*$srl="SELECT max(numerotipo) FROM comprobante_cab WHERE tipo_comp='100'";
				$rs=mysql_query($srl,$linkbd);
				$ro=mysql_fetch_row($rs);*/
				$cod=$_POST[codigo];
				preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/",$_POST['fecha'],$fecha);
				$fechaG="$fecha[3]-$fecha[2]-$fecha[1]";
				$vigenciaG = $fecha[3];
				$sqlr="INSERT INTO acti_deprecia_inicial (codigo,fecha,nombre,vigencia,estado) VALUES ('".$_POST[codigo]."', '$fechaG', 'DEPRECIACION INICIAL', '".$vigenciaG."', 'S')";
				//echo $sqlr;
				mysql_query($sqlr,$linkbd);
				$sqlrt="INSERT INTO comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito, total_credito,diferencia,estado) VALUES ('$cod','22','$fechaG','DEPRECICION INICIAL ',0,0,0,0,'1') ON DUPLICATE KEY UPDATE numerotipo='$cod',tipo_comp='100'";
				mysql_query($sqlrt,$linkbd);
				$sqlrdl ="DELETE FROM comprobante_det WHERE tipo_comp='22' AND numerotipo='$cod'";
				mysql_query($sqlrdl,$linkbd);
				for($x=0;$x<count($_POST[dplaca]);$x++)
				{
					if($_POST[dvalordic][$x]>0)
					{
						$tipo=substr($_POST[dplaca][$x],0,6);
						$sqlr="SELECT * FROM acti_depreciacionactivos_det WHERE tipo='$tipo'";
						$res=mysql_query($sqlr,$linkbd);
						$row=mysql_fetch_assoc($res);
						if($row["cuenta_debito"]!='')
						{
							$sqlr3="INSERT INTO acti_deprecia_inicial_det (codigo, placa,nombre, fechact, valor, mesesdeptot, valdepmes, mesesdepdic, valdepdic,saldo, estado) VALUES ('".$_POST[codigo]."', '".$_POST[dplaca][$x]."','".$_POST[dnombre][$x]."', '".cambiar_fecha($_POST[dfecact][$x])."', '".$_POST[dvalact][$x]."','".$_POST[dmesesdept][$x]."', '".$_POST[dvalordepm][$x]."', '".$_POST[dmesesdic][$x]."', ".$_POST[dvalordic][$x].",".$_POST[dsaldo][$x].",'S')";
							mysql_query($sqlr3,$linkbd);
							$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito, estado, vigencia,tipo_comp,numerotipo,numacti) values ('22 $cod','".$_POST[cuentact]."','$tercero','".$_POST[dcc][$x]."' , '".$_POST[dplaca][$x].$_POST[dnombre][$x]."','','".$_POST[dvalordic][$x]."','0','1','$vigenciaG','22','$cod','".$_POST[dplaca][$x]."')";
							mysql_query($sqlr,$linkbd);
							$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito, estado, vigencia,tipo_comp,numerotipo,numacti) values ('22 $cod','".$row['cuenta_credito']."','$tercero','".$_POST[dcc][$x]."' , '".$_POST[dplaca][$x]."-".$_POST[dnombre][$x]."','','0','".$_POST[dvalordic][$x]."','1','$vigenciaG','22','$cod','".$_POST[dplaca][$x]."')";
							mysql_query($sqlr,$linkbd);
						}
						else
						{
							$cuentanp[]=$_POST[dplaca][$x];	
						}
						if(count($cuentanp)=='0')
						{
							echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado con Exito <img src='imagenes\confirm.png'></center></td></tr></table>";
							echo "<script>funcionmensaje();</script>";
						}
					}
					
				}
				echo "<script>document.form2.oculto.value='';</script>";
			}
			for($d=0;$d<count($cuentanp);$d++)
			{
				echo "<div class='saludo1'>No Parametrizada: $cuentanp[$d]</div>";  
			}
			?>
		</div>
		<?php
			if(count($cuentanp)!='0')
			{
				echo "<div class='saludo1'>Se almaceno con exito, pero tiene activos sin parametrizar</div>";  
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