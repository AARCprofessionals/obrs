<?php
/*
Plugin Name: GT Post Approval 0.3 Beta
Plugin URI: http://www.gt-globalwarming-awareness2007.org/wordpress/gt-post-approval-for-gt-globalwarming-awareness2007-wordpress-plugin/
Description: Add Approve/Reject buttoms visible just for administrators and editors in <a href='edit.php'>edit > posts</a>. Go to <a href='options-general.php?page=gt-post-approval.php'>Options > Approval</a> to choose where display not approved posts
Version: 0.3 b0.3
Author: Francesco Terenzani
Author URI: http://www.terenzani.it/
*/

//
// Self extension
//

if(function_exists('is_tag'))
	add_filter('gt_areas', 'gt_self_extension');

function gt_self_extension($array){
	$array['is_tag'] = 'Tags archive';
	return $array;
}

//
// Installation
//

// On activation of the plugin launch the install_gt_post_approval function below
register_activation_hook(__FILE__, 'install_gt_post_approval');

// Change the wp_posts table
function install_gt_post_approval(){
	global $wpdb;
	// If gt_status column do not exist
	if($wpdb->get_var("SHOW COLUMNS FROM $wpdb->posts LIKE 'gt_status'") != 'gt_status'){

		// Step 1, add gt_status column and set every post as approved (value 1)
		$wpdb->query("ALTER TABLE $wpdb->posts ADD gt_status INT( 1 ) NOT NULL DEFAULT '1'");

		// Step 2, change the default value of gt_status. New posts have to be approved
		$wpdb->query("ALTER TABLE $wpdb->posts CHANGE gt_status gt_status INT( 1 ) NOT NULL DEFAULT '0'");
	}
	// Unhelpful optiomisation :D 
	add_option('gt_opt', 'empty', '', 'no');

	// Set default options
	$_POST['gt-form'] = true;
	$_POST['is_'] = array('is_author' => true, 'is_search' => true, 'is_single' => true);
	$_POST['gt-level'] = 10;
	gt_save_options();
}

//
// The_Loop
//

// Change the where clause from the wp_query class using the show_only_gt_approved function below
add_filter('posts_where', 'show_only_gt_approved');

// Show only GT Approved posts
// Disable the filter in admin area, in single page and in user defined areas
function show_only_gt_approved($where){
	if(is_admin() || is_page() || is_custom_defined() )
		return $where;
	return 'AND gt_status = 1 '.$where;
}
// Return true if we are in a user defined page of wordpress
// I feel this function very cool :P
function is_custom_defined(){
	$callback = get_option('gt_opt_callback');
	if(is_array($callback)){
		do
			if(call_user_func(current($callback)))
				return true;

		while(next($callback));
	}
	return false;
}

//
// Optimisation
//

// Set the global array $post_gt_aproved with the structure: [post_ID] => gt_status
// I use it to know the gt_status without any other query
function gt_post2status($post_query_results){
	global $post_gt_aproved;

	$post_gt_aproved = array();

	for($i = 0, $j = count($post_query_results); $i < $j; $i++)
		$post_gt_aproved[$post_query_results[$i]->ID] = $post_query_results[$i]->gt_status;

	return $post_query_results;
}



//
// Administration
//

// Change the admin area wp-admin/edit.php if current user is admin or editor
if(is_admin()){
	add_filter('init', 'gt_admin_status');

	function gt_admin_status(){
		global $wpdb;
		// If current user is admin or editor
		if(current_user_can('edit_others_posts')){

			// Add the GT Status column
			add_filter('manage_posts_columns', 'gt_column');

			// Set the global array with the structure post_ID => gt_status, ...
			add_filter('the_posts', 'gt_post2status');

			// For each post in edit.php add a button approve/reject
			add_filter('manage_posts_custom_column', 'gt_return_status');

			// Add a CSS to emphasize the button approve
			add_filter('admin_head', 'gt_emphasize_to_aprove');

			// On click of approve/reject change the status in the database (value 1 -> approved/0 -> rejected)
			if(isset($_GET['gt_reject']) && is_numeric($_GET['gt_reject'])){
				$wpdb->query("UPDATE $wpdb->posts SET gt_status = 0 WHERE ID = $_GET[gt_reject]");
				gt_redirect_after_change();
			}
			elseif(isset($_GET['gt_approve']) && is_numeric($_GET['gt_approve'])){
				$wpdb->query("UPDATE $wpdb->posts SET gt_status = 1 WHERE ID = $_GET[gt_approve]");
				gt_redirect_after_change();
			}

		}
		// Auto approve a post if current user level is greater then X
		add_filter('wp_insert_post', 'gt_auto_approve');
	}
}
// Add the GT Status column
function gt_column($array){
	$array['gt_column'] = __('GT Status');
	return $array;
}

