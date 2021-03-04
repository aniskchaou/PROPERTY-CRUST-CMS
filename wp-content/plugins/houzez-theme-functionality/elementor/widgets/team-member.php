<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Elementor Team Widget.
 * @since 1.5.6
 */
class Houzez_Elementor_Team_Member extends Widget_Base {

    /**
     * Get widget name.
     *
     * Retrieve widget name.
     *
     * @since 1.5.6
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'houzez_elementor_team_member';
    }

    /**
     * Get widget title.
     * @since 1.5.6
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'Team', 'houzez-theme-functionality' );
    }

    /**
     * Get widget icon.
     *
     * @since 1.5.6
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-person';
    }

    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the widget belongs to.
     *
     * @since 1.5.6
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories() {
        return [ 'houzez-elements' ];
    }

    /**
     * Register widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.5.6
     * @access protected
     */
    protected function _register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label'     => esc_html__( 'Content', 'houzez-theme-functionality' ),
                'tab'       => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'team_image',
            [
                'label'     => esc_html__( 'Image', 'houzez-theme-functionality' ),
                'type'  => Controls_Manager::MEDIA,
                'description'   => '370 x 550 pixels',
            ]
        );

        $this->add_control(
            'team_name',
            [
                'label'     => esc_html__( 'Name', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::TEXT,
                'description'   => '',
            ]
        );

        $this->add_control(
            'team_position',
            [
                'label'     => esc_html__( 'Position', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::TEXT,
                'description'   => '',
            ]
        );
        $this->add_control(
            'team_description',
            [
                'label'     => esc_html__( 'Description', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::WYSIWYG,
                'description'   => '',
            ]
        );
        $this->add_control(
            'team_link',
            [
                'label'     => esc_html__( 'Custom Link', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::TEXT,
                'placeholder' => 'https://your-link.com',
                'description'   => '',
            ]
        );

        $this->add_control(
            'team_social_facebook',
            [
                'label'     => esc_html__( 'Facebook Profile Link', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::TEXT,
                'description'   => '',
            ]
        );
        $this->add_control(
            'team_social_facebook_target',
            [
                'label'     => esc_html__( 'Facebook Target', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    "_self" => "Self",
                    "_blank" => "Blank",
                    "_parent" => "Parent"
                ],
                'default' => '',
            ]
        );
        $this->add_control(
            'team_social_twitter',
            [
                'label'     => esc_html__( 'Twitter Profile Link', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::TEXT,
                'description'   => '',
            ]
        );
        $this->add_control(
            'team_social_twitter_target',
            [
                'label'     => esc_html__( 'Twitter Target', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    "_self" => "Self",
                    "_blank" => "Blank",
                    "_parent" => "Parent"
                ],
                'default' => '',
            ]
        );

        $this->add_control(
            'team_social_linkedin',
            [
                'label'     => esc_html__( 'LinkedIn Profile Link', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::TEXT,
                'description'   => '',
            ]
        );
        $this->add_control(
            'team_social_linkedin_target',
            [
                'label'     => esc_html__( 'LinkedIn Target', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    "_self" => "Self",
                    "_blank" => "Blank",
                    "_parent" => "Parent"
                ],
                'default' => '',
            ]
        );
        $this->add_control(
            'team_social_pinterest',
            [
                'label'     => esc_html__( 'Pinterest Profile Link', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::TEXT,
                'description'   => '',
            ]
        );
        $this->add_control(
            'team_social_pinterest_target',
            [
                'label'     => esc_html__( 'Pinterest Target', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    "_self" => "Self",
                    "_blank" => "Blank",
                    "_parent" => "Parent"
                ],
                'default' => '',
            ]
        );
        $this->add_control(
            'team_social_googleplus',
            [
                'label'     => esc_html__( 'Google Plus Profile Link', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::TEXT,
                'description'   => '',
            ]
        );
        $this->add_control(
            'team_social_googleplus_target',
            [
                'label'     => esc_html__( 'Google Plus Target', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    "_self" => "Self",
                    "_blank" => "Blank",
                    "_parent" => "Parent"
                ],
                'default' => '',
            ]
        );
        
        $this->end_controls_section();

    }

    /**
     * Render widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.5.6
     * @access protected
     */
    protected function render() {

        $settings = $this->get_settings_for_display();

        $args['team_image']    =  $settings['team_image']['id'];
        $args['team_name']     =  $settings['team_name'];
        $args['team_position']  =  $settings['team_position'];
        $args['team_description']  =  $settings['team_description'];
        $args['team_link']  =  $settings['team_link'];

        $args['team_social_facebook']  =  $settings['team_social_facebook'];
        $args['team_social_twitter']  =  $settings['team_social_twitter'];
        $args['team_social_linkedin']  =  $settings['team_social_linkedin'];
        $args['team_social_pinterest']  =  $settings['team_social_pinterest'];
        $args['team_social_googleplus']  =  $settings['team_social_googleplus'];

        $args['team_social_facebook_target']  =  $settings['team_social_facebook_target'];
        $args['team_social_twitter_target']  =  $settings['team_social_twitter_target'];
        $args['team_social_linkedin_target']  =  $settings['team_social_linkedin_target'];
        $args['team_social_pinterest_target']  =  $settings['team_social_pinterest_target'];
        $args['team_social_googleplus_target']  =  $settings['team_social_googleplus_target'];
       
        if( function_exists( 'houzez_team' ) ) {
            echo houzez_team( $args );
        }

    }

}

Plugin::instance()->widgets_manager->register_widget_type( new Houzez_Elementor_Team_Member );