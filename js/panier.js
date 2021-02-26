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
                    let qtt = $('#main .display .product .desc .input_qtt input').val();
                    if(taille === null){
                        alert('Veillez entrer une taille pour le vêtement !');
                        return null;
                    }
                    if(qtt === ''){
                        qtt = 1;
                    }
                    let article = $('#main .display .product .desc .article').text();
                    article = String(article).split(' ')[0];
                    data_php = {target:'add_clothes_to_panier', id:id, label:label,
                                article:article, taille:taille, qtt:qtt, price:price};
                    panier.hand_of_my_db(data_php).done(function (r,s) {
                        if (r['status'] === 'true : "Vêtement" ajouté'){
                            action();
                        }
                    })
                    break;
            }
        })
    }

    this.set_panier = function () {
        // DISPLAY PANIER
        $(document).on('click', '#topBar .panier', function () {
            const data_php = {target:'get_panier'};
            panier.hand_of_my_db(data_php).done(function (r,s) {
                if(r['status'] === 'true'){
                    if(r['status_tissue'] === 'yes'){
                        $('#panier_command_container .panier .summary .tissue table').append(r['tissue']);
                        $('#panier_command_container .panier .summary .tissue').show();
                    }
                    if(r['status_clothes'] === 'yes'){
                        $('#panier_command_container .panier .summary .clothes table').append(r['clothes']);
                        $('#panier_command_container .panier .summary .clothes').show();
                    }
                }
                $('#panier_command_container').show('slow');
            });
        });
        // EXIT PANIER AND COMMAND ***************************
        $(document).on('click', '#panier_command_container .panier .exit, #panier_command_container .outer', function () {
            $('#panier_command_container').hide('slow', function () {
                $('#panier_command_container .summary div table *').remove();
                let panier = $('#panier_command_container .panier');
                if(panier.is(':hidden')){
                    panier.show();
                }
            });
        });
        // CLEAR PANIER
        $(document).on('click', '#panier_command_container .panier .btns .vider_panier', function () {
            const data_php = {target:'clear_panier'};
            panier.hand_of_my_db(data_php).done(function (r,s) {
                if(r['status'] === 'true'){
                    $('#panier_command_container .panier .summary div').hide('slow');
                }
            })
        });
        // DELETE FROM PANIER
        $(document).on('click', '#panier_command_container .panier .summary div table tr td.delete', function (e) {
            const tissue_or_clothes = $(e.target).parent().parent().parent().prop('class');
            const id = $(e.target).parent().find('td.id').text();
            const data_php = {target:'delete_from_panier', tissue_or_clothes:tissue_or_clothes, id:parseInt(id)};
            panier.hand_of_my_db(data_php).done(function (r,s) {
                if(r['status'] === 'true'){
                    if(r['empty'] === 'yes'){
                        $(e.target).parent().parent().parent().hide('slow');
                    }
                    else{
                        $(e.target).parent().hide('slow');
                        $(e.target).parent().parent().find('tr td.total_number').text(String(r['newPriceTotal'] +' DA'));
                    }
                }
            })
        });
    }

    this.set_btn_commander = function () {
        $(document).on('click', '#panier_command_container .panier .btns .commander', function () {
            const data_php = {target:'check_if_user_is_connected'};
            panier.hand_of_my_db(data_php).done(function (r) {
                if(r['status'] === 'true'){
                    console.log('Il y a un user !');
                    $.ajax({
                        url: 'php_backend/controller/command.php',
                        type: 'POST',
                        dataType: 'json',
                        data: {target:'init_command'},
                        error: function (r, s, e) {
                            console.log({target:'init_command'});
                            console.log(e);
                        }
                    }).done(function (r) {
                        if(r['status'] === 'true'){
                            $('#panier_command_container .command .infos .phone input').val(r['tel']);
                            $('#panier_command_container .command .infos .address select.wilaya').append(r['wilayas']);
                            $('#panier_command_container .panier').hide('fast', function () {
                                $('#panier_command_container .command').show('slow');
                            });
                        }
                    })
                }
                else{
                    console.log('Veillez vous connecter !');
                }
            });
        });
    }

    this.main = function () {
        $('#panier_command_container').hide();
        this.add_to_panier();
        this.set_panier();
        this.set_btn_commander();
    }
}

console.log('PANIER');
let panier = new Panier();
panier.main();