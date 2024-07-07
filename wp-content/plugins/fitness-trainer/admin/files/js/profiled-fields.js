"use strict";
var ajaxurl = profilefields.ajaxurl;
var loader_image = profilefields.loading_image;

	function update_profile_fields(){
		jQuery('#success_fields1').html(loader_image);
		var search_params = {
			"action": 		"ep_fitness_update_profile_fields",
			"form_data":	jQuery("#profile_fields").serialize(),
			"_wpnonce"		:  	profilefields.settings,
		};
		jQuery.ajax({
			url: ajaxurl,
			dataType: "json",
			type: "post",
			data: search_params,
			success: function(response) {
				jQuery('#success_fields1').html('<div class="alert alert-info alert-dismissable"><a class="panel-close close" data-dismiss="alert">x</a>'+response.code +'.</div>');
					var url = profilefields.wp_ep_fitness_ADMINPATH+"admin.php?page=wp-ep_fitness-settings";
					jQuery(location).attr('href',url);
					
			}
		});
	}
	function iv_add_field_profilefields(){

	jQuery('#profilefields_div10').append('<div class="row form-group " id="profilefield_'+profilefields.i+'"><div class=" col-sm-4"> <input type="text" class="form-control" name="meta_name[]" id="meta_name[]" value="" placeholder="Enter User Meta Name "> </div>	<div  class=" col-sm-4"><input type="text" class="form-control" name="meta_label[]" id="meta_label[]" value="" placeholder="Enter User Meta Label"></div><div  class=" col-sm-1"><label> </label></div> <div  class="checkbox col-sm-1"><label></label></div> <div  class=" checkbox col-sm-2"><button class="btn btn-danger btn-xs" onclick="return iv_remove_field('+i+');">Delete</button>');


		i=i+1;
	}
	function iv_remove_field(div_id){
		jQuery("#profilefield_"+div_id).remove();
	}


	function iv_add_menu(){

	jQuery('#custom_menu_div').append('<div class="row form-group " id="menu_'+profilefields.ii+'"><div class=" col-sm-3"> <input type="text" class="form-control" name="menu_title[]" id="menu_title[]" value="" placeholder="Enter Menu Title "> </div>	<div  class=" col-sm-7"><input type="text" class="form-control" name="menu_link[]" id="menu_link[]" value="" placeholder="Enter Menu Link.  Example  http://www.google.com"></div><div  class=" col-sm-2"><button class="btn btn-danger btn-xs" onclick="return iv_remove_menu('+profilefields.ii+');">Delete</button>');

		ii=ii+1;
	}
	function iv_remove_menu(div_id){

		jQuery("#menu_"+div_id).remove();
	}
