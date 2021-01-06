<?php //V 1000 12/12/16 ?>
<?php
    require "comun.inc";
    require "funciones.inc";
    session_start();
    $linkbd = conectar_bd();
    cargarcodigopag($_GET[codpag], $_SESSION["nivel"]);
    header("Cache-control: private"); // Arregla IE 6
    date_default_timezone_set("America/Bogota");
    ini_set('max_execution_time', 720);
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
    <meta http-equiv="X-UA-Compatible" content="IE=9"/>
    <title>:: SPID - Presupuesto</title>
    <link href="css/css2.css" rel="stylesheet" type="text/css"/>
    <link href="css/css3.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="css/calendario.js"></script>
    <script type="text/javascript" src="css/programas.js"></script>
    <script>
        function buscacta(e)
        {
            if (document.form2.cuenta.value != "")
            {
                document.form2.bc.value = 2;
                document.form2.submit();
            }
        }

        //************* ver reporte ************
        //***************************************
        function verep(idfac)
        {
            document.form1.oculto.value = idfac;
            document.form1.submit();
        }

        //************* genera reporte ************
        //***************************************
        function genrep(idfac)
        {
            document.form2.oculto.value = idfac;
            document.form2.submit();
        }

        function pdf()
        {
            document.form2.action = "pdfejecuciongastos.php";
            document.form2.target = "_BLANK";
            document.form2.submit();
            document.form2.action = "";
            document.form2.target = "";
        }

        function excell()
        {
            document.form2.action = "presu-ejecuciongastosexcel.php";
            document.form2.target = "_BLANK";
            document.form2.submit();
            document.form2.action = "";
            document.form2.target = "";
        }
    </script>
    <?php titlepag(); ?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
    <tr>
        <script>barra_imagenes("presu");</script><?php cuadro_titulos(); ?></tr>
    <tr><?php menu_desplegable("presu"); ?></tr>
    <tr>
        <?php
            $informes = [];
            $informes[1] = "538";
            $informes[2] = "539";
            $informes[3] = "540";
            $informes[4] = "541";
            $informes[5] = "543";
            $informes[6] = "544";
        ?>
        <td colspan="3" class="cinta"><a href="#" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a><a
                    href="#" class="mgbt" onClick="document.form2.submit();"><img src="imagenes/guarda.png"
                                                                                  title="Guardar"/></a><a href="#"
                                                                                                          onClick="document.form2.submit()"
                                                                                                          class="mgbt"><img
                        src="imagenes/busca.png" title="Buscar"/></a><a href="#"
                                                                        onClick="mypop=window.open('presu-principal.php','','');mypop.focus();"
                                                                        class="mgbt"><img src="imagenes/nv.png"
                                                                                          title="Nueva Ventana"></a><a
                    href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png" title="imprimir"></a><a
                    href="<?php echo "archivos/" . $_SESSION[usuario] . "informecgr" . $fec . ".csv"; ?>"
                    target="_blank" class="mgbt"><img src="imagenes/csv.png" title="cs"></a><a
                    href="descargartxt.php?id=<?php echo $informes[$_POST[reporte]] . ".txt"; ?>&dire=archivos"
                    target="_blank" class="mgbt"><img src="imagenes/contraloria.png" title="contraloria"></a></td>
    </tr>
