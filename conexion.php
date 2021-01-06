<?php
ini_set('display_errors', 1);
ini_set('display_starup_error', 1);

require_once('vendor/autoload.php');

$dotenv = Dotenv\Dotenv::create(__DIR__ . '');
$dotenv->load();

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection([
  'driver'    => getenv('DB_DRIVER'),
  'host'      => getenv('DB_HOST'),
  'database'  => getenv('DB_NAME'),
  'username'  => getenv('DB_USER'),
  'password'  => getenv('DB_PASS'),
  'charset'   => 'utf8',
  'collation' => 'utf8_unicode_ci',
  'prefix'    => '',
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();

