<div class="co2ok_container co2ok_container_default" data-cart="<?php echo $cart ?>">

    <span class="co2ok_checkbox_container co2ok_checkbox_container_default <?php echo ($co2ok_session_opted == 1 ? 'selected' : 'unselected' )?>">
        <?php
            woocommerce_form_field('co2ok_cart', array(
                'type' => 'checkbox',
                'id' => 'co2ok_cart',
                'class' => array('co2ok_cart'),
                'required' => false,
            ), $co2ok_session_opted);
        ?>

        <div id="checkbox_label">
            <a href="#!" input type="button" role="button" tabindex="0" style="outline: none; -webkit-appearance: none; background-color: transparent !important; z-index: 9999;">
                <div class="inner_checkbox_label inner_checkbox_label_default co2ok_global_temp" id="default_co2ok_temp">
                    <div id="checkbox">
                    </div>

                    <span class="make make_co2ok_default"><?php echo __( 'Make ', 'co2ok-for-woocommerce' ); ?> </span>
                    <?php echo south_pole_plugin_woocommerce\Components\Co2ok_HelperComponent::RenderImage('images/logo.svg', 'co2ok_logo', 'co2ok_logo_default', 'co2ok_logo', 'skip-lazy'); 

                        echo '<span class="compensation_amount_default compensation_amount_global">+' .
                        $currency_symbol.''. $surcharge ."</span>";

                        $priceArr = str_split($surcharge);
                        $price_length = count($priceArr);
                    ?>

                </div>
            </a>
        </div>
    </span>



    <span class="co2ok_payoff">
        <span class="co2ok_payoff_text co2ok_adaptive_color_default">
                <span>
                    <?php
                        echo  __( 'Make my purchase climate friendly', 'co2ok-for-woocommerce' );
                        ?>
                </span>
                <span>
                    <?php

                    $variables = array(
                        '{COMPENSATION_COUNT}' => esc_attr($compensation_count),
                        '{IMPACT}' => esc_attr($impact_total));
                    echo esc_html( strtr( __('{COMPENSATION_COUNT}x compensated; {IMPACT}t CO₂ reduction', 'co2ok-for-woocommerce' ), $variables));
                    ?>
                </span>
                <span>
                    <?php

                    $variables = array(
                        '{KM}' => $impact_total * 5000);
                    echo esc_html( strtr( __('This is equivalent to {KM} km of flying ✈️', 'co2ok-for-woocommerce' ), $variables));
                    ?>
              </span>
        </span>
        <a href="#!" input type="button" role="button" tabindex="0" class="co2ok_info_keyboardarea" style="outline: none; -webkit-appearance: none;">
        <span id="p">
            <span class="co2ok_info_hitarea">
                <?php echo south_pole_plugin_woocommerce\Components\Co2ok_HelperComponent::RenderImage('images/info.svg', 'co2ok_info', 'co2ok_info'); ?>
            </span>
        </span>
        </a>

        <div class="co2ok_infobox_container co2ok-popper default-info-hovercard" id="infobox-view">

            <div class="default-exit-area desktop-hidden">
                <p class="default-exit-hovercard">
                    <?php echo __('X',  'co2ok-for-woocommerce' );?>
                </p>
            </div>

            <div class="default-wrapper default-info-hovercard">
                <?php echo south_pole_plugin_woocommerce\Components\Co2ok_HelperComponent::RenderImage('images/factory.png', 'default-png', 'default-png default-png-right default-info-hovercard', 'a3-notlazy'); ?>
                <p class="default-steps step-one default-left default-info-hovercard">
                    <?php echo __('Every product has a climate impact through transport and production',  'co2ok-for-woocommerce' );?>
                </p>
            </div>

            <div class="hovercard-road default-info-hovercard">
                <?php echo south_pole_plugin_woocommerce\Components\Co2ok_HelperComponent::RenderImage('images/gray_road.png', 'default-road-png', 'default-road-png default-top-road default-info-hovercard', 'a3-notlazy'); ?>
            </div>

            <div class="default-wrapper default-info-hovercard">
                <?php echo south_pole_plugin_woocommerce\Components\Co2ok_HelperComponent::RenderImage('images/green_truck.png', 'default-png', 'default-png-left default-png default-png-truck default-info-hovercard', 'a3-notlazy'); ?>
                <p class="default-steps step-two default-right default-info-hovercard">
                    <?php echo __('This webshop neutralizes emissions from transport',  'co2ok-for-woocommerce' );?>
                </p>
            </div>

            <div class="hovercard-road default-info-hovercard">
                <?php echo south_pole_plugin_woocommerce\Components\Co2ok_HelperComponent::RenderImage('images/green_road_left.png', 'default-road-png', 'default-road-png default-middle-road default-info-hovercard', 'a3-notlazy'); ?>

            </div>

            <div class="default-wrapper default-info-hovercard">
                <?php echo south_pole_plugin_woocommerce\Components\Co2ok_HelperComponent::RenderImage('images/checkmark.png', 'default-png', 'default-png-button default-png default-info-hovercard', 'a3-notlazy'); ?>
                <p class="default-steps step-three default-left default-info-hovercard">
                    <?php echo __('You can neutralize the impact of production with your contribution',  'co2ok-for-woocommerce' );?>
                </p>
            </div>

            <div class="hovercard-road default-info-hovercard">
                <?php echo south_pole_plugin_woocommerce\Components\Co2ok_HelperComponent::RenderImage('images/green_road_right.png', 'default-road-png', 'default-bottom-road default-road-png default-info-hovercard', 'a3-notlazy'); ?>
            </div>

            <div class="default-wrapper default-info-hovercard">
                <?php echo south_pole_plugin_woocommerce\Components\Co2ok_HelperComponent::RenderImage('images/renewable_energy.png', 'default-png', 'default-png default-png-left default-png-renewable default-info-hovercard', 'a3-notlazy'); ?>
                <p class="default-steps step-four default-right default-info-hovercard">
                    <?php echo __('We finance projects that directly prevent emissions and together we help the climate 💚',  'co2ok-for-woocommerce' );?>
                </p>
            </div>

            <div class="projects-wrapper default-info-hovercard">
                <p class="default-projects projects-text default-info-hovercard">
                    <?php echo __('South Pole supports several carbon offset projects. These projects are certified with the CDM Gold Standard, the strictest standard for climate protection projects.',  'co2ok-for-woocommerce' );?>
                </p>
                <?php echo south_pole_plugin_woocommerce\Components\Co2ok_HelperComponent::RenderImage('images/co2-projects.png', 'default-projects-image default-info-hovercard', 'a3-notlazy'); ?>
                <p class="co2-image-description default-info-hovercard">
                    <?php echo __('Not only the climate benefits: we also realize less deforestation and increased health benefits through less smoke and toxic carbon monoxide',  'co2ok-for-woocommerce' );?>
                </p>
            </div>

            <a class="hover-link" target="_blank" href="http://co2ok.eco"><?php echo south_pole_plugin_woocommerce\Components\Co2ok_HelperComponent::RenderImage('images/logo.svg', 'default-logo-hovercard', 'default-logo-hovercard default-info-hovercard', 'a3-notlazy'); ?></a>

            <span class="default-button-hovercard-links default-info-hovercard">
                <a class="default-co2ok-button default-info-hovercard" target="_blank" href="http://www.co2ok.eco/co2-compensatie"><?php
                    echo  __( 'How do we do this', 'co2ok-for-woocommerce' );
                ?></a>
            </span>
            <?php echo south_pole_plugin_woocommerce\Components\Co2ok_HelperComponent::RenderImage('images/branch.png', 'default-branch-png', 'default-branch-png default-info-hovercard', 'a3-notlazy'); ?>

        </div>

        <?php if ( $co2ok_gif_feature == 'on' ): ?>
            <div class="co2ok_videoRewardBox_container" id="videoRewardBox-view">

                <video width="320" height="240" autoplay id="co2ok_videoReward" playsinline>
                <?php echo south_pole_plugin_woocommerce\Components\Co2ok_HelperComponent::RenderRandomizedVideo(); ?>
                    Your browser does not support the video tag.
                </video>

            </div>
        <?php endif; ?>

    </span>


</div>
