<?php
/*
	Plugin Name: Swiper For Visual Composer
	Description: Swiper For Visual Composer
	Plugin URI: 
	Author: Xblue
	Author URI: 
	Version: 1.0
	License: GPL2
*/
if (!class_exists('Swiper_For_Visual_Composer')) {
    class Swiper_For_Visual_Composer
    {
        function __construct()
        {
            add_action('vc_before_init', array($this, 'sfvc_swiper'));
            add_action('init', array($this, 'check_if_vc_is_install'));
            // remove_filter( 'the_content', 'wpautop' );
        }


        function sfvc_swiper()
        {
            include 'render/sfvc_swiper.php';
        }

        function check_if_vc_is_install()
        {
            if (!defined('WPB_VC_VERSION')) {
                // Display notice that Visual Compser is required
                add_action('admin_notices', array($this, 'showVcVersionNotice'));
                return;
            }
        }
        function showVcVersionNotice()
        {
    ?>
            <div class="notice notice-warning is-dismissible">
                <p>Please Install <a href="https://1.envato.market/A1QAx">WPBakery Page Builder</a> to use swiper.</p>
            </div>
    <?php
        }
    }
    $tdt_object = new Swiper_For_Visual_Composer;
}
?>