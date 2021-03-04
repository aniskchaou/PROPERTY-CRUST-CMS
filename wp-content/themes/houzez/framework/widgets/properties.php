<?php
/*
 * Widget Name: Featured Properties
 * Version: 1.0
 * Author: Waqas Riaz
 * Author URI: http://favethemes.com/
 */

class HOUZEZ_properties extends WP_Widget {

	/**
	 * Register widget
	 **/
	public function __construct() {

		parent::__construct(
			'houzez_properties', // Base ID
			esc_html__( 'HOUZEZ: Properties', 'houzez' ), // Name
			array( 'description' => esc_html__( 'Show properties', 'houzez' ), ) // Args
		);

	}


	/**
	 * Front-end display of widget
	 **/
	public function widget( $args, $instance ) {

		global $before_widget, $after_widget, $before_title, $after_title, $post;
		extract( $args );

		$allowed_html_array = array(
			'div' => array(
				'id' => array(),
				'class' => array()
			),
			'h3' => array(
				'class' => array()
			)
		);

		$title = apply_filters('widget_title', $instance['title'] );
		$items_num = $instance['items_num'];
		$prop_type = isset( $instance['prop_type'] ) ? $instance['prop_type'] : '';
		$prop_status = isset( $instance['prop_status'] ) ? $instance['prop_status'] : '';
		$prop_city = isset( $instance['prop_city'] ) ? $instance['prop_city'] : '';
		$prop_area = isset( $instance['prop_area'] ) ? $instance['prop_area'] : '';
		$prop_state = isset( $instance['prop_state'] ) ? $instance['prop_state'] : '';
		$prop_label = isset( $instance['prop_label'] ) ? $instance['prop_label'] : '';

		echo wp_kses( $before_widget, $allowed_html_array );


		if ( $title ) echo wp_kses( $before_title, $allowed_html_array ) . $title . wp_kses( $after_title, $allowed_html_array );
		?>

		<?php

		$tax_query = array();
		//$property_ids_array = array();

		if (!empty($prop_type)) {
			$tax_query[] = array(
				'taxonomy' => 'property_type',
				'field' => 'slug',
				'terms' => $prop_type
			);
		}
		if (!empty($prop_status)) {
			$tax_query[] = array(
				'taxonomy' => 'property_status',
				'field' => 'slug',
				'terms' => $prop_status
			);
		}
		if (!empty($prop_city)) {
			$tax_query[] = array(
				'taxonomy' => 'property_city',
				'field' => 'slug',
				'terms' => $prop_city
			);
		}
		if (!empty($prop_area)) {
			$tax_query[] = array(
				'taxonomy' => 'property_area',
				'field' => 'slug',
				'terms' => $prop_area
			);
		}
		if (!empty($prop_state)) {
			$tax_query[] = array(
				'taxonomy' => 'property_state',
				'field' => 'slug',
				'terms' => $prop_state
			);
		}
		if (!empty($prop_label)) {
			$tax_query[] = array(
				'taxonomy' => 'property_label',
				'field' => 'slug',
				'terms' => $prop_label
			);
		}

		$tax_count = count( $tax_query );

		if( $tax_count > 1 ) {

			$tax_query['relation'] = 'AND';

		}

		$wp_qry = new WP_Query(
			array(
				'post_type' => 'property',
				'posts_per_page' => $items_num,
				'ignore_sticky_posts' => 1,
				'post_status' => 'publish',
				'tax_query' => $tax_query
			)
		);

		?>


		<div class="widget-body">

			<?php if( $wp_qry->have_posts() ): while( $wp_qry->have_posts() ): $wp_qry->the_post(); ?>

				<div class="property-item-widget">
					<div class="d-flex align-items-start">
						<div class="left-property-item-widget-wrap">
							<?php get_template_part('template-parts/listing/partials/item-image'); ?>
						</div><!-- left-property-item-widget-wrap -->
						<div class="right-property-item-widget-wrap">
							<?php get_template_part('template-parts/listing/partials/item-title'); ?>
							<?php get_template_part('template-parts/listing/partials/item-price'); ?>
							<?php get_template_part('template-parts/listing/partials/item-features-v1'); ?>
						</div><!-- right-property-item-widget-wrap -->
					</div><!-- d-flex -->
				</div><!-- property-item-widget -->

			<?php endwhile; endif; ?>
			<?php wp_reset_postdata(); ?>

		</div>


		<?php
		echo wp_kses( $after_widget, $allowed_html_array );

	}


