<?php
global $post, $houzez_local;
$post_id    = get_the_ID();
$submit_link = houzez_dashboard_add_listing();
$listings_page = houzez_dashboard_listings();
$edit_link  	= add_query_arg( 'edit_property', get_the_ID(), $submit_link );
$delete_link  	= add_query_arg( 'property_id', get_the_ID(), $listings_page );
$paid_submission_type  = houzez_option('enable_paid_submission');
$property_status = get_post_status ( $post->ID );
$payment_status = get_post_meta( get_the_ID(), 'fave_payment_status', true );

$payment_page = houzez_get_template_link('template/template-payment.php');
$insights_page = houzez_get_template_link_2('template/user_dashboard_insight.php');
$payment_page_link = add_query_arg( 'prop-id', $post_id, $payment_page );
$payment_page_link_featured = add_query_arg( 'upgrade_id', $post_id, $payment_page );
$insights_page_link = add_query_arg( 'listing_id', $post_id, $insights_page );


if( $property_status == 'publish' ) {
    $status_badge = '<span class="badge badge-success">'.esc_html__('Approved', 'houzez').'</span>';
} elseif( $property_status == 'on_hold' ) {
    $status_badge = '<span class="badge badge-info">'.esc_html__('On Hold', 'houzez').'</span>';
} elseif( $property_status == 'pending' ) {
    $status_badge = '<span class="badge badge-warning">'.esc_html__('Pending', 'houzez').'</span>';
} elseif( $property_status == 'expired' ) {
    $status_badge = '<span class="badge badge-danger">'.esc_html__('Expired', 'houzez').'</span>';
} elseif( $property_status == 'draft' ) {
    $status_badge = '<span class="badge badge-dark">'.esc_html__('Draft', 'houzez').'</span>';
} else {
    $status_badge = '';
}

