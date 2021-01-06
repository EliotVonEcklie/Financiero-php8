<?php //V 1001 21/12/16 ?> 
<?php
require"comun.inc";
require"funciones.inc";
session_start();
cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
//**niveles menu: Administracion (0) - Consultas (1) - Herramientas (2) - Reportes (3)
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
<meta http-equiv="Content-Type" content="text/html" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<title>:: SPID - Tesoreria</title>
<script>
function buscacta(e)
 {
if (document.form2.cuenta.value!="")
{
 document.form2.bc.value='1';
 document.form2.submit();
 }
 }
</script>
<script language="JavaScript1.2">
function validar()
{
document.form2.submit();
}
</script>
<script>
function agregardetalle()
{
if(document.form2.banco.value!="" &&  document.form2.cb.value!=""  )
{ 
				document.form2.agregadet.value=1;
	//			document.form2.chacuerdo.value=2;
				document.form2.submit();
 }
 else {
 alert("Falta informacion para poder Agregar");
 }
}
</script>
<script>

function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden") {document.getElementById('ventanam').src="";}
				else
				{
					switch(_tip)
					{
						case "1":
							document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
						case "2":
							document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
						case "3":
							document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
						case "4":
							document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;	
					}
				}
			}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.form2.oculto.value='2';document.form2.submit();break;
				}
			}
			function funcionmensaje(){
				if(document.form2.tipoex.value=="exoneracion"){
					document.location.href = "teso-exoneracionver.php?idpres="+document.form2.idpres.value;
				}
				if(document.form2.tipoex.value=="exento"){
					document.location.href = "teso-exentosver.php?idpres="+document.form2.idpres.value;
				}
				// if($_POST[tipoex]=='exoneracion'){
					// 
				// }
				// if($_POST[tipoex]=='exento'){
					// document.location.href = "teso-exentover.php?idpredial="+document.form2.codcat.value;
				// }
				
			}
</script>
<script>
//************* genera reporte ************
//***************************************
function guardar()
{

if (document.form2.tipop.value!='')
  {
	despliegamodalm('visible','4','Esta Seguro de Guardar','1');
  }
  else{
			despliegamodalm('visible','2','Faltan datos para completar el registro');
	  		document.form2.fecha.focus();
	  		document.form2.fecha.select();
  }
}
</script>
<script>
function buscater(e)
 {
if (document.form2.tercero.value!="")
{
 document.form2.bt.value='1';
 document.form2.submit();
 }
 }
</script>
<script>
function buscar()
 {
	// alert("dsdd");
 document.form2.buscav.value='1';
 document.form2.submit();
 }
</script>
<script>
function pdf()
{
document.form2.action="pdfpredialexoneracion.php";
document.form2.target="_BLANK";
document.form2.submit(); 
document.form2.action="";
document.form2.target="";
}
			function despliegamodal2(_valor)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else {document.getElementById('ventana2').src="catastral-ventana01.php";}
			}
</script>
<script src="css/programas.js"></script>
<script src="css/calendario.js"></script>
<script src="JQuery/jquery-2.1.4.min.js"></script>

<link href="css/css2.css" rel="stylesheet" type="text/css" />
<link href="css/css3.css" rel="stylesheet" type="text/css" />
<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
	<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
	<tr><?php menu_desplegable("teso");?></tr>
<tr>
  <td colspan="3" class="cinta">
	<a href="teso-exoneracionpredios.php" class="mgbt"><img src="imagenes/add.png" alt="Nuevo"  border="0" title="Nuevo"/></a> 
	<a href="#"  onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png"  alt="Guardar" title="Guardar"/></a> 
	<a href="#" onClick="location.href='teso-buscaexoneraciones.php'" class="mgbt"> <img src="imagenes/busca.png"  alt="Buscar" title="Buscar"/></a> 
	<a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana" title="Nueva Ventana"> </a>  
	<a href="#" <?php if($_POST[oculto]==2) { ?> onClick="pdf()" class="mgbt"<?php } ?>> <img src="imagenes/print.png"  alt="Buscar" title="Imprimir" /></a> 
	<a href="teso-gestionpredial.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a></td>
</tr>		  
</table>
<tr><td colspan="3" class="tablaprin" align="center"> 
<?php
$vigencia=date(Y);
$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
$vigencia=$vigusu;
 ?>	
   
