<?php
  wp_enqueue_style('wp-ep_fitness-style-11', wp_ep_fitness_URLPATH . 'admin/files/css/iv-bootstrap.css');
  wp_enqueue_style('wp-ep_fitness-style-12', wp_ep_fitness_URLPATH . 'admin/files/css/profile-login-sign-up.css');
  wp_enqueue_style('all', wp_ep_fitness_URLPATH . 'admin/files/css/all.min.css');
  wp_enqueue_script("jquery");
  require(wp_ep_fitness_DIR .'/admin/files/css/color_style.php');
?>
<div id="login-2" class="bootstrap-wrapper">
  <div class="menu-toggler sidebar-toggler">
  </div>
  <div class="content">
    <form id="login_form710" class="login-form" action="" method="post">
      <h3 class="form-title"><?php  esc_html_e('Sign In','epfitness');?></h3>
      <div class="form-content">
        <div class="display-hide" id="error_message">
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-3 col-sm-4">
              <label class="control-label visible-ie8 visible-ie9"><?php  esc_html_e('Username','epfitness');?></label>
            </div>
            <div class="col-md-9 col-sm-8">
              <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="<?php  esc_html_e('Username','epfitness');?>" name="username710" id="username710"/>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-3 col-sm-4">
              <label class="control-label visible-ie8 visible-ie9"><?php  esc_html_e('Password','epfitness');?></label>
            </div>
            <div class="col-md-9 col-sm-8">
              <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="<?php  esc_html_e('Password','epfitness');?>" name="password710" id="password710"/>
            </div>
          </div>
        </div>
        <div class="form-actions row">
          <div class="col-md-3"></div>
          <div class="col-md-3 col-sm-4 col-xs-4">
            <button type="button" class="btn-new btn-custom" onclick="return chack_login();" ><?php  esc_html_e('Login','epfitness');?></button>
          </div>       
          <p class="margin-20 para col-md-6 col-sm-8 col-xs-8 text-right">
            <a href="javascript:;" class="forgot-link"><?php  esc_html_e('Forgot Password?','epfitness');?> </a>
          </p>
        </div>
      </div>
      <?php
        if(has_action('oa_social_login')) {
        ?>
        <div class="form-actions row">
          <div class="col-md-4"> </div>
          <div class="col-md-3">  <?php echo do_action('oa_social_login'); ?></div>
          <div class="col-md-3"> </div>
        </div>
        <?php
        }
      ?>
      <div class="create-account">
        <p><?php
          $iv_redirect = get_option( '_ep_fitness_price_table');
          $reg_page= get_permalink( $iv_redirect);
        ?><?php  esc_html_e('Are you a new user?','epfitness');?>
        <a  href="<?php echo esc_url($reg_page);?>" id="register-btn" class="uppercase"><?php  esc_html_e('Create an account','epfitness');?>  </a>
        </p>
      </div>
    </form>
    <form id="forget-password" name="forget-password" class="forget-form" action="" method="post" >
      <h3><?php  esc_html_e('Forget Password ?','epfitness');?>  </h3>
      <div class="form-content">
        <div class="row">
          <div class="col-md-4 col-sm-4">
            <div id="forget_message">
              <p>
                <?php  esc_html_e('Enter your e-mail address','epfitness');?>
              </p>
            </div>
          </div>
          <div class="col-md-8 col-sm-8">
            <div class="form-group">
              <input class="form-control form-control-solid placeholder-no-fix" type="text"  placeholder="<?php  esc_html_e('Email','epfitness');?>" name="forget_email" id="forget_email"/>
            </div>
            <div class="">
              <button type="button" id="back-btn" class="btn-new btn-warning margin-b-30"><?php  esc_html_e('Back','epfitness');?> </button>
              <button type="button" onclick="return forget_pass();"  class="btn-new btn-custom pull-right margin-b-30"><?php  esc_html_e('Submit','epfitness');?> </button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
<?php
  wp_enqueue_script('iv_fitness-ar-script-47', wp_ep_fitness_URLPATH . 'admin/files/js/login.js');
  wp_localize_script('iv_fitness-ar-script-47', 'fit_data', array(
  'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
  'loading_image'		=> wp_ep_fitness_URLPATH.'admin/files/images/loader.gif',
  'current_user_id'	=>get_current_user_id(),
  'forget_sent'=> esc_html__( 'Password Sent. Please check your email.','epfitness'),
  'login_error'=> esc_html__( 'Invalid Username & Password.','epfitness'),
  'login_validator'=> esc_html__( 'Enter Username & Password.','epfitness'),
  'forget_validator'=> esc_html__( 'Enter Email Address','epfitness'),
  'settingnonce'=> wp_create_nonce("settings"),
  ) );
?>