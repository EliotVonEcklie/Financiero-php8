<?php //V 1000 12/12/16 ?>
<?php
require"comun.inc";
require"funciones.inc";
require('php-excel-reader/excel_reader2.php');
session_start();
$linkbd=conectar_bd();	
cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
//**niveles menu: Administracion (0) - Consultas (1) - Herramientas (2) - Reportes (3)
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<title>:: SPID - Tesoreria</title>

<script>
//************* ver reporte ************
//***************************************
function verep(idfac)
{
  document.form1.oculto.value=idfac;
  document.form1.submit();
  }
</script>
<script>
//************* genera reporte ************
//***************************************
function genrep(idfac)
{
  document.form2.oculto.value=idfac;
  document.form2.submit();
  }
</script>
<script>
function pdf()
{
document.form2.action="pdfbalance.php";
document.form2.target="_BLANK";
document.form2.submit();
document.form2.action="";
document.form2.target="";
}
</script>
<script>
//************* genera reporte ************
//***************************************
function guardar()
{

	if (confirm("Esta Seguro de Guardar"))
  	{
  	document.form2.oculto.value=2;
  	document.form2.submit();
  	}
}
</script>

<script src="css/calendario.js"></script>
<script src="css/programas.js"></script>
<link href="css/css2.css" rel="stylesheet" type="text/css" />
<link href="css/css3.css" rel="stylesheet" type="text/css" />
<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
	<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>
	<tr><?php menu_desplegable("teso");?></tr>
	<tr>
		<td colspan="3" class="cinta">
			<a href="teso-importapredial1.php" class="mgbt"><img src="imagenes/add.png"  alt="Nuevo" title="Nuevo"/></a>
			<a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" alt="Guardar" /></a>
			<a href="#" class="mgbt"><img src="imagenes/buscad.png" alt="Buscar" title="Buscar"/> </a>
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt" ><img src="imagenes/nv.png" alt="nueva ventana" title="Nueva Ventana" ></a>
			<a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png" alt="imprimir" title="Imprimir"></a>
			<a href="teso-gestionpredial.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
		</td>
	  </tr>
</table>
<script type="text/javascript">
var documentoCargado = false;
var guardarBD = false;

function cargarDocumento() {
  confirm("Los registros se guardaran en la base de datos.");
  document.form2.o1.value=1;
  document.form2.submit();
  documentoCargado = true;
}

function guardarCambios() {
    document.form2.o1.value=1;
    document.form2.o2.value=1;
    document.form2.submit();
    guardarBD = true;
    confirm("Los registros se han guardado en la base de datos.");
}

</script>

<tr><td colspan="3" class="tablaprin">
 <form action="teso-importapredial1.php" method="post" enctype="multipart/form-data" name="form2">
  <?php
  $vigusu=vigencia_usuarios($_SESSION[cedulausu]);
  ?>
    <table  align="center" class="inicio" >
      <tr >
        <td class="titulos" colspan="5">.: Importar Predial</td><td width="72" class="cerrar"><a href="teso-principal.php">Cerrar</a></td>
      </tr>
       <tr> <td width="142"  class="saludo1">Seleccione Archivo: </td>
        <td width="273" >
          <input type="file" name="archivotexto" id="archivotexto"></td>
        <td width="555" >
          <input type="button" name="generar" value="Cargar" onClick="cargarDocumento()">
          <!-- <input type="button" name="guardar" value="Guardar" onClick="guardarCambios()"> -->
          <input name="o1" type="hidden" value="0">
          <input name="o2" type="hidden" value="0">
