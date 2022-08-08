<?php
session_start();
spl_autoload_register(function ($class){
    $class = filter_var($class, FILTER_SANITIZE_STRING);
    $class = str_replace('/', '\\', $class);
    $class = explode('\\', $class);
    $class = end($class);

    require_once __DIR__."/controllers/".$class.".php";

});