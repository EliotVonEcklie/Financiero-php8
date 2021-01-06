<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
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
		<title>:: SPID - Presupuesto</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
<script>
function buscarp(e)
 {
if (document.form2.rp.value!="")
{
 document.form2.brp.value='1';
 document.form2.submit();
 }
 }
//************* genera reporte ************
//***************************************
function genrep(idfac)
{
  document.form2.oculto.value=idfac;
  document.form2.submit();
  }
//************* genera reporte ************
//***************************************
function guardar()
{

if (document.form2.vigencia.value!='' && document.form2.fecha.value!='' )
  {
	if (confirm("Esta Seguro de Guardar"))
  	{
  	document.form2.oculto.value=2;
  	document.form2.submit();
	//document.form2.action="pdfcdp.php";
  	}
  }
  else{
  alert('Faltan datos para completar el registro');
  	document.form2.fecha.focus();
  	document.form2.fecha.select();
  }
}
function validar(formulario)
{
document.form2.oculto.value=1;	
document.form2.action="presu-liberarsaldos.php";
document.form2.submit();
}
function validar2(formulario)
{
document.form2.chacuerdo.value=2;
document.form2.action="presu-liberarsaldos.php";
document.form2.submit();
}
function buscacta(e)
 {
if (document.form2.cuenta.value!="")
{
 document.form2.bc.value=2;
 document.form2.submit();
 }
 }
function agregardetalle()
{
if(document.form2.cuenta.value!="" &&  document.form2.fuente.value!="" && document.form2.valor.value>=0 )
{ 
				document.form2.agregadet.value=1;
	//			document.form2.chacuerdo.value=2;
				document.form2.submit();
 }
 else {
 alert("Falta informacion para poder Agregar");
 }
}
function eliminar(variable)
{
if (confirm("Esta Seguro de Eliminar"))
  {
  document.form2.chacuerdo.value=2;
document.form2.elimina.value=variable;
//eli=document.getElementById(elimina);
vvend=document.getElementById('elimina');
//eli.value=elimina;
vvend.value=variable;
document.form2.submit();
}
}
function pdf()
{
document.form2.action="pdfrprecom.php";
document.form2.target="_BLANK";
document.form2.submit(); 
document.form2.action="";
document.form2.target="";
}
function finaliza()
 {
  if (confirm("Confirme Guardando el Documento, al completar el Proceso"))
  {
	  document.form2.fin.value=1;
	  document.form2.fin.checked=true; 
  } 
  else
  	  document.form2.fin.value=0;
  document.form2.fin.checked=false; 
 }
function buscater(e)
 {
if (document.form2.tercero.value!="")
{
 document.form2.bt.value='1';
 document.form2.submit();
 }
 }
function resumar() 
{ 
 cali=document.getElementsByName('dcuentas[]');
 valrubro=document.getElementsByName('dgastos[]');
 sumar=0;
// document.form2.todos.checked=chkbox.checked;
for (var i=0;i < cali.length;i++) 
{ 
//		 alert('si'+i+' '+cali.item(i).value);
//	cali.item(i).checked = true;
	sumar=parseFloat(sumar)+parseFloat(valrubro.item(i).value);	
//		alert("cabio"+habdesv.item(i).value);
//		alert("cabio"+habdesv.item(i).value);
} 
document.form2.cuentagas2.value=sumar;
document.form2.valorrp.value=sumar;
document.form2.cuentagas.value=sumar;
document.form2.oculto.value=0;
//document.form2.submit();	
} 
</script>
		<?php titlepag();?>
    </head>
    <body >
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("presu");?></tr>
        	<tr>
          		<td colspan="3" class="cinta"><a href="presu-liberarsaldos.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a><a href="#"  onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar"/></a><a href="presu-buscarp.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a><a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a><a href="#" <?php if($_POST[oculto]==2) { ?> onClick="pdf()" <?php } ?> class="mgbt"><img src="imagenes/print.png" title="Imprimir"></a></td>
        	</tr>
   		</table>
