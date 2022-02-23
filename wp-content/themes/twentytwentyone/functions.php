<?php
/**
 * Functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */
add_filter('auto_update_theme', '__return_false');
// This theme requires WordPress 5.3 or later.
if (version_compare($GLOBALS['wp_version'], '5.3', '<')) {
    require get_template_directory() . '/inc/back-compat.php';
}

if (!function_exists('twenty_twenty_one_setup')) {
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     *
     * @return void
     * @since Twenty Twenty-One 1.0
     *
     */
    function twenty_twenty_one_setup()
    {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on Twenty Twenty-One, use a find and replace
         * to change 'twentytwentyone' to the name of your theme in all the template files.
         */
        load_theme_textdomain('twentytwentyone', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         * This theme does not use a hard-coded <title> tag in the document head,
         * WordPress will provide it for us.
         */
        add_theme_support('title-tag');

        /**
         * Add post-formats support.
         */
        add_theme_support(
            'post-formats',
            array(
                'link',
                'aside',
                'gallery',
                'image',
                'quote',
                'status',
                'video',
                'audio',
                'chat',
            )
        );

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support('post-thumbnails');
        set_post_thumbnail_size(1568, 9999);

        register_nav_menus(
            array(
                'primary' => esc_html__('Primary menu', 'twentytwentyone'),
                'footer' => __('Secondary menu', 'twentytwentyone'),
            )
        );

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support(
            'html5',
            array(
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
                'style',
                'script',
                'navigation-widgets',
            )
        );

        /**
         * Add support for core custom logo.
         *
         * @link https://codex.wordpress.org/Theme_Logo
         */
        $logo_width = 300;
        $logo_height = 100;

        add_theme_support(
            'custom-logo',
            array(
                'height' => $logo_height,
                'width' => $logo_width,
                'flex-width' => true,
                'flex-height' => true,
                'unlink-homepage-logo' => true,
            )
        );

        // Add theme support for selective refresh for widgets.
        add_theme_support('customize-selective-refresh-widgets');

        // Add support for Block Styles.
        add_theme_support('wp-block-styles');

        // Add support for full and wide align images.
        add_theme_support('align-wide');

        // Add support for editor styles.
        add_theme_support('editor-styles');
        $background_color = get_theme_mod('background_color', 'D1E4DD');
        if (127 > Twenty_Twenty_One_Custom_Colors::get_relative_luminance_from_hex($background_color)) {
            add_theme_support('dark-editor-style');
        }

        $editor_stylesheet_path = './assets/css/style-editor.css';

        // Note, the is_IE global variable is defined by WordPress and is used
        // to detect if the current browser is internet explorer.
        global $is_IE;
        if ($is_IE) {
            $editor_stylesheet_path = './assets/css/ie-editor.css';
        }

        // Enqueue editor styles.
        add_editor_style($editor_stylesheet_path);

        // Add custom editor font sizes.
        add_theme_support(
            'editor-font-sizes',
            array(
                array(
                    'name' => esc_html__('Extra small', 'twentytwentyone'),
                    'shortName' => esc_html_x('XS', 'Font size', 'twentytwentyone'),
                    'size' => 16,
                    'slug' => 'extra-small',
                ),
                array(
                    'name' => esc_html__('Small', 'twentytwentyone'),
                    'shortName' => esc_html_x('S', 'Font size', 'twentytwentyone'),
                    'size' => 18,
                    'slug' => 'small',
                ),
                array(
                    'name' => esc_html__('Normal', 'twentytwentyone'),
                    'shortName' => esc_html_x('M', 'Font size', 'twentytwentyone'),
                    'size' => 20,
                    'slug' => 'normal',
                ),
                array(
                    'name' => esc_html__('Large', 'twentytwentyone'),
                    'shortName' => esc_html_x('L', 'Font size', 'twentytwentyone'),
                    'size' => 24,
                    'slug' => 'large',
                ),
                array(
                    'name' => esc_html__('Extra large', 'twentytwentyone'),
                    'shortName' => esc_html_x('XL', 'Font size', 'twentytwentyone'),
                    'size' => 40,
                    'slug' => 'extra-large',
                ),
                array(
                    'name' => esc_html__('Huge', 'twentytwentyone'),
                    'shortName' => esc_html_x('XXL', 'Font size', 'twentytwentyone'),
                    'size' => 96,
                    'slug' => 'huge',
                ),
                array(
                    'name' => esc_html__('Gigantic', 'twentytwentyone'),
                    'shortName' => esc_html_x('XXXL', 'Font size', 'twentytwentyone'),
                    'size' => 144,
                    'slug' => 'gigantic',
                ),
            )
        );

        // Custom background color.
        add_theme_support(
            'custom-background',
            array(
                'default-color' => 'd1e4dd',
            )
        );

        // Editor color palette.
        $black = '#000000';
        $dark_gray = '#28303D';
        $gray = '#39414D';
        $green = '#D1E4DD';
        $blue = '#D1DFE4';
        $purple = '#D1D1E4';
        $red = '#E4D1D1';
        $orange = '#E4DAD1';
        $yellow = '#EEEADD';
        $white = '#FFFFFF';

        add_theme_support(
            'editor-color-palette',
            array(
                array(
                    'name' => esc_html__('Black', 'twentytwentyone'),
                    'slug' => 'black',
                    'color' => $black,
                ),
                array(
                    'name' => esc_html__('Dark gray', 'twentytwentyone'),
                    'slug' => 'dark-gray',
                    'color' => $dark_gray,
                ),
                array(
                    'name' => esc_html__('Gray', 'twentytwentyone'),
                    'slug' => 'gray',
                    'color' => $gray,
                ),
                array(
                    'name' => esc_html__('Green', 'twentytwentyone'),
                    'slug' => 'green',
                    'color' => $green,
                ),
                array(
                    'name' => esc_html__('Blue', 'twentytwentyone'),
                    'slug' => 'blue',
                    'color' => $blue,
                ),
                array(
                    'name' => esc_html__('Purple', 'twentytwentyone'),
                    'slug' => 'purple',
                    'color' => $purple,
                ),
                array(
                    'name' => esc_html__('Red', 'twentytwentyone'),
                    'slug' => 'red',
                    'color' => $red,
                ),
                array(
                    'name' => esc_html__('Orange', 'twentytwentyone'),
                    'slug' => 'orange',
                    'color' => $orange,
                ),
                array(
                    'name' => esc_html__('Yellow', 'twentytwentyone'),
                    'slug' => 'yellow',
                    'color' => $yellow,
                ),
                array(
                    'name' => esc_html__('White', 'twentytwentyone'),
                    'slug' => 'white',
                    'color' => $white,
                ),
            )
        );

        add_theme_support(
            'editor-gradient-presets',
            array(
                array(
                    'name' => esc_html__('Purple to yellow', 'twentytwentyone'),
                    'gradient' => 'linear-gradient(160deg, ' . $purple . ' 0%, ' . $yellow . ' 100%)',
                    'slug' => 'purple-to-yellow',
                ),
                array(
                    'name' => esc_html__('Yellow to purple', 'twentytwentyone'),
                    'gradient' => 'linear-gradient(160deg, ' . $yellow . ' 0%, ' . $purple . ' 100%)',
                    'slug' => 'yellow-to-purple',
                ),
                array(
                    'name' => esc_html__('Green to yellow', 'twentytwentyone'),
                    'gradient' => 'linear-gradient(160deg, ' . $green . ' 0%, ' . $yellow . ' 100%)',
                    'slug' => 'green-to-yellow',
                ),
                array(
                    'name' => esc_html__('Yellow to green', 'twentytwentyone'),
                    'gradient' => 'linear-gradient(160deg, ' . $yellow . ' 0%, ' . $green . ' 100%)',
                    'slug' => 'yellow-to-green',
                ),
                array(
                    'name' => esc_html__('Red to yellow', 'twentytwentyone'),
                    'gradient' => 'linear-gradient(160deg, ' . $red . ' 0%, ' . $yellow . ' 100%)',
                    'slug' => 'red-to-yellow',
                ),
                array(
                    'name' => esc_html__('Yellow to red', 'twentytwentyone'),
                    'gradient' => 'linear-gradient(160deg, ' . $yellow . ' 0%, ' . $red . ' 100%)',
                    'slug' => 'yellow-to-red',
                ),
                array(
                    'name' => esc_html__('Purple to red', 'twentytwentyone'),
                    'gradient' => 'linear-gradient(160deg, ' . $purple . ' 0%, ' . $red . ' 100%)',
                    'slug' => 'purple-to-red',
                ),
                array(
                    'name' => esc_html__('Red to purple', 'twentytwentyone'),
                    'gradient' => 'linear-gradient(160deg, ' . $red . ' 0%, ' . $purple . ' 100%)',
                    'slug' => 'red-to-purple',
                ),
            )
        );

        /*
        * Adds starter content to highlight the theme on fresh sites.
        * This is done conditionally to avoid loading the starter content on every
        * page load, as it is a one-off operation only needed once in the customizer.
        */
        if (is_customize_preview()) {
            require get_template_directory() . '/inc/starter-content.php';
            add_theme_support('starter-content', twenty_twenty_one_get_starter_content());
        }

        // Add support for responsive embedded content.
        add_theme_support('responsive-embeds');

        // Add support for custom line height controls.
        add_theme_support('custom-line-height');

        // Add support for experimental link color control.
        add_theme_support('experimental-link-color');

        // Add support for experimental cover block spacing.
        add_theme_support('custom-spacing');

        // Add support for custom units.
        // This was removed in WordPress 5.6 but is still required to properly support WP 5.5.
        add_theme_support('custom-units');
    }
}
add_action('after_setup_theme', 'twenty_twenty_one_setup');

/**
 * Register widget area.
 *
 * @return void
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 *
 * @since Twenty Twenty-One 1.0
 *
 */
function twenty_twenty_one_widgets_init()
{

    register_sidebar(
        array(
            'name' => esc_html__('Footer', 'twentytwentyone'),
            'id' => 'sidebar-1',
            'description' => esc_html__('Add widgets here to appear in your footer.', 'twentytwentyone'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h2 class="widget-title">',
            'after_title' => '</h2>',
        )
    );
}

add_action('widgets_init', 'twenty_twenty_one_widgets_init');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @return void
 * @global int $content_width Content width.
 *
 * @since Twenty Twenty-One 1.0
 *
 */
function twenty_twenty_one_content_width()
{
    // This variable is intended to be overruled from themes.
    // Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
    // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
    $GLOBALS['content_width'] = apply_filters('twenty_twenty_one_content_width', 750);
}

add_action('after_setup_theme', 'twenty_twenty_one_content_width', 0);

/**
 * Enqueue scripts and styles.
 *
 * @return void
 * @since Twenty Twenty-One 1.0
 *
 */
function twenty_twenty_one_scripts()
{
    // Note, the is_IE global variable is defined by WordPress and is used
    // to detect if the current browser is internet explorer.
    global $is_IE, $wp_scripts;
    if ($is_IE) {
        // If IE 11 or below, use a flattened stylesheet with static values replacing CSS Variables.
        wp_enqueue_style('twenty-twenty-one-style', get_template_directory_uri() . '/assets/css/ie.css', array(), wp_get_theme()->get('Version'));
    } else {
        // If not IE, use the standard stylesheet.
        wp_enqueue_style('twenty-twenty-one-style', get_template_directory_uri() . '/style.css', array(), wp_get_theme()->get('Version'));
    }

    // RTL styles.
    wp_style_add_data('twenty-twenty-one-style', 'rtl', 'replace');

    // Print styles.
    wp_enqueue_style('twenty-twenty-one-print-style', get_template_directory_uri() . '/assets/css/print.css', array(), wp_get_theme()->get('Version'), 'print');

    // Threaded comment reply styles.
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    // Register the IE11 polyfill file.
    wp_register_script(
        'twenty-twenty-one-ie11-polyfills-asset',
        get_template_directory_uri() . '/assets/js/polyfills.js',
        array(),
        wp_get_theme()->get('Version'),
        true
    );

    // Register the IE11 polyfill loader.
    wp_register_script(
        'twenty-twenty-one-ie11-polyfills',
        null,
        array(),
        wp_get_theme()->get('Version'),
        true
    );
    wp_add_inline_script(
        'twenty-twenty-one-ie11-polyfills',
        wp_get_script_polyfill(
            $wp_scripts,
            array(
                'Element.prototype.matches && Element.prototype.closest && window.NodeList && NodeList.prototype.forEach' => 'twenty-twenty-one-ie11-polyfills-asset',
            )
        )
    );

    // Main navigation scripts.
    if (has_nav_menu('primary')) {
        wp_enqueue_script(
            'twenty-twenty-one-primary-navigation-script',
            get_template_directory_uri() . '/assets/js/primary-navigation.js',
            array('twenty-twenty-one-ie11-polyfills'),
            wp_get_theme()->get('Version'),
            true
        );
    }

    // Responsive embeds script.
    wp_enqueue_script(
        'twenty-twenty-one-responsive-embeds-script',
        get_template_directory_uri() . '/assets/js/responsive-embeds.js',
        array('twenty-twenty-one-ie11-polyfills'),
        wp_get_theme()->get('Version'),
        true
    );
}

add_action('wp_enqueue_scripts', 'twenty_twenty_one_scripts');

/**
 * Enqueue block editor script.
 *
 * @return void
 * @since Twenty Twenty-One 1.0
 *
 */
function twentytwentyone_block_editor_script()
{

    wp_enqueue_script('twentytwentyone-editor', get_theme_file_uri('/assets/js/editor.js'), array('wp-blocks', 'wp-dom'), wp_get_theme()->get('Version'), true);
}

add_action('enqueue_block_editor_assets', 'twentytwentyone_block_editor_script');

/**
 * Fix skip link focus in IE11.
 *
 * This does not enqueue the script because it is tiny and because it is only for IE11,
 * thus it does not warrant having an entire dedicated blocking script being loaded.
 *
 * @link https://git.io/vWdr2
 */
function twenty_twenty_one_skip_link_focus_fix()
{

    // If SCRIPT_DEBUG is defined and true, print the unminified file.
    if (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) {
        echo '<script>';
        include get_template_directory() . '/assets/js/skip-link-focus-fix.js';
        echo '</script>';
    }

    // The following is minified via `npx terser --compress --mangle -- assets/js/skip-link-focus-fix.js`.
    ?>
    <script>
        /(trident|msie)/i.test(navigator.userAgent) && document.getElementById && window.addEventListener && window.addEventListener("hashchange", (function () {
            var t, e = location.hash.substring(1);
            /^[A-z0-9_-]+$/.test(e) && (t = document.getElementById(e)) && (/^(?:a|select|input|button|textarea)$/i.test(t.tagName) || (t.tabIndex = -1), t.focus())
        }), !1);
    </script>
    <?php
}

add_action('wp_print_footer_scripts', 'twenty_twenty_one_skip_link_focus_fix');

/** Enqueue non-latin language styles
 *
 * @return void
 * @since Twenty Twenty-One 1.0
 *
 */
function twenty_twenty_one_non_latin_languages()
{
    $custom_css = twenty_twenty_one_get_non_latin_css('front-end');

    if ($custom_css) {
        wp_add_inline_style('twenty-twenty-one-style', $custom_css);
    }
}

add_action('wp_enqueue_scripts', 'twenty_twenty_one_non_latin_languages');

// SVG Icons class.
require get_template_directory() . '/classes/class-twenty-twenty-one-svg-icons.php';

// Custom color classes.
require get_template_directory() . '/classes/class-twenty-twenty-one-custom-colors.php';
new Twenty_Twenty_One_Custom_Colors();

// Enhance the theme by hooking into WordPress.
require get_template_directory() . '/inc/template-functions.php';

// Menu functions and filters.
require get_template_directory() . '/inc/menu-functions.php';

// Custom template tags for the theme.
require get_template_directory() . '/inc/template-tags.php';

// Customizer additions.
require get_template_directory() . '/classes/class-twenty-twenty-one-customize.php';
new Twenty_Twenty_One_Customize();

// Block Patterns.
require get_template_directory() . '/inc/block-patterns.php';

// Block Styles.
require get_template_directory() . '/inc/block-styles.php';

// Dark Mode.
require_once get_template_directory() . '/classes/class-twenty-twenty-one-dark-mode.php';
new Twenty_Twenty_One_Dark_Mode();

/**
 * Enqueue scripts for the customizer preview.
 *
 * @return void
 * @since Twenty Twenty-One 1.0
 *
 */
function twentytwentyone_customize_preview_init()
{
    wp_enqueue_script(
        'twentytwentyone-customize-helpers',
        get_theme_file_uri('/assets/js/customize-helpers.js'),
        array(),
        wp_get_theme()->get('Version'),
        true
    );

    wp_enqueue_script(
        'twentytwentyone-customize-preview',
        get_theme_file_uri('/assets/js/customize-preview.js'),
        array('customize-preview', 'customize-selective-refresh', 'jquery', 'twentytwentyone-customize-helpers'),
        wp_get_theme()->get('Version'),
        true
    );
}

add_action('customize_preview_init', 'twentytwentyone_customize_preview_init');

/**
 * Enqueue scripts for the customizer.
 *
 * @return void
 * @since Twenty Twenty-One 1.0
 *
 */
function twentytwentyone_customize_controls_enqueue_scripts()
{

    wp_enqueue_script(
        'twentytwentyone-customize-helpers',
        get_theme_file_uri('/assets/js/customize-helpers.js'),
        array(),
        wp_get_theme()->get('Version'),
        true
    );
}

add_action('customize_controls_enqueue_scripts', 'twentytwentyone_customize_controls_enqueue_scripts');

/**
 * Calculate classes for the main <html> element.
 *
 * @return void
 * @since Twenty Twenty-One 1.0
 *
 */
function twentytwentyone_the_html_classes()
{
    $classes = apply_filters('twentytwentyone_html_classes', '');
    if (!$classes) {
        return;
    }
    echo 'class="' . esc_attr($classes) . '"';
}

/**
 * Add "is-IE" class to body if the user is on Internet Explorer.
 *
 * @return void
 * @since Twenty Twenty-One 1.0
 *
 */
function twentytwentyone_add_ie_class()
{
    ?>
    <script>
        if (-1 !== navigator.userAgent.indexOf('MSIE') || -1 !== navigator.appVersion.indexOf('Trident/')) {
            document.body.classList.add('is-IE');
        }
    </script>
    <?php
}

add_action('wp_footer', 'twentytwentyone_add_ie_class');

//wp/v2/posts

//use WP_REST_Server;

//for custom end point
add_action('rest_api_init', function () {

    register_rest_route('home', 'slider', array(
        'methods' => 'GET',
        'callback' => 'get_home_slider',
        'permission_callback' => function () {
            return true;
        }

    ));

    register_rest_route('wishlist', 'add', array(
        'methods' => WP_REST_SERVER::CREATABLE,
        'callback' => 'add_product_to_wishlist',
        'args' => array(),
        'permission_callback' => function () {
            return true;
        }
    ));

    register_rest_route('wishlist', 'all', array(
        'methods' => WP_REST_SERVER::CREATABLE,
        'callback' => 'get_all_wishlist',
        'args' => array(),
        'permission_callback' => function () {
            return true;
        }
    ));

    register_rest_route('wishlist', 'clear', array(
        'methods' => WP_REST_SERVER::CREATABLE,
        'callback' => 'clear_all_wishlist',
        'permission_callback' => function () {
            return true;
        }
    ));

    register_rest_route('order', 'file', array(
        'methods' => WP_REST_SERVER::CREATABLE,
        'callback' => 'fileuploadorder',
        'permission_callback' => function () {
            return true;
        }
    ));

    register_rest_route('wishlist', 'remove', array(
        'methods' => WP_REST_SERVER::CREATABLE,
        'callback' => 'remove_item_from_wishlist',
        'args' => array(),
        'permission_callback' => function () {
            return true;
        }
    ));
    register_rest_route('wishlist', 'merge', array(
        'methods' => WP_REST_SERVER::CREATABLE,
        'callback' => 'add_product_to_wishlist_marge',
        'args' => array(),
        'permission_callback' => function () {
            return true;
        }
    ));


    register_rest_route('appointment', 'submit', array(
        'methods' => WP_REST_SERVER::CREATABLE,
        'callback' => 'appointment_submit',
        'args' => array(),
        'permission_callback' => function () {
            return true;
        }
    ));
    register_rest_route('newsletter', 'add', array(
        'methods' => WP_REST_SERVER::CREATABLE,
        'callback' => 'newsletter_add',
        'args' => array(),
        'permission_callback' => function () {
            return true;
        }
    ));
    register_rest_route('newsletter', 'all', array(
        'methods' => 'GET',
        'callback' => 'newsletter_all',
        'permission_callback' => function () {
            return true;
        }
    ));


    register_rest_route('remain', 'slot', array(
        'methods' => WP_REST_SERVER::CREATABLE,
        'method' => 'POST',
        'callback' => 'remain_slot',
        'permission_callback' => function () {
            return true;
        }
    ));


// 	payment_gate_way
    register_rest_route('payment', 'payment_gateway', array(
        'methods' => WP_REST_SERVER::CREATABLE,
        'callback' => 'payment_gateway',
        'args' => array(),
        'permission_callback' => function () {
            return true;
        }
    ));


    register_rest_route('payment', 'payment-return', array(
        'methods' => WP_REST_SERVER::CREATABLE,
        'callback' => 'payment_success',
        'args' => array(),
        'permission_callback' => function () {
            return true;
        }
    ));


    register_rest_route('payment', 'payment-failed', array(
        'methods' => WP_REST_SERVER::CREATABLE,
        'callback' => 'payment_failed',
        'args' => array(),
        'permission_callback' => function () {
            return true;
        }
    ));


    register_rest_route('payment', 'payment_gateway_test', array(
        'methods' => WP_REST_SERVER::CREATABLE,
        'callback' => 'payment_gateway_test',
        'args' => array(),
        'permission_callback' => function () {
            return true;
        }
    ));

//    customer fav product
    register_rest_route('customer', 'fav/(?P<id>\d+)', array(
        'method' => 'GET',
        'callback' => 'get_district_information',
        'args' => array(  //call back with get id
            'id' => array(
                'validate_callback' => function ($param, $request, $key) {
                    return is_numeric($param);
                }
            ),
        ),
        'permission_callback' => function () {
            return true;
        }
    ));


    register_rest_route('password', 'change', array(
        'methods' => WP_REST_SERVER::CREATABLE,
        'callback' => 'changepassword',
        'args' => array(),
        'permission_callback' => function () {
            return true;
        }
    ));

    register_rest_route('customer', 'forget/password', array(
        'methods' => WP_REST_SERVER::CREATABLE,
        'callback' => 'changepassword_forget',
        'args' => array(),
        'permission_callback' => function () {
            return true;
        }
    ));


    register_rest_route('customer', 'forget', array(
        'methods' => WP_REST_SERVER::CREATABLE,
        'callback' => 'get_the_verification_code',
        'args' => array(),
        'permission_callback' => function () {
            return true;
        }
    ));


    register_rest_route('customer', 'forget/verification', array(
        'methods' => WP_REST_SERVER::CREATABLE,
        'callback' => 'get_the_verification_code_match',
        'args' => array(),
        'permission_callback' => function () {
            return true;
        }
    ));


    register_rest_route('customer', 'get_all', array(
        'methods' => WP_REST_SERVER::CREATABLE,
        'callback' => 'get_all_customer',
        'args' => array(),
        'permission_callback' => function () {
            return true;
        }
    ));
    register_rest_route('customer', 'add', array(
        'methods' => WP_REST_SERVER::CREATABLE,
        'callback' => 'create_customer',
        'args' => array(),
        'permission_callback' => function () {
            return true;
        }
    ));


    register_rest_route('customer', 'sendsms', array(
        'methods' => WP_REST_SERVER::CREATABLE,
        'callback' => 'create_customer_sms',
        'args' => array(),
        'permission_callback' => function () {
            return true;
        }
    ));



    register_rest_route('customer', 'update', array(
        'methods' => WP_REST_SERVER::CREATABLE,
        'callback' => 'update_customer',
        'args' => array(),
        'permission_callback' => function () {
            return true;
        }
    ));

    register_rest_route('customer', 'login', array(
        'methods' => WP_REST_SERVER::CREATABLE,
        'callback' => 'login_customer',
        'args' => array(  //call back with get id
            'id' => array(
                'validate_callback' => function ($param, $request, $key) {
                    return is_numeric($param);
                }
            ),
        ),
        'permission_callback' => function () {
            return true;
        }
    ));

    register_rest_route('customer', 'fav', array(
        'method' => 'POST',
        'callback' => 'add_Post_to_fav',
        'args' => array(  //call back with get id
            'id' => array(
                'validate_callback' => function ($param, $request, $key) {
                    return is_numeric($param);
                }
            ),
        ),
        'permission_callback' => function () {
            return true;
        }
    ));

//get child details
    register_rest_route('categories', 'parent/(?P<id>\d+)', array(
        'method' => 'GET',
        'callback' => 'get_category_details',
        'args' => array(  //call back with get id
            'id' => array(
                'validate_callback' => function ($param, $request, $key) {
                    return is_numeric($param);
                }
            ),
        ),
        'permission_callback' => function () {
            return true;
        }
    ));


    register_rest_route('page', 'id/(?P<id>\d+)', array(
        'method' => 'GET',
        'callback' => 'getallpagedate',
        'args' => array(  //call back with get id
            'id' => array(
                'validate_callback' => function ($param, $request, $key) {
                    return is_numeric($param);
                }
            ),
        ),
        'permission_callback' => function () {
            return true;
        }
    ));


    //get product from category
    register_rest_route('categories', 'list', array(
        'method' => 'GET',
        'callback' => 'get_product_from_all',
        'permission_callback' => function () {
            return true;
        }

    ));
    register_rest_route('products', 'category/(?P<id>\d+)', array(
        'method' => 'GET',
        'callback' => 'get_product_from_cat',
        'permission_callback' => function () {
            return true;
        }

    ));

    register_rest_route('filter', 'product', array(
        'methods' => WP_REST_SERVER::CREATABLE,
        'callback' => 'filter_product',
        'args' => array(),
        'permission_callback' => function () {
            return true;
        }
    ));


    register_rest_route('products', 'id/(?P<id>\d+)', array(
        'method' => 'GET',
        'callback' => 'get_product_from_id',
        'permission_callback' => function () {
            return true;
        }

    ));

    register_rest_route('products', 'slug/(?P<slug>[-\w]{1,255})', array(
        'method' => 'GET',
        'callback' => 'get_product_from_slug',
        'permission_callback' => function () {
            return true;
        }

    ));


    register_rest_route('orders', 'id', array(

        'methods' => WP_REST_SERVER::CREATABLE,
        'callback' => 'get_partial_order_info',
        'args' => array(),
        'permission_callback' => function () {
            return true;
        }

    ));


//    related products or feature products

    register_rest_route('products', 'related/(?P<id>\d+)', array(
        'method' => 'GET',
        'callback' => 'get_related_products',
        'permission_callback' => function () {
            return true;
        }

    ));

    register_rest_route('menu', 'menu_id/(?P<id>\d+)', array(
        'method' => 'GET',
        'callback' => 'get_nav_item',
        'permission_callback' => function () {
            return true;
        }

    ));
    register_rest_route('get_post', 'all', array(
        'method' => 'GET',
        'callback' => 'get_all_post',
        'permission_callback' => function () {
            return true;
        }

    ));

    register_rest_route('get_product', 'all', array(
        'method' => 'GET',
        'callback' => 'get_all_prodcut',
        'permission_callback' => function () {
            return true;
        }

    ));


    register_rest_route('carts', 'add', array(
        'methods' => WP_REST_SERVER::CREATABLE,
        'callback' => 'add_product_to_cart',
        'args' => array(),
        'permission_callback' => function () {
            return true;
        }
    ));
    register_rest_route('carts', 'merge', array(
        'methods' => WP_REST_SERVER::CREATABLE,
        'callback' => 'add_product_to_cart_marge',
        'args' => array(),
        'permission_callback' => function () {
            return true;
        }
    ));

    register_rest_route('carts', 'all', array(
        'methods' => WP_REST_SERVER::CREATABLE,
        'callback' => 'get_all_cart',
        'args' => array(),
        'permission_callback' => function () {
            return true;
        }
    ));

    register_rest_route('carts', 'update', array(
        'methods' => WP_REST_SERVER::CREATABLE,
        'callback' => 'remove_item_from_cart',
        'args' => array(),
        'permission_callback' => function () {
            return true;
        }
    ));

    register_rest_route('carts', 'clear', array(
        'methods' => WP_REST_SERVER::CREATABLE,
        'callback' => 'clear_all_cart',
        'permission_callback' => function () {
            return true;
        }
    ));
});


function get_home_slider()
{


    $args = array(
        'post_type' => 'home_slider',
        'orderby' => 'ID',
        'post_status' => 'publish',
        'order' => 'DESC',
        'posts_per_page' => -1 // this will retrive all the post that is published
    );


    $posts = get_posts($args);
    foreach ($posts as $single) : setup_postdata($single);


        // var_dump($single);
        $meta = get_post_meta($single->ID);
        $extra_banner = get_the_post_thumbnail_url($single->ID, 'full', true);

        // $meta= get_post_meta($single->ID,true);

        $array = array(
            'ID' => $single->ID,
            'post_author' => $single->post_author,
            'post_date' => $single->post_date,
            'post_feature_image' => $extra_banner,
            'post_date_gmt' => $single->post_date_gmt,
            'post_content' => $single->post_content,
            'post_title' => $single->post_title,
            'post_excerpt' => $single->post_excerpt,
            'post_status' => $single->post_status,
            'comment_status' => $single->comment_status,
            'ping_status' => $single->ping_status,
            'post_password' => $single->post_password,
            'post_name' => $single->post_name,
            'to_ping' => $single->to_ping,
            'post_modified' => $single->post_modified,
            'post_modified_gmt' => $single->post_modified_gmt,
            'post_content_filtered' => $single->post_content_filtered,
            'post_parent' => $single->post_parent,
            'guid' => $single->guid,
            'menu_order' => $single->menu_order,
            'post_type' => $single->post_type,
            'post_mime_type' => $single->post_mime_type,
            'comment_count' => $single->comment_count,
            'meta' => $meta,
            'banner' => $extra_banner

        );

        // return $array;
        $op[] = $array;

        wp_reset_postdata(); endforeach;

    header('Content-type: application/json');
    echo json_encode($op, JSON_PRETTY_PRINT);
}

//wishlist


function add_product_to_wishlist($request)
{
    $body = $request->get_body();
    $user_id = $request->get_param('user_id');
    $product_id = $request->get_param('product_id');


    $array = array();
    $price = null;
    $image = null;
    //$count = $request->get_param('count');
    if (empty($variable_id)) {
        $variable_id = null;
    }
    if (!empty($user_id) and !empty($product_id)) {
        global $wpdb;
        $tablename = $wpdb->prefix . 'customwishlist';
        $product = wc_get_product($product_id);
        $sku = $product->sku;
        $name = $product->name;
        $price = $product->price;
        $image = wp_get_attachment_image_url($product->image_id, 'full');

        $post_id = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}customwishlist where user_id = {$user_id} and product_id = {$product_id}");


        if (empty($post_id)) {


            $success = $wpdb->insert(
                $tablename,
                array(
                    'user_id' => esc_attr($user_id),
                    'product_id' => esc_attr($product_id),
                    'sku' => esc_attr($sku),
                    'product_name' => esc_attr($name),
                    'image_id' => esc_url($image),
                    'price' => esc_attr($price)

                )
            );

            if ($success) {
                $user_nicenames = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}customwishlist where user_id = {$user_id} and product_id = {$product_id}", ARRAY_A);

                $product = array();
                foreach ($user_nicenames as $nicename) {
                    $product2 = wc_get_product($nicename['product_id']);
                    //$product = $nicename;


                    // var_dump($product->parent_id);
                    $product = array(
                        'id' => $nicename['id'],
                        'user_id' => $nicename['user_id'],
                        'product_id' => $nicename['product_id'],
                        'parent_id' => $product2->parent_id,
                        'product_name' => $nicename['product_name'],
                        'sku' => $nicename['sku'],
                        'image_id' => $nicename['image_id'],
                        'price' => $nicename['price'],
                        'count' => $nicename['count'],
                    );
                }

                header('Content-type: application/json');
                echo json_encode($product, JSON_PRETTY_PRINT);

            } else {
                $wpdb->print_error();
                echo "Not inserted";
            }
        } else {


            $message = [
                'status' => 1,
                'message' => 'Product already exists'
            ];


            header('Content-type: application/json');
            echo json_encode($message, JSON_PRETTY_PRINT);


        }
    }

}


