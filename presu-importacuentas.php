<?php //IDEAL10 06/12/19 DD
	/**
	 * Vista Presupuesto para importación de cuentas
	 * Se importa librerias con funciones estandares
	 */
	require 'comun.inc';
	require 'funciones.inc';
	session_start();
	header("Cache-control: private");
	date_default_timezone_set("America/Bogota");

	/**
	 * Condicional para cargue de información del EXCEL a la variable $_POST
	 */
	if(@$_POST['import']==1){
		$_POST['cuenta']=array();
		$_POST['nombre']=array();
		$_POST['tipo']=array();
		$_POST['clasificacion']=array();
		$_POST['regalias']=array();
		$_POST['causacion']=array();
		$_POST['fuente']=array();
		$_POST['posicion']=array();

		if(is_uploaded_file(@$_FILES['archivotexto']['tmp_name']))
		{
			$archivo = @$_FILES['archivotexto']['name'];
			$archivoF = "$archivo";
			if(move_uploaded_file($_FILES['archivotexto']['tmp_name'],$archivoF))
				$subio=1;
		}

		require_once 'PHPExcel/Classes/PHPExcel.php';
		$inputFileType = PHPExcel_IOFactory::identify(@$archivo);
		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$objPHPExcel = $objReader->load($archivo);
		$sheet = $objPHPExcel->getSheet(0);
		$highestRow = $sheet->getHighestRow();
		$highestColumn = $sheet->getHighestColumn();

		$cod = 1;
		for ($row = 3; $row <= $highestRow; $row++)
		{
			$val1 = $sheet->getCell("A".$row)->getValue();
			$val2 = utf8_decode($sheet->getCell("B".$row)->getValue());
			$val3 = $sheet->getCell("C".$row)->getValue();
			$val4 = $sheet->getCell("D".$row)->getValue();
			$val5 = $sheet->getCell("E".$row)->getValue();
			$val6 = $sheet->getCell("F".$row)->getValue();
			$val7 = $sheet->getCell("G".$row)->getValue();

			$_POST['cuenta'][]=$val1;
			$_POST['nombre'][]=$val2;
			$_POST['tipo'][]=$val3;
			$_POST['clasificacion'][]=$val4;
			$_POST['regalias'][]=$val5;
			$_POST['causacion'][]=$val6;
			$_POST['fuente'][]=$val7;
			$_POST['posicion'][]=$cod;
			$cod+=1;
		}
	}
?>

<!DOCTYPE html5>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>:: IDEAL10 - Presupuesto</title>

    <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
    <link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
    <link href="css/tabs.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="bootstrap/css/estilos.css">
    <link rel="stylesheet" href="bootstrap/fontawesome.5.11.2/css/all.css">
    <link rel="stylesheet" href="css/sweetalert.css">

    <script type="text/javascript" src="JQuery/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
    <script type="text/javascript" src="css/calendario.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
    <script type="text/javascript" src="javaScript/funciones.js"></script>
    <script type="text/javascript" src="css/funciones.js"></script>
    <script type="text/javascript" src="ajax/funcionesPresupuesto.js"></script>

    <script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="bootstrap/fontawesome.5.11.2/js/all.js"></script>
    <script type="text/javascript" src="css/sweetalert.js"></script>
    <?php titlepag();?>
</head>

