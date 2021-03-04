<?php
add_action( 'wp_ajax_nopriv_houzez_submit_review', 'houzez_submit_review' );
add_action( 'wp_ajax_houzez_submit_review', 'houzez_submit_review' );
if( !function_exists('houzez_submit_review') ) {
    function houzez_submit_review() {
    	$userID = get_current_user_id();
    	$username = '';
    	$creds = array();
    	$reviews_approved = houzez_option('property_reviews_approved_by_admin');
    	$update_reviews_approved = houzez_option('update_review_approved');

        $nonce = $_POST['review-security'];
        if (!wp_verify_nonce( $nonce, 'review-nonce') ) {
            echo json_encode(array(
                'success' => false,
                'msg' => esc_html__('Invalid Nonce!', 'houzez')
            ));
            wp_die();
        }

        $admin_email = get_option( 'admin_email' );

        $review_title = sanitize_text_field( $_POST['review_title'] );
        $permalink = esc_url( $_POST['permalink'] );
        $review_stars = sanitize_text_field( $_POST['review_stars'] );
        $review = wp_kses_post( $_POST['review'] );
        $listing_title = sanitize_text_field( $_POST['listing_title'] );
        $listing_title = esc_attr(strip_tags( $listing_title ));
        $review_post_type = sanitize_text_field( $_POST['review_post_type'] );
        $listing_id = sanitize_text_field( $_POST['listing_id'] );

        if(is_author()) {
        	$property_author_id = $userID;
        } else {
	        $property_author_id = get_post_field( 'post_author', $listing_id );
	    }


        if ( empty($review_title) ) {
            echo json_encode(array(
                'success' => false,
                'msg' => esc_html__('Review title field is empty!', 'houzez')
            ));
            wp_die();
        }

        if ( empty($review_stars) ) {
            echo json_encode(array(
                'success' => false,
                'msg' => esc_html__('Select rating!', 'houzez')
            ));
            wp_die();
        }

        if (empty($review)) {
            echo json_encode(array(
                'success' => false,
                'msg' => esc_html__('Write review!', 'houzez')
            ));
            wp_die();
        }


    	$new_review = array(
            'post_type'	=> 'houzez_reviews'
        );
        $review_id = 0;
        $new_review['post_title'] = $review_title;
        $new_review['post_content'] = wp_kses_post( $review );
        $new_review['post_author'] = $userID;


        $submission_action = intval($_POST['is_update']);

		if ( is_user_logged_in() ) {

			//Check if user already posted review 
			if(houzez_check_user_review($userID, $listing_id, $review_post_type)) {
				echo json_encode( array (
		            'success' => false,
		            'review_link' => '',
		            'msg' => esc_html__("Sorry! You have already posted review on this listing!", 'houzez')
		        ));
		        wp_die();

			} elseif( $userID == $property_author_id ) {

				echo json_encode( array (
		            'success' => false,
		            'review_link' => '',
		            'msg' => esc_html__("Sorry! Listing owners can not post review on their listings!", 'houzez')
		        ));
		        wp_die();

			} else {

				if( $submission_action == 1 ) {

		        	$new_review['ID'] = intval( $_POST['review_id'] );
			        if($update_reviews_approved) {
			        	$new_review['post_status'] = 'pending';
			        } else {
			        	$new_review['post_status'] = 'publish';
			        }

			        $review_id = wp_update_post( $new_review );

		        } else {
		        	if($reviews_approved) {
			        	$new_review['post_status'] = 'pending';
			        } else {
			        	$new_review['post_status'] = 'publish';
			        }
			        $review_id = wp_insert_post( $new_review );
		        }
			}

			$username = get_the_author_meta( 'display_name', get_current_user_id() );
	        
	    } else {

	    	$reviewer_email = sanitize_text_field( $_POST['review_email'] );

	    	if( !is_email( $reviewer_email ) ) {

	            echo json_encode( array( 'success' => false, 'msg' => esc_html__('Invalid email address.', 'houzez') ) );
	            wp_die();

	        } else if( email_exists( $reviewer_email ) ) {

	            echo json_encode( array( 'success' => false, 'msg' => esc_html__('Email already exists! Please login or change email', 'houzez') ) );
	            wp_die();

	        } else {

	        	$user_password = wp_generate_password( $length = 12, $include_standard_special_chars = false );
	        	list($username) = explode('@', $reviewer_email);
				$username .=rand(1,100);

				if( username_exists( $username ) ) {
		            echo json_encode( array( 'success' => false, 'msg' => $username.' '.esc_html__('Username already exist!', 'houzez') ) );
		            wp_die();
		        }

		        $user_id = wp_create_user( $username, $user_password, $reviewer_email );
				$creds['user_login'] = $username;
				$creds['user_password'] = $user_password;
				$creds['remember'] = true;
				$user = wp_signon( $creds, true );

				if($reviews_approved) {
		        	$new_review['post_status'] = 'pending';
		        } else {
		        	$new_review['post_status'] = 'publish';
		        }

		        $new_review['post_author'] = $user_id;
		        $review_id = wp_insert_post( $new_review );

		        houzez_wp_new_user_notification( $user_id, $user_password );
	        }
	        
	    }
        
        if($review_id > 0) {

        	update_post_meta($review_id, 'review_post_type', $review_post_type);
        	update_post_meta($review_id, 'review_stars', $review_stars);
        	update_post_meta($review_id, 'review_by', $userID);
        	update_post_meta($review_id, 'review_to', $property_author_id);

        	$meta_key = '';
        	if($review_post_type == 'property') {
        		update_post_meta($review_id, 'review_property_id', $listing_id);
        		$meta_key = 'review_property_id';
        		$review_link = add_query_arg( 'tab', 'reviews#review-'.$review_id, $permalink );

        	} else if($review_post_type == 'houzez_agent') {
        		update_post_meta($review_id, 'review_agent_id', $listing_id);
        		$meta_key = 'review_agent_id';
        		$review_link = add_query_arg( 'tab', 'reviews', $permalink );

        	} else if($review_post_type == 'houzez_agency') {
        		update_post_meta($review_id, 'review_agency_id', $listing_id);
        		$meta_key = 'review_agency_id';
        		$review_link = add_query_arg( 'tab', 'reviews', $permalink );

        	} else if($review_post_type == 'houzez_author') {
        		update_post_meta($review_id, 'review_author_id', $listing_id);
        		$meta_key = 'review_author_id';
        		$review_link = add_query_arg( 'tab', 'reviews', $permalink );
        	}

        	houzez_add_listing_rating($listing_id, $meta_key, $review_stars);

      
        	$site_name = get_bloginfo('name');

	        $subject = sprintf( esc_html__('A new rating has been received for %s', 'houzez'), $listing_title, $site_name );

	        $body = esc_html__("Rating:", 'houzez') .' '. esc_attr($review_stars) . " ".esc_html__('stars', 'houzez')." <br/>";

	     	$body .= esc_html__("Review Title:", 'houzez') .' '. $review_title . " <br/>";

	     	$body .= esc_html__("Comment:", 'houzez') .' '.( $review ). " <br/>";

			$body .= "<br>------------------------------------<br>";

			$body .= "<br>".esc_html__("You can view this at", 'houzez').' '.esc_url( $review_link ). " <br/>";

			$body .= "<br>".esc_html__('Do not reply to this email.', 'houzez')."<br>";

	        $headers = "Content-Type: text/html; charset=UTF-8\r\n";
	        $headers .= 'From: '.$site_name.' <do-not-reply@'.$_SERVER['HTTP_HOST'].'>' . "\r\n";
        	$headers .= "MIME-Version: 1.0\r\n";

	        wp_mail( $admin_email, $subject, $body, $headers );

	        echo json_encode( array(
	            'success' => true,
	            'review_link' => $review_link,
	            'msg' => esc_html__("Review has been submitted successfully!", 'houzez')
	        ));
	    }

	    $activity_args = array(
            'type' => 'review',
            'review_title' => $review_title,
            'listing_id' => $listing_id,
            'review_id' => $review_id,
            'review_stars' => $review_stars,
            'review_post_type' => $review_post_type,
            'review_content' => $review,
            'review_link' => $review_link,
            'username' => $username,
        );
        do_action('houzez_record_activities', $activity_args);

	    wp_die();

    }
}

