<?php
$panier = [];

function add_tissue_to_panier(){
    global $panier;
    $panier += ['tissue_or_clothes'=>'tissue', 'id'=>$_POST['id'], 'label'=>$_POST['label'],
        'surface'=>$_POST['surface']];
    return json_encode(['status'=>'true']);
}

function add_clothes_to_panier(){
    global $panier;
    $panier += ['tissue_or_clothes'=>'clothes', 'id'=>$_POST['id'], 'label'=>$_POST['label'],
        'article'=>$_POST['article'], 'taille'=>$_POST['taille']];
    return json_encode(['status'=>'true']);
}

function main(){
    switch ($_POST['target']){
        case 'add_tissue_to_panier':
            echo add_tissue_to_panier();
            break;
        case 'add_clothes_to_panier':
            echo add_clothes_to_panier();
            break;
    }
}

main();