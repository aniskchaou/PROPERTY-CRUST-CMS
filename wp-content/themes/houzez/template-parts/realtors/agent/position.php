<?php
global $houzez_local;
$agent_position = get_post_meta( get_the_ID(), 'fave_agent_position', true );
$agent_company = get_post_meta( get_the_ID(), 'fave_agent_company', true );
$agent_agency_id = get_post_meta( get_the_ID(), 'fave_agent_agencies', true );

$href = "";
if(!empty($agent_agency_id)) {
	$href = ' href="'.esc_url(get_permalink($agent_agency_id)).'"';
}

if(!empty($agent_position) || !empty($agent_company)) {
?>
<p class="agent-list-position"> <?php echo esc_attr($agent_position); ?>
	<?php if(!empty($agent_company)) { ?>
		
		<?php echo $houzez_local['at']; ?>
		<a<?php echo $href; ?>>
			<?php echo esc_attr( $agent_company ); ?>		
		</a>

	<?php } ?>
</p>
<?php } ?>