<div class="menu-edit-property-wrap">
    <div class="menu-title">
        <?php esc_html_e('Menu', 'houzez'); ?> 
    </div><!-- menu-title -->
    <ul class="menu-edit-property list-unstyled">
        <?php
        $layout = houzez_option('property_form_sections');
        $layout = $layout['enabled'];

        if ($layout): foreach ($layout as $key=>$value) {

            switch($key) {

                case 'description-price':
                    echo '<li>
                            <a href="#" data-val="description-price" class="menu-edit-property-link">
                                <i class="houzez-icon icon-arrow-right-1"></i> '.houzez_option('cls_description_price', 'Description & Price').'
                            </a>
                        </li>';
                    break;

                case 'media':
                    echo '<li>
                            <a href="#" data-val="media" class="menu-edit-property-link">
                                <i class="houzez-icon icon-arrow-right-1"></i> '.houzez_option('cls_media', 'Media').'
                            </a>
                        </li>';
                    break;

                case 'details':
                    echo '<li>
                            <a href="#" data-val="details" class="menu-edit-property-link">
                                <i class="houzez-icon icon-arrow-right-1"></i> '.houzez_option('cls_details', 'Details').'
                            </a>
                        </li>';
                    break;

                case 'energy_class':
                    echo '<li>
                            <a href="#" data-val="energy-class" class="menu-edit-property-link">
                                <i class="houzez-icon icon-arrow-right-1"></i> '.houzez_option('cls_energy_class', 'Energy Class').'
                            </a>
                        </li>';
                    break;

                case 'features':
                    echo '<li>
                            <a href="#" data-val="features" class="menu-edit-property-link">
                                <i class="houzez-icon icon-arrow-right-1"></i> '.houzez_option('cls_features', 'Features').'
                            </a>
                        </li>';
                    break;

                case 'location':
                    echo '<li>
                            <a href="#" data-val="location" class="menu-edit-property-link">
                                <i class="houzez-icon icon-arrow-right-1"></i> '.houzez_option('cls_location', 'Location').'
                            </a>
                        </li>';
                    break;
                
                case 'virtual_tour':
                    echo '<li>
                            <a href="#" data-val="virtual-tour" class="menu-edit-property-link">
                                <i class="houzez-icon icon-arrow-right-1"></i> '.houzez_option('cls_virtual_tour', '360° Virtual Tour').'
                            </a>
                        </li>';
                    break;

                case 'floorplans':
                    echo '<li>
                            <a href="#" data-val="floorplan" class="menu-edit-property-link">
                                <i class="houzez-icon icon-arrow-right-1"></i> '.houzez_option('cls_floor_plans', 'Floor Plans').'
                            </a>
                        </li>';
                    break;

                case 'multi-units':
                    echo '<li>
                            <a href="#" data-val="sub-properties" class="menu-edit-property-link">
                                <i class="houzez-icon icon-arrow-right-1"></i> '.houzez_option('cls_sub_listings', 'Sub Listings').'
                            </a>
                        </li>';
                    break;

                case 'agent_info':
                    if(houzez_show_agent_box()) {
                        echo '<li>
                                <a href="#" data-val="contact-info" class="menu-edit-property-link">
                                    <i class="houzez-icon icon-arrow-right-1"></i> '.houzez_option('cls_contact_info', 'Contact Information').'
                                </a>
                            </li>';
                    }
                    break;

                case 'private_note':
                    echo '<li>
                            <a href="#" data-val="private-note" class="menu-edit-property-link">
                                <i class="houzez-icon icon-arrow-right-1"></i> '.houzez_option('cls_private_notes', 'Private Note').'
                            </a>
                        </li>';
                    break;

                case 'attachments':
                    echo '<li>
                            <a href="#" data-val="attachments" class="menu-edit-property-link">
                                <i class="houzez-icon icon-arrow-right-1"></i> '.houzez_option('cls_documents', 'Property Documents').'
                            </a>
                        </li>';
                    break;


            }

        }
        endif;
        if( houzez_is_admin() ) {
            echo '<li>
                    <a href="#" data-val="settings" class="menu-edit-property-link">
                        <i class="houzez-icon icon-arrow-right-1"></i> '.houzez_option('cls_settings', 'Property Settings').'
                    </a>
                </li>';
        }
        ?>
    </ul>
</div><!-- menu-edit-property-wrap -->