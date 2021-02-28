<?php
//require '../model/panier.php';

function convert_priceSTR_to_priceINT($priceSTR){
    $tab = explode(' ', strval($priceSTR));
    return intval($tab[0]);
}

// TISSUES -----------------------------------------------------------------------------------------
// ------------------------------------------------------------------------------------------------------

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
    return ob_get_clean();
}

function check_if_session_panier_tissue_exists(){
    if( !isset($_SESSION['panier_tissues']) || !isset($_SESSION['price_tissues']) ) {
        $_SESSION['panier_tissues'] = array();
        $_SESSION['price_tissues'] = 0;
        return false;
    }
    return true;
}

function add_tissue_to_panier(){
    if(!isset($_POST['id']) || !isset($_POST['label']) || !isset($_POST['surface']) || !isset($_POST['price'])){
        return json_encode(['status'=>'false : Variables "Tissu" non transmis']);
    }
    check_if_session_panier_tissue_exists();
    $price = convert_priceSTR_to_priceINT($_POST['price']) * intval($_POST['surface']);
    if(!array_key_exists($_POST['id'], $_SESSION['panier_tissues'])){
        $tissue = ['label'=>$_POST['label'], 'surface'=>$_POST['surface'], 'price'=>$price];
        $_SESSION['panier_tissues'][$_POST['id']] = $tissue;
    }
    else{
        $_SESSION['panier_tissues'][$_POST['id']]['surface'] = $_POST['surface'];
        $_SESSION['panier_tissues'][$_POST['id']]['price'] = $price;
    }
    $_SESSION['price_tissues'] = $_SESSION['price_tissues'] + $price;
    return json_encode(['status'=>'true : "Tissu" ajouté']);
}

function tissue_to_html($id, $tissue){
    ob_start();
    ?>
    <tr>
        <td class="id" style="display: none"><?php print $id ?></td>
        <td class="label"><?php print $tissue['label'] ?></td>
        <td class="surface"><?php print $tissue['surface'] ?></td>
        <td class="price"><?php print $tissue['price'].' DA' ?></td>
        <td class="delete">X</td>
    </tr>
    <?php
    return ob_get_clean();
}

function format_price_tissues_to_html(){
    ob_start();
    ?>
    <tr>
        <td></td>
        <td class="total total_title">Total</td>
        <td class="total total_number"><?php print $_SESSION['price_tissues'].' DA' ?></td>
        <td></td>
    </tr>
    <?php
    return ob_get_clean();
}

function format_panier_tissues_to_html(){
    if(isset($_SESSION['panier_tissues']) && isset($_SESSION['price_tissues'])){
        $panierTissues = [init_panier_tissue()];
        foreach ($_SESSION['panier_tissues'] as $id => $tissue){
            array_push($panierTissues, tissue_to_html($id, $tissue));
        }
        array_push($panierTissues, format_price_tissues_to_html());
        return join('', $panierTissues);
    }
    return null;
}

// CLOTHES -----------------------------------------------------------------------------------------
// ------------------------------------------------------------------------------------------------------

function check_if_session_panier_clothes_exists(){
    if( !isset($_SESSION['panier_clothes']) || !isset($_SESSION['price_clothes']) ) {
        $_SESSION['panier_clothes'] = array();
        $_SESSION['price_clothes'] = 0;
        return false;
    }
    return true;
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
    return ob_get_clean();
}

function add_clothes_to_panier(){
    if(!isset($_POST['id']) || !isset($_POST['label']) || !isset($_POST['article']) || !isset($_POST['taille']) || !isset($_POST['qtt']) || !isset($_POST['price'])){
        return json_encode(['status'=>'false : Variables "Vêtement" non transmis']);
    }
    check_if_session_panier_clothes_exists();
    $price = convert_priceSTR_to_priceINT($_POST['price']) * intval($_POST['qtt']);
    if(!array_key_exists($_POST['id'], $_SESSION['panier_clothes'])){
        $clothe = ['article'=>$_POST['article'], 'label'=>$_POST['label'],
            'taille'=>$_POST['taille'], 'qtt'=>$_POST['qtt'], 'price'=>$price];
        $_SESSION['panier_clothes'][$_POST['id']] = $clothe;
    }
    else{
        $_SESSION['panier_clothes'][$_POST['id']]['taille'] = $_POST['taille'];
        $_SESSION['panier_clothes'][$_POST['id']]['qtt'] = $_POST['qtt'];
        $_SESSION['panier_clothes'][$_POST['id']]['price'] = $price;
    }

    $_SESSION['price_clothes'] = $_SESSION['price_clothes'] + $price;
    return json_encode(['status'=>'true : "Vêtement" ajouté']);
}

