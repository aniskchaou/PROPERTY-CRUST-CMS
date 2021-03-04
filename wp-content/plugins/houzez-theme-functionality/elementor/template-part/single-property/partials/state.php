<?php
global $settings;
$state = houzez_taxonomy_simple('property_state');
echo '<li class="detail-state"><strong>'.esc_attr($settings['state_title']).'</strong> <span>'.esc_attr($state).'</span></li>';