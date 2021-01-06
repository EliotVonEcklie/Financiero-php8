<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	sesion();
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
<title>:: Spid - Gestion Humana</title>
<script>
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

//************* genera reporte ************
//***************************************
function guardar()
{
if (document.form2.tperiodo.value!='' && document.form2.periodo.value!='')
  {
	if (confirm("Esta Seguro de Guardar"))
  	{
  	document.form2.oculto.value=2;
  	document.form2.submit();
  	}
  }
  else{
  alert('Faltan datos para completar el registro');
  }
 }

function validar(formulario)
{
//document.form2.cperiodo.value='1';	
document.form2.cperiodo.value='2';
document.form2.action="hum-liquidarnominaaprobar.php";
document.form2.submit();
}

function cleanForm()
{
document.form2.nombre1.value="";
document.form2.nombre2.value="";
document.form2.apellido1.value="";
document.form2.apellido2.value="";
document.form2.documento.value="";
document.form2.codver.value="";
document.form2.telefono.value="";
document.form2.direccion.value="";
document.form2.email.value="";
document.form2.web.value="";
document.form2.celular.value="";
document.form2.razonsocial.value="";
}

//************* genera reporte ************
//***************************************
function marcar(indice,posicion)
{
vvigencias=document.getElementsByName('empleados[]');
vtabla=document.getElementById('fila'+indice);
clase=vtabla.className;
//alert(' este '+indice+' ch '+posicion);
	 if(vvigencias.item(posicion).checked)
	 {
		//alert(' este '+indice+' ch '+indice);
		vtabla.style.backgroundColor='#3399bb'; 
	 }
	 else
	 {
		e=vvigencias.item(posicion).value;
		//alert(' este '+indice+' sch '+indice);
		document.getElementById('fila'+e).style.backgroundColor='#ffffff';
	 }
	 sumarconc();
 }

function excell()
{
document.form2.action="hum-liquidarnominaexcel.php";
document.form2.target="_BLANK";
document.form2.submit(); 
document.form2.action="";
document.form2.target="";
}
</script>
<script type="text/javascript" src="css/calendario.js"></script>
<script type="text/javascript" src="css/programas.js"></script>
<link href="css/css2.css" rel="stylesheet" type="text/css" />
<link href="css/css3.css" rel="stylesheet" type="text/css" />
<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
    <tr><script>barra_imagenes("hum");</script><?php cuadro_titulos();?></tr>	 
    <tr><?php menu_desplegable("hum");?></tr><tr>
  <td colspan="3" class="cinta"><a href="hum-liquidarnominaaprobar.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a><a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a><a onClick="document.form2.submit();" href="hum-buscaliquidacion.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a><a href="#" onClick="mypop=window.open('hum-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="nueva ventana"></a><a href="#" onClick='excell()' class="mgbt"><img src="imagenes/excel.png"  title="excel"> </a></td></tr>	
  		</table>
<tr><td colspan="3" class="tablaprin"> 
 <form name="form2" method="post" action="">
<?php
$linkbd=conectar_bd();
	if(!$_POST[oculto])
	{
	$linkbd=conectar_bd();
	$sqlr="select max(id_nom) from humnomina";
		$res=mysql_query($sqlr,$linkbd);
		$consec=0;
		while($r=mysql_fetch_row($res))
		 {
		  $consec=$r[0];	  
	 	}
	 	$consec+=1;
	 	$_POST[idcomp]=$consec;		 
		 $fec=date("d/m/Y");
		 $_POST[fecha]=$fec; 
		
	}
		 $pf[]=array();
		 $pfcp=array();	
?>
<table  class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="8">:: Buscar Tercero</td><td class="cerrar" ><a href="hum-principal.php">Cerrar</a></td>
      </tr>
      <tr><td class="saludo1">No Liquidacion</td><td><input name="idcomp" type="text" size="5" value="<?php echo $_POST[idcomp]?>" readonly></td><td class="saludo1">Fecha</td><td><input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10" size="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY">   <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>  </td></tr>
      <tr >
        <td class="saludo1">Periodo Liquidar:
        </td>
        <?php
		if(!$_POST[oculto])
		{
	 $_POST[diast]=array();
	 $_POST[devengado]=array();
	 $_POST[empleados]=array();		 		
		}
		
		$linkbd=conectar_bd();
		$sqlr="select *from admfiscales where vigencia='".$_SESSION[vigencia]."'";
		$resp = mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($resp)) 
				{
					 $_POST[balim]=$row[7];
					 $_POST[btrans]=$row[8];
					 $_POST[bfsol]=$row[6];
					 $_POST[alim]=$row[5];
					 $_POST[transp]=$row[4];
					 $_POST[salmin]=$row[3];
					 $_POST[cajacomp]=$row[13];
					 $_POST[icbf]=$row[10];
					 $_POST[sena]=$row[11];
					 $_POST[esap]=$row[14];
					 $_POST[iti]=$row[12];					 					 					 					 					 		 			 	}		
        ?>
		<td>
		<input id="cajacomp" name="cajacomp" type="hidden" value="<?php echo $_POST[cajacomp]?>" >
		<input id="icbf" name="icbf" type="hidden" value="<?php echo $_POST[icbf]?>" >
	    <input id="sena" name="sena" type="hidden" value="<?php echo $_POST[sena]?>" >
    	<input id="esap" name="esap" type="hidden" value="<?php echo $_POST[esap]?>" >
		<input id="iti" name="iti" type="hidden" value="<?php echo $_POST[iti]?>" >           
        <input id="btrans" name="btrans" type="hidden" value="<?php echo $_POST[btrans]?>" >
        <input id="balim" name="balim" type="hidden" value="<?php echo $_POST[balim]?>" >
        <input id="bfsol" name="bfsol" type="hidden" value="<?php echo $_POST[bfsol]?>" >
        <input id="transp" name="transp" type="hidden" value="<?php echo $_POST[transp]?>" >
        <input id="alim" name="alim" type="hidden" value="<?php echo $_POST[alim]?>" >
		 <input id="salmin" name="salmin" type="hidden" value="<?php echo $_POST[salmin]?>" >        
<select name="tperiodo" id="tperiodo" onChange="validar()" >
				  <option value="-1">Seleccione ....</option>
					<?php
					 $sqlr="Select * from humperiodos  where estado='S'";
		 		$resp = mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($resp)) 
				{
				$i=$row[0];
				echo "<option value=$row[0] ";
				if($i==$_POST[tperiodo])
			 	{
				 echo "SELECTED";
				 $_POST[tperiodonom]=$row[1];
				 $_POST[diasperiodo]=$row[2];
				 }
				echo " >".$row[0]." - ".$row[1]."</option>";	  
			     }   
				?>
		  </select><input id="tperiodonom" name="tperiodonom" type="hidden" value="<?php echo $_POST[tperiodonom]?>" ><input name="cperiodo" type="hidden" value=""></td>
        <td class="saludo1">Dias:
        </td>
        <td><input name="diasperiodo" type="text" id="diasperiodo" value="<?php echo $_POST[diasperiodo]?>" size="5" readonly>
          <input name="oculto" type="hidden" value="1"></td>
          <td class="saludo1">CC:</td>
          <td>
          <select name="cc"  onChange="validar()" onKeyUp="return tabular(event,this)">
          <option value='' <?php if(''==$_POST[cc]) echo "SELECTED"?>>Todos</option>
	<?php
	$linkbd=conectar_bd();
	$sqlr="select *from centrocosto where estado='S'";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
				    {
					echo "<option value=$row[0] ";
					$i=$row[0];
		
					 if($i==$_POST[cc])
			 			{
						 echo "SELECTED";
						 }
					  echo ">".$row[0]." - ".$row[1]."</option>";	 	 
					}	 	
	?>
   </select>
          </td>
          <td class="saludo1" colspan="1">Mes:</td>
          <td ><select name="periodo" id="periodo" onChange="validar()"  >
				  <option value="-1">Seleccione ....</option>
					<?php
					 $sqlr="Select * from meses where estado='S' ";
		 		$resp = mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($resp)) 
				{
				$i=$row[0];
				echo "<option value=$row[0] ";
				if($i==$_POST[periodo])
			 	{
				 echo "SELECTED";
				 $_POST[periodonom]=$row[1];
				 $_POST[periodonom]=$row[2];
				 }
				echo " >".$row[1]."</option>";	  
			     }   
				?>
		  </select> 
		  <?php 
		  if($_POST[tperiodo]=='1')
				{
				?>
                <input type="hidden" name="mesnum" value='1'>	
		 <?php 			
				}  
		 if($_POST[tperiodo]=='2')
				{
		?>
        <select name="mesnum" id="mesnum">
          <option value="1" <?php if($_POST[mesnum]=='1') echo "selected" ?>>1 Quincena</option>
          <option value="2" <?php if($_POST[mesnum]=='2') echo "selected" ?>>2 Quincena</option>
        </select> 
		 <?php 	
				}
		   ?>
           <input type="button" value="Calcular" name="calcular" onClick="validar()" >
           </td>
       </tr>                       
    </table>    
	<div class="subpantalla">
      <?php

$linkbd=conectar_bd();
$crit1=" ";
$crit2=" ";
//sacar el consecutivo 

