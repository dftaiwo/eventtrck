<?php

require_once('ValidationService.php');
require_once('validators/Validator.php');

class ValidationServiceProvider {

    /**
     * @var ValidationService
     */
    private static $service;

    static function getValidatorService(){
        if(ValidationServiceProvider::$service == null){
            $service = new ValidationService();

            require_once(get_includes_directory().'/validation/validation_config.php');

            $config = get_validation_config();

            foreach($config['validators'] as $name=>$info){
                $info['name'] = $name;
                $service->registerValidator($name, $info);
            }

            ValidationServiceProvider::$service = $service;
        }
        return ValidationServiceProvider::$service;
    }
} 