// Print a button approve/reject for the current post
function gt_return_status(){
	global $id, $post_gt_aproved;

	// If current post is approved (see gt_post2status() function)
	if($post_gt_aproved[$id])
		echo "<a href='edit.php?gt_reject=$id&eamp;$_SERVER[QUERY_STRING]' class='edit'>".__('Reject').'</a>';
		// Note: I use also the query string for an easy redirect in the gt_redirect_after_change() function
	else
		echo "<a href='edit.php?gt_approve=$id&eamp;$_SERVER[QUERY_STRING]' class='edit gtaprove'>".__('Approve').'</a>';
}

// Redirect after change GT Status
function gt_redirect_after_change(){
	header('Location: '.preg_replace("/gt_(?:reject|approve)=[0-9]+[&]?/", '', $_SERVER['REQUEST_URI']));
	exit();
}

// CSS for admin area
function gt_emphasize_to_aprove(){
?>
	<style type='text/css'>.gtaprove{background:#adf;font-weight:bold}</style>
<?php
}

// Auto approve a post if current user level is greater then X
function gt_auto_approve($post_id){
	global $wpdb;
	if($_POST['post_status'] == 'publish' && $_POST['prev_status'] != $_POST['post_status']){
		$level = get_option('gt_opt');
		$level = $level['gt-level'];
		if($level > 0)
			if(current_user_can("level_$level"))
				$wpdb->query("UPDATE $wpdb->posts SET gt_status = 1 WHERE ID = $post_id");
	}
}

//
// Options
//

function gt_add_options_page(){
	add_options_page('GT Post Approval', 'Approval', 10, 'gt-post-approval.php', 'gt_options_page');
}

add_filter('admin_menu','gt_add_options_page');


function gt_options_page(){

	// On submit save options
	gt_save_options();

	$options = get_option('gt_opt');

	// Options checked are here
	$checked =& $options['is_'];

	$registered_inputs = gt_get_registered_options();

?>
	<div class="wrap">
		<h2>GT Post Approval</h2>
		<form method='post' action='?<?php echo $_SERVER['QUERY_STRING']?>'>
		<fieldset class="options">

			<legend>Not approved posts are visible just in: </legend>

			<?php foreach($registered_inputs as $input_name => $description){

				$checked[$input_name] = ($checked[$input_name]) ? 'checked="checked"' : null;

				echo <<<CODE
					<p>
						<label for="is_[$input_name]">
							<input type='checkbox' id="is_[$input_name]" name="is_[$input_name]" $checked[$input_name] /> $description
						</label>
					</p>
CODE;
			} ?>

		</fieldset>

		<fieldset class="options">

			<legend>Auto approve posts if current user level is: </legend>

			<p><label for='gt-level'>Range 0-10:
				<input type="text" size='2' id='gt-level' name='gt-level' value='<?php echo $options['gt-level'] ?>' /></label>
				<br /><em>0 or empty value to reject every post by default.</em></p>

			<p class='submit'>
				<input type='submit' name='gt-form' value='Update Options &raquo;' />
				<input type='hidden' name='gt-form' value='1' />
			</p>

		</fieldset>

		</form>
	</div>

<?php
}

function gt_save_options(){

	if(isset($_POST['gt-form'])){

		$registered_callbacks = gt_get_registered_options();

		if(is_array($_POST['is_']))
			foreach($_POST['is_'] as $is_what => $on)
				if($on && $registered_callbacks[$is_what])
					// I will run this functions in is_custom_defined()
					$callback[] = $is_what;

		update_option( 'gt_opt_callback', $callback );
		update_option( 'gt_opt', array( 'is_' => $_POST['is_'], 'gt-level' => gt_get_option_level() ) );
	}
}

function gt_get_registered_options(){
	return apply_filters('gt_areas', array ('is_author' => 'Author\'s archive', 'is_search' => 'Search results', 'is_feed' => 'Feeds', 'is_date' => 'Post per data archive', 'is_single' => 'Single post page'));
}

function gt_get_option_level(){
	if( is_numeric( $_POST['gt-level']) ){
		if ( $_POST['gt-level'] > 10 )
			return 10;
		if ( $_POST['gt-level'] < 0 )
			return 0;
		return $_POST['gt-level'];
	}
	return 0;
}
?>