<?php //V 1001 20/12/16 Modificado implementacion de Reversion?> 
<?php //V 1000 12/12/16 ?> 
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
<title>:: SPID - Presupuesto</title>
<script language="JavaScript1.2">
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
</script>
<script>
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
<script>
//************* genera reporte ************
//***************************************
function guardar()
{

if (document.form2.fecha.value!='')
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
</script>
<script>
function calcularpago()
 {
	valorp=document.form2.valor.value;
	descuentos=document.form2.totaldes.value;
	valorc=valorp-descuentos;
	document.form2.valorcheque.value=valorc;
	document.form2.valoregreso.value=valorp;
	document.form2.valorretencion.value=descuentos;
	
 }
</script>
<script>
function pdf()
{
document.form2.action="pdfegreso.php";
document.form2.target="_BLANK";
document.form2.submit(); 
document.form2.action="";
document.form2.target="";
}
</script>
<script language="JavaScript1.2">
function adelante()
{

//document.form2.oculto.value=2;
if(parseFloat(document.form2.ncomp.value)<parseFloat(document.form2.maximo.value))
 {
document.form2.oculto.value=1;
//document.form2.agregadet.value='';
//document.form2.elimina.value='';
document.form2.ncomp.value=parseFloat(document.form2.ncomp.value)+1;
document.form2.egreso.value=parseFloat(document.form2.egreso.value)+1;
document.form2.action="presu-girarcheques-reflejar.php";
document.form2.submit();
}
else
{
	  // alert("Balance Descuadrado"+parseFloat(document.form2.maximo.value));
	}
}
</script>
<script language="JavaScript1.2">
function atrasc()
{

//document.form2.oculto.value=2;
if(document.form2.ncomp.value>1)
 {

document.form2.oculto.value=1;
//document.form2.agregadet.value='';
//document.form2.elimina.value='';
document.form2.ncomp.value=document.form2.ncomp.value-1;
document.form2.egreso.value=document.form2.egreso.value-1;
document.form2.action="presu-girarcheques-reflejar.php";
document.form2.submit();
 }
}
</script>
<script language="JavaScript1.2">
function validar2()
{
//   alert("Balance Descuadrado");
document.form2.oculto.value=1;
document.form2.ncomp.value=document.form2.egreso.value;
//document.form2.agregadet.value='';
//document.form2.elimina.value='';
document.form2.action="presu-girarcheques-reflejar.php";
document.form2.submit();
}
</script>
<script src="css/programas.js"></script>
<script src="css/calendario.js"></script>
<link href="css/css2.css" rel="stylesheet" type="text/css" />
<link href="css/css3.css" rel="stylesheet" type="text/css" />
<link href="css/tabs.css" rel="stylesheet" type="text/css" />
<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
	<tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
	<tr><?php menu_desplegable("presu");?></tr>
	<tr>
  		<td colspan="3" class="cinta">
  			<a class="mgbt" href="#" ><img src="imagenes/add2.png" alt="Nuevo"  border="0" /></a>
  			<a class="mgbt" href="#"><img src="imagenes/guardad.png"  alt="Guardar" /></a>
  			<a class="mgbt" href="presu-buscagirarcheques-reflejar.php"> <img src="imagenes/busca.png"  alt="Buscar" border="0" /></a> 
  			<a class="mgbt" href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" alt="nueva ventana"></a>
  			<a class="mgbt" href="#" onClick="guardar()"><img src="imagenes/reflejar1.png"  alt="Reflejar" style="width:24px;" /> 
  			<a class="mgbt" href="#" onClick="pdf()"> <img src="imagenes/print.png"  alt="Imprimir" /></a> 
  			<a class="mgbt" href="presu-reflejardocs.php"><img src="imagenes/iratras.png" alt="nueva ventana"></a>			
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
?>	

<?php
if($_GET[idegre]!=""){echo "<script>document.getElementById('codrec').value=$_GET[idegre];</script>";}
//*********** cuenta origen va al credito y la destino al debito
if(!$_POST[oculto]){
	$linkbd=conectar_bd();
	$sqlr="select *from cuentapagar where estado='S' ";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)){
		$_POST[cuentapagar]=$row[1];
	}
	$sqlr="select * from tesoegresos ORDER BY id_egreso DESC";
	$res=mysql_query($sqlr,$linkbd);
	$r=mysql_fetch_row($res);
	$_POST[maximo]=$r[0];

	if ($_POST[codrec]!="" || $_GET[idegre]!=""){
		if($_POST[codrec]!=""){
			$sqlr="select * from tesoegresos where id_egreso='$_POST[codrec]'";
		}
		else{
			$sqlr="select * from tesoegresos where id_egreso='$_GET[idegre]'";
		}
	}
	else{
		$sqlr="select * from tesoegresos ORDER BY id_egreso DESC";
	}
	$res=mysql_query($sqlr,$linkbd);
	$r=mysql_fetch_row($res);
	$_POST[ncomp]=$r[0];
	$_POST[egreso]=$r[0];
	$check1="checked";
	// $fec=date("d/m/Y");
 	//$_POST[fecha]=$fec; 		 		  			 
	//$_POST[valor]=0;
	//$_POST[valorcheque]=0;
	//$_POST[valorretencion]=0;
	//$_POST[valoregreso]=0;
	//$_POST[totaldes]=0;
}
//$_POST[vigencia]=$vigusu; 		
$sqlr="select * from tesoegresos where id_egreso=$_POST[ncomp]";
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
	if ($_POST[estado]=='N')$estadoc="ANULADO";
	if ($_POST[estado]=='S')$estadoc="ACTIVO";
	if ($_POST[estado]=='R')$estadoc="REVERSADO";

	$_POST[ncheque]=$r[10];		  		  
	$_POST[cb]=$r[12];		  
  	$_POST[transferencia]=$r[12];
	$_POST[fecha]=$r[3];		  		  		  
}
ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
$_POST[fecha]=$fechaf;
$_POST[egreso]=$consec;		 

