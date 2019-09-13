<?php

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

if (!class_exists('WC_Email_Customer_Answer')) :

    /**
     * Customer Answer Email
     *
     * An email sent to the admin  and customer when a vendor post answer.
     *
     * @class 		WC_Email_Customer_Answer
     * @version		2.0.0
     * @package		WooCommerce/Classes/Emails
     * @author 		WooThemes
     * @extends 	WC_Email
     */
    class WC_Email_Customer_Answer extends WC_Email {
        /**
         * Constructor
         */
        function __construct() {
            global $WCMp;
            $this->id = 'customer_answer';
            $this->title = __('Customer Answer', 'dc-woocommerce-multi-vendor');
            $this->description = __('Answer notification emails are sent when vendor reply a question.', 'dc-woocommerce-multi-vendor');

            $this->heading = __('customer Answer', 'dc-woocommerce-multi-vendor');
            $this->subject = __('[{site_title}] customer Answer', 'dc-woocommerce-multi-vendor');

            $this->template_html = 'emails/customer-answer.php';
            $this->template_plain = 'emails/plain/customer-answer.php';
            $this->template_base = $WCMp->plugin_path . 'templates/';

            // Call parent constructor
            parent::__construct();
        }

        /**
         * Get email subject.
         *
         * @since  3.1.0
         * @return string
         */
        function trigger( $customer, $answer, $product_id ) {
        $this->answer = $answer;
        $this->product_id = $product_id;
        if($customer && !isset($customer->user_email)) return;
        $this->recipient = $customer->user_email;
        
        $this->customer = $customer;
        if ( ! $this->is_enabled() || ! $this->get_recipient() ) return;

        $this->find[ ]      = '{site_title}';
        $this->replace[ ]   = $this->get_blogname();

        $this->find[ ]      = '{STORE_NAME}';
        $this->replace[ ]   = $vendor->page_title;
        
        return $this->send( $this->get_recipient(), $this->get_subject(), $this->get_content(), $this->get_headers(), $this->get_attachments() );
    }
    
    /**
     * Get email subject.
     *
     * @access  public
     * @return string
     */
    public function get_default_subject() {
        $subject = __( '[{site_title}] **Answer**', 'dc-woocommerce-multi-vendor');
        if( isset($this->object['subject']) && !empty($this->object['subject']) ){
            $subject = $subject . ' - ' . $this->object['subject'];
        }
        return apply_filters( 'wcmp_vendor_customer_answer_email_subject', $subject, $this->object );
    }

    /**
     * Get email heading.
     *
     * @access  public
     * @return string
     */
    public function get_default_heading() {
        return apply_filters( 'wcmp_vendor_customer_answer_email_heading', __( "Answer", 'dc-woocommerce-multi-vendor'), $this->object );
    }
    
    /**
     * Get email headers.
     *
     * @return string
     */
    public function get_headers() {
        $header = 'Content-Type: ' . $this->get_content_type() . "\r\n";
        if( apply_filters( 'wcmp_vendor_customer_answer_email_goes_to_admin', true, $this->object ) ) {
            $header .= 'Cc: Admin <' . get_option('admin_email') . '>'."\r\n";
        }

        return apply_filters( 'wcmp_vendor_customer_answer_email_headers', $header, $this->id, $this->object );
    }
    
    /**
    * Get WordPress blog name.
    *
    * @return string
    */
    public function get_blogname() {
           return wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
    }

    /**
     * get_content_html function.
     *
     * @access public
     * @return string
     */
    function get_content_html() {
        ob_start();
        wc_get_template( $this->template_html, array(
            'customer'      => $this->customer,
            'email_heading' => $this->get_heading(),
            'answer'        => $this->answer,
            'product_id'    => $this->product_id,
            'plain_text'    => false,
            'email'         => $this,
            ), 'dc-product-vendor/', $this->template_base);
        return ob_get_clean();
    }

    /**
     * get_content_plain function.
     *
     * @access public
     * @return string
     */
    function get_content_plain() {
        ob_start();
        wc_get_template( $this->template_plain, array(
            'customer'      => $this->customer,
            'email_heading' => $this->get_heading(),
            'answer'        => $this->answer,
            'product_id'    => $this->product_id,
            'plain_text'    => true,
            'email'         => $this,
            ), 'dc-product-vendor/', $this->template_base);
        return ob_get_clean();
    }

    }
  
    endif;