<?php
if(!$_POST[oculto])
{
	 $linkbd=conectar_bd();	 	 	
	 $sqlr="select *from  tesoparametros where estado='S' ";
	  $res=mysql_query($sqlr,$linkbd);
	 while($row=mysql_fetch_row($res))
	  {
	  $_POST[agespre]=0;
	  $_POST[tesorero]=buscatercero($row[1]);
	  }
	  $_POST[agepar]=$vigusu-$_POST[agespre];
 		 $fec=date("d/m/Y");
		 $_POST[fecha]=$fec; 	
		 $_POST[valoradicion]=0;
		 $_POST[valorreduccion]=0;
		 $_POST[valortraslados]=0;		 		  			 
		 $_POST[valor]=0;
	
		 	 
}
if ($_POST[chacuerdo]=='2')
{
	$_POST[dcuentas]=array();
	$_POST[dncuetas]=array();
	$_POST[dingresos]=array();
	$_POST[dgastos]=array();
	$_POST[diferencia]=0;
	$_POST[cuentagas]=0;
	$_POST[cuentaing]=0;																			
}	
?>
<div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
<form  name="form2" method="post" action="teso-exoneracionpredios.php">
	


 <?php if($_POST[bt]=='1')
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
			 
			 ?>
 <?php
if($_POST[buscav]=='1')
 {
	 $_POST[dcuentas]=array();
	 $_POST[dncuentas]=array();
	 $_POST[dtcuentas]=array();		 
	 $_POST[dvalores]=array();

	 $linkbd=conectar_bd();
	 $sqlr="select *from tesopredios where cedulacatastral=".$_POST[codcat]." ";
	 //echo "s:$sqlr";
	 $res=mysql_query($sqlr,$linkbd);
	 while($row=mysql_fetch_row($res))
	  {
		  //$_POST[vigencia]=$row[0];
		  $_POST[catastral]=$row[0];
		  $_POST[propietario]=$row[6];
		  $_POST[documento]=$row[5];
		  $_POST[direccion]=$row[7];
		  $_POST[ha]=$row[8];
		  $_POST[mt2]=$row[9];
		  $_POST[areac]=$row[10];
		  $_POST[avaluo]=number_format($row[11],2);
		  $_POST[tipop]=$row[14];
		  if($_POST[tipop]=='urbano')
			$_POST[estrato]=$row[15];
			else
			$_POST[rangos]=$row[15];
				// $_POST[dcuentas][]=$_POST[estrato];		
		 $_POST[dtcuentas][]=$row[1];		 
		 $_POST[dvalores][]=$row[5];
		 $_POST[buscav]="";
	  }
	  	 // echo "dc:".$_POST[dcuentas];
  }
