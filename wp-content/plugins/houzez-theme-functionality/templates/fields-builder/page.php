<?php 
if(isset($_GET['action']) && ( $_GET['action'] == 'add-new' || $_GET['action'] == 'houzez-edit-field')) {
	load_template( HOUZEZ_TEMPLATES . '/fields-builder/fields-form.php' );
} else {
	load_template( HOUZEZ_TEMPLATES . '/fields-builder/index.php' );
}
?>