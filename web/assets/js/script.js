$( document ).ready(function() {
	'use-strict';

	setTimeout(function(){
		inicio();
	}, 300);

	$(window).on('resize', function(){
	    inicio();
	});

	$("#slide1 > .buttonPrev").click(function(e){
		e.preventDefault();
		alert("Click Prev");
	});

	$("#slide1 > .buttonNext").click(function(e){
		e.preventDefault();
		alert("Click Next");
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