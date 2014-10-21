<aside class="column threecol">

	
	<div class="profile-preview">
		<div class="profile-image">
        	<?php echo 'USER ID '.ThemexUser::$data['user']['ID'];?>
			<?php  echo get_avatar(ThemexUser::$data['user']['ID'], 200); ?>
		</div>
		<div class="profile-options clearfix">
			<form action="" enctype="multipart/form-data" method="POST" class="upload-form">
				<label for="user_avatar" class="button small"><?php _e('Change Photo', 'lovestory'); ?></label>
				<input type="file" id="user_avatar" name="user_avatar" class="shifted" />
				<input type="hidden" name="user_action" value="update_avatar" />
				<input type="hidden" name="nonce" value="<?php echo wp_create_nonce(THEMEX_PREFIX.'nonce'); ?>" />
			</form>
		</div>
	</div>
	<div class="widget profile-menu">
		<ul>
			<li <?php if(get_query_var('author')) { ?>class="current"<?php } ?>><a href="<?php echo ThemexUser::$data['user']['profile_url']; ?>"><?php _e('My Profile', 'lovestory'); ?></a></li>
			<?php if(ThemexUser::$data['user']['membership']['ID']>=0) { ?>
			<li <?php if(get_query_var('memberships')) { ?>class="current"<?php } ?>><a href="<?php echo ThemexUser::$data['user']['memberships_url']; ?>"><?php _e('My Membership', 'lovestory'); ?></a></li>
			<?php } ?>
			<li <?php if(get_query_var('editprofile')) { ?>class="current"<?php } ?> id="editprofile_click"> <a href="<?php echo ThemexUser::$data['user']['editprofile_url']; ?>"><?php _e('Edit Profile', 'lovestory'); ?></a></li>	
			<li <?php if(get_query_var('settings')) { ?>class="current"<?php } ?>><a href="<?php echo ThemexUser::$data['user']['settings_url']; ?>"><?php _e('Edit Settings', 'lovestory'); ?></a></li>							
			<li <?php if(get_query_var('messages')) { ?>class="current"<?php } ?>>
				<div class="static-column tencol">
					<a href="<?php echo ThemexUser::$data['user']['messages_url']; ?>"><?php _e('My Messages', 'lovestory'); ?></a>
				</div>
				<div class="static-column twocol last profile-value"><?php echo ThemexUser::countMessages(ThemexUser::$data['user']['ID']); ?></div>
				<div class="clear"></div>
			</li>
		</ul>
	</div>

	<form class="formatted-form" id="formatted-form_left" action="" method="POST">
		<table class="profile-fields">
			<tbody>
				<?php if(!ThemexCore::checkOption('user_name')) { ?>
				<tr>
					<th><?php _e('First Name', 'lovestory'); ?></th>
					<td>
						<div class="field-wrap">
							<input type="text" name="first_name" size="50" value="<?php echo ThemexUser::$data['user']['profile']['name']; ?>" />
						</div>
					</td>
				</tr>
				<tr>
					<th><?php _e('Last Name', 'lovestory'); ?></th>
					<td>
						<div class="field-wrap">
							<input type="text" name="last_name" size="50" value="<?php echo ThemexUser::$data['user']['profile']['last_name']; ?>" />
						</div>
					</td>
				</tr>
				<?php } ?>
				<?php if(!ThemexCore::checkOption('user_gender')) { ?>
				<tr>
					<th><?php _e('Gender', 'lovestory'); ?></th>
					<td>
						<div class="select-field">
							<span></span>
							<?php 
							echo ThemexInterface::renderOption(array(
								'id' => 'gender',
								'type' => 'select',
								'value' => !empty(ThemexUser::$data['user']['profile']['gender'])?ThemexUser::$data['user']['profile']['gender']:'man',
								'options' => ThemexCore::$components['genders'],
								'wrap' => false,
							));
							?>
						</div>
					</td>
				</tr>
				<tr>
					<th><?php _e('Seeking', 'lovestory'); ?></th>
					<td>
						<div class="select-field">
							<span></span>
							<?php 
							echo ThemexInterface::renderOption(array(
								'id' => 'seeking',
								'type' => 'select',
								'value' => !empty(ThemexUser::$data['user']['profile']['seeking'])?ThemexUser::$data['user']['profile']['seeking']:'woman',
								'options' => ThemexCore::$components['genders'],
								'wrap' => false,
							));
							?>
						</div>
					</td>
				</tr>
				<?php } ?>
				<?php if(!ThemexCore::checkOption('user_age')) { ?>
				<tr>
					<th><?php _e('Age', 'lovestory'); ?></th>
					<td>
						<div class="select-field">
							<span></span>
							<?php 
							echo ThemexInterface::renderOption(array(
								'id' => 'age',
								'type' => 'select_age',
								'value' => ThemexUser::$data['user']['profile']['age'],
								'wrap' => false,
							));
							?>
						</div>
					</td>
				</tr>
				<?php } ?>
				<?php if(!ThemexCore::checkOption('user_location')) { ?>
				<tr>
					<th><?php _e('Country', 'lovestory'); ?></th>
					<td>
						<div class="select-field">
							<span></span>
							<?php 
							echo ThemexInterface::renderOption(array(
								'id' => 'country',
								'type' => 'select',
								'options' => array_merge(array('0' => '&ndash;'), ThemexCore::$components['countries']),
								'value' => !empty(ThemexUser::$data['user']['profile']['country'])?ThemexUser::$data['user']['profile']['country']:null,
								'wrap' => false,				
							));
							?>
						</div>
					</td>
				</tr>
				<tr>
					<th><?php _e('City', 'lovestory'); ?></th>
					<td>
						<div class="field-wrap">
							<input type="text" name="city" size="50" value="<?php echo ThemexUser::$data['user']['profile']['city']; ?>" />
						</div>
					</td>
				</tr>
                <tr>
					<th><?php _e('Height', 'lovestory'); ?></th>
					<td>
						<div class="field-wrap">
							<input type="text" name="city" size="50" value="<?php echo ThemexUser::$data['user']['profile']['height-in-cm']; ?>" />
						</div>
					</td>
				</tr>
                <tr>
					<th><?php _e('Weight', 'lovestory'); ?></th>
					<td>
						<div class="field-wrap">
							<input type="text" name="city" size="50" value="<?php echo ThemexUser::$data['user']['profile']['weight-in-kilos']; ?>" />
						</div>
					</td>
				</tr>
				<?php } ?>
				<?php
				ThemexForm::renderData('profile', array(
					'edit' =>  true,
					'before_title' => '<tr><th>',
					'after_title' => '</th>',
					'before_content' => '<td>',
					'after_content' => '</td></tr>',
				), ThemexUser::$data['user']['profile']);
				?>
			</tbody>
		</table>
		<div class="profile-description">
			<?php ThemexInterface::renderEditor('description', wpautop(ThemexUser::$data['user']['profile']['description'])); ?>
		</div>		
		<a href="#" class="button submit-button"><?php _e('Save Changes', 'lovestory'); ?></a>
		<input type="hidden" name="update" value="1" />
		<input type="hidden" name="user_action" value="update_profile" />
		<input type="hidden" name="nonce" value="<?php echo wp_create_nonce(THEMEX_PREFIX.'nonce'); ?>" />
	</form>
</aside>