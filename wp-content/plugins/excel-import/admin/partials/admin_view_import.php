<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       dcastalia.com
 * @since      1.0.0
 *
 * @package    Excel_Import
 * @subpackage Excel_Import/admin/partials
 */


?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->


<h3>Import Product From Excel File</h3>

<?php


if (isset($_POST['submit'])) {
    global $wpdb;
    $data = $_POST['data'];;
//    $parent = $_POST['parent'];;


    $data = stripslashes($data);

    $sku = array();

    $colors_product = array();




    if (current_user_can('manage_options')) {
        if (!empty($data)) {

            $data = json_decode($data, TRUE);


            foreach ($data as $index => $single_product) {



                $product_category = $single_product['Product Category'];
                $productType = $single_product['Variation'];
//                $name = $single_product['Name'];
                $sku = $single_product['Meta: _uniqidentifiercode'];
                $price = isset($single_product['Price']);
                $id = isset($single_product['Item No']);
                $parent = isset($single_product['Parent']);
                $tag = isset($single_product['Tags']);
                $meta_productype = isset($single_product['Meta: _product_type']);
                $meta_model = isset($single_product['Meta: _model']);
                $meta_productcode = isset($single_product['Meta: _product_code']);
                $attributeonename = isset($single_product['Attribute 1 name']);
                $attributeonevalue = isset($single_product['Attribute 1 value(s)']);
                $attributtwoname = isset($single_product['Attribute 2 name']);
                $attributtwovalue = isset($single_product['Attribute 2 value(s)']);
                $weight = isset($single_product['Weight (kg)']);
                $width = isset($single_product['Width (cm)']);
                $height = isset($single_product['Height (cm)']);
                $length = isset($single_product['Length (cm)']);
                $_frames = isset($single_product['Meta: _frames']);
                $_framescoveing = isset($single_product['Meta: _framescoveing']);
                $upholstery  = isset($single_product['Upholstery']);
                $meta_cushionfabric  = isset($single_product['Meta: _cushionfabric']);
                $meta__cushionsize  = isset($single_product['Meta: _cushionsize']);
                $drawer  = isset($single_product['Drawer']);
                $_sidetableframe  = isset($single_product['Meta: _sidetableframe']);
                $_tray  = isset($single_product['Meta: _tray']);
                $_base  = isset($single_product['Meta: _base']);
                $_top  = isset($single_product['Meta: _top']);
                $_shelf  = isset($single_product['Meta: _shelf']);
                $_quantity  = isset($single_product['Meta: _quantity']);
                $_door  = isset($single_product['Meta: _door']);
                $_featuresadditional  = isset($single_product['Meta: _featuresadditional']);
                $description  = isset($single_product['Description']);







//                if product type is variable
                if(!empty($productType)){


                    if($productType == 'variable'){
                        $product_id = $wpdb->get_var($wpdb->prepare("SELECT post_id FROM $wpdb->postmeta WHERE meta_key='_sku' AND meta_value='%s' LIMIT 1", $sku));

                        if(empty($product_id)){

                            $term = term_exists($product_category, 'product_cat');
                            $args = array(
                                'post_author' => get_current_user_id(),
                                'post_status' => "Publish", // (Draft | Pending | Publish)
                                'post_title' => sanitize_text_field($name),
                                'post_type' => "product",

                            );

                            $post_id = wp_insert_post($args);

                            wp_set_object_terms( $post_id, 'variable', 'product_type' );

                            update_post_meta( $post_id, '_visibility', 'visible' );
                            update_post_meta( $post_id, '_stock_status', 'instock');
                            update_post_meta( $post_id, 'total_sales', '0' );
                            update_post_meta( $post_id, '_downloadable', 'no' );
                            update_post_meta( $post_id, '_virtual', 'yes' );
                            update_post_meta( $post_id, '_regular_price', $price );
                            update_post_meta( $post_id, '_sale_price', '' );
                            update_post_meta( $post_id, '_purchase_note', '' );
                            update_post_meta( $post_id, '_featured', 'no' );
                            update_post_meta( $post_id, '_weight', $weight );
                            update_post_meta( $post_id, '_length', $length );
                            update_post_meta( $post_id, '_width', $width );
                            update_post_meta( $post_id, '_height', $height );
                            update_post_meta( $post_id, '_sku', $sku );
                            $product_attributes[0] = array(
                                'name' => $attributeonename, // set attribute name
                                'value' => $attributeonevalue, // set attribute value
                                'is_visible' => 1,
                                'is_variation' => 0,
                                'is_taxonomy' => 1
                            );
                            update_post_meta( $post_id, '_product_attributes', array() );
                            update_post_meta( $post_id, '_sale_price_dates_from', '' );
                            update_post_meta( $post_id, '_sale_price_dates_to', '' );
                            update_post_meta( $post_id, '_price', '' );
                            update_post_meta( $post_id, '_sold_individually', '' );
                            update_post_meta( $post_id, '_manage_stock', 'no' );
                            update_post_meta( $post_id, '_backorders', 'no' );
                            update_post_meta( $post_id, '_stock', '' );



//                            if ( ! empty( $post_id ) && function_exists( 'wc_get_product' ) ) {
//                                $product = wc_get_product( $post_id );
//                                $product->set_sku($sku); // Generate a SKU with a prefix. (i.e. 'pre-123')
//                                $product->set_regular_price($price); // Be sure to use the correct decimal price.
//                                $product->save(); // Save/update the WooCommerce order object.
//                            }
////                            wp_set_object_terms($post_id, get_term($term['term_id'])->name, 'product_cat');
////                            if (!empty($taglist['term_id'])) {
////                                wp_set_object_terms($post_id, get_term($taglist['term_id'])->name, 'product_tag');
////                            }
////                            else {
////
////                                $ptag = wp_insert_term($term, 'product_tag', array(
////                                    'description' => '', // optional
////                                    'parent' => 0, // optional
////                                ));
////                                foreach ($ptag as $termlisttag) {
////                                    wp_set_object_terms($post_id, $termlisttag, 'product_tag');
////                                }
////                            }
                        }
                        else{
//                            echo "SKU Already Exist";
                        }

                    }

                    if($productType == 'variation'){
                        $product_id = $wpdb->get_var($wpdb->prepare("SELECT post_id FROM $wpdb->postmeta WHERE meta_key='_sku' AND meta_value='%s' LIMIT 1", $sku));

                        $parent_id = $product_id;
                        $variation = array(
                            'post_title'   => $name,
                            'post_content' => '',
                            'post_status'  => 'publish',
                            'post_parent'  => $parent_id,
                            'post_type'    => 'product_variation'
                        );


                        //Creating Attributes


//Create variations
                        pricode_create_variations( $product_id, $price, '',  ['color' => 'red', 'size' => 'M']);


                    }


                }








            }


        }
    }

}

