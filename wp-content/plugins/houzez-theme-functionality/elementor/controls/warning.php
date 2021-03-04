<?php

class Houzez_Warning_note extends \Elementor\Base_Control {

	public function get_type() {
		return 'houzez-warning-note';
	}


	protected function get_default_settings() {
		return [
			'label_block' => true,
		];
	}
	public function content_template() {
		?>
		<div class="houzez-warning-control-wrap">
			<p style="line-height: 18px; color: red;" class="houzez-warning-control">{{{ data.label }}}</p>
		</div>
		<?php
	}

}