if(!function_exists('houzez_admin_review_meta_on_save')) {
	function houzez_admin_review_meta_on_save($review_id, $postdata) {


    	$review_post_type = isset($postdata['review_post_type']) ? $postdata['review_post_type'] : '';
    	$review_stars = isset($postdata['review_stars']) ? $postdata['review_stars'] : '';

  		if(empty($review_post_type)) {
  			return;
  		}
    	
    	$meta_key = '';
    	if($review_post_type == 'property') {
    		$listing_id = isset($postdata['review_property_id']) ? $postdata['review_property_id'] : '';
    		$meta_key = 'review_property_id';

    	} else if($review_post_type == 'houzez_agent') {
    		$listing_id = isset($postdata['review_agent_id']) ? $postdata['review_agent_id'] : '';
    		$meta_key = 'review_agent_id';

    	} else if($review_post_type == 'houzez_agency') {
    		$listing_id = isset($postdata['review_agency_id']) ? $postdata['review_agency_id'] : '';
    		$meta_key = 'review_agency_id';

    	}
    	
    	houzez_add_listing_rating($listing_id, $meta_key, $review_stars);
	}
}

if(!function_exists('houzez_check_user_review')){
	function houzez_check_user_review($user_id, $listing_id, $review_post_type){
		$returnVal = false;
		
		if(!empty($user_id) && !empty($listing_id)){
			
			$args = array(
				'post_type'  => 'houzez_reviews',
				'post_status'	=> 'publish',
				'author' => $user_id,
				'posts_per_page' => -1,
				
		 	);
		 	$query = new WP_Query( $args );
			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
					$query->the_post();
					if($review_post_type == 'property') {
						$current_review = get_post_meta(get_the_ID(), 'review_property_id', true);

					} elseif($review_post_type == 'houzez_agent') {
						$current_review = get_post_meta(get_the_ID(), 'review_agent_id', true);

					} elseif($review_post_type == 'houzez_agency') {
						$current_review = get_post_meta(get_the_ID(), 'review_agency_id', true);

					} elseif($review_post_type == 'houzez_author') {
						$current_review = get_post_meta(get_the_ID(), 'review_author_id', true);

					}

					if($current_review==$listing_id){
						$returnVal = true;
					}
				}
				wp_reset_postdata();
			}
			
		}
		else{
			$returnVal = false;
		}
		return $returnVal;
	}
}