?>
 
    <table class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="7">.: Exentos y Exoneraci&oacute;n de Predios</td><td width="72" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
      </tr>     
	  <tr> 
		
				
		
		<td class="saludo1" style="width:10%;"> Tipo:</td> 
		<td style="width:10%;">
			<select name="tipoex" id="tipoex" onChange="validar();" onKeyUp="return tabular(event,this)" style="width:40%">
					<option value="" > Seleccione ..</option>
					<option value="exoneracion" <?php if($_POST[tipoex]=='exoneracion') echo "SELECTED"?>> Exoneraci&oacute;n</option>
					<option value="exento" <?php if($_POST[tipoex]=='exento') echo "SELECTED"?>> Exento </option>
			</select>
			<?php
			if($_POST[tipoex]=='exoneracion'){
				$linkbd=conectar_bd();
				$sqlr="select count(id) from tesoexoneracion";
				$res=mysql_query($sqlr,$linkbd);
				$consec=0;
				while($r=mysql_fetch_row($res))
				 {
					
				  $consec=$r[0];
				}
				$consec=$consec+1;
				$_POST[idpres]=$consec;	
				
		
			}	
			if($_POST[tipoex]=='exento'){
				$linkbd=conectar_bd();
				$sqlr="select count(id) from tesoexentos";
			
				$res=mysql_query($sqlr,$linkbd);
				$consec=0;
				while($r=mysql_fetch_row($res))
				 {
				  $consec=$r[0];	  
				}
				$consec=$consec+1;
				$_POST[idpres]=$consec;
				//echo $_POST[idpres].h;				
			}
	?>
		</td>
		<td class="saludo1">No Exonerado:</td>
			<td  style="width:10%;">
				<input name="idpres" type="text" id="idpres"  onClick="document.getElementById('idpres').focus();document.getElementById('idpres').select();" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[idpres]?>"  style="width:80%;" readonly >
			</td>
		<td class="saludo1">Fecha: </td>
        <td >
			<input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" style="width:20%"> <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/calendario04.png" align="absmiddle" style="width:20px" border="0"></a>     </td>
        </tr>
        <tr>
			<td  class="saludo1" style="width:10%;">C&oacute;digo Catastral:</td>
			<td style="width:25%;">
				<input name="tesorero" id="tesorero" type="hidden" value="<?php echo $_POST[tesorero] ?>" >
				<input id="codcat" type="text" name="codcat" style="width:40%;"onKeyUp="return tabular(event,this)" onBlur="buscar(event)" value="<?php echo $_POST[codcat]?>" onClick="document.getElementById('tercero').focus();document.getElementById('tercero').select();" >
				<input id="ord" type="text" name="ord"   value="<?php echo $_POST[ord]?>" style="width:10%;" readonly>
				<input id="tot" type="text" name="tot"  value="<?php echo $_POST[tot]?>" style="width:10%;" readonly>&nbsp; <a title="Listado de Predios" onClick="despliegamodal2('visible');" style="cursor:pointer;"><img src="imagenes/find02.png" style="width:20px;"/></a>
				<input type="hidden" value="0" name="bt"> 
				<input type="hidden" name="chacuerdo" value="1">
				<input type="hidden" value="1" name="oculto" id="oculto"> 
				<input type="hidden" value="<?php echo $_POST[buscav]?>" name="buscav">
				<input type="button" name="buscarb" id="buscarb" value="   Buscar   " onClick="buscar()" >
			</td>
			
			<td class="saludo1" style="width:10%;">No Resoluci&oacute;n:</td>
			<td style="width:8%;">
				<input name="nresol" type="text" id="nresol"  onClick="document.getElementById('nresol').focus();document.getElementById('nresol').select();" onKeyUp="return tabular(event,this)" style="width:80%;" value="<?php echo $_POST[nresol]?>"></td>
			</tr>
	  </table>
	  <table class="inicio">
	  <tr>
	    <td class="titulos" colspan="10">Informaci&oacute;n Predio</td></tr>
	<tr>
	<td style="width:12%" class="saludo1">C&oacute;digo Catastral:</td>
	<td style="width:10%" >
			<input type="hidden" value="<?php echo $_POST[nbanco]?>" name="nbanco"> <input name="catastral" type="text" id="catastral" style="width:100%" onBlur="buscater(event)" onClick="document.getElementById('tercero').focus();document.getElementById('tercero').select();" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[catastral]?>"  readonly></td>  
	<td class="saludo1" style="width:8%">Avaluo:</td>
	<td style="width:10%">
			<input name="avaluo" type="text" id="avaluo" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[avaluo]?>" style="width:100%" readonly>
	</td>
	<td class="saludo1" style="width:8%">Ha:</td>
	<td style="width:5%">
			<input name="ha" type="text" id="ha" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[ha]?>" style="width:100%" readonly>
	</td>
	<td  class="saludo1" style="width:8%">Mt2:</td>
	<td style="width:5%"><input name="mt2" type="text" id="mt2" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[mt2]?>" style="width:85%" readonly></td>
	<td class="saludo1" style="width:8%">Area Cons:</td>
	<td style="width:5%"><input name="areac" type="text" id="areac" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[areac]?>" style="width:70%" readonly></td>
	
	  </tr>
      <tr>	    
		 <td  class="saludo1">Documento:</td>         
	  <td><input name="documento" type="text" id="documento" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[documento]?>" readonly>
	  </td>
      <td  class="saludo1">Propietario:</td>
	  <td colspan="3"><input type="hidden" value="<?php echo $_POST[nbanco]?>" name="nbanco"> <input name="propietario" type="text" id="propietario" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[propietario]?>" style="width:100%" readonly></td>
      </tr>
      <tr>
	  <td class="saludo1">Direcci&oacute;n:</td>
	  <td  colspan="3"><input type="hidden" value="<?php echo $_POST[nbanco]?>" name="nbanco"> <input name="direccion" type="text" id="direccion" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[direccion]?>" style="width:100%" readonly></td>
			   
	     <td  class="saludo1">Tipo:</td><td>
		 <select name="tipop" onChange="validar();">
       <option value="">Seleccione ...</option>
				  <option value="urbano" <?php if($_POST[tipop]=='urbano') echo "SELECTED"?>>Urbano</option>
  				  <option value="rural" <?php if($_POST[tipop]=='rural') echo "SELECTED"?>>Rural</option>
				  </select>
                 </td>
         <?php
		 if($_POST[tipop]=='urbano')
		 {
		  ?> 
        <td class="saludo1">Estratos:</td><td><select name="estrato" >
       		<option value="">Seleccione ...</option>
            <?php
				$linkbd=conectar_bd();
				$sqlr="select *from estratos where estado='S'";
				$res=mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($res)) 
				    {
					echo "<option value=$row[0] ";
					$i=$row[0];
		
					 if($i==$_POST[estrato])
			 			{
						 echo "SELECTED";
						 $_POST[nestrato]=$row[1];
						 }
					  echo ">".$row[1]."</option>";	 	 
					}	 	
				?>            
			</select>  <input type="hidden" value="<?php echo $_POST[nestrato]?>" name="nestrato">
            </td>  
          <?php
		 }
		 else
		  {
			?>  
			<td class="saludo1">Rango Avaluo:</td>
			<td>
				<select name="rangos" disabled>
					<option value="">Seleccione ...</option>
					<?php
						$linkbd=conectar_bd();
						$sqlr="select *from rangoavaluos where estado='S'";
						$res=mysql_query($sqlr,$linkbd);
						while ($row =mysql_fetch_row($res)) 
						{
							echo "<option value=$row[0] ";
							$i=$row[0];
							if($i==$_POST[rangos])
							{
								echo "SELECTED";
								$_POST[nrango]=$row[1]." - ".$row[2]." SMMLV";
							}
							echo ">Entre ".$row[1]." - ".$row[2]." SMMLV</option>";	 	 
						}	 	
					?>            
				</select>
				<input type="hidden" value="<?php echo $_POST[nrango]?>" name="nrango">            
				<input type="hidden" value="0" name="agregadet">
			</td>
			<?php
		  }
		  ?> 
        </tr> 
      </table>
      <div class="subpantallac4">
	   <table  class="inicio" style="width:45%" >
	   	   <tr>
	   	     <td colspan="12" class="titulos">Periodos a Exonerar/Exento</td>
	   	   </tr> 
          <tr>
	   	     <td colspan="12" class="saludo1">No A&ntilde;os : <input name="agespre" type="text" size="2" value="<?php echo $_POST[agespre]?>" readonly> - Antes de: <input name="agepar" type="text" size="4" value="<?php echo $_POST[agepar]?>" readonly></td>
	   	   </tr>                   
		<tr>
		  	<td class="titulos2">Vigencia</td><td class="titulos2">Avaluo</td>
		  	<td class="titulos2"><input type="checkbox" name="selectodo" id="selectodo"></td>
	  	</tr>
	  	
       <?php
       $sqlr="Select *from tesoprediosavaluos,tesopredios where tesoprediosavaluos.codigocatastral=$_POST[codcat] and tesoprediosavaluos.estado='S' and tesoprediosavaluos.vigencia<='$_POST[agepar]' and tesoprediosavaluos.pago='N' and tesoprediosavaluos.codigocatastral=tesopredios.cedulacatastral order by tesoprediosavaluos.vigencia ASC";		
	 
			$res=mysql_query($sqlr,$linkbd);
			$cuentavigencias = mysql_num_rows($res);
			$cv=0;
			while($r=mysql_fetch_row($res))
			{
			 echo "<tr>
					<td class='saludo1'>
						<input name='vigencias[]' type='text' value='$r[0]' size='4' readonly>
					</td>
					<td class='saludo1'>
						<input name='avaluos[]' type='text' value='".number_format($r[2],0)."' readonly>
						<input name='avaluosh[]' type='hidden' value='".$r[2]."' >	
					</td>
					<td class='saludo1'>
						<input type='checkbox' class='selector' name='dselvigencias[]' value='$r[0]' onClick='buscavigencias(this)' $chk>
					</td>
				</tr>";
			}
		?>			
       </table>
       <script type="text/javascript">
	  		$("#selectodo").click(function(event) {
	  			/* Act on the event */
	  			$('.selector').prop('checked', true);
	  		});
	  	</script>
       </div>
	    <?php
