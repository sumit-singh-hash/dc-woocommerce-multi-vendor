<?php
/**
 * The template for displaying demo plugin content.
 *
 * Override this template by copying it to yourtheme/dc-product-vendor/emails/vendor-new-announcement.php
 *
 * @author 		WC Marketplace
 * @package 	dc-product-vendor/Templates
 * @version   0.0.1
 */
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly 
global $WCMp;
$vendor = get_wcmp_vendor(absint($vendor_id));
do_action( 'woocommerce_email_header', $email_heading, $email );
$text_align = is_rtl() ? 'right' : 'left';
?>

<p><?php printf(__('A new announcement is added by admin. Their details is as follows:', 'dc-woocommerce-multi-vendor')); ?></p>


<?php do_action('woocommerce_email_before_order_table', true, false); ?>

<p><?php printf(__('Announcement title : ', 'dc-woocommerce-multi-vendor') ); ?><?php echo $post_title; ?></p>
<p><?php printf( __( "View the announcement: %s",  'dc-woocommerce-multi-vendor' ), esc_url(wcmp_get_vendor_dashboard_endpoint_url(get_wcmp_vendor_settings('wcmp_vendor_announcements_endpoint', 'vendor', 'general', 'vendor-announcements')))); ?></p>

<?php do_action('wcmp_email_footer'); ?>
