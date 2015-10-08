<script type="text/javascript">
	$e=jQuery.noConflict();
	$e(document).ready(function(e) {
		$e("#spritz_wpm").change(function(){
			var opt='';
			var yes=false;
			$e(this).find(":selected").each(function(index, element) {
				var yes=true;
				if('<?php echo get_option('spritz_default_speed'); ?>'==$e(this).val()){
				    opt+='<option value="'+$e(this).val()+'" selected="selected">'+$e(this).val()+'WPM</option>';
				}else{
					opt+='<option value="'+$e(this).val()+'">'+$e(this).val()+'WPM</option>';
				}
			});
			if(yes==true){
				$e('#spritz_default_speed option').remove();
			}
			$e('#spritz_default_speed').append(opt);
		})
		$e("#spritz_wpm").trigger("change");
	});
</script>
<form action="" method="post" name="form-targetted" id="form-targetted">
    <div class="spritzoptions_holder" role="tablist">
        <h3><?php echo __('General Configuration','WordPresswithSpritz'); ?></h3>
		
        <div class="spritzoptions">
			
			<?php /* Display Style: Start */ ?>
            <div class="spritzoptions_row">
                <label class="spritzoptions_label"><?php echo __('Display Style','WordPresswithSpritz'); ?></label>
                <div class="spritzoptions_field">
                    <select class="select" name="spritz_flyout_display_type" id="spritz_flyout_display_type">
                        <option value="tab" <?php echo (get_option('spritz_flyout_display_type')=='tab' || get_option('spritz_flyout_display_type')=='')?'selected="selected"':''; ?>><?php echo __('Tab Button with Popup','WordPresswithSpritz'); ?></option>
                        <option value="popup" <?php echo (get_option('spritz_flyout_display_type')=='popup')?'selected="selected"':''; ?>><?php echo __('Inline Button with Popup','WordPresswithSpritz'); ?></option>
                        <option value="inline" <?php echo (get_option('spritz_flyout_display_type')=='inline')?'selected="selected"':''; ?>><?php echo __('Inline Spritzer','WordPresswithSpritz'); ?></option>
                    </select>

                    <div class="nfos"><?php echo __('Select the display style to use on your website.','WordPresswithSpritz'); ?></div>

                    <div class="clear"></div>
                </div>

                <div class="clear"></div>
            </div>
			<?php /* Display Style: End */ ?>
			
			<?php /* Choose Position for tab */ ?>
            <div class="spritzoptions_row" id="display_position" style="<?php echo (get_option('spritz_flyout_display_type')=='tab' || get_option('spritz_flyout_display_type')=='')?'display: block':'display: none'; ?> ">
                <label class="spritzoptions_label"><?php echo __('Choose Tab Button Position','WordPresswithSpritz'); ?></label>
                <div class="spritzoptions_field">
                    <select class="select" name="popup_position">
                        <option value="left" <?php echo (get_option('popup_position')=='left')?'selected="selected"':''; ?>><?php echo __('Left','WordPresswithSpritz'); ?></option>
                        <option value="right" <?php echo (get_option('popup_position')=='right')?'selected="selected"':''; ?>><?php echo __('Right','WordPresswithSpritz'); ?></option>
                        <option value="top" <?php echo (get_option('popup_position')=='top')?'selected="selected"':''; ?>><?php echo __('Top','WordPresswithSpritz'); ?></option>
                        
                    </select>

                    <div class="nfos"><?php echo __('Select position of the tab button on the screen.','WordPresswithSpritz'); ?></div>

                    <div class="clear"></div>
                </div>

                <div class="clear"></div>
            </div>
			<?php /* Choose Position: End */ ?>

            <?php /* Choose Position for inline and inline popup */ ?>
            <div class="spritzoptions_row" id="display_inline_popup_position" style="<?php echo (get_option('spritz_flyout_display_type')=='inline' || get_option('spritz_flyout_display_type')=='popup')?'display: block':'display: none'; ?> ">
                <label class="spritzoptions_label"><?php echo __('Align Read with Spritz Button','WordPresswithSpritz'); ?></label>
                <div class="spritzoptions_field">
                    <select class="select" name="display_inline_popup_position">
                        <option value="bttnAlignCenter" <?php echo (get_option('display_inline_popup_position')=='bttnAlignCenter')?'selected="selected"':''; ?>><?php echo __('Align Button to Center','WordPresswithSpritz'); ?></option>
                        <option value="bttnAlignLeft" <?php echo (get_option('display_inline_popup_position')=='bttnAlignLeft')?'selected="selected"':''; ?>><?php echo __('Align Button to Left','WordPresswithSpritz'); ?></option>
                        <option value="bttnAlignRight" <?php echo (get_option('display_inline_popup_position')=='bttnAlignRight')?'selected="selected"':''; ?>><?php echo __('Align Button to Right','WordPresswithSpritz'); ?></option>
                        
                    </select>

                    <div class="nfos"><?php echo __("Select from the options in the dropdown to position the 'Read with Spritz' button on the page.",'WordPresswithSpritz'); ?></div>

                    <div class="clear"></div>
                </div>

                <div class="clear"></div>
            </div>
			<?php /* Choose Position: End */ ?>
			
			<?php /* Show Speed Options?: Start */ ?>
            <div class="spritzoptions_row">
                <div class="spritzoptions_field">
                    <div>
                        <input type="checkbox" class="checkbox" name="spritz_speed_option" id="spritz_speed_option" <?php echo (get_option('spritz_speed_option')=='Y' || get_option('spritz_speed_option')=='')?'checked="checked"':''; ?> />
                        <label for="spritz_speed_option"><?php echo __('Show Speed Options?','WordPresswithSpritz'); ?></label>

                        <div class="clear"></div>
                    </div>

                    <div class="nfos"><?php echo __('Please make checked if you want to show controls on Spritzer.','WordPresswithSpritz'); ?></div>

                    <div class="clear"></div>
                </div>

                <div class="clear"></div>
            </div>
			<?php /* Show Speed Options?: End */ ?>
			
			<?php /* Spritz Speed Items List: Start */ ?>
            <div class="spritzoptions_row speedoptions" style="<?php echo (get_option('spritz_speed_option')=='N')?'display: none':''; ?>">
                <label class="spritzoptions_label" for="spritz_detect_data_attr"><?php echo __('Spritz Speed Items List','WordPresswithSpritz'); ?></label>
                <div class="spritzoptions_field">
                    <?php $selecteds=explode(',',get_option('spritz_wpm')); ?>
                    <select multiple="multiple" id="spritz_wpm" name="spritz_wpm[]" class="multiselect">
                        <option value="50" <?php echo (in_array('50',$selecteds))?'selected="selected"':''; ?>><?php echo __('50WPM','WordPresswithSpritz'); ?></option>
                        <option value="100" <?php echo (in_array('100',$selecteds))?'selected="selected"':''; ?>><?php echo __('100WPM','WordPresswithSpritz'); ?></option>
                        <option value="150" <?php echo (in_array('150',$selecteds))?'selected="selected"':''; ?>><?php echo __('150WPM','WordPresswithSpritz'); ?></option>
                        <option value="250" <?php echo (in_array('250',$selecteds) || get_option('spritz_wpm')=='')?'selected="selected"':''; ?>><?php echo __('250WPM','WordPresswithSpritz'); ?></option>
                        <option value="300" <?php echo (in_array('300',$selecteds))?'selected="selected"':''; ?>><?php echo __('300WPM','WordPresswithSpritz'); ?></option>
                        <option value="350" <?php echo (in_array('350',$selecteds))?'selected="selected"':''; ?>><?php echo __('350WPM','WordPresswithSpritz'); ?></option>
                        <option value="400" <?php echo (in_array('400',$selecteds))?'selected="selected"':''; ?>><?php echo __('400WPM','WordPresswithSpritz'); ?></option>
                        <option value="450" <?php echo (in_array('450',$selecteds))?'selected="selected"':''; ?>><?php echo __('450WPM','WordPresswithSpritz'); ?></option>
                        <option value="500" <?php echo (in_array('500',$selecteds))?'selected="selected"':''; ?>><?php echo __('500WPM','WordPresswithSpritz'); ?></option>
                        <option value="550" <?php echo (in_array('550',$selecteds))?'selected="selected"':''; ?>><?php echo __('550WPM','WordPresswithSpritz'); ?></option>
                        <option value="600" <?php echo (in_array('600',$selecteds))?'selected="selected"':''; ?>><?php echo __('600WPM','WordPresswithSpritz'); ?></option>
                        <option value="650" <?php echo (in_array('650',$selecteds))?'selected="selected"':''; ?>><?php echo __('650WPM','WordPresswithSpritz'); ?></option>
                        <option value="700" <?php echo (in_array('700',$selecteds))?'selected="selected"':''; ?>><?php echo __('700WPM','WordPresswithSpritz'); ?></option>
                        <option value="750" <?php echo (in_array('750',$selecteds))?'selected="selected"':''; ?>><?php echo __('750WPM','WordPresswithSpritz'); ?></option>
                        <option value="800" <?php echo (in_array('800',$selecteds))?'selected="selected"':''; ?>><?php echo __('800WPM','WordPresswithSpritz'); ?></option>
                        <option value="850" <?php echo (in_array('850',$selecteds))?'selected="selected"':''; ?>><?php echo __('850WPM','WordPresswithSpritz'); ?></option>
                        <option value="900" <?php echo (in_array('900',$selecteds))?'selected="selected"':''; ?>><?php echo __('900WPM','WordPresswithSpritz'); ?></option>
                        <option value="950" <?php echo (in_array('950',$selecteds))?'selected="selected"':''; ?>><?php echo __('950WPM','WordPresswithSpritz'); ?></option>
                        <option value="1000" <?php echo (in_array('1000',$selecteds))?'selected="selected"':''; ?>><?php echo __('1000WPM','WordPresswithSpritz'); ?></option>
                    </select>

                    <div class="nfos"><?php echo __('Users will only be able to use speeds 250-450WPM unless they are logged into Spritz.','WordPresswithSpritz'); ?></div>

                    <div class="clear"></div>
                </div>

                <div class="clear"></div>
            </div>
			<?php /* Spritz Speed Items List: End */ ?>
			
			<?php /* Default Speed: Start */ ?>
            <div class="spritzoptions_row speedoptions" style="<?php echo (get_option('spritz_speed_option')=='N')?'display: none':''; ?>">
                <label class="spritzoptions_label" for="spritz_default_speed"><?php echo __('Default Speed','WordPresswithSpritz'); ?></label>
                <div class="spritzoptions_field">
                    <select name="spritz_default_speed" id="spritz_default_speed" class="select">
                    </select>

                    <div class="nfos"><?php echo __('Select the default speed for the reader.','WordPresswithSpritz'); ?></div>

                    <div class="clear"></div>
                </div>

                <div class="clear"></div>
            </div>
			<?php /* Default Speed: End */ ?>
			
			<?php /* Activate Spritz Reader on the Following Content Types: Start */ ?>
            <div class="spritzoptions_row ">
                <label class="spritzoptions_label" for="spritz_detect_data_attr"><?php echo __('Activate Spritz Reader on the Following Content Types','WordPresswithSpritz'); ?></label>
                <div class="spritzoptions_field">
                    <?php
					$args = array(
					   'public' => true
					);
					$output = 'names';
					$post_types = get_post_types( $args, $output);
					?>
                    <select multiple="multiple" id="activate_spritz_reader_content_types" name="activate_spritz_reader_content_types[]" class="multiselect" style="height: 90px;">
						<?php  
						if(($key = array_search('attachment', $post_types)) !== false) {
							unset($post_types[$key]);
						}
						$_old=explode(',',get_option('activate_spritz_reader_content_types'));
						foreach ( $post_types as $post_type ) { 
							$sel='';
							if(in_array($post_type,$_old)){
								$sel=" selected='selected' ";
							}
						?>
						<option value="<?php echo $post_type; ?>" <?php echo $sel; ?>><?php echo $post_type; ?></option>
						<?php } ?>
                    </select>

                    <div class="nfos"><?php echo __('The Spritz Reader will only be displayed on the content types selected. (hold down the CTRL or COMMAND key for multiple selections)','WordPresswithSpritz'); ?></div>

                    <div class="clear"></div>
                </div>

                <div class="clear"></div>
            </div>
			<?php /* Activate Spritz Reader on the Following Content Types: End */ ?>
			
			<?php /* Activate Spritz on Certain Pages/Posts/Custom Posts Only: Start */ ?>
            <div class="spritzoptions_row">
                <div class="spritzoptions_field">
                    <div>
                        <input type="checkbox" class="checkbox" data-checkbox-toggle=".certain_post" name="activate_spritz_box_on_certain_post" <?php echo (get_option('activate_spritz_box_on_certain_post')=='Y')?'checked="checked"':''; ?> id="activate_spritz_box_on_certain_post" />
                        <label for="activate_spritz_box_on_certain_post"><?php echo __('Activate Spritz on Certain Pages/Posts/Custom Posts Only','WordPresswithSpritz'); ?></label>

                        <div class="clear"></div>
                    </div>

                    <div class="clear"></div>
                </div>

                <div class="clear"></div>
            </div>
			<?php /* Activate Spritz on Certain Pages/Posts/Custom Posts Only: End */ ?>
			
			<?php  /* Choose the Content to Display Spritz Reader On: Start */ ?>
            <div class="spritzoptions_row certain_post" style="<?php echo  (get_option('activate_spritz_box_on_certain_post')!='Y')?'display:none':''?>">
                <label class="spritzoptions_label" for="spritz_detect_data_attr"><?php echo __('Choose the content to display the Spritz Reader on','WordPresswithSpritz'); ?></label>
                <div class="spritzoptions_field">
                    <select multiple="multiple" id="spritz_contents" name="spritz_contents[]" class="multiselect"></select>

                    <div class="nfos"><?php echo __('The Spritz Reader will only be displayed on the specific pages/posts selected. (hold down the CTRL or COMMAND key for multiple selections)','WordPresswithSpritz'); ?></div>

                    <div class="clear"></div>
                </div>

                <div class="clear"></div>
            </div>
            
            <?php /* Include Spritz on these content types by default: Start */ ?>
            <div class="spritzoptions_row">
                <div class="spritzoptions_field">
                    <div>
                        <input type="checkbox" class="checkbox" data-checkbox-toggle=".autoenable" name="include_spritz_reader_onfollowing_certain_post" <?php echo (get_option('include_spritz_reader_onfollowing_certain_post')=='Y')?'checked="checked"':''; ?> id="include_spritz_reader_onfollowing_certain_post" />
                        <label for="include_spritz_reader_onfollowing_certain_post"><?php echo __('Include Spritz on these content types by default.','WordPresswithSpritz'); ?></label>

                        <div class="clear"></div>
                    </div>

                    <div class="clear"></div>
                </div>

                <div class="clear"></div>
            </div>
			<?php /* Include Spritz on these content types by default: End */ ?>
			
			<?php /* Choose the Content to Display Spritz Reader On: Start */ ?>
            <div class="spritzoptions_row autoenable" style="<?php echo (get_option('include_spritz_reader_onfollowing_certain_post')!='Y')?'display:none':''?>">
                <label class="spritzoptions_label" for="include_spritz_reader_on_following"><?php echo __('Choose the Content to Include Spritz Reader by default.','WordPresswithSpritz'); ?></label>
                <div class="spritzoptions_field">
                    <div class="multiselect" style="border:1px solid #b1b1b1; width:57%;height:150px;">
                    <?php  
						if(($key = array_search('attachment', $post_types)) !== false) {
							unset($post_types[$key]);
						}
						$_old=explode(',',get_option('include_spritz_reader_on_following'));
						foreach ( $post_types as $post_type ) { 
							$sel='';
							if(in_array($post_type,$_old)){
								$sel=" checked='checked' ";
							}
						?>
					
                        <label style="width:100%; line-height:22px; padding:3px; display:block;" for="<?php echo $post_type; ?>">
                        <input name="include_spritz_reader_on_following[]" type="checkbox" id="<?php echo $post_type; ?>" style="position:relative;top:2px;" value="<?php echo $post_type; ?>" <?php echo $sel; ?> /><?php echo $post_type; ?></label>
						<?php } ?>
                    </div>
                    <div class="nfos"><?php echo __('Include Spritz on these content types by default.','WordPresswithSpritz'); ?></div>

                    <div class="clear"></div>
                </div>

                <div class="clear"></div>
				
                <div class="spritzoptions_field">
                    <div>
                        <input type="checkbox" class="checkbox" name="automatically_put_the_spritz_reader_at_the_top_of_my_content" <?php echo (get_option('automatically_put_the_spritz_reader_at_the_top_of_my_content')=='Y')?'checked="checked"':''; ?> id="automatically_put_the_spritz_reader_at_the_top_of_my_content" />
                        <label for="automatically_put_the_spritz_reader_at_the_top_of_my_content"><?php echo __('Automatically put the Spritz Reader at the top of my content.','WordPresswithSpritz'); ?></label><br />
						<div class="nfos">To manually insert the Spritz Reader on a page use the following shortcode:<br/><b>'[SpritzStarter]'</b></div>
						
                        <div class="clear"></div>
                    </div>

                    <div class="clear"></div>
                </div>

                <div class="clear"></div>
            </div>
			<?php /* Choose the Content to Display Spritz Reader On: End */ ?>
			
			<?php /* Content Region Include: Start */ ?>
            <div class="spritzoptions_row">
                <label class="spritzoptions_label"><?php echo __('Content Region Include','WordPresswithSpritz'); ?></label>
                <div class="spritzoptions_field">
                    <input type="text" name="content_region_include" placeholder="eg: p,span " class="text" id="content_region_include" value="<?php echo get_option('content_region_include'); ?>" />
					<input type="button" class="button reset_to_default" data-field='content_region_include' value="Reset to Default" />
                    <div class="nfos"><?php echo __('Content Region to Include (eg. CSS Class, ID &amp; Tag Name).','WordPresswithSpritz'); ?></div>

                    <div class="clear"></div>
                </div>

                <div class="clear"></div>
            </div>
			<?php /* Content Region Include: End */ ?>
            
            <?php /* Content Region Include: Start */ ?>
            <div class="spritzoptions_row">
                <label class="spritzoptions_label"><?php echo __('Content Region to Exclude & Omit Tags','WordPresswithSpritz'); ?></label>
                <div class="spritzoptions_field">
                    <input type="text" name="spirtz_exclude" placeholder="eg: p.class,div#id,span,ul" class="text" id="spirtz_exclude" value="<?php echo str_replace("|", '#', get_option('spirtz_exclude')); ?>" />
