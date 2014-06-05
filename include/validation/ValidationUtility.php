<?php

require_once("IValidationContext.php");
require_once('IValidationRuleRetrieval.php');

require_once('validation_config.php');
require_once('ValidationService.php');
require_once('ValidationErrorMessageTranslator.php');
require_once('ValidationContext.php');
require_once('ValidationResult.php');
require_once('validators/Validator.php');
require_once('exceptions.php');
require_once('ValidationQuery.php');
require_once('ValidationRule.php');


class ValidationUtility {

    /**
     * @var ValidationService
     */
    private static $service;

    static function getValidationService(){
        if(ValidationUtility::$service == null){
            $service = new ValidationService();

            $config = get_validation_config();

            foreach($config['validators'] as $name=>$info){
                $info['name'] = $name;
                $service->registerValidator($name, $info);
            }

            ValidationUtility::$service = $service;
        }
        return ValidationUtility::$service;
    }

    /**
     * @return ValidationQuery
     */
    static function createValidationQuery(){
        return new ValidationQuery();
    }
}