echo "<table class='inicio' align='center' width='99%'><tr><td colspan='17' class='titulos'>.: Resultados Busqueda: $ntr Empleados</td></tr><tr><td class='titulos2' width='1%'>Vac<input type='checkbox' name='todos' value=''  onClick='' $chk></td><td class='titulos2' >EMPLEADO</td><td class='titulos2' width='2%'>CEDULA</td><td class='titulos2' >SAL BAS</td><td class='titulos2' >DIAS LIQ</td><td class='titulos2' >DEVENGADO</td><td class='titulos2' >AUX ALIM</td><td class='titulos2' >AUX TRAN</td><td class='titulos2' >HORAS EXTRAS</td><td class='titulos2' >TOT DEV</td><td class='titulos2' >SALUD</td><td class='titulos2' >PENSION</td><td class='titulos2' >F SOLIDA</td><td class='titulos2' >RETE FTE</td><td class='titulos2' >OTRAS DEDUC</td><td class='titulos2' >TOT DEDUC</td><td class='titulos2' >NETO PAG</td></tr>";	
//echo "nr:".$_POST[cperiodo];
$iter='saludo3';
$iter2='saludo3';
if ($_POST[cperiodo]=='2')
  {
	 $saludportot=0;
	 $pensionportot=0;	 
//*** parafiscales
	 $sqlr="select porcentaje from humparafiscales where codigo='06'";
	 $resp2 = mysql_query($sqlr,$linkbd);
	 $row2 =mysql_fetch_row($resp2);
	 $arp=$row2[0];
	 $sqlr="select porcentaje from humparafiscales where codigo='07'";
	 $resp2 = mysql_query($sqlr,$linkbd);
	 $row2 =mysql_fetch_row($resp2);
	 $saludportot=$row2[0];
	 $saludemp=$row2[0];	 
	 $sqlr="select porcentaje from humparafiscales where codigo='08'";
	 $resp2 = mysql_query($sqlr,$linkbd);
	 $row2 =mysql_fetch_row($resp2);
	 $salud=$row2[0];
 	 $saludportot+=$row2[0];
	 $sqlr="select porcentaje from humparafiscales where codigo='09'";
	 $resp2 = mysql_query($sqlr,$linkbd);
	 $row2 =mysql_fetch_row($resp2);
	 $pensionportot=$row2[0];
 	 $pensionemp=$row2[0];
 	 $sqlr="select porcentaje from humparafiscales where codigo='10'";
	 $resp2 = mysql_query($sqlr,$linkbd);
	 $row2 =mysql_fetch_row($resp2);
 	 $pension=$row2[0];
	 $pensionportot+=$row2[0];	 
	  
$_POST[totsaludtot]=0;
$_POST[totpenstot]=0;

$_POST[totaldevini]=0;
$_POST[totalauxalim]=0;
$_POST[totalauxtra]=0;
$_POST[totaldevtot]=0;
$_POST[totalsalud]=0;
$_POST[totalpension]=0;
$_POST[totaltransporte]=0;
$_POST[totalfondosolida]=0;
$_POST[totalotrasreducciones]=0;
$_POST[totaldeductot]=0;
$_POST[totalnetopago]=0;
$sqlr="select *from terceros inner join terceros_nomina on terceros.cedulanit=terceros_nomina.cedulanit where terceros.estado='S' and terceros.empleado='1' and terceros_nomina.cc LIKE '%".$_POST[cc]."%' order by terceros.apellido1,terceros.apellido2,terceros.nombre1,terceros.nombre2";
	// echo "<div><div>sqlr:".$sqlr."</div></div>";
	$resp = mysql_query($sqlr,$linkbd);
	$ntr = mysql_num_rows($resp);
	$con=0;
	$totalparafiscales=0;
	while ($row =mysql_fetch_row($resp)) 
	 {
$sqlr="select terceros_nomina.cargo, humnivelsalarial.nombre, humnivelsalarial.valor, terceros_nomina.fondopensionestipo from terceros_nomina inner join humnivelsalarial on terceros_nomina.cargo=humnivelsalarial.id_nivel where terceros_nomina.cedulanit=$row[12] ";
	 $resp2 = mysql_query($sqlr,$linkbd);
	 $row2 =mysql_fetch_row($resp2);
	 $valordia=$row2[2]/30;
	 $salario=$row2[2]; 
	 	 $tipofondopension=$row2[3];
	 $auxalim=0;
	 $auxtra=0;
	 $otrasrete=0;
	 $totalretenciones=0;
	 if($_POST[diast][$con]>$_POST[diasperiodo] || $_POST[diast][$con]<0 || $_POST[diast][$con]=='')
	 {
	// echo "ddd".strlen($_POST[diast]);
	 $_POST[diast][$con]=$_POST[diasperiodo];
	// echo "   sss".$_POST[diast][$con];
	 }
	 if($row2[2]<=$_POST[balim])
	 {
	  $auxalim=$_POST[alim];
	  $auxalim=$auxalim/30; 
	 }
	 if($row2[2]<=$_POST[btrans])
	 {
	  $auxtra=$_POST[transp]; 
	  $auxtra=$auxtra/30;
	 } 
	 $rsalud=0;
	 $rpension=0;
	 $otrasrete=0;
	 $fondosol=0;
	 $varp=0;	 
	 $diaslab=$_POST[diast][$con];
	 	$chk='';
		$ch=esta_en_array($_POST[empleados],$row[12]);
			  $style="";		
			if($ch=='1')
			 {
			 $chk="checked";
			 $diaslab=$_POST[diasperiodo];
 			  $style="style='backgroundColor=#3399bb'";
			 }	 
	 $deven=round($valordia*$_POST[diast][$con],0);
	 $deven2=round($valordia* $diaslab,0);
	 $auxtratot=round($auxtra*$_POST[diast][$con],0);
 	 $auxalimtot=round($auxalim*$_POST[diast][$con],0);
	 $totdev=$deven+$auxalimtot+$auxtratot+$horex;
	 
	 	 //**devengado
	 		$sqlr="select * from  humvariables_det where codigo='01' and cc='".$row[31]."' and estado='S'";
		 	$resrp = mysql_query($sqlr,$linkbd);
			$rowrp =mysql_fetch_row($resrp);
			$ctapresnomina=$rowrp[7];
			$pfcp[$ctapresnomina]+= $deven; 
	 	 //**alimentacion
	 		$sqlr="select * from  humvariables_det where codigo='07' and cc='".$row[31]."' and estado='S'";
		 	$resrp = mysql_query($sqlr,$linkbd);
			$rowrp =mysql_fetch_row($resrp);
			$pfcp[$rowrp[7]]+= $auxalimtot;
		 //**transporte
	 		$sqlr="select * from  humvariables_det where codigo='08' and cc='".$row[31]."' and estado='S'";
		 	$resrp = mysql_query($sqlr,$linkbd);
			$rowrp =mysql_fetch_row($resrp);
			$pfcp[$rowrp[7]]+= $auxtratot;		
	 
	 
//****
	 $bparafiscales=round($totdev-$auxtratot,-3);
	$bparafiscales2=round($deven2+$auxalimtot+$auxtratot+$horex-$auxtratot,-3);
	 $sqlr="select *from centrocosto where estado='S'";
	 $rescc=mysql_query($sqlr,$linkbd);
	 while ($rowcc =mysql_fetch_row($rescc)) 
	 {
	  $sqlr="select * from humparafiscales where tipo='A' and estado='S'";
	  $respf = mysql_query($sqlr,$linkbd);
	  while($rowf =mysql_fetch_row($respf))
	  {
		 if($row[31]==$rowcc[0])
		  { 
		    if($rowf[0]=='06')
			{
				$pf[$rowf[0]][$rowcc[0]]+= round(($rowf[3]/100)*$bparafiscales,-2); 
				//echo "<br>$row[12]- $rowf[0]:$bparafiscales2- ".$rowrp[6];	
			}
			else
			{
			$pf[$rowf[0]][$rowcc[0]]+= round(($rowf[3]/100)*$bparafiscales2,-2); 
			}
				if($rowf[0]=='09')
		 		{
			 if($tipofondopension=='N/A')
			 $tpf='N/A';
			 if($tipofondopension=='PR')
			 $tpf='privado';
			 if($tipofondopension=='PB')
			 $tpf='publico';			 			 
			$sqlr="select * from humparafiscales_det where codigo='$rowf[0]' and cc='$rowcc[0]' and estado='S' and sector='$tpf'";
		//echo $sqlr;
		 	$resrp = mysql_query($sqlr,$linkbd);
			$rowrp =mysql_fetch_row($resrp);
			$pfcp[$rowrp[6]]+= round(($rowf[3]/100)*$bparafiscales2,-2); 
			// $tipofondopension;
					 
		 		}
			 else
				 {
				$sqlr="select * from humparafiscales_det where codigo='$rowf[0]' and cc='$rowcc[0]' and estado='S'";
		 		$resrp = mysql_query($sqlr,$linkbd);
				$rowrp =mysql_fetch_row($resrp);
				if($rowf[0]=='06')
				{
				$pfcp[$rowrp[6]]+= round(($rowf[3]/100)*$bparafiscales,-2);
				//echo "<br>$row[12]- $rowf[0]:$bparafiscales2- ".$rowrp[6];	
				}
				else			
				{
				$pfcp[$rowrp[6]]+= round(($rowf[3]/100)*$bparafiscales2,-2); 			
				}
		 		}				 
		 	/*$sqlr="select * from humparafiscales_det where codigo='$rowf[0]' and cc='$rowcc[0]' and estado='S'";
		 	$resrp = mysql_query($sqlr,$linkbd);
			$rowrp =mysql_fetch_row($resrp);
			$pfcp[$rowrp[6]]+= round(($rowf[3]/100)*$bparafiscales,-2); */
		  }
	  }	
	 }
	 
	 $varp=round((($arp/100)*$bparafiscales),-2);
//  	 $rsalud=round((($salud/100)*$bparafiscales),0);
//	 $rsaludemp=round((($saludemp/100)*$bparafiscales),0);
//	 $valsaludtot=round(($saludportot/100)*$bparafiscales,-2);	 	 
	 $valsaludtot=round(($saludportot/100)*$bparafiscales2,-2);
	 $rsalud=round(((($salud)/($saludportot))*$valsaludtot),-2);
	// $rsaludemp=round(((($saludemp)/($saludportot))*$valsaludtot),-2);
	$rsaludemp=$valsaludtot-$rsalud;
	//$pfcp[$ctapresnomina]+=$rsaludemp ; 
	 $valpensiontot=round(($pensionportot/100)*$bparafiscales2,-2);
//	 $valsaludtot=round(ceil((($saludportot/100)*$bparafiscales)),-1);	 
	// $rpension=round((($pension/100)*$bparafiscales),0);	
	// $rpensionemp=round(ceil(($pensionemp/100)*$bparafiscales),0);		
	 $rpension=round(((($pension)/($pensionportot))*$valpensiontot),-2);
//	 $rpensionemp=round(((($pensionemp)/($pensionportot))*$valpensiontot),-2);  
	 	 $rpensionemp=$valpensiontot-$rpension;
		
	$sqlr="select * from humfondosoli where estado='S' and $bparafiscales between (rangoinicial*$_POST[salmin]) and (rangofinal*$_POST[salmin])";
	 $resp2 = mysql_query($sqlr,$linkbd);
	 $row2 =mysql_fetch_row($resp2);
 	 $fondosol=round(ceil((($row2[3]/100)*$bparafiscales2)/50),0)*50;	
	 $valpensiontot=round(($pensionportot/100)*$bparafiscales2,-2)+$fondosol;	
	 	// $pfcp[$ctapresnomina]+=$rpensionemp+$fondosol;  
	// $sqlr="select sum(valorcuota) from humretenempleados where estado='S' and empleado='".$row[12]."' and MONTH(fecha)<=$_POST[periodo] and YEAR(fecha)<=".$_SESSION[vigencia]." and sncuotas>0";
//	 
$sqlr="select sum(valorcuota) from humretenempleados where estado='S' and empleado='".$row[12]."' and CONCAT(YEAR(fecha),'-',MONTH(fecha))<='".$_SESSION[vigencia]."-$_POST[periodo]' and sncuotas>0";
	 $resp2 = mysql_query($sqlr,$linkbd);
	 $row2 =mysql_fetch_row($resp2);
	 $otrasrete=round($row2[0]);
	 
//	 $fondosol=round(($row2[3]/100)*$bparafiscales);
//	 echo "<br>".$sqlr;	 
	 $totalretenciones=$rsalud+$rpension+$otrasrete+$fondosol;
 	 $totalneto= $totdev-$totalretenciones;
	  if($ch=='1')
			 {
  	 $totalparafiscales+=$bparafiscales2;	
	 		 }
			 else
			 {
  	 $totalparafiscales+=$bparafiscales;
			 }
 	 //$totalparafiscales+=$bparafiscales;
	
	 echo "<tr  id='fila$row[12]' class='saludo3' $style ><td ><input type='checkbox' name='empleados[]' value='$row[12]'  onClick='marcar($row[12],$con);' $chk></td><td ><input type='hidden' name='nomemp[]' value='".strtoupper($row[3])." ".strtoupper($row[4])." ".strtoupper($row[1])." ".strtoupper($row[2])."' >".strtoupper($row[3])." ".strtoupper($row[4])." ".strtoupper($row[1])." ".strtoupper($row[2])."</td><td ><input type='hidden' name='ccemp[]' value='$row[12]'>$row[12] </td><td ><input type='hidden' name='centrocosto[]' value='".$row[31]."' size='8' readonly><input type='text' name='salbas[]' value='$salario' size='8' readonly> </td><td ><input type='text' size='2' name='diast[]' value='".$_POST[diast][$con]."'  onKeyPress='javascript:return solonumeros(event)' onKeyUp='return tabular(event,this)'  onBlur='document.form2.submit()' > </td><td ><input type='text' size='8' name='devengado[]' value='".($deven)."' readonly> </td><td ><input type='text' size='5' name='ealim[]' value='".($auxalim*$_POST[diast][$con])."' readonly>  </td><td ><input type='text' size='5' name='etrans[]' value='".($auxtra*$_POST[diast][$con])."' readonly>  </td><td ><input type='text' name='horaextra[]' value='$_POST[horaextra]' size='8' readonly> </td><td ><input type='text' name='totaldev[]' value='$totdev' size='8' readonly><input type='hidden' name='ibc[]' value='$bparafiscales' size='8' readonly></td><td ><input type='hidden' name='arpemp[]' value='$varp' ><input type='text' name='saludrete[]' value='$rsalud' size='8' readonly><input type='hidden' name='saludemprete[]' value='$rsaludemp' size='8' readonly><input type='hidden' name='totsaludrete[]' value='$valsaludtot' size='8' readonly></td><td ><input type='text' name='pensionrete[]' value='$rpension' size='8' readonly><input type='hidden' name='pensionemprete[]' value='$rpensionemp' size='8' readonly> <input type='hidden' name='totpensionrete[]' value='$valpensiontot' size='8' readonly></td><td ><input type='text' name='fondosols[]' value=' $fondosol' size='8' readonly> </td><td > </td><td ><input type='text' name='otrasretenciones[]' value='$otrasrete' size='8' readonly> </td><td ><input type='text' name='totalrete[]' value='$totalretenciones' size='8' readonly> </td><td ><input type='text' name='netopagof[]' value='".number_format($totalneto,0)."' size='12' readonly ><input type='hidden' name='netopago[]' value='$totalneto'> </td></tr>";
	 	$auxalimtot=$auxalim*$_POST[diast][$con];
		$auxtratot=$auxtra*$_POST[diast][$con];
		$_POST[totsaludtot]+=$valsaludtot;
		$_POST[totpenstot]+=$valpensiontot;
		$_POST[totaldevini]+=$deven;
		$_POST[totalauxalim]+=$auxalimtot;
		$_POST[totalauxtra]+=$auxtratot;
		$_POST[totaldevtot]+=$totdev;	
		$_POST[totalsalud]+=$rsalud;
		$_POST[totalpension]+=$rpension;
		$_POST[totalfondosolida]+=$fondosol;
		$_POST[totalotrasreducciones]+=$otrasrete;
		$_POST[totaldeductot]+=$totalretenciones;
		$_POST[totalnetopago]+=$totalneto;
	 $con+=1;
	 $aux=$iter;
	 $iter=$iter2;
	 $iter2=$aux;
	}
  }
 else
    {
			 	$chk='';
	$saludportot=0;
	 $pensionportot=0;	 	
	//*** parafiscales
	 $sqlr="select porcentaje from humparafiscales where codigo='06'";
	 $resp2 = mysql_query($sqlr,$linkbd);
	 $row2 =mysql_fetch_row($resp2);
	 $arp=$row2[0];
	 $sqlr="select porcentaje from humparafiscales where codigo='07'";
	 $resp2 = mysql_query($sqlr,$linkbd);
	 $row2 =mysql_fetch_row($resp2);
	 $saludportot=$row2[0];
	 $saludemp=$row2[0];	 
	 $sqlr="select porcentaje from humparafiscales where codigo='08'";
	 $resp2 = mysql_query($sqlr,$linkbd);
	 $row2 =mysql_fetch_row($resp2);
	 $salud=$row2[0];
 	 $saludportot+=$row2[0];
	 $sqlr="select porcentaje from humparafiscales where codigo='09' ";
	 $resp2 = mysql_query($sqlr,$linkbd);
	 $row2 =mysql_fetch_row($resp2);
	 $pensionportot=$row2[0];
 	 $pensionemp=$row2[0];
 	 $sqlr="select porcentaje from humparafiscales where codigo='10'";
	 $resp2 = mysql_query($sqlr,$linkbd);
	 $row2 =mysql_fetch_row($resp2);
 	 $pension=$row2[0];
	 $pensionportot+=$row2[0];	 	
$_POST[totsaludtot]=0;
$_POST[totpenstot]=0;
$_POST[totaldevini]=0;
$_POST[totalauxalim]=0;
$_POST[totalauxtra]=0;
$_POST[totaldevtot]=0;
$_POST[totalsalud]=0;
$_POST[totalpension]=0;
$_POST[totalfondosolida]=0;
$_POST[totalotrasreducciones]=0;
$_POST[totaldeductot]=0;
$_POST[totalnetopago]=0;
	$con=0;
	$totalparafiscales=0;
	 for ($x=0;$x<count($_POST[salbas]);$x++) 
	 {
	 $sqlr="select terceros_nomina.cargo, humnivelsalarial.nombre, humnivelsalarial.valor, terceros_nomina.fondopensionestipo from terceros_nomina inner join humnivelsalarial on terceros_nomina.cargo=humnivelsalarial.id_nivel where terceros_nomina.cedulanit='".$_POST[ccemp][$con]."'";
	 $resp2 = mysql_query($sqlr,$linkbd);
	 $row2 =mysql_fetch_row($resp2);
	 $valordia=$row2[2]/30;
	 $salario=$row2[2];
	 	 $tipofondopension=$row2[3];
	 $auxalim=0;
	 $auxtra=0;
 	 $otrasrete=0;
	 $totalretenciones=0;
//	 echo "<br>D:".$_POST[diast][$con];
	 if($_POST[diast][$con]>$_POST[diasperiodo] || $_POST[diast][$con]<0 || $_POST[diast][$con]=='')
	 {
//	 echo "ddd".strlen($_POST[diast]);
	 $_POST[diast][$con]=$_POST[diasperiodo];
//	 echo "   sss".$_POST[diast][$con];
	 }
	 if($row2[2]<=$_POST[balim])
	 {
	  $auxalim=$_POST[alim];
	  $auxalim=$auxalim/30; 
	 }
	 if($row2[2]<=$_POST[btrans])
	 {
	  $auxtra=$_POST[transp]; 
	  $auxtra=$auxtra/30;
	 }
	 //$_POST[diast][]=$_POST[diast][$con];
 	 $rsalud=0;
	 $rpension=0;
	 $otrasrete=0;
	 $fondosol=0;
	 $varp=0;	 
	 $diaslab=$_POST[diast][$con];
	   $chk=''; 
	  $style="";
		$ch=esta_en_array($_POST[empleados],$_POST[ccemp][$con]);
			if($ch=='1')
			 {
			 $chk="checked";
			  $diaslab=$_POST[diasperiodo];
			  $style="style='backgroundColor=#3399bb'";
			 }
	 $deven=round($valordia*$_POST[diast][$con],0);
	  $deven2=round($valordia* $diaslab,0);
	 $auxtratot=round($auxtra*$_POST[diast][$con],0);
	 $auxalimtot=round($auxalim*$_POST[diast][$con],0);
	 $totdev=$deven+$auxalimtot+$auxtratot+$horex;
	 $bparafiscales=round($totdev-$auxtratot,-3);
	 $bparafiscales2=round($deven2+$auxalimtot+$auxtratot+$horex-$auxtratot,-3);
	 //**devengado
	 		$sqlr="select * from  humvariables_det where codigo='01' and cc='".$_POST[centrocosto][$con]."' and estado='S'";
		 	$resrp = mysql_query($sqlr,$linkbd);
			$rowrp =mysql_fetch_row($resrp);
			$ctapresnomina=$rowrp[7];
			$pfcp[$ctapresnomina]+= $deven; 
	 	 //**alimentacion
	 		$sqlr="select * from  humvariables_det where codigo='07' and cc='".$_POST[centrocosto][$con]."' and estado='S'";
		 	$resrp = mysql_query($sqlr,$linkbd);
			$rowrp =mysql_fetch_row($resrp);
			$pfcp[$rowrp[7]]+= $auxalimtot;
		 //**transporte
	 		$sqlr="select * from  humvariables_det where codigo='08' and cc='".$_POST[centrocosto][$con]."' and estado='S'";
		 	$resrp = mysql_query($sqlr,$linkbd);
			$rowrp =mysql_fetch_row($resrp);
			$pfcp[$rowrp[7]]+= $auxtratot;		
	 
	 $sqlr="select *from centrocosto where estado='S'";
	 $rescc=mysql_query($sqlr,$linkbd);
	 while ($rowcc =mysql_fetch_row($rescc)) 
	 {
	  $sqlr="select * from humparafiscales where tipo='A' and estado='S'";
	  $respf = mysql_query($sqlr,$linkbd);
	  while($rowf =mysql_fetch_row($respf))
	  {
		 if($_POST[centrocosto][$con]==$rowcc[0])
		  { 
		//$pf[$rowf[0]][$rowcc[0]]+= round(($rowf[3]/100)*$bparafiscales,-2); 	 
		  if($rowf[0]=='06')
			{$pf[$rowf[0]][$rowcc[0]]+= round(($rowf[3]/100)*$bparafiscales,-2);
			//echo "<br>$_POST[ccemp][$con]-$rowf[0]:$bparafiscales2- ".$rowrp[6];
			 }
			else
			{$pf[$rowf[0]][$rowcc[0]]+= round(($rowf[3]/100)*$bparafiscales2,-2); }
		if($rowf[0]=='09')
		 {
			 if($tipofondopension=='N/A')
			 $tpf='N/A';
			 if($tipofondopension=='PR')
			 $tpf='privado';
			 if($tipofondopension=='PB')
			 $tpf='publico';
			 
			 
		$sqlr="select * from humparafiscales_det where codigo='$rowf[0]' and cc='$rowcc[0]' and estado='S' and sector='$tpf'";
		//echo $sqlr;
		 	$resrp = mysql_query($sqlr,$linkbd);
			$rowrp =mysql_fetch_row($resrp);
			$pfcp[$rowrp[6]]+= round(($rowf[3]/100)*$bparafiscales2,-2); 
			// $tipofondopension;
			//echo "- ".$rowrp[6];
			 
		 }
		 else
		 {
			$sqlr="select * from humparafiscales_det where codigo='$rowf[0]' and cc='$rowcc[0]' and estado='S'";
		 	$resrp = mysql_query($sqlr,$linkbd);
			$rowrp =mysql_fetch_row($resrp);
			if($rowf[0]=='06')
			{$pfcp[$rowrp[6]]+= round(($rowf[3]/100)*$bparafiscales,-2);
			//echo "<br>$_POST[ccemp][$con]-$rowf[0]:$bparafiscales2- ".$rowrp[6];
			}
			else		{	
			$pfcp[$rowrp[6]]+= round(($rowf[3]/100)*$bparafiscales2,-2); }
//			$pfcp[$rowrp[6]]+= round(($rowf[3]/100)*$bparafiscales,-2); 
		  }
		//echo "<br>pf $rowf[0]-$rowcc[0] :".$pf[$rowf[0]][$rowcc[0]];
		  }
	  }	
	 }	
	 $varp=round((($arp/100)*$bparafiscales),-2);
 $valsaludtot=round(($saludportot/100)*$bparafiscales2,-2);
	 $rsalud=round(((($salud)/($saludportot))*$valsaludtot),-2);
	 //$rsaludemp=round(((($saludemp)/($saludportot))*$valsaludtot),-2);
	$rsaludemp=$valsaludtot-$rsalud;
	//$pfcp[$ctapresnomina]+=$rsaludemp ; 
	 $valpensiontot=round(($pensionportot/100)*$bparafiscales2,-2);		  
	  $rpension=round(((($pension)/($pensionportot))*$valpensiontot),-2);
	  
	 //$rpensionemp=round(((($pensionemp)/($pensionportot))*$valpensiontot),-2);  
	 $rpensionemp=$valpensiontot-$rpension;
	$sqlr="select * from humfondosoli where estado='S' and $bparafiscales between (rangoinicial*$_POST[salmin]) and (rangofinal*$_POST[salmin])";
	 $resp2 = mysql_query($sqlr,$linkbd);
	 $row2 =mysql_fetch_row($resp2);
 	 $fondosol=round(ceil((($row2[3]/100)*$bparafiscales2)/50),0)*50;
	
	 $valpensiontot=round(($pensionportot/100)*$bparafiscales2,-2)+$fondosol;	 
	 	 //$pfcp[$ctapresnomina]+=$rpensionemp+$fondosol;  
$sqlr="select sum(valorcuota) from humretenempleados where estado='S' and empleado='".$_POST[ccemp][$con]."' and CONCAT(YEAR(fecha),'-',MONTH(fecha))<='".$_SESSION[vigencia]."-$_POST[periodo]' and sncuotas>0";
//	 $sqlr="select sum(valorcuota) from humretenempleados where estado='S' and empleado='".$_POST[ccemp][$con]."' and MONTH(fecha)<=$_POST[periodo] and  YEAR(fecha)<=".$_SESSION[vigencia]." and sncuotas>0";
	 $resp2 = mysql_query($sqlr,$linkbd);
	 $row2 =mysql_fetch_row($resp2);
	 $otrasrete=round($row2[0]);
	 
//	 echo "<br>".$sqlr;
	 $totalretenciones=$rsalud+$rpension+$otrasrete+$fondosol;
	// $totalretenciones=$rsalud+$rpension+$otrasrete;
	 $totalneto= $totdev-$totalretenciones;
	 if($ch=='1')
			 {
  	 $totalparafiscales+=$bparafiscales2;	
	 		 }
			 else
			 {
  	 $totalparafiscales+=$bparafiscales;
			 }
	 echo "<tr  id='fila$row[12]' class='saludo3' $style><td ><input type='checkbox' name='empleados[]' value='".$_POST[ccemp][$con]."'  onClick='marcar(".$_POST[empleados][$con].",$con);' $chk></td><td ><input type='hidden' name='nomemp[]' value='".$_POST[nomemp][$con]."'>".$_POST[nomemp][$con]."</td><td ><input type='hidden' name='ccemp[]' value='".$_POST[ccemp][$con]."'>".$_POST[ccemp][$con]."</td><td ><input type='hidden' name='centrocosto[]' value='".$row[31]."' size='8' readonly><input type='text' name='salbas[]' value='$salario' size='8' readonly> </td><td ><input type='text' size='2' name='diast[]' value='".$_POST[diast][$con]."'  onKeyPress='javascript:return solonumeros(event)' onKeyUp='return tabular(event,this)' onBlur='document.form2.submit()' > </td><td ><input type='text' size='8' name='devengado[]' value='".($deven)."' readonly> </td><td ><input type='text' size='5' name='ealim[]' value='".($auxalimtot)."' readonly>  </td><td ><input type='text' size='5' name='etrans[]' value='".($auxtratot)."' readonly>  </td><td ><input type='text' name='horaextra[]' value='$_POST[horaextra]' size='8' readonly> </td><td ><input type='text' name='totaldev[]' value='$totdev' size='8' readonly><input type='hidden' name='ibc[]' value='$bparafiscales' size='8' readonly></td><td ><input type='hidden' name='arpemp[]' value='$varp' ><input type='text' name='saludrete[]' value='$rsalud' size='8' readonly><input type='hidden' name='saludemprete[]' value='$rsaludemp' size='8' readonly><input type='hidden' name='totsaludrete[]' value='$valsaludtot' size='8' readonly></td><td ><input type='text' name='pensionrete[]' value='$rpension' size='8' readonly><input type='hidden' name='pensionemprete[]' value='$rpensionemp' size='8' readonly><input type='hidden' name='totpensionrete[]' value='$valpensiontot' size='8' readonly> </td><td ><input type='text' name='fondosols[]' value='$fondosol' size='8' readonly>  </td><td >$row2[2] </td><td ><input type='text' name='otrasretenciones[]' value='$otrasrete' size='8' readonly> </td><td ><input type='text' name='totalrete[]' value='$totalretenciones' size='8' readonly> </td><td ><input type='text' name='netopagof[]' value='".number_format($totalneto,0)."' size='12' readonly><input type='hidden' name='netopago[]' value='$totalneto' > </td></tr>";
		$_POST[totsaludtot]+=$valsaludtot;
		$_POST[totpenstot]+=$valpensiontot;
	 	$_POST[totaldevini]+=$deven;
		$_POST[totalauxalim]+=$auxalimtot;
		$_POST[totalauxtra]+=$auxtratot;
		$_POST[totaldevtot]+=$totdev;	
		$_POST[totalsalud]+=$rsalud;
		$_POST[totalpension]+=$rpension;
		$_POST[totalfondosolida]+=$fondosol;
		$_POST[totalotrasreducciones]+=$otrasrete;
		$_POST[totaldeductot]+=$totalretenciones;
		$_POST[totalnetopago]+=$totalneto;
	 $con+=1;
	 $aux=$iter;
	 $iter=$iter2;
	 $iter2=$aux;
	 }
	}
