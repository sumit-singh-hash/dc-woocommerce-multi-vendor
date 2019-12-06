<?php
/**
 * The template for displaying demo plugin content.
 *
 * Override this template by copying it to yourtheme/dc-product-vendor/emails/plain/vendor-new-announcement.php
 *
 * @author 		WC Marketplace
 * @package 	dc-product-vendor/Templates
 * @version   0.0.1
 */
 
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $WCMp;
$vendor = get_wcmp_vendor( absint( $vendor_id ) );
echo $email_heading . "\n\n";

echo sprintf( __('A new announcement is added by admin. Their details is as follows:', 'dc-woocommerce-multi-vendor') ) . "\n\n";

echo "****************************************************\n\n";

echo sprintf( __( 'Announcement title : %s',  'dc-woocommerce-multi-vendor'), $post_title ) . "\n";
printf( __( "View the announcement: %s",  'dc-woocommerce-multi-vendor' ), esc_url(wcmp_get_vendor_dashboard_endpoint_url(get_wcmp_vendor_settings('wcmp_vendor_announcements_endpoint', 'vendor', 'general', 'vendor-announcements'))));

echo "\n****************************************************\n\n";

echo apply_filters( 'wcmp_email_footer_text', get_option( 'wcmp_email_footer_text' ) );