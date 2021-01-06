<?php //V 1000 12/12/16 ?> 
<?php
require"comun.inc";
require"funciones.inc";
require "conversor.php";
session_start();
cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
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

<script src="css/programas.js"></script>
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
  <td colspan="3" class="cinta"><a href="teso-girarcheques.php" ><img src="imagenes/add.png" alt="Nuevo"  border="0" /></a> <a href="#"  onClick="guardar()"><img src="imagenes/guarda.png"  alt="Guardar" /></a><a href="teso-buscagirarcheques.php"> <img src="imagenes/busca.png"  alt="Buscar" border="0" /></a> <a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" alt="nueva ventana"></a>  <a href="#" onClick="pdf()"> <img src="imagenes/print.png"  alt="Buscar" /></a></td>
</tr>		  
</table>
<tr><td colspan="3" class="tablaprin" align="center"> 
<?php
$vigencia=date(Y);
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

	$sqlr="select *from tesoegresos where estado='S' ";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
	{
	 $_POST[cuentapagar]=$row[1];
	}
		$check1="checked";
 		 $fec=date("d/m/Y");
		 $_POST[fecha]=$fec; 		 		  			 
		//$_POST[valor]=0;
		//$_POST[valorcheque]=0;
		//$_POST[valorretencion]=0;
		//$_POST[valoregreso]=0;
		//$_POST[totaldes]=0;
		 $_POST[vigencia]=$_SESSION[vigencia]; 		
		 $sqlr="select max(id_egreso) from tesoegresos ";
		$res=mysql_query($sqlr,$linkbd);
		$consec=0;
		while($r=mysql_fetch_row($res))
		 {
		  $consec=$r[0];	  
	 	}
	 	$consec+=1;
	 	$_POST[egreso]=$consec;		 
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
 <form name="form2" method="post" action=""> 
 <?php
 if($_POST[bop]=='1')
			 {
			if($_POST[orden]!='' )
				 {
			  //*** busca detalle cdp
			  $linkbd=conectar_bd();
  				$sqlr="select *from tesoordenpago where id_orden=$_POST[orden] and estado='S'";
				//echo $sqlr;
				$resp = mysql_query($sqlr,$linkbd);
				$row =mysql_fetch_row($resp);
				$_POST[concepto]=$row[7];
				$_POST[tercero]=$row[6];
				$_POST[ntercero]=buscatercero($_POST[tercero]);
				$_POST[valororden]=$row[10];
				$_POST[retenciones]=$row[12];
				$_POST[totaldes]=number_format($_POST[retenciones],2);
				$_POST[valorpagar]=$_POST[valororden]-$_POST[retenciones];
				$_POST[base]=$row[14];
				$_POST[iva]=$row[15];
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
		}	  		 
        ?>
	   <table class="inicio" align="center" >       
	   <tr>
	   <td colspan="10" class="titulos">Comprobante de Egreso</td><td width="74" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td></tr>
       <tr><td class="saludo1">No Egreso:</td><td><input name="cuentapagar" type="hidden" value="<?php echo $_POST[cuentapagar]?>" > <input name="egreso" type="text" value="<?php echo $_POST[egreso]?>" size="10" onKeyUp="return tabular(event,this)" onKeyDown="mascara(this,'/',patron,true)" onBlur="buscarp(event)" readonly ></td>
       	  <td class="saludo1">Fecha: </td>
        <td ><input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10" size="10" onKeyDown="mascara(this,'/',patron,true)" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)">        </td>       
       <td width="111" class="saludo1">Forma de Pago:</td>
       <td width="156">
       <select name="tipop" onChange="validar();" onKeyUp="return tabular(event,this)">
       <option value="">Seleccione ...</option>
				  <option value="cheque" <?php if($_POST[tipop]=='cheque') echo "SELECTED"?>>Cheque</option>
  				  <option value="transferencia" <?php if($_POST[tipop]=='transferencia') echo "SELECTED"?>>Transferencia</option>
				  </select>
          </td>        
       </tr>
<tr>  <td class="saludo1">No Orden Pago:</td>
	  <td ><input name="orden" type="text" value="<?php echo $_POST[orden]?>" size="10" onKeyUp="return tabular(event,this)" onBlur="buscaop(event)"  ><input type="hidden" value="0" name="bop"> <a href="#" onClick="mypop=window.open('ordenpago-ventana.php?vigencia=<?php echo $_POST[vigencia]?>','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=900,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a> </td>
      <td width="126" class="saludo1">Tercero:</td>
          <td width="144"  ><input id="tercero" type="text" name="tercero" size="20" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo $_POST[tercero]?>" readonly>
           </td><td colspan="4"><input name="ntercero" type="text" value="<?php echo $_POST[ntercero]?>" size="70" readonly></td></tr>
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
						 $_POST[tcta]=$row[3];
						 }
					  echo ">".$row[2]." - Cuenta ".$row[3]."</option>";	 	 
					}	 	
	?>
            </select>
			<?php 
			if($_POST[cb]!="")
			 {
			$sqlr="select count(*) from tesochequeras where banco=$_POST[ter] and cuentabancaria=$_POST[cb] and estado='S'";
			$res2=mysql_query($sqlr,$linkbd);
//			echo $sqlr;
			$row2 =mysql_fetch_row($res2);
			if($row2[0]<=0 && $_POST[oculto]!='')
			  {
			   echo "<script>alert('No existe una chequera activa para esta Cuenta');document.form2.banco.value=''; document.form2.banco.focus();</script>";
			  $_POST[nbanco]="";
			  $_POST[ncheque]="";
			  }
			  else
			   {
			    $sqlr="select * from tesochequeras where banco=$_POST[ter] and cuentabancaria=$_POST[cb] and estado='S' ";
				$res2=mysql_query($sqlr,$linkbd);
				$row2 =mysql_fetch_row($res2);
			   //$_POST[ncheque]=$row2[6];
			   }
			  }
			 ?>
		<input name="tcta" type="hidden" value="<?php echo $_POST[tcta]?>" ><input name="cb" type="hidden" value="<?php echo $_POST[cb]?>" ><input type="hidden" id="ter" name="ter" value="<?php echo $_POST[ter]?>" ></td><td colspan="2"><input type="text" id="nbanco" name="nbanco" value="<?php echo $_POST[nbanco]?>" size="50" readonly></td>
			<td width="96" class="saludo1">Cheque:</td><td width="332" ><input type="text" id="ncheque" name="ncheque" value="<?php echo $_POST[ncheque]?>" size="20" ></td>
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
						 $_POST[tcta]=$row[3];
						 }
					  echo ">".$row[2]." - Cuenta ".$row[3]."</option>";	 	 
					}	 	
	?>
            </select>
			
		<input name="tcta" type="hidden" value="<?php echo $_POST[tcta]?>" ><input name="cb" type="hidden" value="<?php echo $_POST[cb]?>" ><input type="hidden" id="ter" name="ter" value="<?php echo $_POST[ter]?>" ></td><td colspan="2"><input type="text" id="nbanco" name="nbanco" value="<?php echo $_POST[nbanco]?>" size="50" readonly></td>
			<td class="saludo1">No Transferencia:</td><td ><input type="text" id="ntransfe" name="ntransfe" value="<?php echo $_POST[ntransfe]?>" size="20" ></td>
	  </tr>
      <?php
	     }//cierre del if de cheques
      ?> 
	  <tr>
	  <td class="saludo1">Valor Orden:</td><td><input name="valororden" type="text" id="valororden" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[valororden]?>" size="20" readonly></td>	  <td class="saludo1">Retenciones:</td><td><input name="retenciones" type="text" id="retenciones" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[retenciones]?>" size="20" readonly></td>	  <td class="saludo1">Valor a Pagar:</td><td><input name="valorpagar" type="text" id="valorpagar" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[valorpagar]?>" size="20" readonly> <input type="hidden" value="1" name="oculto"></td><td class="saludo1" >Base:</td><td><input type="text" id="base" name="base" value="<?php echo $_POST[base]?>" size="15" onKeyUp="return tabular(event,this)" onChange='calcularpago()' readonly> </td><td class="saludo1" >Iva:</td><td><input type="text" id="iva" name="iva" value="<?php echo $_POST[iva]?>" size="15" onKeyUp="return tabular(event,this)" onChange='calcularpago()' readonly> <input type="hidden" id="regimen" name="regimen" value="<?php echo $_POST[regimen]?>" ></td></tr>	
      </table>	 
