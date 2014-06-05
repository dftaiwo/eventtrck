<?php

class RequiredValidator extends Validator {

    /**
     * @param $value
     * @param $context ValidationContext
     * @return bool|mixed|string
     */
    public function doValidate($value, $context=null){
        return strlen(trim($value)) > 0;
    }

    public function getDefaultErrorMessage($context)
    {
        return "{0} is required";
    }


} 