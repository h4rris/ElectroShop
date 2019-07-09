$(document).ready(function(){

	function addEntry(id_article, image, text_article, prix) {

	    // Recuperer le panier depuis localStorage
	    var existingEntries = JSON.parse(localStorage.getItem("cart_items"));
	    
	    //Verifier si l'utilisateur possede deja un panier
	    if (existingEntries === null) {
	    	existingEntries = [];
	    	var array = {"id_article" : id_article, "quantity" : 1, "image" : image, "text" : text_article, "prix" : prix};
    		existingEntries.push(array);
	    	localStorage.setItem("cart_items", JSON.stringify(existingEntries)); // Ajouter le panier dasn localStorage
	    	
	    	swal({
				title: "Article ajouté dans le panier !",
				icon: "success", //error, warning, success, info,
			});
	    }
	    else {
	    	//Verifier si l'article est deja dans le panier
	    	var id_article_in_cart = -1;

	    	existingEntries.forEach(function(element) {
	    		if (element.id_article === id_article)
	    			id_article_in_cart = existingEntries.indexOf(element);
			});

	    	// si article existe dans le panier
	    	if (id_article_in_cart >= 0 ) {
	    		swal({
					title: "Cet article est déjà dans votre panier! Voulez-vous rajouter en plus ?",
					icon: "warning", //error, warning, success, info,
					buttons: true
				})
				.then((addToCart) => {
					if (addToCart) {
						existingEntries[id_article_in_cart]['quantity'] = existingEntries[id_article_in_cart]['quantity'] + +1;
		    			localStorage.setItem("cart_items", JSON.stringify(existingEntries)); //Ajouter l'article dans le panier puis sauver dans localStorage

						swal({
							title: "Article ajouté dans le panier ! ?",
							icon: "success", //error, warning, success, info,
						});
					}
				});

	    	// 	if (confirm("Cet article est déjà ajouté dans votre panier! Voulez-vous rajouter en plus ?")) {
	    	// 		console.log(existingEntries[id_article_in_cart]);
				  //   existingEntries[id_article_in_cart]['quantity'] += 1;
			  	// }
	    	}
	    	else { //sinon on ajoute dans localstorage
	    		// var array = {"id_article" : id_article, "quantity" : 1};
	    		var array = {"id_article" : id_article, "quantity" : 1, "image" : image, "text" : text_article, "prix" : prix};
	    		existingEntries.push(array);
	    		localStorage.setItem("cart_items", JSON.stringify(existingEntries)); //Ajouter l'article dans le panier puis sauver dans localStorage
	    		
	    		swal({
						title: "Article ajouté dans le panier ! ?",
						icon: "success", //error, warning, success, info,
				});
	    	}
	    }
	};
	
	if ($("#article_section").length) {

		$(document).on('click', 'a[data-toggle="collapse"]', function() {
			$('div[data-group="article"]').hide();
			$('div[data-category="'+ $(this).data('group')+'"]').show();
		});

		$(document).on('click', '.add_to_cart', function() {
			var parent_of_all = $(this).closest("div[class^='col-']");

			var id_to_add = parent_of_all.data('id');
			var image = parent_of_all.find('img').attr('src');
			var text_article = parent_of_all.find('.article').html();
			var prix = parseInt(parent_of_all.find('.price').children().html().slice(0, -1));

			addEntry(id_to_add, image, text_article, prix);
		});

		$(document).on('click', '.show_more', function() {
			var parent_of_all = $(this).closest("div[class^='col-']");
			var id_to_add = parent_of_all.data('id');

			window.location.href = "single-product.php?id_article=" + id_to_add;
			// $().redirect('single-product.php', {'id': id_to_add});
		});
	}

});






