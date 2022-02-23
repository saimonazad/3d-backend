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


    <h3>Import Excel File from here</h3>

<?php
//include plugin_dir_path(__FILE__) . '../PHPExcel/IOFactory.php';
if (isset($_POST['submit'])) {
    global $wpdb;
    $data = $_POST['data'];;
    $data = stripslashes($data);

    if (current_user_can('manage_options')) {
        if (!empty($data)) {
            $data = json_decode($data, TRUE);

            foreach ($data as $single_product) {
                // var_dump($single_product);

                $ProductCategory = $single_product['ProductCategory'];
                $ProductType = $single_product['ProductType'];
                $Itemtype = $single_product['Itemtype'];
                $ProductName = $single_product['Product'];
                $model = $single_product['Model_Name'];
                $product_code = $single_product['Product_Code'];
                $uniq = $single_product['unique_identifier_codes'];
                $Material = $single_product['Material'];
//                $Material = $single_product['Material'];
                $Color = $single_product['Color'];
                $Size = $single_product['Size/Dimensions'];
                $Covering = $single_product['Covering'];
                $Notes = $single_product['Notes'];
                $Quantity = $single_product['Quantity'];
                $Price = $single_product['Price'];
                if (!empty($ProductCategory)) {
                    $term = term_exists($ProductCategory, 'product_cat');
                    if (!empty($term['term_id'])) {

                        $args = array(
                            'post_author' => get_current_user_id(),
                            'post_content' => '',
                            'post_status' => "Publish", // (Draft | Pending | Publish)
                            'post_title' => $ProductName,
                            'post_parent' => '',
                            'post_type' => "product",
                            'post_category' => $term['term_id']
                        );
//            $post_id = wp_insert_post($args);
//
//            // Setting the product type
//            wp_set_object_terms($post_id, 'simple', 'product_type');
//            wp_set_object_terms($post_id, get_term($term['term_id'])->name, 'product_cat');
//            // Setting the product price
//            update_post_meta($post_id, '_price', 0);
//            update_post_meta($post_id, '_regular_price', 0);
//

                    } else {


//            $cate_id = wp_insert_term($age, 'product_cat', array(
//                'description' => '', // optional
//                'parent' => 0, // optional
//            ));


//            foreach ($cate_id as $termlist) {
                        $args = array(
                            'post_author' => get_current_user_id(),
                            'post_content' => '',
                            'post_status' => "Publish", // (Draft | Pending | Publish)
                            'post_title' => $ProductName,
                            'post_parent' => '',
                            'post_type' => "product",
                            //   'post_category' => $termlist
                        );


                        //   $post_id = wp_insert_post($args);


                        // Setting the product type
                        //  wp_set_object_terms($post_id, 'variable', 'product_type');
                        // wp_set_object_terms($post_id, $termlist, 'product_cat');
// Setting the product price

//
//
//
                        //function create_product($material,$age,$price,$quantity){
                        $product = new WC_Product_Variable();
                        //  $product->set_description('T-shirt variable description');
                        $product->set_name($ProductName);
                        $product->set_price(strval($Price));
                        $product->set_regular_price(strval($Price));
                        $product->set_manage_stock(true);
                        // $product->set_category_ids($cate_id);
                        $product->set_stock_status('instock');
                        $product->set_stock_quantity($Quantity);
                        // $product->set_attributes('pa_color',['red','blue']);

                        // update_post_meta( $product->get_id(), 'pa_color', array('red','black'));
                        update_post_meta($product->get_id(), '_price', strval($Price));
                        update_post_meta($product->get_id(), '_regular_price', strval($Price));

                        //  wp_set_object_terms( $product->get_id(), 'black', 'pa_color', true );


                        $atts = [];
                        $atts[] = pricode_create_attributes('Color', array($Color));
                        $atts[] = pricode_create_attributes('Materials', array($Material));

//Adding attributes to the created product
                        $product->set_attributes($atts);

//                        $atts[] = Array('pa_color' =>Array(
//                            'name'=>'pa_color',
//                            'value'=>'black',
//                            'is_visible' => '1',
//                            'is_taxonomy' => '1'
//                        ));

                        //update_post_meta( $product->get_id(), '_product_attributes', "ok");

                        $product->save();

//                        $variation_data =  array(
//                            'attributes' => array(
//                                'color' => $Color,
//                            ),
//                            'sku'           => '',
//                            'regular_price' => $Price,
//                            'sale_price'    => $Price,
//                            'stock_qty'     => $Quantity,
//                        );
//                        create_product_variation( $product->get_id(), $variation_data );
//            $variations = $product->get_available_variations();
//
//            var_dump($variations);


                        pricode_create_variations($product->get_id(),$Color,$Price,$Material);


                        //   create_product($material,$age,$price,$quantity);
//

//


                    }
                }
            }
        }
    }

}


