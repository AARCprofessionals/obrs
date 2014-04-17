<?php
/*
Template Name: IMIS Auth
*/
?>
<?php get_header(); ?>

<div class="column eightcol">

<?php ob_start();

$email = 'testuser4@aarc.org'; /* Get username or password from form */
    
if (!email_exists($email))
{
 echo 'That E-mail doesn\'t belong to any registered users on   this site,So registering....<br>';

// Creating WP User
wp_create_user( 'testuser4', 'testuser4', 'testuser4@aarc.org'); 
echo 'This email id is now registered thanks--->'.$email;
        
}
else
{
 echo "That E-mail id is already registered !! So, automatically signing in...";        

    $creds = array();
    $creds['user_login'] = 'anotheruser';
    $creds['user_password'] = 'anotherpass';
    $creds['remember'] = true;

        // Sigining in a WP User
    $user = wp_signon( $creds, true ); 

    if( is_wp_error($user))
    {

      echo 'oops!! we got some error in sigining in '.$user->get_error_message();

    }
    else
    {
       echo '<br>User is now logged in !!<br>';
   }        
}
ob_end_flush();
?> 	


</div>

<aside class="sidebar column fourcol last">
<?php get_sidebar(); ?>
</aside>
<?php get_footer(); ?>
