<?php

    require_once ('/Controllers/EjemploController.php');

    $ejemploGuardar = new EjemploController();
    //Funcion que consulta a la tabla de permisos con el ususario y nos trae estado "T"
    $ejemploGuardar->ejemploGuardar();