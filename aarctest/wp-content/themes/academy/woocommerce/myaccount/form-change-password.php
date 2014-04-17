<?php global $woocommerce; ?>
<div class="fourcol column">
	<div class="formatted-form">
		<?php $woocommerce->show_messages(); ?>
		<form action="<?php echo esc_url( get_permalink(woocommerce_get_page_id('change_password')) ); ?>" method="post">
			<div class="field-wrapper">
				<input type="password" class="input-text" name="password_1" id="password_1" placeholder="<?php _e( 'New password', 'woocommerce' ); ?>" />
			</div>
			<div class="field-wrapper">
				<input type="password" class="input-text" name="password_2" id="password_2" placeholder="<?php _e( 'Re-enter new password', 'woocommerce' ); ?>" />
			</div>
			<div class="clear"></div>
			<input type="submit" class="button" name="change_password" value="<?php _e( 'Save', 'woocommerce' ); ?>" />
			<?php $woocommerce->nonce_field('change_password')?>
			<input type="hidden" name="action" value="change_password" />
		</form>
	</div>
</div>
<div class="clear"></div>