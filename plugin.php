<?php
/*
Plugin Name: Simple Admin Language
Description: Change the language of the single-site management screen.
Author: Webnist
Version: 0.7.1
Author URI: http://profiles.wordpress.org/webnist
License: GPLv2 or later
Text Domain: simple-admin-language
Domain Path: /languages/
*/
if ( ! class_exists( 'SimpleAdminLanguageAdmin' ) )
	require_once( dirname(__FILE__) . '/includes/admin.php' );

if ( ! class_exists( 'SimpleAdminLanguageView' ) )
	require_once( dirname(__FILE__) . '/includes/view.php' );

class SimpleAdminLanguageInit {

	public function __construct() {

		$this->basename    = dirname( plugin_basename(__FILE__) );
		$this->dir         = plugin_dir_path( __FILE__ );
		$this->url         = plugin_dir_url( __FILE__ );
		$headers           = array(
			'name'        => 'Plugin Name',
			'version'     => 'Version',
			'domain'      => 'Text Domain',
			'domain_path' => 'Domain Path',
		);
		$data              = get_file_data( __FILE__, $headers );
		$this->name        = $data['name'];
		$this->version     = $data['version'];
		$this->domain      = $data['domain'];
		$this->domain_path = $data['domain_path'];
		$this->default_options = array(
			'general' => '',
		);
		$this->options = get_option( 'simple-admin-language', $this->default_options );
		$this->general = $this->options['general'] ? $this->options['general'] : WPLANG;

		load_plugin_textdomain( $this->domain, false, $this->name . $this->domain_path );
	}
}

new SimpleAdminLanguageInit();
new SimpleAdminLanguageAdmin();
new SimpleAdminLanguageView();
