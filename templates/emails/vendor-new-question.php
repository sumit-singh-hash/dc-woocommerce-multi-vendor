<?php
/**
 * The template for displaying demo plugin content.
 *
 * Override this template by copying it to yourtheme/dc-product-vendor/emails/vendor-new-question.php
 *
 * @author 		WC Marketplace
 * @package 	dc-product-vendor/Templates
 * @version   0.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
global $WCMp;
$text_align = is_rtl() ? 'right' : 'left';
$question = isset( $question ) ? $question : '';
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>
<p style="text-align:<?php echo $text_align; ?>;" ><?php printf(__( 'You got a question :- ', 'dc-woocommerce-multi-vendor' )); ?>
    <?php printf(__( '<a class="link" href="' . esc_url( wcmp_get_vendor_dashboard_endpoint_url(get_wcmp_vendor_settings('wcmp_vendor_products_qnas_endpoint', 'vendor', 'general', 'products-qna')) ) . '">'.$question.'</a>', 'dc-woocommerce-multi-vendor' )); ?>
</p>


<?php do_action( 'wcmp_email_footer' ); ?>


