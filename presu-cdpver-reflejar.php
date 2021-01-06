<?php //V 1002 28/12/16 No modificaba bn el estado de la cabecera?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	require"validaciones.inc";
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
		<title>:: Spid - Presupuesto</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
        <script type="text/javascript" src="JQuery/jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="JQuery/autoNumeric-master/autoNumeric-min.js"></script>
<script>
//************* ver reporte ************
//***************************************
function verep(idfac)
{
  document.form1.oculto.value=idfac;
  document.form1.submit();
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
	if (document.form2.vigencia.value!='' && document.form2.fecha.value!='' && document.form2.solicita.value!='')
	{
		if (confirm("Esta Seguro de Guardar"))
		{
			document.form2.oculto.value=2;
			document.form2.submit();
		}
	}
	else
	{
		alert('Faltan datos para completar el registro');
		document.form2.fecha.focus();
		document.form2.fecha.select();
	}
}

function validar(formulario)
{
document.form2.action="presu-cdpver-reflejar.php";
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
document.form2.action="pdfcdispre.php";
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
function capturaTecla(e){ 
var tcl = (document.all)?e.keyCode:e.which;
if (tcl==115){
alert(tcl);
return tabular(e,elemento);
}
}
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
document.form2.action="presu-cdpver-reflejar.php";
document.form2.submit();
}
}
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
document.form2.action="presu-cdpver-reflejar.php";
document.form2.submit();
 }
}
function validar2()
{
document.form2.oculto.value=1;
document.form2.ncomp.value=document.form2.idcomp.value;
document.form2.action="presu-cdpver-reflejar.php";
document.form2.submit();
}
</script>
		<?php titlepag();?>
    </head>
    <body >
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table >
            <tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("presu");?></tr>
        	<tr>
          		<td colspan="3" class="cinta">
					<a class="mgbt" href="#" >
						<img src="imagenes/add2.png" alt="Nuevo"  border="0" />
					</a> 
					<a class="mgbt" href="#" onClick="#">
						<img src="imagenes/guardad.png"  alt="Guardar" />
					</a> 
					<a class="mgbt" href="presu-rpver-reflejar.php"> 
						<img src="imagenes/busca.png"  alt="Buscar" />
					</a> 
					<a class="mgbt" href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();">
						<img src="imagenes/nv.png" alt="nueva ventana">
					</a> 
					<a class="mgbt" href="#" onClick="guardar()">
						<img src="imagenes/reflejar1.png"  alt="Reflejar" style="width:24px;" />
					</a> 
					<a class="mgbt" href="#"onClick="pdf()"> 
						<img src="imagenes/print.png"  alt="Buscar" />
					</a> 
					<a class="mgbt" href="presu-reflejardocs.php">
						<img src="imagenes/iratras.png" alt="nueva ventana">
					</a>
				</td>
        	</tr>
		</table>
<?php
	$linkbd=conectar_bd();
	$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
?> 
<?php

