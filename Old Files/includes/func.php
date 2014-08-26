<?php
define("HOST", "localhost"); // The host you want to connect to.
define("USER", "admin"); // The database username.
define("PASSWORD", "diogomoura"); // The database password.
define("DATABASE", "rc_database"); // The database name.
include_once('nav.php');

function redirect_to($path)
{
    header("Location:{$path}");
    exit;
}

function login($username, $password)
{
    $conn = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
    if (mysqli_connect_errno()) {
        die('CONNECTION ERROR:DATABASE NOT FOUND');
        return false;
    }
    $query = "SELECT * FROM members WHERE username='";
    $query .= $username . "';";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $password_db = $row['password'];
    $salt = $row['salt'];
    $user_id = $row['id'];
    mysqli_close($conn);

    $password = hash('sha512', $password . $salt);

    if ($password_db == $password) {
        $_SESSION['user_id'] = $user_id;
        $_SESSION['password'] = $password;
        return true;
    } else return false;

}

function login_check()
{
    if (isset($_SESSION['user_id'], $_SESSION['password'])) {
        $user_id = $_SESSION['user_id'];
        $password = $_SESSION['password'];
    } else return false;

    $conn = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
    if (mysqli_connect_errno()) {
        return false;
    }
    $query = "SELECT  password FROM members WHERE id=";
    $query .= $user_id . ";";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result);
    $password_db = $row['password'];

    if ($password === $password_db) {
        return true;
    } else {
        return false;
    }
    mysqli_close($conn);
}

function logout()
{
    $_SESSION = array();
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]);
    }
    session_destroy();
    header('Location:login.php');
}

function countries_list($country)
{
    $output = "";
    $country_list = array(
        'Afghanistan', 'Akrotiri', 'Albania', 'Algeria', 'American Samoa', 'Andorra', 'Anguilla', 'Antarctica', 'Antigua and Barbuda', 'Argentina',
        'Armenia', 'Aruba', 'Ashmore and Cartier Islands', 'Australia', 'Austria', 'Azerbaijan', 'Bahamas', 'Bahrain', 'Bangladesh', 'Barbados',
        'Bassas de India', 'Belarus', 'Belgium', 'Belize', 'Benin', 'Bermuda', 'Bhutan', 'Bolivia', 'Bosnia and Herzegovina', 'Botswanna', 'Bouvet Island',
        'Brazil', 'British Indian Ocean Territory', 'British Virgin Islands', 'Brunei', 'Bulgaria', 'Burkina Faso', 'Burma', 'Burundi', 'Cambodia', 'Cameroon',
        'Canada', 'Cape Verde', 'Cayman Islands', 'Central African Republic', 'Chad', 'Chile', 'China', 'Christmas Island', 'Clipperton Island',
        'Cocoas (Keeling) Islands', 'Colombia', 'Comoros', 'Congo (Democratic Republic)', 'Congo (Republic)', 'Cook Islands', 'Coral Sea Islands', 'Costa Rica',
        'Cote d\'lvoire', 'Croatia', 'Cuba', 'Cyprus', 'Czech Republic', 'Denmark', 'Dhekelia', 'Djibouti', 'Dominica', 'Dominican Republic',
        'Ecuador', 'Egypt', 'El Salvador', 'Equatorial Guinea', 'Eritrea', 'Estonia', 'Ethiopia', 'Europa Island', 'Falkland Islands (Islas Malvinas)',
        'Faroe Islands', 'Fiji', 'Finland', 'France', 'French Guinea', 'French Polynesia', 'French Southern and Antarctic Lands', 'Gabon', 'Gambia', 'Gaza Strip',
        'Georgia', 'Germany', 'Ghana', 'Gibraltar', 'Glorioso Islands', 'Greece', 'Greenland', 'Grenada', 'Guadeloupe', 'Guam', 'Guatemala', 'Guernsey', 'Guinea',
        'Guinea-Bissau', 'Guyana', 'Haiti', 'Heard Island and McDonald Islands', 'Holy See (Vatican City)', 'Honduras', 'Hong Kong', 'Hungary', 'Iceland', 'India',
        'Indonesia', 'Iran', 'Iraq', 'Ireland', 'Isle of Man', 'Israel', 'Italy', 'Jamaica', 'Jan Mayen', 'Japan', 'Jersey', 'Jordan', 'Juan de Nova Island',
        'Kazakhstan', 'Kenya', 'Kiribati', 'Korea (North)', 'Korea (South)', 'Kuwait', 'Kyrgyzstan', 'Laos', 'Latvia', 'Lebanon', 'Lesotho', 'Liberia', 'Libya',
        'Liechtenstein', 'Lithuania', 'Luxembourg', 'Macau', 'Macedonia', 'Madagascar', 'Malawi', 'Malaysia', 'Maldives', 'Mali', 'Malta', 'Marshall Islands',
        'Martinique', 'Mauritania', 'Mauritius', 'Mayotte', 'Mexico', 'Micronesia (Federated States)', 'Moldova', 'Monaco', 'Mongolia', 'Montserrat', 'Morocco',
        'Mozambique', 'Namibia', 'Nauru', 'Navassa Island', 'Nepal', 'Netherlands', 'Netherlands Antilles', 'New Caledonia', 'New Zealand', 'Nicaragua', 'Niger',
        'Nigeria', 'Niue', 'Norfolk Island', 'Northern Mariana Islands', 'Norway', 'Oman', 'Pakistan', 'Palau', 'Panama', 'Papua New Guinea', 'Paracel Islands',
        'Paraguay', 'Peru', 'Philippines', 'Pitcairn Islands', 'Poland', 'Portugal', 'Puerto Rico', 'Qatar', 'Reunion', 'Romania', 'Russia', 'Rwanda', 'Saint Helena',
        'Saint Kitts and Nevis', 'Saint Lucia', 'Saint Pierre and Miquelon', 'Saint Vincent and the Grenadines', 'Samoa', 'San Marino', 'Sao Tome and Principe',
        'Saudi Arabia', 'Senegal', 'Serbia and Montenegro', 'Seychelles', 'Sierra Leone', 'Singapore', 'Slovakia', 'Slovenia', 'Solomon Islands', 'Somalia',
        'South Africa', 'South Georgia and the South Sandwich Islands', 'Spain', 'Spratly Islands', 'Sri Lanka', 'Sudan', 'Suriname', 'Svalbard', 'Swaziland',
        'Sweden', 'Switzerland', 'Syria', 'Taiwan', 'Tajikistan', 'Tanzania', 'Thailand', 'Timor-Leste', 'Togo', 'Tokelau', 'Tonga', 'Trinidad and Tobago',
        'Tromelin Island', 'Tunisia', 'Turkey', 'Turkmenistan', 'Turks and Caicos Islands', 'Tuvalu', 'Uganda', 'Ukraine', 'United Arab Emirates', 'United Kingdom',
        'United States', 'Uruguay', 'Uzbekistan', 'Vanuatu', 'Venezuela', 'Vietnam', 'Virgin Islands', 'Wake Island', 'Wallis and Futuna', 'West Bank', 'Western Sahara',
        'Yemen', 'Zambia', 'Zimbabwe');
    for ($i = 0; $i < count($country_list); $i++) {
        if ($country == $country_list[$i]) {
            $output .= "<option name=\"{$country_list[$i]}\" selected value=\"{$country_list[$i]}\">{$country_list[$i]}</option>";
        } else
            $output .= "<option name=\"{$country_list[$i]}\" value=\"{$country_list[$i]}\">{$country_list[$i]}</option>";
    }
    return $output;
}

