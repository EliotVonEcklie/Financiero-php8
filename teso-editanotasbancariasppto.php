<?php //V 1000 12/12/16 ?> 
<?php
require "comun.inc";
require "funciones.inc";
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
document.form2.action="teso-pdfnotasbancarias.php";
document.form2.target="_BLANK";
document.form2.submit(); 
document.form2.action="";
document.form2.target="";
}
</script>
<script language="JavaScript1.2">
function adelante()
{
   //alert("adelante"+document.form2.ncomp.value);
//document.form2.oculto.value=2;
if(parseFloat(document.form2.ncomp.value)<parseFloat(document.form2.maximo.value))
 {
document.form2.oculto.value=1;
//document.form2.agregadet.value='';
//document.form2.elimina.value='';
document.form2.ncomp.value=parseFloat(document.form2.ncomp.value)+1;
document.form2.idcomp.value=parseFloat(document.form2.idcomp.value)+1;
document.form2.action="teso-editanotasbancariasppto.php";
document.form2.submit();
}
}
</script>
<script language="JavaScript1.2">
function atrasc()
{
	   //alert("atras"+document.form2.ncomp.value);
//document.form2.oculto.value=2;
if(document.form2.ncomp.value>1)
 {
document.form2.oculto.value=1;
//document.form2.agregadet.value='';
//document.form2.elimina.value='';
document.form2.ncomp.value=document.form2.ncomp.value-1;
document.form2.idcomp.value=document.form2.idcomp.value-1;
document.form2.action="teso-editanotasbancariasppto.php";
document.form2.submit();
 }
}
</script>
<script language="JavaScript1.2">
function validar2()
{
//   alert("Balance Descuadrado");
document.form2.oculto.value=1;
document.form2.ncomp.value=document.form2.idcomp.value;
//document.form2.agregadet.value='';
//document.form2.elimina.value='';
document.form2.action="teso-editanotasbancariasppto.php";
document.form2.submit();
}
</script>
<script src="css/programas.js"></script><script src="css/calendario.js"></script>
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
  <td colspan="3" class="cinta"><a href="teso-notasbancarias.php" ><img src="imagenes/add.png" alt="Nuevo"  border="0" /></a> <a href="#"  onClick="guardar();"><img src="imagenes/guarda.png"  alt="Guardar" /></a><a href="teso-buscanotasbancarias.php"> <img src="imagenes/busca.png"  alt="Buscar" border="0" /></a> <a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" alt="nueva ventana"></a><a href="#" onClick="pdf()"><img src="imagenes/print.png"  alt="Buscar" /></a> <a href="teso-actualizardocs.php"><img src="imagenes/iratras.png" alt="nueva ventana"></a></td>
</tr>		  
</table>
<tr>
<td colspan="3" class="tablaprin" align="center"> 
<?php
$linkbd=conectar_bd();
$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
$vigencia=$vigusu;
 ?>
<form name="form2" method="post" action=""> 
<?php
if(!$_POST[oculto])
{
$sqlr="select MAX(tesonotasbancarias_cab.id_notaban) from tesonotasbancarias_cab ";
$res=mysql_query($sqlr,$linkbd);
//echo $sqlr;
	$r=mysql_fetch_row($res);
	 $_POST[maximo]=$r[0];
	 $_POST[ncomp]=$r[0];
	 $_POST[idcomp]=$r[0];
}
		 $_POST[dccs]= array(); 
		 $_POST[ddocban]= array(); 
		 $_POST[dbancos]= array(); 
  		 $_POST[dnbancos]= array(); 
		 $_POST[dgbancarios]= array(); 
		 $_POST[dngbancarios]= array(); 
		 $_POST[dcbs]= array(); 
		 $_POST[dcts]= array(); 
		 $_POST[dvalores]= array(); 

	$sqlr="select *from tesonotasbancarias_cab left join tesonotasbancarias_det on  tesonotasbancarias_cab.id_notaban=tesonotasbancarias_det.id_notabancab where tesonotasbancarias_cab.id_notaban=$_POST[idcomp]";
 $cont=0;
 	$resp = mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($resp))
	{	 $_POST[idcomp]=$row[0];
		 $_POST[concepto]=$row[5]; 
		 $_POST[estadoc]=$row[4]; 
		 $_POST[fecha]=$row[2]; 	
		  	ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
	 $_POST[fecha]=$fechaf;
		 $_POST[dccs][]=$row[10];
		 $_POST[ddocban][]=$row[9];
		 $_POST[dcts][]=$row[12];
		 $ctaconban=buscabancocn($row[11],$row[12]);
		 $_POST[dbancos][]=$ctaconban;
		  $_POST[dgbancarios][]=$row[13];
		    $_POST[dngbancarios][]=$row[13]." - ".buscagastoban($row[13]);
		  $_POST[dnbancos][]=buscatercero($row[12]);
		 $_POST[dcbs][]=$row[11];		 
		 $_POST[dvalores][]=$row[15];		
         $_POST[cuenta]=$row[9];
		 $_POST[ncuenta]=buscacuentapres($row[9],2);
		 $_POST[vigencia]=$row[3];
		 $cont=$cont+1;
	} 
	 $sqlr="select *from tesonotasbancarias_cab where tesonotasbancarias_cab.id_notaban=$_POST[idcomp]";
