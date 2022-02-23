<?php

namespace ShopEngine\Core\Page_Templates\Hooks;

use ShopEngine\Widgets\Widget_Helper;

defined('ABSPATH') || exit;

class Checkout extends Base {

	protected $page_type = 'checkout';
	protected $template_part = 'content-checkout.php';

	public function init(): void {

		/**
		 * add product thumbnail in checkout page
		 */
		if(!is_cart()) {
			add_action( 'woocommerce_cart_item_name', [ $this, 'add_product_thumbnail' ], 10, 4 );
			add_action( 'woocommerce_cart_item_class', [ $this, 'add_css_class_to_product_tr' ], 10, 3 );
		}

		Widget_Helper::instance()->wc_template_replace_multiple(
			[
				'checkout/review-order.php',
				'checkout/payment-method.php',
			]
		);

		remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10);

		remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form');


        /**
         * Remove checkout template extra markup;
         */
        remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10);


	}

	public function add_css_class_to_product_tr($css_class , $cart_item, $cart_item_key){

		return  $css_class.' shopengine-order-review-product';
	}

	public function add_product_thumbnail( $product_name, $cart_item, $cart_item_key){
		$product_id =  isset( $cart_item['variation_id'] ) && $cart_item['variation_id'] ? $cart_item['variation_id'] : $cart_item['product_id'] ;

		$image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), 'single-post-thumbnail' );
		$thumbnail =  $image_url[0] ?? null;

		return     "<img src='{$thumbnail}'/>".$product_name;
	}

	protected function get_page_type_option_slug(): string {

		return !empty($_REQUEST['shopengine_quick_checkout']) && $_REQUEST['shopengine_quick_checkout'] === 'modal-content' ? 'quick_checkout' : $this->page_type;
	}

	protected function template_include_pre_condition(): bool {

		return   (is_checkout() && !is_wc_endpoint_url('order-received')) || (isset($_REQUEST['wc-ajax']) &&  $_REQUEST['wc-ajax'] == 'update_order_review');
	}
}
