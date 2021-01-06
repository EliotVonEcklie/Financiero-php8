<?php //IDEAL10 19/01/20 DD
/**
 * Vista notas bancarias Tesoreria
 * Se define fecha actual
 */
require 'comun.inc';
require 'funciones.inc';
sesion();
header("Cache-control: private");
header("Content-Type: text/html;charset=utf8");
date_default_timezone_set("America/Bogota");
@$_POST['fecha'] = date("d/m/Y");
?>

<!DOCTYPE html5>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>:: IDEAL10 - Tesoreria </title>

    <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
    <link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
    <link href="css/css4.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="bootstrap/css/estilos.css">
    <link rel="stylesheet" href="bootstrap/fontawesome.5.11.2/css/all.css">
    <link rel="stylesheet" href="bootstrap/datatables/dataTables.min.css">
    <link rel="stylesheet" href="css/sweetalert.css">

    <script type="text/javascript" src="JQuery/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
    <script type="text/javascript" src="css/calendario.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
    <script type="text/javascript" src="ajax/funcionesTesoreria.js"></script>

    <script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript" src="bootstrap/fontawesome.5.11.2/js/all.js"></script>
    <script type="text/javascript" src="bootstrap/datatables/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="bootstrap/datatables/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="bootstrap/numeral/numeral.min.js"></script>
    <script type="text/javascript" src="bootstrap/numeral/locales.min.js"></script>
    <script type="text/javascript" src="css/sweetalert.js"></script>
    <?php titlepag();?>
</head>

