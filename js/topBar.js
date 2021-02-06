function TopBar() {
    let topBar = this;

    // AJAX ----------------------------------------------------------------------------------------------
    this.hand_of_my_db = function (data) {
        return $.ajax({
            url: 'php_backend/controller/connexion.php',
            type: 'POST',
            dataType: 'json',
            data: data,
            error: function (r, s, e) {
                console.log();
            }
        })
    }

    this.main = function () {
		$(document).on('click', '#topBar .wax-page', function(e){
			window.location.href = 'index.php';
		});
    }
}
let topBar = new TopBar();
topBar.main();
