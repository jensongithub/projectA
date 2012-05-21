<?php echo css('css/login.css') ?>
<div id="content" class='container' style="margin-top:10em;">
	<div class="content expando" name="modal_content">		
		<div class='section-header'><?php echo T_("Shipping address");?></div>
		<div class='error-panel' style="display:none;" ></div>
		<div class=''>
			<div class='header'><?php echo T_("Please enter the delivery address or choose the address below.");?></div>
			<form method="POST" name='checkout/address' action="<?php echo $page['order_address_url']; ?>">
				
				<div class='field'>
					<label for='country' class='label'><?php echo T_("Country");?></label>
					<select name='country'>
						<option value="">Country*</option>
						<option value="AF" >Afghanistan</option>
						<option value="AL" >Albania</option>
						<option value="DZ" >Algeria</option>
						<option value="AD" >Andorra</option>

						<option value="AO" >Angola</option>
						<option value="AG" >Antigua and Barbuda</option>
						<option value="AR" >Argentina</option>
						<option value="AM" >Armenia</option>
						<option value="AU" >Australia</option>
						<option value="AT" >Austria</option>

						<option value="AZ" >Azerbaijan</option>
						<option value="BS" >Bahamas</option>
						<option value="BH" >Bahrain</option>
						<option value="BD" >Bangladesh</option>
						<option value="BB" >Barbados</option>
						<option value="BE" >Belgium</option>

						<option value="BO" >Bolivia</option>
						<option value="BA" >Bosnia and Herzegovina</option>
						<option value="BR" >Brazil</option>
						<option value="IO" >British Indian Ocean Territory</option>
						<option value="BN" >Brunei</option>
						<option value="BG" >Bulgaria</option>

						<option value="CA" >Canada</option>
						<option value="TD" >Chad</option>
						<option value="CL" >Chile</option>
						<option value="CN" >China</option>
						<option value="CC" >Cocos</option>
						<option value="CO" >Colombia</option>

						<option value="CK" >Cook Islands</option>
						<option value="CR" >Costa Rica</option>
						<option value="HR" >Croatia</option>
						<option value="CU" >Cuba</option>
						<option value="CY" >Cyprus</option>
						<option value="CZ" >Czech Republic</option>

						<option value="DK" >Denmark</option>
						<option value="DO" >Dominican Republic</option>
						<option value="EC" >Ecuador</option>
						<option value="EG" >Egypt</option>
						<option value="SV" >El Salvador</option>
						<option value="EE" >Estonia</option>

						<option value="FK" >Falkland Islands</option>
						<option value="FI" >Finland</option>
						<option value="FR" >France</option>
						<option value="DE" >Germany</option>
						<option value="GH" >Ghana</option>
						<option value="GI" >Gibraltar</option>

						<option value="GR" >Greece</option>
						<option value="GP" >Guadeloupe</option>
						<option value="GT" >Guatemala</option>
						<option value="GG" >Guernsey</option>
						<option value="HT" >Haiti</option>
						<option value="HN" >Honduras</option>

						<option value="HK" >Hong Kong SAR</option>
						<option value="HU" >Hungary</option>
						<option value="IS" >Iceland</option>
						<option value="IN" >India</option>
						<option value="IR" >Iran</option>
						<option value="IQ" >Iraq</option>

						<option value="IE" >Ireland</option>
						<option value="IM" >Isle of Man</option>
						<option value="IL" >Israel</option>
						<option value="IT" >Italy</option>
						<option value="JM" >Jamaica</option>
						<option value="JP" >Japan</option>

						<option value="JE" >Jersey</option>
						<option value="JO" >Jordan</option>
						<option value="KE" >Kenya</option>
						<option value="KI" >Kiribati</option>
						<option value="KR" >Korea</option>
						<option value="KW" >Kuwait</option>

						<option value="LA" >Laos</option>
						<option value="LB" >Lebanon</option>
						<option value="LR" >Liberia</option>
						<option value="LU" >Luxembourg</option>
						<option value="MO" >Macao SAR</option>
						<option value="MK" >Macedonia, Former Yugoslav Republic of</option>

						<option value="MG" >Madagascar</option>
						<option value="MY" >Malaysia</option>
						<option value="MT" >Malta</option>
						<option value="MQ" >Martinique</option>
						<option value="MU" >Mauritius</option>
						<option value="MX" >Mexico</option>

						<option value="ME" >Montenegro</option>
						<option value="MA" >Morocco</option>
						<option value="NP" >Nepal</option>
						<option value="NL" >Netherlands</option>
						<option value="AN" >Netherlands Antilles</option>
						<option value="NZ" >New Zealand</option>

						<option value="NI" >Nicaragua</option>
						<option value="NG" >Nigeria</option>
						<option value="NO" >Norway</option>
						<option value="OM" >Oman</option>
						<option value="PK" >Pakistan</option>
						<option value="PS" >Palestinian Authority</option>

						<option value="PA" >Panama</option>
						<option value="PY" >Paraguay</option>
						<option value="PE" >Peru</option>
						<option value="PH" >Philippines</option>
						<option value="PL" >Poland</option>
						<option value="PT" >Portugal</option>

						<option value="QA" >Qatar</option>
						<option value="CI" >Republic of C</option>
						<option value="RE" >Reunion</option>
						<option value="RO" >Romania</option>
						<option value="RU" >Russia</option>
						<option value="RW" >Rwanda</option>

						<option value="SA" >Saudi Arabia</option>
						<option value="SN" >Senegal</option>
						<option value="RS" >Serbia</option>
						<option value="SG" >Singapore</option>
						<option value="SK" >Slovakia</option>
						<option value="SI" >Slovenia</option>

						<option value="SO" >Somalia</option>
						<option value="ZA" >South Africa</option>
						<option value="ES" >Spain</option>
						<option value="LK" >Sri Lanka</option>
						<option value="SE" >Sweden</option>
						<option value="CH" >Switzerland</option>

						<option value="SY" >Syria</option>
						<option value="TW" >Taiwan</option>
						<option value="TH" >Thailand</option>
						<option value="TT" >Trinidad and Tobago</option>
						<option value="TN" >Tunisia</option>
						<option value="TR" >Turkey</option>

						<option value="UA" >Ukraine</option>
						<option value="AE" >United Arab Emirates</option>
						<option value="UK" >United Kingdom</option>
						<option value="US" >United States</option>
						<option value="UM" >United States Minor Outlying Islands</option>
						<option value="UY" >Uruguay</option>

						<option value="VE" >Venezuela</option>
						<option value="VN" >Vietnam</option>
						<option value="YE" >Yemen</option>
						<option value="ZW" >Zimbabwe</option>
						<option value="US" >United States</option>
					</select>
				</div>
				<div class='field'>
					<label for='address_zip' class='label'><?php echo T_("Address_zip");?></label><input type='text' id='address_zip' name='address_zip' value='<?php echo set_value('address_zip'); ?>' class='input' />
				</div>
				<div class='field'>
					<label for='address_state' class='label'><?php echo T_("Address_state");?></label><input type='text' id='address_state' name='address_state' value='<?php echo set_value('address_state'); ?>' class='input' />
				</div>
				<div class='field'>
					<label for='address_city' class='label'><?php echo T_("Address_city");?></label><input type='text' id='address_city' name='address_city' value='<?php echo set_value('address_city'); ?>' class='input' />
				</div>
				<div class='field'>
					<label for='address_street' class='label'><?php echo T_("Address_street");?></label><input type='text' id='address_street' name='address_street' value='<?php echo set_value('address_street'); ?>' class='input' />
				</div>
				<div>
				
				<input type='button'  class='submit-button'  onclick="check_address();" value='<?php echo T_("Submit");?>' /></div>
			</form>
		</div>
	</div>