<body>
    <!-- Modal>
    <div class="modal hide fade" data-keyboard="true" id="modal_cargando" tabindex="-1" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close"></button>
                <div class="body-modal p-0">
                    <div class="body-loading">
                        <div class="loading" id="div_carga">
                            <span>Cargando...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div-->
    <div class="container-fluid">
        <table>
            <tr>
                <script>
                barra_imagenes("teso");
                </script>
                <?php cuadro_titulos();?>
            </tr>
            <tr><?php menu_desplegable("teso");?></tr>
            <tr>
                <td colspan="3" class="cinta">
                    <a href="teso-notasbancarias.php" class="mgbt">
                        <img src="imagenes/add.png" title="Nuevo" />
                    </a>
                    <a onClick="guardarNotaBancaria(arrayNotaBanca, $('#tipo_mov').val())" class="mgbt">
                        <img src="imagenes/guarda.png" title="Guardar" />
                    </a>
                    <a href="teso-buscarnotasbancarias.php" class="mgbt">
                        <img src="imagenes/busca.png" title="Buscar" />
                    </a>
                    <a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img
                            src="imagenes/agenda1.png" title="Agenda" />
                    </a>
                    <a class="mgbt" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();"><img
                            src="imagenes/nv.png" title="Nueva Ventana">
                    </a>
                    <a class="mgbt" onClick="generarPDF()">
                        <img src="imagenes/print.png" title="Imprimir" />
                    </a>
                    <a href="teso-buscarnotasbancarias.php" class="mgbt">
                        <img src="imagenes/iratras.png" title="Atras" />
                    </a>
                </td>
            </tr>
        </table>
        <section class="section-header-gb mb-1">
            <div class="card">
                <div class="row my-1 mx-1 titulo-gb">
                    <div class="col-md-10 col-sm-10 col-10 pt-1">
                        <span class="pl-1 text-white">.: Nota Bancaria </span>
                    </div>
                    <div class="col-md-2 col-sm-2 col-2 text-right p-0">
                        <a href="teso-principal.php">
                            <button type="button" class="btn btn-sm btn-outline-light font-weight-bolder">
                                <i class="fas fa-times-circle"></i>
                                <span class="ml-1">Cerrar</span>
                            </button>
                        </a>
                    </div>
                </div>
                <div class="form-inline mb-2">
                    <div class="col-md-2 col-sm-2 col-2 px-1">
                        <label class="etiqueta-gb py-1">Tipo de movimiento</label>
                    </div>
                    <div class="col-md-2 col-sm-2 col-2 px-1">
                        <select class="form-control w-100" id="tipo_mov" name="tipo_mov">
                            <option value="201">201 - Crear Nota</option>
                            <option value="401">401 - Reversar Nota</option>
                        </select>
                    </div>
                    <div class="col-md-1 col-sm-1 col-1 px-1">
                        <label class="etiqueta-gb py-1">Fecha</label>
                    </div>
                    <div class="col-md-3 col-sm-3 col-3 px-0">
                        <input type="text" value="<?php echo @$_POST['fecha']; ?>" class="form-control imput--fecha"
                            aria-describedby="basic-addon1" onKeyPress="javascript:return solonumeros(event)"
                            onKeyUp="return tabular(event,this)" id="fc_1198971545"
                            onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" placeholder="DD/MM/YYYY">
                        <a href="#" onClick="displayCalendarFor('fc_1198971545');" title="Calendario">
                            <img src="imagenes/calendario04.png" style="width:20px;" />
                        </a>
                    </div>
                    <div class="form-inline col-md-3 col-sm-3 col-3 p-0" id="div_comp" name="div_comp">
                        <div class="col-md-4 col-sm-4 col-4 px-1">
                            <label class="etiqueta-gb py-1"># Comprob.</label>
                        </div>
                        <div class="col-md-8 col-sm-8 col-8 px-1">
                            <input class="form-control w-100" type="text" id="id_comp" name="id_comp" readonly>
                        </div>
                    </div>
                </div>
                <div class="form mb-1" id="form_201">
                    <div class="form-inline mb-2">
                        <div class="col-md-1 col-sm-1 col-1 px-1">
                            <label class="etiqueta-gb py-1">CCosto</label>
                        </div>
                        <div class="col-md-3 col-sm-3 col-3 px-1">
                            <select class="form-control w-100" id="ccosto" name="ccosto_act"></select>
                        </div>
                        <div class="col-md-1 col-sm-1 col-1 px-1">
                            <label class="etiqueta-gb py-1">Concepto nota</label>
                        </div>
                        <div class="col-md-3 col-sm-3 col-3 px-1">
                            <input class="form-control w-100" type="text" id="concepto">
                        </div>
                        <div class="col-md-1 col-sm-1 col-1 px-1">
                            <label class="etiqueta-gb py-1">Doc banco</label>
                        </div>
                        <div class="col-md-3 col-sm-3 col-3 px-1">
                            <input class="form-control w-100" type="text" id="num_banco">
                        </div>
                    </div>
                    <div class="form-inline mb-1">
                        <div class="col-md-1 col-sm-1 col-1 px-1">
                            <label class="etiqueta-gb py-1">Cuenta bancaria</label>
                        </div>
                        <div class="col-md-3-col-sm-3 col-3 px-1">
                            <div class="input-group">
                                <input class="form-control" type="text" id="cuenta_banca" name="cuenta_banca" readonly>
                                <div class=" input-group-append">
                                    <button class="btn btn-primary" onClick="despliegamodal2('visible','1');">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1 col-sm-1 col-1 px-1">
                            <label class="etiqueta-gb py-1">Descripción</label>
                        </div>
                        <div class="col-md-3 col-sm-3 col-3 px-1">
                            <input class="form-control w-100" type="text" id="ncuenta_banca" name="ncuenta_banca"
                                readonly>
                        </div>
                        <div class="col-md-1 col-sm-1 col-1 px-1">
                            <label class="etiqueta-gb py-1">Gasto bancario</label>
                        </div>
                        <div class="col-md-3 col-sm-3 col-3 px-1">
                            <select class="form-control w-100" id="gasto_banca" name="gasto_banca"></select>
                        </div>
                    </div>
                    <div class="form-inline mb-1">
                        <div class="form-inline col-md-3 col-sm-3 col-3 p-0" id="div_valor" name="div_valor">
                            <div class="col-md-4 col-sm-4 col-4 px-1">
                                <label class="etiqueta-gb py-1">Valor nota</label>
                            </div>
                            <div class="col-md-8 col-sm-8 col-8 px-1">
                                <input class="form-control w-100 text-right" type="text" id="valor">
                            </div>
                        </div>
                        <div class="offset-6 col-md-2 col-sm-2 col-2 px-1" id="div_btn_deta">
                            <button class="btn btn-primary w-100" onClick="agregarDetalles()">
                                <i class="fas fa-plus-circle"></i>
                                Agregar
                            </button>
                        </div>
                    </div>
                    <div>
                        <input type="hidden" id="nickusu" value="<?php echo$_SESSION['nickusu']?>">
                        <input type="hidden" id="ccuenta_banca" name="ccuenta_banca">
                        <input type="hidden" id="tccuenta_banca" name="tccuenta_banca">
                    </div>
                </div>
                <div class="form mb-1" id="form_401" hidden>
                    <div class="form-inline mb-2">
                        <div class="col-md-1 col-sm-1 col-1 px-1">
                            <label class="etiqueta-gb py-1">Nota bancaria</label>
                        </div>
                        <div class="col-md-2 col-sm-2 col-2 px-1">
                            <div class="input-group">
                                <input class="form-control" type="text" id="nota_banca" name="nota_banca" readonly>
                                <div class=" input-group-append">
                                    <button class="btn btn-primary" onClick="despliegamodal2('visible','3');">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1 col-sm-1 col-1 px-1">
                            <label class="etiqueta-gb py-1">Fecha creación</label>
                        </div>
                        <div class="col-md-2 col-sm-2 col-2 px-0">
                            <input type="text" name="fecha" class="form-control imput--fecha"
                                aria-describedby="basic-addon1" id="fecha" readonly>
                        </div>
                        <div class="col-md-1 col-sm-1 col-1 px-1">
                            <label class="etiqueta-gb py-1">Concepto</label>
                        </div>
                        <div class="col-md-5 col-sm-5 col-5 px-1">
                            <input class="form-control w-100" type="text" id="concepto_nota" name="concepto_nota"
                                readonly>
                        </div>
                    </div>
                    <div class="form-inline mb-2">
                        <div class="col-md-1 col-sm-1 col-1 px-1">
                            <label class="etiqueta-gb py-1">Valor nota</label>
                        </div>
                        <div class="col-md-2 col-sm-2 col-2 px-1">
                            <input class="form-control w-100 text-right" type="text" id="valor_nota" name="valor_nota"
                                readonly>
                        </div>
                        <div class="col-md-1 col-sm-1 col-1 px-1">
                            <label class="etiqueta-gb py-1">Nota reversión</label>
                        </div>
                        <div class="col-md-8 col-sm-8 col-8 px-1">
                            <input class="form-control w-100" type="text" id="concepto_nota_rever"
                                name="concepto_nota_rever">
                        </div>
                    </div>
                </div>
            </div>
            <form id="formPDF" method="POST" action="teso-pdfnotasbancarias.php" target="_BLANK" hidden>
                <input type="hidden" name="id_nota" id="id_nota" />
            </form>
        </section>
        <div class="card" id="nav_rp" hidden>
            <section class="section-header-gb mb-1">
                <nav class="nav nav-fill m-1">
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link btn-primary text-white active" id="nav-add-tab" data-toggle="tab"
                            href="#nav-add" role="tab" aria-controls="nav-add" aria-selected="true" hidden>Agregar</a>
                        <a class="nav-item nav-link btn-primary text-white" id="nav-view-tab" data-toggle="tab"
                            href="#nav-view" role="tab" aria-controls="nav-view" aria-selected="false"
                            hidden>Visualizar</a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-add" role="tabpanel" aria-labelledby="nav-add-tab">
                        <form name="form2" onsubmit="return false;">
                            <div class="form-inline mb-1">
                                <div class="col-md-1 col-sm-1 col-1 px-1">
                                    <label class="etiqueta-gb py-1">Número Rp</label>
                                </div>
                                <div class="col-md-2 col-sm-2 col-2 px-1">
                                    <div class="input-group">
                                        <input class="form-control" type="text" id="rp" name="rp" readonly
                                            onblur="buscarDetallesRp(this.value, cargarDatosTabla)">
                                        <div class=" input-group-append">
                                            <button class="btn btn-primary" onClick="despliegamodal2('visible','2');">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1 col-sm-1 col-1 px-1">
                                    <label class="etiqueta-gb py-1">Descripción</label>
                                </div>
                                <div class="col-md-3 col-sm-3 col-3 px-1">
                                    <input class="form-control w-100" type="text" id="des_rp" name="des_rp" disabled>
                                </div>
                                <div class="col-md-1 col-sm-1 col-1 px-1">
                                    <label class="etiqueta-gb py-1">Valor</label>
                                </div>
                                <div class="col-md-2 col-sm-2 col-2 px-1">
                                    <input class="form-control w-100 text-right" type="text" id="valor_rp"
                                        name="valor_rp">
                                </div>
                                <div class="col-md-2 col-xs-2 col-2">
                                    <button class="btn btn-primary w-100" onClick="agregarDetallesGastosRp()">
                                        <i class="fas fa-plus-circle"></i>
                                        Agregar
                                    </button>
                                </div>
                            </div>
                        </form>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover" id="dataTable_add" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Cuenta</th>
                                            <th scope="col">Nombre Cuenta</th>
                                            <th scope="col">Saldo</th>
                                        </tr>
                                    </thead>
                                    <tbody class="font-weight-normal">
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="text-right" colspan="3">Total:</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-view" role="tabpanel" aria-labelledby="nav-view-tab">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover" id="dataTable_view" cellspacing="0"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">CCosot</th>
                                            <th scope="col">Doc Bancario</th>
                                            <th scope="col">Cuenta Bancaria</th>
                                            <th scope="col">Banco</th>
                                            <th scope="col">Gasto Bancario</th>
                                            <th scope="col"># Rp</th>
                                            <th scope="col">Rp / Compromiso</th>
                                            <th scope="col">Valor</th>
                                            <th scope="col">Ope</th>
                                        </tr>
                                    </thead>
                                    <tbody class="font-weight-normal">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <div id="bgventanamodal2">
        <div id="ventanamodal2">
            <IFRAME name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0
                style="left:500px; width:880px; height:480px; top:200;"></IFRAME>
        </div>
    </div>
