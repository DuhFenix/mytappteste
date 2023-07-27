<?php
set_time_limit(10000);
require 'functions/helpers.php';
require('vendor/autoload.php');
require 'autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

$xhrLogin = false;
$http_origin = $_SERVER["HTTP_HOST"];

// Cors Activate
//$login = new Login();
//$login->cors();

/**
 * Instância que carrega as requisições
 * @param Router   
 * Class Router
 * @package Hero
 *
 * @method Router get($route, $callable)
 * @method Router post($route, $callable)
 * @method Router put($route, $callable)
 * @method Router delete($route, $callable)
 */

$router = new Router();
$typeReq = $_SERVER['REQUEST_METHOD'];

$router
    ->post('/user/(\w+)', function ($function) {

        //Token Authorization 

        switch ($function) {

            case 'createUser':
                $parametros = json_decode(file_get_contents('php://input'));
                $retorno = array('data' => [], 'error' => '');

                try {
                    $usuario = new Usuario();
                    $return = $usuario->createUser($parametros);

                    if ($return['status']) {

                        $retorno['data'] = $return['resultado'];
                    } else {
                        $retorno['error'] = $return['erro'];
                    }
                } catch (Exception $e) {
                    $retorno['error'] = $e;
                }

                echo json_encode($retorno);
            case 'updateUser':
                $parametros = json_decode(file_get_contents('php://input'));
                $retorno = array('data' => [], 'error' => '');

                try {
                    $usuario = new Usuario();
                    $return = $usuario->updateUsuario($parametros);

                    if ($return['status']) {

                        $retorno['data'] = $return['resultado'];
                    } else {
                        $retorno['error'] = $return['erro'];
                    }
                } catch (Exception $e) {
                    $retorno['error'] = $e;
                }

                echo json_encode($retorno);
                break;
            case 'deleteUser':
                $parametros = json_decode(file_get_contents('php://input'));
                $retorno = array('data' => [], 'error' => '');

                try {
                    $usuario = new Usuario();
                    $return = $usuario->deleteUsuario($parametros->id);

                    if ($return['status']) {

                        $retorno['data'] = $return['resultado'];
                    } else {
                        $retorno['error'] = $return['erro'];
                    }
                } catch (Exception $e) {
                    $retorno['error'] = $e;
                }

                echo json_encode($retorno);
            case 'login':
                $parametros = json_decode(file_get_contents('php://input'));
                $retorno = array('data' => [], 'error' => '');

                try {
                    $usuario = new Usuario();
                    $return = $usuario->Login($parametros);

                    if ($return['status']) {

                        $retorno['data'] = $return['resultado'];
                    } else {
                        $retorno['error'] = $return['erro'];
                    }
                } catch (Exception $e) {
                    $retorno['error'] = $e;
                }

                echo json_encode($retorno);
            default:
                $retorno = array('data' => [], 'error' => 'Houve um erro na sua requisição!');
                echo json_encode($retorno);
                break;
        }
    });
