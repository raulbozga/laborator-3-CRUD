

<?php

session_start();
// aici ne conectam la baza de date 

$mysqli = new mysqli('localhost', 'root', 'parola123', 'crud') or die(mysqli_error($mysqli));

$id = 0;
$update = false;        //aici declaram variabilele
$nume = '';
$adresa = '';

//aici verificam daca butonul a fost apasat 
if (isset($_POST['save'])) {
    $nume = $_POST['nume']; //aici stocam numele si adresa in variabile 
    $adresa = $_POST['adresa'];


    //aici inseram in baza de date cu ajutorul acestui query
    $mysqli->query("insert into data (nume, adresa) VALUES ('$nume','$adresa')") or

        die($mysqli->error);

    $_SESSION['message'] = "A fost adaugat !";  //aici afisam mesajul cum ca a fost adaugat
    $_SESSION['msg_type'] = "success";

    header("location: index.php"); //cu functia header facem ca actiunea sa se intample in index.php 
    //fara a ne trimite in proccess.php
}


//aici facem butonul delete cu metoda get 
if (isset($_GET['delete'])) {

    $id = $_GET['delete'];
    $mysqli->query("delete from data where id=$id") or die($mysqli->error);

    $_SESSION['message'] = "A fost sters !";
    $_SESSION['msg_type'] = "danger";
    header("location: index.php");
}

//aici facem butonul edit 
if (isset($_GET['edit'])) {

    $id = $_GET['edit'];

    $update = true;
    $result = $mysqli->query("select * from data where id=$id") or die($mysqli->error);

    //aici verifcam daca datele exista si
    //aici avem o bucla unde la apasarea butonului edit datele din
    //campul selectat vor aparea pentru a fi editate cua jutorul fetch_array
    if ($result) {

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
