function Products() {
    let products = this;

    // AJAX ----------------------------------------------------------------------------------------------
    this.hand_of_my_db = function (data) {
        return $.ajax({
            url: 'php_backend/controller/display_product.php',
            type: 'POST',
            dataType: 'html',
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
            const tissue_or_clothes = $(e.target).find('.desc .tissue_or_clothes').text();
            const data_php = {target:'display_product', id:id_product, tissue_or_clothes:tissue_or_clothes};
            products.hand_of_my_db(data_php).done(function (product, status) {
                $('#main .display .product').append(product);
                $('#main .display').show('slow');
            })
        })

        $(document).on('click', '#main .display .product .exit, #main .display .outer', function () {
            $('#main .display .product img, #main .display .product .desc').remove();
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