<?php
session_start();
require './class/admin-link.class.php';
$admin_link = new admin_link();
$id = isset($_POST['id']) ? $_POST['id'] : NULL;
if (isset($_POST['delete-admin']))
{
    $admin_link->delete_admin($id);
}
else if (isset($_POST['modify-admin']))
{
    $admin = $admin_link->get_admin_from_id($id);
    $modified_non_empty_values = [];
    foreach ($_POST as $k => $v)
    {
        if (isset($v) && $v != '' && $v != NULL && (isset($admin[$k]) || empty($admin[$k])) && $v != $admin[$k])
        {
            if ($k != "email" || $k != "login" || !$admin_link->is_admin_login_used($v))
            {
                $modified_non_empty_values[$k] = $v;
            }
        }
    }
    $admin_link->update_admin($id, $modified_non_empty_values);
    if (isset($_SESSION["admin"]) && $id == $_SESSION["admin"]["id"])
    {
        $admin_link->log_admin_from_id($id);
    }
}
header('Location: ./admins-manager.php');

?>