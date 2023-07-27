<?php 
//set_time_limit (120);
date_default_timezone_set('America/Sao_Paulo');

include "config/conexao-pdo.php";

function my_autoload ($nomeClasse) {
    $dirs = array(
        'router',
        'model',
        'config'
    );

    foreach ($dirs as $key => $value) {
        $ext =  ".php";
        $dir = str_replace("\\",DIRECTORY_SEPARATOR, __DIR__); 
        $ds = $dir.DIRECTORY_SEPARATOR.$value.DIRECTORY_SEPARATOR; 
        $fullpath = $value.DIRECTORY_SEPARATOR.''. strtolower($nomeClasse) . $ext; 
        
        if(file_exists($fullpath)){  
            require_once $fullpath; 
        }
    }
}