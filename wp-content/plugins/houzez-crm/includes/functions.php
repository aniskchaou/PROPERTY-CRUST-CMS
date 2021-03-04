<?php

if(!function_exists('get_crm_deal_group')) {
    function get_crm_deal_group() {
        $group_array = array(); 

        $deal_settings   = get_option( 'hcrm_deals_settings' );
        $deal_group = isset($deal_settings[ 'deal_group' ]) ? $deal_settings[ 'deal_group' ] : "";

        if(!empty($deal_group)) {
            $groups = explode(',', $deal_group);

            foreach ($groups as $group) {
                $group_array[]['name'] = $group;
                $group_array[]['slug'] = preg_replace('/\s+/', '_', $group);
            } 
        }
        return $group_array;
    }
}

if( !function_exists('houzez_crm_get_form_user_type') ) {
    function houzez_crm_get_form_user_type($token) {
    
       $value = '';
       
       if( $token == 'buyer' ) {
            $value = houzez_option('spl_con_buyer', "I'm a buyer");

       } else if( $token == 'tennant' ) {
            $value = houzez_option('spl_con_tennant', "I'm a tennant");

       } else if( $token == 'agent' ) {
            $value = houzez_option('spl_con_agent', "I'm an agent");

       } else if( $token == 'other' ) {
            $value = houzez_option('spl_con_other', "Other");
       } else {
            $value = $token;
       }

       return $value;
    }
}

function hcrm_get_option( $key, $section, $defaults = '' ) {

    /**
     * Get crm settings options
     *
     * @param string $key - unique key for settings option
     * @param array $section - Settings fields array
     *
     */
    $options = get_option( $section );

    if ( isset( $options[ $key ] ) ) {
        return $options[ $key ];
    }

    return $defaults;
}

if( !function_exists('matched_listings')) {
    function matched_listings($meta) {
         
        if(empty($meta)) {
            return '';
        }       
        $meta = maybe_unserialize($meta);
        $tax_query = array();
        $meta_query = array();

        $paged  = (get_query_var('paged')) ? get_query_var('paged') : 1;

        $args = array(
            'post_type' => 'property',
            'posts_per_page' => 15,
            'paged' => $paged,
            'post_status' => 'publish'
        );
        
        // Taxonomies
        $tax_query = apply_filters( 'houzez_tax_crm_filter', $tax_query, $meta );
        $tax_count = count($tax_query);
        if( $tax_count > 1 ) {
            $tax_query['relation'] = 'AND';
        }

        if($tax_count > 0 ) {
            $args['tax_query'] = $tax_query;
        }

        // Meta
        $meta_query = apply_filters( 'houzez_meta_crm_filter', $meta_query, $meta );
        $meta_count = count($meta_query);
        if( $meta_count > 1 ) {
            $meta_query['relation'] = 'AND';
        }

        if($meta_count > 0 ) {
            $args['meta_query'] = $meta_query;
        }

        $query = new WP_Query( $args );
        return $query;
    }
}

if(!function_exists('houzez_matched_prop_type')) {
    function houzez_matched_prop_type($tax_query, $meta) {
        if ( isset( $meta['property_type']['slug'] ) && !empty($meta['property_type']['slug']) ) {
            $tax_query[] = array(
                'taxonomy' => 'property_type',
                'field' => 'slug',
                'terms' => $meta['property_type']['slug']
            );
        }
        return $tax_query;
    }

    add_filter('houzez_tax_crm_filter', 'houzez_matched_prop_type', 10, 2);
}


if(!function_exists('houzez_matched_country')) {
    function houzez_matched_country($tax_query, $meta) {
        if ( isset( $meta['country']['slug'] ) && !empty($meta['country']['slug']) ) {
            $tax_query[] = array(
                'taxonomy' => 'property_country',
                'field' => 'slug',
                'terms' => $meta['country']['slug']
            );
        }

        
        return $tax_query;
    }

    add_filter('houzez_tax_crm_filter', 'houzez_matched_country', 10, 2);
}

if(!function_exists('houzez_matched_state')) {
    function houzez_matched_state($tax_query, $meta) {
        if ( isset( $meta['state']['slug'] ) && !empty($meta['state']['slug']) ) {
            $tax_query[] = array(
                'taxonomy' => 'property_state',
                'field' => 'slug',
                'terms' => $meta['state']['slug']
            );
        }
        return $tax_query;
    }

    add_filter('houzez_tax_crm_filter', 'houzez_matched_state', 10, 2);
}

