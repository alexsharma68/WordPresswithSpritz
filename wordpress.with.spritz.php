<?php
/*
  Plugin Name: WordPress with Spritz
  Plugin URI: http://www.yokoco.com
  Description: WordPress with Spritz Plugin
  Version: 1.0
  Author: Yoko Co
  Author URI: http://www.yokoco.com
*/
ob_start();
define('SPRITZ', '1.0.0');
define('SPRITZ__PLUGIN_URL', plugin_dir_url(__FILE__));
define('SPRITZ__PLUGIN_DIR', plugin_dir_path(__FILE__));
$upload_dir = wp_upload_dir();
$spritz['box']=false;


/* ********************************************* */
/* Plugin Activation & Deactivation Code Start * */
/* ********************************************* */
register_activation_hook(__FILE__, 'spritz_install');
register_deactivation_hook(__FILE__, 'spritz_deactivate');
register_uninstall_hook('wordpress.with.spritz.uninstall.php', 'spritz_uninstall');
include_once('class/class.wordpress.with.spritz.widget.php');
include_once('class/class.wordpress.with.spritz.helper.php');
define('SPRITZ__EXCLUDE',Spritz_Helper::fieldsToOmit());
define('SPRITZ__INCLUDE',Spritz_Helper::fieldsToInclude());



/* ********************************************* */
/* Upgrading Files if Required ***************** */
/* ********************************************* */
function spritz_install() {
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    add_option('spritz_admin_email', 'info@spritzinc.com');
	add_option('spirtz_exclude',SPRITZ__EXCLUDE);
	add_option('content_region_include',SPRITZ__INCLUDE);
	add_option('spritz_start_text','Please Wait');
	add_option('spritz_end_text','The End');
	add_option('spritz_flyout_display_type','tab');
	add_option('popup_position','left');
	add_option('activate_spritz_reader_content_types',get_all_post());
	add_option('include_spritz_reader_onfollowing_certain_post','Y');
	add_option('include_spritz_reader_on_following',get_all_post());
	add_option('automatically_put_the_spritz_reader_at_the_top_of_my_content','Y');
}

function get_all_post(){
	$arr		= array();
	$args 		= array('public' => true);
	$output 	= 'names';
	$post_types = get_post_types($args, $output);
	
	if(($key = array_search('attachment',$post_types)) !== false) {
		unset($post_types[$key]);
	}
	
	return implode(',',$post_types);
}

function spritz_uninstall(){
	
}

function spritz_deactivate() {
	delete_option("spritz_admin_email");
	delete_option('spirtz_exclude');
	delete_option('content_region_include');
	delete_option('spritz_start_text');
	delete_option('spritz_end_text');
	delete_option('spritz_flyout_display_type');
	delete_option('popup_position');
	delete_option('activate_spritz_reader_content_types');
	delete_option('include_spritz_reader_onfollowing_certain_post');
	delete_option('include_spritz_reader_on_following');
	delete_option('automatically_put_the_spritz_reader_at_the_top_of_my_content');
}

function spritz() {
    add_menu_page('WordPress Spritz', 'WordPress Spritz', 'manage_options', 'config', 'spritz_configuration', SPRITZ__PLUGIN_URL . '/images/favicon.ico');
}

function spritz_configuration() {
    include_once(SPRITZ__PLUGIN_DIR.'wordpress.with.spritz.configuration.php');
}

function inc_textdomain() {
	$path=dirname( plugin_basename( __FILE__ ) ) . '/languages/';
	load_plugin_textdomain('WordPresswithSpritz', false, $path);
}

add_action('plugins_loaded', 'inc_textdomain');
function filter_content($content){
	$_old=explode(',',get_option('include_spritz_reader_on_following'));
	if(get_option('include_spritz_reader_onfollowing_certain_post')=='N') return $content;
	if (is_array($_old) && sizeof($_old)>0 && in_array($GLOBALS['post']->post_type,$_old)) {
		$top=(get_option('automatically_put_the_spritz_reader_at_the_top_of_my_content')=='Y')?'Y':'N';
		$_post_type_to_display=explode(',',get_option('activate_spritz_reader_content_types'));
		
		if(!empty($_post_type_to_display) && in_array($GLOBALS['post']->post_type,$_post_type_to_display)){
			$_content_to_display=explode(',',get_option('spritz_contents'));
			
			if(get_option('activate_spritz_box_on_certain_post')=='Y' && !empty($_content_to_display) && in_array($GLOBALS['post']->ID,$_content_to_display)){
				if($top=='Y'){
					return "[SpritzStarter selector='']".$content;
				 	//return "[SpritzStarter selector='#post-".$GLOBALS['post']->ID."']".$content;
				}else{
					//return $content."[SpritzStarter selector='#post-".$GLOBALS['post']->ID."']";
					return $content."[SpritzStarter selector='']";
				}
			}else if(get_option('activate_spritz_box_on_certain_post')=='N' || get_option('activate_spritz_box_on_certain_post')==''){
				if($top=='Y'){
					//return "[SpritzStarter selector='#post-".$GLOBALS['post']->ID."']".$content;
				 	return "[SpritzStarter selector='']".$content;
				}else{
					//return $content."[SpritzStarter selector='#post-".$GLOBALS['post']->ID."']";
					return $content."[SpritzStarter selector='']";
				}
			}
		}elseif(get_option('activate_spritz_reader_content_types')==''){
			if($top=='Y'){
				 	//return "[SpritzStarter selector='#post-".$GLOBALS['post']->ID."']".$content;
					return "[SpritzStarter selector='']".$content;
				}else{
					//return $content."[SpritzStarter selector='#post-".$GLOBALS['post']->ID."']";
					return $content."[SpritzStarter selector='']";
				}
		}
  }
  
  return $content;
}

