<?php
/**
 * Role Management
 *
 * Created by PhpStorm.
 * User: waqasriaz
 * Date: 08/08/16
 * Time: 9:38 PM
 */
global $fave_options;

$fave_options = get_option( 'houzez_options' );

$user_can_publish = true;

if ( isset( $fave_options['listings_admin_approved'] ) && $fave_options['listings_admin_approved'] == 'yes' ) :
    $user_can_publish = false;
endif;

add_role(
    'houzez_buyer',
    __( 'Buyer' ),
    array(
        'read'         => true,  // true allows this capability
        'edit_posts'   => false,
        'delete_posts' => false, // Use false to explicitly deny
    )
);

add_role(
    'houzez_agency',
    __( 'Agency' ),
    array(
        'read'                      => true,  // true allows this capability
        'edit_posts'                => true,
        'delete_posts'              => true, // Use false to explicitly deny
        'read_property'             => true,
        'publish_posts'             => true,
        'edit_property'             => true,
        'create_properties'         => true,
        'edit_properties'           => true,
        'delete_properties'       => true,
        'edit_published_properties'    => true,
        'publish_properties'        => true,
        'delete_published_properties'   => true,
        'delete_private_properties' => true,
        'read_testimonial'             => true,
        'edit_testimonial'             => true,
        'create_testimonials'         => true,
        'edit_testimonials'           => true,
        'edit_published_testimonials'    => true,
        'publish_testimonials'        => true,
        'delete_published_testimonials'   => true
    )
);

add_role(
    'houzez_agent',
    __( 'Agent' ),
    array(
        'read'                      => true,  // true allows this capability
        'edit_posts'                => true,
        'delete_posts'              => true, // Use false to explicitly deny
        'read_property'             => true,
        'publish_posts'             => true,
        'edit_property'             => true,
        'create_properties'         => true,
        'edit_properties'           => true,
        'delete_properties'       => true,
        'edit_published_properties'    => true,
        'publish_properties'        => true,
        'delete_published_properties'   => true,
        'delete_private_properties' => true,
        'read_testimonial'             => true,
        'edit_testimonial'             => true,
        'create_testimonials'         => true,
        'edit_testimonials'           => true,
        'edit_published_testimonials'    => true,
        'publish_testimonials'        => true,
        'delete_published_testimonials'   => true
    )
);

add_role(
    'houzez_seller',
    __( 'Seller' ),
    array(
        'read'                      => true,  // true allows this capability
        'read_property'             => true,
        'edit_property'             => true,
        'create_properties'         => true,
        'edit_properties'           => true,
        'delete_properties'       => true,
        'edit_published_properties'    => true,
        'publish_properties'        => true,
        'delete_published_properties'   => true,
        'delete_private_properties' => true
    )
);

add_role(
    'houzez_owner',
    __( 'Owner' ),
    array(
        'read'                      => false,  // true allows this capability
        'edit_posts'                => false,
        'delete_posts'              => false, // Use false to explicitly deny
        'read_property'             => true,
        'publish_posts'             => false,
        'edit_property'             => true,
        'create_properties'         => true,
        'edit_properties'           => true,
        'delete_properties'         => true,
        'edit_published_properties' => true,
        'publish_properties'        => true,
        'delete_published_properties'=> true,
        'delete_private_properties' => true
    )
);
add_role(
    'houzez_manager',
    __( 'Manager' ),
    array(
        'read'                      => false,  // true allows this capability
        'edit_posts'                => false,
        'delete_posts'              => false, // Use false to explicitly deny
        'read_property'             => true,
        'publish_posts'             => false,
        'edit_property'             => true,
        'create_properties'         => true,
        'edit_properties'           => true,
        'delete_properties'         => true,
        'edit_published_properties' => true,
        'publish_properties'        => true,
        'delete_published_properties'=> true,
        'delete_private_properties' => true
    )
);