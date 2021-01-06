<?php //V 1000 12/12/16 ?> 
<?php 
require "comun.inc";
require"funciones.inc";
$linkbd=conectar_bd(); 
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<?php require "head.php"; ?>
		<title>:: Spid</title>
		<script> 
			function ponprefijo(pref,opc,objeto,nobjeto)
			{ 
				parent.document.getElementById(''+objeto).value =pref ;
				parent.document.getElementById(''+nobjeto).value =opc ;
				//parent.document.form2.submit();
				parent.despliegamodal2('hidden');
			} 
		</script> 
		<?php titlepag();?>
	</head>
	<body>
		<form action="" method="post" name="form2">
			<?php
				if($_POST[oculto]==""){$_POST[tobjeto]=$_GET[objeto];$_POST[tnobjeto]=$_GET[nobjeto];}
			?>
			<table  class="inicio ancho" align="center" >
				<tr >
					<td class="titulos" colspan="4" width='100%'>:: Buscar Tercero</td>
					<td class="boton02" onClick="parent.despliegamodal2('hidden');">Cerrar</td>
				</tr>
				<tr>
					<td class="saludo1" style='width:4cm;'>Nombre o apellidos:</td>
					<td style='width:30%;'><input name="nombre" type="text" value="" style='width:100%;'/> </td>
					<td class="saludo1" style='width:3cm;'>Documento:</td>
					<td><input name="documento" type="text" id="documento" value=""  style='width:60%;'/>&nbsp;<em type="submit" class="botonflecha" name="Submit" value="" onClick="document.form2.submit();" >Buscar</em></td>
				</tr>
			</table> 
			<input type="hidden" name="oculto" id="oculto"  value="1">
			<input type="hidden" name="tobjeto" id="tobjeto" value="<?php echo $_POST[tobjeto]?>"/>
			<input type="hidden" name="tnobjeto" id="tnobjeto" value="<?php echo $_POST[tnobjeto]?>"/>
			<?php
				$oculto=$_POST['oculto'];
				{
					$crit1=" ";
					$crit2=" ";
					if ($_POST[nombre]!="")
					{$crit1="AND (nombre1 like '%".$_POST[nombre]."%' OR nombre2 LIKE '%".$_POST[nombre]."%' OR apellido1 LIKE '%".$_POST[nombre]."%' OR apellido2 LIKE '%".$_POST[nombre]."%' OR razonsocial LIKE '%".$_POST[nombre]."%') ";}
					if ($_POST[documento]!=""){$crit2="AND cedulanit LIKE '%$_POST[documento]%' ";}
					$sqlr="SELECT * FROM terceros WHERE estado='S' $crit1 $crit2 ORDER BY apellido1,apellido2,nombre1,nombre2";
					$resp = mysql_query($sqlr,$linkbd);
					$ntr = mysql_num_rows($resp);
					$con=1;
					echo "
					<table class='inicio' align='center' width='99%'>
						<tr><td colspan='8' class='titulos'>.: Resultados Busqueda:</td></tr>
						<tr><td colspan='8'>Terceros Encontrados: $ntr</td></tr>
						<tr>
							<td class='titulos2' width='2%'>Item</td>
							<td class='titulos2' width='30%'>RAZON SOCIAL</td>
							<td class='titulos2' width='10%'>PRIMER APELLIDO</td>
							<td class='titulos2' width='10%'>SEGUNDO APELLIDO</td>
							<td class='titulos2' width='10%'>PRIMER NOMBRE</td>
							<td class='titulos2' width='10%'>SEGUNDO NOMBRE</td>
							<td class='titulos2' width='4%'>DOCUMENTO</td>
						</tr>";	
				$iter='saludo1a';
				$iter2='saludo2';
 				while ($row =mysql_fetch_row($resp)) 
 				{
   					if ($row[11]=='31'){$ntercero=$row[5];}
  					else { $ntercero=" $row[3] $row[4] $row[1] $row[2]";}
	 				echo"
						<tr class='$iter' onClick=\"javascript:ponprefijo('$row[12]','$ntercero','$_POST[tobjeto]','$_POST[tnobjeto]')\">
							<td>$con</td>
							<td>".strtoupper($row[5])."</td>
							<td>".strtoupper($row[3])."</td>
							<td>".strtoupper($row[4])."</td>
							<td >".strtoupper($row[1])."</td>
							<td>".strtoupper($row[2])."<td>$row[12]</td>
						</tr>";
	 $con+=1;
	 $aux=$iter;
	 $iter=$iter2;
	 $iter2=$aux;
 }
 echo"</table>";
}
?>
</form>
</body>
</html>
