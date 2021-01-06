<?php
    require "comun.inc";
    require "funciones.inc";
    session_start();
    $linkbd = conectar_bd();
    cargarcodigopag($_GET[codpag], $_SESSION["nivel"]);
    header("Cache-control: private"); // Arregla IE 6
    date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
    <meta http-equiv="X-UA-Compatible" content="IE=9"/>
    <title>:: SPID - Presupuesto</title>
    <link href="css/css2.css" rel="stylesheet" type="text/css"/>
    <link href="css/css3.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="css/programas.js"></script>
    <script>
        //************* ver reporte ************
        //***************************************
        function verep(idfac)
        {
            document.form1.oculto.value = idfac;
            document.form1.submit();
        }

        function funcionmensaje()
        {
        }

        function guardar()
        {


                despliegamodalm('visible', '4', 'Esta Seguro de Guardar', '1');


        }

        function despliegamodalm(_valor, _tip, mensa, pregunta, variable)
        {
            document.getElementById("bgventanamodalm").style.visibility = _valor;
            if (_valor == "hidden")
            {
                document.getElementById('ventanam').src = "";
            } else
            {
                switch (_tip)
                {
                    case "1":
                        document.getElementById('ventanam').src = "ventana-mensaje1.php?titulos=" + mensa;
                        break;
                    case "2":
                        document.getElementById('ventanam').src = "ventana-mensaje3.php?titulos=" + mensa;
                        break;
                    case "3":
                        document.getElementById('ventanam').src = "ventana-mensaje2.php?titulos=" + mensa;
                        break;
                    case "4":
                        document.getElementById('ventanam').src = "ventana-consulta1.php?titulos=" + mensa + "&idresp=" + pregunta;
                        break;
                    case "5":
                        document.getElementById('ventanam').src = "ventana-elimina1.php?titulos=" + mensa + "&idresp=" + pregunta + "&variable=" + variable;
                        break;
                }
            }
        }

        function respuestaconsulta(pregunta, variable)
        {
            switch (pregunta)
            {
                case "1":
                    document.getElementById('oculto').value = "2";
                    document.form2.submit();
                    break;
                case "2":
                    document.form2.elimina.value = variable;
                    //eli=document.getElementById(elimina);
                    vvend = document.getElementById('elimina');
                    //eli.value=elimina;
                    vvend.value = variable;
                    document.form2.submit();
                    break;
            }
        }

        //************* genera reporte ************
        //***************************************
        function genrep(idfac)
        {
            document.form2.oculto.value = idfac;
            document.form2.submit();
        }

        function cambiar()
        {
            document.form2.oculto.value = '5';
            document.form2.submit();
        }
    </script>
    <script>
        function verCuentaActiva(idcta, tipo, filas, filtro)
        {
            var scrtop = $('#divdet').scrollTop();
            var altura = $('#divdet').height();
            var numpag = $('#nummul').val();
            var limreg = $('#numres').val();
            if ((numpag <= 0) || (numpag == ""))
                numpag = 0;
            if ((limreg == 0) || (limreg == ""))
                limreg = 10;
            numpag++;
            location.href = "presu-editarcuentaspasivaexterno.php?idcta=" + idcta + "&tipo=" + tipo + "&scrtop=" + scrtop + "&totreg=" + filas + "&altura=" + altura + "&numpag=" + numpag + "&limreg=" + limreg + "&filtro=" + filtro;
        }
    </script>

    <?php titlepag(); ?>
    <?php
        $scrtop = $_GET['scrtop'];
        if ($scrtop == "") $scrtop = 0;
        echo "<script>
			window.onload=function(){
				$('#divdet').scrollTop(" . $scrtop . ")
			}
		</script>";
        $gidcta = $_GET['idcta'];
        if (isset($_GET['filtro']))
            $_POST[numero] = $_GET['filtro'];
    ?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
    <tr>
        <script>barra_imagenes("presu");</script><?php cuadro_titulos(); ?></tr>
    <tr><?php menu_desplegable("presu"); ?></tr>
    <tr>
        <td colspan="3" class="cinta"><a href="presu-cuentaspasivaexternoadd.php" class="mgbt"><img
                        src="imagenes/add.png" title="Nuevo"/></a><a href="#" onClick="guardar()" class="mgbt"><img
                        src="imagenes/guarda.png" title="Guardar"/></a><a href="#" onClick="document.form2.submit();"
                                                                          class="mgbt"><img src="imagenes/busca.png"
                                                                                            title="Buscar"/></a><a
                    href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img
                        src="imagenes/nv.png" title="Nueva Ventana"></a><img src="imagenes/iratras.png"
                                                                             title="Atr&aacute;s"
                                                                             onClick="location.href='presu-gestionentidades.php'"
                                                                             class="mgbt"/></td>
    </tr>
