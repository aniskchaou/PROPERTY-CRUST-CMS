<?php
$houzez_map_system = houzez_get_map_system();
$full_id = 'houzez-gmap-full-osm';
if( $houzez_map_system == 'google') {
	$full_id = 'houzez-gmap-full';
} 
?>
<div class="map-arrows-actions">
	<button id="listing-mapzoomin" class="map-btn"><i class="houzez-icon icon-add"></i></button>
	<button id="listing-mapzoomout" class="map-btn"><i class="houzez-icon icon-subtract"></i></button>
</div><!-- map-arrows-actions -->
<div class="map-next-prev-actions">
	<?php if($houzez_map_system == 'google') { ?>
	<ul class="dropdown-menu" aria-labelledby="houzez-gmap-view">
		<li class="dropdown-item"><a href="#" class="houzezMapType" data-maptype="roadmap"><span><?php esc_html_e( 'Roadmap', 'houzez' ); ?></span></a></li>
        <li class="dropdown-item"><a href="#" class="houzezMapType" data-maptype="satellite"><span><?php esc_html_e( 'Satelite', 'houzez' ); ?></span></a></li>
        <li class="dropdown-item"><a href="#" class="houzezMapType" data-maptype="hybrid"><span><?php esc_html_e( 'Hybrid', 'houzez' ); ?></span></a></li>
        <li class="dropdown-item"><a href="#" class="houzezMapType" data-maptype="terrain"><span><?php esc_html_e( 'Terrain', 'houzez' ); ?></span></a></li>
	</ul>
	<button id="houzez-gmap-view" class="map-btn dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="houzez-icon icon-earth-1 mr-1"></i> <span><?php esc_html_e( 'View', 'houzez' ); ?></span></button>
	<?php } ?>

	<button id="houzez-gmap-prev" class="map-btn"><i class="houzez-icon icon-arrow-left-1 mr-1"></i> <span><?php esc_html_e('Prev', 'houzez'); ?></span></button>
	<button id="houzez-gmap-next" class="map-btn"><span><?php esc_html_e('Next', 'houzez'); ?></span> <i class="houzez-icon icon-arrow-right-1 ml-1"></i></button>
</div><!-- map-next-prev-actions -->
<div class="map-zoom-actions">
	<div id="<?php echo esc_attr($full_id); ?>" class="map-btn">
		<i class="houzez-icon icon-expand-3 mr-1"></i> <span><?php esc_html_e('Fullscreen', 'houzez'); ?></span>
	</div>
</div><!-- map-zoom-actions -->