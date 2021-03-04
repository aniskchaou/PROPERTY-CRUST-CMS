<?php global $houzez_local; 
	$unique_id = esc_attr( uniqid( 'search-form-' ) );
?>

<form role="search" method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <div class="form-row">
        <div class="col-sm-12 col-md-8">        
            <div class="form-group">
                <input value="<?php echo get_search_query(); ?>" name="s" id="<?php echo $unique_id; ?>" type="text" placeholder="<?php echo $houzez_local['blog_search']; ?>" class="form-control">
            </div>
        </div>
        <div class="col-sm-12 col-md-4">        
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-full-width"><?php esc_html_e('Search', 'houzez'); ?></button>
            </div>
        </div>
    </div>
</form>