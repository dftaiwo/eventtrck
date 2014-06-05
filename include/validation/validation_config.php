<?php

$validation_config['validators']['required'] = array(
    'include'       => 'include/validation/validators/RequiredValidator.php',
    'class'         => 'RequiredValidator'
);

$validation_config['validators']['length'] = array(
    'include'       => 'include/validation/validators/LengthValidator.php',
    'class'         => 'LengthValidator'
);

global $validation_configuration;
$validation_configuration = $validation_config;

function get_validation_config(){
    global $validation_configuration;
    return $validation_configuration;
}