/*!
 * The PayPal Mini Cart 
 * Visit https://minicart.paypal-labs.com/ for details
 * Use subject to license agreement as set forth at the link below
 * 
 * @author Jeff Harrell
 * @license https://github.com/jeffharrell/MiniCart/blob/master/LICENSE eBay Open Source License Agreement
 */
if (typeof PAYPAL == 'undefined' || !PAYPAL) {
	var PAYPAL = {};
}

PAYPAL.apps = PAYPAL.apps || {};


(function () {

	/**
	 * Default configuration
	 */
	var config = {			
		/**
		 * The parent element the cart should "pin" to
		 */
		parent: document.body,
		
		/**
		 * Edge of the window to pin the cart to
		 */
		displayEdge: 'right',
		
		/**
		 * Distance from the edge of the window
		 */
		edgeDistance: '50px',
		
		/**
		 * The base path of your website to set the cookie to
		 */		
		cookiePath: '/',
		
		/**
		 * Strings used for display text
		 */		
		strings: {
			button: '',
			subtotal: '',
			discount: '',
			shipping: ''
		},
		
		/**
		 * Unique ID used on the wrapper element
		 */		
		name: 'PPMiniCart',
		
		/**
		 * Boolean to determine if the cart should "peek" when it's hidden with items
		 */
		peekEnabled: true,

		/**
		 * The URL of the PayPal website
		 */
		paypalURL: 'https://www.paypal.com/cgi-bin/webscr',		
		
		/**
		 * The base URL to the visual assets
		 */		
		assetURL: 'http://www.minicartjs.com/build/',
		
		events: {
			/**
			 * Custom event fired before the cart is rendered
			 */
			onRender: null, 
					
			/**
			 * Custom event fired after the cart is rendered
			 */
			afterRender: null,
			
			/**
			 * Custom event fired before the cart is hidden
			 *
			 * @param e {event} The triggering event
			 */
			onHide: null,
			
			/**
			 * Custom event fired after the cart is hidden
			 *
			 * @param e {event} The triggering event
			 */
			afterHide: null,
			
			/**
			 * Custom event fired before the cart is shown
			 *
			 * @param e {event} The triggering event
			 */
			onShow: null,
			
			/**
			 * Custom event fired after the cart is shown
			 *
			 * @param e {event} The triggering event
			 */
			afterShow: null,
			
			/**
			 * Custom event fired before a product is added to the cart
			 *
			 * @param data {object} Product object
			 */
			onAddToCart: null,
			
			/**
			 * Custom event fired after a product is added to the cart
			 *
			 * @param data {object} Product object
			 */
			afterAddToCart: null,
			
			/**
			 * Custom event fired before a product is removed from the cart
			 *
			 * @param data {object} Product object
			 */
			onRemoveFromCart: null,
			
			/**
			 * Custom event fired after a product is removed from the cart
			 *
			 * @param data {object} Product object
			 */
			afterRemoveFromCart: null,
			
			/**
			 * Custom event fired before the checkout action takes place
			 *
			 * @param e {event} The triggering event
			 */
			onCheckout: null,
			
			/**
			 * Custom event fired before the cart is reset
			 */
			onReset: null,
			
			/**
			 * Custom event fired after the cart is reset
			 */
			afterReset: null
		}
	};



	/**
	 * Mini Cart application 
	 */
	PAYPAL.apps.MiniCart = (function () {
		
		var minicart = {},
			isShowing = false
		;
				
				
		/** PRIVATE **/
		
		
		/**
		 * Regex filter for product values, which appear multiple times in a cart
		 */
		var productFilter = /^(?:item_number|item_name|amount|quantity|on|os|option_|tax|weight|handling|shipping|discount)/;
		
		
		/**
		 * Regex filter for cart settings, which appear only once in a cart
		 */
		var settingFilter = /^(?:business|currency_code|lc|paymentaction|no_shipping|cn|no_note|invoice|handling_cart|weight_cart|weight_unit|tax_cart|page_style|image_url|cpp_|cs|cbt|return|cancel_return|notify_url|rm|custom|charset)/;
		
			
		/**
		 * Renders the cart to the page and sets up it's events
		 */
		var _render = function () {
			var events = config.events,
				onRender = events.onRender,
				afterRender = events.afterRender
			;
			
			if (typeof onRender == 'function') {
				onRender.call(minicart);
			}
			
			_addCSS();
			_buildDOM();
			_bindEvents();
			
			if (typeof afterRender == 'function') {
				afterRender.call(minicart);
			}
		};
		
		
		/**
		 * Adds the cart's CSS to the page
		 */
		var _addCSS = function () {
			var name = config.name,
				css = [],
				style, head
			;

			css.push('#' + name + ' form { position:fixed; float:none; top:-250px; ' + config.displayEdge + ':' + config.edgeDistance + '; width:265px; margin:0; padding:50px 10px 0; min-height:170px; background:#fff url(' + config.assetURL + 'images/minicart_sprite.png) no-repeat -125px -60px; border:1px solid #999; border-top:0; font:13px/normal arial, helvetica; color:#333; text-align:left; -moz-border-radius:0 0 8px 8px; -webkit-border-radius:0 0 8px 8px; border-radius:0 0 8px 8px; -moz-box-shadow:1px 1px 1px rgba(0, 0, 0, 0.1); -webkit-box-shadow:1px 1px 1px rgba(0, 0, 0, 0.1); box-shadow:1px 1px 1px rgba(0, 0, 0, 0.1); } ');
			css.push('#' + name + ' ul { position:relative; overflow-x:hidden; overflow-y:auto; height:130px; margin:0 0 7px; padding:0; list-style-type:none; border-top:1px solid #ccc; border-bottom:1px solid #ccc; } ');
			css.push('#' + name + ' li { position:relative; margin:-1px 0 0; padding:6px 5px 6px 0; border-top:1px solid #f2f2f2; } ');
			css.push('#' + name + ' li a { color:#333; text-decoration:none; } ');
			css.push('#' + name + ' li a span { color:#999; font-size:10px; } ');
			css.push('#' + name + ' li .quantity { position:absolute; top:.5em; right:78px; width:22px; padding:1px; border:1px solid #83a8cc; text-align:right; } ');
			css.push('#' + name + ' li .price { position:absolute; top:.5em; right:4px; } ');
			css.push('#' + name + ' li .remove { position:absolute; top:9px; right:60px; width:14px; height:14px; background:url(' + config.assetURL + 'images/minicart_sprite.png) no-repeat -134px -4px; border:0; cursor:pointer; } ');
			css.push('#' + name + ' p { margin:0; padding:0 0 0 20px; background:url(' + config.assetURL + 'images/minicart_sprite.png) no-repeat; font-size:13px; font-weight:bold; } ');
			css.push('#' + name + ' p:hover { cursor:pointer; } ');
			css.push('#' + name + ' p input { float:right; margin:4px 0 0; padding:1px 4px; text-decoration:none; font-weight:normal; color:#333; background:#ffa822 url(' + config.assetURL + 'images/minicart_sprite.png) repeat-x left center; border:1px solid #d5bd98; border-right-color:#935e0d; border-bottom-color:#935e0d; -moz-border-radius:2px; -webkit-border-radius:2px; border-radius:2px; } ');
			css.push('#' + name + ' p .shipping { display:block; font-size:10px; font-weight:normal; color:#999; } ');

			style = document.createElement('style');
			style.type = 'text/css';
			
			if (style.styleSheet) {
				style.styleSheet.cssText = css.join('');
			} else {
				style.appendChild(document.createTextNode(css.join('')));
			}

			head = document.getElementsByTagName('head')[0];
			head.appendChild(style);
		};
		
		
		/**
		 * Builds the DOM elements required by the cart
		 */
		var _buildDOM = function () {
			var UI = minicart.UI,
				cmd, type, bn, parent, version
			;
			
			UI.wrapper = document.createElement('div');
			UI.wrapper.id = config.name;
			
			cmd = document.createElement('input');
			cmd.type = 'hidden';
			cmd.name = 'cmd';
			cmd.value = '_cart';
			
			type = cmd.cloneNode(false);
			type.name = 'upload';
			type.value = '1';
			
			bn = cmd.cloneNode(false);
			bn.name = 'bn';
			bn.value = 'MiniCart_AddToCart_WPS_US';
			
			UI.cart = document.createElement('form');
			UI.cart.method = 'post';
			UI.cart.action = config.paypalURL;
			UI.cart.appendChild(cmd);
			UI.cart.appendChild(type);
			UI.cart.appendChild(bn);
			UI.wrapper.appendChild(UI.cart);
			
			UI.itemList = document.createElement('ul');
			UI.cart.appendChild(UI.itemList);
			
			UI.summary = document.createElement('p');
			UI.cart.appendChild(UI.summary);
			
			UI.button = document.createElement('input');
			UI.button.type = 'submit';
			UI.button.value = config.strings.button || 'Checkout';
			UI.summary.appendChild(UI.button);
			
			UI.subtotal = document.createElement('span');
			UI.subtotal.innerHTML = config.strings.subtotal || 'Subtotal: ';
	
			UI.subtotalAmount = document.createElement('span');
			UI.subtotalAmount.innerHTML = '0.00';
			
			UI.subtotal.appendChild(UI.subtotalAmount);
			UI.summary.appendChild(UI.subtotal);
			
			UI.shipping = document.createElement('span');
			UI.shipping.className = 'shipping';
			UI.shipping.innerHTML = config.strings.shipping || 'does not include shipping &amp; tax';
			UI.summary.appendChild(UI.shipping);
			
			// Workaround: IE 6 and IE 7/8 in quirks mode do not support position:fixed in CSS
			if (window.attachEvent && !window.opera) {
				version = navigator.userAgent.match(/MSIE\s([^;]*)/);
				
				if (version) {
					version = parseFloat(version[1]);
				
					if (version < 7 || (version >= 7 && document.compatMode === 'BackCompat')) {
						UI.cart.style.position = 'absolute';
						UI.wrapper.style[config.displayEdge] = '0';
						UI.wrapper.style.setExpression('top', 'x = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop');
					}
				}
			}
			
			parent = (typeof config.parent === 'string') ? document.getElementById(config.parent) : config.parent;		
			parent.appendChild(UI.wrapper);
		};
		
		
		/**
		 * Attaches the cart events to it's DOM elements
		 */
		var _bindEvents =function () {
			var forms, form, i;
			
			// Look for all "Cart" and "Buy Now" forms on the page and attach events
			forms = document.getElementsByTagName('form');

			for (i = 0; i < forms.length; i++) {
				form = forms[i];
				
				if (form.cmd && (form.cmd.value === '_cart' || form.cmd.value === '_xclick')) {
					minicart.bindForm(form);	
				}
			}
			
			// Hide the Mini Cart for all non-cart related clicks
			$.event.add(document, 'click', function (e) {
				if (isShowing) {
					var target = e.target;

					if (!(/input|button|select|option/i.test(target.tagName))) {
						while (target.nodeType === 1) {
							if (target === minicart.UI.cart) {
								return;
							}

							target = target.parentNode;
						}
						
						minicart.hide(null);
					}
				}
			});
			
			// Run the checkout code when submitting the form
			$.event.add(minicart.UI.cart, 'submit', function (e) {
				_checkout(e);
			});
			
			// Show the cart when clicking on the summary
			$.event.add(minicart.UI.summary, 'click', function (e) {
				var target = e.target;
				
				if (target !== minicart.UI.button) {
					minicart.toggle(e);
				}
			}); 

			// Update other windows when HTML5 localStorage is updated
			function redrawCartItems() {
				minicart.products = [];
				minicart.UI.itemList.innerHTML = '';
				minicart.UI.subtotalAmount.innerHTML = '';
		
				_parseStorage();
				minicart.updateSubtotal();
			}
			
			if (window.attachEvent && !window.opera) {
				$.event.add(document, 'storage', function (e) {
					// IE needs a delay in order to properly see the change
					setTimeout(redrawCartItems, 100);
				});			
			} else {
				$.event.add(window, 'storage', function (e) {
					// Safari, Chrome, and Opera can filter on updated storage key	
					// Firefox can't so it uses a brute force approach
					if ((e.key && e.key == config.name) || !e.key) {
						redrawCartItems();
					}
				});
			}
		};


		/**
		 * Loads the stored data and builds the cart
		 */
		var _parseStorage = function () {
			var data, length, i;
			
			if ((data = $.storage.load())) {
				length = data.length;
				
				for (i = 0; i < length; i++) {
					if (_renderProduct(data[i])) {
						isShowing = true;
					}
				}
			}
		};

		
		/**
		 * Data parser used for forms
		 *
		 * @param form {HTMLElement} An HTML form
		 * @return {object} 
		 */		
		var _parseForm = function (form) {
			var raw = form.elements,
				data = {},
				pair, value, length, i, len
			;
			
			for (i = 0, len = raw.length; i < len; i++) {
				pair = raw[i];
				
				if ((value = $.util.getInputValue(pair))) {
					data[pair.name] = value;
				}
			}
			
			return data;
		};
		
				
		/**
		 * Massage's a object's data in preparation for adding it to the user's cart
		 *
		 * @param data {object} An object of WPS xclick style data to add to the cart. The format is { product: '', settings: '' }.
		 * @return {object}
		 */
		var _parseData = function (data) {
			var product = {},
				settings = {},
				existing, option_index, key, len, match, i, j
			;
			
			// Parse the data into a two categories: product and settings
			for (key in data) {
				if (settingFilter.test(key)) {
					settings[key] = data[key];
				} else if (productFilter.test(key)) {
					product[key] = data[key];
				}
			}
			
			// Check the products to see if this variation already exists
			// If it does then reuse the same object
			for (i = 0, len = minicart.products.length; i < len; i++) {
				existing = minicart.products[i].product;
				
				// Do the product name and number match
				if (product.item_name === existing.item_name && product.item_number === existing.item_number) {
					// Products are a match so far; Now do all of the products options match?
					match = true;
					j = 0;
					
					while (existing['os' + j]) {
						if (product['os' + j] !== existing['os' + j]) {
							match = false;
							break;
						}
						
						j++;
					}
					
					if (match) {
						product.offset = existing.offset;
						break;
					}
				}
			}

			// Normalize the values
			product.href = product.href || window.location.href;
			product.quantity = product.quantity || 1;
			product.amount = product.amount || 0;
			
			// Add Mini Cart specific settings
			if (settings['return'] && settings['return'].indexOf('#') == -1) {
				settings['return'] += '#' + config.name + '=reset';
			}
			
			// Add option amounts to the total amount
			option_index = (product.option_index) ? product.option_index : 0;

			while (product['os' + option_index]) {
				i = 0;
				
				while (typeof product['option_select' + i] != 'undefined') {
					if (product['option_select' + i] == product['os' + option_index]) {
						product.amount = product.amount + parseFloat(product['option_amount' + i]);
						break;
					}
					
					i++;
				}
				
				option_index++;
			}
			
			return {
				product: product,
				settings: settings
			};
		};
		
		
		/**
		 * Renders the product in the cart
		 *
		 * @param data {object} The data for the product
		 */
		var _renderProduct = function (data) {
			var keyupTimer,
				product = new ProductNode(data, minicart.UI.itemList.children.length + 1),
				offset = data.product.offset,
				hiddenInput, key
			;
				
			minicart.products[offset] = product;
			
			// Add hidden settings data to parent form
			for (key in data.settings) {
				if (minicart.UI.cart.elements[key]) {
					if (minicart.UI.cart.elements[key].value) {
						minicart.UI.cart.elements[key].value = data.settings[key];
					} else {
						minicart.UI.cart.elements[key] = data.settings[key];
					}
				} else {
					hiddenInput = document.createElement('input');
					hiddenInput.type = 'hidden';
					hiddenInput.name = key;
					hiddenInput.value = data.settings[key];
			
					minicart.UI.cart.appendChild(hiddenInput);
				}
			}
			
			// if the product has no name or number then don't add it
			if (product.isPlaceholder) {
				return false;
			// otherwise, setup the new element
			} else {
				// Click event for "x"
				$.event.add(product.removeNode, 'click', function () {
					_removeProduct(product, offset);
				});
			
				// Event for changing quantities
				var currentValue = product.quantityNode.value;
				
				$.event.add(product.quantityNode, 'keyup', function () {
					var that = this;
					
					keyupTimer = setTimeout(function () {
						var value = parseInt(that.value, 10);
						
						if (!isNaN(value) && value != currentValue) {
							currentValue = value;
							
							product.setQuantity(value);

							// Delete the product
							if (!product.getQuantity()) {
								_removeProduct(product, offset);
							}

							minicart.updateSubtotal();
							$.storage.save(minicart.products);
						}
					}, 250);
				});
			
				// Add the item and fade it in
				minicart.UI.itemList.appendChild(product.liNode);
				$.util.animate(product.liNode, 'opacity', { from: 0, to: 1 });
				
				return true;	
			}
		};
		

		/**
		 * Removes a product from the cart
		 *
		 * @param product {ProductNode} The product object
		 * @param offset {Number} The offset for the product in the cart
		 */
		var _removeProduct = function (product, offset) {
			var events = config.events,
				onRemoveFromCart = events.onRemoveFromCart,
				afterRemoveFromCart = events.afterRemoveFromCart
			;
				
			if (typeof onRemoveFromCart == 'function') {
				onRemoveFromCart.call(minicart, product);
			}
			
			product.setQuantity(0);
			product.quantityNode.style.display = 'none';
		
			$.util.animate(product.liNode, 'opacity', { from: 1, to: 0 }, function () {
				$.util.animate(product.liNode, 'height', { from: 18, to: 0 }, function () {
					try {
						product.liNode.parentNode.removeChild(product.liNode);
					} catch (e) {
						// fail
					}
					
					// regenerate the form element indexes
					var products = minicart.UI.cart.getElementsByTagName('li'),
						products_len = products.length,
						inputs,
						inputs_len,
						input,
						matches,
						i, j, k = 1
					;
					
					for (i = 0 ; i < products_len; i++) {
						inputs = products[i].getElementsByTagName('input');
						inputs_len = inputs.length;
						
						for (j = 0; j < inputs_len; j++) {
							input = inputs[j];
							matches = /(.+)_[0-9]+$/.exec(input.name);
							
							if (matches && matches[1]) {
								input.name = matches[1] + '_' + k;
							}
						}
						
						k++;
					}
					
					if (typeof afterRemoveFromCart == 'function') {
						afterRemoveFromCart.call(minicart, product);
					}
				});
			});
		
			minicart.products[offset].product.item_name = '';
			minicart.products[offset].product.item_number = '';
		
			minicart.updateSubtotal();
			$.storage.save(minicart.products);
		};
		
		
		/**
		 * Event when the cart form is submitted
		 *
		 * @param e {event} The form submission event
		 */
		var _checkout = function (e) {
			var onCheckout = config.events.onCheckout;
			
			if (typeof onCheckout == 'function') {
				onCheckout.call(minicart, e);
			}
		};
		
		
		/** PUBLIC **/

		
		/**
		 * Array of ProductNode
		 */
		minicart.products = [];
		
		
		/**
		 * Container for UI elements
		 */
		minicart.UI = {};
		

		/**
		 * Renders the cart, creates the configuration and loads the data
		 *
		 * @param userConfig {object} User settings which override the default configuration
		 */
		minicart.render = function (userConfig) {
			var hash, cmd, key, i;
				
			// Overwrite default configuration with user settings
			for (key in userConfig) {
				if (config[key]) {
					config[key] = userConfig[key];
				}
			}

			// Render the cart UI
			_render();
		
			// Process any stored data
			_parseStorage();
						
			// Check if a transaction was completed
			hash = location.hash.substring(1);
			
			if (hash.indexOf(config.name + '=') === 0) {
				cmd = hash.split('=')[1];
				
				if (cmd == 'reset') {
					minicart.reset();
					location.hash = '';
				}
			}
					
			// Update the UI
			if (isShowing) {
				setTimeout(function () {
					minicart.hide(null);
				}, 500);
			} else {
				$.storage.remove();
			}

			minicart.updateSubtotal();
		};


		/**
		 * Binds a form to the Mini Cart
		 *
		 * @param form {HTMLElement} The form element to bind
		 */
		minicart.bindForm = function (form) {
			if (form.add) {
				$.event.add(form, 'submit', function (e) {
					e.preventDefault(e);

					var data = _parseForm(e.target);
					minicart.addToCart(data);
				});
			} else if (form.display) {
				$.event.add(form, 'submit', function (e) {
					e.preventDefault();
					minicart.show(e);
				});
			} else {
				return false;
			}

			return true;
		};


		/**
		 * Adds a product to the cart
		 *
		 * @param data {object} Product object. See _parseData for format
		 * @return {boolean} True if the product was added, false otherwise
		 */
		minicart.addToCart = function (data) {
			var events = config.events,
				onAddToCart = events.onAddToCart,
				afterAddToCart = events.afterAddToCart,
				success = false,
				offset
			;
			
			if (typeof onAddToCart === 'function') {
				if (onAddToCart.call(minicart, data) === false) {
					return;
				}
			}
			
			data = _parseData(data);
			offset = data.product.offset;
			
			// Check if the product has already been added; update if so
			if (typeof offset != 'undefined' && minicart.products[offset]) {
				minicart.products[offset].product.quantity += parseInt(data.product.quantity || 1, 10);
				
				minicart.products[offset].setPrice(data.product.amount * minicart.products[offset].product.quantity);
				minicart.products[offset].setQuantity(minicart.products[offset].product.quantity);
				
				success = true;
			// Add a new DOM element for the product
			} else {	
				data.product.offset = minicart.products.length; 
				success = _renderProduct(data); 
			}	
				
			minicart.updateSubtotal();
			minicart.show(null);
			
			$.storage.save(minicart.products);
		
			if (typeof afterAddToCart === 'function') {
				afterAddToCart.call(minicart, data);
			}
			
			return success;
		};


		/**
		 * Iterates over each product and calculates the subtotal
		 *
		 * @return {number} The subtotal
		 */
		minicart.calculateSubtotal = function () {
			var amount = 0,
				product, price, discount, len, i
			;
				
			for (i = 0, len = minicart.products.length; i < len; i++) {
				if ((product = minicart.products[i].product)) {
					if (product.quantity && product.amount) {
						price = product.amount;
						discount = (product.discount_amount) ? product.discount_amount : 0;
						
						amount += parseFloat((price * product.quantity) - discount);
					}
				}
			}
			
			return amount.toFixed(2);
		};
		
		
		/**
		 * Updates the UI with the current subtotal and currency code
		 */
		minicart.updateSubtotal = function () {
			var currency_code,
				currency_symbol,
				subtotal = minicart.calculateSubtotal(),
				level = 1,
				hex, len, i
			;

			// Get the currency
			currency_code = '';
			currency_symbol = '';

			if (minicart.UI.cart.elements.currency_code) {
				currency_code = minicart.UI.cart.elements.currency_code.value || minicart.UI.cart.elements.currency_code;
			} else {			
				for (i = 0, len = minicart.UI.cart.elements.length; i < len; i++) {
					if (minicart.UI.cart.elements[i].name == 'currency_code') {
						currency_code = minicart.UI.cart.elements[i].value || minicart.UI.cart.elements[i];
						break;
					}
				}
			}

			// Update the UI		
			minicart.UI.subtotalAmount.innerHTML = $.util.formatCurrency(subtotal, currency_code); 
		
			// Yellow fade on update
			(function () {
				hex = level.toString(16);
				level++;
				
				minicart.UI.subtotalAmount.style.backgroundColor = '#ff' + hex;

				if (level >= 15) {
					minicart.UI.subtotalAmount.style.backgroundColor = 'transparent';
					
					// hide the cart if there's no total
					if (subtotal == '0.00') {
						minicart.hide(null, true);
					}
					
					return;
				}

				setTimeout(arguments.callee, 30);
			})();
		};
				

		/**
		 * Shows the cart
		 *
		 * @param e {event} The triggering event
		 */
		minicart.show = function (e) {
			var from = parseInt(minicart.UI.cart.offsetTop, 10),
				to = 0,
				events = config.events,
				onShow = events.onShow,
				afterShow = events.afterShow
			;
				
			if (e && e.preventDefault) { e.preventDefault(); }
			
			if (typeof onShow == 'function') {
				onShow.call(minicart, e);
			}
					
			$.util.animate(minicart.UI.cart, 'top', { from: from, to: to }, function () {
				if (typeof afterShow == 'function') {
					afterShow.call(minicart, e);
				}
			});
			
			minicart.UI.summary.style.backgroundPosition = '-195px 2px';
			isShowing = true;
		};
		
		
		/**
		 * Hides the cart off the screen
		 *
		 * @param e {event} The triggering event
		 * @param fully {boolean} Should the cart be fully hidden? Optional. Defaults to false.
		 */
		minicart.hide = function (e, fully) {
			var cartHeight = (minicart.UI.cart.offsetHeight) ? minicart.UI.cart.offsetHeight : document.defaultView.getComputedStyle(minicart.UI.cart, '').getPropertyValue('height'),
				summaryHeight = (minicart.UI.summary.offsetHeight) ? minicart.UI.summary.offsetHeight : document.defaultView.getComputedStyle(minicart.UI.summary, '').getPropertyValue('height'),
				from = parseInt(minicart.UI.cart.offsetTop, 10),
				events = config.events,
				onHide = events.onHide,
				afterHide = events.afterHide,
				to
			;

			// make the cart fully hidden
			if (fully || !config.peekEnabled) {
				to = cartHeight * -1;
			// otherwise only show a little teaser portion of it
			} else {
				to = (cartHeight - summaryHeight - 8) * -1;
			}

			if (e && e.preventDefault) { e.preventDefault(); }
			
			if (typeof onHide == 'function') {
				onHide.call(minicart, e);
			}
			
			$.util.animate(minicart.UI.cart, 'top', { from: from, to: to }, function () {
				if (typeof afterHide == 'function') {
					afterHide.call(minicart, e);
				}	
			});
			
			minicart.UI.summary.style.backgroundPosition = '-195px -32px';
			isShowing = false;
		};
		

		/**
		 * Toggles the display of the cart
		 *
		 * @param e {event} The triggering event
		 */
		minicart.toggle = function (e) {
			if (isShowing) {
				minicart.hide(e);
			} else {
				minicart.show(e);
			}
		};
				
	
		/**
		 * Resets the cart to it's initial state
		 */
		minicart.reset = function () {	
			var events = config.events,
				onReset = events.onReset,
				afterReset = events.afterReset
			;
				
			if (typeof onReset === 'function') {
				onReset.call(minicart);
			}
			
			minicart.products = [];

			if (isShowing) {
				minicart.UI.itemList.innerHTML = '';
				minicart.UI.subtotalAmount.innerHTML = '';
				minicart.hide(null, true);
			}
	
			$.storage.remove();
		
			if (typeof afterReset === 'function') {
				afterReset.call(minicart);
			}
		};
		

		// Expose the object as public methods
		return minicart;
	})();

	
	
	/**
	 * An HTMLElement which displays each product
	 *
	 * @param data {object} The data for the product
	 * @param position {number} The product number
	 */
	var ProductNode = function (data, position) {
		this.product = null;
		this.settings = null;
		this.liNode = null;
		this.nameNode = null;
		this.metaNode = null;
		this.priceNode = null;
		this.quantityNode = null;
		this.removeNode = null;
		this.isPlaceholder = false;
		
		this._init(data, position);
	};
	
	
	ProductNode.prototype = {		
		/**
		 * Creates the DOM nodes and adds the product content
		 *
		 * @param data {object} The data for the product
		 * @param position {number} The product number
		 */
		_init: function (data, position) {
			var shortName, fullName, price, discount = 0, hiddenInput, key, i;

			this.product = data.product;
			this.settings = data.settings;
			
			this.liNode = document.createElement('li');
			this.nameNode = document.createElement('a');
			this.metaNode = document.createElement('span');
			this.priceNode = document.createElement('span');
			this.quantityNode = document.createElement('input');
			this.removeNode = document.createElement('input');
			
			// Don't add blank products
			if (!this.product || (!this.product.item_name && !this.product.item_number)) { 
				this.isPlaceholder = true;
				return;
			}

			// Name
			if (this.product.item_name) { 
				fullName = this.product.item_name; 
				shortName = (fullName.length > 20) ? fullName.substr(0, 20) + '...' : fullName;
			}
			
			this.nameNode.innerHTML = shortName;
			this.nameNode.title = fullName;
			this.nameNode.href = this.product.href;
			this.nameNode.appendChild(this.metaNode);	
			
			// Meta info
			if (this.product.item_number) { 
				this.metaNode.innerHTML = '<br />#' + this.product.item_number;
			}
	
			// Options
			i = 0;
			
			while (typeof this.product['on' + i] !== 'undefined') {
				this.metaNode.innerHTML += '<br />' + this.product['on' + i] + ': ' + this.product['os' + i];
				i++;
			}

			// Discount
			if (this.product.discount_amount) { 
				this.metaNode.innerHTML += '<br />';
				this.metaNode.innerHTML += config.strings.discount || 'Discount: ';
				this.metaNode.innerHTML += $.util.formatCurrency(this.product.discount_amount, this.settings.currency_code);
			}

			// Quantity
			this.product.quantity = parseInt(this.product.quantity, 10);
			
			this.quantityNode.name = 'quantity_' + position;
			this.quantityNode.value = this.product.quantity ? this.product.quantity : 1;
			this.quantityNode.className = 'quantity';
			this.quantityNode.setAttribute('autocomplete', 'off');

			// Remove button
			this.removeNode.type = 'button';
			this.removeNode.className = 'remove';
			
			// Price
			price = parseFloat(this.product.amount, 10);
			
			if (this.product.discount_amount) {
				discount = this.product.discount_amount;
			}
			
			this.priceNode.innerHTML = $.util.formatCurrency((price * parseFloat(this.product.quantity, 10) - discount).toFixed(2), this.settings.currency_code);
			this.priceNode.className = 'price';
			
			// Build out the DOM
			this.liNode.appendChild(this.nameNode);			
			this.liNode.appendChild(this.quantityNode);
			this.liNode.appendChild(this.removeNode);
			this.liNode.appendChild(this.priceNode);	
			
			// Add in hidden product data
			for (key in this.product) {
				if (key !== 'quantity') {
					hiddenInput = document.createElement('input');
					hiddenInput.type = 'hidden';
					hiddenInput.name = key + '_' + position;
					hiddenInput.value = this.product[key];
				
					this.liNode.appendChild(hiddenInput);
				}
			}
		},
		
		
		/**
		 * Utility function to set the quantity of this product
		 *
		 * @param value {number} The new value
		 */
		setQuantity: function (value) {
			value = parseInt(value, 10);
			
			this.product.quantity = value;	
			
			if (this.quantityNode.value != value) {
				this.quantityNode.value = value;
			}
			
			this.setPrice(this.product.amount * value);
		},
		
		
		/**
		 * Utility function to get the quantity of this product
		 *
		 * @return {number}
		 */
		getQuantity: function () {
			return parseFloat(this.quantityNode.value, 10);
		},
		
		
		/**
		 * Utility function to set the price of this product
		 *
		 * @param value {number} The new value
		 */
		setPrice: function (value) {
			value = parseFloat(value, 10);
						
			this.priceNode.innerHTML = $.util.formatCurrency(parseFloat(value, 10).toFixed(2), this.settings.currency_code);
		},
		
		
		/**
		 * Utility function to get the price of this product
		 *
		 * @return {number} 
		 */
		getPrice: function () {
			return (this.product.amount * this.getQuantity());
		}
	};
	
	
	
	/** UTILITY **/
	
	var $ = {};
	
	$.storage = (function () {
		var name = config.name;
		
		// Use HTML5 client side storage
		if (window.localStorage) {
			return {

				/**
				 * Loads the saved data
				 * 
				 * @return {object}
				 */
				load: function () {
					var data = localStorage.getItem(name); 
					
					if (data) {
						data = JSON.parse(decodeURIComponent(data));
					}
					
					return data;
				},
				
				
				/**
				 * Saves the data
				 *
				 * @param items {object} The list of items to save
				 */
				save: function (items) {
					var data = [],
						item, len, i
					;
					
					if (items) {
						for (i = 0, len = items.length; i < len; i++) { 
							item = items[i];
							data.push({
								product: item.product,
								settings: item.settings
							});
						}
			
						data = encodeURIComponent(JSON.stringify(data));
						localStorage.setItem(name, data);
					}
				},
				
				
				/**
				 * Removes the saved data
				 */
				remove: function () {
					localStorage.removeItem(name);	
				}
			};
			
		// Otherwise use cookie based storage
		} else {
			return {
				
				/**
				 * Loads the saved data
				 * 
				 * @return {object}
				 */
				load: function () {
					var key = name + '=', 
						data, cookies, cookie, value, i
					;

					try {
						cookies = document.cookie.split(';');

						for (i = 0; i < cookies.length; i++) {
							cookie = cookies[i];

							while (cookie.charAt(0) === ' ') { 
								cookie = cookie.substring(1, cookie.length);
							}

							if (cookie.indexOf(key) === 0) {
								value = cookie.substring(key.length, cookie.length);
								data = JSON.parse(decodeURIComponent(value));
							}
						}					
					} catch(e) {}

					return data;	
				},
				
				
				/**
				 * Saves the data
				 *
				 * @param items {object} The list of items to save
				 */
				save: function (items, duration) {
					var date = new Date(),
						data = [],
						item, len, i
					;

					if (items) {
						for (i = 0, len = items.length; i < len; i++) {
							item = items[i];
							data.push({
								product: item.product,
								settings: item.settings
							});
						}
					
						duration = duration || 30;
						date.setTime(date.getTime() + duration * 24 * 60 * 60 * 1000);

						document.cookie = config.name + '=' + encodeURIComponent(JSON.stringify(data)) + '; expires=' + date.toGMTString() + '; path=' + config.cookiePath;
					}
				},


				/**
				 * Removes the saved data
				 */
				remove: function () {
					this.save(null, -1);
				}
			};
		}
	})();
	
	
	$.event = {
		/**
		 * Events are added here for easy reference
		 */
		cache: [],
		
		
		/**
		 * Cross browser way to add an event to an object and optionally adjust it's scope
		 *
		 * @param obj {HTMLElement} The object to attach the event to
		 * @param type {string} The type of event excluding "on"
		 * @param fn {function} The function
		 * @param scope {object} Object to adjust the scope to (optional)
		 */
		add: function (obj, type, fn, scope) {
			var wrappedFn;
						
			scope = scope || obj; 

			if (obj.addEventListener) {
				wrappedFn = function (e) { fn.call(scope, e); };
				obj.addEventListener(type, wrappedFn, false);
			} else if (obj.attachEvent) {
				wrappedFn = function () {
					var e = window.event;
					e.target = e.target || e.srcElement;

					e.preventDefault = function () {
						e.returnValue = false;
					};

					fn.call(scope, e);
				};

				obj.attachEvent('on' + type, wrappedFn);
			}

			this.cache.push([obj, type, fn, wrappedFn]);
		},
		
		
		/**
		 * Cross browser way to remove an event from an object
		 *
		 * @param obj {HTMLElement} The object to remove the event from
		 * @param type {string} The type of event excluding "on"
		 * @param fn {function} The function
		 */
		remove: function (obj, type, fn) {
			var wrappedFn, item, len, i;

			for (i = 0; i < this.cache.length; i++) {
				item = this.cache[i];

				if (item[0] == obj && item[1] == type && item[2] == fn) {
					wrappedFn = item[3];

					if (wrappedFn) {
						if (obj.removeEventListener) {
							obj.removeEventListener(type, wrappedFn, false);
						} else if (obj.detachEvent) {
							obj.detachEvent('on' + type, wrappedFn);
						}
						
						delete this.cache[i];
					}
				}
			}
		}
	};
	
	
	$.util = {
		/**
		 * Animation method for elements
		 *
		 * @param el {HTMLElement} The element to animate
		 * @param prop {string} Name of the property to change
		 * @param config {object} Properties of the animation
		 * @param callback {function} Callback function after the animation is complete
		 */
		animate: function (el, prop, config, callback) {
			config = config || {};
			config.from = config.from || 0;
			config.to = config.to || 0;
			config.duration = config.duration || 10;
			config.unit = (/top|bottom|left|right|width|height/.test(prop)) ? 'px' : '';

			var step = (config.to - config.from) / 20,
				current = config.from
			;

			(function () {
				el.style[prop] = current + config.unit;
				current += step;

				if ((step > 0 && current > config.to) || (step < 0 && current < config.to) || step === 0) {
					el.style[prop] = config.to + config.unit;

					if (typeof callback === 'function') {
						callback();
					}

					return;
				}

				setTimeout(arguments.callee, config.duration);
			})();
		},
		
		
		/**
		 * Convenience method to return the value of any type of form input
		 *
		 * @param input {HTMLElement} The element who's value is returned
		 */
		getInputValue: function (input) {
			var tag = input.tagName.toLowerCase();

			if (tag == 'select') {
				return input.options[input.selectedIndex].value;
			} else if (tag == 'textarea') {
				return input.innerHTML;
			} else {
				if (input.type == 'radio') {
					return (input.checked) ? input.value : null;
				} else if (input.type == 'checkbox') {
					return (input.checked) ? input.value : null;
				} else {
					return input.value;
				}
			}
		},
		
		
		/**
		 * Formats a float into a currency 
		 *
		 * @param amount {float} The currency amount
		 * @param code {string} The three letter currency code
		 */
		formatCurrency: function (amount, code) {
			// TODO: The supported currency patterns need to be refined and
			// should support values for before, after, decimal, and separator.
			var currencies = {
					AED: { before: '\u062c' },
					ANG: { before: '\u0192' },
					ARS: { before: '$' },
					AUD: { before: '$' },
					AWG: { before: '\u0192' },
					BBD: { before: '$' },
					BGN: { before: '\u043b\u0432' },
					BMD: { before: '$' },
					BND: { before: '$' },
					BRL: { before: 'R$' },
					BSD: { before: '$' },
					CAD: { before: '$' },
					CHF: { before: '' },
					CLP: { before: '$' },
					CNY: { before: '\u00A5' },
					COP: { before: '$' },
					CRC: { before: '\u20A1' },
					CZK: { before: 'Kc' },
					DKK: { before: 'kr' },
					DOP: { before: '$' },
					EEK: { before: 'kr' },
					EUR: { before: '\u20AC' },
					GBP: { before: '\u00A3' },
					GTQ: { before: 'Q' },
					HKD: { before: '$' },
					HRK: { before: 'kn' },
					HUF: { before: 'Ft' },
					IDR: { before: 'Rp' },
					ILS: { before: '\u20AA' },
					INR: { before: 'Rs.' },
					ISK: { before: 'kr' },
					JMD: { before: 'J$' },
					JPY: { before: '\u00A5' },
					KRW: { before: '\u20A9' },
					KYD: { before: '$' },
					LTL: { before: 'Lt' },
					LVL: { before: 'Ls' },
					MXN: { before: '$' },
					MYR: { before: 'RM' },
					NOK: { before: 'kr' },	
					NZD: { before: '$' },
					PEN: { before: 'S/' },
					PHP: { before: 'Php' },
					PLN: { before: 'z' },
					QAR: { before: '\ufdfc' },
					RON: { before: 'lei' },
					RUB: { before: '\u0440\u0443\u0431' },
					SAR: { before: '\ufdfc' },
					SEK: { before: 'kr' },
					SGD: { before: '$' },
					THB: { before: '\u0E3F' },
					TRY: { before: 'TL' },
					TTD: { before: 'TT$' },
					TWD: { before: 'NT$' },
					UAH: { before: '\u20b4' },
					USD: { before: '$' },
					UYU: { before: '$U' },
					VEF: { before: 'Bs' },
					VND: { before: '\u20ab' },
					XCD: { before: '$' },
					ZAR: { before: 'R' }			
				},
				currency = currencies[code],
				before, 
				after;
			
			if (currency) {
				before = currency.before || '';
				after = currency.after || '';
			}
	
			return before + amount + after;
		}
	};
	
	
	/**
	 * JSON Parser - See http://www.json.org/js.html
	 */
	if(!this.JSON){JSON={};}(function(){function f(n){return n<10?"0"+n:n;}if(typeof Date.prototype.toJSON!=="function"){Date.prototype.toJSON=function(key){return this.getUTCFullYear()+"-"+f(this.getUTCMonth()+1)+"-"+f(this.getUTCDate())+"T"+f(this.getUTCHours())+":"+f(this.getUTCMinutes())+":"+f(this.getUTCSeconds())+"Z";};String.prototype.toJSON=Number.prototype.toJSON=Boolean.prototype.toJSON=function(key){return this.valueOf();};}var cx=/[\u0000\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g,escapable=/[\\\"\x00-\x1f\x7f-\x9f\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g,gap,indent,meta={"\b":"\\b","\t":"\\t","\n":"\\n","\f":"\\f","\r":"\\r",'"':'\\"',"\\":"\\\\"},rep;function quote(string){escapable.lastIndex=0;return escapable.test(string)?'"'+string.replace(escapable,function(a){var c=meta[a];return typeof c==="string"?c:"\\u"+("0000"+a.charCodeAt(0).toString(16)).slice(-4);})+'"':'"'+string+'"';}function str(key,holder){var i,k,v,length,mind=gap,partial,value=holder[key];if(value&&typeof value==="object"&&typeof value.toJSON==="function"){value=value.toJSON(key);}if(typeof rep==="function"){value=rep.call(holder,key,value);}switch(typeof value){case"string":return quote(value);case"number":return isFinite(value)?String(value):"null";case"boolean":case"null":return String(value);case"object":if(!value){return"null";}gap+=indent;partial=[];if(Object.prototype.toString.apply(value)==="[object Array]"){length=value.length;for(i=0;i<length;i+=1){partial[i]=str(i,value)||"null";}v=partial.length===0?"[]":gap?"[\n"+gap+partial.join(",\n"+gap)+"\n"+mind+"]":"["+partial.join(",")+"]";gap=mind;return v;}if(rep&&typeof rep==="object"){length=rep.length;for(i=0;i<length;i+=1){k=rep[i];if(typeof k==="string"){v=str(k,value);if(v){partial.push(quote(k)+(gap?": ":":")+v);}}}}else{for(k in value){if(Object.hasOwnProperty.call(value,k)){v=str(k,value);if(v){partial.push(quote(k)+(gap?": ":":")+v);}}}}v=partial.length===0?"{}":gap?"{\n"+gap+partial.join(",\n"+gap)+"\n"+mind+"}":"{"+partial.join(",")+"}";gap=mind;return v;}}if(typeof JSON.stringify!=="function"){JSON.stringify=function(value,replacer,space){var i;gap="";indent="";if(typeof space==="number"){for(i=0;i<space;i+=1){indent+=" ";}}else{if(typeof space==="string"){indent=space;}}rep=replacer;if(replacer&&typeof replacer!=="function"&&(typeof replacer!=="object"||typeof replacer.length!=="number")){throw new Error("JSON.stringify");}return str("",{"":value});};}if(typeof JSON.parse!=="function"){JSON.parse=function(text,reviver){var j;function walk(holder,key){var k,v,value=holder[key];if(value&&typeof value==="object"){for(k in value){if(Object.hasOwnProperty.call(value,k)){v=walk(value,k);if(v!==undefined){value[k]=v;}else{delete value[k];}}}}return reviver.call(holder,key,value);}cx.lastIndex=0;if(cx.test(text)){text=text.replace(cx,function(a){return"\\u"+("0000"+a.charCodeAt(0).toString(16)).slice(-4);});}if(/^[\],:{}\s]*$/.test(text.replace(/\\(?:["\\\/bfnrt]|u[0-9a-fA-F]{4})/g,"@").replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g,"]").replace(/(?:^|:|,)(?:\s*\[)+/g,""))){j=eval("("+text+")");return typeof reviver==="function"?walk({"":j},""):j;}throw new SyntaxError("JSON.parse");};}}());

})();
