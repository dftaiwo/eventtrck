<?php

class Validator {

    private $name;

    public function clean($value){
        return $value;
    }

    public function doValidate($value, $context){
        return true;
    }


    public function getValidator($validator){
        return ValidationServiceProvider::getValidatorService()->getValidator($validator);
    }

    public function validateAgainst($field, $context = array()){
        ValidationServiceProvider::getValidatorService()->registerValidation($this->getName(), $field, $context);
        return $this;
    }

    /**
     * @param $items_to_validate
     * @return ValidationResult
     */
    public function validate($items_to_validate){
        return ValidationServiceProvider::getValidatorService()->validate($items_to_validate);
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }



} 