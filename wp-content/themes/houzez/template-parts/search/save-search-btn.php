<?php 
global $search_qry; 
$search_uri = '';
$get_search_uri = $_SERVER['REQUEST_URI'];
$get_search_uri = explode( '/?', $get_search_uri );
if(isset($get_search_uri[1]) && $get_search_uri[1] != "") {
    $search_uri = $get_search_uri[1];
}

if( houzez_option('enable_disable_save_search', 0) ) {
?>
<div class="save-search-form-wrap">
    <?php if( !houzez_is_half_map() ) { ?>
    <form method="post" action="" class="save_search_form">
    <?php } ?>
            
        <input type="hidden" name="search_args" value='<?php print base64_encode( serialize( $search_qry ) ); ?>'>
        <input type="hidden" name="search_URI" value="<?php echo esc_attr($search_uri); ?>">
        <input type="hidden" name="search_geolocation" value="<?php echo isset($_GET['search_location']) ? esc_attr($_GET['search_location']) : ''; ?>">
        <input type="hidden" name="houzez_save_search_ajax" value="<?php echo wp_create_nonce('houzez-save-search-nounce')?>">

        <button id="save_search_click" class="btn save-search-btn" type="button">
            <?php get_template_part('template-parts/loader'); ?>
            <i class="houzez-icon icon-alarm-bell mr-1"></i> <?php echo houzez_option('srh_btn_save_search', 'Save Search'); ?>
        </button>
    <?php if( !houzez_is_half_map() ) { ?>
    </form>
    <?php } ?>
</div>
<?php } ?>