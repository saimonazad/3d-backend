<?php

namespace Rtwpvg\Helpers;

use WC_Data_Store;
use WC_Product;
use WC_Product_Variable;

class Functions
{
    /**
     * Slug
     *
     * @var string
     */
    public static $slug = 'rtwpvg';

    static function get_simple_embed_url($media_link) {
        // Youtube
        $re = '@https?://(www.)?youtube.com/watch\?v=([^&]+)@';
        $subst = 'https://www.youtube.com/embed/$2?feature=oembed';

        $link = preg_replace($re, $subst, $media_link, 1);

        // Vimeo
        $re = '@https?://(www.)?vimeo.com/([^/]+)@';
        $subst = 'https://player.vimeo.com/video/$2';

        $link = preg_replace($re, $subst, $link, 1);


        return apply_filters('rtwpvg_get_simple_embed_url', $link, $media_link);
    }

    public static function generate_inline_style($styles = array()) {

        $generated = array();
        if (!empty($styles)) {
            foreach ($styles as $property => $value) {
                $generated[] = "{$property}: $value";
            }
        }

        return implode('; ', array_unique(apply_filters('rtwpvg_generate_inline_style', $generated)));
    }


    public static function get_gallery_image_html($attachment_id, $options = array()) {
        $defaults = array('is_main_thumbnail' => false, 'has_only_thumbnail' => false);
        $options = wp_parse_args($options, $defaults);

        $image = self::get_gallery_image_props($attachment_id);
        $classes = apply_filters('rtwpvg_image_html_class', array(
            'rtwpvg-gallery-image',
        ), $attachment_id, $image);
        $has_video = trim(get_post_meta($attachment_id, 'rtwpvg_video_link', true));
        $type = wp_check_filetype($has_video);
        if ($has_video) {
            $classes[] = 'rtwpvg-gallery-video';
        }


        $template = '<div class="rtwpvg-single-image-container"><img width="%d" height="%d" src="%s" class="%s" alt="%s" title="%s" data-caption="%s" data-src="%s" data-large_image="%s" data-large_image_width="%d" data-large_image_height="%d" srcset="%s" sizes="%s" %s /></div>';

        $inner_html = sprintf($template, esc_attr($image['src_w']), esc_attr($image['src_h']), esc_url($image['src']), esc_attr($image['class']), esc_attr($image['alt']), esc_attr($image['title']), esc_attr($image['caption']), esc_url($image['full_src']), esc_url($image['full_src']), esc_attr($image['full_src_w']), esc_attr($image['full_src_h']), esc_attr($image['srcset']), esc_attr($image['sizes']), $image['extra_params']);

        $inner_html = apply_filters('rtwpvg_gallery_image_inner_html', $inner_html, $image, $template, $attachment_id, $options);


        if (!$options['is_main_thumbnail'] && !empty($has_video)) {
            $style = "width: 100%; height: 400px; margin: 0;padding: 0; background-color: #000";

            if (!empty($type['type'])) {
                $inner_html = sprintf('<video preload="auto" controls="" controlslist="nodownload" src="%s" style="%s"></video>',
                    $has_video,
                    $style
                );
            } else {
                $inner_html = sprintf('<iframe class="rtwpvg-lightbox-iframe" src="%s" style="%s" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>',
                    Functions::get_simple_embed_url($has_video),
                    $style
                );
            }
        }

        // If require thumbnail
        if (!$options['is_main_thumbnail']) {
            $classes = apply_filters('rtwpvg_thumbnail_image_html_class', array(
                'rtwpvg-thumbnail-image',
            ), $attachment_id, $image);
            if ($has_video) {
                $classes[] = 'rtwpvg-thumbnail-video';
            }
            $template = '<img width="%d" height="%d" src="%s" class="%s" alt="%s" title="%s" />';
            $inner_html = sprintf($template, esc_attr($image['gallery_thumbnail_src_w']), esc_attr($image['gallery_thumbnail_src_h']), esc_url($image['gallery_thumbnail_src']), esc_attr($image['gallery_thumbnail_class']), esc_attr($image['alt']), esc_attr($image['title']));
            $inner_html = apply_filters('rtwpvg_thumbnail_image_inner_html', $inner_html, $image, $template, $attachment_id, $options);
        }

        return '<div class="' . esc_attr(implode(' ', array_unique($classes))) . '"><div>' . $inner_html . '</div></div>';
    }


