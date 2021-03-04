<?php
/*-----------------------------------------------------------------------------------*/
/*  Advance Search
/*-----------------------------------------------------------------------------------*/
if( !function_exists('houzez_advance_search') ) {
    function houzez_advance_search($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'search_title' => ''
        ), $atts));

        ob_start();

        $search_builder = houzez_search_builder();
        $layout = $search_builder['enabled'];
        unset($layout['placebo']);

        if(!taxonomy_exists('property_country')) {
            unset($layout['country']);
        }

        if(!taxonomy_exists('property_state')) {
            unset($layout['state']);
        }

        if(!taxonomy_exists('property_city')) {
            unset($layout['city']);
        }

        if(!taxonomy_exists('property_area')) {
            unset($layout['areas']);
        }

        if(houzez_is_radius_search() != 1) {
            unset($layout['geolocation']);
        }

        if(houzez_is_price_range_search()) {
            unset($layout['min-price'], $layout['max-price']);
        }
        unset($layout['price']);
        ?>
        <div class="advanced-search-module">
            <?php if(!empty($search_title)) { ?>
            <div class="advanced-search-module-title">
                <i class="houzez-icon icon-search mr-2"></i> <?php echo esc_attr($search_title); ?>
            </div>
            <?php } ?>
            <form class="houzez-search-form-js" method="get" autocomplete="off" action="<?php echo esc_url( houzez_get_search_template_link() ); ?>">
                <div class="advanced-search-v1">
                    <div class="row">
    
                        <?php
                        $i = 0;
                        if ($layout) {
                            foreach ($layout as $key=>$value) { $i ++;
                                
                                if(in_array($key, houzez_search_builtIn_fields())) {
                                    
                                    if($key == 'geolocation') {

                                        echo '<div class="col-md-4 col-12">';
                                            get_template_part('template-parts/search/fields/geolocation', 'shortcode');
                                        echo '</div>';

                                        echo '<div class="col-md-2 col-6">';
                                            get_template_part('template-parts/search/fields/distance');
                                        echo '</div>';

                                    } elseif( $key == 'keyword' ) {
                                        echo '<div class="col-md-4 col-6">';
                                            get_template_part('template-parts/search/fields/'.$key);
                                        echo '</div>';

                                    } else {
                                        echo '<div class="col-md-2 col-6">';
                                            get_template_part('template-parts/search/fields/'.$key);
                                        echo '</div>';
                                    }
                                } else {

                                    echo '<div class="col-md-2 col-6">';
                                        houzez_get_custom_search_field($key);
                                    echo '</div>';
                                    
                                }
            
                            }
                        }
                        ?>
                        
                        <div class="col-md-2 col-6 d-none d-sm-block">
                            <?php get_template_part('template-parts/search/fields/submit-button'); ?>
                        </div>
                        <div class="col-12 d-block d-sm-none mb-3">
                            <?php get_template_part('template-parts/search/fields/submit-button'); ?>
                        </div>
                    </div>
                </div><!-- advanced-search-v1 -->

                <?php if(houzez_is_price_range_search()) { ?>
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <?php get_template_part('template-parts/search/fields/price-range'); ?>   
                    </div>
                </div>
                <?php } ?>

                <?php if(houzez_is_other_featuers_search()) { ?>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <?php get_template_part('template-parts/search/other-features'); ?>
                    </div>
                </div>
                <?php } ?>
            </form>
        </div><!-- advanced-search-module -->
        <?php
        
        $result = ob_get_contents();
        ob_end_clean();
        return $result;

    }

    add_shortcode('hz-advance-search', 'houzez_advance_search');
}
?>