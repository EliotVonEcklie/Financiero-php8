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

if (document.form2.fecha.value!='')
  {
	// if (confirm("Esta Seguro de Guardar"))
  	// {
  	// document.form2.oculto.value=2;
  	// document.form2.submit();
  	// }
	despliegamodalm('visible','4','Esta Seguro de Guardar','1');
  }
  else{
  // alert('Faltan datos para completar el registro');
  	// document.form2.fecha.focus();
  	// document.form2.fecha.select();
	despliegamodalm('visible','2','Faltan datos para completar el registro');
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
document.form2.action="cont-girarcheques-reflejar.php";
document.form2.submit();
}
else
{
	  // alert("Balance Descuadrado"+parseFloat(document.form2.maximo.value));
	}
}

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
document.form2.action="cont-girarcheques-reflejar.php";
document.form2.submit();
 }
}

function validar2()
{
//   alert("Balance Descuadrado");
document.form2.oculto.value=1;
document.form2.ncomp.value=document.form2.egreso.value;
//document.form2.agregadet.value='';
//document.form2.elimina.value='';
document.form2.action="cont-girarcheques-reflejar.php";
document.form2.submit();
}
function direccionaCuentaGastos(row){
//alert (row);
window.open("cont-editarcuentagastos.php?idcta="+row);
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
			<a href="cont-buscagirarcheques-reflejar.php" class="mgbt"> <img src="imagenes/busca.png"  alt="Buscar" border="0" title="Buscar" /></a>
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
if($_GET[consecutivo]!=""){echo "<script>document.getElementById('codrec').value=$_GET[consecutivo];</script>";}
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

	if ($_POST[codrec]!="" || $_GET[consecutivo]!=""){
		if($_POST[codrec]!=""){
			$sqlr="select * from tesoegresos where id_egreso='$_POST[codrec]' AND  tipo_mov='201'";
		}
		else{
			$sqlr="select * from tesoegresos where id_egreso='$_GET[consecutivo]' AND tipo_mov='201'";
		}
	}
	else{
		$sqlr="select * from tesoegresos WHERE tipo_mov='201' ORDER BY id_egreso DESC";
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
$sqlr="select * from tesoegresos where id_egreso=$_POST[ncomp] and tipo_mov='201'";
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
	$_POST[codingreso] = $r[15];
	$nombreCodigo = buscaingreso($r[15]);
	if($nombreCodigo!='')
	{
		$_POST[ningreso] = $nombreCodigo;
	}
	else
	{
		$_POST[ningreso] = buscaEntidadAdministradora($r[15]);
		$_POST[entidadAdministradora] = 'S';
	}
	//	  
}
ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
$_POST[fecha]=$fechaf;
$_POST[vigencia2]=$fecha[1];
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
<div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
<form name="form2" method="post" action=""> 
<input type="hidden" name="anio[]" id="anio[]" value="<?php echo $_POST[anio] ?>">
<input type="hidden" name="anioact" id="anioact" value="<?php echo $_POST[anioact] ?>">
<input type="hidden" name="bloqueo[]" id="bloqueo[]" value="<?php echo $_POST[bloqueo] ?>">
 	<?php
	if($_POST[orden]!='' ){
		//*** busca detalle cdp
		$linkbd=conectar_bd();
  		$sqlr="select *from tesoordenpago where id_orden=$_POST[orden] AND tipo_mov='201'";
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
		$_POST[iva]=$row[15];
		$_POST[vigenciadoc]=$row[3];
		$_POST[fechacxp]=$row[2];
		$_POST[totaldes]=number_format($_POST[retenciones],2);
		$_POST[valorpagar]=$_POST[valororden]-$_POST[retenciones];
		$_POST[bop]="";
		$_POST[medioDePago] = $row[19];
		if($_POST[medioDePago] == '')
			$_POST[medioDePago] = '-1';
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
                        <td style="width:7%;" class="cerrar" ><a href="cont-principal.php">Cerrar</a></td>
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
								<?php
								if($_POST[medioDePago]!='2')
								{
									?>
       						<td style="width:3.5cm" class="saludo1">Forma de Pago:</td>
       						<td style="width:30%">
       						<select name="tipop" onChange="validar();" ="return tabular(event,this)">
                            	<?php
									if($_POST[tipop]=='cheque'){
										echo'<option value="cheque" selected>Cheque</option>';
									}
									else if($_POST[tipop]=='transferencia'){
										echo'<option value="transferencia" selected>Transferencia</option>';
									}
									else{
										echo'<option value="caja" selected>Efectivo</option>';
									}
									?>
				  				</select> 
									<?php 
								}
								else
								{
									$_POST[tipop]='';
									//echo "<td style='width:2.8cm;'></td><td style='width:14%'></td>";
									?>
									<td class="saludo1" style="width:10%">Medio de Pago:</td>
									<td style="width:50%;">
										<input type="hidden" id="codingreso" name="codingreso" value="<?php echo $_POST[codingreso]?>"  onKeyUp="return tabular(event,this)" onBlur="buscaing(event)" style="width:100%;" readonly>
										<input type="text" name="ningreso" id="ningreso" value="<?php echo $_POST[codingreso]." - ".$_POST[ningreso]?>" style="width:100%;" readonly>
										<input type="hidden" name="entidadAdministradora" id="entidadAdministradora" value="<?php echo $_POST[entidadAdministradora]?>" > 

									</td>
									<?php 
								}
								?>
                  	<input type="hidden" name="estado"  value="<?php echo $_POST[estado]?>" readonly>
									<?php 
							
								if($_POST[estado]=="S"){
									$valuees="ACTIVO";
									$stylest="width:80%; background-color:#0CD02A; color:white; text-align:center;";
								}else if($_POST[estado]=="N"){
									$valuees="ANULADO";
									$stylest="width:80%; background-color:#FF0000; color:white; text-align:center;";
								}else if($_POST[estadoc]=="P"){
									$valuees="PAGO";
									$stylest="width:80%; background-color:#0404B4; color:white; text-align:center;";
								}else if($_POST[estado]=="R"){
									$valuees="REVERSADO";
									$stylest="width:80%; background-color:#FF0000; color:white; text-align:center;";
								}
							?>
                            
                            <input name="vigencia" type="hidden" value="<?php echo $_POST[vigencia]?>" size="10" onKeyUp="return tabular(event,this)" readonly>
                  			<input name="vigenciaop" type="hidden" value="<?php echo $_POST[vigenciaop]?>" size="10" onKeyUp="return tabular(event,this)" readonly> 
          				</td>        
       				</tr>
					<tr>  
                    	<td class="saludo1">No Orden Pago:</td>
	  					<td>
                        	<input name="orden" type="text" value="<?php echo $_POST[orden]?>" style="width:100%;" onKeyUp="return tabular(event,this)" readonly >
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
				 if($_POST[tipop]=='caja')//**** if del transferencias
	    					{
	  					?>
      							<tr>
	  								<td class="saludo1">Cuenta Caja:</td>
	  								<td >
	     								<select id="banco" name="banco"  onChange="validar()" onKeyUp="return tabular(event,this)">
	      									<option value="">Seleccione....</option>
		  									<?php
											  	$sqlr="select cuentacaja from tesoparametros";
												$res=mysql_query($sqlr,$linkbd);
												while ($row =mysql_fetch_row($res)) 
												{
													$_POST[nbanco] = buscacuenta($row[0]);
													echo "";
													$i=$row[0];
					 								if($i==$_POST[banco])
			 										{
														echo "<option value='$row[0]' SELECTED>$row[0] - Cuenta $_POST[nbanco]</option>";
						 								
													}
					  								else {echo "<option value='$row[0]'>$row[0] - Cuenta $_POST[nbanco]</option>";}
												}
											?>
            							</select>
                                  	</td>
                                    <td colspan="2"><input type="text" id="nbanco" name="nbanco" value="<?php echo $_POST[nbanco]?>" style="width:100%" readonly></td>
	  							</tr>
      					<?php
	     					}//cierre del if de efectivo
      			?> 
	  			<tr>
	  				<td class="saludo1">Valor Orden:</td>
                   	<td>
				 		<input name="valor" type="hidden" value="<?php echo $_POST[valororden]?>">
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
										<td><input type='text' name='estado' id='estado' value='<?php echo $valuees ?>' style='<?php echo $stylest ?>' readonly /></td>
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
				if($_POST[oculto]!='2'){
					$totaldes=0;
					$_POST[dndescuentos]=array();
					$_POST[ddescuentos]=array();
					$_POST[dporcentajes]=array();				
					$_POST[ddesvalores]=array();
					$_POST[codigos]=array();

					$gdndescuentos=array();
					$gddescuentos=array();
					$gdporcentajes=array();				
					$gddesvalores=array();	
					$cr=0;
					$sqlr="select *from tesoordenpago_retenciones where id_orden=$_POST[orden] and estado='S'";
					
					$resd=mysql_query($sqlr,$linkbd);
					while($rowd=mysql_fetch_row($resd)){	
						$sqlr2="SELECT *from tesoretenciones where id=".$rowd[0];	 
		 				//echo $sqlr2;
		 				$resd2=mysql_query($sqlr2,$linkbd);
		  				$rowd2=mysql_fetch_row($resd2);
						$gdndescuentos[$cr]="$rowd2[1] - $rowd2[2]";
						$gddescuentos[$cr]=$rowd2[1];
						$gdporcentajes[$cr]=$rowd[2];				
						$gddesvalores[$cr]=round($rowd[3],0);	
		 				echo "<tr>
							<td class='saludo2'>
								<input name='dndescuentos[]' value='".$rowd2[1]." - ".$rowd2[2]."' type='hidden'>
								<input name='codigos[]' value='".$rowd2[1]."' type='hidden'>
								<input name='ddescuentos[]' value='".$rowd[0]."' type='hidden'>".$rowd2[1]." - ".$rowd2[2]."
							</td>";
		 					echo "<td class='saludo2' align='center'>
								<input name='dporcentajes[]' value='".$rowd[2]."' type='hidden'>".$rowd[2]."
							</td>";
		 					echo "<td class='saludo2' align='right'>
		 						<input name='ddesvalores[]' value='".$rowd[3]."' type='hidden'>".number_format(round($rowd[3],0),2)."
							</td>
						</tr>";
// 		 echo "<td class='saludo2'><input name='ddesvalores[]' value='".$_POST[ddesvalores][$x]."' type='text' size='15'></td><td class='saludo2'><a href='#' onclick='eliminard($x)'><img src='imagenes/del.png'></a></td></tr>";
		 				$totaldes=$totaldes+($rowd[3])	;
						$cr=$cr+1;
		 			}
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
		
		$sqlr="select *from tesoordenpago_det where id_orden=$_POST[orden]  AND tipo_mov='201'";
		//echo $sqlr;
		$dcuentas[]=array();
		$dncuentas[]=array();
		$resp2 = mysql_query($sqlr,$linkbd);
		$iter='saludo1a';
		$iter2='saludo2';
		while($row2=mysql_fetch_row($resp2)){
	  		//$_POST[dcuentas][]=$row2[2];
			$nombre=buscacuentaprescxp($row2[2],$_POST[vigenciaop]);
			//$_POST[dvalores][]=$row2[4];				
			echo "<tr class='$iter' style=\"cursor: hand\" ondblclick=\"direccionaCuentaGastos('".$row2[2]."')\" onMouseOver=\"anterior=this.style.backgroundColor; this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\">
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

	function generaRetenciones($orden,$valor){
		$linkbd=conectar_bd();
		$arreglocuenta=Array();
		$total=0;
		for($x=0;$x<count($_POST[dndescuentos]);$x++)
		{
			$dd=$_POST[ddescuentos][$x];
			$sqlr="select * from tesoretenciones_det,tesoretenciones where tesoretenciones_det.codigo=tesoretenciones.id and tesoretenciones.id='$dd'";
			$resdes=mysql_query($sqlr,$linkbd);
			$valordes=0;
			while($rowdes=mysql_fetch_row($resdes))
			{
				$val2=$rowdes[7];
				$val3=$_POST[ddesvalores][$x];
				$valordes=round(($valor/$_POST[valor])*($val2/100)*$val3,0);
				$total+=$valordes;
			}
			//echo $arreglocuenta[$_POST[dcuentas][$j]]." hola <br>";
		}
		return $total;
	}
	
if($_POST[oculto]=='2')
{
	$linkbd=conectar_bd();
 	$query="SELECT conta_pago FROM tesoparametros";
	$resultado=mysql_query($query,$linkbd);
	$arreglo=mysql_fetch_row($resultado);
	$opcion=$arreglo[0];
	$anioact=split("/", $_POST[fecha]);
			$_POST[anioact]=$anioact[2];
			for($x=0;$x<count($_POST[anio]);$x++)
			{
				if($_POST[anioact]==$_POST[anio][$x])
				{
					if($_POST[bloqueo][$x]=='S')
					{
						$bloquear="S";
					}else
					{
						$bloquear="N";
					}
				}
			}
		if($bloquear=="N"){
			ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
			$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
			$vigegreso=$fecha[3];
			//$fechaf=$_POST[fechacxp];
			//************CREACION DEL COMPROBANTE CONTABLE ************************

			$sqlr="select count(*) from tesoegresos where id_egreso=$_POST[egreso] and estado ='S'";
				$res=mysql_query($sqlr,$linkbd);
				//echo $sqlr;
			$row=mysql_fetch_row($res);
		  //***********crear el contabilidad
		  $ideg=$_POST[egreso];
		
		  $sqlr="delete from comprobante_cab where numerotipo=$ideg and tipo_comp=6";
		   mysql_query($sqlr,$linkbd);
		  $sqlr="delete from comprobante_det where id_comp='6 $ideg' ";
		   mysql_query($sqlr,$linkbd);
		   if ($_POST[estado]=='N' || $_POST[estado]=='R')
		   $estado=0;
		   else
		   $estado=1;
		  	 $sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($ideg,6,'$fechaf','$_POST[concepto]',0,$_POST[valororden],$_POST[valororden],0,'$estado')";
			     mysql_query($sqlr,$linkbd);			 
				$idcomp=mysql_insert_id();					 
			  $totaldes=0;
			  $numrub=0;
			  $totpago=0;
		  for ($x=0;$x<count($_POST[dcuentas]);$x++)
		   {
			 if ($_POST[dvalores][$x] >0)
			 {
			  $numrub+=1;
			  $totpago+=$_POST[dvalores][$x];
			 }
			}
		       $totaldes=array_sum($_POST[ddesvalores]);
		       $sqlr="update tesoegresos set id_comp=$idcomp where id_egreso=$ideg ";			 			 
			   mysql_query($sqlr,$linkbd);
			   $sqlr="select cc,vigencia FROM tesoordenpago WHERE id_orden=$_POST[orden] and tipo_mov='201'  ";
			   $result=mysql_query($sqlr,$linkbd);
			   $centro=mysql_fetch_array($result);
			   $sqlr="select *from tesoordenpago_det where id_orden=$_POST[orden] and tipo_mov='201' ";
			   //echo $sqlr;
				$resp2 = mysql_query($sqlr,$linkbd);
				while($row2=mysql_fetch_row($resp2))
				{
					$sqlr="select codconcepago from pptocuentas where cuenta='$row2[2]' and (vigencia='$centro[1]' or vigenciaf='$centro[1]')";
					$resp = mysql_query($sqlr,$linkbd);
					while($rowp=mysql_fetch_row($resp))
					{
						
						//echo $row2[4]."<br>	";
						$valneto=$row2[4];
						//echo $valneto."<br>	";
						$orden=$_POST[orden];
						if($opcion=="1"){
							$valneto-=generaRetenciones($orden,$row2[4]);
							//$valneto = $_POST[valorpagar];
						}
						$sq="select fechainicial from conceptoscontables_det where codigo='$rowp[0]' and modulo='3' and cc='$row2[3]' and tipo='P' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
						
						$re=mysql_query($sq,$linkbd);
						while($ro=mysql_fetch_assoc($re))
						{
							$_POST[fechacausa]=$ro["fechainicial"];
						}
						$sqlr="select * from conceptoscontables_det where codigo='$rowp[0]' and modulo='3' and cc='$row2[3]' and tipo='P' and fechainicial='".$_POST[fechacausa]."'";
						//echo $sqlr." --> ".$valneto."<br>";
						$resc = mysql_query($sqlr,$linkbd);
						while($rowc=mysql_fetch_row($resc))
						{
							if($rowc[3]=='N' && $valneto > 0)
							{
								$ncppto=buscacuentaprescxp($row2[2],$_POST[vigenciaop]);
								$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito, estado, vigencia) values ('6 $ideg','$rowc[4]','$_POST[tercero]','$row2[3]','Pago $ncppto','','$valneto',0,'1' ,'$vigusu')";
								//echo $sqlr."<br>";
								mysql_query($sqlr,$linkbd);
							}
							if($rowc[3]=='B')
							{
								$valopb=$row2[4];
								if($opcion=="1"){
								$valopb=$valneto;
								}
								//***buscar retenciones
								$cc=$_POST[cc];
							  if($opcion=="2"){
								 if($row2[4]>0)
								   {
									//echo count($_POST[ddesvalores])."hola<br>";
									for($x=0;$x<count($_POST[ddesvalores]);$x++)
									{
										$sqlr="select * from tesoretenciones,tesoretenciones_det where tesoretenciones_det.codigo=tesoretenciones.id and tesoretenciones.codigo='".$_POST[codigos][$x]."'";
										$resdes=mysql_query($sqlr);
										while($rowdes=mysql_fetch_assoc($resdes))
										{
											$valordes=0;
											$val2=0;
											$val2=$rowdes['porcentaje'];
											if($_POST[iva]>0 && $rowdes['terceros']==1)
											{
												$valordes=round(($row2[4]/$_POST[valororden])*($val2/100)*$_POST[ddesvalores][$x],0);
												//$valordes=round(($rw['base']*$rowdes['retencion']/100)*($rowdes['porcentaje']/100),0);
											}
											else
											{
												$valordes=round(($row2[4]/$_POST[valororden])*($val2/100)*$_POST[ddesvalores][$x],0);	
											}	
											$valopb-= $valordes;

											$codigoRetencion=0;
											$rest=0;
											
											$codigoCausa=0;
											if ($_POST[medioDePago]!='1')
											{
												//concepto contable //********************************************* */
												$rest=substr($rowdes['tipoconce'],0,2);
												$sq="select fechainicial from conceptoscontables_det where codigo='".$rowdes['conceptocausa']."' and modulo='".$rowdes['modulo']."' and tipo='$rest' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
												$re=mysql_query($sq,$linkbd);
												while($ro=mysql_fetch_assoc($re))
												{
													$_POST[fechacausa]=$ro["fechainicial"];
												}
												$sqlr="select * from conceptoscontables_det where codigo='".$rowdes['conceptocausa']."' and modulo='".$rowdes['modulo']."' and cc='".$cc."' and tipo='$rest' and fechainicial='".$_POST[fechacausa]."'";	
												//echo $sqlr." hoal <br>";
												$rst=mysql_query($sqlr,$linkbd);
												$row1=mysql_fetch_assoc($rst);
												if($row1['cuenta']!='' && $valordes>0)
												{
													//echo "Hola 5  ";
													$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito, valcredito, estado, vigencia) values ('6 $ideg','".$row1['cuenta']."','".$_POST[tercero]."' ,'".$cc."' , 'Descuento ".$gdndescuentos[$x]."','',".$valordes.",0,'1' ,'".$vigegreso."')";
													mysql_query($sqlr,$linkbd);
												}

												//concepto contable //********************************************* */
												$rest=substr($rowdes['tipoconce'],-2);
												$sq="select fechainicial from conceptoscontables_det where codigo='".$rowdes['conceptoingreso']."' and modulo='".$rowdes['modulo']."' and tipo='$rest' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
												$re=mysql_query($sq,$linkbd);
												while($ro=mysql_fetch_assoc($re))
												{
													$_POST[fechacausa]=$ro["fechainicial"];
												}
												$sqlr="select * from conceptoscontables_det where codigo='".$rowdes['conceptoingreso']."' and modulo='".$rowdes['modulo']."' and cc='".$cc."' and tipo='$rest' and fechainicial='".$_POST[fechacausa]."'";	
												//echo $sqlr." hoal <br>";
												$rst=mysql_query($sqlr,$linkbd);
												$row1=mysql_fetch_assoc($rst);
												if($row1['cuenta']!='' && $valordes>0)
												{
													//echo "Hola 5  ";
													$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito, valcredito, estado, vigencia) values ('6 $ideg','".$row1['cuenta']."','".$_POST[tercero]."' ,'".$cc."' , 'Descuento ".$gdndescuentos[$x]."','',0,".$valordes.",'1' ,'".$vigegreso."')";
													mysql_query($sqlr,$linkbd);
												}

												//concepto contable //********************************************* */
												$rest="SR";
												$sq="select fechainicial from conceptoscontables_det where codigo='".$rowdes['conceptosgr']."' and modulo='".$rowdes['modulo']."' and tipo='$rest' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
												$re=mysql_query($sq,$linkbd);
												while($ro=mysql_fetch_assoc($re))
												{
													$_POST[fechacausa]=$ro["fechainicial"];
												}
												$sqlr="select * from conceptoscontables_det where codigo='".$rowdes['conceptosgr']."' and modulo='".$rowdes['modulo']."' and cc='".$cc."' and tipo='$rest' and fechainicial='".$_POST[fechacausa]."'";	
												//echo $sqlr." hoal <br>";
												$rst=mysql_query($sqlr,$linkbd);
												$row1=mysql_fetch_assoc($rst);
												if($row1['cuenta']!='' && $valordes>0)
												{
													//echo "Hola 5  ";
													$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito, valcredito, estado, vigencia) values ('6 $ideg','".$row1['cuenta']."','".$_POST[tercero]."' ,'".$cc."' , 'Descuento ".$gdndescuentos[$x]."','',0,".$valordes.",'1' ,'".$vigegreso."')";
													mysql_query($sqlr,$linkbd);
												}

												

												continue;
											}
											else
											{
												$codigoIngreso = $rowdes['conceptoingreso'];
												if($codigoIngreso != "-1")
												{
													$codigoRetencion = $rowdes['conceptoingreso'];
													$rest=substr($rowdes['tipoconce'],-2);
													$val2=$rowdes['porcentaje'];
												}
											}
											
											//concepto contable //********************************************* */
											$sq="select fechainicial from conceptoscontables_det where codigo='$codigoRetencion' and modulo='".$rowdes['modulo']."' and cc='$cc' and tipo='$rest' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
											$re=mysql_query($sq,$linkbd);
											while($ro=mysql_fetch_assoc($re))
											{
												$_POST[fechacausa]=$ro["fechainicial"];
											}
											$sqlr="select * from conceptoscontables_det where codigo='$codigoRetencion' and modulo='".$rowdes['modulo']."' and cc='$cc' and tipo='$rest' and fechainicial='".$_POST[fechacausa]."'";
											//echo $sqlr."<br>";
											$rst=mysql_query($sqlr,$linkbd);
											$row1=mysql_fetch_assoc($rst);
											//TERMINA BUSQUEDA CUENTA CONTABLE////////////////////////
											if($row1['cuenta']!='' && $valordes>0)
											{
												$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito, valcredito, estado, vigencia) values ('6 $ideg','".$row1['cuenta']."','".$_POST[tercero]."' ,'".$row2[3]."' , 'Descuento ".$rowdes['nombre']."','',0,".$valordes.",'1' ,'".$_POST[vigencia2]."')";
												mysql_query($sqlr,$linkbd);
											}
											
											$realizaCausacion = 0;
											
											if($rowdes['terceros']!=1 || $rowdes['tipo']=='C')
											{
												$realizaCausacion = 1;

												if($rowdes['destino']!='M' && $rowdes['tipo']=='C')
												{
													$realizaCausacion = 0;
												}
											}
											if($rowdes['conceptocausa']!='-1' && $_POST[medioDePago]=='1' && $realizaCausacion == 1)
											{
												//concepto contable //********************************************* */
												$rest=substr($rowdes['tipoconce'],0,2);
												$sq="select fechainicial from conceptoscontables_det where codigo='".$rowdes['conceptocausa']."' and modulo='".$rowdes['modulo']."' and tipo='$rest' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
												$re=mysql_query($sq,$linkbd);
												while($ro=mysql_fetch_assoc($re))
												{
													$_POST[fechacausa]=$ro["fechainicial"];
												}
												$sqlr="select * from conceptoscontables_det where codigo='".$rowdes['conceptocausa']."' and modulo='".$rowdes['modulo']."' and cc='$cc' and tipo='$rest' and fechainicial='".$_POST[fechacausa]."'";	
												//echo $sqlr." hoal <br>";
												$rst=mysql_query($sqlr,$linkbd);
												$row1=mysql_fetch_assoc($rst);
												if($row1['cuenta']!='' && $valordes>0)
												{
													$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito, valcredito, estado, vigencia) values ('6 $ideg','".$row1['cuenta']."','".$_POST[tercero]."' ,'".$row2[3]."' , 'Descuento ".$rowdes['nombre']."','',".$valordes.",0,'1' ,'".$_POST[vigencia2]."')";
												
													mysql_query($sqlr,$linkbd);
													$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito, valcredito, estado, vigencia) values ('6 $ideg','".$row1['cuenta']."','".$_POST[tercero]."' ,'".$row2[3]."' , 'Descuento ".$rowdes['nombre']."','',0,".$valordes.",'1' ,	'".$_POST[vigencia2]."')";
													mysql_query($sqlr,$linkbd);
												}
											}
										}	// ** FIn while				  
									}	//**FIn for																 
								 }	  // ** Fin if
								}  //** FIn if
								
								//INCLUYE EL CHEQUE
								if($_POST[codingreso]!='')
								{
									if($_POST[entidadAdministradora] == 'S')
									{
										$sqlri = "SELECT * FROM tesomediodepago WHERE estado='S' AND id = '$_POST[codingreso]'";
										$resi=mysql_query($sqlri,$linkbd);
										$rowi=mysql_fetch_row($resi);
										if($valopb>0)
										{
											$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) values ('6 $ideg','".$rowi[2]."','".$_POST[tercero]."' ,'".$row2[3]."' , 'Pago ".$ncppto."','$_POST[cheque]  $_POST[ntransfe]',0,".$valopb.",'1' ,'".$_POST[vigencia2]."')";								
											mysql_query($sqlr,$linkbd);
										}
										
									}
									else
									{
										$sqlri="Select * from tesoingresos_det where codigo='".$_POST[codingreso]."' and vigencia='$vigegreso'";
										$resi=mysql_query($sqlri,$linkbd);
										while($rowi=mysql_fetch_row($resi))
										{
											//**** busqueda concepto contable*****
											$sq="select fechainicial from conceptoscontables_det where codigo='$rowi[2]' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
											$re=mysql_query($sq,$linkbd);
											while($ro=mysql_fetch_assoc($re))
											{
												$_POST[fechacausa]=$ro["fechainicial"];
											} 
											$sqlrc12="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C' and fechainicial='".$_POST[fechacausa]."'";
											$resc12=mysql_query($sqlrc12,$linkbd);	  
											while($rowc12=mysql_fetch_row($resc12))
											{
												if($cc==$rowc12[5])
												{
													if($rowc12[3]=='N')
													{
														if($rowc12[6]=='S')
														{
															if($row2[4]>0)
															{
																$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) values ('6 $ideg','".$rowc12[4]."','".$_POST[tercero]."' ,'".$row2[3]."' , 'Ingreso ".$ncppto."','$_POST[cheque]  $_POST[ntransfe]',0,".$valopb.",'1' ,'".$_POST[vigencia2]."')";
																mysql_query($sqlr,$linkbd);
															}
														}  
													}			   
												}
											}
										}
									}
								}
								else
								{
									if($row2[4]>0)
									{
										$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) values ('6 $ideg','".$_POST[banco]."','".$_POST[tercero]."' ,'".$row2[3]."' , 'Pago Banco ".$ncppto."','$_POST[cheque]  $_POST[ntransfe]',0,".$valopb.",'1' ,'".$_POST[vigencia2]."')";					
										mysql_query($sqlr,$linkbd);
									}
								}
							}   // FIN B
						} //FIN WHILE
					}  //FIN WHILE
				}  // FIN WHILE

	  
				$ideg=$_POST[egreso];
				  echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado el Egreso con Exito <img src='imagenes\confirm.png'></center></td></tr></table>";		
				  ?>
				<script>
					
					despliegamodalm('visible','1',"Se ha almacenado el Egreso con Exito");
				</script>
				<?php
		}
		else
			{
				?>
				<script>
					
					despliegamodalm('visible','2',"No se puede reflejar por Cierre de Año");
				</script>
				<?php

			}
}//************ FIN DE IF OCULTO************
?>	
</form>
 </td></tr>  
</table>
</body>
</html>	 