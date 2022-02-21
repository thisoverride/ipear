<?php

    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);

    require_once './class/product-link.class.php';

    function odd_product($id,$name,$description,$price,$picture){
        echo
        '<div class="row align-items-center">
            <div class="col-sm-6 col-xs-12 stack-product-info">
                <div class="wrapper-product">
                    <h2 role="presentation" class="mb-3">'.$name.'</h2>
                    <p class="p-2" >'.$description.'</p>
                    <a href="product.php?product_id='.$id.'">Acheter à partir de '.$price.'€ ></a>
                    <h3 role="presentation">Obtenez jusqu’à 260 € de crédit de reprise avec Pear Trade In**</h3>
                </div>
            </div>
            <div class="col-sm-6 col-xs-12 stack-product-picture text-center">
                <img src="'.$picture.'">
            </div>
        </div>';
    }

    function even_product($id,$name,$description,$price,$picture){
        echo
        '<div class="row align-items-center">
            <div class="col-sm-6 col-xs-12 stack-product-picture">
                <img src="'.$picture.'">
            </div>
            <div class="col-sm-6 col-xs-12 stack-product-info">
                <div class="wrapper-product">
                    <h2 role="presentation" class="mb-3">'.$name.'</h2>
                    <p class="p-2">'.$description.'</p>
                    <a href="product.php?product_id='.$id.'">Acheter à partir de '.$price.'€ ></a>
                    <h3 role="presentation">Obtenez jusqu’à 260 € de crédit de reprise avec Pear Trade In**</h3>
                </div>
            </div>
        </div>';
    }

    function single_product($id,$name,$description,$price,$picture){
        echo
        '<div class="row">
            <div class="col-lg-4">
                <img style="height: 400px;" src="'.$picture.'">
                <hr>
            </div>
            <div class="col-lg-4 mx-auto">
                <div class="wrapper-product">
                    <h2 role="presentation">Acheter '.$name.'</h2>
                    <h3 role="presentation">Obtenez jusqu’à 260 € de crédit de reprise avec Pear Trade In**</h3>
                    <div class="card p-4">
                        <div class="row">
                            <div class="col-6">
                                <p class="mx-auto">'.$name.' </p>
                            </div>
                            <div class="col-6">
                                <p style="text-align: right;">À partir de '.$price.'€</p>
                            </div>
                        </div>
                    </div>
                    <p class="mt-3 text-center">
                        '.$description.'
                    </p>
                </div>
                <div class="cart-add">
                    <input id="quantityPicker" type="number" value="1" min="1" max="99" step="1"/>
                    <button id="addToCart" type="button" class="btn btn-primary">Ajouter au panier</button>
                </div>
                <p id="addedMessage"></p>
            </div>
        </div>';
    }

    function product_in_cart($product){
        $id = $product['id'];
        $name = $product['name'];
        $price = $product['price'];
        $quantity = $_SESSION['cart'][$id]['quantity'];
        $total_price = $_SESSION['cart'][$id]['total_price'];
        $picture = $product['picture'];
        $options = range(1,99);
        $options_string = "";
        foreach ($options as $val) {
            if ($quantity ==     $val) {
                $options_string .= '<option selected>'.$val.'</option>';
            } else {
                $options_string .= '<option>'.$val.'</option>';
            }
        }
        echo
        '<div id="'.$id.'-container" class="row product-in-cart">
            <div class="col-lg-4 text-center">
                <img style="height: 200px;" src="'.$picture.'">
            </div>
            <div class="col-lg-4 mx-auto">
                <div class="wrapper-product">
                    <h3 role="presentation">'.$name.'</h3>
                    <div class="card p-4">
                        <div class="row">
                            <div class="col-6">
                                <select class="p-1 quantitySelector" id="'.$id.'-quantitySelector" value="'.$quantity.'">
                                    '.$options_string.'
                                </select> x '.$price.'
                            </div>
                            <div class="col-6">
                                <p id="'.$id.'-priceDisplay" style="text-align: right; margin-top: 10px;">Prix total : '.$total_price.'€</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="cart-add">
                    <button id="'.$id.'-removeFromCart" type="button" class="btn btn-primary mx-auto removeFromCart">Supprimer</button>
                </div>
            </div>
        </div>';
    }
    
    function get_product_in_order($line){
        $product_link = new product_link();
        $product_id = $line['product_id'];
        $product = $product_link->get_product_from_id($product_id);
        $quantity = $line['quantity'];
        $id = $product['id'];
        $name = $product['name'];
        $total_price = $quantity*$product['price'];
        $picture = $product['picture'];
        $options = range(1,99);
        $options_string = "";
        foreach ($options as $val) {
            if ($quantity ==     $val) {
                $options_string .= '<option selected>'.$val.'</option>';
            } else {
                $options_string .= '<option>'.$val.'</option>';
            }
        }
        return
        '<div id="'.$id.'-container" class="row">
            <div class="wrapper-product d-flex align-items-center m-2">
                <div class="col-4 text-center">
                    <h3 role="presentation">'.$name.'</h3>
                    <img style="height: 150px;" src="'.$picture.'">
                </div>
                <div class="col-8 p-4 text-end">
                    <p class="p-2">Prix unitaire : '.$product['price'].'€</p>
                    <p class="p-2">Quantité : '.$quantity.'</p>
                    <p class="p-2">Prix total : '.$total_price.'€</p>
                </div>
            </div>
        </div>';
    }


    function echo_products_table($products) {
        $products_rows = '';
        foreach ($products as $product) {
            $products_rows .= get_product_row($product);
        }
        echo
        '<table class="table text-center">
            <thead>
                <tr>
                    <th id="category-title" scope="col">Catégorie</th>
                    <th id="name-title" scope="col">Nom du produit</th>
                    <th id="description-title" scope="col">Description</th>
                    <th id="price-title"scope="col">Prix</th>
                    <th id="stock-title"scope="col">Stock</th>
                    <th scope="col">Emplacement photo</th>
                    <th scope="col">Modifier</th>
                    <th scope="col">Supprimer</th>
                </tr>
            </thead>
            <tbody>
                '.$products_rows.'
            </tbody>
        </table>';
    }

    function get_product_row($product) {
        $options_string = '';
        if ($product['category_id'] == 1) {
            $options_string =   '<option value="1" selected>iPear</option>
                                <option value="2">iPed</option>
                                <option value="3">iWotch</option>';
        } else if ($product['category_id'] == 2) {
            $options_string =   '<option value="1">iPear</option>
                                <option value="2" selected>iPed</option>
                                <option value="3">iWotch</option>';

        } else if ($product['category_id'] == 3) {
            $options_string =   '<option value="1">iPear</option>
                                <option value="2">iPed</option>
                                <option value="3" selected>iWotch</option>';
        }
        return
        '<form method="POST" action="submit-product-action.php"><tr>
            <td><select name="category_id" id="category_id" class="form-select">
                    '.$options_string   .'
                </select>
            <td><input name="name" class="form-control" type="text" id="name" value="'.$product["name"]. '"></td>
            <td><input name="description" class="form-control" type="text" id="description" value="'.$product["description"]. '"></td>
            <td><input name="price" class="form-control" id="price" value="'.$product["price"]. '"></td>
            <td><input name="stock" class="form-control" type="text" id="stock" value="'.$product["stock"]. '"></td>
            <td><input name="picture" class="form-control" type="text" id="picture" value="'.$product["picture"]. '"></td>
            <td><button type="submit" name="modify-product" id="validate" class="btn btn-primary">✓</button></td>
            <td><button type="submit" name="delete-product" id="rounded" class="btn btn-primary d-block mx-auto">X</button></td>
            <input name="id" style="display: none;" type="number" value="'.$product["id"].'">
        </tr></form>';
    }
?>