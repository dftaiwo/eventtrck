<?php


class ValidationQuery implements IValidationQuery, IValidationContext, IValidationRuleRetrieval {

    private $currentField, $currentValidator;
    private $validations = array();
    /**
     * @var ValidationContext
     */
    private $currentContext;

    public function withField($field){
        $this->currentField = $field;
        $this->currentValidator = null;
        return $this;
    }

    public function validateUsing($validator_name, $context=null){
        if($this->currentField){
            $this->registerValidation($validator_name, $this->currentField, $context);
            return $this;
        }
        throw new InvalidValidationConfigurationException("target validation field not specified before call to validateUsing");
    }


    public function validateUsingValidators($validators=array()){
        foreach($validators as $validator_data){
            $context = null;
            $field = $validator_data;
            if(is_array($validator_data)){
                $field = $validator_data['validator'];
                $context = $validator_data['context'];
            }
            $this->validateUsing($field, $context);
        }
        return $this;
    }

    public function withValidator($validator_name){
        $this->currentValidator = $validator_name;
        $this->currentField = null;
        return $this;
    }

    public function validateAgainst($field, $context = null){
        if($this->currentValidator){
            $this->registerValidation($this->currentValidator, $field, $context);
            return $this;
        }
        throw new InvalidValidationConfigurationException("target validator not specified before call to validateAgainst");
    }

    public function validateAgainstFields($fields=array()){
        foreach($fields as $field_data){
            $context = null;
            $field = $field_data;
            if(is_array($field_data)){
                $field = $field_data['field'];
                $context = $field_data['context'];
            }
            $this->validateAgainst($field, $context);
        }
        return $this;
    }

    public function validate($items_to_validate){
        return ValidationUtility::getValidationService()->validate($items_to_validate, $this);
    }

    public function getAllValidations(){
        return $this->validations;
    }

    /**
     * @param $field_name
     * @return ValidationRule[]
     */
    public function getFieldValidations($field_name){
        if(isset($this->validations[$field_name])){
            return $this->validations[$field_name];
        }
        return array();
    }

    /**
     * @param $field_name
     * @param $validator
     * @return ValidationRule
     */
    public function getValidationRule($field_name, $validator){
        $validations = $this->getFieldValidations($field_name);
        if($validator instanceof Validator){
            $validator = $validator->getName();
        }
        if(!empty($validations)){
            foreach($validations as $validation_rule){
                if($validation_rule->getValidatorName() == $validator){
                    return $validation_rule;
                }
            }
        }

    }

    private function registerValidation($validator_name, $field, $context){
        $this->currentContext = $context;
        if(!$this->currentContext){
            $this->currentContext = new ValidationContext();
        }
        if(!isset($this->validations[$field])){
            $this->validations[$field] = array();
        }

        $this->validations[$field][] = new ValidationRule($validator_name, $this->currentContext);

    }


    function setErrorMessage($error_message)
    {
        if($this->currentContext){
            $this->currentContext->setErrorMessage($error_message);
        }
        return $this;
    }

    function addErrorMessageArgument($key, $value)
    {
        if($this->currentContext){
            $this->currentContext->addErrorMessageArgument($key, $value);
        }
        return $this;
    }

    function addValidationContextData($key, $val)
    {
        if($this->currentContext){
            $this->currentContext->addValidationContextData($key, $val);
        }
        return $this;
    }

    function setPreValidationCallback($function)
    {
        if($this->currentContext){
            $this->currentContext->setPreValidationCallback($function);
        }
        return $this;
    }

}

interface IValidationQuery{
    public function withValidator($validator_name);
    public function validateAgainst($field, $context = null);

    public function withField($field);
    public function validateUsing($validator_name, $context=null);

    public function validate($items_to_validate);
}