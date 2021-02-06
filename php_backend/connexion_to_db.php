<?php
$conn = null;

function connexion_to_db(){
    global $conn;
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    try{
        // Connexion to database
        $conn = new PDO("mysql:host=$servername;dbname=wax_db", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}
connexion_to_db();