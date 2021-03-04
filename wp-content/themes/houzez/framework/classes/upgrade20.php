<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Houzez_upgrade_20' ) ) {
	
	class Houzez_upgrade_20 {


		protected $theme_name = '';

		protected $page_slug;


		protected $page_url;
		
		private static $instance = null;

		
		public static function get_instance() {
			if ( ! self::$instance ) {
				self::$instance = new self;
			}

			return self::$instance;
		}


		
		public function __construct() {
			$this->init_globals();
			$this->init_actions();
		}

		
		
		
		public function init_globals() {
			$this->page_slug       = 'houzez-upgrade-20';
			$this->page_url = 'themes.php?page=' . $this->page_slug;
		}
		
		public function init_actions() {

			if( ! get_option( 'houzez_20_db_updated' ) ) {
				add_action( 'admin_menu', array( $this, 'admin_menus' ) );
			}
			add_action( 'admin_init', array( $this, 'upgrade_wizard' ), 30 );	
			add_action( 'admin_init', array( $this, 'admin_redirect' ), 30 );
			add_action( 'admin_init', array( $this, 'houzez_update_bd'), 30 );	
		
		}

		public function admin_redirect() {
			global $pagenow;

			if ( is_admin() && 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {

				$already_using = get_option( 'houzez_activation');
				$upgrated = get_option( 'houzez_20_db_updated' );
				if( $already_using == 'activated' && !$upgrated ) {
					wp_redirect(admin_url("themes.php?page=houzez-upgrade-20"));
				}
				
			}
		}

	    public function houzez_update_bd() {

	        if ( isset( $_REQUEST['houzez_update_bd'] ) && $_REQUEST['houzez_update_bd'] == true ) :

	            $this->houzez_make_upgrade();

	        	update_option( 'houzez_20_db_updated', true );
	            header( 'Location: ' . admin_url() );

	        endif;

	    }
		

		/**
		 * Add admin menus/screens.
		 */
		public function admin_menus() {

			add_theme_page( esc_html__( 'Upgrade 2.0', 'houzez' ), esc_html__( 'Upgrade 2.0', 'houzez' ), 'manage_options', $this->page_slug, array(
					$this,
					'upgrade_wizard',
				) );

		}



		/**
		 * Show the Upgrade 2.0
		 */
		public function upgrade_wizard() {
			if ( empty( $_GET['page'] ) || $this->page_slug !== $_GET['page'] ) {
				return;
			}
			$update_url     = add_query_arg( array(
	            'houzez_update_bd' => 'true'
	        ), admin_url() );

	        ?>
	        <!DOCTYPE html>
			<html lang="en">
			<head>

			    <title>Houzez v.2.0</title>
			    <!-- meta tags -->
			    <meta charset="UTF-8">
			    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
			    <meta name="keywords" content="Houzez">
			    <meta name="description" content="Houzez Highly Customizable Real Estate WordPress Theme">
			    <meta name="author" content="Favethemes">

			    <style type="text/css">
			        body {
			            font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
			            font-size: 16px;
			            line-height: 1.5;
			        }
			        ul, li {
			            list-style: none;
			        }
			        table {
			            border-collapse: collapse;
			            background-color: #fff;
			        }
			        table td {
			            padding: 10px;
			            border-bottom: 1px solid #ccc;
			        }
			        ul li {
			            display: inline-block;
			            padding-right: 5px;
			        }
			        h1 {

			        }
			        .wrap {
			            text-align: center;
			            max-width: 360px;
			            margin: 0 auto;
			        }
			        .alert {
			            color: #155724;
			            background-color: #d4edda;
			            border-color: #c3e6cb;
			            position: relative;
			            padding: 20px;
			            margin-bottom: 1rem;
			            border-radius: .25rem;
			            font-size: 19px;
			        }
			        .btn {
			            display: inline-block;
			            width: 100%;
			            font-weight: 400;
			            text-align: center;
			            white-space: nowrap;
			            vertical-align: middle;
			            border: 1px solid transparent;
			            padding: 10px 0;
			            font-size: 1rem;
			            line-height: 1.5;
			            border-radius: .25rem;
			            color: #fff;
			            background-color: #28a745;
			            border-color: #28a745;
			            text-decoration: none;
			        }
			    </style>
			</head>

			<body>

			    <div class="wrap">
			        <h2>Database Update</h2>
			        <div class="alert">
			            It's mandatory to updated the database in order to use Houzez 2.0<br/>
			            <span style="color:red; font-size: 12px;">Make sure you have updated houzez-theme-functionality plugin
			            	<a target="_blank" href="?page=tgmpa-install-plugins">click for update plugin</a>
			            </span>
			        </div>
			        <a class="btn" href="<?php echo esc_url( $update_url ); ?>">Click Here To Update</a>
			    </div>



			</body>

			</html>
	        <?php
			exit;
		}

		public function houzez_make_upgrade() {
			
			$this->setup_pages();
			$this->setup_taxonomies();
			$this->setup_properties_country();
			$this->setup_taxonomies_images();
			$this->setup_users20();
		}

		public function setup_pages() {
			$args = array(
			    'post_type' => 'page',
			    'posts_per_page' => -1,
			    'post_status' => 'publish'
			);

			$pages_query = new WP_Query( $args );
            if ( $pages_query->have_posts() ) :
                while ( $pages_query->have_posts() ) : $pages_query->the_post();

                    $template = get_post_meta( get_the_ID(), '_wp_page_template', true ); 
                    $default_view = get_post_meta( get_the_ID(), 'fave_default_view', true ); 
                    $header_full_screen = get_post_meta( get_the_ID(), 'fave_header_full_screen', true ); 
                    $header_search = get_post_meta( get_the_ID(), 'fave_page_header_search', true ); 


                	//Update templates
                    if( $template == 'template/property-listing-template.php' && $default_view == 'list_view' ) {
                    	update_post_meta( get_the_ID(), '_wp_page_template', 'template/template-listing-list-v1.php' );

                    } elseif( $template == 'template/property-listing-fullwidth.php' && $default_view == 'list_view' ) {
                    	update_post_meta( get_the_ID(), '_wp_page_template', 'template/template-listing-list-v1-fullwidth.php' );

                    } elseif( $template == 'template/property-listing-template-style2.php' && $default_view == 'list_view' ) {
                    	update_post_meta( get_the_ID(), '_wp_page_template', 'template/template-listing-list-v2.php' );

                    } elseif( $template == 'template/property-listing-style2-fullwidth.php' && $default_view == 'list_view' ) {
                    	update_post_meta( get_the_ID(), '_wp_page_template', 'template/template-listing-list-v2-fullwidth.php' );

                    } elseif( $template == 'template/property-listing-template.php' && $default_view == 'grid_view' ) {
                    	update_post_meta( get_the_ID(), '_wp_page_template', 'template/template-listing-grid-v1.php' );

                    } elseif( $template == 'template/property-listing-fullwidth.php' && $default_view == 'grid_view' ) {
                    	update_post_meta( get_the_ID(), '_wp_page_template', 'template/template-listing-grid-v1-fullwidth-2cols.php' );

                    } elseif( $template == 'template/property-listing-fullwidth.php' && $default_view == 'grid_view_3_col' ) {
                    	update_post_meta( get_the_ID(), '_wp_page_template', 'template/template-listing-grid-v1-fullwidth-3cols.php' );

                    } elseif( $template == 'template/property-listing-template-style2.php' && $default_view == 'grid_view' ) {
                    	update_post_meta( get_the_ID(), '_wp_page_template', 'template/template-listing-grid-v2.php' );

                    } elseif( $template == 'template/property-listing-style2-fullwidth.php' && $default_view == 'grid_view' ) {
                    	update_post_meta( get_the_ID(), '_wp_page_template', 'template/template-listing-grid-v2-fullwidth-2cols.php' );

                    } elseif( $template == 'template/property-listing-style2-fullwidth.php' && $default_view == 'grid_view_3_col' ) {
                    	update_post_meta( get_the_ID(), '_wp_page_template', 'template/template-listing-grid-v2-fullwidth-3cols.php' );

                    } elseif( $template == 'template/property-listing-template-style3.php') {
                    	update_post_meta( get_the_ID(), '_wp_page_template', 'template/template-listing-grid-v3.php' );

                    } elseif( $template == 'template/property-listing-template-style3-fullwidth.php') {
                    	update_post_meta( get_the_ID(), '_wp_page_template', 'template/template-listing-grid-v3-fullwidth-3cols.php' );

                    } elseif( $template == 'template/submit_property.php') {
                    	update_post_meta( get_the_ID(), '_wp_page_template', 'template/user_dashboard_submit.php' );

                    } 

                    //Update page header settings
                    if($header_full_screen == 'no') {
                    	update_post_meta( get_the_ID(), 'fave_header_full_screen', 0 );
                    } elseif($header_full_screen == 'yes') {
                    	update_post_meta( get_the_ID(), 'fave_header_full_screen', 1 );
                    }

                    if($header_search == 'no') {
                    	update_post_meta( get_the_ID(), 'fave_page_header_search', 0 );
                    } elseif($header_search == 'yes') {
                    	update_post_meta( get_the_ID(), 'fave_page_header_search', 1 );
                    }


                endwhile;
        
            endif;
            wp_reset_postdata();
		}

		public function setup_properties_country() {
			$args = array(
			    'post_type' => 'property',
			    'posts_per_page' => -1,
			    'post_status' => 'publish'
			);

			$listing_query = new WP_Query( $args );
            if ( $listing_query->have_posts() ) :
                while ( $listing_query->have_posts() ) : $listing_query->the_post();

                    $country_code = get_post_meta( get_the_ID(), 'fave_property_country', true ); 
                    
                    if(!empty($country_code)) {
	                    $country = houzez_country_code_to_country($country_code);
	                    wp_set_object_terms( get_the_ID(), $country, 'property_country' );
	                }

                endwhile;
        
            endif;
            wp_reset_postdata();
		}

		public function setup_taxonomies() {
			$taxonomies = get_terms( array(
			    'taxonomy' => 'property_state',
			    'hide_empty' => false
			) );
			 
			if ( !empty($taxonomies) ) :
			    
			    foreach( $taxonomies as $category ) {
			    	$term_id = $category->term_id;

			        $term_meta= get_option( "_houzez_property_state_$term_id");
			        $country_code = esc_attr($term_meta['parent_country']);

			        if(!empty($country_code)) {
			            $country = houzez_country_code_to_country($country_code);
			            
			            $inserted_term = wp_insert_term( $country, 'property_country' );

			            if( is_wp_error($inserted_term) ) {
				            $new_term_id = $inserted_term->error_data['term_exists'];
				        } else {
				        	$new_term_id = $inserted_term['term_id'];
				        }

			            $term = get_term( $new_term_id, 'property_country' );
						$slug = $term->slug;

						$houzez_meta = array();

			            $houzez_meta['parent_country'] = isset( $slug ) ? $slug : '';

			            update_option( '_houzez_property_state_'.$term_id, $houzez_meta );
			        }
			    }
			    
			endif;
		}

		public function setup_users20() {
			$blogusers = get_users( [ 'role__in' => [ 'houzez_agent', 'houzez_agency', 'houzez_seller', 'houzez_owner' ] ] );
			foreach ( $blogusers as $user ) {
			   $user->add_cap('level_2');
			}
		}

		public function setup_taxonomies_images() {
			$taxonomies = get_terms(
				array(
					'hide_empty' => false,
				)
			);
			 
			if ( !empty($taxonomies) ) :
			  
			    foreach( $taxonomies as $category ) {
			        $term_id = $category->term_id;
			        $option_name = 'tax_meta_'.$term_id;
			        $option = get_option($option_name);

			        if( !empty($option) ) {
			        	$attachment_id = $option['fave_prop_type_image']['id'];
			        	add_term_meta( $term_id, "fave_taxonomy_img" , $attachment_id, true );

			        	$marker_id = $option['fave_prop_type_icon']['id'];
			        	$marker_retina_id = $option['fave_prop_type_icon_retina']['id'];
			        	if(!empty($marker_id)) {
			        		add_term_meta( $term_id, "fave_marker_icon" , $marker_id, true );
			        	}
			        	if(!empty($marker_retina_id)) {
			        		add_term_meta( $term_id, "fave_marker_retina_icon" , $marker_retina_id, true );
			        	}
			        }
			        delete_option($option_name);
			     
			    }	
			    
			endif;
		}

	}

}// if !class_exists

/**
 * Loads the main instance of Houzez_upgrade_20 to have
 * ability extend class functionality
 *
 * @since 1.1.1
 * @return object Houzez_upgrade_20
 */
add_action( 'after_setup_theme', 'Houzez_upgrade_20', 10 );
if ( ! function_exists( 'Houzez_upgrade_20' ) ) :
	function Houzez_upgrade_20() {
		Houzez_upgrade_20::get_instance();
	}
endif;
