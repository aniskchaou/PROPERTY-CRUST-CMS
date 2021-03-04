<?php
global $ele_settings;

$data_column_class = isset($ele_settings['data_columns']) && !empty($ele_settings['data_columns']) ? $ele_settings['data_columns'] : houzez_option('prop_features_cols', 'list-3-cols');

?>
<ul class="<?php echo esc_attr($data_column_class); ?> list-unstyled">
	<?php
    
    $features_icons = houzez_option('features_icons');
	global $features;
    if (!empty($features)):
        foreach ($features as $term):
            $term_link = get_term_link($term, 'property_feature');
            if (is_wp_error($term_link))
                continue;

            $feature_icon = '';
            $icon_type = get_term_meta($term->term_id, 'fave_feature_icon_type', true);
            $icon_class = get_term_meta($term->term_id, 'fave_prop_features_icon', true);
            $img_icon = get_term_meta($term->term_id, 'fave_feature_img_icon', true);

            $feature_icon = '';
            if($icon_type == 'custom') {
            	$icon_url = wp_get_attachment_url( $img_icon );
            	if(!empty($icon_url)) {
                	$feature_icon = '<img src="'.esc_url($icon_url).'" class="mr-2">';
                }
            } else {
            	if(!empty($icon_class))
            	$feature_icon = '<i class="'.$icon_class.' mr-2"></i>';
            }

            if( !empty($feature_icon) ) {
                echo '<li>'.$feature_icon.'<a href="' . esc_url($term_link) . '">' . esc_attr($term->name) . '</a></li>';
            } else {
                echo '<li><i class="houzez-icon icon-check-circle-1 mr-2"></i><a href="' . esc_url($term_link) . '">' . esc_attr($term->name) . '</a></li>';
            }
        endforeach;
    endif;
    ?>
</ul>