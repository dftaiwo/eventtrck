<?php

class PHPTemplateRenderer extends BaseRenderer{

    protected   $base_directory,
                $extension = 'php';

    public function initialize($render_config){
        foreach($render_config as $key=>$val){
            $this->{$key} = $val;
        }
    }

    public function canRender($template)
    {
        $template_file = BASE_DIRECTORY."/{$this->base_directory}/".$template;
        return preg_match('/\.php$/', $template_file);
    }

    public function render($template, $variables, $buffer=false){
        $template_file = BASE_DIRECTORY."/{$this->base_directory}/".$template;


        foreach ($variables as $field => $value) {
            $$field = $value;
        }

        if (!file_exists($template_file)) {
            throw new TemplateNotFoundException($template_file);
        }

        if($buffer == true){
            ob_start();
            include($template_file);

            $output = ob_get_clean();
            return $output;
        }
        include($template_file);

    }
} 