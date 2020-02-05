=== Cart Products for WordPress ===
Contributors: blueglassinteractive
Tags: cart, products, checkout, woocommerce, tickets, quick checkout, ajax cart, ajax, ux cart, elementor, gutenberg
Requires at least: 4.3
Tested up to: 5.1
Stable tag: 1.0.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Extension for Woocommerce that allows you to add products quickly and easily to the cart straight from cart or checkout page. 


== Description ==
Extension for Woocommerce, that allows you to add products quickly into to cart straight from cart or checkout page. Extreamly usefull for sites with small ammount of products, that needed to be added straight from cart or checkout page. 
If you sell some services, it's easier for the user to select amount right in checkout and pay right away.
Also works with normal product pages (Could be limited support for variable products, as not tested much).
We initially developed this plugin for one of our projects to sell museum tickets.

Plugin does not provide much styling out of the box, plugin is intended to use your theme styling or styling configured with Elementor plugin.
Plugin also doesnt provide any settings page, only Elementor and Gutenberd blocks coonfigurators.

= Building blocks =
Has Elementor block, with fully configurable parameters and styles.
Has Gutenberg block with ability to configure parameters.
Has shortcode [wc_cart_products] with available parameters:
* category : [string] of coma separated product category slugs
* per_page : [number] of total products to show, "-1" by default, which is "all" products
* type : [empty|bycategory]
* actions : [true:false] to show or hide footer area
* show_thumb : [true:false] to show or hide product images
* footer_total : [true:false] to show or hide total price in footer area

= Availbale hooks: =
"wccp/products_query" [Array] - To filter products query (Uses function "wc_get_products()").
"wccp/categoty_h_tag" [string] - To change heading tag. Default "h3".
"wccp/product_table_thumbnail" [true|false] - To hide/show product thumbnail in table.
"wccp/quantity_update_timeout" [number in milliseconds] - To change delay, after when the ajax cart update triggered. Default 800. 



== Installation ==

1. Upload plugin to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Use [job-postings] to print jobs listing

== Changelog ==


= 1.0.4 =
Woocommerce empty cart redirect fixed

= 1.0.3 =
Fixed gutenberg error

= 1.0.2 =
Fixed php warning

= 1.0.1 =
Added WP5 version check to load gutenberg block

= 1.0.0 =
Initial release
