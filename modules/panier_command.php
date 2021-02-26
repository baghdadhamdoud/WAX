<?php
ob_start();
?>
<div id="panier_command_container">
    <div class="outer"></div>
    <div class="panier">
        <p class="title">Mon Panier</p>
        <span class="exit">X</span>
        <div class="summary">
            <div class="tissue" style="display: none">
                <p>Tissus</p>
                <table></table>
            </div>
            <div class="clothes" style="display: none">
                <p>Vêtements</p>
                <table></table>
            </div>
        </div>
        <div class="btns">
            <button type="button" class="vider_panier">Vider le Panier</button>
            <button type="button" class="commander">Commander</button>
        </div>
    </div>
    <div class="command">
        <p class="title">Commander</p>
        <span class="exit">X</span>
        <div class="infos">
            <div class="phone">
                <label for="input_phone">Confirmer votre téléphone</label>
                <input id="input_phone" type="text" required>
            </div>
            <div class="address">
                <select class="wilaya" required>
                    <option disabled selected hidden>Wilaya</option>
                </select>
                <select class="daira" style="display: none" required>
                    <option disabled selected hidden>Daira</option>
                </select>
                <select class="commune" style="display: none" required>
                    <option disabled selected hidden>Commune</option>
                </select>
            </div>
            <div class="btns">
                <button type="button" class="back">Retour</button>
                <button type="button" class="valid">Valider</button>
            </div>
        </div>
    </div>
</div>
<?php
echo ob_get_clean();