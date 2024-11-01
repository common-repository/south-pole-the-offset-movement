<?php
namespace south_pole_plugin_woocommerce\Components;

if ( !class_exists( 'south_pole_plugin_woocommerce\Components\Co2ok_HelperComponent' ) ) :

    class Co2ok_HelperComponent
    {
        public function __construct()
        {

        }

        static public function RenderImage($uri, $class = null, $class_global = null, $id = null, $extra_class = null)
        {
            $img_html = '<img alt="Maak mijn aankoop klimaatneutraal " title="Maak mijn aankoop klimaatneutraal " src="' .esc_url(plugins_url($uri, __FILE__)) . '" ';
            $img_html = str_ireplace( '/Components', '', $img_html );
            if (isset($class))
                $img_html .= 'class="' . $class .' '. $class_global . ' ' . $extra_class . '"';
            if (isset($id))
                $img_html .= 'id="' . $id . '" ';

            return $img_html . ' />';
        }

        static public function RenderRandomizedVideo()
        {
            $rewardVideo[] = array();
            $rewardVideo[0] = 'make-globe-happy';
            $rewardVideo[1] = 'happy-flower';
            $rewardVideo[2] = 'globe-sprout';
            $rewardVideo[3] = 'happy-globe';

            $pickedVideo = mt_rand(0,count($rewardVideo) - 1);

            $videopath = esc_url(plugins_url('images/'.$rewardVideo[$pickedVideo], __FILE__));
            $videopath = str_ireplace( '/Components', '', $videopath );

            $video_html = '<source src="' . $videopath . '.mp4" type="video/mp4">';

            return $video_html;
        }

        public function RenderCheckbox($surcharge, $cart)
        {
            global $woocommerce;

            $templateRenderer = new Co2ok_TemplateRenderer(plugin_dir_path(__FILE__).'../Templates/');

            $template = get_option('co2ok_button_template', 'co2ok_button_template_default');
            if (get_option('co2ok_cfp') == 'on')
                $template = 'co2ok_button_template_default_cfp';

            // Render checkbox / button according to admin settings
            echo $templateRenderer->render($template,
            array('cart' => $cart,
                    'co2ok_session_opted' =>  $woocommerce->session->co2ok,
                    'currency_symbol' =>get_woocommerce_currency_symbol(),
                    'surcharge' => $surcharge,
                    'co2ok_gif_feature' => get_option('co2ok_gif_feature', 'on'),
                    // fake it till you make it; 0 => 1
                    'compensation_count' => get_option('co2ok_compensation_count', 1),
                    // impact from kg => tonne, 1 decimal point, rounding up
                    // ceil 4.2 => 5, so /10, ceil, /100, round with 1 decimal
                    'impact_total' => round(ceil(get_option('co2ok_impact', 100)/10) / 100, 1)
                )
            );



        }

    }

endif;
