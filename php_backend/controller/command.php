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

function get_wilayas(){
    $wilayas = get_wilayas_from_db();
    ob_start();
    foreach ($wilayas as $w){
        ?>
        <option><?php print utf8_encode($w['code_wilaya']).' - '.utf8_encode($w['nom_wilaya'])?></option>
        <?php
    }
    return ob_get_clean();
}

function init_command(){
    if(isset($_SESSION['telephone'])){
        return json_encode(['status'=>'true', 'tel'=>format_phone_number(strval($_SESSION['telephone'])),
                            'wilayas'=>get_wilayas()]);
    }
    return json_encode(['status'=>'false', 'wilayas'=>get_wilayas()]);
}

function get_daira(){
    $dairas = get_dairas_from_db($_POST['id_wilaya']);
    ob_start();
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
    foreach ($communes as $c){
        ?>
        <option><?php print utf8_encode($c['code_commune']).' - '.utf8_encode($c['nom_commune'])?></option>
        <?php
    }
    return json_encode(['status'=>'true', 'commune'=>ob_get_clean()]);
}

function commander(){
    if(!isset($_POST['adresse'])){
        return json_encode(['status'=>'false : variable is missing']);
    }
    $date = date('Y-m-d');
    $heure = date('H:i:s');
    insert_commandes_tissues($_SESSION['panier_tissues'], $_SESSION['id_user'], $date, $heure, $_POST['adresse']);
    return json_encode(['status'=>'true']);
}

// MAIN -----------------------------------------------------------------------------------------
// ------------------------------------------------------------------------------------------------------

function main(){
    session_start();
    switch ($_POST['target']){
        case 'init_command':
            echo init_command();
            break;
        case 'get_daira':
            echo get_daira();
            break;
        case 'get_commune':
            echo get_commune();
            break;
        case 'commander':
            echo commander();
            break;
    }
}
main();