add_action( 'wp_ajax_nopriv_reviews_likes_dislikes', 'houzez_reviews_likes_dislikes' );
add_action( 'wp_ajax_reviews_likes_dislikes', 'houzez_reviews_likes_dislikes' );

if(!function_exists('houzez_reviews_likes_dislikes')) {
	function houzez_reviews_likes_dislikes() {
		$review_id = $_POST['review_id'];
		$type = $_POST['type'];
		

		$cookie_name = $type.$review_id;
		$cookie_value = true;
		$likeDislikeCookie = (isset($_COOKIE[$cookie_name])) ? $_COOKIE[$cookie_name] : array();

		if($type == 'likes') { 
			$cookie_dislike = 'dislikes'.$review_id;
			unset($_COOKIE[$cookie_dislike]);
			setcookie($cookie_dislike, '', time() - 3600);

		} elseif($type == 'dislikes') {
			$cookie_like = 'likes'.$review_id;
			unset($_COOKIE[$cookie_like]);
			setcookie($cookie_like, '', time() - 3600);
		}

		if(empty($likeDislikeCookie)) {

			setcookie($cookie_name , $cookie_value , time() + (3600 * 24 * 30));

			$current_likes = get_post_meta($review_id, 'review_likes', true);
			$current_dislikes = get_post_meta($review_id, 'review_dislikes', true);

			if($type == 'likes') {
				
				if(!empty($current_likes)) {
					$current_likes++;
				} else {
					$current_likes = 1;
				}

				if(!empty($current_dislikes)) {
					$current_dislikes--;
				} else {
					$current_dislikes = 0;
				}

			} elseif($type == 'dislikes') {
				if(!empty($current_likes)) {
					$current_likes--;
				} else {
					$current_likes = 0;
				}

				if(!empty($current_dislikes)) {
					$current_dislikes++;
				} else {
					$current_dislikes = 1;
				}
			}
			
			update_post_meta($review_id, 'review_likes', $current_likes);
			update_post_meta($review_id, 'review_dislikes', $current_dislikes);

			echo json_encode( array(
	            'success' => true,
	            'likes' => $current_likes,
	            'dislikes' => $current_dislikes,
	            'msg' => esc_html__('Thanks for voting', 'houzez')
	        ));
	        wp_die();

		} else {
		
			echo json_encode( array(
	            'success' => false,
	            'msg' => esc_html__("You have already voted", 'houzez')
	        ));
	        wp_die();
		}
	}
}