$_POST[ids]=$_GET[is];
//echo $sqlr;
 $cont=0;
 	$resp = mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($resp))
	{	 $_POST[idcomp]=$row[0];
		 $_POST[concepto]=$row[5]; 
		 $_POST[fecha]=$row[2]; 		 	
		  	ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
	$_POST[vigencia]=$row[3];
	 $_POST[fecha]=$fechaf;

   }
?>
  <table class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="12"> Editar Nota Bancaria </td>
        <td  class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
      </tr>
      <tr  >    
        <td  class="saludo1" >Numero Comp:</td>
        <td ><a href="#" onClick="atrasc()"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a><input name="idcomp" type="text" size="5" value="<?php echo $_POST[idcomp]?>" onKeyUp="return tabular(event,this)"  onBlur="validar2()" ><input name="ncomp" type="hidden" value="<?php echo $_POST[ncomp]?>"><a href="#" onClick="adelante()"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> <input type="hidden" value="a" name="atras" ><input type="hidden" value="s" name="siguiente" ><input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo"></td><td width="122"  class="saludo1">Fecha:        </td>
        <td  ><input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10" size="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" readonly>  </td>    
        <td  class="saludo1">Concepto Nota:</td>
        <td colspan="3"><input name="concepto" type="text" value="<?php echo $_POST[concepto]?>" size="80" onKeyUp="return tabular(event,this)" readonly></td><td  class="saludo1">Vigencia:</td><td><input name="vigencia" size="4" type="text" value="<?php echo $_POST[vigencia] ?>" readonly></td> <td class="saludo1">Estado:</td>
		  <td colspan=1 > <input name="estadoc" type="text" id="estadoc" value="<?php echo $_POST[estadoc] ?>" size="5" readonly></td>
