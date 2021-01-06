<?php //V 1000 12/12/16 ?> 
<?php
require "comun.inc";
require "funciones.inc";
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
document.form2.action="teso-pdfrecaja.php";
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
document.form2.action="teso-recibocaja-regrabarppto.php";
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
document.form2.action="teso-recibocaja-regrabarppto.php";
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
document.form2.action="teso-recibocaja-regrabarppto.php";
document.form2.submit();
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
  <td colspan="3" class="cinta"><a href="teso-recibocaja-regrabarppto.php" ><img src="imagenes/add.png" alt="Nuevo"  border="0" /></a> <a href="#" onClick="guardar()"><img src="imagenes/guarda.png"  alt="Guardar" /></a><a href="teso-buscarecibocaja.php"> <img src="imagenes/busca.png"  alt="Buscar" /></a> <a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" alt="nueva ventana"></a> <a href="#"onClick="pdf()"> <img src="imagenes/print.png"  alt="Buscar" /></a> <a href="teso-actualizardocs.php"><img src="imagenes/iratras.png" alt="nueva ventana"></a></td>
</tr>		  
</table>
<tr>
<td colspan="3" class="tablaprin" align="center"> 
 <form name="form2" method="post" action=""> 
 
<?php
$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
$vigencia=$vigusu;
$linkbd=conectar_bd();
	$sqlr="select valor_inicial from dominios where nombre_dominio='CUENTA_CAJA'";
	//echo $sqlr;
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
	{
	 $_POST[cuentacaja]=$row[0];
//	 echo "cc";
	}
 ?>	
<?php
if(!$_POST[oculto])
{
$sqlr="select valor_inicial,valor_final, tipo from dominios where nombre_dominio='COBRO_RECIBOS' AND descripcion_valor='$vigusu' and  tipo='S'";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
	{
	 $_POST[cobrorecibo]=$row[0];
	 $_POST[vcobrorecibo]=$row[1];
	 $_POST[tcobrorecibo]=$row[2];	 
	}
}


	  //*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
$sqlr="select id_recibos,id_recaudo from  tesoreciboscaja ORDER BY id_recibos DESC";
$res=mysql_query($sqlr,$linkbd);
//echo $sqlr;
	$r=mysql_fetch_row($res);
	 $_POST[maximo]=$r[0];
if(!$_POST[oculto])
{
	$check1="checked";
	$fec=date("d/m/Y");
	$_POST[vigencia]=$vigencia;
$sqlr="select id_recibos,id_recaudo from  tesoreciboscaja ORDER BY id_recibos DESC";
$res=mysql_query($sqlr,$linkbd);
//echo $sqlr;
	$r=mysql_fetch_row($res);
	 $_POST[maximo]=$r[0];
	 $_POST[ncomp]=$r[0];
	 $_POST[idcomp]=$r[0];
	 $_POST[idrecaudo]=$r[1];	 
}
//echo "Ncomp: ".$_POST[ncomp];
 $sqlr="select * from tesoreciboscaja where id_recibos=$_POST[idcomp]";
 $res=mysql_query($sqlr,$linkbd);
// echo $sqlr;
		while($r=mysql_fetch_row($res))
		 {		  
		  $_POST[tiporec]=$r[10];
		  $_POST[idrecaudo]=$r[4];
		  $_POST[ncomp]=$r[0];
		  $_POST[modorec]=$r[5];	
		 }
