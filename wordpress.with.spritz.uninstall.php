<?php
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) 
exit();
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
?>