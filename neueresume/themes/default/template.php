<!DOCTYPE html>
<html>
<head>

<meta charset="utf-8" />
	<meta name="format-detection" content="telephone=no">
	<title><?php echo $this->settings['bio']['name'];?> | <?php echo $this->settings['bio']['email'];?></title>
	<meta name="keywords" content="" />
	<meta name="description" content="Nick Walker's resume" />
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

</head>
<body>
	<div id="container">
		<header itemscope itemtype="http://schema.org/Person">
				<div class="plate">
					<h1 itemprop="name"><?php echo $this->settings['bio']['name'];?></h1>
					<h2 itemprop="jobTitle"><?php echo $this->settings['bio']['job_title'];?></h2>
				</div>
				<div class="right-plate">
					<div class="contact-info">
						<h3 id="print"><button onClick="window.print()">Print</button></h3>
						<h3><a itemprop="url" href="<?php echo $this->settings['bio']['site'];?>"><?php echo $this->settings['bio']['site'];?></a></h3>
						<h3><a itemprop="email" href="mailto:<?php echo $this->settings['bio']['email'];?>"><?php echo $this->settings['bio']['email'];?></a></h3>
						<h3 itemprop="telephone"><?php echo $this->settings['bio']['phone_number'];?></h3>
						<h4 itemprop="address" class="address"><?php echo $this->settings['bio']['street_address'];?></h4>
					</div>
					<ul id="social">
						<li><a href="http://www.facebook.com/nick.walker" data-tip="Facebook" id="facebook"></a></li>
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
			<h2 itemprop="name">{{Title}}</h2><a class="link button"href="{{Link}}"><a class="fancybox image button" href="{{ImagePath}}"></a>
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
					<p><?php echo $this->settings['bio']['name'];?> &mdash; <a href="mailto:<?php echo $this->settings['bio']['email'];?>"><?php echo $this->settings['bio']['email'];?></a> &mdash; <?php echo $this->settings['bio']['phone_number'];?></p>
				</footer>
			</div><!-- container -->
</body>
</html>