<?php 
if($layout_column == 2){
	$classcolmd = "col-lg-6";
} else if($layout_column == 3) {
	$classcolmd = "col-lg-4";
} else {
	$classcolmd = "col-lg-3";
}

//Text Colors
$heading_color = !empty($one_shortcode_data->heading_color)?$one_shortcode_data->heading_color:$this->heading_color;
$description_color = !empty($one_shortcode_data->description_color)?$one_shortcode_data->description_color:$this->description_color;
$price_color = !empty($one_shortcode_data->price_color)?$one_shortcode_data->price_color:$this->price_color;
//Button Colors
$button_bg_color = !empty($one_shortcode_data->button_bg_color)?$one_shortcode_data->button_bg_color:$this->button_bg_color;		

$button_bg_hover_color = !empty($one_shortcode_data->button_bg_hover_color)?$one_shortcode_data->button_bg_hover_color:$this->button_bg_hover_color;
$button_text_color = !empty($one_shortcode_data->button_text_color)?$one_shortcode_data->button_text_color:$this->button_text_color;		
$button_text_hover_color = !empty($one_shortcode_data->button_text_hover_color)?$one_shortcode_data->button_text_hover_color:$this->button_text_hover_color;
//Image Border
$image_border = $one_shortcode_data->image_border;
$image_border_array = array();
if(!empty($image_border)) {
	$image_border_array = explode(",", $image_border);
}
$top = $image_border_array[0]==''?10:$image_border_array[0];
$right = $image_border_array[1]==''?10:$image_border_array[1];
$bottom = $image_border_array[2]==''?10:$image_border_array[2];
$left = $image_border_array[3]==''?10:$image_border_array[3];

//Order Button Border
$button_border = $one_shortcode_data->button_border;
$button_border_array = array();
if(!empty($button_border)) {
	$button_border_array = explode(",", $button_border);
}
$btntop = $button_border_array[0]==''?10:$button_border_array[0];
$btnright = $button_border_array[1]==''?10:$button_border_array[1];
$btnbottom = $button_border_array[2]==''?10:$button_border_array[2];
$btnleft = $button_border_array[3]==''?10:$button_border_array[3];

$url = $one_shortcode_data->url;
$selected_menu = array();
if(!empty($url)){
	$selected_menu = explode(",", $url);
}
$show_order_now = $one_shortcode_data->show_order_now ?? '0';	

?> 

<style type="text/css">
    .dynamicclass<?php echo $one_shortcode_data->id; ?> {
        background-color: <?php echo esc_attr($button_bg_color); ?> !important;
		color: <?php echo esc_attr($button_text_color); ?> !important;
    }

    .dynamicclass<?php echo $one_shortcode_data->id; ?>:hover{
        background-color: <?php echo esc_attr($button_bg_hover_color); ?> !important;
		color: <?php echo esc_attr($button_text_hover_color); ?> !important;
    }

</style>

<section class="container-fluid">     
    <div class="row">
        <?php            
            foreach ($smp_allmenu as $key => $value) {                       
                if(!in_array($value['id'], $selected_menu)) {
                    continue;
                }
            ?>
            <div class="<?php echo esc_attr($classcolmd); ?> <?php echo esc_attr($atts['id']); ?> menu-item-col">
                 <img style="border-radius: <?php echo esc_attr($top); ?>px <?php echo esc_attr($right); ?>px <?php echo esc_attr($bottom); ?>px <?php echo esc_attr($left); ?>px;" src="<?php echo esc_url($value["imagePath"]); ?>" alt="" title="<?php echo esc_attr($value["name"]); ?>" class="menuItemImage"/>
                <span style="color: <?php echo esc_attr($price_color); ?>;" class="menu-item-price">$<?php echo esc_html($value["finalPrice"]); ?></span>
				<h3 style="color: <?php echo esc_attr($heading_color); ?>;"  class="menu-item-name"><?php echo esc_html($value["categoryName"]); ?></h3>
				<p style="color: <?php echo esc_attr($description_color); ?>;" class="menu-item-des"><?php echo esc_html($value["name"]); ?></p>
				<?php 
				 if($show_order_now != 1){
				?>
				<a href="#" class="order-btn dynamicclass<?php echo $one_shortcode_data->id; ?>" style="border-radius: <?php echo esc_attr($btntop); ?>px <?php echo esc_attr($btnright); ?>px <?php echo esc_attr($btnbottom); ?>px <?php echo esc_attr($btnleft); ?>px;"><?php _e('Order Now', 'smart-menupad'); ?></a>
				<?php
				 }
				 ?>
            </div>
        <?php } ?>
    </div>
</section>