<div class="smpWrapper">
    <section class="container-fluid">
        <div class="row mt-4 mb-3">
            <div class="col-lg-12">
                <h2 class="wp-heading-inline">Menu Short Code</h2>
                <a href="<?=get_admin_url().'admin.php?page=smp-shortcode&quickmenuid=new'?>" class="page-title-action"> Add New </a>
                <span style="color:green;margin-left:55px;"><?=$msg?></span>
            </div>    
        </div>
        <?php if(!empty($quickmenuid)) { ?> 
            <form action ="<?php echo $this->smp_admin_url('smp-shortcode'); ?>" method ="post">  
                <?php if($quickmenuid == "new" ) { ?>
                    <input type="hidden" name="add_shortcode" value="add_shortcode" >
                <?php } 
                else { ?>
                    <input type="hidden" name="update_shortcode" value="update_shortcode" >
                    <input type="hidden" name="smp_quick_menu_id" value="<?=$quickmenuid?>" >
                <?php } ?>
                <?php
                    $title = $one_shortcode_data->title ?? '';
                    $layout_view = $one_shortcode_data->layout_view ?? '';
                    $layout_column = $one_shortcode_data->layout_column ?? '';
                    $heading_color = !empty($one_shortcode_data->heading_color)?$one_shortcode_data->heading_color:$this->heading_color;
                    $description_color = !empty($one_shortcode_data->description_color)?$one_shortcode_data->description_color:$this->description_color;
                    $price_color = !empty($one_shortcode_data->price_color)?$one_shortcode_data->price_color:$this->price_color;
                    $button_bg_color = !empty($one_shortcode_data->button_bg_color)?$one_shortcode_data->button_bg_color:$this->button_bg_color;
                    $button_bg_hover_color = !empty($one_shortcode_data->button_bg_hover_color)?$one_shortcode_data->button_bg_hover_color:$this->button_bg_hover_color;
					$button_text_color = !empty($one_shortcode_data->button_text_color)?$one_shortcode_data->button_text_color:$this->button_text_color;
                    $button_text_hover_color = !empty($one_shortcode_data->button_text_hover_color)?$one_shortcode_data->button_text_hover_color:$this->button_text_hover_color;
                    $image_border = $one_shortcode_data->image_border ?? '';
                    $image_border_array = array();
                    if(!empty($image_border)) {
                        $image_border_array = explode(",", $image_border);
                    }
                    
                    $button_border = $one_shortcode_data->button_border ?? '';
                    $button_border_array = array();
                    if(!empty($button_border)) {
                        $button_border_array = explode(",", $button_border);
                    }
                    
                    $url = $one_shortcode_data->url ?? '';
                    $selected_menu = array();
                    if(!empty($url)){
                        $selected_menu = explode(",",$url);
                    }
                ?>
                <div class="row">
                    <div class="col-lg-9">
                        <div class="row mb-4">
                            <div class="col-lg-12">
                                <input type="text" name="title" value="<?=$title?>" required="" placeholder="Enter Title" class="titleTextbox"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="wrapperBg">
                                    <h2>Product Category</h2>
                                    <div class="menuListHeight">
                                        <?php if(count($smp_category) > 0) {
                                            foreach ($smp_category as $keycat => $val) { ?>
                                                    <div class="productList">
                                                        <input onchange="filterProducts(this,<?=$keycat?>)" type="checkbox" checked="checked" value="<?=$keycat?>">
                                                        <?=$val?> 
                                                    </div>  
                                                <?php }
                                            }
                                        ?>  
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="wrapperBg ">
									<h2>Product List</h2>
									<div class="row menu_list menuListHeight">
										<?php
										$selected = '';
										foreach( $smp_allmenu_category_wise as $k => $categories ) {
											foreach ($categories as $key => $value) { 
												$checked = in_array($value['id'], $selected_menu)?' checked="checked"' :'';
												$menu = '<div class="col-xl-12 col-lg-12  marginBottom menu_'.$k.'_'.$value['id'].'"><div class="menuItemSection"><div class="row"><div class="col-6"><img src="'.$value["imagePath"].'" alt="" title="Menu Item Name" class="menuItemImage"/></div><div class="col-6"><span class="list-menu-item-price">$'.$value["finalPrice"].'</span><h3 class="list-menu-item-name">'.$value["categoryName"].'</h3><p class="list-menu-item-des">'.$value["name"].'</p><label class="labelBlock"><input onchange="menuitems(this)"'.$checked.' type="checkbox" name="menuids[]" value="'.$value['id'].'"/>Add to section</label></div></div></div></div>'; 
												if(in_array($value['id'], $selected_menu)) {
													$selected .= $menu;
												} else {
													echo $menu;
												}
											}
										} ?>
									</div> 
								</div>
                            </div>
                               
                            <div class="col-md-4">
                                <div class="wrapperBg">
                                    <h2>Selected Product</h2>
                                    <div class="row selected_menu menuListHeight">
                                        <?php echo $selected; ?>
                                    </div>
                                </div>
                          </div>                            
                        </div>   
                    </div>
                    <div class="col-lg-3">
                        <div class="sidebarWrapper mb-4">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h2><?php _e('Shortcode', 'smart-menupad'); ?></h2>
                                    <div class="postbox-section">
                                        <?php if($quickmenuid != "new") { ?>
                                            <p><?php _e('Copy and paste below shortcode into your posts or pages', 'smart-menupad'); ?></p>
                                            <div class="qt-sc-code">[smart_menupad id=<?=$quickmenuid?>]</div>
                                        <?php } ?>
                                        <button type="submit" class="pubhBtn">
                                            <?=($quickmenuid == "new")? 'Publish':'Update'?>
                                        </button>
                                    </div>    
                                </div>
                            </div>
                        </div>
                        <div class="sidebarWrapper pb-4">
                            <h2><?php _e('Preset Setting', 'smart-menupad'); ?></h2>
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="sidebarTitle"><?php _e('Choose a Layout style from below', 'smart-menupad'); ?></div>
                                        <div class="postbox-section">
                                            <select name="layout_view" id="layout_view" class="menuCategorySelect">
                                                <option value="1" <?=($layout_view == 1)? 'selected="selected"' : ""?> ><?php _e('Grid View', 'smart-menupad'); ?></option>
                                                <option value="2" <?=($layout_view == 2)? 'selected="selected"' : ""?> ><?php _e('List View', 'smart-menupad'); ?></option>                                  
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6" id="layout_column_hide" <?php if($layout_view == 2) { ?> style="display:none;" <?php } ?>>
                                        <div class="sidebarTitle"><?php _e('Column', 'smart-menupad'); ?></div>
                                        <div class="postbox-section">
                                            <select name="layout_column" id="layout_column" class="menuCategorySelect">
                                                <option value="2" <?=($layout_column == 2)? 'selected="selected"' : ""?>>2</option>
                                                <option value="3" <?=($layout_column == 3)? 'selected="selected"' : ""?>>3</option>                                  
                                                <option value="4" <?=($layout_column == 4)? 'selected="selected"' : ""?>>4</option>                                  
                                            </select>
                                        </div>    
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="sidebarTitle"><?php _e('Image Border Radius (px)', 'smart-menupad'); ?></div>
                                <div class="postbox-section">
                                    <div class="row">
                                        <div class="col-xl-3 col-lg-6 col-md-6">
                                            <input type="text" class="inputRadius" value="<?=$image_border_array[0]??""?>" name="imageborder[]" placeholder="0" title="Margin Top">
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6">
                                            <input type="text" class="inputRadius" value="<?=$image_border_array[1]??""?>" name="imageborder[]" placeholder="0" title="Margin right">
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6">
                                            <input type="text" class="inputRadius" value="<?=$image_border_array[2]??""?>" name="imageborder[]" placeholder="0" title="Margin bottom">
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6">
                                            <input type="text" class="inputRadius" value="<?=$image_border_array[3]??""?>" name="imageborder[]" placeholder="0" title="Margin left">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="sidebarTitle"><?php _e('Item Color', 'smart-menupad'); ?></div>
                                        <div class="instructionName"><?php _e('You can change the color of menu item name', 'smart-menupad'); ?></div>
                                        <div class="postbox-section">
                                            <input type="text" name="heading_color" value="<?=$heading_color?>" class="heading_color" data-default-color="#000000" />
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="sidebarTitle"><?php _e('Item Description Color', 'smart-menupad'); ?></div>
                                        <div class="instructionName"><?php _e('You can change the color of menu item description', 'smart-menupad'); ?></div>
                                        <div class="postbox-section">
                                            <input type="text" name="description_color" value="<?=$description_color?>" class="description_color" data-default-color="#898989" />
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="sidebarTitle"><?php _e('Item Price Color', 'smart-menupad'); ?></div>
                                        <div class="instructionName"><?php _e('You can change the color of menu item price', 'smart-menupad'); ?></div>
                                        <div class="postbox-section">
                                            <input type="text" name="price_color" value="<?=$price_color?>" class="price_color" data-default-color="#effeff" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="sidebarTitle"><?php _e('Button Radius (px)', 'smart-menupad'); ?></div>
                                <div class="postbox-section">
                                    <div class="row">
                                        <div class="col-xl-3 col-lg-6 col-md-6">
                                            <input type="text" class="inputRadius" value="<?=$button_border_array[0]??""?>" name="orderbtnborder[]" placeholder="0" title="Margin Top">
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6">
                                            <input type="text" class="inputRadius" value="<?=$button_border_array[0]??""?>" name="orderbtnborder[]" placeholder="0" title="Margin right">
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6">
                                            <input type="text" class="inputRadius" value="<?=$button_border_array[0]??""?>" name="orderbtnborder[]" placeholder="0" title="Margin bottom">
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6">
                                            <input type="text" class="inputRadius" value="<?=$button_border_array[0]??""?>" name="orderbtnborder[]" placeholder="0" title="Margin left">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="sidebarTitle"><?php _e('Button Background Color', 'smart-menupad'); ?></div>
                                        <div class="postbox-section">
                                            <input type="text" name="button_bg_color" value="<?=$button_bg_color?>" class="price_color" data-default-color="#effeff" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="sidebarTitle"><?php _e('Button Text Color', 'smart-menupad'); ?></div>
                                        <div class="postbox-section">
                                            <input type="text" name="button_text_color" value="<?=$button_text_color?>" class="price_color" data-default-color="#effeff" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="sidebarTitle"><?php _e('Button Background Hover Color', 'smart-menupad'); ?></div>
                                        <div class="postbox-section">
                                            <input type="text" name="button_bg_hover_color" value="<?=$button_bg_hover_color?>" class="price_color" data-default-color="#effeff" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="sidebarTitle"><?php _e('Button Hover Text Color', 'smart-menupad'); ?></div>
                                        <div class="postbox-section">
                                            <input type="text" name="button_text_hover_color" value="<?=$button_text_hover_color?>" class="price_color" data-default-color="#effeff" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
            </form>
        <?php } else { ?>
            <div class="row">
                <div class="col-lg-12">
                    <table class="wp-list-table widefat fixed striped posts">
                        <thead>
                            <tr> 
                                <th><?php _e('Title', 'smart-menupad'); ?></th>                 
                                <th><?php _e('Shortcode', 'smart-menupad'); ?></th>                               
                                <th><?php _e('Date', 'smart-menupad'); ?></th>             
                                <th class="text-center"><?php _e('Action', 'smart-menupad'); ?></th>             
                            </tr> 
                        </thead> 
                        <tbody id="the-list">
                            <?php
                                if(count($all_shortcode_data) > 0) {
                                    foreach ($all_shortcode_data as $key => $value) {       
                                        if(!empty($value->time)){
                                                $title = $value->title;
                                                $id = $value->id;
                                                $time = strtotime($value->time);          
                                            ?>
                                            <tr>                 
                                                <td><?=$title?></td>                 
                                                <td>[smart_menupad id=<?=$id?>]</td>                               
                                                <td><?=date("Y-m-d", $time)?></td>             
                                                <td class="text-center"><a href="<?php echo $this->smp_admin_url('smp-shortcode'); ?>&quickmenuid=<?=$id?>"><?php _e('Edit', 'smart-menupad'); ?></a></td>
                                            </tr>
                                        <?php
                                        }
                                    }
                                } else { ?>
                                    <tr><td colspan="4"><?php _e('No Shortcodes created yet. Click Add New to create your Menu Shortcode.'); ?></td></tr>
                                <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php } ?>
    </section>
</div>