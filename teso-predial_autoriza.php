<?php //V 1000 12/12/16 ?> 
<?php
	require "comun.inc";
	require "funciones.inc";
	require "conversor.php";
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
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
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
			function validar() {document.form2.submit();}
			function buscater(e)
			{
				if (document.form2.tercero.value!="")
				{
			 		document.form2.bt.value='1';
			 		document.form2.submit();
			 	}
			 }
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
if (document.form2.fecha.value!='' && document.form2.autorizacion.value!='' )
  {
	despliegamodalm('visible','4','Esta Seguro de Guardar','1');
  }
  else{
	despliegamodalm('visible','2','Faltan datos para completar el registro');
  	document.form2.fecha.focus();
  	document.form2.fecha.select();
  }
}
function despliegamodalm(_valor,_tip,mensa,pregunta,variable)
		{
			document.getElementById("bgventanamodalm").style.visibility=_valor;
			if(_valor=="hidden"){document.getElementById('ventanam').src="";}
			else
			{
				switch(_tip)
				{
					case "1":	document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
					case "2":	document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
					case "3":	document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
					case "4":	document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;	
					case "5":
					document.getElementById('ventanam').src="ventana-elimina1.php?titulos="+mensa+"&idresp="+pregunta+"&variable="+variable;break;	
				}
			}
		}
		function respuestaconsulta(pregunta, variable)
		{
			switch(pregunta)
			{
				case "1":	document.getElementById('oculto').value="2";
							document.form2.submit();break;
				case "2":
					document.form2.elimina.value=variable;
					//eli=document.getElementById(elimina);
					vvend=document.getElementById('elimina');
					//eli.value=elimina;
					vvend.value=variable;
					document.form2.submit();
					break;
			}
		}
		function funcionmensaje(){document.location.href = "teso-predial_autoriza.php";}
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
			<a href="teso-predial_autoriza.php" class="mgbt"><img src="imagenes/add.png" alt="Nuevo"  border="0" title="Nuevo"/></a> 
			<a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png"  alt="Guardar" title="Guardar"/></a>
			<a href="teso-buscapredial.php" class="mgbt"> <img src="imagenes/busca.png"  alt="Buscar" title="Buscar"/></a> 
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana" title="Nueva Ventana"></a> 
			<a href="#" <?php if($_POST[oculto]==2) { ?> onClick="pdf()" <?php } ?> class="mgbt"> <img src="imagenes/print.png"  alt="Buscar" title="Imprimir" /></a>
		</td>
	</tr>		  