</table>
<form name="form2" method="post" action="presu-reportescgr.php">
    <?php
        $vigusu = vigencia_usuarios($_SESSION[cedulausu]);
        $linkbd = conectar_bd();
        if ($_POST[bc] != '')
        {
            $nresul = buscacuentapres($_POST[cuenta], 2);
            if ($nresul != '')
            {
                $_POST[ncuenta] = $nresul;
                $linkbd = conectar_bd();
                $sqlr = "select *from pptocuentaspptoinicial where cuenta=$_POST[cuenta] and vigencia=" . $vigusu;
                $res = mysql_query($sqlr, $linkbd);
                $row = mysql_fetch_row($res);
                $_POST[valor] = $row[5];
                $_POST[valor2] = $row[5];

            } else
            {
                $_POST[ncuenta] = "";
            }
        }
        $sqlr = "select *from configbasica where estado='S'";
        $res = mysql_query($sqlr, $linkbd);
        while ($row = mysql_fetch_row($res))
        {
            $_POST[nitentidad] = $row[0];
            $_POST[entidad] = $row[1];
            $_POST[codent] = $row[8];
        }
    ?>
    <table align="center" class="inicio">
        <tr>
            <td class="titulos" colspan="6">.: Reportes CGR</td>
            <td width="74" class="cerrar"><a href="presu-principal.php">&nbsp;Cerrar</a></td>
        </tr>
        <tr>
            <td class="saludo1">Reporte</td>
            <td>
                <select name="reporte" id="reporte">
                    <option value="-1">Seleccione ....</option>
                    <option value="1" <?php if ($_POST[reporte] == '1') echo "selected" ?>>F50.1 PROGRAMACI&Oacute;N DE
                        INGRESOS
                    </option>
                    <option value="2" <?php if ($_POST[reporte] == '2') echo "selected" ?>>F50.2 EJECUCI&Oacute;N DE
                        INGRESOS
                    </option>
                    <option value="3" <?php if ($_POST[reporte] == '3') echo "selected" ?>>F50.4: PROGRAMACI&Oacute;N DE
                        GASTOS - VIGENCIA ACTUAL
                    </option>
                    <option value="4" <?php if ($_POST[reporte] == '4') echo "selected" ?>>F50.5: PROGRAMACI&Oacute;N DE
                        GASTOS - RESERVAS
                    </option>
                    <option value="5" <?php if ($_POST[reporte] == '5') echo "selected" ?>>F50.7: EJECUCI&Oacute;N DE
                        GASTOS - VIGENCIA ACTUAL
                    </option>
                    <option value="6" <?php if ($_POST[reporte] == '6') echo "selected" ?>>F50.8: EJECUCI&Oacute;N DE
                        GASTOS - RESERVAS
                    </option>
                </select>
            </td>
            <td class='saludo1'>
                Periodos
            </td>
            <td>
                <select name="periodos" id="periodos" onChange="validar()" style="width:45%;">
                    <option value="">Sel..</option>
                    <?php
                        $sqlr = "Select * from chip_periodos  where estado='S' order by id";
                        $resp = mysql_query($sqlr, $linkbd);
                        while ($row = mysql_fetch_row($resp))
                        {
                            if ($row[0] == $_POST[periodos])
                            {
                                echo "<option value=$row[0] SELECTED>$row[2]</option>";
                                $_POST[periodo] = $row[1];
                                $_POST[cperiodo] = $row[2];
                            } else
                            {
                                echo "<option value=$row[0]>$row[2]</option>";
                            }
                        }
                    ?>
                </select><input type="hidden" name="periodo" value="<?php echo $_POST[periodo] ?>">
                <input type="text" name="cperiodo" value="<?php echo $_POST[cperiodo] ?>" style="width:45%;" readonly>
            </td>
            <td class="saludo3" style="width:11%;">Codigo Entidad</td>
            <td><input name="codent" type="text" value="<?php echo $_POST[codent] ?>">
                <input type="button" name="generar" value="Generar" onClick="document.form2.submit()"> <input
                        type="hidden" value="1" name="oculto"></td>
        </tr>
    </table>
    <?php

        //**** busca cuenta
        if ($_POST[bc] != '')
        {
            $nresul = buscacuentapres($_POST[cuenta], 2);
            if ($nresul != '')
            {
                $_POST[ncuenta] = $nresul;

                $sqlr = "select *from pptocuentaspptoinicial where cuenta=$_POST[cuenta] and vigencia=" . $vigusu . " and vigenciaf=$vigusu";
                $res = mysql_query($sqlr, $linkbd);
                $row = mysql_fetch_row($res);
                $_POST[valor] = $row[5];
                $_POST[valor2] = $row[5];
                ?>
                <script>
                    document.form2.fecha.focus();
                    document.form2.fecha.select();
                </script>
            <?php
                }
                else
                {
                $_POST[ncuenta] = "";
            ?>
                <script>alert("Cuenta Incorrecta");
                    document.form2.cuenta.focus();</script>
                <?php
            }
        }
    ?>
    <div class="subpantallap" style="height:66.5%; width:99.6%;">
        <?php
            //**** para sacar la consulta del balance se necesitan estos datos ********
            //**** nivel, mes inicial, mes final, cuenta inicial, cuenta final, cc inicial, cc final
            $oculto = $_POST['oculto'];
            $iter = "zebra1";
            $iter2 = "zebra2";
            if ($_POST[oculto])
            {
                $acumulado = 0;
                switch ($_POST[reporte])
                {
                    case 1:
                        $namearch = "archivos/" . $_SESSION[usuario] . "informecgr" . $fec . ".csv";
                        $Descriptor1 = fopen($namearch, "w+");
                        $namearch2 = "archivos/" . $informes[$_POST[reporte]] . ".txt";
                        $Descriptor2 = fopen($namearch2, "w+");
                        echo "<table class='inicio' align='center' '>
			<tr>
				<td colspan='16' class='titulos'>.: F50.1  PROGRAMACI&Oacute;N DE INGRESOS:</td>
			</tr>
			<tr>
				<td colspan='5'>Resultados Encontrados: $ntr</td>
			</tr>
			<tr>
				<td class='titulos2' >Codigo</td>
				<td class='titulos2' >Recurso</td>
				<td class='titulos2'>Origen</td>
				<td class='titulos2' >Destino</td>
				<td class='titulos2'>Situacion de Fondos</td>
				<td class='titulos2'>Acto Administrativo</td>
				<td class='titulos2'>Inicial</td>
				<td class='titulos2'>Adicion</td>
				<td class='titulos2'>Reduccion</td>
				<td class='titulos2'>Creditos</td>
				<td class='titulos2'>Contracreditos</td>
				<td class='titulos2'>Aplazamiento</td>
				<td class='titulos2'>Desplazamiento</td>
				<td class='titulos2'>Definitivo</td>
			</tr>";

                        $mes1 = substr($_POST[periodo], 1, 2);
                        $mes2 = substr($_POST[periodo], 3, 2);
                        $_POST[fecha] = '01' . '/' . $mes1 . '/' . $vigusu;
                        $_POST[fecha2] = intval(date("t", $mes2)) . '/' . $mes2 . '/' . $vigusu;

                        ereg("([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha], $fecha);
                        $fechai = $fecha[3] . "-" . $fecha[2] . "-" . $fecha[1];
                        ereg("([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2], $fecha);
                        $fechaf = $fecha[3] . "-" . $fecha[2] . "-" . $fecha[1];
                        $linkbd = conectar_bd();
                        $sqlr1 = "select codcontaduria from configbasica";
                        $res1 = mysql_query($sqlr1, $linkbd);
                        $rowr = mysql_fetch_row($res1);
                        $res1 = $rowr[0];

                        $sqlr = "create  temporary table usr_session (id int(11),codigo varchar(100),recurso varchar(10),origen varchar(10),destino varchar(10),situacion varchar(10),acto varchar(10),inicial double,adicion double,reduccion double,definitivo double)";
                        mysql_query($sqlr, $linkbd);
                        $sqlr2 = "Select distinct cuenta, tipo, vigencia, vigenciaf from pptocuentas 
    where (clasificacion='ingresos' or clasificacion='reservas-ingresos') and  (vigencia='" . $vigusu . "' or vigenciaf='$vigusu') and tipo='Auxiliar' order by cuenta";
    
                        $pctas = [];
                        $tpctas = [];
                        $pctasvig1 = [];
                        $pctasvig2 = [];
                        $cuentanp = [];
                        $i = 0;
                        $rescta = mysql_query($sqlr2, $linkbd);
                        while ($row = mysql_fetch_row($rescta))
                        {
                            if ($row[0] != "")
                            {
                                $pctas[] = $row[0];
                                $tpctas[$row[0]] = $row[1];
                                $pctasvig1[$row[0]] = $row[2];
                                $pctasvig2[$row[0]] = $row[3];
                            }
                        }
                        mysql_free_result($rescta);

                        $i = 0;
                        fputs($Descriptor1, "S;" . $_POST[codent] . ";" . $_POST[periodo] . ";" . $vigusu . ";PROGRAMACIONDEINGRESOS\r\n");
                        fputs($Descriptor1, "S;Codigo;Recurso;Origen;Destino;Situacion de fondos; Actos administrativos;Inicial;Adicion; Reduccion; Creditos;Contracreditos; Aplazamiento; Desplazamiento; Definitivo\r\n");
                        fputs($Descriptor2, "S\t" . $_POST[codent] . "\t" . $_POST[periodo] . "\t" . $vigusu . "\tPROGRAMACIONDEINGRESOS\r\n");
                        for ($x = 0; $x < count($pctas); $x++)
                        {
                            $crit1 = " ";
                            $crit2 = " ";
                            $crit3 = " ";
                            $crit4 = " ";
                            $crit5 = " ";
                            $adicion = 0;
                            $pi = 0;
                            $reduccion = 0;
                            $tipo = 0;
                            $tipo1 = 0;
                            $cuentas = $row[0];


                            //**** codigo
                            $sqlr = "Select distinct cuenta,nombre, sidefclas, sidefrecur, sideforigen, sidefdest, sideftercero, sidefgasto, sidefgastofin, sidefdep, sideffondos  from pptocuentas where cuenta='" . $pctas[$x] . "' and (vigenciaf=$vigusu or vigencia=$vigusu)";
                            //echo $sqlr."<br>";
                            $resi = mysql_query($sqlr, $linkbd);
                            $rowi = mysql_fetch_row($resi);
                            $cuenta = $rowi[0];
                            $nomcuenta = $rowi[1];
                            $codigo = $rowi[2];
                            $recurso = $rowi[3];
                            $origen = $rowi[4];
                            $destino = $rowi[5];
                            $situacion = $rowi[10];
                            $acto = 1;
                            if ($codigo == '' || $codigo == '-1')
                            {
                                $cuentanp[] = $cuenta;
                                //echo $sqlr;
                            }

                            //*****ppto inicial ********
                            $pi = 0;

                            switch ($_POST[periodos])
                            {
                                case "1":
                                    $totaldias = cal_days_in_month(CAL_GREGORIAN, 3, date("Y"));
                                    $fechaf2 = $pctasvig1[$pctas[$x]]."-03-$totaldias";
                                    break;
                                case "2":
                                    $totaldias = cal_days_in_month(CAL_GREGORIAN, 6, date("Y"));
                                    $fechaf2 = $pctasvig1[$pctas[$x]]."-06-$totaldias";
                                    break;
                                case "3":
                                    $totaldias = cal_days_in_month(CAL_GREGORIAN, 9, date("Y"));
                                    $fechaf2 = $pctasvig1[$pctas[$x]]."-09-$totaldias";
                                    break;
                                case "4":
                                    $totaldias = cal_days_in_month(CAL_GREGORIAN, 12, date("Y"));
                                    $fechaf2 = $pctasvig1[$pctas[$x]]."-12-$totaldias";
                                    break;
                            }
                            $arregloFinal = generaReporteIngresos($pctas[$x], $pctasvig1[$pctas[$x]], $pctasvig1[$pctas[$x]] . "-01-01", $fechaf2,"S");
                            $pi = $arregloFinal[0];
                            $adicion = $arregloFinal[1];
                            $reduccion = $arregloFinal[2];
                            $definitivo = $pi + $adicion - $reduccion;
                            $i += 1;
                            if (empty($adicion) || is_null($adicion))
                            {
                                $adicion = 0;
                            }
                            if (empty($reduccion) || is_null($reduccion))
                            {
                                $reduccion = 0;
                            }
                            if (empty($definitivo) || is_null($definitivo))
                            {
                                $definitivo = 0;
                            }
                            if (empty($pi) || is_null($pi))
                            {
                                $pi = 0;
                            }
                            $sqlr = "insert into usr_session (id,codigo,recurso,origen,destino,situacion,acto,inicial,adicion,reduccion,definitivo) values($i,'" . $codigo . "','" . $recurso . "','" . $origen . "','" . $destino . "','" . $situacion . "',1," . $pi . ",'" . $adicion . "','" . $reduccion . "','" . $definitivo . "')";

                            mysql_query($sqlr, $linkbd);
                        }

                        $acumulado = 0;
                        $sqlr = "select DISTINCT codigo,recurso,origen,destino,situacion,acto,sum(inicial),sum(adicion),sum(reduccion),sum(definitivo) from usr_session group by codigo,recurso,origen,destino,situacion order by codigo ";
                        $rest = mysql_query($sqlr, $linkbd);
                        while ($rowt = mysql_fetch_row($rest))
                        {
                            $codigo = $rowt[0];
                            $recurso = $rowt[1];
                            $origen = $rowt[2];
                            $destino = $rowt[3];
                            $situacion = $rowt[4];
                            if ($situacion == '1')
                                $situacion = 'C';
                            else
                                $situacion = 'S';
                            $acto = $rowt[5];
                            $pi = $rowt[6];
                            $adicion = $rowt[7];
                            $reduccion = $rowt[8];
                            $definitivo = $rowt[9];
                            if ($codigo != '' && !($definitivo == '0' && $pi == '0' && $adicion == '0') && $codigo != '-1' && $recurso != '-1')
                            {
                                //$acumulado+=$adicion;
                                //echo $acumulado."---";
                                echo "<tr class='$iter'>
					<td >$codigo</td>
					<td >$recurso</td>
					<td >$origen</td>
					<td>$destino</td>
					<td >$situacion</td>
					<td >1</td>
					<td >" . number_format($pi, "2", ",", ".") . "</td>
					<td >" . number_format($adicion, "2", ",", ".") . "</td>
					<td>" . number_format($reduccion, "2", ",", ".") . "</td>
					<td >" . number_format($tipo, "2", ",", ".") . "</td>
					<td>" . number_format($tipo1, "2", ",", ".") . "</td>
					<td >0</td>
					<td>0</td>
					<td >" . number_format($definitivo, "2", ",", ".") . "</td>
				</tr>";
                                $aux = $iter;
                                $iter = $iter2;
                                $iter2 = $aux;
                                fputs($Descriptor1, "D;" . $codigo . ";" . $recurso . ";" . $origen . ";" . $destino . ";" . $situacion . ";1;" . round($pi) . ";" . round($adicion) . ";" . round($reduccion) . ";" . $tipo . ";" . $tipo1 . ";0;0;" . round($definitivo) . "\r\n");
                                fputs($Descriptor2, "D\t" . $codigo . "\t" . $recurso . "\t" . $origen . "\t" . $destino . "\t" . $situacion . "\t1\t" . round($pi) . "\t" . round($adicion) . "\t" . round($reduccion) . "\t" . $tipo . "\t" . $tipo1 . "\t0\t0\t" . round($definitivo) . "\r\n");
                            }
                        }
                        echo "</table>";
                        for ($d = 0; $d < count($cuentanp); $d++)
                        {
                            echo "<div class='saludo1'>No Parametrizada: $cuentanp[$d]</div>";
                        }
                        fclose($Descriptor1);
                        fclose($Descriptor2);
                        break;

                    case 2: //	EJECUCION INGRESOS
                        $cuentanp = [];
                        $namearch = "archivos/" . $_SESSION[usuario] . "informecgr" . $fec . ".csv";
                        $Descriptor1 = fopen($namearch, "w+");
                        $namearch2 = "archivos/" . $informes[$_POST[reporte]] . ".txt";
                        $Descriptor2 = fopen($namearch2, "w+");
                        echo "<table class='inicio' align='center' '>
			<tr>
				<td colspan='16' class='titulos'>.: F50.2  EJECUCI&Oacute;N DE INGRESOS:</td>
			</tr>
			<tr>
				<td colspan='5'>Resultados Encontrados: $ntr</td>
			</tr>
			<tr>
				<td class='titulos2' >Codigo</td>
				<td class='titulos2' >Recurso</td>
				<td class='titulos2'>Origen</td>
				<td class='titulos2' >Destino</td>
				<td class='titulos2'>Situacion de Fondos</td>
				<td class='titulos2'>No Reg Recaudos</td>
				<td class='titulos2'>Entidad Reciproca</td>
				<td class='titulos2'>Acto Admin</td>
				<td class='titulos2'>Recaudos</td>
				<td class='titulos2'>Devoluciones</td>
				<td class='titulos2'>Reversion Recaudos</td>
				<td class='titulos2'>Recaudos Vig Anteriores</td>
				<td class='titulos2'>REVERSION DE RECAUDOS DE VIGENCIAS ANT. (Dif de ingresos tributarios)</td>
			</tr>";


                        $mes1 = substr($_POST[periodo], 1, 2);
                        $mes2 = substr($_POST[periodo], 3, 2);
                        $_POST[fecha] = '01/01/' . $vigusu;
                        $_POST[fecha2] = intval(date("t", $mes2)) . '/' . $mes2 . '/' . $vigusu;

                        ereg("([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha], $fecha);
                        $fechai = $fecha[3] . "-" . $fecha[2] . "-" . $fecha[1];
                        ereg("([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2], $fecha);
                        $fechaf = $fecha[3] . "-" . $fecha[2] . "-" . $fecha[1];
                        $linkbd = conectar_bd();
                        $sqlr1 = "select codcontaduria from configbasica";
                        $res1 = mysql_query($sqlr1, $linkbd);
                        $rowr = mysql_fetch_row($res1);
                        $res1 = $rowr[0];

                        $sqlr = "create  temporary table usr_session (id int(11),codigo varchar(100),recurso varchar(10),origen varchar(10),destino varchar(10),situacion varchar(10),nreg varchar(10), entidad varchar(50), acto varchar(5),definitivo double, devoluciones double, reversiones double, recvigant double, revrecvigant double)";
                        mysql_query($sqlr, $linkbd);
                        $sqlr2 = "Select distinct cuenta, tipo, vigencia, vigenciaf from pptocuentas 
	where (clasificacion='ingresos' or clasificacion='reservas-ingresos') and  (vigencia='$vigusu' or vigenciaf='$vigusu') and tipo='Auxiliar' order by cuenta";

                        $pctas = [];
                        $tpctas = [];
                        $pctasvig1 = [];
                        $pctasvig2 = [];
                        $i = 0;
                        $rescta = mysql_query($sqlr2, $linkbd);
                        while ($row = mysql_fetch_row($rescta))
                        {
                            $pctas[] = $row[0];
                            $tpctas[$row[0]] = $row[1];
                            $pctasvig1[$row[0]] = $row[2];
                            $pctasvig2[$row[0]] = $row[3];

                        }
                        mysql_free_result($rescta);

                        $i = 0;
                        fputs($Descriptor1, "S;" . $_POST[codent] . ";" . $_POST[periodo] . ";" . $vigusu . ";EJECUCIONDEINGRESOS\r\n");
                        fputs($Descriptor1, "S;Codigo;Recurso;Origen;Destino;Situacion de fondos; No Reg Recaudos;Entidad Reciproca; Acto Admin; Recaudos;Devoluciones; Reversion Recaudos;Recaudos Vig Anteriores; REVERSION DE RECAUDOS DE VIGENCIAS ANT. (Dif de ingresos tributarios)\r\n");
                        fputs($Descriptor2, "S\t" . $_POST[codent] . "\t" . $_POST[periodo] . "\t" . $vigusu . "\tEJECUCIONDEINGRESOS\r\n");
                        for ($x = 0; $x < count($pctas); $x++)
                        {
                            $crit1 = " ";
                            $crit2 = " ";
                            $crit3 = " ";
                            $crit4 = " ";
                            $crit5 = " ";
                            $adicion = 0;
                            $pi = 0;
                            $reduccion = 0;
                            $cuentas = $row[0];


                            //**** codigo
                            $sqlr = "Select distinct cuenta,nombre, sidefclas, sidefrecur, sideforigen, sidefdest, sideftercero, sidefgasto, sidefgastofin, sidefdep, sideffondos  from pptocuentas where cuenta='" . $pctas[$x] . "' and (vigencia='" . $vigusu . "' or vigenciaf='$vigusu') and (tipo='Auxiliar' OR tipo='auxiliar') ";
                            $resi = mysql_query($sqlr, $linkbd);
                            $rowi = mysql_fetch_row($resi);
                            $cuenta = $rowi[0];
                            $nomcuenta = $rowi[1];
                            $codigo = $rowi[2];
                            $recurso = $rowi[3];
                            $origen = $rowi[4];
                            $destino = $rowi[5];
                            $tercero = $rowi[6];
                            $situacion = $rowi[10];
                            $acto = 1;

                            if ($codigo == '' || $codigo == '-1')
                            {
                                $cuentanp[] = $cuenta;
                            }
                            //*****ppto inicial ********
                            $vitot = 0;
                            $supertavitdef = generaSuperavit($pctas[$x], $pctasvig1[$pctas[$x]], $pctasvig1[$pctas[$x]], $fechaf);
                            //*** todos los ingresos ***
                            $recaudo = generaRecaudo($pctas[$x], $pctasvig1[$pctas[$x]], $pctasvig1[$pctas[$x]], $fechai, $fechaf);
                            $definitivo = $recaudo;
                            if (empty($definitivo) || is_null($definitivo))
                            {
                                $definitivo = 0;
                            }
                            $i += 1;
                            $sqlr = "insert into usr_session (id,codigo ,recurso ,origen ,destino ,situacion ,nreg , entidad , acto ,definitivo , devoluciones , reversiones , recvigant ,   revrecvigant) values($i,'" . $codigo . "','" . $recurso . "','" . $origen . "','" . $destino . "','" . $situacion . "','1','" . $tercero . "',1," . $definitivo . ",0,0,0,0)";
                            //echo $sqlr;
                            mysql_query($sqlr, $linkbd);
                        }

                        $sqlr = "select DISTINCT codigo ,recurso ,origen ,destino ,situacion , entidad,  sum(definitivo)  from usr_session group by codigo,recurso,origen,destino,entidad order by codigo ";
                        $rest = mysql_query($sqlr, $linkbd);
                        while ($rowt = mysql_fetch_row($rest))
                        {
                            $codigo = $rowt[0];
                            $recurso = $rowt[1];
                            $origen = $rowt[2];
                            $destino = $rowt[3];
                            $situacion = $rowt[4];
                            if ($situacion == 1)
                                $situacion = 'C';
                            else
                                $situacion = 'S';

                            $acto = 1;
                            $vitot = $rowt[6];
                            $tercero = $rowt[5];

                            if ($tercero == '0')
                            {
                                $tercero = '000000000000000';
                            }
                            if ($codigo != '' && $vitot != '0' && $codigo != '-1' && $recurso != '-1')
                            {
                                echo "<tr class='$iter'><td >$codigo</td><td >$recurso</td><td >$origen</td><td>$destino</td><td >$situacion</td><td >1</td><td >$tercero</td><td >1</td><td >" . number_format($vitot, "2", ",", ".") . "</td><td >0</td><td >0</td><td>0</td><td >0</td></tr>";
                                $aux = $iter;
                                $iter = $iter2;
                                $iter2 = $aux;
                                fputs($Descriptor1, "D;" . $codigo . ";" . $recurso . ";" . $origen . ";" . $destino . ";" . $situacion . ";1;" . $tercero . ";1;" . round($vitot) . ";0;0;0;0\r\n");
                                fputs($Descriptor2, "D\t" . $codigo . "\t" . $recurso . "\t" . $origen . "\t" . $destino . "\t" . $situacion . "\t1\t" . $tercero . "\t1\t" . round($vitot) . "\t0\t0\t0\t0\r\n");
                            }

                        }
                        echo "</table>";
                        for ($d = 0; $d < count($cuentanp); $d++)
                        {
                            echo "<div class='saludo1'>No Parametrizada: $cuentanp[$d]</div>";
                        }
                        fclose($Descriptor1);
                        fclose($Descriptor2);
                        break;

                    case 3:  //PROGRAMACION DE GASTOS
                        $namearch = "archivos/" . $_SESSION[usuario] . "informecgr" . $fec . ".csv";
                        $Descriptor1 = fopen($namearch, "w+");
                        $namearch2 = "archivos/" . $informes[$_POST[reporte]] . ".txt";
                        $Descriptor2 = fopen($namearch2, "w+");
                        echo "<table class='inicio' align='center' '>
			<tr>
			<td colspan='16' class='titulos'>.: F50.1  PROGRAMACI&Oacute;N DE INGRESOS:</td>
			</tr>
			<tr>
			<td colspan='5'>Resultados Encontrados: $ntr</td>
			</tr>
			<tr>
			<td class='titulos2' >Codigo</td>
			<td class='titulos2' >Recurso</td>
			<td class='titulos2'>Origen</td>
			<td class='titulos2' >Destino</td>
			<td class='titulos2'>Finalidad</td>
			<td class='titulos2'>Inicial</td>
			<td class='titulos2'>Adicion</td>
			<td class='titulos2'>Reduccion</td>
			<td class='titulos2'>Cancelaciones</td>
			<td class='titulos2'>Creditos</td>
			<td class='titulos2'>Contracreditos</td>
			<td class='titulos2'>Aplazamiento</td>
			<td class='titulos2'>Desplazamiento</td>
			<td class='titulos2'>Definitivo</td>
			<td class='titulos2'>Disponibilidades</td></tr>";

                        $mes1 = substr($_POST[periodo], 1, 2);
                        $mes2 = substr($_POST[periodo], 3, 2);
                        $_POST[fecha] = '01/01/' . $vigusu;
                        $_POST[fecha2] = intval(date("t", $mes2)) . '/' . $mes2 . '/' . $vigusu;

                        ereg("([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha], $fecha);
                        $fechai = $fecha[3] . "-" . $fecha[2] . "-" . $fecha[1];
                        ereg("([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2], $fecha);
                        $fechaf = $fecha[3] . "-" . $fecha[2] . "-" . $fecha[1];

                        $linkbd = conectar_bd();
                        $sqlr1 = "select codcontaduria from configbasica";
                        $res1 = mysql_query($sqlr1, $linkbd);
                        $rowr = mysql_fetch_row($res1);
                        $res1 = $rowr[0];

                        $sqlr = "create  temporary table usr_session (id int(11),codigo varchar(100),recurso varchar(10),origen varchar(10),destino varchar(10),finalidad varchar(10),acto varchar(10),inicial double,adicion double,reduccion double,creditos double,contracreditos double,definitivo double,cdps double)";
                        mysql_query($sqlr, $linkbd);

                        $sqlr2 = "Select distinct cuenta, tipo, vigencia, vigenciaf from pptocuentas 
	where clasificacion NOT LIKE '%ingresos%' and  (vigencia='" . $vigusu . "' or vigenciaf='$vigusu') and (tipo='Auxiliar' OR tipo='auxiliar') order by cuenta";

                        $pctas = [];
                        $tpctas = [];
                        $pctasvig1 = [];
                        $pctasvig2 = [];
                        $cuentanp = [];
                        $acum = 0;
                        $i = 0;
                        $rescta = mysql_query($sqlr2, $linkbd);
                        while ($row = mysql_fetch_row($rescta))
                        {
                            if ($row[0] != "")
                            {
                                $pctas[] = $row[0];
                                $tpctas[$row[0]] = $row[1];
                                $pctasvig1[$row[0]] = $row[2];
                                $pctasvig2[$row[0]] = $row[3];
                            }
                        }
                        mysql_free_result($rescta);

                        $i = 0;
                        fputs($Descriptor1, "S;" . $_POST[codent] . ";" . $_POST[periodo] . ";" . $vigusu . ";PROGRAMACIONDEGASTOS\r\n");
                        fputs($Descriptor1, "S;Codigo;Recurso;Origen;Destino;Finalidad; Inicial;Adicion; Reduccion; Cancelaciones;Creditos; Contracreditos;Aplazamiento; Desplazamiento;Definitivo;Disponibilidades)\r\n");
                        //fputs($Descriptor1,"S;$res1; 1$mesini$mesfinal; $vigusu; PROGRAMACION DE INGRESOS; ".date("Y-m-d")." \r\n");
                        //fputs($Descriptor1,"D; Codigo; Recurso; Origen; Destino; Situacion de Fondos; Acto Admin; Inicial; Adicion; Reduccion; Creditos; Contracredito; Aplazamientos; Desplazamientos; Definitivo\r\n");
                        fputs($Descriptor2, "S\t" . $_POST[codent] . "\t" . $_POST[periodo] . "\t" . $vigusu . "\tPROGRAMACIONDEGASTOS\r\n");
                        //\tfputs($Descriptor2,"S|$res1| 1$mesini$mesfinal| $vigusu| PROGRAMACION DE INGRESOS| ".date("Y-m-d")." \r\n");
                        //fputs($Descriptor2,"D| Codigo| Recurso| Origen| Destino| Situacion de Fondos| Acto Admin| Inicial| Adicion| Reduccion| Creditos| Contracredito| Aplazamientos| Desplazamientos| Definitivo\r\n");
                        for ($x = 0; $x < count($pctas); $x++)
                        {
                            $crit1 = " ";
                            $crit2 = " ";
                            $crit3 = " ";
                            $crit4 = " ";
                            $crit5 = " ";
                            $adicion = 0;
                            $pi = 0;
                            $reduccion = 0;
                            $cuentas = $row[0];


                            //**** codigo
                            $sqlr = "Select distinct cuenta,nombre, sidefclas, sidefrecur, sideforigen, sidefdest, sideftercero, sidefgasto, sidefgastofin, sidefdep, sideffondos  from pptocuentas where cuenta='" . $pctas[$x] . "' and (vigenciaf=$vigusu or vigencia=$vigusu)";
                            //echo $sqlr;
                            $resi = mysql_query($sqlr, $linkbd);
                            $rowi = mysql_fetch_row($resi);
                            $cuenta = $rowi[0];
                            $nomcuenta = $rowi[1];
                            $codigo = $rowi[2];
                            $recurso = $rowi[3];
                            $origen = $rowi[4];
                            $destino = $rowi[5];
                            $situacion = $rowi[10];
                            $finalidad = $rowi[8];
                            $acto = 1;
                            if ($codigo == '' || $codigo == '-1')
                            {
                                $cuentanp[] = $cuenta;
                                //echo $sqlr;
                            }


                            //*****ppto inicial ****************************************************************************************************************************************************
                            $pi = 0;
                            $cdps = 0;
                            $adicion = 0;
                            $reduccion = 0;
                            $definitivo = 0;

                            $arregloCuenta = generaReporteGastos($pctas[$x], $pctasvig1[$pctas[$x]], $fechai, $fechaf, "N", $pctasvig1[$pctas[$x]], $pctasvig1[$pctas[$x]], "S");
                            //****ppto inicial
                            $pi += $arregloCuenta[0];
                            //*** adiciones ***
                            $adicion += $arregloCuenta[1];
                            //*** reducciones ***
                            $reduccion += $arregloCuenta[2];
                            //*** CREDITOS ***
                            $tipo = 0;
                            $tipo1 = 0;
                            $tipo += $arregloCuenta[3];
                            //*** Contracredito ***
                            $tipo1 += $arregloCuenta[4];
                            //*** DISPONIBILIDADES ***
                            $cdps += $arregloCuenta[6];
                            //DEFINITIVOO*****************
                            $definitivo = $arregloCuenta[5];
                            if (empty($pi) || is_null($pi))
                            {
                                $pi = 0;
                            }
                            if (empty($adicion) || is_null($adicion))
                            {
                                $adicion = 0;
                            }
                            if (empty($reduccion) || is_null($reduccion))
                            {
                                $reduccion = 0;
                            }
                            if (empty($tipo) || is_null($tipo))
                            {
                                $tipo = 0;
                            }
                            if (empty($tipo1) || is_null($tipo1))
                            {
                                $tipo1 = 0;
                            }
                            if (empty($cdps) || is_null($cdps))
                            {
                                $cdps = 0;
                            }
                            if (empty($definitivo) || is_null($definitivo))
                            {
                                $definitivo = 0;
                            }
                            $sqlr = "insert into usr_session (id,codigo,recurso,origen,destino,finalidad,acto,inicial,adicion,reduccion,creditos,contracreditos,definitivo,cdps) values($i,'" . $codigo . "','" . $recurso . "','" . $origen . "','" . $destino . "','" . $finalidad . "',''," . $pi . ",$adicion,$reduccion,$tipo,$tipo1,$definitivo,$cdps)";
                            mysql_query($sqlr, $linkbd);
                        }
                        $sqlr = "select DISTINCT codigo,recurso,origen,destino,finalidad,acto,sum(inicial),sum(adicion),sum(reduccion),sum(creditos),sum(contracreditos),sum(definitivo),sum(cdps) from usr_session group by codigo,recurso,origen,destino order by codigo ";
                        $rest = mysql_query($sqlr, $linkbd);
                        $disp = 0;
                        while ($rowt = mysql_fetch_row($rest))
                        {
                            $codigo = $rowt[0];
                            $recurso = $rowt[1];
                            $origen = $rowt[2];
                            $destino = $rowt[3];
                            $finalidad = $rowt[4];
                            $acto = $rowt[5];
                            $pi = $rowt[6];
                            $adicion = $rowt[7];
                            $reduccion = $rowt[8];
                            $credito = $rowt[9];
                            $contracredito = $rowt[10];
                            $definitivo = $rowt[11];
                            $disp = $rowt[12];
                            //$codigo=$rowt[1];
                            if ($codigo != '' && !($definitivo == '0' && $pi == '0' && $adicion == '0' && $reduccion == '0' && $credito == '0' && $contracredito == '0') && $codigo != '-1')
                            {
                                echo "<tr class='$iter'><td >$codigo</td><td >$recurso</td><td >$origen</td><td>$destino</td><td >$finalidad</td><td >" . number_format($pi, "2", ",", ".") . "</td><td >" . number_format($adicion, "2", ",", ".") . "</td><td>" . number_format($reduccion, "2", ",", ".") . "</td><td >0</td><td >" . number_format($credito, "2", ",", ".") . "</td><td>" . number_format($contracredito, "2", ",", ".") . "</td><td >0</td><td>0</td><td >" . number_format($definitivo, "2", ",", ".") . "</td><td >" . number_format($disp, "2", ",", ".") . "</td></tr>";

                                $aux = $iter;
                                $iter = $iter2;
                                $iter2 = $aux;
                                fputs($Descriptor1, "D;" . $codigo . ";" . $recurso . ";" . $origen . ";" . $destino . ";" . $finalidad . ";" . round($pi) . ";" . round($adicion) . ";" . round($reduccion) . ";0;" . round($credito) . ";" . round($contracredito) . ";0;0;" . round($definitivo) . ";" . round($disp) . ";0\r\n");
                                fputs($Descriptor2, "D\t" . $codigo . "\t1\t" . $recurso . "\t" . $origen . "\t" . $destino . "\t" . $finalidad . "\t" . round($pi) . "\t" . round($adicion) . "\t" . round($reduccion) . "\t0\t" . round($credito) . "\t" . round($contracredito) . "\t0\t0\t" . round($definitivo) . "\t" . round($disp) . "\t0\r\n");
                            }
//echo "nr:".$nr;
                        }
                        echo "</table>";
                        for ($d = 0; $d < count($cuentanp); $d++)
                        {
                            echo "<div class='saludo1'>No Parametrizada: $cuentanp[$d]</div>";
                        }
                        fclose($Descriptor1);
                        fclose($Descriptor2);
                        break;

                    case 4:  //PROGRAMACION DE GASTOS - RESERVAS
                        $namearch = "archivos/" . $_SESSION[usuario] . "informecgr" . $fec . ".csv";
                        $Descriptor1 = fopen($namearch, "w+");
                        $namearch2 = "archivos/" . $informes[$_POST[reporte]] . ".txt";
                        $Descriptor2 = fopen($namearch2, "w+");
                        echo "<table class='inicio' align='center' '>
			<tr>
			<td colspan='16' class='titulos'>.: F50.1  PROGRAMACI&Oacute;N DE GASTOS:</td>
			</tr>
			<tr>
			<td colspan='5'>Resultados Encontrados: $ntr</td>
			</tr>
			<tr>
			<td class='titulos2' >Codigo</td>
			<td class='titulos2' >Recurso</td>
			<td class='titulos2'>Origen</td>
			<td class='titulos2' >Destino</td>
			<td class='titulos2'>Finalidad</td>
			<td class='titulos2'>Inicial</td>
			<td class='titulos2'>Adicion</td>
			<td class='titulos2'>Reduccion</td>
			<td class='titulos2'>Cancelaciones</td>
			<td class='titulos2'>Creditos</td>
			<td class='titulos2'>Contracreditos</td>
			<td class='titulos2'>Aplazamiento</td>
			<td class='titulos2'>Desplazamiento</td>
			<td class='titulos2'>Definitivo</td>
			<td class='titulos2'>Disponibilidades</td></tr>";

                        $mes1 = substr($_POST[periodo], 1, 2);
                        $mes2 = substr($_POST[periodo], 3, 2);
                        $_POST[fecha] = '01/01/' . $vigusu;
                        $_POST[fecha2] = intval(date("t", $mes2)) . '/' . $mes2 . '/' . $vigusu;

                        ereg("([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha], $fecha);
                        $fechai = $fecha[3] . "-" . $fecha[2] . "-" . $fecha[1];
                        ereg("([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2], $fecha);
                        $fechaf = $fecha[3] . "-" . $fecha[2] . "-" . $fecha[1];

                        $linkbd = conectar_bd();
                        $sqlr1 = "select codcontaduria from configbasica";
                        $res1 = mysql_query($sqlr1, $linkbd);
                        $rowr = mysql_fetch_row($res1);
                        $res1 = $rowr[0];

                        $sqlr = "create  temporary table usr_session (id int(11),codigo varchar(100),recurso varchar(10),origen varchar(10),destino varchar(10),finalidad varchar(10),acto varchar(10),inicial double,adicion double,reduccion double,creditos double,contracreditos double,definitivo double,cdps double)";
                        mysql_query($sqlr, $linkbd);

                        $sqlr2 = "Select distinct cuenta, tipo, vigencia, vigenciaf from pptocuentas 
	where clasificacion NOT LIKE '%ingresos%' and  (vigencia='" . $vigusu . "' or vigenciaf='$vigusu') and (tipo='Auxiliar' OR tipo='auxiliar') order by cuenta";
                        //echo "$sqlr2";
                        $pctas = [];
                        $tpctas = [];
                        $pctasvig1 = [];
                        $pctasvig2 = [];
                        $cuentanp = [];
                        $i = 0;
                        $rescta = mysql_query($sqlr2, $linkbd);
                        while ($row = mysql_fetch_row($rescta))
                        {
                            if ($row[0] != "")
                            {
                                $pctas[] = $row[0];
                                $tpctas[$row[0]] = $row[1];
                                $pctasvig1[$row[0]] = $row[2];
                                $pctasvig2[$row[0]] = $row[3];
                            }
                        }
                        mysql_free_result($rescta);

                        $i = 0;
                        fputs($Descriptor1, "S;" . $_POST[codent] . ";" . $_POST[periodo] . ";" . $vigusu . ";PROGRAMACIONDEGASTOS\r\n");
                        fputs($Descriptor1, "S;Codigo;Recurso;Origen;Destino;Finalidad; Inicial;Adicion; Reduccion; Cancelaciones;Creditos; Contracreditos;Aplazamiento; Desplazamiento;Definitivo;Disponibilidades)\r\n");
                        //fputs($Descriptor1,"S;$res1; 1$mesini$mesfinal; $vigusu; PROGRAMACION DE INGRESOS; ".date("Y-m-d")." \r\n");
                        //fputs($Descriptor1,"D; Codigo; Recurso; Origen; Destino; Situacion de Fondos; Acto Admin; Inicial; Adicion; Reduccion; Creditos; Contracredito; Aplazamientos; Desplazamientos; Definitivo\r\n");
                        fputs($Descriptor2, "S\t" . $_POST[codent] . "\t" . $_POST[periodo] . "\t" . $vigusu . "\tPROGRAMACIONDEGASTOS\r\n");
                        //\tfputs($Descriptor2,"S|$res1| 1$mesini$mesfinal| $vigusu| PROGRAMACION DE INGRESOS| ".date("Y-m-d")." \r\n");
                        //fputs($Descriptor2,"D| Codigo| Recurso| Origen| Destino| Situacion de Fondos| Acto Admin| Inicial| Adicion| Reduccion| Creditos| Contracredito| Aplazamientos| Desplazamientos| Definitivo\r\n");
                        for ($x = 0; $x < count($pctas); $x++)
                        {
                            $crit1 = " ";
                            $crit2 = " ";
                            $crit3 = " ";
                            $crit4 = " ";
                            $crit5 = " ";
                            $adicion = 0;
                            $pi = 0;
                            $reduccion = 0;
                            $cuentas = $row[0];


                            //**** codigo
                            $sqlr = "Select distinct cuenta,nombre, sidefclas, sidefrecur, sideforigen, sidefdest, sideftercero, sidefgasto, sidefgastofin, sidefdep, sideffondos  from pptocuentas where cuenta='" . $pctas[$x] . "' and (vigenciaf=$vigusu or vigencia=$vigusu)";
                            //echo $sqlr;
                            $resi = mysql_query($sqlr, $linkbd);
                            $rowi = mysql_fetch_row($resi);
                            $cuenta = $rowi[0];
                            $nomcuenta = $rowi[1];
                            $codigo = $rowi[2];
                            $recurso = $rowi[3];
                            $origen = $rowi[4];
                            $destino = $rowi[5];
                            $situacion = $rowi[10];
                            $finalidad = $rowi[8];
                            $acto = 1;
                            if ($codigo == '' || $codigo == '-1')
                            {
                                $cuentanp[] = $cuenta;
                                //echo $sqlr;
                            }


                            //*****ppto inicial ****************************************************************************************************************************************************
                            $pi = 0;
                            $cdps = 0;
                            $adicion = 0;
                            $reduccion = 0;
                            //$arregloCuenta=generaVectorCuenta($pctas[$x],$pctasvig1[$pctas[$x]],$fechaf);
                            $arregloCuenta = generaReporteGastos($pctas[$x], $pctasvig1[$pctas[$x]], $fechai, $fechaf, "N", $pctasvig1[$pctas[$x]], $pctasvig1[$pctas[$x]], "S");
                            //****ppto inicial
                            $pi += $arregloCuenta[0];
                            //*** adiciones ***
                            $adicion += $arregloCuenta[1];
                            //*** reducciones ***
                            $reduccion += $arregloCuenta[2];
                            //*** CREDITOS ***
                            $tipo = 0;
                            $tipo1 = 0;
                            $tipo += $arregloCuenta[3];
                            //*** Contracredito ***
                            $tipo1 += $arregloCuenta[4];
                            //*** DISPONIBILIDADES ***
                            $cdps += $arregloCuenta[6];
                            //DEFINITIVOO*****************
                            $definitivo = $arregloCuenta[5];


                            $sqlr = "insert into usr_session (id,codigo,recurso,origen,destino,finalidad,acto,inicial,adicion,reduccion,creditos,contracreditos,definitivo,cdps) values($i,'" . $codigo . "','" . $recurso . "','" . $origen . "','" . $destino . "','" . $finalidad . "',''," . $pi . ",$adicion,$reduccion,$tipo,$tipo1,$definitivo,$cdps)";
                            mysql_query($sqlr, $linkbd);
                        }
                        $sqlr = "select DISTINCT codigo,recurso,origen,destino,finalidad,acto,sum(inicial),sum(adicion),sum(reduccion),sum(creditos),sum(contracreditos),sum(definitivo),sum(cdps) from usr_session group by codigo,recurso,origen,destino order by codigo ";
                        $rest = mysql_query($sqlr, $linkbd);
                        $disp = 0;
                        while ($rowt = mysql_fetch_row($rest))
                        {
                            $codigo = $rowt[0];
                            $recurso = $rowt[1];
                            $origen = $rowt[2];
                            $destino = $rowt[3];
                            $finalidad = $rowt[4];
                            $acto = $rowt[5];
                            $pi = $rowt[6];
                            $adicion = $rowt[7];
                            $reduccion = $rowt[8];
                            $credito = $rowt[9];
                            $contracredito = $rowt[10];
                            $definitivo = $rowt[11];
                            $disp = $rowt[12];
                            //$codigo=$rowt[1];
                            if ($codigo != '' && !($definitivo == '0' && $pi == '0' && $adicion == '0' && $reduccion == '0' && $credito == '0' && $contracredito == '0') && $codigo != '-1')
                            {
                                echo "<tr class='$iter'><td >$codigo</td><td >$recurso</td><td >$origen</td><td>$destino</td><td >$finalidad</td><td >" . number_format($pi, "2", ",", ".") . "</td><td >" . number_format($adicion, "2", ",", ".") . "</td><td>" . number_format($reduccion, "2", ",", ".") . "</td><td >0</td><td >" . number_format($credito, "2", ",", ".") . "</td><td>" . number_format($contracredito, "2", ",", ".") . "</td><td >0</td><td>0</td><td >" . number_format($definitivo, "2", ",", ".") . "</td><td >" . number_format($disp, "2", ",", ".") . "</td></tr>";

                                $aux = $iter;
                                $iter = $iter2;
                                $iter2 = $aux;
                                fputs($Descriptor1, "D;" . $codigo . ";" . $recurso . ";" . $origen . ";" . $destino . ";" . $finalidad . ";" . round($pi) . ";" . round($adicion) . ";" . round($reduccion) . ";0;" . round($credito) . ";" . round($contracredito) . ";0;0;" . round($definitivo) . ";" . round($disp) . ";0\r\n");
                                fputs($Descriptor2, "D\t" . $codigo . "\t1\t" . $recurso . "\t" . $origen . "\t" . $destino . "\t" . $finalidad . "\t" . round($pi) . "\t" . round($adicion) . "\t" . round($reduccion) . "\t0\t" . round($credito) . "\t" . round($contracredito) . "\t0\t0\t" . round($definitivo) . "\t" . round($disp) . "\t0\r\n");
                            }
//echo "nr:".$nr;
                        }
                        echo "</table>";
                        for ($d = 0; $d < count($cuentanp); $d++)
                        {
                            echo "<div class='saludo1'>No Parametrizada: $cuentanp[$d]</div>";
                        }
                        fclose($Descriptor1);
                        fclose($Descriptor2);
                        break;


                    case 5: //**EJECUCION DE GASTOS
                        $namearch = "archivos/" . $_SESSION[usuario] . "informecgr" . $fec . ".csv";
                        $Descriptor1 = fopen($namearch, "w+");
                        $namearch2 = "archivos/" . $informes[$_POST[reporte]] . ".txt";
                        $Descriptor2 = fopen($namearch2, "w+");
                        echo "<table class='inicio' align='center' '><tr><td colspan='21' class='titulos'>.: F50.1  EJECUCION DE GASTOS:</td></tr><tr><td colspan='21'>Resultados Encontrados: $ntr</td></tr><tr><td class='titulos2' >Codigo</td><td class='titulos2' >Dependencia</td><td class='titulos2' >Recurso</td><td class='titulos2'>Origen</td><td class='titulos2' >Destino</td><td class='titulos2'>Finalidad Gasto</td><td class='titulos2'>Situacion de Fondos</td><td class='titulos2'>N Registro Compromiso</td><td class='titulos2'>N Registro Obligacion</td><td class='titulos2'>N pago</td><td class='titulos2'>Entidad Reciproca</td><td class='titulos2'>Compromiso con Anticipo Pactados</td><td class='titulos2'>Compromiso sin Anticipo Pactados</td><td class='titulos2'>Reversion Gastos Comprometidos</td><td class='titulos2'>Gastos Obligados</td><td class='titulos2'>Reversion Gastos Obligados</td><td class='titulos2'>Pagos</td><td class='titulos2'>Anulacion Pagos</td><td class='titulos2'>Reservas Presupuestales</td><td class='titulos2'>Cuentas por Pagar</td><td class='titulos2'>Obligaciones Por Ejecutar</td></tr>";

                        $mes1 = substr($_POST[periodo], 1, 2);
                        $mes2 = substr($_POST[periodo], 3, 2);
                        $_POST[fecha] = '01/01/' . $vigusu;
                        $_POST[fecha2] = intval(date("t", $mes2)) . '/' . $mes2 . '/' . $vigusu;

                        ereg("([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha], $fecha);
                        $fechai = $fecha[3] . "-" . $fecha[2] . "-" . $fecha[1];
                        ereg("([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2], $fecha);
                        $fechaf = $fecha[3] . "-" . $fecha[2] . "-" . $fecha[1];

                        $linkbd = conectar_bd();
                        $sqlr1 = "select codcontaduria from configbasica";
                        $res1 = mysql_query($sqlr1, $linkbd);
                        $rowr = mysql_fetch_row($res1);
                        $res1 = $rowr[0];

                        $sqlr = "create  temporary table usr_session (id int(11),codigo varchar(100),dependencia varchar(100),recurso varchar(10),origen varchar(10),destino varchar(10),finalidad varchar(10),situacion varchar(10),entidad varchar(20),compconant double,compsinant double,revgascomp double,obligacion double,revobligacion double,pagos double,anulapagos double,reservas double,cxp double,obligaxeje double)";
                        mysql_query($sqlr, $linkbd);

                        $sqlr2 = "Select distinct cuenta, tipo, vigencia, vigenciaf,clasificacion from pptocuentas 
	where clasificacion NOT LIKE '%ingresos%' AND clasificacion NOT LIKE '%reservas-gastos%' and  (vigencia='" . $vigusu . "' or vigenciaf='$vigusu') and (tipo='Auxiliar' OR tipo='auxiliar') order by cuenta";
//echo "$sqlr2";
                        $pctas = [];
                        $tpctas = [];
                        $pctasvig1 = [];
                        $pctasvig2 = [];
                        $cuentanp = [];
                        $i = 0;
                        $rescta = mysql_query($sqlr2, $linkbd);
                        while ($row = mysql_fetch_row($rescta))
                        {
                            if ($row[0] != "")
                            {
                                $pctas[] = $row[0];
                                $tpctas[$row[0]] = $row[1];
                                $pctasvig1[$row[0]] = $row[2];
                                $pctasvig2[$row[0]] = $row[3];
                                $clasicuen[$row[0]] = $row[4];
                            }
                        }
                        mysql_free_result($rescta);

                        $i = 0;
                        fputs($Descriptor1, "S;" . $_POST[codent] . ";" . $_POST[periodo] . ";" . $vigusu . ";EJECUCIONDEGASTOS\r\n");
                        fputs($Descriptor1, "S;Codigo;Dependencia;Recurso;Origen;Destino; Finalidad Gasto;Situacion de Fondos; N Registro Compromiso; N Registro Obligacion;N pago; Entidad Reciproca;Compromiso con Anticipo Pactados; Compromiso sin Anticipo Pactados;Reversion Gastos Comprometidos	;Gastos Obligados;Reversion Gastos Obligados;Pagos;Anulacion Pagos;Reservas Presupuestales;Cuentas por Pagar;Obligaciones Por Ejecutar \r\n");
                        //fputs($Descriptor1,"S;$res1; 1$mesini$mesfinal; $vigusu; PROGRAMACION DE INGRESOS; ".date("Y-m-d")." \r\n");
                        //fputs($Descriptor1,"D; Codigo; Recurso; Origen; Destino; Situacion de Fondos; Acto Admin; Inicial; Adicion; Reduccion; Creditos; Contracredito; Aplazamientos; Desplazamientos; Definitivo\r\n");
                        fputs($Descriptor2, "S\t" . $_POST[codent] . "\t" . $_POST[periodo] . "\t" . $vigusu . "\tEJECUCIONDEGASTOS\r\n");
                        //\tfputs($Descriptor2,"S|$res1| 1$mesini$mesfinal| $vigusu| PROGRAMACION DE INGRESOS| ".date("Y-m-d")." \r\n");
                        //fputs($Descriptor2,"D| Codigo| Recurso| Origen| Destino| Situacion de Fondos| Acto Admin| Inicial| Adicion| Reduccion| Creditos| Contracredito| Aplazamientos| Desplazamientos| Definitivo\r\n");
                        for ($x = 0; $x < count($pctas); $x++)
                        {
                            $crit1 = " ";
                            $crit2 = " ";
                            $crit3 = " ";
                            $crit4 = " ";
                            $crit5 = " ";
                            $adicion = 0;
                            $pi = 0;
                            $reduccion = 0;
                            $cuentas = $row[0];


                            //**** codigo
                            $sqlr = "Select distinct cuenta,nombre, sidefclas, sidefrecur, sideforigen, sidefdest, sideftercero, sidefgasto, sidefgastofin, sidefdep, sideffondos  ,sidefdep from pptocuentas where cuenta='" . $pctas[$x] . "' and (vigenciaf=$vigusu or vigencia=$vigusu)";

                            //echo $sqlr;
                            $resi = mysql_query($sqlr, $linkbd);
                            $rowi = mysql_fetch_row($resi);
                            $cuenta = $rowi[0];
                            $nomcuenta = $rowi[1];
                            $codigo = $rowi[2];
                            $recurso = $rowi[3];
                            $origen = $rowi[4];
                            $destino = $rowi[5];
                            $finalidad = $rowi[8];
                            $tercero = $rowi[6];
                            $situacion = $rowi[10];
                            $dependencia = $rowi[11];
                            $acto = 1;
                            if ($codigo == '' || $codigo == '-1')
                            {
                                $cuentanp[] = $cuenta;
                                //echo $sqlr;
                            }
                            //*****ppto inicial ********
                            $pi = 0;
                            $oblig = 0;
                            $rps = 0;
                            $pagos = 0;
                            $cxp = 0;
                            $oblxeje = 0;

                            //$arregloCuenta=generaVectorCuenta($pctas[$x],$pctasvig1[$pctas[$x]],$fechaf);
                            $arregloCuenta = generaReporteGastos($pctas[$x], $pctasvig1[$pctas[$x]], $fechai, $fechaf, "N", $pctasvig1[$pctas[$x]], $pctasvig1[$pctas[$x]], "S");
                            $pdef = $arregloCuenta[5];
                            $reser = $arregloCuenta[7] - $arregloCuenta[8];
                            $pagos += $arregloCuenta[9];
                            $oblig += $arregloCuenta[8];
                            $rps += $arregloCuenta[7];
                            $cxp = $oblig - $pagos;
                            $oblxeje = $rps - $oblig;
                            $i += 1;


                            $sqlr = "insert into usr_session (id,codigo,dependencia,recurso,origen,destino,finalidad,situacion,entidad,compconant,compsinant,revgascomp,obligacion ,revobligacion,pagos,anulapagos,reservas,cxp,obligaxeje) values($i,'" . $codigo . "','" . $dependencia . "','" . $recurso . "','" . $origen . "','" . $destino . "','" . $finalidad . "','" . $situacion . "','" . $tercero . "',0," . $rps . ",0,$oblig,0,$pagos,0,0,$cxp,$oblxeje)";
                            mysql_query($sqlr, $linkbd);
                        }
                        $sqlr = "select DISTINCT codigo,dependencia,recurso,origen,destino,finalidad,situacion,entidad,sum(compconant),sum(compsinant),sum(revgascomp),sum(obligacion),sum(revobligacion),sum(pagos),sum(anulapagos),sum(reservas),sum(cxp) ,sum(obligaxeje)  from usr_session group by codigo,dependencia,recurso,origen,destino order by codigo ";
//	$sqlr="select * from usr_session order by codigo ";
                        //echo "<br>".$sqlr;
                        $rest = mysql_query($sqlr, $linkbd);
                        while ($rowt = mysql_fetch_row($rest))
                        {
                            $codigo = $rowt[0];
                            $recurso = $rowt[2];
                            $origen = $rowt[3];
                            $destino = $rowt[4];
                            $situacion = $rowt[6];
                            if ($situacion == '1')
                                $situacion = 'C';
                            else
                                $situacion = 'S';
                            $rpsc = $rowt[8];
                            $rp = $rowt[9];
                            $revrp = $rowt[10];
                            $obliga = $rowt[11];
                            $revobliga = $rowt[12];
                            $pag = $rowt[13];
                            $anpag = $rowt[14];
                            $rese = $rowt[15];
                            $cx = $rowt[16];
                            $oxe = $rowt[17];

                            $finalidad = $rowt[5];
                            $tercero = $rowt[7];
                            if ($tercero == '0')
                            {
                                $tercero = '000000000000000';
                            }
                            $dependencia = $rowt[1];
                            if ($codigo != '' && !($obliga == '0' && $revobliga == '0' && $pag == '0') && $codigo != '-1')
                            {
                                echo "<tr class='$iter'>
				<td >$codigo</td>
				<td >$dependencia</td>
				<td >$recurso</td>
				<td >$origen</td>
				<td>$destino</td>
				<td >$finalidad</td>
				<td >$situacion</td>
				<td >1</td>
				<td >1</td>
				<td >1</td>
				<td >$tercero</td>
				<td >" . number_format($rpsc, "2", ",", ".") . "</td>
				<td >" . number_format($rp, "2", ",", ".") . "</td>
				<td>" . number_format($revrp, "2", ",", ".") . "</td>
				<td >" . number_format($obliga, "2", ",", ".") . "</td>
				<td>" . number_format($revobliga, "2", ",", ".") . "</td>
				<td >$pag</td>
				<td>$anpag</td>
				<td >" . number_format($rese, "2", ",", ".") . "</td>
				<td >" . number_format($cx, "2", ",", ".") . "</td>
				<td >" . number_format($oxe, "2", ",", ".") . "</td>
		</tr>";
                                $aux = $iter;
                                $iter = $iter2;
                                $iter2 = $aux;
                                fputs($Descriptor1, "D;" . $codigo . ";" . $dependencia . ";" . $recurso . ";" . $origen . ";" . $destino . ";" . $finalidad . ";" . $situacion . ";1;1;1;$tercero;" . $rpsc . ";" . $rp . ";" . $revrp . ";" . $obliga . ";" . $revobliga . ";" . $pag . ";" . $anpag . ";" . $rese . ";" . $cx . ";" . $oxe . "\r\n");

                                fputs($Descriptor2, "D\t" . $codigo . "\t1\t" . $dependencia . "\t" . $recurso . "\t" . $origen . "\t" . $destino . "\t" . $finalidad . "\t" . $situacion . "\t1\t1\t1\t" . $tercero . "\t" . $rpsc . "\t" . $rp . "\t" . $revrp . "\t" . $obliga . "\t" . $revobliga . "\t" . $pag . "\t" . $anpag . "\t" . $rese . "\t" . $cx . "\t" . $oxe . "\r\n");
                                //fputs($Descriptor2,"D\t".$codigo."\t1\t".$recurso."\t".$origen."\t".$destino."\t".$situacion."\t1\t".$pi."\t".$adicion."\t".$reduccion."\t".$credito."\t".$contracredito."\t0\t0\t".$definitivo."\t".$disp."\r\n");
                            }
//echo "nr:".$nr;
                        }
                        echo "</table>";
                        for ($d = 0; $d < count($cuentanp); $d++)
                        {
                            echo "<div class='saludo1'>No Parametrizada: $cuentanp[$d]</div>";
                        }
                        fclose($Descriptor1);
                        fclose($Descriptor2);
                        break;


                }
            }
        ?>
    </div>
</form>
</td></tr>
</table>
</body>
</html>