</tr>

	  </table>
	  
	  <div class="subpantalla">
	   <table class="inicio">
	   	   <tr><td colspan="7" class="titulos">Detalle Gastos Bancarios</td></tr>                  
		<tr><td class="titulos2">CC</td><td class="titulos2">Doc Bancario</td><td class="titulos2">Cuenta Bancaria</td><td class="titulos2">Banco</td><td class="titulos2">Gasto Bancario</td><td class="titulos2">Valor</td><td class="titulos2"><img src="imagenes/del.png"><input type='hidden' name='elimina' id='elimina'><input type="hidden" id="comp" name="comp" value="<?php echo $_POST[comp]?>" ><input name="oculto" type="hidden" id="oculto" value="1" ></td></tr>
		<?php 		
		if ($_POST[elimina]!='')
		 { 
		 //echo "<TR><TD>ENTROS :".$_POST[elimina]."</TD></TR>";
		 $posi=$_POST[elimina];
		 unset($_POST[dccs][$posi]);
		 unset($_POST[ddocban][$posi]);
		  unset($_POST[dbancos][$posi]);
		 unset($_POST[dnbancos][$posi]);
		 unset($_POST[dgbancarios][$posi]);	
		 unset($_POST[dngbancarios][$posi]);		 
 		 unset($_POST[dcbs][$posi]);	
 		 unset($_POST[dcts][$posi]);			 
		 unset($_POST[dvalores][$posi]);			  
		 $_POST[dccs]= array_values($_POST[dccs]); 
		 $_POST[ddocban]= array_values($_POST[ddocban]);  
		 $_POST[dbancos]= array_values($_POST[dbancos]); 
  		 $_POST[dnbancos]= array_values($_POST[dnbancos]); 
		 $_POST[dgbancarios]= array_values($_POST[dgbancarios]); 
		 $_POST[dngbancarios]= array_values($_POST[dngbancarios]); 		 
		 $_POST[dcbs]= array_values($_POST[dcbs]); 		 
		 $_POST[dcts]= array_values($_POST[dcts]); 		 		 
		 $_POST[dvalores]= array_values($_POST[dvalores]); 		 		 		 		 		 
		 }	 
		 if ($_POST[agregadet]=='1')
		 {
		 $_POST[dccs][]=$_POST[cc];
		 $_POST[ddocban][]=$_POST[numero];			 
		 $_POST[dbancos][]=$_POST[banco];		 
		 $_POST[dnbancos][]=$_POST[nbanco];	
		 $_POST[dgbancarios][]=$_POST[gastobancario];		
		 $_POST[dngbancarios][]=$_POST[ngastobancario];				  
		 $_POST[dcbs][]=$_POST[cb];
		 $_POST[dcts][]=$_POST[ct];
		  $_POST[dvalores][]=$_POST[valor];
		 $_POST[agregadet]=0;
		  ?>
		 <script>
		  		//document.form2.cuenta.focus();	
				document.form2.banco.value="";
				document.form2.nbanco.value="";
				document.form2.cb.value="";
				document.form2.valor.value="";	
				document.form2.numero.value="";				
				document.form2.numero.select();
		  		document.form2.numero.focus();	
		 </script>
		  <?php
		  }
		  $_POST[totalc]=0;
		 for ($x=0;$x<count($_POST[dbancos]);$x++)
		 {		 
		 echo "<tr><td class='saludo2'><input name='dccs[]' value='".$_POST[dccs][$x]."' type='text' size='4' readonly></td><td class='saludo2'><input name='ddocban[]' value='".$_POST[ddocban][$x]."' type='text' readonly></td><td class='saludo2'><input name='dcts[]' value='".$_POST[dcts][$x]."' type='hidden' ><input name='dbancos[]' value='".$_POST[dbancos][$x]."' type='hidden' ><input name='dcbs[]' value='".$_POST[dcbs][$x]."' type='text' size='45' readonly></td><td class='saludo2'><input name='dnbancos[]' value='".$_POST[dnbancos][$x]."' type='text' size='30' readonly></td><td class='saludo2'><input name='dngbancarios[]' value='".$_POST[dngbancarios][$x]."' type='text' size='50' readonly><input name='dgbancarios[]' value='".$_POST[dgbancarios][$x]."' type='hidden' ></td><td class='saludo2'><input name='dvalores[]' value='".$_POST[dvalores][$x]."' type='text' size='15' onKeyPress='javascript:return solonumeros(event)' ></td><td class='saludo2'><a href='#' onclick='eliminar($x)'><img src='imagenes/del.png'></a></td></tr>";
		 $_POST[totalc]=$_POST[totalc]+$_POST[dvalores][$x];
		 $_POST[totalcf]=number_format($_POST[totalc],2,".",",");
		 }
 			$resultado = convertir($_POST[totalc]);
			$_POST[letras]=$resultado." Pesos";
		 echo "<tr><td colspan='4'></td><td class='saludo2'>Total</td><td class='saludo2'><input name='totalcf' type='text' value='$_POST[totalcf]' readonly><input name='totalc' type='hidden' value='$_POST[totalc]'></td></tr><tr><td class='saludo1'>Son:</td><td colspan='5' ><input name='letras' type='text' value='$_POST[letras]' size='90'></td></tr>";
		?> 
	   </table></div>
	  <?php
