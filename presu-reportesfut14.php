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
			/*
			function excell()
			{
				document.form2.action="presu-ejecuciongastosexcel.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}*/
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
  				<td colspan="3" class="cinta">
					<a class="mgbt" onClick="location.href='presu-reportesfut.php'"><img src="imagenes/add.png" title="Nuevo"/></a>
					<a class="mgbt" onClick="document.form2.submit();"><img src="imagenes/guarda.png" title="Guardar" /></a>
					<a onClick="document.form2.submit()" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a onClick="<?php echo paginasnuevas("presu");?>" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
					<a onClick="pdf()" class="mgbt"><img src="imagenes/print.png" title="imprimir" style="width:29px; height:25px;"></a>
					<a href="descargartxt.php?id=<?php echo "informefutingresos.txt"; ?>&dire=archivos" class="mgbt"><img src="imagenes/fut.png" style="width: 25px; height:25px" title="FUT"></a>
					<a href="<?php echo "archivos/".$_SESSION[usuario]."informefutingresos".$fec.".csv"; ?>" target="_blank" class="mgbt"><img src="imagenes/csv.png" title="CSV" style="width:29px; height:25px;"></a>
					<a onClick="location.href='presu-reportesfut.php'" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
				</td>
  			</tr>
		</table>
		<form name="form2" method="post" action="presu-reportesfut14.php">
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
        			<td class="titulos" colspan="6">.: FUT INGRESOS</td>
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
     		<div class="subpantallap" style="height:66.5%; width:99.6%;">
  				 <?php
  //**** para sacar la consulta del balance se necesitan estos datos ********
  //**** nivel, mes inicial, mes final, cuenta inicial, cuenta final, cc inicial, cc final  
