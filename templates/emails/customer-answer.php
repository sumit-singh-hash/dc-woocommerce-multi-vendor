<?php
/**
 * The template for displaying demo plugin content.
 *
 * Override this template by copying it to yourtheme/dc-product-vendor/emails/customer-answer.php
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
$answer = isset( $answer ) ? $answer : '';
$product_id = isset( $product_id ) ? $product_id : '';
$product = wc_get_product($product_id);
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>
<p style="text-align:<?php echo $text_align; ?>;" ><?php printf(__( 'here is your answer :- ', 'dc-woocommerce-multi-vendor' )); ?>
    <?php printf(__( '<a href="' . esc_url($product->get_permalink()) . '">'.$answer.'</a>', 'dc-woocommerce-multi-vendor' )); ?>
</p>


<?php do_action( 'wcmp_email_footer' ); ?>


