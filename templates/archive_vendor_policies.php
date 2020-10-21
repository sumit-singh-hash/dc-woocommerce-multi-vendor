<?php
/**
 * The template for displaying archive vendor info
 *
 * Override this template by copying it to yourtheme/dc-product-vendor/archive_vendor_policies.php
 *
 * @author      WC Marketplace
 * @package     WCMp/Templates
 * @version   2.2.0
 */
global $WCMp;

$content .= '<div class="wcmp-product-policies">';
if(isset($policies['shipping_policy']) && !empty($policies['shipping_policy'])) {
    $content .='<div class="wcmp-shipping-policies policy">
        <h2 class="wcmp_policies_heading heading">'.__('Shipping Policy', 'dc-woocommerce-multi-vendor').'</h2>
        <div class="wcmp_policies_description description" >'.$policies['shipping_policy'].'</div>
    </div>';
} 
if(isset($policies['refund_policy']) && !empty($policies['refund_policy'])){ 
    $content .='<div class="wcmp-refund-policies policy">
        <h2 class="wcmp_policies_heading heading heading">'.__('Refund Policy', 'dc-woocommerce-multi-vendor').'</h2>
        <div class="wcmp_policies_description description">'.$policies['refund_policy'].'</div>
    </div>';
} 
if(isset($policies['cancellation_policy']) && !empty($policies['cancellation_policy'])){ 
    $content .='<div class="wcmp-cancellation-policies policy">
        <h2 class="wcmp_policies_heading heading">'.__('Cancellation / Return / Exchange Policy', 'dc-woocommerce-multi-vendor').'</h2>
        <div class="wcmp_policies_description description" >'.$policies['cancellation_policy'].'</div>
    </div>';
}
$content .='</div>';
echo $content;