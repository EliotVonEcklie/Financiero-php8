<?php //IDEAL10 13/01/2020 DD
/**
 * Vista Tesoreria para defición de parametros estandar
 */
require 'comun.inc';
require 'funciones.inc';
sesion();
header("Cache-control: private");
header("Content-Type: text/html;charset=utf8");
date_default_timezone_set("America/Bogota");
?>

<!DOCTYPE html5>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>:: IDEAL10 - Tesoreria</title>

    <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s'); ?>" rel="stylesheet" type="text/css" />
    <link href="css/css3.css?<?php echo date('d_m_Y_h_i_s'); ?>" rel="stylesheet" type="text/css" />
    <link href="css/tabs.css?<?php echo date('d_m_Y_h_i_s'); ?>" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="bootstrap/css/estilos.css">
    <link rel="stylesheet" href="bootstrap/fontawesome.5.11.2/css/all.css">
    <link rel="stylesheet" href="css/sweetalert.css">

    <script type="text/javascript" src="JQuery/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s'); ?>"></script>
    <script type="text/javascript" src="ajax/funcionesTesoreria.js"></script>

    <script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript" src="bootstrap/fontawesome.5.11.2/js/all.js"></script>
    <script type="text/javascript" src="bootstrap/numeral/numeral.min.js"></script>
    <script type="text/javascript" src="bootstrap/numeral/locales.min.js"></script>
    <script type="text/javascript" src="css/sweetalert.js"></script>
    <?php titlepag(); ?>
</head>