</table>
<?php
    if ($_GET[numpag] != "")
    {
        $oculto = $_POST[oculto];
        if ($oculto != 2)
        {
            $_POST[numres] = $_GET[limreg];
            $_POST[numpos] = $_GET[limreg] * ($_GET[numpag] - 1);
            $_POST[nummul] = $_GET[numpag] - 1;
        }
    } else
    {
        if ($_POST[nummul] == "")
        {
            $_POST[numres] = 10;
            $_POST[numpos] = 0;
            $_POST[nummul] = 0;
        }
    }
?>
<form action="" method="post" enctype="multipart/form-data" name="form2">
    <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres]; ?>"/>
    <input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos]; ?>"/>
    <input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul]; ?>"/>
    <input type="hidden" name="numtop" id="numtop" value="<?php echo $_POST[numtop]; ?>"/>
    <table class="inicio" width="99%">
        <tr>
            <td height="25" colspan="2" class="titulos">Buscar Cuentas Gastos</td>
            <td width="91" class="cerrar"><a href="presu-principal.php"> Cerrar</a></td>
        </tr>
        <tr>
            <td colspan="4" class="titulos2">:&middot; Por Descripcion</td>
        </tr>
        <tr>
            <td width="144" class="saludo1">:&middot; Numero Cuenta:</td>
            <td colspan="3"><input name="numero" type="text" style="width:30%" value="<?php echo $_POST[numero]; ?>">
                <input name="oculto" type="hidden" id="oculto" value="1">
                <input type="submit" name="Submit" value="Buscar">
                <input type="hidden" name="contador" id="contador" value="<?php echo $_POST[contador]; ?>">
            </td>
        </tr>
    </table>
    <div id="divdet" class="subpantallap" style="height:63.5%; width:99.6%;">
        <?php
            $oculto = $_POST['oculto'];
            $vigusu = vigencia_usuarios($_SESSION[cedulausu]);
            //echo $oculto;
            $link = conectar_bd();
            $cond = "";
            $cond2 = "";
            $_POST[contador] = 0;
            if ($_POST[numero] != "")
            {
                $cond = "and (cuenta like'%" . trim($_POST[numero]) . "%' or nombre like '%" . strtoupper($_POST[numero]) . "%')";
            }
            if ($_POST[numres] != "-1")
            {
                //$cond2="LIMIT $_POST[numpos], $_POST[numres]";
            }

            $sqlr = "Select distinct pptocuentasentidades.*, dominios.tipo from pptocuentasentidades, dominios where dominios.descripcion_valor=pptocuentasentidades.clasificacion AND dominios.nombre_dominio='CLASIFICACION_RUBROS' AND (dominios.tipo='G') and (vigencia='" . $vigusu . "' or  vigenciaf='" . $vigusu . "') $cond";
            $resp = mysql_query($sqlr, $link);
            $numregistros = mysql_num_rows($resp);
            $_POST[numtop] = $numregistros;

            echo "<script>document.getElementById('contador').value=$numregistros; </script>";
            $_POST[contador] = $_POST[numtop];
            $nuncilumnas = ceil($_POST[numtop] / $_POST[numres]);
            $sqlr = "Select distinct pptocuentasentidades.*, dominios.tipo from pptocuentasentidades, dominios where dominios.descripcion_valor=pptocuentasentidades.clasificacion AND dominios.nombre_dominio='CLASIFICACION_RUBROS' AND (dominios.tipo='G') and (vigencia='" . $vigusu . "' or  vigenciaf='" . $vigusu . "') $cond ORDER BY cuenta ASC " . $cond2;
            $resp = mysql_query($sqlr, $linkbd);
            $co = 'saludo1a';
            $co2 = 'saludo2';
            $numcontrol = $_POST[nummul] + 1;
            $i = ($_POST[nummul] * $_POST[numres]) + 1;
            if (($nuncilumnas == $numcontrol) || ($_POST[numres] == "-1"))
            {
                $imagenforward = "<img src='imagenes/forward02.png' style='width:17px'>";
                $imagensforward = "<img src='imagenes/skip_forward02.png' style='width:16px' >";
            } else
            {
                $imagenforward = "<img src='imagenes/forward01.png' style='width:17px' title='Siguiente' onClick='numsiguiente()'>";
                $imagensforward = "<img src='imagenes/skip_forward01.png' style='width:16px' title='Fin' onClick='saltocol(\"$nuncilumnas\")'>";
            }
            if (($_POST[numpos] == 0) || ($_POST[numres] == "-1"))
            {
                $imagenback = "<img src='imagenes/back02.png' style='width:17px'>";
                $imagensback = "<img src='imagenes/skip_back02.png' style='width:16px'>";
            } else
            {
                $imagenback = "<img src='imagenes/back01.png' style='width:17px' title='Anterior' onClick='numanterior();'>";
                $imagensback = "<img src='imagenes/skip_back01.png' style='width:16px' title='Inicio' onClick='saltocol(\"1\")'>";
            }
            echo '<table class="inicio">
    				<tr>
      					<td height="25" colspan="5" class="titulos" style="width:95%" >Resultados Busqueda </td>
						<td class="submenu" >
							<select name="renumres" id="renumres" onChange="cambionum();" style="width:100%">
								<option value="10"';
            if ($_POST[renumres] == '10')
            {
                echo 'selected';
            }
            echo '>10</option>
								<option value="20"';
            if ($_POST[renumres] == '20')
            {
                echo 'selected';
            }
            echo '>20</option>
								<option value="30"';
            if ($_POST[renumres] == '30')
            {
                echo 'selected';
            }
            echo '>30</option>
								<option value="50"';
            if ($_POST[renumres] == '50')
            {
                echo 'selected';
            }
            echo '>50</option>
								<option value="100"';
            if ($_POST[renumres] == '100')
            {
                echo 'selected';
            }
            echo '>100</option>
								<option value="-1"';
            if ($_POST[renumres] == '-1')
            {
                echo 'selected';
            }
            echo '>Todos</option>
							</select>
						</td>
      				</tr>
    				<tr>
      <td width="32" class="titulos2"  >Item</td>
      <td width="76" class="titulos2" >Cuenta </td>
      <td width="70" class="titulos2" >Descripcion</td>
      <td width="100" class="titulos2" >Tipo</td>				
      <td width="115" class="titulos2" >Relacion</td>
	  <td width="32" class="titulos2"  >Estado</td>	  
    				</tr>';
            $filas = 1;
            $i = 0;
            while ($r = mysql_fetch_row($resp))
            {
                $semaforo = "sema_rojoON.jpg";
                $negrilla = "style='font-weight:bold'";
                $tipo = $r[2];
                if ($r[2] == 'Auxiliar')
                {
                    $negrilla = " ";
                }
                if ($gidcta != "")
                {
                    if ($gidcta == $r[0])
                    {
                        $estilo = 'background-color:#FF9';
                    } else
                    {
                        $estilo = "";
                    }
                } else
                {
                    $estilo = "";
                }

                $idcta = "'$r[0]'";
                $tipo = "'$tipo'";
                $numfil = "'" . $filas . "'";
                $filtro = "'" . $_POST[numero] . "'";
                if (empty($_POST[oculto]))
                {

                    $sq = "select cuentaexterna,unidad from pptocuentashomologacion where cuentacentral='$r[0]' ";
                    $re = mysql_query($sq, $link);
                    $ro = mysql_fetch_row($re);
                    if ($ro[0] != '')
                    {
                        $_POST[concecausa][$i] = $ro[0] . "-" . $ro[1];
                        $semaforo = "sema_verdeON.jpg";
                    } else
                    {
                        $_POST[concecausa][$i] = '';
                    }

                }
                if ($_POST[oculto] == '5')
                {
                    $sq = "select cuentaexterna from pptocuentashomologacion where cuentacentral='$r[0]' ";
                    $re = mysql_query($sq, $link);
                    $ro = mysql_fetch_row($re);
                    if ($ro[0] != '')
                    {
                        $semaforo = "sema_verdeON.jpg";
                    } else
                    {
                        $semaforo = "sema_rojoON.jpg";
                    }
                }

                echo "<tr class='$co' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
			onMouseOut=\"this.style.backgroundColor=anterior\" style='text-transform:uppercase; $estilo' >
			<td>$i</td>
			<td $negrilla>$r[0]<input type='hidden' name='cuentas' id='cuentas' value='$r[0]' /></td>
			<td $negrilla>" . ucwords(strtolower($r[1])) . "</td>
			<td $negrilla>" . ucwords(strtolower($r[2])) . "</td>
			<td><select name='concecausa[$i]' id='concecausa[$i]' style='width: 100% !important'>
				  <option value='-1'>Seleccione ....</option>" .
                    $sqlr1 = "Select entidadesgastos.cuenta,entidadesgastos.nombre,pptouniejecu.nombre,pptouniejecu.id_cc from entidadesgastos,pptouniejecu  where entidadesgastos.vigencia='$vigusu' AND entidadesgastos.unidad=pptouniejecu.id_cc order by entidadesgastos.cuenta,pptouniejecu.id_cc ";
                $resp1 = mysql_query($sqlr1, $link);
                while ($row1 = mysql_fetch_row($resp1))
                {
                    $concatena = $row1[0] . "-" . $row1[3];
                    echo "<option value='$concatena' ";
                    if ($concatena == $_POST[concecausa][$i])
                    {
                        echo "SELECTED";
                    }
                    echo " >$row1[0] - $row1[1] ( $row1[2] )</option>";
                }
                "</select></td>
			";
                echo "<td>
						<center>
						<img src='imagenes/$semaforo' height='20' />
						</center>
                    </td>  </tr>";
                echo "
						<input type='hidden' name='cuentacen[]' value='" . $r[0] . "'/>
						<input type='hidden' name='cuentaex[]' value='" . $_POST[concecausa][$i] . "'/>";
                $aux = $co;
                $co = $co2;
                $co2 = $aux;
                $i = ++$i;
                $filas++;
            }


        ?>
        </table>
        <?php

            if ($_POST[oculto] == '2') //**********guardar la configuracion de la cuenta
            {
                $link = conectar_bd();
                $sql = "DELETE FROM pptocuentashomologacion";
                mysql_query($sql, $link);
                for ($x = 0; $x < count($_POST[concecausa]); $x++)
                {

                    if ($_POST[concecausa][$x] != '-1')
                    {
                        $arreglo = explode("-", $_POST[concecausa][$x]);
                        $sqlr = "insert into pptocuentashomologacion (cuentacentral,cuentaexterna,vigencia,unidad) values ('" . $_POST[cuentacen][$x] . "','" . $arreglo[0] . "','$vigusu','" . $arreglo[1] . "')";
                        mysql_query($sqlr, $link);
                    }

                }
                $ruta = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                echo "<meta http-equiv='refresh' content='2;url=$ruta'>";
                echo "<table class='inicio'><tr><td class='saludo1'><center>Se han homologado la cuentas con exito <img src='imagenes\confirm.png'></center></td></tr></table>";
                $_POST[oculto] = "";
            }

        ?>

    </div>
    <div id="bgventanamodalm" class="bgventanamodalm">
        <div id="ventanamodalm" class="ventanamodalm">
            <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0
                    style=" width:700px; height:130px; top:200; overflow:hidden;">
            </IFRAME>
        </div>
    </div>
