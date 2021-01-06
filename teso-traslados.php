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
<title>:: SPID- Tesoreria</title>

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
function pdf()
{
document.form2.action="teso-pdftraslados.php";
document.form2.target="_BLANK";
document.form2.submit(); 
document.form2.action="";
document.form2.target="";
}
</script>

<script src="css/programas.js"></script>
<script src="css/calendario.js"></script>
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
	<tr  class="cinta">
		<td colspan="3"  class="cinta">
			<a href="teso-traslados.php" class="mgbt"><img src="imagenes/add.png" alt="Nuevo"  border="0" /></a>
			<a href="#"  onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png"  alt="Guardar" /></a>
			<a href="teso-buscatraslados.php" class="mgbt"> <img src="imagenes/busca.png"  alt="Buscar" border="0" /></a>
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana"></a>
			<a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png"  alt="Buscar" /></a>
		</td>
	</tr>		  
</td></tr>
</table>
<tr><td colspan="3" class="tablaprin" align="center"> 
<?php
$vigencia=date(Y);
$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
$vigencia=$vigusu;
 ?>	
<?php
	  //*********** cuenta origen va al credito y la destino al debito
if(!$_POST[oculto])
{
$_POST[tipotras]=1;
 		 $linkbd=conectar_bd();
		 $fec=date("d/m/Y");
	 $sqlr="select valor_inicial,valor_final, tipo from dominios where nombre_dominio='CUENTA_TRASLADO'";
	 $res=mysql_query($sqlr,$linkbd);
		while ($row =mysql_fetch_row($res)) 
			{
			 $_POST[cuentatraslado]=$row[0];
			 }
		 $_POST[fecha]=$fec; 		 		  			 
		 $_POST[valor]=0;	
		 $sqlr="select max(id_consignacion) from tesotraslados_cab ";
	$res=mysql_query($sqlr,$linkbd);
	$consec=0;
	while($r=mysql_fetch_row($res))
	 {
	  $consec=$r[0];	  
	 }
	 $consec+=1;
	 $_POST[idcomp]=$consec;	 
}
?>
 <form name="form2" method="post" action=""> 
    <table class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="5">.: Agregar Traslados</td>
        <td width="126" class="cerrar" ><a href="teso-principal.php">  Cerrar</a></td>
      </tr>
      <tr  >
	        <td class="saludo1" >Numero Comp:</td>
        <td ><input name="idcomp" type="text" size="5" value="<?php echo $_POST[idcomp]?>"><input name="cuentatraslado" type="text" size="5" value="<?php echo $_POST[cuentatraslado]?>"></td>
<td  class="saludo1">Fecha:        </td>
        <td ><input id="fc_1198971545" title="DD/MM/YYYY" name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10" size="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onKeyDown="mascara(this,'/',patron,true)">   <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>     </td>  
