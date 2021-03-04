<div class="form-group">
    <label for="prop_video_url"><?php echo houzez_option('cl_video_url', 'Video URL'); ?></label>
    <input class="form-control" name="prop_video_url" value="<?php
    if (houzez_edit_property()) {
        houzez_field_meta('video_url');
    }
    ?>" placeholder="<?php echo houzez_option('cl_video_url_plac', 'YouTube, Vimeo, SWF File and MOV File are supported'); ?>" type="text">
    <small class="form-text text-muted"><?php echo houzez_option('cl_example', 'For example'); ?>: https://www.youtube.com/watch?v=49d3Gn41IaA</small>
</div>