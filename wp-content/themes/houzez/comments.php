<?php
/**
 * The template for displaying Comments
 *
 * The area of the page that contains comments and the comment form.
 *
 * @package Houzez
 * @since Houzez 1.0
 */

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
global $houzez_local;
if ( post_password_required() ) {
	return;
}
?>

<div class="post-comment-form-wrap">
 
    <div class="comments-form-wrap">
    <?php
	//Custom Fields
	$fields =  array(
		'author'=> '<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<div class="input-user input-icon">
									<input name="author" required class="form-control" id="author" value="" placeholder="'.$houzez_local['your_name'].'" type="text">
								</div>
							</div>
						</div>',

		'email' => '<div class="col-sm-6">
						<div class="form-group">
							<div class="input-email input-icon">
								<input type="email" class="form-control" required name="email" id="email" placeholder="'.$houzez_local['your_email'].'">
							</div>
						</div>
					</div>',

		'url' 	=> '</div>',
	);

	//Comment Form Args
	$comments_args = array(
		'fields' => $fields,
		'title_reply'=> $houzez_local['join_discussion'],
		'comment_notes_before' => '',
		'comment_notes_after' => '',
		'comment_field' => '<div class="row"><div class="col-sm-12"><div class="form-group"><textarea class="form-control" required rows="4" name="comment" id="comment"></textarea></div></div></div>',
		'label_submit' => $houzez_local['submit']
	);

	// Show Comment Form
	comment_form($comments_args);
	?>
    </div>
</div>

<?php if ( have_comments() ) : ?>
<div class="post-comment-wrap">
    <h3 class="title">
    	<?php
			printf( _n( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'houzez' ),
				number_format_i18n( get_comments_number() ), get_the_title() );
		?>
    </h3>
    <ul class="comments-list list-unstyled">
		<?php
		wp_list_comments( array(
			'style'      => 'ul',
			'short_ping' => true,
			'avatar_size'=> 60,
			'callback' => 'houzez_comments_callback'
		) );
		?>
	</ul>

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
		<nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
			<div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'houzez' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'houzez' ) ); ?></div>
		</nav>
	<?php endif; ?>

	<?php if ( ! comments_open() ) : ?>
	<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'houzez' ); ?></p>
	<?php endif; ?>

</div>

<?php endif; // have_comments() ?>


