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
function buscacta(e)
 {
if (document.form2.cuenta.value!="")
{
 document.form2.bc.value=2;
 document.form2.submit();
 }
 }
//************* ver reporte ************
//***************************************
function verep(idfac)
{
  document.form1.oculto.value=idfac;
  document.form1.submit();
  }
//************* genera reporte ************
//***************************************
function genrep(idfac)
{
  document.form2.oculto.value=idfac;
  document.form2.submit();
  }
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
  				<td colspan="3" class="cinta"><a href="#" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a><a href="#" class="mgbt" onClick="document.form2.submit();"><img src="imagenes/guarda.png" title="Guardar"/></a><a href="#" onClick="document.form2.submit()" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a><a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a><a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png" title="imprimir"></a><a href="#" onClick="excell()" class="mgbt"><img src="imagenes/excel.png" title="excel"></a><a href="<?php echo "archivos/".$_SESSION[usuario]."ejecuciongastos.csv"; ?>" target="_blank" class="mgbt"><img src="imagenes/csv.png"  title="csv"></a><a href="presu-reportesfut.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a></td>
          	</tr>
		</table>
 <form name="form2" method="post" action="">
 <?php
  $linkbd=conectar_bd();
 $vigusu=vigencia_usuarios($_SESSION[cedulausu]);
$vigencia=$vigusu;
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
         <td class="titulos" colspan="6">.: Reportes CGR</td>
        <td width="74" class="cerrar"><a href="presu-principal.php">&nbsp;Cerrar</a></td>
      </tr>
      <tr><td class='saludo1'>
		Periodos
		</td>
		<td>
		<select name="periodos" id="periodos" onChange="validar()"  style="width:45%;" >
      					<option value="">Sel..</option>
	  					<?php	  
  	  						$sqlr="Select * from chip_periodos  where estado='S' order by id";		
							$resp = mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($resp)) 
							{
		 						if($row[0]==$_POST[periodos])
		 						{
			 						echo "<option value=$row[0] SELECTED>$row[2]</option>";
			 						$_POST[periodo]=$row[1]; 
			 						$_POST[cperiodo]=$row[2]; 	
								}
								else {echo "<option value=$row[0]>$row[2]</option>";}
							}
							?>
      	</select><input type="hidden" name="periodo" value="<?php echo $_POST[periodo]?>">
                    <input type="text" name="cperiodo" value="<?php echo $_POST[cperiodo]?>"  style="width:45%;" readonly>
		</td>
		<td class="saludo3" style="width:11%;">Codigo Entidad</td>
                <td><input name="codent" type="text" value="<?php echo $_POST[codent]?>">		        <input type="button" name="generar" value="Generar" onClick="document.form2.submit()"> <input type="hidden" value="1" name="oculto"></td></tr>        
    </table>
     <?php
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
	<div class="subpantallap" style="height:66.6%; width:99.6%; ">
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
ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
	$fechaf2=$fecha[3]."-".$fecha[2]."-".$fecha[1];	
  echo "<table class='inicio' ><tr><td colspan='17' class='titulos'>Ejecucion Cuentas $_POST[fecha] - $_POST[fecha2]</td></tr>";
	 //$nc=buscacuentap($_POST[cuenta]);
$linkbd=conectar_bd();
$cuentanp=array();
	$namearch="archivos/".$_SESSION[usuario]."informecgr".$fec.".csv";
	$Descriptor1 = fopen($namearch,"w+"); 
	$namearch2="archivos/".$informes[$_POST[reporte]].".txt";
	$Descriptor2 = fopen($namearch2,"w+"); 	
	echo "<table class='inicio' align='center' '><tr><td colspan='16' class='titulos'>.: F50.2  EJECUCI&Oacute;N DE INGRESOS:</td></tr><tr><td colspan='5'>Resultados Encontrados: $ntr</td></tr>

		<tr>
			<td class='titulos2' >Codigo</td>
			<td class='titulos2' >Nombre</td>
			<td class='titulos2' >Fuente</td>
			<td class='titulos2' >Nombre</td>
			<td class='titulos2' >Nombre</td>
			<td class='titulos2' >Codigo</td>
			<td class='titulos2' >Nombre</td>
			<td class='titulos2' >Fuente</td>
			<td class='titulos2' >Nombre</td>
			<td class='titulos2' >Nombre</td>
			<td class='titulos2' >Codigo</td>
			<td class='titulos2' >Nombre</td>
			<td class='titulos2' >Fuente</td>
			
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
	// echo "e1: ".mysql_error($linkbd);
	$sqlr2="Select distinct cuenta, tipo, vigencia, vigenciaf from pptocuentas 
	where (clasificacion='deuda') and  (vigencia='".$vigusu."' or vigenciaf='$vigusu') and tipo='Auxiliar' order by cuenta";	