</table>
<tr>
<td colspan="3" class="tablaprin" align="center"> 
<?php
	$linkbd=conectar_bd();
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
if($_POST[autorizacion]!="")
{	  
 	$sqlr="select *from tesoautorizapredial where estado='S' and id_auto='".$_POST[autorizacion]."'";
	$res=mysql_query($sqlr,$linkbd);
	while($r=mysql_fetch_row($res))
			{
			 $_POST[fechaav]=$r[3];
			 $_POST[codcat]=$r[1];
			 $_POST[ord]=$r[11];
			 $_POST[tot]=$r[12];			 
			}
ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fechaav],$fechaf);
$_POST[fechaav]=$fechaf[3]."/".$fechaf[2]."/".$fechaf[1];
}	  
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
		 	//$_POST[fechaav]=$_POST[fecha]; 		  			 
 			ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechaav],$fecha);
			$vigproy=$fecha[3];	
			$vigusu=$vigproy;	
			$_POST[vigencia]=$vigproy; 		
			$check1="checked";
			$sqlr="select *from tesotasainteres where vigencia=".$vigusu;
			//echo $sqlr;
			$res=mysql_query($sqlr,$linkbd);
			$r=mysql_fetch_row($res);
			$tasam=array();
			$tasam[0]=$r[14];									
			$tasam[1]=$r[15];
			$tasam[2]=$r[16];
			$tasam[3]=$r[17];
			$tasamoratoria[0]=0;
			ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechaav],$fecha);
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
			ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechaav],$fecha);
			$fechaactual=$fecha[3]."-".$fecha[2]."-".$fecha[1];	
			$sqlr="select *from tesodescuentoincentivo where vigencia=".$vigusu." and ingreso='01' and estado='S'";
			$res=mysql_query($sqlr,$linkbd);
			//echo $sqlr;
			$condes=0;
			while($r=mysql_fetch_row($res))
			{	  
				if($r[7]<=$fechaactual && $fechaactual <= $r[8] )
			   			{
							$_POST[descuento]=$r[2];	   
				 			$condes=1;
			   			}
			  			elseif($fechaactual>$r[9] && $fechaactual <= $r[10] )
			   			{
							$_POST[descuento]=$r[3];	   
							$condes=1;				 
			  			}
			  			elseif($fechaactual>$r[11] && $fechaactual <= $r[12] )
			   			{
				 			$_POST[descuento]=$r[4];	 
				 			$condes=1;				 
			   			} 
						elseif($fechaactual>$r[19] && $fechaactual <= $r[20]  )
			   			{
				 			$_POST[descuento]=$r[16];	  
				 			$condes=1;				 
			   			} 
						elseif($fechaactual>$r[21] && $fechaactual <= $r[22] )
			   			{
				 			$_POST[descuento]=$r[17];	   
				 			$condes=1;				 
			   			} 
						elseif($fechaactual>$r[23] && $fechaactual <= $r[24] )
			   			{
				 			$_POST[descuento]=$r[18];	   
				 			$condes=1;				 
			   			} 
						else 
						{	
							if($r[24]!="0000-00-00"){$ulfedes=explode("-",$r[24]);}
							elseif($r[22]!="0000-00-00"){$ulfedes=explode("-",$r[22]);}
							elseif($r[20]!="0000-00-00"){$ulfedes=explode("-",$r[20]);}
							elseif($r[12]!="0000-00-00"){$ulfedes=explode("-",$r[12]);}
							elseif($r[10]!="0000-00-00"){$ulfedes=explode("-",$r[10]);}
							else {$ulfedes=explode("-",$r[8]);}
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
		//$_POST[fechaav]=$fec; 		 		  			 
		 $_POST[valor]=0;
}
else
 {
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechaav],$fecha);
	$vigproy=$fecha[3];	
	$vigusu=$vigproy;	
	$_POST[vigencia]=$vigproy; 	
	 $linkbd=conectar_bd();
$sqlr="select *from tesotasainteres where vigencia=".$vigusu;
	//	echo $sqlr;
			$res=mysql_query($sqlr,$linkbd);
			$r=mysql_fetch_row($res);
			$tasam=array();
			$tasam[0]=$r[14];
			$tasam[1]=$r[15];
			$tasam[2]=$r[16];
			$tasam[3]=$r[17];
			$tasamoratoria[0]=0;
