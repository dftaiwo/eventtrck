<?php


interface IValidationRuleRetrieval {

    /**
     * @param $field_name
     * @return ValidationRule[]
     */
    public function getFieldValidations($field_name);

    /**
     * @param $field_name
     * @param $validator
     * @return ValidationRule
     */
    public function getValidationRule($field_name, $validator);

    public function getAllValidations();
} 