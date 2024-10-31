<?php 
function ppfw_popular_products_views_count($productID) {
	$count_key = 'views';
	$count = get_post_meta($productID, $count_key, true);
	if($count==''){
		delete_post_meta($productID, $count_key);
		add_post_meta($productID, $count_key, '1');
	}else{
		$count++;
		update_post_meta($productID, $count_key, $count);
	}
}

/*
 * track product views
 */
function ppfw_popular_products_views ($post_id) {
	if ( is_product() ){
		if ( empty ( $post_id) ) {
			global $post;
			$post_id = $post->ID;
			ppfw_popular_products_views_count($post_id);
		}
	}
}
add_action( 'wp_head', 'ppfw_popular_products_views');