    public static function locate_template($name) {
        // Look within passed path within the theme - this is priority.
        $template = array(
            trailingslashit(rtwpvg()->dirname()) . "$name.php"
        );

        if (!$template_file = locate_template($template)) {
            $template_file = rtwpvg()->get_template_file_path($name);
        }

        return apply_filters('rtwpvg_locate_template', $template_file, $name);
    }

    static function get_template($fileName, $args = null) {

        if (!empty($args) && is_array($args)) {
            extract($args); // @codingStandardsIgnoreLine
        }

        $located = self::locate_template($fileName);


        if (!file_exists($located)) {
            /* translators: %s template */
            self::doing_it_wrong(__FUNCTION__, sprintf(__('%s does not exist.', 'classified-listing'), '<code>' . $located . '</code>'), '1.0');

            return;
        }

        // Allow 3rd party plugin filter template file from their plugin.
        $located = apply_filters('rtwpvg_get_template', $located, $fileName, $args);

        do_action('rtwpvg_before_template_part', $fileName, $located, $args);

        include $located;

        do_action('rtwpvg_after_template_part', $fileName, $located, $args);

    }

    static public function get_template_html($template_name, $args = null) {
        ob_start();
        self::get_template($template_name, $args);

        return ob_get_clean();

    }


    static function doing_it_wrong($function, $message, $version) {
        // @codingStandardsIgnoreStart
        $message .= ' Backtrace: ' . wp_debug_backtrace_summary();

        _doing_it_wrong($function, $message, $version);

    }

    public static function check_license() {
        return apply_filters('rtwpvg_check_license', true);
    }

    static function get_product_list_html($products = array()) {
        $html = null;
        if (!empty($products)) {
            $htmlProducts = null;
            foreach ($products as $key => $product) { 
                if ( function_exists('rtwpvgp') && $key == 'rtwpvg-pro') continue;

                $image_url = isset($product['image_url']) ? $product['image_url'] : null;
                $image_thumb_url = isset($product['image_thumb_url']) ? $product['image_thumb_url'] : null;
                $image_thumb_url = $image_thumb_url ? $image_thumb_url : $image_url;
                $price = isset($product['price']) ? $product['price'] : null;
                $title = isset($product['title']) ? $product['title'] : null;
                $url = isset($product['url']) ? $product['url'] : null;
                $buy_url = isset($product['buy_url']) ? $product['buy_url'] : null;
                $buy_url = $buy_url ? $buy_url : $url;
                $doc_url = isset($product['doc_url']) ? $product['doc_url'] : null;
                $demo_url = isset($product['demo_url']) ? $product['demo_url'] : null;
                $feature_list = null;
                $info_html = sprintf('<div class="rt-product-info">%s%s%s</div>',
                    $title ? sprintf("<h3 class='rt-product-title'><a href='%s' target='_blank'>%s</a></h3>", esc_url($url), $title) : null,
                    $feature_list,
                    $buy_url || $demo_url || $doc_url ?
                        sprintf(
                            '<div class="rt-product-action">%s%s%s</div>',
                            $buy_url ? sprintf('<a class="rt-admin-btn" href="%s" target="_blank">%s</a>', esc_url($buy_url), esc_html__('Buy', 'woo-product-variation-swatches')) : null,
                            $demo_url ? sprintf('<a class="rt-admin-btn" href="%s" target="_blank">%s</a>', esc_url($demo_url), esc_html__('Demo', 'woo-product-variation-swatches')) : null,
                            $doc_url ? sprintf('<a class="rt-doc button" href="%s" target="_blank">%s</a>', esc_url($doc_url), esc_html__('Documentation', 'woo-product-variation-swatches')) : null
                        )
                        : null
                );

                $htmlProducts .= sprintf(
                    '<div class="rt-product">%s%s</div>',
                    $image_thumb_url ? sprintf(
                        '<div class="rt-media"><img src="%s" alt="%s" /></div>',
                        esc_url($image_thumb_url),
                        esc_html($title)
                    ) : null,
                    $info_html
                );

            }

            $html = sprintf('<div class="rt-product-list">%s</div>', $htmlProducts);

        }

        return $html;
    }

    static function get_product_default_attributes($product_id) {

        $product = wc_get_product($product_id);

        if ($product && !$product->is_type('variable')) {
            return array();
        }

        $variable_product = new WC_Product_Variable(absint($product_id));

        return $variable_product->get_default_attributes();
    }

