<?php
	header("Cache-control: no-cache, no-store, must-revalidate");
	header("Content-Type: text/html;charset=iso-8859-1");
	require 'comun.inc';
	require 'funciones.inc';
	$linkbd=conectar_v7();
	date_default_timezone_set("America/Bogota");

	$_POST['iNota']=@$_GET['iNota'];
	$_POST['iFecha']=@$_GET['iFecha'];
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
    function fagregar(id, fecha) {
        if (id) {
            iNota = document.getElementById('iNota').value;
            parent.document.getElementById('' + iNota).value = id;
            parent.document.getElementById('' + iNota).select();
            parent.document.getElementById('' + iNota).blur();
        }
        if (fecha) {
            iFecha = document.getElementById('iFecha').value;
            parent.document.getElementById('' + iFecha).value = fecha;
        }
        parent.despliegamodal2("hidden");
    }
    </script>
</head>

<body style="width:99.5%; overflow-y:hidden">
    <form name="form2" method="post">
        <table class="inicio">
            <tr>
                <td class="titulos" colspan="6">:: Buscar Notas Bancarias</td>
                <td class="cerrar" style="width:7%;">
                    <a onClick="parent.despliegamodal2('hidden');">&nbsp;Cerrar</a>
                </td>
            </tr>
            <tr>
                <td class="saludo1">:: Numero:</td>
                <td><input name="numero" type="text" value=""></td>
                <td><input type="submit" name="Submit" value="Buscar"></td>
            </tr>
        </table>
        <input type="hidden" name="iNota" id="iNota" value="<?php echo @$_POST['iNota']?>" />
        <input type="hidden" name="iFecha" id="iFecha" value="<?php echo @$_POST['iFecha']?>" />
        <div class="subpantalla" style="height:84%; width:99.2%; overflow-x:hidden;">
            <?php
				$crit1 = " ";
				if (@$_POST['numero']!="")
					$crit1=" AND T1.id_notaban = ".$_POST['numero']." ";

				$sqlr="SELECT * FROM tesonotasbancarias_cab T1 WHERE T1.estado='S'".$crit1." ORDER BY T1.id_notaban DESC";
				$resp = mysqli_query($linkbd, $sqlr);
				$con = mysqli_num_rows($resp);
				echo "
					<table class='inicio' align='center' width='99%'>
						<tr><td colspan='8' class='titulos'>.: Resultados Busqueda:</td></tr>
						<tr><td colspan='8'>Notas bancarias encontradas: $con</td></tr>
						<tr>
							<td class='titulos2' width='2%'>Item</td>
							<td class='titulos2' width='10%'>Fecha</td>
							<td class='titulos2' width='80%'>Concepto</td>
							<td class='titulos2' width='8%'>Vigencia</td>
							</tr>";
				$iter='saludo1a';
				$iter2='saludo2';
				$conta=1;
				while ($row =mysqli_fetch_row($resp)) {
					echo"
						<tr class='$iter' style='text-transform:uppercase' onClick=\"javascript:fagregar('$row[0]','$row[2]')\" >
							<td>$row[0]</td>
							<td>$row[2]</td>
							<td>$row[5]</td>
							<td>$row[3]</td>
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
