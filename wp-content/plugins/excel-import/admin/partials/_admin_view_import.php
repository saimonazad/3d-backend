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
//include plugin_dir_path(__FILE__) . '../PHPExcel/IOFactory.php';
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

                var_dump($single_product['Product Category']);


                if (!empty($ProductCategory)) {
                    $term = term_exists($ProductCategory, 'product_cat');
                    $tag_id_put = null;
                    $product_id = $wpdb->get_var($wpdb->prepare("SELECT post_id FROM $wpdb->postmeta WHERE meta_key='_sku' AND meta_value='%s' LIMIT 1", $uniq));
                    $all_color = null;
                    $all_material = null;
                    var_dump($product_id);

                    if (!empty($product_id)) {

                        $get_old_product_at = wc_get_product_terms($product_id, 'pa_color', array('fields' => 'all'));
                        //   $get_old_material = wc_get_product_terms( $product_id, 'pa_color', array( 'fields' =>  'all' ) );
                        $attri = array();

                        if ($get_old_product_at) {
                            foreach ($get_old_product_at as $term) {

                                $attri[] = $term->name;
                            }
                            $Color = array_merge($attri, array($Color));
                            $all_color[] = implode(', ', $Color);

                        } else {
                            $Color = $Color;
                        }

                        $meta = get_post_meta($product_id);
                        $oldAttr = unserialize($meta["_product_attributes"][0]);
                        $newAttr = [];
                        foreach ($oldAttr as $key => $attr) {
                            foreach (get_the_terms($product_id, $attr['name']) as $key => $term) {
                                $term->url = get_term_link($term->term_id, $term->taxonomy);
                                $newAttr[$term->taxonomy][$term->slug] = (array)$term;
                            }
                        }
                        $attr [] = $newAttr;

                        $att_mat = array_unique(array($attr['value'], $frame));
                        $all_material[] = implode(', ', $att_mat);

                        $get_old_color = array_unique(array_merge($oldAttr['pa_color']['value'], $Color));


                        $product = new WC_Product_Variable($product_id);
                        $product->set_name($ProductName);
                        $product->set_price(strval($price));
                        $product->set_regular_price(strval($price));
                        $product->set_manage_stock(true);
                        $product->set_stock_status('instock');
                        $product->set_stock_quantity($quantity);

                        // $product->set_attributes('pa_color',$all_color);


                        update_post_meta($product->get_id(), '_price', strval($price));
                        update_post_meta($product->get_id(), '_regular_price', strval($price));
                        update_post_meta($product->get_id(), '_sku', strval($uniq));
                        //
                        //
                        wp_set_object_terms($product->get_id(), array($Color), 'pa_color', true);
                        wp_set_object_terms($product->get_id(), array($Color), 'pa_color', true);
                        wp_set_object_terms($product->get_id(), array($frame), 'materials', true);
//                        $attributes_update = array(
//                            "pa_color" =>  array(
//                                'name' => 'pa_color',
//                                'value' => $all_color,
//                                'is_visible' => '1',
//                                'is_taxonomy' => '1'
//                            ),
//                            "materials" =>  array(
//                                'name' => 'materials',
//                                'value' => $Material,
//                                'is_visible' => '1',
//                                'is_taxonomy' => '1'
//                            )
//
//                        );
//                        update_post_meta( $product->get_id() ,'_product_attributes', $attributes_update);


                        $atts[] = pricode_create_attributes('pa_color', $Color, 0);
                        echo "</br>";

                        $atts[] = pricode_create_attributes('materials', array_unique($att_mat), 0);
                        $product->set_attributes($atts);
                        $product->save();


                        pricode_create_variations($product_id, $price, $Size, ['pa_color' => $Color, 'materials' => $frame]);


                    }
                    if(empty($product_id)) {


                        if (!empty($term['term_id'])) {

                            $taglist = term_exists($ProductType, 'product_tag');

                            $args = array(
                                'post_author' => get_current_user_id(),
                                'post_content' => '',
                                'post_status' => "Publish", // (Draft | Pending | Publish)
                                'post_title' => $ProductName,
                                'post_parent' => '',
                                'post_type' => "product",
                                //   'post_category' => $termlist
                            );
                            $post_id = wp_insert_post($args);


                            $product = new WC_Product_Variable($post_id);
                            $product->set_name($ProductName);
                            $product->set_price(strval($price));
                            $product->set_regular_price(strval($price));
                            $product->set_manage_stock(true);
                            $product->set_stock_status('instock');
                            $product->set_stock_quantity($quantity);;
                            update_post_meta($product->get_id(), '_price', strval($price));
                            update_post_meta($product->get_id(), '_regular_price', strval($price));
                            update_post_meta($product->get_id(), '_sku', strval($uniq));
                            $atts = [];
                            $atts[] = pricode_create_attributes('pa_color', array($Color), 0);
                            $atts[] = pricode_create_attributes('materials', array($frame), 0);
                            $product->set_attributes($atts);
                            $product->save();
                            pricode_create_variations($post_id, $price, $Size, ['pa_color' => $Color, 'materials' => $frame]);


                            wp_set_object_terms($post_id, get_term($term['term_id'])->name, 'product_cat');
                            if (!empty($taglist['term_id'])) {
                                wp_set_object_terms($post_id, get_term($taglist['term_id'])->name, 'product_tag');
                            } else {

                                $ptag = wp_insert_term($ProductType, 'product_tag', array(
                                    'description' => '', // optional
                                    'parent' => 0, // optional
                                ));
                                foreach ($ptag as $termlisttag) {
                                    wp_set_object_terms($post_id, $termlisttag, 'product_tag');
                                }
                            }
                        }
                        else {


                            $cate_id = wp_insert_term($ProductCategory, 'product_cat', array(
                                'description' => '', // optional
                                'parent' => 0, // optional
                            ));

                            foreach ($cate_id as $termlist) {
                                $taglist = term_exists($ProductType, 'product_tag');

                                $args = array(
                                    'post_author' => get_current_user_id(),
                                    'post_content' => '',
                                    'post_status' => "Publish", // (Draft | Pending | Publish)
                                    'post_title' => $ProductName,
                                    'post_parent' => '',
                                    'post_type' => "product",
                                    //   'post_category' => $termlist
                                );


                                $post_id = wp_insert_post($args);


                                $product = new WC_Product_Variable($post_id);
                                $product->set_name($ProductName);
                                $product->set_price(strval($price));
                                $product->set_regular_price(strval($price));
                                $product->set_manage_stock(true);
//                                $product->set_tag_ids($get_tag_id);
                                $product->set_stock_status('instock');
                                $product->set_stock_quantity($quantity);
                                update_post_meta($product->get_id(), '_sku', strval($uniq));
                                update_post_meta($product->get_id(), '_price', strval($price));
                                update_post_meta($product->get_id(), '_regular_price', strval($price));
                                $atts = [];
                                $atts[] = pricode_create_attributes('pa_color', array($Color), 0);
                                $atts[] = pricode_create_attributes('materials', array($frame), 0);
                                $product->set_attributes($atts);
                                wp_set_object_terms($post_id, $termlist, 'product_cat');

                                $product->save();
                                wp_set_object_terms($post_id, $termlist, 'product_cat');

                                pricode_create_variations($post_id, $price, $Size, ['pa_color' => $Color, 'materials' => $frame]);


                                if (!empty($taglist['term_id'])) {
                                    wp_set_object_terms($post_id, get_term($taglist['term_id'])->name, 'product_tag');
                                } else {


                                    $ptag = wp_insert_term($ProductType, 'product_tag', array(
                                        'description' => '', // optional
                                        'parent' => 0, // optional
                                    ));


                                    foreach ($ptag as $termlisttag) {

                                        wp_set_object_terms($post_id, $termlisttag, 'product_tag');


                                    }
                                }
                            }

                        }


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


