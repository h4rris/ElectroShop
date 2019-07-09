$(document).ready(function() {

	function addEntry(id_article, image, text_article, prix, quantity) {
    
      // Recuperer le panier depuis localStorage
      var existingEntries = JSON.parse(localStorage.getItem("cart_items"));
      
      //Verifier si l'utilisateur possede deja un panier
      if (existingEntries === null) {
        existingEntries = [];
        var array = {"id_article" : id_article, "quantity" : quantity, "image" : image, "text" : text_article, "prix" : prix};
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
            existingEntries[id_article_in_cart]['quantity'] = existingEntries[id_article_in_cart]['quantity'] + quantity;
              localStorage.setItem("cart_items", JSON.stringify(existingEntries)); //Ajouter l'article dans le panier puis sauver dans localStorage

            swal({
              title: "Article ajouté dans le panier ! ?",
              icon: "success", //error, warning, success, info,
            });
          }
        });

        //  if (confirm("Cet article est déjà ajouté dans votre panier! Voulez-vous rajouter en plus ?")) {
        //    console.log(existingEntries[id_article_in_cart]);
          //   existingEntries[id_article_in_cart]['quantity'] += 1;
          // }
        }
        else { //sinon on ajoute dans localstorage
          // var array = {"id_article" : id_article, "quantity" : 1};
          var array = {"id_article" : id_article, "quantity" : quantity, "image" : image, "text" : text_article, "prix" : prix};
          existingEntries.push(array);
          localStorage.setItem("cart_items", JSON.stringify(existingEntries)); //Ajouter l'article dans le panier puis sauver dans localStorage
          
          swal({
            title: "Article ajouté dans le panier ! ?",
            icon: "success", //error, warning, success, info,
        });
        }
      }
  };
	$(document).on('click', '#add_to_cart', function () {
		var id_to_add = $(this).data('id_article');
		var image = $('.img-fluid').attr('src');
		var prix = parseInt($('#prix').html().slice(0, -1));
		var text_article = $('#nom_article').html();

		var quantity = parseInt($("#quantity").attr('value'));


		console.log(id_to_add,image, text_article, prix, quantity);
		addEntry(id_to_add, image, text_article, prix, quantity);
	});

	$(document).on('click', '.increase', function() {
		// $(this).find("input");
		var value = parseInt($(this).siblings('input').attr("value"));
		var max_value = parseInt($(this).siblings('input').attr("max"));

		if (value < max_value) {
			$(this).siblings('input').attr("value", +value + +1);
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
		}
    });

});