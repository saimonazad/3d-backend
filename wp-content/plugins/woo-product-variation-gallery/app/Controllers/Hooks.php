<?php

namespace Rtwpvg\Controllers;

use Rtwpvg\Helpers\Functions;

class Hooks
{

    public function __construct() {
        add_action('admin_init', array($this, 'after_plugin_active'));

        add_action('init', array($this, 'remove_wc_default_template'), 200);

        add_filter('body_class', array($this, 'body_class'));
        add_filter('post_class', array($this, 'product_loop_post_class'), 25, 3);

        add_action('after_setup_theme', array($this, 'enable_theme_support'), 200); // Enable theme support

        add_action('woocommerce_save_product_variation', array($this, 'save_variation_gallery'), 10, 2);
        add_action('woocommerce_product_after_variable_attributes', array($this, 'gallery_admin_html'), 10, 3);

        add_filter('woocommerce_available_variation', array($this, 'available_variation_gallery'), 90, 3);
        add_action('woocommerce_before_single_product_summary', array(
            $this,
            'woocommerce_show_product_images'
        ), 22);
        add_filter('wc_get_template', array($this, 'gallery_template_override'), 30, 2);

        add_action('wp_ajax_rtwpvg_get_default_gallery_images', array($this, 'get_default_gallery_images'));
        add_action('wp_ajax_nopriv_rtwpvg_get_default_gallery_images', array($this, 'get_default_gallery_images'));

        add_filter('rtwpvg_inline_style', array($this, 'rtwpvg_add_inline_style'), 9);  

        add_action('wp_ajax_save-attachment-compat', array($this, 'save_compat_video_field_via_ajax'), 0, 1);
        add_action('edit_attachment', array($this, 'save_compat_video_field'), 1);
        add_action('woocommerce_update_product', [$this, 'delete_cache_data'], 10, 1);

        add_action('rtwpvg_product_badge', [__CLASS__, 'add_yith_badge']);
    }

    /**
     * @param \WC_Product $product
     */
    public static function add_yith_badge($product) {
        if((defined('YITH_WCBM_VERSION') && YITH_WCBM_VERSION) || (defined('YITH_WCBM_PREMIUM') && YITH_WCBM_PREMIUM)) {
            echo apply_filters('woocommerce_single_product_image_thumbnail_html', '<div class="rtwpvg-yith-badge"></div>', $product->get_image_id());
        }
    }


    public function after_plugin_active() {
        if (get_option('rtwpvg_pro_active') === 'yes') {
            delete_option('rtwpvg_pro_active');
            wp_safe_redirect(add_query_arg(array(
                'page' => 'wc-settings',
                'tab' => rtwpvg()->settings_api()->get_setting_id(),
            ), admin_url('admin.php')));
        }
    }

    function delete_cache_data($product_id) {
        Functions::delete_transients($product_id);
    }

    function save_compat_video_field_via_ajax() {
        $post_id = $_POST['id'];
        if (isset($_POST['attachments'][$post_id]['rtwpvg_video_link'])) {
            $link = $_POST['attachments'][$post_id]['rtwpvg_video_link'];
            update_post_meta($post_id, 'rtwpvg_video_link', $link);

            clean_post_cache($post_id);
        }
    }

    /**
     * Update media custom field from edit media page (non ajax).
     *
     * @param $post_id
     */

    function save_compat_video_field($post_id) {
        if (isset($_POST['attachments'][$post_id]['rtwpvg_video_link'])) {
            $video = $_POST['attachments'][$post_id]['rtwpvg_video_link'];
            update_post_meta($post_id, 'rtwpvg_video_link', $video);
        }

        return;
    }   

    public function body_class($classes) {
        array_push($classes, 'rtwpvg');

        return array_unique($classes);
    }

    public function product_loop_post_class($classes, $class, $product_id) {

        if ('product' === get_post_type($product_id)) {
            $product = wc_get_product($product_id);
            if ($product->is_type('variable')) {
                $classes[] = 'rtwpvg-product';
            }
        }

        return $classes;
    }

    function rtwpvg_add_inline_style($styles) {
        $gallery_width = absint(apply_filters('rtwpvg_default_width', 30));
        if ($gallery_width > 99) {
            $styles['float'] = 'none';
            $styles['display'] = 'block';
        }

        return $styles;
    }

    public function woocommerce_show_product_images() {
        Functions::get_template('product-images');
    } 

    function gallery_template_override( $template, $template_name ) {
        
        $old_template = $template;
        
        // Disable gallery on specific product
        
        if ( apply_filters( 'disable_woo_variation_gallery', false ) ) {
            return $old_template;
        }
        
        if ( $template_name == 'single-product/product-image.php' ) {
            $template = rtwpvg()->locate_template('product-images');
        }
        
        if ( $template_name == 'single-product/product-thumbnails.php' ) {
            $template = rtwpvg()->locate_template('product-thumbnails');
        }
        
        return apply_filters( 'rtwpvg_gallery_template_override_location', $template, $template_name, $old_template );
    } 