if(!function_exists('houzez_get_single_review')) {
	function houzez_get_single_review($property_id) {
		$meta_query = array();
		$args = array(
		    'post_type' => 'houzez_reviews',
		    'posts_per_page' => 1
		);

		$meta_query[] = array(
            'key' => 'review_property_id',
            'value' => $property_id,
            'type' => 'NUMERIC',
            'compare' => '=',
        );

        $meta_query[] = array(
            'key' => 'review_by',
            'value' => get_current_user_id(),
            'type' => 'NUMERIC',
            'compare' => '=',
        );

        $meta_query['relation'] = 'AND';

        $args['meta_query'] = $meta_query;

		$review_qry = new WP_Query( $args );

        return $review_qry;

	}
}


if(!function_exists('houzez_add_listing_rating')) {
	function houzez_add_listing_rating($listing_id, $meta_key, $new_stars = null) {
		$args = array(
		    'post_type'   => 'houzez_reviews',
		    'meta_key' => $meta_key,
		    'meta_value' => $listing_id,
		    'posts_per_page' => -1,
		    'post_status' => 'publish',
		);

		$listing_rating = '';
		$total_stars = $total_review = 0;

		$review_query = new WP_Query($args);
		if($review_query->have_posts()) {
			$total_review = $review_query->found_posts;

			while($review_query->have_posts()): $review_query->the_post();
				$review_stars = get_post_meta(get_the_ID(), 'review_stars', true);
				$total_stars = $total_stars + $review_stars;

			endwhile; 
			wp_reset_postdata();

			$total_review = $total_review+1;
			$total_stars = $total_stars+$new_stars;

			$rating = $total_stars/$total_review;

			update_post_meta($listing_id, 'houzez_total_rating', $rating);
			return true;

		} else {
			
			update_post_meta($listing_id, 'houzez_total_rating', $new_stars);
		}

		return true;
	}
}

if(!function_exists('houzez_adjust_listing_rating_on_delete')) {
	function houzez_adjust_listing_rating_on_delete($review_id) {

		$review_post_type = get_post_meta($review_id, 'review_post_type', true);

  		if(empty($review_post_type)) {
  			return;
  		}
    	
    	$meta_key = '';
    	if($review_post_type == 'property') {
    		$listing_id = get_post_meta($review_id, 'review_property_id', true);
    		$meta_key = 'review_property_id';

    	} else if($review_post_type == 'houzez_agent') {
    		$listing_id = get_post_meta($review_id, 'review_agent_id', true);
    		$meta_key = 'review_agent_id';

    	} else if($review_post_type == 'houzez_agency') {
    		$listing_id = get_post_meta($review_id, 'review_agency_id', true);
    		$meta_key = 'review_agency_id';

    	} else if($review_post_type == 'houzez_author') {
    		$listing_id = get_post_meta($review_id, 'review_author_id', true);
    		$meta_key = 'review_author_id';

    	}

		$args = array(
		    'post_type'   => 'houzez_reviews',
		    'meta_key' => $meta_key,
		    'meta_value' => $listing_id,
		    'post_status' => 'publish'
		);

		$listing_rating = '';
		$total_stars = $total_review = 0;

		$review_query = new WP_Query($args);
		if($review_query->have_posts()) { 
			$total_review = $review_query->found_posts;
			while($review_query->have_posts()): $review_query->the_post();
				$houzez_rating = get_post_meta(get_the_ID(), 'review_stars', true);
				$total_stars = $total_stars + $houzez_rating;

			endwhile; 
			wp_reset_postdata();
		}
			

		if($total_review == 0) {
			$rating = '';
		} else {
			$rating = $total_stars/$total_review;
		}
		
		update_post_meta($listing_id, 'houzez_total_rating', $rating);

		return true;
	}
}

