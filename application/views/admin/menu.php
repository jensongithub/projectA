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
				$('#text_zh').val(holder.text_zh);
				$('#text_cn').val(holder.text_cn);
				$('#level').val(holder.level);			
			});

			$('#btnSubmit').click(function(){
				var cat_id = $('#cat_id').val();
				var text = $('#text').val();
				var text_zh = $('#text_zh').val();
				var text_cn = $('#text_cn').val();
				var level = $('#level').val();
				$.ajax({
					type: "POST",
					url: "/en/worker/update_menu",
					data: "cat_id=" + cat_id + "&text=" + text + "&text_zh=" + text_zh + "&text_cn=" + text_cn + "&level=" + level
				}).done(function( msg ) {
					$('#msg-panel').html("Update: " + msg);
					
					if( msg == "OK" ){
						$('#msg-panel').removeClass('error');
						$('#msg-panel').addClass('success');
						$('#msg-panel').show();
						setTimeout( function(){ $('#msg-panel').fadeOut(1200) }, 2000);
						holder.text = text;
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
			
			$("#t-menu > li").click(function(e){
				switch(e.target.id){
					case "t-en":
						//change status &amp;amp;amp; style menu
						$("#t-en").addClass("t-active");
						$("#t-zh").removeClass("t-active");
						$("#t-cn").removeClass("t-active");
						//display selected division, hide others
						$("#tab-en").fadeIn(200);
						$("#tab-zh").css("display", "none");
						$("#tab-cn").css("display", "none");
						$('#text').select();
						break;
					case "t-zh":
						//change status &amp;amp;amp; style menu
						$("#t-en").removeClass("t-active");
						$("#t-zh").addClass("t-active");
						$("#t-cn").removeClass("t-active");
						//display selected division, hide others
						$("#tab-zh").fadeIn(200);
						$("#tab-en").css("display", "none");
						$("#tab-cn").css("display", "none");
						$('#text_zh').select();
						break;
					case "t-cn":
						//change status &amp;amp;amp; style menu
						$("#t-en").removeClass("t-active");
						$("#t-zh").removeClass("t-active");
						$("#t-cn").addClass("t-active");
						//display selected division, hide others
						$("#tab-cn").fadeIn(200);
						$("#tab-en").css("display", "none");
						$("#tab-zh").css("display", "none");
						$('#text_cn').select();
						break;
				}
				//alert(e.target.id);
				return false;
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
		<p><?php echo _('Menu item') ?></p>
		<p><input id='cat_name' name='cat_name' readonly='readonly' size='50' /></p>	
		
		<p><label for='level'><?php echo _('Display level') ?></label></p>
		<p><input id='level' name='level' size='50' value='<?php if( validation_errors() != "" ) echo set_value('level'); ?>' /></p>
		
		<div id="tabs">
			<ul id='t-menu'>
				<li id='t-en' class='t-active'><?php echo _('English') ?></li>
				<li id='t-zh'><?php echo _('Trad. Chinese') ?></li>
				<li id='t-cn'><?php echo _('Simp. Chinese') ?></li>
			</ul>
			<div class='clear'></div>
			
			<div class='tab-content'>
				<div id="tab-en">
					<p><label for='text'><?php echo _('Display text') ?></label></p>
					<p><input id='text' name='text' size='50' value='' /></p>
				</div>
				<div id="tab-zh">
					<p><label for='text_zh'><?php echo _('Display text') ?></label></p>
					<p><input id='text_zh' name='text' size='50' value='' /></p>
				</div>
				<div id="tab-cn">
					<p><label for='text_cn'><?php echo _('Display text') ?></label></p>
					<p><input id='text_cn' name='text' size='50' value='' /></p>
				</div>
			</div>
		</div>
		
		<p><input id='btnSubmit' type='submit' value='<?php echo _('Submit') ?>' /></p>		
	</form>
</div>