?>
<form enctype="<?php plugin_dir_path(__FILE__) . "/admin/partials/admin_view_import.php"; ?>" method="post">

    <input id="upload" type=file name="files">
    <?php
    $args = array(
        'parent' => 0
    );
    $terms = get_terms('product_cat', $args);
    // Getting a visual raw output
    ?>


    <input id="append_data" type=hidden name="data">

    <?php submit_button("Import", 'submit', 'submit'); ?>
</form>


<textarea style="width:100%;height: 450px" class="form-control" id="xlx_json"></textarea>

<?php
$attributes = get_post_meta(2940, '_product_attributes', true);
echo "<pre>";
var_dump($attributes);
?>


<?php


function pricode_create_attributes($name, $options, $index)
{
    $attribute = new WC_Product_Attribute();
    $attribute->set_id($index);

    $attribute->set_name($name);
    $attribute->set_options($options);
    $attribute->set_visible(true);
    $attribute->set_variation(true);
    return $attribute;
}

function pricode_create_variations($product_id, $price, $size, $values)
{
    $variation = new WC_Product_Variation();
    $variation->set_parent_id($product_id);
    $variation->set_attributes($values);
    $variation->set_status('publish');

    $variation->set_price($price);
    $variation->set_regular_price($price);
    $myArray = explode('X', $size);
//    $variation->set_height($myArray[0]);
//    $variation->set_width($myArray[1]);
    $variation->set_stock_status();
    $variation->save();


}



?>


<script>
    var ExcelToJSON = function () {

        this.parseExcel = function (file) {
            var reader = new FileReader();

            reader.onload = function (e) {
                var data = e.target.result;
                var workbook = XLSX.read(data, {
                    type: 'binary'
                });
                workbook.SheetNames.forEach(function (sheetName) {
                    // Here is your object
                    var XL_row_object = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
                    var json_object = JSON.stringify(XL_row_object);
                    console.log(JSON.parse(json_object));
                    jQuery('#xlx_json').val(json_object);
                    jQuery('#append_data').val(json_object);
                    // jQuery.ajax({
                    // 	type: 'POST',
                    // 	url: ajax.ajax_url,
                    // 	data: {
                    // 		'data': JSON.parse(json_object),
                    // 		'action': 'admin_content' //this is the name of the AJAX method called in WordPress
                    // 	}, success: function (result) {
                    // 		jQuery( '#xlx_json' ).val( json_object );
                    //
                    // 	//	alert(json_object);
                    // 	},
                    // 	error: function () {
                    // 		//alert("error");
                    // 	}
                    // });
                })
            };

            reader.onerror = function (ex) {
                console.log(ex);
            };

            reader.readAsBinaryString(file);
        };
    };

    function handleFileSelect(evt) {

        var files = evt.target.files; // FileList object
        var xl2json = new ExcelToJSON();
        xl2json.parseExcel(files[0]);
    }

    document.getElementById('upload').addEventListener('change', handleFileSelect, false);
</script>


