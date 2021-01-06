<?php //V 1000 12/12/16 ?> 
<?php
require "comun.inc";
require "funciones.inc";
require "conversor.php";
//session_start();
sesion();
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
document.form2.action="pdfpredial.php";
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
vtotalintp=document.getElementsByName("ditpredial[]"); 	
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
  <td colspan="3" class="cinta"><a href="teso-predial.php" ><img src="imagenes/add.png" alt="Nuevo"  border="0" /></a> <a href="#" onClick="guardar()" ><img src="imagenes/guarda.png"  alt="Guardar" /></a><a href="teso-buscapredial.php"> <img src="imagenes/busca.png"  alt="Buscar" /></a> <a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" alt="nueva ventana"></a> <a href="#" <?php if($_POST[oculto]==2) { ?> onClick="pdf()" <?php } ?>> <img src="imagenes/print.png"  alt="Buscar" /></a></td>
</tr>		  
</table>
<tr>
<td colspan="3" class="tablaprin" align="center"> 
<?php
$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
$vigencia=$vigusu;
 ?>	
<?php
if(0>diferenciamesesfechas_f2($_POST[fecha],$_POST[fechaav]))
{
 ?>
 <script>alert("LA FECHA DE PROYECCION DE LIQUIDACION NO PUEDE SER MENOR A LA FECHA ACTUAL")</script>
 <?php
 $_POST[fechaav]=$_POST[fecha];
}
	  //*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
if(!$_POST[oculto])
{
	$linkbd=conectar_bd();
	
	$sqlr="select valor_inicial,valor_final, tipo from dominios where nombre_dominio='BASE_PREDIAL' ";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
	{
	 $_POST[basepredial]=$row[0];
	}
	$sqlr="select valor_inicial,valor_final, tipo from dominios where nombre_dominio='BASE_PREDIALAMB' ";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
	{
	 $_POST[basepredialamb]=$row[0];
	}
	
	 $sqlr="select valor_inicial,valor_final, tipo from dominios where nombre_dominio='NORMA_PREDIAL' ";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
	{
	 $_POST[aplicapredial]=$row[0];
	}

	
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
			//echo $sqlr;
			$res=mysql_query($sqlr,$linkbd);
			$r=mysql_fetch_row($res);
			$tasam=array();
			$tasam[0]=$r[6];									
			$tasam[1]=$r[7];
			$tasam[2]=$r[8];
			$tasam[3]=$r[9];
			$tasamoratoria[0]=0;
			
			ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
//			$fechaactual=$fecha[3]."-".$fecha[2]."-".$fecha[1];
			//$fecha[2]=round($fecha[2],0);
			//echo "<br>ve:".round($fecha[2],0);
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
			 $condes=0;
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
 				 $condes=1;   
			   }
			  if($fechaactual>$r[9] && $fechaactual <= $r[10])
			   {
				 $fdescuento=$r[2];	 
				 $_POST[descuento]=$r[3];	   
				 $condes=1;
			   }
			  if($fechaactual>$r[11] && $fechaactual <= $r[12])
			   {
				 $fdescuento=$r[2];	 
				 $_POST[descuento]=$r[4];	   
				 $condes=1;				 
			   }  
			}
