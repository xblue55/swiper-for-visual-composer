<?php
if (!defined('ABSPATH')) {
    die('-1');
}
if (!class_exists('WPBakeryShortCode_sfvc_swiper')) {
    class WPBakeryShortCode_sfvc_swiper extends WPBakeryShortCode
    {
        protected function content($atts, $content = null)
        {
            extract(shortcode_atts(array(
                'settings' => '',
                'style' => 'coverflow-effect-3d',
                'effect' => 'coverflow',
                'grabCursor' => 'false',
                'centeredSlides' => 'true',
                'slidesPerView' => 'auto',
                'loop' => 'false',
                'pagination' => 'true',
                'loopAdditionalSlides' => 1,
                'slideToClickedSlide' => 'true',
                'initialSlide' => 2,
            ), $atts));

            $content = wpb_js_remove_wpautop($content, true);
            $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '), $this->settings['base'], $atts);
            wp_enqueue_style('swiper-css', plugins_url('../css/swiper.min.css', __FILE__));
            wp_enqueue_style('style-css', plugins_url('../css/style.css', __FILE__));
            wp_enqueue_script('swiper-js', plugins_url('../js/swiper.min.js', __FILE__), array('jquery'));
            ob_start();
            $args = array(
                'posts_per_page' => -1,
            );
            $seperate_settings = explode('|', $settings);

            foreach ($seperate_settings as $setting) {
                $key_val = explode(':', $setting);
                if ($key_val[0] == 'size') {
                    $args['posts_per_page'] = $key_val[1];
                } elseif ($key_val[0] == 'categories') {
                    $args['category__in'] = explode(',', $key_val[1]);
                } else {
                    $args[$key_val[0]] = $key_val[1];
                }
            }

            // The Query
            $the_query = new WP_Query($args);

            // The Loop
            if ($the_query->have_posts()) { ?>
                <div class='template-flexible-section <?php echo $css_class ?>'>
                    <div class="swipers-section">
                        <div class="swipers-container">
                            <div class="swiper-container" id="rwc-id-1">
                                <div class="swiper-wrapper">
                                    <?php while ($the_query->have_posts()) { ?>
                                        <?php $the_query->the_post(); ?>

                                        <?php switch ($style) {
                                            case 'coverflow-effect-3d':
                                                include 'includes/coverflow-effect-3d.php';
                                                break;
                                            default:
                                                include 'includes/coverflow-effect-3d.php';
                                                break;
                                        } ?>
                                    <?php } ?>
                                </div>
                                <div class="swiper-pagination"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    jQuery(document).ready(function($) {
                        var swiper = new Swiper('#rwc-id-1', {
                            effect: '<?php echo $effect; ?>',
                            grabCursor: <?php echo $grabCursor; ?>,
                            centeredSlides: <?php echo $centeredSlides; ?>,
                            slidesPerView: '<?php echo $slidesPerView; ?>',
                            loop: <?php echo $loop; ?>,
                            pagination: <?php echo $pagination; ?>,
                            loopAdditionalSlides: <?php echo $loopAdditionalSlides; ?>,
                            slideToClickedSlide: <?php echo $slideToClickedSlide; ?>,
                            initialSlide: <?php echo $initialSlide; ?>,
                            coverflowEffect: {
                                rotate: -0,
                                stretch: 100, //This wil change the 
                                depth: 80,
                                modifier: 1,
                                slideShadows: false
                            },
                            controller: {
                                inverse: false,
                            },
                            pagination: {
                                el: '.swiper-pagination',
                                type: 'bullets',
                                clickable: 'true'
                            }
                        });

                        function changingControls() {
                            jQuery('#rwc-btn-prev-id-1').addClass('swiper-button-prev');
                            jQuery('#rwc-btn-prev-id-1').removeClass('swiper-button-next');
                            jQuery('#rwc-btn-next-id-1').addClass('swiper-button-next');
                            jQuery('#rwc-btn-next-id-1').removeClass('swiper-button-prev');
                            setTimeout(function() {
                                jQuery('#rwc-btn-prev-id-1').addClass('swiper-button-prev');
                                jQuery('#rwc-btn-prev-id-1').removeClass('swiper-button-next');
                                jQuery('#rwc-btn-next-id-1').addClass('swiper-button-next');
                                jQuery('#rwc-btn-next-id-1').removeClass('swiper-button-prev');
                            }, 50);
                        }
                        jQuery(document).ready(function($) {
                            changingControls()
                        });
                        jQuery('.navigation-button').click(function() {
                            changingControls();
                        });
                        changingControls();
                    });
                </script>
    <?php wp_reset_postdata();
            } else {
                // no posts found
            }
            return ob_get_clean();
        }
    }

    vc_map(array(
        "base"             => "sfvc_swiper",
        "name"             => __('SFVC swiper', 'SFVC-swiper'),
        "category"         => __('SFVC Slider'),
        "description"     => __('show posts as slider', ''),
        "icon" => plugin_dir_url(__FILE__) . '../icons/swiper.png',
        'params' => array(
            array(
                "type"             =>     "dropdown",
                "heading"         =>     __('Choose Style', 'SFVC-swiper'),
                "param_name"     =>     "style",
                "group"         => 'General',
                "value"         =>     array(
                    "3D Coverflow Effect" => "coverflow-effect-3d",
                )
            ),

            array(
                "type"             =>     "loop",
                "heading"         =>     __('Link To', 'SFVC-swiper'),
                "param_name"     =>     "settings",
                "description"    =>    "Add Slide Url or leave blank, use it if you select theme [top image bottom content]",
                "group"         => 'General',
            ),
            array(
                "type"             =>     "dropdown",
                "heading"         =>     __('Loop', 'SFVC-swiper'),
                "param_name"     =>     "loop",
                "description"    =>    "Set to true to enable continuous loop mode",
                "value"         =>     array(
                    "True"         =>         "true",
                    "Fasle"     =>         "false"
                ),
                "group"         => 'General',
            ),
        ),
    ));
}
