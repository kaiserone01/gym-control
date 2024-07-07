<?php
	wp_enqueue_script("jquery");	
	wp_enqueue_style('wp-ep_fitness-myaccount-style-11', wp_ep_fitness_URLPATH . 'admin/files/css/iv-bootstrap.css');
	wp_enqueue_script('bootstrap', wp_ep_fitness_URLPATH . 'admin/files/js/bootstrap.min.js');
	wp_enqueue_style('add-listing-stylemyaccount', wp_ep_fitness_URLPATH . 'admin/files/css/my-account.css');
	wp_enqueue_style('front-end', wp_ep_fitness_URLPATH . 'admin/files/css/front-end.css');
	wp_enqueue_style('all', wp_ep_fitness_URLPATH . 'admin/files/css/all.min.css');
	wp_enqueue_style('jquery-ui', wp_ep_fitness_URLPATH . 'admin/files/css/jquery-ui.css');	
	wp_enqueue_style('jquery.fancybox', wp_ep_fitness_URLPATH . 'admin/files/css/jquery.fancybox.css');
	wp_enqueue_script('jquery.fancybox',wp_ep_fitness_URLPATH . 'admin/files/js/jquery.fancybox.js');
	global $current_user;
	$current_page_permalink= get_page_link();
	require(wp_ep_fitness_DIR .'/admin/files/css/color_style.php');
	$user = new WP_User( $current_user->ID );
	if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
		foreach ( $user->roles as $role ){
			$crole= ucfirst($role);
			break;
		}
	}
	if(strtoupper($crole)!=strtoupper('administrator')){
		include(wp_ep_fitness_template.'/private-profile/check_status.php');
	}
	$color_setting=get_option('_dir_color');
	if($color_setting==""){$color_setting='#bfbfbf';}
	$color_setting=str_replace('#','',$color_setting);
	wp_enqueue_media();
	require(wp_ep_fitness_DIR .'/admin/files/css/color_style.php');
	$currencies = array();
	$currencies['AUD'] ='$';$currencies['CAD'] ='$';
	$currencies['EUR'] ='€';$currencies['GBP'] ='£';
	$currencies['JPY'] ='¥';$currencies['USD'] ='$';
	$currencies['NZD'] ='$';$currencies['CHF'] ='Fr';
	$currencies['HKD'] ='$';$currencies['SGD'] ='$';
	$currencies['SEK'] ='kr';$currencies['DKK'] ='kr';
	$currencies['PLN'] ='zł';$currencies['NOK'] ='kr';
	$currencies['HUF'] ='Ft';$currencies['CZK'] ='Kč';
	$currencies['ILS'] ='₪';$currencies['MXN'] ='$';
	$currencies['BRL'] ='R$';$currencies['PHP'] ='₱';
	$currencies['MYR'] ='RM';$currencies['AUD'] ='$';
	$currencies['TWD'] ='NT$';$currencies['THB'] ='฿';
	$currencies['TRY'] ='TRY';	$currencies['CNY'] ='¥';
	$currency= get_option('_ep_fitness_api_currency');
	$currency_symbol=(isset($currencies[$currency]) ? $currencies[$currency] :$currency );