//*************cuenta caja
	$sqlr="select valor_inicial from dominios where nombre_dominio='CUENTA_CAJA'";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
	{
	 $_POST[cuentacaja]=$row[0];
	}
	$sqlr="select max(numerotipo) from comprobante_cab where tipo_comp='8' ";
	$res=mysql_query($sqlr,$linkbd);
	$consec=0;
	while($r=mysql_fetch_row($res))
	 {
	  $consec=$r[0];	  
	 }
	 $consec+=1;
	 $_POST[idcomp]=$consec;	
 		 $fec=date("d/m/Y");
		 $_POST[fecha]=$fec; 	
		 $_POST[fechaav]=$fec; 		 		  			 
		 $_POST[valor]=0;		 

}
else
 {
	 $linkbd=conectar_bd();
$sqlr="select *from tesotasainteres where vigencia=".$vigusu;
//		echo $sqlr;
			$res=mysql_query($sqlr,$linkbd);
			$r=mysql_fetch_row($res);
			$tasam=array();
			$tasam[0]=$r[6];									
			$tasam[1]=$r[7];
			$tasam[2]=$r[8];
			$tasam[3]=$r[9];
			$tasamoratoria[0]=0;
$sqlr="select *from tesotasainteres where vigencia=".$vigusu;
		//echo $sqlr;
			$res=mysql_query($sqlr,$linkbd);
			$r=mysql_fetch_row($res);
			$tasam=array();
			$tasam[0]=$r[6];									
			$tasam[1]=$r[7];
			$tasam[2]=$r[8];
			$tasam[3]=$r[9];
			$tasamoratoria[0]=0;

			ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechaav],$fecha);
//			$fechaactual=$fecha[3]."-".$fecha[2]."-".$fecha[1];
			//echo $fecha[2];
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
				ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechaav],$fecha);
			$fechaactual=$fecha[3]."-".$fecha[2]."-".$fecha[1];	
			$condes=0;
			$sqlr="select *from tesodescuentoincentivo where vigencia=".$vigusu." and ingreso='01' and estado='S'";
			$res=mysql_query($sqlr,$linkbd);
			//echo $sqlr;
			while($r=mysql_fetch_row($res))
			{	
		
			  if($r[7]<=$fechaactual && $fechaactual <= $r[8])
			   {
				 $fdescuento=$r[2];	 
				 $_POST[descuento]=$r[2];	   
				 $condes=1;
			   }
			  if($fechaactual>$r[9] && $fechaactual <= $r[10])
			   {
				 $fdescuento=$r[2];	 
				 $_POST[descuento]=$r[3];	   
				 $condes=1;				 
			   }
			  if($fechaactual>$r[11] && $fechaactual <= $r[12])
			   {
				 $fdescuento=$r[2];	 
				 $_POST[descuento]=$r[4];	   
				 $condes=1;				 
			   }  
			}
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
  
if($_POST[buscav]=='1')
 {
	 $_POST[dcuentas]=array();
	 $_POST[dncuentas]=array();
	 $_POST[dtcuentas]=array();		 
	 $_POST[dvalores]=array();

	 $linkbd=conectar_bd();
	 $sqlr="select *from tesopredios where cedulacatastral=".$_POST[codcat]." and ord='".$_POST[ord]."'  and tot='".$_POST[tot]."'";
	 //echo "s:$sqlr";
	 $res=mysql_query($sqlr,$linkbd);
	 while($row=mysql_fetch_row($res))
	  {
		  //$_POST[vigencia]=$row[0];
		  $_POST[catastral]=$row[0];
		  $_POST[ntercero]=$row[6];
		  $_POST[tercero]=$row[5];
		  $_POST[direccion]=$row[7];
		  $_POST[ha]=$row[8];
		  $_POST[mt2]=$row[9];
		  $_POST[areac]=$row[10];
		  $_POST[avaluo]=number_format($row[11],2);
		  $_POST[avaluo2]=number_format($row[11],2);
		  $_POST[vavaluo]=$row[11];
		  $_POST[tipop]=$row[14];
		  if($_POST[tipop]=='urbano')
			{$_POST[estrato]=$row[15];
			$tipopp=$row[15];}
			else
			{$_POST[rangos]=$row[15];
						$tipopp=$row[15];}
				// $_POST[dcuentas][]=$_POST[estrato];		
		 $_POST[dtcuentas][]=$row[1];		 
		 $_POST[dvalores][]=$row[5];
		 $_POST[buscav]="";
		 $sqlr2="select *from tesotarifaspredial where vigencia='".$vigusu."' and tipo='$_POST[tipop]' and estratos=$tipopp";
			//echo $sqlr2;
		 $res2=mysql_query($sqlr2,$linkbd);
	 		while($row2=mysql_fetch_row($res2))
			  {
			   $_POST[tasa]=$row2[5];
			   $_POST[predial]=($row2[5]/1000)*$_POST[vavaluo];
			   $_POST[predial]=number_format($_POST[predial],2);
			  }
	  }
	  	 // echo "dc:".$_POST[dcuentas];
  }
