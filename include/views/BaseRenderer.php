<?php

abstract class BaseRenderer {

    public function initialize($render_config){

    }

    public function canRender($template){
        return false;
    }

    public function render($template, $variables, $buffer=false){

    }
} 