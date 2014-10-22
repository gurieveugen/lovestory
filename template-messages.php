<?php get_header(); ?>
<!-- sidebar-messages-left.php -->
<?php get_sidebar('messages-left'); ?>
<?php include(__DIR__ . "/messages_direction.php"); ?>
<?php
	$inbox_page = count(ThemexUser::getMessagesInbox(ThemexUser::$data['user']['ID'], get_query_var('message')));
	$sent_page = count(ThemexUser::getMessagesSent(ThemexUser::$data['user']['ID'], get_query_var('message')));
	$unread_page = count(ThemexUser::getMessagesUnread(ThemexUser::$data['user']['ID'], get_query_var('message')));
?>
<script>
	hide_notify = true;
</script>
<div class="box_messages">
<div class="full-profile fivecol column">
	<div class="section-title">
		<h2><?php _e('My Messages', 'lovestory'); ?></h2>
	</div>
     <div class="bottom">
        <!--
		<ul id="menu_messages">
            <li id="inbox_click">Inbox</li>
            <li id="sent_click">Message Sent</li>
            <li id="unread_click">Unread only</li>
            <li>
                <div>Total Messages Received: <?php echo $inbox_page; ?></div>
                <div>Unread Messages: <?php echo $unread_page; ?></div>
                <div>Sent Messages: <?php echo $sent_page; ?></div>
            </li>
        </ul>
		-->
  
        <ul id="sub_menu_messages">
            <li id="select_all">Select all</li>
			<li id="select_none">Select None</li>
			<li id="select_delete">Delete</li>
            <li id="select_read">Read</li>
            <li id="select_unread">Unread</li>
        </ul>
    </div>
	
	
	<?php 
		$recipients=ThemexUser::getRecipients(ThemexUser::$data['user']['ID']); 

	?>
	<div id='inbox'>
	<?php 
		//$inbox_page = count(ThemexUser::getMessagesInbox(ThemexUser::$data['user']['ID'], get_query_var('message')));
		
		$page = themex_paged();
		if(isset($_POST['inbox_p']) && $_POST['inbox_p'] != '')
			$page = (int)$_POST['inbox_p'];
			
		$messages=ThemexUser::getMessagesInbox(ThemexUser::$data['user']['ID'], get_query_var('message'), $page); 
	
	if(count($messages) == 0){ ?><p class="secondary"><?php _e('No messages received yet.', 'lovestory'); ?></p>
	<?php
	}else{
	?>
		<div id="paginate"></div>
		<div class="inbox_p">
	<?php
		foreach($messages as $message) {
			$GLOBALS['comment']=$message;
			ThemexUser::$data['active_user']=ThemexUser::getUser($message->user_id);
			$age = "";
			if(ThemexUser::$data['active_user']['profile']['age'] != '')
				$age = ThemexUser::$data['active_user']['profile']['age'] . ",";
				
			$country = "";
			if(ThemexUser::$data['active_user']['profile']['country'] != '')
				$country = ThemexUser::$data['active_user']['profile']['country'] . ",";
			//var_dump(ThemexUser::$data['active_user']); die();
			?>
			<a class="message_avatar">
			<?php
			if($message->comment_karma == '0'):	
			?>
			
			<div style="background-color:#F4F9FC;">
			<?php else:?>
			
			<div>
			
			<?php endif; ?>	
					<?php ThemexUser::dataMessage($message->comment_date); ?>
					<ul>
						<li id="<?php echo ThemexUser::$data['user']['ID']; ?>"><input type="checkbox" name="stateMessage" value="<?php echo $message->comment_ID; ?>"></li>
						<li class="pointer" onclick='clickUrl("<?php echo ThemexUser::$data['active_user']['message_url']; ?>");'><?php echo get_avatar(ThemexUser::$data['active_user']['ID'], 60); ?></li>
						<li class="pointer" onclick='clickUrl("<?php echo ThemexUser::$data['active_user']['message_url']; ?>");'><?php get_template_part('module', 'status'); ?><?php echo ThemexUser::$data['active_user']['profile']['full_name']; ?>  <?php echo $age; ?> <?php echo $country; ?> <?php echo ThemexUser::$data['active_user']['profile']['city']; ?></li>
						<li class="pointer" onclick='clickUrl("<?php echo ThemexUser::$data['active_user']['message_url']; ?>");'><?php echo $message->comment_date;  ?></li>
					</ul>
					<div class="pointer" onclick='clickUrl("<?php echo ThemexUser::$data['active_user']['message_url']; ?>");'>
						<?php 
							if(strlen($message->comment_content) > 50){
								$nr = strlen($message->comment_content) - 50;
								echo substr_replace($message->comment_content ,"",-$nr) . "    ...";
							}else{
								echo $message->comment_content;
							}
						?>
					</div>
				</div>
				
			</a>
			
<?php
			//get_template_part('content', 'message');
		}
		
		}
		?>
	<!--
				<?php
					if(!empty($recipients)) { 
				?>
				<ul class="bordered-list">
					<?php 
					foreach($recipients as $recipient) {
					ThemexUser::$data['active_user']=ThemexUser::getUser($recipient['ID']);
				
					if(ThemexUser::$data['user']['ID'] == ThemexUser::$data['active_user']['ID']) continue;
					
					?>
					<li class="clearfix">
						<div class="static-column tencol">
							<h4><?php get_template_part('module', 'status'); ?>
												<a href="<?php echo ThemexUser::$data['active_user']['message_url']; ?>">
													<?php echo ThemexUser::$data['active_user']['profile']['full_name']; ?>
												</a></h4>
						</div>
						<?php if($recipient['unread']>0) { ?>
						<div class="static-column twocol last profile-value"><?php echo $recipient['unread']; ?></div>
						<?php } ?>
					</li>
					<?php 
					}
					ThemexUser::refresh();
					?>
				</ul>
				<?php } else { ?>
				<p class="secondary"><?php _e('No messages received yet.', 'lovestory'); ?></p>
				<?php } ?>
				-->
			</div>
		</div>
	<!--</div> min-->
	<div id='sent'>

		<?php
		
		$page = themex_paged();
		if(isset($_POST['sent_p']) && $_POST['sent_p'] != '')
			$page = (int)$_POST['sent_p'];
			
		$messages = ThemexUser::getMessagesSent(ThemexUser::$data['user']['ID'], get_query_var('message'), $page); 
		
		//var_dump($messages);
			if(count($messages) == 0){ ?><p class="secondary"><?php _e('No messages sent yet.', 'lovestory'); ?></p>
	<?php
	}else{
	?>
		<div id="paginate"></div>
		<div class="sent_p" style="clear:both;">
	<?php
		foreach($messages as $message) {
			
			$GLOBALS['comment']=$message;
			//var_dump($message); die();
			ThemexUser::$data['active_user']=ThemexUser::getUser($message->user_id);
			ThemexUser::$data['active_parent']=ThemexUser::getUser($message->comment_parent);
			$age = "";
			if(ThemexUser::$data['active_parent']['profile']['age'] != '')
				$age = ThemexUser::$data['active_parent']['profile']['age'] . ",";
				
			$country = "";
			if(ThemexUser::$data['active_parent']['profile']['country'] != '')
				$country = ThemexUser::$data['active_parent']['profile']['country'] . ",";
			//var_dump(ThemexUser::$data['active_user']); die();
			?>
			<div class="message">
				<?php ThemexInterface::renderMessages(); ?>
			</div>
			<a class="message_avatar">
				<?php
				if($message->comment_karma == '0'):	
					echo '<div style="background-color:#F4F9FC;">';
				?>
				
				
				<?php else:?>
				
				<div>
				 
				<?php endif; ?>	
					<ul>
						<li id="<?php echo ThemexUser::$data['user']['ID']; ?>"><input type="checkbox" name="stateMessage" value="<?php echo $message->comment_ID; ?>"></li>
						<li class="pointer" onclick='clickUrl("<?php echo ThemexUser::$data['active_parent']['message_url']; ?>");'><?php echo get_avatar(ThemexUser::$data['active_user']['ID'], 60); ?></li>
						<li class="pointer" onclick='clickUrl("<?php echo ThemexUser::$data['active_parent']['message_url']; ?>");'><?php get_template_part('module', 'statusParent'); ?><?php echo ThemexUser::$data['active_parent']['profile']['full_name']; ?>  <?php echo $age; ?> <?php echo $country; ?> <?php echo ThemexUser::$data['active_parent']['profile']['city']; ?></li>
						<li class="pointer" onclick='clickUrl("<?php echo ThemexUser::$data['active_parent']['message_url']; ?>");'><?php echo $message->comment_date;  ?></li>
					</ul>
					<div class="pointer" onclick='clickUrl("<?php echo ThemexUser::$data['active_parent']['message_url']; ?>");'>
						<?php 
							if(strlen($message->comment_content) > 50){
								$nr = strlen($message->comment_content) - 50;
								echo substr_replace($message->comment_content ,"",-$nr) . "    ...";
							}else{
								echo $message->comment_content;
							}
						?>
					</div>
				</div>
			</a>
			
			
<?php
			//get_template_part('content', 'message');
		}?>
		<?php }
		?>
	<!--
			<?php
					if(!empty($recipients)) { 
				?>
				<ul class="bordered-list">
					<?php 
					foreach($recipients as $recipient) {
					ThemexUser::$data['active_user']=ThemexUser::getUser($recipient['ID']);
				
					if(ThemexUser::$data['user']['ID'] != ThemexUser::$data['active_user']['ID']) continue;
					
					?>
					<li class="clearfix">
						<div class="static-column tencol">
							<h4><?php get_template_part('module', 'status'); ?>
												<a href="<?php echo ThemexUser::$data['active_user']['message_url']; ?>">
													<?php echo ThemexUser::$data['active_user']['profile']['full_name']; ?>
												</a></h4>
						</div>
						<?php if($recipient['unread']>0) { ?>
						<div class="static-column twocol last profile-value"><?php echo $recipient['unread']; ?></div>
						<?php } ?>
					</li>
					<?php 
					}
					ThemexUser::refresh();
					?>
				</ul>
				<?php } else { ?>
				<p class="secondary"><?php _e('No sent yet.', 'lovestory'); ?></p>
				<?php } ?>
	-->
	
		</div>
	</div>
	<!---------trash---------->
	<div id='trash'>	
			
		<?php 
		//$unread_page = count(ThemexUser::getMessagesUnread(ThemexUser::$data['user']['ID'], get_query_var('message')));
		
		$page = themex_paged();
		if(isset($_POST['trash_p']) && $_POST['trash_p'] != '')
			$page = (int)$_POST['trash_p'];
		
		$messages=ThemexUser::getMessagesTrash(ThemexUser::$data['user']['ID'], get_query_var('message'), $page); 
		//var_dump($messages); die();
			if(count($messages) == 0){ ?><p class="secondary"><?php _e('No trash yet.', 'lovestory'); ?></p>
	<?php
	}else{
	?>
		<div id="paginate"></div>
		<div class="trash_p" style="clear: both">
	<?php
		foreach($messages as $message) {
			$GLOBALS['comment']=$message;
			//var_dump($message); die();
			ThemexUser::$data['active_user']=ThemexUser::getUser($message->user_id);
			$age = "";
			if(ThemexUser::$data['active_user']['profile']['age'] != '')
				$age = ThemexUser::$data['active_user']['profile']['age'] . ",";
				
			$country = "";
			if(ThemexUser::$data['active_user']['profile']['country'] != '')
				$country = ThemexUser::$data['active_user']['profile']['country'] . ",";
			//var_dump(ThemexUser::$data['active_user']); die();
			?>
			<a class="message_avatar">
				<div>
					<ul>
						<li id="<?php echo ThemexUser::$data['user']['ID']; ?>"><input type="checkbox" name="stateMessage" value="<?php echo $message->comment_ID; ?>"></li>
						<li class="pointer" onclick='clickUrl("<?php echo ThemexUser::$data['active_user']['message_url']; ?>");'><?php echo get_avatar(ThemexUser::$data['active_user']['ID'], 60); ?></li>
						<li class="pointer" onclick='clickUrl("<?php echo ThemexUser::$data['active_user']['message_url']; ?>");'><?php get_template_part('module', 'status'); ?><?php echo ThemexUser::$data['active_user']['profile']['full_name']; ?>  <?php echo $age; ?> <?php echo $country; ?> <?php echo ThemexUser::$data['active_user']['profile']['city']; ?></li>
						<li class="pointer" onclick='clickUrl("<?php echo ThemexUser::$data['active_user']['message_url']; ?>");'><?php echo $message->comment_date;  ?></li>
					</ul>
					<div class="pointer" onclick='clickUrl("<?php echo ThemexUser::$data['active_user']['message_url']; ?>");'>
						<?php 
							if(strlen($message->comment_content) > 50){
								$nr = strlen($message->comment_content) - 50;
								echo substr_replace($message->comment_content ,"",-$nr) . "    ...";
							}else{
								echo $message->comment_content;
							}
						?>
					</div>
				</div>
				
			</a>
			
		<?php
			//get_template_part('content', 'message');
		}
		}
		?>
	</div>
	<!--</div> min-->
	
	<!---------end trash----------->
	
	<!---------draft---------->
	<div id='draft'>	
			
		<?php 
		//$unread_page = count(ThemexUser::getMessagesUnread(ThemexUser::$data['user']['ID'], get_query_var('message')));
		
		$page = themex_paged();
		if(isset($_POST['draft_p']) && $_POST['draft_p'] != '')
			$page = (int)$_POST['draft_p'];
		
		$messages=ThemexUser::getMessagesDraft(ThemexUser::$data['user']['ID'], get_query_var('message'), $page); 
		//var_dump($messages); die();
			if(count($messages) == 0){ ?><p class="secondary"><?php _e('No draft yet.', 'lovestory'); ?></p>
			
	<?php
	}else{
	?>
		<div id="paginate"></div>
		<div class="draft_p">
	<?php
		foreach($messages as $message) {
			$GLOBALS['comment']=$message;
			//var_dump($message); die();
			ThemexUser::$data['active_user']=ThemexUser::getUser($message->user_id);
			$age = "";
			if(ThemexUser::$data['active_user']['profile']['age'] != '')
				$age = ThemexUser::$data['active_user']['profile']['age'] . ",";
				
			$country = "";
			if(ThemexUser::$data['active_user']['profile']['country'] != '')
				$country = ThemexUser::$data['active_user']['profile']['country'] . ",";
			//var_dump(ThemexUser::$data['active_user']); die();
			?>
			<a class="message_avatar">
				<div>
					<ul>
						<li id="<?php echo ThemexUser::$data['user']['ID']; ?>"><input type="checkbox" name="stateMessage" value="<?php echo $message->comment_ID; ?>"></li>
						<li class="pointer" onclick='clickUrl("<?php echo ThemexUser::$data['active_user']['message_url']; ?>");'><?php echo get_avatar(ThemexUser::$data['active_user']['ID'], 60); ?></li>
						<li class="pointer" onclick='clickUrl("<?php echo ThemexUser::$data['active_user']['message_url']; ?>");'><?php get_template_part('module', 'status'); ?><?php echo ThemexUser::$data['active_user']['profile']['full_name']; ?>  <?php echo $age; ?> <?php echo $country; ?> <?php echo ThemexUser::$data['active_user']['profile']['city']; ?></li>
						<li class="pointer" onclick='clickUrl("<?php echo ThemexUser::$data['active_user']['message_url']; ?>");'><?php echo $message->comment_date;  ?></li>
					</ul>
					<div class="pointer" onclick='clickUrl("<?php echo ThemexUser::$data['active_user']['message_url']; ?>");'>
						<?php 
							if(strlen($message->comment_content) > 50){
								$nr = strlen($message->comment_content) - 50;
								echo substr_replace($message->comment_content ,"",-$nr) . "    ...";
							}else{
								echo $message->comment_content;
							}
						?>
					</div>
				</div>
				
			</a>
			
		<?php
			//get_template_part('content', 'message');
		}
		?>
		</div>
		<?php
		}
		?>
	
	</div>
	
	<!---------end draft----------->
	
	<div id='unread'>	
			
		<?php 
		//$unread_page = count(ThemexUser::getMessagesUnread(ThemexUser::$data['user']['ID'], get_query_var('message')));
		
		$page = themex_paged();
		if(isset($_POST['unread_p']) && $_POST['unread_p'] != '')
			$page = (int)$_POST['unread_p'];
		
		$messages=ThemexUser::getMessagesUnread(ThemexUser::$data['user']['ID'], get_query_var('message'), $page); 
		//var_dump($messages); die();
			if(count($messages) == 0){ ?><p class="secondary"><?php _e('No messages received yet.', 'lovestory'); ?></p>
	<?php
	}else{
	?>
		<div id="paginate"></div>
		<div class="unread_p">
	<?php
		foreach($messages as $message) {
			$GLOBALS['comment']=$message;
			//var_dump($message); die();
			ThemexUser::$data['active_user']=ThemexUser::getUser($message->user_id);
			$age = "";
			if(ThemexUser::$data['active_user']['profile']['age'] != '')
				$age = ThemexUser::$data['active_user']['profile']['age'] . ",";
				
			$country = "";
			if(ThemexUser::$data['active_user']['profile']['country'] != '')
				$country = ThemexUser::$data['active_user']['profile']['country'] . ",";
			//var_dump(ThemexUser::$data['active_user']); die();
			?>
			<a class="message_avatar">
				<div>
					<ul>
						<li id="<?php echo ThemexUser::$data['user']['ID']; ?>"><input type="checkbox" name="stateMessage" value="<?php echo $message->comment_ID; ?>"></li>
						<li class="pointer" onclick='clickUrl("<?php echo ThemexUser::$data['active_user']['message_url']; ?>");'><?php echo get_avatar(ThemexUser::$data['active_user']['ID'], 60); ?></li>
						<li class="pointer" onclick='clickUrl("<?php echo ThemexUser::$data['active_user']['message_url']; ?>");'><?php get_template_part('module', 'status'); ?><?php echo ThemexUser::$data['active_user']['profile']['full_name']; ?>  <?php echo $age; ?> <?php echo $country; ?> <?php echo ThemexUser::$data['active_user']['profile']['city']; ?></li>
						<li class="pointer" onclick='clickUrl("<?php echo ThemexUser::$data['active_user']['message_url']; ?>");'><?php echo $message->comment_date;  ?></li>
					</ul>
					<div class="pointer" onclick='clickUrl("<?php echo ThemexUser::$data['active_user']['message_url']; ?>");'>
						<?php 
							if(strlen($message->comment_content) > 50){
								$nr = strlen($message->comment_content) - 50;
								echo substr_replace($message->comment_content ,"",-$nr) . "    ...";
							}else{
								echo $message->comment_content;
							}
						?>
					</div>
				</div>
				
			</a>
			
		<?php
			//get_template_part('content', 'message');
		}
		}
		?>
	</div>
	</div>
    <!--
	<?php 
	//$recipients=ThemexUser::getRecipients(ThemexUser::$data['user']['ID']); 
	//if(!empty($recipients)) {
	?>
	<ul class="bordered-list">
		<?php 
		//foreach($recipients as $recipient) {
		//ThemexUser::$data['active_user']=ThemexUser::getUser($recipient['ID']);
		?>
		<li class="clearfix">
			<div class="static-column tencol">
				<h4><?php get_template_part('module', 'status'); ?>
                                    <a href="<?php echo ThemexUser::$data['active_user']['message_url']; ?>">
                                        <?php echo ThemexUser::$data['active_user']['profile']['full_name']; ?>
                                    </a></h4>
			</div>
			<?php if($recipient['unread']>0) { ?>
			<div class="static-column twocol last profile-value"><?php echo $recipient['unread']; ?></div>
			<?php } ?>
		</li>
		<?php 
		//}
		//ThemexUser::refresh();
		?>
	</ul>
	<?php //} else { ?>
	<p class="secondary"><?php _e('No messages received yet.', 'lovestory'); ?></p>
	<?php //} ?>

    -->
    