if(!function_exists('houzez_matched_city')) {
    function houzez_matched_city($tax_query, $meta) {
        if ( isset( $meta['city']['slug'] ) && !empty($meta['city']['slug']) ) {
            $tax_query[] = array(
                'taxonomy' => 'property_city',
                'field' => 'slug',
                'terms' => $meta['city']['slug']
            );
        }
        return $tax_query;
    }

    add_filter('houzez_tax_crm_filter', 'houzez_matched_city', 10, 2);
}

if(!function_exists('houzez_matched_area')) {
    function houzez_matched_area($tax_query, $meta) {
        if ( isset( $meta['area']['slug'] ) && !empty($meta['area']['slug']) ) {
            $tax_query[] = array(
                'taxonomy' => 'property_area',
                'field' => 'slug',
                'terms' => $meta['area']['slug']
            );
        }
        return $tax_query;
    }

    add_filter('houzez_tax_crm_filter', 'houzez_matched_area', 10, 2);
}

if(!function_exists('houzez_matched_price')) {
    function houzez_matched_price($meta_query, $meta) {
        if (isset($meta['min_price']) && !empty($meta['min_price']) && isset($meta['max_price']) && !empty($meta['max_price'])) {
            $min_price = doubleval(houzez_clean($meta['min_price']));
            $max_price = doubleval(houzez_clean($meta['max_price']));

            if ($min_price > 0 && $max_price >= $min_price) { 
                $meta_query[] = array(
                    'key' => 'fave_property_price',
                    'value' => array($min_price, $max_price),
                    'type' => 'NUMERIC',
                    'compare' => 'BETWEEN',
                );
            }
        } else if (isset($meta['min_price']) && !empty($meta['min_price'])) {
            $min_price = doubleval(houzez_clean($meta['min_price']));
            if ($min_price > 0) {
                $meta_query[] = array(
                    'key' => 'fave_property_price',
                    'value' => $min_price,
                    'type' => 'NUMERIC',
                    'compare' => '>=',
                );
            }
        } else if (isset($meta['max_price']) && !empty($meta['max_price']) ) {
            $max_price = doubleval(houzez_clean($meta['max_price']));
            if ($max_price > 0) {
                $meta_query[] = array(
                    'key' => 'fave_property_price',
                    'value' => $max_price,
                    'type' => 'NUMERIC',
                    'compare' => '<=',
                );
            }
        }
        return $meta_query;
    }

    add_filter('houzez_meta_crm_filter', 'houzez_matched_price', 10, 2);
}

if(!function_exists('houzez_matched_bedrooms')) {
    function houzez_matched_bedrooms($meta_query, $meta) {
        if (isset($meta['min_beds']) && !empty($meta['min_beds']) && isset($meta['max_beds']) && !empty($meta['max_beds'])) {
            $min_beds = doubleval(houzez_clean($meta['min_beds']));
            $max_beds = doubleval(houzez_clean($meta['max_beds']));

            if ($min_beds > 0 && $max_beds >= $min_beds) { 
                $meta_query[] = array(
                    'key' => 'fave_property_bedrooms',
                    'value' => array($min_beds, $max_beds),
                    'type' => 'NUMERIC',
                    'compare' => 'BETWEEN',
                );
            }
        } else if (isset($meta['min_beds']) && !empty($meta['min_beds'])) {
            $min_beds = doubleval(houzez_clean($meta['min_beds']));
            if ($min_beds > 0) {
                $meta_query[] = array(
                    'key' => 'fave_property_bedrooms',
                    'value' => $min_beds,
                    'type' => 'NUMERIC',
                    'compare' => '>=',
                );
            }
        } else if (isset($meta['max_beds']) && !empty($meta['max_beds']) ) {
            $max_beds = doubleval(houzez_clean($meta['max_beds']));
            if ($max_beds > 0) {
                $meta_query[] = array(
                    'key' => 'fave_property_bedrooms',
                    'value' => $max_beds,
                    'type' => 'NUMERIC',
                    'compare' => '<=',
                );
            }
        }
        return $meta_query;
    }

    add_filter('houzez_meta_crm_filter', 'houzez_matched_bedrooms', 10, 2);
}

