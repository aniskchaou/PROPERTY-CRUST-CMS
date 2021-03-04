<?php
/*-----------------------------------------------------------------------------------*/
/*	Add Metaboxes
/*-----------------------------------------------------------------------------------*/

add_action( 'load-post.php', 'houzez_meta_boxes_setup' );
add_action( 'load-post-new.php', 'houzez_meta_boxes_setup' );

/* Meta box setup function. */
if ( !function_exists( 'houzez_meta_boxes_setup' ) ) :
	function houzez_meta_boxes_setup() {
		global $typenow;

		$paid_submission_type  = houzez_option('enable_paid_submission');

		if ( $typenow == 'user_packages' ) {
			add_action( 'add_meta_boxes', 'houzez_load_user_packages_metaboxes' );
			add_action( 'save_post', 'houzez_save_user_packages_metaboxes', 10, 2 );
		}

		if ( $typenow == 'houzez_invoice' ) {
			add_action( 'add_meta_boxes', 'houzez_load_invoices_metaboxes' );
			add_action( 'save_post', 'houzez_save_invoices_metaboxes', 10, 2 );
		}
		if ( $typenow == 'property' && $paid_submission_type == 'per_listing') {
			add_action( 'add_meta_boxes', 'houzez_load_property_metaboxes' );
			add_action( 'save_post', 'houzez_save_property_metaboxes', 10, 2 );
		}
		if ( $typenow == 'page' ) {
			add_action( 'add_meta_boxes', 'houzez_load_page_metaboxes' );
			add_action( 'save_post', 'houzez_save_page_metaboxes', 10, 2 );
		}
	}
endif;

if ( !function_exists( 'houzez_load_property_metaboxes' ) ) :
	function houzez_load_property_metaboxes() {
		add_meta_box('houzez-paid-submission', esc_html__('Paid Submission',   'houzez'), 'houzez_paid_submission', 'property', 'side', 'high' );
	}
endif;

if ( !function_exists( 'houzez_load_page_metaboxes' ) ) :
	function houzez_load_page_metaboxes() {
		add_meta_box('houzez-page-metaboxes', esc_html__('Page Sidebar',   'houzez'), 'houzez_page_metaboxes', 'page', 'side', 'high' );
	}
endif;

/* Add invoices metaboxes */
if ( !function_exists( 'houzez_load_invoices_metaboxes' ) ) :
	function houzez_load_invoices_metaboxes() {
		add_meta_box(
			'houzez_invoice_metaboxes',
			esc_html__('Invoice Details', 'houzez'),
			'houzez_invoice_meta',
			array('houzez_invoice'),
			'normal',
			'default'
		);

		add_meta_box(
			'houzez_invoice_payment_status',
			esc_html__('Payment Status', 'houzez'),
			'houzez_invoice_payment_status',
			array('houzez_invoice'),
			'side',
			'high'
		);
	}
endif;

/* Add package management metaboxes */
if ( !function_exists( 'houzez_load_user_packages_metaboxes' ) ) :
	function houzez_load_user_packages_metaboxes() {
		add_meta_box(
			'houzez_user_packages_metaboxes',
			esc_html__('Package Details', 'houzez'),
			'houzez_user_packages_meta',
			array('user_packages'),
			'normal',
			'default'
		);
	}
endif;


/*-----------------------------------------------------------------------------------*/
/*  Property Pay Submission  function
/*-----------------------------------------------------------------------------------*/

if( !function_exists('houzez_paid_submission') ):

	function houzez_paid_submission( $object, $box ){

		$paid_submission_type  = houzez_option('enable_paid_submission');
		if($paid_submission_type=='no'){
			esc_html_e('Paid Submission is disabled','houzez');
		}

		//if($paid_submission_type=='per_listing'){
			esc_html_e('Payment Status: ','houzez');

			$payment_status = get_post_meta( $object->ID, 'fave_payment_status', true);
			if( $payment_status == 'paid' ) {
				echo '<span class="fave_admin_label label-green">'.esc_html__('Paid','houzez').'</span>';
			} else {
				echo '<span class="fave_admin_label label-red">'.esc_html__('Not Paid','houzez').'</span>';
			}
		//}
		?>

		<div class="favethemes_meta_control custom_sidebar_js">
			<p><?php esc_html_e( 'Change Payment Status:', 'houzez' ); ?></p>
			<select name="fave[fave_payment_status]" class="fave-dropdown widefat">
				<option value="not_paid" <?php selected( $payment_status, 'not_paid' );?>><?php esc_html_e( 'Not Paid', 'houzez' ); ?></option>
				<option value="paid" <?php selected( $payment_status, 'paid' );?>><?php esc_html_e( 'Paid', 'houzez' ); ?></option>
			</select>
		</div>

<?php
	}
