<article <?php post_class('post clearfix'); ?>>
	<?php if(has_post_thumbnail()) { ?>
	<div class="column twocol post-image">
		<div class="bordered-image thick-border">
			<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('normal'); ?></a>
		</div>
	</div>
	<div class="post-content column tencol last">
	<?php } else { ?>
	<div class="post-content">
	<?php } ?>
		<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
		<?php 
		if(isset($GLOBALS['content'])) {
			echo do_shortcode($GLOBALS['content']);
		} else {
			the_excerpt();
		}
		?>
		<footer class="post-footer">
			<a href="<?php the_permalink(); ?>" class="button small"><span><?php _e('Read More','academy'); ?></span></a>
			<?php if(comments_open()) { ?>
			<div class="post-comment-count"><?php comments_number('0','1','%'); ?></div>
			<?php } ?>			
			<time class="post-date nomargin" datetime="<?php the_time('Y-m-d'); ?>"><?php the_time($GLOBALS['date_format']); ?></time>
			<?php if(ThemexCore::getOption('blog_author')!='true') { ?>
			<div class="post-author">&nbsp;<?php _e('by', 'academy'); ?> <?php the_author_posts_link(); ?></div>
			<?php } ?>
		</footer>
	</div>
</article>