function clear_all_wishlist($request)
{
    global $wpdb;
    $tablename = $wpdb->prefix . 'customwishlist';

    $user_id = $request->get_param('user_id');

    $wpdb->delete($tablename, array('user_id' => $user_id));
    $post_id = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}customwishlist where user_id={$user_id}");

    $all3 = array();
    $product_name = null;
    foreach ($post_id as $id) {
        $all3[] = $id;
        $product_name = $id['product_name'];
    }
    $message = [
        'status' => 1,
        'message' => "Wishlist clear successfully"
    ];


    header('Content-type: application/json');
    echo json_encode($message, JSON_PRETTY_PRINT);
}

function get_all_wishlist($request)
{
    global $wpdb;

    $user_id = $request->get_param('user_id');
    global $wpdb;
    $post_id = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}customwishlist where user_id={$user_id}");

    $all3 = array();
    foreach ($post_id as $id) {
        $product = wc_get_product($id->product_id);
        $all3[] = array(
            'id' => $id->id,
            'user_id' => $id->user_id,
            'product_id' => $id->product_id,
            'parent_id' => $product->parent_id,
            'product_name' => $id->product_name,
            'sku' => $id->sku,
            'image_id' => $id->image_id,
            'price' => $id->price,
            'count' => $id->count,
        );

    }

    header('Content-type: application/json');
    echo json_encode($all3, JSON_PRETTY_PRINT);

}

function remove_item_from_wishlist($request)
{

    global $wpdb;
    $tablename = $wpdb->prefix . 'customwishlist';

    $user_id = $request->get_param('user_id');
    $product_id = $request->get_param('product_id');

    $check_user = null;
    $post_id = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}customwishlist where user_id={$user_id} and product_id={$product_id}");
    foreach ($post_id as $idd) {

        $check_user = $idd->user_id;

    }

    if (!empty($check_user)) {
        $wpdb->delete($tablename, array('user_id' => $user_id, 'product_id' => $product_id));
        $post_id = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}customwishlist where user_id={$user_id}");

        $all3 = array();
        $product_name = null;
        foreach ($post_id as $id) {
            $product = wc_get_product($id->product_id);
            $all3[] = array(
                'id' => $id->id,
                'user_id' => $id->user_id,
                'product_id' => $id->product_id,
                'parent_id' => $product->parent_id,
                'product_name' => $id->product_name,
                'sku' => $id->sku,
                'image_id' => $id->image_id,
                'price' => $id->price,
                'count' => $id->count,
            );

        }

        header('Content-type: application/json');
        echo json_encode($all3, JSON_PRETTY_PRINT);
    } else {
        $message = [
            'status' => 1,
            'message' => "Product don't exists"
        ];


        header('Content-type: application/json');
        echo json_encode($message, JSON_PRETTY_PRINT);
    }


}

function fileuploadorder($request){
    $order_id = $request->get_param('order_id');
    $file = $_FILES;
    $filename = $file['file']['name'];;
    $attachment_id = 0;

    $upload_file = wp_upload_bits($filename, null, file_get_contents($file['file']['tmp_name']));
    if (!$upload_file['error']) {
        $wp_filetype = wp_check_filetype($filename, null );
        $attachment = array(
            'post_mime_type' => $wp_filetype['type'],
            'post_parent' => $order_id,
            'post_title' => preg_replace('/\.[^.]+$/', '', $filename),
            'post_content' => '',
            'post_status' => 'inherit'
        );
        $attachment_id = wp_insert_attachment( $attachment, $upload_file['file'], $order_id );

        if (!is_wp_error($attachment_id)) {
            require_once(ABSPATH . "wp-admin" . '/includes/image.php');
            $attachment_data = wp_generate_attachment_metadata( $attachment_id, $upload_file['file'] );
            wp_update_attachment_metadata( $attachment_id,  $attachment_data );
        }
        update_post_meta($order_id,'attachement_order' ,$attachment_id );

        $message = [
            'status' => 1,
            'message' => 'File Upload Successfully'
        ];
    }
    else{
        $message = [
            'status' => 0,
            'message' => 'Select a file first'
        ];
    }
    header('Content-type: application/json');
    echo json_encode($message, JSON_PRETTY_PRINT);

}

function add_product_to_wishlist_marge($request)
{

    global $wpdb;
    $flag1 = false;
    $flag2 = false;
    $ids = array();
    $ids2 = array();
    $body = $request->get_body();
    $user_id = $request->get_param('user_id');
    $product_idss = $request->get_param('product_wish_cart');
    $product_ids = array();
    $product_count = null;
    $array = array();
    $price = null;
    $product_id_arrya = array();
    $image = null;
    $user_id2 = $wpdb->get_results("SELECT user_id FROM {$wpdb->prefix}customwishlist where user_id = {$user_id} ");

    if ($user_id2) {
        $cart_id = null;

        foreach ($request->get_param('product_wish_cart') as $item) {
            $product_ids = $item['product_id'];
            //$product_count = $product['count'];

            if (!empty($user_id) and !empty($product_ids)) {

                $tablename = $wpdb->prefix . 'customwishlist';
                $product = wc_get_product($product_ids);
                $sku = $product->sku;
                $name = $product->name;
                $price = $product->price;
                $image = wp_get_attachment_image_url($product->image_id, 'full');
                $exist_arry = array();
                $nonexist_arry = array();

                $post_id = $wpdb->get_results("SELECT product_id FROM {$wpdb->prefix}customwishlist where user_id = {$user_id} and product_id = {$product_ids}");

                $cart_id = null;


                if ($post_id == true) {
                    foreach ($post_id as $id) {
                        // $get_present_count = $id->count + $product_count;
                        $exist_arry [] = $id;

                        foreach ($exist_arry as $pro) {

                            $post_id = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}customwishlist where user_id = {$user_id} and product_id = {$pro->product_id}");

                            $cart_id = null;
                            foreach ($post_id as $id) {

                                $cart_id = $id->id;
                            }


                            $insert = $wpdb->query($wpdb->prepare("UPDATE {$wpdb->prefix}customwishlist SET user_id={$user_id} WHERE id={$cart_id}"));

                            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
                            $success = dbDelta($insert);


                        }

                    }

                } elseif ($post_id == false) {
                    $nonexist_arry[] = $product_ids;
                    foreach ($nonexist_arry as $pro) {


                        $product = wc_get_product($pro);
                        $sku = $product->sku;
                        $name = $product->name;
                        $price = $product->price;
                        $image = wp_get_attachment_image_url($product->image_id, 'full');

                        $success = $wpdb->insert(
                            $tablename,
                            array(
                                'user_id' => esc_attr($user_id),
                                'product_id' => esc_attr($pro),
                                'sku' => esc_attr($sku),
                                'product_name' => esc_attr($name),
                                'image_id' => esc_url($image),
                                'price' => esc_attr($price),
                                //'count' => esc_attr($product_count)
                            )
                        );

                        if ($success) {
                            $full_data = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}customwishlist where user_id = {$user_id} ");

                        } else {
                            $wpdb->print_error();
                            echo "Not inserted";
                        }
                    }
                }


            }


        }


        $success = null;
        $product_ids = null;
        //$product_count = $product['count'];
        $product = null;
        $sku = null;
        $name = null;
        $price = null;
        $image = null;
        $full_data = null;
    }
    if (empty($user_id2)) {
        $tablename = $wpdb->prefix . 'customwishlist';
        foreach ($request->get_param('product_wish_cart') as $item) {
            $product_ids = $item['product_id'];
            //$product_count = $product['count'];
            $product = wc_get_product($product_ids);
            $sku = $product->sku;
            $name = $product->name;
            $price = $product->price;
            $image = wp_get_attachment_image_url($product->image_id, 'full');

            $success = $wpdb->insert(
                $tablename,
                array(
                    'user_id' => esc_attr($user_id),
                    'product_id' => esc_attr($product_ids),
                    'sku' => esc_attr($sku),
                    'product_name' => esc_attr($name),
                    'image_id' => esc_url($image),
                    'price' => esc_attr($price),
                    //'count' => esc_attr($product_count)
                )
            );

            if ($success) {
                $full_data3 = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}customwishlist where user_id = {$user_id} ");


            } else {
                $wpdb->print_error();
                echo "Not inserted";
            }

        }

        $success = null;
        $product_ids = null;
        //$product_count = $product['count'];
        $product = null;
        $sku = null;
        $name = null;
        $price = null;
        $image = null;
        $full_data = null;
    }
    $full_data = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}customwishlist where user_id = {$user_id} ");


    header('Content-type: application/json');
    echo json_encode($full_data, JSON_PRETTY_PRINT);


}

function newsletter_all()
{

    global $wpdb;
    $table_name = $wpdb->prefix . 'newsletter_custom';
    $full_data = $wpdb->get_results("SELECT * FROM $table_name ");


    header('Content-type: application/json');
    echo json_encode($full_data, JSON_PRETTY_PRINT);
}

function newsletter_add($request)
{

    global $wpdb;
    $user_id = $request->get_param('email');
    $table_name = $wpdb->prefix . 'newsletter_custom';

    $sql = "SELECT email FROM " . $table_name . " WHERE email = '" . $user_id . "'";
    //echo $sql;
    $check_email = $wpdb->get_results($sql, ARRAY_A);
    $date_name = null;
    $product = array();
    var_dump();
    if (empty($check_email)) {
        $success = $wpdb->insert(
            $table_name,
            array(
                'email' => esc_attr($user_id),

            )
        );

        if ($success) {
            $message = [
                'status' => 0,
                'message' => 'Email Add Successfully'
            ];

            return $message;
        }
    } else {
        $message = [
            'status' => 1,
            'message' => 'Email Already Exits'
        ];

        return $message;
    }
}

function appointment_submit($request)
{
    $body = $request->get_body();
    $user_id = $request->get_param('user_id');
    $appoint_name = $request->get_param('appoint_name');
    $apoint_email = $request->get_param('apoint_email');
    $appoint_phone = $request->get_param('appoint_phone');
    $appoint_visit_type = $request->get_param('appoint_visit_type');
    $appoint_slot_id = $request->get_param('appoint_slot_id');
    $appoint_slot_time = $request->get_param('appoint_slot_time');
    $appoint_slot_start = $request->get_param('appoint_slot_start');
    $appoint_slot_end = $request->get_param('appoint_slot_end');
    $appoint_product = $request->get_param('appoint_product');
    $appoint_status = $request->get_param('appoint_status');
    $appoint_date = $request->get_param('appoint_date');


    global $wpdb;
    $table_name = $wpdb->prefix . 'appointments_schedule';
    $table_name2 = $wpdb->prefix . 'date_slot';

    $user_nicenames = $wpdb->get_results("SELECT * FROM {$table_name2} where date_name='{$appoint_date}' and slot_id='{$appoint_slot_id}'", ARRAY_A);
    $date_name = null;
    $product = array();


    if (empty($user_nicenames)) {
        $success = $wpdb->insert(
            $table_name,
            array(
                'user_id' => esc_attr($user_id),
                'appoint_name' => esc_attr($appoint_name),
                'apoint_email' => esc_attr($apoint_email),
                'appoint_phone' => esc_attr($appoint_phone),
                'appoint_visit_type' => esc_attr($appoint_visit_type),
                'appoint_slot_id' => esc_attr($appoint_slot_id),
                'appoint_slot_time' => esc_attr($appoint_slot_time),
                'appoint_slot_start' => esc_attr($appoint_slot_start),
                'appoint_slot_end' => esc_attr($appoint_slot_end),
                'appoint_product' => esc_attr($appoint_product),
                'appoint_status' => esc_attr($appoint_status),
            )
        );

        if ($success) {

            $success3 = $wpdb->insert(
                $table_name2,
                array(
                    'date_name' => esc_attr($appoint_date),
                    'slot_id' => esc_attr($appoint_slot_id),
                )
            );


            $user_nicenames = $wpdb->get_results("SELECT * FROM {$table_name} where user_id = {$user_id}", ARRAY_A);

            $product = array();
            foreach ($user_nicenames as $nicename) {
                $product = $nicename;
            }
            $message = [
                'status' => 1,
                'message' => 'Appointment Submit Successfully'
            ];

            return $message;
//            header('Content-type: application/json');
//            echo json_encode($product, JSON_PRETTY_PRINT);
            $to = $apoint_email;
            $subject = 'Your appointment have been confirm';
            $body = 'The email body content';
            $headers = array('Content-Type: text/html; charset=UTF-8');

            wp_mail($to, $subject, $body, $headers);
        } else {
            $wpdb->print_error();
            echo "Not inserted";
        }
    } else {
        $message = [
            'status' => 0,
            'message' => 'Slot already Booked'
        ];

        return $message;
    }

    foreach ($user_nicenames as $nicename) {
        $product = $nicename;
    }

//add_option('date-' . $appoint_date, $product, '', 'yes');


}

function remain_slot($request)
{
    $body = $request->get_body();
    $appoint_date = $request->get_param('appoint_date');
    global $wpdb;
    $table_name = $wpdb->prefix . 'appointments_slot';
    $table_name2 = $wpdb->prefix . 'date_slot';
    $user_nicenames = $wpdb->get_results("SELECT * FROM {$table_name2} where date_name='{$appoint_date}' ", ARRAY_A);
    $user_nicenames2 = $wpdb->get_results("SELECT * FROM {$table_name}", ARRAY_A);
    $data [] = null;
    $result [] = null;
    $data2 [] = null;

    $final = array();
    if (!empty($user_nicenames)) {
        foreach ($user_nicenames2 as $remain) {
            $data[] = $remain['id'];
        }

        foreach ($user_nicenames as $slot_free) {
            $data2 [] = $slot_free['slot_id'];
        }

        $result = array_diff($data, $data2);

        foreach ($result as $pri) {

            $user_nicenames2 = $wpdb->get_results("SELECT * FROM {$table_name} where id={$pri}", ARRAY_A);

            foreach ($user_nicenames2 as $remain) {
                $final[] = $remain;
            }
        }

        header('Content-type: application/json');
        echo json_encode($final, JSON_PRETTY_PRINT);
    } elseif (empty($user_nicenames)) {
        $user_nicenames2 = $wpdb->get_results("SELECT * FROM {$table_name} ", ARRAY_A);

        foreach ($user_nicenames2 as $remain) {
            $final[] = $remain;
        }

        header('Content-type: application/json');
        echo json_encode($final, JSON_PRETTY_PRINT);
    }


}


// payment gateway
function payment_gateway($request)
{

    $body = $request->get_body();
    $user_id = $request->get_param('user_id');
    $product_id = $request->get_param('count');
    $order_id = $request->get_param('order_id');
    $order = wc_get_order($order_id);


// Get the Customer ID (User ID)
//
//    var_dump($order->get_discount_total());
//
//

    $flag = false;


    $total = $order->total;
    $partial_payment = get_option('partial_payment');

    if ($total >= $partial_payment) {
        $total = $partial_payment;

    }


    $curency = 'BDT';
    $tran_id = "TR_" . $order_id . uniqid();
    $cus_name = $order->get_billing_first_name() . ' ' . $order->get_billing_last_name();
    $cus_email = $order->get_billing_email();
    $cus_add1 = $order->get_billing_address_1();
    $cus_add2 = $order->get_billing_address_2();
    $cus_city = $order->get_billing_city();
    $cus_state = $order->get_billing_state();
    $cus_postcode = $order->get_billing_postcode();
    $cus_country = $order->get_billing_country();
    $cus_phone = $order->get_billing_phone();
    $ship_name = $order->get_shipping_first_name() . '' . $order->get_shipping_last_name();
    $ship_add1 = $order->get_shipping_address_1();
    $ship_add2 = $order->get_shipping_address_2();
    $ship_city = $order->get_shipping_city();
    $ship_state = $order->get_shipping_state();
    $ship_postcode = $order->get_shipping_postcode();
    $ship_country = $order->get_shipping_country();


    $vat = $order->get_tax_totals();
    $discount_amount = $order->get_discount_total();
    $convenience_fee = "0";
    $product_name = $order->get_id();
    $product_category = $order->get_id();
    $product_profile = $order->get_id();
    $cart = $order->get_id();
//    220129231840zhKq9NUO385vFIg

    /* PHP */
    $post_data = array();
    $post_data['store_id'] = "saif5ff69f4b4e530";
    $post_data['store_passwd'] = "saif5ff69f4b4e530@ssl";
    $post_data['total_amount'] = $total;
    $post_data['currency'] = $curency;
    $post_data['tran_id'] = $tran_id;
//    $post_data['success_url'] = "http://localhost/payment/";
//    $post_data['fail_url'] = "http://localhost/payment/";
//    $post_data['cancel_url'] = "http://localhost/payment/";
    $post_data['success_url'] = "https://shantalifestyle.qwikq.net/payment-process?key=" . $tran_id;
    $post_data['fail_url'] = "https://shantalifestyle.qwikq.net/payment-failed?order_id=" . $order_id;
    $post_data['cancel_url'] = "https://shantalifestyle.qwikq.net/payment-cancel?order_id=" . $order_id;
# $post_data['multi_card_name'] = "mastercard,visacard,amexcard";  # DISABLE TO DISPLAY ALL AVAILABLE

# EMI INFO
    $post_data['emi_option'] = "0";
    $post_data['emi_max_inst_option'] = "0";
    $post_data['emi_selected_inst'] = "0";

# CUSTOMER INFORMATION
    $post_data['cus_name'] = $cus_name;
    $post_data['cus_email'] = $cus_email;
    $post_data['cus_add1'] = $cus_add1;
    $post_data['cus_add2'] = $cus_add2;
    $post_data['cus_city'] = $cus_city;
    $post_data['cus_state'] = $cus_state;
    $post_data['cus_postcode'] = $cus_postcode;
    $post_data['cus_country'] = $cus_country;
    $post_data['cus_phone'] = $cus_phone;
    $post_data['cus_fax'] = $cus_phone;

# SHIPMENT INFORMATION
    $post_data['ship_name'] = $ship_name;
    $post_data['ship_add1 '] = $ship_add1;
    $post_data['ship_add2'] = $ship_add2;
    $post_data['ship_city'] = $ship_city;
    $post_data['ship_state'] = $ship_state;
    $post_data['ship_postcode'] = $ship_postcode;
    $post_data['ship_country'] = $ship_country;
    $post_data['shipping_method'] = "No";
# OPTIONAL PARAMETERS
    $post_data['value_a'] = $order_id;
    $post_data['value_b '] = "ref002";
    $post_data['value_c'] = "ref003";
    $post_data['value_d'] = "ref004";

# CART PARAMETERS
    $post_data['cart'] = $cart;
    $post_data['product_amount'] = $total;
    $post_data['product_name'] = $product_name;
    $post_data['product_category'] = $product_category;
    $post_data['product_profile'] = $product_profile;
    $post_data['vat'] = $vat;
    $post_data['discount_amount'] = $discount_amount;
    $post_data['convenience_fee'] = $convenience_fee;


# REQUEST SEND TO SSLCOMMERZ
    $direct_api_url = "https://sandbox.sslcommerz.com/gwprocess/v4/api.php";

    $handle = curl_init();
    curl_setopt($handle, CURLOPT_URL, $direct_api_url);
    curl_setopt($handle, CURLOPT_TIMEOUT, 30);
    curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($handle, CURLOPT_POST, 1);
    curl_setopt($handle, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, FALSE); # KEEP IT FALSE IF YOU RUN FROM LOCAL PC


    $content = curl_exec($handle);

    $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

    if ($code == 200 && !(curl_errno($handle))) {
        curl_close($handle);
        $sslcommerzResponse = $content;


    } else {
        curl_close($handle);
        echo "FAILED TO CONNECT WITH SSLCOMMERZ API";
        exit;
    }

# PARSE THE JSON RESPONSE
    $sslcz = json_decode($sslcommerzResponse, true);
    header('Content-type: application/json');
    echo json_encode($sslcz, JSON_PRETTY_PRINT);

}


// payment success
function payment_success($request)
{
    $body = $request->get_body();
    $tran_id = $request->get_param('key');
//    $val_id = $request->get_param('val_id');


    if (!empty($tran_id)) {
        //    $val_id = urlencode($_POST['val_id']);

//        $tran_id=urlencode($_POST['tran_id']);
        $store_id = urlencode("saif5ff69f4b4e530");
        $store_passwd = urlencode("saif5ff69f4b4e530@ssl");
        $requested_url = ("https://sandbox.sslcommerz.com/validator/api/merchantTransIDvalidationAPI.php?tran_id=" . $tran_id . "&store_id=" . $store_id . "&store_passwd=" . $store_passwd . "&v=1&format=json");


        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $requested_url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false); # IF YOU RUN FROM LOCAL PC
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false); # IF YOU RUN FROM LOCAL PC

        $result = curl_exec($handle);

        $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);


        if ($code == 200 && !(curl_errno($handle))) {

            # TO CONVERT AS ARRAY
            # $result = json_decode($result, true);
            # $status = $result['status'];

            # TO CONVERT AS OBJECT
            $result = json_decode($result);

            $result = $result->element[0];


            # TRANSACTION INFO
            $status = $result->status;
            $tran_date = $result->tran_date;
            $tran_id = $result->tran_id;
            $val_id = $result->val_id;
            $amount = $result->amount;
            $store_amount = $result->store_amount;
            $bank_tran_id = $result->bank_tran_id;
            $card_type = $result->card_type;

            # EMI INFO
            $emi_instalment = $result->emi_instalment;
            $emi_amount = $result->emi_amount;
            $emi_description = $result->emi_description;
            $emi_issuer = $result->emi_issuer;

            # ISSUER INFO
            $card_no = $result->card_no;
            $card_issuer = $result->card_issuer;
            $card_brand = $result->card_brand;
            $card_issuer_country = $result->card_issuer_country;
            $card_issuer_country_code = $result->card_issuer_country_code;

            # API AUTHENTICATION
            $APIConnect = $result->APIConnect;
            $validated_on = $result->validated_on;
            $gw_version = $result->gw_version;
            $partial_payment = get_option('partial_payment');
//    var_dump($result);
            if ($status == "VALID" || $status == "VALIDATED") {
                $order = wc_get_order($result->value_a);
                $total = $order->total;


                if ($total == $amount) {


                    $order->update_status("wc-processing", 'Processing', TRUE);
                    update_post_meta($result->value_a, 'dueamount', 0);
                    $message = [
                        'status' => 1,
                        'order_id' => $result->value_a,
                        'message' => 'Payment Completed Successfully'
                    ];
                    return $message;
                } elseif ($total >= $partial_payment) {

                    update_post_meta($result->value_a, 'dueamount', ($total - $partial_payment));
                    $order->update_status("wc-partially-paid", 'Partially Paid', TRUE);

                    $message = [
                        'status' => 1,
                        'order_id' => $result->value_a,
                        'message' => 'Payment Completed Successfully'
                    ];
                    return $message;
                }
            }
        } else {

            echo "Failed to connect with SSLCOMMERZ";
        }
    } else {
//        $orderDetail = new WC_Order( $result->value_a );
//        $orderDetail->update_status("wc-failed", 'Completed', TRUE);

        $message = [
            'status' => 0,
            'message' => 'Payment Pending'
        ];
        return $message;
    }
}


function payment_failed($request)
{
    $body = $request->get_body();
    $order_id = $request->get_param('order_id');


    $orderDetail = new WC_Order($order_id);
    $orderDetail->update_status("wc-failed", 'Failed', TRUE);

    $message = [
        'status' => 1,
        'order_id' => $order_id,
        'message' => 'Payment Failed'
    ];
    return $message;
}