<div class="subpantallac4">
 <table class="inicio">
	   <tr><td colspan="8" class="titulos">Detalle Orden de Pago</td></tr>                  
		<tr><td class="titulos2">Cuenta</td><td class="titulos2">Nombre Cuenta</td><td class="titulos2">Recurso</td><td class="titulos2">Valor</td></tr>
		<?php 		
		if ($_POST[elimina]!='')
		 { 
		 //echo "<TR><TD>ENTROS :".$_POST[elimina]."</TD></TR>";
		 $posi=$_POST[elimina];
		 unset($_POST[dccs][$posi]);
		 unset($_POST[dvalores][$posi]);		 
		 $_POST[dccs]= array_values($_POST[dccs]); 
		 }	 
		 if ($_POST[agregadet]=='1')
		 {
		 $_POST[dccs][]=$_POST[cc];
		 $_POST[agregadet]='0';
		  ?>
		 <script>
		  		//document.form2.cuenta.focus();	
				document.form2.banco.value="";
				document.form2.nbanco.value="";
				document.form2.banco2.value="";
				document.form2.nbanco2.value="";
				document.form2.cb.value="";
				document.form2.cb2.value="";
				document.form2.valor.value="";	
				document.form2.numero.value="";	
				document.form2.agregadet.value="0";				
				document.form2.numero.select();
		  		document.form2.numero.focus();	
		 </script>
		  <?php
		  }
		  $_POST[totalc]=0;
		  $sqlr="select *from humnomina_det where id_nom=$_POST[orden] and 'S'=(select estado from tesoordenpago where id_orden=$_POST[orden] )";
				//echo $sqlr;
				$dcuentas[]=array();
				$dncuentas[]=array();
				$resp2 = mysql_query($sqlr,$linkbd);
				while($row2=mysql_fetch_row($resp2))
				 {
				  //$_POST[dcuentas][]=$row2[2];
				  $nombre=buscacuentapres($row2[2],2);
				  //$_POST[dvalores][]=$row2[4];				
		 echo "<tr><td class='saludo2'><input name='dcuentas[]' value='".$row2[2]."' type='text' size='40'></td><td class='saludo2'><input name='dncuentas[]' value='".$nombre."' type='text' size='80'></td><td class='saludo2'><input name='drecursos[]' value='".$_POST[drecursos][$x]."' type='text' ></td><td class='saludo2'><input name='dvalores[]' value='".$row2[4]."' type='text' size='20' onDblClick='llamarventanaegre(this,$x);'  readonly></td></tr>";
		 $_POST[totalc]=$_POST[totalc]+$row2[4];
		 $_POST[totalcf]=number_format($_POST[totalc],2,".",",");
		 }
		$resultado = convertir($_POST[totalc]);
		$_POST[letras]=$resultado." PESOS M/CTE";
	    echo "<tr><td colspan='2'></td><td class='saludo2'>Total</td><td class='saludo2'><input name='totalcf' type='text' value='$_POST[totalcf]'><input name='totalc' type='hidden' value='$_POST[totalc]'></td></tr><tr><td  class='saludo1'>Son:</td> <td colspan='5' class='saludo1'><input name='letras' type='text' value='$_POST[letras]' size='90'></td></tr>";
		?>
        <script>
        document.form2.valor.value=<?php echo $_POST[totalc];?>;
		//calcularpago();
        </script>
	   </table></div>	
        <?php
