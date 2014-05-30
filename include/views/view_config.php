<?php


$renderer_config['renderer_list']['php_template'] = array(
    'include'       => 'include/views/PHPTemplateRenderer.php',
    //the class instance that will be used to instantiate this template renderer
    'class'         => 'PHPTemplateRenderer',
    //config parameters to be passed to the renderer after instantiation
    'config'        => array(
        'base_directory'    => 'template'
    )
);

$renderer_config['renderer_engine'] = array(
    'class'         => 'BaseRenderingEngine',
    'include'       => 'include/views/BaseRenderingEngine.php',
    //'config'        => array() //extra config data that can be used to initialize this rendering engine
);

global $view_config;
$view_config = $renderer_config;

function get_view_config(){
    global $view_config;
    return $view_config;
}

function get_view_renderer_engine_info(){
    return get_view_config()['renderer_engine'];
}

function get_view_renderer_list(){
    return get_view_config()['renderer_list'];
}