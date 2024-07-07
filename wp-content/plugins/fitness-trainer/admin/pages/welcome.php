<?php if (!defined('ABSPATH')) {
	die;
} // Cannot access directly. ?>

<div class="wrap ep-wrap">

    <div class="ep-admin-page-header">

        <div class="ep-admin-page-header-text">
            <h1><?php esc_html_e('Welcome to Fitnase Membership!', 'epfitness'); ?></h1>
            <p><?php esc_html_e('Fitnase is a Gym & Fitness WordPress Theme', 'epfitness'); ?></p>
        </div>

        <div class="ep-admin-page-header-logo">
            <img src="<?php echo get_theme_file_uri('inc/admin/assets/images/admin-logo.png'); ?>"/>
            <strong>V-<?php echo wp_get_theme()->get('Version'); ?></strong>
        </div>
    </div>

    <div class="ep-admin-boxes">

        <div class="ep-admin-box">

            <div class="ep-admin-box-header">
                <h2><?php esc_html_e('Membership', 'epfitness'); ?></h2>
            </div>

            <div class="ep-admin-box-inside">             
                 <a href="<?php echo admin_url(); ?>admin.php?page=wp-ep_fitness-settings"
                   class="button"><?php esc_html_e('Go to Settings', 'epfitness'); ?></a>
            </div>

        </div>
		 <div class="ep-admin-box">

            <div class="ep-admin-box-header">
                <h2><?php esc_html_e('Package/Plans', 'epfitness'); ?></h2>
            </div>

            <div class="ep-admin-box-inside">
                
                <a href="<?php echo admin_url(); ?>admin.php?page=wp-ep_fitness-package-all"
                   class="button"><?php esc_html_e('Go to Package', 'epfitness'); ?></a>
            </div>

        </div>
		 <div class="ep-admin-box">

            <div class="ep-admin-box-header">
                <h2><?php esc_html_e('Coupon', 'epfitness'); ?></h2>
            </div>

            <div class="ep-admin-box-inside">
              
				<a href="<?php echo admin_url(); ?>admin.php?page=wp-ep_fitness-coupons-form"  class="button">				
               <?php esc_html_e('Go to Coupon', 'epfitness'); ?></a>
            </div>

        </div>
		<div class="ep-admin-box">

            <div class="ep-admin-box-header">
                <h2><?php esc_html_e('Payment Gateways', 'epfitness'); ?></h2>
            </div>

            <div class="ep-admin-box-inside">
               
                <a href="<?php echo admin_url(); ?>admin.php?page=wp-ep_fitness-payment-settings"
                   class="button"><?php esc_html_e('Go to Gateways', 'epfitness'); ?></a>
            </div>

        </div>
        <div class="ep-admin-box">

            <div class="ep-admin-box-header">
                <h2><?php esc_html_e('User Settings', 'epfitness'); ?></h2>
            </div>

            <div class="ep-admin-box-inside">
                
                <a href="<?php echo admin_url(); ?>admin.php?page=wp-iv_user-directory-admin"
                   class="button"><?php esc_html_e('Go to User Settings', 'epfitness'); ?></a>
            </div>

        </div>

    </div>
    <div class="ep-admin-boxes">

        <div class="ep-admin-box">

            <div class="ep-admin-box-header">
                <h2><?php esc_html_e('Membership Pages', 'epfitness'); ?></h2>
            </div>
			<?php
			 $price_table=get_option('_ep_fitness_price_table');
			$registration=get_option('_ep_fitness_registration');
			$profile_page=get_option('_ep_fitness_profile_page');
			$profile_public=get_option('_ep_fitness_profile_public_page');
			$login_page=get_option('_ep_fitness_login_page');
			$thank_you=get_option('_ep_fitness_thank_you_page');
			?>
			<div class="ep-admin-box-inside">     
				<?php
				$profile_page= get_permalink( $profile_page);
				?>
                 <a  href="<?php  echo esc_url($profile_page); ?>" target="_blank"
                   class="button"><?php esc_html_e('My Account', 'epfitness'); ?></a>
				  <?php
				$registration= get_permalink( $registration);
				?> 
				     <a  href="<?php  echo esc_url($registration); ?>" target="_blank"
                   class="button"><?php esc_html_e('Registration', 'epfitness'); ?>
				</a>
				  <?php
				$login_page= get_permalink( $login_page);
				?> 
				 <a  href="<?php  echo esc_url($login_page); ?>" target="_blank"
                   class="button"><?php esc_html_e('Login Page', 'epfitness'); ?></a>
				   <?php
					   $profile_public= get_permalink( $profile_public);
					?>  
				  <a  href="<?php  echo esc_url($profile_public); ?>" target="_blank"
                   class="button"><?php esc_html_e('Public Profile', 'epfitness'); ?></a>
            </div>
          
        </div>
		 

    </div>

</div>
