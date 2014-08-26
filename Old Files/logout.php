<?php
session_start();
require_once('includes/func.php');
if (isset($_SESSION['user_id'])) {
    logout();
    $_POST = array();
}

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]);

}
header('Location:login.php');
session_destroy();
?>