    static function get_product_default_variation_id($product, $attributes) {

        if (is_numeric($product)) {
            $product = wc_get_product($product);
        }

        if (!$product->is_type('variable')) {
            return 0;
        }

        foreach ($attributes as $key => $value) {
            if (strpos($key, 'attribute_') === 0) {
                continue;
            }

            unset($attributes[$key]);
            $attributes[sprintf('attribute_%s', $key)] = $value;
        }

        $data_store = WC_Data_Store::load('product');

        return $data_store->find_matching_product_variation($product, $attributes);
    }

    /**
     * @param $product_id int
     * @param $variation_id int
     * @return array|bool
     */
    public static function get_product_variation($product_id, $variation_id) {
        $variable_product = new WC_Product_Variable(absint($product_id));
        return $variable_product->get_available_variation(absint($variation_id));
    }

    /**
     * @param $product_id
     * @return mixed|void
     */
    public static function get_gallery_images($product_id) {
        $transient_name = Functions::get_transient_name($product_id, "default-images");
        if (false === ($images = get_transient($transient_name))) {
            $product = wc_get_product($product_id);
            $product_id = $product->get_id();
            $attachment_ids = $product->get_gallery_image_ids();
            $post_thumbnail_id = $product->get_image_id();
            $images = array();

            $post_thumbnail_id = (int)apply_filters('rtwpvg_post_thumbnail_id', $post_thumbnail_id, $attachment_ids, $product);
            $attachment_ids = (array)apply_filters('rtwpvg_attachment_ids', $attachment_ids, $post_thumbnail_id, $product);

            if (!empty($post_thumbnail_id)) {
                array_unshift($attachment_ids, $post_thumbnail_id);
            }

            if (is_array($attachment_ids) && !empty($attachment_ids)) {
                foreach ($attachment_ids as $i => $image_id) {
                    $images[$i] = Functions::get_gallery_image_props($image_id);
                }
            }

            set_transient($transient_name, $images, 12 * HOUR_IN_SECONDS);
        }

        return apply_filters('rtwpvg_get_gallery_images', $images, $product_id);
    }

    /**
     * Helper: WPML - Get original variation ID
     *
     * If WPML is active and this is a translated variaition, get the original ID.
     *
     * @param int $id
     *
     * @return int
     */
    public static function wpml_get_original_variation_id($id) {
        $wpml_original_variation_id = get_post_meta($id, '_wcml_duplicate_of_variation', true);

        if ($wpml_original_variation_id) {
            $id = $wpml_original_variation_id;
        }

        return $id;
    }

    /**
     * Helper: Get all images transient name for specific variation/product
     *
     * @param int $id
     * @param string $type
     *
     * @return string
     */
    public static function get_transient_name($id, $type) {
        if ($type === "default-images") {
            $id = self::wpml_get_original_variation_id($id);
            $transient_name = sprintf("%s_default_images_%d", self::$slug, $id);
        } elseif ($type === "sizes") {
            $transient_name = sprintf("%s_variation_image_sizes_%d", self::$slug, $id);
        } elseif ($type === "variation") {
            $transient_name = sprintf("%s_variation_%d", self::$slug, $id);
        } else {
            $transient_name = false;
        }

        return apply_filters('rtwpvg_transient_name', $transient_name, $type, $id);
    }


    /**
     * Helper: Delete all transient
     *
     * @param bool $product_id
     * @param string $type
     */
    public static function delete_transients($product_id = false, $type = '') {
        if ($product_id) {
            if ($type) {
                $default_transient_name = self::get_transient_name($product_id, $type);
                delete_transient($default_transient_name);
            } else {
                $default_transient_name = self::get_transient_name($product_id, "default-images");
                delete_transient($default_transient_name);
            }
        }
    }