$oculto=$_POST['oculto'];
if($_POST[oculto])
{$iter="zebra1";
$iter2="zebra2";
$sumacdp=0;
$sumarp=0;	
$sumaop=0;	
$sumap=0;			
$sumai=0;
$sumapi=0;				
$sumapad=0;	
$sumapred=0;	
$sumapcr=0;	
$sumapccr=0;
$sumasaldo=0;	
$acumula=0;					
ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
	$fechaf2=$fecha[3]."-".$fecha[2]."-".$fecha[1];	
  echo "<table class='inicio' ><tr><td colspan='17' class='titulos'>Ejecucion Cuentas $_POST[fecha] - $_POST[fecha2]</td></tr>";
	 //$nc=buscacuentap($_POST[cuenta]);
$linkbd=conectar_bd();
$cuentanp=array();
	$namearch="archivos/".$_SESSION[usuario]."informefutingresos".$fec.".csv";
	$Descriptor1 = fopen($namearch,"w+"); 
	$namearch2="archivos/informefutingresos.txt";
	$Descriptor2 = fopen($namearch2,"w+"); 	
	echo "<table class='inicio' align='center' '>
			<tr>
				<td colspan='16' class='titulos'>.: F50.2  EJECUCI&Oacute;N DE INGRESOS:</td>
			</tr>
			<tr>
				<td colspan='5'>Resultados Encontrados: $ntr</td>
			</tr>
			<tr>
				<td class='titulos2' >Codigo</td>
				<td class='titulos2' >PRESUPUESTO INICIAL</td>
				<td class='titulos2' >PRESUPUESTO DEFINITIVO</td>
				<td class='titulos2' >RECAUDO</td>
				<td class='titulos2' >SITUACION FONDOS</td>
				<td class='titulos2' >TOTAL INGRESOS</td>
				<td class='titulos2' >TIENE DOC</td>
				<td class='titulos2' >NUMERO DOC</td>
				<td class='titulos2' >PORC DESTINACION</td>
				<td class='titulos2' >VALOR DESTINACION</td>
			</tr>";	


	$mes1=substr($_POST[periodo],1,2);
	$mes2=substr($_POST[periodo],3,2);
	$_POST[fecha]='01/01/'.$vigusu;	
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

	 $sqlr="create  temporary table usr_session (id int(11),codigo varchar(100), futcoding varchar(100), presuinicial double, presudef double,recaudo double, situacion varchar(4), totingresos double, tienedoc varchar(10), numdoc varchar(10), porcdest double, valdest double)";


	 mysql_query($sqlr,$linkbd);
	$sqlr2="Select distinct cuenta, tipo, vigencia, vigenciaf from pptocuentas 
	where clasificacion LIKE '%ingresos%'  and  (vigencia='$vigusu' or vigenciaf='$vigusu') and (tipo='Auxiliar' OR tipo='auxiliar') order by cuenta";	
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
	$fechaenv=date('d-m-Y');
	$fechaenv=str_replace("-","",$fechaenv);
	fputs($Descriptor1,"S;".$_POST[codent].";".$_POST[periodo].";".$vigusu.";REPORTE_INFORMACION;$fechaenv\r\n");
	fputs($Descriptor1,"S;CODIGO;INICIAL;DEFINITIVO;RECAUDO;SITUACION FONDOS; TOTAL INGRESOS;TIENE DOC;NUMERO DOC; PORC DESTINACION; PORC DESTINACION\r\n");

	fputs($Descriptor2,"S\t".$_POST[codent]."\t".$_POST[periodo]."\t".$vigusu."\tREPORTE_INFORMACION\t$fechaenv\r\n");
	
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
	 $sqlr="Select distinct cuenta,nombre, futcoding,futsituacion,futdest  from pptocuentas where cuenta='".$pctas[$x]."' and (vigencia='$vigusu' or vigenciaf='$vigusu') and (tipo='Auxiliar' OR tipo='auxiliar')";
	 $resi=mysql_query($sqlr,$linkbd);
	 $rowi=mysql_fetch_row($resi);
	 $cuenta=$rowi[0];
	 $nomcuenta=$rowi[1];
	 $codigo=$rowi[2];	 
	 $situacion=$rowi[3];	 
	 $destino=$rowi[4];
	 if($destino=='-1')
	 {
		$destino='TRUE';
	 }
	 if($destino=='TRUE')
	 {
	  $ndoc='1';
	  $porcdest=100;
	  $valdest=0;
	 }	
	 else
	 {
	  $ndoc='NA';
	  $porcdest=0;
	  $valdest=0;
	 }
	 $acto=1;	 	 	 	 
	 
	 if($codigo=='' || $codigo=='-1')
	{	
	 $cuentanp[]=$cuenta;	
	 //echo $sqlr;
	}	
	 //*****ppto inicial ********
	//*** todos los ingresos ***
	$pini=0;
	$adicion=0;
	$pdef=0;
	$reduccion=0;
	$arregloIngresos=generaReporteIngresos($pctas[$x],$vigusu,$fechai,$fechaf,"S");
	
	$pini=$arregloIngresos[0];
	$adicion=$arregloIngresos[1];
	$reduccion=$arregloIngresos[2];
	$pdef=$pini+$adicion-$reduccion;
	$totrec=generaRecaudo($pctas[$x],$vigusu,$vigusu,$fechai,$fechaf);
 	$vitot=generaRecaudo($pctas[$x],$vigusu,$vigusu,$fechai,$fechaf);
	$i+=1;
	$acumula+=$pdef;
	$totrec=0;
	if(empty($pini) || is_null($pini)){
		$pini=0;
	}
	if(empty($pdef) || is_null($pdef)){
		$pdef=0;
	}
	if(empty($totrec) || is_null($totrec)){
		$totrec=0;
	}
	if(empty($vitot) || is_null($vitot)){
		$vitot=0;
	}
	$sqlr="insert into usr_session (id,codigo,futcoding,presuinicial,presudef,recaudo,situacion,totingresos,tienedoc,numdoc,porcdest,valdest) values($i,'".$cuenta."','".$codigo."',$pini,$pdef,$vitot,'$situacion',$totrec,'$destino','$ndoc','$porcdest',$valdest)";
	 mysql_query($sqlr,$linkbd);

	}	
	$sqlr="select DISTINCT futcoding ,situacion ,tienedoc,numdoc,porcdest, sum(presuinicial), sum(presudef), sum(recaudo),sum(totingresos),sum(valdest) from usr_session group by futcoding,situacion,tienedoc order by futcoding ";
  	$rest=mysql_query($sqlr,$linkbd);
	while($rowt=mysql_fetch_row($rest))
	{
	$codigo=$rowt[0];	
	$situacion=$rowt[1];
	$acto=1;
	$presuini=$rowt[5];	
	$predef=$rowt[6];	
	$vitot=$rowt[7];
	$destino=$rowt[2];
	$ndoc=$rowt[3];
	$porcdest=$rowt[4];
	$totrec=0;
	$vsitu=0;
	if($situacion=='S')
	 {
	 $vsitu=$vitot;
	 $vitot=0;
	 }
	 $totrec=$vitot+$vsitu;
	if(!empty($codigo) && !($presuini==0 && $predef==0 && $vitot==0) && $codigo!='-1')
	{
		echo "<tr class='$iter'><td >$codigo</td><td >".number_format($presuini,2,",",".")."</td><td >".number_format($predef,2,",",".")."</td><td >".number_format($vitot,2,",",".")."</td><td>".number_format($vsitu,2,",",".")."</td><td >".number_format($totrec,2,",",".")."</td><td >".strtolower($destino)."</td><td >$ndoc</td><td >0</td><td >$valdest</td></tr>";
		 $aux=$iter;
		 $iter=$iter2;
		 $iter2=$aux;
		 
		fputs($Descriptor1,"D;".$codigo.";".round($presuini,2).";".round($predef,2).";".round($vitot,2).";".round($vsitu,2).";".round($totrec,2).";".strtolower($destino).";$ndoc;".$porcdesti.";$valdest\r\n");
		fputs($Descriptor2,"D\t".$codigo."\t".round($presuini,2)."\t".round($predef,2)."\t".round($vitot,2)."\t".$vsitu."\t".round($totrec,2)."\t".strtolower($destino)."\t$ndoc\t$porcdest\t$valdest\r\n");
	}
	

//echo "nr:".$nr;
	}
	  echo"</table>";
	  for($d=0;$d<count($cuentanp);$d++)
	  {
		echo "<div class='saludo1'>No Parametrizada: $cuentanp[$d]</div>";  
	  }
	  fclose($Descriptor1);
	  fclose($Descriptor2);	 
}	  
?> 
			</div>
        </form>
	</body>
</html>