//echo "ncomp: ".$_POST[ncomp];
//echo " mrec: ".$_POST[modorec];
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
<input name="cobrorecibo" type="hidden" value="<?php echo $_POST[cobrorecibo]?>" >
 <input name="vcobrorecibo" type="hidden" value="<?php echo $_POST[vcobrorecibo]?>" >
 <input name="tcobrorecibo" type="hidden" value="<?php echo $_POST[tcobrorecibo]?>" > 
 <input name="encontro" type="hidden" value="<?php echo $_POST[encontro]?>" >
  <input name="codcatastral" type="hidden" value="<?php echo $_POST[codcatastral]?>" >
 <?php 

	switch($_POST[tiporec]) 
  	 {
	  case 1:
	  $sqlr="select *from tesoliquidapredial where tesoliquidapredial.idpredial=$_POST[idrecaudo] and  1=$_POST[tiporec]";
  		//echo "$sqlr";
  	  $_POST[encontro]="";
	  $res=mysql_query($sqlr,$linkbd);
		while ($row =mysql_fetch_row($res)) 
	 	{
		$_POST[codcatastral]=$row[1];		
	  	$_POST[concepto]=$row[17].' Cod Catastral No '.$row[1];	
//		$_POST[modorec]=$row[24];
	  	$_POST[valorecaudo]=$row[8];		
	  	$_POST[totalc]=$row[8];	
	  	$_POST[tercero]=$row[4];	
	  	$_POST[ntercero]=buscatercero($row[4]);		
		if ($_POST[ntercero]=='')
		 {
		  $sqlr2="select *from tesopredios where cedulacatastral='".$row[1]."' ";
		  $resc=mysql_query($sqlr2,$linkbd);
		  $rowc =mysql_fetch_row($resc);
		   $_POST[ntercero]=$rowc[6];
		 }	
	  	$_POST[encontro]=1;
		}
		$sqlr="select *from tesoreciboscaja where  id_recibos=$_POST[idcomp] ";
		$res=mysql_query($sqlr,$linkbd);
		$row =mysql_fetch_row($res); 
		//$_POST[idcomp]=$row[0];
		$_POST[fecha]=$row[2];
		$_POST[estadoc]=$row[9];
		   if ($row[9]=='N')
		   {$_POST[estado]="ANULADO";
		   $_POST[estadoc]='0';
		   }
		   else
		   {
			   $_POST[estadoc]='1';
			   $_POST[estado]="ACTIVO";
		   }
						$_POST[modorec]=$row[5];
							$_POST[banco]=$row[7];	
        ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
	   $_POST[fecha]=$fecha[3]."/".$fecha[2]."/".$fecha[1];

	  break;
	  
	  case 2:
	  $sqlr="select *from tesoindustria where tesoindustria.id_industria=$_POST[idrecaudo]  and 2=$_POST[tiporec]";
  		//echo "$sqlr";
  	  $_POST[encontro]="";
	  $res=mysql_query($sqlr,$linkbd);
		while ($row =mysql_fetch_row($res)) 
	 	{
	  	$_POST[concepto]="Liquidacion Industria y Comercio avisos y tableros - ".$row[3];	
	  	$_POST[valorecaudo]=$row[6];		
	  	$_POST[totalc]=$row[6];	
	  	$_POST[tercero]=$row[5];	
	  	$_POST[ntercero]=buscatercero($row[5]);	
//				$_POST[modorec]=$row[13];
	  	$_POST[encontro]=1;
	 	}
		$sqlr="select *from tesoreciboscaja where  id_recibos=$_POST[idcomp] ";
		$res=mysql_query($sqlr,$linkbd);
		$row =mysql_fetch_row($res); 
		//$_POST[idcomp]=$row[0];
		$_POST[fecha]=$row[2];
		$_POST[estadoc]=$row[9];
		   if ($row[9]=='N')
		   {$_POST[estado]="ANULADO";
		   $_POST[estadoc]='0';
		   }
		   else
		   {
			   $_POST[estadoc]='1';
			   $_POST[estado]="ACTIVO";
		   }
        ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
	   $_POST[fecha]=$fecha[3]."/".$fecha[2]."/".$fecha[1];
	   		$_POST[modorec]=$row[5];
			$_POST[banco]=$row[7];
	  break;
	  
	  case 3:
	  $sqlr="select *from tesorecaudos where tesorecaudos.id_recaudo=$_POST[idrecaudo] and 3=$_POST[tiporec]";
  		//echo "$sqlr";
  	  $_POST[encontro]="";
	  $res=mysql_query($sqlr,$linkbd);
		while ($row =mysql_fetch_row($res)) 
	 	{
	  	$_POST[concepto]=$row[6];	
	  	$_POST[valorecaudo]=$row[5];		
	  	$_POST[totalc]=$row[5];	
	  	$_POST[tercero]=$row[4];	
	  	$_POST[ntercero]=buscatercero($row[4]);			
	  	$_POST[encontro]=1;
	 	}
		$sqlr="select *from tesoreciboscaja where  id_recibos=$_POST[idcomp] ";
		$res=mysql_query($sqlr,$linkbd);
		$row =mysql_fetch_row($res); 
		//echo "$sqlr";
		//$_POST[idcomp]=$row[0];
		$_POST[fecha]=$row[2];
		$_POST[estadoc]=$row[9];
		   if ($row[9]=='N')
		   {$_POST[estado]="ANULADO";
		   $_POST[estadoc]='0';
		   }
		   else
		   {
			   $_POST[estadoc]='1';
			   $_POST[estado]="ACTIVO";
		   }

				$_POST[modorec]=$row[5];
					$_POST[banco]=$row[7];
        ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
	   $_POST[fecha]=$fecha[3]."/".$fecha[2]."/".$fecha[1];
	   //echo "mre:".$_POST[modorec];
		break;	
	}

 ?>
    <table class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="9">Regrabar Recibo de Caja Ppto</td>
        <td width="68" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
      </tr>
      <tr  >
        <td  class="saludo1" >No Recibo:</td>
        <td width="203"  > <a href="#" onClick="atrasc()"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a> <input name="cuentacaja" type="hidden" value="<?php echo $_POST[cuentacaja]?>" ><input name="idcomp" type="text" size="5" value="<?php echo $_POST[idcomp]?>" onKeyUp="return tabular(event,this) "  onBlur="validar2()"  ><input name="ncomp" type="hidden" value="<?php echo $_POST[ncomp]?>"><a href="#" onClick="adelante()"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> <input type="hidden" value="a" name="atras" ><input type="hidden" value="s" name="siguiente" ><input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo"></td>
	  <td width="103"   class="saludo1">Fecha:        </td>
        <td width="229" ><input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10" size="10"  onKeyDown="mascara(this,'/',patron,true)"  onKeyUp="return tabular(event,this)">        </td>
         <td width="101" class="saludo1">Vigencia:</td>
		  <td width="350"><input type="text" id="vigencia" name="vigencia" size="8" onKeyPress="javascript:return solonumeros(event)" 
		  onKeyUp="return tabular(event,this)"  value="<?php echo $_POST[vigencia]?>" onClick="document.getElementById('tipocta').focus();document.getElementById('tipocta').select();" readonly>   <input type="text" name="estado" value="<?php echo $_POST[estado] ?>" size="5" readonly>  <input type="hidden" name="estadoc" value="<?php echo $_POST[estadoc] ?>">      
        </tr>
      <tr><td class="saludo1"> Recaudo:</td><td> <select name="tiporec" id="tiporec" onKeyUp="return tabular(event,this)" onChange="validar()" >
         <option value="1" <?php if($_POST[tiporec]=='1') echo "SELECTED"; ?>>Predial</option>
          <option value="2" <?php if($_POST[tiporec]=='2') echo "SELECTED"; ?>>Industria y Comercio</option>
          <option value="3" <?php if($_POST[tiporec]=='3') echo "SELECTED"; ?>>Otros Recaudos</option>
        </select>
          </td>
          <?php
		  $sqlr="";
		  ?>
        <td class="saludo1">No Liquid:</td><td><input type="text" id="idrecaudo" name="idrecaudo" value="<?php echo $_POST[idrecaudo]?>" size="30" onKeyUp="return tabular(event,this)" onChange="validar()" readonly> </td>
	 <td class="saludo1">Recaudado en:</td><td> <select name="modorec" id="modorec" onKeyUp="return tabular(event,this)" onChange="validar()" >
         <option value="caja" <?php if($_POST[modorec]=='caja') echo "SELECTED"; ?>>Caja</option>
          <option value="banco" <?php if($_POST[modorec]=='banco') echo "SELECTED"; ?>>Banco</option>
        </select>
        <?php
		  if ($_POST[modorec]=='banco')
		   {
		?>
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
       <input name="cb" type="hidden" value="<?php echo $_POST[cb]?>" ><input type="hidden" id="ter" name="ter" value="<?php echo $_POST[ter]?>" >           </td><td> <input type="text" id="nbanco" name="nbanco" value="<?php echo $_POST[nbanco]?>" size="40" readonly>
          </td>
        <?php
		   }
		?> 
       </tr>
	  <tr><td class="saludo1" width="71">Concepto:</td><td colspan="5"><input name="concepto" size="90" type="text" value="<?php echo $_POST[concepto] ?>" onKeyUp="return tabular(event,this)"></td></tr>
      <tr><td class="saludo1" width="71">Valor:</td><td><input type="text" id="valorecaudo" name="valorecaudo" value="<?php echo $_POST[valorecaudo]?>" size="30" onKeyUp="return tabular(event,this)" readonly ></td><td  class="saludo1">Documento: </td>
        <td ><input name="tercero" type="text" value="<?php echo $_POST[tercero]?>" size="20" onKeyUp="return tabular(event,this)" readonly>
         </td>
			  <td class="saludo1">Contribuyente:</td>
	  <td  ><input type="text" id="ntercero" name="ntercero" value="<?php echo $_POST[ntercero]?>" size="50" onKeyUp="return tabular(event,this) "  readonly><input type="hidden" id="cb" name="cb" value="<?php echo $_POST[cb]?>" ><input type="hidden" id="ct" name="ct" value="<?php echo $_POST[ct]?>" >
	  </td><td>
	    <input type="hidden" value="1" name="oculto">
		<input type="hidden" value="<?php echo $_POST[trec]?>"  name="trec">
	    <input type="hidden" value="0" name="agregadet"></td></tr>
     
      </table>
     <div class="subpantallac7">
      <?php 
 if($_POST[encontro]=='1')
 {
  switch($_POST[tiporec]) 
  	 {
	  case 1: //********PREDIAL
	   $sqlr="select *from tesoliquidapredial_det where tesoliquidapredial_det.idpredial=$_POST[idrecaudo] and estado ='S'  and 1=$_POST[tiporec]";
		 // echo "$sqlr";
		 $_POST[dcoding]= array(); 		 
		 $_POST[dncoding]= array(); 		 
		 $_POST[dvalores]= array(); 	
		 if($_POST[tcobrorecibo]=='S')
		 {	 
		 $_POST[dcoding][]=$_POST[cobrorecibo];
		 $_POST[dncoding][]=buscaingreso($_POST[cobrorecibo])." ".$vigusu;			 		
    	 $_POST[dvalores][]=$_POST[vcobrorecibo];
		 }
		 $_POST[trec]='PREDIAL';	 
 	 	$res=mysql_query($sqlr,$linkbd);
//*******************CREANDO EL RECIBO DE CAJA DE PREDIAL ***********************
		while ($row =mysql_fetch_row($res)) 
		{
		$vig=$row[1];
		if($vig==$vigusu)
		 {
		$sqlr2="select * from tesoingresos where codigo='01'";
		$res2=mysql_query($sqlr2,$linkbd);
		$row2 =mysql_fetch_row($res2); 
		$_POST[dcoding][]=$row2[0];
		$_POST[dncoding][]=$row2[1]." ".$vig;			 		
    	$_POST[dvalores][]=$row[11];		 
			//	echo "Vig:$vig valor:$row[11] codigo:".$row2[0];
	 	}
		 else
	   	 {	
		$sqlr2="select * from tesoingresos where codigo='03'";
		$res2=mysql_query($sqlr2,$linkbd);
		$row2 =mysql_fetch_row($res2); 
		$_POST[dcoding][]=$row2[0];
		$_POST[dncoding][]=$row2[1]." ".$vig;			 		
	    $_POST[dvalores][]=$row[11];		
				//		echo "Vig:$vig valor:$row[11] codigo:".$row2[0];
		 }
		 
	}  
	  break;
	  
	  case 2: //***********INDUSTRIA Y COMERCIO
 $_POST[dcoding]= array(); 		 
		 $_POST[dncoding]= array(); 		 
		 $_POST[dvalores]= array(); 	
	  		 $_POST[trec]='INDUSTRIA Y COMERCIO';	 
		if($_POST[tcobrorecibo]=='S')
		 {	 
		 $_POST[dcoding][]=$_POST[cobrorecibo];
		 $_POST[dncoding][]=buscaingreso($_POST[cobrorecibo])." ".$vigusu;			 		
    	 $_POST[dvalores][]=$_POST[vcobrorecibo];
		 }
			 
		$sqlr="select *from tesoindustria where tesoindustria.id_industria=$_POST[idrecaudo] and  2=$_POST[tiporec]";
  	//echo "$sqlr";
	  $res=mysql_query($sqlr,$linkbd);
		while ($row =mysql_fetch_row($res)) 
	 	{
		$sqlr2="select * from tesoingresos where codigo='02'";
	  $res2=mysql_query($sqlr2,$linkbd);
		$row2 =mysql_fetch_row($res2);
 		$_POST[dcoding][]=$row2[0];
		$_POST[dncoding][]=$row2[1];			 		
	    $_POST[dvalores][]=$row[6];		
		}
	  break;
	  
	  case 3: ///*****************otros recaudos *******************
	  		 $_POST[trec]='OTROS RECAUDOS';	 
//  $sqlr="select *from tesorecaudos_det where tesorecaudos_det.id_recaudo=$_POST[idrecaudo]   and 3=$_POST[tiporec]";
	  $sqlr="Select *from tesoreciboscaja_det where tesoreciboscaja_det.id_recibos=$_POST[idcomp]";
//  echo "$sqlr";
		 $_POST[dcoding]= array(); 		 
		 $_POST[dncoding]= array(); 		 
		 $_POST[dvalores]= array(); 	
/*		if($_POST[tcobrorecibo]=='S')
		 {	 
		 $_POST[dcoding][]=$_POST[cobrorecibo];
		 $_POST[dncoding][]=buscaingreso($_POST[cobrorecibo])." ".$vigusu;			 		
    	 $_POST[dvalores][]=$_POST[vcobrorecibo];
		 }	 */
  $res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
	{	
	$_POST[dcoding][]=$row[2];
	$sqlr2="select nombre from tesoingresos where  codigo='".$row[2]."'";
	$res2=mysql_query($sqlr2,$linkbd);
	//echo "$sqlr2";
	$row2 =mysql_fetch_row($res2); 
	$_POST[dncoding][]=$row2[0];			 		
    $_POST[dvalores][]=$row[3];		 	
	}
	break;
   }
 }
 ?>
	   <table class="inicio">
	   	   <tr><td colspan="4" class="titulos">Detalle Recibo de Caja</td></tr>                  
		<tr><td class="titulos2">Codigo</td><td class="titulos2">Ingreso</td><td class="titulos2">Valor</td></tr>
		<?php 		
		if ($_POST[elimina]!='')
		 { 
		 //echo "<TR><TD>ENTROS :".$_POST[elimina]."</TD></TR>";
		 $posi=$_POST[elimina];
		  
 		 unset($_POST[dcoding][$posi]);	
 		 unset($_POST[dncoding][$posi]);			 
		 unset($_POST[dvalores][$posi]);			  		 
		 $_POST[dcoding]= array_values($_POST[dcoding]); 		 
		 $_POST[dncoding]= array_values($_POST[dncoding]); 		 		 
		 $_POST[dvalores]= array_values($_POST[dvalores]); 		 		 		 		 		 
		 }	 
		 if ($_POST[agregadet]=='1')
		 {
		 $_POST[dcoding][]=$_POST[codingreso];
		 $_POST[dncoding][]=$_POST[ningreso];			 		
		  $_POST[dvalores][]=$_POST[valor];
		 $_POST[agregadet]=0;
		  ?>
		 <script>
		  		//document.form2.cuenta.focus();	
				document.form2.codingreso.value="";
				document.form2.valor.value="";	
				document.form2.ningreso.value="";				
				document.form2.codingreso.select();
		  		document.form2.codingreso.focus();	
		 </script>
		  <?php
		  }
		  $_POST[totalc]=0;
		 for ($x=0;$x<count($_POST[dcoding]);$x++)
		 {		 
		 echo "<tr><td class='saludo1'><input name='dcoding[]' value='".$_POST[dcoding][$x]."' type='text' size='4'></td><td class='saludo1'><input name='dncoding[]' value='".$_POST[dncoding][$x]."' type='text' size='90'></td><td class='saludo1'><input name='dvalores[]' value='".$_POST[dvalores][$x]."' type='text' size='15'></td></tr>";
		 $_POST[totalc]=$_POST[totalc]+$_POST[dvalores][$x];
		 $_POST[totalcf]=number_format($_POST[totalc],2);
		 }
 			$resultado = convertir($_POST[totalc]);
			$_POST[letras]=$resultado." PESOS M/CTE";
		 echo "<tr><td></td><td class='saludo2'>Total</td><td class='saludo1'><input name='totalcf' type='text' value='$_POST[totalcf]'><input name='totalc' type='hidden' value='$_POST[totalc]'></td></tr><tr><td class='saludo1'>Son:</td><td colspan='5' ><input name='letras' type='text' value='$_POST[letras]' size='90'></td></tr>";
		?> 
	   </table></div>
	  <?php