</div>
<script>
function check_address(){

	var lobj = {};
	var country = encodeURIComponent($("select[name=country] option:selected").text());
	var country_code = encodeURIComponent($("select[name=country] option:selected").val());
	var address_state = encodeURIComponent($("input[name=address_state]").val());
	var address_zip = encodeURIComponent($("input[name=address_zip]").val())
	var address_city = encodeURIComponent($("input[name=address_city]").val());
	var address_street = encodeURIComponent($("input[name=address_street]").val());
	var pg = encodeURIComponent($('input[name=pg]').val());
		$.ajax({
			type: "POST",
			url: "<?php echo $page['order_address_url']?>",
			data: "country="+country+"&country_code="+country_code+"&address_state="+address_state+"&address_zip="+address_zip+"&address_city="+address_city+"&address_street="+address_street+"&cli=js"+"&pg="+pg,
			dataType: "text",
			success: function (data, textStatus, jqXHR) {
				if (jqXHR.responseText=="200"){
					address_callback();
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
function address_callback(){ 
$('.modal').children().remove();
//$('.modal').append("<div id='content' class='container' style='margin-top:10em;'><div class='content expando'><div>We are directing you to Paypal. Please do not close the browser.</div></div></div>");
shop_cart.payment_gateway();
};  

</script>