<body>
    <div class="container-fluid">
        <table>
            <tr>
                <script>
                barra_imagenes("presu");
                </script><?php cuadro_titulos();?>
            </tr>
            <tr><?php menu_desplegable("presu");?></tr>
            <tr>
                <td colspan="3" class="cinta">
                    <a href="presu-importacuentas.php" class="mgbt">
                        <img src="imagenes/add.png" title="Nuevo" />
                    </a>
                    <a href="#" onClick="guardarImportaCuentas()" class="mgbt">
                        <img src="imagenes/guarda.png" title="Guardar" />
                    </a>
                    <a class="mgbt">
                        <img src="imagenes/buscad.png" title="Buscar" />
                    </a>
                    <a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img
                            src="imagenes/agenda1.png" title="Agenda" />
                    </a>
                    <a href="#" class="mgbt"
                        onClick="mypop=window.open('presu-principal.php','','');mypop.focus();"><img
                            src="imagenes/nv.png" title="Nueva Ventana">
                    </a>
                </td>
            </tr>
        </table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0
                    style=" width:680px; height:110px; top:200; ">
                </IFRAME>
            </div>
        </div>
        <section class="section-header-gb">
            <div class="card">
                <div class="row my-1 mx-1 titulo-gb">
                    <div class="col-md-10 col-sm-10 col-10 pt-1">
                        <span class="pl-1 text-white">.: Importar Plan de Cuentas
                            Presupuestales</span>
                    </div>
                    <div class="col-md-2 col-sm-2 col-2 text-right p-0">
                        <a href="presu-principal.php">
                            <button type="button" class="btn btn-sm btn-outline-light font-weight-bolder">
                                <i class="fas fa-times-circle"></i>
                                <span class="ml-1">Cerrar</span>
                            </button>
                        </a>
                    </div>
                </div>
                <form class="form-inline mb-1" method="post" name="form2" enctype="multipart/form-data">
                    <div class="col-md-1 col-sm-1 col-1 px-1">
                        <label class="etiqueta-gb py-1">Entidad:</label>
                    </div>
                    <div class="col-md-1 col-sm-1 col-1 px-1">
                        <select class="form-control" name="entidades" id="entidades">
                            <option value="1" <?php if(@$_POST['entidades']=="1"){echo "selected"; }?>>Interna</option>
                            <option value="2" <?php if(@$_POST['entidades']=="2"){echo "selected"; }?>>Externa</option>
                        </select>
                    </div>
                    <div class="col-md-1 col-sm-1 col-1 mx-0 px-1">
                        <label class="etiqueta-gb py-1">
                            Archivo
                        </label>
                    </div>
                    <div class="col-md-3 col-sm-3 col-3 px-1">
                        <input class="pb-4" type="file" name="archivotexto" id="archivotexto" style="width:100%;"
                            accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                    </div>
                    <div class="col-md-1 col sm-1 col-1 px-1">
                        <label class="etiqueta-gb py-1">Fecha:</label>
                    </div>
                    <div class="col-md-3 col-sm-3 col-3 px-0 ">
                        <input type="text" name="fecha" value="<?php echo @$_POST['fecha']; ?>"
                            class="form-control imput--fecha" aria-describedby="basic-addon1"
                            onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"
                            id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY"
                            placeholder="DD/MM/YYYY">
                        <a href="#" onClick="displayCalendarFor('fc_1198971545');" title="Calendario"><img
                                src="imagenes/calendario04.png" style="width:20px;" /></a>
                    </div>
                    <div class="col-md-2 col sm-2 col-2 px-0 d-inline-flex">
                        <button type="button" class="btn btn-primary m-1" name="generar" id="btnCargar"
                            onClick="cargar()" disabled>
                            <i class="fas fa-upload"></i>
                            Cargar
                        </button>
                        <button type="button" class="btn btn-primary m-1" onClick="protocoloimport()"
                            data-toggle="tooltip" data-placement="bottom" title="Descarga Formato de Importacion">
                            <i class="fas fa-download"></i>
                            Formato
                        </button>
                        <input type="hidden" name="import" id="import" value="<?php echo $_POST['import'] ?>">
                    </div>
                </form>
            </div>
        </section>
        <section class="section-body-gb">
            <div class="subpantalla" style="height:60%; width:99.6%; overflow-x:hidden;">
                <table class="table table-sm table-primary table-hover table-responsive">
                    <thead>
                        <tr>
                            <td scope="col" style='width: 5%'>Posicion</td>
                            <td scope="col" style='width: 10%'>Cuenta</td>
                            <td scope="col" style='width: 30%'>Nombre</td>
                            <td scope="col" style='width: 10%'>Tipo</td>
                            <td scope="col" style='width: 10%'>Clasificacion</td>
                            <td scope="col" style='width: 5%'>Regalias</td>
                            <td scope="col" style='width: 5%'>Causacion Contable</td>
                            <td scope="col" style='width: 10%'>Fuente</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
							/**
							 * Condicional para cargar de la información en inputs y en la tabla de visualización
							 */
							if(@$_POST['import']==1){
								echo "
								<script>
									document.form2.import.value=2;
								</script>";
							}
							$iter="saludo1";
							$iter2="saludo2";
							for($x = 0;$x < count(@$_POST['cuenta']);$x++)
							{
								echo "
									<input type='hidden' name='cuenta[]' value='".$_POST['cuenta'][$x]."'>
									<input type='hidden' name='nombre[]' value='".$_POST['nombre'][$x]."'>
									<input type='hidden' name='tipo[]' value='".$_POST['tipo'][$x]."'>
									<input type='hidden' name='clasificacion[]' value='".$_POST['clasificacion'][$x]."'>
									<input type='hidden' name='regalias[]' value='".$_POST['regalias'][$x]."'>
									<input type='hidden' name='causacion[]' value='".$_POST['causacion'][$x]."'>
									<input type='hidden' name='fuente[]' value='".$_POST['fuente'][$x]."'>
									<input type='hidden' name='posicion[]' value='".@$_POST['posicion'][$x]."'>
								";
								echo "<tr class='$iter'>
										<td>".$_POST['posicion'][$x]."</td>
										<td>".$_POST['cuenta'][$x]."</td>
										<td>".$_POST['nombre'][$x]."</td>
										<td>".$_POST['tipo'][$x]."</td>
										<td>".$_POST['clasificacion'][$x]."</td>
										<td>".$_POST['regalias'][$x]."</td>
										<td>".$_POST['causacion'][$x]."</td>
										<td>".$_POST['fuente'][$x]."</td>
									</tr>
								";
								$aux=$iter;
								$iter=$iter2;
								$iter2=$aux;
							}
							echo "</table>";
						?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</body>

<script>
/**@abstract
 * Funciones de carga automatica
 * Declaración del tooltip
 * Evento de escucha al cambio asignado [id = #archivotexto]
 */
$(function() {
    $('[data-toggle="tooltip"]').tooltip();
    $('#archivotexto').change(function(e) {
        validateFile = $('#archivotexto').val() ? $('#btnCargar').attr('disabled', false) : $(
            '#btnCargar').attr('disabled', true);
    });
});

/**@abstract
 * Despliega ventana emergente heredada
 */
function despliegamodalm(_valor, _tip, mensa, pregunta) {
    document.getElementById("bgventanamodalm").style.visibility = _valor;

    if (_valor == "hidden") {
        document.getElementById('ventanam').src = "";
    } else {
        switch (_tip) {
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
                document.getElementById('ventanam').src = "ventana-consulta1.php?titulos=" + mensa +
                    "&idresp=" +
                    pregunta;
                break;
        }
    }
}

/**@abstract
 * Función para descargar formato de importación de cuentas
 */
function protocoloimport() {
    document.form2.action = "presu-cuentas-import10.php";
    document.form2.target = "_BLANK";
    document.form2.submit();
    document.form2.action = "";
    document.form2.target = "";
}

/**@abstract
 * Función para carga de formato de importación de cuentas
 */
function cargar() {
    document.form2.import.value = 1;
    document.form2.submit();
}
</script>

</html>
