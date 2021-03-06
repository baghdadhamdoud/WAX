function NavBar() {
    let navBar = this;
	
	this.hand_of_my_db = function (data) {
        return $.ajax({
            url: 'php_backend/controller/nav_Bar.php',
            type: 'POST',
            dataType: 'html',
            data: data,
            error: function (r, s, e) {
                console.log(e);
            }
        })
    }
	
	this.set_types_of_clothes = function(){
		const data_php = {target: 'get_types_nqv_bar'};
		this.hand_of_my_db(data_php).done(function(types, success){
			if(success === 'success'){
				$('#navBar #nav-clothes-types').append(types).hide();
			}
		});
	}

	this.set_navBar_onclick = function () {
		$(document).on('click', '#navBar #nav-tissue', function (e) {
			$('#navBar *.li_choose').removeClass('li_choose');
			$('#navBar #nav-clothes #nav-clothes-types').hide();
			$(e.target).addClass('li_choose');
			const data_php = {target:'get_tissues_nav_bar'};
			navBar.hand_of_my_db(data_php).done(function (tissues) {
				$('#container-products').hide('fast', function(){
					$('#container-products .product').remove();
					$('#container-products').append(tissues).show('fast');
				});
			});
		});
		$(document).on('click', '#navBar #nav-clothes #nav-clothes-sexe li', function (e) {
			$('#navBar *.li_choose').removeClass('li_choose');
			$('#navBar #nav-clothes li.title').addClass('li_choose');
			$(e.target).addClass('li_choose');
			$('#navBar #nav-clothes #nav-clothes-types').show();
			const sexe = $(e.target).text();
			const data_php = {target:'get_clothes_nav_bar', sexe: sexe};
			navBar.hand_of_my_db(data_php).done(function (clothes) {
				$('#container-products').hide('fast', function(){
					$('#container-products .product').remove();
					$('#container-products').append(clothes).show('fast');
				});
			});
		});
		$(document).on('click', '#navBar #nav-clothes #nav-clothes-types li', function (e) {
			$('#navBar #nav-clothes #nav-clothes-types .li_choose').removeClass('li_choose');
			$(e.target).addClass('li_choose');
			const sexe = $('#navBar #nav-clothes #nav-clothes-sexe .li_choose').text();
			const type = $(e.target).text();
			const data_php = {target:'get_clothes_nav_bar', sexe: sexe, type: type};
			navBar.hand_of_my_db(data_php).done(function (clothes) {
				$('#container-products').hide('fast', function(){
					$('#container-products .product').remove();
					$('#container-products').append(clothes).show('fast');
				});
			});
		});
	}

    this.main = function () {
		this.set_types_of_clothes();
		this.set_navBar_onclick();
		$('#navBar').hide();
			$(document).on('click', '#navBar .btn', function(){
				if(!$('#navBar').hasClass('navBar_show')){
					$('#navBar').addClass('navBar_show');
				}
				else{
					$('#navBar').removeClass('navBar_show');
				}
				if(!$('#navBar .btn').hasClass('rotate_arrow')){
					$('#navBar .btn').addClass('rotate_arrow');
				}
				else {
					$('#navBar .btn').removeClass('rotate_arrow');
				}
			});
    }
}
let navBar = new NavBar();
navBar.main();