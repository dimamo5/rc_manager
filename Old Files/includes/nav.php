<?php

function nav_bar_clients($type, $id)
{
    $output = nav_bar('clients');
    if ($type == 'list') {
        $output .= "
          <ul class=\"nav nav-sidebar\">
            <li><a href=\"clients.php?opt=new\"><span class=\"glyphicon glyphicon-plus\"></span> Novo Cliente</a></li>
            <li><a href=\"clients.php?opt=search\"><span class=\"glyphicon glyphicon-search\"></span> Pesquisar</a></li>
          </ul>
        </div>";
    } else if ($type == 'show') {
        $output .= "
          <ul class=\"nav nav-sidebar\">
          <li><a href=\"cars.php?opt=new&id={$id}\"><span class=\"glyphicon glyphicon-plus\"></span> Adicinar Veiculo</a></li>
          <li><a href=\"\"><span class=\"glyphicon glyphicon-envelope\"></span> Enviar E-mail</a></li>
          <li><a href=\"clients.php?opt=search\"><span class=\"glyphicon glyphicon-search\"></span> Pesquisar</a></li>
          <li><a href=\"safe_data.php?opt=delete_client&id={$id}\"><span class=\"glyphicon glyphicon-remove\"></span> Eliminar Cliente</a></li>
          </ul>
        </div>";
    } else if ($type == 'search') {
        $output .= "<ul class=\"nav nav-sidebar\">
        <li><a href=\"clients.php?opt=search\"><span class=\"glyphicon glyphicon-search\"></span> Pesquisar</a></li>
        </ul></div>";
    }
    return $output;
}

function nav_bar_cars($type, $id)
{
    $output = nav_bar('cars');
    if ($type == 'list')
        $output .= "
          <ul class=\"nav nav-sidebar\">
            <li><a href=\"cars.php?opt=search\"><span class=\"glyphicon glyphicon-search\"></span> Pesquisar</a></li>
          </ul>
        </div>";
    else if ($type == 'show') {
        $output .= "<ul class=\"nav nav-sidebar\">
            <li><a href=\"cars.php?opt=search\"><span class=\"glyphicon glyphicon-search\"></span> Pesquisar</a></li>
            <li><a href=\"\"><span class=\"glyphicon glyphicon-print\"></span> Imprimir</a></li>
             <li><a href=\"safe_data.php?opt=delete_car&id=$id\"><span class=\"glyphicon glyphicon-remove\"></span> Eliminar Veiculo</a></li>
             <li><a href=\"work.php?opt=new&id={$id}\"><span class=\"glyphicon glyphicon-plus\"></span> Adicinar Reparação</a></li>
          </ul>
        </div>";
    }
    return $output;
}

function nav_bar_work($type, $id)
{
    $output = nav_bar('work');
    if ($type == 'show') {
        $output .= "<ul class=\"nav nav-sidebar\">
            <li><a href=\"\"><span class=\"glyphicon glyphicon-plus\"></span> Adicinar Descrição</a></li>
            <li><a href=\"\"><span class=\"glyphicon glyphicon-print\"></span> Imprimir</a></li>
            <li><a href=\"safe_data.php?opt=delete_work&id=$id\"><span class=\"glyphicon glyphicon-remove\"></span> Eliminar Reparação</a></li>

          </ul>
        </div>";
    }

    return $output;
}

function nav_bar_workers($type, $id)
{
    $output = nav_bar('workers');
    if ($type == 'list')
        $output .= "
          <ul class=\"nav nav-sidebar\">
            <li><a href=\"workers.php?opt=search\"><span class=\"glyphicon glyphicon-search\"></span> Pesquisar</a></li>
            <li><a href=\"workers.php?opt=new\"><span class=\"glyphicon glyphicon-plus\"></span> Novo Trabalhador</a></li>
          </ul>
        </div>";
    else if ($type == 'show') {
        $output .= "<ul class=\"nav nav-sidebar\">
            <li><a href=\"cars.php?opt=search\"><span class=\"glyphicon glyphicon-search\"></span> Pesquisar</a></li>
            <li><a href=\"\"><span class=\"glyphicon glyphicon-print\"></span> Imprimir</a></li>
             <li><a href=\"safe_data.php?opt=delete_worker&id={$id}\"><span class=\"glyphicon glyphicon-remove\"></span> Eliminar Empregado</a></li>
          </ul>
        </div>";
    }
    return $output;
}

