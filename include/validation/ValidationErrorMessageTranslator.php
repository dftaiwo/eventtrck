<?php


class ValidationErrorMessageTranslator {

    /**
     * @param $validator Validator
     * @param $validationContext ValidationContext,
     * @param $user_input
     * @return string
     */
    static function translateErrorMessage($validator, $validationContext, $user_input){

        $error_message = $validationContext->getErrorMessage();

        if(!$error_message){
            $error_message = $validator->getDefaultErrorMessage($validationContext);
        }

        $error_message_args = $validationContext->getErrorMessageArguments();

        if(!empty($error_message_args)){
            $replacements = array();
            $replace_with = array();
            foreach($error_message_args as $index=>$val){
                $replacements[] = '/\{'.$index.'\}/';
                if($val == '%%user_input%%')
                    $replace_with[] = $user_input;
                else
                    $replace_with[] = $val;
            }
            return preg_replace($replacements, $replace_with, $error_message);
        }
    }

} 