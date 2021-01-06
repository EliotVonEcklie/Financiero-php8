<?php //V 1000 12/12/16 ?> 
<?php
require"comun.inc";
require"funciones.inc";
session_start();
header("Cache-control: private"); // Arregla IE 6
date_default_timezone_set("America/Bogota");
//**niveles menu: Administracion (0) - Consultas (1) - Herramientas (2) - Reportes (3)
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html"  />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<title>:: Spid - Contabilidad</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js"></script>
<script>
//************* ver reporte ************
//***************************************
function guardar()
{
	if( document.form2.codigo.value!="")
	{
  	if (confirm("Esta Seguro de Guardar"))
  	{
	  document.form2.oculto.value=2;
	  document.form2.submit();
	}
	}
	else{alert('Faltan datos para completar el registro');document.form2.codigo.focus();document.form2.codigo.select();}
}
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

function buscactac(e)
 {
if (document.form2.cuentacerrar.value!="")
{
 document.form2.bcr.value='1';
 document.form2.submit();
 }
 }

function buscactacr(e)
 {
if (document.form2.cuentacierre.value!="")
{
//alert();
 document.form2.bcre.value='1';
 document.form2.submit();
 }
 }

function buscactat(e)
 {
if (document.form2.cuentas.value!="")
{
 document.form2.bct.value='1';
 document.form2.submit();
 }
 }

function agregardetalle()
{
//alert('valor'+valordeb);
if(document.form2.cuentas.value!="")
 {
document.form2.agregadet.value=1;
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
document.form2.elimina.value=variable;
//eli=document.getElementById(elimina);
vvend=document.getElementById('elimina');
//eli.value=elimina;
vvend.value=variable;
document.form2.submit();
}
}
</script>
<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
    <tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
    <tr><?php menu_desplegable("cont");?></tr>
	<tr>
		<td colspan="3" class="cinta">
			<a href="cont-conceptosexogena.php" ><img src="imagenes/add.png" class="mgbt" title="Nuevo" /></a>
			<a href="#" onClick="guardar()"><img src="imagenes/guarda.png" class="mgbt" title="Guardar" /></a>
			<a href="cont-buscaconceptosexogena.php" > <img src="imagenes/busca.png" class="mgbt" title="Buscar" /></a>
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" class="mgbt" title="nueva ventana"></a>
			<a href="cont-parametrosexogena.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
		</td>
	</tr>
</table>
<tr>
<td>
<?php
$linkbd=conectar_bd();
$vigusu=vigencia_usuarios($_SESSION[cedulausu]); 

	//echo  "oc".$_POST[oculto];
   if($_POST[oculto]=="")
   {	
    $_POST[dcuentas]=array();
    $_POST[dncuentas]=array();
    $_POST[dtipos]=array();	
	$sqlr="select * from  contexogenaconce_cab where codigo='$_GET[cod]'";
	$res=mysql_query($sqlr,$linkbd);
	while($row=mysql_fetch_row($res))
	 {
		$_POST[codigo]=$row[0];
		$_POST[nombre]=$row[1];
		$_POST[estado]=$row[2];			
	 }
	$sqlr="select * from  contexogenaconce_det where codigo='$_GET[cod]'";
	$res=mysql_query($sqlr,$linkbd);
	while($row=mysql_fetch_row($res))
	 {
		$_POST[dcuentas][]=$row[1];
    	$_POST[dncuentas][]=buscacuenta($row[1]);
	    $_POST[dtipos][]=$row[2];	
	 }
	}
	if($_POST[bct]=='1')
			 {
			  $nresul=buscacuenta($_POST[cuentas]);
			  if($nresul!='')
			   {
			  $_POST[ncuentas]=$nresul;
  	
			  }
			 else
			 {
			  $_POST[ncuentas]="";
			  }
			 }