	/**
	 * Sanitize widget form values as they are saved
	 **/
	public function update( $new_instance, $old_instance ) {

		$instance = array();

		/* Strip tags to remove HTML. For text inputs and textarea. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['items_num'] = strip_tags( $new_instance['items_num'] );
		$instance['prop_type'] = strip_tags( $new_instance['prop_type'] );
		$instance['prop_status'] = strip_tags( $new_instance['prop_status'] );
		$instance['prop_city'] = strip_tags( $new_instance['prop_city'] );
		$instance['prop_area'] = strip_tags( $new_instance['prop_area'] );
		$instance['prop_state'] = strip_tags( $new_instance['prop_state'] );
		$instance['prop_label'] = strip_tags( $new_instance['prop_label'] );

		return $instance;

	}

	/**
	 * Back-end widget form
	 **/
	public function form( $instance ) {

		/* Default widget settings. */
		$defaults = array(
			'title' => 'Properties',
			'prop_status' => '',
			'prop_city' => '',
			'prop_area' => '',
			'prop_state' => '',
			'prop_label' => '',
			'items_num' => '5',
			'prop_type' => ''
		);

		$instance = wp_parse_args( (array) $instance, $defaults );

		$prop_types = houzez_get_property_type_slug_array();
		$prop_status = houzez_get_property_status_slug_array();
		$prop_city = houzez_get_property_city_slug_array();
		$prop_area = houzez_get_property_area_slug_array();

		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e('Title:', 'houzez'); ?></label>
			<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'prop_type' ) ); ?>"><?php esc_html_e('Property Type filter:', 'houzez'); ?></label><br>
			<select id="<?php echo esc_attr( $this->get_field_id( 'prop_type' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'prop_type' ) ); ?>">

				<?php

				foreach ( $prop_types as $key => $value ) :

					echo '<option value="' . $value . '" ' . selected( $instance['prop_type'], $value, true ) . '>' . $key . '</option>';

				endforeach;

				?>

			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'prop_status' ) ); ?>"><?php esc_html_e('Property Status filter:', 'houzez'); ?></label><br>
			<select id="<?php echo esc_attr( $this->get_field_id( 'prop_status' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'prop_status' ) ); ?>">

				<?php

				foreach ( $prop_status as $key => $value ) :

					echo '<option value="' . $value . '" ' . selected( $instance['prop_status'], $value, true ) . '>' . $key . '</option>';

				endforeach;

				?>

			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'prop_city' ) ); ?>"><?php esc_html_e('Property City filter:', 'houzez'); ?></label><br>
			<select id="<?php echo esc_attr( $this->get_field_id( 'prop_city' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'prop_city' ) ); ?>">

				<?php

				foreach ( $prop_city as $key => $value ) :

					echo '<option value="' . $value . '" ' . selected( $instance['prop_city'], $value, true ) . '>' . $key . '</option>';

				endforeach;

				?>

			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'prop_area' ) ); ?>"><?php esc_html_e('Property Area filter:', 'houzez'); ?></label><br>
			<select id="<?php echo esc_attr( $this->get_field_id( 'prop_area' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'prop_area' ) ); ?>">

				<?php

				foreach ( $prop_area as $key => $value ) :

					echo '<option value="' . $value . '" ' . selected( $instance['prop_area'], $value, true ) . '>' . $key . '</option>';

				endforeach;

				?>

			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'prop_state' ) ); ?>"><?php esc_html_e('Property State filter:', 'houzez'); ?></label><br>
			<select id="<?php echo esc_attr( $this->get_field_id( 'prop_state' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'prop_state' ) ); ?>">

				<?php

				echo '<option value="">'.esc_html__(' - All - ', 'houzez').'</option>';

				$prop_state = get_terms (
					array(
						"property_state"
					),
					array(
						'orderby' => 'name',
						'order' => 'ASC',
						'hide_empty' => true,
						'parent' => 0
					)
				);
				houzez_hirarchical_options('property_state', $prop_state, $instance['prop_state'] );

				?>

			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'prop_label' ) ); ?>"><?php esc_html_e('Property Label filter:', 'houzez'); ?></label><br>
			<select id="<?php echo esc_attr( $this->get_field_id( 'prop_label' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'prop_label' ) ); ?>">

				<?php

				echo '<option value="">'.esc_html__(' - All - ', 'houzez').'</option>';

				$prop_label = get_terms (
					array(
						"property_label"
					),
					array(
						'orderby' => 'name',
						'order' => 'ASC',
						'hide_empty' => true,
						'parent' => 0
					)
				);
				houzez_hirarchical_options('property_state', $prop_label, $instance['prop_label'] );

				?>

			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'items_num' ) ); ?>"><?php esc_html_e('Maximum posts to show:', 'houzez'); ?></label>
			<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'items_num' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'items_num' ) ); ?>" value="<?php echo esc_attr( $instance['items_num'] ); ?>" size="1" />
		</p>

		<?php
	}

}

if ( ! function_exists( 'HOUZEZ_properties_loader' ) ) {
	function HOUZEZ_properties_loader (){
		register_widget( 'HOUZEZ_properties' );
	}
	add_action( 'widgets_init', 'HOUZEZ_properties_loader' );
}