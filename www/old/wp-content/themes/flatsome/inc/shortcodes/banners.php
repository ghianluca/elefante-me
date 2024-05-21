<?php
// [ux_banner]
function uxbannerShortcode( $atts, $content = null ){
  $bannerid = rand();
  extract( shortcode_atts( array(
    'text_pos' => 'center',
    'height' => '300px',
    'text_color' => 'light',
    'link' => '',
    'text_width' => '60%',
    'text_align' => 'center',
    'animation' => 'fadeIn',
    'hover' => '',
    'bg' => '', // Set default value
    'parallax' => ''
  ), $atts ) );

  // replace ___ (3 underscores) with a nice divider
  $fix = array (
                '&nbsp;' => '', 
                '<p></p>' => '', 
                '<p>[' => '[', 
                ']</p>' => ']', 
                ']<br />' => ']',
                '_____' => '<div class="tx-div large"></div>',
                '____' => '<div class="tx-div medium"></div>',
                '___' => '<div class="tx-div small"></div>',
  );
   $content = strtr($content, $fix);

   $content = do_shortcode( $content ); 

   $img_link = get_template_directory_uri().'/img/';

   $color = "light";
   if($text_color == 'light') $color = "dark";

   if($hover) $hover = 'hover_'.$hover;

   $animated = "";
   if($animation != "none") $animated = "animated";

   $start_link = "";
   $end_link = "";
   if($link) {$start_link = '<a href="'.$link.'">'; $end_link = '</a>';};

   $background = "";
   $background_color = "";
    if (strpos($bg,'http://') !== false) {
      $background = $bg;
    }
    elseif (strpos($bg,'#') !== false) {
      $background_color = 'background-color:'.$bg.'!important';
    }
     else {
      $bg = wp_get_attachment_image_src($bg, 'large');
      $background = $bg[0];
    }



   $textalign = "";
   if($text_align) {$textalign = "text-".$text_align;}
    
  $parallax_class = '';
  if($parallax){$parallax_class = 'ux_parallax'; $parallax='data-velocity="0.'.$parallax.'"';} 
 
   $banner ='
   <div id="banner_'.$bannerid.'" class="ux_banner '.$color.' '.$hover.'"  style="height:'.$height.'" data-height="'.$height.'" role="banner">
      '.$start_link.' 
        <div class="row">
          <div class="inner '.$text_pos.'   '.$animated.' '.$textalign.'" data-animate="'.$animation.'" style="width:'.$text_width.'">
           '.$content.'
          </div>  
         </div>
        <div class="banner-bg '.$parallax_class.'" '.$parallax.' style="background-image:url('.$background.');' .$background_color.'"></div>
       '.$end_link.' 
   </div>
';

return $banner;
 
}
add_shortcode('ux_banner', 'uxbannerShortcode');