if(!function_exists('houzez_matched_bathrooms')) {
    function houzez_matched_bathrooms($meta_query, $meta) {
        if (isset($meta['min_baths']) && !empty($meta['min_baths']) && isset($meta['max_baths']) && !empty($meta['max_baths'])) {
            $min_baths = doubleval(houzez_clean($meta['min_baths']));
            $max_baths = doubleval(houzez_clean($meta['max_baths']));

            if ($min_baths > 0 && $max_baths >= $min_baths) { 
                $meta_query[] = array(
                    'key' => 'fave_property_bathrooms',
                    'value' => array($min_baths, $max_baths),
                    'type' => 'NUMERIC',
                    'compare' => 'BETWEEN',
                );
            }
        } else if (isset($meta['min_baths']) && !empty($meta['min_baths'])) {
            $min_baths = doubleval(houzez_clean($meta['min_baths']));
            if ($min_baths > 0) {
                $meta_query[] = array(
                    'key' => 'fave_property_bathrooms',
                    'value' => $min_baths,
                    'type' => 'NUMERIC',
                    'compare' => '>=',
                );
            }
        } else if (isset($meta['max_baths']) && !empty($meta['max_baths']) ) {
            $max_baths = doubleval(houzez_clean($meta['max_baths']));
            if ($max_baths > 0) {
                $meta_query[] = array(
                    'key' => 'fave_property_bathrooms',
                    'value' => $max_baths,
                    'type' => 'NUMERIC',
                    'compare' => '<=',
                );
            }
        }
        return $meta_query;
    }

    add_filter('houzez_meta_crm_filter', 'houzez_matched_bathrooms', 10, 2);
}

if(!function_exists('houzez_matched_area_size')) {
    function houzez_matched_area_size($meta_query, $meta) {
        if (isset($meta['min_area']) && !empty($meta['min_area']) && isset($meta['max_area']) && !empty($meta['max_area'])) {
            $min_area = doubleval(houzez_clean($meta['min_area']));
            $max_area = doubleval(houzez_clean($meta['max_area']));

            if ($min_area > 0 && $max_area >= $min_area) { 
                $meta_query[] = array(
                    'key' => 'fave_property_size',
                    'value' => array($min_area, $max_area),
                    'type' => 'NUMERIC',
                    'compare' => 'BETWEEN',
                );
            }
        } else if (isset($meta['min_area']) && !empty($meta['min_area'])) {
            $min_area = doubleval(houzez_clean($meta['min_area']));
            if ($min_area > 0) {
                $meta_query[] = array(
                    'key' => 'fave_property_size',
                    'value' => $min_area,
                    'type' => 'NUMERIC',
                    'compare' => '>=',
                );
            }
        } else if (isset($meta['max_area']) && !empty($meta['max_area']) ) {
            $max_area = doubleval(houzez_clean($meta['max_area']));
            if ($max_area > 0) {
                $meta_query[] = array(
                    'key' => 'fave_property_size',
                    'value' => $max_area,
                    'type' => 'NUMERIC',
                    'compare' => '<=',
                );
            }
        }
        return $meta_query;
    }

    add_filter('houzez_meta_crm_filter', 'houzez_matched_area_size', 10, 2);
}

if(!function_exists('houzez_mathed_zipcode')) {
    function houzez_mathed_zipcode($meta_query, $meta) {
        
        if (isset($meta['zipcode']) && !empty($meta['zipcode'])) {
            $zipcode = sanitize_text_field($meta['zipcode']);
            $meta_query[] = array(
                'key' => 'fave_property_zip',
                'value' => $zipcode,
                'type' => 'char',
                'compare' => '=',
            );
        }
        return $meta_query;
    }

    add_filter('houzez_meta_crm_filter', 'houzez_mathed_zipcode', 10, 2);
}



if( !function_exists('houzezcrm_get_assigned_agent')) {
	function houzezcrm_get_assigned_agent($type = "", $agent_id) {
		$data = array();
		if(empty($type)) {
			return '';
		}

		if( $type == 'author_info' ) {
			$data[ 'name' ] = get_the_author_meta( 'display_name' , $agent_id );
        	$data[ 'email' ] = get_the_author_meta( 'email', $agent_id );

		} else if( $type == 'agency_info' ) {
			$data['name'] = get_the_title($agent_id);
			$data['email'] = get_post_meta($agent_id, 'fave_agency_email', true);

		} else {
			$data['name'] = get_the_title($agent_id);
			$data['email'] = get_post_meta($agent_id, 'fave_agent_email', true);
		}
		return $data;
	}
}

