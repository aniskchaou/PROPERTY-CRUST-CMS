<?php
global $settings;
$city = houzez_taxonomy_simple('property_city');
echo '<li class="detail-city"><strong>'.esc_attr($settings['city_title']).'</strong> <span>'.esc_attr($city).'</span></li>';