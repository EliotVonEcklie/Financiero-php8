<?php //IDEAL10 10/12/19 DD
	header("Cache-control: private");
	header("Content-Type: text/html;charset=utf8");
	date_default_timezone_set("America/Bogota");
	require 'comun.inc';
	require 'funciones.inc';
	sesion();
	ini_set('display_errors', 1);

	$_POST['fecha']=date("d/m/Y");
	$_POST['vigencia']=vigencia_usuarios($_SESSION['cedulausu']);
	$_POST['valor_adicion']=0;
	$_POST['valor_reduccion']=0;
	$_POST['valor_traslado']=0;
	$_POST['valor_inicial']=0;
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
    <script type="text/javascript" src="ajax/funcionesCcpet.js"></script>

    <script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript" src="bootstrap/fontawesome.5.11.2/js/all.js"></script>
    <script type="text/javascript" src="css/sweetalert.js"></script>
    <?php titlepag();?>
</head>

<body>
    <div class="container-fluid">
        <table>
            <tr>
                <script>
                barra_imagenes("ccpet");
                </script><?php cuadro_titulos();?>
            </tr>
            <tr><?php menu_desplegable("ccpet");?></tr>
            <tr>
                <td colspan="3" class="cinta">
                    <a href="ccp-acuerdos.php" class="mgbt">
                        <img src="imagenes/add.png" title="Nuevo" />
                    </a>
                    <a href="#" onClick="guardarAcuerdos()" class="mgbt" id="btn_guardar">
                        <img src="imagenes/guarda.png" title="Guardar" />
                    </a>
                    <a href="ccp-buscaracuerdos.php" class="mgbt">
                        <img src="imagenes/busca.png" title="Buscar" />
                    </a>
                    <a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img
                            src="imagenes/agenda1.png" title="Agenda" />
                    </a>
                    <a href="#" class="mgbt"
                        onClick="mypop=window.open('ccp-principal.php','','');mypop.focus();"><img
                            src="imagenes/nv.png" title="Nueva Ventana">
                    </a>
                    <a href="ccp-buscaracuerdos.php" class="mgbt" id="btn_atras" hidden>
                        <img src="imagenes/iratras.png" title="Atr&aacute;s">
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
                        <span class="pl-1 text-white">.: Agregar Acto Administrativo</span>
                    </div>
                    <div class="col-md-2 col-sm-2 col-2 text-right p-0">
                        <a href="ccp-principal.php">
                            <button type="button" class="btn btn-sm btn-outline-light font-weight-bolder">
                                <i class="fas fa-times-circle"></i>
                                <span class="ml-1">Cerrar</span>
                            </button>
                        </a>
                    </div>
                </div>
                <form class="mb-1" onsubmit="return false;">
                    <div class="form-inline mb-2">
                        <div class="col-md-1 col-sm-1 col-1 px-1">
                            <label class="etiqueta-gb py-1">Fecha:</label>
                        </div>
                        <div class="col-md-3 col-sm-3 col-2 px-0">
                            <input type="text" name="fecha" value="<?php echo @$_POST['fecha']; ?>"
                                class="form-control imput--fecha" aria-describedby="basic-addon1"
                                onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"
                                id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY"
                                placeholder="DD/MM/YYYY">
                            <a href="#" onClick="displayCalendarFor('fc_1198971545');" title="Calendario"><img
                                    src="imagenes/calendario04.png" style="width:20px;" /></a>
                        </div>
                        <div class="col-md-1 col-sm-1 col-1 px-1">
                            <label class="etiqueta-gb py-1">Tipo acto:</label>
                        </div>
                        <div class="col-md-2 col-sm-2 col-2 px-1">
                            <select class="form-control w-100" id="tipo_acto_adm">
                                <option value="0" <?php if(@$_POST['tipo_acto_adm']=="0"){echo "selected"; }?>>
                                    Seleccione</option>
                                <option value="1" <?php if(@$_POST['tipo_acto_adm']=="1"){echo "selected"; }?>>Por
                                    acuerdo</option>
                                <option value="2" <?php if(@$_POST['tipo_acto_adm']=="2"){echo "selected"; }?>>Por
                                    resolución</option>
                                <option value="3" <?php if(@$_POST['tipo_acto_adm']=="3"){echo "selected"; }?>>Por
                                    decreto</option>
                            </select>
                        </div>
                        <div class="col-md-1 col-sm-1 col-1 px-1">
                            <label class="etiqueta-gb py-1">Número:</label>
                        </div>
                        <div class="col-md-2 col-sm-2 col-2 px-0">
                            <input class="form-control w-100" type="text" id="numero"
                                value="<?php echo @$_POST['numero']?>">
                        </div>
                    </div>
                    <div class="form-inline mb-1">
                        <div class="col-md-1 col-sm-1 col-1 px-1">
                            <label class="etiqueta-gb py-1">Acto Adtvo:</label>
                        </div>
                        <div class="col-md-6 col-sm-6 col-6 px-0">
                            <input class="form-control w-100" type="text" id="acuerdo"
                                value="<?php echo @$_POST['acuerdo']?>">
                        </div>
                        <div class="col-md-1 col-sm-1 col-1 px-1">
                            <label class="etiqueta-gb py-1">Tipo acuerdo:</label>
                        </div>
                        <div class="col-md-2 col-sm-2 col-2 px-0">
                            <select class="form-control w-100" id="tipo_acuerdo">
                                <option value="I" <?php if(@$_POST['tipo_acuerdo']=="I"){echo "selected"; }?>>Inicial
                                </option>
                                <option value="M" <?php if(@$_POST['tipo_acuerdo']=="M"){echo "selected"; }?>>
                                    Modificación</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-inline mb-1" id="form_ini">
                        <div class="col-md-1 col-sm-1 col-1 px-1">
                            <label class="etiqueta-gb py-1">Vlr inicial:</label>
                        </div>
                        <div class="col-md-3 col-sm-3 col-3 px-0">
                            <input class="form-control" type="text" id="valor_inicial"
                                value="<?php echo $_POST['valor_inicial']?>"
                                onKeyPress="javascript:return solonumeros(event)">
                        </div>
                        <div class="col-md-2 col-xs-2 col-2">
                            <button class="btn btn-primary w-100" id="btn_guardar" onClick="guardarAcuerdos()">
                                <i class="fas fa-save"></i>
                                Guardar
                            </button>
                        </div>
                    </div>
                    <div class="form-inline mb-1" id="form_mod" hidden>
                        <div class="col-md-1 col-sm-1 col-1 px-1">
                            <label class="etiqueta-gb py-1">Vlr adición:</label>
                        </div>
                        <div class="col-md-3 col-sm-3 col-3 px-0">
                            <input class="form-control" type="text" id="valor_adicion"
                                value="<?php echo $_POST['valor_adicion']?>"
                                onKeyPress="javascript:return solonumeros(event)">
                        </div>
                        <div class="col-md-1 col-sm-1 col-1 px-1">
                            <label class="etiqueta-gb py-1">Vlr reducción:</label>
                        </div>
                        <div class="col-md-2 col-sm-2 col-2 px-0">
                            <input class="form-control" type="text" id="valor_reduccion"
                                value="<?php echo $_POST['valor_reduccion']?>"
                                onKeyPress="javascript:return solonumeros(event)">
                        </div>
                        <div class="col-md-1 col-sm-1 col-1 px-1">
                            <label class="etiqueta-gb py-1">Vlr traslados:</label>
                        </div>
                        <div class="col-md-2 col-sm-2 col-2 px-0">
                            <input class="form-control" type="text" id="valor_traslado"
                                value="<?php echo $_POST['valor_traslado']?>"
                                onKeyPress="javascript:return solonumeros(event)">
                        </div>
                        <div class="col-md-2 col-xs-2 col-2">
                            <button class="btn btn-primary w-100" id="btn_guardar" onClick="guardarAcuerdos()">
                                <i class="fas fa-save"></i>
                                Guardar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