<?php
$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
$vigencia=$vigusu;
$linkbd=conectar_bd();
if(!$_POST[oculto])
{
		 $_POST[vigencia]=$vigencia; 	
 		 $fec=date("d/m/Y");
		 $_POST[fecha]=$fec; 	
		 $_POST[valor]=0; 	
		  $_POST[valorrp]=0; 			 
		 $_POST[cuentaing]=0;
		 $_POST[cuentagas]=0;
 		 $_POST[cuentaing2]=0;
		 $_POST[cuentagas2]=0;
		 	$link=conectar_bd();
	$sqlr="select max(id_lib) from pptoliberarsaldos_cab  ";
	$res=mysql_query($sqlr,$link);
//echo $sqlr;
	while($r=mysql_fetch_row($res))
	{
	 $maximo=$r[0];
	}
	if(!$maximo)
	  {
	  $_POST[idcomp]=1;
	  }else{
  	$_POST[idcomp]=$maximo+1;
 		 }
}
 			 //***** busca tercero
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
 
			//**** busca cuenta
			if($_POST[bc]!='')
			 {
			  $nresul=buscacuentapres($_POST[cuenta],2);			
			  if($nresul!='')
			   {
			  $_POST[ncuenta]=$nresul;
			  $linkbd=conectar_bd();
			  //$ind=substr($_POST[cuenta],0,1);
			  $ind=substr($_POST[cuenta],0,1);			
			  	if($ind=='R' || $ind=='r')
					 {						
					$ind=substr($_POST[cuenta],1,1);						  
					 }
			  if ($ind=='2')
			  $sqlr="select pptocuentas.futfuentefunc,pptocuentaspptoinicial.saldoscdprp,pptofutfuentefunc.nombre from pptocuentas,pptocuentaspptoinicial,pptofutfuentefunc where pptocuentas.cuenta='$_POST[cuenta]' and pptocuentas.cuenta=pptocuentaspptoinicial.cuenta and pptocuentas.futfuentefunc=pptofutfuentefunc.codigo";
			  if ($ind=='3' || $ind=='4')
			  $sqlr="select pptocuentas.futfuenteinv,pptocuentaspptoinicial.saldoscdprp,pptofutfuenteinv.nombre from pptocuentas,pptocuentaspptoinicial,pptofutfuenteinv where pptocuentas.cuenta='$_POST[cuenta]' and pptocuentas.cuenta=pptocuentaspptoinicial.cuenta and pptofutfuenteinv.codigo=pptocuentas.futfuenteinv";
//			  echo $sqlr;
			  $res=mysql_query($sqlr,$linkbd);
			  $row=mysql_fetch_row($res);
			    if($row[1]!='' || $row[1]!=0)
			     {
				  $_POST[cfuente]=$row[0];
				  $_POST[fuente]=$row[2];
				  $_POST[valor]=$row[1];			  
				  $_POST[saldo]=$row[1];			  
				 }
				 else
				  {
				   $_POST[cfuente]="";
	  			   $_POST[fuente]="";
				   $_POST[valor]="";			  
				   $_POST[saldo]="";
				   $_POST[cuenta]="";			  
				   $_POST[ncuenta]="";			  
				  }  
			   }
			  else
			  {
			   $_POST[ncuenta]="";	
			   }
			 }
			 
		if ($_POST[chacuerdo]=='2')
					 {
				    $_POST[dcuentas]=array();
				    $_POST[dncuetas]=array();
				    $_POST[dingresos]=array();
				    $_POST[dgastos]=array();
					$_POST[diferencia]=0;
					$_POST[cuentagas]=0;
					$_POST[cuentaing]=0;																			
					 }	 
		?>

 <form name="form2" method="post" action="">
 <?php
 if($_POST[brp]=='1')
			 {
			  $nresul=buscaregistro($_POST[rp],$_POST[vigencia]);
			  if($nresul!='')
			   {
			  $_POST[cdp]=$nresul;
			  //*** busca detalle cdp
			  $linkbd=conectar_bd();
  				$sqlr="select pptorp.vigencia,pptorp.consvigencia,pptocdp.objeto,pptorp.estado,pptocdp.consvigencia,pptorp.valor,pptorp.saldo,pptorp.tercero, pptocdp.objeto from pptorp,pptocdp where pptorp.estado='S' and pptocdp.consvigencia=$_POST[cdp] and pptorp.idcdp=pptocdp.consvigencia and pptorp.consvigencia=".$_POST[rp]." and pptorp.vigencia=$_POST[vigencia] order by pptorp.vigencia,pptorp.consvigencia,pptocdp.objeto,pptorp.estado";
				//echo $sqlr;
				$resp = mysql_query($sqlr,$linkbd);
				$row =mysql_fetch_row($resp);
				$_POST[detallecdp]=$row[2];
				$_POST[tercero]=$row[7];
				$_POST[ntercero]=buscatercero($_POST[tercero]);
				$_POST[regimen]=buscaregimen($_POST[tercero]);			
				$_POST[valorrp]=$row[5];
				$_POST[saldorp]=$row[6];
				$_POST[valor]=$row[6];
				if($_POST[regimen]==1)
				 $_POST[iva]=round($_POST[valor]-$_POST[valor]/(1.16),1);	
				 else
				 $_POST[iva]=0;			
				 $_POST[base]=$_POST[valor]-$_POST[iva];				 
				$_POST[detallegreso]=$row[8];
				$_POST[valoregreso]=$_POST[valor];
				$_POST[valorretencion]=$_POST[totaldes];
				$_POST[valorcheque]=$_POST[valoregreso]-$_POST[valorretencion];
				$_POST[valorcheque]=number_format($_POST[valorcheque],2);				
			  }
			 else
			 {
			  $_POST[cdp]="";
			  $_POST[detallecdp]="";
			  $_POST[tercero]="";
			  $_POST[ntercero]="";
			  }
			 }
 //***** busca tercero
			 if($_POST[bt]=='1')
			 {
			  $nresul=buscatercero($_POST[tercero]);
			  $_POST[regimen]=buscaregimen($_POST[tercero]);	
			  if($nresul!='')
			   {
			  $_POST[ntercero]=$nresul;
  				if($_POST[regimen]==1)
				 $_POST[iva]=round($_POST[valor]-$_POST[valor]/(1.16),1);	
				 else
				 $_POST[iva]=0;	
				 $_POST[base]=$_POST[valor]-$_POST[iva];				 
			  }
			 else
			 {
			  $_POST[ntercero]="";
			  }
			 }
 
 ?>
    <table class="inicio" align="center"  >
    <tr >
        <td class="titulos" colspan="8">.: Liberacion Saldo Presupuestal </td>
        <td  class="cerrar" ><a href="presu-principal.php">Cerrar</a></td>
      </tr>
    <tr >
		<td  class="saludo1" >Numero Liberacion Saldo:</td>
        <td ><input name="idcomp" type="text" size="5" value="<?php echo $_POST[idcomp]?>" readonly></td>

	    <td class="saludo1">Fecha: </td>
        <td ><input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10" size="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY">   <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>  
        </td>
	    <td  class="saludo1">Vigencia: </td>
        <td  ><input name="vigencia" type="text" value="<?php echo $_POST[vigencia]?>" maxlength="2" size="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly> </td>
        <td class="saludo1">Tipo Liberacion:</td>
        <td>
        <select name="tipolib" id="tipolib" onKeyUp="return tabular(event,this)" >
         <option value="" <?php if($_POST[tipolib]=='') echo "SELECTED"; ?>>Seleccione tipo liberacion</option>
         <option value="cdp" <?php if($_POST[tipolib]=='cdp') echo "SELECTED"; ?>>Liberar Saldo solo CDP</option>
          <option value="rp" <?php if($_POST[tipolib]=='rp') echo "SELECTED"; ?>>Liberar Saldo RP y CDP</option>
        </select>        
        </td>
      </tr>
        <tr>
        <td  class="saludo1">Registro:
        </td>
        <td><input name="rp" type="text" value="<?php echo $_POST[rp]?>" size="10" onKeyUp="return tabular(event,this)" onBlur="buscarp(event)" ><input type="hidden" value="0" name="brp">
            <a href="#" onClick="mypop=window.open('registro-ventana.php?vigencia=<?php echo $_POST[vigencia]?>','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=900,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>        </td>
	  <td class="saludo1">CDP:</td>
	  <td>
