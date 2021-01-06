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
document.form2.action="hum-vacaciones.php";
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
function checktodos()
{
 vvigencias=document.getElementsByName('empleados[]');
 //vtabla=document.getElementById('fila'+indice);
 for (var i=0;i < vvigencias.length;i++) 
 { 
	if (document.getElementById("todos").checked) 
	{
	 vvigencias.item(i).checked = true;
 	 document.getElementById("todos").value=1;	
	 vvigencias.item(i).style.backgroundColor='#3399bb'; 
	}
	else
	{
	vvigencias.item(i).checked = false;
    document.getElementById("todos").value=0;
	vvigencias.item(i).style.backgroundColor='#ffffff';
	}
 }	
}

function aplicatodos()
{
 
 vvigencias=document.getElementsByName('empleados[]');
 fechas1=document.getElementsByName('fechainiv[]');
 fechas2=document.getElementsByName('fechafinv[]');
 if(document.getElementById("vactodos").checked)
 {
 //vtabla=document.getElementById('fila'+indice);
 for (var i=0;i < vvigencias.length;i++) 
 { 
	if (vvigencias.item(i).checked) 
	{
 	fechas1.item(i).value=document.getElementById("fechaig").value;	
 	fechas2.item(i).value=document.getElementById("fechafg").value;	
	}
 }	
 //alert('ede');
 }
}

function excell()
{
document.form2.action="hum-liquidarnominaexcel.php";
document.form2.target="_BLANK";
document.form2.submit(); 
document.form2.action="";
document.form2.target="";
}