switch($_POST[tabgroup1]){
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

<form name="form2" method="post" action=""> 
 	<?php
	if($_POST[orden]!='' ){
		//*** busca detalle cdp
		$linkbd=conectar_bd();
  		$sqlr="select *from tesoordenpago where id_orden=$_POST[orden] ";
		//echo $sqlr;
		$resp = mysql_query($sqlr,$linkbd);
		$row =mysql_fetch_row($resp);
		$_POST[concepto]=$row[7];
		$_POST[tercero]=$row[6];
		$_POST[vigenciaop]=$row[3];
		$_POST[ntercero]=buscatercero($_POST[tercero]);
		$_POST[valororden]=$row[10];
		$_POST[cc]=$row[5];
		$_POST[retenciones]=$row[12];
		$_POST[base]=$row[10];
		$_POST[iva]=$row[12];
		$_POST[vigenciadoc]=$row[3];
		$_POST[totaldes]=number_format($_POST[retenciones],2);
		$_POST[valorpagar]=$_POST[valororden]-$_POST[retenciones];
		$_POST[bop]="";
		$_POST[medio_pago] = $row[19];
	}
	else{
		$_POST[cdp]="";
		$_POST[detallecdp]="";
		$_POST[tercero]="";
		$_POST[ntercero]="";
		$_POST[bop]="";
	}
  	?>
 	<div class="tabsic"> 
   		<div class="tab"> 
       		<input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
	   		<label for="tab-1">Egreso</label>
	   		<div class="content" style="height:90%; overflow:hidden;">
	   			<table class="inicio" align="center" >
	   				<tr>
	     				<td colspan="6" class="titulos">Comprobante de Egreso</td>
                        <td style="width:7%;" class="cerrar" ><a href="presu-principal.php">Cerrar</a></td>
                 	</tr>
       				<tr>
       					<td style="width:2.5cm" class="saludo1">No Egreso:</td>
                        <td style="width:10%">
                        	<a href="#" onClick="atrasc()"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a>
                            <input name="cuentapagar" type="hidden" value="<?php echo $_POST[cuentapagar]?>" > 
                            <input name="egreso" type="text" value="<?php echo $_POST[egreso]?>" style="width:50%" onKeyUp="return tabular(event,this)" onBlur="validar2()"  > 
                            <input name="ncomp" type="hidden" value="<?php echo $_POST[ncomp]?>">
                            <a href="#" onClick="adelante()"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> 
                            <input type="hidden" value="a" name="atras" ><input type="hidden" value="s" name="siguiente" >
                            <input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo">
                            <input type="hidden" value="<?php echo $_POST[codrec]?>" name="codrec" id="codrec">
                     	</td>
       	  				<td style="width:2.5cm" class="saludo1">Fecha: </td>
        				<td style="10%">
                        	<input id="fc_1198971545" name="fecha" type="text" value="<?php echo $_POST[fecha]?>"  style="width:100%;" onKeyUp="return tabular(event,this)" readonly>  
                       	</td>       
       					<td style="width:3.5cm" class="saludo1">Forma de Pago:</td>
       					<td style="width:30%">
       						<select name="tipop" onChange="validar();" ="return tabular(event,this)">
                            	<?php
								if($_POST[tipop]=='cheque'){
									echo'<option value="cheque" selected>Cheque</option>';
								}
								else{
									echo'<option value="transferencia" selected>Transferencia</option>';
								}
								?>
				  			</select> 
                  			<input type="hidden" name="estado"  value="<?php echo $_POST[estado]?>" readonly>
                            <input type="text" name="estadoc"  value="<?php echo $estadoc; ?>" readonly> 
                            <input name="vigencia" type="hidden" value="<?php echo $_POST[vigencia]?>" size="10" onKeyUp="return tabular(event,this)" readonly>
                  			<input name="vigenciaop" type="hidden" value="<?php echo $_POST[vigenciaop]?>" size="10" onKeyUp="return tabular(event,this)" readonly> 
          				</td>        
       				</tr>
					<tr>  
                    	<td class="saludo1">No Orden Pago:</td>
	  					<td>
                        	<input name="orden" type="text" value="<?php echo $_POST[orden]?>" style="width:100%;" onKeyUp="return tabular(event,this)" onBlur="buscaop(event)" readonly >
                            <input type="hidden" value="0" name="bop">  
                     	</td>
      					<td class="saludo1">Tercero:</td>
          				<td>
                        	<input id="tercero" type="text" name="tercero" style="width:100%;" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo $_POST[tercero]?>" readonly>
           				</td>
                        <td colspan="2">
                        	<input name="ntercero" type="text" value="<?php echo $_POST[ntercero]?>" style="width:100%;" readonly>
                      	</td>
                  	</tr>
					<tr>
                    	<td class="saludo1">Concepto:</td>
                        <td colspan="5">
                        	<input name="concepto" type="text" value="<?php echo $_POST[concepto]?>" style="width:100%;" readonly>
							<input name="medio_pago" type="text" value="<?php echo $_POST[medio_pago]?>" style="width:100%;" readonly>
                       	</td>
                  	</tr>           
      				<?php 
	  				//**** if del cheques
	  				if($_POST[tipop]=='cheque'){
	  				?>    
           			<tr>
	  					<td class="saludo1">Cuenta Bancaria:</td>
	  					<td colspan="3">
	     					<select id="banco" name="banco" onKeyUp="return tabular(event,this)">
		  						<?php
								$linkbd=conectar_bd();
								$sqlr="select tesobancosctas.estado,tesobancosctas.cuenta,tesobancosctas.ncuentaban,tesobancosctas.tipo,terceros.razonsocial,tesobancosctas.tercero from tesobancosctas,terceros where tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.estado='S'  and tesobancosctas.tipo='Corriente' ";
								$res=mysql_query($sqlr,$linkbd);
								while($row =mysql_fetch_row($res)){
							 		if($row[1]==$_POST[banco]){
										echo "<option value=$row[1] SELECTED>".$row[2]." - Cuenta ".$row[3]." - ".$row[4]."</option>";
						 				$_POST[nbanco]=$row[4];
						  				$_POST[ter]=$row[5];
						 				$_POST[cb]=$row[2];
						 			}
								}	 	
								?>
            				</select>		
							<input name="cb" type="hidden" value="<?php echo $_POST[cb]?>" >
                            <input type="hidden" id="ter" name="ter" value="<?php echo $_POST[ter]?>" >
                            <input type="hidden" id="nbanco" name="nbanco" value="<?php echo $_POST[nbanco]?>">
                       	</td>
						<td class="saludo1">Cheque:</td>
                        <td>
                        	<input type="text" id="ncheque" name="ncheque" value="<?php echo $_POST[ncheque]?>" style="width:100%;" readonly>
                       	</td>
	  				</tr>
      			<?php
	     		}//cierre del if de cheques
      			?> 
       			<?php 
	  			//**** if del transferencias
	  			if($_POST[tipop]=='transferencia'){
	  			?> 
      			<tr>
	  				<td class="saludo1">Cuenta Bancaria:</td>
	  				<td colspan="3">
	     				<select id="banco" name="banco"  onChange="validar()" onKeyUp="return tabular(event,this)">
	      					<option value="">Seleccione....</option>
		  					<?php
							$linkbd=conectar_bd();
							$sqlr="select tesobancosctas.estado,tesobancosctas.cuenta,tesobancosctas.ncuentaban,tesobancosctas.tipo,terceros.razonsocial,tesobancosctas.tercero from tesobancosctas,terceros where tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.estado='S' ";
							$res=mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($res)){
						 		if($row[1]==$_POST[banco]){
									echo "<option value=$row[1] SELECTED>".$row[2]." - Cuenta ".$row[3]." - ".$row[4]."</option>";
					 				$_POST[nbanco]=$row[4];
					  				$_POST[ter]=$row[5];
					 				$_POST[cb]=$row[2];
					 			}
							}	 	
							?>
            			</select>				
						<input name="cb" type="hidden" value="<?php echo $_POST[cb]?>" >
                        <input type="hidden" id="ter" name="ter" value="<?php echo $_POST[ter]?>" >
                        <input type="hidden" id="nbanco" name="nbanco" value="<?php echo $_POST[nbanco]?>">
                   	</td>
					<td class="saludo1">No Transferencia:</td>
                    <td >
                    	<input type="text" id="ntransfe" name="ntransfe" value="<?php echo $_POST[ntransfe]?>" style="width:100%;" readonly >
                   	</td>
	  			</tr>
      			<?php
	     		}//cierre del if de cheques
      			?> 
	  			<tr>
	  				<td class="saludo1">Valor Orden:</td>
                   	<td>
                      	<input name="valororden" type="text" id="valororden" onKeyUp="return tabular(event,this)" value="<?php echo number_format($_POST[valororden],2,',','.')?>" style="width:100%; text-align:right;" readonly>
                   	</td>	  
                    <td class="saludo1">Retenciones:</td>
                    <td>
                    	<input name="retenciones" type="text" id="retenciones" onKeyUp="return tabular(event,this)" value="<?php echo number_format($_POST[retenciones],2,',','.')?>" style="width:100%; text-align:right;" readonly>
                     </td>	  
                     <td class="saludo1">Valor a Pagar:</td>
                     <td>
                       	<input name="valorpagar" type="text" id="valorpagar" onKeyUp="return tabular(event,this)" value="<?php echo number_format($_POST[valorpagar],2,',','.')?>" style="width:100%; text-align:right;" readonly> 
                        <input type="hidden" value="<?php $_POST[oculto] ?>" name="oculto">
                     </td>
              	</tr>
      			<tr>
                	<td class="saludo1" >Base:</td>
                    <td>
                    	<input type="text" id="base" name="base" value="<?php echo number_format($_POST[base],2,',','.')?>"  style="width:100%; text-align:right;" onKeyUp="return tabular(event,this)" readonly> 
                   	</td>
                    <td class="saludo1" >Iva:</td>
                    <td>
                    	<input type="text" id="iva" name="iva" value="<?php echo number_format($_POST[iva],2,',','.')?>" style="width:100%; text-align:right;" onKeyUp="return tabular(event,this)" onChange='' readonly> 
                        <input type="hidden" id="regimen" name="regimen" value="<?php echo $_POST[regimen]?>" > 
                        <input type="hidden" id="cc" name="cc" value="<?php echo $_POST[cc]?>" >
                   	</td>
               	</tr>	
      		</table>
	 	</div>
  	</div>
  	<div class="tab">
    	<input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?>>
       	<label for="tab-2">Retenciones</label>
       	<div class="content"> 
        	<table class="inicio" style="overflow:scroll">
         		<tr>
        			<td class="titulos" colspan="8">Retenciones</td>
      			</tr>
       			<tr>
                	<td></td>
                    <td class="saludo1" align="right">Total:</td>
                    <td class="saludo1" align="right">
                    	<input id="totaldes" name="totaldes" type="hidden" size="10" value="<?php echo $_POST[totaldes]?>" readonly>
                        <?php
							echo $_POST[totaldes];
						?>
                   	</td>
              	</tr>
        		<tr>
                	<td class="titulos2">Descuento</td>
                    <td class="titulos2" align="center">%</td>
                    <td class="titulos2" align="center">Valor</td>
              	</tr>
      			<?php
				
					$totaldes=0;
					if($_POST[oculto]!="2"){
					$_POST[dndescuentos]=array();
					$_POST[ddescuentos]=array();
					$_POST[dporcentajes]=array();				
					$_POST[ddesvalores]=array();
					}
						
					$sqlr="select *from tesoordenpago_retenciones where id_orden=$_POST[orden] and estado='S'";
					$resd=mysql_query($sqlr,$linkbd);
					while($rowd=mysql_fetch_row($resd)){	
						$sqlr2="SELECT *from tesoretenciones where id=".$rowd[0];	 
		 				//echo $sqlr2;
		 				$resd2=mysql_query($sqlr2,$linkbd);
		  				$rowd2=mysql_fetch_row($resd2);
		 				echo "<tr>
							<td class='saludo2'>".$rowd2[1]." - ".$rowd2[2]."</td>";
		 					echo "<td class='saludo2' align='center'>".$rowd[2]."
							</td>";
		 					echo "<td class='saludo2' align='right'>".number_format(round($rowd[3],0),2)."
							</td>
						</tr>";
						if($_POST[oculto]!="2"){
							echo "<input name='dndescuentos[]' value='".$rowd2[1]." - ".$rowd2[2]."' type='hidden'>
							<input name='ddescuentos[]' value='".$rowd2[0]."' type='hidden'>
							<input name='dporcentajes[]' value='".$rowd[2]."' type='hidden'>
							<input name='ddesvalores[]' value='".round($rowd[3],0)."' type='hidden'>";
						}

		 				$totaldes=$totaldes+($rowd[3])	;
		 			}
		 		
				?>
        		<script>
        			document.form2.totaldes.value=<?php echo $totaldes;?>;		
					calcularpago();
