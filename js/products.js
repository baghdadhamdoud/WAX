function Products() {
    let products = this;

    // AJAX ----------------------------------------------------------------------------------------------
    this.hand_of_my_db = function (data) {
        return $.ajax({
            url: 'php_backend/controller/display_product.php',
            type: 'POST',
            dataType: 'json',
            data: data,
            error: function (r, s, e) {
                console.log(e);
            }
        })
    }

    this.set_product = function () {
        $('#main .display').hide();
        $(document).on('click', '#main #container-products .product', function (e) {
            const id_product = $(e.target).find('.desc .id').text();
            const data_php = {target:'get_product_by_id', id:id_product};
            $('#main .display').show('slow');
            console.log('bb');
            // products.hand_of_my_db(data_php).done(function (product, status) {
            //     console.log('produit chargé');
            //     $('#main .display').show('slow');
            // })
        })

        $(document).on('click', '#main .display .product .exit, #main .display .outer', function () {
            $('#main .display').hide('slow');
        })
    }

    this.main = function () {
        $('#container-products').hide();
        this.set_product();
    }
}
let products = new Products();
products.main();