<?php
	header("Cache-control: no-cache, no-store, must-revalidate");
	header("Content-Type: text/html;charset=iso-8859-1");
	require 'comun.inc';
	require 'funciones.inc';
	$linkbd=conectar_v7();
	date_default_timezone_set("America/Bogota");
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
?>
<!DOCTYPE>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1" />
    <meta http-equiv="X-UA-Compatible" content="IE=9" />
    <title>:: SieS</title>
    <link href="css/css2.css" rel="stylesheet" type="text/css" />
    <link href="css/css3.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="css/calendario.js"></script>
    <script type="text/javascript" src="css/programas.js"></script>
    <script>
    function fagregar(idfun, documento, nombre) {
        if (document.getElementById('tcodfun').value != '' && document.getElementById('tcodfun').value != null) {
            tcodfun = document.getElementById('tcodfun').value;
            parent.document.getElementById('' + tcodfun).value = idfun;
        }
        tobjeto = document.getElementById('tobjeto').value;
        parent.document.getElementById('' + tobjeto).value = documento;
        ntobjeto = document.getElementById('ntobjeto').value;
        parent.document.getElementById('' + ntobjeto).value = nombre;
        parent.despliegamodal2("hidden");
    }
    </script>
    <?php titlepag();?>
</head>

<body>
    <form name="form2" method="post">
        <?php
			if(@$_POST['oculto']=="")
			{
				$_POST['tobjeto']=@$_GET['objeto'];
				$_POST['tcodfun']=@$_GET['vcodfun'];
				$_POST['ntobjeto']=@$_GET['ntobjeto'];
			}
		?>
        <table class="inicio" style="width:99.5%">
            <tr>
                <td class="titulos" colspan="6">:: Buscar Funcionario</td>
                <td class="cerrar" style="width:7%;">
                    <a onClick="parent.despliegamodal2('hidden');">&nbsp;Cerrar</a>
                </td>
            </tr>
            <tr>
                <td class="saludo1" style='width:4cm;'>:: Documento o Nombre:</td>
                <td colspan="5"><input type="search" name="nombre" id="nombre" value="<?php echo @$_POST['nombre'];?>"
                        style='width:100%;' /> </td>
            </tr>
            <tr>
                <td class="saludo1">:: Centro de Costo:</td>
                <td style="width:30%;">
                    <select name="cc" style="width:100%;">
                        <option value='' <?php if(''==@$_POST['cc']) echo "SELECTED"?>>Todos</option>
                        <?php
								$sqlr="SELECT * FROM centrocosto WHERE estado='S' ORDER BY ID_CC";
								$res=mysqli_query($linkbd,$sqlr);
								while ($row =mysqli_fetch_row($res))
								{
									if($row[0]==$_POST['cc']){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
									else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
								}
							?>
                    </select>
                </td>
                <td> <input type="button" name="bboton" onClick="document.form2.submit();"
                        value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;" /></td>
            </tr>
        </table>
        <input type="hidden" name="oculto" id="oculto" value="1" />
        <input type="hidden" name="tobjeto" id="tobjeto" value="<?php echo @$_POST['tobjeto']?>" />
        <input type="hidden" name="tcodfun" id="tcodfun" value="<?php echo @$_POST['tcodfun']?>" />
        <input type="hidden" name="ntobjeto" id="ntobjeto" value="<?php echo @$_POST['ntobjeto']?>" />
        <div class="subpantalla" style="height:82%; width:99.2%; overflow-x:hidden;">
            <?php
					if (@$_POST['nombre']!="")
					{$crit1=" AND (SELECT T4.codfun FROM hum_funcionarios T4 WHERE T4.descripcion  LIKE  '%$_POST[nombre]%' AND T4.estado='S' AND T4.codfun=T1.codfun AND (T4.item='NOMTERCERO' OR T4.item='DOCTERCERO'))  ";}
					else{$crit1="";}
					if(@$_POST['cc']!='')
					{$crit2=" AND (SELECT T3.codfun FROM hum_funcionarios T3 WHERE T3.descripcion LIKE '$_POST[cc]' AND T3.estado='S' AND T3.codfun=T1.codfun AND T3.item='NUMCC')";}
					else{$crit2="";}
					$sqlr="SELECT T1.codfun,
					GROUP_CONCAT(T1.descripcion ORDER BY CONVERT(T1.valor, SIGNED INTEGER) SEPARATOR '<->')
					FROM hum_funcionarios T1
					WHERE (T1.item = 'NOMCARGO' OR T1.item = 'DOCTERCERO' OR T1.item = 'NOMTERCERO' OR T1.item = 'ESTGEN' OR T1.item = 'NUMCC' OR T1.item = 'NOMCC') AND T1.estado='S' AND (SELECT T2.codfun FROM hum_funcionarios T2 WHERE T2.descripcion LIKE 'S' AND T2.estado='S' AND T2.codfun=T1.codfun AND T2.item='ESTGEN') $crit2 $crit1
					GROUP BY T1.codfun
					ORDER BY CONVERT(T1.codfun, SIGNED INTEGER)";
					$resp = mysqli_query($linkbd,$sqlr);
					$con=mysqli_num_rows($resp);
					echo "
					<table class='inicio' align='center' width='99%'>
						<tr><td colspan='6' class='titulos'>.: Resultados Busqueda:</td></tr>
						<tr><td colspan='7'>Funcionarios Encontrados: $con</td></tr>
						<tr class='titulos2' >
							<td class='titulos2' width='3%'>No</td>
							<td class='titulos2' width='3%'>ID</td>
							<td class='titulos2' width='10%'>DOCUMENTO</td>
							<td class='titulos2' width='20%'>NOMBRE</td>
							<td class='titulos2' >CARGO</td>
							<td class='titulos2' width='15%'>CENTRO COSTO</td>
						</tr>";
					$iter='saludo1a';
					$iter2='saludo2';
					$conta=1;
					while ($row =mysqli_fetch_row($resp))
					{
						$datos = explode('<->',$row[1]);
						echo "
						<tr class='$iter' onClick=\"javascript:fagregar('$row[0]','$datos[1]','$datos[2]')\">
							<td>$conta</>
							<td>$row[0]</td>
							<td>$datos[1]</td>
							<td>$datos[2]</td>
							<td>$datos[0]</td>
							<td>$datos[4]</td>
						</tr>";
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
						$conta++;
					}
					echo"</table>";
				?>
        </div>
    </form>
</body>

</html>