if(!$_POST[oculto])
{	

	$_POST[vigencia]=$vigusu;

	$sqlr="select consvigencia from pptocdp where vigencia='$vigusu' order by consvigencia desc";
	$res=mysql_query($sqlr,$linkbd);
	$r=mysql_fetch_row($res);
	
	$_POST[ncomp]=$r[0];
	$_POST[idcomp]=$r[0];
	$sqlr="select consvigencia from  pptocdp where vigencia='$vigusu' ORDER BY consvigencia DESC";
	$res=mysql_query($sqlr,$linkbd);
	//echo $sqlr;
	$r=mysql_fetch_row($res);
	 $_POST[maximo]=$r[0];
	 //$_POST[ncomp]=$r[0];
	 //$_POST[idcomp]=$r[0];
	// $_POST[idrecaudo]=$r[1];	 
}                                  
		 $_POST[solicita]="";
		 $_POST[objeto]="";
		 $_POST[estadoc]="";
		$sqlr="select distinct *from pptocdp  where pptocdp.vigencia='$vigusu' and pptocdp.consvigencia=$_POST[ncomp] ";
	//echo $sqlr;
		$res=mysql_query($sqlr,$linkbd); 
		$_POST[agregadet]='';
		$cont=0;
		while ($row=mysql_fetch_row($res)) 
		 {		
		 $_POST[vigencia]=$row[1];
		$_POST[estado]= $row[5];
		 if($row[5]=='S')
		 {
		 $_POST[estadoc]='DISPONIBLE'; 	 
		 $color=" style='background-color:#009900 ;color:#fff'";
		 }
		 if($row[5]=='C')
		 {
		 $_POST[estadoc]='CON REGISTRO'; 	
		 $color=" style='background-color:#00CCFF ; color:#fff'"; 				  
		 }
		 if($row[5]=='N')
		 {
		 $_POST[estadoc]='ANULADO'; 	
		 $color=" style='background-color:#aa0000 ; color:#fff'"; 				  
		 }
		 if($row[5]=='R')
		 {
		 $_POST[estadoc]='REVERSADO'; 	
		 $color=" style='background-color:#aa0000 ; color:#fff'"; 				  
		 }
		$p1=substr($row[3],0,4);
		$p2=substr($row[3],5,2);
		$p3=substr($row[3],8,2);
		$_POST[fecha]=$row[3];	
		ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
		$_POST[fecha]=$fecha[3]."/".$fecha[2]."/".$fecha[1];			
		// $_POST[dcuentas]=$row[3]; 			 
		 $_POST[solicita]=$row[6];
		 $_POST[objeto]=$row[7];
		 $_POST[numero]=$row[2];
		 }
		 $_POST[dcuentas]= array(); 		 
		 $_POST[dncuentas]= array(); 		 
		 $_POST[dgastos]= array(); 
		 $_POST[dcfuentes]= array(); 
		 $_POST[dfuentes]= array(); 
		$sqlr="select distinct *from  pptocdp_detalle where  pptocdp_detalle.consvigencia=$_POST[ncomp] and pptocdp_detalle.vigencia='".$vigusu."' ORDER BY CUENTA ";
	//echo $sqlr;
		$res=mysql_query($sqlr,$linkbd); 
		$_POST[agregadet]='';
		$cont=0;
		while ($row=mysql_fetch_row($res)) 
		 {				
		 $_POST[dcuentas][$cont]=$row[3];
		 $_POST[dncuentas][$cont]=existecuentain($row[3]);
		 $_POST[dgastos][$cont]=$row[5];
		 $nfuente=buscafuenteppto($row[3],$_POST[vigencia]);
	  	 $cdfuente=substr($nfuente,0,strpos($nfuente,"_"));
		 $_POST[dcfuentes][]=$cdfuente;
	  	 $_POST[dfuentes][]=$nfuente;
		 $cont=$cont+1;
		 }
