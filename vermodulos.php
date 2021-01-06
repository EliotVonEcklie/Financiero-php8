<?php //V 1000 12/12/16 ?>
<?php
	require"comun.inc";
	require"funciones.inc";
	sesion();
	$_SESSION["usuario"] ;
	$_SESSION["perfil"] ;
	$_SESSION["linkset"] ;
	$linkbd=conectar_bd();
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
	$scroll=$_GET['scrtop'];
	$totreg=$_GET['totreg'];
	$idcta=$_GET['idcta'];
	$altura=$_GET['altura'];
	$filtro="'".$_GET['filtro']."'";
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1" />
    <meta http-equiv="X-UA-Compatible" content="IE=9" />
    <title>:: SPID - Administracion</title>
    <link href="css/css2.css" rel="stylesheet" type="text/css" />
    <link href="css/css3.css" rel="stylesheet" type="text/css" />
    <script type='text/javascript' src='JQuery/jquery-2.1.4.min.js'></script>
    <script type="text/javascript" src="css/programas.js"></script>
    <script>
    //************* ver reporte ************
    //***************************************
    function verep(idfac) {
        document.form1.oculto.value = idfac;
        document.form1.submit();
    }
    </script>
    <script>
    //************* genera reporte ************
    //***************************************
    function genrep(idfac) {
        document.form2.oculto.value = idfac;
        document.form2.submit();
    }
    </script>
    <script>
    //************* genera reporte ************
    //***************************************
    function agregar() {
        document.form2.action = "verperfiles.php";
        document.form2.oculto.value = "";
        document.form2.submit();
    }
    </script>
    <script>
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

    function iratras(scrtop, numpag, limreg, filtro) {
        var idcta = document.getElementById('codigo').value;
        location.href = "perfiles.php?idcta=" + idcta + "&scrtop=" + scrtop + "&numpag=" + numpag + "&limreg=" +
            limreg + "&filtro=" + filtro;
    }
    </script>
    </script>
    <?php titlepag();?>
</head>

<body>
    <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
    <span id="todastablas2"></span>
    <?php
		$numpag=$_GET[numpag];
		$limreg=$_GET[limreg];
		$scrtop=26*$totreg;
		?>
    <table>
        <tr>
            <script>
            barra_imagenes("adm");
            </script><?php cuadro_titulos();?>
        </tr>
        <tr><?php menu_desplegable("adm");?></tr>
        <tr class="cinta">
            <td colspan="3" class="cinta">
                <a href="addperfil.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a>
                <a href="#" onClick="document.form2.submit();" class="mgbt"><img src="imagenes/guarda.png"
                        title="Guardar" /></a>
                <a href="perfiles.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
                <a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img
                        src="imagenes/agenda1.png" title="Agenda" /></a>
                <a href="#" onClick="mypop=window.open('adm-principal.php','','');mypop.focus();" class="mgbt"><img
                        src="imagenes/nv.png" title="Nueva Ventana"></a>
                <a onClick="iratras(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>)"
                    class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
            </td>
        </tr>
    </table>
    <?php
	if ($_POST[oculto]=="")
	{

  $sqlr="select * from roles where id_rol=$_GET[idrol]";
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
        <table width="60%" class="inicio" align="center">
            <tr>
                <td class="titulos" colspan="2">:: Informacion Perfil</td>
                <td style='width:7%' class='cerrar'><a href='adm-principal.php'>Cerrar</a></td>
            </tr>
            <tr>
                <td class="saludo1">:&middot; Nombre: </td>
                <td><input name="nombre" type="text" id="nombre" size="45" value="<?php echo $nombre ?>"></td>
            </tr>
            <tr>
                <td class="saludo1">:&middot; Descripcion: </td>
                <td><input name="valor" type="text" id="valor" size="70" value="<?php echo $des ?>">
                    <input name="oculto" type="hidden" id="oculto" value="1">
                    <input name="codigo" type="hidden" id="codigo" value="<?php echo $cr ?>"></td>
            </tr>
        </table>
        <div class="subpantalla" style="height:64.8%; width:99.6%; overflow-x:hidden;">
            <?php
echo " <table width='50%'  class='inicio' align='center'>";//*****tabla de Privilegios *****
echo " <tr class='titulos'><td height='25' colspan='2'>:: Privilegios del Perfil ";
echo "</td><td style='width:7%' class='cerrar'><a href='#' onClick = 'agregar()'>Agregar</a></td></tr>";
echo "<tr >";
echo "<td class='titulos2' width='10'><center>Item</center></td>";
echo "<td class='titulos2' width='30'><center>Modulo</center></td>";
//echo "<td class='titulos2' width='30'><center>Men�</center></td>";
//echo "<td class='titulos2' width=''><center>Nombre</center></td>";
echo "<td class='titulos2' width='10' height='25'><center> Sel </center></td></tr>";
$linkbd=conectar_bd();
//********Sacar los privilegios****
$_SESSION[idexacli]=array();
$_SESSION[valexacli]=array();
$sqlr="Select * from modulos  order by modulos.nombre";
//	$sqlr="Select * from opciones,modulos where modulos.id_modulo=opciones.modulo and opciones.modulo=(Select modulo_rol.id_modulo from modulo_rol where modulo_rol.id_rol=$_SESSION[nivel]) order by opciones.nom_opcion";
	//echo "sql:$sqlr";
	$sqlr2="select modulo_rol.id_modulo, modulos.nombre,roles.id_rol, modulo_rol.id_rol from roles,modulo_rol,modulos where modulo_rol.id_modulo=modulos.id_modulo  ";
     $sqlr2=$sqlr2."and	 roles.id_rol=modulo_rol.id_rol and modulo_rol.id_rol=$cr";
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

  echo "<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\"><td >$i</td>";
   echo "<td>$row[1]</td>";
 //  echo "<td id='$iter'>$row[9]</td>";
$i+=1;
 // echo "<td id='$iter'>$row[1]</td>";
  if (!esta_en_array($_SESSION[idexacli],$row[0]))
  {
   echo "<td><center><input type='checkbox' name=tabla[] value='$row[0]' ";
   echo"></td></tr>";
  }
   else
   {
  $pos=pos_en_array($_SESSION[idexacli],$row[0]);
  $valor=$_SESSION[idexacli][$pos];
   echo "<td><center><input type='checkbox' name=tabla[] value='$row[0]'";
  echo " checked ></td></tr>"; //***** para cuando se registre las sesiones y las variables de sesion
  echo "</td></tr>";
   }
  $aux=$iter;
  $iter=$iter2;
  $iter2=$aux;
 }

echo "</table>";
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
$sqlr="Delete from modulo_rol where id_rol=$_POST[codigo]";
//echo $sqlr."<br>";
//$resp=oci_parse ($linkbd, $sqlr);
//oci_execute ($resp);
//echo "$sqlr<br>";
$resp = mysql_query($sqlr,$linkbd);
$i=0;
Foreach ($_POST[tabla] as $id)//For ($i=1;$i<=count($v);$i++)
{
  $sqlr="Select MAX(id_modulo) from modulo_rol ";
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
$sqlr="insert into modulo_rol (id_rol,id_modulo,estado) values($_POST[codigo],$v[$i],'1')";
//$resp=oci_parse ($linkbd, $sqlr);
//oci_execute ($resp);
//echo $sqlr."<br>";
$resp = mysql_query($sqlr,$linkbd);
$i+=1;
}
echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha Actualizado con Exito</center></td></tr></table>";
//oci_free_statement($resp);
//oci_c
lose($linkdb);
}
?>
    </td>
    </tr>
    </table>
</body>

</html>
