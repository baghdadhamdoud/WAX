<?php
require '../connexion_to_db.php';

function check_label_on_db($label){
    global $conn;
    try{
        //    Insert query
        $stmt = $conn->prepare("select * from produit where label=:label");
        $stmt->execute(array('label'=>$label));
        //    Get result of query
        $line = $stmt->fetch();
        $stmt->closeCursor();
        if($line == null){
            return false;
        }
        return $line;
    }catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}

function set_new_label_on_db($label){
    global $conn;
    try{
        //    Insert query
        $stmt = $conn->prepare("insert into produit (label) values (:label)");
        $stmt->execute(array('label'=>$label));
        $stmt->closeCursor();
        $line = check_label_on_db($label);
        return $line['id_produit'];
    }catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}

function add_tissue_to_db($id_produit_fk, $prix_unit, $path_photo, $stocke_surface){
    global $conn;
    try{
        //    Insert query
        $stmt = $conn->prepare("insert into tissu (id_produit_fk, prix_unit, path_photo, stocke_surface)
                                values (:id_produit_fk, :prix_unit, :path_photo, :stocke_surface)");
        $stmt->execute(array('id_produit_fk'=>$id_produit_fk,
                            'prix_unit'=>$prix_unit, 
                            'path_photo'=>$path_photo, 
                            'stocke_surface'=>$stocke_surface));
        //    Get result of query
        $stmt->closeCursor();
    }catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}

function add_clothe_to_db($id_produit_fk, $sexe, $type, $article, $taille, $prix_vetement, $path_photo, $stocke_piece){
    global $conn;
    try{
        //    Insert query
        $stmt = $conn->prepare("insert into tissu (id_produit_fk, sexe, type, article, taille, prix_vetement, path_photo, stocke_piece)
                                values (:id_produit_fk, :sexe, :type, :article, :taille, :prix_vetement, :path_photo, :stocke_piece)");
        $stmt->execute(array('id_produit_fk'=>$id_produit_fk,
                            'sexe'=>$sexe, 
                            'type'=>$type, 
                            'article'=>$article,
                            'taille'=>$taille,
                            'prix_vetement'=>$prix_vetement,
                            'path_photo'=>$path_photo,
                            'stocke_piece'=>$stocke_piece));
        //    Get result of query
        $stmt->closeCursor();
    }catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}
