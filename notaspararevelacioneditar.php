<?php //V 1001 22/12/16 ?> 
<!--V 1.0 24/02/2015-->
<?php
	require "comun.inc";
	require"funciones.inc";
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
		<title>:: SieS</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js"></script>
		<script> 
			function guardar()
			{
				parent.document.form2.notaf.value =document.form2.texta.value;
				parent.despliegamodal2("hidden");
				parent.document.form2.submit();
			} 
			function editar(){
				document.form2.edita.value=2;
				// alert(document.form2.texta.value);
				document.form2.nota1.value=document.form2.texta.value;
				document.form2.submit();
			}
		</script> 
		<?php titlepag();?>
	</head>
	<body >
  	<form action="" method="post" name="form2">
		<?php
			if($_POST[edita]!=2){
				$_POST[nota1]=$_GET[nota];
				$_POST[modulo]=$_GET[modulo];
				$_POST[doc]=$_GET[doc];
				$_POST[tdoc]=$_GET[tdoc];
				$_POST[valor]=$_GET[valor];
			}
		?>
		<?php 
			if($_POST[edita]==2){
				$sqlr="delete from teso_notasrevelaciones where modulo='$_POST[modulo]' and numero_documento='$_POST[doc]' and tipo_documento='$_POST[tdoc]'";
				mysql_query($sqlr,$linkbd);
				$date=getdate();
				$h=$date["hours"];
				$min=$date["minutes"];
				$hora=$h.":".$min;
				$sqlr="insert into teso_notasrevelaciones(hora,fecha,usuario,modulo,tipo_documento,numero_documento,valor_total_transaccion,nota) values('$hora','$date','".$_SESSION["usuario"]."','$_POST[modulo]','$_POST[tdoc]','$_POST[doc]','$_POST[valor]','$_POST[nota1]')";
				mysql_query($sqlr,$linkbd);
			}
		?>
		<table  class="inicio" style="width:99.4%;">
  			<tr >
    			<td class="titulos" colspan="2">:. Notas para Revelaciones</td>
				<td style="width:7%" class="cerrar" ><a onClick="parent.despliegamodal2('hidden');" style="cursor:pointer;">Cerrar</a></td>
			</tr>
      	</table> 
		<div class="subpantalla" style="height:86%; width:99%; overflow-x:hidden;">
			<table>
				<tr >
					<td class="saludo1" colspan="2">:. Nota:</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="hidden" name="nota1" id="nota1" value="<?php echo $_POST[nota1]?>">
						<input type="hidden" name="modulo" id="modulo" value="<?php echo $_POST[modulo]?>">
						<input type="hidden" name="doc" id="doc" value="<?php echo $_POST[doc]?>">
						<input type="hidden" name="tdoc" id="tdoc" value="<?php echo $_POST[tdoc]?>">
						<input type="hidden" name="valor" id="valor" value="<?php echo $_POST[valor]?>">
						<input type="hidden" name="edita" id="edita" value="1">
						<?php echo "<textarea name='texta' id='texta' rows='24' cols='120' >$_POST[nota1]</textarea>";?>
					</td>
				</tr>
				<tr>
					<td><input type="button" value="Editar" onClick="editar()"><input type="button" value="Guardar" onClick="guardar()" <?php if($_POST[edita]!=2){echo "disabled";} ?>></td>
				</tr>
				
			</table>
			
		</div>
		<input type="hidden" name="numtop" id="numtop" value="<?php echo $_POST[numtop];?>" />
</form>
</body>
</html>
