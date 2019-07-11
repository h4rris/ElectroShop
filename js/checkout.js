$(document).ready(function(){

	var existingEntries = JSON.parse(localStorage.getItem("cart_items"));
	var sous_total = 0;
	existingEntries.forEach(function(element) {

		$('#purchase_summary').append('<tr><td title="'+ element.text +'">'+ element.text +'</td><td align="center">'+ element.quantity +'</td><td align="right">'+ element.prix * element.quantity + '€' +'</td></tr>');
		sous_total = (element.prix * element.quantity) + sous_total;
	});

	$('#sub_total').html(sous_total + '€');
	$('#total').html(sous_total + +5 + '€');

	$(document).on('click', 'input:radio', function() {
		$('#total').html(sous_total + parseInt($(this).attr('value')) + '€');
	});

	$(document).on('click')
});