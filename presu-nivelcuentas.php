<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
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
        <link href="css/tabs.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
<script>
function recalcularctas(tipo)
{
	if(tipo==1)
	{
		var diging=document.getElementsByName('digitosi[]');
		var posing=document.getElementsByName('posicionesi[]');
		acumulapos=0;
		//alert('tipo'+diging.length);
		for(x=0;x<diging.length;x++)
		 {
			acumulapos+=parseFloat(diging.item(x).value);			 
			posing.item(x).value=acumulapos;
		 }
	}
	if(tipo==2)
	{
		var diging=document.getElementsByName('digitosg[]');
		var posing=document.getElementsByName('posicionesg[]');
		acumulapos=0;
		//alert('tipo'+diging.length);
		for(x=0;x<diging.length;x++)
		 {
			acumulapos+=parseFloat(diging.item(x).value);			 
			posing.item(x).value=acumulapos;
		 }
	}
 }
//************* genera reporte ************
//***************************************
function guardar()
{

	if (confirm("Esta Seguro de Guardar"))
  	{
  	document.form2.oculto.value=2;
  	document.form2.submit();
  	}
}
function eliminari(variable)
{
if (confirm("Esta Seguro de Eliminar"))
  {
document.form2.eliminai.value=variable;
//eli=document.getElementById(elimina);
vvend=document.getElementById('eliminai');
//eli.value=elimina;
vvend.value=variable;
document.form2.submit();
}
}
function eliminarg(variable)
{
if (confirm("Esta Seguro de Eliminar"))
  {
document.form2.eliminag.value=variable;
//eli=document.getElementById(elimina);
vvend=document.getElementById('eliminag');
//eli.value=elimina;
vvend.value=variable;
document.form2.submit();
}
}

function agregardetallei()
{

				document.form2.agregadeti.value=1;
	//			document.form2.chacuerdo.value=2;
				document.form2.submit();
 
}
function agregardetalleg()
{

				document.form2.agregadetg.value=1;
	//			document.form2.chacuerdo.value=2;
				document.form2.submit();
 
}
</script>
		<?php titlepag();?>
    </head>
    <body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("presu");?></tr>
        <tr>
          <td colspan="3" class="cinta"><a href="presu-nivelcuentas.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a><a href="#" onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png" title="Guardar"/></a><a href="#" onClick="document.form2.submit();" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a><a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td></tr>
        </table>
   <form action="" method="post" enctype="multipart/form-data" name="form2">
<?php

if($_POST[oculto]=='2')
{
$link=conectar_bd();
$cuentaexi=0;
$cuentaexig=0;
$sqlr="delete from nivelesctasgas";
mysql_query($sqlr,$link);
for($x=0;$x<count($_POST[nivelesg]);$x++)
 {
  $sqlr="insert  nivelesctasgas (id_nivel,digitos,estado,posiciones) values (".$_POST[nivelesg][$x].",".$_POST[digitosg][$x].",'S',".$_POST[posicionesg][$x].")";
  if (!mysql_query($sqlr,$link))
			{
			 echo "<table class='inicio'><tr><td class='saludo1'><img src='imagenes\alert.png'> Error no se pudo actualizar $sqlr</td></tr></table>";	
			}
			else
			{
				$cuentaexig+=1;
				}	
 }
 $sqlr="delete from nivelesctasing";
mysql_query($sqlr,$link);
 for($x=0;$x<count($_POST[nivelesi]);$x++)
 {
 $sqlr="insert  nivelesctasing (id_nivel,digitos,estado,posiciones) values (".$_POST[nivelesi][$x].",".$_POST[digitosi][$x].",'S',".$_POST[posicionesi][$x].")";
  if (!mysql_query($sqlr,$link))
			{
			 echo "<table class='inicio'><tr><td class='saludo1'><img src='imagenes\alert.png'> Error no se pudo actualizar $sqlr</td></tr></table>";	
			}
			else
			{
			$cuentaexi+=1;
			}
	}
	echo "<table class='inicio'><tr><td class='saludo1'> Se han actualizado las Niveles de Cuentas <img src='imagenes\confirm.png'></td></tr></table>";	
	?><script >
function recarga() 
{
	var pagina="presu-nivelcuentas.php";
location.href=pagina;
} 
setTimeout ("recarga()", 2000);
</script>
<?php
$check1="checked";
}

if(!$_POST[oculto])
{
	$check1="checked";
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
}
if($_POST[oculto])
{
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
}
?>
   <input type="hidden" value="1" name="oculto">
