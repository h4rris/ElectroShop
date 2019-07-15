$(document).ready(function(){
	if ($("#cart_section").length) {

		var existingEntries = JSON.parse(localStorage.getItem("cart_items"));

		if(existingEntries){
			existingEntries.forEach(function(element) {
				$('#cart_body').prepend('<tr data-idArticle="'+element.id_article+'"><td><div class="media"><div class="d-flex"><img src="'+ element.image +'" style="height: 137px; width: 191px;" alt=""></div> <div class="media-body"> <p>'+ element.text +'</p><br/><p><a href="javascript:void(0)" class="supprimer_article">Supprimer</a></p> </div> </div> </td> <td> <h5 class="prix_article">'+ element.prix + '€' + '</h5> </td> <td> <div class="product_count"> <input type="number" name="qty" class="quantity" max="10" value="'+ element.quantity +'" class="input-text qty"> <button class="increase items-count" type="button"><i class="lnr lnr-chevron-up"></i></button> <button class="reduced items-count" type="button"><i class="lnr lnr-chevron-down"></i></button> </div> </td> <td> <h5 class="prix_total_par_article">'+ element.quantity * element.prix + "€" +'</h5> </td> </tr>');
			});
		}
		else{
			$('#cart_body').prepend('<h3 class="text center">Aucun article dans le panier !!</h3>');
		}

		function update_cart_total(id_article, quantity) {
			// $('#total_amount_cart');

			var total = 0;
			$(".prix_total_par_article").each(function() {

			    total += parseInt($(this).html().slice(0, -1));
		 	})
			$('#total_amount_cart').html(total);
			$('#total_amount_cart').data("total", total);

			if(existingEntries){
				existingEntries.forEach(function(element) {
					if (element.id_article == id_article) {
						element.quantity = quantity;
					}
				});
			}
			localStorage.setItem("cart_items", JSON.stringify(existingEntries));
		}

		$.get( "all_articles.php")
		  	.done(function(data) {
		  		var obj = JSON.parse(data);

			    obj.forEach(function (element) {
			    	$('#cart_body>tr').each(function() {
				    	if ($(this).data('idarticle') == element.id_article) {

							$(this).find('input').attr('max',element.stock_article);
				    	}
				    });
			    });
			})
			.fail(function(error) {
				console.log(error);
		});

		$(document).on('click', '.increase', function() {
			// $(this).find("input");
			var value = parseInt($(this).siblings('input').attr("value"));
			var max_value = parseInt($(this).siblings('input').attr("max"));

			if (value < max_value) {
				$(this).siblings('input').attr("value", +value + +1);

				var prix = parseInt($(this).closest('td').prev('td').text().slice(0, -1));
				$(this).closest('td').next('td').find('h5').html(prix * (+value + +1) + '€');

				var id = $(this).closest('tr').data('idarticle')
				var value = $(this).siblings('input').attr('value');
				update_cart_total(id, value);
			}
			else {
				swal({
					title: "Vous avez dépassé la quantité maximale !",
					icon: "warning" //error, warning, success, info
				});
			}
		});

		$(document).on('click', '.reduced', function() {
			var value = $(this).siblings('input').attr("value");
			if (value > 1) {
				$(this).siblings('input').attr("value", +value - +1);

				var prix = parseInt($(this).closest('td').prev('td').text().slice(0, -1));
				$(this).closest('td').next('td').find('h5').html(prix * (+value - +1) + '€');

				var id = $(this).closest('tr').data('idarticle')
				var value = $(this).siblings('input').attr('value');
				update_cart_total(id, value);
			}
		});

		$(document).on('click', '.supprimer_article', function() {
			var id_article_cart = $(this).closest('tr').data('idarticle');
			$(this).closest('tr').fadeOut(300, function() {
				$(this).remove();
				update_cart_total();

				existingEntries.forEach(function(element, index, array) {
					if (element.id_article === id_article_cart) {
						array.splice(index, 1);
					}
				});
    			localStorage.setItem("cart_items", JSON.stringify(existingEntries)); //Ajouter l'article dans le panier puis sauver dans localStorage
			});

			swal({
				title: "Article supprimé !",
				icon: "success", //error, warning, success, info,
			});
		});

		$(document).on('click', '.Shipping_option', function() {
			$('.Shipping_option').removeClass('active');
			$(this).addClass('active');

			var total = parseInt($('#total_amount_cart').data("total"));

			$('#total_amount_cart').html(total+ parseInt($(this).data("delivery-price")));
		});

		
		if ($('#total_amount_cart').html() == 0) {
			$("#cart_validate").attr("href", "category.php")
		}

		update_cart_total();

	}
});