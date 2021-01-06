<?php
include_once ($_SERVER['DOCUMENT_ROOT'].'/financiero/dirs.php');
require (VENDOR_PATH.'autoload.php');
use Illuminate\Database\Eloquent\Model;

class Transaccion extends Model
{
    public static function beginTransaction()
    {
        self::getConnectionResolver()->connection()->beginTransaction();
    }

    public static function commit()
    {
        self::getConnectionResolver()->connection()->commit();
    }

    public static function rollBack()
    {
        self::getConnectionResolver()->connection()->rollBack();
    }

}
