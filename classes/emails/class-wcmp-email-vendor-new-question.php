<?php

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

if (!class_exists('WC_Email_Vendor_New_Question')) :

    /**
     * Vendor New Question Mail
     *
     * An email sent to vendor when a customer ask a Question.
     *
     * @class 		WC_Email_Vendor_New_Question
     * @version		2.0.0
     * @package		WooCommerce/Classes/Emails
     * @author 		WooThemes
     * @extends 	WC_Email
     */
    class WC_Email_Vendor_New_Question extends WC_Email {
        /**
         * Constructor
         */
        function __construct() {
            global $WCMp;
            $this->id = 'vendor_new_question';
            $this->title = __('Vendor New question', 'dc-woocommerce-multi-vendor');
            $this->description = __('New question notification emails are sent when customer ask a question.', 'dc-woocommerce-multi-vendor');

            $this->heading = __('Vendor New Question', 'dc-woocommerce-multi-vendor');
            $this->subject = __('[{site_title}] Vendor New Question', 'dc-woocommerce-multi-vendor');

            $this->template_html = 'emails/vendor-new-question.php';
            $this->template_plain = 'emails/plain/vendor-new-question.php';
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
        function trigger( $vendor, $cust_question ) {
        $this->question = $cust_question;
        if($vendor && !isset($vendor->user_data->user_email)) return;
        $this->recipient = $vendor->user_data->user_email;
        
        $this->vendor = $vendor;
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
        $subject = __( '[{site_title}] New Question', 'dc-woocommerce-multi-vendor');
        if( isset($this->object['subject']) && !empty($this->object['subject']) ){
            $subject = $subject . ' - ' . $this->object['subject'];
        }
        return apply_filters( 'wcmp_vendor_new_question_email_subject', $subject, $this->object );
    }

    /**
     * Get email heading.
     *
     * @access  public
     * @return string
     */
    public function get_default_heading() {
        return apply_filters( 'wcmp_vendor_new_question_email_heading', __( "Question", 'dc-woocommerce-multi-vendor'), $this->object );
    }
    
    /**
     * Get email headers.
     *
     * @return string
     */
    public function get_headers() {
        $header = 'Content-Type: ' . $this->get_content_type() . "\r\n";
        if( apply_filters( 'wcmp_vendor_new_question_email_goes_to_admin', true, $this->object ) ) {
            $header .= 'Cc: Admin <' . get_option('admin_email') . '>'."\r\n";
        }

        return apply_filters( 'wcmp_vendor_new_question_email_headers', $header, $this->id, $this->object );
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
            'vendor'        =>  $this->vendor,
            'email_heading' => $this->get_heading(),
            'question'      => $this->question,
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
            'vendor'        =>  $this->vendor,
            'email_heading' => $this->get_heading(),
            'question'      => $this->question,
            'plain_text'    => true,
            'email'         => $this,
            ), 'dc-product-vendor/', $this->template_base);
        return ob_get_clean();
    }

    }
  
    endif;