function payment_gateway_test($request)
{
    $body = $request->get_body();
    $order_id = $request->get_param('order_id');
    $order = new WC_Order($order_id);

    $user_id = $request->get_param('user_id');
    $product_id = $request->get_param('count');
    $total = $request->get_param('total_amount');
    $curency = $request->get_param('currency');
    $tran_id = $request->get_param('tran_id');
    $cus_name = $request->get_param('cus_name');
    $cus_email = $request->get_param('cus_email');
    $cus_add1 = $request->get_param('cus_add1');
    $cus_add2 = $request->get_param('cus_add2');
    $cus_city = $request->get_param('cus_city');
    $cus_state = $request->get_param('cus_state');
    $cus_postcode = $request->get_param('cus_postcode');
    $cus_country = $request->get_param('cus_country');
    $cus_phone = $request->get_param('cus_phone');
    $ship_name = $request->get_param('ship_name');
    $ship_add1 = $request->get_param('ship_add1');
    $ship_add2 = $request->get_param('ship_add2');
    $ship_city = $request->get_param('ship_city');
    $ship_state = $request->get_param('ship_state');
    $ship_postcode = $request->get_param('ship_postcode');
    $ship_country = $request->get_param('ship_country');
    $product_amount = $request->get_param('product_amount');
    $vat = $request->get_param('vat');
    $discount_amount = $request->get_param('discount_amount');
    $convenience_fee = $request->get_param('convenience_fee');
    $product_name = $request->get_param('product_name');
    $product_category = $request->get_param('product_category');
    $product_profile = $request->get_param('product_profile');
    $cart = $request->get_param('cart');
    $success_url = $request->get_param('success_url');
    $fail_url = $request->get_param('fail_url');
    $cancel_url = $request->get_param('cancel_url');


    /* PHP */
    $post_data = array();
    $post_data['store_id'] = "testbox";
    $post_data['store_passwd'] = "qwerty@ssl";
    $post_data['total_amount'] = $total;
    $post_data['currency'] = $curency;
    $post_data['tran_id'] = $tran_id;
    $post_data['success_url'] = $success_url;
    $post_data['fail_url'] = $fail_url;
    $post_data['cancel_url'] = $cancel_url;
# $post_data['multi_card_name'] = "mastercard,visacard,amexcard";  # DISABLE TO DISPLAY ALL AVAILABLE

# EMI INFO
    $post_data['emi_option'] = "1";
    $post_data['emi_max_inst_option'] = "9";
    $post_data['emi_selected_inst'] = "9";

# CUSTOMER INFORMATION
    $post_data['cus_name'] = $cus_name;
    $post_data['cus_email'] = $cus_email;
    $post_data['cus_add1'] = $cus_add1;
    $post_data['cus_add2'] = $cus_add2;
    $post_data['cus_city'] = $cus_city;
    $post_data['cus_state'] = $cus_state;
    $post_data['cus_postcode'] = $cus_postcode;
    $post_data['cus_country'] = $cus_country;
    $post_data['cus_phone'] = $cus_phone;
    $post_data['cus_fax'] = $cus_phone;

# SHIPMENT INFORMATION
    $post_data['ship_name'] = $ship_name;
    $post_data['ship_add1 '] = $ship_add1;
    $post_data['ship_add2'] = $ship_add2;
    $post_data['ship_city'] = $ship_city;
    $post_data['ship_state'] = $ship_state;
    $post_data['ship_postcode'] = $ship_postcode;
    $post_data['ship_country'] = $ship_country;
    $post_data['shipping_method'] = "No";
# OPTIONAL PARAMETERS
    $post_data['value_a'] = "ref001";
    $post_data['value_b '] = "ref002";
    $post_data['value_c'] = "ref003";
    $post_data['value_d'] = "ref004";

# CART PARAMETERS
    $post_data['cart'] = $cart;
    $post_data['product_amount'] = $product_amount;
    $post_data['product_name'] = $product_name;
    $post_data['product_category'] = $product_category;
    $post_data['product_profile'] = $product_profile;
    $post_data['vat'] = $vat;
    $post_data['discount_amount'] = $discount_amount;
    $post_data['convenience_fee'] = $convenience_fee;


# REQUEST SEND TO SSLCOMMERZ
    $direct_api_url = "https://sandbox.sslcommerz.com/gwprocess/v4/api.php";

    $handle = curl_init();
    curl_setopt($handle, CURLOPT_URL, $direct_api_url);
    curl_setopt($handle, CURLOPT_TIMEOUT, 30);
    curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($handle, CURLOPT_POST, 1);
    curl_setopt($handle, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, FALSE); # KEEP IT FALSE IF YOU RUN FROM LOCAL PC


    $content = curl_exec($handle);

    $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

    if ($code == 200 && !(curl_errno($handle))) {
        curl_close($handle);
        $sslcommerzResponse = $content;
    } else {
        curl_close($handle);
        echo "FAILED TO CONNECT WITH SSLCOMMERZ API";
        exit;
    }

# PARSE THE JSON RESPONSE
    $sslcz = json_decode($sslcommerzResponse, true);
    header('Content-type: application/json');
    echo json_encode($sslcz, JSON_PRETTY_PRINT);

}


//create customer api

function create_customer($request)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'mobile_users';
    $otptable = $wpdb->prefix . 'userotp_verifcation';

    $user_table = $wpdb->prefix . 'users';
    $body = $request->get_body();
    //$body_params = $_POST['user_login'];

    $user_phone = $request->get_param('user_phone');
    $user_name = $request->get_param('user_login');
    $display_name = $request->get_param('display_name');
    $otp = $request->get_param('otp');
    $validotp = null;
    //Generate a random string.
    $token = openssl_random_pseudo_bytes(16);

//Convert the binary data into hexadecimal representation.
    $token = bin2hex($token);

    global $wpdb;
    $table_name = $wpdb->prefix . 'mobile_users';
    $user_table = $wpdb->prefix . 'users';
    $user_name = esc_attr($user_name);
    $get_phone = $wpdb->get_row("SELECT user_phone FROM {$wpdb->prefix}users WHERE user_phone={$user_phone}", ARRAY_A);
    //$get_name = $wpdb->get_results("SELECT user_login FROM {$wpdb->prefix}users where user_login={$request->get_param('user_login')}", ARRAY_A);
    $getotp = $wpdb->get_row("SELECT * FROM {$otptable} WHERE number={$user_phone}", ARRAY_A);

    if (isset($get_phone)) {
        $message = [
            'status' => 0,
            'message' => 'Phone number already exist'
        ];

        header('Content-type: application/json');
        echo json_encode($message, JSON_PRETTY_PRINT);
    }
    else {
        //echo $user_name;
        $user_data = get_user_by('login', $user_name);


        if($getotp[otp] == $otp){
            if (empty($user_data)) {
                $userdata [] = null;
                $user_id = email_exists($request->get_param('user_login'));
                if (!$user_id) {
                    $user_id = wp_create_user($request->get_param('user_login'), $request->get_param('user_pass'), '');

                    $insert = $wpdb->query($wpdb->prepare("UPDATE $user_table SET user_phone= '$user_phone', display_name= '$display_name', token = '$token'  WHERE ID=$user_id"));

                    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
                    dbDelta($insert);

                    $user_pass_chek = $wpdb->get_results("SELECT ID,token,user_nicename ,user_phone,user_email,user_url,display_name,country_code,user_pass FROM {$wpdb->prefix}users WHERE ID = '$user_id'", ARRAY_A);

                    foreach ($user_pass_chek as $nice_name) {

                        $userdata = [
                            'id' => $nice_name['ID'],
                            'token' => $nice_name['token'],
                            'user_nicename' => $nice_name['user_nicename'],
                            'user_phone' => $nice_name['user_phone'],
                            'user_email' => $nice_name['user_email'],
                            'user_url' => $nice_name['user_url'],
                            'display_name' => $nice_name['display_name'],
                            'country_code' => $nice_name['country_code'],
                            'user_pass' => $nice_name['user_pass'],


                        ];


                    }

                    return $userdata;
                } else {
                    $error = __('User already exists.  Password inherited.');
                }
            }
            else {
                $message = [
                    'status' => 0,
                    'message' => 'Username already exist'
                ];
                header('Content-type: application/json');
                echo json_encode($message, JSON_PRETTY_PRINT);
            }
            $validotp = null;
        }
        else{
            $message = [
                'status' => 0,
                'message' => 'OTP Invalid'
            ];
            header('Content-type: application/json');
            echo json_encode($message, JSON_PRETTY_PRINT);
            $validotp = null;
        }






        ///user_id_exists($user_name);
    }


}


const API_TOKEN = "9d105121-972e-4c0a-838d-3ec43c077cc4"; //put ssl provided api_token here
const SID = "SHANTAIDAPI"; // put ssl provided sid here
const DOMAIN = "https://smsplus.sslwireless.com"; //api domain // example http://smsplus.sslwireless.com




function create_customer_sms($request){
    global $wpdb;

    $body = $request->get_body();
    //$body_params = $_POST['user_login'];

    $mobilename = $request->get_param('user_phone');

    $tablename = $wpdb->prefix . "userotp_verifcation";
    $otp = rand(100000,999999);
    $msisdn = $mobilename;
    $messageBody = "Your Registration OTP token is -" . $otp;
    $csmsId = rand(345, 4987)."2934fe343"; // csms id must be unique



    $params = [
        "api_token" => API_TOKEN,
        "sid" => SID,
        "msisdn" => $msisdn,
        "sms" => $messageBody,
        "csms_id" => $csmsId
    ];
    $url = trim(DOMAIN, '/')."/api/v3/send-sms";
    $params = json_encode($params);
    $ch = curl_init(); // Initialize cURL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($params),
        'accept:application/json'
    ));

    $response = curl_exec($ch);

    curl_close($ch);

    $get_phone = $wpdb->get_row("SELECT * FROM {$tablename} WHERE number={$msisdn}", ARRAY_A);
    if (isset($get_phone)) {
        $insert = $wpdb->query($wpdb->prepare("UPDATE $tablename SET 
        otp='{$otp}' WHERE number={$msisdn}"));

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        $success = dbDelta($insert);
    }
    else {
        $success = $wpdb->insert(
            $tablename,
            array(
                'number' => esc_attr($msisdn),
                'otp' => esc_attr($otp),
            )
        );



    }
    return $response;


}


function user_id_exists($user_id)
{
    global $wpdb;

    // Check cache:
    if (wp_cache_get($user_id, 'users')) return true;

    // Check database:
    if ($wpdb->get_var($wpdb->prepare("SELECT EXISTS (SELECT 1 FROM $wpdb->users WHERE user_login = %s)", $user_id))) return true;

    return false;
}

//update customer
function update_customer($request)
{
    global $wpdb;

    $user_id = $request->get_param('user_id');
    $user_nicename = $request->get_param('username');
    $first_name = $request->get_param('first_name');
    $last_name = $request->get_param('last_name');
    $email = $request->get_param('email');
    $gender = $request->get_param('gender');
    $date_of_birth = $request->get_param('date_of_birth');
    $user_phone = $request->get_param('user_phone');
    $avatar_url = $request->get_param('avatar_url');
    $billing_address = $request->get_param('billing_address');
    $shipping_address = $request->get_param('shipping_address');
    $tablename = $wpdb->prefix . 'users';
    if (is_wp_error($user_id)) {
        return $user_id;
    }

    if (!empty($user_nicename)) {

        $display_name = $first_name . " " . $last_name;

        $insert = $wpdb->query($wpdb->prepare("UPDATE $tablename SET 
        user_login='{$user_nicename}'  WHERE ID={$user_id}"));

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        $success = dbDelta($insert);

    }
    if (!empty($email)) {

        $display_name = $first_name . " " . $last_name;

        $insert = $wpdb->query($wpdb->prepare("UPDATE $tablename SET 
        user_email='{$email}'  WHERE ID={$user_id}"));

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        $success = dbDelta($insert);

    }
    if (!empty($gender)) {

        $display_name = $first_name . " " . $last_name;

        $insert = $wpdb->query($wpdb->prepare("UPDATE $tablename SET 
        gender='{$gender}'  WHERE ID={$user_id}"));

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        $success = dbDelta($insert);

    }
    if (!empty($date_of_birth)) {

        $display_name = $first_name . " " . $last_name;

        $insert = $wpdb->query($wpdb->prepare("UPDATE $tablename SET 
        date_of_birth='{$date_of_birth}'  WHERE ID={$user_id}"));

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        $success = dbDelta($insert);

    }
    if (!empty($billing_address)) {

        foreach ($billing_address as $meta_key => $meta_value) {

            update_user_meta($user_id, $meta_key, $meta_value);
        }


    }
    if (!empty($user_phone)) {

        $display_name = $first_name . " " . $last_name;
        $insert = $wpdb->query($wpdb->prepare("UPDATE $tablename SET 
        user_phone='{$user_phone}'  WHERE ID={$user_id}"));

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        $success = dbDelta($insert);

    }
    if (!empty($shipping_address)) {


        foreach ($shipping_address as $meta_key => $meta_value) {

            update_user_meta($user_id, $meta_key, $meta_value);
        }


    }

    $customer = new WC_Customer($user_id);

    $user_nicenames = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}users where ID={$user_id}", ARRAY_A);

    $display_name = $customer->get_first_name() . "" . $customer->get_last_name();
    $data = array(

        'username' => $customer->get_username(),
        "first_name" => $customer->get_first_name(),
        "last_name" => $customer->get_last_name(),
        'email' => $customer->get_email(),
        'gender' => $user_nicenames[0]['gender'],
        'date_of_birth' => $user_nicenames[0]['date_of_birth'],
        'user_phone' => $user_nicenames[0]['user_phone'],
        'avatar_url' => $customer->get_avatar_url(),
        'billing_address' => array(
            'first_name' => $customer->get_billing_first_name(),
            'last_name' => $customer->get_billing_last_name(),
            'company' => $customer->get_billing_company(),
            'address_1' => $customer->get_billing_address_1(),
            'address_2' => $customer->get_billing_address_2(),
            'city' => $customer->get_billing_city(),
            'state' => $customer->get_billing_state(),
            'postcode' => $customer->get_billing_postcode(),
            'country' => $customer->get_billing_country(),
            'email' => $customer->get_billing_email(),
            'phone' => $customer->get_billing_phone(),
        ),
        'shipping_address' => array(
            'first_name' => $customer->get_shipping_first_name(),
            'last_name' => $customer->get_shipping_last_name(),
            'company' => $customer->get_shipping_company(),
            'address_1' => $customer->get_shipping_address_1(),
            'address_2' => $customer->get_shipping_address_2(),
            'city' => $customer->get_shipping_city(),
            'state' => $customer->get_shipping_state(),
            'postcode' => $customer->get_shipping_postcode(),
            'country' => $customer->get_shipping_country(),
        ),
    );


    header('Content-type: application/json');
    echo json_encode($data, JSON_PRETTY_PRINT);
}


//get all customer
function get_all_customer($request)
{

    global $wpdb;

    $user_id = $request->get_param('user_id');
    if (is_wp_error($user_id)) {
        return $user_id;
    }
    $customer = new WC_Customer($user_id);
    $user_nicenames = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}users where ID={$user_id}", ARRAY_A);

    $display_name = $customer->get_first_name() . "" . $customer->get_last_name();
    $data = array(

        'username' => $customer->get_username(),

        "first_name" => $customer->get_first_name(),
        "last_name" => $customer->get_last_name(),
        'email' => $customer->get_email(),
        'gender' => $user_nicenames[0]['gender'],
        'date_of_birth' => $user_nicenames[0]['date_of_birth'],
        'user_phone' => $user_nicenames[0]['user_phone'],
        'avatar_url' => $customer->get_avatar_url(),
        'billing_address' => array(
            'first_name' => $customer->get_billing_first_name(),
            'last_name' => $customer->get_billing_last_name(),
            'company' => $customer->get_billing_company(),
            'address_1' => $customer->get_billing_address_1(),
            'address_2' => $customer->get_billing_address_2(),
            'city' => $customer->get_billing_city(),
            'state' => $customer->get_billing_state(),
            'postcode' => $customer->get_billing_postcode(),
            'country' => $customer->get_billing_country(),
            'email' => $customer->get_billing_email(),
            'phone' => $customer->get_billing_phone(),
        ),
        'shipping_address' => array(
            'first_name' => $customer->get_shipping_first_name(),
            'last_name' => $customer->get_shipping_last_name(),
            'company' => $customer->get_shipping_company(),
            'address_1' => $customer->get_shipping_address_1(),
            'address_2' => $customer->get_shipping_address_2(),
            'city' => $customer->get_shipping_city(),
            'state' => $customer->get_shipping_state(),
            'postcode' => $customer->get_shipping_postcode(),
            'country' => $customer->get_shipping_country(),
        ),
    );


    header('Content-type: application/json');
    echo json_encode($data, JSON_PRETTY_PRINT);
}

function get_all_prodcut()
{


    global $product;
    $product = wc_get_product();
    $oldAttr = null;
    $op = array();
    $cats = array();
    $attr = array();
    $array = array();
    $cats = array();
    $args = array_map('wc_get_product', get_posts(['post_type' => 'product', 'nopaging' => true]));


    foreach ($args as $single) {
        $meta = get_post_meta($single->id);


        $image2 = wp_get_attachment_image_url($single->image_id, 'full');
        $link = $image2;
        foreach ($single->gallery_image_ids as $single_image) {


            $image2 = wp_get_attachment_image_url($single_image, 'full');


            $cats [] = $image2;


        }


        if (isset($meta["_product_attributes"][0])) {
            $oldAttr = unserialize($meta["_product_attributes"][0]);
        }

        $newAttr = [];


        if (!empty($oldAttr)) {
            foreach ($oldAttr as $key => $attr) {

                $name_term = get_the_terms($single->id, $attr['name']);
                if (!empty($name_term)) {
                    foreach ($name_term as $key => $term) {
                        //var_dump($term);
                        if (isset($term->taxonomy)) {
                            //   var_dump($term);
                            $term->url = get_term_link($term->term_id, $term->taxonomy);
                            $newAttr[$term->taxonomy][$term->slug] = (array)$term;
                        }

                    }
                }


            }
        }


        $attr [] = $newAttr;


        $product = new WC_Product_Variable($single->id);
        $variations = $product->get_available_variations();
        $var_data = [];
        $var_data_2 = [];
        $gallery = [];

        $tag = [];


        foreach ($single->tag_ids as $tagname) {


            /// var_dump($tagname);
            $terms_list = get_term_by('id', $tagname, 'product_tag', 'ARRAY_A');
            //var_dump($terms_list);

            $tag [] = $terms_list;


        }
        //var_dump($tag);

        foreach ($variations as $key => $variation) {
            $variation__id = $variation['variation_id'];
            $has_variation_gallery_images = get_post_meta($variation__id, 'rtwpvg_images', true);

            if ($has_variation_gallery_images) {

                foreach ($has_variation_gallery_images as $single_id) {
                    $image3 = wp_get_attachment_image_url($single_id, 'full');


                    $var_data_2 [] = $image3;

                    $variation['variation_gallery_images'] = $var_data_2;
//                    array_replace($variation['variation_gallery_images'],$var_data_2);

                }
            }
            $var_data_2 = null;

            $var_data  [] = $variation;
//            $var_data [] = array(
//                'attributes' => $variation['attributes'],
//                'availability_html' => $variation['availability_html'],
//                'backorders_allowed' => $variation['backorders_allowed'],
//                'dimensions' => $variation['dimensions'],
//                'dimensions_html' => $variation['dimensions_html'],
//                'display_price' => $variation['display_price'],
//                'display_regular_price' => $variation['display_regular_price'],
//                'image' => $variation['image'],
//                'image_id' => $variation['image_id'],
//                'is_downloadable' => $variation['is_downloadable'],
//                'is_in_stock' => $variation['is_in_stock'],
//                'is_purchasable' => $variation['is_purchasable'],
//                'is_sold_individually' => $variation['is_sold_individually'],
//                'is_virtual' => $variation['is_virtual'],
//                'max_qty' => $variation['max_qty'],
//                'min_qty' => $variation['min_qty'],
//                'price_html' => $variation['price_html'],
//                'sku' => $variation['sku'],
//                'variation_description' => $variation['variation_description'],
//                'variation_id' => $variation['variation_id'],
//                'variation_is_active' => $variation['variation_is_active'],
//                'variation_is_visible' => $variation['variation_is_visible'],
//                'weight' => $variation['weight'],
//                'weight_html' => $variation['weight_html'],
//                'variation_gallery_images' =>  $var_data_2,
//
//
//
//            );

        }

        $array = array(
            'id' => $single->id,
            'name' => $single->name,
            'slug' => $single->slug,
            'date_created' => $single->date_created,
            'date_modified' => $single->date_modified,
            'status' => $single->status,
            'featured' => $single->featured,
            'catalog_visibility' => $single->catalog_visibility,
            'description' => $single->description,
            'short_description' => $single->short_description,
            'sku' => $single->sku,
            'price' => $single->price,
            'regular_price' => $single->regular_price,
            'sale_price' => $single->sale_price,
            'date_on_sale_from' => $single->date_on_sale_from,
            'date_on_sale_to' => $single->date_on_sale_to,
            'total_sales' => $single->total_sales,
            'tax_status' => $single->tax_status,
            'tax_class' => $single->tax_class,
            'manage_stock' => $single->manage_stock,
            'stock_quantity' => $single->stock_quantity,
            'stock_status' => $single->stock_status,
            'backorders' => $single->backorders,
            'low_stock_amount' => $single->low_stock_amount,
            'weight' => $single->weight,
            'length' => $single->length,
            'width' => $single->width,
            'height' => $single->height,
            'upsell_ids' => $single->upsell_ids,
            'cross_sell_ids' => $single->cross_sell_ids,
            'parent_id' => $single->parent_id,
            'reviews_allowed' => $single->reviews_allowed,
            'purchase_note' => $single->purchase_note,
            'attributes' => $attr,
            'default_attributes' => $single->default_attributes,
            'menu_order' => $single->menu_order,
            'post_password' => $single->post_password,
            'virtual' => $single->virtual,
            'downloadable' => $single->downloadable,
            'category_ids' => $single->category_ids,
            'tag_ids' => $tag,
            'shipping_class_id' => $single->shipping_class_id,
            'downloads' => $single->downloads,
            'image_id' => $link,
            'gallery_image_ids' => $cats,
            'download_limit' => $single->download_limit,
            'download_expiry' => $single->download_expiry,
            'rating_counts' => $single->rating_counts,
            'average_rating' => $single->average_rating,
            'review_count' => $single->review_count,
            'product_url' => $single->product_url,
            'button_text' => $single->button_text,
            'meta_data' => $meta,
            'variation' => $var_data,


        );
        $cats = null;
        $op[] = $array;
    }


    header('Content-type: application/json');
    echo json_encode($op, JSON_PRETTY_PRINT);

}

//add product to the cart
function add_product_to_cart($request)
{

    $body = $request->get_body();
    $user_id = $request->get_param('user_id');
    $product_id = $request->get_param('product_id');


    $array = array();
    $price = null;
    $image = null;
    $count = $request->get_param('count');
    if (empty($variable_id)) {
        $variable_id = null;
    }
    if (!empty($user_id) and !empty($product_id)) {
        global $wpdb;
        $tablename = $wpdb->prefix . 'customcart';
        $product = wc_get_product($product_id);
        $sku = $product->sku;
        $name = $product->name;
        $price = $product->price;
        $image = wp_get_attachment_image_url($product->image_id, 'full');

        $post_id = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}customcart where user_id = {$user_id} and product_id = {$product_id}");

        $cart_id = null;
        foreach ($post_id as $id) {

            $cart_id = $id->id;
        }


        if (empty($post_id)) {


            $success = $wpdb->insert(
                $tablename,
                array(
                    'user_id' => esc_attr($user_id),
                    'product_id' => esc_attr($product_id),
                    'sku' => esc_attr($sku),
                    'product_name' => esc_attr($name),
                    'image_id' => esc_url($image),
                    'price' => esc_attr($price),
                    'count' => esc_attr($count)
                )
            );

            if ($success) {
                $user_nicenames = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}customcart where user_id = {$user_id} and product_id = {$product_id}", ARRAY_A);

                $product = array();
                foreach ($user_nicenames as $nicename) {
                    $product2 = wc_get_product($nicename['product_id']);
                    //$product = $nicename;


                    // var_dump($product->parent_id);
                    $product = array(
                        'id' => $nicename['id'],
                        'user_id' => $nicename['user_id'],
                        'product_id' => $nicename['product_id'],
                        'parent_id' => $product2->parent_id,
                        'product_name' => $nicename['product_name'],
                        'sku' => $nicename['sku'],
                        'image_id' => $nicename['image_id'],
                        'price' => $nicename['price'],
                        'count' => $nicename['count'],
                    );
                }

                header('Content-type: application/json');
                echo json_encode($product, JSON_PRETTY_PRINT);

            } else {
                $wpdb->print_error();
                echo "Not inserted";
            }
        } else {

            $insert = $wpdb->query($wpdb->prepare("UPDATE {$wpdb->prefix}customcart SET count={$count} WHERE id={$cart_id}"));

            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            $success = dbDelta($insert);
            $user_nicenames = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}customcart where user_id = {$user_id} and product_id = {$product_id}", ARRAY_A);

            $product = array();
            foreach ($user_nicenames as $nicename) {

                $product2 = wc_get_product($nicename['product_id']);
                //$product = $nicename;


                // var_dump($product->parent_id);
                $product = array(
                    'id' => $nicename['id'],
                    'user_id' => $nicename['user_id'],
                    'product_id' => $nicename['product_id'],
                    'parent_id' => $product2->parent_id,
                    'product_name' => $nicename['product_name'],
                    'sku' => $nicename['sku'],
                    'image_id' => $nicename['image_id'],
                    'price' => $nicename['price'],
                    'count' => $nicename['count'],
                );
            }

            header('Content-type: application/json');
            echo json_encode($product, JSON_PRETTY_PRINT);


        }
    }


}

function add_product_to_cart_marge($request)
{
    $flag1 = false;
    $flag2 = false;
    $ids = array();
    $ids2 = array();
    $body = $request->get_body();
    $user_id = $request->get_param('user_id');
    $product_id = $request->get_param('product_cart');
    $product_ids = null;
    $product_count = null;
    $array = array();
    $price = null;
    $product_id_arrya = array();
    $image = null;
    foreach ($product_id as $product) {
        $product_ids = $product['product_id'];
        $product_count = $product['count'];


        if (!empty($user_id) and !empty($product_id)) {
            global $wpdb;
            $tablename = $wpdb->prefix . 'customcart';
            $product = wc_get_product($product_ids);
            $sku = $product->sku;
            $name = $product->name;
            $price = $product->price;
            $image = wp_get_attachment_image_url($product->image_id, 'full');
            $exist_arry = array();
            $nonexist_arry = array();
            $post_id = $wpdb->get_results("SELECT product_id,count FROM {$wpdb->prefix}customcart where user_id = {$user_id} and product_id = {$product_ids}");

            $cart_id = null;

            if ($post_id == true) {
                foreach ($post_id as $id) {
                    $get_present_count = $id->count + $product_count;
                    $exist_arry [] = $id;
                    foreach ($exist_arry as $pro) {

                        $post_id = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}customcart where user_id = {$user_id} and product_id = {$pro->product_id}");

                        $cart_id = null;
                        foreach ($post_id as $id) {

                            $cart_id = $id->id;
                        }


                        $insert = $wpdb->query($wpdb->prepare("UPDATE {$wpdb->prefix}customcart SET count={$get_present_count} WHERE id={$cart_id}"));

                        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
                        $success = dbDelta($insert);
                        if ($success) {
                            $flag1 = true;
                        }


                    }

                }

            } elseif ($post_id == false) {
                $nonexist_arry[] = $product_ids;
                foreach ($nonexist_arry as $pro) {


                    $product = wc_get_product($pro);
                    $sku = $product->sku;
                    $name = $product->name;
                    $price = $product->price;
                    $image = wp_get_attachment_image_url($product->image_id, 'full');

                    $success = $wpdb->insert(
                        $tablename,
                        array(
                            'user_id' => esc_attr($user_id),
                            'product_id' => esc_attr($pro),
                            //'parent_id' => esc_attr($product->parent_id),
                            'sku' => esc_attr($sku),
                            'product_name' => esc_attr($name),
                            'image_id' => esc_url($image),
                            'price' => esc_attr($price),
                            'count' => esc_attr($product_count)
                        )
                    );

                    if ($success) {
                        $flag2 = true;
                    } else {
                        $wpdb->print_error();
                        // echo "Not inserted";
                    }

                }
            }


            if ($flag1 == true || $flag2 == false) {

                $full_data = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}customcart where user_id = {$user_id} ");

                header('Content-type: application/json');
                echo json_encode($full_data, JSON_PRETTY_PRINT);

                break;
            }
            if (($flag1 == false) || $flag2 == true) {
                $full_data = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}customcart where user_id = {$user_id} ");


                header('Content-type: application/json');
                echo json_encode($full_data, JSON_PRETTY_PRINT);
                break;
            }
            if (($flag1 == false) || $flag2 == false) {
                $full_data = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}customcart where user_id = {$user_id} ");


                header('Content-type: application/json');
                echo json_encode($full_data, JSON_PRETTY_PRINT);
                break;
            }
            if (($flag1 == true) || $flag2 == true) {
                $full_data = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}customcart where user_id = {$user_id} ");


                header('Content-type: application/json');
                echo json_encode($full_data, JSON_PRETTY_PRINT);
                break;
            }

        }
    }


}

function remove_item_from_cart($request)
{

    global $wpdb;
    $body = $request->get_body();
    $product = $request->get_param('product');
    $user_id = $request->get_param('user_id');
    $flag = $request->get_param('flag');
    $count_input = $request->get_param('count');

    $array = array();


    $post_id = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}customcart where user_id = {$user_id} and product_id = {$product}");

    $cart_id = null;
    foreach ($post_id as $id) {
        $count = $id->count;
        $cart_id = $id->id;
        $array [] = $id;
    }

    if (!empty($cart_id)) {

        if ($flag == true) {
            $count_input = esc_attr($count + $count_input);
        }
        if ($flag == false) {
            $count_input = esc_attr($count - $count_input);

            if ($count_input == 0) {
                $tablename = $wpdb->prefix . 'customcart';
                $wpdb->delete($tablename, array('id' => $cart_id));
            }
        }
        $insert = $wpdb->query($wpdb->prepare("UPDATE {$wpdb->prefix}customcart SET count={$count_input} Where user_id = {$user_id} and product_id = {$product}"));

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($insert);


        $user_nicenames = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}customcart where user_id = {$user_id} and product_id ={$product} ", ARRAY_A);

        $product = array();
        foreach ($user_nicenames as $nicename) {

            $product2 = wc_get_product($nicename['product_id']);
            //$product = $nicename;


            // var_dump($product->parent_id);
            $product = array(
                'id' => $nicename['id'],
                'user_id' => $nicename['user_id'],
                'product_id' => $nicename['product_id'],
                'parent_id' => $product2->parent_id,
                'product_name' => $nicename['product_name'],
                'sku' => $nicename['sku'],
                'image_id' => $nicename['image_id'],
                'price' => $nicename['price'],
                'count' => $nicename['count'],
            );
        }

        header('Content-type: application/json');
        echo json_encode($product, JSON_PRETTY_PRINT);
    }


}