$payment_status_label = '';
if( $property_status != 'expired' ) {
    if ($paid_submission_type != 'no' && $paid_submission_type != 'membership' && $paid_submission_type != 'free_paid_listing' ) {
        if ($payment_status == 'paid') {
            $payment_status_label = '<span class="label property-payment-status">' . esc_html__('PAID', 'houzez') . '</span>';
        } elseif ($payment_status == 'not_paid') {
            $payment_status_label = '<span class="label property-payment-status">' . esc_html__('NOT PAID', 'houzez') . '</span>';
        } else {
            $payment_status_label = '';
        }
    } else {
        $payment_status_label = '';
    }
}
?>
<tr>
	
	<td class="property-table-thumbnail" data-label="<?php echo esc_html__('Thumbnail', 'houzez'); ?>">
		<div class="table-property-thumb">
			
			<?php echo $payment_status_label; ?>

			<a href="<?php echo esc_url(get_permalink()); ?>">
			<?php
			if( has_post_thumbnail() && get_the_post_thumbnail(get_the_ID()) != '') {
                the_post_thumbnail(array('100', '75'));
            } else {
                echo '<img src="http://via.placeholder.com/100x75">';
            }
			?>
			</a>	
		</div>
	</td>
	
	<td class="property-table-address" data-label="<?php echo esc_html__('Title', 'houzez'); ?>">
		<a href="<?php echo esc_url(get_permalink()); ?>"><strong><?php the_title(); ?></strong></a><br>
		<?php echo houzez_get_listing_data('property_map_address'); ?><br>
		<?php if( houzez_user_role_by_post_id($post_id) != 'administrator' && get_post_status ( $post_id ) == 'publish' ) { ?>
                <?php if($paid_submission_type != 'no' && houzez_option('per_listing_expire_unlimited') ) { ?>
                <span class="expiration_date">
                    <?php echo esc_html__('Expiration:', 'houzez'); ?> <?php houzez_listing_expire(); ?>
                </span>
                <?php } ?>
        <?php } ?>
	</td>

	<td>
		<?php echo $status_badge; ?>
	</td>

	<td class="property-table-type" data-label="<?php echo esc_html__('Type', 'houzez'); ?>">
		<?php echo houzez_taxonomy_simple('property_type'); ?>&nbsp	
	</td>

	<td class="property-table-status" data-label="<?php echo esc_html__('Status', 'houzez'); ?>">
		<?php echo houzez_taxonomy_simple('property_status'); ?>&nbsp
	</td>

	<td class="property-table-price" data-label="<?php echo esc_html__('Price', 'houzez'); ?>">
		<?php houzez_property_price_admin(); ?>&nbsp
	</td>

	<td class="property-table-featured" data-label="<?php echo esc_html__('Featured', 'houzez'); ?>">
		<?php 
		if(houzez_get_listing_data('featured')) {
			echo esc_html__('Yes', 'houzez'); 
		} else {
			echo esc_html__('No', 'houzez'); 
		}
		?>
	</td>

	<td class="property-table-actions" data-label="<?php echo esc_html__('Actions', 'houzez'); ?>">
		<div class="dropdown property-action-menu">
			<button class="btn btn-primary-outlined dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<?php echo esc_html__('Actions', 'houzez'); ?>
			</button>
			<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">

                <?php 
                if( class_exists('Fave_Insights') && !empty($insights_page) ) { ?>
                <a class="dropdown-item" href="<?php echo esc_url($insights_page_link); ?>"><?php esc_html_e('View Stats', 'houzez'); ?></a>
                <?php } ?>

				<a class="dropdown-item" href="<?php echo esc_url($edit_link); ?>"><?php esc_html_e('Edit', 'houzez'); ?></a>

				<a href="" class="delete-property dropdown-item" data-id="<?php echo intval($post->ID); ?>" data-nonce="<?php echo wp_create_nonce('delete_my_property_nonce') ?>"><?php esc_html_e('Delete', 'houzez'); ?></a>

				<a class="clone-property dropdown-item" data-property="<?php echo $post->ID; ?>" href="#"><?php esc_html_e('Duplicate', 'houzez'); ?></a>

				<?php 
				if(houzez_is_published( $post->ID )) { ?>
                <a href="#" class="put-on-hold dropdown-item" data-property="<?php echo $post->ID; ?>"> 
                	<?php esc_html_e('Put On Hold', 'houzez');?>
                </a>
                <?php 
            	} elseif (houzez_on_hold( $post->ID )) { ?>
                    <a href="#" class="put-on-hold dropdown-item" data-property="<?php echo $post->ID; ?>"> 
                    	<?php esc_html_e('Go Live', 'houzez');?>
                    </a>
                <?php } ?>

                <?php
                if( $paid_submission_type == 'per_listing' && $property_status != 'expired' ) {
                    if ($payment_status != 'paid') {

                        if( houzez_is_woocommerce() ) {
                            echo '<a href="#" class="houzez-woocommerce-pay btn pay-btn" data-listid="'.intval($post_id).'">' . esc_html__('Pay Now', 'houzez') . '</a>';
                        } else {
                            echo '<a href="' . esc_url($payment_page_link) . '" class="btn pay-btn">' . esc_html__('Pay Now', 'houzez') . '</a>';
                        }
                    } else {
                        if( houzez_get_listing_data('featured') != 1 && $property_status == 'publish' ) {

                            if( houzez_is_woocommerce() ) {
                                echo '<a href="' . esc_url($payment_page_link_featured) . '" class="houzez-woocommerce-pay btn pay-btn" data-featured="1" data-listid="'.intval($post_id).'">' . esc_html__('Upgrade to Featured', 'houzez') . '</a>';
                            } else {
                                echo '<a href="' . esc_url($payment_page_link_featured) . '" class="btn pay-btn">' . esc_html__('Upgrade to Featured', 'houzez') . '</a>';
                            }
                            
                        }
                    }
                }

                if( $property_status == 'expired' && ( $paid_submission_type == 'per_listing') ) {
                    
                    if( houzez_is_woocommerce() ) {
                        echo '<a href="#" data-listid="'.intval($post_id).'" class="houzez-woocommerce-pay btn pay-btn">'.esc_html__( 'Re-List', 'houzez' ).'</a>';
                    } else {
                        echo '<a href="' . esc_url($payment_page_link) . '" class="btn pay-btn">'.esc_html__( 'Re-List', 'houzez' ).'</a>';
                    }
                    
                }

                if( $property_status == 'expired' && ( $paid_submission_type == 'free_paid_listing' || $paid_submission_type == 'no' ) ) {
                    
                    echo '<a href="#" data-property="'.$post->ID.'" class="relist-free btn pay-btn">'.esc_html__( 'Re-List', 'houzez' ).'</a>';
                    
                }

                if( houzez_check_post_status( $post->ID ) ) {

                    // Membership
                    if ( $paid_submission_type == 'membership' && houzez_get_listing_data('featured') != 1 && $property_status == 'publish' ) {
                        
                        echo '<a href="#" data-proptype="membership" data-propid="'.intval( $post->ID ).'" class="make-prop-featured btn pay-btn">' . esc_html__('Set as Featured', 'houzez') . '</a>';
                        
                    }
                    if ( $paid_submission_type == 'membership' && houzez_get_listing_data('featured') == 1 ) {
                        
                        echo '<a href="#" data-proptype="membership" data-propid="'.intval( $post->ID ).'" class="remove-prop-featured btn pay-btn">' . esc_html__('Remove From Featured', 'houzez') . '</a>';
                        
                    }
                    if( $property_status == 'expired' && $paid_submission_type == 'membership' ) {
                        
                        echo '<a href="#" data-propid="'.intval( $post->ID ).'" class="resend-for-approval btn pay-btn">' . esc_html__('Reactivate Listing', 'houzez') . '</a>';
                        
                    }

                    //Paid Featured
                    if( $paid_submission_type == 'free_paid_listing' && $property_status == 'publish' ) {
                        
                        if( houzez_get_listing_data('featured') != 1 ) {

                            if( houzez_is_woocommerce() ) {
                                echo '<a href="#" class="houzez-woocommerce-pay btn pay-btn" data-featured="1" data-listid="'.intval($post_id).'">' . esc_html__('Upgrade to Featured', 'houzez') . '</a>';
                            } else {
                                echo '<a href="' . esc_url($payment_page_link_featured) . '" class="btn pay-btn">' . esc_html__('Upgrade to Featured', 'houzez') . '</a>';
                            }
                        }
                        
                    }

                }
                ?>
			</div>
		</div>
	</td>
</tr>