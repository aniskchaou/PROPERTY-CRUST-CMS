<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$current_user = wp_get_current_user();

include_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );

$plugins_array = array(
	array(
		'name'     		=> 'Houzez Theme Functionality', // The plugin name
		'slug'     		=> 'houzez-theme-functionality', // The plugin slug (typically the folder name)
		'source'   		=> 'https://default.houzez.co/plugins/houzez-theme-functionality.zip', // The plugin source
		'path'   		=> 'houzez-theme-functionality/houzez-theme-functionality.php', // Plugin main file path
		'required' 		=> true,
		'version' 		=> '2.3.3', 
		'author' 		=> 'FaveThemes',
		'author_url' 	=> 'https://themeforest.net/user/favethemes/portfolio',
		'description' 	=> 'Theme core plugin to add all the functionality for Houzez theme', 
		'thumbnail' 	=> HOUZEZ_IMAGE . 'houzez-icon.jpg',
	),

	array(
		'name'     		=> 'Houzez Login Register', // The plugin name
		'slug'     		=> 'houzez-login-register', // The plugin slug (typically the folder name)
		'source'   		=> 'https://default.houzez.co/plugins/houzez-login-register.zip', // The plugin source
		'path'   		=> 'houzez-login-register/houzez-login-register.php', // Plugin main file path
		'required' 		=> true,
		'version' 		=> '2.3.1', 
		'author' 		=> 'FaveThemes',
		'author_url' 	=> 'https://themeforest.net/user/favethemes/portfolio',
		'description' 	=> 'Theme core plugin to login & register functionality', 
		'thumbnail' 	=> HOUZEZ_IMAGE . 'houzez-icon.jpg',
	),

	array(
		'name'     		=> 'Houzez CRM', // The plugin name
		'slug'     		=> 'houzez-crm', // The plugin slug (typically the folder name)
		'source'   		=> 'https://default.houzez.co/plugins/houzez-crm.zip', // The plugin source
		'path'   		=> 'houzez-crm/houzez-crm.php', // Plugin main file path
		'required' 		=> false,
		'version' 		=> '1.2.3', 
		'author' 		=> 'FaveThemes',
		'author_url' 	=> 'https://themeforest.net/user/favethemes/portfolio',
		'description' 	=> 'Theme core plugin to add the CRM functionality', 
		'thumbnail' 	=> HOUZEZ_IMAGE . 'houzez-icon.jpg',
	),

	array(
		'name'     		=> 'Favethemes Insights', // The plugin name
		'slug'     		=> 'favethemes-insights', // The plugin slug (typically the folder name)
		'source'   		=> 'https://default.houzez.co/plugins/favethemes-insights.zip', // The plugin source
		'path'   		=> 'favethemes-insights/favethemes-insights.php', // Plugin main file path
		'required' 		=> false,
		'version' 		=> '1.0.1', 
		'author' 		=> 'FaveThemes',
		'author_url' 	=> 'https://themeforest.net/user/favethemes/portfolio',
		'description' 	=> 'Theme core plugin to add the insight data chart', 
		'thumbnail' 	=> HOUZEZ_IMAGE . 'houzez-icon.jpg',
	),

	array(
		'name'     		=> 'Redux Framework', // The plugin name
		'slug'     		=> 'redux-framework', // The plugin slug (typically the folder name)
		'path'   		=> 'redux-framework/redux-framework.php', // Plugin main file path
		'required' 		=> true,
		'version' 		=> '', 
		'author' 		=> 'Team Redux',
		'author_url' 	=> 'https://wordpress.org/plugins/redux-framework/',
		'description' 	=> 'Theme Options', 
		'thumbnail' 	=> HOUZEZ_IMAGE . 'redux-icon.jpg', 
	),

	array(
		'name'     		=> 'One Click Demo Import', // The plugin name
		'slug'     		=> 'one-click-demo-import', // The plugin slug (typically the folder name)
		'path'   		=> 'one-click-demo-import/one-click-demo-import.php', // Plugin main file path
		'required' 		=> false,
		'version' 		=> '', 
		'author' 		=> 'ProteusThemes',
		'author_url' 	=> 'https://wordpress.org/plugins/one-click-demo-import/',
		'description' 	=> 'Import demo content', 
		'thumbnail'    => HOUZEZ_IMAGE . 'demo-import-icon.jpg', 
	),

	array(
		'name'         => 'Elementor Page Builder',
		'slug'         => 'elementor',
		'path'         => 'elementor/elementor.php',
		'required'     => true,
		'version'      => '',
		'author'       => 'Elementor.com',
		'author_url'   => 'https://elementor.com/',
		'description'  => "The World's Leading WordPress Drag & Drop Page Builder",
		'thumbnail'    => HOUZEZ_IMAGE . 'elementor-icon.jpg', 
	),

	array(
		'name'     		=> 'Slider Revolution', // The plugin name
		'slug'     		=> 'revslider', // The plugin slug (typically the folder name)
		'source'   		=> 'https://default.houzez.co/plugins/revslider.zip', // The plugin source
		'path'   		=> 'revslider/revslider.php', // Plugin main file path
		'required' 		=> false,
		'version' 		=> '', 
		'author' 		=> 'themepunch',
		'author_url' 	=> 'https://codecanyon.net/item/slider-revolution-responsive-wordpress-plugin/2751380',
		'description' 	=> 'Create Sliders & Carousels, Hero Headers', 
		'thumbnail' 	=> HOUZEZ_IMAGE . 'slider-revolution-icon.jpg', 
	),

	array(
		'name'     		=> 'MailChimp For WP', // The plugin name
		'slug'     		=> 'mailchimp-for-wp', // The plugin slug (typically the folder name)
		'path'   		=> 'mailchimp-for-wp/mailchimp-for-wp.php', // Plugin main file path
		'required' 		=> false,
		'version' 		=> '', 
		'author' 		=> 'ibericode',
		'author_url' 	=> 'https://wordpress.org/plugins/mailchimp-for-wp/',
		'description' 	=> 'This plugin helps you grow your Mailchimp lists.', 
		'thumbnail'    => HOUZEZ_IMAGE . 'mailchimp-icon.jpg', 
	),
	
);
?>

