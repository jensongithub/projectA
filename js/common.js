function check_login(){
	var lobj = {};
	$.ajax({
			type: "POST",
			url: "http://lna.localhost/zh/login/require_login",
			data: "redirect="+encodeURIComponent(window.location)+"&cli=js",
			dataType: "json",
			success: function (data, textStatus, jqXHR) {
				lobj = jQuery.parseJSON(jqXHR.responseText);			
			},
			error:function(xhr,err){ alert(err+"Please try again later or contact info@casimira.com.hk."); },
			async:false
		});
	if (lobj.code =="-999") window.location.href=lobj.url;
	return lobj;
}