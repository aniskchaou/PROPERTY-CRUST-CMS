<?php
/**
 * Template Name: User Dashboard Saved Search
 * Created by PhpStorm.
 * User: waqasriaz
 * Date: 11/01/16
 * Time: 4:35 PM
 */
if ( !is_user_logged_in() ) {
    wp_redirect(  home_url() );
}

global $wpdb, $houzez_local;

$userID = get_current_user_id();

$table_name = $wpdb->prefix . 'houzez_search';
$results    = $wpdb->get_results( 'SELECT * FROM ' . $table_name . ' WHERE auther_id = '.$userID.' ORDER BY id DESC', OBJECT );

get_header(); ?>

<header class="header-main-wrap dashboard-header-main-wrap">
    <div class="dashboard-header-wrap">
        <div class="d-flex align-items-center">
            <div class="dashboard-header-left flex-grow-1">
                <h1><?php echo houzez_option('dsh_saved_searches', 'Saved Searches'); ?></h1>         
            </div><!-- dashboard-header-left -->
            <div class="dashboard-header-right">

            </div><!-- dashboard-header-right -->
        </div><!-- d-flex -->
    </div><!-- dashboard-header-wrap -->
</header><!-- .header-main-wrap -->
<section class="dashboard-content-wrap">
    <div class="dashboard-content-inner-wrap">
        <div class="dashboard-content-block-wrap">

            <?php
            if ( sizeof( $results ) !== 0 ) : ?>

                <table class="dashboard-table table-lined responsive-table">
                    <thead>
                        <tr>
                            <th><?php echo esc_html__('Search Parameters', 'houzez'); ?></th>
                            <th class="action-col"><?php echo esc_html__('Actions', 'houzez'); ?></th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php
                    foreach ( $results as $houzez_search_data ) :

                        get_template_part( 'template-parts/dashboard/saved-search-item' );

                    endforeach;
                    ?>

                    </tbody>
                </table>

            <?php
            else :

                echo '<div class="dashboard-content-block">
                        '.esc_html__("You don't have any saved search.", 'houzez').'
                    </div>';

            endif;

            ?>
            

        </div><!-- dashboard-content-block-wrap -->
    </div><!-- dashboard-content-inner-wrap -->
</section><!-- dashboard-content-wrap -->
<section class="dashboard-side-wrap">
    <?php get_template_part('template-parts/dashboard/side-wrap'); ?>
</section>

    
<?php get_footer(); ?>