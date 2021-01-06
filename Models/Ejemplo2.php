<?php
require ('vendor/autoload.php');

use Illuminate\Database\Eloquent\Model;

class Ejemplo2 extends Model
{
    protected $table = 'ejemplo2';
    public $timestamps = false;
}