<input type="button" class="button reset_to_default" data-field='spirtz_exclude' value="Reset to Default" />
                    <div class="nfos"><?php echo __('Please provide CSS class name/ID with Tags Name (eg: p.dontread,div#hide) and tag name to Omit (eg: h1,h2)','WordPresswithSpritz'); ?></div>

                    <div class="clear"></div>
                </div>

                <div class="clear"></div>
            </div>
			<?php /* Content Region Include: End */ ?>
			
			<?php /* Spritz Start Text: Start */ ?>
            <div class="spritzoptions_row">
                <label class="spritzoptions_label"><?php echo __('Spritz Start Text','WordPresswithSpritz'); ?></label>
                <div class="spritzoptions_field">
                    <input type="text" name="spritz_start_text" class="text" id="spritz_start_text" value="<?php echo get_option('spritz_start_text'); ?>" />

                    <div class="nfos"><?php echo __('Provide Start Text for Spritz.','WordPresswithSpritz'); ?></div>

                    <div class="clear"></div>
                </div>

                <div class="clear"></div>
            </div>
			<?php /* Spritz Start Text: End */ ?>
			
			<?php /* Spritz End Text: Start */ ?>
            <div class="spritzoptions_row">
                <label class="spritzoptions_label"><?php echo __('Spritz End Text','WordPresswithSpritz'); ?></label>
                <div class="spritzoptions_field">
                    <input type="text" name="spritz_end_text" class="text" id="spritz_end_text" value="<?php echo get_option('spritz_end_text'); ?>" />

                    <div class="nfos"><?php echo __('Provide End Text for Spritz.','WordPresswithSpritz'); ?></div>

                    <div class="clear"></div>
                </div>

                <div class="clear"></div>
            </div>
			<?php /* Spritz End Text: End */ ?>
			
			<?php /* Notice: Start */ ?>
            <div class="spritzoptions_row">
                <label class="spritzoptions_label">
                    <?php wp_nonce_field (plugin_basename (__FILE__), 'ps_nonce'); ?>
                    <input type="hidden" name="isconfic" value="isconfic" />
                </label>
                <div class="spritzoptions_field">
                    <input type="button" value="<?php echo __('Save Changes','WordPresswithSpritz'); ?>" class="button button-primary submit-targetted" id="submit-targetted" name="submit-targetted" />
                    <span class="spritz-status"></span>

                    <div class="clear"></div>
                </div>

                <div class="clear"></div>
            </div>
			<?php /* Notice: End */ ?>
			
            <div class="clear"></div>
        </div>

        <div class="clear"></div>
    </div>
</form>