add_filter('the_content', "filter_content");



/* ********************************************* */
/* Register CSS and JS Dependencies ************ */
/* ********************************************* */
add_action('admin_menu', 'spritz');
function spritz_ats_styles() {
	if(is_admin()){
        
		/* Admin Core Stylesheet */
		wp_register_style('spritz_admin_css', SPRITZ__PLUGIN_URL . 'css/spritz.admin.css');
        wp_enqueue_style('spritz_admin_css');
		
		/* jQuery Tabs for Admin Layout */
        wp_register_style('spritz_tabs', SPRITZ__PLUGIN_URL . 'css/spritz.tabs.css');
		wp_enqueue_style('spritz_tabs');
		
		/* jQuery UI CSS */
		wp_register_style('spritz_tabs_tab', SPRITZ__PLUGIN_URL . 'jquery-ui/jquery-ui-1.10.4.custom.css');
		wp_enqueue_style('spritz_tabs_tab');
		
		/* Font Awesome for Admin Icons */
		wp_register_style('spritz_icons', SPRITZ__PLUGIN_URL . 'css/font-awesome/css/font-awesome.min.css');
		wp_enqueue_style('spritz_icons');
		
		/* jQuery UI JS */
		wp_register_script('spritz_ud', SPRITZ__PLUGIN_URL .'js/jquery-ui.js');
		wp_enqueue_script('spritz_ud');
	}else{
		wp_register_style('spritz_icons', SPRITZ__PLUGIN_URL . 'css/font-awesome/css/font-awesome.css');
		wp_enqueue_style('spritz_icons');
		
		/* Core CSS for Frontend */
		wp_register_style('spritz_core', SPRITZ__PLUGIN_URL . 'css/spritz.wp.css');
		wp_enqueue_style('spritz_core');
		
		/* Light Theme (default) Style */
		if(get_option('spritz_themes')=='light' || get_option('spritz_themes')==''){
			wp_register_style('spritz_light', SPRITZ__PLUGIN_URL . 'css/theme/spritz.light.css');
			wp_enqueue_style('spritz_light');
		}else{
			/* Dark Theme Style */
			wp_register_style('spritz_dark', SPRITZ__PLUGIN_URL . 'css/theme/spritz.dark.css');
			wp_enqueue_style('spritz_dark');
		}
		
		/* For Responsive */
		if(get_option('make_responsive')=='Y'){
			wp_register_style('spritz_responsive', SPRITZ__PLUGIN_URL . 'css/spritz.responsive.css');
			wp_enqueue_style('spritz_responsive');
		}
	}
}



/* ********************************************* */
/* Widget ************************************** */
/* ********************************************* */
add_action('widgets_init', 'spritz_widget');
function spritz_widget() {
    register_widget('Spritz_Widget');
}



/* ********************************************* */
/* Color Picker ******************************** */
/* ********************************************* */
add_action('admin_enqueue_scripts', 'wp_enqueue_color_picker');
function wp_enqueue_color_picker( ) {
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('wp-color-picker-script', plugins_url('js/tabs.js', __FILE__), array('wp-color-picker'), false, true);
}



/* ********************************************* */
/* ATS Styles ********************************** */
/* ********************************************* */
add_action('init', 'spritz_ats_styles');
$SP['included']=array();
function spritz_start($atts) {
    global $wpdb,$post,$wp_query,$SP;
    $html = '';
	
    extract(shortcode_atts(array(
        'target' 	=> '',
		'selector' 	=> '',
		'style'		=> '',
		'title'		=> ''
	), $atts));
	
	$data = '';
	
	if($selector!=''){
		$data = $selector;
	}
	
	if(!in_array($post->ID,$SP['included'])){
		$SP['included'][]=$post->ID;
		return SpritzStarter($target, $data, $style, $title);
		
	}
}



/* ********************************************* */
/* Short Code ********************************** */
/* ********************************************* */
add_shortcode('SpritzStarter', 'spritz_start');
function wp_theme_adding_scripts() {
	wp_enqueue_script('jquery');
}
add_action('wp_enqueue_scripts', 'wp_theme_adding_scripts' );


/* ********************************************* */
/* Add Header Content ************************** */
/* ********************************************* */
add_action('wp_head', 'header_content', 50);
function spritzer_admin_scripts() {
	if (isset($_GET['page']) && $_GET['page'] == 'config') {
		wp_enqueue_script('jquery');
		wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');
	}
}

function spritzer_admin_styles() {
	if (isset($_GET['page']) && $_GET['page'] == 'config') {
		wp_enqueue_style('thickbox');
	}
}

add_action('admin_print_scripts', 'spritzer_admin_scripts');
add_action('admin_print_styles', 'spritzer_admin_styles');
function get_selector(){
	
	/* ********************************************* */
	/* Tags to Omit ******************************** */
	/* ********************************************* */
	return $omits = get_option('content_region_include');	
}



