<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
	ini_set('max_execution_time', 3600);
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: SPID - Tesoreria</title>
       	<link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
        <script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
		<script>
			$(window).load(function () {
					$('#cargando').hide();
				});
			function buscacta(e)
 			{
				if (document.form2.cuenta.value!="")
				{
 					document.form2.bc.value='1';
 					document.form2.submit();
 				}
			}
			function validar(){document.form2.submit();}
			function buscatercero(e)
			{
				if (document.form2.tercero.value!="")
				{
					document.form2.bc.value='1';
					 document.form2.submit();
 				}
 			}
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
			function eliminar(idr)
			{
				if (confirm("Esta Seguro de Eliminar El Egreso No "+idr))
  				{
  					document.form2.oculto.value=2;
  					document.form2.var1.value=idr;
					document.form2.submit();
  				}
			}
			function guardar()
			{
				var validacion01=document.getElementById('concepto').value
				if (document.form2.fecha.value!='' && validacion01.trim()!='' && document.getElementById('vigencias').value!='')
  				{despliegamodalm('visible','4','Esta Seguro de Guardar','2');}
  				else
				{
  					despliegamodalm('visible','2','Faltan datos para completar el registro');
  					document.form2.fecha.focus();
  					document.form2.fecha.select();
 				}
			}
			function pdf()
			{
				document.form2.action="pdfreporegresos.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function despliegamodal2(_valor)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else 
				{
					document.getElementById('ventana2').src="tercerosgral-ventana01.php?objeto=tercero&nobjeto=ntercero&nfoco=cc";
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
						case "1":	//document.getElementById('valfocus').value='';
									document.getElementById('vigencias').focus();
									//document.getElementById('tercero').select();
									break;
						case "2":	//document.getElementById('banco').value='';
									document.getElementById('vigencias').focus();
									//document.getElementById('banco').select();
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
					}
				}
			}
			function despliegamodal3(_valor,pos)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else {document.getElementById('ventana2').src="cont-codigosinternosexogena-ventana.php?pos="+pos;}
			}
			function funcionmensaje()
			{
				//var numdocar=document.getElementById('idcomp').value;
				//document.location.href = "teso-exogena1001.php";
				var _cons=document.getElementById('idexo').value;
				document.location.href = "teso-verexogena1001.php?idexo="+_cons;
			}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.form2.oculto.value='2';
								document.form2.submit();
								break;
					case "2":	document.getElementById('btguardar').value="";
								document.getElementById('btexcell').value="1";
								document.form2.oculto.value='2';
								document.form2.submit();
								break;
				}
			}
			function excell()
			{
				if (document.getElementById('vigencias').value!='')
				{
					document.form2.action="teso-exogena1001excel.php";
					document.form2.target="_BLANK";
					document.form2.submit(); 
					document.form2.action="";
					document.form2.target="";
				}
			}
			function actgenerar()
			{
				var validacion01=document.getElementById('concepto').value
				if (document.form2.fecha.value!='' && validacion01.trim()!='' && document.getElementById('vigencias').value!='')
				{
					document.getElementById('btgenerar').value="hidden";
					document.getElementById('btguardar').value="1";
					document.form2.submit();
				}
				else
				{
  					despliegamodalm('visible','2','Faltan datos para generar el reporte');
  					document.form2.fecha.focus();
  					document.form2.fecha.select();
 				}
			}
		</script>
		<?php 
			titlepag();
			if ($_POST[btexcell]==""){$mtrexcell="<a class='mgbt1'><img src='imagenes/excelb.png' ></a>";}
			else {$mtrexcell="<a class='mgbt' onClick='excell();'><img src='imagenes/excel.png' title='Exogena 1001'></a>";}
			if($_POST[btguardar]=="1"){$mtrguardar="<a onClick='guardar()' class='mgbt'><img src='imagenes/guarda.png' title='Guardar' style='width:24px;height:24px;'/></a>";}
			else {$mtrguardar="<a class='mgbt1'><img src='imagenes/guardad.png' style='width:24px;height:24px;'/></a>";}
		?>
	</head>
	<body>
	<div id="cargando" style=" position:absolute;left: 46%; bottom: 45%">
		<img src="imagenes/loading.gif" style=" width: 80px; height: 80px"/>
	</div>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("cont");?></tr>
			<tr>
  				<td colspan="3" class="cinta">
				<a onClick="location.href='teso-exogena1001.php'" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a><?php echo $mtrguardar;?>
				<a onClick="location.href='teso-buscaexogena1001.php'" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
				<a class="mgbt" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
				<a class="mgbt" onClick="pdf()"><img src="imagenes/print.png" title="imprimir" style="width:29px;height:25px;"></a>
				<a class="mgbt" onClick="location.href='<?php echo "archivos/".$_SESSION[usuario]."-reporteegresosexogena.csv"; ?>'" ><img src="imagenes/csv.png" title="csv" style="width:26px;height:25px;"/></a><?php echo $mtrexcell;?><a onClick="location.href='teso-formatoexogena.php'"  class="mgbt"><img src="imagenes/iratras.png" title="Retornar"></a></td>
       		</tr>	
		</table>
		<div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
 		<form name="form2" method="post" action="teso-exogena1001.php">
 			<?php
				if ($_POST[oculto]=="")
				{
					$_POST[btgenerar]="visible";
					$_POST[btexcell]="";
					$_POST[btguardar]="";
				}
				$sqlr="select max(id_exo) from exogena_cab";
			 	$resp=mysql_query($sqlr,$linkbd);
			 	$row=mysql_fetch_row($resp);
			 	$_POST[idexo]=$row[0]+1;
			 	$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
			 	$vigencia=$vigusu;
			 	$vact=$vigusu; 
				//echo "vig:".$_POST[vigencias];
 				if($_POST[bc]=='1')
			 	{
			 	 	$nresul=buscatercero($_POST[tercero]);
			  		if($nresul!=''){$_POST[ntercero]=$nresul;}
			 		else {$_POST[ntercero]=""; }
			 	}
			?>
			<table  class="inicio" align="center" >
      		<tr >
        		<td class="titulos" colspan="9">:. Formato Exogena 1001</td>
        		<td class="cerrar" style="width:7%;"><a onClick="location.href='teso-principal.php'">&nbsp;Cerrar</a></td>
      		</tr>
 			<tr>
            	<td class="saludo1" style="width:2.5cm;">No Exogena:</td>
                <td style="width:8%"><input type="text" id="idexo" name="idexo" value="<?php echo $_POST[idexo]?>" style="width:100%" readonly></td>
                <td class="saludo1"  style="width:2cm;">Fecha:</td>
                <td style="width:10%"><input type="text" name="fecha"  value="<?php echo $_POST[fecha]?>" maxlength="10"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" style="width:80%;">&nbsp;<a onClick="displayCalendarFor('fc_1198971545');" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px; cursor:pointer"></a></td>
                <td class="saludo1"  style="width:2cm;">Concepto:</td>
                <td style="width:30%"><input type="text" name="concepto" id="concepto" value="<?php echo $_POST[concepto]?>" style="width:100%"/></td>
                <td class="saludo1"  style="width:3.5cm;">Vigencia Exogena:</td>
                <td style="width:7%">
                	<select name="vigencias" id="vigencias" style="width:100%;">
      					<option value="">Sel..</option>
	  						<?php	  
     							for($x=$vact;$x>=$vact-4;$x--)
	  							{
		 							if($x==$_POST[vigencias]){echo "<option value='$x' SELECTED>$x</option>";}
									else {echo "<option value='$x'>$x</option>";}
								}
	  						?>
      					</select>     
             	</td>
				<td> &nbsp;       
         			<input type="button" name="generar" value="Generar" onClick="actgenerar()"  style="visibility:<?php echo $_POST[btgenerar];?>"/> 
                    <input type="hidden" name="oculto" id="oculto" value="1" >
                    <input type="hidden" name="btgenerar" id="btgenerar" value="<?php echo $_POST[btgenerar];?>"/>
                    <input type="hidden" name="btexcell" id="btexcell" value="<?php echo $_POST[btexcell];?>"/>
                    <input type="hidden" name="btguardar" id="btguardar" value="<?php echo $_POST[btguardar];?>"/>
              	</td>
       		</tr>                    
			<?php 
				if($_POST[bc]=='1')
			 	{
			  		$nresul=buscatercero($_POST[tercero]);
			 		if($nresul!='')
			   		{
			  			$_POST[ntercero]=$nresul;
  			  			echo"<script>document.form2.fecha.focus();document.form2.fecha.select();</script>";
			  		}
			 		else
			 		{
			  			$_POST[ntercero]="";
			 			echo"<script>alert('Tercero Incorrecta');document.form2.tercero.focus();</script>";
			  		}
			 	}
			 ?>
		</table>  
    	<div class="subpantallap"  style="height:68%;overflow-x:hidden;">
      		<?php	  
				$oculto=$_POST['oculto'];
				if($_POST[oculto])
				{
					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
					$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
					$fechaf2=$fecha[3]."-".$fecha[2]."-".$fecha[1];	
					$crit1=" ";
					$crit2=" ";
					if ($_POST[tercero]!="")
					{
						$crit3="AND tesoegresos.tercero LIKE '%$_POST[tercero]%' ";
						$crit4="AND tesoegresosnomina.tercero LIKE '%$_POST[tercero]%' ";
						$crit5="AND tesopagoterceros.tercero LIKE '%$_POST[tercero]%' ";
						$crit6="AND tesopagotercerosvigant.tercero LIKE '%$_POST[tercero]%' ";
					}
					if ($_POST[numero]!="")
					{
						$crit1="AND tesoegresos.id_egreso LIKE '%$_POST[numero]%' ";
						$crit7="AND tesoegresosnomina.id_egreso LIKE '%$_POST[numero]%' ";
						$crit8="AND tesopagoterceros.id_PAGO LIKE '%$_POST[numero]%' ";
						$crit9="AND tesopagotercerosvigant.id_PAGO LIKE '%$_POST[numero]%' ";
					}
					if ($_POST[nombre]!="")
					{
						$crit2="AND tesoegresos.concepto LIKE '%$_POST[nombre]%'  ";
						$crit10="AND tesoegresosnomina.concepto LIKE '%$_POST[nombre]%'  ";
						$crit11="AND tesopagoterceros.concepto LIKE '%$_POST[nombre]%'  ";
						$crit12="AND tesopagotercerosvigant.concepto LIKE '%$_POST[nombre]%'  ";
					}
					//sacar el consecutivo 
					//$sqlr="select *from pptosideforigen where".$crit1.$crit2." order by pptosideforigen.codigo";
					$query="SELECT conta_pago FROM tesoparametros";
					$resultado=mysql_query($query,$linkbd);
					$arreglo=mysql_fetch_row($resultado);
					$opcion=$arreglo[0];
					if($opcion=='1')
					{
						$sqlr="SELECT * FROM tesoordenpago WHERE tesoordenpago.id_orden>-1 $crit1 $crit2 $crit3 AND YEAR(tesoordenpago.fecha) = '$_POST[vigencias]' AND tesoordenpago.estado!='R' ORDER BY tesoordenpago.id_orden DESC";
					}
					else
					{
						$sqlr="SELECT * FROM tesoegresos WHERE tesoegresos.id_egreso>-1 $crit1 $crit2 $crit3 AND YEAR(tesoegresos.fecha) = '$_POST[vigencias]' AND estado='S' ORDER BY tesoegresos.id_egreso DESC";
					}
					$sqlr2="SELECT * FROM tesoegresosnomina,tesoegresosnomina_det WHERE tesoegresosnomina.id_egreso=tesoegresosnomina_det.id_egreso and tesoegresosnomina.id_egreso>-1 $crit4 $crit7 $crit10  AND YEAR(tesoegresosnomina.fecha) = '$_POST[vigencias]' and tesoegresosnomina.estado='S' and tesoegresosnomina_det.tipo NOT IN ('01','02','03', '04', '05', '06', '07', '08', '09', '10', '11', '12','13','14','15','16','17','18','19','20', 'DS') group by tesoegresosnomina.id_egreso order by tesoegresosnomina.id_egreso DESC";

					//$sqlr3="SELECT * FROM tesopagoterceros WHERE tesopagoterceros.id_PAGO>-1 $crit5 $crit8 $crit11 AND YEAR(tesopagoterceros.fecha)='$_POST[vigencias]' and estado='S' order by tesopagoterceros.id_PAGO DESC";

					$sqlr4="select *from tesopagotercerosvigant where tesopagotercerosvigant.id_PAGO>-1 $crit6 $crit9 $crit12 AND YEAR(tesopagotercerosvigant.fecha)='$_POST[vigencias]' AND and estado='S' order by tesopagotercerosvigant.id_PAGO DESC";
					//echo "<div><div>sqlr:".$sqlr."</div></div>"; //sistem@s2014
					$resp = mysql_query($sqlr,$linkbd);
					$ntr = mysql_num_rows($resp);
					$resp2 = mysql_query($sqlr2,$linkbd);
					$ntr2 = mysql_num_rows($resp2);
					//$resp3 = mysql_query($sqlr3,$linkbd);
					//$ntr3 = mysql_num_rows($resp3);
					$resp4 = mysql_query($sqlr4,$linkbd);
					$ntr4 = mysql_num_rows($resp4);
					$con=0;
					$namearch="archivos/".$_SESSION[usuario]."-reporteegresosexogena.csv";
					$namearch2="archivos/fmt1001_".$_POST[vigencias].".csv";
					$Descriptor1 = fopen($namearch,"w+"); 
					$Descriptor2 = fopen($namearch2,"w+"); 
					fputs($Descriptor1,"CONCEPTO;TIPODOC;Doc Tercero;DV;FECHA;CHEQUE;VALOR;RETENCION EN LA FUENTE;RETE IVA;VALOR PAGO;CONCEPTO;ESTADO\r\n");
					//fputs($Descriptor2,"CONCEPTO;TIPODOC;Doc Tercero;DV;FECHA;CHEQUE;VALOR;VALOR PAGO;CONCEPTO;ESTADO\r\n");
					fputs($Descriptor2,"Concepto;Tipo de documento;N�mero identificaci�n del informado;DV;Primer apellido del informado;Segundo apellido del informado;Primer nombre del informado;Otros nombres del informado;Raz�n social informado;Direcci�n;C�digo dpto;C�digo mcp;Pa�s de residencia o domicilio;Pago o abono en cuenta deducible;Pago o abono en cuenta no deducible;Iva mayor valor del costo o gasto deducible;Iva mayor valor del costo o gasto no deducible;Retenci�n en la fuente practicada en renta;Retenci�n en la fuente asumida en renta;Retenci�n en la fuente practicada IVA r�gimen com�n;Retenci�n en la fuente asumida  IVA r�gimen simplificado;Retenci�n en la fuente practicada IVA no domiciliados;Retenci�n en la fuente practicadas CREE;Retenci�n en la fuente asumidas CREE\r\n");
					echo "
					<table class='inicio' align='center' >
						<tr><td colspan='11' class='titulos'>.: Resultados Busqueda:</td></tr>
						<tr><td colspan='11' class='saludo3'>Pagos Encontrados: ".($ntr+$ntr2+$ntr3+$ntr4)."</td></tr>
						<tr>
							<td  class='titulos2'>CONCEPTO</td>
							<td  class='titulos2'>EGRESO</td>
							<td  class='titulos2'>ORDEN</td>
							<td class='titulos2'>DOC TERCERO</td>
							<td class='titulos2'>TERCERO</td>
							<td class='titulos2'>FECHA</td>
							<td class='titulos2'>VALOR</td>
							<td class='titulos2'>Retencion en la Fuente</td>
							<td class='titulos2'>Rete IVA</td>
							<td class='titulos2'>Descripcion</td>
							<td class='titulos2' width='3%'><center>Estado</td>
						</tr>";	
					//echo "nr:".$nr;
					$iter='zebra11';
					$iter2='zebra22';
					while ($row =mysql_fetch_row($resp)) 
					{
						if($opcion==1)
						{
							$ntr=buscatercero($row[6]);
							 //**busca retenciones en la fuente ***
							$sqlr="select sum(valor) from tesoordenpago_retenciones,tesoretenciones where tesoretenciones.destino='N' and iva<>1 and tesoordenpago_retenciones.id_orden=$row[0] and tesoordenpago_retenciones.id_retencion=tesoretenciones.id";
							$respret=mysql_query($sqlr,$linkbd);
							$rowret =mysql_fetch_row($respret);
							$valret=0;
							$valret+=$rowret[0];
							$sqlr="select sum(valor) from tesoordenpago_retenciones,tesoretenciones where tesoretenciones.destino='N' and iva=1 and tesoordenpago_retenciones.id_orden=$row[0] and tesoordenpago_retenciones.id_retencion=tesoretenciones.id";
							$respret=mysql_query($sqlr,$linkbd);
							$rowret =mysql_fetch_row($respret);
							$valretiva=0;
							$valretiva+=$rowret[0];
							 //***
							 echo "
							<tr class='$iter'>
								<td ><input type='text' name='conexogena[]' value='' size='4' onDblClick='despliegamodal3(\"visible\",$con)'></td>
								<td ><input type='hidden' name='egresos[]' value='$row[0]'>0</td>
								<td ><input type='hidden' name='ordenes[]' value='$row[0]'>$row[0]</td>
								<td ><input type='hidden' name='terceros[]' value='$row[6]'>$row[6]</td>
								<td ><input type='hidden' name='nterceros[]' value='$ntr'>$ntr</td>
								<td ><input type='hidden' name='fechas[]' value='$row[2]'>$row[2]</td>
								<td ><input type='hidden' name='valoresb[]' value='$row[10]'>".number_format($row[10],2)."</td>
								<td ><input type='hidden' name='valores[]' value='$valret'>".number_format($valret,2)."</td>
								<td ><input type='hidden' name='valoresiv[]' value='$valretiva'>".number_format($valretiva,2)."</td>
								<td ><input type='hidden' name='conceptos[]' value='EGRESOS $row[7]'>".strtoupper("CXP ".$row[7])."</td>
								<td ><input type='hidden' name='estados[]' value='EG'>".strtoupper($row[13])."</td>
							</tr>";
							$con+=1;
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux;
							  fputs($Descriptor1,"0;".$row[0].";".$row[6].";".$ntr.";".$row[3].";".$row[10].";".number_format($row[5],2,".","").";".$valret.";".$valretiva.";".number_format($row[7],2,".","").";".strtoupper("EGRESO ".$row[8]).";".strtoupper($row[13])."\r\n");
						}
						else
						{

							$ntr=buscatercero($row[11]);
							 //**busca retenciones en la fuente ***
							$sqlr="select sum(valor) from tesoordenpago_retenciones,tesoretenciones where tesoretenciones.destino='N' and iva<>1 and tesoordenpago_retenciones.id_orden=$row[2] and tesoordenpago_retenciones.id_retencion=tesoretenciones.id";
							$respret=mysql_query($sqlr,$linkbd);
							$rowret =mysql_fetch_row($respret);
							$valret=0;
							$valret+=$rowret[0];
							$sqlr="select sum(valor) from tesoordenpago_retenciones,tesoretenciones where tesoretenciones.destino='N' and iva=1 and tesoordenpago_retenciones.id_orden=$row[2] and tesoordenpago_retenciones.id_retencion=tesoretenciones.id";
							$respret=mysql_query($sqlr,$linkbd);
							$rowret =mysql_fetch_row($respret);
							$valretiva=0;
							$valretiva+=$rowret[0];
							 //***
							 echo "
							<tr class='$iter'>
								<td ><input type='text' name='conexogena[]' value='' size='4' onDblClick='despliegamodal3(\"visible\",$con)'></td>
								<td ><input type='hidden' name='egresos[]' value='$row[0]'>$row[0]</td>
								<td ><input type='hidden' name='ordenes[]' value='$row[2]'>$row[2]</td>
								<td ><input type='hidden' name='terceros[]' value='$row[11]'>$row[11]</td>
								<td ><input type='hidden' name='nterceros[]' value='$ntr'>$ntr</td>
								<td ><input type='hidden' name='fechas[]' value='$row[3]'>$row[3]</td>
								<td ><input type='hidden' name='valoresb[]' value='$row[5]'>".number_format($row[5],2)."</td>
								<td ><input type='hidden' name='valores[]' value='$valret'>".number_format($valret,2)."</td>
								<td ><input type='hidden' name='valoresiv[]' value='$valretiva'>".number_format($valretiva,2)."</td>
								<td ><input type='hidden' name='conceptos[]' value='EGRESOS $row[8]'>".strtoupper("EGRESOS ".$row[8])."</td>
								<td ><input type='hidden' name='estados[]' value='EG'>".strtoupper($row[13])."</td>
							</tr>";
							$con+=1;
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux;
							  fputs($Descriptor1,$row[0].";".$row[2].";".$row[11].";".$ntr.";".$row[3].";".$row[10].";".number_format($row[5],2,".","").";".$valret.";".$valretiva.";".number_format($row[7],2,".","").";".strtoupper("EGRESO ".$row[8]).";".strtoupper($row[13])."\r\n");
						}
 					}
 					while ($row2 =mysql_fetch_row($resp2)) 
 					{
						$valorExogena = '';
						$sqlrCod = "SELECT C.codigo FROM contcodigosinternos AS C, contcodigosinternos_det AS CT WHERE CT.codigo='$row2[18]' AND CT.idnum = C.idnum ";
						$respCod = mysql_query($sqlrCod,$linkbd);
						$rowCod =mysql_fetch_row($respCod);
						
						$valorExogena = $rowCod[0];

						 if($row2[18]=='01' || $row2[18]=='N')
						 {
							$ntr=buscatercero($row2[11]);
							echo "
							<tr class='$iter'>
							<td ><input type='text' name='conexogena[]' value='$valorExogena' size='4' ></td>
							<td ><input type='hidden' name='egresos[]' value='$row2[0]'>$row2[0]</td>
							<td ><input type='hidden' name='ordenes[]' value='$row2[2]'>$row2[18]</td>
							<td ><input type='hidden' name='terceros[]' value='$row2[11]'>$row2[11]</td>
							<td ><input type='hidden' name='nterceros[]' value='$ntr'>$ntr</td>
							<td ><input type='hidden' name='fechas[]' value='$row2[3]'>$row2[3]</td>
							<td ><input type='hidden' name='valoresb[]' value='$row2[5]'>".number_format(calculavalordevengado($row2[0]),2)."</td>
							<td ><input type='hidden' name='valores[]' value='$row2[6]'>".number_format($row2[6],2)."</td>
							<td ><input type='hidden' name='valoresiv[]' value='$valretiva'>".number_format($valretiva,2)."</td>
							<td ><input type='hidden' name='conceptos[]' value='EGRESO NOMINA $row2[8]'>".strtoupper("EGRESO NOMINA ".$row2[8])."</td>
							<td ><input type='hidden' name='estados[]' value='EN'>".strtoupper($row2[13])."</td>
							</tr>";
							$con+=1;
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux;
							fputs($Descriptor1,$row2[0].";".$row2[2].";".$row2[11].";".$ntr.";".$row2[3].";".$row2[10].";".number_format(calculavalordevengado($row2[0]),2,".","").";".$row2[6].";".$valretiva.";".number_format($row2[7],2,".","").";".strtoupper("EGRESO NOMINA".$row2[8]).";".strtoupper($row2[13])."\r\n");
						 }
						 else
						 {
							$ntr=buscatercero($row2[11]);
							echo "
							  <tr class='$iter'>
							 <td ><input type='text' name='conexogena[]' value='$valorExogena' size='4' ></td>
							 <td ><input type='hidden' name='egresos[]' value='$row2[0]'>$row2[0]</td>
							 <td ><input type='hidden' name='ordenes[]' value='$row2[2]'>$row2[18]</td>
							 <td ><input type='hidden' name='terceros[]' value='$row2[11]'>$row2[11]</td>
							 <td ><input type='hidden' name='nterceros[]' value='$ntr'>$ntr</td>
							 <td ><input type='hidden' name='fechas[]' value='$row2[3]'>$row2[3]</td>
							 <td ><input type='hidden' name='valoresb[]' value='$row2[5]'>".number_format($row2[5],2)."</td>
							 <td ><input type='hidden' name='valores[]' value='$row2[6]'>".number_format($row2[6],2)."</td>
							 <td ><input type='hidden' name='valoresiv[]' value='$valretiva'>".number_format($valretiva,2)."</td>
							 <td ><input type='hidden' name='conceptos[]' value='EGRESO NOMINA $row2[8]'>".strtoupper("EGRESO NOMINA ".$row2[8])."</td>
							 <td ><input type='hidden' name='estados[]' value='EN'>".strtoupper($row2[13])."</td>
							 </tr>";
						   $con+=1;
						   $aux=$iter;
						   $iter=$iter2;
						   $iter2=$aux;
						fputs($Descriptor1,$row2[0].";".$row2[2].";".$row2[11].";".$ntr.";".$row2[3].";".$row2[10].";".number_format($row2[5],2,".","").";".$row2[6].";".$valretiva.";".number_format($row2[7],2,".","").";".strtoupper("EGRESO NOMINA".$row2[8]).";".strtoupper($row2[13])."\r\n");
						 }
					}
					/*while ($row3 =mysql_fetch_row($resp3)) 
					{
	 					$ntr=buscatercero($row3[1]);
	 					echo "
						<tr class='$iter'>
							<td ><input type='text' name='conexogena[]' value='' size='4'></td>
							<td ><input type='hidden' name='egresos[]' value='$row3[0]'>$row3[0]</td>
							<td ><input type='hidden' name='ordenes[]' value='$row3[0]'>$row3[0]</td>
							<td ><input type='hidden' name='terceros[]' value='$row3[1]'>$row3[1]</td>
							<td ><input type='hidden' name='nterceros[]' value='$ntr'>$ntr</td>
							<td ><input type='hidden' name='fechas[]' value='$row3[10]'>$row3[10]</td>
							<td ><input type='hidden' name='valoresb[]' value='$row3[5]'>".number_format($row3[5],2)."</td>
							<td ><input type='hidden' name='valores[]' value='0'>".number_format(0,2)."</td>
							<td ><input type='hidden' name='valoresiv[]' value='$valretiva'>".number_format($valretiva,2)."</td>
							<td ><input type='hidden' name='conceptos[]' value='PAGO TERCEROS $row3[7]'>".strtoupper("PAGO TERCEROS".$row3[7])."</td>
							<td ><input type='hidden' name='estados[]' value='PT'>".strtoupper($row3[9])."</td>
						</tr>";
	 					$con+=1;
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
  						fputs($Descriptor1,$row3[0].";".$row3[0].";".$row3[1].";".$ntr.";".$row3[10].";".$row3[3].";".number_format($row[5],2,".","").";".$valret.";".$valretiva.";".number_format($row3[5],2,".","").";".strtoupper("PAGO TERCEROS".$row3[7]).";".strtoupper($row3[9])."\r\n");
					}*/
 					$valreteiva=0;
  					while ($row4 =mysql_fetch_row($resp4)) 
					{
	 					$ntr=buscatercero($row4[1]);
	 					echo "
						<tr class='$iter'>
							<td ><input type='text' name='conexogena[]' value='' size='4' onDblClick='despliegamodal3(\"visible\",$con)'></td>
							<td ><input type='hidden' name='egresos[]' value='$row4[0]'>$row4[0]</td>
							<td ><input type='hidden' name='ordenes[]' value='$row4[0]'>$row4[0]</td>
							<td ><input type='hidden' name='terceros[]' value='$row4[1]'>$row4[1]</td>
							<td ><input type='hidden' name='nterceros[]' value='$ntr'>$ntr</td>
							<td ><input type='hidden' name='fechas[]' value='$row4[10]'>$row4[10]</td>
							<td ><input type='hidden' name='valoresb[]' value='$row4[5]'>".number_format($row4[5],2)."</td>
							<td ><input type='hidden' name='valores[]' value='0'>".number_format(0,2)."</td>
							<td ><input type='hidden' name='valoresiv[]' value='$valretiva'>".number_format($valretiva,2)."</td>
							<td ><input type='hidden' name='conceptos[]' value='PAGO VIG ANTERIOR $row4[7]'>".strtoupper("PAGO VIG ANTERIOR".$row4[7])."</td>
							<td ><input type='hidden' name='estados[]' value='PV'>".strtoupper($row4[9])."</td>
						</tr>";	
	 					$con+=1;
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
   						fputs($Descriptor1,$row4[0].";".$row4[0].";".$row4[1].";".$ntr.";".$row4[10].";".$row4[3].";".number_format($row4[5],2,".","").";".$valret.";".$valretiva.";".number_format($row4[5],2,".","").";".strtoupper("PAGO VIG ANTERIOR".$row4[7]).";".strtoupper($row4[9])."\r\n");
 					}
 					fclose($Descriptor1);
 					echo"</table>";
				}
				if($_POST[oculto]==2 || $_POST[oculto]==3)
				{
					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
					$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
					$idtabla=selconsecutivo('exogena_cab','id_exo');
					$sqlr="insert into exogena_cab (id_exo,fecha,vigencia,descripcion,estado) values ('$idtabla','$fechaf','$_POST[vigencias]', '$_POST[concepto]','S')";
					if(mysql_query($sqlr,$linkbd))
					{
						//$id=mysql_insert_id($linkbd);
						$id=$idtabla;
	 					echo"<script>despliegamodalm('visible','1','Se ha almacenado La Exogena con Exito');</script>";
						$conta=count($_POST[conexogena]);
	 					for($x=0;$x<$conta;$x++)
	 					{
	  						$sqlr="insert into exogena_det (id_exo, concepto, id_egre, id_cxp, fecha, tercero, detalle, valor, retefte,reteiva, tipoegre) values ($id,'".$_POST[conexogena][$x]."','".$_POST[egresos][$x]."','".$_POST[ordenes][$x]."','".$_POST[fechas][$x]."','".$_POST[terceros][$x]."','".$_POST[conceptos][$x]."','".$_POST[valoresb][$x]."','".$_POST[valores][$x]."','".$_POST[valoresiv][$x]."','".$_POST[estados][$x]."')";
	 						mysql_query($sqlr,$linkbd);
							//  echo "<br>".$sqlr;
	 					}
	  					if($_POST[oculto]==3)
	   					{
	   						// $sqlr="select distinct * from exogena_det where id_exo=$id group by concepto,tercero order by concepto,tercero";
	    					$sqlr="select distinct concepto,tercero,sum(valor),sum(retefte),sum(reteiva) from exogena_det where id_exo=$_POST[idexo] group by concepto,tercero order by concepto,tercero";
							$resp=mysql_query($sqlr,$linkbd);
							while($row=mysql_fetch_row($resp))
							{
								$sqlrt="select *from terceros where cedulanit=$row[1]";
								$rest=mysql_query($sqlrt,$linkbd);
								$rowt=mysql_fetch_row($rest);
								fputs($Descriptor2,$row[0].";".$rowt[11].";".$rowt[12].";".$rowt[13].";".$rowt[3].";".$rowt[4].";".$rowt[1].";".$rowt[2].";".$rowt[5].";".$rowt[6].";".$rowt[14].";".$rowt[15].";169;0;".$row[2].";0;0;".$row[3].";0;".$row[4].";0;0;0;0\r\n");
//fputs($Descriptor2,$row[1].";".$rowt[11].";".$rowt[12].";".$rowt[13].";".$rowt[3].";".$rowt[4].";".$rowt[1].";".$rowt[2].";".$rowt[5]."; ".$rowt[6].";".$rowt[14]."; ".$rowt[15].";169;0;".$row[7].";0;0;".$row[8].";0;".$row[9].";0;0;0;0\r\n");
								//***Concepto	Tipo de documento	N�mero identificaci�n del informado	DV	Primer apellido del informado	Segundo apellido del informado	Primer nombre del informado	Otros nombres del informado	Raz�n social informado	Direcci�n	C�digo dpto.	C�digo mcp	Pa�s de residencia o domicilio	Pago o abono en cuenta deducible	 Pago o abono en cuenta no deducible 	 Iva mayor valor del costo o gasto deducible 	 Iva mayor valor del costo o gasto no deducible 	 Retenci�n en la fuente practicada en renta 	 Retenci�n en la fuente asumida en renta 	 Retenci�n en la fuente practicada IVA r�gimen com�n 	 Retenci�n en la fuente asumida  IVA r�gimen simplificado 	 Retenci�n en la fuente practicada IVA no domiciliados 	" Retenci�n en la fuente practicadas CREE "	" Retenci�n en la fuente asumidas CREE "
							}
	   					}		 
					}
					else {echo"<script>despliegamodalm('visible','2','Ya Se ha almacenado un documento con ese consecutivo');</script>";}
				}
			?>
			<div id="bgventanamodal2">
                <div id="ventanamodal2">
                    <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                    </IFRAME>
                </div>
       	 	</div>	
           </div>
		</form>
	</body>
</html>