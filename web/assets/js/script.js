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
	$(".logo").css("height", height);
	$(".logotipo").css("padding-top", "10%");

	/* CATEGORIAS */
	height = parseInt($("#home>footer>div").css("width"));
	height -= 20;
	$(".colorClass").css("height", height+"px");
}