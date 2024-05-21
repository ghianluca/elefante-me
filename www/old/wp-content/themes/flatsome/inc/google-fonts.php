<?php
if(isset($flatsome_opt['type_headings'])){
$customfont = '';
$default = array(
					'arial',
					'verdana',
					'trebuchet',
					'georgia',
					'times',
					'tahoma',
					'helvetica'
				);

$googlefonts = array(
					$flatsome_opt['type_headings'],
					$flatsome_opt['type_texts'],
					$flatsome_opt['type_nav'],
					$flatsome_opt['type_alt']
				);
			
foreach($googlefonts as $googlefont) {
	if(!in_array($googlefont, $default)) {
			$customfont = str_replace(' ', '+', $googlefont). ':300,300italic,400,400italic,700,700italic,900,900italic|' . $customfont;
	}
}	

if ($customfont != "") {	
	function google_fonts() {	
		global $customfont;		
		$protocol = is_ssl() ? 'https' : 'http';
			wp_enqueue_style( 'flatsome-googlefonts', "$protocol://fonts.googleapis.com/css?family=". substr_replace($customfont ,"",-1));}
			add_action( 'wp_enqueue_scripts', 'google_fonts' );
	
}

}

?>
