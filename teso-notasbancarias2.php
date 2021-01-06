<?php 
    require 'comun.inc';
    require 'funciones.inc';
    require_once ('/Controllers/PermisoMovimientoControllers.php');
    require_once ('/controllers/TipoMovimientoControllerTesoController.php');
    require_once ('/controllers/OtrosEgresosController.php');
    require_once ('/controllers/CentroCostoController.php');
    require_once ('/controllers/TesoRetencionesController.php');
    require_once ('/controllers/TesoIngresosController.php');

    $mensaje='';
    //Validar si tiene permisos para modificar este documento
    $user=@$_SESSION[cedulausu];
    $permisoUsuario = new PermisoMovimientoControllers(@$user);
    //Funcion que consulta a la tabla de permisos con el ususario y nos trae estado "T"
    $permisoUsuario->getPermisos();
    $tienePermiso = $permisoUsuario->permisos;
    //En caso de no tener permiso llama la funcion que llena la variable mensaje
    if($tienePermiso['estado']=='')
    {
        $permisoUsuario->setMensaje();
        $mensaje = $permisoUsuario->mensaje;
    }
    else
    {
        //se instancia la clase tipo de movimientos
        $tipoMovimientos = new TipoMovimientoControllerTesoController();
        //la funcion inicializar recibe dos parametros uno es codigo y el otro es el modulo
        $tipoMovimientos->obtenerTipoMovimiento('01',3);
        $movimientos = $tipoMovimientos->tipoMov;
    }

    //se instancia la clase otros egresos para generar consecutivo
    $otrosEgresos = new OtrosEgresosController();
    @$_POST[numeroEgreso] = $otrosEgresos->numeroPago;

    //se instancia la clase que consulta el centro de costo
    $centroDeCosto = new CentroCostoController();
    $centroDeCosto->generarCentroCosto();
    $centroCosto = $centroDeCosto->cc;

    //Se instancia la clase que cosulta las retenciones
    $retenciones = new TesoRetencionesController();
    //el parametro que se envia es 1 que valida la columna de terceros
    $valorbusquedaRetenciones = 1;
    $nombrecampoRetenciones = 'terceros';
    $retenciones->generarAllTesoRetenciones($valorbusquedaRetenciones,$nombrecampoRetenciones);
    $retencion = $retenciones->alltesoretenciones;

    //el parametro que se envia es 1 que valida la columna de terceros
    $valorBusquedaIngresos = 1;
    $nombrecampoIngresos = 'terceros';
    //Se intancia la clase que consulta los ingresos
    $ingresos = new TesoIngresosController();
    $ingresos->generarAllTesoIngresos($valorBusquedaIngresos, $nombrecampoIngresos);
    $ingreso = $ingresos->allIngresos;
?>