function type_repair_list($type)
{
    $output = null;
    $type_repair_array = array("res_tol" => "Restauração Total", "res_par" => "Restauração Parcial",
        "repair" => "Reparação", "man" => "Manutenção");
    foreach ($type_repair_array as $key => $value) {
        if ($type == $key) {
            $output .= "<option selected value=\"{$key}\">{$value}</option>";
        } else {
            $output .= "<option value=\"{$key}\">{$value}</option>";
        }
    }
    return $output;
}

function get_type_work($type)
{
    $type_repair_array = array("res_tol" => "Restauração Total", "res_par" => "Restauração Parcial",
        "repair" => "Reparação", "man" => "Manutenção");
    foreach ($type_repair_array as $key => $value) {
        if ($type == $key) {
            return $value;
        }
    }
}

function type_contract($type)
{
    $output = null;
    $type_contract_array = array("part_time" => "Contrato Temporario", "full_time" => "Contrato Permanente", "fired" => "Despedida",
        "est" => "Estagiario");
    foreach ($type_contract_array as $key => $value) {
        if ($type == $key) {
            $output .= "<option selected value=\"{$key}\">{$value}</option>";
        } else {
            $output .= "<option value=\"{$key}\">{$value}</option>";
        }
    }
    return $output;
}

function get_type_contract($type)
{
    $type_contract_array = array("part_time" => "Contrato Temporario", "full_time" => "Contrato Permanente", "fired" => "Despedida",
        "est" => "Estagiario");
    foreach ($type_contract_array as $key => $value) {
        if ($type == $key) {
            return $value;
        }
    }
}

function client_show_edit($client_id)
{
    $conn = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
    if (mysqli_connect_errno()) {
        die('CONNECTION ERROR:DATABASE NOT FOUND');
        return false;
    }
    $query = "SELECT * FROM clients WHERE id='{$client_id}'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result);
    $client_name = $row['name'];
    $address = $row['address'];
    $city = $row['city'];
    $country = $row['country'];
    $email = $row['email'];
    $phone = $row['phone'];
    $birthday = $row['birthday'];
    mysqli_close($conn);

    $output = nav_bar_clients('show', $client_id);
    $output .= "  <!-- Area Principal-->
                        <div class=\"col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main\">
                        <h1 class=\"page-header.php\">{$client_name}</h1>
                <form action=\"safe_data.php?opt=client_edit&id={$client_id}\" role=\"form\" method=\"post\">
                <div class=\"row\">
                    <div class=\"form-group col-md-3\">
                        <label for=\"name\">Nome</label>
                        <input type=\"text\" class=\"form-control\" name=\"name\" required id=\"name\" value=\"{$client_name}\"></div>
                    <div class=\"form-group col-md-3\">
                        <label for=\"email\">E-mail</label>
                        <input type=\"email\" class=\"form-control\" name=\"email\" id=\"email\" value=\"{$email}\"></div>
                    <div class=\"form-group col-md-2\">
                        <label for=\"phone\">Telemóvel</label>
                        <input type=\"tel\" class=\"form-control\" name=\"phone\" id=\"phone\" value=\"{$phone}\"></div>
                    <div class=\"form-group col-md-2\">
                        <label for=\"birthday\">Data Nascimento</label>
                        <input type=\"date\" class=\"form-control\" name=\"birthday\" id=\"birthday\" value=\"{$birthday}\"></div>
                    <div class=\"form-group col-md-2\">
                        <label for=\"photo\">Photo</label>
                        <img src=\"\" class=\"img-thumbnail img-responsive\" alt=\"Responsive image\"></div>
                    <div class=\"form-group col-md-6\">
                        <label for=\"address\">Address</label>
                        <input type=\"text\" class=\"form-control\" name=\"address\" id=\"address\" value=\"{$address}\"></div>
                    <div class=\"form-group col-md-2\">
                        <label for=\"city\">Cidade</label>
                        <input type=\"text\" class=\"form-control\" name=\"city\" id=\"city\" value=\"{$city}\"></div>
                    <div class=\"form-group col-md-2\">
                        <label for=\"country\">Pais</label>
                        <select class=\"form-control\" name=\"country\" id=\"country\">";
    $output .= countries_list($country);
    $output .= "</select></div></div>
                     <div class=\"row\">
                        <div class=\"form-group col-md-1\">
                        <button type=\"submit\" class=\"btn btn-default\">Submit</button></div>
                    </div></form>";
    echo $output;
    table_cars($client_id);
}

