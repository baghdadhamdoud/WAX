<?php ob_start() ?>
<div id="connexion">
    <div class="outer"></div>
    <div class="main">
        <p class="title">Connexion</p>
        <div class="input username">
            <input type="text" required>
            <span class="placeholder">Nom d'Utilisateur</span>
            <p class="alert"></p>
        </div>
        <div class="input password">
            <input type="password" required>
            <span class="placeholder">Mot de Passe</span>
            <p class="alert"></p>
        </div>
        <button class="btn_valid" type="button">Valider</button>
        <span class="inscription">Inscription</span>
        <span class="exit">Exit</span>
    </div>
</div>
<?php echo ob_get_clean();