echo "<tr class='saludo3'><td colspan='5'></td><td><input type='hidden' name='totaldevini' value='$_POST[totaldevini]'>".number_format($_POST[totaldevini],2)."</td><td><input type='hidden' name='totalauxalim' value='$_POST[totalauxalim]'>".number_format($_POST[totalauxalim],2)."</td><td><input type='hidden' name='totalauxtra' value='$_POST[totalauxtra]'>".number_format($_POST[totalauxtra],2)."</td><td><input type='hidden' name='totalhorex' value='$_POST[totalhorex]'>".number_format($_POST[totalhorex],2)."</td><td><input type='hidden' name='totaldevtot' value='$_POST[totaldevtot]'>".number_format($_POST[totaldevtot],2)."</td><td><input type='hidden' name='totalsalud' value='$_POST[totalsalud]'>".number_format($_POST[totalsalud],2)."</td><td><input type='hidden' name='totalpension' value='$_POST[totalpension]'>".number_format($_POST[totalpension],2)."</td><td><input type='hidden' name='totalfondosolida' value='$_POST[totalfondosolida]'>".number_format($_POST[totalfondosolida],2)."</td><td></td><td><input type='hidden' name='totalotrasreducciones' value='$_POST[totalotrasreducciones]'><input type='hidden' name='totalotrasreducciones' value='$_POST[totalotrasreducciones]'>".number_format($_POST[totalotrasreducciones],2)."</td><td><input type='hidden' name='totaldeductot' value='$_POST[totaldeductot]'>".number_format($_POST[totaldeductot],2)."</td><td><input type='hidden' name='totalnetopago' value='$_POST[totalnetopago]'>".number_format($_POST[totalnetopago],2)."</td></tr>";	
 echo"</table>";
