<section id="home" class="container text-center">
	<img src="./Resource/imgs/habeats-logo.png" alt="">
</section>
<section id="socialmedia" class="container">
	<div class="col-md-12">
		<div class="col-md-5 col-sm-5 col-xs-4 text-right">
			<a href="https://www.facebook.com/habeats">
				<img src="./Resource/imgs/icon_facebook.png">
			</a>
		</div>
		<div class="col-md-2 col-sm-2 col-xs-4 text-center">
			<a href="https://instagram.com/habeats">
				<img src="./Resource/imgs/icon_instagram.png">
			</a>
		</div>
		<div class="col-md-5 col-sm-5 col-xs-4 text-left">
			<a href="https://twitter.com/habeats">
				<img src="./Resource/imgs/icon_twitter.png">
			</a>
		</div>
	</div>
</section>
<script>
	$(function(){
		setTimeout(function(){
			var img_height 	= $('#home > img').height();
			var myheight 	= ($(window).height() / 2) - img_height;
			$('#home > img').css('padding-top', myheight);
			console.log('img_height', img_height);
			console.log('myheight', myheight);
			console.log('img_css', $('#home > img').css('padding-top'));
		}, 500);
	});
</script>