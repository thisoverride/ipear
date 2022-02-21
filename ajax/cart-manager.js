"use strict";

$('#addToCart').click(() => {
	const queryString = window.location.search;
	const urlParams = new URLSearchParams(queryString);
	const id = urlParams.get('product_id');
	const quantityPicker = document.getElementById('quantityPicker');
	const quantity = quantityPicker.value;
	$.ajax({
		url : './cart-actions/add-product.php', 
		type : 'GET',
		data : {'id': id, 'quantity': quantity},
		success: () => {
			const addedMessage = document.getElementById("addedMessage");
			addedMessage.innerHTML = "Les éléments ont étés ajoutés au panier !</br><a href='./cart.php'>Voir le panier</a>";
		}
	 });
});

$('.removeFromCart').click((e) => {
	const id = e.target.id.split('-')[0];
	$.ajax({
		url : './cart-actions/remove-product.php', 
		type : 'GET',
		data : {'id': id},
		success : (newTotalPrice) => {
			const container = document.getElementById(id+'-container');
			const parentContainer = container.parentElement;
			container.remove();
			const remainingProducts = document.getElementsByClassName('product-in-cart');
			const totalPriceDisplay = document.getElementById('totalPriceDisplay');
			totalPriceDisplay.innerText = "Prix total du panier : " + newTotalPrice + "€"
			if (remainingProducts.length <= 0) {
				const validateCart = document.getElementById('validateCart');
				validateCart.style.display = "none";
				totalPriceDisplay.style.display = "none";
				parentContainer.innerText = "Le panier est vide !"
			}
		}
	 });
});


$('.quantitySelector').on('change', (e) => {
	const id = e.target.id.split('-')[0];
	const selector = document.getElementById(e.target.id);
	const quantity = selector.value;
	$.ajax({
		url : './cart-actions/change-product-quantity.php', 
		type : 'GET',
		data : {'id': id, 'quantity': quantity},
		datatype : "text",
		success : (newPrices) => {
			const priceDisplay = document.getElementById(id+'-priceDisplay');
			const totalPriceDisplay = document.getElementById('totalPriceDisplay');
			const newPrice = newPrices.split(",")[1];
			const newTotalPrice = newPrices.split(",")[0];
			priceDisplay.innerText = "Prix total : " + newPrice + "€"
			totalPriceDisplay.innerText = "Prix total du panier : " + newTotalPrice + "€"
		}
	 });
});


$('#validateCart').click(() => {
	$.ajax({
		url : './cart-actions/validate-cart.php', 
		success: () => {
			const url_parts = document.location.href.split('/');
			url_parts[url_parts.length-1] = 'orders.php';
			document.location.href = url_parts.join('/');
		}
	 });
});