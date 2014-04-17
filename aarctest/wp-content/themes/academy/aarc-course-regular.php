<?php
/*
Template Name: Course Modules - Regular
*/
?>
<?php get_header(); 
session_start();
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
          <div class="user-courses-listing" style="width: 80%;">
          <?php
			$recentposts = get_posts('numberposts=11&post_type=course&tag_ID=7&exclude=3643');
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