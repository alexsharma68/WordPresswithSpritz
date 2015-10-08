<?php
$license 	= get_option( 'spritz_license_key' );
$status 	= get_option( 'spritz_license_status' );
?>
<form action="" method="post" name="form-license" id="form-license">
    <div class="spritzoptions_holder" role="tablist">
        <h3><?php echo __('License &amp; API Keys','WordPresswithSpritz'); ?></h3>
		
        <div class="spritzoptions">
            
			<?php /* Spritz License Status: Start */ ?>
            <div class="spritzoptions_row">
                <div scope="row" valign="top">
                    <label class="spritzoptions_label"><?php __('License Status','WordPresswithSpritz'); ?></label>

                    <div class="clear"></div>
                </div>
				
                <div>
                    <div id="part_activate">
                       	<?php if( $status !== false && $status == 'valid' ) { ?>
						<div class="license active">
							<div>
								<?php echo __('License Active: Professional version active.','WordPresswithSpritz'); ?>
							</div>
						</div>
					   	<?php }elseif($license!=''){ ?>
                       	<div class="license invalid">
							<div>
								<?php echo __('Invalid License: You\'re using the Free version.','WordPresswithSpritz'); ?>
							</div>
						</div>
						<?php }else{?>
						<div class="license inactive">
							<div>
								<?php echo __('Inactive License: You\'re using the Free version.','WordPresswithSpritz'); ?>
							</div>
						</div>
						<?php } ?>
						
						<div class="clear"></div>
                    </div>

                    <div class="clear"></div>
                </div>

                <div class="clear"></div>
            </div>
			<?php /* Spritz License Status: End */ ?>
			
			<?php /* Spritz Client ID: Start */ ?>
			<div class="spritzoptions_row">
                <label class="spritzoptions_label" for="spritz_detect_css_clsss"><?php echo __('Spritz Client ID','WordPresswithSpritz'); ?></label>
                <div class="spritzoptions_field">
                    <input type="text" class="text" value="<?php echo get_option('spritz_client_id');?>" id="spritz_client_id" name="spritz_client_id" />

                    <div class="clear"></div>
                </div>

                <div class="clear"></div>
            </div>
			<?php /* Spritz Client ID: End */ ?>
			
			<?php /* Spritz License Key: Start */ ?>
            <div class="spritzoptions_row">
                <label class="spritzoptions_label" for="spritz_detect_elements_id"><?php echo __('Spritz License Key','WordPresswithSpritz'); ?></label>
                <div class="spritzoptions_field">
                    <input type="text" class="text" value="<?php esc_attr_e($license); ?>" id="spritz_license_key" name="spritz_license_key" />

                    <div class="clear"></div>
                </div>

                <div class="clear"></div>
            </div>
			<?php /* Spritz License Key: End */ ?>

            <div class="clear"></div>
        </div>

        <div class="spritzoptions">
            <div class="spritzoptions_row">
                <div class="spritzoptions_field">
                    <?php wp_nonce_field (plugin_basename (__FILE__), 'ps_nonce'); ?>
                    <input type="submit" value="<?php echo __('Save Changes','WordPresswithSpritz'); ?>" class="button button-primary submit-license" name="submit-license" />
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