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
  <td colspan="3" class="cinta"><a href="#" class="mgbt"><img src="imagenes/add2.png" alt="Nuevo"  border="0"  title="Nuevo"/></a><a href="#" class="mgbt"><img src="imagenes/guardad.png"  alt="Guardar" title="Guardar" /></a><a href="#" onClick="buscar()" class="mgbt"><img src="imagenes/busca.png"  alt="Buscar" title="Buscar"/></a><a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana"  title="Nueva ventana"></a><a href="#"  class="mgbt" onClick="pdff();"><img src="imagenes/print.png"  title="Imprimir" /></a><a href="<?php echo "archivos/".$_SESSION[usuario]."reportepredial.csv"; ?>" target="_blank" class="mgbt"><img src="imagenes/csv.png"  alt="csv" title="csv"></a><a href="teso-reportepredial.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a></td></td>
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
?>         
	  <input type="hidden" value="<?php echo $_POST[buscav]?>" name="buscav"></td>
	  <table class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="11">Reporte de Estado Predial</td><td width="72" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
      </tr>
        <tr>
		  <td width="128" class="saludo1">C&oacute;digo Catastral:</td>
          <td >
			<input id="codcat" type="text" name="codcat"  onKeyUp="return tabular(event,this)" onBlur="buscar(event)" value="<?php echo $_POST[codcat]?>" style="width:80%;"> <a href="#" onClick="mypop=window.open('catastral-ventana4.php','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=900,height=500px');mypop.focus();" ><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>
			<input type="hidden" name="chacuerdo" value="1"><input type="hidden" value="1" name="oculto"></td>
		
			<td width="128" class="saludo1">Anio:</td>
          <td ><input type="text" name="anio" id='anio' value=""></td>

			<td ><input type="button" name="buscarb" id="buscarb" value="   Buscar   " onClick="buscar()" ><input name="predial" value="<?php echo $_POST[predial]?>" type="hidden"  readonly></td>
			</tr>
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
	  <div class="subpantallac" style='height: 75%;'>
      <table class="inicio">
	   	   <tr>
	   	     <td colspan="15" class="titulos">Periodos a Liquidar  </td>
	   	   </tr>                  
		<tr>
		  <td  class="titulos2">Vigencia</td>
		  <td  class="titulos2">Tercero</td>
		  <td  class="titulos2">C&oacute;digo Catastral</td>
		  <td  class="titulos2">Avaluo</td>          
   		  <td class="titulos2">Predial</td>
   		  <td  class="titulos2">Intereses</td>          
		  <td  class="titulos2">Sobretasa Bombe</td>
          <td  class="titulos2">Intereses</td>
		  <td class="titulos2">Sobretasa Amb</td>
          <td  class="titulos2">Intereses</td>
          <td  class="titulos2">Descuentos</td>
          <td  class="titulos2">Valor Total</td>
          		  <td  class="titulos2">D&iacute;as Mora</td>
           		  <td  class="titulos2">PAGO</td>
           		  <input type='hidden' name='buscarvig' id='buscarvig'></td>
		  <td width="3%" type='hidden' class="titulos2">Sel
		    </tr>
            <?php								
			$contador=0;
			ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
			$fechaactual=$fecha[3]."-".$fecha[2]."-".$fecha[1];		
			
			$sq="select interespredial from tesoparametros ";
			$result=mysql_query($sq,$linkbd);
			$rw=mysql_fetch_row($result);
			$interespredial=$rw[0];
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
					$criterio3=" and tesoprediosavaluos.pago='$_POST[tipov]'" ;
				  }
			 $_POST[dcuentas]=array();
			 $_POST[dncuentas]=array();
			 $_POST[dtcuentas]=array();		 
	 		 $_POST[dvalores]=array();
			 $linkbd=conectar_bd();
			  $sqlr="SELECT * FROM `tesoparametros` ";
			// echo "s:$sqlr";
			 $res=mysql_query($sqlr,$linkbd);
			 $row=mysql_fetch_row($res);
			 $presc=$row[2];
			$namearch="archivos/".$_SESSION[usuario]."reportepredial.csv";
			$Descriptor1 = fopen($namearch,"w+"); 
			
			fputs($Descriptor1,"VIGENCIA;TERCERO;NOMBRE TERCERO;COD CATASTRAL;DIRECCION;AVALUO;PREDIAL;INTERESES;SOBRETASA BOMBERIL;INTERESES;SOBRETASA AMBIENTAL;INTERESES;VALOR TOTAL;PAGO\r\n");

			 $sqlr="select *from tesopredios where estado<>'' ".$criterio2." ".$criterio."  order by cedulacatastral";
			 //echo "$sqlr";

					$iter='saludo1a';
            		$iter2='saludo2';
			 $resto=mysql_query($sqlr,$linkbd);
			 while($rowto=mysql_fetch_row($resto))
			  {
				  $diasd=0;
			 $_POST[codcat]=$rowto[0];
			 $sqlr="select *from tesopredios where cedulacatastral=".$_POST[codcat]." order by cedulacatastral";
			 //echo "s2:$sqlr";
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
		  
			//$tasaintdiaria=(pow((1+$_POST[tasamora]/100),(1/365))-1); Compuesta
			$tasaintdiaria=($_POST[tasamora]/100);
			$cuentavigencias=0;
			$tdescuentos=0;
			$sqlr="Select *from tesoprediosavaluos,tesopredios where tesoprediosavaluos.codigocatastral=$_POST[catastral] and   tesoprediosavaluos.estado='S'  and tesoprediosavaluos.codigocatastral=tesopredios.cedulacatastral and tesoprediosavaluos.vigencia>='".($vigusu-$presc)."' ".$criterio3." order by tesoprediosavaluos.vigencia ASC";		
			
			//-----echo $sqlr;
			$res=mysql_query($sqlr,$linkbd);
			$cuentavigencias = mysql_num_rows($res);
			$cv=0;
			
			
			while($r=mysql_fetch_row($res))
			{		 
			$pagosnp=$r[3];
			$sqlr2="select *from tesotarifaspredial where vigencia='".$vigusu."' and tipo='$r[21]' and estratos=$r[22]";
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
				  elseif ($interespredial=='inicioanio')//Si se cuentan los dias desde el principio del año 
				   				{
									//$fechaini=mktime(0,0,0,$ulfedes[1],$ulfedes[2],$r[0]);
									//echo "aqui";
									$fechaini=mktime(0,0,0,1,1,$r[0]);
									$fechafin=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
									$difecha=$fechafin-$fechaini;
									$diasd=$difecha/(24*60*60);
									$diasd=floor($diasd);
									$totalintereses=0; 
				   				}
								else //Si se cuentan los dias desde el principio del año 
								{
									//echo "hola";
									$fechaini=mktime(0,0,0,$ulfedes[1],$ulfedes[2],$r[0]);
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
				elseif ($interespredial=='inicioanio')//Si se cuentan los dias desde el principio del año 
				   				{
									//$fechaini=mktime(0,0,0,$ulfedes[1],$ulfedes[2],$r[0]);
									//echo "aqui";
									$fechaini=mktime(0,0,0,1,1,$r[0]);
									$fechafin=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
									$difecha=$fechafin-$fechaini;
									$diasd=$difecha/(24*60*60);
									$diasd=floor($diasd);
									$totalintereses=0; 
				   				}
								else //Si se cuentan los dias desde el principio del año 
								{
									//echo "hola";
									$fechaini=mktime(0,0,0,$ulfedes[1],$ulfedes[2],$r[0]);
									$fechafin=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
									$difecha=$fechafin-$fechaini;
									$diasd=$difecha/(24*60*60);
									$diasd=floor($diasd);
									$totalintereses=0; 
								}
			 }
			
					$sqlr2="select *from tesoingresos_det where codigo='01' and modulo='4' and  estado='S' and vigencia=$vigusu order by concepto";
					//echo $sqlr2;
					$res3=mysql_query($sqlr2,$linkbd);
					while($r3=mysql_fetch_row($res3))
					{
						if($r3[5]>0 && $r3[5]<100){
					
						  	if($r3[2]=='03'){
	//								 echo $tasaintdiaria."-";
							  $valoringreso[0]=ceil($valorperiodo*($r3[5]/100));
							  $valoringresos+=ceil($valorperiodo*($r3[5]/100));
							  //$intereses[0]=ceil($valoringreso[0]*(pow(1+$tasaintdiaria,$diasd)-1));  Compuesta
							  $intereses[0]=round(($valoringreso[0]*$diasd*$tasaintdiaria)/365,0);
							  $totalintereses+=$intereses[0];						
					    	}
						    if($r3[2]=='02'){
								$valoringreso[1]=ceil($valorperiodo*($r3[5]/100));
								$valoringresos+=ceil($valorperiodo*($r3[5]/100));
								//$intereses[1]=ceil($valoringreso[1]*(pow(1+$tasaintdiaria,$diasd)-1)); Compuesta
								$intereses[1]=round(($valoringreso[1]*$diasd*$tasaintdiaria)/365,0);
							  	$totalintereses+=$intereses[1];						 
							}
							if($sidescuentos==1 && '03'==$r3[2]){
								$tdescuentos+=ceil($valoringreso[0]*$pdescuento);
							}
							 //echo $totalintereses."-";				
						}
					}
						$valorperiodo+=$valoringresos;		
						//$ipredial=ceil($predial*(pow(1+$tasaintdiaria,$diasd)-1));
						$ipredial=round(($predial*$tasaintdiaria*$diasd)/365,0);
						$totalpredial=ceil($valorperiodo+$totalintereses+$ipredial);
						$totalpagar=ceil($totalpredial- ceil($tdescuentos));
						$ch=esta_en_array($_POST[dselvigencias], $r[0]);
						$chk="checked";
						if($ch==1)
						 {
						 $chk="checked";
						 }
			//*************	
			
			
			
			if($_POST[dsuperior]!=''){
				$deudasuperior=$_POST[dsuperior];
			}else{
				$deudasuperior=0;
			}
			
			if(intval($totalpagar)>$deudasuperior){
				

                if($r[0]==$_POST[anio] || $_POST[anio]==''){
				echo "<tr class='$iter'>
						<td class=''>
							$r[0]
							<input name='dvigencias[]' value='".$r[0]."' type='hidden' size='4' readonly>
						</td>
						<td class=''>$_POST[tercero] <br> $_POST[ntercero]
							<input name='dterceros[]' value='".$_POST[tercero]."' type='hidden' size='10' readonly>
							<input name='dnterceros[]' value='".$_POST[ntercero]."' type='hidden' size='10' readonly>
						</td>
						<td class=''>$r[1]
							<input name='dcodcatas[]' value='".$r[1]."' type='hidden' size='16' readonly>
							
							<input name='dtasavig[]' value='".$tasav."' type='hidden' >
						</td>
						<td class=''>$base
							<input name='dvaloravaluo[]' value='".$base."' type='hidden' size='8' readonly >
						</td>
						<td class=''>$predial
							<input name='dpredial[]' value='".$predial."' type='hidden' size='12' readonly>
						</td>
						<td class=''>$ipredial
							<input name='dipredial[]' value='".$ipredial."' type='hidden' size='7' readonly>
						</td>
						<td class=''>$valoringreso[0]
							<input name='dimpuesto1[]' value='".$valoringreso[0]."' type='hidden'  size='12' readonly>
						</td>
						<td class=''>$intereses[0]
							<input name='dinteres1[]' value='".$intereses[0]."' type='hidden' size='7' readonly>
						</td>
						<td class=''>$valoringreso[1]
							<input name='dimpuesto2[]' value='".$valoringreso[1]."' type='hidden'  size='12' readonly>
						</td>
						<td class=''>$intereses[1]
							<input name='dinteres2[]' value='".$intereses[1]."' type='hidden' size='7' readonly>
						</td>
						<td class=''>$tdescuentos
							<input type='hidden' name='ddescuentos[]' value='$tdescuentos' size='6' readonly>
						</td>
						<td class=''>$totalpagar
							<input name='davaluos[]' value='".number_format($totalpagar,2)."' type='hidden' size='10' readonly>
							<input name='dhavaluos[]' value='".$totalpagar."' type='hidden' >
						</td>
						<td class=''>$diasd
							<input type='hidden' name='dias[]' value='$diasd' size='4' readonly>
						</td>
						<td class=''>$pagosnp
							<input type='hidden' name='pagos[]' value='$pagosnp' size='4' readonly> 
						</td>
						<td class='' type='hidden'>
							$contador
						</td>
					</tr>";

				$contador++;
                $aux=$iter;
                $iter=$iter2;
                $iter2=$aux;}
		 $_POST[totalc]=$_POST[totalc]+$_POST[davaluos][$x];
		 $_POST[totliquida2]=$_POST[totliquida2]+$totalpagar;
		 $_POST[totalcf]=number_format($_POST[totalc],2,".",",");
		 fputs($Descriptor1,$r[0].";".$_POST[tercero].";".$_POST[ntercero].";Cod: ".$r[1].";".$_POST[direccion].";".$base.";".$predial.";".$ipredial.";".$valoringreso[0].";".$intereses[0].";".$valoringreso[1].";".$intereses[1].";".$totalpagar.";".$pagosnp."\r\n");
		 //$ageliqui=$ageliqui." ".$_POST[dselvigencias][$x];
			}
		 }
		 
	 }
			$resultado = convertir($_POST[totliquida]);
//			$_POST[totliquida2]=array_sum($_POST[dhavaluos]);
			$_POST[letras]=$resultado." PESOS M/CTE";	
			fclose($Descriptor1);
			$_POST[buscav]=''; 
			 }
 	
		?> 
     <script>
  //   buscavigencias(0);
     </script>        
      </table>
      </div>
      
</form>
 </td></tr>
</table>
</body>
</html>