<?php
$currency_symbol = houzez_option( 'currency_symbol' );
$where_currency = houzez_option( 'currency_position' );
$select_packages_link = houzez_get_template_link('template/template-packages.php');

if( isset( $_GET['selected_package'] ) ) {
    $total_taxes = 0;
    $selected_package_id     = isset( $_GET['selected_package'] ) ? $_GET['selected_package'] : '';
    $pack_price              = get_post_meta( $selected_package_id, 'fave_package_price', true );
    $pack_listings           = get_post_meta( $selected_package_id, 'fave_package_listings', true );
    $pack_featured_listings  = get_post_meta( $selected_package_id, 'fave_package_featured_listings', true );
    $pack_unlimited_listings = get_post_meta( $selected_package_id, 'fave_unlimited_listings', true );
    $pack_tax = get_post_meta( $selected_package_id, 'fave_package_tax', true );
    $pack_billing_period     = get_post_meta( $selected_package_id, 'fave_billing_time_unit', true );
    $pack_billing_frquency   = get_post_meta( $selected_package_id, 'fave_billing_unit', true );
    $fave_package_popular    = get_post_meta( $selected_package_id, 'fave_package_popular', true );

    if( !empty($pack_tax) && !empty($pack_price) ) {
        $total_taxes = intval($pack_tax)/100 * $pack_price;
        $total_taxes = round($total_taxes, 2);
    }
    
    $package_total_price = $pack_price + $total_taxes;

    if( $pack_billing_frquency > 1 ) {
        $pack_billing_period .='s';
    }
    if ( $where_currency == 'before' ) {
        $package_price = $currency_symbol.''.$pack_price;
        $package_total_price = $currency_symbol.''.$package_total_price;
    } else {
        $package_price = $pack_price.''.$currency_symbol;
        $package_total_price = $package_total_price.''.$currency_symbol;
    }

    ?>
    <div class="membership-package-order-detail-wrap">
        <div class="dashboard-content-block">
            <h3><?php esc_html_e( 'Membership Package', 'houzez' ); ?></h3>
            <div class="membership-package-order-detail">

                <ul class="list-unstyled mebership-list-info">
                    <li>
                        <i class="houzez-icon icon-check-circle-1 mr-2 primary-text"></i> 
                        <?php esc_html_e( 'Package Name', 'houzez' ); ?> 
                        <strong><?php echo get_the_title( $selected_package_id ); ?></strong>
                    </li>

                    <li>
                        <i class="houzez-icon icon-check-circle-1 mr-2 primary-text"></i> 
                        <?php esc_html_e('Price', 'houzez'); ?> 
                        <strong><?php echo esc_attr( $package_price ); ?></strong>
                    </li>

                    <li>
                        <i class="houzez-icon icon-check-circle-1 mr-2 primary-text"></i> 
                        <?php esc_html_e( 'Time Period', 'houzez' ); ?>
                        <strong><?php echo esc_attr( $pack_billing_frquency ).' '.HOUZEZ_billing_period( $pack_billing_period ); ?></strong>
                    </li>
                    <li>
                        <i class="houzez-icon icon-check-circle-1 mr-2 primary-text"></i> 
                        <?php esc_html_e( 'Listing Included', 'houzez' ); ?>
                        <?php if( $pack_unlimited_listings == 1 ) { ?>
                            <strong><?php esc_html_e( 'Unlimited', 'houzez' ); ?></strong>
                        <?php } else { ?>
                            <strong><?php echo esc_attr( $pack_listings ); ?></strong>
                        <?php } ?>
                    </li>
                    <li>
                        <i class="houzez-icon icon-check-circle-1 mr-2 primary-text"></i> 
                        <?php esc_html_e( 'Featured Listing Included', 'houzez' ); ?>  
                        <strong><?php echo esc_attr( $pack_featured_listings ); ?></strong>
                    </li>

                    <?php if($pack_tax != "") { ?>
                    <li>
                        <i class="houzez-icon icon-check-circle-1 mr-2 primary-text"></i> 
                        <?php esc_html_e('Taxes', 'houzez'); ?> 
                        <strong><?php echo esc_attr($pack_tax); ?>%</strong>
                    </li>
                    <?php } ?>

                    <li class="total-price">
                        <?php esc_html_e( 'Total Price', 'houzez' ); ?> 
                        <strong><?php echo esc_attr($package_total_price); ?></strong>
                    </li>
                </ul>
            </div><!-- membership-package-order-detail -->    
        </div>
        <div class="text-center">
            <a href="<?php echo esc_url( $select_packages_link ); ?>"><?php esc_html_e( 'Change Package', 'houzez' ); ?></a>
        </div>
    </div><!-- membership-package-order-detail-wrap -->
<?php } ?>