?>
    <form enctype="<?php plugin_dir_path(__FILE__) . "/admin/partials/admin_view_import.php"; ?>" method="post">

        <input id="upload" type=file name="files">
        <input id="append_data" type=hidden name="data">

        <?php submit_button("Import", 'submit', 'submit'); ?>
    </form>


    <textarea style="width:100%;height: 450px" class="form-control" id="xlx_json"></textarea>

<?php


?>
    <script>
        document.getElementById('upload').addEventListener('change', handleFileSelect, false)
    </script>

<?php
function update_internalSKU($product_id)
{
    // Get product attributes
    $product_attributes = get_post_meta($product_id, '_product_attributes', true);

    // Loop through product attributes
//    foreach( $product_attributes as $attribute => $attribute_data ) {
//        // Target specif attribute  by its name
//        if( 'color' === $attribute_data['color'] ) {
//            // Set the new value in the array
//            $product_attributes[$attribute]['value'] =array('Black', 'Red');
//            break; // stop the loop
//        }
//    }


    var_dump($product_attributes);
    // Set updated attributes back in database
    update_post_meta($product_id, '_product_attributes', $product_attributes);
}

function pricode_create_attributes($name, $options)
{
    $attribute = new WC_Product_Attribute();
    $attribute->set_id(0);
    $attribute->set_name($name);
    $attribute->set_options($options);
    $attribute->set_visible(true);
    $attribute->set_variation(true);
    return $attribute;
}
function pricode_create_variations($product_id, $color, $price,$materials)
{
    $variation = new WC_Product_Variation();
    $variation->set_parent_id($product_id);
    $variation->set_attributes(['color' => array($color),'materials' => array($materials)]);
    $variation->set_status('publish');
    // $variation->set_sku($data->sku);
    $variation->set_price($price);
    $variation->set_regular_price($price);
    $variation->set_stock_status();
    $variation->save();
    $product = wc_get_product($product_id);
    $product->save();


}


function create_product_variation($product_id, $variation_data)
{
    // Get the Variable product object (parent)
    $product = wc_get_product($product_id);

    $variation_post = array(
        'post_title' => $product->get_name(),
        'post_name' => 'product-' . $product_id . '-variation',
        'post_status' => 'publish',
        'post_parent' => $product_id,
        'post_type' => 'product_variation',
        'guid' => $product->get_permalink()
    );

    // Creating the product variation
    $variation_id = wp_insert_post($variation_post);

    // Get an instance of the WC_Product_Variation object
    $variation = new WC_Product_Variation($variation_id);

    // Iterating through the variations attributes
    foreach ($variation_data['attributes'] as $attribute => $term_name) {
        $taxonomy = 'pa_' . $attribute; // The attribute taxonomy

        // If taxonomy doesn't exists we create it (Thanks to Carl F. Corneil)
        if (!taxonomy_exists($taxonomy)) {
            register_taxonomy(
                $taxonomy,
                'product_variation',
                array(
                    'hierarchical' => false,
                    'label' => ucfirst($attribute),
                    'query_var' => true,
                    'rewrite' => array('slug' => sanitize_title($attribute)), // The base slug
                ),
            );
        }

        // Check if the Term name exist and if not we create it.
        if (!term_exists($term_name, $taxonomy))
            wp_insert_term($term_name, $taxonomy); // Create the term

        $term_slug = get_term_by('name', $term_name, $taxonomy)->slug; // Get the term slug

        // Get the post Terms names from the parent variable product.
        $post_term_names = wp_get_post_terms($product_id, $taxonomy, array('fields' => 'names'));

        // Check if the post term exist and if not we set it in the parent variable product.
        if (!in_array($term_name, $post_term_names))
            wp_set_post_terms($product_id, $term_name, $taxonomy, true);

        // Set/save the attribute data in the product variation
        update_post_meta($variation_id, 'attribute_' . $taxonomy, $term_slug);
    }

    ## Set/save all other data

    // SKU
    if (!empty($variation_data['sku']))
        $variation->set_sku($variation_data['sku']);

    // Prices
    if (empty($variation_data['sale_price'])) {
        $variation->set_price($variation_data['regular_price']);
    } else {
        $variation->set_price($variation_data['sale_price']);
        $variation->set_sale_price($variation_data['sale_price']);
    }
    $variation->set_regular_price($variation_data['regular_price']);

    // Stock
    if (!empty($variation_data['stock_qty'])) {
        $variation->set_stock_quantity($variation_data['stock_qty']);
        $variation->set_manage_stock(true);
        $variation->set_stock_status('');
    } else {
        $variation->set_manage_stock(false);
    }

    $variation->set_weight(''); // weight (reseting)

    $variation->save(); // Save the data
}