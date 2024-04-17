<?php 
require __DIR__ . '/vendor/autoload.php';
use App\Controller\Controller;
ini_set('display_errors', '0');
// Définition d'un gestionnaire d'exception global
set_exception_handler(function (Throwable $e){
    $filelog = fopen('logError.txt', 'a');
    $date = date('d-m-Y H:i:s');
    $error = $date.", " . $e->getMessage() . ", " . $e->getCode() . ", " . $e->getFile() . ", " . $e->getLine() . PHP_EOL;
    error_log($error, 3, 'logError.txt');
    fclose($filelog);
    $control = new Controller();
    $error = "Une erreur s'est produite... Veuillez nous excusez.";
    $control->render('/errors', [
        'error' => $error
    ]);
});
// Définition d'un gestionnaire d'erreurs global
set_error_handler(function ($errno, $errstr, $errfile, $errline){
    throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
});
session_set_cookie_params([
    'lifetime' => 3600,
    'path' => '/',
    'domain' => $_SERVER['SERVER_NAME'],
    'httponly' => true
]);
session_start();

define('_ROOTPATH_', __DIR__);
define('_TEMPLATEPATH_', __DIR__.'/templates');

spl_autoload_register();
$controller = new Controller();
$controller->route();

restore_error_handler();
restore_exception_handler();
