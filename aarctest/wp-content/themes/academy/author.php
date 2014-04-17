<?php get_header(); ?>
<div class="sevencol column last">
	<?php if(ThemexUser::isProfilePage() && ($subscription=ThemexCourse::getSubscriptionTime())) { ?>
	<h2 class="secondary"><?php echo $subscription; ?>.</h2>
	<?php } ?>
	<?php if(ThemexUser::isProfilePage() || ThemexCore::getOption('user_courses')!='true') { ?>
	<?php if($courses=ThemexCourse::getUserCourses(ThemexUser::$data['current_user']->ID)) { ?>
	<div class="user-courses-listing">
	  <?php // counting courses
	    $max_courses = count($courses);
	  ?>
		<?php foreach($courses as $course) { ?>
		<?php ThemexCourse::initCourse($course->ID); ?>
		<?php 
		  /* Is course started?
		  if((!ThemexCourse::isCompletedCourse(0)) && (!ThemexCourse::isCompletedCourse(100))){
		    echo 'Course is started.';
		  } else if(ThemexCourse::isCompletedCourse()){
		    echo 'Course is complete.';
		  } else {
		    echo 'Course prerequisite is incomplete.';
		  } */
		  
		  // List the lessons
		  if(!empty(ThemexCourse::$data['course']['lessons'])) { 
          $lessons = ThemexCourse::$data['course']['lessons']; 
          $urls = array(); //create the array to hold the urls
          foreach($lessons as $lesson){ // for each lesson
            if(ThemexCourse::isMember() && !ThemexCourse::isCompletedLesson($lesson->ID)) { // if the lesson is incomplete
              $urls[] = get_permalink($lesson->ID); // store the incomplete lesson url in the array
            }
          }
          $current_lesson_url = $urls[0]; // return the url at the top of the array
  		}
		?>
		<div class="course-item <?php if(ThemexCourse::$data['course']['progress'] == 100) { ?>complete <?php } else { ?>incomplete <?php } ?>">
			<div class="course-title">
				<h4 class="nomargin"><a href="<?php echo $current_lesson_url; ?>"><?php echo get_the_title($course->ID); ?></a></h4>
				<div class="course-options right">
  				<?php if(ThemexCourse::isCompletedCourse()) { ?>
  				  <a href="<?php echo get_permalink($course->ID); ?>" class="button small"><span>Review Module</span></a>
  				<?php } else if( (0 < ThemexCourse::$data['course']['progress']) && (ThemexCourse::$data['course']['progress'] < 100) ) { ?>
  				  <a href="<?php echo get_permalink($course->ID); ?>" class="button small"><span>View Progress</span></a>
  				  <a href="<?php echo $current_lesson_url; ?>" class="button next-lesson continue-course small"><span>Continue Module <span class="button-icon next"></span></span></a>
  				<?php } else { ?>
  				  <a href="<?php echo $current_lesson_url; ?>" class="button next-lesson continue-course small"><span>Start Module <span class="button-icon next"></span></span></a>
  				<?php } ?>
				</div>
				<div style="padding:10px 0 0 0;">
				  <?php get_template_part('module', 'progress'); ?>	
				</div>
			</div>
			<?php if(ThemexCourse::$data['rating']!='true') { ?>
			<div class="course-meta">			
			<?php get_template_part('module','rating'); ?>			
			</div>
			<?php } ?>
		</div>
		<?php } ?>
	</div>
	<?php } else { ?>
	<h2 class="secondary"><?php _e('No courses yet.', 'academy'); ?></h2>
	<?php } ?>
	<?php } ?>
</div>
<?php get_footer(); ?>