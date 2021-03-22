<?php
require_once('../model/set_product.php');

define('DIRECTORY', '../../pictures/');
define('WIDTH_MAX', 1920);
define('HEIGHT_MAX', 1080);
$tabExt = ['jpg', 'gif', 'png', 'jpeg'];

function check_directory(){
    if(!is_dir(DIRECTORY)){
        if(!mkdir(DIRECTORY, 0755)){
            exit('Erreur : Répertoire ne peut être créé');
        }
    }
}
function check_extension($name){
    $ext = pathinfo($name, PATHINFO_EXTENSION);
    if(in_array(strtolower($ext), $tabExt)){
        return $ext;
    }
    return false;
}
function check_type_and_size($tmp_name){
    $infosImg = getimagesize($tmp_name);
    if($infosImg[2] >= 1 && $infosImg[2] <= 14){
        if($infosImg[0] <= WIDTH_MAX && $infosImg[1] <= HEIGHT_MAX){
            return true;
        }
    }
    return false;
}
function check_errors($error){
    if(isset($error) && UPLOAD_ERR_OK === $error){
        return false;
    }
    return true;
}
function upload_image($image){
    check_directory();
    $ext = check_extension($image['name']);
    if($ext != null){
        return json_encode(['status'=>'false : extensions']);
    }
    if(!check_type_and_size($image['tmp_name'])){
        return json_encode(['status'=>'false : type or size']);
    }
    if(!check_errors($image['error'])){
        return json_encode(['status'=>'false : erreur interne']);
    }
    $nomImage  = md5(uniqid()) . '.' . $ext;
    if(move_uploaded_file($image['tmp_name'], DIRECTORY.$nomImage)){
        // Extraire le nom de l'image sans '../../'
        return $nomImage;
    }
    return false;
}

function add_tissue(){
    if(check_label_on_db($_POST['label']) != false){
        // Voir ce qu'on peut faire
        return json_encode(['status'=>'flase : label already exists']);
    }
    $id_produit = set_new_label_on_db($_POST['label']);
    $prix_unit = $_POST['price_tissue'];
    $stoke_surface = $_POST['stoke_surface'];
    $nomImage_tissu = upload_image($_FILES['img-tissue']);
    if($nomImage_tissu == false){
        return json_encode(['status'=>'false : upload']);
    }
    add_tissue_to_db(intval($id_produit), intval($prix_unit), $nomImage_tissu, intval($stoke_surface));
    return json_encode(['status'=>'true']);
}

function add_clothe(){
    return json_encode(['status'=>'true']);
}



function main(){
    switch ($_POST['target']){
        case 'add_tissue':
            echo add_tissue();
            break;
        case 'add_clothe':
            echo add_clothe();
            break;
    }
}

main();