<?php
require_once('includes/safe.php');
session_start();
if (login_check()) {
    $user_id = $_SESSION['user_id'];
} else {
    header('Location:login.php');
}
if (!isset($_GET['opt'])) {
    die('ERROR');
}
$opt = $_GET['opt'];
if ($opt == 'client_new') {
    safe_client_new();
    redirect_to("clients.php?opt=list");
}
if ($opt == 'client_edit' && isset($_GET['id'])) {
    safe_client_edit($_GET['id']);
    redirect_to("clients.php?opt=show&id={$_GET['id']}");
}
if ($opt == 'car_new' && isset($_GET['id'])) {
    safe_car_new($_GET['id']);
    redirect_to("clients.php?opt=show&id={$_GET['id']}");
}
if ($opt == 'car_edit' && isset($_GET['id'])) {
    safe_car_edit($_GET['id']);
    redirect_to("cars.php?opt=show&id={$_GET['id']}");
}
if ($opt == 'work_edit' && isset($_GET['id'])) {
    safe_work_edit($_GET['id']);
    redirect_to("work.php?opt=show&id={$_GET['id']}");
}
if ($opt == 'work_new' && isset($_GET['id'])) {
    safe_work_new($_GET['id']);
    redirect_to("cars.php?opt=show&id={$_GET['id']}");
}
if ($opt == 'delete_client' && isset($_GET['id'])) {
    delete_client($_GET['id']);
    redirect_to("clients.php?opt=list");
}
if ($opt == 'delete_car' && isset($_GET['id'])) {
    delete_car($_GET['id']);
    redirect_to("cars.php?opt=list");
}
if ($opt == 'delete_work' && isset($_GET['id'])) {
    delete_work($_GET['id']);
    redirect_to("work.php?opt=list");
}
if ($opt == 'delete_work_desc' && isset($_GET['id'])) {
    delete_work_desc($_GET['id']);
    redirect_to("work.php?opt=show&id={$_GET['id']}");
}
if ($opt == 'worker_new') {
    safe_worker_new();
    redirect_to("woker.php?opt=list");
}
if ($opt == 'worker_edit' && isset($_GET['id'])) {
    safe_worker_edit($_GET['id']);
    redirect_to("worker.php?opt=show&id={$_GET['id']}");
}
if ($opt == 'delete_worker' && isset($_GET['id'])) {
    delete_worker($_GET['id']);
    redirect_to("workers.php?opt=list");
}
?>