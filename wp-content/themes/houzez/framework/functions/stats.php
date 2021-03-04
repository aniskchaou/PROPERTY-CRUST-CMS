<?php
if(!function_exists('houzez_get_term_slugs_for_stats')) {
	function houzez_get_term_slugs_for_stats($taxonomy) {
		$terms = get_terms(array(
			'taxonomy' => $taxonomy,
			'hide_empty' => false,
			'orderby'    => 'count',
			'order'    => 'DESC',
		));

		$term_data = $slug = $name = array();

		$i = 0;
		foreach ($terms as $terms): 
			$i++;
		    $slug[] = $terms->slug; 
		    $name[] = $terms->name; 

		    if($i == 3) {
		    	//break;
		    }
		endforeach;

		$term_data['name'] = $name;
		$term_data['slug'] = $slug;
		return $term_data;
	}
}

if(!function_exists('houzez_realtor_stats')) {
	function houzez_realtor_stats($taxonomy, $meta_key, $meta_value, $term_slug) {
		global $author_id;

		$args = array(
			'post_type' => 'property',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'fields' => 'ids',
			'tax_query' => array(
		        array(
		            'taxonomy' => $taxonomy,
		            'field'    => 'slug',
		            'terms'    => $term_slug,
		            'include_children' => false
		        )
		    )
		);

		$meta_query = array();

        if(is_singular('houzez_agency')) {

        	$agents_array = array();
        	$agenyc_agents_ids = Houzez_Query::loop_agency_agents_ids(get_the_ID());

        	if( !empty($agenyc_agents_ids) ) {
	        	$agents_array = array(
		            'key' => 'fave_agents',
		            'value' => $agenyc_agents_ids,
		            'compare' => 'IN',
		        );
	        }

        	$args['meta_query'] = array(
                'relation' => 'OR',
                $agents_array,
                array(
                    'relation' => 'AND',
                    array(
			            'key'     => $meta_key,
			            'value'   => $meta_value,
			            'compare' => '='
			        ),
			        array(
			            'key'     => 'fave_agent_display_option',
			            'value'   => 'agency_info',
			            'compare' => '='
			        )
                ),
            );


        } elseif(is_singular('houzez_agent')) {

        	$meta_query[] = array(
	            'key' => $meta_key,
	            'value' => $meta_value,
	            'type' => 'CHAR',
	            'compare' => '=',
	        );
        	$args['meta_query'] = $meta_query;

        } elseif(is_author()) {
        	$args['author'] = $author_id;
        }

		$posts = get_posts($args); 
		//echo count($posts).'<br/>';

		return count($posts);
	}	
}