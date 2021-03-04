<?php
$args = array(
	"icon_type"						=> "",
	"font_awesome_icon"				=> "",
	"custom_icon"					=> "",
	"title"							=> "",
    "text"							=> "",
    "read_more_text"				=> "",
    "read_more_link"				=> ""
);

extract(shortcode_atts($args, $atts));
?>
<div class="text-with-icon-item text-with-icon-item-v2">
    <div class="d-flex">
        <div class="icon-thumb">
            <?php
            if( $icon_type == "fontawesome_icon" ) { ?>
                <div class="houzez-icon">
                    <i class="<?php echo esc_attr($font_awesome_icon); ?>"></i>
                </div>
            <?php } else {
                echo wp_get_attachment_image( $custom_icon );
            }
            ?>
        </div><!-- icon-thumb -->
        <div class="text-with-icon-content-wrap flex-grow-1">
            <div class="text-with-icon-info">
                <div class="text-with-icon-title">
                    <strong><?php echo esc_attr($title); ?></strong>
                </div><!-- text-with-icon-title -->
                <div class="text-with-icon-body">
                    <?php echo wp_kses_post($text); ?>
                </div><!-- text-with-icon-body -->
            </div><!-- text-with-icon-info -->
            
            <?php if( $read_more_link != '' ) { ?>
                <div class="text-with-icon-link">
                <a href="<?php echo esc_url($read_more_link); ?>"><?php echo esc_attr( $read_more_text ); ?></a>
                </div>
            <?php } ?>

        </div><!-- text-with-icon-content-wrap -->
    </div><!-- d-flex -->
</div><!-- text-with-icon-item  -->