$(document).ready(function(){
	if ($("#cart_section").length) {

		function update_cart_total() {
			// $('#total_amount_cart');
			var total = 0;
			$(".prix_total_par_article").each(function() {
			    total += parseInt($(this).html().slice(0, -1));
		 	})
			$('#total_amount_cart').html(total+'€');
		}


		console.log('ouiiiiii');
		var existingEntries = JSON.parse(localStorage.getItem("cart_items"));
		// console.log(existingEntries);

		existingEntries.forEach(function(element) {
			$('#cart_body').prepend('<tr><td><div class="media"><div class="d-flex"><img src="'+ element.image +'" style="height: 137px; width: 191px;" alt=""></div> <div class="media-body"> <p>'+ element.text +'</p> </div> </div> </td> <td> <h5 class="prix_article">'+ element.prix + '€' + '</h5> </td> <td> <div class="product_count"> <input type="text" name="qty" class="quantity" maxlength="12" value="'+ element.quantity +'" title="Quantity:" class="input-text qty"> <button class="increase items-count" type="button"><i class="lnr lnr-chevron-up"></i></button> <button class="reduced items-count" type="button"><i class="lnr lnr-chevron-down"></i></button> </div> </td> <td> <h5 class="prix_total_par_article">'+ element.quantity * element.prix + "€" +'</h5> </td> </tr>');

		});

		$(document).on('click', '.increase', function() {
			// $(this).find("input");
			var value = $(this).siblings('input').attr("value");

			$(this).siblings('input').attr("value", +value + +1);

			var prix = parseInt($(this).closest('td').prev('td').text().slice(0, -1));
			$(this).closest('td').next('td').find('h5').html(prix * (+value + +1) + '€');

			update_cart_total();
			
		});

		$(document).on('click', '.reduced', function() {
			// $(this).find("input");
			var value = $(this).siblings('input').attr("value");
			if (value > 0) {
				$(this).siblings('input').attr("value", +value - +1);

				var prix = parseInt($(this).closest('td').prev('td').text().slice(0, -1));
				$(this).closest('td').next('td').find('h5').html(prix * (+value - +1) + '€');

				update_cart_total();
			}
		});

		update_cart_total();

	}
});