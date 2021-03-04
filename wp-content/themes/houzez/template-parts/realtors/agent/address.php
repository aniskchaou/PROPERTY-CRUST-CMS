<address>
<?php 
$agent_address = get_post_meta( get_the_ID(), 'fave_agent_address', true );
if(!empty($agent_address)) {
	echo '<i class="houzez-icon icon-pin"></i> '.$agent_address;
}
?>
</address>