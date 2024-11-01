<?php
        add_action( 'admin_post_co2ok_save_options', 'co2ok_save_options' );
        
        function co2ok_save_options() {
            echo('Hello World');
            print_r($_POST);
        }

    if (isset($_GET['co2ok_ab_results'])){
        if (get_option('co2ok_ab_research') == 'on')
            \south_pole_plugin_woocommerce\South_Pole_Plugin::co2ok_calculate_ab_results();
    }

?>

<div style="margin-top: 20px;">

    <img src="<?php echo esc_url(plugins_url('../../../images/logo.svg', __FILE__)); ?>" style="float:left;width:110px;"/>
    <h1 style="margin-left: 20px;display: inline-block;"> Plugin Settings </h1>
</br>
</br>

    <div id="col-container">

        <div id="col-left">
            <div class="col-wrap">
                <div class="form-wrap">
                    <h3>
                        <h1>Thanks for helping us fight climate change! :)</h1>
                        <img src="<?php echo esc_url(plugins_url('../../../images/happy-flower300.gif', __FILE__)); ?>"/>

                        <p>You are our hero. We strongly believe that no fight has been more important, and this needs
                            to be fought in any way possible. And it's not only the climate that benefits;</p>
                            <img src="<?php echo esc_url(plugins_url('../../../images/Lesotho-cookstoves.jpg', __FILE__)); ?>" width=300px/>
                            <p><small>Additional benefits are less deforestation and health benefits, due to decreasing 
                                smoke and poisonous carbon monoxide.</small>

                        <h2>Want to help us some more?</h2>
                        <p>If you do, please leave us a <a href=https://wordpress.org/support/view/plugin-reviews/co2ok-for-woocommerce?rate=5#new-post>5★ rating on WordPress.org</a>. It would be a great help to us.</p>

                        <h2>GIF feature</h2>
                        <p>We believe in putting smiles on customers faces - a happy customer is a returning one. One of the ways we try to put smiles on peoples faces is our GIF feature - it shows a fun GIF like the one above to customers if they choose CO2 compensation. Of course there are differing opinions on this - use the below setting to disable this feature.</p>
                        
                        <form method="POST">
                        
                            <input type="radio" name="co2ok_gif_feature" id="gif_on" value="on" <?php if($co2ok_gif_feature == 'on') echo "checked" ?> >
                            <label style="display: inline" for="gif_on">GIFs ON. (Preferred)</label>
                            <br>
                            <input type="radio" name="co2ok_gif_feature" id="gif_off" value="off" <?php if($co2ok_gif_feature == 'off') echo "checked" ?> >
                            <label style="display: inline" for="gif_off">GIFs OFF.</label>
                            
                            <p style="margin-top: 12px">
                                <input type="submit" value="Save" class="button button-primary button-large"></p>
                        </form>

                        <h2>A/B research</h2>
                        <p>Some webshops are not as forward thinking as yours. To convince them to participate in the fight, we need to show them South Pole doesn't impact conversion (or rather - that it helps!). Help us show them and get them on board!</p>

                        <p>This will show the South Pole option (and widget when present) to 50% of your customers, and report the difference in conversion.</p>
                        
                        <form method="POST">
                        
                            <input type="radio" name="co2ok_ab_research" id="ab_on" value="on" <?php if($co2ok_ab_research == 'on') echo "checked" ?> >
                            <label style="display: inline" for="ab_on">A/B research enabled</label>
                            <br>
                            <input type="radio" name="co2ok_ab_research" id="ab_off" value="off" <?php if($co2ok_ab_research == 'off') echo "checked" ?> >
                            <label style="display: inline" for="ab_off">A/B research disabled</label>
                            
                            <p style="margin-top: 12px">
                                <input type="submit" value="Save" class="button button-primary button-large"></p>
                        </form>

                        <h2>Something not working for you? Have a great idea or any other feedback? </h2>
                        <p>Call/text/WhatsApp us: <a href="tel:+31639765259">+31639765259</a></p>
                        <p>Drop us a line: <a href="mailto: make@co2ok.eco"><span>make@co2ok.eco</span></a></p>
                        <br>
                        <p>Thanks,<br>The South Pole and CO&#8322;ok team.</p>
                        <p><a href="https://www.southpole.com" target="_blank">www.southpole.com</a></p>
                        <br>
                        <hr>

                    </h3>
                </div>
            </div>
        </div>
    </div>
 