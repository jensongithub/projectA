<?php echo css('css/login.css') ?>
<div id="content" class='container' style="margin-top:10em;">
	<div class="content expando" name="modal_content">		
		<div class='section-header'><?php echo T_("Sign In / Create Account");?></div>
		<div class='error-panel' style="display:none;" ></div>
		<div class='left-block'>
			<div class='header'><?php echo _("Existing Customers");?></div>
			<form method="POST" name='login_form' action="<?php echo $page['login_url']; ?>">
				<div class='field'>
					<label for='email' class='label'><?php echo T_("Email");?></label><input type='text' id='email' name='email' value='<?php echo set_value('email'); ?>' class='input' />
				</div>
				<div class='field'>
					<label for='pwd' class='label'><?php echo T_("Password");?></label><input type='password' id='pwd' name='pwd' class='input' />
				</div>
				<div><input type='button'  class='submit-button'  onclick="check_login();" value='<?php echo T_("Submit");?>' /></div>
				<div class='forgot-pwd'><a href='account/forgotten'><?php echo T_("Forgotten Password");?></a></div>
				
			</form>
		</div>
		<div class='right-block'>
			<div class='header'><?php echo T_("New Customer") ?></div>
			<p><?php echo T_("Creating an account provides you with convenient features, including:");?>
				<ul>
					<li>› <?php echo T_("Quick checkout");?></li>
					<li>› <?php echo T_("View and track orders");?></li>
					<li>› <?php echo T_("Add to wish list");?></li>
					<li>› <?php echo T_("Save multiple shipping addresses");?></li>
					<li>› <?php echo T_("Advance notice on latest promotions");?></li>
				</ul>
				<a class='reg-btn' href='register'><?php echo T_("Register");?></a>
			</p>
		</div>
	</div>
</div>
<script>
function check_login(){
	var lobj = {};
	$.ajax({
			type: "POST",
			url: "<?php echo $page['login_url']?>",
			data: "email="+encodeURIComponent($("input[name=email]").val())+"&pwd="+encodeURIComponent($("input[name=pwd]").val())+"&cli=js",
			dataType: "text",
			success: function (data, textStatus, jqXHR) {
				
				if (jqXHR.responseText=="200"){
					login_callback();
				}else if (jqXHR.responseText==="-1"){
					// login failed
					$("div[class=error-panel]").children().remove();
					$("div[class=error-panel]").css({"display":"block"});
					$("div[class=error-panel]").append("<div>Login Failed. Please try again.</div>");					
					
				}else{
					//$('.modal').children("div:first-child").remove();
					$('.modal').children().remove();
					$('.modal').css({"display":"block"});
					$('.modal').append(jqXHR.responseText);
				}
				//lobj = jQuery.parseJSON(jqXHR.responseText);
			},
			error:function(xhr,err){ alert(err+"Please try again later or contact info@casimira.com.hk."); },
			async:false
		});
}
function login_callback(){ 
$('.modal').children().remove();
//$('.modal').append("<div id='content' class='container' style='margin-top:10em;'><div class='content expando'><div>We are directing you to Paypal. Please do not close the browser.</div></div></div>");
shop_cart.payment_gateway();
};  

</script>