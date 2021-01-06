<?php //V 1000 12/12/16 ?> 
<?php
require "comun.inc";
require "funciones.inc";
require "conversor.php";
session_start();
cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<title>:: SPID - Tesoreria</title>

<script language="JavaScript1.2">
	function validar(){
		document.form2.oculto.value='1';
		document.form2.submit();
	}

	function pdf(){
		document.form2.action="pdfpredial.php";
		document.form2.target="_BLANK";
		document.form2.submit(); 
		document.form2.action="";
		document.form2.target="";
	}
</script>
<script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
<script src="css/programas.js"></script>
<script src="css/funciones.js"></script>
<link href="css/css2.css" rel="stylesheet" type="text/css" />
<link href="css/css3.css" rel="stylesheet" type="text/css" />
<link href="css/tabs.css" rel="stylesheet" type="text/css" />
<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
	<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
	<tr><?php menu_desplegable("teso");?></tr>
<tr>
  <td colspan="3" class="cinta">
  <a href="teso-reportepredios.php" class="mgbt"><img src="imagenes/add2.png" alt="Nuevo"  border="0" title="Nuevo"/></a> 
  <a href="#" onClick="#" class="mgbt"><img src="imagenes/guardad.png"  alt="Guardar" title="Guardar"/></a>
  <a href="teso-reportepredios.php" class="mgbt"> <img src="imagenes/buscad.png"  alt="Buscar" title="Buscar" /></a>
  <a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana" title="Nueva ventana"></a> 
  <a href="#" <?php if($_POST[oculto]==2) { ?> onClick="pdf()" <?php } ?> class="mgbt"> <img src="imagenes/print.png"  alt="Buscar" title="Imprimir"/></a>
  <a href="<?php echo "archivos/".$_SESSION[usuario]."reportepredios.csv"; ?>" target="_blank" class="mgbt"><img src="imagenes/csv.png"  alt="csv" title="csv"></a>
  <a href="teso-informespredios.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
  </td>
</tr>		  
</table>
<tr>
<td colspan="3" class="tablaprin" align="center"> 
<?php
$vigencia=date(Y);
$vact=$_SESSION[vigencia]; 
 ?>	

<form name="form2" method="post" action="">
	<table class="inicio">
	    <tr>
    	  	<td class="titulos" colspan="5">Causacion Predial</td>
        	<td class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
  		</tr>
      	<tr>
        	<td class="saludo3">Codigo Catastral:</td>
            <td>
				<input id="codcat" type="text" name="codcat" size="20" onKeyUp="return tabular(event,this)" onBlur="buscar(event)" value="<?php echo $_POST[codcat]?>" >
                <input id="ord" type="text" name="ord" size="3"  value="<?php echo $_POST[ord]?>" readonly><input id="tot" type="text" name="tot" size="3" value="<?php echo $_POST[tot]?>" readonly>
                <a href="#" onClick="mypop=window.open('catastral-ventana.php','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=900,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>
                <input name="oculto" type="hidden" value="<?php echo $_POST[oculto] ?>">
           	</td>
        	<td>
            	<input type="button" name="buscar" value="Buscar Predio" onClick="validar()">
            </td>
      	</tr>
  	</table>
    <div class="subpantallac" style="height:65%; overflow-x:hidden;">
    	<table class="inicio">
      		<tr>
            	<td class="titulos" colspan="9">Predios a Causar</td>
           	</tr>
      		<tr>
				<td class='titulos2'><img src='imagenes/plus.gif'></td>
            	<td class="titulos2">No</td>
                <td class="titulos2">Cod Catastral</td>
                <td class="titulos2">Direccion</td>
                <td class="titulos2">Cedula/Nit</td>
                <td class="titulos2">Propietario</td>
                <td class="titulos2">Tipo Predio</td>
                <td class="titulos2">Clasificacion</td>
                <td class="titulos2">Avaluo</td>
          	</tr>
      		<?php
	  		if($_POST[oculto]>=1){
				$linkbd=conectar_bd();
				$sqlr="select tesopredios.cedulacatastral, tesopredios.avaluo, tesopredios.direccion, tesopredios.documento, tesopredios.tipopredio, tesopredios.estratos, tesopredios.ord, tesopredios.tot from tesopredios ";
				$res=mysql_query($sqlr,$linkbd);
				//echo $sqlr;
				$np=1;
				$codcat="'".$row[0]."'";
				$ord="'".$row[6]."'";
				$tot="'".$row[7]."'";
					
				
				$tpredial=0;
				$tbomberil=0;
				$tambiental=0;	
				$namearch="archivos/".$_SESSION[usuario]."reportepredios.csv";
				$Descriptor1 = fopen($namearch,"w+"); 
				fputs($Descriptor1,"No;cedula_catastral; direccion; documento_propietario; nombre_propietario; tipo_predio; clasificacion; avaluo\r\n");
				while ($row =mysql_fetch_row($res)){ 
					$nter=buscatercero($row[3]);					
					
					echo "<tr class='saludo3'>
						<td class='titulos2'>
							<a onClick=\"verDetallePredial($np, $codcat, $ord, $tot)\" style='cursor:pointer;'>
								<img id='img".$np."' src='imagenes/plus.gif'>
							</a>
						</td>
						<td>$np</td>
						<td>$row[0]</td>
						<td>$row[2]</td>
						<td>$row[3]</td>
						<td>$nter</td>
						<td>$row[4]</td>
						<td>$row[5]</td>
						<td align='right'>".number_format($row[1],2,',','.')."</td>
					</tr>
					<tr>
						<td align='center'></td>
						<td colspan='8' align='right'>
							<div id='detalle".$np."' style='display:none'></div>
						</td>
					</tr>";
					fputs($Descriptor1,$np.";'".$row[0]."';".$row[2].";".$row[3].";".$nter.";".$row[4].";".$row[5].";".$row[1]."\r\n");
					$tpredial+=$predial;
					$tbomberil+=$bomberil;
					$tambiental+=$ambiental;										
					$np+=1;
					}		
				fclose($Descriptor1);			
	   		}
      		?>
      	</table>
	</div>      
</form>
</td></tr>
</table>
</body>
</html>