</body>

<script type="text/javascript">
var dataTable = null;
var arrayParametrosTeso = ['TESOPARAMETROS'];
var arrayNotaBanca = [];
let arrayIdDetalles = ['ccosto', 'num_banco', 'cuenta_banca', 'ncuenta_banca', 'ccuenta_banca', 'tccuenta_banca',
    'gasto_banca', 'rp', 'des_rp', 'valor'
];
let arrayIdCabecera = ['tipo_mov', 'fc_1198971545', 'id_comp', 'concepto', 'nickusu'];
let parameters = null;
/**@abstract
 * Función de carga automatica
 * Carga de parametros
 * Validaciones iniciales
 */
$(document).ready(function() {
    numeral.locale('es');
    buscarParametrosTesoreria(arrayParametrosTeso, tesoParametros);
    //setTimeout(buscarParametrosNotas(llenarNotasParametros), 100);
    $("form[name='form2']").submit(function(e) {
        e.preventDefault();
        return false;
    });
    $('#tipo_mov').on('change', function() {
        if (this.value == 201) {
            $('#form_201').attr('hidden', false);
            $('#form_401').attr('hidden', true);
            $('#div_comp').attr('hidden', false);
            $('#gasto_banca').change();
        } else {
            $('#form_201').attr('hidden', true);
            $('#form_401').attr('hidden', false);
            $('#nav_rp').attr('hidden', true);
            $('#div_comp').attr('hidden', true);
        }
    });
    $('#gasto_banca').on('change', function() {
        let tipo = $('#gasto_banca option:selected').text().split('--')[0];
        if (tipo == 'G' && arrayParametrosTeso['notabancariarp'] == 'S') {
            $('#nav_rp').attr('hidden', false);
            $('#nav-add-tab').attr('hidden', false);
            $('#nav-add').attr('hidden', false);
            $('#div_valor').attr('hidden', true);
            $('#div_btn_deta').attr('hidden', true);
        } else {
            $('#nav-add-tab').attr('hidden', true);
            $('#nav-add').attr('hidden', true);
            $('#div_valor').attr('hidden', false);
            $('#div_btn_deta').attr('hidden', false);
            if (Object.entries(arrayNotaBanca).length == 0)
                $('#nav_rp').attr('hidden', true);
        }
    });
    $('#valor').on('keyup', function() {
        this.value = numeral(this.value).format('$0,0');
    });
    $('#valor_rp').on('keyup', function() {
        this.value = numeral(this.value).format('$0,0');
    });
    $('#nota_banca').on('blur', function() {
        if (this.value != '' || this.value != null)
            buscarHistorialNotas({
                id_notaban: this.value,
                estado: 'S'
            }, function(data) {
                $('#concepto_nota').val(data[0]['concepto']);
                $('#valor_nota').val(numeral(data[0]['valor']).format('$0,0'));
                arrayNotaBanca.splice(0, arrayNotaBanca.length);
            });
    });
});

