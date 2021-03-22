function Choice() {
    let choice = this;

    // AJAX ----------------------------------------------------------------------------------------------
    this.hand_of_my_db = function (data) {
        return $.ajax({
            url: 'php_backend/controller/choice.php',
            type: 'POST',
            dataType: 'html',
            data: data,
            error: function (r, s, e) {
                console.log(e);
            }
        })
    }

    this.main = function () {
        $(document).on('click', '#choice .tissue', function (e) {
            const php_data = {target:'get_tissues'};
            choice.hand_of_my_db(php_data).done(function (tissues, success) {
               if(success === 'success'){
                $('#container-products').append(tissues).show('fast', function(){
                    $('#navBar').show('fast');
                    $('#choice').hide('slow');
                    $('#navBar #nav-tissue li.title').addClass('li_choose')
                });
               }
            });
        });
        $(document).on('click', '#choice .clothes', function (e) {
            const php_data = {target:'get_clothes'};
            choice.hand_of_my_db(php_data).done(function (clothes) {
                $('#container-products').append(clothes).show('fast', function () { 
                    $('#choice').hide('fast');
                    $('#navBar').show('fast');
                    $('#navBar #nav-clothes li.title').addClass('li_choose')
                });
                
            });
        });
    }
}
let choice = new Choice();
choice.main();