<div class="houzez-admin-wrapper">

	<?php get_template_part('framework/admin/header'); ?>

	<?php get_template_part('framework/admin/tabs'); ?>

	<div class="admin-houzez-content">
		<h2><?php esc_html_e('Plugins', 'houzez'); ?></h2>
		<div class="admin-houzez-row">
			
			<div class="admin-houzez-box-wrap admin-houzez-box-wrap-plugins">
				
				<?php
				foreach ( $plugins_array as $plugin ) { ?>

					<div class="admin-houzez-box admin-houzez-box-plugins">
						<div class="admin-houzez-box-image">
							<img src="<?php echo esc_html( $plugin['thumbnail'] ); ?>">
						</div>
						<div class="admin-houzez-box-header">
							<!-- <div class="dashicons-before dashicons-admin-plugins"></div> -->
							<h3><?php echo esc_html( $plugin['name'] ); ?></h3>
						</div><!-- admin-houzez-box-header -->
						<div class="admin-houzez-box-content">
							<?php if( houzez_theme_verified() ) { ?>
							<div class="actions">
								<?php
								$action_links = houzez_get_action_links( $plugin );
								if ( $action_links ) {
									echo $action_links;
								}
								?>
							</div>
							<?php } ?>
							<div>
								<?php echo esc_html( $plugin['description'] ); ?>
								<br>
								<?php if( $plugin['required'] ) { ?>
								<div class="admin-houzez-required-label"><?php esc_html_e('Required', 'houzez'); ?></div>
								<?php } else { ?>
								<div class="admin-houzez-recommended-label"><?php esc_html_e('Recommended', 'houzez'); ?></div>
								<?php } ?> 
							</div>
						</div><!-- admin-houzez-box-content -->
						<div class="admin-houzez-box-footer">
							<div class="active second plugin-version-author-uri">
								<?php if( !empty($plugin['version'])) { ?>
									<?php esc_html_e('Version', 'houzez'); ?> <?php echo esc_attr($plugin['version']); ?> | 
								<?php } ?>

								<?php esc_html_e('By', 'houzez'); ?> <a target="_blank" href="<?php echo esc_url($plugin['author_url']); ?>"><?php echo esc_attr($plugin['author']); ?></a>
							</div>
							
						</div><!-- admin-houzez-box-footer -->
					</div><!-- admin-houzez-box -->
					<?php
				}
				?>

			</div><!-- admin-houzez-box-wrap -->

		</div><!-- admin-houzez-row -->
	</div>
</div>

<?php
function houzez_get_action_links( $plugin ) {
	if ( current_user_can( 'install_plugins' ) || current_user_can( 'update_plugins' ) ) {
		$is_plugin_validate = false;
		$button = '';

		// Determine the status we can perform on a plugin.
		$plugin_status  = install_plugin_install_status( $plugin );
		$plugin_name    = $plugin['name']; 
		$plugin_file    = $plugin['path'];
		$plugin_slug    = $plugin['slug'];
		$plugin_source    = isset($plugin['source']) ? $plugin['source'] : '';

		//Checks that the main plugin file exists and is a valid plugin
		$validate = validate_plugin( $plugin_file );

		if ( ! is_wp_error( $validate ) ) {
			$is_plugin_validate = true;
		}

		switch ( $plugin_status['status'] ) {
			case 'download_link':
			break;

			case 'install':

			$install_text = esc_attr__( 'Install Now', 'houzez' );
			if ( ! empty( $plugin_source ) ) {
				$button = sprintf(
					'<a class="houzez-plugin-js houzez-install-btn button" data-name="%s" data-slug="%s" data-source="%s" data-file="%s" href="#">%s</a>',
					esc_attr( $plugin_name ),
					esc_attr( $plugin_slug ),
					esc_url( $plugin_source ),
					esc_attr( $plugin_file ),
					$install_text
				);
			} else {
				$button = sprintf(
					'<a class="houzez-plugin-js houzez-install-btn button" href="#" data-name="%s" data-slug="%s" data-file="%s">%s</a>',
					esc_attr( $plugin_name ),
					esc_attr( $plugin_slug ),
					esc_attr( $plugin_file ),
					$install_text
				);
			}
			break;

			case 'newer_installed':
			case 'update_available':
			case 'latest_installed':
			if ( is_plugin_inactive( $plugin_file ) && current_user_can( 'activate_plugin', $plugin_file ) ) {
				$button = sprintf( '<a href="#" class="houzez-plugin-js houzez-activate-btn button" data-name="%s" data-slug="%s" data-file="%s">%s</a>',
					esc_attr( $plugin_name ),
					esc_attr( $plugin_slug ),
					esc_attr( $plugin_file ),
					esc_attr__( 'Activate', 'houzez' )
				);
			} else {
				$button = sprintf('<button type="button" class="button button-disabled" disabled="disabled">%s</button>',
					esc_attr__( 'Active', 'houzez' )
				);
			}
			break;
		}

		return $button;
	}
}
?>
