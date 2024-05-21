<?php
/**
 * Product Loop Start
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

global $flatsome_opt;

?>
<div class="row"><div class="large-12 columns">

<?php if($flatsome_opt['category_sidebar'] == 'right-sidebar' AND is_archive())  { ?>
       	<ul class="products small-block-grid-2 large-block-grid-3">
<?php } else if ($flatsome_opt['category_sidebar'] == 'left-sidebar' AND  is_archive()) { ?>
		<ul class="products small-block-grid-2 large-block-grid-3">
<?php } else { ?>
		<ul class="products small-block-grid-2 large-block-grid-4">
<?php } ?>


