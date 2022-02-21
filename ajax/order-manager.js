
$('.stateSelector').on('change', (e) => {
    const id = e.target.id.split('-')[0];
	const selector = document.getElementById(e.target.id);
	const selected_state = selector.value;
	$.ajax({
        url : './order-actions/change-order-state.php', 
		type : 'GET',
		data : {'id': id, 'state': selected_state},
		success : () => {
            const display = document.getElementById(id+"-stateChangedDisplay");
            display.innerText = "Le nouvel état de la commande est : "+selected_state;
		}
	 });
});