    /**
     * @param $attachment_id
     * @param bool $product_id
     * @return mixed|void
     */
    static function get_gallery_image_props($attachment_id, $product_id = false) {
        $props = array(
            'image_id' => '',
            'title' => '',
            'caption' => '',
            'url' => '',
            'alt' => '',
            'full_src' => '',
            'full_src_w' => '',
            'full_src_h' => '',
            'full_class' => '',
            //'full_srcset'              => '',
            //'full_sizes'               => '',
            'gallery_thumbnail_src' => '',
            'gallery_thumbnail_src_w' => '',
            'gallery_thumbnail_src_h' => '',
            'gallery_thumbnail_class' => '',
            //'gallery_thumbnail_srcset' => '',
            //'gallery_thumbnail_sizes'  => '',
            'archive_src' => '',
            'archive_src_w' => '',
            'archive_src_h' => '',
            'archive_class' => '',
            //'archive_srcset'           => '',
            //'archive_sizes'            => '',
            'src' => '',
            'class' => '',
            'src_w' => '',
            'src_h' => '',
            'srcset' => '',
            'sizes' => '',
        );
        $attachment = get_post($attachment_id);

        if ($attachment) {

            $props['image_id'] = $attachment_id;
            $props['title'] = _wp_specialchars(get_post_field('post_title', $attachment_id), ENT_QUOTES, 'UTF-8', true);
            $props['caption'] = _wp_specialchars(get_post_field('post_excerpt', $attachment_id), ENT_QUOTES, 'UTF-8', true);
            $props['url'] = wp_get_attachment_url($attachment_id);

            // Alt text.
            $alt_text = array(trim(wp_strip_all_tags(get_post_meta($attachment_id, '_wp_attachment_image_alt', true))), $props['caption'], wp_strip_all_tags($attachment->post_title));

            if ($product_id) {
                $product = wc_get_product($product_id);
                $alt_text[] = wp_strip_all_tags(get_the_title($product->get_id()));
            }

            $alt_text = array_filter($alt_text);
            $props['alt'] = isset($alt_text[0]) ? $alt_text[0] : '';

            // Large version.
            $full_size = apply_filters('woocommerce_gallery_full_size', apply_filters('woocommerce_product_thumbnails_large_size', 'full'));
            $full_size_src = wp_get_attachment_image_src($attachment_id, $full_size);
            $props['full_src'] = esc_url($full_size_src[0]);
            $props['full_src_w'] = esc_attr($full_size_src[1]);
            $props['full_src_h'] = esc_attr($full_size_src[2]);

            $full_size_class = $full_size;
            if (is_array($full_size_class)) {
                $full_size_class = implode('x', $full_size_class);
            }

            $props['full_class'] = "attachment-$full_size_class size-$full_size_class";
            //$props[ 'full_srcset' ] = wp_get_attachment_image_srcset( $attachment_id, $full_size );
            //$props[ 'full_sizes' ]  = wp_get_attachment_image_sizes( $attachment_id, $full_size );


            // Gallery thumbnail.
            $gallery_thumbnail = wc_get_image_size('gallery_thumbnail');
            $gallery_thumbnail_size = apply_filters('woocommerce_gallery_thumbnail_size', array($gallery_thumbnail['width'], $gallery_thumbnail['height']));
            $gallery_thumbnail_src = wp_get_attachment_image_src($attachment_id, $gallery_thumbnail_size);
            $props['gallery_thumbnail_src'] = esc_url($gallery_thumbnail_src[0]);
            $props['gallery_thumbnail_src_w'] = esc_attr($gallery_thumbnail_src[1]);
            $props['gallery_thumbnail_src_h'] = esc_attr($gallery_thumbnail_src[2]);

            $gallery_thumbnail_class = $gallery_thumbnail_size;
            if (is_array($gallery_thumbnail_class)) {
                $gallery_thumbnail_class = implode('x', $gallery_thumbnail_class);
            }

            $props['gallery_thumbnail_class'] = "attachment-$gallery_thumbnail_class size-$gallery_thumbnail_class";
            //$props[ 'gallery_thumbnail_srcset' ] = wp_get_attachment_image_srcset( $attachment_id, $gallery_thumbnail );
            //$props[ 'gallery_thumbnail_sizes' ]  = wp_get_attachment_image_sizes( $attachment_id, $gallery_thumbnail );


            // Archive/Shop Page version.
            $thumbnail_size = apply_filters('woocommerce_thumbnail_size', 'woocommerce_thumbnail');
            $thumbnail_size_src = wp_get_attachment_image_src($attachment_id, $thumbnail_size);
            $props['archive_src'] = esc_url($thumbnail_size_src[0]);
            $props['archive_src_w'] = esc_attr($thumbnail_size_src[1]);
            $props['archive_src_h'] = esc_attr($thumbnail_size_src[2]);

            $archive_thumbnail_class = $thumbnail_size;
            if (is_array($archive_thumbnail_class)) {
                $archive_thumbnail_class = implode('x', $archive_thumbnail_class);
            }

            $props['archive_class'] = "attachment-$archive_thumbnail_class size-$archive_thumbnail_class";
            //$props[ 'archive_srcset' ] = wp_get_attachment_image_srcset( $attachment_id, $thumbnail_size );
            //$props[ 'archive_sizes' ]  = wp_get_attachment_image_sizes( $attachment_id, $thumbnail_size );


            // Image source.
            $image_size = apply_filters('woocommerce_gallery_image_size', 'woocommerce_single');
            $src = wp_get_attachment_image_src($attachment_id, $image_size);
            $props['src'] = esc_url($src[0]);
            $props['src_w'] = esc_attr($src[1]);
            $props['src_h'] = esc_attr($src[2]);

            $image_size_class = $image_size;
            if (is_array($image_size_class)) {
                $image_size_class = implode('x', $image_size_class);
            }
            $props['class'] = "wp-post-image rtwpvg-post-image attachment-$image_size_class size-$image_size_class ";
            $props['srcset'] = wp_get_attachment_image_srcset($attachment_id, $image_size);
            $props['sizes'] = wp_get_attachment_image_sizes($attachment_id, $image_size);

            $props['extra_params'] = self::array_to_html_attributes(apply_filters('rtwpvg_image_extra_params', array(), $props, $attachment_id, $product_id));

        }

        return apply_filters('rtwpvg_get_image_props', $props, $attachment_id, $product_id);
    }