endif; // end   estate_paid_submission


/*-----------------------------------------------------------------------------------*/
/*  Page sidebar metaboxes
/*-----------------------------------------------------------------------------------*/

if( !function_exists('houzez_page_metaboxes') ):

	function houzez_page_metaboxes( $object, $box ) {
		global $wp_registered_sidebars;

		$fave_meta = houzez_get_sidebar_meta( $object->ID );
		wp_nonce_field( plugin_basename( __FILE__ ), 'houzez_page_nonce' );

		$specific_sidebar = $fave_meta['specific_sidebar'];
		$selected_sidebar = $fave_meta['selected_sidebar'];
	?>
		<div class="favethemes_meta_control custom_sidebar_js">
			<p><?php esc_html_e('Show Specific Sidebar?', 'houzez' ); ?></p>
			<select id="specific_sidebar" name="fave[specific_sidebar]" class="fave-dropdown widefat">
				<option value="no" <?php selected( $specific_sidebar, 'no' );?>><?php esc_html_e( 'No', 'houzez' ); ?></option>
				<option value="yes" <?php selected( $specific_sidebar, 'yes' );?>><?php esc_html_e( 'Yes', 'houzez' ); ?></option>
			</select>
		</div>

		<div id="houzez_selected_sidebar" class="favethemes_meta_control" style="display: none;">
			<p><?php esc_html_e('Select Sidebar', 'houzez' ); ?></p>
			<select name="fave[selected_sidebar]" class="fave-dropdown widefat">
				<?php
				foreach( $wp_registered_sidebars as $sidebar ) { ?>
					<option value="<?php echo $sidebar['id']; ?>" <?php selected( $selected_sidebar, $sidebar['id'] );?>><?php echo $sidebar['name']; ?></option>
				<?php
				}
				?>
			</select>
		</div>

	<?php
	}

endif; // end   houzez_page_metaboxes

/*-----------------------------------------------------------------------------------*/
/* Save sidebar page Meta
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'houzez_save_page_metaboxes' ) ) :
	function houzez_save_page_metaboxes( $post_id, $post ) {

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return;


		if ( $post->post_type == 'page' && isset( $_POST['fave'] ) ) {
			$post_type = get_post_type_object( $post->post_type );
			if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
				return $post_id;

			$fave_meta = array();

			/*$specific_sidebar = isset( $_POST['fave']['specific_sidebar'] ) ? $_POST['fave']['specific_sidebar'] : 'no';
			$selected_sidebar = isset( $_POST['fave']['selected_sidebar'] ) ? $_POST['fave']['selected_sidebar'] : 'default-sidebar'*/;

			$fave_meta['specific_sidebar'] = isset( $_POST['fave']['specific_sidebar'] ) ? $_POST['fave']['specific_sidebar'] : 'no';
			$fave_meta['selected_sidebar'] = isset( $_POST['fave']['selected_sidebar'] ) ? $_POST['fave']['selected_sidebar'] : 'default-sidebar';

			update_post_meta( $post_id, '_houzez_sidebar_meta', $fave_meta );

		}
	}
endif;

