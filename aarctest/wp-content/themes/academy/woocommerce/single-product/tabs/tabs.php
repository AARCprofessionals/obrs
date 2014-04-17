<?php
$tabs = apply_filters( 'woocommerce_product_tabs', array() );
if ( ! empty( $tabs ) ) : 
?>
	<div class="tabs-container horizontal-tabs product-tabs">
		<ul class="tabs">
			<?php foreach ( $tabs as $key => $tab ) : ?>
				<li class="<?php echo $key ?>_tab">
					<h5 class="nomargin"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', $tab['title'], $key ) ?></h5>
				</li>
			<?php endforeach; ?>
		</ul>
		<div class="panes">
		<?php foreach ( $tabs as $key => $tab ) : ?>
			<div class="pane" id="tab-<?php echo $key ?>">
				<?php call_user_func( $tab['callback'], $key, $tab ) ?>
			</div>
		<?php endforeach; ?>
		</div>
	</div>
<?php endif; ?>