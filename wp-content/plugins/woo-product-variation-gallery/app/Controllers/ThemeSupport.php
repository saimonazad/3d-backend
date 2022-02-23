<?php

namespace Rtwpvg\Controllers;

class ThemeSupport
{
    /**
     * ThemeSupport constructor.
     * Add Theme Support for different theme
     */
    public function __construct() {
        add_action('init', array($this, 'add_theme_support'), 200); 
        
        // Flatsome Theme Custom Layout Support
        add_filter( 'wc_get_template_part', array($this, 'rtwpvg_gallery_template_part_override'), 30, 2 );
    }

    function add_theme_support() {
        // Electro Theme remove extra gallery
        if (apply_filters('rtwpvg_add_electro_theme_support', true)) {
            remove_action('woocommerce_before_single_product_summary', 'electro_show_product_images', 20);
        }
    } 
	 
    function rtwpvg_gallery_template_part_override( $template, $template_name ) {
        
        $old_template = $template;
        
        // Disable gallery on specific product
        
        if ( apply_filters( 'disable_woo_variation_gallery', false ) ) {
            return $old_template;
        } 
        
        if ( $template_name == 'single-product/product-image' ) {
            $template = rtwpvg()->locate_template('product-images');
        }
        
        if ( $template_name == 'single-product/product-thumbnails' ) {
            $template = rtwpvg()->locate_template('product-thumbnails');
        }
        
        return apply_filters( 'rtwpvg_gallery_template_part_override_location', $template, $template_name, $old_template );
    } 
} 