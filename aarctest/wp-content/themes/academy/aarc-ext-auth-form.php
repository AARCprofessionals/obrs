<?php
/*
Template Name: IMIS Registration Form
*/
?>
<?php get_header(); ?>


<!-- OBTAIN USER REGISTRATION DATA FROM WEBSTORE FORM & CREATE VARIABLES -->
<?php
$login = $_POST['login']; 		/* Get login from form */
$password = $_POST['password']; 	/* Get password from form */
$email = $_POST['email']; 		/* Get email from form */
$course = $_POST['coursefield']; 	/* Get course from form */
?>

<div class="column eightcol">

<!-- USER REGISTRATION FORM -->
<div style="float: left;">
<form action="http://192.168.1.51/aarctest/thank-you/" method="post">
	User Name <input type="text" name="login" placeholder="Enter your login ID">
	Password <input type="password" name="password" placeholder="Enter your password">
	Email <input type="email" name="email" placeholder="Enter a valid email">
	Course Registered For <input type="text" name="coursefield" placeholder="Enter the course type">
	<input type="submit" name="submit" value="Register">
</form>
</div>




</div>

<aside class="sidebar column fourcol last">
<?php get_sidebar(); ?>
</aside>
<?php get_footer(); ?>
