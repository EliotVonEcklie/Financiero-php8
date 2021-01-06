<?php
    /**
     * Modelo de Tabla pptoacuerdos
     * Almacena datos de los acuerdos
     */
    require(VENDOR_PATH.'autoload.php');
    use Illuminate\Database\Eloquent\Model;

    class CcpetAcuerdos extends Model{
        protected $table = 'ccpetacuerdos';
        protected $primaryKey = 'id_acuerdo';
        public $timestamps = false;
    }