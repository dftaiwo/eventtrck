<?php

class ValidationService {

    protected $validators = array();

    protected $registeredValidations = array();


    function registerValidator($validator_name, $validator_info){
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
            $validator = new $class();
            $validator->setName($name);
            $this->validators[$validator_name] = $validator;
        }
        return $validator;
    }

    function registerValidation($validator_name, $field, $context=array()){

        if($validator_name instanceof Validator){
            $validator_name = $validator_name->getName();
        }

        if(!isset($this->validators[$validator_name])){
            throw new ValidatorNotFoundException("The validator {$validator_name} is not a registered validator");
        }

        if(!isset($this->registeredValidations[$field])){
            $this->registeredValidations[$field] = array();
        }

        $this->registeredValidations[$field][] = array(
            'validator'     => $validator_name,
            'context'       => $context
        );
    }

    function validate($items_to_validate){
        $valid = true;
        $validationResult = new ValidationResult();
        $cleaned = array();
        foreach($items_to_validate as $field_name=>$field_value){
            if(isset($this->registeredValidations[$field_name])){
                $validations = $this->registeredValidations[$field_name];
                foreach($validations as $validation_data){
                    $validator_name = $validation_data['validator'];
                    $validator = $this->getValidator($validator_name);

                    $cleaned_value = $validator->clean($field_value);
                    $validated = $validator->doValidate($cleaned_value, $validation_data['context']);
                    if($validated === true){
                        $cleaned[$field_name] = $cleaned_value;
                    }
                    else{
                        $validationResult->addError($field_name, $validated);
                        $valid = false;
                    }
                }
            }
            else{
                $cleaned[$field_name] = $field_value;
            }
        }

        //empty our validation bucket for the next validation
        $this->registeredValidations = array();

        $validationResult->setValid($valid);
        $validationResult->setCleanedData($cleaned);

        return $validationResult;

    }
}

class ValidationResult{

    private $valid,
            $cleanedData;

    private $errors = array();

    /**
     * @param mixed $cleanedData
     */
    public function setCleanedData($cleanedData)
    {
        $this->cleanedData = $cleanedData;
    }

    /**
     * @return mixed
     */
    public function getCleanedData()
    {
        return $this->cleanedData;
    }

    /**
     * @param mixed $valid
     */
    public function setValid($valid)
    {
        $this->valid = $valid;
    }

    /**
     * @return mixed
     */
    public function isValid()
    {
        return $this->valid;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    public function addError($field, $error){
        if(!isset($this->errors[$field])){
            $this->errors[$field] = array();
        }
        $this->errors[$field][] = $error;
    }

}

class ValidatorNotFoundException extends Exception{

}