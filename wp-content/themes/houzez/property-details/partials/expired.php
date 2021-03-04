<?php
/**
 * Created by PhpStorm.
 * User: waqasriaz
 * Date: 08/01/16
 * Time: 4:23 PM
 */
$allowed_html_array = array(
    'i' => array(
        'class' => array()
    ),
    'span' => array(
        'class' => array()
    ),
    'a' => array(
        'href' => array(),
        'title' => array(),
        'target' => array(),
        'data-toggle' => array(),
        'data-target' => array(),
        'class' => array(),
    )
);
?>
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div id="property_login_required" class="login-required-block detail-block target-block">
                <div class="alert alert-info login-link">
                    <?php
                    echo esc_html__('This listing expired', 'houzez'); 
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>