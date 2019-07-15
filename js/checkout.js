$(document).ready(function(){

	var existingEntries = JSON.parse(localStorage.getItem("cart_items"));
	var sous_total = 0;
	if(existingEntries){
		existingEntries.forEach(function(element) {

			$('#purchase_summary').append('<tr><td title="'+ element.text +'">'+ element.text +'</td><td align="center">'+ element.quantity +'</td><td align="right">'+ element.prix * element.quantity + '€' +'</td></tr>');
			sous_total = (element.prix * element.quantity) + sous_total;
			console.log(sous_total);
		});
	}
	else{
		window.location.href = 'index.php';
	}
	$('#sub_total').html(sous_total + '€');
	$('#total').html(sous_total + +5 + '€');
});