if($_POST[oculto]=='2')
{
	$linkbd=conectar_bd();	
 	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	if($_POST[tipoex]=='exoneracion'){
			
		$sqlr="insert into tesoexoneracion(id,fecha, resolucion, cedulacatastral, estado) values ('$_POST[idpres]','$fechaf','$_POST[nresol]','$_POST[catastral]','S')";
		
		mysql_query($sqlr,$linkbd);
		$nid=mysql_insert_id();
		$sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($nid,32,'$fechaf','EXONERACION COD CAT: $_POST[catastral]',0,0,0,0,'1')";
		mysql_query($sqlr,$linkbd);
		
		if($_POST[tipop]=='urbano')
		$esra=$_POST[estrato];
		else
		$esra=$_POST[rangos];
		$tam=count($_POST[vigencias]);
		$tam2=count($_POST[dselvigencias]);
		//************** modificacion del presupuesto **************
		for($x=0;$x<$tam;$x++)
		{
			for($y=0;$y<$tam2;$y++)
			{
				if($_POST[vigencias][$x]==$_POST[dselvigencias][$y])
				{
					echo "<input name='pvigencias[]' type='hidden' value='".$_POST[dselvigencias][$y]."'>"; 
					echo "<input name='pavaluo[]' type='hidden' value='".$_POST[avaluosh][$x]."'>"; 		  
					$vig= $_POST[dselvigencias][$y];
					$sqlr="UPDATE tesoprediosavaluos set pago='S'  where codigocatastral=".$_POST[catastral]." and pago='N' and vigencia='".$_POST[dselvigencias][$y]."'";	  
					if (!mysql_query($sqlr,$linkbd))
					{
						echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue><img src='imagenes\alert.png'> Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
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
						
						$sqlr="insert into tesoexoneracion_det(fecha,cedulacatastral,estado,vigencia,detalle,avaluo) values ('$fechaf','$_POST[catastral]','S',$vig,'EXONERACION PREDIAL','".$_POST[avaluosh][$x]."')";
						mysql_query($sqlr,$linkbd);
						//*********COMPROBANTE CONTABLE - CONFIGURACIONES CONTABLES ******
						$sqlr2="select *from tesotarifaspredial where vigencia='".$vigusu."' and tipo='$_POST[tipop]' and estratos=$esra";
						$res2=mysql_query($sqlr2,$linkbd);
						$row2=mysql_fetch_row($res2);
						$base=$_POST[avaluosh][$x];
						$predial=$base*($row2[5]/1000);
						$sqlr2="select *from tesoingresos_det where codigo='01' and modulo='4' and  estado='S' and concepto='03' order by concepto";
						
							
						//echo $sqlr2;
						$res3=mysql_query($sqlr2,$linkbd);
						$r3=mysql_fetch_row($res3);
						$bomberil=ceil($predial*($r3[5]/100));
						
						$sqlr2="select *from tesoingresos_det where codigo='01' and modulo='4' and  estado='S' and concepto='02' order by concepto";
						//echo $sqlr2;
						$res3=mysql_query($sqlr2,$linkbd);
						$r3=mysql_fetch_row($res3);
						$ambiental=ceil($predial*($r3[5]/100));
						//*** conceptos contables ***
						//***BOMBERIL
						$sqlr2="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='02' and tipo='PR'";
						$res2=mysql_query($sqlr2,$linkbd);
						while($row2=mysql_fetch_row($res2))
						{
						   if($row2[3]=='N')
							{				 					  		
						   if($row2[6]=='S')
							{
						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('32 $nid','".$row2[4]."','".$_POST[documento]."','".$row2[5]."','EXONERACION BOMBERIL COD CAT $_POST[catastral] - $vig','',".$bomberil.",0,'1','".$vigusu."')";
						mysql_query($sqlr,$linkbd);
							}
							if($row2[6]=='N')
							{
						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('32 $nid','".$row2[4]."','".$_POST[documento]."','".$row2[5]."','EXONERACION BOMBERIL COD CAT $_POST[catastral] - $vig','',0,".$bomberil.",'1','".$vigusu."')";
						mysql_query($sqlr,$linkbd);
							}				
						   }
						 }
						//*****AMBIENTAL
						$sqlr2="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='03' and tipo='PR'";
						$res2=mysql_query($sqlr2,$linkbd);
						 while($row2=mysql_fetch_row($res2))
						  {
						   if($row2[3]=='N')
							{				 					  		
						   if($row2[6]=='S')
							{
						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('32 $nid','".$row2[4]."','".$_POST[documento]."','".$row2[5]."','EXONERACION SOBRETASA AMBIENTAL COD CAT $_POST[catastral] - $vig','',".$ambiental.",0,'1','".$vigusu."')";
						mysql_query($sqlr,$linkbd);
							}
							if($row2[6]=='N')
							{
						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('32 $nid','".$row2[4]."','".$_POST[documento]."','".$row2[5]."','EXONERACION SOBRETASA AMBIENTAL COD CAT $_POST[catastral] - $vig','',0,".$ambiental.",'1','".$vigusu."')";
						mysql_query($sqlr,$linkbd);
							}				
						   }
						 }
				//****** PREDIAL ***
							$sqlr2="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='01' and tipo='PR'";
						$res2=mysql_query($sqlr2,$linkbd);
						 while($row2=mysql_fetch_row($res2))
						  {
						   if($row2[3]=='N')
							{				 					  		
						   if($row2[6]=='S')
							{
						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('32 $nid','".$row2[4]."','".$_POST[documento]."','".$row2[5]."','EXONERACION PREDIAL COD CAT $_POST[catastral] - $vig','',".$predial.",0,'1','".$vigusu."')";
						mysql_query($sqlr,$linkbd);
							}
							if($row2[6]=='N')
							{
						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('32 $nid','".$row2[4]."','".$_POST[documento]."','".$row2[5]."','EXONERACION PREDIAL COD CAT $_POST[catastral] - $vig','',0,".$predial.",'1','".$vigusu."')";
						mysql_query($sqlr,$linkbd);
							}				
						   }
						 }
				//****FIN CONTABLE
						
			  
				echo "<script>
											despliegamodalm('visible','1','Vigencia Exonerada con Exito $vig ');
											document.form2.vguardar.value='1';
											
										</script>";
			  ?>
			<script>
			  document.form2.tercero.value="";
			  document.form2.ntercero.value="";
			</script>
		  <?php
		  }	  
	    }
			}
		}
		
	}
	if($_POST[tipoex]=='exento'){
		$sqlr="insert into tesoexentos(id,fecha, resolucion, cedulacatastral, estado) values ('$_POST[idpres]','$fechaf','$_POST[nresol]','$_POST[catastral]','S')";
		
		mysql_query($sqlr,$linkbd);
		$nid=mysql_insert_id();
		$sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($nid,33,'$fechaf','EXENTO PREDIAL COD CAT: $_POST[catastral]',0,0,0,0,'1')";
		mysql_query($sqlr,$linkbd);
		
		if($_POST[tipop]=='urbano')
		$esra=$_POST[estrato];
		else
		$esra=$_POST[rangos];
		$tam=count($_POST[vigencias]);
		$tam2=count($_POST[dselvigencias]);
		//************** modificacion del presupuesto **************
		for($x=0;$x<$tam;$x++)
		{
			for($y=0;$y<$tam2;$y++)
			{
				if($_POST[vigencias][$x]==$_POST[dselvigencias][$y])
				{
					echo "<input name='pvigencias[]' type='hidden' value='".$_POST[dselvigencias][$y]."'>"; 
					echo "<input name='pavaluo[]' type='hidden' value='".$_POST[avaluosh][$x]."'>"; 		  
					$vig= $_POST[dselvigencias][$y];
					$sqlr="UPDATE tesoprediosavaluos set pago='S'  where codigocatastral=".$_POST[catastral]." and pago='N' and vigencia='".$_POST[dselvigencias][$y]."'";	  
					if (!mysql_query($sqlr,$linkbd))
					{
						echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue><img src='imagenes\alert.png'> Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
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
						
						$sqlr="insert into tesoexentos_det(fecha,cedulacatastral,estado,vigencia,detalle,avaluo) values ('$fechaf','$_POST[catastral]','S',$vig,'EXENTO PREDIAL','".$_POST[avaluosh][$x]."')";
						mysql_query($sqlr,$linkbd);
						//*********COMPROBANTE CONTABLE - CONFIGURACIONES CONTABLES ******
						$sqlr2="select *from tesotarifaspredial where vigencia='".$vigusu."' and tipo='$_POST[tipop]' and estratos=$esra";
						$res2=mysql_query($sqlr2,$linkbd);
						$row2=mysql_fetch_row($res2);
						$base=$_POST[avaluosh][$x];
						$predial=$base*($row2[5]/1000);
						$sqlr2="select *from tesoingresos_det where codigo='01' and modulo='4' and  estado='S' and concepto='03' order by concepto";
						
							
						//echo $sqlr2;
						$res3=mysql_query($sqlr2,$linkbd);
						$r3=mysql_fetch_row($res3);
						$bomberil=ceil($predial*($r3[5]/100));
						
						$sqlr2="select *from tesoingresos_det where codigo='01' and modulo='4' and  estado='S' and concepto='02' order by concepto";
						//echo $sqlr2;
						$res3=mysql_query($sqlr2,$linkbd);
						$r3=mysql_fetch_row($res3);
						$ambiental=ceil($predial*($r3[5]/100));
						//*** conceptos contables ***
						//***BOMBERIL
						$sqlr2="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='02' and tipo='PR'";
						$res2=mysql_query($sqlr2,$linkbd);
						while($row2=mysql_fetch_row($res2))
						{
						   if($row2[3]=='N')
							{				 					  		
						   if($row2[6]=='S')
							{
						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('33 $nid','".$row2[4]."','".$_POST[documento]."','".$row2[5]."','EXENTO BOMBERIL COD CAT $_POST[catastral] - $vig','',".$bomberil.",0,'1','".$vigusu."')";
						mysql_query($sqlr,$linkbd);
							}
							if($row2[6]=='N')
							{
						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('33 $nid','".$row2[4]."','".$_POST[documento]."','".$row2[5]."','EXENTO BOMBERIL COD CAT $_POST[catastral] - $vig','',0,".$bomberil.",'1','".$vigusu."')";
						mysql_query($sqlr,$linkbd);
							}				
						   }
						 }
						//*****AMBIENTAL
						$sqlr2="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='03' and tipo='PR'";
						$res2=mysql_query($sqlr2,$linkbd);
						 while($row2=mysql_fetch_row($res2))
						  {
						   if($row2[3]=='N')
							{				 					  		
						   if($row2[6]=='S')
							{
						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('33 $nid','".$row2[4]."','".$_POST[documento]."','".$row2[5]."','EXENTO SOBRETASA AMBIENTAL COD CAT $_POST[catastral] - $vig','',".$ambiental.",0,'1','".$vigusu."')";
						mysql_query($sqlr,$linkbd);
							}
							if($row2[6]=='N')
							{
						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('33 $nid','".$row2[4]."','".$_POST[documento]."','".$row2[5]."','EXENTO SOBRETASA AMBIENTAL COD CAT $_POST[catastral] - $vig','',0,".$ambiental.",'1','".$vigusu."')";
						mysql_query($sqlr,$linkbd);
							}				
						   }
						 }
				//****** PREDIAL ***
							$sqlr2="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='01' and tipo='PR'";
						$res2=mysql_query($sqlr2,$linkbd);
						 while($row2=mysql_fetch_row($res2))
						  {
						   if($row2[3]=='N')
							{				 					  		
						   if($row2[6]=='S')
							{
						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('33 $nid','".$row2[4]."','".$_POST[documento]."','".$row2[5]."','EXENTO PREDIAL COD CAT $_POST[catastral] - $vig','',".$predial.",0,'1','".$vigusu."')";
						mysql_query($sqlr,$linkbd);
							}
							if($row2[6]=='N')
							{
						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('33 $nid','".$row2[4]."','".$_POST[documento]."','".$row2[5]."','EXENTO PREDIAL COD CAT $_POST[catastral] - $vig','',0,".$predial.",'1','".$vigusu."')";
						mysql_query($sqlr,$linkbd);
							}				
						   }
						 }
				//****FIN CONTABLE
						
			  
				echo "<script>
											despliegamodalm('visible','1','Vigencia Exonerada con Exito $vig ');
											document.form2.vguardar.value='1';
											
										</script>";
			  ?>
			<script>
			  document.form2.tercero.value="";
			  document.form2.ntercero.value="";
			</script>
		  <?php
		  }	  
	    }
			}
		}
		
	
	}
}
?>
		<div id="bgventanamodal2">
                <div id="ventanamodal2">
                    <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                    </IFRAME>
                </div>
       	</div>
   </form>
</table>
</body>
</html>