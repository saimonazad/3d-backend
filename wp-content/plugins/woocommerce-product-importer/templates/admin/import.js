var $j = jQuery.noConflict();

$j(function() {

	$j('#skip_overview').click(function(){
		$j('#skip_overview_form').submit();
	});

	// Upload methods
	$j('input[name=upload_method]').click(function () {
		$j('.upload-method').hide();
		switch($j('input[name=upload_method]:checked').val()) {

			case 'upload':
				$j('#import-products-filters-upload').show();
				break;

			case 'file_path':
				$j('#import-products-filters-file_path').show();
				break;

			case 'url':
				$j('#import-products-filters-url').show();
				break;

			case 'ftp':
				$j('#import-products-filters-ftp').show();
				break;

		}
	});

	// Unselect all field options for this export type
	$j('.unselectall').click(function () {
		$j(this).closest('.widefat').find('option:selected').attr('selected', false);
	});

	$j(document).ready(function() {
		
		// Adds the Import button to WooCommerce screens within the WordPress Administration
		var import_url = 'admin.php?page=woo_pi';
		var import_text = 'Import';
		var import_text_override = 'Import with <attr value="Product Importer">PI</attr>';
		var import_html = '<a href="' + import_url + '" class="page-title-action">' + import_text + '</a>';

		// Adds the Import button to the Products screen
		var product_screen = $j( '.edit-php.post-type-product' );
		var title_action = product_screen.find( '.page-title-action:last' );
		import_html = '<a href="' + import_url + '#import-product" class="page-title-action" title="Import Products with Product Importer">' + import_text_override + '</a>';
		title_action.after( import_html );

		var type = $j('input:radio[name=upload_method]:checked').val();
		$j('#file-filters-'+type).trigger('click');
	});

});