function buscater(e)
 {
if (document.form2.tercero.value!="")
{
 document.form2.bt.value='1';
 document.form2.submit();
 }
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
  <td colspan="3" class="cinta"><a href="hum-vacaciones.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a><a href="#"  onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a><a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a><a href="#" onClick="mypop=window.open('hum-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="nueva ventana"></a><a href="#" onClick='excell()' class="mgbt"><img src="imagenes/excel.png"  title="excel"></a></td></tr>	
  		</table>
<tr><td colspan="3" class="tablaprin"> 
 <form name="form2" method="post" action="">
<?php
$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
$linkbd=conectar_bd();
	if(!$_POST[oculto])
	{
	$linkbd=conectar_bd();
	$sqlr="select max(id_vac) from humvacaciones_cab";
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
	if($_POST[bt]=='1')
			 {
			  $nresul=buscatercero($_POST[tercero]);
			  if($nresul!='')
			   {
			  $_POST[ntercero]=$nresul;
  	
			  }
			 else
			 {
			  $_POST[ntercero]="";
			  }
			 }
	
		 $pf[]=array();
		 $pfcp=array();	
		 if($_POST[vactodos]==1)
 			$checkt=" checked";
 			else
 			$checkt=" ";
?>
<table  class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="8">:: Vacaciones</td><td class="cerrar" ><a href="hum-principal.php">Cerrar</a></td>
      </tr>
      <tr><td class="saludo1">No Liq Vac</td><td><input name="idcomp" type="text" size="5" value="<?php echo $_POST[idcomp]?>" readonly></td><td class="saludo1">Fecha</td><td><input name="fecha" type="date" value="<?php echo $_POST[fecha]?>" > </td></tr><tr>
	 
     <td class="saludo1">Vacaciones Globales:</td><td>Aplicar <input id="vactodos" type="checkbox" name="vactodos" value="1" onClick="aplicatodos()" <?php echo $checkt;?>></td><td class="saludo1"> Fecha Inicial:</td>
          <td ><input id="fechaig" type="date" name="fechaig" value="<?php echo $_POST[fechaig]?>"></td>
          <td class="saludo1">Fecha Final:</td>
          <td ><input id="fechafg" type="date" name="fechafg" value="<?php echo $_POST[fechafg]?>"></td>
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
		  </select><input id="tperiodonom" name="tperiodonom" type="hidden" value="<?php echo $_POST[tperiodonom]?>" ><input name="cperiodo" type="hidden" value="1"></td>
        <td class="saludo1">Dias:
        </td>
        <td><input name="diasperiodo" type="text" id="diasperiodo" value="<?php echo $_POST[diasperiodo]?>" size="5" readonly>
          <input name="oculto" type="hidden" value="1"></td>
          
          <td class="saludo1">Mes:</td>
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
    <div class="subpantallac6">	
      <?php

$linkbd=conectar_bd();
$crit1=" ";
$crit2=" ";
//sacar el consecutivo 

if($_POST[todos]==1)
 $chk=" checked";
 else
 $chk=" ";

echo "<table class='inicio' align='center' width='99%'><tr><td colspan='19' class='titulos'>.: Resultados Busqueda: $ntr Empleados</td></tr><tr><td class='titulos2' width='1%'><input type='checkbox' id='todos' name='todos' value='1'  onClick='checktodos()' $chk></td><td class='titulos2' >EMPLEADO</td><td class='titulos2' width='2%'>Doc</td><td class='titulos2' width='2%'>Fecha Ini</td><td class='titulos2' width='2%'>Fecha Fin</td><td class='titulos2' >SALARIO BASICO</td><td class='titulos2' >OTROS SALARIOS</td><td class='titulos2' >VALOR VACACIONES</td></tr>";	
//echo "nr:".$_POST[cperiodo];
$iter='saludo3';
$iter2='saludo3';
if ($_POST[cperiodo])
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
//$sqlr="select *from terceros inner join terceros_nomina on terceros.cedulanit=terceros_nomina.cedulanit where terceros.estado='S' and terceros.empleado='1' and terceros.cedulanit='$_POST[tercero]' order by terceros.apellido1,terceros.apellido2,terceros.nombre1,terceros.nombre2";
$sqlr="select *from terceros inner join terceros_nomina on terceros.cedulanit=terceros_nomina.cedulanit where terceros.estado='S' and terceros.empleado='1' order by terceros.apellido1,terceros.apellido2,terceros.nombre1,terceros.nombre2";

	// echo "<div><div>sqlr:".$sqlr."</div></div>";
	$resp = mysql_query($sqlr,$linkbd);
	$ntr = mysql_num_rows($resp);
	$con=0;
	$totalparafiscales=0;
	$co="zebra1s";
	$co2="zebra2s";
	while ($row =mysql_fetch_row($resp)) 
	 {
$sqlr="select terceros_nomina.cargo, humnivelsalarial.nombre, humnivelsalarial.valor, terceros_nomina.fondopensionestipo from terceros_nomina inner join humnivelsalarial on terceros_nomina.cargo=humnivelsalarial.id_nivel where terceros_nomina.cedulanit=$row[12] ";
	 $resp2 = mysql_query($sqlr,$linkbd);
	 $row2 =mysql_fetch_row($resp2);
	 $valordia=$row2[2]/30;
	 $salario=$row2[2]; 
	 $totalneto= $salario+$_POST[otrosal][$con];
	$ch=esta_en_array($_POST[empleados],$row[12]);
			  $style="";		
			if($ch=='1')
			 {
			 $chke=" checked";
			 $style="style='background-color:#3399bb'";
			 }
			 else
			 {
			 $chke=" ";
			 $style="";
			 }
	 echo "<tr id='fila$row[12]' class='$co' ".$style."  ><td ><input type='checkbox' name='empleados[]' value='$row[12]'  onClick='marcar($row[12],$con);' $chke></td><td ><input type='hidden' name='nomemp[]' value='".strtoupper($row[3])." ".strtoupper($row[4])." ".strtoupper($row[1])." ".strtoupper($row[2])."' >".strtoupper($row[3])." ".strtoupper($row[4])." ".strtoupper($row[1])." ".strtoupper($row[2])."</td><td ><input type='hidden' name='ccemp[]' value='$row[12]'>$row[12] </td><td ><input type='date' name='fechainiv[]' value='".$_POST[fechainiv][$con]."'></td><td ><input type='date' name='fechafinv[]' value='".$_POST[fechafinv][$con]."'></td><td ><input type='hidden' name='centrocosto[]' value='".$row[31]."' size='8' readonly><input type='text' name='salbas[]' value='$salario' size='8' readonly> </td><td ><input type='text' name='otrosal[]' value='".($_POST[otrosal][$con]+0)."' size='8' > </td><td ><input type='text' name='netopagof[]' value='".number_format($totalneto,0)."' size='12' readonly ><input type='hidden' name='netopago[]' value='$totalneto'> </td></tr>";
	 $aux=$co2;
	 $co2=$co;
	 $co=$aux;
	 	$auxalimtot=$auxalim*$_POST[diast][$con];
		$auxtratot=$auxtra*$_POST[diast][$con];
		$_POST[totsaludtot]+=$valsaludtot;
		$_POST[totpenstot]+=$valpensiontot;
		$_POST[totaldevini]+=$deven;
		$_POST[totalauxalim]+=$auxalimtot;
		$_POST[totalauxtra]+=$auxtratot;
		$_POST[totaldevtot]+=$liqvac;	
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
 	
 echo"</table>";
 
 if($_POST[bt]=='1')
			 {
			  $nresul=buscatercero($_POST[tercero]);
			  if($nresul!='')
			   {
			  $_POST[ntercero]=$nresul;
  				?>
			  <script>
			 // document.getElementById('cc').focus();document.getElementById('cc').select();</script>
			  <?php
			  }
			 else
			 {
			  $_POST[ntercero]="";
			  ?>
			  <script>
				alert("Tercero Incorrecto o no Existe");								
  		  		document.form2.tercero.value="";	
  		  		document.form2.tercero.focus();	
			  		//document.form2.tercero.focus();			  	
			  </script>
			  <?php
			  }
			 }
 
?>
</div>
<?php
//echo "Oc:".$_POST[oculto];
if($_POST[oculto]==2)
 {
  $linkbd=conectar_bd();
  $sqlr="insert into humvacaciones_cab (fecha, mes,vigencia,fechaini,fechafin,periodo, estado) values ('$_POST[fecha]','$_POST[periodo]','".$vigusu."','".$_POST[fechaig]."','".$_POST[fechafg]."','$_POST[tperiodo]','S')";
 // echo $sqlr;
  if (mysql_query($sqlr,$linkbd))
	{
	 $id=mysql_insert_id();	
	// echo "N:".count($_POST[salbas]);
	 for ($x=0;$x<count($_POST[salbas]);$x++) 
	 {
	//*****  datos nomina del empleado *****	 
	  if(1==esta_en_array($_POST[empleados],$_POST[ccemp][$x]))
	  {
//*************************************
		$dias=0;
		$dias=dias_transcurridos($_POST[fechainiv][$x],$_POST[fechafinv][$x]);		 
	 $sqlr="insert into humvacaciones_det(id_vac,cedulanit,salbas,diaslab,otrosalarios,netopagar,estado,mes,vigencia,fechainicial,fechafinal,fecha) values ($id,'".$_POST[ccemp][$x]."',".$_POST[salbas][$x].",".$dias.",".$_POST[otrosal][$x].",".$_POST[netopago][$x].",'S','$_POST[periodo]',$vigusu,'".$_POST[fechainiv][$x]."','".$_POST[fechafinv][$x]."','".$_POST[fecha]."')";
	 //echo "<br>".$sqlr;
	  if (!mysql_query($sqlr,$linkbd))
		{
		 $cerr+=1;	
		}
		else
		{
		$cex+=1;	
		$ctacont='';
		$ctapres='';
		}	
	  }	 	
	}	
	echo "<table class='inicio'><tr><td class='saludo1'><center>Registros Exitosos:$cex   -   Registros Erroneos: $cerr<img src='imagenes\confirm.png'></center></td></tr></table>";
   }
   else
   {
	 echo "<table class='inicio'><tr><td class='saludo1'><center>No se ha podido Guardar <img src='imagenes\alert.png'>".$mysql_error($linkbd)."</center></td></tr></table>";
   }
 }
?>
</form>
</td></tr>     
</table>
</body>
</html>