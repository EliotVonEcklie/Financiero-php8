<?php
	header("Cache-control: no-cache, no-store, must-revalidate");
	header("Content-Type: text/html;charset=iso-8859-1");
	require 'comun.inc';
	require 'funciones.inc';
	$linkbd=conectar_v7();
	date_default_timezone_set("America/Bogota");
	error_reporting(E_ALL);
	ini_set('display_errors', '1');

	$_POST['iPlaca']=@$_GET['iPlaca'];
	$_POST['iNombre']=@$_GET['iNombre'];
	$_POST['iCCosto']=@$_GET['iCCosto'];
?>
<!DOCTYPE html5>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>:: Activos</title>
    <link href="css/css2.css" rel="stylesheet" type="text/css" />
    <link href="css/css3.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="css/programas.js"></script>
    <script>
    function fagregar(placa, nombre, ccosto) {
        iNombre = document.getElementById('iNombre').value;
        parent.document.getElementById('' + iNombre).value = nombre;
        iCCosto = document.getElementById('iCCosto').value;
        parent.document.getElementById('' + iCCosto).value = ccosto;
        iPlaca = document.getElementById('iPlaca').value;
        parent.document.getElementById('' + iPlaca).value = placa;
        parent.document.getElementById('' + iPlaca).select();
        parent.document.getElementById('' + iPlaca).blur();
        parent.despliegamodal2("hidden");
    }
    </script>
</head>

<body>
    <form name="form2" method="post">
        <table class="inicio" style="width:99.5%">
            <tr>
                <td class="titulos" colspan="6">:: Buscar Activos Fijos</td>
                <td class="cerrar" style="width:7%;">
                    <a onClick="parent.despliegamodal2('hidden');">&nbsp;Cerrar</a>
                </td>
            </tr>
            <tr>
                <td class="saludo1">:: Nombre:</td>
                <td><input name="nombre" type="text" value="" size="40"></td>
                <td class="saludo1">:: Placa:</td>
                <td>
                    <input name="documento" type="text" id="documento">
                    <input type="submit" name="Submit" value="Buscar" onClick="buscar()">
                </td>
            </tr>
        </table>
        <input type="hidden" name="iPlaca" id="iPlaca" value="<?php echo @$_POST['iPlaca']?>" />
        <input type="hidden" name="iNombre" id="iNombre" value="<?php echo @$_POST['iNombre']?>" />
        <input type="hidden" name="iCCosto" id="iCCosto" value="<?php echo @$_POST['iCCosto']?>" />
        <div class="subpantalla" style="height:84%; width:99.2%; overflow-x:hidden;">
            <?php
				$crit1 = $crit2 = " ";
				if (@$_POST['nombre']!= '')
					$crit1=" AND T1.nombre LIKE '%".$_POST['nombre']."%' ";
				if (@$_POST['documento']!="")
					$crit2=" AND T1.placa LIKE '%".$_POST['documento']."%' ";

				$sqlr="SELECT * FROM acticrearact_det T1 WHERE T1.estado='S'".$crit1.$crit2." order by T1.nombre";
				$resp = mysqli_query($linkbd, $sqlr);
				$con = mysqli_num_rows($resp);
				echo "
					<table class='inicio' align='center' width='99%'>
						<tr><td colspan='8' class='titulos'>.: Resultados Busqueda:</td></tr>
						<tr><td colspan='8'>Activos Fijos Encontrados: $con</td></tr>
						<tr>
							<td class='titulos2' width='2%'>Item</td>
							<td class='titulos2' width='10%'>Placa</td>
							<td class='titulos2' width='80%'>Nombre</td>
							<td class='titulos2' width='80%'>Centro Costo</td>
							<td class='titulos2' width='80%'>Area</td>
							<td class='titulos2' width='80%'>Ubicacion</td>
							<td class='titulos2' width='10%'>Estado</td>
							</tr>";
				$iter='saludo1a';
				$iter2='saludo2';
				$conta=1;
				while ($row =mysqli_fetch_row($resp)) {
					echo"
						<tr class='$iter' style='text-transform:uppercase' onClick=\"javascript:fagregar('$row[1]','$row[2]','$row[14]')\" >
							<td>$conta</td>
							<td>$row[1]</td>
							<td>$row[2]</td>
							<td>$row[14]</td>
							<td>$row[11]</td>
							<td>$row[12]</td>
							<td>$row[24] </td>
						</tr>";
					$conta++;
					$aux=$iter;
					$iter=$iter2;
					$iter2=$aux;
				}
				echo"</table>";
			?>
        </div>
    </form>
</body>

</html>