/**@abstract
 * Función para obtener parametro de la URL
 */
var getParameters = function() {
    var $_GET = {};
    var args = location.search.substr(1).split(/&/);
    for (var i = 0; i < args.length; ++i) {
        var tmp = args[i].split(/=/);
        if (tmp[0] != "")
            $_GET[decodeURIComponent(tmp[0])] = decodeURIComponent(tmp.slice(1).join("").replace("+", " "));
    }
    return $_GET;
}

/**@abstract
 * Función para validar notabancaria con rp
 */
var tesoParametros = function(datos) {
    arrayParametrosTeso = datos['TESOPARAMETROS'];
    buscarParametrosNotas(llenarNotasParametros);
}

/**@abstract
 * Función para llenar parametros de notas bancarias
 */
var llenarNotasParametros = function(datos) {
    if (Object.entries(datos).length !== 0) {
        for (const parametro in datos) {
            if (parametro == 'id_comp') {
                $('#' + parametro).val(datos[parametro]);
            } else {
                for (const detalle of datos[parametro]) {
                    let $option = $('<option />', {
                        text: detalle['id_cc'] ? detalle['nombre'] : detalle['tipo'] + '--' + detalle[
                            'nombre'],
                        value: detalle['id_cc'] || detalle['codigo'].zfill(2),
                    });
                    $('#' + parametro).append($option);
                }
                $('#' + parametro).prepend($('<option />', {
                    text: 'Seleccione',
                    value: 0,
                    selected: true
                }));
            }
        }
    }
    //editar al terminar de cargar parametros necesarios
    parameters = getParameters();
    if (parameters['type'] == 'edit' || parameters['type'] == 'view') {
        buscarHistorialNotas({
            id_notaban: parameters['id'],
            estado: parameters['active'],
            detalles: true
        }, visualizarNota);
    }
}

