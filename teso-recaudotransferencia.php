<?php
    require "comun.inc";
    require "funciones.inc";
    require "conversor.php";
    session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html"/>
    <meta http-equiv="X-UA-Compatible" content="IE=9"/>
    <title>:: SPID - Tesoreria</title>

    <script>
        //************* ver reporte ************
        //***************************************
        function verep(idfac)
        {
            document.form1.oculto.value = idfac;
            document.form1.submit();
        }
    </script>
    <script>
        //************* genera reporte ************
        //***************************************
        function genrep(idfac)
        {
            document.form2.oculto.value = idfac;
            document.form2.submit();
        }
    </script>
    <script>
        function buscacta(e)
        {
            if (document.form2.cuenta.value != "")
            {
                document.form2.bc.value = '1';
                document.form2.submit();
            }
        }
    </script>
    <script language="JavaScript1.2">
        function validar()
        {
            document.form2.submit();
        }
    </script>
    <script>
        function buscater(e)
        {
            if (document.form2.tercero.value != "")
            {
                document.form2.bt.value = '1';
                document.form2.submit();
            }
        }
    </script>
    <script>
        function agregardetalle()
        {
            if (document.form2.codingreso.value != "" && document.form2.valor.value > 0)
            {
                document.form2.agregadet.value = 1;
                //			document.form2.chacuerdo.value=2;
                document.form2.submit();
            } else
            {
                alert("Falta informacion para poder Agregar");
            }
        }
    </script>
    <script>
        function eliminar(variable)
        {
            if (confirm("Esta Seguro de Eliminar"))
            {
                document.form2.elimina.value = variable;
//eli=document.getElementById(elimina);
                vvend = document.getElementById('elimina');
//eli.value=elimina;
                vvend.value = variable;
                document.form2.submit();
            }
        }
    </script>
    <script>
        //************* genera reporte ************
        //***************************************
        function guardar()
        {
            ingresos2 = document.getElementsByName('dcoding[]');
            if (document.form2.fecha.value != '' && ingresos2.length > 0 && document.form2.presupuesto.value != '-1')
            {
                if (confirm("Esta Seguro de Guardar"))
                {
                    document.form2.oculto.value = 2;
                    document.form2.submit();
                }
            } else
            {
                alert('Faltan datos para completar el registro');
                document.form2.fecha.focus();
                document.form2.fecha.select();
            }
        }
    </script>
    <script>
        function pdf()
        {
            document.form2.action = "teso-pdfrecaudostrans.php";
            document.form2.target = "_BLANK";
            document.form2.submit();
            document.form2.action = "";
            document.form2.target = "";
        }
    </script>
    <script>
        function buscater(e)
        {
            if (document.form2.tercero.value != "")
            {
                document.form2.bt.value = '1';
                document.form2.submit();
            }
        }
    </script>
    <script>
        function buscaing(e)
        {
            if (document.form2.codingreso.value != "")
            {
                document.form2.bin.value = '1';
                document.form2.submit();
            }
        }

        function despliegamodal2(_valor, _num)
        {
            document.getElementById("bgventanamodal2").style.visibility = _valor;
            if (_valor == "hidden")
            {
                document.getElementById('ventana2').src = "";
            } else
            {
                switch (_num)
                {
                    case '1':
                        document.getElementById('ventana2').src = "cuentasbancarias-ventana02.php?tipoc=D&obj01=banco&obj02=nbanco&obj03=&obj04=cb&obj05=ter";
                        break;
                    case '2':
                        document.getElementById('ventana2').src = "teso-liquidacionrecaudo.php";
                        break;
                }
            }
        }

        function respuestamensaje()
        {
            location.href = "teso-editarecaudotransferencia.php?idrecaudo=" + document.form2.idcomp.value;
        }

    </script>
    <script src="css/programas.js"></script>
    <script src="css/calendario.js"></script>
    <link href="css/css2.css" rel="stylesheet" type="text/css"/>
    <link href="css/css3.css" rel="stylesheet" type="text/css"/>
    <link href="css/tabs.css" rel="stylesheet" type="text/css"/>
    <?php titlepag(); ?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
    <tr>
        <script>barra_imagenes("teso");</script><?php cuadro_titulos(); ?></tr>
    <tr><?php menu_desplegable("teso"); ?></tr>
    <tr>
        <td colspan="3" class="cinta">
            <a href="teso-recaudotransferencia.php" class="mgbt"><img src="imagenes/add.png" alt="Nuevo"
                                                                      border="0"/></a>
            <a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" alt="Guardar"/></a>
            <a href="teso-buscarecaudotransferencia.php" class="mgbt"> <img src="imagenes/busca.png" alt="Buscar"/></a>
            <a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img
                        src="imagenes/agenda1.png" title="Agenda"/></a>
            <a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img
                        src="imagenes/nv.png" alt="nueva ventana"></a>
            <a href="#" <?php if ($_POST[oculto] == 2) { ?> onClick="pdf()"  <?php } ?> class="mgbt"> <img
                        src="imagenes/print.png" alt="Buscar"/></a>
        </td>
    </tr>
