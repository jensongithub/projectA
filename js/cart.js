var shop_cart = {
	/*list:[],*/
	add_cart_url:'',
	del_cart_url:'',
	payment_url:'',
	item_count:0,
	item: function() { this.id=''; this.name=''; this.color=''; this.price=''; this.quantity=''; this.size=''; this.filepath=''; },
	save: function(each_item){
		
		$.ajax({
			type: "POST",
			 url: shop_cart.add_cart_url,
			data: "item="+encodeURIComponent($.toJSON(each_item)),
			dataType: "text",
			success: function (data, textStatus, jqXHR) {
				var obj = jQuery.parseJSON(jqXHR.responseText);
				/*if (obj.cart_item!=''){
					shop_cart.list.push(obj.cart_item);
				}*/
				var cart_val = "("+obj.item_count+")";
				if (obj.item_count==0){ cart_val = ""; }
				shop_cart.item_count = obj.item_count;
				$('span[class=item_count]').html(cart_val);
			},
			error:function(xhr,err){ alert("Please try again later or contact info@casimira.com.hk.");},
			async:false
		});
	},
	remove: function(each_item, item_id){
		$.ajax({
			type: "POST",
			url: shop_cart.del_cart_url,
			data: "item="+$.toJSON(each_item)+"&id="+item_id,
			dataType: "text",
			success: function (data, textStatus, jqXHR) {
				var obj = jQuery.parseJSON(jqXHR.responseText);
				/*if (obj.cart_item!=''){
					shop_cart.list.splice(obj.cart_item,1);
				}*/
				var cart_val = "("+obj.item_count+")";
				if (obj.item_count==0){ cart_val = ""; }
				shop_cart.item_count = obj.item_count;
				$('span[class=item_count]').html(cart_val);
			},
			error:function(xhr,err){ alert("Please try again later or contact info@casimira.com.hk.");},
			async:false
		});
	},
	cur_item:[],
	add_rows:0,
	add_item: function(){
		shop_cart.cur_item.id=$(this).attr('val');
		shop_cart.cur_item.quantity=$('input[class=item_quantity]').val();
		if (shop_cart.cur_item.size==''){
			alert("Please enter size");
			return false;
		}else if (shop_cart.cur_item.color==''){ 
			alert("Please enter color");
			return false;
		}else if (shop_cart.cur_item.quantity==''){
			alert("Please enter quantity");
			return false;
		}else{
			shop_cart.save(shop_cart.cur_item);
			shop_cart.cur_item = new shop_cart.item;
			shop_cart.add_rows=1;
		}
		return true;
	},
	del_item: function(){
		shop_cart.remove($(this).attr("value"));
	},
	payment_gateway: function(){
		$.ajax({
			type: "POST",
			 url: shop_cart.payment_url,
			data: "pg="+shop_cart.pg,
			dataType: "text",
			success: function (data, textStatus, jqXHR) {
				
				if (jqXHR.responseText!=="200"){
					$('.modal').children().remove();
					$('.modal').css({"display":"block"});
					$('.modal').append(jqXHR.responseText);
					//$('form[name=order_form]').submit();
				}else if (jqXHR.responseText=="200"){
					/*
					$('.modal').css({"display":"none"});
					$('.modal').remove(":first-child");
					*/
				}
			},
			error:function(xhr,err){ alert(err+"Please try again later or contact info@casimira.com.hk."); },
			async:false
		});
	}
};

function checkout(pg){
	
	shop_cart.item_count = $("input[name=cl]").val();
	if (shop_cart.item_count>0){
		shop_cart.pg=pg;
		shop_cart.payment_gateway();
	}
	
	//var lobj = check_login();
	//if (lobj.code=="200"){
	//shop_cart.item_count = $("input[name=cl]").val();

	
	//}
}


