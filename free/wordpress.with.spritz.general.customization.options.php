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