<body>
    <div class="container-fluid">
        <table>
            <tr>
                <script>
                barra_imagenes("teso");
                </script><?php cuadro_titulos(); ?>
            </tr>
            <tr><?php menu_desplegable("teso"); ?></tr>
            <tr>
                <td colspan="3" class="cinta">
                    <a href="teso-parametrosteso.php" class="mgbt">
                        <img src="imagenes/add.png" title="Nuevo" />
                    </a>
                    <a href="#" onClick="guardarParametrosTesoreria(arrayIdTeso, arrayParametrosTeso)" class="mgbt">
                        <img src="imagenes/guarda.png" title="Guardar" />
                    </a>
                    <a class="mgbt">
                        <img src="imagenes/buscad.png" title="Buscar" />
                    </a>
                    <a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img
                            src="imagenes/agenda1.png" title="Agenda" />
                    </a>
                    <a href="#" class="mgbt" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();"><img
                            src="imagenes/nv.png" title="Nueva Ventana">
                    </a>
                </td>
            </tr>
        </table>
        <section class="section-header-gb">
            <div class="card">
                <nav class="nav nav-fill m-1">
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link btn-primary text-white active" id="nav-teso-tab" data-toggle="tab"
                            href="#nav-teso" role="tab" aria-controls="nav-teso" aria-selected="true">Tesoreria</a>
                        <a class="nav-item nav-link btn-primary text-white" id="nav-pre-tab" data-toggle="tab"
                            href="#nav-pre" role="tab" aria-controls="nav-pre" aria-selected="false">Predial</a>
                        <a class="nav-item nav-link btn-primary text-white" id="nav-ica-tab" data-toggle="tab"
                            href="#nav-ica" role="tab" aria-controls="nav-ica" aria-selected="false">Industria y
                            Comercio</a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-teso" role="tabpanel" aria-labelledby="nav-teso-tab">
                        <div class="card">
                            <div class="row my-1 mx-1 titulo-gb">
                                <div class="col-md-10 col-sm-10 col-10 pt-1">
                                    <span class="pl-1 text-white">.: Parametrización Tesoreria</span>
                                </div>
                            </div>
                            <div class="form m-1">
                                <div class="form-inline mb-2">
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <label class="etiqueta-gb py-1">Tesorero</label>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-3 px-1">
                                        <div class="input-group">
                                            <input class="form-control" type="text" id="cc_terorero" name="cc_terorero">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary"
                                                    onClick="despliegamodal2('visible','1');">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 -col-sm-3 col-3 px-1">
                                        <input class="form-control w-100" type="text" id="nombreteso" name="nombreteso"
                                            disabled>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <label class="etiqueta-gb py-1">Contabiliza Retenciones</label>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <select class="form-control w-100" id="conta_pago" name="conta_pago">
                                            <option value="">Seleccione ...</option>
                                            <option value="1">Cuentas por pagar</option>
                                            <option value="2">Egresos</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-inline mb-2">
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <label class="etiqueta-gb py-1">Cuenta Traslado Bancarios</label>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-3 px-1">
                                        <div class="input-group">
                                            <input class="form-control" type="text" id="cuentatraslado"
                                                name="cuentatraslado">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary"
                                                    onClick="despliegamodal2('visible','2');">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 -col-sm-3 col-3 px-1">
                                        <input class="form-control w-100" type="text" id="ncuentatraslado"
                                            name="ncuentatraslado" disabled>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <label class="etiqueta-gb py-1">Tarifa Minima Industria</label>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <input class="form-control w-100" type="text" id="tmindustria"
                                            name="tmindustria">
                                    </div>
                                </div>
                                <div class="form-inline mb-2">
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <label class="etiqueta-gb py-1">Cuenta a Miles</label>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-3 px-1">
                                        <div class="input-group">
                                            <input class="form-control" type="text" id="cuentamil" name="cuentamil">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary"
                                                    onClick="despliegamodal2('visible','3');">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 -col-sm-3 col-3 px-1">
                                        <input class="form-control w-100" type="text" id="ncuentamil" name="ncuentamil"
                                            disabled>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <label class="etiqueta-gb py-1">Nota Bancaria con Rp</label>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <select class="form-control w-100" id="notabancariarp" name="notabancariarp">
                                            <option value="">Seleccione ...</option>
                                            <option value="S">Aplicar (S)</option>
                                            <option value="N">No Aplicar (N)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-inline mb-2">
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <label class="etiqueta-gb py-1">Cuenta Caja</label>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-3 px-1">
                                        <div class="input-group">
                                            <input class="form-control" type="text" id="cuentacaja" name="cuentacaja">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary"
                                                    onClick="despliegamodal2('visible','4');">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 -col-sm-3 col-3 px-1">
                                        <input class="form-control w-100" type="text" id="ncuentacaja"
                                            name="ncuentacaja" disabled>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <label class="etiqueta-gb py-1">Imprimir Beneficiario</label>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <select class="form-control w-100" id="impbeneficiario" name="impbeneficiario">
                                            <option value="">Seleccione ...</option>
                                            <option value="S">Imprimir (S)</option>
                                            <option value="N">No Imprimir (N)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-inline mb-2">
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <label class="etiqueta-gb py-1">Cuenta Caja Menor</label>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-3 px-1">
                                        <div class="input-group">
                                            <input class="form-control" type="text" id="cuentacajamenor"
                                                name="cuentacajamenor">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary"
                                                    onClick="despliegamodal2('visible','5');">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 -col-sm-3 col-3 px-1">
                                        <input class="form-control w-100" type="text" id="ncuentacajamenor"
                                            name="ncuentacajamenor" disabled>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <label class="etiqueta-gb py-1">Imprimir Tesorero</label>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <select class="form-control w-100" id="imptesorero" name="imptesorero">
                                            <option value="">Seleccione ...</option>
                                            <option value="S">Imprimir (S)</option>
                                            <option value="N">No Imprimir (N)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-inline mb-2">
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <label class="etiqueta-gb py-1">Cuenta Puente</label>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-3 px-1">
                                        <div class="input-group">
                                            <input class="form-control" type="text" id="cuentapuente"
                                                name="cuentapuente">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary"
                                                    onClick="despliegamodal2('visible','6');">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 -col-sm-3 col-3 px-1">
                                        <input class="form-control w-100" type="text" id="ncuentapuente"
                                            name="ncuentapuente" disabled>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <label class="etiqueta-gb py-1">Imprimir Alcalde</label>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <select class="form-control w-100" id="impalcalde" name="impalcalde">
                                            <option value="">Seleccione ...</option>
                                            <option value="S">Imprimir (S)</option>
                                            <option value="N">No Imprimir (N)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-pre" role="tabpanel" aria-labelledby="nav-pre-tab">
                        <div class="card">
                            <div class="row my-1 mx-1 titulo-gb">
                                <div class="col-md-10 col-sm-10 col-10 pt-1">
                                    <span class="pl-1 text-white">.: Parametrización Predial</span>
                                </div>
                            </div>
                            <div class="form m-1">
                                <div class="form-inline mb-2">
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <label class="etiqueta-gb py-1">Ingreso Recibo de Caja</label>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-6 px-1">
                                        <select class="form-control w-100" id="ingresos" name="ingresos"></select>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <label class="etiqueta-gb py-1">Aplicar Cobro Recibo Caja Fijo</label>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <select class="form-control w-100" id="cobrorecibo" name="cobrorecibo">
                                            <option value="">Seleccione ...</option>
                                            <option value="S">Aplicar (S)</option>
                                            <option value="N">No Aplicar (N)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-inline mb-2">
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <label class="etiqueta-gb py-1">Aplicar Norma Predial</label>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <select class="form-control w-100" id="aplicapredial" name="aplicapredial">
                                            <option value="">Seleccione ...</option>
                                            <option value="S">Aplicar (S)</option>
                                            <option value="N">No Aplicar (N)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <label class="etiqueta-gb py-1">Interes Predial</label>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <select class="form-control w-100" id="interespredial" name="interespredial">
                                            <option value="">Seleccione ...</option>
                                            <option value="inicioanio">Inicio año</option>
                                            <option value="finalincentivo">Final de descuento incentivo</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <label class="etiqueta-gb py-1">Descuento en Vigencias Ant.</label>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <select class="form-control w-100" id="descuento_deuda" name="descuento_deuda">
                                            <option value="">Seleccione ...</option>
                                            <option value="S">Aplicar (S)</option>
                                            <option value="N">No Aplicar (N)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-inline mb-2">
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <label class="etiqueta-gb py-1">Base Sobretasa Bomberil</label>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <select class="form-control w-100" id="basepredial" name="basepredial">
                                            <option value="">Seleccione ...</option>
                                            <option value="1">Base Avaluo Predio</option>
                                            <option value="2">Base Predial</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <label class="etiqueta-gb py-1">Base Sobretasa Ambiental</label>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <select class="form-control w-100" id="basepredialamb" name="basepredialamb">
                                            <option value="">Seleccione ...</option>
                                            <option value="1">Base Avaluo Predio</option>
                                            <option value="2">Base Predial</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <label class="etiqueta-gb py-1">Cobrar Impuesto Bomberil</label>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <select class="form-control w-100" id="bomberil" name="bomberil">
                                            <option value="">Seleccione ...</option>
                                            <option value="S">Aplicar (S)</option>
                                            <option value="N">No Aplicar (N)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-inline mb-2">
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <label class="etiqueta-gb py-1">Aplicar Desc Intereses</label>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <select class="form-control w-100" id="aplicadescint" name="aplicadescint">
                                            <option value="">Seleccione ...</option>
                                            <option value="S">Aplicar (S)</option>
                                            <option value="N">No Aplicar (N)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <label class="etiqueta-gb py-1">Vigencia Max Desc Intereses</label>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <input class="form-control w-100" type="text" id="vigmaxdescint"
                                            name="vigmaxdescint">
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <label class="etiqueta-gb py-1">% Desc Intereses</label>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <input class="form-control w-100" type="text" id="porcdescint"
                                            name="porcdescint">
                                    </div>
                                </div>
                                <div class="form-inline mb-2">
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <label class="etiqueta-gb py-1">Años Prescripción Predial</label>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <input class="form-control w-100" type="text" id="age_prespred"
                                            name="age_prespred">
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <label class="etiqueta-gb py-1">Valor Recibo de Caja</label>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <input class="form-control w-100" type="text" id="recibovalor"
                                            name="recibovalor">
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <label class="etiqueta-gb py-1">Ingreso Alumbrado</label>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <select class="form-control w-100" id="ingresos_alumbrado"
                                            name="ingresos_alumbrado">
                                            <option value="">Seleccione ...</option>
                                            <option value="S">Aplicar (S)</option>
                                            <option value="N">No Aplicar (N)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-inline">
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <label class="etiqueta-gb py-1">Cobro Alumbrado Publico</label>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <select class="form-control w-100" id="cobro_alumbrado" name="cobro_alumbrado">
                                            <option value="">Seleccione ...</option>
                                            <option value="S">Aplicar (S)</option>
                                            <option value="N">No Aplicar (N)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <label class="etiqueta-gb py-1">Valor Cobro Alumbrado Publico</label>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <input class="form-control w-100" type="text" id="valor_alumbrado"
                                            name="valor_alumbrado">
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <label>Valor por mil sobre el avaluo</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card m-2">
                            <div class="card-header py-0 my-1 mx-1 titulo-gb">
                                <span class="pl-1 text-white">Descuentos Predial</span>
                            </div>
                            <div class="form-inline mb-2">
                                <div class="col-md-2 col-sm-2 col-2 px-1">
                                    <label class="etiqueta-gb py-1">Capital predial</label>
                                </div>
                                <div class="col-md-2 col-sm-2 col-2 px-1">
                                    <select class="form-control w-100" id="descuentoPredial" name="descuentoPredial">
                                        <option value="">Seleccione ...</option>
                                        <option value="S">Aplica Descuento (S)</option>
                                        <option value="N">Sin Descuento (N)</option>
                                    </select>
                                </div>
                                <div class="col-md-2 col-sm-2 col-2 px-1">
                                    <label class="etiqueta-gb py-1">Bomberil</label>
                                </div>
                                <div class="col-md-2 col-sm-2 col-2 px-1">
                                    <select class="form-control w-100" id="descuentoBomberil" name="descuentoBomberil">
                                        <option value="">Seleccione ...</option>
                                        <option value="S">Aplica Descuento (S)</option>
                                        <option value="N">Sin Descuento (N)</option>
                                    </select>
                                </div>
                                <div class="col-md-2 col-sm-2 col-2 px-1">
                                    <label class="etiqueta-gb py-1">Ambiental</label>
                                </div>
                                <div class="col-md-2 col-sm-2 col-2 px-1">
                                    <select class="form-control w-100" id="descuentoAmbiental" name="descuentoAmbiental">
                                        <option value="">Seleccione ...</option>
                                        <option value="S">Aplica Descuento (S)</option>
                                        <option value="N">Sin Descuento (N)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade " id="nav-ica" role="tabpanel" aria-labelledby="nav-ica-tab">
                        <div class="card">
                            <div class="row my-1 mx-1 titulo-gb">
                                <div class="col-md-10 col-sm-10 col-10 pt-1">
                                    <span class="pl-1 text-white">.: Parametrización Industria y Comercio</span>
                                </div>
                            </div>
                            <div class="card m-2">
                                <div class="card-header py-0 my-1 mx-1 titulo-gb">
                                    <span class="pl-1 text-white">Descuentos</span>
                                </div>
                                <div class="form-inline mb-2">
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <label class="etiqueta-gb py-1">Industria y Comercio</label>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <select class="form-control w-100" id="desindustria" name="desindustria">
                                            <option value="">Seleccione ...</option>
                                            <option value="S">Aplica Descuento (S)</option>
                                            <option value="N">Sin Descuento (N)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <label class="etiqueta-gb py-1">Avisos y Tablero</label>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <select class="form-control w-100" id="desavisos" name="desavisos">
                                            <option value="">Seleccione ...</option>
                                            <option value="S">Aplica Descuento (S)</option>
                                            <option value="N">Sin Descuento (N)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <label class="etiqueta-gb py-1">Bomberil</label>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <select class="form-control w-100" id="desbomberil" name="desbomberil">
                                            <option value="">Seleccione ...</option>
                                            <option value="S">Aplica Descuento (S)</option>
                                            <option value="N">Sin Descuento (N)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card m-2">
                                <div class="card-header py-0 my-1 mx-1 titulo-gb">
                                    <span class="pl-1 text-white">Intereses Mora</span>
                                </div>
                                <div class="form-inline mb-2">
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <label class="etiqueta-gb py-1">Industria y Comercio</label>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <select class="form-control w-100" id="intindustria" name="intindustria">
                                            <option value="">Seleccione ...</option>
                                            <option value="S">Aplica Interes (S)</option>
                                            <option value="N">Sin Interes (N)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <label class="etiqueta-gb py-1">Avisos y Tablero</label>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <select class="form-control w-100" id="intavisos" name="intavisos">
                                            <option value="">Seleccione ...</option>
                                            <option value="S">Aplica Interes (S)</option>
                                            <option value="N">Sin Interes (N)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <label class="etiqueta-gb py-1">Bomberil</label>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-2 px-1">
                                        <select class="form-control w-100" id="intbomberil" name="intbomberil">
                                            <option value="">Seleccione ...</option>
                                            <option value="S">Aplica Interes (S)</option>
                                            <option value="N">Sin Interes (N)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </section>
    </div>
    <div id="bgventanamodal2">
        <div id="ventanamodal2">
            <IFRAME name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0
                style="left:500px; width:880px; height:480px; top:200;"></IFRAME>
        </div>
    </div>
