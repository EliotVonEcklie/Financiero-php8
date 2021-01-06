<?php //V 1000 12/12/16 ?> 
<!--V 1.0 24/02/2015-->
<?php
	require"comun.inc";
	require"funciones.inc";
	sesion();
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
		<title>:: Spid - Gestion Humana</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <link href="css/tabs.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
<script>
//************* ver reporte ************
function verep(idfac){document.form1.oculto.value=idfac;document.form1.submit();}
//************* genera reporte ************
function genrep(idfac){document.form2.oculto.value=idfac;document.form2.submit();}
//************* genera reporte ************
function guardar()
{
	if (document.form2.tperiodo.value!='' && document.form2.periodo.value!='')
  		{if (confirm("Esta Seguro de Guardar")){document.form2.oculto.value=2;document.form2.submit();}}
  	else{alert('Faltan datos para completar el registro');}
}
function validar(formulario)
{
	//document.form2.cperiodo.value='1';	
	document.form2.cperiodo.value='2';
	document.form2.action="hum-liquidarcesantias.php";
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
	document.form2.action="pdfpeticionrp.php";
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
   		<tr>
    		<script>barra_imagenes("hum");</script>
            <?php cuadro_titulos();?>
    	</tr>
    	<tr>
        	<?php menu_desplegable("hum");?>
    	</tr>
<tr>
  <td colspan="3" class="cinta"><a href="hum-liquidarcesantias.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a><a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar"/></a><a href="hum-buscacesantias.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a><a href="#" onClick="mypop=window.open('hum-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a><a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png" title="Imprimir"></a><a href="#" onClick='excell()' class="mgbt"><img src="imagenes/excel.png"  title="Excel"></a></td></tr>	
  		</table>	
 <form name="form2" method="post" action="">
<?php

if($_POST[anticipo]=='S')
 {
	 $chkant=' checked ';
 }

$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
$_POST[vigencia]=$vigusu;
$linkbd=conectar_bd();
	if($_POST[oculto]=="")
	{
//	$linkbd=conectar_bd();
//*****parametros de nomina
	$_POST[tabgroup1]=1;
	$sqlr="select max(id_cesantias) from humcesantias";
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
		 
		 //**** carga parametros de nomina
		 $sqlr="select *from humparametrosliquida";	
		 		$resp = mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($resp)) 
				{
				$_POST[aprueba]=$row[1];
				$_POST[naprueba]=buscatercero($row[1]);
				$_POST[tsueldo]=$row[2];
				$_POST[tsubalim]=$row[8];
				$_POST[tauxtrans]=$row[9];
				$_POST[trecnoct]=$row[11];
				$_POST[thorextdiu]=$row[12];
				$_POST[thorextnoct]=$row[13];
				$_POST[thororddom]=$row[14];
				$_POST[thorextdiudom]=$row[15];
				$_POST[thorextnoctdom]=$row[16];
				$_POST[tcajacomp]=$row[17];
				$_POST[ticbf]=$row[18];
				$_POST[tsena]=$row[19];
				$_POST[titi]=$row[20];
				$_POST[tesap]=$row[21];
				$_POST[tarp]=$row[22];
				$_POST[tsaludemr]=$row[23];
				$_POST[tsaludemp]=$row[24];
				$_POST[tpensionemr]=$row[25];
				$_POST[tpensionemp]=$row[26];
				$_POST[tcesantias]=$row[27];
				}		 				 		
		//*** fin parametros de nomina *******					
	}
		 $pf[]=array();
		 $pfcp=array();	
