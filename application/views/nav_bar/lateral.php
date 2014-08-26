    <!--Barra Lateral-->
    <div class="col-sm-3 col-md-2 sidebar">
    <ul class="nav nav-sidebar">
    <li <?php if($type=='main') echo "class=\"active\"";?>><a href="index.php">DashBoard</a></li>
    <li <?php if($type=='clients') echo "class=\"active\"";?>><a href="clients.php">Clientes</a></li>
    <li <?php if($type=='cars') echo "class=\"active\"";?>><a href="cars.php">Veículos</a></li>
    <li <?php if($type=='work') echo "class=\"active\"";?>><a href="work.php">Reparações</a></li>
    <li <?php if($type=='workers') echo "class=\"active\"";?>><a href="workers.php">Empregados</a></li>
    <li <?php if($type=='files') echo "class=\"active\"";?>><a href="files.php">Ficheiros</a></li>
    </ul></div>