/*-----------------------------------------------------------------------------------*/
/*  Add Invoice Meta boxes
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'houzez_invoice_meta' ) ) :
	function houzez_invoice_meta( $object, $box ) {
		$fave_meta = houzez_get_invoice_meta( $object->ID );
		wp_nonce_field( plugin_basename( __FILE__ ), 'houzez_invoice_nonce' );

		$invoice_billion_for =  esc_html($fave_meta['invoice_billion_for']);
		$payment_status 	 = get_post_meta( $object->ID, 'invoice_payment_status', true);

		$paypal_txn_id = esc_html( get_post_meta( $object->ID, 'HOUZEZ_paypal_txn_id', true ) );

		//'Listing','Upgrade to Featured','Publish Listing with Featured','package'

		$purchase_type  =   0;
		if( $invoice_billion_for == 'Listing' ) {
			$purchase_type = 1;
		}else if( $invoice_billion_for == 'Upgrade to Featured'){
			$purchase_type = 2;
		}else if($invoice_billion_for =='Publish Listing with Featured' ){
			$purchase_type = 3;
		} ?>

		<?php if( $payment_status == 0 ) { ?>
			<div class="favethemes_meta_control">
				<?php
				if( $invoice_billion_for =='package' || $invoice_billion_for =='Package' ) {
					print '<div id="activate_package" class="houzez_activate_listing button button-primary button-large" data-invoice="'.$object->ID.'" data-item="'.esc_attr($fave_meta['invoice_item_id']).'"><span class="btn-loader houzez-loader-js"></span>'.esc_html__('Wire Payment Received - Activate the purchase', 'houzez').'</div>';
				} else {
					print '<div id="activate_purchase_listing" class="houzez_activate_listing button button-primary button-large" data-invoice="'.$object->ID.'" data-item="'.esc_attr($fave_meta['invoice_item_id']).' " data-purchaseType="'.$purchase_type.'"><span class="btn-loader houzez-loader-js"></span>'.esc_html__('Wire Payment Received - Activate the purchase', 'houzez').'</div>';
				}
				?>
			</div>
		<?php } ?>

		<div class="favethemes_meta_control">
			<p class="fave-inline-block-wrap"><span class="fave_meta_title"><?php esc_html_e( 'Invoice ID', 'houzez' ); ?></span></p>
			<div class="fave-inline-block-wrap">
				<strong><?php echo intval( $object->ID ); ?></strong>
			</div>
		</div>

		<div class="favethemes_meta_control">
			<p class="fave-inline-block-wrap"><span class="fave_meta_title"><?php esc_html_e( 'Billing For', 'houzez' ); ?></span></p>
			<div class="fave-inline-block-wrap">
				<!--<strong><?php /*echo esc_attr( $fave_meta['invoice_billion_for'] ); */?></strong>-->
				<input class="fave-input-text-backend-large" type="text" name="fave[invoice_billion_for]" value="<?php echo esc_attr($fave_meta['invoice_billion_for']); ?>" /> <br/>
				<!-- Listing / package / Listing with Featured / Upgrade to Featured / Publish Listing with Featured -->
			</div>
		</div>

		<div class="favethemes_meta_control">
			<p class="fave-inline-block-wrap"><span class="fave_meta_title"><?php esc_html_e( 'Billing Type', 'houzez' ); ?></span></p>
			<div class="fave-inline-block-wrap">
				<!--<strong><?php /*echo esc_attr( $fave_meta['invoice_billing_type'] ); */?></strong>-->
				<input class="fave-input-text-backend-large" type="text" name="fave[invoice_billing_type]" value="<?php echo esc_html($fave_meta['invoice_billing_type']); ?>" />
			</div>
		</div>

		<div class="favethemes_meta_control">
			<p class="fave-inline-block-wrap"><span class="fave_meta_title"><?php esc_html_e( 'Payment Method', 'houzez' ); ?></span></p>
			<div class="fave-inline-block-wrap">
				<!--<strong>
					<?php /*echo esc_attr( $fave_meta['invoice_payment_method'] );  */?>
				</strong>-->
				<input class="fave-input-text-backend-large" type="text" name="fave[invoice_payment_method]" value="<?php echo esc_html($fave_meta['invoice_payment_method']); ?>" />
			</div>
		</div>

		<div class="favethemes_meta_control">
			<p class="fave-inline-block-wrap"><span class="fave_meta_title"><?php esc_html_e( 'Item ID (Listing or Package ID)', 'houzez' ); ?></span></p>
			<div class="fave-inline-block-wrap">
				<input class="fave-input-text-backend-large" type="text" name="fave[invoice_item_id]" value="<?php echo esc_attr($fave_meta['invoice_item_id']); ?>" />
			</div>
		</div>

		<div class="favethemes_meta_control">
			<p class="fave-inline-block-wrap"><span class="fave_meta_title"><?php esc_html_e( 'Item Price:', 'houzez' ); ?></span></p>
			<div class="fave-inline-block-wrap">
				<input class="fave-input-text-backend-large" type="text" name="fave[invoice_item_price]" value="<?php echo esc_attr($fave_meta['invoice_item_price']); ?>" />
			</div>
		</div>

		<div class="favethemes_meta_control">
			<p class="fave-inline-block-wrap"><span class="fave_meta_title"><?php esc_html_e( 'Tax:', 'houzez' ); ?></span></p>
			<div class="fave-inline-block-wrap">
				<input class="fave-input-text-backend-large" type="text" name="fave[invoice_tax]" value="<?php echo esc_attr($fave_meta['invoice_tax']); ?>" />
			</div>
		</div>

		<div class="favethemes_meta_control">
			<p class="fave-inline-block-wrap"><span class="fave_meta_title"><?php esc_html_e( 'Purchase Date:', 'houzez' ); ?></span></p>
			<div class="fave-inline-block-wrap">
				<input class="fave-input-text-backend-large" type="text" name="fave[invoice_purchase_date]" value="<?php echo esc_attr($fave_meta['invoice_purchase_date']); ?>" />
			</div>
		</div>

		<div class="favethemes_meta_control">
			<p class="fave-inline-block-wrap"><span class="fave_meta_title"><?php esc_html_e( 'Username (Buyer Name):', 'houzez' ); ?></span></p>
			<div class="fave-inline-block-wrap">
				<strong>
					<?php
					$user_info = get_userdata($fave_meta['invoice_buyer_id']);
					echo esc_attr($user_info->display_name);
					?>
				</strong>
			</div>
		</div>

		<div class="favethemes_meta_control">
			<p class="fave-inline-block-wrap"><span class="fave_meta_title"><?php esc_html_e( 'Email Address:', 'houzez' ); ?></span></p>
			<div class="fave-inline-block-wrap">
				<strong>
					<?php
					echo esc_attr($user_info->user_email);
					?>
				</strong>
			</div>
		</div>

		<div class="favethemes_meta_control">
			<p class="fave-inline-block-wrap"><span class="fave_meta_title"><?php esc_html_e( 'User ID (Buyer):', 'houzez' ); ?></span></p>
			<div class="fave-inline-block-wrap">
				<input class="fave-input-text-backend-large" type="text" name="fave[invoice_buyer_id]" value="<?php echo esc_attr($fave_meta['invoice_buyer_id']); ?>" />
			</div>
		</div>

		<?php if( $paypal_txn_id !='' ) { ?>
		<div class="favethemes_meta_control">
			<p class="fave-inline-block-wrap"><span class="fave_meta_title"><?php esc_html_e( 'Paypal - Reccuring Payment ID:', 'houzez' ); ?></span></p>
			<div class="fave-inline-block-wrap">
				<strong>
					<?php echo print $paypal_txn_id; ?>
				</strong>
			</div>
		</div>
		<?php } ?>

	  <?php
	}
