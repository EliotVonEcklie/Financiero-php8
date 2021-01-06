<?php 
    require 'comun.inc';
    require 'funciones.inc';
    require_once ('/Controllers/PermisoMovimientoControllers.php');
    require_once ('/controllers/TipoMovimientoControllerTesoController.php');
    require_once ('/controllers/CentroCostoController.php');
    require_once ('/controllers/Mod_Tesoreria/GastoBancarioController.php');
    require_once ('/controllers/Mod_Tesoreria/NotasBancariasController.php');

    $scroll=@$_GET['scrtop'];
	$totreg=@$_GET['totreg'];
	$altura=@$_GET['altura'];
	$filtro="'".@$_GET['filtro']."'";
    $numpag=@$_GET['numpag'];
    $limreg=@$_GET['limreg'];
    $scrtop=26*$totreg;
		
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

    //se instancia la clase que consulta el centro de costo
    $centroDeCosto = new CentroCostoController();
    $centroDeCosto->generarCentroCosto();
    $centroCosto = $centroDeCosto->cc;

    //se instancia la clase Notas Bancarias para generar consecutivo
    $notaBancaria = new NotasBancariasController();
    $dataNotaBancariaCab = $notaBancaria-> buscarNotaBancaria(@$_GET[idr]);
    $arrayFecha = explode("-",$dataNotaBancariaCab[0]["fecha"]);
    @$_POST[fecha]=$arrayFecha[2]."/".$arrayFecha[1]."/".$arrayFecha[0];
    @$_POST[concepto]=$dataNotaBancariaCab[0]["concepto"];
    @$_POST[maximo] = $notaBancaria-> generarConsecutivo();
    @$_POST[minimo] = $notaBancaria-> generarConsecutivoMin();
    
    @$_POST[numeroNota] = @$_GET[idr];

    //se instancia la clase que consulta los gastos bancarios
    $gastoBancario = new GastoBancarioController();
    $gastoBancario->generarGastoBancario();
    $gastoBancos = $gastoBancario->getGastoBancario();
    ?>

