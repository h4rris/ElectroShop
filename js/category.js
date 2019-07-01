$(document).ready(function(){

	function addEntry(id_article, image, text_article, prix) {

	    // Recuperer le panier depuis localStorage
	    var existingEntries = JSON.parse(localStorage.getItem("cart_items"));
	    
	    //Verifier si l'utilisateur possede deja un panier
	    if (existingEntries === null) {
	    	console.log('if');
	    	existingEntries = [];
	    	var array = {"id_article" : id_article, "quantity" : 1, "image" : image, "text" : text_article, "prix" : prix};
    		existingEntries.push(array);
	    	localStorage.setItem("cart_items", JSON.stringify(existingEntries)); // Ajouter le panier dasn localStorage
	    }
	    else {
	    	console.log('already exists');

	    	//Verifier si l'article est deja dans le panier
	    	var id_article_in_cart = -1;

	    	existingEntries.forEach(function(element) {
	    		if (element.id_article === id_article)
	    			id_article_in_cart = existingEntries.indexOf(element);
			});

	    	// var id_article_in_cart = existingEntries.indexOf(id_article);
	    	if (id_article_in_cart >= 0 ) {
	    		if (confirm("Cet article est déjà ajouté dans votre panier! Voulez-vous rajouter en plus ?")) {
	    			console.log(existingEntries[id_article_in_cart]);
				    existingEntries[id_article_in_cart]['quantity'] += 1;
			  	}
	    	}
	    	else {
	    		// var array = {"id_article" : id_article, "quantity" : 1};
	    		var array = {"id_article" : id_article, "quantity" : 1, "image" : image, "text" : text_article, "prix" : prix};
	    		existingEntries.push(array);
	    	}

	    	localStorage.setItem("cart_items", JSON.stringify(existingEntries)); //Ajouter l'article dans le panier puis sauver dans localStorage
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

			console.log(prix);

			addEntry(id_to_add, image, text_article, prix);
		});
	}

});