//echo "$sqlr2";
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
	fputs($Descriptor1,"S;".$_POST[codent].";".$_POST[periodo].";".$vigusu.";EJECUCIONDEINGRESOS\r\n");
	//fputs($Descriptor1,"S;$res1; 1$mesini$mesfinal; $vigusu; PROGRAMACION DE INGRESOS; ".date("Y-m-d")." \r\n");
	//fputs($Descriptor1,"D; Codigo; Recurso; Origen; Destino; Situacion de Fondos; Acto Admin; Inicial; Adicion; Reduccion; Creditos; Contracredito; Aplazamientos; Desplazamientos; Definitivo\r\n");
	fputs($Descriptor2,"S\t".$_POST[codent]."\t".$_POST[periodo]."\t".$vigusu."\tEJECUCIONDEINGRESOS\r\n");
	
	/*fputs($Descriptor1,"S;$res1; 1$mesini$mesfinal; $vigusu; EJECUCION DE INGRESOS; ".date("Y-m-d")." \r\n");
	fputs($Descriptor1,"D; Codigo; Recurso; Origen; Destino; Situacion de Fondos; Acto Admin; Inicial; Adicion; Reduccion; Creditos; Contracredito; Aplazamientos; Desplazamientos; Definitivo\r\n");
	fputs($Descriptor2,"S\t$res1\t 1$mesini$mesfinal\t $vigusu\t EJECUCION DE INGRESOS\t ".date("Y-m-d")." \r\n");
	//fputs($Descriptor2,"D| Codigo| Recurso| Origen| Destino| Situacion de Fondos| Acto Admin| Inicial| Adicion| Reduccion| Creditos| Contracredito| Aplazamientos| Desplazamientos| Definitivo\r\n");*/
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
	 $sqlr="Select distinct cuenta,nombre, futtipodeuda  from pptocuentas where cuenta='".$pctas[$x]."' and (vigencia='".$vigusu."' or vigenciaf='$vigusu') and tipo='Auxiliar' ";
	 //echo $sqlr;
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
	 
	 if($codigo=='' || $codigo=='-1')
	{	
	 $cuentanp[]=$cuenta;	
	 //echo $sqlr;
	}	
	 //*****ppto inicial ********
	$vitot=0; 
	   //*** todos los ingresos ***
	 $sqlr3="SELECT DISTINCT
          pptocomprobante_det.cuenta,
          sum(pptocomprobante_det.valdebito),
          sum(pptocomprobante_det.valcredito)
     FROM pptocomprobante_det, pptocomprobante_cab, pptotipo_comprobante
    WHERE     pptocomprobante_cab.tipo_comp = pptocomprobante_det.tipo_comp
          AND pptocomprobante_det.numerotipo = pptocomprobante_cab.numerotipo
          AND pptocomprobante_cab.estado = 1
          AND (   pptocomprobante_det.valdebito > 0
               OR pptocomprobante_det.valcredito > 0)			   
AND(pptocomprobante_cab.VIGENCIA=".$pctasvig1[$pctas[$x]]." or pptocomprobante_cab.VIGENCIA=".$pctasvig2[$pctas[$x]].")
	  AND(pptocomprobante_det.VIGENCIA=".$pctasvig1[$pctas[$x]]." or pptocomprobante_det.VIGENCIA=".$pctasvig2[$pctas[$x]].")
		    AND pptocomprobante_cab.fecha BETWEEN '' AND '$fechaf'
          AND pptocomprobante_cab.tipo_comp = pptotipo_comprobante.codigo 
		  AND (pptotipo_comprobante.tipo = 'I' or pptotipo_comprobante.tipo = 'D')		   
          AND pptocomprobante_det.cuenta = '".$pctas[$x]."' 
		  GROUP BY pptocomprobante_det.cuenta
   ORDER BY pptocomprobante_det.cuenta";
	   $res=mysql_query($sqlr3,$linkbd);
	   $row =mysql_fetch_row($res);
	   $vitot+=$row[1];	
		 //echo "<br>".$sqlr3;
	$definitivo=$vitot;	
	$i+=1;
	 $sqlr="insert into usr_session (id,codigo ,nombre,fuente ,inicial, definitivo , compromisos,obligaciones,pagos) values($i,'".$codigo."','".$recurso."','".$origen."','".$destino."','".$situacion."','1','".$tercero."',1,".$vitot.",0,0,0,0)";
	 mysql_query($sqlr,$linkbd);
	//echo "e: ".mysql_error($linkbd);
	// echo "<br>".$sqlr;
	}	
$sqlr="select DISTINCT codigo ,recurso ,origen ,destino ,situacion , entidad,  sum(definitivo)  from usr_session group by codigo,recurso,origen,destino,entidad order by codigo ";

//	$sqlr="select * from usr_session order by codigo ";
	// echo "<br>".$sqlr;
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

	//$codigo=$rowt[1];						
	echo "<tr class='$iter'><td >$codigo</td><td >$recurso</td><td >$origen</td><td>$destino</td><td >$situacion</td><td >1</td><td >$tercero</td><td >1</td><td >".number_format($vitot,"2",",",".")."</td><td >0</td><td >0</td><td>0</td><td >0</td></tr>";
	 $aux=$iter;
	 $iter=$iter2;
	 $iter2=$aux;
   	fputs($Descriptor1,"D;".$codigo.";".$recurso.";".$origen.";".$destino.";".$situacion.";1;".$tercero.";1;".$vitot.";0;0;0;0\r\n");
   	fputs($Descriptor2,"D\t".$codigo."\t".$recurso."\t".$origen."\t".$destino."\t".$situacion."\t1\t".$tercero."\t1\t".$vitot."\t0\t0\t0\t0\r\n");

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
</div></form>
</body>
</html>