/**@abstract
 * Function agregar detalles gastos o ingresos
 */
var agregarDetalles = function() {
    let arrayData = {};
    arrayData['cuenta_rubro']='';
    $('#rp').val(0);
    $('#des_rp').val(' ');
    if (validarParametros(arrayData, arrayIdDetalles)) {
        arrayNotaBanca.push(arrayData);
        //data table view
        renderDataTable();
        if (arrayNotaBanca.length > 0)
            cargarDatosTabla({
                arrayNotaBanca
            }, 'visualizar');
        else
            $('#dataTable_view').dataTable({
                data: arrayNotaBanca
            }).draw();
    }
}

/**@abstract
 * Function agregar gastos con Rp parametros tesoreria
 */
var agregarDetallesGastosRp = function() {
    let arrayData = {};
    let arrayRubros = {};
    if (arrayNotaBanca.length > 0 && Object.entries(arrayNotaBanca.filter((nota) => nota.rp == $('#rp')
            .val()))
        .length > 0)
        swal("IDEAL 10", "Rp en uso, seleccione otro Rp!", "warning");
    else {
        arrayData['valor_rubro'] = numeral(dataTable.column(3).footer().textContent)
            .value();
        if (validarParametros(arrayData, arrayIdDetalles)) {
            let arrayDataSelected = $('#dataTable_add  tbody tr.selected').children();
            /*Metodo para varios rubros
			for (let i = 3; i < arrayDataSelected.length; i = i + 4)
                arrayRubros[i - 3] = arrayDataSelected[i - 2].textContent;*/
            arrayData['cuenta_rubro'] = (arrayDataSelected.length > 0) ? arrayDataSelected[1].textContent :
                $('#des_rp').val();

            renderDataTable();
            arrayNotaBanca.push(arrayData);
            //data table view
            if (arrayNotaBanca.length > 0)
                cargarDatosTabla({
                    arrayNotaBanca
                }, 'visualizar');
            else
                $('#dataTable_view').dataTable({
                    data: arrayNotaBanca
                }).draw();
        }
    }
}