function client_show_new()
{
    $client_name = null;
    $address = null;
    $city = null;
    $country = null;
    $email = null;
    $phone = null;
    $birthday = null;
    $header = "Novo Cliente";
    $output = nav_bar('clients') . "</div>";
    $output .= "  <!-- Area Principal-->
                        <div class=\"col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main\">
                        <h1 class=\"page-header.php\">{$header}</h1>
                <form action=\"safe_data.php?opt=client_new\" role=\"form\" method=\"post\">
                <div class=\"row\">
                    <div class=\"form-group col-md-3\">
                        <label for=\"name\">Nome</label>
                        <input type=\"text\" class=\"form-control\" required name=\"name\" id=\"name\" value=\"{$client_name}\"></div>
                    <div class=\"form-group col-md-3\">
                        <label for=\"email\">E-mail</label>
                        <input type=\"email\" class=\"form-control\" name=\"email\" id=\"email\" value=\"{$email}\"></div>
                    <div class=\"form-group col-md-2\">
                        <label for=\"phone\">Telemóvel</label>
                        <input type=\"tel\" class=\"form-control\" name=\"phone\" id=\"phone\" value=\"{$phone}\"></div>
                    <div class=\"form-group col-md-2\">
                        <label for=\"birthday\">Data Nascimento</label>
                        <input type=\"date\" class=\"form-control\" name=\"birthday\" id=\"birthday\" value=\"{$birthday}\"></div>
                    <div class=\"form-group col-md-2\">
                        <label for=\"photo\">Photo</label>
                        <img src=\"\" class=\"img-thumbnail img-responsive\" alt=\"Responsive image\"></div>
                    <div class=\"form-group col-md-6\">
                        <label for=\"address\">Address</label>
                        <input type=\"text\" class=\"form-control\" name=\"address\" id=\"address\" value=\"{$address}\"></div>
                    <div class=\"form-group col-md-2\">
                        <label for=\"city\">Cidade</label>
                        <input type=\"text\" class=\"form-control\" name=\"city\" id=\"city\" value=\"{$city}\"></div>
                    <div class=\"form-group col-md-2\">
                        <label for=\"country\">Pais</label>
                        <select class=\"form-control\" name=\"country\" id=\"country\">";
    $output .= countries_list($country);
    $output .= "</select></div></div>
                     <div class=\"row\">
                        <div class=\"form-group col-md-1\">
                        <button type=\"submit\" class=\"btn btn-default\">Submit</button></div>
                    </div></form>";
    echo $output;
    table_cars(null);
}

function client_list()
{
    $conn = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
    if (mysqli_connect_errno()) {
        die('CONNECTION ERROR:DATABASE NOT FOUND');
        return false;
    }
    $query = "SELECT * FROM clients ORDER BY name ASC";
    $result = mysqli_query($conn, $query);
    $output = nav_bar_clients('list', null);
    $output .= "<div class=\"col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main\"><h2 class=\"sub-header.php\"><span class=\"glyphicon glyphicon-user\"></span> Clientes</h2>
          <div class=\"table-responsive\">
            <table class=\"table table-hover\">
              <thead>
                <tr>
                  <th>Nome</th>
                  <th>Cidade</th>
                  <th>Telemóvel</th>
                  <th>Informação</th>
                </tr>
              </thead>
              <tbody>";
    while ($row = mysqli_fetch_assoc($result)) {
        $client_id = $row['id'];
        $name_temp = $row['name'];
        $city_temp = $row['city'];
        $tel_temp = $row['phone'];
        $output .= "
              <tr>
                  <td>{$name_temp}</td>
                  <td>{$city_temp}</td>
                  <td>{$tel_temp}</td>
                  <td><a href=\"clients.php?opt=show&id={$client_id}\" type=\"button\" class=\"btn btn-info\">Info</a></td>
                </tr>";
    }
    $output .= '</tbody></table></div></div>';
    echo $output;
}

function client_search()
{
    $conn = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
    if (mysqli_connect_errno()) {
        die('CONNECTION ERROR:DATABASE NOT FOUND');
        return false;
    }

    $output = nav_bar_clients('search', null);
    $output .= "  <!-- Area Principal-->
                        <div class=\"col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main\">
                        <h1 class=\"page-header.php\">Pesquisa Cliente</h1>
                <form action=\"clients.php?opt=search\" method=\"post\" role=\"form\">
                <div class=\"row\">
                    <div class=\"form-group col-md-6\">
                        <label for=\"name\">Nome</label>
                        <input type=\"text\" class=\"form-control\" name=\"name\" id=\"name\"></div>
                    <div class=\"form-group col-md-3\">
                        <label for=\"city\">Cidade</label>
                        <input type=\"text\" class=\"form-control\" name=\"city\" id=\"city\"></div>
                    <div class=\"form-group col-md-1\">
                        <label for=\"pesquisar\"></label>
                        <button id=\"pesquisar\"type=\"submit\" class=\"btn btn-default\">Pesquisar</button></div></div></form>";

    if (isset($_POST['name'], $_POST['city'])) {
        $name = $_POST['name'];
        $city = $_POST['city'];
        $query = "SELECT * FROM clients WHERE name LIKE '%{$name}%' AND city LIKE '%{$city}%';";
        $result = mysqli_query($conn, $query);
        $output .= "<div class=\"table-responsive\">
            <table class=\"table table-hover\">
              <thead>
                <tr>
                  <th>Nome</th>
                  <th>Cidade</th>
                  <th>Telemóvel</th>
                  <th>Informação</th>
                </tr>
              </thead>
              <tbody>";
        //echo $query;
        if (!$result) {
            $output .= "</tbody></table>";
            $output .= '<h3 class="text-center">Não foram encontrados resultados!</h3></div>';
        } else while ($row = mysqli_fetch_assoc($result)) {
            $client_id = $row['id'];
            $name_temp = $row['name'];
            $city_temp = $row['city'];
            $tel_temp = $row['phone'];
            $output .= "
              <tr>
                  <td>{$name_temp}</td>
                  <td>{$city_temp}</td>
                  <td>{$tel_temp}</td>
                  <td><a href=\"clients.php?opt=show&id={$client_id}\" type=\"button\" class=\"btn btn-info\">Info</a></td>
                </tr>";
        }
    }
    echo $output;
}

