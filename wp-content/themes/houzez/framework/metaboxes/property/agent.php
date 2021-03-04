<?php
/**
 * Add agent metabox tab
 *
 * @param $metabox_tabs
 *
 * @return array
 */
function houzez_agent_metabox_tab( $metabox_tabs ) {
	if ( is_array( $metabox_tabs ) ) {

		$metabox_tabs['agent'] = array(
			'label' => houzez_option('cls_contact_info', 'Contact Information'),
            'icon' => 'dashicons-businessman',
		);

	}
	return $metabox_tabs;
}
add_filter( 'houzez_property_metabox_tabs', 'houzez_agent_metabox_tab', 60 );


/**
 * Add agent metaboxes fields
 *
 * @param $metabox_fields
 *
 * @return array
 */
function houzez_agent_metabox_fields( $metabox_fields ) {
	$houzez_prefix = 'fave_';

	$is_multi_agents = false;
    $enable_multi_agents = houzez_option('enable_multi_agents');
    if( $enable_multi_agents != 0 ) {
        $is_multi_agents = true;
    }

	$fields = array(
		array(
            'name' => houzez_option('cl_contact_info_text', 'What information do you want to display in agent data container?'),
            'id' => "{$houzez_prefix}agent_display_option",
            'type' => 'radio',
            'std' => 'author_info',
            'options' => array(
                'author_info' => houzez_option('cl_author_info', 'Author Info'),
                'agent_info' => houzez_option('cl_agent_info', 'Agent Info (Choose agent from the list below)'),
                'agency_info' => houzez_option('cl_agency_info', 'Agency Info (Choose agency from the list below)'),
                'none' => houzez_option('cl_not_display', 'Do not display'),
            ),
            'columns' => 12,
            'inline' => false,
            'tab' => 'agent',
        ),
        array(
            'name' => houzez_option('cl_agent_info_plac', 'Select an Agent'),
            'id' => "{$houzez_prefix}agents",
            'type' => 'select',
            'options' => houzez_get_agents_array(),
            'columns' => 12,
            'tab' => 'agent',
            'visible' => array( $houzez_prefix.'agent_display_option', '=', 'agent_info' ),
            'multiple' => $is_multi_agents
        ),
        array(
            'name' => houzez_option('cl_agency_info_plac', 'Select an Agency'),
            'id' => "{$houzez_prefix}property_agency",
            'type' => 'select',
            'options' => houzez_get_agency_array(),
            'columns' => 12,
            'tab' => 'agent',
            'visible' => array( $houzez_prefix.'agent_display_option', '=', 'agency_info' ),
            'multiple' => false
        ),
	);

	return array_merge( $metabox_fields, $fields );

}
add_filter( 'houzez_property_metabox_fields', 'houzez_agent_metabox_fields', 60 );
