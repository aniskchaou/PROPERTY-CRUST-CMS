<?php
global $settings;
$area = houzez_taxonomy_simple('property_area');
echo '<li class="detail-area"><strong>'.esc_attr($settings['area_title']).'</strong> <span>'.esc_attr($area).'</span></li>';