<input type="text" id="cdp" name="cdp" value="<?php echo $_POST[cdp]?>" size="10" readonly></td>
	  <td class="saludo1">Detalle RP:</td>
	  <td colspan="3">
<input type="text" id="detallecdp" name="detallecdp" value="<?php echo $_POST[detallecdp]?>" size="80" readonly> <input type="hidden" value="1" name="oculto"></td>
	  </tr>      
	  <tr><td class="saludo1">Concepto Liberacion</td><td colspan="7"><input type="text" id="detalle" name="detalle" value="<?php echo $_POST[detalle]?>" size="150" ></td></tr> 
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
			  document.getElementById('solicita').focus();document.getElementById('solicita').select();</script>
			  <?php
			  }
			 else
			 {
			  $_POST[ntercero]="";
			  ?>
			  <script>
				 alert("Cuenta Incorrecta");document.form2.tercero.select();
		  		document.form2.tercero.focus();	
			  </script>
			  <?php
			  }
			 }
			?>
            <div class="subpantallac" style="height:60%; width:99.6%; overflow-x:hidden;">
		<table class="inicio" >
        <tr>
          <td class="titulos" colspan="6">Detalle RP</td>
        </tr>
		<tr>
		<td class="titulos2">Cuenta</td><td class="titulos2">Nombre Cuenta</td><td class="titulos2">Valor CDP</td><td class="titulos2">Saldo CDP</td><td class="titulos2">Valor RP</td><td class="titulos2">Saldo Liberar</td></tr>
		  <?php
		  if ($_POST[oculto]==1)
		   {
		  	 $_POST[dcuentas]=array();
		  	 $_POST[dncuentas]=array();
		  	 $_POST[dgastos]=array();
			 $_POST[dsgastos]=array();
		  	 $_POST[dfuentes]=array();
			  $_POST[dcdpvalor]=array();
		  	 $_POST[dcdpsaldo]=array();			 			 			 			 			 
		   $link=conectar_bd();
  		   $sqlr="Select * from pptorp_detalle  where estado='S' and vigencia=$vigusu and consvigencia=$_POST[rp]  order by consvigencia";
//			 echo $sqlr;
		 		$resp = mysql_query($sqlr,$link);
				while ($row =mysql_fetch_row($resp)) 
				{
				$sqlr="Select * from pptocdp_detalle  where estado='S' and vigencia=$vigusu and consvigencia=$_POST[cdp] and  cuenta='".$row[3]."'";
				$resp2 = mysql_query($sqlr,$link);
				$cdpvalor=$row2[5];
				$cdpvalor=$row2[5];
				$cdpvalor=0;
				while ($row2 =mysql_fetch_row($resp2)) 
				{
				$_POST[dcdpvalor][]=$row2[5];	
				$cdpvalor=$row2[5];
				//$_POST[dcdpsaldo][]=$row2[7];					
				}
				
				 //*** CXP 
	 			//***********cuentas x pagar resta a saldo rp
				$_POST[dcdpsaldo][]=$cdpvalor-$row[5];	
				 $_POST[dcuentas][]=$row[3];
 	 		     $nresul=buscacuentapres($row[3],2);			
				 $_POST[dncuentas][]=$nresul;				 
				 $_POST[dgastos][]=$row[5];
				 //$_POST[dsgastos][]=$row[5]-($valorcxp+$valornom);
				 $_POST[dsgastos][]=$row[7];
//				  $ind=substr($row[3],0,1);
	$ind=substr($_POST[cuenta],0,1);			
			  	if($ind=='R' || $ind=='r')
					 {						
					$ind=substr($_POST[cuenta],1,1);						  
					 }
				  if ($ind=='2')
				  $sqlr="select pptocuentas.futfuentefunc,pptocuentaspptoinicial.saldoscdprp,pptofutfuentefunc.nombre from pptocuentas,pptocuentaspptoinicial,pptofutfuentefunc where pptocuentas.cuenta='$row[3]' and pptocuentas.cuenta=pptocuentaspptoinicial.cuenta and pptocuentas.futfuentefunc=pptofutfuentefunc.codigo";
				  if ($ind=='3' || $ind=='4')
				  $sqlr="select pptocuentas.futfuenteinv,pptocuentaspptoinicial.saldoscdprp,pptofutfuenteinv.nombre from pptocuentas,pptocuentaspptoinicial,pptofutfuenteinv where pptocuentas.cuenta='$row[3]' and pptocuentas.cuenta=pptocuentaspptoinicial.cuenta and pptofutfuenteinv.codigo=pptocuentas.futfuenteinv";			  
				  $res2=mysql_query($sqlr,$linkbd);
				  $row2=mysql_fetch_row($res2);
				    if($row2[1]!='' || $row2[1]!=0)
				     {
					  $_POST[dcfuentes][]=$row2[0];
					  $_POST[dfuentes][]=$row2[2];
					 }
		  		}
		     }
			 $cdp=0;
			 $scdp=0;
		 for ($x=0;$x< count($_POST[dcuentas]);$x++)
		 {
		 echo "<tr><td class='saludo2'><input name='dcuentas[]' value='".$_POST[dcuentas][$x]."' type='text' size='20' readonly></td><td class='saludo2'><input name='dncuentas[]' value='".$_POST[dncuentas][$x]."' type='text' size='80' readonly></td><td class='saludo2'><input name='dcdpvalor[]' value='".$_POST[dcdpvalor][$x]."' type='text' size='15' readonly></td><td class='saludo2'><input name='dcdpsaldo[]' value='".$_POST[dcdpsaldo][$x]."' type='text' size='15' ></td><td class='saludo2'><input name='dgastos[]' value='".$_POST[dgastos][$x]."' type='text' size='15' readonly></td><td class='saludo2'><input name='dsgastos[]' value='".$_POST[dsgastos][$x]."' type='text' size='15' ></td></tr>";
//		 $cred= $vc[$x]*1;
		 $gas=$_POST[dgastos][$x];
		 $sgas=$_POST[dsgastos][$x];
		 $cdp+=$_POST[dcdpvalor][$x];
		 $scdp+=$_POST[dcdpsaldo][$x];
//		 $cred=number_format($cred,2,".","");
	//	 $deb=number_format($deb,2,".","");

		 $gas=$gas;
		 $cuentagas=$cuentagas+$gas;
 		 $cuentasgas=$cuentasgas+$sgas;
		 $_POST[cuentacdp]=number_format($cdp,2,".",",");
		 $_POST[cuentascdp]=number_format($scdp,2,".",",");
		 $_POST[cuentagas2]=$cuentagas;
		 $_POST[cuentasgas2]=$cuentasgas;		 
		 $total=number_format($total,2,",","");
 		 $_POST[cuentagas]=number_format($cuentagas,2,".",",");
  		 $_POST[cuentasgas]=number_format($cuentasgas,2,".",",");
			$resultado = convertir($_POST[cuentagas2]);
			$_POST[letras]=$resultado." PESOS";
		 }
		 echo "<tr><td ></td><td ></td><td class='saludo1'><input id='cuentacdp' name='cuentacdp' value='$_POST[cuentacdp]' readonly><input id='cuentacdp2' name='cuentacdp2' value='$_POST[cuentacdp2]' type='hidden'></td><td class='saludo1'><input id='cuentascdp' name='cuentascdp' value='$_POST[cuentascdp]' readonly><input id='cuentascdp2' name='cuentascdp2' value='$_POST[cuentascdp2]' type='hidden'></td><td class='saludo1'><input id='cuentagas' name='cuentagas' value='$_POST[cuentagas]' readonly><input id='cuentagas2' name='cuentagas2' value='$_POST[cuentagas2]' type='hidden'></td><td class='saludo1'><input id='cuentasgas' name='cuentasgas' value='$_POST[cuentasgas]' readonly><input id='cuentasgas2' name='cuentasgas2' value='$_POST[cuentasgas2]' type='hidden'></td></tr>";
		 echo "<tr><td class='saludo1'>Son:</td><td class='saludo1' colspan= '4'><input id='letras' name='letras' value='$_POST[letras]' type='text' size='80'></td></tr>";
		?>
		</table>
        </div>
    </form>
  <?php
  //***************PARTE PARA INSERTAR Y ACTUALIZAR LA INFORMACION CDP y REGISTRO PRESUPUESTAL