function get_all_cart($request)
{
    global $wpdb;

    $user_id = $request->get_param('user_id');
    global $wpdb;
    $post_id = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}customcart where user_id={$user_id}");

    $all = array();
    $data = array();
    $deliveryfee = get_option('woocommerce_flat_rate_2_settings');

    $taxrates = null;
    $tax_classes = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}woocommerce_tax_rates where tax_rate_id=1");

    if (!empty($tax_classes)) {
        foreach ($tax_classes as $itemSingle) {
            $taxrates = $itemSingle->tax_rate;
        }

    }


    foreach ($post_id as $id) {
        $product = wc_get_product($id->product_id);
        // var_dump($product->parent_id);
        $all[] = array(
            'id' => $id->id,
            'user_id' => $id->user_id,
            'product_id' => $id->product_id,
            'parent_id' => $product->parent_id,
            'product_name' => $id->product_name,
            'sku' => $id->sku,
            'image_id' => $id->image_id,
            'price' => $id->price,
            'count' => $id->count,

        );

    }


    $data = array(
        'partial_payment' => $partial_payment = get_option('partial_payment'),
        'delivery_fee' => $deliveryfee['cost'],
        'tax_rate' => $taxrates,
        'cart' => $all
    );


    header('Content-type: application/json');
    echo json_encode($data, JSON_PRETTY_PRINT);

}


function clear_all_cart($request)
{
    global $wpdb;
    $tablename = $wpdb->prefix . 'customcart';

    $user_id = $request->get_param('user_id');

    $wpdb->delete($tablename, array('user_id' => $user_id));
    $post_id = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}customcart where user_id={$user_id}");

    $all = array();
    foreach ($post_id as $id) {
        $all[] = $id;

    }

    header('Content-type: application/json');
    echo json_encode($all, JSON_PRETTY_PRINT);

}

//login customer api
function login_customer($request)
{
    global $wpdb;
    global $wp_hasher;
    $table_name = $wpdb->prefix . 'mobile_users';
    $user_table = $wpdb->prefix . 'users';
    $token = $request->get_param('token');
    $user_phone = $request->get_param('user_phone');
    $user_pass_plane = $request->get_param('user_pass');

    $user_pass_chek = $wpdb->get_results("SELECT ID,token,user_nicename ,user_phone,user_email,user_url,display_name,country_code,user_pass FROM {$wpdb->prefix}users WHERE user_phone = '$user_phone'", ARRAY_A);

    if ($user_pass_chek == true) {
        $userdata [] = null;
        foreach ($user_pass_chek as $nice_name) {
            $user_pass = $nice_name['user_pass'];
            $id = $nice_name['ID'];
            $user_phone = $request->get_param('user_phone');
            $userdata = [
                'id' => $nice_name['ID'],
                'token' => $nice_name['token'],
                'user_nicename' => $nice_name['user_nicename'],
                'user_phone' => $nice_name['user_phone'],
                'user_email' => $nice_name['user_email'],
                'user_url' => $nice_name['user_url'],
                'display_name' => $nice_name['display_name'],
                'country_code' => $nice_name['country_code'],
                //  'user_pass' => $nice_name['user_pass'],


            ];
            if (wp_check_password($user_pass_plane, $user_pass)) {

                return $userdata;
            } else {
                $message = [
                    'status' => 0,
                    'message' => 'Password Incorrect'
                ];

                return $message;
            }

        }
    } else {
        $message = [
            'status' => 0,
            'message' => 'Phone number not exists'
        ];

        return $message;
    }


}

//change password
function changepassword($request)
{
    global $wpdb;
    $user_id = $request->get_param('user_id');
    $token = $request->get_param('token');
    $old = $request->get_param('old_password');
    $new = $request->get_param('new_password');
    $user_nicenames = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}users where ID=$user_id", ARRAY_A);

    if ($user_nicenames) {

        foreach ($user_nicenames as $details) {
            if ($token == $details['token']) {
                if (wp_check_password($old, $details['user_pass'])) {
                    $password = wp_hash_password($new);
                    $user_table = $wpdb->prefix . 'users';
                    $insert = $wpdb->query($wpdb->prepare("UPDATE $user_table SET user_pass= '$password'  WHERE ID=$user_id"));

                    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
                    dbDelta($insert);

                    $message = [
                        'status' => 1,
                        'message' => 'Password Changed Successfully'
                    ];

                    return $message;
                } else {
                    $message = [
                        'status' => 0,
                        'message' => 'Password does not match'
                    ];
                    return $message;
                }
            } else {
                $message = [
                    'status' => 0,
                    'message' => 'Token does not match'
                ];
                return $message;
            }
        }
    } else {
        $message = [
            'status' => 0,
            'message' => 'User not exist'
        ];
        return $message;

    }
}


function changepassword_forget($request)
{
    global $wpdb;
    $user_id = $request->get_param('user_phone');
    $token = $request->get_param('verify_token');
    //$old = $request->get_param('old_password');
    $new = $request->get_param('new_password');
    $user_nicenames = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}users where user_phone=$user_id", ARRAY_A);

    if ($user_nicenames) {

        foreach ($user_nicenames as $details) {
            if ($token == $details['verify_token']) {
                $password = wp_hash_password($new);
                $user_table = $wpdb->prefix . 'users';
                $insert = $wpdb->query($wpdb->prepare("UPDATE $user_table SET user_pass= '$password'  WHERE user_phone=$user_id"));

                require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
                dbDelta($insert);

                $message = [
                    'status' => 1,
                    'message' => 'Password Changed Successfully'
                ];

            } else {
                $message = [
                    'status' => 0,
                    'message' => 'Token does not match'
                ];
                return $message;
            }
        }
    } else {
        $message = [
            'status' => 0,
            'message' => 'User not exist'
        ];
        return $message;

    }
}


//forget password
function get_the_verification_code($request)
{
    global $wpdb;
    $table_name = $wpdb->prefix . "users";
    $user_phone = $request->get_param('user_phone');
    $get_all_phone = $wpdb->get_results("SELECT * FROM {$table_name} where user_phone={$user_phone}");


    if ($get_all_phone) {
        $check = false;
        $message[] = null;
        $six_digit_random_number = random_int(100000, 999999);
        $user_table = $wpdb->prefix . 'users';
        $insert = $wpdb->query($wpdb->prepare("UPDATE $user_table SET verify_token= '$six_digit_random_number'  WHERE user_phone=$user_phone"));

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($insert);

        $message = [
            'status' => 1,
            'message' => 'Your verification code has been sent to your number',
            'code' => $six_digit_random_number
        ];

        return $message;
    } else {
        $message = [
            'status' => 0,
            'message' => 'Mobile number is not valid'
        ];

        return $message;
    }


}


//varification code match
function get_the_verification_code_match($request)
{

    global $wpdb;
    $varification = $request->get_param('verify_token');
    $user_phone_check = $request->get_param('user_phone');
    $user_nicenames = $wpdb->get_results("SELECT verify_token FROM {$wpdb->prefix}users where user_phone={$user_phone_check}", ARRAY_A);
    $check = false;
    foreach ($user_nicenames as $nice_name) {
        //echo var_dump($nice_name);
        if ($nice_name['verify_token'] == $varification) {
            $check = true;
        } else {
            $check = false;
        }
    }
    $message[] = null;
    if ($check == true) {


        $message = [
            'status' => 1,
            'message' => 'Verification code matched successfully'
        ];

        return $message;
    }
    if ($check == false) {
        $message = [
            'status' => 0,
            'message' => 'Verification Code is not valid'
        ];

        return $message;
    }
}


//get fav item
function get_district_information($data)
{
    $user_id = $data['id'];
    if (!$user_id) {
        $user_id = get_current_user_id();
    }
    $favourites = get_user_meta($user_id, '_simple_favourites_string', true);
    if (empty($favourites)) {
        $favourites = array();
    }
    foreach ($favourites as $index => $product_id) {
        global $product;
        $variations = $product_id['variation_id'];
        $product = $product_id['id'];
        $quantity = $product_id['product_qty'];
        $product = wc_get_product($product_id['id']);

        if ($product->is_type('simple')) {
            $product = wc_get_product($product_id['id']);

        } elseif ($product->is_type('variable')) {
            $product = wc_get_product($product_id['variation_id']);

        }

        //    $variations = $product_id['variation_id'];
        // $result = wc_get_product_variation_attributes($variations);
//        $product_variation = wc_get_product($variations);
        echo $product;

    }


    //   return null;
}


function add_Post_to_fav($rest_request)
{
    global $products_controler;
    if (!isset($rest_request['status']))
        $rest_request['status'] = 'publish';
    $wp_rest_request = new WP_REST_Request('POST');
    $wp_rest_request->set_body_params($rest_request);
    return $products_controler->create_item($wp_rest_request);


    //   return null;
}


function get_category_details($data)
{
    $iteam_array = [];
    $children = get_term_children($data['id'], "product_cat");
    $op = array();
    $array = array();

    foreach ($children as $key => $category) {
        $cat = [];
        $term = get_term_by('id', $category, "product_cat");
        $cat[$key] = $term;


        $op = array(
            "term_id" => $term->term_id,
            "name" => $term->name,
            "slug" => $term->slug,
            "term_group" => $term->term_group,
            "term_taxonomy_id" => $term->term_taxonomy_id,
            "taxonomy" => $term->taxonomy,
            "description" => $term->description,
            "parent" => $term->parent,
            "filter" => $term->filter,
            "image_url" => wp_get_attachment_url(get_term_meta($term->term_id, 'thumbnail_id', true)),
        );

        $array[] = $op;
    }
    header('Content-type: application/json');
    echo json_encode($array, JSON_PRETTY_PRINT);
}


function getallpagedate($data)
{

    $array = array();
    $id = null;
    $id = $data['id'];
    $myposts = get_post($id);
    $meta = get_post_meta($id);
    $array = array(
        "id" => $id,
        "post_name" => $myposts->post_name,
        "post_status" => $myposts->post_status,
        "post_excerpt" => $myposts->post_excerpt,
        "post_content" => $myposts->post_content,
        "meta" => $meta,
        "post_title" => $myposts->post_title,
        "thumbnail" => get_the_post_thumbnail_url($id),


        "guid" => $myposts->guid,
    );


    header('Content-type: application/json');
    echo json_encode($array, JSON_PRETTY_PRINT);
}


function get_all_post()
{
    $op = array();
    $cats = array();
    $array = array();
    // $products_all = new WP_Query($argments);
    $extra_banner = array();

    $args = array(
        'post_type' => 'post',
        'orderby' => 'ID',
        'post_status' => 'publish',
        'order' => 'DESC',
        'posts_per_page' => -1 // this will retrive all the post that is published
    );


    $posts = get_posts($args);
    foreach ($posts as $single) : setup_postdata($single);


        // var_dump($single);
        $meta = get_post_meta($single->ID);
        $extra_banner = wp_get_attachment_url($meta['extra_banner'][0], 'full', true);
        //var_dump(wp_get_attachment_url(get_post_thumbnail_id($meta['extra_banner']), 'full', true));
        $post_categories = wp_get_post_categories($single->ID);
        foreach ($post_categories as $c) {
            $cat = get_category($c);

            $cats[] = array('name' => $cat->name, 'slug' => $cat->slug);
            $cats[] = array('name' => $cat->name, 'slug' => $cat->slug);
        }
        $src = wp_get_attachment_url(get_post_thumbnail_id($single->ID), 'full', true);


        // $meta= get_post_meta($single->ID,true);

        $array = array(
            'ID' => $single->ID,
            'post_author' => $single->post_author,
            'post_date' => $single->post_date,
            'post_feature_image' => $src,
            'post_date_gmt' => $single->post_date_gmt,
            'post_content' => $single->post_content,
            'post_title' => $single->post_title,
            'post_excerpt' => $single->post_excerpt,
            'post_status' => $single->post_status,
            'comment_status' => $single->comment_status,
            'ping_status' => $single->ping_status,
            'post_password' => $single->post_password,
            'post_name' => $single->post_name,
            'to_ping' => $single->to_ping,
            'post_modified' => $single->post_modified,
            'post_modified_gmt' => $single->post_modified_gmt,
            'post_content_filtered' => $single->post_content_filtered,
            'post_parent' => $single->post_parent,
            'guid' => $single->guid,
            'menu_order' => $single->menu_order,
            'post_type' => $single->post_type,
            'post_mime_type' => $single->post_mime_type,
            'comment_count' => $single->comment_count,
            'filter' => $single->filter,
            'category' => $cats,
            'meta' => $meta,
            'custom_extra_banner' => $extra_banner
        );

        // return $array;
        $op[] = $array;

        wp_reset_postdata(); endforeach;

    header('Content-type: application/json');
    echo json_encode($op, JSON_PRETTY_PRINT);

}


function get_product_from_all()
{

    $iteam_array = [];
    $children = get_terms(array(
        'taxonomy' => 'product_cat',
        'hide_empty' => false,
    ));
    $op = array();
    $array = array();
    foreach ($children as $key => $category) {
        $iteam_array = [$category];
        $link = "";
        /* push the item on to the result array */

        $image = get_term_meta($category->term_id, 'thumbnail_id', true);

        $image2 = wp_get_attachment_url(get_term_meta($category->term_id, 'thumbnail_id', true));
        $link = $image2;
        $op = array(
            "term_id" => $category->term_id,
            "name" => $category->name,
            "slug" => $category->slug,
            "term_group" => $category->term_group,
            "term_taxonomy_id" => $category->term_taxonomy_id,
            "taxonomy" => $category->taxonomy,
            "description" => $category->description,
            "parent" => $category->parent,
            "filter" => $category->filter,
            "image_url" => wp_get_attachment_url(get_term_meta($category->term_id, 'thumbnail_id', true)),
        );

        $array[] = $op;


    }
    header('Content-type: application/json');
    echo json_encode($array);
}

function get_product_from_cat($data)
{
    $term = get_term_by('id', $data['id'], 'product_cat', 'ARRAY_A');


    $terms = get_the_terms($data['id'], 'product_cat');

    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'product_cat' => $term['slug'],
    );
    $products_all = new WP_Query($args);
    $posts = $products_all->get_posts();
    $array = array();
    $op = array();
    $image_array = array();
    foreach ($posts as $index => $singe) {
        $posts = $singe->ID;
        $product = wc_get_product($singe->ID);
        $image = $product->gallery_image_ids;
        foreach ($image as $index => $link) {


//            $image_array = [
//                "url" => $link,
//            ];
            $image_array[] = wp_get_attachment_url($link, 'full', false);

        }


        $product = new WC_Product_Variable($singe->ID);
        $variations = $product->get_available_variations();
        $var_data = [];
        $var_data_2 = [];
        foreach ($variations as $key => $variation) {
            $variation__id = $variation['variation_id'];
            $has_variation_gallery_images = get_post_meta($variation__id, 'rtwpvg_images', true);

            if ($has_variation_gallery_images) {

                foreach ($has_variation_gallery_images as $single_id) {
                    $image3 = wp_get_attachment_image_url($single_id, 'full');


                    $var_data_2 [] = $image3;

                    $variation['variation_gallery_images'] = $var_data_2;
//                    array_replace($variation['variation_gallery_images'],$var_data_2);

                }
            }
            $var_data_2 = null;

            $var_data  [] = $variation;
//            $var_data [] = array(
//                'attributes' => $variation['attributes'],
//                'availability_html' => $variation['availability_html'],
//                'backorders_allowed' => $variation['backorders_allowed'],
//                'dimensions' => $variation['dimensions'],
//                'dimensions_html' => $variation['dimensions_html'],
//                'display_price' => $variation['display_price'],
//                'display_regular_price' => $variation['display_regular_price'],
//                'image' => $variation['image'],
//                'image_id' => $variation['image_id'],
//                'is_downloadable' => $variation['is_downloadable'],
//                'is_in_stock' => $variation['is_in_stock'],
//                'is_purchasable' => $variation['is_purchasable'],
//                'is_sold_individually' => $variation['is_sold_individually'],
//                'is_virtual' => $variation['is_virtual'],
//                'max_qty' => $variation['max_qty'],
//                'min_qty' => $variation['min_qty'],
//                'price_html' => $variation['price_html'],
//                'sku' => $variation['sku'],
//                'variation_description' => $variation['variation_description'],
//                'variation_id' => $variation['variation_id'],
//                'variation_is_active' => $variation['variation_is_active'],
//                'variation_is_visible' => $variation['variation_is_visible'],
//                'weight' => $variation['weight'],
//                'weight_html' => $variation['weight_html'],
//                'variation_gallery_images' =>  $var_data_2,
//
//
//
//            );

        }

        $meta = get_post_meta($posts);
        $oldAttr = unserialize($meta["_product_attributes"][0]);
        $newAttr = [];
        foreach ($oldAttr as $key => $attr) {
            foreach (get_the_terms($posts, $attr['name']) as $key => $term) {
                $term->url = get_term_link($term->term_id, $term->taxonomy);
                $newAttr[$term->taxonomy][$term->slug] = (array)$term;
            }
        }
        $attr [] = $newAttr;


        $op = array(
            "id" => $product->id,
            "name" => $product->name,
            "slug" => $product->slug,
            "date_created" => $product->date_created,
            "status" => $product->status,
            "featured" => $product->featured,
            "catalog_visibility" => $product->catalog_visibility,
            "description" => $product->description,
            "short_description" => $product->short_description,
            "sku" => $product->sku,
            "price" => $product->price,
            "regular_price" => $product->regular_price,
            "sale_price" => $product->sale_price,
            "date_on_sale_from" => $product->date_on_sale_from,
            "date_on_sale_to" => $product->date_on_sale_to,
            "total_sales" => $product->total_sales,
            "tax_status" => $product->tax_status,
            "manage_stock" => $product->manage_stock,
            "stock_quantity" => $product->stock_quantity,
            "stock_status" => $product->stock_status,
            "backorders" => $product->backorders,
            "sold_individually" => $product->sold_individually,
            "weight" => $product->weight,
            "height" => $product->height,
            "upsell_ids" => $product->upsell_ids,
            "cross_sell_ids" => $product->cross_sell_ids,
            "parent_id" => $product->parent_id,
            "reviews_allowed" => $product->reviews_allowed,
            "purchase_note" => $product->purchase_note,
            "attributes" => $attr,
            "default_attributes" => $product->default_attributes,
            "menu_order" => $product->menu_order,
            "virtual" => $product->virtual,
            "downloadable" => $product->downloadable,
            "category_ids" => $product->category_ids,
            "tag_ids" => $product->tag_ids,
            "shipping_class_id" => $product->shipping_class_id,
            "downloads" => $product->downloads,
            "download_limit" => $product->download_limit,
            "download_limit" => $product->download_limit,
            "download_expiry" => $product->download_expiry,
            "rating_counts" => $product->rating_counts,
            "average_rating" => $product->average_rating,
            "review_count" => $product->review_count,
            "meta_data" => $product->meta_data,
            "average_rating" => $product->average_rating,
            "average_rating" => $product->average_rating,
            "image" => wp_get_attachment_url($product->image_id, 'full', false),
            "gallery" => $image_array,
            "variations" => $var_data

        );

        $array[] = $op;
    }

    header('Content-type: application/json');
    echo json_encode($array, JSON_PRETTY_PRINT);

}

