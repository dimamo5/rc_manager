<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
<div class="container-fluid">
    <div class="navbar-header.php">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php">RC Manager</a>
    </div>
    <div class="navbar-collapse collapse" style=\"height: 1px;\">
    <ul class="nav navbar-nav navbar-right">
    <li><a href="index.php">Dashboard</a></li>
    <li><a href="">Settings</a></li>
    <li><a href=""><?php echo $username ?></a></li>
    <li><a href="logout.php">Logout</a></li>
    </ul>
    <form action="index.php?q=all" method="post" class="navbar-form navbar-right">
    <input name="q" type="text" class="form-control" placeholder="Search...">
    </form>
</div>
</div>
</div>