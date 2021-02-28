<?php
require '../model/command.php';

function format_phone_number($tel){
    $t = '0'.substr($tel, 4, 1);
    $i = 5;
    while($i < 13){
        $t = $t . ' ' . substr($tel, $i, 2);
        $i = $i + 2;
    }
    return $t;
}

// CHECK IF USER IS CONNECTED ---------------------------------------------------------------------------
function check_if_user_is_connected(){
    if(isset($_SESSION['id_user'])){
        return json_encode(['status'=>'true']);
    }
    return json_encode(['status'=>'false']);
}

function get_wilayas(){
    $wilayas = get_wilayas_from_db();
    ob_start();
    ?>
    <option disabled selected hidden>Wilaya</option>
    <?php
    foreach ($wilayas as $w){
        ?>
        <option><?php print utf8_encode($w['code_wilaya']).' - '.utf8_encode($w['nom_wilaya'])?></option>
        <?php
    }
    return ob_get_clean();
}

function init_command(){
    if(isset($_SESSION['telephone'])){
        return json_encode(['status'=>'true', 'tel'=>$_SESSION['telephone'], 'wilayas'=>get_wilayas()]);
    }
    return json_encode(['status'=>'false', 'wilayas'=>get_wilayas()]);
}

function get_daira(){
    $dairas = get_dairas_from_db($_POST['id_wilaya']);
    ob_start();
    ?>
    <option disabled selected hidden>Daira</option>
    <?php
    foreach ($dairas as $d){
        ?>
        <option><?php print utf8_encode($d['code_daira']).' - '.utf8_encode($d['nom_daira'])?></option>
        <?php
    }
    return json_encode(['status'=>'true', 'daira'=>ob_get_clean()]);
}

function get_commune(){
    $communes = get_communes_from_db($_POST['id_daira']);
    ob_start();
    ?>
    <option disabled selected hidden>Commune</option>
    <?php
    foreach ($communes as $c){
        ?>
        <option><?php print utf8_encode($c['code_commune']).' - '.utf8_encode($c['nom_commune'])?></option>
        <?php
    }
    return json_encode(['status'=>'true', 'commune'=>ob_get_clean()]);
}

function check_if_phone_is_the_same($tel){
    if($_SESSION['telephone'] != $tel){
        update_phone_number($tel);
    }
    return true;
}

function valid_command(){
    if(!isset($_POST['id_commune']) || !isset($_POST['tel']) || !isset($_POST['date']) || !isset($_POST['time'])){
        return json_encode(['status'=>'false : variables are missing']);
    }
    check_if_phone_is_the_same($_POST['tel']);
//    insert_commandes_tissues($_SESSION['panier_tissues'], $_SESSION['id_user'], $_POST['date'], $_POST['time'], $_POST['id_commune']);
//    insert_commandes_clothes($_SESSION['panier_clothes'], $_SESSION['id_user'], $_POST['date'], $_POST['time'], $_POST['id_commune']);
    return json_encode(['status'=>'true']);
}

// MAIN -----------------------------------------------------------------------------------------
// ------------------------------------------------------------------------------------------------------

function main(){
    session_start();
    switch ($_POST['target']){
        case 'check_if_user_is_connected':
            echo check_if_user_is_connected();
            break;
        case 'init_command':
            echo init_command();
            break;
        case 'get_daira':
            echo get_daira();
            break;
        case 'get_commune':
            echo get_commune();
            break;
        case 'valid_command':
            echo valid_command();
            break;
    }
}
main();
