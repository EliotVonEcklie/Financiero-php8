<?php
require"comun.inc";
require"funciones.inc";
require "conversor.php";
session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<title>:: SPID - Contabilidad</title>
<script>
	function validar(){
		document.form2.submit();
	}
</script>
<script>
	function buscaop(e){
	if (document.form2.orden.value!=""){
		document.form2.bop.value='1';
		document.form2.submit();
		}
	}
</script>
<script>
function agregardetalle()
{
if(document.form2.numero.value!="" &&  document.form2.valor.value>0 &&  document.form2.banco.value!=""  )
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
function agregardetalled()
{
if(document.form2.retencion.value!="" &&  document.form2.vporcentaje.value!=""  )
{ 
				document.form2.agregadetdes.value=1;
	//			document.form2.chacuerdo.value=2;
				document.form2.submit();
 }
 else {
 alert("Falta informacion para poder Agregar");
 }
}
</script>
<script>
function eliminar(variable)
{
if (confirm("Esta Seguro de Eliminar"))
  {
document.form2.elimina.value=variable;
//eli=document.getElementById(elimina);
vvend=document.getElementById('elimina');
//eli.value=elimina;
vvend.value=variable;
document.form2.submit();
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

//************* genera reporte ************
//***************************************
function guardar()
{

if (document.form2.fecha.value!='' && document.form2.tercero.value!='' && document.form2.banco.value!='')
  {
	if (confirm("Esta Seguro de Guardar"))
  	{
  	document.form2.oculto.value=2;
  	document.form2.submit();
  	}
  }
  else{
  alert('Faltan datos para completar el registro');
  	document.form2.fecha.focus();
  	document.form2.fecha.select();
  }
}

function calcularpago()
 {
	//alert("dddadadad");
	valorp=document.form2.valor.value;
	descuentos=document.form2.totaldes.value;
	valorc=valorp-descuentos;
	document.form2.valorcheque.value=valorc;
	document.form2.valoregreso.value=valorp;
	document.form2.valorretencion.value=descuentos;
	
 }

function pdf()
{
document.form2.action="pdfegreso.php";
document.form2.target="_BLANK";
document.form2.submit(); 
document.form2.action="";
document.form2.target="";
}

function adelante(){
	//document.form2.oculto.value=2;
	if(parseFloat(document.form2.idcomp.value)<parseFloat(document.form2.maximo.value)){
		document.form2.oculto.value=1;
		//document.form2.agregadet.value='';
		//document.form2.elimina.value='';
		document.form2.idcomp.value=parseFloat(document.form2.idcomp.value)+1;
		dato=document.form2.idcomp.value;
		document.form2.action="cont-pagotercerosvigant-reflejar.php?idpago="+dato;
		document.form2.submit();
	}
}

function atrasc(){
	//document.form2.oculto.value=2;
	if(document.form2.idcomp.value>1){
		document.form2.oculto.value=1;
		//document.form2.agregadet.value='';
		//document.form2.elimina.value='';
		document.form2.idcomp.value=document.form2.idcomp.value-1;
		dato=document.form2.idcomp.value;
		document.form2.action="cont-pagotercerosvigant-reflejar.php?idpago="+dato;
		document.form2.submit();
	}
}

function validar2()
{
	if((document.form2.idcomp.value>=1)&&(parseFloat(document.form2.idcomp.value)<=parseFloat(document.form2.maximo.value))){
		document.form2.oculto.value=1;
		document.form2.ncomp.value=document.form2.idcomp.value;
		dato=document.form2.idcomp.value;
		document.form2.action="cont-pagotercerosvigant-reflejar.php?idpago="+dato;
		document.form2.submit();
	}else{
		document.form2.idcomp.value=document.form2.ncomp.value;
		document.form2.submit();
	}
}
function direccionaCuentaGastos(row){
//alert (row);
window.open("presu-editarcuentaspasiva.php?idcta="+row);
}
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
			case "1":	
				document.form2.oculto.value=2;
				document.form2.submit();
			break;
		}
	}

	function funcionmensaje()
	{
	}
</script>
<script src="css/programas.js"></script>
<script src="css/calendario.js"></script>
<script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
<link href="css/tabs.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
	<tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
	<tr><?php menu_desplegable("cont");?></tr>
	<tr>
  		<td colspan="3" class="cinta">
			<a href="#" class="mgbt"><img src="imagenes/add2.png" alt="Nuevo"  border="0" /></a>
			<a href="#" class="mgbt"><img src="imagenes/guardad.png"  alt="Guardar" /></a>
			<a href="cont-buscapagoterceros-refleja.php" class="mgbt"> <img src="imagenes/busca.png"  alt="Buscar" border="0" title="Buscar" /></a>
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#"  class="mgbt" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" alt="nueva ventana" title="Nueva ventana"></a>
			<a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/reflejar1.png"  alt="Reflejar" style="width:24px;" title="Reflejar" /></a>
			<a href="#" onClick="pdf()" class="mgbt"> <img src="imagenes/print.png"  alt="Imprimir" title="Imprimir" /></a>
			<a href="cont-reflejardocs.php" class="mgbt"><img src="imagenes/iratras.png" alt="atr&aacute;s" title="Atr&aacute;s"></a>			
        </td>
	</tr>		  
</table>
<tr><td colspan="3" class="tablaprin" align="center"> 
<?php
$vigencia=date(Y);
$vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
$linkbd=conectar_bd();
$sqlr="select *from cuentapagar where estado='S' ";
$res=mysql_query($sqlr,$linkbd);
while ($row =mysql_fetch_row($res)){
	$_POST[cuentapagar]=$row[1];
}

$sqlr="select * from admbloqueoanio";
$res=mysql_query($sqlr,$linkbd);
$_POST[anio]=array();
$_POST[bloqueo]=array();
while ($row =mysql_fetch_row($res)){
	$_POST[anio][]=$row[0];
	$_POST[bloqueo][]=$row[1];
}
?>	
<?php
if($_GET[idpago]!="")
{echo "<script>document.getElementById('codrec').value=$_GET[idpago];</script>";}
elseif($_GET[consecutivo]!="")
{echo "<script>document.getElementById('codrec').value=$_GET[consecutivo];</script>";}
if(!$_POST[oculto]){
	$linkbd=conectar_bd();
	if($_GET[idpago]=='' && $_GET[consecutivo]==''){
		$sqlr="select max(id_pago) from tesopagotercerosvigant";
		$res=mysql_query($sqlr,$linkbd);
		$row =mysql_fetch_row($res);
		$_GET[idpago]=$row[0];
	}
	$sqlr="select max(id_pago) from tesopagotercerosvigant";
 	$resp = mysql_query($sqlr,$linkbd);
	$row =mysql_fetch_row($resp);
	$_POST[maximo]=$row[0];
	$_POST[idcomp]=$_POST[maximo];
	if($_GET[idpago]!="")
	{
		$_POST[idcomp]=$_GET[idpago];
	}
	if($_GET[consecutivo]!="")
	{
		$_POST[idcomp]=$_GET[consecutivo];
	}
	if ($_POST[codrec]!="" || $_GET[idpago]!="" || $_GET[consecutivo]!=""){
		if($_POST[codrec]!=""){
			$sqlr="select * from tesopagotercerosvigant where id_pago='$_POST[codrec]' ";
		}
		elseif($_POST[idpago]!=""){
			$sqlr="select * from tesopagotercerosvigant where id_pago='$_GET[idpago]' ";
		}
		else
		{
			$sqlr="select * from tesopagotercerosvigant where id_pago='$_GET[consecutivo]' ";
		}
	}
	else{
		$sqlr="select * from tesopagotercerosvigant ORDER BY id_pago DESC";
	}
	$res=mysql_query($sqlr,$linkbd);
	$r=mysql_fetch_row($res);
	$_POST[ncomp]=$r[0];
	$_POST[idcomp]=$r[0];
	$check1="checked";
	
	$sqlr="select *from cuentamiles where estado='S' ";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
	{
	 $_POST[cuentamiles]=$row[1];
	}
}

//$_POST[vigencia]=$vigusu; 		
$sqlr="select * from tesoegresos where id_egreso=$_POST[idcomp] and tipo_mov='201'";
$res=mysql_query($sqlr,$linkbd);
//echo $sqlr;
$consec=0;
while($r=mysql_fetch_row($res)){
	$consec=$r[0];	  
	$_POST[orden]=$r[2];
	$_POST[tipop]=$r[14];
	$_POST[banco]=$r[9];
	$_POST[estado]=$r[13];
	$_POST[vigencia]=substr($r[3],0,4);
	if ($_POST[estado]=='N')
		$estadoc="ANULADO";
	else if($_POST[estado]=='S' || $_POST[estado]=='P' || $_POST[estado]=='C')
	   	$estadoc="ACTIVO";
	else
		$estadoc="REVERSADO";

	$_POST[ncheque]=$r[10];		  		  
	$_POST[cb]=$r[12];		  
  	$_POST[transferencia]=$r[12];
	$_POST[fecha]=$r[3];		  		  		  
}
ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
$_POST[fecha]=$fechaf;
$_POST[vigencia2]=$fecha[1];
$_POST[egreso]=$consec;		 
 ?>	
</table>
<tr><td colspan="3" class="tablaprin" align="center"> 
<form name="form2" method="post" action=""> 
<?php
$vigencia=date(Y);
$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
$vigencia=$vigusu;
 ?>	
<?php

//$check1="checked";
$_POST[vigencia]=$vigusu; 
if($_GET[consecutivo]!='')	
	$sqlr="select * from tesopagotercerosvigant where id_pago=$_GET[consecutivo]";
else
	$sqlr="select * from tesopagotercerosvigant where id_pago=$_GET[idpago]";
$res=mysql_query($sqlr,$linkbd);
$consec=0;
while($r=mysql_fetch_row($res))
{
	$consec=$r[0];	  
	$fec=$r[10];
	ereg("([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $r[10],$fecha);
	$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
	$_POST[fecha]=$fechaf; 		 		  			 
	if ($r[3]!=''){
		$_POST[tipop]="cheque";
		$_POST[ncheque]=$r[3];		  
	}
	if($r[4]!=''){
		$_POST[tipop]="transferencia";		  
		$_POST[ntransfe]=$r[4];
	}
	$_POST[mes]=$r[6];
	$_POST[banco]=$r[2];
	if(strlen($_POST[banco])<9){
		$_POST[banco]=substr($_POST[banco],0,-2).'0'.substr($_POST[banco],-2);
	}
	$_POST[tercero]=$r[1]; 		 		  			
	$_POST[ntercero]=buscatercero($r[1]); 		 		  					  
	$_POST[cc]=$r[8]; 		 		  			
	$_POST[concepto]=$r[7];
	$_POST[valorpagar]=$r[5];
	$_POST[estado]=$r[9];
	$_POST[idcomp]=$r[0];
}
$consec+=1;
if($_GET[consecutivo]!='')
	$sqlr="select * from tesopagotercerosvigant_det where id_pago='$_GET[consecutivo]'";
else
	$sqlr="select * from tesopagotercerosvigant_det where id_pago='$_GET[idpago]'";
$res=mysql_query($sqlr,$linkbd);		
$consec=0;
$_POST[mddescuentos]=array();
$_POST[mtdescuentos]=array();		
$_POST[mddesvalores]=array();
$_POST[mddesvalores2]=array();		
$_POST[mdndescuentos]=array();
$_POST[ddescuentos]=array();
$_POST[mdctas]=array();

$_POST[dndescuentos]=array();
$_POST[dtdescuentos]=array();
$_POST[dfvalores]=array();
$_POST[dvalores]=array();		 
$_POST[dcontable]=array();	

while($r=mysql_fetch_row($res)){
	$_POST[dtdescuentos][]=$r[2];
	$_POST[dfvalores][]=$r[3];
	$_POST[dvalores][]=$r[3];		 
	$_POST[dcontable][]=$r[4];		 
	if($r[2]=='I'){
		$_POST[dndescuentos][]=$r[2].'-'.$r[1].'-'.buscaingreso($r[1]);
	}
	if($r[2]=='R'){
		$_POST[dndescuentos][]=$r[2].'-'.buscaretencioncod($r[1]).'-'.buscaretencion($r[1]);
		$resi=buscaretencion($r[1]);
	}		  
	$_POST[ddescuentos][]=$r[2].'-'.$r[1];
}

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
}
?>

 <?php
 $meses=array('','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
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
 ?>
	   
	   	<table class="inicio" align="center" >
       		<tr>
	     		<td colspan="8" class="titulos">Otros Egresos</td>
	     		<td  class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
	     	</tr>
       		<tr> 
       			<td style="width:12%;" class="saludo1" >N&uacute;mero Pago:</td>
	   			<td style="width:12%;">
	   				<a href="#" onClick="atrasc()"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a>
        			<input type="text" id="idcomp" name="idcomp" value="<?php echo $_POST[idcomp]?>" onKeyUp="return tabular(event,this) "  onBlur="validar2()"  style="width:60%;" />
					<input type="hidden" name="ncomp" id="ncomp" value="<?php echo $_POST[ncomp]?>"/>
					<a href="#" onClick="adelante()"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a>
	   				<input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo">
					<input type="hidden" value="<?php echo $_POST[codrec]?>" name="codrec" id="codrec">
	   			</td>
				<td  class="saludo1">Fecha: </td>
        		<td  >
        			<input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10" style="width:50%;" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" readonly>   
        		</td>
	  			<td   class="saludo1">Vigencia: </td>
        		<td  style="width:20%;">
        			<input name="vigencia" type="text" value="<?php echo $_POST[vigencia]?>" maxlength="2" style="width:30%;" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly> 
					
					<input name="estado" type="hidden" value="<?php echo $_POST[estado] ?>" onKeyUp="return tabular(event,this) " readonly>
					<?php 
							if($_POST[estado]=="S"){
								$valuees="ACTIVO";
								$stylest="width:67%; background-color:#0CD02A; color:white; text-align:center;";
							}else if($_POST[estado]=="N"){
								$valuees="ANULADO";
								$stylest="width:67%; background-color:#FF0000; color:white; text-align:center;";
							}else if($_POST[estado]=="P"){
								$valuees="PAGO";
								$stylest="width:67%; background-color:#0404B4; color:white; text-align:center;";
							}
							echo "<input type='text' name='estado' id='estado' value='$valuees' style='$stylest' readonly />";
					?>
        		</td>
       			<td class="saludo1">Forma de Pago:</td>
       			<td >
       				<input name="vigencia" type="text" value="<?php echo strtoupper($_POST[tipop])?>" maxlength="20" style="width:80%;" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly>
	     		</td>
 			</tr>
         	<?php 
	  		//**** if del cheques
	  		if($_POST[tipop]=='cheque')
	    	{
	  		?>    
           	<tr>
	  			<td class="saludo1">Cuenta Bancaria:</td>
	  			<td >
	     			<select id="banco" name="banco"  onChange="validar()" onKeyUp="return tabular(event,this)">
	      				<?php
						$linkbd=conectar_bd();
						$sqlr="select tesobancosctas.estado,tesobancosctas.cuenta,tesobancosctas.ncuentaban,tesobancosctas.tipo,terceros.razonsocial,tesobancosctas.tercero from tesobancosctas,terceros where tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.estado='S' ";
						$res=mysql_query($sqlr,$linkbd);
						while ($row =mysql_fetch_row($res)) 
						{
							$i=$row[1];
							if($i==$_POST[banco])
							{
								$_POST[nbanco]=$row[4];
								$_POST[ter]=$row[5];
								$_POST[cb]=$row[2];
								echo "<option value=$row[1] SELECTED >".$row[2]." - Cuenta ".$row[3]." y mangos</option>";
							}		 
						}	 	
						?>
            		</select>
					<?php 
					$sqlr="select count(*) from tesochequeras where banco='$_POST[ter]' and cuentabancaria='$_POST[cb]' and estado='S' ";
					$res2=mysql_query($sqlr,$linkbd);
					$row2 =mysql_fetch_row($res2);
					if($row2[0]<=0 && $_POST[oculto]!='')
					  {
					   //echo "<script>alert('No existe una chequera activa para esta Cuenta');document.form2.banco.value=''; document.form2.banco.focus();</script>";
					  $_POST[nbanco]="";
					  $_POST[ncheque]="";
					  }
					  else
					   {
					    $sqlr="select * from tesochequeras where banco='$_POST[ter]' and cuentabancaria='$_POST[cb]' and estado='S' ";
						$res2=mysql_query($sqlr,$linkbd);
						$row2 =mysql_fetch_row($res2);
					   //$_POST[ncheque]=$row2[6];
					   
					   }
					 ?>
					<input name="cb" type="hidden" value="<?php echo $_POST[cb]?>" >
					<input type="hidden" id="ter" name="ter" value="<?php echo $_POST[ter]?>" >
				</td>
				<td colspan="2">
					<input type="text" id="nbanco" name="nbanco" value="<?php echo $_POST[nbanco]?>" style="width:100%;" readonly>
				</td>
				<td  class="saludo1">Cheque:</td>
				<td >
					<input type="text" id="ncheque" name="ncheque" value="<?php echo $_POST[ncheque]?>"  >
				</td>
	  		</tr>
		      <?php
			     }//cie	rre del if de cheques
		      ?> 
		       <?php 
			  //**** if del transferencias
			  if($_POST[tipop]=='transferencia')
			    {
			  ?> 
      		<tr>
	  			<td class="saludo1">Cuenta Bancaria:</td>
	  			<td >
	     		<select id="banco" name="banco"  onChange="validar()" onKeyUp="return tabular(event,this)">
		      		<?php
					$linkbd=conectar_bd();
					$sqlr="select tesobancosctas.estado,tesobancosctas.cuenta,tesobancosctas.ncuentaban,tesobancosctas.tipo,terceros.razonsocial,tesobancosctas.tercero from tesobancosctas,terceros where tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.estado='S' ";
					$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res)) 
					{
						$i=$row[1];
						if($i==$_POST[banco])
						{
							$_POST[nbanco]=$row[4];
							$_POST[ter]=$row[5];
							$_POST[cb]=$row[2];
							echo "<option value=$row[1] SELECTED >".$row[2]." - Cuenta ".$row[3]." y mangos</option>";
						}		 
					}	  	
					?>
            	</select>
				<input name="cb" type="hidden" value="<?php echo $_POST[cb]?>" >
				<input type="hidden" id="ter" name="ter" value="<?php echo $_POST[ter]?>" >
			</td>
			<td colspan="2">
				<input type="text" id="nbanco" name="nbanco" value="<?php echo $_POST[nbanco]?>" style="width:100%;" readonly>
			</td>
			<td class="saludo1">No Transferencia:</td>
			<td >
				<input type="text" id="ntransfe" name="ntransfe" style="width:100%;" value="<?php echo $_POST[ntransfe]?>" >
			</td>
	  	</tr>
      <?php
	     }//cierre del if de cheques
      ?> 
		<tr> 
      		<td  class="saludo1">Tercero:</td>
          	<td   >
          		<input id="tercero" type="text" name="tercero" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" style="width:78%;" value="<?php echo $_POST[tercero]?>" readonly >
			</td>
           	<td colspan="2">
           		<input name="ntercero" type="text" value="<?php echo $_POST[ntercero]?>" style="width:100%;" readonly>
           	</td>
           	<td class="saludo1">Centro Costo:</td>
           	<td colspan="3">
				<select name="cc"  onChange="validar()"  onKeyUp="return tabular(event,this)">
				<?php
				$linkbd=conectar_bd();
				$sqlr="select *from centrocosto where estado='S'";
				$res=mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($res)) 
					{
					$i=$row[0];
					if($i==$_POST[cc])
						{
							echo "<option value=$row[0] SELECTED >".$row[0]." - ".$row[1]."</option>";	
						}					  
					}	 	
				?>
			   	</select>
	 		</td>
	 	</tr>
        <tr>
         	<td class="saludo1">Concepto</td>
         	<td colspan="3">
         		<input type="hidden" value="<?php echo "1"?>" name="oculto">
         		<input type="text" name="concepto" style="width:100%;" value="<?php echo $_POST[concepto]?>" readonly >
         	</td> 
          	<td class="saludo1">Valor a Pagar:</td>
          	<td>
          		<input name="valorpagar" type="text" id="valorpagar" onKeyUp="return tabular(event,this)" style="width:100%;" value="<?php echo number_format($_POST[valorpagar],2)?>"  readonly>
          	</td>  
		</tr>	
    </table>
		<table class="inicio" style="overflow:scroll">
		 <?php 	
		if ($_POST[eliminad]!='')
		 { 
		 //echo "<TR><TD>ENTROS :".$_POST[elimina]."</TD></TR>";
		 $posi=$_POST[eliminad];
		 unset($_POST[dcontable][$posi]); 
		 unset($_POST[ddescuentos][$posi]);
		  unset($_POST[dtdescuentos][$posi]);
		 unset($_POST[dndescuentos][$posi]);
		  unset($_POST[dfvalores][$posi]);
		 unset($_POST[dvalores][$posi]);
		 $_POST[dcontable]= array_values($_POST[dcontable]); 		 
		 $_POST[dtdescuentos]= array_values($_POST[dtdescuentos]); 		 
		 $_POST[ddescuentos]= array_values($_POST[ddescuentos]); 
		 $_POST[dndescuentos]= array_values($_POST[dndescuentos]); 
		  $_POST[dfvalores]= array_values($_POST[dfvalores]); 
		 $_POST[dvalores]= array_values($_POST[dvalores]); 
		 }	 
		 if ($_POST[agregadetdes]=='1')
		 {
		 $_POST[dtdescuentos][]=substr($_POST[retencion],0,1);
		 $_POST[ddescuentos][]=$_POST[retencion];
		 $_POST[dndescuentos][]=$_POST[nretencion];
		 $_POST[dvalores][]=$_POST[valor];
		 $_POST[dfvalores][]=number_format($_POST[valor],2);
		 $_POST[agregadetdes]='0';
		 ?>
		 <script>
        document.form2.porcentaje.value=0;
        document.form2.vporcentaje.value=0;	
		document.form2.retencion.value='';
		document.form2.valor.value='';			
        </script>
		<?php
		 }
		  ?>
		<tr>
			<td class="titulos">Retenciones e Ingresos</td>
			<td class="titulos">Valor</td>
			<td class="titulos2"><img src="imagenes/del.png" ><input type='hidden' name='eliminad' id='eliminad'></td>
		</tr>
      	<?php
		$totalpagar=0;
		$linkbd=conectar_bd();
		ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
		$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
		for ($x=0;$x<count($_POST[dndescuentos]);$x++){		 
			$tm=strlen($_POST[dndescuentos][$x]);
			if(substr($_POST[dndescuentos][$x],0,1)=='R'){
				$sqlr="select *from tesoretenciones_det,tesoretenciones where tesoretenciones.id='".substr($_POST[ddescuentos][$x],2,$tm-2)."'  and tesoretenciones_det.codigo=tesoretenciones.id";
				$res2=mysql_query($sqlr,$linkbd);	
				while($row2=mysql_fetch_row($res2)){
					$rest=substr($row2[6],-2);
					$sq="select fechainicial from conceptoscontables_det where codigo='$row2[4]' and modulo='$row2[5]' and tipo='$rest' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
					$re=mysql_query($sq,$linkbd);
					while($ro=mysql_fetch_assoc($re))
					{
						$_POST[fechacausa]=$ro["fechainicial"];
					}
					$sqlr="select * from conceptoscontables_det where codigo='$row2[4]' and modulo='$row2[5]' and tipo='$rest' and fechainicial='".$_POST[fechacausa]."'";
					$rst=mysql_query($sqlr,$linkbd);
					$row1=mysql_fetch_assoc($rst);
					$vcont=$row1['cuenta'];
				}
			}
			if(substr($_POST[dndescuentos][$x],0,1)=='I')
			{
				$sqlr="select *from  tesoingresos_det where codigo='".substr($_POST[ddescuentos][$x],2,$tm-2)."'";
				$res2=mysql_query($sqlr,$linkbd);	
				while($row2 =mysql_fetch_row($res2)){
					$sqlr="select *from  conceptoscontables_det where codigo='$row2[2]' and modulo='4' and tipo='C' ";
					$res3=mysql_query($sqlr,$linkbd);	
					while($row3 =mysql_fetch_row($res3)){
						if(substr($row3[4],0,1)=='2'){
							$vpor=$row2[5];
							$vcont=$row3[4];
						}
					}
				}
			}
			//**********
			echo "<tr>
		 		<td class='saludo2'>
		 			<input name='dtdescuentos[]' value='".$_POST[dtdescuentos][$x]."' type='hidden'>
		 			<input name='dndescuentos[]' value='".$_POST[dndescuentos][$x]."' type='text' size='100' readonly>
					<input name='ddescuentos[]' value='".$_POST[ddescuentos][$x]."' type='hidden'>
					<input name='dcon[]' value='".$vcont."' type='hidden' size='20' readonly>
		 		</td>
		 		<td class='saludo2'><input name='dfvalores[]' value='".$_POST[dfvalores][$x]."' type='text' size='20' readonly>
		 			<input name='dvalores[]' value='".$_POST[dvalores][$x]."' type='hidden'>
		 		</td>
		 	</tr>";	
			$totalpagar+=$_POST[dvalores][$x];	
		}		 
		$_POST[valorretencion]=$totaldes;

		?>
        <?php
        $resultado = convertir($totalpagar);
		$_POST[letras]=$resultado." PESOS M/CTE";
		 echo "<tr>
		 		<td>Total:</td>
		 		<td class='saludo2'>
		 			<input type='hidden' name='totalpago2' value='$totalpagar' >
		 			<input type='text' name='totalpago' value='".number_format($totalpagar,2)."' size='20' readonly>
		 		</td>
		 	</tr>";
		 echo "<tr>
		 		<td colspan='3'>
		 			<input name='letras' type='text' value='$_POST[letras]' size='150' >
		 		</td>
		 		</tr>";
		    //***** busca tercero
			 if($_POST[bt]=='1')
			 {
			  $nresul=buscatercero($_POST[tercero]);
			  if($nresul!='')
			   {
			  $_POST[ntercero]=$nresul;
  				?>
			  <script>
			  document.getElementById('retencion').focus();document.getElementById('retencion').select();</script>
			  <?php
			  }
			 else
			 {
			  $_POST[ntercero]="";
			  ?>
			  <script>
				alert("Tercero Incorrecto o no Existe")				   		  	
		  		document.form2.tercero.focus();	
			  </script>
			  <?php
			  }
			 }

		?>
        <script>
        document.form2.valorpagar.value=<?php echo round($totalpagar,0);?>;	
        //document.form2.valorpagarmil.value=<?php echo $vmil;?>;	
		//document.form2.diferencia.value=<?php echo round($dif,0);?>;
		document.form2.validar();
        </script>
        </table>
	   </div>
        <?php	  
	//  echo "oculto".$_POST[oculto];
