<?php 
function ppfw_popular_products_widget_register(){
	register_widget('PPFW_Popular_Products_Widget');
}
add_action('widgets_init','ppfw_popular_products_widget_register');

class PPFW_Popular_Products_Widget extends WP_Widget{

	public function __construct(){
		parent:: __construct('ppfw_popular_product_widget', 'Popular Products',array(
          'description'=> 'Shown your most viwes products'
			));
	}


	public function form($instance){

		if(isset($instance['title'])){
			$title = $instance['title'];
		}else{
			$title = 'Popular Products';
		}  

		if(isset($instance['post_per_page'])){
			$post_per_page = $instance['post_per_page'];
		}else{
			$post_per_page = 5;
		}  
 
 		if(isset($instance['displayviews'])){
 	  		$displayviews = $instance['displayviews'];
 	    }else{
 	   		$displayviews = 0;
 	    }
 	    if(isset($instance['display_rating'])){
 	  	    $display_rating = $instance['display_rating'];
 	    }

 	  
		?>
       <p>
       	<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Widget Title:','popular-products-for-woocommerce');?></label>
       	<input type="text" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>"
       	value="<?php echo esc_attr ($title); ?>" class="widefat">
       </p>

		<p>
       	<label for="<?php echo $this->get_field_id('post_per_page') ?>"><?php esc_html_e('Posts Per Page:','popular-products-for-woocommerce');?></label>
       	<input type="text" id="<?php echo $this->get_field_id('post_per_page') ?>" name="<?php echo esc_attr($this->get_field_name('post_per_page')); ?>"
       	value="<?php echo esc_attr ($post_per_page); ?>" class="widefat">
       </p>

       <p>
       <input type="checkbox" id="<?php echo $this->get_field_id('displayviews') ?>" name="<?php echo esc_attr($this->get_field_name('displayviews')); ?>"
       	value="1" <?php checked($displayviews,1); ?> class="widefat">
       	<label for="<?php echo $this->get_field_id('displayviews') ?>"><?php esc_html_e('Display Views Count','popular-products-for-woocommerce');?></label>
       	</p>

       <p>
       	<input type="checkbox" id="<?php echo $this->get_field_id('display_rating') ?>" name="<?php echo esc_attr($this->get_field_name('display_rating')); ?>"
       	value="1" <?php checked($display_rating,1); ?> class="widefat">
       	<label for="<?php echo $this->get_field_id('display_rating') ?>"><?php esc_html_e('Display Rating','popular-products-for-woocommerce');?></label>
       	</p>

	<?php
	}


    public function update($new_instance, $old_instance){

      $instance = array();
      $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
      $instance['post_per_page'] = (!empty($new_instance['post_per_page'])) ? strip_tags($new_instance['post_per_page']) : '';
      $instance['displayviews'] = (!empty($new_instance['displayviews'])) ? strip_tags($new_instance['displayviews']) : '';
      $instance['display_rating'] = (!empty($new_instance['display_rating'])) ? strip_tags($new_instance['display_rating']) : '';
	  return $instance;
	  
	}


	public function widget($args,$instance){

		global $product;
		global $woocommerce;

		$title=$instance['title'];
		$post_per_page=$instance['post_per_page'];
		$displayviews=$instance['displayviews'];
		$display_rating=$instance['display_rating'];

		$tp_posts = new WP_Query( array(
			"posts_per_page" => $post_per_page,
			"post_type" => "product",
			'meta_key' => 'total_sales',
			'orderby' => 'meta_value_num',
			"order" => "DESC",
		) );

		echo $args['before_widget'];
		echo $args['before_title'];
		echo wp_kses_post($title);
		echo $args['after_title'];
		if ( $tp_posts->have_posts() ) {
			while ( $tp_posts->have_posts() ) {
				$tp_posts->the_post();
				$product = new WC_Product(get_the_ID()); 
				$count = get_post_meta(get_the_ID(),'views', true);
				?>
				<div class="propular-product-widget woocommerce">
					<a class="propular-product-img" href="<?php esc_url(the_permalink()); ?>"><?php the_post_thumbnail('full');?></a>
					<div>
						<a class="propular-product-title" href="<?php esc_url(the_permalink()); ?>"><?php the_title();?></a>
						<br>
						<?php if ( $price_html = $product->get_price_html() ) : ?>
						<?php echo wp_kses( $price_html, 'wp_kses_post' ); ?>
						<?php endif; ?>
						<br>
						<?php
						if($displayviews == 1 && $count > 0){
							echo esc_html($count).' '. esc_html__('views','popular-products-for-woocommerce');
						}
						?>
						<br>
						<?php
						if($display_rating == 1){
							if ( wc_review_ratings_enabled() ) {
								echo wc_get_rating_html( $product->get_average_rating() ); 
							}
						}
						?>
					</div>
				</div>
			<?php
			}
		} else {
			echo esc_html__('Click or visit a products of your website to show it as popular products','popular-products-for-woocommerce');
		}
		echo $args['after_widget'];
	}
}