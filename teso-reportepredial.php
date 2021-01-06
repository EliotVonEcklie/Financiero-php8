<?php //V 1001 20/12/16 Se filtro por codi catastral?>
<?php
require "comun.inc";
require "funciones.inc";
require "conversor.php";
ini_set('max_execution_time',5000);
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
document.form2.action="pdfcobropredial.php";
document.form2.target="_BLANK";
document.form2.submit(); 
document.form2.action="";
document.form2.target="";
}
</script>
<script>
function buscar()
 {
	// alert("dsdd");
	var buscavId = document.form2.buscav.value;
	document.form2.buscav.value='1';
 	document.form2.submit();
 	document.form2.buscav.value = buscavId;
 }
 function buscar1()
 {
	// alert("dsdd");
 document.form2.buscav.value='1';
 document.form2.submit();
 }
</script>
<script>
function buscavigencias(objeto)
 {
	
 //document.form2.buscarvig.value='1';
vvigencias=document.getElementsByName('dselvigencias[]');
vtotalpred=document.getElementsByName("dpredial[]"); 	
vtotaliqui=document.getElementsByName("dhavaluos[]"); 	
vtotalbomb=document.getElementsByName("dimpuesto1[]"); 	
vtotalmedio=document.getElementsByName("dimpuesto2[]"); 	
vtotalintp=document.getElementsByName("dipredial[]"); 	
vtotalintb=document.getElementsByName("dinteres1[]"); 	
vtotalintma=document.getElementsByName("dinteres2[]"); 	
vtotaldes=document.getElementsByName("ddescuentos[]"); 	
sumar=0;
sumarp=0;
sumarb=0;
sumarma=0;
sumarint=0;
sumarintp=0;
sumarintb=0;
sumarintma=0;
sumardes=0;
for(x=0;x<vvigencias.length;x++)
 {
	 if(vvigencias.item(x).checked)
	 {
	 sumar=sumar+parseFloat(vtotaliqui.item(x).value);
	 sumarp=sumarp+parseFloat(vtotalpred.item(x).value);
	 sumarb=sumarb+parseFloat(vtotalbomb.item(x).value);
	 sumarma=sumarma+parseFloat(vtotalmedio.item(x).value);
	 sumarint=sumarint+parseFloat(vtotalintp.item(x).value)+parseFloat(vtotalintb.item(x).value)+parseFloat(vtotalintma.item(x).value);
	 sumarintp=sumarintp+parseFloat(vtotalintp.item(x).value);
	 sumarintb=sumarintb+parseFloat(vtotalintb.item(x).value);
	 sumarintma=sumarintma+parseFloat(vtotalintma.item(x).value);	 	 
	 sumardes=sumardes+parseFloat(vtotaldes.item(x).value);
	 }
 }

document.form2.totliquida.value=sumar;
document.form2.totliquida2.value=sumar;
document.form2.totpredial.value=sumarp;
document.form2.totbomb.value=sumarb;
document.form2.totamb.value=sumarma;
document.form2.totint.value=sumarint;
document.form2.intpredial.value=sumarintp;
document.form2.intbomb.value=sumarintb;
document.form2.intamb.value=sumarintma;
document.form2.totdesc.value=sumardes;
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
 function excell()
{
    document.form2.action="teso-reporteprediosexcel.php";
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
		<td colspan="3" class="cinta">
			<a href="#" class="mgbt"><img src="imagenes/add2.png" alt="Nuevo"  border="0"  title="Nuevo"/></a>
			<a href="#" class="mgbt"><img src="imagenes/guardad.png"  alt="Guardar" title="Guardar" /></a>
			<a href="#" class="mgbt"><img src="imagenes/buscad.png"  alt="Buscar" title="Buscar"/></a>
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana"  title="Nueva ventana"></a>
			<a href="#"  class="mgbt" onClick="pdff();"><img src="imagenes/print.png"  title="Imprimir" /></a>
			<a href="<?php echo "archivos/".$_SESSION[usuario]."reportepredial.csv"; ?>" target="_blank" class="mgbt"><img src="imagenes/csv.png"  alt="csv" title="csv"></a>
			<a href="teso-informespredios.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
			<img src="imagenes/excel.png" title="Excel" onClick='excell()' class="mgbt"/>
		</td>
	</td>
</tr>		  
</table>
<tr>
<td colspan="3" class="tablaprin" align="center"> 
<?php
//$vigencia=date(Y);
$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
$vigencia=$vigusu;
 ?>	
<?php
	  //*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
// if(!$_POST[oculto])
// {
	$linkbd=conectar_bd();
	$_POST[var1]=0;
	$_POST[var2]=0;
	$sqlr="select valor_inicial,valor_final, tipo from dominios where nombre_dominio='BASE_PREDIAL' ";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)){$_POST[basepredial]=$row[0];}
	$sqlr="select valor_inicial,valor_final, tipo from dominios where nombre_dominio='BASE_PREDIALAMB' ";
	$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res)){$_POST[basepredialamb]=$row[0];}	
	 				$sqlr="select valor_inicial,valor_final, tipo from dominios where nombre_dominio='NORMA_PREDIAL' ";
					$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res)){
						$_POST[aplicapredial]=$row[0];}
					$sqlr="select valor_inicial,valor_final, tipo from dominios where nombre_dominio='DESC_INTERESES' ";
					$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res)) 
					{
	 					$_POST[vigmaxdescint]=$row[0];
 	 					$_POST[porcdescint]=$row[1];
	 					$_POST[aplicadescint]=$row[2];
					}
	
	 		$fec=date("d/m/Y");
			$_POST[fecha]=$fec; 		 		  			 
			$_POST[fechaav]=$_POST[fecha];
			$_POST[vigencia]=$vigusu; 		
			$check1="checked";
			$sqlr="select *from tesotasainteres where vigencia=".$vigusu;
			
			$res=mysql_query($sqlr,$linkbd);
			$r=mysql_fetch_row($res);
			$tasam=array();
			$tasam[0]=$r[14];									
			$tasam[1]=$r[15];
			$tasam[2]=$r[16];
			$tasam[3]=$r[17];
			$tasamoratoria[0]=0;
			
			ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);

			if($fecha[2]<=3)
			 {
			  $tasamoratoria[0]=$tasam[0];				 
			 }
				else
				  {
				  if($fecha[2]<=6)
				   {
					$tasamoratoria[0]=$tasam[1];									   
				   }
					else
					 {
					  if($fecha[2]<=9)
					   {
						$tasamoratoria[0]=$tasam[2];
					   }
						else
					    {
 						$tasamoratoria[0]=$tasam[3];
					    }						
					 }
				   }
				$_POST[tasamora]=$tasamoratoria[0];   
				if($_POST[tasamora]==0)
				 {
					 ?>
                     <script>alert("LA TASA DE INTERES DE MORA ES CERO (0) POR FAVOR ACTUALIZAR EL VALOR")</script>
                     <?php
				  }
			$_POST[tasa]=0;
			$_POST[predial]=0;
			$_POST[descuento]=0;
			//***** BUSCAR FECHAS DE INCENTIVOS
			ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
			$fechaactual=$fecha[3]."-".$fecha[2]."-".$fecha[1];	
			$sqlr="select *from tesodescuentoincentivo where vigencia=".$vigusu." and ingreso='01' and estado='S'";
			$res=mysql_query($sqlr,$linkbd);
			//echo $sqlr;
			while($r=mysql_fetch_row($res))
			{	
		
			  if($r[7]<=$fechaactual && $fechaactual <= $r[8])
			   {
				 $fdescuento=$r[2];	 
				 $_POST[descuento]=$r[2];	   
			   }
			  elseif($fechaactual>$r[9] && $fechaactual <= $r[10])
			   {
				 $fdescuento=$r[2];	 
				 $_POST[descuento]=$r[3];	   
			   }
			  elseif($fechaactual>$r[11] && $fechaactual <= $r[12])
			   {
				 $fdescuento=$r[2];	 
				 $_POST[descuento]=$r[4];	   
			   } 
				else {$ulfedes=explode("-",$r[12]);}			   
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
  $linkbd=conectar_bd();
$sqlr="Select max(idpredial) from tesoliquidapredial";
$res=mysql_query($sqlr,$linkbd);
$row=mysql_fetch_row($res);
  $_POST[numpredial]=$row[0]+1;
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
      <tr >
        <td class="titulos" colspan="11">Reporte de Estado Predial</td><td width="72" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
      </tr>
     <tr>
		
		<td style="width:10%;" class="saludo1">Fecha:</td>
		<td  style="width:5%;">
			<input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly></td>
		<td class="saludo1"  style="width:8%;">Vigencia:</td>
		<td  style="width:7%;">
			<input name="vigencia" type="text" value="<?php echo $_POST[vigencia]?>" maxlength="2"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  style="width:100%;" readonly></td>
		<td class="saludo1"  style="width:10%;">Tasa Interes Mora:</td>
		<td  style="width:10%;">
			<input name="tasamora" type="text" value="<?php echo $_POST[tasamora]?>"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  style="width:80%;" readonly>%</td>
		<td class="saludo1"  style="width:10%;">Descuento:</td>
		<td  style="width:7%;">
			<input name="descuento" type="text" value="<?php echo $_POST[descuento]?>"   onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  style="width:70%;" readonly>%</td >
		<td class="saludo1" style="width:7%;">Tasa Predial	:</td>
			<td>
				<input name="tasa" value="<?php echo $_POST[tasa]?>" type="text"  style="width:50%;" readonly>x mil</td>
	</tr>
	  <tr> <td  class="saludo1">Documento: </td>
        <td >
			<input name="tercero" type="text" value="<?php echo $_POST[tercero]?>"  onKeyUp="return tabular(event,this)" style="width:80%;" onBlur="buscater(event)">
      <a href="#" onClick="mypop=window.open('terceros-ventana.php?ti=1','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a></td>
			  <td class="saludo1">Contribuyente:</td>
	  <td  colspan="3">
		<input type="text" id="ntercero" name="ntercero" value="<?php echo $_POST[ntercero]?>"  onKeyUp="return tabular(event,this) " style="width:100%" readonly><input type="hidden" value="0" id="bt" name="bt"></td>
		<td class="saludo1">Deduccion Ajuste:</td>
                                <td colspan="2"><input type="text" name="deduccion" value="<?php echo $_POST[deduccion]?>" style="width:100%;" onBlur="document.form2.submit()" ></td>
		<td>
			<input type="hidden" value="<?php echo $_POST[buscav]?>" name="buscav"></td>	 
        </tr>
        <tr>
		  <td width="128" class="saludo1">C&oacute;digo Catastral:</td>
          <td  >
			<input id="codcat" type="text" name="codcat"  onKeyUp="return tabular(event,this)" onBlur="buscar(event)" value="<?php echo $_POST[codcat]?>" style="width:80%;"> <a href="#" onClick="mypop=window.open('catastral-ventana4.php','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=900,height=500px');mypop.focus();" ><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>
			<input type="hidden" name="chacuerdo" value="1"><input type="hidden" value="1" name="oculto" id="oculto">
			<input type="hidden" name="basepredial" value="<?php echo  $_POST[basepredial] ?>"/>
                                <input type="hidden" name="basepredialamb" value="<?php echo  $_POST[basepredialamb] ?>"/>
                                <input type="hidden" name="aplicapredial" value="<?php echo  $_POST[aplicapredial] ?>"/>
                                <input type="hidden" name="vigmaxdescint" value="<?php echo  $_POST[vigmaxdescint] ?>"/>
                                <input type="hidden" name="porcdescint" value="<?php echo  $_POST[porcdescint] ?>"/>
                                <input type="hidden" name="aplicadescint" value="<?php echo  $_POST[aplicadescint] ?>"/>
			</td>
		
		<td class="saludo1" style="width:9%;">Avaluo Vigente:</td>
			<td>
				<input name="avaluo2" value="<?php echo $_POST[avaluo2]?>" type="text" readonly>
				<input type="hidden" name="vavaluo"  value="<?php echo $_POST[vavaluo]?>" > </td>
			
			<td class="saludo1">Estado Vigencias:</td>
			<td>
				<select name="tipov" onChange="document.form2.submit()">
				  <option value="" <?php if($_POST[tipov]=='') echo "SELECTED"?>>Todos</option>
				  <option value="S" <?php if($_POST[tipov]=='S') echo "SELECTED"?>>Pagos</option>
  				  <option value="N" <?php if($_POST[tipov]=='N') echo "SELECTED"?>>Deuda</option>
				  </select>
			</td>
			<td ><input type="button" name="buscarb" id="buscarb" value="   Buscar   " onClick="buscar1()" ><input name="predial" value="<?php echo $_POST[predial]?>" type="hidden"  readonly></td></tr>
          <?php
		  if($_POST[tipov]=='N'){
			  echo "<td class='saludo1'>
						Deuda superior a: 
					</td>
					<td>
						<input type='text' name='dsuperior' id='dsuperior' value='$_POST[dsuperior]'>
					</td>";
		  }
	   if($_POST[bt]=='1')
			 {
			  $nresul=buscatercero($_POST[tercero]);
			  if($nresul!='')
			   {
			  $_POST[ntercero]=$nresul;
  				?>
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
	  </table>         
	  <div class="subpantallac" style='height: 55%;'>
      <table class="inicio">
	   	   <tr>
	   	     <td colspan="15" class="titulos"> .:Informe Predial</td>
	   	     <input type="hidden" name="tot" id="tot" value="<?php echo $_POST[tot]; ?>" />
	   	     <input type="hidden" name="ord" id="ord" value="<?php echo $_POST[ord]; ?>" />
	   	     <input type="hidden" name="tipop" id="tipop" value="<?php echo $_POST[tipop]; ?>">
	   	     <input type="hidden" name="estrato" id="estrato" value="<?php echo $_POST[estrato]; ?>">
	   	     <input type="hidden" name="rangos" id="rangos" value="<?php echo $_POST[rangos]; ?>">
	   	     <input type="hidden" name="predial" value="<?php echo $_POST[predial]; ?>">
	   	   </tr>                  
		<tr>
		  
		  
		  <td  class="titulos2">C&oacute;digo Catastral</td>
		  <td  class="titulos2">Avaluo actual</td>
		  <td  class="titulos2" style="width:10%">Vigencias</td>
		  <td  class="titulos2" colspan="2" style="text-align: center;">Tercero</td>          
   		  <td class="titulos2">Predial</td>
   		  <td  class="titulos2">Intereses Predial</td>
		  <td  class="titulos2">Desc. Intereses</td>           
		  <td  class="titulos2">Sobretasa Bombe</td>
          <td  class="titulos2">Intereses</td>
		  <td class="titulos2">Sobretasa Amb</td>
          <td  class="titulos2">Intereses</td>
          <td  class="titulos2">Descuentos</td>
          <td  class="titulos2">Valor Total</td>
          </tr>
            <?php								
					
			ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
			$fechaactual=$fecha[3]."-".$fecha[2]."-".$fecha[1];
			$estadoPago='';					
			if($_POST[buscav]=='1')
			 {
				 $_POST[totliquida2]=0;
				 if($_POST[codcat]!="")
				  {
					$criterio=" and cedulacatastral='$_POST[codcat]'" ;
				  }
				  if($_POST[tercero]!="")
				  {
					$criterio2=" and documento='$_POST[tercero]'" ;
				  }
				  if($_POST[tipov]!="")
				  {
					$criterio3=" and tesoprediosavaluos.pago='$_POST[tipov]' " ;
				  }
			 $_POST[dcuentas]=array();
			 $_POST[dncuentas]=array();
			 $_POST[dtcuentas]=array();		 
	 		 $_POST[dvalores]=array();
			 $linkbd=conectar_bd();
			  $sqlr="SELECT * FROM tesoparametros ";
			// echo "s:$sqlr";
			 $res=mysql_query($sqlr,$linkbd);
			 $row=mysql_fetch_row($res);
			 $presc=$row[2];
			 $catastralactual="";
			 $namearch="archivos/".$_SESSION[usuario]."reportepredial.csv";
			 $Descriptor1 = fopen($namearch,"w+"); 
			fputs($Descriptor1,"COD CATASTRAL;VIGENCIA;TERCERO;NOMBRE TERCERO;DIRECCION TERCERO;AVALUO;PREDIAL;INTERESES PREDIAL;DESC. INTERESES;SOBRETASA BOMBERIL;INTERESES;SOBRETASA AMBIENTAL;INTERESES;VALOR TOTAL;PAGO\r\n");

		$sqlr="SELECT tesopredios.cedulacatastral,tesopredios.ord,tesopredios.tot,tesopredios.e,tesopredios.d,tesopredios.documento,tesopredios.nombrepropietario,tesopredios.direccion,tesopredios.ha,tesopredios.met2,tesopredios.areacon,tesopredios.avaluo,tesopredios.vigencia,tesopredios.estado,tesopredios.tipopredio,tesopredios.estratos,tesoprediosavaluos.vigencia,tesoprediosavaluos.codigocatastral,tesoprediosavaluos.avaluo,tesoprediosavaluos.pago,tesoprediosavaluos.estado,tesoprediosavaluos.tot,tesoprediosavaluos.ord,tesoprediosavaluos.ha,tesoprediosavaluos.met2,tesoprediosavaluos.areacon,tesoprediosavaluos.tipopredio,tesoprediosavaluos.estratos from tesopredios,tesoprediosavaluos where tesopredios.cedulacatastral=tesoprediosavaluos.codigocatastral and tesoprediosavaluos.estado='S' AND tesoprediosavaluos.vigencia = ( SELECT MAX( tp.vigencia ) FROM tesoprediosavaluos tp WHERE tp.codigocatastral = tesopredios.cedulacatastral ) ".$criterio2." ".$criterio." ".$criterio3." group by tesopredios.cedulacatastral order by tesopredios.cedulacatastral";
			 $iter='saludo1a';
            $iter2='saludo2';
			 $resto=mysql_query($sqlr,$linkbd);
			 
			 $sq="select interespredial from tesoparametros ";
			$result=mysql_query($sq,$linkbd);
			$rw=mysql_fetch_row($result);
			$interespredial=$rw[0];
			 while($rowto=mysql_fetch_row($resto))
			  {
				 $estadoPago=$rowto[19];
				 $_POST[codcat]=$rowto[0];	
		if($_POST[tipov]=='S'){
			if($estadoPago=='S'){
		 	generaReportePagos($rowto[0],$rowto[18],$rowto[5],$rowto[6],$rowto[16],$rowto[7]);
		 }
		}else if($_POST[tipov]=='N'){
			if($estadoPago!='S'){
		 		generaReporteSinPagos1($rowto[0],$vigusu,$rowto[7]);
		 	    //verificaExistePredio($rowto[0],$rowto[18],$rowto[5],$rowto[6],$rowto[16],$rowto[7]);
		 }
		}else{
			if($estadoPago=='S'){
		 	generaReportePagos($rowto[0],$rowto[18],$rowto[5],$rowto[6],$rowto[16],$rowto[7]);
		 }else{
		 	generaReporteSinPagos1($rowto[0],$vigusu,$rowto[7]);
		 	verificaExistePredio($rowto[0],$rowto[18],$rowto[5],$rowto[6],$rowto[16],$rowto[7]);
		 }
		}
		 
				$aux=$iter;
                $iter=$iter2;
                $iter2=$aux;					
				
	     }
			$resultado = convertir($_POST[totliquida]);
			$_POST[letras]=$resultado." PESOS M/CTE";	
			fclose($Descriptor1);
			$_POST[buscav]=''; 
			 }
 	
		?>

		<?php
		
		function verificaExistePredio($codcatastral,$avaluo,$idtercero,$ntercero,$vigencia,$direccion){
			global $linkbd,$Descriptor1;
			$consulta="SELECT tesoliquidapredial_det.predial,tesoliquidapredial_det.intpredial,tesoliquidapredial_det.bomberil,tesoliquidapredial_det.intbomb,tesoliquidapredial_det.medioambiente,tesoliquidapredial_det.intmedioambiente,tesoliquidapredial_det.descuentos,tesoliquidapredial_det.vigliquidada FROM tesoliquidapredial,tesoliquidapredial_det WHERE tesoliquidapredial.codigocatastral='$codcatastral' AND tesoliquidapredial.idpredial=tesoliquidapredial_det.idpredial AND tesoliquidapredial.estado<>'N' ";
			$result=mysql_query($consulta,$linkbd);
			$num=mysql_num_rows($result);
			if($num>0){
				while($rowcon = mysql_fetch_array($result)){
					$pagosnp="PAGO";
					$sumapredial=$rowcon[0];
				 	$sumapredialint=$rowcon[1];
				 	$sumabomb=$rowcon[2];
				 	$sumabombint=$rowcon[3];
				 	$sumaamb=$rowcon[4];
				 	$sumaambint=$rowcon[5];
				 	$sumadesc=$rowcon[6];
				 	$valtotal=$sumapredial+$sumapredialint+$sumabomb+$sumabombint+$sumaamb+$sumaambint-$sumadesc;
				 	$varcol='resaltar01';
		 		echo "<tr class='$varcol' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
					onMouseOut=\"this.style.backgroundColor=anterior\" $clihis $titvig>
			<td>$codcatastral</td>
			<td>$ ".number_format($avaluo,2)."</td>
			<td>".$rowcon[7]."</td>
			<td>$idtercero</td>
			<td>$ntercero</td>
			<td style='text-align:right;'>$ ".number_format($sumapredial,2)."</td>  
			<td style='text-align:right;'>$ ".number_format($sumapredialint,2)."</td>
			<td style='text-align:right;'>$ ".number_format(0,2)."</td>
			<td style='text-align:right;'>$ ".number_format($sumabomb,2)."</td>
			<td style='text-align:right;'>$ ".number_format($sumabombint,2)."</td>
			<td style='text-align:right;'>$ ".number_format($sumaamb,2)."</td>
			<td style='text-align:right;'>$ ".number_format($sumaambint,2)."</td>
			<td style='text-align:right;'>$ ".number_format($sumadesc,2)."</td>
			<td style='text-align:right;'>$ ".number_format($valtotal,2)."</td>
			</tr>";
			echo "
					<input type='hidden' name='codCatastral[]' id='codCatastral[]' value='".$codcatastral."'>
					<input type='hidden' name='avaluo[]' id='avaluo[]' value='".$avaluo."'>
					<input type='hidden' name='vigencia[]' id='vigencia[]' value='".$rowcon[7]."'>
					<input type='hidden' name='tercero[]' id='tercero[]' value='".$idtercero."'>
					<input type='hidden' name='nomTercero[]' id='nomTercero[]' value='".$ntercero."'>
					<input type='hidden' name='predial[]' id='predial[]' value='".$sumapredial."'>
					<input type='hidden' name='intPredial[]' id='intPredial[]' value='".$sumapredialint."'>
					<input type='hidden' name='descInteresPredial[]' id='descInteresPredial[]' value='0'>
					<input type='hidden' name='bomberil[]' id='bomberil[]' value='".$sumabomb."'>
					<input type='hidden' name='intBomberil[]' id='intBomberil[]' value='".$sumabombint."'>
					<input type='hidden' name='ambiental[]' id='ambiental[]' value='".$sumaamb."'>
					<input type='hidden' name='intAmbiental[]' id='intAmbiental[]' value='".$sumaambint."'>
					<input type='hidden' name='descuento[]' id='descuento[]' value='".$sumadesc."'>
					<input type='hidden' name='totalAPagar[]' id='totalAPagar[]' value='".$valtotal."'>
					<input type='hidden' name='estado[]' id='estado[]' value='".$pagosnp."'>
				";
			 fputs($Descriptor1,"Cod: ".$codcatastral.";".$rowcon[7].";".$idtercero.";".$ntercero.";".$direccion.";".$avaluo.";".$sumapredial.";".$sumapredialint.";0;".$sumabomb.";".$sumabombint.";".$sumaamb.";".$sumaambint.";".$valtotal.";".$pagosnp."\r\n");	

				}
				
			}
		}
	
		function generaReportePagos($codcatastral,$avaluo,$idtercero,$ntercero,$vigencia,$direccion){
			global $linkbd,$Descriptor1;
			$consulta="SELECT tesoliquidapredial_det.predial,tesoliquidapredial_det.intpredial,tesoliquidapredial_det.bomberil,tesoliquidapredial_det.intbomb,tesoliquidapredial_det.medioambiente,tesoliquidapredial_det.intmedioambiente,tesoliquidapredial_det.descuentos,tesoliquidapredial_det.vigliquidada FROM tesoliquidapredial,tesoliquidapredial_det WHERE tesoliquidapredial.codigocatastral='$codcatastral' AND tesoliquidapredial.idpredial=tesoliquidapredial_det.idpredial AND tesoliquidapredial.estado<>'N' ";
			//echo $consulta;
		 	$respuesta=mysql_query($consulta,$linkbd);
			$num=mysql_num_rows($respuesta);
			if($num>0){
				while($rowcon=mysql_fetch_row($respuesta)){
				$pagosnp="PAGO";
				$sumapredial=$rowcon[0];
				$sumapredialint=$rowcon[1];
				$sumabomb=$rowcon[2];
				$sumabombint=$rowcon[3];
				$sumaamb=$rowcon[4];
				$sumaambint=$rowcon[5];
				$sumadesc=$rowcon[6];
				$valtotal=$sumapredial+$sumapredialint+$sumabomb+$sumabombint+$sumaamb+$sumaambint-$sumadesc;
				$varcol='resaltar01';
				echo "<tr class='$varcol' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
						onMouseOut=\"this.style.backgroundColor=anterior\" $clihis $titvig>
				<td>$codcatastral</td>
				<td>$ ".number_format($avaluo,2)."</td>
				<td>".$rowcon[7]."</td>
				<td>$idtercero</td>
				<td>$ntercero</td>
				<td style='text-align:right;'>$ ".number_format($sumapredial,2)."</td>  
				<td style='text-align:right;'>$ ".number_format($sumapredialint,2)."</td>
				<td style='text-align:right;'>$ ".number_format(0,2)."</td>
				<td style='text-align:right;'>$ ".number_format($sumabomb,2)."</td>
				<td style='text-align:right;'>$ ".number_format($sumabombint,2)."</td>
				<td style='text-align:right;'>$ ".number_format($sumaamb,2)."</td>
				<td style='text-align:right;'>$ ".number_format($sumaambint,2)."</td>
				<td style='text-align:right;'>$ ".number_format($sumadesc,2)."</td>
				<td style='text-align:right;'>$ ".number_format($valtotal,2)."</td>
				</tr>";
				echo "
					<input type='hidden' name='codCatastral[]' id='codCatastral[]' value='".$codcatastral."'>
					<input type='hidden' name='avaluo[]' id='avaluo[]' value='".$avaluo."'>
					<input type='hidden' name='vigencia[]' id='vigencia[]' value='".$rowcon[7]."'>
					<input type='hidden' name='tercero[]' id='tercero[]' value='".$idtercero."'>
					<input type='hidden' name='nomTercero[]' id='nomTercero[]' value='".$ntercero."'>
					<input type='hidden' name='predial[]' id='predial[]' value='".$sumapredial."'>
					<input type='hidden' name='intPredial[]' id='intPredial[]' value='".$sumapredialint."'>
					<input type='hidden' name='descInteresPredial[]' id='descInteresPredial[]' value='0'>
					<input type='hidden' name='bomberil[]' id='bomberil[]' value='".$sumabomb."'>
					<input type='hidden' name='intBomberil[]' id='intBomberil[]' value='".$sumabombint."'>
					<input type='hidden' name='ambiental[]' id='ambiental[]' value='".$sumaamb."'>
					<input type='hidden' name='intAmbiental[]' id='intAmbiental[]' value='".$sumaambint."'>
					<input type='hidden' name='descuento[]' id='descuento[]' value='".$sumadesc."'>
					<input type='hidden' name='totalAPagar[]' id='totalAPagar[]' value='".$valtotal."'>
					<input type='hidden' name='estado[]' id='estado[]' value='".$pagosnp."'>
				";
				 fputs($Descriptor1,"Cod: ".$codcatastral.";".$rowcon[7].";".$idtercero.";".$ntercero.";".$direccion.";".$avaluo.";".$sumapredial.";".$sumapredialint.";0;".$sumabomb.";".$sumabombint.";".$sumaamb.";".$sumaambint.";".$valtotal.";".$pagosnp."\r\n");
			  }
			}
			
		 	
		 	

		}
		
		
		function generaReporteSinPagos1($codcatastral,$vigusu,$direccion){
			global $linkbd,$Descriptor1;
				$sqlr="select * from tesotasainteres where vigencia=".$vigusu;
					$res=mysql_query($sqlr,$linkbd);
					$r=mysql_fetch_row($res);
					$tasam=array();
					$tasam[0]=$r[14];									
					$tasam[1]=$r[15];
					$tasam[2]=$r[16];
					$tasam[3]=$r[17];
					$tasamoratoria[0]=0;
					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
					if($fecha[2]<=3){$tasamoratoria[0]=$tasam[0];}
					else
				  	{
				  		if($fecha[2]<=6){$tasamoratoria[0]=$tasam[1];}
						else
					 	{
					  		if($fecha[2]<=9){$tasamoratoria[0]=$tasam[2];}
							else {$tasamoratoria[0]=$tasam[3];}						
						}
				   	}
					$_POST[tasamora]=$tasamoratoria[0]; 
					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
					$fechaactual=$fecha[3]."-".$fecha[2]."-".$fecha[1];	
					$condes=0;
					$sqlr="select *from tesodescuentoincentivo where vigencia='$vigusu' and ingreso='01' and estado='S'";
					$res=mysql_query($sqlr,$linkbd);
					while($r=mysql_fetch_row($res))
					{	
						
			 			if($r[7]<=$fechaactual && $fechaactual <= $r[8])
			   			{
							
				 			$fdescuento=$r[2];	 
							$_POST[descuento]=$r[2];	   
				 			$condes=1;
			   			}
			  			elseif($fechaactual>$r[9] && $fechaactual <= $r[10])
			   			{
							
				 			$fdescuento=$r[2];	 
							$_POST[descuento]=$r[3];	   
							$condes=1;				 
			  			}
			  			elseif($fechaactual>$r[11] && $fechaactual <= $r[12])
			   			{
							
				 			$fdescuento=$r[2];	 
				 			$_POST[descuento]=$r[4];	   
				 			$condes=1;				 
			   			} 
						else {$ulfedes=explode("-",$r[12]);}
					}
					if($codcatastral!='')
 				{
					
						$sqlr="SELECT ord,tot FROM tesoprediosavaluos WHERE codigocatastral='$codcatastral'";
						//echo $sqlr;
						$rowot=mysql_fetch_row(mysql_query($sqlr,$linkbd));
						$_POST[ord]=$rowot[0];
						$_POST[tot]=$rowot[1];
						echo "<script>document.form2.ord.value=$rowot[0];document.form2.tot.value=$rowot[1];</script>";
					
					$_POST[dcuentas]=array();
					$_POST[dncuentas]=array();
				 	$_POST[dtcuentas]=array();		 
				 	$_POST[dvalores]=array();
	 				$sqlr="select * from tesopredios where cedulacatastral='$codcatastral' and ord='$_POST[ord]'  and tot='$_POST[tot]'";	
	 				$res=mysql_query($sqlr,$linkbd);
					while($row=mysql_fetch_row($res))
	  				{
		  				$_POST[catastral]=$row[0];
						$_POST[ntercero]=$row[6];
						$_POST[tercero]=$row[5];
						$_POST[direccion]=$row[7];
		  				$_POST[avaluo2]=number_format($row[11],2);
		  				$_POST[vavaluo]=$row[11];
		  				$_POST[tipop]=$row[14];
		  				if($_POST[tipop]=='urbano')
						{
							$_POST[estrato]=$row[15];
							$tipopp=$row[15];
						}
						else
						{
							$_POST[rangos]=$row[15];
							$tipopp=$row[15];
						}
								
		 				$_POST[dtcuentas][]=$row[1];		 
		 				$_POST[dvalores][]=$row[5];
		 				$_POST[buscav]="";
		 				$sqlr2="select *from tesotarifaspredial where vigencia='$vigusu' and tipo='$_POST[tipop]' and estratos='$tipopp'";
		 				$res2=mysql_query($sqlr2,$linkbd);
	 					while($row2=mysql_fetch_row($res2))
			  			{
			   				$_POST[tasa]=$row2[5];
			   				$_POST[predial]=($row2[5]/1000)*$_POST[vavaluo];
			   				$_POST[predial]=number_format($_POST[predial],2);
			  			}
	  				}
 				}
 				///******* aparicion campos

 			ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
						$fechaactual=$fecha[3]."-".$fecha[2]."-".$fecha[1];				
			  			$tasaintdiaria=($_POST[tasamora]/100);
			  			$valoringreso[0]=0;
			  			$valoringreso[1]=0;
						$intereses[1]=0;
						$intereses[0]=0;
						$valoringresos=0;
						$cuentavigencias=0;
						$tdescuentos=0;
						$baseant=0;
						$npredialant=0;
						$banderapre=0;
			  			$co="zebra1";
			  			$co2="zebra2";
						$sqlrxx="
						SELECT DISTINCT TB1.vigencia,TB1.codigocatastral,TB1.avaluo,TB1.pago,TB1.estado,TB1.tipopredio,TB1.estratos,TB1.areacon
						FROM tesoprediosavaluos TB1
						WHERE TB1.codigocatastral = '$codcatastral'
						AND TB1.estado = 'S'
						AND TB1.pago = 'N'
						ORDER BY TB1.vigencia ASC ";						
						$resxx=mysql_query($sqlrxx,$linkbd);
						$cuentavigencias= mysql_num_rows($resxx);
						$sqlr="
						SELECT DISTINCT TB1.vigencia,TB1.codigocatastral,TB1.avaluo,TB1.pago,TB1.estado,TB1.tipopredio,TB1.estratos,TB1.areacon
						FROM tesoprediosavaluos TB1
						WHERE TB1.codigocatastral = '$codcatastral'
						AND TB1.estado = 'S'
						AND (TB1.pago = 'N' OR TB1.pago = 'P')
						ORDER BY TB1.vigencia ASC ";						
						$res=mysql_query($sqlr,$linkbd);
						
						$cv=0;
						$xpm=0;
						$sq="select interespredial from tesoparametros ";
						$result=mysql_query($sq,$linkbd);
						$rw=mysql_fetch_row($result);
						$interespredial=$rw[0];
						while($r=mysql_fetch_row($res))
						{		
							$banderapre++;
							$otros=0; 
							$sqlr2="select *from tesotarifaspredial where vigencia='$r[0]' and tipo='$r[5]' and estratos='$r[6]'";
							
			 				$res2=mysql_query($sqlr2,$linkbd);
	 						$row2=mysql_fetch_row($res2);
							$base=$r[2];
						
							$valorperiodo=$base*($row2[5]/1000)-$base*($row2[5]/1000)*($_POST[deduccion]/100);
					
							$tasav=$row2[5];
							$predial=round($base*($row2[5]/1000)-$base*($row2[5]/1000)*($_POST[deduccion]/100),2);
					
							//**validacion normatividad predial *****
							if($_POST[aplicapredial]=='S')
							{
								$sqlrp="select distinct * from tesoprediosavaluos where tesoprediosavaluos.codigocatastral='$_POST[codcat]' and vigencia=".($r[0]-1)." ";	
	 							$respr=mysql_query($sqlrp,$linkbd);
 								$rowpr=mysql_fetch_row($respr);
								$baseant=0;		
								$estant=$rowpr[3];
								$baseant=$rowpr[2]+0;
								$predialant=$baseant*($rowpr[10]/1000);
								$areaanterior=$rowpr[9];
								if($estant=='S')
								{	
									$sqlrav="select distinct tesoliquidapredial_det.predial,tesoliquidapredial_det.avaluo from tesoliquidapredial_det,tesoliquidapredial where tesoliquidapredial_det.idpredial=tesoliquidapredial.idpredial and tesoliquidapredial.codigocatastral='$_POST[codcat]' and tesoliquidapredial.estado='P' AND tesoliquidapredial_det.vigliquidada='".($r[0]-1)."'";
									$resav=mysql_query($sqlrav,$linkbd);
 									while($rowav=mysql_fetch_row($resav))
		 							{
 		 								if($predialant<($rowav[0]*2))
		 								{
		 									$baseant=$rowav[1]+0;
		 									$predialant=$rowav[0]+0;
		 								}
		 							}		
								}		
								else
								{
									$baseant=$rowpr[2]+0;
									$predialant=$baseant*($rowpr[10]/1000);
								}
								if ($baseant<=0)
								{
			 						//echo "<br>bas ".$baseant;
								}
								else
								{
			 						if(($predialant>($npredialant*2)) && ($npredialant>0))
			 						{
  			  							//echo "<br> PA:".$npredialant;
			  							$predialant=$npredialant;
			 						}
									//echo "if($predial>($predialant*2) && $r[7]==$areaanterior) <br>";	
									if($predial>($predialant*2) && $r[7]==$areaanterior)
			 						{
			  							//echo "<br>PPP ".$predialant." ".$predial;
			  							$predial=$predialant*2;		
								
			 						}	 
								}
								$npredialant=$predial;
							}
							
							//echo "NP:".$npredialant;
							//*******
							$valoringresos=0;
							//echo "vp:".$valorperiodo.' - Pr:'.$predial;
							$sidescuentos=0;
							//****buscar en el concepto del ingreso *******
							$intereses=array();
							$valoringreso=array();
							//Inicializando intereses a cero
							$intereses[0] = 0;
							$intereses[1] = 0;
							
							$in=0;
							if($cuentavigencias>1)
			 				{
								if($vigusu==$r[0] && ($_POST[descuento]>0 or $condes==1) )
				 				{
									$pdescuento=$_POST[descuento]/100;
									$diasd=0;
									if($_POST[descuentoConDeuda]=='S')
									{
										$tdescuentos+=round(($predial)*$pdescuento,0);
									}			
				  				}
				  				elseif ($interespredial=='inicioanio')//Si se cuentan los dias desde el principio del a�o 
				   				{
									$fechaini=mktime(0,0,0,1,1,$r[0]);
									$fechafin=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
									$difecha=$fechafin-$fechaini;
									$vigenciacobro=$fecha[3];
									$diasd=$difecha/(24*60*60);
									$diasd=floor($diasd);
									$totalintereses=0; 
				   				}
								else //Si se cuentan los dias desde el principio del a�o 
								{
									$sqlrfd="SELECT * FROM tesodescuentoincentivo WHERE vigencia='$r[0]' AND estado='S'";
									$resfd=mysql_query($sqlrfd,$linkbd);
									$rowfd=mysql_fetch_row($resfd);
									if($rowfd[24]!="0000-00-00"){$ulfedes01=$rowfd[24];}
									elseif($rowfd[22]!="0000-00-00"){$ulfedes01=$rowfd[22];}
									elseif($rowfd[20]!="0000-00-00"){$ulfedes01=$rowfd[20];}
									elseif($rowfd[12]!="0000-00-00"){$ulfedes01=$rowfd[12];}
									elseif($rowfd[10]!="0000-00-00"){$ulfedes01=$rowfd[10];}
									else {$ulfedes01=$rowfd[8];}
									ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", date('d/m/Y',strtotime($ulfedes01)),$fechafd);
									$fechainiciocobro=$fecha[2];
									$vigenciacobro=$fecha[3];
									$diascobro=$fecha[1];
									$fechaini=mktime(0,0,0,$fechafd[2],$fechafd[1],$fechafd[3]);
									$fechafin=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
									$difecha=$fechafin-$fechaini;
									if($difecha<'0')
									{
										$ulfedes01=$rowfd[7];
										ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", date('d/m/Y',strtotime($ulfedes01)),$fechafd);
										$fechainiciocobro=$fecha[2];
										$vigenciacobro=$fecha[3];
										$diascobro=$fecha[1];
										$fechaini=mktime(0,0,0,$fechafd[2],$fechafd[1],$fechafd[3]);
										$fechafin=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
										$difecha=$fechafin-$fechaini;
									}
									$diasd=$difecha/(24*60*60);
									$diasd=floor($diasd);
									$totalintereses=0;  
								}
			 				}
			 				else //********* si solo debe la actual vigencia
			 				{ 
			  					$diasd=0;
			  					$totalintereses=0; 
			   					$tdescuentos=0;
			  					$sidescuentos=1;
			   					if($vigusu==$r[0] && ($_POST[descuento]>0 or $condes==1))
				 				{
									$pdescuento=$_POST[descuento]/100; 					
									$tdescuentos+=round(($predial)*$pdescuento,0);
				 				}
				 				elseif ($interespredial=='inicioanio')//Si se cuentan los dias desde el principio del a�o 
				   				{
									$fechaini=mktime(0,0,0,1,1,$r[0]);
									$fechafin=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
									$difecha=$fechafin-$fechaini;
									$vigenciacobro=$fecha[3];
									$diasd=$difecha/(24*60*60);
									$diasd=floor($diasd);
									$totalintereses=0; 
				   				}
								else //Si se cuentan los dias desde el principio del a�o 
								{
									$sqlrfd="SELECT * FROM tesodescuentoincentivo WHERE vigencia='$r[0]' AND estado='S'";
									$resfd=mysql_query($sqlrfd,$linkbd);
									$rowfd=mysql_fetch_row($resfd);
									if($rowfd[24]!="0000-00-00"){$ulfedes01=$rowfd[24];}
									elseif($rowfd[22]!="0000-00-00"){$ulfedes01=$rowfd[22];}
									elseif($rowfd[20]!="0000-00-00"){$ulfedes01=$rowfd[20];}
									elseif($rowfd[12]!="0000-00-00"){$ulfedes01=$rowfd[12];}
									elseif($rowfd[10]!="0000-00-00"){$ulfedes01=$rowfd[10];}
									else {$ulfedes01=$rowfd[8];}
									ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", date('d/m/Y',strtotime($ulfedes01)),$fechafd);
									$fechainiciocobro=$fecha[2];
									$vigenciacobro=$fecha[3];
									$diascobro=$fecha[1];
									$fechaini=mktime(0,0,0,$fechafd[2],$fechafd[1],$fechafd[3]);
									$fechafin=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
									$difecha=$fechafin-$fechaini;
									if($difecha<'0')
									{
										$ulfedes01=$rowfd[7];
										ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", date('d/m/Y',strtotime($ulfedes01)),$fechafd);
										$fechainiciocobro=$fecha[2];
										$vigenciacobro=$fecha[3];
										$diascobro=$fecha[1];
										$fechaini=mktime(0,0,0,$fechafd[2],$fechafd[1],$fechafd[3]);
										$fechafin=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
										$difecha=$fechafin-$fechaini;
									}
									$diasd=$difecha/(24*60*60);
									$diasd=floor($diasd);
									$totalintereses=0; 
									
								}
			 				}
							$y1=12;
							$diascobro1=0;
							if($vigenciacobro==$r[0])
							{
								$y1=$fechainiciocobro;
								$diascobro1=$diascobro;
							}
							$sqlr2="select *from tesoingresos_det where codigo='01' and modulo='4' and  estado='S' and vigencia=$vigusu";
							//echo $sqlr2;
							$res3=mysql_query($sqlr2,$linkbd);
							while($r3=mysql_fetch_row($res3))
							{
								if($r3[5]>0 && $r3[5]<100)
					 			{
					  				if($r3[2]=='03')
					    			{
	
										if( $_POST[basepredial]==1)	
										{
				
											//$valoringreso[0]=round($base*($r3[5]/1000),0)-($base*($r3[5]/1000)*($_POST[deduccion]/100));
											$valoringreso[0]=round($base*($r3[5]/1000),0);
											//$valoringresos+=round($base*($r3[5]/1000),0)-($base*($r3[5]/1000)*($_POST[deduccion]/100));
											$valoringresos+=round($base*($r3[5]/1000),0);	
										}
										if( $_POST[basepredial]==2)
										{	
					  						$valoringreso[0]=round($predial*($r3[5]/100),0);
					  						$valoringresos+=round($predial*($r3[5]/100),0);
										}
										
										
										$totdiastri = 0;
										//Antes del 2017 se cobran intereses trimestrales
										$vig=$vigenciacobro-$r[0];
										$vigcal=$r[0];
											for($j=0;$j<=$vig;$j++)
											{
												//Se consultan los interes de la vigencia por mes
												$sqlintereses = "SELECT inmopri,inmoseg,inmoter,inmocua,inmoquin,inmosex,inmosep,inmooct,inmonov,inmodec,inmoonc,inmodoc from tesotasainteres WHERE vigencia = '".$vigcal."'";
												$resinteres = mysql_query($sqlintereses, $linkbd);
												$rowinteres = mysql_fetch_row($resinteres);
												$x1=3;
												for($i = 1; $i <= $y1 ; $i++)
												{
													if($interespredial!='inicioanio')
													{
														$sqlrfd="SELECT * FROM tesodescuentoincentivo WHERE vigencia='$r[0]' AND estado='S'";
														$resfd=mysql_query($sqlrfd,$linkbd);
														$rowfd=mysql_fetch_row($resfd);
														if($rowfd[24]!="0000-00-00"){$ulfedes01=$rowfd[24];}
														elseif($rowfd[22]!="0000-00-00"){$ulfedes01=$rowfd[22];}
														elseif($rowfd[20]!="0000-00-00"){$ulfedes01=$rowfd[20];}
														elseif($rowfd[12]!="0000-00-00"){$ulfedes01=$rowfd[12];}
														elseif($rowfd[10]!="0000-00-00"){$ulfedes01=$rowfd[10];}
														else {$ulfedes01=$rowfd[8];}
														ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", date('d/m/Y',strtotime($ulfedes01)),$fechafd);
														$fechainiciocobro=$fecha[2];
														$vigenciacobro=$fecha[3];
														$diascobro=$fecha[1];
														$fechaini=mktime(0,0,0,$fechafd[2],$fechafd[1],$fechafd[3]);
														$fechafin=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
														$difecha=$fechafin-$fechaini;
														if($difecha<'0')
														{
															$rowinteres[$i-1]=0;
														}
													}
													if($interespredial!='inicioanio')
													{
														$sqlrfd="SELECT * FROM tesodescuentoincentivo WHERE vigencia='$r[0]' AND estado='S'";
														$resfd=mysql_query($sqlrfd,$linkbd);
														$rowfd=mysql_fetch_assoc($resfd);
														if($rowfd['fechafin4']!="0000-00-00"){$ulfedes01=$rowfd['fechafin4'];}
														elseif($rowfd['fechafin5']!="0000-00-00"){$ulfedes01=$rowfd['fechafin5'];}
														elseif($rowfd['fechafin6']!="0000-00-00"){$ulfedes01=$rowfd['fechafin6'];}
														elseif($rowfd['fechafin3']!="0000-00-00"){$ulfedes01=$rowfd['fechafin3'];}
														elseif($rowfd['fechafin2']!="0000-00-00"){$ulfedes01=$rowfd['fechafin2'];}
														else {$ulfedes01=$rowfd['fechafin1'];}
														$mesesIntereses = explode('-',$ulfedes01);
														if($i <= $mesesIntereses[1])
															continue;
													}
													$numdias = cal_days_in_month(CAL_GREGORIAN, $i, $vigcal);
													$totdiastri += $numdias;
													//echo $fecha[3]."<br>";
													if($i==$fechainiciocobro && $vigcal==$fechafd[3] )
														$numdias=$diascobro1;
													if($vigcal>'2006' && $vigcal<'2017')
													{
														if($i % 3 == 0){
															$intereses[0]+=round(($valoringreso[0]*$totdiastri*($rowinteres[$i-$x1]/100))/365,0);
															$totdiastri = 0;
															$x1+=2;
														}
														
													}
													elseif($vigcal=='2017')
													{
														if($i <= 7)
														{
															if($i % 3 == 0){
																$intereses[0]+=round(($valoringreso[0]*$totdiastri*($rowinteres[$i-$x1]/100))/365,0);
																$totdiastri = 0;
																$x1+=2;
															}
														}
														else{
															$totdiastri = $numdias;
															$intereses[0]+=round(($valoringreso[0]*$totdiastri*($rowinteres[$i-1]/100))/365,0);
														}
													}
													else{
															$totdiastri = $numdias;
															$intereses[0]+=round(($valoringreso[0]*$totdiastri*($rowinteres[$i-1]/100))/365,0);
													}
													
												}
												$vigcal+=1;
											}
					  					$totalintereses+=$intereses[0];						
					    			}
					    			if($r3[2]=='02')
					    			{
										if( $_POST[basepredialamb]==1)	
										{
											$valoringreso[1]=round($base*($r3[5]/1000),0)-($base*($r3[5]/1000)*($_POST[deduccion]/100));
					  						$valoringresos+=round($base*($r3[5]/1000),0)-($base*($r3[5]/1000)*($_POST[deduccion]/100));	
										}	
										if( $_POST[basepredialamb]==2)
										{	
					  						$valoringreso[1]=round($predial*($r3[5]/100),0);
					  						$valoringresos+=round($predial*($r3[5]/100),0);
										}
										$totdiastri = 0;
										//Antes del 2017 se cobran intereses trimestrales
										$vig=$vigenciacobro-$r[0];
										$vigcal=$r[0];
											for($j=0;$j<=$vig;$j++)
											{
												$sqlintereses = "SELECT inmopri,inmoseg,inmoter,inmocua,inmoquin,inmosex,inmosep,inmooct,inmonov,inmodec,inmoonc,inmodoc from tesotasainteres WHERE vigencia = '".$vigcal."'";
												$resinteres = mysql_query($sqlintereses, $linkbd);
												$rowinteres = mysql_fetch_row($resinteres);
												$x1=3;
												for($i = 1; $i <= $y1 ; $i++)
												{
													if($interespredial!='inicioanio')
													{
														$sqlrfd="SELECT * FROM tesodescuentoincentivo WHERE vigencia='$r[0]' AND estado='S'";
														$resfd=mysql_query($sqlrfd,$linkbd);
														$rowfd=mysql_fetch_row($resfd);
														if($rowfd[24]!="0000-00-00"){$ulfedes01=$rowfd[24];}
														elseif($rowfd[22]!="0000-00-00"){$ulfedes01=$rowfd[22];}
														elseif($rowfd[20]!="0000-00-00"){$ulfedes01=$rowfd[20];}
														elseif($rowfd[12]!="0000-00-00"){$ulfedes01=$rowfd[12];}
														elseif($rowfd[10]!="0000-00-00"){$ulfedes01=$rowfd[10];}
														else {$ulfedes01=$rowfd[8];}
														ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", date('d/m/Y',strtotime($ulfedes01)),$fechafd);
														$fechainiciocobro=$fecha[2];
														$vigenciacobro=$fecha[3];
														$diascobro=$fecha[1];
														$fechaini=mktime(0,0,0,$fechafd[2],$fechafd[1],$fechafd[3]);
														$fechafin=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
														$difecha=$fechafin-$fechaini;
														if($difecha<'0')
														{
															$rowinteres[$i-1]=0;
														}
													}
													$numdias = cal_days_in_month(CAL_GREGORIAN, $i, $vigcal);
													$totdiastri += $numdias;
													if($i==$fechainiciocobro && $vigcal==$fechafd[3])
														$numdias=$diascobro1;
													if($vigcal<'2017')
													{
														if($i % 3 == 0){
															$intereses[1]+=round(($valoringreso[1]*$totdiastri*($rowinteres[$i-$x1]/100))/365,0);
															$totdiastri = 0;
															$x1+=2;
														}
													}
													elseif($vigcal=='2017')
													{
														if($i <= 7)
														{
															if($i % 3 == 0){
																$intereses[1]+=round(($valoringreso[1]*$totdiastri*($rowinteres[$i-$x1]/100))/365,0);
																$totdiastri = 0;
																$x1+=2;
															}
														}
														else{
															$totdiastri = $numdias;
															$intereses[1]+=round(($valoringreso[1]*$totdiastri*($rowinteres[$i-1]/100))/365,0);
														}
													}
													else{
															$totdiastri = $numdias;
															$intereses[1]+=round(($valoringreso[1]*$totdiastri*($rowinteres[$i-1]/100))/365,0);
													}
												}
												$vigcal+=1;
											}
					  					$totalintereses+=$intereses[1];
					   				}	
					  				
					 			}
								
							}
							//echo $_POST[tcobroalumbrado]."Hola";
							if($_POST[tcobroalumbrado]=='S' && $_POST[tipop]=='rural' && $r[0]!=2016)
							{
								$valorAlumbrado=round($base*($_POST[vcobroalumbrado]/1000),0);
					  			$valoringresos+=round($base*($_POST[vcobroalumbrado]/1000),0);
							}
							$otros+=$valoringresos;	
							$ipredial = 0;
							$totdiastri = 0;
						//Antes del 2017 se cobran intereses trimestrales
						$vig=$vigenciacobro-$r[0];
						$vigcal=$r[0];
							for($j=0;$j<=$vig;$j++)
							{
								$sqlintereses = "SELECT inmopri,inmoseg,inmoter,inmocua,inmoquin,inmosex,inmosep,inmooct,inmonov,inmodec,inmoonc,inmodoc from tesotasainteres WHERE vigencia = '".$vigcal."'";
								$resinteres = mysql_query($sqlintereses, $linkbd);
								$rowinteres = mysql_fetch_row($resinteres);
								$x1=3;
								for($i = 1; $i <= $y1 ; $i++)
								{
									if($interespredial!='inicioanio')
									{
										$sqlrfd="SELECT * FROM tesodescuentoincentivo WHERE vigencia='$r[0]' AND estado='S'";
										$resfd=mysql_query($sqlrfd,$linkbd);
										$rowfd=mysql_fetch_row($resfd);
										if($rowfd[24]!="0000-00-00"){$ulfedes01=$rowfd[24];}
										elseif($rowfd[22]!="0000-00-00"){$ulfedes01=$rowfd[22];}
										elseif($rowfd[20]!="0000-00-00"){$ulfedes01=$rowfd[20];}
										elseif($rowfd[12]!="0000-00-00"){$ulfedes01=$rowfd[12];}
										elseif($rowfd[10]!="0000-00-00"){$ulfedes01=$rowfd[10];}
										else {$ulfedes01=$rowfd[8];}
										ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", date('d/m/Y',strtotime($ulfedes01)),$fechafd);
										$fechainiciocobro=$fecha[2];
										$vigenciacobro=$fecha[3];
										$diascobro=$fecha[1];
										$fechaini=mktime(0,0,0,$fechafd[2],$fechafd[1],$fechafd[3]);
										$fechafin=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
										$difecha=$fechafin-$fechaini;
										if($difecha<'0')
										{
											$rowinteres[$i-1]=0;
										}
									}
									//echo $i." Hola ".$vigcal."<br>";
									$numdias = cal_days_in_month(CAL_GREGORIAN, $i, $vigcal);
									$totdiastri += $numdias;
									if($i==$fechainiciocobro && $vigcal==$fechafd[3])
										$numdias=$diascobro1;
									if($vigcal<'2017')
									{
										if($i % 3 == 0){
											$ipredial+=round(($predial*$totdiastri*($rowinteres[$i-$x1]/100))/365,0);
											$totdiastri = 0;
											$x1+=2;
										}
									}
									elseif($vigcal=='2017')
									{
										if($i <= 7)
										{
											if($i % 3 == 0){
												$iipredial+=round(($predial*$totdiastri*($rowinteres[$i-$x1]/100))/365,0);
												$totdiastri = 0;
												$x1+=2;
											}
										}
										else{
											$totdiastri = $numdias;
											$ipredial+=round(($predial*$totdiastri*($rowinteres[$i-1]/100))/365,0);
											
										}
									}
									else{
											$totdiastri = $numdias;
											$ipredial+=round(($predial*$totdiastri*($rowinteres[$i-1]/100))/365,0);
									}
									
								}
								$vigcal+=1;
							}
							
							//$otros+=$valoringresos;		
						
							//$ipredial=round(($predial*$tasaintdiaria*$diasd)/365,0);
							
							$chk='';
							$ch=esta_en_array($_POST[dselvigencias], $r[0]);
							if($ch==1){$chk=" checked";}
							$descipred=0;
							if($r[0]<=$_POST[vigmaxdescint] && $_POST[aplicadescint]=='S'){
								$descipred=$ipredial*($_POST[porcdescint]/100)+$intereses[0]*($_POST[porcdescint]/100)+$intereses[1]*($_POST[porcdescint]/100);
							}
							$totalpredial=round($predial+$otros+$totalintereses+$ipredial,0);
							//echo "$predial+$otros+$totalintereses-$descipred+$ipredial <br>";
							$totalpagar=round($totalpredial, 0);
							$sqlrat="SELECT TB1.idpredial FROM tesoliquidapredial_det TB1, tesoliquidapredial TB2 WHERE TB1.idpredial=TB2.idpredial AND TB2.codigocatastral='$r[1]' AND TB1.vigliquidada='$r[0]' AND TB2.estado='S'";
							$resat=mysql_fetch_row(mysql_query($sqlrat,$linkbd));
							if($resat[0]!="")
							{
								$varcol='resaltar01';
								$clihis="onDblClick='hisliquidacion(\"$resat[0]\");'"; 
								$titvig="title='Periodo con Liquidación vigente N° $resat[0]'";
								$_POST[var1]=$resat[0];
							}
							else 
							{
								$sqlrat2="SELECT TB1.id_auto FROM tesoautorizapredial_det TB1, tesoautorizapredial TB2 WHERE TB1.id_auto=TB2.id_auto AND TB2.codcatastral='$r[1]' AND TB1.vigencia='$r[0]' AND TB2.estado='S'";
								$resat2=mysql_fetch_row(mysql_query($sqlrat2,$linkbd));
								if($resat2[0]!="")
								{
									$varcol='resaltar01';
									$clihis="onDblClick='hisautorizacion(\"$resat2[0]\");'"; 
									$titvig="title='Periodo con Autorización de Liquidación vigente N° $resat2[0]'";
									$_POST[var2]=$resat2[0];
								}
								else{$varcol=$co;$clihis=""; $titvig="";}
							}
							if($r[3]=="N")
							{
								$pagosnp="NO PAGO";
							echo "
							<tr class='$varcol' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
					onMouseOut=\"this.style.backgroundColor=anterior\" $clihis $titvig>
								<td>$r[1]</td>
								<td>$ ".number_format($r[2],2)."</td>
								<td>$r[0]</td>
								<td>$_POST[tercero]</td>
								<td>$_POST[ntercero]</td>
								<td style='text-align:right;'>$ ".number_format($predial,2)."</td>  
								<td style='text-align:right;'>$ ".number_format($ipredial,2)."</td>
								<td style='text-align:right;'>$ ".number_format(0,2)."</td>
								<td style='text-align:right;'>$ ".number_format(($valoringreso[0]+0),2)."</td>
								<td style='text-align:right;'>$ ".number_format(($intereses[0]+0),2)."</td>

								<td style='text-align:right;'>$ ".number_format(($valoringreso[1]+0),2)."</td>
								<td style='text-align:right;'>$ ".number_format(($intereses[1]+0),2)."</td>
								<td style='text-align:right;'>$ ".number_format($tdescuentos,2)."</td>
								<td style='text-align:right;'>$ ".number_format($totalpagar,2)."</td>
							    </tr>";
								echo "
									<input type='hidden' name='codCatastral[]' id='codCatastral[]' value='".$r[1]."'>
									<input type='hidden' name='avaluo[]' id='avaluo[]' value='".$r[2]."'>
									<input type='hidden' name='vigencia[]' id='vigencia[]' value='".$r[0]."'>
									<input type='hidden' name='tercero[]' id='tercero[]' value='".$_POST[tercero]."'>
									<input type='hidden' name='nomTercero[]' id='nomTercero[]' value='".$_POST[ntercero]."'>
									<input type='hidden' name='predial[]' id='predial[]' value='".$predial."'>
									<input type='hidden' name='intPredial[]' id='intPredial[]' value='".$ipredial."'>
									<input type='hidden' name='descInteresPredial[]' id='descInteresPredial[]' value='0'>
									<input type='hidden' name='bomberil[]' id='bomberil[]' value='".($valoringreso[0]+0)."'>
									<input type='hidden' name='intBomberil[]' id='intBomberil[]' value='".($intereses[0]+0)."'>
									<input type='hidden' name='ambiental[]' id='ambiental[]' value='".($valoringreso[1]+0)."'>
									<input type='hidden' name='intAmbiental[]' id='intAmbiental[]' value='".($intereses[1]+0)."'>
									<input type='hidden' name='descuento[]' id='descuento[]' value='".$tdescuentos."'>
									<input type='hidden' name='totalAPagar[]' id='totalAPagar[]' value='".$totalpagar."'>
									<input type='hidden' name='estado[]' id='estado[]' value='".$pagosnp."'>
                                ";
							fputs($Descriptor1,"Cod: ".$r[1].";".$r[0].";".$_POST[tercero].";".$_POST[ntercero].";".$direccion.";".$r[2].";".$predial.";".$ipredial.";".str_replace(".",",",0).";".($valoringreso[0]+0).";".($intereses[0]+0).";".($valoringreso[1]+0).";".($intereses[1]+0).";".$totalpagar.";".$pagosnp."\r\n");

							$aux=$co;
							$co=$co2;
							$co2=$aux;
							$xpm=$xpm+1;
							}
		 				}
		 				//***terminacion campos
		}
		
		?>        
      </table>
      </div>
      <table class="inicio">
      <tr><td class="saludo1">Total Liquidaci&oacute;n:</td>
	  <td><input type="text" name="totliquida2" value="<?php echo number_format($_POST[totliquida2],2)?>" size="12"  readonly>
	  <input type="hidden" name="totliquida" value="<?php echo $_POST[totliquida]?>" size="12" readonly></td>
	  <td class="saludo1">Total Predial:</td>
	  <td>
		<input type="hidden" name="intpredial" value="<?php echo $_POST[intpredial]?>">
		<input type="text" name="totpredial" value="<?php echo $_POST[totpredial]?>" size="9" readonly></td>
	<td class="saludo1">Total Sobret Bomberil:</td>
	<td>
		<input type="hidden" name="intbomb" value="<?php echo $_POST[intbomb]?>">
		<input type="text" name="totbomb" value="<?php echo $_POST[totbomb]?>" size="9" readonly></td>
	<td class="saludo1">Total Sobret Ambiental:</td>
	<td>
		<input type="hidden" name="intamb" value="<?php echo $_POST[intamb]?>">
		<input type="text" name="totamb" value="<?php echo $_POST[totamb]?>" size="9" readonly></td>
	<td class="saludo1">Total Intereses:</td>
	<td>
		<input type="text" name="totint" value="<?php echo $_POST[totint]?>" size="9" readonly></td>
		<td class="saludo1">Total Descuentos:</td>
		<td>
		<input type="text" name="totdesc"  value="<?php echo $_POST[totdesc]?>" size="9" readonly></td></tr>
  
      </table>
</form>
 </td></tr>
</table>
</body>
</html>