var cargarDatosTabla = function(argument, type) {
    let idDataTable;
    let footer;
    let columnDefs;
    if (type == 'crear') {
        //Parametros tabla agregar
        idDataTable = 'dataTable_add';
        footer = ['saldo', '3'];
        columnDefs = [{
                targets: 0,
                data: 'id_cdpdetalle',
                orderable: false,
                render: function(data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            {
                targets: 1,
                data: 'cuenta',
                orderable: false,
            },
            {
                targets: 2,
                data: 'ncuenta',
                orderable: false,
                render: function(data, type, row, meta) {
                    return data['nombre'];
                }
            },
            {
                targets: 3,
                data: 'saldo',
                orderable: false,
                render: function(data, type, row, meta) {
                    return numeral(data).format('$0,0')
                }
            }
        ];
        if (dataTable) {
            $('#' + idDataTable).DataTable().draw().destroy();
            $('#' + idDataTable + '> tbody').empty();
        }
    } else {
        //Parametros tabla visualizar
        idDataTable = 'dataTable_view';
        footer = ['valor', '6']
        columnDefs = [{
                targets: 0,
                data: 'ccosto',
            },
            {
                targets: 1,
                data: 'num_banco'
            },
            {
                targets: 2,
                data: 'cuenta_banca'
            },
            {
                targets: 3,
                data: 'ncuenta_banca'
            },
            {
                targets: 4,
                data: 'gasto_banca'
            },
            {
                targets: 5,
                data: 'rp',
                width: '5%'
            },
            {
                targets: 6,
                data: 'des_rp',
                width: '40%'
            },
            {
                targets: 7,
                data: 'valor'
            },
            {
                targets: 8,
                data: '',
                orderable: false,
                render: function(data, type, row, meta) {
                    return `<div class="btn-group" role="group">
									<button type="button" class="btn btn-danger" id="delete_` + row.rp + `">
										<i class="fas fa-times-circle"></i>
									</button>
							</div>`;
                }
            },
        ];
    }

    dataTable = $('#' + idDataTable).DataTable({
        data: $.map(argument, function(value, key) {
            return value;
        }),
        bFilter: false,
        paging: false,
        scrollY: '155px',
        scrollCollapse: true,
        order: [
            [1, "asc"]
        ],
        language: {
            "emptyTable": "No hay datos disponibles en la tabla.",
            "info": "Del _START_ al _END_ de _TOTAL_ ",
            "infoEmpty": "Mostrando 0 registros de un total de 0.",
            "infoFiltered": "(filtrados de un total de _MAX_ registros)",
            "infoPostFix": "(Registros)",
            "lengthMenu": "Mostrar _MENU_ registros",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "searchPlaceholder": "Dato para buscar",
            "zeroRecords": "No se han encontrado coincidencias.",
            "paginate": {
                "first": "Primera",
                "last": "Última",
                "next": "Siguiente",
                "previous": "Anterior"
            },
            "aria": {
                "sortAscending": "Ordenación ascendente",
                "sortDescending": "Ordenación descendente"
            }
        },
        columnDefs: columnDefs,
        footerCallback: function(row, data, start, end, display) {
            var api = this.api(),
                data;
            $('#' + idDataTable + ' tbody').on('click', 'tr', function() {
                if ($(this).hasClass('selected'))
                    $(this).removeClass('selected');
                else {
                    api.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                }
                // Remove the formatting to get integer data for summation
                var intVal = function(i) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '') * 1 :
                        typeof i === 'number' ?
                        i : 0;
                };

                // Total items selected
                total = 0;
                arraySelectd = api.rows('.selected').data();
                for (let i = 0; i < arraySelectd.length; i++)
                    total += intVal(arraySelectd[i][footer[0]]);

                $(api.column(footer[1]).footer()).html(
                    numeral(total).format('$0,0')
                );
            });
        }
    });
    //tabla visualizar
    if (type == 'visualizar') {
        //Ajustar tabla
        $('#nav-view').css('display', 'block');
        dataTable.columns.adjust().draw();
        $.fn.dataTable
            .tables({
                visible: true,
                api: true
            })
            .columns.adjust();
        //Metodo de eliminar registro
        $('#' + idDataTable).on('click', 'button.btn.btn-danger', function() {
            $('#' + idDataTable).dataTable().api().row($(this).parents('tr')).remove().draw();
            var idNode = $(this)[0].id;
            arrayNotaBanca = arrayNotaBanca.filter((nota) => nota.rp != idNode.split('_')[1]);
        });
    }
}