function filter_product($request)
{
    $varification = $request->get_param('category_id');
    $price = $request->get_param('price');
    $colors = $request->get_param('colors');
    $width = $request->get_param('width');
    $height = $request->get_param('height');
    $material = $request->get_param('material');


    // echo $price;
    $term = get_term_by('id', $varification, 'product_cat', 'ARRAY_A');


    $terms = get_the_terms($varification, 'product_cat');


    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'product_cat' => $term['slug'],
    );
    $products_all = new WP_Query($args);
    $posts = $products_all->get_posts();
    $output = array();
    $image_array = array();
    $var = array();
    $array = array();
    $op = array();

    foreach ($posts as $index => $singe) {
        $posts = $singe->ID;

        $product = wc_get_product($singe->ID);
        $image = $product->gallery_image_ids;


        $product = new WC_Product_Variable($singe->ID);


        if (!empty($price)) {

            foreach ($price as $single_price) {
                //   echo $single_price['start']  .  $single_price['end'];

                $variations = $product->get_available_variations();

                $var_data = [];


                if ($product->price >= $single_price['start'] && $product->price <= $single_price['end']) {


                    foreach ($image as $index => $link) {


//            $image_array = [
//                "url" => $link,
//            ];
                        $image_array[] = wp_get_attachment_url($link, 'full', false);

                    }


                    if (!empty($colors)) {
                        foreach ($colors as $color_singe) {


                            foreach ($variations as $key => $variation) {
                                $variation__id = $variation['attributes']['attribute_pa_color'];
                                $material_check = $variation['attributes']['attribute_materials'];
                                $width_check = $variation['dimensions']['width'];
                                $height_check = $variation['dimensions']['height'];


                                $var_data  [] = $variation;
                                //var_dump($material_check);

                                if ($variation__id == $color_singe['slug']) {


                                    if (!empty($width)) {
                                        foreach ($width as $single_width) {


                                            if ($single_width['start'] <= $width_check && $single_width['end'] >= $width_check) {
                                                //  var_dump($variation);

                                                if (!empty($height)) {

                                                    foreach ($height as $single_height) {

                                                        if ($single_height['start'] <= $height_check && $single_height['end'] >= $height_check) {

                                                            if (!empty($material)) {

                                                                //  echo $singe->ID;
                                                                foreach ($material as $single_material) {

                                                                    if ($single_material['slug'] == $material_check) {


                                                                        $op = array(
                                                                            "id" => $product->id,
                                                                            "name" => $product->name,
                                                                            "slug" => $product->slug,
                                                                            "date_created" => $product->date_created,
                                                                            "status" => $product->status,
                                                                            "featured" => $product->featured,
                                                                            "catalog_visibility" => $product->catalog_visibility,
                                                                            "description" => $product->description,
                                                                            "short_description" => $product->short_description,
                                                                            "sku" => $product->sku,
                                                                            "price" => $product->price,
                                                                            "regular_price" => $product->regular_price,
                                                                            "sale_price" => $product->sale_price,
                                                                            "date_on_sale_from" => $product->date_on_sale_from,
                                                                            "date_on_sale_to" => $product->date_on_sale_to,
                                                                            "total_sales" => $product->total_sales,
                                                                            "tax_status" => $product->tax_status,
                                                                            "manage_stock" => $product->manage_stock,
                                                                            "stock_quantity" => $product->stock_quantity,
                                                                            "stock_status" => $product->stock_status,
                                                                            "backorders" => $product->backorders,
                                                                            "sold_individually" => $product->sold_individually,
                                                                            "weight" => $product->weight,
                                                                            "height" => $product->height,
                                                                            "upsell_ids" => $product->upsell_ids,
                                                                            "cross_sell_ids" => $product->cross_sell_ids,
                                                                            "parent_id" => $product->parent_id,
                                                                            "reviews_allowed" => $product->reviews_allowed,
                                                                            "purchase_note" => $product->purchase_note,
                                                                            "attributes" => $product->attributes,
                                                                            "default_attributes" => $product->default_attributes,
                                                                            "menu_order" => $product->menu_order,
                                                                            "virtual" => $product->virtual,
                                                                            "downloadable" => $product->downloadable,
                                                                            "category_ids" => $product->category_ids,
                                                                            "tag_ids" => $product->tag_ids,
                                                                            "shipping_class_id" => $product->shipping_class_id,
                                                                            "downloads" => $product->downloads,
                                                                            "download_limit" => $product->download_limit,
                                                                            "download_limit" => $product->download_limit,
                                                                            "download_expiry" => $product->download_expiry,
                                                                            "rating_counts" => $product->rating_counts,
                                                                            "average_rating" => $product->average_rating,
                                                                            "review_count" => $product->review_count,
                                                                            "meta_data" => $product->meta_data,
                                                                            "average_rating" => $product->average_rating,
                                                                            "average_rating" => $product->average_rating,
                                                                            "image" => wp_get_attachment_url($product->image_id, 'full', false),
                                                                            "gallery" => $image_array,
                                                                            'variation' => $var_data

                                                                        );

                                                                        $array[] = $op;
                                                                    }
                                                                }
                                                            } else {

                                                                $op = array(
                                                                    "id" => $product->id,
                                                                    "name" => $product->name,
                                                                    "slug" => $product->slug,
                                                                    "date_created" => $product->date_created,
                                                                    "status" => $product->status,
                                                                    "featured" => $product->featured,
                                                                    "catalog_visibility" => $product->catalog_visibility,
                                                                    "description" => $product->description,
                                                                    "short_description" => $product->short_description,
                                                                    "sku" => $product->sku,
                                                                    "price" => $product->price,
                                                                    "regular_price" => $product->regular_price,
                                                                    "sale_price" => $product->sale_price,
                                                                    "date_on_sale_from" => $product->date_on_sale_from,
                                                                    "date_on_sale_to" => $product->date_on_sale_to,
                                                                    "total_sales" => $product->total_sales,
                                                                    "tax_status" => $product->tax_status,
                                                                    "manage_stock" => $product->manage_stock,
                                                                    "stock_quantity" => $product->stock_quantity,
                                                                    "stock_status" => $product->stock_status,
                                                                    "backorders" => $product->backorders,
                                                                    "sold_individually" => $product->sold_individually,
                                                                    "weight" => $product->weight,
                                                                    "height" => $product->height,
                                                                    "upsell_ids" => $product->upsell_ids,
                                                                    "cross_sell_ids" => $product->cross_sell_ids,
                                                                    "parent_id" => $product->parent_id,
                                                                    "reviews_allowed" => $product->reviews_allowed,
                                                                    "purchase_note" => $product->purchase_note,
                                                                    "attributes" => $product->attributes,
                                                                    "default_attributes" => $product->default_attributes,
                                                                    "menu_order" => $product->menu_order,
                                                                    "virtual" => $product->virtual,
                                                                    "downloadable" => $product->downloadable,
                                                                    "category_ids" => $product->category_ids,
                                                                    "tag_ids" => $product->tag_ids,
                                                                    "shipping_class_id" => $product->shipping_class_id,
                                                                    "downloads" => $product->downloads,
                                                                    "download_limit" => $product->download_limit,
                                                                    "download_limit" => $product->download_limit,
                                                                    "download_expiry" => $product->download_expiry,
                                                                    "rating_counts" => $product->rating_counts,
                                                                    "average_rating" => $product->average_rating,
                                                                    "review_count" => $product->review_count,
                                                                    "meta_data" => $product->meta_data,
                                                                    "average_rating" => $product->average_rating,
                                                                    "average_rating" => $product->average_rating,
                                                                    "image" => wp_get_attachment_url($product->image_id, 'full', false),
                                                                    "gallery" => $image_array,
                                                                    'variation' => $var_data

                                                                );

                                                                $array[] = $op;
                                                            }
                                                        }
                                                    }

                                                } else {
                                                    if (!empty($material)) {

                                                        //  echo $singe->ID;
                                                        foreach ($material as $single_material) {

                                                            if ($single_material['slug'] == $material_check) {


                                                                $op = array(
                                                                    "id" => $product->id,
                                                                    "name" => $product->name,
                                                                    "slug" => $product->slug,
                                                                    "date_created" => $product->date_created,
                                                                    "status" => $product->status,
                                                                    "featured" => $product->featured,
                                                                    "catalog_visibility" => $product->catalog_visibility,
                                                                    "description" => $product->description,
                                                                    "short_description" => $product->short_description,
                                                                    "sku" => $product->sku,
                                                                    "price" => $product->price,
                                                                    "regular_price" => $product->regular_price,
                                                                    "sale_price" => $product->sale_price,
                                                                    "date_on_sale_from" => $product->date_on_sale_from,
                                                                    "date_on_sale_to" => $product->date_on_sale_to,
                                                                    "total_sales" => $product->total_sales,
                                                                    "tax_status" => $product->tax_status,
                                                                    "manage_stock" => $product->manage_stock,
                                                                    "stock_quantity" => $product->stock_quantity,
                                                                    "stock_status" => $product->stock_status,
                                                                    "backorders" => $product->backorders,
                                                                    "sold_individually" => $product->sold_individually,
                                                                    "weight" => $product->weight,
                                                                    "height" => $product->height,
                                                                    "upsell_ids" => $product->upsell_ids,
                                                                    "cross_sell_ids" => $product->cross_sell_ids,
                                                                    "parent_id" => $product->parent_id,
                                                                    "reviews_allowed" => $product->reviews_allowed,
                                                                    "purchase_note" => $product->purchase_note,
                                                                    "attributes" => $product->attributes,
                                                                    "default_attributes" => $product->default_attributes,
                                                                    "menu_order" => $product->menu_order,
                                                                    "virtual" => $product->virtual,
                                                                    "downloadable" => $product->downloadable,
                                                                    "category_ids" => $product->category_ids,
                                                                    "tag_ids" => $product->tag_ids,
                                                                    "shipping_class_id" => $product->shipping_class_id,
                                                                    "downloads" => $product->downloads,
                                                                    "download_limit" => $product->download_limit,
                                                                    "download_limit" => $product->download_limit,
                                                                    "download_expiry" => $product->download_expiry,
                                                                    "rating_counts" => $product->rating_counts,
                                                                    "average_rating" => $product->average_rating,
                                                                    "review_count" => $product->review_count,
                                                                    "meta_data" => $product->meta_data,
                                                                    "average_rating" => $product->average_rating,
                                                                    "average_rating" => $product->average_rating,
                                                                    "image" => wp_get_attachment_url($product->image_id, 'full', false),
                                                                    "gallery" => $image_array,
                                                                    'variation' => $var_data

                                                                );

                                                                $array[] = $op;
                                                            }
                                                        }
                                                    } else {
                                                        $array = array();
                                                        $op = array(
                                                            "id" => $product->id,
                                                            "name" => $product->name,
                                                            "slug" => $product->slug,
                                                            "date_created" => $product->date_created,
                                                            "status" => $product->status,
                                                            "featured" => $product->featured,
                                                            "catalog_visibility" => $product->catalog_visibility,
                                                            "description" => $product->description,
                                                            "short_description" => $product->short_description,
                                                            "sku" => $product->sku,
                                                            "price" => $product->price,
                                                            "regular_price" => $product->regular_price,
                                                            "sale_price" => $product->sale_price,
                                                            "date_on_sale_from" => $product->date_on_sale_from,
                                                            "date_on_sale_to" => $product->date_on_sale_to,
                                                            "total_sales" => $product->total_sales,
                                                            "tax_status" => $product->tax_status,
                                                            "manage_stock" => $product->manage_stock,
                                                            "stock_quantity" => $product->stock_quantity,
                                                            "stock_status" => $product->stock_status,
                                                            "backorders" => $product->backorders,
                                                            "sold_individually" => $product->sold_individually,
                                                            "weight" => $product->weight,
                                                            "height" => $product->height,
                                                            "upsell_ids" => $product->upsell_ids,
                                                            "cross_sell_ids" => $product->cross_sell_ids,
                                                            "parent_id" => $product->parent_id,
                                                            "reviews_allowed" => $product->reviews_allowed,
                                                            "purchase_note" => $product->purchase_note,
                                                            "attributes" => $product->attributes,
                                                            "default_attributes" => $product->default_attributes,
                                                            "menu_order" => $product->menu_order,
                                                            "virtual" => $product->virtual,
                                                            "downloadable" => $product->downloadable,
                                                            "category_ids" => $product->category_ids,
                                                            "tag_ids" => $product->tag_ids,
                                                            "shipping_class_id" => $product->shipping_class_id,
                                                            "downloads" => $product->downloads,
                                                            "download_limit" => $product->download_limit,
                                                            "download_limit" => $product->download_limit,
                                                            "download_expiry" => $product->download_expiry,
                                                            "rating_counts" => $product->rating_counts,
                                                            "average_rating" => $product->average_rating,
                                                            "review_count" => $product->review_count,
                                                            "meta_data" => $product->meta_data,
                                                            "average_rating" => $product->average_rating,
                                                            "average_rating" => $product->average_rating,
                                                            "image" => wp_get_attachment_url($product->image_id, 'full', false),
                                                            "gallery" => $image_array,
                                                            'variation' => $var_data

                                                        );

                                                        $array[] = $op;
                                                    }
                                                }

                                            }
                                            //break;


                                        }
                                    } else {
                                        if (!empty($height)) {

                                            foreach ($height as $single_height) {
                                                if ($single_height['start'] <= $height_check && $single_height['end'] >= $height_check) {
                                                    $array = array();
                                                    if (!empty($material)) {

                                                        //  echo $singe->ID;
                                                        foreach ($material as $single_material) {

                                                            if ($single_material['slug'] == $material_check) {


                                                                $op = array(
                                                                    "id" => $product->id,
                                                                    "name" => $product->name,
                                                                    "slug" => $product->slug,
                                                                    "date_created" => $product->date_created,
                                                                    "status" => $product->status,
                                                                    "featured" => $product->featured,
                                                                    "catalog_visibility" => $product->catalog_visibility,
                                                                    "description" => $product->description,
                                                                    "short_description" => $product->short_description,
                                                                    "sku" => $product->sku,
                                                                    "price" => $product->price,
                                                                    "regular_price" => $product->regular_price,
                                                                    "sale_price" => $product->sale_price,
                                                                    "date_on_sale_from" => $product->date_on_sale_from,
                                                                    "date_on_sale_to" => $product->date_on_sale_to,
                                                                    "total_sales" => $product->total_sales,
                                                                    "tax_status" => $product->tax_status,
                                                                    "manage_stock" => $product->manage_stock,
                                                                    "stock_quantity" => $product->stock_quantity,
                                                                    "stock_status" => $product->stock_status,
                                                                    "backorders" => $product->backorders,
                                                                    "sold_individually" => $product->sold_individually,
                                                                    "weight" => $product->weight,
                                                                    "height" => $product->height,
                                                                    "upsell_ids" => $product->upsell_ids,
                                                                    "cross_sell_ids" => $product->cross_sell_ids,
                                                                    "parent_id" => $product->parent_id,
                                                                    "reviews_allowed" => $product->reviews_allowed,
                                                                    "purchase_note" => $product->purchase_note,
                                                                    "attributes" => $product->attributes,
                                                                    "default_attributes" => $product->default_attributes,
                                                                    "menu_order" => $product->menu_order,
                                                                    "virtual" => $product->virtual,
                                                                    "downloadable" => $product->downloadable,
                                                                    "category_ids" => $product->category_ids,
                                                                    "tag_ids" => $product->tag_ids,
                                                                    "shipping_class_id" => $product->shipping_class_id,
                                                                    "downloads" => $product->downloads,
                                                                    "download_limit" => $product->download_limit,
                                                                    "download_limit" => $product->download_limit,
                                                                    "download_expiry" => $product->download_expiry,
                                                                    "rating_counts" => $product->rating_counts,
                                                                    "average_rating" => $product->average_rating,
                                                                    "review_count" => $product->review_count,
                                                                    "meta_data" => $product->meta_data,
                                                                    "average_rating" => $product->average_rating,
                                                                    "average_rating" => $product->average_rating,
                                                                    "image" => wp_get_attachment_url($product->image_id, 'full', false),
                                                                    "gallery" => $image_array,
                                                                    'variation' => $var_data

                                                                );

                                                                $array[] = $op;
                                                            }
                                                        }
                                                    } else {

                                                        $op = array(
                                                            "id" => $product->id,
                                                            "name" => $product->name,
                                                            "slug" => $product->slug,
                                                            "date_created" => $product->date_created,
                                                            "status" => $product->status,
                                                            "featured" => $product->featured,
                                                            "catalog_visibility" => $product->catalog_visibility,
                                                            "description" => $product->description,
                                                            "short_description" => $product->short_description,
                                                            "sku" => $product->sku,
                                                            "price" => $product->price,
                                                            "regular_price" => $product->regular_price,
                                                            "sale_price" => $product->sale_price,
                                                            "date_on_sale_from" => $product->date_on_sale_from,
                                                            "date_on_sale_to" => $product->date_on_sale_to,
                                                            "total_sales" => $product->total_sales,
                                                            "tax_status" => $product->tax_status,
                                                            "manage_stock" => $product->manage_stock,
                                                            "stock_quantity" => $product->stock_quantity,
                                                            "stock_status" => $product->stock_status,
                                                            "backorders" => $product->backorders,
                                                            "sold_individually" => $product->sold_individually,
                                                            "weight" => $product->weight,
                                                            "height" => $product->height,
                                                            "upsell_ids" => $product->upsell_ids,
                                                            "cross_sell_ids" => $product->cross_sell_ids,
                                                            "parent_id" => $product->parent_id,
                                                            "reviews_allowed" => $product->reviews_allowed,
                                                            "purchase_note" => $product->purchase_note,
                                                            "attributes" => $product->attributes,
                                                            "default_attributes" => $product->default_attributes,
                                                            "menu_order" => $product->menu_order,
                                                            "virtual" => $product->virtual,
                                                            "downloadable" => $product->downloadable,
                                                            "category_ids" => $product->category_ids,
                                                            "tag_ids" => $product->tag_ids,
                                                            "shipping_class_id" => $product->shipping_class_id,
                                                            "downloads" => $product->downloads,
                                                            "download_limit" => $product->download_limit,
                                                            "download_limit" => $product->download_limit,
                                                            "download_expiry" => $product->download_expiry,
                                                            "rating_counts" => $product->rating_counts,
                                                            "average_rating" => $product->average_rating,
                                                            "review_count" => $product->review_count,
                                                            "meta_data" => $product->meta_data,
                                                            "average_rating" => $product->average_rating,
                                                            "average_rating" => $product->average_rating,
                                                            "image" => wp_get_attachment_url($product->image_id, 'full', false),
                                                            "gallery" => $image_array,
                                                            'variation' => $var_data

                                                        );

                                                        $array[] = $op;
                                                    }
                                                }
                                            }

                                        } else {
                                            if (!empty($material)) {

                                                //  echo $singe->ID;
                                                foreach ($material as $single_material) {

                                                    if ($single_material['slug'] == $material_check) {


                                                        $op = array(
                                                            "id" => $product->id,
                                                            "name" => $product->name,
                                                            "slug" => $product->slug,
                                                            "date_created" => $product->date_created,
                                                            "status" => $product->status,
                                                            "featured" => $product->featured,
                                                            "catalog_visibility" => $product->catalog_visibility,
                                                            "description" => $product->description,
                                                            "short_description" => $product->short_description,
                                                            "sku" => $product->sku,
                                                            "price" => $product->price,
                                                            "regular_price" => $product->regular_price,
                                                            "sale_price" => $product->sale_price,
                                                            "date_on_sale_from" => $product->date_on_sale_from,
                                                            "date_on_sale_to" => $product->date_on_sale_to,
                                                            "total_sales" => $product->total_sales,
                                                            "tax_status" => $product->tax_status,
                                                            "manage_stock" => $product->manage_stock,
                                                            "stock_quantity" => $product->stock_quantity,
                                                            "stock_status" => $product->stock_status,
                                                            "backorders" => $product->backorders,
                                                            "sold_individually" => $product->sold_individually,
                                                            "weight" => $product->weight,
                                                            "height" => $product->height,
                                                            "upsell_ids" => $product->upsell_ids,
                                                            "cross_sell_ids" => $product->cross_sell_ids,
                                                            "parent_id" => $product->parent_id,
                                                            "reviews_allowed" => $product->reviews_allowed,
                                                            "purchase_note" => $product->purchase_note,
                                                            "attributes" => $product->attributes,
                                                            "default_attributes" => $product->default_attributes,
                                                            "menu_order" => $product->menu_order,
                                                            "virtual" => $product->virtual,
                                                            "downloadable" => $product->downloadable,
                                                            "category_ids" => $product->category_ids,
                                                            "tag_ids" => $product->tag_ids,
                                                            "shipping_class_id" => $product->shipping_class_id,
                                                            "downloads" => $product->downloads,
                                                            "download_limit" => $product->download_limit,
                                                            "download_limit" => $product->download_limit,
                                                            "download_expiry" => $product->download_expiry,
                                                            "rating_counts" => $product->rating_counts,
                                                            "average_rating" => $product->average_rating,
                                                            "review_count" => $product->review_count,
                                                            "meta_data" => $product->meta_data,
                                                            "average_rating" => $product->average_rating,
                                                            "average_rating" => $product->average_rating,
                                                            "image" => wp_get_attachment_url($product->image_id, 'full', false),
                                                            "gallery" => $image_array,
                                                            'variation' => $var_data

                                                        );

                                                        $array[] = $op;
                                                    }
                                                }
                                            } else {
                                                $array = array();
                                                $op = array(
                                                    "id" => $product->id,
                                                    "name" => $product->name,
                                                    "slug" => $product->slug,
                                                    "date_created" => $product->date_created,
                                                    "status" => $product->status,
                                                    "featured" => $product->featured,
                                                    "catalog_visibility" => $product->catalog_visibility,
                                                    "description" => $product->description,
                                                    "short_description" => $product->short_description,
                                                    "sku" => $product->sku,
                                                    "price" => $product->price,
                                                    "regular_price" => $product->regular_price,
                                                    "sale_price" => $product->sale_price,
                                                    "date_on_sale_from" => $product->date_on_sale_from,
                                                    "date_on_sale_to" => $product->date_on_sale_to,
                                                    "total_sales" => $product->total_sales,
                                                    "tax_status" => $product->tax_status,
                                                    "manage_stock" => $product->manage_stock,
                                                    "stock_quantity" => $product->stock_quantity,
                                                    "stock_status" => $product->stock_status,
                                                    "backorders" => $product->backorders,
                                                    "sold_individually" => $product->sold_individually,
                                                    "weight" => $product->weight,
                                                    "height" => $product->height,
                                                    "upsell_ids" => $product->upsell_ids,
                                                    "cross_sell_ids" => $product->cross_sell_ids,
                                                    "parent_id" => $product->parent_id,
                                                    "reviews_allowed" => $product->reviews_allowed,
                                                    "purchase_note" => $product->purchase_note,
                                                    "attributes" => $product->attributes,
                                                    "default_attributes" => $product->default_attributes,
                                                    "menu_order" => $product->menu_order,
                                                    "virtual" => $product->virtual,
                                                    "downloadable" => $product->downloadable,
                                                    "category_ids" => $product->category_ids,
                                                    "tag_ids" => $product->tag_ids,
                                                    "shipping_class_id" => $product->shipping_class_id,
                                                    "downloads" => $product->downloads,
                                                    "download_limit" => $product->download_limit,
                                                    "download_limit" => $product->download_limit,
                                                    "download_expiry" => $product->download_expiry,
                                                    "rating_counts" => $product->rating_counts,
                                                    "average_rating" => $product->average_rating,
                                                    "review_count" => $product->review_count,
                                                    "meta_data" => $product->meta_data,
                                                    "average_rating" => $product->average_rating,
                                                    "average_rating" => $product->average_rating,
                                                    "image" => wp_get_attachment_url($product->image_id, 'full', false),
                                                    "gallery" => $image_array,
                                                    'variation' => $var_data

                                                );

                                                $array[] = $op;
                                            }
                                        }
                                    }


                                }


                                // break;
                            }


                            // break;
                        }
                    } else {
                        foreach ($variations as $key => $variation) {
                            $variation__id = $variation['attributes']['attribute_pa_color'];
                            $material_check = $variation['attributes']['attribute_materials'];
                            $width_check = $variation['dimensions']['width'];
                            $height_check = $variation['dimensions']['height'];


                            $var_data  [] = $variation;
                            //var_dump($material_check);


                            if (!empty($width)) {
                                foreach ($width as $single_width) {


                                    if ($single_width['start'] <= $width_check && $single_width['end'] >= $width_check) {
                                        //  var_dump($variation);

                                        if (!empty($height)) {

                                            foreach ($height as $single_height) {
                                                if ($single_height['start'] <= $height_check && $single_height['end'] >= $height_check) {
                                                    $array = array();
                                                    if (!empty($material)) {

                                                        //  echo $singe->ID;
                                                        foreach ($material as $single_material) {

                                                            if ($single_material['slug'] == $material_check) {


                                                                $op = array(
                                                                    "id" => $product->id,
                                                                    "name" => $product->name,
                                                                    "slug" => $product->slug,
                                                                    "date_created" => $product->date_created,
                                                                    "status" => $product->status,
                                                                    "featured" => $product->featured,
                                                                    "catalog_visibility" => $product->catalog_visibility,
                                                                    "description" => $product->description,
                                                                    "short_description" => $product->short_description,
                                                                    "sku" => $product->sku,
                                                                    "price" => $product->price,
                                                                    "regular_price" => $product->regular_price,
                                                                    "sale_price" => $product->sale_price,
                                                                    "date_on_sale_from" => $product->date_on_sale_from,
                                                                    "date_on_sale_to" => $product->date_on_sale_to,
                                                                    "total_sales" => $product->total_sales,
                                                                    "tax_status" => $product->tax_status,
                                                                    "manage_stock" => $product->manage_stock,
                                                                    "stock_quantity" => $product->stock_quantity,
                                                                    "stock_status" => $product->stock_status,
                                                                    "backorders" => $product->backorders,
                                                                    "sold_individually" => $product->sold_individually,
                                                                    "weight" => $product->weight,
                                                                    "height" => $product->height,
                                                                    "upsell_ids" => $product->upsell_ids,
                                                                    "cross_sell_ids" => $product->cross_sell_ids,
                                                                    "parent_id" => $product->parent_id,
                                                                    "reviews_allowed" => $product->reviews_allowed,
                                                                    "purchase_note" => $product->purchase_note,
                                                                    "attributes" => $product->attributes,
                                                                    "default_attributes" => $product->default_attributes,
                                                                    "menu_order" => $product->menu_order,
                                                                    "virtual" => $product->virtual,
                                                                    "downloadable" => $product->downloadable,
                                                                    "category_ids" => $product->category_ids,
                                                                    "tag_ids" => $product->tag_ids,
                                                                    "shipping_class_id" => $product->shipping_class_id,
                                                                    "downloads" => $product->downloads,
                                                                    "download_limit" => $product->download_limit,
                                                                    "download_limit" => $product->download_limit,
                                                                    "download_expiry" => $product->download_expiry,
                                                                    "rating_counts" => $product->rating_counts,
                                                                    "average_rating" => $product->average_rating,
                                                                    "review_count" => $product->review_count,
                                                                    "meta_data" => $product->meta_data,
                                                                    "average_rating" => $product->average_rating,
                                                                    "average_rating" => $product->average_rating,
                                                                    "image" => wp_get_attachment_url($product->image_id, 'full', false),
                                                                    "gallery" => $image_array,
                                                                    'variation' => $var_data

                                                                );

                                                                $array[] = $op;
                                                            }
                                                        }
                                                    } else {

                                                        $op = array(
                                                            "id" => $product->id,
                                                            "name" => $product->name,
                                                            "slug" => $product->slug,
                                                            "date_created" => $product->date_created,
                                                            "status" => $product->status,
                                                            "featured" => $product->featured,
                                                            "catalog_visibility" => $product->catalog_visibility,
                                                            "description" => $product->description,
                                                            "short_description" => $product->short_description,
                                                            "sku" => $product->sku,
                                                            "price" => $product->price,
                                                            "regular_price" => $product->regular_price,
                                                            "sale_price" => $product->sale_price,
                                                            "date_on_sale_from" => $product->date_on_sale_from,
                                                            "date_on_sale_to" => $product->date_on_sale_to,
                                                            "total_sales" => $product->total_sales,
                                                            "tax_status" => $product->tax_status,
                                                            "manage_stock" => $product->manage_stock,
                                                            "stock_quantity" => $product->stock_quantity,
                                                            "stock_status" => $product->stock_status,
                                                            "backorders" => $product->backorders,
                                                            "sold_individually" => $product->sold_individually,
                                                            "weight" => $product->weight,
                                                            "height" => $product->height,
                                                            "upsell_ids" => $product->upsell_ids,
                                                            "cross_sell_ids" => $product->cross_sell_ids,
                                                            "parent_id" => $product->parent_id,
                                                            "reviews_allowed" => $product->reviews_allowed,
                                                            "purchase_note" => $product->purchase_note,
                                                            "attributes" => $product->attributes,
                                                            "default_attributes" => $product->default_attributes,
                                                            "menu_order" => $product->menu_order,
                                                            "virtual" => $product->virtual,
                                                            "downloadable" => $product->downloadable,
                                                            "category_ids" => $product->category_ids,
                                                            "tag_ids" => $product->tag_ids,
                                                            "shipping_class_id" => $product->shipping_class_id,
                                                            "downloads" => $product->downloads,
                                                            "download_limit" => $product->download_limit,
                                                            "download_limit" => $product->download_limit,
                                                            "download_expiry" => $product->download_expiry,
                                                            "rating_counts" => $product->rating_counts,
                                                            "average_rating" => $product->average_rating,
                                                            "review_count" => $product->review_count,
                                                            "meta_data" => $product->meta_data,
                                                            "average_rating" => $product->average_rating,
                                                            "average_rating" => $product->average_rating,
                                                            "image" => wp_get_attachment_url($product->image_id, 'full', false),
                                                            "gallery" => $image_array,
                                                            'variation' => $var_data

                                                        );

                                                        $array[] = $op;
                                                    }
                                                }
                                            }

                                        } else {
                                            if (!empty($material)) {

                                                //  echo $singe->ID;
                                                foreach ($material as $single_material) {

                                                    if ($single_material['slug'] == $material_check) {


                                                        $op = array(
                                                            "id" => $product->id,
                                                            "name" => $product->name,
                                                            "slug" => $product->slug,
                                                            "date_created" => $product->date_created,
                                                            "status" => $product->status,
                                                            "featured" => $product->featured,
                                                            "catalog_visibility" => $product->catalog_visibility,
                                                            "description" => $product->description,
                                                            "short_description" => $product->short_description,
                                                            "sku" => $product->sku,
                                                            "price" => $product->price,
                                                            "regular_price" => $product->regular_price,
                                                            "sale_price" => $product->sale_price,
                                                            "date_on_sale_from" => $product->date_on_sale_from,
                                                            "date_on_sale_to" => $product->date_on_sale_to,
                                                            "total_sales" => $product->total_sales,
                                                            "tax_status" => $product->tax_status,
                                                            "manage_stock" => $product->manage_stock,
                                                            "stock_quantity" => $product->stock_quantity,
                                                            "stock_status" => $product->stock_status,
                                                            "backorders" => $product->backorders,
                                                            "sold_individually" => $product->sold_individually,
                                                            "weight" => $product->weight,
                                                            "height" => $product->height,
                                                            "upsell_ids" => $product->upsell_ids,
                                                            "cross_sell_ids" => $product->cross_sell_ids,
                                                            "parent_id" => $product->parent_id,
                                                            "reviews_allowed" => $product->reviews_allowed,
                                                            "purchase_note" => $product->purchase_note,
                                                            "attributes" => $product->attributes,
                                                            "default_attributes" => $product->default_attributes,
                                                            "menu_order" => $product->menu_order,
                                                            "virtual" => $product->virtual,
                                                            "downloadable" => $product->downloadable,
                                                            "category_ids" => $product->category_ids,
                                                            "tag_ids" => $product->tag_ids,
                                                            "shipping_class_id" => $product->shipping_class_id,
                                                            "downloads" => $product->downloads,
                                                            "download_limit" => $product->download_limit,
                                                            "download_limit" => $product->download_limit,
                                                            "download_expiry" => $product->download_expiry,
                                                            "rating_counts" => $product->rating_counts,
                                                            "average_rating" => $product->average_rating,
                                                            "review_count" => $product->review_count,
                                                            "meta_data" => $product->meta_data,
                                                            "average_rating" => $product->average_rating,
                                                            "average_rating" => $product->average_rating,
                                                            "image" => wp_get_attachment_url($product->image_id, 'full', false),
                                                            "gallery" => $image_array,
                                                            'variation' => $var_data

                                                        );

                                                        $array[] = $op;
                                                    }
                                                }
                                            } else {
                                                $array = array();
                                                $op = array(
                                                    "id" => $product->id,
                                                    "name" => $product->name,
                                                    "slug" => $product->slug,
                                                    "date_created" => $product->date_created,
                                                    "status" => $product->status,
                                                    "featured" => $product->featured,
                                                    "catalog_visibility" => $product->catalog_visibility,
                                                    "description" => $product->description,
                                                    "short_description" => $product->short_description,
                                                    "sku" => $product->sku,
                                                    "price" => $product->price,
                                                    "regular_price" => $product->regular_price,
                                                    "sale_price" => $product->sale_price,
                                                    "date_on_sale_from" => $product->date_on_sale_from,
                                                    "date_on_sale_to" => $product->date_on_sale_to,
                                                    "total_sales" => $product->total_sales,
                                                    "tax_status" => $product->tax_status,
                                                    "manage_stock" => $product->manage_stock,
                                                    "stock_quantity" => $product->stock_quantity,
                                                    "stock_status" => $product->stock_status,
                                                    "backorders" => $product->backorders,
                                                    "sold_individually" => $product->sold_individually,
                                                    "weight" => $product->weight,
                                                    "height" => $product->height,
                                                    "upsell_ids" => $product->upsell_ids,
                                                    "cross_sell_ids" => $product->cross_sell_ids,
                                                    "parent_id" => $product->parent_id,
                                                    "reviews_allowed" => $product->reviews_allowed,
                                                    "purchase_note" => $product->purchase_note,
                                                    "attributes" => $product->attributes,
                                                    "default_attributes" => $product->default_attributes,
                                                    "menu_order" => $product->menu_order,
                                                    "virtual" => $product->virtual,
                                                    "downloadable" => $product->downloadable,
                                                    "category_ids" => $product->category_ids,
                                                    "tag_ids" => $product->tag_ids,
                                                    "shipping_class_id" => $product->shipping_class_id,
                                                    "downloads" => $product->downloads,
                                                    "download_limit" => $product->download_limit,
                                                    "download_limit" => $product->download_limit,
                                                    "download_expiry" => $product->download_expiry,
                                                    "rating_counts" => $product->rating_counts,
                                                    "average_rating" => $product->average_rating,
                                                    "review_count" => $product->review_count,
                                                    "meta_data" => $product->meta_data,
                                                    "average_rating" => $product->average_rating,
                                                    "average_rating" => $product->average_rating,
                                                    "image" => wp_get_attachment_url($product->image_id, 'full', false),
                                                    "gallery" => $image_array,
                                                    'variation' => $var_data

                                                );

                                                $array[] = $op;
                                            }
                                        }

                                    }
                                    //break;


                                }
                            } else {
                                if (!empty($height)) {

                                    foreach ($height as $single_height) {
                                        if ($single_height['start'] <= $height_check && $single_height['end'] >= $height_check) {
                                            $array = array();
                                            if (!empty($material)) {

                                                //  echo $singe->ID;
                                                foreach ($material as $single_material) {

                                                    if ($single_material['slug'] == $material_check) {


                                                        $op = array(
                                                            "id" => $product->id,
                                                            "name" => $product->name,
                                                            "slug" => $product->slug,
                                                            "date_created" => $product->date_created,
                                                            "status" => $product->status,
                                                            "featured" => $product->featured,
                                                            "catalog_visibility" => $product->catalog_visibility,
                                                            "description" => $product->description,
                                                            "short_description" => $product->short_description,
                                                            "sku" => $product->sku,
                                                            "price" => $product->price,
                                                            "regular_price" => $product->regular_price,
                                                            "sale_price" => $product->sale_price,
                                                            "date_on_sale_from" => $product->date_on_sale_from,
                                                            "date_on_sale_to" => $product->date_on_sale_to,
                                                            "total_sales" => $product->total_sales,
                                                            "tax_status" => $product->tax_status,
                                                            "manage_stock" => $product->manage_stock,
                                                            "stock_quantity" => $product->stock_quantity,
                                                            "stock_status" => $product->stock_status,
                                                            "backorders" => $product->backorders,
                                                            "sold_individually" => $product->sold_individually,
                                                            "weight" => $product->weight,
                                                            "height" => $product->height,
                                                            "upsell_ids" => $product->upsell_ids,
                                                            "cross_sell_ids" => $product->cross_sell_ids,
                                                            "parent_id" => $product->parent_id,
                                                            "reviews_allowed" => $product->reviews_allowed,
                                                            "purchase_note" => $product->purchase_note,
                                                            "attributes" => $product->attributes,
                                                            "default_attributes" => $product->default_attributes,
                                                            "menu_order" => $product->menu_order,
                                                            "virtual" => $product->virtual,
                                                            "downloadable" => $product->downloadable,
                                                            "category_ids" => $product->category_ids,
                                                            "tag_ids" => $product->tag_ids,
                                                            "shipping_class_id" => $product->shipping_class_id,
                                                            "downloads" => $product->downloads,
                                                            "download_limit" => $product->download_limit,
                                                            "download_limit" => $product->download_limit,
                                                            "download_expiry" => $product->download_expiry,
                                                            "rating_counts" => $product->rating_counts,
                                                            "average_rating" => $product->average_rating,
                                                            "review_count" => $product->review_count,
                                                            "meta_data" => $product->meta_data,
                                                            "average_rating" => $product->average_rating,
                                                            "average_rating" => $product->average_rating,
                                                            "image" => wp_get_attachment_url($product->image_id, 'full', false),
                                                            "gallery" => $image_array,
                                                            'variation' => $var_data

                                                        );

                                                        $array[] = $op;
                                                    }
                                                }
                                            } else {

                                                $op = array(
                                                    "id" => $product->id,
                                                    "name" => $product->name,
                                                    "slug" => $product->slug,
                                                    "date_created" => $product->date_created,
                                                    "status" => $product->status,
                                                    "featured" => $product->featured,
                                                    "catalog_visibility" => $product->catalog_visibility,
                                                    "description" => $product->description,
                                                    "short_description" => $product->short_description,
                                                    "sku" => $product->sku,
                                                    "price" => $product->price,
                                                    "regular_price" => $product->regular_price,
                                                    "sale_price" => $product->sale_price,
                                                    "date_on_sale_from" => $product->date_on_sale_from,
                                                    "date_on_sale_to" => $product->date_on_sale_to,
                                                    "total_sales" => $product->total_sales,
                                                    "tax_status" => $product->tax_status,
                                                    "manage_stock" => $product->manage_stock,
                                                    "stock_quantity" => $product->stock_quantity,
                                                    "stock_status" => $product->stock_status,
                                                    "backorders" => $product->backorders,
                                                    "sold_individually" => $product->sold_individually,
                                                    "weight" => $product->weight,
                                                    "height" => $product->height,
                                                    "upsell_ids" => $product->upsell_ids,
                                                    "cross_sell_ids" => $product->cross_sell_ids,
                                                    "parent_id" => $product->parent_id,
                                                    "reviews_allowed" => $product->reviews_allowed,
                                                    "purchase_note" => $product->purchase_note,
                                                    "attributes" => $product->attributes,
                                                    "default_attributes" => $product->default_attributes,
                                                    "menu_order" => $product->menu_order,
                                                    "virtual" => $product->virtual,
                                                    "downloadable" => $product->downloadable,
                                                    "category_ids" => $product->category_ids,
                                                    "tag_ids" => $product->tag_ids,
                                                    "shipping_class_id" => $product->shipping_class_id,
                                                    "downloads" => $product->downloads,
                                                    "download_limit" => $product->download_limit,
                                                    "download_limit" => $product->download_limit,
                                                    "download_expiry" => $product->download_expiry,
                                                    "rating_counts" => $product->rating_counts,
                                                    "average_rating" => $product->average_rating,
                                                    "review_count" => $product->review_count,
                                                    "meta_data" => $product->meta_data,
                                                    "average_rating" => $product->average_rating,
                                                    "average_rating" => $product->average_rating,
                                                    "image" => wp_get_attachment_url($product->image_id, 'full', false),
                                                    "gallery" => $image_array,
                                                    'variation' => $var_data

                                                );

                                                $array[] = $op;
                                            }
                                        }
                                    }

                                } else {
                                    if (!empty($material)) {

                                        //  echo $singe->ID;
                                        foreach ($material as $single_material) {

                                            if ($single_material['slug'] == $material_check) {


                                                $op = array(
                                                    "id" => $product->id,
                                                    "name" => $product->name,
                                                    "slug" => $product->slug,
                                                    "date_created" => $product->date_created,
                                                    "status" => $product->status,
                                                    "featured" => $product->featured,
                                                    "catalog_visibility" => $product->catalog_visibility,
                                                    "description" => $product->description,
                                                    "short_description" => $product->short_description,
                                                    "sku" => $product->sku,
                                                    "price" => $product->price,
                                                    "regular_price" => $product->regular_price,
                                                    "sale_price" => $product->sale_price,
                                                    "date_on_sale_from" => $product->date_on_sale_from,
                                                    "date_on_sale_to" => $product->date_on_sale_to,
                                                    "total_sales" => $product->total_sales,
                                                    "tax_status" => $product->tax_status,
                                                    "manage_stock" => $product->manage_stock,
                                                    "stock_quantity" => $product->stock_quantity,
                                                    "stock_status" => $product->stock_status,
                                                    "backorders" => $product->backorders,
                                                    "sold_individually" => $product->sold_individually,
                                                    "weight" => $product->weight,
                                                    "height" => $product->height,
                                                    "upsell_ids" => $product->upsell_ids,
                                                    "cross_sell_ids" => $product->cross_sell_ids,
                                                    "parent_id" => $product->parent_id,
                                                    "reviews_allowed" => $product->reviews_allowed,
                                                    "purchase_note" => $product->purchase_note,
                                                    "attributes" => $product->attributes,
                                                    "default_attributes" => $product->default_attributes,
                                                    "menu_order" => $product->menu_order,
                                                    "virtual" => $product->virtual,
                                                    "downloadable" => $product->downloadable,
                                                    "category_ids" => $product->category_ids,
                                                    "tag_ids" => $product->tag_ids,
                                                    "shipping_class_id" => $product->shipping_class_id,
                                                    "downloads" => $product->downloads,
                                                    "download_limit" => $product->download_limit,
                                                    "download_limit" => $product->download_limit,
                                                    "download_expiry" => $product->download_expiry,
                                                    "rating_counts" => $product->rating_counts,
                                                    "average_rating" => $product->average_rating,
                                                    "review_count" => $product->review_count,
                                                    "meta_data" => $product->meta_data,
                                                    "average_rating" => $product->average_rating,
                                                    "average_rating" => $product->average_rating,
                                                    "image" => wp_get_attachment_url($product->image_id, 'full', false),
                                                    "gallery" => $image_array,
                                                    'variation' => $var_data

                                                );

                                                $array[] = $op;
                                            }
                                        }
                                    } else {


                                        $op = array(
                                            "id" => $product->id,
                                            "name" => $product->name,
                                            "slug" => $product->slug,
                                            "date_created" => $product->date_created,
                                            "status" => $product->status,
                                            "featured" => $product->featured,
                                            "catalog_visibility" => $product->catalog_visibility,
                                            "description" => $product->description,
                                            "short_description" => $product->short_description,
                                            "sku" => $product->sku,
                                            "price" => $product->price,
                                            "regular_price" => $product->regular_price,
                                            "sale_price" => $product->sale_price,
                                            "date_on_sale_from" => $product->date_on_sale_from,
                                            "date_on_sale_to" => $product->date_on_sale_to,
                                            "total_sales" => $product->total_sales,
                                            "tax_status" => $product->tax_status,
                                            "manage_stock" => $product->manage_stock,
                                            "stock_quantity" => $product->stock_quantity,
                                            "stock_status" => $product->stock_status,
                                            "backorders" => $product->backorders,
                                            "sold_individually" => $product->sold_individually,
                                            "weight" => $product->weight,
                                            "height" => $product->height,
                                            "upsell_ids" => $product->upsell_ids,
                                            "cross_sell_ids" => $product->cross_sell_ids,
                                            "parent_id" => $product->parent_id,
                                            "reviews_allowed" => $product->reviews_allowed,
                                            "purchase_note" => $product->purchase_note,
                                            "attributes" => $product->attributes,
                                            "default_attributes" => $product->default_attributes,
                                            "menu_order" => $product->menu_order,
                                            "virtual" => $product->virtual,
                                            "downloadable" => $product->downloadable,
                                            "category_ids" => $product->category_ids,
                                            "tag_ids" => $product->tag_ids,
                                            "shipping_class_id" => $product->shipping_class_id,
                                            "downloads" => $product->downloads,
                                            "download_limit" => $product->download_limit,
                                            "download_limit" => $product->download_limit,
                                            "download_expiry" => $product->download_expiry,
                                            "rating_counts" => $product->rating_counts,
                                            "average_rating" => $product->average_rating,
                                            "review_count" => $product->review_count,
                                            "meta_data" => $product->meta_data,
                                            "average_rating" => $product->average_rating,
                                            "average_rating" => $product->average_rating,
                                            "image" => wp_get_attachment_url($product->image_id, 'full', false),
                                            "gallery" => $image_array,
                                            'variation' => $var_data

                                        );

                                        $array[] = $op;
                                    }
                                }
                            }
                            // break;
                        }

                    }


                }

            }
        }
        if (empty($price)) {

            foreach ($image as $index => $link) {


//            $image_array = [
//                "url" => $link,
//            ];
                $image_array[] = wp_get_attachment_url($link, 'full', false);

            }
            $variations = $product->get_available_variations();

            $var_data = [];

            if (!empty($colors)) {
                foreach ($colors as $color_singe) {


                    foreach ($variations as $key => $variation) {
                        $variation__id = $variation['attributes']['attribute_pa_color'];
                        $material_check = $variation['attributes']['attribute_materials'];
                        $width_check = $variation['dimensions']['width'];
                        $height_check = $variation['dimensions']['height'];


                        $var_data  [] = $variation;
                        //var_dump($material_check);

                        if ($variation__id == $color_singe['slug']) {


                            if (!empty($width)) {
                                foreach ($width as $single_width) {


                                    if ($single_width['start'] <= $width_check && $single_width['end'] >= $width_check) {
                                        //  var_dump($variation);

                                        if (!empty($height)) {

                                            foreach ($height as $single_height) {
                                                if ($single_height['start'] <= $height_check && $single_height['end'] >= $height_check) {

                                                    if (!empty($material)) {

                                                        //  echo $singe->ID;
                                                        foreach ($material as $single_material) {

                                                            if ($single_material['slug'] == $material_check) {


                                                                $op = array(
                                                                    "id" => $product->id,
                                                                    "name" => $product->name,
                                                                    "slug" => $product->slug,
                                                                    "date_created" => $product->date_created,
                                                                    "status" => $product->status,
                                                                    "featured" => $product->featured,
                                                                    "catalog_visibility" => $product->catalog_visibility,
                                                                    "description" => $product->description,
                                                                    "short_description" => $product->short_description,
                                                                    "sku" => $product->sku,
                                                                    "price" => $product->price,
                                                                    "regular_price" => $product->regular_price,
                                                                    "sale_price" => $product->sale_price,
                                                                    "date_on_sale_from" => $product->date_on_sale_from,
                                                                    "date_on_sale_to" => $product->date_on_sale_to,
                                                                    "total_sales" => $product->total_sales,
                                                                    "tax_status" => $product->tax_status,
                                                                    "manage_stock" => $product->manage_stock,
                                                                    "stock_quantity" => $product->stock_quantity,
                                                                    "stock_status" => $product->stock_status,
                                                                    "backorders" => $product->backorders,
                                                                    "sold_individually" => $product->sold_individually,
                                                                    "weight" => $product->weight,
                                                                    "height" => $product->height,
                                                                    "upsell_ids" => $product->upsell_ids,
                                                                    "cross_sell_ids" => $product->cross_sell_ids,
                                                                    "parent_id" => $product->parent_id,
                                                                    "reviews_allowed" => $product->reviews_allowed,
                                                                    "purchase_note" => $product->purchase_note,
                                                                    "attributes" => $product->attributes,
                                                                    "default_attributes" => $product->default_attributes,
                                                                    "menu_order" => $product->menu_order,
                                                                    "virtual" => $product->virtual,
                                                                    "downloadable" => $product->downloadable,
                                                                    "category_ids" => $product->category_ids,
                                                                    "tag_ids" => $product->tag_ids,
                                                                    "shipping_class_id" => $product->shipping_class_id,
                                                                    "downloads" => $product->downloads,
                                                                    "download_limit" => $product->download_limit,
                                                                    "download_limit" => $product->download_limit,
                                                                    "download_expiry" => $product->download_expiry,
                                                                    "rating_counts" => $product->rating_counts,
                                                                    "average_rating" => $product->average_rating,
                                                                    "review_count" => $product->review_count,
                                                                    "meta_data" => $product->meta_data,
                                                                    "average_rating" => $product->average_rating,
                                                                    "average_rating" => $product->average_rating,
                                                                    "image" => wp_get_attachment_url($product->image_id, 'full', false),
                                                                    "gallery" => $image_array,
                                                                    'variation' => $var_data

                                                                );

                                                                $array[] = $op;
                                                            }
                                                        }
                                                    } else {

                                                        $op = array(
                                                            "id" => $product->id,
                                                            "name" => $product->name,
                                                            "slug" => $product->slug,
                                                            "date_created" => $product->date_created,
                                                            "status" => $product->status,
                                                            "featured" => $product->featured,
                                                            "catalog_visibility" => $product->catalog_visibility,
                                                            "description" => $product->description,
                                                            "short_description" => $product->short_description,
                                                            "sku" => $product->sku,
                                                            "price" => $product->price,
                                                            "regular_price" => $product->regular_price,
                                                            "sale_price" => $product->sale_price,
                                                            "date_on_sale_from" => $product->date_on_sale_from,
                                                            "date_on_sale_to" => $product->date_on_sale_to,
                                                            "total_sales" => $product->total_sales,
                                                            "tax_status" => $product->tax_status,
                                                            "manage_stock" => $product->manage_stock,
                                                            "stock_quantity" => $product->stock_quantity,
                                                            "stock_status" => $product->stock_status,
                                                            "backorders" => $product->backorders,
                                                            "sold_individually" => $product->sold_individually,
                                                            "weight" => $product->weight,
                                                            "height" => $product->height,
                                                            "upsell_ids" => $product->upsell_ids,
                                                            "cross_sell_ids" => $product->cross_sell_ids,
                                                            "parent_id" => $product->parent_id,
                                                            "reviews_allowed" => $product->reviews_allowed,
                                                            "purchase_note" => $product->purchase_note,
                                                            "attributes" => $product->attributes,
                                                            "default_attributes" => $product->default_attributes,
                                                            "menu_order" => $product->menu_order,
                                                            "virtual" => $product->virtual,
                                                            "downloadable" => $product->downloadable,
                                                            "category_ids" => $product->category_ids,
                                                            "tag_ids" => $product->tag_ids,
                                                            "shipping_class_id" => $product->shipping_class_id,
                                                            "downloads" => $product->downloads,
                                                            "download_limit" => $product->download_limit,
                                                            "download_limit" => $product->download_limit,
                                                            "download_expiry" => $product->download_expiry,
                                                            "rating_counts" => $product->rating_counts,
                                                            "average_rating" => $product->average_rating,
                                                            "review_count" => $product->review_count,
                                                            "meta_data" => $product->meta_data,
                                                            "average_rating" => $product->average_rating,
                                                            "average_rating" => $product->average_rating,
                                                            "image" => wp_get_attachment_url($product->image_id, 'full', false),
                                                            "gallery" => $image_array,
                                                            'variation' => $var_data

                                                        );

                                                        $array[] = $op;
                                                    }
                                                }
                                            }

                                        } else {
                                            if (!empty($material)) {

                                                //  echo $singe->ID;
                                                foreach ($material as $single_material) {

                                                    if ($single_material['slug'] == $material_check) {


                                                        $op = array(
                                                            "id" => $product->id,
                                                            "name" => $product->name,
                                                            "slug" => $product->slug,
                                                            "date_created" => $product->date_created,
                                                            "status" => $product->status,
                                                            "featured" => $product->featured,
                                                            "catalog_visibility" => $product->catalog_visibility,
                                                            "description" => $product->description,
                                                            "short_description" => $product->short_description,
                                                            "sku" => $product->sku,
                                                            "price" => $product->price,
                                                            "regular_price" => $product->regular_price,
                                                            "sale_price" => $product->sale_price,
                                                            "date_on_sale_from" => $product->date_on_sale_from,
                                                            "date_on_sale_to" => $product->date_on_sale_to,
                                                            "total_sales" => $product->total_sales,
                                                            "tax_status" => $product->tax_status,
                                                            "manage_stock" => $product->manage_stock,
                                                            "stock_quantity" => $product->stock_quantity,
                                                            "stock_status" => $product->stock_status,
                                                            "backorders" => $product->backorders,
                                                            "sold_individually" => $product->sold_individually,
                                                            "weight" => $product->weight,
                                                            "height" => $product->height,
                                                            "upsell_ids" => $product->upsell_ids,
                                                            "cross_sell_ids" => $product->cross_sell_ids,
                                                            "parent_id" => $product->parent_id,
                                                            "reviews_allowed" => $product->reviews_allowed,
                                                            "purchase_note" => $product->purchase_note,
                                                            "attributes" => $product->attributes,
                                                            "default_attributes" => $product->default_attributes,
                                                            "menu_order" => $product->menu_order,
                                                            "virtual" => $product->virtual,
                                                            "downloadable" => $product->downloadable,
                                                            "category_ids" => $product->category_ids,
                                                            "tag_ids" => $product->tag_ids,
                                                            "shipping_class_id" => $product->shipping_class_id,
                                                            "downloads" => $product->downloads,
                                                            "download_limit" => $product->download_limit,
                                                            "download_limit" => $product->download_limit,
                                                            "download_expiry" => $product->download_expiry,
                                                            "rating_counts" => $product->rating_counts,
                                                            "average_rating" => $product->average_rating,
                                                            "review_count" => $product->review_count,
                                                            "meta_data" => $product->meta_data,
                                                            "average_rating" => $product->average_rating,
                                                            "average_rating" => $product->average_rating,
                                                            "image" => wp_get_attachment_url($product->image_id, 'full', false),
                                                            "gallery" => $image_array,
                                                            'variation' => $var_data

                                                        );

                                                        $array[] = $op;
                                                    }
                                                }
                                            } else {

                                                $op = array(
                                                    "id" => $product->id,
                                                    "name" => $product->name,
                                                    "slug" => $product->slug,
                                                    "date_created" => $product->date_created,
                                                    "status" => $product->status,
                                                    "featured" => $product->featured,
                                                    "catalog_visibility" => $product->catalog_visibility,
                                                    "description" => $product->description,
                                                    "short_description" => $product->short_description,
                                                    "sku" => $product->sku,
                                                    "price" => $product->price,
                                                    "regular_price" => $product->regular_price,
                                                    "sale_price" => $product->sale_price,
                                                    "date_on_sale_from" => $product->date_on_sale_from,
                                                    "date_on_sale_to" => $product->date_on_sale_to,
                                                    "total_sales" => $product->total_sales,
                                                    "tax_status" => $product->tax_status,
                                                    "manage_stock" => $product->manage_stock,
                                                    "stock_quantity" => $product->stock_quantity,
                                                    "stock_status" => $product->stock_status,
                                                    "backorders" => $product->backorders,
                                                    "sold_individually" => $product->sold_individually,
                                                    "weight" => $product->weight,
                                                    "height" => $product->height,
                                                    "upsell_ids" => $product->upsell_ids,
                                                    "cross_sell_ids" => $product->cross_sell_ids,
                                                    "parent_id" => $product->parent_id,
                                                    "reviews_allowed" => $product->reviews_allowed,
                                                    "purchase_note" => $product->purchase_note,
                                                    "attributes" => $product->attributes,
                                                    "default_attributes" => $product->default_attributes,
                                                    "menu_order" => $product->menu_order,
                                                    "virtual" => $product->virtual,
                                                    "downloadable" => $product->downloadable,
                                                    "category_ids" => $product->category_ids,
                                                    "tag_ids" => $product->tag_ids,
                                                    "shipping_class_id" => $product->shipping_class_id,
                                                    "downloads" => $product->downloads,
                                                    "download_limit" => $product->download_limit,
                                                    "download_limit" => $product->download_limit,
                                                    "download_expiry" => $product->download_expiry,
                                                    "rating_counts" => $product->rating_counts,
                                                    "average_rating" => $product->average_rating,
                                                    "review_count" => $product->review_count,
                                                    "meta_data" => $product->meta_data,
                                                    "average_rating" => $product->average_rating,
                                                    "average_rating" => $product->average_rating,
                                                    "image" => wp_get_attachment_url($product->image_id, 'full', false),
                                                    "gallery" => $image_array,
                                                    'variation' => $var_data

                                                );

                                                $array[] = $op;
                                            }
                                        }

                                    }
                                    //break;


                                }
                            } else {
                                if (!empty($height)) {

                                    foreach ($height as $single_height) {
                                        if ($single_height['start'] <= $height_check && $single_height['end'] >= $height_check) {

                                            if (!empty($material)) {

                                                //  echo $singe->ID;
                                                foreach ($material as $single_material) {

                                                    if ($single_material['slug'] == $material_check) {


                                                        $op = array(
                                                            "id" => $product->id,
                                                            "name" => $product->name,
                                                            "slug" => $product->slug,
                                                            "date_created" => $product->date_created,
                                                            "status" => $product->status,
                                                            "featured" => $product->featured,
                                                            "catalog_visibility" => $product->catalog_visibility,
                                                            "description" => $product->description,
                                                            "short_description" => $product->short_description,
                                                            "sku" => $product->sku,
                                                            "price" => $product->price,
                                                            "regular_price" => $product->regular_price,
                                                            "sale_price" => $product->sale_price,
                                                            "date_on_sale_from" => $product->date_on_sale_from,
                                                            "date_on_sale_to" => $product->date_on_sale_to,
                                                            "total_sales" => $product->total_sales,
                                                            "tax_status" => $product->tax_status,
                                                            "manage_stock" => $product->manage_stock,
                                                            "stock_quantity" => $product->stock_quantity,
                                                            "stock_status" => $product->stock_status,
                                                            "backorders" => $product->backorders,
                                                            "sold_individually" => $product->sold_individually,
                                                            "weight" => $product->weight,
                                                            "height" => $product->height,
                                                            "upsell_ids" => $product->upsell_ids,
                                                            "cross_sell_ids" => $product->cross_sell_ids,
                                                            "parent_id" => $product->parent_id,
                                                            "reviews_allowed" => $product->reviews_allowed,
                                                            "purchase_note" => $product->purchase_note,
                                                            "attributes" => $product->attributes,
                                                            "default_attributes" => $product->default_attributes,
                                                            "menu_order" => $product->menu_order,
                                                            "virtual" => $product->virtual,
                                                            "downloadable" => $product->downloadable,
                                                            "category_ids" => $product->category_ids,
                                                            "tag_ids" => $product->tag_ids,
                                                            "shipping_class_id" => $product->shipping_class_id,
                                                            "downloads" => $product->downloads,
                                                            "download_limit" => $product->download_limit,
                                                            "download_limit" => $product->download_limit,
                                                            "download_expiry" => $product->download_expiry,
                                                            "rating_counts" => $product->rating_counts,
                                                            "average_rating" => $product->average_rating,
                                                            "review_count" => $product->review_count,
                                                            "meta_data" => $product->meta_data,
                                                            "average_rating" => $product->average_rating,
                                                            "average_rating" => $product->average_rating,
                                                            "image" => wp_get_attachment_url($product->image_id, 'full', false),
                                                            "gallery" => $image_array,
                                                            'variation' => $var_data

                                                        );

                                                        $array[] = $op;
                                                    }
                                                }
                                            } else {

                                                $op = array(
                                                    "id" => $product->id,
                                                    "name" => $product->name,
                                                    "slug" => $product->slug,
                                                    "date_created" => $product->date_created,
                                                    "status" => $product->status,
                                                    "featured" => $product->featured,
                                                    "catalog_visibility" => $product->catalog_visibility,
                                                    "description" => $product->description,
                                                    "short_description" => $product->short_description,
                                                    "sku" => $product->sku,
                                                    "price" => $product->price,
                                                    "regular_price" => $product->regular_price,
                                                    "sale_price" => $product->sale_price,
                                                    "date_on_sale_from" => $product->date_on_sale_from,
                                                    "date_on_sale_to" => $product->date_on_sale_to,
                                                    "total_sales" => $product->total_sales,
                                                    "tax_status" => $product->tax_status,
                                                    "manage_stock" => $product->manage_stock,
                                                    "stock_quantity" => $product->stock_quantity,
                                                    "stock_status" => $product->stock_status,
                                                    "backorders" => $product->backorders,
                                                    "sold_individually" => $product->sold_individually,
                                                    "weight" => $product->weight,
                                                    "height" => $product->height,
                                                    "upsell_ids" => $product->upsell_ids,
                                                    "cross_sell_ids" => $product->cross_sell_ids,
                                                    "parent_id" => $product->parent_id,
                                                    "reviews_allowed" => $product->reviews_allowed,
                                                    "purchase_note" => $product->purchase_note,
                                                    "attributes" => $product->attributes,
                                                    "default_attributes" => $product->default_attributes,
                                                    "menu_order" => $product->menu_order,
                                                    "virtual" => $product->virtual,
                                                    "downloadable" => $product->downloadable,
                                                    "category_ids" => $product->category_ids,
                                                    "tag_ids" => $product->tag_ids,
                                                    "shipping_class_id" => $product->shipping_class_id,
                                                    "downloads" => $product->downloads,
                                                    "download_limit" => $product->download_limit,
                                                    "download_limit" => $product->download_limit,
                                                    "download_expiry" => $product->download_expiry,
                                                    "rating_counts" => $product->rating_counts,
                                                    "average_rating" => $product->average_rating,
                                                    "review_count" => $product->review_count,
                                                    "meta_data" => $product->meta_data,
                                                    "average_rating" => $product->average_rating,
                                                    "average_rating" => $product->average_rating,
                                                    "image" => wp_get_attachment_url($product->image_id, 'full', false),
                                                    "gallery" => $image_array,
                                                    'variation' => $var_data

                                                );

                                                $array[] = $op;
                                            }
                                        }
                                    }

                                } else {
                                    if (!empty($material)) {

                                        //  echo $singe->ID;
                                        foreach ($material as $single_material) {

                                            if ($single_material['slug'] == $material_check) {


                                                $op = array(
                                                    "id" => $product->id,
                                                    "name" => $product->name,
                                                    "slug" => $product->slug,
                                                    "date_created" => $product->date_created,
                                                    "status" => $product->status,
                                                    "featured" => $product->featured,
                                                    "catalog_visibility" => $product->catalog_visibility,
                                                    "description" => $product->description,
                                                    "short_description" => $product->short_description,
                                                    "sku" => $product->sku,
                                                    "price" => $product->price,
                                                    "regular_price" => $product->regular_price,
                                                    "sale_price" => $product->sale_price,
                                                    "date_on_sale_from" => $product->date_on_sale_from,
                                                    "date_on_sale_to" => $product->date_on_sale_to,
                                                    "total_sales" => $product->total_sales,
                                                    "tax_status" => $product->tax_status,
                                                    "manage_stock" => $product->manage_stock,
                                                    "stock_quantity" => $product->stock_quantity,
                                                    "stock_status" => $product->stock_status,
                                                    "backorders" => $product->backorders,
                                                    "sold_individually" => $product->sold_individually,
                                                    "weight" => $product->weight,
                                                    "height" => $product->height,
                                                    "upsell_ids" => $product->upsell_ids,
                                                    "cross_sell_ids" => $product->cross_sell_ids,
                                                    "parent_id" => $product->parent_id,
                                                    "reviews_allowed" => $product->reviews_allowed,
                                                    "purchase_note" => $product->purchase_note,
                                                    "attributes" => $product->attributes,
                                                    "default_attributes" => $product->default_attributes,
                                                    "menu_order" => $product->menu_order,
                                                    "virtual" => $product->virtual,
                                                    "downloadable" => $product->downloadable,
                                                    "category_ids" => $product->category_ids,
                                                    "tag_ids" => $product->tag_ids,
                                                    "shipping_class_id" => $product->shipping_class_id,
                                                    "downloads" => $product->downloads,
                                                    "download_limit" => $product->download_limit,
                                                    "download_limit" => $product->download_limit,
                                                    "download_expiry" => $product->download_expiry,
                                                    "rating_counts" => $product->rating_counts,
                                                    "average_rating" => $product->average_rating,
                                                    "review_count" => $product->review_count,
                                                    "meta_data" => $product->meta_data,
                                                    "average_rating" => $product->average_rating,
                                                    "average_rating" => $product->average_rating,
                                                    "image" => wp_get_attachment_url($product->image_id, 'full', false),
                                                    "gallery" => $image_array,
                                                    'variation' => $var_data

                                                );

                                                $array[] = $op;
                                            }
                                        }
                                    } else {

                                        $op = array(
                                            "id" => $product->id,
                                            "name" => $product->name,
                                            "slug" => $product->slug,
                                            "date_created" => $product->date_created,
                                            "status" => $product->status,
                                            "featured" => $product->featured,
                                            "catalog_visibility" => $product->catalog_visibility,
                                            "description" => $product->description,
                                            "short_description" => $product->short_description,
                                            "sku" => $product->sku,
                                            "price" => $product->price,
                                            "regular_price" => $product->regular_price,
                                            "sale_price" => $product->sale_price,
                                            "date_on_sale_from" => $product->date_on_sale_from,
                                            "date_on_sale_to" => $product->date_on_sale_to,
                                            "total_sales" => $product->total_sales,
                                            "tax_status" => $product->tax_status,
                                            "manage_stock" => $product->manage_stock,
                                            "stock_quantity" => $product->stock_quantity,
                                            "stock_status" => $product->stock_status,
                                            "backorders" => $product->backorders,
                                            "sold_individually" => $product->sold_individually,
                                            "weight" => $product->weight,
                                            "height" => $product->height,
                                            "upsell_ids" => $product->upsell_ids,
                                            "cross_sell_ids" => $product->cross_sell_ids,
                                            "parent_id" => $product->parent_id,
                                            "reviews_allowed" => $product->reviews_allowed,
                                            "purchase_note" => $product->purchase_note,
                                            "attributes" => $product->attributes,
                                            "default_attributes" => $product->default_attributes,
                                            "menu_order" => $product->menu_order,
                                            "virtual" => $product->virtual,
                                            "downloadable" => $product->downloadable,
                                            "category_ids" => $product->category_ids,
                                            "tag_ids" => $product->tag_ids,
                                            "shipping_class_id" => $product->shipping_class_id,
                                            "downloads" => $product->downloads,
                                            "download_limit" => $product->download_limit,
                                            "download_limit" => $product->download_limit,
                                            "download_expiry" => $product->download_expiry,
                                            "rating_counts" => $product->rating_counts,
                                            "average_rating" => $product->average_rating,
                                            "review_count" => $product->review_count,
                                            "meta_data" => $product->meta_data,
                                            "average_rating" => $product->average_rating,
                                            "average_rating" => $product->average_rating,
                                            "image" => wp_get_attachment_url($product->image_id, 'full', false),
                                            "gallery" => $image_array,
                                            'variation' => $var_data

                                        );

                                        $array[] = $op;
                                    }
                                }
                            }


                        }


                        // break;
                    }


                    // break;
                }
                ///break;
            } else {
                foreach ($variations as $key => $variation) {
                    $variation__id = $variation['attributes']['attribute_pa_color'];
                    $material_check = $variation['attributes']['attribute_materials'];
                    $width_check = $variation['dimensions']['width'];
                    $height_check = $variation['dimensions']['height'];


                    $var_data  [] = $variation;
                    //var_dump($material_check);


                    if (!empty($width)) {
                        foreach ($width as $single_width) {


                            if ($single_width['start'] <= $width_check && $single_width['end'] >= $width_check) {
                                //  var_dump($variation);

                                if (!empty($height)) {

                                    foreach ($height as $single_height) {
                                        if ($single_height['start'] <= $height_check && $single_height['end'] >= $height_check) {

                                            if (!empty($material)) {

                                                //  echo $singe->ID;
                                                foreach ($material as $single_material) {

                                                    if ($single_material['slug'] == $material_check) {


                                                        $op = array(
                                                            "id" => $product->id,
                                                            "name" => $product->name,
                                                            "slug" => $product->slug,
                                                            "date_created" => $product->date_created,
                                                            "status" => $product->status,
                                                            "featured" => $product->featured,
                                                            "catalog_visibility" => $product->catalog_visibility,
                                                            "description" => $product->description,
                                                            "short_description" => $product->short_description,
                                                            "sku" => $product->sku,
                                                            "price" => $product->price,
                                                            "regular_price" => $product->regular_price,
                                                            "sale_price" => $product->sale_price,
                                                            "date_on_sale_from" => $product->date_on_sale_from,
                                                            "date_on_sale_to" => $product->date_on_sale_to,
                                                            "total_sales" => $product->total_sales,
                                                            "tax_status" => $product->tax_status,
                                                            "manage_stock" => $product->manage_stock,
                                                            "stock_quantity" => $product->stock_quantity,
                                                            "stock_status" => $product->stock_status,
                                                            "backorders" => $product->backorders,
                                                            "sold_individually" => $product->sold_individually,
                                                            "weight" => $product->weight,
                                                            "height" => $product->height,
                                                            "upsell_ids" => $product->upsell_ids,
                                                            "cross_sell_ids" => $product->cross_sell_ids,
                                                            "parent_id" => $product->parent_id,
                                                            "reviews_allowed" => $product->reviews_allowed,
                                                            "purchase_note" => $product->purchase_note,
                                                            "attributes" => $product->attributes,
                                                            "default_attributes" => $product->default_attributes,
                                                            "menu_order" => $product->menu_order,
                                                            "virtual" => $product->virtual,
                                                            "downloadable" => $product->downloadable,
                                                            "category_ids" => $product->category_ids,
                                                            "tag_ids" => $product->tag_ids,
                                                            "shipping_class_id" => $product->shipping_class_id,
                                                            "downloads" => $product->downloads,
                                                            "download_limit" => $product->download_limit,
                                                            "download_limit" => $product->download_limit,
                                                            "download_expiry" => $product->download_expiry,
                                                            "rating_counts" => $product->rating_counts,
                                                            "average_rating" => $product->average_rating,
                                                            "review_count" => $product->review_count,
                                                            "meta_data" => $product->meta_data,
                                                            "average_rating" => $product->average_rating,
                                                            "average_rating" => $product->average_rating,
                                                            "image" => wp_get_attachment_url($product->image_id, 'full', false),
                                                            "gallery" => $image_array,
                                                            'variation' => $var_data

                                                        );

                                                        $array[] = $op;
                                                    }
                                                }
                                            } else {

                                                $op = array(
                                                    "id" => $product->id,
                                                    "name" => $product->name,
                                                    "slug" => $product->slug,
                                                    "date_created" => $product->date_created,
                                                    "status" => $product->status,
                                                    "featured" => $product->featured,
                                                    "catalog_visibility" => $product->catalog_visibility,
                                                    "description" => $product->description,
                                                    "short_description" => $product->short_description,
                                                    "sku" => $product->sku,
                                                    "price" => $product->price,
                                                    "regular_price" => $product->regular_price,
                                                    "sale_price" => $product->sale_price,
                                                    "date_on_sale_from" => $product->date_on_sale_from,
                                                    "date_on_sale_to" => $product->date_on_sale_to,
                                                    "total_sales" => $product->total_sales,
                                                    "tax_status" => $product->tax_status,
                                                    "manage_stock" => $product->manage_stock,
                                                    "stock_quantity" => $product->stock_quantity,
                                                    "stock_status" => $product->stock_status,
                                                    "backorders" => $product->backorders,
                                                    "sold_individually" => $product->sold_individually,
                                                    "weight" => $product->weight,
                                                    "height" => $product->height,
                                                    "upsell_ids" => $product->upsell_ids,
                                                    "cross_sell_ids" => $product->cross_sell_ids,
                                                    "parent_id" => $product->parent_id,
                                                    "reviews_allowed" => $product->reviews_allowed,
                                                    "purchase_note" => $product->purchase_note,
                                                    "attributes" => $product->attributes,
                                                    "default_attributes" => $product->default_attributes,
                                                    "menu_order" => $product->menu_order,
                                                    "virtual" => $product->virtual,
                                                    "downloadable" => $product->downloadable,
                                                    "category_ids" => $product->category_ids,
                                                    "tag_ids" => $product->tag_ids,
                                                    "shipping_class_id" => $product->shipping_class_id,
                                                    "downloads" => $product->downloads,
                                                    "download_limit" => $product->download_limit,
                                                    "download_limit" => $product->download_limit,
                                                    "download_expiry" => $product->download_expiry,
                                                    "rating_counts" => $product->rating_counts,
                                                    "average_rating" => $product->average_rating,
                                                    "review_count" => $product->review_count,
                                                    "meta_data" => $product->meta_data,
                                                    "average_rating" => $product->average_rating,
                                                    "average_rating" => $product->average_rating,
                                                    "image" => wp_get_attachment_url($product->image_id, 'full', false),
                                                    "gallery" => $image_array,
                                                    'variation' => $var_data

                                                );

                                                $array[] = $op;
                                            }
                                        }
                                    }

                                } else {
                                    if (!empty($material)) {

                                        //  echo $singe->ID;
                                        foreach ($material as $single_material) {

                                            if ($single_material['slug'] == $material_check) {


                                                $op = array(
                                                    "id" => $product->id,
                                                    "name" => $product->name,
                                                    "slug" => $product->slug,
                                                    "date_created" => $product->date_created,
                                                    "status" => $product->status,
                                                    "featured" => $product->featured,
                                                    "catalog_visibility" => $product->catalog_visibility,
                                                    "description" => $product->description,
                                                    "short_description" => $product->short_description,
                                                    "sku" => $product->sku,
                                                    "price" => $product->price,
                                                    "regular_price" => $product->regular_price,
                                                    "sale_price" => $product->sale_price,
                                                    "date_on_sale_from" => $product->date_on_sale_from,
                                                    "date_on_sale_to" => $product->date_on_sale_to,
                                                    "total_sales" => $product->total_sales,
                                                    "tax_status" => $product->tax_status,
                                                    "manage_stock" => $product->manage_stock,
                                                    "stock_quantity" => $product->stock_quantity,
                                                    "stock_status" => $product->stock_status,
                                                    "backorders" => $product->backorders,
                                                    "sold_individually" => $product->sold_individually,
                                                    "weight" => $product->weight,
                                                    "height" => $product->height,
                                                    "upsell_ids" => $product->upsell_ids,
                                                    "cross_sell_ids" => $product->cross_sell_ids,
                                                    "parent_id" => $product->parent_id,
                                                    "reviews_allowed" => $product->reviews_allowed,
                                                    "purchase_note" => $product->purchase_note,
                                                    "attributes" => $product->attributes,
                                                    "default_attributes" => $product->default_attributes,
                                                    "menu_order" => $product->menu_order,
                                                    "virtual" => $product->virtual,
                                                    "downloadable" => $product->downloadable,
                                                    "category_ids" => $product->category_ids,
                                                    "tag_ids" => $product->tag_ids,
                                                    "shipping_class_id" => $product->shipping_class_id,
                                                    "downloads" => $product->downloads,
                                                    "download_limit" => $product->download_limit,
                                                    "download_limit" => $product->download_limit,
                                                    "download_expiry" => $product->download_expiry,
                                                    "rating_counts" => $product->rating_counts,
                                                    "average_rating" => $product->average_rating,
                                                    "review_count" => $product->review_count,
                                                    "meta_data" => $product->meta_data,
                                                    "average_rating" => $product->average_rating,
                                                    "average_rating" => $product->average_rating,
                                                    "image" => wp_get_attachment_url($product->image_id, 'full', false),
                                                    "gallery" => $image_array,
                                                    'variation' => $var_data

                                                );

                                                $array[] = $op;
                                            }
                                        }
                                    } else {

                                        $op = array(
                                            "id" => $product->id,
                                            "name" => $product->name,
                                            "slug" => $product->slug,
                                            "date_created" => $product->date_created,
                                            "status" => $product->status,
                                            "featured" => $product->featured,
                                            "catalog_visibility" => $product->catalog_visibility,
                                            "description" => $product->description,
                                            "short_description" => $product->short_description,
                                            "sku" => $product->sku,
                                            "price" => $product->price,
                                            "regular_price" => $product->regular_price,
                                            "sale_price" => $product->sale_price,
                                            "date_on_sale_from" => $product->date_on_sale_from,
                                            "date_on_sale_to" => $product->date_on_sale_to,
                                            "total_sales" => $product->total_sales,
                                            "tax_status" => $product->tax_status,
                                            "manage_stock" => $product->manage_stock,
                                            "stock_quantity" => $product->stock_quantity,
                                            "stock_status" => $product->stock_status,
                                            "backorders" => $product->backorders,
                                            "sold_individually" => $product->sold_individually,
                                            "weight" => $product->weight,
                                            "height" => $product->height,
                                            "upsell_ids" => $product->upsell_ids,
                                            "cross_sell_ids" => $product->cross_sell_ids,
                                            "parent_id" => $product->parent_id,
                                            "reviews_allowed" => $product->reviews_allowed,
                                            "purchase_note" => $product->purchase_note,
                                            "attributes" => $product->attributes,
                                            "default_attributes" => $product->default_attributes,
                                            "menu_order" => $product->menu_order,
                                            "virtual" => $product->virtual,
                                            "downloadable" => $product->downloadable,
                                            "category_ids" => $product->category_ids,
                                            "tag_ids" => $product->tag_ids,
                                            "shipping_class_id" => $product->shipping_class_id,
                                            "downloads" => $product->downloads,
                                            "download_limit" => $product->download_limit,
                                            "download_limit" => $product->download_limit,
                                            "download_expiry" => $product->download_expiry,
                                            "rating_counts" => $product->rating_counts,
                                            "average_rating" => $product->average_rating,
                                            "review_count" => $product->review_count,
                                            "meta_data" => $product->meta_data,
                                            "average_rating" => $product->average_rating,
                                            "average_rating" => $product->average_rating,
                                            "image" => wp_get_attachment_url($product->image_id, 'full', false),
                                            "gallery" => $image_array,
                                            'variation' => $var_data

                                        );

                                        $array[] = $op;
                                    }
                                }

                            }
                            //break;


                        }
                    } else {
                        if (!empty($height)) {

                            foreach ($height as $single_height) {
                                if ($single_height['start'] <= $height_check && $single_height['end'] >= $height_check) {

                                    if (!empty($material)) {

                                        //  echo $singe->ID;
                                        foreach ($material as $single_material) {

                                            if ($single_material['slug'] == $material_check) {


                                                $op = array(
                                                    "id" => $product->id,
                                                    "name" => $product->name,
                                                    "slug" => $product->slug,
                                                    "date_created" => $product->date_created,
                                                    "status" => $product->status,
                                                    "featured" => $product->featured,
                                                    "catalog_visibility" => $product->catalog_visibility,
                                                    "description" => $product->description,
                                                    "short_description" => $product->short_description,
                                                    "sku" => $product->sku,
                                                    "price" => $product->price,
                                                    "regular_price" => $product->regular_price,
                                                    "sale_price" => $product->sale_price,
                                                    "date_on_sale_from" => $product->date_on_sale_from,
                                                    "date_on_sale_to" => $product->date_on_sale_to,
                                                    "total_sales" => $product->total_sales,
                                                    "tax_status" => $product->tax_status,
                                                    "manage_stock" => $product->manage_stock,
                                                    "stock_quantity" => $product->stock_quantity,
                                                    "stock_status" => $product->stock_status,
                                                    "backorders" => $product->backorders,
                                                    "sold_individually" => $product->sold_individually,
                                                    "weight" => $product->weight,
                                                    "height" => $product->height,
                                                    "upsell_ids" => $product->upsell_ids,
                                                    "cross_sell_ids" => $product->cross_sell_ids,
                                                    "parent_id" => $product->parent_id,
                                                    "reviews_allowed" => $product->reviews_allowed,
                                                    "purchase_note" => $product->purchase_note,
                                                    "attributes" => $product->attributes,
                                                    "default_attributes" => $product->default_attributes,
                                                    "menu_order" => $product->menu_order,
                                                    "virtual" => $product->virtual,
                                                    "downloadable" => $product->downloadable,
                                                    "category_ids" => $product->category_ids,
                                                    "tag_ids" => $product->tag_ids,
                                                    "shipping_class_id" => $product->shipping_class_id,
                                                    "downloads" => $product->downloads,
                                                    "download_limit" => $product->download_limit,
                                                    "download_limit" => $product->download_limit,
                                                    "download_expiry" => $product->download_expiry,
                                                    "rating_counts" => $product->rating_counts,
                                                    "average_rating" => $product->average_rating,
                                                    "review_count" => $product->review_count,
                                                    "meta_data" => $product->meta_data,
                                                    "average_rating" => $product->average_rating,
                                                    "average_rating" => $product->average_rating,
                                                    "image" => wp_get_attachment_url($product->image_id, 'full', false),
                                                    "gallery" => $image_array,
                                                    'variation' => $var_data

                                                );

                                                $array[] = $op;
                                            }
                                        }
                                    } else {

                                        $op = array(
                                            "id" => $product->id,
                                            "name" => $product->name,
                                            "slug" => $product->slug,
                                            "date_created" => $product->date_created,
                                            "status" => $product->status,
                                            "featured" => $product->featured,
                                            "catalog_visibility" => $product->catalog_visibility,
                                            "description" => $product->description,
                                            "short_description" => $product->short_description,
                                            "sku" => $product->sku,
                                            "price" => $product->price,
                                            "regular_price" => $product->regular_price,
                                            "sale_price" => $product->sale_price,
                                            "date_on_sale_from" => $product->date_on_sale_from,
                                            "date_on_sale_to" => $product->date_on_sale_to,
                                            "total_sales" => $product->total_sales,
                                            "tax_status" => $product->tax_status,
                                            "manage_stock" => $product->manage_stock,
                                            "stock_quantity" => $product->stock_quantity,
                                            "stock_status" => $product->stock_status,
                                            "backorders" => $product->backorders,
                                            "sold_individually" => $product->sold_individually,
                                            "weight" => $product->weight,
                                            "height" => $product->height,
                                            "upsell_ids" => $product->upsell_ids,
                                            "cross_sell_ids" => $product->cross_sell_ids,
                                            "parent_id" => $product->parent_id,
                                            "reviews_allowed" => $product->reviews_allowed,
                                            "purchase_note" => $product->purchase_note,
                                            "attributes" => $product->attributes,
                                            "default_attributes" => $product->default_attributes,
                                            "menu_order" => $product->menu_order,
                                            "virtual" => $product->virtual,
                                            "downloadable" => $product->downloadable,
                                            "category_ids" => $product->category_ids,
                                            "tag_ids" => $product->tag_ids,
                                            "shipping_class_id" => $product->shipping_class_id,
                                            "downloads" => $product->downloads,
                                            "download_limit" => $product->download_limit,
                                            "download_limit" => $product->download_limit,
                                            "download_expiry" => $product->download_expiry,
                                            "rating_counts" => $product->rating_counts,
                                            "average_rating" => $product->average_rating,
                                            "review_count" => $product->review_count,
                                            "meta_data" => $product->meta_data,
                                            "average_rating" => $product->average_rating,
                                            "average_rating" => $product->average_rating,
                                            "image" => wp_get_attachment_url($product->image_id, 'full', false),
                                            "gallery" => $image_array,
                                            'variation' => $var_data

                                        );

                                        $array[] = $op;
                                    }
                                }
                            }

                        } else {
                            if (!empty($material)) {

                                //  echo $singe->ID;
                                foreach ($material as $single_material) {

                                    if ($single_material['slug'] == $material_check) {


                                        $op = array(
                                            "id" => $product->id,
                                            "name" => $product->name,
                                            "slug" => $product->slug,
                                            "date_created" => $product->date_created,
                                            "status" => $product->status,
                                            "featured" => $product->featured,
                                            "catalog_visibility" => $product->catalog_visibility,
                                            "description" => $product->description,
                                            "short_description" => $product->short_description,
                                            "sku" => $product->sku,
                                            "price" => $product->price,
                                            "regular_price" => $product->regular_price,
                                            "sale_price" => $product->sale_price,
                                            "date_on_sale_from" => $product->date_on_sale_from,
                                            "date_on_sale_to" => $product->date_on_sale_to,
                                            "total_sales" => $product->total_sales,
                                            "tax_status" => $product->tax_status,
                                            "manage_stock" => $product->manage_stock,
                                            "stock_quantity" => $product->stock_quantity,
                                            "stock_status" => $product->stock_status,
                                            "backorders" => $product->backorders,
                                            "sold_individually" => $product->sold_individually,
                                            "weight" => $product->weight,
                                            "height" => $product->height,
                                            "upsell_ids" => $product->upsell_ids,
                                            "cross_sell_ids" => $product->cross_sell_ids,
                                            "parent_id" => $product->parent_id,
                                            "reviews_allowed" => $product->reviews_allowed,
                                            "purchase_note" => $product->purchase_note,
                                            "attributes" => $product->attributes,
                                            "default_attributes" => $product->default_attributes,
                                            "menu_order" => $product->menu_order,
                                            "virtual" => $product->virtual,
                                            "downloadable" => $product->downloadable,
                                            "category_ids" => $product->category_ids,
                                            "tag_ids" => $product->tag_ids,
                                            "shipping_class_id" => $product->shipping_class_id,
                                            "downloads" => $product->downloads,
                                            "download_limit" => $product->download_limit,
                                            "download_limit" => $product->download_limit,
                                            "download_expiry" => $product->download_expiry,
                                            "rating_counts" => $product->rating_counts,
                                            "average_rating" => $product->average_rating,
                                            "review_count" => $product->review_count,
                                            "meta_data" => $product->meta_data,
                                            "average_rating" => $product->average_rating,
                                            "average_rating" => $product->average_rating,
                                            "image" => wp_get_attachment_url($product->image_id, 'full', false),
                                            "gallery" => $image_array,
                                            'variation' => $var_data

                                        );

                                        $array[] = $op;
                                    }
                                }
                            } else {

                                //echo $product->id;
                                $op = array();

                                //   $array[] = $op;


                            }
                        }
                    }
                    // break;
                }
///break;
            }
        }

        $filteredList = array_unique($array);


        foreach (my_array_unique($array) as $single_product_id) {
            $output [] = $single_product_id;
        }

    }


    wp_reset_postdata();
    header('Content-type: application/json');
    echo json_encode($output, JSON_PRETTY_PRINT);


}

