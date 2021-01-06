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
		<title>:: SPID - Presupuesto</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
		<script>
			function despliegamodal2(_valor)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else {document.getElementById('ventana2').src="contra-productos-ventana.php";}
			}
 			function despliegamodalm(_valor,_tip,mensa,pregunta,variable)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventanam').src="";}
				else
				{
					switch(_tip)
					{
						case "1":	document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
						case "2":	document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
						case "3":	document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
						case "4":	document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;	
				case "5":
					document.getElementById('ventanam').src="ventana-elimina1.php?titulos="+mensa+"&idresp="+pregunta+"&variable="+variable;break;	
					}
				}
			}
			function respuestaconsulta(pregunta, variable)
			{
				switch(pregunta)
				{
					case "1":	document.getElementById('oculto').value="2";
								document.form2.submit();break;
					case "2":
						document.form2.elimina.value=variable;
						//eli=document.getElementById(elimina);
						vvend=document.getElementById('elimina');
						//eli.value=elimina;
						vvend.value=variable;
						document.form2.submit();
						break;
				}
			}
			function funcionmensaje(){}
			function pdf()
			{
				document.form2.action="presu-ejecuciongastospdf.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function excell()
			{
				document.form2.action="presu-ejecuciongastosexcel2.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function validar()
			{
				document.getElementById('oculto').value='3';
				document.form2.submit(); 
			}
		</script>
		<?php titlepag();?>
	</head>
<body>
 <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
        	<tr><?php menu_desplegable("presu");?></tr>
        	<tr>
  				<td colspan="3" class="cinta"><a href="#" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a> <a href="#" class="mgbt" onClick="document.form2.submit();"><img src="imagenes/guarda.png" title="Guardar"/></a> <a href="#" onClick="document.form2.submit()" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a> <a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a> <a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png" title="imprimir"></a> <a href="#" onClick="excell()" class="mgbt"><img src="imagenes/excel.png" title="excel"></a> <a href="presu-ejecucionpresupuestal.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a></td>
          	</tr>
		</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>	  
		<form name="form2" method="post" action="presu-ejecuciongastosoficial.php">
			<?php
			$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
			$vigencia=$vigusu;
			if($_POST[bc]!='')
			{
				$nresul=buscacuentapres($_POST[cuenta],2);			
				if($nresul!='')
				{
					$_POST[ncuenta]=$nresul;
   			 /* $linkbd=conectar_bd();
			  $sqlr="select *from pptocuentaspptoinicial where cuenta=$_POST[cuenta] and vigencia=". $vigusu;
			  $res=mysql_query($sqlr,$linkbd);
			  $row=mysql_fetch_row($res);
			  $_POST[valor]=$row[5];		  
			  $_POST[valor2]=$row[5];	*/	  			  

				}
				else
				{
					$_POST[ncuenta]="";	
				}
			}
 ?>
    <table  align="center" class="inicio" >
		<tr >
			<td class="titulos" colspan="8">.: Ejecucion Gastos</td>
			<td width="7%" class="cerrar"><a href="presu-principal.php">Cerrar</a></td>
		</tr>
		<tr>      
			<td width="10%" class="saludo1">Fecha Inicial:</td>
			<td width="10%"><input type="hidden" value="<?php echo $ $vigusu ?>" name="vigencias"><input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">         <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/calendario04.png" style="width:20px;" align="absmiddle" border="0"></a>        </td>
			<td width="10%" class="saludo1">Fecha Final: </td>
			<td width="10%"><input name="fecha2" type="text" id="fc_1198971546" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha2]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10"> <a href="#" onClick="displayCalendarFor('fc_1198971546');"><img src="imagenes/calendario04.png" style="width:20px;" align="absmiddle" border="0"></a>  
			</td>
			<td style="width=5%" class="saludo1">Ver: </td>
			<td style="width=10%">
				<select name="vereg" id="vereg" style='width: 100%;'>
					<option value="1" <?php if($_POST[vereg]=='1') echo 'selected="selected"'; ?>>TODOS</option>
					<option value="2" <?php if($_POST[vereg]=='2') echo 'selected="selected"'; ?>>SGR</option>
				</select>
			</td>
			<td width="5%">
				<input type="button" name="generar" value="Generar" onClick="validar()"> 
				<input type="hidden" value="<?php echo $_POST[oculto]; ?>" name="oculto" id="oculto">
			</td>
			<td width="33%"></td>
		</tr>      
    </table>
	<?php
		if($_POST[oculto]==2){
			ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha1);
			$fechaf=$fecha1[3]."-".$fecha1[2]."-".$fecha1[1];
			ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha2);
			$fechaf2=$fecha2[3]."-".$fecha2[2]."-".$fecha2[1];	
			if($_POST[vereg]=='1'){
				if($fecha1[3]==$fecha2[3]){
					$correcto=1;
					$sqlv="SELECT vigencia, vigenciaf FROM pptocuentas WHERE vigencia='$fecha1[3]' AND regalias='S'";
					$resv=mysql_query($sqlv,$linkbd);
					if(mysql_num_rows($resv)!=0){
						$todos=1;
					}
					else{
						$todos=0;
					}
				}
				else{
					$correcto=0;
					echo "<script>despliegamodalm('visible','1','El Presupuesto General SOLO Aplica para Una Vigencia');</script>";				
				}
			}
			elseif($_POST[vereg]=='2'){
				if($fecha1[3]==$fecha2[3]){
					$correcto=1;
					$sqlv="SELECT vigencia, vigenciaf FROM pptocuentas WHERE vigencia='$fecha1[3]' AND regalias='S'";
					//echo $sqlv;
					$resv=mysql_query($sqlv,$linkbd);
					if(mysql_num_rows($resv)!=0){
						$todos=1;
					}
					else{
						$todos=0;
					}
				}
				else{
					$numvig=$fecha2[3]-$fecha1[3];
					if(($numvig>0)&&($numvig<3)){
						$vigenciarg=$fecha1[3].' - '.$fecha2[3];
						$sqlv2="SELECT * FROM pptocuentas WHERE vigenciarg='$vigenciarg'";
						$resv2=mysql_query($sqlv2,$linkbd);
						if(mysql_num_rows($resv2)!=0){
							$correcto=1;
							if($numvig>0){
								$todos=1;
							}
							else{
								$sqlv="SELECT vigencia, vigenciaf FROM pptocuentas WHERE vigencia='$fecha1[3]' AND regalias='S'";
								$resv=mysql_query($sqlv,$linkbd);
								if(mysql_num_rows($resv)!=0){
									$todos=1;
								}
								else{
									$todos=0;
								}
							}
						}
						else{
							$correcto=0;
							echo "<script>despliegamodalm('visible','1','Su Busqueda NO corresponde a una Vigencia del SGR');</script>";			
						}
					}
					else{
						$correcto=0;
						echo "<script>despliegamodalm('visible','1','La Vigencia para SGR se puede Consultar Maximo por 2 Años');</script>";				
					}
				}
			}
		}
		//**** busca cuenta
		if($_POST[bc]!='')
		{
			$nresul=buscacuentapres($_POST[cuenta],2);
			if($nresul!='')
			{
				$_POST[ncuenta]=$nresul;
				/*$linkbd=conectar_bd();
				$sqlr="select *from pptocuentas where cuenta=$_POST[cuenta] and vigencia=$vigusu";
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
				$_POST[valor]=$row[5];		  
				$_POST[valor2]=$row[5];	*/	  			  
				?>
				<script>
					document.form2.fecha.focus();
					document.form2.fecha.select();
				</script>
			<?php
			}
			else
			{
				$_POST[ncuenta]="";
			?>
				<script>alert("Cuenta Incorrecta");document.form2.cuenta.focus();</script>
			<?php
			}
		}
	?>
	<table>
	<?php
			$sqlr2="Select distinct pptocuentas.cuenta, pptocuentas.tipo, pptocuentas.vigencia, pptocuentas.vigenciaf, dominios.tipo from pptocuentas, dominios where dominios.descripcion_valor=pptocuentas.clasificacion AND dominios.nombre_dominio='CLASIFICACION_RUBROS' AND (dominios.tipo='G') and (pptocuentas.vigencia='".$vigusu."' or  pptocuentas.vigenciaf='".$vigusu."') $cond ORDER BY pptocuentas.cuenta ASC ";
	?>
	</table>
	<?php
	if ($_POST[oculto]==3)
	{
	?>
	<div class="subpantallap" style="height:66.6%; width:99.6%; ">
	
	<?php
		$var1=array();
		$var2=array();
		$var3=array();
		$var4=array();
		$var5=array();
		$var6=array();
		$var7=array();
		$var8=array();
		$var9=array();
		$var10=array();
		$var11=array();
		$var12=array();
		$var13=array();
		$var14=array();
		$var15=array();
		$var16=array();
		$_POST[cuenta]=array();
		$_POST[nombre]=array();
		$_POST[pid]=array();
		$_POST[pic]=array();
		$_POST[adc]=array(); 
		$_POST[red]=array();
		$_POST[cred]=array();
		$_POST[contra]=array();
		$_POST[ppto]=array();
		$_POST[cdpd]=array(); 
		$_POST[cdpc]=array(); 
		$_POST[rpd]=array(); 
		$_POST[rpc]=array(); 
		$_POST[cxpd]=array(); 
		$_POST[cxpc]=array(); 
		$_POST[cxp]=array();
		$_POST[egd]=array(); 
		$_POST[egc]=array(); 
		$_POST[cee]=array();
		$_POST[saldos]=array();
		
		$c1=array();
		$c2=array();
		$c3=array();
		$c4=array();
		$c5=array();
		$c6=array();
		$c7=array();
		$c8=array();
		$iter="zebra1";
		$iter2="zebra2";
		$tipo=array();
		echo "<table class='inicio'>
			<tr class='titulos'>
				<td colspan='15'>.: Ejecucion Cuentas</td>
			</tr>
			<tr class='titulos2'>
				<td>Cuenta</td>
				<td >Nombre</td>
				<td >Presupuesto Inicial</td>
				<td >Adicion</td>
				<td >Reduccion</td>
				<td >Credito</td>
				<td >Contra Credito</td>
				<td >Presupuesto Definitivo</td>
				<td >Disponibilidad</td>
				<td >Compromisos</td>
				<td >Obligaciones</td>
				<td >Pagos</td>
				<td >Saldo</td>
				<td >%</td>
			</tr>
			
			";
		$fech1=split("/",$_POST[fecha]);
		$fech2=split("/",$_POST[fecha2]);
		$f1=$fech1[2]."-".$fech1[1]."-".$fech1[0];
		$f2=$fech2[2]."-".$fech2[1]."-".$fech2[0];
		//--CUENTAS
		$sqlr="select cuenta,nombre,tipo from pptocuentas where cuenta like '2%' order by cuenta asc";
		$res=mysql_query($sqlr,$linkbd);
		while($row=mysql_fetch_row($res)){
			$var1[]=$row[0];
			$var2[]=$row[1];
			$tipo[]=$row[2];
		}
		// echo count($var1);
		// for($x=0;$x<count($var1);$x++){
			// echo $var1[$x]."<br>";
		// }
		//--P.I
		$totalpi1=0;
		$totalpi2=0;
		$sqlr1="SELECT p1.cuenta,sum(p1.valdebito),sum(p1.valcredito), p1.tipo_comp FROM pptocomprobante_det p1, pptocomprobante_cab p2 WHERE p1.tipo_comp=1 and p1.cuenta like '2%' and p1.numerotipo=p2.numerotipo and p1.tipo_comp=p2.tipo_comp and p2.fecha>='$f1' and p2.fecha<='$f2' and p1.tipomovimiento=1 and p1.estado=1 and p1.vigencia=$vigencia GROUP BY tipo_comp,cuenta ORDER BY CUENTA ASC";
		$res1=mysql_query($sqlr1,$linkbd);
		while($row1=mysql_fetch_row($res1)){
			$c1[]=$row1[0];
			$var3[]=$row1[1];
			$var4[]=$row1[2];
			$totalpi1+=$row1[1];
			$totalpi2+=$row1[2];
		}
		//--ADICION
		$totalad=0;
		$sqlr2="SELECT p1.cuenta,sum(p1.valdebito),sum(p1.valcredito), p1.tipo_comp FROM pptocomprobante_det p1, pptocomprobante_cab p2 WHERE p1.tipo_comp=2 and p1.cuenta like '2%' and p1.numerotipo=p2.numerotipo and p1.tipo_comp=p2.tipo_comp and p2.fecha>='$f1' and p2.fecha<='$f2' and p1.tipomovimiento=1 and p1.estado=1 and p1.vigencia=$vigencia GROUP BY tipo_comp,cuenta ORDER BY CUENTA ASC";
		$res2=mysql_query($sqlr2,$linkbd);
		while($row2=mysql_fetch_row($res2)){
			$c2[]=$row2[0];
			$var5[]=$row2[1];
			$totalad+=$row2[1];
		}
		//--REDUCCION
		$totalred=0;
		$sqlr3="SELECT p1.cuenta,sum(p1.valdebito),sum(p1.valcredito), p1.tipo_comp FROM pptocomprobante_det p1, pptocomprobante_cab p2 WHERE p1.tipo_comp=3 and p1.cuenta like '2%' and p1.numerotipo=p2.numerotipo and p1.tipo_comp=p2.tipo_comp and p2.fecha>='$f1' and p2.fecha<='$f2' and p1.tipomovimiento=1 and p1.estado=1 and p1.vigencia=$vigencia GROUP BY tipo_comp,cuenta ORDER BY CUENTA ASC";
		echo $sqlr3;
		$res3=mysql_query($sqlr3,$linkbd);
		while($row3=mysql_fetch_row($res3)){
			$c3[]=$row3[0];
			$var6[]=$row3[2];
			$totalred+=$row3[2];
		}
		//--TRASLADOS
		$totalcred=0;
		$totalcontra=0;
		$sqlr8="SELECT p1.cuenta,sum(p1.valdebito),sum(p1.valcredito), p1.tipo_comp FROM pptocomprobante_det p1, pptocomprobante_cab p2 WHERE p1.tipo_comp=5 and p1.cuenta like '2%' and p1.numerotipo=p2.numerotipo and p1.tipo_comp=p2.tipo_comp and p2.fecha>='$f1' and p2.fecha<='$f2' and p1.tipomovimiento=1 and p1.estado=1 and p1.vigencia=$vigencia GROUP BY tipo_comp,cuenta ORDER BY CUENTA ASC";
		$res8=mysql_query($sqlr8,$linkbd);
		while($row8=mysql_fetch_row($res8)){
			$c8[]=$row8[0];
			$var15[]=$row8[1];
			$var16[]=$row8[2];
			$totalred+=$row8[1];
			$totalcontra+=$row8[2];
		}
		//--CDP
		$totalcdp1=0;
		$totalcdp2=0;
		$sqlr4="SELECT p1.cuenta,sum(p1.valdebito),sum(p1.valcredito), p1.tipo_comp FROM pptocomprobante_det p1, pptocomprobante_cab p2 WHERE p1.tipo_comp=6 and p1.cuenta like '2%' and p1.numerotipo=p2.numerotipo and p1.tipo_comp=p2.tipo_comp and p2.fecha>='$f1' and p2.fecha<='$f2' and p1.tipomovimiento=1 and (p1.estado=1 or p1.estado=4) and p1.vigencia=$vigencia GROUP BY tipo_comp,cuenta ORDER BY CUENTA ASC";
		$res4=mysql_query($sqlr4,$linkbd);
		while($row4=mysql_fetch_row($res4)){
			$c4[]=$row4[0];
			$var7[]=$row4[1];
			$var8[]=$row4[2];
			$totalcdp1+=$row4[1];
			$totalcdp2+=$row4[2];
		}
		//--RP
		$totalrp1=0;
		$totalrp2=0;
		$sqlr5="SELECT p1.cuenta,sum(p1.valdebito),sum(p1.valcredito), p1.tipo_comp FROM pptocomprobante_det p1, pptocomprobante_cab p2 WHERE p1.tipo_comp=7 and p1.cuenta like '2%' and p1.numerotipo=p2.numerotipo and p1.tipo_comp=p2.tipo_comp and p2.fecha>='$f1' and p2.fecha<='$f2' and p1.tipomovimiento=1 and p1.estado=1 and p1.vigencia=$vigencia GROUP BY tipo_comp,cuenta ORDER BY CUENTA ASC";
		$res5=mysql_query($sqlr5,$linkbd);
		while($row5=mysql_fetch_row($res5)){
			$c5[]=$row5[0];
			$var9[]=$row5[1];
			$var10[]=$row5[2];
			$totalrp1+=$row5[1];
			$totalrp2+=$row5[2];
		}
		//--OBLIGACIONES
		$totalob1=0;
		$totalob2=0;
		$sqlr6="SELECT p1.cuenta,sum(p1.valdebito),sum(p1.valcredito), p1.tipo_comp FROM pptocomprobante_det p1, pptocomprobante_cab p2 WHERE (p1.tipo_comp=8 or p1.tipo_comp=9)  and p1.cuenta like '2%' and p1.numerotipo=p2.numerotipo and p1.tipo_comp=p2.tipo_comp and p2.fecha BETWEEN '$f1' AND '$f2' and p1.tipomovimiento=1 and p1.estado=1 and p1.vigencia=$vigencia GROUP BY cuenta ORDER BY CUENTA ASC";
		//echo $sqlr6;
		$res6=mysql_query($sqlr6,$linkbd);
		while($row6=mysql_fetch_row($res6)){
			$c6[]=$row6[0];
			$var11[]=$row6[1];
			$var12[]=$row6[2];
			$totalob1+=$row6[1];
			$totalob2+=$row6[2];
		}
		//--PAGOS
		$totalpag1=0;
		$totalpag2=0;
		$sqlr7="SELECT p1.cuenta,sum(p1.valdebito),sum(p1.valcredito), p1.tipo_comp FROM pptocomprobante_det p1, pptocomprobante_cab p2 WHERE p1.tipo_comp=11 and p1.cuenta like '2%' and p1.numerotipo=p2.numerotipo and p1.tipo_comp=p2.tipo_comp and p2.fecha>='$f1' and p2.fecha<='$f2' and p1.tipomovimiento=1 and p1.estado=1 and p1.vigencia=$vigencia GROUP BY tipo_comp,cuenta ORDER BY CUENTA ASC";
		$res7=mysql_query($sqlr7,$linkbd);
		while($row7=mysql_fetch_row($res7)){
			$c7[]=$row7[0];
			$var13[]=$row7[1];
			$var14[]=$row7[2];
			$totalpag1+=$row7[1];
			$totalpag2+=$row7[2];
		}
		//---
		$cont1=0;
		$cont2=0;
		$cont3=0;
		$cont4=0;
		$cont5=0;
		$cont6=0;
		$cont7=0;
		$cont8=0;
		$s1=$s2=$s3=$s4=$s5=$s6=$s7=$s8=$s9=$s10=$s11=$s12=0;
		$totalsaldos=0;
		for($x=0;$x<count($var1);$x++){
			$_POST[cuenta][]=$var1[$x];
			$_POST[nombre][]=$var2[$x];
			if($tipo[$x]=='Mayor'){
				$s="style='font-weight:bold; font-size:9px;'";
			}else{
				$s="style='font-size:9px;'";
			}
			echo "<tr class='$iter' $s>			
				<td>$var1[$x]</td>
				<td>$var2[$x]</td>
				";
			if($var1[$x]==$c1[$cont1]){
				// echo $var1[$x]."-".$c1[$cont1]." ";
				// echo "
				// <td>".number_format($var3[$cont1],2,",",".")."</td>
				// <td>".number_format($var4[$cont1],2,",",".")."</td>";
				echo "<td>".number_format($var3[$cont1],2,",",".")."</td>";
				$s1=$var3[$cont1];
				$s2=$var4[$cont1];
				$_POST[pid][]=$var3[$cont1];
				$_POST[pic][]=$var4[$cont1];
				$cont1+=1;
			}else{
				$sqlr="select sum(p1.valdebito),sum(p1.valcredito) from pptocomprobante_det p1, pptocomprobante_cab p2 where p1.cuenta like '".$var1[$x]."%' and p1.tipo_comp=1 and p1.numerotipo=p2.numerotipo and p1.tipo_comp=p2.tipo_comp and p2.fecha>='$f1' and p2.fecha<='$f2' and p1.tipomovimiento=1 and p1.estado=1 and p1.vigencia=$vigencia";
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
				if($row[0]==0){$row[0]=0;}
				if($row[1]==0){$row[1]=0;}
				// echo "
				// <td>".number_format($row[0],2,",",".")."</td>
				// <td>".number_format($row[1],2,",",".")."</td>";
				echo "<td>".number_format($row[0],2,",",".")."</td>";
				$s1=$row[0];
				$s2=$row[1];
				$_POST[pid][]=$row[0];
				$_POST[pic][]=$row[1];
			}
			if($var1[$x]==$c2[$cont2]){
				echo "
				<td>".number_format($var5[$cont2],2,",",".")."</td>";
				$s3=$var5[$cont2];
				$_POST[adc][]=$var5[$cont2]; 
				$cont2+=1;
			}else{
				$sqlr="select sum(p1.valdebito),sum(p1.valcredito) from pptocomprobante_det p1, pptocomprobante_cab p2 where p1.cuenta like '".$var1[$x]."%' and p1.tipo_comp=2 and p1.numerotipo=p2.numerotipo and p1.tipo_comp=p2.tipo_comp and p2.fecha>='$f1' and p2.fecha<='$f2' and p1.tipomovimiento=1 and p1.estado=1 and p1.vigencia=$vigencia";
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
				if($row[0]==0){$row[0]=0;}
				echo "
				<td>".number_format($row[0],2,",",".")."</td>";
				$s3=$row[0];
				$_POST[adc][]=$row[0];
			}
			if($var1[$x]==$c3[$cont3]){
				echo "
				<td>".number_format($var6[$cont3],2,",",".")."</td>";
				$_POST[red][]=$var6[$cont3]; 
				$s4=$var6[$cont3]; 
				$cont3+=1;
			}else{
				$sqlr="select sum(p1.valdebito),sum(p1.valcredito) from pptocomprobante_det p1, pptocomprobante_cab p2 where p1.cuenta like '".$var1[$x]."%' and p1.tipo_comp=3 and p1.numerotipo=p2.numerotipo and p1.tipo_comp=p2.tipo_comp and p2.fecha>='$f1' and p2.fecha<='$f2' and p1.tipomovimiento=1 and p1.estado=1 and p1.vigencia=$vigencia";
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
				if($row[1]==0){$row[1]=0;}
				echo "
				<td>".number_format($row[1],2,",",".")."</td>";
				$_POST[red][]=$row[1]; 
				$s4==$row[1];
			}
			if($var15[$x]==$c8[$cont8]){
				echo "
				<td>".number_format($var15[$cont8],2,",",".")."</td>
				<td>".number_format($var16[$cont8],2,",",".")."</td>";
				$_POST[cred][]=$var15[$cont8];
				$_POST[contra][]=$var16[$cont8]; 
				$cont8+=1;
			}else{
				$sqlr="select sum(p1.valdebito),sum(p1.valcredito) from pptocomprobante_det p1, pptocomprobante_cab p2 where p1.cuenta like '".$var1[$x]."%' and p1.tipo_comp=5 and p1.numerotipo=p2.numerotipo and p1.tipo_comp=p2.tipo_comp and p2.fecha>='$f1' and p2.fecha<='$f2' and p1.tipomovimiento=1 and p1.estado=1 and p1.vigencia=$vigencia";
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
				if($row[0]==0){$row[0]=0;}
				echo "
				<td>".number_format($row[0],2,",",".")."</td>
				<td>".number_format($row[1],2,",",".")."</td>";
				$_POST[cred][]=$row[0];
				$_POST[contra][]=$row[1];				
			}
			$pptodef=$_POST[pid][$x]+$_POST[adc][$x]-$_POST[red][$x]+$_POST[cred][$x]-$_POST[contra][$x];
			$_POST[ppto][]=$pptodef;
			echo "<td>".number_format($pptodef,2,",",".")."</td>";
			if($var1[$x]==$c4[$cont4]){
				// echo "
				// <td>".number_format($var7[$cont4],2,",",".")."</td>
				// <td>".number_format($var8[$cont4],2,",",".")."</td>";
				echo "<td>".number_format($var7[$cont4],2,",",".")."</td>";
				$_POST[cdpd][]=$var7[$cont4]; 
				$_POST[cdpc][]=$var8[$cont4]; 
				$s5=$var7[$cont4];
				$s6=$var8[$cont4];
				$cont4+=1;
			}else{
				$sqlr="select sum(p1.valdebito),sum(p1.valcredito) from pptocomprobante_det p1, pptocomprobante_cab p2 where p1.cuenta like '".$var1[$x]."%' and p1.tipo_comp=6 and p1.numerotipo=p2.numerotipo and p1.tipo_comp=p2.tipo_comp and p2.fecha>='$f1' and p2.fecha<='$f2' and p1.tipomovimiento=1 and (p1.estado=1 or p1.estado=4) and p1.vigencia=$vigencia";
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
				if($row[0]==0){$row[0]=0;}
				if($row[1]==0){$row[1]=0;}
				// echo "
				// <td>".number_format($row[0],2,",",".")."</td>
				// <td>".number_format($row[1],2,",",".")."</td>";
				echo "<td>".number_format($row[0],2,",",".")."</td>";
				$_POST[cdpd][]=$row[0]; 
				$_POST[cdpc][]=$row[1];
				$s5=$row[0];
				$s6=$row[1];
			}
			if($var1[$x]==$c5[$cont5]){
				// echo "
				// <td>".number_format($var9[$cont5],2,",",".")."</td>
				// <td>".number_format($var10[$cont5],2,",",".")."</td>";
				echo "<td>".number_format($var9[$cont5],2,",",".")."</td>";
				$_POST[rpd][]=$var9[$cont5]; 
				$_POST[rpc][]=$var10[$cont5]; 
				$s7=$var9[$cont5]; 
				$s8=$var10[$cont5]; 
				$cont5+=1;
			}else{
				$sqlr="select sum(p1.valdebito),sum(p1.valcredito) from pptocomprobante_det p1, pptocomprobante_cab p2 where p1.cuenta like '".$var1[$x]."%' and p1.tipo_comp=7 and p1.numerotipo=p2.numerotipo and p1.tipo_comp=p2.tipo_comp and p2.fecha>='$f1' and p2.fecha<='$f2' and p1.tipomovimiento=1 and p1.estado=1 and p1.vigencia=$vigencia";
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
				if($row[0]==0){$row[0]=0;}
				if($row[1]==0){$row[1]=0;}
				// echo "
				// <td>".number_format($row[0],2,",",".")."</td>
				// <td>".number_format($row[1],2,",",".")."</td>";
				echo "<td>".number_format($row[0],2,",",".")."</td>";
				$_POST[rpd][]=$row[0]; 
				$_POST[rpc][]=$row[1];
				$s7=$row[0];
				$s8=$row[1]; 
			}
			if($var1[$x]==$c6[$cont6]){
				// echo "
				// <td>".number_format($var11[$cont6],2,",",".")."</td>
				// <td>".number_format($var12[$cont6],2,",",".")."</td>";
				echo "<td>".number_format($var11[$cont6],2,",",".")."</td>";
				$_POST[cxpd][]=$var11[$cont6]; 
				$_POST[cxpc][]=$var12[$cont6];
				$s9=$var11[$cont6]; 
				$s10=$var12[$cont6]; 
				$cont6+=1;
			}else{
				$sqlr="select sum(p1.valdebito),sum(p1.valcredito) from pptocomprobante_det p1, pptocomprobante_cab p2 where p1.cuenta like '".$var1[$x]."%' and p1.tipo_comp=8 and p1.numerotipo=p2.numerotipo and p1.tipo_comp=p2.tipo_comp and p2.fecha>='$f1' and p2.fecha<='$f2' and p1.tipomovimiento=1 and p1.estado=1 and p1.vigencia=$vigencia";
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
				if($row[0]==0){$row[0]=0;}
				if($row[1]==0){$row[1]=0;}
				// echo "
				// <td>".number_format($row[0],2,",",".")."</td>
				// <td>".number_format($row[1],2,",",".")."</td>";
				echo "<td>".number_format($row[0],2,",",".")."</td>";
				$_POST[cxpd][]=$row[0]; 
				$_POST[cxpc][]=$row[1]; 
				$s9=$row[0];
				$s10=$row[1];
			}
			$_POST[cee][]=$_POST[rpd][$x]-$_POST[cxpd][$x];
			if($var1[$x]==$c7[$cont7]){
				// echo "
				// <td>".number_format($var13[$cont7],2,",",".")."</td>
				// <td>".number_format($var14[$cont7],2,",",".")."</td>";
				echo "<td>".number_format($var13[$cont7],2,",",".")."</td>";
				$_POST[egd][]=$var13[$cont7]; 
				$_POST[egc][]=$var14[$cont7]; 
				$s11=$var13[$cont7]; 
				$s12=$var14[$cont7]; 
				$cont6+=1;
			}else{
				$sqlr="select sum(p1.valdebito),sum(p1.valcredito) from pptocomprobante_det p1, pptocomprobante_cab p2 where p1.cuenta like '".$var1[$x]."%' and p1.tipo_comp=11 and p1.numerotipo=p2.numerotipo and p1.tipo_comp=p2.tipo_comp and p2.fecha>='$f1' and p2.fecha<='$f2' and p1.tipomovimiento=1 and p1.estado=1 and p1.vigencia=$vigencia";
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
				if($row[0]==0){$row[0]=0;}
				if($row[1]==0){$row[1]=0;}
				// echo "
				// <td>".number_format($row[0],2,",",".")."</td>
				// <td>".number_format($row[1],2,",",".")."</td>";
				echo "<td>".number_format($row[0],2,",",".")."</td>";
				$_POST[egd][]=$row[0]; 
				$_POST[egc][]=$row[1]; 
				$s11=$row[0];
				$s12=$row[1];
			}
			$_POST[cxp][]=$_POST[cxpd][$x]-$_POST[egd][$x];
			$saldo=$_POST[ppto][$x]-$_POST[cdpd][$x];
			$_POST[saldos][]=$saldo;
			$totalsaldos+=$saldo;
			$porcentaje=(($s2+$s4+$s6+$s8+$s10+$s12)*100)/($s1+$s3+$s5+$s7+$s9+$s11);
			$porcentaje=(int)$porcentaje;
			echo "
				<td>".number_format($saldo,2,",",".")."</td>
				<td>$porcentaje %</td>";
			echo"</tr>";
			$aux=$iter;
			$iter=$iter2;
			$iter2=$aux;
			echo "
				<input type='hidden' name='cuenta[]' id='cuenta[]' value='".$_POST[cuenta][$x]."'>
				<input type='hidden' name='nombre[]' id='nombre[]' value='".$_POST[nombre][$x]."'>
				<input type='hidden' name='pid[]' id='pid[]' value='".$_POST[pid][$x]."'>
				<input type='hidden' name='pic[]' id='pic[]' value='".$_POST[pic][$x]."'>
				<input type='hidden' name='adc[]' id='adc[]' value='".$_POST[adc][$x]."'>
				<input type='hidden' name='red[]' id='red[]' value='".$_POST[red][$x]."'>
				<input type='hidden' name='cdpd[]' id='cdpd[]' value='".$_POST[cdpd][$x]."'>
				<input type='hidden' name='cdpc[]' id='cdpc[]' value='".$_POST[cdpc][$x]."'>
				<input type='hidden' name='rpd[]' id='rpd[]' value='".$_POST[rpd][$x]."'>
				<input type='hidden' name='rpc[]' id='rpc[]' value='".$_POST[rpc][$x]."'>
				<input type='hidden' name='cxpd[]' id='cxpd[]' value='".$_POST[cxpd][$x]."'>
				<input type='hidden' name='cxpc[]' id='cxpc[]' value='".$_POST[cxpc][$x]."'>
				<input type='hidden' name='egd[]' id='egd[]' value='".$_POST[egd][$x]."'>
				<input type='hidden' name='egc[]' id='egc[]' value='".$_POST[egc][$x]."'>
				<input type='hidden' name='saldos[]' id='saldos[]' value='".$_POST[saldos][$x]."'>
				<input type='hidden' name='cred[]' id='cred[]' value='".$_POST[cred][$x]."'>
				<input type='hidden' name='contra[]' id='contra[]' value='".$_POST[contra][$x]."'>
				<input type='hidden' name='contra[]' id='contra[]' value='".$_POST[ppto][$x]."'>
				<input type='hidden' name='cxp[]' id='cxp[]' value='".$_POST[cxp][$x]."'>
				<input type='hidden' name='cee[]' id='cee[]' value='".$_POST[cee][$x]."'>
				";
		}
		echo "
			<tr class='titulos2'>
				<td ></td>
				<td ></td>
				<td >Presupuesto Inicial</td>
				<td >Adicion</td>
				<td >Reduccion</td>
				<td >Credito</td>
				<td >Contra-Credito</td>
				<td >Presupuesto Definitivo</td>
				<td >Disponibilidad</td>
				<td >Registros</td>
				<td >Obligaciones</td>
				<td >Pagos</td>
				<td >Saldo</td>
				<td ></td>
			</tr>
			<tr style='font-size:10px;'>
				<td></td>
				<td>Totales:</td>
				<td class='saludo3'>".number_format($totalpi1,2,",",".")."</td>
				<td class='saludo3'>".number_format($totalad,2,",",".")."</td>
				<td class='saludo3'>".number_format($totalred,2,",",".")."</td>
				<td class='saludo3'>".number_format($totalcred,2,",",".")."</td>
				<td class='saludo3'>".number_format($totalcontra,2,",",".")."</td>
				<td class='saludo3'>".number_format(0,2,",",".")."</td>
				<td class='saludo3'>".number_format($totalcdp1,2,",",".")."</td>
				<td class='saludo3'>".number_format($totalrp1,2,",",".")."</td>
				<td class='saludo3'>".number_format($totalob1,2,",",".")."</td>
				<td class='saludo3'>".number_format($totalpag1,2,",",".")."</td>
				<td class='saludo3'>".number_format($totalsaldos,2,",",".")."</td>
				<td></td>
			</tr>";
		
		echo "</table>";
	?> 
	</div>
	<?php
	}
	?>
</form>
</body>
</html>