<?php
ob_start();
?>
<div id="panier">
    <p class="title">Panier</p>
    <div class="summary">
        <!-- Mettre un tableau -->
    </div>
    <button type="button">Commander</button>
</div>
<?php
echo ob_get_clean();