function my_array_unique($array, $keep_key_assoc = false)
{
    $duplicate_keys = array();
    $tmp = array();

    foreach ($array as $key => $val) {
        // convert objects to arrays, in_array() does not support objects
        if (is_object($val))
            $val = (array)$val;

        if (!in_array($val, $tmp))
            $tmp[] = $val;
        else
            $duplicate_keys[] = $key;
    }

    foreach ($duplicate_keys as $key)
        unset($array[$key]);

    return $keep_key_assoc ? $array : array_values($array);
}

function get_product_from_id($data)
{
    $term = get_term_by('id', $data['id'], 'product_cat', 'ARRAY_A');


    $terms = get_the_terms($data['id'], 'product_cat');

    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,

    );
    $products_all = new WP_Query($args);
    $posts = $products_all->get_posts();
    $array = array();
    $op = array();
    $review = array();
    $image_array = array();


    global $product;
    $product = wc_get_product($data['id']);

    $op = array();
    $cats = array();
    $attr = array();
    $array = array();
    $cats = array();
    $args = array_map('wc_get_product', get_posts(['post_type' => 'product', 'include' => $data['id'], 'nopaging' => true]));


    foreach ($args as $single) {
        $meta = get_post_meta($data['id']);


        $image2 = wp_get_attachment_image_url($single->image_id, 'full');
        $link = $image2;
        foreach ($single->gallery_image_ids as $single_image) {


            $image2 = wp_get_attachment_image_url($single_image, 'full');


            $cats [] = $image2;


        }


        $oldAttr = unserialize($meta["_product_attributes"][0]);
        $newAttr = [];

        $args2 = array(
            'post_id' => $data['id'],
            'number' => 100,
            'status' => 'approve',
            'post_status' => 'publish',
            'post_type' => 'product'
        );

        $comments = get_comments($args2);
        foreach ($comments as $comment) {
            $review [] = array(
                'id' => $comment->comment_ID,
                'reviewer_name' => $comment->comment_author,
                'reviewer_email' => $comment->comment_author_email,
                'reviewer_url' => $comment->comment_author_url,
                'content' => $comment->comment_content,

                'rating' => get_comment_meta($comment->comment_ID, 'rating', true),

            );
        }
        foreach ($oldAttr as $key => $attr) {
            foreach (get_the_terms($data['id'], $attr['name']) as $key => $term) {
                $term->url = get_term_link($term->term_id, $term->taxonomy);
                $newAttr[$term->taxonomy][$term->slug] = (array)$term;
            }
        }

        $attr [] = $newAttr;


        $product = new WC_Product_Variable($data['id']);
        $variations = $product->get_available_variations();
        $var_data = [];
        $var_data_2 = [];
        $gallery = [];


        foreach ($variations as $key => $variation) {
            $variation__id = $variation['variation_id'];
            $has_variation_gallery_images = get_post_meta($variation__id, 'rtwpvg_images', true);

            if ($has_variation_gallery_images) {

                foreach ($has_variation_gallery_images as $single_id) {
                    $image3 = wp_get_attachment_image_url($single_id, 'full');


                    $var_data_2 [] = $image3;

                    $variation['variation_gallery_images'] = $var_data_2;
//                    array_replace($variation['variation_gallery_images'],$var_data_2);

                }
            }
            $var_data_2 = null;


            $var_data  [] = array_merge($variation, $_model);


        }

        $array = array(
            'id' => $data['id'],
            'name' => $single->name,
            'slug' => $single->slug,
            'date_created' => $single->date_created,
            'date_modified' => $single->date_modified,
            'status' => $single->status,
            'featured' => $single->featured,
            'catalog_visibility' => $single->catalog_visibility,
            'description' => $single->description,
            'short_description' => $single->short_description,
            'sku' => $single->sku,
            'price' => $single->price,
            'regular_price' => $single->regular_price,
            'sale_price' => $single->sale_price,
            'date_on_sale_from' => $single->date_on_sale_from,
            'date_on_sale_to' => $single->date_on_sale_to,
            'total_sales' => $single->total_sales,
            'tax_status' => $single->tax_status,
            'tax_class' => $single->tax_class,
            'manage_stock' => $single->manage_stock,
            'stock_quantity' => $single->stock_quantity,
            'stock_status' => $single->stock_status,
            'backorders' => $single->backorders,
            'low_stock_amount' => $single->low_stock_amount,
            'weight' => $single->weight,
            'length' => $single->length,
            'width' => $single->width,
            'height' => $single->height,
            'upsell_ids' => $single->upsell_ids,
            'cross_sell_ids' => $single->cross_sell_ids,
            'parent_id' => $single->parent_id,
            'reviews_allowed' => $single->reviews_allowed,
            'purchase_note' => $single->purchase_note,
            'attributes' => $attr,
            'default_attributes' => $single->default_attributes,
            'menu_order' => $single->menu_order,
            'post_password' => $single->post_password,
            'virtual' => $single->virtual,
            'downloadable' => $single->downloadable,
            'category_ids' => $single->category_ids,
            'tag_ids' => $single->tag_ids,
            'shipping_class_id' => $single->shipping_class_id,
            'downloads' => $single->downloads,
            'image_id' => $link,
            'gallery_image_ids' => $cats,
            'download_limit' => $single->download_limit,
            'download_expiry' => $single->download_expiry,
            'rating_counts' => $single->rating_counts,
            'average_rating' => $single->average_rating,
            'review_count' => $single->review_count,
            'product_url' => $single->product_url,
            'button_text' => $single->button_text,
            'meta_data' => $meta,
            'variation' => $var_data,
            'review' => $review,


        );
        $cats = null;
        $op[] = $array;

        break;
    }


    header('Content-type: application/json');
    echo json_encode($op, JSON_PRETTY_PRINT);
    $product = null;

}


