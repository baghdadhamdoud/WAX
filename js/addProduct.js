function AddProduct(){
    let addProduct = this;

    // AJAX ----------------------------------------------------------------------------------------------
    this.hand_of_my_db = function (data) {
        return $.ajax({
            url: 'php_backend/controller/add_product.php',
            type: 'POST',
            dataType: 'json',
            data: data,
            contentType: false,
            processData: false,
            error: function (r, s, e) {
                console.log(e);
            }
        })
    }

    this.setBtnTissu = function(){
        $(document).on('click', '#add-product #add-tissue-clothes #add-tissue button', function(){
            let fd = new FormData();
            fd.append('target', 'add_tissue');
            const img_tissue = $('#input-tissue')[0].files[0];
            if(img_tissue === undefined){
                console.log('image_tissue undefined');
                return null;
            }
            fd.append('img-tissue', img_tissue);
            const label = $('#add-label input').val();
            if(label === ''){
                console.log('label empty');
                return null;
            }
            fd.append('label', label);
            const price_tissue = $('#add-tissue-price input').val();
            if(price_tissue === ''){
                console.log('price_tissue empty');
                return null;
            }
            fd.append('price_tissue', price_tissue);
            const stocke_surface = $('#add-tissue-stoke input').val();
            if(stocke_surface === ''){
                console.log('stoke_surface empty');
                return null;
            }
            fd.append('stoke_surface', stoke_surface);
            addProduct.hand_of_my_db(fd).done(function(result){
                if(result['status'] === 'true'){
                    alert('Tissu ajouté');
                }
                else{
                    alert('Tissu non ajouté');
                }
            });
        });
    }
    
    this.setBtnVetement = function(){
        $(document).on('click', '#add-product #add-tissue-clothes #add-clothes button', function(){
            let fd = new FormData();
            fd.append('target', 'add_clothe');
            const img_clothes = $('#input-clothes')[0].files[0];
            if(img_clothes === undefined){
                console.log('img_clothes undefined');
                return null;
            }
            fd.append('img-clothes', img_clothes);
            const label = $('#add-label input').val();
            if(label === ''){
                console.log('label empty');
                return null;
            }
            fd.append('label', label);
            const price_clothes = $('#add-clothes-price input').val();
            if(price_clothes === ''){
                console.log('price_clothes empty');
                return null;
            }
            fd.append('price-clothes', price_clothes);
            const sexe = $('#add-clothes-sexe select').val();
            if(sexe === ''){
                console.log('sexe empty');
                return null;
            }
            fd.append('sexe', sexe);
            const type_clothes =  $('#add-clothes-type select').val();
            if(type_clothes === ''){
                console.log('type_clothes empty');
                return null;
            }
            fd.append('type', type_clothes);
            const article = $('#add-clothes-article input').val();
            if(article === ''){
                console.log('article empty');
                return null;
            }
            fd.append('article', article);
            const taille = $('#add-clothes-taille input').val();
            if(taille === ''){
                console.log('taille empty');
                return null;
            }
            fd.append('taille', taille);
            addProduct.hand_of_my_db(fd).done(function(result){
                if(result['status'] === 'true'){
                    alert('Vêtement ajouté');
                }
                else{
                    alert('Vêtement non ajouté');
                }
            });
        });
    }

    this.main = function(){
        this.setBtnTissu();
        this.setBtnVetement();
    }
}
let addProduct = new AddProduct();
addProduct.main();