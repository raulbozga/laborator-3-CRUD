

<?php

session_start();

$mysqli = new mysqli('localhost', 'root', 'parola123', 'crud') or die(mysqli_error($mysqli));

$id = 0;
$update = false;
$nume = '';
$adresa = '';

if (isset($_POST['save'])) {
    $nume = $_POST['nume'];
    $adresa = $_POST['adresa'];



    $mysqli->query("insert into data (nume, adresa) VALUES ('$nume','$adresa')") or

        die($mysqli->error);

    $_SESSION['message'] = "A fost adaugat !";
    $_SESSION['msg_type'] = "success";

    header("location: index.php");
}



if (isset($_GET['delete'])) {

    $id = $_GET['delete'];
    $mysqli->query("delete from data where id=$id") or die($mysqli->error);

    $_SESSION['message'] = "A fost sters !";
    $_SESSION['msg_type'] = "danger";
    header("location: index.php");
}


if (isset($_GET['edit'])) {

    $id = $_GET['edit'];

    $update = true;
    $result = $mysqli->query("select * from data where id=$id") or die($mysqli->error);

    if ($result) {
        // if (count($result) == 1) {
        $row = $result->fetch_array();
        $nume = $row['nume'];
        $adresa = $row['adresa'];
    }
}

if (isset($_POST['update'])) {

    $id = $_POST['id'];
    $nume = $_POST['nume'];
    $adresa = $_POST['adresa'];

    $mysqli->query("update data set nume='$nume',adresa='$adresa' where id=$id") or die($mysqli->error);

    $_SESSION['message'] = "modificat cu success!";
    $_SESSION['msg_type'] = "warning";

    header('location:index.php');
}


// if (!$mysqli) {

//     die(mysqli_error($mysqli));
// }
