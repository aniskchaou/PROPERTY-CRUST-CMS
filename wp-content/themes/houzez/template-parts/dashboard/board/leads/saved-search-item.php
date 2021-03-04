<?php
global $houzez_search_data;
$datetime = $houzez_search_data->time; 
$datetime_unix = strtotime($datetime);
$get_date = houzez_return_formatted_date($datetime_unix);
$get_time = houzez_get_formatted_time($datetime_unix);

$search_args = $houzez_search_data->query;
$search_args_decoded = unserialize( base64_decode( $search_args ) );
$search_uri = $houzez_search_data->url;
$search_page = houzez_get_template_link('template/template-search.php');
$search_link = $search_page.'/?'.$search_uri;
$explode_qry = explode('&', $search_uri);

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

?>
<tr>
	
	<td data-label="<?php esc_html_e('Search Parameters', 'houzez'); ?>">
        <?php 
        if( isset( $search_args_decoded['tax_query'] ) ) {
            foreach ($search_args_decoded['tax_query'] as $key => $val):

                if (isset($val['taxonomy']) && isset($val['terms']) && $val['taxonomy'] == 'property_status') {
                    $status = hz_saved_search_term($val['terms'], 'property_status');
                    if (!empty($status)) {
                        echo '<strong>' . esc_html__('Status', 'houzez') . ':</strong> ' . esc_attr( $status ). ' / ';
                    }
                }
                if (isset($val['taxonomy']) && isset($val['terms']) && $val['taxonomy'] == 'property_type') {
                    $types = hz_saved_search_term($val['terms'], 'property_type');
                    if (!empty($types)) {
                        echo '<strong>' . esc_html__('Type', 'houzez') . ':</strong> ' . esc_attr( $types ). ' / ';
                    }
                }
                if (isset($val['taxonomy']) && isset($val['terms']) && $val['taxonomy'] == 'property_city') {
                    $cities = hz_saved_search_term($val['terms'], 'property_city');
                    if (!empty($cities)) {
                        echo '<strong>' . esc_html__('City', 'houzez') . ':</strong> ' . esc_attr( $cities ). ' / ';
                    }
                }

                if (isset($val['taxonomy']) && isset($val['terms']) && $val['taxonomy'] == 'property_state') {
                    $state = hz_saved_search_term($val['terms'], 'property_state');
                    if (!empty($state)) {
                        echo '<strong>' . esc_html__('State', 'houzez') . ':</strong> ' . esc_attr( $state ). ' / ';
                    }
                }

                if (isset($val['taxonomy']) && isset($val['terms']) && $val['taxonomy'] == 'property_area') {
                    $area = hz_saved_search_term($val['terms'], 'property_area');
                    if (!empty($area)) {
                        echo '<strong>' . esc_html__('Area', 'houzez') . ':</strong> ' . esc_attr( $area ). ' / ';
                    }
                }

                if (isset($val['taxonomy']) && isset($val['terms']) && $val['taxonomy'] == 'property_label') {
                    $label = hz_saved_search_term($val['terms'], 'property_label');
                    if (!empty($label)) {
                        echo '<strong>' . esc_html__('Label', 'houzez') . ':</strong> ' . esc_attr( $area ). ' / ';
                    }
                }

            endforeach;
        }

        if( isset( $meta_query ) && sizeof( $meta_query ) !== 0 ) {
            foreach ( $meta_query as $key => $val ) :

                if (isset($val['key']) && $val['key'] == 'fave_property_bedrooms') {
                    
                    echo '<strong>' . esc_html__('Bedrooms', 'houzez') . ':</strong> ' . esc_attr( $val['value'] ). ' / ';
                }

                if (isset($val['key']) && $val['key'] == 'fave_property_bathrooms') {
                    
                    echo '<strong>' . esc_html__('Bathrooms', 'houzez') . ':</strong> ' . esc_attr( $val['value'] ). ' / ';
                }

                if (isset($val['key']) && $val['key'] == 'fave_property_price') {
                    if ( isset( $val['value'] ) && is_array( $val['value'] ) ) :
                        $user_args['min-price'] = $val['value'][0];
                        $user_args['max-price'] = $val['value'][1];
                        echo '<strong>' . esc_html__('Price', 'houzez') . ':</strong> ' . esc_attr( $val['value'][0] ).' - '.esc_attr( $val['value'][1]). ' / ';
                    else :
                        $user_args['max-price'] = $val['value'];
                        echo '<strong>' . esc_html__('Price', 'houzez') . ':</strong> ' . esc_attr( $val['value'] ).' / ';
                    endif;
                }

                if (isset($val['key']) && $val['key'] == 'fave_property_size') {
                    if ( isset( $val['value'] ) && is_array( $val['value'] ) ) :
                        $user_args['min-area'] = $val['value'][0];
                        $user_args['max-area'] = $val['value'][1];
                        echo '<strong>' . esc_html__('Size', 'houzez') . ':</strong> ' . esc_attr( $val['value'][0] ).' - '.esc_attr( $val['value'][1]). ' / ';
                    else :
                        $user_args['max-area'] = $val['value'];
                        echo '<strong>' . esc_html__('Size', 'houzez') . ':</strong> ' . esc_attr( $val['value'] ).' / ';
                    endif;
                }


            endforeach;
        }
         ?>
    </td>
    <td>
    	<a target="_blank" href="<?php echo esc_url($search_link); ?>"><?php esc_html_e('View', 'houzez'); ?></a>
    </td>
	<td class="table-nowrap" data-label="<?php esc_html_e('Date', 'houzez'); ?>">
		<?php echo esc_attr($get_date); ?><br>
        <?php echo esc_html__('at', 'houzez'); ?> <?php echo esc_attr($get_time); ?>
	</td>
</tr>