?>
<div id="profile-account2" class="bootstrap-wrapper around-separetor">
  <div class="row margin-top-10">
    <div class="col-md-3">
      <div class="profile-sidebar">
        <div class="portlet portlet0 light profile-sidebar-portlet">
          <div class="profile-userpic text-center" id="profile_image_main">
						<?php
							$iv_profile_pic_url=get_user_meta($current_user->ID, 'iv_profile_pic_url',true);
							if($iv_profile_pic_url!=''){ ?>
							<img src="<?php echo esc_url($iv_profile_pic_url); ?>" class="pt1_img">
							<?php
								}else{
								$iv_profile_pic_url= wp_ep_fitness_URLPATH.'assets/images/Blank-Profile.jpg';
							?>
							<img src="<?php echo esc_url($iv_profile_pic_url); ?>" class="pt1_img">
							<?php
							}
						?>
					</div>
					<div class="profile-usertitle">
						<div class="profile-usertitle-name">
							<?php
								$name_display=get_user_meta($current_user->ID,'first_name',true).' '.get_user_meta($current_user->ID,'last_name',true);
							echo (trim($name_display)!=""? $name_display : $current_user->display_name );?>
						</div>
						<div class="profile-usertitle-job">
							<?php echo get_user_meta($current_user->ID,'occupation',true); ?>
						</div>
					</div>
					<div class="profile-userbuttons">
						<button type="button" onclick="edit_profile_image('profile_image_main');"  class="btn green-haze"><?php esc_html_e('Change','epfitness'); ?> </button>
					</div>
					<div class="profile-usermenu">
						<?php
							$active=(isset($_GET['fitprofile'])?$_GET['fitprofile']:'training-plans');
							if(isset($_GET['fitprofile']) AND $_GET['fitprofile']=='setting' ){
								$active='setting';
							}
							if(isset($_GET['fitprofile']) AND $_GET['fitprofile']=='level' ){
								$active='level';
							}
							if(isset($_GET['fitprofile']) AND $_GET['fitprofile']=='records' ){
								$active='records';
							}
							if(isset($_GET['fitprofile']) AND $_GET['fitprofile']=='add-record' ){
								$active='add-record';
							}
							if(isset($_GET['fitprofile']) AND $_GET['fitprofile']=='saved-record' ){
								$active='saved-record';
							}
							$userId=$current_user->ID;
							$user_id=$current_user->ID;
							$user = new WP_User( $userId );
							if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
								foreach ( $user->roles as $role ){
									$crole= $role;
									break;
								}
							}
						?>
						<ul class="nav">
							<?php
								$trainer_package= get_user_meta($current_user->ID, 'trainer_package', true);
								if($trainer_package>0 || strtoupper($crole)==strtoupper('administrator')){
									include('trainer_menu.php');
								}
								$account_menu_check= '';
								if( get_option( '_ep_fitness_menusetting' ) ) {
									$account_menu_check= get_option('_ep_fitness_menusetting');
								}
								if($account_menu_check!='yes'){
								?>
								<li class="<?php echo ($active=='setting'? 'active':''); ?> ">
									<a href="<?php echo get_permalink($current_page_permalink); ?>?&fitprofile=setting">
										<i class="fas fa-cog"></i>
									<?php esc_html_e('Account Settings','epfitness');?> </a>
								</li>
								<?php
								}
								$trainer_package= get_user_meta($current_user->ID, 'trainer_package', true);
								if($trainer_package=='' || strtoupper($crole)==strtoupper('administrator')){
								?>
								<?php
									$account_menu_check= '';
									if( get_option( '_ep_fitness_mylevel' ) ) {
										$account_menu_check= get_option('_ep_fitness_mylevel');
									}
									if($account_menu_check!='yes'){
									?>
									<li class="<?php echo ($active=='level'? 'active':''); ?> ">
										<a href="<?php echo get_permalink($current_page_permalink); ?>?&fitprofile=level">
											<i class="fas fa-user-lock"></i>
										<?php esc_html_e('Membership Level','epfitness'); ?> </a>
									</li>
									<?php
									}
								?>
								<?php
									$account_menu_check= '';
									if( get_option( '_ep_fitness_menurecords' ) ) {
										$account_menu_check= get_option('_ep_fitness_menurecords');
									}
									if($account_menu_check!='yes'){
									?>
									<li class="<?php echo ($active=='records'? 'active':''); ?> ">
										<a href="<?php echo get_permalink($current_page_permalink); ?>?&fitprofile=records">
											<i class="fas fa-folder-open"></i>
										<?php esc_html_e('My Records','epfitness');?> </a>
									</li>
									<?php
									}
								?>
								<?php
									$account_menu_check= '';
									if( get_option( '_ep_fitness_menumy-report' ) ) {
										$account_menu_check= get_option('_ep_fitness_menumy-report');
									}
									if($account_menu_check!='yes'){
									?>
									<li class="<?php echo ($active=='my-report'? 'active':''); ?> ">
										<a href="<?php echo get_permalink($current_page_permalink); ?>?&fitprofile=my-report">
											<i class="fas fa-file-alt"></i>
										<?php esc_html_e('My Reports','epfitness');?> </a>
									</li>
									<?php
									}
								?>
								<?php		$package_id=get_user_meta($current_user->ID,'ep_fitness_package_id',true);
									$training_program= get_post_meta($package_id, 'iv_training_program', true);
									$default_fields = array();
									$field_set=get_option('_ep_fitness_url_postype' );
									if($field_set!=""){
										$default_fields=get_option('_ep_fitness_url_postype' );
										}else{
										$default_fields['training-plans']='Training Plans';
										$default_fields['detox-plans']='Detox Plans';
										$default_fields['diet-plans']='Diet Plans';
										$default_fields['diet-guide']='Diet Guide';
										$default_fields['recipes']='Recipes';
									}
									foreach ( $default_fields as $field_key => $field_value ) {
									?>
									<li class="<?php echo ($active==$field_key? 'active':''); ?> ">
										<a href="<?php echo get_permalink($current_page_permalink).'?&fitprofile='.$field_key; ?>".>
											<i class="fas fa-calendar-alt"></i>
										<?php echo esc_html($field_value);?> </a>
									</li>
									<?php
									}
								?>
								<?php     $old_custom_menu = array();
									if(get_option('ep_fitness_profile_menu')){
										$old_custom_menu=get_option('ep_fitness_profile_menu' );
									}
									$ii=1;
									if($old_custom_menu!=''){
										foreach ( $old_custom_menu as $field_key => $field_value ) { ?>
										<li class="">
											<a href="<?php echo esc_html($field_value); ?>">
												<i class="fas fa-file-alt"></i>
											<?php echo esc_html($field_key);?> </a>
										</li>
										<?php
										}
									}
								?>
								<?php
								}
							?>
							<li class="<?php echo ($active=='log-out'? 'active':''); ?> ">
								<a href="<?php echo wp_logout_url( home_url() ); ?>" >
									<i class="fas fa-sign-out-alt"></i>
									<?php esc_html_e('Sign out','epfitness');?>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<?php ?>
		<div class="col-md-9">
			<?php
				$fitprofile=(isset($_GET['fitprofile'])?$_GET['fitprofile']:'');
			
				$style=(isset($_GET['style'])?$_GET['style']:'');
				$file_include='training-calendar.php';
				switch ($fitprofile) {
					case "level":
					$file_include='profile-level-1.php';
					break;
					case "setting":
					$file_include='profile-setting-1.php';
					break;
					case "record-edit":
					$file_include='profile-record-edit.php';
					break;
					case "records":
					$file_include='profile-all-record.php';
					break;
					case "add-record":
					$file_include='profile-new-record.php';
					break;
					case "add-report":
					$file_include='all-save-report.php';
					break;
					case "new-report":
					$file_include='new_report.php';
					break;
					case "edit-report":
					$file_include='edit_report.php';
					break;
					case "my-report":
					$file_include='my-report.php';
					break;
					case "saved-record":
					$file_include='all-save-records.php';
					break;
					case "add-plan":
					$file_include='new-listing.php';
					break;
					case "edit-post":
					$file_include='listing-edit.php';
					break;
					case "client-plan":
					$file_include='all-save-post.php';
					break;
					case "add-recordpt":
					$file_include='record-new-pt.php';
					break;
					case "edit-recordpt": 
					$file_include='record-edit-pt.php';
					break;
					case "post":
					$file_include='profile-single-post.php';
					break;
					case "trainer-dashboard":
					$file_include='trainer-dashboard.php';
					break;
					default:
					$trainer_defualt='no';
					$trainer_role=get_option('epfitness_trainer_role');
					if(isset($current_user->roles[0]) and $current_user->roles[0]=='administrator'){
						if($fitprofile==''){
							$trainer_defualt='yes';
						}
					}
					$trainer_package= get_user_meta($current_user->ID, 'trainer_package', true);
					if($trainer_package>0 AND $current_user->roles[0]!='administrator'){
						$trainer_defualt='yes';
					}
					if($trainer_defualt=='no'){
						$i=1;$f_cpt='';
						$default_fields = array();
						$field_set=get_option('_ep_fitness_url_postype' );
						if($field_set!=""){
							$default_fields=get_option('_ep_fitness_url_postype' );
							}else{
							$default_fields['training-plans']='Training Plans';
							$default_fields['detox-plans']='Detox Plans';
							$default_fields['diet-plans']='Diet Plans';
							$default_fields['diet-guide']='Diet Guide';
							$default_fields['recipes']='Recipes';
						}
						foreach ( $default_fields as $field_key => $field_value ) {
							$f_cpt=$field_key;
							break;
						}
						foreach ( $default_fields as $field_key => $field_value ) {
							$old_select=get_option('cpt_page_'.$field_key);
							if($fitprofile==''){
								$frist_cpt=get_option('cpt_page_'.$f_cpt);
								if($frist_cpt==''){$frist_cpt='training-calendar';}
								$file_include=$frist_cpt.'.php';
								break;
							}
							if($field_key==$fitprofile){
								if($old_select!=''){
									$file_include=$old_select.'.php';
									}else{
									if($i==1){
										$file_include='training-calendar.php';
										}else{
										$file_include='post-list.php';
									}
								}
								break;
							}
							$i++;
						}
						}else{
						$file_include='trainer-dashboard.php';
					}
				}
				include(  wp_ep_fitness_template. 'private-profile/'.$file_include);
			?>
		</div>
	</div>
