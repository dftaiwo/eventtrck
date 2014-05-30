<?php

$validation_config['validators']['required'] = array(
    'include'       => 'include/validation/validators/RequiredValidator.php',
    'class'         => 'RequiredValidator'
);

global $validation_configuration;
$validation_configuration = $validation_config;

function get_validation_config(){
    global $validation_configuration;
    return $validation_configuration;
}