$sqlr="select *from tesotasainteres where vigencia=".$vigusu;
		//echo $sqlr;
			$res=mysql_query($sqlr,$linkbd);
			$r=mysql_fetch_row($res);
			$tasam=array();
			$tasam[0]=$r[14];									
			$tasam[1]=$r[15];
			$tasam[2]=$r[16];
			$tasam[3]=$r[17];
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
			$sqlr="select *from tesodescuentoincentivo where vigencia=".$vigusu." and ingreso='01' and estado='S'";
			$res=mysql_query($sqlr,$linkbd);
			//echo $sqlr;
			 $condes=0;	  
			while($r=mysql_fetch_row($res))
			{	
				if($r[7]<=$fechaactual && $fechaactual <= $r[8] )
			   			{
							$_POST[descuento]=$r[2];	   
				 			$condes=1;
			   			}
			  			elseif($fechaactual>$r[9] && $fechaactual <= $r[10] )
			   			{
							$_POST[descuento]=$r[3];	   
							$condes=1;				 
			  			}
			  			elseif($fechaactual>$r[11] && $fechaactual <= $r[12] )
			   			{
				 			$_POST[descuento]=$r[4];	 
				 			$condes=1;				 
			   			} 
						elseif($fechaactual>$r[19] && $fechaactual <= $r[20]  )
			   			{
				 			$_POST[descuento]=$r[16];	  
				 			$condes=1;				 
			   			} 
						elseif($fechaactual>$r[21] && $fechaactual <= $r[22] )
			   			{
				 			$_POST[descuento]=$r[17];	   
				 			$condes=1;				 
			   			} 
						elseif($fechaactual>$r[23] && $fechaactual <= $r[24] )
			   			{
				 			$_POST[descuento]=$r[18];	   
				 			$condes=1;				 
			   			} 
						else 
						{	
							if($r[24]!="0000-00-00"){$ulfedes=explode("-",$r[24]);}
							elseif($r[22]!="0000-00-00"){$ulfedes=explode("-",$r[22]);}
							elseif($r[20]!="0000-00-00"){$ulfedes=explode("-",$r[20]);}
							elseif($r[12]!="0000-00-00"){$ulfedes=explode("-",$r[12]);}
							elseif($r[10]!="0000-00-00"){$ulfedes=explode("-",$r[10]);}
							else {$ulfedes=explode("-",$r[8]);}
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
		<div id="bgventanamodalm" class="bgventanamodalm">
			<div id="ventanamodalm" class="ventanamodalm">
				<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
				</IFRAME>
			</div>
		</div>
 <form name="form2" method="post" action="">
  <?php
  $linkbd=conectar_bd();
  $_POST[numpredial]=selconsecutivo('tesoliquidapredial','idpredial');
if($_POST[buscav]=='1')
 {
	 $_POST[dcuentas]=array();
	 $_POST[dncuentas]=array();
	 $_POST[dtcuentas]=array();		 
	 $_POST[dvalores]=array();
	 $linkbd=conectar_bd();
	 $sqlr="select *from tesopredios where cedulacatastral=".$_POST[codcat]."  and tesopredios.ord='".$_POST[ord]."'  and tesopredios.tot='".$_POST[tot]."' ";
	 //echo "s:$sqlr";
	 $res=mysql_query($sqlr,$linkbd);
	 while($row=mysql_fetch_row($res))
	  {
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
		$_POST[tipop]=$row[15];
		$_POST[rangos]=$row[16];
		$tipopp=$row[15];	
		$_POST[dtcuentas][]=$row[1];		 
		$_POST[dvalores][]=$row[5];
		$_POST[buscav]="";
		 $sqlr2="select IF(tasa='-1',0,tasa) from tesoprediosavaluos where vigencia='$vigusu' AND codigocatastral='$row[0]' ";
		 $res2=mysql_query($sqlr2,$linkbd);
	 	while($row2=mysql_fetch_row($res2))
			{
				$_POST[tasa]=$row2[0];
				$_POST[predial]=($row2[0]/1000)*$_POST[vavaluo];
				$_POST[predial]=number_format($_POST[predial],2);
			}
	  }
	  	 // echo "dc:".$_POST[dcuentas];
		  $condes=0;
			//***** BUSCAR FECHAS DE INCENTIVOS
			ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechaav],$fecha);
			$fechaactual=$fecha[3]."-".$fecha[2]."-".$fecha[1];	
			$sqlr="select *from tesodescuentoincentivo where vigencia=".$vigusu." and ingreso='01' and estado='S'";
			$res=mysql_query($sqlr,$linkbd);
			//echo $sqlr;
			while($r=mysql_fetch_row($res))
			{	
				if($r[7]<=$fechaactual && $fechaactual <= $r[8] )
			   			{
							$_POST[descuento]=$r[2];	   
				 			$condes=1;
			   			}
			  			elseif($fechaactual>$r[9] && $fechaactual <= $r[10] )
			   			{
							$_POST[descuento]=$r[3];	   
							$condes=1;				 
			  			}
			  			elseif($fechaactual>$r[11] && $fechaactual <= $r[12] )
			   			{
				 			$_POST[descuento]=$r[4];	 
				 			$condes=1;				 
			   			} 
						elseif($fechaactual>$r[19] && $fechaactual <= $r[20]  )
			   			{
				 			$_POST[descuento]=$r[16];	  
				 			$condes=1;				 
			   			} 
						elseif($fechaactual>$r[21] && $fechaactual <= $r[22] )
			   			{
				 			$_POST[descuento]=$r[17];	   
				 			$condes=1;				 
			   			} 
						elseif($fechaactual>$r[23] && $fechaactual <= $r[24] )
			   			{
				 			$_POST[descuento]=$r[18];	   
				 			$condes=1;				 
			   			} 
						else 
						{	
							if($r[24]!="0000-00-00"){$ulfedes=explode("-",$r[24]);}
							elseif($r[22]!="0000-00-00"){$ulfedes=explode("-",$r[22]);}
							elseif($r[20]!="0000-00-00"){$ulfedes=explode("-",$r[20]);}
							elseif($r[12]!="0000-00-00"){$ulfedes=explode("-",$r[12]);}
							elseif($r[10]!="0000-00-00"){$ulfedes=explode("-",$r[10]);}
							else {$ulfedes=explode("-",$r[8]);}
						}
			}
  }
