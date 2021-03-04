<?php

class Houzez_Info_note extends \Elementor\Base_Control {

	public function get_type() {
		return 'houzez-info-note';
	}


	protected function get_default_settings() {
		return [
			'label_block' => true,
		];
	}
	public function content_template() {
		?>
		<div class="houzez-info-control-wrap">
			<p style="line-height: 18px;" class="houzez-info-control">{{{ data.label }}}</p>
		</div>
		<?php
	}

}