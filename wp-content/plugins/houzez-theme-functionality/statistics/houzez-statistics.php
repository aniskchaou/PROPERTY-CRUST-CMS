<?php

add_action( 'admin_menu', 'houzez_statistics_page' );

if (!function_exists( 'houzez_statistics_page' ) ) {

	function houzez_statistics_page() {

		add_menu_page( esc_html__('Houzez Statistics', 'houzez-theme-functionality'), esc_html__('Houzez Statistics', 'houzez-theme-functionality'), 'manage_options', 'houzez-statistics', 'houzez_statistics_page_View' );
		add_submenu_page( 'houzez-statistics', esc_html__('Most Viewed Properties', 'houzez-theme-functionality'), esc_html__('Most Viewed', 'houzez-theme-functionality'), 'manage_options', 'houzez-statistics-most-viewed', 'houzez_statistics_most_viewed_page_View' );
		add_submenu_page( 'houzez-statistics', esc_html__('Most Favourite Properties', 'houzez-theme-functionality'), esc_html__('Most Favourite', 'houzez-theme-functionality'), 'manage_options', 'houzez-statistics-most-favourite', 'houzez_statistics_most_favourite_page_View' );
		add_submenu_page( 'houzez-statistics', esc_html__('Saved Searches', 'houzez-theme-functionality'), esc_html__('Saved Searches', 'houzez-theme-functionality'), 'manage_options', 'houzez-statistics-saved-searches', 'houzez_statistics_saved_searches_page_View' );
		// add_submenu_page( 'houzez-statistics', esc_html_e('Most Searched Keyword', 'houzez-theme-functionality'), esc_html__('Most Searched Keyword', 'houzez-theme-functionality'), 'manage_options', 'houzez-statistics-most-searched-keyword', 'houzez_statistics_most_searched_keyword_page_View' );
	
	}

}

add_action( 'admin_enqueue_scripts', 'houzez_statistics_scripts' );

if ( !function_exists( 'houzez_statistics_scripts' ) ) {

	function houzez_statistics_scripts( $hook ) {
	
		// if ( $hook == 'toplevel_page_houzez-statistics' ) {
	
			wp_enqueue_style( 'custom_wp_admin_css', plugins_url( 'css/houzez-statistics.css', __FILE__ ) );
		
		// }
	
	}

}

if ( !function_exists( 'houzez_statistics_page_View' ) ) {

	function houzez_statistics_page_View() {
	
		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}
		
		$online_users = apply_filters( 'houzez_online_users', true );
		$today_views = apply_filters( 'houzez_today_views', true );
		
		?>
		<div class="statis-area">
			<h2 class="statis-title"> <?php esc_html_e('Houzez Statistic', 'houzez-theme-functionality'); ?> </h2>
			<div class="statis-block-wrap statis-block-4-col">
				<div class="statis-block-outer">
					<div class="statis-block statis-online-user">
						<h3 class="statis-block-title title-center"> <?php esc_html_e('Total Views Today', 'houzez-theme-functionality'); ?> </h3>
						<ul>
							<li><span class="statis-user-title"><?php esc_html_e('Users', 'houzez-theme-functionality'); ?></span> <span class="statis-user-value"><?php echo $online_users['total']; ?></span></li>
                                <?php if ( $online_users['agents'] != 0 ) { ?>
							<li><span class="statis-user-title"><?php esc_html_e('Agents', 'houzez-theme-functionality'); ?></span> <span class="statis-user-value"><?php echo $online_users['agents']; ?></span></li>
                            <?php } ?>
                            <?php if ( $online_users['buyers'] != 0 ) { ?>
                                <li><span class="statis-user-title"><?php esc_html_e('Buyers', 'houzez-theme-functionality'); ?></span> <span class="statis-user-value"><?php echo $online_users['buyers']; ?></span></li>
                            <?php } ?>
                            <?php if ( $online_users['agency'] != 0 ) { ?>
                                <li><span class="statis-user-title"><?php esc_html_e('Agencies', 'houzez-theme-functionality'); ?></span> <span class="statis-user-value"><?php echo $online_users['agency']; ?></span></li>
                            <?php } ?>
                            <?php if ( $online_users['seller'] != 0 ) { ?>
                                <li><span class="statis-user-title"><?php esc_html_e('Sellers', 'houzez-theme-functionality'); ?></span> <span class="statis-user-value"><?php echo $online_users['seller']; ?></span></li>
                            <?php } ?>
                            <?php if ( $online_users['owner'] != 0 ) { ?>
                                <li><span class="statis-user-title"><?php esc_html_e('Owners', 'houzez-theme-functionality'); ?></span> <span class="statis-user-value"><?php echo $online_users['owner']; ?></span></li>
                            <?php } ?>
                            <?php if ( $online_users['manager'] != 0 ) { ?>
                                <li><span class="statis-user-title"><?php esc_html_e('Managers', 'houzez-theme-functionality'); ?></span> <span class="statis-user-value"><?php echo $online_users['manager']; ?></span></li>
                            <?php } ?>
                        </ul>
					</div>
				</div>
				<div class="statis-block-outer">
					<div class="statis-block statis-block-counter">
						<h3 class="statis-block-title title-center"><?php esc_html_e('Total Views Today', 'houzez-theme-functionality'); ?></h3>
						<h4 class="statis-counter"> <?php echo $today_views; ?> </h4>
					</div>
				</div>
			</div>
		</div>
		<?php
	
	}

}

