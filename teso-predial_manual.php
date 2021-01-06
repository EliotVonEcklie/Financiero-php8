<?php //V 1000 12/12/16 ?> 
<?php
	require "comun.inc";
	require "funciones.inc";
	require "conversor.php";
	setlocale(LC_ALL,"es_ES");
	sesion();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: SPID - Tesoreria</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <link href="css/tabs.css" rel="stylesheet" type="text/css" />
   		<script type="text/javascript" src="css/programas.js"></script>
        <script type="text/javascript" src="css/calendario.js"></script>
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
function totalesvig()
{	
vvigencias=document.getElementsByName('dselvigencias[]');
vtotalpred=document.getElementsByName("dpredial[]"); 	
vtotaliqui=document.getElementsByName("dhavaluos[]"); 
vtotaliqui2=document.getElementsByName("davaluos[]"); 	
vtotalbomb=document.getElementsByName("dimpuesto1[]"); 	
vtotalmedio=document.getElementsByName("dimpuesto2[]"); 	
vtotalintp=document.getElementsByName("dipredial[]"); 	
vtotalintb=document.getElementsByName("dinteres1[]"); 	
vtotalintma=document.getElementsByName("dinteres2[]"); 	
vtotaldes=document.getElementsByName("ddescuentos[]"); 	
sumar=0;
for(x=0;x<vvigencias.length;x++)
 {
  sumar=0;	 
   if(vvigencias.item(x).checked)
	 {
  sumar=parseFloat(vtotalpred.item(x).value)+parseFloat(vtotalbomb.item(x).value)+parseFloat(vtotalmedio.item(x).value)+parseFloat(vtotalintp.item(x).value)+parseFloat(vtotalintb.item(x).value)+parseFloat(vtotalintma.item(x).value)-parseFloat(vtotaldes.item(x).value); 
  vtotaliqui.item(x).value=sumar;
  vtotaliqui2.item(x).value=sumar;
  //alert("entro"+vtotaliqui.item(x).value);
	 }
 }
 
}
</script>
<
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
			<a href="teso-predial_manual.php" ><img src="imagenes/add.png" alt="Nuevo"  border="0" /></a>
			<a href="#" onClick="guardar()" ><img src="imagenes/guarda.png"  alt="Guardar" /></a>
			<a href="#"> <img src="imagenes/buscad.png"  alt="Buscar" /></a>
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" alt="nueva ventana"></a>
			<a href="#" <?php if($_POST[oculto]==2) { ?> onClick="pdf()" <?php } ?>> <img src="imagenes/print.png"  alt="Buscar" /></a>
		</td>
	</tr>		  
</table>
<tr>
<td colspan="3" class="tablaprin" align="center"> 
<?php
$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
$vigencia=$vigusu;
 ?>	
<?php 
/*if(0>diferenciamesesfechas_f2($_POST[fecha],$_POST[fechaav]))
{
 ?>
 <script>alert("LA FECHA DE PROYECCION DE LIQUIDACION NO PUEDE SER MENOR A LA FECHA ACTUAL")</script>
 <?php
 $_POST[fechaav]=$_POST[fecha];
}*/
	  //*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
