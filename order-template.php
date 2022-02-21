<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
require './class/customer-link.class.php';
require './product-template.php';

function echo_single_order($order)
{
    $id = $order['id'];
    $customer_id = $order['customer_id'];
    $date = $order['date'];
    $state = $order['state'];
    $total_price = $order['total_price'];
    $customer_link = new customer_link();
    $customer = $customer_link->get_customer_from_id($customer_id);

    if (isset($_SESSION['customer'])) {
        $state_field = $state;
    } else if (isset($_SESSION['admin'])) {
        $options = ['Nouvelle', 'Annulée', 'En cours', 'Terminée'];
        $options_string = "";
        foreach ($options as $option) {
            if ($option == $state) {
                $options_string .= '<option selected>' . $option . '</option>';
            } else {
                $options_string .= '<option>' . $option . '</option>';
            }
        }
        $state_field =  '<select class="p-1 stateSelector" id="' . $id . '-stateSelector" value="' . $state . '">
                                ' . $options_string . '
                            </select>
                            <p id="' . $id . '-stateChangedDisplay"></p>';
    } else {
        $state_field = '';
    }

    echo
    '<div id="' . $id . '-container" class="row">
            <div class="col-lg-12 mx-auto">
                <div class="wrapper-product mb-4">
                    <h3 role="presentation"><a href="order.php?id=' . $id . '">Numéro de Commande #' . $id . '</a></h3>
                    <div class="card p-4">
                        <div class="row">
                            <div class="col-3">
                                ' . $customer['last_name'] . ' ' . $customer['first_name'] . '</br>' . $customer['email'] . '
                            </div>
                            <div class="col-3">
                                Date de la commande : ' . $order['date'] . '
                            </div>
                            <div class="col-3">
                                État de la commande : ' . $state_field . '
                            </div>
                            <div class="col-3">
                            <p id="' . $id . '-priceDisplay" style="text-align: right">Prix total : ' . $total_price . '€</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
}

function echo_full_order($order)
{
    $id = $order['id'];
    $customer_id = $order['customer_id'];
    $date = $order['date'];
    $state = $order['state'];
    $total_price = $order['total_price'];
    $customer_link = new customer_link();
    $customer = $customer_link->get_customer_from_id($customer_id);

    $state_field = '';
    if (isset($_SESSION['customer'])) {
        $state_field = $state;
    } else if (isset($_SESSION['admin'])) {
        $options = ['Nouvelle', 'Annulée', 'En cours', 'Terminée'];
        $options_string = "";
        foreach ($options as $option) {
            if ($option == $state) {
                $options_string .= '<option selected>' . $option . '</option>';
            } else {
                $options_string .= '<option>' . $option . '</option>';
            }
        }
        $state_field =  '<select class="p-1 stateSelector" id="' . $id . '-stateSelector" value="' . $state . '">
                                ' . $options_string . '
                            </select>
                            <p id="' . $id . '-stateChangedDisplay"></p>';
    }

    $lines_field = '';
    foreach ($order['lines'] as $line) {
        $lines_field .= get_product_in_order($line);
    }

    echo
    '<div id="' . $id . '-container" class="row mt-5">
            <div class="col-lg-12 mx-auto">
                <div class="wrapper-product text-dark">
                    <h3 role="presentation"><a href="order.php?id=' . $id . '">Numéro de commande #' . $id . '</a></h3>
                    <div class="wrapper-order card">
                        <div class="card p-4">
                            <div class="row">
                                <div class="col-3">
                                    ' . $customer['last_name'] . ' ' . $customer['first_name'] . '</br>' . $customer['email'] . '
                                </div>
                                <div class="col-3">
                                    Date de la commande : ' . $order['date'] . '
                                </div>
                                <div class="col-3">
                                    État de la commande : ' . $state_field . '
                                </div>
                                <div class="col-3">
                                    <p id="' . $id . '-priceDisplay" style="text-align: right">Prix total : ' . $total_price . '€</p>
                                </div>
                            </div>
                        </div>
                        <div class="wrapper-product-list row">
                            ' . $lines_field . '
                        </div>
                    </div>
                </div>
            </div>
        </div>';
}