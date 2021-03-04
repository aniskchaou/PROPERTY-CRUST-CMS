<?php

add_filter( 'houzez_online_users', 'houzez_online_users_filter' );

if ( !function_exists( 'houzez_online_users_filter' ) ) {

	function houzez_online_users_filter() {

		if ( ( $logged_in_users = get_transient( 'users_online' ) ) === false ) $logged_in_users = array();
		
		$users_by_role = array( 'agents' => 0, 'buyers' => 0, 'agency' => 0, 'seller' => 0, 'owner' => 0, 'manager' => 0, 'total' => sizeof( $logged_in_users ) );

		if ( sizeof( $logged_in_users ) != 0 ) {
		
			foreach ( $logged_in_users as $userID => $last_login ) {

				$user_info = get_userdata( $userID );

                if ($user_info->roles[0] != 'administrator') {

                    if ($user_info->roles[0] == 'houzez_agent') {

                        $users_by_role['agents']++;

                    } elseif($user_info->roles[0] == 'houzez_buyer') {

                        $users_by_role['buyers']++;

                    } elseif($user_info->roles[0] == 'houzez_agency') {

                        $users_by_role['agency']++;

                    } elseif($user_info->roles[0] == 'houzez_seller') {

                        $users_by_role['seller']++;

                    } elseif($user_info->roles[0] == 'houzez_owner') {

                        $users_by_role['owner']++;

                    } elseif($user_info->roles[0] == 'houzez_manager') {

                        $users_by_role['manager']++;

                    }
                }
			
			}
		
		}
		
		return $users_by_role;

	}

}

add_filter( 'houzez_today_views', 'houzez_today_views_filter' );

if ( !function_exists( 'houzez_today_views_filter' ) ) {

	function houzez_today_views_filter() {

		global $wpdb;

		$total_views = 0;
		$meta_tabel = $wpdb->prefix .'postmeta';
		$posts_views = $wpdb->get_results( "SELECT `meta_value` FROM $meta_tabel WHERE meta_key = 'houzez_views_by_date'" );

		$today_date = date("m-d-Y");

		foreach ( $posts_views as $views ) {

			$views = unserialize( $views->meta_value );

			if ( isset( $views[ $today_date ] ) ) {
				$total_views += $views[ $today_date ];
			}

		}

		return $total_views;

	}

}

add_filter( 'houzez_most_favourite_properties', 'houzez_most_favourite_properties_filter' );

if ( !function_exists( 'houzez_most_favourite_properties_filter' ) ) {

	function houzez_most_favourite_properties_filter() {

		global $wpdb;

		$properties = Array ();
		$_properties = Array ();
		$meta_tabel = $wpdb->prefix .'options';
		$favorites_posts = $wpdb->get_results( "SELECT `option_value` FROM $meta_tabel WHERE option_name LIKE 'houzez_favorites-%' ORDER BY option_id ASC LIMIT 50" );

		foreach ( $favorites_posts as $favorites ) {

			$posts = unserialize( $favorites->option_value );

			foreach ( $posts as $post => $postID ) {

				if ( isset( $_properties[ $postID ] ) ) {
					$_properties[ $postID ]++;
				} else {
					$_properties[ $postID ] = 1;
				}

			}

		}

		arsort( $_properties );
		$i = 0;

		foreach ( $_properties as $key => $value ) {

			$properties[ $key ] = $value;
			$i++;
			if ( $i == 10 ) {
				break;
			}

		}

		return $properties;

	}

}

add_filter( 'houzez_save_user_search', 'houzez_save_search_meta_filter', 3, 9 );

if ( !function_exists( 'houzez_save_search_filter' ) ) {

	function houzez_save_search_meta_filter( $type, $name, $value ) {
	
		$name = 'houzez_search_' . $type . '_' . $name . '__' . $value;
	
		if ( get_option( $name ) !== false ) {

			$option_value = get_option( $name );
			$option_value++;

			update_option( $name, $option_value );

		} else {

			add_option( $name, 1 );

		}

	}

}


add_filter( 'houzez_save_search_get_data', 'houzez_save_search_get_data_filter', 2, 9 );

if ( !function_exists( 'houzez_save_search_get_data_filter' ) ) {

	function houzez_save_search_get_data_filter( $type, $name ) {

		global $wpdb;
	
		$name = 'houzez_search_' . $type . '_' . $name . '__';
		$meta_tabel = $wpdb->prefix .'options';
		$get_meta = $wpdb->get_row( "SELECT * FROM $meta_tabel WHERE option_name LIKE '$name%' ORDER BY option_value DESC" );
	
		if ( isset( $get_meta->option_name ) ) {
			$value = explode( '__', $get_meta->option_name );
			return $value[1];
		} else {
			return '';
		}

	}

}