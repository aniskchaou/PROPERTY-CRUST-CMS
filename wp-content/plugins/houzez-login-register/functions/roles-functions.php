<?php
/**
 * Created by PhpStorm.
 * User: waqasriaz
 * Date: 08/08/16
 * Time: 10:38 PM
 */

if( !function_exists('houzez_add_theme_caps') ) {
    function houzez_add_theme_caps() {
        
        // gets the author role
        $role = get_role('administrator');

        $role->add_cap('create_properties');

        $role->add_cap('publish_properties');
        $role->add_cap('read_property');
        $role->add_cap('delete_property');
        $role->add_cap('edit_property');
        $role->add_cap('edit_properties');
        $role->add_cap('delete_properties');
        $role->add_cap('edit_published_properties');
        $role->add_cap('delete_published_properties');
        $role->add_cap('read_private_properties');
        $role->add_cap('delete_private_properties');
        $role->add_cap('edit_others_properties');
        $role->add_cap('delete_others_properties');
        $role->add_cap('edit_private_properties');
        $role->add_cap('delete_private_properties');
        $role->add_cap('edit_published_properties');

        $role->add_cap('delete_user_package');
        $role->add_cap('delete_user_packages');
        $role->add_cap('edit_user_packages');
        $role->add_cap('delete_others_user_packages');

        $role->add_cap('read_testimonial');
        $role->add_cap('edit_testimonial');
        $role->add_cap('delete_testimonial');
        $role->add_cap('create_testimonials');
        $role->add_cap('publish_testimonials');
        $role->add_cap('edit_testimonials');
        $role->add_cap('edit_published_testimonials');
        $role->add_cap('delete_published_testimonials');
        $role->add_cap('delete_testimonials');
        $role->add_cap('delete_private_testimonials');
        $role->add_cap('delete_others_testimonials');
        $role->add_cap('edit_others_testimonials');
        $role->add_cap('edit_private_testimonials');
        $role->add_cap('edit_published_testimonials');

        $role->add_cap('read_agent');
        $role->add_cap('delete_agent');
        $role->add_cap('edit_agent');
        $role->add_cap('create_agents');
        $role->add_cap('edit_agents');
        $role->add_cap('edit_others_agents');
        $role->add_cap('publish_agents');
        $role->add_cap('read_private_agents');
        $role->add_cap('delete_agents');
        $role->add_cap('delete_private_agents');
        $role->add_cap('delete_published_agents');
        $role->add_cap('delete_others_agents');
        $role->add_cap('edit_private_agents');
        $role->add_cap('edit_published_agents');

        // gets the author role
        $role = get_role('editor');

        $role->add_cap('create_properties');

        $role->add_cap('read_property');
        $role->add_cap('delete_property');
        $role->add_cap('edit_property');
        $role->add_cap('publish_properties');
        $role->add_cap('edit_properties');
        $role->add_cap('edit_published_properties');
        $role->add_cap('delete_published_properties');
        $role->add_cap('read_private_properties');
        $role->add_cap('delete_private_properties');
        $role->add_cap('edit_others_properties');
        $role->add_cap('delete_others_properties');
        $role->add_cap('edit_private_properties');
        $role->add_cap('edit_published_properties');

        $role->add_cap('read_testimonial');
        $role->add_cap('delete_testimonial');
        $role->add_cap('edit_testimonial');
        $role->add_cap('create_testimonials');
        $role->add_cap('delete_testimonial');
        $role->add_cap('publish_testimonials');
        $role->add_cap('edit_testimonials');
        $role->add_cap('edit_published_testimonials');
        $role->add_cap('delete_published_testimonials');
        $role->add_cap('delete_testimonials');
        $role->add_cap('delete_private_testimonials');
        $role->add_cap('delete_others_testimonials');
        $role->add_cap('edit_others_testimonials');
        $role->add_cap('edit_private_testimonials');
        $role->add_cap('edit_published_testimonials');

        $role->add_cap('read_agent');
        $role->add_cap('delete_agent');
        $role->add_cap('edit_agent');
        $role->add_cap('create_agents');
        $role->add_cap('edit_agents');
        $role->add_cap('edit_others_agents');
        $role->add_cap('publish_agents');
        $role->add_cap('read_private_agents');
        $role->add_cap('delete_agents');
        $role->add_cap('delete_private_agents');
        $role->add_cap('delete_published_agents');
        $role->add_cap('delete_others_agents');
        $role->add_cap('edit_private_agents');
        $role->add_cap('edit_published_agents');

        $role = get_role('houzez_agent');
        $role->add_cap('level_2');

        $agency_role = get_role('houzez_agency');
        $agency_role->add_cap('level_2');

        $owner_role = get_role('houzez_owner');
        $owner_role->add_cap('level_2');

        $seller_role = get_role('houzez_seller');
        $seller_role->add_cap('level_2');

        $manager_role = get_role('houzez_manager');
        $manager_role->add_cap('level_5');


    }

    add_action('admin_init', 'houzez_add_theme_caps');
}
?>