$oculto=$_POST['oculto'];
if($_POST[oculto]=='2')
{
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	$linkbd=conectar_bd();
	$sqlr="insert into pptoliberarsaldos_cab  (id_rp, id_cdp, vigencia, fecha, detallelib, estado) values($_POST[rp],$_POST[cdp],'$vigusu','$fechaf','$_POST[detalle]','S' )";
	//echo $sqlr;
	if(!mysql_query($sqlr,$linkbd))
	   {
	   echo "<table class='inicio'><tr><td class='saludo1'><center>No Se ha Actualizado con Exito <img src='imagenes/alert.png'></center></td></tr></table>";	
	   }
	   else
	    {
		$idlib=mysql_insert_id();
		
		if($_POST[tipolib]=='rp')
		{
		 for ($x=0;$x< count($_POST[dcuentas]);$x++)
		 {
		    $sqlr="insert into pptoliberarsaldos_det  (id_lib, cuenta, vigencia, valcdp, saldocdp, valrp, saldorp) values($idlib,'".$_POST[dcuentas][$x]."','$vigusu',".$_POST[dcdpvalor][$x].", ".$_POST[dcdpsaldo][$x].", ".$_POST[dgastos][$x].", ".$_POST[dsgastos][$x]." )";
			mysql_query($sqlr,$linkbd);
			$sqlr="update pptorp_detalle set saldo=saldo-".$_POST[dsgastos][$x].", saldo_liberado+=".$_POST[dsgastos][$x]." where consvigencia=$_POST[rp] and vigencia=$vigusu  and cuenta='".$_POST[dcuentas][$x]."'";
			mysql_query($sqlr,$linkbd);
			//echo "<br>".$sqlr;
			$sqlr="update pptocdp_detalle set saldo=0, saldo_liberado+=".($_POST[dsgastos][$x]+$_POST[dcdpsaldo][$x])." where consvigencia=$_POST[cdp] and vigencia=$vigusu and cuenta='".$_POST[dcuentas][$x]."'";
			mysql_query($sqlr,$linkbd);
			//echo "<br>".$sqlr;
			
			$sqlr="update pptocomprobante_det set valcredito=".($_POST[dsgastos][$x]+$_POST[dcdpsaldo][$x])." where tipo_comp=6 and numerotipo=$_POST[cdp] and cuenta='".$_POST[dcuentas][$x]."' and vigencia='$vigusu'";
	 	    mysql_query($sqlr,$linkbd); 
			
			$sqlr="update pptocomprobante_det set valcredito=".($_POST[dsgastos][$x])." where tipo_comp=7 and numerotipo=$_POST[rp] and cuenta='".$_POST[dcuentas][$x]."' and vigencia='$vigusu'";
	 	    mysql_query($sqlr,$linkbd); 	
			//echo "<br>".$sqlr;				
		 }
		 echo "<table  class='inicio'><tr><td class='saludo1'><center>Se ha Liberado el Saldo del RP $_POST[rp] , CDP $_POST[cdp], Vigencia $vigusu con Exito <img src='imagenes/confirm.png'></center></td></tr></table>";
		}
		if($_POST[tipolib]=='cdp')
		{
		//	echo "LIBERACION CDPS <BR>";
		 for ($x=0;$x< count($_POST[dcuentas]);$x++)
		 {
		  $sqlr="update pptocdp_detalle set saldo=0, saldo_liberado=".($_POST[dcdpsaldo][$x])." where consvigencia=$_POST[cdp] and vigencia=$vigusu and cuenta='".$_POST[dcuentas][$x]."'";
		  mysql_query($sqlr,$linkbd);	 
		 // echo "$sqlr<br>";
		  $sqlr="insert into pptoliberarsaldos_det  (id_lib, cuenta, vigencia, valcdp, saldocdp, valrp, saldorp) values($idlib,'".$_POST[dcuentas][$x]."','$vigusu',".$_POST[dcdpvalor][$x].", ".$_POST[dcdpsaldo][$x].", ".$_POST[dgastos][$x].", 0 )";
		  mysql_query($sqlr,$linkbd);	
		 // echo "$sqlr<br>";	
		  $sqlr="update pptocomprobante_det set valcredito=".($_POST[dcdpsaldo][$x])." where tipo_comp=6 and numerotipo=$_POST[cdp] and cuenta='".$_POST[dcuentas][$x]."' and vigencia='$vigusu'";
	 	  mysql_query($sqlr,$linkbd); 	
		  //echo "$sqlr<br>";
		 }	
		 echo "<table  class='inicio'><tr><td class='saludo1'><center>Se ha Liberado el Saldo del  CDP $_POST[cdp], Vigencia $vigusu con Exito <img src='imagenes/confirm.png'></center></td></tr></table>";
		}
	  }
 }//*** if de control de guardado
?> 
</td></tr>     
</table>
</body>
</html>