<?php

require_once ('Controller.php');

$action = myGet("action");

$methods = get_class_methods('Controller');

if (in_array($action, $methods)){
    Controller::$action();
    }
else{
    return "mauvaise action";
    }


function myGet($nomvar){
    if (isset($_POST[$nomvar])) {
        return $_POST[$nomvar];
    } else{
        if (isset($_GET[$nomvar])) {
            return $_GET[$nomvar];
        } else{
            return null;
        }
    }
}

?>