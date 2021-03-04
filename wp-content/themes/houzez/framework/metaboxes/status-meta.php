<?php
/* Add metaboxes to property status */

if ( !function_exists( 'houzez_property_status_add_meta_fields' ) ) :
	function houzez_property_status_add_meta_fields() {
		$houzez_meta = houzez_get_property_status_meta();
?>

	<div class="form-field">
		 <label for="Color"><?php _e( 'Global Color', 'houzez'); ?></label><br/>
		 <label><input type="radio" name="fave[color_type]" value="inherit" class="fave-radio color-type" <?php checked( $houzez_meta['color_type'], 'inherit' );?>> <?php _e( 'Inherit from default accent color', 'houzez' ); ?></label>
		 <label><input type="radio" name="fave[color_type]" value="custom" class="fave-radio color-type" <?php checked( $houzez_meta['color_type'], 'custom' );?>> <?php _e( 'Custom', 'houzez' ); ?></label>
		 <div id="fave_color_wrap">
		 <p>
		   	<input name="fave[color]" type="text" class="fave_colorpicker" value="<?php echo $houzez_meta['color']; ?>" data-default-color="<?php echo $houzez_meta['color']; ?>"/>
		 </p>
		 <?php if ( !empty( $colors ) ) { echo $colors; } ?>
		 </div>
		 <div class="clear"></div>
		 <p class="howto"><?php _e( 'Choose color', 'houzez' ); ?></p>
	</div>
	<?php
	}
endif;

add_action( 'property_status_add_form_fields', 'houzez_property_status_add_meta_fields', 10, 2 );


/**
*   ----------------------------------------------------------------------------------------------------------------------------------------------------
*   2.0 - Edit Category meta field
*   ----------------------------------------------------------------------------------------------------------------------------------------------------
*/

if ( !function_exists( 'houzez_property_status_edit_meta_fields' ) ) :
	function houzez_property_status_edit_meta_fields( $term ) {
		$houzez_meta = houzez_get_property_status_meta( $term->term_id );
?>
	  <?php

		$most_used = get_option( 'houzez_recent_colors' );

		$colors = '';

		if ( !empty( $most_used ) ) {
			$colors .= '<p>'.__( 'Recently used', 'houzez' ).': <br/>';
			foreach ( $most_used as $color ) {
				$colors .= '<a href="#" style="width: 20px; height: 20px; background: '.$color.'; float: left; margin-right:3px; border: 1px solid #aaa;" class="fave_colorpick" data-color="'.$color.'"></a>';
			}
			$colors .= '</p>';
		}

	?>

	 <tr class="form-field">
		<th scope="row" valign="top"><label><?php _e( 'Color', 'houzez' ); ?></label></th>
			<td>
				<label><input type="radio" name="fave[color_type]" value="inherit" class="fave-radio color-type" <?php checked( $houzez_meta['color_type'], 'inherit' );?>> <?php _e( 'Inherit from default accent color', 'houzez' ); ?></label> <br/>
				<label><input type="radio" name="fave[color_type]" value="custom" class="fave-radio color-type" <?php checked( $houzez_meta['color_type'], 'custom' );?>> <?php _e( 'Custom', 'houzez' ); ?></label>
			  <div id="fave_color_wrap">
			  <p>
			    	<input name="fave[color]" type="text" class="fave_colorpicker" value="<?php echo $houzez_meta['color']; ?>" data-default-color="<?php echo $houzez_meta['color']; ?>"/>
			  </p>
			  <?php if ( !empty( $colors ) ) { echo $colors; } ?>
				</div>
				<div class="clear"></div>
				<p class="howto"><?php _e( 'Choose color', 'houzez' ); ?></p>
			</td>
		</tr>

	<?php
	}
endif;

add_action( 'property_status_edit_form_fields', 'houzez_property_status_edit_meta_fields', 10, 2 );