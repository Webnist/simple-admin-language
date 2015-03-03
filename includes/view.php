<?php
class SimpleAdminLanguageView extends SimpleAdminLanguageInit {

	public function __construct() {
		parent::__construct();
		add_filter( 'locale', array( $this, 'locale' ) );
	}

	function locale( $locale ) {
		if ( is_admin() ) {
			$user_id = get_current_user_id();
			$locale  = get_user_meta( $user_id, 'simple_admin_language', true );
			$locale  = !empty( $locale ) ? $locale : $this->general;
		}
		return $locale;
	}
}
