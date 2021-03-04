<?php
global $settings;
$country = houzez_taxonomy_simple('property_country');
echo '<li class="detail-country"><strong>'.esc_attr($settings['country_title']).'</strong> <span>'.esc_attr($country).'</span></li>';