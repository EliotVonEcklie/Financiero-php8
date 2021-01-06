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
function agregardetalled()
{
if(document.form2.retencion.value!="" )
{ 
				document.form2.agregadetdes.value=1;
	//			document.form2.chacuerdo.value=2;
				document.form2.submit();
 }
 else {
 alert("Seleccione una retencion");
 }
}
function eliminard(variable)
{
if (confirm("Esta Seguro de Eliminar"))
  {
document.form2.eliminad.value=variable;
//eli=document.getElementById(elimina);
vvend=document.getElementById('eliminad');
//eli.value=elimina;
vvend.value=variable;
document.form2.submit();
}
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
                $informes[1]="F05-Registros PresupuestalesCDM";
                $informes[2]="F06-IngresosCDM";
                $informes[3]="F07-FuentedeRecursosCDM";
                $informes[4]="F08-ContratoPrincipalCDM";
                $informes[5]="F17A-MesaRendirCDM(ESTAMPILLAS PROCULTURA)";
                $informes[6]="F17B-MesaRendirCDM(ESTAMPILLAS PROTURISMO)";
                $informes[7]="F17C-MesaRendirCDM(ESTAMPILLAS PRODESARROLLO)";
                $informes[8]="F17D-MesaRendirCDM(ESTAMPILLAS PROUNILLANOS)";
                $informes[9]="F18-EntidadCDM";
                $informes[10]="F20-1A-NITCDM";
                $informes[11]="F20-1B-NITCDM";
                $informes[12]="F20-1C-NITConsorcioCDM";
                $informes[13]="F20-2AGR-EntidadFiducianteCDM";
                $informes[14]="F25-VigenciasCDM";
            ?>
  			<td colspan="3" class="cinta"><a href="#" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a><a href="#" class="mgbt" onClick="document.form2.submit();"><img src="imagenes/guarda.png" title="Guardar"/></a><a href="#" onClick="document.form2.submit()" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a><a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a><a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png" title="imprimir"></a><a href="<?php echo "archivos/".$_SESSION[usuario]."informecdm_".$informes[$_POST[reporte]].".csv"; ?>" target="_blank" class="mgbt"><img src="imagenes/csv.png" title="csv"></a></td>
			</tr>
		</table>
 <form name="form2" method="post" action="presu-informescdm_saldo.php">
 <?php
 $vigusu=vigencia_usuarios($_SESSION[cedulausu]);
 if($_POST[bc]!='')
			 {
			  $nresul=buscacuentapres($_POST[cuenta],2);			
			  if($nresul!='')
			   {
			  $_POST[ncuenta]=$nresul;
   			  $linkbd=conectar_bd();
			  $sqlr="select *from pptocuentaspptoinicial where cuenta=$_POST[cuenta] and vigencia=".$vigusu;
			  $res=mysql_query($sqlr,$linkbd);
			  $row=mysql_fetch_row($res);
			  $_POST[valor]=$row[5];		  
			  $_POST[valor2]=$row[5];		  			  

			   }
			  else
			  {
			   $_POST[ncuenta]="";	
			   }
			 }
 ?>
    <table  align="center" class="inicio" >
      <tr >
        <td class="titulos" colspan="6">.: Reportes CDM</td>
        <td width="74" class="cerrar"><a href="presu-principal.php">Cerrar</a></td>
      </tr>
      <tr  ><td class="saludo1">Reporte</td>
      <td>
       <select name="reporte" id="reporte">
       <option value="-1">Seleccione ....</option>
          <option value="1" <?php if($_POST[reporte]=='1') echo "selected" ?>>F05 - Registros Presupuestales CDM</option>
          <option value="2" <?php if($_POST[reporte]=='2') echo "selected" ?>>F06 - Ingresos CDM</option>
          <option value="3" <?php if($_POST[reporte]=='3') echo "selected" ?>>F07 - Fuente de Recursos CDM</option>
          <option value="4" <?php if($_POST[reporte]=='4') echo "selected" ?>>F08 - Contrato Principal CDM</option>
          <option value="5" <?php if($_POST[reporte]=='5') echo "selected" ?>>F17A - Mes a Rendir CDM (ESTAMPILLAS PROCULTURA)</option>
          <option value="6" <?php if($_POST[reporte]=='6') echo "selected" ?>>F17B - Mes a Rendir CDM (ESTAMPILLAS PROTURISMO)</option>
          <option value="7" <?php if($_POST[reporte]=='7') echo "selected" ?>>F17C - Mes a Rendir CDM (ESTAMPILLAS PRODESARROLLO)</option>
          <option value="8" <?php if($_POST[reporte]=='8') echo "selected" ?>>F17D - Mes a Rendir CDM (ESTAMPILLAS PROUNILLANOS)</option>
          <option value="9" <?php if($_POST[reporte]=='9') echo "selected" ?>>F18 - Entidad CDM</option>
          <option value="10" <?php if($_POST[reporte]=='10') echo "selected" ?>>F20-1A - NIT CDM</option>
          <option value="11" <?php if($_POST[reporte]=='11') echo "selected" ?>>F20-1B - NIT CDM</option>
          <option value="12" <?php if($_POST[reporte]=='12') echo "selected" ?>>F20-1C - NIT Consorcio CDM</option>
          <option value="13" <?php if($_POST[reporte]=='13') echo "selected" ?>>F20-2AGR - Entidad Fiduciante CDM</option>
          <option value="14" <?php if($_POST[reporte]=='14') echo "selected" ?>>F25 - Vigencias CDM</option>
        </select>
      </td>      
        <td width="88" class="saludo1">Fecha Inicial:</td>
        <td width="193"><input type="hidden" value="<?php echo $vigusu ?>" name="vigencias"><input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">         <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>        </td>
        <td width="79" class="saludo1">Fecha Final: </td>
        <td width="613"><input name="fecha2" type="text" id="fc_1198971546" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha2]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10"> <a href="#" onClick="displayCalendarFor('fc_1198971546');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>  <input type="button" name="generar" value="Generar" onClick="document.form2.submit()"> <input type="hidden" value="1" name="oculto"></td></tr>      
    </table>
     <?php
			//**** busca cuenta
			if($_POST[bc]!='')
			 {
			  $nresul=buscacuentapres($_POST[cuenta],2);
			  if($nresul!='')
			   {
			  $_POST[ncuenta]=$nresul;
			  $linkbd=conectar_bd();
			  $sqlr="select *from pptocuentaspptoinicial where cuenta=$_POST[cuenta] and vigencia=".$vigusu;
			  $res=mysql_query($sqlr,$linkbd);
			  $row=mysql_fetch_row($res);
			  $_POST[valor]=$row[5];		  
			  $_POST[valor2]=$row[5];		  			  
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
	<div class="subpantallap" style="height:65.5%; width:99.6%; overflow-x:hidden;">
  <?php
  //**** para sacar la consulta del balance se necesitan estos datos ********
  //**** nivel, mes inicial, mes final, cuenta inicial, cuenta final, cc inicial, cc final  
$oculto=$_POST['oculto'];
if($_POST[oculto])
{$linkbd=conectar_bd();
$iter='zebra1';
$iter2='zebra2';
  switch($_POST[reporte])
   {	
	case 1: //F05 - Registros Presupuestales CDM
			
		$crit1=" ";
		$crit2=" ";
		$crit3=" ";
		$crit4=" ";
		$crit5=" ";
		$_POST[nominforme]="F05 - Registros Presupuestales CDM";
 		$namearch="archivos/".$_SESSION[usuario]."informecdm_".$informes[$_POST[reporte]].".csv";
		$_POST[nombrearchivo]=$namearch;
		$Descriptor1 = fopen($namearch,"w+"); 
		fputs($Descriptor1,"(N) Numero De Registro Presupuestal,(C) Rubro Presupuestal,	(F)Fecha De Expedicion,(D)Valor,(N)Numero De Cdp,(C)Nº Contrato,(C)Objeto,(C) Contratista,(C) Nit O C.C. Contratista\r\n");
		if ($vigusu!="")
		$crit1=" and pptorp.vigencia ='$vigusu' ";
		if ($_POST[numero]!="")
		$crit2=" and pptorp.consvigencia like '%$_POST[numero]%' ";
		if ($_POST[fecha]!="" and $_POST[fecha2]!="" )
		{	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
		$fechai=$fecha[3]."-".$fecha[2]."-".$fecha[1];
		ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
		$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
		$crit3=" and pptorp.fecha between '$fechai' and '$fechaf'  ";
		}
		$sqlr="select DISTINCT *from pptorp inner join pptorp_detalle 
		where pptorp.estado<>'N' ".$crit1.$crit2.$crit3." 
		and pptorp.consvigencia=pptorp_detalle.consvigencia and pptorp.vigencia=".$vigusu." and pptorp_detalle.vigencia=".$vigusu." order by pptorp.consvigencia, pptorp_detalle.CUENTA";
		//echo $sqlr;
		$resp = mysql_query($sqlr,$linkbd);
		$ntr = mysql_num_rows($resp);
		$con=1;
		echo "<table class='inicio' align='center' width='80%'>
		<tr><td colspan='10' class='titulos'>.: F05 - REGISTROS PRESUPUESTALES CDM:</td></tr>
		<tr><td colspan='5'>Registro Presupuestal Encontrados: $ntr</td></tr>
		<tr><td class='titulos2'>RP</td><td class='titulos2' >Rubro</td>
		<td class='titulos2' >Nombre Rubro</td><td class='titulos2' >Fecha</td>
		<td class='titulos2' >SALDO</td><td class='titulos2'>CDP</td>
		<td class='titulos2' >Contrato</td><td class='titulos2'>Objeto</td>
		<td class='titulos2'>Nit Tercero</td><td class='titulos2'>Tercero</td></tr>";	
		
		while ($row =mysql_fetch_row($resp)) 
		 {
		 if($row[16]>0 )
		 {
		 $sqlr2="select pptocdp.objeto from pptocdp where pptocdp.consvigencia=$row[2] and pptocdp.vigencia=$row[0]";
		 $resp2 = mysql_query($sqlr2,$linkbd);
		 $r2 =mysql_fetch_row($resp2);
		 $nrub= buscacuentapres($row[12],2);
		 $tercero=buscatercero($row[5]);
		 if($nrub!="")
	 	 {
		 if(($row[5]!='892000812') && ($row[5]!='8920008120'))
		 {
			ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $row[4],$fecha);
	$fechaf=$fecha[1]."/".$fecha[2]."/".$fecha[3]; 
			 echo "<tr class='$iter'><td >$row[1]</td><td >$row[12]</td>
		 	<td >".str_replace(","," ",$nrub)."</td><td>".$fechaf."</td>
		 	<td >".number_format($row[16],0)."</td><td >$row[2]</td>
		 	<td >".$row[8]."</td><td >".str_replace(","," ",$r2[0])."</td>
		 	<td >$row[5]</td><td >".str_replace(","," ",$tercero)."</td></tr>";
		 	fputs($Descriptor1,$row[1].",".$row[12].",".$fechaf.",".number_format($row[16],2,".","").",".
			$row[2].",".$row[8].",".str_replace(","," ",$r2[0]).",".str_replace(","," ",$tercero).",".$row[5]."\r\n");
		 	$con+=1;
		 	$aux=$iter;
		 	$iter=$iter2;
		 	$iter2=$aux;
		  }	
	 	 }
		 }
 	}
	echo"</table>";
	fclose($Descriptor1);
	break;
	case 2:	//F06 - Ingresos CDM
	$crit3=" ";
	$crit4=" ";	
	$namearch="archivos/".$_SESSION[usuario]."informecdm_".$informes[$_POST[reporte]].".csv";
	$_POST[nombrearchivo]=$namearch;
	$Descriptor1 = fopen($namearch,"w+"); 
	fputs($Descriptor1,"(C) Codigo Rubro;(C) Descripcion Ingreso; (D) Aforo Inicial;(D) Adiciones;(D) Reducciones; (D) Aforo Definitivo;(D) Total Recaudado;(D) Saldo por Reacaudar;(J) % Recaudado\r\n");
	
	if ($_POST[fecha]!="" and $_POST[fecha2]!="" )
	{	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
	$fechaf2=$fecha[3]."-".$fecha[2]."-".$fecha[1];	
	}
	$sqlr2="Select distinct cuenta, tipo, vigencia, vigenciaf from pptocuentas 
	where (left(cuenta,1)='1' OR left(cuenta,2)='R1') and  (vigencia='".$vigusu."' or vigenciaf='$vigusu') and tipo='Auxiliar' order by cuenta";	
//echo "$sqlr2";
	$pctas=array();
	$tpctas=array();
	$pctasvig1=array();
	$pctasvig2=array();	
	$rescta=mysql_query($sqlr2,$linkbd);
	while ($row =mysql_fetch_row($rescta)) 
	 {
	  $pctas[]=$row[0];
	  $tpctas[$row[0]]=$row[1];
	  $pctasvig1[$row[0]]=$row[2];
	  $pctasvig2[$row[0]]=$row[3];
	 }	
	mysql_free_result($rescta);
	
	echo "<table class='inicio' align='center' width='80%'>
	<tr><td colspan='9' class='titulos'>.: F06 - INGRESOS CDM:</td></tr>
	<tr><td colspan='5'>Registros Encontrados: $ntr</td></tr>
	<tr><td class='titulos2'>Codigo Rubro</td><td class='titulos2'>Descripcion Rubro</td>
	<td class='titulos2' >Aforo Inicial</td><td class='titulos2' >Adiciones</td><td class='titulos2' >Reducciones</td>
	<td class='titulos2'>Aforo Definitivo</td><td class='titulos2' >Total Recaudado</td>
	<td class='titulos2'>Saldo por Recaudar</td><td class='titulos2'>% Por Recaudar</td></tr>";
	for ($x=0;$x<count($pctas);$x++) 
	 {
	  $pdef=0;
	  $pred=0;
	  $pad=0;
	  $vitot=0;
	  $sqlr3="SELECT DISTINCT
          pptocomprobante_det.cuenta,
          sum(pptocomprobante_det.valdebito),
          sum(pptocomprobante_det.valcredito)
	      FROM pptocomprobante_det, pptocomprobante_cab
    	  WHERE pptocomprobante_cab.tipo_comp = pptocomprobante_det.tipo_comp
          AND pptocomprobante_det.numerotipo = pptocomprobante_cab.numerotipo
          AND pptocomprobante_cab.estado = 1
          AND ( pptocomprobante_det.valdebito > 0
          OR pptocomprobante_det.valcredito > 0)			   
	  AND (pptocomprobante_cab.VIGENCIA=".$pctasvig1[$pctas[$x]]." or pptocomprobante_cab.VIGENCIA=".$pctasvig2[$pctas[$x]].")
	  AND (pptocomprobante_det.VIGENCIA=".$pctasvig1[$pctas[$x]]." or pptocomprobante_det.VIGENCIA=".$pctasvig2[$pctas[$x]].")
		  AND pptocomprobante_cab.fecha BETWEEN '$fechaf' AND '$fechaf2'
          AND pptocomprobante_det.tipo_comp = 1 
          AND pptocomprobante_cab.tipo_comp = 1 		  
          AND pptocomprobante_det.cuenta = '".$pctas[$x]."' 
		  GROUP BY pptocomprobante_det.cuenta
		  ORDER BY pptocomprobante_det.cuenta";
       //echo "<br>".$sqlr3;
	   $res=mysql_query($sqlr3,$linkbd);
	   $row =mysql_fetch_row($res);
	   $pi+=$row[1];
	   $pdef+=$pi;
		//*** adiciones ***
	   $sqlr3="SELECT DISTINCT
          pptocomprobante_det.cuenta,
          sum(pptocomprobante_det.valdebito),
          sum(pptocomprobante_det.valcredito)
     FROM pptocomprobante_det, pptocomprobante_cab
    WHERE     pptocomprobante_cab.tipo_comp = pptocomprobante_det.tipo_comp
          AND pptocomprobante_det.numerotipo = pptocomprobante_cab.numerotipo
          AND pptocomprobante_cab.estado = 1
          AND (   pptocomprobante_det.valdebito > 0
               OR pptocomprobante_det.valcredito > 0)			   
		AND (pptocomprobante_cab.VIGENCIA=".$pctasvig1[$pctas[$x]]." or pptocomprobante_cab.VIGENCIA=".$pctasvig2[$pctas[$x]].")
	  	AND (pptocomprobante_det.VIGENCIA=".$pctasvig1[$pctas[$x]]." or pptocomprobante_det.VIGENCIA=".$pctasvig2[$pctas[$x]].")		    AND pptocomprobante_cab.fecha BETWEEN '$fechaf' AND '$fechaf2'
          AND pptocomprobante_cab.tipo_comp = 2 
		  AND pptocomprobante_cab.tipo_comp = 2 
          AND pptocomprobante_det.cuenta = '".$pctas[$x]."' 
		  GROUP BY pptocomprobante_det.cuenta
   ORDER BY pptocomprobante_det.cuenta";
	   $res=mysql_query($sqlr3,$linkbd);
	   $row =mysql_fetch_row($res);
	   $pad+=$row[1];	 
	   $pdef+=$pad;	
	  
	   //*** reducciones ***
	   $sqlr3="SELECT DISTINCT
          pptocomprobante_det.cuenta,
          sum(pptocomprobante_det.valdebito),
          sum(pptocomprobante_det.valcredito)
     FROM pptocomprobante_det, pptocomprobante_cab
    WHERE     pptocomprobante_cab.tipo_comp = pptocomprobante_det.tipo_comp
          AND pptocomprobante_det.numerotipo = pptocomprobante_cab.numerotipo
          AND pptocomprobante_cab.estado = 1
          AND (   pptocomprobante_det.valdebito > 0
               OR pptocomprobante_det.valcredito > 0)			   		
  	  AND (pptocomprobante_cab.VIGENCIA=".$pctasvig1[$pctas[$x]]." or pptocomprobante_cab.VIGENCIA=".$pctasvig2[$pctas[$x]].")
	  AND (pptocomprobante_det.VIGENCIA=".$pctasvig1[$pctas[$x]]." or pptocomprobante_det.VIGENCIA=".$pctasvig2[$pctas[$x]].")
		  AND pptocomprobante_cab.fecha BETWEEN '$fechaf' AND '$fechaf2'
          AND pptocomprobante_cab.tipo_comp = 3 
		  AND pptocomprobante_cab.tipo_comp = 3 
          AND pptocomprobante_det.cuenta = '".$pctas[$x]."' 
		  GROUP BY pptocomprobante_det.cuenta
   ORDER BY pptocomprobante_det.cuenta";
	   $res=mysql_query($sqlr3,$linkbd);
	   $row =mysql_fetch_row($res);
	   $pred+=$row[2];	   
	   $pdef-=$pred;	 
	   //**** PRUEBA TODOS LOS INGRESOS
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
		AND (pptocomprobante_cab.VIGENCIA=".$pctasvig1[$pctas[$x]]." or pptocomprobante_cab.VIGENCIA=".$pctasvig2[$pctas[$x]].")
	    AND (pptocomprobante_det.VIGENCIA=".$pctasvig1[$pctas[$x]]." or pptocomprobante_det.VIGENCIA=".$pctasvig2[$pctas[$x]].")
		  AND pptocomprobante_cab.fecha BETWEEN '$fechaf' AND '$fechaf2'
          AND pptocomprobante_cab.tipo_comp = pptotipo_comprobante.codigo 
		  AND (pptotipo_comprobante.tipo = 'I' or pptotipo_comprobante.tipo = 'D')		   
          AND pptocomprobante_det.cuenta = '".$pctas[$x]."' 
		  GROUP BY pptocomprobante_det.cuenta
   ORDER BY pptocomprobante_det.cuenta";
	   $res=mysql_query($sqlr3,$linkbd);
	   $row =mysql_fetch_row($res);
	   $vitot+=$row[1];
	    
   	   $nrub= buscacuentapres($pctas[$x],1);
	   $porcentaje=round(100-($vitot/$pdef)*100,2);
	   $saldoporre=	$pdef-$vitot;	   	 
	 echo "<tr class='$iter'><td>".$pctas[$x]."</td><td>$nrub</td><td >$pi</td>
	 <td >$pad</td><td>$pred</td><td>$pdef</td>
	 <td>$vitot</td><td>$saldoporre</td><td>$porcentaje%</td></tr>";
	 fputs($Descriptor1,$pctas[$x].";".$nrub.";".$pi.";".$pad.";".$pred.";".$pdef.";".$vitot.";".$saldoporre.";".number_format($porcentaje,2,",","")."%\r\n");
	 $con+=1;
	 $aux=$iter;
	 $iter=$iter2;
	 $iter2=$aux;	 
   }
   fclose($Descriptor1);
	break;
	
	case 3: //F07 - Fuente de Recursos CDM
	$crit3=" ";
	$crit4=" ";	
	$namearch="archivos/".$_SESSION[usuario]."informecdm_".$informes[$_POST[reporte]].".csv";
	$_POST[nombrearchivo]=$namearch;
	$Descriptor1 = fopen($namearch,"w+"); 
	fputs($Descriptor1,"(C) Codigo;(C) Descripcion;(C) Fuente De Recursos;(D) Apropiacion Inicial;(D) Adiciones;(D) Reducciones;(D) Creditos;(D) Contracreditos;(D) Apropiacion Definitiva;(D) Compromisos;(D) Saldo Por Comprometer;(D) Obligaciones;(D) Compromisos Por Ejecutar;(D) Pagos;(D) Obligaciones Por Pagar\r\n");
	
	if ($_POST[fecha]!="" and $_POST[fecha2]!="" )
	{	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
	$fechaf2=$fecha[3]."-".$fecha[2]."-".$fecha[1];	
	}
	$sqlr2="Select distinct cuenta, tipo, vigencia, vigenciaf from pptocuentas where  (left(cuenta,1)>=2 OR (left(cuenta,1)='R' and substring(cuenta,2,1)>=2)) and  (vigencia='".$vigusu."' or vigenciaf='".$vigusu."') and tipo='Auxiliar' order by cuenta";	
//echo "$sqlr2";
	$pctas=array();
	$tpctas=array();
	$pctasvig1=array();
	$pctasvig2=array();	
	$rescta=mysql_query($sqlr2,$linkbd);
	while ($row =mysql_fetch_row($rescta)) 
	 {
	  $pctas[]=$row[0];
	  $tpctas[$row[0]]=$row[1];
	  $pctasvig1[$row[0]]=$row[2];
	  $pctasvig2[$row[0]]=$row[3];
	 }	
	mysql_free_result($rescta);
	echo "<table class='inicio' align='center' width='80%'>
	<tr><td colspan='15' class='titulos'>.: F07 - Fuente de Recursos CDM:</td></tr>
	<tr class='zebra1'><td colspan='15'>Registros Encontrados: $ntr</td></tr>
	<tr><td class='titulos2'>Codigo Rubro</td><td class='titulos2'>Descripcion Rubro</td>
	<td class='titulos2'>Fuente de Recursos</td><td class='titulos2' >Aforo Inicial</td>
	<td class='titulos2' >Adiciones</td><td class='titulos2' >Reducciones</td>
	<td class='titulos2' >Creditos</td><td class='titulos2' >Contracreditos</td>	
	<td class='titulos2'>Aforo Definitivo</td><td class='titulos2' >Compromisos</td>
	<td class='titulos2'>Saldo por Comprometer</td><td class='titulos2' >Obligaciones</td>	
	<td class='titulos2'>Compromisos por Ejecutar</td><td class='titulos2' >Pagos</td>	
	<td class='titulos2'>Obligaciones por Pagar</td></tr>";
	for ($x=0;$x<count($pctas);$x++) 
	 {
	  $pdef=0;
	  $pred=0;
	  $pad=0;
	  $vitot=0;
	  $pdef=0;
	  $rps=0;	 
	  $pagos=0;
	  $pccr=0;
	  $pcr=0;	 
	  $ops=0;
	 
	  $sqlr3="SELECT DISTINCT
          pptocomprobante_det.cuenta,
          sum(pptocomprobante_det.valdebito),
          sum(pptocomprobante_det.valcredito)
	      FROM pptocomprobante_det, pptocomprobante_cab
    	  WHERE pptocomprobante_cab.tipo_comp = pptocomprobante_det.tipo_comp
          AND pptocomprobante_det.numerotipo = pptocomprobante_cab.numerotipo
          AND pptocomprobante_cab.estado = 1
          AND ( pptocomprobante_det.valdebito > 0
          OR pptocomprobante_det.valcredito > 0)			   
	  AND (pptocomprobante_cab.VIGENCIA=".$pctasvig1[$pctas[$x]]." or pptocomprobante_cab.VIGENCIA=".$pctasvig2[$pctas[$x]].")
	  AND (pptocomprobante_det.VIGENCIA=".$pctasvig1[$pctas[$x]]." or pptocomprobante_det.VIGENCIA=".$pctasvig2[$pctas[$x]].")
		  AND pptocomprobante_cab.fecha BETWEEN '$fechaf' AND '$fechaf2'
          AND pptocomprobante_det.tipo_comp = 1 
          AND pptocomprobante_cab.tipo_comp = 1 		  
          AND pptocomprobante_det.cuenta = '".$pctas[$x]."' 
		  GROUP BY pptocomprobante_det.cuenta
		  ORDER BY pptocomprobante_det.cuenta";
       //echo "<br>".$sqlr3;
	   $res=mysql_query($sqlr3,$linkbd);
	   $row =mysql_fetch_row($res);
	   $pi+=$row[1];
	   $pdef+=$pi;
		//*** adiciones ***
	   $sqlr3="SELECT DISTINCT
          pptocomprobante_det.cuenta,
          sum(pptocomprobante_det.valdebito),
          sum(pptocomprobante_det.valcredito)
     FROM pptocomprobante_det, pptocomprobante_cab
    WHERE     pptocomprobante_cab.tipo_comp = pptocomprobante_det.tipo_comp
          AND pptocomprobante_det.numerotipo = pptocomprobante_cab.numerotipo
          AND pptocomprobante_cab.estado = 1
          AND (   pptocomprobante_det.valdebito > 0
               OR pptocomprobante_det.valcredito > 0)			   
		AND (pptocomprobante_cab.VIGENCIA=".$pctasvig1[$pctas[$x]]." or pptocomprobante_cab.VIGENCIA=".$pctasvig2[$pctas[$x]].")
	  	AND (pptocomprobante_det.VIGENCIA=".$pctasvig1[$pctas[$x]]." or pptocomprobante_det.VIGENCIA=".$pctasvig2[$pctas[$x]].")		    AND pptocomprobante_cab.fecha BETWEEN '$fechaf' AND '$fechaf2'
          AND pptocomprobante_cab.tipo_comp = 2 
		  AND pptocomprobante_cab.tipo_comp = 2 
          AND pptocomprobante_det.cuenta = '".$pctas[$x]."' 
		  GROUP BY pptocomprobante_det.cuenta
   ORDER BY pptocomprobante_det.cuenta";
	   $res=mysql_query($sqlr3,$linkbd);
	   $row =mysql_fetch_row($res);
	   $pad+=$row[1];	 
	   $pdef+=$pad;	
	  
	   //*** reducciones ***
	   $sqlr3="SELECT DISTINCT
          pptocomprobante_det.cuenta,
          sum(pptocomprobante_det.valdebito),
          sum(pptocomprobante_det.valcredito)
     FROM pptocomprobante_det, pptocomprobante_cab
    WHERE     pptocomprobante_cab.tipo_comp = pptocomprobante_det.tipo_comp
          AND pptocomprobante_det.numerotipo = pptocomprobante_cab.numerotipo
          AND pptocomprobante_cab.estado = 1
          AND (   pptocomprobante_det.valdebito > 0
               OR pptocomprobante_det.valcredito > 0)			   		
  	  AND (pptocomprobante_cab.VIGENCIA=".$pctasvig1[$pctas[$x]]." or pptocomprobante_cab.VIGENCIA=".$pctasvig2[$pctas[$x]].")
	  AND (pptocomprobante_det.VIGENCIA=".$pctasvig1[$pctas[$x]]." or pptocomprobante_det.VIGENCIA=".$pctasvig2[$pctas[$x]].")
		  AND pptocomprobante_cab.fecha BETWEEN '$fechaf' AND '$fechaf2'
          AND pptocomprobante_cab.tipo_comp = 3 
		  AND pptocomprobante_cab.tipo_comp = 3 
          AND pptocomprobante_det.cuenta = '".$pctas[$x]."' 
		  GROUP BY pptocomprobante_det.cuenta
   ORDER BY pptocomprobante_det.cuenta";
	   $res=mysql_query($sqlr3,$linkbd);
	   $row =mysql_fetch_row($res);
	   $pred+=$row[2];	   
	   $pdef-=$pred;	 
	   //*** traslados ***
	   $sqlr3="SELECT DISTINCT
          pptocomprobante_det.cuenta,
          sum(pptocomprobante_det.valdebito),
          sum(pptocomprobante_det.valcredito)
     FROM pptocomprobante_det, pptocomprobante_cab
    WHERE     pptocomprobante_cab.tipo_comp = pptocomprobante_det.tipo_comp
          AND pptocomprobante_det.numerotipo = pptocomprobante_cab.numerotipo
          AND pptocomprobante_cab.estado = 1
          AND (   pptocomprobante_det.valdebito > 0
               OR pptocomprobante_det.valcredito > 0)			   
			   AND
			   pptocomprobante_cab.VIGENCIA=$vigusu
			   and  pptocomprobante_det.VIGENCIA=$vigusu
		    AND pptocomprobante_cab.fecha BETWEEN '$fechaf' AND '$fechaf2'
          AND pptocomprobante_cab.tipo_comp = 5 
		  AND pptocomprobante_cab.tipo_comp = 5 
          AND pptocomprobante_det.cuenta = '".$pctas[$x]."' 
		  GROUP BY pptocomprobante_det.cuenta
   ORDER BY pptocomprobante_det.cuenta";
	   $res=mysql_query($sqlr3,$linkbd);
	   $row =mysql_fetch_row($res);
	   $pcr+=$row[1];	   
	   $pccr+=$row[2];	   	   
	   $pdef=$pdef+$pcr-$pccr;	 
	   	   	  
	     //*** rps ***
	   $sqlr3="SELECT DISTINCT
          pptocomprobante_det.cuenta,
          sum(pptocomprobante_det.valdebito),
          sum(pptocomprobante_det.valcredito)
     FROM pptocomprobante_det, pptocomprobante_cab
    WHERE     pptocomprobante_cab.tipo_comp = pptocomprobante_det.tipo_comp
          AND pptocomprobante_det.numerotipo = pptocomprobante_cab.numerotipo
          AND pptocomprobante_cab.estado = 1
          AND (   pptocomprobante_det.valdebito > 0
               OR pptocomprobante_det.valcredito > 0)			   
			   AND
		AND (pptocomprobante_cab.VIGENCIA=".$pctasvig1[$pctas[$x]]." or pptocomprobante_cab.VIGENCIA=".$pctasvig2[$pctas[$x]].")
	    AND (pptocomprobante_det.VIGENCIA=".$pctasvig1[$pctas[$x]]." or pptocomprobante_det.VIGENCIA=".$pctasvig2[$pctas[$x]].")
		    AND pptocomprobante_cab.fecha BETWEEN '$fechaf' AND '$fechaf2'
          AND pptocomprobante_cab.tipo_comp = 7 
		  AND pptocomprobante_cab.tipo_comp = 7 
          AND pptocomprobante_det.cuenta = '".$pctas[$x]."' 
		  GROUP BY pptocomprobante_det.cuenta
   ORDER BY pptocomprobante_det.cuenta";
	   $res=mysql_query($sqlr3,$linkbd);
	   $row =mysql_fetch_row($res);
	   $rps+=$row[1];	   
	   
//***CXP TODOS  ****
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
			   AND
		AND (pptocomprobante_cab.VIGENCIA=".$pctasvig1[$pctas[$x]]." or pptocomprobante_cab.VIGENCIA=".$pctasvig2[$pctas[$x]].")
	    AND (pptocomprobante_det.VIGENCIA=".$pctasvig1[$pctas[$x]]." or pptocomprobante_det.VIGENCIA=".$pctasvig2[$pctas[$x]].")
		    AND pptocomprobante_cab.fecha BETWEEN '$fechaf' AND '$fechaf2'
          AND pptocomprobante_cab.tipo_comp = pptotipo_comprobante.codigo 
		  AND (pptotipo_comprobante.tipo = 'C')		   
          AND pptocomprobante_det.cuenta = '".$ctaniv."' 
		  GROUP BY pptocomprobante_det.cuenta
   ORDER BY pptocomprobante_det.cuenta";
	   $res=mysql_query($sqlr3,$linkbd);
	   $row =mysql_fetch_row($res);
	   $ops+=$row[1];	
	   	   
	    //*** todos los PAGOS ***
		
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
		AND (pptocomprobante_cab.VIGENCIA=".$pctasvig1[$pctas[$x]]." or pptocomprobante_cab.VIGENCIA=".$pctasvig2[$pctas[$x]].")
	    AND (pptocomprobante_det.VIGENCIA=".$pctasvig1[$pctas[$x]]." or pptocomprobante_det.VIGENCIA=".$pctasvig2[$pctas[$x]].")
		  AND pptocomprobante_cab.fecha BETWEEN '$fechaf' AND '$fechaf2'
          AND pptocomprobante_cab.tipo_comp = pptotipo_comprobante.codigo 
		  AND (pptotipo_comprobante.tipo = 'G' or pptotipo_comprobante.tipo = 'D')		   
          AND pptocomprobante_det.cuenta = '".$pctas[$x]."' 
		  GROUP BY pptocomprobante_det.cuenta
   ORDER BY pptocomprobante_det.cuenta";
	   $res=mysql_query($sqlr3,$linkbd);
	   $row =mysql_fetch_row($res);
	   $vitot+=$row[1];
	   $fuente=explode("_",buscafuenteppto($pctas[$x],$vigusu));
   	   $nrub= buscacuentapres($pctas[$x],1);
	   $saldocomp=$pdef-$rps;	
	   $compejec=$rps-$ops;
	   $oblpagar=$ops-$vitot;   	 
//	(C) Codigo,(C) Descripcion,(C) Fuente De Recursos,(D) Apropiacion Inicial,(D) Adiciones,(D) Reducciones,(D) Creditos,(D) Contracreditos,(D) Apropiacion Definitiva,(D) Compromisos,(D) Saldo Por Comprometer,(D) Obligaciones,(D) Compromisos Por Ejecutar,(D) Pagos,(D) Obligaciones Por Pagar	   
	 echo "<tr class='$iter'><td>".$pctas[$x]."</td><td>$nrub</td><td >$fuente[0] $fuente[1]</td><td >$pi</td>
	 <td >$pad</td><td>$pred</td><td>$pcr</td><td >$pccr</td><td>$pdef</td>
	 <td >$rps</td><td>$saldocomp</td><td>$ops</td><td>$compejec</td>	 	 
	 <td>$vitot</td><td>$oblpagar</td></tr>";
	 fputs($Descriptor1,$pctas[$x].";".$nrub.";".$fuente[0].";".$pi.";".$pad.";".$pred.";".$pcr.";".$pccr.";".$pdef.";".$rps.";".$saldocomp.";".$ops.";".$compejec.";".$vitot.";".$oblpagar."\r\n");
	 $con+=1;
	 $aux=$iter;
	 $iter=$iter2;
	 $iter2=$aux;	 
   }
   fclose($Descriptor1);
	
	break;
	
	case 6://****** F17B - Mes a Rendir CDM (ESTAMPILLAS PROTURISMO)
	if ($_POST[fecha]!="" and $_POST[fecha2]!="" )
	{	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
	$fechaf2=$fecha[3]."-".$fecha[2]."-".$fecha[1];	
	}	
	$namearch="archivos/".$_SESSION[usuario]."informecdm_".$informes[$_POST[reporte]].".csv";
	$_POST[nombrearchivo]=$namearch;
	$Descriptor1 = fopen($namearch,"w+"); 
	fputs($Descriptor1,"(C) Mes A Rendir;(D) Saldo Anterior;(D) Valor Retenido;(F) Fecha De Pago;(C) Nº Recibo;(D) Valor Pagado;(D) Saldo Siguiente\r\n");
	?>
    <table class="inicio">
	 <tr> <td class="saludo1">Retenciones e Ingresos:</td>
		<td colspan="2">
		<select name="retencion"  onChange="validar()" onKeyUp="return tabular(event,this)">
		<option value="">Seleccione ...</option>
	<?php
	//PARA LA PARTE CONTABLE SE TOMA DEL DETALLE DE LA PARAMETRIZACION LAS CUENTAS QUE INICIAN EN 2**********************	
	$linkbd=conectar_bd();
	$sqlr="select *from tesoretenciones where estado='S' and terceros='1'";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
				    {
					echo "<option value='R-$row[0]' ";
					$i=$row[0];
		
					 if('R-'.$i==$_POST[retencion])
			 			{
						 echo "SELECTED";
						  $_POST[nretencion]='R - '.$row[1]." - ".$row[2];
						 }
					  echo ">R - ".$row[1]." - ".$row[2]."</option>";	 	 
					}	 	
	$sqlr="select *from tesoingresos where estado='S' and terceros='1'";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
				    {
					echo "<option value='I-$row[0]' ";
					$i=$row[0];
		
					 if('I-'.$i==$_POST[retencion])
			 			{
						 echo "SELECTED";
						  $_POST[nretencion]='I - '.$row[1]." - ".$row[2];
						 }
					  echo ">I - ".$row[1]." - ".$row[2]."</option>";	 	 
					}	 	
	?>
   </select>
		</td> <td><input type="hidden" value="<?php echo $_POST[nretencion]?>" name="nretencion"><input type="hidden" value="1" name="oculto">
		<input type="button" name="agregard" id="agregard" value="   Agregar   " onClick="agregardetalled()" ><input type="hidden" value="0" name="agregadetdes"></td></tr></table>
        <table class="inicio" style="overflow:scroll">
       <?php 	
		if ($_POST[eliminad]!='')
		 { 
		 //echo "<TR><TD>ENTROS :".$_POST[elimina]."</TD></TR>";
		 $posi=$_POST[eliminad];
		 unset($_POST[ddescuentos][$posi]);
		 unset($_POST[dndescuentos][$posi]);
		 $_POST[ddescuentos]= array_values($_POST[ddescuentos]); 
		 $_POST[dndescuentos]= array_values($_POST[dndescuentos]); 
		 }	 
		 if ($_POST[agregadetdes]=='1')
		 {
		 if(!esta_en_array($_POST[ddescuentos], $_POST[retencion]))
		  	 {
		 $_POST[ddescuentos][]=$_POST[retencion];
		 $_POST[dndescuentos][]=$_POST[nretencion];
		 $_POST[agregadetdes]='0';
			 }
			 else
			 {
			?>
			 <script>
				alert('La Retencion o Ingreso ya esta en la Lista');
	        </script>
			<?php
			 }
		 ?>
		 <script>
        document.form2.porcentaje.value=0;
        document.form2.vporcentaje.value=0;	
		document.form2.retencion.value='';	
        </script>
		<?php
		 }
		  ?>
        <tr><td class="titulos">Retenciones e Ingresos</td><td class="titulos2"><img src="imagenes/del.png" ><input type='hidden' name='eliminad' id='eliminad'></td></tr>
      	<?php
		$totaldes=0;
//		echo "v:".$_POST[valor];
		for ($x=0;$x<count($_POST[ddescuentos]);$x++)
		 {		 
		 echo "<tr><td class='saludo2'><input name='dndescuentos[]' value='".$_POST[dndescuentos][$x]."' type='text' size='100' readonly><input name='ddescuentos[]' value='".$_POST[ddescuentos][$x]."' type='hidden'></td>";		
		 echo "<td class='saludo2'><a href='#' onclick='eliminard($x)'><img src='imagenes/del.png'></a></td></tr>";	
		 }		 
		$_POST[valorretencion]=$totaldes;

		?>
        <script>
        document.form2.totaldes.value=<?php echo $totaldes;?>;		
//	calcularpago();
       document.form2.valorretencion.value=<?php echo $totaldes;?>;
        </script>
        <?php
		$_POST[valorcheque]=$_POST[valoregreso]-$_POST[valorretencion];
		?>
        </table>
        
        <table class="inicio" >
        <tr><td class="titulos">Mes</td><td class="titulos">Pago</td><td class="titulos">Fecha Pago</td><td class="titulos">Retenciones / Ingresos</td><td class="titulos">Contabilidad</td><td class="titulos">Valor</td></tr>        
      	<?php
		$_POST[mddescuentos]=array();
		$_POST[mtdescuentos]=array();		
		$_POST[mddesvalores]=array();
		$_POST[mddesvalores2]=array();		
		$_POST[mdndescuentos]=array();
		$_POST[mdctas]=array();	
		$_POST[mdmes]=array();				
		$totalpagar=0;
		//**** buscar movimientos
		for ($x=0;$x<count($_POST[ddescuentos]);$x++)
		 {	
		 $tm=strlen($_POST[ddescuentos][$x]);
		//********** RETENCIONES *********
		if(substr($_POST[ddescuentos][$x],0,1)=='R')
		  {
		 $sqlr="select distinct tesoordenpago_retenciones.id_retencion, sum(tesoordenpago_retenciones.valor),MONTH(tesoegresos.fecha) from tesoordenpago, tesoordenpago_retenciones,tesoegresos where tesoegresos.id_orden=tesoordenpago.id_orden  and tesoegresos.estado='S' and tesoegresos.fecha BETWEEN '$fechaf' AND '$fechaf2' and tesoordenpago_retenciones.id_retencion='".substr($_POST[ddescuentos][$x],2,$tm-2)."' and tesoordenpago.id_orden=tesoordenpago_retenciones.id_orden group by MONTH(tesoegresos.fecha),tesoordenpago_retenciones.id_retencion";				 	
		 $res=mysql_query($sqlr,$linkbd);		 
		// echo "$row[0] - ".$sqlr;
		while ($row =mysql_fetch_row($res)) 
	    {
		 $sqlr="select *from tesoretenciones_det where codigo='$row[0]' and vigencia='$vigusu' ";
		  $res2=mysql_query($sqlr,$linkbd);	
		 // echo "$row[0] - ".$sqlr;
		  while($row2 =mysql_fetch_row($res2))
		   {
		   if(substr($row2[2],0,1)=='2')
		    {
		   $vpor=$row2[4];
	   	   $_POST[mtdescuentos][]='R';
		   $_POST[mddesvalores][]=$row[1]*($vpor/100);
	   	   $_POST[mddesvalores2][]=$row[1]*($vpor/100);		   
		   $_POST[mddescuentos][]=$row[0];
		   $_POST[mdctas][]=$row2[2];		   
		   $_POST[mdmes][]=$row[2];		   		   
		   $_POST[mdndescuentos][]=buscaretencion($row[0]);
		   $totalpagar+=$row[1]*($vpor/100);
			}
		   }
		 }
		}
		//****** INGRESOS *******
		if(substr($_POST[ddescuentos][$x],0,1)=='I')
		  {
	$sqlr="select distinct tesoreciboscaja_det.ingreso, sum(tesoreciboscaja_det.valor), tesoreciboscaja.cuentabanco,tesoreciboscaja.cuentacaja,MONTH(tesoreciboscaja.fecha) from  tesoreciboscaja_det,tesoreciboscaja where tesoreciboscaja.estado='S' and tesoreciboscaja.fecha BETWEEN '$fechaf' AND '$fechaf2' and tesoreciboscaja_det.ingreso='".substr($_POST[ddescuentos][$x],2,$tm-2)."' and tesoreciboscaja_det.id_recibos=tesoreciboscaja.id_recibos group by MONTH(tesoreciboscaja.fecha), tesoreciboscaja_det.ingreso";
		 $res=mysql_query($sqlr,$linkbd);		 
	// echo "<br> - ".$sqlr; 
		while ($row =mysql_fetch_row($res)) 
	    {
		 $sqlr="select *from  tesoingresos_det where codigo='$row[0]' and vigencia='$vigusu'";
		  $res2=mysql_query($sqlr,$linkbd);	
		  //echo "$row[0] - ".$sqlr;
		  while($row2 =mysql_fetch_row($res2))
		   {
		   $sqlr="select *from  conceptoscontables_det where codigo='$row2[2]' and modulo='4' and tipo='C' ";
		  $res3=mysql_query($sqlr,$linkbd);	
		 // echo "$row2[1] - ".$sqlr;
		   while($row3 =mysql_fetch_row($res3))
		   {
		   if(substr($row3[4],0,1)=='2')
		    {
		   $vpor=$row2[5];
		   $_POST[mtdescuentos][]='I';
		   $_POST[mdmes][]=$row[4];		   		   		   
	   	   $_POST[mddesvalores][]=$row[1]*($vpor/100);
		   $_POST[mddesvalores2][]=$row[1]*($vpor/100);		   
		   $_POST[mddescuentos][]=$row[0];
		   $_POST[mdctas][]=$row3[4];
		   $_POST[mdndescuentos][]=buscaingreso($row[0]);
		   $totalpagar+=$row[1]*($vpor/100);		   
		   //$nv=buscaingreso($row[0]);
		   //echo "ing:$nv";
			}
		   }
		  }
		 }
		}
		
		
		//*****INGRESOS PROPIOS
		 $sqlr="select distinct tesosinreciboscaja_det.ingreso, sum(tesosinreciboscaja_det.valor), tesosinreciboscaja.cuentabanco,tesosinreciboscaja.cuentacaja,MONTH(tesosinreciboscaja.fecha) from  tesosinreciboscaja_det,tesosinreciboscaja where tesosinreciboscaja.estado='S' and MONTH(tesosinreciboscaja.fecha)='$_POST[mes]' and YEAR(tesosinreciboscaja.fecha)='".$_POST[vigencias]."' and tesosinreciboscaja_det.ingreso='".substr($_POST[ddescuentos][$x],2,$tm-2)."' and tesosinreciboscaja_det.id_recibos=tesosinreciboscaja.id_recibos group by  MONTH(tesosinreciboscaja.fecha),tesosinreciboscaja_det.ingreso ";
		 $res=mysql_query($sqlr,$linkbd);		 
	//echo "<br> - ".$sqlr;
		while ($row =mysql_fetch_row($res)) 
	    {
		 $sqlr="select *from  tesoingresos_det where codigo='$row[0]' and vigencia='$vigusu'";
		  $res2=mysql_query($sqlr,$linkbd);	
		  //echo "$row[0] - ".$sqlr;
		  while($row2 =mysql_fetch_row($res2))
		   {
		   $sqlr="select *from  conceptoscontables_det where codigo='$row2[2]' and modulo='4' and tipo='C' ";
		  $res3=mysql_query($sqlr,$linkbd);	
		 // echo "$row2[1] - ".$sqlr;
		   while($row3 =mysql_fetch_row($res3))
		   {
		   if(substr($row3[4],0,1)=='2')
		    {
		   $vpor=$row2[5];
		   $_POST[mdmes][]=$row[4];
		   $_POST[mtdescuentos][]='I';
	   	   $_POST[mddesvalores][]=$row[1]*($vpor/100);
		   $_POST[mddesvalores2][]=$row[1]*($vpor/100);		   
		   $_POST[mddescuentos][]=$row[0];
		   $_POST[mdctas][]=$row3[4];
		   $_POST[mdndescuentos][]=buscaingreso($row[0]);
		   $totalpagar+=$row[1]*($vpor/100);		   
		   //$nv=buscaingreso($row[0]);
		   //echo "ing:$nv";
			}
		   }
		  }
		 }
		 
		//********************************
		}
		for ($x=0;$x<count($_POST[mddescuentos]);$x++)
		 {		 
		 $valorpago=buscapagotercero_detalle($_POST[mddescuentos][$x],$_POST[mdmes][$x],$vigusu);
		 
		 echo "<tr  class='$iter'><td><input name='mdmes[]' value='".$_POST[mdmes][$x]."' type='text' size='15' readonly></td><td>".$valorpago[0]."</td><td>".$valorpago[1]."</td><td><input name='mdndescuentos[]' value='".$_POST[mdndescuentos][$x]."' type='text' size='100' readonly><input name='mddescuentos[]' value='".$_POST[mddescuentos][$x]."' type='hidden'><input name='mtdescuentos[]' value='".$_POST[mtdescuentos][$x]."' type='hidden'></td><td><input name='mdctas[]' value='".$_POST[mdctas][$x]."' type='text' size='15' readonly></td>";
		echo "<td><input name='mddesvalores[]' value='".round($_POST[mddesvalores][$x],0)."' type='hidden'><input name='mddesvalores2[]' value='".number_format($_POST[mddesvalores2][$x],0)."' type='text' size='15' readonly></td></tr>";
		 $aux=$iter;
		 $iter=$iter2;
		 $iter2=$aux;
		 }		 
		 $vmil=0;
		if($_POST[ajuste]=='1')
		 {
		$vmil=round($totalpagar,-3);	 
		  }
		  else
		  {
		$vmil=$totalpagar;			  
		  }
		$resultado = convertir(round($vmil,0));
		$_POST[letras]=$resultado." PESOS M/CTE";
		 echo "<tr><td></td><td>Total:</td><td><input type='hidden' name='totalpago2' value='".round($totalpagar,0)."' ><input type='text' name='totalpago' value='".number_format($totalpagar,0)."' size='15' readonly></td></tr>";
		 echo "<tr><td colspan='3'><input name='letras' type='text' value='$_POST[letras]' size='150' ></td>";
		$dif=$vmil-$totalpagar;
		?>
        <script>
        document.form2.valorpagar.value=<?php echo round($totalpagar,0);?>;	
        document.form2.valorpagarmil.value=<?php echo $vmil;?>;	
		document.form2.diferencia.value=<?php echo round($dif,0);?>;			//calcularpago();
        </script>
        </table>
        
        
	<?php
	break;
	
   }
 $sqlr="select *from pptocuentaspptoinicial where cuenta=$_POST[cuenta] and vigencia=".$vigusu;	
}
?>
</div></form></td></tr>
</table>
</body>
</html>