function get_product_by_slug($page_slug, $output = OBJECT)
{
    global $wpdb;
    $product = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE post_name = %s AND post_type= %s", $page_slug, 'product'));
    if ($product)
        return get_post($product, $output);

    return null;
}

function get_product_from_slug($slug)

{
    $product_obj = get_product_by_slug($slug['slug']);
    $idMain = $product_obj->ID;

    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,

    );
    $products_all = new WP_Query($args);
    $review = array();


    global $product;
    $product = wc_get_product($idMain);

    $op = array();
    $cats = array();
    $attr = array();
    $array = array();
    $cats = array();
    $args = array_map('wc_get_product', get_posts(['post_type' => 'product', 'include' => $idMain, 'nopaging' => true]));


    foreach ($args as $single) {
        $meta = get_post_meta($idMain);


        $image2 = wp_get_attachment_image_url($single->image_id, 'full');
        $link = $image2;
        foreach ($single->gallery_image_ids as $single_image) {


            $image2 = wp_get_attachment_image_url($single_image, 'full');


            $cats [] = $image2;


        }


        $oldAttr = unserialize($meta["_product_attributes"][0]);
        $newAttr = [];

        $args2 = array(
            'post_id' => $idMain,
            'number' => 100,
            'status' => 'approve',
            'post_status' => 'publish',
            'post_type' => 'product'
        );

        $comments = get_comments($args2);
        foreach ($comments as $comment) {
            $review [] = array(
                'id' => $comment->comment_ID,
                'reviewer_name' => $comment->comment_author,
                'reviewer_email' => $comment->comment_author_email,
                'reviewer_url' => $comment->comment_author_url,
                'content' => $comment->comment_content,

                'rating' => get_comment_meta($comment->comment_ID, 'rating', true),

            );
        }


        if (!empty($oldAttr)) {
            foreach ($oldAttr as $key => $attr) {

                $name_term = get_the_terms($idMain, $attr['name']);
                if (!empty($name_term)) {
                    foreach ($name_term as $key => $term) {
                        //var_dump($term);
                        if (isset($term->taxonomy)) {
                            $term->url = get_term_link($term->term_id, $term->taxonomy);
                            $newAttr[$term->taxonomy][$term->slug] = (array)$term;
                        }

                    }
                }


            }
        }


        $attr [] = $newAttr;


        $product = new WC_Product_Variable($idMain);
        $variations = $product->get_available_variations();
        $var_data = [];
        $var_data_2 = [];
        $gallery = [];

        $_model = [];


        foreach ($variations as $key => $variation) {
            $variation__id = $variation['variation_id'];
            $has_variation_gallery_images = get_post_meta($variation__id, 'rtwpvg_images', true);

            if ($has_variation_gallery_images) {

                foreach ($has_variation_gallery_images as $single_id) {
                    $image3 = wp_get_attachment_image_url($single_id, 'full');


                    $var_data_2 [] = $image3;

                    $variation['variation_gallery_images'] = $var_data_2;

//                    array_replace($variation['variation_gallery_images'],$var_data_2);


                }
            }
            $var_data_2 = null;


            $_model = array(
                '_model' => get_post_meta($variation__id, '_model', true),
                '_product_code' => get_post_meta($variation__id, '_product_code', true),
                '_uniqidentifiercode' => get_post_meta($variation__id, '_uniqidentifiercode', true),
                '_frames' => get_post_meta($variation__id, '_frames', true),
                '_framescoveing' => get_post_meta($variation__id, '_framescoveing', true),
                '_base' => get_post_meta($variation__id, '_base', true),
                '_top' => get_post_meta($variation__id, '_top', true),
                '_quantity' => get_post_meta($variation__id, '_quantity', true),
                '_featuresadditional' => get_post_meta($variation__id, '_featuresadditional', true),
                '_cushionfabric' => get_post_meta($variation__id, '_cushionfabric', true),
                '_cushionsize' => get_post_meta($variation__id, '_cushionsize', true),
                '_door' => get_post_meta($variation__id, '_door', true),
                '_shelf' => get_post_meta($variation__id, '_shelf', true),
                '_tray' => get_post_meta($variation__id, '_tray', true),
                '_sidetableframe' => get_post_meta($variation__id, '_sidetableframe', true),
            );
            $var_data  [] = array_merge($variation, $_model);
//            var_dump($_model);

        }


        $array = array(
            'id' => $idMain,
            'name' => $single->name,
            'slug' => $single->slug,
            'date_created' => $single->date_created,
            'date_modified' => $single->date_modified,
            'status' => $single->status,
            'featured' => $single->featured,
            'catalog_visibility' => $single->catalog_visibility,
            'description' => $single->description,
            'short_description' => $single->short_description,
            'sku' => $single->sku,
            'price' => $single->price,
            'regular_price' => $single->regular_price,
            'sale_price' => $single->sale_price,
            'date_on_sale_from' => $single->date_on_sale_from,
            'date_on_sale_to' => $single->date_on_sale_to,
            'total_sales' => $single->total_sales,
            'tax_status' => $single->tax_status,
            'tax_class' => $single->tax_class,
            'manage_stock' => $single->manage_stock,
            'stock_quantity' => $single->stock_quantity,
            'stock_status' => $single->stock_status,
            'backorders' => $single->backorders,
            'low_stock_amount' => $single->low_stock_amount,
            'weight' => $single->weight,
            'length' => $single->length,
            'width' => $single->width,
            'height' => $single->height,
            'upsell_ids' => $single->upsell_ids,
            'cross_sell_ids' => $single->cross_sell_ids,
            'parent_id' => $single->parent_id,
            'reviews_allowed' => $single->reviews_allowed,
            'purchase_note' => $single->purchase_note,
            'attributes' => $attr,
            'default_attributes' => $single->default_attributes,
            'menu_order' => $single->menu_order,
            'post_password' => $single->post_password,
            'virtual' => $single->virtual,
            'downloadable' => $single->downloadable,
            'category_ids' => $single->category_ids,
            'tag_ids' => $single->tag_ids,
            'shipping_class_id' => $single->shipping_class_id,
            'downloads' => $single->downloads,
            'image_id' => $link,
            'gallery_image_ids' => $cats,
            'download_limit' => $single->download_limit,
            'download_expiry' => $single->download_expiry,
            'rating_counts' => $single->rating_counts,
            'average_rating' => $single->average_rating,
            'review_count' => $single->review_count,
            'product_url' => $single->product_url,
            'button_text' => $single->button_text,
            'meta_data' => $meta,
            'variation' => $var_data,
            'review' => $review,

        );
        $cats = null;
        $op[] = $array;

        break;
    }


    header('Content-type: application/json');
    echo json_encode($op, JSON_PRETTY_PRINT);
    $product = null;

}


