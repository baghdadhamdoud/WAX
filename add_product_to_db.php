<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Wax Vêtement Ajouter des Produits</title>
    <!--    MY CSS ----------------------------------------------------------------------------------->
    <!--    CSS of INDEX-->
    <link href="css/addProduct.css" rel="stylesheet"/>
</head>
<body>

<form id="add-product" method="post" action="" enctype="multipart/form-data">
    <!-- LABEL PRODUCT ///////////////////////////////////////////////////////////////// -->
    <div class="big-input input" id="add-label">
        <input type="text" required>
        <span class="placeholder">Label du Produit</span>
    </div>
    <div id="add-tissue-clothes">
        <!-- TISSUE ///////////////////////////////////////////////////////////////// -->
        <div class="big-input" id="add-tissue">
            <!-- TISSUE : PRICE ----------------------------------------- -->
            <div class="input" id="add-tissue-price">
                <input type="text" required>
                <span class="placeholder">Prix du Tissu</span>
            </div>
            <!-- TISSUE : STOCKE ----------------------------------------- -->
            <div class="input" id="add-tissue-stoke">
                <input type="number" required>
                <span class="placeholder">Stocke en Surface</span> 
            </div>
            <!-- TISSUE : IMAGE ----------------------------------------- -->
            <div class="add-img">
                <img class="img-file" src="" alt="Image Tissu">
                <label class="input-file-label" for="input-tissue">
<!--                    <img class="icon-upload" src="pictures/icon/upload-solid.svg" alt="">-->
                    <span>Image du Tissu ...</span>
                    <input class="input-file" id="input-tissue" type="file" accept="image/jpg, image/png, image/jpeg">
                </label>
            </div>
            <button type="button">Add Tissue</button>
        </div>
        <!-- CLOTHES ///////////////////////////////////////////////////////////////// -->
        <div class="big-input" id="add-clothes">
            <!-- CLOTHES : SEXE ----------------------------------------- -->
            <div class="input-select" id="add-clothes-sexe">
                <select required>
                    <option disabled selected hidden>Choisissez un Sexe</option>
                    <option>Homme</option>
                    <option>Femme</option>
                </select>
            </div>
            <!-- CLOTHES : TYPE ----------------------------------------- -->
            <div class="input-select" id="add-clothes-type">
                <select required>
                    <option disabled selected hidden>Choisissez un Type</option>
                    <option>Haut</option>
                    <option>Bas</option>
                    <option>Ensemble</option>
                </select>
            </div>
            <!-- CLOTHES : ARTICLE ----------------------------------------- -->
            <div class="input" id="add-clothes-article">
                <input type="text" required>
                <span class="placeholder">Article</span>
            </div>
            <!-- CLOTHES : TAILLE ----------------------------------------- -->
            <div class="input" id="add-clothes-taille">
                <input type="text" required>
                <span class="placeholder">Tailles (séparées par '-')</span>
            </div>
            <!-- CLOTHES : PRICE ----------------------------------------- -->
            <div class="input" id="add-clothes-price">
                <input type="number" required>
                <span class="placeholder">Prix</span>
            </div>
            <!-- CLOTHES : IMAGE ----------------------------------------- -->
            <div class="add-img">
                <img class="img-file" src="" alt="Image Clothes">
                <label class="input-file-label" for="input-clothes">
<!--                    <img class="icon-upload" src="pictures/icon/upload-solid.svg" alt="">-->
                    <span>Image du Vêtement ...</span>
                    <input class="input-file" id="input-clothes" type="file" accept="image/jpg, image/png, image/jpeg">
                </label>
            </div>
            <button type="button">Add Clothes</button>
        </div>
    </div>
</form>

<!--    JS LIBRARIES-->
<script type="text/javascript" src="js/bib/jquery-3.5.1.js"></script>
<!--    MY JS -------------------------------------------------------------------------- -->
<!--    JS OF TOP BAR-->
<script type="text/javascript" src="js/addProduct.js"></script>
</body>
</html>