    static function array_to_html_attributes($attrs) {
        return implode(' ', array_map(function ($key, $value) {

            if (is_bool($value)) {
                return $key;
            } else {
                if (wc_is_valid_url($value)) {
                    $value = esc_url($value);
                } else {
                    $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
                }

                return $key . '="' . $value . '"';
            }
        }, array_keys($attrs), $attrs));
    }

    /**
     * @param $id
     * @return \WC_Product_Variation
     */
    public static function get_product($id) {
        $post_type = get_post_type($id);

        if ($post_type !== "product_variation") {
            return wc_get_product(absint($id));
        }

        if (version_compare(WC_VERSION, '2.7', '<')) {
            return wc_get_product(absint($id), array('product_type' => 'variable'));
        } else {
            return new \WC_Product_Variation(absint($id));
        }
    }


    /**
     * Get gallery image IDs
     *
     * @param WC_Product $product
     *
     * @return array
     */
    public static function get_gallery_image_ids($product) {
        return method_exists($product, 'get_gallery_image_ids') ? $product->get_gallery_image_ids() : $product->get_gallery_attachment_ids();
    }

    /**
     * Helper: Get all image IDs for a specifc variation
     *
     * @param int $id
     *
     * @return array
     */
    public function get_all_image_ids($id) {
        $transient_name = $this->get_transient_name($id, "all-images");

        if (false === ($image_ids = get_transient($transient_name))) {
            $image_ids = array();
            $product = self::get_product($id);
            $product_image = $product->get_image_id();

            // Add featured image.
            if (!empty($product_image)) {
                $image_ids['featured'] = $product_image;
            }

            // Add gallery images.
            $image_ids = array_merge($image_ids, self::get_gallery_image_ids($product));

            // Set placeholder or parent images if no images present.
            if (empty($image_ids)) {
                $parent_id = Iconic_WooThumbs_Product::get_parent_id($product);

                if ($parent_id > 0) {
                    $image_ids = $this->get_all_image_ids($parent_id);
                } else {
                    $image_ids['featured'] = 'placeholder';
                }
            }

            set_transient($transient_name, $image_ids, 12 * HOUR_IN_SECONDS);
        }

        $image_ids = array_map(array($this, 'get_translated_media_id'), $image_ids);

        return apply_filters('iconic_woothumbs_all_image_ids', $image_ids, $id);
    }

    /**
     * Helper: Get all image sizes
     *
     * @param int $product_id
     *
     * @return array
     */
    public function get_all_image_sizes($product_id) {
        $image_ids = $this->get_all_image_ids(absint($product_id));
        $images = array();

        if (!empty($image_ids)) {
            foreach ($image_ids as $image_id):

                $transient_name = $this->get_transient_name($image_id, "sizes");

                if (false === ($image_data = get_transient($transient_name))) {
                    $image_data = Iconic_WooThumbs_Images::get_attachment_props($image_id);
                    $image_data = apply_filters('iconic_woothumbs_single_image_data', $image_data, $image_id, $product_id);

                    set_transient($transient_name, $image_data, 12 * HOUR_IN_SECONDS);
                }

                if ($image_data) {
                    $images[] = $image_data;
                }

            endforeach;
        }

        return apply_filters('iconic_woothumbs_all_images_data', $images, $product_id);
    }

}