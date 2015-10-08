<div class="wrap cstm-tble">

	<h2><?php echo __('Spritz Reader Plugin Configuration','WordPresswithSpritz'); ?></h2><br>
    <?php
		if(core::get_notification()!=''){
			?>
				<div class="notice">
					<?php echo core::get_notification(); ?>
				</div>
			<?php
		}
	?>
	<div style="padding: 20px 0;" id="demo-tabs-vertical" class="marginBottom" data-role="z-tab" data-options='{"orientation": "vertical", "style": "contained", "theme": "silver","defaultTab": "tab1", "shadows": true, "rounded": false, "size":"medium", "animation": {"effects": "none", "duration": 350, "type": "css", "easing": "easeOutQuint"}, "position": "top-compact"}'>
		<ul>
			<li><a><i class="fa-eye">&nbsp;</i><?php echo __('Plugin Configuration','WordPresswithSpritz'); ?></a></li>
			<li><a><i class="fa-folder">&nbsp;</i><?php echo __('Reader Customization','WordPresswithSpritz'); ?></a></li>
			<li><a><i class="fa-clock-o">&nbsp;</i><?php echo __('Plugin Licensing'); ?></a></li>
		</ul>
		<div>
			<div>
			
				<?php 
				include(SPRITZ__PLUGIN_DIR."wordpress.with.spritz.general.configuration.php"); 
				?>
            </div>
			<div><?php include(SPRITZ__PLUGIN_DIR."wordpress.with.spritz.general.customization.options.php"); ?></div>
			<div><?php include(SPRITZ__PLUGIN_DIR."wordpress.with.spritz.licensing.php"); ?></div>
		</div>
	</div>
