<?php
include('class/class.wordpress.with.spritz.helper.php');
$global=Spritz_Helper::usedFields();
if(isset($_POST['isconfic']) && $_POST['isconfic']=='isconfic'){
	$_POST['spritz_speed_option']					= isset($_POST['spritz_speed_option'])?'Y':'N';
	$_POST['spritz_controlls']						= isset($_POST['spritz_controlls'])?'Y':'N';
	$_POST['spritz_auto_detect']					= isset($_POST['spritz_auto_detect'])?'Y':'N';
	$_POST['spritz_wpm']							= implode(',',(isset($_POST['spritz_wpm'])?$_POST['spritz_wpm']:array()));
	$_POST['pause_play_control']					= isset($_POST['pause_play_control'])?'Y':'Y';
	$_POST['rewind_control']						= isset($_POST['rewind_control'])?'Y':'Y';
	$_POST['back_control']							= isset($_POST['back_control'])?'Y':'Y';
	$_POST['forward_control']						= isset($_POST['forward_control'])?'Y':'Y';
	$_POST['go_to_end_control']						= isset($_POST['go_to_end_control'])?'Y':'N';
	$_POST['activate_spritz_reader_content_types']	= implode(',',(isset($_POST['activate_spritz_reader_content_types'])?$_POST['activate_spritz_reader_content_types']:array()));
	$_POST['spritz_contents']						= implode(',',isset($_POST['spritz_contents'])?$_POST['spritz_contents']:array());
	$_POST['activate_spritz_box_on_certain_post']	= isset($_POST['activate_spritz_box_on_certain_post'])?'Y':'N';
	$_POST['include_spritz_reader_onfollowing_certain_post'] = isset($_POST['include_spritz_reader_onfollowing_certain_post'])?'Y':'N';
	$_POST['automatically_put_the_spritz_reader_at_the_top_of_my_content'] = isset($_POST['automatically_put_the_spritz_reader_at_the_top_of_my_content'])?'Y':'N';
}

if(isset($_POST['controlls_hidden'])){
	$_POST['image_tab_popup']						= isset($_POST['image_tab_popup'])?'Y':'N';
	$_POST['image_inline_popup']					= isset($_POST['image_inline_popup'])?'Y':'N';
	$_POST['created_by']							= isset($_POST['created_by'])?'Y':'N';	
	$_POST['make_responsive']						= isset($_POST['make_responsive'])?'Y':'N';
	$_POST['enable_spritzer_in_home_page']			= isset($_POST['enable_spritzer_in_home_page'])?'Y':'N';
}

if(isset($_POST['spirtz_exclude'])){
	$_POST['spirtz_exclude']						= str_replace("#", '|',$_POST['spirtz_exclude']);
}

if(isset($_POST['include_spritz_reader_on_following'])){
	$_POST['include_spritz_reader_on_following']	= implode(',',$_POST['include_spritz_reader_on_following']);
}

require_once('../../../wp-load.php');

//foreach($global as $key=>$val){ delete_option($val); } die();
if(!empty($_POST['ps_nonce'])) {
	if(isset($_POST['controlls_hidden']) || isset($_POST['isconfic'])){
		if(is_array($_POST) && sizeof($_POST)>0){
			foreach($_POST as $key=>$val){
				if(in_array($key,$global)){
					update_option($key,$val);
				}
			}
		}
		
		echo '[{"msg":"Configuration successfully updated.","color":"green"}]';
	}elseif(isset($_POST['post_types'])){
		$_old		= explode(',',get_option('spritz_contents'));
		$posts		= query_posts(array('post_type' =>$_POST['post_types'],'post_status'=>'publish'));
		$opt		= '';
		
		foreach($posts as $vels){
			$sel	= '';
			
			if(in_array($vels->ID,$_old)){
				$sel=" selected='selected' ";
			}
			
			$opt.="<option ".$sel." value='".$vels->ID."'>".$vels->post_title."</option>";
		}
		
		echo '[{"msg":"Configuration successfully updated.","color":"green","options":"'.$opt.'"}]';
	}elseif(isset($_POST['spritz_license_key'])){
		
		$old = get_option('spritz_license_key');
		$new = $_POST['spritz_license_key'];
		
		if($old && $old != $new ) {
			delete_option('spritz_license_status');
		}
		
		update_option('spritz_license_key', $_POST['spritz_license_key']);
		update_option('spritz_client_id', $_POST['spritz_client_id']);
		
		//if(isset($_POST['spritz_post_type']) && ($_POST['spritz_post_type']=='activate')){
			$spritz_license_key = trim(get_option('spritz_license_key'));
			define('EDD_SL_STORE_URL','http://www.wordpresswithspritz.com');
			$spritz_item_name = 'WordPresswithSpritz';
			$api_params = array(
				'edd_action'	=> 'activate_license',
				'license' 		=> $spritz_license_key,
				'item_name' 	=> urlencode($spritz_item_name),
				'url' 			=> EDD_SL_STORE_URL
			);
			$response = wp_remote_get(add_query_arg($api_params, EDD_SL_STORE_URL));
			
			if (is_wp_error($response))
				return false;
			
			$license_data = json_decode(wp_remote_retrieve_body($response));
			update_option('spritz_license_status', $license_data->license);
			core::doAction();
		//}
		
		if(get_option('spritz_license_status')=='valid'){
			echo '[{"msg":"License is active. Please wait... all features are being reloaded in the window.","status":"Invalid","spritz_license_status":"'.get_option('spritz_license_status').'","kay":"'.get_option('spritz_license_key').'","color":"green"}]';
		}else{
			if(get_option('spritz_license_key')==''){
				echo '[{"msg":"Inactive License.","status":"Inactive","spritz_license_status":"'.get_option('spritz_license_status').'","kay":"'.get_option('spritz_license_key').'","color":"red"}]';
			}else{
				echo '[{"msg":"Invalid License.","status":"Invalid","spritz_license_status":"'.get_option('spritz_license_status').'","kay":"'.get_option('spritz_license_key').'","color":"red"}]';
			}
		}
	}
}

if(!empty($_POST['option'])) {
	if($_POST['option']=='spirtz_exclude'){
		update_option('spirtz_exclude',SPRITZ__EXCLUDE);
		echo SPRITZ__EXCLUDE;
	}else if($_POST['option']=='content_region_include'){
		update_option('content_region_include',SPRITZ__INCLUDE);
		echo SPRITZ__INCLUDE;
	}
}
?>