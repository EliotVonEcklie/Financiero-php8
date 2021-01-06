<?php //V 1000 12/12/16 ?> 
<?php
require"comun.inc";
require"funciones.inc";
require"validaciones.inc";
require "conversor.php";
session_start();												   
header("Cache-control: private"); // Arregla IE 6
date_default_timezone_set("America/Bogota");
//**niveles menu: Administracion (0) - Consultas (1) - Herramientas (2) - Reportes (3)
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">

<head>

	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
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
//************* genera reporte ************
//***************************************
function guardar()
{
if (document.form2.vigencia.value!='' && document.form2.fecha.value!='' && document.form2.objeto.value!='')
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
<script >
function validar(formulario)
{
document.form2.action="presu-cdp.php";
document.form2.submit();
}
</script>
<script >
function validar2(formulario)
{
document.form2.chacuerdo.value=2;
document.form2.action="presu-cdp.php";
document.form2.submit();
}
function validaimport(formulario)
{
	document.form2.import.value=1;
	document.form2.action="teso-superavit.php";
	document.form2.submit();
}
function protocoloimport()
	{
		document.form2.action="teso-superavit-import.php";
		document.form2.target="_BLANK";
		document.form2.submit(); 
		document.form2.action="";
		document.form2.target="";
	}
</script>

<script >
function validarcdp()
{
valorp=document.getElementById("valor").value;
nums=quitarpuntos(valorp);			
if(nums<0 || nums> parseFloat(document.form2.saldo.value))
{
		alert('Valor Superior al Disponible '+document.form2.saldo.value);
document.form2.cuenta.select();
document.form2.cuenta.focus();
}
}
</script>
<script>
function buscacta(e)
 {
if (document.form2.cuenta.value!="")
{
 document.form2.bc.value=2;
 document.form2.submit();
 }
 }
</script>
<script>
function agregardetalle()
{
if(document.form2.cuenta.value!="" &&  parseFloat(document.form2.valor.value) >=0 )
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
  document.form2.chacuerdo.value=2;
document.form2.elimina.value=variable;
//eli=document.getElementById(elimina);
document.getElementById('elimina').value=variable;
//eli.value=elimina;
//vvend.value=variable;
document.form2.submit();
}
}
</script>
<script>
function pdf()
{
document.form2.action="pdfcdispre.php";
document.form2.target="_BLANK";
document.form2.submit(); 
document.form2.action="";
document.form2.target="";
}
</script>
<script>
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
</script>

<script>
function capturaTecla(e){ 
var tcl = (document.all)?e.keyCode:e.which;
if (tcl==115){
alert(tcl);
return tabular(e,elemento);
}
}
</script>
<script src="css/programas.js"></script>
<script src="css/calendario.js"></script>
<link href="css/css2.css" rel="stylesheet" type="text/css" />
<link href="css/css3.css" rel="stylesheet" type="text/css" />
<?php titlepag();?>
</head>
<body >
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
	<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
	<tr><?php menu_desplegable("teso");?></tr>
	<tr>
		<td colspan="3" class="cinta">
			<a href="teso-superavit.php" class="mgbt" ><img src="imagenes/add.png"  alt="Nuevo" border="0" title="Nuevo"/></a> 
			<a href="#"  onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png"  alt="Guardar" title="Guardar"/></a> 
			<a href="teso-buscasuperavit.php" class="mgbt"><img src="imagenes/busca.png"  alt="Buscar" border="0" title="Buscar"/></a> 
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" alt="nueva ventana" class="mgbt" title="Nueva ventana"></a> 
			<a href="#" <?php if($_POST[oculto]==2) { ?> onClick="pdf()" <?php } ?> class="mgbt"><img src="imagenes/print.png" alt="Imprimir" title="Imprimir"></a>
		</td>
	</tr>
</table>
<tr><td colspan="3" class="tablaprin"> 
<?php
//$vigencia=date(Y);
$linkbd=conectar_bd();
$vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
$_POST[vigencia]=vigencia_usuarios($_SESSION[cedulausu]); 
$vigencia=$vigusu;
 ?>	
<?php
	if(!$_POST[oculto])
	{
		//$_POST[vigencia]=$_SESSION[vigencia]; 	
 		$fec=date("d/m/Y");
		$_POST[fecha]=$fec; 	
		$_POST[cuentaing]=0;
		$_POST[cuentagas]=0;
 		$_POST[cuentaing2]=0;
		$_POST[cuentagas2]=0;
		$link=conectar_bd();
		$sqlr="select max(consvigencia) from pptosuperavit where vigencia=$_POST[vigencia] ";
		$res=mysql_query($sqlr,$link);
		//echo $sqlr;
		$r=mysql_fetch_row($res);
		$maximo=$r[0];
		if(!$maximo)
		{
			$_POST[numero]=1;
		}
		else
		{
			$_POST[numero]=$maximo+1;
 		}
	}