function table_cars($client_id)
{
    $conn = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
    if (mysqli_connect_errno()) {
        die('CONNECTION ERROR:DATABASE NOT FOUND');
        return false;
    }
    $output = '<h2 class=\"sub-header.php\">Carros</h2>
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Marca</th>
                  <th>Modelo</th>
                  <th>Cor</th>
                  <th>Year</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>';
    $query = "SELECT * FROM cars WHERE client_id='{$client_id}'";
    $result = mysqli_query($conn, $query);
    if (!mysqli_num_rows($result)) {
        $output .= "</tbody></table>";
        $output .= '<h3 class="text-center">Não foram encontrados carros!</h3></div>';
        echo $output;
        exit;
    } else while ($row = mysqli_fetch_assoc($result)) {
        $manufacturer = $row['manufacturer'];
        $model = $row['model'];
        $color = $row['color'];
        $car_id = $row['id'];
        $year = $row['year'];
        $output .= "
                <tr>
                  <td>{$manufacturer}</td>
                  <td>{$model}</td>
                  <td>{$color}</td>
                  <td>{$year}</td>
                  <td><a href=\"cars.php?opt=show&id={$car_id}\" type=\"button\" class=\"btn btn-info\">Info</a></td>
                </tr>";
    }
    mysqli_close($conn);
    $output .= "</tbody></table></div>";
    echo $output;
}

function table_work($car_id)
{
    $conn = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
    if (mysqli_connect_errno()) {
        die('CONNECTION ERROR:DATABASE NOT FOUND');
        return false;
    }
    $output = '<h2 class=\"sub-header.php\">Reparações</h2>
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Estado</th>
                  <th>Tipo Reparação</th>
                  <th>Orçamento</th>
                  <th>Data Inicio</th>
                  <th>Data Fim</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>';
    $query = "SELECT * FROM repair_work WHERE car_id='{$car_id}'";
    $result = mysqli_query($conn, $query);
    if (!mysqli_num_rows($result)) {
        $output .= "</tbody></table>";
        $output .= '<h3 class="text-center">Não foram encontrados registos de reparações!</h3></div>';
        echo $output;
        exit;
    } else while ($row = mysqli_fetch_assoc($result)) {
        $work_id = $row['id'];
        $status = $row['status'];
        $type_work = get_type_work($row['type_work']);
        $budget = $row['budget'];
        $date_begin = $row['date_begin'];
        $date_end = $row['date_end'];
        if ($status)
            $status = "<span class=\"glyphicon glyphicon-refresh\"></span>";
        else
            $status = "<span class=\"glyphicon glyphicon-ok\"></span>";

        $output .= "
                <tr>
                  <td>{$status}</td>
                  <td>{$type_work}</td>
                  <td>{$budget}</td>
                  <td>{$date_begin}</td>
                  <td>{$date_end}</td>
                  <td><a href=\"work.php?opt=show&id={$work_id}\" type=\"button\" class=\"btn btn-info\">Info</a></td>
                </tr>";
    }
    mysqli_close($conn);
    $output .= "</tbody></table></div>";
    echo $output;
}

function table_work_desc($work_id)
{
    $conn = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
    if (mysqli_connect_errno()) {
        die('CONNECTION ERROR:DATABASE NOT FOUND');
        return false;
    }
    $output = '<h2 class=\"sub-header.php\">Descrição</h2>
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Estado</th>
                  <th>Descrição</th>
                  <th>Data Conclusão</th>
                  <th>Opção</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>';
    $query = "SELECT * FROM repair_desc WHERE id='{$work_id}'";
    $result = mysqli_query($conn, $query);
    if (!mysqli_num_rows($result)) {
        $output .= "</tbody></table>";
        $output .= '<h3 class="text-center">Não foram encontrados registos!</h3></div>';
        echo $output;
        exit;
    } else while ($row = mysqli_fetch_assoc($result)) {
        $status = $row['status'];
        $description = $row['description'];
        $date = $row['date'];
        if ($date == null)
            $date = "Trabalho ainda nao realizado";
        if ($status)
            $status = "<span class=\"glyphicon glyphicon-refresh\"></span>";
        else
            $status = "<span class=\"glyphicon glyphicon-ok\"></span>";

        $output .= "
                <tr>
                  <td>{$status}</td>
                  <td>{$description}</td>
                  <td>{$date}</td>
                  <td><a href=\"work.php?opt=show&id={$work_id}\" type=\"button\" class=\"btn btn-info\">Info</a></td>
                </tr>";
    }
    mysqli_close($conn);
    $output .= "</tbody></table></div>";
    echo $output;
}

function cars_list()
{
    $conn = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
    if (mysqli_connect_errno()) {
        die('CONNECTION ERROR:DATABASE NOT FOUND');
        return false;
    }
    $query = "SELECT * FROM cars ORDER BY last_change DESC;";
    $result = mysqli_query($conn, $query);
    $output = nav_bar_cars('list', null);
    $output .= "<div class=\"col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main\"><h2 class=\"sub-header.php\">Clientes</h2>
          <div class=\"table-responsive\">
            <table class=\"table table-hover\">
              <thead>
                <tr>
                  <th>Marca</th>
                  <th>Modelo</th>
                  <th>Cor</th>
                  <th>Proprietário</th>
                  <th>Informação</th>
                </tr>
              </thead>
              <tbody>";
    while ($row = mysqli_fetch_assoc($result)) {
        $car_id = $row['id'];
        $client_id = $row['client_id'];
        $manufacturer = $row['manufacturer'];
        $model = $row['model'];
        $color_temp = $row['color'];
        $query = "SELECT * FROM clients WHERE id='{$client_id}';";
        $result_temp = mysqli_query($conn, $query);
        $temp = mysqli_fetch_assoc($result_temp);
        $client_name = $temp['name'];
        $output .= "
              <tr>
                  <td>{$manufacturer}</td>
                  <td>{$model}</td>
                  <td>{$color_temp}</td>
                  <td>{$client_name}</td>
                  <td><a href=\"cars.php?opt=show&id={$car_id}\" type=\"button\" class=\"btn btn-info\">Info</a></td>
                </tr>";
    }
    $output .= '</tbody></table></div></div>';
    echo $output;
}

