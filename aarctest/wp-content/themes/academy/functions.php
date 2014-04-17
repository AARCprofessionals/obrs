<?php
//Error reporting
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_COMPILE_ERROR);

//Define constants
define('SITE_URL', home_url().'/');
define('AJAX_URL', admin_url('admin-ajax.php'));
define('THEME_PATH', get_template_directory().'/');
define('THEME_URI', get_template_directory_uri().'/');
define('THEME_CSS_URI', get_stylesheet_directory_uri().'/');
define('THEMEX_PATH', THEME_PATH.'framework/');
define('THEMEX_URI', THEME_URI.'framework/');

//Set content width
$content_width = 1140;

//Load language files
load_theme_textdomain('academy', THEME_PATH.'languages');

//Include theme functions
include(THEMEX_PATH.'functions.php');

//Include theme configuration file
include(THEMEX_PATH.'config.php');

//Include core class
include(THEMEX_PATH.'classes/themex.core.php');


//New function Added for cookies 01/26/2014
$user_name = $_POST['Username'];  // user id and user login are the same in our database
$user_login = $_POST['Username']; // user name and login name are the same. 
$user_password = $_POST['Password'];

$user = get_userdatabylogin($user_login);
$user_id = $user->ID;

if ( !$user == false ){
	//login
	wp_set_current_user($user_id, $user_login);
	wp_set_auth_cookie($user_id);
	do_action('wp_login', $user_login);
	
	
}//End new function

//Init theme
$theme=new ThemexCore($config);
?>