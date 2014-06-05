<?php

class ValidationException extends Exception{

}

class ValidatorNotFoundException extends ValidationException{

}

class ValidatorExistException extends ValidationException{

}

class InvalidValidationConfigurationException extends ValidationException{

}