function cars_show_edit($car_id)
{
    $conn = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
    if (mysqli_connect_errno()) {
        die('CONNECTION ERROR:DATABASE NOT FOUND');
        return false;
    }
    $query = "SELECT * FROM cars WHERE id='{$car_id}';";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result);
    $manufacturer = $row['manufacturer'];
    $model = $row['model'];
    $color = $row['color'];
    $owner_id = $row['client_id'];
    $year = $row['year'];
    $license_plate = $row['license_plate'];

    $header = $manufacturer . " " . $model;

    $query_owner = "SELECT name FROM clients WHERE id='{$owner_id}';";
    $result_owner = mysqli_query($conn, $query_owner);
    $row_owner = mysqli_fetch_array($result_owner);
    $owner_name = $row_owner['name'];
    mysqli_close($conn);
    $output = nav_bar_cars('show', $car_id);
    $output .= "  <!-- Area Principal-->
                        <div class=\"col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main\">
                        <h1 class=\"page-header.php\">{$header}</h1>
                <form action=\"safe_data.php?opt=car_edit&id={$car_id}\" method=\"post\" role=\"form\">
                <div class=\"row\">
                    <div class=\"form-group col-md-3\">
                        <label for=\"manufacturer\">Marca</label>
                        <input type=\"text\" class=\"form-control\" required name=\"manufacturer\" id=\"manufacturer\" value=\"{$manufacturer}\"></div>
                    <div class=\"form-group col-md-3\">
                        <label for=\"model\">Model</label>
                        <input type=\"text\" class=\"form-control\" required name=\"model\" id=\"model\" value=\"{$model}\"></div>
                    <div class=\"form-group col-md-2\">
                        <label for=\"year\">Cor</label>
                        <input type=\"number\" min=\"1700\" max=\"2100\" name=\"year\" class=\"form-control\" id=\"year\" value=\"{$year}\"></div></div>
                     <div class=\"row\">
                        <div class=\"form-group col-md-3\">
                            <label for=\"color\">Color</label>
                            <input type=\"text\" class=\"form-control\" name=\"color\" id=\"color\" value=\"{$color}\"></div>
                        <div class=\"form-group col-md-3\">
                            <label for=\"license_plate\">Matricula</label>
                            <input type=\"text\" class=\"form-control\" name=\"license_plate\" id=\"license_plate\" value=\"{$license_plate}\"></div>
                        <div class=\"form-group col-md-3\">
                            <label for=\"owner\">Proprietário</label>
                            <input type=\"text\" class=\"form-control\" id=\"owner\" disabled value=\"{$owner_name}\"></div>
                        <div class=\"form-group col-md-1\">
                            <button type=\"submit\" class=\"btn btn-default\">Guardar</button></div>
                    </div></form>";
    echo $output;
    table_work($car_id);
}

function cars_show_new($client_id)
{
    $conn = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
    if (mysqli_connect_errno()) {
        die('CONNECTION ERROR:DATABASE NOT FOUND');
        return false;
    }
    $car_id = null;
    $manufacturer = null;
    $model = null;
    $header = "Novo Veiculo";
    $color = null;
    $year = null;
    $license_plate = null;
    $owner_name = null;

    $query_owner = "SELECT name FROM clients WHERE id='{$client_id}';";
    $result_owner = mysqli_query($conn, $query_owner);
    $row_owner = mysqli_fetch_array($result_owner);
    $owner_name = $row_owner['name'];

    $output = nav_bar('cars') . "</div>";
    $output .= "  <!-- Area Principal-->
                        <div class=\"col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main\">
                        <h1 class=\"page-header.php\">{$header}</h1>
                <form action=\"safe_data.php?opt=car_new&id={$client_id}\" role=\"form\" method=\"post\">
                <div class=\"row\">
                    <div class=\"form-group col-md-3\">
                        <label for=\"manufacturer\">Marca</label>
                        <input type=\"text\" class=\"form-control\" name=\"manufacturer\" required id=\"manufacturer\" value=\"{$manufacturer}\"></div>
                    <div class=\"form-group col-md-3\">
                        <label for=\"model\">Model</label>
                        <input type=\"text\" class=\"form-control\" name=\"model\" required id=\"model\" value=\"{$model}\"></div>
                    <div class=\"form-group col-md-2\">
                        <label for=\"year\">Ano</label>
                        <input type=\"number\" min=\"1700\" max=\"2100\" name=\"year\" class=\"form-control\" id=\"year\" value=\"{$year}\"></div></div>
                     <div class=\"row\">
                        <div class=\"form-group col-md-3\">
                            <label for=\"color\">Color</label>
                            <input type=\"text\" class=\"form-control\" name=\"color\" id=\"color\" value=\"{$color}\"></div>
                        <div class=\"form-group col-md-3\">
                            <label for=\"license_plate\">Matricula</label>
                            <input type=\"text\" class=\"form-control\" name=\"license_plate\" id=\"license_plate\" value=\"{$license_plate}\"></div>
                        <div class=\"form-group col-md-3\">
                            <label for=\"owner\">Proprietario</label>
                            <input type=\"text\" class=\"form-control\" id=\"owner\" disabled value=\"{$owner_name}\"></div>
                        <div class=\"form-group col-md-1\">
                            <button type=\"submit\" class=\"btn btn-default\">Guardar</button></div>
                    </div></form>";
    echo $output;
    table_work($car_id);
}

