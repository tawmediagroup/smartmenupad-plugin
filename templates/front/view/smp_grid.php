<?php 
if($layout_column == 2){
	$classcolmd = "col-lg-6";
} else if($layout_column == 3) {
	$classcolmd = "col-lg-4";
} else {
	$classcolmd = "col-lg-3";
}

//Text Colors
$heading_color = !empty($one_shortcode_data->heading_color)?$one_shortcode_data->heading_color:$heading_color;
$description_color = !empty($one_shortcode_data->description_color)?$one_shortcode_data->description_color:$description_color;
$price_color = !empty($one_shortcode_data->price_color)?$one_shortcode_data->price_color:$price_color;
//Button Colors
$button_bg_color = !empty($one_shortcode_data->button_bg_color)?$one_shortcode_data->button_bg_color:$button_bg_color;		
$button_bg_hover_color = !empty($one_shortcode_data->button_bg_hover_color)?$one_shortcode_data->button_bg_hover_color:$button_bg_hover_color;
$button_text_color = !empty($one_shortcode_data->button_text_color)?$one_shortcode_data->button_text_color:$button_text_color;		
$button_text_hover_color = !empty($one_shortcode_data->button_text_hover_color)?$one_shortcode_data->button_text_hover_color:$button_text_hover_color;
//Image Border
$image_border = $one_shortcode_data->image_border;
$image_border_array = array();
if(!empty($image_border)) {
	$image_border_array = explode(",", $image_border);
}
$top = empty($image_border_array[0])?10:$image_border_array[0];
$right = empty($image_border_array[1])?10:$image_border_array[1];
$bottom = empty($image_border_array[2])?10:$image_border_array[2];
$left = empty($image_border_array[3])?10:$image_border_array[3];

//Order Button Border
$button_border = $one_shortcode_data->button_border;
$button_border_array = array();
if(!empty($button_border)) {
	$button_border_array = explode(",", $button_border);
}
$btntop = empty($button_border_array[0])?10:$button_border_array[0];
$btnright = empty($button_border_array[1])?10:$button_border_array[1];
$btnbottom = empty($button_border_array[2])?10:$button_border_array[2];
$btnleft = empty($button_border_array[3])?10:$button_border_array[3];

$url = $one_shortcode_data->url;
$selected_menu = array();
if(!empty($url)){
	$selected_menu = explode(",", $url);
}
?> 

<style type="text/css">
    .dynamicclass {
        background-color: <?=$button_bg_color?> !important;
		color: <?=$button_text_color?> !important;
    }

    .dynamicclass:hover{
        background-color: <?=$button_bg_hover_color?> !important;
		color: <?=$button_text_hover_color?> !important;
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
            <div class="<?=$classcolmd?> <?=$atts['id']?> menu-item-col">
                <img style="border-radius: <?=$top?>px <?=$right?>px <?=$bottom?>px <?=$left?>px;" src="<?=$value["imagePath"]?>" alt="" title="<?=$value["name"]?>" class="menuItemImage" />
                <span style="color: <?=$price_color?>;" class="menu-item-price"> $<?=$value["finalPrice"]?></span>
                <h3 style="color: <?=$heading_color?>;"  class="menu-item-name"><?=$value["categoryName"]?></h3>
                <p style="color: <?=$description_color?>;" class="menu-item-des"><?=$value["name"]?></p>
                <a href="#" class="order-btn dynamicclass" style="border-radius: <?=$btntop?>px <?=$btnright?>px <?=$btnbottom?>px <?=$btnleft?>px;"  ><?php _e('Order Now', 'smart-menupad'); ?></a>
            </div>
        <?php } ?>
    </div>
</section>