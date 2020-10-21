<?php
/**
 * The template for displaying demo plugin content.
 *
 * Override this template by copying it to yourtheme/dc-product-vendor/emails/vendor-followed.php
 *
 * @author 		WC Marketplace
 * @package 	dc-product-vendor/Templates
 * @version   0.0.1
 */
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly 
global $WCMp;
if($post->post_type == 'product') {
    ?>
    <p><?php printf(esc_html__('A new product is created:', 'dc-woocommerce-multi-vendor')); ?></p>
    <?php
} else {
    ?>
    <p><?php printf(esc_html__('A new coupon is created:', 'dc-woocommerce-multi-vendor')); ?></p>
    <?php
}
do_action( 'woocommerce_email_header', $email_heading, $email );
$text_align = is_rtl() ? 'right' : 'left';
?>

<?php do_action('wcmp_email_footer'); ?>