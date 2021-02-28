function Command() {
    let command = this;

    // AJAX ----------------------------------------------------------------------------------------------
    this.hand_of_my_db = function (data) {
        return $.ajax({
            url: 'php_backend/controller/command.php',
            type: 'POST',
            dataType: 'json',
            data: data,
            error: function (r, s, e) {
                console.log(e);
            }
        })
    }

    // TRY TO DELETE
    this.check_if_panier_is_empty = function () {
        const t = $('#panier_command_container .panier .summary .tissue').is(':hidden');
        const c = $('#panier_command_container .panier .summary .clothes').is(':hidden');
        return !!(t && c);
    }

    // BUTTON COMMAND : IMPORTANT, A OPTIMISER ----------------------------------------------------------------------
    this.set_btn_commander = function () {
        $(document).on('click', '#panier_command_container .panier .btns .commander', function () {
            if(command.check_if_panier_is_empty()){
                $('#panier_command_container .panier .summary p').addClass('alert');
                setTimeout(function () {
                    $('#panier_command_container .panier .summary p').removeClass('alert');
                }, 3000);
                return null;
            }
            let data_php = {target:'check_if_user_is_connected'};
            command.hand_of_my_db(data_php).done(function (r) {
                if(r['status'] === 'true'){
                    console.log('Il y a un user !');
                    data_php = {target:'init_command'};
                    command.hand_of_my_db(data_php).done(function (r) {
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
                    console.log('Veuillez vous connecter !');
                    if($('#panier_command_container .alert_not_user').hasClass('alert_hide')){
                        $('#panier_command_container .alert_not_user').removeClass('alert_hide');
                    }
                    $('#panier_command_container .alert_not_user').addClass('alert_display');
                    $('#panier_command_container .panier').addClass('div_pause')
                    $(document).on('click', '#panier_command_container .alert_not_user .exit, #panier_command_container .outer, #panier_command_container .alert_not_user button', function () {
                        $('#panier_command_container .alert_not_user').removeClass('alert_not_user_display').addClass('alert_hide');
                        $('#panier_command_container .panier').removeClass('div_pause');
                    });
                    $(document).on('click', '#panier_command_container .alert_not_user button', function () {
                        $('#panier_command_container').hide('fast', function () {
                            $('#panier_command_container .panier .summary div table *, #panier_command_container .panier .summary p').remove();
                            $('#connexion').show('slow');
                        })
                    })
                }
            });
        });
    }

    this.set_command = function () {
        //EXIT
        $(document).on('click', '#panier_command_container .outer, #panier_command_container .command .exit', function () {
            $('#panier_command_container .command').hide('slow', function () {
                $('#panier_command_container .command .infos .address select *').remove();
                $('#panier_command_container .command .infos .address select.daira, #panier_command_container .command .infos .address select.commune').hide();
            });
        })
        //BUTTON BACK
        $(document).on('click', '#panier_command_container .command .btns .back', function () {
            $('#panier_command_container .command').hide('fast', function () {
                $('#panier_command_container .panier').show('slow');
                $('#panier_command_container .command .infos .address select *').remove();
                $('#panier_command_container .command .infos .address select.daira, #panier_command_container .command .infos .address select.commune').hide();
            })
        });
        //SELECT WILAYA
        $(document).on('change', '#panier_command_container .command .infos .address select.wilaya', function () {
            const id_wilaya = parseInt($('option:selected', this).val().split('-'));
            const data_php = {target:'get_daira', id_wilaya:id_wilaya};
            command.hand_of_my_db(data_php).done(function (r) {
                if(r['status'] === 'true'){
                    $('#panier_command_container .command .infos .address select.daira').append(r['daira']).show('fast');
                }
            })
        });
        //SELECT DAIRA
        $(document).on('change', '#panier_command_container .command .infos .address select.daira', function () {
            const id_daira = parseInt($('option:selected', this).val().split('-'));
            const data_php = {target:'get_commune', id_daira:id_daira};
            command.hand_of_my_db(data_php).done(function (r) {
                if(r['status'] === 'true'){
                    $('#panier_command_container .command .infos .address select.commune').append(r['commune']).show('fast');
                }
            })
        });
        //BUTTON VALID
        $(document).on('click', '#panier_command_container .command .btns .valid', function () {
            const id_commune = String($('#panier_command_container .command .infos .address select.commune').val()).split('-')[0];
            if(id_commune === 'null'){
                $('#panier_command_container .command .infos .address p').addClass('alert');
                setTimeout(function () {
                    $('#panier_command_container .command .infos .address p').removeClass('alert')
                }, 3000);
                return null;
            }
            const tel = $('#panier_command_container .command .infos .phone input').val();
            const dateObj = new Date();
            const date = String(dateObj.getFullYear() + '-' + parseInt(dateObj.getMonth() + 1) + '-' + dateObj.getDate());
            const time = String(dateObj.getHours() + ':' + dateObj.getMinutes() + ':' + dateObj.getSeconds());
            const data_php = {target:'valid_command', tel:tel, id_commune:id_commune, date:date, time:time};
            command.hand_of_my_db(data_php).done(function (r) {
                if(r['status'] === 'true'){
                    console.log('Votre commande a bien été passée !');
                    $('#panier_command_container .alert_command_validated').removeClass('alert_hide').addClass('alert_display');
                    $(document).on('click', '#panier_command_container .alert_command_validated .exit, #panier_command_container .outer', function () {
                        $('#panier_command_container .alert_command_validated').addClass('alert_hide').removeClass('alert_display');
                    })
                }
                else{
                    console.log('Il y a eu un problème lors de la validation de votre commande');
                }
            })
        });
    }

    this.main = function () {
        $('#panier_command_container div.command').hide();
        this.set_command();
        this.set_btn_commander();
    }
}

console.log('COMMAND');
let comm = new Command();
comm.main();

