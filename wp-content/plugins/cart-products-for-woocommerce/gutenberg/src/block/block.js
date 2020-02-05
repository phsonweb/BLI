
import './style.scss';
import './editor.scss';

(function(wp) {
	var registerBlockType = wp.blocks.registerBlockType;
	var InspectorControls = wp.editor.InspectorControls;
	var PanelBody = wp.components.PanelBody;
	var TextControl = wp.components.TextControl;
	var ColorPicker = wp.components.ColorPicker;
	var ColorPalette = wp.components.ColorPalette;
	var SelectControl = wp.components.SelectControl;
	var Dashicon = wp.components.Dashicon;
	var el = wp.element.createElement;
	var withState = wp.compose.withState;
	var __ = wp.i18n.__;

	const postSelections = [];
	const allPosts = wp.apiFetch({path: "/wc/v3/products/categories/"}).then(categories => {	
			$.each( categories, function( key, val ) {
					postSelections.push({label: val.name, value: val.slug});
			});
			return postSelections;
	});

  function AmiliaControl(props) {
		var attributes = props.attributes;
		var setAttributes = props.setAttributes;
		var setState = props.setState;
		var status = props.status;

		console.log('category', attributes);


		const MyTextControl = withState( {
				category_txt: attributes.category,
			} )( ( { category, setState } ) => ( 
					<TextControl
							label="Categories"
							value={ attributes.category }
							onChange={ ( category_txt ) => setAttributes( { category_txt } ) }
					/>
			) );
		
		const FooterSelectControl = withState( {
			actions: attributes.actions,
			} )( ( { actions, setState } ) => ( 
					<SelectControl
							label="Show Footer"
							value={ attributes.actions }
							options={ [
									{ label: 'Yes', value: 'true' },
									{ label: 'No', value: 'false' },
							] }
							onChange={ ( actions ) => { setAttributes( { actions } ) } }
					/>
			) );

		const FooterPriceSelectControl = withState( {
			footer_total: attributes.footer_total,
			} )( ( { footer_total, setState } ) => ( 
					<SelectControl
							label="Show Total Price"
							value={ attributes.footer_total }
							options={ [
									{ label: 'Yes', value: 'true' },
									{ label: 'No', value: 'false' },
							] }
							onChange={ ( footer_total ) => { setAttributes( { footer_total } ) } }
					/>
			) );
			
		const ThumbSelectControl = withState( {
			show_thumb: attributes.show_thumb,
			} )( ( { show_thumb, setState } ) => ( 
					<SelectControl
							label="Show Product Thumb"
							value={ attributes.show_thumb }
							options={ [
									{ label: 'Yes', value: 'true' },
									{ label: 'No', value: 'false' },
							] }
							onChange={ ( show_thumb ) => { setAttributes( { show_thumb } ) } }
					/>
			) );

		const TypeSelectControl = withState( {
				type: attributes.type,
			} )( ( { type, setState } ) => ( 
					<SelectControl
							label="Type"
							value={ attributes.type }
							options={ [
									{ label: 'Default', value: 'default' },
									{ label: 'By Category', value: 'bycategory' },
							] }
							onChange={ ( type ) => { setAttributes( { type } ) } }
					/>
			) );


		const CategorySelectControl = withState( {
				category: attributes.category,
			} )( ( { category, setState } ) => ( 
					<SelectControl
							multiple
							label="Category"
							value={ attributes.category }
							options={ postSelections }
							onChange={ ( category ) => { setAttributes( { category: category } ) } }
					/>
			) );

  		var inspectorControl = el(InspectorControls, {}, 

				el(CategorySelectControl),
				el(TypeSelectControl),

				el(ThumbSelectControl),

				el(FooterSelectControl),
				el(FooterPriceSelectControl),


				el('a', {href: 'https://www.cloudways.com/en/wordpress-cloud-hosting.php?id=151244&amp;a_bid=08e2b8f4', target: '_top'}, 
					el('img', {src: '//www.cloudways.com/affiliate/accounts/default1/banners/08e2b8f4.jpg', title: 'Load WordPress Sites in as fast as 37ms!'})
				),
				el('img', {src: 'https://www.cloudways.com/affiliate/scripts/imp.php?id=151244&amp;a_bid=08e2b8f4', width: '1', height: '1'}),

				//el({}, {}, '<a href="https://www.cloudways.com/en/wordpress-cloud-hosting.php?id=151244&amp;a_bid=08e2b8f4" target="_top"><img src="//www.cloudways.com/affiliate/accounts/default1/banners/08e2b8f4.jpg" alt="Load WordPress Sites in as fast as 37ms!" title="Load WordPress Sites in as fast as 37ms!" width="300" height="600" /></a><img style="border:0" src="https://www.cloudways.com/affiliate/scripts/imp.php?id=151244&amp;a_bid=08e2b8f4" width="1" height="1" alt=""/>'),

			);

		return el('div', 
			{
				className: 'wccp-cart-products-store-block'
			},

			el('h3', {className: 'strong'}, "Cart Products for Woocommerce"),
			el('p', {className: ''}, "You can configure this block under Block Settings."),
			el('p', {className: 'italic'}, "Changes are visible on front-end."),
			inspectorControl
	  );
	}

  registerBlockType('wccp/shortcode-block', {
	  title: __('Cart Products'),
	  category: 'embed',
	  icon: {
			foreground: '#46aaf8',
			src: 'store'
	  },
	  attributes: {
			type: {
				type: 'string',
				default: null
			},
			category: {
				type: 'array',
				default: null
			},
			actions: {
				type: 'string',
				default: 'true'
			},
			footer_total: {
				type: 'string',
				default: 'true'
			},
			show_thumb: {
				type: 'string',
				default: 'true'
			}
	  },
	  edit: AmiliaControl,
	  save: function(props) {
			return null;
	  }
	});

})(window.wp);