<?php

define('BASE_DIR', dirname(__DIR__));

require_once BASE_DIR . '/Config/constants.php';
require_once BASE_DIR . '/vendor/autoload.php';

try{
    if (!preg_match('/assets/i', $_SERVER['REQUEST_URI']))
    {
        \Core\Router::dispatch($_SERVER['REQUEST_URI']);
    }
}catch (PDOException $e){
    dd("PDOException", $e);
}catch (Exception $e){
    dd("Exception", $e);
}