<?php //V 1000 12/12/16 ?> 
<?php
require"comun.inc";
require"funciones.inc";
sesion();
cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
//**niveles menu: Administracion (0) - Consultas (1) - Herramientas (2) - Reportes (3)
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
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

function pdf()
{
document.form2.action="pdfplanillapago.php";
document.form2.target="_BLANK";
document.form2.submit(); 
document.form2.action="";
document.form2.target="";
}
</script>
<script type="text/javascript" src="css/calendario.js"></script>
<script type="text/javascript" src="css/programas.js"></script>
<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
    <tr><script>barra_imagenes("hum");</script><?php cuadro_titulos();?></tr>	 
    <tr><?php menu_desplegable("hum");?></tr>
<tr>
  <td colspan="3" class="cinta"><a href="hum-liquidarnominaaprobar.php" class="mgbt"><img src="imagenes/add.png" alt="Nuevo" /></a><a href="#"  onClick="" class="mgbt"><img src="imagenes/guardad.png" alt="Guardar" /></a><a onClick="document.form2.submit();" href="hum-buscanominasaprobadas.php" class="mgbt"><img src="imagenes/busca.png" alt="Buscar" /></a> <a href="#" onClick="mypop=window.open('hum-principal.php','','');mypop.focus();" class="mgbt"> <img src="imagenes/nv.png" alt="nueva ventana"> </a><a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png" alt="imprimir"></a><a href="#" onClick='excell()' class="mgbt"> <img src="imagenes/excel.png"  alt="excel"> </a></td></tr>	
  		</table>
<tr><td colspan="3" class="tablaprin"> 
 <form name="form2" method="post" action="">
<?php
$linkbd=conectar_bd();
$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
	if(!$_POST[oculto])
	{
	$linkbd=conectar_bd();
	$sqlr="select * from  humnomina_aprobado where id_nom=$_GET[idr]";
		$res=mysql_query($sqlr,$linkbd);
		$consec=0;
		while($r=mysql_fetch_row($res))
		 {
		  $_POST[idliq]=$r[1];	
		  $_POST[idcomp]=$r[0];
		  $_POST[rp]=$r[3];  
		  $_POST[fecha]=$r[2];
	 	}
	 	//$consec+=1;	 	
		 //$fec=date("d/m/Y");
		 //$_POST[fecha]=$fec; 
		
	}
		 $pf[]=array();
		 $pfcp=array();	
?>
<table  class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="10">:: Buscar Liquidaciones</td><td class="cerrar" ><a href="hum-principal.php">Cerrar</a></td>
      </tr>
      <tr><td class="saludo1">No Aprobacion</td><td><input name="idcomp" type="text" size="5" value="<?php echo $_POST[idcomp]?>" readonly></td><td class="saludo1">No Liquidacion</td><td><select name="idliq" id="idliq" onChange="validar()" disabled="disabled" >
				  <option value="-1">Sel ...</option>
				 <?php
				 $sqlr="Select *  from humnomina where humnomina.estado='P'";
		 		 $resp = mysql_query($sqlr,$linkbd);
				 while ($row =mysql_fetch_row($resp)) 
				 {
				 $i=$row[0];
				 echo "<option value=$row[0] ";
				 if($i==$_POST[idliq])
			 	 {
				  echo "SELECTED";
				  $_POST[tperiodo]=$row[2];	
  				  $_POST[periodo]=$row[3];
				  $_POST[cc]=$row[6];
				  $_POST[diasperiodo]=$row[4];				  
				 }
				 echo " >".$row[0]."</option>";	  
			     }   
				?>
		  </select></td><td class="saludo1">Fecha</td><td><input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10" size="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" readonly>   <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/calendario04.png" style="width:20px;" align="absmiddle" border="0"></a>  </td><td class="saludo1">RP</td> <td>
      <select name="rp" id="rp" onChange="validar()" disabled="disabled" >
				  <option value="-1">Sel ...</option>
				 <?php
				 $sqlr="Select humnom_rp.consvigencia, pptorp.valor, pptorp.idcdp  from humnom_rp inner join pptorp on humnom_rp.consvigencia=pptorp.consvigencia  where humnom_rp.estado='S' and humnom_rp.vigencia='".$vigusu."'";
		 		 $resp = mysql_query($sqlr,$linkbd);
				 while ($row =mysql_fetch_row($resp)) 
				 {
				 $i=$row[0];
				 echo "<option value=$row[0] ";
				 if($i==$_POST[rp])
			 	 {
				  echo "SELECTED";
				  $_POST[rp]=$row[0];	
  				  $_POST[valorp]=$row[1];
				  $_POST[hvalorp]=$row[1];
				  $_POST[cdp]=$row[2];				  
				 }
				 echo " >".$row[0]."</option>";	  
			     }   
				?>
		  </select>
      <input type="hidden" value="<?php echo $_POST[hvalorp]?>" name="hvalorp">
      <input type="text" value="<?php echo number_format($_POST[valorp],2)?>" name="valorp" size="14" readonly></td><td class="saludo1">CDP:</td>
	  <td>
