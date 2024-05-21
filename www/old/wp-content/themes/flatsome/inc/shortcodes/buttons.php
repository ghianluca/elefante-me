<?php
// [button]
function button_shortcode( $atts, $content = null ){
  extract( shortcode_atts( array(
    'text' => '',
    'style' => '',
    'size' => '',
    'link' => '',
  ), $atts ) );


return '<a href="'.$link.'" class="button '.$size.' '.$style.'">'.$text.'</a>';

}
add_shortcode('button', 'button_shortcode');


