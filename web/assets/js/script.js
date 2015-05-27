$( document ).ready(function() {
	'use-strict';

	setTimeout(function(){
		inicio();
	}, 300);

	$(window).on('resize', function(){
	    inicio();
	});
});

function inicio(){
	/* INICIO */
	var height = $(window).height();

	/* CATEGORIAS */
	height = parseInt($("#home>footer>div").css("width"));
	height -= 80;
	$(".colorClass").css("height", height+"px");
}