<?php 
global $houzez_local, $post; 
$key = '';
$userID      =   get_current_user_id();
$fav_option = 'houzez_favorites-'.$userID;
$fav_option = get_option( $fav_option );
if( !empty($fav_option) ) {
    $key = array_search($post->ID, $fav_option);
}

$icon = '';
if( $key != false || $key != '' ) {
    $icon = 'text-danger';
}

if(houzez_option('disable_favorite', 1) || houzez_option('disable_compare', 1) || houzez_option('disable_preview', 1) ) { ?>
<ul class="item-tools">

    <?php if(houzez_option('disable_preview', 1)) { ?>
    <li class="item-tool item-preview">
        <span class="hz-show-lightbox-js" data-listid="<?php echo intval($post->ID)?>" data-toggle="tooltip" data-placement="top" title="<?php echo houzez_option('cl_preview', 'Preview'); ?>">
                <i class="houzez-icon icon-expand-3"></i>   
        </span><!-- item-tool-favorite -->
    </li><!-- item-tool -->
    <?php } ?>
    
    <?php if(houzez_option('disable_favorite', 1)) { ?>
    <li class="item-tool item-favorite">
        <span class="add-favorite-js item-tool-favorite" data-toggle="tooltip" data-placement="top" title="<?php echo houzez_option('cl_favorite', 'Favourite'); ?>" data-listid="<?php echo intval($post->ID)?>">
            <i class="houzez-icon icon-love-it <?php echo esc_attr($icon); ?>"></i> 
        </span><!-- item-tool-favorite -->
    </li><!-- item-tool -->
    <?php } ?>

    <?php if(houzez_option('disable_compare', 1)) { ?>
    <li class="item-tool item-compare">
        <span class="houzez_compare compare-<?php echo intval($post->ID); ?> item-tool-compare show-compare-panel" data-toggle="tooltip" data-placement="top" title="<?php echo houzez_option('cl_add_compare', 'Add to Compare'); ?>" data-listing_id="<?php echo intval($post->ID); ?>" >
            <i class="houzez-icon icon-add-circle"></i>
        </span><!-- item-tool-compare -->
    </li><!-- item-tool -->
    <?php } ?>
</ul><!-- item-tools -->
<?php } ?>