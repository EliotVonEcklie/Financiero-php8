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
		<title>:: IDEAL</title>
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
				document.location.href = "teso-verexogena1009.php?idexo="+_cons;
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
					document.form2.action="teso-exogena1009excel.php";
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
				<a onClick="location.href='teso-exogena1009.php'" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a><?php echo $mtrguardar;?>
				<a onClick="location.href='teso-buscaexogena1009.php'" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
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
 		<form name="form2" method="post" action="teso-exogena1009.php">
 			<?php
				if ($_POST[oculto]=="")
				{
					$_POST[btgenerar]="visible";
					$_POST[btexcell]="";
					$_POST[btguardar]="";
				}
				$sqlr="select max(id_exo) from exogena_cab_1009";
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
        		<td class="titulos" colspan="9">:. Formato Exogena 1009</td>
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
					}
					if ($_POST[numero]!="")
					{
						$crit1="AND tesoegresos.id_egreso LIKE '%$_POST[numero]%' ";
					}
					if ($_POST[nombre]!="")
					{
						$crit2="AND tesoegresos.concepto LIKE '%$_POST[nombre]%'  ";
					}
					//sacar el consecutivo 
					//$sqlr="select *from pptosideforigen where".$crit1.$crit2." order by pptosideforigen.codigo";
					
					$sqlr="SELECT * FROM tesoordenpago WHERE tesoordenpago.id_orden>-1 $crit1 $crit2 $crit3 AND YEAR(tesoordenpago.fecha) = '$_POST[vigencias]' AND tesoordenpago.estado!='R' ORDER BY tesoordenpago.id_orden DESC";
					
					$resp = mysql_query($sqlr,$linkbd);
					$ntr = mysql_num_rows($resp);
					
					
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
						<tr><td colspan='11' class='saludo3'>Pagos Encontrados: ".($ntr)."</td></tr>
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
                        $ntr=buscatercero($row[6]);
                            //**busca retenciones en la fuente ***
                        $sqlr="select id_egreso from tesoegresos where tesoegresos.id_orden='$row[0]' and YEAR(tesoegresos.fecha) = '$_POST[vigencias]'";
                        $respret=mysql_query($sqlr,$linkbd);
                        $rowret =mysql_fetch_row($respret);
                        $valretiva=0;
                        if($rowret[0] == '')
                        {
                            echo "
                            <tr class='$iter'>
                                <td ><input type='text' name='conexogena[]' value='' size='4' onDblClick='despliegamodal3(\"visible\",$con)'></td>
                                <td ><input type='hidden' name='egresos[]' value='$row[0]'>0</td>
                                <td ><input type='hidden' name='ordenes[]' value='$row[0]'>$row[0]</td>
                                <td ><input type='hidden' name='terceros[]' value='$row[6]'>$row[6]</td>
                                <td ><input type='hidden' name='nterceros[]' value='$ntr'>$ntr</td>
                                <td ><input type='hidden' name='fechas[]' value='$row[2]'>$row[2]</td>
                                <td ><input type='hidden' name='valoresb[]' value='$row[10]'>".number_format($row[10],2)."</td>
                                <td ><input type='hidden' name='valores[]' value='0'>".number_format(0,2)."</td>
                                <td ><input type='hidden' name='valoresiv[]' value='0'>".number_format(0,2)."</td>
                                <td ><input type='hidden' name='conceptos[]' value='CXP $row[7]'>".strtoupper("CXP ".$row[7])."</td>
                                <td ><input type='hidden' name='estados[]' value='EG'>".strtoupper($row[13])."</td>
                            </tr>";
                            $con+=1;
                            $aux=$iter;
                            $iter=$iter2;
                            $iter2=$aux;
                            fputs($Descriptor1,"0;".$row[0].";".$row[6].";".$ntr.";".$row[3].";".$row[10].";".number_format($row[5],2,".","").";".$valret.";".$valretiva.";".number_format($row[7],2,".","").";".strtoupper("CXP ".$row[8]).";".strtoupper($row[13])."\r\n");
                        }
                            
						
 					}
 					fclose($Descriptor1);
 					echo"</table>";
				}
				if($_POST[oculto]==2 || $_POST[oculto]==3)
				{
					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
					$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
					$idtabla=selconsecutivo('exogena_cab_1009','id_exo');
					$sqlr="insert into exogena_cab_1009 (id_exo,fecha,vigencia,descripcion,estado) values ('$idtabla','$fechaf','$_POST[vigencias]', '$_POST[concepto]','S')";
					if(mysql_query($sqlr,$linkbd))
					{
						//$id=mysql_insert_id($linkbd);
						$id=$idtabla;
	 					echo"<script>despliegamodalm('visible','1','Se ha almacenado La Exogena con Exito');</script>";
						$conta=count($_POST[conexogena]);
	 					for($x=0;$x<$conta;$x++)
	 					{
	  						$sqlr="insert into exogena_det_1009 (id_exo, concepto, id_egre, id_cxp, fecha, tercero, detalle, valor, retefte,reteiva, tipoegre) values ($id,'".$_POST[conexogena][$x]."','".$_POST[egresos][$x]."','".$_POST[ordenes][$x]."','".$_POST[fechas][$x]."','".$_POST[terceros][$x]."','".$_POST[conceptos][$x]."','".$_POST[valoresb][$x]."','".$_POST[valores][$x]."','".$_POST[valoresiv][$x]."','".$_POST[estados][$x]."')";
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