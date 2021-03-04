<?php
/**
 * Widget Name: Taxonomies
 * Created by PhpStorm.
 * User: waqasriaz
 * Date: 12/01/16
 * Time: 11:58 PM
 */
class HOUZEZ_property_taxonomies extends WP_Widget {

    /**
     * Register widget
     **/
    public function __construct() {

        parent::__construct(
            'houzez_property_taxonomies', // Base ID
            esc_html__( 'HOUZEZ: Property Taxonomies', 'houzez' ), // Name
            array( 'classname' => 'widget-taxonomy', 'description' => esc_html__( 'Show property type, status, features, cities, states', 'houzez' ), ) // Args
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
        $prop_taxonomy = $instance['taxonomy'];
        $tax_count = $instance['tax_count'];
        $tax_child = $instance['tax_child'];

        if( $tax_count == 'yes' ) { $show_count = true; } else { $show_count = false; }

        if( $tax_child == 'yes' ) { $show_child = true; } else { $show_child = false; }

        echo wp_kses( $before_widget, $allowed_html_array );

        if ( $title ) echo wp_kses( $before_title, $allowed_html_array ) . $title . wp_kses( $after_title, $allowed_html_array );

        echo '<div class="widget-body">';
            houzez_property_taxonomies( $prop_taxonomy, $show_child, $show_count );
        echo '</div>';

        echo wp_kses( $after_widget, $allowed_html_array );
    }


    /**
     * Sanitize widget form values as they are saved
     **/
    public function update( $new_instance, $old_instance ) {

        $instance = array();

        /* Strip tags to remove HTML. For text inputs and textarea. */
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['taxonomy'] = $new_instance['taxonomy'];
        $instance['tax_count'] = $new_instance['tax_count'];
        $instance['tax_child'] = $new_instance['tax_child'];

        return $instance;

    }


    /**
     * Back-end widget form
     **/
    public function form( $instance ) {

        /* Default widget settings. */
        $defaults = array(
            'title' => '',
            'taxonomy' => 'property_type',
            'tax_count' => 'no',
            'tax_child' => 'yes'
        );
        $instance = wp_parse_args( (array) $instance, $defaults );

        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e('Title:', 'houzez'); ?></label>
            <input type="text" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat" />
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'taxonomy' ) ); ?>"><?php esc_html_e( 'Taxonomy', 'houzez' ); ?>
                <select class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'taxonomy' ) ); ?>">
                    
                    <option value="property_type" <?php echo ($instance['taxonomy'] == 'property_type') ? ' selected="selected"' : ''; ?>><?php esc_html_e( 'Property Type', 'houzez' ); ?></option>
                    
                    <option value="property_status" <?php echo ($instance['taxonomy'] == 'property_status') ? ' selected="selected"' : ''; ?>><?php esc_html_e( 'Property Status', 'houzez' ); ?></option>
                    
                    <option value="property_city" <?php echo ($instance['taxonomy'] == 'property_city') ? ' selected="selected"' : ''; ?>><?php esc_html_e( 'Property City', 'houzez' ); ?></option>
                    
                    <option value="property_state" <?php echo ($instance['taxonomy'] == 'property_state') ? ' selected="selected"' : ''; ?>><?php esc_html_e( 'Property State', 'houzez' ); ?></option>
                    
                    <option value="property_label" <?php echo ($instance['taxonomy'] == 'property_label') ? ' selected="selected"' : ''; ?>><?php esc_html_e( 'Property Label', 'houzez' ); ?></option>
                    
                    <option value="property_feature" <?php echo ($instance['taxonomy'] == 'property_feature') ? ' selected="selected"' : ''; ?>><?php esc_html_e( 'Property Feature', 'houzez' ); ?></option>
                    
                    <option value="property_area" <?php echo ($instance['taxonomy'] == 'property_area') ? ' selected="selected"' : ''; ?>><?php esc_html_e( 'Property Neighbourhood', 'houzez' ); ?></option>
                    

                </select>
            </label>
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'tax_count' ) ); ?>"><?php esc_html_e( 'Count', 'houzez' ); ?>
                <select class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'tax_count' ) ); ?>">
                    <option value="yes" <?php echo ($instance['tax_count'] == 'yes') ? ' selected="selected"' : ''; ?>><?php esc_html_e( 'Show Count', 'houzez' ); ?></option>
                    <option value="no" <?php echo ($instance['tax_count'] == 'no') ? ' selected="selected"' : ''; ?>><?php esc_html_e( 'Hide Count', 'houzez' ); ?></option>
                </select>
            </label>
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'tax_child' ) ); ?>"><?php esc_html_e( 'Child', 'houzez' ); ?>
                <select class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'tax_child' ) ); ?>">
                    <option value="no" <?php echo ($instance['tax_child'] == 'no') ? ' selected="selected"' : ''; ?>><?php esc_html_e( 'Hide Child', 'houzez' ); ?></option>
                    <option value="yes" <?php echo ($instance['tax_child'] == 'yes') ? ' selected="selected"' : ''; ?>><?php esc_html_e( 'Show Child', 'houzez' ); ?></option>
                </select>
            </label>
        </p>

        <?php
    }

}

if ( ! function_exists( 'HOUZEZ_property_taxonomies_loader' ) ) {
    function HOUZEZ_property_taxonomies_loader (){
        register_widget( 'HOUZEZ_property_taxonomies' );
    }
    add_action( 'widgets_init', 'HOUZEZ_property_taxonomies_loader' );
}


function houzez_property_taxonomies( $taxonomy, $show_child, $show_count ) {
    $terms = get_terms( $taxonomy , array( 'parent'=> 0 ));
    if( !is_wp_error($terms) ) {
        $count = count($terms);
        if ( $count > 0 ){
            show_hierarchical_property_types( $terms, $taxonomy, $show_child, $show_count );
        }
    }
}

function show_hierarchical_property_types ( $terms, $taxonomy, $show_child, $show_count ) {
    $count = count( $terms );
    if ( $count > 0 ){

        if( $show_child ) {
            echo '<ul>';
        } else {
            echo '<ul class="children">';
        }

        foreach ($terms as $term){
            echo '<li><a href="' . esc_url( get_term_link( $term->slug, $term->taxonomy ) ). '">' . esc_attr( $term->name ) . '</a>';

            if( $show_count ) {
                echo '<span class="cat-count">(' . esc_attr( $term->count ) . ')</span>';
            }

            if( $show_child ) {
                $child_terms = get_terms( $taxonomy, array('parent' => $term->term_id));
                if ($child_terms) {
                    show_hierarchical_property_types( $child_terms, $taxonomy, false, $show_count );
                }
            }
            echo '</li>';
        }
        echo '</ul>';
    }
}