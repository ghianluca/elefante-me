<?php
// [share]

function shareShortcode($atts, $content = null) {
	extract(shortcode_atts(array(
		'title'  => '',
	), $atts));
	global $post;

	$permalink = get_permalink($post->ID);
	$featured_image =  wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail');
	$featured_image_2 = $featured_image['0'];
	$post_title = rawurlencode(get_the_title($post->ID)); 

// no código abaixo eu comentei pra sumir, mas é só tirar que volta as configurações originais do share de redes
/*	if($title) $title = '<span>'.$title.'</span>';
*	$container = '
*	<div class="social-icons share-row">
*			'.$title.'
*      	  	<a href="http://www.facebook.com/sharer.php?u='.$permalink.'&amp;images='.$featured_image_2.'" target="_blank" class="icon facebook tip-top" data-tip="Share on Facebook"><span class="icon-facebook"></span> </a>
*            <a href="https://twitter.com/share?url='.$permalink.'" target="_blank" class="icon twitter tip-top" data-tip="Share on Twitter"><span class="icon-twitter"></span> </a>
*            <a href="mailto:enteryour@addresshere.com?subject='.$post_title.'&amp;body=Check%20this%20out:%20'.$permalink.'" class="icon email tip-top" data-tip="Email to a Friend"><span class="icon-envelop"></span> </a>
*            <a href="//pinterest.com/pin/create/button/?url='.$permalink.'&amp;media='.$featured_image_2.'&amp;description='.$post_title.'" target="_blank" class="icon pintrest tip-top" data-tip="Pin on Pinterest"><span class="icon-pinterest"></span></a>
*       </div>
*	';
*	return $container;
*/

} 


add_shortcode('share','shareShortcode');


// [follow]

function followShortcode($atts, $content = null) {
	$sliderrandomid = rand();
	extract(shortcode_atts(array(
		"title" => '',
		'twitter' => '',
		'facebook' => '',
		'pinterest' => '',
		'email' => '',
	), $atts));
	ob_start();
	?>

    <div class="social-icons">

    	<?php if($title){?> 
    	<span><?php echo $title; ?></span>
		<?php }?>

    	<?php if($facebook){?> 
    	<a href="<?php echo $facebook; ?>" target="_blank"  class="icon facebook tip-top" data-tip="Facebook da Madre!"><span class="icon-facebook"></span></a>
		<?php }?>
		<?php if($twitter){?> 
		       <a href="<?php echo $twitter; ?>" target="_blank" class="icon twitter tip-top" data-tip="Twitter da Madre!"><span class="icon-twitter"></span></a>
		<?php }?>
		<?php if($email){?> 
		       <a href="mailto:<?php echo $email; ?>" target="_blank" class="icon email tip-top" data-tip="Nos mande um e-mail!"><span class="icon-envelop"></span></a>
		<?php }?>
		<?php if($pinterest){?> 
		       <a href="<?php echo $pinterest; ?>" target="_blank" class="icon pintrest tip-top" data-tip="Pinterest da Madre!"><span class="icon-pinterest"></span></a>
		<?php }?>
     </div>
    	

	<?php
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}


add_shortcode("follow", "followShortcode");



?>