?>
<div class="tabspre">
   	<div class="tab">
       	<input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
	   	<label for="tab-1">Liquidaci&oacute;n Predial</label>
	   	<div class="content">
           	<table class="inicio" align="center" >
		      	<tr >
		        	<td style="width:95%;" class="titulos" colspan="3">Liquidar Predial</td>
		        	<td style="width:5%;" class="cerrar" >
		        		<a href="teso-principal.php">Cerrar</a>
		        	</td>
		     	</tr>
			  	<tr>
			  		<td style="width:80%;">
			  			<table>
			  				<tr>
						  		<td style="width:10%;" class="saludo1">No Autorizaci&oacute;n</td>
							  	<td style="width:18%;">
							  		<select name="autorizacion" onChange="validar();" >
						       			<option value="">Seleccione ...</option>
							            <?php
											$linkbd=conectar_bd();
											$sqlr="select * from tesoautorizapredial where estado='S' and liquidacion=0";
											$res=mysql_query($sqlr,$linkbd);
											while ($row =mysql_fetch_row($res)) 
											    {
												echo "<option value=$row[0] ";
												$i=$row[0];
												 if($i==$_POST[autorizacion])
										 			{
													 echo "SELECTED";
													 //$_POST[nestrato]=$row[1];
													 }
												  echo ">".$row[0]." - Codcat:".$row[1]."</option>";	 	 
												}	 	
										?>            
									</select> 
							  	</td>
							  	<td style="width:10%" class="saludo1">No Liquidaci&oacute;n:</td>
			     				<td style="width:10%;">
			     					<input name="numpredial" type="text" value="<?php echo $_POST[numpredial]?>" style="width:70%;" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly>
			     				</td>
			     				<td class="saludo1">Fecha:</td>
			     				<td style="width:10%;">
			     					<input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10" style="width:80%;" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly>
			     				</td>
			     				<td class="saludo1">Vigencia:</td>
			     				<td >
			     					<input name="vigencia" type="text" value="<?php echo $_POST[vigencia]?>" maxlength="2" style="width:20%;" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly>
			     				</td>
						  	</tr>
			     			<tr>
			     				<td style="width:10%;" class="saludo1">Tasa Interes Mora:</td>
			     				<td style="width:18%;">
			     					<input name="tasamora" type="text" value="<?php echo $_POST[tasamora]?>" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly>%</td>
			    				<td style="width:10%" class="saludo1">Descuento:</td>
			    				<td style="width:10%;">
			    					<input name="descuento" type="text" value="<?php echo $_POST[descuento]?>" style="width:70%;" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly>%</td >
			    				<td class="saludo1">Proy Liquidaci&oacute;n:</td>
				  				<td style="width:10%;">

				  					<input name="fechaav" type="text" style="width:80%;" value="<?php echo $_POST[fechaav]?>" maxlength="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" readonly>    

				  				</td> 

			    			

				  				

				  				<td style="width:10%;" class="saludo1">C&oacute;digo Catastral:</td>

			          			<td style="width:21%;">

			          				<input id="codcat" type="text" name="codcat" onKeyUp="return tabular(event,this)" style="width:65%;" onBlur="buscar(event)" value="<?php echo $_POST[codcat]?>" >

			          				<input id="ord" type="text" name="ord" style="width:15%;" value="<?php echo $_POST[ord]?>" readonly>

			          				<input id="tot" type="text" name="tot" style="width:15%;" value="<?php echo $_POST[tot]?>" readonly>

			          				<input type="hidden" value="0" name="bt">  

			          				<input type="hidden" name="chacuerdo" value="1">

			          				<input type="hidden" value="1" name="oculto" id="oculto">

			          				<input type="hidden" value="<?php echo  $_POST[basepredial] ?>" name="basepredial">

			          				<input type="hidden" value="<?php echo  $_POST[basepredialamb] ?>" name="basepredialamb">

			          				<input type="hidden" value="<?php echo  $_POST[aplicapredial] ?>" name="aplicapredial">

			          				<input type="hidden" value="<?php echo  $_POST[vigmaxdescint] ?>" name="vigmaxdescint">

			          				<input type="hidden" value="<?php echo  $_POST[porcdescint] ?>" name="porcdescint">

			          				<input type="hidden" value="<?php echo  $_POST[aplicadescint] ?>" name="aplicadescint">

			          			</td>

			          			<td > 

			          				<input type="hidden" value="<?php echo $_POST[buscav]?>" name="buscav">

			          				<input type="button" name="buscarb" id="buscarb" value=" Ver " onClick="buscar()" >

			          			</td>

			          			

			        		</tr>

			        		<tr>

			        			<td style="width:10%;" class="saludo1">Avaluo Vigente:</td>

			        			<td style="width:18%;">

			        				<input name="avaluo2" value="<?php echo $_POST[avaluo2]?>" type="text" readonly>

			        				<input type="hidden" name="vavaluo"  value="<?php echo $_POST[vavaluo]?>" > 

			        			</td>

			        			<td style="width:10%" class="saludo1">Tasa Predial	:</td>

			        			<td style="width:10%;">

			        				<input name="tasa" value="<?php echo $_POST[tasa]?>" style="width:70%;" type="text" readonly>

			        					<font size="1">

			        						xmil

			        					</font>

			        				<input name="predial" value="<?php echo $_POST[predial]?>" type="hidden"  readonly>

			        			</td>

			        			<td class="saludo1">Deduccion Ajuste:</td>

			        			<td style="width:10%;">

			        				<input name="deduccion" value="<?php echo $_POST[deduccion]?>" type="text" style="width:80%;" onBlur="document.form2.submit()">

			        			</td>

			        		</tr>

			  			</table>

			  		</td>

			  		<td colspan="3" style="width:20%; background:url(imagenes/siglas.png); background-repeat:no-repeat; background-position:right; background-size: 100% 100%;" ></td>  

			  	</tr>

	  		</table>

		</div> 

	</div>

    <div class="tab">

       	<input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?>>

       	<label for="tab-2">Informaci&oacute;n Predio</label>

       	<div class="content"> 

		  	<table class="inicio">

		  		<tr>

		    		<td class="titulos" colspan="9">Informaci&oacute;n Predio</td>

					<td style="width:7%" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>

		    	</tr>

		  		<tr>

				  	<td style="width:10%;" class="saludo1">C&oacute;digo Catastral:</td>

				  	<td style="width:10%;">

				  		<input type="hidden" value="<?php echo $_POST[nbanco]?>" name="nbanco"> 

				  		<input name="catastral" type="text" id="catastral" onBlur="buscater(event)" style="width:100%;" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[catastral]?>"  readonly>

				  	</td>

				   	<td style="width:8%;" class="saludo1">Avaluo:</td>

		  			<td style="width:5%;">

		  				<input name="avaluo" type="text" id="avaluo" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[avaluo]?>" style="width:100%;" readonly>

		  			</td>

		  			<td style="width:7%;" class="saludo1">Documento:</td>

				  	<td style="width:5%;">

				  		<input name="tercero" type="text" id="tercero" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[tercero]?>" style="width:100%;" readonly>

				  	</td>

				  	<td style="width:7%;" class="saludo1">Propietario:</td>

				  	<td  colspan="3">

				  		<input type="hidden" value="<?php echo $_POST[nbanco]?>" name="nbanco"> 

				  		<input name="ntercero" type="text" id="propietario" style="width:100%;" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[ntercero]?>"  readonly>

				  	</td>

					

					

		  		</tr>

			    

	      		<tr>

		  			<td  class="saludo1">Direccion:</td>

		  			<td colspan="3">

		  				<input type="hidden" value="<?php echo $_POST[nbanco]?>"  name="nbanco"> 

		  				<input name="direccion" type="text" id="direccion" style="width:100%;" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[direccion]?>" readonly>

		  			</td>

				   	<td class="saludo1">Ha:</td>

		  			<td style="width:5%;">

		  				<input name="ha" type="text" id="ha" onKeyUp="return tabular(event,this)" style="width:100%;" value="<?php echo $_POST[ha]?>" readonly>

		  			</td>

					<td  class="saludo1">Mt2:</td>

					<td style="width:5%;">

						<input name="mt2" type="text" id="mt2" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[mt2]?>" style="width:100%;" readonly>

					</td>

					<td  class="saludo1" style="width:6%;">Area Cons:</td>

					<td style="width:5%;">

						<input name="areac" type="text" id="areac" style="width:100%;" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[areac]?>" readonly>

					</td>

					

	      		</tr>

		  		<tr>

		     		<td width="119" class="saludo1">Tipo:</td>

                              <td  ><select name="tipop" onChange="validar();" id="tipop" style="width: 80%">

							   <option value="">Seleccione ...</option>

								<?php

								if(!empty($_POST[tipop])){

									$linkbd=conectar_bd();

										$sql="SELECT codigo,nombre FROM teso_clasificapredios WHERE vigencia='$_POST[vigencia]' GROUP BY codigo,nombre";

										$result=mysql_query($sql,$linkbd);

										while($row = mysql_fetch_array($result)){

						

												if($row[0]==$_POST[tipop]){

													echo "<option value='$row[0]' SELECTED >$row[1]</option>";

												}else{

													echo "<option value='$row[0]'>$row[1]</option>";

												}

											

										}

								}

										

									

									?>

								</select>

								</td>

								<?php 

									if(!empty($_POST[rangos])){

								?>

									<td width="119" class="saludo1">Rango Avaluo:</td>

                                 <td  >

								 <select name="rangos" onChange="validar();" id="rangos" style="width: 80%">

									<option value="">Seleccione ...</option>

									<?php

											$linkbd=conectar_bd();

											if(!empty($_POST[tipop]) && !empty($_POST[rangos])){

													$sql="SELECT id_rango,nom_rango FROM teso_clasificapredios WHERE codigo=$_POST[tipop] AND id_rango=$_POST[rangos] AND vigencia='$_POST[vigencia]'";

											$result=mysql_query($sql,$linkbd);

											while($row = mysql_fetch_array($result)){

							

													if($row[0]==$_POST[rangos]){

														echo "<option value='$row[0]' SELECTED >$row[1]</option>";

													}else{

														echo "<option value='$row[0]'>$row[1]</option>";

													}

												

											}

											}

										

										

										?>

								</select>

								</td>

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

				//echo "hollaaaa";

			ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechaav],$fecha);

			$fechaactual=$fecha[3]."-".$fecha[2]."-".$fecha[1];					

			//$tasaintdiaria=(pow((1+$_POST[tasamora]/100),(1/365))-1); Compuesta

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

			$co="zebra1";

			$co2="zebra2";	

			$vautorizados=array();

			$sqlr="select vigencia from  tesoautorizapredial_det where id_auto='$_POST[autorizacion]'";
			//echo $sqlr;
			$res=mysql_query($sqlr,$linkbd);			  

			  while($rv=mysql_fetch_row($res))

				{

				 $vautorizados[]=$rv[0];

				}

			  //echo $sqlr;

			$sqlrxx="

						SELECT DISTINCT TB1.vigencia,TB1.codigocatastral,TB1.avaluo,TB1.pago,TB1.estado,TB2.tipopredio,TB2.estratos

						FROM tesoprediosavaluos TB1, tesopredios TB2

						WHERE TB1.codigocatastral = '$_POST[codcat]'

						AND TB1.estado = 'S'

						AND TB1.pago = 'N'

						AND TB1.codigocatastral = TB2.cedulacatastral

						ORDER BY TB1.vigencia ASC 

