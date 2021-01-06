<?php
    ini_set('max_execution_time',3600);
	require "comun.inc";
	require "funciones.inc";
	sesion();
	$_SESSION["usuario"] ;
	$_SESSION["perfil"] ;
	$_SESSION["linkset"] ;
	$linkbd=conectar_bd();
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">

    <head>
        <meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1" />
        <meta http-equiv="X-UA-Compatible" content="IE=9" />
        <title>:: SPID - Administracion</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <link href="css/css4.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
        <script type="text/javascript" src="jquery-1.11.0.min.js"></script>
        <script>
            //************* ver reporte ************
            //***************************************
            $(window).load(function() {
                $('#cargando').hide();
            });

            function verep(idfac) {
                document.form1.oculto.value = idfac;
                document.form1.submit();
            }
        
            //************* genera reporte ************
            //***************************************
            function genrep(idfac) {
                document.form2.oculto.value = idfac;
                document.form2.submit();
            }
        
            function habilitar(chkbox) {
                habdesv = document.getElementsByName('habdes[]');
                chks = document.getElementsByName('asigna[]');
                for (var i = 0; i < cali.length; i++) {
                    if (chks.item(i) == chkbox) {
                        if (chkbox.checked == true) {
                            habdesv.item(i).value = "1";
                            //	alert("cabio"+habdesv.item(i).value)
                        } else
                            habdesv.item(i).value = "0";
                        //	alert("cabio"+habdesv.item(i).value)

                    }
                }
            }
        </script>
        <?php titlepag();?>
    </head>

    <body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr>
                <script>
                barra_imagenes("adm");
                </script><?php cuadro_titulos();?>
            </tr>
            <tr><?php menu_desplegable("adm");?></tr>
            <tr class="cinta">
                <td colspan="3" class="cinta"><a href="addperfil.php" class="mgbt"><img src="imagenes/add.png"
                        title="Nuevo" /></a><a href="#" onClick="document.form2.submit();" class="mgbt"><img
                        src="imagenes/guarda.png" title="Guardar" /></a><a href="perfiles.php" class="mgbt"><img
                        src="imagenes/busca.png" title="Buscar" /></a><a href="#"
                    onClick="mypop=window.open('adm-principal.php','','');mypop.focus();" class="mgbt"><img
                        src="imagenes/nv.png" title="Nueva Ventana"></a>
                </td>
            </tr>
        </table>
        <?php
	        if ($_POST[oculto]=="")
	        {
                $sqlr="select *from roles where id_rol=$_POST[codigo]";
                $resp = mysql_query($sqlr,$linkbd);
                $fila =mysql_fetch_row($resp);
                // $fila = oci_fetch_array($resp,OCI_BOTH);
                $cr=$fila[0];
                $nombre=$fila[1];
                $des=$fila[3];
                desconectar_bd();
            }
            else
            {
	            $cr=$_POST[codigo];
                $nombre=$_POST[nombre];
                $des=$_POST[valor];
	        }
            if ($_POST[oculto]=="")
            {
                ?>
                <form name="form2" method="post" action="">
                    <div class="loading" id="divcarga"><span>Cargando...</span></div>
                    <table width="60%" class="inicio" align="center">
                        <tr>
                            <td class="titulos" colspan="2">:: Informacion Perfil</td>
                            <td style='width:7%' class='cerrar'><a href='adm-principal.php'> Cerrar</a></td>
                        </tr>
                        <tr>
                            <td class="saludo1">:&middot; Nombre: </td>
                            <td><input name="nombre" type="text" id="nombre" size="45" value="<?php echo $nombre ?>"></td>
                        </tr>
                        <tr>
                            <td class="saludo1">:&middot; Descripcion: </td>
                            <td><input name="valor" type="text" id="valor" size="70" value="<?php echo $des ?>"> <input
                                    name="oculto" type="hidden" id="oculto" value="1">
                            <input name="codigo" type="hidden" id="codigo" value="<?php echo $cr ?>"></td>
                        </tr>
                    </table>
                    <div class="subpantallap" style="height:64.8%; width:99.6%; overflow-x:hidden;">
                        <?php
                        echo " <table width='50%'  class='inicio' align='center'>";//*****tabla de Privilegios *****
                        echo " <tr class='titulos'><td height='25' colspan='5'>:: Privilegios del Perfil ";
                        echo "</td></tr>";
                        echo "<tr >";
                        echo "<td class='titulos2' width='10'><center>Item</center></td>";
                        echo "<td class='titulos2' width='30'><center>Modulo</center></td>";
                        echo "<td class='titulos2' width='30'><center>Men�</center></td>";
                        echo "<td class='titulos2' width=''><center>Nombre</center></td>";
                        echo "<td class='titulos2' width='10' height='25'><center> Sel </center></td></tr>";
                        $linkbd=conectar_bd();
                        //********Sacar los privilegios****
                        $_SESSION[idexacli]=array();
                        $_SESSION[valexacli]=array();
                        if ($cr==1)
                        {
                            $sqlr="Select distinct opciones.id_opcion,opciones.nom_opcion,opciones.ruta_opcion,opciones.niv_opcion,opciones.est_opcion,opciones.orden,opciones.modulo,modulo_rol.id_modulo,modulos.nombre,niveles.nombre from modulo_rol,opciones,modulos,niveles where modulo_rol.id_rol=$cr and modulo_rol.id_modulo=opciones.modulo and modulos.id_modulo=modulo_rol.id_modulo and opciones.modulo=niveles.id_modulo and niveles.id_nivel=opciones.niv_opcion group by opciones.id_opcion,opciones.nom_opcion,opciones.ruta_opcion,opciones.niv_opcion,opciones.est_opcion,opciones.orden,opciones.modulo,modulo_rol.id_modulo,modulos.nombre,niveles.nombre order by modulos.nombre, niveles.nombre";
                        }
                        else
                        {
                            $sqlr="Select distinct opciones.id_opcion,opciones.nom_opcion,opciones.ruta_opcion,opciones.niv_opcion,opciones.est_opcion,opciones.orden,opciones.modulo,modulo_rol.id_modulo,modulos.nombre,niveles.nombre from modulo_rol,opciones,modulos,niveles where modulo_rol.id_rol=$cr and modulo_rol.id_modulo=opciones.modulo and modulos.id_modulo=modulo_rol.id_modulo and opciones.modulo=niveles.id_modulo and niveles.id_nivel=opciones.niv_opcion and opciones.especial<>'S' group by opciones.id_opcion,opciones.nom_opcion,opciones.ruta_opcion,opciones.niv_opcion,opciones.est_opcion,opciones.orden,opciones.modulo,modulo_rol.id_modulo,modulos.nombre,niveles.nombre order by modulos.nombre, niveles.nombre";
                        }
                        //	$sqlr="Select * from opciones,modulos where modulos.id_modulo=opciones.modulo and opciones.modulo=(Select modulo_rol.id_modulo from modulo_rol where modulo_rol.id_rol=$_SESSION[nivel]) order by opciones.nom_opcion";
                        //echo "sql:$sqlr";
                        $sqlr2="select rol_priv.id_opcion, opciones.nom_opcion,rol_priv.id_opcion,roles.id_rol, rol_priv.id_rol from roles,rol_priv,opciones where rol_priv.id_opcion=opciones.id_opcion  ";
                        $sqlr2=$sqlr2."and	 roles.id_rol=rol_priv.id_rol and rol_priv.id_rol=$cr";
                        $iter='saludo1';
                        $iter2='saludo2';
                        //	echo "$sqlr2";
                        $resp = mysql_query($sqlr2,$linkbd);
                        //$resp = oci_parse ($linkbd, $sqlr2);
                        //oci_execute ($resp);
                        $i=0;
                        while ($row = mysql_fetch_row($resp))
                        {
                            $_SESSION[idexacli][$i]=$row[0];
                            $_SESSION[valexacli][$i]=$row[1];
                            $i+=1;
                        }
                        //oci_free_statement($resp);
                        $resp = mysql_query($sqlr,$linkbd);
                        //$resp = oci_parse ($linkbd, $sqlr);
                        //oci_execute ($resp);
                        $i=1;
                        while ($row =  mysql_fetch_row($resp))
                        {
                            echo "<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"onMouseOut=\"this.style.backgroundColor=anterior\"><td>$i</td>";
                            echo "<td>$row[8]</td>";
                            echo "<td>$row[9]</td>";
                            $i+=1;
                            echo "<td>$row[1]</td>";
                            if (!esta_en_array($_SESSION[idexacli],$row[0]))
                            {
                                echo "<td><center><input type='checkbox' name=tabla[] value='$row[0]' ></td></tr>";
                            }
                            else
                            {
                                $pos=pos_en_array($_SESSION[idexacli],$row[0]);
                                $valor=$_SESSION[idexacli][$pos];
                                echo "<td><center><input type='checkbox' name=tabla[] value='$row[0]'checked ></td></tr>"; //***** para cuando se registre las sesiones y las variables de sesion
                            }
                            $aux=$iter;
                            $iter=$iter2;
                            $iter2=$aux;
                        }
                        echo "</table><script>document.getElementById('divcarga').style.display='none';</script>";
                        ?>
                    </div>
                </form>
                <?php
            }
            $oculto=$_POST['oculto'];
            if($oculto!="")
            {
                /*$i=1;
                Foreach ($_POST[tabla] as $id)
                {
                $vd2=$id;
                $v[$i]=$vd2;
                $i+=1;
                }*/
                $linkbd=conectar_bd();
                $sqlr="update roles set nom_rol='$_POST[nombre]',desc_rol='$_POST[valor]' where id_rol=$_POST[codigo]";
                $resp = mysql_query($sqlr,$linkbd);
                //$resp=oci_parse ($linkbd, $sqlr);
                //oci_execute ($resp);
                //sacar el consecutivo
                $sqlr="Delete from rol_priv where id_rol=$_POST[codigo]";
                //$resp=oci_parse ($linkbd, $sqlr);
                //oci_execute ($resp);
                //echo "$sqlr<br>";
                $resp = mysql_query($sqlr,$linkbd);
                $i=1;
                foreach ($_POST[tabla] as $id)//For ($i=1;$i<=count($v);$i++)
                {
                    $sqlr="Select MAX(id_rolpri) from rol_priv ";
                    //$statement = oci_parse ($linkbd, $sqlr);
                    //oci_execute ($statement);
	                $statement = mysql_query($sqlr,$linkbd);
                    $nr=0;
                    //while ($row = oci_fetch_array ($statement, OCI_BOTH))
                    while ($row =mysql_fetch_row($resp))
                    {
		                $nr=$row[0]+1;
		            }
                    if ($nr==0)
                    {
                        $nr=1;
                    }
                    //		oci_free_statement($statement);
                    $vd2=$id;
                    $v[$i]=$vd2;
                    $sqlr="insert into rol_priv (id_rol,id_opcion,est_rolpriv) values($_POST[codigo],$v[$i],'1')";
                    //$resp=oci_parse ($linkbd, $sqlr);
                    //oci_execute ($resp);
                    //echo $sqlr."<br>";
                    $resp = mysql_query($sqlr,$linkbd);
                    $i+=1;
                }

                echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha Actualizado con Exito</center></td></tr></table>";
                //oci_free_statement($resp);
                //oci_close($linkdb);
            }
        ?>
    </body>
</html>