endif;

/*-----------------------------------------------------------------------------------*/
/* Invoice Payment Status
/*-----------------------------------------------------------------------------------*/

if( !function_exists('houzez_invoice_payment_status') ):

	function houzez_invoice_payment_status( $object, $box ){ ?>

		<div class="favethemes_meta_control custom_sidebar_js">
			<?php
			$payment_status = get_post_meta( $object->ID, 'invoice_payment_status', true);
			if( $payment_status == 0 ) {
				echo '<span class="fave_admin_label label-red" style="float: none;">'.esc_html__('Not Paid','houzez').'</span>';
			} else {
				echo '<span class="fave_admin_label label-green" style="float: none;">'.esc_html__('Paid','houzez').'</span>';
			}
			?>
		</div>

<?php
	}
endif; // end   estate_paid_submission


/*-----------------------------------------------------------------------------------*/
/* Save Property Post Meta
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'houzez_save_property_metaboxes' ) ) :
	function houzez_save_property_metaboxes( $post_id, $post ) {

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return;

		if ( isset( $_POST['fave_property_nonce'] ) ) {
			if ( !wp_verify_nonce( $_POST['fave_property_nonce'], __FILE__  ) )
				return;
		}


		if ( $post->post_type == 'property' && isset( $_POST['fave'] ) ) {
			$post_type = get_post_type_object( $post->post_type );
			if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
				return $post_id;

			$fave_payment_status = isset( $_POST['fave']['fave_payment_status'] ) ? $_POST['fave']['fave_payment_status'] : '';
			update_post_meta( $post_id, 'fave_payment_status', $fave_payment_status );

		}
	}
endif;

/*-----------------------------------------------------------------------------------*/
/* Save invoice Post Meta
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'houzez_save_invoices_metaboxes' ) ) :
	function houzez_save_invoices_metaboxes( $post_id, $post ) {

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return;

		/*if ( isset( $_POST['houzez_invoice_nonce'] ) ) {
			if ( !wp_verify_nonce( $_POST['houzez_invoice_nonce'], __FILE__  ) )
				return;
		}*/


		if ( $post->post_type == 'houzez_invoice' && isset( $_POST['fave'] ) ) {
			$post_type = get_post_type_object( $post->post_type );
			if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
				return $post_id;

			$fave_meta = array();

			$invoice_billion_for = isset( $_POST['fave']['invoice_billion_for'] ) ? $_POST['fave']['invoice_billion_for'] : '';
			$invoice_billing_type = isset( $_POST['fave']['invoice_billing_type'] ) ? $_POST['fave']['invoice_billing_type'] : '';
			$invoice_item_id = isset( $_POST['fave']['invoice_item_id'] ) ? $_POST['fave']['invoice_item_id'] : '';
			$invoice_item_price = isset( $_POST['fave']['invoice_item_price'] ) ? $_POST['fave']['invoice_item_price'] : '';
			$invoice_tax = isset( $_POST['fave']['invoice_tax'] ) ? $_POST['fave']['invoice_tax'] : '';
			$invoice_purchase_date = isset( $_POST['fave']['invoice_purchase_date'] ) ? $_POST['fave']['invoice_purchase_date'] : '';
			$invoice_buyer_id = isset( $_POST['fave']['invoice_buyer_id'] ) ? $_POST['fave']['invoice_buyer_id'] : '';

			// For search
			update_post_meta( $post_id, 'HOUZEZ_invoice_buyer', $invoice_buyer_id );
			update_post_meta( $post_id, 'HOUZEZ_invoice_type', $invoice_billing_type );
			update_post_meta( $post_id, 'HOUZEZ_invoice_for', $invoice_billion_for );
			update_post_meta( $post_id, 'HOUZEZ_invoice_item_id', $invoice_item_id );
			update_post_meta( $post_id, 'HOUZEZ_invoice_price', $invoice_item_price );
			update_post_meta( $post_id, 'HOUZEZ_invoice_tax', $invoice_tax );
			update_post_meta( $post_id, 'HOUZEZ_invoice_date', $invoice_purchase_date );


			$fave_meta['invoice_billion_for'] = isset( $_POST['fave']['invoice_billion_for'] ) ? $_POST['fave']['invoice_billion_for'] : '';
			$fave_meta['invoice_billing_type'] = isset( $_POST['fave']['invoice_billing_type'] ) ? $_POST['fave']['invoice_billing_type'] : '';
			$fave_meta['invoice_item_id'] = isset( $_POST['fave']['invoice_item_id'] ) ? $_POST['fave']['invoice_item_id'] : '';
			$fave_meta['invoice_item_price'] = isset( $_POST['fave']['invoice_item_price'] ) ? $_POST['fave']['invoice_item_price'] : '';
			$fave_meta['invoice_tax'] = isset( $_POST['fave']['invoice_tax'] ) ? $_POST['fave']['invoice_tax'] : '';
			$fave_meta['invoice_purchase_date'] = isset( $_POST['fave']['invoice_purchase_date'] ) ? $_POST['fave']['invoice_purchase_date'] : '';
			$fave_meta['invoice_buyer_id'] = isset( $_POST['fave']['invoice_buyer_id'] ) ? $_POST['fave']['invoice_buyer_id'] : '';
			$fave_meta['invoice_payment_method'] = isset( $_POST['fave']['invoice_payment_method'] ) ? $_POST['fave']['invoice_payment_method'] : '';

			update_post_meta( $post_id, '_houzez_invoice_meta', $fave_meta );

		}
	}
