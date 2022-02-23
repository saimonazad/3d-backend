(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 */
	 $( window ).load(function() {
		 $('body').on('click', '.slot_delete', function () {
			 var ajaxurl = blog.ajaxurl;
			 var $id = $(this).attr('data-id');
			 var data = {
				 'action': 'appointment_slot_delete',
				 'id' : $id,
			 };
			 if(confirm('Are you sure ?')) {
				 $.post(blog.ajaxurl, data, function (response) {
					 location.reload();
				 });

				 return false;
			 }
		 });

		 return false;
	 });

	$(document).ready(function(){
		$('.datepicker').datepicker({
			format: "dd-mm-yyyy",
		});

		$('.appoint_close').on('click', function (e) {
			var id = $(this).attr('data-id');
			appoint_status_update(id, 3);
		});

		$('.appoint_cancel').on('click', function (e) {
			var id = $(this).attr('data-id');
			appoint_status_update(id, 4);
		});

		function appoint_status_update(id, status) {
			if(confirm('Are you sure ?')){
				$.get(blog.ajaxurl, {
					"action": "appointStatusChange",
					"id": id,
					"status": status,
				},function (data){
					location.reload();
				});
			}
		}

	});
	 /*
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

})( jQuery );