function work_list()
{
    $conn = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
    if (mysqli_connect_errno()) {
        die('CONNECTION ERROR:DATABASE NOT FOUND');
        return false;
    }
    $query = "SELECT * FROM repair_work ORDER BY status ASC;";
    $result = mysqli_query($conn, $query);
    $output = nav_bar('work') . "</div>";
    $output .= "<div class=\"col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main\"><h2 class=\"sub-header.php\">Reparações</h2>
          <div class=\"table-responsive\">
            <table class=\"table table-hover\">
              <thead>
                <tr>
                  <th>Status</th>
                  <th>Tipo Reparaçao</th>
                  <th>Data Inicio</th>
                  <th>Data Final</th>
                  <th>Carro</th>
                  <th>Proprietário</th>
                </tr>
              </thead>
              <tbody>";
    while ($row = mysqli_fetch_assoc($result)) {
        $work_id = $row['id'];
        $car_id = $row['car_id'];
        $status = $row['status'];
        $type_work = get_type_work($row['type_work']);
        $date_begin = $row['date_begin'];
        if ($status) {
            $date_end = $row['date_end'];
        } else $date_end = "Reparação em execução";
        $query_car = "SELECT * FROM cars WHERE id='{$car_id}';";
        $result_car = mysqli_query($conn, $query_car);
        $row_car = mysqli_fetch_assoc($result_car);
        $car_manufacturer = $row_car['manufacturer'];
        $car_model = $row_car['model'];
        $owner_id = $row_car['client_id'];
        $query_client = "SELECT * FROM clients WHERE id='{$owner_id}';";
        $result_client = mysqli_query($conn, $query_client);
        $row_client = mysqli_fetch_assoc($result_client);
        $client_name = $row_client['name'];
        $vehicle = $car_manufacturer . " " . $car_model;
        if ($status)
            $status = "<span class=\"glyphicon glyphicon-ok\"></span>";
        else
            $status = "<span class=\"glyphicon glyphicon-refresh\"></span>";
        $output .= "
              <tr>
                  <td>{$status}</td>
                  <td>{$type_work}</td>
                  <td>{$date_begin}</td>
                  <td>{$date_end}</td>
                  <td>{$vehicle}</td>
                  <td>($client_name)</td>
                  <td><a href=\"work.php?opt=show&id={$work_id}\" type=\"button\" class=\"btn btn-info\">Info</a></td>
                </tr>";
    }
    $output .= '</tbody></table></div></div>';
    echo $output;
}

function work_show_edit($work_id)
{
    $conn = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
    if (mysqli_connect_errno()) {
        die('CONNECTION ERROR:DATABASE NOT FOUND');
        return false;
    }
    $query = "SELECT * FROM repair_work WHERE id='{$work_id}';";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result);
    $status = $row['status'];
    $car_id = $row['car_id'];
    $type_work = $row['type_work'];
    $budget = $row['budget'];
    $date_begin = $row['date_begin'];
    $date_end = $row['date_end'];
    $obs = $row['obs'];
    $query_car = "SELECT * FROM cars WHERE id='{$car_id}';";
    $result_car = mysqli_query($conn, $query_car);
    $row_car = mysqli_fetch_array($result_car);
    mysqli_close($conn);
    $manufacturer = $row_car['manufacturer'];
    $model = $row_car['model'];
    $header = "Reparação {$manufacturer} {$model}";
    $car = $manufacturer . " " . $model;
    $output = nav_bar_work('show', $work_id);

    $output .= "  <!-- Area Principal-->
                <div class=\"col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main\">
                <h1 class=\"page-header.php\">{$header}</h1>
                <form action=\"safe_data.php?opt=work_edit&id={$work_id}\" method=\"post\" role=\"form\">
                <div class=\"row\">
                    <div class=\"form-group col-md-3\">
                        <label for=\"type_work\">Tipo de Reparação</label>
                        <select class=\"form-control\" name=\"type_work\" id=\"type_work\">";
    $output .= type_repair_list($type_work);
    $output .= "</select></div><div class=\"form-group col-md-3\">
                        <label for=\"budget\">Orçamento</label>
                        <input type=\"text\" name=\"budget\" class=\"form-control\" id=\"budget\" value=\"{$budget}\"></div>
                    <div class=\"form-group col-md-2\">
                        <label for=\"year\">Obs</label>
                        <input type=\"text\" name=\"obs\" class=\"form-control\" id=\"year\" value=\"{$obs}\"></div></div>
                     <div class=\"row\">
                        <!-- METER DATA INICIO AUTOMATICA-->
                        <div class=\"form-group col-md-3\">
                            <label for=\"data_begin\">Data Inicio</label>
                            <input type=\"date\" class=\"form-control\" id=\"date_begin\" disabled value=\"{$date_begin}\"></div>
                        <div class=\"form-group col-md-3\">
                            <label for=\"date_end\">Data Fim</label>
                            <input type=\"date\" class=\"form-control\" id=\"date_end\" disabled value=\"{$date_end}\"></div>
                        <div class=\"form-group col-md-3\">
                            <label for=\"owner\">Carro</label>
                            <input type=\"text\" class=\"form-control\" id=\"owner\" disabled value=\"{$car}\"></div>
                        <div class=\"form-group col-md-1\">
                            <button type=\"submit\" class=\"btn btn-default\">Guardar</button></div>
                    </div></form>";
    echo $output;
    table_work_desc($work_id);
}

function work_show_new($car_id)
{
    $conn = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
    if (mysqli_connect_errno()) {
        die('CONNECTION ERROR:DATABASE NOT FOUND');
        return false;
    }
    $work_id = null;
    $status = null;
    $budget = null;
    $type_work = null;
    $budget = null;
    $date_begin = null;
    $date_end = null;
    $manufacturer = null;
    $model = null;
    $obs = null;

    $query_car = "SELECT * FROM cars WHERE id='{$car_id}';";
    $result_car = mysqli_query($conn, $query_car);
    $row_car = mysqli_fetch_array($result_car);
    $manufacturer = $row_car['manufacturer'];
    $model = $row_car['model'];
    $header = "Reparação {$manufacturer} {$model}";
    $output = nav_bar('work') . "</div>";
    $car = $manufacturer . " " . $model;

    $output .= "  <!-- Area Principal-->
                <div class=\"col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main\">
                <h1 class=\"page-header.php\">{$header}</h1>
                <form action=\"safe_data.php?opt=work_new&id={$car_id}\"  method=\"post\" role=\"form\">
                <div class=\"row\">
                    <div class=\"form-group col-md-3\">
                        <label for=\"type_work\">Tipo de Reparação</label>
                        <select class=\"form-control\" name=\"type_work\" id=\"type_work\">";
    $output .= type_repair_list($type_work);
    $output .= "</select></div><div class=\"form-group col-md-3\">
                        <label for=\"budget\">Orçamento</label>
                        <input type=\"text\" name=\"budget\" class=\"form-control\" id=\"budget\" value=\"{$budget}\"></div>
                    <div class=\"form-group col-md-2\">
                        <label for=\"year\">Obs</label>
                        <input type=\"text\" name=\"obs\" class=\"form-control\" id=\"year\" value=\"{$obs}\"></div></div>
                     <div class=\"row\">
                        <!-- METER DATA INICIO AUTOMATICA-->
                        <div class=\"form-group col-md-3\">
                            <label for=\"data_begin\">Data Inicio</label>
                            <input type=\"date\" class=\"form-control\" id=\"date_end\" disabled value=\"{$date_begin}\"></div>
                        <div class=\"form-group col-md-3\">
                            <label for=\"date_end\">Data Fim</label>
                            <input type=\"date\" class=\"form-control\" id=\"date_begin\" disabled value=\"{$date_end}\"></div>
                        <div class=\"form-group col-md-3\">
                            <label for=\"owner\">Carro</label>
                            <input type=\"text\" class=\"form-control\" id=\"owner\" disabled value=\"{$car}\"></div>
                        <div class=\"form-group col-md-1\">
                            <button type=\"submit\" class=\"btn btn-default\">Guardar</button></div>
                    </div></form>";
    echo $output;
    table_work_desc($work_id);

}

