<?php
    function echo_customers_table($customers) {
        $customers_rows = '';
        foreach ($customers as $customer) {
            $customers_rows .= get_customer_row($customer);
        }
        $delete_col = isset($_SESSION["admin"]) ? '<th scope="col">Supprimer</th>' : '';
        echo
        '<table class="table text-center">
            <thead>
                <tr>
                    <th id="last_name-title" scope="col">Nom</th>
                    <th id="first_name-title" scope="col">Prénom</th>
                    <th id="email-title"scope="col">E-mail</th>
                    <th id="phone-title"scope="col">Téléphone</th>
                    <th scope="col">Date de naissance</th>
                    <th scope="col">Adresse</th>
                    <th scope="col">Modifier</th>
                    '.$delete_col.'
                </tr>
            </thead>
            <tbody>
                '.$customers_rows.'
            </tbody>
        </table>';
    }

    function get_customer_row($customer) {
        $address_string = $customer["address"];
        $address_string = isset($customer["postal_code"]) && $address_string != "" ? $address_string.', '.$customer["postal_code"] : $address_string;
        $address_string = isset($customer["city"]) && $address_string != "" ? $address_string.', '.$customer["city"] : $address_string;
        $delete_button = isset($_SESSION["admin"]) ? '<td><button type="submit" name="delete-customer" id="rounded" class="btn btn-primary d-block mx-auto">X</button></td>' : '';
        return
    '<form method="POST" action="submit-customer-action.php"><tr>
            <td><input name="last_name" class="form-control" type="text" id="last_name" value="'.$customer["last_name"]. '"></td>
            <td><input name="first_name" class="form-control" type="text" id="first_name" value="'.$customer["first_name"]. '"></td>
            <td><input name="email" class="form-control" type="email" id="email" value="'.$customer["email"]. '"></td>
            <td><input name="phone_number" class="form-control" id="isNumber" type="text" value="'.$customer["phone_number"]. '"></td>
            <td><input name="birth_date" class="form-control" type="date" value="'.$customer["birth_date"]. '"></td>
            <td><input type="text" class="form-control isAddress" id="'.$customer["id"].'-isAddress" autocomplete="off" placeholder="22 rue saint-augustin paris 75002" value="'.$address_string.'"></td>
            <td><button type="submit" name="modify-customer" id="validate" class="btn btn-primary">✓</button></td>
            '.$delete_button.'
            <div class="hiddenAddress" id="'.$customer["id"].'-hiddenAddress">
                <input type="text" name="address" id="'.$customer["id"].'-address" value="'.$customer["address"].'">
                <input type="text" name="city" id="'.$customer["id"].'-city" value="'.$customer["city"].'">
                <input type="text" name="postal_code" id="'.$customer["id"].'-postal_code" value="'.$customer["postal_code"].'">
            </div>
            <input name="id" style="display: none;" type="number" value="'.$customer["id"].'">
        </tr></form>';
    }

?>