/* ********************************************* */
/* Header Content Output *********************** */
/* ********************************************* */
function header_content(){
?>
<script type="text/javascript">
	<?php
		$redicleWidth		= 340;
		$redicleHeight		= 70;
		$controlSize		= "normal";
		if(get_option('spritz_redicle_size')=='small'){
			//$redicleWidth	= 250;									    // Specify redicle width
			//$redicleHeight= 50;
		}elseif(get_option('spritz_redicle_size')=='large'){
			//$redicleWidth	= 600;									    // Specify redicle width
			//$redicleHeight= 120;
		}
	?>
	var SpritzSettings = {
		clientId					: "<?php echo ((get_option('spritz_client_id')=='') ? 'fee1145ba10a4e2c3' : get_option('spritz_client_id')); ?>",
		redirectUri					: "<?php echo SPRITZ__PLUGIN_URL; ?>wordpress.with.login.success.html",
	};
	<?php
	if(get_option('spritz_wpm')!=''){
	?>
	var items = eval("[<?php echo get_option('spritz_wpm'); ?>]");
	<?php
	}
	?>
	var customOptions = {
		redicleWidth 				: <?php echo (int) $redicleWidth; ?>,
		redicleHeight 				: <?php echo (int) $redicleHeight; ?>,
		<?php if(get_option('spritz_wpm')!=''){ ?>
		speedItems 					: items,
		<?php } ?>
		<?php if(get_option('spritz_default_speed')!=''){ ?>
		"defaultSpeed":<?php echo (int)get_option('spritz_default_speed'); ?>,
		<?php } ?>
		placeholderText				:
		{
			startText 				: '<?php echo get_option('spritz_start_text'); ?>',
			endText					: '<?php echo get_option('spritz_end_text'); ?>',
		},
		"controlButtons" 			: ["rewind","back","pauseplay","forward"],
		"controlTitles" 			:
		{
			"pause" 				: "Pause",
			"play" 					: "Play",
			"rewind" 				: "Rewind",
			"back" 					: "Previous Sentence",
			"end"					: "Go to End",
			"forward"				: "Forward"
		},
		redicle: {
			backgroundColor 		: "<?php echo (get_option('spritz_redicle_bg_color')!='') ? get_option('spritz_redicle_bg_color') : '#fff'; ?>",
			textNormalPaintColor 	: "<?php echo (get_option('text_normal_paint_color')!='') ? get_option('text_normal_paint_color') : '#333'; ?>",
			textHighlightPaintColor : "<?php echo (get_option('text_highlight_paint_color')!='') ? get_option('text_highlight_paint_color') : '#cc0001'; ?>", // Red ORP
			redicleLineColor 		: "<?php echo (get_option('redicle_line_color')!='') ? get_option('redicle_line_color') : '#000'; ?>",
			redicleLineWidth		: 1,
			countdownTime			: 750,                 	// milliseconds
			countdownSlice			: 5,                  	// milliseconds
			countdownColor			: "rgba(0,0,0,0.1)"   	// rgba colors work too
		}
		
	}
</script>
<script type="text/javascript" src="//sdk.spritzinc.com/js/1.2/js/spritz.min.js"></script>
<?php
}
$count=0;
function SpritzStarter($target='',$selector='',$style='',$title=''){
	global $count;
	global $post;
	global $spritz;
	
	
	if((get_option('spritz_flyout_display_type')!='inline' && get_option('spritz_flyout_display_type')!='popup') && ($count>1)){
		return '';
	}
	//if((get_option('make_responsive')=='Y') && ($count>1)){
	if($count>0){
		return '';
	}
	
	if((get_option('enable_spritzer_in_home_page')=='N') && is_home()){
		return '';
	}
	
	$_post_type_to_display=explode(',',get_option('activate_spritz_reader_content_types'));
	if(!empty($_post_type_to_display) && !in_array($post->post_type,$_post_type_to_display)){
		return '';
	}
	
	$_content_to_display=explode(',',get_option('spritz_contents'));
	if(get_option('activate_spritz_box_on_certain_post')=='Y' && !empty($_content_to_display) && !in_array($post->ID,$_content_to_display)){
		return '';
	}
	ob_start();
	$id = time().$count;
	
	
	
	/* ********************************************* */
	/* Display Style Classes *********************** */
	/* ********************************************* */
	$classes 		= 'spritztabwpopup';
	$_option 		= '';
	$_style 		= 'none';
	$_url 			= ($target=='body' || $target=='all' || $target=='') ? 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] : $target;
	
	if(get_option('spritz_flyout_display_type')=='tab' || get_option('spritz_flyout_display_type')==''){
		$classes 	= 'spritztabwpopup'; 		/* Tab Popup */
	}elseif(get_option('spritz_flyout_display_type')=='popup'){
		$classes 	= 'spritzinlinewpopup'; 	/* Inline Popup */
	}else{
		$classes 	= 'spritzinlinereader'; 	/* Inline Reader */
		$_style		= "block";
		$_option 	= ' data-selector="' . (($selector=='')?get_selector():$selector) . '" 
		data-url="' .SPRITZ__PLUGIN_URL.'wordpress.with.spritz.content.filter.php?url='.$_url . '&selector='.get_option('spirtz_exclude').'&tages="';
	}
	
	
	
	/* ********************************************* */
	/* Popup Structure ***************************** */
	/* ********************************************* */
	$popupElement='<div class="' . $classes . ' spritzer_popup '.get_option('spritz_themes').' '.((get_option('make_responsive')=='Y' && get_option('spritz_flyout_display_type')!='popup')?'responsive':'').'" style="display : '.$_style.';">
			<div class="spritzer_frame">
				<div class="spritzer_title">';
				if(get_option('spritz_flyout_display_type')!='inline'){
				$popupElement.='<a class="close_icon '.$classes.'_close">&nbsp;</a>';
				}
				$popupElement.='</div><div id="spritzer' . $id . '" data-options=\'{"defaultSpeed":'.get_option('spritz_default_speed').'}\' data-role="spritzer" ' . $_option . ' class="spritzer ' . get_option('css_classes_for_spritzer_div') . '">
					<div class="clear"></div>
				</div>
				
				<div class="clear"></div>
			</div>
			
			<div class="clear"></div>
		</div>
	';
	
	
	
	/* ********************************************* */
	/* Reader Button Classes *********************** */
	/* ********************************************* */
	$readerbuttonclasses = 'tabpopup ';
	
	if(get_option('spritz_flyout_display_type')=='tab' || get_option('spritz_flyout_display_type')==''){
		$readerbuttonclasses = 'tabpopup '; 													/* Tab Popup */
	}elseif(get_option('spritz_flyout_display_type')=='popup'){
		$readerbuttonclasses = 'inlinepopup ' . get_option('display_inline_popup_position'); 	/* Inline Popup */
	}else{
		$readerbuttonclasses = 'inlinereader ' . get_option('display_inline_popup_position'); 	/* Inline Reader */
	}
	
	
	
	/* ********************************************* */
	/* Read Button lacement for Tab *************** */
	/* ********************************************* */
	if($count==0 && get_option('spritz_flyout_display_type')=='inline'){
		$count++;
		echo $popupElement;
		
	}
	
	if(get_option('spritz_flyout_display_type')!='inline'){
	?>
		<a data-target="<?php echo $_url; ?>" 
			data-selector='<?php echo $selector; ?>' 
			class='spritz_start <?php echo $readerbuttonclasses; ?>' 
			href='javascript:void(0)' 
			data-position='
			<?php 
				$po=(get_option('popup_position')=='') ? 'left' : get_option('popup_position');
				echo (get_option('spritz_flyout_display_type')=='tab' || get_option('spritz_flyout_display_type')=='') ? $po : '';
			?>'>
		</a>
        
    <?php
	}
	
	if($count==0 && (get_option('spritz_flyout_display_type')=='popup' || get_option('spritz_flyout_display_type')=='tab')){
		$count++;
		echo $popupElement; 
		
	}
	if(get_option('make_responsive')=='Y'){
			?>
            <script type="text/javascript">
			var j = jQuery.noConflict();
				j(document).ready(function(){
					// j('.spritzer_popup').prependTo('body');
				})
			</script>
        <?php
		}
	if(get_option('spritz_flyout_display_type')!='inline'){
	?>
    <script type="text/javascript">
	var j = jQuery.noConflict();
	j(document).ready(function(){
		j.each(j(".spritzer"),function(){
			j(this).data("controller").applyOptions(customOptions);
		})
	})
    </script><?php
	}elseif(get_option('spritz_flyout_display_type')=='inline'){
		?>
         <script type="text/javascript">
			var j = jQuery.noConflict();
			var url;
			var selector;
			
			j(document).ready(function(){
				
				j.each(j(".spritzer"),function(){
					
					selector=(typeof(j(this).data('selector')) != 'undefined') ? j(this).data('selector'):'';
					
					if(selector==''){
						if("<?php echo get_selector(); ?>" != ''){
							selector='<?php echo get_selector(); ?>';
						}else{
							selector='';
						}
					}else{
						selector=selector;
					}
					
					url = (typeof(j(this).data('url')) != 'undefined') ? j(this).data('url'):'';
					var urls="<?php echo SPRITZ__PLUGIN_URL.'wordpress.with.spritz.content.filter.php?url='; ?>"+url+"<?php echo "&selector=".get_option('spirtz_exclude');?>&tages=";
					
					j(this).data("controller").applyOptions(customOptions)
					j(this).data("controller").loadText(false, {url:urls,selector:selector})
					
				})
				
				
			})
		</script>
        
		<?php
	}
	$page = ob_get_contents();
    ob_end_clean();
    return $page;
}
/* *********************************************************************************** */
/* Head Script: Start **************************************************************** */
/* *********************************************************************************** */
add_action('wp_head', 'headscript', 52);