switch($_POST[tabgroup1])
{
case 1:
$check1='checked';
break;
case 2:
$check2='checked';
break;
case 3:
$check3='checked';
break;
case 4:
$check4='checked';
break;
}		 
?>
<table  class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="8">:: Liquidar Cesantias</td><td class="cerrar" ><a href="hum-principal.php">Cerrar</a></td>
      </tr>
      <tr><td class="saludo1">No Liquidacion</td><td>
      <input type="hidden" id="aprueba" name="aprueba" value="<?php echo $_POST[aprueba] ?>">
      <input type="hidden" id="naprueba" name="naprueba" value="<?php echo $_POST[naprueba] ?>">
      <input type="hidden" id="tsueldo" name="tsueldo" value="<?php echo $_POST[tsueldo] ?>">
      <input type="hidden" id="tsubalim" name="tsubalim" value="<?php echo $_POST[tsubalim] ?>">
      <input type="hidden" id="tauxtrans" name="tauxtrans" value="<?php echo $_POST[tauxtrans] ?>">
      <input type="hidden" id="trecnoct" name="trecnoct" value="<?php echo $_POST[trecnoct] ?>">
      <input type="hidden" id="thorextdiu" name="thorextdiu" value="<?php echo $_POST[thorextdiu] ?>">
      <input type="hidden" id="thorextnoct" name="thorextnoct" value="<?php echo $_POST[thorextnoct] ?>">
      <input type="hidden" id="thororddom" name="thororddom" value="<?php echo $_POST[thororddom] ?>">
      <input type="hidden" id="thorextdiudom" name="thorextdiudom" value="<?php echo $_POST[thorextdiudom] ?>">
      <input type="hidden" id="thorextnoctdom" name="thorextnoctdom" value="<?php echo $_POST[thorextnoctdom] ?>">
      <input type="hidden" id="tcajacomp" name="tcajacomp" value="<?php echo $_POST[tcajacomp] ?>">
      <input type="hidden" id="ticbf" name="ticbf" value="<?php echo $_POST[ticbf] ?>">
      <input type="hidden" id="tsena" name="tsena" value="<?php echo $_POST[tsena] ?>">
      <input type="hidden" id="titi" name="titi" value="<?php echo $_POST[titi] ?>">
      <input type="hidden" id="tesap" name="tesap" value="<?php echo $_POST[tesap] ?>">
      <input type="hidden" id="tarp" name="tarp" value="<?php echo $_POST[tarp] ?>">
      <input type="hidden" id="tsaludemr" name="tsaludemr" value="<?php echo $_POST[tsaludemr] ?>">
      <input type="hidden" id="tsaludemp" name="tsaludemp" value="<?php echo $_POST[tsaludemp] ?>">
      <input type="hidden" id="tpensionemr" name="tpensionemr" value="<?php echo $_POST[tpensionemr] ?>">
      <input type="hidden" id="tpensionemp" name="tpensionemp" value="<?php echo $_POST[tpensionemp] ?>">
      <input type="hidden" id="tcesantias" name="tcesantias" value="<?php echo $_POST[tcesantias] ?>">
      
      <input name="idcomp" type="text" size="5" value="<?php echo $_POST[idcomp]?>" readonly></td><td class="saludo1">Fecha</td><td><input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10" size="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY">   <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>  </td><td class="saludo1">Vigencia</td> <td><input name="vigencia" type="text" size="5" value="<?php echo $_POST[vigencia]?>" readonly></td><td class="saludo1">Liq. Nomina</td><td><select name="idliq" id="idliq" onChange="validar()" >
				  <option value="-1">Sel ...</option>
				 <?php
				 $sqlr="Select *  from humnomina where humnomina.estado<>'N' ";
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
		  </select></td>
	    </tr>
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
					 $_POST[iti]=$row[12];	
					 $_POST[indiceinca]=$row[15];						 	
					}		
        ?>
		<td>
		<input id="cajacomp" name="cajacomp" type="hidden" value="<?php echo $_POST[cajacomp]?>" >
		<input id="icbf" name="icbf" type="hidden" value="<?php echo $_POST[icbf]?>" >
	    <input id="sena" name="sena" type="hidden" value="<?php echo $_POST[sena]?>" >
    	<input id="esap" name="esap" type="hidden" value="<?php echo $_POST[esap]?>" >
		<input id="iti" name="iti" type="hidden" value="<?php echo $_POST[iti]?>" >           
		<input id="indiceinca" name="indiceinca" type="hidden" value="<?php echo $_POST[indiceinca]?>" >                   
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
	$sqlr="select *from centrocosto where estado='S' ORDER BY ID_CC	";
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
<div class="tabscontra">
 <div class="tab">
       <input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
	   <label for="tab-1">Liquidacion Empleados</label>
	   <div class="content">
      <?php
