<?php
require ('vendor/autoload.php');

use Illuminate\Database\Eloquent\Model;

class Ejemplo extends Model
{
    protected $table = 'ejemplo1';
    public $timestamps = false;
}