</div>
<script>
    jQuery(function($) {
        $('.submit-targetted').click(function() {
            $('#form-targetted').find('.spritz-status').html('Please wait...<img src="<?php echo SPRITZ__PLUGIN_URL.'/images/small_loader.gif';?>" />');
            $.ajax({
                url		: '<?php echo SPRITZ__PLUGIN_URL . 'wordpress.with.spritz.save.php'; ?>',
                type	: 'POST',
                dataType: 'json',
				data	: $('#form-targetted').serialize(),
                success	: function(result) {
					$('#form-targetted').find('.spritz-status').text(result[0].msg);
					$('#form-targetted').find('.spritz-status').css({'color':result[0].color})
					setTimeout(function(){
						$('#form-targetted').find('.spritz-status').text('');
						$('#form-targetted').find('.spritz-status').removeAttr('style');
					},2800);
                }
            });
            return false;
        });
		
		$('.submit-interface').click(function() {
            $('#form-interface').find('.spritz-status').html('Please wait...<img src="<?php echo SPRITZ__PLUGIN_URL.'/images/small_loader.gif';?>" />');
            $.ajax({
                url		: '<?php echo SPRITZ__PLUGIN_URL . 'wordpress.with.spritz.save.php'; ?>',
                type	: 'POST',
                dataType: 'json',
				data	: $('#form-interface').serialize(),
                success	: function(result) {
                    $('#form-interface').find('.spritz-status').text(result[0].msg);
					$('#form-interface').find('.spritz-status').css({'color':result[0].color})
					setTimeout(function(){
						$('#form-interface').find('.spritz-status').text('');
						$('#form-interface').find('.spritz-status').removeAttr('style');
					},2800);
                }
            });
            return false;
        });
		
		$('.submit-license').click(function() {
			var data_type=$.trim($(this).attr('data-type'));
			if(data_type=='activate'){
				$("#spritz_post_type").val(data_type);
				$('#form-license').find('.spritz-status-activate').html('Please wait...<img src="<?php echo SPRITZ__PLUGIN_URL.'/images/small_loader.gif';?>" />');
			}else{
				$('#form-license').find('.spritz-status').html('Please wait...<img src="<?php echo SPRITZ__PLUGIN_URL.'/images/small_loader.gif';?>" />');	
			}
			
            $.ajax({
                url		: '<?php echo SPRITZ__PLUGIN_URL . 'wordpress.with.spritz.save.php'; ?>',
                type	: 'POST',
                dataType: 'json',
				data	: $('#form-license').serialize(),
                success	: function(result) {
					if(data_type=='activate'){
						$('#form-license').find('.spritz-status-activate').text(result[0].msg);
						$('#form-license').find('.spritz-status-activate').css({'color':result[0].color});
					}else{
						$('#form-license').find('.spritz-status').text(result[0].msg);
						$('#form-license').find('.spritz-status').css({'color':result[0].color});
					}
					setTimeout(function(){
						$('#form-license').find('.spritz-status').text('');
						$('#form-license').find('.spritz-status').removeAttr('style');
						$('#form-license').find('.spritz-status-activate').text('');
						$('#form-license').find('.spritz-status-activate').removeAttr('style');
					},2800);
					
					var message='';
					if($.trim(result[0].spritz_license_status)=='valid'){
						message="<font color='green'>"+result[0].status+"</font>";
						setTimeout(function(){
							document.location.reload();
						},800)
					}else{
						message="<font color='red'>"+result[0].status+"</font>";
						setTimeout(function(){
							document.location.reload();
						},800)
					}
					
					$("#part_activate").empty().append(message);
                }
            });
			
            return false;
        });

		$(".admin_accordion").accordion({heightStyle: "content"});
		$(".spritz-color").wpColorPicker();
		
		$("#spritz_controlls").change(function(){
			if($(this).is(":checked")){
				$("#controlls").show(400)	
			}else{
				$("#controlls").hide(400)
			}
		})
		
		$("#spritz_speed_option").change(function(){
			if($(this).is(":checked")){
				$(".speedoptions").show(400)
			}else{
				$(".speedoptions").hide(400)
			}
		})
		
		// Created By
		$("#created_by").change(function(){
			if($(this).is(":checked")){
				$("#created_by_logos").show(400)
			}else{
				$("#created_by_logos").hide(400)
			}
		})
		
		// Make Responsive
		$("#make_responsive").change(function(){
			if($(this).is(":checked")){
				$("#make_responsive_width").show(400)
			}else{
				$("#make_responsive_width").hide(400)
			}
		})
		
		$("#spritz_flyout_display_type").change(function(){
			if($(this).val()=='tab'){
				$("#display_position").show(400)
			}else{
				$("#display_position").hide(400)
			}
			if($(this).val()=='popup'){
				$("#button_graphic_size").slideDown();
			}else{
				$("#button_graphic_size").slideUp();
			}
			
			if($(this).val()=='popup' || $(this).val()=='inline'){
				$("#display_inline_popup_position").show(400)
			}else{
				$("#display_inline_popup_position").hide(400)
			}
		})
		
		$("#image_inline_popup").change(function(){
			if($(this).is(":checked")){
				$("#change_inline_image_popup").show(400)
			}else{
				$("#change_inline_image_popup").hide(400)
			}
		})
		
		$("#image_tab_popup").change(function(){
			if($(this).is(":checked")){
				$("#image_tab_popup_tr").show(400)
			}else{
				$("#image_tab_popup_tr").hide(400)
			}
		})
		
		$("[data-checkbox-toggle]").change(function(){
			if($(this).is(":checked")){
				$($(this).data('checkbox-toggle')).show(400)
			}else{
				$($(this).data('checkbox-toggle')).hide(400)
			}
		})
		
		$("#activate_spritz_reader_content_types").change(function(){
			var types=$(this).val();//$.trim($(this).val());
			$.ajax({
                url		: '<?php echo SPRITZ__PLUGIN_URL . 'wordpress.with.spritz.save.php'; ?>',
                type	: 'POST',
                dataType: 'json',
				data	: {'post_types':types,'certain_post':'certain_post','ps_nonce':'<?php wp_nonce_field (plugin_basename (__FILE__), 'ps_nonce'); ?>'},
                success	: function(result) {
					$("#spritz_contents").empty().append(result[0].options);
                },
				error:function(){}
            });
		})
		$(".reset_to_default").click(function(){
			var types=$(this).data('field');
			$.ajax({
                url		: '<?php echo SPRITZ__PLUGIN_URL . 'wordpress.with.spritz.save.php'; ?>',
                type	: 'POST',
				data	: {'option':$(this).data('field'),'ps_nonce':'<?php wp_nonce_field (plugin_basename (__FILE__), 'ps_nonce'); ?>'},
                success	: function(result) {
					//alert(types);
					$('#'+types).val($.trim(result));
                },
				error:function(e){alert(e)}
            });
		})
		
		$("#activate_spritz_reader_content_types").trigger('change');
    });
</script>
