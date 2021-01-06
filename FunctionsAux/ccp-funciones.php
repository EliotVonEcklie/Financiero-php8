<?php
    /**
     * Switch case para seleccionar el proceso el llamado al controlador pertinente
     * Se evalua el valor obtenido de $_POST
     */
    include_once ($_SERVER['DOCUMENT_ROOT'].'/financiero/dirs.php');
    //require_once (CONTROLLERS_PATH.'PptoCuentasController.php');
    require_once (CONTROLLERS_PATH.'CcpetAcuerdosController.php');
    //require_once (CONTROLLERS_PATH.'PptoRPSController.php');

    switch ($_POST['proceso']) {
        case 'PPTOACUERDOS_BUSCAR':
        case 'PPTOACUERDOS_FILTRAR':
            $PptoAcuerdos = new CcpetAcuerdosController();
            $ResultPptoAcuerdos = $PptoAcuerdos->buscarAcuerdos($_POST);
            echo $ResultPptoAcuerdos;
            break;
        case 'PPTOACUERDOS_GUARDAR';
        case 'PPTOACUERDOS_EDITAR':
            $PptoAcuerdos = new CcpetAcuerdosController();
            $ResultPptoAcuerdos = $PptoAcuerdos->guardarAcuerdos($_POST);
            echo $ResultPptoAcuerdos;
            break;
        case 'PPTOACUERDOS_ANULAR':
            $PptoAcuerdos = new CcpetAcuerdosController();
            $ResultPptoAcuerdos = $PptoAcuerdos->anularAcuerdos($_POST);
            echo $ResultPptoAcuerdos;
            break;
        default:break;
    }