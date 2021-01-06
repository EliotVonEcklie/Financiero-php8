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
<title>:: SPID - Presupuesto</title>

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
if(document.form2.codingreso.value!="" &&  document.form2.valor.value>0  )
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
ingresos2=document.getElementsByName('dcoding[]');
if (document.form2.fecha.value!='' && ingresos2.length>0)
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
document.form2.action="teso-pdfrecaudostrans.php";
document.form2.target="_BLANK";
document.form2.submit(); 
document.form2.action="";
document.form2.target="";
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
function buscaing(e)
 {
if (document.form2.codingreso.value!="")
{
 document.form2.bin.value='1';
 document.form2.submit();
 }
 }
</script>
<script language="JavaScript1.2">
function adelante()
{

//document.form2.oculto.value=2;
if(parseFloat(document.form2.ncomp.value)<parseFloat(document.form2.maximo.value))
 {
document.form2.oculto.value=1;
//document.form2.agregadet.value='';
//document.form2.elimina.value='';
document.form2.ncomp.value=parseFloat(document.form2.ncomp.value)+1;
document.form2.idcomp.value=parseFloat(document.form2.idcomp.value)+1;
document.form2.action="presu-recaudotransferencia-reflejar.php";
document.form2.submit();
}
else
{
	  // alert("Balance Descuadrado"+parseFloat(document.form2.maximo.value));
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
document.form2.action="presu-recaudotransferencia-reflejar.php";
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
document.form2.action="presu-recaudotransferencia-reflejar.php";
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
  <td colspan="3" class="cinta">
  <a class="mgbt" href="#" ><img src="imagenes/add2.png" alt="Nuevo"  border="0" /></a> 
  <a class="mgbt" href="#" onClick="#"><img src="imagenes/guardad.png"  alt="Guardar" /></a> 
  <a class="mgbt" href="presu-buscarecaudotransferencia-reflejar.php"> <img src="imagenes/busca.png"  alt="Buscar" /></a> 
  <a class="mgbt" href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" alt="nueva ventana"></a> 
  <a class="mgbt" href="#" onClick="guardar()"><img src="imagenes/reflejar1.png"  alt="Reflejar" style="width:24px;" /></a> 
  <a class="mgbt" href="#"onClick="pdf()"> <img src="imagenes/print.png"  alt="Buscar" /></a> 
  <a class="mgbt" href="presu-reflejardocs.php"><img src="imagenes/iratras.png" alt="nueva ventana"></a></td>
</tr>		  
</table>
<tr>
<td colspan="3" class="tablaprin" align="center"> 
<?php
$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
$vigencia=$vigusu;
//$_POST[vigencia]=$vigencia;
$linkbd=conectar_bd();
 //*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
if($_GET[idr]!=""){echo "<script>document.getElementById('codrec').value=$_GET[idr];</script>";}
if(!$_POST[oculto]){
	$sqlr="select max(id_recaudo) from tesorecaudotransferencia ORDER BY tesorecaudotransferencia.ID_recaudo DESC";
	$res=mysql_query($sqlr,$linkbd);
	$r=mysql_fetch_row($res);
	$_POST[maximo]=$r[0];

	if ($_POST[codrec]!="" || $_GET[idr]!=""){
		if($_POST[codrec]!=""){
			$sqlr="select * from tesorecaudotransferencia where id_recaudo='$_POST[codrec]'";
		}
		else{
			$sqlr="select * from tesorecaudotransferencia where id_recaudo='$_GET[idr]'";
		}
	}
	else{
		$sqlr="select max(id_recaudo) from tesorecaudotransferencia ORDER BY tesorecaudotransferencia.ID_recaudo DESC";
	}
	$res=mysql_query($sqlr,$linkbd);
	$r=mysql_fetch_row($res);
	$_POST[ncomp]=$r[0];
	$_POST[idcomp]=$_POST[ncomp];
	$check1="checked";
//	$fec=date("d/m/Y");
	$_POST[vigencia]=$vigencia;
}

//$linkbd=conectar_bd();
	$_POST[dcoding]= array(); 		 
	$_POST[dncoding]= array(); 		 
	$_POST[dvalores]= array(); 
	$sqlr="select distinct *from tesorecaudotransferencia, tesorecaudotransferencia_det   where	  tesorecaudotransferencia.id_recaudo=$_POST[ncomp]  AND tesorecaudotransferencia.ID_recaudo=tesorecaudotransferencia_det.ID_recaudo and tesorecaudotransferencia_det.id_recaudo=$_POST[ncomp]";	
	$res=mysql_query($sqlr,$linkbd);
	$cont=0;
//	echo $sqlr;
	//$_POST[idcomp]=$_GET[idrecaudo];	
	$total=0;
	while ($row =mysql_fetch_row($res)){	
		$p1=substr($row[2],0,4);
		$p2=substr($row[2],5,2);
		$p3=substr($row[2],8,2);
		$_POST[fecha]=$p3."/".$p2."/".$p1;	
		$_POST[cc]=$row[8];
		$_POST[dcoding][$cont]=$row[15];			 
		$_POST[banco]=$row[18];		 
		$_POST[dnbanco]=buscatercero($row[4]);		 
		$_POST[dncoding][$cont]=buscaingreso($row[15]);
		$_POST[tercero]=$row[7];
		$_POST[ntercero]=buscatercero($row[7]);
		$_POST[concepto]=$row[6];
		$total=$total+$row[17]; 
		$_POST[totalc]=$total;
		$_POST[vigencia]=$row[3];
		
		$_POST[dvalores][$cont]=$row[16];
 		if($row[10]=='N'){
			$_POST[estado]="ANULADO";
		   	$_POST[estadoc]='0';
		}
		else{
			$_POST[estadoc]='1';
			$_POST[estado]="ACTIVO";
		}
		$cont=$cont+1;		
	}		

	$sqlr="select distinct *from tesorecaudotransferencia, tesorecaudotransferencia_det ,tesobancosctas   where	 tesobancosctas.ncuentaban= tesorecaudotransferencia.ncuentaban  and tesorecaudotransferencia.id_recaudo=$_POST[ncomp]  AND tesorecaudotransferencia.ID_recaudo=tesorecaudotransferencia_det.ID_recaudo and tesorecaudotransferencia_det.id_recaudo=$_POST[ncomp]";	
	$res=mysql_query($sqlr,$linkbd);
	//$cont=0;
//	echo $sqlr;
	//$_POST[idcomp]=$_GET[idrecaudo];	
	//$total=0;
	while ($row =mysql_fetch_row($res)) {	
		/*$p1=substr($row[2],0,4);
		$p2=substr($row[2],5,2);
		$p3=substr($row[2],8,2);
		$_POST[fecha]=$p3."/".$p2."/".$p1;	
		$_POST[cc]=$row[8];
		$_POST[dcoding][$cont]=$row[13];			 */
		$_POST[banco]=$row[18];		 
		$_POST[dnbanco]=buscatercero($row[4]);		 
/*		$_POST[dncoding][$cont]=buscaingreso($row[13]);
		$_POST[tercero]=$row[7];
		$_POST[ntercero]=buscatercero($row[7]);
		$_POST[concepto]=$row[6];
		$total=$total+$row[15]; 
		$_POST[totalc]=$total;
		$_POST[dvalores][$cont]=$row[14];
		$cont=$cont+1;		*/
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
 	//***** busca tercero
	if($_POST[bt]=='1'){
  		$nresul=buscatercero($_POST[tercero]);
		if($nresul!=''){
			$_POST[ntercero]=$nresul;
		}
		else{
			$_POST[ntercero]="";
		}
	}
//******** busca ingreso *****
//***** busca tercero
			 if($_POST[bin]=='1')
			 {
			  $nresul=buscaingreso($_POST[codingreso]);
			  if($nresul!='')
			   {
			  $_POST[ningreso]=$nresul;
  	
			  }
			 else
			 {
			  $_POST[ningreso]="";
			  }
			 }
			 
 ?>
 	<table class="inicio" align="center" >
    	<tr >
        	<td class="titulos" colspan="6"> Recaudos Transferencias</td>
        	<td style="width:7%" class="cerrar"><a href="teso-principal.php">Cerrar</a></td>
      	</tr>
      	<tr>
        	<td style="width:2.5cm" class="saludo1">Numero Recaudo:</td>
        	<td style="width:10%" >
            	<input type="hidden" value="1" name="oculto">
                <a href="#" onClick="atrasc()"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a>
                <input name="idcomp" type="text" size="5" value="<?php echo $_POST[idcomp]?>" onKeyUp="return tabular(event,this)" onBlur="validar2()"  >
                <input name="ncomp" type="hidden" value="<?php echo $_POST[ncomp]?>">
                <a href="#" onClick="adelante()"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> 
                <input type="hidden" value="a" name="atras" ><input type="hidden" value="s" name="siguiente" >
                <input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo">
                <input type="hidden" value="<?php echo $_POST[codrec]?>" name="codrec" id="codrec">
           	</td>
        	<td style="width:2.5cm" class="saludo1">Fecha:</td>
        	<td style="width:10%">
            	<input name="fecha" type="text" title="DD/MM/YYYY" style="width:100%" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " readonly> 
         	</td>
        	<td style="width:2.5cm" class="saludo1" >Vigencia:</td>
        	<td style="width:20%">
            	<input type="text" id="vigencia" name="vigencia" style="width:40%" onKeyUp="return tabular(event,this)"  value="<?php echo $_POST[vigencia]?>" onClick="document.getElementById('tipocta').focus();document.getElementById('tipocta').select();" readonly>       
          		<input type="text" name="estado" value="<?php echo $_POST[estado] ?>" style="width:40%" readonly>  
                <input type="hidden" name="estadoc" value="<?php echo $_POST[estadoc] ?>">         
          	</td>
        </tr>
        <tr>
        	<td style="width:2.5cm" class="saludo1">Recaudado:</td>
         	<td colspan="5"> 
         		<select id="banco" name="banco"  onChange="validar()" onKeyUp="return tabular(event,this)">
		  			<?php
					$linkbd=conectar_bd();
					$sqlr="select tesobancosctas.estado,tesobancosctas.cuenta,tesobancosctas.ncuentaban,tesobancosctas.tipo,terceros.razonsocial,tesobancosctas.tercero from tesobancosctas,terceros where tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.estado='S' order by tesobancosctas.cuenta";
					$res=mysql_query($sqlr,$linkbd);
					while($row =mysql_fetch_row($res)){
					 	if($row[1]==$_POST[banco]){
						 	$ncb=buscacuenta($row[1]);
							echo "<option value=$row[1] SELECTED>".$row[1]."-".substr($ncb,0,70)." - Cuenta ".$row[3]." - ".$row[4]."</option>";
						 	$_POST[nbanco]=$row[4];
						  	$_POST[ter]=$row[5];
						 	$_POST[cb]=$row[2];
						}
					}	 	
					?>
            	</select>
       			<input name="cb" type="hidden" value="<?php echo $_POST[cb]?>" ><input type="hidden" id="ter" name="ter" value="<?php echo $_POST[ter]?>" >           
            	<input type="hidden" id="nbanco" name="nbanco" value="<?php echo $_POST[nbanco]?>">
           	</td>
        </tr>
      	<tr>
        	<td style="width:2.5cm" class="saludo1">Concepto Recaudo:</td>
        	<td colspan="5" >
            	<input name="concepto" type="text" value="<?php echo $_POST[concepto]?>" style="width:100%" onKeyUp="return tabular(event,this)" readonly>
           	</td>
       	</tr>  
      	<tr>
	        <td style="width:2.5cm" class="saludo1">NIT: </td>
    	    <td >
        		<input name="tercero" type="text" value="<?php echo $_POST[tercero]?>" style="width:100%" onKeyUp="return tabular(event,this)" readonly>
	       	</td>
    	    <td class="saludo1" >Contribuyente:</td>
        	<td colspan="3">
        		<input type="text" id="ntercero" name="ntercero" value="<?php echo $_POST[ntercero]?>" style="width:100%" onKeyUp="return tabular(event,this) "  readonly>
	            <input type="hidden" value="0" name="bt">
    	        <input type="hidden" id="cb" name="cb" value="<?php echo $_POST[cb]?>" >
        	    <input type="hidden" id="ct" name="ct" value="<?php echo $_POST[ct]?>" >        
	      	</td>
   		</tr>
	</table>
    <?php
           //***** busca tercero
			 if($_POST[bt]=='1')
			 {
			  $nresul=buscatercero($_POST[tercero]);
			  if($nresul!='')
			   {
			  $_POST[ntercero]=$nresul;
  				?>
<script>
			  document.getElementById('codingreso').focus();document.getElementById('codingreso').select();</script>
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
			 //*** ingreso
			 if($_POST[bin]=='1')
			 {
			  $nresul=buscaingreso($_POST[codingreso]);
			  if($nresul!='')
			   {
			  $_POST[ningreso]=$nresul;
  			  ?>
			  <script>
			  document.getElementById('valor').focus();document.getElementById('valor').select();</script>
			  <?php
			  }
			 else
			 {
			  $_POST[codingreso]="";
			  ?>
			  <script>alert("Codigo Ingresos Incorrecto");document.form2.codingreso.focus();</script>
			  <?php
			  }
			 }
			 ?>
      
	<div class="subpantalla">
		<table class="inicio">
	   		<tr>
   	      		<td colspan="3" class="titulos">Detalle  Recaudos Transferencia</td></tr>                  
			<tr>
            	<td class="titulos2">Codigo</td>
                <td class="titulos2">Ingreso</td>
                <td class="titulos2">Valor</td>
			</tr>
			<?php
		  	$_POST[totalc]=0;
			$iter='saludo1a';
			$iter2='saludo2';
		 	for ($x=0;$x<count($_POST[dcoding]);$x++){		 
				echo "<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor; this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\">
					<td style='width:10%' align='center'>
						<input name='dcoding[]' value='".$_POST[dcoding][$x]."' type='hidden'>".$_POST[dcoding][$x]."
					</td>
					<td style='width:70%'>
						<input name='dncoding[]' value='".$_POST[dncoding][$x]."' type='hidden'>".$_POST[dncoding][$x]."
					</td>
					<td align='right'>
						<input name='dvalores[]' value='".$_POST[dvalores][$x]."' type='hidden'>".number_format($_POST[dvalores][$x],2,',','.')."
					</td>
				</tr>";
		 		$_POST[totalc]=$_POST[totalc]+$_POST[dvalores][$x];
		 		$_POST[totalcf]=number_format($_POST[totalc],2);
				$aux=$iter;
				$iter=$iter2;
				$iter2=$aux;
		 	}
 			$resultado = convertir($_POST[totalc]);
			$_POST[letras]=$resultado." Pesos";
		 echo "<tr class='titulos2'>
		 	<td></td>
			<td>Total</td>
			<td align='right'>
				<input name='totalcf' type='hidden' value='$_POST[totalcf]'>
				<input name='totalc' type='hidden' value='$_POST[totalc]'>".number_format($_POST[totalc],2,',','.')."
				</td>
			</tr>
			<tr>
				<td class='saludo1'>Son:</td>
				<td colspan='5'>
					<input name='letras' type='hidden' value='$_POST[letras]'>".$_POST[letras]."
				</td>
			</tr>";
		?> 
	   </table></div>
	  <?php
if($_POST[oculto]=='2')
{
	$linkbd=conectar_bd();
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	//*********************CREACION DEL COMPROBANTE CONTABLE ***************************
	$sqlr="DELETE from pptocomprobante_cab where numerotipo='$_POST[idcomp]' and tipo_comp='19'";
	mysql_query($sqlr,$linkbd);
	//***busca el consecutivo del comprobante contable
	$consec=$_POST[idcomp];	
	//***cabecera comprobante
	$sqlr="INSERT into pptocomprobante_cab (numerotipo,tipo_comp,fecha,concepto,vigencia,total_debito,total_credito,diferencia,estado) values ($consec,19,'$fechaf','".strtoupper($_POST[concepto])."',$_POST[vigencia],0,0,0,'$_POST[estadoc]')";
	//echo $sqlr;
	if(mysql_query($sqlr,$linkbd))	
	{
		$idcomp=mysql_insert_id();
		$sqlr="DELETE from pptocomprobante_det where  numerotipo='$_POST[idcomp]' and tipo_comp='19'";
		mysql_query($sqlr,$linkbd);
		$sqlr="DELETE from pptoingtranppto where idrecibo=$consec";
		mysql_query($sqlr,$linkbd);	
		//******************* DETALLE DEL COMPROBANTE CONTABLE *********************
		for($x=0;$x<count($_POST[dcoding]);$x++)
		{
			//***** BUSQUEDA INGRESO ********
			$sqlri="SELECT * from tesoingresos_det where codigo='".$_POST[dcoding][$x]."' and vigencia=$vigusu";
			$resi=mysql_query($sqlri,$linkbd);
			//echo "$sqlri <br>";	    
			while($rowi=mysql_fetch_row($resi))
			{
				//**** busqueda concepto contable*****
				if($rowi[6]!="")
				{
					$porce=$rowi[5];
					$vi=$_POST[dvalores][$x]*($porce/100);
					$valordeb=0;
				 	$sqlr="INSERT into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values('".$rowi[6]."','".$_POST[tercero]."','RECAUDO TRANSFERENCIA',".$vi.",0,1,'$vigusu',19,'$consec',1,'','','$fechaf')";
					mysql_query($sqlr,$linkbd);
					// echo "<br>".$sqlr;
					$sqlr="UPDATE pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' AND VIGENCIA='$vigusu'";
					//mysql_query($sqlr,$linkbd);	
					 //****creacion documento presupuesto ingresos
					$sqlr="INSERT into pptoingtranppto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$consec,$vi,'".$_POST[vigencia]."')";
					 mysql_query($sqlr,$linkbd);				  
					//echo "Conc: $sqlr <br>";
				}
			}
		}
		echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado el Recaudo con Exito <img src='imagenes/confirm.png'><script></script></center></td></tr></table>";
	}
	else{
		echo "<table class='inicio'><tr><td class='saludo1'><center>No Se ha almacenado el Recaudo con Exito <img src='imagenes/alert.png'><script></script></center></td></tr></table>";
	}
}
?>	
</form>
 </td></tr>
</table>
</body>
</html> 		