//       document.form2.valorretencion.value=<?php echo $totaldes;?>;
        		</script>
        	</table>
      	</table>
	</div>
</div> 
</div>   
	 
<div class="subpantallac4">
	<table class="inicio">
		<tr>
        	<td colspan="8" class="titulos">Detalle Orden de Pago</td>
       	</tr>                  
		<tr>
        	<td class="titulos2">Cuenta</td>
            <td class="titulos2">Nombre Cuenta</td>
            <td class="titulos2">Recurso</td>
            <td class="titulos2">Valor</td>
       	</tr>		
		<?php
		$_POST[totalc]=0;
		$sqlr="select *from tesoordenpago_det where id_orden=$_POST[orden] and estado='S'";
		//echo $sqlr;
		$dcuentas[]=array();
		$dncuentas[]=array();
		$resp2 = mysql_query($sqlr,$linkbd);
		$iter='saludo1a';
		$iter2='saludo2';
		while($row2=mysql_fetch_row($resp2)){
	  		//$_POST[dcuentas][]=$row2[2];
			$nombre=buscacuentapres($row2[2],2);
			//$_POST[dvalores][]=$row2[4];				
			echo "<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor; this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\">
				<td>
					<input name='dcuentas[]' value='".$row2[2]."' type='hidden'>".$row2[2]."
				</td>
				<td>
					<input name='dncuentas[]' value='".$nombre."' type='hidden'>".$nombre."
				</td>
				<td>
					<input name='drecursos[]' value='".$_POST[drecursos][$x]."' type='hidden'>".$_POST[drecursos][$x]."
				</td>
				<td align='right'>
					<input name='dvalores[]' value='".$row2[4]."' type='hidden'>".number_format($row2[4],2,',','.')."
				</td>
			</tr>";
		 	$_POST[totalc]=$_POST[totalc]+$row2[4];
		 	$_POST[totalcf]=number_format($_POST[totalc],2,".",",");
		 	$aux=$iter;
			$iter=$iter2;
			$iter2=$aux;	
		}
		$resultado = convertir($_POST[valorpagar]);
		$_POST[letras]=$resultado." PESOS M/CTE";
	    echo "<tr class='titulos2'>
			<td colspan='2'></td>
			<td>Total</td>
			<td align='right'>
				<input name='totalcf' type='hidden' value='$_POST[totalcf]'>
				<input name='totalc' type='hidden' value='$_POST[totalc]'>".number_format($_POST[totalc],2,',','.')."
			</td>
		</tr>
		<tr class='titulos2'>
			<td>Son:</td> 
			<td colspan='5'>
				<input name='letras' type='hidden' value='$_POST[letras]'>".$_POST[letras]."
			</td>
		</tr>";
		?>
        <script>
        	document.form2.valor.value=<?php echo $_POST[totalc];?>;
		//calcularpago();
        </script>
	</table>