function headscript(){
	global $spritz;
	$width				= 140;
	$height				= 22;
	$position_option	= '';
	
	// Tab and Left or Right
	if((get_option('spritz_flyout_display_type')=='tab' || (get_option('spritz_flyout_display_type')=='')) && (get_option('popup_position')=='left' || get_option('popup_position')=='right' || get_option('popup_position')=='')){
		$width			= 52;
		$height			= 173;
		$r				= (get_option('popup_position')=='right') ? 'transform: rotate(180deg); -webkit-transform: rotate(180deg);-ms-transform: rotate(180deg);' : '';
		$position_option='position: fixed; top: 40%;' . ((get_option('popup_position')=='right') ? 'right' : 'left') . ' : -26px; ' . $r;
	}
	
	// Tab and Top or Bottom
	else if(get_option('spritz_flyout_display_type')=='tab' && (get_option('popup_position')=='top' || get_option('popup_position')=='bottom')){
		$width			= 173;
		$height			= 52;
		$position_option= 'position: fixed; margin-left: -' . ($width/2) . 'px;left:50%;' . ((get_option('popup_position')=='top') ? 'top' : 'bottom') . ' : -' . ($height/2) . 'px;';
	}elseif(get_option('spritz_flyout_display_type')=='popup' || get_option('spritz_flyout_display_type')=='inline'){
		$width			= (get_option('button_title_graphic_size')=='small' || get_option('button_title_graphic_size')=='') ? '140' : '268';
		$height			= (get_option('button_title_graphic_size')=='small' || get_option('button_title_graphic_size')=='') ? '22' : '42';
		$position_option= 'position: relative; left: 50%';
	}
	?>
	<style type="text/css">
	
	/* ********************************************* */
	/* Popup Container CSS ************************* */
	/* ********************************************* */
	.spritzer_popup {
		<?php if(get_option('spritz_flyout_display_type')=='tab' || get_option('spritz_flyout_display_type')=='popup' || get_option('spritz_flyout_display_type')==''){ ?>
		
		<?php /*
		position: fixed;
		top: 0;
		left: 0;
		z-index: 999999;
		height: 100%;
		background-color: rgba(0,0,0,0.2);
		*/ ?>
		
		<?php } ?>
		}
	
	/* ********************************************* */
	/* Spritzer Frame ****************************** */
	/* ********************************************* */
	.spritzer_frame {
		<?php if(get_option('spritz_flyout_display_type')=='tab' || get_option('spritz_flyout_display_type')=='popup' || get_option('spritz_flyout_display_type')==''){ ?>
		
		<?php /*
		position: relative;
		top: 50%;
		margin-top: -125px;
		width: auto;
		*/ ?>
		
		<?php } ?>
		background-color: <?php echo (get_option('bg_color_for_spritz_plugin_frame')!='') ? get_option('bg_color_for_spritz_plugin_frame') : '#fff'; ?>;
		}
	


	/* ********************************************* */
	/* Popup Title ********************************* */
	/* ********************************************* */
	.spritzer_title {
		<?php if(get_option('spritz_flyout_display_type')=='inline'){ ?>
		
		<?php /*
		float: right;
		width: 33%;
		min-height: 188px;
		background: url(<?php echo ((get_option('created_by')!='N' && get_option('created_by')!=''))?get_option('spritz_logo'):SPRITZ__PLUGIN_URL.'images/wordpress_spritz1.png'; ?>) bottom left no-repeat;
		*/ ?>
		
		height: 185px;
		background: url("<?php echo ((get_option('created_by')!='N' && get_option('created_by')!=''))?get_option('spritz_logo') : SPRITZ__PLUGIN_URL.'images/wordpress_spritz1.png'; ?>") 17px 92% no-repeat;
		background-size: 100%;
		
		<?php } if(get_option('spritz_flyout_display_type')=='tab' || get_option('spritz_flyout_display_type')=='popup' || get_option('spritz_flyout_display_type')==''){ ?>
		
		<?php /*
		display: block;
		width: 100%;
		height: 70px;
		background: #f4f4f4 url(<?php echo (get_option('created_by')=='Y' && get_option('spritz_logo')!='') ? get_option('spritz_logo') : SPRITZ__PLUGIN_URL . 'images/wordpress_spritz1.png'; ?>) left center no-repeat;
		*/ ?>
		
		height: 70px;
		background: url("<?php echo (get_option('created_by')=='Y' && get_option('spritz_logo')!='') ? get_option('spritz_logo') : SPRITZ__PLUGIN_URL . 'images/wordpress_spritz1.png'; ?>") 17px 52% no-repeat;
		<?php } ?>
		<?php if((get_option('created_by')=='Y' && (get_option('spritz_logo')==''))){ ?>
		
		<?php /*
		width: 15px;
		background-image: none;
		*/ ?>
		
		height: 0;
		background-image: none;
		<?php
		}
		?>
		}
		
		/* If Responsive */
		div.spritzer_popup.responsive .spritzer_title {
			background-size: auto;
			}
	
	
	
	/* ********************************************* */
	/* Popup Start Button ************************** */
	/* ********************************************* */
	.spritz_start {
		<?php
		$bg_url='';
		
		if(
			(get_option('spritz_flyout_display_type')=='tab' || get_option('spritz_flyout_display_type')=='') 
			&& get_option('image_tab_popup')=='Y' && get_option('spritz_title_image')!=''){
			$bg_url = get_option('spritz_title_image');
		}elseif(
			(get_option('spritz_flyout_display_type')=='popup' || get_option('spritz_flyout_display_type')=='inline') 
			&& get_option('image_inline_popup')=='Y' && get_option('inline_spritz_title_image')!=''){
			$bg_url = get_option('inline_spritz_title_image');
		}else{
			if(get_option('spritz_flyout_display_type')=='tab' || get_option('spritz_flyout_display_type')==''){
				if(get_option('popup_position')=='top'){
					$bg_url =SPRITZ__PLUGIN_URL.'images/Spritz_Tab_Solo_top.png';
				}else{
					$bg_url = SPRITZ__PLUGIN_URL . 'images/Spritz_Tab_Solo.png';
				}
			}else{
				if(get_option('button_title_graphic_size')=='small' || get_option('button_title_graphic_size')==''){
					$bg_url = SPRITZ__PLUGIN_URL . 'images/Spritz_Button_Solo.png';
				}else{
					$bg_url = SPRITZ__PLUGIN_URL . 'images/Spritz_Button_Solo_Large.png';
				}
			}
		}
		?>
		width: <?php echo $width; ?>px !important;
		height: <?php echo $height; ?>px !important;
		background-image: url("<?php echo $bg_url; ?>") !important;

		<?php echo $position_option; ?>
		}

	<?php echo stripslashes(get_option('custom_css_spritz')); ?>

	<?php if(get_option('spritz_speed_option')=='N'){ ?>
	/* ********************************************* */
	/* Hide Spritz Speed *************************** */
	/* ********************************************* */
	.spritzer-speed {
		display: none !important;
		}
	<?php } ?>

	<?php /*if(get_option('spritz_controlls')=='N'){ * /?>
	/ * ********************************************* * /
	/ * Hide Spritz Controls ************************ * /
	/ * ********************************************* * /
	.spritzer-button-container {
		display: none !important;
		}
	<?php / * } */ ?>

	<?php if(get_option('powerby')=='N'){ ?>
	/* ********************************************* */
	/* Remove Powered By *************************** */
	/* ********************************************* */
	.spritzer-logo {
		<?php /*
		background-image: none !important;
		display: none;
		*/ ?>
		}
	<?php } ?>
	
	<?php if(get_option('make_responsive')=='Y'){ ?>
	/* ********************************************* */
	/* Responsive Output *************************** */
	/* ********************************************* */
	
	a.close_icon.spritzinlinereader_close { display: none !important; }
	
	<?php if(get_option('spritz_flyout_display_type')=='inline'){ ?>
	body{
		padding-top: 0;
		}
		div.spritzer_popup.responsive {
			display: none !important;
			}
	<?php } ?>
	@media screen and (min-width: 0) and (max-width: <?php echo get_option('spritz_responsive_width'); ?>px) {
		<?php if(get_option('spritz_flyout_display_type')=='inline'){ ?>
		body.responsivespritz {
			padding-top: 250px;
			}
			div.spritzer_popup.responsive {
				position: fixed;
				top: 0;
				left: 0;
				z-index: 9999999;
				margin: 0 !important;
				display: block !important;
				width: 100% !important;
				}
		<?php } ?>
		div.spritzer_popup.responsive:first-child {
			position: fixed;
			top: 0;
			left: 0;
			z-index: 9999999;
			margin: 0 !important;
			width: 100% !important;
			/* display: block !important; */
			
			-webkit-border-radius: 	0;
			-moz-border-radius: 	0;
			border-radius: 			0;
			}

			div.spritzer_popup.responsive div.spritzer_frame {
				margin: 0 auto;
				width: 100%;
				
				-webkit-border-radius: 	0;
				-moz-border-radius: 	0;
				border-radius: 			0;
				}
				
				/* Title and Logos */
				div.spritzer_popup.responsive div.spritzer_title { /* Logo Assigned to this Selector */
					float: none;
					width: 100%;
					height: 70px;
					
					-webkit-border-radius: 	0;
					-moz-border-radius: 	0;
					border-radius: 			0;
					}
					div.spritzer_popup.spritzinlinereader a.close_icon {}
				
				/* Reader */
				div.spritzer_popup.responsive div.spritzer { /* Custom Class Assigned to this Selector */
					margin: 0 auto;
					width: 100%;
					float: none;
					
					-webkit-box-sizing: border-box;
					-moz-box-sizing: 	border-box;
					box-sizing: 		border-box;
					}
					
					/* Reader Container */
					div.spritzer_popup.responsive div.spritzer-container {
						margin: 0 auto;
						max-width: 370px;
						}
	}
	<?php } ?>
	
	a {
		outline: none;
		}
	</style>
	
	<?php if(get_option('make_responsive')=='Y'){ ?>
	<script type="text/javascript">
	jQuery(window).ready(function($){
		var viewportWidth = $(window).width();
		<?php /* console.log('Initial screen width is: ' + viewportWidth + 'px'); */ ?>
		
		if((viewportWidth <= <?php echo get_option('spritz_responsive_width'); ?>) && ($('div.spritzinlinereader').hasClass('responsive') )) {
			$('body').addClass('responsivespritz');
			$('body').removeClass('nonresponsivespritz');
		} else {
			$('body').removeClass('responsivespritz');
			$('body').addClass('nonresponsivespritz');
		}
		
		$(window).resize(function(){
			var viewportWidth = $(window).width();
			<?php /* console.log('Screen width is currently: ' + viewportWidth + 'px'); */ ?>
			
			if((viewportWidth <= <?php echo get_option('spritz_responsive_width'); ?>) && ($('div.spritzinlinereader').hasClass('responsive') )) {
				$('body').addClass('responsivespritz');
				$('body').removeClass('nonresponsivespritz');
			} else {
				$('body').removeClass('responsivespritz');
				$('body').addClass('nonresponsivespritz');
			}
			
		});
	});
	</script>
	<?php } ?>
<?php
}
/* *********************************************************************************** */
/* Head Script: Start **************************************************************** */
/* *********************************************************************************** */
?>
<?php
function edd_sample_register_option() {
	// creates our settings in the options table
	register_setting('spritz_license', 'spritz_license_key', 'spritz_sanitize_license');
}

