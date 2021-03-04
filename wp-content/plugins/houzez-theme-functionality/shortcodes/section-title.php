<?php
/*-----------------------------------------------------------------------------------*/
/*	Module 1
/*-----------------------------------------------------------------------------------*/
if( !function_exists('houzez_section_title') ) {
	function houzez_section_title($atts, $content = null)
	{
		extract(shortcode_atts(array(
			'hz_section_title' => '',
			'hz_section_subtitle' => '',
			'hz_section_title_align' => '',
			'hz_section_title_color' => ''
		), $atts));

		ob_start();
		?>
		<div
			class="houzez-module module-title section-title-module <?php echo esc_attr($hz_section_title_align) . ' ' . esc_attr($hz_section_title_color); ?>">
			<h2><?php echo esc_attr($hz_section_title); ?></h2>

			<p class="sub-heading"><?php echo esc_attr($hz_section_subtitle); ?></p>
		</div>
		<?php
		$result = ob_get_contents();
		ob_end_clean();
		return $result;

	}

	add_shortcode('hz-section-title', 'houzez_section_title');
}
?>