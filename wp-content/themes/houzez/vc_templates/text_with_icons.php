<?php
$style = '';
$args = array(
    "columns" => "three_columns",
);

$html = "";

extract(shortcode_atts($args, $atts));

$columns_class = "module-3cols";
if($columns == 'four_columns') {
    $columns_class = "module-4cols";
}

echo '<div class="text-with-icons-module '.esc_attr( $columns_class ).' clearfix">';

echo do_shortcode($content);

echo '</div>';