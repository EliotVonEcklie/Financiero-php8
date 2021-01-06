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
  				<td colspan="3" class="cinta"><a class="mgbt" onClick="location.href='presu-reportesfut.php'"><img src="imagenes/add.png" title="Nuevo"/></a><a class="mgbt" onClick="document.form2.submit();"><img src="imagenes/guarda.png" title="Guardar" /></a><a onClick="document.form2.submit()" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a><a onClick="<?php echo paginasnuevas("presu");?>" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a><a onClick="pdf()" class="mgbt"><img src="imagenes/print.png" title="imprimir" style="width:29px; height:25px;"></a><a href="descargartxt.php?id=<?php echo "EJECUCIONFONDOSALUD.txt"; ?>&dire=archivos" class="mgbt"><img src="imagenes/fut.png" style="width: 25px; height:25px" title="FUT"></a><a href="<?php echo "archivos/".$_SESSION[usuario]."EJECUCIONFONDOSALUD".$fec.".csv"; ?>" target="_blank" class="mgbt"><img src="imagenes/csv.png" title="csv" style="width:29px; height:25px;"></a><a onClick="location.href='presu-reportesfut.php'" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a></td>
  			</tr>
		</table>
		<form name="form2" method="post" action="presu-reportesfut09.php">
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
        			<td class="titulos" colspan="6">.: FUT Ejecucion del Fondo de Salud</td>
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

  echo "<table class='inicio' ><tr><td colspan='17' class='titulos'>Ejecucion Cuentas $_POST[fecha] - $_POST[fecha2]</td></tr>";
	 //$nc=buscacuentap($_POST[cuenta]);