</body>
<script type="text/javascript">
var arrayIdTeso = [
    'cc_terorero',
    'age_prespred',
    'nombreteso',
    'cuentatraslado',
    'tmindustria',
    'bomberil',
    'impbeneficiario',
    'interespredial',
    'cuentacaja',
    'conta_pago',
    'imptesorero',
    'impalcalde',
    'cuotas',
    'descuentoPredial',
    'descuentoBomberil',
    'descuentoAmbiental',
    'desindustria',
    'desavisos',
    'desbomberil',
    'intindustria',
    'intavisos',
    'intbomberil',
    'cuentapuente',
    'cuentacajamenor',
    'notabancariarp'
];
var arrayParametrosTeso = ['TESOINGRESOS', 'BASE_PREDIAL', 'BASE_PREDIALAMB', 'NORMA_PREDIAL', 'COBRO_RECIBOS',
    'CUENTA_MILES', 'DESC_INTERESES', 'CUENTA_TRASLADO', 'DESCUENTO_CON_DEUDA', 'COBRO_ALUMBRADO', 'TESOPARAMETROS'
];
var cuentas = ['cuentatraslado', 'cuentamil', 'cuentacaja', 'cuentacajamenor', 'cuentapuente'];
/**@abstract
 * Función de carga automatica
 * Carga de parametros de tesoreria
 */
