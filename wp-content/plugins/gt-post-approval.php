<?php
/*
Plugin Name: GT Post Approval
Plugin URI: http://www.gt-globalwarming-awareness2007.org/wordpress/gt-post-approval-for-gt-globalwarming-awareness2007-wordpress-plugin/
Description: Add Approve/Reject buttoms visible just for administrators and editors in <a href='edit.php'>edit > posts</a>. Posts rejected are visible only in author's archive.
Version: 0.2
Author: Francesco Terenzani
Author URI: http://www.terenzani.it/
*/

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
}

//
// The_Loop
//

// Change the where clause from the wp_query class using the show_only_gt_approved function below
add_filter('posts_where', 'show_only_gt_approved');

// Show only GT Approved posts
// Disable the filter in author's archive, admin area and single post/page
function show_only_gt_approved($where){
	if(is_author() || is_admin() || is_single() || is_page() || is_search())
		return $where;
	return $where ." AND gt_status = 1 ";
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

			// Change the query string used for easy redirect after click in gt_return_status function
			if($_SERVER['QUERY_STRING']) $_SERVER['QUERY_STRING'] = '&'.$_SERVER['QUERY_STRING'];

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
		echo "<a href='edit.php?gt_reject=$id$_SERVER[QUERY_STRING]' class='edit'>".__('Reject').'</a>';
		// Note: I use also the query string for an easy redirect in the gt_redirect_after_change() function
	else
		echo "<a href='edit.php?gt_approve=$id$_SERVER[QUERY_STRING]' class='edit gtaprove'>".__('Approve').'</a>';
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
?>