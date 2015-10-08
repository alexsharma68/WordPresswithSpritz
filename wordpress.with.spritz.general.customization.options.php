<script type="text/javascript">
var j = jQuery.noConflict();
j(document).ready(function() {
    var formfield;
    j('.spritz_upload').click(function() {
        formfield = j(this).next('input'); //The input field that will hold the uploaded file url
        tb_show('','media-upload.php?TB_iframe=true');

        return false;
    });
    window.old_tb_remove = window.tb_remove;
    window.tb_remove = function() {
        window.old_tb_remove(); // calls the tb_remove() of the Thickbox plugin
        formfield = null;
    };
    window.original_send_to_editor = window.send_to_editor;
    window.send_to_editor = function(html){
        if (formfield) {
            fileurl = j('img',html).attr('src');
            j(formfield).val(fileurl);
            tb_remove();
        } else {
            window.original_send_to_editor(html);
        }
    };
});
</script>

<form action="" method="post" name="form-interface" id="form-interface">
    <div class="spritzoptions_holder" role="tablist">

       
		<h3><?php echo __('General Customization Options','WordPresswithSpritz'); ?></h3>

        <div class="spritzoptions">
            
			<?php /* Remove/Replace "Created by Yoko Co and Powered by Spritz"?: Start */ ?>
			<div class="spritzoptions_row">
                <div class="spritzoptions_field">
                    <div>
                        <input type="checkbox" class="checkbox" id="created_by" name="created_by" <?php echo (get_option('created_by')=='Y')?'checked="checked"':''; ?> />
                        <label for="created_by"><?php echo __('Remove/Replace "<em>Created by Yoko Co and Powered by Spritz</em>"?','WordPresswithSpritz'); ?></label>

                        <div class="clear"></div>
                    </div>

                    <div class="nfos"><?php echo __('Check this option if you want to display or change the logo.','WordPresswithSpritz'); ?></div>

                    <div class="clear"></div>
                </div>

                <div class="clear"></div>
            </div>
			<?php /* Remove/Replace "Created by Yoko Co and Powered by Spritz"?: End */ ?>
			
			<?php /* Change Logo: Start */ ?>
            <div class="spritzoptions_row" id="created_by_logos" style="<?php echo (get_option('created_by')=='Y') ? 'display: block;' : 'display: none;'; ?>">
                <label class="spritzoptions_label"><?php echo __('Change Logo'); ?></label>
                <div class="spritzoptions_field">
                    <input class="spritz_upload button" type="button" value="<?php echo __('Upload Logo','WordPresswithSpritz'); ?>" />
                    <input id="spritz_logo" type="text" name="spritz_logo" class="text spritz_image_class" size="25" value="<?php echo get_option('spritz_logo');?>" />

                    <div class="nfos"><?php echo __('Please provide the new logo to use on the frontend. Suggested size: 300x70 pixels.','WordPresswithSpritz'); ?></div>

                    <div class="clear"></div>
                </div>

                <div class="clear"></div>
            </div>
			<?php /* Change Logo: End */ ?>
			
			<?php /* Make Reader Responsive for Mobile Devices?: Start */ ?>
			<div class="spritzoptions_row">
                <div class="spritzoptions_field">
                    <div>
						<input type="checkbox" id="make_responsive" name="make_responsive" class="checkbox" <?php echo (get_option('make_responsive')=='Y') ? 'checked="checked"' : ''; ?> value="<?php echo get_option('make_responsive'); ?>" />
                        <label for="make_responsive"><?php echo __('Only use Spritz on responsive displays?','WordPresswithSpritz'); ?></label>

                        <div class="clear"></div>
                    </div>

                    <div class="nfos"><?php echo __('Check this option if you wish to make the Spritz reader responsive for any device. This option only works with the inline Spritzer.','WordPresswithSpritz'); ?></div>

                    <div class="clear"></div>
                </div>

                <div class="clear"></div>
            </div>
			<?php /* Make Reader Responsive for Mobile Devices?: End */ ?>
			
			<?php /* Provide Responsive Width: Start */ ?>
			<div class="spritzoptions_row" id="make_responsive_width" style="<?php echo (get_option('make_responsive')=='Y') ? 'display: block;' : 'display: none;'; ?>">
                <label class="spritzoptions_label" for="spritz_responsive_width"><?php echo __('Desired Responsive Width to Display Spritz Reader','WordPresswithSpritz'); ?></label>
                <div class="spritzoptions_field">
                    <input type="text" class="text" value="<?php echo get_option('spritz_responsive_width');?>" id="spritz_responsive_width" name="spritz_responsive_width" />
                    <div class="nfos"><?php echo __('Please select the browser viewport width you would like to display the Spritz Reader at. The reader will not be displayed until the viewport width reaches this value or less. Value is in pixels.','WordPresswithSpritz'); ?></div>

                    <div class="clear"></div>
                </div>

                <div class="clear"></div>
            </div>
			<?php /* Provide Responsive Width: End */ ?>
			
			<?php /* Disable Spritz Reader on Home Page?: Start */ ?>
            <div class="spritzoptions_row">
                <div class="spritzoptions_field">
                    <div>
                        <input type="checkbox" class="checkbox" name="enable_spritzer_in_home_page" id="enable_spritzer_in_home_page" <?php echo (get_option('enable_spritzer_in_home_page')=='Y')?'checked="checked"':''; ?> />
                        <label for="enable_spritzer_in_home_page"><?php echo __('Disable Spritz Reader on Home Page?','WordPresswithSpritz'); ?></label>

                        <div class="clear"></div>
                    </div>

                    <div class="nfos"><?php echo __('Check this option if you want to disable Spritz on the Home Page.','WordPresswithSpritz'); ?></div>

                    <div class="clear"></div>
                </div>

                <div class="clear"></div>
            </div>
			<?php /* Disable Spritz Reader on Home Page?: End */ ?>
			
			<?php /* Please Choose a Theme: Start */ ?>
            <div class="spritzoptions_row" >
                <label class="spritzoptions_label" for="spritz_themes"><?php echo __('Please Choose a Theme','WordPresswithSpritz'); ?></label>
                <div class="spritzoptions_field">
                    <select class="select" name="spritz_themes" id="spritz_themes">
                        <option <?php echo (get_option('spritz_themes')=='light' || get_option('spritz_themes')=='')?'selected="selected"':''; ?> value="light"><?php echo __('Light','WordPresswithSpritz'); ?></option>
                        <option <?php echo (get_option('spritz_themes')=='dark')?'selected="selected"':''; ?> value="dark"><?php echo __('Dark','WordPresswithSpritz'); ?></option>
                    </select>

                    <div class="nfos"><?php echo __('Please select a theme that will be used for the look of the reader.','WordPresswithSpritz'); ?></div>

                    <div class="clear"></div>
                </div>

                <div class="clear"></div>
            </div>
			<?php /* Please Choose a Theme: End */ ?>
			
			<?php /* Spritz Reader Frame Background Color: Start */ ?>
            <div class="spritzoptions_row">
                <label class="spritzoptions_label" for="bg_color_for_spritz_plugin_frame"><?php echo __('Spritz Reader Frame Background Color','WordPresswithSpritz'); ?></label>
                <div class="spritzoptions_field">
                    <input type="text" class="text spritz-color" value="<?php echo get_option('bg_color_for_spritz_plugin_frame');?>" id="bg_color_for_spritz_plugin_frame" name="bg_color_for_spritz_plugin_frame" />

                    <div class="nfos"><?php echo __('Provide your desired background color for the Spritz plugin frame.','WordPresswithSpritz'); ?></div>

                    <div class="clear"></div>
                </div>

                <div class="clear"></div>
            </div>
			<?php /* Spritz Reader Frame Background Color: End */ ?>
			
			<?php /* Change Button Image for Tab Button with Popup: Start */ ?>
            <div class="spritzoptions_row">
                <div class="spritzoptions_field">
                    <div>
                        <input type="checkbox" class="checkbox" name="image_tab_popup" <?php echo (get_option('image_tab_popup')=='Y')?'checked="checked"':''; ?> id="image_tab_popup" />
                        <label for="image_tab_popup"><?php echo __('Change Button Image for Tab Button with Popup','WordPresswithSpritz'); ?></label>

                        <div class="clear"></div>
                    </div>

                    <div class="nfos"><?php echo __('Check this option if you want to change this button image.','WordPresswithSpritz'); ?></div>

                    <div class="clear"></div>
                </div>

                <div class="clear"></div>
            </div>
			<?php /* Change Button Image for Tab Button with Popup: End */ ?>
			
			<?php /* Button Image for Tab Button with Popup: Start */ ?>
            <div class="spritzoptions_row" id="image_tab_popup_tr" style="<?php echo (get_option('image_tab_popup')=='Y')?'display: block':'display: none'; ?>">
                <label class="spritzoptions_label" for="redicle_line_color"><?php echo __('Button Image for Tab Button with Popup','WordPresswithSpritz'); ?></label>
                <div class="spritzoptions_field">
                    <input class="spritz_upload button" type="button" value="<?php echo __('Upload Image','WordPresswithSpritz'); ?>" />
                    <input id="spritz_title_image" type="text" name="spritz_title_image" class="text spritz_image_class" size="25" value="<?php echo get_option('spritz_title_image');?>" />

                    <div class="nfos"><?php echo __('Provide an image to replace the "Speed Read this Page with Spritz" Button.','WordPresswithSpritz'); ?></div>

                    <div class="clear"></div>
                </div>

                <div class="clear"></div>
            </div>
			<?php /* Button Image for Tab Button with Popup: End */ ?>
			
			<?php /* Change Button Image for Inline Button with Popup: Start */ ?>
            <div class="spritzoptions_row">
                <div class="spritzoptions_field">
                    <div>
                        <input type="checkbox" class="checkbox" name="image_inline_popup" <?php echo (get_option('image_inline_popup')=='Y')?'checked="checked"':''; ?> id="image_inline_popup" />
                        <label for="image_inline_popup"><?php echo __('Change Button Image for Inline Button with Popup','WordPresswithSpritz'); ?></label>

                        <div class="clear"></div>
                    </div>

                    <div class="nfos"><?php echo __('Check this option if you want to change this button image.','WordPresswithSpritz'); ?></div>

                    <div class="clear"></div>
                </div>

                <div class="clear"></div>
            </div>
			<?php /* Change Button Image for Inline Button with Popup: End */ ?>
			
			<?php /* Button Image for Inline with Popup: Start */ ?>
            <div class="spritzoptions_row" id="change_inline_image_popup" style="<?php echo (get_option('image_inline_popup')=='Y')?'display: block':'display: none'; ?>">
                <label class="spritzoptions_label" for="redicle_line_color"><?php echo __('Button Image for Inline with Popup','WordPresswithSpritz'); ?></label>
                <div class="spritzoptions_field">
                    <input class="spritz_upload button" type="button" value="<?php echo __('Upload Image','WordPresswithSpritz'); ?>" />
                    <input id="inline_spritz_title_image" type="text" name="inline_spritz_title_image" class="text spritz_image_class" size="25" value="<?php echo get_option('inline_spritz_title_image');?>" />

                    <div class="nfos"><?php echo __('Provide an image to replace the "Speed Read this Page with Spritz" Button.','WordPresswithSpritz'); ?></div>

                    <div class="clear"></div>
                </div>

                <div class="clear"></div>
            </div>
			<?php /* Button Image for Inline with Popup: End */ ?>
			
			<?php /* Inline Button Size to Use: Start */ ?>
            <div class="spritzoptions_row" id="button_graphic_size">
                <label class="spritzoptions_label" for="redicle_line_color"><?php echo __('Inline Button Size to Use','WordPresswithSpritz'); ?></label>
                <div class="spritzoptions_field">
                    <select class="select" name="button_title_graphic_size" id="button_title_graphic_size">
                        <option <?php echo (get_option('button_title_graphic_size')=='small')?'selected="selected"':''; ?> value="small"><?php echo __('Small (140 x 22 pixels)','WordPresswithSpritz'); ?></option>
                        <option <?php echo (get_option('button_title_graphic_size')=='large')?'selected="selected"':''; ?> value="large"><?php echo __('Large (268 x 42 pixels)','WordPresswithSpritz'); ?></option>
                    </select>

                    <div class="nfos"><?php echo __('Select the size you want the inline Spritz Reader button to be. This option will work if you have choosed "Inline Button with Popup" or "Inline Spritzer" in Display Style','WordPresswithSpritz'); ?></div>

                    <div class="clear"></div>
                </div>

                <div class="clear"></div>
            </div>
			<?php /* Inline Button Size to Use: End */ ?>
			
			<?php /* Custom CSS Class for Spritz Reader: Start */ ?>
            <div class="spritzoptions_row">
                <label class="spritzoptions_label" for="css_classes_for_spritzer_div"><?php echo __('Custom CSS Class for Spritz Reader','WordPresswithSpritz'); ?></label>
                <div class="spritzoptions_field">
                    <input type="text" class="text" value="<?php echo get_option('css_classes_for_spritzer_div');?>" id="css_classes_for_spritzer_div" name="css_classes_for_spritzer_div" />

                    <div class="nfos"><?php echo __('Provide a CSS class that will be assigned to the Spritz Reader parent div.','WordPresswithSpritz'); ?></div>

                    <div class="clear"></div>
                </div>

                <div class="clear"></div>
            </div>
			<?php /* Custom CSS Class for Spritz Reader: End */ ?>
			
			<?php /* Custom CSS: Start */ ?>
            <div class="spritzoptions_row">
                <label class="spritzoptions_label" for="custom_css_spritz"><?php echo __('Custom CSS','WordPresswithSpritz'); ?></label>
                <div class="spritzoptions_field">
                    <textarea class="textarea" name="custom_css_spritz" id="custom_css_spritz" placeholder="<?php echo __('Custom CSS Here','WordPresswithSpritz'); ?>"><?php echo get_option('custom_css_spritz');?></textarea>

                    <div class="nfos"><?php echo __('Provide custom CSS if you wish to add your own styling.','WordPresswithSpritz'); ?></div>

                    <div class="clear"></div>
                </div>

                <div class="clear"></div>
            </div>
			<?php /* Custom CSS: End */ ?>
			
			<?php /* Custom jQuery: Start */ ?>
            <div class="spritzoptions_row">
                <label class="spritzoptions_label" for="spritz_start_stop_height"><?php echo __('Custom jQuery','WordPresswithSpritz'); ?></label>
                <div class="spritzoptions_field">
                    <textarea class="textarea" name="custom_javascript_spritz" id="custom_javascript_spritz" placeholder="<?php echo __('Custom jQuery Code Here'); ?>"><?php echo stripslashes(get_option('custom_javascript_spritz')); ?></textarea>

                    <div class="nfos"><?php echo __("Please write jQuery code using 'j' as the jQuery instance. Your code will be placed in a document ready state.",'WordPresswithSpritz'); ?></div>

                    <div class="clear"></div>
                </div>

                <div class="clear"></div>
            </div>
			<?php /* Custom jQuery: End */ ?>
			
            <div class="clear"></div>
        </div>

        <div class="spritzoptions">
            <div class="spritzoptions_row">
                <label class="spritzoptions_label"></label>
                <div class="spritzoptions_field">
                    <?php wp_nonce_field (plugin_basename (__FILE__), 'ps_nonce'); ?><input type="hidden" name="controlls_hidden" id="controlls_hidden" />
                    <input type="submit" value="<?php echo __('Save Changes','WordPresswithSpritz'); ?>" class="button button-primary submit-interface" name="submit-interface" />
                    <span class="spritz-status"></span>

                    <div class="clear"></div>
                </div>

                <div class="clear"></div>
            </div>

            <div class="clear"></div>
        </div>

        <div class="clear"></div>
	</div>
</form>