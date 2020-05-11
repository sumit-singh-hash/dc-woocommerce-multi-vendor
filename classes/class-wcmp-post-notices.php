<?php
/**
 * WCMp Email Class
 *
 * @version		2.2.0
 * @package		WCMp
 * @author 		WC Marketplace
 */
 
class WCMp_Notices {
	private $post_type;
  public $dir;
  public $file;
  
  public function __construct() {
    $this->post_type = 'wcmp_vendor_notice';
    $this->register_post_type();
		add_action( 'add_meta_boxes', array($this,'vendor_notices_add_meta_box_addtional_field') );
		add_action( 'add_meta_boxes', array($this,'vendor_notices_add_meta_box_select_vendor') );
		add_action( 'save_post', array( $this, 'vendor_notices_save_addtional_field' ), 10, 3 );
		add_action('transition_post_status', array( $this, 'vendor_notices_send_email' ), 10, 3 );		
  }
  
  
  public function vendor_notices_add_meta_box_addtional_field() {
  	global $WCMp;
		$screens = array( 'wcmp_vendor_notice' );
		foreach ( $screens as $screen ) {
			add_meta_box(
				'wcmp_vendor_notice_addtional_field',
				__( 'Addtional Fields', 'dc-woocommerce-multi-vendor' ),
				array($this,'wcmp_vendor_notice_addtional_field_callback'),
				$screen,
				'normal',
				'high'
			);
		}  	
  }
  
  public function wcmp_vendor_notice_addtional_field_callback() {
  	global $WCMp, $post;
  	$url = get_post_meta($post->ID,'_wcmp_vendor_notices_url', true);
  	?>
  	<div id="_wcmp_vendor_notices_url_div" class="_wcmp_vendor_notices_url_div" >
  		<label>Enter Url</label>
  		<input type="text" name="_wcmp_vendor_notices_url" value="<?php echo $url; ?>" class="widefat" style="margin:10px; border:1px solid #888; width:90%;" >			
		</div>			
		<?php
  }

  public function vendor_notices_add_meta_box_select_vendor() {
  	global $WCMp;
  		$WCMp->library->load_select2_lib();
		$screens = array( 'wcmp_vendor_notice' );
		foreach ( $screens as $screen ) {
			add_meta_box(
				'wcmp_vendor_notice_select_vendor',
				__( 'Vendors', 'dc-woocommerce-multi-vendor' ),
				array($this,'wcmp_vendor_notice_select_vendor_callback'),
				$screen,
				'side',
				'low'
			);
		}  	
  }

  public function wcmp_vendor_notice_select_vendor_callback() {
  	global $WCMp, $post;
  	$selected_vendors = get_post_meta($post->ID, '_wcmp_vendor_notices_vendors', true);
  	?>
	<select id="show_announcement_vendors" name="show_announcement_vendors[]" class="" multiple="multiple" style="width:60%">
        <?php
        $vendors = get_wcmp_vendors();
        if ($vendors){
			foreach ($vendors as $vendor) {
				$selected = in_array($vendor->id, $selected_vendors) ? 'selected' : '';
                echo '<option value="' . esc_attr($vendor->id) . '" '.$selected.'>' . esc_html($vendor->page_title) . '</option>';
            }
        } ?>
    </select>			
	<script>
	    jQuery(document).ready(function ($) {
	    		 $("#show_announcement_vendors").select2({
	            placeholder: '<?php echo trim(__('Select vendor...', 'dc-woocommerce-multi-vendor'));?>'
	        });
	    });		
	</script>
	<?php
  }

  public function vendor_notices_send_email( $new_status, $old_status, $post ) { 
  	if ( $new_status == 'publish' && $old_status != 'publish' ) {
		$email_vendor = WC()->mailer()->emails['WC_Email_Vendor_New_Announcement'];
		$selected_vendors = isset($_POST['show_announcement_vendors']) ? $_POST['show_announcement_vendors'] : '';
		$all_vendor_ids = wp_list_pluck( get_wcmp_vendors(), 'id' );
		$vendors = ($selected_vendors && !empty($selected_vendors)) ? $selected_vendors : $all_vendor_ids;
		$single = (count($vendors) == 1) ? 'Your' : 'All vendors and their';
		foreach ($vendors as $vendor_id) {
			$email_vendor->trigger( $post, $vendor_id, $single );
    	}
  	}
  }
  
