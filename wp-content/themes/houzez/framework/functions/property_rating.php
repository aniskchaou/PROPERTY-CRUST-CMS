<?php
add_action( 'wp_ajax_nopriv_houzez_property_raring', 'houzez_property_raring' );
add_action( 'wp_ajax_houzez_property_raring', 'houzez_property_raring' );

if ( !function_exists( 'houzez_property_raring' ) ) {

    /**
     * Add rating using Ajax
     */
    function houzez_property_raring()
    {

        $nonce = $_POST['start_thread_message_form_ajax'];

        if ( !wp_verify_nonce( $nonce, 'property-rating-form-nonce') ) {
            echo json_encode( array(
                'success' => false,
                'msg' => esc_html__('Unverified Nonce!', 'houzez')
            ));
            wp_die();
        }

        global $wpdb, $current_user;

        wp_get_current_user();
        $userID =  $current_user->ID;
        $user = get_user_by( 'id', $userID );
        $property_id = $_POST['property_id'];
        $rating_count = $_POST['rating'];
        $rating_title = $_POST['title'];
        $comments_table = $wpdb->comments;
        $comments_meta_table = $wpdb->commentmeta;
        $check_comment_query = "SELECT * FROM $comments_table as comment INNER JOIN $comments_meta_table AS meta WHERE comment.comment_post_ID = $property_id AND comment.user_id = $userID  AND meta.meta_key = 'rating' AND meta.comment_id = comment.comment_ID ORDER BY comment.comment_ID DESC";
        $check_comment = $wpdb->get_row( $check_comment_query );
        $comment_approved = 1;
        $approved_by_admin = houzez_option( 'property_reviews_approved_by_admin' );
        if ( $approved_by_admin == 1 ) {
            $comment_approved = 0;
        }

        if ( empty( $check_comment ) ) {

            $user = $user->data;
            $data = Array();
            $data['comment_post_ID'] = $property_id;
            $data['comment_author'] = $user->user_login;
            $data['comment_author_email'] = $user->user_email;
            $data['comment_author_url'] = $user->user_url;
            $data['comment_content'] = $_POST['message'];
            $data['user_id'] = $userID;
            $data['comment_date'] = current_time( 'mysql' );
            $data['comment_approved'] = $comment_approved;
            $comment_id = wp_insert_comment( $data );

            add_comment_meta( $comment_id, 'rating', $rating_count );
            add_comment_meta( $comment_id, 'title', $rating_title );
            if ( $comment_approved = 1 ) {
                apply_filters('houzez_rating_meta', $property_id, $rating_count);
            }

        } else {

            $user = $user->data;
            $data = Array();
            $data['comment_ID'] = $check_comment->comment_ID;
            $data['comment_post_ID'] = $property_id;
            $data['comment_content'] = $_POST['message'];
            $data['comment_date'] = current_time('mysql');
            $data['comment_approved'] = $comment_approved;

            wp_update_comment( $data );

            update_comment_meta( $check_comment->comment_ID, 'rating', $rating_count, $check_comment->meta_value );
            update_comment_meta( $check_comment->comment_ID, 'title', $rating_title );
            if ( $comment_approved = 1 ) {
                apply_filters('houzez_rating_meta', $property_id, $rating_count, false, $check_comment->meta_value);
            }

        }

        wp_die();

    }

}

add_filter( 'houzez_rating_meta', 'houzez_rating_meta_filter', 4, 9 );

if ( !function_exists( 'houzez_rating_meta_filter' ) ) {

    /**
     * Update proeprty rating meta
     * @param $property_id
     * @param $rating_count
     */
    function houzez_rating_meta_filter( $property_id, $rating_count, $save = true, $old_rating_count = 0 )
    {

        $rating_data = get_post_meta( $property_id, 'fave_rating',  true );

        if ( $save == true ) {

            echo $old_rating_count;

            if (!empty($rating_data)) {

                $rating_data[$rating_count]++;

            } else {

                $rating_data = Array();
                $rating_data[1] = 0;
                $rating_data[2] = 0;
                $rating_data[3] = 0;
                $rating_data[4] = 0;
                $rating_data[5] = 0;
                $rating_data[$rating_count]++;

            }

        } else {

            $rating_data[ $old_rating_count ]--;
            $rating_data[$rating_count]++;

        }

        update_post_meta( $property_id, 'fave_rating', $rating_data );

    }

}

add_action( 'delete_comment',  'houzez_rating_delete', 10 ,1);

if ( !function_exists( 'houzez_rating_delete' ) ) {

    function houzez_rating_delete( $comment_id )
    {

        global $wpdb;

        $rating_count = get_comment_meta( $comment_id, 'rating', true );

        if ( !empty( $rating_count ) ) {

            $comments_table = $wpdb->comments;
            $comment_query = "SELECT comment_post_ID as prop_ID FROM $comments_table WHERE comment_ID = $comment_id";
            $comment_meta = $wpdb->get_row( $comment_query  );
            $property_id = $comment_meta->prop_ID;
            $rating_data = get_post_meta( $property_id, 'fave_rating',  true );
            $rating_data[ $rating_count ]--;

            update_post_meta( $property_id, 'fave_rating', $rating_data );

        }

    }
}

add_action('transition_comment_status', 'houzez_rating_approve', 10, 3);

if ( !function_exists( 'houzez_rating_approve' ) ) {
    function houzez_rating_approve( $new_status, $old_status, $comment )
    {
        if ( $old_status != $new_status ) {
            if ( $new_status == 'approved' ) {
                $rating = get_comment_meta( $comment->comment_ID, 'rating', true );
                $rating_data = get_post_meta( $comment->comment_post_ID, 'fave_rating',  true );
                $rating_data[ $rating ]++;
                update_post_meta( $comment->comment_post_ID, 'fave_rating', $rating_data );
            } else {
                $rating = get_comment_meta( $comment->comment_ID, 'rating', true );
                $rating_data = get_post_meta( $comment->comment_post_ID, 'fave_rating',  true );
                
                if(!empty($rating)) {
                    $rating_data[ $rating ]--;
                    update_post_meta( $comment->comment_post_ID, 'fave_rating', $rating_data );
                }
            }
        }
    }
}