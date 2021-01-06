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
<html xmlns="http://www.w3.org/1999/xhtml">
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

if (document.form2.vigencia.value!='' && document.form2.fecha.value!='' && document.form2.acuerdo.value!='')
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

function validar(formulario)
{
//document.form2.action="presu-adicioningver.php";
document.form2.submit();
}

function validar2(formulario)
{
document.form2.chacuerdo.value=2;
document.form2.action="presu-adicioningver.php";
document.form2.submit();
}

function buscacta(e)
 {
if (document.form2.cuenta.value!="")
{
 document.form2.bc.value=document.form2.tipocta.value;
 document.form2.submit();
 }
 }

function agregardetalle()
{
 vc=document.form2.valorac2.value;
if(document.form2.cuenta.value!="" && document.form2.tipomov.value!="" && document.form2.tipocta.value!="" && document.form2.valor.value>=0 )
{ 
 tipoc=document.form2.tipocta.value;
 switch (tipoc)
 {
   case '1':
     suma=parseFloat(document.form2.valor.value)+parseFloat(document.form2.cuentaing2.value);
 		if(suma<=vc)
  			{
				document.form2.agregadet.value=1;
//				document.form2.chacuerdo.value=2;
				document.form2.submit();
				
  			}
			else
	 			{
	 			alert("El Valor supera el Acto Administrativo: "+suma);
				 }
	break;
	case '2':
	suma=parseFloat(document.form2.valor.value)+parseFloat(document.form2.cuentagas2.value);
 		if(suma<=vc)
  			{
				document.form2.agregadet.value=1;
	//			document.form2.chacuerdo.value=2;
				document.form2.submit();
  			}
			else
	 			{
	 			alert("El Valor supera el Acto Administrativo: "+suma);
				 }
	break;
	}
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

function finaliza()
 {
 if (document.form2.valorac2.value==document.form2.cuentagas2.value && document.form2.valorac2.value==document.form2.cuentaing2.value)
  {
  if (confirm("Confirme Guardando el Documento, al completar el Proceso"))
  {
	  document.form2.fin.checked=true; 
  } 
  else
  document.form2.fin.checked=false; 
  }
  else 
  {
   alert("El Total del Acto Administrativo no es igual al de Ingresos y/o Gastos");
    document.form2.fin.checked=false; 
  }
 }

function pdf()
{
document.form2.action="pdfpptoadga.php";
document.form2.target="_BLANK";
document.form2.submit(); 
document.form2.action="";
document.form2.target="";
}

function capturaTecla(e){ 
var tcl = (document.all)?e.keyCode:e.which;
if (tcl==115){
alert(tcl);
return tabular(e,elemento);
}
}

			function adelante(){
				if(document.form2.siguiente.value!=''){
					location.href="presu-cargaentidadesver.php?idac="+document.form2.siguiente.value;
				}
			}
		
			function atrasc(){
				if(document.form2.anterior.value!=''){
					location.href="presu-cargaentidadesver.php?idac="+document.form2.anterior.value;
				}
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
          <td colspan="3" class="cinta"><a href="presu-cargaentidades.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a><a href="#" onClick="" class="mgbt"><img src="imagenes/guardad.png" title="Guardar" /></a><a href="presu-buscarcargaentidades.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a><a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a><img src="imagenes/iratras.png" title="Atr&aacute;s" onClick="location.href='presu-buscarcargaentidades.php'" class="mgbt"/></td>
        </tr></table> 
<?php
$vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
$vigencia=$vigusu;
if(!$_POST[oculto])
{
	$linkbd=conectar_bd();

	$sqlr="select *from pptoacuerdos where (pptoacuerdos.valoradicion>0) or (pptoacuerdos.valorreduccion>0) and pptoacuerdos.tipo='M' ORDER BY vigencia DESC, consecutivo ";
	$res=mysql_query($sqlr,$linkbd);
	$contacu=0;
	$_POST[actual]=$_GET[idac];
	$_POST[unidad]=$_GET[uni];
	$_POST[fecha]=$_GET[fec];
	$_POST[trimestre]=$_GET[trime];
	$_POST[vigencia]=$_GET[vig];

	$sqlr1="select *from entidadesgastos where entidadesgastos.unidad='$_POST[unidad]' and entidadesgastos.vigencia='$_POST[vigencia]' and entidadesgastos.trimestre='$_POST[trimestre]' and entidadesgastos.fecha='$_POST[fecha]' ORDER BY cuenta";
	//echo $sqlr1;
	$res1=mysql_query($sqlr1,$linkbd);
	$con=0;
	while ($row1=mysql_fetch_row($res1))
	{		
		$_POST[dcuentas][$con]=$row1[0];	
		$_POST[inicial][$con]=$row1[2];
		$_POST[adicion][$con]=$row1[3];
		$_POST[reduccion][$con]=$row1[4];
		$_POST[creditos][$con]=$row1[5];
		$_POST[contracreditos][$con]=$row1[6];
		$_POST[definitivo][$con]=$row1[7];
		$_POST[disponibilidad][$con]=$row1[8];
		$_POST[compromiso][$con]=$row1[9];
		$_POST[obligacion][$con]=$row1[10];
		$_POST[compromisoejecu][$con]=$row1[11];
		$_POST[pago][$con]=$row1[12];
		$_POST[cxp][$con]=$row1[13];
		$_POST[saldo][$con]=$row1[14];
		$con++;
	}
	}
?>
 <form name="form2" method="post" action="">
 	<input type="hidden" name="hab" id="hab" value="<?php echo $_POST[hab] ?>">
    <table class="inicio" align="center" width="80%" >
      	<tr >
        	<td class="titulos" style="width:95%;" colspan="2">.: Consolidacion Entidad - Ejecucion Gastos</td>
        	<td  class="cerrar" style="width:5%;"><a href="presu-principal.php">Cerrar</a></td>
      	</tr>
      	<tr>
      		<td style="width:75%;">
      			<table>
      				<tr  >
			  			<td style="width:10%;" class="saludo1">Unidad</td>
				  		<td style="width:10%;">
				  			<select name="cc" onKeyUp="return tabular(event,this)">
								<?php
									$sqlr="SELECT * FROM pptouniejecu WHERE estado='S' AND entidad='N' AND id_cc='$_POST[unidad]'";
									$res=mysql_query($sqlr,$linkbd);
									while ($row =mysql_fetch_row($res)) 
									{
										if($row[0]==$_POST[cc]){echo "<option value=$row[0] SELECTED>$row[0] - $row[1]</option>";}
										else {echo "<option value=$row[0]>$row[0] - $row[1]</option>";}
									}	 	
								?>
							</select>
						</td>
			  			<td style="width:5%;" class="saludo1">Fecha:        </td>
		        		<td style="width:7%;">
		        			<input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" style="width:100%;" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" readonly>
		        			       
		        		</td>
				 		<td style="width:12%;" class="saludo1">Trimestre:</td>
				 		<td style="width:25%;" valign="middle" >
				  			<select name="trimestre" id="trimestre" disabled>
								<option value="1" <?php if($_POST[trimestre]=="1"){echo "SELECTED"; } ?> >Enero-Marzo</option>
								<option value="2" <?php if($_POST[trimestre]=="2"){echo "SELECTED"; } ?>>Abril-Junio</option>
								<option value="3" <?php if($_POST[trimestre]=="3"){echo "SELECTED"; } ?> >Julio-Septiembre</option>
								<option value="4" <?php if($_POST[trimestre]=="4"){echo "SELECTED"; } ?>>Octubre-Diciembre</option>
							</select>
						</td>
				  		<td style="width:8%;" class="saludo1">Vigencia:</td>
				  		<td style="width:10%;">
				  			<input type="text" id="vigencia" name="vigencia" onKeyPress="javascript:return solonumeros(event)" style="width:100%;" onKeyUp="return tabular(event,this)"  value="<?php echo $_POST[vigencia]?>" onClick="document.getElementById('tipocta').focus(); document.getElementById('tipocta').select();" readonly>
				  		</td>
		       		</tr>
      			</table>
      		</td>
      		<td colspan="3" style="width:25%; background:url(imagenes/siglas.png); background-repeat:no-repeat; background-position:right; background-size: 100% 100%;" >
      			
      		</td>
      	</tr>
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
			//**** busca cuenta
			if($_POST[bc]!='')
			 {

			  $nresul=buscacuentapres($_POST[cuenta],$_POST[tipocta]);
			  if($nresul!='')
			   {
			  $_POST[ncuenta]=$nresul;
  			  ?>
			  <script>
			  document
			  document.getElementById('valor').focus();
			  document.getElementById('valor').select();
			  </script>
			  <?php
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
		<div class="subpantalla" style="height:50.9%; width:99.6%; overflow-x:hidden;">
		<table class="inicio" width="99%">
        <tr>
          <td class="titulos" colspan="14">Detalle Comprobantes          </td>
        </tr>
		<tr>
			<td class="titulos2">Cuenta</td>
			<td class="titulos2">Inicial</td>
			<td class="titulos2">Adicion</td>
			<td class="titulos2">Reduccion</td>
			<td class="titulos2">Creditos</td>
			<td class="titulos2">Contra credito</td>
			<td class="titulos2">Definitivo</td>
			<td class="titulos2">Disponibilidad</td>
			<td class="titulos2">Compromiso</td>
			<td class="titulos2">Obligacion</td>
			<td class="titulos2">Compromiso en ejecucion</td>
			<td class="titulos2">Pago</td>
			<td class="titulos2">CxP</td>
			<td class="titulos2">Saldo</td>
		</tr> 
		<?php 
		  $iter='zebra1';
		  $iter2='zebra2';
		 for ($x=0;$x< count($_POST[dcuentas]);$x++)
		 {
		 
		 echo "<tr class='$iter'>
			<td><input name='dcuentas[]' value='".$_POST[dcuentas][$x]."' type='text' style='width:100%;' readonly></td>
			<td><input name='inicial[]' value='".$_POST[inicial][$x]."' type='text' style='width:100%;' readonly></td>
			<td><input name='adicion[]' value='".$_POST[adicion][$x]."' type='text' style='width:100%;' readonly></td>
			<td><input name='reduccion[]' value='".$_POST[reduccion][$x]."' type='text' style='width:100%;' readonly></td>
			<td><input name='creditos[]' value='".$_POST[creditos][$x]."' type='text' style='width:100%;' readonly></td>
			<td><input name='contracreditos[]' value='".$_POST[contracreditos][$x]."' type='text' style='width:100%;' readonly></td>
			<td><input name='definitivo[]' value='".$_POST[definitivo][$x]."' type='text' style='width:100%;' readonly></td>
			<td><input name='disponibilidad[]' value='".$_POST[disponibilidad][$x]."' type='text' style='width:100%;' readonly></td>
			<td><input name='compromiso[]' value='".$_POST[compromiso][$x]."' type='text' style='width:100%;' readonly></td>
			<td><input name='obligacion[]' value='".$_POST[obligacion][$x]."' type='text' style='width:100%;' readonly></td>
			<td><input name='compromisoejecu[]' value='".$_POST[compromisoejecu][$x]."' type='text' style='width:100%;' readonly></td>
			<td><input name='pago[]' value='".$_POST[pago][$x]."' type='text' style='width:100%;' readonly></td>
			<td><input name='cxp[]' value='".$_POST[cxp][$x]."' type='text' style='width:100%;' readonly></td>
			<td><input name='saldo[]' value='".$_POST[saldo][$x]."' type='text' style='width:100%;' readonly></td>
		</tr>";
		  	$aux=$iter;
	 		$iter=$iter2;
	 		$iter2=$aux;
		 }
		 
		?>
		</table></div>
    </form>
</td></tr>     
</table>
</body>
</html>