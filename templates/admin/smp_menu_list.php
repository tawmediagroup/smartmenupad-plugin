<div class="smpWrapper">
	<div class="container-fluid">
		<div class="sectionBg">
			<div>
				<img src="<?php echo $this->smp_plugin_url('assets/img/logo.png'); ?>" alt="logo"/>
			</div>
			<div>
				<h2><?php _e('Smart Menu Pad', 'smart-menupad'); ?></h2>
				<p><?php _e('You’re almost done! Just 2 steps to have your website connected to SmartMenuPad for automatic.', 'smart-menupad'); ?></p>
				<p style="color:red;"><?php _e($error_message, 'smart-menupad'); ?> </p>
				<div class="syncBtn">
					<a onclick='return smplogout();' class="connectbtn"><?php _e('Logout', 'smart-menupad'); ?></a> 
					<button type="button" class="sync" onclick='return updatemenu();' ><span><?php _e('Sync Now', 'smart-menupad'); ?></span><i style="display:none;" class="spinner-border spinner-border-sm sync-spinner"></i></button>
					<p><?php _e('Last updated: ', 'smart-menupad'); ?> <?php _e($smp_last_synced); ?></p>
				</div>
			</div>
		</div>        
	</div>
	<div class="container-fluid quickSection mb-4">
		<div class="row">
			<div class="col-lg-3">
				<div class="orderBg">
					<span><?php echo intval($this->smp_total_orders()); ?></span> <p><?php _e('Total Orders', 'smart-menupad'); ?></p>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="productBg">
					<span><?php echo intval(count($smp_allmenulist)); ?></span> <p><?php _e('Total Products', 'smart-menupad'); ?></p>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="customerBg">
					<span><?php echo intval($this->smp_total_customers()); ?></span> <p><?php _e('Total Customers', 'smart-menupad'); ?></p>
				</div>            
			</div>
			<div class="col-lg-3" onclick="location.href = '<?php echo esc_url($this->smp_admin_url('smp-shortcode')); ?>' ">
				<div class="shortCodeBg">                 
					<span>+</span> <p><?php _e('Make ShortCode', 'smart-menupad'); ?></p>
				</div>            
			</div>
		</div>        
	</div>
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
			<form action ="<?php echo esc_url($this->smp_admin_url('smp-shortcode')); ?>" method ="post">    
				<input type="hidden" name="smp_make_shortcode" value="smp_make_shortcode" >
				<h2 class="wp-heading-inline"><?php _e('Food Menu', 'smart-menupad'); ?></h2>
				<div id="poststuff">
					<div id="post-body" class="metabox-holder">
						<div id="post-body-content">
							<table class="wp-list-table widefat striped posts boldText normalText">
								<thead>
									<tr>
										<th><?php _e('Title', 'smart-menupad'); ?></th>
										<!--<th><//?php _e('Title', 'smart-menupad'); ?></th>-->
										<th><?php _e('Price', 'smart-menupad'); ?></th>
										<th><?php _e('Food Category', 'smart-menupad'); ?></th>
										<th><?php _e('Publish', 'smart-menupad'); ?></th>         
										<th><?php _e('Date', 'smart-menupad'); ?></th>
										<th class="text-center"><?php _e('Action', 'smart-menupad'); ?></th>										
									</tr>
								</thead>
								<tbody id="the-list">
									<?php
										$sno = 1;
										$jsonMenuList = array();
										$allowed_html = array(
											'tr' => array(),
											'td' => array('class' => array()),
											'img' => array('class' => array(), 'src' => array(), 'alt' => array()),
											'a' => array(
												'onclick' => array(),
												'class' => array()
											),
										);
										foreach ($smp_allmenulist as $key => $value) 
										{    
											$jsonMenuList[$value['id']] = $value;
											$optionsdata = $value;
											$string      = '';
											$isPublish = $value['isPublish'];
											$createdDate = date("Y-m-d ",strtotime($value['createdDate']));
											$string .= '<tr>';                        
											$string .= '<td>
															<img class="img-responsive" src = "'.esc_url($optionsdata['imagePath']).'" alt = "'.esc_attr($optionsdata['name']).'" /> 
															'.esc_html($optionsdata['name']).'
														</td>';
											$string .= '<td> $'.(float)$optionsdata['finalPrice'].'</td>';
											$string .= '<td>'.esc_html($optionsdata['categoryName']).'</td>';
											$string .= '<td> '.($isPublish?"Published":"Un-Publish").' </td>';
											$string .= '<td> '.$createdDate.' </td>';
											$string .= '<td class="text-center"> <a href="#" class="viewLink" onclick="return viewMoreMenuInfo('.esc_attr($value['id']).');">View Detail</a> </td>';
											$string .= '</tr>';
											$sno        = $sno + 1;
											echo wp_kses($string, $allowed_html);       
										}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</form>
		</div>    
	</div>
</div>
<script>var menuItemsJSON = '<?php echo json_encode($jsonMenuList); ?>';</script>

<!-- Modal -->
<div class="modal fade" id="viewMore" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content"> 
		<div class="modal-body px-0 pt-0">
			<div class="loader" id="loadingid" style="display:none;"></div>
			<div class="menu_info">
				<div class="productImageName">
				  <button type="button" class="popupClose" data-bs-dismiss="modal" aria-label="Close">×</button>
				  <div class="menuItemImagebg" style="background-position:center top; background-repeat: no-repeat; background-size: cover;"></div>
				</div>
				<div class="addonsDetails nameInfo"></div>
				<div class="addonsDetails addonChoices"></div>
				<div class="addonsDetails multipleSizes"></div>
			</div>
		</div>
    </div>
  </div>
</div>