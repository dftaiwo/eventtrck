<?php

class BaseRenderingEngine {

    protected $renderers = array();

    public final function initialize($config){
        $this->preInitialize($config);
        $this->registerViewRenderers($config);
        $this->postInitialize($config);
    }

    public function preInitialize($config){

    }

    public function postInitialize($config){

    }

    /**
     * actually renders a template. The default engines behaviours to find a template renderer who can render the specified
     *  template from the list of renderers
     * @param $template
     * @param $variables
     * @param bool $buffer if TRUE (default) then the generated output is buffered and returned to the caller,
     *  otherwise the generated output is written straight to the stream. It's left for the renders though to determine how
     *  buffering should work
     * @throws NoRendererFoundException
     */
    public function render($template, $variables=array(), $buffer=false){
        foreach($this->renderers as $render_name=>&$renderer){
            if(is_array($renderer)){
                // this renderer has not been created lets instantiate it
                if(array_key_exists('include', $renderer)){
                    //if a file is required for inclusion, include it
                    $file = $renderer['include'];
                    $file = BASE_DIRECTORY."/{$file}";
                    require_once $file;
                }

                $config = isset($renderer['config'])? $renderer['config'] : array();

                //instantiate and initialise the renderer passing in any configuration parameter set
                $class = $renderer['class'];
                $renderer = new $class();
                $renderer->initialize($config);
            }

            if($renderer->canRender($template)){
                return $renderer->render($template, $variables, $buffer);
            }
        }
        throw new NoRendererFoundException('No renderer found for template '.$template);
    }

    private function registerViewRenderers($config){
        $this->renderers = get_view_renderer_list();
    }
}