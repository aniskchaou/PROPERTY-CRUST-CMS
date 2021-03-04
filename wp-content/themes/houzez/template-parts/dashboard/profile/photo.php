<?php
global $houzez_local;
$userID = get_current_user_id();

$user_custom_picture    =   get_the_author_meta( 'fave_author_custom_picture' , $userID );
$author_picture_id      =   get_the_author_meta( 'fave_author_picture_id' , $userID );
$user_default_currency  =   get_the_author_meta( 'fave_author_currency' , $userID );
if($user_custom_picture =='' ) {
    $user_custom_picture = HOUZEZ_IMAGE. 'profile-avatar.png';
}
?>

<div id="houzez_profile_photo" class="profile-image">
<?php
if( !empty( $author_picture_id ) ) {
    $author_picture_id = intval( $author_picture_id );
    if ( $author_picture_id ) {
        echo wp_get_attachment_image( $author_picture_id, 'large', "", array( "class" => "img-fluid" ) );
        echo '<input type="hidden" class="profile-pic-id" id="profile-pic-id" name="profile-pic-id" value="' . esc_attr( $author_picture_id ).'"/>';
    }
} else {
    print '<img class="img-fluid" id="profile-image" src="'.esc_url( $user_custom_picture ).'" alt="user image" >';
}
?>
</div>
<button id="select_user_profile_photo" type="button" class="btn btn-primary btn-full-width mt-3">
	<?php echo esc_html__('Update Profile Picture', 'houzez'); ?>
</button>
<small class="form-text text-muted text-center"><?php echo esc_html__('Minimum size 300 x 300 px', 'houzez'); ?></small>
<div id="upload_errors"></div>