var renderDataTable = function() {
    $('#dataTable_add').DataTable().draw().destroy();
    $('#dataTable_add> tbody').empty();
    $('#dataTable_view').DataTable().draw().destroy();
    $('#dataTable_view> tbody').empty();
    if ($('#nav-add-tab').is(':visible')) {
        $('#nav-add-tab').removeClass('active');
        $('#nav-add').removeClass('show active');
        $('#nav-view-tab').attr('hidden', false).addClass('active');
        $('#nav-view').addClass('show active');
        $('#rp').val('');
        $('#des_rp').val('');
        $('#valor_rp').val('');
        $(dataTable.column(3).footer()).html('');
    } else {
        $('#nav_rp').attr('hidden', false);
        $('#nav-add-tab').removeClass('active');
        $('#nav-add').removeClass('show active');
        $('#nav-view-tab').attr('hidden', false).addClass('active');
        $('#nav-view').addClass('show active');
    }
}

var validarParametros = function(arrayData, arrayIdDetalle) {
    var valid = true;
    arrayIdDetalle.forEach(idDetalle => {
        var data = $('#' + idDetalle).val();
        data = (idDetalle == 'valor') ? ($('#div_valor').is(':visible') ? numeral(data).value() :
            numeral($('#valor_rp').val()).value()) : data;
        if (data == null || data == '') {
            swal("IDEAL 10", "Falta información para la nota bancaria", "warning");
            valid = false;
            return;
        } else if (arrayData) {
            idDetalle = (idDetalle == 'fc_1198971545') ? 'fecha' : idDetalle;
            arrayData[idDetalle] = data;
        }
    });
    if (numeral($('#valor_rp').val()).value() > arrayData['valor_rubro']) {
        swal("IDEAL 10", "El valor de la nota es inferior al rubro seleccionado", "warning");
        valid = false;
    }
    return valid;
}

/**@abstract
 * Funcion para visualizar datos de notas bancarias existentes
 */