if($_POST[oculto]=='2')
{
	$linkbd=conectar_bd();
		ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	$bloq=bloqueos($_SESSION[cedulausu],$fechaf);	
	if($bloq>=1)
	{						
	//************VALIDAR SI YA FUE GUARDADO ************************
	switch($_POST[tiporec]) 
  	 {
	  case 1://***** PREDIAL *****************************************
//	  echo 'PREDIAL';
	  $sqlr="select count(*) from tesoreciboscaja where id_recaudo=$_POST[idrecaudo] and tipo='1' ";
		$res=mysql_query($sqlr,$linkbd);
		//echo $sqlr;
		while($r=mysql_fetch_row($res))
		 {
			$numerorecaudos=$r[0];
		 }
	  if($numerorecaudos>=0)
	   { 	
     $sqlr="delete from pptocomprobante_cab where numerotipo=$_POST[idcomp] and tipo_comp='16'";
	  mysql_query($sqlr,$linkbd);
	    $sqlr="delete from pptocomprobante_det where  numerotipo=$_POST[idcomp] and tipo_comp='16'";
		//echo $sqlr;
		mysql_query($sqlr,$linkbd);
		$sqlr="delete from pptosinrecibocajappto where idrecibo=$_POST[idcomp]";
		//echo $sqlr;		
		mysql_query($sqlr,$linkbd);
		   $sqlr="insert into  pptocomprobante_cab (numerotipo,tipo_comp,fecha,concepto,vigencia,total_debito,total_credito,diferencia,estado) values($_POST[idcomp],16,'$fechaf','RECIBO DE CAJA',$_POST[vigencia],0,0,0,'$_POST[estadoc]')";
		   		mysql_query($sqlr,$linkbd);
				//echo $sqlr;
		   if($_POST[modorec]=='caja')
			  	{				 
					$cuentacb=$_POST[cuentacaja];
					$cajas=$_POST[cuentacaja];
					$cbancos="";
			  	}
				if($_POST[modorec]=='banco')
			    {
					$cuentacb=$_POST[banco];				
					$cajas="";
					$cbancos=$_POST[banco];
			    }	   
		      ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
			  $fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	   
	   
	   	//************ insercion de cabecera recaudos ************
		 $concecc=$_POST[idcomp];
		 //echo "ccc".$concecc;
		 echo "<input type='hidden' name='concec' value='$concecc'>";	
		  echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado el Recibo de Caja con Exito <img src='imagenes/confirm.png'><script></script></center></td></tr></table>";
		  $sqlr="update tesoliquidapredial set estado='P' WHERE idpredial=$_POST[idrecaudo]";
		  mysql_query($sqlr,$linkbd);
		  $sqlr="Select *from tesoliquidapredial_det where idpredial=$_POST[idrecaudo]";
		  $resq=mysql_query($sqlr,$linkbd);
		  //echo "<br>$sqlr";
		  while($rq=mysql_fetch_row($resq))
 		  {
		   $sqlr2="update tesoprediosavaluos set pago='S' where codigocatastral=(select codigocatastral from tesoliquidapredial WHERE   idpredial=$_POST[idrecaudo]) AND vigencia=$rq[1]";
		   mysql_query($sqlr2,$linkbd);
		   		//  echo "<br>$sqlr2";				
		  }
		  ?>
		  <script>
		  document.form2.numero.value="";
		  document.form2.valor.value=0;
		  </script>
		  <?php		  			 
	//**********************CREANDO COMPROBANTE CONTABLE ********************************	 		 
		 
		 //		 echo "<BR>".$sqlr;		 
		 $sqlrs="select *from tesoliquidapredial_det where tesoliquidapredial_det.idpredial=$_POST[idrecaudo] and estado ='S'  and 1=$_POST[tiporec]";
		 $res=mysql_query($sqlrs,$linkbd);	
		 $rowd==mysql_fetch_row($res);
		 $tasadesc=($rowd[6]/100);
		 $sqlrs="select *from tesoliquidapredial_det where tesoliquidapredial_det.idpredial=$_POST[idrecaudo] and estado ='S'  and 1=$_POST[tiporec]";
		 $res=mysql_query($sqlrs,$linkbd);		 
		// echo "<BR>".$sqlrs;		 
//*******************CREANDO EL RECIBO DE CAJA DE PREDIAL ***********************
		while ($row =mysql_fetch_row($res)) 
		{
		$vig=$row[1];
		$vlrdesc=$row[10];
		if($vig==$vigusu) //*************VIGENCIA ACTUAL *****************
		 {
				 		// $tasadesc=round($row[10]/($row[4]+$row[6]),1);		
		 $idcomp=mysql_insert_id();
		// echo "<input type='hidden' name='ncomp' value='$idcomp'>";	
		  $sqlr="update tesoreciboscaja set id_comp=$idcomp WHERE id_recaudo=$_POST[idrecaudo] and tipo='1'";
		  mysql_query($sqlr,$linkbd);
		$sqlr2="select * from tesoingresos_DET where codigo='01' AND MODULO='4' and vigencia=$vigusu";
		$res2=mysql_query($sqlr2,$linkbd);
				// echo "<BR>".$sqlr2;				 
				 //****** $cuentacb   ES LA CUENTA CAJA O BANCO
		while($rowi =mysql_fetch_row($res2))
		 {
			// echo "<br>conc: ".$rowi[2];
		  switch($rowi[2])
		   {
			case '01': //***  VALOR PREDIAL
			//**** busca descuento PREDIAL
					$sqlrds="select * from tesoingresos_DET where codigo='01' and concepto='P01' AND MODULO='4' and vigencia=$vigusu";					
					$resds=mysql_query($sqlrds,$linkbd);
					while($rowds =mysql_fetch_row($resds))
		   			{
					 $descpredial=round($vlrdesc*round($rowds[5]/100,2),2);
				//	 echo "<BR>$vlrdesc*($rowds[5]/100) desc".$descpredial;
					}
							 
			//****			
				 $sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 $resc=mysql_query($sqlrc,$linkbd);	  
				 		 //echo "<BR>".$sqlrc;
				 while($rowc=mysql_fetch_row($resc))
				 {
			  	$porce=$rowi[5];
				if($rowc[6]=='S')
			 	  {				 
					$valorcred=$row[4];
					$valordeb=$row[4];					
					if($rowc[3]=='N')
				    {
				 	 if($valorcred>0)
					  {
//							 echo "<BR>round($valorcred-($descpredial*$valorcred))";
					     //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$valordeb-$descpredial;
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
			  if($rowi[6]!="")
			  {
			   $sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) values('".$rowi[6]."','".$_POST[tercero]."','RECIBO DE CAJA',".$vi.",0,'$_POST[estadoc]','$_POST[vigencia]',16,'$concecc')";
	  mysql_query($sqlr,$linkbd); 		
			  }

		//	echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL		
					  }
					}
				  }
				 }
			break;  
			case '02': //***
			 $sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 $resc=mysql_query($sqlrc,$linkbd);	  
				 		// echo "<BR>".$sqlrc;
				 while($rowc=mysql_fetch_row($resc))
				 {
			  	$porce=$rowi[5];
				if($rowc[6]=='S')
			 	  {				 
					$valorcred=$row[8];
					$valordeb=$row[8];					
					if($rowc[3]=='N')
				    {
				 	 if($valorcred>0)
					  {
							// echo "<BR>".$sqlr;							
					  //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$valordeb;
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
			  if($rowi[6]!="")
			  {
			   $sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) values('".$rowi[6]."','".$_POST[tercero]."','RECIBO DE CAJA',".$vi.",0,'$_POST[estadoc]','$_POST[vigencia]',16,'$concecc')";
	  mysql_query($sqlr,$linkbd); 		
			  }

//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL			
					  }
					}
				  }
				 }
			
			break;  
			case '03': 			
					$sqlrds="select * from tesoingresos_DET where codigo='01' and concepto='P10' AND MODULO='4' and vigencia=$vigusu";
					$resds=mysql_query($sqlrds,$linkbd);
					while($rowds =mysql_fetch_row($resds))
		   			{
					 $descpredial=round($vlrdesc*round($rowds[5]/100,2),2);
		//	 echo "<BR>$vlrdesc*($rowds[5]/100) desc".$descpredial;
					}

			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 $resc=mysql_query($sqlrc,$linkbd);	  
				 		// echo "<BR>".$sqlrc;
				 while($rowc=mysql_fetch_row($resc))
				 {
			  	$porce=$rowi[5];
				if($rowc[6]=='S')
			 	  {				 
					$valorcred=$row[6];
					$valordeb=$row[6];					
					if($rowc[3]=='N')
				    {
				 	 if($valorcred>0)
					  {
							// echo "<BR>".$sqlr;
							
					  //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$valordeb-$descpredial;
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
			  if($rowi[6]!="")
			  {
			   $sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) values('".$rowi[6]."','".$_POST[tercero]."','RECIBO DE CAJA',".$vi.",0,'$_POST[estadoc]','$_POST[vigencia]',16,'$concecc')";
	  mysql_query($sqlr,$linkbd); 		
			  }
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL			
					  }
					}
				  }
				 }
			break;  
			case 'P10': 
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 $resc=mysql_query($sqlrc,$linkbd);	  
				 		// echo "<BR>".$sqlrc;
				 while($rowc=mysql_fetch_row($resc))
				 {
			  	$porce=$rowi[5];
				if($rowc[6]=='S')
			 	  {				 
					$valordeb=round($row[10]*($porce/100),2);
//					$valorcred=round($row[10]*($porce/100),2);		
					//echo "<BR>$row[10] $porce ".$valordeb;			
					if($rowc[3]=='N')
				    {
				 	 if($valordeb>0)
					  {						
					//		 echo "<BR>".$sqlr;
							  //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$valordeb;
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
			  if($rowi[6]!="")
			  {
			   $sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) values('".$rowi[6]."','".$_POST[tercero]."','RECIBO DE CAJA',".$vi.",0,'$_POST[estadoc]','$_POST[vigencia]',16,'$concecc')";
	  mysql_query($sqlr,$linkbd); 		
			  }
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL	
					  }
					}
				  }
				 }
			break;  
			case 'P01': 
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 $resc=mysql_query($sqlrc,$linkbd);	  
				 		// echo "<BR>".$sqlrc;
				 while($rowc=mysql_fetch_row($resc))
				 {
			  	$porce=$rowi[5];
				if($rowc[6]=='S')
			 	  {				 
					$valordeb=round($row[10]*$porce/100,2);
					// echo "<BR>".$valordeb." round($row[10]*$porce/100,0)";
					$valorcred=0;					
					if($rowc[3]=='N')
				    {
				 	 if($valordeb>0)
					  {						
							// echo "<BR>".$sqlr;
							  //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$valordeb;
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
		  if($rowi[6]!="")
			  {
			   $sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) values('".$rowi[6]."','".$_POST[tercero]."','RECIBO DE CAJA',".$vi.",0,'$_POST[estadoc]','$_POST[vigencia]',16,'$concecc')";
	  mysql_query($sqlr,$linkbd); 		
			  }
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL	
					  }
					}
				  }
				 }
			break;  
			case 'P02': 
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 $resc=mysql_query($sqlrc,$linkbd);	  
				 		// echo "<BR>".$sqlrc;
				 while($rowc=mysql_fetch_row($resc))
				 {
			  	$porce=$rowi[5];
				if($rowc[6]=='S')
			 	  {				 
					$valorcred=$row[5];
					$valordeb=$valorcred;					
					if($rowc[3]=='N')
				    {
				 	 if($valorcred>0)
					  {
							// echo "<BR>".$sqlr;
							  //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$valordeb;
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
		  if($rowi[6]!="")
			  {
			   $sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) values('".$rowi[6]."','".$_POST[tercero]."','RECIBO DE CAJA',".$vi.",0,'$_POST[estadoc]','$_POST[vigencia]',16,'$concecc')";
	  mysql_query($sqlr,$linkbd); 		
			  }

//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL	
					  }
					}
				  }
				 }
			break;  
			case 'P04': 
			
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 $resc=mysql_query($sqlrc,$linkbd);	  
				 		// echo "<BR>".$sqlrc;
				 while($rowc=mysql_fetch_row($resc))
				 {
			  	$porce=$rowi[5];
				if($rowc[6]=='S')
			 	  {				 
					$valorcred=$row[7];
					$valordeb=$valorcred;					
					if($rowc[3]=='N')
				    {
				 	 if($valorcred>0)
					  {						
							// echo "<BR>".$sqlr;
							
							  //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$valordeb;
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
		  if($rowi[6]!="")
			  {
			   $sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) values('".$rowi[6]."','".$_POST[tercero]."','RECIBO DE CAJA',".$vi.",0,'$_POST[estadoc]','$_POST[vigencia]',16,'$concecc')";
	  mysql_query($sqlr,$linkbd); 		
			  }
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL	
					  }
					}
				  }
				 }
			break;  
			case 'P05': 
			
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 $resc=mysql_query($sqlrc,$linkbd);	  
				 		// echo "<BR>".$sqlrc;
				 while($rowc=mysql_fetch_row($resc))
				 {
			  	$porce=$rowi[5];
				if($rowc[6]=='S')
			 	  {				 
					$valorcred=$row[6];
					$valordeb=$valorcred;					
					if($rowc[3]=='N')
				    {
				 	 if($valorcred>0)
					  {						
							// echo "<BR>".$sqlr;
							
							  //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$valordeb;
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
		  if($rowi[6]!="")
			  {
			   $sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) values('".$rowi[6]."','".$_POST[tercero]."','RECIBO DE CAJA',".$vi.",0,'$_POST[estadoc]','$_POST[vigencia]',16,'$concecc')";
	  mysql_query($sqlr,$linkbd); 		
			  }

//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL	
					  }
					}
				  }
				 }
			break;  
			case 'P07': 
			
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 $resc=mysql_query($sqlrc,$linkbd);	  
				 		// echo "<BR>".$sqlrc;
				 while($rowc=mysql_fetch_row($resc))
				 {
			  	$porce=$rowi[5];
				if($rowc[6]=='S')
			 	  {				 
					$valorcred=$row[9];
					$valordeb=$valorcred;					
					if($rowc[3]=='N')
				    {
				 	 if($valorcred>0)
					  {						
							// echo "<BR>".$sqlr;
							
							  //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$valordeb;
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
		  if($rowi[6]!="")
			  {
			   $sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) values('".$rowi[6]."','".$_POST[tercero]."','RECIBO DE CAJA',".$vi.",0,'$_POST[estadoc]','$_POST[vigencia]',16,'$concecc')";
	  mysql_query($sqlr,$linkbd); 		
			  }

//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL	
					  }
					}
				  }
				 }
			break;  
			case 'P08': 
			
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 $resc=mysql_query($sqlrc,$linkbd);	  
				 		// echo "<BR>".$sqlrc;
				 while($rowc=mysql_fetch_row($resc))
				 {
			  	$porce=$rowi[5];
				if($rowc[6]=='S')
			 	  {				 
					$valorcred=0;
					$valordeb=$row[8];					
				  }
				 if($rowc[6]=='N')
			 	  {				 
					$valorcred=$row[8];
					$valordeb=0;					
				  }
					if($rowc[3]=='N')
				    {
							// echo "<BR>".$sqlr;
							
							  //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$row[8];
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
		  if($rowi[6]!="")
			  {
			   $sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) values('".$rowi[6]."','".$_POST[tercero]."','RECIBO DE CAJA',".$vi.",0,'$_POST[estadoc]','$_POST[vigencia]',16,'$concecc')";
	  mysql_query($sqlr,$linkbd); 		
			  }

//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL	
				   }
				 }
			break; 
			} 
			//echo "<br>".$sqlr;
		 }
		$_POST[dcoding][]=$row2[0];
		$_POST[dncoding][]=$row2[1]." ".$vig;			 		
    	$_POST[dvalores][]=$row[11];		 
			//	echo "Vig:$vig valor:$row[11] codigo:".$row2[0];
	 	}
		 else  ///***********OTRAS VIGENCIAS ***********
	   	 {	
			 		 $tasadesc=$row[10]/($row[4]+$row[6]);
		// $sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($concecc,5,'$fechaf','$_POST[concepto]',0,$_POST[totalc],$_POST[totalc],0,'1')";
		 //mysql_query($sqlr,$linkbd);
		// echo "<BR>".$sqlr;
		 $idcomp=mysql_insert_id();
//		 echo "<input type='hidden' name='ncomp' value='$idcomp'>";	
		  $sqlr="update tesoreciboscaja set id_comp=$idcomp WHERE id_recaudo=$_POST[idrecaudo] and tipo='1'";
		  mysql_query($sqlr,$linkbd);
		$sqlr2="select * from tesoingresos_DET where codigo='03' AND MODULO='4' and vigencia=$vigusu";
		$res2=mysql_query($sqlr2,$linkbd);
				// echo "<BR>".$sqlr2;
				 
				 //****** $cuentacb   ES LA CUENTA CAJA O BANCO
		while($rowi =mysql_fetch_row($res2))
		 {
			// echo "<br>conc: ".$rowi[2];
		  switch($rowi[2])
		   {
			case 'P03': //***
				 $sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 $resc=mysql_query($sqlrc,$linkbd);	  
				 		 //echo "<BR>".$sqlrc;
				 while($rowc=mysql_fetch_row($resc))
				 {
			  	$porce=$rowi[5];
				if($rowc[6]=='S')
			 	  {				 
					$valorcred=$row[4];
					$valordeb=$valorcred;					
					if($rowc[3]=='N')
				    {
				 	 if($valorcred>0)
					  {						
							// echo "<BR>".$sqlr;
							
						  //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$valordeb;
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
		  if($rowi[6]!="")
			  {
			   $sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) values('".$rowi[6]."','".$_POST[tercero]."','RECIBO DE CAJA',".$vi.",0,'$_POST[estadoc]','$_POST[vigencia]',16,'$concecc')";
	  mysql_query($sqlr,$linkbd); 		
			  }

//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL		
					  }
					}
				  }
				 }
			break;  
			case 'P06': //***
			 $sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 $resc=mysql_query($sqlrc,$linkbd);	  
				 		// echo "<BR>".$sqlrc;
				 while($rowc=mysql_fetch_row($resc))
				 {
			  	$porce=$rowi[5];
				if($rowc[6]=='S')
			 	  {				 
					$valorcred=$row[8];
					$valordeb=$valorcred;					
					if($rowc[3]=='N')
				    {
				 	 if($valorcred>0)
					  {						
							// echo "<BR>".$sqlr;
							
							  //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$valordeb;
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
		  if($rowi[6]!="")
			  {
			   $sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) values('".$rowi[6]."','".$_POST[tercero]."','RECIBO DE CAJA',".$vi.",0,'$_POST[estadoc]','$_POST[vigencia]',16,'$concecc')";
	  mysql_query($sqlr,$linkbd); 		
			  }

//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL	
					  }
					}
				  }
				 }
			
			break;  
			case '03': 
			
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 $resc=mysql_query($sqlrc,$linkbd);	  
				 		// echo "<BR>".$sqlrc;
				 while($rowc=mysql_fetch_row($resc))
				 {
			  	$porce=$rowi[5];
				if($rowc[6]=='S')
			 	  {				 
					$valorcred=$row[6];
					$valordeb=$valorcred;					
					if($rowc[3]=='N')
				    {
				 	 if($valorcred>0)
					  {						
							// echo "<BR>".$sqlr;
							
							  //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$valordeb;
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
		  if($rowi[6]!="")
			  {
			   $sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) values('".$rowi[6]."','".$_POST[tercero]."','RECIBO DE CAJA',".$vi.",0,'$_POST[estadoc]','$_POST[vigencia]',16,'$concecc')";
	  mysql_query($sqlr,$linkbd); 		
			  }
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL	
					  }
					}
				  }
				 }
			break;  
			case 'P01': 
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 $resc=mysql_query($sqlrc,$linkbd);	  
				 		// echo "<BR>".$sqlrc;
				 while($rowc=mysql_fetch_row($resc))
				 {
			  	$porce=$rowi[5];
				if($rowc[6]=='S')
			 	  {				 
					$valordeb=$row[10];
					$valorcred=0;					
					if($rowc[3]=='N')
				    {
				 	 if($valorcred>0)
					  {						
							// echo "<BR>".$sqlr;
							
					  }
					}
				  }
				 }
			break;  
			case 'P02': 
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 $resc=mysql_query($sqlrc,$linkbd);	  
				 		// echo "<BR>".$sqlrc;
				 while($rowc=mysql_fetch_row($resc))
				 {
			  	$porce=$rowi[5];
				if($rowc[6]=='S')
			 	  {				 
					$valorcred=$row[5];
					$valordeb=$valorcred;					
					if($rowc[3]=='N')
				    {
				 	 if($valorcred>0)
					  {
							// echo "<BR>".$sqlr;
							
							  //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$valordeb;
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
		  if($rowi[6]!="")
			  {
			   $sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) values('".$rowi[6]."','".$_POST[tercero]."','RECIBO DE CAJA',".$vi.",0,'$_POST[estadoc]','$_POST[vigencia]',16,'$concecc')";
	  mysql_query($sqlr,$linkbd); 		
			  }

//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL	
					}
				   }
				  }
				 }
			break;  
			case 'P04': 
			
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 $resc=mysql_query($sqlrc,$linkbd);	  
				 		// echo "<BR>".$sqlrc;
				 while($rowc=mysql_fetch_row($resc))
				 {
			  	$porce=$rowi[5];
				if($rowc[6]=='S')
			 	  {				 
					$valorcred=$row[7];
					$valordeb=$valorcred;					
					if($rowc[3]=='N')
				    {
				 	 if($valorcred>0)
					  {						
							// echo "<BR>".$sqlr;
							
							  //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$valordeb;
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
		  if($rowi[6]!="")
			  {
			   $sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) values('".$rowi[6]."','".$_POST[tercero]."','RECIBO DE CAJA',".$vi.",0,'$_POST[estadoc]','$_POST[vigencia]',16,'$concecc')";
	  mysql_query($sqlr,$linkbd); 		
			  }

//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL	
					  }
					}
				  }
				 }
			break;  
			case 'P05': 
			
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 $resc=mysql_query($sqlrc,$linkbd);	  
				 		// echo "<BR>".$sqlrc;
				 while($rowc=mysql_fetch_row($resc))
				 {
			  	$porce=$rowi[5];
				if($rowc[6]=='S')
			 	  {				 
					$valorcred=$row[6];
					$valordeb=$valorcred;					
					if($rowc[3]=='N')
				    {
				 	 if($valorcred>0)
					  {
							// echo "<BR>".$sqlr;
							
							  //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$valordeb;
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
		  if($rowi[6]!="")
			  {
			   $sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) values('".$rowi[6]."','".$_POST[tercero]."','RECIBO DE CAJA',".$vi.",0,'$_POST[estadoc]','$_POST[vigencia]',16,'$concecc')";
	  mysql_query($sqlr,$linkbd); 		
			  }

//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL	
					  }
					}
				  }
				 }
			break;  
			case 'P07': 
			
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 $resc=mysql_query($sqlrc,$linkbd);	  
				 		// echo "<BR>".$sqlrc;
				 while($rowc=mysql_fetch_row($resc))
				 {
			  	$porce=$rowi[5];
				if($rowc[6]=='S')
			 	  {				 
					$valorcred=$row[9];
					$valordeb=$valorcred;					
					if($rowc[3]=='N')
				    {
				 	 if($valorcred>0)
					  {						
							// echo "<BR>".$sqlr;
							
							  //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$valordeb;
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
		  if($rowi[6]!="")
			  {
			   $sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) values('".$rowi[6]."','".$_POST[tercero]."','RECIBO DE CAJA',".$vi.",0,'$_POST[estadoc]','$_POST[vigencia]',16,'$concecc')";
	  mysql_query($sqlr,$linkbd); 		
			  }
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL	
					  }
					}
				  }
				 }
			break;  
			case 'P08': 
			
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 $resc=mysql_query($sqlrc,$linkbd);	  
				 		// echo "<BR>".$sqlrc;
				 while($rowc=mysql_fetch_row($resc))
				 {
			  	$porce=$rowi[5];
				if($rowc[6]=='S')
			 	  {				 
					$valorcred=0;
					$valordeb=$row[8];					
				  }
				 if($rowc[6]=='N')
			 	  {				 
					$valorcred=$row[8];
					$valordeb=0;					
				  }
					if($rowc[3]=='N')
				    {
				 	 					
							// echo "<BR>".$sqlr;
							  //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$row[8];
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			mysql_query($sqlr,$linkbd);				
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
		  if($rowi[6]!="")
			  {
			   $sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) values('".$rowi[6]."','".$_POST[tercero]."','RECIBO DE CAJA',".$vi.",0,'$_POST[estadoc]','$_POST[vigencia]',16,'$concecc')";
	  mysql_query($sqlr,$linkbd); 		
			  }

			//************ FIN MODIFICACION PPTAL		
				   }
				 }
			break;  


			} 
			//echo "<br>".$sqlr;
		 }
		$_POST[dcoding][]=$row2[0];
		$_POST[dncoding][]=$row2[1]." ".$vig;			 		
    	$_POST[dvalores][]=$row[11];		 	
				//		echo "Vig:$vig valor:$row[11] codigo:".$row2[0];
		 }
		}
	//*******************  
	 $sqlr="Select *from tesoliquidapredial_det where idpredial=$_POST[idrecaudo]";
		  $resp=mysql_query($sqlr,$linkbd);
		  while($row=mysql_fetch_row($resp,$linkbd))
		   {
		    $sqlr2="update tesoprediosavaluos set pago='S' where codigocatastral=(select codigocatastral from tesoliquidapredial WHERE idpredial=$_POST[idrecaudo]) AND vigencia=$row[1]";
			mysql_query($sqlr2,$linkbd);
		   }	 	  
		  
   	 } //fin de la verificacion
	 else
	 {
	  echo "<table class='inicio'><tr><td class='saludo1'><center>Ya Existe un Recibo de Caja para esta Liquidacion Predial<img src='imagenes/alert.png'></center></td></tr></table>";
	 }//***FIN DE LA VERIFICACION
	   break;
	   case 2:  //********** INDUSTRIA Y COMERCIO
	   //echo "INDUSTRIA";
		      ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
			  $fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
		$sqlr="select count(*) from tesoreciboscaja where id_recaudo=$_POST[idrecaudo] and tipo='2'";
	$res=mysql_query($sqlr,$linkbd);
	//echo $sqlr;
	while($r=mysql_fetch_row($res))
	 {
		$numerorecaudos=$r[0];
	 }
  if($numerorecaudos>=0)
   {   	 
     $sqlr="delete from pptocomprobante_cab where numerotipo=$_POST[idcomp] and tipo_comp='16'";
	  mysql_query($sqlr,$linkbd);
	    $sqlr="delete from pptocomprobante_det where  numerotipo=$_POST[idcomp] and tipo_comp='16'";
		//echo $sqlr;
		mysql_query($sqlr,$linkbd);
		$sqlr="delete from pptosinrecibocajappto where idrecibo=$_POST[idcomp]";
		//echo $sqlr;		
		mysql_query($sqlr,$linkbd);
		   $sqlr="insert into  pptocomprobante_cab (numerotipo,tipo_comp,fecha,concepto,vigencia,total_debito,total_credito,diferencia,estado) values($_POST[idcomp],16,'$fechaf','RECIBO DE CAJA',$_POST[vigencia],0,0,0,'$_POST[estadoc]')";
		 //  echo $sqlr;		
	if (!mysql_query($sqlr,$linkbd))	
		{
	 	echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue><img src='imagenes/alert.png'> Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
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
		 echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado el Recibo de Caja con Exito <img src='imagenes/confirm.png'><script></script></center></td></tr></table>"; 
		 $concecc=$_POST[idcomp]; 
		 //*************COMPROBANTE CONTABLE INDUSTRIA
		 
		  if($_POST[modorec]=='caja')
			  	{				 
					$cuentacb=$_POST[cuentacaja];
					$cajas=$_POST[cuentacaja];
					$cbancos="";
			  	}
				if($_POST[modorec]=='banco')
			    {
					$cuentacb=$_POST[banco];				
					$cajas="";
					$cbancos=$_POST[banco];
			    }
	
		for($x=0;$x<count($_POST[dcoding]);$x++)
	 	{
		 //***** BUSQUEDA INGRESO ********
		$sqlr="Select * from tesoindustria_det where id_industria=".$_POST[idrecaudo];
	 	$res=mysql_query($sqlr,$linkbd);
		$row=mysql_fetch_row($res);
		  //   echo "$sqlr <br>";	    
		$industria=$row[1];
		$avisos=$row[2];
		$bomberil=$row[3];
		$retenciones=$row[4];
		$sanciones=$row[5];	
		$intereses=$row[6];
		$antivigact=$row[11];		
		$antivigant=$row[10];	
		$sqlri="Select * from tesoingresos_det where codigo='".$_POST[dcoding][$x]."' and vigencia=$vigusu";
	 	$res=mysql_query($sqlri,$linkbd);
     //echo "$sqlri <br>";	    
		  while($row=mysql_fetch_row($res))
		  {
			if($row[2]=='00') //*****sanciones
			  {					
					  //**fin rete ica
						 $valordeb=$industria+$sanciones-$retenciones;
						 $valorcred=0;
						
					$sqlr="UPDATE pptocuentaspptoinicial set ingresos=ingresos+$industria  WHERE cuenta='$row[6]'   and vigencia=".$vigusu;
						mysql_query($sqlr,$linkbd);
						 $sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$row[6]',$concecc,$sanciones,'".$vigusu."')";
					//	 echo "ic rec:".$sqlr;
  						  mysql_query($sqlr,$linkbd);	
		  if($row[6]!="")
			  {
			   $sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) values('".$row[6]."','".$_POST[tercero]."','RECIBO DE CAJA',".$sanciones.",0,'$_POST[estadoc]','$_POST[vigencia]',16,'$concecc')";
	  mysql_query($sqlr,$linkbd); 		
	  		// echo "ic rec:".$sqlr;
			  }						
			  }
			if($row[2]=='04') //*****industria
			  {					
					  //**fin rete ica
						 $valordeb=$industria+$sanciones-$retenciones;
						 $valorcred=0;
						
					$sqlr="UPDATE pptocuentaspptoinicial set ingresos=ingresos+$industria  WHERE cuenta='$row[6]'   and vigencia=".$vigusu;
						mysql_query($sqlr,$linkbd);
						 $sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$row[6]',$concecc,$industria,'".$vigusu."')";
					//	 echo "ic rec:".$sqlr;
  						  mysql_query($sqlr,$linkbd);	
		  if($row[6]!="")
			  {
				  $industria+=$intereses;
			   $sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) values('".$row[6]."','".$_POST[tercero]."','RECIBO DE CAJA',".$industria.",0,'$_POST[estadoc]','$_POST[vigencia]',16,'$concecc')";
	  mysql_query($sqlr,$linkbd); 		
	  		 //echo "ic rec:".$sqlr;
			  }						
			  }
			  
			   if($row[2]=='P11')//************ANTICIPOS VIG ACTUAL ****************** 
			  {
				  if(antivigact>0)
				  {
				$sqlr2="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='P11' and tipo='C'";
					$res2=mysql_query($sqlr2,$linkbd);
					 while($row2=mysql_fetch_row($res2))
					  {
					   if($row2[3]=='N')
						{				 					  		
					   if($row2[7]=='S')
						 {				 
						 $valordeb=0;
						 $valorcred=$antivigact;					
						  $sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$row2[4]."','".$_POST[tercero]."', '".$row2[5]."','ANTICIPO VIGENCIA ACTUAL $_POST[ageliquida]','',0,$valorcred,'1','".$_POST[vigencia]."')";
						mysql_query($sqlr,$linkbd);	 
//						echo "<br>$sqlr";						
						//********** CAJA O BANCO
						 $valordeb=$antivigact;
						 $valorcred=0;
						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','".$cuentacb."','".$_POST[tercero]."','".$row2[5]."','ANTICIPO VIGENCIA ACTUAL $_POST[modorec]','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
						mysql_query($sqlr,$linkbd);											
						 }
						}						
					  }
				  }
			  }
			  //*******************
			  if($row[2]=='P11')//************ANTICIPOS VIG ANTERIOR ****************** 
			  {
				  if(antivigant>0)
				  {
				$sqlr2="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='P11' and tipo='C'";
					$res2=mysql_query($sqlr2,$linkbd);
					 while($row2=mysql_fetch_row($res2))
					  {
					   if($row2[3]=='N')
						{				 					  		
					   if($row2[7]=='S')
						 {				 
						 $valorcred=0;
						 $valordeb=$antivigant;					
						  $sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$row2[4]."','".$_POST[tercero]."', '".$row2[5]."','ANTICIPO VIGENCIA ANTERIOR $_POST[ageliquida]','',$valordeb,$valorcred,'1','".$_POST[vigencia]."')";
						mysql_query($sqlr,$linkbd);	 
//						echo "<br>$sqlr";						
						//********** CAJA O BANCO									
						 }
						}						
					  }
				  }
			  }
			  //*******************  
			  
			if($row[2]=='05')//************avisos
			  {
						 $valordeb=$avisos;
						 $valorcred=0;
						
					$sqlr="UPDATE pptocuentaspptoinicial set ingresos=ingresos+$avisos  WHERE cuenta='$row[6]'   and vigencia=".$vigusu;
						mysql_query($sqlr,$linkbd);
						 $sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$row[6]',$concecc,$avisos,'".$vigusu."')";
						  //echo "av rec:".$sqlr;
		  			  mysql_query($sqlr,$linkbd);	
		   if($row[6]!="")
			   {
			   $sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) values('".$row[6]."','".$_POST[tercero]."','RECIBO DE CAJA',".$avisos.",0,'$_POST[estadoc]','$_POST[vigencia]',16,'$concecc')";
	  mysql_query($sqlr,$linkbd); 	
//	   echo "<br>av rec:".$sqlr;	
			    }				
			  }
			if($row[2]=='06') //*********bomberil ********
			  {
					$sqlr2="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='06' and tipo='C'";
					$res2=mysql_query($sqlr2,$linkbd);
					 while($row2=mysql_fetch_row($res2))
					  {
					   if($row2[3]=='N')
						{				 					  		
					   if($row2[6]=='S')
						 {				 
						 $valordeb=0;
						 $valorcred=$bomberil;					
		//				echo "<br>$sqlr";						
						//********** CAJA O BANCO
						 $valordeb=$bomberil;
						 $valorcred=0;
			//***MODIFICAR PRESUPUESTO
						$sqlr="UPDATE pptocuentaspptoinicial set ingresos=ingresos+$bomberil  WHERE cuenta=$row[6]   and vigencia=".$vigusu;
						mysql_query($sqlr,$linkbd);
						 $sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$row[6]',$concecc,$bomberil,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
				 //echo "bom rec:".$sqlr;
		  if($row[6]!="")
			  {
			   $sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) values('".$row[6]."','".$_POST[tercero]."','RECIBO DE CAJA',".$bomberil.",0,'$_POST[estadoc]','$_POST[vigencia]',16,'$concecc')";
	  mysql_query($sqlr,$linkbd); 		
			  }
				 
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
	  echo "<table class='inicio'><tr><td class='saludo1'><center>Ya Existe un Recibo de Caja para esta Liquidacion <img src='imagenes/alert.png'></center></td></tr></table>";
	 }
		 
		break; 
	  case 3: //**************OTROS RECAUDOS
	
    $sqlr="delete from pptocomprobante_cab where numerotipo=$_POST[idcomp] and tipo_comp='16'";
	  mysql_query($sqlr,$linkbd);
	    $sqlr="delete from pptocomprobante_det where  numerotipo=$_POST[idcomp] and tipo_comp='16'";
		//echo $sqlr;
		mysql_query($sqlr,$linkbd);
		$sqlr="delete from pptosinrecibocajappto where idrecibo=$_POST[idcomp]";
		//echo $sqlr;		
		mysql_query($sqlr,$linkbd);
 	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	//*********************CREACION DEL COMPROBANTE CONTABLE ***************************
//***busca el consecutivo del comprobante contable
	$consec=$_POST[idcomp];
//***cabecera comprobante
	 //$sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($consec,5,'$fechaf','$_POST[concepto]',0,$_POST[totalc],$_POST[totalc],0,'$_POST[estadoc]')";
     $sqlr="insert into  pptocomprobante_cab (numerotipo,tipo_comp,fecha,concepto,vigencia,total_debito,total_credito,diferencia,estado) values($consec,16,'$fechaf','RECIBO DE CAJA',$_POST[vigencia],0,0,0,'$_POST[estadoc]')";
	if(mysql_query($sqlr,$linkbd))
	{
	$idcomp=mysql_insert_id();
//	echo "<input type='hidden' name='ncomp' value='$idcomp'>";
		
		//******************* DETALLE DEL COMPROBANTE CONTABLE *********************
	for($x=0;$x<count($_POST[dcoding]);$x++)
	 {
		 //***** BUSQUEDA INGRESO ********
		$sqlri="Select * from tesoingresos_det where codigo='".$_POST[dcoding][$x]."' and vigencia=$vigusu";
	 	$resi=mysql_query($sqlri,$linkbd);
		//	echo "$sqlri <br>";	    
		while($rowi=mysql_fetch_row($resi))
		 {
		
	    if($rowi[6]!="")
		    {
	    //**** busqueda cuenta presupuestal*****
		 $porce=$rowi[5];
		 $valorcred=$_POST[dvalores][$x]*($porce/100);
		 $valordeb=0;
			   //*****inserta del concepto contable  
			   //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
			$rowpto=mysql_fetch_row($respto);			
			$vi=$_POST[dvalores][$x]*($porce/100);
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			//mysql_query($sqlr,$linkbd);	
			//****creacion documento presupuesto ingresos		
	  $sqlr="insert into pptosinrecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$consec,$vi,'".$vigusu."')";
	  mysql_query($sqlr,$linkbd);	
	  $sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) values('".$rowi[6]."','".$_POST[tercero]."','RECIBO DE CAJA',".$vi.",0,'$_POST[estadoc]','$_POST[vigencia]',16,'$consec')";
	  mysql_query($sqlr,$linkbd); 			  
			}

		 }
	}	
	 echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha Actualizado el Recibo de caja con Exito<img src='imagenes/confirm.png'><script></script></center></td></tr></table>";
	}
	else
	{
		 echo "<table class='inicio'><tr><td class='saludo1'><center>No Se ha Actualizado el Recibo de caja con Exito <img src='imagenes/alert.png'><script></script></center></td></tr></table>";
	}	
	break;
	   //********************* INDUSTRIA Y COMERCIO
	} //*****fin del switch
	}//***bloqueo
		else
	   {
    	echo "<div class='inicio'><img src='imagenes\alert.png'> No Tiene los Permisos para Modificar este Documento</div>";
	   }

   }//**fin del oculto 
?>	
</form>
 </td></tr>
</table>
</body>
</html>