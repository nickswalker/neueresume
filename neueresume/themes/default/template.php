<!DOCTYPE html>
<html>
<head>

<meta charset="utf-8" />
	<meta name="format-detection" content="telephone=no">
	<title><?php echo $this->vars['bio']['name'];?> | <?php echo $this->vars['bio']['email'];?></title>
	<meta name="keywords" content="" />
	<meta name="description" content="<?php echo $this->vars['bio']['name'];?>'s resume." />
	<link rel="stylesheet"  href="<?php $this->showThemeURL();?>resume.css" media="all" />


<link rel="stylesheet" href="neueresume/scripts/fancybox/jquery.fancybox.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script src="neueresume/scripts/fancybox/jquery.fancybox.js"></script>


<script type="text/javascript">
	$(document).ready(function() {
		$('.fancybox').fancybox({
			padding : 0,
			openEffect: 'fade',
			closeEffect: 'fade',
			prevEffect: 'fade',
			nextEffect: 'fade',
			loop: false,
			closeBtn: false,
			helpers : {
   	title : null
}
		});
	});
</script>
<script type="text/javascript">
$(document).ready(function() {
	var $returnMessage = $('.return-message').hide(),
	$form = $('form');
	$('.submit').on('click', function(event){
		sendEmail();
		event.preventDefault();
	});
function handleReturn(returnedObject){
		$form.fadeOut(200, function(){

		switch(returnedObject){
			case 'sent':
			$returnMessage.append('<span class="icon-ok"></span>');
				break;
			case 'failed':
				$returnMessage.append('<span class="icon-remove"></span><span class="message">Sorry, the message can\'t seem to get through. <a href="mailto:<?php echo $this->vars['bio']['email'];?>">Try using your client?</a></span>');
				break;
			default :
				$returnMessage.append('<span class="icon-remove"></span><span class="message">'+returnedObject+'</span>');
			break;
	}
		$returnMessage.fadeIn(200);
		});

		$('.return-message').on('click', function(){

			$(this).fadeOut(200, function(){
			$(this).children().remove();
						$form.fadeIn(200);
			});

		});
}
	function sendEmail(){
		var emailid = $form.children('.email').val(),
		tempname = $form.children('.name').val(),
		tempmessage = $form.children('.message').val(),
	 data = { email: emailid,
			name : tempname,
			message : tempmessage
	};
		$.ajax({
	type: "POST",
	url: "index.php",
	data: data,
	dataType: "text",
	success: function(returnedObject){
		console.log(returnedObject);
		handleReturn(returnedObject);
	}
	});
}
});
</script>
</head>
<body>
	<div id="container">
		<header itemscope itemtype="http://schema.org/Person">
				<div class="plate">
					<h1 itemprop="name"><?php echo $this->vars['bio']['name'];?></h1>
					<h2 itemprop="jobTitle"><?php echo $this->vars['bio']['job-title'];?></h2>
				</div>
				<div class="right-plate">
					<div class="contact-info">
						<h3 id="print"><button onClick="window.print()">Print</button></h3>
						<h3><a itemprop="url" href="<?php echo $this->vars['bio']['site'];?>"><?php echo $this->vars['bio']['site'];?></a></h3>
						<h3><a itemprop="email" href="mailto:<?php echo $this->vars['bio']['email'];?>"><?php echo $this->vars['bio']['email'];?></a></h3>
						<h3 itemprop="telephone"><?php echo $this->vars['bio']['phone-number'];?></h3>
						<h4 itemprop="address" class="address"><?php echo $this->vars['bio']['street-address'];?></h4>
					</div>
					<ul id="social">
						<?php
							if( $this->vars['bio']['social']['linkedin'] != '' ){ echo '<li><a href="'.$this->vars['bio']['social']['linkedin'].'" class="icon-linkedin"></a></li>';}
							if( $this->vars['bio']['social']['github'] != '' ){ echo '<li><a href="'.$this->vars['bio']['social']['github'].'" class="icon-github"></a></li>';}
							if( $this->vars['bio']['social']['vimeo'] != '' ){ echo '<li><a href="'.$this->vars['bio']['social']['vimeo'].'" class="icon-vimeo"></a></li>';}
							if( $this->vars['bio']['social']['tumblr'] != '' ){ echo '<li><a href="'.$this->vars['bio']['social']['tumblr'].'" class="icon-tumblr"></a></li>';}
							if( $this->vars['bio']['social']['google-plus'] != '' ){ echo '<li><a href="'.$this->vars['bio']['social']['google-plus'].'" class="icon-googleplus"></a></li>';}
							if( $this->vars['bio']['social']['facebook'] != '' ){ echo '<li><a href="'.$this->vars['bio']['social']['facebook'].'" class="icon-facebook"></a></li>';}
							if( $this->vars['bio']['social']['twitter'] != '' ){ echo '<li><a href="'.$this->vars['bio']['social']['twitter'].'" class="icon-twitter"></a></li>';}

?>
					</ul>
				</div>
		</header>

		<?php
$sectionFormat = '
		<section class="{{Type}}">
				<div class="left">
					<h2>{{Title}}</h2>
				</div>

				<div class="right">
				{{SectionContent}}
				</div>
		</section>
				';
$textFormat = '
		<span class="mission">{{Text}}</span>
				';

$listItemFormat = '

		<li itemprop="itemListElement">{{Text}}</li>

		';
$detailListItemFormat = '

		<article>
			<h2>{{Title}}</h2>
			<h3>{{SubTitle}}</h3>
			<h4>{{Date}}</h4>
			<p>{{Text}}</p>
		</article>

		';
$jobsListItemFormat = '

		<article itemscope itemtype="http://schema.org/CreativeWork">
			<h2 itemprop="name">{{Title}}</h2><a class="icon-link .btn button"href="{{Link}}"><a class="icon-picture .btn fancybox button" href="{{ImagePath}}"></a>
			<h3 itemprop="genre">{{SubTitle}}</h3>
			<h4>{{Date}}</h4>
			<p itemprop="description">{{Text}}</p>
		</article>

		';

$this->showResume($sectionFormat, $textFormat, $jobsListItemFormat, $listItemFormat, $detailListItemFormat);

$contactFormFormat = '
		<section class="contact">
				<div class="left">
					<h2>Contact</h2>
				</div>

				<div class="right">
				{{ContactForm}}
				</div>
		</section>
				';

$this->showContactForm($contactFormFormat);
?>


				<footer>
					<p><?php echo $this->vars['bio']['name'];?> &mdash; <a href="mailto:<?php echo $this->vars['bio']['email'];?>"><?php echo $this->vars['bio']['email'];?></a> &mdash; <?php echo $this->vars['bio']['phone-number'];?></p>
				</footer>
			</div><!-- container -->
</body>
</html>