add_action( 'wp_ajax_nopriv_houzez_ajax_review', 'houzez_ajax_review' );
add_action( 'wp_ajax_houzez_ajax_review', 'houzez_ajax_review' );  
if( !function_exists('houzez_ajax_review') ) {
	function houzez_ajax_review() {
      	$allowded_html = array();
      	$meta_query = array();
      	$num_of_review = houzez_option('num_of_review');

      	$listing_id = intval($_POST['listing_id']);
      	$sort_by = $_POST['sortby'];
      	$paged = $_POST['paged'];

      	$args = array(
		    'post_type' =>  'houzez_reviews',
		    'posts_per_page' => $num_of_review,
		    'post_status' =>  'publish'
		);

		$review_post_type = $_POST['review_post_type'];
		$meta_key = '';
    	if($review_post_type == 'property') {
    		$meta_key = 'review_property_id';

    	} else if($review_post_type == 'houzez_agent') {
    		$meta_key = 'review_agent_id';

    	} else if($review_post_type == 'houzez_agency') {
    		$meta_key = 'review_agency_id';

    	}

		$meta_query[] = array(
            'key' => $meta_key,
            'value' => $listing_id,
            'type' => 'NUMERIC',
            'compare' => '=',
        );

		if ( $sort_by == 'a_rating' ) {
            $args['orderby'] = 'meta_value_num';
            $args['meta_key'] = 'review_stars';
            $args['order'] = 'ASC';
        } else if ( $sort_by == 'd_rating' ) {
            $args['orderby'] = 'meta_value_num';
            $args['meta_key'] = 'review_stars';
            $args['order'] = 'DESC';
        } else if ( $sort_by == 'a_date' ) {
            $args['orderby'] = 'date';
            $args['order'] = 'ASC';
        } else if ( $sort_by == 'd_date' ) {
            $args['orderby'] = 'date';
            $args['order'] = 'DESC';
        }

        $meta_count = count($meta_query);
        if( $meta_count > 1 ) {
            $meta_query['relation'] = 'AND';
        }
        if ($meta_count > 0) {
            $args['meta_query'] = $meta_query;
        }

        if (!empty($paged) && $paged > 1) {
            $args['paged'] = $paged;
        } else {
            $args['paged'] = 1;
        }

		$review_query = new WP_Query($args);

		if($review_query->have_posts()) {
			while($review_query->have_posts()): $review_query->the_post(); 
				get_template_part('template-parts/reviews/review'); 
		
			endwhile; 
			wp_reset_postdata();
		}

	    wp_die();
	}
}

if(!function_exists('houzez_reviews_count')) {
	function houzez_reviews_count($meta_key) {
		global $author_id;
		
		if(is_author()) {
			$meta_value = $author_id;
		} else {
			$meta_value = get_the_ID();
		}

		$args = array(
		    'post_type' => 'houzez_reviews',
		    'meta_key' => $meta_key,
		    'meta_value' => $meta_value,
		    'posts_per_page' => -1,
		    'post_status' => 'publish',
		);
		$review_qry = new WP_Query( $args );

		$total_review = $review_qry->found_posts;
		return $total_review;
		wp_reset_postdata();
	}
}

