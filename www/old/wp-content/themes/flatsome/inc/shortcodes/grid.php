<?php 
// [row]
function rowShortcode($params = array(), $content = null) {
	$content = do_shortcode($content);
	$container = '<div class="row container">'.$content.'</div>';
	return $container;
} 

// [ux_banner_grid]
function bannergridShortCode($params = array(), $content = null) {
	$content = do_shortcode($content);
	$container = '<div class="row"><div class="large-12 columns"><div class="row collapse ux_banner-grid">'.$content.'</div></div></div>
	<script>
	/* Start PACKERY grid */
	jQuery(document).ready(function ($) {
	    var $container = $(".ux_banner-grid");
	    $container.packery({
	      itemSelector: ".columns",
	      gutter: 0
	    });
	 });
	</script>';
	return $container;
} 

// [col]
function colShortcode($atts, $content = null) {	
	extract( shortcode_atts( array(
    'span' => '3',
  	), $atts ) );

  	switch ($span) {
    case "1/4":
        $span = '3'; break;
    case "2/4":
         $span ='6'; break;
    case "3/4":
        $span = '9'; break;
    case "1/3":
        $span = '4'; break;
    case "2/3":
         $span = '8'; break;
    case "1/2":
        $span = '6'; break;
    case "1/6":
        $span = '2'; break;
    case "2/6":
         $span = '4'; break;
    case "3/6":
        $span = '6'; break;
    case "4/6":
        $span = '8'; break;
    case "5/6":
        $span = '10'; break;
	}

  	

	$content = do_shortcode($content);
	$column = '<div class="large-'.$span.' columns">'.$content.'</div>';
	return $column;
}

add_shortcode('ux_banner_grid', 'bannergridShortcode');
add_shortcode('col', 'colShortcode');
add_shortcode('row', 'rowShortcode');