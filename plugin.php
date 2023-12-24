<?php

/**
 * @package confetti_animation_wordpress_plugin
 * @version 1.0
 **/

/*
Plugin Name: Confetti Animation
Plugin URI: https://greoux.re/code/index.php/confetti-animation-wordpress-plugin/
Description: Use the shortcode [confetti-animation delay="1" duration="25"] on any (individual) post or page to start a falling confetti animation. Parameters "delay" (before starting of the animation) and "duration" (of the animation) in seconds.
Author: Gréoux Research
Version: 1.0
Author URI: https://greoux.re
 */

/* --- */

if (!function_exists("add_action")) {
    exit;
}

/* --- */

define("GREOUXRE_CONFETTI_ANIMATION_URL", plugin_dir_url(__FILE__));

/* --- */

$GREOUXRE_CONFETTI_ANIMATION_CAN_BE_LOADED = 0;

function GREOUXRE_CONFETTI_ANIMATION_TEMPLATE_REDIRECT()
{
    global $GREOUXRE_CONFETTI_ANIMATION_CAN_BE_LOADED;
    if ((is_page() or is_single()) and (strpos(get_post(get_the_ID())->post_content, "[confetti-animation") !== false)) {
        $GREOUXRE_CONFETTI_ANIMATION_CAN_BE_LOADED = 1;
    }
}

add_action("template_redirect", "GREOUXRE_CONFETTI_ANIMATION_TEMPLATE_REDIRECT");

/* --- */

function GREOUXRE_CONFETTI_ANIMATION_WP_ENQUEUE_SCRIPTS()
{
    global $GREOUXRE_CONFETTI_ANIMATION_CAN_BE_LOADED;
    if ($GREOUXRE_CONFETTI_ANIMATION_CAN_BE_LOADED === 1) {
        wp_enqueue_script("jquery");
        wp_enqueue_script(
            "confetti-js",
            GREOUXRE_CONFETTI_ANIMATION_URL . "assets/confetti.js@1.0/confetti.min.js"
        );
        wp_enqueue_script(
            "confetti-animation",
            GREOUXRE_CONFETTI_ANIMATION_URL . "assets/confetti-animation.js",
            array("jquery", "confetti-js")
        );
    }
}

add_action("wp_enqueue_scripts", "GREOUXRE_CONFETTI_ANIMATION_WP_ENQUEUE_SCRIPTS");

/* --- */

function GREOUXRE_CONFETTI_ANIMATION_HTM($atts)
{
    global $GREOUXRE_CONFETTI_ANIMATION_CAN_BE_LOADED;
    if ($GREOUXRE_CONFETTI_ANIMATION_CAN_BE_LOADED === 1) {
        $atts = shortcode_atts(
            array(
                "delay"    => "",
                "duration" => "",
            ), $atts
        );
        $delay    = $atts["delay"];
        $duration = $atts["duration"];
        return "<div class=\"confetti-animation\" data-delay=\"" . $delay . "\" data-duration=\"" . $duration . "\"></div>";
    } else {
        return "";
    }
}

add_shortcode("confetti-animation", "GREOUXRE_CONFETTI_ANIMATION_HTM");

/* --- */
