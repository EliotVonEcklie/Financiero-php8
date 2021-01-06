<?php
require_once ('/../Models/Ejemplo.php');
require_once ('/../Models/Ejemplo2.php');
require_once ('/../Models/transaccion.php');
require_once ('/../conexion.php');

class EjemploController
{
    public function __construct(){}

    public function ejemploGuardar()
    {
        // Open a try/catch block
        try 
        {
            // Begin a transaction
            Transaccion::beginTransaction();
            
            $guardaEjemplo = new Ejemplo();
            $guardaEjemplo -> id = 1;
            $guardaEjemplo -> nombre = "Ricardo";
            $ejem = $guardaEjemplo -> save();

            $guardaEjemplo2 = new Ejemplo2();
            $guardaEjemplo2 -> id = 1;
            $guardaEjemplo2 -> texto = "Ricardo";
            $ejem2 = $guardaEjemplo2 -> save();

            $guardaEjemplo2 = new Ejemplo2();
            $guardaEjemplo2 -> id = 2;
            $guardaEjemplo2 -> texto1 = "Ricardo";
            $ejem3 = $guardaEjemplo2 -> save();
            // Do something and save to the db...

            // Commit the transaction
            var_dump("holaa");
            Transaccion::commit();
            if($ejem3)
            {
                echo "entro al if";
            }
        }
        catch (\Exception $e) 
        {
            // An error occured; cancel the transaction...
            Transaccion::rollback();
            var_dump('roll');
            // and throw the error again.
            throw $e;
        }
    }

    public function ejemploGuardar2()
    {
        $guardaEjemplo = new Ejemplo();
        $guardaEjemplo -> id = 1;
        $guardaEjemplo -> nombre = "Ricardo";
        $guardaEjemplo -> save();

        $guardaEjemplo2 = new Ejemplo2();
        $guardaEjemplo2 -> id = 1;
        $guardaEjemplo2 -> texto = "Ricardo";
        $guardaEjemplo2 -> save();

        $guardaEjemplo2 = new Ejemplo2();
        $guardaEjemplo2 -> id = 1;
        $guardaEjemplo2 -> texto = "Ricardo";
        $guardaEjemplo2 -> save();
    }

}