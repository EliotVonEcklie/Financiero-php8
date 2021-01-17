<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6 - otro
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
		<script>
			//************* ver reporte ************
			//***************************************
			function verep(idfac){document.form1.oculto.value=idfac;document.form1.submit();}
			//************* genera reporte ************
			//***************************************
			function genrep(idfac){document.form2.oculto.value=idfac;document.form2.submit();}
			function pdf()
			{
				document.form2.action="pdfauxiliarcuentacon.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}	
			function buscacta(e){if (document.form2.cuenta.value!=""){document.form2.bc.value='1';document.form2.submit();}}
            function buscacta2(e){if (document.form2.cuenta2.value!=""){document.form2.bc2.value='1';document.form2.submit(); }}
			function excell()
			{
				document.form2.action="cont-auxiliarcuentaexcel.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function auxiliarcuentatercero()
			{
				var cell = document.form2.cuenta.value;
				var fech=document.form2.fecha.value;
				var fech1=document.form2.fecha2.value;
				window.open("cont-auxiliarcuentatercero.php?cod="+cell+"&fec="+fech+"&fec1="+fech1);
			}
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
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
    		<tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
    		<tr><?php menu_desplegable("cont");?></tr>
   			<tr class="cinta">
  				<td colspan="3" class="cinta">
					<a href="cont-auxiliarcuentas.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
					<a href="#" onClick="document.form2.submit();" class="mgbt"><img src="imagenes/guarda.png" title="Guardar"/></a>
					<a href="#" onClick="document.form2.submit()"class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
					<a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png" title="Imprimir"></a>
					<a href="#" onClick="excell()" class="mgbt"><img src="imagenes/excel.png" title="Excel"></a>
					<a href="cont-auxiliarescontabilidad.php" class="mgbt"><img src="imagenes/iratras.png" title="Retornar"></a>
				</td>
					
         	</tr>
		</table>
 		<form name="form2" method="post" action="cont-auxiliarcuentas.php">
  			<?php
  				$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
				if(isset($_GET['cod'])){
				if(!empty($_GET['cod'])){
					$_POST[cuenta]=$_GET['cod'];
					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_GET['fec'],$fecha);
					$_POST[fecha]=$fecha[3]."-".$fecha[2]."-".$fecha[1];
					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_GET['fec1'],$fecha1);
					$_POST[fecha2]=$fecha1[3]."-".$fecha1[2]."-".$fecha1[1];
					$_POST[bc]='1';
				}
			}
 				if($_POST[consolidado]==''){$chkcomp=' ';}
 				else {$chkcomp=' checked ';}
				if($_POST[cierre]==''){$chkcierre=' ';}
 				else {$chkcierre=' checked ';}
 				if($_POST[bc]=='1')
			 	{
			 		$nresul=buscacuenta($_POST[cuenta]);
			  		if($nresul!=''){$_POST[ncuenta]=$nresul;}
			 		else {$_POST[ncuenta]="";}
				 }
				 if($_POST[resumido]==1)
	 			{
					$chk=" checked";	 
	 			}
				else
				{
					$chk=" ";	 
				}
			?>
    		<table  align="center" class="inicio" >
      			<tr>
        			<td class="titulos" colspan="12">.: Auxilar por Cuenta</td>
                    <td class="cerrar" style="width:7%;"><a href="cont-principal.php">&nbsp;Cerrar</a></td>
      			</tr>
     			<tr>
                    <td class="saludo1" style="width:10%;">Cuenta inicial:</td>

          			<td style="width:11%;">
                        <input type="text" id="cuenta" name="cuenta" style="width:80%;" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="buscacta(event)" value="<?php echo $_POST[cuenta]?>">&nbsp;<a href="#" onClick="despliegamodal2('visible','2');"><img src="imagenes/find02.png" style='width:20px'></a>
                    </td>
          			<td style="width:20%;">
                        <input id="ncuenta" name="ncuenta" type="text" value="<?php echo $_POST[ncuenta]?>" style='width:98%;text-transform:uppercase' readonly> 
                    </td> 

                    <td class="saludo1" style="width:10%;">Cuenta final:</td>
					<td style="width:11%;"><input type="text" id="cuenta2" name="cuenta2" style="width:80%;" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="buscacta2(event)" value="<?php echo $_POST[cuenta2]?>">&nbsp;<a href="#" onClick="despliegamodal2('visible','3');"><img src="imagenes/find02.png" style='width:20px'></a></td>
          			<td colspan="2"><input id="ncuenta2"  name="ncuenta2" type="text" value="<?php echo $_POST[ncuenta2]?>" style='width:98%;text-transform:uppercase' readonly></td> 
                </tr>
                <tr>
        			<td  class="saludo1" style="width:10%;">Fecha Inicial:</td>
					<td style="width:10%;"><input name="fecha" type="text" id="fc_1198971545" title="YYYY-MM-DD" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return 	tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)" style="width:80%;">         <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/calendario04.png"style="width:20px" align="absmiddle" border="0"></a>        
					</td>

                    <td></td>

					<td class="saludo1" style="width:2cm;">Fecha Final: </td>
					<td style="width:10%;"><input name="fecha2" type="text" id="fc_1198971546" title="YYYY-MM-DD"  value="<?php echo $_POST[fecha2]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)" style="width:80%;">         <a href="#" onClick="displayCalendarFor('fc_1198971546');"><img src="imagenes/calendario04.png" align="absmiddle" border="0" style="width:20px"></a> 
					</td>  
					<td style="width:5%"><input type="hidden" style="width:20%;"></td>
              	</tr>
                <tr>       
                	<td class="saludo1" style="width:2.3cm;">Centro Costo:</td>
	  				<td >
						<select name="cc" onKeyUp="return tabular(event,this)" style="width:96%;">
   							<option value="" >Seleccione...</option>
							<?php
								$sqlr="SELECT * FROM centrocosto WHERE estado='S'";
								$res=mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($res)) 
				    			{
					 				if($row[0]==$_POST[cc]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
									else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
								}	 	
							?>
   						</select>
                	</td>     
                    <td class="saludo1" style="width:2.5cm;"> Consolidado&nbsp;
       				<input type="checkbox" class="defaultcheckbox" name="consolidado" id="consolidado" value="1"  <?php echo $chkcomp ?>></td>
					<td class="saludo1" style="width:2.5cm;">Cierre
       				<input type="checkbox" class="defaultcheckbox" name="Cierre" id="Cierre" value="1"  <?php echo $chkcierre ?>></td>

                    <td><input type="button" name="generar" value="Generar" onClick="document.form2.submit()"> </td>

					<td class="saludo1">Resumido</td><td><input id="resumido" type="checkbox" name="resumido" value="1" onClick="" <?php echo $chk;  ?>></td>
					<td></td>
               	</tr>                    
    		</table>
    		<input type="hidden" value="0" name="bc">
    		<input name="oculto" type="hidden" value="1"> 
			<?php 
				$cuentav=array();
				$sqlr1="SELECT cuentacentral FROM contcuentashomologacion WHERE cuentaexterna='$_POST[cuenta]'";
				$rs=mysql_query($sqlr1,$linkbd);
				while($row=mysql_fetch_row($rs))
				{
					$cuentav[]=$row[0];
				}
				if($_POST[bc]=='1')
			 	{
			  		$nresul=buscacuenta($_POST[cuenta]);
			  		if($nresul!='')
			   		{
			 			$_POST[ncuenta]=$nresul;
  			  			echo"<script>document.form2.fecha.focus();document.form2.fecha.select();</script>";
			 		}
			 		else
			 		{
			  			$_POST[ncuenta]="";
			  			echo"<script>alert('Cuenta Incorrecta');document.form2.cuenta.focus();document.form2.cuenta.value='';</script>";
			  		}
				}
			 ?>
			<div class="subpantallac5">
  			<?php
  				//**** para sacar la consulta del balance se necesitan estos datos ********
  				//**** nivel, mes inicial, mes final, cuenta inicial, cuenta final, cc inicial, cc final  
				$oculto=$_POST['oculto'];
				if($_POST[oculto])
				{
					if($_POST[consolidado]=='1'){$critcons=" ";}
					else{$critcons=" and comprobante_det.tipo_comp <> 19 ";}
					if($_POST[consolidado]!='1')
					{
						$critcons2="";
						if($_POST[tipocc]=='N' ){$critcons2="";}
						else
						{
							$sqlrcc="select id_cc from centrocosto where entidad='N'";
							$rescc=mysql_query($sqlrcc,$linkbd);
							while($rowcc=mysql_fetch_row($rescc))
 							{ $critcons2.=" and comprobante_det.centrocosto <> '$rowcc[0]' ";}
 						}	 
					}
					$sumad=0;
                    $sumac=0;	
                    $sumaSaldoInicial=0;
					/*	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
					$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
						$agetra=$fecha[3];
					$fechafa2=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
					$fechaf2=$fecha[3]."-".$fecha[2]."-".$fecha[1];	
					$fechafa=$agetra."-01-01";
					$fechafa2=date('Y-m-d',$fechafa2-((24*60*60)));
					*/
					if($_POST[cierre]=='1'){$critconscierre=" ";}
					else {$critconscierre=" and comprobante_det.tipo_comp <> 13 ";}
					$fecha=explode ("-" ,$_POST[fecha] );
					$fechaf=$fecha[0]."-".$fecha[1]."-".$fecha[2];
					$agetra=$fecha[0];
					$fechafa2=mktime(0,0,0,$fecha[1],$fecha[2],$fecha[0]);
					$f1=$fechafa2;	
					$fecha=explode ("-" ,$_POST[fecha2]);
					$fechaf2=$fecha[0]."-".$fecha[1]."-".$fecha[2];	
					$f2=mktime(0,0,0,$fecha[1],$fecha[2],$fecha[0]);
 					//********** calcular saldo inicial ***********
					$fechafa=$agetra."-01-01";
					//$fechafa2=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
					//$diasfa2=($fechafa2/(24*60*60))-1;
					//$diasfa2=floor($diasfa2);
					$fechafa2=date('Y-m-d',$fechafa2-((24*60*60)));
					
					/*	$sqlr="select distinct comprobante_det.cuenta,(sum(comprobante_det.valdebito)-sum(comprobante_det.valcredito)) as saldof from comprobante_cab,comprobante_det where comprobante_det.cuenta='$_POST[cuenta]' and  comprobante_cab.fecha between '$fechafa' and '$fechafa2' and comprobante_det.tipo_comp=comprobante_cab.tipo_comp and  comprobante_det.numerotipo=comprobante_cab.numerotipo  and comprobante_cab.estado='1' and comprobante_cab.tipo_comp<>'7'  ".$critcons." and comprobante_det.cuenta!='' group by comprobante_det.cuenta order by comprobante_cab.tipo_comp, comprobante_cab.numerotipo,comprobante_det.id_det";
						$sqlr="select  comprobante_det.cuenta,(sum(comprobante_det.valdebito)-sum(comprobante_det.valcredito)) as saldof from comprobante_cab,comprobante_det where comprobante_det.cuenta='$_POST[cuenta]' and  comprobante_cab.fecha between '' and '$fechaf' and comprobante_det.tipo_comp=comprobante_cab.tipo_comp and  comprobante_det.numerotipo=comprobante_cab.numerotipo  and comprobante_cab.estado='1' and comprobante_det.cuenta!=''  ".$critcons." group by comprobante_det.cuenta order by comprobante_cab.tipo_comp, comprobante_cab.numerotipo,comprobante_det.id_det";
  					 $res=mysql_query($sqlr,$linkbd);
					$row =mysql_fetch_row($res);
    				$inicial=$row[1];
					echo "ft: ".substr($fechaf,0,4)." aget".$agetra;*/
					$condicioninic="";
					$condicioninic2="";
					if((substr($fechaf,0,4)==$agetra))
					{
						//$condicioninic= "AND YEAR(comprobante_cab.fecha)= '".substr($fechaf,0,4)."'";	
						$condicioninic2= "AND comprobante_cab.tipo_comp <> '7'";	
					}
					//echo $condicioninic;
					$cuentanterior='';
					for($j=0;$j<count($cuentav);$j++)
					{
						$cuentanterior=$cuentanterior." OR comprobante_det.cuenta='$cuentav[$j]'";
                    }

                    echo "
					    <table class='inicio' >
                            <tr><td colspan='10' class='titulos'>Auxiliar por Cuenta</td></tr>
                            <tr>
                                <td class='titulos2'>Fecha</td>
                                <td class='titulos2'>Tipo Comp</td>
                                <td class='titulos2'>No Comp</td>
                                <td class='titulos2'>CC</td>
                                <td class='titulos2'>Tercero</td>
                                <td class='titulos2'>Detalle</td>
                                <td class='titulos2'>Saldo Ant.</td>
                                <td class='titulos2'>Debito</td>
                                <td class='titulos2'>Credito</td>
                                <td class='titulos2'>Nuevo Saldo</td>
                            </tr>";

                    $sqlr12="select  comprobante_det.cuenta,sum(comprobante_det.valdebito), sum(comprobante_det.valcredito) from comprobante_cab,comprobante_det where comprobante_det.cuenta BETWEEN '$_POST[cuenta]' AND '$_POST[cuenta2]' AND LENGTH(comprobante_det.cuenta) = 9 and  comprobante_cab.fecha BETWEEN '' AND '$fechaf2' and comprobante_det.tipo_comp=comprobante_cab.tipo_comp AND comprobante_det.numerotipo=comprobante_cab.numerotipo and comprobante_cab.tipo_comp <> '102' and comprobante_cab.tipo_comp <> '100' and comprobante_cab.tipo_comp <> '101' and comprobante_cab.tipo_comp <> '103' and comprobante_cab.tipo_comp <> '104' and  comprobante_cab.estado='1'  $critcons $critcons2 AND comprobante_det.centrocosto like '%$_POST[cc]%' and comprobante_det.cuenta!='' group by comprobante_det.cuenta order by comprobante_cab.tipo_comp, comprobante_cab.numerotipo,comprobante_det.id_det";
					$res12=mysql_query($sqlr12,$linkbd);
                    $cuentainicial='';
                    while ($row12 =mysql_fetch_row($res12))
                    {
                        
                        $inicial=0;
                        $saldant=0;
                        $compinicial=0;
                        $compini=0;
                        if(($fechaf <= $fechafa and $fechaf2 > $fechafa) && (substr($fechaf,0,4)==$agetra))
                        { 
                            $sqlr="SELECT comprobante_det.cuenta,(sum(comprobante_det.valdebito)-sum(comprobante_det.valcredito)) as saldof FROM comprobante_cab,comprobante_det where comprobante_det.cuenta = '$row12[0]' and  comprobante_det.tipo_comp=comprobante_cab.tipo_comp AND comprobante_det.numerotipo=comprobante_cab.numerotipo  and comprobante_cab.estado='1' and comprobante_cab.tipo_comp='102' $condicioninic $critcons $critcons2 AND comprobante_det.cuenta!='' GROUP BY comprobante_det.cuenta  ORDER BY comprobante_cab.tipo_comp, comprobante_cab.numerotipo,comprobante_det.id_det ";
                            //echo $sqlr;
                            $res=mysql_query($sqlr,$linkbd);
                            $row =mysql_fetch_row($res);
                            $compini=$row[1];
                        }

                        $sqlr="select  comprobante_det.cuenta,(sum(comprobante_det.valdebito)-sum(comprobante_det.valcredito)) as saldof from comprobante_cab,comprobante_det where comprobante_det.cuenta='$row12[0]' and  comprobante_cab.fecha between '' and '$fechafa2' and comprobante_det.tipo_comp=comprobante_cab.tipo_comp AND comprobante_det.numerotipo=comprobante_cab.numerotipo and comprobante_cab.tipo_comp <> '102' and comprobante_cab.tipo_comp <> '100' and comprobante_cab.tipo_comp <> '101' and comprobante_cab.tipo_comp <> '103' and comprobante_cab.tipo_comp <> '104' and  comprobante_cab.estado='1'  $critcons12 $critcons3 AND comprobante_det.centrocosto like '%$_POST[cc]%' and comprobante_det.cuenta!='' order by comprobante_cab.tipo_comp, comprobante_cab.numerotipo,comprobante_det.id_det";
                        $res=mysql_query($sqlr,$linkbd);
                        $saldoperant=0;	
                        while ($row =mysql_fetch_row($res)){$saldoperant=$row[1];}
                        $saldant=round($compini+$saldoperant,2);
                        $compinicial=$saldant;
                        //$_POST[saldofin]=$_POST[saldoini];	
                        $nc=buscacuenta($row12[0]);
                        
                            if($_POST[consolidado]=='1'){$critcons=" ";}
                            else
                            {
                                $critcons=" and det.tipo_comp <> 19 ";
                                $critcons12=" and comprobante_det.tipo_comp <> 19 ";
                            }
                            if($_POST[consolidado]!='1')
                            {
                                $critcons2="";
                                if($_POST[tipocc]=='N' ){$critcons2="";}
                                else
                                {
                                    $sqlrcc="select id_cc from centrocosto where entidad='N'";
                                    $rescc=mysql_query($sqlrcc,$linkbd);
                                    while($rowcc=mysql_fetch_row($rescc))
                                    { 
                                        $critcons2.=" and det.centrocosto <> '$rowcc[0]' "; 
                                        $critcons3.=" and comprobante_det.centrocosto <> '$rowcc[0]' ";
                                    
                                    }
                                }	 
                            }
                            if($_POST[resumido]==1)
                            {
                                $sqlr="SELECT cab.numerotipo, cab.tipo_comp, cab.fecha, cab.concepto, det.cuenta, det.tercero, det.centrocosto, det.detalle, sum(det.valdebito), sum(det.valcredito) FROM comprobante_cab cab,comprobante_det det WHERE det.cuenta='$row12[0]' AND  cab.fecha BETWEEN '$fechaf' AND '$fechaf2' AND det.tipo_comp=cab.tipo_comp AND det.numerotipo=cab.numerotipo  AND cab.estado='1' AND cab.tipo_comp<>'7' AND cab.tipo_comp<>'102' AND cab.tipo_comp<>'103' AND cab.tipo_comp<>'101' $critcons $critcons2  AND det.centrocosto LIKE '%$_POST[cc]%' AND det.cuenta!='' GROUP BY cab.numerotipo, cab.tipo_comp ORDER BY cab.fecha asc ";
                            }
                            else
                            {
                                $sqlr="SELECT cab.numerotipo, cab.tipo_comp, cab.fecha, cab.concepto, det.cuenta, det.tercero, det.centrocosto, det.detalle, det.valdebito, det.valcredito FROM comprobante_cab cab,comprobante_det det WHERE det.cuenta='$row12[0]' AND  cab.fecha BETWEEN '$fechaf' AND '$fechaf2' AND det.tipo_comp=cab.tipo_comp AND det.numerotipo=cab.numerotipo  AND cab.estado='1' AND cab.tipo_comp<>'7' AND cab.tipo_comp<>'102' AND cab.tipo_comp<>'103' AND cab.tipo_comp<>'101' $critcons $critcons2  AND det.centrocosto LIKE '%$_POST[cc]%' AND det.cuenta!='' ORDER BY cab.fecha asc ";
                            }
                            $res=mysql_query($sqlr,$linkbd);
                            while($row=mysql_fetch_row($res))
                            {
                                $nc=buscacuentacont($row12[0]);	
                                if($row12[0]!=$cuentainicial)
                                {
                                    echo "<tr ><td class='titulop'>$row12[0]</td><td colspan='7' class='titulop'>$nc</td></tr>";	  
                                    $cuentainicial=$row12[0];
                                }
                                $sqlr="select *from tipo_comprobante where codigo=$row[1]";
                                $res2=mysql_query($sqlr);
                                $row2=mysql_fetch_row($res2);
                                $nt=buscatercero($row[5]);
                                $ns=$saldant+$row[8]-$row[9];
                                $nc=buscacuenta($row[4]);
                                /*if($row[12]=='11100507') //****** para ajustar los centros de costos
                                {
                                    $sqlru="update comprobante_det set centrocosto='01' where tipo_comp=$row[2] and numerotipo=$row[1] and (valdebito=$row[17] or  valcredito=$row[17] ) " ;
                                    mysql_query($sqlru);
                                    echo "<br>".$sqlru;
                                }	*/  
                                echo "
                                <tr>
                                    <td class='saludo3'><input type='hidden' name='cuentas[]' value='$row[4]'><input type='hidden' name='ncuentas[]' value='$nc'><input type='hidden' name='fechas[]' value='$row[2]'>$row[2]</td>
                                    <td class='saludo3'><input type='hidden' name='tipocomps[]' value='$row2[1]'>$row2[1]</td>
                                    <td class='saludo3'><input type='hidden' name='ncomps[]' value='$row[0]'>$row[0]</td>
                                    <td class='saludo3'><input type='hidden' name='ccs[]' value='$row[6]'>$row[6]</td>
                                    <td class='saludo3'><input type='hidden' name='terceros[]' value='$row[5]'><input type='hidden' name='nterceros[]' value='$nt'>$nt</td>
                                    <td class='saludo3'><input type='hidden' name='detalles[]' value='$row[7]'>$row[7]</td><td class='saludo3'><input type='hidden' name='saldanteriores[]' value='$saldant'>".number_format($saldant,2)."</td>
                                    <td class='saludo3'><input type='hidden' name='debitos[]' value='$row[8]'>".number_format($row[8],2)."</td>
                                    <td class='saludo3'><input type='hidden' name='creditos[]' value='$row[9]'>".number_format($row[9],2)."</td>
                                    <td class='saludo3'><input type='hidden' name='nuevosaldos[]' value='$ns'>".number_format($ns,2)."</td>
                                </tr>";
                                $sumad+=$row[8];
                                $sumac+=$row[9];
                                $saldant=$ns;
                                $sumaSaldoInicial += $saldant;
                            }
                    }

					
 	 					$ns=$sumaSaldoInicial+$sumad-$sumac;
 						echo "
							<tr>
								<td colspan='5'></td>
								<td>Totales:</td>
								<td class='saludo1'><input type='hidden' name='totiniciales' value='$sumaSaldoInicial'>$".number_format(0,2)."</td>
								<td class='saludo1'><input type='hidden' name='sumadebitos' value='$sumad'>$".number_format($sumad,2)."</td>
								<td class='saludo1'><input type='hidden' name='sumacreditos' value='$sumac'>$".number_format($sumac,2)."</td>
								<td class='saludo1'><input type='hidden' name='totnuevosaldos' value='$ns'>$".number_format(0,2)."</td>
							</tr>
						</table>";
					}
					if(isset($_GET['cod'])){
					if(!empty($_GET['cod'])){
						echo "<script>document.form2.submit();</script>";
					}
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
	</body>
</html>