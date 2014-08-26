<?php
require_once('func.php');
$conn = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
if (mysqli_connect_errno()) {
    die('CONNECTION ERROR:DATABASE NOT FOUND');
}

function safe_client_new()
{
    global $conn;
    if (isset($_POST['name'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $country = $_POST['country'];
        $phone = $_POST['phone'];
        $birthday = $_POST['birthday'];
        $query = "INSERT INTO clients (name,address,city,country,email,phone,birthday) ";
        $query .= "VALUES ('{$name}','{$address}','{$city}','{$country}','{$email}','{$phone}','{$birthday}');";
        echo $query;
        $result = mysqli_query($conn, $query);
        /*if(isset($result)){
            header.php('Location:clients.php?opt=show&id=')
        }*/
    }
}

function safe_client_edit($client_id)
{
    global $conn;
    $name = $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    echo $country;
    $phone = $_POST['phone'];
    $birthday = $_POST['birthday'];
    $query = "UPDATE clients SET name='{$name}', address='{$address}', city='{$city}', country='{$country}', email='{$email}', phone='{$phone}', birthday='{$birthday}' WHERE id='{$client_id}';";
    echo $query;
    $result = mysqli_query($conn, $query);
}

function delete_client($client_id)
{
    global $conn;
    $query = "DELETE FROM clients WHERE id='{$client_id}'";
    $result = mysqli_query($conn, $query);
}

function delete_car($car_id)
{
    global $conn;
    $query = "DELETE FROM cars WHERE id='{$car_id}'";
    $result = mysqli_query($conn, $query);
}

function delete_work($work_id)
{
    global $conn;
    $query = "DELETE FROM repair_work WHERE id='{$work_id}'";
    $result = mysqli_query($conn, $query);
    echo $query;
}

function delete_repair_desc($repair_desc_id)
{
    global $conn;
    $query = "DELETE FROM repair_desc WHERE id='{$repair_desc_id}'";
    $result = mysqli_query($conn, $query);
}

function delete_worker($worker_id)
{
    global $conn;
    $query = "DELETE FROM employer WHERE id='{$worker_id}'";
    $result = mysqli_query($conn, $query);
}

function safe_car_new($client_id)
{
    global $conn;
    $manufacturer = $_POST['manufacturer'];
    $model = $_POST['model'];
    $license_plate = $_POST['license_plate'];
    $color = $_POST['color'];
    $year = $_POST['year'];
    $query = "INSERT INTO cars (manufacturer,model,license_plate,color,year,client_id,last_change) ";
    $query .= "VALUES ('{$manufacturer}','{$model}','{$license_plate}','{$color}','{$year}','{$client_id}',CURDATE());";
    $result = mysqli_query($conn, $query);

}

function safe_car_edit($car_id)
{
    global $conn;
    $manufacturer = $_POST['manufacturer'];
    $model = $_POST['model'];
    $license_plate = $_POST['license_plate'];
    $color = $_POST['color'];
    $year = $_POST['year'];
    $query = "UPDATE cars SET manufacturer='{$manufacturer}', model='{$model}', license_plate='{$license_plate}', year='{$year}',color='{$color}', last_change=CURDATE() WHERE id='{$car_id}';";
    $result = mysqli_query($conn, $query);
}

function safe_work_new($car_id)
{
    global $conn;
    $type_work = $_POST['type_work'];
    $budget = $_POST['budget'];
    $obs = $_POST['obs'];
    $query = "INSERT INTO repair_work (type_work,budget,obs,car_id,date_begin()) ";
    $query .= "VALUES ('{$type_work}','{$budget}','{$obs}','{$car_id}',CURDATE())";
    $result = mysqli_query($conn, $query);
    $query2 = "UPDATE cars SET last_change=CURDATE() WHERE id={$car_id};";
    $result2 = mysqli_query($conn, $query2);
    echo $query;
    echo $query2;
}

function safe_work_edit($work_id)
{
    global $conn;
    $type_work = $_POST['type_work'];
    $budget = $_POST['budget'];
    $obs = $_POST['obs'];
    $query_car_id = "SELECT car_id FROM repair_work WHERE id ={$work_id};";
    $result_car_id = mysqli_query($conn, $query_car_id);
    $row_car_id = mysqli_fetch_assoc($result_car_id);
    $car_id = $row_car_id['car_id'];
    $query = "UPDATE repair_work SET type_work='{$type_work}',budget='{$budget}',obs='{$obs}' WHERE={$work_id} ";
    $result = mysqli_query($conn, $query);
    $query2 = "UPDATE cars SET last_change=CURDATE() WHERE id={$car_id};";
    $result2 = mysqli_query($conn, $query2);
    echo $query;
    echo $query2;
}

function safe_worker_new()
{
    global $conn;
    if (isset($_POST['name'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $country = $_POST['country'];
        $phone = $_POST['phone'];
        $birthday = $_POST['birthday'];
        $func = $_POST['func'];
        $contract = $_POST['contract'];
        $query = "INSERT INTO employer (name,address,city,country,email,phone,birthday,contract,func,status) ";
        $query .= "VALUES ('{$name}','{$address}','{$city}','{$country}','{$email}','{$phone}','{$birthday}','{$contract}','{$func}','1');";
        echo $query;
        $result = mysqli_query($conn, $query);
    }
}

function safe_worker_edit($worker_id)
{
    global $conn;
    $name = $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $contract = $_POST['contract'];
    $func = $_POST['func'];
    $phone = $_POST['phone'];
    $birthday = $_POST['birthday'];
    $query = "UPDATE employer SET name='{$name}', address='{$address}', city='{$city}', country='{$country}', email='{$email}', phone='{$phone}', birthday='{$birthday},func='{$func}',contract='{$contract}' WHERE id='{$worker_id}';";
    echo $query;
    $result = mysqli_query($conn, $query);
}


?>