?></div>
<table class="inicio">
<?php
$linkbd=conectar_bd();
?>
<tr>
<td class="titulos">Codigo</td><td class="titulos">Aportes Parafiscales</td><td class="titulos">Porcentaje</td><td class="titulos">Valor</td>
<td class="titulos">Codigo</td><td class="titulos">Aportes Parafiscales</td><td class="titulos">Porcentaje</td><td class="titulos">Valor</td>
<td class="titulos">Codigo</td><td class="titulos">Aportes Parafiscales</td><td class="titulos">Porcentaje</td><td class="titulos">Valor</td>
</tr>
<?php
$sqlr="select * from humparafiscales where tipo='A' and estado='S'";
	 $resp2 = mysql_query($sqlr,$linkbd);
	 $co=0;
	 while($row2 =mysql_fetch_row($resp2))
	  {
  	 if($co==0)
	  {
		echo "<tr>";  
	  }	  
	 $caja=$row2[0];
	 $ncaja=$row2[1];
	 $pcaja=$row2[3];
// 	 $vcaja=round(($pcaja/100)*($totalparafiscales),-2);	
   $vcaja=array_sum($pf[$row2[0]]);
	 echo "<td class='saludo3'><input name='codpara[]' type='hidden' value='$caja'> $caja </td><td class='saludo3'><input name='codnpara[]' type='hidden' value='$ncaja'>  $ncaja </td><td class='saludo3'><input name='porpara[]' type='hidden' value='$pcaja'> $pcaja %</td><td class='saludo3'><input name='valpara[]' type='hidden' value='$vcaja'>".number_format($vcaja,0)."</td>";
	  $co+=1;
	 if($co==3)
	  {
		echo "</tr>";  
		$co=0;
	  } 
	 }
	 echo "<tr><td>TOTAL SALUD</td><td class='saludo3'>".number_format($_POST[totsaludtot],2)."</td></tr>";
 	 echo "<tr><td>TOTAL PENSION</td><td class='saludo3'>".number_format($_POST[totpenstot],2)."</td></tr>";
?>
</table>
<table class="inicio">
<tr>
<td class="titulos">Cuenta Presupuestal</td><td class="titulos">Nombre Cuenta Presupuestal</td><td class="titulos">Valor</td></tr>
<?php
$totalrubro=0;
foreach($pfcp as $k => $valrubros)
 {
  $ncta=existecuentain($k);
  echo "<tr class='saludo3'><td ><input type='hidden' name='rubrosp[]' value='$k'>$k</td><td><input type='hidden' name='nrubrosp[]' value='".strtoupper($ncta)."'>".strtoupper($ncta)."</td><td align='right'><input type='hidden' name='vrubrosp[]' value='$valrubros'>".number_format($valrubros,2)."</td></tr>";
  $totalrubro+=$valrubros;
 }
