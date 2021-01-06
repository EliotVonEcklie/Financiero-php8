<?php //V 1001 17/12/16 ?>
<?php
require "comun.inc";
require"funciones.inc";
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
        <title>:: SPID</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/calendario.js"></script>
		<script >
			function ponprefijo(pref,opc,val)
			{   
				parent.document.form2.codigo.value=pref;
				parent.document.form2.fecha.value=opc;
				parent.document.form2.valor.value=val;
				parent.document.form2.oculto.value='1';
				parent.despliegamodal2("hidden");
			} 
		</script> 
		<?php titlepag();?>
	</head>
	<body >
	<form action="" method="post" enctype="multipart/form-data" name="form1">
		<?php
		?>
		<table  class="inicio" align="center" >
			<tr >
				<td height="25" colspan="4" class="titulos" >Buscar Documentos de Donaciones y/o Recuperaciones </td>
				<td class="cerrar"><a onClick="parent.despliegamodal2('hidden');">&nbsp;Cerrar</a></td>
			</tr>
			<tr>
				<td colspan="6" class="titulos2" >:&middot; Por Descripcion </td>
			</tr>
			<tr >
				<td class="saludo1" >:&middot; Numero Orden:</td>
				<td  colspan="3">
					<input name="numero" type="text" size="30" >
					<input type="submit" name="Submit" value="Buscar" >
				</td>
			</tr>      
		</table>
		<div class="subpantalla" style="height:78.5%; width:99.6%; overflow-x:hidden;">
			<table class="inicio">
				<tr >
					<td height="25" colspan="6" class="titulos" >Resultados Busqueda </td>
				</tr>
				<tr>
					<td class='titulos2' style="width:5%">Orden</td>
					<td class='titulos2' style="width:10%">Fecha</td>
					<td class='titulos2' style="width:40%">Valor</td>
					<td class='titulos2' style="width:10%">Estado</td>
				</tr>
				<?php
				$linkbd=conectar_bd();
				$crit1=" ";
				$crit2=" ";
				$sqlr="SELECT acti_donaciones_cab.id, acti_donaciones_cab.fecha, acti_donaciones_cab.valor,acti_donaciones_cab.estado FROM acti_donaciones_cab WHERE acti_donaciones_cab.estado='S' and acti_donaciones_cab.tipo_mov='101' ORDER BY acti_donaciones_cab.id";
				$resp = mysql_query($sqlr,$linkbd);
				$ntr = mysql_num_rows($resp);
				$iter='saludo1a';
				$iter2='saludo2';
				while ($r =mysql_fetch_row($resp)) 
				{			
					echo"<tr class='$iter' style='text-transform:uppercase' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\" onClick=\"javascript:ponprefijo('$r[0]','$r[1]','$r[2]')\" >";
						echo "<td>$r[0]</td>
						<td>$r[1]</td>
						<td>$r[2]</td>
						<td>$r[3]</td>
					</tr>";
				$aux=$iter;
				$iter=$iter2;
				$iter2=$aux;
				}
				?>
			</table>
		</div>
	</form>
	</body>
</html>