</table>
<tr>
    <td colspan="3" class="tablaprin" align="center">
        <?php
            $linkbd = conectar_bd();
            $vigusu = vigencia_usuarios($_SESSION[cedulausu]);
            $vigencia = $vigusu;
            $_POST[vigencia] = $vigencia;
        ?>
        <?php
            //*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
            if (!$_POST[oculto])
            {
                $check1 = "checked";
                $fec = date("d/m/Y");
                $_POST[vigencia] = $vigencia;

                $sqlr = "select valor_inicial from dominios where nombre_dominio='CUENTA_CAJA'";
                $res = mysql_query($sqlr, $linkbd);
                while ($row = mysql_fetch_row($res))
                {
                    $_POST[cuentacaja] = $row[0];
                }
                /*$sqlr="select max(numerotipo) from comprobante_cab where tipo_comp='2' and EXTRACT(YEAR FROM fecha)=".$_SESSION["vigencia"];
                $res=mysql_query($sqlr,$linkbd);
                $consec=0;
                while($r=mysql_fetch_row($res))
                 {
                  $consec=$r[0];
                 }
                 $consec+=1;*/
                $sqlr = "select max(id_recaudo) from tesorecaudotransferencia ";
                $res = mysql_query($sqlr, $linkbd);
                $consec = 0;
                while ($r = mysql_fetch_row($res))
                {
                    $consec = $r[0];
                }
                $consec += 1;
                $_POST[idcomp] = $consec;
                $fec = date("d/m/Y");
                $_POST[fecha] = $fec;
                $_POST[valor] = 0;
            }
            switch ($_POST[tabgroup1])
            {
                case 1:
                    $check1 = 'checked';
                    break;
                case 2:
                    $check2 = 'checked';
                    break;
                case 3:
                    $check3 = 'checked';
            }
            $_POST[dcoding] = [];
            $_POST[dncoding] = [];
            $_POST[dvalores] = [];
            $sqlr = "select distinct *from  tesorecaudotransferencialiquidar_det   where	 tesorecaudotransferencialiquidar_det.id_recaudo=$_POST[idrecaudo]";
            $res = mysql_query($sqlr, $linkbd);
            $cont = 0;
            //echo $sqlr;
            //$_POST[idcomp]=$_GET[idrecaudo];
            $total = 0;
            while ($row = mysql_fetch_row($res))
            {
                $_POST[dcoding][] = $row[2];
                $_POST[dncoding][] = buscaingreso($row[2]);
                $_POST[dvalores][] = $row[3];
            }
            $sqlr = "select distinct *from  tesorecaudotransferencialiquidar   where	 tesorecaudotransferencialiquidar.id_recaudo=$_POST[idrecaudo]";
            $res = mysql_query($sqlr, $linkbd);
            $cont = 0;
            //echo $sqlr;
            //$_POST[idcomp]=$_GET[idrecaudo];
            $total = 0;
            while ($row = mysql_fetch_row($res))
            {
                $_POST[concepto] = $row[6];
                $_POST[tercero] = $row[7];
                $_POST[ntercero] = buscatercero($row[7]);
                $_POST[cc] = $row[8];
                $_POST[medioDePago] = $row[11];
            }


        ?>
        <form name="form2" method="post" action="">
            <?php
                //***** busca tercero
                if ($_POST[bt] == '1')
                {
                    $nresul = buscatercero($_POST[tercero]);
                    if ($nresul != '')
                    {
                        $_POST[ntercero] = $nresul;

                    } else
                    {
                        $_POST[ntercero] = "";
                    }
                }
                //******** busca ingreso *****
                //***** busca tercero
                if ($_POST[bin] == '1')
                {
                    $nresul = buscaingreso($_POST[codingreso]);
                    if ($nresul != '')
                    {
                        $_POST[ningreso] = $nresul;

                    } else
                    {
                        $_POST[ningreso] = "";
                    }
                }

            ?>


            <table class="inicio" align="center">
                <tr>
                    <td class="titulos" style="width:93%;" colspan="3"> Recaudos Transferencias</td>
                    <td class="cerrar" style="width:7%;"><a href="teso-principal.php">Cerrar</a></td>
                </tr>
                <tr>
                    <td style="width:80%;">
                        <table>
                            <tr>
                                <td style="width:8%;" class="saludo1">No Recaudo:</td>
                                <td style="width:10%;">
                                    <input name="idcomp" type="text" value="<?php echo $_POST[idcomp] ?>"
                                           style="width:75%;" onKeyUp="return tabular(event,this) " readonly>
                                </td>
                                <td style="width:5%;" class="saludo1">Fecha:</td>
                                <td style="width:7%;">
                                    <input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY"
                                           value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) "
                                           onKeyDown="mascara(this,'/',patron,true)" maxlength="10" style="width:80%;">
                                    <a href="#" onClick="displayCalendarFor('fc_1198971545');">
                                        <img src="imagenes/buscarep.png" align="absmiddle" border="0">
                                    </a>
                                </td>
                                <td style="width:3%;" class="saludo1">No Liquid:</td>
                                <td style="width:5%;">
                                    <input type="text" id="idrecaudo" name="idrecaudo"
                                           value="<?php echo $_POST[idrecaudo] ?>" style="width:70%;"
                                           onKeyUp="return tabular(event,this)" onBlur="validar()"><a
                                            onClick="despliegamodal2('visible','2');" style="cursor:pointer;"
                                            title="Listado Ordenes Pago"><img src="imagenes/find02.png"
                                                                              style="width:20px;"/></a>
                                </td>
                                <td style="width:8%;" class="saludo1">Centro Costo:</td>
                                <td style="width:10%;">
                                    <select name="cc" onChange="validar()" style="width:100%;"
                                            onKeyUp="return tabular(event,this)">
                                        <?php
                                            $linkbd = conectar_bd();
                                            $sqlr = "select *from centrocosto where estado='S'";
                                            $res = mysql_query($sqlr, $linkbd);
                                            while ($row = mysql_fetch_row($res))
                                            {
                                                echo "<option value=$row[0] ";
                                                $i = $row[0];
                                                if ($i == $_POST[cc])
                                                {
                                                    echo "SELECTED";
                                                }
                                                echo ">" . $row[0] . " - " . $row[1] . "</option>";
                                            }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:6%;" class="saludo1">Concepto Recaudo:</td>
                                <td colspan="3">
                                    <input name="concepto" type="text" value="<?php echo $_POST[concepto] ?>"
                                           style="width:100%;" onKeyUp="return tabular(event,this)" readonly>
                                </td>
                                <td style="width:3%;" class="saludo1">Vigencia:</td>
                                <td style="width:5%;">
                                    <input type="text" id="vigencia" name="vigencia" style="width:100%;"
                                           onKeyPress="javas cript:return solonumeros(event)"
                                           onKeyUp="return tabular(event,this)" value="<?php echo $_POST[vigencia] ?>"
                                           onClick="document.getElementById('tipocta').focus(); document.getElementById('tipocta').select();"
                                           readonly>
                                </td>
                                <td class="saludo1">Ingresa presupuesto?</td>
                                <td style="width:14%;">
                                    <select name="presupuesto" id="presupuesto" onKeyUp="return tabular(event,this)"
                                            style="width:100%">
                                        <option value="1" <?php if (($_POST[presupuesto] == '1')) echo "SELECTED"; ?>>
                                            SI
                                        </option>
                                        <option value="2" <?php if ($_POST[presupuesto] == '2') echo "SELECTED"; ?>>NO
                                        </option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <?php
                                    if ($_POST[medioDePago] != 2)
                                    {
                                        ?>
                                        <td style="width:5%;" class="saludo1">Recaudado:</td>
                                        <td style="width:10%;">
                                            <!--
									<select id="banco" name="banco"  onChange="validar()" onKeyUp="return tabular(event,this)">
										<option value="">Seleccione....</option>
										<?php
                                                $linkbd = conectar_bd();
                                                $sqlr = "select tesobancosctas.estado, tesobancosctas.cuenta, tesobancosctas.ncuentaban, tesobancosctas.tipo, terceros.razonsocial, tesobancosctas.tercero from tesobancosctas,terceros where tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.estado='S' ";
                                                $res = mysql_query($sqlr, $linkbd);
                                                while ($row = mysql_fetch_row($res))
                                                {
                                                    echo "<option value=$row[1] ";
                                                    $i = $row[1];
                                                    $ncb = buscacuenta($row[1]);
                                                    if ($i == $_POST[banco])
                                                    {
                                                        echo "SELECTED";
                                                        $_POST[nbanco] = $row[4];
                                                        $_POST[ter] = $row[5];
                                                        $_POST[cb] = $row[2];
                                                    }
                                                    echo ">" . substr($ncb, 0, 70) . " - Cuenta " . $row[3] . "</option>";
                                                }
                                            ?>
									</select>-->
                                            <input type="text" name="cb" id="cb" value="<?php echo $_POST[cb]; ?>"
                                                   style="width:75%;"/>&nbsp;
                                            <a onClick="despliegamodal2('visible','1');" style="cursor:pointer;"
                                               title="Listado Cuentas Bancarias">
                                                <img src='imagenes/find02.png' style='width:20px;'/>
                                            </a>
                                            <input name="banco" id="banco" type="hidden"
                                                   value="<?php echo $_POST[banco] ?>">
                                            <input type="hidden" id="ter" name="ter" value="<?php echo $_POST[ter] ?>">
                                        </td>
                                        <td colspan="6">
                                            <input type="text" id="nbanco" name="nbanco"
                                                   value="<?php echo $_POST[nbanco] ?>" style="width:100%;" readonly>
                                        </td>
                                        <?php
                                    } else
                                    {
                                        $regalias = "MEDIO PAGO SSF";
                                        ?>
                                        <td class="saludo1">Recaudo:</td>
                                        <td colspan="5">
                                            <input type="text" id="regalias" value="<?php echo $regalias; ?>"
                                                   style="width:100%;" readonly>
                                        </td>
                                        <td style="width:8%;" class="saludo1">Entidad administradora:</td>
                                        <td style="width:10%;">
                                            <select name="mediodepagosgr" style="width:100%;"
                                                    onKeyUp="return tabular(event,this)">
                                                <option value="">No contabiliza</option>
                                                <?php
                                                    $linkbd = conectar_bd();
                                                    $sqlr = "select *from tesomediodepago where estado='S'";
                                                    $res = mysql_query($sqlr, $linkbd);
                                                    while ($row = mysql_fetch_row($res))
                                                    {
                                                        echo "<option value=$row[0] ";
                                                        $i = $row[0];
                                                        if ($i == $_POST[mediodepagosgr])
                                                        {
                                                            echo "SELECTED";
                                                        }
                                                        echo ">" . $row[0] . " - " . $row[1] . "</option>";
                                                    }
                                                ?>
                                            </select>
                                        </td>
                                        <?php
                                    }
                                ?>
                            </tr>
                            <tr>
                                <td style="width:5%;" class="saludo1">NIT:</td>
                                <td style="width:10%;">
                                    <input name="tercero" type="text" value="<?php echo $_POST[tercero] ?>"
                                           style="width:100%;" onKeyUp="return tabular(event,this)"
                                           onBlur="buscater(event)" readonly>
                                </td>
                                <td colspan="6">
                                    <input type="text" id="ntercero" name="ntercero"
                                           value="<?php echo $_POST[ntercero] ?>" style="width:100%;"
                                           onKeyUp="return tabular(event,this) " readonly>
                                    <input type="hidden" value="0" name="bt">
                                    <input type="hidden" id="cb" name="cb" value="<?php echo $_POST[cb] ?>">
                                    <input type="hidden" id="ct" name="ct" value="<?php echo $_POST[ct] ?>">
                                    <input type="hidden" value="1" name="oculto">
                                </td>
                            </tr>
                            <tr>

                            </tr>
                        </table>
                    </td>
                    <td colspan="3"
                        style="width:20%; background:url(imagenes/siglas.png); background-repeat:no-repeat; background-position:right; background-size: 100% 100%;"></td>
                </tr>
            </table>
            <?php
                //***** busca tercero
                if ($_POST[bt] == '1')
                {
                    $nresul = buscatercero($_POST[tercero]);
                    if ($nresul != '')
                    {
                        $_POST[ntercero] = $nresul;
                        ?>
                        <script>
                            document.getElementById('codingreso').focus();
                            document.getElementById('codingreso').select();</script>
                    <?php
                        }
                        else
                        {
                        $_POST[ntercero] = "";
                    ?>
                        <script>
                            alert("Tercero Incorrecto o no Existe")
                            document.form2.tercero.focus();
                        </script>
                        <?php
                    }
                }
                //*** ingreso
                if ($_POST[bin] == '1')
                {
                    $nresul = buscaingreso($_POST[codingreso]);
                    if ($nresul != '')
                    {
                        $_POST[ningreso] = $nresul;
                        ?>
                        <script>
                            document.getElementById('valor').focus();
                            document.getElementById('valor').select();</script>
                    <?php
                        }
                        else
                        {
                        $_POST[codingreso] = "";
                    ?>
                        <script>alert("Codigo Ingresos Incorrecto");
                            document.form2.codingreso.focus();</script>
                        <?php
                    }
                }
            ?>

            <div class="subpantalla">
                <table class="inicio">
                    <tr>
                        <td colspan="4" class="titulos">Detalle Recaudos Transferencia</td>
                    </tr>
                    <tr>
                        <td class="titulos2">Codigo</td>
                        <td class="titulos2">Ingreso</td>
                        <td class="titulos2">Valor</td>
                        <td class="titulos2"><img src="imagenes/del.png"><input type='hidden' name='elimina'
                                                                                id='elimina'></td>
                    </tr>
                    <?php
                        if ($_POST[elimina] != '')
                        {
                            //echo "<TR><TD>ENTROS :".$_POST[elimina]."</TD></TR>";
                            $posi = $_POST[elimina];

                            unset($_POST[dcoding][$posi]);
                            unset($_POST[dncoding][$posi]);
                            unset($_POST[dvalores][$posi]);
                            $_POST[dcoding] = array_values($_POST[dcoding]);
                            $_POST[dncoding] = array_values($_POST[dncoding]);
                            $_POST[dvalores] = array_values($_POST[dvalores]);
                        }
                        if ($_POST[agregadet] == '1')
                        {
                            $_POST[dcoding][] = $_POST[codingreso];
                            $_POST[dncoding][] = $_POST[ningreso];
                            $_POST[dvalores][] = $_POST[valor];
                            $_POST[agregadet] = 0;
                            ?>
                            <script>
                                //document.form2.cuenta.focus();
                                document.form2.codingreso.value = "";
                                document.form2.valor.value = "";
                                document.form2.ningreso.value = "";
                                document.form2.codingreso.select();
                                document.form2.codingreso.focus();
                            </script>


                            <?php
                        }
                        $_POST[totalc] = 0;
                        for ($x = 0; $x < count($_POST[dcoding]); $x++)
                        {
                            echo "<tr class='saludo1'>
		 		<td style='width:5%;'>
		 			<input name='dcoding[]' value='" . $_POST[dcoding][$x] . "' type='text' style='width:100%;' readonly>
		 		</td>
		 		<td style='width:80%;'>
		 			<input name='dncoding[]' value='" . $_POST[dncoding][$x] . "' type='text' style='width:100%;' readonly>
		 		</td>
		 		<td style='width:15%;'>
		 			<input name='dvalores[]' value='" . $_POST[dvalores][$x] . "' type='text' style='width:100%;' readonly>
		 		</td>
		 		<td >
		 			<a href='#' onclick='eliminar($x)'>
		 				<img src='imagenes/del.png'>
		 			</a>
		 		</td>
		 	</tr>";
                            $_POST[totalc] = $_POST[totalc] + $_POST[dvalores][$x];
                            $_POST[totalcf] = number_format($_POST[totalc], 2);
                        }
                        $resultado = convertir($_POST[totalc]);
                        $_POST[letras] = $resultado . " Pesos";
                        echo "<tr class='saludo1'>
		 		<td style='width:5%;'>
		 		</td>
		 		<td style='width:80%;'>Total</td>
		 		<td style='width:15%;'>
		 			<input name='totalcf' type='text' value='$_POST[totalcf]' style='width:100%;' readonly>
		 			<input name='totalc' type='hidden' value='$_POST[totalc]'>
		 		</td>
		 	</tr>
		 	<tr>
		 		<td style='width:5%;' class='saludo1'>Son:</td>
		 		<td style='width:80%;'>
		 			<input name='letras' type='text' value='$_POST[letras]' style='width:100%;'>
		 		</td>
		 	</tr>";
                    ?>
                </table>
            </div>
            <?php
                if ($_POST[oculto] == '2')
                {
                    $sqlr = "select count(*) from tesorecaudotransferencia where id=$_POST[idcomp]";
                    $res = mysql_query($sqlr, $linkbd);
                    //echo $sqlr;
                    while ($r = mysql_fetch_row($res))
                    {
                        $numerorecaudos = $r[0];
                    }
                    if ($numerorecaudos == 0)
                    {
                        $linkbd = conectar_bd();
                        ereg("([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha], $fecha);
                        $fechaf = $fecha[3] . "-" . $fecha[2] . "-" . $fecha[1];
                        //*********************CREACION DEL COMPROBANTE CONTABLE ***************************
                        //***busca el consecutivo del comprobante contable
                        $consec = 0;
                        $sqlr = "select max(numerotipo) from comprobante_cab where tipo_comp='14' ";
                        //echo $sqlr;
                        $res = mysql_query($sqlr, $linkbd);
                        while ($r = mysql_fetch_row($res))
                        {
                            $consec = $r[0];
                        }
                        $consec += 1;
                        //***cabecera comprobante
                        if ($_POST[conSinBanco] == "NO")
                        {
                            $_POST[concepto] = "ESTE DOCUMENTO NO REQUIERE CAUSACION CONTABLE " . $_POST[concepto];
                        }
                        $sqlr = "insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($consec,14,'$fechaf','" . strtoupper($_POST[concepto]) . "',0,$_POST[totalc],$_POST[totalc],0,'1')";
                        mysql_query($sqlr, $linkbd);

                        $idcomp = mysql_insert_id();
                        echo "<input type='hidden' name='ncomp' value='$idcomp'>";
                        //******************* DETALLE DEL COMPROBANTE CONTABLE *********************
                        if ($_POST[medioDePago] != 2)
                        {
                            for ($x = 0; $x < count($_POST[dcoding]); $x++)
                            {
                                //***** BUSQUEDA INGRESO ********
                                $sqlri = "Select * from tesoingresos_det where codigo='" . $_POST[dcoding][$x] . "'  and vigencia=$vigusu";
                                $resi = mysql_query($sqlri, $linkbd);
                                //	echo "$sqlri <br>";
                                while ($rowi = mysql_fetch_row($resi))
                                {
                                    //**** busqueda concepto contable*****
                                    $sq = "select fechainicial from conceptoscontables_det where codigo='" . $rowi[2] . "' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
                                    $re = mysql_query($sq, $linkbd);
                                    while ($ro = mysql_fetch_assoc($re))
                                    {
                                        $_POST[fechacausa] = $ro["fechainicial"];
                                    }
                                    $sqlrc = "Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo=" . $rowi[2] . " and tipo='C' and fechainicial='" . $_POST[fechacausa] . "'";
                                    $resc = mysql_query($sqlrc, $linkbd);
                                    //	echo "con: $sqlrc <br>";
                                    while ($rowc = mysql_fetch_row($resc))
                                    {
                                        $porce = $rowi[5];
                                        if ($_POST[cc] == $rowc[5])
                                        {
                                            if ($rowc[6] == 'S')
                                            {
                                                $valorcred = $_POST[dvalores][$x] * ($porce / 100);
                                                $valordeb = 0;
                                                $sqlr = "insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('14 $consec','" . $rowc[4] . "','" . $_POST[tercero] . "','" . $_POST[cc] . "','Recaudo Transferencia" . strtoupper($_POST[dncoding][$x]) . "',''," . $valordeb . "," . $valorcred . ",'1','" . $_POST[vigencia] . "')";
                                                mysql_query($sqlr, $linkbd);
                                                //echo "<br>".$sqlr;
                                                $valordeb = $_POST[dvalores][$x] * ($porce / 100);
                                                $valorcred = 0;
                                                $sqlr = "insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('14 $consec','" . $_POST[banco] . "','" . $_POST[tercero] . "','" . $_POST[cc] . "','Recaudo Transferencia" . strtoupper($_POST[dncoding][$x]) . "',''," . $valordeb . "," . $valorcred . ",'1','" . $_POST[vigencia] . "')";
                                                mysql_query($sqlr, $linkbd);
                                                //echo "<br>".$sqlr;
                                                $vi = $_POST[dvalores][$x] * ($porce / 100);
                                                $sqlr = "update pptocuentaspptoinicial  set ingresos=ingresos+" . $vi . " where cuenta ='" . $rowi[6] . "' and vigencia=$vigusu";
                                                //mysql_query($sqlr,$linkbd);
                                                //****creacion documento presupuesto ingresos
                                                $sqlr = "insert into pptoingtranppto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$consec,$vi,'" . $vigusu . "')";
                                                // mysql_query($sqlr,$linkbd);

                                            }
                                        }
                                        //echo "Conc: $sqlr <br>";
                                    }
                                }
                            }
                        } elseif ($_POST[mediodepagosgr] != '')
                        {
                            for ($x = 0; $x < count($_POST[dcoding]); $x++)
                            {
                                //***** BUSQUEDA INGRESO ********
                                $sqlri = "Select * from tesoingresos_det where codigo='" . $_POST[dcoding][$x] . "'  and vigencia=$vigusu";
                                $resi = mysql_query($sqlri, $linkbd);
                                //	echo "$sqlri <br>";
                                while ($rowi = mysql_fetch_row($resi))
                                {
                                    //**** busqueda concepto contable*****
                                    $sq = "select fechainicial from conceptoscontables_det where codigo='" . $rowi[2] . "' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
                                    $re = mysql_query($sq, $linkbd);
                                    while ($ro = mysql_fetch_assoc($re))
                                    {
                                        $_POST[fechacausa] = $ro["fechainicial"];
                                    }
                                    $sqlrc = "Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo=" . $rowi[2] . " and tipo='C' and fechainicial='" . $_POST[fechacausa] . "'";
                                    $resc = mysql_query($sqlrc, $linkbd);
                                    //	echo "con: $sqlrc <br>";
                                    while ($rowc = mysql_fetch_row($resc))
                                    {
                                        $porce = $rowi[5];
                                        if ($_POST[cc] == $rowc[5])
                                        {
                                            if ($rowc[6] == 'S')
                                            {
                                                $valorcred = $_POST[dvalores][$x] * ($porce / 100);
                                                $valordeb = 0;
                                                $sqlr = "insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('14 $consec','" . $rowc[4] . "','" . $_POST[tercero] . "','" . $_POST[cc] . "','Recaudo Transferencia" . strtoupper($_POST[dncoding][$x]) . "',''," . $valordeb . "," . $valorcred . ",'1','" . $_POST[vigencia] . "')";
                                                mysql_query($sqlr, $linkbd);
                                                //echo "<br>".$sqlr;
                                                $valordeb = $_POST[dvalores][$x] * ($porce / 100);
                                                $valorcred = 0;
                                                $sqlrMedioPago = "SELECT cuentacontable FROM tesomediodepago WHERE id='$_POST[mediodepagosgr]' AND estado='S'";
                                                $resMedioPago = mysql_query($sqlrMedioPago, $linkbd);
                                                $rowMedioPago = mysql_fetch_row($resMedioPago);
                                                $sqlr = "insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('14 $consec','" . $rowMedioPago[0] . "','" . $_POST[tercero] . "','" . $_POST[cc] . "','Recaudo Transferencia" . strtoupper($_POST[dncoding][$x]) . "',''," . $valordeb . "," . $valorcred . ",'1','" . $_POST[vigencia] . "')";
                                                mysql_query($sqlr, $linkbd);

                                                $sqlrBanco = "select tesobancosctas.estado, tesobancosctas.cuenta, tesobancosctas.ncuentaban, tesobancosctas.tipo, terceros.razonsocial, tesobancosctas.tercero from tesobancosctas,terceros where tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.cuenta='$rowMedioPago[0]' and tesobancosctas.estado='S' ";
                                                $resBanco = mysql_query($sqlrBanco, $linkbd);
                                                $rowBanco = mysql_fetch_row($resBanco);
                                                $_POST[nbanco] = $rowBanco[4];
                                                $_POST[ter] = $rowBanco[5];
                                                $_POST[cb] = $rowBanco[2];
                                                $vi = $_POST[dvalores][$x] * ($porce / 100);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        //************ insercion de cabecera recaudos ************

                        $sqlr = "insert into tesorecaudotransferencia (idcomp,fecha,vigencia,banco,ncuentaban,concepto,tercero,cc,valortotal,estado,presupuesto,mediopago) values($_POST[idrecaudo],'$fechaf','" . $_POST[vigencia] . "','$_POST[ter]','$_POST[cb]','" . strtoupper($_POST[concepto]) . "','$_POST[tercero]','$_POST[cc]','$_POST[totalc]','S','$_POST[presupuesto]','$_POST[mediodepagosgr]')";
                        mysql_query($sqlr, $linkbd);
                        $idrec = mysql_insert_id();

                        $sqlr = "insert into pptocomprobante_cab (numerotipo,tipo_comp,fecha,concepto,vigencia,total_debito,total_credito,diferencia,estado) values ($idrec,19,'$fechaf','" . strtoupper($_POST[concepto]) . "',$_POST[vigencia],0,0,0,'1')";
                        mysql_query($sqlr, $linkbd);
                        //echo "Conc: $sqlr <br>";
                        //************** insercion de consignaciones **************


                        for ($x = 0; $x < count($_POST[dcoding]); $x++)
                        {
                            $sqlr = "insert into tesorecaudotransferencia_det (id_recaudo,ingreso,valor,estado) values($idrec,'" . $_POST[dcoding][$x] . "'," . $_POST[dvalores][$x] . ",'S')";
                            if (!mysql_query($sqlr, $linkbd))
                            {
                                echo "<table ><tr><td class='saludo1'><center><font color=blue><img src='imagenes/alert.png'> Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petici�n: <br><font color=red><b>$sqlr</b></font></p>";
                                //	 $e =mysql_error($respquery);
                                echo "Ocurri� el siguiente problema:<br>";
                                //echo htmlentities($e['message']);
                                echo "<pre>";
                                ///echo htmlentities($e['sqltext']);
                                // printf("\n%".($e['offset']+1)."s", "^");
                                echo "</pre></center></td></tr></table>";
                            } else
                            {
                                if ($_POST[medioDePago] != 2)
                                {
                                    $sqlri = "Select * from tesoingresos_det where codigo='" . $_POST[dcoding][$x] . "' and vigencia=$vigusu";
                                    $resi = mysql_query($sqlri, $linkbd);
                                    //	echo "$sqlri <br>";
                                    while ($rowi = mysql_fetch_row($resi))
                                    {
                                        $porce = $rowi[5];
                                        $vi = $_POST[dvalores][$x] * ($porce / 100);

                                        if ($_POST[presupuesto] == "1")
                                        {
                                            $sqlr = "update pptocuentaspptoinicial  set ingresos=ingresos+" . $vi . " where cuenta ='" . $rowi[6] . "' AND VIGENCIA='" . $_POST[vigencia] . "'";
                                            mysql_query($sqlr, $linkbd);
                                            //****creacion documento presupuesto ingresos
                                            $sqlr = "insert into pptoingtranppto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$idrec,$vi,'" . $vigusu . "')";
                                            mysql_query($sqlr, $linkbd);
                                        }

                                        if ($rowi[6] != "" || $vi > 0)
                                        {
                                            $sqlr = "insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values('" . $rowi[6] . "','" . $_POST[tercero] . "','RECAUDO TRANSFERENCIA'," . $vi . ",0,1,'$vigusu',19,'$idrec','201','1','','$fechaf')";
                                            mysql_query($sqlr, $linkbd);
                                        }
                                    }
                                } elseif ($_POST[mediodepagosgr] != '')
                                {
                                    $sqlri = "Select * from tesoingresos_det where codigo='" . $_POST[dcoding][$x] . "' and vigencia=$vigusu";
                                    $resi = mysql_query($sqlri, $linkbd);
                                    //	echo "$sqlri <br>";
                                    while ($rowi = mysql_fetch_row($resi))
                                    {
                                        $porce = $rowi[5];
                                        $vi = $_POST[dvalores][$x] * ($porce / 100);

                                        if ($_POST[presupuesto] == "1")
                                        {
                                            //****creacion documento presupuesto ingresos
                                            $sqlr = "insert into pptoingtranppto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$idrec,$vi,'" . $vigusu . "')";
                                            mysql_query($sqlr, $linkbd);
                                        }
                                    }
                                }
                                echo "<table  class='inicio'>
						<tr>
							<td class='saludo1'>
								<center>Se ha almacenado el Recaudo con Exito <img src='imagenes/confirm.png'></center>
							</td>
						</tr>
					</table>
					<script>respuestamensaje();</script>
					";
                                ?>
                                <script>
                                    document.form2.numero.value = "";
                                    document.form2.valor.value = 0;
                                </script>
                                <?php
                            }

                        }
                    } else
                    {
                        echo "<table class='inicio'><tr><td class='saludo1'><center>Ya Existe un Recibo con este numero <img src='imagenes/alert.png'></center></td></tr></table>";
                    }
                }
            ?>

            <div id="bgventanamodal2">
                <div id="ventanamodal2">
                    <IFRAME src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0
                            style="left:500px; width:900px; height:500px; top:200;">
                    </IFRAME>
                </div>
            </div>
        </form>
    </td>
</tr>
</table>
</body>
</html> 		