function nav_bar($type)
{
    $output = "<div class=\"row\">
          <!--Barra Lateral-->
        <div class=\"col-sm-3 col-md-2 sidebar\">
          <ul class=\"nav nav-sidebar\">";
    if ($type == 'main') {
        $output .= "<li class=\"active\"><a href=\"index.php\">DashBoard</a></li>
            <li><a href=\"clients.php\">Clientes</a></li>
            <li><a href=\"cars.php\">Veículos</a></li>
            <li><a href=\"work.php\">Reparações</a></li>
            <li><a href=\"workers.php\">Empregados</a></li>
            <li><a href=\"money.php\">Finanças</a></li>
            <li><a href=\"photos.php\">Ficheiros</a></li>
          </ul></div>";
    } else if ($type == 'clients') {
        $output .= "
            <li><a href=\"index.php\">DashBoard</a></li>
            <li class=\"active\"><a href=\"clients.php\">Clientes</a></li>
            <li><a href=\"cars.php\">Veículos</a></li>
            <li><a href=\"work.php\">Reparações</a></li>
            <li><a href=\"workers.php\">Empregados</a></li>
            <li><a href=\"money.php\">Finanças</a></li>
            <li><a href=\"photos.php\">Ficheiros</a></li>
          </ul>";
    } else if ($type == 'cars') {
        $output .= "
            <li ><a href=\"index.php\">DashBoard</a></li>
            <li><a href=\"clients.php\">Clientes</a></li>
            <li class=\"active\"><a href=\"cars.php\">Veículos</a></li>
            <li><a href=\"work.php\">Reparações</a></li>
            <li><a href=\"workers.php\">Empregados</a></li>
            <li><a href=\"money.php\">Finanças</a></li>
            <li><a href=\"photos.php\">Ficheiros</a></li>
          </ul>";
    } else if ($type == 'work') {
        $output .= "
            <li ><a href=\"index.php\">DashBoard</a></li>
            <li><a href=\"clients.php\">Clientes</a></li>
            <li><a href=\"cars.php\">Veículos</a></li>
            <li class=\"active\"><a href=\"work.php\">Reparações</a></li>
            <li><a href=\"workers.php\">Empregados</a></li>
            <li><a href=\"money.php\">Finanças</a></li>
            <li><a href=\"photos.php\">Ficheiros</a></li>
          </ul>";
    } else if ($type == 'money') {
        $output .= "
            <li ><a href=\"index.php\">DashBoard</a></li>
            <li><a href=\"clients.php\">Clientes</a></li>
            <li><a href=\"cars.php\">Veículos</a></li>
            <li><a href=\"work.php\">Reparações</a></li>
            <li><a href=\"workers.php\">Empregados</a></li>
            <li class=\"active\"><a href=\"money.php\">Finanças</a></li>
            <li><a href=\"photos.php\">Ficheiros</a></li>
          </ul>";
    } else if ($type == 'photos') {
        $output .= "
            <li><a href=\"index.php\">DashBoard</a></li>
            <li><a href=\"clients.php\">Clientes</a></li>
            <li><a href=\"cars.php\">Veículos</a></li>
            <li><a href=\"work.php\">Reparações</a></li>
            <li><a href=\"workers.php\">Empregados</a></li>
            <li><a href=\"money.php\">Finanças</a></li>
            <li class=\"active\"><a href=\"photos.php\">Ficheiros</a></li>
          </ul>";
    } else if ($type == 'workers') {
        $output .= "
            <li><a href=\"index.php\">DashBoard</a></li>
            <li><a href=\"clients.php\">Clientes</a></li>
            <li><a href=\"cars.php\">Veículos</a></li>
            <li><a href=\"work.php\">Reparações</a></li>
            <li class=\"active\"><a href=\"workers.php\">Empregados</a></li>
            <li><a href=\"money.php\">Finanças</a></li>
            <li><a href=\"photos.php\">Ficheiros</a></li>
          </ul>";
    }
    return $output;
}

function nav_bar_top()
{
    $output = "
<div class=\"navbar navbar-inverse navbar-fixed-top\" role=\"navigation\">
    <div class=\"container-fluid\">
        <div class=\"navbar-header.php\">
            <button type=\"button\" class=\"navbar-toggle collapsed\" data-toggle=\"collapse\" data-target=\".navbar-collapse\">
                <span class=\"sr-only\">Toggle navigation</span>
                <span class=\"icon-bar\"></span>
                <span class=\"icon-bar\"></span>
                <span class=\"icon-bar\"></span>
            </button>
            <a class=\"navbar-brand\" href=\"index.php\">RC Manager</a>
        </div>
        <div class=\"navbar-collapse collapse\" style=\"height: 1px;\">
            <ul class=\"nav navbar-nav navbar-right\">
                <li><a href=\"index.php\">Dashboard</a></li>
                <li><a href=\"\">Settings</a></li>
                <li><a href=\"\">Profile</a></li>
                <li><a href=\"logout.php\">Logout</a></li>
            </ul>
            <form action=\"index.php?q=all\" method=\"post\" class=\"navbar-form navbar-right\">
                <input name=\"q\" type=\"text\" class=\"form-control\" placeholder=\"Search...\">
            </form>
        </div>
    </div>
</div>";

    echo $output;
}

?>