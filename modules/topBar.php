<?php ob_start(); ?>
<div id="topBar">
    <p class="wax-page">WAX Dress</p>
    <p class="welcome">Bonjour Truc</p>
    <div class="panier">
        <img src="pictures/icon/panier.png" alt="Logo panier">
<!--        <p id="panier-topbar-title">Panier</p>-->
    </div>
    <div class="connexion_inscription">
        <p class="connexion">Connexion</p>
        <p class="inscription">Insciption</p>
    </div>
    <div class="profil_deconnexion">
        <div class="profil">
            <p>Profil</p>
            <div></div>
        </div>
        <p class="deconnexion">Déconnexion</p>
    </div>
</div>
<?php echo ob_get_clean();