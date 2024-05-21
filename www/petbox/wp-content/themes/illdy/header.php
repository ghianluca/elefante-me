<?php
/**
 *	The template for displaying the header.
 *
 *	@package WordPress
 *	@subpackage illdy
 */
?>
<?php
$img_logo = get_theme_mod( 'illdy_img_logo', esc_url( get_template_directory_uri() . '/layout/images/header-logo.png' ) );
$text_logo = get_theme_mod( 'illdy_text_logo', esc_html__('Illdy', 'illdy') );
$jumbotron_general_image = get_theme_mod( 'illdy_jumbotron_general_image', esc_url( get_template_directory_uri() . '/layout/images/front-page/front-page-header.png' ) );
$preloader_enable = get_theme_mod( 'illdy_preloader_enable', 1 );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<link rel="icon" href="favicon_petbox.ico" type="image/x-icon" />
		<link rel="shortcut icon" href="favicon_petbox.ico" type="image/x-icon" />
		<script src="wp-content/themes/illdy/3d/viewer/three.js"></script>
  		<script src="wp-content/themes/illdy/3d/viewer/Detector.js"></script>
		<?php wp_head(); ?>
	</head>
	<body data-viewport <?php body_class(); ?>>
		<?php if( $preloader_enable == 1 ): ?>
			<div class="pace-overlay"></div>
		<?php endif; ?>
		<header id="header" class="<?php if( is_front_page() ): echo 'header-front-page'; else: echo 'header-blog'; endif; ?>" style="overflow-x:hidden;background-image: url('<?php if( is_front_page() ): echo ( ( $jumbotron_general_image ) ? esc_url( $jumbotron_general_image ) : '' ); else: echo esc_url( get_header_image() ); endif; ?>');">
			<div class="top-header">
				<div class="container">
					<div class="row">
						<div class="col-sm-2">
							<?php if( $img_logo ): ?>
								<a href="<?php echo esc_url( home_url() ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" class="header-logo"><img src="<?php echo esc_url( $img_logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" /></a>
							<?php else: ?>
								<a href="<?php echo esc_url( home_url() ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" class="header-logo"><?php echo esc_html( $text_logo ); ?></a>
							<?php endif; ?>
						</div><!--/.col-sm-2-->
						<div class="col-sm-10">
							<nav class="header-navigation">
								<ul class="clearfix">
									<?php
									wp_nav_menu( array(
										'theme_location'	=> 'primary-menu',
										'menu'				=> '',
										'container'			=> '',
										'container_class'	=> '',
										'container_id'		=> '',
										'menu_class'		=> '',
										'menu_id'			=> '', 
										'items_wrap'		=> '%3$s',
										'walker'			=> new MTL_Extended_Menu_Walker(),
										'fallback_cb'		=> 'MTL_Extended_Menu_Walker::fallback'
									) );
									?>
								</ul><!--/.clearfix-->
							</nav><!--/.header-navigation-->
							<button class="open-responsive-menu"><i class="fa fa-bars"></i></button>
						</div><!--/.col-sm-10-->
						</div><!--/.row-->
										</div><!--/.container-->
										
			</div><!--/.top-header-->
			<nav class="responsive-menu">
				<ul>
					<?php
					wp_nav_menu( array(
						'theme_location'	=> 'primary-menu',
						'menu'				=> '',
						'container'			=> '',
						'container_class'	=> '',
						'container_id'		=> '',
						'menu_class'		=> '',
						'menu_id'			=> '', 
						'items_wrap'		=> '%3$s',
						'walker'			=> new MTL_Extended_Menu_Walker(),
						'fallback_cb'		=> 'MTL_Extended_Menu_Walker::fallback'
					) );
					?>
				</ul>
			</nav><!--/.responsive-menu-->
			<!--<?php
			if( is_front_page() ):
				get_template_part( 'sections/front-page', 'bottom-header' );
			else:
				get_template_part( 'sections/blog', 'bottom-header' );
			endif;
			?>
			<!--<div align="center"><iframe src="https://p3d.in/e/OOwjJ" width="640" height="480" frameborder="0" seamless allowfullscreen webkitallowfullscreen></iframe></div>!-->
			<!--<div id="3doverlay" class="3dmap"><iframe id="3dmap" src="http://elefante.me/www/model2/model2.html" frameborder="0" width="100%" height="600" style="border:none;" scrolling="no"></iframe></div>!-->
			<script>  
    var container, scene, renderer, camera, light, clock, loader;
	var WIDTH, HEIGHT, VIEW_ANGLE, ASPECT, NEAR, FAR, TOP_HEADER_HEIGHT;
	var mouseX = 0, mouseY = 0;
	var windowHalfX = window.innerWidth / 2;
	var windowHalfY = window.innerHeight / 2;
	container = document.querySelector('#header')
	clock = new THREE.Clock();
	TOP_HEADER_HEIGHT = document.querySelector('.top-header').offsetHeight;
	WIDTH = window.innerWidth,
	HEIGHT = window.innerHeight - TOP_HEADER_HEIGHT;
	VIEW_ANGLE = 45,
	ASPECT = WIDTH / HEIGHT,
	NEAR = 1,
	FAR = 10000;

    scene = new THREE.Scene();

    renderer = new THREE.WebGLRenderer({antialias: true});

    renderer.setSize(WIDTH, HEIGHT);
    renderer.setClearColor( 0xa26353, 1);

    container.appendChild(renderer.domElement);

	/**camera = new THREE.PerspectiveCamera( 45, window.innerWidth / window.innerHeight, 1, 2000 );*/
    camera = new THREE.PerspectiveCamera(VIEW_ANGLE, ASPECT, NEAR, FAR);

	camera.position.z=0;
	camera.position.y=60;
	camera.position.x=60;
   /** camera.position.set(50, 50, 100); */



    scene.add(camera);

      light = new THREE.AmbientLight(0xede8c1, 0.65);

    scene.add(light);

      light = new THREE.DirectionalLight(0xd3ba8e, 0.5);
    light.position.set(0, -100, -60);

    scene.add(light);

     light = new THREE.DirectionalLight(0xd3ba8e, 0.5);

    light.position.set(0, 100, 60);

    scene.add(light);

    loader = new THREE.JSONLoader();
    var mesh;
    loader.load('wp-content/themes/illdy/3d/caixa-petbox.js', function (geometry, materials) {
      var material = new THREE.MeshLambertMaterial({
        map: THREE.ImageUtils.loadTexture('wp-content/themes/illdy/3d/petboxtextura.png'), 
      });

      mesh = new THREE.Mesh(
        geometry,
        material
      );

      mesh.rotation.y = -Math.PI/12;

      scene.add(mesh);
      render(); 
    });

    function render() {
     var time = clock.getElapsedTime();
     mesh.rotation.y += .002;
     mesh.rotation.x += .002;
     mesh.rotation.z += .002;

      
  camera.lookAt(scene.position);
  renderer.render(scene, camera);

     requestAnimationFrame(render);
    }
</script>
		</header><!--/#header-->