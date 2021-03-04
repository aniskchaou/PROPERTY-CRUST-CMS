<?php
$features = wp_get_post_terms( get_the_ID(), 'property_feature', array("fields" => "all"));
$features_icons = houzez_option('features_icons');
$additional_features = get_post_meta( get_the_ID(), 'additional_features', true );
$hide_detail = houzez_option('hide_detail_prop_fields');

$fullwidth = false;
$columns = 'list-2-cols';
if(empty($additional_features)) {
	$fullwidth = true;
	$columns = 'list-3-cols';
}

if(!empty($features) || !empty($additional_features)) {
?>
<div class="fw-property-features-wrap fw-property-section-wrap" id="property-features-wrap">
	<div class="d-flex">
		
		<?php if (!empty($features)): ?>
		<div class="block-wrap fw-property-features-left" <?php if($fullwidth) {?> style="width:100%; background-color:#ffffff;" <?php } ?>>
			<div class="block-title-wrap">
				<h2><?php echo houzez_option('sps_features', 'Features'); ?></h2>
			</div><!-- block-title-wrap -->
			<div class="block-content-wrap">
				<ul class="<?php echo esc_attr($columns); ?> list-unstyled">
					<?php
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
			</div><!-- block-content-wrap -->
		</div><!-- block-wrap -->
		<?php endif; ?>

		<?php if(!empty($additional_features)): ?>
		<div class="block-wrap fw-property-features-right">
			<div class="block-title-wrap">
				<h2><?php echo houzez_option('sps_additional_details', 'Additional details'); ?></h2>
			</div><!-- block-title-wrap -->
			<div class="block-content-wrap">
				<ul class="list-2-cols list-unstyled">
					<?php if( !empty( $additional_features ) && $hide_detail['additional_details'] != 1 ) {  ?>
		                <?php
		                foreach( $additional_features as $ad_del ):
		                    echo '<li><strong>'.esc_attr( $ad_del['fave_additional_feature_title'] ).':</strong> <span>'.esc_attr( $ad_del['fave_additional_feature_value'] ).'</span></li>';
		                endforeach;
		                ?>
		            <?php } ?>
				</ul>
			</div><!-- block-content-wrap -->
		</div><!-- block-wrap -->
		<?php endif; ?>

	</div><!-- d-flex -->
</div><!-- fw-property-features-wrap -->
<?php } ?>