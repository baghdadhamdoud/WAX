<?php
require '../connexion_to_db.php';

$offset = 1;
$limit = 10;

function get_tissues_from_db($offset, $limit){
    global $conn;
    $result = [];
    try{
        //    Insert query
        $stmt = $conn->prepare("SELECT id_tissu, label, prix_unit, path_photo, stocke_surface 
                                        FROM tissu, produit 
                                        WHERE id_produit_fk = id_produit 
                                        AND id_tissu BETWEEN :min AND :max ");
        $stmt->execute(array('min'=>$offset, 'max'=>$offset+$limit-1));
        //    Get result of query
        while($line = $stmt->fetch()){
            $result += [$line['id_tissu'] => ['label'=>$line['label'], 'prix_unit'=>$line['prix_unit'], 'path_photo'=>$line['path_photo'],
                'stocke_surface'=>$line['stocke_surface']]];
        }
        $stmt->closeCursor();
    }catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    return $result;
}

function get_clothes_from_db($offset, $limit, $sexe, $type){
    global $conn;
    $result = [];
    try{
        $stmt = $conn->prepare("SELECT id_vetement, label, sexe, type, article, taille, prix_vetement, path_photo, stocke_piece 
                                        FROM vetement, produit 
                                        WHERE id_produit_fk = id_produit 
                                        AND sexe ".$sexe." 
                                        AND type ".$type."
                                        AND id_vetement BETWEEN :min AND :max ");
        $stmt->execute(array('min'=>$offset, 'max'=>$offset+$limit-1));
        //    Get result of query
        while($line = $stmt->fetch()){
            $result += [$line['id_vetement'] => ['label'=>$line['label'], 'sexe'=>$line['sexe'], 'type'=>$line['type'],
                'article'=>$line['article'], 'taille'=>$line['taille'], 'prix_vetement'=>$line['prix_vetement'], 'path_photo'=>$line['path_photo']
				,'stocke_piece'=>$line['stocke_piece']]];
        }
        $stmt->closeCursor();
    }catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    return $result;
}

function get_types_of_clothes_from_db(){
    global $conn;
    $result = [];
    try{
        //    Insert query
        $stmt = $conn->prepare("SELECT DISTINCT type FROM vetement ORDER BY type");
        $stmt->execute();
        //    Get result of query
        while($line = $stmt->fetch(PDO::FETCH_ASSOC)){
            array_push($result, $line['type']);
        }
        $stmt->closeCursor();
    }catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    return $result;
}