<!--o1 y o2 son indicadores usados para a través de banderas pasar información de javascript a PHP.  -->
        </td>
       </tr>
    </table>

	<div class="subpantalla" id="subpantallaPredial" style="background-color:white">
  <?php
  $vigusu=vigencia_usuarios($_SESSION[cedulausu]);


  //Estas dos variables las utilizo para saber en PHP si el usuario ya hizo clic en cargar o guardar.
  $cargar=$_POST['o1'];
  $guardar=$_POST['o2'];

  if(is_uploaded_file($_FILES['archivotexto']['tmp_name'])){
    $location_file=$_FILES['archivotexto']['tmp_name'];
	$name_file=$_FILES['archivotexto']['name'];
	$type_file=$_FILES['archivotexto']['type'];
	$size_file=$_FILES['archivotexto']['size'];
	$content = file_get_contents($_FILES['archivotexto']['tmp_name']);
	$handle = fopen($_FILES['archivotexto']['tmp_name'],"r");
	if($location_file==""){
	header("location:teso-importapredial.php?msg=Please Choose the File");
	}else if ($type_file == '.txt'){
		header("location:teso-importapredial.php?msg=Upload file with .txt extension only");
	}
	else{
		$datosTipo1 = array();
		$datosTipo2 = array();
		$datosTipo3 = array();
		while (false !== ($line = fgets($handle)))
		{
			//$tipo = trim(substr($line, 31, 1));
					
            $departamento = trim(substr($line, 0, 2));
            $municipio = trim(substr($line, 2, 3));
            //$resolucion = trim(substr($line, 5, 4));
            //$radicacion = trim(substr($line, 9, 5));
            //$mutacion = trim(substr($line, 14, 1));
            $predio = trim(substr($line, 5, 15));
            $cancelainscribe = trim(substr($line, 30, 1));
            $numeroorden = trim(substr($line, 32, 3));
            $totalregistros = trim(substr($line, 35, 3));
            $nombre = trim(substr($line, 38, 33));
            $estadocivil = trim(substr($line, 71, 1));
            $tipodoc = trim(substr($line, 72, 1));
            $numerodoc = (int)trim(substr($line, 73, 12));
            $direccion = trim(substr($line, 85, 34));
            $comuna = trim(substr($line, 119, 1));
            $desteconomico = trim(substr($line, 120, 1)); 
            $areaterreno = trim(substr($line, 121, 12)); 
            $ha = (int)trim(substr($line, 121, 8));
            $met2 = (int)trim(substr($line, 129, 4));
            $areaconst = (int)trim(substr($line, 133, 6));
            $avaluo = (int)(trim(substr($line, 139, 12)));
            $vigencia = (int)substr(trim(substr($line, 151, 8)),-4);
            
            $datosTipo1[]=array(
                "departamento" => $departamento,
                "municipio" => $municipio,
                "resolucion" => $resolucion,
                "radicacion" => $radicacion,
                "mutacion" => $mutacion,
                "predio" => $predio,
                "cancelainscribe" => $cancelainscribe,
                "numeroorden" => $numeroorden,
                "totalregistros" => $totalregistros,
                "nombre" => $nombre,
                "estadocivil" => $estadocivil,
                "tipodoc" => $tipodoc,
                "numerodoc" => $numerodoc,
                "direccion" => $direccion,
                "comuna" => $comuna,
                "desteconomico" => $desteconomico,
                "areaterreno" => $areaterreno,
                "areaconst" => $areaconst,
                "avaluo" => $avaluo,
                "vigencia" => $vigencia
            );

            if($cancelainscribe=="C"){
                $sql = "SELECT 1 from tesopredios WHERE documento='$numerodoc' AND estado='S' AND cedulacatastral='$predio' ";
                $res = mysql_query($sql,$linkbd);
                $numPropietarios = mysql_num_rows($res);
                if($numPropietarios > 0){
                    $sql = "UPDATE tesopredios SET estado='N' WHERE documento='$numerodoc' AND cedulacatastral='$predio' AND estado='S' ";
                    if(mysql_query($sql,$linkbd)){
                        
                        echo "SE HA CANCELADO EL PREDIO CON CODIGO $predio PARA EL SEÑOR(A) $nombre </br>";
                    }
                }
                
            }else{
                $sql = "SELECT documento from tesopredios WHERE estado='N' AND cedulacatastral='$predio' ";
                $res = mysql_query($sql,$linkbd);
                $numPropietarios = mysql_num_rows($res);
                $row = mysql_fetch_row($res);
                
                if($numPropietarios > 0){
                    $sql = "UPDATE tesopredios SET documento='$numerodoc',nombrepropietario='$nombre',estado='S' WHERE documento='".$row[0]."' AND cedulacatastral='$predio' ";
                    if(mysql_query($sql,$linkbd)){
                        echo "SE HA INSCRITO EL PREDIO CON CODIGO $predio A NOMBRE DEL SEÑOR(A) $nombre </br>";
                    }
                }
            }
            
            $sql = "SELECT 1 FROM tesopredios WHERE cedulacatastral='$predio' AND documento='$numerodoc' AND estado='S' ";
            $res = mysql_query($sql,$linkbd);
            $numPredios = mysql_num_rows($res);
            if($numPredios == 0){
                $sql = "INSERT INTO tesopredios (cedulacatastral,ord,tot,e,d,documento,nombrepropietario,direccion,ha,met2,areacon,avaluo,vigencia,estado) VALUES ('$predio','$numeroorden','$totalregistros','','C','$numerodoc','$nombre','$direccion','$ha','$met2','$areaconst','$avaluo','$vigencia','S')";
                if(mysql_query($sql,$linkbd)){
                    echo "SE HA REGISTRADO EL NUEVO PREDIO CON CODIGO $predio A NOMBRE DEL SEÑOR(A) $nombre </br>";
                    
                    $sql = "UPDATE tesoprediosavaluos SET ha='$ha',met2='$met2',areacon='$areaconst' WHERE cedulacatastral='$predio' AND pago='N'";
                    mysql_query($sql,$linkbd);
                }
            }else{
                $sql = "UPDATE tesopredios SET ord='$numeroorden',tot='$totalregistros',direccion='$direccion',ha='$ha',met2='$met2',areacon='$areaconst',avaluo='$avaluo',vigencia='$vigencia' WHERE cedulacatastral='$predio' AND documento='$numerodoc' AND estado='S' ";
                if(mysql_query($sql,$linkbd)){
                    
                    echo "SE HA ACTUALIZADO EL PREDIO CON CODIGO $predio A NOMBRE DEL SEÑOR(A) $nombre </br>";
                    
                    $sql = "UPDATE tesoprediosavaluos SET ha='$ha',met2='$met2',areacon='$areaconst' WHERE cedulacatastral='$predio' AND pago='N'";
                    mysql_query($sql,$linkbd);
                }
            }
					

		}


		fclose($handle);
		
        }

  }

 ?>
</table>
</body>
</html>
