<script type='text/javascript' src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<?php echo js('jquery-validation-1.9.0/jquery.validate.min.js'); ?>
<?php echo css('css/admin/menu.css') ?>

<div id='menu-list-panel'>
	<h3><a href='<?php echo site_url( uri_string() ) ?>' class='refresh'><?php echo _('Refresh the list') ?></a></h4>
	
	<select id='menu-list' size='10'></select>
	
	<h3><?php echo _('Preview') ?></h3>
	<div id='menu-preview'></div>
	
	<script type='text/javascript'>
		var menu = <?php echo $menu_json ?>;
		var holder;
		
		function createMenuList(){
			var i = 1;
			while( menu['mi' + i] != undefined ){
				var item = menu['mi' + i];
				if(item.level == '' || item.level == null){
					$('#menu-list').append("<option id='cat" + item.id + "' value='" + i + "' class='inactive'>" + item['name'] + "</option>");
				}
				else{
					$('#menu-list').append("<option value='" + i + "'>" + item['name'] + "</option>");
					$('#menu-preview').append("<div class='level-" + (item.level.split(".").length - 1) +"'>" + item.text + "</div>");
				}
				i++;
			}
		}

		$(document).ready(function(){
			createMenuList();
			
			$('#menu-list').change(function(){				
				holder = menu['mi' + $(this).find("option:selected").val()];
				$('#cat_id').val(holder.id);
				$('#cat_name').val(holder.name);
				$('#text').val(holder.text);
				$('#path').val(holder.path);
				$('#level').val(holder.level);			
			});

			$('#btnSubmit').click(function(){
				var cat_id = $('#cat_id').val();
				var text = $('#text').val();
				var path = $('#path').val();
				var level = $('#level').val();
				$.ajax({
					type: "POST",
					url: "/en/worker/update_menu",
					data: "cat_id=" + cat_id + "&text=" + text + "&path=" + path + "&level=" + level
				}).done(function( msg ) {
					$('#msg-panel').html("Update: " + msg);
					
					if( msg == "OK" ){
						$('#msg-panel').removeClass('error');
						$('#msg-panel').addClass('success');
						$('#msg-panel').show();
						setTimeout( function(){ $('#msg-panel').fadeOut(1200) }, 2000);
						holder.text = text;
						holder.path = path;
						holder.level = level;
						if( level != '' )
							$('#cat' + cat_id).removeClass('inactive');
						else
							$('#cat' + cat_id).addClass('inactive');
					}
					else{
						$('#msg-panel').removeClass('success');
						$('#msg-panel').addClass('error');
						$('#msg-panel').show();
						setTimeout( function(){ $('#msg-panel').fadeOut(1200) }, 2000);
					}
				});
				return false;
			});
			
			$('#menu-preview').scroll(function(event){
				event.stopPropagation();
				event.stopImmediatePropagation();
			});
		});
		
	</script>
</div>

<div id='forms-panel'>
	<div id='msg-panel'></div>
		
	<form id='menu-edit-form' action='edit_menu' method='post' class='form'>
		<input type='hidden' id='cat_id' name='cat_id' value='<?php echo set_value('cat_id'); ?>' />
		<h3>Edit menu item</h3>
		<p><?php echo _('Menu item') ?></p>
		<p><input id='cat_name' name='cat_name' readonly='readonly' size='50' /></p>
		<p><label for='text'><?php echo _('Display text') ?></label></p>
		<p><input id='text' name='text' size='50' value='<?php if( validation_errors() != "" ) echo set_value('text'); ?>' /></p>
		<p><label for='path'><?php echo _('Path to the photo folder') ?></label></p>
		<p><input id='path' name='path' size='50' value='<?php if( validation_errors() != "" ) echo set_value('path'); ?>' /></p>
		<p><label for='level'><?php echo _('Display level') ?></label></p>
		<p><input id='level' name='level' size='50' value='<?php if( validation_errors() != "" ) echo set_value('level'); ?>' /></p>
		<p><input id='btnSubmit' type='submit' value='<?php echo _('Submit') ?>' /></p>
	</form>
</div>