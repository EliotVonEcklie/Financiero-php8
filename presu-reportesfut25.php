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
			function pdf()
			{
				document.form2.action="pdfejecuciongastos.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function excell()
			{
				document.form2.action="presu-ejecuciongastosexcel.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
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
				<?php
					$informes=array();
					$informes[1]="538";
					$informes[2]="539";
					$informes[3]="540";
					$informes[4]="541";
					$informes[5]="543";
					$informes[6]="544";
                ?>
  				<td colspan="3" class="cinta"><a class="mgbt" onClick="location.href='presu-reportesfut.php'"><img src="imagenes/add.png" title="Nuevo"/></a><a class="mgbt" onClick="document.form2.submit();"><img src="imagenes/guarda.png" title="Guardar" /></a><a onClick="document.form2.submit()" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a><a onClick="<?php echo paginasnuevas("presu");?>" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a><a onClick="pdf()" class="mgbt"><img src="imagenes/print.png" title="imprimir" style="width:29px; height:25px;"></a><a href="descargartxt.php?id=<?php echo "informecgr.txt"; ?>&dire=archivos" class="mgbt"><img src="imagenes/csv.png" title="excel"></a><a href="<?php echo "archivos/".$_SESSION[usuario]."informecgr".$fec.".csv"; ?>" target="_blank" class="mgbt"><img src="imagenes/excel.png" title="csv" style="width:29px; height:25px;"></a><a onClick="location.href='presu-reportesfut.php'" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a></td>
  			</tr>
		</table>
		<form name="form2" method="post" action="presu-reportesfut25.php">
 			<?php
  				$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
 				if($_POST[bc]!='')
			 	{
			  		$nresul=buscacuentapres($_POST[cuenta],2);			
			  		if($nresul!='')
			   		{
			  			$_POST[ncuenta]=$nresul;
					  	$sqlr="select *from pptocuentaspptoinicial where cuenta='$_POST[cuenta]' and vigencia='$vigusu'";
					  	$res=mysql_query($sqlr,$linkbd);
					  	$row=mysql_fetch_row($res);
					  	$_POST[valor]=$row[5];		  
					  	$_POST[valor2]=$row[5];		  			  
			  		}
			  		else {$_POST[ncuenta]="";}
				}
			 	$sqlr="select *from configbasica where estado='S'";
				$res=mysql_query($sqlr,$linkbd);
				while($row=mysql_fetch_row($res))
	 			{
  					$_POST[nitentidad]=$row[0];
  					$_POST[entidad]=$row[1];
					$_POST[codent]=$row[8];
 				 }
			?>
    		<table  align="center" class="inicio" >
      			<tr>
        			<td class="titulos" colspan="6">.: SGR INGRESOS</td>
        			<td class="cerrar" style="width:7%;"><a onClick="location.href='presu-principal.php'">&nbsp;Cerrar</a></td>
     	 		</tr>
      			<tr>
					<td class='saludo1'>Periodos</td>
					<td>
						<select name="periodos" id="periodos" onChange="validar()" style="width:45%;" >
      						<option value="">Sel..</option>
	  						<?php	  
  	  							$sqlr="Select * from chip_periodos  where estado='S' order by id";		
								$resp = mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($resp)) 
								{
									if($row[0]==$_POST[periodos])
									{
										echo "<option value='$row[0]' SELECTED>$row[2]</option>";
										$_POST[periodo]=$row[1]; 
										$_POST[cperiodo]=$row[2]; 	
									}
									else {echo "<option value='$row[0]'>$row[2]</option>";}
								}
							?>
      					</select>
                        <input type="hidden" name="periodo" value="<?php echo $_POST[periodo]?>">
                    	<input type="text" name="cperiodo" value="<?php echo $_POST[cperiodo]?>"  style="width:45%;" readonly>
					</td>
					<td class="saludo3" style="width:11%;">Codigo Entidad</td>
                	<td>
                    	<input name="codent" type="text" value="<?php echo $_POST[codent]?>">		
        				<input type="button" name="generar" value="Generar" onClick="document.form2.submit()"> 
                        <input type="hidden" value="1" name="oculto">
                  	</td>
           		</tr>      
    		</table>
     		<?php
				if($_POST[bc]!='')//**** busca cuenta
				{
			  		$nresul=buscacuentapres($_POST[cuenta],2);
			  		if($nresul!='')
			   		{
			  			$_POST[ncuenta]=$nresul;
			  			$sqlr="select * from pptocuentaspptoinicial where cuenta='$_POST[cuenta]' and vigencia='$vigusu' and vigenciaf='$vigusu'";
			  			$res=mysql_query($sqlr,$linkbd);
			 			$row=mysql_fetch_row($res);
			  			$_POST[valor]=$row[5];		  
			  			$_POST[valor2]=$row[5];		  			  
  			  			echo "<script>document.form2.fecha.focus(); document.form2.fecha.select();</script>";
			  		}
			 		else
			 		{
			 			$_POST[ncuenta]="";
			 			echo "<script>alert('Cuenta Incorrecta');document.form2.cuenta.focus();</script>";
			  		}
			 	}
			?>
			<div class="subpantallap" style="height:66.5%; width:99.6%;">
  				<?php
					$oculto=$_POST['oculto'];
					$iter="zebra1";
					$iter2="zebra2";
					if($_POST[oculto])
					{
						$cuentanp=array();
						$namearch="archivos/".$_SESSION[usuario]."informecgr".$fec.".csv";
						$Descriptor1 = fopen($namearch,"w+"); 
						$namearch2="archivos/informecgr.txt";
						$Descriptor2 = fopen($namearch2,"w+"); 	
						echo "
						<table class='inicio' align='center' '>
							<tr><td colspan='16' class='titulos'>.: F50.2  EJECUCI&Oacute;N DE INGRESOS:</td></tr>
							<tr><td colspan='5'>Resultados Encontrados: $ntr</td></tr>
							<tr>
								<td class='titulos2'>Codigo</td>
								<td class='titulos2'>Recurso</td>
								<td class='titulos2'>Origen</td>
								<td class='titulos2' >Destino</td>
								<td class='titulos2'>Situacion de Fondos</td>
								<td class='titulos2'>No Reg Recaudos</td>
								<td class='titulos2'>Entidad Reciproca</td>
								<td class='titulos2'>Acto Admin</td>
								<td class='titulos2'>Recaudos</td>
								<td class='titulos2'>Devoluciones</td>
								<td class='titulos2'>Reversion Recaudos</td>
								<td class='titulos2'>Recaudos Vig Anteriores</td>
								<td class='titulos2'>REVERSION DE RECAUDOS DE VIGENCIAS ANT. (Dif de ingresos tributarios)</td>
							</tr>";	
						$mes1=substr($_POST[periodo],1,2);
						$mes2=substr($_POST[periodo],3,2);
						$_POST[fecha]='01'.'/'.$mes1.'/'.$vigusu;	
						$_POST[fecha2]=intval(date("t",$mes2)).'/'.$mes2.'/'.$vigusu;	
						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
						$fechai=$fecha[3]."-".$fecha[2]."-".$fecha[1];
						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
						$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
						$linkbd=conectar_bd();
						$sqlr1="select codcontaduria from configbasica";
						$res1=mysql_query($sqlr1,$linkbd);
						$rowr=mysql_fetch_row($res1);
						$res1=$rowr[0];
	 					$sqlr="create  temporary table usr_session (id int(11),codigo varchar(100),recurso varchar(10),origen varchar(10),destino varchar(10),situacion varchar(10),nreg varchar(10), entidad varchar(50), acto varchar(5),definitivo double, devoluciones double, reversiones double, recvigant double, revrecvigant double)";
						mysql_query($sqlr,$linkbd);
						$sqlr2="Select distinct cuenta, tipo, vigencia, vigenciaf from pptocuentas where clasificacion='ingresos' and  (vigencia='$vigusu' or vigenciaf='$vigusu') and tipo='Auxiliar' order by cuenta";	
						$pctas=array();
						$tpctas=array(); 
						$pctasvig1=array();
						$pctasvig2=array();	
						$i=0;
						$rescta=mysql_query($sqlr2,$linkbd);   
						while ($row =mysql_fetch_row($rescta)) 
	 					{
							$pctas[]=$row[0];
							$tpctas[$row[0]]=$row[1];
						  	$pctasvig1[$row[0]]=$row[2];
						  	$pctasvig2[$row[0]]=$row[3];
	 					}	
						mysql_free_result($rescta);
						$i=0;
						fputs($Descriptor1,"S;".$_POST[codent].";".$_POST[periodo].";".$vigusu.";FUT_INGRESOS\r\n");
						fputs($Descriptor2,"S\t".$_POST[codent]."\t".$_POST[periodo]."\t".$vigusu."\tFUT_INGRESOS\r\n");
						for($x=0;$x<count($pctas);$x++)
 						{
							$crit1=" ";
							$crit2=" ";
							$crit3=" ";
							$crit4=" ";
							$crit5=" ";
							$adicion=0;
							$pi=0;
							$reduccion=0;
							$cuentas=$row[0];
							//**** codigo
	 						$sqlr="Select distinct cuenta,nombre, futcoding  from pptocuentas where cuenta='".$pctas[$x]."' and (vigencia='".$vigusu."' or vigenciaf='$vigusu') and tipo='Auxiliar' ";
	 						$resi=mysql_query($sqlr,$linkbd);
							$rowi=mysql_fetch_row($resi);
							$cuenta=$rowi[0];
							$nomcuenta=$rowi[1];
							$codigo=$rowi[2];
							$recurso=$rowi[3];
							$origen=$rowi[4];
							$destino=$rowi[5];
							$tercero=$rowi[6];
							$situacion=$rowi[10];	 
							$acto=1;	 	 	 	 
	 						if($codigo=='' || $codigo=='-1'){$cuentanp[]=$cuenta;}	
							//*****ppto inicial ********
	 						$sqlr3="
							SELECT DISTINCT
          						pptocomprobante_det.cuenta,
								sum(pptocomprobante_det.valdebito),
							  	sum(pptocomprobante_det.valcredito)
     						FROM 
								pptocomprobante_det, 
								pptocomprobante_cab
    						WHERE     
								pptocomprobante_cab.tipo_comp = pptocomprobante_det.tipo_comp = '1'
          						AND pptocomprobante_det.numerotipo = pptocomprobante_cab.numerotipo
         						AND pptocomprobante_cab.estado = 1
          						AND (pptocomprobante_det.valdebito > 0 OR pptocomprobante_det.valcredito > 0)			   
								AND(pptocomprobante_cab.VIGENCIA=".$pctasvig1[$pctas[$x]]." or pptocomprobante_cab.VIGENCIA=".$pctasvig2[$pctas[$x]].")
	  							AND(pptocomprobante_det.VIGENCIA=".$pctasvig1[$pctas[$x]]." or pptocomprobante_det.VIGENCIA=".$pctasvig2[$pctas[$x]].")
		   						AND pptocomprobante_cab.fecha BETWEEN '' AND '$fechaf'		   
          						AND pptocomprobante_det.cuenta = '".$pctas[$x]."' 
		  					GROUP BY 
								pptocomprobante_det.cuenta
  							ORDER BY 
								pptocomprobante_det.cuenta";
							$res=mysql_query($sqlr3,$linkbd);
	   						$row =mysql_fetch_row($res);
							$vitot=0; 
	  						//*** todos los ingresos ***
	 						$sqlr3="
							SELECT DISTINCT
          						pptocomprobante_det.cuenta,
								sum(pptocomprobante_det.valdebito),
								sum(pptocomprobante_det.valcredito)
     						FROM 
								pptocomprobante_det, 
								pptocomprobante_cab, 
								pptotipo_comprobante
    						WHERE     
								pptocomprobante_cab.tipo_comp = pptocomprobante_det.tipo_comp
          						AND pptocomprobante_det.numerotipo = pptocomprobante_cab.numerotipo
          						AND pptocomprobante_cab.estado = 1
          						AND (   pptocomprobante_det.valdebito > 0 OR pptocomprobante_det.valcredito > 0)			   
								AND(pptocomprobante_cab.VIGENCIA=".$pctasvig1[$pctas[$x]]." or pptocomprobante_cab.VIGENCIA=".$pctasvig2[$pctas[$x]].")
	  							AND(pptocomprobante_det.VIGENCIA=".$pctasvig1[$pctas[$x]]." or pptocomprobante_det.VIGENCIA=".$pctasvig2[$pctas[$x]].")
		    					AND pptocomprobante_cab.fecha BETWEEN '' AND '$fechaf'
          						AND pptocomprobante_cab.tipo_comp = pptotipo_comprobante.codigo 
		  						AND (pptotipo_comprobante.tipo = 'I' or pptotipo_comprobante.tipo = 'D')		   
          						AND pptocomprobante_det.cuenta = '".$pctas[$x]."' 
		  					GROUP BY 
								pptocomprobante_det.cuenta
  							ORDER BY 
							 	pptocomprobante_det.cuenta";
	   						$res=mysql_query($sqlr3,$linkbd);
	   						$row =mysql_fetch_row($res);
	   						$vitot+=$row[1];	
							$definitivo=$vitot;	
							$i+=1;
	 						$sqlr="insert into usr_session (id,codigo ,recurso ,origen ,destino ,situacion ,nreg , entidad , acto ,definitivo , devoluciones , reversiones , recvigant ,   revrecvigant) values($i,'".$codigo."','".$recurso."','".$origen."','".$destino."','".$situacion."','1','".$tercero."',1,".$vitot.",0,0,0,0)";
	 						mysql_query($sqlr,$linkbd);
						}	
						$sqlr="select DISTINCT codigo ,recurso ,origen ,destino ,situacion , entidad,  sum(definitivo)  from usr_session group by codigo,recurso,origen,destino,entidad order by codigo ";
  						$rest=mysql_query($sqlr,$linkbd);
						while($rowt=mysql_fetch_row($rest))
						{
							$codigo=$rowt[0];
							$recurso=$rowt[1];
							$origen=$rowt[2];
							$destino=$rowt[3];
							$situacion=$rowt[4];
							$acto=1;
							$vitot=$rowt[6];
							$tercero=$rowt[5];
							echo "
							<tr class='$iter'>
								<td >$codigo</td>
								<td >$recurso</td>
								<td >$origen</td>
								<td>$destino</td>
								<td >$situacion</td>
								<td >1</td>
								<td >$tercero</td>
								<td >1</td>
								<td >".number_format($vitot,"2",",",".")."</td>
								<td >0</td>
								<td >0</td>
								<td>0</td>
								<td >0</td>
							</tr>";
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux;
   							fputs($Descriptor1,"D;".$codigo.";".$recurso.";".$origen.";".$destino.";".$situacion.";1;".$tercero.";1;".$vitot.";0;0;0;0\r\n");
   							fputs($Descriptor2,"D\t".$codigo."\t".$recurso."\t".$origen."\t".$destino."\t".$situacion."\t1\t".$tercero."\t1\t".$vitot."\t0\t0\t0\t0\r\n");
						}
	  					echo"</table>";
	  					for($d=0;$d<count($cuentanp);$d++)
	  					{echo "<div class='saludo1'>No Parametrizada: $cuentanp[$d]</div>";}
	  					fclose($Descriptor1);
	  					fclose($Descriptor2);	  
					}//oculto
				?> 
			</div>
        </form>
	</body>
</html>