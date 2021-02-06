function Products() {
    let products = this;

    this.main = function () {
        $('#container-products *').hide();
    }
}
window.onload = function () {
    let products = new Products();
    products.main();
}