if(!$_POST[oculto])
{
	$linkbd=conectar_bd();
	 		 $fec=date("d/m/Y");
		 $_POST[fecha]=$fec; 		
		 $_POST[fechaav]=$_POST[fecha]; 		  			 
 		$_POST[vigencia]=$vigusu; 		
			$check1="checked";
			$sqlr="select *from tesotasainteres where vigencia='$vigusu'";
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
			$sqlr="select *from tesodescuentoincentivo where vigencia='$vigusu' and ingreso='01' and estado='S'";
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
	 $sqlr="SELECT * FROM tesopredios T1 WHERE T1.cedulacatastral='$_POST[codcat]' AND T1.ord='$_POST[ord]' AND T1.tot='$_POST[tot]'";
	 
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
	  <tr><td class="saludo1">Proy Liquidacion:</td><td><input name="fechaav" type="text" value="<?php echo $_POST[fechaav]?>" maxlength="10" size="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" >   <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>  </td> <td width="128" class="saludo1">Codigo Catastral:</td>
          <td colspan="3"><input id="codcat" type="text" name="codcat" size="20" onKeyUp="return tabular(event,this)" onBlur="buscar(event)" value="<?php echo $_POST[codcat]?>" ><input id="ord" type="text" name="ord" size="3"  value="<?php echo $_POST[ord]?>" readonly><input id="tot" type="text" name="tot" size="3" value="<?php echo $_POST[tot]?>" readonly><input type="hidden" value="0" name="bt">  <a href="#" onClick="mypop=window.open('catastral-ventana.php','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=900,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a><input type="hidden" name="chacuerdo" value="1"><input type="hidden" value="1" name="oculto"></td><td> <input type="hidden" value="<?php echo $_POST[buscav]?>" name="buscav"><input type="button" name="buscarb" id="buscarb" value="   Buscar   " onClick="buscar()" ></td>
        </tr>
        <tr><td class="saludo1">Avaluo Vigente:</td><td><input name="avaluo2" value="<?php echo $_POST[avaluo2]?>" type="text" size="20" readonly><input type="hidden" name="vavaluo"  value="<?php echo $_POST[vavaluo]?>" > </td><td class="saludo1">Tasa Predial	:</td><td><input name="tasa" value="<?php echo $_POST[tasa]?>" type="text" size="4" readonly>xmil</td><td ></td><td><input name="predial" value="<?php echo $_POST[predial]?>" type="hidden"  readonly></td><td class="saludo1">Deduccion Ajuste:</td><td><input name="deduccion" value="<?php echo $_POST[deduccion]?>" type="text" size="10" onBlur="document.form2.submit()"></td></tr>
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
	   	     <td colspan="12" class="titulos">Periodos a Liquidar  </td>
	   	   </tr>                  
		<tr>
		  <td  class="titulos2">Vigencia</td>
		  <td  class="titulos2">Codigo Catastral</td>
   		  <td class="titulos2">Predial</td>
   		  <td  class="titulos2">Intereses</td>          
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
			  $co="zebra1";
			  $co2="zebra2";
				$sqlr="SELECT * FROM tesoprediosavaluos T1,tesopredios T2  WHERE T1.codigocatastral='$_POST[catastral]' AND T1.estado='S' AND T1.pago='N' AND T1.codigocatastral=T2.cedulacatastral AND T2.ord='$_POST[ord]' AND T2.tot='$_POST[tot]' ORDER BY T1.vigencia ASC";		
			$res=mysql_query($sqlr,$linkbd);
			echo $sqlr;
			$cuentavigencias = mysql_num_rows($res);
			$cv=0;
			$cont=0;
			while($r=mysql_fetch_row($res))
			{		 
			$totalpagar=0;
			$base=0;
			$tasav=0;
			//$sqlr2="select *from tesotarifaspredial where vigencia='".$vigusu."' and tipo='$r[19]' and estratos=$r[20]";
			//*************	
			 echo "<tr class='$co'><td ><input name='dvigencias[]' value='".$r[0]."' type='text' size='4' readonly></td><td><input name='dcodcatas[]' value='".$r[1]."' type='text' size='16' readonly><input name='dvaloravaluo[]' value='".$base."' type='hidden' ><input name='dtasavig[]' value='".$tasav."' type='hidden' ></td><td ><input name='dpredial[]' value='".$_POST[dpredial][$cont]."' type='text' size='12' onBlur='totalesvig()' ></td><td ><input name='dipredial[]' value='".$_POST[dipredial][$cont]."' type='text' size='7'  onBlur='totalesvig()'  ></td><td ><input name='dimpuesto1[]' value='".$_POST[dimpuesto1][$cont]."' type='text'  size='12'  onBlur='totalesvig()' ></td><td ><input name='dinteres1[]' value='".$_POST[dinteres1][$cont]."' type='text' size='7'  onBlur='totalesvig()' ></td><td ><input name='dimpuesto2[]' value='".$_POST[dimpuesto2][$cont]."' type='text'  size='12' onBlur='totalesvig()'  ></td><td ><input name='dinteres2[]' value='".$_POST[dinteres2][$cont]."' type='text' size='7'  onBlur='totalesvig()' ></td><td><input type='text' name='ddescuentos[]' value='".$_POST[ddescuentos][$cont]."' size='6'  onBlur='totalesvig()' ></td><td ><input name='davaluos[]' value='".$_POST[davaluos][$cont]."' type='text' size='10' ><input name='dhavaluos[]' value='".$_POST[davaluos][$cont]."' type='hidden' ></td><td ><input type='text' name='dias[]' value='$diasd' size='4' ></td><td><input type='checkbox' name='dselvigencias[]' value='$r[0]' onClick='buscavigencias(this)' $chk></td></tr>";
		 $_POST[totalc]=$_POST[totalc]+$_POST[davaluos][$x];
		 $_POST[totalcf]=number_format($_POST[totalc],2,".",",");
		 $aux=$co;
		 $co=$co2;
		 $co2=$aux;
		 $cont+=1;
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
	  $sqlr="insert into tesoliquidapredial ( `codigocatastral`, `fecha`, `vigencia`, tercero,`tasamora`, `descuento`, `tasapredial`, `totaliquida`, `totalpredial`, `totalbomb`, `totalmedio`, `totalinteres`, `intpredial`, `intbomb`, `intmedio`, `totaldescuentos`, concepto,`estado`,ord,tot) values ('$_POST[catastral]','$fechaf','".$vigusu."','$_POST[tercero]',$_POST[tasamora],$_POST[descuento],$_POST[tasa],$_POST[totliquida],$_POST[totpredial], $_POST[totbomb],$_POST[totamb] ,$_POST[totint],$_POST[intpredial],$_POST[intbomb],$_POST[intamb],$_POST[totdesc],'".utf8_decode("A�os Liquidados:".$ageliqui)."','S','$_POST[ord]','$_POST[tot]')";

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
		 $sqlr="insert into tesoliquidapredial_det (`idpredial`, `vigliquidada`, avaluo,tasav,`predial`, `intpredial`, `bomberil`, `intbomb`, `medioambiente`, `intmedioambiente`, `descuentos`, `totaliquidavig`, `estado`) values ($idp,'".$_POST[dvigencias][$x]."',".$_POST[dvaloravaluo][$x].",".$_POST[dtasavig][$x].",".$_POST[dpredial][$x].",".$_POST[dipredial][$x].",".$_POST[dimpuesto1][$x].",".$_POST[dinteres1][$x].",".$_POST[dimpuesto2][$x].",".$_POST[dinteres2][$x].",".$_POST[ddescuentos][$x].",".$_POST[dhavaluos][$x].",'S')";
		 	mysql_query($sqlr,$linkbd);
			$ageliqui=$ageliqui." ".$_POST[dselvigencias][$y];
			//echo "<br>".$sqlr;
			  }
		  }		 
		  }
		   echo "<table class='inicio'><tr><td class='saludo1'><center>".utf8_decode("A�os Liquidados:")." $ageliqui <img src='imagenes\confirm.png'> </center></td></tr></table>";  		   
		}  
	 }
    ?>
</form>

 </td></tr>
</table>
</body>
</html>