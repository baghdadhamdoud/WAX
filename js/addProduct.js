function AddProduct(){
    let addProduct = this;

    this.setBtnTissu = function(){
        let fd = new FormData();
        const img_tissue = $('#input-tissue')[0].files[0];
        fd.append('target', 'add_tissue');
        fd.append('img-tissue', img_tissue);
        fd.append('label', $('#add-label input').val());
        fd.append('price-tissue', $('#add-tissue-price input').val());
        return $.ajax({
            url: 'php_backend/controller/add_product.php',
            type: 'POST',
            dataType: 'JSON',
            data: fd,
            contentType: false,
            processData: false,
            error: function (r, s, e) {
                console.log(e);
                console.log(data);
            }
        }).done(function(result){
            if(result){
                alert('Tissu ajouté');
            }
            else{
                alert('Tissu non ajouté');
            }
        });
    }
    
    this.setBtnVetement = function(){
        let fd = new FormData();
        const img_clothes = $('#input-clothes')[0].files[0];
        fd.append('target', 'add_clothes');
        fd.append('img-clothes', img_clothes);
        fd.append('label', $('#add-label input').val());
        fd.append('price-clothes', $('#add-clothes-price input').val());
        fd.append('sexe', $('#add-clothes-sexe select').val());
        fd.append('type', $('#add-clothes-type select').val());
        fd.append('article', $('#add-clothes-article input').val());
        fd.append('taille', $('#add-clothes-taille input').val());
        return $.ajax({
            url: 'php_backend/controller/add_product.php',
            type: 'POST',
            dataType: 'JSON',
            data: fd,
            contentType: false,
            processData: false,
            error: function (r, s, e) {
                console.log(e);
                console.log(data);
            }
        }).done(function(result){
            if(result){
                alert('Vêtement ajouté');
            }
            else{
                alert('Vêtement non ajouté');
            }
        });
    }

    this.main = function(){

    }
}
let addProduct = new AddProduct();
addProduct.main();