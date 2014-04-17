<?php
//Widget Name: Twitter Widget

class themex_twitter_widget extends WP_Widget {

	//Widget Setup
	function __construct() {
		$widget_ops = array('classname' => 'widget_recent_tweets', 'description' => __( 'The most recent tweets', 'academy' ) );
		parent::__construct('recent-tweets', __('Recent Tweets','academy'), $widget_ops);
		$this->alt_option_name = 'widget_recent_tweets';
		
		if ( is_active_widget( false, false, $this->id_base, true ) ) {
			add_action('wp_head', array($this, 'add_script'));
		}
	}

	//Widget view
	function widget( $args, $instance ) {
		extract($args, EXTR_SKIP);
		
		if($instance['username']=='') $instance['username']='themextemplates';
		if($instance['number']=='') $instance['number']='3';
		
		$out=$before_widget;
		
		//show title
		$title=apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Recent Tweets', 'academy' ) : $instance['title'], $instance, $this->id_base );
		$out.=$before_title.$title.$after_title;
		
		$out.='<ul class="tweets-list styled-list style-5"></ul>';
		$out.='<input type="hidden" class="twitter-username" value="'.$instance['username'].'" />';
		$out.='<input type="hidden" class="twitter-number" value="'.$instance['number'].'" />';
		$out.=$after_widget;
		
		echo $out;
	}

	//Update widget
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['username'] = $new_instance['username'];
		$instance['number'] = intval($new_instance['number']);
		return $instance;
	}
	
	//Add script
	function add_script() {
		?>
		<script type="text/javascript">
		function loadTweets(twitters) {
		  var statusHTML = [];
		  for (var i=0; i<twitters.length; i++){
			var username = twitters[i].user.screen_name;
			var status = twitters[i].text.replace(/((https?|s?ftp|ssh)\:\/\/[^"\s\<\>]*[^.,;'">\:\s\<\>\)\]\!])/g, function(url) {
			  return '<a href="'+url+'">'+url+'</a>';
			}).replace(/\B@([_a-z0-9]+)/ig, function(reply) {
			  return  reply.charAt(0)+'<a href="http://twitter.com/'+reply.substring(1)+'">'+reply.substring(1)+'</a>';
			});
			statusHTML.push('<li>'+status+'</li>');
		  }
		  return statusHTML.join('');
		}
		
		jQuery(document).ready(function($) {
			$('.<?php echo $this->alt_option_name; ?>').each(function() {
				var widget=$(this);
				var number=widget.find('input.twitter-number').val();
				var username=widget.find('input.twitter-username').val();
				$.getJSON('http://api.twitter.com/1/statuses/user_timeline/'+username+'.json?count='+number+'&callback=?', function(tweets) {
					widget.find('ul').html(loadTweets(tweets));
				});
			});
		});
		</script>
		<?php
	}
	
	//Widget form
	function form( $instance ) {
		//Defaults
		$defaults = array(
			'number'=>'3',
			'title'=>'',
			'username'=>'',
		);
		$instance = wp_parse_args( (array)$instance, $defaults ); ?>
		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'academy'); ?>:</label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('username'); ?>"><?php _e('Username', 'academy'); ?>:</label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'username' ); ?>" name="<?php echo $this->get_field_name( 'username' ); ?>" value="<?php echo $instance['username']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Tweets Number', 'academy'); ?>:</label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" value="<?php echo $instance['number']; ?>" />
		</p>
	<?php
	}
}
?>