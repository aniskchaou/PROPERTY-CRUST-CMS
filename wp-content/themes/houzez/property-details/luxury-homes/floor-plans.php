<?php
$floor_plans          = get_post_meta( get_the_ID(), 'floor_plans', true );

if( !empty( $floor_plans ) ) {
?>
<div class="fw-property-floor-plans-wrap fw-property-section-wrap" id="property-floor-plans-wrap">
	<div class="block-wrap">
		<div class="block-title-wrap">
			<h2><?php echo houzez_option('sps_floor_plans', 'Floor Plans'); ?></h2>
		</div><!-- block-title-wrap -->
		<div class="block-content-wrap">

			<div class="floor-plans-tabs">
				<ul class="nav nav-tabs justify-content-center">
					
					<?php
	                $i = 0;
	                foreach( $floor_plans as $pln ):
	                    $i++;
	                    if( $i == 1 ) {
	                        $active = 'active';
	                    } else {
	                        $active = '';
	                    }

	                    $plan_title = isset($pln['fave_plan_title']) ? esc_attr($pln['fave_plan_title']) : '';
	                    echo '<li class="nav-item"><a class="nav-link '.$active.'" href="#floor-'.$i.'" data-toggle="tab">'.$plan_title.'</a></li>';
	                endforeach;
	                ?>
				</ul>
			</div>

			<div class="tab-content horizontal-tab-content" id="property-tab-content">
				<?php
                $j = 0;
                foreach( $floor_plans as $plan ):
                    $j++;
                    if( $j == 1 ) {
                        $active_tab = 'active show';
                    } else {
                        $active_tab = '';
                    }
                    $price_postfix = '';

                    $plan_image = isset($plan['fave_plan_image']) ? $plan['fave_plan_image'] : '';
                    $plantitle = isset($plan['fave_plan_title']) ? esc_attr($plan['fave_plan_title']) : '';
                    $fave_plan_price = isset($plan['fave_plan_price']) ? esc_attr($plan['fave_plan_price']) : '';


                    if( !empty( $plan['fave_plan_price_postfix'] ) ) {
                        $price_postfix = ' / '.$plan['fave_plan_price_postfix'];
                    }
                    $filetype = wp_check_filetype($plan_image);
                    ?>

                
				<div class="tab-pane fade <?php echo esc_attr($active_tab); ?>" id="floor-<?php echo esc_attr($j); ?>" role="tabpanel">
					<div class="floor-plan-wrap">
						<div class="d-flex align-items-center">
							<div class="floor-plan-left-wrap">
								<?php if( !empty( $plan_image ) ) { ?>
                    
			                        <?php if($filetype['ext'] != 'pdf' ) {?>
			                        <a href="<?php echo esc_url( $plan['fave_plan_image'] ); ?>" data-lightbox="roadtrip">
			                            <img class="img-fluid" src="<?php echo esc_url( $plan['fave_plan_image'] ); ?>" alt="image">
			                        </a>
			                        <?php } else { 
			                            
			                            $path = $plan_image;
			                            $file = basename($path); 
			                            $file = basename($path, ".pdf");
			                            echo '<a href="'.esc_url( $plan_image ).'" download>';
			                            echo $file;
			                            echo '</a>';
			                        } ?>
			                    
			                <?php } ?>
							</div><!-- floor-plan-left-wrap -->

							<div class="floor-plan-right-wrap">
								<h3><?php echo esc_attr( $plantitle ); ?></h3>
								
								<?php if( !empty( $fave_plan_price ) ) { ?>
								<div>
									<?php esc_html_e( 'Price', 'houzez' ); ?>: 
			                        <strong><?php echo houzez_get_property_price( $fave_plan_price ).$price_postfix; ?></strong>
			                     </div>
			                 	<?php } ?>

								<div class="floor-plan-description">
									<p><strong><?php echo esc_html__('Description', 'houzez'); ?>:</strong><br>
										<?php 
										if( isset($plan['fave_plan_description']) && !empty( $plan['fave_plan_description'] ) ) { 
											echo wp_kses_post( $plan['fave_plan_description'] ); 
										} 
										?>
									</p>
								</div><!-- floor-plan-description -->
								<div class="d-flex">
									<?php if( isset($plan['fave_plan_rooms']) && !empty( $plan['fave_plan_rooms'] ) ) { ?>
									<div class="d-flex fw-property-floor-data-wrap align-items-center">
										<img class="img-fluid" src="<?php echo HOUZEZ_IMAGE; ?>streamline-icon-hotel-double-bed-1@40x40.png" alt="">
										<div class="fw-property-floor-data">
											<?php esc_html_e( 'Rooms', 'houzez' ); ?>:<br>
											<?php echo esc_attr( $plan['fave_plan_rooms'] ); ?>
										</div><!-- fw-property-floor-data -->
									</div><!-- "d-flex -->
									<?php } ?>

									<?php if( isset($plan['fave_plan_bathrooms']) && !empty( $plan['fave_plan_bathrooms'] ) ) { ?>
									<div class="d-flex fw-property-floor-data-wrap align-items-center">
										<img class="img-fluid" src="<?php echo HOUZEZ_IMAGE; ?>streamline-icon-bathroom-shower-1@40x40.png" alt="">
										<div class="fw-property-floor-data">
											<?php esc_html_e( 'Baths', 'houzez' ); ?>:<br>
											<?php echo esc_attr( $plan['fave_plan_bathrooms'] ); ?>
										</div><!-- fw-property-floor-data -->
									</div><!-- "d-flex -->
									<?php } ?>

									<?php if( isset($plan['fave_plan_size']) && !empty( $plan['fave_plan_size'] ) ) { ?>
									<div class="d-flex fw-property-floor-data-wrap align-items-center">
										<img class="img-fluid" src="<?php echo HOUZEZ_IMAGE; ?>streamline-icon-real-estate-dimensions-plan-1@40x40.png" alt="">
										<div class="fw-property-floor-data">
											<?php esc_html_e( 'Size', 'houzez' ); ?>:<br>
											<?php echo esc_attr( $plan['fave_plan_size'] ); ?>
										</div><!-- fw-property-floor-data -->
									</div><!-- "d-flex -->
									<?php } ?>

								</div><!-- d-flex -->
							</div><!-- floor-plan-right-wrap -->
						</div><!-- d-flex -->
					</div><!--floor-plan-wrap -->
				</div>

				<?php endforeach; ?>
			</div>
		</div><!-- block-content-wrap -->
	</div><!-- block-wrap -->
</div><!-- fw-property-floor-plans-wrap -->
<?php } ?>