?>
<tr class='saludo3'><td></td><td>Total:</td><td align='right'><?php echo number_format($totalrubro,2) ?></td></tr> 
</table>
<?php
if($_POST[oculto]==2)
 {
  $linkbd=conectar_bd();
  ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
  $sqlr="insert into humnomina (`fecha`, `periodo`, `mes`, `diasp`, `mesnum`, `cc`, `vigencia`, `estado`) values ('$fechaf','$_POST[tperiodo]','$_POST[periodo]','$_POST[diasperiodo]','$_POST[mesnum]','$_POST[cc]','".$_SESSION[vigencia]."','S')";
  if (!mysql_query($sqlr,$linkbd))
	{
	 echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue><img src='imagenes\alert.png'>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
//	 $e =mysql_error($respquery);
	 echo "Ocurrió el siguiente problema:<br>";
  	 //echo htmlentities($e['message']);
  	 echo "<pre>";
     ///echo htmlentities($e['sqltext']);
    // printf("\n%".($e['offset']+1)."s", "^");
     echo "</pre></center></td></tr></table>";
	}
  	else
  	{
	 $id=mysql_insert_id();
	 $sqlr="insert into humnomina_aprobado (id_nom,fecha,id_rp,persoaprob,estado) values ($id,'$fechaf',$_POST[rp], '$_SESSION[usuario]', 'S')";
	 if (!mysql_query($sqlr,$linkbd))
	 {
	 echo "<table class='inicio'><tr><td class='saludo1'><center>No se Pudo Aprobrar la Nomina <img src='imagenes\alert.png'></center></td></tr></table>"; 	  
	 }
	  else
	  {
	 echo "<table class='inicio'> <tr><td class='saludo1'> <center>Registros Exitosos:$cex   -   Registros Erroneos: $cerr<img src='imagenes\confirm.png'></center></td></tr></table> "; 	
	  }
	  $lastday = mktime (0,0,0,$_POST[periodo],1,$_SESSION[vigencia]);
	  echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado la Liquidacion de la Nomina $id - Centro Costo:$_POST[cc] - Mes: ".strtoupper(strftime('%B',$lastday))." - $_POST[mesnum]<img src='imagenes\confirm.png'></center></td></tr></table>";
	$cex=0;
	$cerr=0;
	 $sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($id,4,'$fechaf','CAUSACION NOMINA MES ".strtoupper(strftime('%B',$lastday))."',0,0,0,0,'1')";
	mysql_query($sqlr,$linkbd);
	//echo "<br>$sqlr";
	 for ($x=0;$x<count($_POST[salbas]);$x++) 
	 {
	//*****  datos nomina del empleado *****	 
		 $sqlr="Select *from terceros_nomina where cedulanit='".$_POST[ccemp][$x]."'";
//echo "<br>$sqlr";
		 $respn=mysql_query($sqlr,$linkbd);
				 $eps="";
				 $arp="";				 
				 $afp="";	
				 $tipoafp="";
		 while ($rown =mysql_fetch_row($respn)) 
				{
				 $eps=$rown[3];
				 $arp=$rown[4];				 
				 $afp=$rown[5];
				 if('PR'==$rown[11])
				 $tipoafp="privado";				 				 
				 if('PB'==$rown[11])
				 $tipoafp='publico';				 				 
				}				
//*************************************		 
	 $sqlr="insert into humnomina_det (`id_nom`, `cedulanit`, `salbas`, `diaslab`, `devendias`, `ibc`, `auxalim`, `auxtran`, `valhorex`, `totaldev`, `salud`, `saludemp`, `pension`, `pensionemp`, `fondosolid`, `retefte`, `otrasdeduc`, `totaldeduc`, `netopagar`, `estado`) values ($id,'".$_POST[ccemp][$x]."',".$_POST[salbas][$x].",".$_POST[diast][$x].",".$_POST[devengado][$x].",".$_POST[ibc][$x].",".$_POST[ealim][$x].",".$_POST[etrans][$x].",0,".$_POST[totaldev][$x].",".$_POST[saludrete][$x].",".$_POST[saludemprete][$x].",".$_POST[pensionrete][$x].",".$_POST[pensionemprete][$x].",".$_POST[fondosols][$x].",0,".$_POST[otrasretenciones][$x].",".$_POST[totalrete][$x].",".$_POST[netopago][$x].",'S')";
	  if (!mysql_query($sqlr,$linkbd))
		{
		 $cerr+=1;	
		}
		else
		{
		$cex+=1;	
		$ctacont='';
		$ctapres='';
		//*****SALARIO *******
		$sqlr="select distinct *from humvariables,humvariables_det where  humvariables.codigo=humvariables_det.codigo and humvariables_det.modulo=2 and humvariables.codigo='01' and humvariables_det.CC='".$_POST[centrocosto][$x]."'";
		$resph=mysql_query($sqlr,$linkbd);
		//echo "<br>$sqlr";
		while ($rowh =mysql_fetch_row($resph)) 
				{
				if($_POST[centrocosto][$x]==$rowh[9])
				 {
				   $ctacont=$rowh[10];	 
				   $ctapres=$rowh[11];	 
				 }
				$sqlr="Select distinct conceptoscontables_det.cuenta from conceptoscontables,conceptoscontables_det  where conceptoscontables_det.modulo='3' and conceptoscontables_det.tipo='P' and conceptoscontables_det.CC='".$_POST[centrocosto][$x]."' AND conceptoscontables_det.tipocuenta='N' AND conceptoscontables_det.codigo=(Select codconcepago from pptocuentas where cuenta='$ctapres' and vigencia='".$_SESSION[vigencia]."')";
		 		$respc = mysql_query($sqlr,$linkbd);
				//		echo "<br>$sqlr";
				while ($rowc =mysql_fetch_row($respc)) 
				{
				 $ctaconcepto=$rowc[0];
				}				
			   }
				$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$_POST[ccemp][$x]."','".$_POST[centrocosto][$x]."','Causacion Salario Mes ".strtoupper(strftime('%B',$lastday))."','',".$_POST[devengado][$x].",0,'1','".$_SESSION[vigencia]."')";
				mysql_query($sqlr,$linkbd);
				//echo "<br>$sqlr";
				$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctaconcepto."','".$_POST[ccemp][$x]."','".$_POST[centrocosto][$x]."','Causacion Salario Mes ".strtoupper(strftime('%B',$lastday))."','',0,".$_POST[devengado][$x].",'1','".$_SESSION[vigencia]."')";
				mysql_query($sqlr,$linkbd);
				//echo "<br>$sqlr";
			//************ FIN SALARIO ********
		//****** ALIMENTACION ****
		$ctacont='';
		$ctapres='';
		if($_POST[ealim][$x]>0)
		 {
				$sqlr="select distinct *from humvariables,humvariables_det where  humvariables.codigo=humvariables_det.codigo and humvariables_det.modulo=2 and humvariables.codigo='07' and humvariables_det.CC='".$_POST[centrocosto][$x]."'";
		$resph=mysql_query($sqlr,$linkbd);
		//echo "<br>$sqlr";
		while ($rowh =mysql_fetch_row($resph)) 
				{
				if($_POST[centrocosto][$x]==$rowh[9])
				 {
				   $ctacont=$rowh[10];	 
				   $ctapres=$rowh[11];	 
				 }
				$sqlr="Select distinct conceptoscontables_det.cuenta from conceptoscontables,conceptoscontables_det  where conceptoscontables_det.modulo='3' and conceptoscontables_det.tipo='P' and conceptoscontables_det.CC='".$_POST[centrocosto][$x]."' AND conceptoscontables_det.tipocuenta='N' AND conceptoscontables_det.codigo=(Select codconcepago from pptocuentas where cuenta='$ctapres' and vigencia='".$_SESSION[vigencia]."')";
		 		$respc = mysql_query($sqlr,$linkbd);
				//		echo "<br>$sqlr";
				while ($rowc =mysql_fetch_row($respc)) 
				{
				 $ctaconcepto=$rowc[0];
				}				
			   }
				$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$_POST[ccemp][$x]."','".$_POST[centrocosto][$x]."','Causacion Aux Alimentacion Mes ".strtoupper(strftime('%B',$lastday))."','',".$_POST[ealim][$x].",0,'1','".$_SESSION[vigencia]."')";
				mysql_query($sqlr,$linkbd);
				//echo "<br>$sqlr";
				$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctaconcepto."','".$_POST[ccemp][$x]."','".$_POST[centrocosto][$x]."','Causacion Aux Alimentacion Mes ".strtoupper(strftime('%B',$lastday))."','',0,".$_POST[ealim][$x].",'1','".$_SESSION[vigencia]."')";
				mysql_query($sqlr,$linkbd);
		 }
		
		//*****FIN ALIMENTACION **********
		//******TRANSPORTE *****
		$ctacont='';
		$ctapres='';
		if($_POST[etrans][$x]>0)
		 {
				$sqlr="select distinct *from humvariables,humvariables_det where  humvariables.codigo=humvariables_det.codigo and humvariables_det.modulo=2 and humvariables.codigo='08' and humvariables_det.CC='".$_POST[centrocosto][$x]."'";
		$resph=mysql_query($sqlr,$linkbd);
		//echo "<br>$sqlr";
		while ($rowh =mysql_fetch_row($resph)) 
				{
				if($_POST[centrocosto][$x]==$rowh[9])
				 {
				   $ctacont=$rowh[10];	 
				   $ctapres=$rowh[11];	 
				 }
				$sqlr="Select distinct conceptoscontables_det.cuenta from conceptoscontables,conceptoscontables_det  where conceptoscontables_det.modulo='3' and conceptoscontables_det.tipo='P' and conceptoscontables_det.CC='".$_POST[centrocosto][$x]."' AND conceptoscontables_det.tipocuenta='N' AND conceptoscontables_det.codigo=(Select codconcepago from pptocuentas where cuenta='$ctapres' and vigencia='".$_SESSION[vigencia]."')";
		 		$respc = mysql_query($sqlr,$linkbd);
				//		echo "<br>$sqlr";
				while ($rowc =mysql_fetch_row($respc)) 
				{
				 $ctaconcepto=$rowc[0];
				}				
			   }
				$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$_POST[ccemp][$x]."','".$_POST[centrocosto][$x]."','Causacion Aux Transporte Mes ".strtoupper(strftime('%B',$lastday))."','',".$_POST[etrans][$x].",0,'1','".$_SESSION[vigencia]."')";
				mysql_query($sqlr,$linkbd);
				//echo "<br>$sqlr";
				$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctaconcepto."','".$_POST[ccemp][$x]."','".$_POST[centrocosto][$x]."','Causacion Aux Transporte Mes ".strtoupper(strftime('%B',$lastday))."','',0,".$_POST[etrans][$x].",'1','".$_SESSION[vigencia]."')";
				mysql_query($sqlr,$linkbd);
		 }
		//****** FIN TRANSPORTE ****

		//********SALUD EMPLEADO *****
		$ctacont='';
		$ctapres='';
		$sqlrins="insert into  humnomina_saludpension (id_nom, tipo, empleado, tercero, cc, valor, estado) values()";
		$sqlr="select distinct *from humparafiscales_det where  humparafiscales_det.codigo='08' and humparafiscales_det.CC='".$_POST[centrocosto][$x]."'";
		$resph=mysql_query($sqlr,$linkbd);
		//echo "<br>$sqlr";
		while ($rowh =mysql_fetch_row($resph)) 
				{
				if($_POST[centrocosto][$x]==$rowh[2])
				 {
				   $ctacont=$rowh[3];	 
				   $ctapres=$rowh[6];	 
				 }
				 if('S'==$rowh[4])
				  {
					$debito=$_POST[saludrete][$x];
					$credito=0;
				  }
				 if('S'==$rowh[5])
				   {
					$credito=$_POST[saludrete][$x];
					$debito=0;
					}				 				 
				$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$eps."','".$_POST[centrocosto][$x]."','APORTE SALUD EMPLEADO Mes ".strtoupper(strftime('%B',$lastday))."','',".$debito.",".$credito.",'1','".$_SESSION[vigencia]."')";
				mysql_query($sqlr,$linkbd);
				$ctasalud=$ctacont;
			//	echo "<br>$sqlr";			
			   }				
		//******** FIN SALUD EMPLEADO ****
		//********PENSION EMPLEADO *****
		$ctacont='';
		$ctapres='';
				$sqlr="select distinct *from humparafiscales_det where  humparafiscales_det.codigo='10' and humparafiscales_det.CC='".$_POST[centrocosto][$x]."'";
		$resph=mysql_query($sqlr,$linkbd);
		while ($rowh =mysql_fetch_row($resph)) 
				{
				if($_POST[centrocosto][$x]==$rowh[2])
				 {
				   $ctacont=$rowh[3];	 
				   $ctapres=$rowh[6];	 
				 }
				 if('S'==$rowh[4])
				  {
					$debito=$_POST[pensionrete][$x];
					$credito=0;
				  }
				 if('S'==$rowh[5])
				   {
					$credito=$_POST[pensionrete][$x];
					$debito=0;
					}				 				 
				$sqlr2="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$afp."','".$_POST[centrocosto][$x]."','APORTE PENSION EMPLEADO Mes ".strtoupper(strftime('%B',$lastday))."','',".$debito.",".$credito.",'1','".$_SESSION[vigencia]."')";
				mysql_query($sqlr2,$linkbd);
				$ctapension=$ctacont;					
			   }				
		//******** FIN PENSION EMPLEADO ****
		//********FONDO SOLIDARIDAD EMPLEADO *****
		$ctacont='';
		$ctapres='';
		if($_POST[fondosols][$x]>0)
		 {
			$sqlr="select distinct *from humparafiscales_det where  humparafiscales_det.codigo='10' and humparafiscales_det.CC='".$_POST[centrocosto][$x]."'";
		$resph=mysql_query($sqlr,$linkbd);
		//echo "<br>$sqlr";
		while ($rowh =mysql_fetch_row($resph)) 
				{
				if($_POST[centrocosto][$x]==$rowh[2])
				 {
				   $ctacont=$rowh[3];	 
				   $ctapres=$rowh[6];	 
				 }
				 if('S'==$rowh[4])
				  {
					$debito=$_POST[fondosols][$x];
					$credito=0;
				  }
				 if('S'==$rowh[5])
				   {
					$credito=$_POST[fondosols][$x];
					$debito=0;
					}				 				 
				$sqlr2="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$afp."','".$_POST[centrocosto][$x]."','APORTE FONDO SOLIDARIDAD EMPLEADO Mes ".strtoupper(strftime('%B',$lastday))."','',".$debito.",".$credito.",'1','".$_SESSION[vigencia]."')";
				mysql_query($sqlr2,$linkbd);
			//	echo "<br>$sqlr";
			$ctapension=$ctacont;
				}
			   }				
		//******** FIN FONDO SOLIDARIDAD EMPLEADO ****		
		//********OTROS DESCUENTOS EMPLEADO *****
		$ctacont='';
		$ctapres='';
	//	echo "<br>desc".$_POST[otrasretenciones][$x];
		if($_POST[otrasretenciones][$x]>0)
		 {
			$sqlr="select distinct *from humretenempleados where humretenempleados.empleado='".$_POST[ccemp][$x]."' and humretenempleados.sncuotas>0";
		
		$respli=mysql_query($sqlr,$linkbd);
		//echo "<br>$sqlr";
		while ($rowh=mysql_fetch_row($respli)) 
				{
				$valorlibranza=$rowh[8];
				$sqlr="select distinct *from humvariablesretenciones,humvariablesretenciones_det where humvariablesretenciones.codigo='".$rowh[2]."' and humvariablesretenciones.codigo=humvariablesretenciones_det.codigo";
		$respr=mysql_query($sqlr,$linkbd);
		//echo "<br>$sqlr";
		while ($rowr=mysql_fetch_row($respr)) 
				{						
				  $ctacont=$rowr[8];	 
				 if('S'==$rowr[9])
				  {
					$debito=$valorlibranza;
					$credito=0;
				 $sqlret="INSERT INTO  humnominaretenemp (id_nom, id, cedulanit, fecha, descripcion, valor, ncta, estado) values($id,$rowh[0],'$rowh[4]','$fechaf','$rowh[1]',$debito,".($rowh[6]-$rowh[7]+1).",'S')";
				  mysql_query($sqlret,$linkbd);
				 // echo "<br>".$sqlret;
				  }
				 if('S'==$rowr[10])
				   {
					$credito=$valorlibranza;
					$debito=0;
					}				 				 
				$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$rowr[2]."','".$_POST[centrocosto][$x]."','PAGO".$rowr[1]." Mes ".strtoupper(strftime('%B',$lastday))."','',".$debito.",".$credito.",'1','".$_SESSION[vigencia]."')";
				mysql_query($sqlr,$linkbd);
			//	echo "<br>$sqlr";
				}
				}
			   }				
		//******** FIN otros descuentos EMPLEADO ****
				//****OTRAS RETENCIONES ******		
				
		$sqlr="UPDATE humretenempleados SET SNCUOTAS=SNCUOTAS-1 where estado='S' and empleado='".$_POST[ccemp][$x]."' and CONCAT(YEAR(fecha),'-',MONTH(fecha))<='".$_SESSION[vigencia]."-$_POST[periodo]' and sncuotas>0";				
	 $resp2 = mysql_query($sqlr,$linkbd);
	 $row2 =mysql_fetch_row($resp2);
		
		 $sqlr="UPDATE humretenempleados SET estado='P' where estado='S' and empleado='".$_POST[ccemp][$x]."'  and sncuotas<=0";
	 $resp2 = mysql_query($sqlr,$linkbd);
	 $row2 =mysql_fetch_row($resp2);


		//*****************************
		//******** SALUD EMPLEADOR *******
		$ctacont='';
		$ctapres='';		
			$sqlr="select distinct *from humparafiscales_det where  humparafiscales_det.codigo='07' and humparafiscales_det.CC='".$_POST[centrocosto][$x]."' ";
		$resph=mysql_query($sqlr,$linkbd);
		//echo "<br>$sqlr - $tipoafp";
		while ($rowh =mysql_fetch_row($resph)) 
				{
				if($_POST[centrocosto][$x]==$rowh[2])
				 {
				  if('N/A'==$rowh[7])
				  {
				   $ctacont=$rowh[3];	 
				   $ctapres=$rowh[6];	
				    $sqlr="Select distinct conceptoscontables_det.cuenta from conceptoscontables_det  where conceptoscontables_det.modulo='3' and conceptoscontables_det.tipo='P' and conceptoscontables_det.CC='".$_POST[centrocosto][$x]."' AND conceptoscontables_det.tipocuenta='N' AND conceptoscontables_det.codigo='15'";
		 		$respc = mysql_query($sqlr,$linkbd);
					//	echo "<br>$sqlr ";
				   while ($rowc =mysql_fetch_row($respc)) 
					{
					 $ctaconcepto=$rowc[0];
					}	 
					
					 if('S'==$rowh[4])
					  {
						$debito=$_POST[pensionemprete][$x];
						$credito=0;
				  	  }							 				 
						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$afp."','".$_POST[centrocosto][$x]."','APORTE SALUD EMPLEADOR Mes ".strtoupper(strftime('%B',$lastday))."','',".$debito.",0,'1','".$_SESSION[vigencia]."')";
						mysql_query($sqlr,$linkbd);
					//		echo "<br>$sqlr ";
						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctaconcepto."','".$afp."','".$_POST[centrocosto][$x]."','APORTE SALUD EMPLEADOR Mes ".strtoupper(strftime('%B',$lastday))."','',0,".$debito.",'1','".$_SESSION[vigencia]."')";
						mysql_query($sqlr,$linkbd);									
						//	echo "<br>$sqlr ";
				   }
				  if('publico'==$rowh[7])
				  {
					if('publico'==$tipoafp)  
					 {  $ctacont=$rowh[3];	 
					   $ctapres=$rowh[6];	 
						 $sqlr="Select distinct conceptoscontables_det.cuenta from conceptoscontables_det  where conceptoscontables_det.modulo='3' and conceptoscontables_det.tipo='P' and conceptoscontables_det.CC='".$_POST[centrocosto][$x]."' AND conceptoscontables_det.tipocuenta='N' AND conceptoscontables_det.codigo='15'";
		 		$respc = mysql_query($sqlr,$linkbd);
						//echo "<br>$sqlr";
					   while ($rowc =mysql_fetch_row($respc)) 
						{
						 $ctaconcepto=$rowc[0];
						}	
					 if('S'==$rowh[4])
						  {
							$debito=$_POST[pensionemprete][$x];
							$credito=0;
						  }							 				 
							$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$afp."','".$_POST[centrocosto][$x]."','APORTE SALUD EMPLEADOR Mes ".strtoupper(strftime('%B',$lastday))."','',".$debito.",0,'1','".$_SESSION[vigencia]."')";
							mysql_query($sqlr,$linkbd);
						//	echo "<br>$sqlr";
							$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctaconcepto."','".$afp."','".$_POST[centrocosto][$x]."','APORTE SALUD EMPLEADOR Mes ".strtoupper(strftime('%B',$lastday))."','',0,".$debito.",'1','".$_SESSION[vigencia]."')";
							mysql_query($sqlr,$linkbd);																   
						//	echo "<br>$sqlr";
					 }
				   }
				  if('privado'==$rowh[7])
				  {
					  //echo "<br>$rowh[7] - $tipoafp";
					if('privado'==$tipoafp)  
					 {  
					  $ctacont=$rowh[3];	 
					   $ctapres=$rowh[6];	 
					    $sqlr="Select distinct conceptoscontables_det.cuenta from conceptoscontables_det  where conceptoscontables_det.modulo='3' and conceptoscontables_det.tipo='P' and conceptoscontables_det.CC='".$_POST[centrocosto][$x]."' AND conceptoscontables_det.tipocuenta='N' AND conceptoscontables_det.codigo='15'";
		 		$respc = mysql_query($sqlr,$linkbd);
						
					   while ($rowc =mysql_fetch_row($respc)) 
						{
						 $ctaconcepto=$rowc[0];
						}	
					 if('S'==$rowh[4])
						  {
						$debito=$_POST[pensionemprete][$x];
						$credito=0;
				  			}							 				 
							$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$afp."','".$_POST[centrocosto][$x]."','APORTE SALUD EMPLEADOR Mes ".strtoupper(strftime('%B',$lastday))."','',".$debito.",0,'1','".$_SESSION[vigencia]."')";
							mysql_query($sqlr,$linkbd);
							//echo "<br>$sqlr";
							$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctaconcepto."','".$afp."','".$_POST[centrocosto][$x]."','APORTE SALUD EMPLEADOR Mes ".strtoupper(strftime('%B',$lastday))."','',0,".$debito.",'1','".$_SESSION[vigencia]."')";
							mysql_query($sqlr,$linkbd);
							//echo "<br>$sqlr";
					 }
				  }				  	
				 }
				}
			 //**************FIN SALUD EMPLEADOR		
		//******** PENSIONES EMPLEADOR *******
		$ctacont='';
		$ctapres='';		
			$sqlr="select distinct *from humparafiscales_det where  humparafiscales_det.codigo='09' and humparafiscales_det.CC='".$_POST[centrocosto][$x]."' ";
		$resph=mysql_query($sqlr,$linkbd);
		//echo "<br>$sqlr - $tipoafp";
		while ($rowh =mysql_fetch_row($resph)) 
				{
				if($_POST[centrocosto][$x]==$rowh[2])
				 {
				  if('N/A'==$rowh[7])
				  {
				   $ctacont=$rowh[3];	 
				   $ctapres=$rowh[6];	
				    $sqlr="Select distinct conceptoscontables_det.cuenta from conceptoscontables_det  where conceptoscontables_det.modulo='3' and conceptoscontables_det.tipo='P' and conceptoscontables_det.CC='".$_POST[centrocosto][$x]."' AND conceptoscontables_det.tipocuenta='N' AND conceptoscontables_det.codigo='14'";
		 		$respc = mysql_query($sqlr,$linkbd);
					//	echo "<br>$sqlr ";
				   while ($rowc =mysql_fetch_row($respc)) 
					{
					 $ctaconcepto=$rowc[0];
					}	 
					
					 if('S'==$rowh[4])
					  {
						$debito=$_POST[pensionemprete][$x];
						$credito=0;
				  	  }							 				 
						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$afp."','".$_POST[centrocosto][$x]."','APORTE PENSIONES EMPLEADOR Mes ".strtoupper(strftime('%B',$lastday))."','',".$debito.",0,'1','".$_SESSION[vigencia]."')";
						mysql_query($sqlr,$linkbd);
		//					echo "<br>$sqlr ";
						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctaconcepto."','".$afp."','".$_POST[centrocosto][$x]."','APORTE PENSIONES EMPLEADOR Mes ".strtoupper(strftime('%B',$lastday))."','',0,".$debito.",'1','".$_SESSION[vigencia]."')";
						mysql_query($sqlr,$linkbd);	
			//			echo "<br>$sqlr ";
				   }
				  if('publico'==$rowh[7])
				  {
					if('publico'==$tipoafp)  
					 {  $ctacont=$rowh[3];	 
					   $ctapres=$rowh[6];	 
						 $sqlr="Select distinct conceptoscontables_det.cuenta from conceptoscontables_det  where conceptoscontables_det.modulo='3' and conceptoscontables_det.tipo='P' and conceptoscontables_det.CC='".$_POST[centrocosto][$x]."' AND conceptoscontables_det.tipocuenta='N' AND conceptoscontables_det.codigo='14'";
		 		$respc = mysql_query($sqlr,$linkbd);
			//			echo "<br>$sqlr";
					   while ($rowc =mysql_fetch_row($respc)) 
						{
						 $ctaconcepto=$rowc[0];
						}	
					 if('S'==$rowh[4])
						  {
							$debito=$_POST[pensionemprete][$x];
							$credito=0;
						  }							 				 
							$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$afp."','".$_POST[centrocosto][$x]."','APORTE PENSIONES EMPLEADOR Mes ".strtoupper(strftime('%B',$lastday))."','',".$debito.",0,'1','".$_SESSION[vigencia]."')";
							mysql_query($sqlr,$linkbd);
	//echo "<br>$sqlr ";
							$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctaconcepto."','".$afp."','".$_POST[centrocosto][$x]."','APORTE PENSIONES EMPLEADOR Mes ".strtoupper(strftime('%B',$lastday))."','',0,".$debito.",'1','".$_SESSION[vigencia]."')";
							mysql_query($sqlr,$linkbd);															   
	//echo "<br>$sqlr ";							
					 }
				   }
				  if('privado'==$rowh[7])
				  {
				//	  echo "<br>$rowh[7] - $tipoafp";
					if('privado'==$tipoafp)  
					 {  
					  $ctacont=$rowh[3];	 
					   $ctapres=$rowh[6];	 
					    $sqlr="Select distinct conceptoscontables_det.cuenta from conceptoscontables_det  where conceptoscontables_det.modulo='3' and conceptoscontables_det.tipo='P' and conceptoscontables_det.CC='".$_POST[centrocosto][$x]."' AND conceptoscontables_det.tipocuenta='N' AND conceptoscontables_det.codigo='14'";
		 		$respc = mysql_query($sqlr,$linkbd);
					//	echo "<br>$sqlr";
					   while ($rowc =mysql_fetch_row($respc)) 
						{
						 $ctaconcepto=$rowc[0];
						}	
					 if('S'==$rowh[4])
						  {
						$debito=$_POST[pensionemprete][$x];
						$credito=0;
				  			}							 				 
							$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$afp."','".$_POST[centrocosto][$x]."','APORTE PENSIONES EMPLEADOR Mes ".strtoupper(strftime('%B',$lastday))."','',".$debito.",0,'1','".$_SESSION[vigencia]."')";
							mysql_query($sqlr,$linkbd);
	//echo "<br>$sqlr ";
							$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctaconcepto."','".$afp."','".$_POST[centrocosto][$x]."','APORTE PENSIONES EMPLEADOR Mes ".strtoupper(strftime('%B',$lastday))."','',0,".$debito.",'1','".$_SESSION[vigencia]."')";
							mysql_query($sqlr,$linkbd);	
	//echo "<br>$sqlr ";
					 }
				  }				  	
				 }
				}
			 //**************FIN PENSION EMPLEADOR		
			 
			 //******ARP ******
			 
			$ctacont='';
			$ctapres='';		
			$sqlr="select distinct *from humparafiscales_det inner join humparafiscales on humparafiscales_det.codigo=humparafiscales.codigo  where  humparafiscales_det.codigo='06' and humparafiscales_det.CC='".$_POST[centrocosto][$x]."' ";
		$resph=mysql_query($sqlr,$linkbd);		
		while ($rowh =mysql_fetch_row($resph)) 
				{
				if($_POST[centrocosto][$x]==$rowh[2])
				 {				 
				   $ctacont=$rowh[3];	 
				   $ctapres=$rowh[6];	
				    $sqlr="Select distinct conceptoscontables_det.cuenta from conceptoscontables_det  where conceptoscontables_det.modulo='3' and conceptoscontables_det.tipo='P' and conceptoscontables_det.CC='".$_POST[centrocosto][$x]."' AND conceptoscontables_det.tipocuenta='N' AND conceptoscontables_det.codigo=(Select codconcepago from pptocuentas where cuenta='$ctapres' and vigencia='".$_SESSION[vigencia]."')";
		 		$respc = mysql_query($sqlr,$linkbd);
				//		echo "<br>$sqlr ";
				   while ($rowc =mysql_fetch_row($respc)) 
					{
					 $ctaconcepto=$rowc[0];
					}	 
					
					 if('S'==$rowh[4])
					  {
						$debito=$_POST[arpemp][$x];
						$credito=0;
				  	  }							 				 
						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$arp."','".$_POST[centrocosto][$x]."','APORTE ARP EMPLEADOR Mes ".strtoupper(strftime('%B',$lastday))."','',".$debito.",0,'1','".$_SESSION[vigencia]."')";
						mysql_query($sqlr,$linkbd);
					$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctaconcepto."','".$arp."','".$_POST[centrocosto][$x]."','APORTE ARP EMPLEADOR Mes ".strtoupper(strftime('%B',$lastday))."','',0,".$debito.",'1','".$_SESSION[vigencia]."')";
					mysql_query($sqlr,$linkbd);		
				//	$sqlr="insert into humnomina_parafiscales (id_nom, id_parafiscal, porcentaje, valor, cc) values ($id,'06',$rowh[13],$debito,'".$_POST[centrocosto][$x]."')";			
					//	mysql_query($sqlr,$linkbd);		
						//		echo "<br>$sqlr ";								
				   }
				}
			 //***** FIN ARP *****	
			 
			 //********CESANTIAS*****
		$ctacont='';
		$ctapres='';
			$sqlr="select distinct *from humparafiscales_det inner join humparafiscales on humparafiscales_det.codigo=humparafiscales.codigo where  humparafiscales_det.codigo='11' and humparafiscales_det.CC='".$_POST[centrocosto][$x]."'";
		$resph=mysql_query($sqlr,$linkbd);
		//echo "<br>$sqlr";
		while ($rowh =mysql_fetch_row($resph)) 
				{
				if($_POST[centrocosto][$x]==$rowh[2])
				 {
				   $ctacont=$rowh[3];	 
				   $ctapres=$rowh[6];	 
				   $cesantias=round($_POST[totaldev][$x]*($rowh[13]/100),0);
				 }
				 if('S'==$rowh[4])
				  {					
					$debito=round($_POST[totaldev][$x]*($rowh[13]/100),0);
					$credito=0;
				  }
				 if('S'==$rowh[5])
				   {
					$credito=round($_POST[totaldev][$x]*($rowh[13]/100),0);
					$debito=0;
					}				 				 
				$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$_POST[ccemp][$x]."','".$_POST[centrocosto][$x]."','PROVISION CESANTIAS EMPLEADO Mes ".strtoupper(strftime('%B',$lastday))."','',".$debito.",".$credito.",'1','".$_SESSION[vigencia]."')";
				mysql_query($sqlr,$linkbd);
				//echo "<br>$sqlr";
			$ctapension=$ctacont;
				}			 		
		//******** FIN CESANTIAS EMPLEADO ****	
		//********INTERESES CESANTIAS*****
		$ctacont='';
		$ctapres='';
			$sqlr="select distinct *from humparafiscales_det inner join humparafiscales on humparafiscales_det.codigo=humparafiscales.codigo where  humparafiscales_det.codigo='12' and humparafiscales_det.CC='".$_POST[centrocosto][$x]."'";
		$resph=mysql_query($sqlr,$linkbd);
		//echo "<br>$sqlr";
		while ($rowh =mysql_fetch_row($resph)) 
				{
				if($_POST[centrocosto][$x]==$rowh[2])
				 {
				   $ctacont=$rowh[3];	 
				   $ctapres=$rowh[6];	 
				 }
				 if('S'==$rowh[4])
				  {					
					$debito=round($cesantias*($rowh[13]/100)*$_POST[diast][$x]/360,0);
					$credito=0;
				  }
				 if('S'==$rowh[5])
				   {
					$credito=round($cesantias*($rowh[13]/100)*$_POST[diast][$x]/360,0);
					$debito=0;
					}				 				 
				$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$_POST[ccemp][$x]."','".$_POST[centrocosto][$x]."','PROVISION CESANTIAS EMPLEADO Mes ".strtoupper(strftime('%B',$lastday))."','',".$debito.",".$credito.",'1','".$_SESSION[vigencia]."')";
				mysql_query($sqlr,$linkbd);
			//echo "<br>$sqlr";
			$ctapension=$ctacont;
				}			 		
		//******** FIN INTERESES CESANTIAS EMPLEADO ****	
					
			 //******************
		}		 //**FIN DEL FOR DE EMPLEADOS
															
	 }
	 	 //***********PARAFISCALES ******
		 //****ARP DETALLE PARAFISCALES
		 
		 $sqlr="insert into humnomina_parafiscales (id_nom, id_parafiscal, porcentaje, valor, cc) values ($id,'06',$rowh[13],$debito,'".$_POST[centrocosto][$x]."')";			
		  mysql_query($sqlr,$linkbd);	
		 
		 
		 //*****
		 
			 //CAJAS DE COMPENSACION
			 $sqlr="select *from centrocosto where estado='S'";
	 $rescc=mysql_query($sqlr,$linkbd);
//	 echo "<br>$sqlr";
	 while ($rowcc =mysql_fetch_row($rescc)) 
	 {
			$ctacont='';
			$ctapres='';		
		  if($pf['01'][$rowcc[0]]>0)
		   {			
			$sqlr="select distinct *from humparafiscales_det  inner join humparafiscales on humparafiscales_det.codigo=humparafiscales.codigo where  humparafiscales_det.codigo='01' and humparafiscales_det.CC='$rowcc[0]' ";
		$resph=mysql_query($sqlr,$linkbd);		
		while ($rowh =mysql_fetch_row($resph)) 
				{
				if($rowcc[0]==$rowh[2])
				 {				 
				   $ctacont=$rowh[3];	 
				   $ctapres=$rowh[6];	
				    $sqlr="Select distinct conceptoscontables_det.cuenta from conceptoscontables_det  where conceptoscontables_det.modulo='3' and conceptoscontables_det.tipo='P' and conceptoscontables_det.CC='$rowcc[0]' AND conceptoscontables_det.tipocuenta='N' AND conceptoscontables_det.codigo=(Select codconcepago from pptocuentas where cuenta='$ctapres' and vigencia='".$_SESSION[vigencia]."')";
		 		$respc = mysql_query($sqlr,$linkbd);
					//	echo "<br>$sqlr ";
				   while ($rowc =mysql_fetch_row($respc)) 
					{
					 $ctaconcepto=$rowc[0];
					}	 
					
					 if('S'==$rowh[4])
					  {
						$debito=$pf['01'][$rowcc[0]];
						$credito=0;
				  	  }							 				 
						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$_POST[cajacomp]."','".$rowcc[0]."','APORTE CAJA COMPENSACION Mes ".strtoupper(strftime('%B',$lastday))."','',".$debito.",0,'1','".$_SESSION[vigencia]."')";
						mysql_query($sqlr,$linkbd);
						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctaconcepto."','".$_POST[cajacomp]."','".$rowcc[0]."','APORTE CAJA COMPENSACION Mes ".strtoupper(strftime('%B',$lastday))."','',0,".$debito.",'1','".$_SESSION[vigencia]."')";
						mysql_query($sqlr,$linkbd);	
												//***nomina parafiscales
						$sqlr="insert into humnomina_parafiscales (id_nom, id_parafiscal, porcentaje, valor, cc) values ($id,'01',$rowh[13],$debito,'$rowcc[0]')";			
						mysql_query($sqlr,$linkbd);											
				   }
				}
		   }
	 }
				//*************FIN CAJAS DE COMP
			 //ICBF
		 $sqlr="select *from centrocosto where estado='S'";
	 $rescc=mysql_query($sqlr,$linkbd);
//	 echo "<br>$sqlr";
	 while ($rowcc =mysql_fetch_row($rescc)) 
	 {
			$ctacont='';
			$ctapres='';		
		  if($pf['02'][$rowcc[0]]>0)
		   {			
			$sqlr="select distinct *from humparafiscales_det  inner join humparafiscales on humparafiscales_det.codigo=humparafiscales.codigo where  humparafiscales_det.codigo='02' and humparafiscales_det.CC='$rowcc[0]' ";
		$resph=mysql_query($sqlr,$linkbd);		
		while ($rowh =mysql_fetch_row($resph)) 
				{
				if($rowcc[0]==$rowh[2])
				 {				 
				   $ctacont=$rowh[3];	 
				   $ctapres=$rowh[6];	
				    $sqlr="Select distinct conceptoscontables_det.cuenta from conceptoscontables_det  where conceptoscontables_det.modulo='3' and conceptoscontables_det.tipo='P' and conceptoscontables_det.CC='$rowcc[0]' AND conceptoscontables_det.tipocuenta='N' AND conceptoscontables_det.codigo=(Select codconcepago from pptocuentas where cuenta='$ctapres' and vigencia='".$_SESSION[vigencia]."')";
		 		$respc = mysql_query($sqlr,$linkbd);
				//		echo "<br>$sqlr ";
				   while ($rowc =mysql_fetch_row($respc)) 
					{
					 $ctaconcepto=$rowc[0];
					}	 
					
					 if('S'==$rowh[4])
					  {
						$debito=$pf['02'][$rowcc[0]];
						$credito=0;
				  	  }							 				 
						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$_POST[icbf]."','".$rowcc[0]."','APORTE ICBF Mes ".strtoupper(strftime('%B',$lastday))."','',".$debito.",0,'1','".$_SESSION[vigencia]."')";
						mysql_query($sqlr,$linkbd);
						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctaconcepto."','".$_POST[icbf]."','".$rowcc[0]."','APORTE ICBF Mes ".strtoupper(strftime('%B',$lastday))."','',0,".$debito.",'1','".$_SESSION[vigencia]."')";
						mysql_query($sqlr,$linkbd);	
												//***nomina parafiscales
						$sqlr="insert into humnomina_parafiscales (id_nom, id_parafiscal, porcentaje, valor, cc) values ($id,'02',$rowh[13],$debito,'$rowcc[0]')";			
						mysql_query($sqlr,$linkbd);											
				   }
				}
		   }
	 }
				//*************FIN ICBF
 		//SENA
		 $sqlr="select *from centrocosto where estado='S'";
	 $rescc=mysql_query($sqlr,$linkbd);
//	 echo "<br>$sqlr";
	 while ($rowcc =mysql_fetch_row($rescc)) 
	 {
			$ctacont='';
			$ctapres='';		
		  if($pf['03'][$rowcc[0]]>0)
		   {			
			$sqlr="select distinct *from humparafiscales_det inner join humparafiscales on humparafiscales_det.codigo=humparafiscales.codigo where  humparafiscales_det.codigo='03' and humparafiscales_det.CC='$rowcc[0]' ";
		$resph=mysql_query($sqlr,$linkbd);		
		while ($rowh =mysql_fetch_row($resph)) 
				{
				if($rowcc[0]==$rowh[2])
				 {				 
				   $ctacont=$rowh[3];	 
				   $ctapres=$rowh[6];	
				    $sqlr="Select distinct conceptoscontables_det.cuenta from conceptoscontables_det  where conceptoscontables_det.modulo='3' and conceptoscontables_det.tipo='P' and conceptoscontables_det.CC='$rowcc[0]' AND conceptoscontables_det.tipocuenta='N' AND conceptoscontables_det.codigo=(Select codconcepago from pptocuentas where cuenta='$ctapres' and vigencia='".$_SESSION[vigencia]."')";
		 		$respc = mysql_query($sqlr,$linkbd);
				//		echo "<br>$sqlr ";
				   while ($rowc =mysql_fetch_row($respc)) 
					{
					 $ctaconcepto=$rowc[0];
					}	 
					
					 if('S'==$rowh[4])
					  {
						$debito=$pf['03'][$rowcc[0]];
						$credito=0;
				  	  }							 				 
						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$_POST[sena]."','".$rowcc[0]."','APORTE SENA Mes ".strtoupper(strftime('%B',$lastday))."','',".$debito.",0,'1','".$_SESSION[vigencia]."')";
						mysql_query($sqlr,$linkbd);
						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctaconcepto."','".$_POST[sena]."','".$rowcc[0]."','APORTE SENA Mes ".strtoupper(strftime('%B',$lastday))."','',0,".$debito.",'1','".$_SESSION[vigencia]."')";
						mysql_query($sqlr,$linkbd);		
						//***nomina parafiscales
						$sqlr="insert into humnomina_parafiscales (id_nom, id_parafiscal, porcentaje, valor, cc) values ($id,'03',$rowh[13],$debito,'$rowcc[0]')";			
						mysql_query($sqlr,$linkbd);																
				   }
				}
		   }
	 }
				//*************FIN SENA		
//ITI
			 $sqlr="select *from centrocosto where estado='S'";
	 $rescc=mysql_query($sqlr,$linkbd);
//	 echo "<br>$sqlr";
	 while ($rowcc =mysql_fetch_row($rescc)) 
	 {
			$ctacont='';
			$ctapres='';		
		  if($pf['04'][$rowcc[0]]>0)
		   {			
			$sqlr="select distinct *from humparafiscales_det inner join humparafiscales on humparafiscales_det.codigo=humparafiscales.codigo where  humparafiscales_det.codigo='04' and humparafiscales_det.CC='$rowcc[0]' ";
		$resph=mysql_query($sqlr,$linkbd);		
		while ($rowh =mysql_fetch_row($resph)) 
				{
				if($rowcc[0]==$rowh[2])
				 {				 
				   $ctacont=$rowh[3];	 
				   $ctapres=$rowh[6];	
				    $sqlr="Select distinct conceptoscontables_det.cuenta from conceptoscontables_det  where conceptoscontables_det.modulo='3' and conceptoscontables_det.tipo='P' and conceptoscontables_det.CC='$rowcc[0]' AND conceptoscontables_det.tipocuenta='N' AND conceptoscontables_det.codigo=(Select codconcepago from pptocuentas where cuenta='$ctapres' and vigencia='".$_SESSION[vigencia]."')";
		 		$respc = mysql_query($sqlr,$linkbd);
				//		echo "<br>$sqlr ";
				   while ($rowc =mysql_fetch_row($respc)) 
					{
					 $ctaconcepto=$rowc[0];
					}	 
					
					 if('S'==$rowh[4])
					  {
						$debito=$pf['04'][$rowcc[0]];
						$credito=0;
				  	  }							 				 
						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$_POST[iti]."','".$rowcc[0]."','APORTE INST TECNICOS Mes ".strtoupper(strftime('%B',$lastday))."','',".$debito.",0,'1','".$_SESSION[vigencia]."')";
						mysql_query($sqlr,$linkbd);
						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctaconcepto."','".$_POST[iti]."','".$rowcc[0]."','APORTE INST TECNICOS Mes ".strtoupper(strftime('%B',$lastday))."','',0,".$debito.",'1','".$_SESSION[vigencia]."')";
						mysql_query($sqlr,$linkbd);		
												//***nomina parafiscales
						$sqlr="insert into humnomina_parafiscales (id_nom, id_parafiscal, porcentaje, valor, cc) values ($id,'04',$rowh[13],$debito,'$rowcc[0]')";			
						mysql_query($sqlr,$linkbd);										
				   }
				}
		   }
	 }
				//*************FIN ITI		
			//ESAP********
	 $sqlr="select *from centrocosto where estado='S'";
	 $rescc=mysql_query($sqlr,$linkbd);
//	 echo "<br>$sqlr";
	 while ($rowcc =mysql_fetch_row($rescc)) 
	 {
			$ctacont='';
			$ctapres='';
		//		 echo "<br>ESAP $rowcc[0]: ".$pf['05'][$rowcc[0]];
		  if($pf['05'][$rowcc[0]]>0)
		   {			
			$sqlr="select distinct *from humparafiscales_det inner join humparafiscales on humparafiscales_det.codigo=humparafiscales.codigo where  humparafiscales_det.codigo='05' and humparafiscales_det.CC='$rowcc[0]' ";
		$resph=mysql_query($sqlr,$linkbd);		
		while ($rowh =mysql_fetch_row($resph)) 
				{
				if($rowcc[0]==$rowh[2])
				 {				 
				   $ctacont=$rowh[3];	 
				   $ctapres=$rowh[6];	
				    $sqlr="Select distinct conceptoscontables_det.cuenta from conceptoscontables_det  where conceptoscontables_det.modulo='3' and conceptoscontables_det.tipo='P' and conceptoscontables_det.CC='$rowcc[0]' AND conceptoscontables_det.tipocuenta='N' AND conceptoscontables_det.codigo=(Select codconcepago from pptocuentas where cuenta='$ctapres' and vigencia='".$_SESSION[vigencia]."')";
		 		$respc = mysql_query($sqlr,$linkbd);
				//		echo "<br>$sqlr ";
				   while ($rowc =mysql_fetch_row($respc)) 
					{
					 $ctaconcepto=$rowc[0];
					}	 
					
					 if('S'==$rowh[4])
					  {
						$debito=$pf['05'][$rowcc[0]];
						$credito=0;
				  	  }							 				 
						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$_POST[esap]."','".$rowcc[0]."','APORTE ESAP Mes ".strtoupper(strftime('%B',$lastday))."','',".$debito.",0,'1','".$_SESSION[vigencia]."')";
						mysql_query($sqlr,$linkbd);
						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctaconcepto."','".$_POST[esap]."','".$rowcc[0]."','APORTE ESAP Mes ".strtoupper(strftime('%B',$lastday))."','',0,".$debito.",'1','".$_SESSION[vigencia]."')";
						mysql_query($sqlr,$linkbd);	
						//***nomina parafiscales
						$sqlr="insert into humnomina_parafiscales (id_nom, id_parafiscal, porcentaje, valor, cc) values ($id,'05',$rowh[13],$debito,'$rowcc[0]')";			
						mysql_query($sqlr,$linkbd);								
				   }
				}
		   }
	 }
				//*************FIN ESAP	
				
					//ARP********
	 $sqlr="select *from centrocosto where estado='S'";
	 $rescc=mysql_query($sqlr,$linkbd);
//	 echo "<br>$sqlr";
	 while ($rowcc =mysql_fetch_row($rescc)) 
	 {
			$ctacont='';
			$ctapres='';
		
		  if($pf['06'][$rowcc[0]]>0)
		   {			
			$sqlr="select distinct *from humparafiscales_det inner join humparafiscales on humparafiscales_det.codigo=humparafiscales.codigo where  humparafiscales_det.codigo='06' and humparafiscales_det.CC='$rowcc[0]' ";
		$resph=mysql_query($sqlr,$linkbd);		
		while ($rowh =mysql_fetch_row($resph)) 
				{
				if($rowcc[0]==$rowh[2])
				 {				 
				   $ctacont=$rowh[3];	 
				   $ctapres=$rowh[6];					    
					
					 if('S'==$rowh[4])
					  {
						$debito=$pf['06'][$rowcc[0]];
						$credito=0;
				  	  						 				 						
						//***nomina parafiscales
						$sqlr="insert into humnomina_parafiscales (id_nom, id_parafiscal, porcentaje, valor, cc) values ($id,'06',$rowh[13],$debito,'$rowcc[0]')";			
						mysql_query($sqlr,$linkbd);								
					  }		
				   }
				}
		   }
	 }
				//*************FIN arp	
	  echo "<table class='inicio'><tr><td class='saludo1'><center>Registros Exitosos:$cex   -   Registros Erroneos: $cerr<img src='imagenes\confirm.png'></center></td></tr></table>"; 
	}
 }
?>
</form>
</td></tr>     
</table>
</body>
</html>