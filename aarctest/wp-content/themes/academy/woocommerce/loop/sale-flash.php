<?php global $post, $product; ?>
<?php if ($product->is_on_sale()) : ?>
	<?php echo apply_filters('woocommerce_sale_flash', '<div class="course-price"><div class="corner-wrap"><div class="corner"></div><div class="corner-background"></div></div><div class="price-text">'.__( 'Sale!', 'woocommerce' ).'</div></div>', $post, $product); ?>
<?php endif; ?>