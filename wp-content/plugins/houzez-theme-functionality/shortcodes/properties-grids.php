<?php
/**
 * Properties Grids
 * Created by PhpStorm.
 * User: waqasriaz
 * Date: 07/01/16
 * Time: 1:08 PM
 */
if( !function_exists('houzez_prop_grids') ) {
    function houzez_prop_grids($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'prop_grid_type' => '',
            'property_type' => '',
            'property_status' => '',
            'property_state' => '',
            'property_country' => '',
            'property_city' => '',
            'property_area' => '',
            'property_label' => '',
            'featured_prop' => '',
            'posts_limit' => '',
            'offset' => '',
            'min_price' => '',
            'max_price' => '',
            'ele_lazyloadbg' => '',
            'properties_by_agents' => ''
        ), $atts));

        ob_start();

        $grid_class = "property-grids-module-v1";
        if($prop_grid_type == 'grid_2') {
            $grid_class = "property-grids-module-v2";

        } else if($prop_grid_type == 'grid_3') {
            $grid_class = "property-grids-module-v3";

        } else if($prop_grid_type == 'grid_4') {
            $grid_class = "property-grids-module-v4";
            
        }

        //do the query
        $the_query = houzez_data_source::get_wp_query($atts); //by ref  do the query
        ?>

        <div class="property-grids-module <?php echo esc_attr($grid_class); ?>">
            <?php
            $i = 0;
            if ($the_query->have_posts()) : 

                while ($the_query->have_posts()) : $the_query->the_post();
                    $i++;

                    if($i == 1) {
                        echo '<div class="property-grids-module-row clearfix">';
                    }

                        get_template_part('template-parts/listing/grid-item');

                    if($prop_grid_type == 'grid_1' || $prop_grid_type == 'grid_2') {
                        if ($i == 6 || ($the_query->current_post +1 == $the_query->post_count) ) {
                            echo '</div>';
                            $i = 0;
                        }
                    } else if($prop_grid_type == 'grid_3') {
                        if ($i == 7 || ($the_query->current_post +1 == $the_query->post_count) ) {
                            echo '</div>';
                            $i = 0;
                        }
                    } else if($prop_grid_type == 'grid_4') {
                        if ($i == 4 || ($the_query->current_post +1 == $the_query->post_count) ) {
                            echo '</div>';
                            $i = 0;
                        }
                    }

                endwhile;
            endif;
            ?>
        </div>

        <?php
        $result = ob_get_contents();
        ob_end_clean();
        return $result;

    }

    add_shortcode('houzez-prop-grids', 'houzez_prop_grids');
}
?>