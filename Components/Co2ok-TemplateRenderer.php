<?php
namespace south_pole_plugin_woocommerce\Components;

class Co2ok_TemplateRenderer
{

    public $templateFolder;

    function __construct( $templateFolder = null ){
        if ( $templateFolder ) {
            $this->set_template_folder( $templateFolder );
        }
    }

    function set_template_folder( $templateFolder ){
        // normalize the internal folder value by removing any final slashes
        $this->templateFolder = $this->templateFolder = rtrim( $templateFolder, '/' );
    }

    function render( $suggestions, $variables = array() ){
        $template = $this->find_template( $suggestions );
        $output = '';
        if ( $template ){
            $output = $this->render_template( $template, $variables );
        }


        return $output;
    }

    function find_template( $template_name )
    {
        $file = "{$this->templateFolder}/{$template_name}.php";

        if ( file_exists( $file ) ){
            $found = $file;
            return $file;
        }
        else
        {
            echo ' Selected Template not found ..';
            return false;
        }

        return false;
    }

    function render_template( ){
        ob_start();
        foreach ( func_get_args()[1] as $key => $value) {
            ${$key} = $value;
        }
        include func_get_args()[0];
        return ob_get_clean();
    }
}