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
                console.log(data);                
                console.log(e);
            }
        })
    }

    this.add_to_panier = function () {
        function action(){
            $('#main .display .product .desc button').hide();
            $('#main .display .product .desc .added').show('slow');
            // setTimeout(function () {
            //     $('#main .display .product img, #main .display .product .desc').remove();
            //     $('#main .display').hide('slow');
            // }, 3000)
        }
        $(document).on('click', '#main .display .product .desc button', function (e) {
            const tissue_or_clothes = $('#main .display .product .desc .tissue_or_clothes').text();
            const id = $('#main .display .product .desc .id').text();
            const label = $('#main .display .product .desc .label').text();
            const price = $('#main .display .product .desc .price').text();
            let data_php;
            switch (tissue_or_clothes) {
                case 'tissue':
                    const surface = $('#main .display .product .desc .input_surface input').val();
                    if(surface === ''){
                        alert('Veuillez entrer une surface');
                        return null;
                    }
                    data_php = {target:'add_tissue_to_panier', id:id, label:label, surface:surface, price:price};
                    panier.hand_of_my_db(data_php).done(function (r,s) {
                        // console.log(r);
                        if (r['status'] === 'true : "Tissu" ajouté'){
                            action();
                        }
                    })
                    break;
                case 'clothes':
                    const taille = $('#main .display .product .desc select').val();
                    const qtt = $('#main .display .product .desc .input_qtt input').val();
                    if(taille === null || qtt === null){
                        return null;
                    }
                    let article = $('#main .display .product .desc .article').text();
                    article = String(article).split(' ')[0];
                    data_php = {target:'add_clothes_to_panier', id:id, label:label, 
                                article:article, taille:taille, qtt:qtt, price:price};
                    panier.hand_of_my_db(data_php).done(function (r,s) {
                        // console.log(r);
                        if (r['status'] === 'true : "Vêtement" ajouté'){
                            action();
                        }
                    })
                    break;
            }
        })
    }

    this.set_panier = function () {
        $(document).on('click', '#topBar .panier', function () {
            const data_php = {target:'get_panier'};
            panier.hand_of_my_db(data_php).done(function (r,s) {
                // console.log(r);
                if(r['status'] === 'true'){
                    if(r['status_tissue'] === 'yes'){
                        $('#panier_container .panier .summary .tissue table').append(r['tissue'], r['price_tissue']);
                        $('#panier_container .panier .summary .tissue').show();
                    }
                    if(r['status_clothes'] === 'yes'){
                        $('#panier_container .panier .summary .clothes table').append(r['clothes'], r['price_clothes']);
                        $('#panier_container .panier .summary .clothes').show();
                    }
                    $('#panier_container').show('slow');
                }
            });
        });
        $(document).on('click', '#panier_container .panier .exit, #panier_container .outer', function () {
            $('#panier_container').hide('slow');
            $('#panier_container .summary table *').remove();
        });
    }

    this.main = function () {
        $('#panier_container').hide();
        this.add_to_panier();
        this.set_panier();
    }
}

console.log('PANIER');
let panier = new Panier();
panier.main();