?>
 <?php
	//**** busca cuenta
	if($_POST[bc]!='')
	{
		$tipo=substr($_POST[cuenta],0,1);			
		$nresul=buscacuentapres($_POST[cuenta],$tipo);			
		if($nresul!='')
		{
			$_POST[ncuenta]=$nresul;
			$linkbd=conectar_bd();
			//$sqlr="select *from pptocuentaspptoinicial where cuenta='$_POST[cuenta]' and vigencia=".$_POST[vigencia];
 			$sqlr="select *from pptocuentas where cuenta='$_POST[cuenta]' and (vigencia=".$vigusu." or   vigenciaf=$vigusu)";
			// echo $sqlr;
			$res=mysql_query($sqlr,$linkbd);
			$row=mysql_fetch_row($res);
			//$_POST[saldo]=$row[6];	
			$vigenciai=$row[25];
			$clasifica=$row[29];
			$vsal=consultasaldo($_POST[cuenta],$vigenciai,$vigusu);
			$_POST[saldo]=$vsal;
			$ind=substr($_POST[cuenta],0,1);
			//$reg=	substr($_POST[cuenta],0,1);		
			if($ind=='R' || $ind=='r')
			{						
				$ind=substr($_POST[cuenta],1,1);	
				$criterio="and (pptocuentas.vigencia=".$vigusu." or  pptocuentas.vigenciaf=$vigusu) ";
				$reg='R';					  
			}
			else
			{
				$reg='';
				$criterio=" and pptocuentas.vigencia=".$vigusu." ";
			}
			if ($clasifica=='funcionamiento')
			{
				$sqlr="select pptocuentas.futfuentefunc,pptocuentas.pptoinicial,pptofutfuentefunc.nombre from pptocuentas,pptofutfuentefunc where pptocuentas.cuenta='$_POST[cuenta]'  and pptocuentas.futfuentefunc=pptofutfuentefunc.codigo ".$criterio;
				$_POST[tipocuenta]=2;
			}
			if ($clasifica=='deuda' )
			{
				$sqlr="select pptocuentas.futfuenteinv,pptocuentas.pptoinicial,pptofutfuenteinv.nombre from pptocuentas,pptofutfuenteinv where pptocuentas.cuenta='$_POST[cuenta]' and pptofutfuenteinv.codigo=pptocuentas.futfuenteinv ".$criterio;
				$_POST[tipocuenta]=3;
			}
			if ($clasifica=='inversion' )
			{
				$sqlr="select pptocuentas.futfuenteinv,pptocuentas.pptoinicial,pptofutfuenteinv.nombre from pptocuentas,pptofutfuenteinv where pptocuentas.cuenta='$_POST[cuenta]' and pptofutfuenteinv.codigo=pptocuentas.futfuenteinv ".$criterio;
				$_POST[tipocuenta]=4;
			}
			// echo $sqlr." ".$clasifica;
			$res=mysql_query($sqlr,$linkbd);
			$row=mysql_fetch_row($res);
			if($row[1]!='' || $row[1]!=0)
			{
				// $_POST[cfuente]=$row[0];
				// $_POST[fuente]=buscafuenteppto($_POST[cuenta],$vigusu);;
				$_POST[valor]=0;			  
				//$_POST[saldo]=$row[1];			  
			}
			else
			{
				// $_POST[cfuente]="";
	  			// $_POST[fuente]=""; 
				/* $_POST[cfuente]="";
	  			   $_POST[fuente]="";
				   $_POST[valor]="";			  
				   $_POST[saldo]="";
				   $_POST[cuenta]="";			  
				   $_POST[ncuenta]="";			  */
			}  
		}
		else
		{
			$_POST[ncuenta]="";	
			$_POST[fuente]="";				   
			$_POST[cfuente]="";				   			   
			$_POST[valor]="";
			$_POST[saldo]="";
		}
		echo "<script>document.form2.bc.value='';</script>";
	}

