<?php

require_once("BaseRenderer.php");
class RendererEngineFactory {

    private static $engine = null;

    public static function getRenderingEngine(){
        if(RendererEngineFactory::$engine == null){
            require_once "view_config.php";

            $engine_info = get_view_renderer_engine_info();
            if(array_key_exists('include', $engine_info)){
                $include_file = $engine_info['include'];
                $include_file = BASE_DIRECTORY."/{$include_file}";
                require_once($include_file);
            }

            $engine = new $engine_info['class']();
            
            $engine->initialize(get_view_config());
            RendererEngineFactory::$engine = $engine;
        }
        return RendererEngineFactory::$engine;
    }

}

class NoRendererFoundException extends Exception{

}

class TemplateNotFoundException extends Exception{
    public $template;
    function __construct($template=''){
        parent::_contruct();
        $this->template = $template;
    }
}