<div class="tabsctas" style="height:76.5%; width:99.6%;">
   <div class="tab" >
       <input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
	   <label for="tab-1">Cuentas Ingresos</label>
	   <div class="content" style="overflow-x:hidden;">
    <table class="inicio" style="width:30%" >
    <tr >
      <td height="25" colspan="3" class="titulos"  >Niveles Cuentas Ingresos <input name="Agregari" type="button" value=" + " onClick="agregardetallei()" ><input type="hidden" value="0" name="agregadeti" ></td><td class="cerrar" ><a href="presu-principal.php">Cerrar</a></td>
      </tr>
    <tr >
      <td width="76" class="titulos2" >Nivel </td>
      <td width="140" class="titulos2" >Digitos</td>
      <td width="5" class="titulos2" >Posicion</td>
      <td width="5" class="titulos2" ><center><img src="imagenes/del.png" ></center><input type='hidden' name='eliminai' id='eliminai'  ></td>  	
    </tr>
      <?php 		
		if ($_POST[eliminai]!='')
		 { 
		 //echo "<TR><TD>ENTROS :".$_POST[elimina]."</TD></TR>";
		 $posi=$_POST[eliminai];
		 unset($_POST[nivelesi][$posi]);
		 unset($_POST[digitosi][$posi]);
		 unset($_POST[posicionesi][$posi]);		 
		 $_POST[nivelesi]= array_values($_POST[nivelesi]); 
		 $_POST[digitosg]= array_values($_POST[digitosi]); 
		 $_POST[posicionesi]= array_values($_POST[posicionesi]); 		 		 
		 }	
		 //agregar 
		 if ($_POST[agregadeti]=='1')
		 {
		 $indice=count($_POST[nivelesi])+1;
		  $_POST[nivelesi][]= $indice;
		 $_POST[digitosi][]=0 ;
		 $_POST[posicionesi][]=$_POST[posicionesi][$indice] ;
		 $_POST[agregadetg]='0';
		 }
		  ?>
	<?php

//echo $oculto;
if(!$_POST[oculto])
{
$link=conectar_bd();
 $sqlr="Select  * from nivelesctasing   order by id_nivel";
//echo $sqlr;
$resp = mysql_query($sqlr,$link);			
$co='saludo1';
	 $co2='saludo2';	
	 $i=1;
		while ($r =mysql_fetch_row($resp)) 
	    {
		 $negrilla="style='font-weight:bold'";
		 $tipo=$r[2];
    	 ?><tr class="<?php echo $co ?>"><td> <input name="<?php echo 'nivelesi[]';?>" type='text' value="<?php echo $r[0];?>" readonly></td>
    	 <?php 
     	 echo "<td $negrilla><input name='digitosi[]' type='text' size='3' value='".ucwords(strtolower($r[1]))."' onBlur='recalcularctas(1)' onKeyUp='return tabular(event,this) ' onKeyPress='javascript:return solonumeros(event)' ></td>";
  		 echo "<td class='$iter'><input type='text' name='posicionesi[]' size='3' value='".ucwords(strtolower($r[3]))."'  onKeyUp='return tabular(event,this) ' onKeyPress='javascript:return solonumeros(event)' readonly></td>";
		  echo "<td class='$iter'><center><a href='#' onclick='eliminari($x)'><img src='imagenes/del.png'></a></center></td></tr>";
         $aux=$co;
         $co=$co2;
         $co2=$aux;
		 $i=1+$i;
   		}
}
if($_POST[oculto])
{
	
	$co='saludo1';
	 $co2='saludo2';	
	 $i=1;
		for ($x=0;$x<count($_POST[nivelesi]);$x++) 
	    {		
    	 ?>
        <tr class="<?php echo $co ?>"><td><input name="<?php echo 'nivelesi[]';?>" type='text' value="<?php echo $_POST[nivelesi][$x];?>" readonly></td>
    	 <?php 
     	 echo "<td $negrilla><input name='digitosi[]' type='text' size='3' value='".ucwords(strtolower($_POST[digitosi][$x]))."' onBlur='recalcularctas(1)' onKeyUp='return tabular(event,this) ' onKeyPress='javascript:return solonumeros(event)' ></td>";
  		 echo "<td class='$iter'><input type='text' name='posicionesi[]' size='3' value='".ucwords(strtolower($_POST[posicionesi][$x]))."' readonly></td>";
		  if ($x==count($_POST[nivelesi])-1)
		  echo "<td class='$iter'><center><a href='#' onclick='eliminari($x)'><img src='imagenes/del.png'></a></center></td></tr>";
		  else
		  echo "<td class='$iter'></td></tr>";
         $aux=$co;
         $co=$co2;
         $co2=$aux;
		 $i=1+$i;
   		}
}
?>
</table>
</div>
</div>
<div class="tab">
       <input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?>>
       <label for="tab-2">Cuentas Gastos</label>
       <div class="content" style="overflow-x:hidden;"> 
        <table class="inicio" style="width:30%" >
    <tr >
      <td height="25" colspan="3" class="titulos"  >Niveles Cuentas Gastos <input name="Agregarg" type="button" value=" + " onClick="agregardetalleg()" ><input type="hidden" value="0" name="agregadetg"></td><td class="cerrar" ><a href="presu-principal.php">Cerrar</a></td>
      </tr>
    <tr >
      <td width="76" class="titulos2" >Nivel </td>
      <td width="140" class="titulos2" >Digitos</td>
      <td width="5" class="titulos2" >Posicion</td>	  
    <td width="5" class="titulos2" ><center><img src="imagenes/del.png" ></center><input type='hidden' name='eliminag' id='eliminag'  ></td>  	  
    </tr>
    <?php 		
		if ($_POST[eliminag]!='')
		 { 
		 //echo "<TR><TD>ENTROS :".$_POST[elimina]."</TD></TR>";
		 $posi=$_POST[eliminag];
		 unset($_POST[nivelesg][$posi]);
		 unset($_POST[digitosg][$posi]);
		 unset($_POST[posicionesg][$posi]);		 
		 $_POST[nivelesg]= array_values($_POST[nivelesg]); 
		 $_POST[digitosg]= array_values($_POST[digitosg]); 
		 $_POST[posicionesg]= array_values($_POST[posicionesg]); 		 		 
		 }	
		 //agregar 
		 if ($_POST[agregadetg]=='1')
		 {
		$indice=count($_POST[nivelesg])+1;
		  $_POST[nivelesg][]= $indice;
		 $_POST[digitosg][]=0 ;
		 $_POST[posicionesg][]=$_POST[posicionesg][$indice] ;
		 $_POST[agregadetg]='0';
		 }
		  ?>
	<?php