add_action('admin_init', 'edd_sample_register_option');
function spritz_sanitize_license( $new ) {
	$old = get_option('spritz_license_key');
	if($old && $old != $new) {
		delete_option('spritz_license_status'); // new license has been entered, so must reactivate
	}
	return $new;
}
?>
<?php
function spritz_activate_license_client() {

	if( isset($_POST['spritz_license_activate'])) {

		if(! check_admin_referer('spritz_nonce', 'spritz_nonce'))
			return;
		$spritz_license_key = trim(get_option('spritz_license_key'));
		define('EDD_SL_STORE_URL','http://www.wordpresswithspritz.com');
		$spritz_item_name='WordPresswithSpritz';
		
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
	}
}
add_action('admin_init', 'spritz_activate_license_client');
add_action('wp_footer', 'footer');
function footer(){
	global $count;
	//echo $count." - Total ";
?>
<script type="text/javascript">
	var j = jQuery.noConflict();
	
	j(document).ready(function(e) {
		<?php
		if(get_option('spritz_flyout_display_type') != 'inline'){
		?>
		j('body').append('<div class="spritzpopup_backdrop"></div>');
		j(".spritzpopup_backdrop").css({'display' : 'none'});
		<?php
		}
		?>
		var sPopupWidth  = j(".spritzer_popup").width();
		var sPopupHeight = j(".spritzer_popup").height();
		
		<?php
		// Reader Type for Display Positioning
		if(get_option('spritz_flyout_display_type') == 'tab' || get_option('spritz_flyout_display_type') == ''){
		?>
		j(".spritzer_popup").css({'margin' : '-' + (sPopupHeight/3.25) + 'px 0 0 -' + (sPopupWidth/1.85) + 'px'});	/* Tab Popup */
		<?php
		}elseif(get_option('spritz_flyout_display_type')=='popup'){ ?>
		j(".spritzer_popup").css({'margin' : '-' + (sPopupHeight/3.25) + 'px 0 0 -' + (sPopupWidth/1.85) + 'px'});	/* Inline Popup */
		<?php
		}else{
		?>
		j(".spritzer_popup").css({});	 																			/* Inline Reader */
		<?php
		}
		?>
		j('body').on('click','.spritzinlinewpopup_close,.spritztabwpopup_close,.spritzpopup_backdrop',function(event){
			if(j(event.target).hasClass('spritzinlinewpopup_close') || j(event.target).hasClass('spritztabwpopup_close') || j(event.target).hasClass('spritzpopup_backdrop')){
				if(typeof(j(".spritzer").data("controller")) != 'undefined'){
					var sp = j(".spritzer").data("controller");
					sp.stopSpritzing()
				}
				
				if(j(this).hasClass("spritzpopup_backdrop")){
					j().closes(j(this));
					j().closes(j(".spritzer_popup"));
				}else{
					j().closes(j(".spritzpopup_backdrop"));
					j().closes(j(this).parents(".spritzer_popup"));
				}
			}
		})
		
		j.fn.closes = function(e){
			<?php
			if(get_option('make_responsive')=='Y'){
				?>
				if(j(window).width()<parseInt("<?php echo get_option('spritz_responsive_width'); ?>")){
					j('body').animate({'padding-top':'0px'},500);
				}
				<?php
			}
			?>
			e.fadeOut(500,function(){j(this).hide()});
		}
		
		j.fn.opens = function(e){
			<?php
			if(get_option('make_responsive')=='Y'){
				?>
				if(j(window).width() < parseInt("<?php echo get_option('spritz_responsive_width'); ?>")){
					//j('body').animate({'padding-top':'250px'},500);
				}
				<?php
			}
			?>
			e.fadeIn(500,function(){j(this).show()});
		}
		
		j('body').on('click','.tabpopup,.inlinepopup',function(event){ /* Other clicked */
			
			var selector = (typeof(j(this).data('selector'))!='undefined') ? j(this).data('selector') : '';
			
			if(selector==''){
				if("<?php echo get_selector(); ?>" != ''){
					selector='<?php echo get_selector(); ?>';
				}else{
					selector = '';
				}
			}else{
				selector = selector;
			}
			
			var url = (typeof(j(this).data('target')) != 'undefined') ? j(this).data('target') : '';
			var urls="<?php echo SPRITZ__PLUGIN_URL.'wordpress.with.spritz.content.filter.php?url='; ?>"+url+"<?php echo "&selector=".get_option('spirtz_exclude');?>&tages=";
			
			if(urlfilter(url)){
				if(selector == ''){
					SpritzClient.fetchContents(urls, onSpritzifySuccess, onSpritzifyError);
				}else{
					SpritzClient.fetchContents(urls, onSpritzifySuccess, onSpritzifyError,selector);
				}
			}else{
				var urls="<?php echo SPRITZ__PLUGIN_URL.'wordpress.with.spritz.content.filter.php?url='; ?>"+document.URL+"<?php echo "&selector=".get_option('spirtz_exclude');?>&tages=";
				
				if(selector == ''){
					SpritzClient.fetchContents(urls, onSpritzifySuccess, onSpritzifyError);
				}else{
					SpritzClient.fetchContents(urls, onSpritzifySuccess, onSpritzifyError,selector);
				}
			}
			
			j().opens(j(".spritzer_popup,.spritzpopup_backdrop"));
			j().whenResize();
		})
		
		/* Inline Reader */
		j('body').on('click','.inlinereader',function(event){ /* remove .inlinereader */
			if(j(this).hasClass('activeReader')){
				var sp = j(this).prev(".spritzer_popup").find(".spritzer");
				
				if(typeof(sp.data("controller")) != 'undefined'){
					sp.data("controller").stopSpritzing();
				}
				
				j(this).prev(".spritzer_popup").slideUp();
				j(this).removeClass('activeReader');
				j(this).prev(".spritzer_popup").removeClass('activeReader');
			}else{
				j(this).addClass('activeReader');
				j(this).prev(".spritzer_popup").addClass('activeReader lastClick');
				j(this).prev(".spritzer_popup").slideDown();
			
				var selector = (typeof(j(this).data('selector'))!='undefined') ? j(this).data('selector') : '';
				
				if(selector == ''){
					if("<?php echo get_selector(); ?>" != ''){
						selector='<?php echo get_selector(); ?>';
					}else{
						selector='';
					}
				}else{
					selector=selector;
				}
				
				selector = getSelector(selector);
				var url = (typeof(j(this).data('target')) != 'undefined') ? j(this).data('target') : '';
				var urls="<?php echo SPRITZ__PLUGIN_URL.'wordpress.with.spritz.content.filter.php?url='; ?>"+urls+"<?php echo "&selector=".get_option('spirtz_exclude');?>&tages=";
				
				if(urlfilter(url)){
					if(selector == ''){
						SpritzClient.fetchContents(urls, onSpritzifySuccess, onSpritzifyError);
					}else{
						SpritzClient.fetchContents(urls, onSpritzifySuccess, onSpritzifyError,selector);
					}
				}else{
					var urls="<?php echo SPRITZ__PLUGIN_URL.'wordpress.with.spritz.content.filter.php?url='; ?>"+document.URL+"<?php echo "&selector=".get_option('spirtz_exclude');?>&tages=";
					
					if(selector == ''){
						SpritzClient.fetchContents(urls, onSpritzifySuccess, onSpritzifyError);
					}else{
						SpritzClient.fetchContents(urls, onSpritzifySuccess, onSpritzifyError,selector);
					}
				}
			}
		})

		j('body').on('click','.spritzinlinereader_close',function(event){
			var realObj = j(this).parents(".spritzer_popup");
			
			if(realObj.hasClass('activeReader')){
				var sp = realObj.find(".spritzer");
				
				if(typeof(sp.data("controller")) != 'undefined'){
					sp.data("controller").stopSpritzing();
				}
			}
			
			if(realObj.hasClass('activeReader')){
				realObj.removeClass('activeReader');
			}
			
			realObj.parent().find('a.spritz_start').removeClass('activeReader');
			realObj.slideUp(500,function(){ /*realObj.prev().slideDown(); */ });
		})
		
		j('.tabpopup').mouseenter(function(){
			var e = j.trim(j(this).data('position'))
			switch(e){
				case "left":
					j(this).stop(true, true).animate({'left' : '0'});
					
					break;
				case "right":
					j(this).stop(true, true).animate({'right' : '0'});
					
					break;
				case "top":
					j(this).stop(true, true).animate({'top' : '0px'});
					
					break;
				case "bottom":
					j(this).stop(true, true).animate({'bottom' : '-60px'});
					
					break;
			}
		}).mouseleave(function(){
			var e = j.trim(j(this).data('position'))
			var property = {};
			switch(e){
				case "left":
					j(this).stop(true, true).animate({'left' : -(j(this).width() / 2) + 'px'});
					
					break;
				case "right":
					j(this).stop(true, true).animate({'right' : -(j(this).width() / 2) + 'px'});
					
					break;
				case "top":
					j(this).stop(true, true).animate({'top' : -(j(this).height() / 2) + 'px'});
					
					break;
				case "bottom":
					j(this).stop(true, true).animate({'bottom' : -(j(this).height() / 2) + 'px'});
					
					break;
			}
		})
		
		function urlfilter(str){
			var urlregex = new RegExp("^(http|https|ftp)\://([a-zA-Z0-9\.\-]+(\:[a-zA-Z0-9\.&amp;%\$\-]+)*@)*((25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9])\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[0-9])|([a-zA-Z0-9\-]+\.)*[a-zA-Z0-9\-]+\.(com|edu|gov|int|mil|net|org|biz|arpa|info|name|pro|aero|coop|museum|[a-zA-Z]{2}))(\:[0-9]+)*(/($|[a-zA-Z0-9\.\,\?\'\\\+&amp;%\$#\=~_\-]+))*$");
			
			if (urlregex.test(str)) {
				return (true);
			}
			
			return (false);
		}
		
		function onSpritzifySuccess(spritzText) {
			if(j(".lastClick").length > 0){
				j(".lastClick").find(".spritzer").data("controller").startSpritzing(spritzText);
				j(".lastClick").removeClass("lastClick");
			}else{
				j(".spritzer").data("controller").startSpritzing(spritzText);	
			}
		}
		
		function getSelector(selector){
			if(selector.charAt(0)===','){
				selector = selector.slice(1);
			}
			
			return selector;
		}
		
		function onSpritzifyError(error) {
			console.log("Unable to Spritz: " + error.message);
		}
		
		var customOptions_b = jQuery.extend(true, {}, customOptions);

		j.fn.whenResize = function(){
			var width=parseInt(j(window).width());
			var av=parseInt(<?php echo get_option('spritz_responsive_width');?>);
			var res="<?php echo get_option('make_responsive'); ?>";
			var _width = j(".spritzer-canvas-container").width();
			
			customOptions_b.redicleWidth=(_width < 150) ? customOptions_b.redicleWidth : _width;
			
			j.each(j(".spritzer"),function(){
				j(this).data("controller").applyOptions(customOptions_b);
				
				<?php
					// added to inline-new
					if(get_option('spritz_flyout_display_type')=='inline'){
				?>
				selector = (typeof(j(this).data('selector')) != 'undefined') ? j(this).data('selector') : '';
				
				if(selector == ''){
					if("<?php echo get_selector(); ?>" != ''){
						selector = '<?php echo get_selector(); ?>';
					}else{
						selector = '';
					}
				}else{
					selector = selector;
				}
				
				url = (typeof(j(this).data('url')) != 'undefined') ? j(this).data('url') : '';
				var urls="<?php echo SPRITZ__PLUGIN_URL.'wordpress.with.spritz.content.filter.php?url='; ?>"+url+"<?php echo "&selector=".get_option('spirtz_exclude');?>&tages=";
				
				j(this).data("controller").loadText(false, {url:urls,selector:selector})
				
				<?php } ?>
			})
		}
		
		j(window).resize(function(){
			j().whenResize();
		})
		
		j().whenResize();
	});
</script>
<?php } ?>