if($_POST[oculto]=='2')
{
	$linkbd=conectar_bd();	
	ereg("([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	$bloq=bloqueos($_SESSION[cedulausu],$fechaf);	
//	echo "$bloq  ".$_POST[fecha];
	if($bloq>=1)
	{
 	ereg("([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	$linkbd=conectar_bd();
	$sqlr="delete from comprobante_cab where numerotipo=$_POST[idcomp] and tipo_comp=15";
	mysql_query($sqlr,$linkbd);
	$sqlr="delete from comprobante_det where numerotipo=$_POST[idcomp] and tipo_comp=15";
	mysql_query($sqlr,$linkbd);
	if($_POST[estado]=='S' || $_POST[estado]=='P')
		$estado = 1;
	else
		$estado = 0;
		
	$sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($_POST[idcomp] ,15,'$fechaf','$_POST[concepto]',0,$totalpagar,$totalpagar,0,'$estado')";
	mysql_query($sqlr,$linkbd);


	//echo "<br>C:".count($_POST[mddescuentos]);
	for ($x=0;$x<count($_POST[ddescuentos]);$x++)
	 {		
			$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('15 $_POST[idcomp]','".$_POST[dcon][$x]."','".$_POST[tercero]."','".$_POST[cc]."','PAGO RECAUDO A VIG ANTERIOR MES ".$meses[$_POST[mes]]."','$_POST[ncheque]$_POST[ntransfe]',".$_POST[dvalores][$x].",0,'1','".$vigusu."')";
			echo "$sqlr <br>";
			mysql_query($sqlr,$linkbd);  
		  
		 //*** Cuenta BANCO **
			$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('15 $_POST[idcomp]','".$_POST[banco]."','".$_POST[tercero]."','".$_POST[cc]."','PAGO RECAUDO A TERCERO MES ".$meses[$_POST[mes]]."','$_POST[ncheque]$_POST[ntransfe]',0,".$_POST[dvalores][$x].",'1','".$vigusu."')";
			mysql_query($sqlr,$linkbd);
		//	echo "$sqlr <br>";	
	  }
	   echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado el Egreso con Exito <img src='imagenes/confirm.png'></center></td></tr></table>";
	}
}
?>	
</form>
 </td></tr>  
</table>
</body>
</html>	 