<?php

	//add importer to WP admin
		add_action('admin_menu', 'glblog_add_demo_importer');

		function glblog_add_demo_importer() {
			add_theme_page(esc_html__('Demo Importer', 'glblog'), esc_html__('Demo Importer', 'glblog'), 'administrator', 'glblog-demo-importer', 'glblog_demo_importer_page');
		}
	
	

	//webhosting permission and capability check		
		if(empty($_POST['glblog_importing']) && $_GET['page'] == 'glblog-demo-importer' && current_user_can('administrator')){		
			
		
			//is allow_url_fopen setting on in php.ini?		
			if(ini_get('allow_url_fopen') != '1' && ini_get('allow_url_fopen') != 'On'){			
				$glblog_demo_importer_selfcheck[] = esc_html__('The allow_url_fopen setting is turned off in the PHP ini!', 'glblog');			
			}else{					
				//can we read a file with wp filesystem?
				global $wp_filesystem;
				if(empty($wp_filesystem)){
					require_once(ABSPATH . '/wp-admin/includes/file.php');
					WP_Filesystem();
				}		
				
				if(!$wp_filesystem->get_contents(get_template_directory_uri().'/importer/data.imp')){
					$glblog_demo_importer_selfcheck[] = esc_html__('The script couldn\'t read the data.imp file. Is it there? Does it have the permission to read?', 'glblog');
				}
			}
			
						
			//can we create directory?
			$uploads_dir = $wp_filesystem->abspath() . '/wp-content/uploads';
			if(!$wp_filesystem->is_dir($uploads_dir)){
				if(!$wp_filesystem->mkdir($uploads_dir)){
					$glblog_demo_importer_selfcheck[] = esc_html__('The script couldn\'t create a directory!', 'glblog');
				}
			}
			
			
			//can we copy files?
			if(!$wp_filesystem->copy(get_template_directory().'/importer/media/book.jpg', $wp_filesystem->abspath() . '/wp-content/uploads/test.jpg')){			
				$glblog_demo_importer_selfcheck[] = esc_html__('The script couldn\'t copy a file!', 'glblog');					
			}else{
				$wp_filesystem->delete($wp_filesystem->abspath() . '/wp-content/uploads/test.jpg');
			}
		
			
				
				
			//can we read/write database?
			global $wpdb;
			if(!$wpdb->query('CREATE TABLE IF NOT EXISTS '.$wpdb->prefix.'testing (id mediumint(9) NOT NULL AUTO_INCREMENT, test varchar(255), UNIQUE KEY id (id))')){
				$glblog_demo_importer_selfcheck[] = esc_html__('The script is not allowed to write MySQL database!', 'glblog');
			}else{
				if(!$wpdb->query('TRUNCATE TABLE '.$wpdb->prefix.'testing')){
					$glblog_demo_importer_selfcheck[] = esc_html__('The script is not allowed to write MySQL database!', 'glblog');
				}
			}
		}
	
	
	
	//start importing
		if(!empty($_POST['glblog_importing']) && $_GET['page'] == 'glblog-demo-importer'&& current_user_can('administrator')){
			
		  //copy all media files
			global $wp_filesystem;
			if(empty($wp_filesystem)){
				require_once(ABSPATH . '/wp-admin/includes/file.php');
				WP_Filesystem();
			}	
			
			$files = glob(get_template_directory().'/importer/media/*.*');	
			foreach($files as $file){				
				if(!$wp_filesystem->copy($file, $wp_filesystem->abspath() . '/wp-content/uploads/' . basename($file))){				
					$glblog_demo_importer_error = '1';
				}
			}
			
			
		  //clear tables			
			global $wpdb;		  
			  $wpdb->query('TRUNCATE TABLE '.$wpdb->prefix.'comments');

			$wpdb->query('TRUNCATE TABLE '.$wpdb->prefix.'postmeta');
			$wpdb->query('TRUNCATE TABLE '.$wpdb->prefix.'posts');
			$wpdb->query('TRUNCATE TABLE '.$wpdb->prefix.'term_relationships');
			$wpdb->query('TRUNCATE TABLE '.$wpdb->prefix.'term_taxonomy');
			$wpdb->query('TRUNCATE TABLE '.$wpdb->prefix.'terms');
			
			
		  //read SQL dump and process each statement							
			$data = $wp_filesystem->get_contents(get_template_directory_uri().'/importer/data.imp');
			$sql = explode('<glblog_sep>',$data);
			$current_url = get_site_url();
			foreach($sql as $statement){
				if(!empty($statement)){	
				
				  //replace default wp prefix to user's choice if it's not the default one
					if(strstr($statement,'wp_comments') && $wpdb->prefix != 'wp_'){
						$statement = str_replace('wp_comments',$wpdb->prefix.'comments',$statement);

					}
					
					if(strstr($statement,'wp_postmeta')){
						if($wpdb->prefix != 'wp_'){
							$statement = str_replace('wp_postmeta',$wpdb->prefix.'postmeta',$statement);
						}											
						
						//also replace all our sample paths to the user's actual path
						$statement = str_replace('http://theme.me',$current_url,$statement);
					}
					
					if(strstr($statement,'wp_posts')){
						if($wpdb->prefix != 'wp_'){
							$statement = str_replace('wp_posts',$wpdb->prefix.'posts',$statement);
						}
						
						//also replace all our sample paths to the user's actual path
						$statement = str_replace('http://theme.me',$current_url,$statement);
					}
					
					if(strstr($statement,'wp_term_relationships') && $wpdb->prefix != 'wp_'){
						$statement = str_replace('wp_term_relationships',$wpdb->prefix.'term_relationships',$statement);
					}
					
					if(strstr($statement,'wp_term_taxonomy') && $wpdb->prefix != 'wp_'){
						$statement = str_replace('wp_term_taxonomy',$wpdb->prefix.'term_taxonomy',$statement);
					}
					
					if(strstr($statement,'wp_terms') && $wpdb->prefix != 'wp_'){
						$statement = str_replace('wp_terms',$wpdb->prefix.'terms',$statement);
					}										
                    
					
					//run the query
					if(!$wpdb->query($statement)){
						$glblog_demo_importer_error = '1';
						//var_dump($glblog_demo_importer_error);exit;
					}
				}
			}
			
		
		  //navigation, widgets, other settings
			if(empty($glblog_demo_importer_error)){
				update_option('page_for_posts','0');
				update_option('nav_menu_options',unserialize('a:2:{i:0;b:0;s:8:"auto_add";a:0:{}}'));
				update_option('sidebars_widgets',unserialize('a:5:{s:19:"wp_inactive_widgets";a:0:{}s:9:"sidebar-1";a:4:{i:0;s:8:"search-2";i:1;s:12:"categories-2";i:2;s:14:"recent-posts-2";i:3;s:11:"tag_cloud-2";}s:16:"footer-sidebar-1";a:0:{}s:16:"footer-sidebar-2";a:0:{}s:13:"array_version";i:3;}'));
				update_option('widget_text',unserialize('a:2:{i:1;a:0:{}s:12:"_multiwidget";i:1;}'));
				update_option('theme_mods_twentyseventeen',unserialize('a:3:{s:18:"custom_css_post_id";i:-1;s:16:"sidebars_widgets";a:2:{s:4:"time";i:1529507914;s:4:"data";a:4:{s:19:"wp_inactive_widgets";a:0:{}s:9:"sidebar-1";a:4:{i:0;s:8:"search-2";i:1;s:12:"categories-2";i:2;s:14:"recent-posts-2";i:3;s:11:"tag_cloud-2";}s:9:"sidebar-2";a:0:{}s:9:"sidebar-3";a:0:{}}}s:18:"nav_menu_locations";a:1:{s:3:"top";i:2;}}'));
				update_option('theme_mods_glblog',unserialize('a:18:{i:0;b:0;s:18:"nav_menu_locations";a:2:{s:8:"Top-menu";i:2;s:9:"Main-menu";i:2;}s:18:"custom_css_post_id";i:-1;s:11:"custom_logo";i:14;s:16:"sidebars_widgets";a:2:{s:4:"time";i:1529506071;s:4:"data";a:4:{s:19:"wp_inactive_widgets";a:0:{}s:9:"sidebar-1";a:4:{i:0;s:8:"search-2";i:1;s:12:"categories-2";i:2;s:14:"recent-posts-2";i:3;s:11:"tag_cloud-2";}s:16:"footer-sidebar-1";a:0:{}s:16:"footer-sidebar-2";a:0:{}}}s:7:"twitter";s:22:"http://www.twiiter.com";s:8:"facebook";s:23:"http://www.facebook.com";s:11:"google-plus";s:20:"http://www.gplus.com";s:9:"pinterest";s:25:"http://www.printreset.com";s:8:"linkedin";s:23:"http://www.linkedin.com";s:7:"youtube";s:22:"http://www.youtube.com";s:5:"vimeo";s:0:"";s:17:"footer_text_block";s:50:"Copyright © 2018 WP Theme. - All Rights Reserved.";s:17:"textarea_field_id";s:14:"asdadsaddasdsa";s:20:"sample_default_image";i:0;s:16:"background_image";s:0:"";s:20:"tcx_background_image";s:57:"http://glblog.me/wp-content/uploads/2018/06/banner.jpg";s:20:"sample_default_radio";s:4:"list";}'));
				update_option('page_on_front','0');
				update_option('show_on_front','posts');
				update_option('theme_mods_glowlogix-blog',unserialize('a:3:{i:0;b:0;s:18:"nav_menu_locations";a:2:{s:8:"Top-menu";i:2;s:9:"Main-menu";i:4;}s:18:"custom_css_post_id";i:-1;}'));
				update_option('widget_archives',unserialize('a:2:{i:2;a:3:{s:5:"title";s:8:"ARCHIVES";s:5:"count";i:0;s:8:"dropdown";i:0;}s:12:"_multiwidget";i:1;}'));
				update_option('widget_categories',unserialize('a:2:{i:2;a:4:{s:5:"title";s:10:"CATEGORIES";s:5:"count";i:0;s:12:"hierarchical";i:0;s:8:"dropdown";i:0;}s:12:"_multiwidget";i:1;}'));
				update_option('widget_search',unserialize('a:2:{i:2;a:1:{s:5:"title";s:6:"SEARCH";}s:12:"_multiwidget";i:1;}'));				
			}
		
		
		  //if everything went well
		  	if(empty($glblog_demo_importer_error)){
				$glblog_demo_importer_success = '1';
			}
	
		}
	
	
	//admin page
		function glblog_demo_importer_page(){
			global $glblog_demo_importer_selfcheck, $glblog_demo_importer_success;
		
			echo '<div class="wrap">
			<h1>'.esc_html__('Demo Content Importer', 'glblog').'</h1>
			';
						
				if(empty($_POST['glblog_importing'])){
				  //welcome message
					echo '<p>' . esc_html__('Here you can import sample content with a single click!', 'glblog') . '<br /><br />
					'. __('<b>WARNING! The importing process will remove your existing posts, pages and media library!<br />
					It\'s recommended to use a fresh, clean wordpress install!</b>', 'glblog') . '</p>
					<p>&nbsp;</p>';
					
				  //show button if no error were found in selfcheck
					if(empty($glblog_demo_importer_selfcheck)){
						echo '
						<form method="post">
							<input type="hidden" name="glblog_importing" value="1" />
							<input type="submit" name="submit" id="submit" class="button button-primary" value="' . esc_attr__('Import Now!', 'glblog') . '"  />
						</form>';						
					}
					
				}else{				
				  //user pressed the import button								  
					if(!empty($glblog_demo_importer_success)){					  
					  //successful import
						echo '<p><b>' . __('Demo content has been successfully imported!', 'glblog') . '</p>';						
					}else{
					  //something went wrong
						echo '<p><b>' . __('ERROR! Something went wrong!', 'glblog') . '</p>';						
					}
				}
			
			
			//error messages from webhosting check
				if(!empty($glblog_demo_importer_selfcheck)){
					echo '
					<h2 class="title">'.esc_html__('Whooops!', 'glblog').'</h2>					
					<p><b>'.esc_html__('One or more problems were found that needs to be fixed before the import!', 'glblog').'</b></p>					
					<ul>';
					
					foreach($glblog_demo_importer_selfcheck as $err){
						echo '<li>&bull; '.$err.'</li>';
					}
					
					echo '</ul>';
				}
				
			echo '</div>';
		}
	
	
	
	
?>