</tr>
	<tr>
	<td class="saludo1">Tipo Traslado</td>
	<td>
	<select name="tipotras" id="tipotras" onKeyUp="return tabular(event,this)" onChange="validar()" >
         <option value="1" <?php if($_POST[tipotras]=='1') echo "SELECTED"; ?>>Interno</option>
         <option value="2" <?php if($_POST[tipotras]=='2') echo "SELECTED"; ?>>Externo</option>
  	</select>
	</td>
	<?php
	 if($_POST[tipotras]==2)
	   {
	?>
	<td class="saludo1">Tipo Traslado</td>
	<td>
	<select name="tipotrasext" id="tipotrasext" onKeyUp="return tabular(event,this)" onChange="validar()" >
         <option value="1" <?php if($_POST[tipotrasext]=='1') echo "SELECTED"; ?>>Entrada</option>
         <option value="2" <?php if($_POST[tipotrasext]=='2') echo "SELECTED"; ?>>Salida</option>
  	</select>
	</td>
	<?php
		}
	?>
	</tr>
	<tr>
        <td  class="saludo1">Numero Transaccion:
        </td>
        <td><input name="numero" type="text" value="<?php echo $_POST[numero]?>" size="20" onKeyUp="return tabular(event,this)">        </td>
				  <td  class="saludo1">Concepto Traslado:</td>
		          <td><input name="concepto" type="text" value="<?php echo $_POST[concepto]?>" size="95" onKeyUp="return tabular(event,this)">        </td>

       </tr> 
	  <tr>
	  <td class="saludo1">Centro Costo :</td>
	  <td>
	<select name="cc"  onChange="validar()" onKeyUp="return tabular(event,this)">
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
	  <td class="saludo1">Cuenta Bancaria :</td>
	  <td >
	    <select id="banco" name="banco"  onChange="validar()" onKeyUp="return tabular(event,this)">
	      <option value="">Seleccione....</option>
		  <?php
	$linkbd=conectar_bd();
	$sqlr="select tesobancosctas.estado,tesobancosctas.cuenta,tesobancosctas.ncuentaban,tesobancosctas.tipo,terceros.razonsocial,tesobancosctas.tercero from tesobancosctas,terceros where tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.estado='S' ";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
				    {
					echo "<option value='$row[1]' ";
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
            </select> <input type="text" id="nbanco" name="nbanco" value="<?php echo $_POST[nbanco]?>" size="50" readonly><input type="hidden" id="cb" name="cb" value="<?php echo $_POST[cb]?>" ><input type="hidden" id="ter" name="ter" value="<?php echo $_POST[ter]?>" ></td>
	  </tr> 
	  <?php
	   if($_POST[tipotras]==1)
	   {
	   ?>
	  <tr>
	  <td class="saludo1">Centro Costo Destino:</td>
	  <td>
	<select name="cc2"  onChange="validar()" onKeyUp="return tabular(event,this)">
	<?php
	$linkbd=conectar_bd();
	$sqlr="select *from centrocosto where estado='S'";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
				    {
					echo "<option value=$row[0] ";
					$i=$row[0];
		
					 if($i==$_POST[cc2])
			 			{
						 echo "SELECTED";
						 }
					  echo ">".$row[0]." - ".$row[1]."</option>";	 	 
					}	 	
	?>
   </select>
	 </td>
	  <td class="saludo1">Cuenta Bancaria Destino:</td>
	  <td >
	    <select id="banco2" name="banco2"  onChange="validar()" onKeyUp="return tabular(event,this)">
	      <option value="">Seleccione....</option>
		  <?php
	$linkbd=conectar_bd();
	$sqlr="select tesobancosctas.estado,tesobancosctas.cuenta,tesobancosctas.ncuentaban,tesobancosctas.tipo,terceros.razonsocial,tesobancosctas.tercero from tesobancosctas,terceros where tesobancosctas.tercero=terceros.cedulanit   and tesobancosctas.estado='S' ";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
				    {
					echo "<option value='$row[1]' ";
					$i=$row[1];
					 if($i==$_POST[banco2])
			 			{
						 echo "SELECTED";
						 $_POST[nbanco2]=$row[4];
						 $_POST[cb2]=$row[2];
						  $_POST[ter2]=$row[5];						
						 }
					  echo ">".$row[2]." - Cuenta ".$row[3]."</option>";	 	 
					}	 	
	?>
            </select> <input type="text" id="nbanco2" name="nbanco2" value="<?php echo $_POST[nbanco2]?>" size="50" readonly><input type="hidden" id="cb2" name="cb2" value="<?php echo $_POST[cb2]?>" ><input type="hidden" id="ter2" name="ter2" value="<?php echo $_POST[ter2]?>" ></td>
	  </tr> 
	  <?php
	  }
	  ?>
	  <tr>
	  <td class="saludo1">Valor:</td><td><input type="text" id="valor" name="valor" value="<?php echo $_POST[valor]?>" size="20" onKeyUp="return tabular(event,this)"> <input type="button" name="agregar" id="agregar" value="   Agregar   " onClick="agregardetalle()" ><input type="hidden" value="0" name="agregadet"><input type="hidden" value="1" name="oculto">	</td>
	  </tr>
      </table>
	<script>
	   document.form2.valor.focus();
 document.form2.valor.select();
 </script>
	  <div class="subpantalla">
	   <table class="inicio">
	   <tr><td colspan="8" class="titulos">Detalle Traslados</td></tr>                  
		<tr><td class="titulos2">Banco</td><td class="titulos2">N� Transaccion</td>
		<td class="titulos2">CC-1</td>
		<td class="titulos2">Cuenta Bancaria 1 </td>
		<td class="titulos2">CC-2</td>
		<td class="titulos2">Cuenta Bancaria 2 </td>
		<td class="titulos2">Valor</td><td class="titulos2"><img src="imagenes/del.png"><input type='hidden' name='elimina' id='elimina'></td></tr>
		<?php 		
		if ($_POST[elimina]!='')
		 { 
		 //echo "<TR><TD>ENTROS :".$_POST[elimina]."</TD></TR>";
		 $posi=$_POST[elimina];
		 unset($_POST[dccs][$posi]);
		 unset($_POST[dccs2][$posi]);
		 unset($_POST[dconsig][$posi]);
		  unset($_POST[dbancos][$posi]);
		 unset($_POST[dnbancos][$posi]);		 
		  unset($_POST[dbancos2][$posi]);
		 unset($_POST[dnbancos2][$posi]);		 
 		 unset($_POST[dcbs][$posi]);	
 		 unset($_POST[dcbs2][$posi]);	
		  unset($_POST[dcts][$posi]);	
 		 unset($_POST[dcts2][$posi]);		 
		 unset($_POST[dvalores][$posi]);			  
		 $_POST[dccs]= array_values($_POST[dccs]); 
		 $_POST[dccs2]= array_values($_POST[dccs2]); 		 
		 $_POST[dconsig]= array_values($_POST[dconsig]);  
		 $_POST[dbancos]= array_values($_POST[dbancos]); 
  		  $_POST[dnbancos]= array_values($_POST[dnbancos]); 
		 $_POST[dbancos2]= array_values($_POST[dbancos2]); 
  		  $_POST[dnbancos2]= array_values($_POST[dnbancos2]); 
		 $_POST[dcbs]= array_values($_POST[dcbs]); 		 
		 $_POST[dcbs2]= array_values($_POST[dcbs2]); 	
		 $_POST[dcts]= array_values($_POST[dcts]); 		 
		 $_POST[dcts2]= array_values($_POST[dcts2]); 		 		 
		 $_POST[dvalores]= array_values($_POST[dvalores]); 		 		 		 		 		 
		 }	 
		 if ($_POST[agregadet]=='1')
		 {
		 $_POST[dccs][]=$_POST[cc];
		 $_POST[dccs2][]=$_POST[cc2];		 
		 $_POST[dconsig][]=$_POST[numero];			 
		 $_POST[dbancos][]=$_POST[banco];		 
		 $_POST[dnbancos][]=$_POST[nbanco];		 
		 $_POST[dbancos2][]=$_POST[banco2];		 
		 $_POST[dnbancos2][]=$_POST[nbanco2];		 
		 $_POST[dcbs][]=$_POST[cb];
		 $_POST[dcbs2][]=$_POST[cb2];		
		 $_POST[dcts][]=$_POST[ter];
		 $_POST[dcts2][]=$_POST[ter2];		 
		  $_POST[dvalores][]=$_POST[valor];
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
				document.form2.ter.value="";
				document.form2.ter2.value="";
				document.form2.valor.value="";	
				document.form2.numero.value="";	
				document.form2.agregadet.value="0";				
				document.form2.numero.select();
		  		document.form2.numero.focus();	
		 </script>
		  <?php
		  }
		  		  $_POST[totalc]=0;
		 for ($x=0;$x<count($_POST[dbancos]);$x++)
		 {		 
		 echo "<tr><td class='saludo2'><input name='dnbancos[]' value='".$_POST[dnbancos][$x]."' type='text' size='40'></td><td class='saludo2'><input name='dconsig[]' value='".$_POST[dconsig][$x]."' type='text' ></td><td class='saludo2'><input name='dccs[]' value='".$_POST[dccs][$x]."' type='text' size='2' readonly></td><td class='saludo2'><input name='dbancos[]' value='".$_POST[dbancos][$x]."' type='hidden' ><input name='dcts[]' value='".$_POST[dcts][$x]."' type='hidden' ><input name='dcbs[]' value='".$_POST[dcbs][$x]."' type='text' size='40' readonly></td><td class='saludo2'><input name='dccs2[]' value='".$_POST[dccs2][$x]."' type='text' size='2' readonly></td><td class='saludo2'><input name='dcts2[]' value='".$_POST[dcts2][$x]."' type='hidden' ><input name='dnbancos2[]' value='".$_POST[dnbancos2][$x]."' type='hidden' ><input name='dbancos2[]' value='".$_POST[dbancos2][$x]."' type='hidden' ><input name='dcbs2[]' value='".$_POST[dcbs2][$x]."' type='text' size='40' readonly></td><td class='saludo2'><input name='dvalores[]' value='".$_POST[dvalores][$x]."' type='text' size='15' readonly></td><td class='saludo2'><a href='#' onclick='eliminar($x)'><img src='imagenes/del.png'></a></td></tr>";
		 $_POST[totalc]=$_POST[totalc]+$_POST[dvalores][$x];
		 $_POST[totalcf]=number_format($_POST[totalc],2,".",",");
		 }
		$resultado = convertir($_POST[totalc]);
		$_POST[letras]=$resultado." Pesos";
	    echo "<tr><td colspan='5'></td><td class='saludo2'>Total</td><td class='saludo2'><input name='totalcf' type='text' value='$_POST[totalcf]'><input name='totalc' type='hidden' value='$_POST[totalc]'></td></tr><tr><td colspan='5'>Son: <input name='letras' type='text' value='$_POST[letras]' size='90'></td></tr>";
		?>
	   </table></div>
	  <?php
if($_POST[oculto]=='2')
{
	$linkbd=conectar_bd();
 $sqlr="select count(*) from tesotraslados_cab where id_consignacion=$_POST[idcomp]  ";
		$res=mysql_query($sqlr,$linkbd);
		//echo "t:".$_POST[tipotras];
		while($r=mysql_fetch_row($res))
		 {
			$numerorecaudos=$r[0];
		 }
	  if($numerorecaudos==0)
	   { 	
 	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
//************CREACION DEL COMPROBANTE CONTABLE ************************6246
//***busca el consecutivo del comprobante contable
	$consec=0;
	/*$sqlr="select max(numerotipo) from comprobante_cab where tipo_comp='10' and EXTRACT(YEAR FROM fecha)=".$vigusu;
	//echo $sqlr;
	$res=mysql_query($sqlr,$linkbd);
	while($r=mysql_fetch_row($res))
	 {
	  $consec=$r[0];	  
	 }*/
	 //$consec+=1;
	 $consec=$_POST[idcomp];
//***cabecera comprobante
	 $sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($consec,10,'$fechaf','$_POST[concepto]',0,$_POST[totalc],$_POST[totalc],0,'1')";
	mysql_query($sqlr,$linkbd);
	$idcomp=mysql_insert_id();
	$sqlr="insert into tesotraslados_cab (id_comp,fecha,vigencia,estado,concepto) values($idcomp,'$fechaf','".$vigusu."','S','$_POST[concepto]')";	
	mysql_query($sqlr,$linkbd);
	//echo "$sqlr <br>";
	$idtraslados=mysql_insert_id();
	echo "<input type='hidden' name='ncomp' value='$idcomp'>";
	
			if($_POST[tipotras]=='1')
				{
	//******************* DETALLE DEL COMPROBANTE CONTABLE *********************
				for($x=0;$x<count($_POST[dbancos]);$x++)
				 {
	    //**** consignacion  BANCARIA*****
	$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('10 $consec','".$_POST[dbancos][$x]."','".$_POST[dcts][$x]."','".$_POST[dccs][$x]."','Traslado ".$_POST[dconsig][$x]." ".$_POST[dnbancos][$x]."','',0,".$_POST[dvalores][$x].",'1','".$vigusu."')";
	mysql_query($sqlr,$linkbd);
		//*** Cuenta CAJA **
	$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado, vigencia) values ('10 $consec','".$_POST[dbancos2][$x]."','".$_POST[dcts2][$x]."','".$_POST[dccs2][$x]."','Traslado ".$_POST[dconsig][$x]." ".$_POST[dnbancos2][$x]."','',".$_POST[dvalores][$x].",0,'1','".$vigusu."')";
	mysql_query($sqlr,$linkbd);
		//	echo "$sqlr <br>";
				  }	
	//************ insercion de cabecera TRASLADOS ************
	
//***************CREACION DE LA TABLA EN CTRASLADOS *********************
				for($x=0;$x<count($_POST[dbancos]);$x++)
				 {
	$sqlr="insert into tesotraslados (id_trasladocab,fecha,ntransaccion,cco,ncuentaban1,tercero1,ccd,ncuentaban2,tercero2,valor,estado) values($idtraslados,'$fechaf','".$_POST[dconsig][$x]."','".$_POST[dccs][$x]."','".$_POST[dcbs][$x]."','".$_POST[dcts][$x]."','".$_POST[dccs2][$x]."','".$_POST[dcbs2][$x]."','".$_POST[dcts2][$x]."',".$_POST[dvalores][$x].",'S')";	
    //echo $sqlr;	
					if (!mysql_query($sqlr,$linkbd))
						{
	 echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petici�n: <br><font color=red><b>$sqlr</b></font></p>";
//	 $e =mysql_error($respquery);
	 echo "Ocurri� el siguiente problema:<br>";
  	 //echo htmlentities($e['message']);
  	 echo "<pre>";
     ///echo htmlentities($e['sqltext']);
    // printf("\n%".($e['offset']+1)."s", "^");
     echo "</pre></center></td></tr></table>";
						}
  						else
  						 {
		  echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado los Traslados con Exito <img src='imagenes/confirm.png'></center></td></tr></table>";
		  ?>
		  <script>
		  document.form2.numero.value="";
		  document.form2.valor.value=0;
		  document.form2.oculto.value=1;
		  </script>
		  <?php
						  }
					}	  
				}	
	
	if($_POST[tipotras]=='2')
	{
	for($x=0;$x<count($_POST[dbancos]);$x++)
	 {
	 if($_POST[tipotrasext]=='1')
	 {
	 $debito=$_POST[dvalores][$x];
	 $credito=0;	 
	 }
	 if($_POST[tipotrasext]=='2')
	 {
	 $debito=0;
	 $credito=$_POST[dvalores][$x];	 	 
	 }	
	    //**** consignacion  BANCARIA*****
	$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('10 $consec','".$_POST[dbancos][$x]."','".$_POST[dcts][$x]."','".$_POST[dccs][$x]."','Traslado ".$_POST[dconsig][$x]." ".$_POST[dnbancos][$x]."','',$debito,$credito,'1','".$vigusu."')";
	mysql_query($sqlr,$linkbd);
	//echo $sqlr;
	$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('10 $consec','".$_POST[cuentatraslado]."','".$_POST[dcts][$x]."','".$_POST[dccs][$x]."','Traslado ".$_POST[dconsig][$x]." ".$_POST[dnbancos][$x]."','',$credito,$debito,'1','".$vigusu."')";
	mysql_query($sqlr,$linkbd);
	//echo $sqlr;
	 }
	 	
//***************CREACION DE LA TABLA EN CTRASLADOS *********************
for($x=0;$x<count($_POST[dbancos]);$x++)
{
$sqlr="insert into tesotraslados (id_trasladocab,fecha,ntransaccion,cco,ncuentaban1,tercero1,ccd,ncuentaban2,tercero2,valor,estado) values($idtraslados,'$fechaf','".$_POST[dconsig][$x]."','".$_POST[dccs][$x]."','".$_POST[dcbs][$x]."','".$_POST[dcts][$x]."','".$_POST[dccs2][$x]."','".$_POST[dcbs2][$x]."','".$_POST[dcts2][$x]."',".$_POST[dvalores][$x].",'S')";	
//echo $sqlr;	
   if (!mysql_query($sqlr,$linkbd))
	   {
echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petici�n: <br><font color=red><b>$sqlr</b></font></p>";
//	 $e =mysql_error($respquery);
echo "Ocurri� el siguiente problema:<br>";
//echo htmlentities($e['message']);
echo "<pre>";
///echo htmlentities($e['sqltext']);
// printf("\n%".($e['offset']+1)."s", "^");
echo "</pre></center></td></tr></table>";
	   }
		 else
		  {
echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado los Traslados con Exito <img src='imagenes/confirm.png'></center></td></tr></table>";
?>
<script>
document.form2.numero.value="";
document.form2.valor.value=0;
document.form2.oculto.value=1;
</script>
<?php
		 }
   }	 
	}
  }
  else
  {
    echo "<table class='inicio'><tr><td class='saludo1'><center>Ya existe un traslado con este consecutivo <img src='imagenes/alert.png'></center></td></tr></table>";
  }

}
?>	
</form>
 </td></tr>  
</table>
</body>
</html>