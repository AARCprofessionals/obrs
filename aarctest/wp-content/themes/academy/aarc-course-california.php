<?php
/*
Template Name: Course Modules - California
*/
?>
<?php get_header(); 


$login = $_POST['Username']; 		/* Get login from form */
$password = $_POST['Password']; 	/* Get password from form */
$email = "wordpress@aarc.org";

//Create User id
$user_id=wp_create_user( $login, $password, $email );
//Assign User to course
ThemexCourse::subscribeUser(2128, $user_id, true);

?>

<div class="column eightcol">
	
    
	<!-- comment out sample code
    <?php echo('This is the California course modules template'); ?><br>
    <h2>A Listing of All Categories</h2>
    <?php list_cats(); ?>
    <br>
    <p>&nbsp;</p>
    end commenting of sample code -->          
      
      <!-- Query by post
      <h2>Query by Post</h2>
       
		<?php query_posts('showposts=5'); ?>
		<ul>
			<?php while (have_posts()) : the_post(); ?>
			<li><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></li>
			<?php endwhile;?>
		</ul>   
     end code for query by post -->
                	                
           
      <h1>Course Modules</h1>    
      <!-- Query a list of posts by post type -->
         <p><a href="?npcms_logout=true">Click here</a> to log out</p>
          <div class="user-courses-listing" style="width: 80%;">
          <?php
			$recentposts = get_posts('numberposts=22&post_type=course&tag_ID=10');
				foreach ($recentposts as $post) :
				setup_postdata($post);
			?>
			<li class="course-title" style="display: block;"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></li>
		 <?php endforeach; ?>      
         </div>     
    
    <!-- -->
 


</div>

<aside class="sidebar column fourcol last">
<?php get_sidebar(); ?>
</aside>
<?php get_footer(); ?>