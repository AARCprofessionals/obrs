<?php
global $product, $woocommerce_loop;

if ( empty( $woocommerce_loop['loop'] ) ) {
	$woocommerce_loop['loop'] = 0;
}

$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

if ( ! $product->is_visible() ) {
	return;
}
	
$woocommerce_loop['loop']++;

$classes = array();
if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] )
	$classes[] = 'first';
if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] )
	$classes[] = 'last';
?>
<li <?php post_class( $classes ); ?>>
	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
	<a href="<?php the_permalink(); ?>">
		<?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
	</a>
	<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
	<footer class="product-footer clearfix">
	<?php do_action( 'woocommerce_after_shop_loop_item_title' ); ?>
	<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
	</footer>	
</li>