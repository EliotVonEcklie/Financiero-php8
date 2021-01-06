<?php //V 1000 12/12/16 ?> 
<?php
require"comun.inc";
require"funciones.inc";
sesion();
$_SESSION["usuario"] ;
$_SESSION["perfil"] ;
$_SESSION["linkset"] ;
header("Cache-control: private"); // Arregla IE 6
date_default_timezone_set("America/Bogota");
?><html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<title>:: Spid - Presupuesto</title>
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
function agregar()
{ document.form2.action="verperfiles.php";
  document.form2.oculto.value="";
  document.form2.submit();
  }
</script>
<script >
function habilitar(chkbox) 
{ 
 habdesv=document.getElementsByName('habdes[]');
 chks=document.getElementsByName('asigna[]');
for (var i=0;i < cali.length;i++) 
{ 
 if(chks.item(i)==chkbox)
  {
   if (chkbox.checked==true)
     {
		habdesv.item(i).value="1";
	//	alert("cabio"+habdesv.item(i).value)
	 }
	else
	habdesv.item(i).value="0";
	//	alert("cabio"+habdesv.item(i).value)

  }
}
} 
</script>
<script >
function validar(formulario)
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
//	 alert('ddddd');
 document.form2.submit();
 }
 }
</script>
<script>
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
</script>
<?php titlepag();?>
<script src="css/programas.js"></script>
<link href="css/css2.css" rel="stylesheet" type="text/css" />
<link href="css/css3.css" rel="stylesheet" type="text/css" />
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
	<tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
	<tr><?php menu_desplegable("presu");?></tr>
   <tr>
  <td colspan="3" class="cinta">
  <a href="presu-parametros.php" class="mgbt"><img src="imagenes/add.png"  alt="Nuevo" title="Nuevo"/></a>  
  <a href="#" onClick="guardar()" class="mgbt" ><img src="imagenes/guarda.png" alt="Guardar" title="Guardar"/></a> 
  <a href="#" class="mgbt"><img src="imagenes/buscad.png" alt="Buscar" title="Buscar"/> </a>
  <a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana" title="Nueva ventana"></a></td></tr></table>		  
<tr><td colspan="3" class="tablaprin"> 
<form name="form2" method="post" >
<?php
 $linkbd=conectar_bd();
 $vigusu=vigencia_usuarios($_SESSION[cedulausu]);
if($_POST[oculto]=="")
 {
  $_POST[diacorte]=1;
  $sqlr="Select * from  pptoparametros";
			// echo $sqlr;
		 			$resp = mysql_query($sqlr,$linkbd);
				    while ($row =mysql_fetch_row($resp)) 
				    {						 
					 $_POST[tercero]=$row[1];
					 $_POST[ntercero]=$row[2];
					 $_POST[agepres]=$row[2];					 
					}
 }
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
  <table width="60%" class="inicio" align="center" >
    <tr >
      <td class="titulos" colspan="4">Parametrizacion</td>
      <td width='9%' class='cerrar'><a href='presu-principal.php'>Cerrar</a></td>
    </tr>
    <tr >
      <td class="saludo1" >Presupuesto:</td>
      <td>
      <input id="tercero" name="tercero" type="text" value="<?php echo $_POST[tercero]?>" size="15" onKeyUp="return tabular(event,this)"><a href="#" onClick="mypop=window.open('tercerosgral-ventana.php?vigencia=<?php echo $_SESSION[vigencia]?>&objeto=tercero&nobjeto=ntercero','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=900,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a> <input id="ntercero" name="ntercero" type="text" value="<?php echo $_POST[ntercero]?>" size="40" onKeyUp="return tabular(event,this)">
      <input type="hidden" value="0" name="oculto"></td>
          </tr>
 </table>
      <?php
	  if($_POST[bt]=='1')
			 {
			  $nresul=buscatercero($_POST[tercero]);
			  $_POST[regimen]=buscaregimen($_POST[tercero]);	
			  if($nresul!='')
			   {
			  $_POST[ntercero]=$nresul;
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
			?>
<?php
$oculto=$_POST[oculto];
if($oculto=="2")
{
$linkbd=conectar_bd();
$sqlr="delete from pptoparametros";
mysql_query($sqlr,$linkbd);
$sqlr="insert into pptoparametros (cc_terorero,age_prespred,estado) values ('$_POST[tercero]', '$_POST[ntercero]', 'S')";
//$resp=oci_parse ($linkbd, $sqlr);
//oci_execute ($resp);
//echo $sqlr."<br>";
if(!mysql_query($sqlr,$linkbd))
 {
echo "<table class='inicio'><tr><td class='saludo1'><center>No Se ha Actualizado la informacion ".mysql_error($linkbd)." <img src='imagenes/alert.png'></center></td></tr></table>";
 }
 else
 {
echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha Actualizado con Exito <img src='imagenes/confirm.png'></center></td></tr></table>";	 
 }
//oci_free_statement($resp);
//oci_close($linkdb);
}
?>
</form>
</td></tr>   
</table>
</body>
</html>