function workers_list()
{
    $conn = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
    if (mysqli_connect_errno()) {
        die('CONNECTION ERROR:DATABASE NOT FOUND');
        return false;
    }
    $query = "SELECT * FROM employer ORDER BY name ASC";
    $result = mysqli_query($conn, $query);
    $output = nav_bar_workers('list', null);
    $output .= "<div class=\"col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main\"><h2 class=\"sub-header.php\"><span class=\"glyphicon glyphicon-user\"></span> Empregados</h2>
          <div class=\"table-responsive\">
            <table class=\"table table-hover\">
              <thead>
                <tr>
                  <th>Nome</th>
                  <th>Funções</th>
                  <th>E-Mail</th>
                  <th>Contrato</th>
                </tr>
              </thead>
              <tbody>";
    while ($row = mysqli_fetch_assoc($result)) {
        $worker_id = $row['id'];
        $worker_name = $row['name'];
        $worker_func = $row['func'];
        $worker_email = $row['email'];
        $worker_contract = get_type_contract($row['contract']);
        $output .= "
              <tr>
                  <td>{$worker_name}</td>
                  <td>{$worker_func}</td>
                  <td>{$worker_email}</td>
                  <td>{$worker_contract}</td>
                  <td><a href=\"workers.php?opt=show&id={$worker_id}\" type=\"button\" class=\"btn btn-info\">Info</a></td>
                </tr>";
    }
    $output .= '</tbody></table></div></div>';
    echo $output;
}

function workers_show_edit($worker_id)
{
    $conn = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
    if (mysqli_connect_errno()) {
        die('CONNECTION ERROR:DATABASE NOT FOUND');
        return false;
    }
    $query = "SELECT * FROM employer WHERE id='{$worker_id}';";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result);
    $name = $row['name'];
    $contract = $row['contract'];
    $address = $row['address'];
    $city = $row['city'];
    $country = $row['country'];
    $phone = $row['phone'];
    $birthday = $row['birthday'];
    $email = $row['email'];
    $func = $row['func'];
    $header = $name;
    mysqli_close($conn);
    $output = nav_bar_workers('show', $worker_id);
    $output .= "<div class=\"col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main\">
                        <h1 class=\"page-header.php\">{$header}</h1>
                <form action=\"safe_data.php?opt=worker_edit&id={$worker_id}\" role=\"form\" method=\"post\">
                <div class=\"row\">
                    <div class=\"form-group col-md-3\">
                        <label for=\"name\">Nome</label>
                        <input type=\"text\" class=\"form-control\" required name=\"name\" id=\"name\" value=\"{$name}\"></div>
                    <div class=\"form-group col-md-3\">
                        <label for=\"email\">E-mail</label>
                        <input type=\"email\" class=\"form-control\" name=\"email\" id=\"email\" value=\"{$email}\"></div>
                    <div class=\"form-group col-md-2\">
                        <label for=\"phone\">Telemóvel</label>
                        <input type=\"tel\" class=\"form-control\" name=\"phone\" id=\"phone\" value=\"{$phone}\"></div>
                    <div class=\"form-group col-md-2\">
                        <label for=\"birthday\">Data Nascimento</label>
                        <input type=\"date\" class=\"form-control\" name=\"birthday\" id=\"birthday\" value=\"{$birthday}\"></div>
                    <div class=\"form-group col-md-2\">
                        <label for=\"photo\">Photo</label>
                        <img src=\"\" class=\"img-thumbnail img-responsive\" alt=\"Responsive image\"></div>
                    <div class=\"form-group col-md-6\">
                        <label for=\"address\">Address</label>
                        <input type=\"text\" class=\"form-control\" name=\"address\" id=\"address\" value=\"{$address}\"></div>
                    <div class=\"form-group col-md-2\">
                        <label for=\"city\">Cidade</label>
                        <input type=\"text\" class=\"form-control\" name=\"city\" id=\"city\" value=\"{$city}\"></div>
                    <div class=\"form-group col-md-2\">
                        <label for=\"country\">Pais</label>
                        <select class=\"form-control\" name=\"country\" id=\"country\">";
    $output .= countries_list($country);
    $output .= "</select></div></div>
                     <div class=\"row\">
                     <div class=\"form-group col-md-3\">
                        <label for=\"func\">Funções</label>
                        <input type=\"text\" class=\"form-control\" name=\"func\" id=\"func\" value=\"{$func}\"/></div>
                     <div class=\"form-group col-md-3\">
                        <label for=\"contract\">Contrato</label>
                        <select class=\"form-control\" name=\"contract\" id=\"contract\">";
    $output .= type_contract($contract);
    $output .= "</select></div>
                <div class=\"form-group col-md-1\">
                        <button type=\"submit\" class=\"btn btn-default\">Submit</button></div>
                    </div></form>";
    echo $output;
}

