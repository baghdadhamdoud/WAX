<?php
ob_start();
?>
<div id="panier_container">
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
        <div>
            <button type="button">Vider le Panier</button>
            <button type="button">Commander</button>
        </div>
    </div>
</div>
<?php
echo ob_get_clean();