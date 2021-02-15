<?php
$panier_tissue = [];
$panier_clothes = [];
$tissue_count = 1;
$clothes_count = 1;

function init_panier(){
    global $panier_tissue , $panier_clothes ;
    ob_start();
    ?>
    <tr class="titles">
        <td>Numéro</td>
        <td>Label</td>
        <td>Surface</td>
        <td>Prix</td>
        <td>Button</td>
    </tr>
    <?php
    array_push($panier_tissue, ob_get_clean());
    ob_start();
    ?>
    <tr class="titles">
        <td>Numéro</td>
        <td>Article</td>
        <td>Label</td>
        <td>Taille</td>
        <td>Prix</td>
        <td>Button</td>
    </tr>
    <?php
    array_push($panier_clothes, ob_get_clean());
}

function add_tissue_to_panier(){
    global $panier_tissue , $tissue_count;
    if(!isset($_POST['id']) || !isset($_POST['label']) || !isset($_POST['surface']) || !isset($_POST['price'])){
        return json_encode(['status'=>'false']);
    }
    ob_start();
    ?>
    <tr>
        <td></td>
        <td><?php print $tissue_count ?></td>
        <td class="id" style="display: none"> <?php print $_POST['id'] ?></td>
        <td class="label"> <?php print $_POST['label'] ?></td>
        <td class="surface"> <?php print $_POST['surface'] ?> </td>
        <td class="price"> <?php print $_POST['price'] ?> </td>
        <td class="button">X</td>
    </tr>
    <?php
    array_push($panier_tissue, ob_get_clean());
    $tissue_count ++;
    // return json_encode(['status'=>'true']);
}

function add_clothes_to_panier(){
    global $panier_clothes, $clothes_count;
    if(!isset($_POST['id']) || !isset($_POST['label']) || !isset($_POST['article']) || !isset($_POST['taille']) || !isset($_POST['price'])){
        // return json_encode(['status'=>'false']);
    }
    $id = $_POST['id'];
    $article = $_POST['article'];
    $label = $_POST['label'];
    $taille = $_POST['taille'];
    $price = $_POST['price'];

    $c = '<tr>
            <td>'.$clothes_count.'</td>
            <td class="id" style="display: none">'.$id.'</td>
            <td class="article">'.$article.'</td>
            <td class="label">'.$label.'</td>
            <td class="taille">'.$taille.'</td>
            <td class="price">'.$price.'</td>
            <td class="button">X</td> </tr>';

    // return json_encode(['c'=>$c]);
    $clothes_count ++;
    array_push($panier_clothes, $c);
    // return json_encode(['status'=>'false']);
}

function get_panier(){
    global $panier_tissue , $panier_clothes;
    return json_encode(['status'=>'true', 'tissue'=>$panier_tissue, 'clothes'=>$panier_clothes]);
}

function main(){
    init_panier();
    if(!isset($_POST['target'])){
        return null;
    }
    switch ($_POST['target']){
        case 'add_tissue_to_panier':
            add_tissue_to_panier();
            break;
        case 'add_clothes_to_panier':
            add_clothes_to_panier();
            break;
        case 'get_panier':
            echo get_panier();
            break;
        case 'get_panier_tissue':
            echo get_panier_tissue();
    }
}

main();
// session_start();
// init_panier();
// add_clothes_to_panier();
// add_clothes_to_panier();
// echo json_encode(get_panier());