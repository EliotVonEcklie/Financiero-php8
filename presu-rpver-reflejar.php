<?php //V 1002 28/12/16 NO enviaba bn el estado a la cabecera?> 
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
//************* ver reporte ************
function verep(idfac)
{
  document.form1.oculto.value=idfac;
  document.form1.submit();
  }
//************* genera reporte ************
function genrep(idfac)
{
  document.form2.oculto.value=idfac;
  document.form2.submit();
  }
//************* genera reporte ************
function guardar()
{

if (document.form2.vigencia.value!='' && document.form2.fecha.value!='' && document.form2.solicita.value!='')
{
	if (confirm("Esta Seguro de Guardar"))
  	{
		document.form2.oculto.value='2';
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
document.form2.action="presu-rpver-reflejar.php";
document.form2.submit();
}
function validar2(formulario)
{
document.form2.chacuerdo.value=2;
document.form2.action="presu-cdp.php";
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
// function pdf()
// {
// document.form2.action="pdfrprecom.php";
// document.form2.target="_BLANK";
// document.form2.submit(); 
// document.form2.action="";
// document.form2.target="";
// }
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
</script>
<script>
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
document.form2.action="presu-rpver-reflejar.php";
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
document.form2.action="presu-rpver-reflejar.php";
document.form2.submit();
 }
}
function validar2()
{
document.form2.oculto.value=1;
document.form2.ncomp.value=document.form2.idcomp.value;
document.form2.action="presu-rpver-reflejar.php";
document.form2.submit();
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
</tr></table>
<tr><td colspan="3" class="tablaprin"> 
<?php
//$vigencia=date(Y);
//$linkbd=conectar_bd();
$vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
$oculto=$_POST['oculto'];	 
 ?>	
<?php
if(!$_POST[oculto])
{	

	$sqlr="select consvigencia from  pptorp where vigencia='$vigusu' ORDER BY consvigencia DESC";
	$res=mysql_query($sqlr,$linkbd);
	//echo $sqlr;
	$r=mysql_fetch_row($res);
	$_POST[maximo]=$r[0];
	$_POST[ncomp]=$r[0];
	$_POST[idcomp]=$r[0];
}	
    $_POST[dcuentas]=array();
	$_POST[dncuentas]=array();
	$_POST[dingresos]=array();
	$_POST[dgastos]=array();
	$_POST[drecursos]=array();
	$_POST[dnrecursos]=array();		
		
		$_POST[fechacdp]="";	
		$_POST[fecha]="";	
		$_POST[solicita]=""; 	
 		 $_POST[objeto]=""; 	
 		 $_POST[valorrp]="";
		 $_POST[saldo]="";
		 $_POST[vigencia]=""; 	
 		 $_POST[tercero]="";
		  $_POST[ntercero]="";
		$_POST[estado]="";
		$_POST[numerocdp]="";
		$_POST[estadoc]="";
		$_POST[ncontrato]="";
		  $linkbd=conectar_bd();
		$sqlr="select *from pptorp, pptocdp where pptorp.idcdp=pptocdp.consvigencia  and pptorp.consvigencia=$_POST[ncomp] and  pptorp.vigencia=$vigusu and pptocdp.vigencia=$vigusu";
		// echo $sqlr;
		$res=mysql_query($sqlr,$linkbd); 
	//	$_POST[agregadet]='';
		$cont=0;
		while ($row=mysql_fetch_row($res)) 
 		{
	 	if($row[3]=='S')
		{
			$_POST[estadoc]='ACTIVO';
			$color=" style='background-color:#0CD02A ;color:#fff'"; 	 				  
		}
		if($row[3]=='C')
		{
			$_POST[estadoc]='COMPLETO'; 	 				
			$color=" style='background-color:#00CCFF ; color:#fff'"; 	  
		}
		if($row[3]=='N')
		{
			$_POST[estadoc]='ANULADO'; 
			$color=" style='background-color:#aa0000 ; color:#fff'"; 
		}
		if($row[3]=='R')
		{
			$_POST[estadoc]='REVERSADO'; 
			$color=" style='background-color:#aa0000 ; color:#fff'"; 
		}
		$sq="select solicita, objeto from pptocdp where vigencia='$vigusu' and consvigencia='$_POST[ncomp]'";
		$rs=mysql_query($sq,$linkbd); 
		$rw=mysql_fetch_row($rs);
		$separar=explode(' - ',$rw[0]);
		$_POST[solicita]=$row[16]; 
		$_POST[objeto]=$row[15];
		
		 $sqlr1="select concepto from pptocomprobante_cab where tipo_comp='7' and vigencia='$vigusu' and numerotipo='$_POST[ncomp]'";
		$res1=mysql_query($sqlr1,$linkbd); 
		$row1=mysql_fetch_row($res1);
		
		$_POST[numerocdp]=$row[2];
		$_POST[numero]=$_POST[ncomp];
		$p1=substr($row[12],0,4);
		$p2=substr($row[12],5,2);
		$p3=substr($row[12],8,2);
		$_POST[fechacdp]=$p3."-".$p2."-".$p1;	
		$_POST[fecha]=$row[4];
			
 		 	
 		 $_POST[valorrp]=$row[6];
		 $_POST[saldo]=$row[7];
		 $_POST[vigencia]=$row[0]; 	
 		 $_POST[tercero]=$row[5];
		  $_POST[ntercero]=buscatercero($_POST[tercero]);
		$_POST[estado]=$row[3];
		$_POST[ncontrato]=$row[8];
		 $cont=$cont+1;
}
?>
 <?php
			//**** busca cuenta
			
			 
		if ($_POST[chacuerdo]=='2')
					 {
				    $_POST[dcuentas]=array();
				    $_POST[dncuetas]=array();
				    $_POST[dingresos]=array();
				    $_POST[dgastos]=array();
					 $_POST[drecursos]=array();
	 				 $_POST[dnrecursos]=array();	
					$_POST[diferencia]=0;
					$_POST[cuentagas]=0;
					$_POST[cuentaing]=0;																			
					 }	 
		?>

 <form name="form2" method="post" action="">
    <table class="inicio" align="center" width="80%" >
		<tr >
			<td class="titulos" colspan="10">.: Registro Presupuestal </td>
			<td  class="cerrar"  style='width:10%'><a href="presu-principal.php">Cerrar</a></td>
		</tr>
		<tr>
			<td style="width:10%;" class="saludo1">Fecha:        </td>
			<td >
				<input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" readonly>         
				<input type="hidden" name="chacuerdo" value="1">
			</td>
			<td class="saludo1">Numero:</td>
			<td >
				<a href="#" onClick="atrasc()">
					<img src="imagenes/back.png" alt="anterior" align="absmiddle">
				</a> 
				<input name="cuentacaja" type="hidden" value="<?php echo $_POST[cuentacaja]?>" >
				<input name="idcomp" type="text" size="5" value="<?php echo $_POST[idcomp]?>" onKeyUp="return tabular(event,this) "  onBlur="validar2()"  >
				<input name="ncomp" type="hidden" value="<?php echo $_POST[ncomp]?>">
				<a href="#" onClick="adelante()">
					<img src="imagenes/next.png" alt="siguiente" align="absmiddle">
				</a> 
				<input type="hidden" value="a" name="atras" >
				<input type="hidden" value="s" name="siguiente" >
				<input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo">
				<input name="numero" type="hidden" id="numero" value="<?php echo $_POST[numero] ?>" readonly>
			</td>
			<td  class="saludo1">Vigencia:</td>
			<td>
				<input  type="text" name="vigencia" value="<?php echo $_POST[vigencia] ?>" readonly>
			</td>
			<td class="saludo1">Contrato:</td>
			<td >
				<input id="ncontrato" type="text" name="ncontrato" onKeyUp="return tabular(event,this)"  onKeyPress="javascript:return solonumeros(event)"  value="<?php echo $_POST[ncontrato]?>" readonly >
			</td>
			<td class="saludo1">Estado</td>
			<td >
				<input name="estadoc" type="text" id="estadoc" value="<?php echo $_POST[estadoc] ?>" readonly  <?php echo $color; ?> >
			</td>
		</tr>
		<tr  >
			<td class="saludo1">Numero CDP:</td>
			<td >
				<input name="numerocdp" type="text" id="numerocdp" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[numerocdp]?>" readonly>
			</td>
			<td  class="saludo1">Fecha CDP:        </td>
			<td >
				<input name="fechacdp" type="text" id="fc_1198971546" title="DD/MM/YYYY" value="<?php echo $_POST[fechacdp]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" readonly>   
			</td>
			<td class="saludo1">Tercero:          </td>
			<td  colspan="5" >
				<input id="tercero" type="text" name="tercero" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo $_POST[tercero]?>" onClick="document.getElementById('tercero').focus();document.getElementById('tercero').select();" readonly>
				<input type="hidden" value="0" name="bt">
				<input name="ntercero" type="text" value="<?php echo $_POST[ntercero]?>" style="width:73.5%;" readonly>
			</td>
	    </tr>
		<tr>
			<td class="saludo1">
				<input type="hidden" value="1" name="oculto">Solicita:
			</td>
			<td colspan="3">
				<input name="solicita" type="text" id="solicita" style="width:100%;" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[solicita]?>" readonly>
			</td>
			<td class="saludo1">Objeto:</td>
			<td colspan='5'>
				<input name="objeto" type="text" id="objeto" style="width:100%;" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[objeto]?>" readonly> 
			</td>
	    </tr>
        <tr>
			<td class="saludo1">Valor RP:</td>
			<td>
				<input name="valorrp" type="text" value="<?php echo $_POST[valorrp]?>" readonly>
			</td>
			<td class="saludo1">Saldo:</td>
			<td>
				<input name="saldo" type="text" value="<?php echo $_POST[saldo]?>" readonly>
			</td>
		</tr>
    </table>
<div class="subpantalla" style="height:55.5%; width:99.6%; overflow-x:hidden;">
	<table class="inicio" width="99%">
        <tr>
			<td class="titulos" colspan="5">Detalle RP</td>
        </tr>
		<tr>
			<td class="titulos2" style='width:10%'>Cuenta</td>
			<td class="titulos2">Nombre Cuenta</td>
			<td class="titulos2">Fuente</td>
			<td class="titulos2" style='width:10%'>Valor</td>
		</tr>
		  <?php
		  	 $_POST[dcuentas]=array();
		  	 $_POST[dncuentas]=array();
		  	 $_POST[dgastos]=array();
		  	 $_POST[dfuentes]=array();	
			 $_POST[dcfuentes]=array();			 			 			 			 			 		   
  		   $sqlr="Select * from pptorp_detalle  where vigencia='$vigusu' and consvigencia=$_POST[ncomp]  order by CUENTA";
			//echo $sqlr;
		 		$resp = mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($resp)) 
				{
				 $_POST[dcuentas][]=$row[3];
 	 		     $nresul=buscacuentapres($row[3],2);			
				 $_POST[dncuentas][]=$nresul;				 
				 $_POST[dgastos][]=$row[5];
				  $nfuente=buscafuenteppto($row[3],$vigusu);
			  	 $cdfuente=substr($nfuente,0,strpos($nfuente,"_"));
				// echo "cc ".$cdfuente;
					  $_POST[dcfuentes][]=$cdfuente;
					  $_POST[dfuentes][]=$nfuente;
		  		}
			 $co="zebra1";
			 $co2="zebra2";						
		 for ($x=0;$x< count($_POST[dcuentas]);$x++)
		 {
		 
		 echo "<tr class='$co' onMouseOver=\"anterior=this.style.backgroundColor; this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\" >
		<td>
			<input name='dcuentas[]' value='".$_POST[dcuentas][$x]."' type='text' style='width:100%' readonly class='inpnovisibles'>
		</td>
		<td >
			<input name='dncuentas[]' value='".$_POST[dncuentas][$x]."' type='text' style='width:100%' readonly class='inpnovisibles'>
		</td>
		<td>
			<input name='dcfuentes[]' value='".$_POST[dcfuentes][$x]."' type='hidden'>
			<input name='dfuentes[]' value='".$_POST[dfuentes][$x]."' type='text' style='width:100%' readonly class='inpnovisibles'>
		</td>
		<td>
			<input name='dgastos[]' value='".$_POST[dgastos][$x]."' type='text' style='text-align:right; width:100%' onDblClick='llamarventana(this,$x)' readonly class='inpnovisibles'>
		</td>
	</tr>";
//		 $cred= $vc[$x]*1;
		 $gas=$_POST[dgastos][$x];
//		 $cred=number_format($cred,2,".","");
	//	 $deb=number_format($deb,2,".","");

		 $gas=$gas;
		 $cuentagas=$cuentagas+$gas;
		 $_POST[cuentagas2]=$cuentagas;
		 $total=number_format($total,2,",","");
 		 $_POST[cuentagas]=number_format($cuentagas,2,".",",");
			$resultado = convertir($_POST[cuentagas2]);
			$_POST[letras]=$resultado." PESOS";
			$aux=$co;
			$co=$co2;
			$co2=$aux;
		 }
		 echo "<tr>
				<td >
				</td>
				<td colspan='1'>
				</td>
				<td>
				</td>
				<td class='saludo1'>
					<input id='cuentagas' name='cuentagas' value='$_POST[cuentagas]' readonly class='inpnovisibles' style='text-align:right; width:100%'>
					<input id='cuentagas2' name='cuentagas2' value='$_POST[cuentagas2]' type='hidden'>
				</td>
			</tr>";
		 echo "<tr >
				<td class='saludo1'>Son:</td>
				<td class='saludo1' colspan= '4'>
					<input id='letras' name='letras' value='$_POST[letras]' type='text' style='width:100%' class='inpnovisibles'>
				</td>
			</tr>";
		?>
		<?php
				//***************PARTE PARA INSERTAR Y ACTUALIZAR LA INFORMACION CDP y REGISTRO PRESUPUESTAL
				$oculto=$_POST['oculto'];
				if($_POST[oculto]=='2')
				{
					$sqlr="select tipo_mov from pptorp_cab_r where consvigencia='$_POST[numero]'";
					$resdes=mysql_query($sqlr);
					$rowdes=mysql_fetch_row($resdes);
					if($rowdes[0]!=''){
						$tipomov=$rowdes[0];
					}else{
						$tipomov='201';
					}
					if($_POST[estado]=='S'){$estadof=1;}
					if($_POST[estado]=='N'){$estadof=0;}
					if(($_POST[estado]=='R') and $tipomov=='401'){$estadof=1;$tm='401';$estadoff=2;}
					if(($_POST[estado]=='R') and $tipomov=='402'){$estadof=1;$tm='402';$estadoff=3;}
					if($_POST[estado]=='C'){$estadof=4;}
					
					$sqlr="delete from pptocomprobante_cab where numerotipo='$_POST[numero]' and tipo_comp=7";
					mysql_query($sqlr,$linkbd); 
					// echo $sqlr."<br>";
					$sqlr="delete from  pptocomprobante_det where tipo_comp=7 and numerotipo='$_POST[numero]' and valcredito=0";
					mysql_query($sqlr,$linkbd);
					// echo $sqlr."<br>";
					// $sqlr="delete from  pptocomprobante_det where tipo_comp=6 and numerotipo='$_POST[numerocdp]' and valdebito=0 and tipomovimiento='201'";
					// mysql_query($sqlr,$linkbd);
					// echo $sqlr."<br>";
					
					$sqlr="select count(*) from pptorp where vigencia='$_POST[vigencia]' and consvigencia=$_POST[numero]";
					
					$res=mysql_query($sqlr,$linkbd);
					while($r=mysql_fetch_row($res)){
						$numerorecaudos=$r[0];
					}
				
					if($numerorecaudos==1)
					{
						$nr="1";				
						$totalrp=0;
						$totalrp=array_sum($_POST[dgastos]);
						$_POST[valorrp]=0+$totalrp;
						if(($_POST[estado]=='R') and $tipomov=='401'){
							$sqlr="insert into  pptocomprobante_cab (numerotipo,tipo_comp,fecha,concepto,vigencia,total_debito, total_credito,diferencia,estado) values('$_POST[numero]',7,'$_POST[fecha]','$_POST[solicita] - $_POST[objeto]','$_POST[vigencia]','$_POST[cuentagas2]','$_POST[cuentagas2]',0,'$estadoff')";
							mysql_query($sqlr,$linkbd); 
						}else{
							$sqlr="insert into  pptocomprobante_cab (numerotipo,tipo_comp,fecha,concepto,vigencia,total_debito, total_credito,diferencia,estado) values('$_POST[numero]',7,'$_POST[fecha]','$_POST[solicita] - $_POST[objeto]','$_POST[vigencia]','$_POST[cuentagas2]','$_POST[cuentagas2]',0,'$estadof')";
							mysql_query($sqlr,$linkbd); 
						}
						
						// echo $sqlr."<br>";
						
						$sqlr="delete from pptocomprobante_det where numerotipo='$_POST[numerocdp]' and tipo_comp=6 and valcredito=0 and doc_receptor='0' and tipomovimiento=$tm";
						mysql_query($sqlr,$linkbd);	
						$sqlr="delete from pptocomprobante_det where numerotipo='$_POST[numero]' and tipo_comp=7 and valdebito=0 and doc_receptor='0' and tipomovimiento=$tm";
								mysql_query($sqlr,$linkbd);
						for($x=0;$x<count($_POST[dgastos]);$x++)
						{
							$sqlr="delete from pptocomprobante_det where numerotipo='$_POST[numerocdp]' and tipo_comp=6 and valdebito=0 and cuenta='".$_POST[dcuentas][$x]."' and doc_receptor='$_POST[numero]' and tipomovimiento='201' and valcredito='".$_POST[dgastos][$x]."'";
							mysql_query($sqlr,$linkbd);
							$sqlr="delete from pptocomprobante_det where numerotipo='$_POST[numerocdp]' and tipo_comp=6 and valdebito=0 and doc_receptor='0' and tipomovimiento='201'";
							mysql_query($sqlr,$linkbd);							
							
							$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia, tipo_comp,numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values('".$_POST[dcuentas][$x]."','$_POST[tercero]','".$_POST[dfuentes][$x]."',".$_POST[dgastos][$x].",0,$estadof,'$_POST[vigencia]',7,'$_POST[numero]','201','','','$_POST[fecha]')";
							// echo $sqlr."<br>";
							mysql_query($sqlr,$linkbd); 
							
							$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia, tipo_comp,numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values('".$_POST[dcuentas][$x]."','$_POST[tercero]','".$_POST[dfuentes][$x]."',0,'".$_POST[dgastos][$x]."',$estadof,'$_POST[vigencia]',6,'$_POST[numerocdp]','201','','$_POST[numero]','$_POST[fecha]')";
							echo $sqlr."<br>";
							mysql_query($sqlr,$linkbd);
							if($_POST[estado]=='R'){
								$sqlr="select valor from pptorp_det_r where consvigencia=$_POST[numero] and vigencia=$_POST[vigencia] and cuenta='".$_POST[dcuentas][$x]."'";
								$res=mysql_query($sqlr,$linkbd);
								$valor=mysql_fetch_row($res);
								// echo $sqlr;
								$sqlr="delete from pptocomprobante_det where numerotipo='$_POST[numerocdp]' and tipo_comp=6 and valcredito=0 and cuenta='".$_POST[dcuentas][$x]."' and doc_receptor='$_POST[numero]' and tipomovimiento=$tm and valcredito='".$_POST[dgastos][$x]."'";
								mysql_query($sqlr,$linkbd);
																	
								
								$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia, tipo_comp,numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values('".$_POST[dcuentas][$x]."','$_POST[tercero]','".$_POST[dfuentes][$x]."',0,".$valor[0].",$estadoff,'$_POST[vigencia]',7,'$_POST[numero]',$tm,'','','$_POST[fecha]')";
								// echo $sqlr."<br>";
								mysql_query($sqlr,$linkbd); 
								
								$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia, tipo_comp,numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values('".$_POST[dcuentas][$x]."','$_POST[tercero]','".$_POST[dfuentes][$x]."',".$valor[0].",0,$estadoff,'$_POST[vigencia]',6,'$_POST[numerocdp]',$tm,'','$_POST[numero]','$_POST[fecha]')";
								// echo $sqlr."<br>";
								mysql_query($sqlr,$linkbd);
							}
						}
						echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha reflejado el RP con Exito<img src='imagenes\confirm.png'></center></td></tr></table>"; 
							
					}
					else
					{
						echo"<script>despliegamodalm('visible','2','Ya Existe un Registro Presupuestal con este Numero');</script>";
					}
				}//*** if de control de guardado
			?> 
		</table>
 </div>
 </form>
</body>
</html>