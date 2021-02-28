<?php
require '../model/login.php';

function check_username(){
    $username = $_POST['username'];
    if(preg_match('/^[A-Za-z]{1}[A-Za-z0-9]{5,31}$/', $username)){
        return true;
    }
    return false;
}

function check_password(){
    $password = $_POST['password'];
    if(preg_match('/^.{8,}$/', $password)){
        return true;
    }
    return false;
}

function save_user_session($id_user, $usename,$nom,$prenom,$genre,$email,$telephone){
    $_SESSION['id_user'] = $id_user;
    $_SESSION['username'] = $usename;
    $_SESSION['nom'] = $nom;
    $_SESSION['prenom'] = $prenom;
    $_SESSION['genre'] = $genre;
    $_SESSION['email'] = $email;
    $_SESSION['telephone'] = $telephone;
}

function get_user_session(){
    if(isset($_SESSION['username']) && isset($_SESSION['nom']) && isset($_SESSION['prenom'])
        && isset($_SESSION['genre']) && isset($_SESSION['email']) && isset($_SESSION['telephone'])){

        $user = ['status'=>'true', 'username'=>$_SESSION['username'],
            'nom'=>$_SESSION['nom'], 'prenom'=>$_SESSION['prenom'], 'genre'=>$_SESSION['genre'],
            'email'=>$_SESSION['email'], 'telephone'=>$_SESSION['telephone']];
        return json_encode($user);
    }
    else{
        return json_encode(['status'=>'false']);
    }
}

function deconnexion(){
    if(isset($_SESSION['id_user']) && isset($_SESSION['username']) && isset($_SESSION['nom']) && isset($_SESSION['prenom'])
        && isset($_SESSION['genre']) && isset($_SESSION['email']) && isset($_SESSION['telephone'])){
        unset($_SESSION['id_user']);
        unset($_SESSION['username']);
        unset($_SESSION['nom']);
        unset($_SESSION['prenom']);
        unset($_SESSION['genre']);
        unset($_SESSION['email']);
        unset($_SESSION['telephone']);
        return json_encode(['status'=>'true']);
    }
    else{
        return json_encode(['status'=>'false']);
    }
}

function connexion_treatment(){
    if(!isset($_POST['username']) || !isset($_POST['password'])){
        return false;
    }
    $username = $_POST['username'];
    $password = $_POST['password'];
    if(!check_username()){
        return json_encode(['status'=>'false', 'response'=>'Veuillez entrer un Nom d\'utilisateur valide']);
    }
    if(!check_password()){
        return json_encode(['status'=>'false', 'response'=>'Veuillez entrer au moins 8 caractère pour le Mot de Passe']);
    }
    $user = get_user($username);
    if(!$user){
        return json_encode(['status'=>'false', 'response'=>'Votre Nom d\'utilisateur n\'existe pas']);
    }
    if($user['password'] != $password){
        return json_encode(['status'=>'false', 'response'=>'Votre Mot de Passe est erroné']);
    }
    save_user_session($user['id_user'], $username, $user['nom'], $user['prenom'],$user['genre'], $user['email'], $user['telephone']);
    return json_encode(['status'=>'true', 'nom'=>$user['nom'], 'prenom'=>$user['prenom']]);
}

function main(){
    session_start();
    switch ($_POST['target']){
        case 'connexion_treatment':
            echo connexion_treatment();
            break;
        case 'get_user_session':
            echo get_user_session();
            break;
        case 'deconnexion':
            echo deconnexion();
            break;
    }
}

main();