<!DOCTYPE html5>
<html lang="es">
<head>
        <meta charset="Utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>:: Notas Bancarias</title>
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
        function despliegamodal2(_valor,_num)
        {
            document.getElementById("bgventanamodal2").style.visibility = _valor;
            if (_valor == "hidden") 
            {
                document.getElementById('ventana2').src = "";
            } 
            else 
            {
                switch (_num) 
                {
                    case '1':
                        document.getElementById('ventana2').src =
                        "cuentasbancarias-ventana03.php?tipoc=D&objeto=cuentaBancaria&nobjeto=nbanco&cobjeto=ccuenta_banca&tcobjeto=tccuenta_banca";
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

        function adelante(scrtop, numpag, limreg, filtro, filas, altura)
        {
            var maximo=document.getElementById('maximo').value;
            var actual=document.getElementById('numeroNota').value;
            if(parseFloat(maximo)>parseFloat(actual))
            {
                var idcta=parseFloat(actual)+1;
                document.location.href = "teso-editarnotasbancarias.php?idr="+idcta+"&scrtop="+scrtop+"&totreg="+filas+"&altura="+altura+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
            }
            else
            {
                swal("IDEAL 10","Esta es la ultima nota bancarias.", "warning","ffff");
            }
        }
    
        function atrasc(scrtop, numpag, limreg, filtro, filas, altura)
        {
            var minimo=document.getElementById('minimo').value;
            var actual=document.getElementById('numeroNota').value;
            if(parseFloat(minimo)<parseFloat(actual))
            {
                var idcta=actual-1;
                document.location.href = "teso-editarnotasbancarias.php?idr="+idcta+"&scrtop="+scrtop+"&totreg="+filas+"&altura="+altura+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
            }
            else
            {
                swal("IDEAL 10","Esta es la primer nota bancarias.", "warning","ffff");
            }
        }
    
        function iratras(scrtop, numpag, limreg, filtro, filas, altura){
            var idcta=document.getElementById('numeroNota').value;
            location.href="teso-buscanotasbancarias.php?idr="+idcta+"&scrtop="+scrtop+"&totreg="+filas+"&altura="+altura+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
        }
        
    </script>
    <body>
        <div class="container-fluid">
            <table>
                <tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
                <tr><?php menu_desplegable("teso");?></tr>
                <tr>
                    <td colspan="3" class="cinta">
                        <a href="teso-notasbancarias.php" accesskey="n" class="mgbt"><img src="imagenes/add.png" title="Nuevo" border="0" /></a>
                        <a href="#" onClick="editarGastoBancario()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" />
                        </a>
                        <a href="teso-buscanotasbancarias.php" class="mgbt">
                            <img src="imagenes/busca.png" title="Buscar" />
                        </a>
                        <a onClick="mypop=window.open('teso-principal.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda"/></a>
                        <a href="#" class="mgbt" onClick="<?php echo paginasnuevas("teso");?>"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
                        <a href="#" onClick="iratras(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $totreg; ?>, <?php echo $altura; ?>)" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s" class="mgbt"></a>
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
                        <h4 class="barra--titulo__h4">Notas Bancarias</h4>
                    </div>
                    <div class="form-group row">
                        <div class="col-2 subtitulos--label__movimiento">
                            <label for="" class="col-form-label label1--movimiento">Tipo de movimiento:</label>
                        </div>

                        <div class="col-3 container--crear__datos">
                            <select name="tipoMovimiento" id="tipoMovimiento" class="form-control" onChange="document.form2.submit();" disabled>
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
                                <label for="" class="col-form-label label1">Num. Comprobante:</label>
                            </div>
                            <div class="col-2 row d-flex justify-content-around">
                                <div class="col-2 containerBotonAtras">
                                    <button type="button" class="btn btn-primary containerBotonAtrasBoton" name="eliminar" id="eliminar" onClick="atrasc(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $totreg; ?>, <?php echo $altura; ?>)"><i class="fas fa-arrow-alt-circle-left"></i></button>
                                </div>
                                <div class="col-6 containerCenter">
                                    <input type="text" name="numeroNota" id="numeroNota" class="form-control input__num1" aria-describedby="basic-addon1" value="<?php echo @$_POST[numeroNota]; ?>" readonly>
                                </div>
                                <div class="col-2 containerBotonAdelante">
                                    <button type="button" class="btn btn-primary" name="eliminar" id="eliminar" onClick="adelante(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $totreg; ?>, <?php echo $altura; ?>)"><i class="fas fa-arrow-alt-circle-right"></i></button>
                                    <input type="hidden" value="<?php echo @$_POST[maximo]?>" name="maximo" id="maximo">
                                    <input type="hidden" value="<?php echo @$_POST[minimo]?>" name="minimo" id="minimo">
                                </div>
                                
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
                            <div class="col-5 container--crear__datos">
                                <input type="text" name="concepto" id="concepto" class="form-control" value="<?php echo @$_POST[concepto]; ?>" placeholder="Objeto de la nota bancaria">
                            </div>
                            <div class="col-2 subtitulos--label">
                                <label for="" class="col-form-label label1">Doc. Banco:</label>
                            </div>
                            <div class="col-2 container--crear__datos">
                                <input type="text" name="docBanco" id="docBanco" class="form-control input-valor" >
                            </div>
                        </div>
                        <div class="container row" >
                            <div class="col-2 subtitulos--label">
                                <label for="" class="col-form-label label1">Cuenta:</label>
                            </div>
                            <div class="col-2 container--crear__datos">
                                <div class="row">
                                    <div class="col-10">
                                        <input type="text" class="form-control" name="cuentaBancaria" id="cuentaBancaria" value="<?php echo @$_POST[cuentaBancaria]; ?>" aria-describedby="basic-addon1" readonly>
                                    </div>
                                    <div class="col-2 container--crear__datos--a" id="buscaCuenta">
                                        <a onClick="despliegamodal2('visible','1');" tittle="Cuenta Bancaria"><img src='imagenes/find02.png' style='width:20px;' /></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-7">
                                <input type="text" name="nbanco" id="nbanco" class="form-control" value="<?php echo @$_POST[nbanco]; ?>" readonly>
                            </div>
                        </div>
                        <div class="container row">
                            <div class="col-2 subtitulos--label">
                                <label for="" class="col-form-label label1">Gasto Bancario:</label>
                            </div>
                            <div class="col-4 container--crear__datos">
                                <select name="gastoBancario" id="gastoBancario" class="form-control">
                                    <option value="-1">Seleccione...</option>
                                    <?php
                                        for($xx = 0; $xx < count($gastoBancos); $xx++)
                                        {
                                            echo "<option value='".$gastoBancos[$xx]['tipo']."-".$gastoBancos[$xx]['codigo']."'>".$gastoBancos[$xx]['tipo']." - ".$gastoBancos[$xx]['codigo']." - ".$gastoBancos[$xx]['nombre']."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-2 subtitulos--label">
                                <label for="" class="col-form-label label1">Valor nota:</label>
                            </div>
                            <div class="col-2 container--crear__datos">
                                <input type="text" id='valor' name='valor' class="form-control input-valor" placeholder="0">
                            </div>
                            <div class="col-2">
                                <button type="button" class="btn btn-primary" name="agregar" id="agregar" onClick="agregarDetalleGastoBancario()">
                                    <i class="fas fa-arrow-circle-down"></i>
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
                </section>
                <div class="bg-white contenedor-tabla rounded overflow-auto" id="divGastosBancarios">
                    <table class="table table-striped table-hover" id="tablaGastosBancarios">
                        <thead class="bg-info">
                            <tr>
                                <th scope="col">Item</th>
                                <th scope="col">Centro Costo</th>
                                <th scope="col">Doc Banco</th>
                                <th scope="col">Banco</th>
                                <th scope="col">Gasto Banco</th>
                                <th scope="col">Valor</th>
                                <th scope="col">Eliminar</th>
                            </tr>
                        </thead>
                        <tbody id="tablaGastosBancariosBody">
                            
                        </tbody>
                    </table>
                </div>
            </form>
            <div id="bgventanamodal2">
                <div id="ventanamodal2">
                    <IFRAME name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0
                        style="left:500px; width:880px; height:480px; top:200;"></IFRAME>
                </div>
            </div>
            <script>
            editarNotasDetalles();
            </script>
    </body>
</html>

