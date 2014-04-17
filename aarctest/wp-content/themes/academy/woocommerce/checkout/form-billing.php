<?php global $woocommerce; ?>
<h2><?php _e('Order Details', 'academy'); ?></h2>
<div class="formatted-form checkout-form">
<?php foreach ($checkout->checkout_fields['billing'] as $key => $field) : ?>
	<div class="field-wrapper">
	<?php woocommerce_form_field( $key, $field, ThemexWoo::filterValue($checkout->get_value( $key ), $key, 'billing_')); ?>
	</div>
<?php endforeach; ?>
<?php if (!is_user_logged_in() && $checkout->enable_signup) : ?>
<?php foreach ($checkout->checkout_fields['account'] as $key => $field) : ?>
	<div class="field-wrapper">
	<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
	</div>
<?php endforeach; ?>
<?php endif; ?>
<input type="hidden" name="shipping_method" id="shipping_method" value="free_shipping">
</div>