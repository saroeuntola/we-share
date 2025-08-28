<?php

include("auth.php");

function OnlyRolesAdmin() {

    $auth = new Auth();
    
    if ($auth->is_logged_in()) {
        if ($_SESSION['role_id'] != 1) {
            header("Location: /weshare/admin/include/permission_denied");
            exit;
        }
    } else {
        header("Location: /weshare/login");
        exit;
    }
}

function onlyPosterAndAdmincanAccess()
{
    $auth = new Auth();
    if ($auth->is_logged_in()) {
        if ($_SESSION['role_id'] != 1 && $_SESSION['role_id'] != 3) {
            header("Location: /weshare/admin/include/permission_denied");
            exit;
        }
    } else {
        header("Location: /weshare/login");
        exit;
    }
}

?>
