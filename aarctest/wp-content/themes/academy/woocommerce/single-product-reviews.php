<?php global $woocommerce; ?>
<?php if ( comments_open() ) : ?>
<div id="reviews">
<?php
echo '<div id="comments" class="comments-listing">';
if ( get_option('woocommerce_enable_review_rating') == 'yes' ) {
	$count = $wpdb->get_var( $wpdb->prepare("
		SELECT COUNT(meta_value) FROM $wpdb->commentmeta
		LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
		WHERE meta_key = 'rating'
		AND comment_post_ID = %d
		AND comment_approved = '1'
		AND meta_value > 0
	", $post->ID ) );

	$rating = $wpdb->get_var( $wpdb->prepare("
		SELECT SUM(meta_value) FROM $wpdb->commentmeta
		LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
		WHERE meta_key = 'rating'
		AND comment_post_ID = %d
		AND comment_approved = '1'
	", $post->ID ) );

} else {
	echo '<h2>'.__( 'Reviews', 'woocommerce' ).'</h2>';
}
$title_reply = '';

if ( have_comments() ) :
	echo '<ul>';
	wp_list_comments( array( 'callback' => 'woocommerce_comments' ) );
	echo '</ul>';

	if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
		<nav class="pagination">
			<span class="page-numbers prev"><?php previous_comments_link( __( '', 'woocommerce' ) ); ?></span>
			<span class="page-numbers next"><?php next_comments_link( __( '', 'woocommerce' ) ); ?></span>
		</nav>
		<div class="clear"></div>
	<?php endif;
	echo '<div class="add_review"><a href="#review_form" class="inline show_review_form button" rel="prettyPhoto" >' . __( 'Add Review', 'woocommerce' ) . '</a></div>';
	$title_reply = __( 'Add a review', 'woocommerce' );
else :
	$title_reply = __( 'Be the first to review', 'woocommerce' ).' &ldquo;'.$post->post_title.'&rdquo;';
	echo '<p class="noreviews">'.__( 'There are no reviews yet, would you like to <a href="#review_form" class="inline show_review_form">submit yours</a>?', 'woocommerce' ).'</p>';
endif;

$commenter = wp_get_current_commenter();
echo '</div><div id="review_form_wrapper"><div id="review_form">';

$comment_form = array(
	'title_reply' => $title_reply,
	'comment_notes_before' => '',
	'comment_notes_after' => '',
	'fields' => array(
		'author' => '<p class="comment-form-author"><input id="author" name="author" type="text" placeholder="' . __( 'Name', 'woocommerce' ) . '" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" aria-required="true" /></p>',
		'email'  => '<p class="comment-form-email"><input id="email" name="email" type="text" placeholder="' . __( 'Email', 'woocommerce' ) . '" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" aria-required="true" /></p>',
	),
	'label_submit' => __( 'Submit Review', 'woocommerce' ),
	'logged_in_as' => '',
	'comment_field' => ''
);

if ( get_option('woocommerce_enable_review_rating') == 'yes' ) {
	$comment_form['comment_field'] = '<p class="comment-form-rating"><label for="rating">' . __( 'Rating', 'woocommerce' ) .'</label><select name="rating" id="rating">
		<option value="">'.__( 'Rate&hellip;', 'woocommerce' ).'</option>
		<option value="5">'.__( 'Perfect', 'woocommerce' ).'</option>
		<option value="4">'.__( 'Good', 'woocommerce' ).'</option>
		<option value="3">'.__( 'Average', 'woocommerce' ).'</option>
		<option value="2">'.__( 'Not that bad', 'woocommerce' ).'</option>
		<option value="1">'.__( 'Very Poor', 'woocommerce' ).'</option>
	</select></p>';
}

$comment_form['comment_field'] .= '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" placeholder="' . __( 'Your Review', 'woocommerce' ) . '"></textarea></p>' . $woocommerce->nonce_field('comment_rating', true, false);
comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );

echo '</div></div>';
?>
<div class="clear"></div>
</div>
<?php endif; ?>