
var shop_cart = {
	/*list:[],*/
	total:0,
	item: function() { this.id=''; this.name=''; this.color=''; this.price=''; this.quantity=''; this.size='';},
	save: function(each_item){
		$.ajax({
			type: "POST",
			url: "http://lna.localhost/zh/cart/add/",			
			data: "item="+$.toJSON(each_item),
			dataType: "text",
			success: function (data, textStatus, jqXHR) {
				var obj = jQuery.parseJSON(jqXHR.responseText);
				/*if (obj.cart_item!=''){
					shop_cart.list.push(obj.cart_item);
				}*/
				var cart_val = "("+obj.cart_counter+")";
				if (obj.cart_counter==0){ cart_val = ""; }
				shop_cart.total = obj.cart_counter;
				$('span[class=cart_counter]').html(cart_val);
			},
			error:function(xhr,err){ alert("Please try again later or contact info@casimira.com.hk.");},
			async:false
		});
	},
	remove: function(each_item, item_id){
		$.ajax({
			type: "POST",
			url: "http://lna.localhost/zh/cart/del/",			
			data: "item="+$.toJSON(each_item)+"&id="+item_id,
			dataType: "text",
			success: function (data, textStatus, jqXHR) {
				var obj = jQuery.parseJSON(jqXHR.responseText);
				/*if (obj.cart_item!=''){
					shop_cart.list.splice(obj.cart_item,1);
				}*/
				var cart_val = "("+obj.cart_counter+")";
				if (obj.cart_counter==0){ cart_val = ""; }
				shop_cart.total = obj.cart_counter;
				$('span[class=cart_counter]').html(cart_val);
				
			},
			error:function(xhr,err){ alert("Please try again later or contact info@casimira.com.hk.");},
			async:false
		});
	},
	cur_item:[],
	add_item: function(){		
		shop_cart.cur_item.id=$(this).attr('value');
		shop_cart.cur_item.quantity=$('input[class=item_quantity]').val();
		if (shop_cart.cur_item.size==''){ 
			alert("Please enter size");
		}else if (shop_cart.cur_item.color==''){ 
			alert("Please enter color");
		}else if (shop_cart.cur_item.quantity==''){
			alert("Please enter quantity");
		}else{
			//shop_cart.list.push(_item);
			shop_cart.save(shop_cart.cur_item);
			shop_cart.cur_item = new shop_cart.item;
		}
	},
	del_item: function(){
		shop_cart.remove($(this).attr("value"));
	},
	payment_gateway: function(){
		$.ajax({
			type: "POST",
			url: "http://lna.localhost/zh/checkout/payment/",
			data: "pg="+$("input[name=pg]").val(),
			dataType: "text",
			success: function (data, textStatus, jqXHR) {
				//var obj = jQuery.parseJSON(jqXHR.responseText);
				$('div[class=payment_gateway]').append(jqXHR.responseText);
				$('form[name=order_form]').submit();
			},
			error:function(xhr,err){ alert("Please try again later or contact info@casimira.com.hk.");},
			async:false
		});
	}
};