<?php
/**
 * Created by PhpStorm.
 * User: waqasriaz
 * Date: 06/10/15
 * Time: 4:12 PM
 */

global $current_user;

wp_get_current_user();
$userID = $current_user->ID;
$user_show_roles = houzez_option('user_show_roles');
$show_hide_roles = houzez_option('show_hide_roles');
$enable_paid_submission = houzez_option('enable_paid_submission');
$remaining_listings = houzez_get_remaining_listings( $userID );
$select_packages_link = houzez_get_template_link('template/template-packages.php'); 

$cancel_link = houzez_dashboard_listings();
if( !is_user_logged_in() ) {
  $cancel_link = home_url('/');  
}

$show_submit_btn = houzez_option('submit_form_type');
$allowed_html = array(
    'i' => array(
        'class' => array()
    ),
    'strong' => array(),
    'a' => array(
        'href' => array(),
        'title' => array(),
        'target' => array()
    )
);

if( is_page_template( 'template/user_dashboard_submit.php' ) ) {

    if (!houzez_is_admin() && $enable_paid_submission == 'membership' && $remaining_listings != -1 && $remaining_listings < 1 && is_user_logged_in() ) {

        echo '<div class="dashboard-content-block-wrap">
                <div class="dashboard-content-block">';
        if (!houzez_user_has_membership($userID)) {
            print '<p>' . esc_html__('You don\'t have any package! You need to buy your package.', 'houzez') . '</p>
                    <a class="btn btn-primary" href="' . $select_packages_link . '">' . esc_html__('Get Package', 'houzez') . '</a>';
        } else {
            print '<p>' . esc_html__("Your current package doesn\'t let you publish more properties! You need to upgrade your membership.", 'houzez') . '</p>
            <a class="btn btn-primary" href="' . $select_packages_link . '">' . esc_html__('Upgrade Package', 'houzez') . '</a>';
        }
        echo '</div>
        </div>';

    } else { ?>

        <form autocomplete="off" id="submit_property_form" name="new_post" method="post" action="#" enctype="multipart/form-data"
              class="add-frontend-property" novalidate>

            <div class="validate-errors alert alert-danger houzez-hidden" role="alert">
                <?php echo wp_kses(__( '<strong>Error!</strong> Please fill out the following required fields.', 'houzez' ), $allowed_html); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="validate-errors-gal alert alert-danger houzez-hidden" role="alert">
                <?php echo wp_kses(__( '<strong>Error!</strong> Upload at least one image.', 'houzez' ), $allowed_html); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <?php
            $layout = houzez_option('property_form_sections');
            $layout = $layout['enabled'];

            if ($layout): foreach ($layout as $key=>$value) {

                switch($key) {

                    case 'description-price':
                        get_template_part('template-parts/dashboard/submit/description-and-price');
                        break;

                    case 'media':
                        get_template_part('template-parts/dashboard/submit/media');
                        break;

                    case 'details':
                        get_template_part('template-parts/dashboard/submit/details');
                        break;

                    case 'energy_class':
                        get_template_part('template-parts/dashboard/submit/energy-class');
                        break;

                    case 'features':
                        get_template_part('template-parts/dashboard/submit/features');
                        break;

                    case 'location':
                        get_template_part('template-parts/dashboard/submit/location');
                        break;
                    
                    case 'virtual_tour':
                        get_template_part('template-parts/dashboard/submit/360-virtual-tour');
                        break;

                    case 'floorplans':
                        get_template_part('template-parts/dashboard/submit/floor', 'plans');
                        break;

                    case 'multi-units':
                        get_template_part('template-parts/dashboard/submit/sub-properties');
                        break;

                    case 'agent_info':
                        if(houzez_show_agent_box()) {
                            get_template_part('template-parts/dashboard/submit/contact-information');
                        }
                        break;

                    case 'private_note':
                        get_template_part('template-parts/dashboard/submit/private-note');
                        break;

                    case 'attachments':
                        get_template_part('template-parts/dashboard/submit/attachments');
                        break;


                }

            }
            endif;

            if( houzez_is_admin() ) {
                get_template_part('template-parts/dashboard/submit/settings');
            }

            if(houzez_option('add-prop-gdpr-enabled')) {
                get_template_part('template-parts/dashboard/submit/gdpr'); 
            }

            if ( !is_user_logged_in() ) { 

                get_template_part('template-parts/dashboard/submit/account');

             } ?>

            <?php wp_nonce_field('submit_property', 'property_nonce'); ?>

            <input type="hidden" name="action" value="add_property"/>
            <?php if( ! houzez_is_admin() ) { ?>
            <input type="hidden" name="prop_featured" value="0"/>
            <?php } ?>

            <input type="hidden" name="prop_payment" value="not_paid"/>
            <?php if ( !is_user_logged_in() ) { ?>
                <input type="hidden" name="user_submit_has_no_membership" value="yes"/>
            <?php } ?>

            <div class="d-flex justify-content-between add-new-listing-bottom-nav-wrap">
                <a href="<?php echo esc_url($cancel_link ); ?>" class="btn-cancel btn btn-primary-outlined">
                    <?php echo houzez_option('fal_cancel', esc_html__('Cancel', 'houzez')); ?>    
                </a> 

                <?php if($show_submit_btn == 'one_step') { ?>
                    <button id="add_new_property" type="submit" class="btn houzez-submit-js btn-primary">
                        <?php get_template_part('template-parts/loader'); ?>
                        <?php echo houzez_option('fal_submit_property', esc_html__('Submit Property', 'houzez') ); ?>        
                    </button>
                <?php } else { ?>
                    <button class="btn-back houzez-hidden btn btn-primary-outlined">
                        <i class="houzez-icon icon-arrow-left-1 mr-2"></i> <?php houzez_option('fal_back', esc_html_e('Back', 'houzez')); ?>
                    </button> 

                    <button class="btn-next btn btn-primary">
                        <?php echo houzez_option('fal_next', esc_html__('Next', 'houzez')); ?> <i class="houzez-icon icon-arrow-right-1 ml-2"></i>
                    </button>   

                    <div class="btn-step-submit" style="display: none;">
                        <button id="add_new_property" type="submit" class="btn houzez-submit-js btn-primary">
                            <?php get_template_part('template-parts/loader'); ?>
                            <?php echo houzez_option('fal_submit_property', esc_html__('Submit Property', 'houzez') ); ?>        
                        </button>
                    </div>
                <?php } ?>
            </div>

            
        </form>

        <?php
    }
}