if($_POST[oculto]=='2')
{
	$linkbd=conectar_bd();
		$p1=substr($_POST[fecha],0,2);
	$p2=substr($_POST[fecha],3,2);
	$p3=substr($_POST[fecha],6,4);
	$fechaf=$p3."-".$p2."-".$p1;	
	$bloq=bloqueos($_SESSION[cedulausu],$fechaf);	
	if($bloq>=1)
	{
 	//ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	//$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	//*********************CREACION DEL COMPROBANTE CONTABLE ***************************	
//***busca el consecutivo del comprobante contable
	$consec=0;
//***cabecera comprobante
//echo "es ".$_POST[estadoc];
if ($_POST[estadoc]=='S')
$esta=1;
else
$esta=0;
$consec=$_POST[idcomp];
 $sqlr="delete from pptocomprobante_cab where tipo_comp=20 and numerotipo=$_POST[idcomp] ";
	 mysql_query($sqlr,$linkbd);
	//echo $sqlr;
	  $sqlr="insert into  pptocomprobante_cab (numerotipo,tipo_comp,fecha,concepto,vigencia,total_debito,total_credito,diferencia,estado) values($consec,20,'$fechaf','NOTAS BANCARIAS',$_POST[vigencia],0,0,0,'$esta')";
	 	if(  mysql_query($sqlr,$linkbd))
		{
	//echo $sqlr;

	//******************* DETALLE DEL COMPROBANTE CONTABLE *********************
	 $sqlr="delete from pptocomprobante_det where tipo_comp=20 and numerotipo=$_POST[idcomp] ";
	 mysql_query($sqlr,$linkbd);
	
//	echo "$sqlr <br>";
	
	for($x=0;$x<count($_POST[dccs]);$x++)
	 {	 
	 //** Busca  Gastos Bancarios ****
	$sqlr="select tesogastosbancarios_det.*,tesogastosbancarios.tipo from tesogastosbancarios_det,tesogastosbancarios where tesogastosbancarios_det.tipoconce='GB' and tesogastosbancarios_det.modulo='4' and tesogastosbancarios_det.codigo='".$_POST[dgbancarios][$x]."' and tesogastosbancarios_det.estado='S' and tesogastosbancarios_det.vigencia='$vigusu' and tesogastosbancarios_det.codigo=tesogastosbancarios.codigo";
	echo "$sqlr";
	$res=mysql_query($sqlr,$linkbd);
	while($r=mysql_fetch_row($res))
	 {
	//******Busca el concepto contable de los gastos bancarios
		 //*****SI ES DE GASTO *****
		 if($r[8]=='G')
		  {
	      //**** NOTA  BANCARIA DETALLE CONTABLE*****
			if($r[5]!='')
			  {
				$sqlr="insert into pptonotasbanppto  (cuenta,idrecibo,valor,vigencia) values ('$r[5]',$consec,".$_POST[dvalores][$x].",'".$_POST[vigencia]."')";				
				mysql_query($sqlr,$linkbd);
				 $sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) values('".$r[5]."','".$_POST[dcts][$x]."','NOTAS BANCARIAS',".$_POST[dvalores][$x].",0,$esta,'$_POST[vigencia]',20,'$consec')";
	  mysql_query($sqlr,$linkbd); 	
			  }
		 }//*****FIN GASTO
		//*****SI ES DE INGRESO *****
		 if($r[8]=='I')
		  {
		  //**** NOTA  BANCARIA DETALLE CONTABLE*****
			if($r[5]!='')
			  {
				$sqlr="insert into pptonotasbanppto  (cuenta,idrecibo,valor,vigencia) values ('$r[5]',$consec,".$_POST[dvalores][$x].",'".$_POST[vigencia]."')";				
				mysql_query($sqlr,$linkbd);
				 $sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) values('".$r[5]."','".$_POST[dcts][$x]."','NOTAS BANCARIAS',".$_POST[dvalores][$x].",0,$esta,'$_POST[vigencia]',20,'$consec')";
	  mysql_query($sqlr,$linkbd); 	
			  }
		}//*****FIN INGRESO	  
	 }
	 
	}	
	 echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado la Nota con Exito <img src='imagenes/confirm.png'><script></script></center></td></tr></table>";
	}
	else
	{
		 echo "<table class='inicio'><tr><td class='saludo1'><center>No Se ha almacenado la Nota con Exito <img src='imagenes/alert.png'><script></script></center></td></tr></table>";
	}		  
  }
  else
   {
    echo "<div class='inicio'><img src='imagenes\alert.png'> No Tiene los Permisos para Modificar este Documento</div>";
   }
  //****fin if bloqueo  
}
?>	
</form>
 </td></tr>
</table>
</body>
</html>