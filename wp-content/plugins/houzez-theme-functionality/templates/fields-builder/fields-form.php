<?php
$instance = null;

if ( Houzez_Fields_Builder::is_edit_field() ) {
    $page_title = esc_html__( 'Update field', 'houzez-theme-functionality' );
    $button_title = esc_html__( 'Update', 'houzez-theme-functionality' );
    $instance = Houzez_Fields_Builder::get_edit_field();
} else {
    $page_title = esc_html__( 'Create field', 'houzez-theme-functionality' );
    $button_title = esc_html__( 'Submit', 'houzez-theme-functionality' );
}
$add_new = Houzez_Fields_Builder::field_add_link();
?>

<h2 class="houzez-heading-inline"><?php esc_html_e('Fields Builder', 'houzez-theme-functionality');?></h2>
<a href="<?php echo esc_url($add_new);?>" class="page-title-action"><?php esc_html_e('Add New', 'houzez-theme-functionality');?></a>

<div class="admin-houzez-row">
    <div class="admin-houzez-box-wrap">
        <div class="admin-houzez-box">
            <div class="admin-houzez-box-content">
                <form action="" method="POST" class="admin-houzez-form">
                    <div class="form-wrap">
                        <?php

                        echo Houzez::render_form_field( esc_html__( 'Field Name', 'houzez-theme-functionality' ), 'hz_fbuilder[label]', 'text', array(
                            'required' => 'required',
                            'value' => Houzez_Fields_Builder::get_field_value( $instance, 'label' ),
                            'placeholder' => esc_html__('Enter field name', 'houzez'),
                            'class' => 'hz-fbuilder-name-js',
                        ));

                        echo Houzez::render_form_field( esc_html__( 'Placeholder', 'houzez-theme-functionality' ), 'hz_fbuilder[placeholder]', 'text', array(
                            'value' => Houzez_Fields_Builder::get_field_value( $instance, 'placeholder' ),
                            'placeholder' => esc_html__('Enter field placeholder', 'houzez'),
                        ));


                        echo Houzez::render_form_field(esc_html__( 'Type', 'houzez-theme-functionality' ), 'hz_fbuilder[type]', 'list', array(
                            'values' => Houzez_Fields_Builder::get_field_types(),
                            'placeholder' => esc_html__( '-- Choose field type --', 'houzez-theme-functionality' ),
                            'required' => 'required',
                            'value' => Houzez_Fields_Builder::get_field_value( $instance, 'type' ),
                            'class' => 'houzez-fbuilder-js-on-change',
                        ) );

                        echo '<div class="houzez_multi_line_js" style="display:none;">';
                        echo Houzez::render_form_field( esc_html__( 'Options', 'houzez-theme-functionality' ), 'hz_fbuilder[options]', 'textarea', array(
                            'options' => Houzez_Fields_Builder::get_field_option($instance),
                            'placeholder' => esc_html__('Please add comma separated options. Example: One, Two, Three', 'houzez'),
                            'rows' => '3',
                        ));
                        echo '</div>';

                        echo '<div class="houzez_select_options_loader_js">';
                        if($instance['type'] == 'select' || $instance['type'] == 'multiselect') {
                            include HOUZEZ_TEMPLATES . '/fields-builder/multiple.php';
                        }
                        echo '</div>';
                        
                        echo Houzez::render_form_field(esc_html__( 'Make available for searches?', 'houzez-theme-functionality' ), 'hz_fbuilder[is_search]', 'list', array(
                            'values' => array('no' => esc_html__('No', 'houzez'), 'yes' => esc_html__('Yes', 'houzez')),
                            'required' => 'required',
                            'value' => Houzez_Fields_Builder::get_field_value( $instance, 'is_search' )
                        ) );
                        ?>

                        <div class="submit">
                            <input type="submit" class="button button-primary" value="<?php echo esc_attr($button_title);?>"/>
                        </div>
                        <?php if ( ! empty( $instance['id'] ) ) : ?>
                            <input type="hidden" name="hz_fbuilder[id]" value="<?php echo $instance['id']; ?>"/>
                        <?php endif; ?>

                        <?php wp_nonce_field( 'houzez_fbuilder_save_field', 'houzez_fbuilder_save_field' ); ?>	
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>