if ( !function_exists( 'houzez_statistics_most_viewed_page_View' ) ) {

    function houzez_statistics_most_viewed_page_View() {

        if ( !current_user_can( 'manage_options' ) )  {
            wp_die( __( 'You do not have sufficient permissions to access this page.', 'houzez-theme-functionality' ) );
        }
        $args = array(
            'post_type' => 'property',
            'posts_per_page' => 10,
            'order' => 'DESC',
            'meta_key' => 'houzez_total_property_views',
            'orderby'   => 'meta_value_num'
        );

        $properties = new WP_Query( $args );
        ?>
        <div class="wrap">
            <h1 class="wp-heading-inline"><?php esc_html_e('Most Viewed Properties', 'houzez-theme-functionality'); ?> </h1>
            <table class="wp-list-table widefat fixed striped pages">
                <thead>
                <tr>
                    <th scope="col" id="title" class="manage-column column-title column-primary sortable desc">
                        <span><?php esc_html_e('Property Title', 'houzez-theme-functionality'); ?></span>
                    </th>
                    <th scope="col" id="thumbnail" class="manage-column column-thumbnail"><?php esc_html_e('Thumbnail', 'houzez-theme-functionality'); ?></th>
                    <th scope="col" id="city" class="manage-column column-city"><?php esc_html_e('City', 'houzez-theme-functionality'); ?></th>
                    <th scope="col" id="type" class="manage-column column-type"><?php esc_html_e('Type', 'houzez-theme-functionality'); ?></th>
                    <th scope="col" id="status" class="manage-column column-status"><?php esc_html_e('Status', 'houzez-theme-functionality'); ?></th>
                    <th scope="col" id="price" class="manage-column column-price"><?php esc_html_e('Price', 'houzez-theme-functionality'); ?></th>
                    <th scope="col" id="id" class="manage-column column-id"><?php esc_html_e('Property ID', 'houzez-theme-functionality'); ?></th>
                    <th scope="col" id="id" class="manage-column column-id"><?php esc_html_e('Views Count', 'houzez-theme-functionality'); ?></th>
                    <th scope="col" id="houzez_actions" class="manage-column column-houzez_actions"><?php esc_html_e('Actions', 'houzez-theme-functionality'); ?></th>
                </tr>
                </thead>
                <tbody id="the-list">
                <?php
                if ( $properties->have_posts() ) {
                    while ( $properties->have_posts() ) {
                        $properties->the_post();
                        ?>
                        <tr class="iedit author-self level-0 post-1849 type-property status-draft has-post-thumbnail">
                            <td class="title column-title has-row-actions column-primary page-title"
                                data-colname="Property Title">
                                <div class="locked-info">
                                    <span class="locked-avatar"></span>
                                    <span class="locked-text"></span>
                                </div>
                                <strong><?php the_title(); ?></strong>
                            </td>
                            <td class="thumbnail column-thumbnail" data-colname="Thumbnail">
                                <?php
                                if ( has_post_thumbnail() ) {
                                    the_post_thumbnail( 'thumbnail', array(
                                        'class'     => 'attachment-thumbnail attachment-thumbnail-small',
                                    ) );
                                } else {
                                    echo '-';
                                }
                                ?>
                            </td>
                            <td class="city column-city" data-colname="City">
                                <?php echo houzez_statistics_taxonomy_terms ( get_the_ID(), 'property_city', 'property' ); ?>
                            </td>
                            <td class="type column-type" data-colname="Type">
                                <?php echo houzez_statistics_taxonomy_terms ( get_the_ID(), 'property_type', 'property' ); ?>
                            </td>
                            <td class="status column-status" data-colname="Status">
                                <?php echo houzez_statistics_taxonomy_terms ( get_the_ID(), 'property_status', 'property' ); ?>
                            </td>
                            <td class="price column-price" data-colname="Price">
                                <?php houzez_property_price_admin(); ?>
                            </td>
                            <td class="id column-id" data-colname="Property ID">
                                <?php
                                $Prop_id = get_post_meta( get_the_ID(), 'fave_property_id',true );
                                if ( !empty( $Prop_id ) ) {
                                    echo esc_attr( $Prop_id );
                                } else {
                                    _e( 'NA','houzez-theme-functionality' );
                                }
                                ?>
                            </td>
                            <td>
                                <?php echo get_post_meta( get_the_ID(), 'houzez_total_property_views', true ); ?>
                            </td>
                            <td class="houzez_actions column-houzez_actions" data-colname="Actions">
                                <a href="<?php the_permalink(); ?>"><?php esc_html_e('View', 'houzez-theme-functionality'); ?></a>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo '<tr class="no-items"><td class="colspanchange" colspan="12">' . esc_html__('No Property found', 'houzez-theme-functionality') . '</td></tr>';
                }
                ?>
                </tbody>
                <tfoot>
                <tr>
                    <th scope="col" class="manage-column column-title column-primary sortable desc">
                        <span><?php esc_html_e('Property Title', 'houzez-theme-functionality'); ?></span>
                    </th>
                    <th scope="col" class="manage-column column-thumbnail"><?php esc_html_e('Thumbnail', 'houzez-theme-functionality'); ?></th>
                    <th scope="col" class="manage-column column-city"><?php esc_html_e('City', 'houzez-theme-functionality'); ?></th>
                    <th scope="col" class="manage-column column-type"><?php esc_html_e('Type', 'houzez-theme-functionality'); ?></th>
                    <th scope="col" class="manage-column column-status"><?php esc_html_e('Status', 'houzez-theme-functionality'); ?></th>
                    <th scope="col" class="manage-column column-price"><?php esc_html_e('Price', 'houzez-theme-functionality'); ?></th>
                    <th scope="col" class="manage-column column-id"><?php esc_html_e('Property ID', 'houzez-theme-functionality'); ?></th>
                    <th scope="col" id="id" class="manage-column column-id"><?php esc_html_e('Views Count', 'houzez-theme-functionality'); ?></th>
                    <th scope="col" class="manage-column column-houzez_actions"><?php esc_html_e('Actions', 'houzez-theme-functionality'); ?></th>
                </tr>
                </tfoot>
            </table>
        </div>
        <?php

    }

}

if ( !function_exists( 'houzez_statistics_most_favourite_page_View' ) ) {

	function houzez_statistics_most_favourite_page_View() {

		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.', 'houzez-theme-functionality' ) );
		}

        $not_found = false;
		$most_favourite_properties = apply_filters( 'houzez_most_favourite_properties', true );
        if ( empty( $most_favourite_properties ) ) {
            $not_found = true;
        }
		$args = array(
			'post_type' => 'property',
			'fields' => 'ids',
			'post__in' => array_keys( $most_favourite_properties ),
			'orderby' => 'post__in',
			'order' => 'ASC'
		);
		$properties = new WP_Query( $args );
		?>
		<div class="wrap">
			<h1 class="wp-heading-inline"> <?php esc_html_e('Most Favourite Properties', 'houzez-theme-functionality'); ?></h1>
			<table class="wp-list-table widefat fixed striped pages">
				<thead>
					<tr>
						<th scope="col" id="title" class="manage-column column-title column-primary sortable desc">
							<span><?php esc_html_e('Property Title', 'houzez-theme-functionality'); ?></span>
						</th>
						<th scope="col" id="thumbnail" class="manage-column column-thumbnail"><?php esc_html_e('Thumbnail', 'houzez-theme-functionality'); ?></th>
						<th scope="col" id="city" class="manage-column column-city"><?php esc_html_e('City', 'houzez-theme-functionality'); ?></th>
						<th scope="col" id="type" class="manage-column column-type"><?php esc_html_e('Type', 'houzez-theme-functionality'); ?></th>
						<th scope="col" id="status" class="manage-column column-status"><?php esc_html_e('Status', 'houzez-theme-functionality'); ?></th>
						<th scope="col" id="price" class="manage-column column-price"><?php esc_html_e('Price', 'houzez-theme-functionality'); ?></th>
						<th scope="col" id="id" class="manage-column column-id"><?php esc_html_e('Property ID', 'houzez-theme-functionality'); ?></th>
						<th scope="col" id="id" class="manage-column column-id"><?php esc_html_e('Favourite Count ', 'houzez-theme-functionality'); ?></th>
						<th scope="col" id="houzez_actions" class="manage-column column-houzez_actions"><?php esc_html_e('Actions', 'houzez-theme-functionality'); ?></th>
					</tr>
				</thead>
				<tbody id="the-list">

					<?php
					    if ( !$not_found ) {
                            if ($properties->have_posts()) {
                                while ($properties->have_posts()) {
                                    $properties->the_post();
                                    ?>
                                    <tr class="iedit author-self level-0 post-1849 type-property status-draft has-post-thumbnail">
                                        <td class="title column-title has-row-actions column-primary page-title"
                                            data-colname="Property Title">
                                            <div class="locked-info">
                                                <span class="locked-avatar"></span>
                                                <span class="locked-text"></span>
                                            </div>
                                            <strong><?php the_title(); ?></strong>
                                        </td>
                                        <td class="thumbnail column-thumbnail" data-colname="Thumbnail">
                                            <?php
                                            if (has_post_thumbnail()) {
                                                the_post_thumbnail('thumbnail', array(
                                                    'class' => 'attachment-thumbnail attachment-thumbnail-small',
                                                ));
                                            } else {
                                                echo '-';
                                            }
                                            ?>
                                        </td>
                                        <td class="city column-city" data-colname="City">
                                            <?php echo houzez_statistics_taxonomy_terms(get_the_ID(), 'property_city', 'property'); ?>
                                        </td>
                                        <td class="type column-type" data-colname="Type">
                                            <?php echo houzez_statistics_taxonomy_terms(get_the_ID(), 'property_type', 'property'); ?>
                                        </td>
                                        <td class="status column-status" data-colname="Status">
                                            <?php echo houzez_statistics_taxonomy_terms(get_the_ID(), 'property_status', 'property'); ?>
                                        </td>
                                        <td class="price column-price" data-colname="Price">
                                            <?php houzez_property_price_admin(); ?>
                                        </td>
                                        <td class="id column-id" data-colname="Property ID">
                                            <?php
                                            $Prop_id = get_post_meta(get_the_ID(), 'fave_property_id', true);
                                            if (!empty($Prop_id)) {
                                                echo esc_attr($Prop_id);
                                            } else {
                                                _e('NA', 'houzez-theme-functionality');
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo $most_favourite_properties[get_the_ID()]; ?>
                                        </td>
                                        <td class="houzez_actions column-houzez_actions" data-colname="Actions">
                                            <a href="<?php the_permalink(); ?>"><?php esc_html_e('View', 'houzez-theme-functionality'); ?></a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                        } else {
                            echo '<tr class="no-items"><td class="colspanchange" colspan="12">' . esc_html__('No Property found', 'houzez-theme-functionality') . '</td></tr>';
                        }
					?>
				</tbody>
				<tfoot>
					<tr>
						<th scope="col" class="manage-column column-title column-primary sortable desc">
							<span><?php esc_html_e('Property Title', 'houzez-theme-functionality'); ?></span>
						</th>
						<th scope="col" class="manage-column column-thumbnail"><?php esc_html_e('Thumbnail', 'houzez-theme-functionality'); ?></th>
						<th scope="col" class="manage-column column-city"><?php esc_html_e('City', 'houzez-theme-functionality'); ?></th>
						<th scope="col" class="manage-column column-type"><?php esc_html_e('Type', 'houzez-theme-functionality'); ?></th>
						<th scope="col" class="manage-column column-status"><?php esc_html_e('Status', 'houzez-theme-functionality'); ?></th>
						<th scope="col" class="manage-column column-price"><?php esc_html_e('Price', 'houzez-theme-functionality'); ?></th>
						<th scope="col" class="manage-column column-id"><?php esc_html_e('Property ID', 'houzez-theme-functionality'); ?></th>
						<th scope="col" id="id" class="manage-column column-id"><?php esc_html_e('Favourite Count', 'houzez-theme-functionality'); ?></th>
						<th scope="col" class="manage-column column-houzez_actions"><?php esc_html_e('Actions', 'houzez-theme-functionality'); ?></th>
					</tr>
				</tfoot>
			</table>
		</div>
		<?php

	}

}

if ( !function_exists( 'houzez_statistics_saved_searches_page_View' ) ) {

	function houzez_statistics_saved_searches_page_View() {
	
		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.', 'houzez-theme-functionality' ) );
		}

		?>
        <div class="wrap">
            <h1 class="wp-heading-inline"><?php esc_html_e('Saved Searches', 'houzez-theme-functionality'); ?></h1>
            <table class="wp-list-table widefat fixed striped pages">
                <thead>
                <tr>
                    <th scope="col" id="title" class="manage-column column-title column-primary sortable desc">
                        <span><?php esc_html_e('Search Query', 'houzez-theme-functionality'); ?></span>
                    </th>
                    <th scope="col" id="houzez_actions" class="manage-column column-houzez_actions"><?php esc_html_e('Actions', 'houzez-theme-functionality'); ?></th>
                </tr>
                </thead>
                <tbody id="the-list">
                    <?php

                    global $wpdb;

                    $table_name     = $wpdb->prefix . 'houzez_search';
                    $results        = $wpdb->get_results( 'SELECT * FROM ' . $table_name, OBJECT );

                    if ( sizeof( $results ) !== 0 ) {

                        foreach ( $results as $houzez_search_data ) {

                            $search_args = $houzez_search_data->query;

                            $search_args_decoded = unserialize( base64_decode( $search_args ) );
                            $search_uri = $houzez_search_data->url;
                            $search_uri = explode( '/?', $search_uri );
                            $search_uri = $search_uri[0];

                            $user_args = array ();

                            if ( isset( $search_args_decoded['s'] ) && !empty( $search_args_decoded['s'] ) ) {
                                $user_args['keyword'] = $search_args_decoded['s'];
                            }
                            if ( isset( $search_args_decoded['date_query'] ) && is_array( $search_args_decoded['date_query'] ) ) {
                                $search_day = $search_args_decoded['date_query'][2]['day'];
                                $search_month = $search_args_decoded['date_query'][1]['month'];
                                $search_year = $search_args_decoded['date_query'][0]['year'];
                                $user_args['publish_date'] = $search_month . '/' . $search_day . '/' . $search_year;
                            }

                            ?>
                            <tr class="iedit author-self level-0 post-1849 type-property status-draft has-post-thumbnail">
                                <td class="title column-title has-row-actions column-primary page-title"
                                    data-colname="Property Title">
                                    <?php
                                    if( isset( $search_args_decoded['tax_query'] ) ) {
                                        foreach ($search_args_decoded['tax_query'] as $key => $val):

                                            global $user_args;
                                            if (isset($val['taxonomy']) && isset($val['terms']) && $val['taxonomy'] == 'property_city') {
                                                $page = get_term_by('slug', $val['terms'], 'property_city');
                                                $user_args['location'] = $val['terms'];
                                                if (!empty($page)) {
                                                    echo '<strong>' . esc_html__('Location', 'houzez-theme-functionality') . ':</strong> ' . esc_attr( $page->name ). ', ';
                                                }
                                            }

                                            if (isset($val['taxonomy']) && isset($val['terms']) && $val['taxonomy'] == 'property_type') {
                                                $page = get_term_by('slug', $val['terms'], 'property_type');
                                                $user_args['type'] = $val['terms'];
                                                if (!empty($page)) {
                                                    echo '<strong>' . esc_html__('Type', 'houzez-theme-functionality') . ':</strong> ' . esc_attr( $page->name ). ', ';
                                                }
                                            }

                                            if (isset($val['taxonomy']) && isset($val['terms']) && $val['taxonomy'] == 'property_status') {
                                                $page = get_term_by('slug', $val['terms'], 'property_status');
                                                $user_args['status'] = $val['terms'];
                                                if (!empty($page)) {
                                                    echo '<strong>' . esc_html__('Status', 'houzez-theme-functionality') . ':</strong> ' . esc_attr( $page->name ). ', ';
                                                }
                                            }

                                            if (isset($val['taxonomy']) && isset($val['terms']) && $val['taxonomy'] == 'property_area') {
                                                $page = get_term_by('slug', $val['terms'], 'property_area');
                                                $user_args['area'] = $val['terms'];
                                                if (!empty($page)) {
                                                    echo '<strong>' . esc_html__('Neighborhood', 'houzez-theme-functionality') . ':</strong> ' . esc_attr( $page->name ). ', ';
                                                }
                                            }

                                            if (isset($val['taxonomy']) && isset($val['terms']) && $val['taxonomy'] == 'property_state') {
                                                $page = get_term_by('slug', $val['terms'], 'property_state');
                                                $user_args['state'] = $val['terms'];
                                                if (!empty($page)) {
                                                    echo '<strong>' . esc_html__('State', 'houzez-theme-functionality') . ':</strong> ' . esc_attr( $page->name ). ', ';
                                                }
                                            }

                                            if (isset($val['taxonomy']) && isset($val['terms']) && $val['taxonomy'] == 'property_feature') {
                                                $user_args['feature'] = $val['terms'];
                                            }

                                            if (isset($val['taxonomy']) && isset($val['terms']) && $val['taxonomy'] == 'property_label') {
                                                $user_args['label'] = $val['terms'];
                                            }

                                        endforeach;
                                    }

                                    $meta_query     = array();

                                    if ( isset( $search_args_decoded['meta_query'] ) ) :

                                        foreach ( $search_args_decoded['meta_query'] as $key => $value ) :

                                            if ( is_array( $value ) ) :

                                                if ( isset( $value['key'] ) ) :

                                                    $meta_query[] = $value;

                                                else :

                                                    foreach ( $value as $key => $value ) :

                                                        if ( is_array( $value ) ) :

                                                            foreach ( $value as $key => $value ) :

                                                                if ( isset( $value['key'] ) ) :

                                                                    $meta_query[]     = $value;

                                                                endif;

                                                            endforeach;

                                                        endif;

                                                    endforeach;

                                                endif;

                                            endif;

                                        endforeach;

                                    endif;

                                    if( isset( $meta_query ) && sizeof( $meta_query ) !== 0 ) {
                                        foreach ( $meta_query as $key => $val ) :

                                            if (isset($val['key']) && $val['key'] == 'fave_property_bedrooms') {
                                                $user_args['bedrooms'] = esc_attr( $val['value'] );
                                                echo '<strong>' . esc_html__('Bedrooms', 'houzez-theme-functionality') . ':</strong> ' . esc_attr( $val['value'] ). ', ';
                                            }

                                            if (isset($val['key']) && $val['key'] == 'fave_property_bathrooms') {
                                                $user_args['bathrooms'] = esc_attr( $val['value'] );
                                                echo '<strong>' . esc_html__('Bathrooms', 'houzez-theme-functionality') . ':</strong> ' . esc_attr( $val['value'] ). ', ';
                                            }

                                            if (isset($val['key']) && $val['key'] == 'fave_property_price') {
                                                if ( isset( $val['value'] ) && is_array( $val['value'] ) ) :
                                                    $user_args['min_price'] = $val['value'][0];
                                                    $user_args['max_price'] = $val['value'][1];
                                                    echo '<strong>' . esc_html__('Price', 'houzez-theme-functionality') . ':</strong> ' . esc_attr( $val['value'][0] ).' - '.esc_attr( $val['value'][1]). ', ';
                                                else :
                                                    $user_args['min_price'] = $val['value'];
                                                    echo '<strong>' . esc_html__('Price', 'houzez-theme-functionality') . ':</strong> ' . esc_attr( $val['value'] ).', ';
                                                endif;
                                            }

                                            if (isset($val['key']) && $val['key'] == 'fave_property_size') {
                                                if ( isset( $val['value'] ) && is_array( $val['value'] ) ) :
                                                    $user_args['min_area'] = $val['value'][0];
                                                    $user_args['max_area'] = $val['value'][1];
                                                    echo '<strong>' . esc_html__('Size', 'houzez-theme-functionality') . ':</strong> ' . esc_attr( $val['value'][0] ).' - '.esc_attr( $val['value'][1]). ', ';
                                                else :
                                                    $user_args['min_area_area'] = $val['value'];
                                                    echo '<strong>' . esc_html__('Size', 'houzez-theme-functionality') . ':</strong> ' . esc_attr( $val['value'] ).', ';
                                                endif;
                                            }

                                            if (isset($val['key']) && $val['key'] == 'fave_property_id') {
                                                $user_args['property_id'] = $val['value'];
                                            }

                                            if (isset($val['key']) && $val['key'] == 'fave_property_country') {
                                                $user_args['country'] = $val['value'];
                                            }

                                            if (isset($val['key']) && $val['key'] == 'fave_property_country') {
                                                $user_args['country'] = $val['value'];
                                            }

                                        endforeach;
                                    }
                                    ?>
                                </td>
                                <td class="houzez_actions column-houzez_actions" data-colname="Actions">
                                    <a target="_blank" href="<?php echo esc_url( add_query_arg( $user_args, $search_uri ) ); ?>"><?php esc_html_e('View', 'houzez-theme-functionality'); ?></a>
                                </td>
                            </tr>
                            <?php

                        }
                    } else {
                        echo '<tr class="no-items"><td class="colspanchange" colspan="12">' . esc_html__('No Search found', 'houzez-theme-functionality') . '</td></tr>';
                    }
                    ?>

                </tbody>
                <tfoot>
                <tr>
                    <th scope="col" id="title" class="manage-column column-title column-primary sortable desc">
                        <span><?php esc_html_e('Search Query', 'houzez-theme-functionality'); ?></span>
                    </th>
                    <th scope="col" id="houzez_actions" class="manage-column column-houzez_actions"><?php esc_html_e('Actions', 'houzez-theme-functionality'); ?></th>
                </tr>
                </tfoot>
            </table>
        </div>
		<?php
	
	}

}

if ( !function_exists( 'houzez_statistics_most_searched_keyword_page_View' ) ) {

	function houzez_statistics_most_searched_keyword_page_View() {
	
		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.', 'houzez-theme-functionality' ) );
		}
		
		$keywords = Array (
			Array ( 'price', 'min', esc_html__('Min Price', 'houzez-theme-functionality') ),
			Array ( 'price', 'max', esc_html__('Max Price', 'houzez-theme-functionality') ),
			Array ( 'term', 'status', esc_html__('Status', 'houzez-theme-functionality') ),
			Array ( 'term', 'type', esc_html__('Type', 'houzez-theme-functionality') ),
			Array ( 'term', 'location', esc_html__('Location', 'houzez-theme-functionality') ),
			Array ( 'term', 'state', esc_html__('State', 'houzez-theme-functionality') ),
			Array ( 'meta', 'country', esc_html__('Country', 'houzez-theme-functionality') ),
			Array ( 'term', 'area', esc_html__('Area', 'houzez-theme-functionality') ),
			Array ( 'term', 'feature', esc_html__('Feature', 'houzez-theme-functionality') ),
			Array ( 'area', 'max', esc_html__('Max Size', 'houzez-theme-functionality') ),
			Array ( 'area', 'max', esc_html__('Max Size', 'houzez-theme-functionality') ),
			Array ( 'meta', 'bedrooms', esc_html__('Bedroom', 'houzez-theme-functionality') ),
			Array ( 'meta', 'bathroom', esc_html__('Bathroom', 'houzez-theme-functionality') )
		);
		$keyword = apply_filters( 'houzez_save_search_get_data', 'search', 'keyword' );
		
		?>
		<div class="statis-area">
			<h2 class="statis-title"><?php esc_html_e('Houzez Searches', 'houzez-theme-functionality'); ?></h2>
			<?php if ( !empty( $keyword ) ) { ?>
				<div class="statis-block-wrap">
					<div class="statis-block-outer">
						<div class="statis-block static-keyword-block">
							<h3 class="statis-block-title"><?php esc_html_e('Search Keyworks', 'houzez-theme-functionality'); ?></h3>
							<p><?php echo str_replace( '_', ' ', $keyword ); ?></p>
						</div>
					</div>
				</div>
			<?php } ?>
			<div class="statis-block-wrap statis-block-4-col">
				<?php

				foreach ( $keywords as $keyword ) {
					$data = apply_filters( 'houzez_save_search_get_data', $keyword[0], $keyword[1] );
					if ( !empty( $data ) ) {
						?>
						<div class="statis-block-outer">
							<div class="statis-block statis-block-counter">
								<h3 class="statis-block-title title-center"><?php echo $keyword[2]; ?></h3>
								<h4 class="statis-counter"> <?php echo $data; ?> </h4>
							</div>
						</div>
						<?php
					}

				}
				?>
			</div>
		</div>
		<?php
	
	}

}

if ( !function_exists( 'houzez_statistics_taxonomy_terms' ) ) {

	function houzez_statistics_taxonomy_terms( $post_id, $taxonomy, $post_type ) {

        $terms = get_the_terms( $post_id, $taxonomy );

        if ( ! empty ( $terms ) ) {
            $out = array();
            /* Loop through each term, linking to the 'edit posts' page for the specific term. */
            foreach ( $terms as $term ) {
                $out[] = esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, $taxonomy, 'display' ) );
            }
            /* Join the terms, separating them with a comma. */
            return join( ', ', $out );
        }

        return false;
    }
    
}