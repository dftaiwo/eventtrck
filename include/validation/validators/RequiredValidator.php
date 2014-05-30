<?php

class RequiredValidator extends Validator {

    public function doValidate($value, $context=array()){
        if(strlen(trim($value)) > 0){
            return true;
        }
        else{
            $message = "This field is required";
            if(isset($context['error_message'])){
                $message = $context['error_message'];
            }
            return $message;
        }
    }

} 