$linkbd=conectar_bd();
$crit1=" ";
$crit2=" ";
//sacar el consecutivo 
echo "<table class='inicio' align='center' width='99%'><tr><td colspan='12' class='titulos'>.: Resultados Busqueda: $ntr Empleados</td></tr><tr><td  class='titulos2'>Id</td><td class='titulos2' width='1%'>Vac</td><td class='titulos2' >EMPLEADO</td><td class='titulos2' width='2%'>Doc Id</td><td class='titulos2' >SAL BAS</td><td class='titulos2' >DIAS LIQ</td><td class='titulos2' >DEVENGADO</td><td class='titulos2' >AUX ALIM</td><td class='titulos2' >AUX TRAN</td><td class='titulos2' >OTROS INGRESOS</td><td class='titulos2' >TOT DEVENGADO</td><td class='titulos2' >VALOR CESANTIAS</td></tr>";	
//echo "nr:".$_POST[cperiodo];
$iter='saludo3';
$iter2='saludo3';
$sqlr="select *from humnomina_det where id_nom=$_POST[idliq] ";
$resp = mysql_query($sqlr,$linkbd);
$con=0;
while ($row =mysql_fetch_row($resp)) 
	{
	 if($ch=='1')
			 {
  	 $totalparafiscales+=$bparafiscales2;	
	 		 }
			 else
			 {
  	 $totalparafiscales+=$bparafiscales;
			 }
	$_POST[ccemp][]=$row[1];
	$nter=buscatercero($row[1]);	
	$salario=$row[2]; 
	$auxalimtot=$row[6]; 
	$auxtratot=$row[7]; 	
	$totdev=$row[9]+$_POST[otrosingre][$con];
	$cesantias=0;
	$deven=$row[4];
	$sqlr="select distinct *from  humparafiscales  where  humparafiscales.codigo='$_POST[tcesantias]' ";
		$resph=mysql_query($sqlr,$linkbd);
		//echo "<br>$sqlr";
		while ($rowh =mysql_fetch_row($resph)) 
				{
				   $cesantias=round($totdev*($rowh[3]/100),0);					 
				}
	 echo "<tr  id='fila$row[12]' class=$iter><td >".($con+1)."</td><td ><input type='checkbox' name='empleados[]' value='".$row[1]."'  onClick='marcar(".$_POST[empleados][$con].",$con);' $chk></td><td ><input type='hidden' name='nomemp[]' value='".$nter."'>".$nter."</td><td ><input type='hidden' name='ccemp[]' value='".$row[1]."'>".$row[1]."</td><td ><input type='hidden' name='centrocosto[]' value='".$row[31]."' size='8' readonly><input type='text' name='salbas[]' value='$salario' size='8' readonly> </td><td ><input type='text' size='2' name='diast[]' value='".$row[3]."'  onKeyPress='javascript:return solonumeros(event)' onKeyUp='return tabular(event,this)' onBlur='validar()' > </td><td ><input type='text' size='8' name='devengado[]' value='".($deven)."' readonly> </td><td ><input type='text' size='5' name='ealim[]' value='".($auxalimtot)."' readonly>  </td><td ><input type='text' size='5' name='etrans[]' value='".($auxtratot)."' readonly>  </td><td ><input type='text' name='otrosingre[]' value='".$_POST[otrosingre][$con]."' size='8' > </td><td ><input type='text' name='totaldev[]' value='$totdev' size='8' readonly><input type='hidden' name='ibc[]' value='$bparafiscales2' size='8' readonly></td><td ><input type='text' name='netopagof[]' value='".number_format($cesantias,0)."' size='12' readonly><input type='hidden' name='netopago[]' value='$cesantias' ></td></tr>";
	 $aux=$iter;
	 $iter=$iter2;
	 $iter2=$aux;
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
echo "<tr class='saludo3'><td><input type='hidden' name='totaldevini' value='$_POST[totaldevini]'>".number_format($_POST[totaldevini],2)."</td><td><input type='hidden' name='totalauxalim' value='$_POST[totalauxalim]'>".number_format($_POST[totalauxalim],2)."</td><td><input type='hidden' name='totalauxtra' value='$_POST[totalauxtra]'>".number_format($_POST[totalauxtra],2)."</td><td><input type='hidden' name='totalhorex' value='$_POST[totalhorex]'>".number_format($_POST[totalhorex],2)."</td><td><input type='hidden' name='totaldevtot' value='$_POST[totaldevtot]'>".number_format($_POST[totaldevtot],2)."</td><td><input type='hidden' name='totalsalud' value='$_POST[totalsalud]'>".number_format($_POST[totalsalud],2)."</td><td><input type='hidden' name='totalpension' value='$_POST[totalpension]'>".number_format($_POST[totalpension],2)."</td><td><input type='hidden' name='totalfondosolida' value='$_POST[totalfondosolida]'>".number_format($_POST[totalfondosolida],2)."</td><td></td><td><input type='hidden' name='totalotrasreducciones' value='$_POST[totalotrasreducciones]'><input type='hidden' name='totalotrasreducciones' value='$_POST[totalotrasreducciones]'>".number_format($_POST[totalotrasreducciones],2)."</td><td><input type='hidden' name='totaldeductot' value='$_POST[totaldeductot]'>".number_format($_POST[totaldeductot],2)."</td><td><input type='hidden' name='totalnetopago' value='$_POST[totalnetopago]'>".number_format($_POST[totalnetopago],2)."</td></tr>";	
 echo"</table>";
?></div>
</div>
    <div class="tab">
       <input type="radio" id="tab-3" name="tabgroup1" value="3" <?php echo $check3;?> >
	   <label for="tab-3">Presupuesto</label>
	   <div class="content">

<table class="inicio">
<tr>
<td class="titulos">Cuenta Presupuestal</td><td class="titulos">Nombre Cuenta Presupuestal</td><td class="titulos">Valor</td></tr>
<?php
$totalrubro=0;
foreach($pfcp as $k => $valrubros)
 {
  $ncta=existecuentain($k);
  if($valrubros>0)
  {
  echo "<tr class='saludo3'><td ><input type='hidden' name='rubrosp[]' value='$k'>$k</td><td><input type='hidden' name='nrubrosp[]' value='".strtoupper($ncta)."'>".strtoupper($ncta)."</td><td align='right'><input type='hidden' name='vrubrosp[]' value='$valrubros'>".number_format($valrubros,2)."</td></tr>";
  $totalrubro+=$valrubros;
  }
 }
?>
<tr class='saludo3'><td></td><td>Total:</td><td align='right'><?php echo number_format($totalrubro,2) ?></td></tr> 
</table>
</div>
</div>
</div>
<?php
if($_POST[oculto]==2)
 {
$linkbd=conectar_bd(); 
 $sqlr="select count(*) from humcesantias where id_nomina=$_POST[periodo] and estado<>'N'";
 $respval=mysql_query($sqlr,$linkbd);
 $rval =mysql_fetch_row($respval);
 if($rval[0]<=0)
 {  
  ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
  $fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
  $sqlr="insert into humcesantias (id_nom,`fecha`, `periodo`, `mes`, `diasp`, `mesnum`, `cc`, `vigencia`, `estado`) values ($_POST[idliq],'$fechaf','$_POST[tperiodo]','$_POST[periodo]','$_POST[diasperiodo]','$_POST[mesnum]','$_POST[cc]','".$vigusu."','S')";
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
	 $tam=count($_POST[totalnetopago]);
	 //echo "tam:".$tam;
	 $errores=0;
	 $exitosos=0;
	 for($x=0;$x<$tam;$x++)
	 {
	  $sqlr="insert into humcesantias_det (id_cesantias, devengado, auxalim, auxtrans, otrosingresos, totaldev, valorcesantias) values ('$id','".$_POST[devengado][$x]."','".$_POST[ealim][$x]."','".$_POST[etrans][$x]."','".$_POST[otrosingre][$x]."','".$_POST[totaldev][$x]."','".$_POST[netopago][$x]."')";
	  if (!mysql_query($sqlr,$linkbd)) 
	  {
		$errores+=1;  
		echo "<table class='inicio'><tr><td class='saludo1'><center>No se Pudo Agregar las cesantias $sqlr <img src='imagenes\alert.png'></center></td></tr></table>"; 	 
	  }
	  else
	  {
		$exitosos+=1;  		
	  }
	 }
	 echo "<table class='inicio'> <tr><td class='saludo1'> <center>Registros Exitosos:$exitosos   -   Registros Erroneos: $errores<img src='imagenes\confirm.png'></center></td></tr></table> "; 
	 /*$sqlr="insert into humnomina_aprobado (id_nom,fecha,id_rp,persoaprobo,estado) values ($id,'$fechaf',$_POST[rp], '$_SESSION[usuario]', 'S')";
	 if (!mysql_query($sqlr,$linkbd))
	 {
	 echo "<table class='inicio'><tr><td class='saludo1'><center>No se Pudo Aprobrar la Nomina <img src='imagenes\alert.png'></center></td></tr></table>"; 	  
	 }
	  else
	  {
	 echo "<table class='inicio'> <tr><td class='saludo1'> <center>Registros Exitosos:$cex   -   Registros Erroneos: $cerr<img src='imagenes\confirm.png'></center></td></tr></table> "; 	
	  }*/
	}
  }	
  else
  {
   echo "<table class='inicio'><tr><td class='saludo1'><center>LIQUIDACION DE CESANTIAS EXISTENTE PARA ESTOS PARAMETROS<img src='imagenes\alert.png'></center></td></tr></table>";   
   ?>
   <script>alert("No se puede Generar: LIQUIDACION DE CESANTIAS EXISTENTE")</script>
   <?php
  }
}
?>
</form>
</td></tr>     
</table>
</body>
</html>