<?php
/**
 * CoCart- Product Tags controller
 *
 * Handles requests to the products/tags endpoint.
 *
 * @author   Sébastien Dumont
 * @category API
 * @package  CoCart\API\Products\v2
 * @since    3.1.0
 * @license  GPL-2.0+
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * REST API Product Tags controller class.
 *
 * @package CoCart/API
 * @extends CoCart_Product_Tags_Controller
 */
class CoCart_Product_Tags_V2_Controller extends CoCart_Product_Tags_Controller {

	/**
	 * Endpoint namespace.
	 *
	 * @var string
	 */
	protected $namespace = 'cocart/v2';

}
