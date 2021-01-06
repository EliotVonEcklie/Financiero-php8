<?php //V 1000 12/12/16 ?> 
<!--V 1.0 24/02/2015-->
<?php
	require "comun.inc";
	require "funciones.inc";
	require "conversor.php";
	session_start();
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
        <script src="css/calendario.js"></script>
		<script src="css/programas.js"></script>
<script>
function buscacta(e){if (document.form2.cuenta.value!=""){document.form2.bc.value='1';document.form2.submit();}}
function validar(){document.form2.submit();}
function buscater(e){if (document.form2.tercero.value!=""){document.form2.bt.value='1';document.form2.submit();}}
function agregardetalle()
{
	if(document.form2.numero.value!="" &&  document.form2.valor.value>0 &&  document.form2.banco.value!=""  )
	{ 
		document.form2.agregadet.value=1;
		//document.form2.chacuerdo.value=2;
		document.form2.submit();
	}
 	else {alert("Falta informacion para poder Agregar");}
}
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
function guardar()
{
	if (document.form2.fecha.value!='')
 		{if (confirm("Esta Seguro de Guardar")){document.form2.oculto.value=2;document.form2.submit();}}
 	else{alert('Faltan datos para completar el registro');document.form2.fecha.focus();document.form2.fecha.select();}
}
function pdf()
{
	document.form2.action="pdfestadocuenta.php";
	document.form2.target="_BLANK";
	document.form2.submit(); 
	document.form2.action="";
	document.form2.target="";
}
function buscar()
{
	//alert("dsdd");
	document.form2.buscav.value='1';
	document.form2.submit();
}
function buscavigencias()
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
  <a href="teso-estadocuenta.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
  <a href="#" class="mgbt"><img src="imagenes/guardad.png" title="Guardar" /></a>
  <a href="teso-buscapredial.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a>
  <a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
  <a href="#" onClick="pdf()" class="mgbt"> <img src="imagenes/print.png"  title="Buscar" /></a>
  <a href="teso-informespredios.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a></td>