if($_POST[oculto]=='2')
{
	$linkbd=conectar_bd();
 	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
//************CREACION DEL COMPROBANTE CONTABLE ************************
$sqlr="select count(*) from tesoegresos where id_orden=$_POST[orden] and estado ='S'";
$res=mysql_query($sqlr,$linkbd);
//echo $sqlr;
$row=mysql_fetch_row($res);
$nreg=$row[0];
	if ($nreg==0)
	 {
   $sqlr="insert into tesoegresos (`id_orden`, `fecha`, `vigencia`, `valortotal`, `retenciones`, `valorpago`, `concepto`, `banco`, `cheque`, `tercero`, `cuentabanco`, `estado`,pago) values ($_POST[orden],'$fechaf','".$_SESSION[vigencia]."',$_POST[valororden],$_POST[retenciones],$_POST[valorpagar],'$_POST[concepto]','$_POST[banco]','$_POST[ncheque]','$_POST[tercero]','$_POST[cb]','S','$_POST[tipop]')"; 
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
			 	$ideg=mysql_insert_id();
				$_POST[egreso]=$ideg;
		  echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado el Egreso con Exito <img src='imagenes\confirm.png'></center></td></tr></table>";		 
		  $sqlr="update tesochequeras set consecutivo=consecutivo+1 where cuentabancaria='$_POST[cb]'  and estado='S'";
		  
//		    echo $sqlr;
		  mysql_query($sqlr,$linkbd);
		  
		  $sqlr="insert into tesoegresos_cheque (id_cheque,id_egreso,estado,motivo) values ('$_POST[ncheque]',$ideg,'S','')";
		  mysql_query($sqlr,$linkbd);
	//	  echo $sqlr;
		  $sqlr="update tesoordenpago set estado='P' where id_orden=$_POST[orden] and estado='S'";
	//	  echo $sqlr;
		  mysql_query($sqlr,$linkbd);
		  
		  //*****hacer la afectacion presupuestal
		  $sqlr="select *from tesoordenpago_det where id_orden=$_POST[orden] ";
				$resp2 = mysql_query($sqlr,$linkbd);
				while($row2=mysql_fetch_row($resp2))
				 {
	  			$sqlr="insert into pptorecibopagoppto (cuenta,idrecibo,valor,vigencia) values ($row2[2],$ideg,$row2[4],".$_SESSION[vigencia].")";				
				mysql_query($sqlr,$linkbd);
				$sqlr="UPDATE  pptocuentaspptoinicial SET pagos=pagos+$row2[4] where vigencia=".$_SESSION[vigencia]." and cuenta='$row2[2]'";				
				mysql_query($sqlr,$linkbd);
				$sqlr="UPDATE  pptocuentaspptoinicial SET cxp=cxp-$row2[4] where vigencia=".$_SESSION[vigencia]." and cuenta='$row2[2]'";				
				mysql_query($sqlr,$linkbd);
				 }
		  //***********crear el contabilidad
		  	 $sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values 		($ideg,6,'$fechaf','$_POST[concepto]',0,$_POST[valororden],$_POST[valororden],0,'1')";
			 mysql_query($sqlr,$linkbd);
				$idcomp=mysql_insert_id();
				$sqlr="update tesoegresos set id_comp=$idcomp where id_egreso=$ideg ";			 			 
			 mysql_query($sqlr,$linkbd);

//echo $sqlr;
		  $sqlr="select *from tesoordenpago_det where id_orden=$_POST[orden] ";
				$resp2 = mysql_query($sqlr,$linkbd);
				while($row2=mysql_fetch_row($resp2))
				 {
					$sqlr="select codconcepago from pptocuentas where cuenta='$row2[2]' and vigencia='".$_SESSION[vigencia]."'";	  
					$resp = mysql_query($sqlr,$linkbd);
					while($rowp=mysql_fetch_row($resp))
					 {
						$sqlr="select * from conceptoscontables_det where codigo='$rowp[0]' and modulo='3' and cc='$row2[3]' and tipo='P'";	  
						$resc = mysql_query($sqlr,$linkbd);
						//echo "<br>$sqlr";
						while($rowc=mysql_fetch_row($resc))
						{
						 if($rowc[3]=='N')
						   {
							$ncppto=buscacuentapres($row2[2],2);
							
	 						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito, estado, vigencia) values ('6 $ideg','".$rowc[4]."','".$_POST[tercero]."' ,'".$row2[3]."' , 'Pago ".$ncppto."','',".$row2[4].",0,'1' ,'".$_SESSION[vigencia]."')";
							mysql_query($sqlr,$linkbd);
						   }
						 if($rowc[3]=='B')
						   {
								$valopb=$row2[4];
								//***buscar retenciones
							//	echo "<br>c:".count($_POST[ddescuentos]);
							for($x=0;$x<count($_POST[ddescuentos]);$x++)
							 {	
  	 						  $sqlr="select *from tesoretenciones_det inner join tesoretenciones on tesoretenciones_det.codigo=tesoretenciones.id where tesoretenciones.codigo='".$_POST[ddescuentos][$x]."'";
							  $resdes=mysql_query($sqlr);
							  $valordes=0;
							 // echo "<br>".$sqlr;
							  while($rowdes=mysql_fetch_row($resdes))
							   {							  
    							 if($_POST[iva]>0 && $rowdes[13]==1)
								  {
								   $valordes=$_POST[ddesvalores][$x];
								  }
								  else
								  {
									   $valordes=($_POST[ddesvalores][$x]);
								  }
 							   $valopb-= $valordes; 
							   $sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito, estado, vigencia) values ('6 $ideg','".$rowdes[2]."','".$_POST[tercero]."' ,'".$row2[3]."' , 'Descuento ".$_POST[dndescuentos][$x]."','',0,".$valordes.",'1' ,'".$_SESSION[vigencia]."')";
   								mysql_query($sqlr,$linkbd);
								//echo "<br>".$sqlr;
							  //afectacion presupuestal***********
					  			$sqlr="insert into pptoretencionpago  (cuenta,idrecibo,valor,vigencia) values ($rowdes[3],$ideg,".$valordes.",".$_SESSION[vigencia].")";				
								mysql_query($sqlr,$linkbd);
								$sqlr="UPDATE  pptocuentaspptoinicial SET ingresos=ingresos+".$valordes." where vigencia=".$_SESSION[vigencia]." and cuenta='$rowdes[3]'";				
								mysql_query($sqlr,$linkbd);							  
							   }							  
							 }										
							 //INCLUYE EL CHEQUE
	 						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito, estado, vigencia) values ('6 $ideg','".$_POST[banco]."','".$_POST[tercero]."' ,'".$row2[3]."' , 'Pago Banco ".$ncppto."','$_POST[cheque]  $_POST[ntransfe]',0,".$valopb.",'1' ,'".$_SESSION[vigencia]."')";					
							mysql_query($sqlr,$linkbd);
						   }											 
						}	  
					 }
				 }
		 }
 }
  else
   {
 	echo "<table class='inicio'><tr><td class='saludo1'><center>No se puede almacenar, ya existe un egreso para esta orden <img src='imagenes\alert.png'></center></td></tr></table>";
   }
}//************ FIN DE IF OCULTO************
?>	
</form>
 </td></tr>  
</table>
</body>
</html>	 