?>
    <form name="form2" method="post" action="cont-editaconceptosexogena.php">
      <table class="inicio">  
     <tr >
        <td class="titulos"  colspan="6">:: Conceptos Exogena</td><td width="5%" class="cerrar" ><a href="cont-principal.php">Cerrar</a></td>
      </tr>     
      <tr  >
		<td  class="saludo1">Codigo:</td>
          <td  valign="middle" ><input type="text" id="codigo" name="codigo" size="10" onKeyPress="javascript:return solonumeros(event)" 		  onKeyUp="return tabular(event,this)" value="<?php echo $_POST[codigo]?>" onClick="document.getElementById('numero').focus();document.getElementById('numero').select();" readonly></td>
		 <td  class="saludo1">Nombre:</td>
         <td  valign="middle" ><input type="text" id="nombre" name="nombre" size="80" 
	onKeyUp="return tabular(event,this)" value="<?php echo $_POST[nombre]?>" onClick="document.getElementById('acuerdo').focus();document.getElementById('acuerdo').select();"></td>
    	 <td  class="saludo1">Estado:</td>
         <td  valign="middle" ><input type="text" id="estado" name="estado" size="5" value="<?php echo $_POST[estado]?>" readonly>
    </tr>
       </table>
        <table class="inicio">  
     <tr >
        <td class="titulos"  colspan="6">:: Parametros de Cuentas</td><td  class="cerrar" ><a href="cont-principal.php">Cerrar</a></td>
      </tr>  
        <tr  >
        <td  class="saludo1">:: Cuenta:
       </td>
        <td ><input type="text" id="cuentas" name="cuentas" size="8" onKeyPress="javascript:return solonumeros(event)" 
		  onKeyUp="return tabular(event,this)" onBlur="buscactat(event)" value="<?php echo $_POST[cuentas]?>" onClick="document.getElementById('cuentas').focus();document.getElementById('cuentas').select();" placeholder='cuenta contable'><input type="hidden" value="0" name="bct"><a href="#" onClick="mypop=window.open('cuentasgral-ventana.php?vigencia=<?php echo $_SESSION[vigencia]?>&objeto=cuentas&nobjeto=ncuentas','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>  </td><td><input id="ncuentas" name="ncuentas" type="text" value="<?php echo $_POST[ncuentas]?>" size="70" readonly></td><td class="saludo1">Tipo:</td><td><select name="debcred">
		   <option value="1" <?php if($_POST[debcred]=='1') echo "SELECTED"; ?>>Debito</option>
          <option value="2" <?php if($_POST[debcred]=='2') echo "SELECTED"; ?>>Credito</option>
            <option value="3" <?php if($_POST[debcred]=='3') echo "SELECTED"; ?>>Saldo</option>
		  </select></td><td> <input type="button" name="agrega" value="  Agregar  " onClick="agregardetalle()" ><input type="hidden" value="0" name="agregadet"><input name="oculto" type="hidden" id="oculto" value="1" ></td>
        </tr>   
        </table>
        <div class="subpantalla">
        <table class="inicio">
        <tr><td class="titulos" colspan="4">Detalle Cuentas Concepto</td></tr>
        <tr><td class="titulos2">Cuenta</td><td class="titulos2">Nombre Cuenta</td><td class="titulos2">Tipo</td><td class="titulos2"><img src="imagenes/del.png"><input type='hidden' name='elimina' id='elimina'></td></tr>   
        <?php
		// echo "bcr".$_POST[bcr];
		//  echo "bcre".$_POST[bcre];
		// echo "bct".$_POST[bct];
		 if($_POST[bct]==1)
			 {
			  $nresul=buscacuenta($_POST[cuentas]);
			  if($nresul!='')
			   {
			  $_POST[ncuentas]=$nresul;
  			  ?>
			  <script>			  
			  document.getElementById('ncuentas').value='<?php echo $_POST[ncuentas]?>';
			  document.getElementById('bct').value='';
			  </script>
			  <?php
			  }
			 else
			 {
			  $_POST[ncuentas]="";
//			  	 echo "bcr--".$_POST[bcr];
	//	  echo "bcre--".$_POST[bcre];
		// echo "bct--".$_POST[bct];
			  ?>
			  <script>alert("Cuenta Incorrecta ");document.form2.cuentas.focus();</script>
			  <?php
			  }
			 } 
			 
		if ($_POST[elimina]!='')
		 { 
		 //echo "<TR><TD>ENTROS :".$_POST[elimina]."</TD></TR>";
		 $posi=$_POST[elimina];		 
		 unset($_POST[dcuentas][$posi]);
		 unset($_POST[dncuentas][$posi]);
		 unset($_POST[dtipos][$posi]);		 
		 $_POST[dcuentas]= array_values($_POST[dcuentas]); 
		 $_POST[dncuentas]= array_values($_POST[dncuentas]); 		 
		 $_POST[dtipos]= array_values($_POST[dtipos]); 		 
		 }
		if ($_POST[agregadet]=='1')
		 {
		 $_POST[dcuentas][]=$_POST[cuentas];
		 $_POST[dncuentas][]=$_POST[ncuentas];
		 $_POST[dtipos][]=$_POST[debcred];	
		 //echo "numero ".$_POST[cuentacierre];	 		 
		 $_POST[agregadet]=0;
		 }
		$numctas=count($_POST[dcuentas]);
		//echo "numero ".$numctas;
		$co="saludo1";
		$co2="saludo2";		
		$tipos=array('','Debito','Credito','Saldos');
		for ($x=0;$x<$numctas;$x++)
		 {
		echo "<tr><td class='$co'><input type='hidden' name='dcuentas[]' value='".$_POST[dcuentas][$x]."'> ".$_POST[dcuentas][$x]."</td><td class='$co'><input type='hidden' name='dncuentas[]' value='".$_POST[dncuentas][$x]."'> ".$_POST[dncuentas][$x]."</td><td class='$co'><input type='hidden' name='dtipos[]' value='".$_POST[dtipos][$x]."'> ".$tipos[$_POST[dtipos][$x]]."</td><td class='$co'><a href='#' onclick='eliminar($x)'><img src='imagenes/del.png'></a></td></tr>";			 
				$aux=$co;
				$co=$co2;
				$co2=$aux;								
		 }
		?>     
        </table>
        </div>
    </form>
  <?php
  