</tr>		  
</table>
<?php
	$vigencia=date(Y);
	$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
 	$_POST[vigencia]=$vigusu; 	
	$dif= diferenciamesesfechas_f2($_POST[fecha],$_POST[fechaav]);
 	if(0>diferenciamesesfechas_f2($_POST[fecha],$_POST[fechaav]))
	{
		?><script>alert("LA FECHA DE PROYECCION DE LIQUIDACION NO PUEDE SER MENOR A LA FECHA ACTUAL")</script><?php
 		$_POST[fechaav]=$_POST[fecha];
	}	
	  //*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
	if(!$_POST[oculto])
	{
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

		
		$fec=date("d/m/Y");
		$_POST[fecha]=$fec; 
		$_POST[fechaav]=$_POST[fecha];
		$fec=date("d/m/Y");
		$_POST[fecha]=$fec; 		 		  			 		
		$check1="checked";
		$sqlr="select *from tesotasainteres where vigencia=".$vigusu;
		$res=mysql_query($sqlr,$linkbd);
		$r=mysql_fetch_row($res);
		$tasam=array();
		$tasam[0]=$r[6];									
		$tasam[1]=$r[7];
		$tasam[2]=$r[8];
		$tasam[3]=$r[9];
		$tasamoratoria[0]=0;
		ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechaav],$fecha);
		//$fechaactual=$fecha[3]."-".$fecha[2]."-".$fecha[1];
		//echo $fecha[2];
		if($fecha[2]<=3){$tasamoratoria[0]=$tasam[0];}
		else
		{
			if($fecha[2]<=6){$tasamoratoria[0]=$tasam[1];}
			else
			{
				if($fecha[2]<=9){$tasamoratoria[0]=$tasam[2];}
				else{$tasamoratoria[0]=$tasam[3];}						
			}
		}
		$_POST[tasamora]=$tasamoratoria[0];   
		$_POST[tasa]=0;
		$_POST[predial]=0;
		$_POST[descuento]=0;
		$condes=0;
		//***** BUSCAR FECHAS DE INCENTIVOS
		ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechaav],$fecha);
		$fechaactual=$fecha[3]."-".$fecha[2]."-".$fecha[1];	
		$sqlr="select *from tesodescuentoincentivo where vigencia=".$vigusu." and ingreso='01' and estado='S'";
		$res=mysql_query($sqlr,$linkbd);
		while($r=mysql_fetch_row($res))
		{	
			if($r[7]<=$fechaactual && $fechaactual <= $r[8]){$fdescuento=$r[2];$_POST[descuento]=$r[2];$condes=1; }
			elseif($fechaactual>$r[9] && $fechaactual <= $r[10]){$fdescuento=$r[2];$_POST[descuento]=$r[3];$condes=1;}
			elseif($fechaactual>$r[11] && $fechaactual <= $r[12]){$fdescuento=$r[2];$_POST[descuento]=$r[4];$condes=1;} 
			else {$ulfedes=explode("-",$r[12]);}
		}
		//*************cuenta caja
		$sqlr="select *from cuentacaja where estado='S' and vigencia=".$vigusu;
		$res=mysql_query($sqlr,$linkbd);
		while ($row =mysql_fetch_row($res)){$_POST[cuentacaja]=$row[1];}
		$sqlr="select max(numerotipo) from comprobante_cab where tipo_comp='8' ";
		$res=mysql_query($sqlr,$linkbd);
		$consec=0;
		while($r=mysql_fetch_row($res)){$consec=$r[0];}
	   	$consec+=1;
	  	$_POST[idcomp]=$consec;	
		$fec=date("d/m/Y");
	   	$_POST[fecha]=$fec; 		 		  			 
		$_POST[valor]=0;		 
	}
	else
 	{
		$sqlr="select *from tesotasainteres where vigencia=".$vigusu;
		$res=mysql_query($sqlr,$linkbd);
		$r=mysql_fetch_row($res);
		$tasam=array();
		$tasam[0]=$r[6];									
		$tasam[1]=$r[7];
		$tasam[2]=$r[8];
		$tasam[3]=$r[9];
		$tasamoratoria[0]=0;
		$sqlr="select *from tesotasainteres where vigencia=".$vigusu;
		$res=mysql_query($sqlr,$linkbd);
		$r=mysql_fetch_row($res);
		$tasam=array();
		$tasam[0]=$r[6];									
		$tasam[1]=$r[7];
		$tasam[2]=$r[8];
		$tasam[3]=$r[9];
		$tasamoratoria[0]=0;
		ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechaav],$fecha);
		//$fechaactual=$fecha[3]."-".$fecha[2]."-".$fecha[1];
		//echo $fecha[2];
		if($fecha[2]<=3){$tasamoratoria[0]=$tasam[0];}
		else
		{
			if($fecha[2]<=6){$tasamoratoria[0]=$tasam[1];}
			else
			{
				if($fecha[2]<=9){$tasamoratoria[0]=$tasam[2]; }
				else{$tasamoratoria[0]=$tasam[3];}						
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
			if($r[7]<=$fechaactual && $fechaactual <= $r[8]){$fdescuento=$r[2];$_POST[descuento]=$r[2];$condes=1;}
			elseif($fechaactual>$r[9] && $fechaactual <= $r[10]){$fdescuento=$r[2];$_POST[descuento]=$r[3];$condes=1;}
			elseif($fechaactual>$r[11] && $fechaactual <= $r[12]){$fdescuento=$r[2];$_POST[descuento]=$r[4];$condes=1;} 
			else {$ulfedes=explode("-",$r[12]);} 
		}
 	}
	switch($_POST[tabgroup1])
	{
		case 1:$check1='checked';break;
		case 2:$check2='checked';break;
		case 3:$check3='checked';
	}
?>
 	<form name="form2" method="post" action="">
<?php
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
	 	$sqlr="select *from tesopredios where cedulacatastral='".$_POST[codcat]."' AND ORD='$_POST[ord]' AND TOT='$_POST[tot]'";
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
			if($_POST[tipop]=='urbano'){$_POST[estrato]=$row[15];$tipopp=$row[15];}
			else{$_POST[rangos]=$row[15];$tipopp=$row[15];}
			// $_POST[dcuentas][]=$_POST[estrato];		
			$_POST[dtcuentas][]=$row[1];		 
			$_POST[dvalores][]=$row[5];
			$_POST[buscav]="";
			$sqlr2="select *from tesotarifaspredial where vigencia='".$vigusu."' and tipo='$_POST[tipop]' and estratos=$tipopp";
		 	$res2=mysql_query($sqlr2,$linkbd);
	 		while($row2=mysql_fetch_row($res2))
			{
				$_POST[tasa]=$row2[5];
			   	$_POST[predial]=($row2[5]/1000)*$_POST[vavaluo];
			   	$_POST[predial]=number_format($_POST[predial],2);
			}
	  	}
  	}
