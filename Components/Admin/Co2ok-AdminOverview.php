<?php
/**
 * Created by PhpStorm.
 * User: Chris-Home
 * Date: 11/20/2017
 * Time: 19:33
 */

namespace south_pole_plugin_woocommerce\Components\Admin;

class Co2ok_AdminOverview
{

    public function __construct()
    {
        add_action('admin_menu', array($this, 'south_pole_plugin_setup_menu'));


        //add_action('admin_enqueue_scripts', array($this, 'co2ok_admin_style'),100000000);
        //add_action('admin_enqueue_scripts', array($this, 'co2ok_admin_javascript'),100000000);

    }

    function co2ok_admin_style($hook)
    {
        if($hook != 'co2ok-plugin') {
          //  return;
        }
        wp_enqueue_style( 'custom_wp_admin_css', plugins_url('admin-style.css', __FILE__) );

        wp_register_style('co2ok_stylesheet', plugins_url('../../css/co2ok.css', __FILE__) );
        wp_enqueue_style('co2ok_stylesheet');



        wp_enqueue_style( 'co2ok-google-fonts', 'http://fonts.googleapis.com/css?family=Roboto:300,400', false );
    }

    function co2ok_admin_javascript()
    {
        wp_register_script('co2ok_js_wp', plugins_url('../../js/co2ok-plugin.js', __FILE__) );
        wp_enqueue_script('co2ok_js_wp');
    }

    function south_pole_plugin_setup_menu()
    {
        add_menu_page( 'Co2ok Plugin Page', 'CO&#8322;ok Plugin', 'manage_options', 'co2ok-plugin', array($this, 'south_pole_plugin_admin_overview'));
    }

    function validate_setting_input($setting, $input)
    {
      $returnValue = '';
      if ($setting == 'co2ok_optout' || 'co2ok_gif_feature' || 'co2ok_ab_research') {
        if ($input == 'on' || $input == 'off') {
          $returnValue = $input; 
        } else {
          $returnValue = 'off';
        }
      } else if ($setting == 'co2ok_checkout_placement') {
        if ($input == 'after_order_notes' || 'before_checkout_form' || 'checkout_before_customer_details' || 'after_checkout_billing_form' || 'checkout_order_review') {
          $returnValue = $input;
        } else {
          $returnValue = 'checkout_order_review';
        }
      }
      return $returnValue;
    }

    function south_pole_plugin_admin_overview()
    {
        // Receives Post from Plugin-Settings in the browser and updates 
        // the state of the co2ok button style to WP database
        // if (isset($_POST['co2ok_button_template'])) {
        //     update_option('co2ok_button_template', $_POST['co2ok_button_template']);
        // }

        // if (isset($_POST['co2ok_statistics']))
        // {
        //     update_option('co2ok_statistics', 'on');
        // }

        // if (isset($_POST['co2ok_optout']))
        // {
        //     update_option('co2ok_optout', $this->validate_setting_input('co2ok_optout', sanitize_key($_POST['co2ok_optout'])));
        // }
        // if (isset($_POST['co2ok_cfp']))
        // {
        //     update_option('co2ok_cfp', $_POST['co2ok_cfp']);
        // }
        if (isset($_POST['co2ok_gif_feature']))
        {
            update_option('co2ok_gif_feature', $this->validate_setting_input('co2ok_gif_feature', sanitize_key($_POST['co2ok_gif_feature'])));
        }
        if (isset($_POST['co2ok_ab_research']))
        {
            update_option('co2ok_ab_research', $this->validate_setting_input('co2ok_ab_research', sanitize_key($_POST['co2ok_ab_research'])));
        }
        // if (isset($_POST['co2ok_widgetmark_footer']))
        // {
        //     update_option('co2ok_widgetmark_footer', $_POST['co2ok_widgetmark_footer']);
        // }

        // if (isset($_POST['co2ok_checkout_placement']))
        // {
            // update_option('co2ok_checkout_placement', $this->validate_setting_input('co2ok_checkout_placement', sanitize_key($_POST['co2ok_checkout_placement'])));
        // }

        // if (isset($_GET['co2ok_disable_button_on_cart']))
        // {
        //     update_option('co2ok_disable_button_on_cart', $_GET['co2ok_disable_button_on_cart']);
        // }


        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            if (!isset($_POST['co2ok_statistics']))
            {
                $_POST['co2ok_statistics'] = 'off';
                update_option('co2ok_statistics', 'off');
            }

            $graphQLClient = new \south_pole_plugin_woocommerce\Components\Co2ok_GraphQLClient(\south_pole_plugin_woocommerce\South_Pole_Plugin::$co2okApiUrl);

            $merchantId = get_option('co2ok_id', false);
            $co2ok_statistics = get_option('co2ok_statistics', 'off');
            $co2ok_optout = get_option('co2ok_optout', 'off');
            $co2ok_cfp = get_option('co2ok_cfp', 'off');
            $co2ok_gif_feature = get_option('co2ok_gif_feature', 'on');
            $co2ok_ab_research = get_option('co2ok_ab_research', 'off');
            $co2ok_widgetmark_footer = get_option('co2ok_widgetmark_footer', 'off');
            $co2ok_disable_button_on_cart = get_option('co2ok_disable_button_on_cart', 'false');
            $co2ok_checkout_placement = get_option('co2ok_checkout_placement', 'after_order_notes');

            $graphQLClient->mutation(function ($mutation) use ($merchantId, $co2ok_statistics, $co2ok_optout, $co2ok_cfp, $co2ok_gif_feature, $co2ok_widgetmark_footer, $co2ok_ab_research, $co2ok_disable_button_on_cart, $co2ok_checkout_placement)
            {
                $mutation->setFunctionName('updateMerchant');

                $mutation->setFunctionParams(
                    array(
                        'merchantId' => $merchantId,
                        'sendStats' => $co2ok_statistics,
                        'optout' => $co2ok_optout,
                        'cfp' => $co2ok_cfp,
                        'gif_feature' => $co2ok_gif_feature,
                        'ab_research' => $co2ok_ab_research,
                        'widgetmark_footer' => $co2ok_widgetmark_footer,
                        'co2ok_disable_button_on_cart' => $co2ok_disable_button_on_cart,
                        'co2ok_checkout_placement' => $co2ok_checkout_placement
                    )
                );
                $mutation->setFunctionReturnTypes(array('ok'));
            }
                , function ($response)// Callback after request
                {
                    // echo print_r($response,1);
                    // TODO error handling
                });
        }

        $co2ok_button_template = get_option('co2ok_button_template', 'co2ok_button_template_default');
        $co2ok_statistics = get_option('co2ok_statistics', 'off');
        $co2ok_optout = get_option('co2ok_optout', 'off');
        $co2ok_cfp = get_option('co2ok_cfp', 'off');
        $co2ok_gif_feature = get_option('co2ok_gif_feature', 'on');
        $co2ok_ab_research = get_option('co2ok_ab_research', 'off');
        $co2ok_widgetmark_footer = get_option('co2ok_widgetmark_footer', 'off');
        $co2ok_disable_button_on_cart = get_option('co2ok_disable_button_on_cart', 'false');
        $co2ok_checkout_placement = get_option('co2ok_checkout_placement', 'after_order_notes');
      
        include_once plugin_dir_path(__FILE__).'views/default.php';
    }

}
$admin = new Co2ok_AdminOverview();