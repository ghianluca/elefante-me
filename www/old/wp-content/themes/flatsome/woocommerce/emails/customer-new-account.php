<?php
/**
 * Customer new account email
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates/Emails
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<?php do_action( 'woocommerce_email_header', $email_heading ); ?>

<p><?php printf(__("Obrigado por criar uma conta na Madre. Seu login é <strong>%s</strong>.", 'woocommerce'), esc_html( $blogname ), esc_html( $user_login ) ); ?></p>

<p><?php printf(__( 'Você pode conferir sua conta neste link: %s.', 'woocommerce' ), get_permalink(woocommerce_get_page_id('myaccount'))); ?></p>

<?php do_action( 'woocommerce_email_footer' ); ?>