function clothe_to_html($id, $clothe){
    ob_start();
    ?>
    <tr>
        <td class="id" style="display: none"><?php print $id ?></td>
        <td class="article"><?php print $clothe['article'] ?></td>
        <td class="label"><?php print $clothe['label'] ?></td>
        <td class="taille"><?php print $clothe['taille'] ?></td>
        <td class="qtt"><?php print $clothe['qtt'] ?> </td>
        <td class="price"><?php print $clothe['price'].' DA' ?></td>
        <td class="delete">X</td>
    </tr>
    <?php
    return ob_get_clean();
}

function format_price_clothes_to_html(){
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

function format_panier_clothes_to_html(){
    if(isset($_SESSION['panier_clothes']) && isset($_SESSION['price_clothes'])){
        $panierClothes = [init_panier_clothes()];
        foreach ($_SESSION['panier_clothes'] as $id => $clothe){
            array_push($panierClothes, clothe_to_html($id, $clothe));
        }
        array_push($panierClothes, format_price_clothes_to_html());
        return join('', $panierClothes);
    }
    return null;
}

// GET PANIER -----------------------------------------------------------------------------------------
// ------------------------------------------------------------------------------------------------------

function get_panier(){
    if(isset($_SESSION['panier_tissues']) && isset($_SESSION['panier_clothes'])){
        return json_encode(['status'=>'true', 'status_tissue'=>'yes', 'status_clothes'=>'yes', 
                'tissue'=>format_panier_tissues_to_html(), 'clothes'=>format_panier_clothes_to_html()]);
    }
    if(isset($_SESSION['panier_tissues']) && !isset($_SESSION['panier_clothes'])){
        return json_encode(['status'=>'true', 'status_tissue'=>'yes', 'status_clothes'=>'no', 
                'tissue'=>format_panier_tissues_to_html()]);
    }
    if(!isset($_SESSION['panier_tissues']) && isset($_SESSION['panier_clothes'])){
        return json_encode(['status'=>'true', 'status_tissue'=>'no', 'status_clothes'=>'yes', 
                'clothes'=>format_panier_clothes_to_html()]);
    }
    if(!isset($_SESSION['panier_tissues']) && !isset($_SESSION['panier_clothes'])){
        return json_encode(['status'=>'false : Pas de panier']);
    }
    return json_encode(['status'=>'false : ERROR']);
}

// CLEAR PANIER -----------------------------------------------------------------------------------------
// ------------------------------------------------------------------------------------------------------

function clear_panier(){
    if(isset($_SESSION['panier_tissues'])){
        unset($_SESSION['panier_tissues']);
        unset($_SESSION['price_tissues']);
    }
    if(isset($_SESSION['panier_clothes'])){
        unset($_SESSION['panier_clothes']);
        unset($_SESSION['price_clothes']);
    }
    return json_encode(['status'=>'true']);
}

// DELETE FROM PANIER -----------------------------------------------------------------------------------------
// ------------------------------------------------------------------------------------------------------

function delete_from_panier(){
    if(!isset($_POST['tissue_or_clothes']) || !isset($_POST['id'])){
        return json_encode(['status'=>'false : variables non transmis']);
    }
    switch ($_POST['tissue_or_clothes']){
        case'tissue':
            if(array_key_exists($_POST['id'], $_SESSION['panier_tissues'])){
                $retour = [];
                if(count($_SESSION['panier_tissues']) == 1){
                    unset($_SESSION['panier_tissues']);
                    unset($_SESSION['price_tissues']);
                    $retour += ['empty'=>'yes'];
                }
                else{
                    $_SESSION['price_tissues'] = $_SESSION['price_tissues'] - $_SESSION['panier_tissues'][$_POST['id']]['price'];
                    unset($_SESSION['panier_tissues'][$_POST['id']]);
                    $retour += ['empty'=>'no', 'newPriceTotal'=>$_SESSION['price_tissues']];
                }
                $retour += ['status'=>'true'];
                return json_encode($retour);
            }
            break;
        case'clothes':
            if(array_key_exists($_POST['id'], $_SESSION['panier_clothes'])){
                $retour = [];
                if(count($_SESSION['panier_clothes']) == 1){
                    unset($_SESSION['panier_clothes']);
                    unset($_SESSION['price_clothes']);
                    $retour += ['empty'=>'yes'];
                }
                else{
                    $_SESSION['price_clothes'] = $_SESSION['price_clothes'] - $_SESSION['panier_clothes'][$_POST['id']]['price'];
                    unset($_SESSION['panier_clothes'][intval($_POST['id'])]);
                    $retour += ['empty'=>'no', 'newPriceTotal'=>$_SESSION['price_clothes']];
                }
                $retour += ['status'=>'true'];
                return json_encode($retour);
            }
    }
    return json_encode(['status'=>'false']);
}

// MAIN -----------------------------------------------------------------------------------------
// ------------------------------------------------------------------------------------------------------

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
        case 'delete_from_panier':
            echo delete_from_panier();
            break;
    }
}
main();
