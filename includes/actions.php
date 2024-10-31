<?php
add_shortcode( 'ppfw_propular_products','ppfw_propular_products_func');
function ppfw_propular_products_func(){

    $ppfw_posts = new WP_Query( array(
        "posts_per_page" => 8,
        "post_type" => "product",
        'meta_key' => 'total_sales',
        'orderby' => 'meta_value_num',
        "order" => "DESC",
        "ignore_sticky_posts" => true,
    ) );
    if ( $ppfw_posts->have_posts() ) {
        ?>
        <div class="ppfw-grid-view">
        <?php
        while ( $ppfw_posts->have_posts() ) {
            $ppfw_posts->the_post();
            $product = new WC_Product(get_the_ID()); 
            $count_num = get_post_meta(get_the_id(),'views', true);
            ?>
            <div class="propular-product-widget woocommerce">
                <a class="propular-product-img" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('full');?></a>
                <a class="propular-product-title" href="<?php the_permalink(); ?>"><?php the_title();?></a>
                <br>
                <?php if ( $price_html = $product->get_price_html() ) : ?>
                <?php echo wp_kses( $price_html, 'wp_kses_post' ); ?>
                <?php endif; ?>
                <br>
                <?php
                if($count_num > 0){
					echo esc_html($count_num).' '. esc_html__('Views','popular-products-for-woocommerce');
                }
				?>
                <br>
                <?php
                if ( wc_review_ratings_enabled() ) {
                    echo wc_get_rating_html( $product->get_average_rating() ); 
                }
				?>
            </div>
        <?php } ?>
        </div>
        <?php
    } else {
        echo esc_html__('Click or visit a products of your website to show it as popular products','popular-products-for-woocommerce');
    }
    wp_reset_postdata();
}