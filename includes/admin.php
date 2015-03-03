<?php
class SimpleAdminLanguageAdmin extends SimpleAdminLanguageInit {

	public function __construct() {
		parent::__construct();

		add_action( 'admin_init', array( $this, 'add_general_custom_fields' ) );
		add_filter( 'admin_init', array( $this, 'add_custom_whitelist_options_fields' ) );

		add_action( 'show_user_profile', array( $this, 'edit_profile_fields' ) );
		add_action( 'edit_user_profile', array( $this, 'edit_profile_fields' ) );
		add_action( 'profile_update', array( $this, 'profile_update' ), 10, 2 );
	}

	public function add_general_custom_fields() {

		add_settings_field(
			'simple-admin-language-general',
			__( 'Select the interface language', $this->domain ),
			array( $this, 'dropdown_languages' ),
			'general',
			'default',
			array(
				'name'      => 'simple-admin-language[general]',
				'add_langs' => array( 'en_US' ),
				'value'     => $this->general,
			)
		);
	}

	public function edit_profile_fields( $user ) {
		$current_user = wp_get_current_user();
		$value        = !empty( $current_user->simple_admin_language ) ? $current_user->simple_admin_language : '';
		$args         = array(
			'name'      => 'simple_admin_language',
			'add_langs' => array( '', 'en_US' ),
			'value'     => $value,
		);
		?>

		<h3><?php _e( $this->name, $this->domain ); ?></h3>
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row"><?php _e( 'Select the interface language', $this->domain ); ?></th>
					<td>
						<?php echo $this->dropdown_languages( $args ); ?>
					</td>
				</tr>
			</tbody>
		</table>
		<?php
	}

	public function dropdown_languages( $args ) {
		extract( $args );
		$langs = get_available_languages();
		$langs = array_merge( $add_langs, $langs );
		$id    = ! empty( $id ) ? $id : $name;
		$output = '<select name="' . $name . '" id="' . $id . '">' . "\n";
			foreach ( $langs as $lang ) {
				$output .= '<option value="' . $lang . '"' . selected( $value, $lang, false ) . '>' . $lang . '</option>' . "\n";
			}
		$output .= '</select>' . "\n";

		echo $output;
	}

	public function add_custom_whitelist_options_fields() {
		register_setting( 'general', 'simple-admin-language' );
	}

	public function profile_update( $user_id, $old_user_data ) {
		if ( isset( $_POST['simple_admin_language'] ) && $old_user_data->simple_admin_language != $_POST['simple_admin_language'] ) {
			$value = $_POST['simple_admin_language'];
			update_user_meta( $user_id, 'simple_admin_language', $value );
		} else {
			delete_user_meta( $user_id, 'simple_admin_language' );
		}
	}
}