</div>
<?php
	$currencyCode= get_option('_ep_fitness_api_currency');
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-datepicker');
	wp_enqueue_script('iv_fitness-ar-script-s13', wp_ep_fitness_URLPATH . 'admin/files/js/profile/setting.js');
	wp_localize_script('iv_fitness-ar-script-s13', 'fit_s13', array(
	'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
	'loading_image'		=> '<img src="'.wp_ep_fitness_URLPATH.'admin/files/images/loader.gif">',
	'current_user_id'	=>get_current_user_id(),
	'delete_message'=> esc_html__( 'Do you want to delete the report?','epfitness'),
	'permalink'=>  get_permalink($current_page_permalink)."?&fitprofile=records"  	,
	'add'=> 		   esc_html__( 'Add','epfitness'),
	'setimage'=> esc_html__( 'Set Image','epfitness'),
	'settingnonce'=> wp_create_nonce("settings"),
	'signup'=> wp_create_nonce("signup"),
	'edit'=> esc_html__( 'Edit','epfitness'),
	'remove'=> esc_html__( 'Remove','epfitness'),
	'confirmmessage'=> esc_html__( 'Are you sure to cancel this Membership?','epfitness'),
	'currencyCode'=> $currencyCode,
	"sProcessing"=>  esc_html__('Processing','epfitness'),
	"sSearch"=>   esc_html__('Search','epfitness'),
	"lengthMenu"=>   esc_html__('Display _MENU_ records per page','epfitness'),
	"zeroRecords"=>  esc_html__('Nothing found - sorry','epfitness'),
	"info"=>  esc_html__('Showing page _PAGE_ of _PAGES_','epfitness'),
	"infoEmpty"=>   esc_html__('No records available','epfitness'),
	"infoFiltered"=>  esc_html__('(filtered from _MAX_ total records)','epfitness'),
	"sFirst"=> esc_html__('First','epfitness'),
	"sLast"=>  esc_html__('Last','epfitness'),
	"sNext"=>     esc_html__('Next','epfitness'),
	"sPrevious"=>  esc_html__('Previous','epfitness'),
	) );
	

?>