$linkbd=conectar_bd();
$cuentanp=array();
	$namearch="archivos/".$_SESSION[usuario]."EJECUCIONFONDOSALUD".$fec.".csv";
	$Descriptor1 = fopen($namearch,"w+"); 
	$namearch2="archivos/EJECUCIONFONDOSALUD.txt";
	$Descriptor2 = fopen($namearch2,"w+"); 	
	echo "<table class='inicio' align='center' '>
			<tr>
				<td colspan='16' class='titulos'>.:FUT Ejecucion del Fondo de Salud:</td>
			</tr>
			<tr>
				<td colspan='5'>Resultados Encontrados: $ntr</td>
			</tr>
			<tr>
				<td class='titulos2' >Codigo</td>
				<td class='titulos2' >FUENTE INVERSION</td>
				<td class='titulos2' >PRESUPUESTO INICIAL</td>
				<td class='titulos2' >PRESUPUESTO DEFINITIVO</td>
				<td class='titulos2' >COMPROMISOS</td>
				<td class='titulos2' >OBLIGACIONES</td>
				<td class='titulos2' >PAGOS</td>
			</tr>";	


	$mes1=substr($_POST[periodo],1,2);
	$mes2=substr($_POST[periodo],3,2);
	$_POST[fecha]='01/01/'.$vigusu;	
	$_POST[fecha2]=intval(date("t",$mes2)).'/'.$mes2.'/'.$vigusu;	
	
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechai=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	
	
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechai=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	$linkbd=conectar_bd();
	$sqlr1="select codcontaduria from configbasica";
	$res1=mysql_query($sqlr1,$linkbd);
	$rowr=mysql_fetch_row($res1);
	$res1=$rowr[0];

	 $sqlr="create  temporary table usr_session (id int(11),codigo varchar(100), futcodfun varchar(100),unidad varchar(100),fuente varchar(100), presuinicial double, presudef double,rps double, cxp double, pagos double,cuenta varchar(100) )";
	 //Concepto	<UNIDAD_EJECUTORA>	<FUENTES_FINANCIACION>	<PRESUPUESTO_INICIAL>	<PRESUPUESTO_DEFINITIVO>	<COMPROMISOS>	<OBLIGACIONES>	<PAGOS>


	 mysql_query($sqlr,$linkbd);
	// echo "e1: ".mysql_error($linkbd);
	$sqlr2="Select distinct cuenta, tipo, vigencia, vigenciaf,clasificacion from pptocuentas where (clasificacion='inversion' OR clasificacion='reservas-gastos' or clasificacion='ingresos') and  (vigencia='".$vigusu."' or vigenciaf='$vigusu') and (tipo='Auxiliar' OR tipo='auxiliar') order by cuenta";	
 
	$pctas=array();
	$tpctas=array();
	$pctasvig1=array();
	$pctasvig2=array();	
	$clasi=array();
	$i=0;
	$rescta=mysql_query($sqlr2,$linkbd);
	while ($row =mysql_fetch_row($rescta)) 
	 {
	  $pctas[]=$row[0];
	  $tpctas[$row[0]]=$row[1];
	  $pctasvig1[$row[0]]=$row[2];
	  $pctasvig2[$row[0]]=$row[3];
	  $clasi[$row[0]]=$row[4];
	 }	
	mysql_free_result($rescta);
	
	$i=0;
	$fechaenv=date('d-m-Y');
	$fechaenv=str_replace("-","",$fechaenv);
	fputs($Descriptor1,"S;".$_POST[codent].";".$_POST[periodo].";".$vigusu.";EJECUCION_FONDO_SALUD;\r\n");
	fputs($Descriptor1,"S;CODIGO;FUENTE INVERSION;	PRESUPUESTO INICIAL;PRESUPUESTO DEFINITIVO;COMPROMISOS;  OBLIGACIONES; PAGOS\r\n");

	fputs($Descriptor2,"S\t".$_POST[codent]."\t".$_POST[periodo]."\t".$vigusu."\tEJECUCION_FONDO_SALUD\t\r\n");

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
	$sqlr="Select distinct cuenta,nombre, futinversion,futdependencias,futfuenteinv  from pptocuentas  where cuenta='".$pctas[$x]."' and (vigencia='".$vigusu."' or vigenciaf='$vigusu') and tipo='Auxiliar' ";
	//echo "<br>:".$sqlr;
	$resi=mysql_query($sqlr,$linkbd);
	$rowi=mysql_fetch_row($resi);
	$cuenta=$rowi[0];
	$nomcuenta=$rowi[1];
	$dependencia=$rowi[3];	 
	$fuentefunc=$rowi[4];
	
	
	$sq="SELECT codigo FROM futparametros WHERE cuenta='".$pctas[$x]."' AND vigencia='".$vigusu."'";
	$resul=mysql_query($sq,$linkbd);
	$ro=mysql_fetch_row($resul);
	$codigo=$ro[0];
	 if($codigo=='' || $codigo=='-1')
	{	
	 $cuentanp[]=$cuenta;	
	}	
	 //*****ppto inicial ********
	//*** todos los ingresos ***
	 $pini=0;
	 $pdef=0;
	 $prp=0;
	 $pcxp=0;
	 $ppagos=0;
	 if($clasi[$pctas[$x]]=='ingresos')
	{
		$arregloIngresos=generaReporteIngresos($pctas[$x],$vigusu,$fechai,$fechaf);
		$pini=$arregloIngresos[0];
		$pdef=$arregloIngresos[3];
		$prp=generaRecaudo($pctas[$x],$vigusu,$vigusu,$fechai,$fechaf);
	}
	else
	{
		$arreglogasto=generaReporteGastos($pctas[$x],$vigusu,$fechai,$fechaf,"N",$vigusu,$vigusu,"S");    
		$pini=$arreglogasto[0];
		$pdef=$arreglogasto[5];
		$prp=$arreglogasto[7];
		$pcxp=$arreglogasto[8];
		$ppagos=$arreglogasto[9];
	}
	 
	if(empty($pini) || is_null($pini)){
		$pini=0;
	}
	if(empty($pdef) || is_null($pdef)){
		$pdef=0;
	}
	if(empty($prp) || is_null($prp)){
		$prp=0;
	}
	if(empty($pcxp) || is_null($pcxp)){
		$pcxp=0;
	}
	if(empty($ppagos) || is_null($ppagos)){
		$ppagos=0;
	}
	 $sqlr="insert into usr_session (id,codigo , futcodfun ,unidad ,fuente , presuinicial , presudef ,rps , cxp , pagos,cuenta) values($i,'".$cuenta."','".$codigo."','".$dependencia."','".$fuentefunc."','".$pini."','".$pdef."',".$prp.",'".$pcxp."',$ppagos,'".$pctas[$x]."' )";
	 mysql_query($sqlr,$linkbd);
	//echo "e: ".mysql_error($linkbd);
	// echo "<br>".$sqlr;
	}	
	$sqlr="select DISTINCT futcodfun,unidad ,fuente, sum(presuinicial), sum(presudef), sum(rps),sum(cxp),sum(pagos),cuenta from usr_session group by futcodfun,unidad,fuente order by futcodfun ";	
//	$sqlr="select * from usr_session order by codigo ";
	// echo "<br>".$sqlr;
  	$rest=mysql_query($sqlr,$linkbd);
	while($rowt=mysql_fetch_row($rest))
	{
	$codigo=$rowt[0];	
	$unidad=$rowt[1];
	$presuini=$rowt[3];	
	$predef=$rowt[4];	
	$rps=$rowt[5];
	$fuente=$rowt[2];
	$cxps=$rowt[6];
	$pagos=$rowt[7];
	$cuenta=$rowt[8];
	if(!empty($codigo) && !($presuini==0 && $predef==0 && $rps==0 && $cxps==0 && $pagos==0) && $codigo!='-1'){
		echo "<tr class='$iter'><td >$codigo</td><td >$fuente</td><td >".number_format($presuini,2,",",".")."</td><td >".number_format($predef,2,",",".")."</td><td >".number_format($rps,2,",",".")."</td><td>".number_format($cxps,2,",",".")."</td><td >".number_format($pagos,2,",",".")."</td></tr>";
	 $aux=$iter;
	 $iter=$iter2;
	 $iter2=$aux;
   	fputs($Descriptor1,"D;".$codigo.";".$fuente.";".round($presuini,0).";".round($predef,0).";".round($rps,0).";".round($cxps,0).";".round($pagos,0)."\r\n");
   	fputs($Descriptor2,"D\t".$codigo."\t".$fuente."\t".round($presuini,0)."\t".round($predef,0)."\t".round($rps,0)."\t".round($cxps,0)."\t".round($pagos,0)."\r\n");
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