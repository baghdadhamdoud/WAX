function Panier() {
    let panier = this;

    // AJAX ----------------------------------------------------------------------------------------------
    this.hand_of_my_db = function (data) {
        return $.ajax({
            url: 'php_backend/controller/panier.php',
            type: 'POST',
            dataType: 'json',
            data: data,
            error: function (r, s, e) {
                console.log(e);
            }
        })
    }

    this.add_to_panier = function () {
        $(document).on('click', '#main .display .product .desc button', function (e) {
            const tissue_or_clothes = $('#main .display .product .desc .tissue_or_clothes').text();
            const id = $('#main .display .product .desc .id').text();
            const label = $('#main .display .product .desc .label').text();
            let data_php;
            switch (tissue_or_clothes) {
                case 'tissue':
                    const surface = $('#main .display .product .desc .input_surface input').val();
                    if(surface === ''){
                        return null;
                    }
                    data_php = {target:'add_tissue_to_panier', id:id, label:label, surface:surface};
                    panier.hand_of_my_db(data_php).done(function (r,s) {
                        if (r['status'] === 'true'){
                            $('#main .display .product .desc').addClass('button_disable');
                        }
                    })
                    break;
                case 'clothes':
                    const taille = $('#main .display .product .desc select').val();
                    const article = $('#main .display .product .desc .article').text();
                    data_php = {target:'add_clothes_to_panier', id:id, label:label, article:article, surface:taille};
                    panier.hand_of_my_db(data_php).done(function (r,s) {
                        console.log(s)
                        if (r['status'] === 'true'){
                            $('#main .display .product .desc').addClass('button_disable');
                        }
                    })
                    break;
            }
        })
    }

    this.main = function () {
        $('#panier').hide();
        this.add_to_panier();
    }
}
let panier = new Panier();
panier.main();