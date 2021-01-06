<?php //V 1000 12/12/16 ?> 
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
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<title>:: SPID - Presupuesto</title>

<script>
//************* ver reporte ************
//***************************************
function verep(idfac){
  document.form1.oculto.value=idfac;
  document.form1.submit();
}
</script>
<script>
//************* genera reporte ************
//***************************************
function genrep(idfac){
  document.form2.oculto.value=idfac;
  document.form2.submit();
}
</script>

<link href="css/css2.css" rel="stylesheet" type="text/css" />
<link href="css/css3.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
<script type="text/javascript" src="css/programas.js"></script>
<script type="text/javascript" src="css/funciones.js"></script>
<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
	<tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
	<tr><?php menu_desplegable("presu");?></tr>
<tr>
  <td colspan="3" class="cinta"><a href="presu-saldoscuentas.php" ><img src="imagenes/add2.png"  alt="Nuevo" /></a> <img src="imagenes/guardad.png" alt="Guardar" /></a> <a href="#" onClick="document.form2.submit();"> <img src="imagenes/buscad.png" alt="Buscar" /></a> <a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" alt="nueva ventana"></a> <a href="<?php echo "archivos/".$_SESSION[usuario]."SALDOS_RUBROS.csv"; ?>" ><img src="imagenes/csv.png"  alt="csv"></a> </td></tr></table>
<tr><td colspan="3" class="tablaprin"> 
<form action="" method="post" enctype="multipart/form-data" name="form2">
	<div class="subpantallap">
    	<table class="inicio" width="99%">
			<tr >
      			<td height="25" colspan="4" class="titulos" >
                	Saldos Cuentas <input name="oculto" type="hidden" value="1"> 
               	</td>
                <td class="cerrar">
                	<a href="presu-principal.php">Cerrar</a>
             	</td>
    		</tr>    
    		<tr>
      			<td class="titulos2">Item</td>
      			<td class="titulos2">Sector </td>
      			<td class="titulos2">Rubro</td>
	  			<td class="titulos2">Nombre Rubro</td>
      			<td class="titulos2">Saldo</td>          	  	  
    		</tr>
			<?php
			$oculto=$_POST['oculto'];
			$vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
			if($oculto!=""){
				$sqlr="Select distinct * from pptocuentas_sectores where  (vigenciai=".$vigusu." or vigenciaf=".$vigusu.")  order by cuenta";
				$resp = mysql_query($sqlr,$linkbd);			
				$co='zebra1';
				$co2='zebra2';	
				$i=1;
				$namearch="archivos/".$_SESSION[usuario]."SALDOS_RUBROS.csv";
				$Descriptor1 = fopen($namearch,"w+"); 
				fputs($Descriptor1,"ITEM;SECTOR;RUBRO;NOMBRE RUBRO;SALDO\r\n");
				while ($r =mysql_fetch_row($resp)){
					$nomcta=existecuentain($r[0]);
					$saldo=consultasaldo($r[0],$vigusu,$vigusu);	
					echo "<tr class='$co'>
						<td>$i</td>
						<td>$r[1]</td>
						<td>$r[0]</td>
						<td>$nomcta</td>
						<td>".number_format($saldo,2,",",".")."</td>
					</tr>";	
					fputs($Descriptor1,$i.";".$r[1].";".$r[0].";".$nomcta.";".$saldo."\r\n");
         			$aux=$co;
         			$co=$co2;
         			$co2=$aux;
		 			$i=1+$i;
		 			$saldo=0;
   				}
 				fclose($Descriptor1);
				$_POST[oculto]="";
			}
			?>
		</table>
	</div>
</form>
</td></tr>
</table>
</body>
</html>