<?php
/**
 * Created by PhpStorm.
 * User: Waqas Riaz
 * Date: 23/12/16
 * Time: 3:22 AM
 * Since v1.5.0
 * Description: Allows you to add an expiration date (minute) to properties and make then expire at expiration time.
 */

add_action( 'load-post.php', 'houzez_expiration_meta_setup' );
add_action( 'load-post-new.php', 'houzez_expiration_meta_setup' );

if ( !function_exists( 'houzez_expiration_meta_setup' ) ) :
    function houzez_expiration_meta_setup() {
        global $typenow;

        if ( $typenow == 'property' ) {
            add_action( 'add_meta_boxes', 'houzez_load_expiration_metaboxes' );
            add_action( 'save_post', 'houzez_save_expiration_metaboxes', 10, 2 );
        }
    }
endif;
/*---------------------------------------------------------------------------------*
 * Adds hook to get the meta box added to property custom post types
 *----------------------------------------------------------------------------------*/
if( !function_exists('houzez_load_expiration_metaboxes') ) {
    function houzez_load_expiration_metaboxes()
    {
        add_meta_box(
            'houzez_expiration_date',
            esc_html__('Property Expirator', 'houzez'),
            'houzez_expiration_meta_box',
            'property',
            'side',
            'high'
        );
    }
}


/*---------------------------------------------------------------------------------*
 * Metabox Function
 *----------------------------------------------------------------------------------*/
