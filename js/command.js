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

    this.set_command = function () {
        //EXIT
        $(document).on('click', '#panier_command_container .outer, #panier_command_container .command .exit', function () {
            $('#panier_command_container .command').hide('slow');
        })
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
            console.log(id_daira);
            const data_php = {target:'get_commune', id_daira:id_daira};
            command.hand_of_my_db(data_php).done(function (r) {
                if(r['status'] === 'true'){
                    $('#panier_command_container .command .infos .address select.commune').append(r['commune']).show('fast');
                }
            })
        });
    }

    this.main = function () {
        $('#panier_command_container div.command').hide();
        this.set_command();
    }
}

console.log('COMMAND');
let comm = new Command();
comm.main();