</div>	
<?php
	//	echo "oc:	".$_POST[oculto];
	if($_POST[oculto]=='2')
	{
		$linkbd=conectar_bd();
		// echo $_POST[estado];
		$query="SELECT conta_pago FROM tesoparametros";
		$resultado=mysql_query($query,$linkbd);
		$arreglo=mysql_fetch_row($resultado);
		$opcion=$arreglo[0];
 		if($_POST[estado]=='S'){$estadof=1;$tm='201';}
		if($_POST[estado]=='N'){$estadof=0;$tm='201';}
		if(($_POST[estado]=='R') and $tipomov=='401'){$estadof=2;$tm='401';$estadoff=1;}
		if(($_POST[estado]=='R') and $tipomov=='402'){$estadof=3;$tm='402';$estadoff=1;}
		if($_POST[estado]=='C'){$estadof=4;$tm='201';}
		// echo $estado;
 		$fpfecha=split("/",$_POST[fecha]);
		$fechaf=$fpfecha[2]."-".$fpfecha[1]."-".$fpfecha[0];	

		//************CREACION DEL COMPROBANTE CONTABLE ************************

		  
	  	//*****hacer la afectacion presupuestal
		$ideg=$_POST[egreso];

		if($opcion=="2")
		{
			$elimina="delete from pptoretencionpago where idrecibo=$ideg";
			mysql_query($elimina,$linkbd);
			$reten=str_replace(".00","",$_POST[totaldes]);
			$reten=str_replace(",","",$reten);
			mysql_query($sqlr,$linkbd);
			
			if($_POST[medio_pago]!='2')
			{
				for($x=0;$x<count($_POST[ddescuentos]);$x++)
				{												 			 
					$valorp=$valorp-round($_POST[valororden]*$_POST[dporcentajes][$x]/1000,2);
					
					$sqlr="select * from tesoretenciones_det,tesoretenciones_det_presu where tesoretenciones_det.id=tesoretenciones_det_presu.id_retencion and tesoretenciones_det.codigo='".$_POST[ddescuentos][$x]."'";
					$resdes=mysql_query($sqlr);	
					$valordes=0;
					while($rowdes=mysql_fetch_assoc($resdes))
					{							  
						
						if($_POST[iva]>0 && $rowdes['tercero']==1)
						{
							$valordes=round($_POST[ddesvalores][$x]*($rowdes['porcentaje']/100),0);
						
						}
						else
						{
							$valordes=round(($_POST[ddesvalores][$x])*($rowdes['porcentaje']/100),0);
				
						}
						if($rowdes['cuentapres']!="")
						{
							$sql="insert into pptoretencionpago(cuenta,idrecibo,valor,vigencia,tipo) values ('".$rowdes['cuentapres']."',$ideg,$valordes,'$_POST[vigencia]','egreso')";
							mysql_query($sql,$linkbd); 	
						}
					}							  
				}
			}
			
		}
		
		echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado el Egreso con Exito <img src='imagenes\confirm.png'></center></td></tr></table>";		
	}//************ FIN DE IF OCULTO************
?>	
</form>
 </td></tr>  
</table>
</body>
</html>	 