function get_partial_order_info($request)
{

    $order_id = $request->get_param('order_id');


    $message = [
        'status' => 0,
        'message' => 'Order ID not Found'
    ];
    $order = wc_get_order($order_id);
    $deliveryfee = get_option('woocommerce_flat_rate_2_settings',$order_id);
    $partial_payment = get_option('partial_payment');
    $tax = 0;
    if(!empty($order)){
        if($order->get_subtotal() >= $partial_payment){
            $due =$order->get_total() -get_option('partial_payment');

        }
        else{
            $due = 0.00;
            $partial_payment = 0.00;
        }

		foreach($order->get_tax_totals() as $item){
           $tax = $item->amount;
        }

        $op = array(
            'get_subtotal' => $order->get_subtotal(),
            'deliveryfee' => $deliveryfee['cost'],
            'partial_payment' => $partial_payment,
            'tax' => $tax,
            'total' => $order->get_total(),
            'due' => $due,
        );


        header('Content-type: application/json');
        echo json_encode($op, JSON_PRETTY_PRINT);
        $partial_payment = null;
    }else{
        header('Content-type: application/json');
        echo json_encode($message, JSON_PRETTY_PRINT);

    }



}


function get_related_products($data)
{
    global $product;

    $product_cats_ids = wc_get_product_term_ids($data['id'], 'product_cat');
    global $post;
    $related = get_posts(
        array(
            'category__in' => wp_get_post_categories($data['id']),
            'numberposts' => 4,
            'post__not_in' => array($data['id']),
            'post_type' => 'product'
        )
    );

    wp_send_json($related);
}


function get_nav_item($data)
{

    $menu = wp_get_nav_menu_items($data['id']);

    foreach ($menu as $item) {
        // var_dump($item);
    }
    wp_send_json($menu);
}


// create new endpoint route
add_action('rest_api_init', function () {
    register_rest_route('wp/v2', 'menu', array(
        'methods' => 'GET',
        'callback' => 'custom_wp_menu',
        'permission_callback' => function () {
            return true;
        }
    ));
});


function custom_wp_menu()
{
    // Replace your menu name, slug or ID carefully

    echo wp_get_nav_menu_items('primary');
}


//home slider / custom post

function custiompost()
{

    register_post_type(
        'home_slider',

        $args = array(
            'labels' => array(
                'name' => __('Home Slider'),
                'singular_name' => __('home_slider'),
                'add_new' => 'Add New Home Slider',
                'edit_item' => 'Edit Home Slider',
                'search_items' => 'Search Home Slider',
            ),
            'supports' => array('title', 'editor', 'custom-fields', 'thumbnail', 'page-attributes', 'post-formats', 'excerpt'),
            'menu_icon' => 'dashicons-schedule',
            'show_tagcloud' => false,
            'rewrite' => array('slug' => 'home-slider', 'with_front' => false),
            'taxonomy' => true,
            'query_var' => true,
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => null,
            'show_in_admin_bar' => true,
            'show_in_nav_menus' => true,
            'can_export' => true,
            'has_archive' => true,
            'exclude_from_search' => false,
            'publicly_queryable' => true,
            'capability_type' => 'post',

        )


    );

}

add_action('init', 'custiompost');

//co cart


add_action('woocommerce_checkout_create_order', 'init_order_status_history', 20, 4);
function init_order_status_history($order, $data)
{
    // Set the default time zone (http://php.net/manual/en/timezones.php)
    date_default_timezone_set('Asia/Dhaka');

    // Init order status history on order creation.
    $order->update_meta_data('_status_history', array(time() => 'pending'));
}

// Getting each status change history and saving the data
add_action('woocommerce_order_status_changed', 'order_status_history', 20, 4);
function order_status_history($order_id, $old_status, $new_status, $order)
{
    // Set the default time zone (http://php.net/manual/en/timezones.php)

    date_default_timezone_set('Asia/Dhaka');
    // Get order status history
    $order_status_history = $order->get_meta('_status_history') ? $order->get_meta('_status_history') : array();

    // Add the current timestamp with the new order status to the history array
    $order_status_history[time()] = $new_status;

    // Update the order status history (as order meta data)
    $order->update_meta_data('_status_history', $order_status_history);
    $order->save(); // Save
}


function ratings_fansub_create()
{
//
//    global $wpdb;
//    $table_name = $wpdb->prefix . "customcart";
//    global $charset_collate;
//    $charset_collate = $wpdb->get_charset_collate();
//    global $db_version;
//
//    if ($wpdb->get_var("SHOW TABLES LIKE '" . $table_name . "'") != $table_name) {
//        $create_sql = "CREATE TABLE " . $table_name . " (
//            id INT(50) NOT NULL auto_increment,
//            user_id INT(50) NOT NULL ,
//            product_id INT(50) NOT NULL ,
//            variable_id INT(50) NOT NULL ,
//            image_id VARCHAR(255) NOT NULL,
//            price INT(50) NOT NULL,
//            count INT(50) NOT NULL ,
//            PRIMARY KEY (id))$charset_collate;";
//    }
//    require_once(ABSPATH . "wp-admin/includes/upgrade.php");
//    dbDelta($create_sql);
//
//
//    //register the new table with the wpdb object
//    if (!isset($wpdb->ratings_fansub)) {
//        $wpdb->ratings_fansub = $table_name;
//        //add the shortcut so you can use $wpdb->stats
//        $wpdb->tables[] = str_replace($wpdb->prefix, '', $table_name);
//    }

}

add_action('init', 'ratings_fansub_create');


//custom field for product variation
// Add Variation Custom fields

//Display Fields in admin on product edit screen
add_action('woocommerce_product_after_variable_attributes', 'woo_variable_fields', 10, 3);

//Save variation fields values
add_action('woocommerce_save_product_variation', 'save_variation_fields', 10, 2);

// Create new fields for variations
function woo_variable_fields($loop, $variation_data, $variation)
{

    echo '<div class="variation-custom-fields">';

    // model name
    woocommerce_wp_text_input(
        array(
            'id' => '_model[' . $loop . ']',
            'label' => __('Model Name', 'woocommerce'),
//            'placeholder' => 'Bombe',
            //'desc_tip'    => true,
            'wrapper_class' => 'form-row form-row-first',
//            'description' => __( 'Enter the Product Model Name.', 'woocommerce' ),
            'value' => get_post_meta($variation->ID, '_model', true)
        )
    );

    // product code
    woocommerce_wp_text_input(
        array(
            'id' => '_product_code[' . $loop . ']',
            'label' => __('Product Code', 'woocommerce'),
//            'placeholder' => 'Product Code',
            //'desc_tip'    => true,
            'wrapper_class' => 'form-row form-row-last',
//            'description' => __( 'Enter the Product Code.', 'woocommerce' ),
            'value' => get_post_meta($variation->ID, '_product_code', true)
        )
    );
    // uniq identifier code code
    woocommerce_wp_text_input(
        array(
            'id' => '_uniqidentifiercode[' . $loop . ']',
            'label' => __('Uniq Identifier Code', 'woocommerce'),
//            'placeholder' => 'Uniq Identifier',
            //'desc_tip'    => true,
            'wrapper_class' => 'form-row form-row-first',
//            'description' => __( 'Enter Uniq Identifier Code.', 'woocommerce' ),
            'value' => get_post_meta($variation->ID, '_uniqidentifiercode', true)
        )
    );

    // frame
    woocommerce_wp_text_input(
        array(
            'id' => '_frames[' . $loop . ']',
//            'placeholder' => 'Frames',
            'label' => __('Frame', 'woocommerce'),
            //'desc_tip'    => true,
            'wrapper_class' => 'form-row form-row-last',
//            'description' => __( 'Enter Frame.', 'woocommerce' ),
            'value' => get_post_meta($variation->ID, '_frames', true)
        )
    );

    // frame covering
    woocommerce_wp_text_input(
        array(
            'id' => '_framescoveing[' . $loop . ']',
            'label' => __('Frame Covering', 'woocommerce'),
//            'placeholder' => 'Frame Covering',
            //'desc_tip'    => true,
            'wrapper_class' => 'form-row form-row-first',
//            'description' => __( 'Enter Frame.', 'woocommerce' ),
            'value' => get_post_meta($variation->ID, '_framescoveing', true)
        )
    );

    // upholsetery
    woocommerce_wp_text_input(
        array(
            'id' => '_upholstery[' . $loop . ']',
            'label' => __('Upholsetery', 'woocommerce'),
//            'placeholder' => 'Upholsetery',
            //'desc_tip'    => true,
            'wrapper_class' => 'form-row form-row-last',
//            'description' => __( 'Enter Frame.', 'woocommerce' ),
            'value' => get_post_meta($variation->ID, '_frames', true)
        )
    );


    // finish
    woocommerce_wp_text_input(
        array(
            'id' => '_finish[' . $loop . ']',
            'label' => __('Finish', 'woocommerce'),
//            'placeholder' => 'Finish',
            //'desc_tip'    => true,
            'wrapper_class' => 'form-row form-row-first',
//            'description' => __( 'Finish', 'woocommerce' ),
            'value' => get_post_meta($variation->ID, '_finish', true)
        )
    );


    // base
    woocommerce_wp_text_input(
        array(
            'id' => '_base[' . $loop . ']',
            'label' => __('Base', 'woocommerce'),
//            'placeholder' => 'Metal OP69 mat Graphite',
            //'desc_tip'    => true,
            'wrapper_class' => 'form-row form-row-last',
//            'description' => __( 'Base', 'woocommerce' ),
            'value' => get_post_meta($variation->ID, '_base', true)
        )
    );

    // top
    woocommerce_wp_text_input(
        array(
            'id' => '_top[' . $loop . ']',
            'label' => __('Top', 'woocommerce'),
//            'placeholder' => 'Brused Brass',
            //'desc_tip'    => true,
            'wrapper_class' => 'form-row form-row-first',
//            'description' => __( 'Top', 'woocommerce' ),
            'value' => get_post_meta($variation->ID, '_top', true)
        )
    );


    // top
    woocommerce_wp_text_input(
        array(
            'id' => '_quantity[' . $loop . ']',
            'label' => __('Quantity', 'woocommerce'),
//            'placeholder' => 'Quantity',
            //'desc_tip'    => true,
            'wrapper_class' => 'form-row form-row-last',
//            'description' => __( 'Quantity', 'woocommerce' ),
            'value' => get_post_meta($variation->ID, '_quantity', true)
        )
    );


    //cushion fabric
    woocommerce_wp_text_input(
        array(
            'id' => '_cushionfabric[' . $loop . ']',
            'label' => __('Cushion Fabric', 'woocommerce'),
//            'placeholder' => 'Quantity',
            //'desc_tip'    => true,
            'wrapper_class' => 'form-row form-row-first',
//            'description' => __( 'Quantity', 'woocommerce' ),
            'value' => get_post_meta($variation->ID, '_cushionfabric', true)
        )
    );


    //cushion size
    woocommerce_wp_text_input(
        array(
            'id' => '_cushionsize[' . $loop . ']',
            'label' => __('Cushion Size', 'woocommerce'),
//            'placeholder' => 'Quantity',
            //'desc_tip'    => true,
            'wrapper_class' => 'form-row form-row-last',
//            'description' => __( 'Quantity', 'woocommerce' ),
            'value' => get_post_meta($variation->ID, '_cushionsize', true)
        )
    );


    //cushion quantity
    woocommerce_wp_text_input(
        array(
            'id' => '_cushionquantity[' . $loop . ']',
            'label' => __('Cushion Qunatity', 'woocommerce'),
//            'placeholder' => 'Quantity',
            //'desc_tip'    => true,
            'wrapper_class' => 'form-row form-row-first',
//            'description' => __( 'Quantity', 'woocommerce' ),
            'value' => get_post_meta($variation->ID, '_cushionquantity', true)
        )
    );


    // door
    woocommerce_wp_text_input(
        array(
            'id' => '_door[' . $loop . ']',
            'label' => __('Door', 'woocommerce'),
//            'placeholder' => 'Quantity',
            //'desc_tip'    => true,
            'wrapper_class' => 'form-row form-row-last',
//            'description' => __( 'Quantity', 'woocommerce' ),
            'value' => get_post_meta($variation->ID, '_door', true)
        )
    );


    // shelf
    woocommerce_wp_text_input(
        array(
            'id' => '_shelf[' . $loop . ']',
            'label' => __('Shelf', 'woocommerce'),
//            'placeholder' => 'Quantity',
            //'desc_tip'    => true,
            'wrapper_class' => 'form-row form-row-first',
//            'description' => __( 'Quantity', 'woocommerce' ),
            'value' => get_post_meta($variation->ID, '_shelf', true)
        )
    );


    // tray
    woocommerce_wp_text_input(
        array(
            'id' => '_tray[' . $loop . ']',
            'label' => __('Tray', 'woocommerce'),
//            'placeholder' => 'Quantity',
            //'desc_tip'    => true,
            'wrapper_class' => 'form-row form-row-last',
//            'description' => __( 'Quantity', 'woocommerce' ),
            'value' => get_post_meta($variation->ID, '_tray', true)
        )
    );


    // side table frame
    woocommerce_wp_text_input(
        array(
            'id' => '_sidetableframe[' . $loop . ']',
            'label' => __('Side Table Frame', 'woocommerce'),
//            'placeholder' => 'Quantity',
            //'desc_tip'    => true,
            'wrapper_class' => 'form-row form-row-first',
//            'description' => __( 'Quantity', 'woocommerce' ),
            'value' => get_post_meta($variation->ID, '_sidetableframe', true)
        )
    );


    // additional features
    woocommerce_wp_text_input(
        array(
            'id' => '_featuresadditional[' . $loop . ']',
            'label' => __('Additional Features', 'woocommerce'),
//            'placeholder' => 'Electrial System',
            //'desc_tip'    => true,
            'wrapper_class' => 'form-row form-row-last',
//            'description' => __( 'Additional Features', 'woocommerce' ),
            'value' => get_post_meta($variation->ID, '_featuresadditional', true)
        )
    );


    echo "</div>";

}

/** Save new fields for variations */
function save_variation_fields($variation_id, $i)
{

    // Text Field
    $model = $_POST['_model'][$i];
    update_post_meta($variation_id, '_model', esc_attr($model));


    // Text Field
    $_product_code = $_POST['_product_code'][$i];
    update_post_meta($variation_id, '_product_code', esc_attr($_product_code));


    // Text Field
    $_uniqidentifiercode = $_POST['_uniqidentifiercode'][$i];
    update_post_meta($variation_id, '_uniqidentifiercode', esc_attr($_uniqidentifiercode));


    // Text Field
    $_frames = $_POST['_frames'][$i];
    update_post_meta($variation_id, '_frames', esc_attr($_frames));


    // Text Field
    $_framescoveing = $_POST['_framescoveing'][$i];
    update_post_meta($variation_id, '_framescoveing', esc_attr($_framescoveing));


    // Text Field
    $_upholstery = $_POST['_upholstery'][$i];
    update_post_meta($variation_id, '_product_code', esc_attr($_upholstery));


    // Text Field
    $_base = $_POST['_base'][$i];
    update_post_meta($variation_id, '_base', esc_attr($_base));


    // Text Field
    $_top = $_POST['_top'][$i];
    update_post_meta($variation_id, '_top', esc_attr($_top));


    // Text Field
    $_quantity = $_POST['_quantity'][$i];
    update_post_meta($variation_id, '_quantity', esc_attr($_quantity));

    // Text Field
    $_cushionfabric = $_POST['_cushionfabric'][$i];
    update_post_meta($variation_id, '_cushionfabric', esc_attr($_cushionfabric));

    // Text Field
    $_cushionsize = $_POST['_cushionsize'][$i];
    update_post_meta($variation_id, '_cushionsize', esc_attr($_cushionsize));


    // Text Field
    $_door = $_POST['_door'][$i];
    update_post_meta($variation_id, '_door', esc_attr($_door));


    // Text Field
    $_shelf = $_POST['_shelf'][$i];
    update_post_meta($variation_id, '_shelf', esc_attr($_shelf));

    // Text Field
    $_tray = $_POST['_tray'][$i];
    update_post_meta($variation_id, '_tray', esc_attr($_tray));

    // Text Field
    $_sidetableframe = $_POST['_sidetableframe'][$i];
    update_post_meta($variation_id, '_sidetableframe', esc_attr($_sidetableframe));


    // Text Field
    $_featuresadditional = $_POST['_featuresadditional'][$i];
    update_post_meta($variation_id, '_featuresadditional', esc_attr($_featuresadditional));


}

add_action('wf_refresh_after_product_import', 'refresh_after_product_import', 1);


function my_custom_post_type()
{


    register_post_type(
        'mypost',

        $args = array(
            'labels' => array(
                'name' => __('My Post'),
                'singular_name' => __('my_post'),
                'add_new' => 'Add New Post',
                'edit_item' => 'Edit Post',
                'search_items' => 'Search Post',
            ),
            'supports' => array('title', 'editor', 'custom-fields', 'thumbnail', 'page-attributes', 'post-formats', 'excerpt'),
            'menu_icon' => 'dashicons-schedule',
            'show_tagcloud' => false,
            'rewrite' => array('slug' => 'my_post', 'with_front' => false),
            'taxonomy' => true,
            'query_var' => true,
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => null,
            'show_in_admin_bar' => true,
            'show_in_nav_menus' => true,
            'can_export' => true,
            'has_archive' => true,
            'exclude_from_search' => false,
            'publicly_queryable' => true,
            'capability_type' => 'post',

        )


    );


}

add_action('init', 'my_custom_post_type');


function add_my_settings($settings)
{

    $updated_settings = array();
    $new_settings = array(// this is where you create your settings
    );

    // loop through settings to add them to the update ones and insert the new ones
    foreach ($settings as $setting) {
        // merge the existing settings into our new array
        $updated_settings[] = $setting;

        // determine which setting you want to add yours after
        if (isset($setting['id']) && 'add_after_this_setting_id' === $setting['id']) {
            $updated_settings = array_merge($updated_settings, $new_settings);
        }
    }

    return $updated_settings;
}

add_filter('woocommerce_some_settings_im_adding_stuff_to', 'add_my_settings');


// Add a new section to WooCommerce > Settings > Products
function add_my_products_section($sections)
{
    $sections['tshirt_designer'] = __('Partial Payment', 'my-textdomain');
    return $sections;
}

add_filter('woocommerce_get_sections_products', 'add_my_products_section');


// Add Settings for new section
function add_my_products_settings($settings, $current_section)
{

    // make sure we're looking only at our section
    if ('tshirt_designer' === $current_section) {

        $my_settings = array(
            array(
                'title' => __('Partial Payment', 'my-textdomain'),
                'type' => 'title',
                'id' => 'my_settings_section',
            ),

            array(
                'id' => 'partial_payment',
                'type' => 'text',
                'title' => __('Partial Payment', 'my-textdomain'),
                'default' => 'uno',
                'desc_tip' => true,
            ),

            array(
                'type' => 'sectionend',
                'id' => 'my_settings_section',
            ),
        );

        return $my_settings;

    } else {
        // otherwise give us back the other settings
        return $settings;
    }
}


