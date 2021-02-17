<?php

function init_panier(){
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
    array_push($_SESSION['panier_tissue'], ob_get_clean());
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
    array_push($_SESSION['panier_clothes'], ob_get_clean());
}

function check_if_session_panier_exists(){
    if(!isset($_SESSION['panier_tissue']) || !isset($_SESSION['panier_clothes']) ||
        !isset($_SESSION['tissue_count']) || !isset($_SESSION['clothes_count'])){
        $_SESSION['panier_tissue'] = array();
        $_SESSION['panier_clothes'] = array();
        $_SESSION['tissue_count'] = 1;
        $_SESSION['clothes_count'] = 1;
        init_panier();
    }
}

function add_tissue_to_panier(){
    if(!isset($_POST['id']) || !isset($_POST['label']) || !isset($_POST['surface']) || !isset($_POST['price'])){
        return json_encode(['status'=>'false']);
    }
    check_if_session_panier_exists();
    ob_start();
    ?>
    <tr>
        <td></td>
        <td><?php print $_SESSION['tissue_count'] ?></td>
        <td class="id" style="display: none"> <?php print $_POST['id'] ?></td>
        <td class="label"> <?php print $_POST['label'] ?></td>
        <td class="surface"> <?php print $_POST['surface'] ?> </td>
        <td class="price"> <?php print $_POST['price'] ?> </td>
        <td class="button">X</td>
    </tr>
    <?php
    if(isset($_SESSION['panier_tissue']) && isset($_SESSION['tissue_count'])){
        array_push($_SESSION['panier_tissue'], ob_get_clean());
        $_SESSION['tissue_count'] ++;
        return json_encode(['status'=>'true']);
    }
    return json_encode(['status'=>'false']);
}

function add_clothes_to_panier(){
    if(!isset($_POST['id']) || !isset($_POST['label']) || !isset($_POST['article']) || !isset($_POST['taille']) || !isset($_POST['price'])){
        return json_encode(['status'=>'false']);
    }
    check_if_session_panier_exists();
    ob_start();
    ?>
    <tr>
        <td></td>
        <td><?php print $_SESSION['clothes_count'] ?></td>
        <td class="id" style="display: none"> <?php print $_POST['id'] ?></td>
        <td class="article"><?php print $_POST['article'] ?></td>
        <td class="label"> <?php print $_POST['label'] ?></td>
        <td class="taille"> <?php print $_POST['taille'] ?> </td>
        <td class="price"> <?php print $_POST['price'] ?> </td>
        <td class="button">X</td>
    </tr>
    <?php
    if(isset($_SESSION['panier_clothes']) && isset($_SESSION['clothes_count'])){
        array_push($_SESSION['panier_clothes'], ob_get_clean());
        $_SESSION['clothes_count'] ++;
        return json_encode(['status'=>'true']);
    }
    return json_encode(['status'=>'false']);
}

function get_panier(){
    return json_encode(['status'=>'true', 'tissue'=>$_SESSION['panier_tissue'], 'clothes'=>$_SESSION['panier_clothes']]);
}

function main(){    
    session_start();
    switch ($_POST['target']){
        case 'add_tissue_to_panier':
            // echo add_tissue_to_panier();
            echo json_encode(['status'=>'false']); 
            break;
        case 'add_clothes_to_panier':
            // echo add_clothes_to_panier();
            echo json_encode(['status'=>'false']);
            // echo '<p>Baghdad</p>';
            break;
        case 'get_panier':
            echo get_panier();
            break;
    }
}
main();