$oculto=$_POST['oculto'];
if($_POST[oculto]=="2")
{
?>
<div class="subpantallac">
<?php	
$linkbd=conectar_bd();

$sqlr="update contexogenaconce_cab set nombre='".$_POST[nombre]."' where codigo='".$_POST[codigo]."'";
if (mysql_query($sqlr,$linkbd))
	{
		// echo "<div><div>sqlr:".$sqlr."</div></div>";

	$numctas=count($_POST[dcuentas]);
	$sqlr="delete from contexogenaconce_det where codigo='".$_POST[codigo]."'";
	mysql_query($sqlr,$linkbd);
		//echo "numero ".$numctas;
for ($x=0;$x<$numctas;$x++)
 {
// echo "<div><div>sqlr:".$sqlr."</div></div>";
  $sqlr="insert into contexogenaconce_det (codigo, cuenta, tipo,estado) values ('".$_POST[codigo]."','".$_POST[dcuentas][$x]."','".$_POST[dtipos][$x]."','S') ";
  if (!mysql_query($sqlr,$linkbd))
	{
	 echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
	// $e = mysql_error($respquery);
	 echo "Ocurrió el siguiente problema:<br>";
  	 //echo htmlentities($e['message']);
  	 echo "<pre>".mysql_error($linkbd);
     //echo htmlentities($e['sqltext']);
     //printf("\n%".($e['offset']+1)."s", "^");
     echo "</pre></center></td></tr></table>";
	}
else
 {
  echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha Almacenado el Concepto ".$_POST[dcuentacerrar][$x]."  ".$_POST[dcuentacierre][$x]." ".$_POST[dcuentatras][$x]." <img src='imagenes/confirm.png'></center></td></tr></table>";
 } 
 }
 ?>
 </div>
 <?php
  }
  else
  {
	   echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: $sqlr<br><font color=red><b></b></font></p>";
	// $e = mysql_error($respquery);
	 echo "Ocurrió el siguiente problema:<br>";
  	 //echo htmlentities($e['message']);
  	 echo "<pre>".mysql_error($linkbd);
     //echo htmlentities($e['sqltext']);
     //printf("\n%".($e['offset']+1)."s", "^");
     echo "</pre></center></td></tr></table>";
  }
}
?>
 </td></tr>
<tr><td></td></tr>      
</table>
</body>
</html>