var visualizarNota = function(data) {
    let dataNotaCab = data[0];
    let dataNotaDet = data['TesoNotasBancariasDet'];
    let dataCompDet = data['ComprobanteDet'];
    let dataNotasPpto = data['PptoNotasBanPpto'];

    //Nota Cab
    let fecha = new Date(dataNotaCab['fecha']);
    $('#fc_1198971545').val(fecha.getDate().zfill(2) + '/' + (fecha.getMonth() + 1).zfill(2) + '/' +
        fecha.getFullYear());
    $('#id_comp').val(dataNotaCab['id_notaban']);
    $('#tipo_mov').attr('disabled', true);
    $('#concepto').val(dataNotaCab['concepto']);
    for (const idx in dataNotaDet) {
        //Nota Det
        $('#num_banco').val(dataNotaDet[idx]['docban']);
        $('#ccosto').val(dataNotaDet[idx]['cc']);
        $('#cuenta_banca').val(dataNotaDet[idx]['ncuentaban']);
        $('#tccuenta_banca').val(dataNotaDet[idx]['tercero']);
        $('#gasto_banca').val(dataNotaDet[idx]['gastoban']);
        let tipo = $('#gasto_banca option:selected').text().split('--')[0];

        if (parameters['active'] == 'S') {
            //Comp Det
            $('#ccuenta_banca').val(dataCompDet[idx]['cuenta']);
            $('#ncuenta_banca').val(dataNotaDet[idx]['TerceroCtaBanca']['razonsocial']);
            $('#gasto_banca').change();

            if (tipo == 'G' && arrayParametrosTeso['notabancariarp'] == 'S') { //Si tesoparametro y Gasto G
                $('#rp').val(dataNotasPpto[idx]['rp']);
                $('#valor_rp').val(numeral(dataNotasPpto[idx]['valor']).format('$0,0'));
                $('#des_rp').val(dataNotasPpto[idx]['cuenta']);
                cargarDatosTabla({}, 'crear');
                $(dataTable.column(3).footer())
                    .html(numeral(dataNotasPpto[idx]['valor']).format('$0,0'));
                agregarDetallesGastosRp();
            } else { //No tesoparametro
                $('#valor').val(numeral(dataNotaDet[idx]['valor']).format('$0,0'));
                agregarDetalles();
            }
        } else if (parameters['active'] == 'R') {
            $('#valor').val(numeral(dataNotaDet['valor']).format('$0,0'));
            $('#fc_1198971545').attr('disabled', true);
            $('#concepto').attr('disabled', true);
            $('#num_banco').attr('disabled', true);
            $('#ccosto').attr('disabled', true);
            $('#cuenta_banca').attr('disabled', true);
            $('#gasto_banca').attr('disabled', true);
            $('#valor').attr('disabled', true);
            $('img[title="Guardar"]').parent().attr('hidden', true);
            $('img[title="Imprimir"]').parent().attr('hidden', true);
        }
    }
    /*

    if (parameters['active'] == 'S') {
        //Comp Det
        $('#ccuenta_banca').val(dataCompDet['cuenta']);
        $('#ncuenta_banca').val(dataTerceroCta['razonsocial']);
        $('#gasto_banca').change();

        if (tipo == 'G' && arrayParametrosTeso['notabancariarp'] == 'S') { //Si tesoparametro y Gasto G
            $('#rp').val(dataNotasPpto['rp']);
            $('#valor_rp').val(numeral(dataNotasPpto['valor']).format('$0,0'));
            $('#des_rp').val(dataNotasPpto['cuenta']);
            cargarDatosTabla({}, 'crear');
            $(dataTable.column(3).footer())
                .html(numeral(dataNotasPpto['valor']).format('$0,0'));
            agregarDetallesGastosRp();
        } else { //No tesoparametro
            $('#valor').val(numeral(dataNotaDet['valor']).format('$0,0'));
            agregarDetalles();
        }
    } else if (parameters['active'] == 'R') {
        $('#valor').val(numeral(dataNotaDet['valor']).format('$0,0'));
        $('#fc_1198971545').attr('disabled', true);
        $('#concepto').attr('disabled', true);
        $('#num_banco').attr('disabled', true);
        $('#ccosto').attr('disabled', true);
        $('#cuenta_banca').attr('disabled', true);
        $('#gasto_banca').attr('disabled', true);
        $('#valor').attr('disabled', true);
        $('img[title="Guardar"]').parent().attr('hidden', true);
        $('img[title="Imprimir"]').parent().attr('hidden', true);
    }*/
}


/**@abstract
 * Despliega ventana emergente de parametros notas bancarias heredada
 */
var despliegamodal2 = function(_valor, _num) {
    document.getElementById("bgventanamodal2").style.visibility = _valor;
    if (_valor == "hidden") {
        document.getElementById('ventana2').src = "";
    } else {
        switch (_num) {
            case '1':
                document.getElementById('ventana2').src =
                    "cuentasbancarias-ventana03.php?tipoc=D&objeto=cuenta_banca&nobjeto=ncuenta_banca&cobjeto=ccuenta_banca&tcobjeto=tccuenta_banca";
                break;
            case '2':
                fecha = new Date();
                document.getElementById('ventana2').src =
                    "registro-ventana04.php?objeto=rp&nobjeto=des_rp&vigencia=2019" //+ fecha.getYear();
                break;
            case '3':
                document.getElementById('ventana2').src =
                    "notasbancarias-ventana.php?iNota=nota_banca&iFecha=fecha";
                break;
        }
    }
}

/**@abstract
 * Función para generar soporte Pdf
 */
var generarPDF = function(element) {
    $("#id_nota").val($('#id_comp').val());
    $("#formPDF").submit();
}
</script>




</html>