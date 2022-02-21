<?php
session_start();
require './class/customer-link.class.php';
$customer_link = new customer_link();
$id = isset($_POST['id']) ? $_POST['id'] : NULL;
if (isset($_POST['delete-customer']))
{
    $customer_link->delete_customer($id);
}
else if (isset($_POST['modify-customer']))
{
    $customer = $customer_link->get_customer_from_id($id);
    $modified_non_empty_values = [];
    foreach ($_POST as $k => $v)
    {
        if (isset($v) && $v != '' && $v != NULL && (isset($customer[$k]) || empty($customer[$k])) && $v != $customer[$k])
        {
            if ($k != "email" || !$customer_link->is_customer_email_used($v))
            {
                $modified_non_empty_values[$k] = $v;
            }
        }
    }
    $customer_link->update_customer($id, $modified_non_empty_values);
    if (isset($_SESSION["customer"]))
    {
        $customer_link->log_customer_from_id($id);
    }
}
if (isset($_SESSION["admin"]))
{
    header('Location: ./customers-manager.php');
}
else if (isset($_SESSION["customer"]))
{
    header('Location: ./profile.php');
}
else
{
    header('Location: ./index.php');
}

?>