</form>
<script>
    jQuery(function ($)
    {
        var user = "<?php echo $_SESSION[cedulausu]; ?>";
        var bloque = '';
        $.post('peticionesjquery/seleccionavigencia.php', {usuario: user}, selectresponse);


        $('#cambioVigencia').change(function (event)
        {
            var valor = $('#cambioVigencia').val();
            var user = "<?php echo $_SESSION[cedulausu]; ?>";
            var confirma = confirm('¿Realmente desea cambiar la vigencia?');
            if (confirma)
            {
                var anobloqueo = bloqueo.split("-");
                var ano = anobloqueo[0];
                if (valor < ano)
                {
                    if (confirm("Tenga en cuenta va a entrar a un periodo bloqueado. Desea continuar"))
                    {
                        $.post('peticionesjquery/cambiovigencia.php', {valor: valor, usuario: user}, updateresponse);
                    } else
                    {
                        location.reload();
                    }

                } else
                {
                    $.post('peticionesjquery/cambiovigencia.php', {valor: valor, usuario: user}, updateresponse);
                }

            } else
            {
                location.reload();
            }

        });

        function updateresponse(data)
        {
            json = eval(data);
            if (json[0].respuesta == '2')
            {
                alert("Vigencia modificada con exito");
            } else if (json[0].respuesta == '3')
            {
                alert("Error al modificar la vigencia");
            }
            location.reload();
        }

        function selectresponse(data)
        {
            json = eval(data);
            $('#cambioVigencia').val(json[0].vigencia);
            bloqueo = json[0].bloqueo;
        }

    });
</script>
</body>
</html>