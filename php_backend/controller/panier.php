<?php

function init_panier_tissue(){
    ob_start();
    ?>
    <tr class="titles">
        <td>Label</td>
        <td>Surface</td>
        <td>Prix</td>
        <td></td>
    </tr>
    <?php
    array_push($_SESSION['panier_tissue'], ob_get_clean());
}
function init_panier_clothes(){
    ob_start();
    ?>
    <tr class="titles">
        <td>Article</td>
        <td>Label</td>
        <td>Taille</td>
        <td>Quantité</td>
        <td>Prix</td>
        <td></td>
    </tr>
    <?php
    array_push($_SESSION['panier_clothes'], ob_get_clean());
}
function check_if_session_panier_tissue_exists(){
    if( !isset($_SESSION['panier_tissue']) || !isset($_SESSION['price_tissue']) ) {
        $_SESSION['panier_tissue'] = array();
        $_SESSION['price_tissue'] = 0;
        init_panier_tissue();
        return false;
    }
    return true;
}
function check_if_session_panier_clothes_exists(){
    if( !isset($_SESSION['panier_clothes']) || !isset($_SESSION['price_clothes']) ) {
        $_SESSION['panier_clothes'] = array();
        $_SESSION['price_clothes'] = 0;
        init_panier_clothes();
        return false;
    }
    return true;
}
function convert_priceSTR_to_priceINT($priceSTR){
    $tab = explode(' ', strval($priceSTR));
    return intval($tab[0]);
}

function add_tissue_to_panier(){
    if(!isset($_POST['id']) || !isset($_POST['label']) || !isset($_POST['surface']) || !isset($_POST['price'])){
        return json_encode(['status'=>'false : Variables "Tissu" non transmis']);
    }
    check_if_session_panier_tissue_exists();
    $price = convert_priceSTR_to_priceINT($_POST['price']) * intval($_POST['surface']);
    ob_start();
    ?>
    <tr>
        <td class="id" style="display: none"> <?php print $_POST['id'] ?></td>
        <td class="label"> <?php print $_POST['label'] ?></td>
        <td class="surface"> <?php print $_POST['surface'] ?> </td>
        <td class="price"> <?php print $price.' DA' ?> </td>
        <td class="delete">X</td>
    </tr>
    <?php
    if(isset($_SESSION['panier_tissue']) && isset($_SESSION['price_tissue'])){
        array_push($_SESSION['panier_tissue'], ob_get_clean());
        $_SESSION['price_tissue'] = $_SESSION['price_tissue'] + $price;
        return json_encode(['status'=>'true : "Tissu" ajouté']);
    }
    return json_encode(['status'=>'false : SESSION "Tissu" non définit']);
}

function add_clothes_to_panier(){
    if(!isset($_POST['id']) || !isset($_POST['label']) || !isset($_POST['article']) || !isset($_POST['taille']) || !isset($_POST['qtt']) || !isset($_POST['price'])){
        return json_encode(['status'=>'false : Variables "Vêtement" non transmis']);
    }
    check_if_session_panier_clothes_exists();
    $price = convert_priceSTR_to_priceINT($_POST['price']) * intval($_POST['qtt']);
    ob_start();
    ?>
    <tr>
        <td class="id" style="display: none"> <?php print $_POST['id'] ?></td>
        <td class="article"><?php print $_POST['article'] ?></td>
        <td class="label"> <?php print $_POST['label'] ?></td>
        <td class="taille"> <?php print $_POST['taille'] ?> </td>
        <td class="qtt"> <?php print $_POST['qtt'] ?> </td>
        <td class="price"> <?php print $price.' DA' ?> </td>
        <td class="delete">X</td>
    </tr>
    <?php
    if(isset($_SESSION['panier_clothes']) && isset($_SESSION['price_clothes'])){
        array_push($_SESSION['panier_clothes'], ob_get_clean());
        $_SESSION['price_clothes'] = $_SESSION['price_clothes'] + $price;
        return json_encode(['status'=>'true : "Vêtement" ajouté']);
    }
    return json_encode(['status'=>'false : SESSION "Vêtement" non définit']);
}

function formate_price_tissue(){
    ob_start();
    ?>
    <tr>
        <td></td>
        <td class="total total_title">Total</td>
        <td class="total total_number"><?php print $_SESSION['price_tissue'].' DA' ?></td>
        <td></td>
    </tr>
    <?php
    return ob_get_clean();
}
function formate_price_clothes(){
    ob_start();
    ?>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td class="total total_title">Total</td>
        <td class="total total_number"><?php print $_SESSION['price_clothes'].' DA' ?></td>
        <td></td>
    </tr>
    <?php
    return ob_get_clean();
}

function get_panier(){
    if(isset($_SESSION['panier_tissue']) && isset($_SESSION['panier_clothes'])){
        return json_encode(['status'=>'true', 'status_tissue'=>'yes', 'status_clothes'=>'yes', 
                'tissue'=>join('', $_SESSION['panier_tissue']), 'clothes'=>join('', $_SESSION['panier_clothes']),
                'price_tissue'=>formate_price_tissue(), 'price_clothes'=>formate_price_clothes()]);
    }
    if(isset($_SESSION['panier_tissue']) && !isset($_SESSION['panier_clothes'])){
        return json_encode(['status'=>'true', 'status_tissue'=>'yes', 'status_clothes'=>'no', 
                'tissue'=>join('', $_SESSION['panier_tissue']), 'price_tissue'=>formate_price_tissue()]);
    }
    if(!isset($_SESSION['panier_tissue']) && isset($_SESSION['panier_clothes'])){
        return json_encode(['status'=>'true', 'status_tissue'=>'no', 'status_clothes'=>'yes', 
                'clothes'=>join('', $_SESSION['panier_clothes']), 'price_clothes'=>formate_price_clothes()]);
    }
    if(!isset($_SESSION['panier_tissue']) && !isset($_SESSION['panier_clothes'])){
        return json_encode(['status'=>'false : Pas de panier']);
    }
    return json_encode(['status'=>'false : ERROR']);
}

function clear_panier(){
    if(isset($_SESSION['panier_tissue'])){
        unset($_SESSION['panier_tissue']);
        unset($_SESSION['price_tissue']);
    }
    if(isset($_SESSION['panier_clothes'])){
        unset($_SESSION['panier_clothes']);
        unset($_SESSION['price_clothes']);
    }
    return json_encode(['status'=>'true']);
}

function main(){    
    session_start();
    switch ($_POST['target']){
        case 'add_tissue_to_panier':
            echo add_tissue_to_panier();
            break;
        case 'add_clothes_to_panier':
            echo add_clothes_to_panier();
            break;
        case 'get_panier':
            echo get_panier();
            break;
        case 'clear_panier':
            echo clear_panier();
            break;
    }
}
main();
