<?php echo css('css/login.css') ?>
<div id="content" class='container' style="margin-top:10em;">
	<div class="content expando" name="modal_content">		
		<div class='section-header'><?php echo _("Sign In / Create Account");?></div>
		<div class='error-panel' style="display:none;" ></div>
		<div class='left-block'>
			<div class='header'><?php echo _("Existing Customers");?></div>
			<form method="POST" name='login_form' action="<?php echo $page['login_url']; ?>">
				<div class='row'>
					<label><?php echo _("Email");?></label><input type='text' name='email' value='<?php echo set_value('email'); ?>'/>
				</div>
				<div class='row'>
					<label><?php echo _("Password");?></label><input type='password' name='pwd' />
				</div>
				<div><a href='account/forgotten'><?php echo _("Forgotten Password");?></a></div>
				<div><input type='button' onclick="check_login();" value='Submit' /><input type='button' value='Reset' /></div>
			</form>
		</div>
		<div class='right-block'>
			<div class='header'><?php echo _("New Customer");?></div>
			<p><?php echo _("Creating an account provides you with convenient features, including:");?></p>
				<ul>
					<li>? <?php echo _("Quick checkout");?></li>
					<li>? <?php echo _("View and track orders");?></li>
					<li>? <?php echo _("Add to wish list");?></li>
					<li>? <?php echo _("Save multiple shipping addresses");?></li>
					<li>? <?php echo _("Advance notice on latest promotions");?></li>
				</ul>
				<center><a class='reg-btn' href='register' target="_new"><?php echo _("Register");?></a></center>
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