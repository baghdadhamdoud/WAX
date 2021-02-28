<?php
require '../connexion_to_db.php';

function get_wilayas_from_db(){
    global $conn;
    $wilayas = null;
    try{
        $stmt = $conn->prepare("SELECT * FROM wilaya ORDER BY code_wilaya");
        $stmt->execute(array());
        $wilayas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
    }catch(PDOException $e) {
        echo json_encode(["Connection failed: " =>$e->getMessage()]);
    }
    return $wilayas;
}

function get_dairas_from_db($id_wilaya){
    global $conn;
    $dairas = null;
    try{
        $stmt = $conn->prepare("SELECT * FROM `daira` WHERE daira.id_wilaya = :id_wilaya ORDER BY daira.code_daira");
        $stmt->execute(array('id_wilaya'=>$id_wilaya));
        $dairas = $stmt->fetchAll();
        $stmt->closeCursor();
    }catch(PDOException $e) {
        echo json_encode(["Connection failed: " =>$e->getMessage()]);
    }
    return $dairas;
}

function get_communes_from_db($id_daira){
    global $conn;
    $communes = null;
    try{
        $stmt = $conn->prepare("SELECT * FROM `commune` WHERE commune.id_daira = :id_daira ORDER BY commune.code_commune");
        $stmt->execute(array('id_daira'=>$id_daira));
        $communes = $stmt->fetchAll();
        $stmt->closeCursor();
    }catch(PDOException $e) {
        echo json_encode(["Connection failed: " =>$e->getMessage()]);
    }
    return $communes;
}

function update_phone_number($tel){
    global $conn;
    try{
        $stmt = $conn->prepare("UPDATE user SET telephone=:tel WHERE id_user=:id_user");
        $stmt->execute(array('tel'=>$tel, 'id_user'=>$_SESSION['id_user']));
        $stmt->closeCursor();
    }catch(PDOException $e) {
        echo json_encode(["Connection failed: " =>$e->getMessage()]);
    }
    return true;
}

function insert_commandes_tissues($tissues, $id_user_fk, $date, $heure, $id_adresse_fk){
    global $conn;
    foreach ($tissues as $id => $tissue) {
        try {
            $stmt = $conn->prepare("insert into commander_tissu (id_tissu_fk, id_user_fk, date, heure, surface, prix, id_adresse_fk) 
                values (:id_tissu_fk, :id_user_fk, :date, :heure, :surface, :prix, :id_adresse_fk)");
            $stmt->execute(array('id_tissu_fk' => $id, 'id_user_fk' => $id_user_fk,
                                'date' => $date, 'heure' => $heure,
                                'surface' => $tissue['surface'], 'prix' => $tissue['price'],
                                'id_adresse_fk' => $id_adresse_fk));
            $stmt->closeCursor();
        } catch (PDOException $e) {
            echo json_encode(["Connection failed: " =>$e->getMessage()]);
        }
    }
    return true;
}

function insert_commandes_clothes($clothes, $id_user_fk, $date, $heure, $id_adresse_fk){
    global $conn;
    foreach ($clothes as $id => $clothe) {
        try {
            $stmt = $conn->prepare("insert into commander_vetement (id_vetement_fk, id_user_fk, date, heure, taille, qtt, prix, id_adresse_fk) 
                values (:id_vetement_fk, :id_user_fk, :date, :heure, :taille, :qtt, :prix, :id_adresse_fk)");
            $stmt->execute(array('id_vetement_fk' => $id, 'id_user_fk' => $id_user_fk,
                'date' => $date, 'heure' => $heure,
                'taille' => $clothe['taille'], 'qtt' => $clothe['qtt'], 'prix' => $clothe['price'],
                'id_adresse_fk' => $id_adresse_fk));
            $stmt->closeCursor();
        } catch (PDOException $e) {
            echo json_encode(["Connection failed: " =>$e->getMessage()]);
        }
    }
    return true;
}