<?php

class ValidationService {

    protected $validators = array();


    function registerValidator($validator_name, $validator_info){
        if(isset($this->validators[$validator_name])){
            throw new ValidatorExistException("A validator with the name {$validator_name} already exists");
        }
        $this->validators[$validator_name] = $validator_info;
    }

    /**
     * @param $validator_name
     * @return Validator
     * @throws ValidatorNotFoundException
     */
    function getValidator($validator_name){
        if(!isset($this->validators[$validator_name])){
            throw new ValidatorNotFoundException("The validator {$validator_name} is not a registered validator");
        }
        $validator = $this->validators[$validator_name];
        if(is_array($validator)){
            if(array_key_exists('include', $validator)){
                require_once(BASE_DIRECTORY.'/'.$validator['include']);
            }

            $name = $validator['name'];
            $class = $validator['class'];
            $validator = new $class($name);
            $this->validators[$validator_name] = $validator;
        }
        return $validator;
    }

    /**
     * @param $items_to_validate array
     * @param $validation_rule_retrieval IValidationRuleRetrieval
     * @return ValidationResult
     */
    function validate($items_to_validate, $validation_rule_retrieval){
        $valid = true;
        $validationResult = new ValidationResult();
        $cleaned = array();
        foreach($items_to_validate as $field_name=>$field_value){
            $validations = $validation_rule_retrieval->getFieldValidations($field_name);

            if(!empty($validations)){

                foreach($validations as $validation_rule){
                    $validator_name = $validation_rule->getValidatorName();
                    $validation_context = $validation_rule->getValidatorContext();

                    $validator = $this->getValidator($validator_name);
                    $cleaned_value = $validator->clean($field_value);

                    $validated = $validator->performValidation($cleaned_value, $field_name, $validation_context);

                    if($validated === true){
                        $cleaned[$field_name] = $cleaned_value;
                    }
                    else{
                        $error_message = ValidationErrorMessageTranslator
                            ::translateErrorMessage($validator, $validation_context, $field_value);

                        $validationResult->addError($field_name, $error_message);
                        $valid = false;
                    }
                }
            }
            else{
                $cleaned[$field_name] = $field_value;
            }
        }

        $validationResult->setValid($valid);
        $validationResult->setCleanedData($cleaned);

        return $validationResult;

    }

}