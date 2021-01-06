<!--V 1.0 24/02/2015-->
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
		<title>:: Spid - Contabilidad</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
        <script type="text/javascript" src="css/cssrefresh.js"></script>
        <script type="text/javascript" src="jquery-1.11.0.min.js"></script>
		<script>
			function pdf()
			{
				document.form2.action="pdfauxiliarcuentacon.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function buscatercero(e){if (document.form2.tercero.value!=""){document.form2.bt.value='1';document.form2.submit();}}
			function excell()
			{
				document.form2.action="cont-auxiliartercerocuentaexcel.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function buscacta(e){if (document.form2.cuenta.value!=""){document.form2.bc.value='1';document.form2.submit();}}
			function buscacta2(e){if (document.form2.cuenta2.value!=""){document.form2.bc2.value='1';document.form2.submit();}}
			function despliegamodal2(_valor,_nomve)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else 
				{
					switch(_nomve)
					{
						case "1":	document.getElementById('ventana2').src="terceros-ventana1.php";break;
						case "2":	document.getElementById('ventana2').src="cuentasgral-ventana02.php?vigencia=<?php echo $_SESSION[vigencia]?>&objeto=cuenta&nobjeto=ncuenta";break;
						case "3":	document.getElementById('ventana2').src="cuentasgral-ventana02.php?vigencia=<?php echo $_SESSION[vigencia]?>&objeto=cuenta2&nobjeto=ncuenta2";break;
					}
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
						case "1":	document.getElementById('valfocus').value='0';
									document.getElementById('ntercero').value="";
									document.getElementById('tercero').focus();
									document.getElementById('tercero').select();
									break;
						case "2":	document.getElementById('valfocus').value='0';
									document.getElementById('ncuenta').value="";
									document.getElementById('cuenta').focus();
									document.getElementById('cuenta').select();
									break;
						case "3":	document.getElementById('valfocus').value='0';
									document.getElementById('ncuenta2').value="";
									document.getElementById('cuenta2').focus();
									document.getElementById('cuenta2').select();
									break;
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
					}
				}
			}
			function generarbal()
			{
				var validacion01=document.getElementById('fc_1198971545').value;
				var validacion02=document.getElementById('fc_1198971546').value;
				if ((validacion01.trim()!='')&&(validacion02.trim()!=''))
				{document.getElementById('oculto').value='3';document.form2.submit()}
				else {despliegamodalm('visible','2',"Falta informaci�n para poder Generar Balance")}
			}
			function generarbal1()
			{
				var validacion01=document.getElementById('fc_1198971545').value;
				var validacion02=document.getElementById('fc_1198971546').value;
				if ((validacion01.trim()!='')&&(validacion02.trim()!=''))
				{document.getElementById('oculto').value='3';document.form2.submit()}
			}
		</script>
		<?php titlepag();?>
	</head>
	<body>
	<?php 
		if(isset($_GET['cuenta']) && isset($_GET['tercero'])){
			if($_GET['cuenta']!='' && $_GET['tercero']!=''){
				$_POST[tercero]=$_GET['tercero'];
				$_POST[cuenta]=$_GET['cuenta'];
				$_POST[cuenta2]=$_GET['cuenta'];
				$_POST[fecha]=$_GET['fini'];
				$_POST[fecha2]=$_GET['ffin'];
				$_POST[bc]='1';
				$_POST[bt]='1';
				$_POST[bc2]='1';
				$_POST[oculto]='3';
			}
		}
	?>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
    		<tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
    		<tr><?php menu_desplegable("cont");?></tr>
   			<tr class="cinta">
  				<td colspan="3" class="cinta">
					<a href="cont-auxiliartercerocuenta.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a>
					<a class="mgbt"><img src="imagenes/guardad.png"/></a>
					<a href="#" onClick="generarbal();" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
					<a href="#" onClick="excell()" class="mgbt"><img src="imagenes/excel.png" title="Excel"/></a>
					<a href="<?php echo "archivos/".$_SESSION[usuario]."tercerocuenta$_POST[nivel].csv"; ?>" target="_blank" class="mgbt"><img src="imagenes/csv.png"  title="csv"></a>
					<a href="cont-auxiliarescontabilidad.php" class="mgbt"><img src="imagenes/iratras.png" title="Retornar"></a>
				</td>
          	</tr>
   		</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
  		<form name="form2" method="post" action="cont-auxiliartercerocuenta.php">
        	<input type="hidden" name="valfocus" id="valfocus" value="0"/>
 			<?php
 				$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
 			?>
    		<table  align="center" class="inicio" >
      			<tr>
        			<td class="titulos" colspan="10" style='width:93%'>.: Auxilar por Tercero x Cuenta</td>
        			<td class="cerrar" style='width:7%'><a href="cont-principal.php">&nbsp;Cerrar</a></td>
     			</tr>
      			<tr>
        			<td style='width:10%'class="saludo1">Tercero:</td>
        			<td style='width:11%' ><input type="text" id="tercero" name="tercero" style='width:70%'onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="buscatercero(event)" value="<?php echo $_POST[tercero]?>" onClick="document.getElementById('tercero').focus();document.getElementById('tercero').select();">&nbsp;<a href="#" onClick="despliegamodal2('visible','1');"><img src="imagenes/find02.png" style="width:20px"></a></td>
        			<td style='width:25%' colspan="2"><input style='text-transform:uppercase;width:98%' name="ntercero" type="text" id="ntercero" value="<?php echo $_POST[ntercero]?>" readonly></td>       
          			<td class="saludo1" style='width:10%'>Centro Costo:</td>
	  	  			<td colspan="3">
            			<select name="cc" id="cc" onKeyUp="return tabular(event,this)">
            				<option value="" >Seleccione...</option>
							<?php
								$sqlr="select *from centrocosto where estado='S'";
								$res=mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($res)) 
								{
									if($row[0]==$_POST[cc]){echo "<option value=$row[0] SELECTED>$row[0] - $row[1]</option>";}
									else {echo "<option value=$row[0]>$row[0] - $row[1]</option>";}
								}	 	
           					?>
   						</select>
            		</td>      
          		</tr>
          		<tr>
       	  			<td class="saludo1">Cuenta inicial:</td>
         		 	<td ><input type="text" id="cuenta" name="cuenta" style='width:70%'  onKeyPress="javascript:return solonumeros(event)" 
		  onKeyUp="return tabular(event,this)" onBlur="buscacta(event)" value="<?php echo $_POST[cuenta]?>" onClick="document.getElementById('cuenta').focus();document.getElementById('cuenta').select();">&nbsp;<a href="#" onClick="despliegamodal2('visible','2');"><img src="imagenes/find02.png" style="width:20px"></a></td>
          			<td colspan="2"><input id="ncuenta" name="ncuenta" type="text" value="<?php echo $_POST[ncuenta]?>" style='width:98%;text-transform:uppercase' readonly></td> 
          			<td class="saludo1">Cuenta final:</td>
          			<td><input type="text" id="cuenta2" name="cuenta2" style='width:80%' onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="buscacta2(event)" value="<?php echo $_POST[cuenta2]?>" onClick="document.getElementById('cuenta2').focus();document.getElementById('cuenta2').select();">&nbsp;<a href="#" onClick="despliegamodal2('visible','3');"><img src="imagenes/find02.png" style="width:20px"></a></td>
          			<td style="width:25%;"><input id="ncuenta2" name="ncuenta2" type="text" value="<?php echo $_POST[ncuenta2]?>" style='width:98%;text-transform:uppercase'  readonly></td> 
              	</tr> 
         		<tr>   
        			<td  class="saludo1" >Fecha Inicial:</td>
        			<td style="width:10%"><input name="fecha" type="text" id="fc_1198971545" title="YYYY-MM-DD"  value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this)" onKeyDown="mascara(this,'/',patron,true)" style="width:70%" maxlength="10">&nbsp;<a href="#" onClick="displayCalendarFor('fc_1198971545');" title="Calendario"><img src="imagenes/calendario04.png" align="absmiddle" style="width:20px;"></a></td>
        			<td style="width:10%" class="saludo1">Fecha Final: </td>
        			<td style="width:10%"><input name="fecha2" type="text" id="fc_1198971546" title="YYYY-MM-DD"  value="<?php echo $_POST[fecha2]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)" style="width:70%" maxlength="10">&nbsp;<a href="#" onClick="displayCalendarFor('fc_1198971546');" title="Calendario"><img src="imagenes/calendario04.png" align="absmiddle" style="width:20px;"></a></td><td><input type="button" name="generar" value="Generar" onClick="generarbal();"></td>
             	</tr>                 
    		</table>
            <input type="hidden" name="bt" id="bt" value="0">
            <input type="hidden" name="bc" id="bc" value="0">
            <input type="hidden" name="bc2" id="bc2" value="0">
            <input type="hidden" name="oculto" id="oculto" value="3">
    		<?php 
			if($_POST[bc]=='1')
			 	{ 
			  		$nresul=buscacuenta($_POST[cuenta]);
			  		if($nresul!='')
			   		{
  			  			echo "<script>document.getElementById('ncuenta').value='$nresul';document.getElementById('cuenta2').focus(); document.getElementById('cuenta2').select();</script>";
			  		}
			 		else
			 		{
			  			echo "<script>document.getElementById('valfocus').value='2';despliegamodalm('visible','2','Cuenta Incorrecta');</script>";
			  		}
			 	}
			 	if($_POST[bc2]=='1')
			 	{
			  		$nresul=buscacuenta($_POST[cuenta2]);
					
			  		if($nresul!='')
			   		{
			  			echo "<script>document.getElementById('ncuenta2').value='$nresul';</script>";
			  		}
			 		else
			 		{
			  			$_POST[ncuenta2]="";
			  			echo "<script>document.getElementById('valfocus').value='3';despliegamodalm('visible','2','Cuenta Incorrecta');</script>";
			  		}
			 	}
				if($_POST[bt]=='1')
				{
			  		$nresul=buscatercero($_POST[tercero]);
					if($nresul!='')
			   		{
			  			echo "<script>document.getElementById('ntercero').value='$nresul'; document.getElementById('tercero').select();generarbal1();</script>";
			  		}
					else
			 		{
			  			echo "<script>document.getElementById('valfocus').value='1';despliegamodalm('visible','2','Tercero Incorrecto');</script>";
			  		}
			 	}
			 ?>
			<div class="subpantallac5" style="height:60%; width:99.6%; overflow-x:hidden;">
				<?php
                    //**** para sacar la consulta del balance se necesitan estos datos ********
                    //**** nivel, mes inicial, mes final, cuenta inicial, cuenta final, cc inicial, cc final  
                    $oculto=$_POST['oculto'];
                    if($_POST[oculto]=="3")
                    {
                        $sumad=0;
                        $sumac=0;	
                        ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
                        $fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
                        $fechafa2=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
                        ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
                        $fechaf2=$fecha[3]."-".$fecha[2]."-".$fecha[1];	
                        $fechafa=$vigusu."-01-01";
                        $fechafa2=date('Y-m-d',$fechafa2-((24*60*60)));
                        $inicial=0;
                        $saldant=0;
                        $compinicial=0;
                        $sqlr="select distinct comprobante_det.cuenta,(sum(comprobante_det.valdebito)-sum(comprobante_det.valcredito)) as saldof from comprobante_cab,comprobante_det where comprobante_det.tercero='$_POST[tercero]' and comprobante_det.cuenta between '$_POST[cuenta]' and '$_POST[cuenta2]' and  comprobante_cab.fecha between '$fechafa' and '$fechafa2' and comprobante_det.tipo_comp=comprobante_cab.tipo_comp and  comprobante_det.numerotipo=comprobante_cab.numerotipo  and comprobante_cab.estado='1' and comprobante_cab.tipo_comp<>'7'  AND comprobante_det.centrocosto like '%$_POST[cc]%' group by comprobante_det.cuenta order by comprobante_cab.tipo_comp, comprobante_cab.numerotipo,comprobante_det.id_det";
                        $res=mysql_query($sqlr,$linkbd);
                        $row =mysql_fetch_row($res);
                        $inicial=$row[1];
                        $sqlr="select distinct comprobante_det.cuenta,(sum(comprobante_det.valdebito)-sum(comprobante_det.valcredito)) as saldof from comprobante_cab,comprobante_det where comprobante_det.tercero='$_POST[tercero]' and comprobante_det.cuenta between '$_POST[cuenta]' and '$_POST[cuenta2]' and comprobante_det.tipo_comp=comprobante_cab.tipo_comp and  comprobante_det.numerotipo=comprobante_cab.numerotipo  and comprobante_cab.estado='1' and comprobante_cab.tipo_comp='7'   and YEAR(comprobante_cab.fecha)= '".substr($_POST[fecha],0,4)."' AND comprobante_det.centrocosto like '%$_POST[cc]%'  group by comprobante_det.cuenta order by comprobante_cab.tipo_comp, comprobante_cab.numerotipo,comprobante_det.id_det ";
                        $res=mysql_query($sqlr,$linkbd);
                        $row =mysql_fetch_row($res);
                        $compinicial=$row[1]+$inicial;
                        $saldant=$compinicial;
                        echo "<table class='inicio' ><tr><td colspan='9' class='titulos'>Auxiliar por Cuenta</td></tr>";
                        $nc=buscatercero($_POST[tercero]);
                        echo "<tr><td class='titulos2'>Tercero:</td><td class='titulos2' >Nombre Tercero</td></tr><tr><td class='saludo3'>$_POST[tercero]</td><td class='saludo3' style='text-transform:uppercase'>$nc</td></tr></table>";
                        echo "<table class='inicio' ><tr><td colspan='12' class='titulos'>Auxiliar por Tercero<input type='hidden' name='saldoinicial' value='$compinicial'></td></tr>";
                        echo "
						<tr>
							<td class='titulos2'>Fecha</td>
							<td class='titulos2'>Tipo Comp</td>
							<td class='titulos2'>No Comp</td>
							<td class='titulos2'>CC</td>
							<td class='titulos2'>Cuenta</td>
							<td class='titulos2'>Nom Cuenta</td>
							<td class='titulos2'>Tercero</td>
							<td class='titulos2'>Detalle</td>
							<td class='titulos2'>Saldo Ant.</td>
							<td class='titulos2'>Debito</td>
							<td class='titulos2'>Credito</td>
							<td class='titulos2'>Nuevo Saldo</td>
						</tr>";
						$namearch="archivos/".$_SESSION[usuario]."tercerocuenta$_POST[nivel].csv";
						$Descriptor1 = fopen($namearch,"w+"); 
						$lista = array ('FECHA','TIPO COMP','No COMP','CC','CUENTA','NOM CUENTA','TERCERO','DETALLE','SALDO ANT','DEBITO','CREDITO','SALDO');
						fputcsv($Descriptor1, $lista,";");
                        $sqlr="SELECT distinct * FROM comprobante_cab, comprobante_det WHERE comprobante_det.tercero LIKE '%$_POST[tercero]%' and  comprobante_cab.fecha between 	'".$_POST[fecha]."' and '".$_POST[fecha2]."' and comprobante_det.tipo_comp=comprobante_cab.tipo_comp and  comprobante_det.numerotipo=comprobante_cab.numerotipo and comprobante_det.cuenta between '$_POST[cuenta]' and '$_POST[cuenta2]'  and comprobante_cab.estado='1' and comprobante_cab.tipo_comp<>'7' AND comprobante_det.centrocosto like '%$_POST[cc]%' GROUP BY comprobante_det.id_det order by comprobante_cab.fecha, comprobante_cab.tipo_comp, comprobante_cab.numerotipo,comprobante_det.id_det";
                        $res=mysql_query($sqlr,$linkbd);
                        while($row=mysql_fetch_row($res))
                        {
                            $sqlrup="update comprobante_det set centrocosto='04' where tercero='$_POST[tercero]' and tipo_comp<>1";
                            $sqlr="select *from tipo_comprobante where codigo=$row[2]";
                            $res2=mysql_query($sqlr);
                            $row2=mysql_fetch_row($res2);
                            $nt=buscatercero($row[13]);
                            $nc=buscacuenta($row[12]);
                            $ns=$saldant+$row[17]-$row[18];
                            echo "
							<tr>
								<td class='saludo3'><input type='hidden' name='fechas[]' value='$row[3]'>$row[3]</td>
								<td class='saludo3'><input type='hidden' name='tipocomps[]' value='$row2[1]'>$row2[1]</td>
								<td class='saludo3'><input type='hidden' name='ncomps[]' value='$row[1]'>$row[1]</td>
								<td class='saludo3'><input type='hidden' name='ccs[]' value='$row[14]'>$row[14]</td>
								<td class='saludo3'><input type='hidden' name='cuentas[]' value='$row[12]'>$row[12]</td>
								<td class='saludo3'><input type='hidden' name='ncuentas[]' value='$nc'>$nc</td>
								<td class='saludo3'><input type='hidden' name='terceros[]' value='$row[13]'><input type='hidden' name='nterceros[]' value='$nt'>$nt</td>
								<td class='saludo3'><input type='hidden' name='detalles[]' value='$row[15]'>$row[15]</td>
								<td class='saludo3'><input type='hidden' name='saldanteriores[]' value='$saldant'>".number_format($saldant,2)."</td>
								<td class='saludo3'><input type='hidden' name='debitos[]' value='$row[17]'>".number_format($row[17],2)."</td>
								<td class='saludo3'><input type='hidden' name='creditos[]' value='$row[18]'>".number_format($row[18],2)."</td>
								<td class='saludo3'><input type='hidden' name='nuevosaldos[]' value='$ns'>".number_format($ns,2)."</td>
							</tr>";
                            $sumad+=$row[17];
                            $sumac+=$row[18];
                            $saldant=$ns;
							unset($lista);
							$lista = array ($row[3],$row2[1],$row[1],$row[14],$row[12],$nc,$nt,$row[15],number_format($saldant,2,",",""),number_format($row[17],2,",",""),number_format($row[18],2,",",""),number_format($ns,2,",",""));
							fputcsv($Descriptor1, $lista,";");
                        }
						fclose($Descriptor1);
                        $ns=$compinicial+$sumad-$sumac;
                        echo "<tr><td colspan='7'></td><td>Totales:</td><td class='saludo1'><input type='hidden' name='totiniciales' value='$compinicial'>$".number_format($compinicial,2)."</td><td class='saludo1'><input type='hidden' name='sumadebitos' value='$sumad'>$".number_format($sumad,2)."</td><td class='saludo1'><input type='hidden' name='sumacreditos' value='$sumac'>$".number_format($sumac,2)."</td><td class='saludo1'><input type='hidden' name='totnuevosaldos' value='$ns'>$".number_format($ns,2)."</td></tr>";
                        echo "</table>";
                    }
                ?> 
			</div>
            <div id="bgventanamodal2">
                <div id="ventanamodal2">
                    <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                    </IFRAME>
                </div>
       	 	</div>
		</form>  
		<script>
			jQuery(function($){
				var cuenta="<?php echo $_GET[cuenta]; ?>";
				if(cuenta!='' && cuenta!=null){
					$('input[name=generar]').click();
				}
				

			});
		</script> 
	</body>
</html>