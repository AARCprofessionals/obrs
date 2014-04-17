<?php
global $post;
$rating = esc_attr( get_comment_meta( $GLOBALS['comment']->comment_ID, 'rating', true ) );
?>
<li itemprop="reviews" itemscope itemtype="http://schema.org/Review" id="li-comment-<?php comment_ID() ?>">
	<div id="comment-<?php comment_ID(); ?>" class="comment clearfix">
		<div class="avatar-container">
			<div class="bordered-image">
			<a href="<?php echo get_author_posts_url($GLOBALS['comment']->user_id); ?>"><?php echo get_avatar( $GLOBALS['comment'] ); ?></a>
			</div>										
		</div>
		<div class="comment-text">
			<header class="comment-header hidden-wrap">
			<?php if ($GLOBALS['comment']->comment_approved == '0') : ?>
				<p class="meta"><em><?php _e( 'Your comment is awaiting approval', 'woocommerce' ); ?></em></p>
			<?php else : ?>				
				<h5 class="left comment-author"><a href="<?php echo get_author_posts_url($GLOBALS['comment']->user_id); ?>"><?php comment_author(); ?></a></h5>
				<time class="comment-time left" datetime="<?php comment_time('Y-m-d'); ?>"><?php comment_time(ThemexCore::getOption('date_format', 'd/m/Y')); ?></time>
			<?php endif; ?>
			</header>
			<?php comment_text(); ?>
			<?php if ( get_option('woocommerce_enable_review_rating') == 'yes' ) : ?>
			<div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating" class="star-rating" title="<?php echo sprintf(__( 'Rated %d out of 5', 'woocommerce' ), $rating) ?>">
				<span style="width:<?php echo ( intval( get_comment_meta( $GLOBALS['comment']->comment_ID, 'rating', true ) ) / 5 ) * 100; ?>%"><strong itemprop="ratingValue"><?php echo intval( get_comment_meta( $GLOBALS['comment']->comment_ID, 'rating', true ) ); ?></strong> <?php _e( 'out of 5', 'woocommerce' ); ?></span>
			</div>
			<?php endif; ?>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>