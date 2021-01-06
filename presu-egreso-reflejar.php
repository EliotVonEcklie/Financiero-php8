<?php
require"comun.inc";
require"funciones.inc";
require "conversor.php";
$linkbd=conectar_bd();
session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<title>:: SPID - Presupuesto</title>
<script language="JavaScript1.2">
	function validar(){
		document.form2.submit();
	}
//***************************************
	function guardar(){
		if (document.form2.fecha.value!=''){
			if (confirm("Esta Seguro de Guardar")){
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
function calcularpago()
 {
	//alert("dddadadad");
	valorp=document.form2.valor.value;
	descuentos=document.form2.totaldes.value;
	valorc=valorp-descuentos;
	document.form2.valorcheque.value=valorc;
	document.form2.valoregreso.value=valorp;
	document.form2.valorretencion.value=descuentos;	
	  	document.form2.submit();
 }
</script>
<script>
function pdf()
{
document.form2.action="pdfcxp.php";
document.form2.target="_BLANK";
document.form2.submit(); 
document.form2.action="";
document.form2.target="";
}
</script>
<script language="JavaScript1.2">
function adelante()
{
//   alert("Balance Descuadrado");
//document.form2.oculto.value=2;
if(parseFloat(document.form2.ncomp.value)<parseFloat(document.form2.maximo.value))
 {
document.form2.oculto.value=1;
//document.form2.agregadet.value='';
//document.form2.elimina.value='';
document.form2.ncomp.value=parseFloat(document.form2.ncomp.value)+1;
document.form2.idcomp.value=parseFloat(document.form2.idcomp.value)+1;
document.form2.action="presu-egreso-reflejar.php";
document.form2.submit();
}
}
</script>
<script language="JavaScript1.2">
function atrasc()
{

//document.form2.oculto.value=2;
if(document.form2.ncomp.value>1)
 {

document.form2.oculto.value=1;
//document.form2.agregadet.value='';
//document.form2.elimina.value='';
document.form2.ncomp.value=document.form2.ncomp.value-1;
document.form2.idcomp.value=document.form2.idcomp.value-1;
document.form2.action="presu-egreso-reflejar.php";
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
document.form2.action="presu-egreso-reflejar.php";
document.form2.submit();
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
	<tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
	<tr><?php menu_desplegable("presu");?></tr>
<tr>
  <td colspan="3" class="cinta"><a href="#" class="mgbt"><img src="imagenes/add2.png" alt="Nuevo"  border="0" /></a> <a href="#" class="mgbt"><img src="imagenes/guardad.png"  alt="Guardar" /></a><a href="presu-buscaegreso-reflejar.php" class="mgbt"> <img src="imagenes/busca.png"  alt="Buscar" border="0" /></a> <a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana"></a>  <a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/reflejar1.png"  alt="Reflejar" style="width:24px;" /> <a href="#" onClick="pdf()" class="mgbt"> <img src="imagenes/print.png"  alt="Buscar" /></a> <a href="presu-reflejardocs.php" class="mgbt"><img src="imagenes/iratras.png" alt="nueva ventana"></a></td>
</tr>		  
</table>
<tr><td colspan="3" class="tablaprin" align="center"> 
<?php
$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
$vigencia=$vigusu;
?>	
<?php
	  //*********** cuenta origen va al credito y la destino al debito
if($_GET[idr]!=""){echo "<script>document.getElementById('codrec').value=$_GET[idr];</script>";}
if(!$_POST[oculto]){
	$sqlr="select *from cuentapagar where estado='S' ";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)){
		$_POST[cuentapagar]=$row[1];
	}
	$sqlr="select * from tesoordenpago ORDER BY id_orden DESC";
	$res=mysql_query($sqlr,$linkbd);
	$r=mysql_fetch_row($res);
	$_POST[maximo]=$r[0];

	if ($_POST[codrec]!="" || $_GET[idr]!=""){
		if($_POST[codrec]!=""){
			$sqlr="select * from tesoordenpago WHERE id_orden='$_POST[codrec]'";
		}
		else{
			$sqlr="select * from tesoordenpago WHERE id_orden='$_GET[idr]'";
		}
	}
	else{
		$sqlr="select * from tesoordenpago ORDER BY id_orden DESC";
	}
	$res=mysql_query($sqlr,$linkbd);
	$r=mysql_fetch_row($res);
	$_POST[ncomp]=$r[0];
	$check1="checked"; 
 	$fec=date("d/m/Y");
	if($_GET[idop]!=""){	
		$_POST[ncomp]=$_GET[idop];
	}
//		 $_POST[fecha]=$fec; 		 		  			 
		//$_POST[valor]=0;
		//$_POST[valorcheque]=0;
		//$_POST[valorretencion]=0;
		//$_POST[valoregreso]=0;
		//$_POST[totaldes]=0;
	$vigusu=$vigusu; 		
	$sqlr="select * from tesoordenpago where id_orden=".$_POST[ncomp];
	$res=mysql_query($sqlr,$linkbd);
	$consec=0;
	while($r=mysql_fetch_row($res)){
		$_POST[fecha]=$r[2];
		$_POST[compcont]=$r[1];
		$consec=$r[0];	  
		$_POST[rp]=$r[4];
  		$_POST[estado]=$r[13];
		$_POST[estadoc]=$r[13];
	}
	$_POST[idcomp]=$consec;	
	ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
	$_POST[fecha]=$fechaf;
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
	$sqlr="select * from tesoordenpago where id_orden=$_POST[idcomp] ";
	$res=mysql_query($sqlr,$linkbd);
	while($r=mysql_fetch_row($res)){
 		$_POST[fecha]=$r[2];
//	  $_POST[idcomp]=$r[0];	  
	  	ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
		$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
	 	$_POST[fecha]=$fechaf;	
	 	$_POST[rp]=$r[4];
	 	$_POST[estado]=$r[13];
		$_POST[estadoc]=$r[13];	
	}
	$nresul=buscaregistro($_POST[rp],$vigusu);
	$_POST[cdp]=$nresul;
	//*** busca detalle cdp
	$linkbd=conectar_bd();
  	$sqlr="select pptorp.vigencia,pptorp.consvigencia,pptocdp.objeto,pptorp.estado,pptocdp.consvigencia,pptorp.valor,pptorp.saldo,pptorp.tercero, pptocdp.objeto from pptorp,pptocdp where pptorp.estado='S' and pptocdp.consvigencia=$_POST[cdp] and pptorp.idcdp=pptocdp.consvigencia and pptorp.consvigencia=".$_POST[rp]." and pptorp.vigencia=$vigusu and pptorp.idcdp=pptocdp.consvigencia and pptocdp.vigencia=$vigusu order by pptorp.vigencia,pptorp.consvigencia,pptocdp.objeto,pptorp.estado";
	//echo $sqlr;
	$resp = mysql_query($sqlr,$linkbd);
	$row =mysql_fetch_row($resp);
	$_POST[detallecdp]=$row[2];
	$sqlr="Select *from tesoordenpago where id_orden=".$_POST[idcomp];
	$resp = mysql_query($sqlr,$linkbd);
	$row =mysql_fetch_row($resp);
	$_POST[tercero]=$row[6];
	$_POST[ntercero]=buscatercero($_POST[tercero]);
	$_POST[valorrp]=$row[8];
	$_POST[saldorp]=$row[9];
	$_POST[cdp]=$row[4];
	$_POST[valor]=$row[10];
	$_POST[cc]=$row[5];				
	$_POST[detallegreso]=$row[7];
	$_POST[valoregreso]=$_POST[valor];
	$_POST[valorretencion]=$row[12];
	$_POST[base]=$row[14];
	$_POST[iva]=$row[15];
	$_POST[valorcheque]=$_POST[valoregreso]-$_POST[valorretencion];
	//$_POST[valorcheque]=number_format($_POST[valorcheque],2);								
 	?>
 	<div class="tabsic">
   		<div class="tab">
       		<input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
	   		<label for="tab-1">Liquidacion CxP</label>
	   		<div class="content">
    		<table class="inicio" align="center" >
      			<tr >
        			<td class="titulos" colspan="10">Liquidacion CxP</td>
        			<td style="width:7%" class="cerrar" ><a href="presu-principal.php">Cerrar</a></td>
      			</tr>
      			<tr>
		        	<td style="width:4.5cm" class="saludo1" >Numero CxP:</td>
        			<td style="width:10%"> 
                    	<a href="#" onClick="atrasc()"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a>
                        <input name="idcomp" type="text" style="width:50%" value="<?php echo $_POST[idcomp]?>" onBlur="validar2()" onKeyUp="return tabular(event,this)">
                        <input name="ncomp" type="hidden" value="<?php echo $_POST[ncomp]?>">
                        <input name="compcont" type="hidden" value="<?php echo $_POST[compcont]?>">
                        <a href="#" onClick="adelante()"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> 
                        <input type="hidden" value="a" name="atras" >
                        <input type="hidden" value="s" name="siguiente" >
                        <input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo">
                        <input type="hidden" value="<?php echo $_POST[codrec]?>" name="codrec" id="codrec">
                  	</td>
	  				<td style="width:2.5cm" class="saludo1">Fecha: </td>
        			<td style="width:8%">
                    	<input name="fecha" type="text" value="<?php echo $_POST[fecha]?>"  style="width:100%" onKeyUp="return tabular(event,this)"  readonly>   
                  	</td>
	  				<td style="width:2.5cm" class="saludo1">Vigencia: </td>
        			<td style="width:20%">
                    	<input name="vigencia" type="text" value="<?php echo $vigusu?>"  style="width:40%" onKeyUp="return tabular(event,this)" readonly> 
                        <input name="estadoc" type="text" value="<?php echo $_POST[estadoc]?>" style="width:40%" readonly > 
                        <input name="estado" type="hidden" value="<?php echo $_POST[estado]?>">
                 	</td>
                    <td colspan="4" style="width:20%"></td>
				<tr>
        			<td class="saludo1">Registro:</td>
        			<td>
                    	<input name="rp" type="text" value="<?php echo $_POST[rp]?>" style="width:100%" onKeyUp="return tabular(event,this)" readonly >
                        <input type="hidden" value="0" name="brp">
					</td>
	  				<td class="saludo1">CDP:</td>
	  				<td>
						<input type="text" id="cdp" name="cdp" value="<?php echo $_POST[cdp]?>" style="width:100%" readonly>
                   	</td>
	  				<td class="saludo1">Detalle RP:</td>
	  				<td colspan="5">
						<input type="text" id="detallecdp" name="detallecdp" value="<?php echo $_POST[detallecdp]?>" style="width:100%" readonly>
                  	</td>
	  			</tr> 
	  			<tr>
	  				<td class="saludo1">Centro Costo:</td>
	  				<td>
						<select name="cc"  onChange="validar()" onKeyUp="return tabular(event,this)">
							<?php
							$sqlr="select *from centrocosto where estado='S'";
							$res=mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($res)){
					 			if($row[0]==$_POST[cc]){
									echo "<option value=$row[0] SELECTED>".$row[0]." - ".$row[1]."</option>";
						 		}
							}	 	
							?>
   						</select>
	 				</td>
	     			<td class="saludo1">Tercero:</td>
          			<td>
                    	<input id="tercero" type="text" name="tercero" style="width:100%" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[tercero]?>" readonly>
           			</td>
          			<td colspan="6">
                    	<input  id="ntercero"  name="ntercero" type="text" value="<?php echo $_POST[ntercero]?>" style="width:100%" readonly>
                   	</td>
              	</tr>
          		<tr>
                	<td class="saludo1">Detalle Orden de Pago:</td>
                    <td colspan="9">
						<input type="text" id="detallegreso" name="detallegreso" value="<?php echo $_POST[detallegreso]?>" style="width:100%"  readonly >
                     </td>
              	</tr>
	  			<tr>
                	<td class="saludo1">Valor RP:</td>
                    <td>
                    	<input type="text" id="valorrp" name="valorrp" value="<?php echo number_format($_POST[valorrp],2,',','.')?>" style="width:100%; text-align:right;" onKeyUp="return tabular(event,this)" readonly>
                   	</td>
                    <td class="saludo1">Saldo RP:</td>
                    <td>
                    	<input type="text" id="saldorp" name="saldorp"  value="<?php echo number_format($_POST[saldorp],2,',','.')?>" style="width:100%; text-align:right;" onKeyUp="return tabular(event,this)" readonly>
                   	</td>
	  				<td class="saludo1" >Valor a Pagar:</td>
                    <td>
                    	<input type="text" id="valor" name="valor" value="<?php echo number_format($_POST[valor],2,',','.')?>" style="width:100%; text-align:right;" onKeyUp="return tabular(event,this)" readonly> 
                        <input type="hidden" value="1" name="oculto">
                   	</td>
                    <td class="saludo1" >Base:</td>
                    <td>
                    	<input type="text" id="base" name="base" value="<?php echo number_format($_POST[base],2,',','.')?>" style="width:100%; text-align:right;" onKeyUp="return tabular(event,this)"  readonly> 
                   	</td>
                    <td class="saludo1" >Iva:</td>
                    <td>
                    	<input type="text" id="iva" name="iva" value="<?php echo number_format($_POST[iva],2,',','.')?>" style="width:100%; text-align:right;" onKeyUp="return tabular(event,this)"  readonly> 
                   	</td>
               	</tr>
      		</table>
		</div>
   	</div>
	<div class="tab">
       <input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?>>
       <label for="tab-2">Retenciones</label>
       <div class="content"> 
        	<table class="inicio" style="overflow:scroll">
        		<tr>
                	<td class="titulos">Descuento</td>
                    <td class="titulos">%</td>
                    <td class="titulos">Valor</td>
              	</tr>
      			<?php
				$totaldes=0;
				$sqlr="select *from tesoordenpago_retenciones where id_orden=".$_POST[idcomp];
				
				$res=mysql_query($sqlr,$linkbd);
				while($row=mysql_fetch_row($res)){		 
		 			$sqlr="select *from tesoretenciones where id='$row[0]'";
					$res2=mysql_query($sqlr,$linkbd);
					$row2=mysql_fetch_row($res2);
		 			echo "<tr>
						<td class='saludo2'>
							<input name='dndescuentos[]' value='".$row2[2]."' type='hidden'>
							<input name='ddescuentos[]' value='".$row[0]."' type='hidden'>".$row2[2]."
						</td>
		 				<td class='saludo2'>
							<input name='dporcentajes[]' value='".$row[2]."' type='hidden'>".$row[2]."
						</td>
		 				<td class='saludo2'>
							<input name='ddesvalores[]' value='".$row[3]."' type='hidden'>".$row[3]."
						</td>
					</tr>";
		 			$totaldes=$totaldes+$row[3];
		 		}		 
				?>
        	<script>
        		document.form2.totaldes.value=<?php echo $totaldes;?>;		
        	</script>
       	</table>
   	</table>
</div>
</div>
    <div class="tab">
       	<input type="radio" id="tab-3" name="tabgroup1" value="3" <?php echo $check3;?>>
       	<label for="tab-3">Cuenta por Pagar</label>
   		<div class="content"> 
	   		<table class="inicio" align="center" >
	   			<tr>
                	<td colspan="6" class="titulos">Cheque</td>
                    <td style="width:7%" class="cerrar" ><a href="presu-principal.php">Cerrar</a></td>
               	</tr>
				<tr>
	  				<td style="width:2.5cm" class="saludo1">Cuenta Contable:</td>
	  				<td style="width:20%">
	    				<input name="cuentapagar" type="text" value="<?php echo $_POST[cuentapagar]?>" style="width:100%; text-align:center" readonly> 
						<input name="cb" type="hidden" value="<?php echo $_POST[cb]?>" >
                        <input type="hidden" id="ter" name="ter" value="<?php echo $_POST[ter]?>" >
                  	</td>
                    <td style="width:50%" colspan="4"></td>
	  			</tr> 
	  			<tr>
	  				<td class="saludo1">Valor Orden de Pago:</td>
                    <td>
                    	<input type="text" id="valoregreso" name="valoregreso" value="<?php echo number_format($_POST[valoregreso],2,',','.')?>" style="width:100%; text-align:right" readonly>
                  	</td>
                    <td class="saludo1">Valor Retenciones:</td>
                    <td align="right">
                    	<input type="text" id="valorretencion" name="valorretencion" value="<?php echo number_format($_POST[valorretencion],2,',','.')?>" style="width:100%; text-align:right" readonly>
                   	</td>
                    <td class="saludo1">Valor Cta Pagar:</td>
                    <td align="right">
                    	<input type="text" id="valorcheque" name="valorcheque" value="<?php echo number_format($_POST[valorcheque],2,',','.')?>" style="width:100%; text-align:right" readonly>
                   	</td>
             	</tr>	
      		</table>
	   	</div>
	</div>
</div>
<div class="subpantallac4">
	<?php
	//*** busca contenido del rp
	$_POST[dcuentas]=array();
  	$_POST[dncuentas]=array();
	$_POST[dvalores]=array();
	$sqlr="select *from tesoordenpago_det where id_orden=$_POST[idcomp]";
	//echo $sqlr;
	$res=mysql_query($sqlr,$linkbd);
	while($r=mysql_fetch_row($res)){
		$consec=$r[0];	  
		$_POST[dcuentas][]=$r[2];
		$_POST[dvalores][]=$r[4];
		$_POST[dncuentas][]=buscacuentapres($r[2],2);
	}
  	?>
	<table class="inicio">
		<tr>
        	<td colspan="8" class="titulos">Detalle Orden de Pago</td>
       	</tr>                  
		<tr>
        	<td class="titulos2">Cuenta</td>
            <td class="titulos2">Nombre Cuenta</td>
            <td class="titulos2">Recurso</td>
            <td class="titulos2">Valor</td>
      	</tr>
		<?php
		$_POST[totalc]=0;
		$iter='saludo1a';
		$iter2='saludo2';
		for ($x=0;$x<count($_POST[dcuentas]);$x++){		 
			echo "<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor; this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\">
				<td style='width:20%'>
					<input name='dcuentas[]' value='".$_POST[dcuentas][$x]."' type='hidden'>".$_POST[dcuentas][$x]."
				</td>
				<td style='width:60%'>
					<input name='dncuentas[]' value='".$_POST[dncuentas][$x]."' type='hidden'>".$_POST[dncuentas][$x]."
				</td>
				<td style='width:10%'>
					<input name='drecursos[]' value='".$_POST[drecursos][$x]."' type='hidden'>".$_POST[drecursos][$x]."
				</td>
				<td align='right'>
					<input name='dvalores[]' value='".$_POST[dvalores][$x]."' type='hidden'>".number_format($_POST[dvalores][$x],2,',','.')."
				</td>
			</tr>";
		 	$_POST[totalc]=$_POST[totalc]+$_POST[dvalores][$x];
		 	$_POST[totalcf]=number_format($_POST[totalc],2,".",",");
		 	$aux=$iter;
			$iter=$iter2;
			$iter2=$aux;	
		}
		$resultado = convertir($_POST[totalc]);
		$_POST[letras]=$resultado." PESOS M/CTE";
	    echo "<tr class='titulos2'>
			<td colspan='2'></td>
			<td>Total</td>
			<td align='right'>
				<input name='totalcf' type='hidden' value='$_POST[totalcf]' readonly>
				<input name='totalc' type='hidden' value='$_POST[totalc]'>".number_format($_POST[totalc],2,',','.')."
			</td>
		</tr>
		<tr class='titulos2'>
			<td>Son:</td> 
			<td colspan='5'>
				<input name='letras' type='hidden' value='$_POST[letras]'>".$_POST[letras]."
			</td>
		</tr>";
		?>
	</table>
</div>
<?php
if($_POST[oculto]=='2')
{

	$consec=$_POST[idcomp];
	$linkbd=conectar_bd();
	$query="SELECT conta_pago FROM tesoparametros";
	$resultado=mysql_query($query,$linkbd);
	$arreglo=mysql_fetch_row($resultado);
	$opcion=$arreglo[0];
	if($_POST[estado]=='N')
	{
	$estado=0;
	}
	else
	{
	$estado=1;	
	}
	
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];

if($opcion=="1"){
$sqlr="delete from pptoretencionpago  where idrecibo=$_POST[idcomp]";
	mysql_query($sqlr,$linkbd);

for($x=0;$x<count($_POST[ddescuentos]);$x++)
		{				

			$valorp=$valorp-round($_POST[valor]*$_POST[dporcentajes][$x]/1000,2);
  	 		
			$sqlr="select * from tesoretenciones_det,tesoretenciones_det_presu where tesoretenciones_det.id=tesoretenciones_det_presu.id_retencion and tesoretenciones_det.codigo='".$_POST[ddescuentos][$x]."'";
			$resdes=mysql_query($sqlr);
			//echo $sqlr."<br>";
			$valordes=0;
			
			while($rowdes=mysql_fetch_assoc($resdes))
			{			

				
       			if($rowdes['tercero']==1)
				{
					$valordes=round(($_POST[ddesvalores][$x])*($rowdes['porcentaje']/100),0);
				
				}
				else
				{
					$valordes=round(($_POST[ddesvalores][$x])*($rowdes['porcentaje']/100),0);
		
				}

	   			if($rowdes['cuentapres']!="")
				{
					
					$sql="insert into pptoretencionpago(cuenta,idrecibo,valor,vigencia,tipo) values ('".$rowdes['cuentapres']."',$_POST[idcomp],$valordes,'$vigusu','orden')";

					mysql_query($sql,$linkbd); 	

				}
			}							  
		}
		echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado la CXP con Exito <img src='imagenes\confirm.png'></center></td></tr></table>";
}else{
	echo "<table class='inicio'><tr><td class='saludo1'><center>La causacion esta parametrizada para los egresos <img src='imagenes\error.png'></center></td></tr></table>";
}	
	 
		
 
		
	
//************CREACION DEL COMPROBANTE CONTABLE ************************
//***busca el consecutivo del comprobante contable
}//************ FIN DE IF OCULTO************
?>	
</form>
 </td></tr>  
</table>
</body>
</html>	 