$(document).ready(function() {
    numeral.locale('es');
    buscarParametrosTesoreria(arrayParametrosTeso, llenarParametros);
    $('#tmindustria').on('keyup', function(element) {
        this.value = numeral(this.value).format('$0,0');
    });
});

/**@abstract
 * Función para llenar parametros tesoreria
 */
var llenarParametros = function(datos) {
    if (Object.entries(datos).length !== 0) {
        for (const parametro in datos) {
            if (datos[parametro])
                switch (parametro) {
                    case 'TESOPARAMETROS':
                        for (let i = 0; i < arrayIdTeso.length; i++)
                            $('#' + arrayIdTeso[i]).val(datos[parametro][arrayIdTeso[i]]);
                        break;
                    case 'TESOINGRESOS':
                        var ingresos = datos[parametro];
                        for (let i = 0; i < ingresos.length; i++) {
                            let $option = $('<option />', {
                                text: ingresos[i]['codigo'].zfill(2) + ' - ' + ingresos[i]['nombre'],
                                value: ingresos[i]['codigo'].zfill(2)
                            });
                            $('#ingresos').append($option);
                        }
                        $('#ingresos').prepend($('<option />', {
                            text: 'Seleccione',
                            value: 0,
                            selected: true
                        }));
                    case 'BASE_PREDIAL':
                        $('#basepredial').val(datos[parametro]['valor_inicial']);
                        break
                    case 'BASE_PREDIALAMB':
                        $('#basepredialamb').val(datos[parametro]['valor_inicial']);
                        break;
                    case 'COBRO_RECIBOS':
                        $('#ingresos').val(datos[parametro]['valor_inicial']);
                        $('#recibovalor').val(datos[parametro]['valor_final']);
                        $('#cobrorecibo').val(datos[parametro]['tipo']);
                        break;
                    case 'CUENTA_MILES':
                        $('#cuentamil').val(datos[parametro]['valor_inicial']);
                        break;
                    case 'DESC_INTERESES':
                        $('#vigmaxdescint').val(datos[parametro]['valor_inicial']);
                        $('#porcdescint').val(datos[parametro]['valor_final']);
                        $('#aplicadescint').val(datos[parametro]['tipo']);
                        break;
                    case 'NORMA_PREDIAL':
                        $('#aplicapredial').val(datos[parametro]['valor_inicial']);
                        break;
                    case 'DESCUENTO_CON_DEUDA':
                        $('#descuento_deuda').val(datos[parametro]['valor_inicial']);
                        break;
                    case 'COBRO_ALUMBRADO':
                        $('#ingresos_alumbrado').val(datos[parametro]['valor_inicial']);
                        $('#valor_alumbrado').val(datos[parametro]['valor_final']);
                        $('#cobro_alumbrado').val(datos[parametro]['tipo']);
                        break;
                }
        }
        var cuentas_parametros = [];
        for (const cuenta of cuentas)
            cuentas_parametros[cuenta] = $('#' + cuenta).val();
        buscarCuentasTesoreria(cuentas_parametros, llenarCuentasParametros);
    }
}

