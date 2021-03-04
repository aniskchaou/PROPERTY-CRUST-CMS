<?php 
global $houzez_local;
$agent_office_num = get_post_meta( get_the_ID(), 'fave_agent_office_num', true );
if(is_author()) {
	global $current_author_meta;
	$agent_office_num = isset($current_author_meta['fave_author_phone'][0]) ? $current_author_meta['fave_author_phone'][0] : '';
}
$agent_office_call = str_replace(array('(',')',' ','-'),'', $agent_office_num);

if( !empty($agent_office_num) ) { ?>
    <li>
    	<strong><?php echo $houzez_local['office_colon']; ?></strong> 
    	<a href="tel:<?php echo esc_attr($agent_office_call); ?>">
	    	<span class="agent-phone <?php houzez_show_phone(); ?>"><?php echo esc_attr( $agent_office_num ); ?></span>
	    </a>
    </li>
<?php } ?>