?>

	<form name="form2" method="post" action="teso-superavit.php" enctype="multipart/form-data">
		<input type="hidden" name="oculto" id="oculto" value="<?php echo $_POST[oculto]?>" />
		<table class="inicio" align="center" width="80%" >
			<tr >
				<td style="width:95%;" class="titulos" colspan="6">.: Superavit </td>
				<td style="width:5%;" class="cerrar" ><a href="presu-principal.php">Cerrar</a></td>
			</tr>
			<tr  >
				<td class="saludo1" style="width:5%;">Vigencia:</td>
				<td style="width:5%;">
					<input  style="width:100%;" type="text" name="vigencia" value="<?php echo $_POST[vigencia] ?>" readonly>
				</td>
				<td  class="saludo1" style="width:5%;">Numero:</td>
				<td style="width:8%;">
					<input style="width:100%;" name="numero" type="text" id="numero" value="<?php echo $_POST[numero] ?>"  readonly></td>
				<td class="saludo1" style="width:5%;">Fecha:        </td>
				<td>
					<input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY"  value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">         
					<a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>        <input type="hidden" name="chacuerdo" value="1">		  
				</td>
			</tr>
			<tr>
				<td class="saludo1">Objeto:</td>
				<td style="width:100%;" colspan="6">
					<input name="objeto" type="text" id="objeto" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[objeto]?>" style="width:60%">
				</td>
			</tr>
		</table>
		<table  align="center" class="inicio" >
				<tr >
					<td class="titulos" colspan="7">.: Importar Cuentas Superavit</td>
				</tr>   
				<tr> 
					<td width="15%"  class="saludo1">Seleccione Archivo: </td>
					<td width="15%" >
						<input type="file" name="archivotexto" id="archivotexto">
					</td>
					<td colspan="7" >
						<input type="button" name="generar" value="Subir Archivo" onClick="validaimport()">
						<input type="hidden" name="import" id="import" value="<?php echo $_POST[import] ?>" >
						<input type="button" name="protocolo" value="Descargar Formato de Importacion" onClick="protocoloimport()">
					</td>
				</tr>                  
			</table>
		<table class="inicio">
			<tr>
				<td colspan="8" class="titulos">Cuentas
				</td>
			</tr>
			<tr>
				<td  class="saludo1" style="width:5%;">Cuenta:</td>
				<td  valign="middle" style="width:10%;" >
					 <input type="text" id="cuenta" name="cuenta" style="width:80%;" onKeyUp="return tabular(event,this)" onBlur="buscacta(event)" value="<?php echo $_POST[cuenta]?>" onClick="document.getElementById('cuenta').focus();document.getElementById('cuenta').select();">
					 <input type="hidden" value="" name="bc" id="bc"><a href="#" onClick="mypop=window.open('cuentasppto-ventana.php?ti=1','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>
				</td>
				<td style="width:20%;" colspan="3">
					<input name="ncuenta" id="ncuenta" type="text" style="width:100%;" value="<?php echo $_POST[ncuenta]?>" readonly>
				</td>
				<td style="width:60%;"></td>
			</tr>
			<tr> 
				<td class="saludo1" style="width:5%;">Valor:
				</td>
				<td style="width:10%;">
					<input id="valor" name="valor" type="text" value="<?php echo $_POST[valor]?>" onKeyPress="javascript:return solonumeros(event)" onKeyUp="" onKeyDown="return tabular(event,this)" onBlur=""> 
				</td>		 
				<td class="saludo1" style="width:5%;">Saldo:
				</td>
				<td style="width:10%;">
					<input name="saldo" type="text" id="saldo" onKeyPress="javascript:return solonumeros(event)" style="width:100%;" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[saldo]?>" readonly> 
				</td>
				<td style="width:5%;">
					<input type="button" name="agregar" id="agregar" value="   Agregar   " onClick="agregardetalle()" >
					<input type="hidden" value="0" name="agregadet">
				</td>
			</tr>  
		</table>
		<table class="inicio" width="99%">
			<tr>
				<td class="titulos" colspan="5">Detalle CDP</td>
			</tr>
			<tr>
				<td class="titulos2">Cuenta</td>
				<td class="titulos2">Nombre Cuenta</td>
				<td class="titulos2">Fuente</td>
				<td class="titulos2">Valor</td>
				<td class="titulos2"><img src="imagenes/del.png"></td>
			</tr>
		<?php 
		if($_POST[import]==1){
					unset($_POST[dcuentas][$posi]);
					unset($_POST[dncuentas][$posi]);
					unset($_POST[dcfuentes][$posi]);
					unset($_POST[dgastos][$posi]);
							 
					$_POST[dcuentas]= array_values($_POST[dcuentas]); 
					$_POST[dncuentas]= array_values($_POST[dncuentas]); 
					$_POST[dcfuentes]= array_values($_POST[dcfuentes]); 
					$_POST[dgastos]= array_values($_POST[dgastos]); 
					if(is_uploaded_file($_FILES['archivotexto']['tmp_name']))
					{
						$archivo = $_FILES['archivotexto']['name'];
						$archivoF = "$archivo";
								if(move_uploaded_file($_FILES['archivotexto']['tmp_name'],$archivoF))
						{
							$subio=1;
						}else{
							echo "El archivo NO se subio correctamente ";
						}
					}
					
					require_once 'PHPExcel/Classes/PHPExcel/IOFactory.php';
					
					$objPHPExcel = PHPExcel_IOFactory::load("$archivo");
					
					foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
						$worksheetTitle     = $worksheet->getTitle();
						$highestRow         = $worksheet->getHighestRow(); // e.g. 10
						$highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
						$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
						$nrColumns = ord($highestColumn) - 64;
						for ($row = 3; $row <= $highestRow; ++ $row) {
							
							echo "<tr class='$co'>";
							$cell = $worksheet->getCellByColumnAndRow(0, $row);
							$val1 = trim($cell->getValue());
							//$val1 = str_replace(".", "",$val1);
							$cell = $worksheet->getCellByColumnAndRow(1, $row);
							$val2 = utf8_decode($cell->getValue());
							$cell = $worksheet->getCellByColumnAndRow(2, $row);
							$val3 = $cell->getValue();
							$cell = $worksheet->getCellByColumnAndRow(3, $row);
							$val4 = $cell->getValue();
							$_POST[dcuentas][]=$val1;
							$_POST[dncuentas][]=$val2;
							$_POST[dcfuentes][]=$val3;
							if($val4=='' || $val4=='0')
	 	 					{
								$_POST[dgastos][]=0;
							}else{
								$_POST[dgastos][]=$val4;
							}
						}
						ECHO count($_POST[dcuentas]);
					}
					?>
						<script>
							document.form2.import.value=2;
						</script>
					<?php
				}
		if ($_POST[elimina]!='')
		{ 
			$posi=$_POST[elimina];
			//echo "<TR><TD>ENTROS :".$_POST[elimina]." $posi</TD></TR>";
			$cuentagas=0;
			$cuentaing=0;
			$diferencia=0;
			// array_splice($_POST[dcuentas],$posi, 1);
			unset($_POST[dcuentas][$posi]);
			unset($_POST[dncuentas][$posi]);
			unset($_POST[dgastos][$posi]);		 		 		 		 		 
			unset($_POST[dcfuentes][$posi]);		 		 
			unset($_POST[dfuentes][$posi]);		 
			$_POST[dcuentas]= array_values($_POST[dcuentas]); 
			$_POST[dncuentas]= array_values($_POST[dncuentas]); 
			$_POST[dgastos]= array_values($_POST[dgastos]); 
			$_POST[dfuentes]= array_values($_POST[dfuentes]); 		 		 		 		 
			$_POST[dcfuentes]= array_values($_POST[dcfuentes]); 		 	
			$_POST[elimina]='';	 		 		 		 
		}	 
		if ($_POST[agregadet]=='1')
		{
			$ch=esta_en_array($_POST[dcuentas],$_POST[cuenta]);
			if($ch!='1')
			{			 
				$cuentagas=0;
				$cuentaing=0;
				$diferencia=0;
				$_POST[dcuentas][]=$_POST[cuenta];
				$_POST[dncuentas][]=$_POST[ncuenta];
				$_POST[dfuentes][]=$_POST[fuente];
				$_POST[dcfuentes][]=$_POST[cfuente];		 
				$_POST[dgastos][]=$_POST[valor];
				$_POST[agregadet]=0;
		?>
		<script>
		  	//document.form2.cuenta.focus();	
			document.form2.cuenta.value="";
			document.form2.ncuenta.value="";
			document.form2.fuente.value="";
			document.form2.cfuente.value="";				
			//document.form2.cuenta.select();
		  	document.form2.cuenta.focus();	
		</script>
		<?php
			}
			else
			{
		?>
		<script>
		  	alert('Ya existe este Rubro en los detalles');
		</script>
		<?php
			}
		}
		?>
            <input type='hidden' name='elimina' id='elimina'>
        <?php
			 //echo "<TR><TD>t :".$_POST[dcuentas][0]."</TD></TR>";
			for ($x=0;$x<count($_POST[dcuentas]);$x++)
			{
				echo "
				<tr>
					<td class='saludo2'>
						<input name='dcuentas[]' value='".$_POST[dcuentas][$x]."' type='text' size='20' readonly>
					</td>
					<td class='saludo2'>
						<input name='dncuentas[]' value='".$_POST[dncuentas][$x]."' type='text' size='80' readonly>
					</td>
					<td class='saludo2'>
						<input name='dcfuentes[]' value='".$_POST[dcfuentes][$x]."' type='hidden'>
						<input name='dfuentes[]' value='".$_POST[dfuentes][$x]."' type='text' size='45' readonly>
					</td>
					<td class='saludo2'>
						<input name='dgastos[]' value='".$_POST[dgastos][$x]."' type='text' size='15' onDblClick='llamarventana(this,$x)' readonly>
					</td>
					<td class='saludo2'>
						<a href='#' onclick='eliminar($x)'><img src='imagenes/del.png'></a>
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
				$_POST[letras]=$resultado." Pesos";
			}
			echo "<tr><td ></td><td colspan='1'></td><td class='saludo1'></td><td class='saludo1'><input id='cuentagas' name='cuentagas' value='$_POST[cuentagas]' readonly><input id='cuentagas2' name='cuentagas2' value='$_POST[cuentagas2]' type='hidden'><input id='letras' name='letras' value='$_POST[letras]' type='hidden'></td></tr>";
			echo "<tr><td class='saludo1'>Son:</td><td class='saludo1' colspan= '4'>$resultado</td></tr>";
		?>
		</table>
    </form>
	<?php
	//***************PARTE PARA INSERTAR Y ACTUALIZAR LA INFORMACION
	$oculto=$_POST['oculto'];
	if($_POST[oculto]=='2')
	{
		ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
		$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
		$bloq=bloqueos($_SESSION[cedulausu],$fechaf);
		if($bloq>=1)
		{
			$linkbd=conectar_bd();
			$sqlr="select count(*) from pptosuperavit where vigencia='$_POST[vigencia]' and consvigencia=$_POST[numero]";
			$res=mysql_query($sqlr,$linkbd);
			//echo $sqlr;
			while($r=mysql_fetch_row($res))
			{
				$numerorecaudos=$r[0];
			}
			if($numerorecaudos==0)
			{
				$nr="1";	 	
				//************** modificacion del presupuesto **************
				$sqlr="insert into pptocomprobante_cab(numerotipo,tipo_comp,fecha,concepto,vigencia,total_debito,total_credito,diferencia,estado) values($_POST[numero],24,'$fechaf','$_POST[objeto]',$_POST[vigencia],'$_POST[cuentagas2]',0,0,'1')";
				mysql_query($sqlr,$linkbd);
				$sqlr="insert into pptosuperavit (vigencia,consvigencia,fecha,valor,estado,objeto) values($_POST[vigencia],$_POST[numero],'$fechaf','$_POST[cuentagas2]','S','$_POST[objeto]')";
				// echo $sqlr."<br>";
				if (!mysql_query($sqlr,$linkbd))
				{
					echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b> <img src='imagenes\alert.png'> </b></font></p>";
	//	 			$e =mysql_error($respquery);
					echo "Ocurrió el siguiente problema:<br>";
					//echo htmlentities($e['message']);
					echo "<pre>";
					///echo htmlentities($e['sqltext']);
					// printf("\n%".($e['offset']+1)."s", "^");
					echo "</pre></center></td></tr></table>";
				}
				else
				{
					echo "<table class='inicio'><tr><td class='saludo1'>Se ha almacenado el Superavit con Exito <img src='imagenes\confirm.png'></center></td></tr></table>";
				}
				//echo count($_POST[dcuentas]);
				for ($x=0;$x<count($_POST[dcuentas]);$x++)
				{
					$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values('".$_POST[dcuentas][$x]."','','Superavit','".$_POST[dgastos][$x]."',0,'1','$_POST[vigencia]',24,$_POST[numero],1,'','','$fechaf')";
					mysql_query($sqlr,$linkbd); 				
					$sqlr="insert into pptosuperavit_detalle (vigencia,consvigencia,cuenta,valor,estado) values('$_POST[vigencia]','$_POST[numero]','".$_POST[dcuentas][$x]."',".$_POST[dgastos][$x].",'S')";
					$res=mysql_query($sqlr,$linkbd);
					//echo $sqlr."<br>";
				}
			}
			else
			{
				echo "<table class='inicio'><tr><td class='saludo1'><center>Ya Existe un Superavit con este Numero <img src='imagenes/alert.png'></center></td></tr></table>";
			}
		}
		else
		{
			echo "<div class='inicio'><img src='imagenes\alert.png'> No Tiene los Permisos para Modificar este Documento</div>";	
		}
	}//*** if de control de guardado
?> 
</td></tr>     
</table>
</body>
</html>