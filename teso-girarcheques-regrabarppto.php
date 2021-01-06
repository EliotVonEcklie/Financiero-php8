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
<title>:: SPID - Tesoreria</title>
<script>
//************* ver reporte ************
//***************************************
function verep(idfac)
{
  document.form1.oculto.value=idfac;
  document.form1.submit();
  }
</script>
<script>
//************* genera reporte ************
//***************************************
function genrep(idfac)
{
  document.form2.oculto.value=idfac;
  document.form2.submit();
  }
</script>
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
function buscaop(e)
 {
if (document.form2.orden.value!="")
{
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
	//alert("dddadadad");
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
document.form2.action="teso-girarcheques-regrabarppto.php";
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
document.form2.action="teso-girarcheques-regrabarppto.php";
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
document.form2.action="teso-girarcheques-regrabarppto.php";
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
	<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
	<tr><?php menu_desplegable("teso");?></tr>
<tr>
  <td colspan="3" class="cinta"><a href="#" ><img src="imagenes/add2.png" alt="Nuevo"  border="0" /></a> <a href="#"  onClick="guardar()"><img src="imagenes/guarda.png"  alt="Guardar" /></a><a href="teso-buscagirarcheques-rg.php"> <img src="imagenes/busca.png"  alt="Buscar" border="0" /></a> <a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" alt="nueva ventana"></a>  <a href="#" onClick="pdf()"> <img src="imagenes/print.png"  alt="Imprimir" /></a> <a href="teso-actualizardocs.php"><img src="imagenes/iratras.png" alt="nueva ventana"></a></td>
</tr>		  
</table>
<tr><td colspan="3" class="tablaprin" align="center"> 
<?php
$vigencia=date(Y);
 $vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
		$linkbd=conectar_bd();
	$sqlr="select *from cuentapagar where estado='S' ";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
	{
	 $_POST[cuentapagar]=$row[1];
	}

 ?>	
<?php
	  //*********** cuenta origen va al credito y la destino al debito
if(!$_POST[oculto])
{
		$linkbd=conectar_bd();
	$sqlr="select *from cuentapagar where estado='S' ";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
	{
	 $_POST[cuentapagar]=$row[1];
	}
$sqlr="select * from tesoegresos ORDER BY id_egreso DESC";
$res=mysql_query($sqlr,$linkbd);
//echo $sqlr;
	$r=mysql_fetch_row($res);
	 $_POST[maximo]=$r[0];
	 $_POST[ncomp]=$_POST[maximo];
	$_POST[egreso]=$_POST[ncomp];
		$check1="checked";
		if($_GET[idegre]!="")
		{
	 	 $_POST[egreso]=$_GET[idegre];
		  $_POST[ncomp]=$_GET[idegre];
		}
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
		while($r=mysql_fetch_row($res))
		 {
		  $consec=$r[0];	  
		  $_POST[orden]=$r[2];
		  $_POST[tipop]=$r[14];
		  $_POST[banco]=$r[9];
		  $_POST[estado]=$r[13];
		  $_POST[vigencia]=substr($r[3],0,4);
		  		   if ($_POST[estado]=='N')
		   $estadoc="ANULADO";
		   else
		   $estadoc="ACTIVO";

		  $_POST[ncheque]=$r[10];		  		  
			$_POST[cb]=$r[12];		  
		  $_POST[transferencia]=$r[12];
			$_POST[fecha]=$r[3];		  		  		  
	 	}
		ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
		$_POST[fecha]=$fechaf;
	 	$_POST[egreso]=$consec;		 

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

 <form name="form2" method="post" action=""> 
 <?php
				 if($_POST[orden]!='' )
				 {
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
				
			  }
			 else
			 {
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
	   <div class="content">
	   <table class="inicio" align="center" >
       
	   <tr>
	     <td colspan="6" class="titulos">Comprobante de Egreso</td><td width="74" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td></tr>
       <tr><td class="saludo1">No Egreso:</td><td><a href="#" onClick="atrasc()"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a><input name="cuentapagar" type="hidden" value="<?php echo $_POST[cuentapagar]?>" > <input name="egreso" type="text" value="<?php echo $_POST[egreso]?>" size="10" onKeyUp="return tabular(event,this)" onBlur="validar2()"  > <input name="ncomp" type="hidden" value="<?php echo $_POST[ncomp]?>"><a href="#" onClick="adelante()"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> <input type="hidden" value="a" name="atras" ><input type="hidden" value="s" name="siguiente" ><input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo"></td>
       	  <td class="saludo1">Fecha: </td>
        <td ><input id="fc_1198971545" name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10" size="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)">  <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>        </td>       
       <td class="saludo1">Forma de Pago:</td>
       <td >
       <select name="tipop" onChange="validar();" ="return tabular(event,this)">
       <option value="">Seleccione ...</option>
				  <option value="cheque" <?php if($_POST[tipop]=='cheque') echo "SELECTED"?>>Cheque</option>
  				  <option value="transferencia" <?php if($_POST[tipop]=='transferencia') echo "SELECTED"?>>Transferencia</option>
				  </select> <input type="hidden" name="estado"  value="<?php echo $_POST[estado]?>" readonly><input type="text" name="estadoc"  value="<?php echo $estadoc; ?>" readonly> <input name="vigencia" type="text" value="<?php echo $_POST[vigencia]?>" maxlength="2" size="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly>
                  <input name="vigenciaop" type="text" value="<?php echo $_POST[vigenciaop]?>" maxlength="2" size="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly> 
          </td>        
       </tr>
<tr>  <td class="saludo1">No Orden Pago:</td>
	  <td ><input name="orden" type="text" value="<?php echo $_POST[orden]?>" size="10" onKeyUp="return tabular(event,this)" onBlur="buscaop(event)" readonly ><input type="hidden" value="0" name="bop">  </td>
      <td width="126" class="saludo1">Tercero:</td>
          <td width="144"  ><input id="tercero" type="text" name="tercero" size="20" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo $_POST[tercero]?>" readonly>
           </td><td colspan="2"><input name="ntercero" type="text" value="<?php echo $_POST[ntercero]?>" size="70" readonly></td></tr>
<tr><td class="saludo1">Concepto:</td><td colspan="3"><input name="concepto" type="text" value="<?php echo $_POST[concepto]?>" size="90" readonly></td></tr>           
      <?php 
	  //**** if del cheques
	  if($_POST[tipop]=='cheque')
	    {
	  ?>    
           <tr>
	  <td class="saludo1">Cuenta Bancaria:</td>
	  <td >
	     <select id="banco" name="banco"  onChange="validar()" onKeyUp="return tabular(event,this)">
	      <option value="">Seleccione....</option>
		  <?php
	$linkbd=conectar_bd();
	$sqlr="select tesobancosctas.estado,tesobancosctas.cuenta,tesobancosctas.ncuentaban,tesobancosctas.tipo,terceros.razonsocial,tesobancosctas.tercero from tesobancosctas,terceros where tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.estado='S'  and tesobancosctas.tipo='Corriente' ";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
				    {
					echo "<option value=$row[1] ";
					$i=$row[1];
					 if($i==$_POST[banco])
			 			{
						 echo "SELECTED";
						 $_POST[nbanco]=$row[4];
						  $_POST[ter]=$row[5];
						 $_POST[cb]=$row[2];
						 }
					  echo ">".$row[2]." - Cuenta ".$row[3]."</option>";	 	 
					}	 	
	?>
            </select>		
		<input name="cb" type="hidden" value="<?php echo $_POST[cb]?>" ><input type="hidden" id="ter" name="ter" value="<?php echo $_POST[ter]?>" ></td><td colspan="2"><input type="text" id="nbanco" name="nbanco" value="<?php echo $_POST[nbanco]?>" size="50" readonly></td>
			<td  class="saludo1">Cheque:</td><td  ><input type="text" id="ncheque" name="ncheque" value="<?php echo $_POST[ncheque]?>" size="20" readonly></td>
	  </tr>
      <?php
	     }//cierre del if de cheques
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
	      <option value="">Seleccione....</option>
		  <?php
	$linkbd=conectar_bd();
	$sqlr="select tesobancosctas.estado,tesobancosctas.cuenta,tesobancosctas.ncuentaban,tesobancosctas.tipo,terceros.razonsocial,tesobancosctas.tercero from tesobancosctas,terceros where tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.estado='S' ";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
				    {
					echo "<option value=$row[1] ";
					$i=$row[1];
					 if($i==$_POST[banco])
			 			{
						 echo "SELECTED";
						 $_POST[nbanco]=$row[4];
						  $_POST[ter]=$row[5];
						 $_POST[cb]=$row[2];
						 }
					  echo ">".$row[2]." - Cuenta ".$row[3]."</option>";	 	 
					}	 	
	?>
            </select>				
		<input name="cb" type="hidden" value="<?php echo $_POST[cb]?>" ><input type="hidden" id="ter" name="ter" value="<?php echo $_POST[ter]?>" ></td><td colspan="2"><input type="text" id="nbanco" name="nbanco" value="<?php echo $_POST[nbanco]?>" size="50" readonly></td>
			<td class="saludo1">No Transferencia:</td><td ><input type="text" id="ntransfe" name="ntransfe" value="<?php echo $_POST[ntransfe]?>" size="20" ></td>
	  </tr>
      <?php
	     }//cierre del if de cheques
      ?> 
	  <tr>
	  <td class="saludo1">Valor Orden:</td><td><input name="valororden" type="text" id="valororden" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[valororden]?>" size="20" readonly></td>	  <td class="saludo1">Retenciones:</td><td><input name="retenciones" type="text" id="retenciones" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[retenciones]?>" size="20" readonly></td>	  <td class="saludo1">Valor a Pagar:</td><td><input name="valorpagar" type="text" id="valorpagar" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[valorpagar]?>" size="20" readonly> <input type="hidden" value="<?php $_POST[oculto] ?>" name="oculto"></td></tr>
      <tr><td class="saludo1" >Base:</td><td><input type="text" id="base" name="base" value="<?php echo $_POST[base]?>" size="15" onKeyUp="return tabular(event,this)" onChange='' readonly> </td><td class="saludo1" >Iva:</td><td><input type="text" id="iva" name="iva" value="<?php echo $_POST[iva]?>" size="15" onKeyUp="return tabular(event,this)" onChange='' readonly> <input type="hidden" id="regimen" name="regimen" value="<?php echo $_POST[regimen]?>" > <input type="hidden" id="cc" name="cc" value="<?php echo $_POST[cc]?>" ></td></tr>	
      </table>
	 </div>
     </div>
     <div class="tab">
       <input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?>>
       <label for="tab-2">Retenciones</label>
       <div class="content"> 
         <table class="inicio" style="overflow:scroll">
         <tr >
        <td class="titulos" colspan="8">Retenciones</td>
      </tr>
       <tr><td></td><td class="saludo1">Total:</td><td><input id="totaldes" name="totaldes" type="text" size="10" value="<?php echo $_POST[totaldes]?>" readonly></td></tr>
        <tr><td class="titulos2">Descuento</td><td class="titulos2">%</td><td class="titulos2">Valor</td></tr>
      	<?php
		if ($_POST[oculto]!='2')
		 {
		$totaldes=0;
		$_POST[dndescuentos]=array();
		$_POST[ddescuentos]=array();
		$_POST[dporcentajes]=array();				
		$_POST[ddesvalores]=array();		
		$sqlr="select *from tesoordenpago_retenciones where id_orden=$_POST[orden] and estado='S'";
		//echo $sqlr;
		$resd=mysql_query($sqlr,$linkbd);
		while($rowd=mysql_fetch_row($resd))
		 {	
		 $sqlr2="SELECT *from tesoretenciones where id=".$rowd[0];	 
		 //echo $sqlr2;
		 $resd2=mysql_query($sqlr2,$linkbd);
		  $rowd2=mysql_fetch_row($resd2);
		 echo "<tr><td class='saludo2'><input name='dndescuentos[]' value='".$rowd2[1]." - ".$rowd2[2]."' type='text' size='100' readonly><input name='ddescuentos[]' value='".$rowd2[1]."' type='hidden'></td>";
		 echo "<td class='saludo2'><input name='dporcentajes[]' value='".$rowd[2]."' type='text' size='5' readonly></td>";
		 echo "<td class='saludo2'><input name='ddesvalores[]' value='".round($rowd[3],0)."' type='text' size='15' readonly></td></tr>";
// 		 echo "<td class='saludo2'><input name='ddesvalores[]' value='".$_POST[ddesvalores][$x]."' type='text' size='15'></td><td class='saludo2'><a href='#' onclick='eliminard($x)'><img src='imagenes/del.png'></a></td></tr>";
		 $totaldes=$totaldes+($rowd[3])	;
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
	   <tr><td colspan="8" class="titulos">Detalle Orden de Pago</td></tr>                  
		<tr><td class="titulos2">Cuenta</td><td class="titulos2">Nombre Cuenta</td><td class="titulos2">Recurso</td><td class="titulos2">Valor</td></tr>		
		  <?php
		 $_POST[totalc]=0;
		  $sqlr="select *from tesoordenpago_det where id_orden=$_POST[orden] and estado='S'";
				//echo $sqlr;
				$dcuentas[]=array();
				$dncuentas[]=array();
				$resp2 = mysql_query($sqlr,$linkbd);
				while($row2=mysql_fetch_row($resp2))
				 {
				  //$_POST[dcuentas][]=$row2[2];
				  $nombre=buscacuentapres($row2[2],2);
				  //$_POST[dvalores][]=$row2[4];				
		 echo "<tr><td class='saludo2'><input name='dcuentas[]' value='".$row2[2]."' type='text' size='40'></td><td class='saludo2'><input name='dncuentas[]' value='".$nombre."' type='text' size='80'></td><td class='saludo2'><input name='drecursos[]' value='".$_POST[drecursos][$x]."' type='text' ></td><td class='saludo2'><input name='dvalores[]' value='".$row2[4]."' type='text' size='20'   readonly></td></tr>";
		 $_POST[totalc]=$_POST[totalc]+$row2[4];
		 $_POST[totalcf]=number_format($_POST[totalc],2,".",",");
		 }
		$resultado = convertir($_POST[valorpagar]);
		$_POST[letras]=$resultado." PESOS M/CTE";
	    echo "<tr><td colspan='2'></td><td class='saludo2'>Total</td><td class='saludo2'><input name='totalcf' type='text' value='$_POST[totalcf]'><input name='totalc' type='hidden' value='$_POST[totalc]'></td></tr><tr><td  class='saludo1'>Son:</td> <td colspan='5' class='saludo1'><input name='letras' type='text' value='$_POST[letras]' size='90'></td></tr>";
		?>
        <script>
        document.form2.valor.value=<?php echo $_POST[totalc];?>;
		//calcularpago();
        </script>
	   </table></div>	
        <?php
	//	echo "oc:	".$_POST[oculto];
if($_POST[oculto]=='2')
{
	$linkbd=conectar_bd();
 if ($_POST[estado]=='N')
		   $estado=0;
		   else
		   $estado=1;
 	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];

//************CREACION DEL COMPROBANTE CONTABLE ************************

		  
	  //*****hacer la afectacion presupuestal
				$ideg=$_POST[egreso];

				$sqlr="delete from pptoretencionpago where idrecibo=$ideg ";		  
				mysql_query($sqlr,$linkbd);
					//****descuentos
					$sqlr="delete from pptocomprobante_cab where tipo_comp=17 and numerotipo=$ideg ";		  
				mysql_query($sqlr,$linkbd);
				$sqlr="delete from pptocomprobante_det where tipo_comp=17 and numerotipo=$ideg ";		  
				mysql_query($sqlr,$linkbd);
				
					 $sqlr="insert into  pptocomprobante_cab (numerotipo,tipo_comp,fecha,concepto,vigencia,total_debito,total_credito,diferencia,estado) values($ideg,17,'$fechaf','DESCUENTOS EGRESO',$_POST[vigencia],0,0,0,'$estado')";
	 	  mysql_query($sqlr,$linkbd);
							for($x=0;$x<count($_POST[ddescuentos]);$x++)
							 {																		 			 
							  $valorp=$valorp-round($_POST[valororden]*$_POST[dporcentajes][$x]/1000,2);
  	 						 // $sqlr="select *from tesoretenciones_det where codigo=(select id from tesoretenciones where codigo='".$_POST[ddescuentos][$x]."')";
							 $sqlr="select *from tesoretenciones_det,tesoretenciones where tesoretenciones_det.codigo=tesoretenciones.id and tesoretenciones.codigo='".$_POST[ddescuentos][$x]."' and tesoretenciones_det.vigencia='$vigusu'";
							  $resdes=mysql_query($sqlr);
							  $valordes=0;
							  //echo $sqlr;
							  while($rowdes=mysql_fetch_row($resdes))
							   {							  
							   //$valordes=($row2[4]*$_POST[dporcentajes][$x]/100)*($rowdes[4]/100);
       							 if($_POST[iva]>0 && $rowdes[14]==1)
								  {
									   $valordes=round($_POST[ddesvalores][$x]*($rowdes[4]/100),2);
								//    $valordes=round($_POST[ddesvalores][$x],0);								
									//echo "<br>Pi: round($row2[4]*($rowdes[4]/100),0) :".$valordes;
								  }
								  else
								  {
									$valordes=round(($_POST[ddesvalores][$x])*($rowdes[4]/100),2);
							    //$valordes=round($_POST[ddesvalores][$x],0);								
								//echo "<br>Pn: round($row2[4]*($rowdes[4]/100),0) :".$valordes;
								  }
	   						    if($rowdes[3]!="")
							    {
							  //afectacion presupuestal***********							 
					  			$sqlr="insert into pptoretencionpago  (cuenta,idrecibo,valor,vigencia) values ($rowdes[3],$ideg,".$valordes.",".$_POST[vigencia].")";				
								mysql_query($sqlr,$linkbd);
								$sqlr="UPDATE  pptocuentaspptoinicial SET ingresos=ingresos+".$valordes." where (vigencia='".$vigusu."' or vigenciaf='$vigusu') and cuenta='$rowdes[3]' ";				
								mysql_query($sqlr,$linkbd);		
								$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) values('".$rowdes[3]."','".$_POST[tercero]."','DESCUENTO EGRESO ',".$valordes.",0,1,'$_POST[vigencia]',17,'$ideg')";
						 	  mysql_query($sqlr,$linkbd); 					  
							   }
							   }							  
							 }

				$sqlr="delete from pptorecibopagoppto where idrecibo=$ideg and vigencia='$vigusu'";		  
				mysql_query($sqlr,$linkbd);
				$sqlr="delete from pptocomprobante_cab where tipo_comp=11 and numerotipo=$ideg ";		  
				mysql_query($sqlr,$linkbd);
				$sqlr="delete from pptocomprobante_det where tipo_comp=11 and numerotipo=$ideg ";		  
				mysql_query($sqlr,$linkbd);
				
				 $sqlr="insert into  pptocomprobante_cab (numerotipo,tipo_comp,fecha,concepto,vigencia,total_debito,total_credito,diferencia,estado) values($ideg,11,'$fechaf','EGRESO ',$_POST[vigenciaop],0,0,0,'$estado')";
	 	  mysql_query($sqlr,$linkbd);	
						  		
		  		$sqlr="select *from tesoordenpago_det where id_orden=$_POST[orden] ";		  
				$resp2 = mysql_query($sqlr,$linkbd);
				while($row2=mysql_fetch_row($resp2))
				 {
	  			$sqlr="insert into pptorecibopagoppto  (cuenta,idrecibo,valor,vigencia) values ('$row2[2]',$ideg,$row2[4],".$_POST[vigenciaop].")";				
				mysql_query($sqlr,$linkbd);
				$vi=$row2[4];
				if($vi>0)
			   {
			  $sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) values('".$row2[2]."','".$_POST[tercero]."','EGRESO ',".$vi.",0,1,'$_POST[vigenciaop]',11,'$ideg')";
	 	  mysql_query($sqlr,$linkbd); 
			   }
				//echo "<br>$sqlr";
				 }
				  echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado el Egreso con Exito <img src='imagenes\confirm.png'></center></td></tr></table>";		
}//************ FIN DE IF OCULTO************
?>	
</form>
 </td></tr>  
</table>
</body>
</html>	 