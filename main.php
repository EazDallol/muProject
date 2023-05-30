<?php
include 'dp.php';
$database = new database();
$database->createDbConnection();
if($_SERVER['REQUEST_METHOD']=="POST"){
    $name = $_POST["name"];
    $email = $_POST["email"];
    $database->insertNewStudent($name,$email,"");

}
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $name = $_POST["name"];
    $email = $_POST["email"];
    $myFile = $_FILES["image"];
    
    $database->updateStudent($name,$email,$myFile);
    }
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $id = $_POST["id"];
    $database->deleteStudent($id);
    }
    if(isset($_GET["id"])){
        $database->getStudentById($_GET["id"]);
    }else{
        $database->getAllStudents();
    }
   
?>