<?php
/**
* Plugin name: Popular Products for WooCommerce
* Plugin URI: https://github.com/arrony200/popular-products-for-woocommerce
* description: This is a simple widget and shortcode plugin to show WooCommerce Popular Products of your WordPress website based on views.
* Version: 1.0.1
* Author: arrony200
* Author URI: http://arrony200.com/
* Tested up to: 5.9
* Textdomain: popular-products-for-woocommerce
* License URI: http://www.gnu.org/licenses/gpl-2.0.html
* License: GPL2
* Copyright 2021 arrony200  (email : arrony200@gmail.com, skype:barony27)
* This program is free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License, version 2, as
* published by the Free Software Foundation.
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
* You should have received a copy of the GNU General Public License
* along with this program; if not, write to the Free Software
* Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
**/

if(!defined('ABSPATH')){
	exit;
}

function ppfw_popular_products_style(){
   wp_enqueue_style('ppfw-popular-products-style', plugin_dir_url( __FILE__ ) . 'assets/css/style.css',false,time() );
}
add_action('wp_enqueue_scripts','ppfw_popular_products_style');

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
   require_once(plugin_dir_path(__FILE__).'/includes/popular-products-widget.php');
   require_once(plugin_dir_path(__FILE__).'/includes/helper-function.php');
   require_once(plugin_dir_path(__FILE__).'/includes/actions.php');
}