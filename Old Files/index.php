<?php
require_once('includes/func.php');
include_once('includes/nav.php');
session_start();
if (login_check()) {
    $user_id = $_SESSION['user_id'];
} else {
    redirect_to("login.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Diogo Moura">
    <link rel="shortcut icon" href="images/roda_icon.ico">

    <title>RC Manager</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/dashboard.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]>
    <script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="js/ie-emulation-modes-warning.js"></script>
    <style type="text/css"></style>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style id="holderjs-style" type="text/css"></style>
</head>

<body>

<!-- Barra do topo Preta-->
<?php nav_bar_top(); ?>

<div class="container-fluid">
    <?php $out = nav_bar('main');
    echo $out;
    ?>
    <!-- Area Principal-->
    <?php
    if (isset($_GET['q'])) {
        if ($_GET['q'] == 'all') {
            if (isset($_POST['q']))
                search_all($_POST['q']);
        }
    }
    ?>
</div>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/docs.min.js"></script>


</body>
</html>