</body>
<script type="text/javaScript">
    $(function() {
	var parameters = getParameters();
    if (parameters['type'] == 'edit' || parameters['type'] == 'view') {
        buscarAcuerdos({
			consecutivo: -1,
            id_acuerdo: parameters['id'],
            tipo_acto: parameters['type_act'],
            fecha: parameters['date'],
        }, llenarFormulario);
    }

	$('#numero').blur(validaAcuerdo);
	$('#fc_1198971545').blur(validaAcuerdo);
	$('#tipo_acto_adm').change(validaAcuerdo);
    $('#tipo_acuerdo').change(function() {
        changeTipoAcuerdo(this);
    });
});

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

var validaAcuerdo = function(element){
	buscarAcuerdos({
            consecutivo: $('#numero').val(),
            tipo_acto: $('#tipo_acto_adm').val(),
            fecha: $("#fc_1198971545").val().split('/')[2]
        }, function(datos){
			if(datos.length == 1)
			$('#numero').val('');
		});
}

var changeTipoAcuerdo = function(element) {
    if ($(element).val() == 'I') {
        $('#form_ini').attr('hidden', false);
        $('#form_mod').attr('hidden', true);
    } else if ($(element).val() == 'M') {
        $('#form_ini').attr('hidden', true);
        $('#form_mod').attr('hidden', false);
    }
}

var llenarFormulario = function(datos) {
    var acto_adm = datos[0];
	var fecha = acto_adm['fecha'].split('-');

	$("#numero").attr('disabled',true);
	$("[id='btn_atras']").attr('hidden',false);

	$("#fc_1198971545").val(fecha[2] + "/" + fecha[1] + "/" + fecha[0]);
	$("#tipo_acto_adm").val(acto_adm['tipo_acto_adm']);
	$("#numero").val(acto_adm['consecutivo']);
	$("#acuerdo").val(acto_adm['numero_acuerdo']);

	if(type_get == 'view'){
		$("[id='btn_guardar']").attr('hidden',true);
		$("#fc_1198971545").attr('disabled',true);
		$("#tipo_acto_adm").attr('disabled',true);
		$("#acuerdo").attr('disabled',true);
		$("#tipo_acuerdo").attr('disabled',true);
		$("#valor_inicial").attr('disabled',true);
		$("#valor_adicion").attr('disabled',true);
		$("#valor_reduccion").attr('disabled',true);
		$("#valor_traslado").attr('disabled',true);
	} else if(type_get == 'edit')
		$("#tipo_acto_adm").attr('disabled', $("#tipo_acto_adm").val() != '0'? true: false);

    switch (acto_adm['tipo']) {
        case 'I':
            $("#tipo_acuerdo").val(acto_adm['tipo']);
            $("#valor_inicial").val(acto_adm['valorinicial']);
            break;
        case 'M':
            $("#tipo_acuerdo").val(acto_adm['tipo']);
            $("#valor_adicion").val(acto_adm['valoradicion']);
            $("#valor_reduccion").val(acto_adm['valorreduccion']);
            $("#valor_traslado").val(acto_adm['valortraslado']);
            break;
    }
    changeTipoAcuerdo($("#tipo_acuerdo"));
}
<?php $type = @$_GET['type']; $id = @$_GET['id'];?>
var type_get = '<?php echo $type; ?>';
var id_get = '<?php echo $id; ?>';
</script>

</html>