if( !function_exists('houzez_expiration_meta_box') ) {
    function houzez_expiration_meta_box($post)
    {

        $expiration_date = get_post_meta($post->ID, '_houzez_expiration_date', true);
        $manual_expire = get_post_meta($post->ID, 'houzez_manual_expire', true);
        $enabled = $disabled = '';

        if (empty($expiration_date)) {
            $defaultmonth = date_i18n('m');
            $defaultday = date_i18n('d');
            $defaulthour = date_i18n('H');
            $defaultyear = date_i18n('Y');
            $defaultminute = date_i18n('i');

            $disabled = ' disabled="disabled"';

        } else {
            $defaultmonth = get_date_from_gmt(gmdate('Y-m-d H:i:s', $expiration_date), 'm');
            $defaultday = get_date_from_gmt(gmdate('Y-m-d H:i:s', $expiration_date), 'd');
            $defaultyear = get_date_from_gmt(gmdate('Y-m-d H:i:s', $expiration_date), 'Y');
            $defaulthour = get_date_from_gmt(gmdate('Y-m-d H:i:s', $expiration_date), 'H');
            $defaultminute = get_date_from_gmt(gmdate('Y-m-d H:i:s', $expiration_date), 'i');
            if (!empty($manual_expire)) {
                $enabled = ' checked="checked"';
            } else {
                $disabled = ' disabled="disabled"';
            }

        }

        $output = '';
        $output .= '<p>';
        $output .= '<input type="checkbox" name="houzez_enable_expiration_date" id="houzez_enable_expiration_date" ' . $enabled . ' value="checked" onclick="houzez_expiration_date_ajax(\'houzez_enable_expiration_date\')">';
        $output .= '<label for="houzez_enable_expiration_date">' . esc_html__('Enable Property Expiration', 'houzez') . '</label>';
        $output .= '</p>';

        $output .= '<table width="100%">';
        $output .= '<tbody>';
        $output .= '<tr>';
        $output .= '<th style="text-align: left;">' . esc_html__('Year', 'houzez') . '</th>';
        $output .= '<th style="text-align: left;">' . esc_html__('Month', 'houzez') . '</th>';
        $output .= '<th style="text-align: left;">' . esc_html__('Day', 'houzez') . '</th>';
        $output .= '</tr>';

        $output .= '<tr>';
        $output .= '<td>';
        $output .= '<select ' . $disabled . ' name="expirationdate_year" id="expirationdate_year">';

        $currentyear = date('Y');

        if ($defaultyear < $currentyear) $currentyear = $defaultyear;

        for ($i = $currentyear; $i < $currentyear + 8; $i++) {
            if ($i == $defaultyear)
                $selected = ' selected="selected"';
            else
                $selected = '';
            $output .= '<option' . $selected . '>' . $i . '</option>';
        }

        $output .= '</select>';
        $output .= '</td>';

        $output .= '<td>';
        $output .= '<select ' . $disabled . ' name="expirationdate_month" id="expirationdate_month">';

        for ($i = 1; $i <= 12; $i++) {
            if ($defaultmonth == date_i18n('m', mktime(0, 0, 0, $i, 1, date_i18n('Y'))))
                $selected = ' selected="selected"';
            else
                $selected = '';
            $output .= '<option value="' . date_i18n('m', mktime(0, 0, 0, $i, 1, date_i18n('Y'))) . '"' . $selected . '>' . date_i18n('F', mktime(0, 0, 0, $i, 1, date_i18n('Y'))) . '</option>';
        }

        $output .= '</select>';
        $output .= '</td>';

        $output .= '<td>';
        $output .= '<input ' . $disabled . ' type="text" id="expirationdate_day" name="expirationdate_day" value="' . $defaultday . '" size="2">,';
        $output .= '</td>';
        $output .= '</tr>';

        $output .= '<tr>';
        $output .= '<th style="text-align: left;"></th>';
        $output .= '<th style="text-align: left;">' . esc_html__('Hour', 'houzez') . '(' . date_i18n('T', mktime(0, 0, 0, $i, 1, date_i18n('Y'))) . ')</th>';
        $output .= '<th style="text-align: left;">' . esc_html__('Minute', 'houzez') . '</th>';
        $output .= '</tr>';

        $output .= '<tr>';
        $output .= '<td>@</td>';
        $output .= '<td>';
        $output .= '<select ' . $disabled . ' name="expirationdate_hour" id="expirationdate_hour">';

        for ($i = 1; $i <= 24; $i++) {
            if ($defaulthour == date_i18n('H', mktime($i, 0, 0, date_i18n('n'), date_i18n('j'), date_i18n('Y'))))
                $selected = ' selected="selected"';
            else
                $selected = '';
            $output .= '<option value="' . date_i18n('H', mktime($i, 0, 0, date_i18n('n'), date_i18n('j'), date_i18n('Y'))) . '"' . $selected . '>' . date_i18n('H', mktime($i, 0, 0, date_i18n('n'), date_i18n('j'), date_i18n('Y'))) . '</option>';
        }

        $output .= '</select>';
        $output .= '</td>';

        $output .= '<td>';
        $output .= '<input ' . $disabled . ' type="text" id="expirationdate_minute" name="expirationdate_minute" value="' . $defaultminute . '" size="2">';
        $output .= '</td>';
        $output .= '</tr>';

        $output .= '</tbody>';
        $output .= '</table>';

        $output .= '<input type="hidden" name="expirationdate_formcheck" value="true">';

        echo $output;

    }
}


/*---------------------------------------------------------------------------------*
 * Save expiration meta
 *----------------------------------------------------------------------------------*/
if ( !function_exists( 'houzez_save_expiration_metaboxes' ) ) :
    function houzez_save_expiration_metaboxes( $post_id, $post ) {

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
            return;

        if ( $post->post_type == 'revision')
            return;

        if (!isset($_POST['expirationdate_formcheck']))
            return;

        if (isset($_POST['houzez_enable_expiration_date'])) {

            $month	 = intval($_POST['expirationdate_month']);
            $day 	 = intval($_POST['expirationdate_day']);
            $year 	 = intval($_POST['expirationdate_year']);
            $hour 	 = intval($_POST['expirationdate_hour']);
            $minute  = intval($_POST['expirationdate_minute']);

            update_post_meta( $post_id, 'houzez_manual_expire', $_POST['houzez_enable_expiration_date'] );

            $options = array();
            $timestamp = get_gmt_from_date("$year-$month-$day $hour:$minute:0",'U');

            // Schedule/Update Expiration
            $options['id'] = $post_id;

            _houzezScheduleExpiratorEvent( $post_id, $timestamp, $options );
        } else {

            $enable = isset($_POST['houzez_enable_expiration_date']) ? $_POST['houzez_enable_expiration_date'] : 0;
            update_post_meta( $post_id, 'houzez_manual_expire', $enable );
            _houzezUnscheduleExpiratorEvent( $post_id );
        }

    }