    public function enable_theme_support() {
        add_theme_support('wc-product-gallery-zoom');
        add_theme_support('wc-product-gallery-lightbox');
    }

    public function remove_wc_default_template() {
        if (apply_filters('rtwpvg_remove_wc_default_template', true)) {
            remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 10);
            remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);
            remove_action('woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20);
            remove_action('woocommerce_before_single_product_summary_product_images', 'woocommerce_show_product_thumbnails', 20);
        }
    }

    public function save_variation_gallery($variation_id, $loop) {
        if (isset($_POST['rtwpvg'])) {
            if (isset($_POST['rtwpvg'][$variation_id])) {
                $rtwpvg_ids = (array)array_map('absint', $_POST['rtwpvg'][$variation_id]);
                update_post_meta($variation_id, 'rtwpvg_images', $rtwpvg_ids);
            } else {
                delete_post_meta($variation_id, 'rtwpvg_images');
            }
        } else {
            delete_post_meta($variation_id, 'rtwpvg_images');
        }
    }

    public function gallery_admin_html($loop, $variation_data, $variation) {
        $variation_id = absint($variation->ID);
        $gallery_images = get_post_meta($variation_id, 'rtwpvg_images', true);
        ?>
        <div class="form-row form-row-full rtwpvg-gallery-wrapper">
            <h4><?php esc_html_e('Variation Image Gallery', 'woo-product-variation-gallery') ?></h4>
            <div class="rtwpvg-image-container">
                <ul class="rtwpvg-images">
                    <?php
                    if (is_array($gallery_images) && !empty($gallery_images)) {
                        foreach ($gallery_images as $image_id):
                            $image = wp_get_attachment_image_src($image_id);
                            $video = get_post_meta($image_id, 'rtwpvg_video_link', true);
                            ?>
                            <li class="image<?php echo $video ? ' video' : null; ?>">
                                <input type="hidden" name="rtwpvg[<?php echo esc_attr($variation_id) ?>][]"
                                       value="<?php echo $image_id ?>">
                                <img src="<?php echo esc_url($image[0]) ?>">
                                <a href="#" class="delete rtwpvg-remove-image"><span
                                            class="dashicons dashicons-dismiss"></span></a>
                            </li>
                        <?php endforeach;
                    } ?>
                </ul>
            </div>
            <p class="rtwpvg-add-image-wrapper hide-if-no-js">
                <a href="#" data-product_variation_loop="<?php echo absint($loop) ?>"
                   data-product_variation_id="<?php echo esc_attr($variation_id) ?>"
                   class="button rtwpvg-add-image"><?php esc_html_e('Add Gallery Images', 'woo-product-variation-gallery') ?></a>
            </p>
        </div>
        <?php
    }


    /**
     * @param $available_variation
     * @param $variationProductObject
     * @param $variation
     *
     * @return string
     */
    public function available_variation_gallery($available_variation, $variationProductObject, $variation) {

        $product_id = absint($variation->get_parent_id());
        $variation_id = absint($variation->get_id());
        $variation_image_id = absint($variation->get_image_id());
        $has_variation_gallery_images = (bool)get_post_meta($variation_id, 'rtwpvg_images', true);
        if ($has_variation_gallery_images) {
            $gallery_images = (array)get_post_meta($variation_id, 'rtwpvg_images', true);
        } else {
            $gallery_images = $variationProductObject->get_gallery_image_ids();
        }

        $featured_thumbnail = rtwpvg()->get_option('remove_featured_thumbnail') ? false : true ;
        if ( apply_filters('rtwpvg_variation_gallery_images_enable_feature_image', $featured_thumbnail) ) {
            if ($variation_image_id) {
                array_unshift($gallery_images, $variation_image_id);
            } else {
                $parent_product = wc_get_product($product_id);
                $parent_product_image_id = $parent_product->get_image_id();

                if (!empty($parent_product_image_id)) {
                    array_unshift($gallery_images, $parent_product_image_id);
                }
            }
        }

        $available_variation['variation_gallery_images'] = array();

        foreach ($gallery_images as $i => $variation_gallery_image_id) {
            $available_variation['variation_gallery_images'][$i] = Functions::get_gallery_image_props($variation_gallery_image_id);
        }

        return apply_filters('rtwpvg_available_variation_gallery', $available_variation, $variation, $product_id);
    }

    public function get_default_gallery_images() {
        $product_id = isset($_POST['product_id']) ? absint($_POST['product_id']) : 0;
        $images = Functions::get_gallery_images($product_id);
        wp_send_json_success(apply_filters('rtwpvg_get_default_gallery_images', $images, $product_id));
    }

}