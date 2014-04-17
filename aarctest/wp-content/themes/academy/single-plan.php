<?php get_header(); ?>
<div class="column eightcol">
	<?php the_post(); ?>
	<?php 
/*  $planCategories = get_post_meta($id,'_plan_category');
  $planCategory = $planCategories[0];
  $terms = get_term_by( 'id', $planCategory, 'course_category' );
  $term = $terms->slug;
  $args = array(
    'post_type' => 'course',
    'course_category' => $term
  );
  $planCourses = get_posts($args);
  foreach($planCourses as $planCourse) { 
    setup_postdata( $planCourse );
    echo $planCourse->ID.'<br>';
  }
  wp_reset_postdata();
  
  echo '<br><br>';
  print_r($terms); */
//  print_r( ThemexCourse::getPlanCourses($post->ID) );
	?>
	<article class="single-post">
		<div class="post-content">
			<?php the_content(); ?>
			<?php 
  			if(ThemexCourse::isSubscribed($post->ID)){ ?>
  		    <form action="<?php echo ThemexCourse::getAction(get_permalink()); ?>" method="POST">
    			  <?php 
    			    $courses = ThemexCourse::getPlanCourses($post->ID); 
    			    //ThemexCourse::subscribeUser('2126', $user_id, true);
					foreach($courses as $idx=>$val){
    			      $name=htmlentities('course_id['.$idx.']');
                $value=htmlentities($val);
                echo '<input type="hidden" name="'.$name.'" value="'.$value.'">';
    			    }
    			  ?>
    				<input type="hidden" name="course_action" value="deregister" />
    				<input type="hidden" name="plan_id" value="<?php the_ID(); ?>" />
    				<input type="hidden" name="user_id" value="<?php echo get_current_user_id(); ?>" />			
    				<a href="#" class="button medium submit-button left"><span><?php _e('Unsubscribe', 'academy'); ?></span></a>
    			</form>
  		<?php	} else { ?>
			<form action="<?php echo ThemexCourse::getAction(get_permalink()); ?>" method="POST">
			  <?php 
			    $courses = ThemexCourse::getPlanCourses($post->ID); 
			    foreach($courses as $idx=>$val){
			      $name=htmlentities('course_id['.$idx.']');
            $value=htmlentities($val);
            echo '<input type="hidden" name="'.$name.'" value="'.$value.'">';
			    }
			  ?>
				<input type="hidden" name="course_action" value="register" />
				<input type="hidden" name="plan_id" value="<?php the_ID(); ?>" />				
				<a href="#" class="button medium submit-button left"><span><?php _e('Subscribe Now', 'academy'); ?></span></a>
			</form>
			<?php } ?>
		</div>
	</article>
</div>
<aside class="sidebar column fourcol last">
<?php get_sidebar(); ?>
</aside>
<?php get_footer(); ?>