?>
 <?php
			//**** busca cuenta
			
			 
		/*if ($_POST[chacuerdo]=='2')
					 {
				    $_POST[dcuentas]=array();
				    $_POST[dncuetas]=array();
				    $_POST[dingresos]=array();
				    $_POST[dgastos]=array();
					$_POST[diferencia]=0;
					$_POST[cuentagas]=0;
					$_POST[cuentaing]=0;																			
					 }	 */
		?>
 <form name="form2" method="post" action="">
    <table class="inicio" align="center" width="80%" >
      <tr >
        <td class="titulos" colspan="8">.: Certificado Disponibilidad Presupuestal </td>
        <td width="73" class="cerrar" ><a href="presu-principal.php">Cerrar</a></td>
      </tr>
      <tr  >
		<td style="width:9%;" class="saludo1">N&uacute;mero:</td>
		<td style="width:15%;">
			  <a href="#" onClick="atrasc()"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a> 
			  <input name="cuentacaja" type="hidden" value="<?php echo $_POST[cuentacaja]?>" >
			  <input name="idcomp" type="text"  value="<?php echo $_POST[idcomp]?>" onKeyUp="return tabular(event,this) " style="width:50%;" onBlur="validar2()" >
			  <input name="ncomp" type="hidden" value="<?php echo $_POST[ncomp]?>"><a href="#" onClick="adelante()"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> <input type="hidden" value="a" name="atras" >
			  <input type="hidden" value="s" name="siguiente" >
			  <input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo">
			  <input name="numero" type="hidden" id="numero" value="<?php echo $_POST[numero] ?>" readonly>
		</td>
	  <td style="width:9%;" class="saludo1">Vigencia:</td>
	  <td style="width:10%;"><input style="width:100%;" type="text" name="vigencia" value="<?php echo $_POST[vigencia] ?>" readonly></td>
	  
	  <td class="saludo1" style="width:9%;">Fecha:        </td>
        <td style="width:10%;">
			<input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY"  value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" style="width:100%;" readonly> 
			<input type="hidden" name="chacuerdo" value="1">		  </td>
			<td  class="saludo1">Estado</td>
			<td >
				<input name="estadoc" type="text" id="estadoc" value="<?php echo $_POST[estadoc] ?>" <?php echo $color; ?> readonly>
				<input name="estado" type="hidden" id="estado" value="<?php echo $_POST[estado] ?>" ></td>
	    </tr>
		<tr>
			<td class="saludo1"><input type="hidden" value="1" name="oculto">Solicita:</td>
			<td colspan="3">
				<input name="solicita" type="text" id="solicita" onKeyUp="return tabular(event,this)" style="width:100%;" value="<?php echo $_POST[solicita]?>" readonly></td>
			<td class="saludo1">Objeto:</td>
			<td  colspan="3">
				<input name="objeto" style="width:100%;" type="text" id="objeto" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[objeto]?>" readonly></td>
	    </tr>
		<?php
		   //**** si esta disponible
		   
		   
		   //****
	    ?>
		</table>
	   	
	<?php
	if(!$_POST[oculto])
	{ 
		 ?>
		 <script>
    	document.form2.fecha.focus();
		</script>
	<?php
	}
	?>
		<?php
			//**** busca cuenta
			if($_POST[bc]!='')
			{
				$nresul=buscacuentapres($_POST[cuenta],2);
				if($nresul!='')
				{
					$_POST[ncuenta]=$nresul;
  		?>
		<script>
			document.getElementById('valor').focus();
			document.getElementById('valor').select();
		</script>
		<?php
			/*if ($ind=='2')
			  $sqlr="select pptocuentas.futfuentefunc,pptocuentaspptoinicial.saldoscdprp,pptofutfuentefunc.nombre from pptocuentas,pptocuentaspptoinicial,pptofutfuentefunc where pptocuentas.cuenta='$_POST[cuenta]' and pptocuentas.cuenta=pptocuentaspptoinicial.cuenta and pptocuentas.futfuentefunc=pptofutfuentefunc.codigo";
			  if ($ind=='3' || $ind=='4')
			  $sqlr="select pptocuentas.futfuenteinv,pptocuentaspptoinicial.saldoscdprp,pptofutfuenteinv.nombre from pptocuentas,pptocuentaspptoinicial,pptofutfuenteinv where pptocuentas.cuenta='$_POST[cuenta]' and pptocuentas.cuenta=pptocuentaspptoinicial.cuenta and pptofutfuenteinv.codigo=pptocuentas.futfuenteinv";
			  //echo $sqlr;*/

				}
				else
				{
					$_POST[ncuenta]="";
		?>
		<script>alert("Cuenta Incorrecta");document.form2.cuenta.focus();</script>
		<?php
				}
			}
		?>
		<table class="inicio" width="99%">
        <tr>
          <td class="titulos" colspan="5">Detalle CDP</td>
        </tr>
		<tr>
		<td class="titulos2">Cuenta</td>
		<td class="titulos2"><center>Nombre Cuenta </center></td>
		<td class="titulos2"><center>Fuente </center></td>
		<td class="titulos2"><center>Valor </center></td>
		<!-- <td class="titulos2"><img src="imagenes/del.png"><input type='hidden' name='elimina' id='elimina'></td> -->
		</tr>
        <?php 
		
		$iter1='saludo1a';
		$iter2='saludo2';
		for ($x=0;$x<count($_POST[dcuentas]);$x++)
		{
			$nfuente=buscafuenteppto($_POST[dcuentas][$x],$vigusu);
			$cdfuente=substr($nfuente,0,strpos($nfuente,"_"));
			// echo "cc ".$cdfuente;
			$_POST[dcfuentes][]=$cdfuente;
			$_POST[dfuentes][]=$nfuente;
			echo "<tr class=$iter1 onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\">
					<td style='width:10%;'>
						<input name='dcuentas[]' value='".$_POST[dcuentas][$x]."' type='text' style='width:100%;' readonly class='inpnovisibles'></td>
					<td style='width:32%;'>
						<input name='dncuentas[]' value='".$_POST[dncuentas][$x]."' type='text' style='width:100%;' readonly class='inpnovisibles'></td>
					<td style='width:45%;'>
						<input name='dcfuentes[]' value='".$_POST[dcfuentes][$x]."' type='hidden'>
						<input name='dfuentes[]' value='".utf8_decode($_POST[dfuentes][$x])."' type='text' style='width:100%;' readonly class='inpnovisibles'></td>
					<td style='width:13%;'>
						<input name='dgastos[]' value='".number_format($_POST[dgastos][$x],2,".",",")."' type='text' style='width:100%;text-align:right;' onDblClick='llamarventana(this,$x)' readonly class='inpnovisibles'>
					</td>
				</tr>";
			//<td ><a href='#' onclick='eliminar($x)'><img src='imagenes/del.png'></a></td>
			//		 $cred= $vc[$x]*1;
			$gas=$_POST[dgastos][$x];
			//		 $cred=number_format($cred,2,".","");
			//	 $deb=number_format($deb,2,".","");
			$aux=$iter1;
			$iter1=$iter2;
			$iter2=$aux;
			$gas=$gas;
			$cuentagas=$cuentagas+$gas;
			$_POST[cuentagas2]=$cuentagas;
			$total=number_format($total,2,",","");
			$_POST[cuentagas]=number_format($cuentagas,2,".",",");
			$resultado = convertir($_POST[cuentagas2]);
			$_POST[letras]=$resultado." Pesos";
		 }
		 echo "<tr class='saludo1'><td></td><td colspan='1'></td>
				<td></td>
				<td>
					<input id='cuentagas' style='width:100%;text-align:right;' name='cuentagas' value='$_POST[cuentagas]' readonly class='inpnovisibles'>
					<input id='cuentagas2' name='cuentagas2' value='$_POST[cuentagas2]' type='hidden'>
					<input id='letras' name='letras' value='$_POST[letras]' type='hidden'>
				</td>
			</tr>";
		 echo "<tr><td class='saludo1'>Son:</td><td class='saludo1' colspan= '4'>$resultado</td></tr>";
		?>
		</table>
		<?php
			 //***************PARTE PARA INSERTAR Y ACTUALIZAR LA INFORMACION
			$oculto=$_POST['oculto'];
			if($_POST[oculto]=='2')
			{
				$sqlr="select tipo_mov from pptocdp_cab_r where consvigencia='$_POST[numero]'";
				//echo $sqlr;
				$resdes=mysql_query($sqlr);
				$rowdes=mysql_fetch_row($resdes);
				if($rowdes[0]!=''){
					$tipomov=$rowdes[0];
				}else{
					$tipomov='201';
				}
				
				if($_POST[estado]=='S'){$estadof=1;}
				if($_POST[estado]=='N'){$estadof=0;}
				if(($_POST[estado]=='R') and $tipomov=='401'){$estadof=2;$tm='401';$estadoff=2;}
				if(($_POST[estado]=='R') and $tipomov=='402'){$estadof=3;$tm='402';$estadoff=3;}
				if($_POST[estado]=='C'){$estadof=4;}
				$fpfecha=split("/",$_POST[fecha]);
				$fechaf=$fpfecha[2]."-".$fpfecha[1]."-".$fpfecha[0];	
				// echo $fechaf;
				$sqlr="delete from  pptocomprobante_cab where numerotipo=$_POST[numero] and tipo_comp=6";
				mysql_query($sqlr,$linkbd);
				$sqlr="delete from  pptocomprobante_det where numerotipo=$_POST[numero] and tipo_comp=6 and valcredito=0";
				mysql_query($sqlr,$linkbd);
				if(($_POST[estado]=='R') and $tipomov=='401'){
					$sqlr="insert into  pptocomprobante_cab (numerotipo,tipo_comp,fecha,concepto,vigencia,total_debito,total_credito,diferencia,estado) values($_POST[numero],6,'$fechaf','$_POST[solicita] - $_POST[objeto]',$_POST[vigencia],$_POST[cuentagas2],$_POST[cuentagas2],0,'$estadoff')";
					//echo $sqlr;
					mysql_query($sqlr,$linkbd);
				}else{
					$sqlr="insert into  pptocomprobante_cab (numerotipo,tipo_comp,fecha,concepto,vigencia,total_debito,total_credito,diferencia,estado) values($_POST[numero],6,'$fechaf','$_POST[solicita] - $_POST[objeto]',$_POST[vigencia],$_POST[cuentagas2],$_POST[cuentagas2],0,'$estadof')";
					//echo $sqlr;
					mysql_query($sqlr,$linkbd);
				}
				
				// echo $sqlr;
				// echo count($_POST[dcuentas]);
				$sqlr="delete from pptocomprobante_det where numerotipo=$_POST[vigencia] and tipo_comp=1 and valcredito=0 and doc_receptor=0 and tipomovimiento=$tm";
						// echo $sqlr;
						mysql_query($sqlr,$linkbd);
				for ($x=0;$x<count($_POST[dcuentas]);$x++)
				{			
					
					$sqlr="delete from pptocomprobante_det where numerotipo=$_POST[vigencia] and tipo_comp=1 and valdebito=0 and cuenta='".$_POST[dcuentas][$x]."' and doc_receptor=$_POST[numero] and tipomovimiento='201'";
					// echo $sqlr;
					mysql_query($sqlr,$linkbd);
					$sqlr="delete from pptocomprobante_det where numerotipo=$_POST[vigencia] and tipo_comp=1 and valdebito=0 and doc_receptor=0 and tipomovimiento='201'";
					// echo $sqlr;
					mysql_query($sqlr,$linkbd);
					$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values('".$_POST[dcuentas][$x]."','','".$_POST[dfuentes][$x]."','".$_POST[dgastos][$x]."',0,$estadof,'$_POST[vigencia]',6,'$_POST[numero]','201','','','$fechaf')";
					// echo $sqlr."<br>";
					mysql_query($sqlr,$linkbd); 
					$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values('".$_POST[dcuentas][$x]."','','".$_POST[dfuentes][$x]."',0,'".$_POST[dgastos][$x]."',$estadof,'$_POST[vigencia]',1,'$_POST[vigencia]','201','','$_POST[numero]','$fechaf')";
					// echo $sqlr;
					mysql_query($sqlr,$linkbd); 
					//echo "hol".$_POST[dfuentes][$x];
					if($_POST[estado]=='R'){
						$sqlr="select valor from pptocdp_det_r where consvigencia=$_POST[numero] and vigencia=$_POST[vigencia] and cuenta='".$_POST[dcuentas][$x]."'";
						$res=mysql_query($sqlr,$linkbd);
						$valor=mysql_fetch_row($res);
						
						$sqlr="delete from pptocomprobante_det where numerotipo=$_POST[numero] and tipo_comp=6 and valdebito=0 and cuenta='".$_POST[dcuentas][$x]."' and tipomovimiento=$tm";
						// echo $sqlr;
						mysql_query($sqlr,$linkbd);
						$sqlr="delete from pptocomprobante_det where numerotipo=$_POST[vigencia] and tipo_comp=1 and valcredito=0 and cuenta='".$_POST[dcuentas][$x]."' and doc_receptor=$_POST[numero] and tipomovimiento=$tm";
						// echo $sqlr;
						mysql_query($sqlr,$linkbd);
						
						$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values('".$_POST[dcuentas][$x]."','','".$_POST[dfuentes][$x]."',0,'".$valor[0]."',$estadoff,'$_POST[vigencia]',6,'$_POST[numero]',$tm,'','','$fechaf')";
						// echo $sqlr."<br>";
						mysql_query($sqlr,$linkbd); 
						$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values('".$_POST[dcuentas][$x]."','','".$_POST[dfuentes][$x]."','".$valor[0]."',0,$estadoff,'$_POST[vigencia]',1,'$_POST[vigencia]',$tm,'','$_POST[numero]','$fechaf')";
						// echo $sqlr."<br>";
						mysql_query($sqlr,$linkbd); 
					}
					
				}
				echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha reflejado el CDP con Exito<img src='imagenes\confirm.png'></center></td></tr></table>";		
				
			}
			
		 
            ?> 
    </form>
</td></tr>     
</table>
</body>
</html>