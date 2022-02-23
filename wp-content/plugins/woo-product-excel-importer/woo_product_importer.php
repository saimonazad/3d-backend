<?php
/*
 * Plugin Name: WordPress Product Excel Import & Export for WooCommerce
 * Plugin URI: https://extend-wp.com/product-import-export-for-woocommerce-with-excel/
 * Description: WordPress Plugin to Import/Update/Export Simple products for WooCommerce in Bulk with Excel
 * Version: 4.1
 * Author: extendWP
 * Author URI: https://extend-wp.com
 *
 * WC requires at least: 2.2
 * WC tested up to: 6.5
 * 
 * License: GPL2
 * Created On: 10-05-2016
 * Updated On: 19-01-2022
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


$role = get_role( 'administrator' );
$role->add_cap( 'wpeieWoo' );

function woopei_js(){

	//ENQUEUED CSS FILE INSTEAD OF INLINE CSS
	wp_enqueue_style( 'woo-importer_css', plugins_url( "/css/woo-importer.css?v=12", __FILE__ ) );	
	wp_enqueue_style( 'woo-importer_css');	

	wp_enqueue_script( 'woo-importer-xlsx', plugins_url( "/js/xlsx.js", __FILE__ ), array('jquery') , null, true );	
	wp_enqueue_script( 'woo-importer-xlsx');	
	wp_enqueue_script( 'woo-importer-filesaver', plugins_url( "/js/filesaver.js", __FILE__ ), array('jquery') , null, true );	
	wp_enqueue_script( 'woo-importer-filesaver');	
	
    wp_enqueue_script( 'woopei_js', plugins_url( "/js/woo-importer.js", __FILE__ ), array('jquery','jquery-ui-core','jquery-ui-draggable','jquery-ui-droppable') , null, true);	
	wp_enqueue_script( 'woopei_js');
	
    $woopei = array( 
		'RestRoot' => esc_url_raw( rest_url() ),
		'plugin_url' => plugins_url( '', __FILE__ ),
		'siteUrl'	=>	site_url(),
		'nonce' => wp_create_nonce( 'wp_rest' ),
		'ajaxUrl' => admin_url( 'admin-ajax.php' ),	
		'exportfile' => plugins_url( '/js/tableexport.js', __FILE__ )
	);	
    wp_localize_script( 'woopei_js', 'woopei', $woopei );		
	
}
add_action('admin_enqueue_scripts', 'woopei_js');

include( plugin_dir_path(__FILE__) .'/import.php');
include( plugin_dir_path(__FILE__) .'/export.php');


add_action( 'wp_ajax_woopei_exportProducts', 'woopei_exportProducts' );
add_action( 'wp_ajax_nopriv_woopei_exportProducts',  'woopei_exportProducts' );

//ADD MENU LINK AND PAGE FOR WOO PRODUCT IMPORTER
add_action('admin_menu', 'woopei_menu');


add_action( 'admin_footer', 'woopeiPopup');

function woopei_menu() {
	add_submenu_page( 'edit.php?post_type=product', 'Product Import Export', 'Import from Excel', 'wpeieWoo', 'woo-product-importer', 'woopei_init' );	
	add_submenu_page( 'woocommerce', 'Product Import Export', 'Import from Excel', 'wpeieWoo', 'woo-product-importer', 'woopei_init' );	
	add_menu_page('Woo Product Importer Settings', 'Product Import Export', 'wpeieWoo', 'woo-product-importer', 'woopei_init', 'dashicons-upload','50');
}


//ADD ACTION LINKS
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'add_woopei_links' );

function add_woopei_links ( $links ) {
 $links[] =  '<a href="' . admin_url( 'admin.php?page=woo-product-importer' ) . '">Settings</a>';
 $links[] =  '<a target="_blank" href="https://extend-wp.com/product/wordpress-product-import-export-excel-woocommerce/">Go PRO</a>';
 $links[] = '<a href="https://extend-wp.com" target="_blank">More plugins!</a>';
   return $links;
}


function woopei_header() {
?>
		<img src='<?php echo plugins_url( 'images/woo_product_importer_banner.jpg', __FILE__ ); ?>'style='width:100%;'  />		
		
<?php
}



function woopei_footer() {
?>
	<hr>

	
		<a target='_blank' class='web_logo' href='https://extend-wp.com/'>
			<img  src='<?php echo plugins_url( 'images/extendwp.png', __FILE__ ); ?>' alt='Get more plugins by extendWP' title='Get more plugins by extendWP' />
		</a>	
<?php
}

function woopei_form() { ?>
			<form method="post" id='woo_importer' enctype="multipart/form-data" action= "<?php echo admin_url( 'admin.php?page=woo-product-importer' ); ?>">
				
				<table class="form-table">
					<tr valign="top">
					<th scope="row" style='width:100%;'>
						<div class="uploader" style="background:url(<?php print plugins_url('images/default.png', __FILE__ );?> ) no-repeat center center;
						background-size:cover" >
							<img src="" class='userSelected'/>
							<input type="file"  required name="file" id='file'  accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" />
						</div>
					</th>
					<td><?php wp_nonce_field('excel_upload'); ?></td>
					</tr>
				</table>
				
				<?php submit_button('Upload','primary','upload'); ?>

			</form>
			
			<?php  woopei_processData(); ?>	
			
<?php		
}

function woopei_main() { ?>

		
		<div class='left_wrap' >		
			<p><strong><?php _e("Download the sample excel file, save it and add your products. Upload it using the form below.","woo_product_importer");?> <a href='<?php echo plugins_url( '/sample.xlsx', __FILE__ ); ?>'><?php _e("SAMPLE EXCEL FILE","woo_product_importer");?></a></strong></p>			
			<?php		
				woopei_form();
			?>		
		</div>
		
		<div class='right_wrap rightToLeft'>
			<h2  class=' center ' style='background:none;box-shadow:none;color:#000;padding-bottom:2px;' >Need to upload Variable Products, Translations, Images?</h2>		
			<h2  class='premium center '><span class="dashicons dashicons-tag"></span>	CHECH PRO VERSION here >></h2>
					
			<p class='center'>			

				<iframe width="100%" height="315" src="https://www.youtube.com/embed/zvMBVo6C3eM" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

			</p>
			<p>	
				<?php woopei_Rating(); ?>
			</p>
			<p>	
				<a target='_blank' class='wp_extensions'  style='text-align:center;margin:0 auto' href='https://extend-wp.com'>
					<b>
						<span class="dashicons dashicons-admin-plugins"></span> <?php esc_html_e( "Check More extend-wp Plugins", "woopei" ); ?>
					</b>
				</a>
			</p>
			
		</div>
<?php		
}

//MAIN FORM FOR EXCEL UPLOAD
function woopei_init() {
	?>
	<!-- ADDITION DIV CLASSES AND STYLE MOVED TO CSS FILE-->
	<div class="importer-wrap">

    <?php 
	
	woopei_header();	
			$tabs = array(
				'main' => __("Import/Update Products","woopei"),
				'exportProducts' =>  __("Export Products","woopei"), 
			);
			
			if(isset($_GET['tab']) && $_GET['tab'] ){
				$current = $_GET['tab'] ;
			}else $current = 'main';
			echo '<h2 class="nav-tab-wrapper" >';
			foreach( $tabs as $tab => $name ){
				$class = ( $tab === $current ) ? ' nav-tab-active' : '';
				echo "<a class='nav-tab$class' href='?page=woo-product-importer&tab=$tab'>$name</a>";
			}
			?>
			<a class='nav-tab premium' href='#'>Delete Products</a>
			<a class='nav-tab premium' href='#'>Import Categories</a>
			<a class='nav-tab premium' href='#'>Delete Categories</a>
			<a class='nav-tab instructions' href='<?php echo plugins_url( '/documentation/documentation.docx', __FILE__ ); ?>'><?php _e("Instructions","woopei");?></a>			
			<?php 	
			echo '</h2>';?>

	<?php 
		if(isset($_GET['tab']) && $_GET['tab']==='exportProducts' ){
			$export = new WooexportProducts;
			$export->exportProductsDisplay();
		}else woopei_main();
	

	?> 

		<div class='get_ajax' style='width:100%;overflow:hidden;' ></div>
		<?php woopei_footer();	?>
	</div>

	<?php
}

	 function woopeiPopup(){ ?>
		<div id="woopeiPopup">
		  <!-- Modal content -->
		  <div class="modal-content">
			<div class='clearfix'><span class="close">&times;</span></div>
			<div class='clearfix verticalAlign'>
				<div class='columns2'>
					<center>
						<img style='width:90%' src='<?php echo plugins_url( 'images/woo_product_importer_premium.png', __FILE__ ); ?>' style='width:100%' />
					</center>
				</div>
				
				<div class='columns2'>
					<h3>Go PRO and get more important features!</h3>
					<p>&#10004; Import / Update Simple + Variable Products with unlimited Attributes + more fields</p>
					<p>&#10004; Import / Update Simple Products unlimited Attributes Comma Separated!</p>
					<p>&#10004; Import / Export Affiliate/External products</p>
					<p>&#10004; NEW - Import / Export <a target='_blank'  href='https://woocommerce.com/products/woocommerce-subscriptions' >Subscription Products</a></p>
					<p>&#10004; Import WPML WooCommerce Product Translations with Excel</p>
					<p>&#10004; Export Simple - Variable Products - get more Product fields</p>
					<p>&#10004; Import / Export ACF custom Product fields and manually defined fields</p>
					<p>&#10004; Import / Export YOAST SEO Meta Product fields</p>
					<p>&#10004; Delete Products with Excel </p>
					<p>&#10004; Import / Delete Categories with Excel </p>
					<p>&#10004; Upload a Product Image from Url as Featured Image</p>
					<p>&#10004; Import Images in <strong>Product Gallery</strong></p>
					<p>&#10004; Import Custom Taxonomies along with Products</p> 
					<p>&#10004; Define <strong>Downloadable Product</strong>, Download url,Download Name, Limit, Expiry </p>
					<p>&#10004; Extra Fields Support: Purchase Note, Featured image, Product Gallery, Downloadable, Upsell, Crossell etc.</p>
					<p class='bottomToUp'><center><a target='_blank' class='premium_button' href='https://extend-wp.com/product/wordpress-product-import-export-excel-woocommerce/'>GET IT HERE</a></center></p>
				</div>
			</div>
		  </div>
		</div>		
		<?php
	}

	function woopei_Rating(){
	?>
		<div class="notice notice-success rating is-dismissible">
			<p>
			<strong><?php esc_html_e( "You like this plugin? ", 'weiep' ); ?></strong><i class='fa fa-2x fa-smile-o' ></i><br/> <?php esc_html_e( "Then please give us ", 'weiep' ); ?> 
				<a target='_blank' href='https://wordpress.org/support/plugin/woo-product-excel-importer/reviews/#new-post'>
					<span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span>
				</a>
			</p>
		</div> 	
	<?php	
	}	


	// check more if you like!
	add_action( 'wp_ajax_nopriv_wpeieWoo_extensions', 'woopei_extensions' );
	add_action( 'wp_ajax_wpeieWoo_extensions', 'woopei_extensions' );
	
	function woopei_extensions(){
		
		if( is_admin() && current_user_can( 'wpeieWoo' ) && isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'wpeieWoo_extensions' ){
			
			$response = wp_remote_get( 'https://extend-wp.com/wp-json/products/v2/product/category/woocommerce' );
			
			if( is_wp_error( $response ) ) {
				return;
			}	
			
			$posts = json_decode( wp_remote_retrieve_body( $response ) );

			if( empty( $posts ) ) {
				return;
			}

			if( !empty( $posts ) ) {
				
				$allowed_html = array(
							'a' => array(
								'style' => array(),
								'href' => array(),
								'title' => array(),
								'class' => array(),
								'id'=>array()                   
							),
							'i' => array('style' => array(),'class' => array(),'id'=>array() ),
							'br' => array('style' => array(),'class' => array(),'id'=>array() ),
							'em' => array('style' => array(),'class' => array(),'id'=>array() ),
							'strong' => array('style' => array(),'class' => array(),'id'=>array() ),
							'h1' => array('style' => array(),'class' => array(),'id'=>array() ),
							'h2' => array('style' => array(),'class' => array(),'id'=>array() ),
							'h3' => array('style' => array(),'class' => array(),'id'=>array() ),
							'h4' => array('style' => array(),'class' => array(),'id'=>array() ),
							'h5' => array('style' => array(),'class' => array(),'id'=>array() ),
							'h6' => array('style' => array(),'class' => array(),'id'=>array() ),
							'img' => array('style' => array(),'class' => array(),'id'=>array() ),
							'p' => array('style' => array(),'class' => array(),'id'=>array() ),
							'ul' => array('style' => array(),'class' => array(),'id'=>array() ),
							'li' => array('style' => array(),'class' => array(),'id'=>array() ),
							'ol' => array('style' => array(),'class' => array(),'id'=>array() ),
							'video' => array('style' => array(),'class' => array(),'id'=>array() ),
							'blockquote' => array('style' => array(),'class' => array(),'id'=>array() ),
							'style' => array(),            
							'img' => array(
								'alt' => array(),
								'src' => array(),
								'title' => array(),
								'style' => array(),
								'class' => array(),
								'id'=>array()
							),
					);				
				
				echo "<div id='woopei_extensions_popup'>";
					echo "<div class='woopei_extensions_content'>";	
						?>
						<span class="woopeiclose">&times;</span>
						<h2><i><?php esc_html_e( 'Extend your WordPress functionality with Extend-WP.com well crafted Premium Plugins!','woopei' ); ?></i></h2>
						<hr/>
						<?php
						foreach( $posts as $post ) {
							
							echo "<div class='ex_columns'><a target='_blank' href='".esc_url( $post->url )."' /><img src='".esc_url( $post->image )."' /></a>
							<h3><a target='_blank' href='".esc_url( $post->url )."' />". esc_html( $post->title ) . "</a></h3>
							<div>". wp_kses( $post->excerpt, $allowed_html )."</div>
							<a class='button_extensions button-primary' target='_blank' href='".esc_url( $post->url )."' />". esc_html__( 'Get it here', 'woopei' ) . " <i class='fa fa-angle-double-right'></i></a>
							</div>";
						}
					echo '</div>';
				echo '</div>';	
			}
			wp_die();
		}
	}
	
?>