  public function vendor_notices_save_addtional_field($post_id, $post, $update) {
  	global $WCMp;
  	if (  $this->post_type != $post->post_type ) {
        return;
    }
    if(isset($_POST['_wcmp_vendor_notices_url'])) {
    	update_post_meta($post_id, '_wcmp_vendor_notices_url', $_POST['_wcmp_vendor_notices_url']);    	
    } 	
    if(isset($_POST['show_announcement_vendors'])) {
    	update_post_meta($post_id, '_wcmp_vendor_notices_vendors', $_POST['show_announcement_vendors']);    	
    } 
  }
  
  /**
	 * Register vendor_notices post type
	 *
	 * @access public
	 * @return void
	*/
  function register_post_type() {
		global $WCMp;
		if ( post_type_exists($this->post_type) ) return;
		$labels = array(
			'name' => _x( 'Announcements', 'post type general name' , 'dc-woocommerce-multi-vendor' ),
			'singular_name' => _x( 'Announcements', 'post type singular name' , 'dc-woocommerce-multi-vendor' ),
			'add_new' => _x( 'Add New', $this->post_type , 'dc-woocommerce-multi-vendor' ),
			'add_new_item' => sprintf( __( 'Add New %s' , 'dc-woocommerce-multi-vendor' ), __( 'Announcements' , 'dc-woocommerce-multi-vendor' ) ),
			'edit_item' => sprintf( __( 'Edit %s' , 'dc-woocommerce-multi-vendor' ), __( 'Announcements' , 'dc-woocommerce-multi-vendor') ),
			'new_item' => sprintf( __( 'New %s' , 'dc-woocommerce-multi-vendor' ), __( 'Announcements' , 'dc-woocommerce-multi-vendor') ),
			'all_items' => sprintf( __( 'All %s' , 'dc-woocommerce-multi-vendor' ), __( 'Announcements' , 'dc-woocommerce-multi-vendor' ) ),
			'view_item' => sprintf( __( 'View %s' , 'dc-woocommerce-multi-vendor' ), __( 'Announcements' , 'dc-woocommerce-multi-vendor' ) ),
			'search_items' => sprintf( __( 'Search %a' , 'dc-woocommerce-multi-vendor' ), __( 'Announcements' , 'dc-woocommerce-multi-vendor' ) ),
			'not_found' =>  sprintf( __( 'No %s found' , 'dc-woocommerce-multi-vendor' ), __( 'Announcements' , 'dc-woocommerce-multi-vendor' ) ),
			'not_found_in_trash' => sprintf( __( 'No %s found in trash' , 'dc-woocommerce-multi-vendor' ), __( 'Announcements' , 'dc-woocommerce-multi-vendor' ) ),
			'parent_item_colon' => '',
			'all_items' => __( 'Announcements' , 'dc-woocommerce-multi-vendor' ),
			'menu_name' => __( 'Announcements' , 'dc-woocommerce-multi-vendor' )
		);
		
		$args = array(
			'labels' => $labels,
			'public' => false,
			'publicly_queryable' => true,
			'exclude_from_search' => true,
			'show_ui' => true,
			'show_in_menu' => current_user_can( 'manage_woocommerce' ) ? 'wcmp' : false,
			'show_in_nav_menus' => false,
			'query_var' => false,
			'rewrite' => true,
			'capability_type' => 'post',
			'has_archive' => false,
			'hierarchical' => true,
			'supports' => array( 'title', 'editor' ),
			'menu_position' => 10,
			'menu_icon' => $WCMp->plugin_url.'/assets/images/dualcube.png'
		);		
		register_post_type( $this->post_type, $args );
	}  
	
	
}
