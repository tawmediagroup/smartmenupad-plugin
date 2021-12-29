<section class="loginForm">
	<div class="formWrapper">
		<h2><?php _e('Connect to <b>Smart Menu Pad</b>', 'smart-menupad'); ?></h2>            
		<img src="<?php echo $this->smp_plugin_url('assets/img/icon.png'); ?>" alt="image"/>
		<p><?php _e('You’re almost done! Just 2 steps to have your website connected to SmartMenuPad for automatic.', 'smart-menupad'); ?></p>
		<span><?php _e('Login with your SmartMenuPad Username and Password', 'smart-menupad'); ?></span>
		<span style="color:red;background:none;margin-right: 55px;"><?=$errorMsg?></span>
		<div class="loader" id="loadingid" style="display:none;"></div> 
		<form action ="" method ="post">    
			<input type="hidden" name="connect_smp" value="connect_smp" >
			<div class="formRow">
				<input type="hidden" name="grant_type" value="password" />
				<input type="text"  name="username" required="" id="usernamesmpid" placeholder="Enter Username"/>
			</div> 
			<div class="formRow">
				<input type="password" name="password" required="" id="passsmpid" placeholder="Enter Password" />
			</div>
			<div class="formRow">
				<button type="submit" onclick="jQuery('#loadingid').show();setTimeout(hideloader, 900);"><?php _e('Proceed to connect', 'smart-menupad'); ?></button>
			</div>
		</form>
	</div>
</section> 