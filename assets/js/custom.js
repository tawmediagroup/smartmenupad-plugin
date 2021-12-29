jQuery("#layout_view").on('change',function(){
	if(jQuery(this).val() ==  2) {
		jQuery("#layout_column_hide").hide();
	} else {
		jQuery("#layout_column_hide").show();
	}
});

function get_query() {
    var url = document.location.href;
    var qs = url.substring(url.indexOf('?') + 1).split('&');
    for(var i = 0, result = {}; i < qs.length; i++){
        qs[i] = qs[i].split('=');
        result[qs[i][0]] = decodeURIComponent(qs[i][1]);
    }
    return result;
}

jQuery(document).ready(function($){
    $('.price_color').wpColorPicker();
    $('.description_color').wpColorPicker();
    $('.heading_color').wpColorPicker();    
    var result = get_query();
   
    if(result["page"] == "smp-connect") {
        $('#toplevel_page_smp_get_menu_list_slug li.wp-first-item').addClass('current');
    }
});

function smplogout() {
	if (confirm("Note: If you Logout, your previous Synced Menus/ Or Saved ShortCodes will be Removed. \n Do you want to continue ?") == true) {
		var data = {
			'action': 'smp_logout'
		};

		jQuery.post(ajaxurl, data, function(response) {
			var result = JSON.parse(response);
			if(result.status == 'SUCCESS') {					
				window.location = result.redirect;
			}
			return true;
		}); 	
	
	} else {
		return false;
	}
	
}


function updatemenu() {
	jQuery('.sync').find('span').text('');
	jQuery('.sync-spinner').show();
	
	var data = {
		action: 'update_menu'                    
	};
	jQuery.get(ajaxurl, data, function(response) {
		var result = JSON.parse(response);
		jQuery('.sync-spinner').hide();
		if(result.status == 'ERROR') {
			jQuery('.sync').find('span').text('Sync Now');
			alert(result.message);
		} else {
			jQuery('.sync').find('span').text('Synced');
			window.location.reload();
		}
	});  
}

function hideloader() {   
    if(jQuery('#usernamesmpid').val() == "" || jQuery('#passsmpid').val() == "" ){
        jQuery('#loadingid').hide();
    }
}
setTimeout(hideloader, 900);

function filterProducts(ele, catid){
	if(jQuery(ele).is(':checked')) {
		jQuery("[class*='menu_"+catid+"']").show();
	} 
	else {		
		jQuery("[class*='menu_"+catid+"']").hide();
	}
}

function menuitems(ele){
	if (jQuery(ele).is(":checked")) {
		jQuery(ele).closest('.marginBottom').detach().appendTo('.selected_menu');
	} else {
		jQuery(ele).closest('.marginBottom').detach().appendTo('.menu_list');
	}
}

function viewMoreMenuInfo(id) {
	jQuery('#viewMore').modal('show');
	var result = JSON.parse(menuItemsJSON);
	jQuery('.menuItemImagebg').css('background-image','url("'+result[id].imagePath+'")');
	jQuery('.nameInfo').html('<span>$'+result[id].finalPrice+'</span><h3>'+result[id].name+'</h3><p>'+result[id].description+'</p>');
	jQuery('.addonChoices, .multipleSizes').html('');
	if(result[id].isAddOnsChoices) {
		var menuChoices = result[id].menuAddOnsChoicesList;
		var choicesHTML = '';
		jQuery.each( menuChoices, function(key,choice){
			choicesHTML += '<h4>'+choice.title+'</h4>';
			var choiceOptions = choice.addOnChoiceItems;
			jQuery.each(choiceOptions, function(k, value){
				choicesHTML += '<div class="choiceRow"><p>'+value.name+'</p><p>$'+value.price+'</p></div>';
			});
		});
		
		jQuery('.addonChoices').html(choicesHTML);
	}
	if(result[id].isMultipleSize) {
		var sizesHTML = '<h4>Sizes</h4>';
		var multipleSizes = result[id].menuMultipleSizesList;
		console.log(multipleSizes);
		jQuery.each( multipleSizes, function(key, value){
			sizesHTML += '<div class="choiceRow"><p>'+value.name+'</p><p>$'+value.price+'</p></div>';
		});
		jQuery('.multipleSizes').html(sizesHTML);
	}
	return false;		
}