if(!$_POST[oculto])
{

$link=conectar_bd();
 $sqlr="Select  * from nivelesctasgas   order by id_nivel";
//echo $sqlr;
$resp = mysql_query($sqlr,$link);			
$co='saludo1';
	 $co2='saludo2';	
	 $i=1;
		while ($r =mysql_fetch_row($resp)) 
	    {
		 $negrilla="style='font-weight:bold'";
		 $tipo=$r[2];
    	 ?><tr class="<?php echo $co ?>" ><td><input name="<?php echo 'nivelesg[]';?>" type='text' value="<?php echo $r[0];?>" readonly></td>
    	 <?php 
     	 echo "<td $negrilla><input name='digitosg[]' size='3' value='". ucwords(strtolower($r[1]))."' onChange='recalcularctas(2)' onKeyUp='return tabular(event,this) ' onKeyPress='javascript:return solonumeros(event)' ></td>";
		 echo "<td class='$iter'><input name='posicionesg[]' size='3' value='". ucwords(strtolower($r[3]))."' readonly></td>";
		  echo "<td class='$iter'><center><a href='#' onclick='eliminarg($x)'><img src='imagenes/del.png'></a></center></td></tr>";
         $aux=$co;
         $co=$co2;
         $co2=$aux;
		 $i=1+$i;
   		}
}
if($_POST[oculto])
{
	
	$co='saludo1';
	 $co2='saludo2';	
	 $i=1;
		for ($x=0;$x<count($_POST[nivelesg]);$x++) 
	    {		
    	 ?>
        <tr class="<?php echo $co ?>"><td><input name="<?php echo 'nivelesg[]';?>" type='text' value="<?php echo $_POST[nivelesg][$x];?>" readonly></td>
    	 <?php 
     	 echo "<td $negrilla><input name='digitosg[]' type='text' size='3' value='".ucwords(strtolower($_POST[digitosg][$x]))."' onBlur='recalcularctas(2)' onKeyUp='return tabular(event,this) ' onKeyPress='javascript:return solonumeros(event)' ></td>";
  		 echo "<td class='$iter'><input type='text' name='posicionesg[]' size='3' value='".ucwords(strtolower($_POST[posicionesg][$x]))."' readonly></td>";
		 if ($x==count($_POST[nivelesg])-1)
		   echo "<td class='$iter'><center><a href='#' onclick='eliminarg($x)'><img src='imagenes/del.png'></a></center></td></tr>";
		  else
		   echo "<td class='$iter'><center></center></td></tr>";
         $aux=$co;
         $co=$co2;
         $co2=$aux;
		 $i=1+$i;
   		}
}
?>

</table>
 </div>
</div>      
</div>
</form>
</td></tr>
<tr><td></td></tr>      
</table>
</body>
</html>