<?php //V 1000 12/12/16 ?> 
<?php 
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
	//**niveles menu: Administracion (0) - Consultas (1) - Herramientas (2) - Reportes (3)
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Spid - Contabilidad</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
		<script>
			function pdf()
			{
				document.form2.action="pdfbalance.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function excell()
			{
				document.form2.action="cont-balancepruebaexcel.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function despliegamodal2(_valor,_nomcu)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else 
				{
					document.getElementById('ventana2').src="cuentasgral-ventana01.php?vigencia=<?php echo $_SESSION[vigencia]?>&objeto="+_nomcu+"&nobjeto=000";
				}
			}
			
			function direccionaCuentaGastos(row){
			var cell = row.getElementsByTagName("td")[0];
			var id = cell.innerHTML;																			 
			var fech=document.getElementById("fecha").value;
			var fech1=document.getElementById("fecha2").value;
			window.open("cont-auxiliarcuenta.php?cod="+id+"&fec="+fech+"&fec1="+fech1);
		}
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<table>
   			<tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>
    		<tr><?php menu_desplegable("cont");?></tr>
			<tr>
  				<td colspan="3" class="cinta">
					<a href="cont-balanceprueba.php" class="mgbt"><img src="imagenes/add.png"  title="Nuevo" /></a>
					<a class="mgbt"><img src="imagenes/guardad.png"/></a>
					<a href="#" onClick="document.form2.submit()" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="nueva ventana"></a>
					<a href="cont-estadocomprobantes.php" class="mgbt"><img src="imagenes/iratras.png" title="Retornar"></a>
				</td>
  			</tr>
		</table>
 		<form name="form2" method="post" action="cont-razonabilidadsaldofinal.php">
 			<?php
 				$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
 				if($_POST[consolidado]==''){$chkcomp=' ';}
 				else {$chkcomp=' checked ';}
 				if($_POST[cierre]==''){$chkcierre=' ';}
 				else {$chkcierre=' checked ';}
				$_POST[tipocc]="";
 			?>
			<table  align="center" class="inicio" >
			<tr>
				<td class="titulos" colspan="8" >.: Razonabilidad Saldo Final</td>
        		<td class="cerrar" style="width:7%;"><a href="cont-principal.php">&nbsp;Cerrar</a></td>
    		</tr>
    		<tr>
        			<input name="nivel" type="hidden" id="nivel" style="width:80%;">
						<?php
                            $niveles=array();
                            $sqlr="Select * from nivelesctas  where estado='S' order by id_nivel";
                            $resp = mysql_query($sqlr,$linkbd);
                            while ($row =mysql_fetch_row($resp)) 
                            {
                                $niveles[]=$row[4];
								$_POST[nivel]=$row[0];
                            }			
                        ?>
       	 		<td class="saludo1" style="width:10%;">Mes Inicial:</td>
        		<td style="width:11%;">
					<input name="fecha" type="text" id="fecha" title="DD/MM/YYYY" style="width:80%;" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" tabindex="2"/>&nbsp;<a href="#" onClick="displayCalendarFor('fecha');" tabindex="3" title="Calendario"><img src="imagenes/calendario04.png" align="absmiddle" style="width:20px;"></a>
				</td>
        		<td class="saludo1" style="width:10%;">Mes Final:</td>
        		<td style="width:11%;">
					<input type="text" name="fecha2" id="fecha2" title="DD/MM/YYYY" style="width:80%;" value="<?php echo $_POST[fecha2]; ?>" onKeyUp="return tabular(event,this)" onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" tabindex="4"/>&nbsp;<a href="#" onClick="displayCalendarFor('fecha2');" tabindex="5" title="Calendario"><img src="imagenes/calendario04.png" align="absmiddle" style="width:20px;"></a>
				</td>
   	 		</tr>
    		<tr> 
    			<td class="saludo1" >Cuenta Inicial:</td>
        		<td><input name="cuenta1" type="text" id="cuenta1" style="width:80%;" value="<?php echo $_POST[cuenta1]; ?>"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this) " tabindex="6"/>&nbsp;<a href="#" tabindex="7" onClick="despliegamodal2('visible','cuenta1')"><img src="imagenes/find02.png" style="width:20px;" align="absmiddle" border="0"></a></td>
        		<td class="saludo1" >Cuenta Final:</td>
				<td><input name="cuenta2" type="text" id="cuenta2" style="width:80%;" value="<?php echo $_POST[cuenta2]; ?>"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this) " tabindex="8">&nbsp;<a href="#" tabindex="9" onClick="despliegamodal2('visible','cuenta2')"><img src="imagenes/find02.png" style="width:20px;" align="absmiddle" border="0"></a></td>
         		<td class="saludo1">Centro Costo:</td>
	  			<td colspan="2" style="width:25%;">
					<select id='cc' name="cc" onKeyUp="return tabular(event,this)" style="width:70%;" tabindex="10">
    					<option value="" >Seleccione...</option>
						<?php
							$sqlr="select *from centrocosto where estado='S'";
							$res=mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($res)) 
							{
								if($row[0]==$_POST[cc])
			 					{
									echo "<option value=$row[0] SELECTED>$row[0] - $row[1]</option>";
			 						$_POST[tipocc]=$row[3];
								}
								else{echo "<option value=$row[0]>$row[0] - $row[1]</option>";}
							}	 	
						?>
   					</select>
	 				<input type="button" name="generar" value="Generar" onClick="document.form2.submit()" tabindex="13">
	 			</td>
    		</tr>  
		</table>
 		<input type="hidden" name="tipocc" value='<?php echo $_POST[tipocc]?>'>
		<input type="hidden" name="oculto" value="1"></td>
		<div class="subpantallap" style="height:62%; width:99.6%; overflow-x:hidden;">
  		<?php
			//echo "tipo :  ".$_POST[tipocc];
  			//**** para sacar la consulta del balance se necesitan estos datos ********
  			//**** nivel, mes inicial, mes final, cuenta inicial, cuenta final, cc inicial, cc final  
			$oculto=$_POST['oculto'];
			if($_POST[oculto])
			{	 
				if($_POST[consolidado]=='1'){$critcons=" ";$_POST[cc]="";}
				if($_POST[consolidado]!='1')
				{
					$critcons="";
					if($_POST[tipocc]=='N'){$critcons="";}
					else
					{
						$sqlrcc="select id_cc from centrocosto where entidad='N'";
						$rescc=mysql_query($sqlrcc,$linkbd);
						while($rowcc=mysql_fetch_row($rescc)){$critcons.=" and comprobante_det.centrocosto <> '".$rowcc[0]."' ";}
 					}	 
				}
				if($_POST[cierre]=='1'){$critconscierre=" ";}
				else {$critconscierre=" and comprobante_det.tipo_comp <> 13 ";}
				//echo $critcons;
				$horaini=date('h:i:s');		
				ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
				$fechaf1=$fecha[3]."-".$fecha[2]."-".$fecha[1];
				ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
				$fechaf2=$fecha[3]."-".$fecha[2]."-".$fecha[1];
				ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
				$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
				$fechafa2=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
				$f1=$fechafa2;	
				$f2=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
				$fechafa=$vigusu."-01-01";
				$fechafa2=date('Y-m-d',$fechafa2-((24*60*60)));
				//Borrar el balance de prueba anterior
				$sqlr2="select distinct digitos, posiciones from nivelesctas where estado='S' ORDER BY id_nivel DESC ";
				$resn=mysql_query($sqlr2,$linkbd);
				$rown=mysql_fetch_row($resn);
				$nivmax=$rown[0];
				$dignivmax=$rown[1];
				//continuar**** creacion balance de prueba
				//$namearch="archivos/".$_SESSION[usuario]."balanceprueba.csv";
				//$Descriptor1 = fopen($namearch,"w+"); 
				//fputs($Descriptor1,"CODIGO;CUENTA;SALDO ANTERIOR;DEBITO;CREDITO;SALDO FINAL\r\n");
  				echo "<table class='inicio' >
				<tr><td colspan='7' class='titulos'>Razonabilidad Saldo Final</td></tr>";
  				echo "<tr>
				<td class='titulos2'>Codigo</td>
				<td class='titulos2'>Cuenta</td>
				<td class='titulos2' align='center'>Saldo Anterior</td>
				<td class='titulos2' align='center'>Debito</td>
				<td class='titulos2' align='center'>Credito</td>
				<td class='titulos2' align='center'>Saldo Final</td>
				<td class='titulos2' align='center'>Estado</td>
				</tr>";
    			$tam=$niveles[$_POST[nivel]-1];
				$crit1=" and left(cuenta,$tam)>='$_POST[cuenta1]' and left(cuenta,$tam)<='$_POST[cuenta2]' ";
				$sqlr2="select distinct cuenta,tipo from cuentas where estado ='S'  and length(cuenta)=$tam ".$crit1." group by cuenta,tipo order by cuenta ";
				$rescta=mysql_query($sqlr2,$linkbd);
				$i=0;
				//echo $sqlr2;
				$pctas=array();
				$pctasb[]=array();
				while ($row =mysql_fetch_row($rescta)) 
 				{
  					$pctas[]=$row[0];
  					$pctasb["$row[0]"][0]=$row[0];
  					$pctasb["$row[0]"][1]=0;
  					$pctasb["$row[0]"][2]=0;
  					$pctasb["$row[0]"][3]=0;
				}
				mysql_free_result($rescta);
				$tam=$niveles[$_POST[nivel]-1];
				//echo "tc:".count($pctas);
				//******MOVIMIENTOS PERIODO
				$sqlr3="SELECT DISTINCT
        		SUBSTR(comprobante_det.cuenta,1,$tam),
        		sum(comprobante_det.valdebito),
        		sum(comprobante_det.valcredito)
     			FROM comprobante_det, comprobante_cab
				WHERE comprobante_cab.tipo_comp = comprobante_det.tipo_comp
				AND comprobante_det.numerotipo = comprobante_cab.numerotipo
				AND comprobante_cab.estado = 1
				AND (comprobante_det.valdebito > 0
				OR comprobante_det.valcredito > 0)
				AND comprobante_cab.fecha BETWEEN '$fechaf1' AND '$fechaf2'
				AND comprobante_det.tipo_comp <> 7 ".$critcons." ".$critconscierre."
				AND SUBSTR(comprobante_det.cuenta,1,$tam) >= '$_POST[cuenta1]' AND SUBSTR(comprobante_det.cuenta,1,$tam) <='$_POST[cuenta2]'
				AND comprobante_det.centrocosto like '%$_POST[cc]%'
				GROUP BY SUBSTR(comprobante_det.cuenta,1,$tam)
				ORDER BY comprobante_det.cuenta";
				$res=mysql_query($sqlr3,$linkbd);
				// echo $sqlr3;
				while ($row =mysql_fetch_row($res)) 
				{
					$pctasb["$row[0]"][0]=$row[0];
					$pctasb["$row[0]"][2]=$row[1];
					$pctasb["$row[0]"][3]=$row[2];
				}
				//**** SALDO INICIAL ***
				$sqlr3="SELECT DISTINCT
				SUBSTR(comprobante_det.cuenta,1,$tam),
				sum(comprobante_det.valdebito)-
				sum(comprobante_det.valcredito)
				FROM comprobante_det, comprobante_cab
				WHERE comprobante_cab.tipo_comp = comprobante_det.tipo_comp
				AND comprobante_det.numerotipo = comprobante_cab.numerotipo
				AND comprobante_cab.estado = 1
				AND (comprobante_det.valdebito > 0
				OR comprobante_det.valcredito > 0)         
				AND comprobante_det.tipo_comp = 7 
				AND SUBSTR(comprobante_det.cuenta,1,$tam) >= '$_POST[cuenta1]' AND SUBSTR(comprobante_det.cuenta,1,$tam) <='$_POST[cuenta2]'   
				AND comprobante_det.centrocosto like '%$_POST[cc]%' ".$critcons."
				GROUP BY SUBSTR(comprobante_det.cuenta,1,$tam)
				ORDER BY comprobante_det.cuenta";
				$res=mysql_query($sqlr3,$linkbd);
				// echo $sqlr3;
				while ($row =mysql_fetch_row($res)) 
				{
					$pctasb["$row[0]"][0]=$row[0];
					$pctasb["$row[0]"][1]=$row[1];
				}
				//*******MOVIMIENTOS PREVIOS PERIODO
				$sqlr3="SELECT DISTINCT
				SUBSTR(comprobante_det.cuenta,1,$tam),
				sum(comprobante_det.valdebito)-
				sum(comprobante_det.valcredito)
				FROM comprobante_det, comprobante_cab
				WHERE comprobante_cab.tipo_comp = comprobante_det.tipo_comp
				AND comprobante_det.numerotipo = comprobante_cab.numerotipo
				AND comprobante_cab.estado = 1
				AND (comprobante_det.valdebito > 0
				OR comprobante_det.valcredito > 0)
				AND comprobante_det.tipo_comp <> 7 ".$critcons."  
				AND comprobante_cab.fecha BETWEEN '' AND '$fechafa2'
				AND SUBSTR(comprobante_det.cuenta,1,$tam) >= '$_POST[cuenta1]' AND SUBSTR(comprobante_det.cuenta,1,$tam) <='$_POST[cuenta2]'		 
				AND comprobante_det.centrocosto like '%$_POST[cc]%'
				GROUP BY SUBSTR(comprobante_det.cuenta,1,$tam)
				ORDER BY comprobante_det.cuenta";
				$res=mysql_query($sqlr3,$linkbd);
				//echo $sqlr3;
				//  sort($pctasb[]);
				while ($row =mysql_fetch_row($res)) 
				{
					$pctasb["$row[0]"][0]=$row[0];
					$pctasb["$row[0]"][1]+=$row[1]; 
				} 
				for ($y=0;$y<$_POST[nivel];$y++)
				{ 
					$lonc=count($pctasb);
					//foreach($pctasb as $k => $valores )
					$k=0;
					// echo "lonc:".$lonc;
					//   while($k<$lonc)
					foreach($pctasb as $k => $valores )
					{
						if (strlen($pctasb[$k][0])>=$niveles[$y-1])
						{		 
							$ncuenta=substr($pctasb[$k][0],0,$niveles[$y-1]);
							if($ncuenta!='')
							{
								$pctasb["$ncuenta"][0]=$ncuenta;
								$pctasb["$ncuenta"][1]+=$pctasb[$k][1];
								$pctasb["$ncuenta"][2]+=$pctasb[$k][2];
								$pctasb["$ncuenta"][3]+=$pctasb[$k][3];
								//echo "<br>N:".$niveles[$y-1]." : cuenta:".$k." NC:".$ncuenta."  ".$pctasb["$ncuenta"][1]."  ".$pctasb["$ncuenta"][2]."  ".$pctasb["$ncuenta"][3];	
							}
						}			
						$k++;
					}
				}
				$sqlr="create  temporary table usr_session (id int(11),cuenta varchar(20),nombrecuenta varchar(100),saldoinicial double,debito double,credito double,saldofinal double)";
				mysql_query($sqlr,$linkbd);
				$i=1;
				foreach($pctasb as $k => $valores )
				{	 
					if(($pctasb[$k][1]<0 || $pctasb[$k][1]>0) || ($pctasb[$k][2]<0 || $pctasb[$k][2]>0) || ($pctasb[$k][3]<0 || $pctasb[$k][3]>0))
					{
						$saldofinal=$pctasb[$k][1]+$pctasb[$k][2]-$pctasb[$k][3];
						$nomc=existecuenta($pctasb[$k][0]);
						$sqlr="insert into usr_session (id,cuenta,nombrecuenta,saldoinicial,debito,credito,saldofinal) values($i,'".$pctasb[$k][0]."','".$nomc."',".$pctasb[$k][1].",".$pctasb[$k][2].",".$pctasb[$k][3].",".$saldofinal.")";
						mysql_query($sqlr,$linkbd);
						//echo "<br>".$sqlr;
						$i+=1;
					}
					//echo "<br>cuenta:".$k."  ".$pctasb[$k][1]."  ".$pctasb[$k][2]."  ".$pctasb[$k][3];	
				}
				$sqlr="select *from usr_session order by cuenta";
				$res=mysql_query($sqlr,$linkbd);
				$_POST[tsaldoant]=0;
				$_POST[tdebito]=0;
				$_POST[tcredito]=0;
				$_POST[tsaldofinal]=0;
				$namearch="archivos/".$_SESSION[usuario]."balanceprueba-nivel$_POST[nivel].csv";
				$Descriptor1 = fopen($namearch,"w+"); 
				fputs($Descriptor1,"CODIGO;CUENTA;SALDO ANTERIOR;DEBITO;CREDITO;SALDO FINAL\r\n");
				$co='zebra1';
				$co2='zebra2';
  				while($row=mysql_fetch_row($res))
  				{
					$negrilla="style='font-weight:bold'";
					$puntero="";
					$dobleclick="";
					if (strlen($row[1])==($dignivmax))
					{
						//$negrilla=" "; 
						//$_POST[tsaldoant]+=$row[3];
						//$_POST[tdebito]+=$row[4];
						//$_POST[tcredito]+=$row[5];
					}
					if($niveles[$_POST[nivel]-1]==strlen($row[1]))
					{
						$negrilla=" "; 
						$dobleclick="ondblclick='direccionaCuentaGastos(this)'";
						$puntero='cursor: hand';
						$_POST[tsaldoant]+=$row[3];
						$_POST[tdebito]+=$row[4];
						$_POST[tcredito]+=$row[5];			  
						$_POST[tsaldofinal]+=$row[6];			  	
					}
					$sql="SELECT naturaleza from cuentas WHERE cuenta='$row[1]' ";
					//echo $sql;
					$res2=mysql_query($sql,$linkbd);
					$ro=mysql_fetch_row($res2);
					
					if (substr($row[1],0,1)=='2' || substr($row[1],0,1)=='3' || substr($row[1],0,1)=='4')
					{
						$var1=number_format($miles,0,",",".");
						$var2=number_format($rowc[2],0,",",".");
						$sumvar=$var1 + $var2;
						if((strlen($row[1])==8)&& $row[6]>'0' && ($ro[0]=='CREDITO' or $ro[0]=='credito')){
							$estilo='background-color:yellow;';
							$var1=str_replace(',','.',str_replace('.','',$var1));
							$var2=str_replace(',','.',str_replace('.','',$var2));
							$dif="REVISAR SALDO O NATURALEZA DE LA CUENTA>";
							
							
							
							//echo "IF se pinta: "; echo $row[1]; echo "<br>";
						}
						else{
							$estilo="";
							$dif="";
						}	
					}
					else{
						
						$var1=number_format($miles,0,",",".");
						$var2=number_format($rowc[2],0,",",".");
						if((strlen($row[1])==8)&& $row[6]<'0' && ($ro[0]=='DEBITO' or $ro[0]=='debito')){
							$estilo='background-color:yellow;';
							$var1=str_replace(',','.',str_replace('.','',$var1));
							$var2=str_replace(',','.',str_replace('.','',$var2));
							
							$dif="REVISAR SALDO O NATURALEZA DE LA CUENTA ";
							//echo "ELSE se pinta: "; echo $row[1]; echo "<br>";
						}
						else{
							$estilo="";
							$dif="";
						}
					}
					echo "
					<tr class='$co' $dobleclick style='text-transform:uppercase; $estilo $puntero' text-rendering: optimizeLegibility;'>
						<td $negrilla style='width:5%;'>$row[1]</td>
						<td $negrilla style='width:33%;'>$row[2]</td>
						<td $negrilla align='right' style='width:10%;'>".number_format($row[3],2,".",",")."</td>
						<td $negrilla align='right' style='width:10%;'>".number_format($row[4],2,".",",")."</td>
						<td $negrilla align='right' style='width:10%;'>".number_format($row[5],2,".",",")."</td>
						<td $negrilla align='right' style='width:10%;'>".number_format($row[6],2,".",",")."";
					echo "<input type='hidden' name='dcuentas[]' value= '".$row[1]."'> <input type='hidden' name='dncuentas[]' value= '".$row[2]."'><input type='hidden' name='dsaldoant[]' value= '".number_format($row[3],2,",",".")."'> <input type='hidden' name='ddebitos[]' value= '".number_format($row[4],2,",",".")."'> <input type='hidden' name='dcreditos[]' value= '".number_format($row[5],2,",",".")."'><input type='hidden' name='dsaldo[]' value= '".number_format($row[6],2,",",".")."'></td>
					<td style='width:30%;' align='center'> $dif</td>
					</tr>";
					fputs($Descriptor1,$row[1].";".$row[2].";".number_format($row[3],3,",","").";".number_format($row[4],3,",","").";".number_format($row[5],3,",","").";".number_format($row[6],3,",","")."\r\n");
					$aux=$co;
					$co=$co2;
					$co2=$aux;
					$i=1+$i;
				}
				fclose($Descriptor1);
				echo "<tr class='$co'><td colspan='2'></td><td class='$co' align='right'>".number_format($_POST[tsaldoant],2,".",",")."<input type='hidden' name='tsaldoant' value= '$_POST[tsaldoant]'></td><td class='$co' align='right'>".number_format($_POST[tdebito],2,".",",")."<input type='hidden' name='tdebito' value= '$_POST[tdebito]'></td><td class='$co' align='right'>".number_format($_POST[tcredito],2,".",",")."<input type='hidden' name='tcredito' value= '$_POST[tcredito]'></td><td class='$co' align='right'>".number_format($_POST[tsaldofinal],2,".",",")."<input type='hidden' name='tsaldofinal' value= '$_POST[tsaldofinal]'></td></tr>";  
				$horafin=date('h:i:s');	
				echo "<DIV class='ejemplo'>INICIO:$horaini FINALIZO: $horafin</DIV>";
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