<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>
	<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

<!--<script src="https://code.jquery.com/ui/1.10.4/jquery-ui.min.js"></script>
<script src="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>-->
	<script type="text/javascript" src="<?php echo THEME_URI; ?>js/script_profile.js"></script>
	<script type="text/javascript" src="<?php echo THEME_URI; ?>js/slideBoost/jquery.nstSlider.js"></script>
	<link type="text/css" rel="stylesheet" href="<?php echo THEME_URI; ?>framework/assets/css/pagination.css"/>
	<link type="text/css" rel="stylesheet" href="<?php echo THEME_URI; ?>/js/slideBoost/jquery.nstSlider.css"/>

	
	<script type="text/javascript">
		$(function() {
			setInterval( "reloadInboxNumber()", 60000*10);
		});
	</script>
	<!--[if lt IE 9]>
	<script type="text/javascript" src="<?php echo THEME_URI; ?>js/html5.js"></script>
	<![endif]-->
	
	<?php wp_head(); 

	$unread_page = count(ThemexUser::getMessagesUnread(ThemexUser::$data['user']['ID'], get_query_var('message')));
	?>
	<script>
	$(document).ready(function(){
		CheckNotification("<?php echo(ThemexUser::$data['user']['profile_url']); ?>" );
	
	});
</script>
</head>

<body <?php body_class(); ?>>
<?php //var_dump(ThemexUser::$data['user']); ?>
	<div class="site-wrap">
		<div class="header-wrap">
			<header class="site-header">
            <div class="container">
				<div class="site-logo left">
					<a href="<?php echo SITE_URL; ?>" rel="home">
						<img src="<?php echo ThemexCore::getOption('logo', THEME_URI.'images/logo.png'); ?>" alt="<?php bloginfo('name'); ?>" />
					</a>
				</div>
				<!-- /logo -->
				<div class="header-options">
					<?php if(is_user_logged_in()) { ?>
						<a href="<?php echo wp_logout_url(SITE_URL); ?>" class="button secondary"><?php _e('Sign Out', 'lovestory'); ?></a>
						<a href="<?php echo ThemexUser::$data['user']['profile_url']; ?>" class="button"><?php _e('My Profile', 'lovestory'); ?></a>
					<?php } else { ?>
						<a href="#" class="button secondary header-login-button"><?php _e('Sign In', 'lovestory'); ?></a>
						<?php if(get_option('users_can_register')) { ?>
						<a href="<?php echo ThemexCore::getURL('register'); ?>" class="button"><?php _e('Register', 'lovestory'); ?></a>
						<?php } ?>
					<?php } ?>
				</div>
				<!-- /options -->
				<nav class="header-menu right">
				<?php if($unread_page > 0){ ?>
					
				<?php } ?>	
					<?php wp_nav_menu( array( 'theme_location' => 'main_menu','container_class' => 'menu' ) ); ?>
					<div class="mobile-menu hidden">
						<div class="select-field">
							<span></span>
							<?php ThemexInterface::renderSelectMenu('main_menu'); ?>
						</div>
					</div>					
				</nav>
				<!-- /menu -->	
            </div>			
			</header>
			<?php if(is_user_logged_in()) { ?>
			<?php get_sidebar('featured-left');?>
			<?php get_sidebar('featured-right');?>
			<?php } ?>
			<!-- /header -->
			<?php if(!is_user_logged_in()) { ?>
			<div class="header-form-wrap container">
				<div class="header-form header-login-form clearfix">
					<form class="ajax-form formatted-form" action="<?php echo AJAX_URL; ?>" method="POST">
						<div class="message"></div>
						<div class="field-wrap">
							<input type="text" name="user_login" value="<?php _e('Username', 'lovestory'); ?>" />
						</div>
						<div class="field-wrap">
							<input type="password" name="user_password" value="<?php _e('Password', 'lovestory'); ?>" />
						</div>
						<a href="#" class="button submit-button"><?php _e('Sign In', 'lovestory'); ?></a>
						<?php if(ThemexFacebook::isActive()) { ?>
						<a href="<?php echo home_url('?facebook_login=1'); ?>" class="button facebook-login-button" title="<?php _e('Sign in with Facebook', 'lovestory'); ?>">
							<span class="button-icon icon-facebook nomargin"></span>
						</a>
						<?php } ?>
						<a href="#" class="button secondary header-password-button" title="<?php _e('Password Recovery', 'lovestory'); ?>">
							<span class="button-icon icon-lock nomargin"></span>
						</a>
						<input type="hidden" name="user_action" value="login_user" />
						<input type="hidden" class="nonce" value="<?php echo wp_create_nonce(THEMEX_PREFIX.'nonce'); ?>" />
						<input type="hidden" class="action" value="<?php echo THEMEX_PREFIX; ?>update_user" />
					</form>
				</div>
				<div class="header-form header-password-form clearfix">					
					<form class="ajax-form formatted-form" action="<?php echo AJAX_URL; ?>" method="POST">
						<div class="message"></div>
						<div class="field-wrap">
							<input type="text" name="user_email" value="<?php _e('Email', 'lovestory'); ?>" />
						</div>
						<a href="#" class="button submit-button"><?php _e('Reset Password', 'lovestory'); ?></a>
						<input type="hidden" name="user_action" value="reset_password" />
						<input type="hidden" class="nonce" value="<?php echo wp_create_nonce(THEMEX_PREFIX.'nonce'); ?>" />
						<input type="hidden" class="action" value="<?php echo THEMEX_PREFIX; ?>update_user" />
					</form>
				</div>
			</div>
			<?php get_sidebar('featured-left');?>
			<?php get_sidebar('featured-right');?>
			<!-- /forms -->
			<?php } ?>
			<?php if(is_front_page() && is_page()) { ?>
				<?php get_template_part('module', 'slider'); ?>
				<?php if(!ThemexCore::checkOption('search_bar') && !ThemexCore::checkOption('user_gender')) { ?>
				<div class="header-content-wrap overlay-wrap">
					<div class="header-content container">
					<?php get_template_part('module', 'search-bar'); ?>
					</div>
				</div>
				<?php } ?>
			<?php } else { ?>
			<div class="header-content-wrap">
				<div class="header-content container">
					<h1 class="page-title"><?php ThemexInterface::renderPageTitle(); ?></h1>
				</div>
			</div>
			<?php } ?>
			<!-- /content -->
		
		</div>
		
		<div class="content-wrap">
			<section class="site-content container clearfix">