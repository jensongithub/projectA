<?php echo js('jquery-validation-1.9.0/jquery.validate.min.js'); ?>
<?php echo css('css/admin/menu.css') ?>

<div id='menu-list-panel'>
	<h3><a href='<?php echo site_url( uri_string() ) ?>' class='refresh'><?php echo _('Refresh the list') ?></a></h4>
	
	<select id='menu-list' size='10'></select>
	
	<h3><?php echo _('Preview') ?></h3>
	<div id='menu-preview'></div>
	
	<script type='text/javascript'>
		var menu = <?php echo $page['menu_json']?>;
		var holder;
		var holderKey;
		
		function createMenuList(){
			var i = 1;
			while( menu['mi' + i] != undefined ){
				var item = menu['mi' + i];
				if(item.level == '' || item.level == null){
					$('#menu-list').append("<option id='cat" + item.id + "' value='" + i + "' class='inactive'>" + item['name'] + "</option>");
				}
				else{
					$('#menu-list').append("<option value='" + i + "'>" + item['name'] + "</option>");
					$('#menu-preview').append("<div class='level-" + (item.level.split(".").length - 1) +"'>" + item.text_en + "</div>");
				}
				i++;
			}
		}

		$(document).ready(function(){
			createMenuList();
			
			$('#menu-list').change(function(){
				holderKey = 'mi' + $(this).find("option:selected").val();
				holder = menu[holderKey];
				$('#cat_id').val(holder.id);
				$('#cat_name').val(holder.name);
				$('#text_en').val(holder.text_en);
				$('#text_zh').val(holder.text_zh);
				$('#text_cn').val(holder.text_cn);
				$('#level').val(holder.level);			
			});

			$('#btnSubmit').click(function(){
				var cat_id = $('#cat_id').val();
				var text_en = $('#text_en').val();
				var text_zh = $('#text_zh').val();
				var text_cn = $('#text_cn').val();
				var level = $('#level').val();
				$.ajax({
					type: "POST",
					url: "/en/worker/update_menu",
					data: "cat_id=" + cat_id + "&text_en=" + encodeURIComponent(text_en) + "&text_zh=" + encodeURIComponent(text_zh) + "&text_cn=" + encodeURIComponent(text_cn) + "&level=" + level
				}).done(function( msg ) {
					$('#msg-panel').html("Update: " + msg);
					
					if( msg == "OK" ){
						$('#msg-panel').removeClass('error');
						$('#msg-panel').addClass('success');
						$('#msg-panel').show();
						setTimeout( function(){ $('#msg-panel').fadeOut(1200) }, 2000);
						holder.text_en = text_en;
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
	<div id='msg-panel-holder'>
		<div id='msg-panel'></div>
	</div>
		
	<form id='menu-edit-form' action='edit_menu' method='post' class='form'>
		<input type='hidden' id='cat_id' name='cat_id' value='<?php echo set_value('cat_id'); ?>' />
		<h3>Edit menu item</h3>
		<div class='field'>
			<label class='label'><?php echo _('Menu item') ?></label>
			<input id='cat_name' name='cat_name' readonly='readonly' size='50' class='input' />
		</div>
		
		<div class='field'>
			<label for='level' class='label'><?php echo _('Display level') ?></label>
			<input id='level' name='level' size='50' value='<?php if( validation_errors() != "" ) echo set_value('level'); ?>' class='input' />
		</div>
		
		
		<div class='field'>
			<label for='text_en' class='label'><?php echo _('Display text') ?></label>
			<input id='text_en' name='text_en' size='50' value='' class='input' />
		</div>
		<div class='field'>
			<label for='text_zh' class='label'><?php echo _('Text (T.Chinese)') ?></label>
			<input id='text_zh' name='text' size='50' value='' class='input' />
		</div>
		<div class='field'>
			<label for='text_cn' class='label'><?php echo _('Text (S.Chinese)') ?></label>
			<input id='text_cn' name='text' size='50' value='' class='input' />
		</div>
			
		
		<p><input id='btnSubmit' type='submit' value='<?php echo _('Submit') ?>' class='submit-button' /></p>		
	</form>
</div>