endif;


function _houzezScheduleExpiratorEvent( $post_id, $timestamp, $options) {

    if (wp_next_scheduled('houzez_property_expirator_expire', array($post_id)) !== false) {
        wp_clear_scheduled_hook('houzez_property_expirator_expire',array($post_id)); //Remove any existing hooks
    }

    wp_schedule_single_event( $timestamp, 'houzez_property_expirator_expire', array($post_id) );

    // Update Post Meta
    update_post_meta( $post_id, '_houzez_expiration_date', $timestamp );
    update_post_meta( $post_id, '_houzez_expiration_date_options', $options );
    update_post_meta( $post_id, '_houzez_expiration_date_status', 'saved' );
}

function _houzezUnscheduleExpiratorEvent( $post_id ) {
    delete_post_meta( $post_id, '_houzez_expiration_date' );
    delete_post_meta( $post_id, '_houzez_expiration_date_options' );

    // Delete Scheduled Expiration
    if (wp_next_scheduled('houzez_property_expirator_expire', array($post_id)) !== false) {
        wp_clear_scheduled_hook('houzez_property_expirator_expire',array($post_id)); //Remove any existing hooks
    }
    update_post_meta( $post_id, '_houzez_expiration_date_status','saved' );
}


function houzez_property_expirator_expire($post_id) {

    if (empty($post_id)) {
        return false;
    }

    if (is_null(get_post($post_id))) {
        return false;
    }

    $property_options = get_post_meta($post_id, '_houzez_expiration_date_options', true);
    extract($property_options);

    // Remove KSES - wp_cron runs as an unauthenticated user, which will by default trigger kses filtering,
    // even if the post was published by a admin user.  It is fairly safe here to remove the filter call since
    // we are only changing the post status/meta information and not touching the content.
    kses_remove_filters();

    wp_update_post(array('ID' => $post_id, 'post_status' => 'expired'));
    houzez_listing_expire_meta($post_id);

}
add_action('houzez_property_expirator_expire', 'houzez_property_expirator_expire');


/*---------------------------------------------------------------------------------*
 * Admin ajax for enable/disable metaboxes
 *----------------------------------------------------------------------------------*/
function houzez_expiration_date_js_admin_header() { ?>

    <script type="text/javascript">
        //<![CDATA[
        function houzez_expiration_date_ajax(enableID) {
            var expire = document.getElementById(enableID);

            if (expire.checked == true) {
                var enable = 'true';
                if (document.getElementById('expirationdate_month')) {
                    document.getElementById('expirationdate_month').disabled = false;
                    document.getElementById('expirationdate_day').disabled = false;
                    document.getElementById('expirationdate_year').disabled = false;
                    document.getElementById('expirationdate_hour').disabled = false;
                    document.getElementById('expirationdate_minute').disabled = false;
                }
            } else {
                if (document.getElementById('expirationdate_month')) {
                    document.getElementById('expirationdate_month').disabled = true;
                    document.getElementById('expirationdate_day').disabled = true;
                    document.getElementById('expirationdate_year').disabled = true;
                    document.getElementById('expirationdate_hour').disabled = true;
                    document.getElementById('expirationdate_minute').disabled = true;
                }
                var enable = 'false';
            }

            return true;
        }
        //]]>
    </script>
    <?php
}
add_action('admin_head', 'houzez_expiration_date_js_admin_header' );