?>
 <div class="tabspre">
   <div class="tab">
       <input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
	   <label for="tab-1">Liquidacion Predial</label>
	   <div class="content">
           <table class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="9">Liquidar Predial</td><td class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
      </tr>
     <tr><td class="saludo1">No Liquidacion:</td><td><input name="numpredial" type="text" value="<?php echo $_POST[numpredial]?>"  size="8" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly></td><td class="saludo1">Fecha:</td><td><input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10" size="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly></td><td class="saludo1">Vigencia:</td><td><input name="vigencia" type="text" value="<?php echo $_POST[vigencia]?>" maxlength="2" size="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly></td><td class="saludo1">Tasa Interes Mora:</td><td><input name="tasamora" type="text" value="<?php echo $_POST[tasamora]?>" size="5" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly>%</td>
    <td class="saludo1">Descuento:</td><td><input name="descuento" type="text" value="<?php echo $_POST[descuento]?>"  size="5" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly>%</td ></tr>
	  <tr><td class="saludo1">Proy Liquidacion:</td><td><input name="fechaav" type="text" value="<?php echo $_POST[fechaav]?>" maxlength="10" size="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" readonly>   <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>  </td> <td width="128" class="saludo1">Codigo Catastral:</td>
          <td colspan="3"><input id="codcat" type="text" name="codcat" size="20" onKeyUp="return tabular(event,this)" onBlur="buscar(event)" value="<?php echo $_POST[codcat]?>" ><input id="ord" type="text" name="ord" size="3"  value="<?php echo $_POST[ord]?>" readonly><input id="tot" type="text" name="tot" size="3" value="<?php echo $_POST[tot]?>" readonly><input type="hidden" value="0" name="bt">  <a href="#" onClick="mypop=window.open('catastral-ventana.php','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=900,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a><input type="hidden" name="chacuerdo" value="1"><input type="hidden" value="1" name="oculto"></td><td> <input type="hidden" value="<?php echo  $_POST[basepredial] ?>" name="basepredial"><input type="hidden" value="<?php echo  $_POST[basepredialamb] ?>" name="basepredialamb"><input type="hidden" value="<?php echo  $_POST[aplicapredial] ?>" name="aplicapredial"><input type="hidden" value="<?php echo  $_POST[vigmaxdescint] ?>" name="vigmaxdescint"><input type="hidden" value="<?php echo  $_POST[porcdescint] ?>" name="porcdescint"><input type="hidden" value="<?php echo  $_POST[aplicadescint] ?>" name="aplicadescint"><input type="hidden" value="<?php echo $_POST[buscav]?>" name="buscav"><input type="button" name="buscarb" id="buscarb" value="   Buscar   " onClick="buscar()" ></td>
        </tr>
        <tr><td class="saludo1">Avaluo Vigente:</td><td><input name="avaluo2" value="<?php echo $_POST[avaluo2]?>" type="text" size="20" readonly><input type="hidden" name="vavaluo"  value="<?php echo $_POST[vavaluo]?>" > </td><td class="saludo1">Tasa Predial	:</td><td><input name="tasa" value="<?php echo $_POST[tasa]?>" type="text" size="4" readonly>xmil</td><td ></td><td><input name="predial" value="<?php echo $_POST[predial]?>" type="hidden"  readonly></td><td class="saludo1">Deduccion Ajuste:</td><td><input name="deduccion" value="<?php echo $_POST[deduccion]?>" type="text" size="10" onBlur="document.form2.submit()" ></td></tr>
	  </table>
	</div> 
	</div>
     <div class="tab">
       <input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?>>
       <label for="tab-2">Informacion Predio</label>
       <div class="content"> 
		  <table class="inicio">
	  <tr>
	    <td class="titulos" colspan="8">Informacion Predio</td></tr>
	  <tr>
	  <td width="119" class="saludo1">Codigo Catastral:</td>
	  <td width="202" ><input type="hidden" value="<?php echo $_POST[nbanco]?>" name="nbanco"> <input name="catastral" type="text" id="catastral" onBlur="buscater(event)"  onKeyUp="return tabular(event,this)" value="<?php echo $_POST[catastral]?>" size="20" readonly></td>
			   
		 <td width="82" class="saludo1">Avaluo:</td>
	  <td colspan="5"><input name="avaluo" type="text" id="avaluo" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[avaluo]?>" size="20" readonly>
	  </td></tr>
      <tr> <td width="82" class="saludo1">Documento:</td>
	  <td ><input name="tercero" type="text" id="tercero" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[tercero]?>" size="20" readonly>
	  </td>
	  <td width="119" class="saludo1">Propietario:</td>
	  <td width="202" colspan="5" ><input type="hidden" value="<?php echo $_POST[nbanco]?>" name="nbanco"> <input name="ntercero" type="text" id="propietario" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[ntercero]?>" size="76" readonly></td>
			   
		</tr>
      <tr>
	  <td width="119" class="saludo1">Direccion:</td>
	  <td width="202" ><input type="hidden" value="<?php echo $_POST[nbanco]?>" name="nbanco"> <input name="direccion" type="text" id="direccion" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[direccion]?>" size="40" readonly></td>
			   
		 <td width="82" class="saludo1">Ha:</td>
	  <td width="124"><input name="ha" type="text" id="ha" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[ha]?>" size="6" readonly>
	  </td>
	  <td width="72" class="saludo1">Mt2:</td>
	  <td width="144"><input name="mt2" type="text" id="mt2" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[mt2]?>" size="6" readonly></td>
	  <td width="76" class="saludo1">Area Cons:</td>
	  <td width="206"><input name="areac" type="text" id="areac" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[areac]?>" size="6" readonly></td>
      </tr>
	  <tr>
	     <td width="119" class="saludo1">Tipo:</td><td width="202"><select name="tipop" onChange="validar();" disabled>
       <option value="">Seleccione ...</option>
				  <option value="urbano" <?php if($_POST[tipop]=='urbano') echo "SELECTED"?>>Urbano</option>
  				  <option value="rural" <?php if($_POST[tipop]=='rural') echo "SELECTED"?>>Rural</option>
				  </select>
                 </td>
         <?php
		 if($_POST[tipop]=='urbano')
		 {
		  ?> 
        <td class="saludo1">Estratos:</td><td><select name="estrato"  disabled>
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
            <select name="rangos" >
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
            <input type="hidden" value="<?php echo $_POST[nrango]?>" name="nrango">            <input type="hidden" value="0" name="agregadet"></td>
                <?php
		  }
		  ?> 
        </tr> 
      </table>
		</div> 
	</div>    
