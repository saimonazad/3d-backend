<?php

namespace ShopEngine\Modules\Wishlist;

use ShopEngine\Core\Register\Module_List;
use ShopEngine\Traits\Singleton;
use ShopEngine\Utils\Helper;

class Wishlist {

	const COOKIE_KEY = 'shopengine_wishlist_offline';
	const UMK_WISHLIST = 'shopengine_wishlist';
	const ONCLICK_SELECTOR_CLS = 'shopengine_add_to_list_action';

	use Singleton;

	public function init() {

		new Route();

		$sett              = Module_List::instance()->get_settings('wishlist');
		$is_show_in_single = isset($sett['show_on_single_page']['value']) ? ($sett['show_on_single_page']['value'] === 'yes') : true;

		if($is_show_in_single === true) {

			if($this->get_where_to($sett) === 'after') {

				add_action('woocommerce_after_add_to_cart_button', [$this, 'print_wish_button'], 10, 0);

			} else {

				add_action('woocommerce_before_add_to_cart_button', [$this, 'print_wish_button'], 10, 0);
			}
		}


		$is_show = isset($sett['show_on_archive_page']['value']) ? ($sett['show_on_archive_page']['value'] === 'yes') : true;

		$show_in_archive = apply_filters('shopengine/module/wishlist/show_icon_in_shop_page', $is_show);

		if($show_in_archive === true) {

			add_filter('woocommerce_loop_add_to_cart_link', [$this, 'print_button_in_shop'], 10, 3);
		}

		add_action('wp_enqueue_scripts', [$this, 'enqueue']);


		if(is_user_logged_in()) {

			if(!empty($_COOKIE[Wishlist::COOKIE_KEY])) {

				$uid = get_current_user_id();

				$content = get_user_meta($uid, self::UMK_WISHLIST, true);
				$content = empty($content) ? [] : $content;

				$cck = explode(',', $_COOKIE[Wishlist::COOKIE_KEY]);

				foreach($cck as $pid) {

					$content[$pid] = $pid;
				}

				update_user_meta($uid, self::UMK_WISHLIST, $content);

				setcookie(Wishlist::COOKIE_KEY, '', time() - 3600);
			}
		}


		add_action('init', function () {
			add_rewrite_endpoint('wishlist', EP_ROOT | EP_PAGES);
		});

		add_filter('woocommerce_account_menu_items', [$this, 'add_to_menu'], 40);
		add_action('woocommerce_account_wishlist_endpoint', [$this, 'wishlist_content']);
	}


	public function enqueue() {

		wp_enqueue_style('shopengine-wishlist', plugin_dir_url(__FILE__) . 'assets/css/wishlist.css', [], \ShopEngine::version());

		wp_enqueue_script(
			'shopengine-wishlist',
			plugin_dir_url(__FILE__) . '/assets/js/wishlist.js',
			['jquery']
		);

		wp_localize_script('shopengine-wishlist', 'shopEngineWishlist', [
			'product_id' => get_the_ID(),
			'resturl'    => get_rest_url(),
			'isLoggedIn' => is_user_logged_in(),
			'rest_nonce' => wp_create_nonce('wp_rest'),
		]);
	}


	/**
	 *
	 * @return mixed - only other exact value we are expecting is after!
	 */
	public function get_where_to($settings = []) {

		$position = !empty($settings['show_icon_where_to']['value']) ? $settings['show_icon_where_to']['value'] : 'before';

		return apply_filters('shopengine/module/wishlist/put_icon_in_side', $position);
	}


	private function is_exists_in_wishlist($idd) {

		if(is_user_logged_in()) {

			$content = get_user_meta(get_current_user_id(), self::UMK_WISHLIST, true);

			return isset($content[$idd]);
		}

		if(empty($_COOKIE[Wishlist::COOKIE_KEY])) {
			return false;
		}

		$content = explode(',', $_COOKIE[Wishlist::COOKIE_KEY]);

		return in_array($idd, $content);
	}


	public function print_wish_button() {

		$pid   = get_the_ID();
		$exist = $this->is_exists_in_wishlist($pid);
		$prop  = $exist ? 'darkorange' : 'none';
		$cls   = $exist ? 'active' : 'inactive';

		$left_text  = apply_filters('shopengine/module/wishlist/optional_text_left', '');
		$right_text = apply_filters('shopengine/module/wishlist/optional_text_right', '');

		?>

        <a
                class="<?php echo self::ONCLICK_SELECTOR_CLS ?> shopengine-wishlist badge <?php echo esc_attr($cls) ?>"
                data-pid="<?php echo intval($pid) ?>"
                href="#"
        >
			<?php echo Helper::kses($left_text) ?>
            <i class="shopengine-icon-add_to_favourite_1"></i>
			<?php echo Helper::kses($right_text) ?>
        </a>

		<?php
	}


	function print_button_in_shop($add_to_cart_html, $product, $args = []) {

		$sett = Module_List::instance()->get_settings('wishlist');

		$exist = $this->is_exists_in_wishlist($product->get_id());
		$prop  = $exist ? 'darkorange' : 'none';
		$cls   = $exist ? 'active' : 'inactive';

		$left_text  = apply_filters('shopengine/module/wishlist/optional_text_left', '');
		$right_text = apply_filters('shopengine/module/wishlist/optional_text_right', '');

		$btn = '<a 
        data-pid="' . $product->get_id() . '" 
        class="' . self::ONCLICK_SELECTOR_CLS . ' shopengine-wishlist badge se-btn ' . esc_attr($cls) . '" 
        href="#" >' .
			$left_text .
			'<i class="shopengine-icon-add_to_favourite_1"></i>' .
			$right_text . '</a>';


		if($this->get_where_to($sett) == 'after') {

			$before = '';
			$after  = $btn;

		} else {

			$before = $btn;
			$after  = '';
		}

		return $before . $add_to_cart_html . $after;
	}


	public function add_to_menu($menu_links) {

		$menu_links['wishlist'] = esc_html__('Wishlist', 'shopengine');

		if(isset($menu_links['customer-logout'])) {

			$logout = $menu_links['customer-logout'];
			unset($menu_links['customer-logout']);
			$menu_links['customer-logout'] = $logout;
		} else {
			$menu_links['customer-logout'] = esc_html__('Logout', 'shopengine');
		}

		return $menu_links;
	}

	public function wishlist_content() {

		$list = get_user_meta(get_current_user_id(), Wishlist::UMK_WISHLIST, true);

		include __DIR__ . '/screens/default.php';
	}
}
