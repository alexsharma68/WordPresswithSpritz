<?php
class Spritz_Widget extends WP_Widget {
	function Spritz_Widget() {
		$widget_ops = array(
			'classname' 	=> 'spritz',
			'description' 	=> __('A widget that displays the Spritzer interface', 'WordPresswithSpritz')
		);
		$this->WP_Widget('sptitz-widget', __('Spritz','WordPresswithSpritz'), $widget_ops /*,$control_ops*/);
	}
	
	public function widget($args, $instance) {
		global $wpdb, $post;
		
		$title = apply_filters('widget_title', $instance['title']);

		echo $args['before_widget'];
		
		if (!empty($title)){
			echo $args['before_title'] . $title . $args['after_title'];
		}
		echo SpritzStarter($instance['number'],$instance['selector'],$style='',$instance['title']);
		echo $args['after_widget'];
	}

	//Update the widget 
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		//Strip tags from title and name to remove HTML 
		$instance['title'] 	= strip_tags($new_instance['title']);
		$instance['number'] = strip_tags($new_instance['number']);
		//$instance['selector'] = strip_tags($new_instance['selector']);
		return $instance;
	}

	function form($instance) {
		if (isset($instance['title'])) {
			$title = $instance['title'];
		} else {
			$title = '';
		}
		if (isset($instance['number'])) {
			$limit = $instance['number'];
		} else {
			$limit = 'body';
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php __('Title:','WordPresswithSpritz'); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
        
        <p>
			<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Content Target (URL or body):','WordPresswithSpritz'); ?></label>
			
			<br />
			
			<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo esc_attr($limit); ?>" style="width: 100%;" />
		</p>
		
       
	<?php
	}
}
?>