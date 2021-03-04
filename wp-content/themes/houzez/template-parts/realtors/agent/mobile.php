<?php 
global $houzez_local;
$agent_mobile = get_post_meta( get_the_ID(), 'fave_agent_mobile', true );

if(is_author()) {
	global $current_author_meta;
	$agent_mobile = isset($current_author_meta['fave_author_mobile'][0]) ? $current_author_meta['fave_author_mobile'][0] : '';
}

$agent_mobile_call = str_replace(array('(',')',' ','-'),'', $agent_mobile);
if( !empty( $agent_mobile ) ) { ?>
	<li>
		<strong><?php echo $houzez_local['mobile_colon']; ?></strong> 
		<a href="tel:<?php echo esc_attr($agent_mobile_call); ?>">
			<span class="agent-phone <?php houzez_show_phone(); ?>"><?php echo esc_attr( $agent_mobile ); ?></span>
		</a>
	</li>
<?php } ?>