</div>
	  <div class="subpantallac">
      <table class="inicio">
	   	   <tr>
	   	     <td colspan="14" class="titulos">Periodos a Liquidar  </td>
	   	   </tr>                  
		<tr>
		  <td  class="titulos2">Vigencia</td>
		  <td  class="titulos2">Codigo Catastral</td>
   		  <td class="titulos2">Predial</td>
   		  <td  class="titulos2">Intereses Predial</td>   
   		  <td  class="titulos2">Desc. Intereses</td> 
 		  <td  class="titulos2">Tot. Int Predial</td>                              
		  <td  class="titulos2">Sobretasa Bombe</td>
          <td  class="titulos2">Intereses</td>
		  <td class="titulos2">Sobretasa Amb</td>
          <td  class="titulos2">Intereses</td>
          <td  class="titulos2">Descuentos</td>
          <td  class="titulos2">Valor Total</td>
          		  <td  class="titulos2">Dias Mora</td>
		  <td width="3%" class="titulos2">Sel
		    <input type='hidden' name='buscarvig' id='buscarvig'></td></tr>
            <?php			
			ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechaav],$fecha);
			$fechaactual=$fecha[3]."-".$fecha[2]."-".$fecha[1];					
			  //$tasaintdiaria=(pow((1+$_POST[tasamora]/100),(1/365))-1); Compuesta
			  $tasaintdiaria=($_POST[tasamora]/100);
			  $cuentavigencias=0;
			  $tdescuentos=0;
			  $baseant=0;
			  $npredialant=0;
			  $co="zebra1";
			  $co2="zebra2";
			$sqlr="Select *from tesoprediosavaluos,tesopredios where tesoprediosavaluos.codigocatastral='$_POST[catastral]' and   tesoprediosavaluos.estado='S' and tesoprediosavaluos.pago='N' and tesoprediosavaluos.codigocatastral=tesopredios.cedulacatastral order by tesoprediosavaluos.vigencia ASC";		
			$res=mysql_query($sqlr,$linkbd);
			//echo $sqlr;
			$cuentavigencias = mysql_num_rows($res);
			$cv=0;
			while($r=mysql_fetch_row($res))
			{		
			$otros=0; 
			//$sqlr2="select *from tesotarifaspredial where vigencia='".$vigusu."' and tipo='$r[19]' and estratos=$r[20]";
			$sqlr2="select *from tesotarifaspredial where vigencia='".$r[0]."' and tipo='$r[21]' and estratos='$r[22]'";
			//echo $sqlr2;
			 $res2=mysql_query($sqlr2,$linkbd);
	 		$row2=mysql_fetch_row($res2);
			$base=$r[2];
			//$_POST[vavaluo]=$row[2];
			$valorperiodo=$base*($row2[5]/1000)-$_POST[deduccion];
			$tasav=$row2[5];
			$predial=$base*($row2[5]/1000)-$_POST[deduccion];
			
			
			//**validacion normatividad predial *****
		if($_POST[aplicapredial]=='S')
		{
		$sqlrp="select distinct * from tesoprediosavaluos where tesoprediosavaluos.codigocatastral='$_POST[catastral]' and vigencia=".($r[0]-1)." ";		
	 	$respr=mysql_query($sqlrp,$linkbd);
 		$rowpr=mysql_fetch_row($respr);
		$baseant=0;		
		$estant=$rowpr[3];
		$baseant=$rowpr[2]+0;
		
		$predialant=$baseant*($row2[5]/1000);
		if($estant=='S')
		{	
		$sqlrav="select distinct tesoliquidapredial_det.predial,tesoliquidapredial_det.avaluo from tesoliquidapredial_det,tesoliquidapredial where tesoliquidapredial_det.idpredial=tesoliquidapredial.idpredial and tesoliquidapredial.codigocatastral='$_POST[catastral]' and tesoliquidapredial.estado='P' AND tesoliquidapredial_det.vigliquidada='".($r[0]-1)."'";
		//echo "".$sqlrav;
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
		//echo "".$sqlrp;
		$baseant=$rowpr[2]+0;
		$predialant=$baseant*($row2[5]/1000);
		}
			// echo "<br>bas ".$predialant."  PR:".$predial;
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
			 if($predial>($predialant*2))
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
			$in=0;
			if($cuentavigencias>1)
			 {
				if($vigusu==$r[0] && ($_POST[descuento]>0 or $condes==1) )
				 {
				 $diasd=0;
				 $totalintereses=0; 
			  	 $sidescuentos=0;
				  }
				  else
				   {
					   if($cv==0)  
					   {
						$fechaini=mktime(0,0,0,5,1,$r[0]);						   
						$cv+=1;
						   }
						else
						{					
						$fechaini=mktime(0,0,0,1,1,$r[0]);
					}
//				$fechaini=mktime(0,0,0,1,1,$r[0]);
				$fechafin=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
				$difecha=$fechafin-$fechaini;
				$diasd=$difecha/(24*60*60);
				$diasd=floor($diasd);
			 	$totalintereses=0; 
				   }
			 }
			 else
			 { //********* si solo debe la actual vigencia
			  $diasd=0;
			  $totalintereses=0; 
			   $tdescuentos=0;
			  $sidescuentos=1;			  
			 // echo "Aqui";
			   if($vigusu==$r[0] && ($_POST[descuento]>0 or $condes==1))
				 {
					$pdescuento=$_POST[descuento]/100; 					
					$tdescuentos+=round(($predial)*$pdescuento,0);
				 }
				 else
				 {
					//  echo "Aqui";
					$fechaini=mktime(0,0,0,5,1,$r[0]);	 
					$fechafin=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
				$difecha=$fechafin-$fechaini;
				$diasd=$difecha/(24*60*60);
				$diasd=floor($diasd);
				//$totalintereses=0; 
				 }
			 }
			
					$sqlr2="select *from tesoingresos_det where codigo='01' and modulo='4' and  estado='S' and vigencia=$vigusu order by concepto";
					//echo $sqlr2;
					$res3=mysql_query($sqlr2,$linkbd);
				while($r3=mysql_fetch_row($res3))
					{
					if($r3[5]>0 && $r3[5]<100)
					 {
					
					  if($r3[2]=='03')
					    {
//								 echo $tasaintdiaria."-";
						if( $_POST[basepredial]==1)	
						{
						//$valoringreso[0]=round($_POST[vavaluo]*($r3[5]/1000),0);
					  	//$valoringresos+=round($_POST[vavaluo]*($r3[5]/1000),0);	
						//$valoringreso[0]=round($base*($r3[5]/1000),0);
					  	//$valoringresos+=round($base*($r3[5]/1000),0);	
						$valoringreso[0]=round($base*($r3[5]/1000),0)-round($_POST[deduccion]*($r3[5]/1000),0);
					  	$valoringresos+=round($base*($r3[5]/1000),0)-round($_POST[deduccion]*($r3[5]/1000),0);	
						}
						if( $_POST[basepredial]==2)
						{	
					  	$valoringreso[0]=round($predial*($r3[5]/100),0);
					  	$valoringresos+=round($predial*($r3[5]/100),0);
						}
					  //$intereses[0]=ceil($valoringreso[0]*(pow(1+$tasaintdiaria,$diasd)-1));  Compuesta
					  $intereses[0]=round(($valoringreso[0]*$diasd*$tasaintdiaria)/365,0);
					  $totalintereses+=$intereses[0];						
					    }
					    if($r3[2]=='02')
					    {
						if( $_POST[basepredialamb]==1)	
						{
						//$valoringreso[1]=round($_POST[vavaluo]*($r3[5]/1000),0);
					  	//$valoringresos+=round($_POST[vavaluo]*($r3[5]/1000),0);	
						$valoringreso[1]=round($base*($r3[5]/1000),0)-round($_POST[deduccion]*($r3[5]/1000),0);
					  	$valoringresos+=round($base*($r3[5]/1000),0)-round($_POST[deduccion]*($r3[5]/1000),0);	
						}	
						if( $_POST[basepredialamb]==2)
						{	
					  $valoringreso[1]=round($predial*($r3[5]/100),0);
					  $valoringresos+=round($predial*($r3[5]/100),0);
						}
					  //$intereses[1]=ceil($valoringreso[1]*(pow(1+$tasaintdiaria,$diasd)-1)); Compuesta
					  $intereses[1]=round(($valoringreso[1]*$diasd*$tasaintdiaria)/365,0);
					  $totalintereses+=$intereses[1];						 
					    }	
					  if($sidescuentos==1 && '03'==$r3[2])
					   {
						 $tdescuentos+=round($valoringreso[0]*$pdescuento,0);
						}
						 //echo $totalintereses."-";				
					 }
					}
					//echo "+".$valoringresos;
			$otros+=$valoringresos;		
			//$ipredial=ceil($predial*(pow(1+$tasaintdiaria,$diasd)-1));
			$ipredial=round(($predial*$tasaintdiaria*$diasd)/365,0);
			
			$ch=esta_en_array($_POST[dselvigencias], $r[0]);
			if($ch==1)
			 {
			 $chk="checked";
			 }
			 $descipred=0;
			 if($r[0]<=$_POST[vigmaxdescint] && $_POST[aplicadescint]=='S')
			 {
			 $descipred=$ipredial*($_POST[porcdescint]/100);
			 }
			 $totalpredial=round($predial+$otros+$totalintereses-$descipred+$ipredial,0);
			 $totalpagar=round($totalpredial- round($tdescuentos,0),0);
			//*************	
			 echo "<tr class='$co'><td ><input name='dvigencias[]' value='".$r[0]."' type='text' size='4' readonly></td><td><input name='dcodcatas[]' value='".$r[1]."' type='text' size='16' readonly><input name='dvaloravaluo[]' value='".$base."' type='text' ><input name='dtasavig[]' value='".$tasav."' type='hidden' ></td><td ><input name='dpredial[]' value='".$predial."' type='text' size='12' readonly></td><td ><input name='dipredial[]' value='".$ipredial."' type='text' size='7' readonly></td><td ><input name='ddescipredial[]' value='".$descipred."' type='text' size='7' readonly></td><td ><input name='ditpredial[]' value='".($ipredial-$descipred)."' type='text' size='7' readonly></td><td ><input name='dimpuesto1[]' value='".$valoringreso[0]."' type='text'  size='12' readonly></td><td ><input name='dinteres1[]' value='".$intereses[0]."' type='text' size='7' readonly></td><td ><input name='dimpuesto2[]' value='".$valoringreso[1]."' type='text'  size='12' readonly></td><td ><input name='dinteres2[]' value='".$intereses[1]."' type='text' size='7' readonly></td><td><input type='text' name='ddescuentos[]' value='$tdescuentos' size='6' readonly></td><td ><input name='davaluos[]' value='".number_format($totalpagar,2)."' type='text' size='10' readonly><input name='dhavaluos[]' value='".$totalpagar."' type='hidden' ></td><td ><input type='text' name='dias[]' value='$diasd' size='4' readonly></td><td><input type='checkbox' name='dselvigencias[]' value='$r[0]' onClick='buscavigencias(this)' $chk></td></tr>";
		 $_POST[totalc]=$_POST[totalc]+$_POST[davaluos][$x];
		 $_POST[totalcf]=number_format($_POST[totalc],2,".",",");
		 $aux=$co;
		 $co=$co2;
		 $co2=$aux;
		 //$ageliqui=$ageliqui." ".$_POST[dselvigencias][$x];
		 }
 			$resultado = convertir($_POST[totliquida]);
			$_POST[letras]=$resultado." PESOS M/CTE";	
		?> 
      </table>
      </div>
      <table class="inicio">
      <tr><td class="saludo1">Total Liquidacion:</td><td><input type="text" name="totliquida2" value="<?php echo number_format($_POST[totliquida2],2)?>" size="12"  readonly><input type="hidden" name="totliquida" value="<?php echo $_POST[totliquida]?>" size="12" readonly></td><td class="saludo1">Total Predial:</td><td><input type="hidden" name="intpredial" value="<?php echo $_POST[intpredial]?>"><input type="text" name="totpredial" value="<?php echo $_POST[totpredial]?>" size="9" readonly></td><td class="saludo1">Total Sobret Bomberil:</td><td><input type="hidden" name="intbomb" value="<?php echo $_POST[intbomb]?>"><input type="text" name="totbomb" value="<?php echo $_POST[totbomb]?>" size="9" readonly></td><td class="saludo1">Total Sobret Ambiental:</td><td><input type="hidden" name="intamb" value="<?php echo $_POST[intamb]?>"><input type="text" name="totamb" value="<?php echo $_POST[totamb]?>" size="9" readonly></td><td class="saludo1">Total Intereses:</td><td><input type="text" name="totint" value="<?php echo $_POST[totint]?>" size="9" readonly></td><td class="saludo1">Total Descuentos:</td><td><input type="text" name="totdesc"  value="<?php echo $_POST[totdesc]?>" size="9" readonly></td></tr>
      <tr><td class="saludo1" >Son:</td><td colspan="8"><input type="text" name="letras"  value="<?php echo $_POST[letras]?>" size="155"></td></tr>
      </table>
	<?php
	if ($_POST[oculto]=='2')
	 {
		 ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	  $linkbd=conectar_bd();
	  $sqlr="insert into tesoliquidapredial ( `codigocatastral`, `fecha`, `vigencia`, tercero,`tasamora`, `descuento`, `tasapredial`, `totaliquida`, `totalpredial`, `totalbomb`, `totalmedio`, `totalinteres`, `intpredial`, `intbomb`, `intmedio`, `totaldescuentos`, concepto,`estado`,ord,tot) values ('$_POST[catastral]','$fechaf','".$vigusu."','$_POST[tercero]',$_POST[tasamora],$_POST[descuento],$_POST[tasa],$_POST[totliquida],$_POST[totpredial], $_POST[totbomb],$_POST[totamb] ,$_POST[totint],$_POST[intpredial],$_POST[intbomb],$_POST[intamb],$_POST[totdesc],'".utf8_decode("Años Liquidados:".$ageliqui)."','S','$_POST[ord]','$_POST[tot]')";

	if(!mysql_query($sqlr,$linkbd))
	 {
	  echo "<table class='inicio'><tr><td class='saludo1'>No Se ha podido Liquidar el Predial ".mysql_error($linkbd)."<img src='imagenes\alert.png'></td></tr></table>";  
	 }
	  else
	   {
		 $idp=mysql_insert_id(); 
		 echo "<input name='idpredial' value='$idp' type='hidden' >";
		 echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha Liquidado el Predial <img src='imagenes\confirm.png'></center></td></tr></table>";  
		 for ($y=0;$y<count($_POST[dselvigencias]);$y++)
		  {
		 for($x=0;$x<count($_POST[dvigencias]);$x++)
		  {
			  if($_POST[dvigencias][$x]==$_POST[dselvigencias][$y])
			  {
		 $sqlr="insert into tesoliquidapredial_det (`idpredial`, `vigliquidada`, avaluo,tasav,`predial`, `intpredial`, `bomberil`, `intbomb`, `medioambiente`, `intmedioambiente`, `descuentos`, `totaliquidavig`, `estado`) values ($idp,'".$_POST[dvigencias][$x]."',".$_POST[dvaloravaluo][$x].",".$_POST[dtasavig][$x].",".$_POST[dpredial][$x].",".$_POST[ditpredial][$x].",".$_POST[dimpuesto1][$x].",".$_POST[dinteres1][$x].",".$_POST[dimpuesto2][$x].",".$_POST[dinteres2][$x].",".$_POST[ddescuentos][$x].",".$_POST[dhavaluos][$x].",'S')";
		 	mysql_query($sqlr,$linkbd);
			$ageliqui=$ageliqui." ".$_POST[dselvigencias][$y];
			  }
		  }		 
		  }
		   echo "<table class='inicio'><tr><td class='saludo1'><center>".utf8_decode("Años Liquidados:")." $ageliqui <img src='imagenes\confirm.png'> </center></td></tr></table>";  		   
		}  
	 }
    ?>
</form>

 </td></tr>
</table>
</body>
</html>