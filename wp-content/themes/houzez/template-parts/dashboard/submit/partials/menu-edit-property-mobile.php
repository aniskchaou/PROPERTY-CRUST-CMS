<div class="dashboard-mobile-edit-menu-wrap">
    <div class="form-group">
        <select id="menu_edit_mobile" class="selectpicker form-control bs-select-hidden" title="<?php esc_html_e('Menu', 'houzez'); ?> " data-live-search="false" data-drop-up="false" data-size="13">
            <?php
            $layout = houzez_option('property_form_sections');
            $layout = $layout['enabled'];
            if ($layout): foreach ($layout as $key=>$value) {

                switch($key) {
                    case 'description-price':
                        echo '<option value="description-price"> '.houzez_option('cls_description_price', 'Description & Price').'</option>';
                    break;

                    case 'media':
                        echo '<option value="media"> '.houzez_option('cls_media', 'Media').'</option>';
                        break;

                    case 'details':
                        echo '<option value="details"> '.houzez_option('cls_details', 'Details').'</option>';
                        break;

                    case 'energy_class':
                        echo '<option value="energy-class"> '.houzez_option('cls_energy_class', 'Energy Class').'</option>';
                        break;

                    case 'features':
                        echo '<option value="features"> '.houzez_option('cls_features', 'Features').'</option>';
                        break;

                    case 'location':
                        echo '<option value="location"> '.houzez_option('cls_location', 'Location').'</option>';
                        break;
                    
                    case 'virtual_tour':
                        echo '<option value="virtual-tour"> '.houzez_option('cls_virtual_tour', '360° Virtual Tour').'</option>';
                        break;

                    case 'floorplans':
                        echo '<option value="floorplan"> '.houzez_option('cls_floor_plans', 'Floor Plans').'</option>';
                        break;

                    case 'multi-units':
                        echo '<option value="sub-properties"> '.houzez_option('cls_sub_listings', 'Sub Listings').'</option>';
                        break;

                    case 'agent_info':
                        if(houzez_show_agent_box()) {
                            echo '<option value="contact-info"> '.houzez_option('cls_contact_info', 'Contact Information').'</option>';
                        }
                        break;

                    case 'private_note':
                        echo '<option value="private-note"> '.houzez_option('cls_private_notes', 'Private Notes').'</option>';
                        break;

                    case 'attachments':
                        echo '<option value="attachments"> '.houzez_option('cls_documents', 'Property Documents').'</option>';
                        break;
                }
            }
            endif;

            if( houzez_is_admin() ) {
                echo '<option value="settings"> '.houzez_option('cls_settings', 'Property Settings').'</option>';
            }
            ?>
        </select><!-- selectpicker -->
    </div><!-- form-group -->
</div><!-- dashboard-mobile-edit-menu-wrap -->