<?php //get_sidebar('profile-right'); ?>
<?php //get_footer(); ?>

</div>
</div>
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="<?php echo THEME_URI; ?>js/jquery.pagination.js"></script>
<script type="text/javascript">


	function visibleFilter(){
	
		if ($('#inbox').is(':visible')) {
			return 'inbox';
		}else if ($('#sent').is(':visible')) {
			return 'sent';
		}else if ($('#unread').is(':visible')) {
			return 'unread';
		}else{
			return 'inbox';
		}

	}
	
	function reloadHolePage(){
		$.ajax({
			 url: window.location,
			 dataType: "html",
			}).success(function(data) {
				  //var result = $('<div />').append(data).find('.box_messages').html();
				  //$('.box_messages').empty();
				  //$('.box_messages').append(result);
				  var data = data.replace('<body', '<body><div id="body"').replace('</body>','</div></body>');
				  var body = $(data).filter('#body').html();
				  $('body').html(body);
	    });	
	
	}
	

	$(function() {
			setTimeout( "reloadHolePage()", 60000*10);
			
			var $show = visibleFilter();
			var count_page;
			switch($show){
				case 'inbox':
					count_page = <?php echo $inbox_page; ?>;
				break;
				case 'sent':
					count_page = <?php echo $sent_page; ?>;
				break;
				case 'unread':
					count_page = <?php echo $unread_page; ?>;
				break;
				default:
					count_page = 1;
			}
			
			$('#' + $show + " #paginate").pagination({
			items: count_page,
			itemsOnPage: 6,
			cssStyle: 'light-theme',
			onPageClick: function(pageNumber, event) {
						$.ajax({
								 url: window.location,
								 type: "post",
								 dataType: "html",
								data: $show + "_p=" + pageNumber, 
								}).success(function(data) {
									  var result = $('<div />').append(data).find('.' + $show + '_p').html();
									  $('.' + $show + '_p').html(result);
								});	
							
							}
			
		}); 
		
	});
</script>
	