/**@abstract
 * Función para llenar cuentas parametros tesoreria
 */
var llenarCuentasParametros = function(datos) {
    if (Object.entries(datos).length !== 0) {
        for (const cuenta of cuentas)
            if (datos[cuenta])
                $('#n' + cuenta).val(datos[cuenta]['nombre']);
    }
}

/**@abstract
 * Despliega ventana emergente de parametros teso heredada
 */
var despliegamodal2 = function(_valor, _num) {
    document.getElementById("bgventanamodal2").style.visibility = _valor;
    if (_valor == "hidden") {
        document.getElementById('ventana2').src = "";
    } else {
        switch (_num) {
            case '1':
                document.getElementById('ventana2').src =
                    "tercerosgral-ventana01.php?objeto=cc_terorero&nobjeto=nombreteso";
                break;
            case '2':
                document.getElementById('ventana2').src =
                    "cuentasgral-ventana02.php?objeto=cuentatraslado&nobjeto=ncuentatraslado";
                break;
            case '3':
                document.getElementById('ventana2').src =
                    "cuentasgral-ventana02.php?objeto=cuentamil&nobjeto=ncuentamil";
                break;
            case '4':
                document.getElementById('ventana2').src =
                    "cuentasgral-ventana02.php?objeto=cuentacaja&nobjeto=ncuentacaja";
                break;
            case '5':
                document.getElementById('ventana2').src =
                    "cuentasgral-ventana02.php?objeto=cuentacajamenor&nobjeto=ncuentacajamenor";
                break;
            case '6':
                document.getElementById('ventana2').src =
                    "cuentasgral-ventana02.php?objeto=cuentapuente&nobjeto=ncuentapuente";
                break;
        }
    }
}
</script>

</html>