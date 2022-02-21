<?php

function echo_admin_table($admins)
{
    $admins_rows = '';
    foreach ($admins as $admin) {
        $admins_rows .= get_admin_row($admin);
    }
    echo ' <table class="table mt-5 text-center">
                            <thead>
                                <tr>
                                    <th id="title-login"scope="col">Login</th>
                                    <th id="title-email" scope="col">Email</th>
                                    <th id="actionOne"scope="col">Modifier</th>
                                    <th id="actionTwo" scope="col">Supprimer</th>
                                </tr>
                            </thead>
                            <tbody>
                                ' . $admins_rows . '
                            </tbody>
                        </table>';
}

function get_admin_row($admin)
{
    return
        '<form method="POST" action="submit-admin-action.php"><tr>
        <td><input name="login" class="form-control" id="login" type="text" value="' . $admin["login"] . '"/></td>
        <td><input name="email" class="form-control" type="email" id="email" value="' . $admin["email"] . '"/></td>
        <td id="actionOne"><button type="submit" name="modify-admin" id="validate" class="btn btn-primary">✓</button></td>
        <td id="actionTwo"><button type="submit" name="delete-admin" id="rounded" class="btn btn-primary d-block mx-auto">X</button></td>
        <input name="id" style="display: none;" type="number" value="' . $admin["id"] . '">
    </tr></form>';
}