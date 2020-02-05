jQuery( function( $ ) {

	if( $('.wccp_show_all').length ){
		$('.wccp_show_all').on('click', function(e){
			e.preventDefault();
			$('.wccp-hidden-category').toggleClass('wccp-hide');
		});
	}

	if( $('.wccp-qty').length ){
		$('.wccp-qty-minus').on('click', function(e){
			e.preventDefault();
			var qty_input 	= $(this).parents('.wccp-qty').find('.qty');
			var min 		= qty_input.attr('min');
			var max 		= qty_input.attr('max');
			var step 		= qty_input.attr('step');
			var value 		= qty_input.val();
			var new_value 	= value;

			new_value = Number(new_value) - Number(step);
			if(new_value < min) {
				new_value = min;
			}

			qty_input.attr('value', new_value).trigger('change');
		});

		$('.wccp-qty-plus').on('click', function(e){
			e.preventDefault();
			var qty_input 	= $(this).parents('.wccp-qty').find('.qty');
			var min 		= qty_input.attr('min');
			var max 		= qty_input.attr('max');
			var step 		= qty_input.attr('step');
			var value 		= qty_input.val();
			var new_value 	= value;

			new_value = Number(new_value) + Number(step);
			if( max != '' && new_value >= Number(max) ){
				new_value = max;
			}

			qty_input.attr('value', new_value).trigger('change');
		});
	}


    $('button[name="custom_update_cart"]').live('click', function(e){
        e.preventDefault();
        var form = $(this).parents('.wccp-woocommerce-cart-form');
        wccp_quantity_update( form );
    });

    function wccp_quantity_update( $form ) {

        block( $form );

        // Provide the submit button value because wc-form-handler expects it.
        $( '<input />' ).attr( 'type', 'hidden' )
                        .attr( 'name', 'update_cart' )
                        .attr( 'value', 'Update Cart' )
                        .appendTo( $form );

        // Make call to actual form post URL.
        $.ajax( {
            type:     $form.attr( 'method' ),
            url:      $form.attr( 'action' ),
            data:     $form.serialize(),
            dataType: 'html',
            success:  function( response ) {
                wccp_update_wc_div( response, true );
                $( document.body ).trigger( 'updated_wc_div' );
            },
            complete: function() {
                unblock( $form );
            }
        } );
    }

    var wccp_update_wc_div = function( html_str, preserve_notices ) {
		var $html       = $.parseHTML( html_str );
		var $new_form   = $( '.wccp-woocommerce-cart-form', $html );
        var $new_totals = $( $html ).find('.cart_totals');
        var $new_total_price = $( $html ).find('.wccp-woocommerce-cart-form').data('cart-total');
        var $notices    = $( '.woocommerce-error, .woocommerce-message, .woocommerce-info', $html );
        
        console.log( '$new_total_price', $new_total_price );

		// No form, cannot do this.
		if ( $( '.wccp-woocommerce-cart-form' ).length === 0 ) {
			window.location.href = window.location.href;
			return;
		}

		// Remove errors
		if ( ! preserve_notices ) {
			$( '.woocommerce-error, .woocommerce-message, .woocommerce-info' ).remove();
		}

		if ( $new_form.length === 0 ) {
			// If the checkout is also displayed on this page, trigger reload instead.
			if ( $( '.woocommerce-checkout' ).length ) {
				window.location.href = window.location.href;
				return;
			}

			// No items to display now! Replace all cart content.
			var $cart_html = $( '.cart-empty', $html ).closest( '.woocommerce' );
			$( '.woocommerce-cart-form__contents' ).closest( '.woocommerce' ).replaceWith( $cart_html );

			// Display errors
			if ( $notices.length > 0 ) {
				show_notice( $notices );
			}
		} else {
			// If the checkout is also displayed on this page, trigger update event.
			if ( $( '.woocommerce-checkout' ).length ) {
				$( document.body ).trigger( 'update_checkout' );
			}

			//$( '.wccp-woocommerce-cart-form' ).replaceWith( $new_form );
			//$( '.wccp-woocommerce-cart-form' ).find( ':input[name="update_cart"]' ).prop( 'disabled', true );

			if ( $notices.length > 0 ) {
				show_notice( $notices );
            }
            
            $('.wccp-woocommerce-cart-form .cart-total-price').html( $new_total_price );

			wccp_update_cart_totals_div( $new_totals );
		}

		$( document.body ).trigger( 'updated_wc_div' );
    };

    $( document.body ).on('updated_wc_div, removed_coupon', function(){
        $('.woocommerce.wccp').prepend( $('.woocommerce-notices-wrapper') );
    });

    /**
	 * Update the .cart_totals div with a string of html.
	 *
	 * @param {String} html_str The HTML string with which to replace the div.
	 */
	var wccp_update_cart_totals_div = function( html_str ) {
        console.log(html_str);
        //$( '.wccp-cart-collaterals .cart_totals' ).html( $(html_str).html() );
        $( '.cart_totals' ).replaceWith( html_str );
		$( document.body ).trigger( 'updated_cart_totals' );
	};

    /**
	 * Check if a node is blocked for processing.
	 *
	 * @param {JQuery Object} $node
	 * @return {bool} True if the DOM Element is UI Blocked, false if not.
	 */
	var is_blocked = function( $node ) {
		return $node.is( '.processing' ) || $node.parents( '.processing' ).length;
	};

	/**
	 * Block a node visually for processing.
	 *
	 * @param {JQuery Object} $node
	 */
	var block = function( $node ) {
		if ( ! is_blocked( $node ) ) {
			$node.addClass( 'processing' ).block( {
				message: null,
				overlayCSS: {
					background: '#fff',
					opacity: 0.6
				}
			} );
		}
    };
    
	/**
	 * Unblock a node after processing is complete.
	 *
	 * @param {JQuery Object} $node
	 */
	var unblock = function( $node ) {
		$node.removeClass( 'processing' ).unblock();
    };
    
} );