<!DOCTYPE html5>
<html lang="es">
    <head>
        <meta charset="Utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>:: IDEAL - Notas Bancarias</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <link href="css/tabs.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
        <script src="css/calendario.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
        <script type="text/javascript" src="JQuery/jquery-2.1.4.min.js"></script>
        <script src="javaScript/funciones.js"></script>
        <script src="ajax/funcionesTesoreria.js"></script>
        <script type="text/javascript" src="css/funciones.js"></script>
        <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="bootstrap/css/estilos.css">
        <script type="text/javascript" src="css/sweetalert.js"></script>
		<script type="text/javascript" src="css/sweetalert.min.js"></script>
        <script type="text/javascript" src="bootstrap/fontawesome.5.11.2/js/all.js"></script>
		<link href="css/sweetalert.css" rel="stylesheet" type="text/css" />
        <?php titlepag();?>
    </head>
    <script>
        function despliegamodal2(_valor,scr='')
        {
            var formaPago = document.form2.formaDePago.value;
            if(formaPago=='-1')
            {
                swal("IDEAL","Falta Seleccionar la Forma de Pago.","warning");
            }
            else
            {
                if(scr=='')
                {
                    scr = formaPago;
                }
                if(scr=="1"){
                    var url="cuentasbancarias-ventana02.php?tipoc=D&obj01=banco&obj02=nbanco&obj03=&obj04=cuentaBancaria&obj05=ter";
                }
                if(scr=="2"){
                    var url="cuentasbancarias-ventana02.php?tipoc=C&obj01=banco&obj02=nbanco&obj03=&obj04=cuentaBancaria&obj05=ter";
                }
                if(scr=="3"){
                    var url="tercerosgral-ventana01.php?objeto=tercero&nobjeto=ntercero&nfoco=cc";
                }
                document.getElementById("bgventanamodal2").style.visibility=_valor;
                if(_valor=="hidden")
                {
                    document.getElementById('ventana2').src="";
                }
                else 
                {
                    document.getElementById('ventana2').src=url;
                }
            }
        }
        function funcionmensaje()
        {
            document.location.href = "teso-editanotasbancarias.php?idr="+document.getElementById('idcomp').value;
        }
			
        function respuestaconsulta(pregunta)
        {
            switch(pregunta)
            {
                case "1":
                    document.form2.oculto.value=2;
                    document.form2.submit();
                    break;
            }
        }
    </script>
    <body>
        <div class="container-fluid">
            <table>
                <tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
                <tr><?php menu_desplegable("teso");?></tr>
                <tr>
                    <td colspan="3" class="cinta">
                        <a href="teso-notasbancarias2.php" accesskey="n" class="mgbt"><img src="imagenes/add.png" title="Nuevo" border="0" /></a>
                        <a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a>
                        <a onClick="visualizar()" accesskey="b" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a>
                        <a onClick="mypop=window.open('teso-principal.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
                        <a href="#" class="mgbt" onClick="<?php echo paginasnuevas("teso");?>"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
                    </td>
                </tr>
            </table>
            <div id="bgventanamodalm" class="bgventanamodalm">
                <div id="ventanamodalm" class="ventanamodalm">
                    <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:680px; height:110px; top:200; "> 
                    </IFRAME>
                </div>
            </div>
            <form method="post" name="form2" id="form2">
                
                <section class="movimiento">
                    <div class="barra--titulo">
                        <h4 class="barra--titulo__h4">Otros egresos</h4>
                    </div>
                    <div class="form-group row">
                        <div class="col-2 subtitulos--label__movimiento">
                            <label for="" class="col-form-label label1--movimiento">Tipo de movimiento:</label>
                        </div>

                        <div class="col-3 container--crear__datos">
                            <select name="tipoMovimiento" id="tipoMovimiento" class="form-control" onChange="document.form2.submit();">
                                <?php
                                for($x=0; $x<count($movimientos); $x++)
                                {
                                    $codigoMov = $movimientos[$x]['id'].$movimientos[$x]['codigo'];
                                    if($codigoMov==@$_POST[tipoMovimiento])
                                    {
                                        echo "<option value='".$codigoMov."' SELECTED>".$movimientos[$x]['id']."".$movimientos[$x]['codigo']." - ".$movimientos[$x]['descripcion']."</option>";
                                    }
                                    else
                                    {
                                        echo "<option value='".$codigoMov."'>".$movimientos[$x]['id']."".$movimientos[$x]['codigo']." - ".$movimientos[$x]['descripcion']."</option>";
                                    }
                                }
                                ?>
                            </select>
                        <div>
                    </div>
                </section>

                <section class="container--crear">
                    <div class="form-group">

                        <div class="container row">
                            <div class="col-2 subtitulos--label">
                                <label for="" class="col-form-label label1">Número Egreso:</label>
                            </div>
                            <div class="col-2 container--crear__datos">
                                <input type="text" name="numeroEgreso" id="numeroEgreso" class="form-control input__num" aria-describedby="basic-addon1" value="<?php echo @$_POST[numeroEgreso]; ?>" readonly>
                            </div>
                            <div class="col-1 subtitulos--label subtitulos--label__fecha">
                                <label for="" class="col-form-label label1">Fecha:</label>
                            </div>
                            <div class="col-2 container--crear__datos container row">
                                <div class="col-9">
                                    <input type="text" name="fecha" value="<?php echo @$_POST[fecha]; ?>" class="form-control imput--fecha" aria-describedby="basic-addon1" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" placeholder="DD/MM/YYYY">
                                </div>
                                <div class="col-2 container--crear__datos--a">
                                    <a href="#" onClick="displayCalendarFor('fc_1198971545');" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px;"/></a>
                                </div>
                            </div>
                            <div class="col-2 offset-1 subtitulos--label mover--derecha">
                                <label for="" class="col-form-label label1">Forma de pago:</label>
                            </div>
                            <div class="col-2 container--crear__datos">
                                <select name="formaDePago" id="formaDePago" class="form-control" onChange="formaDePagoSelect();">
                                    <option value="-1">Seleccione...</option>
                                    <option value="1" <?php if(@$_POST[formaDePago]=='1') echo "SELECTED"?>>Transferencia</option>
				  				  	<option value="2" <?php if(@$_POST[formaDePago]=='2') echo "SELECTED"?>>Cheque</option>
                                </select>
                            </div>
                        </div>

                        <div class="container row" >
                            <div class="col-2 subtitulos--label">
                                <label for="" class="col-form-label label1">Cuenta:</label>
                            </div>
                            <div class="col-2 container--crear__datos">
                                <div class="row">
                                    <div class="col-10">
                                        <input type="text" class="form-control" name="cuentaBancaria" id="cuentaBancaria" value="<?php echo @$_POST[cuentaBancaria]; ?>" aria-describedby="basic-addon1" >
                                    </div>
                                    <div class="col-2 container--crear__datos--a">
                                        <a onClick="despliegamodal2('visible');" tittle="Cuenta Bancaria"><img src='imagenes/find02.png' style='width:20px;' /></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <input type="text" name="nbanco" id="nbanco" class="form-control" value="<?php echo @$_POST[nbanco]; ?>" readonly>
                                <input type='hidden' name='banco' id='banco' value='<?php echo @$_POST[banco];?>'/>
                                <input type='hidden' id='ter' name='ter' value='<?php echo @$_POST[ter];?>'/>
                            </div>
                            <div class="col-2 subtitulos--label">
                                <label for="" class="col-form-label label1" id="formaDePagoLabel"><?php echo @$_POST[formaDePagoLabel]; ?></label>
                            </div>
                            <div class="col-2 container--crear__datos">
                                <input type="text" class="form-control" placeholder="0">
                            </div>
                        </div>

                        <div class="container row">
                            <div class="col-2 subtitulos--label">
                                <label for="" class="col-form-label label1">Tercero:</label>
                            </div>
                            <div class="col-2 container--crear__datos">
                                <div class="row">
                                    <div class="col-10">
                                        <input type="text" class="form-control" aria-describedby="basic-addon1"name="tercero" id="tercero" onBlur="bterceros('tercero','ntercero');" value="<?php echo @$_POST[tercero]; ?>">
                                    </div>
                                    <div class="col-2 container--crear__datos--a">
                                        <a onClick="despliegamodal2('visible','3');" tittle="Tercero"><img src='imagenes/find02.png' style='width:20px;' /></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <input type="text" class="form-control" name="ntercero" id="ntercero" value="<?php echo @$_POST[ntercero]; ?>" readonly>
                            </div>
                            <div class="col-2 subtitulos--label">
                                <label for="" class="col-form-label label1">Centro de costo:</label>
                            </div>
                            <div class="col-2 container--crear__datos">
                                <select name="cc" id="cc" class="form-control">
                                    <option value="-1">Seleccione...</option>
                                    <?php
                                        for($xx = 0; $xx < count($centroCosto); $xx++)
                                        {
                                            if($centroCosto[$xx]['id_cc']==@$_POST[cc])
                                            {
                                                echo "<option value='".$centroCosto[$xx]['id_cc']."' SELECTED>".$centroCosto[$xx]['id_cc']." - ".$centroCosto[$xx]['nombre']."</option>";
                                            }
                                            else
                                            {
                                                echo "<option value='".$centroCosto[$xx]['id_cc']."'>".$centroCosto[$xx]['id_cc']." - ".$centroCosto[$xx]['nombre']."</option>";
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="container row">
                            <div class="col-2 subtitulos--label">
                                <label for="" class="col-form-label label1">Concepto:</label>
                            </div>
                            <div class="col-6 container--crear__datos">
                                <input type="text" class="form-control" placeholder="Descripción del egreso">
                            </div>
                            <div class="col-2 subtitulos--label">
                                <label for="" class="col-form-label label1">Valor a pagar:</label>
                            </div>
                            <div class="col-2 container--crear__datos">
                                <input type="text" class="form-control input-valor" placeholder="0" readonly>
                            </div>
                        </div>

                        <div class="container row">
                            <div class="col-2 subtitulos--label">
                                <label for="" class="col-form-label label1">Retenciones e ingresos:</label>
                            </div>
                            <div class="col-4 container--crear__datos">
                                <select name="RetencionIngreso" id="RetencionIngreso" class="form-control">
                                    <option value="-1">Seleccione...</option>
                                    <?php
                                        for($y = 0; $y < count($retencion); $y++)
                                        {
                                            echo "<option value='R-".$retencion[$y]['codigo']." - ".$retencion[$y]['nombre']."'>R - ".$retencion[$y]['codigo']." - ".$retencion[$y]['nombre']."</option>";
                                        }
                                        for($y = 0; $y < count($ingreso); $y++)
                                        {
                                            
                                            echo "<option value='I-".$ingreso[$y]['codigo']." - ".$ingreso[$y]['nombre']."'>I - ".$ingreso[$y]['codigo']." - ".$ingreso[$y]['nombre']."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-2 subtitulos--label">
                                <label for="" class="col-form-label label1">Agregar valor:</label>
                            </div>
                            <div class="col-2 container--crear__datos">
                                <input type="text" id='valor' name='valor' class="form-control input-valor" placeholder="0">
                            </div>
                            <div class="col-2">
                                <button type="button" class="btn btn-primary" name="agregar" id="agregar" onClick="agregarDetalleOtrosEgresos()">
                                    <i class="fas fa-arrow-circle-down"></i>
                                    Agregar
                                 </button>
                            </div>
                        </div>
                    </div>
                </section>
                <div class="bg-white contenedor-tabla rounded">
                    <table class="table table-striped table-hover" id="tablaOtrosEgresos">
                        <thead class="bg-info">
                            <tr>
                                <th scope="col">Item</th>
                                <th scope="col">Retencion / Ingresos</th>
                                <th scope="col">Cuenta Contable</th>
                                <th scope="col">valor</th>
                                <th scope="col">Eliminar</th>
                            </tr>
                        </thead>
                        <tbody class="h-25">
                            
                        </tbody>
                    </table>
                </div>
                <div id="bgventanamodal2">
                    <div id="ventanamodal2">
                        <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:884px; height:480px; top:200;"> 
                        </IFRAME>
                    </div>
                </div>	
            </form>
        </div>
        <script src="/static/js/bootstrap.js"></script>
    </body>
</html>