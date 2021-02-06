function Panier() {
    let panier = this;

    this.main = function () {
        $('#panier').hide();
    }
}
let panier = new Panier();
panier.main();