?>
<div class="tabspre">
	<div class="tab">
		<input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
	   	<label for="tab-1">Estado de Cuenta</label>
	   	<div class="content">
 			<table class="inicio" align="center" >
      			<tr >
        			<td class="titulos" colspan="9" style='width:93%'>Estado de Cuenta</td>
                    <td class="cerrar" style='width:7%'><a href="teso-principal.php">Cerrar</a></td>
      			</tr>
     			<tr>
					<td class="saludo1">No Liquidacion:</td>
                    <td><input name="numpredial" type="text" value="<?php echo $_POST[numpredial]?>"  size="8" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly></td>
                    <td class="saludo1">Fecha:</td>
                    <td><input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10" size="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly></td>
                    <td class="saludo1">Vigencia:</td>
                    <td><input name="vigencia" type="text" value="<?php echo $_POST[vigencia]?>" maxlength="2" size="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly></td>
                    <td class="saludo1">Tasa Interes Mora:</td><td><input name="tasamora" type="text" value="<?php echo $_POST[tasamora]?>" size="5" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly>%</td>
                    <td class="saludo1">Descuento:</td>
                    <td><input name="descuento" type="text" value="<?php echo $_POST[descuento]?>"  size="5" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly>%</td >
                </tr>
	  <tr><td class="saludo1">Proy Liquidacion:</td><td><input name="fechaav" type="text" value="<?php echo $_POST[fechaav]?>" maxlength="10" size="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY"  readonly>   <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>  </td> 
	  
	  <td width="128" class="saludo1">Codigo Catastral:</td> 
          <td  >
		  <input id="codcat" type="text" name="codcat" size="20" onKeyUp="return tabular(event,this)" onBlur="buscar(event)" value="<?php echo $_POST[codcat]?>" >
		  <input id="ord" type="text" name="ord" size="3"  value="<?php echo $_POST[ord]?>" readonly>
		  <input id="tot" type="text" name="tot" size="3" value="<?php echo $_POST[tot]?>" readonly><input type="hidden" value="0" name="bt">  <a href="#" onClick="mypop=window.open('catastral-ventana.php','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=900,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a><input type="hidden" name="chacuerdo" value="1"><input type="hidden" value="1" name="oculto"></td>
		  <td class="saludo1">Deuda superior a:</td><td><input name="deudasuperior" id="deudasuperior" type="text" value="<?php echo "$_POST[deudasuperior]"; ?>" size="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"></td>
		  <td> <input type="hidden" value="<?php echo  $_POST[basepredial] ?>" name="basepredial"><input type="hidden" value="<?php echo  $_POST[basepredialamb] ?>" name="basepredialamb"><input type="hidden" value="<?php echo  $_POST[aplicapredial] ?>" name="aplicapredial"> <input type="hidden" value="<?php echo $_POST[buscav]?>" name="buscav"><input type="button" name="buscarb" id="buscarb" value="   Buscar   " onClick="buscar()" ></td>
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
	    <td class="titulos" colspan="8">Informaci&oacute;n Predio</td></tr>
	  <tr>
	  <td width="119" class="saludo1">C&oacute;digo Catastral:</td>
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
	  <td width="119" class="saludo1">Direcci&oacute;n:</td>
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
			 // $tasaintdiaria=(pow((1+$_POST[tasamora]/100),(1/365))-1);
			  $tasaintdiaria=($_POST[tasamora]/100);
			  $cuentavigencias=0;
			  $tdescuentos=0;
			$sqlr="Select  distinct TB1.codigocatastral, TB1.vigencia from tesoprediosavaluos TB1,tesopredios TB2 where TB1.estado='S' and TB1.pago='N' and TB1.codigocatastral=TB2.cedulacatastral and TB2.ord=TB1.ord  and TB2.tot=TB1.tot limit 0,10";	
			$res=mysql_query($sqlr,$linkbd);
			while($row=mysql_fetch_row($res))
			{
			$sqlr2="select TB1.predial, from tesoliquidapredial_det TB1,tesoliquidapredial TB2 where TB2.codigocatastral='row[0]' and TB2.idpredial=TB1.idpredial";
			$res2=mysql_query($sqlr2,$linkbd);
			
			$cuentavigencias = mysql_num_rows($res);
			$cv=0;
					 
			$otros=0;
			//$sqlr2="select *from tesotarifaspredial where vigencia='".$vigusu."' and tipo='$r[19]' and estratos=$r[20]";
			$sqlr2="select *from tesotarifaspredial where vigencia='".$r[0]."' and tipo='$r[21]' and estratos=$r[22]";
			//echo $sqlr2;
			 $res2=mysql_query($sqlr2,$linkbd);
	 		$row2=mysql_fetch_row($res2);
			$base=$r[2];
			$valorperiodo=round($base*($row2[5]/1000)-$base*($row2[5]/1000)*($_POST[deduccion]/100),2);
			$tasav=$row2[5];
			$predial=round($base*($row2[5]/1000)-$base*($row2[5]/1000)*($_POST[deduccion]/100),2);
			$valoringresos=0;
			$sidescuentos=0;
			
						//**validacion normatividad predial *****
		if($_POST[aplicapredial]=='S')
		{
		$estant="N";
		$sqlrp="select * from tesoprediosavaluos where vigencia=".($r[0]-1)."";		
	 	$respr=mysql_query($sqlrp,$linkbd);
 		$rowpr=mysql_fetch_row($respr);
		$baseant=0;
		$estant=$rowpr[3];
		$baseant=$rowpr[2]+0;
		$predialant=$baseant*($row2[5]/1000);
		//echo "<br>$predialant $baseant".$row2[5];
		if($estant=='S')
		{	
		$sqlrav="select distinct tesoliquidapredial_det.predial,tesoliquidapredial_det.avaluo from tesoliquidapredial_det,tesoliquidapredial where tesoliquidapredial_det.idpredial=tesoliquidapredial.idpredial and tesoliquidapredial.codigocatastral='$_POST[catastral]' and tesoliquidapredial.estado='P' AND tesoliquidapredial_det.vigliquidada='".($r[0]-1)."'";
		//echo "<BR>".$sqlrav;
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
		//echo "".$sqlrp;
		//$baseant=$rowpr[2]+0;
		//$predialant=$baseant*($row2[5]/1000);
		//echo "<br>bas ".$predialant."  PR:".$predial;
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

			
			
			//****buscar en el concepto del ingreso *******
			$intereses=array();
			$valoringreso=array();
			$in=0;
			
			if($cuentavigencias>1)
			 {
				if($vigusu==$r[0] && ($_POST[descuento]>0 or $condes==1))
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
							//$fechaini=mktime(0,0,0,1,1,$r[0]);
							$fechaini=mktime(0,0,0,$ulfedes[1],$ulfedes[2],$r[0]);
						}
//						$fechaini=mktime(0,0,0,1,1,$r[0]);
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
					$tdescuentos+=ceil(($predial)*$pdescuento);
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
						//$valoringreso[0]=round($_POST[vavaluo]*($r3[5]/1000),0);
					  	//$valoringresos+=round($_POST[vavaluo]*($r3[5]/1000),0);	
						$valoringreso[0]=round($base*($r3[5]/1000),0)-($base*($r3[5]/1000)*($_POST[deduccion]/100));
					  	$valoringresos+=round($base*($r3[5]/1000),0)-($base*($r3[5]/1000)*($_POST[deduccion]/100));	
						}
						if($_POST[basepredial]==2)
						{	
					  $valoringreso[0]=round($predial*($r3[5]/100),0);
					  $valoringresos+=round($predial*($r3[5]/100),0);
						}
					 // $intereses[0]=ceil($valoringreso[0]*(pow(1+$tasaintdiaria,$diasd)-1));
					 $intereses[0]=round(($valoringreso[0]*$diasd*$tasaintdiaria)/365,0);
					  $totalintereses+=$intereses[0];						
					    }
					    if($r3[2]=='02')
					    {
						if( $_POST[basepredialamb]==1)	
						{
						//$valoringreso[1]=round($_POST[vavaluo]*($r3[5]/1000),0);
					  	//$valoringresos+=round($_POST[vavaluo]*($r3[5]/1000),0);	
						$valoringreso[1]=round($base*($r3[5]/1000),0)-($base*($r3[5]/1000)*($_POST[deduccion]/100));
					  	$valoringresos+=round($base*($r3[5]/1000),0)-($base*($r3[5]/1000)*($_POST[deduccion]/100));	
						}
						if($_POST[basepredialamb]==2)
						{
					  	$valoringreso[1]=round($predial*($r3[5]/100),0);
					  	$valoringresos+=round($predial*($r3[5]/100),0);
						}
					  //$intereses[1]=ceil($valoringreso[1]*(pow(1+$tasaintdiaria,$diasd)-1));
					  $intereses[1]=round(($valoringreso[1]*$diasd*$tasaintdiaria)/365,0);
					  $totalintereses+=$intereses[1];						 
					    }	
					  if($sidescuentos==1 && '03'==$r3[2])
					   {
						$tdescuentos+=round($valoringreso[0]*$pdescuento,0);
						}
						if($sidescuentos==1 && '02'==$r3[2])
					   {
						$tdescuentos+=round($valoringreso[1]*$pdescuento,0);
					   }
					  $in+=1;
					 }
					}
			$otros+=$valoringresos;		
			//$ipredial=ceil($predial*(pow(1+$tasaintdiaria,$diasd)-1));
			$ipredial=round(($predial*$tasaintdiaria*$diasd)/365,0);			
			$totalpredial=round(($predial+$otros+$totalintereses+$ipredial),0);
			$totalpagar=round($totalpredial- $tdescuentos,0);
			$ch=esta_en_array($_POST[dselvigencias], $r[0]);
			if($ch==1)
			 {
			 $chk="checked";
			 }
			//*************	
			echo "
				<input type='hidden' name='dvigencias[]' value='$r[0]'/>
				<input type='hidden' name='dcodcatas[]' value='$r[1]'/>
				<input type='hidden' name='dpredial[]' value='$predial'/>
				<input type='hidden' name='dipredial[]' value='$ipredial'/>
				<input type='hidden' name='dimpuesto1[]' value='".($valoringreso[0]+0)."'/>
				<input type='hidden' name='dinteres1[]' value='".($intereses[0]+0)."'/>
				<input type='hidden' name='dimpuesto2[]' value='".($valoringreso[1]+0)."'/>
				<input type='hidden' name='dinteres2[]' value='".($intereses[1]+0)."'/>
				<input type='hidden' name='ddescuentos[]' value='$tdescuentos'/>
				<input type='hidden' name='davaluos[]' value='$totalpagar'/>
				<input type='hidden' name='dias[]' value='$diasd'/>
				<input type='hidden' name='dselvigencias[]' value='$r[0]'/>
			";
			
		 $_POST[totalc]=$_POST[totalc]+$_POST[davaluos][$x];
		 $_POST[totalcf]=number_format($_POST[totalc],2,".",",");
		 //$ag22eliqui=$ageliqui." ".$_POST[dselvigencias][$x];		
		 }	

						$xx=0;
						$varconta= count($_POST[dvigencias]);
						$xy=0;
						while ($xx < $varconta)
						{
							$sumatotal=0;
							for ($xy=0; $xy < $varconta; $xy++) { 
			 				if($_POST[dcodcatas][$xy]==$_POST[dcodcatas][$xx]){
			 					
			 					$sumatotal=$sumatotal+$_POST[davaluos][$xy];
			 					}

			 				}
			 				$sumafinal=$sumatotal;
							echo $sumafinal;
							echo "-".$_POST['deudasuperior'];
			 				if ($sumafinal>=$_POST['deudasuperior'])
			 				{
			 					
								echo "
								 <tr>
								 	<td class='saludo1'>".$_POST[dvigencias][$xx]."</td>
								 	<td class='saludo1'>".$_POST[dcodcatas][$xx]."</td>
								 	<td class='saludo1'>".$_POST[dpredial][$xx]."</td>
								 	<td class='saludo1'>".$_POST[dipredial][$xx]."</td>
								 	<td class='saludo1'>".$_POST[dimpuesto1][$xx]."</td>
								 	<td class='saludo1'>".$_POST[dinteres1][$xx]."</td>
								 	<td class='saludo1'>".$_POST[dimpuesto2][$xx]."</td>
								 	<td class='saludo1'>".$_POST[dinteres2][$xx]."</td>
								 	<td class='saludo1'>".$_POST[ddescuentos][$xx]."</td>
								 	<td class='saludo1'>".$_POST[davaluos][$xx]."</td>
								 	<td class='saludo1'>".$_POST[dias][$xx]."</td>
								 	<td class='saludo1'><input type='checkbox' name='dselvigencias[]' value='".$_POST[dselvigencias2][$xx]."' onClick='buscavigencias(this)' ".$_POST[varcheck][$xx]."></td></tr>";
								
							}
							$xx++;
						
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
		<script>buscavigencias()</script>
</form>
 </td></tr>
</table>
</body>
</html>