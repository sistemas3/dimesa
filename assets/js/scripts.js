$(function(){

	/* Busqueda */

	// Variables
	var btn_buscador = $('a.busqueda');
	var div_busqueda = $('#busqueda');
	var form_busqueda = $('#busqueda form');
	var btn_cerrar = $('#busqueda .btn-cerrar');
	var campo_busqueda = $('#busqueda .form-control');
	var menu_seccion = $('#menu-seccion');

	// Mostrar buscador
	btn_buscador.click(function(e){
		e.preventDefault();
		$(this).addClass('hidden');
		div_busqueda.toggleClass('hidden');
		form_busqueda.fadeIn(200);
		if( menu_seccion.length > 0 ){
			div_busqueda.addClass('busqueda-interior')
		}
	});

	// Ocultar buscador 
	btn_cerrar.click(function(e){
		btn_buscador.removeClass('hidden');
		div_busqueda.toggleClass('hidden');	
		form_busqueda.fadeOut(200);
		campo_busqueda.val();
	});

	/* Menu */

	// Variables
    var menu = $("#menu-principal");
    var menu_pos = $("#menu-principal").position();
    //var logo_fijo = $('a.logo-tv-azteca-noreste-fijo');

    // Fijar menu
	$(window).scroll(function() {
		if ($(window).scrollTop() > menu_pos.top){
			menu.addClass('fijo');
			//logo_fijo.fadeIn(150);
		}else{
			menu.removeClass('fijo');
			//logo_fijo.fadeOut(150);
		}
	});

});