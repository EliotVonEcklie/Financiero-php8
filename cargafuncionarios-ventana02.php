<?php //V 1000 12/12/16 ?> 
<?php 
	require"comun.inc";
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
		<script type="text/javascript" src="css/calendario.js"></script>
        <script type="text/javascript" src="css/programas.js"></script>
		<script>
			
			function fagregar(documento)
			{	
				tobjeto=document.getElementById('tobjeto').value;
				parent.document.getElementById(''+tobjeto).value =documento;
				parent.document.getElementById(''+tobjeto).select();
				parent.document.getElementById(''+tobjeto).blur();
				parent.despliegamodal2("hidden");
			}
        </script> 
		<?php titlepag();?>
	</head>
	<body>
		<form name="form2" method="post">
			<?php
				if($_POST[oculto]==""){$_POST[tobjeto]=$_GET[objeto];}
         	 ?>
			<table  class="inicio" align="center" >
      			<tr>
                	<td class="titulos" colspan="2">:: Buscar Funcionario</td>
                	<td class="cerrar" style="width:7%;"><a onClick="parent.despliegamodal2('hidden');">&nbsp;Cerrar</a></td>
                </tr>
      			<tr>
                	<td class="saludo1" style='width:4cm;'>:: Documento o Nombre:</td>
        			<td>
                    	<input type="search" name="nombre" id="nombre" value="<?php echo $_POST[nombre];?>" style='width:60%;'/>
                        <input type="button" name="bboton" onClick="document.form2.submit();" value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;" />
                        <input type="button" name="bagregar" onClick="fagregar();" value="&nbsp;&nbsp;Agregar&nbsp;&nbsp;" />
                    </td>
       			</tr>                       
    		</table> 
            <input type="hidden" name="oculto" id="oculto" value="1"/>
            <input type="hidden" name="tobjeto" id="tobjeto" value="<?php echo $_POST[tobjeto]?>"/>
            <div class="subpantalla" style="height:83.5%; width:99.6%; overflow-x:hidden;">
				<?php
					if ($_POST[nombre]!="")
					{$crit1=" AND (SELECT T2.codfun FROM hum_funcionarios T2 WHERE T2.descripcion  LIKE  '%$_POST[nombre]%' AND T2.estado='S' AND T2.codfun=T1.codfun AND (T2.item='NOMTERCERO' OR T2.item='DOCTERCERO'))  ";}
					else {$crit1="";}
					$sqlr="
					SELECT T1.codfun, 
					GROUP_CONCAT(T1.descripcion ORDER BY CONVERT(T1.valor, SIGNED INTEGER) SEPARATOR '<->')
					FROM hum_funcionarios T1
					WHERE (T1.item = 'NOMCARGO' OR T1.item = 'DOCTERCERO' OR T1.item = 'NOMTERCERO' OR T1.item = 'ESTGEN' OR T1.item = 'NOMCC') AND T1.estado='S' $crit1
					GROUP BY T1.codfun
					ORDER BY CONVERT(T1.codfun, SIGNED INTEGER)";
					
					$resp = mysql_query($sqlr,$linkbd);
					$con=mysql_num_rows($resp);
					echo "
					<table class='inicio' align='center' width='99%'>
						<tr>
							<td colspan='6' class='titulos'>.: Resultados Busqueda:</td>
						</tr>
						<tr><td colspan='7'>funcionarios Encontrados: $con</td></tr>
						<tr>
							<td class='titulos2' width='2%'>ID</td>
							<td class='titulos2' width='10%'>DOCUMENTO</td>
							<td class='titulos2' width='20%'>NOMBRE</td>
							<td class='titulos2' >CARGO</td>
							<td class='titulos2' width='15%'>CENTRO COSTO</td>
						</tr>";	
					$iter='saludo1a';
					$iter2='saludo2';
					while ($row =mysql_fetch_row($resp)) 
					{
						$datos = explode('<->', $row[1]);
						if($datos[4]=="S")
						{
							echo "
							<tr class='$iter' onClick=\"javascript:fagregar('$datos[1]')\">
								<td>$row[0]</td>
								<td>$datos[1]</td>
								<td>$datos[2]</td>
								<td>$datos[0]</td>
								<td>$datos[3]</td>
							</tr>
							";
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux;
						}
					}
					echo"</table>";
                ?>
			</div>
		</form>
	</body>
</html>
