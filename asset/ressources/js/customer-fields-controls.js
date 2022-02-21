"use strict";
// Control input phone number (register)
const phone = document.getElementById("isNumber");
phone.maxLength = 10;

phone.addEventListener("keypress", function (evt) {
  var keynum; 

  if (window.event) {
    keynum = evt.keyCode;
  } else {
    keynum = evt.which;
  }

  if (!/[0-9]/.test(String.fromCharCode(keynum))) {
    evt.preventDefault();
  }
});

// Jquery Autocomplete address (register)
$(".isAddress").on("keyup", function (evt) {

  $(function () {
    
    $(".isAddress").autocomplete({
      source: function (request, response) {
        $.ajax({
          url: "./search.php",
          dataType: "JSON",
          type: "POST",
          data: {
            term: request.term
          },
          success: function (data) {
            response(data);
          },
        });
      },
      minLength: 2,
      select: function (event, ui) {
        const customer_id = event.target.id.split('-')[0];
        if (customer_id != null && customer_id != '') {
          document.getElementById(customer_id+'-address').value=ui.item.address;
          document.getElementById(customer_id+'-city').value=ui.item.city;
          document.getElementById(customer_id+'-postal_code').value=ui.item.postal_code;
        } else {
          document.getElementById('address').value=ui.item.address;
          document.getElementById('city').value=ui.item.city;
          document.getElementById('postal_code').value=ui.item.postal_code;
        }
      },
    });
  });
});