if(!function_exists('houzez_get_stars')) {
	function houzez_get_stars($stars, $is_label = true ) {

		
		$output = '';

		if($stars >= 1 && $stars < 1.5) {
			$output = '
				<span class="star"><i class="icon-rating full-star"></i></span>
				<span class="star"><i class="icon-rating empty-star"></i></span>
				<span class="star"><i class="icon-rating empty-star"></i></span>
				<span class="star"><i class="icon-rating empty-star"></i></span>
				<span class="star"><i class="icon-rating empty-star"></i></span>
				';

	            if($is_label) {
		            $output .= '<span class="label bg-success">'.esc_html__('Poor', 'houzez').'</span>';
		        }

		} elseif($stars >= 1.5 && $stars < 2) {
			$output = '
				<span class="star"><i class="icon-rating full-star"></i></span>
				<span class="star"><i class="icon-rating half-star"></i></span>
				<span class="star"><i class="icon-rating empty-star"></i></span>
				<span class="star"><i class="icon-rating empty-star"></i></span>
				<span class="star"><i class="icon-rating empty-star"></i></span>
				';

	            if($is_label) {
		            $output .= '<span class="label bg-success">'.esc_html__('Fair', 'houzez').'</span>';
		        }

		} elseif($stars >= 2 & $stars < 2.5) {
			$output = '
				<span class="star"><i class="icon-rating full-star"></i></span>
				<span class="star"><i class="icon-rating full-star"></i></span>
				<span class="star"><i class="icon-rating empty-star"></i></span>
				<span class="star"><i class="icon-rating empty-star"></i></span>
				<span class="star"><i class="icon-rating empty-star"></i></span>
				';

	            if($is_label) {
		            $output .= '<span class="label bg-success">'.esc_html__('Fair', 'houzez').'</span>';
		        }

		}  elseif($stars >= 2.5 & $stars < 3) {
			$output = '
				<span class="star"><i class="icon-rating full-star"></i></span>
				<span class="star"><i class="icon-rating full-star"></i></span>
				<span class="star"><i class="icon-rating half-star"></i></span>
				<span class="star"><i class="icon-rating empty-star"></i></span>
				<span class="star"><i class="icon-rating empty-star"></i></span>
				';

	            if($is_label) {
		            $output .= '<span class="label bg-success">'.esc_html__('Average', 'houzez').'</span>';
		        }

		} elseif($stars >= 3 && $stars < 3.5 ) {
			$output = '
				<span class="star"><i class="icon-rating full-star"></i></span>
				<span class="star"><i class="icon-rating full-star"></i></span>
				<span class="star"><i class="icon-rating full-star"></i></span>
				<span class="star"><i class="icon-rating empty-star"></i></span>
				<span class="star"><i class="icon-rating empty-star"></i></span>
				';

	            if($is_label) {
		            $output .= '<span class="label bg-success">'.esc_html__('Average', 'houzez').'</span>';
		        }

		} elseif($stars >= 3.5 && $stars < 4 ) {
			$output = '
				<span class="star"><i class="icon-rating full-star"></i></span>
				<span class="star"><i class="icon-rating full-star"></i></span>
				<span class="star"><i class="icon-rating full-star"></i></span>
				<span class="star"><i class="icon-rating half-star"></i></span>
				<span class="star"><i class="icon-rating empty-star"></i></span>
				';

	            if($is_label) {
		            $output .= '<span class="label bg-success">'.esc_html__('Good', 'houzez').'</span>';
		        }

		} elseif($stars >= 4 && $stars < 4.5) {
			$output = '
				<span class="star"><i class="icon-rating full-star"></i></span>
				<span class="star"><i class="icon-rating full-star"></i></span>
				<span class="star"><i class="icon-rating full-star"></i></span>
				<span class="star"><i class="icon-rating full-star"></i></span>
				<span class="star"><i class="icon-rating empty-star"></i></span>
				';

	            if($is_label) {
		            $output .= '<span class="label bg-success">'.esc_html__('Good', 'houzez').'</span>';
		        }

		}  elseif($stars >= 4.5 && $stars < 5) {
			$output = '
				<span class="star"><i class="icon-rating full-star"></i></span>
				<span class="star"><i class="icon-rating full-star"></i></span>
				<span class="star"><i class="icon-rating full-star"></i></span>
				<span class="star"><i class="icon-rating full-star"></i></span>
				<span class="star"><i class="icon-rating half-star"></i></span>
				';

	            if($is_label) {
		            $output .= '<span class="label bg-success">'.esc_html__('Exceptional', 'houzez').'</span>';
		        }

		} elseif($stars == 5) {
			$output = '
				<span class="star"><i class="icon-rating full-star"></i></span>
				<span class="star"><i class="icon-rating full-star"></i></span>
				<span class="star"><i class="icon-rating full-star"></i></span>
				<span class="star"><i class="icon-rating full-star"></i></span>
				<span class="star"><i class="icon-rating full-star"></i></span>
				';

	            if($is_label) {
		            $output .= '<span class="label bg-success">'.esc_html__('Exceptional', 'houzez').'</span>';
		        }
		}

		return $output;

	}
}