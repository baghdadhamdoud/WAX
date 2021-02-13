<?php
ob_start();
?>
<div id="panier_container">
    <div class="outer"></div>
    <div class="panier">
        <p class="title">Panier</p>
        <span class="exit">X</span>
        <div class="summary">
            <table class="tissue">
            </table>
            <table class="clothes">
            </table>
        </div>
        <button type="button">Commander</button>
    </div>
</div>
<?php
echo ob_get_clean();