<?php
/**
 *	The template for displaying about section in front page.
 *
 *	@package WordPress
 *	@subpackage illdy
 */
?>
<?php
$general_title = get_theme_mod( 'illdy_about_general_title', esc_html__( 'About', 'illdy' ) );
$general_entry = get_theme_mod( 'illdy_about_general_entry', esc_html__( 'It is an amazng one-page theme with great features that offers an incredible experience. It is easy to install, make changes, adapt for your business. A modern design with clean lines and styling for a wide variety of content, exactly how a business design should be. You can add as many images as you want to the main header area and turn them into slider.', 'illdy' ) );
?>
<section id="about" class="front-page-section" style="<?php if( !$general_title && !$general_entry ): echo 'padding-top: 130px;'; endif; ?>">
	<?php if( $general_title || $general_entry ): ?>
		<div class="section-header">
			<div class="container">
				<div class="row">
					<?php if( $general_title ): ?>
						<div class="col-sm-12">
							<h3><?php echo esc_html( $general_title ); ?></h3>
						</div><!--/.col-sm-12-->
					<?php endif; ?>
											<div class="col-sm-12">
							<div class="col-sm-4"><h1>A Petbox chega ao mercado PET com a proposta de trazer produtos confeccionados à base de papelão reciclável e materiais ecologicamente corretos.</h1></div>
							<div class="col-sm-4"><p>Com o legado e experiência de quase uma década no mercado de embalagens da empresa-irmã Ebenezer Embalagens, a PetBox traz todo o know-how necessário para a fabricação de produtos de qualidade para o seu PET. <br> <br> Pensando no conforto e na segurança do PET, bem como na tranquilidade do seu dono, todos os produtos desenvolvidos pela PetBox foram desenhados e produzidos por amantes de PETs conhecedores do cuidado, conforto e diversão que eles merecem. Nós somos apaixonados por bichos!</p></div>
							<div class="col-sm-4"><p>Todos os produtos da PetBox têm como matéria prima o papelão, material reciclável e biodegradável. <br> <br> O papelão leva em torno de 6 meses para se decompor. <br><br>Seja um consumidor consciente, colabore com a coleta seletiva!</p><div align="center"><img src="wp-content/uploads/2016/03/eco_friendly_petbox.png" alt="Eco Friendly" title="Eco Friendly" style="margin:30px 0;"></div>

						</div>
					<?php endif; ?>
				</div><!--/.row-->
			</div><!--/.container-->
		</div><!--/.section-header-->	
</section><!--/#about.front-page-section-->