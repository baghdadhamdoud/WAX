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
                   $('#navBar').show();
                   $('#choice').hide();
                   $('#navBar #nav-tissue li.title').addClass('li_choose')
                   $('#container-products').append(tissues).show();
               }
            });
        });
        $(document).on('click', '#choice .clothes', function (e) {
            const php_data = {target:'get_clothes'};
            choice.hand_of_my_db(php_data).done(function (clothes) {
                $('#navBar').show();
                $('#choice').hide();
                $('#navBar #nav-clothes li.title').addClass('li_choose')
                $('#container-products').append(clothes).show();
            });
        });
    }
}
let choice = new Choice();
choice.main();