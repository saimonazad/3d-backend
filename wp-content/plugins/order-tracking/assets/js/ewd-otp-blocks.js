var el = wp.element.createElement,
	registerBlockType = wp.blocks.registerBlockType,
	ServerSideRender = wp.components.ServerSideRender,
	TextControl = wp.components.TextControl,
	SelectControl = wp.components.SelectControl,
	InspectorControls = wp.editor.InspectorControls;
	Localize = wp.i18n.__,
	ewdOtpBlocks = ewd_otp_blocks,
	existingLocations = ewdOtpBlocks.locationOptions;

registerBlockType( 'order-tracking/ewd-otp-display-tracking-form-block', {
	title: 'Tracking Form',
	icon: 'clipboard',
	category: 'ewd-otp-blocks',
	attributes: {
		show_orders: { type: 'string' },
	},

	edit: function( props ) {
		var returnString = [];
		returnString.push(
			el( InspectorControls, {},
				el( SelectControl, {
					label: 'Show Orders?',
					value: props.attributes.show_orders,
					options: [ {value: 'No', label: 'No'}, {value: 'Yes', label: 'Yes'} ],
					onChange: ( value ) => { props.setAttributes( { show_orders: value } ); },
				} )
			),
		);
		returnString.push( el( 'div', { class: 'ewd-otp-admin-block ewd-otp-admin-block-tracking-form' }, 'Display Tracking Form' ) );
		return returnString;
	},

	save: function() {
		return null;
	},
} );

registerBlockType( 'order-tracking/ewd-otp-display-customer-form-block', {
	title: 'Customer Form',
	icon: 'clipboard',
	category: 'ewd-otp-blocks',

	edit: function( props ) {
		var returnString = [];
		returnString.push( el( 'div', { class: 'ewd-otp-admin-block ewd-otp-admin-block-customer-form' }, 'Display Customer Form' ) );
		return returnString;
	},

	save: function() {
		return null;
	},
} );

registerBlockType( 'order-tracking/ewd-otp-display-sales-rep-form-block', {
	title: 'Sales Rep Form',
	icon: 'clipboard',
	category: 'ewd-otp-blocks',

	edit: function( props ) {
		var returnString = [];
		returnString.push( el( 'div', { class: 'ewd-otp-admin-block ewd-otp-admin-block-sales-rep-form' }, 'Display Sales Rep Form' ) );
		return returnString;
	},

	save: function() {
		return null;
	},
} );

registerBlockType( 'order-tracking/ewd-otp-display-customer-order-form-block', {
	title: 'Customer Order Form',
	icon: 'clipboard',
	category: 'ewd-otp-blocks',

	edit: function( props ) {
		var returnString = [];
		returnString.push(
			el( InspectorControls, {},
				el( SelectControl, {
					label: Localize( 'Starting Location', 'order-tracking' ),
					value: props.attributes.location,
					options: existingLocations,
					onChange: ( value ) => { props.setAttributes( { location: value } ); },
				} )
			),
		);
		returnString.push( el( 'div', { class: 'ewd-otp-admin-block ewd-otp-admin-block-customer-order' }, 'Display Customer Order Form' ) );
		return returnString;
	},

	save: function() {
		return null;
	},
} );



