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
<?php 
if( file_exists($this->showThemeURL(1).'custom-style.css') ){
	echo ('<link rel="stylesheet" href="'.$this->showThemeURL(1).'custom-style.css">');
}?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script src="neueresume/scripts/fancybox/jquery.fancybox.js"></script>
<script>
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
		(function() {
			if (Contact) {
				var email = $('a[itemprop=email]').text(),
				returnMessage = $('.return-message').hide(),
				form = $('form');
				var contact = new Contact ( email, form, returnMessage );
					$('.submit').on('click', function(event){
						contact.sendEmail();
						event.preventDefault();
					});

			}})();
	});
</script>
</script>

<script src="<?php $this->showThemeURL();?>contact.js"></script>
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
						<h3><a itemprop="url" href="http://<?php echo $this->vars['bio']['site'];?>"><?php echo $this->vars['bio']['site'];?></a></h3>
						<h3><a itemprop="email" href="mailto:<?php echo $this->vars['bio']['email'];?>"><?php echo $this->vars['bio']['email'];?></a></h3>
						<h3 itemprop="telephone"><?php echo $this->vars['bio']['phone-number'];?></h3>
						<h4 itemprop="address" class="address"><?php echo $this->vars['bio']['street-address'];?></h4>
					</div>
					<ul id="social">
						<?php
							foreach ( $this->vars['bio']['social'][0] as $name=>$value ){
								if( $value != '' ){
									echo '<li><a href="'.$value.'" class="icon-'.$name.'"></a></li>';
								}
							}
?>
					</ul>
				</div>
		</header>

		<?php
$sectionFormat = '
		<section class="{{Type}} {{Title}}">
				<div class="left">
					<h2>{{Title}}</h2>
				</div>

				<div class="right">
				{{SectionContent}}
				</div>
		</section>
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

$this->showResume($sectionFormat, $jobsListItemFormat, $listItemFormat, $detailListItemFormat);

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
			</div>
</body>
</html>