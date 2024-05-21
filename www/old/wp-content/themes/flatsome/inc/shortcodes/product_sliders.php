<?php
function slider_script($sliderrandomid){
	?>
	<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(window).load(function() {
	
		$('#slider_<?php echo $sliderrandomid ?>').iosSlider({
			snapToChildren: true,
			desktopClickDrag: true,
			navPrevSelector: '.prev_<?php echo $sliderrandomid ?>',
			navNextSelector: '.next_<?php echo $sliderrandomid ?>',
			onSliderLoaded: slideLoad,
			onSliderResize: slideLoad,
			onSlideChange: slideChange,
		});

		function slideLoad(args) {
			setTimeout(function() {
			 var t=0;
			 var t_elem;
			 $(args.sliderContainerObject).find('li').each(function () {
			 $this = $(this);
			    if ( $this.outerHeight() > t ) {
			        t_elem=this;
			        t=$this.outerHeight();
				}
				});
				$(args.sliderContainerObject).css('min-height',t);
				$(args.sliderContainerObject).css('height','auto');
			  }, 10);
    	 }


    	 function slideChange(args,slider_count) {
    	 	 var slider_count = $('#slider_<?php echo $sliderrandomid ?>').find('li').length;
    	 	 var slider_count = slider_count - 4;
    	 	 if(args.currentSlideNumber > slider_count){
			 	 $('.next_<?php echo $sliderrandomid ?>').addClass('disabled');
			 } else {
			 	 $('.next_<?php echo $sliderrandomid ?>').removeClass('disabled');
			 }
			 if(args.currentSlideNumber == '1'){
			 	 $('.prev_<?php echo $sliderrandomid ?>').addClass('disabled');
			 } else {
			 	 $('.prev_<?php echo $sliderrandomid ?>').removeClass('disabled');
			 }
    	 }

    	 	});
	  
	});
	</script>

<?php }

// [ux_bestseller_products]
function ux_best_sellers($atts, $content = null) {
	$sliderrandomid = rand();
	extract(shortcode_atts(array(
		"title" => '',
		'products'  => '8',
        'orderby' => 'date',
        'order' => 'desc'
	), $atts));
	ob_start();
	?>
    
    <?php 
	/**
	* Check if WooCommerce is active
	**/
	if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	?>
    
		<?php slider_script($sliderrandomid)?>

		<?php if($title){?> 
		<div class="row">
			<div class="large-12 columns">
				<h3 class="section-title"><span><?php echo $title ?></span></h3>
			</div>
		</div><!-- end .title -->
		<?php } ?>

		<div class="row column-slider">
            <div id="slider_<?php echo $sliderrandomid ?>" class="iosSlider" style="overflow:hidden;height:100px;min-height:100px;">
                <ul class="slider large-block-grid-4 small-block-grid-2">
						<?php
                    $args = array(
                        'post_type' => 'product',
						'post_status' => 'publish',
						'ignore_sticky_posts'   => 1,
						'posts_per_page' => $products,
						'meta_key' 		=> 'total_sales',
    					'orderby' 		=> 'meta_value'
                    );
                    
                    $products = new WP_Query( $args );
                    
                    if ( $products->have_posts() ) : ?>
                        <?php while ( $products->have_posts() ) : $products->the_post(); ?>
                            <?php woocommerce_get_template_part( 'content', 'product' ); ?>
                        <?php endwhile; // end of the loop. ?>
                    <?php
                    
                    endif; 
                    wp_reset_query();
                    ?>
                </ul>   <!-- .slider -->  

            <div class="sliderControlls">
		        <div class="sliderNav small hide-for-small">
		       		 <a href="javascript:void(0)" class="nextSlide disabled prev_<?php echo $sliderrandomid ?>"><span class="icon-angle-left"></span></a>
		       		 <a href="javascript:void(0)" class="prevSlide next_<?php echo $sliderrandomid ?>"><span class="icon-angle-right"></span></a>
		        </div>
       		</div><!-- .sliderControlls -->
			
       		</div> <!-- .iOsslider -->
    </div><!-- .row .column-slider -->

    
    <?php } ?>

	<?php
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}



// [ux_featured_products]
function ux_featured_products($atts, $content = null) {
	$sliderrandomid = rand();
	extract(shortcode_atts(array(
		"title" => '',
		'products'  => '8',
        'orderby' => 'date',
        'order' => 'desc'
	), $atts));
	ob_start();
	?>
    
    <?php 
	/**
	* Check if WooCommerce is active
	**/
	if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	?>
    
 		<?php slider_script($sliderrandomid)?>

		<?php if($title){?> 
		<div class="row">
			<div class="large-12 columns">
				<h3 class="section-title"><span><?php echo $title ?></span></h3>
			</div>
		</div><!-- end .title -->
		<?php } ?>

		<div class="row column-slider">
            <div id="slider_<?php echo $sliderrandomid ?>" class="iosSlider" style="overflow:hidden;height:100px;min-height:100px;">
                <ul class="slider large-block-grid-4 small-block-grid-2">
					<?php
                    $args = array(
                        'post_status' => 'publish',
                        'post_type' => 'product',
						'ignore_sticky_posts'   => 1,
                        'meta_key' => '_featured',
                        'meta_value' => 'yes',
                        'posts_per_page' => $products,
						'orderby' => $orderby,
						'order' => $order,
                    );
                    
                    $products = new WP_Query( $args );
                    
                    if ( $products->have_posts() ) : ?>
                                
                        <?php while ( $products->have_posts() ) : $products->the_post(); ?>
                    
                            <?php woocommerce_get_template_part( 'content', 'product' ); ?>
                
                        <?php endwhile; // end of the loop. ?>
                        
                    <?php
                    
                    endif; 
                    wp_reset_query();
                    
                    ?>
                </ul>   <!-- .slider -->  
                  <div class="sliderControlls">
			        <div class="sliderNav small hide-for-small">
			       		 <a href="javascript:void(0)" class="nextSlide disabled prev_<?php echo $sliderrandomid ?>"><span class="icon-angle-left"></span></a>
			       		 <a href="javascript:void(0)" class="prevSlide next_<?php echo $sliderrandomid ?>"><span class="icon-angle-right"></span></a>
			        </div>
       			</div><!-- .sliderControlls -->
       		 </div> <!-- .iOsslider -->
       		</div><!-- .row .column-slider -->

    <?php } ?>

	<?php
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}


