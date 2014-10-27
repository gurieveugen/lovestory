<aside class="sidebar fourcol column last">
<?php 
echo 'user id '.$data['user']['ID'];
if(ThemexUser::checkAccess(ThemexUser::$data['user']['ID'], ThemexUser::$data['active_user']['ID'], 'favorites')) {
	get_template_part('module', 'favorites');
}

if(ThemexUser::checkAccess(ThemexUser::$data['user']['ID'], ThemexUser::$data['active_user']['ID'], 'photos')) {
	get_template_part('module', 'photos');
} 

if(ThemexUser::checkAccess(ThemexUser::$data['user']['ID'], ThemexUser::$data['active_user']['ID'], 'gifts') && !ThemexCore::checkOption('user_gifts')) {
	get_template_part('module', 'gifts');
}

if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('profile_right'));


function super_unique($array,$key)
{

   $temp_array = array();

   foreach ($array as &$v) {

       if (!isset($temp_array[$v[$key]]))

       $temp_array[$v[$key]] =& $v;

   }

   $array = array_values($temp_array);

    return $array;


}
?>
</aside>

<aside class="profile_right">
<div id="cell1">
	<div id="visitors">
		<div class="title"><span>Last Visitors to my profile</span></div>
		<?php 
			$profile_packs = ThemexUser::getUser(ThemexUser::$data['active_user']['ID'], 1); 
			
			foreach($profile_packs['favorites'] as $val){
			ThemexUser::$data['active_user']=ThemexUser::getUser($val['ID']);
			
			$gender = ThemexUser::$data['active_user']['profile']['gender'] . ", ";
			if($gender == ', ') $gender = ""; 		
			$age = ThemexUser::$data['active_user']['profile']['age'] . ", ";
			if($age == ', ') $age = "";
			$country = ThemexUser::$data['active_user']['profile']['city'];
		?>
		<ul>
			<li><?php echo get_avatar(ThemexUser::$data['active_user']['ID'], 35); ?><li>
			<li>
				<div><?php echo ThemexUser::$data['active_user']['profile']['full_name']; ?> <?php get_template_part('module', 'status'); ?> </div>
				<div><?php echo $gender . $age . $country; ?></div>
			</li>
		</ul>
			
		<?php
			}
			
		?>
	</div>
	
	<div id="memebers_intersted">
		<div class="title"><span>Members interested in me</span></div>
		<?php 
			$profile_packs = ThemexUser::getUser(ThemexUser::$data['user']['ID'], 1); 
			$profile_packs = super_unique($profile_packs['gifts'], 'sender');
		
		foreach($profile_packs as $val){
			ThemexUser::$data['active_user']=ThemexUser::getUser($val['sender']);
			
			$gender = ThemexUser::$data['active_user']['profile']['gender'] . ", ";
			if($gender == ', ') $gender = ""; 		
			$age = ThemexUser::$data['active_user']['profile']['age'] . ", ";
			if($age == ', ') $age = "";
			$country = ThemexUser::$data['active_user']['profile']['city'];
		?>
		<ul>
			<li><?php echo get_avatar(ThemexUser::$data['active_user']['ID'], 35); ?><li>
			<li>
				<div><?php echo ThemexUser::$data['active_user']['profile']['full_name']; ?> <?php get_template_part('module', 'status'); ?> </div>
				<div><?php echo $gender . $age . $country; ?></div>
			</li>
		</ul>
			
		<?php
			}
			
		?>
	</div>
</div>
<div id="cell2">
	<div id="added_favorites">
				<div class="title"><span>Members i have added in Favorites</span></div>
	<?php 
		$profile_packs = ThemexUser::getUser(ThemexUser::$data['user']['ID'], 1); 
		
		foreach($profile_packs['favorites'] as $val){
		ThemexUser::$data['active_user']=ThemexUser::getUser($val['ID']);
		
		$gender = ThemexUser::$data['active_user']['profile']['gender'] . ", ";
		if($gender == ', ') $gender = ""; 		
		$age = ThemexUser::$data['active_user']['profile']['age'] . ", ";
		if($age == ', ') $age = "";
		$country = ThemexUser::$data['active_user']['profile']['city'];
	?>
	<ul>
		<li><?php echo get_avatar(ThemexUser::$data['active_user']['ID'], 35); ?><li>
		<li>
			<div><?php echo ThemexUser::$data['active_user']['profile']['full_name']; ?> <?php get_template_part('module', 'status'); ?> </div>
			<div><?php echo $gender . $age . $country; ?></div>
		</li>
	</ul>
		
	<?php
		}
		
	?>
	
	</div>
	<div id="sent_gifts">
		<div class="title"><span>Members i have sent gifts &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div>
	<?php 
		$profile_packs = ThemexUser::getUser(ThemexUser::$data['user']['ID'], 1); 
		//var_dump($profile_packs['giftsS']); //debug
		$profile_packs = super_unique($profile_packs['giftsS'], 'sender');
		
		foreach($profile_packs as $val){
		
		ThemexUser::$data['active_user']=ThemexUser::getUser($val['sender']);
		
		$gender = ThemexUser::$data['active_user']['profile']['gender'] . ", ";
		if($gender == ', ') $gender = ""; 		
		$age = ThemexUser::$data['active_user']['profile']['age'] . ", ";
		if($age == ', ') $age = "";
		$country = ThemexUser::$data['active_user']['profile']['city'];
	?>
	<ul>
		<li><?php echo get_avatar(ThemexUser::$data['active_user']['ID'], 35); ?><li>
		<li>
			<div><?php echo ThemexUser::$data['active_user']['profile']['full_name']; ?> <?php get_template_part('module', 'status'); ?> </div>
			<div><?php echo $gender . $age . $country; ?></div>
		</li>
	</ul>
		
	<?php
		}
		
	?>
	</div>
</div>	
</aside>