<input type="text" id="cdp" name="cdp" value="<?php echo $_POST[cdp]?>" size="10" readonly></td></tr>
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
		$sqlr="select *from admfiscales where vigencia='".$vigusu."'";
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
<select name="tperiodo" id="tperiodo" onChange="validar()" disabled="disabled">
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
          <select name="cc"  onChange="validar()" onKeyUp="return tabular(event,this)" disabled="disabled">
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
          <td ><select name="periodo" id="periodo" onChange="validar()"  disabled="disabled" >
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
           </td>
       </tr>                       
    </table>    
	<div class="subpantalla">
      <?php

$linkbd=conectar_bd();
$crit1=" ";
$crit2=" ";
//sacar el consecutivo 

echo "<table class='inicio' align='center' width='99%'><tr><td colspan='18' class='titulos'>.: Resultados Busqueda: $ntr Empleados</td></tr><tr><td class='titulos2' width='1%'>Vac</td><td class='titulos2' >EMPLEADO</td><td class='titulos2' width='2%'>CC</td><td class='titulos2' >SAL BAS</td><td class='titulos2' >DIAS LIQ</td><td class='titulos2' >DIAS NOV</td><td class='titulos2' >DEVENGADO</td><td class='titulos2' >AUX ALIM</td><td class='titulos2' >AUX TRAN</td><td class='titulos2' >HORAS EXTRAS</td><td class='titulos2' >TOT DEV</td><td class='titulos2' >SALUD</td><td class='titulos2' >PENSION</td><td class='titulos2' >F SOLIDA</td><td class='titulos2' >RETE FTE</td><td class='titulos2' >OTRAS DEDUC</td><td class='titulos2' >TOT DEDUC</td><td class='titulos2' >NETO PAG</td></tr>";	

