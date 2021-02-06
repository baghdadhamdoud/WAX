function Connexion() {
    let connexion = this;

    // AJAX ----------------------------------------------------------------------------------------------
    this.hand_of_my_db = function (data) {
        return $.ajax({
            url: 'php_backend/controller/connexion.php',
            type: 'POST',
            dataType: 'json',
            data: data,
            error: function (r, s, e) {
                console.log(e);
            }
        })
    }

    this.check_nickname_input = function () {
        const nick = $('#connexion .main .username input').val();
        if(nick === ''){
            $('#connexion .main .username .alert').text('Veuillez entrer votre Nom d\'Utilisateur').show('slow');
            setTimeout(function () {
                $('#connexion .main .username .alert').hide();
            }, 5000);
            return false;
        }
        else {
            return nick;
        }
    }
    this.check_password_input = function () {
        const pass = $('#connexion .main .password input').val();
        if(pass === ''){
            $('#connexion .main .password .alert').text('Veuillez entrer votre Mot de Passe').show('slow');
            setTimeout(function () {
                $('#connexion .main .password .alert').hide();
            }, 5000);
            return false;
        }
        else {
            return pass;
        }
    }

    this.set_connexion = function () {
        $(document).on('click', '#topBar .connexion_inscription .connexion', function () {
            $('#connexion').show('slow');
        })
        $(document).on('click', '#connexion .main .exit, #connexion .outer', function () {
            $('#connexion').hide('slow');
        })
        function btn_valid_connexion(){
            const nick = connexion.check_nickname_input();
            const pass = connexion.check_password_input();
            if(nick !== false && pass !== false){
                const data_php = {target:'connexion_treatment', username:nick, password:pass};
                connexion.hand_of_my_db(data_php).done(function (user, status) {
                    if(user['status'] === 'false'){
                        alert(user['response']);
                    }
                    else{
                        $('#topBar .welcome').text('Bienvenue '+user['nom'].toUpperCase()+' '+user['prenom']).show();
                        $('#topBar .deconnexion').show();
                        $('#connexion, #topBar .connexion_inscription').hide();
                    }
                });
            }
        }
        $(document).on('click', '#connexion .main .btn_valid', function () {
            btn_valid_connexion();
        })
        $(document).on('keyup', function(e) {
            if(e.key === 'Enter'){
                btn_valid_connexion();
            }
        });
    }

    this.set_deconnexion = function () {
        $(document).on('click', '#topBar .deconnexion', function () {
            const data_php = {target: 'deconnexion'};
            connexion.hand_of_my_db(data_php).done(function (result) {
                if(result['status'] === 'true'){
                    $('#topBar .welcome, #topBar .deconnexion').hide();
                    $('#topBar .connexion_inscription').show();
                }
            })
        })
    }

    this.set_init_page = function () {
        const data_php = {target: 'get_user_session'};
        topBar.hand_of_my_db(data_php).done(function (user, status) {
            if(user['status'] === 'true'){
                $('#topBar .welcome').text('Bienvenue '+user['nom'].toUpperCase()+' '+user['prenom']).show();
                $('#topBar .deconnexion').show();
                $('#connexion, #topBar .connexion_inscription').hide();
            }
        });
    }

    this.main = function () {
        $('#connexion').hide();
        this.set_connexion();
        this.set_deconnexion();
        this.set_init_page();
    }
}
let conn = new Connexion();
conn.main();