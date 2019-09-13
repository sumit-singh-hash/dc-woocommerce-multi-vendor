<?php
/**
 * The template for displaying demo plugin content.
 *
 * Override this template by copying it to yourtheme/dc-product-vendor/emails/plain/vendor-new-question.php
 *
 * @author 		WC Marketplace
 * @package 	dc-product-vendor/Templates
 * @version   0.0.1
 */
 
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $WCMp;
$question = isset( $question ) ? $question : '';
echo $email_heading . "\n\n"; 
echo __( 'You got a question', 'dc-woocommerce-multi-vendor' ).' : <a class="link" href="' . esc_url( wcmp_get_vendor_dashboard_endpoint_url(get_wcmp_vendor_settings('wcmp_vendor_products_qnas_endpoint', 'vendor', 'general', 'products-qna')) ) . '">'.$question.'</a>'; 

echo apply_filters( 'wcmp_email_footer_text', get_option( 'wcmp_email_footer_text' ) );