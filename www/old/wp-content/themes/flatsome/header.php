<?php
global $woo_options;
global $woocommerce;
global $flatsome_opt;
?>
<!DOCTYPE html>
<!--[if lte IE 9 ]><html class="ie lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html <?php language_attributes(); ?>> <!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<title><?php wp_title( '|', true, 'right' ); ?></title>

	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<!-- Custom favicon-->
	<link rel="shortcut icon" href="<?php if ($flatsome_opt['site_favicon']) { echo $flatsome_opt['site_favicon']; ?>
	<?php } else { ?><?php echo get_template_directory_uri(); ?>/favicon.png<?php } ?>" />

	<!-- Retina/iOS favicon -->
	<link rel="apple-touch-icon-precomposed" href="<?php if ($flatsome_opt['site_favicon_large']) { echo $flatsome_opt['site_favicon_large']; ?>
	<?php } else { ?><?php echo get_template_directory_uri(); ?>/apple-touch-icon-precomposed.png<?php } ?>" />

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<div id="wrapper">

		<?php do_action( 'before' ); ?>

		<?php if(!isset($flatsome_opt['topbar_show']) || $flatsome_opt['topbar_show']){ ?>
		<div id="top-bar">
			<div class="row">
				<div class="large-12 columns">
					<!-- left text -->
					<div class="left-text left">
						<div class="html"><?php echo $flatsome_opt['topbar_left']; ?></div><!-- .html -->
					</div>
					<!-- right text -->
					<div class="right-text right hide-for-small">
						 <?php if ( has_nav_menu( 'top_bar_nav' ) ) : ?>
						<?php  
								wp_nav_menu(array(
									'theme_location' => 'top_bar_nav',
									'menu_class' => 'top-bar-nav',
									'before' => '',
									'after' => '',
									'link_before' => '',
									'link_after' => '',
									'depth' => 2,
									'fallback_cb' => false,
									'walker' => new FlatsomeNavDropdown
								));
						?>
						 <?php else: ?>
                            Define your top bar navigation in <b>Apperance > Menus</b>
                        <?php endif; ?>
					</div><!-- .pos-text -->

				</div><!-- .large-12 columns -->
			</div><!-- .row -->
		</div><!-- .#top-bar -->
		<?php }?>



		<header id="masthead" class="site-header" role="banner">
			<div class="row"> 
				<div class="large-12 columns header-container">
					<div class="mobile-menu show-for-small"><a href="#open-menu"><span class="icon-menu"></span></a></div><!-- end mobile menu -->
					
					<?php if($flatsome_opt['logo_position'] == 'left') : ?> 
					<div id="logo" class="logo-left">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?> - <?php bloginfo( 'description' ); ?>" rel="home">
							<?php if($flatsome_opt['site_logo']){
								$site_title = esc_attr( get_bloginfo( 'name', 'display' ) );
								echo '<img src="'.$flatsome_opt['site_logo'].'" class="header_logo" alt="'.$site_title.'"/>';
							} else {bloginfo( 'name' );}?>
						</a>
					</div><!-- .logo -->
					<?php endif; ?>

					<div class="left-links">
							<ul id="site-navigation" class="header-nav">
								<?php if ( has_nav_menu( 'primary' ) ) : ?>
								
								<?php if (!isset($flatsome_opt['search_pos']) || $flatsome_opt['search_pos'] == 'left') { ?>
								<li class="search-dropdown">
									<a href="#" class="nav-top-link icon-search"></a>
									<div class="nav-dropdown">
										<?php get_search_form( ); ?>		
									</div><!-- .nav-dropdown -->
								</li><!-- .search-dropdown -->
								<?php } ?>

									<?php  
									wp_nav_menu(array(
										'theme_location' => 'primary',
										'container'       => false,
										'items_wrap'      => '%3$s',
										'depth'           => 3,
										'walker'          => new FlatsomeNavDropdown
									));
								?>

								<?php if (isset($flatsome_opt['search_pos']) && $flatsome_opt['search_pos'] == 'right') { ?>
								<li class="search-dropdown">
									<a href="#" class="nav-top-link icon-search"></a>
									<div class="nav-dropdown">
										<?php get_search_form( ); ?>		
									</div><!-- .nav-dropdown -->
								</li><!-- .search-dropdown -->
								<?php } ?>

		                        <?php else: ?>
		                            <li>Define your main navigation in <b>Apperance > Menus</b></li>
		                        <?php endif; ?>								
							</ul>
					</div><!-- .left-links -->

					<?php if($flatsome_opt['logo_position'] == 'center') { ?> 
					<div id="logo">
						<h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?> - <?php bloginfo( 'description' ); ?>" rel="home">
							<?php if($flatsome_opt['site_logo']){
								echo '<img src="'.$flatsome_opt['site_logo'].'" class="header_logo"/>';
							} else {bloginfo( 'name' );}?>
						</a></h1>
					</div><!-- .logo -->
					<?php } ?>

					<div class="right-links">
						<?php if(!$flatsome_opt['catalog_mode']) { ?> 
						<ul class="header-nav">
							<?php if(!isset($flatsome_opt['myaccount_dropdown']) || $flatsome_opt['myaccount_dropdown']) { ?>
							<li class="account-dropdown hide-for-small">
								<?php
								if ( is_user_logged_in() ) { ?> 
								<a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" class="nav-top-link">
									Minha conta
								</a>
								<div class="nav-dropdown">
									<ul>
									<?php if ( has_nav_menu( 'my_account' ) ) : ?>
									<?php  
									wp_nav_menu(array(
										'theme_location' => 'my_account',
										'container'       => false,
										'items_wrap'      => '%3$s',
										'depth'           => 0,
									));
									?>
			                        <?php else: ?>
			                            <li>Define your My Account dropdown menu in <b>Apperance > Menus</b></li>
			                        <?php endif; ?>	
									</ul>
								</div><!-- end account dropdown -->
								
							<?php } else { ?>
							<a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" class="nav-top-link"><?php _e('Login', 'woocommerce'); ?></a>
							<?php
						}
						?>						
						</li>
					<?php } ?>
		

					<!-- Show mini cart if Woocommerce is activated -->
					<?php if(in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) { ?> 
					<li class="mini-cart">
						<div class="cart-inner">
							<?php // Edit this content in inc/template-tags.php. Its gets relpaced with Ajax! ?>
							<a href="<?php echo esc_url( $woocommerce->cart->get_cart_url() ); ?>" class="cart-link">
								<strong class="cart-name hide-for-small">Carrinho</strong> 
								<span class="cart-price hide-for-small">/ <?php echo $woocommerce->cart->get_cart_total(); ?></span> 
									<!-- cart icon -->
									<div class="cart-icon">
				                        <?php if ($flatsome_opt['custom_cart_icon']){ ?> 
				                        <div class="custom-cart-inner">
					                        <div class="custom-cart-count"><?php echo $woocommerce->cart->cart_contents_count; ?></div>
					                        <img class="custom-cart-icon" src="<?php echo $flatsome_opt['custom_cart_icon']?>"/> 
				                        </div><!-- .custom-cart-inner -->
				                        <?php } else { ?> 
				                         <strong><?php echo $woocommerce->cart->cart_contents_count; ?></strong>
				                         <span class="cart-icon-handle"></span>
				                        <?php }?>
									</div><!-- end cart icon -->
							</a>
							<div class="nav-dropdown">
							  	<div class="nav-dropdown-inner">
								<!-- Add a spinner before cart ajax content is loaded -->
									<?php if ($woocommerce->cart->cart_contents_count == 0) {
										echo '<p class="empty">'.__('No products in the cart.','woocommerce').'</p>';
										?> 
									<?php } else { //add a spinner ?> 
										<div class="loading"><i></i><i></i><i></i><i></i></div>
									<?php } ?>
									</div><!-- nav-dropdown-innner -->
							</div><!-- .nav-dropdown -->
						</div><!-- .cart-inner -->
					</li><!-- .mini-cart -->
					<?php } else {echo '<li>WooCommerce not installed!</li>';} ?>
				</ul><!-- .header-nav -->
				<?php } else { ?>
				<div class="catalog-mode-header">
					<?php echo do_shortcode($flatsome_opt['catalog_mode_header']); ?>
				</div>
				<?php } ?>

			</div><!-- .right-links -->
		</div><!-- .large-12 -->
	</div><!-- .row -->
</header><!-- .header -->

<?php if(isset($flatsome_opt['html_after_header'])){
	// AFTER HEADER HTML BLOCK
	echo do_shortcode($flatsome_opt['html_after_header']);
} ?>

<div id="main-content" class="site-main">
<?php 
//adds a border line if header is white
if (strpos($flatsome_opt['header_bg'],'#fff') !== false) {
		  echo '<div class="row"><div class="large-12 columns"><div class="top-divider"></div></div></div>';
} ?>

<?php if(in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) { ?> 
	<!-- woocommerce message -->
	<?php  woocommerce_show_messages(); ?>
<?php } ?>	