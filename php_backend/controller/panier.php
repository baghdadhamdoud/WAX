<?php
$panier_tissue = [];
$panier_clothes = [];
$tissue_count = 1;
$clothes_count = 1;

function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);
    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

function init_panier(){
    global $panier_tissue, $panier_clothes;
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
    global $panier_tissue, $tissue_count;
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
    $tissue_count ++;
    $t = ob_get_clean() . '</br>';
    array_push($panier_tissue, $t);
    return json_encode(['status'=>'true']);
}

function add_clothes_to_panier(){
    global $panier_clothes, $clothes_count;
    if(!isset($_POST['id']) || !isset($_POST['label']) || !isset($_POST['article']) || !isset($_POST['taille']) || !isset($_POST['price'])){
        return json_encode(['status'=>'false']);
    }
    ob_start();
    ?>
    <tr>
        <td><?php print $clothes_count ?></td>
        <td class="id" style="display: none"> <?php print $_POST['id'] ?></td>
        <td class="article"> <?php print $_POST['article'] ?></td>
        <td class="label"> <?php print $_POST['label'] ?></td>
        <td class="taille"> <?php print $_POST['taille'] ?> </td>
        <td class="price"> <?php print $_POST['price'] ?> </td>
        <td class="button">X</td>
    </tr>
    <?php
    $clothes_count++;
    $c = ob_get_clean() . '</br>';
    debug_to_console($c);
    array_push($panier_clothes, $c);
    return json_encode(['status'=>'true']);
}

function display_panier(){
    global $panier_tissue, $panier_clothes;
    return json_encode(['status'=>'true', 'tissue'=>join('', $panier_tissue), 'clothes'=>join('', $panier_clothes)]);
}

function main(){
    init_panier();
    switch ($_POST['target']){
        case 'add_tissue_to_panier':
            echo add_tissue_to_panier();
            break;
        case 'add_clothes_to_panier':
            echo add_clothes_to_panier();
            break;
        case 'display_panier':
            echo display_panier();
            break;
    }
}

main();