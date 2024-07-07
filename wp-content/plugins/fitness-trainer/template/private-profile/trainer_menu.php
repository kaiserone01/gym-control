<li class="<?php echo ($active=='trainer-dashboard'? 'active':''); ?> ">
  <a href="<?php echo get_permalink($current_page_permalink); ?>?&fitprofile=trainer-dashboard">
		<i class="fas fa-users-cog"></i>
	<?php esc_html_e('Trainer Dashboard','epfitness');?> </a>
</li>
<li class="<?php echo ($active=='client-plan'? 'active':''); ?> ">
  <a href="<?php echo get_permalink($current_page_permalink); ?>?&fitprofile=client-plan">
		<i class="fas fa-user-check"></i>
	<?php esc_html_e('Client Plans','epfitness');?> </a>
</li>
<li class="<?php echo ($active=='saved-record'? 'active':''); ?> ">
  <a href="<?php echo get_permalink($current_page_permalink); ?>?&fitprofile=saved-record">
		<i class="fas fa-clipboard"></i>
	<?php esc_html_e('Client Records','epfitness');?> </a>
</li>
<li class="<?php echo ($active=='add-report'? 'active':''); ?> ">
  <a href="<?php echo get_permalink($current_page_permalink); ?>?&fitprofile=add-report">
		<i class="fas fa-file-pdf"></i>
	<?php esc_html_e('Client Reports','epfitness');?> </a>
</li>