$sqlr="select *from humnomina_det where id_nom=$_POST[idliq]";
$resp = mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($resp)) 
				{
				$_POST[ccemp][$con]=$row[1];
				$_POST[nomemp][$con]=buscatercero($row[1]);		
				$salario=$row[2];
				$_POST[diast][$con]=$row[3];
				$_POST[diastnov][$con]=$row[21];
				$deven=$row[4];
				$auxalimtot=$row[6];
				$auxtratot=$row[7];
				$ibc=$row[5];
				$horaextra=$row[8];
				$totdev=$row[9];
				$arpemp=$row[9];
				$rsalud=$row[10];
				$rsaludemp=$row[11];
				$valsaludtot=$row[10]+$row[11];
				$rpension=$row[12];
				$rpensionemp=$row[13];
				$fondosol=$row[14];
				$valpensiontot=$row[12]+$row[13]+$row[14];
				$otrasrete=$row[16];
				$totalretenciones=$row[17];
				$totalneto=$row[18];
				$chk='';
				if($row[20]=='S')
				 {
				  $chk='checked';
				 }
				 echo "<tr  id='fila$row[1]' class='saludo3' $style><td ><input type='checkbox' name='empleados[]' value='".$_POST[ccemp][$con]."'  onClick='marcar(".$_POST[empleados][$con].",$con);' $chk disabled><input name='vacacion' type='hidden' value='$row[20]'></td><td ><input type='hidden' name='nomemp[]' value='".$_POST[nomemp][$con]."'>".$_POST[nomemp][$con]."</td><td ><input type='hidden' name='ccemp[]' value='".$_POST[ccemp][$con]."'>".$_POST[ccemp][$con]."</td><td ><input type='hidden' name='centrocosto[]' value='".$row[31]."' size='8' readonly><input type='text' name='salbas[]' value='$salario' size='8' readonly> </td><td ><input type='text' size='2' name='diast[]' value='".$_POST[diast][$con]."'  onKeyPress='javascript:return solonumeros(event)' onKeyUp='return tabular(event,this)' onBlur='document.form2.submit()' readonly> </td><td ><input type='text' size='2' name='diastnov[]' value='".$_POST[diastnov][$con]."'  onKeyPress='javascript:return solonumeros(event)' onKeyUp='return tabular(event,this)' onBlur='document.form2.submit()' readonly> </td><td ><input type='text' size='8' name='devengado[]' value='".($deven)."' readonly> </td><td ><input type='text' size='5' name='ealim[]' value='".($auxalimtot)."' readonly>  </td><td ><input type='text' size='5' name='etrans[]' value='".($auxtratot)."' readonly>  </td><td ><input type='text' name='horaextra[]' value='$horaextra' size='8' readonly> </td><td ><input type='text' name='totaldev[]' value='$totdev' size='8' readonly><input type='hidden' name='ibc[]' value='$ibc' size='8' readonly></td><td ><input type='hidden' name='arpemp[]' value='$varp' ><input type='text' name='saludrete[]' value='$rsalud' size='8' readonly><input type='hidden' name='saludemprete[]' value='$rsaludemp' size='8' readonly><input type='hidden' name='totsaludrete[]' value='$valsaludtot' size='8' readonly></td><td ><input type='text' name='pensionrete[]' value='$rpension' size='8' readonly><input type='hidden' name='pensionemprete[]' value='$rpensionemp' size='8' readonly><input type='hidden' name='totpensionrete[]' value='$valpensiontot' size='8' readonly> </td><td ><input type='text' name='fondosols[]' value='$fondosol' size='8' readonly>  </td><td >$row2[2] </td><td ><input type='text' name='otrasretenciones[]' value='$otrasrete' size='8' readonly> </td><td ><input type='text' name='totalrete[]' value='$totalretenciones' size='8' readonly> </td><td ><input type='text' name='netopagof[]' value='".number_format($totalneto,0)."' size='12' readonly><input type='hidden' name='netopago[]' value='$totalneto' > </td></tr>";
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
	echo "<tr class='saludo3'><td colspan='6'></td><td><input type='hidden' name='totaldevini' value='$_POST[totaldevini]'>".number_format($_POST[totaldevini],2)."</td><td><input type='hidden' name='totalauxalim' value='$_POST[totalauxalim]'>".number_format($_POST[totalauxalim],2)."</td><td><input type='hidden' name='totalauxtra' value='$_POST[totalauxtra]'>".number_format($_POST[totalauxtra],2)."</td><td><input type='hidden' name='totalhorex' value='$_POST[totalhorex]'>".number_format($_POST[totalhorex],2)."</td><td><input type='hidden' name='totaldevtot' value='$_POST[totaldevtot]'>".number_format($_POST[totaldevtot],2)."</td><td><input type='hidden' name='totalsalud' value='$_POST[totalsalud]'>".number_format($_POST[totalsalud],2)."</td><td><input type='hidden' name='totalpension' value='$_POST[totalpension]'>".number_format($_POST[totalpension],2)."</td><td><input type='hidden' name='totalfondosolida' value='$_POST[totalfondosolida]'>".number_format($_POST[totalfondosolida],2)."</td><td></td><td><input type='hidden' name='totalotrasreducciones' value='$_POST[totalotrasreducciones]'><input type='hidden' name='totalotrasreducciones' value='$_POST[totalotrasreducciones]'>".number_format($_POST[totalotrasreducciones],2)."</td><td><input type='hidden' name='totaldeductot' value='$_POST[totaldeductot]'>".number_format($_POST[totaldeductot],2)."</td><td><input type='hidden' name='totalnetopago' value='$_POST[totalnetopago]'>".number_format($_POST[totalnetopago],2)."</td></tr>";	
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
$sqlr="select DISTINCT id_nom, id_parafiscal, porcentaje, SUM(valor), estado from humnomina_parafiscales where id_nom=$_POST[idliq] and estado='S' GROUP BY id_nom, id_parafiscal";
	 $resp2 = mysql_query($sqlr,$linkbd);
	 $co=0;
	 while($row2 =mysql_fetch_row($resp2))
	  {
  	 if($co==0)
	  {
		echo "<tr>";  
	  }	  
	 $caja=$row2[1];
	 $ncaja=buscaparafiscalnom($row2[1]);
	 $pcaja=round($row2[2],2);
	 $vcaja=$row2[3];
// 	 $vcaja=round(($pcaja/100)*($totalparafiscales),-2);	
   //$vcaja=array_sum($pf[$row2[0]]);
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
//foreach($pfcp as $k => $valrubros)
$sqlr="select *from  humnom_presupuestal where id_nom='$_POST[idliq]'";
$resp=mysql_query($sqlr,$linkbd);
while($rp=mysql_fetch_row($resp))
 {
  $k=$rp[1];	
   $ncta=existecuentain($k); 
  $valrubros=$rp[2];	   
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
	 $sqlr="insert into humnomina_aprobado (id_nom,fecha,id_rp,persoaprobo,estado) values ($_POST[idliq],'$fechaf',$_POST[rp], '$_SESSION[usuario]', 'S')";
	 if (!mysql_query($sqlr,$linkbd))
	 {
	 echo "<table class='inicio'><tr><td class='saludo1'><center>No se Pudo Aprobrar la Nomina <img src='imagenes\alert.png'></center></td></tr></table>"; 	  
	 }
	  else
	  {
	 echo "<table class='inicio'> <tr><td class='saludo1'> <center>Registros Exitosos:$cex   -   Registros Erroneos: $cerr<img src='imagenes\confirm.png'></center></td></tr></table> "; 	
	  }
 }
?>
</form>
</td></tr>     
</table>
</body>
</html>