endif;

/*-----------------------------------------------------------------------------------*/
/*  Add User Packages Meta boxes
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'houzez_user_packages_meta' ) ) :
	function houzez_user_packages_meta( $object, $box ) {

		$houzez_meta = houzez_get_user_packages_meta( $object->ID );
		wp_nonce_field( plugin_basename( __FILE__ ), 'houzez_user_packages_nonce' );
		$postID = $object->ID;

		$package_user_id = get_post_meta( $postID, 'user_packages_userID', true );
		$pack_id = get_user_meta( $package_user_id, 'package_id', true );
		$pack_available_listings = get_user_meta( $package_user_id, 'package_listings', true );
		$pack_featured_available_listings = get_user_meta( $package_user_id, 'package_featured_listings', true );
		$package_activation = get_user_meta( $package_user_id, 'package_activation', true );
		$username = get_the_title( $postID );
		$package_name = get_the_title( $pack_id );
		$user_info = get_userdata( $package_user_id );

		$pack_billing_period = get_post_meta( $pack_id, 'fave_billing_time_unit', true );
		$pack_billing_frequency = get_post_meta( $pack_id, 'fave_billing_unit', true );
		$pack_date = strtotime ( get_user_meta( $package_user_id, 'package_activation',true ) );

		switch ( $pack_billing_period ) {
			case 'Day':
				$seconds = 60*60*24;
				break;
			case 'Week':
				$seconds = 60*60*24*7;
				break;
			case 'Month':
				$seconds = 60*60*24*30;
				break;
			case 'Year':
				$seconds = 60*60*24*365;
				break;
		}

		$pack_time_frame = $seconds * $pack_billing_frequency;
		$expired_date    = $pack_date + $pack_time_frame;
		$expired_date    = date( 'Y-m-d', $expired_date );

		?>

		<div class="favethemes_meta_control">
			<p class="fave-inline-block-wrap"><span class="fave_meta_title"><?php esc_html_e( 'Username:', 'houzez' ); ?></span></p>
			<div class="fave-inline-block-wrap">
				<strong> <?php echo esc_attr( $user_info->display_name ); ?> </strong>
			</div>
		</div>

		<div class="favethemes_meta_control">
			<p class="fave-inline-block-wrap"><span class="fave_meta_title"><?php esc_html_e( 'Package:', 'houzez' ); ?></span></p>
			<div class="fave-inline-block-wrap">
				<strong> <?php echo esc_attr( $package_name ); ?> </strong>
			</div>
		</div>

		<div class="favethemes_meta_control">
			<p class="fave-inline-block-wrap"><span class="fave_meta_title"><?php esc_html_e( 'Listings available:', 'houzez' ); ?></span></p>
			<div class="fave-inline-block-wrap">
				<strong> <?php echo esc_attr( $pack_available_listings ); ?> </strong>
			</div>
		</div>

		<div class="favethemes_meta_control">
			<p class="fave-inline-block-wrap"><span class="fave_meta_title"><?php esc_html_e( 'Featured Listings available:', 'houzez' ); ?></span></p>
			<div class="fave-inline-block-wrap">
				<strong> <?php echo esc_attr( $pack_featured_available_listings ); ?> </strong>
			</div>
		</div>

		<div class="favethemes_meta_control">
			<p class="fave-inline-block-wrap"><span class="fave_meta_title"><?php esc_html_e( 'Package Activation:', 'houzez' ); ?></span></p>
			<div class="fave-inline-block-wrap">
				<strong> <?php echo esc_attr( $package_activation ); ?> </strong>
			</div>
		</div>

		<div class="favethemes_meta_control">
			<p class="fave-inline-block-wrap"><span class="fave_meta_title"><?php esc_html_e( 'Expire Date:', 'houzez' ); ?></span></p>
			<div class="fave-inline-block-wrap">
				<strong> <?php echo esc_attr( $expired_date ); ?> </strong>
			</div>
		</div>


		<?php
	}
endif;

/*-----------------------------------------------------------------------------------*/
/* Save invoice Post Meta
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'houzez_save_user_packages_metaboxes' ) ) :
	function houzez_save_user_packages_metaboxes( $post_id, $post ) {

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return;

		if ( isset( $_POST['houzez_user_packages_nonce'] ) ) {
			if ( !wp_verify_nonce( $_POST['houzez_user_packages_nonce'], __FILE__  ) )
				return;
		}


		if ( $post->post_type == 'user_packages' && isset( $_POST['fave'] ) ) {
			$post_type = get_post_type_object( $post->post_type );
			if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
				return $post_id;

			$fave_meta = array();

		}
	}
endif;
?>