if( !function_exists('hcrm_get_term_by') ) {
    function hcrm_get_term_by( $field, $value, $taxonomy ) {
        
        $data = array();
        $term = get_term_by( $field, $value, $taxonomy );
        if ( $term ) {
            $data['name'] = $term->name;
            $data['slug'] = $term->slug;
        }

        return $data;
    }
}

function hcrm_get_taxonomy($taxonomy_name, $taxonomy_terms, $searched_term = "", $prefix = " " ){

    if (!empty($taxonomy_terms) && taxonomy_exists($taxonomy_name)) {
        foreach ($taxonomy_terms as $term) {

            if( $taxonomy_name == 'property_area' ) {
                $term_meta= get_option( "_houzez_property_area_$term->term_id");
                $parent_city = sanitize_title($term_meta['parent_city']);

                if ($searched_term == $term->slug) {
                    echo '<option data-ref="' . urldecode($term->slug) . '" data-belong="'.urldecode($parent_city).'" value="' . urldecode($term->slug) . '" selected="selected">' . esc_attr($prefix) . esc_attr($term->name) . '</option>';
                } else {
                    echo '<option data-ref="' . urldecode($term->slug) . '" data-belong="'.urldecode($parent_city).'" value="' . urldecode($term->slug) . '">' . esc_attr($prefix) . esc_attr($term->name) .'</option>';
                }
                
            } elseif( $taxonomy_name == 'property_city' ) {
                $term_meta= get_option( "_houzez_property_city_$term->term_id");
                $parent_state = sanitize_title($term_meta['parent_state']);

                if ($searched_term == $term->slug) {
                    echo '<option data-ref="' . urldecode($term->slug) . '" data-belong="'.urldecode($parent_state).'" value="' . urldecode($term->slug) . '" selected="selected">' . esc_attr($prefix) . esc_attr($term->name) . '</option>';
                } else {
                    echo '<option data-ref="' . urldecode($term->slug) . '" data-belong="'.urldecode($parent_state).'" value="' . urldecode($term->slug) . '">' . esc_attr($prefix) . esc_attr($term->name) .'</option>';
                }

            } elseif( $taxonomy_name == 'property_state' ) {

                $term_meta = get_option( "_houzez_property_state_$term->term_id");
                $parent_country = sanitize_title($term_meta['parent_country']);

                if ($searched_term == $term->slug) {
                    echo '<option data-ref="' . urldecode($term->slug) . '" data-belong="'.urldecode($parent_country).'" value="' . urldecode($term->slug) . '" selected="selected">' . esc_attr($prefix) . esc_attr($term->name) . '</option>';
                } else {
                    echo '<option data-ref="' . urldecode($term->slug) . '" data-belong="'.urldecode($parent_country).'" value="' . urldecode($term->slug) . '">' . esc_attr($prefix) . esc_attr($term->name) .'</option>';
                }

            } elseif( $taxonomy_name == 'property_country' ) {
        
                if ($searched_term == $term->slug) {
                    echo '<option data-ref="' . urldecode($term->slug) . '" value="' . urldecode($term->slug) . '" selected="selected">' . esc_attr($prefix) . esc_attr($term->name) . '</option>';
                } else {
                    echo '<option data-ref="' . urldecode($term->slug) . '" value="' . urldecode($term->slug) . '">' . esc_attr($prefix) . esc_attr($term->name) .'</option>';
                }

            } else {

                if ($searched_term == $term->slug) {
                    echo '<option value="' . urldecode($term->slug) . '" selected="selected">' . esc_attr($prefix) . esc_attr($term->name) . '</option>';
                } else {
                    echo '<option value="' . urldecode($term->slug) . '">' . esc_attr($prefix) . esc_attr($term->name) . '</option>';
                }
            }


            $child_terms = get_terms($taxonomy_name, array(
                'hide_empty' => false,
                'parent' => $term->term_id
            ));

            if (!empty($child_terms)) {
                hcrm_get_taxonomy( $taxonomy_name, $child_terms, $searched_term, "- ".$prefix );
            }
        }
    }
}