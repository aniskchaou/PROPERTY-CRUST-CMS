<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Houzez_Team_Member_Translate {
    
    public function __construct() {
       add_filter( 'wpml_elementor_widgets_to_translate', [
            $this,
            'houzez_Team_Member_to_translate'
        ] );
    }

    public function houzez_Team_Member_to_translate( $widgets ) {

        $widgets['houzez_elementor_team_member'] = [
            'conditions' => [ 'widgetType' => 'houzez_elementor_team_member' ],
            'fields'     => [
                [
                    'field'       => 'team_name',
                    'type'        => esc_html__( 'Team Member: Name', 'houzez-theme-functionality' ),
                    'editor_type' => 'LINE'
                ],
                [
                    'field'       => 'team_position',
                    'type'        => esc_html__( 'Team Member: Position', 'houzez-theme-functionality' ),
                    'editor_type' => 'LINE'
                ],
                [
                    'field'       => 'team_description',
                    'type'        => esc_html__( 'Team Member: Description', 'houzez-theme-functionality' ),
                    'editor_type' => 'AREA'
                ],
                [
                    'field'       => 'team_link',
                    'type'        => esc_html__( 'Team Member: Profile Link', 'houzez-theme-functionality' ),
                    'editor_type' => 'LINK'
                ],
                [
                    'field'       => 'team_social_facebook',
                    'type'        => esc_html__( 'Team Member: Facebook Link', 'houzez-theme-functionality' ),
                    'editor_type' => 'LINK'
                ],
                [
                    'field'       => 'team_social_twitter',
                    'type'        => esc_html__( 'Team Member: Twitter Link', 'houzez-theme-functionality' ),
                    'editor_type' => 'LINK'
                ],
                [
                    'field'       => 'team_social_linkedin',
                    'type'        => esc_html__( 'Team Member: LinkedIn Link', 'houzez-theme-functionality' ),
                    'editor_type' => 'LINK'
                ],
                [
                    'field'       => 'team_social_pinterest',
                    'type'        => esc_html__( 'Team Member: Pinterest Link', 'houzez-theme-functionality' ),
                    'editor_type' => 'LINK'
                ],
                [
                    'field'       => 'team_social_googleplus',
                    'type'        => esc_html__( 'Team Member: Google Link', 'houzez-theme-functionality' ),
                    'editor_type' => 'LINK'
                ],

            ],
        ];

        return $widgets;

    }
}

new Houzez_Team_Member_Translate();