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
vvigencias=document.getElementsByName('dselvigencias[]');
if ( !isNaN(document.form2.recibo.value) && parseFloat(vvigencias.length)==0)
  {
	if (confirm("Esta Seguro de Guardar"))
  	{
  	document.form2.oculto.value=2;
  	document.form2.submit();
  	}
  }
  else{
	  if (vvigencias.length>0)
	   {
	   alert('El Predio tiene Pagos Pendientes');
  	document.form2.recibo.focus();
  	document.form2.recibo.select();
		 }
		else
		{
		  alert('Faltan datos para completar el registro'+document.form2.recibo.value);
  	document.form2.recibo.focus();
  	document.form2.recibo.select();
		}
  }
}
</script>
<script>
function pdf()
{
document.form2.action="pdfpazysalvo.php";
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
function buscarc()
 {
// alert("dsdd");
 document.form2.brc.value='1';
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
			<a href="teso-pazysalvo.php" class="mgbt"><img src="imagenes/add.png" alt="Nuevo" title="Nuevo" border="0" /></a> 
			<a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png"  alt="Guardar" title="Guardar" /></a>
			<a href="teso-buscapazysalvo.php" class="mgbt"> <img src="imagenes/busca.png"  alt="Buscar" title="Buscar"/></a> 
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana" title="Nueva ventana"></a> 
			
		</td>
	</tr>		  
</table>
<tr>
<td colspan="3" class="tablaprin" align="center"> 
<?php
$vigencia=date(Y);
 ?>	
<?php
$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
$_POST[vigencia]=$vigusu;
	  //*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
if(!$_POST[oculto])
{
	$linkbd=conectar_bd();
	 		 $fec=date("d/m/Y");
		 $_POST[fecha]=$fec; 		 		  			 
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
					  if($fecha[2]<=6)
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
			  if($fechaactual>$r[9] && $fechaactual <= $r[10])
			   {
				 $fdescuento=$r[2];	 
				 $_POST[descuento]=$r[3];	   
			   }
			  if($fechaactual>$r[11] && $fechaactual <= $r[12])
			   {
				 $fdescuento=$r[2];	 
				 $_POST[descuento]=$r[4];	   
			   }  
			}
//*************cuenta caja
	$sqlr="select *from cuentacaja where estado='S' and vigencia=".$vigusu;
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
	{
	 $_POST[cuentacaja]=$row[1];
	}
	$sqlr="select max(numerotipo) from comprobante_cab where tipo_comp='8' and EXTRACT(YEAR FROM fecha)=".$vigusu;
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
		 $_POST[valor]=0;		 

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
$sqlr="Select max(id) from tesopazysalvo";
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
	 $sqlr="select *from tesopredios where cedulacatastral=".$_POST[codcat]." ";
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
      <?php
	  if($_POST[brc]=='1' and $_POST[recibo]!='')
	   {
        $linkbd=conectar_bd();
		$sqlr="select tesoreciboscaja.id_recibos,tesorecaudos.concepto from tesoreciboscaja,tesorecaudos where tesoreciboscaja.id_recibos='$_POST[recibo]' and tesoreciboscaja.id_recaudo=tesorecaudos.id_recaudo and tesoreciboscaja.tipo='3' and tesoreciboscaja.estado='S'";
		//echo $sqlr;
		$_POST[detallerc]='';
		 $_POST[recibo]='';
		$res=mysql_query($sqlr,$linkbd);
		while ($row =mysql_fetch_row($res)) 
		{
		 $_POST[recibo]=$row[0];
		 $_POST[detallerc]=$row[1];		  
		}	  
		if ($_POST[detallerc]=='')
		 {
		  ?>
          <script>
          alert("Recibo de Caja Incorrecto");
		  document.form2.recibo.focus();
		  document.form2.recibo.select();
          </script>  
          <?php 
		  }
	   }
	  ?>
           <table class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="6">Consultar Predio</td>
		<td  class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
      </tr>
     <tr>
		 <td class="saludo1">No Paz y Salvo:</td>
		 <td >
			<input name="numpredial" id="numpredial" type="text" value="<?php echo $_POST[numpredial]?>"   onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly></td>
		 <td  class="saludo1">Fecha:</td>
		 <td >
			<input name="fecha" id="fecha"type="text" value="<?php echo $_POST[fecha]?>" maxlength="10" style="width:100%;" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly></td>
		 <td class="saludo1" >Vigencia:</td>
		 <td>
			<input name="vigencia" type="text" value="<?php echo $_POST[vigencia]?>" maxlength="2" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly></td>
	 </tr>
	  <tr>
		<td  class="saludo1" >Recibo Caja:</td>
        <td  >
		  <input id="recibo" type="text" name="recibo" onKeyUp="return tabular(event,this)" onBlur="buscarc(event)" value="<?php echo $_POST[recibo]?>" >
		  <input type="hidden" value="0" name="brc"> </td>
		<td colspan="2">
		  <input type="text" name="detallerc"  value='<?php echo $_POST[detallerc] ?>' style="width:100%;"></td> 
		<td  class="saludo1" style="width:8%;">C&oacute;digo Catastral:</td>
        <td>
		  <input id="codcat" type="text" name="codcat" onKeyUp="return tabular(event,this)" onBlur="buscar(event)" style="width:25%;" value="<?php echo $_POST[codcat]?>" >
		  <input type="hidden" value="0" name="bt">  <a href="#" onClick="mypop=window.open('catastral-ventana.php','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=900,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>
		  <input id="ord" type="text" name="ord"  style="width:10%;" value="<?php echo $_POST[ord]?>" readonly>
		  <input id="tot" type="text" name="tot" style="width:10%;" value="<?php echo $_POST[tot]?>" readonly>
		  <input type="hidden" name="chacuerdo" value="1">
		  <input type="hidden" value="1" name="oculto"> 
		  <input type="hidden" value="<?php echo $_POST[buscav]?>" name="buscav">
		  <input type="button" name="buscarb" id="buscarb" value="Buscar" onClick="buscar()" ></td>
        </tr>     
	<tr>
		<td class="saludo1" >Destino:</td>
		<td>
			<input type="text" name="destino" value="<?php echo $_POST[destino] ?>" ></td>
	</tr>	  
	  </table>
  <table class="inicio">
	  <tr>
	    <td class="titulos" colspan="9">Informacion Predio</td></tr>
	  <tr>
	  <td  class="saludo1" style="width:10%;">C&oacute;digo Catastral:</td>
	  <td style="width:10%;" >
	  <input type="hidden" value="<?php echo $_POST[nbanco]?>" name="nbanco">
	  <input name="catastral" type="text" id="catastral" onBlur="buscater(event)" style="width:100%;" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[catastral]?>" readonly></td>
			   
		 <td class="saludo1" style="width:8%;">Avaluo:</td>
	  <td colspan="5">
		<input name="avaluo" type="text" id="avaluo" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[avaluo]?>" style="width:24%;" readonly>
	  </td>
	  <td style="width:20%;"></td>
	  </tr>
      <tr> <td  class="saludo1">Documento:</td>
	  <td ><input name="tercero" type="text" id="tercero" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[tercero]?>" style="width:100%;" readonly>
	  </td>
	  <td class="saludo1">Propietario:</td>
	  <td colspan="5">
		<input type="hidden" value="<?php echo $_POST[nbanco]?>" name="nbanco"> 
		<input name="ntercero" type="text" id="propietario" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[ntercero]?>" style="width:100%;" readonly></td>
			   
		</tr>
      <tr>
	  <td  class="saludo1">Direccion:</td>
	  <td ><input type="hidden" value="<?php echo $_POST[nbanco]?>" name="nbanco"> 
		<input name="direccion" type="text" id="direccion" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[direccion]?>" style="width:100%;" readonly></td>
			   
		 <td  class="saludo1" style="width:8%;">Ha:</td>
	  <td style="width:5%;" >
	  <input name="ha" type="text" id="ha" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[ha]?>" style="width:100%;" readonly>
	  </td>
	  <td  class="saludo1" style="width:8%;">Mt2:</td>
	  <td style="width:8%;">
		<input name="mt2" type="text" id="mt2" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[mt2]?>" style="width:100%;" readonly></td>
	  <td  class="saludo1" style="width:8%;">Area Cons:</td>
	  <td style="width:8%;" >
		<input name="areac" type="text" id="areac" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[areac]?>" style="width:100%;" readonly></td>
      </tr>
	  <tr>
	     <td class="saludo1">Tipo:</td><td ><select name="tipop" onChange="validar();" disabled>
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
            <td >
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
	  <div class="subpantallac">
      <table class="inicio">
	   	   <tr>
	   	     <td colspan="12" class="titulos">Periodos Sin Pagar  </td>
	   	   </tr>                  
		<tr>
		  <td  class="titulos2" style="width:6%;">Vigencia</td>
		  <td  class="titulos2" style="width:15%;">C&oacute;digo Catastral</td>
   		  <td  style="width:10%;" class="titulos2">Predial</td>
   		  <td  style="width:10%;" class="titulos2">Intereses</td>          
		  <td  style="width:10%;" class="titulos2">Sobretasa Bombe</td>
          <td  style="width:10%;" class="titulos2">Intereses</td>
		  <td  style="width:10%;" class="titulos2">Sobretasa Amb</td>
          <td  style="width:10%;" class="titulos2">Intereses</td>
          <td  style="width:10%;" class="titulos2">Descuentos</td>
          <td  style="width:10%;" class="titulos2">Valor Total</td>
          <td  style="width:8%;"  class="titulos2">Dias Mora</td>
		  <td  style="width:4%;" class="titulos2">Sel
		    <input type='hidden' name='buscarvig' id='buscarvig'> </td></tr>
            <?php			
			ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
			$fechaactual=$fecha[3]."-".$fecha[2]."-".$fecha[1];					
			  $tasaintdiaria=(pow((1+$_POST[tasamora]/100),(1/365))-1);
			  $cuentavigencias=0;
			  $tdescuentos=0;
			$sqlr="Select *from tesoprediosavaluos,tesopredios where tesoprediosavaluos.codigocatastral=$_POST[catastral] and   tesoprediosavaluos.estado='S' and tesoprediosavaluos.pago='N' and tesoprediosavaluos.codigocatastral=tesopredios.cedulacatastral order by tesoprediosavaluos.vigencia ASC";		
			$res=mysql_query($sqlr,$linkbd);
			$cuentavigencias = mysql_num_rows($res);
			while($r=mysql_fetch_row($res))
			{		 
			$sqlr2="select *from tesotarifaspredial where vigencia='".$vigusu."' and tipo='$r[19]' and estratos=$r[20]";
			//echo $sqlr2;
			 $res2=mysql_query($sqlr2,$linkbd);
	 		$row2=mysql_fetch_row($res2);
			$base=$r[2];
			$valorperiodo=$base*($row2[5]/1000);
			$tasav=$row2[5];
			$predial=$base*($row2[5]/1000);
			$valoringresos=0;
			$sidescuentos=0;
			//****buscar en el concepto del ingreso *******
			$intereses=array();
			$valoringreso=array();
			$in=0;
			if($cuentavigencias>1)
			 {
				if($vigusu==$r[0] && $_POST[descuento]>0)
				 {
				 $diasd=0;
				 $totalintereses=0; 
			  	 $sidescuentos=0;
				  }
				  else
				   {
				$fechaini=mktime(0,0,0,1,1,$r[0]);
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
			   if($vigusu==$r[0] && $_POST[descuento]>0)
				 {
					$pdescuento=$_POST[descuento]/100; 					
					$tdescuentos+=ceil(($valorperiodo)*$pdescuento);
				 }
			 }
			
					$sqlr2="select *from tesoingresos_det where codigo='01' and modulo='4' and  estado='S' order by concepto";
					//echo $sqlr2;
					$res3=mysql_query($sqlr2,$linkbd);
				while($r3=mysql_fetch_row($res3))
					{
					if($r3[5]>0 && $r3[5]<100)
					 {
					//	 echo $valoringresos."-";
					  if($r3[2]=='03')
					    {
					  $valoringreso[0]=ceil($valorperiodo*($r3[5]/100));
					  $valoringresos+=ceil($valorperiodo*($r3[5]/100));
					  $intereses[0]=ceil($valoringreso[0]*(pow(1+$tasaintdiaria,$diasd)-1));
					  $totalintereses+=$intereses[0];						
					    }
					    if($r3[2]=='02')
					    {
					  $valoringreso[1]=ceil($valorperiodo*($r3[5]/100));
					  $valoringresos+=ceil($valorperiodo*($r3[5]/100));
					  $intereses[1]=ceil($valoringreso[1]*(pow(1+$tasaintdiaria,$diasd)-1));
					  $totalintereses+=$intereses[1];						 
					    }	
					  if($sidescuentos==1 && '03'==$r3[2])
					   {
						 $tdescuentos+=ceil($valoringreso[0]*$pdescuento);
						}			
					 }
					}
				$valorperiodo+=$valoringresos;		
				$ipredial=ceil($predial*(pow(1+$tasaintdiaria,$diasd)-1));
				$totalpredial=ceil($valorperiodo+$totalintereses+$ipredial);
				$totalpagar=ceil($totalpredial- ceil($tdescuentos));
				$ch=esta_en_array($_POST[dselvigencias], $r[0]);
				if($ch==1)
			 {
			 $chk="checked";
			 }
			//*************	
			 echo "<tr>
			 <td class='saludo1' style='width:6%;'>
					<input name='dvigencias[]' value='".$r[0]."' type='text' style='width:100%;' readonly></td>
			 <td class='saludo1' style='width:12%;'>
					<input name='dcodcatas[]' value='".$r[1]."' type='text' style='width:100%;' readonly>
					<input name='dvaloravaluo[]' value='".$base."' type='hidden' >
					<input name='dtasavig[]' value='".$tasav."' type='hidden' ></td>
			 <td class='saludo1'  style='width:12%;'>
					<input name='dpredial[]' value='".$predial."' type='text'  style='width:100%;' readonly></td>
			 <td class='saludo1'  style='width:12%;'>
					<input name='dipredial[]' value='".$ipredial."' type='text'  style='width:100%;' readonly></td>
			 <td class='saludo1' style='width:12%;'>
					<input name='dimpuesto1[]' value='".$valoringreso[0]."' type='text'   style='width:100%;' readonly></td>
			 <td class='saludo1'  style='width:12%;'>
					<input name='dinteres1[]' value='".$intereses[0]."' type='text'  style='width:100%;' readonly></td>
			 <td class='saludo1'  style='width:12%;'>
					<input name='dimpuesto2[]' value='".$valoringreso[1]."' type='text'  style='width:100%;'  readonly></td>
			 <td class='saludo1'  style='width:12%;'>
					<input name='dinteres2[]' value='".$intereses[1]."' type='text'  style='width:100%;' readonly></td>
			 <td class='saludo1'  style='width:12%;'>
					<input type='text' name='ddescuentos[]' value='$tdescuentos'  style='width:100%;' readonly></td>
			 <td class='saludo1'  style='width:12%;'>
					<input name='davaluos[]' value='".number_format($totalpagar,2)."' type='text'  readonly>
					<input name='dhavaluos[]' value='".$totalpagar."' type='hidden' ></td>
			<td class='saludo1'  style='width:15%;'>
					<input type='text' name='dias[]' value='$diasd' readonly></td>
			<td class='saludo1'>
					<input type='checkbox' name='dselvigencias[]' value='$r[0]' onClick='buscavigencias(this)' $chk></td></tr>";
		 $_POST[totalc]=$_POST[totalc]+$_POST[davaluos][$x];
		 $_POST[totalcf]=number_format($_POST[totalc],2,".",",");
		 //$ageliqui=$ageliqui." ".$_POST[dselvigencias][$x];
		 }
 			$resultado = convertir($_POST[totliquida]);
			$_POST[letras]=$resultado." PESOS M/CTE";	
		?> 
      </table>
      </div>
     
	<?php
	if ($_POST[oculto]=='2')
	 {
		ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
		$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
		$linkbd=conectar_bd();
		$sqlr="insert into tesopazysalvo (codigocatastral,idrecibo,fecha,estado,destino) values ('$_POST[codcat]',$_POST[recibo],'$fechaf','S','$_POST[destino]')";
		if(!mysql_query($sqlr,$linkbd))
		 {
		 echo "<table class='inicio'><tr><td class='saludo1'>No Se ha podido Generar el Paz y Salvo <img src='imagenes\alert.png'>".mysql_error($linkbd)."</td></tr></table>";  	
		 
		 	 }
		  else
	   		{
				$npaz=mysql_insert_id();
		 echo "<table class='inicio'><tr><td class='saludo1'>Se ha  Generado el Paz y Salvo N° $npaz <img src='imagenes\confirm.png'></td></tr></table>";			
		 $idps=mysql_insert_id();
		 $_POST[numpredial]=$idps;
			}
	 }
    ?>
</form>
 </td></tr>
</table>
</body>
</html>