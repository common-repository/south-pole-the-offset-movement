<?php
/**
 * Class Autoloader
 *
 *
 */

/*
spl_autoload_register( 'south_pole_plugin_woocommerce_autoload' );

function south_pole_plugin_woocommerce_autoload( $class_name ) {

    if ( false === strpos( $class_name, 'south_pole_plugin_woocommerce' ) ) {
        return;
    }

    $file_name = str_ireplace( '_', '-', $class_name );
    $file_name = str_ireplace( '\\', '/', $file_name );

    $filepath  = trailingslashit( dirname( dirname( __FILE__ ) )  );
    $filepath .= $file_name.'.php';

    if ( file_exists( $filepath ) )
    {
        if ( !class_exists( $class_name ) )
            include_once( $filepath );
    }
    else{ 
      //  echo "Something went wrong finding the files to include";
    }
}
*/

/*
 * PHP 5.1.2 < does not have spl_autoload_register 
    Fallback for Pre 5.1.2 PHP version
*/
//if(!function_exists("spl_autoload_register"))
//{


if ( !class_exists( 'south_pole_plugin_woocommerce\Components\Admin\Co2ok_AdminOverview' ) )
    require_once( plugin_dir_path( __FILE__ )."/Components/Admin/Co2ok-AdminOverview.php");

if ( !class_exists( 'south_pole_plugin_woocommerce\Components\Co2ok_TemplateRenderer' ) )
    require_once( plugin_dir_path( __FILE__ )."/Components/Co2ok-TemplateRenderer.php");

    if ( !class_exists( 'south_pole_plugin_woocommerce\Components\Co2ok_HelperComponent' ) )
        require_once( plugin_dir_path( __FILE__ )."/Components/Co2ok-HelperComponent.php");

    if ( !class_exists( 'south_pole_plugin_woocommerce\Components\Co2ok_HttpsRequest' ) )
        require_once( plugin_dir_path( __FILE__ )."/Components/Co2ok-HttpsRequest.php");

    if ( !class_exists( 'south_pole_plugin_woocommerce\Components\Co2ok_GraphQLClient' ) )
        require_once( plugin_dir_path( __FILE__ )."/Components/Co2ok-GraphQLClient.php");

    if ( !class_exists( 'south_pole_plugin_woocommerce\Components\Co2ok_GraphQLRequest' ) )
        require_once( plugin_dir_path( __FILE__ )."/Components/Co2ok-GraphQLRequest.php");

    if ( !class_exists( 'south_pole_plugin_woocommerce\Components\Co2ok_BewustBezorgd' ) )
        require_once( plugin_dir_path( __FILE__ )."/Components/Co2ok-BewustBezorgd.php");
//}