<?php
require '../connexion_to_db.php';

function get_user($username){
    global $conn;
    $line = null;
    try{
        //    Insert query
        $stmt = $conn->prepare("SELECT * FROM user WHERE username = :username");
        $stmt->execute(array('username'=>$username));
        //    Get result of query
        $line = $stmt->fetch();
        $stmt->closeCursor();
        if($line == null){
            return false;
        }

    }catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    return $line;
}
