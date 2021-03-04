<?php

$values = isset($instance['fvalues']) && ! empty( $instance['fvalues'] ) ? $instance['fvalues'] : array();
$iterator = new ArrayIterator( $values );

do{ ?>
    <div class="houzez-clone">
        <div class="toclone">
            <input placeholder="<?php esc_html_e( 'Enter Value', 'houzez-theme-functionality' ); ?>" type="text" name="hz_fbuilder[fvalues][]" value="<?php echo $values[ $iterator->key() ]; ?>"/>
            <a href="#" class="delete"><span class="dashicons dashicons-trash"></span></a>
            <a href="#" class="clone"><span class="dashicons dashicons-plus"></span></a>
        </div>
    </div>

<?php $iterator->next(); } while( $iterator->valid() );