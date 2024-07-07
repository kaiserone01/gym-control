<h4>
	<?php esc_html_e('Comments & Feedback','epfitness'); ?>
</h4>
<hr>
<?php
	$args = array(	
	'post_id' => $post_data->ID,
	'status' => 'all',
	'user_id' => $current_user->ID,
	'count' => false,
	'date_query' => null, 
	);
	$comments = get_comments($args);
	foreach($comments as $comment) :
?>
<div class="row">
	<div class="comment-author vcard col-md-2 ">
		<?php
			$image_profile=get_user_meta($current_user->ID, 'iv_profile_pic_url',true);
		?>
		<img class="img-responsive" src="<?php echo esc_url($image_profile); ?>" >
	</div>
	<div class="col-md-10">
		<div class="col-md-12">
			<?php echo esc_html($comment->comment_author); ?>
		</div>
		<div class="col-md-12">
			<small><?php echo esc_html($comment->comment_date); ?></small>
		</div>
		<div class="col-md-12">
			<?php echo esc_html($comment->comment_content); ?>
		</div>
	</div>
</div>
<hr/>
<?php	
	$args2 = array(
	'status' => 'all',
	'parent' => $comment->comment_ID,
	);
	$comments2 = get_comments($args2);
	foreach($comments2 as $child_comment) {		
		$childuser = get_user_by( 'email', $child_comment->comment_author_email);
		$cuserId = $childuser->ID;
	?>
	<div class="row">
		<div class="comment-author vcard col-md-2 ">
			<?php
				$image_profile=get_user_meta($cuserId, 'iv_profile_pic_url',true);
			?>
			<img class="img-responsive" src="<?php echo esc_url($image_profile); ?>" >
		</div>
		<div class="col-md-10">
			<div class="col-md-12">
				<?php echo esc_html($child_comment->comment_author); ?>
			</div>
			<div class="col-md-12">
				<small><?php echo esc_html($child_comment->comment_date); ?></small>
			</div>
			<div class="col-md-12">
				<?php echo esc_html($child_comment->comment_content); ?>
			</div>
		</div>
	</div>
	<hr/>
	<?php
	}
	endforeach;
?>
<?php
	$comments_args = array(
	'label_submit' => esc_html__(  'Send', 'epfitness' ),
	'title_reply'=>'',
	'logged_in_as'=>'',
	'comment_field' => '<p class="comment-form-comment"><label for="comment">' . esc_html__(  'Any comments or feedback (Only you & expert will view)?', 'epfitness' ) . '</label><br /><textarea id="comment" name="comment" aria-required="true"></textarea></p>',
	);
	comment_form( $comments_args, $post_data->ID );
?>
<?php
	wp_enqueue_script('iv_fitness-ar-script-comments', wp_ep_fitness_URLPATH . 'admin/files/js/profile/comments.js');
	wp_localize_script('iv_fitness-ar-script-comments', 'fit_data', array(
	'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
	'loading_image'		=> '<img src="'.wp_ep_fitness_URLPATH.'admin/files/images/loader.gif">',
	'current_user_id'	=>get_current_user_id(),
	'Please_wait'=> esc_html__( 'Please wait a while before posting your next comment','epfitness'),
	'thanks'=> 		   esc_html__( 'Thanks for your comment. We appreciate your response','epfitness'),
	'quickly'=>esc_html__( 'Posting too quickly','epfitness'),
	'processing'=>esc_html__( 'Processing','epfitness'),	
	'remove'=>esc_html__( 'Remove','epfitness'),
	) );
?>