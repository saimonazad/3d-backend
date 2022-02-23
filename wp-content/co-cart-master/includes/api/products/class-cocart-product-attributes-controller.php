<?php
/**
 * CoCart - Product Attributes controller
 *
 * Handles requests to the products/attributes endpoint.
 *
 * @author   Sébastien Dumont
 * @category API
 * @package  CoCart\API\Products\v1
 * @since    3.1.0
 * @license  GPL-2.0+
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * REST API Product Attributes controller class.
 *
 * @package CoCart/API
 * @extends CoCart_Product_Attributes_Controller
 */
class CoCart_Product_Attributes_V2_Controller extends CoCart_Product_Attributes_Controller {

	/**
	 * Endpoint namespace.
	 *
	 * @var string
	 */
	protected $namespace = 'cocart/v2';

}