// [ux_sale_products]
function ux_sale_products($atts, $content = null) {
	$sliderrandomid = rand();
	extract(shortcode_atts(array(
		"title" => '',
		'products'  => '8',
        'orderby' => 'date',
        'order' => 'desc'
	), $atts));
	ob_start();
	?>
    
    <?php 
	/**
	* Check if WooCommerce is active
	**/
	if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	?>
    
	   <?php slider_script($sliderrandomid)?>

		<?php if($title){?> 
		<div class="row">
			<div class="large-12 columns">
				<h3 class="section-title"><span><?php echo $title ?></span></h3>
			</div>
		</div><!-- end .title -->
		<?php } ?>

		<div class="row column-slider">
            <div id="slider_<?php echo $sliderrandomid ?>" class="iosSlider" style="overflow:hidden;height:100px;min-height:100px;">
                <ul class="slider large-block-grid-4 small-block-grid-2">
				 <?php
                    $args = array(
                        'post_type' => 'product',
						'post_status' => 'publish',
						'ignore_sticky_posts'   => 1,
						'posts_per_page' => $products,
						'orderby' => $orderby,
						'order' => $order,
						'meta_query' => array(
							array(
								'key' => '_visibility',
								'value' => array('catalog', 'visible'),
								'compare' => 'IN'
							),
							array(
								'key' => '_sale_price',
								'value' =>  0,
								'compare'   => '>',
								'type'      => 'NUMERIC'
							)
						)
                    );
                    
                    $products = new WP_Query( $args );
                    
                    if ( $products->have_posts() ) : ?>
                                
                        <?php while ( $products->have_posts() ) : $products->the_post(); ?>
                    
                            <?php woocommerce_get_template_part( 'content', 'product' ); ?>
                
                        <?php endwhile; // end of the loop. ?>
                        
                    <?php
                    
                    endif; 
                    wp_reset_query();
                    
                    ?>
                </ul>   <!-- .slider -->  
                  <div class="sliderControlls">
		        <div class="sliderNav small hide-for-small">
		       		 <a href="javascript:void(0)" class="nextSlide disabled prev_<?php echo $sliderrandomid ?>"><span class="icon-angle-left"></span></a>
		       		 <a href="javascript:void(0)" class="prevSlide next_<?php echo $sliderrandomid ?>"><span class="icon-angle-right"></span></a>
		        </div>
       		</div><!-- .sliderControlls -->
       		 </div> <!-- .iOsslider -->
    </div><!-- .row .column-slider -->

    
    <?php } ?>

	<?php
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}


// [ux_latest_products]
function ux_latest_products($atts, $content = null) {
	$sliderrandomid = rand();
	extract(shortcode_atts(array(
		"title" => '',
		'products'  => '8',
        'orderby' => 'date',
        'order' => 'desc'
	), $atts));
	ob_start();
	?>
    
    <?php 
	/**
	* Check if WooCommerce is active
	**/
	if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	?>
    
 	<?php slider_script($sliderrandomid)?>

		<?php if($title){?> 
		<div class="row">
			<div class="large-12 columns">
				<h3 class="section-title"><span><?php echo $title ?></span></h3>
			</div>
		</div><!-- end .title -->
		<?php } ?>

		<div class="row column-slider">
            <div id="slider_<?php echo $sliderrandomid ?>" class="iosSlider" style="overflow:hidden;height:100px;min-height:100px;">
                <ul class="slider large-block-grid-4 small-block-grid-2 ux-latest-products">
				  <?php
            
                    $args = array(
                        'post_type' => 'product',
						'post_status' => 'publish',
						'ignore_sticky_posts'   => 1,
						'posts_per_page' => $products
                    );
                    
                    $products = new WP_Query( $args );
                    
                    if ( $products->have_posts() ) : ?>
                                
                        <?php while ( $products->have_posts() ) : $products->the_post(); ?>
                    
                            <?php woocommerce_get_template_part( 'content', 'product' ); ?>
                
                        <?php endwhile; // end of the loop. ?>
                        
                    <?php
                    
                    endif; 
                    wp_reset_query();
                    
                    ?>
                </ul>   <!-- .slider -->  
                  <div class="sliderControlls">
				        <div class="sliderNav small hide-for-small">
				       		 <a href="javascript:void(0)" class="nextSlide disabled prev_<?php echo $sliderrandomid ?>"><span class="icon-angle-left"></span></a>
				       		 <a href="javascript:void(0)" class="prevSlide next_<?php echo $sliderrandomid ?>"><span class="icon-angle-right"></span></a>
				        </div>
       			   </div><!-- .sliderControlls -->
       		 </div> <!-- .iOsslider -->
    </div><!-- .row .column-slider -->

    
    <?php } ?>

	<?php
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}




add_shortcode("ux_bestseller_products", "ux_best_sellers");
add_shortcode("ux_featured_products", "ux_featured_products");
add_shortcode("ux_sale_products", "ux_sale_products");
add_shortcode("ux_latest_products", "ux_latest_products");