";						//echo $sqlrxx;

						$resxx=mysql_query($sqlrxx,$linkbd);

						$cuentavigencias= mysql_num_rows($resxx);

						$sqlr="
						SELECT DISTINCT TB1.vigencia,TB1.codigocatastral,TB1.avaluo,TB1.pago,TB1.estado,TB1.tipopredio,TB1.estratos,TB1.areacon
						FROM tesoprediosavaluos TB1
						WHERE TB1.codigocatastral = '$_POST[codcat]'
						AND TB1.estado = 'S'
						AND (TB1.pago = 'N' OR TB1.pago = 'P')
						ORDER BY TB1.vigencia ASC ";
						$res=mysql_query($sqlr,$linkbd);

						$cuentavigencias = mysql_num_rows($res);

						$cv=0;

						$xpm=0;

						$sq="select interespredial from tesoparametros ";

						$result=mysql_query($sq,$linkbd);

						$rw=mysql_fetch_row($result);

						$interespredial=$rw[0];
						$sq="SELECT idacuerdo FROM tesoacuerdopredial WHERE codcatastral='$_POST[codcat]'";
						$rs=mysql_query($sq,$linkbd);
						$idacuerdopre=mysql_fetch_row($rs);
						if($idacuerdopre[0]!='')
						{
							$cuentavigencias=1;
						}	
						while($r=mysql_fetch_row($res))
						{
							$sql="SELECT * FROM tesoacuerdopredial_det WHERE idacuerdo='$idacuerdopre[0]' and vigencia='$r[0]'";
							$rst=mysql_query($sql,$linkbd);
							if(!mysql_fetch_row($rst))
							{
							$banderapre++;
							$otros=0; 
							$sqlr2="select IF(tasa='-1',0,tasa) from tesoprediosavaluos where vigencia='$r[0]' and codigocatastral='$r[1]' " ;
						
			 				$res2=mysql_query($sqlr2,$linkbd);
	 						$row2=mysql_fetch_row($res2);
							$base=$r[2];

							$valorperiodo=$base*($row2[0]/1000)-$base*($row2[0]/1000)*($_POST[deduccion]/100);
							//$valorperiodo=$base*($row2[0]/1000);
							$tasav=$row2[0];
							$predial=round($base*($row2[0]/1000)-$base*($row2[0]/1000)*($_POST[deduccion]/100),2);
							//$predial=round($base*($row2[0]/1000),2);
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
			 				{//echo "hola".$vigusu; 
								if($vigusu==$r[0] && ($_POST[descuento]>0 or $condes==1) )
				 				{
									$pdescuento=$_POST[descuento]/100; 					
									$tdescuentos+=round(($predial)*$pdescuento,0);
									//
				  				}
				  				elseif ($interespredial=='inicioanio')//Si se cuentan los dias desde el principio del a�o 
				   				{
									$fechaini=mktime(0,0,0,1,1,$r[0]);
									$fechafin=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
									$difecha=$fechafin-$fechaini;
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

							$res3=mysql_query($sqlr2,$linkbd);
							while($r3=mysql_fetch_row($res3))
							{

								if($r3[5]>0 && $r3[5]<100)
					 			{
					  				if($r3[2]=='03')
					    			{
	
										if( $_POST[basepredial]==1)	
										{
				
											$valoringreso[0]=round($base*($r3[5]/1000),0)-($base*($r3[5]/1000)*($_POST[deduccion]/100));
											//$valoringreso[0]=round($base*($r3[5]/1000),0);
											$valoringresos+=round($base*($r3[5]/1000),0)-($base*($r3[5]/1000)*($_POST[deduccion]/100));
											//$valoringresos+=round($base*($r3[5]/1000),0);	
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
													$numdias = cal_days_in_month(CAL_GREGORIAN, $i, $vigcal);
													$totdiastri += $numdias;
													if($i==$fechainiciocobro)
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
											//$valoringreso[1]=round($base*($r3[5]/1000),0);
											$valoringresos+=round($base*($r3[5]/1000),0)-($base*($r3[5]/1000)*($_POST[deduccion]/100));	
											//$valoringresos+=round($base*($r3[5]/1000),0);
										}	
										if( $_POST[basepredialamb]==2)
										{	
											$valoringreso[1]=round($predial*($r3[5]/100),0);
											  //echo $predial." -- ".$r3[5]."= ".$valoringreso[1];
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
													if($i==$fechainiciocobro)
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
									$numdias = cal_days_in_month(CAL_GREGORIAN, $i, $vigcal);
									$totdiastri += $numdias;
									if($i==$fechainiciocobro)
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
											//echo $rowinteres[$i-1]."<br>";
									}
									
								}
								$vigcal+=1;
							}

			$chk='';

			$ch=esta_en_array($_POST[dselvigencias], $r[0]);

			if($ch==1){$chk=" checked";}

			$descipred=0;

			if($r[0]<=$_POST[vigmaxdescint] && $_POST[aplicadescint]=='S'){$descipred=$ipredial*($_POST[porcdescint]/100)+$intereses[0]*($_POST[porcdescint]/100)+$intereses[1]*($_POST[porcdescint]/100);}

			$totalpredial=round($predial+$otros+$totalintereses-$descipred+$ipredial,0);

			//echo "round($predial+$otros+$totalintereses-$descipred+$ipredial,0);";

			$totalpagar=round($totalpredial- round($tdescuentos,0),0);

			//*************	

			 echo "<tr class='$co'>

			 		<td >

			 			<input name='dvigencias[]' value='".$r[0]."' type='text' size='4' readonly>

			 		</td>

			 		<td>

			 			<input name='dcodcatas[]' value='".$r[1]."' type='text' size='16' readonly>

			 			<input name='dvaloravaluo[]' value='".$base."' type='hidden' >

			 			<input name='dtasavig[]' value='".$tasav."' type='hidden' >

			 		</td>

			 		<td >

			 			<input name='dpredial[]' value='".$predial."' type='text' size='10' readonly>

			 		</td>

			 		<td >

			 			<input name='dipredial[]' value='".$ipredial."' type='text' size='7' readonly>

			 		</td>

			 		<td >

			 			<input name='ddescipredial[]' value='".$descipred."' type='text' size='7' readonly>

			 		</td>

			 		<td >

			 			<input name='ditpredial[]' value='".($ipredial-$descipred)."' type='text' size='7' readonly>

			 		</td>

			 		<td >

			 			<input name='dimpuesto1[]' value='".($valoringreso[0]+0)."' type='text'  size='12' readonly>

			 		</td>

			 		<td >

			 			<input name='dinteres1[]' value='".($intereses[0]+0)."' type='text' size='7' readonly>

			 		</td>

			 		<td >

			 			<input name='dimpuesto2[]' value='".($valoringreso[1]+0)."' type='text'  size='12' readonly>

			 		</td>

			 		<td >

			 			<input name='dinteres2[]' value='".($intereses[1]+0)."' type='text' size='7' readonly>

			 		</td>

			 		<td>

			 			<input type='text' name='ddescuentos[]' value='$tdescuentos' size='6' readonly>

			 		</td>

			 		<td >

			 			<input name='davaluos[]' value='".number_format($totalpagar,2)."' type='text' size='10' readonly>

			 			<input name='dhavaluos[]' value='".$totalpagar."' type='hidden' >

			 		</td>

			 		<td >

			 			<input type='text' name='dias[]' value='$diasd' size='4' readonly>

			 		</td>

			 		<td>

			 			<input type='checkbox' name='dselvigencias[]' value='$r[0]' onClick='buscavigencias(this)' $chk>

			 		</td>

			 	</tr>";

		 $_POST[totalc]=$_POST[totalc]+$_POST[davaluos][$x];

		 $_POST[totalcf]=number_format($_POST[totalc],2,".",",");

		 $aux=$co;

		 $co=$co2;

		 $co2=$aux;

		 }

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

	  $_POST[numpredial]=selconsecutivo('tesoliquidapredial','idpredial');

	  $sqlr="insert into tesoliquidapredial (idpredial,codigocatastral, fecha, vigencia, tercero,tasamora, descuento, tasapredial, totaliquida, totalpredial, totalbomb, totalmedio, totalinteres, intpredial, intbomb, intmedio, totaldescuentos, concepto,estado,ord,tot) values ('$_POST[numpredial]','$_POST[codcat]','$fechaf','".$vigusu."','$_POST[tercero]','$_POST[tasamora]','$_POST[descuento]','$_POST[tasa]','$_POST[totliquida]','$_POST[totpredial]', '$_POST[totbomb]','$_POST[totamb]' ,'$_POST[totint]','$_POST[intpredial]','$_POST[intbomb]','$_POST[intamb]','$_POST[totdesc]','".utf8_decode("Años Liquidados:".$ageliqui)."','S','$_POST[ord]','$_POST[tot]')";

	if(!mysql_query($sqlr,$linkbd))

	 {  

	   echo "

									<script>

										despliegamodalm('visible','2','No Se ha podido Liquidar el Predial');

										document.getElementById('valfocus').value='2';

									</script>";

	 }

	  else

	   {

		 $idp=$_POST[numpredial]; 		 

		 $sqlr="update tesoautorizapredial set liquidacion='$idp' where id_auto='$_POST[autorizacion]' ";

		 mysql_query($sqlr,$linkbd);

		 echo "<input name='idpredial' value='$idp' type='hidden' >";

		 echo "<script>despliegamodalm('visible','1','Se ha liquidado el predial');</script>";		 

		 for ($y=0;$y<count($_POST[dselvigencias]);$y++)

		  {

		 for($x=0;$x<count($_POST[dvigencias]);$x++)

		  {

			  if($_POST[dvigencias][$x]==$_POST[dselvigencias][$y])

			  {

		 $sqlr="insert into tesoliquidapredial_det (`idpredial`, `vigliquidada`, avaluo,tasav,`predial`, `intpredial`, `bomberil`, `intbomb`, `medioambiente`, `intmedioambiente`, `descuentos`, `totaliquidavig`, `estado`) values ($idp,'".$_POST[dvigencias][$x]."',".$_POST[dvaloravaluo][$x].",".$_POST[dtasavig][$x].",".$_POST[dpredial][$x].",".$_POST[dipredial][$x].",".$_POST[dimpuesto1][$x].",".$_POST[dinteres1][$x].",".$_POST[dimpuesto2][$x].",".$_POST[dinteres2][$x].",".$_POST[ddescuentos][$x].",".$_POST[dhavaluos][$x].",'S')";

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