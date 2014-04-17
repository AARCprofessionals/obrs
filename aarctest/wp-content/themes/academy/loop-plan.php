<?php $price=ThemexCourse::getPlanPrice($post->ID); ?>
<div class="widget plan-preview aligncenter">
	<div class="widget-title"><h1 class="nomargin aligncenter"><?php the_title(); ?></h1></div>
	<?php if(!empty($price)) { ?>
	<div class="plan-price"><?php echo $price; ?></div>
	<?php } ?>
	<div class="widget-content plan-description">	
	<?php the_content(); ?>	
	</div>
	<footer class="plan-footer">
	  <?php 
	  $user = get_current_user_id();
		$planUsers = ThemexCore::parseMeta($post->ID,'plan','users'); 
		
	  if(ThemexCourse::isSubscribed($post->ID)) { ?>
  		<form action="<?php echo ThemexCourse::getAction(get_permalink()); ?>" method="POST">
        <?php 
  		    $courses = ThemexCourse::getPlanCourses($post->ID); 
  		    foreach($courses as $idx=>$val){
  		      $name=htmlentities('course_id['.$idx.']');
            $value=htmlentities($val);
            echo '<input type="hidden" name="'.$name.'" value="'.$value.'">';
  		    }
  		  ?>
  			<input type="hidden" name="course_action" value="deregister" />
  			<input type="hidden" name="plan_id" value="<?php the_ID(); ?>" />
  			<a href="#" class="button submit-button <?php if(!ThemexCourse::isPrimaryPlan($post->ID)) { ?>secondary<?php } ?>"><span><?php _e('Unsubscribe', 'academy'); ?></span></a>
  		</form>
		<?php } else { ?>
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
    			<a href="#" class="button submit-button <?php if(!ThemexCourse::isPrimaryPlan($post->ID)) { ?>secondary<?php } ?>"><span><?php _e('Subscribe Now', 'academy'); ?></span></a>
    		</form>
		<?php } ?>
	</footer>
</div>