function workers_show_new()
{
    $conn = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
    if (mysqli_connect_errno()) {
        die('CONNECTION ERROR:DATABASE NOT FOUND');
        return false;
    }
    $name = null;
    $contract = null;
    $address = null;
    $city = null;
    $country = null;
    $phone = null;
    $birthday = null;
    $email = null;
    $func = null;
    $header = "Novo Trabalhador";
    mysqli_close($conn);
    $output = nav_bar('workers') . "</div>";
    $output .= "<div class=\"col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main\">
                        <h1 class=\"page-header.php\">{$header}</h1>
                <form action=\"safe_data.php?opt=worker_new\" role=\"form\" method=\"post\">
                <div class=\"row\">
                    <div class=\"form-group col-md-3\">
                        <label for=\"name\">Nome</label>
                        <input type=\"text\" class=\"form-control\" required name=\"name\" id=\"name\" value=\"{$name}\"></div>
                    <div class=\"form-group col-md-3\">
                        <label for=\"email\">E-mail</label>
                        <input type=\"email\" class=\"form-control\" name=\"email\" id=\"email\" value=\"{$email}\"></div>
                    <div class=\"form-group col-md-2\">
                        <label for=\"phone\">Telemóvel</label>
                        <input type=\"tel\" class=\"form-control\" name=\"phone\" id=\"phone\" value=\"{$phone}\"></div>
                    <div class=\"form-group col-md-2\">
                        <label for=\"birthday\">Data Nascimento</label>
                        <input type=\"date\" class=\"form-control\" name=\"birthday\" id=\"birthday\" value=\"{$birthday}\"></div>
                    <div class=\"form-group col-md-2\">
                        <label for=\"photo\">Photo</label>
                        <img src=\"\" class=\"img-thumbnail img-responsive\" alt=\"Responsive image\"></div>
                    <div class=\"form-group col-md-6\">
                        <label for=\"address\">Address</label>
                        <input type=\"text\" class=\"form-control\" name=\"address\" id=\"address\" value=\"{$address}\"></div>
                    <div class=\"form-group col-md-2\">
                        <label for=\"city\">Cidade</label>
                        <input type=\"text\" class=\"form-control\" name=\"city\" id=\"city\" value=\"{$city}\"></div>
                    <div class=\"form-group col-md-2\">
                        <label for=\"country\">Pais</label>
                        <select class=\"form-control\" name=\"country\" id=\"country\">";
    $output .= countries_list($country);
    $output .= "</select></div></div>
                     <div class=\"row\">
                     <div class=\"form-group col-md-3\">
                        <label for=\"func\">Funções</label>
                        <input type=\"text\" class=\"form-control\" name=\"func\" id=\"func\" value=\"{$func}\"/></div>
                     <div class=\"form-group col-md-3\">
                        <label for=\"contract\">Contrato</label>
                        <select class=\"form-control\" name=\"contract\" id=\"contract\">";
    $output .= type_contract($contract);
    $output .= "</select></div>
                <div class=\"form-group col-md-1\">
                        <button type=\"submit\" class=\"btn btn-default\">Submit</button></div>
                    </div></form>";
    echo $output;

}

function search_all($q)
{
    $conn = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
    if (mysqli_connect_errno()) {
        die('CONNECTION ERROR:DATABASE NOT FOUND');
        return false;
    }
    //caso esteja vazio
    if (empty($q)) {
        $query = "SELECT * FROM repair_work WHERE status='0'";
        $result = mysqli_query($conn, $query);
        $output = "<div class=\"col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main\"><h2 class=\"sub-header.php\">Reparações</h2>
          <div class=\"table-responsive\">
            <table class=\"table table-hover\">
              <thead>
                <tr>
                  <th>Status</th>
                  <th>Tipo Reparaçao</th>
                  <th>Data Inicio</th>
                  <th>Data Final</th>
                  <th>Carro</th>
                  <th>Proprietário</th>
                </tr>
              </thead>
              <tbody>";
        while ($row = mysqli_fetch_assoc($result)) {
            $work_id = $row['id'];
            $car_id = $row['car_id'];
            $status = $row['status'];
            $type_work = get_type_work($row['type_work']);
            $date_begin = $row['date_begin'];
            if ($status) {
                $date_end = $row['date_end'];
            } else $date_end = "Reparação em execução";
            $query_car = "SELECT * FROM cars WHERE id='{$car_id}';";
            $result_car = mysqli_query($conn, $query_car);
            $row_car = mysqli_fetch_assoc($result_car);
            $car_manufacturer = $row_car['manufacturer'];
            $car_model = $row_car['model'];
            $owner_id = $row_car['client_id'];
            $query_client = "SELECT * FROM clients WHERE id='{$owner_id}';";
            $result_client = mysqli_query($conn, $query_client);
            $row_client = mysqli_fetch_assoc($result_client);
            $client_name = $row_client['name'];
            $vehicle = $car_manufacturer . " " . $car_model;
            if ($status)
                $status = "<span class=\"glyphicon glyphicon-ok\"></span>";
            else
                $status = "<span class=\"glyphicon glyphicon-refresh\"></span>";
            $output .= "
              <tr>
                  <td>{$status}</td>
                  <td>{$type_work}</td>
                  <td>{$date_begin}</td>
                  <td>{$date_end}</td>
                  <td>{$vehicle}</td>
                  <td>($client_name)</td>
                  <td><a href=\"work.php?opt=show&id={$work_id}\" type=\"button\" class=\"btn btn-info\">Info</a></td>
                </tr>";
        }
        $output .= '</tbody></table></div></div>';
    } else if (isset($q)) {
        $name = $q;
        $query = "SELECT * FROM clients WHERE name LIKE '%{$name}%';";
        $result = mysqli_query($conn, $query);
        $output = "<div class=\"col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main\"><h2 class=\"sub-header.php\">Resultados</h2>
<div class=\"table-responsive\">
            <table class=\"table table-hover\">
              <thead>
                <tr>
                  <th>Nome</th>
                  <th>Cidade</th>
                  <th>Telemóvel</th>
                  <th>Informação</th>
                </tr>
              </thead>
              <tbody>";
        if (!mysqli_num_rows($result)) {
            $output .= "</tbody></table>";
            $output .= '<h3 class="text-center">Não foram encontrados resultados!</h3></div></div>';
        } else while ($row = mysqli_fetch_assoc($result)) {
            $client_id = $row['id'];
            $name_temp = $row['name'];
            $city_temp = $row['city'];
            $tel_temp = $row['phone'];
            $output .= "
              <tr>
                  <td>{$name_temp}</td>
                  <td>{$city_temp}</td>
                  <td>{$tel_temp}</td>
                  <td><a href=\"clients.php?opt=show&id={$client_id}\" type=\"button\" class=\"btn btn-info\">Info</a></td>
                </tr>";
        }
    }

    echo $output;
}

?>