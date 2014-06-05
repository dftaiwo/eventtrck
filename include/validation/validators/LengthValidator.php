<?php


class LengthValidator extends Validator{

    /**
     * @param $value
     * @param $context ValidationContext
     * @return mixed
     */
    public function doValidate($value, $context = null)
    {
        $min = $context->getValidationContextData('min');
        $max = $context->getValidationContextData('max');
        $min_test  = true;
        $max_test = true;

        if(!is_null($min)){
            $min_test = strlen($value) >= $min;
        }

        if(!is_null($max)){
            $max_test = strlen($value) <= $max;
        }

        return $min_test && $max_test;
    }

    /**
     * @param $value
     * @param $context ValidationContext
     */
    public function preValidate($value, $context = null)
    {
        $context->addErrorMessageArgument('min', $context->getValidationContextData('min'));
        $context->addErrorMessageArgument('max', $context->getValidationContextData('max'));
    }

    public function getDefaultErrorMessage($context)
    {
        $min = $context->getValidationContextData('min');
        $max = $context->getValidationContextData('max');
        $min_text = $max_text = '';

        if(!is_null($min)){
            $min_text = ' should be at least {min} characters';
        }
        if(!is_null($max)){
            if($min_text){
                $max_text = ' and ';
            }
            else{
                $max_text = ' should be ';
            }
            $max_text .= 'at most {max} characters';
        }

        $message = "{0}".$min_text.$max_text;
        return $message;
    }


} 